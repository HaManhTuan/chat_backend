<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seat\AddSeatRequest;
use App\Models\Booking;
use App\Models\TripCarStaff;
use App\Services\TripStaffCarService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $tripStaffCarService;

    protected function setModel()
    {
        $this->model = new TripCarStaff();
    }

    public function __construct(TripStaffCarService $tripStaffCarService)
    {
        parent::__construct();
        $this->tripStaffCarService = $tripStaffCarService;
    }

    public function booking(AddSeatRequest $request) {

    }
}
