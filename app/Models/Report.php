<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'slide_id',
        'doctor_id',
        'report_number',
        'final_notes',
    ];

    public function slide(): belongsTo
    {
        return $this->belongsTo(Slide::class, 'slide_id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
