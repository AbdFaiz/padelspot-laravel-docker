<?php

namespace App\Livewire\Payments;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentForm extends Component
{
    use WithFileUploads;

    public int $bookingId;

    public int $paymentMethodId = 0;

    public $proof = null;

    protected function rules(): array
    {
        return [
            'paymentMethodId' => 'required|exists:payment_methods,id',
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function mount(int $id): void
    {
        $this->bookingId = $id;
    }

    public function submit(): void
    {
        $booking = $this->authorizePayment();

        $this->validate();

        $proofPath = $this->proof->store('proofs', 'public');

        DB::transaction(function () use ($booking, $proofPath) {
            Payment::create([
                'booking_id' => $this->bookingId,
                'payment_method_id' => $this->paymentMethodId,
                'amount' => $booking->total_price,
                'proof_path' => $proofPath,
            ]);
        });

        session()->flash('success', 'Pembayaran berhasil! Booking dikonfirmasi secara otomatis.');

        $this->redirect(route('bookings.show', $this->bookingId));
    }

    private function authorizePayment(): Booking
    {
        $booking = Booking::findOrFail($this->bookingId);
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === BookingStatus::Pending, 400);
        abort_unless(! $booking->payment, 400);
        return $booking;
    }

    public function render()
    {
        $booking = $this->authorizePayment();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('livewire.payments.payment-form', compact('booking', 'paymentMethods'))
            ->layout('layouts.app', ['title' => 'Bayar Booking - PadelSpot']);
    }
}
