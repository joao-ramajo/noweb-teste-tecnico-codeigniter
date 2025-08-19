<?php

use app\core\Request;
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
    public function index()
    {
        $users = $this->User_model->all();

        return Response::json([
            'data' => $users
        ]);

    }

    public function store()
    {
        try{
            $request = new UserStoreRequest();
            $request->validate($this->form_validation);

            $userDTO = UserDTO::fromRequest($request);

            $this->userService->save($userDTO);

            return Response::json([
                'message' => 'Account created successfully'
            ], 201);
        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors()
            ], 422);
        }catch(mysqli_sql_exception $e){
                if ($e->getCode() === 1062) {
                    return Response::json([
                        'message' => 'This email is not available',
                    ], 409);
                }

                return Response::json([
                    'message' => 'Database error'
                ], 500);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}