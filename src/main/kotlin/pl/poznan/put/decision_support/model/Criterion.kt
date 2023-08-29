package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "criteria")
data class Criterion(
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null,
    val name: String? = null,
    val type: CriterionType? = null,
    @ManyToOne
    @JoinColumn(name = "id", insertable=false, updatable=false)
    val dataset: Dataset? = null
)