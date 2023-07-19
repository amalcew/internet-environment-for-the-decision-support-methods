package pl.poznan.put.decision_support.sample.service.electre1s

import pl.poznan.put.decision_support.sample.service.electre1s.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre1s.model.Variant
import pl.poznan.put.decision_support.sample.service.electre1s.steps.ConcordanceTest
import pl.poznan.put.decision_support.sample.service.electre1s.steps.DiscordanceTest

import java.util.*

// TODO: [Electre1s] add comments describing each function and its purpose in the Electre1s algorithm

class Electre1s {
    public fun calculate(variants: Array<Variant>, criteria: LinkedList<Criterion>, lambda: Double): Array<Array<Double>> {
        val concordanceTest = ConcordanceTest()
        val discordanceTest = DiscordanceTest()

        val cTestResults = concordanceTest.calculate(variants, criteria)
        val dTestResults = discordanceTest.calculate(variants, criteria)
        val res = this.aggregateTests(cTestResults, dTestResults, lambda)

        return res
    }

    private fun aggregateTests(concordanceTestResults: Array<Array<Double>>, discordanceTestResults: Array<Array<Double>>, lambda: Double): Array<Array<Double>> {
        val n: Int = concordanceTestResults.size
        val result: Array<Array<Double>> = Array(n) { Array(n) { 0.0 } }

        for (row in concordanceTestResults.indices) {
            for (column in 0 until concordanceTestResults[row].size) {
                if (concordanceTestResults[row][column] >= lambda && discordanceTestResults[row][column] != 1.0) {
                    result[row][column] = 1.0
                } else {
                    result[row][column] = 0.0
                }
            }
        }

        return result
    }
}