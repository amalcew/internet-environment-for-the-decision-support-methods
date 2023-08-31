package pl.poznan.put.decision_support.controller

import org.springframework.data.jpa.domain.AbstractPersistable_.id
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.*
import pl.poznan.put.decision_support.model.Dataset
import pl.poznan.put.decision_support.service.dataset.DatasetService

@RestController
class DatasetController(
    private val datasetService: DatasetService
) {

    @GetMapping("/dataset")
    fun getAllDatasets(): List<Dataset?> {
        return datasetService.getAll()
    }

    @PostMapping("/dataset")
    fun createDataset(@RequestBody dataset: Dataset): ResponseEntity<Dataset> {
        val createdDataset = datasetService.save(dataset)
        return ResponseEntity(createdDataset, HttpStatus.CREATED)
    }

    @GetMapping("/dataset/{id}")
    fun getDatasetById(@PathVariable id: Long): ResponseEntity<Dataset> {
        val dataset = datasetService.findById(id).orElse(null)
        return if (dataset != null) ResponseEntity(dataset, HttpStatus.OK)
        else ResponseEntity(HttpStatus.NOT_FOUND)
    }

    @GetMapping("/dataset/name/{name}")
    fun getDatasetByName(name: String): ResponseEntity<Dataset> {
        val dataset = datasetService.getByName(name)
        return if (dataset != null) ResponseEntity(dataset, HttpStatus.OK)
        else ResponseEntity(HttpStatus.NOT_FOUND)
    }

    @PutMapping("/dataset/{id}")
    fun updateDatasetById(@PathVariable("id") datasetId: Long, @RequestBody dataset: Dataset): ResponseEntity<Dataset> {

        val existingDataset =
            datasetService.findById(datasetId).orElse(null) ?: return ResponseEntity(HttpStatus.NOT_FOUND)

        val updatedDataset = existingDataset.copy(name = dataset.name)
        datasetService.save(updatedDataset)
        return ResponseEntity(updatedDataset, HttpStatus.OK)
    }

    @DeleteMapping("/dataset/{id}")
    fun deleteDatasetById(@PathVariable("id") datasetId: Long): ResponseEntity<Dataset> {
        if (!datasetService.existsById(datasetId)) {
            return ResponseEntity(HttpStatus.NOT_FOUND)
        }
        datasetService.deleteById(datasetId)
        return ResponseEntity(HttpStatus.NO_CONTENT)
    }
}