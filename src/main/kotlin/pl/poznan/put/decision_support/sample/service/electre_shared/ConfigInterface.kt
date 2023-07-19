package pl.poznan.put.decision_support.sample.service.electre_shared

import pl.poznan.put.decision_support.sample.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.TestStepInterface

interface ConfigInterface {
    fun getSteps(): Array<TestStepInterface>
    fun getAggregator(): AggregatorInterface
}