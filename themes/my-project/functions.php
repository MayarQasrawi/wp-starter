<?php
/**
 * Theme bootstrap. Feature code lives in inc/, one file per concern.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme version + newest asset mtime, so browsers and host caches
 * pick up every change without manual version bumps.
 */
function my_project_asset_version(): string {
	$latest = 0;
	$files  = array_merge(
		glob( get_template_directory() . '/assets/css/*.css' ) ?: array(),
		glob( get_template_directory() . '/assets/js/*.js' ) ?: array()
	);
	foreach ( $files as $file ) {
		$latest = max( $latest, (int) filemtime( $file ) );
	}
	return wp_get_theme()->get( 'Version' ) . '.' . $latest;
}

define( 'MY_PROJECT_DIR', get_template_directory() );
define( 'MY_PROJECT_URI', get_template_directory_uri() );
define( 'MY_PROJECT_VERSION', my_project_asset_version() );

require MY_PROJECT_DIR . '/inc/setup.php';
require MY_PROJECT_DIR . '/inc/blocks.php';
