package pl.poznan.put.decision_support.users.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
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

    @PostMapping("/users")
    fun addUser(): User {
        val user = User(
            name = "John",
            password = "Doe",
            email = "",
            url = "",
            age = 0
        )
        return userService.addUser(user)
    }
}