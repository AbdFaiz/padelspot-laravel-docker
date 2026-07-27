<?php

use App\Livewire\Courts\CourtForm;
use App\Livewire\Courts\CourtList;
use App\Livewire\Courts\CourtShow;
use App\Livewire\Dashboard;
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
});

require __DIR__.'/settings.php';
