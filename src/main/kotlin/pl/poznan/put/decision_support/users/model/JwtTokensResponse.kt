package pl.poznan.put.decision_support.users.model

data class JwtTokensResponse(
    val accessToken: String,
    val refreshToken: String
)
