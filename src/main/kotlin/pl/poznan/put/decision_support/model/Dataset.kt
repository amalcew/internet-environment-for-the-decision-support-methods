package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "datasets")
data class Dataset(
    val name: String? = null
) {
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "dataset_id")
    var id: Long? = null

    @OneToOne
    @JoinColumn(name = "id")
    val project: Project? = null

    @OneToMany(mappedBy = "dataset", cascade = [CascadeType.ALL], fetch = FetchType.LAZY)
    var criteria: List<Criterion>? = null

    @OneToMany(mappedBy = "dataset", cascade = [CascadeType.ALL], fetch = FetchType.LAZY)
    var variants: List<Variant>? = null
}
