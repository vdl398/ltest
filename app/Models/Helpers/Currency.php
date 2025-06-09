<?php

namespace App\Models\Helpers;

class Currency
{
	
	// список валют 
	public static function getList() {
		return [
		    'RUB' => ['id' => 'RUB', 'name' => 'Рубли', 'shortName' => 'Руб.', 'measure' => 1],
		];
	}
	
	// элемент валюты
	public static function getItem($currencyId) {
		if (!$currencyId) throw new \Exception('currencyId empty');
		$currencyList = self::getList();
		if (empty($currencyList[$currencyId])) throw new \Exception('currencyId ='.$currencyId.' not found');
		return $currencyList[$currencyId];		
	}

}
