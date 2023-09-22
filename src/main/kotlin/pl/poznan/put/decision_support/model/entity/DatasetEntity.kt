package pl.poznan.put.decision_support.model.entity

import jakarta.persistence.*

@Entity
@Table(name = "datasets")
data class DatasetEntity(
    val name: String? = null
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "dataset_id")
    var id: Long? = null

    @OneToOne
    @JoinColumn(name = "id")
    val project: ProjectEntity? = null

    @OneToMany(mappedBy = "dataset", cascade = [CascadeType.ALL], fetch = FetchType.LAZY)
    var criteria: List<CriterionEntity>? = null

    @OneToMany(mappedBy = "dataset", cascade = [CascadeType.ALL], fetch = FetchType.LAZY)
    var variants: List<VariantEntity>? = null
}
