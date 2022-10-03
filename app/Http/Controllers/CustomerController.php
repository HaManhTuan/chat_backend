<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\Customer\AddCustomerRequest;
use App\Http\Requests\Customer\EditCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @var customerService
     */
    private $customerService;

    protected function setModel()
    {
        $this->model = new Customer();
    }

    public function __construct(CustomerService $customerService)
    {
        parent::__construct();
        $this->customerService = $customerService;
    }

    //Backend
    public function getCustomer(Request $request)
    {
        return $this->customerService->getCustomer($request);
    }

    //Backend
    public function createCustomerBE(AddCustomerRequest $request)
    {
        return $this->customerService->createCustomer($request->getData());
    }

    public function deleteCustomer($id)
    {
        return $this->customerService->deleteCustomer($id);
    }

    //Backend
    public function editCustomerBE($id, EditCustomerRequest $request)
    {
        return $this->customerService->updateCustomer($id, $request->getData());
    }

    //Client-Customer
    public function createCustomer(AddCustomerRequest $request)
    {
        return $this->customerService->createCustomer($request->getData());
    }

    //Client-Customer
    public function editCustomer($id, EditCustomerRequest $request)
    {
        return $this->customerService->updateCustomer($id, $request->getData());
    }


}
