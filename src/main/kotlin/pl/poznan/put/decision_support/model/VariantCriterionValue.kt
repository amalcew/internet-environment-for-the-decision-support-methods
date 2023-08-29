package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "variant_criteria_values")
data class VariantCriterionValue(
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null,
    val value: Double? = null,
    @OneToOne
    @JoinColumn(name = "id")
    val variant: Variant? = null,
    @OneToOne
    @JoinColumn(name = "id")
    val criterion: Criterion? = null
)
