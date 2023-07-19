package pl.poznan.put.decision_support.sample.service.electre1s

import org.springframework.context.annotation.Configuration
import pl.poznan.put.decision_support.sample.service.electre1s.steps.*

class Config {
    fun getSteps(): Array<TestStepInterface> {
        return arrayOf(ConcordanceTest(), DiscordanceTest())
    }

    fun getAggregator(): AggregatorInterface {
        return AggregateStep()
    }
}