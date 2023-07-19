package pl.poznan.put.decision_support.sample.service.electre1s.steps

import org.junit.jupiter.api.Assertions.*
import org.junit.jupiter.api.Test
import pl.poznan.put.decision_support.DatasetIrmina

class DiscordanceTestTest {

    private val discordanceTest = DiscordanceTest()
    private val datasetIrmina = DatasetIrmina()

    @Test
    fun testDiscordance() {
        /*
        Tests discordance test with values from Irmina's Electre1s example paper
         */

        val expected: Array<Array<Double>> = arrayOf(
                arrayOf(0.0, 0.0, 0.0),
                arrayOf(0.0, 0.0, 0.0),
                arrayOf(0.0, 1.0, 0.0)
        )

        assertArrayEquals(expected, discordanceTest.calculate(datasetIrmina.variants, datasetIrmina.criteria))
    }
}