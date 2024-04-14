<?php

    Flight::group('/members', function(){
        Flight::route('GET /', function(){
            $memberService = new MemberService(new MemberDao());

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
            $memberService->addMember($data);
        });
    
        Flight::route('PUT /@id', function($id){
            $data = Flight::request()->data->getData();

            $memberService = new MemberService(new MemberDao());

            $memberService->updateMember($id, $data);
        });
    
        Flight::route('PUT /@id/paid', function($id){
            $memberService = new MemberService(new MemberDao());
            $memberService->markMembershipAsPaid($id);
        });
    
        Flight::route('DELETE /@id', function($id){
            $memberService = new MemberService(new MemberDao());
            $memberService->deleteMember($id);
        });
    });   


?>