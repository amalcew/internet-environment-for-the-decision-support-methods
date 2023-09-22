package pl.poznan.put.decision_support.model.mapper

import pl.poznan.put.decision_support.model.domain.Criterion
import pl.poznan.put.decision_support.model.entity.CriterionEntity

fun CriterionEntity.toCriterionMapper() = Criterion(
    id = id,
    name = name,
    type = type
)

fun Criterion.toCriterionEntity() = CriterionEntity(
    id = id,
    name = name,
    type = type
)