<?php

namespace App\Service\MethodService\Transfers;

use App\Service\MethodService\Transfers\Electre1s\CriterionDTO;
use App\Service\MethodService\Transfers\Electre1s\VariantDTO;

class UTARequest
{
    public float $lambda;

    /** @var CriterionDTO[] */
    public array $criteria = [];

    /** @var VariantDTO[] */
    public array $variants = [];

    /** @var VariantDTO[] */
    public $b = []; //remove when spring 1s won't require it
}
