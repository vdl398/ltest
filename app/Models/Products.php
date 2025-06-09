<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Model;
use \App\Models\Helpers\PriceConverter;
use \App\Models\Helpers\Settings;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class Products extends Model
{
    use HasFactory;
	
	public $timestamps = false;
	
	protected static $categories = null;

	protected $fillable = ['name', 'description', 'price', 'category_id'];
	
	// параметры для валидации
	public static function getValidateParams() {
		return [
            'name' => ['required', 'string', 'max:200'],
			'description' => ['string', 'max:500'], 
			'price' => ['numeric'], 
			'category_id' => ['integer']
        ];
	}

    // цена сконвертированная в копейки для сохранения в БД
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => PriceConverter::toKop($value, Settings::getCurrency()),
        );
    }

    // цена сконвертированная из копеек
	protected function priceFormated(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::fromKop($this->price, Settings::getCurrency())
        );
    }
	
	// цена для вывода в шаблоне 
	protected function priceDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::display($this->priceFormated, Settings::getCurrency())
        );
    }		
	
	// категория для вывода в шаблоне 
	protected function categoryDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => static::getCategories()[$this->category_id]
        );
    }
	
	// получить категории
	protected static function getCategories()
    {
		if (static::$categories) return static::$categories;
		static::$categories = [];
		$list = Categories::select('id', 'name')->get();
		foreach($list as $item) {
			static::$categories[$item->id] = $item->name;
		}
		return static::$categories;
	}


}
