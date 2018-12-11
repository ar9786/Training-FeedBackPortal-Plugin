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
define('DB_NAME', 'HrFeedBackPortal');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Hs}v+$sr*^N>[a]F03+h7jZ96aBlBZY<K2dJpm;k?Mlp1jrc|a,g#FS<CyO).B,J');
define('SECURE_AUTH_KEY',  'jlq$n6Z->mm#4d%R|TlTK%]e}t~d_NiR7cpo%r:bY4BTG4`Ak{k]:A<@2c]s_.MA');
define('LOGGED_IN_KEY',    'Pu$5iU1:`i4XhR]9,ecH}q)2`$O$BHFuCT|;)rG4%TD%yUZ7VL/M`m9qf3!_{dzZ');
define('NONCE_KEY',        'F&XkPoE 4P=%~3r.RB,+$rU{:B?g#.DR,+d`nT3wg?Xvpk&b6ps3XH|.5|(1xK82');
define('AUTH_SALT',        '8BZ 318QJ[9$TWs2-K@!Q5U2CXc/P,1HflBCc[kR$YfP(Rxm!TnmaNjIC#v?b47~');
define('SECURE_AUTH_SALT', 'YWhARsw*c^vPU2:Y~X[IqVos&{yUg*m*n^dEECk]<dj1DHBX:~U9u*aq!++jVWl/');
define('LOGGED_IN_SALT',   'p[9z/}3Q_=rG[w%A&aEQ*GKxN <Tcid:M!aD 3~uRr0@`^i<?v|o&tvY |X%W_Yn');
define('NONCE_SALT',       'vIX/b;V[);9{>@&ys5*Mw5zhY[H5hN|(jy6WEJlZpz:LUkGH%1>j-}/Xg#!}YqHo');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
