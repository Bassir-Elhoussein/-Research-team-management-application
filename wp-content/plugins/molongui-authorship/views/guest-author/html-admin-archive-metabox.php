<?php
defined( 'ABSPATH' ) or exit;

?>

<div class="molongui-metabox">

    <!-- Archive this author -->
    <div class="m-field">
        <div class="input-wrap">
            <input type="checkbox" id="_molongui_guest_author_archived" name="_molongui_guest_author_archived" value="1" <?php checked( $guest_author_archived, 1 ); ?>>
            <label class="checkbox-label" for="_molongui_guest_author_archived"><?php _e( "Archive this author so he/she won't be displayed as an eligible author for your posts. Won't be listed in the authors dropdown in your edit-post screen.", 'molongui-authorship' ); ?></label>
        </div>
    </div>

</div>