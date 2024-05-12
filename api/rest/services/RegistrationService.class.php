<?php
require_once __DIR__.'/../dao/RegistrationDao.class.php';

class RegistrationService {
    private $registrationDao;

    public function __construct($registrationDao) {
        $this->registrationDao = $registrationDao;
    }

    public function getAllRegistrations() {
        return $this->registrationDao->getAllRegistrations();
    }

    public function getRegistrations($page, $offset, $limit, $search, $order_column, $order_direction) {
        return $this->registrationDao->getRegistrations($page, $offset, $limit, $search, $order_column, $order_direction);
    }

    public function getRegistrationsByStatus($status) {
        return $this->registrationDao->getRegistrationsByStatus($status);
    }

    public function getRegistrationByID($id) {
        return $this->registrationDao->getRegistrationByID($id);
    }

    public function addRegistration($registration) {
        return $this->registrationDao->addRegistration($registration);
    }

    public function updateRegistration($id, $registration) {
        return $this->registrationDao->updateRegistration($id, $registration);
    }

    public function deleteRegistration($id) {
        return $this->registrationDao->deleteRegistration($id);
    }

    public function setRegistrationStatus($id, $status) {
        return $this->registrationDao->setRegistrationStatus($id, $status);
    }

}

?>