

jQuery(function( $ ){
	$( "ul#menu-careers .job-opps" ).addClass( "current-menu-item" );
	$( "ul#mega-menu-primary > li:nth-of-type(3)" ).addClass( "mega-current-menu-item" );
});

jQuery(document).ready(function($) {
  	$('.popup-modal').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#username',
		modal: true
	});
	$(document).on('click', '.popup-modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});
});