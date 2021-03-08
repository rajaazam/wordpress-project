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
define( 'DB_NAME', 'school system' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '_P|k[n+jP)uPkXxna/ybUdYNxzz~0g+D}W`rN@W*Lm0+nO+;$?B.zBj]?07B|H[/' );
define( 'SECURE_AUTH_KEY',  'YvsD,{;j4i `I%kCasCo`gP(sC.c=*iycgm>3gfZa60!P30<RHWn[5d@RsigDOO%' );
define( 'LOGGED_IN_KEY',    ',h?w> ycvW:_TI8Fv<hNk@1m931bg<lDj:x+K98X*`n7I#Q_jt300:~-GWfEynXC' );
define( 'NONCE_KEY',        'jgjP+4f_!Iaeb1XwstLI=(T^W~nnxZ9XWKXX+S_Az$|?umu&Iml#/-BpB^+e.}+%' );
define( 'AUTH_SALT',        '^Jovq0=@ KFS_*y:a//Ybj8/V>1!,3xR Pw++ukgNKpf(>M7Y==)_|=8*sc3]<nM' );
define( 'SECURE_AUTH_SALT', '`QqFI{[pf1o6^:=-bUj&]u`igS.L:*sP?ojj2FTc3$!}gcnOdiu:-Sd#hENU;W Y' );
define( 'LOGGED_IN_SALT',   'Z_:^93#PL+<eIs+m`nOSl.LyYUW%=wKMN7{-&g&hDsCaCDzU&9F_QM$j;m 1@&%n' );
define( 'NONCE_SALT',       ']#W-Csof#B;57}W4D2OB@CQY:NT#{oMI9`V`Jx431pN-m7E|+!pjAcG+S3O?uuV(' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
