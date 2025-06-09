<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use \App\Http\Resources\AjaxResource;
use \App\Models\Products;
use \App\Models\Categories;
use \App\Models\Base\Basket;

class BasketController extends Controller
{

    public function index()
    {
        return view('basket.index', [
		    'positionExist' => !empty((new Basket)->getFromSession()->getList()->toArray())
		]);
    }
	
	// получить список аяксом
    public function getList()
    {
		$resource = new AjaxResource();
		
        return $resource->sendSuccess(['list' => (new Basket)->getFromSession()->getList()->toArray()]);
    }

	// добавить позицию в сессию
    public function addItem(Request $request){
        $resource = new AjaxResource();
		$result = Basket::addItem($request->all());
		if (!$result->isSuccess()) {
			return $resource->sendError($result->getErrors());
		}
        return $resource->sendSuccess();
    }
	
	// изменить позицию в сессии
	public function updateItem(Request $request){
        $resource = new AjaxResource();		
		$result = Basket::updateItem($request->all());
		if (!$result->isSuccess()) {
			return $resource->sendError($result->getErrors());
		}
        return $resource->sendSuccess();
    }	
	
	// удалить позицию из сессии
	public function deleteItem(Request $request){
        $resource = new AjaxResource();
		$param = $request->all();
		$result = Basket::deleteItem($param['product_id']);
		if (!$result->isSuccess()) {
			return $resource->sendError($result->getErrors());
		}
        return $resource->sendSuccess();	
    }
	
	
}
