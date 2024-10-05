<?php
defined( 'ABSPATH' ) or exit;

?>
<div class="molongui-metabox">
    <p class="m-description"><?php echo $desc; ?></p>
    <div class="m-field">
        <label for="_molongui_author">
            <?php echo $select; ?>
        </label>
    </div>
    <?php if ( !empty( $add_new ) ) : ?>
        <div class="m-field">
            <a id="molongui-add-guest-link">
                <div class="m-tooltip">
                    <?php echo $add_new; ?>
                    <span class="m-tooltip__text m-tooltip__top"><?php _e( "You can quick-add a new guest author now. Later on you will be able to fully edit all profile info through Guest Authors menu item", 'molongui-authorship' ); ?></span>
                </div>
            </a>
        </div>
        <div id="molongui-add-guest-wrap" style="display:none;">
            <hr>
            <div class="m-title"><?php _e( "Quick Add New Guest", 'molongui-authorship' ); ?></div>
            <p class="m-description"><?php _e( "Now you can quick-add a guest author providing just a display name. You'll be able to add other profile data later on.", 'molongui-authorship' ); ?></p>
            <div class="m-field">
                <input type="text" id="molongui_new_guest_display_name" placeholder="<?php _e( "Type display name here...", 'molongui-authorship' ); ?>" value="">
            </div>
            <div id="molongui-add-guest-buttons" class="m-field">
                <button id="molongui-cancel-btn" class="button"><?php _e( "Cancel", 'molongui-authorship' ); ?></button>
                <button id="molongui-add-btn"    class="button button-primary"><?php _e( "Add", 'molongui-authorship' ); ?></button>
            </div>
            <?php wp_nonce_field( 'molongui_authorship_quick_add_nonce', 'molongui_authorship_quick_add_nonce' ); ?>
        </div>
    <?php endif; ?>
</div>