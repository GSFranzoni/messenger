<?php

use \Firebase\JWT\JWT;

class Auth
{
    const SECRET = 'DFSOM23890R90NIFWE0JR234';
    const DURATION = 1000000;

    public static function generateToken($user) {
        $payload = array(
            "email" => $user['email'],
            "admin" => $user['admin'],
            "name" => $user['name'],
            "exp" => time() + Auth::DURATION,
            "iat" => time()
        );
        return JWT::encode($payload, Auth::SECRET);
    }

    public static function validateToken($token)
    {
        try{
            $decoded = JWT::decode($token, Auth::SECRET, array('HS256'));
            return true;
        }
        catch(Exception $e) {
            return false;
        }
    }

    public static function isAdmin($token)
    {
        try{
            $decoded = JWT::decode($token, Auth::SECRET, array('HS256'));
            return $decoded->admin;
        }
        catch(Exception $e) {
            throw new Exception('Token inválido!');
        }
    } 

}
