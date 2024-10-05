(function ( $ ) {
	
	/**
	 * WP Bakery Shortcode Events
	 */
	window.vc.events.on( 'shortcodeView:ready', function ( model ) {
		bdp_vc_init_shortcodes( model );
	});

	/* Initialize Plugin Shortcode */
	function bdp_vc_init_shortcodes( model ) {

		var modelId, settings;
		modelId		= model.get( 'id' );
		settings	= vc.map[ model.get( 'shortcode' ) ] || false;

		if( settings.base == 'vc_raw_html'
			|| settings.base == 'vc_column_text'
			|| settings.base == 'vc_wp_text'
			|| settings.base == 'vc_message'
			|| settings.base == 'vc_toggle'
			|| settings.base == 'vc_cta'
		) {

			window.vc.frame_window.bdp_init_post_slider();
			window.vc.frame_window.bdp_init_post_carousel();
			window.vc.frame_window.bdp_init_post_hticker();
			window.vc.frame_window.bdp_init_post_masonry();
			window.vc.frame_window.bdp_init_post_vticker();
		}
	}

})( window.jQuery );