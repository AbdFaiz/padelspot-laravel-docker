<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentShow extends Component
{
    public int $paymentId;

    public function mount(int $id): void
    {
        $this->paymentId = $id;
    }

    public function render()
    {
        $payment = Payment::with(['booking.court', 'booking.timeSlot', 'paymentMethod', 'booking.user'])
            ->findOrFail($this->paymentId);

        abort_unless(
            Auth::user()->isAdmin() || $payment->booking->user_id === Auth::id(),
            403
        );

        return view('livewire.payments.payment-show', compact('payment'))
            ->layout('components.layouts.app', ['title' => 'Detail Pembayaran - PadelSpot']);
    }
}
