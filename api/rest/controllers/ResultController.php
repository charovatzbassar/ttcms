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

        $allResults = $resultService->getAllResults();

        $body = Flight::request()->query;

        if (count($body) == 0) {
            Flight::json($allResults);
            return;
        }


        $tournamentID = $body['tournamentID'];
        $clubMemberID = $body['clubMemberID'];

        if ($tournamentID != NULL && count($body) == 1) {
            $results = $resultService->getAllResultsByTournamentID($tournamentID);
            Flight::json($results);
            return;
        } else if ($clubMemberID != NULL && count($body) == 1) {
            $results = $resultService->getAllResultsByClubMemberID($clubMemberID);
            Flight::json($results);
            return;
        } 
        

        $params = [
            'start' => isset($body['start']) ? (int)$body['start'] : 0,
            'search' => isset($body['search']['value']) ? $body['search']['value'] : "",
            'draw' => isset($body['draw']) ? (int)$body['draw'] : 0,
            'limit' => isset($body['length']) ? (int)$body['length'] : 10,
            'order_column' => isset($body['order'][0]['name']) ? $body['order'][0]['name'] : "resultID",
            'order_direction' => isset($body['order'][0]['dir']) ? $body['order'][0]['dir'] : "asc"
        ];


        if ($tournamentID != NULL) {
            $results = $resultService->getResultsByTournamentID(
                $tournamentID, 
                $params['start'],
                $params['limit'],
                $params['search'],
                $params['order_column'],
                $params['order_direction']
            );
            foreach ($results as $key => $result) {
                $splitName = explode(' ', $result['opponentName']);
                $results[$key]['actions'] = '<button class="btn btn-warning w-50" id="'.$result['resultID'].'" onclick="handleEditResult('.$result['clubMemberID'].', \''.$splitName[0].'\', \''.$splitName[1].'\', \''.$result['resultStatus'].'\', '.$result['resultID'].')">Edit</button><button class="btn btn-danger w-50" onclick="handleRemoveResult('.$result['resultID'].')">Remove</button>';
            }

        } else if ($clubMemberID != NULL) {
            $results = $resultService->getResultsByClubMemberID(
                $clubMemberID, 
                $params['start'],
                $params['limit'],
                $params['search'],
                $params['order_column'],
                $params['order_direction']
            );
        }

        
        Flight::json([
            "draw" => $params['draw'],
            "recordsTotal" => count($allResults),
            "recordsFiltered" => count($allResults),
            'end' => count($results),
            "data" => $results
        
        ], 200);




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

        $response = $resultService->addResult(array_merge($data, ['appUserID' => $userID]));
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

        $response = $resultService->updateResult($id, array_merge($data, ['appUserID' => $userID]));
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