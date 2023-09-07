package pl.poznan.put.decision_support.service.dataset

import org.springframework.stereotype.Service
import pl.poznan.put.decision_support.model.Criterion
import pl.poznan.put.decision_support.model.Dataset
import pl.poznan.put.decision_support.model.VariantCriterionValue
import pl.poznan.put.decision_support.model.domain.DatasetObject
import pl.poznan.put.decision_support.model.domain.toVariant
import pl.poznan.put.decision_support.repository.CriterionRepository
import pl.poznan.put.decision_support.repository.DatasetRepository
import pl.poznan.put.decision_support.repository.VariantCriterionValueRepository
import pl.poznan.put.decision_support.repository.VariantRepository
import java.util.*

@Service
class DatasetService(
    private val datasetRepository: DatasetRepository,
    private val variantRepository: VariantRepository,
    private val criterionRepository: CriterionRepository,
    private val variantCriterionValueRepository: VariantCriterionValueRepository
) {
    fun getAll(): List<Dataset?> = datasetRepository.findAll().toList()

    fun getByName(name: String) = datasetRepository.getDatasetByName(name)

    fun save(dataset: Dataset) = datasetRepository.save(dataset)

    fun findById(id: Long): Optional<Dataset?> = datasetRepository.findById(id)

    fun existsById(id: Long) = datasetRepository.existsById(id)

    fun deleteById(id: Long) = datasetRepository.deleteById(id)

    fun saveDatasetOfObjects(dataset: DatasetObject): Dataset {
        val savedDataset = datasetRepository.save(Dataset(name = dataset.name))
        val savedCriteria: List<Criterion> = dataset.criteria.map { criterion ->
            criterionRepository.save(Criterion(name = criterion.name, dataset = savedDataset))
        }
        dataset.variants.forEach { variant ->
            val savedVariant = variantRepository.save(variant.toVariant())
            savedCriteria.zip(variant.values).forEach { (criterion, value) ->
                variantCriterionValueRepository.save(
                    VariantCriterionValue(
                        variant = savedVariant,
                        criterion = criterion,
                        value = value
                    )
                )
            }
        }
        return savedDataset
    }
}