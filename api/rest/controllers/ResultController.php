<?php

Flight::group('/results', function () {
    Flight::route('GET /', function(){
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));

        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        $tournamentID = Flight::request()->query['tournamentID'];
        $clubMemberID = Flight::request()->query['clubMemberID'];

        if ($tournamentID != NULL) {
            $results = $resultService->getResultsByTournamentID($tournamentID);
        } else if ($clubMemberID != NULL) {
            $results = $resultService->getResultsByClubMemberID($clubMemberID);
        } else if ($offset == NULL && $limit == NULL) {
            $results = $resultService->getAllResults();
        } else {
            $results = $resultService->getResults($offset, $limit, '-resultID');
        }

        Flight::json($results);
    });

    Flight::route('GET /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));
        $result = $resultService->getResultByID($id);
        Flight::json($result);
    });

    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));

        if ($data['resultStatus'] == "VICTORY") {
            $memberService = new MemberService(new MemberDao($userID));

            $member = $memberService->getMemberByID($data['clubMemberID']);

            $memberService->updateMember($data['clubMemberID'], array(
                'score' => $member['score'] + 5
            ));
        }

        $response = $resultService->addResult($data);
        Flight::json($response);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));

        $response = $resultService->updateResult($id, $data);
        Flight::json($response);
    });

    Flight::route('DELETE /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));
        $response = $resultService->deleteResult($id);
        Flight::json($response);
    });
});


?>