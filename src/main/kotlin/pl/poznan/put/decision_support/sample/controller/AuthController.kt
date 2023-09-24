package pl.poznan.put.decision_support.sample.controller

import org.springframework.beans.factory.annotation.Autowired
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestMapping
import org.springframework.web.bind.annotation.RequestParam
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.config.utils.JwtTokenUtil


@RestController
@RequestMapping("/auth")
class AuthController {
    @Autowired
    private val jwtTokenUtil: JwtTokenUtil? = null
    @PostMapping("/login")
    fun login(@RequestParam username: String?, @RequestParam password: String?): ResponseEntity<String> {
        // Validate username and password (e.g., against a user database)
        // If valid, generate a JWT token and return it
        val token = jwtTokenUtil!!.generateToken(username)
        return ResponseEntity.ok(token)
    }
}