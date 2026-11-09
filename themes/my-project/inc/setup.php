<?php
/**
 * Theme supports and asset loading.
 * Rule: load a file only on the pages that need it.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'editor-styles' );
		add_editor_style( array( 'assets/css/theme.css', 'assets/css/editor.css' ) );
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'my-project', MY_PROJECT_URI . '/assets/css/theme.css', array(), MY_PROJECT_VERSION );

		wp_enqueue_script(
			'my-project',
			MY_PROJECT_URI . '/assets/js/theme.js',
			array(),
			MY_PROJECT_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		// Example of conditional loading: front-page-only script.
		if ( is_front_page() ) {
			wp_enqueue_script(
				'my-project-front',
				MY_PROJECT_URI . '/assets/js/front.js',
				array(),
				MY_PROJECT_VERSION,
				array( 'strategy' => 'defer', 'in_footer' => true )
			);
		}
	}
);
