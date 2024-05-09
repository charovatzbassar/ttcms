<?php

require_once __DIR__.'/../utils/Utils.class.php';

    Flight::group('/members', function(){
    /**
     * @OA\Get(
     *      path="/members",
     *      tags={"Members"},
     *      summary="Get all members",
     *      @OA\Response(
     *           response=200,
     *           description="Get all members"
     *      )
     * )
     */
        Flight::route('GET /', function(){
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));

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

            $offset = Flight::request()->query['offset'];
            $limit = Flight::request()->query['limit'];

            if ($offset == NULL && $limit == NULL) {
                $members = $memberService->getAllMembers();
            } else {
                $members = $memberService->getMembers($offset, $limit, '-clubMemberID');
            }

            
            Flight::json($members);
        });
    
    /**
     * @OA\Get(
     *      path="/members/{id}",
     *      tags={"Members"},
     *      summary="Get a member by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Get a member by ID"
     *      )
     * )
     */
        Flight::route('GET /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));
            $member = $memberService->getMemberByID($id);
            Flight::json($member);
        });
    
    /**
     * @OA\Post(
     *      path="/members",
     *      tags={"Members"},
     *      summary="Create a member",
     *      @OA\Response(
     *           response=200,
     *           description="Create a member"
     *      )
     * )
     */
        Flight::route('POST /', function(){
            $data = Flight::request()->data->getData();
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));
            $response = $memberService->addMember($data);
            Flight::json($response);
        });
    
    /**
     * @OA\Put(
     *      path="/members/{id}",
     *      tags={"Members"},
     *      summary="Edit a member",
     *      @OA\Response(
     *           response=200,
     *           description="Edit a member"
     *      )
     * )
     */
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));

            $response = $memberService->updateMember($id, $data);
            Flight::json($response);
        });
    
    /**
     * @OA\Put(
     *      path="/members/{id}/paid",
     *      tags={"Members"},
     *      summary="Set member's membership as paid",
     *      @OA\Response(
     *           response=200,
     *           description="Set member's membership as paid"
     *      )
     * )
     */
        Flight::route('PUT /@id/paid', function($id){
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));
            $response = $memberService->markMembershipAsPaid($id);
            Flight::json($response);
        });
    
    /**
     * @OA\Delete(
     *      path="/members/{id}",
     *      tags={"Members"},
     *      summary="Delete a member",
     *      @OA\Response(
     *           response=200,
     *           description="Delete a member"
     *      )
     * )
     */
        Flight::route('DELETE /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));

            $resultService = new ResultService(new ResultDao($userID));

            $resultService->deleteResultsForMember($id);

            $response = $memberService->deleteMember($id);
            Flight::json($response);
        });
    });   


?>