<?php
/**
 * Example post type. Data lives in the plugin, so it stays visible
 * if the theme changes. Rename or delete for your project.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'my_project_item',
			array(
				'label'        => __( 'Items', 'my-project-core' ),
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'items' ),
				'menu_icon'    => 'dashicons-portfolio',
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			)
		);
	}
);
