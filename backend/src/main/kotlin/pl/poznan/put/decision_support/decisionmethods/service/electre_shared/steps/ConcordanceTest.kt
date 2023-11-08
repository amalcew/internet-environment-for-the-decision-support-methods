package pl.poznan.put.decision_support.service.electre_shared.steps

import pl.poznan.put.decision_support.decisionmethods.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant
import java.util.LinkedList

// TODO: [ConcordanceTest] add comments describing each function and its purpose in the Electre1s algorithm

class ConcordanceTest : TestStepInterface {
    @Throws(InvalidCriteriaException::class)
    override fun calculate(variantsX: List<Variant>, variantsY: List<Variant>, criteria: List<Criterion>, context: MutableMap<String, Any>): Array<Array<Double>> {
        val x = variantsX.size
        val y = variantsY.size

        val allResults: LinkedList<Array<Array<Double>>> = LinkedList()
        for ((criterionIndex, criterion) in criteria.withIndex()) {
            val results: Array<Array<Double>> = Array(x) { Array(y) { -1.0 } }
            for ((i, variantA) in variantsX.withIndex()) {
                for ((j, variantB) in variantsY.withIndex()) {
                    results[i][j] = this.calculateValueOfOutranking(variantA.values[criterionIndex], variantB.values[criterionIndex], criterion)
                }
            }
            allResults.add(results)
        }
        val result = this.calculateToResultArray(allResults, criteria);
        context["concordance"] = result
        return result;
    }

    private fun calculateToResultArray(allResults: List<Array<Array<Double>>>, criteria: List<Criterion>): Array<Array<Double>> {
        val n = allResults[0].size
        val result: Array<Array<Double>> = Array(n) { Array(n) { 0.0 } }

        for (i in 0 until n) {
            for (j in 0 until n) {
                var sum = 0.0
                var ksum = 0.0
                for ((index, matrix) in allResults.withIndex()) {
                    sum += matrix[i][j]*criteria[index].weight
                    ksum += criteria[index].weight
                }
                result[i][j] = sum/ksum
            }
        }
        return result
    }

    @Throws(InvalidCriteriaException::class)
    private fun calculateValueOfOutranking(variantA: Double, variantB: Double, criterion: Criterion): Double {
        if (criterion.preferenceType == "gain") {
            if (variantA >= variantB - criterion.q) {
                return 1.0
            }
            if (variantA <= variantB - criterion.p) {
                return 0.0
            }
            val space = criterion.p - criterion.q
            val yCurr = variantB - variantA - criterion.q
            return 1.0 - yCurr / space
        }
        if (criterion.preferenceType == "cost") {
            if (variantA <= variantB + criterion.q) {
                return 1.0
            }
            if (variantA >= variantB + criterion.p) {
                return 0.0
            }
            val space = criterion.p - criterion.q
            val yCurr = variantA - variantB - criterion.q
            return 1.0 - yCurr / space
        }
        throw InvalidCriteriaException("Preference type only allows for 'gain' or 'cost' types!")
    }
}