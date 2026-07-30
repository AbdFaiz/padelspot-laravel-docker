<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['start_time', 'end_time'])]
class TimeSlot extends Model
{
    use HasFactory;

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_time_slot')
            ->withPivot('price');
    }

    public function getLabelAttribute(): string
    {
        return "{$this->start_time} - {$this->end_time}";
    }
}
