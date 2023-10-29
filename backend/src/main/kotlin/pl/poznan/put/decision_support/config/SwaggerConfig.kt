package pl.poznan.put.decision_support.config

import io.swagger.v3.oas.models.Components
import io.swagger.v3.oas.models.OpenAPI
import io.swagger.v3.oas.models.info.Info
import io.swagger.v3.oas.models.security.SecurityRequirement
import io.swagger.v3.oas.models.security.SecurityScheme
import org.springframework.context.annotation.Bean
import org.springframework.context.annotation.Configuration


@Configuration
class SwaggerConfig {

    @Bean
    fun openAPI(): OpenAPI? {
        return OpenAPI()
                .info(Info()
                        .title("Decision Support API")
                        .version("1.0")
                        .description("REST endpoints for Decision Support API. Developed for the needs of the Decision Support Systems course at Poznan University of Technology."))
    }
}