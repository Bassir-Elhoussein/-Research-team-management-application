<?php

namespace Molongui\Authorship\Includes;
\defined( 'ABSPATH' ) or exit;
class Author
{
    private $id;
    private $type;
    private $author;
    private $display_errors;
	public function __construct( $id = null, $type = null, $object = null, $errors = false )
    {
        $this->display_errors = $errors;
        $this->id   = $id;
        $this->type = $type;
        if ( $object === false )
        {
            $this->author = null;
            return;
        }
        if ( !empty( $object ) and \is_object( $object ) )
        {
            $this->author = $object;
            return;
        }
        if ( $this->validate( $this->id, $this->type, $errors ) )
        {
            $this->author = $this->get( $this->id, $this->type );
        }
        else
        {
            $this->author = null;
        }
    }
    public function validate( &$id = null, &$type = null, $detail = true, $find = true )
    {
        if ( empty( $id ) and empty( $type ) )
        {
            if ( $find )
            {
                if ( !$authors = \molongui_find_authors() ) return ( $detail ? __( 'No author ID nor author type provided. Please, indicate both values.', 'molongui-authorship' ) : false );
                $id   = $authors[0]->id;
                $type = $authors[0]->type;
            }
            else
            {
                return ( $detail ? __( 'No author ID nor author type provided. Please, provide author id and type when instantiating the Author Class.', 'molongui-authorship' ) : false );
            }
        }
        if ( ( empty( $id ) or empty( $type ) ) and $id != 0 ) return ( $detail ? __( 'No author id or author type provided. Please, indicate both values.', 'molongui-authorship' ) : false );
        if ( !\is_numeric( $id ) or $id == 0 ) return ( $detail ? __( "Wrong id provided. It must be an integer higher than 0.", 'molongui-authorship' ) : false );
        $type = \is_string( $type ) ? \strtolower( $type ) : '';
        if ( !\in_array( $type, array( 'user', 'guest' ) ) ) return ( $detail ? __( "No accepted author type provided. Please, indicate 'user' or 'guest'.", 'molongui-authorship' ) : false );
        switch ( $type )
        {
            case 'user':
                if ( !\in_array( $id, \molongui_get_users( array( 'fields' => 'ID' ) ) ) ) return ( $detail ? \sprintf( __( 'No user exists with the given ID (%s).', 'molongui-authorship' ), $id ) : false );
            break;

            case 'guest':
                if ( !\in_array( $id, \molongui_get_guests( array( 'fields' => 'ids' ) ) ) ) return ( $detail ? \sprintf( __( 'No guest author exists with the given ID (%s).', 'molongui-authorship' ), $id ) : false );
            break;
        }
        return true;
    }
    public function get( $id = null, $type = null, $validate = false, $detail = false )
    {
        if ( $validate )
        {
            $validation = $this->validate( $id, $type, $detail );
            if ( !\is_bool( $validation ) or ( \is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
        }
        $id     = isset( $id ) ? $id : $this->id;
        $type   = isset( $type ) ? $type : $this->type;
        $author = null;
        switch ( $type )
        {
            case 'user':
                \add_filter( '_authorship/filter/get_user_by', '__return_list_false' );
                $author = \get_user_by( 'id', $id );
                \remove_filter( '_authorship/filter/get_user_by', '__return_list_false' );

            break;

            case 'guest':
                $author = \get_post( $id );

            break;
        }
        if ( ( !$author or !\is_object( $author ) ) and $detail ) $author = '<code class="m-a-warning">' . \sprintf( __( 'No %s exists with the given ID (%s).', 'molongui-authorship' ), ( $type == 'guest' ? __( 'guest author', 'molongui-authorship' ) : __( 'user', 'molongui-authorship' ) ), $id ) . '</code>';
        return \apply_filters( 'authorship/author/get', $author, $id, $type );
    }
    public function get_id()
    {
        return $this->id;
    }
    public function get_type()
    {
        return $this->type;
    }
    public function get_author()
	{
        return $this->author;
	}
	public function get_name()
	{
		$name = '';
        if ( !empty( $this->author ) )
        {
            $format = \apply_filters( 'authorship/author/name/format', 'display_name' );

            switch ( $this->type )
            {
                case 'user':

                    switch ( $format )
                    {
                        case 'first_name_first'    : $name = \get_user_meta( $this->id, 'first_name', true ) . ' '  . \get_user_meta( $this->id, 'last_name', true  ); break;
                        case 'last_name_first'     : $name = \get_user_meta( $this->id, 'last_name', true  ) . ', ' . \get_user_meta( $this->id, 'first_name', true ); break;
                        case 'display_name':default: $name = $this->author->display_name; break;
                    }

                break;

                case 'guest':
                    switch ( $format )
                    {
                        case 'first_name_first'    : $name = $this->get_meta( 'first_name' ) . ' '  . $this->get_meta( 'last_name'  ); break;
                        case 'last_name_first'     : $name = $this->get_meta( 'last_name'  ) . ', ' . $this->get_meta( 'first_name' ); break;
                        case 'display_name':default: $name = $this->author->post_title; break;
                    }

                break;
            }
        }
		if ( empty( $name ) and $this->display_errors ) $name = \sprintf( __( 'No %s exists with the given ID (%s).', 'molongui-authorship' ), ( $this->type == 'guest' ? __( 'guest author', 'molongui-authorship' ) : __( 'user', 'molongui-authorship' ) ), $this->id );
		return \apply_filters( 'authorship/author/name', $name, $this->id, $this->type, $this->author );
	}
	public function get_slug()
	{
		$slug = '';
        if ( !empty( $this->author ) )
        {
            switch ( $this->type )
            {
                case 'user':
                    $slug = $this->author->user_nicename;
                break;

                case 'guest':
                    $slug = $this->author->post_name;
                break;
            }
		}
		if ( empty( $slug ) and $this->display_errors ) $slug = \sprintf( __( 'No %s exists with the given ID (%s).', 'molongui-authorship' ), ( $this->type == 'guest' ? __( 'guest author', 'molongui-authorship' ) : __( 'user', 'molongui-authorship' ) ), $this->id );
		return \apply_filters( 'authorship/author/slug', $slug, $this->id, $this->type, $this->author );
	}
	public function get_url()
	{
		$url = '';
		$options = \authorship_get_options();
        if ( !empty( $this->author ) )
        {
            switch ( $this->type )
            {
                case 'user':
                    \add_filter( 'authorship/filter_author_link', '__return_true' );
                    \add_filter( 'molongui_authorship_dont_filter_name', '__return_true' );
                    \add_filter( '_authorship/filter/get_user_by', '__return_list_false' );
                    $url = \get_author_posts_url( $this->id, $this->author->user_nicename );
                    \remove_filter( 'authorship/filter_author_link', '__return_true' );
                    \remove_filter( 'molongui_authorship_dont_filter_name', '__return_true' );
                    \remove_filter( '_authorship/filter/get_user_by', '__return_list_false' );

                break;

                case 'guest':

                    $url = '#molongui-disabled-link';

                break;
            }
		}
		if ( empty( $url ) and $this->display_errors ) $url = \sprintf( __( 'No %s exists with the given ID (%s).', 'molongui-authorship' ), ( $this->type == 'guest' ? __( 'guest author', 'molongui-authorship' ) : __( 'user', 'molongui-authorship' ) ), $this->id );
		return \apply_filters( 'authorship/author/url', $url, $this->id, $this->type, $this->author, $options );
	}
	public function get_link()
	{
		$name = $url = $link = '';
        $name = $this->get_name();
        $url = $this->get_url();
		if ( !empty( $name ) and !empty( $url ) ) $link = '<a href="'.$url.'">'.$name.'</a>';
		return \apply_filters( 'authorship/author/link', $link, $name, $url, $this->id, $this->type, $this->author );
	}
	public function get_bio()
	{
		$bio = '';
        switch ( $this->type )
        {
            case 'user':
                \add_filter( '_authorship/filter/get_user_by', '__return_list_false' );
                \add_filter( 'authorship/get_the_author_description/skip', '__return_true' );
                $bio = \get_the_author_meta( 'description', $this->id );
                \remove_filter( '_authorship/filter/get_user_by', '__return_list_false' );
                \remove_filter( 'authorship/get_the_author_description/skip', '__return_true' );

            break;

            case 'guest':

                if ( !empty( $this->author ) ) $bio = $this->author->post_content;

            break;
        }
        $bio = \apply_filters( 'authorship/author/bio', $bio, $this->id, $this->type, $this->author );
		if ( empty( $bio ) and $this->display_errors ) $bio = \sprintf( __( 'No %s exists with the given ID (%s).', 'molongui-authorship' ), ( $this->type == 'guest' ? __( 'guest author', 'molongui-authorship' ) : __( 'user', 'molongui-authorship' ) ), $this->id );
        return $bio;
	}
	public function get_mail()
	{
		$mail = '';
        if ( !empty( $this->author ) )
        {
            switch ( $this->type )
            {
                case 'user':
                    $mail = $this->author->user_email;
                break;

                case 'guest':
                    $mail = \get_post_meta( $this->id, '_molongui_guest_author_mail', true );
                break;
            }
		}
		if ( empty( $mail ) and $this->display_errors ) $mail = \sprintf( __( 'No %s exists with the given ID (%s).', 'molongui-authorship' ), ( $this->type == 'guest' ? __( 'guest author', 'molongui-authorship' ) : __( 'user', 'molongui-authorship' ) ), $this->id );
		return \apply_filters( 'authorship/author/mail', $mail, $this->id, $this->type, $this->author );
	}
    public function get_meta( $key )
    {
        if ( empty( $key ) ) $meta = __( "Which meta do you want to retrieve? You need to provide a 'key' attribute.", 'molongui-authorship' );
        $meta = '';
        if ( !empty( $this->author ) )
        {
            switch ( $this->type )
            {
                case 'user':

                    switch ( $key )
                    {
                        case 'all'       : $meta = \get_user_meta( $this->id ); break;
                        case 'web'       : $meta = $this->author->user_url;     break;
                        case 'first_name': $meta = $this->author->first_name;   break;
                        case 'last_name' : $meta = $this->author->last_name;    break;
                        default          :
                            \add_filter( '_authorship/filter/get_user_by', '__return_list_false' );
                            $meta = \get_the_author_meta( 'molongui_author_'.$key, $this->id );
                            \remove_filter( '_authorship/filter/get_user_by', '__return_list_false' );

                        break;
                    }

                break;

                case 'guest':

                    if ( $key === 'all' )
                    {
                        $meta = \get_post_meta( $this->id );
                    }
                    else
                    {
                        $meta = \get_post_meta( $this->id, '_molongui_guest_author_'.$key, true );
                    }

                break;
            }
        }
        if ( empty( $meta ) and $this->display_errors ) $meta = \sprintf( __( 'No %s exists for this author (%s).', 'molongui-authorship' ), $key, $this->id );
        return \apply_filters( 'authorship/author/meta', $meta, $this->id, $this->type, $this->author, $key );
    }
	public function get_post_count( $post_types = null )
	{
		$count = array();

		if ( !isset( $post_types ) )
        {
            $post_types = \molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all' );
        }
        elseif ( !\is_array( $post_types ) )
        {
            $post_types = array( $post_types );
        }
        if ( !empty( $this->author ) )
        {
            switch ( $this->type )
            {
                case 'user':
                    foreach( $post_types as $post_type ) $count[$post_type] = $this->get_meta( $post_type.'_count' );
                break;

                case 'guest':
                    foreach( $post_types as $post_type ) $count[$post_type] = $this->get_meta( $post_type.'_count' );
                break;
            }
		}
		return \apply_filters( 'authorship/author/post_count', $count, $this->id, $this->type, $this->author, $post_types );
	}
	public function get_user_roles()
    {
        $user_roles = array();
        if ( empty( $this->author ) ) $this->author = $this->get( $this->id, $this->type );

        switch ( $this->type )
        {
            case 'user':
                $user_meta  = get_userdata( $this->id );
                $user_roles = $user_meta->roles;
            break;

            case 'guest':
                $user_roles = array( _x( "Guest author", 'User role', 'molongui-authorship' ) );
            break;
        }
        return \apply_filters( 'authorship/author/user_roles', $user_roles, $this->id, $this->type, $this->author );
    }
	public function get_user_login()
    {
        $user_login = array();
        if ( empty( $this->author ) ) $this->author = $this->get( $this->id, $this->type );

        switch ( $this->type )
        {
            case 'user':
                $user_login = $this->author->user_login;
            break;

            case 'guest':
                $user_login = '';
            break;
        }
        return \apply_filters( 'authorship/author/user_login', $user_login, $this->id, $this->type, $this->author );
    }
	public function get_avatar( $size = 'full', $context = 'screen', $source = null, $default = null )
	{
		$avatar  = '';
		$attr    = array();
        $options = \apply_filters( '_authorship/get_options', \authorship_get_options() );
        $size    = apply_filters( 'authorship/get_avatar/size', $size, $options );
        $context = apply_filters( 'authorship/get_avatar/context', $context, $options );
        $source  = apply_filters( 'authorship/get_avatar/source', $source, $options );
        $default = apply_filters( 'authorship/get_avatar/default', $default, $options );
        if ( \is_array( $size ) )
        {
            $width  = $size[0];
            $height = $size[1];
        }
        else
        {
            $sizes  = \wp_get_registered_image_subsizes();
            $size   = \in_array( $size, \array_keys( $sizes ) ) ? $size : 'authorship-box-avatar';
            $width  = $sizes[$size]['width'];
            $height = $sizes[$size]['height'];
            $size   = array( $width, $height );
        }
		if ( $context == 'box' )
		{
            if ( \authorship_is_feature_enabled( 'box_styles' ) )
            {
                $width  = $options['author_box_avatar_width'];
                $height = $options['author_box_avatar_height'];
                $size   = array( $width, $height );
            }
            if ( \authorship_is_feature_enabled( 'microdata' ) ) $attr = \array_merge( $attr, array( 'itemprop' => 'image' ) );
		}
        switch ( !empty( $source ) ? $source : ( !empty( $options['author_box_avatar_source'] ) ?  $options['author_box_avatar_source'] : '' ) )
        {
            case 'gravatar':
                if ( $context != 'url' ) $avatar = $this->get_gravatar( $this->get_mail(), \array_merge( $attr, array( 'width' => $width, 'height' => $height ) ), $options );
                else $avatar = \get_avatar_url( $this->get_mail() );

            break;

            case 'acronym':
                if ( $context != 'url' ) $avatar = $this->get_acronym( $this->get_name(), \array_merge( $attr, array( 'width' => $width, 'height' => $height ) ), $options );
                else $avatar = '';

            break;

            case 'local':
            default:

                if ( \authorship_is_feature_enabled( 'avatar' ) )
                {
                    switch ( $this->type )
                    {
                        case 'user':
                            if ( $img_id = \get_user_meta( $this->id, 'molongui_author_image_id', true ) )
                            {
                                if ( $context == 'url' ) $avatar = \wp_get_attachment_url( $img_id );
                                else $avatar = \wp_get_attachment_image( $img_id, $size, false, $attr );
                            }

                        break;

                        case 'guest':
                            if ( \has_post_thumbnail( $this->id ) )
                            {
                                if ( $context == 'url' ) $avatar = \get_the_post_thumbnail_url( $this->id, $size );
                                else $avatar = \get_the_post_thumbnail( $this->id, $size, $attr );
                            }

                        break;
                    }
                }
                if ( empty( $avatar ) and $context != 'url' )
                {
                    switch ( empty( $default ) ? $options['author_box_avatar_fallback'] : $default )
                    {
                        case 'gravatar':
                            $avatar = $this->get_gravatar( $this->get_mail(), \array_merge( $attr, array( 'width' => $width, 'height' => $height ) ), $options );

                        break;

                        case 'acronym':
                            $avatar = $this->get_acronym( $this->get_name(), \array_merge( $attr, array( 'width' => $width, 'height' => $height ) ), $options );

                        break;

                        case 'none':
                        default:

                        break;
                    }
                }

            break;
        }
		return \apply_filters( 'authorship/author/get_avatar', $avatar, $this->id, $this->type, $size, $context );
	}
	public function get_gravatar ( $mail, $attr, $options = array() )
	{
        if ( empty( $options ) ) $options = \authorship_get_options();
        $attr['force_display'] = true;
        $size  = \get_option( 'thumbnail_size_w', 96 );
        $has_w = !empty( $attr['width'] );
        $has_h = !empty( $attr['height'] );

        if     (  $has_w and  $has_h ) $size = \min( $attr['width'], $attr['height'] );
        elseif (  $has_w and !$has_h ) $size = $attr['width'];
        elseif ( !$has_w and  $has_h ) $size = $attr['height'];
        $attr['extra_attr']  = '';
        if ( \authorship_is_feature_enabled( 'microdata' ) ) $attr['extra_attr'] .= 'itemprop = "image"';
        $default = $options['author_box_avatar_default_gravatar'];
        if ( $default == 'random' )
        {
            $defaults = array( 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank' );
            $default  = $defaults[\array_rand( $defaults )];
        }
        \add_filter( 'authorship/get_avatar_data/skip', '__return_true' );
        $gravatar = \get_avatar( $mail, $size, $default, false, $attr );
        \remove_filter( 'authorship/get_avatar_data/skip', '__return_true' );
		return ( !$gravatar ? '' : $gravatar );
	}
	public function get_acronym ( $name, $attr, $options = array() )
	{
		if ( empty( $name ) ) return '';
		if ( empty( $options ) ) $options = \authorship_get_options();

		$class  = empty( $attr['class'] )  ? '' : $attr['class'];
        $style  = empty( $attr['style'] )  ? '' : $attr['style'];
        $width  = empty( $attr['width'] )  ? '' : ' width:'  . $attr['width'].'px;';
        $height = empty( $attr['height'] ) ? '' : ' height:' . $attr['height'].'px;';
        $valign = '';
		$html  = '';
        $html .= '<div data-avatar-type="acronym" class="' . $class . ' acronym-container" style="' . $style . $width . $height . '">';
		$html .= '<div class="molongui-vertical-aligned" style="' . $valign . '">';
		$html .= \molongui_get_acronym( $name );
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
    public function get_data()
    {
        $data = array();
        if ( empty( $this->author ) ) return $data;
        $networks = \authorship_get_social_networks( 'enabled' );
        if ( $this->type == 'guest' ) \do_action( 'authorship/author/guest/before_get_data', $this->id );
        $fields = \apply_filters( 'authorship/get_author_data/fields', array
        (
            'id',
            'type',
            'name',
            'first_name',
            'last_name',
            'slug',
            'mail',
            'phone',
            'web',
            'archive',
            'img',
            'job',
            'company',
            'company_link',
            'bio',
            'post_count',
            'user_roles',
            'user_login',
            'box',
            'show_meta_mail',
            'show_meta_phone',
            'show_social_mail',
            'show_social_web',
            'show_social_phone',
            'archived',
            'social',
        ));
        $data['id']                = $this->id;
        $data['type']              = $this->type;
        $data['name']              = $this->get_name();
        if ( in_array( 'first_name', $fields ) )        $data['first_name']        = $this->get_meta( 'first_name' );
        if ( in_array( 'last_name', $fields ) )         $data['last_name']         = $this->get_meta( 'last_name' );
        if ( in_array( 'slug', $fields ) )              $data['slug']              = $this->get_slug();
        if ( in_array( 'mail', $fields ) )              $data['mail']              = $this->get_mail();
        if ( in_array( 'phone', $fields ) )             $data['phone']             = $this->get_meta( 'phone' );
        if ( in_array( 'web', $fields ) )               $data['web']               = $this->get_meta( 'web' );
        if ( in_array( 'archive', $fields ) )           $data['archive']           = $this->get_url();
        if ( in_array( 'img', $fields ) )               $data['img']               = $this->get_avatar( 'thumbnail', 'box' );
        if ( in_array( 'job', $fields ) )               $data['job']               = $this->get_meta( 'job' );
        if ( in_array( 'company', $fields ) )           $data['company']           = $this->get_meta( 'company' );
        if ( in_array( 'company_link', $fields ) )      $data['company_link']      = $this->get_meta( 'company_link' );
        if ( in_array( 'bio', $fields ) )               $data['bio']               = $this->get_bio();
        if ( in_array( 'post_count', $fields ) )        $data['post_count']        = $this->get_post_count();
        if ( in_array( 'user_roles', $fields ) )        $data['user_roles']        = $this->get_user_roles();
        if ( in_array( 'user_login', $fields ) )        $data['user_login']        = $this->get_user_login();
        if ( in_array( 'box', $fields ) )               $data['box']               = $this->get_meta( 'box_display' );
        if ( in_array( 'show_meta_mail', $fields ) )    $data['show_meta_mail']    = $this->get_meta( 'show_meta_mail' );
        if ( in_array( 'show_meta_phone', $fields ) )   $data['show_meta_phone']   = $this->get_meta( 'show_meta_phone' );
        if ( in_array( 'show_social_mail', $fields ) )  $data['show_social_mail']  = $this->get_meta( 'show_icon_mail' );
        if ( in_array( 'show_social_web', $fields ) )   $data['show_social_web']   = $this->get_meta( 'show_icon_web' );
        if ( in_array( 'show_social_phone', $fields ) ) $data['show_social_phone'] = $this->get_meta( 'show_icon_phone' );
        if ( in_array( 'archived', $fields ) )          $data['archived']          = $this->get_meta( 'archived' );

        if ( in_array( 'social', $fields ) ) foreach ( $networks as $id => $network ) $data[$id] = $this->get_meta( $id );
        if ( $this->type == 'guest' ) \do_action( 'authorship/author/guest/after_get_data', $this->id );
        return \apply_filters( 'authorship/author/data', $data, $this->id, $this->type, $this->author );
    }
    function get_posts_count( $post_type = 'post' )
    {
        $post_status = authorship_post_status( $post_type );

        $count = \count( $this->get_posts( array( 'fields' => 'ids', 'post_type' => $post_type, 'post_status' => $post_status ) ) );
        return \apply_filters( 'authorship/author/posts_count', $count, $this->id, $this->type, $post_type );
    }
    public function get_posts( $args = null )
    {
        $original_args = $args;
        $defaults = array
        (
            'cat'                 => '',
            'fields'              => 'all',
            'ignore_sticky_posts' => true,
            'meta_query'          => '',
            'no_found_rows'       => true,
            'offset'              => '',
            'order'               => 'DESC',
            'orderby'             => 'date',
            'post__in'            => '',
            'post__not_in'        => '',
            'post_type'           => 'post',
            'post_status'         => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash' ), // all WP default post_status
            'posts_per_page'      => '-1',
            'author_id'           => $this->id,
            'author_type'         => $this->type,
            'site_id'             => \get_current_blog_id(),
            'language'            => \molongui_get_language(),
        );
        $parsed_args = \wp_parse_args( $original_args, $defaults );
        switch ( $parsed_args['post_type'] )
        {
            case 'all':
                $parsed_args['post_type'] = \molongui_get_post_types( 'all', 'names', false );
            break;

            case 'selected':
                $parsed_args['post_type'] = \molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all', false );
            break;

            case 'related':
                $options                       = \authorship_get_options();
                $parsed_args['post_type']      = \explode( ",", $options['author_box_related_post_types'] );

            break;
        }
        $parsed_args = \apply_filters( 'authorship/author/get_posts/args', $parsed_args, $original_args, $this->id, $this->type, $this->author );
        $posts = \apply_filters( 'authorship/author/pre_get_posts', null, $this->id, $this->type, $this->author, $parsed_args, $args );
        if ( null !== $posts ) return $posts;
        $hash  = \md5( \serialize( $parsed_args ) );
        $key   = 'posts' . '_' . $hash;
        $posts = \molongui_cache_get( $key );
        if ( false === $posts )
        {
            if ( 'guest' === $this->type )
            {
                if ( !empty( $parsed_args['meta_query'] ) )
                {
                    $mq = array
                    (
                        'relation'  => 'AND',
                        array
                        (
                            'key'   => $parsed_args['meta_query']['key'],
                            'value' => $parsed_args['meta_query']['value'],
                        ),
                        array
                        (
                            'key'   => '_molongui_author',
                            'value' => 'guest-'.$this->id,
                        ),
                    );
                }
                else
                {
                    $mq = array
                    (
                        array
                        (
                            'key'   => '_molongui_author',
                            'value' => 'guest-'.$this->id,
                        ),
                    );
                }
                $args = array
                (
                    'post_type'           => $parsed_args['post_type'],
                    'post__in'            => $parsed_args['post__in'],
                    'post__not_in'        => $parsed_args['post__not_in'],
                    'post_status'         => $parsed_args['post_status'],
                    'cat'                 => $parsed_args['cat'],
                    'meta_query'          => $mq,
                    'orderby'             => $parsed_args['orderby'],
                    'order'               => $parsed_args['order'],
                    'posts_per_page'      => $parsed_args['posts_per_page'],
                    'no_found_rows'       => $parsed_args['no_found_rows'],
                    'ignore_sticky_posts' => $parsed_args['ignore_sticky_posts'],
                    'fields'              => $parsed_args['fields'],
                    'author_id'           => $parsed_args['author_id'],
                    'author_type'         => $parsed_args['author_type'],
                    'site_id'             => $parsed_args['site_id'],
                    'language'            => $parsed_args['language'],
                );
                $data = \molongui_query( $args, 'posts' );
                $posts = empty( $data->posts ) ? array() : $data->posts;
            }
            else
            {
                if ( !empty( $parsed_args['meta_query'] ) )
                {
                    $mq = array
                    (
                        'relation'  => 'AND',
                        array
                        (
                            'key'    => $parsed_args['meta_query']['key'],
                            'value'  => $parsed_args['meta_query']['value'],
                        ),
                        array
                        (
                            'key'     => '_molongui_author',
                            'value'   => 'user-'.$this->id,
                            'compare' => '==',
                        ),
                    );
                }
                else
                {
                    $mq = array
                    (
                        array
                        (
                            'key'     => '_molongui_author',
                            'value'   => 'user-'.$this->id,
                            'compare' => '==',
                        ),
                    );
                }
                $args = array
                (
                    'post_type'           => $parsed_args['post_type'],
                    'post__in'            => $parsed_args['post__in'],
                    'post__not_in'        => $parsed_args['post__not_in'],
                    'post_status'         => $parsed_args['post_status'],
                    'cat'                 => $parsed_args['cat'],
                    'meta_query'          => $mq,
                    'orderby'             => $parsed_args['orderby'],
                    'order'               => $parsed_args['order'],
                    'posts_per_page'      => $parsed_args['posts_per_page'],
                    'no_found_rows'       => $parsed_args['no_found_rows'],
                    'ignore_sticky_posts' => $parsed_args['ignore_sticky_posts'],
                    'fields'              => $parsed_args['fields'],
                    'author_id'           => $parsed_args['author_id'],
                    'author_type'         => $parsed_args['author_type'],
                    'site_id'             => $parsed_args['site_id'],
                    'language'            => $parsed_args['language'],
                );
                $data = \molongui_query( $args, 'posts' );
                $data = empty( $data->posts ) ? array() : $data->posts;
                $data = \apply_filters( 'authorship/author/get_posts', $data, $this->id, $this->type, $this->author, $parsed_args );
                $post_ids = $parsed_args['fields'] == 'ids' ? \array_unique( $data ) : \array_unique( \wp_list_pluck( $data, 'ID' ) );
                if ( empty( $post_ids ) ) return array();
                $args = array
                (
                    'post_type'           => $parsed_args['post_type'],
                    'post__in'            => $post_ids,
                    'post_status'         => $parsed_args['post_status'],
                    'cat'                 => $parsed_args['cat'],
                    'orderby'             => $parsed_args['orderby'],
                    'order'               => $parsed_args['order'],
                    'posts_per_page'      => $parsed_args['posts_per_page'],
                    'no_found_rows'       => $parsed_args['no_found_rows'],
                    'ignore_sticky_posts' => $parsed_args['ignore_sticky_posts'],
                    'fields'              => $parsed_args['fields'],
                    'author_id'           => $parsed_args['author_id'],
                    'author_type'         => $parsed_args['author_type'],
                    'site_id'             => $parsed_args['site_id'],
                    'language'            => $parsed_args['language'],
                );
                $posts = \molongui_query( $args, 'posts' );
                $posts = empty( $posts->posts ) ? array() : $posts->posts;
            }
            \molongui_cache_set( $key, $posts );
            $db_key = MOLONGUI_AUTHORSHIP_PREFIX . '_cache_posts';
            $hashes = \get_option( $db_key, array() );
            $update = \update_option( $db_key, !\in_array( $hash, $hashes ) ? \array_merge( $hashes, array( $hash ) ) : $hashes, true );
        }
        $posts = \apply_filters( 'authorship/author/posts', $posts, $this->id, $this->type, $this->author, $parsed_args );
        return ( !empty( $posts ) ? $posts : array() );
    }

} // class