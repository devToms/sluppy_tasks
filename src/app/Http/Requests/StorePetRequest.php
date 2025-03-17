<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'category.name' => 'required|string|max:255',
            'photoUrls' => 'required|string',  // URL'e jako string oddzielone przecinkami
            'tags' => 'required|string',      // Tagi jako string oddzielone przecinkami
            'status' => 'required|in:available,pending,sold',
        ];
    }
}
