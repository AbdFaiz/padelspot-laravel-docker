<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use App\Models\BookingStatusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BookingShow extends Component
{
    public int $bookingId;

    public function mount(int $id): void
    {
        $this->bookingId = $id;
    }

    public function cancel(): void
    {
        $booking = Booking::findOrFail($this->bookingId);

        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless(in_array($booking->status, ['pending', 'confirmed']), 400);

        DB::transaction(function () use ($booking) {
            $oldStatus = $booking->status;

            $booking->update(['status' => 'cancelled']);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => 'cancelled',
                'notes' => 'Dibatalkan oleh pelanggan.',
            ]);
        });

        session()->flash('success', 'Booking berhasil dibatalkan.');
    }

    public function render()
    {
        $booking = Booking::with(['court', 'timeSlot', 'payment.paymentMethod', 'statusLogs'])
            ->findOrFail($this->bookingId);

        abort_unless($booking->user_id === Auth::id(), 403);

        return view('livewire.bookings.booking-show', compact('booking'))
            ->layout('components.layouts.app', ['title' => 'Detail Booking - PadelSpot']);
    }
}
