package pl.poznan.put.decision_support.service.dataset

import org.springframework.stereotype.Service
import org.springframework.transaction.annotation.Transactional
import pl.poznan.put.decision_support.model.domain.Dataset
import pl.poznan.put.decision_support.model.entity.CriterionEntity
import pl.poznan.put.decision_support.model.entity.DatasetEntity
import pl.poznan.put.decision_support.model.entity.VariantEntity
import pl.poznan.put.decision_support.model.entity.VariantCriterionValueEntity
import pl.poznan.put.decision_support.model.domain.DatasetObject
import pl.poznan.put.decision_support.model.domain.toVariant
import pl.poznan.put.decision_support.model.mapper.mapToDataset
import pl.poznan.put.decision_support.model.mapper.toDatasetEntity
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
    fun getAll(): List<DatasetEntity?> = datasetRepository.findAll().toList()

    fun getByName(name: String) = datasetRepository.getDatasetByName(name)?.mapToDataset()

    @Transactional
    fun save(dataset: Dataset) = datasetRepository.save(dataset.toDatasetEntity())

    fun findById(id: Long): Optional<Dataset?> = datasetRepository.findById(id).map { it?.mapToDataset() }

    fun existsById(id: Long) = datasetRepository.existsById(id)

    @Transactional
    fun deleteById(id: Long) = datasetRepository.deleteById(id)

    @Transactional
    fun saveDatasetOfObjects(dataset: DatasetObject): Dataset {
        var savedDataset = datasetRepository.save(DatasetEntity(name = dataset.name))
        val savedCriteria: List<CriterionEntity> = dataset.criteria.map { criterion ->
            criterionRepository.save(CriterionEntity(name = criterion.name, dataset = savedDataset))
        }
        val savedVariants = mutableListOf<VariantEntity>()
        val values = mutableListOf<VariantCriterionValueEntity>()
        dataset.variants.forEach { variant ->
            val savedVariant = variantRepository.save(variant.toVariant().copy(dataset = savedDataset))
            savedVariants.add(savedVariant)
            savedCriteria.zip(variant.values).forEach { (criterion, value) ->
                values.add(
                    variantCriterionValueRepository.save(
                        VariantCriterionValueEntity(
                            variant = savedVariant,
                            criterion = criterion,
                            value = value
                        )
                    )
                )
            }
        }
        savedDataset.criteria = savedCriteria
        savedDataset.variants = savedVariants
        savedDataset = datasetRepository.save(savedDataset)
        return savedDataset.mapToDataset(values)
    }
}