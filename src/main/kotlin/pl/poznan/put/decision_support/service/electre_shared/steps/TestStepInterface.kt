package pl.poznan.put.decision_support.service.electre_shared.steps

import pl.poznan.put.decision_support.service.electre1s.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.service.electre_shared.model.Variant

interface TestStepInterface {
    /**
     * @return result Array<Array<Double>>|List<Array<Array<Double>>>
     */
    @Throws(InvalidCriteriaException::class)
    public fun calculate(variants: List<Variant>, criteria: List<Criterion>, context: MutableMap<String, Any>): Any
}