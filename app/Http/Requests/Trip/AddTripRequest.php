<?php

namespace App\Http\Requests\Trip;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddTripRequest extends BaseRequest
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
        return [
            'name' => 'required|unique:trips',
            'from' => 'required',
            'to' => 'required',
            'count' => 'required'
        ];
    }
}
