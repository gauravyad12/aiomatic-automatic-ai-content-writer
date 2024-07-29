<?php
if ( ! defined ( 'ABSPATH' ) ) {
	die ( 'Not allowed' );
}
function aiomatic_get_edit_image_url( $id ) {
	return admin_url( 'admin-ajax.php' ) . '?action=aiomatic_edit_thumbnails_page&post=' . $id;
}

function aiomatic_get_edit_image_anchor( $id, $style = '', $classes = '' ) {
	add_thickbox();
	$edit_crops_url = aiomatic_get_edit_image_url( $id );
	return '<a class="autox-thickbox aiomatic ' . $classes . '" style="' . $style . '" href="' . $edit_crops_url . '" title="' . esc_html__( 'AI Generated SEO Fields', 'aiomatic-automatic-ai-content-writer' ) . '">' . esc_html__( 'AI Generated SEO Fields', 'aiomatic-automatic-ai-content-writer' ) . '</a>';
}

function aiomatic_get_edit_image_anchor_ajax() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
	$classes = empty( $_POST['classes'] ) ? 'edit-attachment' : esc_html( $_POST['classes'] );
	echo aiomatic_get_edit_image_anchor( esc_html( $_POST['post'] ), 'margin-right:10px;', $classes );
	die();
}
add_action( 'wp_ajax_aiomatic_get_edit_image_anchor', 'aiomatic_get_edit_image_anchor_ajax' );

function aiomatic_edit_thumbnails_page() {
	global $aiomatic_image_id;
	$aiomatic_image_id = esc_html( $_GET ['post'] );

	if (current_user_can ( 'access_aiomatic_menu', $aiomatic_image_id ) ) {
		include (dirname(__FILE__) . '/seo-panel.php');
	} else {
		die ();
	}
}
add_action( 'wp_ajax_aiomatic_edit_thumbnails_page', 'aiomatic_edit_thumbnails_page' );

function aiomatic_admin_post_thumbnail_html( $content, $id, $thumb_id = null ) {
	global $wp_version;
	if ( version_compare( $wp_version, '4.6.0', '>=' ) ) {
		if ( ! empty( $thumb_id ) ) {
			$image_id = $thumb_id;
		} else {
			return $content;
		}
	} else {
		if ( has_post_thumbnail( $id ) ) {
			$image_id = get_post_thumbnail_id( $id );
		} else {
			return $content;
		}
	}
	if ( ! current_user_can( 'access_aiomatic_menu', $image_id ) ) {
		return $content;
	}
	$edit_crops_content = '<p>' . aiomatic_get_edit_image_anchor( $image_id ) . '</p>';
	return $content . $edit_crops_content;
}

add_filter( 'admin_post_thumbnail_html', 'aiomatic_admin_post_thumbnail_html', 10, 3 );

function aiomatic_print_media_templates() {
	?>
	<script>
	jQuery(document).ready(function() 
	{
		if (window.aiomaticExtendMediaLightboxTemplate) 
		{
			aiomaticExtendMediaLightboxTemplate(
				'<?php echo aiomatic_get_edit_image_anchor( '{{ data.id }}', 'display:block;text-decoration:none;' ); ?>',
				'<?php echo aiomatic_get_edit_image_anchor( '{{ data.id }}', 'text-decoration:none;' ); ?>',
				'<?php echo aiomatic_get_edit_image_anchor( '{{ data.id }}', '', 'button' ); ?>',
				'<?php echo aiomatic_get_edit_image_anchor( '{{ data.attachment.id }}', '', 'button' ); ?>'
			);
		}
	});
	</script>
	<?php
}

add_action( 'print_media_templates', 'aiomatic_print_media_templates' );

function aiomatic_media_row_actions( $actions, $post, $detached ) {
	if ( wp_attachment_is_image( $post->ID ) && current_user_can( 'access_aiomatic_menu', $post->ID ) ) {
		$actions['aiomatic_crop'] = aiomatic_get_edit_image_anchor( $post->ID );
	}
	return $actions;
}
add_filter( 'media_row_actions', 'aiomatic_media_row_actions', 10, 3);
?>