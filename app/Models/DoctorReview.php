<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'slide_id',
        'doctor_id',
        'reviewed_at',
        'notes',
        'decision'
    ];

    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class, 'slide_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
