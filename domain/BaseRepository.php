<?php

namespace Domain;

use Domain\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\{Collection, Model};

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;
    
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    
    public function all(): Collection
    {
        return $this->model->all();
    }
    
    public function find(int|string $id): Model
    {
        return $this->model->findOrFail($id);
    }
    
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
    
    public function update(int|string $id, array $data): Model
    {
        $model = $this->find($id);
        $model->update($data);
        
        return $model;
    }
    
    public function delete(int|string $id): bool
    {
        $model = $this->find($id);
        $model->delete();
        
        return true;
    }
}
