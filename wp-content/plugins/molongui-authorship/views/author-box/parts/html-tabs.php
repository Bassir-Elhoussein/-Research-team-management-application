<?php
$box_tabs = array
(
    'name' => 'mab-tabs-'.$random_id,
    'tabs' => array
    (
        'profile' => array
        (
            'id'      => 'mab-tab-profile-'.$random_id,
            'label'   => apply_filters( 'authorship/box/profile/title', $options['author_box_profile_title'], $author ),//( $options['author_box_profile_title'] ? $options['author_box_profile_title'] : __( "About the author", 'molongui-authorship' ) ),
            'class'   => 'm-a-box-profile-title',//'m-a-box-string-about-the-author',
            'checked' => true,
            'display' => true,
        ),
        'related' => array
        (
            'id'      => 'mab-tab-related-'.$random_id,
            'label'   => apply_filters( 'authorship/box/related/title', $options['author_box_related_title'], $author ),//( $options['author_box_related_title'] ? $options['author_box_related_title'] : __( "Related posts", 'molongui-authorship' ) ),
            'class'   => 'm-a-box-related-title',//'m-a-box-string-related-posts',
            'checked' => false,
            'display' => $show_related,
        ),
        'contact' => array
        (
            'id'      => 'mab-tab-contact-'.$random_id,
            'class'   => 'm-a-box-contact-title',//'m-a-box-string-contact',
            'checked' => false,
            'display' => false,
        ),
    ),
);
if ( !empty( $options['author_box_tabs_position'] ) ) $position = explode('-', $options['author_box_tabs_position'] );
$active_class = 'm-a-box-tab-active';
?>

<script type="text/javascript" language="JavaScript">

	function molonguiHandleTab(myRadio)
	{
        let mabId = myRadio.id.slice( myRadio.id.lastIndexOf('-')+1 );
		document.querySelector( '#mab-'+mabId+' .m-a-box-tabs nav label.m-a-box-tab.<?php echo $active_class; ?>' ).classList.remove( '<?php echo $active_class; ?>' );
		document.querySelector( 'label[for='+myRadio.id+']' ).classList.add( '<?php echo $active_class; ?>' );
	}

</script>

<?php
foreach ( $box_tabs['tabs'] as $box_tab ) :
    if ( !$box_tab['display'] ) continue; ?>
    <input type="radio" id="<?php echo $box_tab['id']; ?>" name="<?php echo $box_tabs['name']; ?>" onclick="molonguiHandleTab(this);" <?php echo ( $box_tab['checked'] ? 'checked' : '' ); ?>>
<?php endforeach; ?>

<nav>
    <?php foreach ( $box_tabs['tabs'] as $box_tab )
    {
        if ( !$box_tab['display'] ) continue;
        ?>
            <label for="<?php echo $box_tab['id']; ?>" class="m-a-box-tab <?php echo ( $box_tab['checked'] ? ' '.$active_class : '' ); ?>">
                <span class="<?php echo $box_tab['class']; ?>"><?php echo $box_tab['label']; ?></span>
            </label>
        <?php
    }?>
</nav>