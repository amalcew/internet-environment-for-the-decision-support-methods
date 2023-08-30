package pl.poznan.put.decision_support.service.dataset

import org.springframework.stereotype.Service
import pl.poznan.put.decision_support.model.Dataset
import pl.poznan.put.decision_support.repository.DatasetRepository

@Service
class DatasetService(
    private val datasetRepository: DatasetRepository
) {
    fun getAll(): List<Dataset?> = datasetRepository.findAll().toList()

    fun getByName(name: String) = datasetRepository.getDatasetByName(name)

    fun save(dataset: Dataset) = datasetRepository.save(dataset)

    fun findById(id: Long) = datasetRepository.findById(id)

    fun existsById(id: Long) = datasetRepository.existsById(id)

    fun deleteById(id: Long) = datasetRepository.deleteById(id)
}