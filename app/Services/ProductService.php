<?php


namespace App\Services;


use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ProductService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Product();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getProduct($request) {
        $querySet = $this->model->query();
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createProduct($data) {
        try {
            $Product = Product::query()->create($data);
            return $this->responseSuccess($Product);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProduct($id, $data) {
        try {
            $Product = Product::query()->where('id', $id)->update($data);
            return $this->responseSuccess($Product);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteProduct($id) {
        try {
            $Product = Product::query()->where('id', $id)->delete();
            return $this->responseSuccess($Product);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
