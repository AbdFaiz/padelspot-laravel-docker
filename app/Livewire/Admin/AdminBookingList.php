<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminBookingList extends Component
{
    public string $search = '';

    public string $status = '';

    public function confirm(int $bookingId): void
    {
        $this->transitionStatus($bookingId, BookingStatus::Confirmed, 'Booking dikonfirmasi oleh admin.');
    }

    public function complete(int $bookingId): void
    {
        $this->transitionStatus($bookingId, BookingStatus::Completed, 'Booking selesai.');
    }

    public function reject(int $bookingId): void
    {
        $this->transitionStatus($bookingId, BookingStatus::Cancelled, 'Ditolak oleh admin.');
    }

    private function transitionStatus(int $bookingId, BookingStatus $newStatus, string $logNotes): void
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $booking = Booking::findOrFail($bookingId);

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
        $query = Booking::with(['user', 'court', 'timeSlots', 'payment']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                    ->orWhereHas('court', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $bookings = $query->orderByDesc('created_at')->get();

        $stats = Booking::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
        ")->first();

        return view('livewire.admin.admin-booking-list', compact('bookings', 'stats'))
            ->layout('components.layouts.app', ['title' => 'Kelola Booking - PadelSpot']);
    }
}
