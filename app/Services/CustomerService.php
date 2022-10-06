<?php


namespace App\Services;


use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerService extends BaseService
{
    /**
     * @var AuthService
     */
    private $authService;

    protected function setModel()
    {
        $this->model = new Customer();
    }

    public function __construct(AuthService $authService)
    {
        parent::__construct();
        $this->setModel();
        Config::set('jwt.user', Customer::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Customer::class,
        ]]);
        $this->authService = $authService;
    }

    public function getCustomer($request) {
        $querySet = $this->model->query();
        if ($request->status) {
            $querySet->where('status', $request->status);
        }
        $data = $this->getPaginateByQuery($querySet, $request);
        return $this->responseSuccess($data);
    }

    public function loginFe($data) {
        try {
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => Customer::CUSTOMER_IS_ACTIVE['ACTIVE']
            ];
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->responseError(__('Login Error'), Response::HTTP_BAD_REQUEST);
            }
            $customer = Auth::user();
            if($customer) {
                return $this->responseSuccess([
                    'expires_in' => JWTAuth::factory()->getTTL(),
                    'access_token' => $token,
                    'customer' => $customer,
                ]);
            }

            return $this->responseSuccess([
                'expires_in' => JWTAuth::factory()->getTTL(),
                'access_token' => $token,
            ]);


        }catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function details() {
        $customer = Auth::user();
        return $this->responseSuccess(['customer' => $customer, 'roles' => 1]);
    }

    public function createCustomer($data, $isFrontEnd = null) {
        try {
            $Customer = Customer::query()->create($data);
            if ($isFrontEnd) {
                return $this->loginFe($data);
            }
            return $this->responseSuccess($Customer);

        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCustomer($id, $data) {
        try {
            $Customer = Customer::query()->where('id', $id)->update($data);
            return $this->responseSuccess($Customer);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCustomer($id) {
        try {
            $Customer = Customer::query()->where('id', $id)->delete();
            return $this->responseSuccess($Customer);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
