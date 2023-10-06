package pl.poznan.put.decision_support.users.model

import jakarta.persistence.*
import lombok.Data

@Entity
@Table(name = "users")
@Data
@SequenceGenerator(name = "users_seq", sequenceName = "users_seq", allocationSize = 1)
data class User(
    val name: String,
    var password: String,
    val url: String,
    val email: String,
    val age: Int
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null
}
