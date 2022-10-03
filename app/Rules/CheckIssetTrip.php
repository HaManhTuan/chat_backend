<?php


namespace App\Rules;


use App\Models\TripCarStaff;
use Illuminate\Contracts\Validation\Rule;

class CheckIssetTrip implements Rule
{
    private $data;
    protected $fail;
    protected $isEdit;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data, $isEdit=null)
    {
        $this->data = $data;
        $this->isEdit = $isEdit;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $staff = $this->data->staff_id ?? null;
        $trip = $this->data->trip_id ?? null;
        $car = $this->data->car_id ?? null;
        $assistant = $this->data->assistant_driver_id ?? null;
        $schedule = $this->data->schedule_id ?? null;
        if($this->isEdit) {
            $checkEdit = TripCarStaff::query()->where(['staff_id' => $staff, 'trip_id' => $trip, 'datetime' => $value, 'car_id' => $car, 'assistant_driver_id' => $assistant, 'schedule_id' => $schedule])->where('id','!=', $this->data->id)->get();
            if(count($checkEdit))         {
                $this->fail = 'Trip, car, staff, datetime isset. ';
                return false;
            }else {
                return true;
            }
        } else {
            $checkIssetTrip = TripCarStaff::query()->where(['staff_id' => $staff, 'trip_id' => $trip, 'datetime' => $value, 'car_id' => $car, 'assistant_driver_id' => $assistant, 'schedule_id' => $schedule])->first();
            if($checkIssetTrip) {
                $this->fail = 'Trip, car, staff, datetime isset. ';
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->fail;
    }
}
