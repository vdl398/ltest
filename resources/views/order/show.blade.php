@extends('layouts')

@section('content')
<div><a style="color: blue;" href="/">к списку товаров</a></div>
<div class="alert alert-success" style="font-size: 20px;">
    Заказ №<?=$order->id?> успешно создан
</div>
@endsection