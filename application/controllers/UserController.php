<?php

use app\core\requests\UserStoreRequest;
use app\core\Response;
use app\helpers\DTOs\UserDTO;
use app\helpers\Exceptions\ValidationException;
use app\services\UserService;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');

        $this->userService = new UserService();
    }

    public function store()
    {
        try{
            $request = new UserStoreRequest();
            $request->validate($this->form_validation);

            $userDTO = UserDTO::fromRequest($request);

            $user = $this->userService->save($userDTO);

            return Response::json([
                'message' => 'Account created successfully',
                'data' => $user
            ], 201);
        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors(),
                'data' => null
            ], 422);
        }catch(mysqli_sql_exception $e){
                if ($e->getCode() === 1062) {
                    return Response::json([
                        'message' => 'This email is not available',
                        'data' => null
                    ], 409);
                }
                return Response::json([
                    'message' => 'Database error',
                    'data' => null
                ], 500);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}