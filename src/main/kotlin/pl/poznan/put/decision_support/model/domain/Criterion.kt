package pl.poznan.put.decision_support.model.domain

import pl.poznan.put.decision_support.model.entity.CriterionType

data class Criterion(
    var id: Long? = null,
    val name: String? = null,
    val type: CriterionType? = null
)
