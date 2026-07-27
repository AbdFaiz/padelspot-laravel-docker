<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookingList extends Component
{
    public function render()
    {
        $bookings = Booking::with(['court', 'timeSlot', 'payment.paymentMethod'])
            ->where('user_id', Auth::id())
            ->orderByDesc('booking_date')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.bookings.booking-list', compact('bookings'))
            ->layout('components.layouts.app', ['title' => 'Booking Saya - PadelSpot']);
    }
}
