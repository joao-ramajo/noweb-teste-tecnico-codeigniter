<?php

use app\core\requests\articles\ArticleStoreRequest;
use app\core\Response;
use app\helpers\DTOs\ArticleDTO;
use app\helpers\Exceptions\ValidationException;

defined('BASEPATH') OR exit('No direct script access allowed');

class ArticleController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function store()
    {
        try{
            $request = new ArticleStoreRequest();
            $request->validate($this->form_validation);

            $articleDTO = ArticleDTO::fromRequest($request);

            return Response::json([
                'message' => $articleDTO
            ]);
        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors()
            ], 422);
        }
    }
}