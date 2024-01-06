package pl.poznan.put.decision_support.decisionmethods.service.electreTri.model

import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant
import pl.poznan.put.decision_support.service.electre_shared.model.Data

data class DataTri(
    val lambda: Double,
    val criteria: List<Criterion>,
    val variants: List<Variant>,
    val profiles: List<Variant>
)
