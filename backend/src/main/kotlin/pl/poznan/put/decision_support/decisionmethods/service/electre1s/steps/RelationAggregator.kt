package pl.poznan.put.decision_support.service.electre1s.steps

import pl.poznan.put.decision_support.decisionmethods.exception.InvalidShapeException
import pl.poznan.put.decision_support.service.electre_shared.steps.AggregatorInterface
import java.util.*

class RelationAggregator : AggregatorInterface {
//    TODO: how does it take opposite in Tri? Is it another table bRa? -> Spytać kogoś mądrego, bo nie ma w pdfach...
    /**
     * based on 'final' in context
     */
    override fun calculate(
        lambda: Double,
        stepResult: LinkedList<Any>,
        context: MutableMap<String, Any>
    ) {
        val final: Array<Array<Double>> = context["final"] as Array<Array<Double>>;
        val x: Int = final.size;
        val y: Int = final[0].size
        if (x != y) {
            throw InvalidShapeException("matrix has to be a square");
        }

        val relations: Array<Array<String>> = Array(x) { Array(x) { "?" } }

        for (row in final.indices) {
            for (column in 0 until final[row].size) {
                val aSb = final[row][column]
                val bSa = final[column][row]
                if (aSb == 1.0 && bSa == 1.0) {
                    relations[row][column] = "I"
                } else if (aSb == 1.0 && bSa == 0.0) {
                    relations[row][column] = "P"
                } else if (aSb == 0.0 && bSa == 1.0) {
                    relations[row][column] = "-P"
                } else if (aSb == 0.0 && bSa == 0.0) {
                    relations[row][column] = "R"
                }

            }
        }
        context["relations"] = relations
        removeCycles(context)
    }

    fun removeCycles(context: MutableMap<String, Any>) {
        val relations: Array<Array<String>> = context["relations"] as Array<Array<String>>
        val mergedNodesMap: MutableMap<Int, MutableList<Int>> = mutableMapOf()
        val relationsFinal = relations.map { it.clone() }.toTypedArray()

        var cycles = findCycles(relationsFinal)
        while (cycles.isNotEmpty()) {
            for (cycle in cycles) {
                mergeCycleNodes(relationsFinal, cycle, mergedNodesMap)
            }
            cycles = findCycles(relationsFinal)
        }
        val filteredRelations = removeEmptyRowsAndColumns(relationsFinal)

        context["final_relations"] = filteredRelations
        context["merged_nodes"] = mergedNodesMap
    }

    private fun mergeCycleNodes(relations: Array<Array<String>>, cycle: List<Int>, mergedNodesMap: MutableMap<Int, MutableList<Int>>) {
        val mergedNodeIndex = cycle.minOrNull() ?: return

        mergedNodesMap[mergedNodeIndex] = mutableListOf()

        for (i in cycle) {
            if (i != mergedNodeIndex) {
                mergedNodesMap[mergedNodeIndex]?.add(i)
                for (j in relations.indices) {
                    if (relations[i][j] != "-" && j != i) {
                        relations[mergedNodeIndex][j] = relations[i][j]
                    }
                    if (relations[j][i] != "-" && j != i) {
                        relations[j][mergedNodeIndex] = relations[j][i]
                    }
                    relations[i][j] = "-"
                    relations[j][i] = "-"
                }
            }
        }
    }

    private fun removeEmptyRowsAndColumns(relations: Array<Array<String>>): Array<Array<String>> {
        val filteredRows = relations.filter { row -> row.any { it != "-" } }

        val columnIndicesToKeep = mutableListOf<Int>()
        if (filteredRows.isNotEmpty()) {
            for (i in filteredRows[0].indices) {
                if (filteredRows.any { row -> row[i] != "-" }) {
                    columnIndicesToKeep.add(i)
                }
            }
        }

        return filteredRows.map { row ->
            columnIndicesToKeep.map { columnIndex -> row[columnIndex] }.toTypedArray()
        }.toTypedArray()
    }

    private fun mergeCycleNodes(relations: Array<Array<String>>,cycle: List<Int>) {
        val mergedNodeIndex = cycle.minOrNull() ?: return

        for (i in cycle) {
            if (i != mergedNodeIndex) {
                for (j in relations.indices) {
                    if (relations[i][j] != "-" && j != i) {
                        relations[mergedNodeIndex][j] = relations[i][j]
                    }
                    if (relations[j][i] != "-" && j != i) {
                        relations[j][mergedNodeIndex] = relations[j][i]
                    }
                    relations[i][j] = "-"
                    relations[j][i] = "-"
                }
            }
        }
    }

    private fun findCycles(relations: Array<Array<String>>): List<List<Int>> {
        val visited = BooleanArray(relations.size) { false }
        val recStack = BooleanArray(relations.size) { false }
        val cycles = mutableListOf<List<Int>>()

        for (x in relations.indices) {
            for (y in relations[x].indices) {
                if (x != y && (relations[x][y] == "I" || relations[x][y] == "-P") && !visited[y]) {
                    if (dfs(y, visited, recStack, relations, mutableListOf(x), cycles)) {
                        break
                    }
                }
            }
        }

        return cycles
    }

    private fun dfs(
        current: Int,
        visited: BooleanArray,
        recStack: BooleanArray,
        relations: Array<Array<String>>,
        path: MutableList<Int>,
        cycles: MutableList<List<Int>>
    ): Boolean {
        if (recStack[current]) {
            cycles.add(path.toList())
            return true
        }
        if (visited[current]) {
            return false
        }

        visited[current] = true
        recStack[current] = true
        path.add(current)

        for (i in relations[current].indices) {
            if (relations[current][i] == "I" && dfs(i, visited, recStack, relations, path, cycles)) {
                return true
            }
        }

        recStack[current] = false
        path.removeAt(path.size - 1)
        return false
    }

}