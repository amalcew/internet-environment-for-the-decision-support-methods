<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ElectreOne extends Model
{
    use HasFactory;
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function electreCriteriaSettings(): HasMany
    {
        return $this->hasMany(ElectreCriteriaSetting::class);
    }
}
