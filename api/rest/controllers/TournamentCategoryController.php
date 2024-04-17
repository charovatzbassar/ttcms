<?php

    Flight::group('/tournament-categories', function(){
        Flight::route('GET /', function(){
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());

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
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());
            $tournamentCategory = $tournamentCategoryService->getTournamentCategoryByID($id);
            Flight::json($tournamentCategory);
        });
    
        Flight::route('POST /', function(){
            $data = Flight::request()->data->getData();
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());
            $tournamentCategoryService->addTournamentCategory($data);
        });
    
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());

            $tournamentCategoryService->updateTournamentCategory($id, $data);
        });
    
        Flight::route('DELETE /@id', function($id){
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao());
            $tournamentCategoryService->deleteTournamentCategory($id);
        });
    });   


?>