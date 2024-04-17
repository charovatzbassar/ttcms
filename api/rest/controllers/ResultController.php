<?php

Flight::group('/results', function () {
    Flight::route('GET /', function(){
        $resultService = new ResultService(new ResultDao());

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
        $resultService = new ResultService(new ResultDao());
        $result = $resultService->getResultByID($id);
        Flight::json($result);
    });

    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $resultService = new ResultService(new ResultDao());

        if ($data['resultStatus'] == "VICTORY") {
            $memberService = new MemberService(new MemberDao());

            $member = $memberService->getMemberByID($data['clubMemberID']);

            $memberService->updateMember($data['clubMemberID'], array(
                'score' => $member['score'] + 5
            ));
        }

        $resultService->addResult($data);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $resultService = new ResultService(new ResultDao());
        $resultService->updateResult($id, $data);
    });

    Flight::route('DELETE /@id', function($id){
        $resultService = new ResultService(new ResultDao());
        $resultService->deleteResult($id);
    });
});


?>