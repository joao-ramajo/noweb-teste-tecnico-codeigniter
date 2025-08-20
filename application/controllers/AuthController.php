<?php

use app\core\requests\auth\LoginRequest;
use app\core\Response;
use app\helpers\DTOs\UserDTO;
use app\helpers\Exceptions\ValidationException;
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
        
        $this->authService = new AuthService();
    }

    public function login()
    {
        try{
            $request = new LoginRequest();
            $request->validate($this->form_validation);

            $userDTO = UserDTO::fromLogin($request);

            $this->authService->verify($userDTO);

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
}