<?php
defined( 'ABSPATH' ) or exit;

add_filter( 'wpml_translatable_user_meta_fields', 'authorship_add_user_meta_fields_to_wpml' );
add_filter( 'authorship/filter_author_link', 'authorship_dont_filter_author_link_for_wpml', 10, 2 );
add_filter( 'icl_ls_languages', 'authorship_wpml_translated_author_urls_fix', 10, 2 );
function authorship_add_user_meta_fields_to_wpml( $user_meta_fields )
{
    $user_meta_fields[] = 'user_url'; // from users table
    $user_meta_fields[] = 'molongui_author_phone';
    $user_meta_fields[] = 'molongui_author_job';
    $user_meta_fields[] = 'molongui_author_company';
    $user_meta_fields[] = 'molongui_author_company_link';
    $user_meta_fields[] = 'molongui_author_short_bio';
$user_meta_fields[] = 'molongui_author_long_bio';

    return $user_meta_fields;
}
function authorship_dont_filter_author_link_for_wpml( $default, $args )
{
    $fn = 'add_author_url_to_ls_lang';

    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) )
    {
        return true;
    }
    return $default;
}
function authorship_wpml_translated_author_urls_fix( $w_active_languages )
{
    if ( is_author() )
    {
        $languages = apply_filters( 'wpml_setting', false, 'active_languages' );

        if ( !empty( $languages ) )
        {
            global $wp_query;

            if ( is_guest_author() and isset( $wp_query->guest_author_id ) )
            {
                foreach ( $languages as $lang )
                {
                    if ( !empty( $w_active_languages[$lang] ) )
                    {
                        $id = apply_filters( 'wpml_object_id', $wp_query->guest_author_id, 'guest_author', false, $lang );
                        $author   = new Molongui\Authorship\Includes\Author( $id, 'guest' );
                        $wpml_url = apply_filters( 'wpml_permalink', $author->get_url(), $lang );
                        $w_active_languages[$lang]['url'] = $wpml_url;
                    }
                    else
                    {
                        $id = apply_filters( 'wpml_object_id', $wp_query->guest_author_id, 'guest_author', false, $lang );
                        global $sitepress;
                        $temp_lang_switch = new WPML_Temporary_Switch_Language( $sitepress, $lang );
                        $author = new Molongui\Authorship\Includes\Author( $id, 'guest' );

                        $args = array
                        (
                            'cat'                 => '',
                            'fields'              => 'ids',
                            'ignore_sticky_posts' => true,
                            'meta_query'          => '',
                            'no_found_rows'       => true,
                            'offset'              => '',
                            'order'               => '',
                            'orderby'             => '',
                            'post__in'            => '',
                            'post__not_in'        => '',
                            'post_type'           => 'selected',
                            'post_status'         => array( 'publish' ),
                            'posts_per_page'      => '-1',
                            'author_id'           => $wp_query->guest_author_id,
                            'author_type'         => 'guest',
                            'site_id'             => get_current_blog_id(),
                            'language'            => $lang,
                        );
                        $posts = $author->get_posts( $args );
                        $temp_lang_switch->restore_lang();
                        if ( !empty( $posts ) )
                        {
                            $wpml_url = apply_filters( 'wpml_permalink', $author->get_url(), $lang );
                            global $sitepress, $wpml_post_translations, $wpml_term_translations;
                            $current_language = $sitepress->get_current_language();
                            $languages_helper = new WPML_Languages( $wpml_term_translations, $sitepress, $wpml_post_translations );
                            $language_details = $languages_helper->get_ls_language( $lang, $current_language, false );

                            $w_active_languages[$lang]['code']             = $language_details['code'];
                            $w_active_languages[$lang]['id']               = $language_details['id'];
                            $w_active_languages[$lang]['native_name']      = $language_details['native_name'];
                            $w_active_languages[$lang]['major']            = $language_details['major'];
                            $w_active_languages[$lang]['active']           = $language_details['active'];
                            $w_active_languages[$lang]['default_locale']   = $language_details['default_locale'];
                            $w_active_languages[$lang]['encode_url']       = $language_details['encode_url'];
                            $w_active_languages[$lang]['tag']              = $language_details['tag'];
                            $w_active_languages[$lang]['missing']          = 0;
                            $w_active_languages[$lang]['translated_name']  = $language_details['translated_name'];
                            $w_active_languages[$lang]['url']              = $wpml_url;
                            $w_active_languages[$lang]['country_flag_url'] = $language_details['country_flag_url'];
                            $w_active_languages[$lang]['language_code']    = $language_details['language_code'];
                        }
                    }
                }
            }
            else
            {
                foreach ( $languages as $lang )
                {
                    if ( !empty( $w_active_languages[$lang] ) )
                    {
                        $author = new Molongui\Authorship\Includes\Author( get_queried_object_id(), 'user' );
                        $wpml_url = apply_filters( 'wpml_permalink', $author->get_url(), $lang );
                        $w_active_languages[$lang]['url'] = $wpml_url;
                    }
                    else
                    {
                        global $sitepress;
                        $temp_lang_switch = new WPML_Temporary_Switch_Language( $sitepress, $lang );
                        $author = new Molongui\Authorship\Includes\Author( get_queried_object_id(), 'user' );

                        $args = array
                        (
                            'cat'                 => '',
                            'fields'              => 'ids',
                            'ignore_sticky_posts' => true,
                            'meta_query'          => '',
                            'no_found_rows'       => true,
                            'offset'              => '',
                            'order'               => '',
                            'orderby'             => '',
                            'post__in'            => '',
                            'post__not_in'        => '',
                            'post_type'           => 'selected',
                            'post_status'         => array( 'publish' ),
                            'posts_per_page'      => '-1',
                            'author_id'           => get_queried_object_id(),
                            'author_type'         => 'user',
                            'site_id'             => get_current_blog_id(),
                            'language'            => $lang,
                        );
                        $posts = $author->get_posts( $args );
                        $temp_lang_switch->restore_lang();
                        if ( !empty( $posts ) )
                        {
                            $wpml_url = apply_filters( 'wpml_permalink', $author->get_url(), $lang );
                            global $sitepress, $wpml_post_translations, $wpml_term_translations;
                            $current_language = $sitepress->get_current_language();
                            $languages_helper = new WPML_Languages( $wpml_term_translations, $sitepress, $wpml_post_translations );
                            $language_details = $languages_helper->get_ls_language( $lang, $current_language, false );

                            $w_active_languages[$lang]['code']             = $language_details['code'];
                            $w_active_languages[$lang]['id']               = $language_details['id'];
                            $w_active_languages[$lang]['native_name']      = $language_details['native_name'];
                            $w_active_languages[$lang]['major']            = $language_details['major'];
                            $w_active_languages[$lang]['active']           = $language_details['active'];
                            $w_active_languages[$lang]['default_locale']   = $language_details['default_locale'];
                            $w_active_languages[$lang]['encode_url']       = $language_details['encode_url'];
                            $w_active_languages[$lang]['tag']              = $language_details['tag'];
                            $w_active_languages[$lang]['missing']          = 0;
                            $w_active_languages[$lang]['translated_name']  = $language_details['translated_name'];
                            $w_active_languages[$lang]['url']              = $wpml_url;
                            $w_active_languages[$lang]['country_flag_url'] = $language_details['country_flag_url'];
                            $w_active_languages[$lang]['language_code']    = $language_details['language_code'];
                        }
                    }
                }
            }
        }
    }

    return $w_active_languages;
}