<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use \App\Http\Resources\AjaxResource;
use \App\Models\Products;
use \App\Models\Categories;
use \App\Models\Basket;
use \App\Models\Orders;
use \App\Models\Base;
use \Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource = new AjaxResource();
		$param = $request->all();
		$order = new Base\Order;
		if (!$order->setFields($param['fields'])) {
			return $resource->sendError($order->getErrors());
		}
		if (!$order->setBasket((new Base\Basket)->getFromSession())) {
			return $resource->sendError(['errorMessage' => $order->getErrors()]);
		}
		if (!$order->save()) {
			return $resource->sendError(['errorMessage' => $order->getErrors()]);
		}
        return $resource->sendSuccess(['id' => $order->getId()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('order.show', [
		    'order' => Orders::find($id)
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
