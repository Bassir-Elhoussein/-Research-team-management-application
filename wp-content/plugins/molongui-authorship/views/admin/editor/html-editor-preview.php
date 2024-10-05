<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;

$options = authorship_get_options();
$authors = molongui_get_authors();
$author  = new stdClass();

if ( !empty( $_GET['author'] ) )
{
    $get = explode( '-', $_GET['author'] );
    $author->id   = $get[1];
    $author->type = $get[0];
    $author->ref  = $_GET['author'];
}
else
{
    $current_user = wp_get_current_user();
    if ( array_intersect( (array) $current_user->roles, explode(",", $options['user_roles'] ) ) )
    {
        $author->id   = $current_user->ID;
        $author->type = 'user';
        $author->ref  = $author->type . '-' . $author->id;
    }
    else
    {
        $author->id   = $authors[0]['id'];
        $author->type = $authors[0]['type'];
        $author->ref  = $authors[0]['ref'];
    }
}

?>

<div id="m-editor-preview">

    <div id="m-editor-author-select">
        <label for="active-author"><?php _e( "Pick an author to preview their author box:", 'molongui-authorship' ); ?></label>
        <select id="active-author">
            <?php foreach ( $authors as $option ) : ?>
            <option value="<?php echo $option['ref']; ?>" <?php selected( $author->ref, $option['ref'] ); ?> ><?php echo $option['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="m-editor-live-preview">
        <div class="m-editor-preview__label">
            <?php _e( "Preview", 'molongui-authorship' ); ?>
        </div>
        <div id="m-editor_preview__warning" class="m-editor-warning" data-pro-options="" style="display:none;">
            <?php _e( "Premium options are only available in the Pro version of the plugin. You can preview them but they won't be saved and will be reverted to defaults.", 'molongui-authorship' ); ?>
        </div>
        <div id="m-editor-live-preview__box">
            <?php echo authorship_box_markup( null, array( $author ), $options, false ); ?>
        </div>
        <div id="m-editor-live-preview__loader"><div></div><div></div></div>

        <div id="m-editor-disclaimer">
            <?php _e( "How the author box is actually displayed in your site's frontend might differ slightly from what is shown here.", 'molongui-authorship' ); ?>
        </div>
    </div>

</div>
