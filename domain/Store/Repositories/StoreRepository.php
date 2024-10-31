<?php

namespace Domain\Store\Repositories;

use Domain\BaseRepository;
use Domain\Contracts\Repositories\IStoreRepository;
use Domain\Store\Models\Store;

class StoreRepository extends BaseRepository implements IStoreRepository
{
    public function __construct(Store $model)
    {
        parent::__construct($model);
    }
}
