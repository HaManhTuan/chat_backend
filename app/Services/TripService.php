<?php


namespace App\Services;


use App\Models\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TripService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Trip();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getTrip($request) {
        $querySet = $this->model->query();
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createTrip($data) {
        try {
            $trip = Trip::query()->create($data);
            return $this->responseSuccess($trip);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateTrip($id, $data) {
        try {
            $trip = Trip::query()->where('id', $id)->update($data);
            return $this->responseSuccess($trip);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteTrip($id) {
        try {
            $trip = Trip::query()->where('id', $id)->delete();
            return $this->responseSuccess($trip);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
