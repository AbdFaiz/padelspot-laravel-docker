<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Court;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $stats = [
                'totalBookings' => Booking::count(),
                'pendingPayments' => Payment::where('status', 'pending')->count(),
                'totalRevenue' => Payment::where('status', 'verified')->sum('amount'),
                'totalCourts' => Court::count(),
                'totalUsers' => User::where('role', 'customer')->count(),
            ];

            $recentBookings = Booking::with(['user', 'court', 'timeSlot'])
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();

            return view('livewire.dashboard', compact('stats', 'recentBookings'))
                ->layout('components.layouts.app', ['title' => 'Dashboard Admin - PadelSpot']);
        }

        $stats = [
            'totalBookings' => Booking::where('user_id', $user->id)->count(),
            'activeBookings' => Booking::where('user_id', $user->id)->whereIn('status', ['pending', 'confirmed'])->count(),
            'completedBookings' => Booking::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        $recentBookings = Booking::with(['court', 'timeSlot', 'payment.paymentMethod'])
            ->where('user_id', $user->id)
            ->orderByDesc('booking_date')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', compact('stats', 'recentBookings'))
            ->layout('components.layouts.app', ['title' => 'Dashboard - PadelSpot']);
    }
}
