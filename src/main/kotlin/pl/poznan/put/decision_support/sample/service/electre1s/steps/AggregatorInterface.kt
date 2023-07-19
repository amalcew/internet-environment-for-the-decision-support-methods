package pl.poznan.put.decision_support.sample.service.electre1s.steps

import java.util.*

interface AggregatorInterface {
    fun calculate(lambda: Double, stepResult: LinkedList<Array<Array<Double>>>): Array<Array<Double>>
}