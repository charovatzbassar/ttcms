<?php

Flight::group('/users', function () {
    Flight::route('GET /', function(){
        $userService = new UserService(new UserDao());
        
        $offset = Flight::request()->query['offset'];
        $limit = Flight::request()->query['limit'];

        if ($offset == NULL && $limit == NULL) {
            $users = $userService->getAllUsers();
        } else {
            $users = $userService->getUsers($offset, $limit, '-appUserID');
        }

        Flight::json($users);
    });

    Flight::route('GET /@id', function($id){
        $userService = new UserService(new UserDao());
        $user = $userService->getUserByID($id);
        Flight::json($user);
    });

    Flight::route('POST /', function(){
        $data = Flight::request()->data->getData();
        $userService = new UserService(new UserDao());
        $userService->addUser($data);
    });

    Flight::route('PUT /@id', function($id){
        $data = Flight::request()->data->getData();

        $userService = new UserService(new UserDao());

        $userService->updateUser($id, $data);
    });

    Flight::route('DELETE /@id', function($id){
        $userService = new UserService(new UserDao());
        $userService->deleteUser($id);
    });
});


?>