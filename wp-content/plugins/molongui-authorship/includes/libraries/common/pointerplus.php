<?php

namespace Molongui\Authorship\Includes\Libraries\Common;
\defined( 'ABSPATH' ) or exit;
if ( !\class_exists( 'Molongui\Authorship\Includes\Libraries\Common\PointerPlus' ) )
{
    /*!
     * Super pointer creation for WP Admin.
     *
     * @package   PointerPlus
     * @version   1.0.1
     * @author    QueryLoop & Mte90
     * @link      http://mte90.net
     * @license   GPL-3.0+
     * @copyright 2014-2018 GPL
     */
    class PointerPlus {
        var $prefix = 'pointerplus';
        var $pointers = array();
        function __construct( $args = array() ) {
            if ( isset( $args[ 'prefix' ] ) ) {
                $this->prefix = $args[ 'prefix' ];
            }
            add_action( 'current_screen', array( $this, 'maybe_add_pointers' ) );
        }
        function initial_pointers() {
            global $pagenow;
            $defaults = array(
                'class' => '',
                'width' => 300, //only fixed value
                'align' => 'middle',
                'edge' => 'left',
                'post_type' => array(),
                'pages' => array(),
                'icon_class' => ''
            );
            $screen = get_current_screen();
            $current_post_type = isset( $screen->post_type ) ? $screen->post_type : false;
            $search_pt = false;

            $pointers = apply_filters( $this->prefix . '-pointerplus_list', array(
            ), $this->prefix );

            foreach ( $pointers as $key => $pointer ) {
                $pointers[ $key ] = wp_parse_args( $pointer, $defaults );
                $search_pt = false;
                $pointers[ $key ][ 'post_type' ] = array_filter( $pointers[ $key ][ 'post_type' ] );
                if ( !empty( $pointers[ $key ][ 'post_type' ] ) ) {
                    if ( !empty( $current_post_type ) ) {
                        if ( is_array( $pointers[ $key ][ 'post_type' ] ) ) {
                            foreach ( $pointers[ $key ][ 'post_type' ] as $value ) {
                                if ( $value === $current_post_type ) {
                                    $search_pt = true;
                                }
                            }
                            if ( $search_pt === false ) {
                                unset( $pointers[ $key ] );
                            }
                        } else {
                            new WP_Error( 'broke', __( 'PointerPlus Error: post_type is not an array!' ) );
                        }
                    } else {
                        unset( $pointers[ $key ] );
                    }
                }
                if ( isset( $pointers[ $key ][ 'pages' ] ) ) {
                    if ( is_array( $pointers[ $key ][ 'pages' ] ) ) {
                        $pointers[ $key ][ 'pages' ] = array_filter( $pointers[ $key ][ 'pages' ] );
                    }

                    if ( !empty( $pointers[ $key ][ 'pages' ] ) ) {
                        if ( is_array( $pointers[ $key ][ 'pages' ] ) ) {
                            foreach ( $pointers[ $key ][ 'pages' ] as $value ) {
                                if ( $pagenow === $value ) {
                                    $search_pt = true;
                                }
                            }

                            if ( $search_pt === false ) {
                                unset( $pointers[ $key ] );
                            }
                        } else {
                            new WP_Error( 'broke', __( 'PointerPlus Error: pages is not an array!' ) );
                        }
                    }
                }
            }

            return $pointers;
        }
        function maybe_add_pointers() {
            $default_keys = $this->initial_pointers();
            $dismissed = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
            $diff = array_diff_key( $default_keys, array_combine( $dismissed, $dismissed ) );
            if ( !empty( $diff ) ) {
                $this->pointers = $diff;
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_assets' ) );

                foreach ( $diff as $pointer ) {
                    if ( isset( $pointer[ 'phpcode' ] ) ) {
                        add_action( 'admin_notices', $pointer[ 'phpcode' ] );
                    }
                }
            }
            $this->pointers[ 'l10n' ] = array
            (
                'next'    => __( 'Next' ),
                'dismiss' => __( 'Dismiss' ),
            );
        }
        function admin_enqueue_assets() {
            $base_url = MOLONGUI_AUTHORSHIP_URL; //plugins_url( '', __FILE__ );
            wp_enqueue_style( $this->prefix, $base_url . ( is_rtl() ? 'assets/vendor/pointerplus/pointerplus-rtl.0390.min.css' : 'assets/vendor/pointerplus/pointerplus.060f.min.css' ), array( 'wp-pointer' ) );
            wp_enqueue_script( $this->prefix, $base_url . 'assets/vendor/pointerplus/pointerplus.e75e.min.js?var=' . str_replace( '-', '_', $this->prefix ) . '_pointerplus', array( 'wp-pointer' ) );
            wp_localize_script( $this->prefix, str_replace( '-', '_', $this->prefix ) . '_pointerplus', apply_filters( $this->prefix . '_pointerplus_js_vars', $this->pointers ) );
        }
        function reset_pointer() {
            add_action( 'current_screen', array( $this, '_reset_pointer' ), 0 );
        }
        function _reset_pointer( $id = 'me' ) {
            if ( $id === 'me' ) {
                $id = get_current_user_id();
            }

            $pointers = explode( ',', get_user_meta( $id, 'dismissed_wp_pointers', true ) );
            foreach ( $pointers as $key => $pointer ) {
                if ( strpos( $pointer, $this->prefix ) === 0 ) {
                    unset( $pointers[ $key ] );
                }
            }

            $meta = implode( ',', $pointers );
            update_user_meta( get_current_user_id(), 'dismissed_wp_pointers', $meta );
        }

    }
}