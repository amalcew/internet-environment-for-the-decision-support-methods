package pl.poznan.put.decision_support.decisionmethods.utils.httpclient

import com.google.gson.Gson

inline fun <reified T> convertFromJson(json: String): T = Gson().fromJson(json, T::class.java)
