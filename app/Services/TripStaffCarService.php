<?php


namespace App\Services;


use App\Models\Seat;
use App\Models\TripCarStaff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TripStaffCarService extends BaseService
{
    protected function setModel()
    {
        $this->model = new TripCarStaff();
    }

    public function __construct()
    {
        $this->setModel();
    }

    public function getList($request) {
        try {
            $querySet = $this->model->query()->with(['staff','assistant', 'trip', 'car', 'schedule', 'seat']);
            $data = $this->getPaginateByQuery($querySet, $request);
            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create($data) {
        try {
            DB::beginTransaction();
            $trip = TripCarStaff::query()->create($data);
            if($trip && $trip->car->seat) {
                \Log::info('$trip->car->seat:'. $trip->car->seat);
                for ($i = 1; $i<= (int) $trip->car->seat; $i++) {
                    Seat::query()->create([
                        'trip_car_staff_id' =>  $trip->id,
                        'seat_id' =>  $i,
                        'status' => Seat::SEAT_IS_ACTIVE['ACTIVE']
                    ]);
                }
            }
            DB::commit();
            return $this->responseSuccess($trip);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
