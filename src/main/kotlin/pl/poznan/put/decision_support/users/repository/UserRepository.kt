package pl.poznan.put.decision_support.users.repository

import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.users.model.User


@Repository
interface UserRepository : CrudRepository<User?, Long?>