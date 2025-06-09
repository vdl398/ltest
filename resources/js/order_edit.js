import $ from 'jquery'

$('body').on('click', '.set_status_btn', function() {
	
    $.ajax({
	    url: '/admin/order/setStatus',
	    method: 'post',
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
	    dataType: 'json',
		data: {
			orderId: $(this).attr('order_id'),
			status: $(this).attr('status'),
		},
	    success: function(rs){
			if (rs.data.status != 'success') {
				alert(rs.data.errors.join(", "));
			}
			else {
			    location.href=location.href;
			}
	    },
		error: function (jqXHR, exception) {
			alert('Ошибка');
		},
    });
	
	
});
