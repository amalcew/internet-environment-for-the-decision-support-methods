package pl.poznan.put.decision_support.service.electre1s.steps

import pl.poznan.put.decision_support.decisionmethods.exception.InvalidShapeException
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import java.util.*

class RelationAggregator : AggregatorInterface {
//    TODO: how does it take opposite in Tri? Is it another table bRa? -> Spytać kogoś mądrego, bo nie ma w pdfach...
    /**
     * based on 'final' in context
     */
    override fun calculate(
        lambda: Double,
        stepResult: LinkedList<Any>,
        context: MutableMap<String, Any>
    ) {
        val final: Array<Array<Double>> = context["final"] as Array<Array<Double>>;
        val x: Int = final.size;
        val y: Int = final[0].size
        if (x != y) {
            throw InvalidShapeException("matrix has to be a square");
        }

        val relations: Array<Array<String>> = Array(x) { Array(x) { "?" } }

        for (row in final.indices) {
            for (column in 0 until final[row].size) {
                val aSb = final[row][column]
                val bSa = final[column][row]
                if (aSb == 1.0 && bSa == 1.0) {
                    relations[row][column] = "I"
                } else if (aSb == 1.0 && bSa == 0.0) {
                    relations[row][column] = "P"
                } else if (aSb == 0.0 && bSa == 1.0) {
                    relations[row][column] = "-P"
                } else if (aSb == 0.0 && bSa == 0.0) {
                    relations[row][column] = "R"
                }

            }
        }
        context["relations"] = relations
    }
}