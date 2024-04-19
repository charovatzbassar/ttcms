<?php

require_once __DIR__.'/BaseDao.class.php';

class RegistrationDao extends BaseDao {

    public function __construct() {
        parent::__construct("registration");
    }

    public function getAllRegistrations() {
        return $this->get_all();
    }

    public function getRegistrationsByStatus($status) {
        return $this->query("SELECT * FROM registration WHERE registrationStatus = :status", ["status" => $status]);
    }

    public function getRegistrations($offset, $limit, $order) {
        return $this->get($offset, $limit, $order);
    }

    public function getRegistrationByID($id) {
        return $this->get_by_id($id, "registrationID");
    }

    public function addRegistration($registration) {
        return $this->add($registration);
    }

    public function updateRegistration($id, $registration) {
        return $this->update($id, $registration, "registrationID");
    }

    public function deleteRegistration($id) {
        return $this->delete($id, "registrationID");
    }

    public function setRegistrationStatus($id, $status) {
        return $this->query("UPDATE registration SET registrationStatus = :registrationStatus WHERE registrationID = :registrationID", ["registrationID" => $id, "registrationStatus" => $status]);
    }
}

?>