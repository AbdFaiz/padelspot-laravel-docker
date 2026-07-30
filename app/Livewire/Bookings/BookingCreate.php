<?php

namespace App\Livewire\Bookings;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\Court;
use App\Models\CourtSchedule;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BookingCreate extends Component
{
    public int $courtId;

    public string $bookingDate = '';

    public array $selectedSlots = [];

    public string $notes = '';

    public function mount(): void
    {
        $this->courtId = (int) request()->query('court', 0);
        $this->bookingDate = now()->toDateString();
    }

    public function updatedBookingDate(): void
    {
        $this->selectedSlots = [];
    }

    public function toggleSlot(int $slotId): void
    {
        if (in_array($slotId, $this->selectedSlots)) {
            $this->selectedSlots = array_values(array_diff($this->selectedSlots, [$slotId]));
        } else {
            $this->selectedSlots[] = $slotId;
            $this->selectedSlots = array_unique($this->selectedSlots);
            sort($this->selectedSlots);
        }
    }

    public function getTotalPriceProperty(): float
    {
        $court = Court::find($this->courtId);

        return $court ? $court->price_per_hour * count($this->selectedSlots) : 0;
    }

    public function getSlotOrderValidProperty(): bool
    {
        if (count($this->selectedSlots) <= 1) {
            return true;
        }

        $sorted = $this->selectedSlots;
        sort($sorted);

        $allSlots = TimeSlot::whereIn('id', $sorted)->orderBy('start_time')->get();

        if ($allSlots->count() !== count($sorted)) {
            return false;
        }

        for ($i = 1; $i < $allSlots->count(); $i++) {
            if ($allSlots[$i]->start_time !== $allSlots[$i - 1]->end_time) {
                return false;
            }
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'courtId' => 'required|exists:courts,id',
            'bookingDate' => 'required|date|after_or_equal:today',
            'selectedSlots' => 'required|array|min:1',
            'selectedSlots.*' => 'exists:time_slots,id',
        ];
    }

    public function store(): void
    {
        $this->validate();

        if (! $this->slotOrderValid) {
            session()->flash('error', 'Slot yang dipilih harus berurutan tanpa jeda.');
            return;
        }

        $schedule = $this->getScheduleForDate();

        if (! $schedule || ! $schedule->is_active) {
            session()->flash('error', 'Lapangan tidak beroperasi pada hari ini.');
            return;
        }

        $slots = TimeSlot::whereIn('id', $this->selectedSlots)->get();

        foreach ($slots as $slot) {
            if ($slot->start_time < $schedule->open_time || $slot->end_time > $schedule->close_time) {
                session()->flash('error', 'Slot '.$slot->label.' di luar jam operasional ('.$schedule->open_time.' - '.$schedule->close_time.').');
                return;
            }
        }

        $existingSlotIds = DB::table('booking_time_slot')
            ->join('bookings', 'booking_time_slot.booking_id', '=', 'bookings.id')
            ->where('bookings.court_id', $this->courtId)
            ->where('bookings.booking_date', $this->bookingDate)
            ->whereIn('booking_time_slot.time_slot_id', $this->selectedSlots)
            ->whereIn('bookings.status', [BookingStatus::Pending, BookingStatus::Confirmed])
            ->pluck('booking_time_slot.time_slot_id')
            ->toArray();

        if (count($existingSlotIds) > 0) {
            $bookedSlots = TimeSlot::whereIn('id', $existingSlotIds)->pluck('label')->implode(', ');
            session()->flash('error', 'Slot berikut sudah dipesan: '.$bookedSlots.'. Silakan pilih slot lain.');
            return;
        }

        $court = Court::findOrFail($this->courtId);

        $booking = DB::transaction(function () use ($court, $slots) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'court_id' => $this->courtId,
                'booking_date' => $this->bookingDate,
                'status' => BookingStatus::Pending,
                'total_price' => $court->price_per_hour * count($slots),
                'notes' => $this->notes ?: null,
            ]);

            $pivotData = [];
            foreach ($slots as $slot) {
                $pivotData[] = [
                    'booking_id' => $booking->id,
                    'time_slot_id' => $slot->id,
                    'price' => $court->price_per_hour,
                ];
            }
            DB::table('booking_time_slot')->insert($pivotData);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'old_status' => '-',
                'new_status' => BookingStatus::Pending->value,
                'notes' => 'Booking dibuat oleh pelanggan.',
            ]);

            return $booking;
        });

        $total = number_format($this->totalPrice, 0, ',', '.');
        session()->flash('success', "Booking berhasil dibuat! Total: Rp {$total}. Silakan lakukan pembayaran.");

        $this->redirect(route('bookings.show', $booking->id));
    }

    private function getScheduleForDate(): ?CourtSchedule
    {
        $dayName = strtolower(Carbon::parse($this->bookingDate)->format('l'));

        return CourtSchedule::where('court_id', $this->courtId)
            ->where('day', $dayName)
            ->first();
    }

    public function render()
    {
        $court = Court::find($this->courtId);
        $timeSlots = TimeSlot::all()->sortBy('start_time')->values();
        $maxDate = now()->addDays(14)->toDateString();

        $bookedSlotIds = DB::table('booking_time_slot')
            ->join('bookings', 'booking_time_slot.booking_id', '=', 'bookings.id')
            ->where('bookings.court_id', $this->courtId)
            ->where('bookings.booking_date', $this->bookingDate)
            ->whereIn('bookings.status', [BookingStatus::Pending, BookingStatus::Confirmed])
            ->pluck('booking_time_slot.time_slot_id')
            ->toArray();

        $schedule = $this->getScheduleForDate();
        $isOperatingDay = $schedule && $schedule->is_active;

        $unavailableSlotIds = [];
        if ($court && $isOperatingDay) {
            foreach ($timeSlots as $slot) {
                if ($slot->start_time < $schedule->open_time || $slot->end_time > $schedule->close_time) {
                    $unavailableSlotIds[] = $slot->id;
                }
            }
        } elseif ($court && ! $isOperatingDay) {
            $unavailableSlotIds = $timeSlots->pluck('id')->toArray();
        }

        $courtSchedule = $isOperatingDay ? [
            'open_time' => $schedule->open_time,
            'close_time' => $schedule->close_time,
        ] : null;

        return view('livewire.bookings.booking-create', compact(
            'court', 'timeSlots', 'maxDate', 'bookedSlotIds', 'unavailableSlotIds', 'courtSchedule'
        ))->layout('components.layouts.app', ['title' => 'Buat Booking - PadelSpot']);
    }
}
