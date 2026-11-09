<?php
/**
 * Plugin Name: My Project Core
 * Description: Site data and behaviour (post types, REST routes, settings, shortcodes). Survives a theme switch.
 * Version: 0.1.0
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Text Domain: my-project-core
 */

defined( 'ABSPATH' ) || exit;

define( 'MY_PROJECT_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'MY_PROJECT_CORE_VERSION', '0.1.0' );

// One file per feature in includes/.
foreach ( glob( MY_PROJECT_CORE_DIR . 'includes/*.php' ) ?: array() as $my_project_core_file ) {
	require_once $my_project_core_file;
}
