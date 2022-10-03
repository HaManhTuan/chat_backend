<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\AddStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    /**
     * @var StaffService
     */
    private $staffService;

    protected function setModel()
    {
        $this->model = new Staff();
    }

    public function __construct(StaffService $staffService)
    {
        parent::__construct();
        $this->staffService = $staffService;
    }

    public function getStaff(Request $request)
    {
        return $this->staffService->getStaff($request);
    }

    public function createStaff(AddStaffRequest $request)
    {
        return $this->staffService->createStaff($request->getData());
    }

    public function editStaff($id, UpdateStaffRequest $request)
    {
        return $this->staffService->updateStaff($id, $request->getData());
    }

    public function deleteStaff($id)
    {
        return $this->staffService->deleteStaff($id);
    }

    public function getAssistantDriver($id, Request $request) {
        return $this->staffService->getAssistant($id, $request);
    }
}
