<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookingList extends Component
{
    public string $status = '';

    public string $search = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public function resetFilters(): void
    {
        $this->status = '';
        $this->search = '';
        $this->dateFrom = '';
        $this->dateTo = '';
    }

    public function render()
    {
        $bookings = Booking::with(['court', 'timeSlots', 'payment.paymentMethod'])
            ->where('user_id', Auth::id())
            ->when($this->status !== '', fn($q) => $q->where('status', $this->status))
            ->when($this->search !== '', fn($q) => $q->whereHas('court', fn($cq) => $cq->where('name', 'like', "%{$this->search}%")))
            ->when($this->dateFrom !== '', fn($q) => $q->where('booking_date', '>=', $this->dateFrom))
            ->when($this->dateTo !== '', fn($q) => $q->where('booking_date', '<=', $this->dateTo))
            ->orderByDesc('booking_date')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.bookings.booking-list', compact('bookings'))
            ->layout('layouts.app', ['title' => 'Booking Saya - PadelSpot']);
    }
}
