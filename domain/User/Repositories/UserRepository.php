<?php
namespace Domain\User\Repositories;

use Domain\BaseRepository;
use Domain\User\Models\User;
use JetBrains\PhpStorm\Pure;

class UserRepository extends BaseRepository
{
    #[Pure] public function __construct(User $user)
    {
        parent::__construct($user);
    }
    
}
