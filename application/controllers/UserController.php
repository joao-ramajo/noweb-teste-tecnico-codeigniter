<?php

use app\core\Request;
use app\core\requests\UserStoreRequest;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        echo "retornando lista de usuario";

    }

    public function store()
    {
        try{
            $request = new UserStoreRequest();
            $request->validate($this->form_validation);

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }
}