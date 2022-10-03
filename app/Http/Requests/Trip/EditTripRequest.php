<?php

namespace App\Http\Requests\Trip;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class EditTripRequest extends BaseRequest
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
            'name' => 'required|unique:trips,name,'.$id,
            'from' => 'required',
            'to' => 'required',
            'count' => 'required'
        ];
    }
}
