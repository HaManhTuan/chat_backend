<?php

namespace App\Http\Requests\Car;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddCarRequest extends BaseRequest
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
            'name' => 'required',
            'type_car_id' => 'required',
            'license_plates' => 'required|unique:cars',
            'color' => 'required',
            'seat' => 'required'
        ];
    }
}
