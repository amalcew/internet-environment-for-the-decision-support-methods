package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "users")
data class User(
    val name: String,
    val password: String,
    val url: String,
    val email: String,
    val age: Int,
    @OneToMany(mappedBy = "user")
    val projects: List<Project>? = null
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null
}
