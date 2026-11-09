<?php
/**
 * Demo content. Run with: ./scripts/wp eval-file /var/www/seed/seed.php
 * Safe to run more than once: pages are found by slug, never by ID.
 */

defined( 'WP_CLI' ) || exit;

function my_project_seed_page( string $slug, string $title, string $content = '' ): int {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return $page->ID;
	}
	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
		)
	);
}

$home = my_project_seed_page(
	'home',
	'Home',
	'<!-- wp:my-project/notice {"message":"Welcome to My Project."} /-->'
);
my_project_seed_page( 'contact', 'Contact' );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home );

WP_CLI::success( 'Seed done.' );
