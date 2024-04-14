<?php

Flight::group('/results', function () {
    Flight::route('GET /', function(){
        $resultService = new ResultService(new ResultDao());
        $results = $resultService->getAllResults();
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