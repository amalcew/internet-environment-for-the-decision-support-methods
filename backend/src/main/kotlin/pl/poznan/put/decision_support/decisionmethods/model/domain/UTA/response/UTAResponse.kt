package pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.response

data class UTAResponse(
    val Kendall: Kendall? = null,
    val errors: List<Float>,
    val optimum: List<Float>,
    val overallValues: List<Float>,
    val ranks: List<Int>,
    val valueFunctions: Map<String, List<List<Double>>>? = null
)

data class Kendall(
    val value: Int? = null
)