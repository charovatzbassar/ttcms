<?php
require_once __DIR__.'/../dao/UserDao.class.php';

class UserService {
    private $userDao;

    public function __construct($userDao) {
        $this->userDao = $userDao;
    }

    public function getAllUsers() {
        return $this->userDao->getAllUsers();
    }

    public function getUsers($offset, $limit, $order) {
        return $this->userDao->getUsers($offset, $limit, $order);
    }

    public function getUserByID($id) {
        return $this->userDao->getUserByID($id);
    }

    public function addUser($user) {
        return $this->userDao->addUser($user);
    }

    public function updateUser($id, $user) {
        return $this->userDao->updateUser($id, $user);
    }

    public function deleteUser($id) {
        return $this->userDao->deleteUser($id);
    }

    public function getUserByEmail($email) {
        return $this->userDao->getUserByEmail($email);
    }


}

?>