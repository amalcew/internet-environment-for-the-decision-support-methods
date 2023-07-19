package pl.poznan.put.decision_support.sample.service.electreTri

import pl.poznan.put.decision_support.sample.service.electreTri.steps.AggregateTriStep
import pl.poznan.put.decision_support.sample.service.electreTri.steps.DiscordanceTriTest
import pl.poznan.put.decision_support.sample.service.electre_shared.ConfigInterface
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.ConcordanceTest
import pl.poznan.put.decision_support.sample.service.electre_shared.steps.TestStepInterface

class Config : ConfigInterface {
    override fun getSteps(): Array<TestStepInterface> {
        return arrayOf(ConcordanceTest(), DiscordanceTriTest())
    }

    override fun getAggregator(): AggregatorInterface {
        return AggregateTriStep()
    }
}