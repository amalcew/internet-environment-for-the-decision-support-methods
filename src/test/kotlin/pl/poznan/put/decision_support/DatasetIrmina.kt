package pl.poznan.put.decision_support

import pl.poznan.put.decision_support.sample.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre_shared.model.Variant
import java.util.*

class DatasetIrmina {
    // ----------------------- criteria --------------------------------------------------------------------------------
    private val criterion1 = Criterion("cost", 1.0, 0.9, 2.2, 3.0 )
    private val criterion2 = Criterion("gain", 9.0, 1.0, 1.6, 3.5)

    // ----------------------- variants --------------------------------------------------------------------------------
    private val variant1 = Variant(listOf(10.8, 4.7))
    private val variant2 = Variant(listOf(8.0, 6.0))
    private val variant3 = Variant(listOf(11.0, 4.8))

    // --------------------- global values -----------------------------------------------------------------------------
    val lambda: Double = 0.6
    val criteria = LinkedList<Criterion>(listOf(criterion1, criterion2))
    val variants: List<Variant> = listOf(variant1, variant2, variant3)
}