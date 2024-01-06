<?php

namespace App\Service\MethodService\Transfers;

use App\Service\MethodService\Transfers\Electre1s\CriterionDTO;
use App\Service\MethodService\Transfers\Electre1s\VariantDTO;

class Electre1sRequestDTO
{
    public ?float $lambda;

    /** @var CriterionDTO[] */
    public array $criteria = [];

    /** @var VariantDTO[] */
    public array $variants = [];
}
