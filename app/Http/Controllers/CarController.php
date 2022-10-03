<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\AddCarRequest;
use App\Http\Requests\Car\EditCarRequest;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * @var CarService
     */
    private $carService;

    protected function setModel()
    {
        $this->model = new Car();
    }

    public function __construct(CarService $carService)
    {
        parent::__construct();
        $this->carService = $carService;
    }

    public function getCar(Request $request)
    {
        return $this->carService->getCar($request);
    }

    public function createCar(AddCarRequest $request)
    {
        return $this->carService->createCar($request->getData());
    }

    public function editCar($id, EditCarRequest $request)
    {
        return $this->carService->updateCar($id, $request->getData());
    }

    public function deleteCar($id)
    {
        return $this->carService->deleteCar($id);
    }
}
