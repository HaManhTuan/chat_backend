<?php


namespace App\Services;


use App\Models\TypeCar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TypeCarService extends BaseService
{
    protected function setModel()
    {
        $this->model = new TypeCar();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getTypeCar($request) {
        $querySet = $this->model->query()->with('car');
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createTypeCar($data) {
        try {
            $TypeCar = TypeCar::query()->create($data);
            return $this->responseSuccess($TypeCar);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateTypeCar($id, $data) {
        try {
            $TypeCar = TypeCar::query()->where('id', $id)->update($data);
            return $this->responseSuccess($TypeCar);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteTypeCar($id) {
        try {
            $TypeCar = TypeCar::query()->where('id', $id)->delete();
            return $this->responseSuccess($TypeCar);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
