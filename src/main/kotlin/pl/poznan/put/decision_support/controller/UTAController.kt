package pl.poznan.put.decision_support.controller

import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.model.domain.UTA.UTADataModel
import pl.poznan.put.decision_support.model.domain.UTA.UTAResponse
import pl.poznan.put.decision_support.service.UTA.UTAFactory

@RestController
class UTAController {

    var utaFactory: UTAFactory = UTAFactory()

    @PostMapping("/UTA")
    fun run(): String {
        return "Hello world from UTA!"
    }

    @PostMapping("/UTA/solution")
    fun solve(@RequestBody utaModel: UTADataModel): UTAResponse {
        val calculator = utaFactory.createUTA()
        return calculator.calculate(utaModel)
    }
}