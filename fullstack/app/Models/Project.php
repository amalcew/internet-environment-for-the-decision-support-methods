<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;


    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projectUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function criteria(): HasMany
    {
        return $this->hasMany(Criterion::class, 'dataset_id', 'dataset_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'dataset_id', 'dataset_id');
    }

    public function electreOnes(): HasMany
    {
        return $this->hasMany(ElectreOne::class);
    }

    public function utas(): HasMany
    {
        return $this->hasMany(Uta::class);
    }

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }
}
