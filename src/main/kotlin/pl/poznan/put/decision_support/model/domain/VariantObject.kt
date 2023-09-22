package pl.poznan.put.decision_support.model.domain

import pl.poznan.put.decision_support.model.entity.VariantEntity

data class VariantObject(
    val name: String,
    val values: List<Double>
)

fun VariantObject.toVariant() = VariantEntity(name = name)