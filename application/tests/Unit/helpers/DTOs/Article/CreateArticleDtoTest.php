<?php

use app\core\Request;
use app\helpers\DTOs\ArticleDTO;

dataset('articleData', [
    [
        'input' => [
            'user_id' => 1,
            'title' => 'Primeira notícia',
            'content' => 'Conteúdo da primeira notícia',
            'id' => 10
        ],
        'expected' => [
            'user_id' => 1,
            'title' => 'Primeira notícia',
            'content' => 'Conteúdo da primeira notícia',
            'id' => 10
        ]
    ],
    [
        'input' => [
            'user_id' => null,
            'title' => 'Segunda notícia',
            'content' => 'Conteúdo da segunda notícia',
        ],
        'expected' => [
            'user_id' => null,
            'title' => 'Segunda notícia',
            'content' => 'Conteúdo da segunda notícia',
            'id' => null
        ]
    ],
]);

it('can create an ArticleDTO from array', function($input, $expected) {
    $dto = ArticleDTO::fromArray($input);

    expect($dto->id)->toBe($expected['id'] ?? null)
        ->and($dto->user_id)->toBe($expected['user_id'])
        ->and($dto->title)->toBe($expected['title'])
        ->and($dto->content)->toBe($expected['content'])
        ->and($dto)->toBeInstanceOf(ArticleDTO::class);

})->with('articleData');

it('can create an ArticleDTO from Request', function($request) {
    $dto = ArticleDTO::fromRequest($request);

    expect($dto)
        ->toBeInstanceOf(ArticleDTO::class)
        ->and((int) $dto->user_id)->toBe((int) $request->input('user_id'))
        ->and($dto->title)->toBe($request->input('title'))
        ->and($dto->content)->toBe($request->input('content'))
        ->and((int) $dto->id)->toBe((int) $request->input('id') ?? null);
})->with([
    new Request(method: 'POST', data: [
        'user_id' => 1,
        'title' => 'Notícia do request',
        'content' => 'Conteúdo do request',
        'id' => 5
    ]),
    new Request(method: 'POST', data: [
        'title' => 'Sem user_id',
        'content' => 'Conteúdo sem user_id',
    ])
]);

it('can create an ArticleDTO from stdClass object', function() {
    $obj = new stdClass();
    $obj->user_id = 1;
    $obj->title = 'Notícia do objeto';
    $obj->content = 'Conteúdo do objeto';
    $obj->id = 7;

    $dto = ArticleDTO::fromObject($obj);

    expect($dto)
        ->toBeInstanceOf(ArticleDTO::class)
        ->and((int) $dto->user_id)->toBe(1)
        ->and($dto->title)->toBe('Notícia do objeto')
        ->and($dto->content)->toBe('Conteúdo do objeto')
        ->and($dto->id)->toBe(7);
});
