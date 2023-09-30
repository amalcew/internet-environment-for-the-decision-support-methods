package pl.poznan.put.decision_support.users.model

import jakarta.persistence.*
import org.springframework.context.annotation.Primary

@Entity
@Table(name = "users")
data class User(
    val name: String,
    val password: String,
    val url: String,
    val email: String,
    val age: Int
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null
}
