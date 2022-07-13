<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $criteria = $request->get('q', '');
        $pageSize = $request->get('page_size', 15);
        $customers = Customer::search($criteria)->paginate($pageSize);
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //TODO: implement store feature
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return Response
     */
    public function show(Customer $customer)
    {
        //TODO: implement show feature
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return Response
     */
    public function update(Request $request, Customer $customer)
    {
        //TODO: implement update feature
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        //TODO: implement delete feature
    }
}
