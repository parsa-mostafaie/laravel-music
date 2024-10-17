<?php

namespace App\Http\Requests;

use App\Models\Track;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TracksRequest extends ManagersOnlyRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function _rules(Track $track = null, $file = "required"): array
    {
        $unique =
            Rule::unique('musics');

        if ($track) {
            $unique->ignore($track->id);
        }

        $rules = [
            'name' => [
                'required',
                'string',
                $unique
            ],
            'summary' => 'nullable|string',
            'lyric' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'file' => $file . '|mimes:mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav|max:30720',
            'quality' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'artist_id' => 'required|exists:artists,id',
        ];

        return $rules;
    }
}
