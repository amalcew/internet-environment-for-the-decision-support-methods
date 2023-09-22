package pl.poznan.put.decision_support.model.domain

import pl.poznan.put.decision_support.model.entity.CriterionEntity

data class CriterionObject(
    val name: String
)

fun CriterionObject.toCriterion() = CriterionEntity(name = name)