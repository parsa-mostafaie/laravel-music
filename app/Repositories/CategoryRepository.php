<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected function query($search = '', $with = [], $withCount = [])
    {
        $query = Category::query();

        $query->whereLike("name", "%" . $search . "%");

        $query->with($with)->withCount($withCount);

        return $query;
    }

    public function find(int|Category $id)
    {
        $Category = $id;

        if (!$Category instanceof Category) {
            $Category = Category::findOrFail($Category);
        }

        return $Category;
    }

    public function all($search = '', $with = [], $withCount = [], $columns = ['*'])
    {
        return $this->query($search, $with, $withCount)->get($columns);
    }

    public function paginate($search = '', $with = [], $withCount = [], $columns = ['*'], $per_page = 10, $page = null)
    {
        return $this->query($search, $with, $withCount)->paginate($per_page, $columns, page: $page);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(array $data, $id)
    {
        $category = $this->find($id);
        return tap($category, fn($category) => $category->update($data));
    }

    public function delete($id)
    {
        $this->find($id)->delete();
    }
}
