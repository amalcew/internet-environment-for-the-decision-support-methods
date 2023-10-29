package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.RESULT_STATUS
import pl.poznan.put.decision_support.methodMeta.Result
import pl.poznan.put.decision_support.methodMeta.ResultBuilder

class SampleResultBuilder: ResultBuilder {

    private val result = SampleResult()
    override fun build(): Result {
        return this.result;
    }

    fun setStatus(status: RESULT_STATUS): SampleResultBuilder {
        this.result.result= status
        return this
    }

    fun setOutput(output: String): SampleResultBuilder {
        this.result.output= output
        return this
    }
}