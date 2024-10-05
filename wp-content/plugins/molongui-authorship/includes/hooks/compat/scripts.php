<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_compat_scripts()
{
    $options = authorship_get_options();
    if ( empty( $options['hide_elements'] ) ) return;

    $selectors = $options['hide_elements'];
    $js = "if (window.jQuery) { var s='{$selectors}', match=s.split(', '); for (var a in match) {jQuery(match[a]).hide();} } else { console.error('MOLONGUI: jQuery not loaded. Can\'t hide anything!'); }";
    echo '<script type="text/javascript">'.$js.'</script>';
}
add_action( 'wp_footer', 'authorship_add_compat_scripts', PHP_INT_MAX );