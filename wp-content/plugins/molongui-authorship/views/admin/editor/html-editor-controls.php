<?php
defined( 'ABSPATH' ) or exit;

?>

<div class="m-editor-controls">

    <div class="m-editor-controls__header">
        <?php _e( "Author Box Editor", 'molongui-authorship' ); ?>
    </div>

    <input id="tab1" type="radio" name="m-editor-tab" checked="checked">
    <input id="tab2" type="radio" name="m-editor-tab">
    <input id="tab3" type="radio" name="m-editor-tab">

    <nav class="m-editor-controls__nav">
        <ul>
            <li class="m-editor-controls__nav_item tab1">
                <label for="tab1"><?php _e( "Content", 'molongui-authorship' ); ?></label>
            </li>
            <li class="m-editor-controls__nav_item tab2">
                <label for="tab2"><?php _e( "Layout", 'molongui-authorship' ); ?></label>
            </li>
            <li class="m-editor-controls__nav_item tab3">
                <label for="tab3"><?php _e( "Advanced", 'molongui-authorship' ); ?></label>
            </li>
        </ul>
    </nav>

    <section class="m-editor-controls__tabs">

        <div id="m-editor-tab-content" class="m-editor-controls__tab tab1">
            <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/editor/parts/html-editor-tab-content.php'; ?>
        </div>

        <div id="m-editor-tab-layout" class="m-editor-controls__tab tab2">
            <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/editor/parts/html-editor-tab-layout.php'; ?>
        </div>

        <div id="m-editor-tab-advanced" class="m-editor-controls__tab tab3">
            <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/admin/editor/parts/html-editor-tab-advanced.php'; ?>
        </div>

    </section>

</div>