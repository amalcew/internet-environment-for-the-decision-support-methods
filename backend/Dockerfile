#!/bin/bash


FROM amazoncorretto:17 as builder
WORKDIR /opt/docker
USER root
COPY gradle/ gradle/
COPY gradlew gradlew
COPY build.gradle.kts build.gradle.kts
COPY settings.gradle.kts settings.gradle.kts
COPY ./src ./src
RUN ./gradlew clean build -x test

FROM amazoncorretto:17 as base
ENV JAVA_TOOL_OPTIONS -agentlib:jdwp=transport=dt_socket,address=*:8000,server=y,suspend=n
ARG JAR_FILE=build/libs/*.jar
WORKDIR /opt/docker
COPY --from=builder /opt/docker/build/libs/*.jar /opt/docker/*.jar
EXPOSE 8080 8000
ENTRYPOINT ["java", "-jar", "/opt/docker/*.jar"]