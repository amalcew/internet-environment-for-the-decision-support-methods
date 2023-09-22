package pl.poznan.put.decision_support.repository

import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.model.entity.VariantCriterionValueEntity

@Repository
interface VariantCriterionValueRepository: CrudRepository<VariantCriterionValueEntity?, Long?> {
}
