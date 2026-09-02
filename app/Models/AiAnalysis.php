<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'slide_id',
        'score',
        'model_version',
        'prediction',
        'status',
        'analyzed_at',
    ];

    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class, 'slide_id');
    }

}
