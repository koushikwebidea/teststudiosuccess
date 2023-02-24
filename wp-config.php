<?php
define( 'WP_CACHE', true );
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'studiosuccess' );

/** Database username */
define( 'DB_USER', 'user-ss' );

/** Database password */
define( 'DB_PASSWORD', 'TaLu4jEgVKAQQW1riiKs' );

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
define( 'AUTH_KEY',         'lox9w3fkhk6ou3c5iqmhbyjumbliutas9fxirwa6qnoigccf5ip7iwrs4ad7kzbp' );
define( 'SECURE_AUTH_KEY',  'uiszszw1wawss2mosfubnj4raxeus89hrbotlnaqynw3qwt1fzmxl7xsoyzyjcws' );
define( 'LOGGED_IN_KEY',    'nciife8j284bvo7q9dzjoivzuf5hhs0x0nftnokkytmjoavb4rbagis2xitkgem5' );
define( 'NONCE_KEY',        'ddnucrnjglh8kqav38tevpnsgzsowzbtc1xkht7ure5hmagbqfjyqjpzj6ilcpvc' );
define( 'AUTH_SALT',        'g8zcgyqhpeozwlca5hzjvize48smvbb2hrrcxyj7tda1ufpqh14zskkemtg0ygog' );
define( 'SECURE_AUTH_SALT', 'l4dfzldytfo62lcpzyjxb4y5foh4cpb63pvqweiyxxjh0yq8irqa0erpkqimczyl' );
define( 'LOGGED_IN_SALT',   'aoepb1yx1putey4zccggfuk6bjvpvpxfdp9lyzczhstevros0qiuof5methsdyp6' );
define( 'NONCE_SALT',       'aptqmeiscsqfvp0wzbfnywwcxxqh7b4y6pmts9aczn3t3raqcqrkmnwke329yane' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpto_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
