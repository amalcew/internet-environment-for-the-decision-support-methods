package pl.poznan.put.decision_support.sample.service.electre1s.steps

import pl.poznan.put.decision_support.sample.service.electre1s.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre1s.model.Variant
import pl.poznan.put.decision_support.sample.service.electre1s.exception.InvalidCriteriaException
import java.util.LinkedList

// TODO: [DiscordanceTest] add comments describing each function and its purpose in the Electre1s algorithm

class DiscordanceTest {
    public fun calculate(variants: Array<Variant>, criteria: LinkedList<Criterion>): Array<Array<Double>> {
        val n = variants.size

        val allResults: LinkedList<Array<Array<Double>>> = LinkedList()
        for ((criterionIndex, criterion) in criteria.withIndex()) {
            val results: Array<Array<Double>> = Array(n) { Array(n) { -1.0 } }
            for ((i, variantA) in variants.withIndex()) {
                for ((j, variantB) in variants.withIndex()) {
                    results[i][j] = this.validateNegationOfOutranking(variantA.values[criterionIndex], variantB.values[criterionIndex], criterion)
                }
            }
            allResults.add(results)
        }

        return this.calculateToResultArray(allResults)
    }

    private fun calculateToResultArray(allResults: LinkedList<Array<Array<Double>>>): Array<Array<Double>> {
        val n = allResults[0].size
        val result: Array<Array<Double>> = Array(n) { Array(n) { 0.0 } }

        for (i in 0 until n) {
            for (j in 0 until n) {
                var negateOutranking = 0.0
                for (matrix in allResults) {
                    if (matrix[i][j] > 0.0) {
                        negateOutranking = 1.0
                    }
                }
                result[i][j] = negateOutranking
            }
        }
        return result
    }

    private fun validateNegationOfOutranking(variantA: Double, variantB: Double, criterion: Criterion): Double {
        if (criterion.preferenceType === criterion.PREFERENCE_TYPE_GAIN) {
            if (variantB < variantA + criterion.v) {
                return 0.0
            }
            if (variantB >= variantA + criterion.v) {
                return 1.0
            }
        }
        if (criterion.preferenceType === criterion.PREFERENCE_TYPE_COST) {
            if (variantB <= variantA - criterion.v) {
                return 1.0
            }
            if (variantB > variantA - criterion.v) {
                return 0.0
            }
        }
        throw InvalidCriteriaException("gain or cost only")  // TODO: [calculateValueOfOutranking()] change InvalidCriteriaException message to more meaningful
    }
}