<?php


namespace App\Rules;


use App\Models\Schedule;
use Illuminate\Contracts\Validation\Rule;

class CheckSchedule implements Rule
{
    private $data;
    protected $fail;
    protected $edit;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data, $isEdit=null)
    {
        $this->data = $data;
        $this->edit = $isEdit;
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
        $trip = $this->data->trip_id ?? null;
        $from = $this->data->from ?? null;
        $to = $this->data->to ?? null;
//        $checkIssetTrip = Schedule::query()->where(['from' => $from, 'trip_id' => $trip, 'to' => $to, 'date' => $value])->first();
//        if($checkIssetTrip) {
//            $this->fail = 'Schedule not duplicated. ';
//            return false;
//        } else {
//            return true;
//        }
        if($this->edit) {
            $checkIssetTrip = Schedule::query()->where(['from' => $from, 'trip_id' => $trip, 'to' => $to, 'date' => $value])->where('id','!=', $this->data->id)->get();
            if(count($checkIssetTrip)) {
                $this->fail = 'Schedule not duplicated.';
                return false;
            } else {
                return true;
            }
        } else {
            $checkIssetTrip = Schedule::query()->where(['from' => $from, 'trip_id' => $trip, 'to' => $to, 'date' => $value])->get();
            if(count($checkIssetTrip)) {
                $this->fail = 'Schedule not duplicated.';
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
