@extends('layouts')
@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1>Заказы</h1>
    <div style="margin-top: 20px;">
	<table>
	    <tr>
            <th>Заказ №</th>
			<th>Дата создания</th>
            <th>ФИО</th>
            <th>Статус</th>
			<th>Итоговая цена</th>
			<th></th>
        </tr>
        @foreach ($orders as $key => $item)
            <tr>
	            <td><a href="/admin/order/<?=$item->id?>"><?=$item->id?></a></td>
				<td><?=$item->createdAtDisplay?></td>
		        <td><?=$item->fio?></td>
				<td><?=$item->statusDisplay?></td>
				<td><?=$item->sumDisplay?></td>
				<td><a href="/admin/order/<?=$item->id?>">Открыть</a></td>
	        </tr>
        @endforeach
	</table>
	</div>
	<div style="margin-top: 20px;">{{ $orders->links() }}</div>
</div>
@endsection