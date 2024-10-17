<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriesRequest extends ManagersOnlyRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function _rules(Category $category = null): array
    {
        $unique =
            Rule::unique('categories');

        if ($category) {
            $unique->ignore($category->id);
        }

        $rules = [
            'name' => [
                'required',
                'string',
                $unique
            ],
            'parent_id' => "nullable|exists:categories,id|not_in:{$category->id}"
        ];

        return $rules;
    }
}
