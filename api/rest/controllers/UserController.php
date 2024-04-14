<?php

Flight::group('/users', function () {
    Flight::route('GET /', function(){
        echo 'List of all users';
    });

    Flight::route('GET /@id', function($id){
        echo 'Details of user with id: ' . $id;
    });

    Flight::route('POST /', function(){
        echo 'Create a new user';
    });

    Flight::route('PUT /@id', function($id){
        echo 'Set user with id ' . $id;
    });

    Flight::route('DELETE /@id', function($id){
        echo 'Delete user with id: ' . $id;
    });
});


?>