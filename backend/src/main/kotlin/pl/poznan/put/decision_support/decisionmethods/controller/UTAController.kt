package pl.poznan.put.decision_support.decisionmethods.controller

import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.request.UTARequest
import pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.response.UTAResponse
import pl.poznan.put.decision_support.decisionmethods.service.UTA.UTAFactory
import pl.poznan.put.decision_support.decisionmethods.utils.httpclient.HTTPClientManagerImpl
import pl.poznan.put.decision_support.decisionmethods.utils.httpclient.convertFromJson

@RestController
class UTAController {

    var utaFactory: UTAFactory = UTAFactory()
    val httpClientManager = HTTPClientManagerImpl()
    @PostMapping("/UTA")
    fun run(@RequestBody body: UTARequest): UTAResponse? {
        val response = httpClientManager.runRequest("http://127.0.0.1:7477/UTA", body)
        val utaResponse = convertFromJson<UTAResponse>(response)
        val calculator = utaFactory.createUTA()
        val result = calculator.calculate(body, utaResponse)
        return result
    }
}