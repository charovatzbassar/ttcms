<?php

require_once __DIR__ . '/../utils/Utils.class.php';

Flight::group('/registrations', function () {
    /**
     * @OA\Get(
     *      path="/registrations",
     *      tags={"Registrations"},
     *      summary="Get all registrations",
     *      @OA\Response(
     *           response=200,
     *           description="Get all registrations"
     *      )
     * )
     */
    Flight::route('GET /', function(){
        $userID = Flight::request()->query['userID'];
        $registrationService = new RegistrationService(new RegistrationDao($userID));

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

    /**
     * @OA\Get(
     *      path="/registrations/{id}",
     *      tags={"Registrations"},
     *      summary="Get a registration by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Get a registration by ID"
     *      )
     * )
     */
    Flight::route('GET /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $registrationService = new RegistrationService(new RegistrationDao($userID));
        $registration = $registrationService->getRegistrationByID($id);
        Flight::json($registration);
    });

    /**
     * @OA\Post(
     *      path="/registrations",
     *      tags={"Registrations"},
     *      summary="Create a registration",
     *      @OA\Response(
     *           response=200,
     *           description="Create a registration"
     *      )
     * )
     */
    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $registrationService = new RegistrationService(new RegistrationDao());

        
        $response = $registrationService->addRegistration($data);
        Flight::json($response);
    });

    /**
     * @OA\Put(
     *      path="/registrations/{id}",
     *      tags={"Registrations"},
     *      summary="Edit a registration",
     *      @OA\Response(
     *           response=200,
     *           description="Edit a registration"
     *      )
     * )
     */
    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $userID = Flight::request()->query['userID'];
        $registrationService = new RegistrationService(new RegistrationDao($userID));

        $response = $registrationService->updateRegistration($id, $data);
        Flight::json($response);
    });

    /**
     * @OA\Put(
     *      path="/registrations/{id}/{status}",
     *      tags={"Registrations"},
     *      summary="Edit a registration's status",
     *      @OA\Response(
     *           response=200,
     *           description="Edit a registration's status"
     *      )
     * )
     */
    Flight::route('PUT /@id/@status', function($id, $status){
        $userID = Flight::request()->query['userID'];
        $registrationService = new RegistrationService(new RegistrationDao($userID));

        if ($status == "ACCEPTED") {
            $memberService = new MemberService(new MemberDao($userID));
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
                "appUserID" => $userID,
            );

            $memberService->addMember($memberData);
        }

        
        $response = $registrationService->setRegistrationStatus($id, $status);
        Flight::json($response);
    });

    /**
     * @OA\Delete(
     *      path="/registrations/{id}",
     *      tags={"Registrations"},
     *      summary="Delete a registration",
     *      @OA\Response(
     *           response=200,
     *           description="Delete a registration"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $registrationService = new RegistrationService(new RegistrationDao($userID));

        $response = $registrationService->deleteRegistration($id);
        Flight::json($response);
    });
});

?>