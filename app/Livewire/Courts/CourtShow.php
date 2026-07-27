<?php

namespace App\Livewire\Courts;

use App\Models\Court;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourtShow extends Component
{
    public int $courtId;

    public string $comment = '';

    public int $rating = 5;

    public function mount(int $id): void
    {
        $this->courtId = $id;
    }

    public function submitReview(): void
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $hasExisting = Review::where('user_id', Auth::id())
            ->where('court_id', $this->courtId)
            ->exists();

        if ($hasExisting) {
            session()->flash('error', 'Anda sudah memberikan ulasan untuk lapangan ini.');

            return;
        }

        Review::create([
            'user_id' => Auth::id(),
            'court_id' => $this->courtId,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->rating = 5;

        session()->flash('success', 'Ulasan berhasil dikirim.');
    }

    public function deleteReview(int $reviewId): void
    {
        $review = Review::findOrFail($reviewId);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();
        session()->flash('success', 'Ulasan berhasil dihapus.');
    }

    public function render()
    {
        $court = Court::with(['schedules', 'reviews.user', 'images'])->findOrFail($this->courtId);

        return view('livewire.courts.court-show', compact('court'))
            ->layout('components.layouts.app', ['title' => $court->name.' - PadelSpot']);
    }
}
