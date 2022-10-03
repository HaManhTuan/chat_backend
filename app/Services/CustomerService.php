<?php


namespace App\Services;


use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Customer();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getCustomer($request) {
        $querySet = $this->model->query();
        if ($request->status) {
            $querySet->where('status', $request->status);
        }
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createCustomer($data) {
        try {
            $Customer = Customer::query()->create($data);
            return $this->responseSuccess($Customer);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCustomer($id, $data) {
        try {
            $Customer = Customer::query()->where('id', $id)->update($data);
            return $this->responseSuccess($Customer);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCustomer($id) {
        try {
            $Customer = Customer::query()->where('id', $id)->delete();
            return $this->responseSuccess($Customer);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
