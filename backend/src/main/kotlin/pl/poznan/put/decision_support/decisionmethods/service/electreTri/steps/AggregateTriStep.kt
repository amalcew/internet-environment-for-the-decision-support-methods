package pl.poznan.put.decision_support.service.electreTri.steps

import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import java.util.*

class AggregateTriStep : AggregatorInterface {
//    TODO: how does it take opposite in Tri? Spójrz na RelationAggregator :)

    override fun calculate(lambda: Double, stepResult: LinkedList<Any>, context: MutableMap<String, Any>) {
        val concordanceTestResults = stepResult[0] //Array<Array<Double>>
        val discordanceTestResults = stepResult[1]
        with (concordanceTestResults as Array<Array<Double>>) {
            with(discordanceTestResults as List<Array<Array<Double>>>) {
                val x: Int = concordanceTestResults.size
                val y: Int = concordanceTestResults[0].size
                val matrix_before_lambda: Array<Array<Double>> = Array(x) { Array(y) { 0.0 } }

                for (row in concordanceTestResults.indices) {
                    for (column in 0 until concordanceTestResults[row].size) {
                        var multiplier = 1.0
                        for (dMatrix in discordanceTestResults) {
                            if (dMatrix[row][column] > concordanceTestResults[row][column]) {
                                multiplier*=(1.0-dMatrix[row][column])/(1.0-concordanceTestResults[row][column])
                            }
                        }
                        matrix_before_lambda[row][column] = concordanceTestResults[row][column] * multiplier
                    }
                }
                context["matrix_before_lambda"] = matrix_before_lambda;

                val result: Array<Array<Double>> = Array(x) { Array(y) { 0.0 } }

                for (row in matrix_before_lambda.indices) {
                    for (column in 0 until matrix_before_lambda[row].size) {
                        if(matrix_before_lambda[row][column] > lambda) {
                            result[row][column] = 1.0;
                        } else {
                            result[row][column] = 0.0;
                        }
                    }
                }
                context["final"] = result;
            }
        }
    }
}