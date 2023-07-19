package pl.poznan.put.decision_support.sample.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.sample.service.electre1s.Electre1sFactory
import pl.poznan.put.decision_support.sample.service.electre1s.model.InputBody

@RestController
class Electre1sController() {

//    TODO: DI
    var electre1sFactory: Electre1sFactory = Electre1sFactory()

    @GetMapping("/electre1s")
    fun run(): String {

        return "Hello world from Electre1s!"
    }

    @PostMapping("/electre1s")
    fun postAction(@RequestBody body: InputBody): Any {
        val data = body.data
        val calculator = electre1sFactory.createElectre1s()
        return calculator.calculate(data.variants, data.criteria, data.lambda)
    }
}