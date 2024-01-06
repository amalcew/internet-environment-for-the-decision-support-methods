<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectreTriCriteriaSettings extends Model
{
    use HasFactory;

    public function electreTri(): BelongsTo
    {
        return $this->belongsTo(ElectreTri::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    protected $hidden = [
        'id', 'electre_tri_id', 'criterion_id', 'created_at', 'updated_at', 'criterion' // Electre1sMapper::generateDTOfromElectre1sModel
    ];
}
