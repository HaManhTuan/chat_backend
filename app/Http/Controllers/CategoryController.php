<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Requests\TypeCar\AddTypeCarRequest;
use App\Http\Requests\TypeCar\EditTypeCarRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\TypeCarService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    protected function setModel()
    {
        $this->model = new Category();
    }

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    public function getCategory(Request $request)
    {
        return $this->categoryService->getCategory($request);
    }

    public function createCategory(AddCategoryRequest $request)
    {
        return $this->categoryService->createCategory($request->getData());
    }

    public function editCategory($id, EditCategoryRequest $request)
    {
        return $this->categoryService->updateCategory($id, $request->getData());
    }

    public function deleteCategory($id)
    {
        return $this->categoryService->deleteCategory($id);
    }
}
