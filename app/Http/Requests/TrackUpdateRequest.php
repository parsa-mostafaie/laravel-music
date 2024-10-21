<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackUpdateRequest extends TracksRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return parent::_rules($this->route('track'), 'nullable');
    }
}