<?php

Flight::group('/results', function () {
    /**
     * @OA\Get(
     *      path="/results",
     *      tags={"Results"},
     *      summary="Get all results",
     *      @OA\Response(
     *           response=200,
     *           description="Get all results"
     *      )
     * )
     */
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

    /**
     * @OA\Get(
     *      path="/results/{id}",
     *      tags={"Results"},
     *      summary="Get a result by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Get a result by ID"
     *      )
     * )
     */
    Flight::route('GET /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));
        $result = $resultService->getResultByID($id);
        Flight::json($result);
    });

    /**
     * @OA\Post(
     *      path="/results",
     *      tags={"Results"},
     *      summary="Create a result",
     *      @OA\Response(
     *           response=200,
     *           description="Create a result"
     *      )
     * )
     */
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

    /**
     * @OA\Put(
     *      path="/results/{id}",
     *      tags={"Results"},
     *      summary="Edit a result",
     *      @OA\Response(
     *           response=200,
     *           description="Edit a result"
     *      )
     * )
     */
    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));

        $response = $resultService->updateResult($id, $data);
        Flight::json($response);
    });

    /**
     * @OA\Delete(
     *      path="/results/{id}",
     *      tags={"Results"},
     *      summary="Delete a result",
     *      @OA\Response(
     *           response=200,
     *           description="Delete a result"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id){
        $userID = Flight::request()->query['userID'];
        $resultService = new ResultService(new ResultDao($userID));
        $response = $resultService->deleteResult($id);
        Flight::json($response);
    });
});


?>