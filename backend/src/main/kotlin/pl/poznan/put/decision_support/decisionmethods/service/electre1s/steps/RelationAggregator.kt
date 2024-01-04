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
        val final: Array<Array<Double>> = context["final"] as Array<Array<Double>>
        val x: Int = final.size
        val y: Int = final[0].size
        if (x != y) {
            throw InvalidShapeException("matrix has to be a square")
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

    private fun removeCycles(context: MutableMap<String, Any>) {
        val relations: Array<Array<String>> = context["relations"] as Array<Array<String>>
        val mergedNodesMap: MutableMap<Int, MutableList<Int>> = mutableMapOf()
        val relationsFinal = relations.map { it.clone() }.toTypedArray()

        var cycles = findCycles(relationsFinal)
        for (cycle in cycles) {
            mergeCycleNodes(relationsFinal, cycle, mergedNodesMap)
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

    private fun findCycles(relations: Array<Array<String>>): List<List<Int>> {
        val n = relations.size
        val successors = Array(n) { mutableListOf<Int>() }
        val cycles = mutableListOf<List<Int>>()

        for (i in 0 until n) {
            for (j in 0 until n) {
                if (i != j && !successors[i].contains(j) && relations[i][j] == "I") {
                    successors[i].add(j)
                }
            }
        }

        var canErase: Boolean
        val stopList = mutableListOf<Int>()
        do {
            canErase = false
            for (i in 0 until n) {
                if (successors[i].isEmpty() && !stopList.contains(i)) {
                    canErase = true
                    stopList.add(i)
                    for (j in 0 until n) {
                        successors[j].remove(i)
                    }
                    successors[i] = mutableListOf()
                }
            }
        } while (canErase)

        // Jeśli po wyczyszczeniu wszystkich wierszy nie zostały żadne, to nie ma cykli
        if (successors.all { it.isEmpty() }) {
            return emptyList()
        }

        // Znalezienie cykli
        for (i in 0 until n) {
            if (successors[i].isNotEmpty()) {
                // Znajdź cykl zaczynając od wierzchołka i
                val cycle = findCycleFromNode(i, successors)
                if (cycle.isNotEmpty()) {
                    cycles.add(cycle)
                }
            }
        }

        return cycles
    }

    private fun findCycleFromNode(start: Int, successors: Array<MutableList<Int>>): MutableList<Int> {
        val visited = BooleanArray(successors.size) { false }
        val stack = mutableListOf<Int>()
        stack.add(start)
        visited[start] = true

        while (stack.isNotEmpty()) {
            val current = stack.last()
            if (successors[current].isEmpty()) {
                // Jeśli nie ma następników, wróć
                visited[current] = false
                stack.removeAt(stack.size - 1)
                continue
            }

            // Sprawdź następniki
            for (next in successors[current]) {
                if (next == start) {
                    // Znaleziono cykl
                    return stack
                }
                if (!visited[next]) {
                    stack.add(next)
                    visited[next] = true
                    break
                }
            }
        }

        return mutableListOf() // Brak cyklu
    }

}