<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedules\AddScheduleRequest;
use App\Http\Requests\Schedules\EditScheduleRequest;
use App\Models\Schedule;
use App\Services\CarService;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * @var CarService
     */
    private $scheduleService;

    protected function setModel()
    {
        $this->model = new Schedule();
    }

    public function __construct(ScheduleService $scheduleService)
    {
        parent::__construct();
        $this->scheduleService = $scheduleService;
    }

    public function getData(Request $request)
    {
        return $this->scheduleService->getData($request);
    }

    public function createData(AddScheduleRequest $request)
    {
        return $this->scheduleService->createData($request->getData());
    }

    public function editData($id, EditScheduleRequest $request)
    {
        return $this->scheduleService->editData($id, $request->getData());
    }

    public function deleteData($id)
    {
        return $this->scheduleService->deleteDate($id);
    }
}
