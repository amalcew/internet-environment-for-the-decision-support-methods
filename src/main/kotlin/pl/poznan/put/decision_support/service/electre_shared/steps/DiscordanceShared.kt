package pl.poznan.put.decision_support.service.electre_shared.steps

import pl.poznan.put.decision_support.service.electre1s.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.service.electre_shared.model.Variant
import java.util.*

abstract class DiscordanceShared : TestStepInterface {
    fun calculateShared(variants: List<Variant>, criteria: List<Criterion>): Any {
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
        return allResults
    }
    @Throws(InvalidCriteriaException::class)
    protected abstract fun validateNegationOfOutranking(variantA: Double, variantB: Double, criterion: Criterion): Double
}