<?php

namespace app\helpers\DTOs;

use app\core\Request;

class ArticleDTO
{
    public ?int $id;
    public ?int $user_id;
    public string $title;
    public string $content;

    public function __construct(?int $user_id, string $title, string $content, ?int $id = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['title'],
            $data['content'],
            $data['id'] ?? null
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('user_id') !== null ? $request->input('user_id') : null,
            $request->input('title'),
            $request->input('content'),
            $request->input('id') !== null ? (int) $request->input('id') : null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
