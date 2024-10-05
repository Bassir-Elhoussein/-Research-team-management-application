<?php
defined( 'ABSPATH' ) or exit;
function authorship_reorder_submenu_items()
{
    global $submenu;
    if ( empty( $submenu['molongui'] ) ) return;
    foreach ( $submenu['molongui'] as $key => $value )
    {
        if ( $value[2] === 'molongui'         ) { $plugins_key = $key; $plugins = $value; continue; }
        if ( $value[2] === 'molongui-support' ) { $support_key = $key; $support = $value; continue; }
        if ( $key === 'molongui-docs'         ) { $docs_key    = $key; $docs    = $value; continue; }
        if ( $key === 'molongui-demos'        ) { $demos_key   = $key; $demos   = $value; continue; }
    }
    if ( isset( $plugins_key ) ) unset( $submenu['molongui'][$plugins_key] );
    if ( isset( $support_key ) ) unset( $submenu['molongui'][$support_key] );
    if ( isset( $docs_key    ) ) unset( $submenu['molongui'][$docs_key]    );
    if ( isset( $demos_key   ) ) unset( $submenu['molongui'][$demos_key]   );
    $titles = array();
    foreach ( $submenu['molongui'] as $items )
    {
        $titles[] = $items[0];
    }
    array_multisort( $titles, SORT_ASC, $submenu['molongui'] );
    if ( isset( $plugins ) ) array_unshift( $submenu['molongui'], $plugins );
    if ( isset( $docs    ) ) array_push( $submenu['molongui'], $docs    );
    if ( isset( $support ) ) array_push( $submenu['molongui'], $support );
    if ( isset( $demos   ) ) array_push( $submenu['molongui'], $demos   );
}
function authorship_get_admin_icon()
{
    return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
            <g>
                <path d="M50,0C22.4,0,0,22.4,0,50c0,27.6,22.4,50,50,50s50-22.4,50-50C100,22.4,77.6,0,50,0z M27.8,66.3v0.4
                    c-0.1,1.4-0.6,2.5-1.5,3.4c-1,0.9-2.1,1.4-3.5,1.4c-1.3,0-2.5-0.5-3.4-1.4c-1-0.9-1.5-2.1-1.5-3.4v-35c0.1-1.4,0.6-2.5,1.6-3.4
                    c0.9-0.9,2.1-1.4,3.5-1.4c1.3,0,2.5,0.5,3.4,1.4c0.9,0.9,1.5,2.1,1.6,3.4V66.3z M81.9,66.5c0,1.4-0.5,2.6-1.5,3.5
                    c-1,1-2.2,1.4-3.6,1.4c-1.4,0-2.6-0.5-3.6-1.5c-1-1-1.4-2.2-1.4-3.4v-19c0-1.2-0.1-2.5-0.3-3.8c-0.2-1.3-0.6-2.5-1.1-3.6
                    c-0.6-1.1-1.4-2-2.5-2.7c-1.1-0.7-2.5-1.1-4.4-1.1c-1.8,0-3.3,0.3-4.4,1c-1.1,0.7-2,1.5-2.6,2.6c-0.6,1-1.1,2.2-1.3,3.5
                    c-0.2,1.3-0.4,2.6-0.4,3.8v19c0,1.4-0.5,2.7-1.4,3.7c-0.9,1-2.1,1.6-3.7,1.6c-1.4,0-2.6-0.5-3.5-1.4c-1-1-1.4-2.1-1.4-3.5V47.2
                    c0-1.2-0.1-2.4-0.3-3.7c-0.2-1.3-0.6-2.5-1.2-3.5c-0.6-1-1.4-1.9-2.5-2.6c-1.1-0.7-2.5-1-4.2-1c-1.5,0-2.8,0.3-3.8,0.8
                    c-1,0.5-1.9,1.2-2.6,1.9v-9c1.1-0.8,2.4-1.5,3.9-2.2c1.5-0.6,3.3-1,5.4-1c1.1,0,2.2,0.1,3.4,0.4c1.2,0.3,2.4,0.7,3.6,1.3
                    c1.1,0.6,2.2,1.4,3.2,2.5s1.9,2.4,2.6,4c0.6-1.1,1.4-2.1,2.3-3.1c0.9-1,1.9-1.9,3-2.6c1.1-0.7,2.4-1.3,3.8-1.8
                    c1.4-0.5,3-0.7,4.7-0.7c1.8,0,3.7,0.3,5.7,0.9c2,0.6,3.8,1.7,5.4,3.4c1,1,1.7,2,2.4,3c0.6,1,1.1,2.1,1.4,3.3
                    c0.3,1.2,0.5,2.6,0.7,4.2c0.1,1.6,0.2,3.4,0.2,5.6V66.5z"/>
            </g>
            </svg>';
}
function authorship_render_plugins_page()
{
    $upsells = authorship_get_upsells();

    include MOLONGUI_AUTHORSHIP_DIR . 'views/common/html-page-plugins.php';
}
function authorship_render_support_page()
{
    $tidio_url = authorship_get_tidio();

    include MOLONGUI_AUTHORSHIP_DIR . 'views/common/html-page-support.php';
}
 function authorship_render_settings_page()
{
    if ( file_exists( $file = MOLONGUI_AUTHORSHIP_DIR . 'config/common/options.php' ) ) include $file;
    if ( file_exists( $file = MOLONGUI_AUTHORSHIP_DIR . 'config/options.php' ) ) include $file;
    $opts = array_merge_recursive( isset( $options ) ? $options : array(), isset( $fw_options ) ? $fw_options : array() );
    if ( $opts )
    {
        foreach ( $opts as $key => $value )
        {
            if ( $value['type'] == 'section' )
            {
                if ( isset( $value['display'] ) and !$value['display'] ) continue;
                $tabs[$value['id']] = array
                (
                    'display' => empty( $value['display'] ) ? true : $value['display'],
                    'access'  => empty( $value['access']  ) ? 'public' : $value['access'],
                    'id'      => $value['id'],
                    'name'    => ucfirst( $value['name'] )
                );
                $parent = $value['id'];
            }
            else
            {
                if ( isset( $value['display'] ) and !$value['display'] ) continue;
                if ( !isset( $parent ) ) $parent = 0;
                ${'tab_'.$parent}[$key] = $value;
            }
        }
        if ( isset( $tabs ) )
        {
            $nav_items    = '';
            $div_contents = null;
            $current_tab  = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
            if ( $current_tab == '' )
            {
                reset( $tabs );
                $current_tab = key( $tabs );
                while ( !$tabs[$current_tab]['display'] )
                {
                    next( $tabs );
                    $current_tab = key( $tabs );
                }
            }
            foreach ( $tabs as $tab )
            {
                if ( 'private' !== $tab['access'] )
                {
                    $nav_items .= '<li class="m-section-nav-tab '.( $tab['id'] == $current_tab ? 'is-selected' : '' ).'"><a class="m-section-nav-tab__link" href="#'.$tab['id'].'" data-id="'.$tab['id'].'" role="menuitem"><span class="m-section-nav-tab__text">' . $tab['name'] . '</span></a></li>';
                }
                $div_contents .= '<section id="'.$tab['id'].'" class="m-tab '.( $tab['id'] == $current_tab ? 'current' : '' ).'">';
                if ( isset( ${'tab_'.$tab['id']} ) )
                {
                    $group = '';
                    foreach ( ${'tab_'.$tab['id']} as $option )
                    {
                        if ( 'header' === $option['type'] ) $group = empty( $option['id'] ) ? '' : str_replace( '_header', '', $option['id'] );

                        $html = new \Molongui\Authorship\Includes\Libraries\Common\Option( $option, $group, '', MOLONGUI_AUTHORSHIP_PREFIX.'_' );
                        $div_contents .= $html;
                    }
                }
                else
                {
                    $div_contents .= __( "There are no settings defined for this tab.", 'molongui-authorship' );
                }

                $div_contents .= '</section>';
            }
        }
        else
        {
            $no_tab = true;
            $div_contents = '<div class="m-no-tab">';

            foreach ( ${'tab_0'} as $tab_content )
            {
                $option = new \Molongui\Authorship\Includes\Libraries\Common\Option( $tab_content, '', '', MOLONGUI_AUTHORSHIP_PREFIX );
                $div_contents .= $option;
            }

            $div_contents .= '</div>';
        }

    }
    require_once MOLONGUI_AUTHORSHIP_DIR . 'views/common/html-page-options.php';
}