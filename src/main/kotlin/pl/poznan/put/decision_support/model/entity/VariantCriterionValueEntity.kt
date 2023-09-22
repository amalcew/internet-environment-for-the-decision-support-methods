package pl.poznan.put.decision_support.model.entity

import jakarta.persistence.*

@Entity
@Table(name = "variant_criteria_values")
data class VariantCriterionValueEntity(
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null,
    val value: Double? = null,
    @ManyToOne(cascade = [CascadeType.ALL])
    @JoinColumn(name = "variant_id")
    val variant: VariantEntity? = null,
    @ManyToOne(cascade = [CascadeType.ALL])
    @JoinColumn(name = "criteria_id")
    val criterion: CriterionEntity? = null
)
