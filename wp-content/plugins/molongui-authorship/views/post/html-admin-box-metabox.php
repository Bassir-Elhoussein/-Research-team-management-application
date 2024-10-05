<?php
defined( 'ABSPATH' ) or exit;

?>
<div class="molongui-metabox">

    <!-- Author Box Display -->
    <div class="m-title"><?php _e( 'Display', 'molongui-authorship' ); ?></div>
    <p class="m-description"><?php _e( 'Whether to show the author box on this post', 'molongui-authorship' ); ?></p>
    <div class="m-field">
        <select name="_molongui_author_box_display">
            <option value="default" <?php selected( $author_box_display, 'default' ); ?>><?php _e( 'Default', 'molongui-authorship' ); ?></option>
            <option value="show"    <?php selected( $author_box_display, 'show' );    ?>><?php _e( 'Show', 'molongui-authorship' ); ?></option>
            <option value="hide"    <?php selected( $author_box_display, 'hide' );    ?>><?php _e( 'Hide', 'molongui-authorship' ); ?></option>
        </select>
    </div>

    <!-- Author Box Position -->
    <div class="m-title <?php echo ( $author_box_display == 'hide' ? 'm-title-disabled' : '' ); ?>"><?php _e( 'Position', 'molongui-authorship' ); ?></div>
    <p class="m-description <?php echo ( $author_box_display == 'hide' ? 'm-description-disabled' : '' ); ?>"><?php _e( 'Where in the post to show the author box?', 'molongui-authorship' ); ?></p>
    <div class="m-field">
        <select name="_molongui_author_box_position" <?php echo ( $author_box_display == 'hide' ? 'disabled' : '' ); ?>>
            <option value="default" <?php selected( $author_box_position, 'default' ); ?>><?php _e( 'Default', 'molongui-authorship' ); ?></option>
            <option value="above"   <?php selected( $author_box_position, 'above' );   ?>><?php _e( 'Above', 'molongui-authorship' ); ?></option>
            <option value="below"   <?php selected( $author_box_position, 'below' );   ?>><?php _e( 'Below', 'molongui-authorship' ); ?></option>
            <option value="both"    <?php selected( $author_box_position, 'both'  );   ?>><?php _e( 'Both', 'molongui-authorship' );  ?></option>
        </select>
    </div>

    <!-- Author Box Position Style -->
    <script type="text/javascript">
        jQuery(function($)
        {
            $('select[name="_molongui_author_box_display"]').on('change', function()
            {
                var author_box_position_select = $('select[name="_molongui_author_box_position"]');

                if ( $(this).val() === 'hide' )
                {
                    author_box_position_select.prop('disabled', 'disabled');
                    author_box_position_select.parent().prev().addClass('m-description-disabled');
                    author_box_position_select.parent().prev().prev().addClass('m-title-disabled');
                }
                else
                {
                    author_box_position_select.prop('disabled', false);
                    author_box_position_select.parent().prev().removeClass('m-description-disabled');
                    author_box_position_select.parent().prev().prev().removeClass('m-title-disabled');
                }
            });
        });
    </script>

</div>