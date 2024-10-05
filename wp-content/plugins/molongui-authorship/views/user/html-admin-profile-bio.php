<?php
defined( 'ABSPATH' ) or exit;

?>

<div id="molongui-bio-info">

    <h3><?php _e( 'Biographical Info' ); ?></h3>
    <table class="form-table" role="presentation">
        <tbody>

        <tr class="m-user-description-wrap">
            <th><label for="description"><?php _e( 'Full Bio', 'molongui-authorship' ); ?></label></th>
            <td>
                <textarea name="description" id="description" rows="7" cols="30"><?php echo $user->description; // textarea_escaped ?></textarea>
                <p class="description"><?php _e( "Biographical information to be shown publicly on several places on your site.", 'molongui-authorship' ); ?></p>
            </td>
        </tr>

        <?php if ( authorship_is_feature_enabled( 'box' ) ) : ?>
            <tr class="m-user-description-wrap">
                <th><label for="molongui_author_short_bio"><?php _e( 'Short Bio', 'molongui-authorship' ); ?></label></th>
                <td>
                    <textarea name="molongui_author_short_bio" id="molongui_author_short_bio" rows="3" cols="30" <?php echo ( authorship_has_pro() ? '' : 'disabled="disabled"' ); ?>><?php echo esc_attr( get_the_author_meta( 'molongui_author_short_bio', $user->ID ) ); ?></textarea>
                    <p class="description"><?php _e( "Concise biographical paragraph you can display on author boxes instead of full bio to keep them slim.", 'molongui-authorship' ); ?></p>
                    <div class="pro-note"><span><?php _e( "PRO only", 'molongui-authorship' ); ?></span><?php printf( __( '%sUpgrade%s to Premium to unlock this feature.', 'molongui-authorship' ), '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'">', '</a>' ); ?></div>
                </td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

</div>