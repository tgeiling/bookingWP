<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', 'dbs12914702' );

/** Database username */
define( 'DB_USER', 'dbu339738' );

/** Database password */
define( 'DB_PASSWORD', 'Stefan.2506' );

/** Database hostname */
define( 'DB_HOST', 'rdbms.strato.de' );

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
define( 'AUTH_KEY',         'N%*Ct:AbM^u^;3~WD[}9yffE|M1m>Y||iN7o{@Xgo>EJ%)$_rHpzFzK+eH9PuY;m' );
define( 'SECURE_AUTH_KEY',  'am],vDF1*8kck<~taX(;:Y7$R1@c6v~9Eq[FT:|Kk(!9]I9 =ik&ONKnTm1Gz9IO' );
define( 'LOGGED_IN_KEY',    'n?gj;WnFbP|*eF;k+S3|-_>+S:uY(^G41uGw%jy.EL~l_&ZNmnf+BCg9hZ|Gtl]S' );
define( 'NONCE_KEY',        '&vZFvU05HqjpnZxKWNfh,cCs^s}0Nn$H0u{wtAPChjj2/.R6;S`HE^q (ne<6#2x' );
define( 'AUTH_SALT',        '?)PWU[2]}f5b(S9~:p.SdnQ6+2JsCMrN:2gI>gm>pVv.-e:}Ts9(D)j[;o[:RU}j' );
define( 'SECURE_AUTH_SALT', '<,GnlK&&Q784a{ow]3}Lbh0C5FpOJ wg!j2-#1H?Q#c9*`{SlFVX6nSBI#TP^J;&' );
define( 'LOGGED_IN_SALT',   'QM|Mp+geFQi{5q`b31BKh(w.C{([|8/Y,|+ Zgy^-;>f5[nFDi-_8Qp/45DkgkSJ' );
define( 'NONCE_SALT',       'vo^d!x_8X8&Q_MnXU!Wym<%_bN1(-0;6 7p=vW8d|N-kcs#{8SHir/.-N1Wc}Zdw' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'demo1_';

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
