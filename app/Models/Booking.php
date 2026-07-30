<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'court_id', 'booking_date', 'status', 'total_price', 'notes'])]
class Booking extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'total_price' => 'decimal:2',
            'status' => BookingStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    public function timeSlots(): BelongsToMany
    {
        return $this->belongsToMany(TimeSlot::class, 'booking_time_slot')
            ->withPivot('price')
            ->orderBy('start_time');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(BookingStatusLog::class)
            ->orderByDesc('created_at');
    }
}
