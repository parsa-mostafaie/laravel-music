<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all($search = '', $with = [], $withCount = [], $columns = ['*']);

    public function paginate($search = '', $with = [], $withCount = [], $columns = ['*'], $per_page = 10, $page = null);

    public function grow(int|User $id);

    public function shrink(int|User $id);

    public function find(int|User $id);

    // TODO:    Functions Below, Are not implemented yet. are handled by jetstream
    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}
