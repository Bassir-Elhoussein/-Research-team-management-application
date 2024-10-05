<?php
defined( 'ABSPATH' ) or exit;

$box_layouts = apply_filters( 'authorship/box_layouts', array
(
    'slim'    => array
    (
        'label'    => __( "Slim", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'tabbed'  => array
    (
        'label'    => __( "Tabbed", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'stacked' => array
    (
        'label'    => __( "Stacked", 'molongui-authorship' ),
        'disabled' => false,
    )
));
$profile_layouts = apply_filters( 'authorship/profile_layouts', array
(
    'layout-1' => array
    (
        'label'    => __( "Profile Template 1 — Default", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'layout-2' => array
    (
        'label'    => __( "Profile Template 2", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'layout-3' => array
    (
        'label'    => __( "Profile Template 3", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'layout-4' => array
    (
        'label'    => __( "Profile Template 4", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'layout-5' => array
    (
        'label'    => __( "Profile Template 5", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'layout-6' => array
    (
        'label'    => __( "Profile Template 6", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'layout-7' => array
    (
        'label'    => __( "Profile Template 7", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'layout-8' => array
    (
        'label'    => __( "Profile Template 8", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
));

authorship_editor_heading( __( "Author Box", 'molongui-authorship' ) );
authorship_editor_spacing( 'author_box_' );
authorship_editor_select( 'author_box_border_style', __( "Border style", 'molongui-authorship' ), authorship_border_style(), array
    (
        'default' => 'none',
    )
);
authorship_editor_colorpicker( 'author_box_border_color', __( "Border color", 'molongui-authorship' ) );
authorship_editor_input( 'author_box_border_radius', __( "Border radius (px)", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'default'     => 0,
        'placeholder' => '0',
        'min'         => 0,
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_width', __( "Width (%)", 'molongui-authorship' ), array
    (
        'type'        => 'range',
        'min'         => 0,
        'max'         => '100',
        'default'     => 100,
        'placeholder' => '100',
        'info-title'  => __( "Author box width", 'molongui-authorship' ),
        'info-desc'   => __( "Amount of space relative to the parent element the author box can take.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
    )
);
authorship_editor_separator();
authorship_editor_colorpicker( 'author_box_background_color', __( "Background color", 'molongui-authorship' ) );
authorship_editor_separator();
authorship_editor_select( 'author_box_layout', __( "Layout", 'molongui-authorship' ), $box_layouts, array
    (
        'default' => 'slim',
    )
);
authorship_editor_input( 'author_box_profile_title', __( "\"Author Profile\" text", 'molongui-authorship' ), array
    (
        'placeholder' => __( "Author Profile", 'molongui-authorship' ),
        'info-title'  => __( "Author profile section title", 'molongui-authorship' ),
        'info-desc'   => __( "Text to display for the author profile section. Leave it blank to not show any title.", 'molongui-authorship' ),
        'info-tip'    => sprintf( __( "%sUse %s{author_name}%s (including curly brackets) in your string to dynamically display current author name. Replacement is done in the frontend.", 'molongui-authorship' ), '<strong>' . apply_filters( 'authorship/pro_tag', __( "Only PRO", 'molongui-authorship' ) . ' — '  ) . '</strong>', '<strong>', '</strong>' ),
        'info-more'   => '',
    )
);
authorship_editor_input( 'author_box_related_title', __( "\"Related Posts\" text", 'molongui-authorship' ), array
    (
        'placeholder' => __( "Related Posts", 'molongui-authorship' ),
        'info-title'  => __( "Related posts section title", 'molongui-authorship' ),
        'info-desc'   => __( "Text to display for the related posts section. Leave it blank to not show any title.", 'molongui-authorship' ),
        'info-tip'    => sprintf( __( "%sUse %s{author_name}%s (including curly brackets) in your string to dynamically display current author name. Replacement is done in the frontend.", 'molongui-authorship' ), '<strong>' . apply_filters( 'authorship/pro_tag', __( "Only PRO", 'molongui-authorship' ) . ' — '  ) . '</strong>', '<strong>', '</strong>' ),
        'info-more'   => '',
    )
);
authorship_editor_select( 'author_box_profile_layout', __( "Template", 'molongui-authorship' ), $profile_layouts, array
    (
        'default' => 'layout-1',
    )
);
authorship_editor_select( 'author_box_profile_valign', __( "Vertical align", 'molongui-authorship' ), array( 'flex-start' => __( "Top", 'molongui-authorship' ), 'center' => __( "Center", 'molongui-authorship' ), 'flex-end' => __( "Bottom", 'molongui-authorship' ) ), array
    (
        'default'     => 'center',
        'info-title'  => __( "Content vertical alignment", 'molongui-authorship' ),
        'info-desc'   => __( "You can control how to vertically align author box content with this setting.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
    )
);
authorship_editor_separator();
authorship_editor_colorpicker( 'author_box_bottom_background_color', __( "Bottom background color", 'molongui-authorship' ), array
    (
        'default' => '#e0e0e0',
    )
);
authorship_editor_select( 'author_box_bottom_border_style', __( "Bottom border style", 'molongui-authorship' ), authorship_border_style(), array
    (
        'default' => 'none',
    )
);
authorship_editor_input( 'author_box_bottom_border_width', __( "Bottom border width (px)", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'min'         => 0,
        'default'     => 0,
        'placeholder' => '0',
    )
);
authorship_editor_colorpicker( 'author_box_bottom_border_color', __( "Bottom border color", 'molongui-authorship' ), array
    (
        'default' => '#b6b6b6' )
);
authorship_editor_notice( 'box_position', sprintf( __( "Where to display the author box can be configured on the %splugin settings page%s", 'molongui-authorship' ), '<a href="'.authorship_options_url().'" target="_blank">', '</a>' ) );
authorship_editor_separator();
authorship_editor_colorpicker( 'author_box_shadow_color', __( "Shadow color", 'molongui-authorship' ), array
    (
        'default' => '#ababab',
    )
);
authorship_editor_input( 'author_box_shadow_h_offset', __( "Shadow horizontal offset", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'default'     => 10,
        'placeholder' => '10',
    )
);
authorship_editor_input( 'author_box_shadow_v_offset', __( "Shadow vertical offset", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'default'     => 10,
        'placeholder' => '10',
    )
);
authorship_editor_input( 'author_box_shadow_blur', __( "Shadow blur", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'default'     => 0,
        'placeholder' => '0',
    )
);
authorship_editor_input( 'author_box_shadow_spread', __( "Shadow spread", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'default'     => 0,
        'placeholder' => '0',
    )
);
authorship_editor_input( 'author_box_shadow_inset', __( "Inner shadow", 'molongui-authorship' ), array
    (
        'type'    => 'checkbox',
        'default' => 0,
    )
);

authorship_editor_heading( __( "Tabs", 'molongui-authorship' ) );
authorship_editor_notice( 'tabs', sprintf( __( "Tabs settings apply only if you pick the %sTabbed%s box layout. So they are now are disabled.", 'molongui-authorship' ), '<span style="font-weight:700">', '</span>' ) );
authorship_editor_select( 'author_box_tabs_position', __( "Position", 'molongui-authorship' ), array( 'top-full' => __( "Top-Full", 'molongui-authorship' ), 'top-left' => __( "Top-Left", 'molongui-authorship' ), 'top-center' => __( "Top-Center", 'molongui-authorship' ), 'top-right' => __( "Top-Right", 'molongui-authorship' ), ), array
    (
        'default' => 'top-full',
    )
);
authorship_editor_separator();
authorship_editor_colorpicker( 'author_box_tabs_color', __( "Tabs color", 'molongui-authorship' ) );
authorship_editor_colorpicker( 'author_box_tabs_background_color', __( "Background color", 'molongui-authorship' ) );
authorship_editor_colorpicker( 'author_box_tabs_text_color', __( "Text color", 'molongui-authorship' ) );
authorship_editor_separator();
authorship_editor_colorpicker( 'author_box_tabs_active_background_color', __( "Active tab color", 'molongui-authorship' ) );
authorship_editor_colorpicker( 'author_box_tabs_active_text_color', __( "Active tab text color", 'molongui-authorship' ) );
authorship_editor_select( 'author_box_tabs_active_border', __( "Active tab border", 'molongui-authorship' ), array( 'none' => __( "None", 'molongui-authorship' ), 'around'=> __( "Around", 'molongui-authorship' ), 'top' => __( "Top", 'molongui-authorship' ), 'topline' => __( "Top + line", 'molongui-authorship' ), 'bottom' =>__( "Bottom", 'molongui-authorship' ) ), array
    (
        'default' => 'none',
    )
);
authorship_editor_select( 'author_box_tabs_active_border_style', __( "Active tab border style", 'molongui-authorship' ), authorship_border_style(), array
    (
        'default' => 'none',
    )
);
authorship_editor_input( 'author_box_tabs_active_border_width', __( "Active tab border width (px)", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'min'         => 0,
        'default'     => 4,
        'placeholder' => '0',
    )
);
authorship_editor_colorpicker( 'author_box_tabs_active_border_color', __( "Active tab border color", 'molongui-authorship' ), array
    (
        'default' => '#ffa500',
    )
);
