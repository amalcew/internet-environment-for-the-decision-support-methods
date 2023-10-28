package pl.poznan.put.decision_support.users.controller

import io.swagger.v3.oas.annotations.OpenAPIDefinition
import io.swagger.v3.oas.annotations.servers.Server
import io.swagger.v3.oas.annotations.tags.Tag
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.beans.factory.annotation.Qualifier
import org.springframework.http.ResponseEntity
import org.springframework.security.crypto.factory.PasswordEncoderFactories
import org.springframework.security.crypto.password.PasswordEncoder
import org.springframework.web.bind.annotation.*
import pl.poznan.put.decision_support.config.utils.JwtTokenUtil
import pl.poznan.put.decision_support.users.model.JwtTokensResponse
import pl.poznan.put.decision_support.users.model.LoginRequest
import pl.poznan.put.decision_support.users.model.User
import pl.poznan.put.decision_support.users.service.UserService


@RestController
@RequestMapping("/auth")
@Qualifier("AuthenticationController")
class AuthController @Autowired constructor(
    private val jwtTokenUtil: JwtTokenUtil,
    private val userService: UserService
) {
    @PostMapping("/login")
    fun login(@RequestBody login: LoginRequest): ResponseEntity<JwtTokensResponse> {
        val passwordEncoder: PasswordEncoder = PasswordEncoderFactories.createDelegatingPasswordEncoder()

        val user = userService.getUserByName(login.email)
        if (user == null || !passwordEncoder.matches(login.password, user.password)) {
            return ResponseEntity.badRequest().build()
        }
        val token = jwtTokenUtil.generateToken(login.email)
        val refreshToken = jwtTokenUtil.generateRefreshToken(login.email)
        return ResponseEntity.ok(JwtTokensResponse(token, refreshToken))
    }
    @PostMapping("/register")
    fun register(@RequestBody user: User): ResponseEntity<JwtTokensResponse> {
        val token = jwtTokenUtil.generateToken(user.email)
        val refreshToken = jwtTokenUtil.generateRefreshToken(user.email)
        val passwordEncoder: PasswordEncoder = PasswordEncoderFactories.createDelegatingPasswordEncoder()
        user.password = passwordEncoder.encode(user.password)
        userService.addUser(user)
        return ResponseEntity.ok(JwtTokensResponse(token, refreshToken))
    }

    @PostMapping("/refresh")
    fun refreshToken(@RequestParam("refreshToken") refreshToken: String): ResponseEntity<JwtTokensResponse> {
        val username = jwtTokenUtil.getUsernameFromToken(refreshToken)

        if (username != null && jwtTokenUtil.validateRefreshToken(refreshToken)) {
            val token = jwtTokenUtil.generateToken(username)
            val newRefreshToken = jwtTokenUtil.generateRefreshToken(username)
            return ResponseEntity.ok(JwtTokensResponse(token, newRefreshToken))
        } else {
            return ResponseEntity.badRequest().build()
        }
    }
}