package pl.poznan.put.decision_support.decisionmethods.model.domain.uta.request

data class UTARequest(
    val alternativesIndifferences: List<List<String>>? = null,
    val alternativesPreferences: List<List<String>>? = null,
    val alternativesRanks: List<Int>? = null,
    val colnamesPerformanceTable: List<String?>,
    val criteriaMinMax: List<String?>,
    val criteriaNumberOfBreakPoints: List<Int?>,
    val epsilon: Double,
    val performanceTable: List<List<Float?>>,
    val rownamesPerformanceTable: List<String?>
)