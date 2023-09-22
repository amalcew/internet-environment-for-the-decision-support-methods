package pl.poznan.put.decision_support.model.domain

data class Dataset(
    var id: Long? = null,
    var name: String? = null,
    val project: Project? = null,
    var criteria: List<Criterion>? = null,
    var variants: List<Variant>? = null,
)