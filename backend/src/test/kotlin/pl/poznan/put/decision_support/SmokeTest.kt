package pl.poznan.put.decision_support

import org.assertj.core.api.Assertions.assertThat
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.boot.test.context.SpringBootTest
import pl.poznan.put.decision_support.controller.DecisionSupportController
import pl.poznan.put.decision_support.decisionmethods.controller.Electre1sController
import pl.poznan.put.decision_support.decisionmethods.controller.UTAController

@SpringBootTest
class SmokeTest {

    @Autowired
    private lateinit var controller: DecisionSupportController

    @Autowired
    private lateinit var electreController: Electre1sController

    @Autowired
    private lateinit var utaController: UTAController

    fun contextLoads() {
        assertThat(controller).isNotNull()
        assertThat(electreController).isNotNull()
        assertThat(utaController).isNotNull()
    }
}