package pl.poznan.put.decision_support.sample.service.electre1s

import pl.poznan.put.decision_support.sample.service.electre1s.exception.InvalidCriteriaException
import pl.poznan.put.decision_support.sample.service.electre_shared.model.Criterion
import pl.poznan.put.decision_support.sample.service.electre_shared.model.Variant

import java.util.*

// TODO: [Electre1s] add comments describing each function and its purpose in the Electre1s algorithm

class Electre1s(private var config: Config) {

    /**
     * TODO:javadoc? union types?
     * @return result Array<Array<Double>>|String
     */
    fun calculate(variants: List<Variant>, criteria: List<Criterion>, lambda: Double): Any {
        var steps = config.getSteps()
        var stepResult = LinkedList<Array<Array<Double>>>()

        try {
            for (step in steps) {
                stepResult.add(step.calculate(variants, criteria))
            }
        } catch (exception: InvalidCriteriaException) {
            return "Preference type only allows for 'gain' or 'cost' types!"
        }


        return config.getAggregator().calculate(lambda, stepResult);
    }

}