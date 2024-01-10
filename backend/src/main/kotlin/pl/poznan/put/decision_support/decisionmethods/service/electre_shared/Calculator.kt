package pl.poznan.put.decision_support.decisionmethods.service.electre_shared

import pl.poznan.put.decision_support.decisionmethods.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.decisionmethods.service.electre_shared.model.Variant

import java.util.*


class Calculator(private var config: ConfigInterface) {

    /**
     * TODO:javadoc? union types?
     * @return result Array<Array<Double>>|String
     */

    var steps = config.getSteps()
    private var stepResult = LinkedList<Any>()

    /**
     * variantsX - x axis - 1s and Tri are variants
     * variantsY - y axis - 1s variants, Tri progi (b)
     */
    fun calculate(variantsX: List<Variant>, variantsY: List<Variant>, criteria: List<Criterion>, lambda: Double): Any {

        var context = mutableMapOf<String, Any>();

        try {
            for (step in steps) {
                stepResult.add(step.calculate(variantsX, variantsY, criteria, context))
            }
        } catch (exception: InvalidCriteriaException) {
            return "Preference type only allows for 'gain' or 'cost' types!"
        }

        for (aggregator in config.getAggregators()) {
            aggregator.calculate(lambda, stepResult, context, variantsY)
        }
        return context;
    }

}