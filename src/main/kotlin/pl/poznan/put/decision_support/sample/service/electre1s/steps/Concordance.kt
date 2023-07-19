package pl.poznan.put.decision_support.sample.service.electre1s.steps

import pl.poznan.put.decision_support.sample.service.electre1s.Kryterium
import pl.poznan.put.decision_support.sample.service.electre1s.Wariant
import pl.poznan.put.decision_support.sample.service.electre1s.exception.InvalidCriteriaException
import java.util.LinkedList
import kotlin.time.times

class Concordance {
    public fun calculate(warianty: Array<Wariant>, kryteria: LinkedList<Kryterium>): Array<Array<Double>> {
        val n = warianty.size

        var allResults: LinkedList<Array<Array<Double>>> = LinkedList()
        for ((kryteriumIndex, kryterium) in kryteria.withIndex()) {
            var results: Array<Array<Double>> = Array(n) { Array(n) { -1.0 } }
            for ((i, wariant) in warianty.withIndex()) {
                for ((j, wariant2) in warianty.withIndex()) {
                    results[i][j] = this.calculateValuePrzewyzszanie(wariant.wartosci[kryteriumIndex], wariant2.wartosci[kryteriumIndex], kryterium)
                }
            }
            allResults.add(results)
        }

        return this.calculateToResultArray(allResults, kryteria)
    }

    private fun calculateToResultArray(allResults: LinkedList<Array<Array<Double>>>, kryteria: LinkedList<Kryterium>): Array<Array<Double>> {
        val n = allResults[0].size
        var result: Array<Array<Double>> = Array(n) { Array(n) { 0.0 } }

        for (i in 0..n-1) {
            for (j in 0..n-1) {
                var sum = 0.0
                var ksum = 0.0
                for ((index, matrix) in allResults.withIndex()) {
                    sum += matrix[i][j]*kryteria[index].weight
                    ksum += kryteria[index].weight
                }
                result[i][j] = sum/ksum
            }
        }
        return result
    }

    private fun calculateValuePrzewyzszanie(wariant1: Double, wariant2: Double, kryterium: Kryterium): Double {
        if (kryterium.preferenceType === kryterium.PREFERENCE_TYPE_GAIN) {
            if (wariant1 >= wariant2 - kryterium.q) {
                return 1.0
            }
            if (wariant1 <= wariant2 - kryterium.p) {
                return 0.0
            }
            var space = kryterium.p - kryterium.q
            var ycurr = wariant2 - wariant1 - kryterium.q
            return 1.0 - ycurr / space
        }
        if (kryterium.preferenceType === kryterium.PREFERENCE_TYPE_COST) {
            if (wariant1 <= wariant2 + kryterium.q) {
                return 1.0
            }
            if (wariant1 >= wariant2 + kryterium.p) {
                return 0.0
            }
            var space = kryterium.p - kryterium.q
            var ycurr = wariant1 - wariant2 - kryterium.q
            return 1.0 - ycurr / space
        }
        throw InvalidCriteriaException("gain or cost only")
    }
}