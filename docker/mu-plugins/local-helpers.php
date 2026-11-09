<?php
/**
 * Local-only helpers. Mounted by docker-compose.yml, never deployed.
 */

if ( wp_get_environment_type() !== 'local' ) {
	return;
}

// Open the site from any host (localhost, LAN IP, phone on the same Wi-Fi).
if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
	$my_project_local_url = 'http://' . preg_replace( '/[^a-zA-Z0-9.:\-]/', '', $_SERVER['HTTP_HOST'] );
	add_filter( 'option_home', fn() => $my_project_local_url );
	add_filter( 'option_siteurl', fn() => $my_project_local_url );
}

// Never send real email from a local copy. Log it instead.
add_filter(
	'pre_wp_mail',
	function ( $null, $atts ) {
		error_log( '[local mail blocked] to: ' . print_r( $atts['to'], true ) . ' subject: ' . $atts['subject'] );
		return true;
	},
	10,
	2
);
