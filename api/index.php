<?php

require './vendor/autoload.php';
require_once dirname(__FILE__)."/rest/dao/MemberDao.class.php";

Flight::group('/members', function(){
    Flight::route('GET /', function(){
        $memberdao = new MemberDao();
        $members = $memberdao->get_members(0,25,'-clubMemberID');
        Flight::json($members);
    });

    Flight::route('GET /@id', function($id){
        echo 'Details of member with id: ' . $id;
    });

    Flight::route('POST /', function(){
        echo 'Create a new member';
    });

    Flight::route('PUT /@id', function($id){
        echo 'Update member with id: ' . $id;
    });

    Flight::route('PUT /@id/paid', function($id){
        echo 'Membership of member with id ' . $id.' marked as paid';
    });

    Flight::route('DELETE /@id', function($id){
        echo 'Delete member with id: ' . $id;
    });
});

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

    Flight::route('PUT /@id/@status', function($id, $status){
        echo 'Set registration with id ' . $id.' to status ' . $status;
    });


});


Flight::start();

?>