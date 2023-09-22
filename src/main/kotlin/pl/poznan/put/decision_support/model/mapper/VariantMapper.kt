package pl.poznan.put.decision_support.model.mapper

import pl.poznan.put.decision_support.model.domain.CriterionValue
import pl.poznan.put.decision_support.model.domain.Variant
import pl.poznan.put.decision_support.model.entity.VariantCriterionValueEntity
import pl.poznan.put.decision_support.model.entity.VariantEntity

fun Variant.toVariantEntityMapper() = VariantEntity(
    id = id,
    name = name
)

//TODO passing values
fun VariantEntity.toVariant(values: List<VariantCriterionValueEntity> = listOf()) = Variant(
    id = id,
    name = name,
    criteriaValues = values.map {
        CriterionValue(
            criterion = it.criterion?.toCriterionMapper(),
            value = it.value
        )
    }
)