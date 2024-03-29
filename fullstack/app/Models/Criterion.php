<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    use HasFactory;

    public const TYPE_COST = 'cost';
    public const TYPE_GAIN = 'gain';
    public $timestamps = false;

    public function values(): HasMany
    {
        return $this->hasMany(Value::class);
    }

    public function electreCriteriaSettings(): HasMany
    {
        return $this->hasMany(ElectreCriteriaSetting::class);
    }

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }

    public function __toString()
    {
        return $this->name;
    }
}
