<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\ManagersOnlyRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
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
    return Category::create($request->all());
  }

  public function update(CategoryUpdateRequest $request, Category $category)
  {
    return response(
      tap($category, fn($category) => $category->update($request->all())),
      200
    );
  }

  public function index(ManagersOnlyRequest $request)
  {
    return
      Category::whereRaw(
        'name LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->paginate(10);
  }

  public function destroy(CategoriesRequest $request, Category $category)
  {
    $category->delete();

    return response("Category was deleted successfully!", 200);
  }
}
