<?php

Flight::group('/tournaments', function () {
    /**
     * @OA\Get(
     *      path="/tournaments",
     *      tags={"Tournaments"},
     *      summary="Get all tournaments",
     *      @OA\Response(
     *           response=200,
     *           description="Get all tournaments"
     *      )
     * )
     */
    Flight::route('GET /', function(){
        $userID = Flight::request()->query['userID'];
        $tournamentService = new TournamentService(new TournamentDao($userID));

        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        if ($offset == NULL && $limit == NULL) {
            $tournaments = $tournamentService->getAllTournaments();
        } else {
            $tournaments = $tournamentService->getTournaments($offset, $limit, '-tournamentID');
        }

        Flight::json($tournaments);
    });

    /**
     * @OA\Get(
     *      path="/tournaments/{id}",
     *      tags={"Tournaments"},
     *      summary="Get a tournament by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Get a tournament by ID"
     *      )
     * )
     */
    Flight::route('GET /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $tournament = $tournamentService->getTournamentByID($id);
        Flight::json($tournament);
    });

    /**
     * @OA\Post(
     *      path="/tournaments",
     *      tags={"Tournaments"},
     *      summary="Create a tournament",
     *      @OA\Response(
     *           response=200,
     *           description="Create a tournament"
     *      )
     * )
     */
    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $userID = Flight::request()->query['userID'];
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
    });

    /**
     * @OA\Put(
     *      path="/tournaments/{id}",
     *      tags={"Tournaments"},
     *      summary="Edit a tournament",
     *      @OA\Response(
     *           response=200,
     *           description="Edit a tournament"
     *      )
     * )
     */
    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $userID = Flight::request()->query['userID'];
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
    });

    /**
     * @OA\Put(
     *      path="/tournaments/{id}/complete",
     *      tags={"Tournaments"},
     *      summary="Mark a tournament as completed",
     *      @OA\Response(
     *           response=200,
     *           description="Mark a tournament as completed"
     *      )
     * )
     */
    Flight::route('PUT /@id/complete', function($id){
        $userID = Flight::request()->query['userID'];
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $response = $tournamentService->markTournamentAsCompleted($id);
        Flight::json($response);
    });

    /**
     * @OA\Delete(
     *      path="/tournaments/{id}",
     *      tags={"Tournaments"},
     *      summary="Delete a tournament",
     *      @OA\Response(
     *           response=200,
     *           description="Delete a tournament"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $tournamentService = new TournamentService(new TournamentDao($userID));
        $resultService = new ResultService(new ResultDao($userID));
        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
        $resultService->deleteResultsForTournament($id);
        $tournamentCategoryService->deleteTournamentCategoriesForTournament($id);

        $response = $tournamentService->deleteTournament($id);
        Flight::json($response);
    });
});

?>