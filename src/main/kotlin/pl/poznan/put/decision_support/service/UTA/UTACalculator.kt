package pl.poznan.put.decision_support.service.UTA

import com.quantego.clp.CLP
import org.ojalgo.optimisation.Expression
import org.ojalgo.optimisation.ExpressionsBasedModel
import org.ojalgo.optimisation.Variable
import pl.poznan.put.decision_support.model.domain.UTA.UTADataModel
import pl.poznan.put.decision_support.model.domain.UTA.UTAResponse


class UTACalculator {

    fun calculate(utaDataModel: UTADataModel): UTAResponse {
        //TODO implement UTA method using linear programming
        return UTAResponse(listOf())
    }
}

/* Example of constructing optimisation problem
    val model = ExpressionsBasedModel()
        //Max Z = 50X + 120Y
        //Max Z = 50X + 120Y
        val X: Variable = model.addVariable("Area for Wheat").weight(50)
        val Y: Variable = model.addVariable("Area for barley").weight(120)
        //100X + 200Y ≤ 10000
        //100X + 200Y ≤ 10000
        val cost: Expression = model.addExpression("Cost") //
            .upper(10000) //
            .lower(0)
        cost.set(X, 100).set(Y, 200)
//10X + 20Y ≤ 1200
//10X + 20Y ≤ 1200
        val manDays: Expression = model.addExpression("ManDays") //
            .upper(1200) //
            .lower(0)
        manDays.set(X, 10).set(Y, 30)
//X + Y ≤ 110
//X + Y ≤ 110
        val totalArea: Expression = model.addExpression("TotalArea") //
            .upper(110) //
            .lower(0)
        totalArea.set(X, 1).set(Y, 1)
        val result = model.maximise()
 */