<?php

use app\core\Request;
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

    public function index()
    {
        try{
            $request = new Request();

            $page = $request->param('page') ?? 1;
            $perPage = 5;
            $offset = ($page - 1) * $perPage;

            $condition = [
                'page' => $page,
                'perPage' => $perPage,
                'offset' => $offset
            ];

            $payload = $this->articleService->all($condition);

            return Response::json([
                $payload
            ], 200);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function store()
    {
        try{
            AuthMiddleware::handle();

            $request = new ArticleStoreRequest();
            $request->validate($this->form_validation);

            $token = $request->getToken();

            $articleDTO = ArticleDTO::fromRequest($request);

            $user = $this->userService->findUserByToken($token);

            $articleDTO->user_id = $user->id;

            $article = $this->articleService->save($articleDTO);

            return Response::json([
                'message' => 'Article created successfully',
                'data' => $article
            ], 201);
        }catch(ValidationException $e){
            return Response::json([
                'message' => $e->getErrors(),
                'data' => null
            ], 422);
        }catch(EntityNotFound $e){
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 404);
        }catch(DomainException $e){
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 422);
        }catch(Exception $e){
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}