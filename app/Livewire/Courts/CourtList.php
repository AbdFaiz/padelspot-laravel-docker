<?php

namespace App\Livewire\Courts;

use App\Models\Court;
use Livewire\Component;

class CourtList extends Component
{
    public string $search = '';

    public ?float $minPrice = null;

    public ?float $maxPrice = null;

    public string $statusFilter = '';

    public function resetFilters(): void
    {
        $this->search = '';
        $this->minPrice = null;
        $this->maxPrice = null;
        $this->statusFilter = '';
    }

    public function render()
    {
        $courts = Court::with(['schedules', 'images', 'reviews'])
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%"))
            ->when($this->minPrice !== null, fn ($q) => $q->where('price_per_hour', '>=', $this->minPrice))
            ->when($this->maxPrice !== null, fn ($q) => $q->where('price_per_hour', '<=', $this->maxPrice))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->get();

        return view('livewire.courts.court-list', compact('courts'))
            ->layout('components.layouts.app', ['title' => 'Lapangan - PadelSpot']);
    }
}
