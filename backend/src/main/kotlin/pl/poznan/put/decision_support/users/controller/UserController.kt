package pl.poznan.put.decision_support.users.controller

import io.swagger.v3.oas.annotations.OpenAPIDefinition
import io.swagger.v3.oas.annotations.servers.Server
import io.swagger.v3.oas.annotations.tags.Tag
import org.springframework.web.bind.annotation.DeleteMapping
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RequestParam
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.users.model.User
import pl.poznan.put.decision_support.users.service.UserService

@RestController("api/v1")
class UserController(
    private val userService: UserService
) {

    @GetMapping("/users")
    fun getAllUsers(): MutableIterable<User?> {
        return userService.getAllUser()
    }

    @GetMapping("/users/{name}")
    fun getUserByName(@RequestParam name: String): User? {
        return userService.getUserByName(name)
    }

    @PostMapping("/users")
    fun addUser(@RequestBody user: User): User? {
        return userService.addUser(user)
    }

    @PostMapping("/users/")
    fun updateUser(@RequestBody user: User): User? {
        return userService.updateUser(user)
    }

    @DeleteMapping("/users")
    fun deleteUser(@RequestBody user: User) {
        userService.deleteUser(user)
    }
}