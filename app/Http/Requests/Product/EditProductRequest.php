<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends BaseRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->id ?? null;
        return [
            'name' => 'required|unique:name,'.$id,
            'amount' => 'required',
            'price' => 'required',
            'sale' => 'nullable',
            'category_id' => 'required',
            'description' => 'nullable',
        ];
    }
}
