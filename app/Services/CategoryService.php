<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function all($search = '', $with = [], $withCount = [], $columns = ['*'])
    {
        return $this->categoryRepository->all($search, $with, $withCount, $columns);
    }

    public function find(int|Category $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function paginate($search = '', $with = [], $withCount = [], $columns = ['*'], $per_page = 10, $page = null)
    {
        return $this->categoryRepository->paginate($search, $with, $withCount, $columns, $per_page, $page);
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->categoryRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
