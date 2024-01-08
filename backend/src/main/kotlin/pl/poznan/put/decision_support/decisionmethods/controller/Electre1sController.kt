package pl.poznan.put.decision_support.decisionmethods.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.service.electre1s.Electre1sFactory
import pl.poznan.put.decision_support.decisionmethods.service.electreTri.ElectreTriFactory
import pl.poznan.put.decision_support.decisionmethods.service.electreTri.model.InputBodyTri
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.InputBody
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant

@RestController
class Electre1sController() {

//    TODO: DI
    var electre1sFactory: Electre1sFactory = Electre1sFactory()
    var electreTriFactory: ElectreTriFactory = ElectreTriFactory()

    @GetMapping("/electre1s")
    fun run(): String {

        return "Hello world from Electre1s!"
    }

    @PostMapping("/electre1s")
    fun postAction(@RequestBody body: InputBody): Any {
        val data = body.data
        val calculator = electre1sFactory.createElectre1s()
        return calculator.calculate(data.variants, data.variants, data.criteria, data.lambda)
    }

    @PostMapping("/electretri")
    fun postTriAction(@RequestBody body: InputBodyTri): Any {
        val data = body.data
        val calculator = electreTriFactory.createElectreTri()
        val variantsWithProfiles = ArrayList<Variant>()
        data.profiles.forEach { variantsWithProfiles.add(it) }
        data.variants.forEach { variantsWithProfiles.add(it) }
        return calculator.calculate(variantsWithProfiles, data.profiles, data.criteria, data.lambda)
    }
}