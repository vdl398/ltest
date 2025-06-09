@extends('layouts')
@vite(['resources/js/product_ext.js'])
@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1>Товары</h1>
    <div style="margin-top: 20px;">
	<table>
	    <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
			<th></th>
        </tr>
        @foreach ($products as $key => $item)
            <tr>
	            <td><a href="/product/<?=$item->id?>"><?=$item->name?></a></td>
		        <td><?=$item->categoryDisplay?></td>
				<td><?=$item->priceDisplay?></td>
				<td><?=$item->basketButton?></td>
	        </tr>
        @endforeach
	</table>
	</div>
	<div style="margin-top: 20px;">{{ $products->links() }}</div>
</div>
@endsection