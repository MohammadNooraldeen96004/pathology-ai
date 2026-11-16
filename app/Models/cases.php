<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class cases extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'case_number',
        'specialization',
        'icd10',
        'diagnosis',
        'conclusion',
        'diff_diagnostic',
        'grossing',
        'micro_protocol',
        'additional_info',
        'status',
        'expected_slides',
    ];
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class, 'case_id');
    }
}
