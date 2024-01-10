<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Datasetable extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function datasetable(): MorphTo
    {
        return $this->morphTo();
    }
}
