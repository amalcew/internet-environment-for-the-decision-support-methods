package pl.poznan.put.decision_support.service.dataset

import org.springframework.stereotype.Service
import org.springframework.transaction.annotation.Transactional
import pl.poznan.put.decision_support.model.Criterion
import pl.poznan.put.decision_support.model.Dataset
import pl.poznan.put.decision_support.model.Variant
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

    @Transactional
    fun save(dataset: Dataset) = datasetRepository.save(dataset)

    fun findById(id: Long): Optional<Dataset?> = datasetRepository.findById(id)

    fun existsById(id: Long) = datasetRepository.existsById(id)

    @Transactional
    fun deleteById(id: Long) = datasetRepository.deleteById(id)

    @Transactional
    fun saveDatasetOfObjects(dataset: DatasetObject): Dataset {
        var savedDataset = datasetRepository.save(Dataset(name = dataset.name))
        val savedCriteria: List<Criterion> = dataset.criteria.map { criterion ->
            criterionRepository.save(Criterion(name = criterion.name, dataset = savedDataset))
        }
        val savedVariants = mutableListOf<Variant>()
        dataset.variants.forEach { variant ->
            val savedVariant = variantRepository.save(variant.toVariant().copy(dataset = savedDataset))
            savedVariants.add(savedVariant)
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
        savedDataset.criteria = savedCriteria
        savedDataset.variants = savedVariants
        savedDataset = datasetRepository.save(savedDataset)
        return savedDataset
    }
}