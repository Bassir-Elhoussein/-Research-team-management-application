<?php
defined( 'ABSPATH' ) or exit;

?>

<div class="molongui-page-plugins">

    <?php
        $args = array
        (
            'logo'   => false,
            'link'   => 'https://www.molongui.com/',
            'button' => null,
        );
        include 'parts/html-part-masthead.php';

    ?>

    <!-- Page Content -->
    <div class="m-page-content">

        <h2 class="m-section-title"><?php _e( "More awesome plugins from Molongui.", 'molongui-authorship' ); ?></h2>

        <!-- Upsells -->
        <?php
        if ( empty( $upsells ) )
        {
            ?>
            <p><?php _e( 'Visit our site to find more plugins and themes we have created to improve your site.', 'molongui-authorship' ); ?></p>
            <a href="<?php echo 'https://www.molongui.com/'; ?>" class="button button-primary" title="Visit Molongui website" target="_blank"><?php _e( 'Visit our site', 'molongui-authorship' ); ?></a>
            <?php
        }
        else
        {
            foreach( $upsells as $upsell_id => $upsell ) : ?>

                <!-- Header -->
                <div class="m-card m-card-header">
                    <div class="m-card-header__label">
                        <span class="m-card-header__label-text"><?php echo $upsell['name']; ?></span>
                    </div>
                    <div class="m-card-header__actions">
                        <a href="<?php echo $upsell['link']; ?>" target="_blank" type="button" class="m-button is-compact <?php echo $upsell['pro'] ? 'is-primary' : '' ?>"><?php _e( 'Learn More', 'molongui-authorship' ); ?></a>
                    </div>
                </div>

                <!-- Description -->
                <div class="m-card">
                    <div class="m-image">
                        <img src="<?php echo $upsell['img']; ?>"/>
                    </div>
                    <div class="m-title">
                        <?php echo $upsell['name']; ?>
                    </div>
                    <div class="m-desc">
                        <p><?php echo $upsell['desc']; ?></p>

                        <!-- Features -->
                        <?php if ( !empty( $upsell['features'] ) ) : ?>
                            <ul class="m-list">
                                <?php foreach( $upsell['features'] as $feature ) : ?>
                                    <li><span class="dashicons dashicons-star-filled"></span> <?php echo $feature; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Install -->
                <?php if ( !$upsell['pro'] and current_user_can( 'install_plugins' ) ) : ?>
                    <div class="m-card m-card-header is-compact">
                        <div class="m-card-header__label">
                            <span class="m-card-header__label-text"><?php _e( "Install now the plugin for free!", 'molongui-authorship' ); ?></span>
                        </div>
                        <div class="m-card-header__actions">
                            <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='.$upsell['id'] ), 'install-plugin_'.$upsell['id'] ); ?>" type="button" class="m-button is-compact is-primary"><?php _e( "Install Now", 'molongui-authorship' ); ?></a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Live Demo -->
                <?php if ( !empty( $upsell['demo'] ) ) : ?>
                    <a class="m-card is-card-link is-compact" href="<?php echo $upsell['demo']; ?>" target="_blank" title="<?php _e( "Click to test drive this plugin", 'molongui-authorship' ); ?>">
                        <svg class="gridicon gridicons-external m-card__link-indicator" height="24" width="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M19 13v6c0 1.105-.895 2-2 2H5c-1.105 0-2-.895-2-2V7c0-1.105.895-2 2-2h6v2H5v12h12v-6h2zM13 3v2h4.586l-7.793 7.793 1.414 1.414L19 6.414V11h2V3h-8z"></path></g></svg>
                        <?php _e( "Try Live Demo", 'molongui-authorship' ); ?>
                    </a>
                <?php endif; ?>

            <?php endforeach;
        }
        ?>

    </div><!-- !m-page-content -->

    <?php
        $args = array
        (
            'links' => array
            (
                array
                (
                    'label'   => __( "Website", 'molongui-authorship' ),
                    'prefix'  => '',
                    'suffix'  => '',
                    'href'    => 'https://www.molongui.com/',
                    'display' => true,
                ),
                array
                (
                    'label'   => __( "Docs", 'molongui-authorship' ),
                    'prefix'  => '',
                    'suffix'  => '',
                    'href'    => 'https://www.molongui.com/docs/',
                    'display' => true,
                ),
                array
                (
                    'label'   => __( "Demos", 'molongui-authorship' ),
                    'prefix'  => '',
                    'suffix'  => '',
                    'href'    => 'https://demos.molongui.com/',
                    'display' => true,
                ),
                array
                (
                    'label'   => __( "Support", 'molongui-authorship' ),
                    'prefix'  => '',
                    'suffix'  => '',
                    'href'    => 'https://www.molongui.com/support/',
                    'display' => true,
                ),
            ),
        );
        include 'parts/html-part-footer.php';
    ?>

</div><!-- !molongui-page-plugins -->