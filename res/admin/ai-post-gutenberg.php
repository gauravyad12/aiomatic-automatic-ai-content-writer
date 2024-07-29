<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
if(isset($aiomatic_Main_Settings['ai_writer_title_prompt']) && $aiomatic_Main_Settings['ai_writer_title_prompt'] != '')
{
    $aiomatic_title_prompt = $aiomatic_Main_Settings['ai_writer_title_prompt'];
}
else
{
    $aiomatic_title_prompt = sprintf( wp_kses( __( 'Create a captivating and concise SEO title in English for your WordPress %s: "%s". Boost its search engine visibility with relevant keywords for maximum impact.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), $post->post_type, '%%post_title_idea%%' );
}
if(isset($aiomatic_Main_Settings['ai_writer_seo_prompt']) && $aiomatic_Main_Settings['ai_writer_seo_prompt'] != '')
{
    $aiomatic_seo_prompt = $aiomatic_Main_Settings['ai_writer_seo_prompt'];
}
else
{
    $aiomatic_seo_prompt = sprintf( wp_kses( __( 'Craft an enticing and succinct meta description in English for your WordPress %s: "%s". Emphasize the notable features and advantages in just 155 characters, incorporating relevant keywords to optimize its SEO performance.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), $post->post_type, '%%post_title_idea%%' );
}
if(isset($aiomatic_Main_Settings['ai_writer_content_prompt']) && $aiomatic_Main_Settings['ai_writer_content_prompt'] != '')
{
    $aiomatic_content_prompt = $aiomatic_Main_Settings['ai_writer_content_prompt'];
}
else
{
    $aiomatic_content_prompt = sprintf( wp_kses( __( 'Create a captivating and comprehensive English description for your WordPress %s: "%s". Dive into specific details, highlighting its unique features of this subject, if possible, benefits, and the value it brings. Craft a compelling narrative around the %s that captivates the audience. Use HTML for formatting, include unnumbered lists and bold. Writing Style: Creative. Tone: Neutral.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), $post->post_type, '%%post_title_idea%%', $post->post_type );
}
if(isset($aiomatic_Main_Settings['ai_writer_excerpt_prompt']) && $aiomatic_Main_Settings['ai_writer_excerpt_prompt'] != '')
{
    $aiomatic_short_prompt = $aiomatic_Main_Settings['ai_writer_excerpt_prompt'];
}
else
{
    $aiomatic_short_prompt = sprintf( wp_kses( __( 'Write a captivating and succinct English summary for the WordPress %s: "%s", accentuating its pivotal features, advantages, and distinctive qualities.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), $post->post_type, '%%post_title_idea%%' );
}
if(isset($aiomatic_Main_Settings['ai_writer_tags_prompt']) && $aiomatic_Main_Settings['ai_writer_tags_prompt'] != '')
{
    $aiomatic_tag_prompt = $aiomatic_Main_Settings['ai_writer_tags_prompt'];
}
else
{
    $aiomatic_tag_prompt = sprintf( wp_kses( __( 'Suggest a series of pertinent keywords in English for your WordPress %s: "%s". These keywords should be closely connected to the %s, optimizing its visibility. Please present the keywords in a comma-separated format without using symbols like -, #, etc.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), $post->post_type, '%%post_title_idea%%', $post->post_type );
}
?>
<div id="aiomatic-content-generator">
    <p class="aiomatic-form-row">
        <label><strong><?php echo ucwords($post->post_type) . ' ' . esc_html__('Title Idea / Keywords','aiomatic-automatic-ai-content-writer');?></strong></label>
        <input class="coderevolution_gutenberg_input" name="aiomatic_original_title" id="aiomatic_original_title" type="text" value="<?php echo esc_html($post->post_title);?>">
    </p>
    <table class="widefat">
        <tr><td colspan="2">
                <h4><?php echo esc_html__('What To Generate?','aiomatic-automatic-ai-content-writer');?></h4>
</td></tr><tr><td>
        <label for="aiomatic_generate_title"><?php echo esc_html__('Generate A SEO Title','aiomatic-automatic-ai-content-writer');?></label>
</td><td>
        <input type="checkbox" value="1" id="aiomatic_generate_title">
</td></tr><tr><td>
        <label for="aiomatic_generate_title"><?php echo esc_html__('Generate A SEO Meta Description','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <input type="checkbox" value="1" id="aiomatic_generate_meta">
</td></tr><tr><td>
        <label for="aiomatic_generate_description"><?php echo esc_html__('Generate Content','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <input type="checkbox" value="1" id="aiomatic_generate_description">
</td></tr><tr><td>
        <label for="aiomatic_generate_short"><?php echo esc_html__('Generate Short Description (Excerpt)','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <input type="checkbox" value="1" id="aiomatic_generate_short">
</td></tr><tr><td>
        <label for="aiomatic_generate_tags"><?php echo esc_html__('Generate Tags','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <input type="checkbox" value="1" id="aiomatic_generate_tags">
</td></tr><tr><td>
        <button type="button" id="aiomatic_show_more" class="button"><?php echo esc_html__('Toggle Advanced Options','aiomatic-automatic-ai-content-writer');?></button>
</td></tr>
<tr class="aiomatic_toggle_me aiomatic_none"><td colspan="2"><hr/></td></tr>
<tr class="aiomatic_toggle_me aiomatic_none"><td colspan="2">
                <h4><?php echo esc_html__('Advanced Settings','aiomatic-automatic-ai-content-writer');?></h4>
</td></tr><tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_ai_assistant_id"><?php echo esc_html__('AI Assistant ID','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("Set the assistant ID to be used for the AI content creation.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
<?php 
$all_assistants = aiomatic_get_all_assistants(true);
?>
<select class="coderevolution_gutenberg_input" autocomplete="off" id="aiomatic_ai_assistant_id" name="aiomatic_ai_assistant_id" onchange="assistantSelected('aiomatic_ai_assistant_id', 'disableModel');" class="cr_width_full">
<?php
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
        echo '<option value=""';
        if(isset($aiomatic_Main_Settings['writer_assistant_id']) && $aiomatic_Main_Settings['writer_assistant_id'] == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if(isset($aiomatic_Main_Settings['writer_assistant_id']) && $aiomatic_Main_Settings['writer_assistant_id'] == $myassistant->ID)
            {
                echo ' selected';
            }
            echo '>' . esc_html($myassistant->post_title);
            echo '</option>';
        }
    }
}
?>
</select>   
</td></tr>
<tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_ai_model"><?php echo esc_html__('AI Model','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("Set the model to be used for the AI content creation.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
<?php 
$all_models = aiomatic_get_all_models(true);
?>
<select class="disableModel cr_width_full coderevolution_gutenberg_input" autocomplete="off" id="aiomatic_ai_model" name="aiomatic_ai_model" <?php if(isset($aiomatic_Main_Settings['writer_assistant_id']) && $aiomatic_Main_Settings['writer_assistant_id'] != ''){echo ' disabled';}?>>
<?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"'; 
   if(isset($aiomatic_Main_Settings['ai_writer_model']) && $aiomatic_Main_Settings['ai_writer_model'] != '')
   {
        if($modelx == $aiomatic_Main_Settings['ai_writer_model'])
        {
            echo ' selected';
        }
   }
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
</select>   
</td></tr>
<tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_title_prompt"><?php echo ucwords($post->post_type) . ' ' .esc_html__('Title Prompt','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
        <textarea class="coderevolution_gutenberg_input" name="aiomatic_title_prompt" id="aiomatic_title_prompt"><?php echo $aiomatic_title_prompt;?></textarea>
</td></tr><tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_seo_prompt"><?php echo ucwords($post->post_type) . ' ' .esc_html__('SEO Meta Description Prompt','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
        <textarea class="coderevolution_gutenberg_input" name="aiomatic_seo_prompt" id="aiomatic_seo_prompt"><?php echo $aiomatic_seo_prompt;?></textarea>
</td></tr><tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_content_prompt"><?php echo ucwords($post->post_type) . ' ' .esc_html__('Content Prompt','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
        <textarea class="coderevolution_gutenberg_input" name="aiomatic_content_prompt" id="aiomatic_content_prompt"><?php echo $aiomatic_content_prompt;?></textarea>
</td></tr><tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_short_prompt"><?php echo ucwords($post->post_type) . ' ' .esc_html__('Short Description Prompt','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
        <textarea class="coderevolution_gutenberg_input" name="aiomatic_short_prompt" id="aiomatic_short_prompt"><?php echo $aiomatic_short_prompt;?></textarea>
</td></tr><tr class="aiomatic_toggle_me aiomatic_none"><td>
        <label for="aiomatic_tag_prompt"><?php echo ucwords($post->post_type) . ' ' .esc_html__('Tags Prompt','aiomatic-automatic-ai-content-writer');?></label><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
    <?php
        echo esc_html__("You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div>
        </td><td>
        <textarea class="coderevolution_gutenberg_input" name="aiomatic_tag_prompt" id="aiomatic_tag_prompt"><?php echo $aiomatic_tag_prompt;?></textarea>
</td></tr>
    <tr class="aiomatic_toggle_me aiomatic_none"><td colspan="2"><?php echo sprintf( wp_kses( __( 'You can edit default values for the above fields, <a href="%s">here</a>', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), admin_url('admin.php?page=aiomatic_admin_settings#tab-27') );?>
</td></tr>
<tr><td colspan="2"><hr/></td></tr>
<tr><td colspan="2">
                <h4><?php echo esc_html__('AI Generated Results','aiomatic-automatic-ai-content-writer');?></h4>
</td></tr>
<tr><td>
        <label for="aiomatic_ai_title"><?php echo ucwords($post->post_type) . ' ' .esc_html__('AI Generated Title','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <textarea rows="1" class="coderevolution_gutenberg_input" name="aiomatic_ai_title" id="aiomatic_ai_title" placeholder="The AI generated title will appear here"></textarea>
</td></tr>
<tr><td>
        <label for="aiomatic_ai_seo"><?php echo ucwords($post->post_type) . ' ' .esc_html__('AI Generated SEO Meta Description','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <textarea rows="2" class="coderevolution_gutenberg_input" name="aiomatic_ai_seo" id="aiomatic_ai_seo" placeholder="The AI generated meta description will appear here"></textarea>
</td></tr>
<tr><td>
        <label for="aiomatic_ai_content"><?php echo ucwords($post->post_type) . ' ' .esc_html__('AI Generated Content','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <textarea rows="10" class="coderevolution_gutenberg_input" name="aiomatic_ai_content" id="aiomatic_ai_content" placeholder="The AI generated content will appear here"></textarea>
</td></tr>
<tr><td>
        <label for="aiomatic_ai_excerpt"><?php echo ucwords($post->post_type) . ' ' .esc_html__('AI Generated Excerpt','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <textarea rows="2" class="coderevolution_gutenberg_input" name="aiomatic_ai_excerpt" id="aiomatic_ai_excerpt" placeholder="The AI generated excerpt will appear here"></textarea>
</td></tr>
<tr><td>
        <label for="aiomatic_ai_tags"><?php echo ucwords($post->post_type) . ' ' .esc_html__('AI Generated Tags','aiomatic-automatic-ai-content-writer');?></label>
        </td><td>
        <textarea rows="1" class="coderevolution_gutenberg_input" name="aiomatic_ai_tags" id="aiomatic_ai_tags" placeholder="The AI generated tags will appear here"></textarea>
</td></tr>
    </table>
    <br/>
    <button type="button" id="aiomatic_ai_content_generator" class="button button-primary"><?php echo esc_html__('Generate Using AI','aiomatic-automatic-ai-content-writer');?></button>&nbsp;&nbsp;
    <span id="aiomatic_save_button" class="aiomatic_none"><button type="button" id="aiomatic_save_ai_content" class="button button-primary"><?php echo esc_html__('Save AI Content','aiomatic-automatic-ai-content-writer');?></button></span>
    <br/>
    <br/>
    <div id="ai-generator-status">

    </div>
</div>