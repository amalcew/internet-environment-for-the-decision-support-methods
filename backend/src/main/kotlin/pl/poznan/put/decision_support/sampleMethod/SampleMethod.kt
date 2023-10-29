package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.DecisionSupportMethod
import pl.poznan.put.decision_support.methodMeta.MethodResult


class SampleMethod: DecisionSupportMethod {
    override fun applyMethod(): MethodResult {
        println("RUN sample")
        return SampleMethodResult()
    }
}