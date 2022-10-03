<?php

namespace App\Http\Requests\Seat;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddSeatRequest extends BaseRequest
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
            'seat_id' => 'required',
            'trip_staff_id' => 'required',
            'customer_name' => 'customer_id',
            'customer_phone' => 'customer_id',
        ];
    }
}
