package pl.poznan.put.decision_support.service.electre1s

import pl.poznan.put.decision_support.decisionmethods.service.electre1s.Config
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.Calculator

class Electre1sFactory {
    fun createConfig(): Config {
        return Config()
    }
    fun createElectre1s(): Calculator {
        return Calculator(this.createConfig())
    }
}