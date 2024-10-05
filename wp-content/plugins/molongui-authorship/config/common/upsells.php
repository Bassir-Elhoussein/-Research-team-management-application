<?php
defined( 'ABSPATH' ) or exit;

return array
(
    'molongui-authorship/molongui-authorship.php' => array
    (
        'id'       => 'molongui-authorship',
        'name'     => 'Molongui Authorship',
        'pro'      => false,
        'link'     => 'https://wordpress.org/plugins/molongui-authorship/',
        'img'      => 'https://ps.w.org/molongui-authorship/assets/banner-1544x500.png?rev=2121645',//MOLONGUI_AUTHORSHIP_URL.'/assets/img/common/molongui_authorship.png',
        'desc'     => __( "Molongui Authorship provides you all the missing features you might need to properly manage and credit all the contributors to your site. Powerful and easy.", 'molongui-authorship' ),
        'features' => array
        (
            sprintf( __( "%sAuthor Box%s – Automatically display author info, bio, social icons and related posts within a highly customizable and responsive author box on posts, pages or there where configured.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sCo-authors%s – Multiple authors contributed on a piece? Easily assign posts to multiple authors and properly credit to everyone involved.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sGuest Authors%s – Easily assign posts to guest authors or one-time contributors without creating a WordPress user account for them.", 'molongui-authorship' ), '<strong>', '</strong>' ),
        ),
        'demo'     => '',
    ),
    'molongui-authorship-pro/molongui-authorship-pro.php' => array
    (
        'id'       => 'molongui-authorship-pro',
        'name'     => 'Molongui Authorship Pro',
        'pro'      => true,
        'link'     => 'https://www.molongui.com/authorship/',
        'img'      => 'https://ps.w.org/molongui-authorship/assets/banner-1544x500.png?rev=2121645',//MOLONGUI_AUTHORSHIP_URL.'/assets/img/common/molongui_authorship.png',
        'desc'     => __( "Go Pro and enjoy additional premium features", 'molongui-authorship' ),
        'features' => array
        (
            sprintf( __( "%sCustom Post Type%s Support – Display the author box on articles, projects, products…", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sConditional Display%s – Control author box display based on post, post categories or post author.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            __( "Enhanced display settings.", 'molongui-authorship' ),
            __( "Third-party shortcodes support.", 'molongui-authorship' ),
            __( "Bulk Edit.", 'molongui-authorship' ),
            __( "Guest Author Duplication.", 'molongui-authorship' ),
            __( "User-to-Guest & Guest-to-User Conversion. Easily convert authors type. Just 1-click!", 'molongui-authorship' ),
            sprintf( __( "%sGuest Archives%s. - All posts from a guest author listed in a single page, just like WordPress does with registered users", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sShortcodes%s - Add as many author boxes as you needed, anywhere.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sAuthor List%s - Easily display a list of authors thanks to a highly configurable shortcode.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sAuthor Posts%s - Easily display a list of posts by author thanks to a highly configurable shortcode.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sPost Byline%s - Easily display the byline of a post anywhere you wish. Customizable shortcode.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sContributors Page%s - Automatically generated page listing all authors in your site.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            __( "Premium Layouts.", 'molongui-authorship' ),
            sprintf( __( "%sPremium Social Networks%s - 20+ additional social profiles.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            __( "SPAM Protection.", 'molongui-authorship' ),
            __( "REST API Support.", 'molongui-authorship' ),
            __( "SEO Option.", 'molongui-authorship' ),
        ),
        'demo'     => 'https://demos.molongui.com/test-drive-molongui-authorship-pro/',
    ),
    'molongui-bump-offer/molongui-bump-offer.php' => array
    (
        'id'       => 'molongui-bump-offer',
        'name'     => 'Molongui Deals, Sales Promotions and Upsells for WooCommerce',
        'pro'      => false,
        'link'     => 'https://wordpress.org/plugins/molongui-bump-offer/',
        'img'      => 'https://ps.w.org/molongui-bump-offer/assets/banner-1544x500.png?rev=2006241',//MOLONGUI_AUTHORSHIP_URL.'/assets/img/common/molongui_bump_offer.png',
        'desc'     => __( "Boost your sales by showing exclusive one-time offers on your Checkout page. Customers can take the offer with just 1-click without being redirected or leaving the order form. That easy!", 'molongui-authorship' ),
        'features' => array
        (
            __( "Display exclusive offers on the Checkout page", 'molongui-authorship' ),
            __( "Eye-catching default style to grab customer attention", 'molongui-authorship' ),
            __( "Fully Customizable – Colors, spacing, line styles, arrow icon, border width…", 'molongui-authorship' ),
            __( "Configurable product to offer", 'molongui-authorship' ),
            __( "Configurable discount price", 'molongui-authorship' ),
            __( "Editable texts", 'molongui-authorship' ),
            __( "Responsive design, mobile ready layout", 'molongui-authorship' ),
            __( "Live Preview", 'molongui-authorship' ),
            __( "Simple and Variable Product Support", 'molongui-authorship' ),
            __( "WooCommerce Compatible", 'molongui-authorship' ),
        ),
        'demo'     => '',
    ),
    'molongui-bump-offer-premium/molongui-bump-offer.php' => array
    (
        'id'       => 'molongui-one-click-upsell-pro',
        'name'     => 'Molongui Deals, Sales Promotions and Upsells Pro',
        'pro'      => true,
        'link'     => 'https://www.molongui.com/deals-sales-promotions-and-upsells-for-woocommerce/',
        'img'      => 'https://ps.w.org/molongui-bump-offer/assets/banner-1544x500.png?rev=2006241',//MOLONGUI_AUTHORSHIP_URL.'/assets/img/common/molongui_bump_offer.png',
        'desc'     => __( "Go Pro and enjoy additional Premium features", 'molongui-authorship' ),
        'features' => array
        (
            sprintf( __( "%sUnlimited deals%s – Add as many as needed, display more than one on the same page.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sImage Support%s – Easily add an image to the upsell box. And configure position, alignment, size and even a color filter.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sConfigurable Position%s – Change location where upsell offers are displayed: above/below customer details, order details, Cart…", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sCart Support%s – Upsell offer bumps can also be displayed at different positions on the Cart page with ease.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sMini-Cart Support%s – Upsells can even be displayed on the Mini-cart!", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sAnywhere%s – Use the provided shortcode to display an offer anywhere you wish", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sConditional Display%s – Display upsell offers no matter what or based on cart item count, value, products, categories or customer's country.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sCountry Restriction%s – Display/Hide your upsell offers to/from those countries of your choice.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sLimited-Time Offer%s – Easily plan and set your upsell discounts to be displayed at specific time range.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sSmart Display%s – Configure whether to ignore added offered products when evaluating whether to display an upsell bump offer.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "%sAutomatic Addition%s – Automatically add the upsell offer to your client’s Cart. No client action needed!", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "Ability to make the arrow on the bump blink to catch client attention.", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "Multi-step Checkout Support", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "Third-party Shortcodes Support. Display whatever within the Upsell box", 'molongui-authorship' ), '<strong>', '</strong>' ),
            sprintf( __( "Premium Support and assistance", 'molongui-authorship' ), '<strong>', '</strong>' ),
        ),
        'demo'     => 'https://demos.molongui.com/test-drive-molongui-deals-sales-promotions-and-upsells-pro/',
    ),
);