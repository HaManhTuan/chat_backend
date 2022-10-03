<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trip\AddTripRequest;
use App\Http\Requests\Trip\EditTripRequest;
use App\Models\Trip;
use App\Services\TripService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * @var tripService
     */
    private $tripService;

    protected function setModel()
    {
        $this->model = new Trip();
    }

    public function __construct(TripService $tripService)
    {
        parent::__construct();
        $this->tripService = $tripService;
    }

    public function getTrip(Request $request)
    {
        return $this->tripService->getTrip($request);
    }

    public function createTrip(AddTripRequest $request)
    {
        return $this->tripService->createTrip($request->getData());
    }

    public function editTrip($id, EditTripRequest $request)
    {
        return $this->tripService->updateTrip($id, $request->getData());
    }

    public function deleteTrip($id)
    {
        return $this->tripService->deleteTrip($id);
    }
}
