package pl.poznan.put.decision_support.sample.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.sample.model.User
import pl.poznan.put.decision_support.sample.service.UserService
import pl.poznan.put.decision_support.sample.service.electre1s.Electre1sCalculator
import pl.poznan.put.decision_support.sample.service.electre1s.Kryterium
import pl.poznan.put.decision_support.sample.service.electre1s.Wariant
import pl.poznan.put.decision_support.sample.service.electre1s.steps.Concordance
import java.util.LinkedList

@RestController
class Electre1sController() {

    @GetMapping("/electre1s")
    fun getAllUsers(): Array<Array<Double>> {
        var calculator = Concordance()
        var kryteria = LinkedList<Kryterium>()
        var kryterium1 = Kryterium()
        kryterium1.q = 0.9
        kryterium1.p = 2.2
        kryterium1.weight = 1.0
        kryterium1.preferenceType = kryterium1.PREFERENCE_TYPE_COST
        kryteria.add(kryterium1)
        var kryterium2 = Kryterium()
        kryterium2.q = 1.0
        kryterium2.p = 1.6
        kryterium2.weight = 9.0
        kryterium2.preferenceType = kryterium2.PREFERENCE_TYPE_GAIN
        kryteria.add(kryterium2)
        var wariant1 = Wariant()
        wariant1.wartosci = arrayOf(10.8, 4.7)
        var wariant2 = Wariant()
        wariant2.wartosci = arrayOf(8.0, 6.0)
        var wariant3 = Wariant()
        wariant3.wartosci = arrayOf(11.0, 4.8)

        var warianty = Array(3) { Wariant() }
        warianty[0] = wariant1
        warianty[1] = wariant2
        warianty[2] = wariant3

        val res = calculator.calculate(warianty, kryteria)

        return res
    }
}