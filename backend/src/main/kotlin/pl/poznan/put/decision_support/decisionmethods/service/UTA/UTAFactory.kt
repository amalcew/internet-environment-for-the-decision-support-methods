package pl.poznan.put.decision_support.decisionmethods.service.UTA

class UTAFactory {

    fun createUTA(): UTACalculator {
        return UTACalculator()
    }
}