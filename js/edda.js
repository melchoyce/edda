jQuery( document ).ready( function( $ ) {

	$( '.menu-toggle button' ).off( 'click' );

	$( '.menu-toggle button' ).on( 'click', function() {
		$( this ).parents( '.menu' ).children( '.wrap' ).slideToggle( 'fast' ).toggleClass( 'open' );
		$( this ).toggleClass( 'active' );
	});

	console.log("I load!");

});