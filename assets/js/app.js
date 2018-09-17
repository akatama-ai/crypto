$('.search-button').click(function() {
	$(this).parent().toggleClass('open');
	$('.search-box').focus();
});


$('.dropdown-menu').on('click', function(e) {
	if($(this).hasClass('dropdown-menu-form')) {
		e.stopPropagation();
	}
});

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});