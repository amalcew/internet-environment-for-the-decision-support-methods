package pl.poznan.put.decision_support.decisionmethods.utils.functioncalculator

import kotlin.math.pow

fun Double.round(decimals: Int = 2): Float = (this * 10F.pow(decimals)).toInt() / 10F.pow(decimals)