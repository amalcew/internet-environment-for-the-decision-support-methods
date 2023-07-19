package pl.poznan.put.decision_support.sample.service.electre1s.steps

import pl.poznan.put.decision_support.sample.service.electre_shared.steps.AggregatorInterface
import java.util.*

class AggregateStep : AggregatorInterface {

    override fun calculate(lambda: Double, stepResult: LinkedList<Array<Array<Double>>>): Array<Array<Double>> {
        val concordanceTestResults = stepResult[0]
        val discordanceTestResults = stepResult[1]
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

        return result
    }
}