<?php

namespace App\Service\MethodService;

use App\Service\MethodService\Transfers\Electre1sRequestDTO;

class MethodFacade
{
    private ?MethodFactory $factory = null;

    private function getFactory(): MethodFactory
    {
        if (!$this->factory) {
            $this->factory = new MethodFactory();
        }
        return $this->factory;
    }
    public function getElectre1sData(Electre1sRequestDTO $dto, $transposeArraysInResults = false) {
        $factory = $this->getFactory();
        $resolver = $factory->createElectre1sResolver();
        return $resolver->resolve($dto, $transposeArraysInResults);
    }
}
