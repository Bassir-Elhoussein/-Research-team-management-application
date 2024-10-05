<?php
defined( 'ABSPATH' ) or exit;
function authorship_notice_display( $id, $type = 'info', $content = array(), $dismissible = false, $dismissal = 0, $class = '', $pages = array() )
{
    if ( authorship_notice_is_dismissed( $id ) ) return;
    if ( !empty( $pages ) )
    {
        global $current_screen;
        if ( !in_array( $current_screen->id, $pages ) ) return;
    }
    wp_enqueue_style( 'molongui-notice-styles' );
    wp_enqueue_script( 'molongui-notice-scripts' );
    molongui_enqueue_sweetalert();
    ?>
    <div id="<?php echo $id; ?>" data-dismissible="<?php echo $dismissal; ?>" data-plugin="<?php echo MOLONGUI_AUTHORSHIP_NAME; ?>" class="notice notice-<?php echo $type; ?> <?php echo $class ?> <?php echo ( $dismissible ? 'is-dismissible' : '' ); ?>">
        <?php if ( !empty( $content['image'] ) ) : ?>
            <div class="molongui-notice-image"><img src="<?php echo $content['image']; ?>" /></div>
        <?php endif; ?>
        <?php if ( !empty( $content['icon'] ) ) : ?>
            <div class="molongui-notice-icon"><i class="molongui-icon-<?php echo $content['icon']; ?>"></i></div>
        <?php endif; ?>
        <div class="molongui-notice-content">
            <?php if ( !empty( $content['title'] ) ) : ?>
                <div class="molongui-notice-title"><h3><?php echo $content['title']; ?></h3></div>
            <?php endif; ?>
            <?php if ( !empty( $content['message'] ) ) : ?>
                <div class="molongui-notice-message"><p><?php echo $content['message']; ?></p></div>
            <?php endif; ?>
            <?php if ( !empty( $content['buttons'] ) ) : ?>
                <div class="molongui-notice-buttons">
                    <?php foreach ( $content['buttons'] as $button ) : ?>
                        <?php if ( isset( $button['hidden'] ) and $button['hidden'] ) continue; ?>
                        <a href="<?php echo $button['href']; ?>" target="<?php echo $button['target']; ?>" class="molongui-notice-button <?php echo $button['class']; ?>"><?php echo ( !empty( $button['icon'] ) ? $button['icon'].' ' : '' ).$button['label']; ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if ( !empty( $content['button'] ) ) : ?>
            <div class="molongui-notice-buttons">
                <a id="<?php echo $content['button']['id']; ?>" href="<?php echo $content['button']['href']; ?>" target="<?php echo $content['button']['target']; ?>" class="molongui-notice-button <?php echo $content['button']['class']; ?>"><?php echo ( !empty( $content['button']['icon'] ) ? $content['button']['icon'].' ' : '' ).$content['button']['label']; ?></a>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
function authorship_notice_is_dismissed( $name )
{
    $notices = get_option( MOLONGUI_AUTHORSHIP_NOTICES );
    if ( !isset( $notices[$name] ) ) return false;
    if ( 'forever' == $notices[$name] ) return true;
    if ( time() >= $notices[$name] )
    {
        unset( $notices[$name] );
        update_option( MOLONGUI_AUTHORSHIP_NOTICES, $notices );
        return false;
    }
    else
    {
        return true;
    }
}