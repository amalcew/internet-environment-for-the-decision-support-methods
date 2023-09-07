package pl.poznan.put.decision_support.controller

import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.model.Project
import pl.poznan.put.decision_support.model.User
import pl.poznan.put.decision_support.service.UserService

@RestController
class UserController(
    private val userService: UserService
) {

    @GetMapping("/users")
    fun getAllUsers(): MutableIterable<User?> {
        return userService.getAllUser()
    }

    @PostMapping("/users")
    fun saveUser(@RequestBody user: User): ResponseEntity<User> {
        val createdProject = userService.addUser(user)
        return ResponseEntity(createdProject, HttpStatus.CREATED)
    }
}