<?php
if ( ! defined ( 'ABSPATH' ) ) {
	die ( 'Not allowed' );
}
?>
<div id="aiomatic-cropper-wrapper">
	<div class="media-modal wp-core-ui">
		<button type="button" class="media-modal-close" onclick="aiomaticCancelCropImage();">
			<span class="media-modal-icon">
				<span class="screen-reader-text"><?php esc_html_e( 'Close panel', 'aiomatic-automatic-ai-content-writer' ); ?></span>
			</span>
		</button>
		<div class="media-modal-content">
    <div class="media-frame wp-core-ui">	
        <div class="media-frame-title"><h1><?php esc_html_e( 'Aiomatic - AI Generated SEO Fields', 'aiomatic-automatic-ai-content-writer' );?></h1></div>
        <div class="media-frame-router">
            <button type="button" class="button-link arrows arrow-l">
                <span class="dashicons dashicons-arrow-left-alt2"></span>
            </button>
            <button type="button" class="button-link arrows arrow-r">
                <span class="dashicons dashicons-arrow-right-alt2"></span>
            </button>
        </div>
        <div class="media-frame-content">
            <div class="attachments-browser">
                
            <div class="attachments">
                <h3><?php esc_html_e( 'AI Content Creator Settings:', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
                <p>
                <label for="aiomatic_target_selector"><strong><?php esc_html_e( 'AI Writer Target', 'aiomatic-automatic-ai-content-writer' ); ?></strong></label><br />
                <select id="aiomatic_target_selector" name="aiomatic_target_selector" class="aiomatic-full" onchange="target_updated_ai();">
                <option value="caption"><?php echo esc_html__("Caption Text", 'aiomatic-automatic-ai-content-writer');?></option>
                <option value="alt"><?php echo esc_html__("Alt Text", 'aiomatic-automatic-ai-content-writer');?></option>
                <option value="description"><?php echo esc_html__("Description Text", 'aiomatic-automatic-ai-content-writer');?></option>        
                <option value="title"><?php echo esc_html__("Title Text", 'aiomatic-automatic-ai-content-writer');?></option>                                         
            </select>
                </p>
                <p>
                <label for="aiomatic_media_prompt"><strong><?php esc_html_e( 'AI Prompt', 'aiomatic-automatic-ai-content-writer' ); ?></strong>
                <small class="small"><?php echo esc_html__("Hint: you can use the following shortcodes in this settings field: %%image_title%%, %%image_caption%%, %%image_alt%%, %%image_description%%, %%parent_title%%, %%parent_excerpt%%, %%parent_content%%, %%blog_title%%, %%random_sentence%%, %%random_sentence2%% + nested shortcodes also supported.", 'aiomatic-automatic-ai-content-writer');?>
                </small>
            </label><br />
                <textarea name="aiomatic_media_prompt" class="aiomatic-full" id="aiomatic_media_prompt">Write a SEO friendly caption text for an image with the title: %%image_title%%</textarea>
                </p>
<hr/>
<p>
    <button type="button" id="aiomatic_get_templates" class="button"><?php esc_html_e('Load Templates List', 'aiomatic-automatic-ai-content-writer'); ?></button>
    <button type="button" id="aiomatic_save_template" class="button"><?php esc_html_e('Save New Template', 'aiomatic-automatic-ai-content-writer'); ?></button>
    <button type="button" id="aiomatic_load_template" class="button"><?php esc_html_e('Load Selected Template', 'aiomatic-automatic-ai-content-writer'); ?></button>
    <button type="button" id="aiomatic_delete_template" class="button"><?php esc_html_e('Delete Selected Template', 'aiomatic-automatic-ai-content-writer'); ?></button>
</p>
<p>
    <label for="aiomatic_template_selector"><strong><?php esc_html_e('Select Template', 'aiomatic-automatic-ai-content-writer'); ?></strong></label><br />
    <select id="aiomatic_template_selector" name="aiomatic_template_selector" class="aiomatic-full">
        <option value=""><?php echo esc_html__("Choose a template", 'aiomatic-automatic-ai-content-writer'); ?></option>
    </select>
</p>
<hr/>
                <p>
            <label for="seo_assistant_id"><strong><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></strong></label><br />
<select id="seo_assistant_id" name="seo_assistant_id" class="aiomatic-full" onchange="aiseoselect();">
    <?php
$all_assistants = aiomatic_get_all_assistants(true);
if($all_assistants === false)
{
    echo '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
    if(count($all_assistants) == 0)
    {
        echo '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
    }
    else
    {
        echo '<option value="">' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'">' . esc_html($myassistant->post_title);
            echo '</option>';
        }
    }
}
?>
    </select>  
</p>
                <p>
                <label for="aiomatic_model_selector"><strong><?php esc_html_e( 'AI Model', 'aiomatic-automatic-ai-content-writer' ); ?></strong></label><br />
                <select id="aiomatic_model_selector" name="aiomatic_model_selector" class="aiomatic-full">
<?php
$all_models = aiomatic_get_all_models(true);
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>                                        
            </select>
                </p>
                <p>
<button type="button" id="aiomatic_generate_text_media" class="button" onclick="aiomaticGenerateMediaText();"><?php esc_html_e( 'Generate Text', 'aiomatic-automatic-ai-content-writer' );?></button>
                </p>
                    <?php 
