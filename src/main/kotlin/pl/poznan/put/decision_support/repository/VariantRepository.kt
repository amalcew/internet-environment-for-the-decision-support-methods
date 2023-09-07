package pl.poznan.put.decision_support.repository

import org.springframework.data.jdbc.repository.query.Query
import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.model.Variant

@Repository
interface VariantRepository : CrudRepository<Variant?, Long?> {
    @Query("SELECT * FROM variants WHERE dataset_id = :datasetId")
    fun findAllByDatasetId(datasetId: Long?): List<Variant?>?
}