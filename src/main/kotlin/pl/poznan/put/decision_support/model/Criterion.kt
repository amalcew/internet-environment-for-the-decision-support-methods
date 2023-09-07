package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "criteria")
data class Criterion(
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "criteria_id")
    var id: Long? = null,
    val name: String? = null,
    val type: CriterionType? = null,
    @ManyToOne
    @JoinColumn(name = "dataset_id", updatable=false)
    val dataset: Dataset? = null
)