<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',  
            'name' => 'required|string|max:255',
            'category.id' => 'nullable|integer',
            'category.name' => 'required|string|max:255',
            'photoUrls' => 'required|array', 
            'photoUrls.*' => 'url',       
            'tags' => 'required|array',  
            'tags.*.id' => 'nullable|integer',
            'tags.*.name' => 'required|string|max:255',
            'status' => 'required|in:available,pending,sold',
        ];
    }
}
