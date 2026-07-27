<?php

use App\Livewire\Admin\AdminPaymentList;
use App\Livewire\Bookings\BookingCreate;
use App\Livewire\Bookings\BookingList;
use App\Livewire\Bookings\BookingShow;
use App\Livewire\Courts\CourtForm;
use App\Livewire\Courts\CourtList;
use App\Livewire\Courts\CourtShow;
use App\Livewire\Dashboard;
use App\Livewire\Payments\PaymentForm;
use App\Livewire\Payments\PaymentShow;
use App\Models\Court;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});

Route::get('courts', CourtList::class)->name('courts.index');
Route::get('courts/{id}', CourtShow::class)->name('courts.show');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('courts/create', CourtForm::class)->name('courts.create');
    Route::get('courts/{id}/edit', CourtForm::class)->name('courts.edit');
    Route::delete('courts/{court}', function (Court $court) {
        $court->delete();

        return redirect()->route('courts.index')->with('success', 'Lapangan berhasil dihapus.');
    })->name('courts.destroy');

    Route::get('admin/payments', AdminPaymentList::class)->name('admin.payments.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('bookings', BookingList::class)->name('bookings.index');
    Route::get('bookings/create', BookingCreate::class)->name('bookings.create');
    Route::get('bookings/{id}', BookingShow::class)->name('bookings.show');

    Route::get('bookings/{id}/pay', PaymentForm::class)->name('payments.create');
    Route::get('payments/{id}', PaymentShow::class)->name('payments.show');
});

require __DIR__.'/settings.php';
