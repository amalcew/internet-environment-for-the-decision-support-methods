package pl.poznan.put.decision_support.service.electre_shared

import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.TestStepInterface

interface ConfigInterface {
    fun getSteps(): Array<TestStepInterface>
    fun getAggregators(): Array<AggregatorInterface>
}