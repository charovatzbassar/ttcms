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

    public function getRegistrations($offset, $limit, $order) {
        return $this->registrationDao->getRegistrations($offset, $limit, $order);
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