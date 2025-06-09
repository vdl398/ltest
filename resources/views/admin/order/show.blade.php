@extends('layouts')
@vite(['resources/js/order_edit.js'])
@section('content')
<div>
    <div style="display: flex; justify-content: space-between; with: 70%; margin-top: 50px;">
	    <a style="color: blue;" href="/admin/order">к списку</a>
	    <form method="POST" action="{{ url('/admin/order/'.$order->id) }}">
            @csrf
            @method('DELETE')
		    <input type="submit" class="btn btn-primary" style="background: red;" value="Удалить заказ" />
	    </form>	
	</div>
    <div style="margin-top: 30px;">
        <h1>Заказ №<?=$order->id?></h1>
		<div>Дата создания: <?=$order->createdAtDisplay?></div>
	    <div>ФИО: <?=$order->fio?></div>
        <div style="display: flex; align-items: center;">
		    <div style="margin-right: 20px;">Статус: <?=$order->statusDisplay?></div>
			<button class="set_status_btn btn btn-primary" order_id="<?=$order->id?>" status="<?=($order->status != 'F')? 'F' : 'N';?>">
			    Изменить на <?=($order->status != 'F')? 'выполнен' : 'новый';?>
			</button>
		</div>
		<div>Сумма: <?=$order->sumDisplay?></div>
        <div>Описание: <?=$order->comment?></div>
    </div>
	<table style="margin-top: 40px;">
	    <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена за шт.</th>
			<th>Количество</th>
			<th>Сумма</th>
        </tr>
		<?php
		    foreach($basket as $item):
		?>
        <tr>
	            <td style="color: blue;"><a href="'/product/'<?=$item->product_id?>"><?=$item->product->name?></a></td>
		        <td><?=$item->product->categoryDisplay?></td>
				<td><?=$item->product->priceDisplay?></td>
				<td><div><?=$item->count?></div></td>
				<td><?=$item->sumDisplay?></td>
	    </tr>
		<?php
		   endforeach;
		?>
	</table>
</div>
@endsection