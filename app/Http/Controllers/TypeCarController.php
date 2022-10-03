<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeCar\AddTypeCarRequest;
use App\Http\Requests\TypeCar\EditTypeCarRequest;
use App\Models\TypeCar;
use App\Services\TypeCarService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TypeCarController extends Controller
{
    /**
     * @var TypeCarService
     */
    private $typeCarService;

    protected function setModel()
    {
        $this->model = new TypeCar();
    }

    public function __construct(TypeCarService $typeCarService)
    {
        parent::__construct();
        $this->typeCarService = $typeCarService;
    }

    public function getTypeCar(Request $request)
    {
        return $this->typeCarService->getTypeCar($request);
    }

    public function createTypeCar(AddTypeCarRequest $request)
    {
        return $this->typeCarService->createTypeCar($request->getData());
    }

    public function editTypeCar($id, EditTypeCarRequest $request)
    {
        return $this->typeCarService->updateTypeCar($id, $request->getData());
    }

    public function deleteTypeCar($id)
    {
        return $this->typeCarService->deleteTypeCar($id);
    }
}
