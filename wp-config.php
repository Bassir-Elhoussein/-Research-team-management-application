<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ait' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'h)U]oJf>D9C&yLkCG?.nxti(&<}h|,h^xr#)(LvI5BTvW+A.0_,!jN**O)&.O2dJ' );
define( 'SECURE_AUTH_KEY',  'L23421kH*|?1led;Wch#]wZwb+J0 Zhx4|yCJ/k?&}R$@w@EC,u)|6a.tAHr`xr$' );
define( 'LOGGED_IN_KEY',    '5=N;4UB{d4l?B:/B>D&7?LhEO:<74~%$T>gFXP7qhJkdSpmH-GVmZ8ZbQ=4 ||~r' );
define( 'NONCE_KEY',        'oy5l2Jsn&b5F(%vSc%+/mp4ps3O=bD-]c{!Xo-@O}i>M]s7~hp#la=M:gYT#/H;h' );
define( 'AUTH_SALT',        '?FLCG~eGD^b=6$Ql~(/v+C_N!>M3F4W@W/=jRj>)+ Dr?*HKqr~?|)lMV:-/cq*Q' );
define( 'SECURE_AUTH_SALT', 'P[pO)t}Arjs}>F9#2|^WqKQ(dn$|H<ktV%fH)ZBM6g%<IH[R:A2$@+2su>l(L>-O' );
define( 'LOGGED_IN_SALT',   'cjRd=TweB S&e`:j6:0!sXhCfc9LmD$^ 4m|5n0x@D9h!5V_,NI~*`G/]n*cUmLx' );
define( 'NONCE_SALT',       '1;@5Q|Wo::hn1O:1xA @[wII8/[!hd Jt(eT1o>Jkpsh}V!+0#L<bMDrr0`%[jt*' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
