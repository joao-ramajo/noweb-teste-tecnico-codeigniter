<?php

namespace app\middlewares;

use app\core\Response;
use app\helpers\Exceptions\InvalidTokenException;
use app\services\TokenService;
use Exception;

class AuthMiddleware
{
    public static function Handle()
    {
        try{
            $headers = getallheaders();
            $tokenService = new TokenService();

            $token = $headers['Authorization'] ?? null;

            $tokenService->validateToken($token);
        }catch(InvalidTokenException $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 401);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}