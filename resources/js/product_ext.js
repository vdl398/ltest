import $ from 'jquery'

$('body').on('click', '.add_basket', function() {
    $.ajax({
		context: this,
	    url: '/basket/add',
	    method: 'post',
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
	    dataType: 'json',
	    data: {product_id: $(this).attr('item_id'), count: 2},
	    success: function(data){
		    if (data.data?.status == 'success') {
			    location.href = location.href;
		    }
			else {
				alert(data.data?.errors[0]);
			}
	    }
    });
});