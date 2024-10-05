<?php
defined( 'ABSPATH' ) or exit;

?>

<div class="wrap">

    <h1 class="wp-heading-inline"><?php _e( "Authors", 'molongui-authorship' ); ?></h1>
    <a href="<?php echo admin_url( 'admin.php?page=author-new' ); ?>" class="page-title-action"><?php _e( 'Add New' ); ?></a>
    <hr class="wp-header-end">

    <div id="nds-wp-list-table-demo" class="molongui-authors">
        <div id="nds-post-body">
            <form id="nds-user-list-form" method="get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <?php $authors_table->search_box( __( "Find author", 'molongui-authorship' ), 'author-search' ); ?>
                <?php $authors_table->display(); ?>
            </form>
        </div>
    </div>

</div>