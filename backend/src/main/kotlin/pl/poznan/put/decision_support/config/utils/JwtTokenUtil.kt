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
    fun generateRefreshToken(username: String?): String {
        val now = Date()

        return Jwts.builder()
            .setSubject(username)
            .setIssuedAt(now)
            .signWith(SignatureAlgorithm.HS512, "refresh$secret")
            .compact()
    }

    fun validateJwtToken(token: String?): Boolean {
        return validateToken(token, secret!!)
    }
    fun validateRefreshToken(token: String?): Boolean {
        return validateToken(token, "refresh$secret")
    }
    fun validateToken(token: String?, secretKey: String): Boolean {
        return try {
            Jwts.parser().setSigningKey(secretKey).parseClaimsJws(token)
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

    fun getUsernameFromToken(token: String?): String? {
        return try {
            val claims = Jwts.parser().setSigningKey("refresh$secret").parseClaimsJws(token).body
            claims.subject
        } catch (ex: Exception) {
            null
        }
    }
}

