package pl.poznan.put.decision_support.config.utils

import io.jsonwebtoken.Claims
import io.jsonwebtoken.Jwts
import io.jsonwebtoken.SignatureAlgorithm
import org.springframework.beans.factory.annotation.Value
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken
import org.springframework.security.core.Authentication
import org.springframework.security.core.userdetails.User
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.stereotype.Component
import java.util.*


@Component
class JwtTokenUtil {
    @Value("\${jwt.secret}:secret")
    private val secret: String? = null

    @Value("\${jwt.expiration}")
    private val expiration: Long? = null

    fun generateToken(username: String?): String {
        val now = Date()
        val expiryDate = Date(now.time + expiration!! * 1000)

        return Jwts.builder()
            .setSubject(username)
            .setIssuedAt(now)
            .setExpiration(expiryDate)
            .signWith(SignatureAlgorithm.HS512, secret)
            .compact()
    }

    fun extractClaims(token: String?): Claims {
        return Jwts.parser()
            .setSigningKey(secret)
            .parseClaimsJws(token)
            .body
    } // Add methods for token validation, expiration check, etc.

    fun validateToken(token: String?): Boolean {
        return try {
            Jwts.parser().setSigningKey(secret).parseClaimsJws(token)
            true
        } catch (ex: Exception) {
            false
        }
    }

    fun getAuthentication(token: String?): Authentication? {
        val claims = Jwts.parser().setSigningKey(secret).parseClaimsJws(token).body
        val userDetails: UserDetails = User(claims.subject, "", emptyList())
        return UsernamePasswordAuthenticationToken(userDetails, "", userDetails.authorities)
    }
}

