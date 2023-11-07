package pl.poznan.put.decision_support.service.electreTri

import pl.poznan.put.decision_support.service.electre_shared.Calculator

class ElectreTriFactory {
    fun createConfig(): Config {
        return Config()
    }
    fun createElectreTri(): Calculator {
        return Calculator(this.createConfig())
    }
 }