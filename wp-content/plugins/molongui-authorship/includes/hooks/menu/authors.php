<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_authors_menu()
{
    $options = authorship_get_options();
    if ( !$options['authors_menu'] ) return;

    add_menu_page
    (
        _x( "Authors", "Page title", 'molongui-authorship' ),
        _x( "Authors", "Menu title", 'molongui-authorship' ),
        'edit_others_posts',
        'authors',
        'authorship_render_authors_screen',
        'dashicons-ellipsis', //molongui_get_base64_svg( authorship_authors_menu_icon() ),
        5
    );
}
add_action( 'admin_menu', 'authorship_add_authors_menu' );
function authorship_authors_menu_icon()
{
    return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024"
                 style="width: 1em; height: 1em; vertical-align: middle; fill: black; overflow: hidden;">
                <path d="M273.664 682.666667L706.389333 249.941333l-60.330666-60.330666L213.333333 622.336V682.666667h60.330667z m35.370667 85.333333H128v-181.034667L615.893333 99.072a42.666667 42.666667 0 0 1 60.330667 0l120.704 120.704a42.666667 42.666667 0 0 1 0 60.330667L309.034667 768zM128 853.333333h768v85.333334H128v-85.333334z"  />
            </svg>';
}
function authorship_add_authors_submenu()
{
    $options = authorship_get_options();

    $page_hook = add_submenu_page
    (
        'authors',
        _x( "Authors", "Page title", 'molongui-authorship' ),
        _x( "View All", "Authors submenu title", 'molongui-authorship' ),
        'edit_others_posts',
        'authors',
        'authorship_render_authors_screen'
    );
    add_action( "load-$page_hook", 'authorship_add_authors_screen_options' );

    if ( current_user_can( 'create_users' ) or $options['guest_authors'] )
    {
        add_submenu_page
        (
            'authors',
            _x( "Add New Author", "Page title", 'molongui-authorship' ),
            _x( "Add New", "Authors submenu title", 'molongui-authorship' ),
            'edit_others_posts',
            'author-new',
            'authorship_render_add_author_screen',
            5
        );
    }

    if ( $options['author_box'] )
    {
        add_submenu_page
        (
            'authors',
            _x( "Author Box Editor", "Authors submenu title", 'molongui-authorship' ),
            _x( "Author Box Editor", "Authors submenu title", 'molongui-authorship' ),
            'manage_options',
            'author-box-editor',
            'authorship_render_author_box_editor'
        );
    }

    add_submenu_page
    (
        'authors',
        _x( "Settings", "Page title", 'molongui-authorship' ),
        _x( "Settings", "Authors submenu title", 'molongui-authorship' ),
        'manage_options',
        MOLONGUI_AUTHORSHIP_NAME,
        'authorship_render_settings_page'
    );

    add_submenu_page
    (
        'authors',
        _x( "Tools", "Page title", 'molongui-authorship' ),
        _x( "Tools", "Authors submenu title", 'molongui-authorship' ),
        'manage_options',
        'molongui-authorship-tools',
        'authorship_render_tools_screen'
    );

    add_submenu_page
    (
        'authors',
        _x( "Help", "Page title", 'molongui-authorship' ),
        _x( "Help!", "Authors submenu title", 'molongui-authorship' ),
        'manage_options',
        'molongui-authorship-help',
        'authorship_render_help_screen'
    );
}
add_action( 'admin_menu', 'authorship_add_authors_submenu' );
function authorship_add_authors_screen_options()
{
    $arguments = array
    (
        'label'   => __( "Authors Per Page", 'molongui-authorship' ),
        'default' => 20,
        'option'  => 'authors_per_page'
    );
    add_screen_option( 'per_page', $arguments );
}
function authorship_set_authors_screen_options( $screen_option, $option, $value )
{
    if ( 'authors_per_page' == $option ) return $value;

    return $screen_option;
}
add_filter( 'set-screen-option', 'authorship_set_authors_screen_options', 10, 3 );
function authorship_render_authors_screen()
{
    $authors_table = new \Molongui\Authorship\Includes\Authors_List_Table( 'molongui-authorship' );
    $authors_table->prepare_items();

    include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/html-page-authors.php';
}
function authorship_render_add_author_screen()
{
    include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/html-page-author-new.php';
}
function authorship_render_author_box_editor()
{
    include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/html-page-editor.php';
}
function authorship_render_tools_screen()
{
    include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/html-page-tools.php';
}
function authorship_render_help_screen()
{
    $tidio_url = authorship_get_tidio();

    include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/html-page-help.php';
}