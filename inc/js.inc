<script>
document.addEventListener( 'DOMContentLoaded', function(){
	
	jQuery.getJSON( 'https://api.ipify.org?format=jsonp&callback=?', function( data ) {
		jQuery( '#ip-validator' ).val( data.ip );
	} );
	
} )
</script>