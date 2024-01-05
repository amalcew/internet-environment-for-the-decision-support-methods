package pl.poznan.put.decision_support.decisionmethods.utils.httpclient


import com.google.gson.Gson
import pl.poznan.put.decision_support.decisionmethods.model.domain.uta.request.UTARequest
import java.net.URI
import java.net.http.HttpClient
import java.net.http.HttpRequest
import java.net.http.HttpResponse

class HTTPClientManagerImpl : HTTPClientManager {

    private val httpClient = HttpClient.newBuilder().version(HttpClient.Version.HTTP_1_1).build()

    override fun runRequest(url: String, body: UTARequest): String {
        val request = HttpRequest.newBuilder()
            .uri(URI.create(url))
            .POST(HttpRequest.BodyPublishers.ofString(Gson().toJson(body)))
            .header("Content-type", "application/json")
            .build()

        val response = httpClient.send(request, HttpResponse.BodyHandlers.ofString())
        return response.body()
    }
}