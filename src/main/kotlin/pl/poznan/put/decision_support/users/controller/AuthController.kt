package pl.poznan.put.decision_support.users.controller

import org.springframework.beans.factory.annotation.Autowired
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestMapping
import org.springframework.web.bind.annotation.RequestParam
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.config.utils.JwtTokenFilter
import pl.poznan.put.decision_support.config.utils.JwtTokenUtil
import pl.poznan.put.decision_support.users.model.User
import pl.poznan.put.decision_support.users.service.UserService


@RestController
@RequestMapping("/auth")
class AuthController @Autowired constructor(
    private val jwtTokenUtil: JwtTokenUtil,
    private val userService: UserService
) {
    @PostMapping("/login")
    fun login(@RequestParam username: String?, @RequestParam password: String?): ResponseEntity<String> {
        // Validate username and password (e.g., against a user database)
        // If valid, generate a JWT token and return it
        val token = jwtTokenUtil.generateToken(username)
        return ResponseEntity.ok(token)
    }
    @PostMapping("/register")
    fun register(@RequestParam username: String?, @RequestParam password: String?): ResponseEntity<String> {
        //todo create user in db
        val token = jwtTokenUtil.generateToken(username)
        return ResponseEntity.ok(token)
    }
}