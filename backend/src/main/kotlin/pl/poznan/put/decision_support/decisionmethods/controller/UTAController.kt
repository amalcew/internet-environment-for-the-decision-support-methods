package pl.poznan.put.decision_support.decisionmethods.controller

import org.springframework.beans.factory.annotation.Value
import org.springframework.boot.autoconfigure.condition.ConditionalOnExpression
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.request.UTARequest
import pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.response.UTAResponse
import pl.poznan.put.decision_support.decisionmethods.service.UTA.UTAFactory
import pl.poznan.put.decision_support.decisionmethods.utils.httpclient.HTTPClientManagerImpl
import pl.poznan.put.decision_support.decisionmethods.utils.httpclient.convertFromJson

@RestController
@ConditionalOnExpression("\${uta_controller.enabled:false}")
class UTAController {

    var utaFactory: UTAFactory = UTAFactory()
    val httpClientManager = HTTPClientManagerImpl()

    @Value("\${uta_service.url}")
    private val utaServiceUrl: String? = null

    @PostMapping("/UTA")
    fun run(@RequestBody body: UTARequest): UTAResponse? {
        return utaServiceUrl?.let {
            val response = httpClientManager.runRequest(utaServiceUrl, body)
            val utaResponse = convertFromJson<UTAResponse>(response)
            val calculator = utaFactory.createUTA()
            val result = calculator.calculate(body, utaResponse)
            result
        }
    }
}