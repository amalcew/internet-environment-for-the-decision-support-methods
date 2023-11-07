package pl.poznan.put.decision_support.model.domain.UTA.response

data class UTAResponse(
    val Kendall: List<Int>,
    val errors: List<Int>,
    val optimum: List<Int>,
    val overallValues: List<Double>,
    val ranks: List<Int>,
    val valueFunctions: Map<String, List<List<Double>>>? = null
)