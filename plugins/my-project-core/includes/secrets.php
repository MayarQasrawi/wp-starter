<?php
/**
 * Read an API key or secret.
 * Order: wp-config constant (MY_PROJECT_<NAME>) → server environment variable.
 * Never commit secrets, never send them to the browser.
 *
 * Example in the server's wp-config.php:
 *   define( 'MY_PROJECT_MAPS_API_KEY', '...' );
 */

defined( 'ABSPATH' ) || exit;

function my_project_core_secret( string $name ): string {
	$constant = 'MY_PROJECT_' . strtoupper( $name );
	if ( defined( $constant ) ) {
		return (string) constant( $constant );
	}
	$env = getenv( $constant );
	return false === $env ? '' : (string) $env;
}
