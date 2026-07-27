<?php

namespace App\Livewire\Courts;

use App\Models\Court;
use Livewire\Component;

class CourtList extends Component
{
    public function render()
    {
        $courts = Court::with('schedules')->get();

        return view('livewire.courts.court-list')
            ->layout('components.layouts.app', ['title' => 'Lapangan - PadelSpot']);
    }
}
