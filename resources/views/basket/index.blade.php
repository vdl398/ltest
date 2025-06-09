@extends('layouts')
@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1>Корзина</h1>
	@if ($positionExist)
	    <div id="app"></div>
	    @vite(['resources/js/basket.js'])
	@else
		<div>Корзина пуста</div>
	@endif
</div>
@endsection