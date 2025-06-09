@if($product)
	@if($inBasket)
        <a href="/basket">Перейти в корзину</a>
    @else
	    <a class="add_basket" item_id="<?=$product->id?>" href="javascript:void(0)">В корзину</a>
	@endif
@endif