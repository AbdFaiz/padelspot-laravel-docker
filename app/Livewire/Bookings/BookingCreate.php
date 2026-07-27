<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\Court;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BookingCreate extends Component
{
    public int $courtId;

    public string $bookingDate = '';

    public int $timeSlotId = 0;

    public string $notes = '';

    public function mount(): void
    {
        $this->courtId = request()->query('court', 0);
        $this->bookingDate = now()->toDateString();
    }

    public function rules(): array
    {
        return [
            'courtId' => 'required|exists:courts,id',
            'bookingDate' => 'required|date|after_or_equal:today',
            'timeSlotId' => 'required|exists:time_slots,id',
        ];
    }

    public function store(): void
    {
        $this->validate();

        $isBooked = Booking::where('court_id', $this->courtId)
            ->where('time_slot_id', $this->timeSlotId)
            ->where('booking_date', $this->bookingDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            session()->flash('error', 'Slot waktu ini sudah dipesan. Silakan pilih slot lain.');

            return;
        }

        $court = Court::findOrFail($this->courtId);

        DB::transaction(function () use ($court) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'court_id' => $this->courtId,
                'time_slot_id' => $this->timeSlotId,
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
        });

        session()->flash('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');

        $this->redirect(route('bookings.index'));
    }

    public function render()
    {
        $court = Court::find($this->courtId);
        $timeSlots = TimeSlot::all();
        $maxDate = now()->addDays(14)->toDateString();

        $bookedSlotIds = Booking::where('court_id', $this->courtId)
            ->where('booking_date', $this->bookingDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time_slot_id')
            ->toArray();

        return view('livewire.bookings.booking-create', compact('court', 'timeSlots', 'maxDate', 'bookedSlotIds'))
            ->layout('components.layouts.app', ['title' => 'Buat Booking - PadelSpot']);
    }
}
