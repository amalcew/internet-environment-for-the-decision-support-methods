package pl.poznan.put.decision_support.service.UTA

class UTAFactory {

    fun createUTA(): UTACalculator {
        return UTACalculator()
    }
}