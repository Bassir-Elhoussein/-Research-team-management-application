<?php
defined( 'ABSPATH' ) or exit;

define( 'MOLONGUI_AUTHORSHIP_IS_EDITOR', true );

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>

<div class="molongui-authorship-editor">
    <?php
    $args = array
    (
        'logo'   => MOLONGUI_AUTHORSHIP_URL . 'assets/img/plugin_logo.png',
        'link'   => MOLONGUI_AUTHORSHIP_WEB,
        'button' => array
        (
            'id'    => 'm-button-save',
            'class' => 'm-button-save',
            'label' => __( "Save Settings", 'molongui-authorship' ),
        ),
    );
    include MOLONGUI_AUTHORSHIP_DIR . 'views/common/parts/html-part-masthead.php';
    ?>

    <div class="m-page-content">

        <div class="m-editor-container">

            <div id="m-editor-property-info">
                <div class="m-editor-property-info__arrow"></div>
                <div class="m-editor-property-info__inner">
                    <div class="m-editor-property-info__title"></div>
                    <div class="m-editor-property-info__desc"></div>
                    <div class="m-editor-property-info__tip"></div>
                    <div class="m-editor-property-info__more"></div>
                </div>
            </div>

            <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/editor/html-editor-controls.php'; ?>

            <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/editor/html-editor-preview.php'; ?>

        </div>

    </div><!-- !m-page-content -->

    <script id="m-editor-js-extra">
        var m_editor = {"url":"<?php echo authorship_editor_url(); ?>",
                        "nonce":"<?php echo wp_create_nonce( 'authorship_box_editor_nonce' ); ?>",
                        "learn_more":"<?php _e( "Learn more", 'molongui-authorship' ); ?>",
                        "premium_warnings":"<?php echo apply_filters( 'authorship/editor/show_premium_warnings', true ); ?>",
                        "author_error":"<?php _e( "Something went wrong and the author box cannot be previewed for the selected author. Please save changes and refresh the page.", 'molongui-authorship' ); ?>"
        };
    </script>

    <?php

    $args = authorship_options_footer();
    include  MOLONGUI_AUTHORSHIP_DIR . 'views/common/parts/html-part-footer.php';

    authorship_enqueue_common_options_styles();
    authorship_enqueue_editor_styles();
    authorship_enqueue_editor_scripts();

    ?>

</div><!-- !molongui-authorship-editor -->

<div id="m-options-saving"><div class="m-loader"><div></div><div></div><div></div><div></div></div></div>
<div id="m-options-saved"><span class="dashicons dashicons-yes"></span><strong><?php echo __( "Saved", 'molongui-authorship' ); ?></strong></div>
<div id="m-options-error"><span class="dashicons dashicons-no"></span><strong><?php echo __( "Error", 'molongui-authorship' ); ?></strong></div>