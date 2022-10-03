<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddStaffRequest extends BaseRequest
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
        \Log::info($this);
        return [
            'name' => 'required',
            'gender'  => 'required',
            'birthday'  => 'required|date_format:d/m/Y',
            'avatar'  => 'nullable',
            'phone'  => 'required|unique:staff',
            'address'  => 'required'
        ];
    }
}
