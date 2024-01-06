package pl.poznan.put.decision_support.service.electre_shared.steps

import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant
import java.util.*

interface AggregatorInterface {
    fun calculate(lambda: Double, stepResult: LinkedList<Any>, context: MutableMap<String, Any>, variantsY: List<Variant>)
}