package pl.poznan.put.decision_support.service.electre1s.steps


import pl.poznan.put.decision_support.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.service.electre_shared.model.Variant
import pl.poznan.put.decision_support.service.electre_shared.steps.DiscordanceShared
import java.util.LinkedList

// TODO: [DiscordanceTest] add comments describing each function and its purpose in the Electre1s algorithm

open class DiscordanceTest : DiscordanceShared() {
    @Throws(pl.poznan.put.decision_support.service.electre1s.exception.InvalidCriteriaException::class)
    override fun calculate(variants: List<Variant>, criteria: List<Criterion>, context: MutableMap<String, Any>): Array<Array<Double>> {
        val allResults = this.calculateShared(variants, criteria)
        /**
         * @var List<Array<Array<Double>>> allResults
         */
        val result = this.calculateToResultArray(allResults as List<Array<Array<Double>>>);
        context["discordance"] = result;
        return result;
    }

    private fun calculateToResultArray(allResults: List<Array<Array<Double>>>): Array<Array<Double>> {
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
    @Throws(pl.poznan.put.decision_support.service.electre1s.exception.InvalidCriteriaException::class)
    override fun validateNegationOfOutranking(variantA: Double, variantB: Double, criterion: Criterion): Double {
        if (criterion.preferenceType == "gain") {
            if (variantB < variantA + criterion.v) {
                return 0.0
            }
            if (variantB >= variantA + criterion.v) {
                return 1.0
            }
        }
        if (criterion.preferenceType == "cost") {
            if (variantB <= variantA - criterion.v) {
                return 1.0
            }
            if (variantB > variantA - criterion.v) {
                return 0.0
            }
        }
        throw pl.poznan.put.decision_support.service.electre1s.exception.InvalidCriteriaException("Preference type only allows for 'gain' or 'cost' types!")
    }
}