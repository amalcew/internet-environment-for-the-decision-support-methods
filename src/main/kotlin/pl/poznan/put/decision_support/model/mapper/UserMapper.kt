package pl.poznan.put.decision_support.model.mapper

import pl.poznan.put.decision_support.model.domain.User
import pl.poznan.put.decision_support.model.entity.UserEntity

fun User.mapToUserEntity() = UserEntity(
    name = name,
    password = password,
    email = email,
    age = age,
    url = url
)

fun UserEntity.mapToUser() = User(
    id = id,
    name = name,
    password = password,
    email = email,
    age = age,
    url = url
)