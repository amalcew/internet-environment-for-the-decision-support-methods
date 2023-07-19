package pl.poznan.put.decision_support.sample.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.sample.service.electre1s.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre1s.Electre1s
import pl.poznan.put.decision_support.sample.service.electre1s.model.Variant
import java.util.LinkedList

@RestController
class Electre1sController() {

    val electre1s = Electre1s()
    @GetMapping("/electre1s")
    fun run(): Array<Array<Double>> {
        val lambda: Double = 0.6
        val kryteria = LinkedList<Criterion>()

        val kryterium1 = Criterion()
        kryterium1.q = 0.9
        kryterium1.p = 2.2
        kryterium1.v = 3.0
        kryterium1.weight = 1.0
        kryterium1.preferenceType = kryterium1.PREFERENCE_TYPE_COST
        kryteria.add(kryterium1)

        val kryterium2 = Criterion()
        kryterium2.q = 1.0
        kryterium2.p = 1.6
        kryterium2.v = 3.5
        kryterium2.weight = 9.0
        kryterium2.preferenceType = kryterium2.PREFERENCE_TYPE_GAIN
        kryteria.add(kryterium2)

        val wariant1 = Variant()
        wariant1.values = arrayOf(10.8, 4.7)

        val wariant2 = Variant()
        wariant2.values = arrayOf(8.0, 6.0)

        val wariant3 = Variant()
        wariant3.values = arrayOf(11.0, 4.8)

        val warianty = Array(3) { Variant() }
        warianty[0] = wariant1
        warianty[1] = wariant2
        warianty[2] = wariant3

        return electre1s.calculate(warianty, kryteria, lambda)
    }
}