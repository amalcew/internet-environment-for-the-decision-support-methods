package pl.poznan.put.decision_support.sampleMethod

import lombok.NoArgsConstructor
import pl.poznan.put.decision_support.methodMeta.Input

@NoArgsConstructor
data class SampleInput(
        var name: String = "",
        var data: List<Int> = emptyList(),
        var columnNames: List<String> = emptyList(),
        override val methodType: String = ""
): Input