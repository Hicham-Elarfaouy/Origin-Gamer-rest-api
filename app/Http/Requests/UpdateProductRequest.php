<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => "required",
            "amount" => ["required", "integer", "min:1"],
            "price" => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "discount" => ["required", "min:0", "max:100"],
            "image" => [File::image()->max(12 * 1024)],
            "description" => "required",
            "category_id" => ["required", "integer", "exists:App\Models\Category,id"],
        ];
    }
}
