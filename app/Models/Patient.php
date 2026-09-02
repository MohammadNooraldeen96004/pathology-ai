<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_code',
        'age',
        'gender',
    ];

    public function cases(): HasMany
    {
        return $this->hasMany(cases::class);
    }
}
