<?php
defined( 'ABSPATH' ) or exit;
require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/compat/wordpress.php';
if ( apply_filters( 'authorship/plugin_compatibility', authorship_is_feature_enabled( 'plugin_compat' ) ) )
{
    if ( !function_exists( 'is_plugin_active' ) ) require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

    $path = MOLONGUI_AUTHORSHIP_DIR . 'includes/compat/plugins/';

    if ( is_plugin_active( 'advanced-access-manager/aam.php' ) ) require_once $path . 'advanced-access-manager.php';
    if ( is_plugin_active( 'anywhere-elementor/anywhere-elementor.php' ) or
         is_plugin_active( 'anywhere-elementor-pro/anywhere-elementor-pro.php' ) ) require_once $path . 'anywhere-elementor.php';
    if ( is_plugin_active( 'author-avatars/author-avatars.php' ) ) require_once $path . 'author-avatars.php';
    if ( is_plugin_active( 'authors-list/authors-list.php' ) ) require_once $path . 'authors-list.php';
    if ( is_plugin_active( 'bb-plugin/fl-builder.php' ) ) require_once $path . 'beaver-builder.php';
    if ( is_plugin_active( 'bb-theme-builder/bb-theme-builder.php' ) ) require_once $path . 'beaver-builder-theme-builder.php';
    if ( is_plugin_active( 'blog-designer/blog-designer.php' ) ) require_once $path . 'blog-designer.php';
    if ( is_plugin_active( 'buddyboss-platform/bp-loader.php' ) ) require_once $path . 'buddyboss-platform.php';
    if ( class_exists( 'BuddyPress' ) ) require_once $path . 'buddypress.php';
    if ( is_plugin_active( 'dp-divi-filtergrid/dp-divi-filtergrid.php' ) ) require_once $path . 'dp-divi-filtergrid.php';
    if ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) require_once $path . 'elementor-pro.php';
    if ( is_plugin_active( 'essential-grid/essential-grid.php' ) ) require_once $path . 'essential-grid.php';
    if ( is_plugin_active( 'events-manager/events-manager.php' ) ) require_once $path . 'events-manager.php';
    if ( is_plugin_active( 'google-sitemap-generator/sitemap.php' ) ) require_once $path . 'google-sitemap-generator.php';
    if ( is_plugin_active( 'hootkit/hootkit.php' ) ) require_once $path . 'hootkit.php';
    if ( is_plugin_active( 'jetpack/jetpack.php' ) ) require_once $path . 'jetpack.php';
    if ( is_plugin_active( 'sfwd-lms/sfwd_lms.php' ) ) require_once $path . 'learndash.php';
    if ( is_plugin_active( 'memberpress/memberpress.php' ) ) require_once $path . 'memberpress.php';
    if ( is_plugin_active( 'nimble-builder/nimble-builder.php' ) ) require_once $path . 'nimble-builder.php';
    if ( is_plugin_active( 'polylang/polylang.php' ) ) require_once $path . 'polylang.php';
    if ( is_plugin_active( 'post-grid/post-grid.php' ) ) require_once $path . 'post-grid.php';
    if ( is_plugin_active( 'premium-addons-for-elementor/premium-addons-for-elementor.php' ) ) require_once $path . 'premium-addons-for-elementor.php';
    if ( is_plugin_active( 'seo-by-rank-math/rank-math.php' ) ) require_once $path . 'rank-math-seo.php';
    if ( is_plugin_active( 'schema/schema.php' ) or
         is_plugin_active( 'schema-premium/schema-premium.php' ) ) require_once $path . 'schema.php';
    if ( is_plugin_active( 'schema-and-structured-data-for-wp/structured-data-for-wp.php' ) ) require_once $path . 'schema-and-structured-data-for-wp.php';
    if ( is_plugin_active( 'shortcodes-indep/init.php' ) ) require_once $path . 'shortcodes-indep.php';
    if ( is_plugin_active( 'td-cloud-library/td-cloud-library.php' ) ) require_once $path . 'td-cloud-library.php';
    if ( is_plugin_active( 'td-composer/td-composer.php' ) ) require_once $path . 'td-composer.php';
    if ( is_plugin_active( 'autodescription/autodescription.php' ) ) require_once $path . 'the-seo-framework.php';
    if ( is_plugin_active( 'ultimate-member/ultimate-member.php' ) ) require_once $path . 'ultimate-member.php';
    if ( is_plugin_active( 'userswp/userswp.php' ) ) require_once $path . 'userswp.php';
    if ( is_plugin_active( 'wordpress-popular-posts/wordpress-popular-posts.php' ) ) require_once $path . 'wordpress-popular-posts.php';
    if ( is_plugin_active( 'js_composer/js_composer.php' ) ) require_once $path . 'wpbakery-page-builder.php';
    if ( is_plugin_active( 'wpdiscuz/class.WpdiscuzCore.php' ) ) require_once $path . 'wpdiscuz.php';
    if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) require_once $path . 'wpml.php';
    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) or
         is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) require_once $path . 'yoast.php';
}
if ( apply_filters( 'authorship/theme_compatibility', authorship_is_feature_enabled( 'theme_compat' ) ) )
{
    $theme = wp_get_theme();

    $path = MOLONGUI_AUTHORSHIP_DIR . 'includes/compat/themes/';

    if     ( 'Astra' == $theme->name or 'Astra' == $theme->parent_theme )                           require_once $path . 'astra.php';
    elseif ( 'GeneratePress' == $theme->name or 'GeneratePress' == $theme->parent_theme )           require_once $path . 'generatepress.php';
    elseif ( 'Divi' == $theme->name or 'Divi' == $theme->parent_theme )                             require_once $path . 'divi.php';
    elseif ( 'Extra' == $theme->name or 'Extra' == $theme->parent_theme )                           require_once $path . 'extra.php';
    elseif ( 'The7' == $theme->name or 'The7' == $theme->parent_theme )                             require_once $path . 'the7.php';
    elseif ( 'Publisher' == $theme->name or 'Publisher' == $theme->parent_theme )                   require_once $path . 'publisher.php';
    elseif ( 'soledad' == $theme->name or 'soledad' == $theme->parent_theme )                       require_once $path . 'soledad.php';
    elseif ( 'Newspaper' == $theme->name or 'Newspaper' == $theme->parent_theme or
             'Newsmag'   == $theme->name or 'Newsmag'   == $theme->parent_theme )                   require_once $path . 'newspaper.php';
    elseif ( 'ColorMag' == $theme->name or 'ColorMag' == $theme->parent_theme )                     require_once $path . 'colormag.php';
    elseif ( 'Alea' == $theme->name or 'Alea' == $theme->parent_theme )                             require_once $path . 'alea.php';
    elseif ( 'JNews' == $theme->name or 'JNews' == $theme->parent_theme )                           require_once $path . 'jnews.php';
    elseif ( 'Agama' == $theme->name or 'Agama' == $theme->parent_theme )                           require_once $path . 'agama.php';
    elseif ( 'fruitful' == $theme->name or 'fruitful' == $theme->parent_theme )                     require_once $path . 'fruitful.php';
    elseif ( 'Jupiter' == $theme->name or 'Jupiter' == $theme->parent_theme )                       require_once $path . 'jupiter.php';
    elseif ( 'Magazine Prime Pro' == $theme->name or 'Magazine Prime Pro' == $theme->parent_theme ) require_once $path . 'magazine-prime-pro.php';
    elseif ( 'university' == $theme->name or 'university' == $theme->parent_theme )                 require_once $path . 'university.php';
    elseif ( 'Vellum' == $theme->name or 'Vellum' == $theme->parent_theme )                         require_once $path . 'vellum.php';
    elseif ( 'Bitz' == $theme->name or 'Bitz' == $theme->parent_theme )                             require_once $path . 'bitz.php';
    elseif ( 'Mundana' == $theme->name or 'Mundana' == $theme->parent_theme )                       require_once $path . 'mundana.php';
    elseif ( 'Genesis' == $theme->name or 'Genesis' == $theme->parent_theme )                       require_once $path . 'genesis.php';
    elseif ( 'Spotlight' == $theme->name or 'Spotlight' == $theme->parent_theme )                   require_once $path . 'spotlight.php';
    elseif ( 'Themify Ultra' == $theme->name or 'Themify Ultra' == $theme->parent_theme )           require_once $path . 'themify-ultra.php';
    elseif ( 'Flatsome' == $theme->name or 'Flatsome' == $theme->parent_theme )                     require_once $path . 'flatsome.php';
    elseif ( 'Blocksy' == $theme->name or 'Blocksy' == $theme->parent_theme )                       require_once $path . 'blocksy.php';
    elseif ( 'BuddyBoss Theme' == $theme->name or 'BuddyBoss Theme' == $theme->parent_theme )       require_once $path . 'buddyboss.php';
    elseif ( 'BuddyX' == $theme->name or 'BuddyX' == $theme->parent_theme )                         require_once $path . 'buddyx.php';
    elseif ( 'SmartMag' == $theme->name or 'SmartMag' == $theme->parent_theme )                     require_once $path . 'smart-mag.php';
    elseif ( 'Mission News' == $theme->name or 'Mission News' == $theme->parent_theme )             require_once $path . 'mission-news.php';
    elseif ( 'Creativo Theme' == $theme->name or 'Creativo Theme' == $theme->parent_theme )         require_once $path . 'creativo.php';
    elseif ( 'AdoreChurch' == $theme->name or 'AdoreChurch' == $theme->parent_theme )               require_once $path . 'adorechurch.php';
    elseif ( strpos( $theme->name, 'Dynamic News' ) !== false or strpos( $theme->parent_theme, 'Dynamic News' ) !== false ) require_once $path . 'dynamic-news.php';
    elseif ( 'Thrive Themes' == $theme->get( 'Author' ) or
           ( $theme->parent() and 'Thrive Themes' == $theme->parent()->get( 'Author' ) ) )          require_once $path . 'thrive-themes.php';
}