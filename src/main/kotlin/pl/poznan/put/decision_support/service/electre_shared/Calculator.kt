package pl.poznan.put.decision_support.service.electre_shared

import pl.poznan.put.decision_support.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.service.electre_shared.model.Variant

import java.util.*


class Calculator(private var config: ConfigInterface) {

    /**
     * TODO:javadoc? union types?
     * @return result Array<Array<Double>>|String
     */

    var steps = config.getSteps()
    private var stepResult = LinkedList<Any>()

    // TODO [Calculator]: in my opinion, this class should be abstract and each Electre method should inherit from this class to allow storing test matrices. In current solution, this is hard to implement and may break the logic of electre 1s or tri
    fun calculate(variants: List<Variant>, criteria: List<Criterion>, lambda: Double): Any {

        var context = mutableMapOf<String, Any>();

        try {
            for (step in steps) {
                stepResult.add(step.calculate(variants, criteria, context))
            }
        } catch (exception: InvalidCriteriaException) {
            return "Preference type only allows for 'gain' or 'cost' types!"
        }


        config.getAggregator().calculate(lambda, stepResult, context)
        return context;
    }

}