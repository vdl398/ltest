@extends('layouts')
@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1>Товары</h1>
    <div style="margin-top: 20px;">
	<a style="margin-top: 20px;" href="/admin/product/0/edit">Добавить товар</a>
	<table style="margin-top: 20px;">
	    <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
			<th></th>
        </tr>
        @foreach ($products as $key => $item)
            <tr>
	            <td style="color: blue;"><a href="/admin/product/<?=$item->id?>"><?=$item->name?></a></td>
		        <td><?=$item->categoryDisplay?></td>
				<td><?=$item->priceDisplay?></td>
				<td style="color: blue;"><a href="/admin/product/<?=$item->id?>/edit">Редактировать</a></td>
	        </tr>
        @endforeach
	</table>
	</div>
	<div style="margin-top: 20px;">{{ $products->links() }}</div>
</div>
@endsection