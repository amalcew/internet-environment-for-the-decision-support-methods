package pl.poznan.put.decision_support.sample.service.electre1s

import pl.poznan.put.decision_support.sample.service.electre1s.steps.*
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.AggregateStep
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.TestStepInterface

class Config {
    fun getSteps(): Array<TestStepInterface> {
        return arrayOf(ConcordanceTest(), DiscordanceTest())
    }

    fun getAggregator(): AggregatorInterface {
        return AggregateStep()
    }
}