<?php

namespace app\services;

use app\helpers\DTOs\ArticleDTO;
use app\helpers\Exceptions\EntityNotFound;
use Article_model;
use DomainException;

class ArticleService
{
    private Article_model $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article_model();
    }

    public function save(ArticleDTO $articleDTO)
    {

        $titleArticle = $this->articleModel->findByTitle($articleDTO->title);

        if($titleArticle){
            throw new DomainException('Title already exists');
        }

        $article = $this->articleModel->create($articleDTO);


        if(!$article){
            throw new EntityNotFound('No records found.');
        }

        $payload = [
            'id' => $article->id,
            'title' => $article->title,
            'content' => $article->content,
            'created_at' => $article->created_at
        ];

        return $payload;
    }
}