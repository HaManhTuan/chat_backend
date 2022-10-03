<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

abstract class BaseService
{

    /** @var $model Model */
    protected $model;

    /** @var Builder $query */
    protected $query;

    public $className;


    public function __construct()
    {
        $this->setModel();
        $this->setQuery();
        $this->setClassName();
    }

    /**
     * @return mixed
     */
    abstract protected function setModel();

    /**
     *
     */
    private function setQuery()
    {
        $this->query = $this->model->query();
    }

    public function show($id)
    {
        $data = $this->query->find($id);
        return $data;
    }

    private function setClassName()
    {
        $this->className = get_class($this->model);
    }

    /**
     * @param Mailable $obj
     * @return boolean
     */
    public function sendMail(Mailable $obj)
    {
        try {
            Mail::send($obj);
            return true;
        } catch (\Exception $e) {
            Log::info('SEND MAIL ERROR: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function store($input)
    {
        $save = $this->model->fill($input)->save();
        return $this->res($save, __('validation.models.' . $this->className) . __('message.common.create_success'));
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function update($input, $id)
    {
        $data = $this->query->find($id);
        if (!$data) {
            return $this->res($data, str_replace(':model', __('validation.models.' . $this->className), __('message.common.not_exists')));
        }
        $save = $data->fill($input)->save();
        return $this->res($save, __('validation.models.' . $this->className) . __('message.common.update_success'));
    }

    public function res($data, $message = null)
    {
        $message = $message ? $message : __('message.common.exception');
        return $data ? ['message' => $message] : ['errors' => $message];
    }

    protected function addDefaultFilter(&$query, Request $request, $isSort = true)
    {
        $request = $request->toArray();
        foreach ($request as $key => $value) {
            $key = str_replace('-', '.', $key);
            try {
                if (preg_match('/(.*)_like$/', $key, $matches) && str_replace('%', '', $value) != '') {
                    $query->where($matches[1], 'like', '%' . $value . '%');
                }
                if (preg_match('/(.*)_equal$/', $key, $matches) && $value !== '' && $value !== null) { //pass if value === 0
                    $query->where($matches[1], $value);
                }
                if (preg_match('/(.*)_start_date$/', $key, $matches) && $value) {
                    $query->whereDate($matches[1], '>=', Carbon::parse($value)->addHours(config('app.time_offset')));
                }
                if (preg_match('/(.*)_end_date$/', $key, $matches) && $value) {
                    $query->whereDate($matches[1], '<=', Carbon::parse($value)->addHours(config('app.time_offset')));
                }

                if (preg_match('/(.*)_start_time$/', $key, $matches) && $value) {
                    $query->whereTime($matches[1], '>=', date('H:i:s', strtotime($value)));
                }
                if (preg_match('/(.*)_end_time$/', $key, $matches) && $value) {
                    $query->whereTime($matches[1], '<=', date('H:i:s', strtotime('+1 minutes', strtotime($value))));
                }

                //add having filter
                if (preg_match('/(.*)_like_having$/', $key, $matches) && str_replace('%', '', $value) != '') {
                    $query->having($matches[1], 'like', '%' . $value . '%');
                }
                if (preg_match('/(.*)_equal_having$/', $key, $matches) && $value !== '' && $value !== null) { //pass if value === 0
                    $query->having($matches[1], $value);
                }

                if ($key == 'sort' && $value && $isSort) {
                    $sortParams = explode('|', $value);
                    $query->orderBy($sortParams[0], isset($sortParams[1]) ? $sortParams[1] : 'asc');
                }
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @param Builder $query
     * @param Request $request
     * @return array
     */
    public function getPaginateByQuery($query, Request $request)
    {
        $without = ['orders', 'limit', 'offset'];
        $total = DB::query()->fromSub($query->cloneWithout($without), 'sub_table')->count();
        $currentPage = $request->current_page ? (int)$request->current_page : config('pagination.current_page');
        $perPage = $request->per_page ? (int)$request->per_page : config('pagination.per_page');
        if ($total == 0) {
            $lastPage = 1;
            $offSet = 0;
            $from = 0;
            $to = 0;
        } else {
            $lastPage = ceil($total / $perPage);
            $offSet = (($currentPage - 1) * $perPage);
            $from = $total ? ($offSet + 1) : 0;
            $to = $currentPage == $lastPage ? $total : ((($currentPage - 1) * $perPage) + $perPage);
        }
        $data = $query->offset($offSet ?: 0)->limit($perPage)->get();
        return [
            'data' => $data,
            'pagination' => [
                'current_page' => $currentPage,
                'from' => $from,
                'to' => $to,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'total' => $total
            ]
        ];
    }

    public function objectToArray($d)
    {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            return $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return $d;
        }
        return [];
    }

    public function scopeIdDescending($query)
    {
        return $query->orderBy('id','DESC');
    }

    public function responseSuccess($data, $message = null)
    {
        if ($message) {
            return response()->json(['success' => true, 'data' => $data, 'message' => $message], 200);
        }
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function responseError($message, $status)
    {
        $status = $status ? $status : 500;
        return response()->json(['success' => false, 'message' => $message], $status);
    }

}
