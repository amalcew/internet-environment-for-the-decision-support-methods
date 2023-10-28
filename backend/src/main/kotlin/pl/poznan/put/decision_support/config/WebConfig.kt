package pl.poznan.put.decision_support.config

import org.springframework.beans.factory.annotation.Autowired
import org.springframework.context.annotation.ComponentScan
import org.springframework.context.annotation.Configuration
import org.springframework.web.servlet.config.annotation.EnableWebMvc
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer
import pl.poznan.put.decision_support.config.utils.JwtTokenUtil


@EnableWebMvc
@Configuration
open class WebConfig: WebMvcConfigurer {

    private var jwtTokenUtil: JwtTokenUtil? = null

    @Autowired
    fun WebConfig(jwtTokenUtil: JwtTokenUtil?) {
        this.jwtTokenUtil = jwtTokenUtil
    }
    override fun addResourceHandlers(registry: ResourceHandlerRegistry) {
        registry.addResourceHandler("swagger-ui.html")
            .addResourceLocations("classpath:/META-INF/resources/")
        registry.addResourceHandler("/webjars/**")
            .addResourceLocations("classpath:/META-INF/resources/webjars/")
    }
}