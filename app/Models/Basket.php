<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Model;
use \App\Models\Helpers\PriceConverter;
use \App\Models\Helpers\Settings;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class Basket extends Model
{
    use HasFactory;
	
	protected $table = 'basket';
	
	public $timestamps = false;
	
	protected $fillable = ['order_id', 'product_id', 'count', 'item_price'];
	
	// связная сущность товаров
	public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    // цена за шт. сконвертированная
	protected function itemPriceFormated(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::fromKop($this->item_price, Settings::getCurrency())
        );
    }
	
	// цена за шт. для вывода в шаблоне 
	protected function itemPriceDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::display($this->itemPriceFormated, Settings::getCurrency())
        );
    }
	
	// сумма 1 позиции в корзине
	protected function sum(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->item_price * $this->count
        );
    }

    // сумма 1 позиции сконвертированная
	protected function sumFormated(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::fromKop($this->sum, Settings::getCurrency())
        );
    }
	
	// сумма 1 позиции для вывода в шаблоне 
	protected function sumDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::display($this->sumFormated, Settings::getCurrency())
        );
    }

}
