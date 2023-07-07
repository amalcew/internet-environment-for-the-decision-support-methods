package pl.poznan.put.decision_support

import org.springframework.boot.autoconfigure.SpringBootApplication
import org.springframework.boot.runApplication

@SpringBootApplication
class DecisionSupportWebBackendApplication

fun main(args: Array<String>) {
    runApplication<DecisionSupportWebBackendApplication>(*args)
}