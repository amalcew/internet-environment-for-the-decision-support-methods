package pl.poznan.put.decision_support.service.project

import org.springframework.stereotype.Service
import pl.poznan.put.decision_support.model.Project
import pl.poznan.put.decision_support.repository.ProjectRepository

@Service
class ProjectService(
    private val projectRepository: ProjectRepository
) {
    fun getAll(): List<Project?> = projectRepository.findAll().toList()

    fun save(project: Project) = projectRepository.save(project)

    fun findById(id: Long) = projectRepository.findById(id)

    fun existsById(id: Long) = projectRepository.existsById(id)

    fun deleteById(id: Long) = projectRepository.deleteById(id)
}