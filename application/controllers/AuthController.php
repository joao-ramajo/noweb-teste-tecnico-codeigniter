<?php

use app\core\Request;
use app\core\requests\auth\LoginRequest;
use app\core\Response;
use app\helpers\DTOs\UserDTO;
use app\helpers\Exceptions\InvalidTokenException;
use app\helpers\Exceptions\ValidationException;
use app\middlewares\AuthMiddleware;
use app\services\AuthService;

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->model('Article_model');
        $this->load->model('Token_model');

        $this->authService = new AuthService();
    }

    public function login(): Response
    {
        try{
            $request = new LoginRequest();
            $request->validate($this->form_validation);

            $userDTO = UserDTO::fromLogin($request);

            $payload = $this->authService->login($userDTO);

            return Response::json([
                'message' => 'Login successfully',
                'token' => $payload['token'],
                'expiration' => $payload['expiration']
            ]);
        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors()
            ], 422);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(): Response
    {
        try{
            AuthMiddleware::handle();
            $request = new Request();
            $token = $request->getToken();

            $this->authService->logout($token);

            return Response::json([
                'message' => 'Logout successfully'
            ], 200);
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