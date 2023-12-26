<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UtaCriteriaSetting extends Model
{
    use HasFactory;

    public function uta(): BelongsTo
    {
        return $this->belongsTo(Uta::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    protected $hidden = [
        'id', 'uta_id', 'criterion_id', 'created_at', 'updated_at', 'criterion'
    ];
}
