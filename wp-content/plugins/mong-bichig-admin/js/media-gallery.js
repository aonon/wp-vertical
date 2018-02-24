/* global ajaxurl */
jQuery(function($){
	$( 'body' ).bind( 'click.wp-gallery', function(e){
		var target = $( e.target ), id, img_size;

		if ( target.hasClass( 'wp-set-header' ) ) {
			( window.dialogArguments || opener || parent || left ).location.href = target.data( 'location' );
			e.preventDefault();
		} else if ( target.hasClass( 'wp-set-background' ) ) {
			id = target.data( 'attachment-id' );
			img_size = $( 'input[name="attachments[' + id + '][image-size]"]:checked').val();

			jQuery.post(ajaxurl, {
				action: 'set-background-image',
				attachment_id: id,
				size: img_size
			}, function(){
				var win = window.dialogArguments || opener || parent || left;
				win.tb_remove();
				win.location.reload();
			});

			e.preventDefault();
		}
	});
});
