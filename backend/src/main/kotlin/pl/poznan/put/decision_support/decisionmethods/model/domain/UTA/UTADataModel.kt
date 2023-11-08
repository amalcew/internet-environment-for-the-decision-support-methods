package pl.poznan.put.decision_support.model.domain.UTA

import pl.poznan.put.decision_support.decisionmethods.model.domain.Criterion
import pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.ReferenceRanking
import pl.poznan.put.decision_support.model.domain.Variant

data class UTADataModel(
    val criteria: List<Criterion>,
    val variants: List<Variant>,
    val referenceRanking: ReferenceRanking,
    val maxLinearSections: List<LinearSection>
)

data class LinearSection(
    val criterion: Criterion,
    val maxLinearSection: Int = 1
)