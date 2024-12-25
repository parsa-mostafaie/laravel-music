<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\ManagersOnlyRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Inertia\Inertia;

class CategoryController extends Controller
{
  public function __construct(
    protected CategoryService $categoryService
  ) {}

  public function manage(ManagersOnlyRequest $request)
  {
    return Inertia::render('Manager/Categories', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search'),
      'categories_select' => Category::pluck('name', 'id')
    ]);
  }

  public function store(CategoryStoreRequest $request)
  {
    return $this->categoryService->create($request->all());
  }

  public function update(CategoryUpdateRequest $request, Category $category)
  {
    return response($this->categoryService->update($request->all(), $category), 200);
  }

  public function index(ManagersOnlyRequest $request)
  {
    return $this->categoryService->paginate($request->search);
  }

  public function destroy(CategoriesRequest $request, Category $category)
  {
    $this->categoryService->delete($category);

    return response(__("Category was deleted successfully!"), 200);
  }
}
