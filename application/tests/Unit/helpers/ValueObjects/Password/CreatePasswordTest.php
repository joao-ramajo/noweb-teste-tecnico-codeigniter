<?php

use app\helpers\ValuesObjects\Password;

it('can create a new entity of Password', function($plainText) {
    $password = new Password($plainText);

    expect($password)
        ->toBeInstanceOf(Password::class);
})->with([
    'Aa123123',
    'Nd219s8',
    'A2e1sdD25'
]);

it('throws exception for invalid password format', function($plainText) {
    $this->expectException(InvalidArgumentException::class);

    new Password($plainText);
})->with([
    'abcdert',
    '12345678',
    'A12345672',
    'ab23156664',
]);

it('throws exception for a long password', function($plainText) {
    $this->expectException(InvalidArgumentException::class);

    new Password($plainText);
})->with([
    'Aa123123123123',
    'Aa1235tjvue22'
]);

it('throws exception for a too short password', function($plainText) {
    $this->expectException(InvalidArgumentException::class);

    new Password($plainText);
})->with([
    '',
    'Aab12'
]);