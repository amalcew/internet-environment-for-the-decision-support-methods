<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectreCriteriaSetting extends Model
{
    use HasFactory;

//TODO: add polymphorfic relationship to electreTri
    public function electreOne(): BelongsTo
    {
        return $this->belongsTo(ElectreOne::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

//    protected $hidden = [
//        'id', 'electre_one_id', 'criterion_id', 'created_at', 'updated_at', 'criterion' // Electre1sMapper::generateDTOfromElectre1sModel
//    ];
}
