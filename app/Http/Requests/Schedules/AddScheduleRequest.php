<?php

namespace App\Http\Requests\Schedules;

use App\Http\Requests\BaseRequest;
use App\Rules\CheckSchedule;
use Illuminate\Foundation\Http\FormRequest;

class AddScheduleRequest extends BaseRequest
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
            'trip_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'date' => ['required', new CheckSchedule($this)],
        ];
    }
}
