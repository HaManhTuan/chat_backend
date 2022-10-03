<?php


namespace App\Services;


use App\Models\Staff;
use App\Models\TripCarStaff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaffService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Staff();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getStaff($request) {
        $querySet = $this->model->query();
        if ($request->status) {
            $querySet->where('status', $request->status);
        }
        $querySet = $this->getIdStaffNotReady($request, $querySet);
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createStaff($data) {
        try {
            $staff = Staff::query()->create($data);
            return $this->responseSuccess($staff);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateStaff($id, $data) {
        try {
            $staff = Staff::query()->where('id', $id)->update($data);
            return $this->responseSuccess($staff);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteStaff($id) {
        try {
            $staff = Staff::query()->where('id', $id)->delete();
            return $this->responseSuccess($staff);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function getAssistant($id, $request) {
        try {
            $query = Staff::query()->where('id','!=', $id);
            $query = $this->getIdStaffNotReady($request, $query);
            $staff = $query->get();
            return $this->responseSuccess($staff);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getIdStaffNotReady($request, $querySet) {
        if($request->option && $request->schedule_id) {
            $idStaffNotReady = TripCarStaff::query()->where('schedule_id', $request->schedule_id)->pluck('staff_id')->toArray();
            $idAssistantNotReady = TripCarStaff::query()->where('schedule_id', $request->schedule_id)->pluck('assistant_driver_id')->toArray();
            $idAllStaff = array_merge($idStaffNotReady, $idAssistantNotReady);
            if(count($idAllStaff)) {
                $querySet->whereNotIn('id', $idAllStaff);
            }
            return $querySet;
        }
        return $querySet;
    }
}
