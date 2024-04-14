<?php

Flight::group('/registrations', function () {
    Flight::route('GET /', function(){
        $registrationService = new RegistrationService(new RegistrationDao());

        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        if ($offset == NULL && $limit == NULL) {
            $registrations = $registrationService->getAllRegistrations();
        } else {
            $registrations = $registrationService->getRegistrations($offset, $limit, '-registrationID');
        }

        Flight::json($registrations);
    });

    Flight::route('GET /@id', function($id){
        $registrationService = new RegistrationService(new RegistrationDao());
        $registration = $registrationService->getRegistrationByID($id);
        Flight::json($registration);
    });

    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $registrationService = new RegistrationService(new RegistrationDao());
        $registrationService->addRegistration($data);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $registrationService = new RegistrationService(new RegistrationDao());
        $registrationService->updateRegistration($id, $data);
    });

    Flight::route('PUT /@id/@status', function($id, $status){
        $registrationService = new RegistrationService(new RegistrationDao());
        $registrationService->setRegistrationStatus($id, $status);
    });

    Flight::route('DELETE /@id', function($id){
        $registrationService = new RegistrationService(new RegistrationDao());
        $registrationService->deleteRegistration($id);
    });
});

?>