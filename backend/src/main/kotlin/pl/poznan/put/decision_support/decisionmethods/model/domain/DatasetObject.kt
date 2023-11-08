package pl.poznan.put.decision_support.decisionmethods.model.domain

data class DatasetObject(
    val name: String,
    val variants: List<VariantObject>,
    val criteria: List<CriterionObject>
)
