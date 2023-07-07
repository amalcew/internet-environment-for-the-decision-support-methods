package pl.poznan.put.decision_support.sample.repository

import org.springframework.data.repository.CrudRepository
import org.springframework.stereotype.Repository
import pl.poznan.put.decision_support.sample.model.User


@Repository
interface UserRepository : CrudRepository<User?, Long?>