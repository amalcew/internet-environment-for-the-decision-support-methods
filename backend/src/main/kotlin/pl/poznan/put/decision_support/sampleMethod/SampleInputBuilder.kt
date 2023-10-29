package pl.poznan.put.decision_support.sampleMethod

import pl.poznan.put.decision_support.methodMeta.Input
import pl.poznan.put.decision_support.methodMeta.InputBuilder

class SampleInputBuilder: InputBuilder {

    private val input = SampleInput()

    override fun build(): Input {
        return this.input
    }

    fun setName(name: String): SampleInputBuilder {
        input.name = name
        return this
    }

    fun setColumns(names: List<String>): SampleInputBuilder {
        input.columnNames = names
        return this
    }

    fun setData(data: List<Int>): SampleInputBuilder {
        input.data = data
        return this
    }
}