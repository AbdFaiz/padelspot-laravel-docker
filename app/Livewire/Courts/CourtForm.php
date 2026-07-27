<?php

namespace App\Livewire\Courts;

use App\Models\Court;
use App\Models\CourtSchedule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CourtForm extends Component
{
    public ?int $courtId = null;

    public string $name = '';

    public string $description = '';

    public float $pricePerHour = 0;

    public string $status = 'available';

    public array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public string $openTime = '08:00';

    public string $closeTime = '22:00';

    public bool $isEdit = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pricePerHour' => 'required|numeric|min:0',
            'status' => 'required|in:available,maintenance',
            'days' => 'required|array|min:1',
            'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'openTime' => 'required|date_format:H:i',
            'closeTime' => 'required|date_format:H:i|after:openTime',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->courtId = $id;
            $this->isEdit = true;

            $court = Court::with('schedules')->findOrFail($id);
            $this->name = $court->name;
            $this->description = $court->description ?? '';
            $this->pricePerHour = (float) $court->price_per_hour;
            $this->status = $court->status;
            $this->days = $court->schedules->pluck('day')->toArray();
            $this->openTime = $court->schedules->first()?->open_time ?? '08:00';
            $this->closeTime = $court->schedules->first()?->close_time ?? '22:00';
        }
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            $court = Court::updateOrCreate(
                ['id' => $this->courtId],
                [
                    'name' => $this->name,
                    'description' => $this->description ?: null,
                    'price_per_hour' => $this->pricePerHour,
                    'status' => $this->status,
                ]
            );

            if ($this->isEdit) {
                $court->schedules()->delete();
            }

            foreach ($this->days as $day) {
                CourtSchedule::create([
                    'court_id' => $court->id,
                    'day' => $day,
                    'open_time' => $this->openTime,
                    'close_time' => $this->closeTime,
                    'is_active' => true,
                ]);
            }
        });

        session()->flash('success', $this->isEdit ? 'Lapangan berhasil diperbarui.' : 'Lapangan berhasil ditambahkan.');

        $this->redirect(route('courts.index'));
    }

    public function render()
    {
        $days = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];

        return view('livewire.courts.court-form', compact('days'))
            ->layout('components.layouts.app', ['title' => ($this->isEdit ? 'Edit' : 'Tambah').' Lapangan - PadelSpot']);
    }
}
