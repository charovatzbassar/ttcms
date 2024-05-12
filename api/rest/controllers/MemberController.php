<?php


require_once __DIR__.'/../utils/Utils.class.php';

    Flight::group('/members', function(){
    /**
     * @OA\Get(
     *      path="/members",
     *      tags={"Members"},
     *      summary="Get all members",
     *      security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Get all members"
     *      ),
     * 
     * )
     */
        Flight::route('GET /', function(){

            $userID = Flight::get('user')->appUserID;
            $memberService = new MemberService(new MemberDao($userID));

            $allMembers = $memberService->getAllMembers();

            $date = date("Y-m-d");
            $day = date('d', strtotime($date));
            $month = date('m', strtotime($date));

            if ($day == 1) {
                $memberService->setAllUnpaid();
            }

            if ($day == 1 && $month == 9) {
                $members = $memberService->getAllMembers();
                foreach ($members as $member) {
                    $memberService->updateMember($member['clubMemberID'], array(
                        'category' => Utils::calculateCategory($member['dateOfBirth'])
                    ));
                }
            }

            $body = Flight::request()->query;

            if (count($body) == 0) {
                Flight::json($allMembers);
                return;
            }

            $params = [
                'page' => isset($body['page']) ? $body['page'] : "",
                'start' => isset($body['start']) ? (int)$body['start'] : 0,
                'search' => isset($body['search']['value']) ? $body['search']['value'] : "",
                'draw' => isset($body['draw']) ? (int)$body['draw'] : 0,
                'limit' => isset($body['length']) ? (int)$body['length'] : 10,
                'order_column' => isset($body['order'][0]['name']) ? $body['order'][0]['name'] : "clubMemberID",
                'order_direction' => isset($body['order'][0]['dir']) ? $body['order'][0]['dir'] : "asc"
            ];

            $members = $memberService->getMembers(
                $params['page'],
                $params['start'],
                $params['limit'],
                $params['search'],
                $params['order_column'],
                $params['order_direction']
            );

            
            Flight::json([
                "draw" => $params['draw'],
                "recordsTotal" => count($allMembers),
                "recordsFiltered" => count($allMembers),
                'end' => count($members),
                "data" => $members
            
            ], 200);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
    /**
     * @OA\Get(
     *      path="/members/{id}",
     *      tags={"Members"},
     *      summary="Get a member by ID",
     *     security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Get a member by ID"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Member ID"),
     *      
     * )
     */
        Flight::route('GET /@id', function($id){
            $userID = Flight::get('user')->appUserID;            
            
            $memberService = new MemberService(new MemberDao($userID));
            $member = $memberService->getMemberByID($id);
            Flight::json($member);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
    /**
     * @OA\Post(
     *      path="/members",
     *      tags={"Members"},
     *      summary="Create a member",
     *     security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Create a member"
     *      ),
     *      @OA\RequestBody(
     *          description="Member data payload",
     *          @OA\JsonContent(
     *              required={"firstName","lastName","dateOfBirth", "birthplace", "gender", "joinDate", "appUserID"},
     *              @OA\Property(property="firstName", type="string", example="Some first name", description="Member first name"),
     *              @OA\Property(property="lastName", type="string", example="Some last name", description="Member last name"),
     *              @OA\Property(property="dateOfBirth", type="string", example="2024-01-01", description="Member date of birth"),
     *              @OA\Property(property="joinDate", type="string", example="2024-01-01", description="Member join date"),
     *              @OA\Property(property="score", type="number", example="0", description="Member score"),
     *              @OA\Property(property="birthplace", type="string", example="Belgrade", description="Member birthplace"),
     *              @OA\Property(property="gender", type="string", example="MALE", description="Member gender"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *      
     * )
     */
        Flight::route('POST /', function(){
            $userID = Flight::get('user')->appUserID;
            $data = Flight::request()->data->getData();

            $memberService = new MemberService(new MemberDao($userID));

            $response = $memberService->addMember($data);
            Flight::json($response);

        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
    /**
     * @OA\Put(
     *      path="/members/{id}",
     *      tags={"Members"},
     *      summary="Edit a member",
     *      security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Edit a member"
     *      ),
     *      @OA\RequestBody(
     *          description="Member data payload",
     *          @OA\JsonContent(
     *              required={"firstName","lastName","dateOfBirth", "birthplace", "gender", "joinDate", "appUserID"},
     *              @OA\Property(property="firstName", type="string", example="Some first name", description="Member first name"),
     *              @OA\Property(property="lastName", type="string", example="Some last name", description="Member last name"),
     *              @OA\Property(property="dateOfBirth", type="string", example="2024-01-01", description="Member date of birth"),
     *              @OA\Property(property="joinDate", type="string", example="2024-01-01", description="Member join date"),
     *              @OA\Property(property="score", type="number", example="0", description="Member score"),
     *              @OA\Property(property="birthplace", type="string", example="Belgrade", description="Member birthplace"),
     *              @OA\Property(property="gender", type="string", example="MALE", description="Member gender"),
     *              @OA\Property(property="appUserID", type="number", example="1", description="User ID"),
     *          )
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Member ID"),
     *      
     * )
     */
        Flight::route('PUT /@id', function($id){

            $userID = Flight::get('user')->appUserID;
            $data = Flight::request()->data->getData();
            $memberService = new MemberService(new MemberDao($userID));

            $response = $memberService->updateMember($id, $data);
            Flight::json($response);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
    /**
     * @OA\Put(
     *      path="/members/{id}/paid",
     *      tags={"Members"},
     *      summary="Set member's membership as paid",
     *     security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Set member's membership as paid"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Member ID"),
     *     
     * )
     */
        Flight::route('PUT /@id/paid', function($id){

            $userID = Flight::get('user')->appUserID;
            $memberService = new MemberService(new MemberDao($userID));
            $response = $memberService->markMembershipAsPaid($id);
            Flight::json($response);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    
    /**
     * @OA\Delete(
     *      path="/members/{id}",
     *      tags={"Members"},
     *      summary="Delete a member",
     *    security={{"JWTAuth": {}}},
     *      @OA\Response(
     *           response=200,
     *           description="Delete a member"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Member ID"),
     *     
     * )
     */
        Flight::route('DELETE /@id', function($id){
            $userID = Flight::get('user')->appUserID;
            
            $memberService = new MemberService(new MemberDao($userID));

            $resultService = new ResultService(new ResultDao($userID));

            $resultService->deleteResultsForMember($id);

            $response = $memberService->deleteMember($id);
            Flight::json($response);
        })->addMiddleware(function(){
            AuthMiddleware();
        });
    });   


?>