<?php
/**
 * Basic checks. Run all tests with: ./scripts/test.sh
 */

if ( PHP_SAPI !== 'cli' || ! defined( 'WP_CLI' ) ) {
	exit;
}

$failures = array();

if ( get_stylesheet() !== 'my-project' ) {
	$failures[] = 'Theme my-project is not active.';
}
if ( ! is_plugin_active( 'my-project-core/my-project-core.php' ) ) {
	$failures[] = 'Plugin my-project-core is not active.';
}
if ( ! WP_Block_Type_Registry::get_instance()->is_registered( 'my-project/notice' ) ) {
	$failures[] = 'Block my-project/notice is not registered.';
}
if ( ! get_page_by_path( 'home' ) ) {
	$failures[] = 'Home page is missing (run the seed).';
}

if ( $failures ) {
	WP_CLI::error( implode( "\n", $failures ) );
}
WP_CLI::success( 'Smoke test passed.' );
