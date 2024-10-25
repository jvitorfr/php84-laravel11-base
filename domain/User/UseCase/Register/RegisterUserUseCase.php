<?php

namespace Domain\User\UseCase\Register;

use Domain\Contracts\Repositories\IUserRepository;
use Domain\Contracts\IUseCase;
use Domain\DomainResponse;
use Domain\User\Models\User;
use InvalidArgumentException;

class RegisterUserUseCase implements IUseCase
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute the use case for user registration.
     *
     * @param RegisterUserParams $params
     * @return DomainResponse
     */
    public function execute(... $params): DomainResponse
    {
        if (count($params) !== 1 || !($params[0] instanceof RegisterUserParams)) {
            throw new InvalidArgumentException('Invalid parameters provided.');
        }

        $registerUserParams = $params[0];
        $password = bcrypt($registerUserParams->password);

        /** @var User $user */
        $user = $this->repository->create([
            'name' => $registerUserParams->name,
            'email' => $registerUserParams->email,
            'password' => $password,
        ]);

        $success['token'] = $user->createToken('LaravelApp')->plainTextToken;
        $success['name'] = $user->name;

        return new DomainResponse(true, $success, 'Usuário Criado com sucesso');
    }

}
