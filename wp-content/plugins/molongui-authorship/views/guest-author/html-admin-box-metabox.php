<?php
defined( 'ABSPATH' ) or exit;
?>

<div class="molongui-metabox">

    <!-- Display Settings -->
    <div class="m-field">
        <label class="m-title" for="_molongui_guest_author_box_display"><strong><?php _e( "Display", 'molongui-authorship' ); ?></strong></label>
        <p class="m-description">
            <?php _e( "Choose whether to display the author box for this author regardless of other post or plugin settings", 'molongui-authorship' ); ?>
            <?php if ( !authorship_has_pro() ) echo ' <i>'.sprintf( __( "Disabled options are only available with the %sPro version%s of the plugin.", 'molongui-authorship' ), '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'">', '</a>' ).'</i>'; ?>
        </p>
        <?php ob_start(); ?>
        <select name="_molongui_guest_author_box_display" id="_molongui_guest_author_box_display">
            <option value="default" <?php selected( $guest_author_hide_box, 'default' ); ?>><?php _e( "Default", 'molongui-authorship' ); ?></option>
            <option value="show"    <?php selected( $guest_author_hide_box, 'show' ); disabled( !authorship_has_pro() ); ?>><?php _e( "Show", 'molongui-authorship' ); ?></option>
            <option value="hide"    <?php selected( $guest_author_hide_box, 'hide' ); disabled( !authorship_has_pro() ); ?>><?php _e( "Hide", 'molongui-authorship' ); ?></option>
        </select>
        <?php
        $select = ob_get_clean();
        echo apply_filters( '_authorship/guest/box_display', $select );
        ?>
    </div>

    <hr>

    <!-- Meta Line Settings -->
    <label class="m-title" for=""><strong><?php _e( "Meta Line", 'molongui-authorship' ); ?></strong></label>

    <!-- Display email as author meta -->
    <div class="m-field">
        <div class="input-wrap">
            <input type="checkbox" id="_molongui_guest_author_show_meta_mail" name="_molongui_guest_author_show_meta_mail" value="1" <?php checked( $guest_author_mail_meta, 1 ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
            <label class="checkbox-label" for="_molongui_guest_author_show_meta_mail"><?php _e( "Display e-mail in the author meta line, which is displayed below author name.", 'molongui-authorship' ); ?></label>
        </div>
    </div>

    <!-- Display phone as author meta -->
    <div class="m-field">
        <div class="input-wrap">
            <input type="checkbox" id="_molongui_guest_author_show_meta_phone" name="_molongui_guest_author_show_meta_phone" value="1" <?php checked( $guest_author_phone_meta, 1 ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
            <label class="checkbox-label" for="_molongui_guest_author_show_meta_phone"><?php _e( "Display phone in the author meta line, which is displayed below author name.", 'molongui-authorship' ); ?></label>
        </div>
    </div>

    <hr>

    <!-- Social Icons Settings -->
    <label class="m-title" for=""><strong><?php _e( "Social Icons", 'molongui-authorship' ); ?></strong></label>

    <!-- Display website as social icon -->
    <div class="m-field">
        <div class="input-wrap">
            <input type="checkbox" id="_molongui_guest_author_show_icon_web" name="_molongui_guest_author_show_icon_web" value="1" <?php checked( $guest_author_web_icon, 1 ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
            <label class="checkbox-label" for="_molongui_guest_author_show_icon_web"><?php _e( "Display website as an icon with social icons.", 'molongui-authorship' ); ?></label>
        </div>
    </div>

    <!-- Display email as social icon -->
    <div class="m-field">
        <div class="input-wrap">
            <input type="checkbox" id="_molongui_guest_author_show_icon_mail" name="_molongui_guest_author_show_icon_mail" value="1" <?php checked( $guest_author_mail_icon, 1 ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
            <label class="checkbox-label" for="_molongui_guest_author_show_icon_mail"><?php _e( "Display e-mail as an icon with social icons.", 'molongui-authorship' ); ?></label>
        </div>
    </div>

    <!-- Display phone as social icon -->
    <div class="m-field">
        <div class="input-wrap">
            <input type="checkbox" id="_molongui_guest_author_show_icon_phone" name="_molongui_guest_author_show_icon_phone" value="1" <?php checked( $guest_author_phone_icon, 1 ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
            <label class="checkbox-label" for="_molongui_guest_author_show_icon_phone"><?php _e( "Display phone as an icon with social icons.", 'molongui-authorship' ); ?></label>
        </div>
    </div>

    <script>
        document.getElementById('_molongui_guest_author_box_display').onchange = function()
        {
            var $disabled = false;
            if ( this.value === 'hide' ) $disabled = true;

            document.getElementById('_molongui_guest_author_show_meta_phone').disabled = $disabled;
            document.getElementById('_molongui_guest_author_show_meta_mail').disabled  = $disabled;
            document.getElementById('_molongui_guest_author_show_icon_mail').disabled  = $disabled;
            document.getElementById('_molongui_guest_author_show_icon_web').disabled   = $disabled;
            document.getElementById('_molongui_guest_author_show_icon_phone').disabled = $disabled;
        };
    </script>
</div>