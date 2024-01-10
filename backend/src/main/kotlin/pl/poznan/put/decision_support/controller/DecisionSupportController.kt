package pl.poznan.put.decision_support.controller

import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RequestMapping
import org.springframework.web.bind.annotation.RestController
import pl.poznan.put.decision_support.exceptions.MethodNotImplementedException
import pl.poznan.put.decision_support.methodMeta.Input
import pl.poznan.put.decision_support.methodMeta.Result
import pl.poznan.put.decision_support.sampleMethod.SampleInput
import pl.poznan.put.decision_support.sampleMethod.SampleMethodClientFactory
import pl.poznan.put.decision_support.sampleMethod.SampleResult

@RestController
@RequestMapping(value = ["/engine/v1/decision-support"])
class DecisionSupportController {

    @GetMapping("/getAllMethods")
    fun getAvailableMethods(): List<String> {
        return listOf("Sample")
    }

    @PostMapping("run/sample")
    fun runSample(@RequestBody input: SampleInput): Result {
        val methodClientFactory =  SampleMethodClientFactory()
        val inputFactory = methodClientFactory.createInputFactory()
        val methodInput = inputFactory.build()

        val method = methodClientFactory.createMethodFactory().createMethod()
        val methodResult = method.applyMethod()

        val outputFactory = methodClientFactory.createResultFactory()

        return  outputFactory.build()

    }

}