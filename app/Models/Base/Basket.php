<?php

namespace App\Models\Base;

use \App\Models\Helpers\Result;
use \App\Models\Products;
use \App\Models\Basket as BasketEntity;
use \App\Models\Helpers\PriceConverter;
use \App\Models\Helpers\Settings;

class Basket
{
	
	protected $list=null;
	protected $errors = [];

	// сохранить корзину
    public function save()
    {
		if (!$this->list || $this->list->isEmpty()) {
			$this->errors[] = 'list empty';
			return false;
		}
		try {
			$productList = self::getProductMap(array_column($this->list->toArray(), 'product_id'));
		    foreach($this->list as $item) {
			    if ((int)$item['id']) {
			        $listItem = BasketEntity::find((int)$item['id']);
				    if(!$listItem) throw new \Exception('basket item id='.$item['id'].' not found');
			    }
			    else {
			        $listItem = new BasketEntity;
			    }
			    $listItem->order_id = (int)$item['order_id'];
			    $listItem->product_id = (int)$item['product_id'];
			    $listItem->count = (int)$item['count'];
				$listItem->item_price = $productList[(string)$item['product_id']]->price;
			    $listItem->save();
			    if (!(int)$listItem->id) throw new \Exception('id='.$item['product_id'].' save error');
		    }
		} catch(\Throwable $e) {
			$this->errors[] = $e->getMessage();
		}
		return empty($this->errors);
    }
	
	// привязать к заказу
    public function setOrderId(int $orderId)
    {
		if ($this->list !== null) {
		    $this->list->transform(function($entry, $key) use ($orderId) {
			    $entry->order_id = $orderId;
			    return $entry;
            });
		}
		return $this;
	}
	
	// получить список позиций
    public function getList()
    {
		return $this->list ?: collect([]);
	}
	
	// общая сумма корзины
    public function getSum()
    {
		return array_sum(array_column($this->getList()->toArray(), 'sum'));
	}
	
	// получить ошибки
    public function getErrors()
    {
		return $this->errors;
	}

    // получить корзину из сессии
    public static function getFromSession()
    {
		$basket = new static;
        $basketList = (array)session('basket');
		$ids = array_column($basketList, 'product_id');
		$basket->list = collect([]);
		if (empty($ids)) {
	        return $basket;
		}
		$productList = self::getProductMap($ids);
		foreach($basketList as $item) {
			$listItem = new BasketEntity;
			$listItem->product_id = (int)$item['product_id'];
			$listItem->product = $productList[(string)$item['product_id']];
			$listItem->count = (int)$item['count'];
			$listItem->item_price = $productList[(string)$item['product_id']]->price;
			$listItem->itemPriceDisplay = $listItem->itemPriceDisplay;
			$listItem->sum = $listItem->sum;
			$listItem->sumDisplay = $listItem->sumDisplay;
			$basket->list->push($listItem);
		}
	    return $basket;
    }
	
	// получить сохраненную корзину через заказ
	public static function getByOrderId(int $orderId)
    {
		$basket = new static;
		$basket->list = BasketEntity::select('*')->with('product')->where('order_id', '=', $orderId)->get();
		return $basket;
	}
	
	// удалить корзину через заказ
	public static function deleteByOrderId(int $orderId)
    {
		foreach(BasketEntity::select('*')->where('order_id', '=', $orderId)->get() as $item) {
			$item->delete();
		}
		return true;
	}

    // добавить товар в сессию
    public static function addItem(array $param): Result
	{
		$result = new Result;
        $basket = (array)session('basket');
		if (!empty($basket[(string)$param['product_id']])) return $result;
		$basket[(string)$param['product_id']] = ['product_id' => (int)$param['product_id'], 'count' => 1];
        session(['basket' => $basket]);
        return $result;
    }
	
	// изменить товар в сессии
	public static function updateItem(array $param): Result
	{
		$result = new Result;
        $basket = (array)session('basket');
		if (empty($basket[(string)$param['product_id']])) {
			$result->addError('product_id='.$param['product_id'].' not found');
			return $result;
		}
		switch($param['operation']) {
			case '+':
			    $basket[(string)$param['product_id']]['count']++;
			break;
			case '-':
			    if ($basket[(string)$param['product_id']]['count'] > 1) $basket[(string)$param['product_id']]['count']--;
			break;
		}
        session(['basket' => $basket]);
        return $result;
    }	
	
	// удалить товар из сессии
	public static function deleteItem($productId): Result
	{
		$result = new Result;
        $basket = (array)session('basket');
		if (empty($basket[(string)$productId])) return $result;
		unset($basket[(string)$productId]);
        session(['basket' => $basket]);
        return $result;
    }
	
	// удалить все товары из сессии
	public static function deleteSession(): Result
	{
		$result = new Result;
        session(['basket' => []]);
        return $result;
    }
	
	// получить товары
	public static function getProductMap(array $productIds)
    {
		$productList = [];
		if (empty($productIds)) return $productList;
		foreach(Products::select('*')->whereIn('id', $productIds)->get() as $product) {
			$productList[(string)$product->id] = $product;
			$productList[(string)$product->id]->categoryDisplay = $product->categoryDisplay;
			$productList[(string)$product->id]->priceDisplay = $product->priceDisplay;
		}
		if (sizeof($productList) != sizeof($productIds)) throw new \Exception('basket product map error');
		return $productList;
	}
	
	// кнопка добавления в корзину для вывода в шаблоне
	public static function getButton(Products $product)
    {
		$basketList = (array)session('basket');
		return view('basket.button', [
		    'product' => $product,
			'inBasket' => $product? !empty($basketList[(string)$product->id]) : false
		]);
    }
	
	
}
