package pl.poznan.put.decision_support.decisionmethods.service.UTA

import pl.poznan.put.decision_support.decisionmethods.model.domain.uta.request.UTARequest
import pl.poznan.put.decision_support.decisionmethods.model.domain.uta.response.UTAResponse
import pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator.LinearFunction
import pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator.Point
import pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator.round
import java.lang.Integer.max
import java.lang.Integer.min


class UTACalculator {

    fun calculate(utaRequest: UTARequest, utaResponse: UTAResponse): UTAResponse {
        val resultMap = mutableMapOf<String, List<Float?>>()

        for (i in utaRequest.performanceTable.indices) {
            utaRequest.rownamesPerformanceTable[i]?.let {
                resultMap[it] = utaRequest.performanceTable[i]
            }
        }
        val overallCompleted = mutableListOf<Float>()
        val valueFunctions = getAscendingValues(utaRequest, utaResponse)

        for (alternative in utaRequest.rownamesPerformanceTable) { // ["RER","METRO1","METRO2","BUS","TAXI"] //TODO remove
            val yValues = mutableListOf<Double>()
            utaRequest.colnamesPerformanceTable.forEachIndexed { i, criteria -> // ["Price","Time","Comfort"] //TODO remove
                val value = resultMap[alternative]?.get(i)
                val valueFunctionsX = valueFunctions.get(criteria)?.get(0)
                val valueFunctionsY = valueFunctions.get(criteria)?.get(1)
                for (valueRange in 0..(valueFunctionsX?.size?.minus(2) ?: 0)) {
                    val currentX = valueFunctionsX?.get(valueRange)?.toFloat() ?: 0
                    val currentY = valueFunctionsY?.get(valueRange)?.toFloat() ?: 0
                    val nextX = (valueFunctionsX?.get(valueRange + 1) ?: 0)?.toFloat()
                    val nextY = (valueFunctionsY?.get(valueRange + 1) ?: 0)?.toFloat()
                    if (currentX != null && currentY != null && nextX != null && nextY != null && valueFunctionsX != null) {
                        val minValue = min(
                            valueFunctionsX[valueRange].toInt(),
                            valueFunctionsX[valueRange + 1].toInt()
                        )
                        val maxValue = max(
                            valueFunctionsX[valueRange].toInt(),
                            valueFunctionsX[valueRange + 1].toInt()
                        )
                        if ((minValue..maxValue).contains(value?.toInt())) value?.let {
                            val yvale = LinearFunction.getY(
                                Point(currentX.toFloat(), currentY.toFloat()), Point(nextX, nextY),
                                it
                            )
                            yValues.add((yvale.toDouble()))
                        }
                    }

                }

            }
            val overallVal = (yValues.sum()).round(3)
            overallCompleted.add(overallVal)
        }


        with(utaResponse) {
            return UTAResponse(
                Kendall,
                errors,
                optimum,
                overallCompleted,
                mapValuesToRankingPositions(overallCompleted),
                valueFunctions
            )
        }
    }

    private fun getAscendingValues(utaRequest: UTARequest, utaResponse: UTAResponse) : Map<String, List<List<Double>>>{
        val valueFunctions = mutableMapOf<String, List<List<Double>>>()
        utaRequest.colnamesPerformanceTable.forEachIndexed { i, criteria ->
            if (utaRequest.criteriaMinMax[i] == "min") {
                val xCol = utaResponse.valueFunctions?.get(criteria)?.get(0)?.reversed() ?: listOf()
                val yCol = utaResponse.valueFunctions?.get(criteria)?.get(1)?.reversed() ?: listOf()
                val cols = listOf(xCol, yCol)
                criteria?.let { valueFunctions[criteria] = cols }
            } else {
                criteria?.let { valueFunctions[criteria] = utaResponse.valueFunctions?.get(criteria) ?: listOf() }
            }
        }
        return valueFunctions
    }

    private fun mapValuesToRankingPositions(values: List<Float>): List<Int> {
        val sortedDoubles = values.sortedDescending()
        val rankingPositionsMap = mutableMapOf<Float, Int>()

        for (i in sortedDoubles.indices) {
            if (!rankingPositionsMap.containsKey(sortedDoubles[i])) {
                if (rankingPositionsMap.isEmpty()) {
                    rankingPositionsMap[sortedDoubles[i]] = i + 1
                } else {
                    rankingPositionsMap[sortedDoubles[i]] = rankingPositionsMap.values.max() + 1
                }

            }
        }

        val rankingPositions = mutableListOf<Int>()

        for (value in values) {
            rankingPositionsMap[value]?.let {
                rankingPositions.add(it)
            }
        }

        return rankingPositions
    }
}