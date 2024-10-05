<?php
defined( 'ABSPATH' ) or exit;

if ( file_exists( $file = MOLONGUI_AUTHORSHIP_DIR . 'config/tools.php' ) ) include $file;
if ( file_exists( $file = MOLONGUI_AUTHORSHIP_DIR . 'config/common/tools.php' ) ) include $file;
$tools = array_merge_recursive( isset( $tools ) ? $tools : array(), isset( $fw_tools ) ? $fw_tools : array() );

?>

<div class="molongui-authorship-tools">
    <?php
    $args = array
    (
        'logo'   => MOLONGUI_AUTHORSHIP_URL . 'assets/img/plugin_logo.png',
        'link'   => MOLONGUI_AUTHORSHIP_WEB,
        'button' => null,
    );
    include MOLONGUI_AUTHORSHIP_DIR . 'views/common/parts/html-part-masthead.php';
    ?>

    <div class="m-page-content">

        <?php foreach ( $tools as $tool )
        {
            echo new \Molongui\Authorship\Includes\Libraries\Common\Option( $tool, '', '', MOLONGUI_AUTHORSHIP_PREFIX.'_' );
        } ?>

    </div><!-- !m-page-content -->

    <?php

    $args = authorship_options_footer();
    include  MOLONGUI_AUTHORSHIP_DIR . 'views/common/parts/html-part-footer.php';

    authorship_enqueue_common_options_styles();
    authorship_enqueue_common_options_scripts();
    authorship_enqueue_options_scripts();

    ?>

</div><!-- !molongui-authorship-tools -->