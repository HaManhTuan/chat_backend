<?php


namespace App\Services;


use App\Models\Car;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ScheduleService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Schedule();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getData($request) {
        try {
            $dateTime = $request->datetime ?? null;
            $tripId = $request->trip_id ?? null;
            $querySet = $this->model->query()->with('trips');
            if($dateTime) {
                $querySet->where('date', $dateTime);
            }
            if($tripId) {
                $querySet->where('trip_id', $tripId);
            }
            $data = $this->getPaginateByQuery($querySet, $request);
            return $this->responseSuccess($data);
        } catch (\Exception $e){
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function createData($data) {
        try {
           $create = Schedule::query()->create($data);
            return $this->responseSuccess($create);
        } catch (\Exception $e){
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function editData($id, $data) {
        try {
            $car = Schedule::query()->where('id', $id)->update($data);
            return $this->responseSuccess($car);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteDate($id) {
        try {
            $schedule = Schedule::query()->where('id', $id)->delete();
            return $this->responseSuccess($schedule);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

