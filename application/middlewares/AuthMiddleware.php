<?php

namespace app\middlewares;

use app\core\Request;
use app\core\Response;
use app\helpers\Exceptions\InvalidTokenException;
use app\services\TokenService;
use Exception;

class AuthMiddleware
{
    public static function Handle()
    {
        try{
            $request = new Request();
            $token = $request->getToken();

            $tokenService = new TokenService();

            $tokenService->validateToken($token);
        }catch(InvalidTokenException $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 403);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}