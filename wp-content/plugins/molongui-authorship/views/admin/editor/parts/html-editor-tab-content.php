<?php
defined( 'ABSPATH' ) or exit;

$header_templates = apply_filters( 'authorship/header_templates', array
(
    'header-template-1' => array
    (
        'label'    => __( "Header Template 1 — Default", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'header-template-2' => array
    (
        'label'    => __( "Header Template 2", 'molongui-authorship' ),
        'disabled' => true,
    ),
    'header-template-3' => array
    (
        'label'    => __( "Header Template 3", 'molongui-authorship' ),
        'disabled' => true,
    ),
    'header-template-4' => array
    (
        'label'    => __( "Header Template 4", 'molongui-authorship' ),
        'disabled' => true,
    ),
    'header-template-5' => array
    (
        'label'    => __( "Header Template 5", 'molongui-authorship' ),
        'disabled' => true,
    ),
    'header-template-6' => array
    (
        'label'    => __( "Header Template 6", 'molongui-authorship' ),
        'disabled' => true,
    ),
    'header-template-7' => array
    (
        'label'    => __( "Header Template 7", 'molongui-authorship' ),
        'disabled' => true,
    ),
    'header-template-8' => array
    (
        'label'    => __( "Header Template 8", 'molongui-authorship' ),
        'disabled' => true,
    ),
));

authorship_editor_heading( __( "Header", 'molongui-authorship' ) );
authorship_editor_input( 'author_box_header_title', __( "Custom title", 'molongui-authorship' ), array
    (
        'placeholder' => __( "About the author", 'molongui-authorship' ),
        'info-title'  => __( "Optional - A title for the author box", 'molongui-authorship' ),
        'info-desc'   => __( "Text to display above the author box as a header. Leave it blank to not show any title.", 'molongui-authorship' ),
        'info-tip'    => sprintf( __( "%sUse %s{author_name}%s (including curly brackets) in your string to dynamically display current author name. Replacement is done in the frontend.", 'molongui-authorship' ), '<strong>' . apply_filters( 'authorship/pro_tag', __( "Only PRO", 'molongui-authorship' ) . ' — '  ) . '</strong>', '<strong>', '</strong>' ),
        'info-more'   => '',
    )
);
authorship_editor_input( 'author_box_header_url', __( "Title URL", 'molongui-authorship' ), array
    (
        'info-title' => __( "Optional - URL to make the title link to", 'molongui-authorship' ),
        'info-desc'  => __( "Whether and where to make the author box title link to.", 'molongui-authorship' ),
        'info-tip'   => sprintf( __( "%sEnter %s{author_page}%s (including curly brackets) to link to the author page. Replacement is done in the frontend.", 'molongui-authorship' ), '<strong>' . apply_filters( 'authorship/pro_tag', __( "Only PRO", 'molongui-authorship' ) . ' — '  ) . '</strong>', '<strong>', '</strong>' ),
        'info-more'  => '',
        'parent'     => 'header',
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_header_bottom_space', __( "Bottom space (px)", 'molongui-authorship' ), array
    (
        'type'       => 'number',
        'default'    => 20,
        'info-title' => __( "Margin bottom", 'molongui-authorship' ),
        'info-desc'  => __( "Space in pixels to add below the title in order to separate it from the author box.", 'molongui-authorship' ),
        'info-tip'   => '',
        'info-more'  => '',
        'parent'     => 'header',
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_header_font_size', __( "Size (px)", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'parent' => 'header',
    )
);
authorship_editor_input( 'author_box_header_line_height', __( "Line height (px)", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'step'   => 1,
        'parent' => 'header',
    )
);
authorship_editor_select( 'author_box_header_font_weight', __( "Weight", 'molongui-authorship' ), authorship_font_weight(), array
    (
        'parent' => 'header',
    )
);
authorship_editor_select( 'author_box_header_text_transform', __( "Transform", 'molongui-authorship' ), authorship_text_transform(), array
    (
        'parent' => 'header',
    )
);
authorship_editor_select( 'author_box_header_font_style', __( "Style", 'molongui-authorship' ), authorship_font_style(), array
    (
        'parent' => 'header',
    )
);
authorship_editor_select( 'author_box_header_text_decoration', __( "Decoration", 'molongui-authorship' ), authorship_text_decoration(), array
    (
        'parent' => 'header',
    )
);
authorship_editor_select( 'author_box_header_text_align', __( "Alignment", 'molongui-authorship' ), authorship_text_align(), array
    (
        'parent' => 'header',
    )
);
authorship_editor_colorpicker( 'author_box_header_color', __( "Color", 'molongui-authorship' ), array
    (
        'parent' => 'header',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_header_tag', __( "HTML tag (SEO)", 'molongui-authorship' ), authorship_html_tags(), array
    (
        'default'    => 'h3',
        'info-title' => __( "The HTML tag for the author box title", 'molongui-authorship' ),
        'info-desc'  => __( "Selecting the HTML tag that best suits your strategy might improve your SEO.", 'molongui-authorship' ),
        'info-tip'   => '',
        'info-more'  => '',
        'parent'     => 'header',
    )
);

$avatar_source = array
(
    'local'    => __( "Local", 'molongui-authorship' ),
    'gravatar' => __( "Gravatar", 'molongui-authorship' ),
    'acronym'  => __( "Acronym", 'molongui-authorship' ),
);
$avatar_fallback = array
(
    'gravatar' => __( "Gravatar", 'molongui-authorship' ),
    'acronym'  => __( "Acronym", 'molongui-authorship' ),
    'none'     => __( 'None' ),
    );
$avatar_default = array
(
    'mp'        => __( "A simple, cartoon-style silhouetted outline of a person", 'molongui-authorship' ),
    'identicon' => __( "A geometric pattern based on an email hash", 'molongui-authorship' ),
    'monsterid' => __( "A generated 'monster' with different colors, faces, etc.", 'molongui-authorship' ),
    'wavatar'   => __( "A generated face with differing features and backgrounds", 'molongui-authorship' ),
    'retro'     => __( "A generated 8-bit arcade-style pixelated face", 'molongui-authorship' ),
    'robohash'  => __( "A generated robot with different colors, faces, etc.", 'molongui-authorship' ),
    'blank'     => __( "A transparent image", 'molongui-authorship' ),
    'random'    => __( "A random choice of the above", 'molongui-authorship' ),
);
$link = array
(
    'archive' => __( "Author page", 'molongui-authorship' ),
    'custom'  => __( "Custom URL", 'molongui-authorship' ),
    'none'    => __( "Don't link", 'molongui-authorship' ),
);

authorship_editor_heading( __( "Avatar", 'molongui-authorship' ) );
authorship_editor_select( 'author_box_avatar_show', __( "Show avatar", 'molongui-authorship' ), array( '1' => __( 'Show' ), '0' => __( 'Hide' ) ), array
    (
        'default' => '1',
    )
);
authorship_editor_select( 'author_box_avatar_source', __( "Source", 'molongui-authorship' ), $avatar_source, array
    (
        'default'    => 'local',
        'info-title' => __( "Author profile image source", 'molongui-authorship' ),
        'info-desc'  => __( "Whether to retrieve the image from local media library (uploaded file) or retrieve it from Gravatar.com. You can also let the plugin generate an image with author's name acronym instead.", 'molongui-authorship' ),
        'info-tip'   => __( "Molongui Authorship allows you to upload a custom image for your authors. No need to install any other third party plugin!", 'molongui-authorship' ),
        'info-more'  => '',
        'parent'     => 'avatar',
    )
);
authorship_editor_select( 'author_box_avatar_fallback', __( "Fallback", 'molongui-authorship' ), $avatar_fallback, array
    (
        'default'    => 'gravatar',
        'info-title' => __( "What to display if no custom avatar available?", 'molongui-authorship' ),
        'info-desc'  => __( "Local avatars require you to upload an image for each author. You can do so from the edit author screen. With this setting you can control what to display if no local image is available.", 'molongui-authorship' ),
        'info-tip'   => __( "'None' option hides and removes the image area from the box layout! Pick 'Gravatar' and use the 'Transparent image' option from the 'Default Gravatar' setting to take up image's space on the box.", 'molongui-authorship' ),
        'info-more'  => '',
        'parent'     => 'avatar',
    )
);
authorship_editor_select( 'author_box_avatar_default_gravatar', __( "Default Gravatar", 'molongui-authorship' ), $avatar_default, array
    (
        'default'    => 'mp',
        'info-title' => __( "What to display if no gravatar configured?", 'molongui-authorship' ),
        'info-desc'  => __( "You need to set up a Gravatar.com account and upload an image there in order to have a gravatar. Most authors do not have a Gravatar.com account. This setting allows you to control what to display when in such cases.", 'molongui-authorship' ),
        'info-tip'   => __( "Use the 'Local' option for the 'Source' setting in order to load the image configured in your authors profile.", 'molongui-authorship' ),
        'info-more'  => '',
        'parent'     => 'avatar',
    )
);
authorship_editor_colorpicker( 'author_box_avatar_background_color', __( "Background color", 'molongui-authorship' ), array
    (
        'default' => '#1d2327',
        'parent'  => 'avatar',
    )
);
authorship_editor_colorpicker( 'author_box_avatar_color', __( "Color", 'molongui-authorship' ), array
    (
        'default' => '#dd9933',
        'parent'  => 'avatar',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_avatar_border_style', __( "Border style", 'molongui-authorship' ), authorship_border_style(), array
    (
        'default' => 'none',
        'parent'  => 'avatar',
    )
);
authorship_editor_input( 'author_box_avatar_border_width', __( "Border width", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'min'         => 0,
        'default'     => 0,
        'placeholder' => '0',
        'parent'      => 'avatar',
    )
);
authorship_editor_colorpicker( 'author_box_avatar_border_color', __( "Border color", 'molongui-authorship' ), array
    (
        'parent'  => 'avatar',
    )
);
authorship_editor_input( 'author_box_avatar_border_radius', __( "Border radius (%)", 'molongui-authorship' ), array
    (

        'type'        => 'range',
        'min'         => 0,
        'max'         => 100,
        'default'     => '',
        'placeholder' => '0',
        'parent'      => 'avatar',
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_avatar_width', __( "Width", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'placeholder' => '150',
        'default'     => 150,
        'min'         => 0,
        'info-title'  => __( "Avatar image width", 'molongui-authorship' ),
        'info-desc'   => __( "Avatar image width in pixels. If bigger than actual image's width, image's width is taken. Square images take the lower value from given size values (width and height).", 'molongui-authorship' ),
        'info-tip'    => __( "If you change this setting, you'll probably need to regenerate your thumbnails.", 'molongui-authorship' ),
        'info-more'   => '',
        'parent'      => 'avatar',
    )
);
authorship_editor_input( 'author_box_avatar_height', __( "Height", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'placeholder' => '150',
        'default'     => 150,
        'min'         => 0,
        'info-title'  => __( "Avatar image height", 'molongui-authorship' ),
        'info-desc'   => __( "Avatar image height in pixels. If bigger than actual image's height, image's height is taken. Square images take the lower value from given size values (width and height).", 'molongui-authorship' ),
        'info-tip'    => __( "If you change this setting, you'll probably need to regenerate your thumbnails.", 'molongui-authorship' ),
        'info-more'   => '',
        'parent'      => 'avatar',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_avatar_link', __( "Link", 'molongui-authorship' ), $link, array
    (
        'default'    => 'archive',
        'info-title' => __( "Whether to make the avatar a link", 'molongui-authorship' ),
        'info-desc'  => __( "You can make the author profile image in the author box link to a page listing all posts by the author (Author page) or to the author's website (Custom URL). You can also disable the link.", 'molongui-authorship' ),
        'info-tip'   => __( "Regardless of this setting, the author avatar might not become a link. i.e. When author archive pages are disabled.", 'molongui-authorship' ),
        'info-more'  => '',
        'parent'     => 'avatar',
    )
);

$name_underline = array( 'keep' => __( "Keep it", 'molongui-authorship' ), 'remove' => __( "Remove it", 'molongui-authorship' ) );

authorship_editor_heading( __( "Author Name", 'molongui-authorship' ) );
authorship_editor_input( 'author_box_name_font_size', __( "Size (px)", 'molongui-authorship' ), array
    (
        'type'        => 'number',
        'min'         => 0,
        'default'     => 22,
        'placeholder' => '22',
    )
);
authorship_editor_input( 'author_box_name_line_height', __( "Line height (px)", 'molongui-authorship' ), array
    (
        'type' => 'number',
        'min'  => 0,
        'step' => 1,
    )
);
authorship_editor_select( 'author_box_name_font_weight', __( "Weight", 'molongui-authorship' ), authorship_font_weight() );
authorship_editor_select( 'author_box_name_text_transform', __( "Transform", 'molongui-authorship' ), authorship_text_transform() );
authorship_editor_select( 'author_box_name_font_style', __( "Style", 'molongui-authorship' ), authorship_font_style() );
authorship_editor_select( 'author_box_name_text_decoration', __( "Decoration", 'molongui-authorship' ), authorship_text_decoration() );
authorship_editor_select( 'author_box_name_text_align', __( "Alignment", 'molongui-authorship' ), authorship_text_align() );
authorship_editor_colorpicker( 'author_box_name_color', __( "Color", 'molongui-authorship' ) );
authorship_editor_separator();
authorship_editor_select( 'author_box_name_link', __( "Link", 'molongui-authorship' ), $link, array
    (
        'default'    => 'archive',
        'info-title' => __( "Whether to make the author name a link", 'molongui-authorship' ),
        'info-desc'  => __( "You can make the author name in the author box link to a page listing all posts by the author (Author page) or to the author's website (Custom URL). You can also disable the link.", 'molongui-authorship' ),
        'info-tip'   => __( "Regardless of this setting, the author name might not become a link. i.e. When author archive pages are disabled.", 'molongui-authorship' ),
        'info-more'  => '',
    )
);
authorship_editor_select( 'author_box_name_underline', __( "Inherited underline", 'molongui-authorship' ), $name_underline, array
    (
        'default'    => 'keep',
        'info-title' => __( "Default underline", 'molongui-authorship' ),
        'info-desc'  => __( "You can use this setting if the 'Decoration' setting above is not working as expected. Use the 'Remove it' option to (try to) remove the underline added by your theme or any other third plugin.", 'molongui-authorship' ),
        'info-tip'   => '',
        'info-more'  => '',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_name_tag', __( "HTML tag (SEO)", 'molongui-authorship' ), authorship_html_tags(), array
    (
        'default'    => 'h5',
        'info-title' => __( "The HTML tag for the author name", 'molongui-authorship' ),
        'info-desc'  => __( "Selecting the HTML tag that best suits your strategy might improve your SEO.", 'molongui-authorship' ),
        'info-tip'   => '',
        'info-more'  => '',
    )
);

$meta_divider = array
(
    '|'  => __( '|' ),  // pipe
    '||' => __( '||' ), // double pipe
    '/'  => __( '/' ),  // slash
    '//' => __( '//' ), // double slash
    '-'  => __( '–' ),  // hyphen
    '--' => __( '--' ), // double hyphen
    '–'  => __( '–' ),  // ndash
    '·'  => __( '·' ),  // sdot
    '•'  => __( '•' ),  // bullet
    '>'  => __( '>' ),  // rsaquo
    '>>' => __( '>>' ), // double rsaquo
    '~'  => __( '~' ),  // tilde
    '*'  => __( '*' ),  // asterisk
    '⇄'  => __( '⇄' ), // arrows
    '⊥'  => __( '⊥' ), // uptack
    '⋄'  => __( '⋄' ),  // diamond
    '<br>' => __( 'Line break', 'molongui-authorship' ),
);

authorship_editor_heading( __( "Meta Info", 'molongui-authorship' ) );
authorship_editor_separator();
authorship_editor_select( 'author_box_meta_show', __( "Show meta info", 'molongui-authorship' ), array( '1' => __( 'Show' ), '0' => __( 'Hide' ) ), array
    (
        'default'    => '1',
        'info-title' => __( "Author meta info", 'molongui-authorship' ),
        'info-desc'  => __( "Whether to show additional author information, like job position, company, website...", 'molongui-authorship' ),
        'info-tip'   => '',
        'info-more'  => '',
    )
);
authorship_editor_input( 'author_box_meta_font_size', __( "Size (px)", 'molongui-authorship' ), array
    (
        'type'    => 'number',
        'min'    => 0,
        'parent' => 'meta',
    )
);
authorship_editor_input( 'author_box_meta_line_height', __( "Line height (px)", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'step'   => 1,
        'parent' => 'meta',
    )
);
authorship_editor_select( 'author_box_meta_font_weight', __( "Weight", 'molongui-authorship' ), authorship_font_weight(), array
    (
        'parent' => 'meta',
    )
);
authorship_editor_select( 'author_box_meta_text_transform', __( "Transform", 'molongui-authorship' ), authorship_text_transform(), array
    (
        'parent' => 'meta',
    )
);
authorship_editor_select( 'author_box_meta_font_style', __( "Style", 'molongui-authorship' ), authorship_font_style(), array
    (
        'parent' => 'meta',
    )
);
authorship_editor_select( 'author_box_meta_text_decoration', __( "Decoration", 'molongui-authorship' ), authorship_text_decoration(), array
    (
        'parent' => 'meta',
    )
);
authorship_editor_select( 'author_box_meta_text_align', __( "Alignment", 'molongui-authorship' ), authorship_text_align(), array
    (
        'parent' => 'meta',
    )
);
authorship_editor_colorpicker( 'author_box_meta_color', __( "Color", 'molongui-authorship' ), array
    (
        'parent' => 'meta',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_meta_divider', __( "Divider", 'molongui-authorship' ), $meta_divider, array
    (
        'default'    => '|',
        'info-title' => __( "Author meta data separator", 'molongui-authorship' ),
        'info-desc'  => __( "Character used to separate author meta data information", 'molongui-authorship' ),
        'info-tip'   => '',
        'info-more'  => '',
        'parent'     => 'meta',
    )
);
authorship_editor_input( 'author_box_meta_divider_spacing', __( "Divider spacing", 'molongui-authorship' ), array
    (
        'type'    => 'number',
        'min'     => 0,
        'step'    => 0.1,
        'default' => 0.2,
        'parent'  => 'meta',
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_meta_at', __( "\"at\" text", 'molongui-authorship' ), array
    (
        'placeholder' => __( "at", 'molongui-authorship' ),
        'default'     => __( "at", 'molongui-authorship' ),
        'info-title'  => '',
        'info-desc'   => __( "Text to show between author's job position and company.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
        'parent'      => 'meta',
    )
);
authorship_editor_input( 'author_box_meta_web', __( "\"Website\" text", 'molongui-authorship' ), array
    (
        'placeholder' => __( "Website", 'molongui-authorship' ),
        'default'     => __( "Website", 'molongui-authorship' ),
        'info-title'  => '',
        'info-desc'   => __( "Text to show as link name to author's personal website.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
        'parent'      => 'meta',
    )
);
authorship_editor_input( 'author_box_meta_posts', __( "\"More Posts\" text", 'molongui-authorship' ), array
    (
        'placeholder' => __( "+ posts", 'molongui-authorship' ),
        'default'     => __( "+ posts", 'molongui-authorship' ),
        'info-title'  => '',
        'info-desc'   => __( "Text to show as toggle button to display author's related posts when displaying author bio.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
        'parent'      => 'meta',
    )
);
authorship_editor_input( 'author_box_meta_bio', __( "\"Bio\" text", 'molongui-authorship' ), array
    (
        'placeholder' => __( "Bio", 'molongui-authorship' ),
        'default'     => __( "Bio", 'molongui-authorship' ),
        'info-title'  => '',
        'info-desc'   => __( "Text to show as toggle button to display author's bio when displaying related posts.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
        'parent'      => 'meta',
    )
);

$bio_source = array
(
    'full' => array
    (
        'label'    => __( "Full bio", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'short' => array
    (
        'label'    => __( "Short bio", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'none' => array
    (
        'label'    => __( "None — Don't show", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
);

authorship_editor_heading( __( "Author Bio", 'molongui-authorship' ) );
authorship_editor_select( 'author_box_bio_source', __( "Source", 'molongui-authorship' ), $bio_source, array
    (
        'default'    => 'full',
        'info-title' => __( "Author bio", 'molongui-authorship' ),
        'info-desc'  => __( "You can control whether to display full or short author bio in the author box. Pick 'None' to not display author bio.", 'molongui-authorship' ),
        'info-tip'   => __( "The short bio option is useful to keep author boxes slim. Full bio will be always displayed on author archive pages if your theme supports it.", 'molongui-authorship' ),
        'info-more'  => '',
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_bio_font_size', __( "Text size", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'parent' => 'bio',
    )
);
authorship_editor_input( 'author_box_bio_line_height', __( "Line height (px)", 'molongui-authorship' ), array
(
        'type'   => 'number',
        'min'    => 0,
        'step'   => 1,
        'parent' => 'bio',
    )
);
authorship_editor_select( 'author_box_bio_font_weight', __( "Font weight", 'molongui-authorship' ), authorship_font_weight(), array
    (
        'parent' => 'bio',
    )
);
authorship_editor_select( 'author_box_bio_text_transform', __( "Text transform", 'molongui-authorship' ), authorship_text_transform(), array
    (
        'parent' => 'bio',
    )
);
authorship_editor_select( 'author_box_bio_font_style', __( "Text style", 'molongui-authorship' ), authorship_font_style(), array
    (
        'parent' => 'bio',
    )
);
authorship_editor_select( 'author_box_bio_text_decoration', __( "Text decoration", 'molongui-authorship' ), authorship_text_decoration(), array
    (
        'parent' => 'bio',
    )
);
authorship_editor_select( 'author_box_bio_text_align', __( "Text alignment", 'molongui-authorship' ), authorship_text_align(), array
    (
        'parent' => 'bio',
    )
);
authorship_editor_colorpicker( 'author_box_bio_color', __( "Font color", 'molongui-authorship' ), array
    (
        'parent' => 'bio',
    )
);

$social_style = array
(
    'default'                 => __( "Default", 'molongui-authorship' ),
    'squared'                 => __( "Squared", 'molongui-authorship' ),
    'circled'                 => __( "Circled", 'molongui-authorship' ),
    'boxed'                   => __( "Boxed", 'molongui-authorship' ),
    'branded'                 => __( "Branded", 'molongui-authorship' ),
    'branded-squared'         => __( "Branded squared", 'molongui-authorship' ),
    'branded-squared-reverse' => __( "Branded squared reverse", 'molongui-authorship' ),
    'branded-circled'         => __( "Branded circled", 'molongui-authorship' ),
    'branded-circled-reverse' => __( "Branded circled reverse", 'molongui-authorship' ),
    'branded-boxed'           => __( "Branded boxed", 'molongui-authorship' ),
);

authorship_editor_heading( __( "Social Icons", 'molongui-authorship' ) );
authorship_editor_select( 'author_box_social_show', __( "Show social icons", 'molongui-authorship' ), array( '1' => __( 'Show' ), '0' => __( 'Hide' ) ), array
    (
        'default' => '1',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_social_style', __( "Style", 'molongui-authorship' ), $social_style, array
    (
        'default' => 'layout-1',
        'parent'  => 'social',
    )
);
authorship_editor_input( 'author_box_social_font_size', __( "Size (px)", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'parent' => 'social',
    )
);
authorship_editor_colorpicker( 'author_box_social_color', __( "Color", 'molongui-authorship' ), array
    (
        'default' => '#ffffff',
        'parent'  => 'social',
    )
);
authorship_editor_separator();
authorship_editor_input( 'author_box_social_target', __( "Open in a new tab", 'molongui-authorship' ), array
    (
        'type'    => 'checkbox',
        'default' => 1,
        'parent'  => 'social' ,
    )
);

$related_layouts = apply_filters( 'authorship/profile_layouts', array
(
    'layout-1' => array
    (
        'label'    => __( "Related Template 1 — Default", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'layout-2' => array
    (
        'label'    => __( "Related Template 2", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'layout-3' => array
    (
        'label'    => __( "Related Template 3", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
));
$related_orderby = array
(
    'date' => array
    (
        'label'    => __( "Date", 'molongui-authorship' ),
        'disabled' => false,
    ),
    'modified' => array
    (
        'label'    => __( "Modified date", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'title' => array
    (
        'label'    => __( "Title", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'comment_count' => array
    (
        'label'    => __( "Number of comments", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
    'rand' => array
    (
        'label'    => __( "Random order", 'molongui-authorship' ) . apply_filters( 'authorship/pro_tag', ' — ' . __( "Only PRO", 'molongui-authorship' ) ),
        'disabled' => false,
    ),
);

authorship_editor_heading( __( "Related Posts", 'molongui-authorship' ) );
authorship_editor_select( 'author_box_related_show', __( "Show related posts", 'molongui-authorship' ), array( '1' => __( 'Show' ), '0' => __( 'Hide' ) ), array
    (
        'default'     => '1',
        'info-title'  => __( "Related posts", 'molongui-authorship' ),
        'info-desc'   => __( "Whether to display related posts by the same author within the author box.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
    )
);
authorship_editor_input( 'author_box_related_empty', __( "Show even if no related", 'molongui-authorship' ), array
    (
        'type'        => 'checkbox',
        'default'     => 0,
        'info-title'  => '',
        'info-desc'   => __( "Whether to display the related posts section even if there are no related entries to list.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
        'parent'      => 'related',
    )
);
authorship_editor_input( 'author_box_related_none', __( "No more posts message", 'molongui-authorship' ), array
    (
        'placeholder' => __( "This author does not have any more posts.", 'molongui-authorship' ),
        'default'     => __( "This author does not have any more posts.", 'molongui-authorship' ),
        'info-title'  => '',
        'info-desc'   => __( "Text to display when no related entries are found.", 'molongui-authorship' ),
        'info-tip'    => '',
        'info-more'   => '',
        'parent'      => 'related',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_related_layout', __( "Template", 'molongui-authorship' ), $related_layouts, array
    (
        'default' => 'layout-1',
        'parent'  => 'related',
    )
);
authorship_editor_input( 'author_box_related_columns', __( "Columns", 'molongui-authorship' ), array
    (
        'type'    => 'number',
        'min'     => 1,
        'default' => 3,
        'parent'  => 'related',
    )
);
authorship_editor_input( 'author_box_related_columns_gap', __( "Columns gap (px)", 'molongui-authorship' ), array
    (
        'type'    => 'number',
        'min'     => 0,
        'default' => 20,
        'parent'  => 'related',
    )
);
authorship_editor_separator();
authorship_editor_select( 'author_box_related_orderby', __( "Order by", 'molongui-authorship' ), $related_orderby, array
    (
        'default' => 'date',
        'parent'  => 'related',
    )
);
authorship_editor_select( 'author_box_related_order', __( "Order", 'molongui-authorship' ), authorship_query_order(), array
    (
        'default' => 'DESC',
        'parent'  => 'related',
    )
);
authorship_editor_input( 'author_box_related_count', __( "Posts to show", 'molongui-authorship' ), array
    (
        'type'    => 'number',
        'min'     => 0,
        'default' => 4,
        'parent'  => 'related',
    )
);
authorship_editor_notice( 'related_post_types', sprintf( __( "Which post types to retrieve as related can be configured on the %splugin settings page%s", 'molongui-authorship' ), '<a href="'.authorship_options_url( 'author-box' ).'" target="_blank">', '</a>' ) );
authorship_editor_separator();
authorship_editor_input( 'author_box_related_font_size', __( "Size (px)", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'parent' => 'related',
    )
);
authorship_editor_input( 'author_box_related_line_height', __( "Line height (px)", 'molongui-authorship' ), array
    (
        'type'   => 'number',
        'min'    => 0,
        'step'   => 1,
        'parent' => 'related',
    )
);
authorship_editor_select( 'author_box_related_font_weight', __( "Weight", 'molongui-authorship' ), authorship_font_weight(), array
    (
        'parent' => 'related',
    )
);
authorship_editor_select( 'author_box_related_text_transform', __( "Transform", 'molongui-authorship' ), authorship_text_transform(), array
    (
        'parent' => 'related',
    )
);
authorship_editor_select( 'author_box_related_font_style', __( "Style", 'molongui-authorship' ), authorship_font_style(), array
    (
        'parent' => 'related',
    )
);
authorship_editor_select( 'author_box_related_text_decoration', __( "Decoration", 'molongui-authorship' ), authorship_text_decoration(), array
    (
        'parent' => 'related',
    )
);
authorship_editor_select( 'author_box_related_text_align', __( "Alignment", 'molongui-authorship' ), authorship_text_align(), array
    (
        'parent' => 'related',
    )
);
authorship_editor_colorpicker( 'author_box_related_color', __( "Color", 'molongui-authorship' ), array
    (
        'parent' => 'related',
    )
);