package pl.poznan.put.decision_support.model.domain

data class Project(
    val id: Long? = null,
    val name: String? = null,
    val user: User? = null,
    val dataset: Dataset? = null
)
