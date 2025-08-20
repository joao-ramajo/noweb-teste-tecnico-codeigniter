<?php

namespace app\services;

use app\helpers\DTOs\ArticleDTO;
use app\helpers\Exceptions\EntityNotFound;
use app\helpers\Exceptions\PermissionException;
use app\helpers\Exceptions\UpdateFailedException;
use app\helpers\Exceptions\ValidationException;
use Article_model;
use Dom\Entity;
use DomainException;

class ArticleService
{
    private Article_model $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article_model();
    }

    public function findById($id){
        return $this->articleModel->find($id);
    }

    public function all(array $condition)
    {
        $articles = $this->articleModel->all($condition);

        $payload = [
            'page' => $condition['page'],
            'total_pages' => ceil($articles['total_pages'] / $condition['perPage']),
            'total' => $articles['total_pages'],
            'data' => $articles['data']
        ];

        return $payload;
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

    public function update(ArticleDTO $article)
    {
        $existingArticle = $this->articleModel->find($article->id);

        if(!$existingArticle){
            throw new EntityNotFound('No articles found.');
        }

        if($article->user_id != $existingArticle->user_id){
            throw new PermissionException('You are not allowed to update this article.');
        }

        $result = $this->articleModel->update($article->id, $article->toArray());

        if(!$result){
            throw new UpdateFailedException('An error occurred while trying to save the record');
        }

        $updatedArticle = $this->articleModel->find($article->id);

        return $updatedArticle;
    }

    public function delete(ArticleDTO $article)
    {
        $this->articleModel->delete($article->id);
    }
}