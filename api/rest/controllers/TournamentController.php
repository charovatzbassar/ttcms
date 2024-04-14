<?php

Flight::group('/tournaments', function () {
    Flight::route('GET /', function(){
        echo 'List of all tournaments';
    });

    Flight::route('GET /@id', function($id){
        echo 'Details of tournament with id: ' . $id;
    });

    Flight::route('POST /', function(){
        echo 'Create a new tournament';
    });

    Flight::route('PUT /@id', function($id){
        echo 'Update tournament with id: ' . $id;
    });

    Flight::route('PUT /@id/complete', function($id){
        echo 'Tournament with id ' . $id.' marked as completed';
    });

    Flight::route('DELETE /@id', function($id){
        echo 'Delete tournament with id: ' . $id;
    });
});

?>