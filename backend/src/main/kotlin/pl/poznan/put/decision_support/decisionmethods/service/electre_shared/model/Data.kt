package pl.poznan.put.decision_support.service.electre_shared.model

import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant

/**
 * corresponding to json
 *
 */
data class Data(
    val lambda: Double,
    val criteria: List<Criterion>,
    val variants: List<Variant>,
    val b: List<Variant>
)