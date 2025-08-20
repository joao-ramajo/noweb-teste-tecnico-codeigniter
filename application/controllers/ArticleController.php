<?php

use app\core\requests\articles\ArticleStoreRequest;
use app\core\Response;
use app\helpers\DTOs\ArticleDTO;
use app\helpers\Exceptions\EntityNotFound;
use app\helpers\Exceptions\ValidationException;
use app\middlewares\AuthMiddleware;
use app\services\ArticleService;
use app\services\UserService;

defined('BASEPATH') OR exit('No direct script access allowed');

class ArticleController extends CI_Controller
{
    private ArticleService $articleService;
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('Article_model');
        $this->load->model('User_model');
        $this->load->model('Token_model');

        $this->articleService = new ArticleService();
        $this->userService = new UserService();
    }

    public function store()
    {
        try{
            AuthMiddleware::handle();

            $request = new ArticleStoreRequest();
            $request->validate($this->form_validation);

            $token = $request->getToken();

            $articleDTO = ArticleDTO::fromRequest($request);

            $user = $this->userService->findUserByTokn($token);

            $articleDTO->user_id = $user->id;

            $article = $this->articleService->save($articleDTO);

            return Response::json([
                'message' => 'Article created successfully',
                'data' => $article
            ]);
        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors()
            ], 422);
        }catch(EntityNotFound $e){
            return Response::json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}