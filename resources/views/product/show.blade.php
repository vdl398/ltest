@extends('layouts')
@vite(['resources/js/product_ext.js'])
@section('content')
<div><a href="/">к списку</a></div>
<div style="margin-top: 30px;">
    <h1><?=$product->name?></h1>
    <div style="margin-top: 20px;">Категория: <?=$product->categoryDisplay?></div>
    <div>Цена: <?=$product->priceDisplay?></div>
    <div>Описание: <?=$product->description?></div>
	<div style="margin-top: 40px;"><?=$product->basketButton?></div>
</div>
@endsection