<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Uta extends Model
{
    use HasFactory;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public $criteriaMinMax = [];

    public $criteriaNumberOfBreakPoints = [];

    public $rownamesPerformanceTable = [];

    public $colnamesPerformanceTable = [];

    public $alternativesPreferences = [];

    public $alternativesIndifferences = [];

    public $performanceTable = [];

    public $epsilon = 0.05;
}
