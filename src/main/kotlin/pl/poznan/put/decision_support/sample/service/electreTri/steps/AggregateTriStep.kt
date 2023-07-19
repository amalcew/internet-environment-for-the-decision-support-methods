package pl.poznan.put.decision_support.sample.service.electreTri.steps

import pl.poznan.put.decision_support.sample.service.electre_shared.steps.AggregatorInterface
import java.util.*

class AggregateTriStep : AggregatorInterface {

    /**
     * TODO: no lambda usage right now. Sama macierz bez przydzieleń do klas
     */
    override fun calculate(lambda: Double, stepResult: LinkedList<Any>): Array<Array<Double>> {
        val concordanceTestResults = stepResult[0] //Array<Array<Double>>
        val discordanceTestResults = stepResult[1]
//        TODO: is multiple with acceptable?
        with (concordanceTestResults as Array<Array<Double>>) {
            with(discordanceTestResults as List<Array<Array<Double>>>) {
                val n: Int = concordanceTestResults.size
                val result: Array<Array<Double>> = Array(n) { Array(n) { 0.0 } }

                for (row in concordanceTestResults.indices) {
                    for (column in 0 until concordanceTestResults[row].size) {
                        var multiplier = 1.0
                        for (dMatrix in discordanceTestResults) {
                            if (dMatrix[row][column] > concordanceTestResults[row][column]) {
                                multiplier*=(1.0-dMatrix[row][column])/(1.0-concordanceTestResults[row][column])
                            }
                        }
                        result[row][column] = concordanceTestResults[row][column] * multiplier
                    }
                }
                return result
            }
        }
    }
}