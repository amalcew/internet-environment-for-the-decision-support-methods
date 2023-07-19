package pl.poznan.put.decision_support.sample.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.sample.service.electre1s.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre1s.Electre1s
import pl.poznan.put.decision_support.sample.service.electre1s.model.Variant
import java.util.LinkedList

@RestController
class Electre1sController() {

    val electre1s = Electre1s()
    @GetMapping("/electre1s")
    fun run(): String {

        return "Hello world from Electre1s!"
    }
}