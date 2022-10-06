<?php


namespace App\Services;


use App\Models\Category;
use App\Models\TypeCar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class CategoryService extends BaseService
{
    protected function setModel()
    {
        $this->model = new Category();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getCategory($request) {
        $querySet = $this->model->query();
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function createCategory($data) {
        try {
            $category = Category::query()->create($data);
            return $this->responseSuccess($category);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCategory($id, $data) {
        try {
            $category = Category::query()->where('id', $id)->update($data);
            return $this->responseSuccess($category);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCategory($id) {
        try {
            $category = Category::query()->where('id', $id)->delete();
            return $this->responseSuccess($category);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
