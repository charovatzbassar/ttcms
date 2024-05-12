<?php


Flight::group('/tournaments', function () {
    /**
     * @OA\Get(
     *      path="/tournaments",
     *      tags={"Tournaments"},
     *      summary="Get all tournaments",
     *     security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Get all tournaments"
     *      ),
     *     
     * )
     */
    Flight::route('GET /', function(){

        $userID = Flight::get('user')->appUserID;
        $tournamentService = new TournamentService(new TournamentDao($userID));

        $allTournaments = $tournamentService->getAllTournaments();

        $body = Flight::request()->query;

        if (count($body) == 0) {
            Flight::json($allTournaments);
            return;
        }

        $params = [
            'page' => isset($body['page']) ? $body['page'] : "",
            'start' => isset($body['start']) ? (int)$body['start'] : 0,
            'search' => isset($body['search']['value']) ? $body['search']['value'] : "",
            'draw' => isset($body['draw']) ? (int)$body['draw'] : 0,
            'limit' => isset($body['length']) ? (int)$body['length'] : 10,
            'order_column' => isset($body['order'][0]['name']) ? $body['order'][0]['name'] : "tournamentID",
            'order_direction' => isset($body['order'][0]['dir']) ? $body['order'][0]['dir'] : "asc"
        ];

        $tournaments = $tournamentService->getTournaments(
            $params['page'],
            $params['start'],
            $params['limit'],
            $params['search'],
            $params['order_column'],
            $params['order_direction']
        );

        foreach ($tournaments as $id => $tournament) {
            $tournaments[$id]['tournamentName'] = '<a href="?id='.$tournament['tournamentID'].'#tournament-info" class="text-black">'.$tournament['tournamentName'].'</a>';
        }

        
        Flight::json([
            "draw" => $params['draw'],
            "recordsTotal" => count($allTournaments),
            "recordsFiltered" => count($allTournaments),
            'end' => count($tournaments),
            "data" => $tournaments
        
        ], 200);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Get(
     *      path="/tournaments/{id}",
     *      tags={"Tournaments"},
     *      summary="Get a tournament by ID",
     *    security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Get a tournament by ID"
     *      ),
     *    
     *   @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Tournament ID"),
     * )
     */
    Flight::route('GET /@id', function($id){

        $userID = Flight::get('user')->appUserID;
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $tournament = $tournamentService->getTournamentByID($id);
        Flight::json($tournament);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Post(
     *      path="/tournaments",
     *      tags={"Tournaments"},
     *      summary="Create a tournament",
     *   security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Create a tournament"
     *      ),
     *      @OA\RequestBody(
     *          description="Tournament data payload",
     *          @OA\JsonContent(
     *              required={"tournamentName","tournamentDate","tournamentLocation", "tournamentStatus", "appUserID"},
     *              @OA\Property(property="tournamentName", type="string", example="Some tournament name", description="Tournament name"),
     *              @OA\Property(property="tournamentDate", type="string", example="2024-01-01", description="Tournament date"),
     *              @OA\Property(property="tournamentLocation", type="string", example="Belgrade", description="Tournament location"),
     *              @OA\Property(property="tournamentStatus", type="string", example="UPCOMING", description="Tournament status"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *    
     * )
     */
    Flight::route('POST /', function(){

        $userID = Flight::get('user')->appUserID;
        $data = Flight::request()->data->getData();
        $tournamentService = new TournamentService(new TournamentDao($userID));

        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));

        $tournamentCategories = $data['categories'];
        $tournament = [
            'tournamentName' => $data['tournamentName'],
            'tournamentDate' => $data['tournamentDate'],
            'tournamentLocation' => $data['tournamentLocation'],
            'tournamentStatus' => $data['tournamentStatus'],
            'appUserID' => $userID
        ];


        $response = $tournamentService->addTournament($tournament);

        foreach ($tournamentCategories as $tournamentCategory) {
            $tournamentCategoryService->addTournamentCategory([
                'tournamentID' => $response['id'],
                'category' => $tournamentCategory,
                'appUserID' => $userID
            ]);
        }

        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Put(
     *      path="/tournaments/{id}",
     *      tags={"Tournaments"},
     *      summary="Edit a tournament",
     *   security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Edit a tournament"
     *      ),
     *      @OA\RequestBody(
     *          description="Tournament data payload",
     *          @OA\JsonContent(
     *              required={"tournamentName","tournamentDate","tournamentLocation", "tournamentStatus", "appUserID"},
     *              @OA\Property(property="tournamentName", type="string", example="Some tournament name", description="Tournament name"),
     *              @OA\Property(property="tournamentDate", type="string", example="2024-01-01", description="Tournament date"),
     *              @OA\Property(property="tournamentLocation", type="string", example="Belgrade", description="Tournament location"),
     *              @OA\Property(property="tournamentStatus", type="string", example="UPCOMING", description="Tournament status"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *   
     *  @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Tournament ID"),
     * )
     */
    Flight::route('PUT /@id', function($id){

        $userID = Flight::get('user')->appUserID;
        $data = Flight::request()->data->getData();
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));

        $tournamentCategories = $data['categories'];
        $tournament = [
            'tournamentName' => $data['tournamentName'],
            'tournamentDate' => $data['tournamentDate'],
            'tournamentLocation' => $data['tournamentLocation'],
            'appUserID' => $userID
        ];

        $response = $tournamentService->updateTournament($id, $tournament);

        $tournamentCategoryService->deleteTournamentCategoriesForTournament($id);

        foreach ($tournamentCategories as $tournamentCategory) {
            $tournamentCategoryService->addTournamentCategory([
                'tournamentID' => $response['tournamentID'],
                'category' => $tournamentCategory,
                'appUserID' => $userID
            ]);
        }

        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Put(
     *      path="/tournaments/{id}/complete",
     *      tags={"Tournaments"},
     *      summary="Mark a tournament as completed",
     *  security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Mark a tournament as completed"
     *      ),
     *  
     * @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Tournament ID"),
     * )
     */
    Flight::route('PUT /@id/complete', function($id){

        $userID = Flight::get('user')->appUserID;
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $response = $tournamentService->markTournamentAsCompleted($id);
        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });

    /**
     * @OA\Delete(
     *      path="/tournaments/{id}",
     *      tags={"Tournaments"},
     *      summary="Delete a tournament",
     *  security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Delete a tournament"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id){

        $userID = Flight::get('user')->appUserID;
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $resultService = new ResultService(new ResultDao($userID));
        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
        $resultService->deleteResultsForTournament($id);
        $tournamentCategoryService->deleteTournamentCategoriesForTournament($id);

        $response = $tournamentService->deleteTournament($id);
        Flight::json($response);
    })->addMiddleware(function(){
        AuthMiddleware();
    });
});

?>