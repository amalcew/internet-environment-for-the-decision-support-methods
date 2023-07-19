package pl.poznan.put.decision_support.sample.service.electre1s.model

class Criterion {
    val PREFERENCE_TYPE_COST = 1
    val PREFERENCE_TYPE_GAIN = 2
    var preferenceType: Int = PREFERENCE_TYPE_GAIN

    var weight: Double = 1.0
    var q: Double = 0.0  // undifferentiability threshold
    var p: Double = 0.0  // preference threshold
    var v: Double = 0.0  // veto threshold
}