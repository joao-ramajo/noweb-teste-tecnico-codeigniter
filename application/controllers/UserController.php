<?php

use app\core\Request;
use app\core\requests\UserStoreRequest;
use app\core\Response;
use app\helpers\Exceptions\ValidationException;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
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

        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors()
            ], 422);
        }
    }
}