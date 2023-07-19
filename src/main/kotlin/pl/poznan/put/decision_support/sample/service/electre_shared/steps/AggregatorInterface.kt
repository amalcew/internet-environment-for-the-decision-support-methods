package pl.poznan.put.decision_support.sample.service.electre_shared.steps

import java.util.*

interface AggregatorInterface {
    fun calculate(lambda: Double, stepResult: LinkedList<Any>): Array<Array<Double>>
}