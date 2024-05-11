<?php


Flight::group('/results', function () {
    /**
     * @OA\Get(
     *      path="/results",
     *      tags={"Results"},
     *      summary="Get all results",
     *     security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Get all results"
     *      ),
     *     
     *   @OA\Parameter(@OA\Schema(type="number"), in="query", name="tournamentID", example="1", description="Tournament ID"),
     *   @OA\Parameter(@OA\Schema(type="number"), in="query", name="clubMemberID", example="1", description="Member ID"),
     * )
     */
    Flight::route('GET /', function(){
        $userID = Flight::get('user')->appUserID;
        $resultService = new ResultService(new ResultDao($userID));

        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        $tournamentID = Flight::request()->query['tournamentID'];
        $clubMemberID = Flight::request()->query['clubMemberID'];

        if ($tournamentID != NULL) {
            $results = $resultService->getResultsByTournamentID($tournamentID);
        } else if ($clubMemberID != NULL) {
            $results = $resultService->getResultsByClubMemberID($clubMemberID);
        } else if ($offset == NULL && $limit == NULL) {
            $results = $resultService->getAllResults();
        } else {
            $results = $resultService->getResults($offset, $limit, '-resultID');
        }

        Flight::json($results);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Get(
     *      path="/results/{id}",
     *      tags={"Results"},
     *      summary="Get a result by ID",
     *    security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Get a result by ID"
     *      ),
     *    
     *   @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Result ID")
     * )
     */
    Flight::route('GET /@id', function($id){

        $userID = Flight::get('user')->appUserID;
        $resultService = new ResultService(new ResultDao($userID));
        $result = $resultService->getResultByID($id);
        Flight::json($result);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Post(
     *      path="/results",
     *      tags={"Results"},
     *      summary="Create a result",
     *    security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Create a result"
     *      ),
     *      @OA\RequestBody(
     *          description="Result data payload",
     *          @OA\JsonContent(
     *              required={"opponentFirstName","opponentLastName","resultStatus", "clubMemberID", "tournamentID", "appUserID"},
     *              @OA\Property(property="opponentFirstName", type="string", example="Some first name", description="Opponent first name"),
     *              @OA\Property(property="opponentLastName", type="string", example="Some last name", description="Opponent last name"),
     *              @OA\Property(property="resultStatus", type="string", example="VICTORY", description="Result status"),
     *              @OA\Property(property="clubMemberID", type="number", example="1", description="Member ID"),
     *              @OA\Property(property="tournamentID", type="number", example="1", description="Tournament ID"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *     
     * )
     */
    Flight::route('POST /', function(){

        $userID = Flight::get('user')->appUserID;
        $data = Flight::request()->data->getData();
        $resultService = new ResultService(new ResultDao($userID));

        if ($data['resultStatus'] == "VICTORY") {
            $memberService = new MemberService(new MemberDao($userID));

            $member = $memberService->getMemberByID($data['clubMemberID']);

            $memberService->updateMember($data['clubMemberID'], array(
                'score' => $member['score'] + 5
            ));
        }

        $response = $resultService->addResult($data);
        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Put(
     *      path="/results/{id}",
     *      tags={"Results"},
     *      summary="Edit a result",
     *   security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Edit a result"
     *      ),
     *      @OA\RequestBody(
     *          description="Result data payload",
     *          @OA\JsonContent(
     *              required={"opponentFirstName","opponentLastName","resultStatus", "clubMemberID", "tournamentID", "appUserID"},
     *              @OA\Property(property="opponentFirstName", type="string", example="Some first name", description="Opponent first name"),
     *              @OA\Property(property="opponentLastName", type="string", example="Some last name", description="Opponent last name"),
     *              @OA\Property(property="resultStatus", type="string", example="VICTORY", description="Result status"),
     *              @OA\Property(property="clubMemberID", type="number", example="1", description="Member ID"),
     *              @OA\Property(property="tournamentID", type="number", example="1", description="Tournament ID"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *    
     *  @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Result ID"),
     * )
     */
    Flight::route('PUT /@id', function($id){
        $userID = Flight::get('user')->appUserID;
        $data = Flight::request()->data->getData();
        $resultService = new ResultService(new ResultDao($userID));

        $response = $resultService->updateResult($id, $data);
        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Delete(
     *      path="/results/{id}",
     *      tags={"Results"},
     *      summary="Delete a result",
     *   security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Delete a result"
     *      ),
     *   
     * @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Result ID"),
     * )
     */
    Flight::route('DELETE /@id', function($id){

        $userID = Flight::get('user')->appUserID;
        $resultService = new ResultService(new ResultDao($userID));
        $response = $resultService->deleteResult($id);
        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });
});


?>