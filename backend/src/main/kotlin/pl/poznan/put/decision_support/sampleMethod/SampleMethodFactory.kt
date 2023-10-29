package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.DecisionSupportMethod
import pl.poznan.put.decision_support.methodMeta.MethodFactory

class SampleMethodFactory: MethodFactory {
    override fun createMethod(): DecisionSupportMethod {
        return SampleMethod()
    }

}