<?php

namespace Domain\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @template TModel of Model
 * @template TKey
 */
interface IBaseRepository
{
    /**
     * Get all records from the model.
     *
     * @return Collection<int, TModel>
     */
    public function all(): Collection;

    /**
     * Find a record by its primary key.
     *
     * @param int|string $id
     * @return TModel
     *
     * @throws ModelNotFoundException
     */
    public function find(int|string $id): Model;

    /**
     * Create a new record in the model.
     *
     * @param array<string, mixed> $data
     * @return TModel
     */
    public function create(array $data): Model;

    /**
     * Update a record in the model.
     *
     * @param int|string $id
     * @param array<string, mixed> $data
     * @return TModel
     */
    public function update(int|string $id, array $data): Model;

    /**
     * Delete a record from the model.
     *
     * @param int|string $id
     * @return bool|null
     */
    public function delete(int|string $id): ?bool;
}
