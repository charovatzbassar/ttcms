<?php

Flight::group('/results', function () {
    Flight::route('GET /', function(){
        echo 'List of all results';
    });

    Flight::route('GET /@id', function($id){
        echo 'Details of result with id: ' . $id;
    });

    Flight::route('POST /', function(){
        echo 'Create a new result';
    });

    Flight::route('PUT /@id', function($id){
        echo 'Update result with id: ' . $id;
    });

    Flight::route('DELETE /@id', function($id){
        echo 'Delete result with id: ' . $id;
    });
});


?>