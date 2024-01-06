<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectreTri extends Model
{
    use HasFactory;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function electreTriCriteriaSettings(): HasMany
    {
        return $this->hasMany(ElectreTriCriteriaSettings::class);
    }

    public function electreTriProfile(): HasMany {
        return $this->hasMany(Profile::class);
    }
}
