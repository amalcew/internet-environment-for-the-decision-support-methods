package pl.poznan.put.decision_support.methodMeta

interface MethodClientFactory {

    fun createInputFactory(): InputBuilder
    fun createResultFactory(): ResultBuilder
    fun createMethodFactory(): MethodFactory
}