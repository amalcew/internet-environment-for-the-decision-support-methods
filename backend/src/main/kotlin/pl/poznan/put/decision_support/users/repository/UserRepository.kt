package pl.poznan.put.decision_support.users.repository

import io.swagger.v3.oas.annotations.Hidden
import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.users.model.User
@Hidden
@Repository
interface UserRepository : CrudRepository<User?, Long?> {
    fun findUserByName(name: String): User?
}