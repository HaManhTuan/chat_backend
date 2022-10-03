<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class CheckAssistant implements Rule
{
    private $data;
    protected $fail;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $assistant = $this->data->assistant_driver_id ?? null;
        if($assistant == $staff) {
          return false;
        } else {
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'driver must must be different assistant';
    }
}
