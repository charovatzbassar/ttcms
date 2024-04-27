<?php

Flight::set("userService", new UserService(new UserDao()));

Flight::group('/auth', function () {

    Flight::route("GET /users", function(){
        $users = Flight::get("userService")->getAllUsers();
        Flight::json($users);
    });

    Flight::route('POST /login', function(){
        $data = Flight::request()->data->getData();
        $user = Flight::get("userService")->getUserByEmail($data['email']);

        if ($user == null) {
            Flight::json(["message" => "User does not exist."], 404);
            return;
        }

        if ($data['password'] != $user['passwordHash']) {
            Flight::json(["message" => "Invalid password."], 401);
            return;
        }

        Flight::json($user);
    });

    Flight::route('POST /register', function(){
        $data = Flight::request()->data->getData();
        $user = Flight::get("userService")->getUserByEmail($data['email']);

        if ($user != null) {
            Flight::json(["message" => "User already exists."], 409);
            return;
        }

        if ($data['password'] != $data['repeatedPassword']) {
            Flight::json(["message" => "Passwords do not match."], 400);
            return;
        }

        $user = [
            "email" => $data['email'],
            "passwordHash" => $data['password'],
            "firstName" => $data['firstName'],
            "lastName" => $data['lastName'],
            "clubName" => $data['clubName'],
        ];

        $response = Flight::get("userService")->addUser($user);
        Flight::json($response);
    });

});

?>