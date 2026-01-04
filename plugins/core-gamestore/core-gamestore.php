<?php

	/**
 * Plugin Name:       Core GameStore
 * Description:       Core code for GameStore
 * Version:           1.0
 * Author:            WPCat
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       core-gamestore
 * Domain Path:       /languages
 */

define('GAMESTORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GAMESTORE_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-core.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/games-meta.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/social-share.php');
require_once(GAMESTORE_PLUGIN_PATH . '/inc/news-term-meta.php');