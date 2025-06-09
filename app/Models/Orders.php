<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;
use \App\Models\Helpers\Result;
use \App\Models\Helpers\PriceConverter;
use \App\Models\Helpers\Settings;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class Orders extends Model
{
    use HasFactory;
	
	public $timestamps = false;

	protected $fillable = ['created_at', 'user_id', 'fio', 'status', 'comment', 'sum'];

    // параметры для валидации
	public static function getValidateParams() {
		return [
            'fio' => ['required', 'string', 'max:200'],
			'comment' => ['required', 'string', 'max:500'],
			'sum' => ['integer'],
        ];
	}
	
	// варианты статусов
	public static function getStatuses() {
		return [
            'N' => 'Новый',
			'F' => 'Выполнен',
        ];
	}
	
	// дата для вывода в шаблоне
    protected function createdAtDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => \Carbon\Carbon::parse($this->created_at)->format('d.m.Y')
        );
    }
	
	// сумма сконвертированная
    protected function sumFormated(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::fromKop($this->sum, Settings::getCurrency())
        );
    }
	
	//  сумма для вывода в шаблоне 
    protected function sumDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => PriceConverter::display($this->sumFormated, Settings::getCurrency())
        );
    }
	
	// статус для вывода в шаблоне
    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => self::getStatuses()[$this->status]
        );
    }
	
}
