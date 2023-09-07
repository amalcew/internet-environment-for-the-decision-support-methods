package pl.poznan.put.decision_support.model.domain

import pl.poznan.put.decision_support.model.Criterion

data class CriterionObject(
    val name: String
)

fun CriterionObject.toCriterion() = Criterion(name = name)