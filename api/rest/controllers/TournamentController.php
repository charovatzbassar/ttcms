<?php

Flight::group('/tournaments', function () {
    Flight::route('GET /', function(){
        $tournamentService = new TournamentService(new TournamentDao());

        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        if ($offset == NULL && $limit == NULL) {
            $tournaments = $tournamentService->getAllTournaments();
        } else {
            $tournaments = $tournamentService->getTournaments($offset, $limit, '-tournamentID');
        }

        Flight::json($tournaments);
    });

    Flight::route('GET /@id', function($id){
        $tournamentService = new TournamentService(new TournamentDao());
        $tournament = $tournamentService->getTournamentByID($id);
        Flight::json($tournament);
    });

    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $tournamentService = new TournamentService(new TournamentDao());

        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());

        $tournamentCategories = $data['categories'];
        $tournament = [
            'tournamentName' => $data['tournamentName'],
            'tournamentDate' => $data['tournamentDate'],
            'tournamentLocation' => $data['tournamentLocation'],
            'tournamentStatus' => $data['tournamentStatus'],
            'appUserID' => 1
        ];


        $response = $tournamentService->addTournament($tournament);

        foreach ($tournamentCategories as $tournamentCategory) {
            $tournamentCategoryService->addTournamentCategory([
                'tournamentID' => $response['id'],
                'category' => $tournamentCategory,
                'appUserID' => 1
            ]);
        }

        Flight::json($response);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $tournamentService = new TournamentService(new TournamentDao());

        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());

        $tournamentCategories = $data['categories'];
        $tournament = [
            'tournamentName' => $data['tournamentName'],
            'tournamentDate' => $data['tournamentDate'],
            'tournamentLocation' => $data['tournamentLocation'],
            'appUserID' => 1
        ];

        $response = $tournamentService->updateTournament($id, $tournament);

        $tournamentCategoryService->deleteTournamentCategoriesForTournament($id);

        foreach ($tournamentCategories as $tournamentCategory) {
            $tournamentCategoryService->addTournamentCategory([
                'tournamentID' => $response['tournamentID'],
                'category' => $tournamentCategory,
                'appUserID' => 1
            ]);
        }

        Flight::json($response);
    });

    Flight::route('PUT /@id/complete', function($id){
        $tournamentService = new TournamentService(new TournamentDao());
        $response = $tournamentService->markTournamentAsCompleted($id);
        Flight::json($response);
    });

    Flight::route('DELETE /@id', function($id){
        $tournamentService = new TournamentService(new TournamentDao());
        $resultService = new ResultService(new ResultDao());
        $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());
        $resultService->deleteResultsForTournament($id);
        $tournamentCategoryService->deleteTournamentCategoriesForTournament($id);

        $response = $tournamentService->deleteTournament($id);
        Flight::json($response);
    });
});

?>