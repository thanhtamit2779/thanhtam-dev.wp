<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define('DB_NAME', '_thanhtam-dev.wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'LjPx&_3sOO|v)X{-3Lw+r=[%|]fIa`,27IRIh/GQ;+a;Nqw>byyzEz_x:oWs*V!/');
define('SECURE_AUTH_KEY',  'Vf)%~)ksX--X2|%Yewj-y_L[knxJ8T|L22O:.}mdcG8S !or,x5(uU7a5*zE364M');
define('LOGGED_IN_KEY',    'tpe{RRaC,rH=UXiKYU{vJ!v/+)$?Oeo^Yaw-[7t:J1YH`k+:&w_d-m^g*V`h$d:p');
define('NONCE_KEY',        'sd-uyM|PTD,+#-6:.(g>8J5kJtlp^a=PxF%DlE34cvvB-}G.uzdUXRr]*`l_#g)(');
define('AUTH_SALT',        'uK)5W$(AZ{A-O6#cRB1rAts`QB`(2&$}.*]ko}dA&+i 8KS:/</JF/}aD`yh[?x;');
define('SECURE_AUTH_SALT', 'IOH}.hO%tYja&JseW<`Tto$%2j%bi5p#A-|p}OxBuC,5]c8sa?=:+*wL]~.^>|zC');
define('LOGGED_IN_SALT',   'vW9^^I0s*0QGf*- f{3l=Y-5W(0S{l!Ntg*AfBdZbv-+U`bBT#2BaJ<y=#.FA/?}');
define('NONCE_SALT',       'Pr;MS  Kn-qJsnX/fdzTC&}.orVtH7Z~Zgd:ZC|<wM?|TGiGK/|Sey8#AYWkUI3O');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
