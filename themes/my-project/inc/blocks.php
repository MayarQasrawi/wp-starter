<?php
/**
 * Registers every block in blocks/<name>/block.json. No build step:
 * editor JS is plain JS with an index.asset.php listing its WP dependencies.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		foreach ( glob( MY_PROJECT_DIR . '/blocks/*/block.json' ) ?: array() as $metadata ) {
			register_block_type( dirname( $metadata ) );
		}
	}
);
