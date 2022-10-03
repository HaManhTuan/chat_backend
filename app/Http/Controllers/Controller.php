<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var $model Model */
    protected $model;

    /** @var Builder $query */
    protected $query;

    /** @var Request $request */
    protected $request;

    public function __construct()
    {
        $this->request = request();
        $this->setModel();
        $this->setQuery();
    }

    /**
     * @return mixed
     */
    abstract protected function setModel();

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (method_exists($this, 'addFilter')) {
            $this->addFilter();
        }
        $this->addDefaultFilter();
        $data = $this->query->paginate($request->per_page ?: 20);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     * @param $id
     * @return Builder|mixed
     */
    public function show($id)
    {
        if (method_exists($this, 'addAppend')) {
            $this->addAppend();
        }
        $data = $this->query->find($id);
        return $data ?? response()->json([
                'message' => 'Not found',
            ], 404);
    }


    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $data = $this->query->find($id);
        if (!$data) {
            return $this->errorResponse();
        }
        $result = $data->delete();
        return $this->resultResponse($result);
    }

    /**
     *
     */
    private function setQuery()
    {
        $this->query = $this->model->query();
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function resultResponse($data)
    {
        return $data ? $this->successResponse() : $this->errorResponse();
    }

    /**
     * @param array $responseData
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($responseData = ['message' => 'OK'])
    {
        return response()->json($responseData);
    }

    /**
     * @param array $errorData
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($errorData)
    {
        return response()->json($errorData, 500);
    }

    /**
     *
     */
    private function addDefaultFilter()
    {
        $data = $this->request->toArray();
        foreach ($data as $key => $value) {
            try {
                if (preg_match('/(.*)_like$/', $key, $matches) && str_replace('%', '', $value) != '') {
                    $this->query->where($matches[1], 'like', '%'. $value . '%');
                }
                if (preg_match('/(.*)_equal$/', $key, $matches)) {
                    $this->query->where($matches[1], $value);
                }
                if (preg_match('/^has_(.*)/', $key, $matches) && $value) {
                    $this->query->whereHas($matches[1]);
                }
                if ($key == 'only_trashed' && $value) {
                    $this->query->onlyTrashed();
                }
                if ($key == 'with_trashed' && $value) {
                    $this->query->withTrashed();
                }

                if ($key == 'sort' && $value) {
                    $sortParams = explode('|', $value);
                    $this->query->orderBy($sortParams[0], isset($sortParams[1]) ? $sortParams[1] : 'asc');
                }
            } catch (\Exception $e) {
            }
        }
    }
}
