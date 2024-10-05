<?php
/**
 * Plugin generic functions file
 *
 * @package Blog Designer Pack
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */
function bdp_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'bdp_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Function to unique number value
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_get_unique() {
	static $unique = 0;
	$unique++;
	
	// For VC front end editing
	if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || 
		 ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' && isset($_POST['editor_post_id']) )
		)
	{
		return rand() .'-'. current_time( 'timestamp' );
	}

	return $unique;
}

/**
 * Function to validate that public script should be enqueue at last.
 * Call this function at last.
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */
function bdp_enqueue_script() {

	// Check public script is in queue
	if( wp_script_is( 'bdp-public-script', 'enqueued' ) ) {
		
		// Dequeue Script
		wp_dequeue_script( 'bdp-public-script' );

		// Enqueue Script
		wp_enqueue_script( 'bdp-public-script' );
	}
}

/**
 * Function to get post excerpt
 * Custom function so some theme filter will not affect it.
 * 
 * @since 1.0.3
 */
function bdp_post_excerpt( $post = null ) {

	$post = get_post( $post );
	if ( empty( $post ) ) {
		return '';
	}
 
	if ( post_password_required( $post ) ) {
		return __( 'There is no excerpt because this is a protected post.', 'blog-designer-pack' );
	}

	return apply_filters( 'bdpp_post_excerpt', $post->post_excerpt, $post );
}

/**
 * Function to get post short content either via excerpt or content.
 * 
 * @since 1.0
 */
function bdp_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {

	global $post;

	$word_length = ! empty( $word_length ) ? $word_length : 55;

	// If post id is passed
	if( ! empty( $post_id ) ) {
		if( has_excerpt( $post_id ) ) {
		  $content = bdp_post_excerpt( $post );
		} else {
		  $content = ! empty( $content ) ? $content : get_the_content();
		}
	}
	
	/***** Divi Theme Tweak Starts *****/
	// Get content with Divi shortcodes
	if( function_exists('et_strip_shortcodes') ) {
		$content = et_strip_shortcodes( $content );
	}
	if( function_exists('et_builder_strip_dynamic_content') ) {
		$content = et_builder_strip_dynamic_content( $content );
	}
	/***** Divi Theme Tweak Ends *****/

	if( $content ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}
	return $content;
}

/**
 * Function to get post featured image
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_get_post_featured_image( $post_id = '', $size = 'full' ) {
	
	$size   = !empty($size) ? $size : 'full';
	$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
	$image 	= isset($image[0]) ? $image[0] : '';

	return $image;
}

/**
 * Function to get post external link or permalink
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_get_post_link( $post_id = '' ) {

	$post_link = '';

	if( !empty($post_id) ) {

		if( empty($post_link) ) {
			$post_link = get_permalink( $post_id );	
		}
	}
	return $post_link;
}

/**
 * Pagination function
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */
function bdp_pagination($args = array(), $identifier = '') {

	$big				= 999999999; // need an unlikely integer
	$page_links_temp	= array();
	$multi_page			= ! empty( $args['multi_page'] ) ? 1 : 0;	

	$paging_args = array(
					'base'      => isset( $args['base'] ) ? $args['base'] : str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => isset( $args['format'] ) ? $args['format'] : '?paged=%#%',
					'current'   => max( 1, $args['paged'] ),
					'total'     => $args['total'],
					'prev_next' => true,
					'prev_text' => "&laquo; " . __('Previous', 'blog-designer-pack'),
					'next_text' => __('Next', 'blog-designer-pack') . " &raquo;",
				);

	// If shortcode is placed in single post and pgination type is 'prev-next'
	if( $multi_page ) {
		$paging_args['type']	= 'plain';
		$paging_args['base']	= esc_url_raw( add_query_arg( 'bdpp-page', '%#%', false ) );
		$paging_args['format']	= '?bdpp-page=%#%';
	}

	$page_links = paginate_links( apply_filters( 'bdpp_pagination', $paging_args, $identifier ) );

	return $page_links;
}

/**
 * Function to get 'bdp_recent_post_slider' shortcode designs
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_recent_post_slider_designs() {
	$design_arr = array(
		'design-1'	=> __('Design 1', 'blog-designer-pack'),
		'design-2'	=> __('Design 2', 'blog-designer-pack'),		
	);
	return $design_arr;
}

/**
 * Function to get 'bdp_recent_post_carousel' shortcode designs
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_recent_post_carousel_designs() {
	$design_arr = array(
		'design-1'	=> __('Design 1', 'blog-designer-pack'),
		'design-2'	=> __('Design 2', 'blog-designer-pack'),		
	);
	return $design_arr;
}

/**
 * Function to get 'bdp_post' shortcode design
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_post_designs() {
	$design_arr = array(
		'design-1'	=> __('Design 1', 'blog-designer-pack'),
		'design-2'	=> __('Design 2', 'blog-designer-pack'),		
		);	
	return $design_arr;
}

/**
 * Function to get 'bdp_post_list' shortcode designs
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_recent_post_list_designs() {
	$design_arr = array(
		'design-1'	=> __('Design 1', 'blog-designer-pack'),
		'design-2'	=> __('Design 2', 'blog-designer-pack'),		
	);
	return $design_arr;
}

/**
 * Function to get 'bdp_post_gridbox' shortcode designs
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_recent_post_gridbox_designs() {
	$design_arr = array(
		'design-1'	=> __('Design 1', 'blog-designer-pack'),			
	);
	return $design_arr;
}

/**
 * Function to get `sp_blog_masonry` shortcode designs
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_post_masonry_designs() {
	$design_arr = array(
						'design-1'	=> __('Design 1', 'blog-designer-pack'),
						'design-2'	=> __('Design 2', 'blog-designer-pack'),
						
					);
	return $design_arr;
}

/**
 * Function to get masonry effect
 * 
 * @package Blog Designer Pack
 * @since 1.0.0
 */
function bdp_post_masonry_effects() {
	$effects_arr = array(
						'effect-1'	=> __('Effect 1', 'blog-designer-pack'),
						'effect-2'	=> __('Effect 2', 'blog-designer-pack'),	
					);
	return $effects_arr;
}

/**
 * Get plugin registered shortcodes
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */
function bdp_registered_shortcodes( $type = 'simplified' ) {

	$result		= array();
	$shortcodes = array(
					'general' => array(
									'name'			=> __('General', 'blog-designer-pack'),
									'shortcodes'	=> array(
															'bdp_post'			=> __('Post Grid', 'blog-designer-pack'),
															'bdp_post_slider'	=> __('Post Slider', 'blog-designer-pack'),
															'bdp_post_carousel'	=> __('Post Carousel', 'blog-designer-pack'),
															'bdp_post_gridbox'	=> __('Post GridBox', 'blog-designer-pack'),															
															'bdp_post_list'		=> __('Post List', 'blog-designer-pack'),
															'bdp_masonry'		=> __('Post Masonry', 'blog-designer-pack'),															
															'bdp_ticker'		=> __('Post Ticker', 'blog-designer-pack'),
														)
									),					
					);
	$shortcodes = apply_filters('bdp_registered_shortcodes', (array)$shortcodes );

	// For simplified result
	if( $type == 'simplified' && ! empty( $shortcodes ) ) {
		foreach ($shortcodes as $shrt_key => $shrt_val) {
			if( is_array( $shrt_val ) && ! empty( $shrt_val['shortcodes'] ) ) {
				$result = array_merge( $result, $shrt_val['shortcodes'] );
			} else {
				$result[ $shrt_key ] = $shrt_val;
			}
		}
	} else {
		$result = $shortcodes;
	}
	return $result;
}