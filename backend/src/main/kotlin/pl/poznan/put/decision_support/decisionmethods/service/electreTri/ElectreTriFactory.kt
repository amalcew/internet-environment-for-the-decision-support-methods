package pl.poznan.put.decision_support.decisionmethods.service.electreTri

import pl.poznan.put.decision_support.decisionmethods.service.electreTri.Config
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.Calculator

class ElectreTriFactory {
    fun createConfig(): Config {
        return Config()
    }
    fun createElectreTri(): Calculator {
        return Calculator(this.createConfig())
    }
 }