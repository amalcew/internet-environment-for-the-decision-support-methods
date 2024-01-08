package pl.poznan.put.decision_support.service.electre1s.steps

import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import java.util.*

class AggregateStep : AggregatorInterface {

    override fun calculate(lambda: Double, stepResult: LinkedList<Any>, context: MutableMap<String, Any>, variantsY: List<Variant>) {
        val concordanceTestResults = stepResult[0] //Array<Array<Double>>
        val discordanceTestResults = stepResult[1]
//        TODO: is multiple with acceptable?

        with (concordanceTestResults as Array<Array<Double>>) {
            with(discordanceTestResults as Array<Array<Double>>) {
                val n: Int = concordanceTestResults.size
                val result: Array<Array<Double>> = Array(n) { Array(n) { 0.0 } }

                for (row in concordanceTestResults.indices) {
                    for (column in 0 until concordanceTestResults[row].size) {
                        if (concordanceTestResults[row][column] >= lambda && discordanceTestResults[row][column] != 1.0) {
                            result[row][column] = 1.0
                        } else {
                            result[row][column] = 0.0
                        }
                    }
                }
                context["final"] = result;
            }
        }
    }
}