<?php

require_once __DIR__.'/BaseDao.class.php';

class RegistrationDao extends BaseDao {
    private $userID;

    public function __construct($userID = NULL) {
        parent::__construct("registration", $userID);
        $this->userID = $userID;
    }

    public function getAllRegistrations() {
        return $this->get_all();
    }

    public function getRegistrationsByStatus($status) {
        return $this->query("SELECT * FROM registration WHERE registrationStatus = :status and appUserID = :appUserID", ["status" => $status, "appUserID" => $this->userID]);
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
        return $this->query("UPDATE registration SET registrationStatus = :registrationStatus WHERE registrationID = :registrationID and appUserID = :appUserID", ["registrationID" => $id, "registrationStatus" => $status, "appUserID" => $this->userID]);
    }
}

?>