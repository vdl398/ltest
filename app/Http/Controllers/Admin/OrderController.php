<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Resources\AjaxResource;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Orders;
use App\Models\Base;

class OrderController extends Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index', [
		    'orders' => Orders::select('*')->paginate(5)
		]);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$order = Base\Order::getById($id);
        return view('admin.order.show', [
		    'order' => $order->getEntity(),
			'basket' => $order->getBasket()->getList(),
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$resource = new AjaxResource();	
		$result = Base\Order::deleteById($id);
		if (!$result->isSuccess()) {
			return back()->withErrors($result->getErrors());
		}
        return redirect('/admin/order');
    }

    //Сменить статус
	public function setStatus(Request $request){
        $resource = new AjaxResource();	
        $param = $request->all();
        $order = Orders::findOrFail((int)$param['orderId']);
		$order->status = $param['status'];
        $order->save();
        return $resource->sendSuccess();
    }	

}