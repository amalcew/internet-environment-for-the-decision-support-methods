package pl.poznan.put.decision_support.model.domain

import pl.poznan.put.decision_support.model.entity.ProjectEntity

data class User(
    val id: Long? = null,
    val name: String,
    val password: String,
    val url: String,
    val email: String,
    val age: Int,
    val projects: List<ProjectEntity>? = null
)
