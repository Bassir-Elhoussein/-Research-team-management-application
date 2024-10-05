<?php
defined( 'ABSPATH' ) or exit;
$editor_url = authorship_editor_url();
$is_pro     = authorship_has_pro();

$options = array();
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'author-box',
        'name'     => __( "Author Box", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Let your readers know more about the authors on your site at a glance.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_features_header',
        'label'    => __( "Feature", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'author_box',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sAn %sauthor box%s is a great way to credit authors for their work. It displays author information on their posts.%s %sYou can %scustomize%s how they look like to nicely integrate them on your site. And easily configure how and when to display them.%s %sDisable this option only if you don't want to display any author box at all.%s", 'molongui-authorship' ), '<p>', '<strong>', '</strong>', '</p>', '<p>', '<a href="'.$editor_url.'">', '</a>', '</p>', '<p>', '</p>' ),
        'label'    => sprintf( __( "Enable %sAuthor Boxes%s", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_display_header',
        'label'    => __( "Display", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => true,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'dropdown',
        'atts'     => array
        (
            'search' => true,
            'multi'  => true,
        ),
        'deps'     => '',
        'search'   => '',
        'id'       => 'box_post_types_auto',
        'default'  => '',
        'class'    => '',
        'title'    => '',
        'desc'     => sprintf( __( "%sAutomatically show%s the author box %son%s all:", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>' ),
        'help'     => apply_filters( 'authorship/options/help', array
        (
            'text' => sprintf( __( "%sPost types in which to automatically insert the author box. Leave it blank and use the setting below if you want to manually select on which items to add the author box.%s %s%sAuthor and post configuration might override this setting%s.%s %sAuthor Boxes are usually displayed on blog posts. However, you may want to show them on a custom post type (like %sproducts%s, %scourses%s, %sprojects%s or %sleads%s).%s %s%sUpgrade to Pro to be able to add author boxes to other post types%s.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '<strong>', '</strong>', '</p>', '<p>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '</p>', '<p>', '<strong>', '</strong>', '</p>' ),
            'link' => array
            (
                'label'  => __( "Get Pro Now", 'molongui-authorship' ),
                'url'    => MOLONGUI_AUTHORSHIP_WEB,
                'target' => '',
            ),
        ), 'box_post_types_auto' ),
        'label'    => '',
        'options'  => authorship_get_post_types(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'dropdown',
        'atts'     => array
        (
            'search' => true,
            'multi'  => true,
        ),
        'deps'     => '',
        'search'   => '',
        'id'       => 'box_post_types_manual',
        'default'  => '',
        'class'    => '',
        'title'    => '',
        'desc'     => sprintf( __( "%sManually add%s the author box %son handpicked%s:", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>' ),
        'help'     => apply_filters( 'authorship/options/help', array
        (
            'text' => sprintf( __( "%sPost types for which you want to have the option to configure —on a post level— whether to display the author box or not. Configuration is made from the edit screen.%s %sLeave it blank and use the setting above if you want the author box to be shown automatically on selected post types.%s %s%sUpgrade to Pro to be able to select any of the grayed out post types%s.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p>', '<strong>', '</strong>', '</p>' ),
            'link' => array
            (
                'label'  => __( "Get Pro Now", 'molongui-authorship' ),
                'url'    => MOLONGUI_AUTHORSHIP_WEB,
                'target' => '',
            ),
        ), 'box_post_types_manual' ),
        'label'    => '',
        'options'  => authorship_get_post_types(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'inline-dropdown',
        'id'       => 'box_position',
        'default'  => 'below',
        'deps'     => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'search'   => '',
        'help'     => sprintf( __( "%sAuthor boxes are usually displayed at the bottom of post content.%s %sHowever, it is up to you whether to make it display above, below or on both placements.%s %s%sKeep in mind that post configuration might override this setting%s.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p>', '<strong>', '</strong>', '</p>' ),
        'label'    => sprintf( __( "%sPlace%s the author box %s the post content", 'molongui-authorship' ), '<strong>', '</strong>',  '{input}' ),
        'options'  => array
        (
            'above' => array
            (
                'icon'  => '',
                'label' => __( "above", 'molongui-authorship' ),
            ),
            'below' => array
            (
                'icon'  => '',
                'label' => __( "below", 'molongui-authorship' ),
            ),
            'both' => array
            (
                'icon'  => '',
                'label' => __( "above and below", 'molongui-authorship' ),
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => true,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'hide_if_no_bio',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => apply_filters( 'authorship/options/help', array
        (
            'text' => sprintf( __( "%sWhen enabled, the author box will not appear for authors without a description%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link' => array
            (
                'label'  => '',
                'url'    => '',
                'target' => '',
            ),
        ), 'hide_if_no_bio' ),
        'label'    => sprintf( __( "%sHide%s the author box %sif%s author description is %sempty%s", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>' ),
    );

    $display   = array();
    $display[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => true,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'hide_on_categories',
        'title'    => __( "Want to hide the author box based on post category?", 'molongui-authorship' ),
        'desc'     => __( "Upgrade to be able to select those post categories where the author box won't be displayed", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options = array_merge( $options, apply_filters( '_authorship/options/display/categories/markup', $display ) );
    $placement   = array();
    $placement[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => true,
        'type'     => 'banner',
        'id'       => 'hook_priority',
        'default'  => '',
        'deps'     => '',
        'class'    => '',
        'search'   => '',
        'title'    => __( "Push the author box higher/lower so it gets displayed before/after other added post widgets", 'molongui-authorship' ),
        'desc'     => __( "This helps ordering content added by third-party plugins", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options = array_merge( $options, apply_filters( '_authorship/options/hook_priority/markup', $placement ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => true,
        'deps'     => '',
        'search'   => '',
        'type'     => 'inline-dropdown',
        'class'    => '',
        'default'  => 'default',
        'id'       => 'box_layout_multiauthor',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => sprintf( __( "Display %s on multi-authored posts", 'molongui-authorship' ), '{input}' ),
        'options'  => array
        (
            'default' => array
            (
                'icon'  => '',
                'label' => __( "one single box with all authors bio", 'molongui-authorship' ),
            ),
            'individual' => array
            (
                'icon'  => '',
                'label' => __( "as many author boxes as authors", 'molongui-authorship' ),
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'link',
        'id'       => 'display_settings_override_notice',
        'default'  => '',
        'deps'     => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'search'   => '',
        'help'     => __( "Click to learn more", 'molongui-authorship' ),
        'label'    => __( "Display settings might get overridden by more specific post or author configuration", 'molongui-authorship' ),
        'href'     => 'https://www.molongui.com/docs/molongui-authorship/author-box/display-settings/',
        'target'   => '_blank',
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_appearance_header',
        'label'    => __( "Appearance", 'molongui-authorship' ),
        'buttons'  => array
        (
            'customize' => array
            (
                'display'  => false,
                'type'     => 'link',
                'href'     => $editor_url,
                'label'    => __( "Edit Styling", 'molongui-authorship' ),
                'title'    => __( "Click to customize author box styles", 'molongui-authorship' ),
                'class'    => '',
                'disabled' => false,
            ),
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => false,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'inline-dropdown',
        'class'    => '',
        'default'  => 'slim',
        'id'       => 'author_box_layout',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sDifferent author box layouts to choose from.%s %sGet to know how each one looks like on your site using the Customizer's live preview.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link' => array
            (
                'label'  => __( "Open Customizer", 'molongui-authorship' ),
                'url'    => $editor_url,
                'target' => 'internal',
            ),
        ),
        'label'   => sprintf( __( "Use the %s layout to display the author box", 'molongui-authorship' ), '{input}' ),
        'options' => array
        (
            'slim' => array
            (
                'icon'  => '',
                'label' => __( "slim", 'molongui-authorship' ),
            ),
            'tabbed' => array
            (
                'icon'  => '',
                'label' => __( "tabbed", 'molongui-authorship' ),
            ),
            'stacked' => array
            (
                'icon'  => '',
                'label' => __( "stacked", 'molongui-authorship' ),
            ),
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'number',
        'default'  => 600,
        'min'      => 1,
        'max'      => '',
        'step'     => 1,
        'class'    => '',
        'id'       => 'breakpoint',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sAs other plugins may also add their stuff to post content, the author box might be displayed somewhere different than expected. Making the plugin to add the author box before that third-party content (lowering the priority number) should move the box up, while adding it later (increasing the priority number) should move the box down.%s %sA value below 10 may cause issues with your content%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
        'label'    => sprintf( __( "Display the responsive layout version of the author box for screens up to %s px wide", 'molongui-authorship' ), '{input}' ),
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'deps'        => '',
        'search'      => '',
        'type'        => 'inline-text',
        'placeholder' => '',
        'default'     => '',
        'class'       => '',
        'id'          => 'author_box_custom_css_class',
        'title'       => '',
        'desc'        => '',
        'help'        => sprintf( __( "%sYou can provide a CSS class you want to be added to the author box. %sThis is useful if you need to add some custom styling to the author box or overwrite a default value.%s %sRemember that CSS selectors are generally case-insensitive.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p>', '</p>' ),
        'label'       => sprintf( __( "Add this custom CSS class to the author box container: %s", 'molongui-authorship' ), '{input}' ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => true,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'enable_author_box_styles',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sAuthor boxes are fully customizable. All the settings you need to make them fit your likings and website style are available on the %sWordPress Customizer%s.%s %sIf you prefer to style it from scratch coding your own stylesheets, you can disable loading the packaged CSS files.%s", 'molongui-authorship' ), '<p>', '<strong><i>', '</i></strong>', '</p>', '<p>', '</p>' ),
        'label'    => sprintf( __( "Load plugin CSS files for the author box %sKeep enabled unless you are a skilled developer that want to provide your own custom styling!%s", 'molongui-authorship' ), '<code>', '</code>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'link',
        'deps'     => '',
        'search'   => '',
        'id'       => 'open_editor',
        'default'  => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => __( "Click to open the Author Box Editor", 'molongui-authorship' ),
        'label'    => sprintf( __( "The author box appearance can be easily customized using the %slive-preview Editor%s. Click here to open it!", 'molongui-authorship' ), '<strong>', '</strong>' ),
        'href'     => $editor_url,
        'target'   => '_self',
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'type'     => 'header',
        'id'       => 'box_shortcode_header',
        'deps'     => '',
        'class'    => '',
        'search'   => '',
        'label'    => __( "Shortcode", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode',
        'title'    => __( "Display the author box anywhere: Custom post types, Sidebar, Footer...", 'molongui-authorship' ),
        'desc'     => __( "Easy-to-use shortcode with many customization attributes", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_headline_header',
        'label'    => __( "Headline", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => true,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'type'     => 'toggle',
        'id'       => 'show_headline',
        'default'  => false,
        'deps'     => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sSometimes you may want to display some text just above the author box.%s %sSomething like: %sAbout the author%s%s %sActivate this setting to add a heading to your author box and fully customize it using WordPress Customizer.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '<i>', '</i>', '</p>', '<p>', '</p>' ),
            'link' => array
            (
                'label'  => __( "Open Customizer", 'molongui-authorship' ),
                'url'    => $editor_url,
                'target' => 'internal',
            ),
        ),
        'label'    => __( "Display a headline above the author box", 'molongui-authorship' ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => false,
        'type'        => 'inline-text',
        'id'          => 'headline',
        'placeholder' => __( "About the author", 'molongui-authorship-pro' ),
        'default'     => '',
        'deps'        => '',
        'class'       => '',
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sText to display above each author box.%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link'    => '',
        ),
        'label'       => sprintf( __( "As a headline, display this text: %s", 'molongui-authorship-pro' ), '{input}' ),
        'search'      => '',
    );

    $headline   = array();
    $headline[] = array
    (
        'display'  => false, //apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => true,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'headline_tag',
        'title'    => __( "Improve your SEO selecting the HTML tag that best suits your SEO strategy.", 'molongui-authorship' ),
        'desc'     => __( "Configure the HTML tag for the author box headline.", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/headline_tag', $headline ) );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_info_header',
        'label'    => __( "Content", 'molongui-authorship' ),
        'buttons' => array
        (
            'advanced' => array
            (
                'display'  => true,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'type'     => 'toggle',
        'id'       => 'name_link_to_archive',
        'default'  => false,
        'deps'     => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sEnable this setting to make the author name in the author box link to a page listing all posts by the author.%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link' => '',
        ),
        'label'    => sprintf( __( "Make %sauthor name%s link to author page", 'molongui-authorship' ), '<strong>', '</strong>' ),
        'search'   => '',
    );

    $author_name_tag   = array();
    $author_name_tag[] = array
    (
        'display'  => false, //apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => true,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'headline_tag',
        'title'    => __( "Improve your SEO selecting the HTML tag that best suits your SEO strategy.", 'molongui-authorship' ),
        'desc'     => __( "Configure the HTML tag for the author name.", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'type'     => 'toggle',
        'id'       => 'show_meta',
        'default'  => true,
        'deps'     => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sDisplay author job position, company, telephone, email and other available author details in a line below the author name.%s %sYou can style that metadata line using WordPress Customizer.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link' => array
            (
                'label'  => __( "Open Customizer", 'molongui-authorship' ),
                'url'    => $editor_url,
                'target' => 'internal',
            ),
        ),
        'label'    => sprintf( __( "Display %sauthor details%s like job position and company in the author box", 'molongui-authorship' ), '<strong>', '</strong>' ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'type'        => 'inline-text',
        'id'          => 'at',
        'placeholder' => __( "at", 'molongui-authorship-pro' ),
        'default'     => '',
        'deps'        => '',
        'class'       => '',
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sText to display between job position and company name.%s %sIf one of those data is not provided, this connector will not be shown.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link'    => '',
        ),
        'label'       => sprintf( __( "As %sconnector%s to display between job position and company name, display this text: %s", 'molongui-authorship-pro' ), '<strong>', '</strong>', '{input}' ),
        'search'      => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'type'        => 'inline-text',
        'id'          => 'web',
        'deps'        => '',
        'search'      => '',
        'placeholder' => __( "Website", 'molongui-authorship-pro' ),
        'default'     => '',
        'class'       => '',
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sText to display as text link to an external author website.%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link'    => '',
        ),
        'label'       => sprintf( __( "As author personal website, use this text: %s", 'molongui-authorship-pro' ), '{input}' ),
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'type'        => 'inline-text',
        'id'          => 'more_posts',
        'deps'        => '',
        'placeholder' => __( "+ posts", 'molongui-authorship-pro' ),
        'default'     => '',
        'class'       => '',
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sText to display as switch to show author related posts.%s %sIt is not displayed if related posts feature is disabled.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link'    => '',
        ),
        'label'       => sprintf( __( "As text to show author related posts, use this text: %s", 'molongui-authorship-pro' ), '{input}' ),
        'search'      => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'deps'        => '',
        'search'      => '',
        'type'        => 'inline-text',
        'placeholder' => __( "Bio", 'molongui-authorship-pro' ),
        'default'     => '',
        'class'       => '',
        'id'          => 'bio',
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sText to display as switch to show author biography.%s %sOnly displayed when the author box is displaying author related posts.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link'    => '',
        ),
        'label'       => sprintf( __( "As text to show author biography back, use this text: %s", 'molongui-authorship-pro' ), '{input}' ),
    );
    $box_info   = array();
    $box_info[] = array
    (
        'display'  => false, //apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'type'     => 'banner',
        'id'       => 'box_info',
        'default'  => '',
        'deps'     => '',
        'class'    => '',
        'title'    => __( "Make author boxes display shorter author bio descriptions to make them look nicer", 'molongui-authorship' ),
        'desc'     => __( "Provide a short bio to display in the author box while keeping full bio to be displayed in author pages", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_avatar_header',
        'label'    => __( "Avatar", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => true,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'type'     => 'toggle',
        'id'       => 'show_avatar',
        'default'  => true,
        'deps'     => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sEnable this setting if you want the author avatar to be displayed in the author box.%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link' => '',
        ),
        'label'    => __( "Display author avatar in the author box", 'molongui-authorship' ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'type'     => 'toggle',
        'id'       => 'avatar_link_to_archive',
        'default'  => false,
        'deps'     => 'show_avatar',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sEnable this setting to make the author profile image in the author box link to a page listing all posts by the author.%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link' => '',
        ),
        'label'    => __( "Make avatar link to the author's page", 'molongui-authorship' ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => true,
        'type'     => 'inline-dropdown',
        'id'       => 'avatar_src',
        'default'  => 'local',
        'deps'     => 'show_avatar',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => sprintf( __( "Retrieve avatar image from %s", 'molongui-authorship' ),  '{input}' ),
        'options'  => array
        (
            'local' => array
            (
                'icon'  => '',
                'label' => __( "media library", 'molongui-authorship' ),
            ),
            'gravatar' => array
            (
                'icon'  => '',
                'label' => __( "Gravatar.com", 'molongui-authorship' ),
            ),
            'acronym' => array
            (
                'icon'  => '',
                'label' => __( "nowhere. Generate an image with author's name acronym instead.", 'molongui-authorship' ),
            ),
        ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => true,
        'type'     => 'inline-dropdown',
        'id'       => 'avatar_local_fallback',
        'default'  => 'gravatar',
        'deps'     => 'show_avatar',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => sprintf( __( "If no image available in the media library, %s", 'molongui-authorship' ),  '{input}' ),
        'options'  => array
        (
            'gravatar' => array
            (
                'icon'  => '',
                'label' => __( "try to retrieve one from Gravatar.com", 'molongui-authorship' ),
            ),
            'acronym' => array
            (
                'icon'  => '',
                'label' => __( "generate an image with author's name acronym instead", 'molongui-authorship' ),
            ),
            'none' => array
            (
                'icon'  => '',
                'label' => __( "don't display anything", 'molongui-authorship' ),
            ),
        ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => true,
        'type'     => 'inline-dropdown',
        'id'       => 'avatar_default_gravatar',
        'default'  => 'mp',
        'deps'     => 'show_avatar',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => sprintf( __( "If the author doesn't have a gravatar configured, load %s", 'molongui-authorship' ),  '{input}' ),
        'options'  => array
        (
            'mp' => array
            (
                'icon'  => '',
                'label' => __( "a simple, cartoon-style silhouetted outline of a person", 'molongui-authorship' ),
            ),
            'identicon' => array
            (
                'icon'  => '',
                'label' => __( "a geometric pattern based on an email hash", 'molongui-authorship' ),
            ),
            'monsterid' => array
            (
                'icon'  => '',
                'label' => __( "a generated 'monster' with different colors, faces, etc.", 'molongui-authorship' ),
            ),
            'wavatar' => array
            (
                'icon'  => '',
                'label' => __( "a generated face with differing features and backgrounds", 'molongui-authorship' ),
            ),
            'retro' => array
            (
                'icon'  => '',
                'label' => __( "a generated 8-bit arcade-style pixelated face", 'molongui-authorship' ),
            ),
            'robohash' => array
            (
                'icon'  => '',
                'label' => __( "a generated robot with different colors, faces, etc.", 'molongui-authorship' ),
            ),
            'blank' => array
            (
                'icon'  => '',
                'label' => __( "a transparent image", 'molongui-authorship' ),
            ),
        ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'type'        => 'inline-number',
        'id'          => 'avatar_width',
        'default'     => 150,
        'placeholder' => '150',
        'deps'        => 'show_avatar',
        'min'         => 1,
        'max'         => '',
        'step'        => 1,
        'class'       => '',
        'title'       => '',
        'desc'        => '',
        'help'        => sprintf( __( "%sAvatar image width in pixels.%s %sIf bigger than actual image's width, image's width is taken.%s %sSquare images take the lower value from given size values (width and height).%s %sYou might need/consider to regenerate thumbnails.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p>', '</p>', '<p>', '</p>' ),
        'label'       => sprintf( __( "Avatar image width: %s (px)", 'molongui-authorship' ), '{input}' ),
        'search'      => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'type'        => 'inline-number',
        'id'          => 'avatar_height',
        'default'     => 150,
        'placeholder' => '150',
        'deps'        => 'show_avatar',
        'min'         => 1,
        'max'         => '',
        'step'        => 1,
        'class'       => '',
        'title'       => '',
        'desc'        => '',
        'help'        => sprintf( __( "%sAvatar image height in pixels.%s %sIf bigger than actual image's height, image's height is taken.%s %sSquare images take the lower value from given size values (width and height).%s %sYou might need/consider to regenerate thumbnails.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p>', '</p>', '<p>', '</p>' ),
        'label'       => sprintf( __( "Avatar image height: %s (px)", 'molongui-authorship' ), '{input}' ),
        'search'      => '',
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_social_links_header',
        'label'    => __( "Social Links", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'show_icons',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sEnable this setting if you want social icons to be displayed in the author box.%s %sOnly provided social profiles are displayed.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/author-box/social-networks/',
        ),
        'label'   => __( "Display social icons in the author box", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'inline-dropdown',
        'class'    => '',
        'default'  => '_blank',
        'id'       => 'social_link_target',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => sprintf( __( "Open social links in %s", 'molongui-authorship' ),  '{input}' ),
        'options'  => array
        (
            '_self' => array
            (
                'icon'  => '',
                'label' => __( "the same browser tab", 'molongui-authorship' ),
            ),
            '_blank' => array
            (
                'icon'  => '',
                'label' => __( "a new tab", 'molongui-authorship' ),
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'box_related_posts_header',
        'label'    => __( 'Related Posts', 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => $is_pro,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'author_box_related_show',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => __( "Display related posts from the same author within the author box", 'molongui-authorship' ),
    );
    $related_posts   = array();
    $related_posts[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'type'     => 'banner',
        'id'       => 'related_posts',
        'default'  => '',
        'deps'     => 'author_box_related_show',
        'class'    => '',
        'title'    => __( "Configure which related posts are displayed to provide more relevant content and a better user experience", 'molongui-authorship' ),
        'desc'     => __( "Select which (custom) post types to retrieve, how many to display and how to order and sort them", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
        'search'   => '',
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/related_posts/markup', $related_posts ) );
    $options[] = array
    (
        'display'  => false,
        'advanced' => true,
        'type'     => 'toggle',
        'id'       => 'author_box_related_show_empty',
        'default'  => false,
        'deps'     => 'author_box_related_show',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => __( "Show section even if there are no related entries to show.", 'molongui-authorship-pro' ),
        'search'   => '',
    );
    $options[] = array
    (
        'display'     => false,
        'advanced'    => true,
        'type'        => 'inline-text',
        'id'          => 'author_box_related_none',
        'default'     => '',
        'deps'        => 'author_box_related_show show_empty_related',
        'class'       => '',
        'placeholder' => __( 'This author does not have any more posts.', 'molongui-authorship-pro' ),
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sMessage to display to let your readers know the author has no related entries to show.%s", 'molongui-authorship' ), '<p>', '</p>' ),
            'link'    => '',
        ),
        'label'       => sprintf( __( "When there are no related posts to show, display this text: %s", 'molongui-authorship-pro' ), '{input}' ),
        'search'      => '',
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'unveil',
        'class'    => '',
        'id'       => 'author_box_unveil',
        'label'    => array
        (
            'show' => __( "Show More Advanced Settings", 'molongui-authorship' ),
            'hide' => __( "Hide More Advanced Settings", 'molongui-authorship' ),
        )
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'main_spam_protecction_header',
        'label'    => __( "Spam Protection", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $spam_protect   = array();
    $spam_protect[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => 'spam_protect',
        'title'    => __( "Display plain author email and phone without worrying about them getting spammed.", 'molongui-authorship' ),
        'desc'     => __( "Encode sensitive information to make it unreadable for SPAM bots.", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/spam_protect/markup', $spam_protect ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'schema_markup_header',
        'label'    => __( "Schema Markup", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => 'hidden',
        'default'  => true,
        'id'       => 'box_schema',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => __( "Add Structured Data/Schema.org Markup to HTML code generated by the plugin.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'compat_cdn_header',
        'label'    => __( "CDN", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => 'hidden',
        'default'  => false,
        'id'       => 'enable_cdn_compat',
        'title'    => '',
        'desc'     => sprintf( __( "Messed up author box layout? And you using a CDN? Enable this setting and clear every cache you might have, including your CDN's. If the issue persists, please %sopen a support ticket%s with us so we can assist.", 'molongui-authorship' ), '<a href="https://www.molongui.com/support/#open-ticket" target="_blank">', '</a>' ),
        'help'     => array
        (
            'text' => sprintf( __( "%sActivate this setting only if you are experiencing issues.%s %sWhen using a CDN to serve stylesheet files, author box layout might look messed up. Enabling this setting should fix that.%s", 'molongui-authorship' ), '<p><strong>', '</strong></p>', '<p>', '</p>' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/troubleshooting/the-author-box-layout-is-being-displayed-oddly/',
        ),
        'label'   => __( "Enable CDN compatibility to fix author box layout and make it display nicely.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'link',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => 'cdn_support',
        'title'    => '',
        'desc'     => '',
        'help'     => __( "Click to open a Support Ticket", 'molongui-authorship' ),
        'label'    => __( "Issue persists? Report it", 'molongui-authorship' ),
        'href'     => molongui_get_support(),
        'target'   => '_blank',
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => 'cdn_premium_support',
        'title'    => __( "Need Premium Support?", 'molongui-authorship' ),
        'desc'     => __( "Paid users are given top priority in our support system, with replies to their support tickets taking precedence.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB.'/pricing/',
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'box_appearance_header',
        'label'    => __( "Styling", 'molongui-authorship' ),
        'buttons'  => array
        (
            'editor' => array
            (
                'display'  => false,
                'type'     => 'link',
                'href'     => $editor_url,
                'label'    => __( "Edit Styling", 'molongui-authorship' ),
                'title'    => __( "Click to customize author box styles", 'molongui-authorship' ),
                'class'    => '',
                'disabled' => false,
            ),
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'enable_author_box_styles',
        'default'  => true,
        'class'    => 'hidden',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sAuthor boxes are fully customizable. All the settings you need to make them fit your likings and website style are available on the %sWordPress Customizer%s.%s %sIf you prefer to style it from scratch coding your own stylesheets, you can disable loading the packaged CSS files.%s", 'molongui-authorship' ), '<p>', '<strong><i>', '</i></strong>', '</p>', '<p>', '</p>' ),
        'label'    => sprintf( __( "Load plugin CSS files for the author box %sKeep enabled unless you are a skilled developer that want to provide your own custom styling!%s", 'molongui-authorship' ), '<code>', '</code>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'compat_misc_header',
        'label'    => __( "Misc", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'     => true,
        'advanced'    => false,
        'deps'        => '',
        'search'      => '',
        'type'        => 'text',
        'placeholder' => '#author-bio, .author-box-wrap',
        'default'     => '',
        'class'       => 'hidden',
        'id'          => 'hide_elements',
        'title'       => '',
        'desc'        => '',
        'help'        => array
        (
            'text'    => sprintf( __( "%sMany themes add elements to your site without giving the option to disable them.%s %sNow you can hide unwanted author boxes, byline decorations or whatever.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link'    => 'https://www.molongui.com/docs/molongui-authorship/troubleshooting/the-author-box-shows-up-twice/',
        ),
        'label'       => sprintf( __( "Need to get rid of some elements you don't have the setting to? Provide a comma-separated list of CSS IDs and/or classes and Molongui Authorship will prevent them from being displayed on the front-end.", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/troubleshooting/the-author-box-shows-up-twice/" target="_blank">', '</a>' ),
    );
}
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'guest-authors',
        'name'     => __( "Guest Authors", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Add an author or one-time contributor to a post without creating an account for them.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'guest_features_header',
        'label'    => __( "Feature", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'guest_authors',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sAdd content from other authors to your site and easily credit them by changing post author.%s %sJust add a new post, paste content and change post author accordingly.%s %sGuest authors are just names. They doesn't have access to your Dashboard, so you don't have to worry about managing them.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' , '<p>', '</p>' ),
        'label'    => sprintf( __( "Enable %sGuest Authors%s", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'button',
        'deps'     => '',
        'search'   => '',
        'id'       => 'guests-post-types-notice',
        'class'    => 'is-compact',
        'label'    => sprintf( __( "Guest authors are enabled %s%s%s", 'molongui-authorship' ), '<strong>', '<span id="guests-post-types"></span>', '</strong>' ),
        'button'   => array
        (
            'display'  => true,
            'type'     => 'action',
            'id'       => 'edit-guests-post-types',
            'label'    => __( "Edit", 'molongui-authorship' ),
            'title'    => __( "Edit post types to which you can add guest authors.", 'molongui-authorship' ),
            'class'    => 'same-width',
            'disabled' => false,
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'guest_pages_header',
        'label'    => __( "Guest Author Pages", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => apply_filters( '_authorship/options/display_advanced_button', false ),
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $guest_archive   = array();
    $guest_archive[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'guest-pages',
        'title'    => __( "Give your guest authors the credit they deserve with Guest Author Pages.", 'molongui-authorship' ),
        'desc'     => __( "Just like User Pages. Same layout, same styles.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/archives/guest/markup', $guest_archive ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '', // This header has multiple dependencies, so it must be handled with tailor-made JS.
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'compat_rest_header',
        'label'    => __( "Search Results", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $enhanced_search   = array();
    $enhanced_search[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'type'     => 'banner',
        'deps'     => '',
        'search'   => '',
        'id'       => 'guests_in_search',
        'default'  => '',
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'label'    => sprintf( __( "Enhance the search function to give visitors more relevant search results and a better user experience allowing them to search content by author display name.", 'molongui-authorship' ) ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/guest_search_markup', $enhanced_search ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'unveil',
        'class'    => '',
        'id'       => 'guest_authors_unveil',
        'label'    => array
        (
            'show' => __( "Show More Advanced Settings", 'molongui-authorship' ),
            'hide' => __( "Hide More Advanced Settings", 'molongui-authorship' ),
        )
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '', // This header has multiple dependencies, so it must be handled with tailor-made JS.
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'guests_rest_header',
        'label'    => __( "REST API", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $rest_api   = array();
    $rest_api[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '', // This header has multiple dependencies, so it must be handled with tailor-made JS.
        'search'   => '',
        'type'     => 'banner',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => 'guests_rest_api',
        'title'    => __( "Allow third-party applications to interact with your posts and authors via the WordPress REST API.", 'molongui-authorship' ),
        'desc'     => __( "Expose post co-authors and guest author object.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/guests_rest_api', $rest_api ) );
}
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'co-authors',
        'name'     => __( "Co-Authors", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Add multiple authors to your posts and credit everyone involved.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'multi_features_header',
        'label'    => __( "Feature", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'enable_multi_authors',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sMultiple authors worked on a piece of content? Enabling this option allows you to add multiple authors to a single post.%s %s%sPublish posts with multiple authors and properly credit to everyone involved%s.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '<strong>', '</strong>', '</p>' ),
        'label'    => sprintf( __( "Enable %sMulti-Authors%s", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'button',
        'deps'     => '',
        'search'   => '',
        'id'       => 'multi-post-types-notice',
        'class'    => 'is-compact',
        'label'    => sprintf( __( "Multi-authors are enabled %s%s%s", 'molongui-authorship' ), '<strong>', '<span id="multi-post-types"></span>', '</strong>' ),
        'button'   => array
        (
            'display'  => true,
            'type'     => 'action',
            'id'       => 'edit-multi-post-types',
            'label'    => __( "Edit", 'molongui-authorship' ),
            'title'    => __( "Edit post types to which you can add multiple authors.", 'molongui-authorship' ),
            'class'    => 'same-width',
            'disabled' => false,
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'byline_header',
        'label'    => __( "Post Byline", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => true,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,//authorship_is_feature_enabled( 'multi' ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'inline-dropdown',
        'class'    => '',
        'default'  => 'all',
        'id'       => 'byline_multiauthor_display',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sThe byline on a post gives the name of the people who contributed to write it.%s %sWhen a post is written by one single person, that person's name is the one displayed on the post byline. However, on co-authored posts you have the option to choose how author names are displayed.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/byline/byline-content-and-link/',
        ),
        'label'   => sprintf( __( "On co-authored posts display %s in the post byline", 'molongui-authorship' ),  '{input}' ),
        'options' => array
        (
            'all' => array
            (
                'icon'  => '',
                'label' => __( "all authors names", 'molongui-authorship' ),
            ),
            'main' => array
            (
                'icon'  => '',
                'label' => __( "only the name of the main author", 'molongui-authorship' ),
            ),
            '1' => array
            (
                'icon'  => '',
                'label' => __( "main author name and remaining authors count as number", 'molongui-authorship' ),
            ),
            '2' => array
            (
                'icon'  => '',
                'label' => __( "first 2 authors names and remaining authors count as number", 'molongui-authorship' ),
            ),
            '3' => array
            (
                'icon'  => '',
                'label' => __( "first 3 authors names and remaining authors count as number", 'molongui-authorship' ),
            ),
        ),
    );
    $options[] = array
    (
        'display'     => true,//authorship_is_feature_enabled( 'multi' ),
        'advanced'    => false,
        'deps'        => '',
        'search'      => '',
        'type'        => 'inline-text',
        'placeholder' => ', ',
        'default'     => ', ',
        'class'       => '',
        'id'          => 'byline_multiauthor_separator',
        'title'       => '',
        'desc'        => '',
        'help'        => sprintf( __( "%sYou can provide any word, string or symbol except these symbols: %s?%s %s/%s %s*%s.%s %sAny question mark, slash and asterisk you provide will be removed.%s", 'molongui-authorship' ), '<p>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '</p>', '<p>', '</p>' ),
        'label'       => sprintf( __( "As delimiter to separate multiple author names, use: %s", 'molongui-authorship' ), '{input}' ),
    );
    $options[] = array
    (
        'display'     => true,//authorship_is_feature_enabled( 'multi' ),
        'advanced'    => false,
        'deps'        => '',
        'search'      => '',
        'type'        => 'inline-text',
        'placeholder' => 'and',
        'default'     => 'and',
        'class'       => '',
        'id'          => 'byline_multiauthor_last_separator',
        'title'       => '',
        'desc'        => '',
        'help'        => sprintf( __( "%sYou can provide any word, string or symbol except these symbols: %s?%s %s/%s %s*%s.%s %sAny question mark, slash and asterisk you provide will be removed.%s", 'molongui-authorship' ), '<p>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '</p>', '<p>', '</p>' ),
        'label'       => sprintf( __( "As delimiter to separate last two author names, use: %s", 'molongui-authorship' ), '{input}' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'byline_name_link',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sThemes normally make author name on bylines to link to that author's archive page. That's standard behavior so everyone expects it to work like that.%s %sHowever, Molongui Authorship allows you to disable that feature preventing author names to be a link.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/byline/byline-content-and-link/',
        ),
        'label'   => __( "Make author name link to author page", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => authorship_is_feature_enabled( 'multi' ),
        'advanced' => true,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'byline_multiauthor_link',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => __( "Your theme or third-party plugin might prevent this setting to work. If disabled, the whole byline will link to the main author page.", 'molongui-authorship' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/byline/byline-content-and-link/',
        ),
        'label'   => sprintf( __( "On co-authored posts, make each author name link to its author page %sMight not always work!%s", 'molongui-authorship' ), '<code>', '</code>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'unveil',
        'class'    => '',
        'id'       => 'co_authors_unveil',
        'label'    => array
        (
            'show' => __( "Show More Advanced Settings", 'molongui-authorship' ),
            'hide' => __( "Hide More Advanced Settings", 'molongui-authorship' ),
        )
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '', // This header has multiple dependencies, so it must be handled with tailor-made JS.
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'multi_rest_header',
        'label'    => __( "REST API", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $rest_api   = array();
    $rest_api[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '', // This header has multiple dependencies, so it must be handled with tailor-made JS.
        'search'   => '',
        'type'     => 'banner',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => 'multi_rest_api',
        'title'    => __( "Allow third-party applications to interact with your posts and authors via the WordPress REST API.", 'molongui-authorship' ),
        'desc'     => __( "Expose post co-authors and guest author object.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/multi_rest_api', $rest_api ) );
}
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'users',
        'name'     => __( "Users", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Local avatar, additional profile fileds and more for your users.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'header',
        'deps'     => '',
        'search'   => '',
        'id'       => 'user_features_header',
        'class'    => '',
        'label'    => __( "Features", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'enable_local_avatars',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sStop depending on Gravatar to display author pictures.%s %sEnabling this setting allows you to upload custom images as author avatars.%s %sThis setting does not disable Gravatar. In fact, it can still be used as fallback if no local avatar is provided.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' , '<p>', '</p>' ),
        'label'    => sprintf( __( "Enable %slocal avatars%s to be able to upload custom images as author profile avatars", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'enable_user_profiles',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sEnabling this setting additional fields are added to the user profile page.%s %sMost of them can be displayed on the author box and other public places.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>' ),
        'label'    => sprintf( __( "Enable %sadditional user profile fields%s like short bio, phone, company, social links and more", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $search_name   = array();
    $search_name[] = array
    (
        'display' => apply_filters( 'authorship/options/display/banners', true ),
        'type'    => 'banner',
        'class'   => '',
        'default' => '',
        'id'      => 'enhanced_search',
        'title'   => '',
        'desc'    => '',
        'label'   => sprintf( __( "Enhance the search function to give visitors more relevant search results and a better user experience allowing them to search content by author display name.", 'molongui-authorship' ) ),
        'button'  => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/search_by_name', $search_name ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'main_user_roles_header',
        'label'    => __( "User Roles", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $user_roles   = array();
    $user_roles[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'user_roles',
        'title'    => '',
        'desc'     => '',
        'label'    => sprintf( __( "Select which user roles to take to populate authors dropdown selector. Even custom user roles are supported. %sBy default, %sadministrator%s, %seditor%s, %sauthor%s and %scontributor%s roles are enabled.", 'molongui-authorship' ), '<br>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/user_roles/markup', $user_roles ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'archive_user_header',
        'label'    => __( "Author Pages", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => apply_filters( '_authorship/options/display_advanced_button', false ),
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $user_archive   = array();
    $user_archive[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'user-archives',
        'title'    => __( "Easily configure User Pages to your needs.", 'molongui-authorship' ),
        'desc'     => __( "Disable them and configure redirection. Switch template and permalink. Include pages and custom post types. Customize page title.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/archives/user/markup', $user_archive ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'user_permissions_header',
        'label'    => __( "Permissions", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $permissions   = array();
    $permissions[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'permissions_hide_others_posts',
        'title'    => __( "Prevent authors to see the Posts that other users are working on and keep Posts list shorter", 'molongui-authorship' ),
        'desc'     => __( "By default, users see all posts but can only edit theirs. With this option you can hide other authors' posts for selected user roles. Custom user roles supported", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/permissions/markup', $permissions ) );
}
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'more',
        'name'     => __( "More", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Personalize Molongui Authorship. Settings that make it yours.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'header',
        'deps'     => '',
        'search'   => '',
        'id'       => 'main_post_types_header',
        'default'  => '',
        'class'    => '',
        'label'    => __( "Post Types", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'dropdown',
        'atts'     => array
        (
            'search' => true,
            'multi'  => true,
        ),
        'deps'     => '',
        'search'   => '',
        'id'       => 'post_types',
        'default'  => '',
        'class'   => '',
        'title'   => '',
        'desc'    => sprintf( __( "Enable %sGuest Authors%s and %sMulti-authors%s on:", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>' ),
        'help'    => '',
        'label'   => '',
        'options' => authorship_get_post_types(),
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'premium_post_types',
        'title'    => __( "Enable other post types", 'molongui-authorship' ),
        'desc'     => __( "Need guest authors and co-authors in courses, projects, products or any other custom post type? Upgrade now!", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'main_social_networks_header',
        'label'    => __( 'Social Networks', 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => true,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'dropdown',
        'atts'     => array
        (
            'search' => true,
            'multi'  => true,
        ),
        'class'    => '',
        'default'  => '',
        'id'       => 'social_networks',
        'title'    => '',
        'desc'     => __( "Select those social networks you want to enable. You can select as many as you wish.", 'molongui-authorship' ),
        'help'     => array
        (
            'text' => sprintf( __( "%sThere are a ton of social networks. To avoid clutter, select those you want to enable.%s %sYou can select as many as you wish. And you can filter displayed list by typing the name of the network you are looking for.%s %sAnd if you find one missing, you can request us to include it.%s %s" ), '<p>', '</p>', '<p>', '</p>', '<p>', '</p>', ( !$is_pro ? sprintf( __( "%sDisabled options are only available in %sMolongui Authorship Pro%s%s", 'molongui-authorship' ), '<p>', '<a href="'.MOLONGUI_AUTHORSHIP_WEB.'" target="_blank">', '</a>', '</p>' ) : '' ) ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/author-box/social-networks/',
        ),
        'label'    => '',
        'options'  => authorship_get_social_networks(),
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'premium_social_networks',
        'title'    => __( "Need to enable any of those disabled listed networks?", 'molongui-authorship' ),
        'desc'     => __( "Disabled networks are only available in Molongui Authorship Pro. Upgrade now!", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => true,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'add_nofollow',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => __( "Add 'nofollow' attribute to social networks links.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'byline_modifiers_header',
        'label'    => __( "Byline Modifiers", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => $is_pro,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $modifiers   = array();
    $modifiers[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'byline_modifiers',
        'title'    => sprintf( __( "Customize bylines by adding custom strings to the beginning %se.g. 'Written by'%s or to the end %se.g. 'et al.'%s of it.", 'molongui-authorship' ), '<code>', '</code>', '<code>', '</code>' ),
        'desc'     => __( "HTML markup is accepted, so you can add your own styles and custom elements.", 'molongui-authorship' ),
        'label'    => '',
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/byline/modifiers/markup', $modifiers ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'unveil',
        'class'    => '',
        'id'       => 'more_unveil',
        'label'    => array
        (
            'show' => __( "Show More Advanced Settings", 'molongui-authorship' ),
            'hide' => __( "Hide More Advanced Settings", 'molongui-authorship' ),
        )
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => 'hidden',
        'id'       => 'seo_tags_header',
        'label'    => __( "Author Tags", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => '',
        'title'    => '',
        'desc'     => __( "Author meta tags might be useful for rich snippets and SEO. Enabling settings below might not be required if you already have a dedicated SEO/Schema plugin that gets the job done.", 'molongui-authorship' ),
        'help'     => '',
        'link'     => '',
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => 'hidden',
        'default'  => true,
        'id'       => 'add_html_meta',
        'title'    => '',
        'desc'     => '',
        'help'     => '',
        'label'    => sprintf( __( "Add %sname='author'%s meta tags.", 'molongui-authorship' ), '<code>', '</code>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => 'hidden',
        'default'  => true,
        'id'       => 'add_opengraph_meta',
        'title'    => '',
        'desc'     => '',
        'help'     => __( "Opengraph meta tags might help your site improve SEO ratings.", 'molongui-authorship' ),
        'label'    => __( "Add Opengraph meta tags.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => 'hidden',
        'default'  => true,
        'id'       => 'add_facebook_meta',
        'title'    => '',
        'desc'     => '',
        'help'     => __( "Facebook tags might help your site improve SEO ratings.", 'molongui-authorship' ),
        'label'    => sprintf( __( "Add %sproperty='article:author'%s meta tag for Facebook.", 'molongui-authorship' ), '<code>', '</code>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => 'hidden',
        'default'  => true,
        'id'       => 'add_twitter_meta',
        'title'    => '',
        'desc'     => '',
        'help'     => __( "Twitter tags might help your site improve SEO ratings.", 'molongui-authorship' ),
        'label'    => sprintf( __( "Add %sname='twitter:creator'%s meta tag for Twitter.", 'molongui-authorship' ), '<code>', '</code>' ),
    );
    $seo_tags   = array();
    $seo_tags[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => 'hidden',
        'default'  => '',
        'id'       => 'seo-tags',
        'title'    => __( "Configure how to include co-authors information into post meta tags.", 'molongui-authorship' ),
        'desc'     => __( "Get full control over meta tags to improve your SEO.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/seo/tags/markup', $seo_tags ) );
    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'advanced_tab_header',
        'label'    => __( "Advanced", 'molongui-authorship' ),
        'buttons'  => array(),
    );

    $options[] = array
    (
        'display'  => false,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'button',
        'class'    => 'is-compact',
        'label'    => sprintf( __( "Configure additional plugin settings %sAdvanced users only%s", 'molongui-authorship' ), '<code>', '</code>' ),
        'button'   => array
        (
            'display'  => true,
            'type'     => 'action',
            'id'       => 'advanced-tab',
            'label'    => __( "Go", 'molongui-authorship' ),
            'title'    => __( "See more advanced settings", 'molongui-authorship' ),
            'class'    => 'same-width',
            'disabled' => false,
        ),
    );
}
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'access'   => '',
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'advanced',
        'name'     => __( "Advanced", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Settings that help you customize the plugin UI, troubleshoot issues and more.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'interface_header',
        'label'    => __( "Interface", 'molongui-authorship' ),
        'buttons'  => array
        (
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'authors_menu',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sIf enabled, a new item is added to your WordPress menu on the left-hand side of your Dashboard.%s", 'molongui-authorship' ), '<p>', '</p>' ),
        'label'    => sprintf( __( "Add %sAuthors%s menu to your WordPress dashboard", 'molongui-authorship' ), '<code>', '</code>' ),
        'notice'   => __( "Changes will take effect on page refresh", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'guests_menu',
        'default'  => false,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sIf enabled, a new item is added to your WordPress menu on the left-hand side of your Dashboard.%s", 'molongui-authorship' ), '<p>', '</p>' ),
        'label'    => sprintf( __( "Add %sGuest Authors%s menu to your WordPress dashboard", 'molongui-authorship' ), '<code>', '</code>' ),
        'notice'   => __( "Changes will take effect on page refresh", 'molongui-authorship' ),
    );
    $interface   = array();
    $interface[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'interface',
        'title'    => '',
        'desc'     => '',
        'label'    => sprintf( __( "Place %sGuest Authors%s menu item inside %sUsers%s, %sPosts%s or %sPages%s menu.", 'molongui-authorship' ), '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '<code>', '</code>' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );

    $options = array_merge( $options, apply_filters( '_authorship/options/interface/markup', $interface ) );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'molongui_menu',
        'default'  => false,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sIf enabled, a new item is added to your WordPress menu on the left-hand side of your Dashboard.%s", 'molongui-authorship' ), '<p>', '</p>' ),
        'label'    => sprintf( __( "Add %sMolongui%s menu to your WordPress dashboard", 'molongui-authorship' ), '<code>', '</code>' ),
        'notice'   => __( "Changes will take effect on page refresh", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'posts_submenu',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sIf enabled, a new item is added to your WordPress %sPosts%s menu for your convenience.%s", 'molongui-authorship' ), '<p>', '<code>', '</code>', '</p>' ),
        'label'    => sprintf( __( "Add %sAuthors%s quick link to the %sPosts%s menu", 'molongui-authorship' ), '<code>', '</code>', '<strong>', '</strong>' ),
        'notice'   => __( "Changes will take effect on page refresh", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'appearance_submenu',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sIf enabled, a new item is added to your WordPress %sAppearance%s menu for your convenience.%s", 'molongui-authorship' ), '<p>', '<code>', '</code>', '</p>' ),
        'label'    => sprintf( __( "Add %sAuthor Box%s quick link to the %sAppearance%s menu", 'molongui-authorship' ), '<code>', '</code>', '<strong>', '</strong>' ),
        'notice'   => __( "Changes will take effect on page refresh", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'toggle',
        'deps'     => '',
        'search'   => '',
        'id'       => 'settings_submenu',
        'default'  => true,
        'class'    => '',
        'title'    => '',
        'desc'     => '',
        'help'     => sprintf( __( "%sIf enabled, some new items are added to your WordPress %sSettings%s menu for your convenience.%s", 'molongui-authorship' ), '<p>', '<code>', '</code>', '</p>' ),
        'label'    => sprintf( __( "Add %sAuthor Box%s, %sGuest Authors%s and %sCo-Authors%s quick links to the %sSettings%s menu", 'molongui-authorship' ), '<code>', '</code>', '<code>', '</code>', '<code>', '</code>', '<strong>', '</strong>' ),
        'notice'   => __( "Changes will take effect on page refresh", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'inline-dropdown',
        'class'    => '',
        'default'  => 'filter',
        'id'       => 'author_name_action',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sOn admin screens listing posts, you have a column labeled %sAuthors%s. This setting allows you to configure what action to take when clicking on the author name displayed on that column.%s %sYou can choose between keeping WordPress default behavior, which is to show a list of posts authored by that author or get redirected to the author edit screen.%s", 'molongui-authorship' ), '<p>', '<code>', '</code>', '</p>', '<p>', '</p>' ),
            'link' => '',
        ),
        'label'   => sprintf( __( "Make author names on your Dashboard link to %s", 'molongui-authorship' ),  '{input}' ),
        'options' => array
        (
            'filter' => array
            (
                'icon'  => '',
                'label' => __( "a screen displaying a filtered list of posts by that author", 'molongui-authorship' ),
            ),
            'edit' => array
            (
                'icon'  => '',
                'label' => __( "the edit-author screen", 'molongui-authorship' ),
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'performance_header',
        'label'    => __( "Performance", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'enable_cache',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sThe WordPress Object Cache is used to save on trips to the database.%s %sHaving this setting enabled can reduce query time up to 94%s. So %sit is really advised to have it ON.%s%s %sBy default, the object cache is non-persistent. This means that data stored in the cache resides in memory only and only for the duration of the request. Cached data will not be stored persistently across page loads unless you install a persistent caching plugin.%s %sWhen in doubt, %sleave it on%s.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '%', '<strong>', '</strong>', '</p>', '<p>', '</p>', '<p>', '<strong>', '</strong>', '</p>' ),
            'link' => 'https://developer.wordpress.org/reference/classes/wp_object_cache/',
        ),
        'label'   => __( "Let the plugin use the WordPress Object Cache to speed things up", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'assets_cdn',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sA content delivery network (CDN) is a distributed network of servers that can efficiently deliver web content to users. CDNs store cached content on edge servers that are close to end users to minimize latency.%s %sCDNs are typically used to deliver static content such as style sheets and client-side scripts. The major advantages of using a CDN are lower latency and faster delivery of content to users, regardless of their geographical location in relation to the datacenter where your site is hosted. CDNs can also help to reduce load on your server, because your site does not have to service requests for the content that is hosted in the CDN.%s %sEnabling this setting vendor assets will be loaded from a CDN.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p>', '</p>' ),
            'link' => '',
        ),
        'label'   => __( "Load vendor assets from remote CDN", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'compatibility_header',
        'label'    => __( "Compatibility", 'molongui-authorship' ),
        'buttons'  => array
        (
            'advanced' => array
            (
                'display'  => false,
                'type'     => 'advanced',
                'label'    => __( "Show Advanced", 'molongui-authorship' ),
                'title'    => __( "Click to show advanced settings", 'molongui-authorship' ),
                'class'    => 'm-advanced-options',
                'disabled' => false,
            ),
            'save' => array
            (
                'display'  => true,
                'type'     => 'save',
                'label'    => __( "Save", 'molongui-authorship' ),
                'title'    => __( "Save Settings", 'molongui-authorship' ),
                'class'    => 'm-save-options',
                'disabled' => true,
            ),
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'enable_theme_compat',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sMolongui Authorship works great with just about every theme, especially with most popular. However, some require tailored functions to achieve full compatibility.%s %sIf you experience issues with the information displayed on your post bylines or anything related to your authors information, make sure this setting is enabled. If it already is and the issue persists, please open a support ticket with us so we can assist.%s %sIn case of doubt, keep this setting enabled.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p><strong>', '</strong></p>' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/compatibility/',
        ),
        'label'    => sprintf( __( "Enable %stheme%s compatibility", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'toggle',
        'class'    => '',
        'default'  => true,
        'id'       => 'enable_plugin_compat',
        'title'    => '',
        'desc'     => '',
        'help'     => array
        (
            'text' => sprintf( __( "%sMolongui Authorship works great with just about every plugin, especially with most popular. However, some require tailored functions to get both plugins running smoothly together.%s %sIf you experience issues related to your authors information, make sure this setting is enabled. If it already is and the issue persists, please open a support ticket with us so we can assist.%s %sIn case of doubt, keep this setting enabled.%s", 'molongui-authorship' ), '<p>', '</p>', '<p>', '</p>', '<p><strong>', '</strong></p>' ),
            'link' => 'https://www.molongui.com/docs/molongui-authorship/compatibility/',
        ),
        'label'    => sprintf( __( "Enable %splugin%s compatibility", 'molongui-authorship' ), '<strong>', '</strong>' ),
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'theme_premium_support',
        'title'    => __( "Need to make your theme work with Molongui Authorship ASAP?", 'molongui-authorship' ),
        'desc'     => __( "Get Premium support to make your theme run smoothly with Molongui Authorship.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB.'/pricing/',
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'link',
        'class'    => '',
        'default'  => '',
        'id'       => '',
        'title'    => '',
        'desc'     => '',
        'help'     => __( "Click to open a Support Ticket", 'molongui-authorship' ),
        'label'    => __( "Issue persists? Report it", 'molongui-authorship' ),
        'href'     => molongui_get_support(),
        'target'   => '_blank',
    );
}
if ( true )
{
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'section',
        'id'       => 'shortcodes',
        'name'     => __( "Shortcodes", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'type'     => 'title',
        'label'    => __( "Handy shortcodes that will make building your site a lot easier.", 'molongui-authorship' ),
    );
    $options[] = array
    (
        'display'  => apply_filters( 'authorship/options/display_banners', true ),
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'banner',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcodes',
        'title'    => __( "Display author information wherever your design requires. Easy yet highly flexible and customizable.", 'molongui-authorship' ),
        'desc'     => __( "Premium shortcodes below are a must-have if you use a page builder like Elementor, Divi, Beaver, Visual Composer or any other.", 'molongui-authorship' ),
        'button'   => array
        (
            'label'  => __( "Upgrade", 'molongui-authorship' ),
            'title'  => __( "Upgrade", 'molongui-authorship' ),
            'class'  => 'm-upgrade',
            'href'   => MOLONGUI_AUTHORSHIP_WEB,
            'target' => '_blank',
        ),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'author_box_shortcodes_header',
        'label'    => __( "Author Box", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_box',
        'title'    => '[molongui_author_box]',
        'desc'     => sprintf( __( "Displays an author box anywhere you want. You can customize which author information to show and how the displayed author box will look like by using additional attributes. All styling settings can be overridden. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_box/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_box/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'byline_shortcodes_header',
        'label'    => __( "Post Byline", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_byline',
        'title'    => '[molongui_byline]',
        'desc'     => sprintf( __( "Displays the post's byline. Most themes display the byline just below the title. You can place it anywhere you want using this shortcode. What is more, customize it by prepending and/or appending any text you like. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_byline/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_byline/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'author_list_shortcodes_header',
        'label'    => __( "Author Lists", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_list',
        'title'    => '[molongui_author_list]',
        'desc'     => sprintf( __( "Displays a list of (all) authors in your site anywhere you want. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_list/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_list/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_select',
        'title'    => '[molongui_author_select]',
        'desc'     => sprintf( __( "Displays a dropdown select listing (all the) authors from your blog. This shortcode is intended for developers only. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui-author-select/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui-author-select/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'author_list_shortcodes_header',
        'label'    => __( "Author Posts", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_posts',
        'title'    => '[molongui_author_posts]',
        'desc'     => sprintf( __( "Displays a list showing (all the) posts from any given author anywhere you want. Listed posts can be configured making use of the optional attributes this shortcode can take. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_posts/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_posts/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'header',
        'class'    => '',
        'id'       => 'author_data_shortcodes_header',
        'label'    => __( "Author Data", 'molongui-authorship' ),
        'buttons'  => array(),
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_name',
        'title'    => '[molongui_author_name]',
        'desc'     => sprintf( __( "Displays the name of the current post author(s) if no attributes are provided or the name of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_name/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_name/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_slug',
        'title'    => '[molongui_author_slug]',
        'desc'     => sprintf( __( "Displays the slug of the current post author(s) if no attributes are provided or the slug of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_slug/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_slug/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_url',
        'title'    => '[molongui_author_url]',
        'desc'     => sprintf( __( "Displays the url to the archive page of the current post author(s) if no attributes are provided or the url to the archive page of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_url/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_url/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_bio',
        'title'    => '[molongui_author_bio]',
        'desc'     => sprintf( __( "Displays the bio of the current post author(s) if no attributes are provided or the bio of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_bio/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_bio/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_mail',
        'title'    => '[molongui_author_mail]',
        'desc'     => sprintf( __( "Displays the email address of the current post author(s) if no attributes are provided or the email address of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_mail/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_mail/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_meta',
        'title'    => '[molongui_author_meta]',
        'desc'     => sprintf( __( "Displays the any author meta data of the current post author(s) if no attributes are provided or any author meta data of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_meta/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_meta/",
    );
    $options[] = array
    (
        'display'  => true,
        'advanced' => false,
        'deps'     => '',
        'search'   => '',
        'type'     => 'notice',
        'class'    => '',
        'default'  => '',
        'id'       => 'shortcode_molongui_author_avatar',
        'title'    => '[molongui_author_avatar]',
        'desc'     => sprintf( __( "Displays the avatar of the current post author(s) if no attributes are provided or the avatar of a given author if you provide the author ID and author type. %sLearn more%s", 'molongui-authorship' ), '<a href="https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_avatar/" target="_blank">', '</a>' ),
        'help'     => '',
        'link'     => "https://www.molongui.com/docs/molongui-authorship/shortcodes/molongui_author_avatar/",
    );
}