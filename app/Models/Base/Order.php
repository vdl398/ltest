<?php

namespace App\Models\Base;


use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Validator;
use \App\Models\Helpers\Result;
use \App\Models\Orders;

class Order
{
	
	protected $entity=null; // основная сущность закзаза
	protected $basket=null; // корзина
	protected $errors = [];

	// получить ошибки
    public function getErrors()
    {
		return $this->errors;
	}
	
	// получить id заказа
    public function getId()
    {
		return $this->entity->id;
	}
	
	// получить заказ
    public static function getById(int $id)
    {
		$order = new static;
		$order->entity = Orders::find($id);
		$order->basket = Basket::getByOrderId($id);
		return $order;
	}
	
	// удалить заказ
	public static function deleteById(int $id): Result
    {
		$result = new Result;
        try {
			$order = Orders::findOrFail($id);
			DB::beginTransaction();
            Basket::deleteByOrderId($id);
			$order->delete();
		    DB::commit();
			Basket::deleteSession();
		} catch(\Throwable $e) {
		    DB::rollBack();
			$result->addError($e->getMessage());
		}
		return $result;
	}
	
	// заполнить поля
	public function setFields(array $fields)
    {
		$validator = Validator::make($fields, Orders::getValidateParams());
        if ($validator->fails()) {	
			$this->errors = $validator->messages()->get('*');
			return false;
        }
		$this->entity = new Orders;
		$this->entity->fill($fields);
		return true;
	}
	
	// получить сущность закзаа
	public function getEntity()
    {
		return $this->entity;
	}
	
	// установить корзину
	public function setBasket(Basket $basket)
    {
		if (!empty($basket->getErrors())) {
			$this->errors = array_merge($this->errors, $basket->getErrors());
			return false;
		}
		$this->basket = $basket;
		return true;
	}
	
	// получить козину
	public function getBasket(): Basket
    {
		return $this->basket;
	}

    // сохранить заказ с корзиной и тд.
	public function save()
    {
		if (!empty($this->errors)) {
			return false;
		}
		if (empty($this->entity)) {
			$this->errors [] = 'entity empty';
			return false;
		}
		if (empty($this->basket)) {
			$this->errors [] = 'basket empty';
			return false;
		}
        try {
			DB::beginTransaction();
			$this->entity->sum = $this->basket->getSum();
            $this->entity->save(); // сохранить основную сущность закзаза
		    if (!(int)$this->entity->id) {
				throw new \Exception('create error');
		    }
			if (!$this->basket->setOrderId($this->entity->id)->save()) { // сохранить корзину на полученный id заказа
				throw new \Exception(join(", ",$this->basket->getErrors()));
			}
		    DB::commit();
			Basket::deleteSession();
		} catch(\Throwable $e) {
		    DB::rollBack();
			$this->errors[] = $e->getMessage();
		}
		return empty($this->errors);
	}
	
}