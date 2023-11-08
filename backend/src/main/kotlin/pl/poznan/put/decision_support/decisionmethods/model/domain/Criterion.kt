package pl.poznan.put.decision_support.decisionmethods.model.domain

data class Criterion(
    var id: Long? = null,
    val name: String? = null,
    val type: CriterionType? = null
)
