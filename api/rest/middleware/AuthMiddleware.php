<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function AuthMiddleware() {
        
        $headers = getallheaders();

        if (!$headers['Authorization']){
            Flight::json(["message" => "Token is missing."], 401);
        } else {
            try {
                $decoded = JWT::decode($headers['Authorization'], new Key(JWT_SECRET, "HS256"));

                Flight::set('user', $decoded);
            } catch (Exception $e) {
                Flight::json(["message" => "Invalid token."], 401);
            }
        }
}

