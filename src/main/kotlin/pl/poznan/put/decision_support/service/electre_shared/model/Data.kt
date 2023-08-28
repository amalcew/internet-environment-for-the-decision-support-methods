package pl.poznan.put.decision_support.service.electre_shared.model

/**
 * corresponding to json
 *
 */
data class Data(
    val lambda: Double,
    val criteria: List<Criterion>,
    val variants: List<Variant>
)