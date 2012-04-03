<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'everlovin');

/** MySQL database username */
define('DB_USER', 'everlovin');

/** MySQL database password */
define('DB_PASSWORD', 'armour471003');

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
define('AUTH_KEY',         'mmK}haMe9@/|/FgY?;<5h,EYQP?h,S*+U6A9><dzfs/9*EY~V&f)`s!uFDi-j!16');
define('SECURE_AUTH_KEY',  'jWtDT%oB/!`PG1<!J[x)k##o-GX%(,x3X?M#%P_03kzxt|011}EoBYw8Ej|}.zrV');
define('LOGGED_IN_KEY',    '>4Es-{@O>S|hb}fA}%7%AiOsblLy<PK+DdRm&CqqTwP3+i4>7Qy1r55hTgc, Q^[');
define('NONCE_KEY',        '$j.+/zn7*4#xC^jXlww~_w 1Tk=I$`([KnZ~,%iRSmr4D|`a UQ-YUIpc?!Z/Af{');
define('AUTH_SALT',        'X*=<w+qqE9;z=4n+hdeLr@A^WfBm}>?@VBa*1t%AR.*;(uRE&L-bCB[;cfP3p;-8');
define('SECURE_AUTH_SALT', '7(&hlbEI]KlZmQ1TgLxJ=Y!+}#jW$}8$n_s+ORhFLgo%DiHnYQA[P~<e-nEs/>@&');
define('LOGGED_IN_SALT',   '57]aHF.7esNKoM*qX1wIe<`Czc#SU#|q+/Fy#;wVc(*/>;;e~; )I1Wdinw)Z2|<');
define('NONCE_SALT',       '<@-1|~6/8|Bmm-(-AQAO +~w:YY9uAYoM-SQ.vRS=#|EmDw!CU#|U-<@hI>Z5sur');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
