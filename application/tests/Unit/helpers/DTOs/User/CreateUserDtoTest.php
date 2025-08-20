<?php

use app\core\Request;
use app\core\requests\auth\LoginRequest;
use app\core\requests\UserStoreRequest;
use app\helpers\DTOs\UserDTO;
use app\helpers\ValuesObjects\Email;
use app\helpers\ValuesObjects\Password;

dataset('userData', [
    [
        'input' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Aa123123'
        ],
        'expected' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]
    ],
    [
        'input' => [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => 'Bb321321'
        ],
        'expected' => [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]
    ],
]);


it('can create a user DTO from array', function($input, $expected) {
    $dto = UserDTO::fromArray($input);

    expect($dto->name)->toBe((string) $expected['name']);
    expect((string) $dto->email)->toBe((string) $expected['email']);

    expect($dto)
        ->toBeInstanceOf(UserDTO::class)
        ->and($dto->password)
            ->toBeInstanceOf(Password::class)
        ->and($dto->email)
            ->toBeInstanceOf(Email::class);

})->with('userData');


it('can create a user DTO from request', function($request) {
    // $request = new Request(method: 'POST', data: [
    //     'name' => 'john doe',
    //     'email' => 'john@gmail.com',
    //     'password' => 'Aa123123'
    // ]);

    $dto = UserDTO::fromRequest($request);

    expect($dto)
        ->toBeInstanceOf(UserDTO::class)
        ->and($dto->password)
            ->toBeInstanceOf(Password::class)
        ->and($dto->email)
            ->toBeInstanceOf(Email::class);
})->with([
    new Request(method: 'POST', data: [
            'name' => 'john doe',
            'email' => 'john@gmail.com',
            'password' => 'Aa123123'
    ]),

    new UserStoreRequest(method: 'POST', data: [
        'name' => 'john doe',
        'email' => 'john@gmail.com',
        'password' => 'Aa123123',
        'password_confirmation' => 'Aa123123'
    ]),
]);


it('can create a UserDTO from stdClass object', function() {
    $userObject = new stdClass();
    $userObject->name = 'John Doe';
    $userObject->email = 'john@example.com';
    $userObject->password = 'Aa123123';

    $dto = UserDTO::fromObject($userObject);

    expect($dto)
        ->toBeInstanceOf(UserDTO::class)
        ->and($dto->name)->toBe('John Doe')
        ->and($dto->email)->toBeInstanceOf(Email::class)
        ->and((string) $dto->email)->toBe('john@example.com')
        ->and($dto->password)->toBeInstanceOf(Password::class)
        ->and((string) $dto->password)->toBe('Aa123123');
});