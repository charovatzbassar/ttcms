<?php

use Firebase\JWT\JWT;

Flight::set("userService", new UserService(new UserDao()));

Flight::group('/auth', function () {

    /**
     * @OA\Get(
     *      path="/auth/users",
     *      tags={"Auth"},
     *      summary="Get all users",
     *      @OA\Response(
     *           response=200,
     *           description="Get all users"
     *      )
     * )
     */    
    Flight::route("GET /users", function(){
        $users = Flight::get("userService")->getAllUsers();
        Flight::json($users);
    });

    /**
     * @OA\Get(
     *      path="/auth/login",
     *      tags={"Auth"},
     *      summary="Log in user",
     *      @OA\Response(
     *           response=200,
     *           description="Log in user"
     *      ),
     *      @OA\RequestBody(
     *          description="Login payload",
     *          @OA\JsonContent(
     *              required={"email","passwordHash"},
     *              @OA\Property(property="email", type="string", example="example@mail.com", description="Email"),
     *              @OA\Property(property="passwordHash", type="string", example="wordpass12", description="Password Hash"),
     *          )
     *      ),
     * )
     */
    Flight::route('POST /login', function(){
        $data = Flight::request()->data->getData();
        $user = Flight::get("userService")->getUserByEmail($data['email']);

        if ($user == null) {
            Flight::json(["message" => "User does not exist."], 404);
            return;
        }

        if (md5($data['password']) != $user['passwordHash']) {
            Flight::json(["message" => "Invalid password."], 401);
            return;
        }

        unset($user['passwordHash']);

        $token = JWT::encode($user, Config::JWT_SECRET(), 'HS256');

        Flight::json($token);
    });

    /**
     * @OA\Post(
     *      path="/auth/register",
     *      tags={"Auth"},
     *      summary="Register user",
     *      @OA\Response(
     *           response=200,
     *           description="Register user"
     *      ),
     *      @OA\RequestBody(
     *          description="Login payload",
     *          @OA\JsonContent(
     *              required={"email","passwordHash", "firstName", "lastName", "clubName"},
     *              @OA\Property(property="email", type="string", example="example@mail.com", description="Email"),
     *              @OA\Property(property="passwordHash", type="string", example="wordpass12", description="Password Hash"),
     *              @OA\Property(property="firstName", type="string", example="Some first name", description="First name"),
     *             @OA\Property(property="lastName", type="string", example="Some last name", description="Last name"),
     *             @OA\Property(property="clubName", type="string", example="Some club name", description="Club name"),
     *          )
     *      ),
     * )
     */
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
            "passwordHash" => md5($data['password']),
            "firstName" => $data['firstName'],
            "lastName" => $data['lastName'],
            "clubName" => $data['clubName'],
        ];

        $response = Flight::get("userService")->addUser($user);

        $user = Flight::get("userService")->getUserByEmail($data['email']);

        unset($user['passwordHash']);

        $token = JWT::encode($user, Config::JWT_SECRET(), 'HS256');

        Flight::json($token);
    });
});

?>