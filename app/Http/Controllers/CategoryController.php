<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
  public function manage(Request $request)
  {
    return Inertia::render('Manager/Categories', [
      'currentPage' => $request->get('page'),
      'search' => $request->get('search'),
      'categories_select' => Category::pluck('name', 'id')
    ]);
  }

  public function store(Request $request)
  {
    $request->validate(
      [
        'name' => 'required|string|unique:categories',
        'parent_id' => "nullable|exists:categories,id"
      ]
    );

    return Category::create($request->all());
  }
  public function update(Request $request, Category $category)
  {
    $request->validate(
      [
        'name' => [
          'required',
          'string',
          Rule::unique('categories')->ignore($category->id)
        ],
        'parent_id' => "nullable|exists:categories,id|not_in:{$category->id}"
      ]
    );

    return response(
      tap($category, fn($category) => $category->update($request->all())),
      200
    );
  }

  public function show(Request $request)
  {
    return
      Category::whereRaw(
        'name LIKE ?',
        ["%{$request->get('search')}%"]
      )
        ->with('parent')
        ->paginate(2);
  }

  public function destroy(Category $category)
  {
    $category->delete();

    return response("Category was deleted successfully!", 204);
  }
}
