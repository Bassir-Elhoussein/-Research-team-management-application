<?php
defined( 'ABSPATH' ) or exit;
?>

<div class="molongui-metabox">

    <div class="m-field">
        <label class="m-title"><strong><?php _e( "Convert to User", 'molongui-authorship' ); ?></strong></label>
        <p class="m-description">
            <?php _e( "Convert this guest author to a registered WP user with just 1-click. Current guest will be removed and a new user created. Posts authorship will be kept.", 'molongui-authorship' ); ?>
        </p>
        <a class="button button-large button-disabled"><?php _e( "Convert", 'molongui-authorship' ); ?></a>
        <div class="pro-note">
            <?php printf( __( "This option is only available in the %sPRO version%s of the plugin.", 'molongui-authorship' ), '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'">', '</a>' ); ?>
        </div>
    </div>

</div>