<?php
defined( 'ABSPATH' ) or exit;

$is_pro   = authorship_has_pro();
$networks = authorship_get_social_networks( 'enabled' );

?>

<div id="molongui-user-fields">

    <h2><?php _e( "Molongui Authorship", 'molongui-authorship' ); ?></h2>

    <!-- Profile Bio -->
    <?php
    ?>
    <script type="text/javascript">
        let aboutTable = document.getElementsByClassName("user-description-wrap")[0].closest('table');
        aboutTable.previousElementSibling.remove();
        aboutTable.remove();
    </script>
    <?php include apply_filters( 'authorship/edit/user/bio/tmpl', 'html-admin-profile-bio.php' ); ?>

    <!-- Profile Picture -->
    <?php include 'html-admin-profile-picture.php'; ?>

    <!-- Professional info -->
    <div id="molongui-pro-info">

        <h3><?php _e( "Professional Info", 'molongui-authorship' ); ?></h3>
        <ul class="m-tip"><li><?php printf( __( "Information below will be displayed on the author box and other relevant sections (i.e. authors list) below the user's name. %sPhone number won't be displayed unless configured%s using the %sdisplay settings%s. Any blank field will not be displayed either.", 'molongui-authorship' ), '<strong>', '</strong>', '<a href="#molongui-box-settings">', '</a>' ); ?></li></ul>

        <table class="form-table" role="presentation">
            <tbody>

                <tr class="user-m-phone-wrap">
                    <th><label for="molongui_author_phone"><?php _e( "Phone", 'molongui-authorship' ); ?></label></th>
                    <td><input type="text" name="molongui_author_phone" id="molongui_author_phone" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_phone', $user->ID ) ); ?>" class="regular-text" /></td>
                </tr>

                <tr class="user-m-job-wrap">
                    <th><label for="molongui_author_job"><?php _e( "Job title", 'molongui-authorship' ); ?></label></th>
                    <td><input type="text" name="molongui_author_job" id="molongui_author_job" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_job', $user->ID ) ); ?>" class="regular-text" /></td>
                </tr>

                <tr class="user-m-company-wrap">
                    <th><label for="molongui_author_company"><?php _e( "Company", 'molongui-authorship' ); ?></label></th>
                    <td><input type="text" name="molongui_author_company" id="molongui_author_company" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_company', $user->ID ) ); ?>" class="regular-text" /></td>
                </tr>

                <tr class="user-m-company-link-wrap">
                    <th><label for="molongui_author_company_link"><?php _e( "Company website", 'molongui-authorship' ); ?></label></th>
                    <td><input type="text" name="molongui_author_company_link" id="molongui_author_company_link" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_company_link', $user->ID ) ); ?>" class="regular-text" placeholder="<?php _e( "https://www.example.com/", 'molongui-authorship' ); ?>" /></td>
                </tr>

            </tbody>
        </table>

    </div>

    <?php if ( !empty( $networks ) ) : ?>

        <!-- Social Profiles -->
        <div id="molongui-social-profiles">
            <h3><?php _e( "Social Profiles", 'molongui-authorship' ); ?></h3>
            <ul class="m-tip"><li><?php printf( __( "The Molongui Authorship plugin allows you to add %smore than %s different social profiles%s, so if you don't see here the ones you want to add, just go to the %splugin settings page%s and enable those you need to edit. %sSocial profiles will be displayed as icons on the author box and other relevant sections. Any blank profile will not be displayed.", 'molongui-authorship' ), '<strong>', '110', '</strong>', '<a href="'.authorship_options_url( 'more' ).'" target="_blank">', '</a>', '<br>' ); ?></li></ul>
            <?php if ( !$is_pro and false !== array_search(true, array_column( $networks, 'premium' ) ) ) : ?>
                <ul class="m-tip m-premium"><li><?php printf( __( "Disabled options are only available in the %sPro version%s of the plugin.", 'molongui-authorship' ), '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'">', '</a>' ); ?></li></ul>
            <?php endif; ?>

            <div id="m-social">

                <?php foreach ( $networks as $id => $network ) : ?>

                    <div class="m-field <?php echo ( ( !$is_pro and $network['premium'] ) ? 'm-premium' : '' ) ?>">
                        <label class="m-title" for="molongui_author_<?php echo $id; ?>"><i class="m-a-icon-<?php echo $id; ?>"></i><?php echo $network['name']; ?></label>
                        <?php if ( !$is_pro and $network['premium'] ) : ?>
                            <div class="input-wrap">
                                <div class="m-tooltip">
                                    <input type="text" disabled placeholder="<?php printf( __( "%s Premium feature", 'molongui-authorship' ), '&#128970;' ); ?>" value="" class="text">
                                    <span class="m-tooltip__text m-tooltip__top"><?php printf( __( "You need Molongui Authorship Pro to be able to add the %s profile", 'molongui-authorship' ), $network['name'] ); ?></span>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="input-wrap"><input type="text" class="text" placeholder="<?php echo $network['url']; ?>" id="molongui_author_<?php echo $id; ?>" name="molongui_author_<?php echo $id; ?>" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_'.$id, $user->ID ) ); ?>"></div>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    <?php endif; ?>

    <?php if ( authorship_is_feature_enabled( 'box' ) ) : ?>

        <!-- Author Box Settings -->
        <div id="molongui-box-settings">

            <h3><?php _e( "Author Box Settings", 'molongui-authorship' ); ?></h3>
            <ul class="m-tip"><li><?php printf( __( "On the %splugin settings page%s you can configure all the display settings that affects how the author box is displayed by default. Nonetheless, below you have some settings that override that global configuration for this user.", 'molongui-authorship' ), '<a href="'.authorship_options_url( 'author-box' ).'" target="_blank">', '</a>' ); ?></li></ul>

            <table class="form-table" role="presentation">
                <tbody>

                    <tr class="user-m-box-display-wrap">
                        <th scope="row"><label for="molongui_author_box_display"><?php _e( "Disable author box", 'molongui-authorship' ); ?></label></th>
                        <td>
                            <?php $user_box_display = get_the_author_meta( 'molongui_author_box_display', $user->ID ); ?>
                            <select name="molongui_author_box_display" id="molongui_author_box_display">
                                <option value="default" <?php selected( $user_box_display, 'default' ); ?>><?php _e( "Default", 'molongui-authorship' ); ?></option>
                                <option value="show"    <?php selected( $user_box_display, 'show' ); disabled( !$is_pro ); ?>><?php _e( "Show", 'molongui-authorship' ); ?></option>
                                <option value="hide"    <?php selected( $user_box_display, 'hide' ); disabled( !$is_pro ); ?>><?php _e( "Hide", 'molongui-authorship' ); ?></option>
                            </select>
                            <?php if( !$is_pro ) : ?>
                                <span class="m-description">
                                    <?php printf( __( " %sUpgrade to Pro%s to be able to control author box display on a per user basis.", 'molongui-authorship' ), '<a href="' . MOLONGUI_AUTHORSHIP_WEB . '" target="_blank">', '</a>' ); ?>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Display email as author meta -->
                    <tr class="user-m-show-meta-mail-wrap">
                        <th scope="row"><label for="molongui_author_show_meta_mail"><?php _e( "Display e-mail", 'molongui-authorship' ); ?></label></th>
                        <td><label for="molongui_author_show_meta_mail"><input type="checkbox" name="molongui_author_show_meta_mail" id="molongui_author_show_meta_mail" value="1" <?php checked( get_the_author_meta( 'molongui_author_show_meta_mail', $user->ID ) ); disabled( $user_box_display, 'hide' ); ?>> <?php _e( "Check this box to display the user's e-mail publicly in the author meta line, which is displayed below the author name.", 'molongui-authorship' ); ?></label></td>
                    </tr>

                    <!-- Display phone as author meta -->
                    <tr class="user-m-show-meta-phone-wrap">
                        <th scope="row"><label for="molongui_author_show_meta_phone"><?php _e( "Display phone", 'molongui-authorship' ); ?></label></th>
                        <td><label for="molongui_author_show_meta_phone"><input type="checkbox" name="molongui_author_show_meta_phone" id="molongui_author_show_meta_phone" value="1" <?php checked( get_the_author_meta( 'molongui_author_show_meta_phone', $user->ID ) ); disabled( $user_box_display, 'hide' ); ?>> <?php _e( "Check this box to display the user's phone publicly in the author meta line, which is displayed below the author name.", 'molongui-authorship' ); ?></label></td>
                    </tr>

                    <!-- Display website as social icon -->
                    <tr class="user-m-show-icon-web-wrap">
                        <th scope="row"><label for="molongui_author_show_icon_web"><?php _e( "Show website icon", 'molongui-authorship' ); ?></label></th>
                        <td><label for="molongui_author_show_icon_web"><input type="checkbox" name="molongui_author_show_icon_web" id="molongui_author_show_icon_web" value="1" <?php checked( get_the_author_meta( 'molongui_author_show_icon_web', $user->ID ) ); disabled( $user_box_display, 'hide' ); ?>> <?php _e( "Check this box to display a website icon with other social icons.", 'molongui-authorship' ); ?></label></td>
                    </tr>

                    <!-- Display email as social icon -->
                    <tr class="user-m-show-icon-mail-wrap">
                        <th scope="row"><label for="molongui_author_show_icon_mail"><?php _e( "Show e-mail icon", 'molongui-authorship' ); ?></label></th>
                        <td><label for="molongui_author_show_icon_mail"><input type="checkbox" name="molongui_author_show_icon_mail" id="molongui_author_show_icon_mail" value="1" <?php checked( get_the_author_meta( 'molongui_author_show_icon_mail', $user->ID ) ); disabled( $user_box_display, 'hide' ); ?>> <?php _e( "Check this box to display an e-mail icon with other social icons.", 'molongui-authorship' ); ?></label></td>
                    </tr>

                    <!-- Display phone as social icon -->
                    <tr class="user-m-show-icon-phone-wrap">
                        <th scope="row"><label for="molongui_author_show_icon_phone"><?php _e( "Show phone icon", 'molongui-authorship' ); ?></label></th>
                        <td><label for="molongui_author_show_icon_phone"><input type="checkbox" name="molongui_author_show_icon_phone" id="molongui_author_show_icon_phone" value="1" <?php checked( get_the_author_meta( 'molongui_author_show_icon_phone', $user->ID ) ); disabled( $user_box_display, 'hide' ); ?>> <?php _e( "Check this box to display a phone icon with other social icons.", 'molongui-authorship' ); ?></label></td>
                    </tr>

                </tbody>
            </table>

            <script>
                document.getElementById('molongui_author_box_display').onchange = function()
                {
                    var $disabled = false;
                    if ( this.value === 'hide' ) $disabled = true;

                    document.getElementById('molongui_author_show_meta_phone').disabled = $disabled;
                    document.getElementById('molongui_author_show_meta_mail').disabled  = $disabled;
                    document.getElementById('molongui_author_show_icon_mail').disabled  = $disabled;
                    document.getElementById('molongui_author_show_icon_web').disabled   = $disabled;
                    document.getElementById('molongui_author_show_icon_phone').disabled = $disabled;
                };
            </script>

        </div>

    <?php endif; ?>

    <?php if ( $user->ID != 0 ) : ?>

        <!-- Author Tools -->
        <?php include apply_filters( 'authorship/edit/user/tools/tmpl', 'html-admin-profile-tools.php' ); ?>

    <?php endif; ?>

    <?php
    do_action( 'authorship/edit/user/fields', $user->ID );
    ?>

</div> <!-- #molongui-user-fields -->