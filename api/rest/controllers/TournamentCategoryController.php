<?php


    Flight::group('/tournament-categories', function(){
        /**
         * @OA\Get(
         *      path="/tournament-categories",
         *      tags={"Tournament Categories"},
         *      summary="Get all tournament categories",
         *     security={{"JWTAuth": {}}},
         *      @OA\Response(
         *           response=200,
         *           description="Get all tournament categories"
         *      ),
         *     
         * )
         */
        Flight::route('GET /', function(){
    
            $userID = Flight::get('user')->appUserID;
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));

            $offset = Flight::request()->query['offset'];
            $limit = Flight::request()->query['limit'];

            if ($offset == NULL && $limit == NULL) {
                $tournamentCategories = $tournamentCategoryService->getAllTournamentCategories();
            } else {
                $tournamentCategories = $tournamentCategoryService->getTournamentCategories($offset, $limit, '-tournamentCategoryID');
            }


            Flight::json($tournamentCategories);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
        /**
         * @OA\Get(
         *      path="/tournament-categories/{id}",
         *      tags={"Tournament Categories"},
         *      summary="Get a tournament category by ID",
         *     security={{"JWTAuth": {}}},
         *      @OA\Response(
         *           response=200,
         *           description="Get a tournament category by ID"
         *      ),
         *    
         *   @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Tournament Category ID")
         * )
         */
        Flight::route('GET /@id', function($id){
    
            $userID = Flight::get('user')->appUserID;
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategory = $tournamentCategoryService->getTournamentCategoryByID($id);
            Flight::json($tournamentCategory);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
        /**
         * @OA\Post(
         *      path="/tournament-categories",
         *      tags={"Tournament Categories"},
         *      summary="Create a tournament category",
         *    security={{"JWTAuth": {}}},
         *      @OA\Response(
         *           response=200,
         *           description="Create a tournament category"
         *      ),
         *      @OA\RequestBody(
        *          description="Tournament Category data payload",
        *          @OA\JsonContent(
        *              required={"tournamentID","category", "appUserID"},
        *             @OA\Property(property="tournamentID", type="number", example="1", description="Tournament ID"),
        *             @OA\Property(property="category", type="string", example="JUNIOR", description="Tournament category"),
        *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
        *          )
        *      ),
         *   
         * )
         */
        Flight::route('POST /', function(){
    
            $userID = Flight::get('user')->appUserID;
            $data = Flight::request()->data->getData();
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->addTournamentCategory($data);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
        /**
         * @OA\Put(
         *      path="/tournament-categories/{id}",
         *      tags={"Tournament Categories"},
         *      summary="Edit a tournament category",
         *    security={{"JWTAuth": {}}},
         *      @OA\Response(
         *           response=200,
         *           description="Edit a tournament category"
         *      ),
        *      @OA\RequestBody(
        *          description="Tournament Category data payload",
        *          @OA\JsonContent(
        *              required={"tournamentID","category", "appUserID"},
        *             @OA\Property(property="tournamentID", type="number", example="1", description="Tournament ID"),
        *             @OA\Property(property="category", type="string", example="JUNIOR", description="Tournament category"),
        *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
        *          )
        *      ),
         *    
         * )
         */
        Flight::route('PUT /@id', function($id){

            $userID = Flight::get('user')->appUserID;
            $data = Flight::request()->data->getData();

            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->updateTournamentCategory($id, $data);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
        /**
         * @OA\Delete(
         *      path="/tournament-categories/{id}",
         *      tags={"Tournament Categories"},
         *      summary="Delete a tournament category",
         *   security={{"JWTAuth": {}}},
         *      @OA\Response(
         *           response=200,
         *           description="Delete a tournament category"
         *      ),
         *   
         * )
         */
        Flight::route('DELETE /@id', function($id){
    
            $userID = Flight::get('user')->appUserID;
            $tournamentCategoryService = new TournamentCategoryService(new TournamentCategoryDao($userID));
            $tournamentCategoryService->deleteTournamentCategory($id);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    });   


?>