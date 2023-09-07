package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "projects")
data class Project(
    val name: String? = null
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "project_id")
    val id: Long? = null
    @ManyToOne
    @JoinColumn(name = "id", updatable=false)
    val user: User? = null
    @OneToOne
    val dataset: Dataset? = null
}
