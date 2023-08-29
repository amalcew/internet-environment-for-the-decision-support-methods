package pl.poznan.put.decision_support.model

import jakarta.persistence.*

@Entity
@Table(name = "datasets")
data class Dataset(
    val name: String? = null
){
    @Id
    @GeneratedValue(strategy = GenerationType.SEQUENCE)
    var id: Long? = null
    @OneToOne
    @JoinColumn(name = "id")
    val project: Project? = null
}
