<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripCarStaff\AddTripCarStaffRequest;
use App\Models\TripCarStaff;
use App\Services\StaffService;
use App\Services\TripStaffCarService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TripCarStaffController extends Controller
{
    /**
     * @var StaffService
     */
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

    public function getList(Request $request)
    {
        return $this->tripStaffCarService->getList($request);
    }

    public function createData(AddTripCarStaffRequest $request)
    {
        return $this->tripStaffCarService->create($request->getData());
    }
}
