@extends('layouts')

@section('content')
<div><a style="color: blue;" href="/admin/product">к списку</a></div>
<div style="margin-top: 30px;">
    <h1><?=$product->name?></h1>
    <div style="margin-top: 20px;">Категория: <?=$product->categoryDisplay?></div>
    <div>Цена: <?=$product->priceDisplay?></div>
    <div>Описание: <?=$product->description?></div>
</div>
@endsection