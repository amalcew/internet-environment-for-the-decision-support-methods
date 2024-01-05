package pl.poznan.put.decision_support

import com.fasterxml.jackson.databind.ObjectMapper
import org.junit.jupiter.api.Test
import org.junit.jupiter.api.assertThrows
import org.junit.jupiter.api.extension.ExtendWith
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.boot.test.autoconfigure.web.servlet.AutoConfigureMockMvc
import org.springframework.boot.test.context.SpringBootTest
import org.springframework.http.MediaType
import org.springframework.test.context.junit.jupiter.SpringExtension
import org.springframework.test.web.servlet.MockMvc
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders.get
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post
import org.springframework.test.web.servlet.result.MockMvcResultMatchers.content
import org.springframework.test.web.servlet.result.MockMvcResultMatchers.status
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.InputBody
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant
import pl.poznan.put.decision_support.service.electre_shared.model.Data
import java.lang.Exception

@SpringBootTest
@AutoConfigureMockMvc
@ExtendWith(SpringExtension::class)
class Electre1sControllerTest {

    @Autowired
    private lateinit var mockMvc: MockMvc

    @Autowired
    private lateinit var objectMapper: ObjectMapper

    private val dataEmpty = Data(lambda = 0.5, criteria = listOf(), variants = listOf(), b = listOf())

    private val dataEmptyWithSingleCriterion = Data(lambda = 0.5, criteria = listOf(), variants = listOf(), b = listOf())

    private val data = Data(
        lambda = 0.5,
        criteria = listOf(
            Criterion(
                weight = 0.5,
                preferenceType = "max",
                use_veto = false,
                q = 0.5,
                p = 0.5,
                v = 0.5,
            )
        ),
        variants = listOf(Variant(values = listOf(1.0)), Variant(values = listOf(1.0)), Variant(values = listOf(1.0))),
        b = listOf(Variant(values = listOf(1.0)))
    )

    @Test
    fun testRunEndpoint() {
        mockMvc.perform(get("/electre1s"))
            .andExpect(status().isOk)
            .andExpect(content().string("Hello world from Electre1s!"))
    }

    @Test
    fun testPostActionEndpoint() {
        performElectre1sRequest(data)
    }

    @Test
    fun testPostTriActionEndpoint() {
        performElectreTriRequest(data)
    }

    @Test
    fun testPostTriActionEndpointOnEmptyData() {
        assertThrows<Exception> {
            performElectre1sRequest(dataEmpty)
        }
    }

    @Test
    fun testPostActionEndpointOnDataWithoutRequired() {
        assertThrows<Exception> {
            performElectre1sRequest(dataEmptyWithSingleCriterion)
        }
    }

    fun performElectre1sRequest(data: Data) {
        val inputBody = InputBody(data)
        mockMvc.perform(
            post("/electre1s")
                .contentType(MediaType.APPLICATION_JSON)
                .content(objectMapper.writeValueAsString(inputBody))
        )
            .andExpect(status().isOk)
    }

    fun performElectreTriRequest(data: Data) {
        val inputBody = InputBody(data)
        mockMvc.perform(
            post("/electretri")
                .contentType(MediaType.APPLICATION_JSON)
                .content(objectMapper.writeValueAsString(inputBody))
        )
            .andExpect(status().isOk)
    }
}