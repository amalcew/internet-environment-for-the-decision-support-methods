package pl.poznan.put.decision_support

import org.junit.jupiter.api.Assertions.assertNotNull
import org.junit.jupiter.api.Test
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.boot.test.context.SpringBootTest
import org.springframework.context.ApplicationContext


@SpringBootTest
class DecisionSupportWebBackendApplicationTests {

    @Autowired
    var applicationContext: ApplicationContext? = null

    @Test
    @Throws(Exception::class)
    fun contextLoads() {
        assertNotNull(applicationContext)
    }
}
