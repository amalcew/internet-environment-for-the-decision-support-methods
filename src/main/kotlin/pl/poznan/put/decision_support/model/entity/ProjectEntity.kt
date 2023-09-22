package pl.poznan.put.decision_support.model.entity

import jakarta.persistence.*

@Entity
@Table(name = "projects")
data class ProjectEntity(
    val name: String? = null
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "project_id")
    val id: Long? = null
    @ManyToOne(cascade = [CascadeType.ALL])
    @JoinColumn(name = "id", updatable=false)
    val user: UserEntity? = null
    @OneToOne
    val dataset: DatasetEntity? = null
}
