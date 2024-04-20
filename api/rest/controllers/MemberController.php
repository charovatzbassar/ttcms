<?php

require_once __DIR__.'/../utils/Utils.class.php';

    Flight::group('/members', function(){
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
    
        Flight::route('GET /@id', function($id){
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));
            $member = $memberService->getMemberByID($id);
            Flight::json($member);
        });
    
        Flight::route('POST /', function(){
            $data = Flight::request()->data->getData();
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));
            $response = $memberService->addMember($data);
            Flight::json($response);
        });
    
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));

            $response = $memberService->updateMember($id, $data);
            Flight::json($response);
        });
    
        Flight::route('PUT /@id/paid', function($id){
            $userID = Flight::request()->query['userID'];
            $memberService = new MemberService(new MemberDao($userID));
            $response = $memberService->markMembershipAsPaid($id);
            Flight::json($response);
        });
    
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