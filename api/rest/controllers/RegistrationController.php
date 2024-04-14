<?php

Flight::group('/registrations', function () {
    Flight::route('GET /', function(){
        echo 'List of all registrations';
    });

    Flight::route('GET /@id', function($id){
        echo 'Details of registration with id: ' . $id;
    });

    Flight::route('POST /', function(){
        echo 'Create a new registration';
    });

    Flight::route('PUT /@id', function($id){
        echo 'Set registration with id ' . $id;
    });

    Flight::route('PUT /@id/@status', function($id, $status){
        echo 'Set registration with id ' . $id.' to status ' . $status;
    });

    Flight::route('DELETE /@id', function($id){
        echo 'Delete registration with id: ' . $id;
    });
});

?>