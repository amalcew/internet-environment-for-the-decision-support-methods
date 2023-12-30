<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

//    TODO: here
//    public function datasetUsers(): HasMany
//    {
//        return $this->hasMany(DatasetUser::class);
//    }

//    public function datasetUsers(): MorphToMany
//    {
//        return $this->morphedByMany(User::class, 'datasetable');
//    }

    public function directMembers(): BelongsToMany
    {
        return $this->morphedByMany(User::class, 'datasetable');
    }
    public function groups(): BelongsToMany
    {
        return $this->morphedByMany(Group::class, 'datasetable');
    }

    public function criteria(): HasMany
    {
        return $this->hasMany(Criterion::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
