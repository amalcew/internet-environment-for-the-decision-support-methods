package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "projects")
data class Project(
    val name: String? = null
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    val id: Long? = null
    @ManyToOne
    @JoinColumn(name = "id", insertable=false, updatable=false)
    val user: User? = null
}
