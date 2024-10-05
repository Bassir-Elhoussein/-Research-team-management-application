<?php
defined( 'ABSPATH' ) or exit;
?>

<div class="molongui-metabox">

    <div class="m-field">
        <p class="m-description">
            <?php _e( 'Provide a short description that can be displayed on the author box instead of the full author biography. On author archive pages full bio is displayed, if your theme supports it.', 'molongui-authorship' ); ?>
        </p>
        <?php wp_editor( '', '_premium_short_bio_field', array( 'tinymce' => array( 'readonly' => true ), 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, /*'editor_height' => 100,*/ 'textarea_rows' => 5 ) ); ?>
        <div class="pro-note">
            <?php printf( __( 'This option is only available in the %sPRO version%s of the plugin.', 'molongui-authorship' ), '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'">', '</a>' ); ?>
        </div>
    </div>

</div>