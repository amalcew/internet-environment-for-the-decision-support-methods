package pl.poznan.put.decision_support.repository

import org.springframework.data.jdbc.repository.query.Query

import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.model.Dataset

@Repository
interface DatasetRepository : CrudRepository<Dataset?, Long?> {
    @Query("FROM datasets WHERE name = ?1")
    fun getDatasetByName(name: String?): Dataset?
}