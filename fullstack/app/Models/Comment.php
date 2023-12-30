<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    public function conclusion(): BelongsTo
    {
        return $this->belongsTo(Conclusion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}