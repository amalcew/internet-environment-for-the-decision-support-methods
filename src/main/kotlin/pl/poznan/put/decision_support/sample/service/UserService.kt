package pl.poznan.put.decision_support.sample.service

import org.springframework.stereotype.Service
import pl.poznan.put.decision_support.sample.model.User
import pl.poznan.put.decision_support.sample.repository.UserRepository

@Service
class UserService(
    private val userRepository: UserRepository
) {
    fun getAllUser() = userRepository.findAll()

    fun addUser(user: User) = userRepository.save(user)
}