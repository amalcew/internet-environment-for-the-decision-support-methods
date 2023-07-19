package pl.poznan.put.decision_support.sample.service.electre1s.steps

import org.junit.jupiter.api.Assertions.*
import org.junit.jupiter.api.Test
import pl.poznan.put.decision_support.sample.service.electre1s.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre1s.model.Variant
import java.util.*

class DiscordanceTestTest {

    private val discordanceTest = DiscordanceTest()

    @Test
    fun testDiscordance() {
        /*
        Tests discordance test with values from Irmina's Electre1s example paper
         */

        val lambda: Double = 0.6
        val criteria = LinkedList<Criterion>()

        val criterion1 = Criterion()
        criterion1.q = 0.9
        criterion1.p = 2.2
        criterion1.v = 3.0
        criterion1.weight = 1.0
        criterion1.preferenceType = criterion1.PREFERENCE_TYPE_COST
        criteria.add(criterion1)

        val criterion2 = Criterion()
        criterion2.q = 1.0
        criterion2.p = 1.6
        criterion2.v = 3.5
        criterion2.weight = 9.0
        criterion2.preferenceType = criterion2.PREFERENCE_TYPE_GAIN
        criteria.add(criterion2)

        val varian1 = Variant()
        varian1.values = arrayOf(10.8, 4.7)

        val variant2 = Variant()
        variant2.values = arrayOf(8.0, 6.0)

        val variant3 = Variant()
        variant3.values = arrayOf(11.0, 4.8)

        val variants = Array(3) { Variant() }
        variants[0] = varian1
        variants[1] = variant2
        variants[2] = variant3

        val expected: Array<Array<Double>> = arrayOf(
                arrayOf(0.0, 0.0, 0.0),
                arrayOf(0.0, 0.0, 0.0),
                arrayOf(0.0, 1.0, 0.0)
        )

        assertArrayEquals(expected, discordanceTest.calculate(variants, criteria))
    }
}