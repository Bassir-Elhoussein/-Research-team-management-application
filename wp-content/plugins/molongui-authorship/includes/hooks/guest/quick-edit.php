<?php
defined( 'ABSPATH' ) or exit;
function authorship_guest_quick_edit_add_title_field()
{
    global $pagenow, $post_type;

    if ( 'edit.php' == $pagenow and $post_type == MOLONGUI_AUTHORSHIP_CPT ) add_post_type_support( $post_type, 'title' );
}
add_action( 'admin_head', 'authorship_guest_quick_edit_add_title_field' );
function authorship_guest_quick_edit_add_custom_fields( $column_name, $post_type )
{
    if ( $column_name != 'guestDisplayBox' ) return;

    wp_nonce_field( 'quick_edit_guest', 'quick_edit_guest_nonce' );

    ?>
    <fieldset class="inline-edit-col-left">
        <div class="inline-edit-col">
            <div class="inline-edit-group wp-clearfix">
                <label class="inline-edit-status alignleft">
                    <span class="title"><?php esc_html_e( "Author Box", 'molongui-authorship' ); ?></span>
                    <select name="_molongui_guest_author_box_display">
                        <option value="default" ><?php _e( "Default", 'molongui-authorship' ); ?></option>
                        <option value="show"    ><?php _e( "Show", 'molongui-authorship' ); ?></option>
                        <option value="hide"    ><?php _e( "Hide", 'molongui-authorship' ); ?></option>
                    </select>
                </label>
            </div>
        </div>
    </fieldset>
    <?php
}
add_action( 'quick_edit_custom_box', 'authorship_guest_quick_edit_add_custom_fields', 10, 2 );
function authorship_guest_quick_edit_populate_custom_fields()
{
    $current_screen = get_current_screen();
    if ( $current_screen->id != 'edit-'.MOLONGUI_AUTHORSHIP_CPT or $current_screen->post_type != MOLONGUI_AUTHORSHIP_CPT ) return;
    wp_enqueue_script( 'jquery' );
    ?>
    <script type="text/javascript">
        jQuery( function( $ )
        {
            var $inline_editor = inlineEditPost.edit;
            inlineEditPost.edit = function(id)
            {
                $inline_editor.apply( this, arguments);
                var post_id = 0;
                if ( typeof(id) == 'object' )
                {
                    post_id = parseInt(this.getId(id));
                }
                if ( post_id != 0 )
                {
                    $row = $('#edit-' + post_id);
                    $box_display = $('#box_display_' + post_id).data( 'display-box' );
                    if ( $box_display === '' )
                    {
                        $box_display = 'default';
                    }
                    $row.find('[name="_molongui_guest_author_box_display"]').val($box_display);
                    $row.find('[name="_molongui_guest_author_box_display"]').children('[value="' + $box_display + '"]').attr('selected', true);
                }
            }
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'authorship_guest_quick_edit_populate_custom_fields' );
function authorship_guest_quick_edit_save_custom_fields( $post_id, $post )
{
    if ( !isset( $_POST['quick_edit_guest_nonce'] ) or !wp_verify_nonce( $_POST['quick_edit_guest_nonce'], 'quick_edit_guest' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;
    if ( !current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['post_title'] ) ) update_post_meta( $post_id, '_molongui_guest_author_display_name', $_POST['post_title'] );
    if ( isset( $_POST['_molongui_guest_author_box_display'] ) ) update_post_meta( $post_id, '_molongui_guest_author_box_display', $_POST['_molongui_guest_author_box_display'] );
}
add_action( 'save_post_'.MOLONGUI_AUTHORSHIP_CPT, 'authorship_guest_quick_edit_save_custom_fields', 10, 2 );