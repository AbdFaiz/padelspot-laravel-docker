<?php

namespace App\Livewire\Admin;

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
        abort_unless(Auth::user()->isAdmin(), 403);

        $booking = Booking::findOrFail($bookingId);
        abort_unless($booking->status === 'pending', 400);

        DB::transaction(function () use ($booking) {
            $oldStatus = $booking->status;
            $booking->update(['status' => 'confirmed']);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => 'confirmed',
                'notes' => 'Booking dikonfirmasi oleh admin.',
            ]);
        });

        session()->flash('success', 'Booking berhasil dikonfirmasi.');
    }

    public function complete(int $bookingId): void
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $booking = Booking::findOrFail($bookingId);
        abort_unless($booking->status === 'confirmed', 400);

        DB::transaction(function () use ($booking) {
            $oldStatus = $booking->status;
            $booking->update(['status' => 'completed']);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => 'completed',
                'notes' => 'Booking selesai.',
            ]);
        });

        session()->flash('success', 'Booking ditandai selesai.');
    }

    public function reject(int $bookingId): void
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $booking = Booking::findOrFail($bookingId);
        abort_unless(in_array($booking->status, ['pending', 'confirmed']), 400);

        DB::transaction(function () use ($booking) {
            $oldStatus = $booking->status;
            $booking->update(['status' => 'cancelled']);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => 'cancelled',
                'notes' => 'Ditolak oleh admin.',
            ]);
        });

        session()->flash('success', 'Booking ditolak.');
    }

    public function render()
    {
        $query = Booking::with(['user', 'court', 'timeSlot', 'payment']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                    ->orWhereHas('court', fn ($q) => $q->where('name', 'like', "%{$this->search}%"));
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $bookings = $query->orderByDesc('created_at')->get();

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('livewire.admin.admin-booking-list', compact('bookings', 'stats'))
            ->layout('components.layouts.app', ['title' => 'Kelola Booking - PadelSpot']);
    }
}
