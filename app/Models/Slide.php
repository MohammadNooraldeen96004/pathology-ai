<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'slide_id',
        'file_name',
        'storage_path',
        'case_mapping',
        'dataset_group'
    ];

    

    public function cases(): BelongsTo
    {
        return $this->belongsTo(cases::class, 'case_id');
    }
    public function AiAnalysis(): HasOne
    {
        return $this->hasOne(AiAnalysis::class, 'slide_id');
    }
    public function reports(): HasOne
    {
        return $this->hasOne(Report::class, 'slide_id');
    }
    
    public function doctorReviews(): HasOne
    {
        return $this->hasOne(DoctorReview::class, 'slide_id');
    }
}
