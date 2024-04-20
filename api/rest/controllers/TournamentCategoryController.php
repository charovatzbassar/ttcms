<?php

    Flight::group('/tournament-categories', function(){
        Flight::route('GET /', function(){
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));

            $offset = Flight::request()->query['offset'];
            $limit = Flight::request()->query['limit'];

            if ($offset == NULL && $limit == NULL) {
                $tournamentCategories = $tournamentCategoryService->getAllTournamentCategories();
            } else {
                $tournamentCategories = $tournamentCategoryService->getTournamentCategories($offset, $limit, '-tournamentCategoryID');
            }


            Flight::json($tournamentCategories);
        });
    
        Flight::route('GET /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategory = $tournamentCategoryService->getTournamentCategoryByID($id);
            Flight::json($tournamentCategory);
        });
    
        Flight::route('POST /', function(){
            $data = Flight::request()->data->getData();
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->addTournamentCategory($data);
        });
    
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->updateTournamentCategory($id, $data);
        });
    
        Flight::route('DELETE /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->deleteTournamentCategory($id);
        });
    });   


?>