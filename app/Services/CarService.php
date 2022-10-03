<?php


namespace App\Services;


use App\Models\Car;
use App\Models\TripCarStaff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Car();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getCar($request) {
        $querySet = $this->model->query()->with('typeCar');
        if($request->option && $request->schedule_id && $request->type_car_id) {
            \Log::info($request->type_car_id);
            $querySet->where('type_car_id', $request->type_car_id);
            $idCarNotReady = TripCarStaff::query()->where('schedule_id', $request->schedule_id)->pluck('car_id');
            if(count($idCarNotReady)) {
                $querySet->whereNotIn('id',$idCarNotReady);
            }
        }
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createCar($data) {
        try {
            $car = Car::query()->create($data);
            return $this->responseSuccess($car);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCar($id, $data) {
        try {
            $car = Car::query()->where('id', $id)->update($data);
            return $this->responseSuccess($car);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCar($id) {
        try {
            $car = Car::query()->where('id', $id)->delete();
            return $this->responseSuccess($car);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
