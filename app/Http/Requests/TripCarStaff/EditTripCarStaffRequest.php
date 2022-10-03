<?php

namespace App\Http\Requests\TripCarStaff;

use App\Http\Requests\BaseRequest;
use App\Rules\CheckAssistant;
use App\Rules\CheckIssetTrip;
use Illuminate\Foundation\Http\FormRequest;

class EditTripCarStaffRequest extends BaseRequest
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
            'trip_id' => 'required',
            'staff_id' => 'required',
            'car_id' => 'required',
            'schedule_id' => 'required',
            'assistant_driver_id' => ['required', new CheckAssistant($this)],
            'datetime' => ['required', new CheckIssetTrip($this, true)],
        ];
    }
}
