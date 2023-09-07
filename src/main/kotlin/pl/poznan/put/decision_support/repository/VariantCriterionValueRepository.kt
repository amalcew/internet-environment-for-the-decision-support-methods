package pl.poznan.put.decision_support.repository

import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.model.VariantCriterionValue

@Repository
interface VariantCriterionValueRepository: CrudRepository<VariantCriterionValue?, Long?> {
}