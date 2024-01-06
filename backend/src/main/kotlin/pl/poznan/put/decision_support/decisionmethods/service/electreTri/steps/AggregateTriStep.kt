package pl.poznan.put.decision_support.decisionmethods.service.electreTri.steps

import pl.poznan.put.decision_support.decisionmethods.service.electreTri.model.RelationType
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import java.util.*
import kotlin.collections.ArrayList

class AggregateTriStep : AggregatorInterface {
//    TODO: how does it take opposite in Tri? Spójrz na RelationAggregator :)

    override fun calculate(lambda: Double, stepResult: LinkedList<Any>, context: MutableMap<String, Any>, variantsY: List<Variant>) {
        val concordanceTestResults = stepResult[0] //Array<Array<Double>>
        val discordanceTestResults = stepResult[1]
        with (concordanceTestResults as Array<Array<Double>>) {
            with(discordanceTestResults as List<Array<Array<Double>>>) {
                val x: Int = concordanceTestResults.size
                val y: Int = discordanceTestResults[0][0].size
                var matrix_before_lambda: Array<Array<Double>> = Array(x) { Array(y) { 0.0 } }
                matrix_before_lambda = matrixWithoutLambda(concordanceTestResults, discordanceTestResults, matrix_before_lambda, context)

                var result: Array<Array<Double>> = Array(x) { Array(y) { 0.0 } }
                result = finalMatrix(matrix_before_lambda, lambda, result, context)

                var sMatrix: Array<Array<RelationType>> = Array(x) { Array(y) { RelationType.INDIFFERENT } }
                sMatrix = calculateSMatrix(sMatrix, result, context)
                val classificationOptimistic = classifyOptimistic(sMatrix, variantsY)
                val classificationPessimistic = classifyPessimistic(sMatrix, variantsY)
                context["optimistic"] = classificationOptimistic
                context["pessimistic"] = classificationPessimistic
            }
        }
    }
    private fun classifyOptimistic(sMatrix: Array<Array<RelationType>>, variantsY: List<Variant>): Array<String> {
        val classes = getClasses(variantsY)
        val classification = Array(sMatrix.size - variantsY.size) { "C1" }

        for (a in 0 until sMatrix.size - variantsY.size) {
            for ((t, _) in classes.withIndex()) {
                if (sMatrix[a][t] == RelationType.bSa) {
                    classification[a] = classes[t]
                    break
                }
            }
        }

        return classification
    }

    private fun classifyPessimistic(sMatrix: Array<Array<RelationType>>, variantsY: List<Variant>): Array<String> {
        val classes = getClasses(variantsY)
        val classification = Array(sMatrix.size - variantsY.size) { "C1" }

        for (a in 0 until sMatrix.size - variantsY.size) {
            for (t in classes.size - 1 downTo 0) {
                if (sMatrix[a][t] == RelationType.aSb) {
                    classification[a] = if (t + 1 < classes.size) classes[t + 1] else classes[t]
                    break
                }
            }
        }

        return classification
    }
    private fun calculateSMatrix(sMatrix: Array<Array<RelationType>>, finalMatrix: Array<Array<Double>>, context: MutableMap<String, Any>): Array<Array<RelationType>> {
        for (row in finalMatrix.indices) {
            for (column in finalMatrix[row].indices) {
                when {
                    finalMatrix[row][column] == 1.0 && finalMatrix[column][row] == 1.0 -> {
                        sMatrix[row][column] = RelationType.INDIFFERENT
                    }
                    finalMatrix[row][column] == 1.0 && finalMatrix[column][row] == 0.0 -> {
                        sMatrix[row][column] = RelationType.aSb
                    }
                    finalMatrix[row][column] == 0.0 && finalMatrix[column][row] == 1.0 -> {
                        sMatrix[row][column] = RelationType.bSa
                    }
                    else -> {
                        sMatrix[row][column] = RelationType.CANNOT_COMPARE
                    }
                }
            }
        }
        context["sMatrix"] = sMatrix;
        return sMatrix;
    }

    private fun matrixWithoutLambda(concordanceTestResults: Array<Array<Double>>, discordanceTestResults: List<Array<Array<Double>>>, matrix_before_lambda: Array<Array<Double>>, context: MutableMap<String, Any>): Array<Array<Double>> {
        for (row in concordanceTestResults.indices) {
            for (column in 0 until discordanceTestResults[0][row].size) {
                var multiplier = 1.0
                for (dMatrix in discordanceTestResults) {
                    if (dMatrix[row][column] > concordanceTestResults[row][column]) {
                        multiplier *= (1.0 - dMatrix[row][column]) / (1.0 - concordanceTestResults[row][column])
                    }
                }
                matrix_before_lambda[row][column] = concordanceTestResults[row][column] * multiplier
            }
        }
        context["matrix_before_lambda"] = matrix_before_lambda
        return matrix_before_lambda
    }

    private fun finalMatrix(matrix_before_lambda: Array<Array<Double>>, lambda: Double, result: Array<Array<Double>>, context: MutableMap<String, Any>): Array<Array<Double>> {
        for (row in matrix_before_lambda.indices) {
            for (column in 0 until matrix_before_lambda[row].size) {
                if (matrix_before_lambda[row][column] > lambda) {
                    result[row][column] = 1.0;
                } else {
                    result[row][column] = 0.0;
                }
            }
        }
        context["final"] = result
        return result
    }

    private fun getClasses(discordanceTestResults: List<Variant>): ArrayList<String> {
        val classes = ArrayList<String>()
        val classesNum = discordanceTestResults.size - 1

        for (i in 1..classesNum) {
            classes.add("C$i")
        }
        return classes
    }
}