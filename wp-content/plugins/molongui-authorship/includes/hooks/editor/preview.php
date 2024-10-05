<?php
defined( 'ABSPATH' ) or exit;
function authorship_box_preview_style_element()
{
    ?>
    <div id="m-editor-live-preview__changes"></div>
    <?php
}
add_action( 'admin_print_footer_scripts', 'authorship_box_preview_style_element', PHP_INT_MAX );
function authorship_box_preview_action()
{
    check_ajax_referer( 'authorship_box_editor_nonce', 'nonce', true );
    $pick    = sanitize_text_field( $_POST['author'] );
    $options = $_POST['options'];
    if ( empty( $pick ) ) wp_die();
    $author       = new stdClass();
    $author->ref  = $pick;
    $pick         = explode( '-', $pick );
    $author->id   = $pick[1];
    $author->type = $pick[0];
    $saved   = authorship_get_options();
    $options = array_merge( $saved, $options );
    add_filter( '_authorship/get_options', function() use ( $options ) { return $options; } );
    $markup = authorship_box_markup( null, array( $author ), $options, false );
    echo $markup;
    wp_die();
}
add_action( 'wp_ajax_authorship_box_preview_action', 'authorship_box_preview_action' );
function authorship_box_preview_profile_layout( $output, $options, $author, $random_id )
{
    $add_microdata = false;

    ob_start();
    switch ( substr( $options['author_box_profile_layout'], 7 ) )
    {
        case '1':
        case '2':
        case '3':
        case '4':
        case '5':
        case '6':

            include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/profile/html-layout-1.php';

        break;

        case '7':
        case '8': ?>

            <div class="m-a-box-content-top"></div><!-- End of .m-a-box-content-top -->

            <div class="m-a-box-content-middle">
                <!-- Author picture -->
                <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-avatar.php'; ?>

                <!-- Author data -->
                <div class="m-a-box-item m-a-box-data">

                    <!-- Author name -->
                    <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-name.php'; ?>

                    <!-- Author metadata -->
                    <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-meta.php'; ?>

                    <!-- Author bio -->
                    <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-bio.php'; ?>

                    <?php if ( $options['author_box_layout'] == 'slim' and !empty( $options['author_box_related_show'] ) ) : ?>

                        <!-- Author related posts -->
                        <div class="m-a-box-related" data-related-layout="<?php echo $options['author_box_related_layout']; ?>">
                            <div class="m-a-box-item m-a-box-related-entries" <?php echo ( $options['author_box_layout'] == 'slim' ? 'style="display: none;"' : '' ); ?>>
                                <ul>
                                    <?php
                                    if ( !empty( $author['posts'] ) )
                                    {
                                        if ( file_exists( $file = MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/related/html-'.$options['author_box_related_layout'].'.php' ) )
                                        {
                                            ob_start();
                                            include $file;
                                            $related_layout = ob_get_clean();
                                        }
                                        else
                                        {
                                            $related_layout = '';
                                        }
                                        echo apply_filters( 'authorship/author_box/related_layout', $related_layout, $options, $author );
                                    }
                                    else
                                    {
                                        echo ' <span class="m-a-box-string-no-related-posts">'. ( $options['author_box_related_none'] ? $options['author_box_related_none'] : __( "This author does not have any more posts.", 'molongui-authorship' ) ).'</span>';
                                    }
                                    ?>
                                </ul>
                            </div><!-- End of .m-a-box-related-entries -->
                        </div><!-- End of .m-a-box-related -->
                    <?php endif; ?>
                </div><!-- End of .m-a-box-data -->
            </div><!-- End of .m-a-box-content-middle -->

            <div class="m-a-box-content-bottom">
                <!-- Author social -->
                <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-socialmedia.php'; ?>
            </div><!-- End of .m-a-box-content-bottom -->

        <?php break;
    }
    $output = ob_get_clean();

    return $output;
}
add_filter( 'authorship/author_box/profile_layout', 'authorship_box_preview_profile_layout', 10, 4 );
function authorship_box_preview_related_layout( $output, $options, $author )
{
    $add_microdata = false;

    ob_start();
    switch ( substr( $options['author_box_related_layout'], 7 ) )
    {
        case '1':
        case '2':

            include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/related/html-'.$options['author_box_related_layout'].'.php';

        break;

        case '3':

            foreach( $author['posts'] as $related )
            {
                ?>
                <li>
                    <div class="m-a-box-related-entry" itemscope itemtype="http://schema.org/CreativeWork">

                        <div class="molongui-display-none" itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <div itemprop="name"><?php echo $author['name']; ?></div>
                            <div itemprop="url"><?php echo esc_url( $author['archive'] ); ?></div>
                        </div>

                        <!-- Related entry thumb -->
                        <div class="m-a-box-related-entry-thumb">
                            <?php if ( has_post_thumbnail( $related->ID ) ) : ?>
                                <a href="<?php echo get_permalink( $related->ID ); ?>">
                                    <?php echo get_the_post_thumbnail( $related->ID, 'thumbnail', $attr = array( 'itemprop' => 'thumbnailUrl' ) ) ?>
                                </a>
                            <?php else : ?>
                                <img src="<?php echo MOLONGUI_AUTHORSHIP_URL.'assets/img/related_placeholder.svg'; ?>" width="<?php echo get_option( 'thumbnail_size_w' ).'px'; ?>">
                            <?php endif; ?>
                        </div>

                        <!-- Related entry date -->
                        <div class="m-a-box-related-entry-date" itemprop="datePublished">
                            <?php echo get_the_date( '', $related->ID ); ?>
                        </div>

                        <!-- Related entry title -->
                        <div class="m-a-box-related-entry-title">
                            <a class="molongui-remove-underline" itemprop="url" href="<?php echo get_permalink( $related->ID ); ?>">
                                <span itemprop="headline"><?php echo $related->post_title; ?></span>
                            </a>
                        </div>

                    </div>
                </li>
                <?php
            }

        break;
    }
    $output = ob_get_clean();

    return $output;
}
add_filter( 'authorship/author_box/related_layout', 'authorship_box_preview_related_layout', 10, 3 );