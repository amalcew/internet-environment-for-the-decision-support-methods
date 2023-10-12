package pl.poznan.put.decision_support.users.service

import io.swagger.v3.oas.annotations.Hidden
import org.springframework.stereotype.Service
import pl.poznan.put.decision_support.users.model.User
import pl.poznan.put.decision_support.users.repository.UserRepository

@Hidden
@Service
class UserService(
    private val userRepository: UserRepository
) {
    fun getAllUser(): MutableIterable<User?> = userRepository.findAll()

    fun addUser(user: User): User? = userRepository.save(user)

    fun getUserByName(name: String): User? = userRepository.findUserByName(name)

    fun deleteUser(user: User) = userRepository.delete(user)

    fun updateUser(user: User) = userRepository.save(user)
}