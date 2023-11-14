package pl.poznan.put.decision_support.model.domain.UTA

import pl.poznan.put.decision_support.decisionmethods.model.domain.Criterion

data class UTAResponse(
    var response: List<CharacteristicPoints>
)

data class CharacteristicPoints(
    val characteristicPoints: List<Point>,
    val criterion: Criterion
)
data class Point(
    val x: Double,
    val y: Double
)