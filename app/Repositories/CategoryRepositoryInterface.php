<?php

namespace App\Repositories;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all($search = '', $with = [], $withCount = [], $columns = ['*']);

    public function paginate($search = '', $with = [], $withCount = [], $columns = ['*'], $per_page = 10, $page = null);

    public function find(int|Category $id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}
