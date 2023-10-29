package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.MethodResult
import pl.poznan.put.decision_support.methodMeta.RESULT_STATUS

data class SampleMethodResult(
        var result: RESULT_STATUS = RESULT_STATUS.SUCCESS,
        var output: String = ""
): MethodResult
