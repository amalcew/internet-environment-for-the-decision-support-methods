package pl.poznan.put.decision_support

import org.springframework.boot.autoconfigure.SpringBootApplication
import org.springframework.boot.runApplication
import org.springframework.data.jpa.repository.config.EnableJpaRepositories

@SpringBootApplication
@EnableJpaRepositories("pl.poznan.put.decision_support.repository")
class DecisionSupportWebBackendApplication

fun main(args: Array<String>) {
    runApplication<DecisionSupportWebBackendApplication>(*args)
}