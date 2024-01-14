package pl.poznan.put.decision_support

import org.junit.jupiter.api.Assertions.assertEquals
import org.junit.jupiter.api.Test
import pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator.LinearFunction
import pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator.Point

class LinearFunctionTest {

    @Test
    fun testGetY() {
        val point1 = Point(1.0F, 2.0F)
        val point2 = Point(3.0F, 6.0F)
        val x = 2.0F

        val result = LinearFunction.getY(point1, point2, x)

        assertEquals(4.0F, result, 0.0001F)
    }

    @Test
    fun testGetYWithNullValues() {
        val point1 = Point(null, 2.0F)
        val point2 = Point(3.0F, null)
        val x = 2.0F

        val result = LinearFunction.getY(point1, point2, x)

        assertEquals(0.0F, result, 0.0001F)
    }

}