package pl.poznan.put.decision_support.model.mapper

import pl.poznan.put.decision_support.model.domain.Dataset
import pl.poznan.put.decision_support.model.entity.DatasetEntity
import pl.poznan.put.decision_support.model.entity.VariantCriterionValueEntity

fun DatasetEntity.mapToDataset(values: List<VariantCriterionValueEntity> = listOf()) = Dataset(
    id = id,
    name = name,
    criteria = criteria?.map { it.toCriterionMapper() },
    variants = variants?.map { it.toVariant(values) },
)

fun Dataset.toDatasetEntity() = DatasetEntity(
    name = name,
)