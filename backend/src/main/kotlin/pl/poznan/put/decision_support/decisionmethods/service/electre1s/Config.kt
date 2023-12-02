package pl.poznan.put.decision_support.decisionmethods.service.electre1s

import pl.poznan.put.decision_support.service.electre1s.steps.AggregateStep
import pl.poznan.put.decision_support.service.electre1s.steps.DiscordanceTest
import pl.poznan.put.decision_support.service.electre1s.steps.RelationAggregator
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.ConfigInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import pl.poznan.put.decision_support.service.electre_shared.steps.ConcordanceTest
import pl.poznan.put.decision_support.service.electre_shared.steps.TestStepInterface

class Config : ConfigInterface {
    override fun getSteps(): Array<TestStepInterface> {
        return arrayOf(ConcordanceTest(), DiscordanceTest())
    }

    override fun getAggregators(): Array<AggregatorInterface> {
        return arrayOf(AggregateStep(), RelationAggregator())
    }
}