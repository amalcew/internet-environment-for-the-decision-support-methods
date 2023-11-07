package pl.poznan.put.decision_support.service.electreTri.steps

import pl.poznan.put.decision_support.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.service.electre_shared.model.Variant
import pl.poznan.put.decision_support.service.electre_shared.steps.DiscordanceShared
import java.util.LinkedList

// TODO: [DiscordanceTest] add comments describing each function and its purpose in the Electre1s algorithm

class DiscordanceTriTest : DiscordanceShared() {
    @Throws(InvalidCriteriaException::class)
    override fun calculate(variantsX: List<Variant>, variantsY: List<Variant>, criteria: List<Criterion>, context: MutableMap<String, Any>): LinkedList<Array<Array<Double>>>
    {
        val allResults = this.calculateShared(variantsX, variantsY, criteria)
        context["discordance"] = allResults;
        return allResults as  LinkedList<Array<Array<Double>>>;
    }

    @Throws(InvalidCriteriaException::class)
    override fun validateNegationOfOutranking(variantA: Double, variantB: Double, criterion: Criterion): Double {
        if (criterion.preferenceType == "gain") {
            if (variantB < variantA + criterion.v) {
                return 0.0
            }
            if (variantB >= variantA + criterion.v) {
                return 1.0
            }
//            TODO: check math
            val space = criterion.v - criterion.p
            val yCurr = variantB - variantA - criterion.p
            return 1.0 - yCurr / space
        }
        if (criterion.preferenceType == "cost") {
            if (variantB <= variantA - criterion.v) {
                return 1.0
            }
            if (variantB > variantA - criterion.v) {
                return 0.0
            }
            val space = criterion.v - criterion.p
            val yCurr = variantB - variantA - criterion.p
            return 1.0 - yCurr / space
        }
        throw InvalidCriteriaException("Preference type only allows for 'gain' or 'cost' types!")
    }
}