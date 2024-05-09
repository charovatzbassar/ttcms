<?php

    Flight::group('/tournament-categories', function(){
        /**
         * @OA\Get(
         *      path="/tournament-categories",
         *      tags={"Tournament Categories"},
         *      summary="Get all tournament categories",
         *      @OA\Response(
         *           response=200,
         *           description="Get all tournament categories"
         *      )
         * )
         */
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
    
        /**
         * @OA\Get(
         *      path="/tournament-categories/{id}",
         *      tags={"Tournament Categories"},
         *      summary="Get a tournament category by ID",
         *      @OA\Response(
         *           response=200,
         *           description="Get a tournament category by ID"
         *      )
         * )
         */
        Flight::route('GET /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategory = $tournamentCategoryService->getTournamentCategoryByID($id);
            Flight::json($tournamentCategory);
        });
    
        /**
         * @OA\Post(
         *      path="/tournament-categories",
         *      tags={"Tournament Categories"},
         *      summary="Create a tournament category",
         *      @OA\Response(
         *           response=200,
         *           description="Create a tournament category"
         *      )
         * )
         */
        Flight::route('POST /', function(){
            $data = Flight::request()->data->getData();
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->addTournamentCategory($data);
        });
    
        /**
         * @OA\Put(
         *      path="/tournament-categories/{id}",
         *      tags={"Tournament Categories"},
         *      summary="Edit a tournament category",
         *      @OA\Response(
         *           response=200,
         *           description="Edit a tournament category"
         *      )
         * )
         */
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->updateTournamentCategory($id, $data);
        });
    
        /**
         * @OA\Delete(
         *      path="/tournament-categories/{id}",
         *      tags={"Tournament Categories"},
         *      summary="Delete a tournament category",
         *      @OA\Response(
         *           response=200,
         *           description="Delete a tournament category"
         *      )
         * )
         */
        Flight::route('DELETE /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->deleteTournamentCategory($id);
        });
    });   


?>