<?php
defined( 'ABSPATH' ) or exit;

?>

<div class="molongui-metabox">

    <ul class="m-tip"><li><?php _e( "Only filled in profiles will be displayed on the frontend as icons. If you are missing some networks you would like to configure, enable them on the plugin settings page: Molongui > Authorship Settings > Main tab > Social Networks section.", 'molongui-authorship' ); ?></li></ul>
    <?php if ( !authorship_has_pro() and false !== array_search(true, array_column( $networks, 'premium' ) ) ) : ?>
        <ul class="m-tip m-premium"><li><?php printf( __( "Disabled options are only available in the %sPro version%s of the plugin.", 'molongui-authorship' ), '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'">', '</a>' ); ?></li></ul>
    <?php endif; ?>

    <?php foreach ( $networks as $id => $network ) : ?>

        <?php $network['value'] = get_post_meta( $post->ID, '_molongui_guest_author_'.$id, true ); ?>

        <div class="m-field <?php echo ( ( !authorship_has_pro() and $network['premium'] ) ? 'm-premium' : '' ) ?>">
            <label class="m-title" for="_molongui_guest_author_<?php echo $id; ?>"><i class="m-a-icon-<?php echo $id; ?>"></i><?php echo $network['name']; ?></label>
            <?php if ( !authorship_has_pro() and $network['premium'] ) : ?>
                <div class="input-wrap">
                    <div class="m-tooltip">
                        <input type="text" disabled placeholder="<?php printf( __( "%s Premium feature", 'molongui-authorship' ), '&#128970;' ); ?>" value="" class="text">
                        <span class="m-tooltip__text m-tooltip__top"><?php printf( __( "You need Molongui Authorship Pro to be able to add the %s profile", 'molongui-authorship' ), $network['name'] ); ?></span>
                    </div>
                </div>
            <?php else : ?>
                <div class="input-wrap">
                    <input type="text" placeholder="<?php echo $network['url']; ?>" id="_molongui_guest_author_<?php echo $id; ?>" name="_molongui_guest_author_<?php echo $id; ?>" value="<?php echo ( $network['value'] ? $network['value'] : '' ); ?>" class="text">
                </div>
            <?php endif; ?>
        </div>

    <?php endforeach; ?>

</div>