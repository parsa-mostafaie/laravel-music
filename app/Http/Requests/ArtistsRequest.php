<?php

namespace App\Http\Requests;

use App\Models\Artist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArtistsRequest extends ManagersOnlyRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function _rules(Artist $artist = null): array
    {
        $unique =
            Rule::unique('artists');

        if ($artist) {
            $unique->ignore($artist->id);
        }

        $rules = [
            'name' => [
                'required',
                'string',
                Rule::unique('artists')->ignore($artist->id)
            ],
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'bio' => 'nullable|string'
        ];

        return $rules;
    }
}
