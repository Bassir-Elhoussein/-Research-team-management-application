<?php

namespace Molongui\Authorship\Includes\Libraries\Common;
\defined( 'ABSPATH' ) or exit;
if ( !\class_exists('Molongui\Authorship\Includes\Libraries\Common\Option') )
{
    class Option
    {
        public $_saved;
        public $_tab;
        public $_group;
        public $_data;
        public $_type;
        public $_id;
        public $_default;
        public $_value;
        public $_class;
        public $_desc;
        public $_step;
        public $_name;
        public $_option_cls;
        public $_options;
        public $_min;
        public $_max;
        public $_args;
        public $_prefix;
        public $_suffix;
        public $_source;
        public $_placeholder;
        public $_editor;
        public $_height;
        public $_upload_title;
        public $_upload_button;
        public $_options_prefix;
        public function __construct( $data = null, $group, $key = '', $prefix = 'molongui' )
        {
            if ( empty( $key ) ) $key = MOLONGUI_AUTHORSHIP_PREFIX.'_options';
            $this->_saved = (array) \get_option( $key, array() );
            $this->_group			= $group;
            $this->_data 			= $data;
            $this->_type			= $data['type'];

            $this->_id				= ( isset( $data['id'] ) ) ? $data['id'] : null;
            $this->_default 		= ( isset( $data['default'] ) ) ? $data['default'] : null;
            $this->_value 			= ( isset( $this->_id ) and isset( $this->_saved[$this->_id] ) ) ? $this->_saved[$this->_id] : $this->_default;

            $this->_class 			= ( isset( $data['class'] ) ) ? $data['class'] : null;
            $this->_desc 			= ( isset( $data['desc'] ) ) ? '<span class="description">'.$data['desc'].'</span>' : null;
            $this->_desc 		   .= ( isset( $data['alert'] ) ) ? '<span class="description alert">'.$data['alert'].'</span>' : null;
            $this->_step 		    = ( isset( $data['step'] ) ) ? $data['step'] : 1;
            $this->_name 			= ( isset( $data['name'] ) ) ? \esc_html($data['name']) : null;
            $this->_option_cls 		= ( isset( $data['option_cls'] ) ) ? $data['option_cls'] : null;
            $this->_options 		= ( isset( $data['options'] ) ) ? $data['options'] : null;
            $this->_min 			= ( isset( $data['min'] ) ) ? $data['min'] : null;
            $this->_max 			= ( isset( $data['max'] ) ) ? $data['max'] : null;
            $this->_args			= ( isset( $data['args'] ) ) ? $data['args'] : array();
            $this->_prefix 			= ( isset( $data['prefix'] ) ) ? $data['prefix'] : null;
            $this->_suffix 			= ( isset( $data['suffix'] ) ) ? $data['suffix'] : null;
            $this->_source 			= ( isset( $data['source'] ) ) ? $data['source'] : null;
            $this->_placeholder 	= ( isset( $data['placeholder'] ) ) ? $data['placeholder'] : null;
            $this->_editor 			= ( isset( $data['editor'] ) ) ? $data['editor_settings'] : null;
            $this->_height 			= ( isset( $data['height'] ) ) ? $data['height'] : null;
            $this->_link            = ( isset( $data['link'] ) ) ? $data['link'] : '';
            $this->_upload_title 	= __( "Insert ", 'molongui-authorship' ) . $this->_name;
            $this->_upload_button	= __( "Choose as ", 'molongui-authorship' ) . $this->_name;
$this->_options_prefix	= $prefix;
        }
        private function _help()
        {
            $help = '';

            if ( !empty( $this->_data['help'] ) )
            {
                if ( isset( $this->_data['help']['link'] ) and \is_array( $this->_data['help']['link'] ) )
                {
                    $label  = empty( $this->_data['help']['link']['label']  ) ? __( "Learn more", 'molongui-authorship' ) : $this->_data['help']['link']['label'];
                    $target = empty( $this->_data['help']['link']['target'] ) ? 'internal' : $this->_data['help']['link']['target'];
                    $url    = empty( $this->_data['help']['link']['url']    ) ? '' : \esc_url( $this->_data['help']['link']['url'] );

                    if ( 'external' === $target )
                    {
                        $url .= '?source=settings-'.\str_replace( '_', '-', $this->_data['id'] ).'&amp;site='.\molongui_get_domain();
                    }
                }
                elseif ( isset( $this->_data['help']['link'] ) )
                {
                    $label = __( "Learn more", 'molongui-authorship' );
                    $url   = empty( $this->_data['help']['link'] ) ? '' : \esc_url( $this->_data['help']['link'] ).'?source=settings-'.\str_replace( '_', '-', $this->_data['id'] ).'&amp;site='.\molongui_get_domain();
                }

                \ob_start();
                ?>
                <div class="m-support-info">
                    <button class="m-info-popup m-info-popup-button">
                        <svg class="gridicon gridicons-info-outline needs-offset" height="18" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g><path d="M13 9h-2V7h2v2zm0 2h-2v6h2v-6zm-1-7c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8m0-2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2z"></path></g>
                        </svg>
                        <span class="screen-reader-text"><?php echo !empty( $label ) ? $label : __( "Option help", 'molongui-authorship' ) ?></span>
                    </button>
                </div>
                <div class="ui popup mini left center transition">
                    <div class="m-support-info-description">
                        <?php echo ( \is_array( $this->_data['help'] ) ? $this->_data['help']['text'] : $this->_data['help'] ); ?>
                    </div>
                    <?php if ( !empty( $url ) ) : ?>
                        <div class="m-support-info-link">
                            <a href="<?php echo $url; ?>" target="_blank">
                                <?php echo $label ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                $help .= \ob_get_clean();
            }

            return $help;
        }
        private function prepend()
        {
            $help  = $this->_help();
            $group = empty( $this->_group ) ? '' : ' data-m-group="'.$this->_group.'"';
            $deps  = empty( $this->_data['deps'] ) ? ' data-m-deps="1"' : ' data-deps="'.$this->_data['deps'].'" data-m-deps="1"';
            $hide  = empty( $this->_data['advanced'] ) ? '' : ' data-m-option="advanced" data-m-hide="1" style="display: none;"';

            $html  = '<div class="m-card '. ( empty( $this->_data['class'] ) ? '' : $this->_data['class'] ).'"'. $group . $deps . $hide . ' >';
            $html .= $help;
            $html .= !empty( $this->_data['title'] ) ? '<div class="m-option-title">'.$this->_data['title'].'</div>'  : '';
            $html .= !empty( $this->_data['desc']  ) ? '<p class="m-option-description">'.$this->_data['desc'].'</p>' : '';

            $class = empty( $this->_data['notice'] ) ? '' : ' has-notice';
            $html .= '<div class="m-option' . $class . '">';

            return $html;
        }
        private function append()
        {
            $html  = '';
            $html .= empty( $this->_data['notice'] ) ? '' : '<div class="m-option-notice">'.$this->_data['notice'].'</div>';
            $html .= '</div>'; // Close .m-option
            $html .= '</div>'; // Close .m-card

            return $html;
        }
        public function __toString()
        {
            switch ( $this->_type )
            {
                case 'notice':          return $this->notice();          break;
                case 'title':           return $this->title();           break;
                case 'text':            return $this->text();            break;
                case 'inline-text':     return $this->inline_text();     break;
                case 'color':           return $this->color();           break;
                case 'textarea':        return $this->textarea();        break;
                case 'radio':           return $this->radio();           break;
                case 'radio-text':      return $this->radio_text();      break;
                case 'number':          return $this->number();          break;
                case 'inline-number':   return $this->inline_number();   break;
                case 'button':          return $this->button();          break;
                case 'export':          return $this->export();          break;
                case 'header':          return $this->header();          break;
                case 'link':            return $this->link();            break;
                case 'toggle':          return $this->toggle();          break;
                case 'toggle-group':    return $this->toggle_group();    break;
                case 'dropdown':        return $this->dropdown();        break;
                case 'inline-dropdown': return $this->inline_dropdown(); break;
                case 'banner':          return $this->banner();          break;
                case 'select_wp_page':  return $this->select_wp_page();  break;
                case 'unveil':          return $this->unveil();          break;
                default	:               return '';
            }
        }
        private function title()
        {
            return '<h2 class="m-section-title">'.$this->_data['label'].'</h2>';
        }
        private function header()
        {
            $output = '';

            \ob_start();
            ?>
            <div class="m-card m-card-header <?php echo ( empty( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>" <?php echo empty( $this->_data['id'] ) ? '' : 'id="'.$this->_data['id'].'"'; ?> <?php echo ( empty ( $this->_data['deps'] ) ? '' : 'data-deps="'.$this->_data['deps'].'"' ); ?>>
                <div class="m-card-header__label">
                    <span class="m-card-header__label-text"><?php echo $this->_data['label']; ?></span>
                </div>
                <?php if ( !empty( $this->_data['buttons'] ) ) : ?>
                    <div class="m-card-header__actions">
                        <?php foreach ( $this->_data['buttons'] as $button ) :
                            if ( !$button['display'] ) continue;
                            switch ( $button['type'] ) :
                                case 'input': ?>
                                    <input type="file" <?php echo empty( $button['id'] ) ? '' : 'id="'.$button['id'].'" name="'.$button['id'].'"'; ?> class="m-file-upload" accept="<?php echo $button['accept']; ?>" data-multiple-caption="{count} files selected" <?php echo ( $button['multi'] ? 'multiple' : '' ); ?> />
                                    <label for="<?php echo empty( $button['id'] ) ? '' : $button['id']; ?>" class="m-button is-compact <?php echo $button['class']; ?>"><?php echo $button['label']; ?></label>
                                <?php break; ?>
                                <?php case 'download': ?>
                                    <button type="submit" <?php echo empty( $button['id'] ) ? '' : 'id="'.$button['id'].'"'; ?> <?php echo empty( $button['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button is-compact <?php echo $button['class']; ?>" title="<?php echo $button['title']; ?>"><?php echo $button['label']; ?></button>
                                <?php break; ?>
                                <?php case 'action': ?>
                                    <button type="submit" <?php echo empty( $button['id'] ) ? '' : 'id="'.$button['id'].'"'; ?> <?php echo empty( $button['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button is-compact <?php echo $button['class']; ?>" title="<?php echo $button['title']; ?>"><?php echo $button['label']; ?></button>
                                <?php break; ?>
                                <?php case 'link': ?>
                                    <a <?php echo empty( $button['id'] ) ? '' : 'id="'.$button['id'].'"'; ?> class="m-button is-secondary is-compact <?php echo $button['class']; ?>" href="<?php echo $button['href']; ?>" target="<?php echo empty( $button['target'] ) ? '_self' : $button['target']; ?>" title="<?php echo $button['title']; ?>" <?php echo empty( $button['disabled'] ) ? '' : 'disabled=""'; ?>>
                                        <?php echo $button['label']; ?>
                                    </a>
                                <?php break; ?>
                                <?php case 'advanced': ?>
                                    <button type="" <?php echo empty( $button['id'] ) ? '' : 'id="'.$button['id'].'"'; ?> <?php echo empty( $button['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button m-button-advanced is-secondary is-compact <?php echo $button['class']; ?>" title="<?php echo $button['title']; ?>" data-m-target="<?php echo str_replace( '_header', '', $this->_data['id'] ); ?>" data-m-state="hidding"><?php echo $button['label']; ?></button>
                                    <?php break; ?>
                                <?php case 'save':default: ?>
                                    <button type="submit" <?php echo empty( $button['id'] ) ? '' : 'id="'.$button['id'].'"'; ?> <?php echo empty( $button['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button m-button-save is-compact <?php echo $button['class']; ?>" title="<?php echo $button['title']; ?>"><?php echo $button['label']; ?></button>
                                <?php break; ?>
                            <?php endswitch; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            $output .= \ob_get_clean();

            return $output;
        }
        private function link()
        {
            $output = '';
            \ob_start();
            ?>
            <a class="m-card is-card-link is-compact <?php echo ( empty( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>" <?php echo empty( $this->_data['id'] ) ? '' : 'id="'.$this->_data['id'].'"'; ?> href="<?php echo $this->_data['href']; ?>" target="<?php echo $this->_data['target']; ?>" title="<?php echo ( empty( $this->_data['help'] ) ? '' : $this->_data['help'] ); ?>" <?php echo ( empty ( $this->_data['deps'] ) ? '' : 'data-deps="'.$this->_data['deps'].'"' ); ?>>
                <svg class="gridicon gridicons-external m-card__link-indicator" height="24" width="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M19 13v6c0 1.105-.895 2-2 2H5c-1.105 0-2-.895-2-2V7c0-1.105.895-2 2-2h6v2H5v12h12v-6h2zM13 3v2h4.586l-7.793 7.793 1.414 1.414L19 6.414V11h2V3h-8z"></path></g></svg>
                <?php echo $this->_data['label']; ?>
            </a>
            <?php
            $output .= \ob_get_clean();

            return $output;
        }
        private function banner()
        {
            $output = '';
            $group  = empty( $this->_group )            ? '' : ' data-m-group="'.$this->_group.'"';
            $deps   = empty( $this->_data['deps'] )     ? ' data-m-deps="1"' : ' data-deps="'.$this->_data['deps'].'" data-m-deps="1"';
            $hide  = empty( $this->_data['advanced'] ) ? '' : ' data-m-option="advanced" data-m-hide="1" style="display: none;"';
            $title  = empty( $this->_data['title'] )    ? $this->_data['label'] : $this->_data['title'];
            $desc   = empty( $this->_data['desc'] )     ? false : true;
            $button = empty( $this->_data['button'] )   ? false : true;
            $badge  = empty( $this->_data['badge'] )    ? __( "PRO", 'molongui-authorship' ) : $this->_data['badge'];

            \ob_start();
            ?>
            <div class="m-card m-banner <?php echo ( empty( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>"
                 id="<?php echo $this->_data['id'].'_ad'; ?>"
                 <?php echo $group . $deps . $hide; ?>>
                <div class="m-banner__icon-plan">
                    <div class="m-plan-icon">
                        <div class="m-plan-icon__text">
                            <?php echo $badge; ?>
                        </div>
                    </div>
                </div>
                <div class="m-banner__content">
                    <div class="m-banner__info">
                        <div class="m-banner__title"><?php echo $title; ?></div>
                        <?php if ( $desc ) : ?>
                            <div class="m-banner__description"><?php echo $this->_data['desc']; ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if ( $button ) : ?>
                        <div class="m-banner__action">
                            <a href="<?php echo $this->_data['button']['href']; ?>?source=<?php echo 'settings-'.str_replace( '_', '-', $this->_data['id'] ); ?>&amp;site=<?php echo molongui_get_domain(); ?>" target="<?php echo $this->_data['button']['target']; ?>" type="button" class="m-button is-compact is-primary <?php echo $this->_data['button']['class']; ?>" <?php echo !empty( $this->_data['button']['title'] ) ? 'title="'.$this->_data['button']['title'].'"' : ''; ?>><?php echo $this->_data['button']['label']; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            $output .= \ob_get_clean();

            return $output;
        }
        private function notice()
        {
            $title = empty( $this->_data['title'] ) ? '' : $this->_data['title'];
            $title = empty( $this->_data['link']  ) ? $title : '<a href="'.\esc_url( $this->_data['link'] ).'" target="_blank">'.$this->_data['title'].'</a>';
            $help  = $this->_help();

            $output  = '';
            $output .= '<div class="m-card '. ( empty( $this->_data['class'] ) ? '' : $this->_data['class'] ) . '"' . ( empty( $this->_data['id'] ) ? '' : 'id="'.$this->_data['id'].'"' ) . '>';
            $output .= $help;
            $output .= !empty( $this->_data['title'] ) ? '<div class="m-option-title">'.$title.'</div>'  : '';
            $output .= !empty( $this->_data['desc']  ) ? '<p class="m-option-description">'.$this->_data['desc'].'</p>' : '';
            $output .= '</div>';

            return $output;
        }
        private function toggle()
        {
            $output  = $this->prepend();

            $output .= '<label for="'.$this->_id.'" class="custom-switch m-toggle '.$this->_data['class'].'">';
            $output .= '<input type="checkbox" class="custom-switch-input" id="'.$this->_id.'" name="'.$this->_id.'" '.\checked( $this->_value, true, false ).'>';
            $output .= '<span class="custom-switch-indicator"></span>';
            $output .= '<span class="custom-switch-description">'.$this->_data['label'].'</span>';
            $output .= '</label>';

            $output .= $this->append();

            return $output;
        }
        private function toggle_group()
        {
            $output  = $this->prepend();
            $output .= '<div class="m-toggle-group">';

            foreach( $this->_data['toggles'] as $toggle )
            {
                $value = ( ( isset( $toggle['id'] ) and isset( $this->_saved[$toggle['id']] ) ) ? \esc_html( $this->_saved[$toggle['id']] ) : $toggle['default'] );

                $output .= '<label for="'.$toggle['id'].'" class="custom-switch m-toggle">';
                $output .= '<input type="checkbox" class="custom-switch-input" id="'.$toggle['id'].'" name="'.$toggle['id'].'" '.\checked( $value, true, false ).'>';
                $output .= '<span class="custom-switch-indicator"></span>';
                $output .= '<span class="custom-switch-description">'.$toggle['label'].'</span>';
                $output .= '</label>';
            }

            $output .= '</div>';
            $output .= $this->append();

            return $output;
        }
        private function dropdown()
        {
            $value  = $this->_value;
            $multi  = empty( $this->_data['atts']['multi']  ) ? '' : 'multiple';
            $search = empty( $this->_data['atts']['search'] ) ? '' : 'search';

            $output = $this->prepend();
            \ob_start();
            ?>
            <div class="ui dropdown selection fluid <?php echo $multi; ?> <?php echo $search; ?> <?php echo $this->_data['class']; ?>">
                <input type="hidden" id="<?php echo $this->_id; ?>" name="<?php echo $this->_id; ?>" value="<?php echo $value; ?>">
                <i class="dropdown icon"></i>
                <div class="text default"><?php echo $this->_data['default']; ?></div>
                <div class="menu">
                    <!--
                    <div class="ui icon search input">
                        <i class="search icon"></i>
                        <input type="text" placeholder="Search tags...">
                    </div>
                    <div class="divider"></div>-->
                    <?php foreach( $this->_data['options'] as $option ) : ?>
                        <div class="item <?php echo ( !empty( $option['disabled'] ) ? 'disabled' : '' ); ?>" data-value="<?php echo $option['id']; ?>">
                            <?php if ( !empty( $option['icon'] ) ) : ?><i class="<?php echo $option['icon']; ?>"></i><?php endif; ?>
                            <?php if ( !empty( $option['disabled'] ) ) : ?>
                                <span class="description is-pro"><?php _e( "PRO", 'molongui-authorship' ); ?></span>
                                <span class="text"><?php echo $option['label']; ?></span>
                            <?php else : ?>
                                <?php echo $option['label']; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function inline_dropdown()
        {
            $saved = $this->_value;
            if ( !empty( $saved ) and !empty( $this->_data['options'][$saved]['label'] ) )
            {
                $value = $this->_data['options'][$saved]['label'];
            }
            else
            {
                if ( !empty( $this->_data['default'] ) and isset( $this->_data['options'][$this->_data['default']] ) )
                {
                    $value = $this->_data['options'][$this->_data['default']]['label'];
                }
                else
                {
                    $value = $this->_data['options'][\array_keys( $this->_data['options'] )[0]]['label'];
                }
            }
            $tmp = \explode( '{input}', $this->_data['label'] );
            foreach ( $tmp as $key => $part ) if ( !empty( $part ) ) $tmp[$key] = '<label class="label-inline-dropdown" for="'.$this->_id.'">'.$part.'</label>';
            $label = $tmp[0].'{input}'.$tmp[1];

            \ob_start();
            ?>
            <div class="ui dropdown inline <?php echo $this->_data['class']; ?>">
                <input type="text" id="<?php echo $this->_id; ?>" name="<?php echo $this->_id; ?>" value="<?php echo $saved; ?>">
                <div class="text"><?php echo $value; ?></div>
                <i class="dropdown icon"></i>
                <div class="menu transition hidden">
                    <?php foreach( $this->_data['options'] as $id => $option ) : ?>
                        <div class="item <?php echo ( $saved === $id ? 'active' : '' ); ?> <?php echo ( !empty( $option['disabled'] ) ? 'disabled' : '' ); ?>" data-text="<?php echo $option['label']; ?>" data-value="<?php echo $id; ?>">
                            <?php if ( !empty( $option['icon'] ) ) : ?><i class="<?php echo $option['icon']; ?>"></i><?php endif; ?>
                            <?php echo $option['label']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php

            $inline  = \ob_get_clean();
            $output  = $this->prepend();
            $output .= \str_replace( '{input}', $inline, $label );
            $output .= $this->append();

            return $output;
        }
        private function select_wp_page()
        {
            $args = array
            (
                'child_of'    => 0,
                'sort_order'  => 'ASC',
                'sort_column' => 'post_title',
                'exclude'     => array(),
                'include'     => array(),
                'authors'     => '',
                'parent'      => -1,
                'number'      => 0,
                'offset'      => 0,
                'post_type'   => 'page',
                'post_status' => 'publish',
            );
            $wp_pages = \get_pages( $args );
            $options = array();
            foreach ( $wp_pages as $wp_page )
            {
                $options[$wp_page->ID]['label'] = $wp_page->post_title;
            }
            $this->_data['options'] = $options;
            $this->_data['class']   = 'search'; // Add a scroll if more than 8 items to list.
            return $this->inline_dropdown();
        }
        private function radio()
        {
            $output = $this->prepend();
            \ob_start();
            ?>
            <div class="custom-controls-stacked">
                <?php foreach( $this->_data['options'] as $key => $option ) : ?>
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="<?php echo $this->_id . '_' . $key; ?>" name="<?php echo $this->_id; ?>" data-id="<?php echo $this->_id; ?>" value="<?php echo $option['value']; ?>" <?php \checked( $this->_value, $option['value'], true ); ?>>
                        <div class="custom-control-label"><?php echo $option['label']; ?></div>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function radio_text()
        {
            $output = $this->prepend();

            \ob_start();
            ?>
            <div class="selectgroup <?php echo $this->_id; ?>">
                <?php foreach( $this->_data['options'] as $value => $label ) : ?>
                    <label class="selectgroup-item" for="<?php echo $this->_id.'_'.$value; ?>">
                        <input type="radio" id="<?php echo $this->_id.'_'.$value; ?>" name="<?php echo $this->_id; ?>" data-id="<?php echo $this->_id; ?>" value="<?php echo $value; ?>" class="selectgroup-input" <?php \checked( $this->_value, $value, true ); ?>>
                        <span class="selectgroup-button"><?php echo $label; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function number()
        {
            $output = $this->prepend();
            \ob_start();
            ?>
            <div class="m-number <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>">
                <label class="" for="<?php echo $this->_id; ?>">
                    <?php echo $this->_data['label']; ?>
                </label>
                <input type="number" id="<?php echo $this->_id; ?>" name="<?php echo $this->_id; ?>" value="<?php echo $this->_value; ?>" class="" min="<?php echo $this->_min; ?>" max="<?php echo $this->_max; ?>" placeholder="<?php echo $this->_data['placeholder']; ?>">
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function inline_number()
        {
            $output = $this->prepend();

            $input  = '<input type="number" id="'. $this->_id .'" name="'. $this->_id .'" value="'. $this->_value .'" class="" placeholder="'.$this->_data['placeholder'].'">';
            $inline = \str_replace( '{input}', $input, $this->_data['label'] );

            \ob_start();
            ?>
            <div class="m-inline-number <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>">
                <label class="" for="<?php echo $this->_id; ?>">
                    <?php echo $inline; ?>
                </label>
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function text()
        {
            $output = $this->prepend();
            \ob_start();
            ?>
            <div class="m-text">
                <label class="" for="<?php echo $this->_id; ?>">
                    <?php echo $this->_data['label']; ?>
                </label>
                <input type="text" id="<?php echo $this->_id; ?>" name="<?php echo $this->_id; ?>" value="<?php echo $this->_value; ?>" class="" placeholder="<?php echo $this->_data['placeholder']; ?>">

            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function inline_text()
        {
            $output = $this->prepend();

            $input  = '<input type="text" id="'. $this->_id .'" name="'. $this->_id .'" value="'. $this->_value .'" class="" placeholder="'.$this->_data['placeholder'].'">';
            $inline = \str_replace( '{input}', $input, $this->_data['label'] );

            \ob_start();
            ?>
            <div class="m-inline-text <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>">
                <label class="" for="<?php echo $this->_id; ?>">
                    <?php echo $inline; ?>
                </label>
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function color()
        {
            $output = $this->prepend();
            \ob_start();
            ?>
            <div class="m-color <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>">
                <label class="" for="<?php echo $this->_id; ?>">
                    <?php echo $this->_data['label']; ?>
                </label>
                <input type="text" class="colorpicker" id="<?php echo $this->_id; ?>" name="<?php echo $this->_id; ?>" value="<?php echo $this->_value; ?>">

            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function textarea()
        {
            $output = $this->prepend();
            \ob_start();
            ?>
            <div class="m-textarea <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>">
                <label class="" for="<?php echo $this->_id; ?>">
                    <?php echo $this->_data['label']; ?>
                </label>
                <textarea id="<?php echo $this->_id; ?>" name="<?php echo $this->_id; ?>" rows="<?php echo $this->_data['rows']; ?>" placeholder="<?php echo $this->_data['placeholder']; ?>"><?php echo $this->_value; ?></textarea>
            </div>
            <?php
            $output .= \ob_get_clean();
            $output .= $this->append();

            return $output;
        }
        private function button()
        {
            $output = '';
            $button = ( empty( $this->_data['button'] ) or !$this->_data['button']['display'] ) ? false : true;

            \ob_start();
            ?>
            <div class="m-card m-card-button <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>" <?php echo empty( $this->_data['id'] ) ? '' : 'id="'.$this->_data['id'].'"'; ?> <?php echo ( empty ( $this->_data['deps'] ) ? '' : 'data-deps="'.$this->_data['deps'].'"' ); ?>>
                <div class="m-card-button__label">
                    <span class="m-card-button__label-text"><?php echo $this->_data['label']; ?></span>
                </div>
                <?php if ( $button ) : ?>
                    <div class="m-card-button__actions">
                        <?php switch ( $this->_data['button']['type'] ) :
                            case 'input': ?>
                                <input type="file" <?php echo empty( $this->_data['button']['id'] ) ? '' : 'id="'.$this->_data['button']['id'].'" name="'.$this->_data['button']['id'].'"'; ?> class="m-file-upload" accept="<?php echo $this->_data['button']['accept']; ?>" data-multiple-caption="{count} files selected" <?php echo ( $this->_data['button']['multi'] ? 'multiple' : '' ); ?> />
                                <label for="<?php echo empty( $this->_data['button']['id'] ) ? '' : $this->_data['button']['id']; ?>" class="m-button is-compact <?php echo $this->_data['button']['class']; ?>"><?php echo $this->_data['button']['label']; ?></label>
                            <?php break; ?>
                            <?php case 'download': ?>
                                <button type="submit" <?php echo empty( $this->_data['button']['id'] ) ? '' : 'id="'.$this->_data['button']['id'].'"'; ?> <?php echo empty( $this->_data['button']['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button is-compact <?php echo $this->_data['button']['class']; ?>" title="<?php echo $this->_data['button']['title']; ?>"><?php echo $this->_data['button']['label']; ?></button>
                            <?php break; ?>
                            <?php case 'action': ?>
                                <button type="submit" <?php echo empty( $this->_data['button']['id'] ) ? '' : 'id="'.$this->_data['button']['id'].'"'; ?> <?php echo empty( $this->_data['button']['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button is-compact <?php echo $this->_data['button']['class']; ?>" title="<?php echo $this->_data['button']['title']; ?>"><?php echo $this->_data['button']['label']; ?></button>
                            <?php break; ?>
                            <?php case 'link': ?>
                                <button type="submit" <?php echo empty( $this->_data['button']['id'] ) ? '' : 'id="'.$this->_data['button']['id'].'"'; ?> <?php echo empty( $this->_data['button']['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button is-compact <?php echo $this->_data['button']['class']; ?>" title="<?php echo $this->_data['button']['title']; ?>"><?php echo $this->_data['button']['label']; ?></button>
                            <?php break; ?>
                            <?php case 'save':default: ?>
                                <button type="submit" <?php echo empty( $this->_data['button']['id'] ) ? '' : 'id="'.$this->_data['button']['id'].'"'; ?> <?php echo empty( $this->_data['button']['disabled'] ) ? '' : 'disabled=""'; ?> class="m-button m-button-save is-compact <?php echo $this->_data['button']['class']; ?>" title="<?php echo $this->_data['button']['title']; ?>"><?php echo $this->_data['button']['label']; ?></button>
                            <?php break; ?>
                            <?php endswitch; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            $output .= \ob_get_clean();

            return $output;
        }
        private function export()
        {
            $output = '';
            $button = ( empty( $this->_data['button'] ) or !$this->_data['button']['display'] ) ? false : true;
            $all_options = \wp_load_alloptions();
            $options_data = array();
            foreach( $all_options as $option_name => $this->_value )
            {
                if ( \substr( $option_name, 0, \strlen( $this->_options_prefix ) ) === $this->_options_prefix ) $options_data[$option_name] = $this->_value;
            }

            \ob_start();
            ?>
            <div class="m-card m-card-button <?php echo $this->_data['class']; ?>">
                <div class="m-card-button__label">
                    <span class="m-card-button__label-text"><?php echo $this->_data['label']; ?></span>
                </div>
                <?php if ( $button ) : ?>
                    <div class="m-card-button__actions">
                        <textarea readonly id="export_field" name="export_field"><?php echo \base64_encode( \json_encode( $options_data ) ); ?></textarea>
                        <label id="<?php echo empty( $this->_data['button']['id'] ) ? '' : $this->_data['button']['id']; ?>" for="<?php echo empty( $this->_data['button']['id'] ) ? '' : $this->_data['button']['id']; ?>" class="m-button is-compact <?php echo $this->_data['button']['class']; ?>"><?php echo $this->_data['button']['label']; ?></label>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            $output .= \ob_get_clean();

            return $output;
        }
        private function unveil()
        {
            $output = '';

            \ob_start();
            ?>
            <div id="<?php echo $this->_id; ?>" class="m-unveil <?php echo ( empty ( $this->_data['class'] ) ? '' : $this->_data['class'] ); ?>"
                 data-show="<?php echo $this->_data['label']['show']; ?>" data-hide="<?php echo $this->_data['label']['hide']; ?>">
                <span>
                    <?php echo $this->_data['label']['show']; ?>
                </span>
            </div>
            <?php
            $output .= \ob_get_clean();

            return $output;
        }

    } // End of class
} // End if_class_exists