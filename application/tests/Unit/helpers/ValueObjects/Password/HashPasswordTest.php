<?php

use app\helpers\ValuesObjects\Password;

it('return a hash from a password', function($input) {
    $plainText = new Password($input);
    $hash = $plainText->hash();

    expect($hash)
        ->toBeString();

    expect(strlen($hash))
        ->toBeGreaterThan(30);
})->with([
    'Aa123123',
    'Nci2jed90',
    'oac(DK2md9',
    'DDDm2o1d9j'
]);