package pl.poznan.put.decision_support.service.electreTri

import pl.poznan.put.decision_support.service.electreTri.steps.AggregateTriStep
import pl.poznan.put.decision_support.service.electreTri.steps.DiscordanceTriTest
import pl.poznan.put.decision_support.service.electre_shared.ConfigInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.ConcordanceTest
import pl.poznan.put.decision_support.service.electre_shared.steps.TestStepInterface

class Config : ConfigInterface {
    override fun getSteps(): Array<TestStepInterface> {
        return arrayOf(ConcordanceTest(), DiscordanceTriTest())
    }

    override fun getAggregators(): Array<AggregatorInterface> {
        return arrayOf(AggregateTriStep(),)
    }
}