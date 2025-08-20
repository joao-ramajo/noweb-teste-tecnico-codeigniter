<?php

use app\helpers\ValuesObjects\Password;

it('return true from to equals password', function($input) {
    $plainText = new Password($input);
    $hash = $plainText->hash();

    expect($plainText->compare($hash))
        ->toBeTrue();
})->with([
    'Aa123123',
    'Bc249s8d9',
    'Kowd21pPl'
]);

it('return false from diferents password', function ($input) {
    $plainText = new Password($input);
    $otherText = new Password('Aab21id9');
    $hash = $otherText->hash();

    expect($plainText->compare($hash))
        ->toBeFalse();
})->with([
    'Aa123123',
    'Ndic8929',
    'Aoco2948d8'
]);