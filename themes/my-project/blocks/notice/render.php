<?php
/**
 * Front-end output for my-project/notice.
 *
 * @var array $attributes
 */

$message = trim( (string) ( $attributes['message'] ?? '' ) );
if ( '' === $message ) {
	return;
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'my-project-notice' ) ); ?>>
	<?php echo esc_html( $message ); ?>
</div>
