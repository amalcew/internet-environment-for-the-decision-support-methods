# Decision support system 

## How to run

`````code
docker build . -t decision-support-web-backend:1.0.0

docker compose -f ./docker/docker-compose.yml up -d
`````

## How to test

`````code
./gradlew clean bootRun
`````
**Docker required!**  
Docker compose will start the database and the application.
This command will automatically build and run the application. And start the server on port 8080.
Also you can run the application from your IDE.

## Authentication Guide for the Application

To access the features of the application, you need to authenticate using JSON Web Tokens (JWT). Below are the steps to obtain and use these tokens.

### 1. Logging In

To log in and acquire an access token and a refresh token, make an HTTP POST request to the following endpoint:

- **Command**: `POST`
- **Endpoint**: `/auth/login`
- **Include Token in Headers**: Yes

Please provide your login credentials in JSON format within the request body. For example:

```json
{
  "email": "your_email@example.com",
  "password": "YourPassword"
}
```

## Token Refresh Guide

To refresh your access token in the application, you can use the provided refresh token. Follow the steps below to obtain a new access token.

### 1. Request Token Refresh

To refresh your access token, make an HTTP POST request to the following endpoint:

- **Command**: `POST`
- **Endpoint**: `/auth/refresh`
- **Include Token in Headers**: Yes

Include your refresh token as a parameter in the request, like this:
```
POST /auth/refresh?refreshToken=YourRefreshToken
```

### 2. Receive New Access Token

Upon a successful request, you will receive a new access token (JWT) along with its expiration date. The new token can be used to access the application's resources.

### Security Considerations

- **Token Expiry**: Be aware that access tokens have a limited lifespan. Ensure you use the new access token when the old one expires.

- **Token Security**: Keep your tokens secure and do not share them with third parties.

You have successfully refreshed your access token and can continue using the application. If you have any questions or need further assistance, please don't hesitate to contact us.


## Build with

<div>
 <img src="https://skillicons.dev/icons?i=kotlin,spring,postgres,docker,git&perline=5" alt="Tech Stack" />
</div>