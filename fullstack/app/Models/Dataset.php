<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dataset extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

//    owner
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function datasetUsers(): HasMany
    {
        return $this->hasMany(DatasetUser::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
