<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    protected function setModel()
    {
        $this->model = new Product();
    }
    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function getProduct(Request $request)
    {
        return $this->productService->getProduct($request);
    }

    public function createProduct(AddProductRequest $request)
    {
        return $this->productService->createProduct($request->getData());
    }

    public function editProduct($id, EditProductRequest $request)
    {
        return $this->productService->updateProduct($id, $request->getData());
    }

    public function deleteProduct($id)
    {
        return $this->productService->deleteProduct($id);
    }
}
