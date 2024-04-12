<?php 

require 'vendor/autoload.php';

Flight::route('/', function(){
    Flight::json(array("message" => "Hello World!"));
});

Flight::start();

?>