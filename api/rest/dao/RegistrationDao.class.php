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

    public function getRegistrations($page, $offset, $limit, $search, $order_column, $order_direction) {
        return $this->query("SELECT CONCAT(firstName, ' ', lastName) as name, email, gender, birthplace, dateOfBirth, registrationID
        from registration where appUserID = :appUserID AND registrationStatus = 'PENDING' AND (LOWER(CONCAT(firstName, ' ', lastName)) LIKE CONCAT('%', :search, '%') 
        OR dateOfBirth LIKE CONCAT('%', :search, '%') OR LOWER(birthplace) LIKE CONCAT('%', :search, '%') OR LOWER(gender) LIKE CONCAT('%', :search, '%') OR email LIKE CONCAT('%', :search, '%'))  
        ORDER BY {$order_column} {$order_direction} LIMIT {$offset}, {$limit}", ["appUserID" => $this->userID, "search" => strtolower($search)]);
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