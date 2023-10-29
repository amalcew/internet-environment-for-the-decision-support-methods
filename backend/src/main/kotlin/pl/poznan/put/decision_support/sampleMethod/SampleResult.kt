package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.RESULT_STATUS
import pl.poznan.put.decision_support.methodMeta.Result


data class SampleResult(
        var result: RESULT_STATUS = RESULT_STATUS.SUCCESS,
        var output: String = ""
): Result