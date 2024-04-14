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
        $tournamentService->addTournament($data);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $tournamentService = new TournamentService(new TournamentDao());
        $tournamentService->updateTournament($id, $data);
    });

    Flight::route('PUT /@id/complete', function($id){
        $tournamentService = new TournamentService(new TournamentDao());
        $tournamentService->markTournamentAsCompleted($id);
    });

    Flight::route('DELETE /@id', function($id){
        $tournamentService = new TournamentService(new TournamentDao());
        $tournamentService->deleteTournament($id);
    });
});

?>