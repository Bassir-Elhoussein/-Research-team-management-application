<?php
defined( 'ABSPATH' ) or exit;
function authorship_fix_mine_count()
{
    $current_screen = get_current_screen();
    if ( !in_array( $current_screen->id, molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ) ) ) return;

    $mine_count = get_user_meta( get_current_user_id(), 'molongui_author_'.$current_screen->post_type.'_count', true );

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) { $('.subsubsub .mine .count').html("(<?php echo $mine_count; ?>)"); });
    </script>
    <?php
}
add_action( 'admin_print_footer_scripts-edit.php', 'authorship_fix_mine_count' );
function authorship_post_edit_list_columns( $columns )
{
    $new_columns = array();
    global $post, $post_type;
    $pt = ( isset( $post->post_type ) ? $post->post_type : '' );
    if ( empty( $post->post_type ) and $post_type == 'page' ) $pt = 'page';
    if ( empty( $pt ) or $pt == 'guest_author' or !in_array( $pt, molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ) ) ) return $columns;
    if ( array_key_exists( 'author', $columns ) ) $position = array_search( 'author', array_keys( $columns ) );      // Default 'Author' column position.
    elseif ( array_key_exists( 'title', $columns ) ) $position = array_search( 'title', array_keys( $columns ) )+1;  // After 'Title' column.
    else $position = count( $columns );                                                                                          // Last column.
    unset( $columns['author'] );
    $i = 0;
    foreach ( $columns as $key => $column )
    {
        if ( $i == $position )
        {
            $new_columns['molongui-author'] = authorship_is_feature_enabled( 'multi' ) ? __( "Authors", 'molongui-authorship' ) : __( "Author" );
            if ( authorship_is_feature_enabled( 'box' ) )
            {
                $new_columns['molongui-box'] = __( "Author Box", 'molongui-authorship' );
            }
        }
        ++$i;
        $new_columns[$key] = $column;
    }
    return $new_columns;
}
add_filter( 'manage_posts_columns', 'authorship_post_edit_list_columns' );
add_filter( 'manage_pages_columns', 'authorship_post_edit_list_columns' );
function authorship_post_fill_list_columns( $column, $ID )
{
    if ( $column == 'molongui-author' )
    {
        $authors = get_post_authors( $ID );
        $options = authorship_get_options();
        if ( !$authors ) return;
        foreach ( $authors as $author )
        {
            $post_type = get_post_type( $ID );

            if ( $author->type == 'guest' )
            {
                $display_name = esc_html( get_the_title( $author->id ) );
                $name_link    = $options['author_name_action'] == 'edit' ? admin_url( "post.php?post=$author->id&action=edit" ) : admin_url( "edit.php?post_type=$post_type&guest=$author->id" );
                $author_tag   = __( 'guest', 'molongui-authorship' );
            }
            else
            {
                $user         = get_userdata( $author->id );
                $display_name = esc_html( $user->display_name );
                $name_link    = $options['author_name_action'] == 'edit' ? admin_url( "user-edit.php?user_id=$author->id" ) : admin_url( "edit.php?post_type=$post_type&author=$author->id" );
                $author_tag   = __( 'user', 'molongui-authorship' );
            }

            ?>
            <p data-author-id="<?php echo $author->id; ?>" data-author-type="<?php echo $author->type; ?>" data-author-display-name="<?php echo $display_name; ?>" class="" style="margin:0 0 2px;">
                <a href="<?php echo $name_link; ?>">
                    <?php echo $display_name; ?>
                </a>
                <?php if ( authorship_is_feature_enabled( 'guest' ) ) : ?>
                    <span style="font-family: 'Courier New', Courier, monospace; font-size: 81%; color: #a2a2a2;" >
                        [<?php echo $author_tag; ?>]
                    </span>
                <?php endif; ?>
            </p>
            <?php
        }

        return;
    }
    elseif ( $column == 'molongui-box' )
    {
        switch ( get_post_meta( $ID, '_molongui_author_box_display', true ) )
        {
            case 'show':
                $icon = 'visibility';
                $tip  = __( "Visible", 'molongui-authorship' );
            break;

            case 'hide':
                $icon = 'hidden';
                $tip  = __( "Hidden", 'molongui-authorship' );
            break;

            default:

                global $post, $post_type;
                if ( !empty( $post->post_type ) )
                {
                    $current_post_type = $post->post_type;
                }
                else
                {
                    $current_post_type = ( 'page' === $post_type ? 'page' : '' );
                }

                if ( !empty( $current_post_type ) )
                {
                    if ( in_array( $current_post_type, authorship_box_post_types( 'auto' ) ) )
                    {
                        $icon = 'visibility';
                        $tip  = __( "Visible", 'molongui-authorship' );
                    }
                    elseif ( in_array( $current_post_type, authorship_box_post_types( 'manual' ) ) )
                           {
                           $icon = 'hidden';
                        $tip  = __( "Hidden because no post configuration provided", 'molongui-authorship' );
                    }
                    else
                    {
                        $icon = 'hidden';
                        $tip  = __( "Hidden", 'molongui-authorship' );
                    }
                }
                else
                {
                    $icon = 'minus';
                    $tip  = __( "Cannot determine visibility for this post type", 'molongui-authorship' );
                }

            break;
        }

        $html  = '<div class="m-tooltip">';
        $html .= '<span class="dashicons dashicons-'.$icon.'"></span>';
        $html .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w100">'.$tip.'</span>';
        $html .= '</div>';

        echo $html;
        return;
    }
}
add_action( 'manage_posts_custom_column', 'authorship_post_fill_list_columns', 10, 2 );
add_action( 'manage_pages_custom_column', 'authorship_post_fill_list_columns', 10, 2 );