package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.InputBuilder
import pl.poznan.put.decision_support.methodMeta.MethodClientFactory
import pl.poznan.put.decision_support.methodMeta.MethodFactory
import pl.poznan.put.decision_support.methodMeta.ResultBuilder

class SampleMethodClientFactory: MethodClientFactory {
    override fun createInputFactory(): InputBuilder {
        return SampleInputBuilder()
    }

    override fun createResultFactory(): ResultBuilder {
        return SampleResultBuilder()
    }

    override fun createMethodFactory(): MethodFactory {
        return SampleMethodFactory()
    }
}