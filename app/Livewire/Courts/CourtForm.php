<?php

namespace App\Livewire\Courts;

use App\Models\Court;
use App\Models\CourtImage;
use App\Models\CourtSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourtForm extends Component
{
    use WithFileUploads;

    public ?int $courtId = null;

    public string $name = '';

    public string $description = '';

    public float $pricePerHour = 0;

    public string $status = 'available';

    public array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public string $openTime = '08:00';

    public string $closeTime = '22:00';

    public bool $isEdit = false;

    public array $newImages = [];

    public array $existingImages = [];

    public ?int $primaryImageId = null;

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
            'newImages' => 'array|max:5',
            'newImages.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->courtId = $id;
            $this->isEdit = true;

            $court = Court::with(['schedules', 'images'])->findOrFail($id);
            $this->name = $court->name;
            $this->description = $court->description ?? '';
            $this->pricePerHour = (float) $court->price_per_hour;
            $this->status = $court->status;
            $this->days = $court->schedules->pluck('day')->toArray();
            $this->openTime = $court->schedules->first()?->open_time ?? '08:00';
            $this->closeTime = $court->schedules->first()?->close_time ?? '22:00';
            $this->existingImages = $court->images->toArray();
            $primary = $court->images->where('is_primary', true)->first();
            $this->primaryImageId = $primary?->id;
        }
    }

    public function addImage(): void
    {
        $this->validate([
            'newImages' => 'array|max:5',
        ]);

        if (count($this->existingImages) + count($this->newImages) > 5) {
            session()->flash('error', 'Maksimal 5 foto per lapangan.');

            return;
        }
    }

    public function removeNewImage(int $index): void
    {
        unset($this->newImages[$index]);
        $this->newImages = array_values($this->newImages);
    }

    public function removeExistingImage(int $imageId): void
    {
        $image = CourtImage::find($imageId);
        if ($image && $image->court_id == $this->courtId) {
            Storage::disk('public')->delete($image->image_path);
            if ($this->primaryImageId === $imageId) {
                $this->primaryImageId = null;
            }
            $image->delete();
            $this->existingImages = collect($this->existingImages)
                ->reject(fn ($img) => $img['id'] === $imageId)
                ->values()
                ->toArray();
        }
    }

    public function setPrimary(int $imageId): void
    {
        $this->primaryImageId = $imageId;
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

            $hasExisting = $this->primaryImageId !== null;
            $hasNew = count($this->newImages) > 0;

            if ($hasNew) {
                $firstNewId = null;
                foreach ($this->newImages as $index => $image) {
                    $path = $image->store('courts', 'public');
                    $img = CourtImage::create([
                        'court_id' => $court->id,
                        'image_path' => $path,
                        'is_primary' => ! $hasExisting && $index === 0,
                    ]);
                    if (! $hasExisting && $index === 0) {
                        $firstNewId = $img->id;
                    }
                }
                if ($firstNewId && ! $hasExisting) {
                    $this->primaryImageId = $firstNewId;
                }
            }

            if ($this->isEdit) {
                CourtImage::where('court_id', $court->id)
                    ->update(['is_primary' => false]);

                if ($this->primaryImageId) {
                    CourtImage::where('id', $this->primaryImageId)
                        ->where('court_id', $court->id)
                        ->update(['is_primary' => true]);
                } else {
                    $firstImage = CourtImage::where('court_id', $court->id)->first();
                    if ($firstImage) {
                        $firstImage->update(['is_primary' => true]);
                    }
                }
            } else {
                if ($this->primaryImageId && $hasNew) {
                    CourtImage::where('id', $this->primaryImageId)->update(['is_primary' => true]);
                }
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