if (!isset($GLOBALS["aiomatic_image_id"])) {
    esc_html_e( 'The media attachment ID was not passed correctly, please try again.', 'aiomatic-automatic-ai-content-writer' );
}
else
{
    if(!is_numeric($GLOBALS["aiomatic_image_id"]))
    {
        esc_html_e( 'The media attachment ID was not parsed correctly, please try again.', 'aiomatic-automatic-ai-content-writer' );
    }
    else
    {
        $post = get_post($GLOBALS["aiomatic_image_id"]);
        if($post) 
        {
            $alt_text = get_post_meta( $GLOBALS["aiomatic_image_id"], '_wp_attachment_image_alt', true );
            ?>
            <hr/>
            <div class="wp_attachment_details edit-form-section">
            <h3><?php esc_html_e( 'Attachment SEO Attributes:', 'aiomatic-automatic-ai-content-writer' ); ?></h3>
            <p>
                <label for="aiomatic_attachment_title"><strong><?php esc_html_e( 'Title', 'aiomatic-automatic-ai-content-writer' ); ?></strong></label><br />
                <textarea name="title" class="aiomatic-full" id="aiomatic_attachment_title"><?php echo $post->post_title; ?></textarea>
            </p>
            <p class="attachment-alt-text">
                <label for="aiomatic_attachment_alt"><strong><?php esc_html_e( 'Alternative Text', 'aiomatic-automatic-ai-content-writer' ); ?></strong></label><br />
                <textarea name="_wp_attachment_image_alt" class="aiomatic-full" id="aiomatic_attachment_alt" aria-describedby="alt-text-description"><?php echo esc_attr( $alt_text ); ?></textarea>
                <input type="hidden" id="aiomatic_media_id" value="<?php echo $GLOBALS["aiomatic_image_id"];?>">
            </p>
            <p class="attachment-alt-text-description" id="alt-text-description">
            <?php

            printf(
                '<a href="%1$s" %2$s>' . esc_html__( 'Learn how to describe the purpose of the image', 'aiomatic-automatic-ai-content-writer' ) . '%3$s</a>. ' . esc_html__( 'Leave empty if the image is purely decorative.', 'aiomatic-automatic-ai-content-writer' ),
                'https://www.w3.org/WAI/tutorials/images/decision-tree',
                'target="_blank" rel="noopener"',
                sprintf(
                    '<span class="screen-reader-text"> %s</span>',
                    esc_html__( '(opens in a new tab)', 'aiomatic-automatic-ai-content-writer' )
                )
            );

            ?>
            </p>
            <p>
                <label for="aiomatic_attachment_caption"><strong><?php esc_html_e( 'Caption', 'aiomatic-automatic-ai-content-writer' ); ?></strong></label><br />
                <textarea name="excerpt" class="aiomatic-full" id="aiomatic_attachment_caption"><?php echo $post->post_excerpt; ?></textarea>
            </p>
        <label for="attachment_content" class="attachment-content-description"><strong><?php _e( 'Description' ); ?></strong>
        <?php
        if ( preg_match( '#^(audio|video)/#', $post->post_mime_type ) ) {
            echo ': ' . esc_html__( 'Displayed on attachment pages.', 'aiomatic-automatic-ai-content-writer' );
        }

        ?>
        </label><br />
        <textarea name="content" class="aiomatic-full" id="attachment_content"><?php echo $post->post_content; ?></textarea>
        </div>
        <?php
        }
        else
        {
            esc_html_e( 'The media attachment ID was not found in the database: ', 'aiomatic-automatic-ai-content-writer' );
            echo esc_html($GLOBALS["aiomatic_image_id"]);
        }
    }
}
?>
<button type="button" class="button button-primary" id="aiomatic_save_media" onclick="aiomatic_save_media_data();"><?php esc_html_e( 'Save', 'aiomatic-automatic-ai-content-writer' );?></button>
    <div><br/></div>
                </div>
                <div class="media-sidebar">
                    <div class="attachment-details">
                        <div class="aiomatic-crop-now-wrapper">
<?php esc_html_e( 'Here you will be able to automatically generate, using AI, the SEO meta fields for this image.', 'aiomatic-automatic-ai-content-writer' ); ?>
                            <span class="spinner"></span>
                        </div>
<?php
	$thumb     = image_get_intermediate_size( $GLOBALS["aiomatic_image_id"], 'thumbnail' );
    if(isset($thumb['url']))
    {
        $thumb_img = wp_constrain_dimensions( $thumb['width'], $thumb['height'], 160, 120 );
?>
                        <p><b>
<?php esc_html_e( 'Preview image:', 'aiomatic-automatic-ai-content-writer' );?>
                        </p></b>
                        <div class="imgedit-group imgedit-applyto">
                            <figure class="imgedit-thumbnail-preview">
                                <img src="<?php 
    echo $thumb['url']; ?>" width="<?php echo $thumb_img[0]; ?>" height="<?php echo $thumb_img[1]; ?>" class="imgedit-size-preview" alt="" draggable="false" />
                                <figcaption class="imgedit-thumbnail-preview-caption"><?php _e( 'Current thumbnail' ); ?></figcaption>
                            </figure>
                        </div>
<?php
    }
?>
                    </div>
                </div>
            </div>
        </div>	
    </div>
    </div>
	</div>
	<div id="aiomatic-cropper-bckgr" class="media-modal-backdrop"></div>
</div>
<?php
exit();
?>