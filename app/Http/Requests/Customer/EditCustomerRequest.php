<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseRequest;
use App\Rules\CheckAccessKey;
use Illuminate\Foundation\Http\FormRequest;

class EditCustomerRequest extends BaseRequest
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
        $isBackend = $this->isBackEnd ?? null;
        if($isBackend) {
            return [
                'name' => 'required',
                'gender'  => 'required',
                'old'  => 'required',
                'phone'  => 'required|unique:customers,phone,'.$id,
                'address'  => 'required'
            ];
        } else {
            return [
                'access_key' => ['required', new CheckAccessKey()],
                'name' => 'required',
                'gender'  => 'required',
                'old'  => 'required',
                'phone'  => 'required|unique:customers,phone,'.$id,
                'address'  => 'required'
            ];
        }

    }
}
