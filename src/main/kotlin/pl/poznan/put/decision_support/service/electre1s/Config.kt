package pl.poznan.put.decision_support.service.electre1s

import pl.poznan.put.decision_support.service.electre1s.steps.AggregateStep
import pl.poznan.put.decision_support.service.electre1s.steps.DiscordanceTest
import pl.poznan.put.decision_support.service.electre_shared.ConfigInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.ConcordanceTest
import pl.poznan.put.decision_support.service.electre_shared.steps.TestStepInterface

class Config : ConfigInterface {
    override fun getSteps(): Array<TestStepInterface> {
        return arrayOf(ConcordanceTest(), DiscordanceTest())
    }

    override fun getAggregator(): AggregatorInterface {
        return AggregateStep()
    }
}