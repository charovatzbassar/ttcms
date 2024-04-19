<?php

require_once __DIR__.'/../utils/Utils.class.php';

    Flight::group('/members', function(){
        Flight::route('GET /', function(){
            $memberService = new MemberService(new MemberDao());

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
            $memberService = new MemberService(new MemberDao());
            $member = $memberService->getMemberByID($id);
            Flight::json($member);
        });
    
        Flight::route('POST /', function(){
            $data = Flight::request()->data->getData();
            $memberService = new MemberService(new MemberDao());
            $response = $memberService->addMember($data);
            Flight::json($response);
        });
    
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $memberService = new MemberService(new MemberDao());

            $response = $memberService->updateMember($id, $data);
            Flight::json($response);
        });
    
        Flight::route('PUT /@id/paid', function($id){
            $memberService = new MemberService(new MemberDao());
            $response = $memberService->markMembershipAsPaid($id);
            Flight::json($response);
        });
    
        Flight::route('DELETE /@id', function($id){
            $memberService = new MemberService(new MemberDao());
            $resultService = new ResultService(new ResultDao());

            $resultService->deleteResultsForMember($id);

            $response = $memberService->deleteMember($id);
            Flight::json($response);
        });
    });   


?>