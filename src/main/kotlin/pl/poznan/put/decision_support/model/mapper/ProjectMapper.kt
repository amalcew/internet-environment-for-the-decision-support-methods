package pl.poznan.put.decision_support.model.mapper

import pl.poznan.put.decision_support.model.domain.Project
import pl.poznan.put.decision_support.model.entity.ProjectEntity

fun Project.mapToProjectEntity() = ProjectEntity(
    name = name,
)

fun ProjectEntity.mapToProject() = Project(
    id = id,
    name = name,
    user = user?.mapToUser(),
    dataset = dataset?.mapToDataset()
)
