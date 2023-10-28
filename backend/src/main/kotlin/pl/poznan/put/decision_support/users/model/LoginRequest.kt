package pl.poznan.put.decision_support.users.model

data class LoginRequest(
    val email: String,
    val password: String
)
