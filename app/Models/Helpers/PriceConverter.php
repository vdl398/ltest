<?php

namespace App\Models\Helpers;

class PriceConverter
{
	
	// ковертировать в копейки
	public static function toKop($value, $currencyId) {
		$currencyItem = Currency::getItem($currencyId);
		return $value*$currencyItem['measure']*100;		
	}
	
	// ковертировать из копеек
	public static function fromKop($value, $currencyId) {
		$currencyItem = Currency::getItem($currencyId);
		return $value/100*$currencyItem['measure'];		
	}
	
	// для отображения в шаблоне
	public static function display($value, $currencyId) {
		$currencyItem = Currency::getItem($currencyId);
		return $value.' '.$currencyItem['shortName'];		
	}
	
}
