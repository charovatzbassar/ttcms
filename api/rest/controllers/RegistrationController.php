<?php

require_once __DIR__ . '/../utils/Utils.class.php';

Flight::group('/registrations', function () {
    Flight::route('GET /', function(){
        $registrationService = new RegistrationService(new RegistrationDao());

        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        $status = Flight::request()->query['status'];

        if ($status != NULL) {
            $registrations = $registrationService->getRegistrationsByStatus($status);
        } else if ($offset == NULL && $limit == NULL) {
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

        
        $response = $registrationService->addRegistration($data);
        Flight::json($response);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $registrationService = new RegistrationService(new RegistrationDao());
        
        $response = $registrationService->updateRegistration($id, $data);
        Flight::json($response);
    });

    Flight::route('PUT /@id/@status', function($id, $status){
        $registrationService = new RegistrationService(new RegistrationDao());

        if ($status == "ACCEPTED") {
            $memberService = new MemberService(new MemberDao());
            $registration = $registrationService->getRegistrationByID($id);
            
            $memberData = array(
                "firstName" => $registration['firstName'],
                "lastName" => $registration['lastName'],
                "dateOfBirth" => $registration['dateOfBirth'],
                "joinDate" => date("Y-m-d"),
                "birthplace" => $registration['birthplace'],
                "gender" => $registration['gender'],
                "membershipStatus" => "UNPAID",
                "category" => Utils::calculateCategory($registration['dateOfBirth']),
                "score" => 0,
                "appUserID" => 1,
            );

            $memberService->addMember($memberData);
        }

        
        $response = $registrationService->setRegistrationStatus($id, $status);
        Flight::json($response);
    });

    Flight::route('DELETE /@id', function($id){
        $registrationService = new RegistrationService(new RegistrationDao());
        
        $response = $registrationService->deleteRegistration($id);
        Flight::json($response);
    });
});

?>