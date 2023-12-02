package pl.poznan.put.decision_support.service.electre_shared.steps

import java.util.*

interface AggregatorInterface {
    fun calculate(lambda: Double, stepResult: LinkedList<Any>, context: MutableMap<String, Any>)
}