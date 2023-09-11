package pl.poznan.put.decision_support

import org.assertj.core.api.Assertions.assertThat
import org.junit.jupiter.api.Test
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.boot.test.context.SpringBootTest
import pl.poznan.put.decision_support.controller.DatasetController
import pl.poznan.put.decision_support.service.dataset.DatasetService


@SpringBootTest
class DecisionSupportWebBackendApplicationTests {

    @Autowired
    private val datasetController: DatasetController? = null

    @Autowired
    private val datasetService: DatasetService? = null

    @Test
    @Throws(Exception::class)
    fun contextLoads() {
        assertThat(datasetController).isNotNull()
        assertThat(datasetService).isNotNull()
    }

}
