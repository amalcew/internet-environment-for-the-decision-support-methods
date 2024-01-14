package pl.poznan.put.decision_support

import org.junit.jupiter.api.Test
import org.mockito.Mock
import org.mockito.Mockito.mock
import pl.poznan.put.decision_support.decisionmethods.model.domain.uta.request.UTARequestBody
import pl.poznan.put.decision_support.decisionmethods.utils.httpclient.HTTPClientManager
import pl.poznan.put.decision_support.decisionmethods.utils.httpclient.convertFromJson


class UTACalculatorTest {

    @Mock
    val httpClientManager = mock(HTTPClientManager::class.java)

    @Test
    fun testMapValuesToRankingPositions() {

        val jsonString = """
        {
            "performanceTable": [[3, 10, 1], [4, 20, 2], [2, 20, 0], [6, 40, 0], [30, 30, 3]],
            "criteriaMinMax": ["min", "min", "max"],
            "criteriaNumberOfBreakPoints": [3, 4, 4],
            "epsilon": 0.05,
            "rownamesPerformanceTable": ["RER", "METRO1", "METRO2", "BUS", "TAXI"],
            "colnamesPerformanceTable": ["Price", "Time", "Comfort"],
            "alternativesPreferences": [["METRO2", "TAXI"]],
            "alternativesIndifferences": [["BUS", "RER"]]
        }
    """.trimIndent()

        val dataBody = convertFromJson<UTARequestBody>(jsonString)
        val response = httpClientManager.runRequest("", dataBody.data)
    }

}