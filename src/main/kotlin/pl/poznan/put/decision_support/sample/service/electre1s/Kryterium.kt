package pl.poznan.put.decision_support.sample.service.electre1s

class Kryterium {
    val PREFERENCE_TYPE_COST = 1
    val PREFERENCE_TYPE_GAIN = 2
    var preferenceType: Int = PREFERENCE_TYPE_GAIN

    var weight: Double = 1.0
    var q: Double = 0.0
    var p: Double = 0.0
    var v: Double = 0.0
}