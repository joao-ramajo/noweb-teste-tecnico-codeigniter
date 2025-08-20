<?php

use app\helpers\ValuesObjects\Email;

it('can create a valid email', function($text) {
    $email = new Email($text);

    expect($email)
        ->toBeInstanceOf(Email::class);
})->with([
    'joao@gmail.com',
    'ramajo.joao@gmail.com',
    'oliveira@hotmail.com',
]);

it('throws a InvalidArgumentException from a invalid email format', function($text) {
    $this->expectException(InvalidArgumentException::class);

    new Email($text);
})->with([
    'ajdwwomo',
    'invalidemail@aocsoooo'
]);