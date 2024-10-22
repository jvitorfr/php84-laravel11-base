<?php

namespace Domain\User\Repositories;

use Domain\BaseRepository;
use Domain\User\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

}
