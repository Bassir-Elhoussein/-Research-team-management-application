<?php

namespace Molongui\Authorship\Includes;
\defined( 'ABSPATH' ) or exit;
if ( class_exists( \Molongui\Authorship\Includes\Libraries\Common\WP_List_Table::class ) )
{
    class DynamicParent extends \Molongui\Authorship\Includes\Libraries\Common\WP_List_Table {};
}
else
{
    if ( !class_exists( \WP_List_Table::class ) )
    {
        require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
    }
    class DynamicParent extends \WP_List_Table {};
}
class Authors_List_Table extends DynamicParent
{
    protected function extra_tablenav( $which )
    {
        if ( 'top' === $which )
        {
            $options = authorship_get_options();
            ?><div class="alignleft actions"><?php

                if ( current_user_can( 'list_users' ) )
                {
                    ?><a href="users.php" class="button"><?php _e( "Edit Users", 'molongui-authorship' ); ?></a>&ensp;<?php
                }
                if ( $options['guest_authors'] and current_user_can( 'edit_posts' ) )
                {
                    ?><a href="<?php echo admin_url( 'edit.php?post_type=guest_author' ); ?>" class="button"><?php _e( "Edit Guests", 'molongui-authorship' ); ?></a>&ensp;<?php
                }
            ?></div><?php
            ?><div class="alignleft actions">

            <?php $type = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : 'all'; ?>
            <label class="screen-reader-text" for="filter-by-type"><?php _ex( "Filter authors by type", 'Screen reader hint', 'molongui-authorship' ); ?></label>
            <select name="type" id="filter-by-type">
                <option value="all" <?php selected( $type, 'all' ); ?>><?php _ex( "All types", 'Filter option', 'molongui-authorship' ); ?></option>
                <option value="users" <?php selected( $type, 'users' ); ?>><?php _ex( "Registered WP User", 'Filter option', 'molongui-authorship' ); ?></option>
                <option value="guests" <?php selected( $type, 'guests' ); ?>><?php _ex( "Guest Author", 'Filter option', 'molongui-authorship' ); ?></option>
            </select>

            <?php $role = isset( $_GET['role'] ) ? sanitize_text_field( $_GET['role'] ) : 'all'; ?>
            <label class="screen-reader-text" for="filter-by-role"><?php _ex( "Filter authors by role", 'Screen reader hint', 'molongui-authorship' ); ?></label>
            <select name="role" id="filter-by-role">
                <option value="all" <?php selected( $role, 'all' ); ?>><?php _ex( "All roles", 'Filter option', 'molongui-authorship' ); ?></option>
                <?php wp_dropdown_roles( $role ); ?>
                <option value="guest"><?php _ex( "Guest Author", 'Filter option', 'molongui-authorship' ); ?></option>
            </select>

            <?php submit_button( __( 'Filter' ), '', 'filter_action', false, array( 'id' => 'post-query-submit' ) );

            ?></div><?php
        }
    }
    public function get_columns()
    {
        $table_columns = array
        (
            'avatar'     => _x( "Avatar", 'column name', 'molongui-authorship' ),
            'name'       => _x( "Display Name", 'column name', 'molongui-authorship' ),
            'type'       => _x( "Type", 'column name', 'molongui-authorship' ),
            'user_roles' => _x( "Roles", 'column name', 'molongui-authorship' ),
            'post_count' => _x( "Entries", 'column name', 'molongui-authorship' ),
            'mail'       => _x( "Email", 'column name', 'molongui-authorship' ),
            'bio'        => _x( "Bio", 'column name', 'molongui-authorship' ),
            'social'     => _x( "Social", 'column name', 'molongui-authorship' ),
            'box'        => _x( "Author Box", 'column name', 'molongui-authorship' ),
            'id'         => __( "ID", 'molongui-authorship' ),
        );

        return $table_columns;
    }
    public function get_sortable_columns()
    {
        return array
        (
            'name'       => array( 'name', false ),
            'type'       => array( 'type', false ),
            'user_roles' => array( 'user_roles', false ),
            'post_count' => array( 'post_count', false ),
            'mail'       => array( 'mail', false ),
            'id'         => array( 'id', false ),
        );
    }
    public function prepare_items()
    {
        $columns               = $this->get_columns();
        $sortable              = $this->get_sortable_columns();
        $hidden                = array();
        $primary               = 'name';
        $this->_column_headers = array( $columns, $hidden, $sortable, $primary );

        $orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'name';
        $order   = ( isset( $_GET['order'] ) )   ? esc_sql( $_GET['order'] )   : 'ASC';
        $search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
        $type_filter = isset( $_REQUEST['type'] ) ? wp_unslash( trim( $_REQUEST['type'] ) ) : 'all';
        $role_filter = isset( $_REQUEST['role'] ) ? wp_unslash( trim( $_REQUEST['role'] ) ) : 'all';
        $type = 'authors';
        switch ( $role_filter )
        {
            case 'all':

                switch ( $type_filter )
                {
                    case 'all':
                        $type = 'authors';
                    break;

                    case 'users':
                        $type = 'users';
                    break;

                    case 'guests':
                        $type = 'guests';
                    break;
                }

            break;
            case 'guest':

                switch ( $type_filter )
                {
                    case 'all':
                    case 'guests':
                        $type = 'guests';
                    break;

                    case 'users':
                        $data = array();
                    break;
                }

            break;
            default:

                switch ( $type_filter )
                {
                    case 'all':
                    case 'users':
                        $type = 'users';
                    break;

                    case 'guests':
                        $data = array();
                    break;
                }

            break;
        }

        if ( !isset( $data ) )
        {
            add_filter( 'authorship/get_author_data/fields', array( $this, 'author_fields' ) );
            add_filter( 'authorship/get_avatar/size', array( $this, 'avatar_size' ) );
            add_filter( 'authorship/get_avatar/context', array( $this, 'avatar_context' ) );

            $data = molongui_get_authors( $type, array(), array(), array(), array(), $order, $orderby, true, 0, array( 'post' ) );

            if ( !in_array( $role_filter, array( 'all', 'guests' ) ) )
            {
                $data = $this->filter_table_data( $data, $role_filter, array( 'user_roles' ) );
            }
        }
        if ( $search_key )
        {
            $search_in = array
            (
                'id',
                'name',
                'first_name',
                'last_name',
                'mail',
            );

            $data = $this->filter_table_data( $data, $search_key, $search_in );
        }
        $items_per_page = $this->get_items_per_page( 'authors_per_page' );
        $table_page     = $this->get_pagenum();
        $this->items    = array_slice( $data, ( ( $table_page - 1 ) * $items_per_page ), $items_per_page );
        $total_authors = count( $data );
        $this->set_pagination_args( array
        (
            'total_items' => $total_authors,
            'per_page'    => $items_per_page,
            'total_pages' => ceil( $total_authors / $items_per_page ),
        ));
    }
    public function author_fields( $default )
    {
        return array
        (
            'id',
            'type',
            'name',
            'mail',
            'archive',
            'img',
            'bio',
            'post_count',
            'user_roles',
            'user_login',
            'box',
            'social',
        );
    }
    public function avatar_size( $default )
    {
        return array( 60, 60 );
    }
    public function avatar_context( $default )
    {
        return 'screen';
    }
    private function filter_table_data( $table_data, $search_key, $search_in )
    {
        $filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key, $search_in )
        {
            foreach ( $row as $key => $row_val )
            {
                if ( !in_array( $key, $search_in ) ) continue;
                if ( is_array( $row_val ) ) $row_val = implode( ", ", $row_val );

                if ( stripos( $row_val, $search_key ) !== false )
                {
                    return true;
                }
            }
        } ) );

        return $filtered_table_data;
    }
    public function no_items()
    {
        _e( "No authors available.", 'molongui-authorship' );
    }
    public function column_default( $item, $column_name )
    {
        $result    = '';
        $author_id = absint( $item['id'] );

        switch ( $column_name )
        {
            case 'avatar':
                $result = $item['img'];
            break;

            case 'name':

                switch ( $item['type'] )
                {
                    case 'user':

                        $super_admin = '';

                        if ( is_multisite() and current_user_can( 'manage_network_users' ) )
                        {
                            if ( in_array( $item['user_login'], get_super_admins(), true ) )
                            {
                                $super_admin = ' &mdash; ' . __( 'Super Admin' );
                            }
                        }
                        if ( current_user_can( 'list_users' ) )
                        {
                            if ( current_user_can( 'edit_user', $author_id ) )
                            {
                                $edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_user_link( $author_id ) ) );
                                $result    = "<strong><a href=\"{$edit_link}\">{$item['name']}</a>{$super_admin}</strong><br />";
                            }
                            else
                            {
                                $result = "<strong>{$item['name']}{$super_admin}</strong><br />";
                            }

                        }
                        else
                        {
                            $result = "<strong>{$item['name']}{$super_admin}</strong>";
                        }

                    break;

                    case 'guest':

                        if ( current_user_can( 'edit_others_pages' ) or current_user_can( 'edit_others_posts' ) )
                        {
                            $edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_post_link( $author_id ) ) );
                            $result    = "<strong><a href=\"{$edit_link}\">{$item['name']}</a></strong><br />";
                        }
                        else
                        {
                            $result = "<strong>{$item['name']}</strong>";
                        }

                    break;
                }

            break;

            case 'type':
                $result = ucfirst( $item['type'] );
            break;

            case 'user_roles':
                global $wp_roles;
                $user_roles = array();
                foreach ( $item[$column_name] as $user_role )
                {
                    if ( 'Guest author' === $user_role )
                    {
                        $user_roles[] = 'Guest author';
                    }
                    else
                    {
                        $user_roles[] = translate_user_role( $wp_roles->roles[ $user_role ]['name'] );
                    }
                }
                $result = ucwords( implode( ", ", $user_roles ) );
            break;

            case 'post_count':

                $result =  '';
                foreach ( molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all', true ) as $post_type )
                {
                    $type = 'user' === $item['type'] ? 'author' : 'guest';
                    $link = admin_url( 'edit.php?post_type='.$post_type['id'].'&'.$type.'='.$author_id );
                    if ( isset( $item[$column_name][$post_type['id']] ) and $item[$column_name][$post_type['id']] > 0 ) $result .= '<div><a href="'.$link.'">'.$item[$column_name][$post_type['id']].' '.$post_type['label'].'</a></div>';
                }
                if ( !$result ) $result = __( 'None' );


            break;

            case 'bio':

                if ( !empty( $item[$column_name] ) )
                {
                    $result  = '<div class="m-tooltip">';
                    $result .= '<span class="dashicons dashicons-yes"></span>';
                    $result .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w400">'.esc_html( $item[$column_name] ).'</span>';
                    $result .= '</div>';
                }

            break;

            case 'social':

                foreach ( authorship_get_social_networks( 'enabled' ) as $network => $data )
                {
                    if ( !empty( $item[$network] ) )
                    {
                        $result  = '<div class="m-tooltip">';
                        $result .= '<span class="dashicons dashicons-yes"></span>';
                        $result .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w50">'.__( "Has social profiles defined", 'molongui-authorship' ).'</span>';
                        $result .= '</div>';
                        break;
                    }
                }

            break;

            case 'box':

                switch ( $item['box'] )
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
                        $icon = 'admin-generic';
                        $tip  = __( "Visibility depends on global plugin settings", 'molongui-authorship' );
                    break;
                }

                $result  = '<div class="m-tooltip">';
                $result .= '<span class="dashicons dashicons-'.$icon.'"></span>';
                $result .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w100">'.$tip.'</span>';
                $result .= '</div>';

            break;

            case 'id':
                $result = $item[$column_name] . '<br>' . '<span style="font-family: \'Courier New\', Courier, monospace; font-size: 81%; color: #a2a2a2;" >' . $item['type'] . '</span>';
            break;

            default:
                $result = $item[$column_name];
            break;
        }

        return $result;
    }
    protected function handle_row_actions( $item, $column_name, $primary )
    {
        if ( $primary !== $column_name ) return '';

        $actions   = array();
        $author_id = absint( $item['id'] );

        switch ( $item['type'] )
        {
            case 'user':
                $url = 'users.php?';
                if ( current_user_can( 'list_users' ) )
                {
                    $edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_user_link( $author_id ) ) );

                    if ( current_user_can( 'edit_user', $author_id ) )
                    {
                        $actions['edit'] = '<a href="' . $edit_link . '">' . __( 'Edit' ) . '</a>';
                    }

                    if ( !is_multisite() and get_current_user_id() != $author_id and current_user_can( 'delete_user', $author_id ) )
                    {
                        $actions['delete'] = "<a class='submitdelete' href='" . wp_nonce_url( "users.php?action=delete&amp;user=$author_id", 'bulk-users' ) . "'>" . __( 'Delete' ) . '</a>';
                    }
                    if ( is_multisite() and current_user_can( 'remove_user', $author_id ) )
                    {
                        $actions['remove'] = "<a class='submitdelete' href='" . wp_nonce_url( $url . "action=remove&amp;user=$author_id", 'bulk-users' ) . "'>" . __( 'Remove' ) . '</a>';
                    }
                    $author_posts_url = get_author_posts_url( $author_id );
                    if ( $author_posts_url )
                    {
                        $actions['view'] = sprintf(
                            '<a href="%s" aria-label="%s">%s</a>',
                            esc_url( $author_posts_url ),
                            esc_attr( sprintf( __( 'View posts by %s' ), $item['name'] ) ),
                            __( 'View' )
                        );
                    }

                }

            break;

            case 'guest':
                if ( current_user_can( 'edit_others_pages' ) or current_user_can( 'edit_others_posts' ) )
                {
                    $edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_post_link( $author_id ) ) );
                    $actions['edit'] = '<a href="' . $edit_link . '">' . __( 'Edit' ) . '</a>';
                }

                if ( current_user_can( 'delete_others_pages' ) or current_user_can( 'delete_others_posts' ) )
                {
                    $actions['trash'] = sprintf(
                        '<a href="%s" class="submitdelete" aria-label="%s">%s</a>',
                        get_delete_post_link( $author_id ),
                        esc_attr( sprintf( __( 'Move &#8220;%s&#8221; to the Trash' ), $item['name'] ) ),
                        _x( 'Trash', 'verb' )
                    );
                }

                if ( '#molongui-disabled-link' !== $item['archive'] )
                {
                    $actions['view'] = sprintf(
                        '<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
                        $item['archive'],
                        esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $item['name'] ) ),
                        __( 'View' )
                    );
                }

            break;
        }
        $actions = apply_filters( 'authorship/authors/row_actions', $actions, $item );

        return $this->row_actions( $actions );
    }
}