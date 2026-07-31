<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminBookingShow extends Component
{
    public int $bookingId;

    public function mount(int $id): void
    {
        $this->bookingId = $id;
    }

    public function confirm(): void
    {
        $this->transitionStatus(BookingStatus::Confirmed, 'Booking dikonfirmasi oleh admin.');
    }

    public function complete(): void
    {
        $this->transitionStatus(BookingStatus::Completed, 'Booking ditandai selesai.');
    }

    public function reject(): void
    {
        $this->transitionStatus(BookingStatus::Cancelled, 'Ditolak oleh admin.');
    }

    private function transitionStatus(BookingStatus $newStatus, string $logNotes): void
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $booking = Booking::findOrFail($this->bookingId);

        $allowedFrom = match ($newStatus) {
            BookingStatus::Confirmed => [BookingStatus::Pending],
            BookingStatus::Completed => [BookingStatus::Confirmed],
            BookingStatus::Cancelled => [BookingStatus::Pending, BookingStatus::Confirmed],
            default => [],
        };

        abort_unless(in_array($booking->status, $allowedFrom), 400);

        DB::transaction(function () use ($booking, $newStatus, $logNotes) {
            $oldStatus = $booking->status->value;
            $booking->update(['status' => $newStatus->value]);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus->value,
                'notes' => $logNotes,
            ]);
        });

        $messages = [
            BookingStatus::Confirmed->value => 'Booking berhasil dikonfirmasi.',
            BookingStatus::Completed->value => 'Booking ditandai selesai.',
            BookingStatus::Cancelled->value => 'Booking ditolak.',
        ];

        session()->flash('success', $messages[$newStatus->value]);
    }

    public function render()
    {
        $booking = Booking::with(['court', 'timeSlots', 'user', 'payment.paymentMethod', 'statusLogs'])
            ->findOrFail($this->bookingId);

        abort_unless(Auth::user()->isAdmin(), 403);

        return view('livewire.admin.admin-booking-show', compact('booking'))
            ->layout('layouts.app', ['title' => 'Detail Booking - PadelSpot']);
    }
}
