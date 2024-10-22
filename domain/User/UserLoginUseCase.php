<?php

namespace Domain\User;

use Domain\Responses\DomainResponse;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class UserLoginUseCase
{
    
    
    public function __construct()
    {
    }
    
    /**
     * Execute the use case for user login.
     *
     * @param string $email
     * @param string $password
     * @return DomainResponse
     */
    public function execute(...$params): DomainResponse
    {
        
        if (count($params) !== 2) {
            throw new InvalidArgumentException('Invalid number of parameters provided.');
        }
        
        [$email, $password] = $params;
        
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return new DomainResponse(false, [], 'Login Error');
        }
        /** @var User $user */
        $user = Auth::user();
        $success['token'] = $user->createToken('LaravelApp')->plainTextToken;
        $success['name'] = $user->name;
        
        return new DomainResponse(true, $success, 'User Logged in');
    }
    
}
