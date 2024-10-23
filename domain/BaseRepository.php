<?php

namespace Domain;

use Domain\Contracts\Repositories\IBaseRepository;
use Illuminate\Database\Eloquent\{Collection, Model};

/**
 * @template TModel of Model
 * @template TKey
 */
class BaseRepository implements IBaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records from the model.
     *
     * @return Collection<int, TModel>
     */
    public function all(): Collection
    {
        /** @var Collection<int, TModel> $collection */
        $collection = $this->model::all();
        return $collection;
    }

    /**
     * Find a record by its primary key.
     *
     * @param int|string $id
     * @return TModel
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find(int|string $id): Model
    {
        /** @var TModel $model */
        $model = $this->model->findOrFail($id);
        return $model;
    }

    /**
     * Create a new record in the model.
     *
     * @param array<string, mixed> $data
     * @return TModel
     */
    public function create(array $data): Model
    {
        /** @var TModel $model */
        $model = $this->model->create($data);
        return $model;
    }

    /**
     * Update a record in the model.
     *
     * @param int|string $id
     * @param array<string, mixed> $data
     * @return TModel
     */
    public function update(int|string $id, array $data): Model
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    /**
     * Delete a record from the model.
     *
     * @param int|string $id
     * @return bool|null
     */
    public function delete(int|string $id): ?bool
    {
        $model = $this->find($id);
        return $model->delete();
    }
}
