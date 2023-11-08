package pl.poznan.put.decision_support.model.domain

import pl.poznan.put.decision_support.decisionmethods.model.domain.Criterion

data class Variant(
    var id: Long? = null,
    val name: String? = null,
    val criteriaValues: List<CriterionValue>? = null
)

data class CriterionValue(
    val criterion: Criterion?,
    val value: Double?
)