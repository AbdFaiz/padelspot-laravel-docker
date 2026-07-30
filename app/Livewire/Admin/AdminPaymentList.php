<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\BookingStatusLog;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminPaymentList extends Component
{
    public string $rejectNotes = '';

    public ?int $rejectingPaymentId = null;

    public function verify(int $paymentId): void
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $payment = Payment::findOrFail($paymentId);
        abort_unless($payment->status === PaymentStatus::Pending, 400);

        DB::transaction(function () use ($payment) {
            $payment->update(['status' => PaymentStatus::Verified->value]);

            $oldStatus = $payment->booking->status->value;
            $payment->booking->update(['status' => BookingStatus::Confirmed->value]);

            BookingStatusLog::create([
                'booking_id' => $payment->booking_id,
                'old_status' => $oldStatus,
                'new_status' => BookingStatus::Confirmed->value,
                'notes' => 'Pembayaran diverifikasi oleh admin.',
            ]);
        });

        session()->flash('success', 'Pembayaran berhasil diverifikasi. Booking dikonfirmasi.');
    }

    public function showRejectForm(int $paymentId): void
    {
        $this->rejectingPaymentId = $paymentId;
        $this->rejectNotes = '';
    }

    public function cancelReject(): void
    {
        $this->rejectingPaymentId = null;
        $this->rejectNotes = '';
    }

    public function reject(int $paymentId): void
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $payment = Payment::findOrFail($paymentId);
        abort_unless($payment->status === PaymentStatus::Pending, 400);

        $payment->update([
            'status' => PaymentStatus::Rejected->value,
            'admin_notes' => $this->rejectNotes,
        ]);

        $this->rejectingPaymentId = null;
        $this->rejectNotes = '';

        session()->flash('success', 'Pembayaran ditolak.');
    }

    public function render()
    {
        $payments = Payment::with(['booking.court', 'booking.user', 'paymentMethod'])
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.admin.admin-payment-list', compact('payments'))
            ->layout('components.layouts.app', ['title' => 'Kelola Pembayaran - PadelSpot']);
    }
}
