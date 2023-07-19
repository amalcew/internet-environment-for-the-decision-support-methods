package pl.poznan.put.decision_support.sample.service.electre1s


/**
 * Most likely to delete when DI will be done
 */
class Electre1sFactory {
    fun createConfig(): Config {
        return Config()
    }
    fun createElectre1s(): Electre1s {
        return Electre1s(this.createConfig())
    }
}