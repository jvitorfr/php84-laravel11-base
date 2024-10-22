<?php
namespace Domain\User;

use Domain\Contracts\UseCaseInterface;
use Domain\Responses\DomainResponse;
use Domain\User\Models\User;
use Domain\User\Repositories\UserRepository;
use InvalidArgumentException;

class RegisterUserUseCase implements UseCaseInterface
{
    
    private UserRepository $repository;
    
    public function __construct(UserRepository $repository)
    {
          $this->repository = $repository;
    }
    
    /**
     * Execute the use case for user registration.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return DomainResponse
     */
    public function execute(...$params): DomainResponse
    {
        
        if (count($params) !== 3) {
            throw new InvalidArgumentException('Invalid number of parameters provided.');
        }
    
        [$name, $email, $password] = $params;
        
        $password = bcrypt($password);
        
        /** @var User $user */
        $user = $this->repository ->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        
        $success['token'] = $user->createToken('LaravelApp')->plainTextToken;
        $success['name'] = $user->name;
        
        return new DomainResponse(true, $success, 'Usuário Criado com sucesso');
    }
    
}
