<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseRequest;
use App\Rules\CheckAccessKey;
use Illuminate\Foundation\Http\FormRequest;

class AddCustomerRequest extends BaseRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'gender'  => 'nullable',
            'old'  => 'nullable',
            'email'  => 'required|unique:customers',
            'phone'  => 'required|unique:customers',
            'address'  => 'nullable',
            'password'  => 'bail|required|min:6'
        ];
    }
}
