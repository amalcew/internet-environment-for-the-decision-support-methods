package pl.poznan.put.decision_support.controller

import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.stereotype.Controller
import org.springframework.web.bind.annotation.*
import pl.poznan.put.decision_support.model.Project
import pl.poznan.put.decision_support.service.project.ProjectService

@Controller
class ProjectController(
    private val projectService: ProjectService
) {
    @GetMapping("/project")
    fun getAllProjects(): List<Project?> {
        return projectService.getAll()
    }

    @PostMapping("/project")
    fun createProject(@RequestBody Project: Project): ResponseEntity<Project> {
        val createdProject = projectService.save(Project)
        return ResponseEntity(createdProject, HttpStatus.CREATED)
    }

    @GetMapping("/project/{id}")
    fun getProjectById(id: Long): ResponseEntity<Project> {
        val project = projectService.findById(id).orElse(null)
        return if (project != null) ResponseEntity(project, HttpStatus.OK)
        else ResponseEntity(HttpStatus.NOT_FOUND)
    }


    @PutMapping("/project/{id}")
    fun updateProjectById(@PathVariable("id") ProjectId: Long, @RequestBody Project: Project): ResponseEntity<Project> {

        val existingProject =
            projectService.findById(ProjectId).orElse(null) ?: return ResponseEntity(HttpStatus.NOT_FOUND)

        val updatedProject = existingProject.copy(name = Project.name)
        projectService.save(updatedProject)
        return ResponseEntity(updatedProject, HttpStatus.OK)
    }

    @DeleteMapping("/project/{id}")
    fun deleteProjectById(@PathVariable("id") ProjectId: Long): ResponseEntity<Project> {
        if (!projectService.existsById(ProjectId)) {
            return ResponseEntity(HttpStatus.NOT_FOUND)
        }
        projectService.deleteById(ProjectId)
        return ResponseEntity(HttpStatus.NO_CONTENT)
    }
}