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
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="query", name="userID", example="1", description="User ID")
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
     *      ),
     *     @OA\Parameter(@OA\Schema(type="number"), in="query", name="userID", example="1", description="User ID"),
     *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Registration ID"),
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
     *      ),
     *      @OA\RequestBody(
     *          description="Registration data payload",
     *          @OA\JsonContent(
     *              required={"firstName","lastName","dateOfBirth", "birthplace", "gender", "email", "registrationStatus", "appUserID"},
     *              @OA\Property(property="firstName", type="string", example="Some first name", description="Registration first name"),
     *              @OA\Property(property="lastName", type="string", example="Some last name", description="Registration last name"),
     *              @OA\Property(property="dateOfBirth", type="string", example="2024-01-01", description="Registration date of birth"),
     *              @OA\Property(property="email", type="string", example="example@mail.com", description="Registration email"),
     *              @OA\Property(property="birthplace", type="string", example="Belgrade", description="Registration birthplace"),
     *              @OA\Property(property="gender", type="string", example="MALE", description="Registration gender"),
     *              @OA\Property(property="registrationStatus", type="string", example="Pending", description="Registration status"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *     @OA\Parameter(@OA\Schema(type="number"), in="query", name="userID", example="1", description="User ID"),
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
     *      ),
     *      @OA\RequestBody(
     *          description="Registration data payload",
     *          @OA\JsonContent(
     *              required={"firstName","lastName","dateOfBirth", "birthplace", "gender", "email", "registrationStatus", "appUserID"},
     *              @OA\Property(property="firstName", type="string", example="Some first name", description="Registration first name"),
     *              @OA\Property(property="lastName", type="string", example="Some last name", description="Registration last name"),
     *              @OA\Property(property="dateOfBirth", type="string", example="2024-01-01", description="Registration date of birth"),
     *              @OA\Property(property="email", type="string", example="example@mail.com", description="Registration email"),
     *              @OA\Property(property="birthplace", type="string", example="Belgrade", description="Registration birthplace"),
     *              @OA\Property(property="gender", type="string", example="MALE", description="Registration gender"),
     *              @OA\Property(property="registrationStatus", type="string", example="Pending", description="Registration status"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *    @OA\Parameter(@OA\Schema(type="number"), in="query", name="userID", example="1", description="User ID"),
     *   @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Registration ID"),
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
     *      ),
     *   @OA\Parameter(@OA\Schema(type="number"), in="query", name="userID", example="1", description="User ID"),
     *   @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Registration ID"),
     *   @OA\Parameter(@OA\Schema(type="string"), in="path", name="status", example="ACCEPTED", description="Registration Status"),
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
     *      ),
     *   @OA\Parameter(@OA\Schema(type="number"), in="query", name="userID", example="1", description="User ID"),
     *  @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Registration ID"),
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