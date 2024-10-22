<?php

namespace Domain\User\UseCase\Login;

use Domain\Contracts\UseCaseInterface;
use Domain\Responses\DomainResponse;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class UserLoginUseCase implements UseCaseInterface
{
    
    public function __construct()
    {
    }
    
    /**
     * Execute the use case for user login.
     *
     * @param LoginUserParams $params
     * @return DomainResponse
     */
    public function execute(...$params): DomainResponse
    {
        
        if (count($params) !== 1 || !($params[0] instanceof LoginUserParams)) {
            throw new InvalidArgumentException('Invalid parameters provided.');
        }
        
        $loginParams = $params[0];
        
        if (!Auth::attempt(['email' => $loginParams->email, 'password' => $loginParams->password])) {
            return new DomainResponse(false, [], 'Login Error');
        }
        
        /** @var User $user */
        $user = Auth::user();
        $success['token'] = $user->createToken('LaravelApp')->plainTextToken;
        $success['name'] = $user->name;
        
        return new DomainResponse(true, $success, 'User Logged in');
    }
    
}
