package pl.poznan.put.decision_support.model

import com.fasterxml.jackson.annotation.JsonIgnoreProperties
import jakarta.persistence.*

@Entity
@Table(name = "variants")
@JsonIgnoreProperties(value = ["dataset_id", "dataset"])
data class Variant(
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "variant_id")
    var id: Long? = null,
    val name: String? = null,
    @ManyToOne(cascade = [CascadeType.ALL], fetch = FetchType.LAZY)
    @JoinColumn(name = "dataset_id", updatable = false)
    val dataset: Dataset? = null
)
