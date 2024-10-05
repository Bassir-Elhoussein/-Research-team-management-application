<?php
defined( 'ABSPATH' ) or exit;
function authorship_editor_url()
{
    return admin_url( 'admin.php?page=author-box-editor' );
}
function authorship_is_editor()
{
    return apply_filters( 'authorship_is_editor', defined( 'MOLONGUI_AUTHORSHIP_IS_EDITOR' ) and MOLONGUI_AUTHORSHIP_IS_EDITOR );
}
function authorship_editor_heading( $label )
{
    ?>
    <div class="m-editor-heading">
        <span class="m-editor-heading__label"><?php echo $label; ?></span>
    </div>
    <?php
}
function authorship_editor_input( $name, $label, $args = array() )
{
    $type        = !empty( $args['type'] ) ? $args['type'] : 'text';
    $default     = isset( $args['default'] ) ? $args['default'] : '';
    $placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
    $disabled    = !empty( $args['disabled'] ) ? $args['disabled'] : '';
    $min         = isset( $args['min'] ) ? $args['min'] : null;
    $max         = !empty( $args['max'] ) ? $args['max'] : '';
    $step        = !empty( $args['step'] ) ? $args['step'] : '';
    $width       = !empty( $args['width'] ) ? $args['width'] : '';
    $info_title  = !empty( $args['info-title'] ) ? 'data-info-title="'.$args['info-title'].'"' : '';
    $info_desc   = !empty( $args['info-desc'] ) ? 'data-info-desc="'.$args['info-desc'].'"' : '';
    $info_tip    = !empty( $args['info-tip'] ) ? 'data-info-tip="'.$args['info-tip'].'"' : '';
    $info_more   = !empty( $args['info-more'] ) ? 'data-info-more="'.$args['info-more'].'"' : '';
    $parent      = !empty( $args['parent'] ) ? 'data-parent="'.$args['parent'].'"' : '';

    $atts  = '';
    $atts .= isset( $placeholder ) ? 'placeholder="'.$placeholder.'"' : '';
    $atts .= !empty( $disabled ) ? 'disabled="disabled"' : '';
    $atts .= isset( $min ) ? 'min="'.$min.'"' : '';
    $atts .= !empty( $max ) ? 'max="'.$max.'"' : '';
    $atts .= !empty( $step ) ? 'step="'.$step.'"' : '';
    $atts .= !empty( $width ) ? 'width="'.$width.'"' : '';

    $options = authorship_get_options();
    $value   = isset( $options[$name] ) ? $options[$name] : $default;
    $checked = 'checkbox' === $type ? checked( $value, true, false ) : '';

    ?>
    <div class="m-editor-input" <?php echo $info_title; ?> <?php echo $info_desc; ?> <?php echo $info_tip; ?> <?php echo $info_more; ?>>
        <div class="m-editor-property__label"><?php echo $label; ?></div>
        <div class="m-editor-property">
            <input type="<?php echo $type; ?>" id="<?php echo $name; ?>" name="<?php echo $name; ?>" <?php echo $atts; ?> value="<?php echo $value; ?>" <?php echo $checked; ?> <?php echo $parent; ?>>
            <?php if ( 'range' === $type ) : ?>
                <input type="number" id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="m-editor-range-value" value="<?php echo $value; ?>" <?php echo $atts; ?> <?php echo $parent; ?>>
                <script>
                    jQuery(document).ready(function($)
                    {
                        $('#<?php echo $name; ?>').on('input', function()
                        {
                            $(this).next('.m-editor-range-value').val($(this).val());
                        });
                        $('#<?php echo $name; ?> ~ .m-editor-range-value').on('input', function()
                        {
                            $(this).prev().val($(this).val());
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
function authorship_editor_select( $name, $label, $options, $args = array() )
{
    $default     = !empty( $args['default'] ) ? $args['default'] : '';
    $disabled    = !empty( $args['disabled'] ) ? $args['disabled'] : '';
    $size        = !empty( $args['size'] ) ? $args['size'] : '';
    $info_title  = !empty( $args['info-title'] ) ? 'data-info-title="'.$args['info-title'].'"' : '';
    $info_desc   = !empty( $args['info-desc'] ) ? 'data-info-desc="'.$args['info-desc'].'"' : '';
    $info_tip    = !empty( $args['info-tip'] ) ? 'data-info-tip="'.$args['info-tip'].'"' : '';
    $info_more   = !empty( $args['info-more'] ) ? 'data-info-more="'.$args['info-more'].'"' : '';
    $parent      = !empty( $args['parent'] ) ? 'data-parent="'.$args['parent'].'"' : '';

    $atts  = '';
    $atts .= !empty( $disabled ) ? 'disabled="disabled"' : '';
    $atts .= !empty( $size ) ? 'size="'.$size.'"' : '';

    $settings = authorship_get_options();
    $selected = isset( $settings[$name] ) ? $settings[$name] : $default;

    ?>
    <div class="m-editor-input" <?php echo $info_title; ?> <?php echo $info_desc; ?> <?php echo $info_tip; ?> <?php echo $info_more; ?>>
        <div class="m-editor-property__label"><?php echo $label; ?></div>
        <div class="m-editor-property">
            <select id="<?php echo $name; ?>" name="<?php echo $name; ?>" <?php echo $atts; ?> <?php echo $parent; ?>>
                <?php foreach ( $options as $key => $item ) : ?>
                    <?php
                    $off = '';
                    if ( is_array( $item ) )
                    {
                        $off  = !empty( $item['disabled'] ) ? 'disabled="disabled"' : '';
                        $item = !empty( $item['label'] ) ? $item['label'] : '';
                    }
                    ?>
                    <option value="<?php echo $key; ?>" <?php selected( $selected, $key ); ?> <?php echo $off; ?>><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php
}
function authorship_editor_textarea( $name, $label, $args = array() )
{
    $default     = !empty( $args['default'] ) ? $args['default'] : '';
    $placeholder = !empty( $args['placeholder'] ) ? $args['placeholder'] : '';
    $disabled    = !empty( $args['disabled'] ) ? $args['disabled'] : '';
    $cols        = !empty( $args['cols'] ) ? $args['cols'] : '';
    $rows        = !empty( $args['rows'] ) ? $args['rows'] : '';
    $maxlength   = !empty( $args['maxlength'] ) ? $args['maxlength'] : '';
    $info_title  = !empty( $args['info-title'] ) ? 'data-info-title="'.$args['info-title'].'"' : '';
    $info_desc   = !empty( $args['info-desc'] ) ? 'data-info-desc="'.$args['info-desc'].'"' : '';
    $info_tip    = !empty( $args['info-tip'] ) ? 'data-info-tip="'.$args['info-tip'].'"' : '';
    $info_more   = !empty( $args['info-more'] ) ? 'data-info-more="'.$args['info-more'].'"' : '';
    $parent      = !empty( $args['parent'] ) ? 'data-parent="'.$args['parent'].'"' : '';

    $atts  = '';
    $atts .= !empty( $placeholder ) ? 'placeholder="'.$placeholder.'"' : '';
    $atts .= !empty( $disabled ) ? 'disabled="disabled"' : '';
    $atts .= !empty( $cols ) ? 'cols="'.$cols.'"' : '';
    $atts .= !empty( $rows ) ? 'rows="'.$rows.'"' : '';
    $atts .= !empty( $maxlength ) ? 'maxlength="'.$maxlength.'"' : '';

    $options = authorship_get_options();
    $value   = isset( $options[$name] ) ? $options[$name] : $default;

    ?>
    <div class="m-editor-input" <?php echo $info_title; ?> <?php echo $info_desc; ?> <?php echo $info_tip; ?> <?php echo $info_more; ?>>
        <textarea id="<?php echo $name; ?>" name="<?php echo $name; ?>" <?php echo $atts; ?> <?php echo $parent; ?>><?php echo $value; ?></textarea>
    </div>
    <?php
}
function authorship_editor_colorpicker( $name, $label, $args = array() )
{
    $default               = !empty( $args['default'] ) ? $args['default'] : 'inherit';
    $container             = !empty( $args['container'] ) ? $args['container'] : 'body';
    $closeOnScroll         = !empty( $args['closeOnScroll'] ) ? $args['closeOnScroll'] : 'true';
    $padding               = !empty( $args['padding'] ) ? $args['padding'] : '8';
    $inline                = !empty( $args['inline'] ) ? $args['inline'] : 'false';
    $autoReposition        = !empty( $args['autoReposition'] ) ? $args['autoReposition'] : 'false';
    $sliders               = !empty( $args['sliders'] ) ? $args['sliders'] : 'h';
    $disabled              = !empty( $args['disabled'] ) ? $args['disabled'] : 'false';
    $comparison            = !empty( $args['comparison'] ) ? $args['comparison'] : 'false';
    $defaultRepresentation = !empty( $args['defaultRepresentation'] ) ? $args['defaultRepresentation'] : 'HEX';
    $position              = !empty( $args['position'] ) ? $args['position'] : 'bottom-end';
    $adjustableNumbers     = !empty( $args['adjustableNumbers'] ) ? $args['adjustableNumbers'] : 'true';
    $info_title            = !empty( $args['info-title'] ) ? 'data-info-title="'.$args['info-title'].'"' : '';
    $info_desc             = !empty( $args['info-desc'] ) ? 'data-info-desc="'.$args['info-desc'].'"' : '';
    $info_tip              = !empty( $args['info-tip'] ) ? 'data-info-tip="'.$args['info-tip'].'"' : '';
    $info_more             = !empty( $args['info-more'] ) ? 'data-info-more="'.$args['info-more'].'"' : '';
    $parent                = !empty( $args['parent'] ) ? 'data-parent="'.$args['parent'].'"' : '';

    $options = authorship_get_options();
    $value   = !empty( $options[$name] ) ? $options[$name] : $default;
    $value   = 'inherit' === $value ? '' : $value;

    ?>
    <div class="m-editor-input" <?php echo $info_title; ?> <?php echo $info_desc; ?> <?php echo $info_tip; ?> <?php echo $info_more; ?>>
        <div class="m-editor-property__label"><?php echo $label; ?></div>
        <div class="m-editor-property">
            <input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php echo $parent; ?>>
            <div class="<?php echo $name; ?>"></div>
            <script>
                    const pickr_<?php echo $name; ?> = Pickr.create(
                    {
                        el                    : '.<?php echo $name; ?>',
                        container             : '<?php echo $container; ?>',
                        theme                 : 'nano',
                        closeOnScroll         : <?php echo $closeOnScroll; ?>,
                        padding               : <?php echo $padding; ?>,
                        inline                : <?php echo $inline; ?>,
                        autoReposition        : <?php echo $autoReposition; ?>,
                        sliders               : '<?php echo $sliders; ?>',
                        disabled              : <?php echo $disabled; ?>,
                        comparison            : <?php echo $comparison; ?>,
                        defaultRepresentation : '<?php echo $defaultRepresentation; ?>',
                        position              : '<?php echo $position; ?>',
                        adjustableNumbers     : <?php echo $adjustableNumbers; ?>,

                        default : '<?php echo $value; ?>',

                        swatches : [
                            'rgba(244, 67, 54, 1)',
                            'rgba(233, 30, 99, 0.95)',
                            'rgba(156, 39, 176, 0.9)',
                            'rgba(103, 58, 183, 0.85)',
                            'rgba(63, 81, 181, 0.8)',
                            'rgba(33, 150, 243, 0.75)',
                            'rgba(3, 169, 244, 0.7)',
                            'rgba(0, 188, 212, 0.7)',
                            'rgba(0, 150, 136, 0.75)',
                            'rgba(76, 175, 80, 0.8)',
                            'rgba(139, 195, 74, 0.85)',
                            'rgba(205, 220, 57, 0.9)',
                            'rgba(255, 235, 59, 0.95)',
                            'rgba(255, 193, 7, 1)'
                        ],

                        components : {
                            preview : true,
                            opacity : true,
                            hue     : true,
                            interaction : {
                                hex   : true,
                                rgba  : true,
                                hsla  : false,
                                hsva  : false,
                                cmyk  : false,
                                input : true,
                                clear : true,
                                save  : true
                            },
                        },
                        i18n: {
                            'ui:dialog'      : 'color picker dialog',
                            'btn:toggle'     : 'toggle color picker dialog',
                            'btn:swatch'     : 'color swatch',
                            'btn:last-color' : 'use previous color',
                            'btn:save'       : '<?php _e( 'Apply' ); ?>',
                            'btn:cancel'     : '<?php _e( 'Cancel' ); ?>',
                            'btn:clear'      : '<?php _e( 'Clear' ); ?>',
                            'aria:btn:save'   : 'save and close',
                            'aria:btn:cancel' : 'cancel and close',
                            'aria:btn:clear'  : 'clear and close',
                            'aria:input'      : 'color input field',
                            'aria:palette'    : 'color selection area',
                            'aria:hue'        : 'hue selection slider',
                            'aria:opacity'    : 'selection slider'
                        },
                    });
                    pickr_<?php echo $name; ?>.on('change', (color, instance) => {

                        let hidden = document.getElementById('<?php echo $name; ?>');
                        hidden.value = color.toHEXA().toString();
                        hidden.dispatchEvent(new Event('change', {bubbles: true, cancelable: true}));
                        hidden.dispatchEvent(new Event('input', {bubbles: true, cancelable: true}));
                    });
                    pickr_<?php echo $name; ?>.on('clear', instance => {

                        let hidden = document.getElementById('<?php echo $name; ?>');
                        hidden.value = 'transparent';
                        hidden.dispatchEvent(new Event('change', {bubbles: true, cancelable: true}));
                        hidden.dispatchEvent(new Event('input', {bubbles: true, cancelable: true}));
                    });
                    pickr_<?php echo $name; ?>.on('save', (color, instance) => {
                        pickr_<?php echo $name; ?>.hide();
                    });
            </script>
        </div>
    </div>
    <?php
}
function authorship_editor_spacing( $prefix )
{
    $options = authorship_get_options();

    ?>
    <div class="m-editor-spacing m-editor-input">

        <div class="m-editor-margin">
            <div class="m-editor-margin__label"><?php _e( "Margin", 'molongui-authorship' ); ?></div>
            <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-margin-top"    value="<?php echo !empty( $options[$prefix.'margin_top'] ) ? $options[$prefix.'margin_top'] : ''; ?>"       id="<?php echo $prefix; ?>margin_top"    name="<?php echo $prefix; ?>margin_top"    title="margin-top">
            <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-margin-right"  value="<?php echo !empty( $options[$prefix.'margin_right'] ) ? $options[$prefix.'margin_right'] : ''; ?>"   id="<?php echo $prefix; ?>margin_right"  name="<?php echo $prefix; ?>margin_right"  title="margin-right">
            <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-margin-bottom" value="<?php echo !empty( $options[$prefix.'margin_bottom'] ) ? $options[$prefix.'margin_bottom'] : ''; ?>" id="<?php echo $prefix; ?>margin_bottom" name="<?php echo $prefix; ?>margin_bottom" title="margin-bottom">
            <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-margin-left"   value="<?php echo !empty( $options[$prefix.'margin_left'] ) ? $options[$prefix.'margin_left'] : ''; ?>"     id="<?php echo $prefix; ?>margin_left"   name="<?php echo $prefix; ?>margin_left"   title="margin-left">

            <div class="m-editor-border">
                <div class="m-editor-border__label"><?php _e( "Border", 'molongui-authorship' ); ?></div>
                <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-border-top-width"    value="<?php echo !empty( $options[$prefix.'border_top'] ) ? $options[$prefix.'border_top'] : ''; ?>"       id="<?php echo $prefix; ?>border_top"    name="<?php echo $prefix; ?>border_top"    title="border-top-width">
                <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-border-right-width"  value="<?php echo !empty( $options[$prefix.'border_right'] ) ? $options[$prefix.'border_right'] : ''; ?>"   id="<?php echo $prefix; ?>border_right"  name="<?php echo $prefix; ?>border_right"  title="border-right-width">
                <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-border-bottom-width" value="<?php echo !empty( $options[$prefix.'border_bottom'] ) ? $options[$prefix.'border_bottom'] : ''; ?>" id="<?php echo $prefix; ?>border_bottom" name="<?php echo $prefix; ?>border_bottom" title="border-bottom-width">
                <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-border-left-width"   value="<?php echo !empty( $options[$prefix.'border_left'] ) ? $options[$prefix.'border_left'] : ''; ?>"     id="<?php echo $prefix; ?>border_left"   name="<?php echo $prefix; ?>border_left"   title="border-left-width">

                <div class="m-editor-padding">
                    <div class="m-editor-padding__label"><?php _e( "Padding", 'molongui-authorship' ); ?></div>
                    <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-padding-top"    value="<?php echo !empty( $options[$prefix.'padding_top'] ) ? $options[$prefix.'padding_top'] : ''; ?>"       id="<?php echo $prefix; ?>padding_top"    name="<?php echo $prefix; ?>padding_top"    title="padding-top">
                    <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-padding-right"  value="<?php echo !empty( $options[$prefix.'padding_right'] ) ? $options[$prefix.'padding_right'] : ''; ?>"   id="<?php echo $prefix; ?>padding_right"  name="<?php echo $prefix; ?>padding_right"  title="padding-right">
                    <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-padding-bottom" value="<?php echo !empty( $options[$prefix.'padding_bottom'] ) ? $options[$prefix.'padding_bottom'] : ''; ?>" id="<?php echo $prefix; ?>padding_bottom" name="<?php echo $prefix; ?>padding_bottom" title="padding-bottom">
                    <input type="text" placeholder="-" class="m-editor-spacing-input m-editor-padding-left"   value="<?php echo !empty( $options[$prefix.'padding_left'] ) ? $options[$prefix.'padding_left'] : ''; ?>"     id="<?php echo $prefix; ?>padding_left"   name="<?php echo $prefix; ?>padding_left"   title="padding-left">
                </div>
            </div>
        </div>

    </div>
    <?php
}
function authorship_editor_separator()
{
    ?>
    <div class="m-editor-separator"></div>
    <?php
}
function authorship_editor_notice( $id, $notice )
{
    $notice = apply_filters( '_authorship/editor_notice', $notice );
    ?>
    <div id="<?php echo $id; ?>-notice" class="m-editor-notice"><?php echo $notice; ?></div>
    <?php
}
function authorship_html_tags()
{
    return array
    (
        'h1'   => 'H1',
        'h2'   => 'H2',
        'h3'   => 'H3',
        'h4'   => 'H4',
        'h5'   => 'H5',
        'h6'   => 'H6',
        'div'  => 'div',
        'span' => 'span',
        'p'    => 'p',
    );
}
function authorship_font_weight()
{
    return array
    (
        ''        => 'Default',
        'normal'  => 'Normal',
        'bold'    => 'Bold',
        '100'     => '100 - Thin',
        '200'     => '200 - Extra light',
        '300'     => '300 - Light',
        '400'     => '400 - Normal',
        '500'     => '500 - Medium',
        '600'     => '600 - Semi bold',
        '700'     => '700 - Bold',
        '800'     => '800 - Extra bold',
        '900'     => '900 - Black',
    );
}
function authorship_text_transform()
{
    return array
    (
        ''           => 'Default',
        'uppercase'  => 'Uppercase',
        'lowercase'  => 'Lowercase',
        'capitalize' => 'Capitalize',
        'none'       => 'Normal',
    );
}
function authorship_font_style()
{
    return array
    (
        ''        => 'Default',
        'none'    => 'Normal',
        'italic'  => 'Italic',
        'oblique' => 'Oblique',
    );
}
function authorship_text_decoration()
{
    return array
    (
        ''             => 'Default',
        'underline'    => 'Underline',
        'overline'     => 'Overline',
        'line-through' => 'Line Through',
        'none'         => 'None',
    );
}
function authorship_text_align()
{
    return array
    (
        ''        => 'Default',
        'left'    => 'Left',
        'center'  => 'Center',
        'right'   => 'Right',
        'justify' => 'Justify',
    );
}
function authorship_border_style()
{
    return array
    (
        'none'   => 'None',
        'dotted' => 'Dotted',
        'dashed' => 'Dashed',
        'solid'  => 'Solid',
        'double' => 'Double',
        'groove' => 'Groove',
        'ridge'  => 'Ridge',
        'inset'  => 'Inset',
        'outset' => 'Outset',
    );
}
function authorship_query_order()
{
    return array
    (
        'ASC'  => __( 'Ascending' ),
        'DESC' => __( 'Descending' ),
    );
}
function authorship_input_has_units( $input )
{
    if ( preg_match("/[a-z]/i", $input ) ) return true;
    return false;
}