<?php

namespace Domain\User\Repositories;

use Domain\BaseRepository;
use Domain\Contracts\Repositories\IUserRepository;
use Domain\User\Models\User;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
