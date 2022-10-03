<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends BaseRequest
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
            'name' => 'required',
            'gender'  => 'required',
            'birthday'  => 'required',
            'avatar'  => 'required',
            'phone'  => 'required|unique:staff,phone,'.$id,
            'address'  => 'required'
        ];
    }
}
