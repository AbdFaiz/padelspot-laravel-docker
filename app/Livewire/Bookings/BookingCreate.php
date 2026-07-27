<?php

namespace App\Livewire\Bookings;

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

    public string $viewMode = 'grid';

    public string $calendarWeekStart = '';

    private ?array $calendarData = null;

    public function mount(): void
    {
        $this->courtId = request()->query('court', 0);
        $this->bookingDate = now()->toDateString();
        $this->calendarWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
    }

    public function updatedBookingDate(): void
    {
        $this->selectedSlots = [];
    }

    public function toggleView(): void
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'calendar' : 'grid';
    }

    public function nextWeek(): void
    {
        $this->calendarWeekStart = Carbon::parse($this->calendarWeekStart)->addWeek()->toDateString();
    }

    public function prevWeek(): void
    {
        $this->calendarWeekStart = Carbon::parse($this->calendarWeekStart)->subWeek()->toDateString();
    }

    public function goToToday(): void
    {
        $this->calendarWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $this->bookingDate = now()->toDateString();
    }

    public function selectCalendarSlot(string $date, int $slotId): void
    {
        $this->bookingDate = $date;
        $this->toggleSlot($slotId);
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

    public function getSelectedSlotsProperty(): array
    {
        return $this->selectedSlots;
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

        $existingBookings = Booking::where('court_id', $this->courtId)
            ->where('booking_date', $this->bookingDate)
            ->whereIn('time_slot_id', $this->selectedSlots)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time_slot_id')
            ->toArray();

        if (count($existingBookings) > 0) {
            $bookedSlots = TimeSlot::whereIn('id', $existingBookings)->pluck('label')->implode(', ');
            session()->flash('error', 'Slot berikut sudah dipesan: '.$bookedSlots.'. Silakan pilih slot lain.');

            return;
        }

        $court = Court::findOrFail($this->courtId);

        DB::transaction(function () use ($court, $slots) {
            foreach ($slots as $slot) {
                $booking = Booking::create([
                    'user_id' => Auth::id(),
                    'court_id' => $this->courtId,
                    'time_slot_id' => $slot->id,
                    'booking_date' => $this->bookingDate,
                    'status' => 'pending',
                    'total_price' => $court->price_per_hour,
                    'notes' => $this->notes ?: null,
                ]);

                BookingStatusLog::create([
                    'booking_id' => $booking->id,
                    'old_status' => '-',
                    'new_status' => 'pending',
                    'notes' => 'Booking dibuat oleh pelanggan.',
                ]);
            }
        });

        $count = count($slots);
        $total = number_format($this->totalPrice, 0, ',', '.');
        session()->flash('success', "{$count} booking berhasil dibuat! Total: Rp {$total}. Silakan lakukan pembayaran.");

        $this->redirect(route('bookings.index'));
    }

    private function getScheduleForDate(): ?CourtSchedule
    {
        $dayName = Carbon::parse($this->bookingDate)->translatedFormat('l');

        $dayMap = [
            'Senin' => 'monday',
            'Selasa' => 'tuesday',
            'Rabu' => 'wednesday',
            'Kamis' => 'thursday',
            'Jumat' => 'friday',
            'Sabtu' => 'saturday',
            'Minggu' => 'sunday',
        ];

        $dayKey = $dayMap[$dayName] ?? strtolower($dayName);

        return CourtSchedule::where('court_id', $this->courtId)
            ->where('day', $dayKey)
            ->first();
    }

    private function getCalendarData(): array
    {
        if ($this->calendarData !== null) {
            return $this->calendarData;
        }

        $court = Court::find($this->courtId);
        if (! $court) {
            return $this->calendarData = [];
        }

        $timeSlots = TimeSlot::all()->sortBy('start_time')->values();
        $weekStart = Carbon::parse($this->calendarWeekStart);
        $maxDate = Carbon::now()->addDays(14);

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $dateStr = $date->toDateString();

            if ($date->lt(now()->startOfDay()) || $date->gt($maxDate)) {
                continue;
            }

            $dayMap = [
                1 => 'monday', 2 => 'tuesday', 3 => 'wednesday',
                4 => 'thursday', 5 => 'friday', 6 => 'saturday', 7 => 'sunday',
            ];
            $schedule = CourtSchedule::where('court_id', $this->courtId)
                ->where('day', $dayMap[$date->dayOfWeekIso])
                ->first();

            $isOperatingDay = $schedule && $schedule->is_active;

            $bookedSlotIds = Booking::where('court_id', $this->courtId)
                ->where('booking_date', $dateStr)
                ->whereIn('status', ['pending', 'confirmed'])
                ->pluck('time_slot_id')
                ->toArray();

            $slots = [];
            foreach ($timeSlots as $slot) {
                $isBooked = in_array($slot->id, $bookedSlotIds);
                $isOutsideHours = $isOperatingDay
                    && ($slot->start_time < $schedule->open_time || $slot->end_time > $schedule->close_time);
                $isDisabled = $isBooked || $isOutsideHours || ! $isOperatingDay;

                $slots[] = [
                    'id' => $slot->id,
                    'label' => $slot->label,
                    'start_time' => $slot->start_time,
                    'is_booked' => $isBooked,
                    'is_outside_hours' => $isOutsideHours,
                    'is_disabled' => $isDisabled,
                ];
            }

            $days[] = [
                'date' => $dateStr,
                'day_name' => $date->isoFormat('ddd'),
                'day_number' => $date->format('d'),
                'month' => $date->isoFormat('MMM'),
                'is_today' => $date->isToday(),
                'is_selected' => $dateStr === $this->bookingDate,
                'is_past' => $date->lt(now()->startOfDay()),
                'schedule' => $isOperatingDay ? [
                    'open' => $schedule->open_time,
                    'close' => $schedule->close_time,
                ] : null,
                'slots' => $slots,
            ];
        }

        return $this->calendarData = $days;
    }

    public function render()
    {
        $court = Court::find($this->courtId);
        $timeSlots = TimeSlot::all()->sortBy('start_time')->values();
        $maxDate = now()->addDays(14)->toDateString();

        $bookedSlotIds = Booking::where('court_id', $this->courtId)
            ->where('booking_date', $this->bookingDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time_slot_id')
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

        $calendarData = $this->getCalendarData();
        $calendarWeekLabel = Carbon::parse($this->calendarWeekStart)->isoFormat('D MMM') . ' - ' . Carbon::parse($this->calendarWeekStart)->addDays(6)->isoFormat('D MMM YYYY');

        return view('livewire.bookings.booking-create', compact(
            'court', 'timeSlots', 'maxDate', 'bookedSlotIds', 'unavailableSlotIds', 'courtSchedule', 'calendarData', 'calendarWeekLabel'
        ))->layout('components.layouts.app', ['title' => 'Buat Booking - PadelSpot']);
    }
}
