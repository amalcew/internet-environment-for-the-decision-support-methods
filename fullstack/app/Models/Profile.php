<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function values(): HasMany
    {
        return $this->hasMany(Value::class);
    }
    public function __toString()
    {
        return $this->name;
    }
}
