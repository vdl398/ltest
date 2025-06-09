import $ from 'jquery'

$('body').on('click', '#save_btn', function() {
	$('#main_form').submit();
});
$('body').on('click', '#delete_btn', function() {
	$('#delete_form').submit();
});