<?php
defined( 'ABSPATH' ) or exit;
global $current_user;
$authors          = array();
$authors[0]       = new \stdClass();
$authors[0]->id   = $current_user->ID;
$authors[0]->type = 'user';
$authors[0]->ref  = 'user'.'-'.$current_user->ID;
$file = 'customizer/css/live-preview.min.css';
if ( file_exists( MOLONGUI_AUTHORSHIP_DIR.$file ) ) wp_enqueue_style( MOLONGUI_AUTHORSHIP_NAME . '-preview', MOLONGUI_AUTHORSHIP_URL.$file, array(), MOLONGUI_AUTHORSHIP_VERSION );
molongui_enqueue_element_queries();
?>

<div class="m-a-box-preview">

	<?php echo authorship_box_markup( null, $authors ); ?>
	<p class="molongui-settings-link-desc">
		<?php _e( "How the author box is displayed in your site's frontend could differ slightly from what is shown here.", 'molongui-authorship' ); ?>
	</p>

</div><!-- !.m-a-box-preview -->