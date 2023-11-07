package pl.poznan.put.decision_support.model.domain

data class DatasetObject(
    val name: String,
    val variants: List<VariantObject>,
    val criteria: List<CriterionObject>
)
