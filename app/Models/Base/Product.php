<?php

namespace App\Models\Base;

use \App\Models\Products;
use \App\Models\Base\Basket;

class Product
{
	
	//форматировать список товаров
    public static function formatList($data)
    {
		$data->transform(function($entry, $key) {
            return self::formatItem($entry);
        });
		return $data;
    }
	
	//форматировать список элемент
    public static function formatItem(Products $data): Products
    {
		$data->basketButton = Basket::getButton($data);
		return $data;
    }

}