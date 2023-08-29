package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "variants")
data class Variant(
    val name: String? = null
){
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null
    @ManyToOne
    @JoinColumn(name = "id", insertable=false, updatable=false)
    val dataset: Dataset? = null
}
