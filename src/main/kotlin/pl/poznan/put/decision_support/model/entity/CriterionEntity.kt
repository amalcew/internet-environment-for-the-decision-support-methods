package pl.poznan.put.decision_support.model.entity

import com.fasterxml.jackson.annotation.JsonIgnoreProperties
import jakarta.persistence.*

@Entity
@Table(name = "criteria")
@JsonIgnoreProperties(value = ["dataset_id", "dataset"])
data class CriterionEntity(
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    @Column(name = "criteria_id")
    var id: Long? = null,
    val name: String? = null,
    val type: CriterionType? = null,
    @ManyToOne(cascade = [CascadeType.ALL], fetch = FetchType.LAZY)
    @JoinColumn(name = "dataset_id", updatable=false)
    val dataset: DatasetEntity? = null
)