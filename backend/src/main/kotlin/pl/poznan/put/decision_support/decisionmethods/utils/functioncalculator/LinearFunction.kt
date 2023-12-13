package pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator

import kotlin.math.abs

object LinearFunction {

    fun getY(point1: Point, point2: Point, x: Float): Float {
        return if (point1.x != null && point2.x != null && point1.y != null && point2.y != null) {
            val slope = abs(point2.y - point1.y) / abs(point2.x - point1.x)
            val yIntercept = point1.y - slope * point1.x
            slope * x + yIntercept
        } else 0F
    }
}