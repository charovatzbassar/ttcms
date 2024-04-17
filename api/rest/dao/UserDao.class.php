<?php

require_once __DIR__.'/BaseDao.class.php';

class UserDao extends BaseDao {

    public function __construct() {
        parent::__construct("appUser");
    }

    public function getAllUsers() {
        return $this->get_all();
    }

    public function getUsers($offset, $limit, $order) {
        return $this->get($offset, $limit, $order);
    }

    public function getUserByID($id) {
        return $this->get_by_id($id, "appUserID");
    }

    public function getUserByEmail($email) {
        return $this->queryUnique("SELECT * FROM appUser WHERE email = :email", ["email" => $email]);
    }

    public function addUser($user) {
        $this->add($user);
    }

    public function updateUser($id, $user) {
        $this->update($id, $user, "appUserID");
    }

    public function deleteUser($id) {
        $this->delete($id, "appUserID");
    }
}

?>