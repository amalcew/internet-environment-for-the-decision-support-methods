package pl.poznan.put.decision_support.decisionmethods.utils.httpclient

import pl.poznan.put.decision_support.decisionmethods.model.domain.UTA.request.UTARequest

interface HTTPClientManager {
    fun runRequest(url: String,  body: UTARequest): String
}