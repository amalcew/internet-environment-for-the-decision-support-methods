<?php

namespace App\Service\MethodService\Transfers;

use App\Service\MethodService\Transfers\Electre1s\VariantDTO;

class UTARequest
{
    public array $alternativesIndifferences = [[]];

    public array $alternativesPreferences = [[]];

    /** @var int[] */
    public ?array $alternativesRanks = [];

    /** @var int[] */
    public array $criteriaNumberOfBreakPoints = [];


    /** @var string[] */
    public array $colnamesPerformanceTable = [];

    /** @var string[] */
    public array $criteriaMinMax = [];

    public float $epsilon = 0.0;

    /** @var int[] */
    public array $performanceTable = [];

    /** @var string[] */
    public array $rownamesPerformanceTable = [];


}
