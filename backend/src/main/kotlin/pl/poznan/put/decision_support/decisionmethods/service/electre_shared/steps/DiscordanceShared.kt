package pl.poznan.put.decision_support.service.electre_shared.steps

import pl.poznan.put.decision_support.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.service.electre_shared.model.Variant
import java.util.*

abstract class DiscordanceShared : TestStepInterface {
    fun calculateShared(variantsX: List<Variant>, variantsY: List<Variant>, criteria: List<Criterion>): Any {
        val x = variantsX.size
        val y = variantsY.size
        val allResults: LinkedList<Array<Array<Double>>> = LinkedList()
        for ((criterionIndex, criterion) in criteria.withIndex()) {
            val results: Array<Array<Double>> = Array(x) { Array(y) { -1.0 } }
            for ((i, variantA) in variantsX.withIndex()) {
                for ((j, variantB) in variantsY.withIndex()) {
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