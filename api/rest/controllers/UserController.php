<?php

Flight::group('/auth', function () {
    Flight::route('POST /login', function(){
        $data = Flight::request()->data->getData();
        $userService = new UserService(new UserDao());
        $user = $userService->getUserByEmail($data['email']);

        if ($user == null) {
            Flight::json(["message" => "User does not exist."]);
            return;
        }

        if ($user['password'] != $data['passwordHash']) {
            Flight::json(["message" => "Invalid password."]);
            return;
        }

        Flight::json($user);
    });

    Flight::route('POST /register', function(){
        $data = Flight::request()->data->getData();
        $userService = new UserService(new UserDao());
        $user = $userService->getUserByEmail($data['email']);

        if ($user != null) {
            Flight::json(["message" => "User already exists."]);
            return;
        }

        $user = [
            "email" => $data['email'],
            "passwordHash" => $data['passwordHash'],
            "firstName" => $data['firstName'],
            "lastName" => $data['lastName'],
            "clubName" => $data['clubName'],
        ];

        $userService->addUser($user);
        Flight::json(["message" => "User has been registered."]);
    });

});

?>