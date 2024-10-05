<?php
defined( 'ABSPATH' ) or exit;
function authorship_post_quick_edit_remove_author()
{
    global $pagenow, $post_type;

    $post_types = molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' );

    if ( 'edit.php' == $pagenow and authorship_byline_takeover() and in_array( $post_type, $post_types ) )
    {
        remove_post_type_support( $post_type, 'author' );
    }
}
add_action( 'admin_head', 'authorship_post_quick_edit_remove_author' );
function authorship_post_quick_edit_add_fields( $column_name, $post_type )
{
    if ( !authorship_byline_takeover() ) return;
    $post_types = molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' );
    if ( !in_array( $post_type, $post_types ) ) return;
    if ( $column_name == 'molongui-author' )
    {
        wp_nonce_field( 'molongui_authorship_quick_edit_nonce', 'molongui_authorship_quick_edit_nonce' );

        ?>
        <br class="clear" />
        <fieldset class="inline-edit-col-left">
            <div class="inline-edit-col">
                <h4><?php _e( "Authorship data", 'molongui-authorship' ); ?></h4>
                <div class="inline-edit-group wp-clearfix">
                    <label class="inline-edit-authors alignleft" style="width: 100%;">
                        <span class="title"><?php authorship_is_feature_enabled( 'multi' ) ? _e( "Authors", 'molongui-authorship' ) : _e( "Author" ); ?></span>
                        <div id="molongui-author-selectr" style="margin-left: 6em;">
                            <?php echo authorship_dropdown_authors( 'authors', array( 'selected' => '' ) ); ?>
                        </div>
                    </label>
                </div>
            </div>
        </fieldset>
        <?php
    }
    elseif ( $column_name == 'molongui-box' )
    {
        wp_nonce_field( 'molongui_authorship_quick_edit_nonce', 'molongui_authorship_quick_edit_nonce' );

        ?>
        <br class="clear" />
        <fieldset class="inline-edit-col-left">
            <div class="inline-edit-col">
                <div class="inline-edit-group wp-clearfix">
                    <label class="inline-edit-box-display alignleft">
                        <span class="title"><?php _e( "Author box", 'molongui-authorship' ); ?></span>
                        <select name="_molongui_author_box_display">
                            <option value="default" ><?php _e( "Default", 'molongui-authorship' ); ?></option>
                            <option value="show"    ><?php _e( "Show"   , 'molongui-authorship' ); ?></option>
                            <option value="hide"    ><?php _e( "Hide"   , 'molongui-authorship' ); ?></option>
                        </select>
                    </label>
                </div>
            </div>
        </fieldset>
        <?php
    }
}
add_action( 'quick_edit_custom_box', 'authorship_post_quick_edit_add_fields', 10, 2 );
function authorship_post_quick_edit_fill_fields()
{
    if ( !authorship_byline_takeover() ) return;
    $current_screen = get_current_screen();
    if ( substr( $current_screen->id, 0, strlen( 'edit-' ) ) != 'edit-' or !in_array( $current_screen->id, molongui_enabled_post_screens( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ) ) ) return;
    wp_enqueue_script( 'jquery' );
    ?>
    <script type="text/javascript">
        jQuery(function($)
        {
            var $inline_editor = inlineEditPost.edit;
            inlineEditPost.edit = function(id)
            {
                $inline_editor.apply(this, arguments);
                var post_id = 0;
                if (typeof(id) === 'object') post_id = parseInt(this.getId(id));
                if (post_id !== 0)
                {
                    var $q_editor = $('#edit-' + post_id);
                    var $post_row = $('#post-' + post_id);
                    var authorSelect = document.getElementById('_molongui_author');
                    if ( typeof(authorSelect) === 'undefined' || authorSelect === null ) return false;
                    var authorList = $q_editor.find('ul#molongui_authors');
                    if ( typeof(authorList) === 'undefined' || authorList === null ) return false;
                    var container = document.getElementById('molongui-author-selectr');
                    if ( typeof(container) === 'undefined' || container === null ) return false;
                    if (container.hasChildNodes()) container.removeChild(container.firstElementChild);
                    container.prepend(authorSelect);
                    $.molonguiInitAuthorSelector(authorSelect, authorList, '');
                    <?php if ( authorship_is_feature_enabled( 'multi' ) ) : ?>
                    authorList.empty();
                    $post_row.find('.molongui-author p').each(function(index, item)
                    {
                        var $ref = $(item).data('author-type') + '-' + $(item).data('author-id');
                        var $li  = '<li data-post="' + post_id + '" data-value="' + $ref + '">' + $(item).data('author-display-name') + '<input type="hidden" name="molongui_authors[]" value="' + $ref + '" /><div class="m-tooltip"><span class="dashicons dashicons-trash js-remove"></span><span class="m-tooltip__text m-tooltip__left">' + molongui_authorship_edit_post_params.remove_author_tip + '</span></div></li>';
                        authorList.append($li);
                    });

                    <?php else : ?>
                    $post_row.find('.molongui-author p').each(function(index, item)
                    {
                        $q_editor.find('.selectr-selected .selectr-label').text($(item).data('author-display-name'));
                        var $ref = $(item).data('author-type') + '-' + $(item).data('author-id');
                        $q_editor.find('#_molongui_author').each(function(i)
                        {
                            $(this).find('option').attr("selected",false);
                            $(this).find('option[value='+$ref+']').attr("selected",true);
                            $(this).val($ref);
                        });
                    });

                    <?php endif; ?>
                    var $box_display = $('#box_display_' + post_id).data('display-box');
                    if ($box_display === '') $box_display = 'default';
                    $q_editor.find('[name="_molongui_author_box_display"]').val($box_display);
                    $q_editor.find('[name="_molongui_author_box_display"]').children('[value="' + $box_display + '"]').attr('selected', true);
                }
            };
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'authorship_post_quick_edit_fill_fields' );
function authorship_post_quick_edit_save_fields( $post_id, $post )
{
    if ( !isset( $_POST['molongui_authorship_quick_edit_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_quick_edit_nonce'], 'molongui_authorship_quick_edit_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return;
    if ( !authorship_byline_takeover() ) return;
    if ( !in_array( $post->post_type, molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all' ) ) ) return;
    if ( !current_user_can( 'edit_post', $post_id ) ) return;
    authorship_post_save_authors( $_POST, $post_id, __CLASS__, __FUNCTION__ );
    if ( isset( $_POST['_molongui_author_box_display'] ) ) update_post_meta( $post_id, '_molongui_author_box_display', $_POST['_molongui_author_box_display'] );
}
add_action( 'save_post', 'authorship_post_quick_edit_save_fields', 10, 2 );
