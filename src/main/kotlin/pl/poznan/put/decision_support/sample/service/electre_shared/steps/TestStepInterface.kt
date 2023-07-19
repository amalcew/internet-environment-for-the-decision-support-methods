package pl.poznan.put.decision_support.sample.service.electre_shared.steps

import pl.poznan.put.decision_support.sample.service.electre1s.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.sample.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre_shared.model.Variant

interface TestStepInterface {
    @Throws(InvalidCriteriaException::class)
    public fun calculate(variants: List<Variant>, criteria: List<Criterion>): Array<Array<Double>>
}