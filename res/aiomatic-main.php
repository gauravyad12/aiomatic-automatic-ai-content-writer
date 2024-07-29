<?php
   defined('ABSPATH') or die();  
   function aiomatic_admin_settings()
   {
       $all_models = aiomatic_get_all_models(true);
       $all_assistants = aiomatic_get_all_assistants(true);
       require_once (dirname(__FILE__) . "/aiomatic-languages.php");
   ?>
<div class="wp-header-end"></div>
<div class=" aiomatic-client-settings-wrapper">
<div class="wrap">
   <div class="ultimate-header">
         <img class="client-logo aiomatic-rounded-circle" src="<?php echo plugins_url( '/../images/icon.png', __FILE__ ); ?>" alt="WordPress" height="50" width="62.5" />
         <h1><?php esc_html_e( 'Aiomatic - AI Content Writer, Editor, ChatBot & AI Toolkit', 'aiomatic-automatic-ai-content-writer' ); ?><span class="aiomatic-brand-dash-developer"><?php esc_html_e( 'Version', 'aiomatic-automatic-ai-content-writer' ); ?> <?php echo aiomatic_get_version();?><?php if (is_plugin_active('aiomatic-automatic-ai-content-writer-pro/aiomatic-automatic-ai-content-writer-pro.php') ) { ?> | Pro Version <?php echo $aiomatic_pro_plugin_version ?><?php } ?></span></h1>
</div></div>
<div class="wrap">
<div class="aiomatic-page-navigation vertical left clearfix">
   <div class="aiomatic-tabs-navigation-wrapper">
        <nav class="nav-tab-wrapper">
            <a href="#tab-15" class="aiomatic-nav-tab"><?php echo esc_html__("Welcome", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-1" class="aiomatic-nav-tab"><?php echo esc_html__("Plugin Activation", 'aiomatic-automatic-ai-content-writer');?></a>
<?php
$plugin = plugin_basename(__FILE__);
$plugin_slug = explode('/', $plugin);
$plugin_slug = $plugin_slug[0]; 
update_option($plugin_slug . '_registration', array('item_id'=>'38877369', 'item_name'=>'Aiomatic - Automatic AI Content Writer', 'created_at'=>'NA', 'buyer'=>'GPL','licence'=>'Custom License','supported_until'=>'12/12/2099'));
$uoptions = array();
$is_activated = aiomatic_is_activated($plugin_slug, $uoptions);
if($is_activated === true || $is_activated === 2)
{
?>
            <a href="#tab-2" class="aiomatic-nav-tab"><?php echo esc_html__("API Keys", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-7" class="aiomatic-nav-tab"><?php echo esc_html__("General Settings", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-17" class="aiomatic-nav-tab"><?php echo esc_html__("Bulk Posts", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-32" class="aiomatic-nav-tab"><?php echo esc_html__("OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-29" class="aiomatic-nav-tab"><?php echo esc_html__("Advanced AI Settings", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-4" class="aiomatic-nav-tab"><?php echo esc_html__("AI Images", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-31" class="aiomatic-nav-tab"><?php echo esc_html__("AI Videos", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-8" class="aiomatic-nav-tab"><?php echo esc_html__("Royalty Free Images", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-28" class="aiomatic-nav-tab"><?php echo esc_html__("Cloud Storage", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-5" class="aiomatic-nav-tab"><?php echo esc_html__("Statistics", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-13" class="aiomatic-nav-tab"><?php echo esc_html__("Embeddings", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-14" class="aiomatic-nav-tab"><?php echo esc_html__("AI Internet Access", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-9" class="aiomatic-nav-tab"><?php echo esc_html__("Random Sentences", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-10" class="aiomatic-nav-tab"><?php echo esc_html__("Custom HTML", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-11" class="aiomatic-nav-tab"><?php echo esc_html__("Keyword Replacer", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-20" class="aiomatic-nav-tab"><?php echo esc_html__("[aicontent] Shortcode", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-16" class="aiomatic-nav-tab"><?php echo esc_html__("Content Wizard", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-18" class="aiomatic-nav-tab"><?php echo esc_html__("AI Forms", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-21" class="aiomatic-nav-tab"><?php echo esc_html__("AI Commenter", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-22" class="aiomatic-nav-tab"><?php echo esc_html__("AI Taxonomy SEO", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-23" class="aiomatic-nav-tab"><?php echo esc_html__("Link Keywords", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-24" class="aiomatic-nav-tab"><?php echo esc_html__("YouTube Embeds", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-26" class="aiomatic-nav-tab"><?php echo esc_html__("AI Image Selector", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-27" class="aiomatic-nav-tab"><?php echo esc_html__("AI Writer", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-30" class="aiomatic-nav-tab"><?php echo esc_html__("Web Scraping", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-25" class="aiomatic-nav-tab"><?php echo esc_html__("WP-CLI", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-33" class="aiomatic-nav-tab"><?php echo esc_html__("REST API", 'aiomatic-automatic-ai-content-writer');?></a>
            <div class="aiomatic-nav-tab">&nbsp;</div>
            <div class="aiomatic-nav-tab">&nbsp;</div>
<?php
}
?>
        </nav>
   </div>
</div>
<div class="aiomatic-tab-content">
      <form id="myForm" method="post" class="form-table" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
      <div class="aiomatic-inner-wrapper settings-dashboard">
         <div class="cr_autocomplete">
            <input type="password" id="PreventChromeAutocomplete" 
               name="PreventChromeAutocomplete" autocomplete="address-level4" />
         </div>
         <?php
            settings_fields('aiomatic_option_group');
            do_settings_sections('aiomatic_option_group');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['aiomatic_enabled'])) {
                $aiomatic_enabled = $aiomatic_Main_Settings['aiomatic_enabled'];
            } else {
                $aiomatic_enabled = '';
            }
            
            if (isset($aiomatic_Main_Settings['sentence_list'])) {
                $sentence_list = $aiomatic_Main_Settings['sentence_list'];
            } else {
                $sentence_list = '';
            }
            if (isset($aiomatic_Main_Settings['sentence_list2'])) {
                $sentence_list2 = $aiomatic_Main_Settings['sentence_list2'];
            } else {
                $sentence_list2 = '';
            }
            if (isset($aiomatic_Main_Settings['player_height'])) {
                $player_height = $aiomatic_Main_Settings['player_height'];
            } else {
                $player_height = '';
            }
            if (isset($aiomatic_Main_Settings['improve_yt_kw'])) {
                $improve_yt_kw = $aiomatic_Main_Settings['improve_yt_kw'];
            } else {
                $improve_yt_kw = '';
            }
            if (isset($aiomatic_Main_Settings['yt_kw_model'])) {
                $yt_kw_model = $aiomatic_Main_Settings['yt_kw_model'];
            } else {
                $yt_kw_model = '';
            }
            if (isset($aiomatic_Main_Settings['yt_assistant_id'])) {
                $yt_assistant_id = $aiomatic_Main_Settings['yt_assistant_id'];
            } else {
                $yt_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['kw_assistant_id'])) {
                $kw_assistant_id = $aiomatic_Main_Settings['kw_assistant_id'];
            } else {
                $kw_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['yt_kw_prompt'])) {
                $yt_kw_prompt = $aiomatic_Main_Settings['yt_kw_prompt'];
            } else {
                $yt_kw_prompt = '';
            }
            if (isset($aiomatic_Main_Settings['ai_writer_model'])) {
                $ai_writer_model = $aiomatic_Main_Settings['ai_writer_model'];
            } else {
                $ai_writer_model = '';
            }
            if (isset($aiomatic_Main_Settings['writer_assistant_id'])) {
                $writer_assistant_id = $aiomatic_Main_Settings['writer_assistant_id'];
            } else {
                $writer_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['ai_writer_title_prompt'])) {
                $ai_writer_title_prompt = $aiomatic_Main_Settings['ai_writer_title_prompt'];
            } else {
                $ai_writer_title_prompt = 'Create a captivating and concise SEO title in English for your WordPress %%post_type%%: "%%post_title_idea%%". Boost its search engine visibility with relevant keywords for maximum impact.';
            }
            if (isset($aiomatic_Main_Settings['ai_writer_seo_prompt'])) {
                $ai_writer_seo_prompt = $aiomatic_Main_Settings['ai_writer_seo_prompt'];
            } else {
                $ai_writer_seo_prompt = 'Craft an enticing and succinct meta description in English for your WordPress %%post_type%%: "%%post_title_idea%%". Emphasize the notable features and advantages in just 155 characters, incorporating relevant keywords to optimize its SEO performance.';
            }
            if (isset($aiomatic_Main_Settings['ai_writer_content_prompt'])) {
                $ai_writer_content_prompt = $aiomatic_Main_Settings['ai_writer_content_prompt'];
            } else {
                $ai_writer_content_prompt = 'Create a captivating and comprehensive English description for your WordPress %%post_type%%: "%%post_title_idea%%". Dive into specific details, highlighting its unique features of this subject, if possible, benefits, and the value it brings. Craft a compelling narrative around the %%post_type%% that captivates the audience. Use HTML for formatting, include unnumbered lists and bold. Writing Style: Creative. Tone: Neutral.';
            }
            if (isset($aiomatic_Main_Settings['ai_writer_excerpt_prompt'])) {
                $ai_writer_excerpt_prompt = $aiomatic_Main_Settings['ai_writer_excerpt_prompt'];
            } else {
                $ai_writer_excerpt_prompt = 'Write a captivating and succinct English summary for the WordPress %%post_type%%: "%%post_title_idea%%", accentuating its pivotal features, advantages, and distinctive qualities.';
            }
            if (isset($aiomatic_Main_Settings['ai_writer_tags_prompt'])) {
                $ai_writer_tags_prompt = $aiomatic_Main_Settings['ai_writer_tags_prompt'];
            } else {
                $ai_writer_tags_prompt = 'Suggest a series of pertinent keywords in English for your WordPress %%post_type%%: "%%post_title_idea%%". These keywords should be closely connected to the %%post_type%%, optimizing its visibility. Please present the keywords in a comma-separated format without using symbols like -, #, etc.';
            }
            if (isset($aiomatic_Main_Settings['deepl_auth'])) {
                $deepl_auth = $aiomatic_Main_Settings['deepl_auth'];
            } else {
                $deepl_auth = '';
            }
            if (isset($aiomatic_Main_Settings['deppl_free'])) {
                $deppl_free = $aiomatic_Main_Settings['deppl_free'];
            } else {
                $deppl_free = '';
            }
            if (isset($aiomatic_Main_Settings['bing_auth'])) {
                $bing_auth = $aiomatic_Main_Settings['bing_auth'];
            } else {
                $bing_auth = '';
            }
            if (isset($aiomatic_Main_Settings['bing_region'])) {
                $bing_region = $aiomatic_Main_Settings['bing_region'];
            } else {
                $bing_region = '';
            }
            if (isset($aiomatic_Main_Settings['video_cfg_scale'])) {
                $video_cfg_scale = $aiomatic_Main_Settings['video_cfg_scale'];
            } else {
                $video_cfg_scale = '';
            }
            if (isset($aiomatic_Main_Settings['cfg_seed'])) {
                $cfg_seed = $aiomatic_Main_Settings['cfg_seed'];
            } else {
                $cfg_seed = '';
            }
            if (isset($aiomatic_Main_Settings['motion_bucket_id'])) {
                $motion_bucket_id = $aiomatic_Main_Settings['motion_bucket_id'];
            } else {
                $motion_bucket_id = '';
            }
            if (isset($aiomatic_Main_Settings['kw_prompt'])) {
                $kw_prompt = $aiomatic_Main_Settings['kw_prompt'];
            } else {
                $kw_prompt = 'Extract a comma-separated list of the most relevant single word keywords from the text, prioritizing specific references over general keywords. Add the highest priority to the most specific keyword that is still related to the main topic. The text is: \"%%content%%\".';
            }
            if (isset($aiomatic_Main_Settings['kw_model'])) {
                $kw_model = $aiomatic_Main_Settings['kw_model'];
            } else {
               $kw_model = get_default_model_name($aiomatic_Main_Settings);
            }
            if (isset($aiomatic_Main_Settings['player_width'])) {
                $player_width = $aiomatic_Main_Settings['player_width'];
            } else {
                $player_width = '';
            }
            if (isset($aiomatic_Main_Settings['global_req_words'])) {
                $global_req_words = $aiomatic_Main_Settings['global_req_words'];
            } else {
                $global_req_words = '';
            }
            if (isset($aiomatic_Main_Settings['require_only_one'])) {
                $require_only_one = $aiomatic_Main_Settings['require_only_one'];
            } else {
                $require_only_one = '';
            }
            if (isset($aiomatic_Main_Settings['global_ban_words'])) {
                $global_ban_words = $aiomatic_Main_Settings['global_ban_words'];
            } else {
                $global_ban_words = '';
            }
            if (isset($aiomatic_Main_Settings['email_notification'])) {
                $email_notification = $aiomatic_Main_Settings['email_notification'];
            } else {
                $email_notification = '';
            }
            if (isset($aiomatic_Main_Settings['image_ai_prompt'])) {
                $image_ai_prompt = $aiomatic_Main_Settings['image_ai_prompt'];
            } else {
                $image_ai_prompt = '';
            }
            if (isset($aiomatic_Main_Settings['image_ai_model'])) {
                $image_ai_model = $aiomatic_Main_Settings['image_ai_model'];
            } else {
                $image_ai_model = '';
            }
            if (isset($aiomatic_Main_Settings['img_assistant_id'])) {
                $img_assistant_id = $aiomatic_Main_Settings['img_assistant_id'];
            } else {
                $img_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['use_image_ai'])) {
                $use_image_ai = $aiomatic_Main_Settings['use_image_ai'];
            } else {
                $use_image_ai = '';
            }
            if (isset($aiomatic_Main_Settings['gpt35_context_limit'])) {
                $gpt35_context_limit = $aiomatic_Main_Settings['gpt35_context_limit'];
            } else {
                $gpt35_context_limit = '';
            }
            if (isset($aiomatic_Main_Settings['claude_context_limit'])) {
                $claude_context_limit = $aiomatic_Main_Settings['claude_context_limit'];
            } else {
                $claude_context_limit = '';
            }
            if (isset($aiomatic_Main_Settings['claude_context_limit_200k'])) {
                $claude_context_limit_200k = $aiomatic_Main_Settings['claude_context_limit_200k'];
            } else {
                $claude_context_limit_200k = '';
            }
            if (isset($aiomatic_Main_Settings['assist_max_prompt_token'])) {
                $assist_max_prompt_token = $aiomatic_Main_Settings['assist_max_prompt_token'];
            } else {
                $assist_max_prompt_token = '';
            }
            if (isset($aiomatic_Main_Settings['assist_max_completion_token'])) {
                $assist_max_completion_token = $aiomatic_Main_Settings['assist_max_completion_token'];
            } else {
                $assist_max_completion_token = '';
            }
            if (isset($aiomatic_Main_Settings['gpt4_context_limit'])) {
                $gpt4_context_limit = $aiomatic_Main_Settings['gpt4_context_limit'];
            } else {
                $gpt4_context_limit = '';
            }
            if (isset($aiomatic_Main_Settings['variable_list'])) {
                $variable_list = $aiomatic_Main_Settings['variable_list'];
            } else {
                $variable_list = '';
            }
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                $enable_detailed_logging = $aiomatic_Main_Settings['enable_detailed_logging'];
            } else {
                $enable_detailed_logging = '';
            }
            if (isset($aiomatic_Main_Settings['proxy_url'])) {
                $proxy_url = $aiomatic_Main_Settings['proxy_url'];
            } else {
                $proxy_url = '';
            }
            if (isset($aiomatic_Main_Settings['proxy_auth'])) {
                $proxy_auth = $aiomatic_Main_Settings['proxy_auth'];
            } else {
                $proxy_auth = '';
            }
            if (isset($aiomatic_Main_Settings['proxy_ai'])) {
                $proxy_ai = $aiomatic_Main_Settings['proxy_ai'];
            } else {
                $proxy_ai = '';
            }
            if (isset($aiomatic_Main_Settings['run_before'])) {
                $run_before = $aiomatic_Main_Settings['run_before'];
            } else {
                $run_before = '';
            }
            if (isset($aiomatic_Main_Settings['run_after'])) {
                $run_after = $aiomatic_Main_Settings['run_after'];
            } else {
                $run_after = '';
            }
            if (isset($aiomatic_Main_Settings['kw_lang'])) {
                $kw_lang = $aiomatic_Main_Settings['kw_lang'];
            } else {
                $kw_lang = '';
            }
            if (isset($aiomatic_Main_Settings['kw_method'])) {
                $kw_method = $aiomatic_Main_Settings['kw_method'];
            } else {
                $kw_method = 'builtin';
            }
            if (isset($aiomatic_Main_Settings['max_len'])) {
                $max_len = $aiomatic_Main_Settings['max_len'];
            } else {
                $max_len = '';
            }
            if (isset($aiomatic_Main_Settings['ai_image_size'])) {
                $ai_image_size = $aiomatic_Main_Settings['ai_image_size'];
            } else {
                $ai_image_size = '512x512';
            }
            if (isset($aiomatic_Main_Settings['ai_image_model'])) {
                $ai_image_model = $aiomatic_Main_Settings['ai_image_model'];
            } else {
                $ai_image_model = 'dalle2';
            }
            if (isset($aiomatic_Main_Settings['back_color'])) {
                $back_color = $aiomatic_Main_Settings['back_color'];
            } else {
                $back_color = '#ffffff';
            }
            if (isset($aiomatic_Main_Settings['form_placeholder'])) {
                $form_placeholder = $aiomatic_Main_Settings['form_placeholder'];
            } else {
                $form_placeholder = 'AI Result';
            }
            if (isset($aiomatic_Main_Settings['submit_location'])) {
                $submit_location = $aiomatic_Main_Settings['submit_location'];
            } else {
                $submit_location = '1';
            }
            if (isset($aiomatic_Main_Settings['submit_align'])) {
                $submit_align = $aiomatic_Main_Settings['submit_align'];
            } else {
                $submit_align = '1';
            }
            if (isset($aiomatic_Main_Settings['show_advanced'])) {
                $show_advanced = $aiomatic_Main_Settings['show_advanced'];
            } else {
                $show_advanced = '';
            }
            if (isset($aiomatic_Main_Settings['show_rich_editor'])) {
                $show_rich_editor = $aiomatic_Main_Settings['show_rich_editor'];
            } else {
                $show_rich_editor = '';
            }
            if (isset($aiomatic_Main_Settings['enable_copy'])) {
                $enable_copy = $aiomatic_Main_Settings['enable_copy'];
            } else {
                $enable_copy = '';
            }
            if (isset($aiomatic_Main_Settings['enable_download'])) {
                $enable_download = $aiomatic_Main_Settings['enable_download'];
            } else {
                $enable_download = '';
            }
            if (isset($aiomatic_Main_Settings['enable_char_count'])) {
                $enable_char_count = $aiomatic_Main_Settings['enable_char_count'];
            } else {
                $enable_char_count = '';
            }
            if (isset($aiomatic_Main_Settings['text_color'])) {
                $text_color = $aiomatic_Main_Settings['text_color'];
            } else {
                $text_color = '#000000';
            }
            if (isset($aiomatic_Main_Settings['btext_color'])) {
                $btext_color = $aiomatic_Main_Settings['btext_color'];
            } else {
                $btext_color = '#ffffff;';
            }
            if (isset($aiomatic_Main_Settings['aicontent_model'])) {
                $aicontent_model = $aiomatic_Main_Settings['aicontent_model'];
            } else {
                $aicontent_model = '';
            }
            if (isset($aiomatic_Main_Settings['aicontent_assistant_id'])) {
                $aicontent_assistant_id = $aiomatic_Main_Settings['aicontent_assistant_id'];
            } else {
                $aicontent_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['tax_description_model'])) {
                $tax_description_model = $aiomatic_Main_Settings['tax_description_model'];
            } else {
                $tax_description_model = '';
            }
            if (isset($aiomatic_Main_Settings['tax_assistant_id'])) {
                $tax_assistant_id = $aiomatic_Main_Settings['tax_assistant_id'];
            } else {
                $tax_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['enable_wpcli'])) {
                $enable_wpcli = $aiomatic_Main_Settings['enable_wpcli'];
            } else {
                $enable_wpcli = '';
            }
            if (isset($aiomatic_Main_Settings['rest_api_init'])) {
                $rest_api_init = $aiomatic_Main_Settings['rest_api_init'];
            } else {
                $rest_api_init = '';
            }
            if (isset($aiomatic_Main_Settings['rest_api_keys'])) {
                $rest_api_keys = $aiomatic_Main_Settings['rest_api_keys'];
            } else {
                $rest_api_keys = '';
            }
            if (isset($aiomatic_Main_Settings['tax_description_prompt'])) {
                $tax_description_prompt = $aiomatic_Main_Settings['tax_description_prompt'];
            } else {
                $tax_description_prompt = 'Write a description for a WordPress %%term_taxonomy_name%% with the following title: "%%term_name%%"';
            }
            if (isset($aiomatic_Main_Settings['aicontent_temperature'])) {
                $aicontent_temperature = $aiomatic_Main_Settings['aicontent_temperature'];
            } else {
                $aicontent_temperature = '1';
            }
            if (isset($aiomatic_Main_Settings['aicontent_top_p'])) {
                $aicontent_top_p = $aiomatic_Main_Settings['aicontent_top_p'];
            } else {
                $aicontent_top_p = '1';
            }
            if (isset($aiomatic_Main_Settings['aicontent_presence_penalty'])) {
                $aicontent_presence_penalty = $aiomatic_Main_Settings['aicontent_presence_penalty'];
            } else {
                $aicontent_presence_penalty = '0';
            }
            if (isset($aiomatic_Main_Settings['aicontent_frequency_penalty'])) {
                $aicontent_frequency_penalty = $aiomatic_Main_Settings['aicontent_frequency_penalty'];
            } else {
                $aicontent_frequency_penalty = '0';
            }
            if (isset($aiomatic_Main_Settings['comment_model'])) {
                $comment_model = $aiomatic_Main_Settings['comment_model'];
            } else {
               $comment_model = get_default_model_name($aiomatic_Main_Settings);
            }
            if (isset($aiomatic_Main_Settings['tax_description_auto'])) {
                $tax_description_auto = $aiomatic_Main_Settings['tax_description_auto'];
            } else {
                $tax_description_auto = array();
            }
            if (isset($aiomatic_Main_Settings['tax_description_manual'])) {
                $tax_description_manual = $aiomatic_Main_Settings['tax_description_manual'];
            } else {
                $tax_description_manual = array();
            }
            if (isset($aiomatic_Main_Settings['max_tax_nr'])) {
                $max_tax_nr = $aiomatic_Main_Settings['max_tax_nr'];
            } else {
                $max_tax_nr = array();
            }
            if (isset($aiomatic_Main_Settings['overwite_tax'])) {
                $overwite_tax = $aiomatic_Main_Settings['overwite_tax'];
            } else {
                $overwite_tax = array();
            }
            if (isset($aiomatic_Main_Settings['tax_seo_auto'])) {
                $tax_seo_auto = $aiomatic_Main_Settings['tax_seo_auto'];
            } else {
                $tax_seo_auto = 'off';
            }
            if (isset($aiomatic_Main_Settings['tax_seo_description_model'])) {
                $tax_seo_description_model = $aiomatic_Main_Settings['tax_seo_description_model'];
            } else {
               $tax_seo_description_model = get_default_model_name($aiomatic_Main_Settings);
            }
            if (isset($aiomatic_Main_Settings['tax_seo_assistant_id'])) {
                $tax_seo_assistant_id = $aiomatic_Main_Settings['tax_seo_assistant_id'];
            } else {
                $tax_seo_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['tax_seo_description_prompt'])) {
                $tax_seo_description_prompt = $aiomatic_Main_Settings['tax_seo_description_prompt'];
            } else {
                $tax_seo_description_prompt = 'Write a SEO friendly short description (maximum 30 words) for a WordPress %%term_taxonomy_name%% with the following title: "%%term_name%%"';
            }
            if (isset($aiomatic_Main_Settings['comment_prompt'])) {
                $comment_prompt = $aiomatic_Main_Settings['comment_prompt'];
            } else {
                $comment_prompt = 'Write a reply for %%username%%\'s comment on the post titled "%%post_title%%". The user\'s comment is: %%comment%%';
            }
            if (isset($aiomatic_Main_Settings['comment_assistant_id'])) {
                $comment_assistant_id = $aiomatic_Main_Settings['comment_assistant_id'];
            } else {
                $comment_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['but_color'])) {
                $but_color = $aiomatic_Main_Settings['but_color'];
            } else {
                $but_color = '#424242;';
            }
            if (isset($aiomatic_Main_Settings['min_len'])) {
                $min_len = $aiomatic_Main_Settings['min_len'];
            } else {
                $min_len = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_model'])) {
                $embeddings_model = $aiomatic_Main_Settings['embeddings_model'];
            } else {
                $embeddings_model = '';
            }
            if (isset($aiomatic_Main_Settings['pinecone_index'])) {
                $pinecone_index = $aiomatic_Main_Settings['pinecone_index'];
            } else {
                $pinecone_index = '';
            }
            if (isset($aiomatic_Main_Settings['pinecone_namespace'])) {
                $pinecone_namespace = $aiomatic_Main_Settings['pinecone_namespace'];
            } else {
                $pinecone_namespace = '';
            }
            if (isset($aiomatic_Main_Settings['qdrant_index'])) {
                $qdrant_index = $aiomatic_Main_Settings['qdrant_index'];
            } else {
                $qdrant_index = '';
            }
            if (isset($aiomatic_Main_Settings['qdrant_name'])) {
                $qdrant_name = $aiomatic_Main_Settings['qdrant_name'];
            } else {
                $qdrant_name = '';
            }
            if (isset($aiomatic_Main_Settings['pinecone_topk'])) {
                $pinecone_topk = $aiomatic_Main_Settings['pinecone_topk'];
            } else {
                $pinecone_topk = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_single'])) {
                $embeddings_single = $aiomatic_Main_Settings['embeddings_single'];
            } else {
                $embeddings_single = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk'])) {
                $embeddings_bulk = $aiomatic_Main_Settings['embeddings_bulk'];
            } else {
                $embeddings_bulk = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_title'])) {
                $embeddings_bulk_title = $aiomatic_Main_Settings['embeddings_bulk_title'];
            } else {
                $embeddings_bulk_title = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_sections'])) {
                $embeddings_bulk_sections = $aiomatic_Main_Settings['embeddings_bulk_sections'];
            } else {
                $embeddings_bulk_sections = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_intro'])) {
                $embeddings_bulk_intro = $aiomatic_Main_Settings['embeddings_bulk_intro'];
            } else {
                $embeddings_bulk_intro = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_content'])) {
                $embeddings_bulk_content = $aiomatic_Main_Settings['embeddings_bulk_content'];
            } else {
                $embeddings_bulk_content = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_qa'])) {
                $embeddings_bulk_qa = $aiomatic_Main_Settings['embeddings_bulk_qa'];
            } else {
                $embeddings_bulk_qa = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_outro'])) {
                $embeddings_bulk_outro = $aiomatic_Main_Settings['embeddings_bulk_outro'];
            } else {
                $embeddings_bulk_outro = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_bulk_excerpt'])) {
                $embeddings_bulk_excerpt = $aiomatic_Main_Settings['embeddings_bulk_excerpt'];
            } else {
                $embeddings_bulk_excerpt = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_edit'])) {
                $embeddings_edit = $aiomatic_Main_Settings['embeddings_edit'];
            } else {
                $embeddings_edit = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_chat_short'])) {
                $embeddings_chat_short = $aiomatic_Main_Settings['embeddings_chat_short'];
            } else {
                $embeddings_chat_short = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_article_short'])) {
                $embeddings_article_short = $aiomatic_Main_Settings['embeddings_article_short'];
            } else {
                $embeddings_article_short = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_edit_short'])) {
                $embeddings_edit_short = $aiomatic_Main_Settings['embeddings_edit_short'];
            } else {
                $embeddings_edit_short = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_related'])) {
                $embeddings_related = $aiomatic_Main_Settings['embeddings_related'];
            } else {
                $embeddings_related = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_assistant'])) {
                $embeddings_assistant = $aiomatic_Main_Settings['embeddings_assistant'];
            } else {
                $embeddings_assistant = '';
            }
            if (isset($aiomatic_Main_Settings['internet_single'])) {
                $internet_single = $aiomatic_Main_Settings['internet_single'];
            } else {
                $internet_single = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk'])) {
                $internet_bulk = $aiomatic_Main_Settings['internet_bulk'];
            } else {
                $internet_bulk = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_title'])) {
                $internet_bulk_title = $aiomatic_Main_Settings['internet_bulk_title'];
            } else {
                $internet_bulk_title = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_sections'])) {
                $internet_bulk_sections = $aiomatic_Main_Settings['internet_bulk_sections'];
            } else {
                $internet_bulk_sections = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_intro'])) {
                $internet_bulk_intro = $aiomatic_Main_Settings['internet_bulk_intro'];
            } else {
                $internet_bulk_intro = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_content'])) {
                $internet_bulk_content = $aiomatic_Main_Settings['internet_bulk_content'];
            } else {
                $internet_bulk_content = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_qa'])) {
                $internet_bulk_qa = $aiomatic_Main_Settings['internet_bulk_qa'];
            } else {
                $internet_bulk_qa = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_outro'])) {
                $internet_bulk_outro = $aiomatic_Main_Settings['internet_bulk_outro'];
            } else {
                $internet_bulk_outro = '';
            }
            if (isset($aiomatic_Main_Settings['internet_bulk_excerpt'])) {
                $internet_bulk_excerpt = $aiomatic_Main_Settings['internet_bulk_excerpt'];
            } else {
                $internet_bulk_excerpt = '';
            }
            if (isset($aiomatic_Main_Settings['internet_prompt'])) {
                $internet_prompt = $aiomatic_Main_Settings['internet_prompt'];
            } else {
                $internet_prompt = '';
            }
            if (isset($aiomatic_Main_Settings['index_types'])) {
                $index_types = $aiomatic_Main_Settings['index_types'];
            } else {
                $index_types = array();
            }
            if (isset($aiomatic_Main_Settings['rewrite_embedding'])) {
                $rewrite_embedding = $aiomatic_Main_Settings['rewrite_embedding'];
            } else {
                $rewrite_embedding = array();
            }
            if (isset($aiomatic_Main_Settings['embedding_template'])) {
                $embedding_template = $aiomatic_Main_Settings['embedding_template'];
            } else {
                $embedding_template = '%%post_title%%
%%post_excerpt%%
Read more at: %%post_url%%';
            }
            if (isset($aiomatic_Main_Settings['embedding_rw_prompt'])) {
                $embedding_rw_prompt = $aiomatic_Main_Settings['embedding_rw_prompt'];
            } else {
                $embedding_rw_prompt = 'Rewrite the given content concisely, preserving its style and information, while ensuring the rewritten text stays within 300 words. Each paragraph should range between 60 to 120 words. Exclude non-textual elements and unnecessary repetition. Conclude with a statement directing readers to find more information at %%post_url%%. If these guidelines cannot be met, send an empty response. The content is as follows: %%post_content%%';
            }
            if (isset($aiomatic_Main_Settings['embedding_rw_model'])) {
                $embedding_rw_model = $aiomatic_Main_Settings['embedding_rw_model'];
            } else {
                $embedding_rw_model = get_default_model_name($aiomatic_Main_Settings);
            }
            if (isset($aiomatic_Main_Settings['emb_assistant_id'])) {
                $emb_assistant_id = $aiomatic_Main_Settings['emb_assistant_id'];
            } else {
                $emb_assistant_id = get_default_model_name($aiomatic_Main_Settings);
            }
            if (isset($aiomatic_Main_Settings['internet_single_template'])) {
                $internet_single_template = $aiomatic_Main_Settings['internet_single_template'];
            } else {
                $internet_single_template = '';
            }
            if (isset($aiomatic_Main_Settings['keyword_extractor_prompt'])) {
                $keyword_extractor_prompt = $aiomatic_Main_Settings['keyword_extractor_prompt'];
            } else {
                $keyword_extractor_prompt = '';
            }
            if (isset($aiomatic_Main_Settings['internet_gl'])) {
                $internet_gl = $aiomatic_Main_Settings['internet_gl'];
            } else {
                $internet_gl = '';
            }
            if (isset($aiomatic_Main_Settings['internet_model'])) {
                $internet_model = $aiomatic_Main_Settings['internet_model'];
            } else {
                $internet_model = '';
            }
            if (isset($aiomatic_Main_Settings['internet_assistant_id'])) {
                $internet_assistant_id = $aiomatic_Main_Settings['internet_assistant_id'];
            } else {
                $internet_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['results_num'])) {
                $results_num = $aiomatic_Main_Settings['results_num'];
            } else {
                $results_num = '';
            }
            if (isset($aiomatic_Main_Settings['internet_edit'])) {
                $internet_edit = $aiomatic_Main_Settings['internet_edit'];
            } else {
                $internet_edit = '';
            }
            if (isset($aiomatic_Main_Settings['internet_chat_short'])) {
                $internet_chat_short = $aiomatic_Main_Settings['internet_chat_short'];
            } else {
                $internet_chat_short = '';
            }
            if (isset($aiomatic_Main_Settings['internet_article_short'])) {
                $internet_article_short = $aiomatic_Main_Settings['internet_article_short'];
            } else {
                $internet_article_short = '';
            }
            if (isset($aiomatic_Main_Settings['internet_edit_short'])) {
                $internet_edit_short = $aiomatic_Main_Settings['internet_edit_short'];
            } else {
                $internet_edit_short = '';
            }
            if (isset($aiomatic_Main_Settings['internet_related'])) {
                $internet_related = $aiomatic_Main_Settings['internet_related'];
            } else {
                $internet_related = '';
            }
            if (isset($aiomatic_Main_Settings['internet_assistant'])) {
                $internet_assistant = $aiomatic_Main_Settings['internet_assistant'];
            } else {
                $internet_assistant = '';
            }
            if (isset($aiomatic_Main_Settings['internet_forms'])) {
                $internet_forms = $aiomatic_Main_Settings['internet_forms'];
            } else {
                $internet_forms = '';
            }
            if (isset($aiomatic_Main_Settings['internet_omni'])) {
                $internet_omni = $aiomatic_Main_Settings['internet_omni'];
            } else {
                $internet_omni = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_forms'])) {
                $embeddings_forms = $aiomatic_Main_Settings['embeddings_forms'];
            } else {
                $embeddings_forms = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_omni'])) {
                $embeddings_omni = $aiomatic_Main_Settings['embeddings_omni'];
            } else {
                $embeddings_omni = '';
            }
            if (isset($aiomatic_Main_Settings['do_not_check_duplicates'])) {
                $do_not_check_duplicates = $aiomatic_Main_Settings['do_not_check_duplicates'];
            } else {
                $do_not_check_duplicates = '';
            }
            if (isset($aiomatic_Main_Settings['no_random_titles'])) {
                $no_random_titles = $aiomatic_Main_Settings['no_random_titles'];
            } else {
                $no_random_titles = '';
            }
            if (isset($aiomatic_Main_Settings['draft_first'])) {
                $draft_first = $aiomatic_Main_Settings['draft_first'];
            } else {
                $draft_first = '';
            }
            if (isset($aiomatic_Main_Settings['alternate_continue'])) {
                $alternate_continue = $aiomatic_Main_Settings['alternate_continue'];
            } else {
                $alternate_continue = '';
            }
            if (isset($aiomatic_Main_Settings['whole_prompt'])) {
                $whole_prompt = $aiomatic_Main_Settings['whole_prompt'];
            } else {
                $whole_prompt = '';
            }
            if (isset($aiomatic_Main_Settings['external_products'])) {
                $external_products = $aiomatic_Main_Settings['external_products'];
            } else {
                $external_products = '';
            }
            if (isset($aiomatic_Main_Settings['continue_prepend'])) {
                $continue_prepend = $aiomatic_Main_Settings['continue_prepend'];
            } else {
                $continue_prepend = '';
            }
            if (isset($aiomatic_Main_Settings['continue_append'])) {
                $continue_append = $aiomatic_Main_Settings['continue_append'];
            } else {
                $continue_append = '';
            }
            if (isset($aiomatic_Main_Settings['no_max'])) {
                $no_max = $aiomatic_Main_Settings['no_max'];
            } else {
                $no_max = '';
            }
            if (isset($aiomatic_Main_Settings['no_jobs'])) {
                $no_jobs = $aiomatic_Main_Settings['no_jobs'];
            } else {
                $no_jobs = '';
            }
            if (isset($aiomatic_Main_Settings['not_important'])) {
                $not_important = $aiomatic_Main_Settings['not_important'];
            } else {
                $not_important = '';
            }
            if (isset($aiomatic_Main_Settings['bing_off'])) {
                $bing_off = $aiomatic_Main_Settings['bing_off'];
            } else {
                $bing_off = '';
            }
            if (isset($aiomatic_Main_Settings['markdown_parse'])) {
                $markdown_parse = $aiomatic_Main_Settings['markdown_parse'];
            } else {
                $markdown_parse = '';
            }
            if (isset($aiomatic_Main_Settings['nlbr_parse'])) {
                $nlbr_parse = $aiomatic_Main_Settings['nlbr_parse'];
            } else {
                $nlbr_parse = '';
            }
            if (isset($aiomatic_Main_Settings['ai_off'])) {
                $ai_off = $aiomatic_Main_Settings['ai_off'];
            } else {
                $ai_off = '';
            }
            if (isset($aiomatic_Main_Settings['pre_code_off'])) {
                $pre_code_off = $aiomatic_Main_Settings['pre_code_off'];
            } else {
                $pre_code_off = '';
            }
            if (isset($aiomatic_Main_Settings['max_retry'])) {
                $max_retry = $aiomatic_Main_Settings['max_retry'];
            } else {
                $max_retry = '';
            }
            if (isset($aiomatic_Main_Settings['max_chat_retry'])) {
                $max_chat_retry = $aiomatic_Main_Settings['max_chat_retry'];
            } else {
                $max_chat_retry = '';
            }
            if (isset($aiomatic_Main_Settings['max_timeout'])) {
                $max_timeout = $aiomatic_Main_Settings['max_timeout'];
            } else {
                $max_timeout = '';
            }
            if (isset($aiomatic_Main_Settings['enable_logging'])) {
                $enable_logging = $aiomatic_Main_Settings['enable_logging'];
            } else {
                $enable_logging = '';
            }
            if (isset($aiomatic_Main_Settings['enable_tracking'])) {
                $enable_tracking = $aiomatic_Main_Settings['enable_tracking'];
            } else {
                $enable_tracking = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_placement'])) {
                $assistant_placement = $aiomatic_Main_Settings['assistant_placement'];
            } else {
                $assistant_placement = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_disable'])) {
                $assistant_disable = $aiomatic_Main_Settings['assistant_disable'];
            } else {
                $assistant_disable = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_not_logged'])) {
                $assistant_not_logged = $aiomatic_Main_Settings['assistant_not_logged'];
            } else {
                $assistant_not_logged = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_image_size'])) {
                $assistant_image_size = $aiomatic_Main_Settings['assistant_image_size'];
            } else {
                $assistant_image_size = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_image_model'])) {
                $assistant_image_model = $aiomatic_Main_Settings['assistant_image_model'];
            } else {
                $assistant_image_model = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_temperature'])) {
                $assistant_temperature = $aiomatic_Main_Settings['assistant_temperature'];
            } else {
                $assistant_temperature = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_top_p'])) {
                $assistant_top_p = $aiomatic_Main_Settings['assistant_top_p'];
            } else {
                $assistant_top_p = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_ppenalty'])) {
                $assistant_ppenalty = $aiomatic_Main_Settings['assistant_ppenalty'];
            } else {
                $assistant_ppenalty = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_fpenalty'])) {
                $assistant_fpenalty = $aiomatic_Main_Settings['assistant_fpenalty'];
            } else {
                $assistant_fpenalty = '';
            }
            if (isset($aiomatic_Main_Settings['assistant_model'])) {
                $assistant_model = $aiomatic_Main_Settings['assistant_model'];
            } else {
                $assistant_model = '';
            }
            if (isset($aiomatic_Main_Settings['wizard_assistant_id'])) {
                $wizard_assistant_id = $aiomatic_Main_Settings['wizard_assistant_id'];
            } else {
                $wizard_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['rel_search'])) {
                $rel_search = $aiomatic_Main_Settings['rel_search'];
            } else {
                $rel_search = array();
            }
            if (isset($aiomatic_Main_Settings['app_id'])) {
                $app_id = $aiomatic_Main_Settings['app_id'];
            } else {
                $app_id = '';
            }
            if (isset($aiomatic_Main_Settings['stability_app_id'])) {
                $stability_app_id = $aiomatic_Main_Settings['stability_app_id'];
            } else {
                $stability_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['midjourney_app_id'])) {
                $midjourney_app_id = $aiomatic_Main_Settings['midjourney_app_id'];
            } else {
                $midjourney_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['headlessbrowserapi_key'])) {
                $headlessbrowserapi_key = $aiomatic_Main_Settings['headlessbrowserapi_key'];
            } else {
                $headlessbrowserapi_key = '';
            }
            if (isset($aiomatic_Main_Settings['phantom_path'])) {
                $phantom_path = $aiomatic_Main_Settings['phantom_path'];
            } else {
                $phantom_path = '';
            }
            if (isset($aiomatic_Main_Settings['phantom_timeout'])) {
                $phantom_timeout = $aiomatic_Main_Settings['phantom_timeout'];
            } else {
                $phantom_timeout = '';
            }
            if (isset($aiomatic_Main_Settings['multi_separator'])) {
                $multi_separator = $aiomatic_Main_Settings['multi_separator'];
            } else {
                $multi_separator = '';
            }
            if (isset($aiomatic_Main_Settings['azure_endpoint'])) {
                $azure_endpoint = $aiomatic_Main_Settings['azure_endpoint'];
            } else {
                $azure_endpoint = '';
            }
            if (isset($aiomatic_Main_Settings['app_id_claude'])) {
                $app_id_claude = $aiomatic_Main_Settings['app_id_claude'];
            } else {
                $app_id_claude = '';
            }
            if (isset($aiomatic_Main_Settings['openai_organization'])) {
                $openai_organization = $aiomatic_Main_Settings['openai_organization'];
            } else {
                $openai_organization = '';
            }
            if (isset($aiomatic_Main_Settings['app_id_google'])) {
                $app_id_google = $aiomatic_Main_Settings['app_id_google'];
            } else {
                $app_id_google = '';
            }
            if (isset($aiomatic_Main_Settings['app_id_openrouter'])) {
                $app_id_openrouter = $aiomatic_Main_Settings['app_id_openrouter'];
            } else {
                $app_id_openrouter = '';
            }
            if (isset($aiomatic_Main_Settings['app_id_huggingface'])) {
                $app_id_huggingface = $aiomatic_Main_Settings['app_id_huggingface'];
            } else {
                $app_id_huggingface = '';
            }
            if (isset($aiomatic_Main_Settings['ollama_url'])) {
                $ollama_url = $aiomatic_Main_Settings['ollama_url'];
            } else {
                $ollama_url = '';
            }
            if (isset($aiomatic_Main_Settings['app_id_perplexity'])) {
                $app_id_perplexity = $aiomatic_Main_Settings['app_id_perplexity'];
            } else {
                $app_id_perplexity = '';
            }
            if (isset($aiomatic_Main_Settings['multiple_key'])) {
                $multiple_key = $aiomatic_Main_Settings['multiple_key'];
            } else {
                $multiple_key = '';
            }
            if (isset($aiomatic_Main_Settings['pinecone_app_id'])) {
                $pinecone_app_id = $aiomatic_Main_Settings['pinecone_app_id'];
            } else {
                $pinecone_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['qdrant_app_id'])) {
                $qdrant_app_id = $aiomatic_Main_Settings['qdrant_app_id'];
            } else {
                $qdrant_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['embeddings_api'])) {
                $embeddings_api = $aiomatic_Main_Settings['embeddings_api'];
            } else {
                $embeddings_api = '';
            }
            if (isset($aiomatic_Main_Settings['elevenlabs_app_id'])) {
                $elevenlabs_app_id = $aiomatic_Main_Settings['elevenlabs_app_id'];
            } else {
                $elevenlabs_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['google_app_id'])) {
                $google_app_id = $aiomatic_Main_Settings['google_app_id'];
            } else {
                $google_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['did_app_id'])) {
                $did_app_id = $aiomatic_Main_Settings['did_app_id'];
            } else {
                $did_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['api_selector'])) {
                $api_selector = $aiomatic_Main_Settings['api_selector'];
            } else {
                $api_selector = 'openai';
            }
            if (isset($aiomatic_Main_Settings['steps'])) {
                $steps = $aiomatic_Main_Settings['steps'];
            } else {
                $steps = '';
            }
            if (isset($aiomatic_Main_Settings['cfg_scale'])) {
                $cfg_scale = $aiomatic_Main_Settings['cfg_scale'];
            } else {
                $cfg_scale = '';
            }
            if (isset($aiomatic_Main_Settings['clip_guidance_preset'])) {
                $clip_guidance_preset = $aiomatic_Main_Settings['clip_guidance_preset'];
            } else {
                $clip_guidance_preset = '';
            }
            if (isset($aiomatic_Main_Settings['clip_style_preset'])) {
                $clip_style_preset = $aiomatic_Main_Settings['clip_style_preset'];
            } else {
                $clip_style_preset = '';
            }
            if (isset($aiomatic_Main_Settings['stable_model'])) {
                $stable_model = $aiomatic_Main_Settings['stable_model'];
            } else {
                $stable_model = '';
            }
            if (isset($aiomatic_Main_Settings['sampler'])) {
                $sampler = $aiomatic_Main_Settings['sampler'];
            } else {
                $sampler = '';
            }
            if (isset($aiomatic_Main_Settings['auto_clear_logs'])) {
                $auto_clear_logs = $aiomatic_Main_Settings['auto_clear_logs'];
            } else {
                $auto_clear_logs = '';
            }
            if (isset($aiomatic_Main_Settings['rule_timeout'])) {
                $rule_timeout = $aiomatic_Main_Settings['rule_timeout'];
            } else {
                $rule_timeout = '';
            }
            if (isset($aiomatic_Main_Settings['send_email'])) {
                $send_email = $aiomatic_Main_Settings['send_email'];
            } else {
                $send_email = '';
            }
            if (isset($aiomatic_Main_Settings['email_address'])) {
                $email_address = $aiomatic_Main_Settings['email_address'];
            } else {
                $email_address = '';
            }
            if (isset($aiomatic_Main_Settings['translate'])) {
                $translate = $aiomatic_Main_Settings['translate'];
            } else {
                $translate = '';
            }
            if (isset($aiomatic_Main_Settings['translate_source'])) {
                $translate_source = $aiomatic_Main_Settings['translate_source'];
            } else {
                $translate_source = '';
            }
            if (isset($aiomatic_Main_Settings['second_translate'])) {
                $second_translate = $aiomatic_Main_Settings['second_translate'];
            } else {
                $second_translate = '';
            }
            if (isset($aiomatic_Main_Settings['spin_text'])) {
                $spin_text = $aiomatic_Main_Settings['spin_text'];
            } else {
                $spin_text = '';
            }
            if (isset($aiomatic_Main_Settings['spin_what'])) {
                $spin_what = $aiomatic_Main_Settings['spin_what'];
            } else {
                $spin_what = '';
            }
            if (isset($aiomatic_Main_Settings['best_humanize'])) {
                $best_humanize = $aiomatic_Main_Settings['best_humanize'];
            } else {
                $best_humanize = '';
            }
            if (isset($aiomatic_Main_Settings['no_title'])) {
                $no_title = $aiomatic_Main_Settings['no_title'];
            } else {
                $no_title = '';
            }
            if (isset($aiomatic_Main_Settings['swear_filter'])) {
                $swear_filter = $aiomatic_Main_Settings['swear_filter'];
            } else {
                $swear_filter = '';
            }
            if (isset($aiomatic_Main_Settings['no_undetectibility'])) {
                $no_undetectibility = $aiomatic_Main_Settings['no_undetectibility'];
            } else {
                $no_undetectibility = '';
            }
            if (isset($aiomatic_Main_Settings['no_media_library'])) {
                $no_media_library = $aiomatic_Main_Settings['no_media_library'];
            } else {
                $no_media_library = '';
            }
            if (isset($aiomatic_Main_Settings['clear_omni'])) {
                $clear_omni = $aiomatic_Main_Settings['clear_omni'];
            } else {
                $clear_omni = '';
            }
            if (isset($aiomatic_Main_Settings['no_pre_code_remove'])) {
                $no_pre_code_remove = $aiomatic_Main_Settings['no_pre_code_remove'];
            } else {
                $no_pre_code_remove = '';
            }
            if (isset($aiomatic_Main_Settings['no_omni_shortcode_render'])) {
                $no_omni_shortcode_render = $aiomatic_Main_Settings['no_omni_shortcode_render'];
            } else {
                $no_omni_shortcode_render = '';
            }
            if (isset($aiomatic_Main_Settings['azure_model_deployments'])) {
                $azure_model_deployments = $aiomatic_Main_Settings['azure_model_deployments'];
            } else {
                $azure_model_deployments = array();
            }
            if (isset($aiomatic_Main_Settings['ai_seed'])) {
                $ai_seed = $aiomatic_Main_Settings['ai_seed'];
            } else {
                $ai_seed = '';
            }
            if (isset($aiomatic_Main_Settings['google_trans_auth'])) {
                $google_trans_auth = $aiomatic_Main_Settings['google_trans_auth'];
            } else {
                $google_trans_auth = '';
            }
            if (isset($aiomatic_Main_Settings['serpapi_auth'])) {
                $serpapi_auth = $aiomatic_Main_Settings['serpapi_auth'];
            } else {
                $serpapi_auth = '';
            }
            if (isset($aiomatic_Main_Settings['google_search_api'])) {
                $google_search_api = $aiomatic_Main_Settings['google_search_api'];
            } else {
                $google_search_api = '';
            }
            if (isset($aiomatic_Main_Settings['google_search_cx'])) {
                $google_search_cx = $aiomatic_Main_Settings['google_search_cx'];
            } else {
                $google_search_cx = '';
            }
            if (isset($aiomatic_Main_Settings['valueserp_auth'])) {
                $valueserp_auth = $aiomatic_Main_Settings['valueserp_auth'];
            } else {
                $valueserp_auth = '';
            }
            if (isset($aiomatic_Main_Settings['yt_app_id'])) {
                $yt_app_id = $aiomatic_Main_Settings['yt_app_id'];
            } else {
                $yt_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['ai_resize_width'])) {
                $ai_resize_width = $aiomatic_Main_Settings['ai_resize_width'];
            } else {
                $ai_resize_width = '';
            }
            if (isset($aiomatic_Main_Settings['copy_locally'])) {
                $copy_locally = $aiomatic_Main_Settings['copy_locally'];
            } else {
                $copy_locally = '';
            }
            if (isset($aiomatic_Main_Settings['disable_compress'])) {
                $disable_compress = $aiomatic_Main_Settings['disable_compress'];
            } else {
                $disable_compress = '';
            }
            if (isset($aiomatic_Main_Settings['compress_quality'])) {
                $compress_quality = $aiomatic_Main_Settings['compress_quality'];
            } else {
                $compress_quality = '';
            }
            if (isset($aiomatic_Main_Settings['url_image'])) {
                $url_image = $aiomatic_Main_Settings['url_image'];
            } else {
                $url_image = '';
            }
            if (isset($aiomatic_Main_Settings['drive_directory'])) {
                $drive_directory = $aiomatic_Main_Settings['drive_directory'];
            } else {
                $drive_directory = 'MyImages';
            }
            if (isset($aiomatic_Main_Settings['bucket_name'])) {
                $bucket_name = $aiomatic_Main_Settings['bucket_name'];
            } else {
                $bucket_name = '';
            }
            if (isset($aiomatic_Main_Settings['bucket_region'])) {
                $bucket_region = $aiomatic_Main_Settings['bucket_region'];
            } else {
                $bucket_region = '';
            }
            if (isset($aiomatic_Main_Settings['wasabi_region'])) {
                $wasabi_region = $aiomatic_Main_Settings['wasabi_region'];
            } else {
                $wasabi_region = '';
            }
            if (isset($aiomatic_Main_Settings['s3_user'])) {
                $s3_user = $aiomatic_Main_Settings['s3_user'];
            } else {
                $s3_user = '';
            }
            if (isset($aiomatic_Main_Settings['s3_pass'])) {
                $s3_pass = $aiomatic_Main_Settings['s3_pass'];
            } else {
                $s3_pass = '';
            }
            if (isset($aiomatic_Main_Settings['wasabi_directory'])) {
                $wasabi_directory = $aiomatic_Main_Settings['wasabi_directory'];
            } else {
                $wasabi_directory = '';
            }
            if (isset($aiomatic_Main_Settings['wasabi_bucket'])) {
                $wasabi_bucket = $aiomatic_Main_Settings['wasabi_bucket'];
            } else {
                $wasabi_bucket = '';
            }
            if (isset($aiomatic_Main_Settings['wasabi_region'])) {
                $wasabi_region = $aiomatic_Main_Settings['wasabi_region'];
            } else {
                $wasabi_region = '';
            }
            if (isset($aiomatic_Main_Settings['wasabi_user'])) {
                $wasabi_user = $aiomatic_Main_Settings['wasabi_user'];
            } else {
                $wasabi_user = '';
            }
            if (isset($aiomatic_Main_Settings['wasabi_pass'])) {
                $wasabi_pass = $aiomatic_Main_Settings['wasabi_pass'];
            } else {
                $wasabi_pass = '';
            }
            if (isset($aiomatic_Main_Settings['cloud_directory'])) {
                $cloud_directory = $aiomatic_Main_Settings['cloud_directory'];
            } else {
                $cloud_directory = '';
            }
            if (isset($aiomatic_Main_Settings['cloud_bucket'])) {
                $cloud_bucket = $aiomatic_Main_Settings['cloud_bucket'];
            } else {
                $cloud_bucket = '';
            }
            if (isset($aiomatic_Main_Settings['cloud_account'])) {
                $cloud_account = $aiomatic_Main_Settings['cloud_account'];
            } else {
                $cloud_account = '';
            }
            if (isset($aiomatic_Main_Settings['cloud_user'])) {
                $cloud_user = $aiomatic_Main_Settings['cloud_user'];
            } else {
                $cloud_user = '';
            }
            if (isset($aiomatic_Main_Settings['cloud_pass'])) {
                $cloud_pass = $aiomatic_Main_Settings['cloud_pass'];
            } else {
                $cloud_pass = '';
            }
            if (isset($aiomatic_Main_Settings['digital_directory'])) {
                $digital_directory = $aiomatic_Main_Settings['digital_directory'];
            } else {
                $digital_directory = '';
            }
            if (isset($aiomatic_Main_Settings['digital_endpoint'])) {
                $digital_endpoint = $aiomatic_Main_Settings['digital_endpoint'];
            } else {
                $digital_endpoint = '';
            }
            if (isset($aiomatic_Main_Settings['digital_user'])) {
                $digital_user = $aiomatic_Main_Settings['digital_user'];
            } else {
                $digital_user = '';
            }
            if (isset($aiomatic_Main_Settings['digital_pass'])) {
                $digital_pass = $aiomatic_Main_Settings['digital_pass'];
            } else {
                $digital_pass = '';
            }
            if (isset($aiomatic_Main_Settings['no_img_translate'])) {
                $no_img_translate = $aiomatic_Main_Settings['no_img_translate'];
            } else {
                $no_img_translate = '';
            }
            if (isset($aiomatic_Main_Settings['omni_webhook'])) {
                $omni_webhook = $aiomatic_Main_Settings['omni_webhook'];
            } else {
                $omni_webhook = '';
            }
            if (isset($aiomatic_Main_Settings['omni_caching'])) {
                $omni_caching = $aiomatic_Main_Settings['omni_caching'];
            } else {
                $omni_caching = '';
            }
            if (isset($aiomatic_Main_Settings['dalle_style'])) {
                $dalle_style = $aiomatic_Main_Settings['dalle_style'];
            } else {
                $dalle_style = '';
            }
            if (isset($aiomatic_Main_Settings['midjourney_image_model'])) {
                $midjourney_image_model = $aiomatic_Main_Settings['midjourney_image_model'];
            } else {
                $midjourney_image_model = '';
            }
            if (isset($aiomatic_Main_Settings['ai_resize_height'])) {
                $ai_resize_height = $aiomatic_Main_Settings['ai_resize_height'];
            } else {
                $ai_resize_height = '';
            }
            if (isset($aiomatic_Main_Settings['ai_resize_quality'])) {
                $ai_resize_quality = $aiomatic_Main_Settings['ai_resize_quality'];
            } else {
                $ai_resize_quality = '';
            }
            if (isset($aiomatic_Main_Settings['textrazor_key'])) {
                $textrazor_key = $aiomatic_Main_Settings['textrazor_key'];
            } else {
                $textrazor_key = '';
            }
            if (isset($aiomatic_Main_Settings['neuron_project'])) {
                $neuron_project = $aiomatic_Main_Settings['neuron_project'];
            } else {
                $neuron_project = '';
            }
            if (isset($aiomatic_Main_Settings['neuron_key'])) {
                $neuron_key = $aiomatic_Main_Settings['neuron_key'];
            } else {
                $neuron_key = '';
            }
            if (isset($aiomatic_Main_Settings['amazon_app_secret'])) {
                $amazon_app_secret = $aiomatic_Main_Settings['amazon_app_secret'];
            } else {
                $amazon_app_secret = '';
            }
            if (isset($aiomatic_Main_Settings['amazon_app_id'])) {
                $amazon_app_id = $aiomatic_Main_Settings['amazon_app_id'];
            } else {
                $amazon_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['plagiarism_api'])) {
                $plagiarism_api = $aiomatic_Main_Settings['plagiarism_api'];
            } else {
                $plagiarism_api = '';
            }
            if (isset($aiomatic_Main_Settings['keyword_prompts'])) {
                $keyword_prompts = $aiomatic_Main_Settings['keyword_prompts'];
            } else {
                $keyword_prompts = '';
            }
            if (isset($aiomatic_Main_Settings['keyword_model'])) {
                $keyword_model = $aiomatic_Main_Settings['keyword_model'];
            } else {
                $keyword_model = '';
            }
            if (isset($aiomatic_Main_Settings['keyword_assistant_id'])) {
                $keyword_assistant_id = $aiomatic_Main_Settings['keyword_assistant_id'];
            } else {
                $keyword_assistant_id = '';
            }
            if (isset($aiomatic_Main_Settings['improve_keywords'])) {
                $improve_keywords = $aiomatic_Main_Settings['improve_keywords'];
            } else {
                $improve_keywords = '';
            }
            if (isset($aiomatic_Main_Settings['image_pool'])) {
                $image_pool = $aiomatic_Main_Settings['image_pool'];
            } else {
                $image_pool = '';
            }
            if (isset($aiomatic_Main_Settings['random_image_sources'])) {
                $random_image_sources = $aiomatic_Main_Settings['random_image_sources'];
            } else {
                $random_image_sources = '';
            }
            if (isset($aiomatic_Main_Settings['random_results_order'])) {
                $random_results_order = $aiomatic_Main_Settings['random_results_order'];
            } else {
                $random_results_order = '';
            }
            if (isset($aiomatic_Main_Settings['image_query_translate_en'])) {
                $image_query_translate_en = $aiomatic_Main_Settings['image_query_translate_en'];
            } else {
                $image_query_translate_en = '';
            }
            if (isset($aiomatic_Main_Settings['best_user'])) {
                $best_user = $aiomatic_Main_Settings['best_user'];
            } else {
                $best_user = '';
            }
            if (isset($aiomatic_Main_Settings['exclude_words'])) {
                $exclude_words = $aiomatic_Main_Settings['exclude_words'];
            } else {
                $exclude_words = '';
            }
            if (isset($aiomatic_Main_Settings['best_password'])) {
                $best_password = $aiomatic_Main_Settings['best_password'];
            } else {
                $best_password = '';
            }
            if (isset($aiomatic_Main_Settings['morguefile_api'])) {
                $morguefile_api = $aiomatic_Main_Settings['morguefile_api'];
            } else {
                $morguefile_api = '';
            }
            if (isset($aiomatic_Main_Settings['morguefile_secret'])) {
                $morguefile_secret = $aiomatic_Main_Settings['morguefile_secret'];
            } else {
                $morguefile_secret = '';
            }
            if (isset($aiomatic_Main_Settings['pexels_api'])) {
                $pexels_api = $aiomatic_Main_Settings['pexels_api'];
            } else {
                $pexels_api = '';
            }
            if (isset($aiomatic_Main_Settings['flickr_api'])) {
                $flickr_api = $aiomatic_Main_Settings['flickr_api'];
            } else {
                $flickr_api = '';
            }
            if (isset($aiomatic_Main_Settings['flickr_license'])) {
                $flickr_license = $aiomatic_Main_Settings['flickr_license'];
            } else {
                $flickr_license = '';
            }
            if (isset($aiomatic_Main_Settings['flickr_order'])) {
                $flickr_order = $aiomatic_Main_Settings['flickr_order'];
            } else {
                $flickr_order = '';
            }
            if (isset($aiomatic_Main_Settings['pixabay_api'])) {
                $pixabay_api = $aiomatic_Main_Settings['pixabay_api'];
            } else {
                $pixabay_api = '';
            }
            if (isset($aiomatic_Main_Settings['imgtype'])) {
                $imgtype = $aiomatic_Main_Settings['imgtype'];
            } else {
                $imgtype = '';
            }
            if (isset($aiomatic_Main_Settings['img_order'])) {
                $img_order = $aiomatic_Main_Settings['img_order'];
            } else {
                $img_order = '';
            }
            if (isset($aiomatic_Main_Settings['request_delay'])) {
                $request_delay = $aiomatic_Main_Settings['request_delay'];
            } else {
                $request_delay = '';
            }
            if (isset($aiomatic_Main_Settings['img_cat'])) {
                $img_cat = $aiomatic_Main_Settings['img_cat'];
            } else {
                $img_cat = '';
            }
            if (isset($aiomatic_Main_Settings['img_width'])) {
                $img_width = $aiomatic_Main_Settings['img_width'];
            } else {
                $img_width = '';
            }
            if (isset($aiomatic_Main_Settings['img_mwidth'])) {
                $img_mwidth = $aiomatic_Main_Settings['img_mwidth'];
            } else {
                $img_mwidth = '';
            }
            if (isset($aiomatic_Main_Settings['img_ss'])) {
                $img_ss = $aiomatic_Main_Settings['img_ss'];
            } else {
                $img_ss = '';
            }
            if (isset($aiomatic_Main_Settings['img_editor'])) {
                $img_editor = $aiomatic_Main_Settings['img_editor'];
            } else {
                $img_editor = '';
            }
            if (isset($aiomatic_Main_Settings['img_language'])) {
                $img_language = $aiomatic_Main_Settings['img_language'];
            } else {
                $img_language = '';
            }
            if (isset($aiomatic_Main_Settings['unsplash_api'])) {
                $unsplash_api = $aiomatic_Main_Settings['unsplash_api'];
            } else {
                $unsplash_api = '';
            }
            if (isset($aiomatic_Main_Settings['google_images'])) {
                $google_images = $aiomatic_Main_Settings['google_images'];
            } else {
                $google_images = '';
            }
            if (isset($aiomatic_Main_Settings['pixabay_scrape'])) {
                $pixabay_scrape = $aiomatic_Main_Settings['pixabay_scrape'];
            } else {
                $pixabay_scrape = '';
            }
            if (isset($aiomatic_Main_Settings['scrapeimgtype'])) {
                $scrapeimgtype = $aiomatic_Main_Settings['scrapeimgtype'];
            } else {
                $scrapeimgtype = '';
            }
            if (isset($aiomatic_Main_Settings['scrapeimg_orientation'])) {
                $scrapeimg_orientation = $aiomatic_Main_Settings['scrapeimg_orientation'];
            } else {
                $scrapeimg_orientation = '';
            }
            if (isset($aiomatic_Main_Settings['scrapeimg_order'])) {
                $scrapeimg_order = $aiomatic_Main_Settings['scrapeimg_order'];
            } else {
                $scrapeimg_order = '';
            }
            if (isset($aiomatic_Main_Settings['scrapeimg_cat'])) {
                $scrapeimg_cat = $aiomatic_Main_Settings['scrapeimg_cat'];
            } else {
                $scrapeimg_cat = '';
            }
            if (isset($aiomatic_Main_Settings['scrapeimg_width'])) {
                $scrapeimg_width = $aiomatic_Main_Settings['scrapeimg_width'];
            } else {
                $scrapeimg_width = '';
            }
            if (isset($aiomatic_Main_Settings['scrapeimg_height'])) {
                $scrapeimg_height = $aiomatic_Main_Settings['scrapeimg_height'];
            } else {
                $scrapeimg_height = '';
            }
            if (isset($aiomatic_Main_Settings['attr_text'])) {
                $attr_text = $aiomatic_Main_Settings['attr_text'];
            } else {
                $attr_text = '';
            }
            if (isset($aiomatic_Main_Settings['bimage'])) {
                $bimage = $aiomatic_Main_Settings['bimage'];
            } else {
                $bimage = '';
            }
            if (isset($aiomatic_Main_Settings['no_royalty_skip'])) {
                $no_royalty_skip = $aiomatic_Main_Settings['no_royalty_skip'];
            } else {
                $no_royalty_skip = '';
            }
            if (isset($aiomatic_Main_Settings['custom_html2'])) {
                $custom_html2 = $aiomatic_Main_Settings['custom_html2'];
            } else {
                $custom_html2 = '';
            }
            if (isset($aiomatic_Main_Settings['partial_kws'])) {
                $partial_kws = $aiomatic_Main_Settings['partial_kws'];
            } else {
                $partial_kws = '';
            }
            if (isset($aiomatic_Main_Settings['kws_case'])) {
                $kws_case = $aiomatic_Main_Settings['kws_case'];
            } else {
                $kws_case = '';
            }
            if (isset($aiomatic_Main_Settings['no_new_tab_kw'])) {
                $no_new_tab_kw = $aiomatic_Main_Settings['no_new_tab_kw'];
            } else {
                $no_new_tab_kw = '';
            }
            if (isset($aiomatic_Main_Settings['kw_skip_ids'])) {
                $kw_skip_ids = $aiomatic_Main_Settings['kw_skip_ids'];
            } else {
                $kw_skip_ids = '';
            }
            if (isset($aiomatic_Main_Settings['custom_html'])) {
                $custom_html = $aiomatic_Main_Settings['custom_html'];
            } else {
                $custom_html = '';
            }
            if (isset($aiomatic_Main_Settings['resize_width'])) {
                $resize_width = $aiomatic_Main_Settings['resize_width'];
            } else {
                $resize_width = '';
            }
            if (isset($aiomatic_Main_Settings['resize_quality'])) {
                $resize_quality = $aiomatic_Main_Settings['resize_quality'];
            } else {
                $resize_quality = '';
            }
            if (isset($aiomatic_Main_Settings['resize_height'])) {
                $resize_height = $aiomatic_Main_Settings['resize_height'];
            } else {
                $resize_height = '';
            }
            if (isset($_GET['settings-updated'])) {
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'aiomatic-automatic-ai-content-writer');?></strong></p>
         </div>
         <?php
            }
            ?>
            <div id="tab-15" class="tab-content">
            <br/><table class="widefat">
            <td>
            <h3><?php echo esc_html__('Welcome to the Aiomatic plugin!', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p><?php echo esc_html__('Hello, my name is', 'aiomatic-automatic-ai-content-writer');?> <a href="https://coderevolution.ro/our-story/" target="_blank">Szabi</a>, <?php echo esc_html__('I am the developer of the', 'aiomatic-automatic-ai-content-writer');?> <a href="https://1.envato.market/aiomatic" target="_blank">Aiomatic <?php echo esc_html__('plugin', 'aiomatic-automatic-ai-content-writer');?></a>. <?php echo esc_html__('I am really excited to have you on board as a user!', 'aiomatic-automatic-ai-content-writer');?></p>

            <p><?php echo esc_html__('Aiomatic is a powerful tool that can help you generate high-quality, AI-created content for your WordPress site. Whether you\'re a blogger, marketer, or simply looking to automate your content creation process, Aiomatic has everything you need to get started.', 'aiomatic-automatic-ai-content-writer');?></p>

            <p><?php echo esc_html__('If you\'re looking to edit existing or newly published posts, Aiomatic also offers AI content editors and AI-generated featured images to help streamline the process. And with advanced features like AI model fine-tuning, AI embeddings, and usage statistics, you can take your content creation to the next level and produce high-quality, engaging posts in no time.', 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Getting started?', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__('To set up the plugin in a fast and efficient way, click the "Start Plugin Quick Setup Now" button from below, which will guide you trough the essential steps to set up the plugin and will also teach you about its functionality.', 'aiomatic-automatic-ai-content-writer');?></p>
            <hr/>
            <div class="cr_center cr_width_full">
               <?php echo '<a href="' . esc_url_raw( admin_url('admin.php?page=aiomatic_admin_settings&aiomatic_go_config=1&nonce=' . wp_create_nonce('aiomatic-quick-config')) ) . '" class="button button-primary">' . esc_html__("Start Plugin Quick Setup Now", 'aiomatic-automatic-ai-content-writer') . '</a>';?>
            </div>
            <hr/>
            <p><?php echo esc_html__('If you don\'t want to use the above Quick Setup, to begin using the plugin, click on the \'Plugin Activation\' tab from above and register your Envato purchase code. This will allow you to benefit of the full feature set of this plugin. To learn how to find your purchase code for the plugin, check', 'aiomatic-automatic-ai-content-writer');?> <a href="https://www.youtube.com/watch?v=NElJ5t_Wd48" target="_blank"><?php echo esc_html__('this video', 'aiomatic-automatic-ai-content-writer');?></a>.</p>

            <p><?php echo esc_html__('Afterwards, you need to add your', 'aiomatic-automatic-ai-content-writer');?> <a href="https://platform.openai.com/account/api-keys" target="_blank">OpenAI</a> <?php echo esc_html__('API key or', 'aiomatic-automatic-ai-content-writer');?> <a href="https://aiomaticapi.com/" target="_blank">AiomaticAPI</a> <?php echo esc_html__('API key into the plugin\'s settings (depending which service you choose). You can do this by going to the \'API keys\' tab from above. In this tab you will find also some additional API keys to add, like', 'aiomatic-automatic-ai-content-writer');?> <a href="https://beta.dreamstudio.ai/membership?tab=apiKeys" target="_blank">Stability.AI</a> (<?php echo esc_html__('to create images using Stable Difussion', 'aiomatic-automatic-ai-content-writer');?>) or <a href="https://www.pinecone.io/" target="_blank">Pinecone.io</a> (<?php echo esc_html__('used for the plugin\'s Embeddings functionality', 'aiomatic-automatic-ai-content-writer');?>).</p>
            
            <p><?php echo esc_html__('Now you are ready to get started seeing the plugin in action! You can hover your mouse over the Aiomatic menu in your WordPress dashboard. From there, you can choose to generate a single AI post or to create bulk automatic AI-created posts, complete with rich HTML content and royalty-free or AI-generated images. You can also edit existing or newly published posts, using an AI content editor. If you are an advanced user or you want to learn how to squize more out of the plugin and AI in general, check the Embeddings and Model Training features of the plugin. Finally, stop over to see the usage charts of the plugin and set limits for its API usage (if you feel that this is needed).', 'aiomatic-automatic-ai-content-writer');?></p>
            
            <p><?php echo esc_html__('You can also add a fully customizable chatbot to your site to engage with visitors and provide them with the information they need in real-time.', 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('What is Aiomatic?', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__('Aiomatic is a comprehensive WordPress plugin that leverages the capabilities of artificial intelligence to create content, chatbots, images, audio, and more. This all-in-one AI suite includes features such as Custom ChatGPT, Content Creator, Automatic Content Generator, Content Wizard, AI Forms, Image Creator, Audio Converter, SEO enhancer, AI Training, Embeddings, and more, all powered by GPT-3, GPT-3.5 and GPT-4.', 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Understanding How It Functions', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__("The Aiomatic plugin operates in conjunction with the OpenAI API or with AiomaticAPI (whichever you choose to use). To utilize it, you must first create an account on OpenAI and paste your API key in the plugin's settings ('API Keys' tab from the top). OpenAI offers a $5 credit for new users. If you see a message stating, \"You exceeded your current quota, please check your plan and billing details\" it means you've depleted your OpenAI quota and need to buy more credit from OpenAI.", 'aiomatic-automatic-ai-content-writer');?></p>

            <p><?php echo esc_html__("Acquiring the Aiomatic plugin does not include any OpenAI credit. Purchasing Aiomatic grants you access to the plugin's advanced features, but it doesn't cover any API credit. You'll need to buy credit from OpenAI or a subscription from AiomaticAPI separately.", 'aiomatic-automatic-ai-content-writer');?></p>

            <p><?php echo esc_html__("If you notice any slowdown or failure in content generation, it could be due to issues with the OpenAI API services. Please wait until their services are back to normal before attempting again.", 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Setting Up Your API Key', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><ul><li><?php echo esc_html__("Visit", 'aiomatic-automatic-ai-content-writer');?> <a href="https://platform.openai.com/account/api-keys" target="_blank">OpenAI</a> <?php echo esc_html__("or", 'aiomatic-automatic-ai-content-writer');?> <a href="https://aiomaticapi.com/" target="_blank">AiomaticAPI</a> <?php echo esc_html__("and create your API key.", 'aiomatic-automatic-ai-content-writer');?>
            </li><li>
            <?php echo esc_html__("Navigate to the 'API Keys' tab on the top of this admin page.", 'aiomatic-automatic-ai-content-writer');?>
            </li><li>
            <?php echo esc_html__("Input your API key in the 'OpenAI / AiomaticAPI API Keys (One Per Line)' settings field and hit the Save button.", 'aiomatic-automatic-ai-content-writer');?>
            </li><li>
            <?php echo esc_html__("You're all set!", 'aiomatic-automatic-ai-content-writer');?>
            </li></ul>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('How to use different features of the plugin? Like AI chatbot, AI content creator, AI Content Editor, AI Model Training, Embeddings, AI Forms and many more?', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__("Depending for which feature are you looking for, be sure to navigate to the respective menu of the Aiomatic plugin, wehre you will find a 'Tutorial' tab for each of the features available in the plugin. There you will find also a tutorial video, with detailed description of the feature you are setting up.", 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Using the Content Wizard', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            
            <p><?php echo esc_html__("The Content Wizard is a feature that allows you to add a button to the WordPress editor to assist in content creation. You can add your own menus with your own prompts. The Content Wizard is compatible with both Gutenberg and Classic Editor. Navigate to your Gutenberg or Classic Editor and look for the Aiomatic plugin's logo in the toolbar. Click on the logo and select the menu you want to use. Click the prompt you want to use. Please note that you need to use the \"Convert to Block\" feature in the Gutenberg Editor to use the Content Wizard.", 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Some Important Notes:', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            
<ul><li>
<?php echo esc_html__("Note 1: Don't forget to secure your API key from OpenAI (don't share it with anyone).", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Note 2: If you're using Cloudflare, please read below.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Note 3: If you're using the WP Rocket caching plugin, please deactivate and reactivate your caching plugin.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Note 4: If your server has a timeout limit (max_execution_time server settings limited), you may not be able to generate longer content. Please request your hosting provider to extend the server timeout limit to at least 10-15 minutes to generate longer content.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Note 5: If you're using iThemes security, please ensure to allow PHP calls from the plugin folder, otherwise, some features of the plugin might not work.", 'aiomatic-automatic-ai-content-writer');?>
            </li></ul>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Using CloudFlare for this website?', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__("If you encounter slowdowns or a even a full halt in your content creation workflow, the problem could potentially come from Cloudflare.", 'aiomatic-automatic-ai-content-writer');?></p>
            <p><?php echo esc_html__("To better understand how this might be happening, it is helpful to first understand how the content generation part of the plugin functions. In most cases, when you request the plugin to create a post with a AI generated title, 5 headings, intro + outro and a Q&A section, the plugin sends 1 API request to generate the title, 5 different API requests for the headings, 3 API requests for the intro, outro and Q&A sections. So, for a single post, there might be 9 or more API calls to OpenAI/AiomaticAPI. If each request takes 20 seconds to receive a response, this means that generating this post could take up to 180 seconds in total.", 'aiomatic-automatic-ai-content-writer');?></p>
            <p><?php echo esc_html__("Unfortunately, the default connection timeout for Cloudflare is set at 100 seconds. This implies that if you're utilizing Cloudflare's default plan and fail to receive all responses from OpenAI within the 100-second window, Cloudflare will reach its timeout limit, resulting in it fully stopping content creation. However, CloudFlare Enterprise users have the option to extend this timeout limit to 6000 seconds either through the Cloudflare API or by reaching out to customer service. Note that only CloudFlare's Enterprise plan will allow this settings change.", 'aiomatic-automatic-ai-content-writer');?></p>

            <p><?php echo esc_html__("If you're a Cloudflare user and you are facing slowdowns in your content creation workflow, one potential remedy could be to extend the connection timeout on Cloudflare (if this is possible in your case). Another approach could be to deactivate CloudFlare while you are using the Aiomatic plugin on your site for long content creation (which uses multiple API requests).", 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Using a LiteSpeed Web Server for this website?', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__("If you are using a LiteSpeed web server, you might need to configure it to allow longer execution times of Aiomatic.", 'aiomatic-automatic-ai-content-writer');?></p>
            <p><a href="https://docs.litespeedtech.com/lsws/cp/cpanel/long-run-script/" target="_blank"><?php echo esc_html__('Check this link for details', 'aiomatic-automatic-ai-content-writer');?></a>.</p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Need help?', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p><?php echo esc_html__('If you need help getting started with Aiomatic, be sure to check out', 'aiomatic-automatic-ai-content-writer');?> <a href="https://www.youtube.com/channel/UCVLIksvzyk-D_oEdHab2Lgg" target="_blank">CodeRevolutionTV's YouTube channel</a> <?php echo esc_html__('for tutorial videos and other helpful resources. Here you can always find what was the newest update for it and how it got improved. I am constantly adding new updates to the plugin to help you get the most out of it, so be sure to subscribe and stay up to date with the latest version of the plugin.', 'aiomatic-automatic-ai-content-writer');?></p>
            
            <p><?php echo esc_html__('If your issue is more technical, create a ticket and ask for support on', 'aiomatic-automatic-ai-content-writer');?> <a href="https://coderevolution.ro/support/tickets/aiomatic-support/" target="_blank"><?php echo esc_html__('Aiomatic\'s Support Page', 'aiomatic-automatic-ai-content-writer');?></a>.</p>
            <p><?php echo esc_html__("For more information about the plugin, please visit", 'aiomatic-automatic-ai-content-writer');?> <a href="https://www.youtube.com/playlist?list=PLEiGTaa0iBIhsRSgl5czLEDAhawr_SHx2" target="_blank">"Aiomatic Updates"</a> or <a href="https://www.youtube.com/playlist?list=PLEiGTaa0iBIhRvgICiyvwBXH-dMBM4VAt" target="_blank">"Aiomatic Tutorials"</a> <?php echo esc_html__("playlists on YouTube.", 'aiomatic-automatic-ai-content-writer');?></p>

            <p><?php echo esc_html__("Feel free to join our Discord community", 'aiomatic-automatic-ai-content-writer');?> <a href="https://discord.gg/Fjggup9wcM" target="_blank">here</a>.</p>

            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Now go have some fun using the plugin!', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            
            <p><?php echo esc_html__('Thank you for choosing Aiomatic, and I look forward to the plugin helping you create amazing content and features for your WordPress site!', 'aiomatic-automatic-ai-content-writer');?></p>
            <br/><table class="widefat"><tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Tutorial Video:', 'aiomatic-automatic-ai-content-writer');?></h2></td></tr></table>
            <p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/_Ft1czw-VPU" frameborder="0" allowfullscreen></iframe></div></p>
            </td>
            </table>
            </div>
            <div id="tab-1" class="tab-content">
            <div class="aiomatic_class">
               <h3>
                  <span class="gs-sub-heading"><?php echo esc_html__('Plugin\'s Main Switch:', 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;</span>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Fully enabled or disables the plugins functionality. If you want to use the plugin, be sure to keep this set to 'ON'.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>&nbsp;&nbsp;&nbsp;
                  <div class="aiomatic-inline-flex slideThree">	
                  <input class="input-checkbox-ai" type="checkbox" id="aiomatic_enabled" name="aiomatic_Main_Settings[aiomatic_enabled]"<?php
                     if ($aiomatic_enabled == 'on')
                           echo ' checked ';
                     ?>>
                  <label for="aiomatic_enabled"></label>
               </div>
               </h3>
               <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("Plugin activation enables the full functionality of the plugin, enable automatic updates for it to never miss the latest features available.", 'aiomatic-automatic-ai-content-writer');
?></p>
            </div>
            <?php if($aiomatic_enabled != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('The entire plugin\'s functionality is disabled! Please enable it from the above switch.', 'aiomatic-automatic-ai-content-writer') . '</div>';}?>
               <table class="widefat">
               <?php
                  if($is_activated === true)
                  {
                  ?>
                  <tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Plugin Registration Info - Automatic Updates Enabled:', 'aiomatic-automatic-ai-content-writer');?></h2>
                  </td></tr>
                  <tr>
                     <td colspan="2">
                        <ul>
                           <li><b><?php echo esc_html__("Item Name:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                           <li>
                              <b><?php echo esc_html__("Item ID:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['item_id']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Created At:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['created_at']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Buyer Name:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['buyer']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("License Type:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['licence']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Supported Until:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                              <?php 
                              $supported = strtotime($uoptions['supported_until']);
                              if($supported !== false && $supported < time())
                              {
      ?>
      <div class="notice notice-error is-dismissible">
        <p>
         <?php echo sprintf( wp_kses( __( 'Your support for Aiomatic has expired. Please <a href="%s" target="_blank">renew it</a> to continue receiving support for the plugin. After you renewed support, please click the "Revoke License" button, from the plugin\'s "Settings" menu -> "Plugin Activation" tab and add your license key again, to activate the plugin with the renewed support license.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//codecanyon.net/item/aiomatic-automatic-ai-content-writer/38877369/support');?>
        </p>
    </div>
    <?php
                              }
                              ?>
                           </li>
                           <li>
                              <input type="button" onclick="unsaved = false;" class="button button-primary" id="<?php echo esc_html($plugin_slug);?>_revoke_license" value="<?php echo esc_html__("Revoke License", 'aiomatic-automatic-ai-content-writer');?>">
                              <input type="hidden" id="<?php echo esc_html($plugin_slug);?>_activation_nonce" value="<?php echo wp_create_nonce('activation-secret-nonce');?>">
                           </li>
                        </ul>
                        <?php
                           }
                           elseif($is_activated === -1)
                           {
?>
<tr>
   <td colspan="2">
      <div><p class="cr_red"><?php echo esc_html__("You are using a PIRATED version of the plugin! Because of this, the main functionality of the plugin is not available. Please revoke your license and activate a genuine license for the Aiomatic plugin. Note that the only place where you can get a valid license for the plugin is found here (if you find the plugin for sale also on other websites, do not buy, they are selling pirated copies): ", 'aiomatic-automatic-ai-content-writer');?><a href="https://1.envato.market/aiomatic" target="_blank"><?php echo esc_html__("Aiomatic on CodeCanyon", 'aiomatic-automatic-ai-content-writer');?></a></p></div>
   </td>
</tr>
<tr>
   <td colspan="2">
   <input type="button" onclick="unsaved = false;" class="button button-primary" id="<?php echo esc_html($plugin_slug);?>_revoke_license" value="<?php echo esc_html__("Revoke License", 'aiomatic-automatic-ai-content-writer');?>">
   <input type="hidden" id="<?php echo esc_html($plugin_slug);?>_activation_nonce" value="<?php echo wp_create_nonce('activation-secret-nonce');?>">
   </td>
</tr>
<?php
                           }
                           elseif($is_activated === 2)
                           {
?>
<tr>
   <td colspan="2">
      <p class="cr_red"><?php echo esc_html__("This is a demo version of the Aiomatic plugin, it has limited functionality in some cases. In the demo mode, the plugin does not need purchase code activation. To use it also on your site, you can purchase a license for it from here: ", 'aiomatic-automatic-ai-content-writer');?><a href="https://1.envato.market/aiomatic" target="_blank"><?php echo esc_html__("Aiomatic on CodeCanyon", 'aiomatic-automatic-ai-content-writer');?></a></p>
   </td>
</tr>
<?php
                           }
                           else
                           {
?>  
                  <tr>
                     <td colspan="2">
                        <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("The Aiomatic plugin is not activated, its functionality is disabled. Please activate the plugin from below!", 'aiomatic-automatic-ai-content-writer');?></p></div>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Plugin Activation:', 'aiomatic-automatic-ai-content-writer');?></h2>
                  </td></tr>  
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' );
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Aiomatic Purchase Code:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td><input type="text" id="<?php echo esc_html($plugin_slug);?>_register_code" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full"></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type="button" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Activate License", 'aiomatic-automatic-ai-content-writer');?>"/>
                     <input type="hidden" id="<?php echo esc_html($plugin_slug);?>_activation_nonce" value="<?php echo wp_create_nonce('activation-secret-nonce');?>">
                        <?php
                           }
                           ?>
                     </td>
                  </tr>
               <tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__('Tips and tricks:', 'aiomatic-automatic-ai-content-writer');?></h2>
                  </td></tr>
                  <tr><td>
                  <ul>
                     <li><?php echo sprintf( wp_kses( __( 'Need help configuring this plugin? Please check out it\'s <a href="%s" target="_blank">video tutorial</a>.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.youtube.com/watch?v=ou3ATnTANJA' );?>
                     </li>
                     <li><?php echo sprintf( wp_kses( __( 'Having issues with the plugin? Please be sure to check out our <a href="%s" target="_blank">knowledge-base</a> before you contact <a href="%s" target="_blank">our support</a>!', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//coderevolution.ro/knowledge-base', '//coderevolution.ro/support' );?></li>
                     <li><?php echo sprintf( wp_kses( __( 'Do you enjoy our plugin? Please give it a <a href="%s" target="_blank">rating</a>  on CodeCanyon, or check <a href="%s" target="_blank">our website</a>  for other cool plugins.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '//codecanyon.net/downloads', 'https://coderevolution.ro' );?></a></li>
                  </ul>
            </td>
               </tr>
                     </table>
                     </div>
                     <div id="tab-2<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
            <h3><?php echo esc_html__('API Key Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'API Keys' menu allows you to manage and configure unique keys essential for integrating and authenticating external AI services with the Aiomatic plugin.", 'aiomatic-automatic-ai-content-writer');
?></p>
                        <table class="widefat">
               <tr class="aiomatic-title-holder"><td colspan="2"><h2><?php echo esc_html__("Main AI API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the AI API service to use to generate content in the plugin using the gpt-3.5/gpt-4 models.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Main API Service Provider Selector:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="api_selector" name="aiomatic_Main_Settings[api_selector]"  class="cr_width_full">
                              <option value="openai"<?php
                                 if ($api_selector == "openai") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("OpenAI / AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="azure"<?php
                                 if ($api_selector == "azure") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Microsoft Azure", 'aiomatic-automatic-ai-content-writer');?></option>                         
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr class="azurehide">
            <td colspan="2">
               <span class="cr_red">&#8252;&nbsp;
<?php echo sprintf( wp_kses( __( "Check <a href='%s' target='_blank'>this detailed step-by-step tutorial</a> and also <a href='%s' target='_blank'>this tutorial video</a> for info on setup and usage of Microsoft Azure OpenAI API in Aiomatic.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-setup-microsoft-azure-api-in-aiomatic/', 'https://www.youtube.com/watch?v=56ZHp2B4qgY' );?>
   &nbsp;&#8252;</span></td>
                              </tr>
                              <tr class="azurehide aiomatic-title-holder"><td colspan="2"><h2><?php echo esc_html__("Azure API Key Settings", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
          <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your API Keys (one per line). For OpenAI API, get your API key <a href='%s' target='_blank'>here</a>. For AiomaticAPI, get your API key <a href='%s' target='_blank'>here</a>. For Azure, get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://platform.openai.com/api-keys', 'https://aiomaticapi.com/pricing/', 'https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinks"><a href='https://platform.openai.com/api-keys' target='_blank'>OpenAI</a>&nbsp;/&nbsp;<a href='https://aiomaticapi.com/api-keys/' target='_blank'>AiomaticAPI</a></span>&nbsp;<?php echo esc_html__("API Keys (One Per Line) - *Required:", 'aiomatic-automatic-ai-content-writer');?></b>   
<?php
$token = '';
$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
$appids = array_filter($appids);
if(count($appids) == 1)
{
   $token = $appids[array_rand($appids)];
   if(aiomatic_is_aiomaticapi_key($token))
   {
      $call_count = get_transient('aiomaticapi_tokens');
      if($token != '' && $call_count !== false)
      {
         echo esc_html__("Remaining API Tokens: ", 'aiomatic-automatic-ai-content-writer') . '<b>' . $call_count . '</b>';
      }
   }
}

?>
               </div>
            </th>
            <td>
                  <textarea rows="2" id="app_id" onkeyup="keyUpdated();" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id]" placeholder="<?php echo esc_html__("Please insert your OpenAI/AiomaticAPI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id);
                     ?></textarea>
            </td>
            </tr>
            <tr class="azurehide">
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Azure OpenAI API endpoint. Get one in the <a href='%s' target='_blank'>Microsoft Azure Services panel</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Azure OpenAI Endpoint:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <input type="url" class="cr_width_full" autocomplete="off" id="azure_endpoint" name="aiomatic_Main_Settings[azure_endpoint]" placeholder="<?php echo esc_html__("Azure Endpoint", 'aiomatic-automatic-ai-content-writer');?>" value="<?php echo esc_attr($azure_endpoint);?>">
               </div>
            </td>
            </tr>
            <tr class="azurehide aiomatic-title-holder"><td colspan="2"><h2><?php echo esc_html__("Azure AI Model Deployments List", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
<?php
foreach (AIOMATIC_AZURE_MODELS as $model) {
   ?>
   <tr class="azurehide">
       <th>
           <div>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                   <div class="bws_hidden_help_text cr_min_260px">
                       <?php
                       echo sprintf( wp_kses( __( "Insert your Azure OpenAI API deployment name for %s model. Create one in the <a href='%s' target='_blank'>Microsoft Azure Services panel</a>.", 'aiomatic-automatic-ai-content-writer'), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_html($model), 'https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' );
                       ?>
                   </div>
               </div>
               <b><?php echo esc_html__("Azure OpenAI Deployment Name For '", 'aiomatic-automatic-ai-content-writer') . $model . "':";?></b>   
           </div>
       </th>
       <td>
           <div>
               <input type="text" class="cr_width_full" autocomplete="off" id="azure_model_deployments_<?php echo esc_attr($model); ?>" name="aiomatic_Main_Settings[azure_model_deployments][<?php echo esc_attr($model); ?>]" placeholder="<?php echo esc_html__("Azure deployment name for ", 'aiomatic-automatic-ai-content-writer') . $model;?>" value="<?php echo esc_attr( isset($azure_model_deployments[$model]) ? $azure_model_deployments[$model] : '' );?>">
           </div>
       </td>
   </tr>
   <?php
}
?>
            <tr class="openhide">
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo esc_html__("For users who belong to multiple organizations, you can pass a header to specify which organization is used for an API request. Usage from these API requests will count as usage for the specified organization. This field is optional.", 'aiomatic-automatic-ai-content-writer');
                                   ?>
                             </div>
                          </div>
                          <b><?php echo esc_html__("OpenAI Organization ID (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="text" autocomplete="off" id="openai_organization" placeholder="<?php echo esc_html__("OpenAI Organization ID (optional)", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full" name="aiomatic_Main_Settings[openai_organization]" value="<?php
                             echo esc_html($openai_organization);
                             ?>"/>
                       </div>
                    </td>
                 </tr>
<?php
if(!function_exists('is_plugin_active'))
{
      include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
?>  
<tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Additional AI API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
<tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your Anthropic Claude API key in this settings field, will make the Anthropic Claude models to appear in all model selector boxes from the plugin. To make it work, insert your Anthropic Claude API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://console.anthropic.com/account/keys' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksClaude"><a href='https://console.anthropic.com/account/keys' target='_blank'>Anthropic Claude</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="app_id_claude" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_claude]" placeholder="<?php echo esc_html__("Please insert your Anthropic Claude API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_claude);
                     ?></textarea>
               </div>
            </td>
            </tr>
<tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your Google AI Studio API key in this settings field, will make the Google AI Studio AI models to appear in all model selector boxes from the plugin. To make it work, insert your Google AI Studio AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://aistudio.google.com/app/apikey' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksGoogle"><a href='https://aistudio.google.com/app/apikey' target='_blank'>Google AI Studio AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="app_id_google" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_google]" placeholder="<?php echo esc_html__("Please insert your Google AI Studio AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_google);
                     ?></textarea>
               </div>
            </td>
            </tr>
<tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your Perplexity key in this settings field, will make the Perplexity AI models to appear in all model selector boxes from the plugin. To make it work, insert your Perplexity AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.perplexity.ai/settings/api' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksPerplexity"><a href='https://www.perplexity.ai/settings/api' target='_blank'>Perplexity AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="app_id_perplexity" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_perplexity]" placeholder="<?php echo esc_html__("Please insert your Perplexity AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_perplexity);
                     ?></textarea>
               </div>
            </td>
            </tr>
<tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your OpenRouter key in this settings field, will make the OpenRouter AI models to appear in all model selector boxes from the plugin. To make it work, insert your OpenRouter AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://openrouter.ai/keys' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksOpenrouter"><a href='https://openrouter.ai/keys' target='_blank'>OpenRouter AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="app_id_openrouter" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_openrouter]" placeholder="<?php echo esc_html__("Please insert your OpenRouter AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_openrouter);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Adding your HuggingFace key in this settings field, will make the HuggingFace AI models to appear in all model selector boxes from the plugin. To make it work, insert your HuggingFace AI API Keys (one per line). Get your API key <a href='%s' target='_blank'>here</a>. After you added your API key, go to the 'Advanced AI Settings' tab and add the list of the HuggingFace models you want to use.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://huggingface.co/settings/tokens' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksHuggingFace"><a href='https://huggingface.co/settings/tokens' target='_blank'>HuggingFace AI</a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="app_id_huggingface" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[app_id_huggingface]" placeholder="<?php echo esc_html__("Please insert your HuggingFace AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($app_id_huggingface);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Add your Ollama Server URL. This can be the local installation of Ollama, from your server.  If you are running Ollama locally, the default IP address + port will be http://localhost:11434 - You can download the installation files of Ollama, <a href='%s' target='_blank'>here</a>. Check <a href='%s' target='_blank'>this tutorial video</a> for details on installing Ollama locally. Check <a href='%s' target='_blank'>this other tutorial video</a> for details on installing Ollama remotely on Digital Ocean droplets.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://ollama.com/download', 'https://youtu.be/cRn4feaz0po', 'https://youtu.be/SOOx6TSEh3k' );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red"><span id="apilinksOllama"><a href='https://ollama.com/download' target='_blank'>Ollama</a>&nbsp;<?php echo esc_html__("Server URL (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>          
<?php
if($ollama_url != '')
{
   $phchecked = get_transient('aiomatic_ollama_check');
   if($phchecked === false)
   {
      $ollama = aiomatic_testOllama();
      if($ollama === 0)
      {
         echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: Ollama not found - please install it and set it up correctly!', 'aiomatic-automatic-ai-content-writer') . '</b> <a href=\'https://ollama.com/\' target=\'_blank\'>' . esc_html__('Download and install Ollama', 'aiomatic-automatic-ai-content-writer') . '</a></span>';
      }
      elseif($ollama === 1)
      {
         echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: Ollama Test Successful', 'aiomatic-automatic-ai-content-writer') . '</b></span>';
         set_transient('aiomatic_ollama_check', '1', 2592000);
      }
   }
   else
   {
      echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: Ollama OK', 'aiomatic-automatic-ai-content-writer') . '</b></span><br/><a id="ollamaButton" href="#" onclick="aiomaticRefreshOllama();" class="button">' . esc_html__('Refresh Ollama Model List', 'aiomatic-automatic-ai-content-writer') . '</a>';   
   }
}
else
{
   delete_option('aiomatic_ollama_models');
}
?>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" id="ollama_url" class="cr_textarea_pass cr_width_full" name="aiomatic_Main_Settings[ollama_url]" placeholder="<?php echo esc_html__("Please insert your Ollama Server URL", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($ollama_url);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr>
               <td colspan="2">
                  <hr/>
               </td>
            </tr>
            <tr class="multiplehide">
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to use the same API key when creating posts, or do you want to select a new API key for each API request.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Use Multiple API Keys When Creating The Same Post:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                     <label class="aiomatic-switch"><input type="checkbox" id="multiple_key" name="aiomatic_Main_Settings[multiple_key]"<?php
                        if ($multiple_key == 'on')
                            echo ' checked ';
                        ?>><span class="aiomatic-slider round"></span></label>
               </div>
            </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Alternative AI Image Generator API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Stability.AI API Keys (one per line). For Stability.AI API, get your Stability.AI key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://beta.dreamstudio.ai/membership?tab=apiKeys' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://beta.dreamstudio.ai/membership?tab=apiKeys' target='_blank'><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="stability_app_id" name="aiomatic_Main_Settings[stability_app_id]" placeholder="<?php echo esc_html__("Please insert your Stability.AI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($stability_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr><tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your GoAPI API Keys (one per line). This is used to generate Midjourney images. Get your GoAPI key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://dashboard.goapi.ai/key' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://dashboard.goapi.ai/key' target='_blank'><?php echo esc_html__("GoAPI.AI (Midjourney)", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Keys (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="midjourney_app_id" name="aiomatic_Main_Settings[midjourney_app_id]" placeholder="<?php echo esc_html__("Please insert your GoAPI API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($midjourney_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Rate Limit Prevention Settings", 'aiomatic-automatic-ai-content-writer');?>:</h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Rate Limit Prevention Delay Between API & Scraping Requests. Set the timeout (in milliseconds) between each subsequent API & scraping call. This will allow API call throttling, so the API call quota limit is not reached for your account.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Delay Between API & Scraping Requests (ms):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="text" id="request_delay" placeholder="<?php echo esc_html__("Input request delay", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[request_delay]" value="<?php echo esc_html($request_delay);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr class="aiomatic-title-holder">
         <td colspan="2">
            <h2 class="aiomatic-inner-title"><?php echo esc_html__("Scraping Enhancements Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
            </td></tr>
            <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "If you wish to use the HeadlessBrowserAPI to render JavaScript generated content for your scraped pages, enter your API key here. Get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Use PhantomJs/Puppeteer/Tor To Parse JavaScript On Pages' in importing rule settings.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://headlessbrowserapi.com/pricing/' );
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://headlessbrowserapi.com/" target="_blank"><?php echo esc_html__("HeadlessBrowserAPI Key (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                          <?php
                           $call_count = get_option('headless_calls', false);
                           if($headlessbrowserapi_key != '' && $call_count !== false)
                           {
                              echo esc_html__("Remaining API Calls For Today: ", 'aiomatic-automatic-ai-content-writer') . '<b>' . $call_count . '</b>';
                           }
                          ?>
                          <div class="cr_float_right bws_help_box bws_help_box_right dashicons cr_align_middle"><img class="cr_align_middle" src="<?php echo plugins_url('../images/new.png', __FILE__);?>" alt="new feature"/>
                          
                                                      <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("New feature added to this plugin: it is able to use HeadlessBrowserAPI to scrape with JavaScript rendered content any website from the internet. Also, the Tor node of the API will be able to scrape .onion sites from the Dark Net!", 'aiomatic-automatic-ai-content-writer');?>
                                                      </div>
                                                   </div>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="headlessbrowserapi_key" class="cr_width_full" placeholder="<?php echo esc_html__("API key", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[headlessbrowserapi_key]" value="<?php
                             echo esc_html($headlessbrowserapi_key);
                             ?>"/>
                       </div>
                    </td>
                 </tr><tr class="aiomatic-title-holder">
         <td colspan="2">
            <h2 class="aiomatic-inner-title"><?php echo esc_html__("Embeddings API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
            </td></tr>
               <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Pinecone API Key. For Pinecone API, get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.pinecone.io/' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://www.pinecone.io/' target='_blank'><?php echo esc_html__("Pinecone.io", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Key:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="pinecone_app_id" name="aiomatic_Main_Settings[pinecone_app_id]" placeholder="<?php echo esc_html__("Please insert your Pinecone.io API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($pinecone_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
               <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Qdrant API Key. For Qdrant API, sign up for a Qdrant account <a href='%s' target='_blank'>here</a> and afterwards, get your API key from the 'Data Access Control' Tab from your Qdrant dashboard.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://qdrant.to/cloud' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://qdrant.to/cloud' target='_blank'><?php echo esc_html__("Qdrant", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Key:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="qdrant_app_id" name="aiomatic_Main_Settings[qdrant_app_id]" placeholder="<?php echo esc_html__("Please insert your Qdrant API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($qdrant_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Text-to-Speech API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your ElevenLabs API Key. For ElevenLabs API, get your API key <a href='%s' target='_blank'>here</a>. This is used for the Chatbot text to speech feature.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://beta.elevenlabs.io/speech-synthesis' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://beta.elevenlabs.io/speech-synthesis' target='_blank'><?php echo esc_html__("ElevenLabs.io", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Key:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="elevenlabs_app_id" name="aiomatic_Main_Settings[elevenlabs_app_id]" placeholder="<?php echo esc_html__("Please insert your ElevenLabs.io API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($elevenlabs_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Google Text-to-Speech API Key. For Google API, get your API key <a href='%s' target='_blank'>here</a>. This is used for the Chatbot text to speech feature.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://cloud.google.com/text-to-speech' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://cloud.google.com/text-to-speech' target='_blank'><?php echo esc_html__("Google Text-to-Speech", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Key:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="google_app_id" name="aiomatic_Main_Settings[google_app_id]" placeholder="<?php echo esc_html__("Please insert your Google Text-to-Speech API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($google_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Text-to-Video API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your D-ID API Key. For D-ID API, get your API key <a href='%s' target='_blank'>here</a>. This is used for the Chatbot text to video feature.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://studio.d-id.com/account-settings' );
                           ?>
                     </div>
                  </div>
                  <b><a href='https://studio.d-id.com/account-settings' target='_blank'><?php echo esc_html__("D-ID", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("API Key:", 'aiomatic-automatic-ai-content-writer');?></b>   
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="2" class="cr_textarea_pass cr_width_full" autocomplete="off" id="did_app_id" name="aiomatic_Main_Settings[did_app_id]" placeholder="<?php echo esc_html__("Please insert your D-ID API Key", 'aiomatic-automatic-ai-content-writer');?>"><?php
                     echo esc_textarea($did_app_id);
                     ?></textarea>
               </div>
            </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Internet Access / Related Headings API Keys:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                 <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "Only For Internet Access, Not Related Headings. If you wish to use the Google Search feature of the plugin when scraping keywords, enter a Google Search API key here. Get one <a href='%s' target='_blank'>here</a>.  Please enable the 'Custom Search API' in <a href='%s' target='_blank'>Google Cloud Console</a>. Also, to search the entire web for results, please follow <a href='%s' target='_blank'>this tutorial</a>. The search engine feature will work even without entering an API key here, but in this case, the Bing API will be used.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://console.cloud.google.com/apis/credentials', 'https://console.cloud.google.com/marketplace/browse?q=custom%20search%20api', 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-google-custom-search-engine-that-searches-the-entire-web/' );
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://console.cloud.google.com/apis/credentials" target="_blank"><?php echo esc_html__("Google SERP API Key", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="google_search_api" placeholder="<?php echo esc_html__("API Key (optional)", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[google_search_api]" class="cr_width_full" value="<?php
                             echo esc_html($google_search_api);
                             ?>"/>
                       </div>
                    </td>
                 </tr>
                 <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "Only For Internet Access, Not Related Headings. To get the Google API Search Engine ID (CX value), go to <a href='%s' target='_blank'>%s</a> 2. Select your search engine or Create one and go click on it. 3. You can find the CX id titled as \"Search engine ID\" 4. Public URL also has the cx id in the Query param as ?cx=**** here. Also, to search the entire web for results, please follow <a href='%s' target='_blank'>this tutorial</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://cse.google.com/all', 'https://cse.google.com/all', 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-google-custom-search-engine-that-searches-the-entire-web/');
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://cse.google.com/all" target="_blank"><?php echo esc_html__("Google SERP API Search Engine ID (CX Value)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="text" autocomplete="off" id="google_search_cx" placeholder="<?php echo esc_html__("API CX Value (optional)", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full" name="aiomatic_Main_Settings[google_search_cx]" value="<?php
                             echo esc_html($google_search_cx);
                             ?>"/>
                       </div>
                    </td>
                 </tr>
                 <tr><td colspan="2"><hr/></td></tr>
                  <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "Used for Related Headings & AI Internet Access. If you want to use SerpAPI to get the related headings for the created posts, you must add your API key here. By default, the plugin scrapes Bing Search for related queries. Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://serpapi.com/manage-api-key');
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://serpapi.com/manage-api-key" target="_blank"><?php echo esc_html__("SerpAPI API Key (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="serpapi_auth" placeholder="<?php echo esc_html__("SerpAPI Key (optional)", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[serpapi_auth]" value="<?php
                             echo esc_html($serpapi_auth);
                             ?>" class="cr_width_full"/>
                       </div>
                    </td>
                 </tr>
                 <tr><td colspan="2"><hr/></td></tr>
                 <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "Used for Related Headings & AI Internet Access. If you want to use ValueSERP to get the related headings for the created posts, you must add your API key here. By default, the plugin scrapes Bing Search for related queries. Get your API key <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://app.valueserp.com/playground');
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://app.valueserp.com/playground" target="_blank"><?php echo esc_html__("ValueSERP API Key (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="valueserp_auth" placeholder="<?php echo esc_html__("ValueSERP Key (optional)", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[valueserp_auth]" value="<?php
                             echo esc_html($valueserp_auth);
                             ?>" class="cr_width_full"/>
                       </div>
                    </td>
                 </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("NLP API Key:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                 <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Used for Relevant Keyword Extraction From Text. Insert your TextRazor API Key. Learn how to get one <a href='%s' target='_blank'>here</a>. This is used when extracting relevant keywords from longer texts. Adding an API key here can greatly improve royalty free image accuracy.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.textrazor.com/console' );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://www.textrazor.com/console" target="_blank"><?php echo esc_html__("TextRazor API Key List (Optional):", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="textrazor_key" name="aiomatic_Main_Settings[textrazor_key]" value="<?php
                              echo esc_html($textrazor_key);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your TextRazor API Key", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
                 <tr><td colspan="2"><hr/></td></tr>
                 <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Used for Relevant Keyword Extraction From Text. Insert your NeuronWriter API Key. Learn how to get one <a href='%s' target='_blank'>here</a>. This is used when extracting relevant keywords from longer texts.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://contadu.crisp.help/en/article/neuronwriter-api-how-to-use-2ds6hx/' );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://contadu.crisp.help/en/article/neuronwriter-api-how-to-use-2ds6hx/" target="_blank"><?php echo esc_html__("NeuronWriter API Key (Optional):", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="neuron_key" name="aiomatic_Main_Settings[neuron_key]" value="<?php
                              echo esc_html($neuron_key);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your NeuronWriter API Key", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your NeuronWriter Project ID. The ID of your project taken from project's URL: https://app.neuronwriter.com/project/view/75a454f6ae5976e8 -> e95fdd229fd98c10", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ));
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("NeuronWriter Project ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" autocomplete="off" id="neuron_project" name="aiomatic_Main_Settings[neuron_project]" value="<?php
                              echo esc_html($neuron_project);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your NeuronWriter Project ID", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Plagiarism Checker/AI Detector API Key:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                 <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your PlagiarismCheck API Key. Learn how to get one <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://plagiarismcheck.org/' );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://plagiarismcheck.org/" target="_blank"><?php echo esc_html__("PlagiarismCheck API Key List (Optional):", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="plagiarism_api" name="aiomatic_Main_Settings[plagiarism_api]" value="<?php
                              echo esc_html($plagiarism_api);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your PlagiarismCheck API Key", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Amazon API Settings (Optional):", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
<?php
if (!is_plugin_active('aiomatic-extension-amazon-api/aiomatic-extension-amazon-api.php')) 
{
   echo ('<tr><td colspan="2"><b>You need to install and enable the \'<a href="https://coderevolution.ro/product/aiomatic-extension-amazon-api/" target="_blank">Aiomatic Extension: Amazon API</a>\' plugin for this feature to work!</b></td></tr>');
}
else
{
?>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( 'Insert your Amazon Access Key ID. Learn how to get one <a href=\'%s\' target=\'_blank\'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href=\'%s\' target=\'_blank\'>here</a>. If you do not enter a value here, the plugin will use direct scraping method to get products.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( 'https://console.aws.amazon.com/iam/home?#/security_credential' ), esc_url_raw( 'https://affiliate-program.amazon.com/assoc_credentials/home' ) );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://console.aws.amazon.com/iam/home?#/security_credential" target="_blank"><?php echo esc_html__("Amazon Access Key ID (Optional):", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" id="amazon_app_id" name="aiomatic_Main_Settings[amazon_app_id]" value="<?php
                              echo esc_html($amazon_app_id);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your Amazon App ID", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( 'Insert your Amazon Secret Access Key. Learn how to get one <a href=\'%s\' target=\'_blank\'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href=\'%s\' target=\'_blank\'>here</a>. If you do not enter a value here, the plugin will use direct scraping method to get products.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( 'https://console.aws.amazon.com/iam/home?#/security_credential' ), esc_url_raw( 'https://affiliate-program.amazon.com/assoc_credentials/home' ) );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://console.aws.amazon.com/iam/home?#/security_credential" target="_blank"><?php echo esc_html__("Amazon Secret Access Key (Optional):", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="amazon_app_secret" name="aiomatic_Main_Settings[amazon_app_secret]" value="<?php
                              echo esc_html($amazon_app_secret);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your Amazon App Secret", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
<?php
}
?>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Related Video Search API Key:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Used for Related Videos. Insert your YouTube API Key. Learn how to get one <a href='%s' target='_blank'>here</a>. This is used when adding YouTube videos to your post content. You can also enter a comma separated list of multiple API keys. This is optional, the Related Videos feature will work also without an API key entered.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://console.cloud.google.com/apis/credentials' );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://console.cloud.google.com/apis/credentials" target="_blank"><?php echo esc_html__("YouTube API Key List (Optional):", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="yt_app_id" name="aiomatic_Main_Settings[yt_app_id]" value="<?php
                              echo esc_html($yt_app_id);
                              ?>" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert your YouTube API Key. You can also insert a list of comma separated API keys. The plugin will select one to user, each time when it runs, at random.", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Translation Services API Keys:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "If you wish to use the official version of the Google Translator API for translation, you must enter first a Google API Key. Get one <a href='%s' target='_blank'>here</a>. Please enable the 'Cloud Translation API' in <a href='%s' target='_blank'>Google Cloud Console</a>. Translation will work even without even without entering an API key here, but in this case, an unofficial Google Translate API will be used.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://console.cloud.google.com/apis/credentials', 'https://console.cloud.google.com/marketplace/browse?q=translate' );
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://console.cloud.google.com/apis/credentials" target="_blank"><?php echo esc_html__("Google Translator API Key (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="google_trans_auth" placeholder="<?php echo esc_html__("API Key (optional)", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[google_trans_auth]" value="<?php
                             echo esc_html($google_trans_auth);
                             ?>" class="cr_width_full"/>
                       </div>
                    </td>
                 </tr>
            <tr><td colspan="2"><hr/></td></tr>
                  <tr>
                    <th>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "If you wish to use DeepL for translation, you must enter first a DeepL 'Authentication Key'. Get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Automatically Translate Content To' and 'Source Language' fields.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://www.deepl.com/subscription.html' );
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://www.deepl.com/subscription.html" target="_blank"><?php echo esc_html__("DeepL Translator Authentication Key (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                       </div>
                    </th>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="deepl_auth" placeholder="<?php echo esc_html__("Auth key (optional)", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[deepl_auth]" value="<?php
                             echo esc_html($deepl_auth);
                             ?>" class="cr_width_full"/>
                       </div>
                    </td>
                 </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Check this checkbox if the above API key is a DeepL free plan key. If it is a PRO key, please uncheck this checkbox.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("The Above Is A DeepL Free API Key:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <label class="aiomatic-switch"><input type="checkbox" id="deppl_free" name="aiomatic_Main_Settings[deppl_free]"<?php
                        if ($deppl_free == 'on')
                            echo ' checked ';
                        ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
            <tr><td colspan="2"><hr/></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "If you wish to use Microsoft for translation, you must enter first a Microsoft 'Access Key'. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Automatically Translate Content To' and 'Source Language' fields.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/' );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/" target="_blank"><?php echo esc_html__("Microsoft Translator Access Key (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="bing_auth" placeholder="<?php echo esc_html__("Access key (optional)", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[bing_auth]" value="<?php
                              echo esc_html($bing_auth);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "If you selected a specific region in your Azure Microsoft account, you must enter it here. Learn more <a href='%s' target='_blank'>here</a>. The default is global.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/' );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-microsoft-translator-api-key-from-using-azure-control-panel/" target="_blank"><?php echo esc_html__("Microsoft Translator Region Code (Optional)", 'aiomatic-automatic-ai-content-writer');?>:</a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" id="bing_region" placeholder="<?php echo esc_html__("global", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[bing_region]" value="<?php
                              echo esc_html($bing_region);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                                   </table>     
        </div>
        <div id="tab-32<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('OmniBlocks Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("Allows you to fine-tune some of the settings offered by the most advanced part of the plugin, the 'OmniBlocks' functionality.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Advanced OmniBlocks Options:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to enable OmniBlocks webhook functionality? This will enable the Webhook OmniBlock type to automatically recieve requests from external sources, using a speicific webhook URL.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable OmniBlocks Webhook Functionality:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                     <label class="aiomatic-switch"><input type="checkbox" id="omni_webhook" name="aiomatic_Main_Settings[omni_webhook]"<?php
                        if ($omni_webhook == 'on')
                            echo ' checked ';
                        ?>><span class="aiomatic-slider round"></span></label>
               </div>
            </td>
         </tr>
        <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to enable OmniBlocks result caching for some OmniBlock types, like the Website Scraper OmniBlock or the RSS Scraper OmniBlock. If this is checked, multiple OmniBlocks in the same queue will use the same data (from caching) and will not download the same website multiple times.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable OmniBlocks Result Caching:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                     <label class="aiomatic-switch"><input type="checkbox" id="omni_caching" name="aiomatic_Main_Settings[omni_caching]"<?php
                        if ($omni_caching == 'on')
                            echo ' checked ';
                        ?>><span class="aiomatic-slider round"></span></label>
               </div>
            </td>
         </tr>
</table>     
        </div>
        <div id="tab-31<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('AI Video Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'AI Videos' tab provides settings for the tools which are used to generate and manage AI-created video content.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Stability.AI Video API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("How strongly the video sticks to the original image. Use lower values to allow the model more freedom to make changes and higher values to correct motion distortions.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Video CFG Scale:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                        <input type="number" min="0" max="10" step="0.1" id="video_cfg_scale" placeholder="<?php echo esc_html__("2.5", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[video_cfg_scale]" value="<?php
                              echo esc_html($video_cfg_scale);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Lower values generally result in less motion in the output video, while higher values generally result in more motion. This parameter corresponds to the motion_bucket_id parameter from the paper.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Video Motion Bucket ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="1" step="1" max="255" name="aiomatic_Main_Settings[motion_bucket_id]" value="<?php echo esc_html($motion_bucket_id);?>" placeholder="<?php echo esc_html__("1-255", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
</table>     
        </div>
        <div id="tab-4<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('AI Image Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'AI Images' tab provides settings for the tools which are used to generate and manage AI-created visual content, enhancing your WordPress site with automated and customizable image solutions.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Dall-E AI Image Generator Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("The style of the generated images. Must be one of vivid or natural. Vivid causes the model to lean towards generating hyper-real and dramatic images. Natural causes the model to produce more natural, less hyper-real looking images. This param is only supported for dall-e-3.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Dall-E 3 Image Style:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <select id="dalle_style" name="aiomatic_Main_Settings[dalle_style]"  class="cr_width_full">
                     <option value="vivid"<?php
                        if ($dalle_style == "vivid") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Vivid", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="natural"<?php
                        if ($dalle_style == "natural") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Natural", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Midjourney API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set what model to use when generating images. Default is fast.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="midjourney_image_model" name="aiomatic_Main_Settings[midjourney_image_model]"  class="cr_width_full">
<?php
$midjourney_image_models = ['relax', 'fast', 'turbo'];
foreach($midjourney_image_models as $sm)
{
   echo '<option value="' . esc_attr($sm) . '"';
   if ($midjourney_image_model == $sm)
   {
      echo " selected";
   }
   echo '>' . esc_html($sm) . '</option>';
}
?>
                           </select>
                        </div>
                     </td>
                  </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Stability.AI API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set what model to use when generating images. Default is ", 'aiomatic-automatic-ai-content-writer') . AIOMATIC_STABLE_DEFAULT_MODE;
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="stable_model" name="aiomatic_Main_Settings[stable_model]"  class="cr_width_full">
<?php
$stable_models = aiomatic_get_stable_image_models();
foreach($stable_models as $sm)
{
   echo '<option value="' . esc_attr($sm) . '"';
   if ($stable_model == $sm)
   {
      echo " selected";
   }
   echo '>' . esc_html($sm) . '</option>';
}
?>
                           </select>
                        </div>
                     </td>
                  </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Number of diffusion steps to run. Default is 50.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Sampling Steps:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="10" step="1" max="250" name="aiomatic_Main_Settings[steps]" value="<?php echo esc_html($steps);?>" placeholder="<?php echo esc_html__("10-250", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("How strictly the diffusion process adheres to the prompt text (higher values keep your image closer to your prompt). Default value is 7.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("CFG Scale:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="0" step="1" max="35" name="aiomatic_Main_Settings[cfg_scale]" value="<?php echo esc_html($cfg_scale);?>" placeholder="<?php echo esc_html__("0-35", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Random noise seed (omit this option or use 0 for a random seed)", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Seed:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="0" step="1" max="4294967295" name="aiomatic_Main_Settings[cfg_seed]" value="<?php echo esc_html($cfg_seed);?>" placeholder="<?php echo esc_html__("0", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set what preset to use when generating images. Default is NONE.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Clip Guidance Preset:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="clip_guidance_preset" name="aiomatic_Main_Settings[clip_guidance_preset]"  class="cr_width_full">
                              <option value="NONE"<?php
                                 if ($clip_guidance_preset == "NONE") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("NONE", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="FAST_BLUE"<?php
                                 if ($clip_guidance_preset == "FAST_BLUE") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("FAST_BLUE", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="FAST_GREEN"<?php
                                 if ($clip_guidance_preset == "FAST_GREEN") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("FAST_GREEN", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="SIMPLE"<?php
                                 if ($clip_guidance_preset == "SIMPLE") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("SIMPLE", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="SLOW"<?php
                                 if ($clip_guidance_preset == "SLOW") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("SLOW", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="SLOWER"<?php
                                 if ($clip_guidance_preset == "SLOWER") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("SLOWER", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="SLOWEST"<?php
                                    if ($clip_guidance_preset == "SLOWEST") {
                                        echo " selected";
                                    }
                                    ?>><?php echo esc_html__("SLOWEST", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Pass in a style preset to guide the image model towards a particular style. Default is NONE.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Style Preset:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="clip_style_preset" name="aiomatic_Main_Settings[clip_style_preset]"  class="cr_width_full">
                              <option value="NONE"<?php
                                 if ($clip_style_preset == "NONE") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("NONE", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="3d-model"<?php
                                 if ($clip_style_preset == "3d-model") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("3d-model", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="analog-film"<?php
                                 if ($clip_style_preset == "analog-film") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("analog-film", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="anime"<?php
                                 if ($clip_style_preset == "anime") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("anime", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="cinematic"<?php
                                 if ($clip_style_preset == "cinematic") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("cinematic", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="comic-book"<?php
                                 if ($clip_style_preset == "comic-book") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("comic-book", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="digital-art"<?php
                                    if ($clip_style_preset == "digital-art") {
                                        echo " selected";
                                    }
                                    ?>><?php echo esc_html__("digital-art", 'aiomatic-automatic-ai-content-writer');?></option>
                                    <option value="enhance"<?php
                                 if ($clip_style_preset == "enhance") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("enhance", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="fantasy-art"<?php
                                 if ($clip_style_preset == "fantasy-art") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("fantasy-art", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="isometric"<?php
                                 if ($clip_style_preset == "isometric") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("isometric", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="line-art"<?php
                                 if ($clip_style_preset == "line-art") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("line-art", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="low-poly"<?php
                                 if ($clip_style_preset == "low-poly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("low-poly", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="modeling-compound"<?php
                                 if ($clip_style_preset == "modeling-compound") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("modeling-compound", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="neon-punk"<?php
                                 if ($clip_style_preset == "neon-punk") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("neon-punk", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="origami"<?php
                                 if ($clip_style_preset == "origami") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("origami", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="photographic"<?php
                                 if ($clip_style_preset == "photographic") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("photographic", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="pixel-art"<?php
                                 if ($clip_style_preset == "pixel-art") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("pixel-art", 'aiomatic-automatic-ai-content-writer');?></option>
                                 <option value="tile-texture"<?php
                                 if ($clip_style_preset == "tile-texture") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("tile-texture", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Which sampler to use for the diffusion process. If this value is omitted we'll automatically select an appropriate sampler for you.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Sampler:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="sampler" name="aiomatic_Main_Settings[sampler]"  class="cr_width_full">
                              <option value="auto"<?php
                                 if ($sampler == "auto") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Auto", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="DDIM"<?php
                                 if ($sampler == "DDIM") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("DDIM", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="DDPM"<?php
                                 if ($sampler == "DDPM") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("DDPM", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_DPMPP_2M"<?php
                                 if ($sampler == "K_DPMPP_2M") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("K_DPMPP_2M", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_DPMPP_2S_ANCESTRAL"<?php
                                 if ($sampler == "K_DPMPP_2S_ANCESTRAL") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("K_DPMPP_2S_ANCESTRAL", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_DPM_2"<?php
                                 if ($sampler == "K_DPM_2") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("K_DPM_2", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_DPM_2_ANCESTRAL"<?php
                              if ($sampler == "K_DPM_2_ANCESTRAL") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("K_DPM_2_ANCESTRAL", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_EULER"<?php
                              if ($sampler == "K_EULER") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("K_EULER", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_EULER_ANCESTRAL"<?php
                              if ($sampler == "K_EULER_ANCESTRAL") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("K_EULER_ANCESTRAL", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_HEUN"<?php
                              if ($sampler == "K_HEUN") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("K_HEUN", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="K_LMS"<?php
                              if ($sampler == "K_LMS") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("K_LMS", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("General AI Image Generator Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("By default, the plugin will attempt to translate AI image prompts to English. If you are publishing only English content on your site, you can disable this feature to speed up image processing.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Don't Attempt To Translate AI Image Prompts To English:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_img_translate" name="aiomatic_Main_Settings[no_img_translate]"<?php
                     if ($no_img_translate == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
               </td>
            </tr>
            <?php if ($copy_locally == "disabled"){ echo '<tr><td colspan="2">' . esc_html__("To use the Image Resizing feature, you need to enable the 'Copy Royalty Free / AI Images From Post Content' feature from the 'Cloud Storage' tab!", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
            }
            if (!function_exists('finfo_open')){ echo '<tr><td colspan="2"><b>finfo_open</b> - ' . esc_html__("This function is not enabled on your server. Please enable it to use the image resizing feature of the plugin!", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
            }?>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Resize the AI generated image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank. This feature will work only if you copy AI generated images from their original sources, locally to your own server.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Generated Image Resize Width:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="1" step="1"<?php if (!function_exists('finfo_open') || $copy_locally == "disabled"){ echo ' disabled title="To use this feature, you need to enable the \'Copy Royalty Free / AI Images From Post Content\' feature from the \'Cloud Storage\' tab!"';}?> name="aiomatic_Main_Settings[ai_resize_width]" value="<?php echo esc_html($ai_resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desired width for AI generated images", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Resize the AI generated image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank. This feature will work only if you copy AI generated images from their original sources.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Generated Image Resize Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="1" step="1"<?php if (!function_exists('finfo_open') || $copy_locally == "disabled"){ echo ' disabled title="To use this feature, you need to enable the \'Copy Royalty Free / AI Images From Post Content\' feature from the \'Cloud Storage\' tab!"';}?> name="aiomatic_Main_Settings[ai_resize_height]" value="<?php echo esc_html($ai_resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desired height for AI generated images", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the quality of the resized images. Accepted values: 1-100. 1 is lowest quality, 100 is highest quality. If you want to disable this feature, leave this field blank. This feature will work only if you copy AI generated images from their original sources.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Generated Image Resize Quality:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="1" step="1"<?php if (!function_exists('finfo_open') || $copy_locally == "disabled"){ echo ' disabled title="To use this feature, you need to enable the \'Copy Royalty Free / AI Images From Post Content\' feature from the \'Cloud Storage\' tab!"';}?> max="100" name="aiomatic_Main_Settings[ai_resize_quality]" value="<?php echo esc_html($ai_resize_quality);?>" placeholder="<?php echo esc_html__("Resize quality", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                  </div>
               </td>
            </tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Stable Diffusion Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
         <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/SX2vGtKNAz4" frameborder="0" allowfullscreen></iframe>
   </td></tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Midjourney Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
         <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/8H45UHQ62mk" frameborder="0" allowfullscreen></iframe>
   </td></tr>
</table>     
        </div>
        <div id="tab-5<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('Statistics Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'Statistics' tab provides settings for the 'Limits & Statistics' module of the plugin.", 'aiomatic-automatic-ai-content-writer');
?></p>
<h2><?php echo esc_html__("Check the Statistics page ", 'aiomatic-automatic-ai-content-writer');?><a href="<?php echo admin_url('admin.php?page=aiomatic_openai_status');?>"><?php echo esc_html__("here", 'aiomatic-automatic-ai-content-writer');?>.</a></h2>
        <table class="widefat">
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Limits & Statistics Options:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable usage tracking for statistics and usage limits?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Usage Tracking For Statistics And Usage Limits:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="enable_tracking" name="aiomatic_Main_Settings[enable_tracking]"<?php
                     if ($enable_tracking == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr></table>     
        </div>
        <div id="tab-16<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Content Wizard', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Content Wizard' tab provides guided options for tools and templates to easily create, format, and optimize engaging content for your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Content Wizard General Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to enable or disable the AI assistant feature of the plugin?", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Enable Content Wizard On:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                  <select id="assistant_disable" name="aiomatic_Main_Settings[assistant_disable]" class="cr_width_full">
                     <option value="back"<?php
                              if ($assistant_disable == "back") {
                                    echo " selected";
                              }
                              ?>>Backend</option>
                     <option value="front"<?php
                              if ($assistant_disable == "front") {
                                    echo " selected";
                              }
                              ?>>Frontend</option>
                     <option value="both"<?php
                              if ($assistant_disable == "both") {
                                    echo " selected";
                              }
                              ?>>Backend & Frontend</option>
                     <option value="on"<?php
                              if ($assistant_disable == "on") {
                                    echo " selected";
                              }
                              ?>>Disabled</option>
                  </select>  
                  </div>
               </td>
            </tr>
        <tr>
                  <th>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set if you want to enable Content Wizard also for not logged in users.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Enable Content Wizard Also For Not Logged In Users:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <select id="assistant_not_logged" name="aiomatic_Main_Settings[assistant_not_logged]" class="cr_width_full">
                     <option value="disable"<?php
                              if ($assistant_not_logged == "disable") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="enable"<?php
                              if ($assistant_not_logged == "enable") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("Enabled", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>  
                  </td>
               </tr>
        <tr>
                  <th>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set where you would like to add the AI assistant result - above or below the selected text.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Result Placement:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <select id="assistant_placement" name="aiomatic_Main_Settings[assistant_placement]" class="cr_width_full">
                     <option value="below"<?php
                              if ($assistant_placement == "below") {
                                    echo " selected";
                              }
                              ?>>Below selected text</option>
                     <option value="above"<?php
                              if ($assistant_placement == "above") {
                                    echo " selected";
                              }
                              ?>>Above selected text</option>
                  </select>  
                  </td>
               </tr>
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Content Wizard Image Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
                  <th>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the image size of the AI assistant generated images.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <select id="assistant_image_size" name="aiomatic_Main_Settings[assistant_image_size]" class="cr_width_full">
                     <option value="256x256"<?php
                              if ($assistant_image_size == "256x256") {
                                    echo " selected";
                              }
                              ?>>256x256 (only for Dall-E 2)</option>
                     <option value="512x512"<?php
                              if ($assistant_image_size == "512x512") {
                                    echo " selected";
                              }
                              ?>>512x512 (only for Dall-E 2 & Stable Diffusion)</option>
                     <option value="1024x1024"<?php
                              if ($assistant_image_size == "1024x1024") {
                                    echo " selected";
                              }
                              ?>>1024x1024</option>
                     <option value="1792x1024"<?php
                              if ($assistant_image_size == "1792x1024") {
                                    echo " selected";
                              }
                              ?>>1792x1024 (only for Dall-E 3)</option>
                     <option value="1024x1792"<?php
                              if ($assistant_image_size == "1024x1792") {
                                    echo " selected";
                              }
                              ?>>1024x1792 (only for Dall-E 3)</option>
                  </select>  
                  </td>
               </tr><tr>
                  <th>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the image model of the AI assistant generated images.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <select id="assistant_image_model" name="aiomatic_Main_Settings[assistant_image_model]" class="cr_width_full">
                     <option value="dalle2"<?php
                              if ($assistant_image_model == "dalle2") {
                                    echo " selected";
                              }
                              ?>>Dall-E 2</option>
                     <option value="dalle3"<?php
                              if ($assistant_image_model == "dalle3") {
                                    echo " selected";
                              }
                              ?>>Dall-E 3</option>
                     <option value="dalle3hd"<?php
                              if ($assistant_image_model == "dalle3hd") {
                                    echo " selected";
                              }
                              ?>>Dall-E 3 HD</option>
                     
                     <?php
                     if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                     {
                     ?>
                     <option value="stability"<?php if ($assistant_image_model == "stability") {
                                    echo " selected";
                              }?> ><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                     <?php
                     }
                     if (isset($aiomatic_Main_Settings['midjourney_app_id']) && trim($aiomatic_Main_Settings['midjourney_app_id']) != '')
                     {
                     ?>
                     <option value="midjourney"<?php if ($assistant_image_model == "midjourney") {
                                    echo " selected";
                              }?> ><?php echo esc_html__("Midjourney", 'aiomatic-automatic-ai-content-writer');?></option>
                     <?php
                     }
                     ?>
                  </select>  
                  </td>
               </tr>
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Content Wizard Text Completion Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="wizard_assistant_id" name="aiomatic_Main_Settings[wizard_assistant_id]" class="cr_width_full" onchange="assistantSelected('wizard_assistant_id', 'disableWizard');">
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
        if($wizard_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($wizard_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
               <tr>
                  <th>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the model to use for the Content Wizard feature.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <select id="assistant_model" name="aiomatic_Main_Settings[assistant_model]" <?php if($wizard_assistant_id != ''){echo ' disabled';}?> class="disableWizard cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($assistant_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </td>
               </tr>
               <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="0" step="0.1" max="2" name="aiomatic_Main_Settings[assistant_temperature]" value="<?php echo esc_html($assistant_temperature);?>" placeholder="1" class="cr_width_full">
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="0" max="1" step="0.1" name="aiomatic_Main_Settings[assistant_top_p]" value="<?php echo esc_html($assistant_top_p);?>" placeholder="1" class="cr_width_full">
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="-2" step="0.1" max="2" name="aiomatic_Main_Settings[assistant_ppenalty]" value="<?php echo esc_html($assistant_ppenalty);?>" placeholder="0" class="cr_width_full">
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Content Wizard Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="0" max="2" step="0.1" name="aiomatic_Main_Settings[assistant_fpenalty]" value="<?php echo esc_html($assistant_fpenalty);?>" placeholder="0" class="cr_width_full">
                  </td>
               </tr></table> 
               <br/>
        <table class="widefat">
         <tr class="aiomatic-title-holder">
            <td>
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("Content Wizard Prompts:", 'aiomatic-automatic-ai-content-writer');?></h2>
               <hr/>
               <div class="table-responsive">
               <div id="grid-wizard-aiomatic">
                     <div class="grid-wizard-heading-aiomatic aiomatic-middle">
                        <?php echo esc_html__("Menu name", 'aiomatic-automatic-ai-content-writer');?>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the name of the command, which will appear in the post editor.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                     </div>
                     <div class="grid-wizard-heading-aiomatic aiomatic-middle">
                        <?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be sent to the AI when clicking on this command in post editor. You can use the %%selected_text%% shortcode and also the following shortcodes, which will use the data from the current post which is edited: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                     </div>
                     <div class="grid-wizard-heading-aiomatic aiomatic-middle">
                        <?php echo esc_html__("Type", 'aiomatic-automatic-ai-content-writer');?>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the type of the prompt you are creating.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                     </div>
                     <div class="grid-wizard-heading-aiomatic aiomatic-middle">
                        <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to delete this rule?", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                     </div>
                  <?php
                     echo aiomatic_expand_assistant_rules();
                     ?>
                        <div>
                           <hr/>
                        </div>
                        <div>
                           <hr/>
                        </div>
                        <div>
                           <hr/>
                        </div>
                        <div>
                           <hr/>
                        </div>
                     <div  class="cr_center"><input type="text" name="aiomatic_assistant_list[menu_name][]"  placeholder="<?php echo esc_html__("Add a menu name", 'aiomatic-automatic-ai-content-writer');?>" value=""/></div>
                     <div  class="cr_center"><textarea rows="1" name="aiomatic_assistant_list[prompt][]"  placeholder="<?php echo esc_html__("Add a prompt", 'aiomatic-automatic-ai-content-writer');?>" value=""></textarea></div>
                     <div  class="cr_center"><select id="aiomatic_assistant_type" name="aiomatic_assistant_list[type][]">
<option value="text" selected><?php echo esc_html__("Text", 'aiomatic-automatic-ai-content-writer');?></option>
<option value="image"><?php echo esc_html__("Image", 'aiomatic-automatic-ai-content-writer');?></option></select></div>
                     <div  class="cr_center"><span class="cr_gray20">X</span></div>
                  </div>
               </div>
                  <hr/>
               <p class="crsubmit"><input type="submit" name="btnSubmitwiz" id="btnSubmitwiz" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Content Wizard Prompts", 'aiomatic-automatic-ai-content-writer');?>"/></p>
            </td></tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr><td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/e5tPgqOB8ss" frameborder="0" allowfullscreen></iframe>
   </td></tr></table>   
        </div>
        <div id="tab-18<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('AI Forms', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'AI Forms' tab enables you to create and manage smart forms powered by AI, designed to improve user interaction and data collection on your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Forms Restrictions:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the min length for form input fields.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Input Fields Min Length:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="number" min="1" step="1" name="aiomatic_Main_Settings[min_len]" value="<?php echo esc_html($min_len);?>" placeholder="3" class="cr_width_full">
            </td>
         </tr>
        <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the max length for form input fields.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Input Fields Max Length:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="number" min="1" step="1" name="aiomatic_Main_Settings[max_len]" value="<?php echo esc_html($max_len);?>" placeholder="10" class="cr_width_full">
            </td>
         </tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Forms Image Options:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the image size for AI generated images.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("AI Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <select autocomplete="off" id="ai_image_size" name="aiomatic_Main_Settings[ai_image_size]" class="cr_width_full">
               <option value="256x256" <?php if($ai_image_size == '256x256'){echo ' selected';}?> ><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="512x512" <?php if($ai_image_size == '512x512'){echo ' selected';}?> ><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="1024x1024" <?php if($ai_image_size == '1024x1024'){echo ' selected';}?> ><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="1024x1792" <?php if($ai_image_size == '1024x1792'){echo ' selected';}?> ><?php echo esc_html__("1024x1792 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="1792x1024" <?php if($ai_image_size == '1792x1024'){echo ' selected';}?> ><?php echo esc_html__("1792x1024 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer');?></option>
            </select>
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the image model for AI generated images.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <select autocomplete="off" id="ai_image_model" name="aiomatic_Main_Settings[ai_image_model]" class="cr_width_full">
               <option value="dalle2" <?php if($ai_image_model == 'dalle2'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="dalle3" <?php if($ai_image_model == 'dalle3'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="dalle3hd" <?php if($ai_image_model == 'dalle3hd'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
            </select>
            </td>
         </tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Forms Options:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to show advanced form options for users.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Show Advanced Form Options For All Textual AI Forms (Global):", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <label class="aiomatic-switch"><input type="checkbox" id="show_advanced" name="aiomatic_Main_Settings[show_advanced]"<?php
                  if ($show_advanced == 'on')
                      echo ' checked ';
                  ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to show a WP Rich Text editor instead of a plain textarea for the AI results output, for all created textual AI Forms.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Show WP Editor Input For All Textual AI Forms (Global):", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <label class="aiomatic-switch"><input type="checkbox" id="show_rich_editor" name="aiomatic_Main_Settings[show_rich_editor]"<?php
                  if ($show_rich_editor == 'on')
                      echo ' checked ';
                  ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to show a 'Character Counter' text under to the results of textual AI Forms.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable the 'Character Counter' Text For All Textual Forms Results (Global):", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <label class="aiomatic-switch"><input type="checkbox" id="enable_char_count" name="aiomatic_Main_Settings[enable_char_count]"<?php
                  if ($enable_char_count == 'on')
                      echo ' checked ';
                  ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to show a 'Copy' button next to the results of textual AI Forms.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable the 'Copy' Button For All Textual Forms Results (Global):", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <label class="aiomatic-switch"><input type="checkbox" id="enable_copy" name="aiomatic_Main_Settings[enable_copy]"<?php
                  if ($enable_copy == 'on')
                      echo ' checked ';
                  ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to show a 'Download' button next to the results of image AI Forms.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable the 'Download' Button For All Image Forms Results (Global):", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <label class="aiomatic-switch"><input type="checkbox" id="enable_download" name="aiomatic_Main_Settings[enable_download]"<?php
                  if ($enable_download == 'on')
                      echo ' checked ';
                  ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the location of the submit button.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Submit Button Location:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <select id="submit_location" name="aiomatic_Main_Settings[submit_location]" class="cr_width_full">
                  <option value="1"<?php
                           if ($submit_location == "1") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Under Input Fields", 'aiomatic-automatic-ai-content-writer');?></option>
                  <option value="2"<?php
                           if ($submit_location == "2") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Above Input Fields", 'aiomatic-automatic-ai-content-writer');?></option>
                  <option value="3"<?php
                           if ($submit_location == "3") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Under Result Field", 'aiomatic-automatic-ai-content-writer');?></option>
                  <option value="4"<?php
                           if ($submit_location == "4") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Under Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></option>
               </select> 
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the alignment of the submit button.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Submit Button Alignment:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <select id="submit_align" name="aiomatic_Main_Settings[submit_align]" class="cr_width_full">
                  <option value="1"<?php
                           if ($submit_align == "1") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Left", 'aiomatic-automatic-ai-content-writer');?></option>
                  <option value="2"<?php
                           if ($submit_align == "2") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Center", 'aiomatic-automatic-ai-content-writer');?></option>
                  <option value="3"<?php
                           if ($submit_align == "3") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Right", 'aiomatic-automatic-ai-content-writer');?></option>
               </select> 
            </td>
         </tr>
        <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the placeholder text of the form output.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Output Placeholder Text:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="text" name="aiomatic_Main_Settings[form_placeholder]" value="<?php echo esc_html($form_placeholder);?>" placeholder="AI Result" class="cr_width_full">
            </td>
         </tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Forms Styling:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the Background color of the form.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="color" name="aiomatic_Main_Settings[back_color]" value="<?php echo esc_html($back_color);?>">
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the text color of the form.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Text Color:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="color" name="aiomatic_Main_Settings[text_color]" value="<?php echo esc_html($text_color);?>">
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the button color of the form.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Button Color:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="color" name="aiomatic_Main_Settings[but_color]" value="<?php echo esc_html($but_color);?>">
            </td>
         </tr>
         <tr>
            <th class="cr_min_width_200">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the button text color of the form.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Form Button Text Color:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="color" name="aiomatic_Main_Settings[btext_color]" value="<?php echo esc_html($btext_color);?>">
            </td>
         </tr>
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr><td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/NhbEeIXxu-0" frameborder="0" allowfullscreen></iframe>
   </td></tr>
        </table>
            </div>
        <div id="tab-23<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Link Keyword Extractor', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Link Keyword Extractor' tab provides settings for tools that analyze and extract relevant keywords from hyperlinks, enhancing your WordPress site's SEO and content relevance strategies.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Automatic Links Keyword Extractor Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the method you want to use for automatic article keyword extraction.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatic Linking Keyword Extraction Method:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <select id="kw_method" name="aiomatic_Main_Settings[kw_method]" onchange="kwChanged();" class="cr_width_full">
                  <option value="builtin"<?php
                           if ($kw_method == "builtin") {
                                 echo " selected";
                           }
                           ?>>Built-In</option>
                  <option value="ai"<?php
                           if ($kw_method == "ai") {
                                 echo " selected";
                           }
                           ?>>AI</option>
               </select> 
            </td>
         </tr>
         <tr class="kwai">
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="kw_assistant_id" name="aiomatic_Main_Settings[kw_assistant_id]" class="cr_width_full" onchange="assistantSelected('kw_assistant_id', 'disableKw');">
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
        if($kw_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($kw_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
         <tr class="kwai">
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the default model you want to use for the AI Linking Keyword Extraction.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Linking Keyword Extraction Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="kw_model" name="aiomatic_Main_Settings[kw_model]" <?php if($kw_assistant_id != ''){echo ' disabled';}?> class="disableKw cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($kw_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr class="kwai">
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI Linking Keyword Extraction feature. You can use the following shortcodes here: %%content%% - the default value for this field is: Extract a comma-separated list of the most relevant single word keywords from the text, prioritizing specific references over general keywords. Add the highest priority to the most specific keyword that is still related to the main topic. The text is: %%content%%.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Linking Keyword Extraction Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[kw_prompt]" placeholder="AI Linking Keyword Extraction Prompt" class="cr_width_full"><?php echo esc_textarea($kw_prompt);?></textarea>
                  </td>
               </tr>
        <tr class="kwbuiltin">
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the language of the automatic keyword extractor, which is used for the internal/external linking feature of the plugin.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Built-in Keyword Extractor Language:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <select id="kw_lang" name="aiomatic_Main_Settings[kw_lang]" class="cr_width_full">
                  <option value="en_US"<?php
                           if ($kw_lang == "en_US") {
                                 echo " selected";
                           }
                           ?>>en_US</option>
                  <option value="af_ZA"<?php
                           if ($kw_lang == "af_ZA") {
                                 echo " selected";
                           }
                           ?>>af_ZA</option>
                  <option value="ar_AE"<?php
                           if ($kw_lang == "ar_AE") {
                                 echo " selected";
                           }
                           ?>>ar_AE</option>
                  <option value="pt_BR"<?php
                           if ($kw_lang == "pt_BR") {
                                 echo " selected";
                           }
                           ?>>pt_BR</option>
                  <option value="pt_PT"<?php
                           if ($kw_lang == "pt_PT") {
                                 echo " selected";
                           }
                           ?>>pt_PT</option>
                  <option value="fr_FR"<?php
                           if ($kw_lang == "fr_FR") {
                                 echo " selected";
                           }
                           ?>>fr_FR</option>
                  <option value="de_DE"<?php
                           if ($kw_lang == "de_DE") {
                                 echo " selected";
                           }
                           ?>>de_DE</option>
                  <option value="it_IT"<?php
                           if ($kw_lang == "it_IT") {
                                 echo " selected";
                           }
                           ?>>it_IT</option>
                  <option value="pl_PL"<?php
                           if ($kw_lang == "pl_PL") {
                                 echo " selected";
                           }
                           ?>>pl_PL</option>
                  <option value="ru_RU"<?php
                           if ($kw_lang == "ru_RU") {
                                 echo " selected";
                           }
                           ?>>ru_RU</option>
                  <option value="ckb_IQ"<?php
                           if ($kw_lang == "ckb_IQ") {
                                 echo " selected";
                           }
                           ?>>ckb_IQ</option>
                  <option value="es_AR"<?php
                           if ($kw_lang == "es_AR") {
                                 echo " selected";
                           }
                           ?>>es_AR</option>
                  <option value="ta_TA"<?php
                           if ($kw_lang == "ta_TA") {
                                 echo " selected";
                           }
                           ?>>ta_TA</option>
                  <option value="tr_TR"<?php
                           if ($kw_lang == "tr_TR") {
                                 echo " selected";
                           }
                           ?>>tr_TR</option>
                  <option value="fa_IR"<?php
                           if ($kw_lang == "fa_IR") {
                                 echo " selected";
                           }
                           ?>>fa_IR</option>
                  <option value="nl_NL"<?php
                           if ($kw_lang == "nl_NL") {
                                 echo " selected";
                           }
                           ?>>nl_NL</option>
                  <option value="zh_TW"<?php
                           if ($kw_lang == "zh_TW") {
                                 echo " selected";
                           }
                           ?>>zh_TW</option>
               </select> 
            </td>
         </tr>
        <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select in which parts of the posts published on your site do you want to search for related keywords. If you leave this field blank, the default values will be post title and content.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Search Keywords For Related Posts, In:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <select multiple id="rel_search" name="aiomatic_Main_Settings[rel_search][]" class="cr_width_full">
                  <option value="post_title"<?php
                           if (in_array("post_title", $rel_search)) {
                                 echo " selected";
                           }
                           ?>>Post Title</option>
                  <option value="post_content"<?php
                           if (in_array("post_content", $rel_search)) {
                                 echo " selected";
                           }
                           ?>>Post Content</option>
                  <option value="post_excerpt"<?php
                           if (in_array("post_excerpt", $rel_search)) {
                                 echo " selected";
                           }
                           ?>>Post Excerpt</option>
               </select> 
            </td>
         </tr>
        </table>
            </div>
        <div id="tab-24<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('YouTube Embeds', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'YouTube Embeds Settings' tab allows you to customize and manage the integration of YouTube videos on your WordPress site, providing options for embedding styles and playback controls.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Embedded YouTube Player Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the maximum width of the player in pixels. Default value is 580.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Player Max Width (Pixels):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <input type="number" id="player_width" step="1" min="0" placeholder="<?php echo esc_html__("580", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[player_width]" value="<?php
                     echo esc_html($player_width);
                     ?>" class="cr_width_full"/>  
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the maximum height of the player in pixels. Default value is 380.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Player Max Height (Pixels):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <input type="number" id="player_height" step="1" min="0" placeholder="<?php echo esc_html__("380", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[player_height]" value="<?php
                     echo esc_html($player_height);
                     ?>" class="cr_width_full"/>  
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Check this to enable the AI writer to improve the YouTube video keywords.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Improve YouTube Video Search Keywords Using AI:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="improve_yt_kw" onchange="ytKwChanged();" name="aiomatic_Main_Settings[improve_yt_kw]"<?php
                     if ($improve_yt_kw == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr class="hideytkw">
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="yt_assistant_id" name="aiomatic_Main_Settings[yt_assistant_id]" class="cr_width_full" onchange="assistantSelected('yt_assistant_id', 'disableYt');">
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
        if($yt_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($yt_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
         <tr class="hideytkw">
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the default model you want to use for the YouTube Video search keyword extractor prompt.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("YouTube Video Search Keyword Extractor Model:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <select id="yt_kw_model" name="aiomatic_Main_Settings[yt_kw_model]" <?php if($yt_assistant_id != ''){echo ' disabled';}?> class="disableYt cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($yt_kw_model == $modelx) 
{
echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                  </select>  
               </div>
            </td>
         </tr>
         <tr class="hideytkw">
               <th class="cr_min_width_200">
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Set the prompt to be used for the YouTube Video search keyword extractor. You can use the following shortcode: %%aiomatic_query%% - The default value for this settings field is: Using which keyword or search phrase should I search YouTube, to get the most relevant videos for this text? Provide a single variant, write only a single keyword or phrase, nothing else. The text is: \"%%aiomatic_query%%\"", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("YouTube Video Search Keyword Extractor Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <textarea name="aiomatic_Main_Settings[yt_kw_prompt]" placeholder="YouTube Video Search Keyword Extractor Prompt" class="cr_width_full"><?php echo esc_textarea($yt_kw_prompt);?></textarea>
               </td>
            </tr>
        </table>
            </div>
        <div id="tab-25<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('WP-CLI', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'WP-CLI Settings' tab offers configuration options for the WP-CLI, allowing you to customize command-line interactions and automate AI generated content tasks within your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("WP-CLI Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to enable Aiomatic's WP-CLI Integration?", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Enable Aiomatic WP-CLI Integration:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="enable_wpcli" name="aiomatic_Main_Settings[enable_wpcli]"<?php
                     if ($enable_wpcli == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Aiomatic WP-CLI Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr><td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/V3AZxQM9irg" frameborder="0" allowfullscreen></iframe>
   </td></tr>
        </table>
            </div>
        <div id="tab-33<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('REST API', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'REST API Settings' tab offers configuration options for the REST API which can be provided by Aiomatic.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("REST API Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to enable Aiomatic's REST API Feature?", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Enable Aiomatic REST API Feature:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="rest_api_init" name="aiomatic_Main_Settings[rest_api_init]"<?php
                     if ($rest_api_init == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
        <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set a list of private API keys (one per line), which will be used to allow access to the API provided by the plugin. If you leave this field blank, the API will be able to be called without an API key. If you set API keys here, they need to be added in the API request in this format: ?apikey=YOURKEY", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Whitelistest API Key List:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[rest_api_keys]" placeholder="API Key List" class="cr_width_full"><?php echo esc_textarea($rest_api_keys);?></textarea>
                  </td>
               </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Aiomatic REST API Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr><td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/XobHHz5bLos" frameborder="0" allowfullscreen></iframe>
   </td></tr>
   <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Aiomatic REST API Documentation:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
   <tr><td colspan="2">
    <p><?php echo esc_html__("This documentation provides details about the Aiomatic REST API endpoints and how to use them.", 'aiomatic-automatic-ai-content-writer');?></p>

    <div class="endpoint">
        <h2><?php echo esc_html__("Generate Image Endpoint", 'aiomatic-automatic-ai-content-writer');?></h2>
        <p><code><?php echo get_rest_url();?>aiomatic/v1/image</code></p>

        <h4><?php echo esc_html__("Methods", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><?php echo esc_html__("Supported methods:", 'aiomatic-automatic-ai-content-writer');?> <code>GET</code>, <code>POST</code></p>

        <h4><?php echo esc_html__("Parameters", 'aiomatic-automatic-ai-content-writer');?></h4>
        <ul>
            <li><strong><?php echo esc_html__("apikey", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required if set in plugin settings): The API key for authentication.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("prompt", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required): The prompt text for image generation.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("model", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(optional): The model to be used for image generation. Supported models are: dalle2, dalle3, dalle3hd", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("assistant", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(optional): An alternative to the model parameter. Enter the assistant ID returned by the Assistants Listing endpoint.", 'aiomatic-automatic-ai-content-writer');?></li>
        </ul>

        <h4><?php echo esc_html__("Example Request", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>GET <?php echo get_rest_url();?>aiomatic/v1/image?apikey=YOUR_API_KEY&prompt=Generate+an+image+of+a+sunset</code></pre>
        <pre><code>POST <?php echo get_rest_url();?>aiomatic/v1/image
Content-Type: application/json

{
    "apikey": "YOUR_API_KEY",
    "prompt": "Generate an image of a sunset",
    "model": "dalle3"
}</code></pre>

        <h4><?php echo esc_html__("Example Response", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": true,
    "image_url": "http://example.com/generated_image.jpg"
}</code></pre>

        <h4><?php echo esc_html__("Error Responses", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": false,
    "error": "You need to specify an API key for this request"
}</code></pre>
    </div>
    <div class="endpoint">
        <h2><?php echo esc_html__("Generate Embedding Endpoint", 'aiomatic-automatic-ai-content-writer');?></h2>
        <h4><?php echo esc_html__("Endpoint", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><code><?php echo get_rest_url();?>aiomatic/v1/embeddings</code></p>

        <h4><?php echo esc_html__("Methods", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><?php echo esc_html__("Supported methods:", 'aiomatic-automatic-ai-content-writer');?> <code>GET</code>, <code>POST</code></p>

        <h4><?php echo esc_html__("Parameters", 'aiomatic-automatic-ai-content-writer');?></h4>
        <ul>
            <li><strong><?php echo esc_html__("apikey", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required if set in plugin settings): The API key for authentication.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("prompt", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required): The prompt text for generating embeddings.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("model", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(optional): The model to be used for generating embeddings.", 'aiomatic-automatic-ai-content-writer');?></li>
        </ul>

        <h4><?php echo esc_html__("Example Request", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>GET <?php echo get_rest_url();?>aiomatic/v1/embeddings?apikey=YOUR_API_KEY&prompt=Generate+an+embedding+for+this+text&model=text-embedding-3-small</code></pre>
        <pre><code>POST <?php echo get_rest_url();?>aiomatic/v1/embeddings
Content-Type: application/json

{
    "apikey": "YOUR_API_KEY",
    "prompt": "Generate an embedding for this text",
    "model": "text-embedding-3-small"
}</code></pre>

        <h4><?php echo esc_html__("Example Response", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": true,
    "embedding": [...]
}</code></pre>

        <h4><?php echo esc_html__("Error Responses", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": false,
    "error": "You need to specify an API key for this request"
}</code></pre>
    </div>
    <div class="endpoint">
        <h2><?php echo esc_html__("Generate Text Endpoint", 'aiomatic-automatic-ai-content-writer');?></h2>
        <h4><?php echo esc_html__("Endpoint", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><code><?php echo get_rest_url();?>aiomatic/v1/text</code></p>

        <h4><?php echo esc_html__("Methods", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><?php echo esc_html__("Supported methods:", 'aiomatic-automatic-ai-content-writer');?> <code>GET</code>, <code>POST</code></p>

        <h4><?php echo esc_html__("Parameters", 'aiomatic-automatic-ai-content-writer');?></h4>
        <ul>
            <li><strong><?php echo esc_html__("apikey", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required if set in plugin settings): The API key for authentication.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("prompt", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required): The prompt text for generating AI content.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("model", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(optional): The model to be used for generating text.", 'aiomatic-automatic-ai-content-writer');?></li>
            <li><strong><?php echo esc_html__("assistant", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(optional): An alternative to the model parameter.", 'aiomatic-automatic-ai-content-writer');?></li>
        </ul>

        <h4><?php echo esc_html__("Example Request", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>GET <?php echo get_rest_url();?>aiomatic/v1/text?apikey=YOUR_API_KEY&prompt=Generate+text+based+on+this+prompt&model=gpt-3.5-turbo</code></pre>
        <pre><code>POST <?php echo get_rest_url();?>aiomatic/v1/text
Content-Type: application/json

{
    "apikey": "YOUR_API_KEY",
    "prompt": "Generate text based on this prompt",
    "model": "gpt-3.5-turbo"
}</code></pre>

        <h4><?php echo esc_html__("Example Response", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": true,
    "data": "Generated text based on the provided prompt...",
    "input_tokens": "Input token count (numeric)",
    "output_tokens": "Output token count (numeric)"
}</code></pre>

        <h4><?php echo esc_html__("Error Responses", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": false,
    "error": "You need to specify an API key for this request"
}</code></pre>
    </div>
    <div class="endpoint">
        <h2><?php echo esc_html__("List AI Assistants Endpoint", 'aiomatic-automatic-ai-content-writer');?></h2>
        <h4><?php echo esc_html__("Endpoint", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><code><?php echo get_rest_url();?>aiomatic/v1/assistants</code></p>

        <h4><?php echo esc_html__("Methods", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><?php echo esc_html__("Supported methods:", 'aiomatic-automatic-ai-content-writer');?> <code>GET</code>, <code>POST</code></p>

        <h4><?php echo esc_html__("Parameters", 'aiomatic-automatic-ai-content-writer');?></h4>
        <ul>
            <li><strong><?php echo esc_html__("apikey", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required if set in plugin settings): The API key for authentication.", 'aiomatic-automatic-ai-content-writer');?></li>
        </ul>

        <h4><?php echo esc_html__("Example Request", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>GET <?php echo get_rest_url();?>aiomatic/v1/assistants?apikey=YOUR_API_KEY</code></pre>
        <pre><code>POST <?php echo get_rest_url();?>aiomatic/v1/assistants
Content-Type: application/json

{
    "apikey": "YOUR_API_KEY"
}</code></pre>

        <h4><?php echo esc_html__("Example Response", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": true,
    "assistants": {
        "Assistant ID 1": "Assistant Name 1",
        "Assistant ID 2": "Assistant Name 2"
    }
}</code></pre>

        <h4><?php echo esc_html__("Error Responses", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": false,
    "error": "You need to specify an API key for this request"
}</code></pre>
    </div>
    <div class="endpoint">
        <h2><?php echo esc_html__("List AI Models Endpoint", 'aiomatic-automatic-ai-content-writer');?></h2>
        <h4><?php echo esc_html__("Endpoint", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><code><?php echo get_rest_url();?>aiomatic/v1/models</code></p>

        <h4><?php echo esc_html__("Methods", 'aiomatic-automatic-ai-content-writer');?></h4>
        <p><?php echo esc_html__("Supported methods:", 'aiomatic-automatic-ai-content-writer');?> <code>GET</code>, <code>POST</code></p>

        <h4><?php echo esc_html__("Parameters", 'aiomatic-automatic-ai-content-writer');?></h4>
        <ul>
            <li><strong><?php echo esc_html__("apikey", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("(required if set in plugin settings): The API key for authentication.", 'aiomatic-automatic-ai-content-writer');?></li>
        </ul>

        <h4><?php echo esc_html__("Example Request", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>GET <?php echo get_rest_url();?>aiomatic/v1/models?apikey=YOUR_API_KEY</code></pre>
        <pre><code>POST <?php echo get_rest_url();?>aiomatic/v1/models
Content-Type: application/json

{
    "apikey": "YOUR_API_KEY"
}</code></pre>

        <h4><?php echo esc_html__("Example Response", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": true,
    "models": [
        "gpt-3.5-turbo",
        "gpt-4-turbo"
    ]
}</code></pre>

        <h4><?php echo esc_html__("Error Responses", 'aiomatic-automatic-ai-content-writer');?></h4>
        <pre><code>{
    "success": false,
    "error": "You need to specify an API key for this request"
}</code></pre>
    </div>
</td></tr>
        </table>
            </div>
        <div id="tab-27<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('AI Writer', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'AI Writer Default Settings' tab allows you to set and adjust the default parameters for the AI content generation tools, ensuring consistency and alignment with your WordPress site's style and tone.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
         <tr class="aiomatic-title-holder"><td><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Post Writer Default Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
         <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="writer_assistant_id" name="aiomatic_Main_Settings[writer_assistant_id]" class="cr_width_full" onchange="assistantSelected('writer_assistant_id', 'disableWriter');">
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
        if($writer_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($writer_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
         <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the default model you want to use for the AI writer functionality of the plugin.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Post Writer Default Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="ai_writer_model" name="aiomatic_Main_Settings[ai_writer_model]" <?php if($writer_assistant_id != ''){echo ' disabled';}?> class="disableWriter cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($ai_writer_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
        <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI writer to create titles. You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%% - default value is: Create a captivating and concise SEO title in English for your WordPress %%post_type%%: \"%%post_title_idea%%\". Boost its search engine visibility with relevant keywords for maximum impact.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Post Writer Default Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[ai_writer_title_prompt]" placeholder="AI Post Writer Title Prompt" class="cr_width_full"><?php echo esc_textarea($ai_writer_title_prompt);?></textarea>
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI writer to create SEO Meta Descriptions. You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%% - default value is: Craft an enticing and succinct meta description in English for your WordPress %%post_type%%: \"%%post_title_idea%%\". Emphasize the notable features and advantages in just 155 characters, incorporating relevant keywords to optimize its SEO performance.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Post Writer Default SEO Meta Description Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[ai_writer_seo_prompt]" placeholder="AI Post Writer SEO Meta Description Prompt" class="cr_width_full"><?php echo esc_textarea($ai_writer_seo_prompt);?></textarea>
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI writer to create Content. You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%% - default value is: Create a captivating and comprehensive English description for your WordPress %%post_type%%: \"%%post_title_idea%%\". Dive into specific details, highlighting its unique features of this subject, if possible, benefits, and the value it brings. Craft a compelling narrative around the %%post_type%% that captivates the audience. Use HTML for formatting, include unnumbered lists and bold. Writing Style: Creative. Tone: Neutral.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Post Writer Default Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[ai_writer_content_prompt]" placeholder="AI Post Writer Content Prompt" class="cr_width_full"><?php echo esc_textarea($ai_writer_content_prompt);?></textarea>
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI writer to create Excerpt. You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%% - default value is: Write a captivating and succinct English summary for the WordPress %%post_type%%: \"%%post_title_idea%%\", accentuating its pivotal features, advantages, and distinctive qualities.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Post Writer Default Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[ai_writer_excerpt_prompt]" placeholder="AI Post Writer Content Excerpt" class="cr_width_full"><?php echo esc_textarea($ai_writer_excerpt_prompt);?></textarea>
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI writer to create Tags. You can use the following shortcodes here: %%post_title_idea%%, %%post_title%%, %%post_excerpt%%, %%post_content%%, %%post_type%% - default value is: Suggest a series of pertinent keywords in English for your WordPress %%post_type%%: \"%%post_title_idea%%\". These keywords should be closely connected to the %%post_type%%, optimizing its visibility. Please present the keywords in a comma-separated format without using symbols like -, #, etc.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Post Writer Default Tags Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[ai_writer_tags_prompt]" placeholder="AI Post Writer Content Tags" class="cr_width_full"><?php echo esc_textarea($ai_writer_tags_prompt);?></textarea>
                  </td>
               </tr>
        </table>
            </div>
      <div id="tab-30<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Web Scraping', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Web Scraping Settings' tab provides tools and options to configure and manage web scraping activities, enabling efficient data extraction and content sourcing for your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder">
         <td colspan="2">
            <h2 class="aiomatic-inner-title"><?php echo esc_html__("Scraping Enhancements Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
            </td></tr>                 
                 <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Set the path on your local server of the phantomjs executable. If you leave this field blank, the default 'phantomjs' call will be used. <a href='%s' target='_blank'>How to install PhantomJs?</a>", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), "//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/" );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("PhantomJS Path On Server:", 'aiomatic-automatic-ai-content-writer');?></b>
<?php
if($phantom_path != '')
{
   $phchecked = get_transient('aiomatic_phantom_check');
   if($phchecked === false)
   {
      $phantom = aiomatic_testPhantom();
      if($phantom === 0)
      {
         echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS not found - please install it on your server or configure the path to it in plugin\'s \'Settings\'!', 'aiomatic-automatic-ai-content-writer') . '</b> <a href=\'//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/\' target=\'_blank\'>' . esc_html__('How to install PhantomJs?', 'aiomatic-automatic-ai-content-writer') . '</a></span>';
      }
      elseif($phantom === -1)
      {
         echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell exec is not enabled on your server. Please enable it and retry using this feature of the plugin.', 'aiomatic-automatic-ai-content-writer') . '</b></span>';
      }
      elseif($phantom === -2)
      {
         echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell exec is not allowed to run on your server (in disable_functions list in php.ini). Please enable it and retry using this feature of the plugin.', 'aiomatic-automatic-ai-content-writer') . '</b></span>';
      }
      elseif($phantom === 1)
      {
         echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: PhantomJS Test Successful', 'aiomatic-automatic-ai-content-writer') . '</b></span>';
         set_transient('aiomatic_phantom_check', '1', 2592000);
      }
   }
   else
   {
      echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: PhantomJS OK', 'aiomatic-automatic-ai-content-writer') . '</b></span>';   
   }
}
?>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" id="phantom_path" class="cr_width_full" placeholder="<?php echo esc_html__("Path to phantomjs", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[phantom_path]" value="<?php echo esc_html($phantom_path);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the timeout (in milliseconds) for every headless browser running. I recommend that you leave this field at it's default value (30000). If you leave this field blank, the default value will be used.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout for Headless Browser Execution:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" id="phantom_timeout" class="cr_width_full" step="1" min="1" placeholder="<?php echo esc_html__("Input headless browser timeout in milliseconds", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[phantom_timeout]" value="<?php echo esc_html($phantom_timeout);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input a separator for multiple content extracted from multiple HTML entities that match the same class defined for crawling. Default is a new line.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Multiple Crawled Content Separator:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <input type="text" id="multi_separator" class="cr_width_full" name="aiomatic_Main_Settings[multi_separator]" value="<?php echo esc_attr($multi_separator);?>" placeholder="<?php echo esc_html__("Content separator", 'aiomatic-automatic-ai-content-writer');?>">
                     </td>
                  </tr>
      </table>
</div>
        <div id="tab-28<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('Cloud Storage Options', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'Cloud Storage' tab allows you to manage and configure cloud storage options for securely saving and accessing AI generated images and videos.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat"><tr class="aiomatic-title-holder">
         <td colspan="2">
            <h2 class="aiomatic-inner-title"><?php echo esc_html__("Image Storage Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
            </td></tr>
              <tr>
                 <th>
                    <div>
                       <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                          <div class="bws_hidden_help_text cr_min_260px">
                             <?php
                                echo esc_html__("Click this option to enable integration with the 'Featured Image from URL' plugin - https://wordpress.org/plugins/featured-image-from-url/ (you need to install and activate this plugin). This will not copy featured images of created posts locally, but will link them directly from their source.", 'aiomatic-automatic-ai-content-writer');
                                ?>
                          </div>
                       </div>
                       <b><?php echo esc_html__("Enable 'Featured Image from URL' Integration:", 'aiomatic-automatic-ai-content-writer');?></b>
<?php
                     if ($url_image == 'on' && !is_plugin_active('featured-image-from-url/featured-image-from-url.php') && !is_plugin_active('fifu-premium/fifu-premium.php')) {
?>
      <br/>
                       <b class="cr_red12"><?php echo esc_html__("The 'Featured Image from URL' plugin is not active. Please install it and activate it: ", 'aiomatic-automatic-ai-content-writer');?> <a href="https://wordpress.org/plugins/featured-image-from-url/" target="_blank">https://wordpress.org/plugins/featured-image-from-url/</a></b>
<?php
                     }
?>
                 </th>
                 <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="url_image" name="aiomatic_Main_Settings[url_image]"<?php
                     if ($url_image == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                 </td>
              </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to copy royalty free or AI generated images from posts content, from their original location to a local/remote server?", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Copy Royalty Free / AI Images From Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
                  <?php
                     if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) {
                         $amazon_s3_active = true;
                     }
                     else
                     {
                        $amazon_s3_active = false;
                     }
                     ?>
                  <select id="copy_locally" name="aiomatic_Main_Settings[copy_locally]" onchange="mainChanged();" class="cr_width_full">
                     <option value="disabled"<?php
                              if ($copy_locally == "disabled") {
                                    echo " selected";
                              }
                              ?>>Disabled</option>
                     <option value="on"<?php
                              if ($copy_locally == "on") {
                                    echo " selected";
                              }
                              ?>>Local Server</option>
                        <option value="amazon"<?php
                        if ($copy_locally == "amazon") {
                              echo " selected";
                        }
                        if($amazon_s3_active == false)
                        {
                           echo ' disabled';
                        }
                        ?> >Amazon S3</option>
                        <option value="cloudflare"<?php
                        if ($copy_locally == "cloudflare") {
                              echo " selected";
                        }
                        if($amazon_s3_active == false)
                        {
                           echo ' disabled';
                        }
                        ?> >CloudFlare R2</option>
                        <option value="digital"<?php
                        if ($copy_locally == "digital") {
                              echo " selected";
                        }
                        if($amazon_s3_active == false)
                        {
                           echo ' disabled';
                        }
                        ?> >Digital Ocean Spaces</option>
                        <option value="wasabi"<?php
                        if ($copy_locally == "wasabi") {
                              echo " selected";
                        }
                        if($amazon_s3_active == false)
                        {
                           echo ' disabled';
                        }
                        ?> >Wasabi</option>
                  </select>
               </td>
            </tr>
            <tr class="hideCompress">
                 <th>
                    <div>
                       <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                          <div class="bws_hidden_help_text cr_min_260px">
                             <?php
                                echo esc_html__("Do you want to disable automatic compression of copied images?", 'aiomatic-automatic-ai-content-writer');
                                ?>
                          </div>
                       </div>
                       <b><?php echo esc_html__("Disable Automatic Image Compression For Copied Images:", 'aiomatic-automatic-ai-content-writer');?></b>
                 </th>
                 <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="disable_compress" name="aiomatic_Main_Settings[disable_compress]"<?php
                     if ($disable_compress == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                 </td>
              </tr>
            <tr class="hideCompress">
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the quality of the compressed images. Accepted values: 1-100. 1 is lowest quality, 100 is highest quality. If you want to disable this feature, leave this field blank. This feature will work only if you copy AI generated images from their original sources. Default is 75.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Image Compression Quality:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="1" step="1" max="100" name="aiomatic_Main_Settings[compress_quality]" value="<?php echo esc_html($compress_quality);?>" placeholder="75" class="cr_width_full">
                  </div>
               </td>
            </tr>
<?php
if($amazon_s3_active == false)
{
?>
            <tr>
               <td colspan="2">
                     <b><?php echo esc_html__("Exciting news for Aiomatic plugin users: You can now store royalty-free or AI-generated images in Amazon S3 with Aiomatic's new extension! Get it here: ", 'aiomatic-automatic-ai-content-writer') . '<a href="https://coderevolution.ro/product/aiomatic-extension-amazon-s3-storage-for-images/" target="_blank">' . esc_html__("Aiomatic Extension: Amazon S3 Storage", 'aiomatic-automatic-ai-content-writer') . '</a>';?></b>
               </td>
            </tr>
<?php
}
?>
            <tr class="aiomatic-title-holder">
               <td colspan="2">
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("Amazon S3 Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the folder name from Amazon S3 where to save the video files. If you leave this blank, the videos will be uploaded to the root folder of your Amazon S3. The plugin will create the directory you define here, if it is not already existing.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Amazon S3 Directory:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[drive_directory]" value="<?php echo esc_html($drive_directory);?>" placeholder="Folder name from Amazon S3" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the bucket name from Amazon S3. You can create your Amazon Bucket, here: ", 'aiomatic-automatic-ai-content-writer') . '<a href="https://s3.console.aws.amazon.com/s3/bucket/create" target="_blank">https://s3.console.aws.amazon.com/s3/bucket/create</a>.';
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Amazon Bucket Name:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[bucket_name]" value="<?php echo esc_html($bucket_name);?>" placeholder="Amazon S3 Bucket Name" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the bucket region from Amazon S3.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Amazon Bucket Region:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <select id="bucket_region" name="aiomatic_Main_Settings[bucket_region]" class="cr_width_full">
               <option value="us-west-1"<?php if($bucket_region == 'us-west-1') {echo ' selected';}?>><?php echo esc_html__("US West 1 (N. California)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="us-west-2"<?php if($bucket_region == 'us-west-2') {echo ' selected';}?>><?php echo esc_html__("US West 2 (Oregon)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="us-east-1"<?php if($bucket_region == 'us-east-1') {echo ' selected';}?>><?php echo esc_html__("US East 1 (N. Virginia)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="us-east-2"<?php if($bucket_region == 'us-east-2') {echo ' selected';}?>><?php echo esc_html__("US East 2 (Ohio)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="sa-east-1"<?php if($bucket_region == 'sa-east-1') {echo ' selected';}?>><?php echo esc_html__("South America 1 (Sao Paulo)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="me-south-1"<?php if($bucket_region == 'me-south-1') {echo ' selected';}?>><?php echo esc_html__("Middle East (Bahrain)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-central-1"<?php if($bucket_region == 'eu-central-1') {echo ' selected';}?>><?php echo esc_html__("EU Central 1 (Frankfurt)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-north-1"<?php if($bucket_region == 'eu-north-1') {echo ' selected';}?>><?php echo esc_html__("EU North 1 (Stockholm)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-west-1"<?php if($bucket_region == 'eu-west-1') {echo ' selected';}?>><?php echo esc_html__("EU West 1 (Ireland)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-west-2"<?php if($bucket_region == 'eu-west-2') {echo ' selected';}?>><?php echo esc_html__("EU West 2 (London)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-west-3"<?php if($bucket_region == 'eu-west-3') {echo ' selected';}?>><?php echo esc_html__("EU West 3 (Paris)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ca-central-1"<?php if($bucket_region == 'ca-central-1') {echo ' selected';}?>><?php echo esc_html__("Canada (Central)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-northeast-1"<?php if($bucket_region == 'ap-northeast-1') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 1 (Tokyo)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-southeast-2"<?php if($bucket_region == 'ap-southeast-2') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 2 (Sydney)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-southeast-1"<?php if($bucket_region == 'ap-southeast-1') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 3 (Singapore)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-northeast-2"<?php if($bucket_region == 'ap-northeast-2') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 4 (Seoul)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-south-1"<?php if($bucket_region == 'ap-south-1') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 5 (Mumbai)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-east-1"<?php if($bucket_region == 'ap-east-1') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 6 (Hong Kong)", 'aiomatic-automatic-ai-content-writer');?></option>
               </select>   
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API key for your Amazon S3 client. Details: ", 'aiomatic-automatic-ai-content-writer');
                              ?><a href="https://console.aws.amazon.com/iamv2/home#/security_credentials" target="_blank">https://console.aws.amazon.com/iamv2/home#/security_credentials</a>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Amazon S3 API Key:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[s3_user]" value="<?php echo esc_html($s3_user);?>" placeholder="Amazon S3 API Key" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API secret for your Amazon S3 client. Details: ", 'aiomatic-automatic-ai-content-writer');
                              ?><a href="https://console.aws.amazon.com/iamv2/home#/security_credentials" target="_blank">https://console.aws.amazon.com/iamv2/home#/security_credentials</a>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Amazon S3 API Secret:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="password" name="aiomatic_Main_Settings[s3_pass]" value="<?php echo esc_html($s3_pass);?>" placeholder="Amazon S3 API Secret" class="cr_width_full">
               </td>
            </tr>
            <tr class="aiomatic-title-holder">
               <td colspan="2">
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("Wasabi Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the folder name from Wasabi where to save the video files. If you leave this blank, the videos will be uploaded to the root folder of your Wasabi. The plugin will create the directory you define here, if it is not already existing.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Wasabi Directory:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[wasabi_directory]" value="<?php echo esc_html($wasabi_directory);?>" placeholder="Folder name from Wasabi" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the Bucket Name from Wasabi - You can create your Wasabi bucket, here: ", 'aiomatic-automatic-ai-content-writer') . '<a href="https://console.wasabisys.com/file_manager" target="_blank">https://console.wasabisys.com/file_manager</a>.';
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Wasabi Bucket Name:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[wasabi_bucket]" value="<?php echo esc_html($wasabi_bucket);?>" placeholder="Wasabi bucket name" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the bucket region from Wasabi.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Wasabi Bucket Region:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <select id="wasabi_region" name="aiomatic_Main_Settings[wasabi_region]" class="cr_width_full">
               <option value="us-west-1"<?php if($wasabi_region == 'us-west-1') {echo ' selected';}?>><?php echo esc_html__("US West 1 (Oregon)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="us-central-1"<?php if($wasabi_region == 'us-central-1') {echo ' selected';}?>><?php echo esc_html__("US Central 1 (Texas)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="us-east-1"<?php if($wasabi_region == 'us-east-1') {echo ' selected';}?>><?php echo esc_html__("US East 1 (N. Virginia)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="us-east-2"<?php if($wasabi_region == 'us-east-2') {echo ' selected';}?>><?php echo esc_html__("US East 2 (N. Virginia)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-central-1"<?php if($wasabi_region == 'eu-central-1') {echo ' selected';}?>><?php echo esc_html__("EU Central 1 (Amsterdam)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-central-2"<?php if($wasabi_region == 'eu-central-2') {echo ' selected';}?>><?php echo esc_html__("EU central 2 (Frankfurt)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-west-1"<?php if($wasabi_region == 'eu-west-1') {echo ' selected';}?>><?php echo esc_html__("EU West 1 (London)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="eu-west-2"<?php if($wasabi_region == 'eu-west-2') {echo ' selected';}?>><?php echo esc_html__("EU West 2 (Paris)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ca-central-1"<?php if($wasabi_region == 'ca-central-1') {echo ' selected';}?>><?php echo esc_html__("Canada (Toronto)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-northeast-1"<?php if($wasabi_region == 'ap-northeast-1') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 1 (Tokyo)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-southeast-2"<?php if($wasabi_region == 'ap-southeast-2') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 2 (Sydney)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-southeast-1"<?php if($wasabi_region == 'ap-southeast-1') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 3 (Singapore)", 'aiomatic-automatic-ai-content-writer');?></option>
               <option value="ap-northeast-2"<?php if($wasabi_region == 'ap-northeast-2') {echo ' selected';}?>><?php echo esc_html__("Asia Pacific 4 (Osaka)", 'aiomatic-automatic-ai-content-writer');?></option>
               </select>   
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API key for your Wasabi client. Details: ", 'aiomatic-automatic-ai-content-writer');
                              ?><a href="https://console.wasabisys.com/access_keys" target="_blank">https://console.wasabisys.com/access_keys</a>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Wasabi API Key:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[wasabi_user]" value="<?php echo esc_html($wasabi_user);?>" placeholder="Wasabi API Key" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API secret for your Wasabi client. Details: ", 'aiomatic-automatic-ai-content-writer');
                              ?><a href="https://console.wasabisys.com/access_keys" target="_blank">https://console.wasabisys.com/access_keys</a>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Wasabi API Secret:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="password" name="aiomatic_Main_Settings[wasabi_pass]" value="<?php echo esc_html($wasabi_pass);?>" placeholder="Wasabi API Secret" class="cr_width_full">
               </td>
            </tr>
            <tr class="aiomatic-title-holder">
               <td colspan="2">
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("CloudFlare R2 Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the folder name from  CloudFlare R2 where to save the video files. If you leave this blank, the videos will be uploaded to the root folder of your CloudFlare R2. The plugin will create the directory you define here, if it is not already existing.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("CloudFlare R2 Directory:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[cloud_directory]" value="<?php echo esc_html($cloud_directory);?>" placeholder="Folder name from CloudFlare R2" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input your Account ID from CloudFlare R2. You can create CloudFlare R2 account ID by copying the ID from the right of the 'Overview' page from the CloudFlare R2 Control Panel.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("CloudFlare R2 Account ID:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[cloud_account]" value="<?php echo esc_html($cloud_account);?>" placeholder="CloudFlare account ID" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input your CloudFlare R2 Bucket Name. ", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("CloudFlare R2 Bucket Name:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[cloud_bucket]" value="<?php echo esc_html($cloud_bucket);?>" placeholder="CloudFlare bucket name" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API key for your CloudFlare R2 client. You can create CloudFlare R2 API credentials by clicking the 'Manage R2 API Tokens' link on the right of the 'Overview' page from the CloudFlare R2 Control Panel.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("CloudFlare R2 API Key:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[cloud_user]" value="<?php echo esc_html($cloud_user);?>" placeholder="CloudFlare R2 API Key" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API secret for your CloudFlare R2 client. You can create CloudFlare R2 API credentials by clicking the 'Manage R2 API Tokens' link on the right of the 'Overview' page from the CloudFlare R2 Control Panel.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("CloudFlare R2 API Secret:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="password" name="aiomatic_Main_Settings[cloud_pass]" value="<?php echo esc_html($cloud_pass);?>" placeholder="CloudFlare R2 API Secret" class="cr_width_full">
               </td>
            </tr>
            <tr class="aiomatic-title-holder">
               <td colspan="2">
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("Digital Ocean Spaces Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the folder name from Digital Ocean Spaces where to save the video files. If you leave this blank, the videos will be uploaded to the root folder of your Digital Ocean Spaces. The plugin will create the directory you define here, if it is not already existing.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Digital Ocean Spaces Directory:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[digital_directory]" value="<?php echo esc_html($digital_directory);?>" placeholder="Folder name from Digital Ocean Spaces" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the Origin Endpoint from Digital Ocean Spaces. This should be in the following format: https://<bucketname>.<datacenterregion>.digitaloceanspaces.com - You can create your Digital Ocean Spaces bucket, here: ", 'aiomatic-automatic-ai-content-writer') . '<a href="https://cloud.digitalocean.com/spaces" target="_blank">https://cloud.digitalocean.com/spaces</a>.';
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Digital Ocean Spaces Origin Endpoint:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[digital_endpoint]" value="<?php echo esc_html($digital_endpoint);?>" placeholder="https://<bucketname>.<datacenterregion>.digitaloceanspaces.com" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API key for your Digital Ocean Spaces client. Details: ", 'aiomatic-automatic-ai-content-writer');
                              ?><a href="https://cloud.digitalocean.com/account/api/spaces" target="_blank">https://cloud.digitalocean.com/account/api/spaces</a>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Digital Ocean Spaces API Key:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="text" name="aiomatic_Main_Settings[digital_user]" value="<?php echo esc_html($digital_user);?>" placeholder="Digital Ocean Spaces API Key" class="cr_width_full">
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the API secret for your Digital Ocean Spaces client. Details: ", 'aiomatic-automatic-ai-content-writer');
                              ?><a href="https://cloud.digitalocean.com/account/api/spaces" target="_blank">https://cloud.digitalocean.com/account/api/spaces</a>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Digital Ocean Spaces API Secret:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <input type="password" name="aiomatic_Main_Settings[digital_pass]" value="<?php echo esc_html($digital_pass);?>" placeholder="Digital Ocean Spaces API Secret" class="cr_width_full">
               </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Amazon S3 Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr><tr>
            <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/DIUZkvD4Y6U" frameborder="0" allowfullscreen></iframe>
   </td></tr>
            <tr><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Other Cloud Storage Options Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
            <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/FFjrfLJ4Re8" frameborder="0" allowfullscreen></iframe>
   </td>
   </tr>
        </table>
            </div>
        <div id="tab-29<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('Advanced AI API Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'Advanced AI API Settings' tab enables you to customize and control advanced AI-driven features by adjusting API configurations and parameters for enhanced functionality of the plugin.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Textual AI Models Advanced Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("If specified, the AI API will make a best effort to sample deterministically, such that repeated requests with the same seed and parameters should return the same result. Determinism is not guaranteed, as changes can be made to the API in the backend, over longer periods of time.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Seed For AI Writer (To Make Responses Deterministic):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" id="ai_seed" step="1" min="0" placeholder="<?php echo esc_html__("AI Seed", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[ai_seed]" value="<?php
                        echo esc_html($ai_seed);
                        ?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set a hardcoded context window limit for the gpt-3.5-turbo-1106 model. If you don't set this, the default 16385 token limit will be used.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Context Window Limit For gpt-3.5-turbo-1106:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="1" step="1" max="16385" name="aiomatic_Main_Settings[gpt35_context_limit]" value="<?php echo esc_html($gpt35_context_limit);?>" placeholder="16385" class="cr_width_full">
                  </td>
               </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set a hardcoded context window limit for the gpt-4-1106(-preview) model. If you don't set this, the default 128000 token limit will be used.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Context Window Limit For gpt-4-1106:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="1" step="1" max="128000" name="aiomatic_Main_Settings[gpt4_context_limit]" value="<?php echo esc_html($gpt4_context_limit);?>" placeholder="128000" class="cr_width_full">
                  </td>
               </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set a hardcoded context window limit for the Claude models. If you don't set this, the default 100000 token limit will be used.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Context Window Limit For Claude Models:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="1" step="1" max="100000" name="aiomatic_Main_Settings[claude_context_limit]" value="<?php echo esc_html($claude_context_limit);?>" placeholder="100000" class="cr_width_full">
                  </td>
               </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set a hardcoded context window limit for the Claude 200k models. If you don't set this, the default 200000 token limit will be used.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Context Window Limit For Claude 200k Models:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="1" step="1" max="200000" name="aiomatic_Main_Settings[claude_context_limit_200k]" value="<?php echo esc_html($claude_context_limit_200k);?>" placeholder="200000" class="cr_width_full">
                  </td>
               </tr><tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Assistants Advanced Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Set the maximum number of prompt tokens which AI Assistants are allowed to use. Use this settings with caution, incomplete Assistant messages may result if this is used.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Assistants Maximum Prompt Token Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" id="assist_max_prompt_token" step="1" min="0" placeholder="<?php echo esc_html__("Max Prompt Token Count", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[assist_max_prompt_token]" value="<?php
                        echo esc_html($assist_max_prompt_token);
                        ?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Set the maximum number of completion tokens which AI Assistants are allowed to use. Use this settings with caution, incomplete Assistant messages may result if this is used.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Assistants Maximum Completion Token Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" id="assist_max_completion_token" step="1" min="0" placeholder="<?php echo esc_html__("Max Completion Token Count", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[assist_max_completion_token]" value="<?php
                        echo esc_html($assist_max_completion_token);
                        ?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
        </table>
        <table class="widefat">
         <tr class="aiomatic-title-holder">
            <td class="cr_width_full">
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("HuggingFace Models:", 'aiomatic-automatic-ai-content-writer');?></h2>
         </td></tr>
<?php
if(empty($app_id_huggingface))
{
   echo esc_html__("You need to add a HuggingFace API key in plugin settings to use this feature.", 'aiomatic-automatic-ai-content-writer');
}
else
{
?>
         <tr><td class="cr_inline">
               <div class="table-responsive">
                  <div id="grid-models-aiomatic">
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the model.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to delete this model?", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <a href="https://huggingface.co/models?pipeline_tag=text-generation&sort=trending" target="_blank"><?php echo esc_html__("HuggingFace Model Name", 'aiomatic-automatic-ai-content-writer');?></a>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("The name of the model from HuggingFace.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <a href="https://ui.endpoints.huggingface.co/" target="_blank"><?php echo esc_html__("Inference Endpoint URL (Optional)", 'aiomatic-automatic-ai-content-writer');?></a>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("The Inference Endpoint URL of this model (optional). This is required only for models which are too large to be run on HuggingFace default platform (for which, the 'The model ... is too large to be loaded automatically (...GB > 10GB)' message is returned). Check this tutorial video for details on the usage of this feature:", 'aiomatic-automatic-ai-content-writer') . ' <a href="https://youtu.be/ub81iVAWjJ0" target="_blank">Huggingface Update</a>.';
                                       ?>
                                 </div>
                              </div>
                           </div>
                        <?php
                           echo aiomatic_expand_huggingface_models();
                           ?>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div class="cr_center">-</div>
                           <div class="cr_center"><span class="cr_gray20">X</span></div>
                           <div class="cr_center"><input type="text" name="aiomatic_huggingface_models[model][]" placeholder="<?php echo esc_html__("Please insert the model name", 'aiomatic-automatic-ai-content-writer');?>" value=""/></div>
                           <div class="cr_center"><input type="url" name="aiomatic_huggingface_models[endpoint_url][]" placeholder="<?php echo esc_html__("Inference Endpoint URL (Optional)", 'aiomatic-automatic-ai-content-writer');?>" value=""/></div>
                           </div>
                        </div>
                  <hr/>
                        <p class="crsubmit"><input type="submit" name="btnSubmitkw" id="btnSubmitkw" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Models", 'aiomatic-automatic-ai-content-writer');?>"/></p>
            </td></tr>
<?php
}
?>
         </table>
            </div>
        <div id="tab-26<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('AI Image Selector', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'AI Image Selector Settings' tab enables you to configure and customize AI-driven tools that help select the most relevant and impactful images for your WordPress site's content.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Default Featured Image Optimizations:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
         <tr>
            <th>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("If you entered a list of images in the 'Default Featured Image List' settings field, you can set up the plugin to ask the AI to select the image which matches the best the title of the published post.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Use AI To Select Default Featured Image For Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="use_image_ai" onchange="imageAIChanged();" name="aiomatic_Main_Settings[use_image_ai]"<?php
                     if ($use_image_ai == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr class="hideimgai">
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="img_assistant_id" name="aiomatic_Main_Settings[img_assistant_id]" class="cr_width_full" onchange="assistantSelected('img_assistant_id', 'disableImg');">
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
        if($img_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($img_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
         <tr class="hideimgai">
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the default model you want to use for the AI Default Featured Image Selector prompt.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("AI Default Featured Image Selector Model:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <select id="image_ai_model" name="aiomatic_Main_Settings[image_ai_model]" <?php if($img_assistant_id != ''){echo ' disabled';}?> class="cr_width_full disableImg">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($image_ai_model == $modelx) 
{
echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                  </select>  
               </div>
            </td>
         </tr>
         <tr class="hideimgai">
               <th class="cr_min_width_200">
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Set the prompt to be used for the AI Default Featured Image Selector. You can use the following shortcodes: %%post_title%%, %%image_list%% - The default value for this settings field is: Select an image URL, based on its file name, which matches the best the post, based on its title. If no matching image can be selected, pick a random one from the list. Respond only with the URL of the selected image and with nothing else. The title of the post is: \"%%post_title%%\" The image URL list is: %%image_list%%", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Default Featured Image Selector:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <textarea name="aiomatic_Main_Settings[image_ai_prompt]" placeholder="YouTube Video Search Keyword Extractor Prompt" class="cr_width_full"><?php echo esc_textarea($image_ai_prompt);?></textarea>
               </td>
            </tr>
        </table>
            </div>
        <div id="tab-22<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <table class="widefat">
<h3><?php echo esc_html__('AI Taxonomy SEO', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'AI Taxonomy Description Writer' tab offers automated tools to create and refine descriptive content for categories and tags, enhancing the organization and SEO of your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Taxonomy Description Writer Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="tax_assistant_id" name="aiomatic_Main_Settings[tax_assistant_id]" class="cr_width_full" onchange="assistantSelected('tax_assistant_id', 'disableTax');">
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
        if($tax_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($tax_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
        <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the default model you want to use for the AI Taxonomy Description Writer.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Taxonomy Description Writer Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="tax_description_model" name="aiomatic_Main_Settings[tax_description_model]" <?php if($tax_assistant_id != ''){echo ' disabled';}?> class="disableTax cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($tax_description_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI Taxonomy Description Writer feature. You can use the following shortcodes here: %%term_name%%, %%term_id%%, %%term_slug%%, %%term_description%%, %%term_taxonomy_name%%, %%term_taxonomy_id%% - default is: Write a description for a WordPress %%term_taxonomy_name%% with the following title: \"%%term_name%%\"", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Taxonomy Description Writer Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[tax_description_prompt]" placeholder="AI Taxonomy Description Writer Prompt" class="cr_width_full"><?php echo esc_textarea($tax_description_prompt);?></textarea>
                  </td>
               </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Taxonomy SEO Meta Writer Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select if you want to enable also SEO meta description writing for the taxonomies. Note that this will work only for taxonomies automatically processed using the 'Enable Automatic Processing Of All Newly Added Taxonomies For' settings field from above. Also, note that you will need to have a SEO plugin installed on your site, from the following list: Yoast SEO, All In One SEO, Rank Math.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Enable SEO Meta Description Writing:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="tax_seo_auto" onchange="taxSeoChanged();" name="aiomatic_Main_Settings[tax_seo_auto]" class="cr_width_full">
                     <option value="off"<?php
                           if ($tax_seo_auto == "off") {
                                 echo " selected";
                           }
                           ?> ><?php echo esc_html__("Off", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="copy"<?php
                           if ($tax_seo_auto == "copy") {
                                 echo " selected";
                           }
                           ?> ><?php echo esc_html__("Copy The Taxonomy Description", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="write"<?php
                           if ($tax_seo_auto == "write") {
                                 echo " selected";
                           }
                           ?> ><?php echo esc_html__("Write Separate SEO Description", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select>  
                  </div>
               </td>
            </tr><tr class="TaxSEO">
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="tax_seo_assistant_id" name="aiomatic_Main_Settings[tax_seo_assistant_id]" class="cr_width_full" onchange="assistantSelected('tax_seo_assistant_id', 'disableTaxSEO');">
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
        if($tax_seo_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($tax_seo_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
            <tr class="TaxSEO">
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the default model you want to use for the AI Taxonomy SEO Description Writer. This will set the SEO description for the following SEO plugins: Yoast SEO, All In One SEO, Rank Math.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Taxonomy SEO Description Writer Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="tax_seo_description_model" name="aiomatic_Main_Settings[tax_seo_description_model]" <?php if($tax_seo_assistant_id != ''){echo ' disabled';}?> class="disableTaxSEO cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($tax_seo_description_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr class="TaxSEO">
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI Taxonomy SEO Description Writer feature. You can use the following shortcodes here: %%term_name%%, %%term_id%%, %%term_slug%%, %%term_description%%, %%term_taxonomy_name%%, %%term_taxonomy_id%% - default is: Write a description for a WordPress %%term_taxonomy_name%% with the following title: \"%%term_name%%\". This will set the SEO description for the following SEO plugins: Yoast SEO, All In One SEO, Rank Math.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Taxonomy SEO Description Writer Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[tax_seo_description_prompt]" placeholder="AI Taxonomy Description Writer Prompt" class="cr_width_full"><?php echo esc_textarea($tax_seo_description_prompt);?></textarea>
                  </td>
               </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Automatic Taxonomy Processing At Creation:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select if you want to enable automatic processing and description creation using AI of all newly added taxonomies for the taxonomy names you select (which don't already have a description set when they are created).", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Enable Automatic Processing Of All Newly Added Taxonomies For:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="tax_description_auto" multiple name="aiomatic_Main_Settings[tax_description_auto][]" class="cr_width_full">
<?php
$taxonomies = get_taxonomies();

foreach ($taxonomies as $tx) 
{
    echo '<option value="' . $tx . '"';
    if (in_array($tx, $tax_description_auto)) {
          echo " selected";
    }
    echo '>' . $tx . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Existing Taxonomy AI Description Writer:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the taxonomies which you want to be affected by the manual taxonomy writing process.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Manually Run Taxonomy Description Writing On:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="tax_description_manual" name="aiomatic_Main_Settings[tax_description_manual]" class="cr_width_full">
<?php
foreach ($taxonomies as $tx) 
{
    echo '<option value="' . $tx . '"';
    if ($tx == $tax_description_manual) {
          echo " selected";
    }
    echo '>' . $tx . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum number of taxonomies to be processed at each run.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Number Of Taxonomies To Process:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" id="max_tax_nr" step="1" min="1" placeholder="Maximum Taxonomy Count" name="aiomatic_Main_Settings[max_tax_nr]" value="<?php echo esc_html($max_tax_nr);?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
         <tr>
            <th>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Check this to force the plugin to make draft posts before they would be fully published. This can help you you use other third party plugins with the automatically published posts.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Process Also Taxonomies Which Already Have A Description:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="overwite_tax" name="aiomatic_Main_Settings[overwite_tax]"<?php
                     if ($overwite_tax == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
            <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to run manual writing of description for existing taxonomies, now? Please check configuration from below before clicking 'Run Taxonomy Desciption Writing'.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Manually Run Taxonomy Description Writing Now:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <img id="run_img" src="<?php echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');?>" alt="Running" class="cr_hidden cr_align_middle" title="status">
                     <div class="codemainfzr">
                     <select id="taxactions" class="actions" name="aiomatic_tax_actions" onchange="actionsChangedTax(this.value);" onfocus="this.selectedIndex = 0;">
                     <option value="select" disabled selected><?php echo esc_html__("Select an Action", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="run"><?php echo esc_html__("Run Taxonomy Desciption Writing", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select>
                     </div>
                     </td>
                  </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Taxonomy Description Writer Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
               <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/k5BFo9jcmcs" frameborder="0" allowfullscreen></iframe>
   </td></tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Automate the AI Taxonomy Description Writing Process:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
               <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/1OibwD73JIA" frameborder="0" allowfullscreen></iframe>
   </td>
</tr>
        </table>
            </div>
        <div id="tab-21<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('AI Comment Writer', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'AI Comment Writer' tab provides an automated system to generate and manage intelligent, context-aware comments, enhancing engagement across your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Comment Writer Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="comment_assistant_id" name="aiomatic_Main_Settings[comment_assistant_id]" class="cr_width_full" onchange="assistantSelected('comment_assistant_id', 'disableComment');">
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
        if($comment_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($comment_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
        <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the default model you want to use for the AI Comment Writer.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("AI Comment Writer Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="comment_model" name="aiomatic_Main_Settings[comment_model]" <?php if($comment_assistant_id != ''){echo ' disabled';}?> class="disableComment cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($comment_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Set the prompt to be used for the AI Comment Writer feature. You can use the following shortcodes here: %%post_title%%, %%post_excerpt%%, %%username%%, %%comment%% - default is: Write a reply for %%username%%'s comment on the post titled \"%%post_title%%\". The user's comment is: %%comment%%", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("AI Comment Writer Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <textarea name="aiomatic_Main_Settings[comment_prompt]" placeholder="AI Comment Writer Prompt" class="cr_width_full"><?php echo esc_textarea($comment_prompt);?></textarea>
                  </td>
               </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Comment Writer Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
               <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/VknKvIcKRuw" frameborder="0" allowfullscreen></iframe>
   </td></tr>
        </table>
            </div>
        <div id="tab-20<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('[aicontent] Shortcode', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The [aicontent] shortcode offers a wide range of options when it comes to creating AI content anywhere on your site. Check the below tutorial video for full details on this feature.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("[aicontent] Shortcode Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("[aicontent] AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="aicontent_assistant_id" name="aiomatic_Main_Settings[aicontent_assistant_id]" class="cr_width_full" onchange="assistantSelected('aicontent_assistant_id', 'disableAicontent');">
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
        if($aicontent_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($aicontent_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
        <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the default model you want to use for the [aicontent] shortcode. You can defined this also in shortcode parameters.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("[aicontent] Shortcode Default Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="aicontent_model" name="aiomatic_Main_Settings[aicontent_model]" <?php if($aicontent_assistant_id != ''){echo ' disabled';}?> class="disableAicontent cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($aicontent_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("[aicontent] Shortcode Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="0" step="0.1" max="2" name="aiomatic_Main_Settings[aicontent_temperature]" value="<?php echo esc_html($aicontent_temperature);?>" placeholder="1" class="cr_width_full">
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("[aicontent] Shortcode Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="0" max="1" step="0.1" name="aiomatic_Main_Settings[aicontent_top_p]" value="<?php echo esc_html($aicontent_top_p);?>" placeholder="1" class="cr_width_full">
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("[aicontent] Shortcode Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="-2" step="0.1" max="2" name="aiomatic_Main_Settings[aicontent_presence_penalty]" value="<?php echo esc_html($aicontent_presence_penalty);?>" placeholder="0" class="cr_width_full">
                  </td>
               </tr><tr>
                  <th class="cr_min_width_200">
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("[aicontent] Shortcode Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </th>
                  <td>
                  <input type="number" min="0" max="2" step="0.1" name="aiomatic_Main_Settings[aicontent_frequency_penalty]" value="<?php echo esc_html($aicontent_frequency_penalty);?>" placeholder="0" class="cr_width_full">
                  </td>
               </tr>
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
               <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/z_mGPlBsQQA" frameborder="0" allowfullscreen></iframe>
   </td></tr>
        </table>
            </div>
        <div id="tab-17<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Bulk AI Post Creator', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Bulk AI Post Creator' tab offers settings for tools which will efficiently generate multiple AI-driven posts, streamlining content creation and ensuring a consistent flow of fresh material on your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Bulk AI Post Creator Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Add a time period between the plugin will run importing at a schedule. To disable this feature, leave this field blank. This works based on your current server timezone and time. Your current server time is: ", 'aiomatic-automatic-ai-content-writer') . date("h:i A");
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Run Rules Only Between These Hour Periods Each Day:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <input type="time" id="run_after" name="aiomatic_Main_Settings[run_after]" value="<?php echo esc_html($run_after);?>" placeholder="<?php echo esc_html__("Run Rules Only After This Hour", 'aiomatic-automatic-ai-content-writer');?>"> - 
            <input type="time" id="run_before" name="aiomatic_Main_Settings[run_before]" value="<?php echo esc_html($run_before);?>" placeholder="<?php echo esc_html__("Run Rules Only Before This Hour", 'aiomatic-automatic-ai-content-writer');?>">
            </td>
         </tr>
         <tr>
            <th>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Check this to force the plugin to make draft posts before they would be fully published. This can help you you use other third party plugins with the automatically published posts.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Draft Posts First, And Publish Them Afterwards:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="draft_first" name="aiomatic_Main_Settings[draft_first]"<?php
                     if ($draft_first == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Choose if you want to skip checking for duplicate post titles when publishing new posts. If you check this, duplicate post titles will be posted! So use it only when it is necesarry.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Do Not Check For Duplicate Titles:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="do_not_check_duplicates" name="aiomatic_Main_Settings[do_not_check_duplicates]"<?php
                     if ($do_not_check_duplicates == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Choose if you want to process entered titles/topics in order of entering them, not in a random order.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Process Titles/Topics In Order, Not Random:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_random_titles" name="aiomatic_Main_Settings[no_random_titles]"<?php
                     if ($no_random_titles == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to receive a summary of the rule running in an email.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Send Rule Running Summary in Email:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="send_email" onchange="mainChanged();" name="aiomatic_Main_Settings[send_email]"<?php
                     if ($send_email == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div class="hideMail">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Input the email adress where you want to send the report. You can input more email addresses, separated by commas.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Email Address:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div class="hideMail">
                  <input type="text" id="email_address" placeholder="<?php echo esc_html__("Input a valid email adress", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[email_address]" value="<?php
                     echo esc_html($email_address);
                     ?>" class="cr_width_full">
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the required words list that will apply to all plugin rules.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Global Required Words List:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="3" cols="70" name="aiomatic_Main_Settings[global_req_words]" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert the global required words list", 'aiomatic-automatic-ai-content-writer');?>"><?php echo esc_textarea($global_req_words);?></textarea>
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to require only one word from the 'Required Words List' for the post to be accepted.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Require Only One Word From The 'Required Words List':", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="require_only_one" name="aiomatic_Main_Settings[require_only_one]"<?php
                     if ($require_only_one == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the banned words list that will apply to all plugin rules.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Global Banned Words List:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <textarea rows="3" cols="70" name="aiomatic_Main_Settings[global_ban_words]" class="cr_width_full" placeholder="<?php echo esc_html__("Please insert the global banned words list", 'aiomatic-automatic-ai-content-writer');?>"><?php echo esc_textarea($global_ban_words);?></textarea>
               </div>
            </td>
         </tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Spin & Translate:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to automatically translate generated content using Google Translate?", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Translate Content To:", 'aiomatic-automatic-ai-content-writer');?></b><br/><b><?php echo esc_html__("Info:", 'aiomatic-automatic-ai-content-writer');?></b> <?php echo esc_html__("for translation, the plugin also supports WPML.", 'aiomatic-automatic-ai-content-writer');?> <b><a href="https://wpml.org/?aid=238195&affiliate_key=ix3LsFyq0xKz" target="_blank"><?php echo esc_html__("Get WPML now!", 'aiomatic-automatic-ai-content-writer');?></a></b>
               </div>
            </th>
            <td>
               <div>
                  <select id="translate" name="aiomatic_Main_Settings[translate]"  class="cr_width_full">
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                           echo '<option value="' . esc_html($language_codes[$i]) . '"';
                           if ($translate == $language_codes[$i]) {
                              echo ' selected';
                           }
                           echo '>' . esc_html($language_names[$i]) . '</option>';
                           $i++;
                     }
                     if($deepl_auth != '')
                     {
                           $i = 0;
                           foreach ($language_names_deepl as $lang) {
                              echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                              if ($translate == $language_codes_deepl[$i]) {
                                 echo ' selected';
                              }
                              echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                              $i++;
                           }
                     }
                     if($bing_auth != '')
                     {
                           $i = 0;
                           foreach ($language_names_bing as $lang) {
                              echo '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                              if ($translate == $language_codes_bing[$i]) {
                                 echo ' selected';
                              }
                              echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                              $i++;
                           }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the source language of the translation.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Translation Source Language:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <select id="translate_source" name="aiomatic_Main_Settings[translate_source]"  class="cr_width_full">
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                           echo '<option value="' . esc_html($language_codes[$i]) . '"';
                           if ($translate_source == $language_codes[$i]) {
                              echo ' selected';
                           }
                           echo '>' . esc_html($language_names[$i]) . '</option>';
                           $i++;
                     }
                     if($deepl_auth != '')
                     {
                           $i = 0;
                           foreach ($language_names_deepl as $lang) {
                              echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                              if ($translate_source == $language_codes_deepl[$i]) {
                                 echo ' selected';
                              }
                              echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                              $i++;
                           }
                     }
                     if($bing_auth != '')
                     {
                           $i = 0;
                           foreach ($language_names_bing as $lang) {
                              echo '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                              if ($translate_source == $language_codes_bing[$i]) {
                                 echo ' selected';
                              }
                              echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                              $i++;
                           }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to automatically translate generated content a second time, to this final language? In some cases, this can replace word spinning of scraped content. Please note that this can increase the amount of requests made to the translation APIs. This field has no effect if you don't set also a first translation language, in the settings field from above.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Also A Second Translation To:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <select class="cr_width_full" id="second_translate" name="aiomatic_Main_Settings[second_translate]" >
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                         echo '<option value="' . esc_html($language_codes[$i]) . '"';
                         if ($second_translate == $language_codes[$i]) {
                             echo ' selected';
                         }
                         echo '>' . esc_html($language_names[$i]) . '</option>';
                         $i++;
                     }
                     if($deepl_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_deepl as $lang) {
                             echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                             if ($second_translate == $language_codes_deepl[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                             $i++;
                         }
                     }
                     if($bing_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_bing as $lang) {
                             echo '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                             if ($second_translate == $language_codes_bing[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                             $i++;
                         }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div id="bestspin">
                  <p><?php echo esc_html__("Don't have an 'The Best Spinner' account yet? Click here to get one:", 'aiomatic-automatic-ai-content-writer');?> <b><a href="https://paykstrt.com/10313/38910" target="_blank"><?php echo esc_html__("get a new account now!", 'aiomatic-automatic-ai-content-writer');?></a></b></p>
               </div>
               <div id="wordai">
                  <p><?php echo esc_html__("Don't have an 'WordAI' account yet? Click here to get one:", 'aiomatic-automatic-ai-content-writer');?> <b><a href="https://wordai.com/?ref=h17f4" target="_blank"><?php echo esc_html__("get a new account now!", 'aiomatic-automatic-ai-content-writer');?></a></b></p>
               </div>
               <div id="spinrewriter">
                  <p><?php echo esc_html__("Don't have an 'SpinRewriter' account yet? Click here to get one:", 'aiomatic-automatic-ai-content-writer');?> <b><a href="https://www.spinrewriter.com/?ref=24b18" target="_blank"><?php echo esc_html__("get a new account now!", 'aiomatic-automatic-ai-content-writer');?></a></b></p>
               </div>
               <div id="spinnerchief">
                  <p><?php echo esc_html__("Don't have an 'SpinnerChief' account yet? Click here to get one:", 'aiomatic-automatic-ai-content-writer');?> <b><a href="http://www.whitehatbox.com/Agents/SSS?code=iscpuQScOZMi3vGFhPVBnAP5FyC6mPaOEshvgU4BbyoH8ftVRbM3uQ==" target="_blank"><?php echo esc_html__("get a new account now!", 'aiomatic-automatic-ai-content-writer');?></a></b></p>
               </div>
               <div id="contentprofessor">
                  <p><?php echo esc_html__("Don't have an 'ContentProfessor' account yet? Click here to get one:", 'aiomatic-automatic-ai-content-writer');?> <b><a href="http://www.contentprofessor.com/go.php?offer=kisded&pid=2" target="_blank"><?php echo esc_html__("get a new account now!", 'aiomatic-automatic-ai-content-writer');?></a></b></p>
               </div>
               <div id="chimprewriter">
                  <p><?php echo esc_html__("Don't have an 'ChimpRewriter' account yet? Click here to get one:", 'aiomatic-automatic-ai-content-writer');?> <b><a href="https://coderevolution--chimprewriter.thrivecart.com/chimp-rewriter-monthly/" target="_blank"><?php echo esc_html__("get a new account now!", 'aiomatic-automatic-ai-content-writer');?></a></b></p>
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Spin Text Using Word Synonyms (for automatically generated posts only):", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <select id="spin_text" name="aiomatic_Main_Settings[spin_text]" onchange="mainChanged()" class="cr_width_full">
            <option value="disabled"
               <?php
                  if ($spin_text == 'disabled') {
                        echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="best"
               <?php
                  if ($spin_text == 'best') {
                        echo ' selected';
                  }
                  ?>
               >The Best Spinner - <?php echo esc_html__("High Quality - Paid", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="wordai"
               <?php
                  if($spin_text == 'wordai')
                           {
                              echo ' selected';
                           }
                  ?>
               >Wordai - <?php echo esc_html__("High Quality - Paid", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="spinrewriter"
               <?php
                  if($spin_text == 'spinrewriter')
                           {
                              echo ' selected';
                           }
                  ?>
               >SpinRewriter - <?php echo esc_html__("High Quality - Paid", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="spinnerchief"
               <?php
                  if($spin_text == 'spinnerchief')
                           {
                              echo ' selected';
                           }
                  ?>
               >SpinnerChief - <?php echo esc_html__("High Quality - Paid", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="chimprewriter"
               <?php
                  if($spin_text == 'chimprewriter')
                           {
                              echo ' selected';
                           }
                  ?>
               >ChimpRewriter - <?php echo esc_html__("High Quality - Paid", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="contentprofessor"
               <?php
                  if($spin_text == 'contentprofessor')
                           {
                              echo ' selected';
                           }
                  ?>
               >ContentProfessor - <?php echo esc_html__("High Quality - Paid", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="builtin"
               <?php
                  if ($spin_text == 'builtin') {
                        echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Built-in - Medium Quality - Free", 'aiomatic-automatic-ai-content-writer');?></option>
            </select>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable Spinner For:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
            <select id="spin_what" name="aiomatic_Main_Settings[spin_what]" onchange="mainChanged()" class="cr_width_full">
            <option value="all"
               <?php
                  if ($spin_what == 'all') {
                        echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Bulk Posters & OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="bulk"
               <?php
                  if ($spin_what == 'bulk') {
                        echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Bulk Posters", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="omni"
               <?php
                  if($spin_what == 'omni')
                  {
                     echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></option>
            </select>
            </td>
         </tr>
         <tr class="hideSpinRewriterSpecific">
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to not spin title (only content)?", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable The Best Spinner Humanize AI Usage:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="best_humanize" name="aiomatic_Main_Settings[best_humanize]"<?php
                     if ($best_humanize == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to not spin title (only content)?", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Spin Title, Only Content:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_title" name="aiomatic_Main_Settings[no_title]"<?php
                     if ($no_title == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select a list of comma separated words that you do not wish to spin (only for built-in spinners).", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Excluded Word List (For Built-In Spinner Only):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div>
                  <input type="text" name="aiomatic_Main_Settings[exclude_words]" value="<?php
                     echo esc_html($exclude_words);
                     ?>" placeholder="<?php echo esc_html__("word1, word2, word3", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div class="hideBest">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert your user name on premium spinner service.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Premium Spinner Service User Name/Email:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div class="hideBest">
                  <input type="text" name="aiomatic_Main_Settings[best_user]" value="<?php
                     echo esc_html($best_user);
                     ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service user name", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
               </div>
            </td>
         </tr>
         <tr>
            <th>
               <div class="hideBest">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert your password for the selected premium spinner service.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Premium Spinner Service Password/API Key:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </th>
            <td>
               <div class="hideBest">
                  <input type="password" autocomplete="off" name="aiomatic_Main_Settings[best_password]" value="<?php
                     echo esc_html($best_password);
                     ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service password", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
               </div>
            </td>
         </tr>
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Notification Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select an email address where a notification will be sent, in case a specific rule depleted its keywords and it did not publish any new content because of this. This will be applied only if you check the 'Process Each Title/Topic Only Once' checkbox in rules. You can enter a comma separated list of email addresses which will be notified.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Send An Email Notification When A Specific Rule Has Depleted Its Keywords/Topics:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" name="aiomatic_Main_Settings[email_notification]" value="<?php
                              echo esc_html($email_notification);
                              ?>" placeholder="your_email@yoursite.com,your_email2@yoursite.com" class="cr_width_full">
                        </div>
                     </td>
                  </tr>
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("WooCommerce Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select if you want to create External WooCommerce Products in the 'Amazon Product Review' Bulk Post Creator. To enable this functionality, you also need to select the 'product' post type in rule settings, in the 'Amazon Product Review' menu of the plugin, for created rules.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Create External WooCommerce Products In 'Amazon Product Review':", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="external_products" name="aiomatic_Main_Settings[external_products]"<?php
                     if ($external_products == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
         <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Advanced Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("If you check this checkbox, all prompts which are used in the plugin will be processed as they are, in a single bulk text block, regardless of new lines from their content. If the checkbox is unchecked, a random prompt will be selected at each run, from the entered prompt lines, based on new lines from the text (like this, you will be able to enter multiple prompts from which the plugin will select a random one at each run).", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Prompt Processing - Bulk Or Random Selection:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="whole_prompt" name="aiomatic_Main_Settings[whole_prompt]"<?php
                     if ($whole_prompt == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("If you want to create long content (over 10000 words) in a single post and you are getting undesired results, you can check this checkbox for a fix.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Use Alternate Continue Tokens (Experimental):", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="alternate_continue" name="aiomatic_Main_Settings[alternate_continue]"<?php
                     if ($alternate_continue == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("When using the 'Title Based Posting' mode, if you set the 'AI Content Minimum Character Count' settings field to a large character count, this you add a prompt completion here, it will be prepended to the text which is sent to the AI writer, for continuation..", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Preppend Text To Prompts For Content Completion:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <textarea rows="3" cols="70" name="aiomatic_Main_Settings[continue_prepend]" class="cr_width_full" placeholder="<?php echo esc_html__("Prompt to prepend to text continuation requests", 'aiomatic-automatic-ai-content-writer');?>"><?php echo esc_textarea($continue_prepend);?></textarea>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("When using the 'Title Based Posting' mode, if you set the 'AI Content Minimum Character Count' settings field to a large character count, this you add a prompt completion here, it will be appended to the text which is sent to the AI writer, for continuation..", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Append Text To Prompts For Content Completion:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <textarea rows="3" cols="70" name="aiomatic_Main_Settings[continue_append]" class="cr_width_full" placeholder="<?php echo esc_html__("Prompt to append to text continuation requests", 'aiomatic-automatic-ai-content-writer');?>"><?php echo esc_textarea($continue_append);?></textarea>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select if you want to convert new lines to <br> tags in created article content.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Convert New Lines To Line Breaks (br) In AI Generated Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="nlbr_parse" name="aiomatic_Main_Settings[nlbr_parse]"<?php
                     if ($nlbr_parse == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select if you want to use the Bing search results to get related headings for created articles.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Disable Bing Search Scraping To Get More Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="bing_off" name="aiomatic_Main_Settings[bing_off]"<?php
                     if ($bing_off == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select if you want to use the AI writer to get related headings for created articles.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Disable AI Writer Usage To Get More Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="ai_off" name="aiomatic_Main_Settings[ai_off]"<?php
                     if ($ai_off == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select if you want to disable the post content processing, to remove the <pre><code> tags added by AI models. These tags can be generated by some models by mistake and the plugin can automatically convert them to correct HTML content. If you want to keep <pre><code> tags intact, check this checkbox. This can be useful if you instruct the AI to create coding examples or different other code related content.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Disable Post Content Processing To Remove <pre><code> Tags:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="pre_code_off" name="aiomatic_Main_Settings[pre_code_off]"<?php
                     if ($pre_code_off == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
      </table> 
        </div>
        <div id="tab-13<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<?php
if($pinecone_app_id != '' || $qdrant_app_id != '')
{
?>
<h3><?php echo esc_html__('Embeddings Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Embeddings' tab allows you to manage and configure settings for generating and using content embeddings to enhance the AI content generated by the plugin.", 'aiomatic-automatic-ai-content-writer');
?></p>
<h2><?php echo esc_html__("More details about Embeddings, check ", 'aiomatic-automatic-ai-content-writer');?><a href="<?php echo admin_url('admin.php?page=aiomatic_embeddings_panel');?>"><?php echo esc_html__("the 'AI Embeddings' settings page", 'aiomatic-automatic-ai-content-writer');?>.</a></h2>
        <table class="widefat">
               <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Main AI Embeddings Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
               <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the embeddings API which will be used by default.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Default Embeddings API To Use:", 'aiomatic-automatic-ai-content-writer');?></b>
               </th>
               <td>
               <select id="embeddings_api" name="aiomatic_Main_Settings[embeddings_api]"  class="cr_width_full">
                     <option value="pinecone"<?php
                        if ($embeddings_api == "pinecone") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Pinecone", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="qdrant"<?php
                        if ($embeddings_api == "qdrant") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Qdrant", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Additional Embeddings Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr <?php
if($embeddings_api == 'qdrant')
{
   echo 'class="cr_display_none"';
}
?> >
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("After creating your Pinecone API, create a new index. Make sure to set your dimension to 1536 and also make sure to set your metric to cosine. Enter the generated index ID here.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Pinecone Index:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="text" placeholder="mytestingindex-28cc276.svc.us-east1-gcp.pinecone.io" name="aiomatic_Main_Settings[pinecone_index]" value="<?php echo esc_html($pinecone_index);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr <?php
if($embeddings_api == 'qdrant')
{
   echo 'class="cr_display_none"';
}
?> >
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("After creating your Pinecone API, create a new namespace (optional).", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Pinecone Namespace:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="text" placeholder="Pinecone namespace" name="aiomatic_Main_Settings[pinecone_namespace]" value="<?php echo esc_html($pinecone_namespace);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr <?php
if($embeddings_api == '' || $embeddings_api == 'pinecone')
{
   echo 'class="cr_display_none"';
}
?> >
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("After creating your Qdrant_index API, create a new index. Make sure to set your dimension to 1536 and also make sure to set your metric to cosine. Enter the generated index ID here.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Qdrant Index URL:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="text" placeholder="29331ee6-e231-409a-b72c-3a1ee4f814d0.europe-west3-0.gcp.cloud.qdrant.io:6333" name="aiomatic_Main_Settings[qdrant_index]" value="<?php echo esc_html($qdrant_index);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr <?php
if($embeddings_api == '' || $embeddings_api == 'pinecone')
{
   echo 'class="cr_display_none"';
}
?> >
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Add a name for your Qdrant collection. This is optional. The default value for this is: qdrant", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Qdrant Collection Name (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="text" placeholder="Collection name" name="aiomatic_Main_Settings[qdrant_name]" value="<?php echo esc_html($qdrant_name);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("The number of results to return for each query.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Number Of Results To Query:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="number" min="1" max="10000" step="1" placeholder="1" name="aiomatic_Main_Settings[pinecone_topk]" value="<?php echo esc_html($pinecone_topk);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the model you want to use for embeddings.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Embeddings Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="embeddings_model" name="aiomatic_Main_Settings[embeddings_model]" class="cr_width_full">
<?php
$all_embeddings = AIOMATIC_EMBEDDINGS_MODELS;
if (isset($aiomatic_Main_Settings['app_id_google']) && trim($aiomatic_Main_Settings['app_id_google']) != '')
{
   $all_embeddings = array_merge($all_embeddings, AIOMATIC_GOOGLE_EMBEDDINGS_MODELS);
}
foreach($all_embeddings as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($embeddings_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx);
if(in_array($modelx, AIOMATIC_GOOGLE_EMBEDDINGS_MODELS))
{
   echo ' (Google)';
}
echo '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Enable embeddings for which parts of the plugin.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Enable Embeddings For:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="checkbox" id="embeddings_single" name="aiomatic_Main_Settings[embeddings_single]"<?php
                        if ($embeddings_single == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_single"><?php echo esc_html__("Single AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="embeddings_bulk" onchange="embeddingsChanged();" name="aiomatic_Main_Settings[embeddings_bulk]"<?php
                        if ($embeddings_bulk == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk"><?php echo esc_html__("Bulk AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                     <div class="hideEmbeddingsContent">
                        <input type="checkbox" id="embeddings_bulk_title" name="aiomatic_Main_Settings[embeddings_bulk_title]"<?php
                        if ($embeddings_bulk_title == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_title"><?php echo esc_html__("Bulk AI Post Creator - Title Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                           <input type="checkbox" id="embeddings_bulk_sections" name="aiomatic_Main_Settings[embeddings_bulk_sections]"<?php
                        if ($embeddings_bulk_sections == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_sections"><?php echo esc_html__("Bulk AI Post Creator - Sections Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        <input type="checkbox" id="embeddings_bulk_intro" name="aiomatic_Main_Settings[embeddings_bulk_intro]"<?php
                        if ($embeddings_bulk_intro == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_intro"><?php echo esc_html__("Bulk AI Post Creator - Intro Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        <input type="checkbox" id="embeddings_bulk_content" name="aiomatic_Main_Settings[embeddings_bulk_content]"<?php
                        if ($embeddings_bulk_content == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_content"><?php echo esc_html__("Bulk AI Post Creator - Content Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        <input type="checkbox" id="embeddings_bulk_qa" name="aiomatic_Main_Settings[embeddings_bulk_qa]"<?php
                        if ($embeddings_bulk_qa == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_qa"><?php echo esc_html__("Bulk AI Post Creator - QA Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        <input type="checkbox" id="embeddings_bulk_outro" name="aiomatic_Main_Settings[embeddings_bulk_outro]"<?php
                        if ($embeddings_bulk_outro == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_outro"><?php echo esc_html__("Bulk AI Post Creator - Outro Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        <input type="checkbox" id="embeddings_bulk_excerpt" name="aiomatic_Main_Settings[embeddings_bulk_excerpt]"<?php
                        if ($embeddings_bulk_excerpt == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_bulk_excerpt"><?php echo esc_html__("Bulk AI Post Creator - Excerpt Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                     </div>
                     <input type="checkbox" id="embeddings_edit" name="aiomatic_Main_Settings[embeddings_edit]"<?php
                        if ($embeddings_edit == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_edit"><?php echo esc_html__("Content Editing", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="embeddings_chat_short" name="aiomatic_Main_Settings[embeddings_chat_short]"<?php
                        if ($embeddings_chat_short == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_chat_short"><?php echo esc_html__("Chatbot Shortcodes", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        
                     <input type="checkbox" id="embeddings_article_short" name="aiomatic_Main_Settings[embeddings_article_short]"<?php
                        if ($embeddings_article_short == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_article_short"><?php echo esc_html__("Text Completion Shortcodes", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                     
                     <input type="checkbox" id="embeddings_edit_short" name="aiomatic_Main_Settings[embeddings_edit_short]"<?php
                        if ($embeddings_edit_short == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_edit_short"><?php echo esc_html__("Text Editing Shortcode", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="embeddings_related" name="aiomatic_Main_Settings[embeddings_related]"<?php
                        if ($embeddings_related == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_related"><?php echo esc_html__("Related Questions Creation", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="embeddings_assistant" name="aiomatic_Main_Settings[embeddings_assistant]"<?php
                        if ($embeddings_assistant == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="embeddings_assistant"><?php echo esc_html__("Content Wizard", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="embeddings_forms" name="aiomatic_Main_Settings[embeddings_forms]"<?php
                        if ($embeddings_forms == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_forms"><?php echo esc_html__("AI Forms", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="embeddings_omni" name="aiomatic_Main_Settings[embeddings_omni]"<?php
                        if ($embeddings_omni == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="embeddings_omni"><?php echo esc_html__("AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                  </div>
               </td>
            </tr>
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Embeddings Auto Indexing Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
            <tr>
                     <th>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the post types for which you want to enable embeddings auto indexing.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Embeddings Auto Indexing For Newly Published:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                        <select autocomplete="off" id="index_types" multiple name="aiomatic_Main_Settings[index_types][]" class="cr_width_full">
                        <?php
                           foreach ( get_post_types( '', 'names' ) as $tpost_type ) {
                              if(strstr($tpost_type, 'aiomatic_'))
                              {
                                 continue;
                              }
                              echo '<option value="' . esc_attr($tpost_type) . '"';
                              if(in_array($tpost_type, $index_types))
                              {
                                    echo ' selected';
                              }
                              echo '>' . esc_html($tpost_type) . '</option>';
                           }
                           ?>
                        </select>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Embeddings Template Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the template of the embedding which will be saved in the database. You can use the following shortcodes: %%post_title%%, %%post_content%%, %%post_excerpt%%, %%post_url%%, %%post_id%%. The default value of this field is: %%post_title%% -- %%post_excerpt%% -- Read more at: %%post_url%%", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Auto Created Embeddings Template:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <textarea rows="8" cols="70" id="embedding_template" class="cr_width_full" name="aiomatic_Main_Settings[embedding_template]" placeholder="<?php echo esc_html__("Set a template to use for auto created embeddings", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($embedding_template);
                        ?></textarea>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("AI Embeddings Optimization Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to rewrite content using AI before sending it to the embedding?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Optimize The %%post_content%% Shortcode Using AI:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="rewrite_embedding" onchange="embChanged();" name="aiomatic_Main_Settings[rewrite_embedding]"<?php
                     if ($rewrite_embedding == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr class="hideEmb">
                     <th>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to rewrite content using AI before sending it to the embedding? This will rewrite the %%post_content%% in the 'Embedding Template' settings field - so be sure to use the %%post_content%% shortcode in the 'Embedding Template' settings field, if you are wanting to optimize the content for it using this feature. You can use the following shortcodes: %%post_title%%, %%post_content%%, %%post_excerpt%%, %%post_url%%, %%post_id%%. The default value of this field is: Revise the given content concisely, preserving its style and information, while ensuring the revised text stays within 300 words. Each paragraph should range between 60 to 120 words. Exclude non-textual elements and unnecessary repetition. Conclude with a statement directing readers to find more information at %%post_url%%. If these guidelines cannot be met, send an empty response. The content is as follows: %%post_content%%", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Embedding Content Rewriter Prompt (%%post_content%%):", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <textarea rows="8" cols="70" id="embedding_rw_prompt" class="cr_width_full" name="aiomatic_Main_Settings[embedding_rw_prompt]" placeholder="<?php echo esc_html__("Add your embedding rewriter prompt", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($embedding_rw_prompt);
                        ?></textarea>
                     </td>
                  </tr><tr class="hideEmb">
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="emb_assistant_id" name="aiomatic_Main_Settings[emb_assistant_id]" class="cr_width_full" onchange="assistantSelected('emb_assistant_id', 'disableEmb');">
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
        if($emb_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($emb_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
                  <tr class="hideEmb">
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the model you want to use for embedding content rewriting and optimizing.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Embedding Content Rewriter Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="embedding_rw_model" name="aiomatic_Main_Settings[embedding_rw_model]" <?php if($emb_assistant_id != ''){echo ' disabled';}?> class="disableEmb cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($embedding_rw_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>  
                        </div>
                     </td>
                  </tr>
         </table>
<?php
}
else
{
   echo '<h2=>' . esc_html__("You need to enter a Pinecone.io API or a Qdrant API key in the 'API Keys' tab and save settings, to use this feature.", 'aiomatic-automatic-ai-content-writer') . '</h2>';
}
?>
        </div>
        <div id="tab-14<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('AI Internet Access Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'AI Internet Access' tab enables you to configure and manage the internet connectivity settings for AI functionalities, ensuring your WordPress site's AI tools can access online data and services securely.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Main AI Internet Access Settings", 'aiomatic-automatic-ai-content-writer');?>&nbsp;(<a href="https://www.youtube.com/watch?v=5XjYjXG_uF8" target="_blank"><?php echo esc_html__("check this feature's tutorial", 'aiomatic-automatic-ai-content-writer');?></a>):</h2></td></tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Modify the prompt for the AI writer, using the below template, adding also information extracted from the internet. You can use the following shortcodes: %%original_query%% (to add the original search query), %%current_date%% (to add the current date), %%web_results%% (to add the search query results).", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Modify Prompt For the AI Writer Using Internet Search Results:", 'aiomatic-automatic-ai-content-writer');?></b><br/><input type="button" onclick="populate_default_internet();" value="<?php echo esc_html__("Restore To Default", 'aiomatic-automatic-ai-content-writer');?>">
                  </div>
               </th>
               <td>
                  <div>
                  <textarea rows="8" cols="70" id="internet_prompt" class="cr_width_full" name="aiomatic_Main_Settings[internet_prompt]" placeholder="<?php echo esc_html__("Add the edited prompt", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($internet_prompt);
                        ?></textarea>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Modify the template of the %%web_results%% shortcode. You will be able to use the following shortcodes: %%result_counter%% (to add the index of the current result), %%result_title%% (to add the title of the current result), %%result_snippet%% (to add the snippet of the current result), %%result_link%% (to add the URL of the current result). The default value for this settings field is: [%%result_counter%%]: %%result_title%% %%result_snippet%% URL: %%result_link%%", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Template For the %%web_results%% Shortcode:", 'aiomatic-automatic-ai-content-writer');?></b><br/><input type="button" onclick="populate_default_template();" value="<?php echo esc_html__("Restore To Default", 'aiomatic-automatic-ai-content-writer');?>">
                  </div>
               </th>
               <td>
                  <div>
                  <textarea rows="2" cols="70" id="internet_single_template" class="cr_width_full" name="aiomatic_Main_Settings[internet_single_template]" placeholder="<?php echo esc_html__("Add the %%web_results%% shortcode template", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($internet_single_template);
                        ?></textarea>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Prompt to use for keyword/keyphrase extraction from the submitted text (so the internet search will be more probable to return related results to the query sent to the AI). You can use the following shortcode here: %%original_prompt%%. The default value for this settings is: Using which keyword or phrase should I search the internet, so I get results related to the following text? Give me only a single search phrase or keyword, don't write anything else. The text is: \"%%original_prompt%%\"?", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Keyword Extractor Prompt (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                  <textarea rows="3" cols="70" id="keyword_extractor_prompt" class="cr_width_full" name="aiomatic_Main_Settings[keyword_extractor_prompt]" placeholder="<?php echo esc_html__("Using which keyword or phrase should I search the internet, so I get results related to the following text? Give me only a single search phrase or keyword, don't write anything else. The text is: \"%%original_prompt%%\"?", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($keyword_extractor_prompt);
                        ?></textarea>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Specifying this parameter should lead to more relevant results for a specific country. This is particularly true for international customers and, even more specifically, for customers in English- speaking countries other than the United States. To restrict search results only to websites located in a specific country, specify this parameter as: countryDE - replace DE with your own 2 letter country code", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Search Results Location (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="text" id="internet_gl" placeholder="<?php echo esc_html__("2 letter country code", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[internet_gl]" value="<?php echo esc_html($internet_gl);?>" class="cr_width_full"/>
                  </div>
               </td>
            </tr>
            <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="internet_assistant_id" name="aiomatic_Main_Settings[internet_assistant_id]" class="cr_width_full" onchange="assistantSelected('internet_assistant_id', 'disableInternet');">
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
        if($internet_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($internet_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the model you want to use for keyword extraction, for internet search results.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Keyword Extractor Model (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <select id="internet_model" name="aiomatic_Main_Settings[internet_model]" <?php if($internet_assistant_id != ''){echo ' disabled';}?> class="disableInternet cr_width_full">
<?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($internet_model == $modelx) 
{
   echo " selected";
}
echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                     </select>  
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div class="hideLog">
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the number of search results to add in the %%web_results%% shortcode. The default value for this settings is : 3", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Number Of Search Results To Add (In The %%web_results%% Shortcode):", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div class="hideLog">
                     <select id="results_num" name="aiomatic_Main_Settings[results_num]" class="cr_width_full">
                        <option value="1"<?php
                           if ($results_num == "1") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("1", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="2"<?php
                           if ($results_num == "2") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("2", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="3"<?php
                           if ($results_num == "3") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("3", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="4"<?php
                           if ($results_num == "4") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("4", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="5"<?php
                           if ($results_num == "5") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("5", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="6"<?php
                           if ($results_num == "6") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("6", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="7"<?php
                           if ($results_num == "7") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("7", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="8"<?php
                           if ($results_num == "8") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("8", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="9"<?php
                           if ($results_num == "9") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("9", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="10"<?php
                           if ($results_num == "10") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("10", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select>
                  </div>
               </td>
            </tr>
            <tr>
               <th>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Enable AI internet access for the following features of the plugin.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Enable AI Internet Access For:", 'aiomatic-automatic-ai-content-writer');?></b>
                  </div>
               </th>
               <td>
                  <div>
                     <input type="checkbox" id="internet_single" name="aiomatic_Main_Settings[internet_single]"<?php
                        if ($internet_single == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="internet_single"><?php echo esc_html__("Single AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="internet_bulk" onchange="internetChanged();" name="aiomatic_Main_Settings[internet_bulk]"<?php
                        if ($internet_bulk == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="internet_bulk"><?php echo esc_html__("Bulk AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        <div class="hideInternetContent">
                           <input type="checkbox" id="internet_bulk_title" name="aiomatic_Main_Settings[internet_bulk_title]"<?php
                           if ($internet_bulk_title == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_title"><?php echo esc_html__("Bulk AI Post Creator - Title Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                              <input type="checkbox" id="internet_bulk_sections" name="aiomatic_Main_Settings[internet_bulk_sections]"<?php
                           if ($internet_bulk_sections == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_sections"><?php echo esc_html__("Bulk AI Post Creator - Sections Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                           <input type="checkbox" id="internet_bulk_intro" name="aiomatic_Main_Settings[internet_bulk_intro]"<?php
                           if ($internet_bulk_intro == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_intro"><?php echo esc_html__("Bulk AI Post Creator - Intro Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                           <input type="checkbox" id="internet_bulk_content" name="aiomatic_Main_Settings[internet_bulk_content]"<?php
                           if ($internet_bulk_content == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_content"><?php echo esc_html__("Bulk AI Post Creator - Content Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                           <input type="checkbox" id="internet_bulk_qa" name="aiomatic_Main_Settings[internet_bulk_qa]"<?php
                           if ($internet_bulk_qa == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_qa"><?php echo esc_html__("Bulk AI Post Creator - QA Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                           <input type="checkbox" id="internet_bulk_outro" name="aiomatic_Main_Settings[internet_bulk_outro]"<?php
                           if ($internet_bulk_outro == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_outro"><?php echo esc_html__("Bulk AI Post Creator - Outro Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                           <input type="checkbox" id="internet_bulk_excerpt" name="aiomatic_Main_Settings[internet_bulk_excerpt]"<?php
                           if ($internet_bulk_excerpt == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_bulk_excerpt"><?php echo esc_html__("Bulk AI Post Creator - Excerpt Prompts", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        </div>
                     <input type="checkbox" id="internet_edit" name="aiomatic_Main_Settings[internet_edit]"<?php
                        if ($internet_edit == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="internet_edit"><?php echo esc_html__("Content Editing", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="internet_chat_short" name="aiomatic_Main_Settings[internet_chat_short]"<?php
                        if ($internet_chat_short == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="internet_chat_short"><?php echo esc_html__("Chatbot Shortcodes", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                        
                     <input type="checkbox" id="internet_article_short" name="aiomatic_Main_Settings[internet_article_short]"<?php
                        if ($internet_article_short == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="internet_article_short"><?php echo esc_html__("Text Completion Shortcodes", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                     
                     <input type="checkbox" id="internet_edit_short" name="aiomatic_Main_Settings[internet_edit_short]"<?php
                        if ($internet_edit_short == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="internet_edit_short"><?php echo esc_html__("Text Editing Shortcode", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="internet_related" name="aiomatic_Main_Settings[internet_related]"<?php
                        if ($internet_related == 'on')
                            echo ' checked ';
                        ?>>
                        <label for="internet_related"><?php echo esc_html__("Related Questions Creation", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="internet_assistant" name="aiomatic_Main_Settings[internet_assistant]"<?php
                        if ($internet_assistant == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="internet_assistant"><?php echo esc_html__("Content Wizard", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                     <input type="checkbox" id="internet_forms" name="aiomatic_Main_Settings[internet_forms]"<?php
                        if ($internet_forms == 'on')
                           echo ' checked ';
                        ?>>
                        <label for="internet_forms"><?php echo esc_html__("AI Forms", 'aiomatic-automatic-ai-content-writer');?></label><br/>

                        <input type="checkbox" id="internet_omni" name="aiomatic_Main_Settings[internet_omni]"<?php
                           if ($internet_omni == 'on')
                              echo ' checked ';
                           ?>>
                           <label for="internet_omni"><?php echo esc_html__("AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></label><br/>
                  </div>
               </td>
            </tr>
        <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr><tr>
        <td class="coderevolution_block_input" colspan="2">
<iframe class="youtube-responsive" src="https://www.youtube.com/embed/5XjYjXG_uF8" frameborder="0" allowfullscreen></iframe>
   </td></tr>
         </table>
        </div>
        <div id="tab-7<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Plugin General Settings', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'General Settings' tab allows you to configure advanced options and preferences that affect the overall operation of the plugin.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
            <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Basic Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable logging for rules?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Logging for Rules:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="enable_logging" onclick="mainChanged();" name="aiomatic_Main_Settings[enable_logging]"<?php
                     if ($enable_logging == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="hideLog">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable detailed logging for rules? Note that this will dramatically increase the size of the log this plugin generates.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Detailed Logging for Rules:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div class="hideLog">
                  <label class="aiomatic-switch"><input type="checkbox" id="enable_detailed_logging" name="aiomatic_Main_Settings[enable_detailed_logging]"<?php
                     if ($enable_detailed_logging == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="hideLog">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to automatically clear logs after a period of time.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Automatically Clear Logs After:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div class="hideLog">
                           <select id="auto_clear_logs" name="aiomatic_Main_Settings[auto_clear_logs]" class="cr_width_full">
                              <option value="No"<?php
                                 if ($auto_clear_logs == "No") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="monthly"<?php
                                 if ($auto_clear_logs == "monthly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a month", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="weekly"<?php
                                 if ($auto_clear_logs == "weekly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a week", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="daily"<?php
                                 if ($auto_clear_logs == "daily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a day", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="twicedaily"<?php
                                 if ($auto_clear_logs == "twicedaily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Twice a day", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="hourly"<?php
                                 if ($auto_clear_logs == "hourly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once an hour", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, input it's address here. Required format: IP Address/URL:port. You can input a comma separated list of proxies.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Address List:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" id="proxy_url" placeholder="<?php echo esc_html__("Input web proxy url", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[proxy_url]" value="<?php echo esc_html($proxy_url);?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, and it requires authentification, input it's authentification details here. Required format: username:password. You can input a comma separated list of users/passwords. If a proxy does not have a user/password, please leave it blank in the list. Example: user1:pass1,user2:pass2,,user4:pass4.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Authentication:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="text" id="proxy_auth" placeholder="<?php echo esc_html__("Input web proxy auth", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[proxy_auth]" value="<?php echo esc_html($proxy_auth);?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to use the above proxies also when accessing OpenAI API? Otherwise, they will be used for Amazon product scraping / image downloading only.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use Proxies Also For OpenAI API Accessing:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="proxy_ai" name="aiomatic_Main_Settings[proxy_ai]"<?php
                     if ($proxy_ai == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the timeout (in seconds) for every rule running and also for automatic post editing. I recommend that you leave this field at it's default value (3600).", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout for Processing (seconds):", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" id="rule_timeout" step="1" min="0" placeholder="<?php echo esc_html__("Input rule timeout in seconds", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[rule_timeout]" value="<?php
                              echo esc_html($rule_timeout);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Width:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="aiomatic_Main_Settings[resize_width]" value="<?php echo esc_html($resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desired width for featured images", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="aiomatic_Main_Settings[resize_height]" value="<?php echo esc_html($resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desired height for featured images", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the quality of the resized images. Accepted values: 1-100. 1 is lowest quality, 100 is highest quality. If you want to disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Quality:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" max="100" name="aiomatic_Main_Settings[resize_quality]" value="<?php echo esc_html($resize_quality);?>" placeholder="<?php echo esc_html__("Resize quality", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to disable the AI content detector fooling method of the plugin? This will leave the AI content as it is, in an unchanged form.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Don't Try To Fool AI Detectors (Disable Content Tricks):", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_undetectibility" name="aiomatic_Main_Settings[no_undetectibility]"<?php
                     if ($no_undetectibility == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable swear word filtering for created content?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Swear Word Filtering:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="swear_filter" name="aiomatic_Main_Settings[swear_filter]"<?php
                     if ($swear_filter == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to disable the Media Library extension of the plugin?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Disable Media Library Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_media_library" name="aiomatic_Main_Settings[no_media_library]"<?php
                     if ($no_media_library == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder"><td colspan="2"><h2 class="aiomatic-inner-title"><?php echo esc_html__("Advanced Settings:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select if you want to convert markdown to HTML in AI generated content.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Convert Markdown To HTML In AI Generated Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="markdown_parse" name="aiomatic_Main_Settings[markdown_parse]"<?php
                     if ($markdown_parse == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to not remove the <pre><code> tags created by the AI writer?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Don't Remove <pre><code> Tags From AI Generated Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_pre_code_remove" name="aiomatic_Main_Settings[no_pre_code_remove]"<?php
                     if ($no_pre_code_remove == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to clear the OmniBlock processed keywords list at plugin deactivation?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Clear OmniBlock Processed Keywords List At Plugin Deactivation:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="clear_omni" name="aiomatic_Main_Settings[clear_omni]"<?php
                     if ($clear_omni == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to disable the rendering of shortcodes in OmniBlocks? Any shortcode which the AI will create, will be rendered on your website directly.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Disable Shortcode Rendering In OmniBlocks:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_omni_shortcode_render" name="aiomatic_Main_Settings[no_omni_shortcode_render]"<?php
                     if ($no_omni_shortcode_render == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum number of times the plugin will retry API calls in case they fail. This is useful, as in some cases OpenAI API is failing and a retry will work. To disable this feature, leave this field blank. This feature is currently not supported if the chatbot is in streaming mode.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("How Many Times To Retry API Calls In Case Of API Failure:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" id="max_retry" step="1" min="0" placeholder="<?php echo esc_html__("API retry max count", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[max_retry]" value="<?php
                              echo esc_html($max_retry);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum number of times the plugin will retry chat API calls in case the AI writer considers the chat as ended. Warning, this can consume more tokens, as it will retry API calls multiple times. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Chat End of Conversation Retry Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" id="max_chat_retry" step="1" min="0" placeholder="<?php echo esc_html__("Chat end API retry max count", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[max_chat_retry]" value="<?php
                              echo esc_html($max_chat_retry);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum number of seconds the plugin will wait for API requests. The default is 120 seconds.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout For API Requests (s):", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="number" id="max_timeout" step="1" min="0" placeholder="<?php echo esc_html__("API Requests Timeout", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Main_Settings[max_timeout]" value="<?php
                              echo esc_html($max_timeout);
                              ?>" class="cr_width_full"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("If you are using content editing which contain Chinese characters, you can try checking this checkbox.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Don't Send Maximum Tokens In API Request (Experimental):", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_max" name="aiomatic_Main_Settings[no_max]"<?php
                     if ($no_max == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("If you encounter issues while using the Single AI Post Creator Advanced Mode tab, check this checkbox.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Don't Use Jobs In The Advanced Mode Single AI Post Creator (Experimental):", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_jobs" name="aiomatic_Main_Settings[no_jobs]"<?php
                     if ($no_jobs == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("If you want to get maximum customizability for your shortcodes, check this checkbox. It will allow maximum customizability for content created by shortcodes.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Don't Use !important In Generated CSS For Shortcodes:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="not_important" name="aiomatic_Main_Settings[not_important]"<?php
                     if ($not_important == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
               </table>     
        </div>
        <div id="tab-8<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
        <h3><?php echo esc_html__('Royalty Free Image Options', 'aiomatic-automatic-ai-content-writer');?></h3>
            <p class="aiomatic-settings-desc"><?php
                                    echo esc_html__("The 'Royalty Free Images' tab offers access to settings of features of the plugin which offers access to a curated collection of copyright-free images, allowing you to enrich your WordPress site's content without licensing concerns.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
                  <tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Royalty Free Image Search Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you want to randomize the royalty free image sources order, at each run. If you check this checkbox, the above order will not be applied any more.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Do Not Randomize Royalty Free Source Order, But Use The Below Order: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input onchange="imgChanged();" type="checkbox" id="random_image_sources" name="aiomatic_Main_Settings[random_image_sources]"<?php
                     if ($random_image_sources == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr class="hideImgs">
                  <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select your prefered order in which you want to search royalty free image sources.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Royalty Free Image Search Order:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td> 
                  <?php
            $cards_order = get_option('aiomatic_image_cards_order', array());
            ?>
            <input type="hidden" id="sortable_cards" name="aiomatic_sortable_cards" value="<?php echo esc_attr(implode(',', $cards_order)); ?>">
            <ul id="aiomatic_roaylty_free_sortable" name="aiomatic_roaylty_free_sortable">
                <?php
                if(empty($cards_order))
                {
                   echo esc_html__('No Royalty Free Image Sources Enabled', 'aiomatic-automatic-ai-content-writer');
                }
                else
                {
                  foreach ($cards_order as $card_id) {
                     if(!empty($card_id))
                     {
                        echo '<li class="aisortable-card" id="' . esc_attr($card_id) . '">' . esc_html(ucfirst($card_id)) . '</li>';
                     }
                  }
               }
                ?>
            </ul>
               </td>
                        </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you want to randomize the search results order, of the returned images. This can lower the accuracy of images, but make images more unique.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Do Not Randomize Royalty Free Image Results Order: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="random_results_order" name="aiomatic_Main_Settings[random_results_order]"<?php
                     if ($random_results_order == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you want to try to translate search query keywords to English. This can be useful for non-English languages.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Try To Translate Search Query Keywords To English: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="image_query_translate_en" name="aiomatic_Main_Settings[image_query_translate_en]"<?php
                     if ($image_query_translate_en == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the maximum position of the images from the image search results. More relevant images are shown first in the royalty free image search results. Because of this, using here a number as low as 4 will make the plugin use only the first 4 image results which were returned by the royalty free image search. This can improve image precision. If you leave this field blank, the default value will be used: 4", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Eligible Images Rank At Most At Position: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <input type="number" min="1" step="1" placeholder="4" class="cr_width_full" name="aiomatic_Main_Settings[image_pool]" value="<?php echo esc_html($image_pool);?>">
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to improve royalty free image importing, using the below services. These will extract keywords from the original text and provide better image quality results. If you select TextRazor, you also need to enter a TextRazor API key below. If you select OpenAI, you also need to enter a prompt for OpenAI keyword extraction, below. To enable TextRazor to be selected, please enter an API key for TextRazor below.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Improve Royalty Free Featured Image Precision Using This Service:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="improve_keywords" name="aiomatic_Main_Settings[improve_keywords]" class="cr_width_full" >
                              <option value="disabled"<?php
                                 if ($improve_keywords == "disabled") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="textrazor"<?php
                                 if ($improve_keywords == "textrazor") {
                                     echo " selected";
                                 }
                                 if(empty($textrazor_key))
                                 {
                                    echo " disabled title='You need to add your API key in API Keys tab to use this feature'";
                                 }
                                 ?>><?php echo esc_html__("TextRazor", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="openai"<?php
                                 if ($improve_keywords == "openai") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__( "Set a prompt for generating a keyword for importing royalty free images for the created posts. You can also instruct the AI writer to return a comma separated list of keywords. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You can use something like: I need to find highly relevant royalty-free images for an article heading, please extract a comma-separated list of the most relevant single word keywords from the heading, prioritizing specific references over general keywords. Add the highest priority to the most specific keyword that is still related to the main topic. By doing so, you can help me find more appropriate and targeted images for the article heading. The blog post heading title is: \"%%post_title%%\".", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Prompt For OpenAI Keyword Generator For Royalty Free Image Importing:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                        <textarea rows="2" cols="70" class="cr_width_full" name="aiomatic_Main_Settings[keyword_prompts]" placeholder="<?php echo esc_html__("I need to find highly relevant royalty-free images for an article heading, please extract a comma-separated list of the most relevant single word keywords from the heading, prioritizing specific references over general keywords. Add the highest priority to the most specific keyword that is still related to the main topic. By doing so, you can help me find more appropriate and targeted images for the article heading. The blog post heading title is: \"%%post_title%%\".", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($keyword_prompts);
                        ?></textarea>
                        </div>
                     </td>
                  </tr>
         <tr>
        <th class="cr_min_width_200">
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the AI Assistant to be used. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
        </th>
        <td><select id="keyword_assistant_id" name="aiomatic_Main_Settings[keyword_assistant_id]" class="cr_width_full">
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
        if($keyword_assistant_id == '')
        {
            echo ' selected';
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if($keyword_assistant_id == $myassistant->ID)
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
        </td>
        </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the model you want to use for keyword extraction, for royalty free image importing.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Model For Keyword Extraction For Royalty Free Images:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select id="keyword_model" name="aiomatic_Main_Settings[keyword_model]" class="cr_width_full">
<?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   if ($keyword_model == $modelx) 
   {
       echo " selected";
   }
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                           </select>  
                        </div>
                     </td>
                  </tr>
                  <tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("More Royalty Free Image Search Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                  <tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Please set a the image attribution shortcode value. You can use this value, using the %%image_attribution%% shortcode, in 'Prepend Content With' and 'Append Content With' settings fields. You can use the following shortcodes, in this settings field: %%image_source_name%%, %%image_source_website%%, %%image_source_url%%. These will be updated automatically for the respective image source, from where the imported image is from. This will replace the %%royalty_free_image_attribution%% shortcode, in 'Generated Post Content' settings field.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Royalty Free Image Attribution Text (%%royalty_free_image_attribution%%): ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <input type="text" name="aiomatic_Main_Settings[attr_text]" value="<?php echo esc_html(stripslashes($attr_text));?>" placeholder="<?php echo esc_html__("Please insert image attribution text pattern", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to enable broad search for royalty free images?", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Enable broad image search: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="bimage" name="aiomatic_Main_Settings[bimage]"<?php
                     if ($bimage == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to not skip importing the aritcle if no royalty free image found for the post?", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Skip Importing of Article If No Free Image Found: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_royalty_skip" name="aiomatic_Main_Settings[no_royalty_skip]"<?php
                     if ($no_royalty_skip == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr><tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Pexels API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                  <tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Pexels App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Pexels API.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ),  "https://www.pexels.com/api/" );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://www.pexels.com/api/" target="_blank"><?php echo esc_html__("Pexels App ID:", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" autocomplete="off" name="aiomatic_Main_Settings[pexels_api]" value="<?php
                              echo esc_html($pexels_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Pexels API key", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">
                        </div>
                     </td>
                  </tr><tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Flickr API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( "Insert your Flickr App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Flickr API.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), "https://www.flickr.com/services/apps/create/apply" );
                                 ?>
                           </div>
                        </div>
                        <b><a href="https://www.flickr.com/services/apps/create/apply" target="_blank"><?php esc_html_e('Flickr App ID: ', 'aiomatic-automatic-ai-content-writer'); ?></a></b>
                     </th>
                     <td>
                        <input type="password" autocomplete="off"  name="aiomatic_Main_Settings[flickr_api]" placeholder="<?php echo esc_html__("Please insert your Flickr APP ID", 'aiomatic-automatic-ai-content-writer');?>" value="<?php if(isset($flickr_api)){echo esc_html($flickr_api);}?>" class="cr_width_full" />
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("The license id for photos to be searched.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Photo License: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[flickr_license]" class="cr_width_full">
                           <option value="-1" 
                              <?php
                                 if($flickr_license == '-1')
                                 {
                                     echo ' selected';
                                 }
                                 ?>
                              ><?php echo esc_html__("Do Not Search By Photo Licenses", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="0"
                              <?php
                                 if($flickr_license == '0')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("All Rights Reserved", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="1"
                              <?php
                                 if($flickr_license == '1')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial-ShareAlike License", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="2"
                              <?php
                                 if($flickr_license == '2')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial License", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="3"
                              <?php
                                 if($flickr_license == '3')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial-NoDerivs License", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="4"
                              <?php
                                 if($flickr_license == '4')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution License", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="5"
                              <?php
                                 if($flickr_license == '5')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-ShareAlike License", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="6"
                              <?php
                                 if($flickr_license == '6')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NoDerivs License", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="7"
                              <?php
                                 if($flickr_license == '7')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("No known copyright restrictions", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="8"
                              <?php
                                 if($flickr_license == '8')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("United States Government Work", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("The order in which to sort returned photos. Deafults to date-posted-desc (unless you are doing a radial geo query, in which case the default sorting is by ascending distance from the point specified).", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Search Results Order: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[flickr_order]" class="cr_width_full">
                           <option value="date-posted-desc"
                              <?php
                                 if($flickr_order == 'date-posted-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Posted Descendant", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="date-posted-asc"
                              <?php
                                 if($flickr_order == 'date-posted-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Posted Ascendent", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="date-taken-asc"
                              <?php
                                 if($flickr_order == 'date-taken-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Taken Ascendent", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="date-taken-desc"
                              <?php
                                 if($flickr_order == 'date-taken-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Taken Descendant", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="interestingness-desc"
                              <?php
                                 if($flickr_order == 'interestingness-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Interestingness Descendant", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="interestingness-asc"
                              <?php
                                 if($flickr_order == 'interestingness-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Interestingness Ascendant", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="relevance"
                              <?php
                                 if($flickr_order == 'relevance')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Relevance", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  </td></tr><tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Pixabay API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Pixabay App ID. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter an API Key here, you will enable search for images using the Pixabay API.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), "https://pixabay.com/api/docs/" );
                                    ?>
                              </div>
                           </div>
                           <b><a href="https://pixabay.com/api/docs/" target="_blank"><?php echo esc_html__("Pixabay App ID:", 'aiomatic-automatic-ai-content-writer');?></a></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" class="cr_width_full" name="aiomatic_Main_Settings[pixabay_api]" value="<?php
                              echo esc_html($pixabay_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Pixabay API key", 'aiomatic-automatic-ai-content-writer');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Filter results by image type.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Image Types To Search:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </th>
                     <td>
                        <div>
                           <select class="cr_width_full" name="aiomatic_Main_Settings[imgtype]" >
                              <option value='all'<?php
                                 if ($imgtype == 'all')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("All", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value='photo'<?php
                                 if ($imgtype == 'photo')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Photo", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value='illustration'<?php
                                 if ($imgtype == 'illustration')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Illustration", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value='vector'<?php
                                 if ($imgtype == 'vector')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Vector", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Order results by a predefined rule.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Results Order: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[img_order]" class="cr_width_full">
                           <option value="popular"<?php
                              if ($img_order == "popular") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Popular", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="latest"<?php
                              if ($img_order == "latest") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Latest", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image category.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Category: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[img_cat]" class="cr_width_full">
                           <option value="all"<?php
                              if ($img_cat == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="fashion"<?php
                              if ($img_cat == "fashion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Fashion", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="nature"<?php
                              if ($img_cat == "nature") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Nature", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="backgrounds"<?php
                              if ($img_cat == "backgrounds") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Backgrounds", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="science"<?php
                              if ($img_cat == "science") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Science", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="education"<?php
                              if ($img_cat == "education") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Education", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="people"<?php
                              if ($img_cat == "people") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("People", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="feelings"<?php
                              if ($img_cat == "feelings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Feelings", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="religion"<?php
                              if ($img_cat == "religion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Religion", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="health"<?php
                              if ($img_cat == "health") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Health", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="places"<?php
                              if ($img_cat == "places") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Places", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="animals"<?php
                              if ($img_cat == "animals") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Animals", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="industry"<?php
                              if ($img_cat == "industry") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Industry", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="food"<?php
                              if ($img_cat == "food") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Food", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="computer"<?php
                              if ($img_cat == "computer") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Computer", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="sports"<?php
                              if ($img_cat == "sports") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Sports", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="transportation"<?php
                              if ($img_cat == "transportation") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Transportation", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="travel"<?php
                              if ($img_cat == "travel") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Travel", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="buildings"<?php
                              if ($img_cat == "buildings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Buildings", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="business"<?php
                              if ($img_cat == "business") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Business", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="music"<?php
                              if ($img_cat == "music") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Music", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Minimum image width.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Width: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <input type="number" min="1" step="1" name="aiomatic_Main_Settings[img_width]" value="<?php echo esc_html($img_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Maximum image width.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Max Width: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <input type="number" min="1" step="1" name="aiomatic_Main_Settings[img_mwidth]" value="<?php echo esc_html($img_mwidth);?>" placeholder="<?php echo esc_html__("Please insert image max width", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("A flag indicating that only images suitable for all ages should be returned.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Safe Search: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="img_ss" name="aiomatic_Main_Settings[img_ss]"<?php
                     if ($img_ss == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select images that have received an Editor's Choice award.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Editor\'s Choice: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="img_editor" name="aiomatic_Main_Settings[img_editor]"<?php
                     if ($img_editor == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Specify default language for regional content.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Filter Language: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[img_language]" class="cr_width_full">
                           <option value="any"<?php
                              if ($img_language == "any") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Any", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="en"<?php
                              if ($img_language == "en") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("English", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="cs"<?php
                              if ($img_language == "cs") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Czech", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="da"<?php
                              if ($img_language == "da") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Danish", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="de"<?php
                              if ($img_language == "de") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("German", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="es"<?php
                              if ($img_language == "es") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Spanish", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="fr"<?php
                              if ($img_language == "fr") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("French", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="id"<?php
                              if ($img_language == "id") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Indonesian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="it"<?php
                              if ($img_language == "it") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Italian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="hu"<?php
                              if ($img_language == "hu") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Hungarian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="nl"<?php
                              if ($img_language == "nl") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Dutch", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="no"<?php
                              if ($img_language == "no") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Norvegian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="pl"<?php
                              if ($img_language == "pl") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Polish", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="pt"<?php
                              if ($img_language == "pt") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Portuguese", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="ro"<?php
                              if ($img_language == "ro") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Romanian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="sk"<?php
                              if ($img_language == "sk") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Slovak", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="fi"<?php
                              if ($img_language == "fi") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Finish", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="sv"<?php
                              if ($img_language == "sv") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Swedish", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="tr"<?php
                              if ($img_language == "tr") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Turkish", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="vi"<?php
                              if ($img_language == "vi") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vietnamese", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="th"<?php
                              if ($img_language == "th") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Thai", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="bg"<?php
                              if ($img_language == "bg") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Bulgarian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="ru"<?php
                              if ($img_language == "ru") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Russian", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="el"<?php
                              if ($img_language == "el") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Greek", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="ja"<?php
                              if ($img_language == "ja") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Japanese", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="ko"<?php
                              if ($img_language == "ko") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Korean", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="zh"<?php
                              if ($img_language == "zh") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Chinese", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr><tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Google Images API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                 <tr>
                    <th>
                       <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                          <div class="bws_hidden_help_text cr_min_260px">
                             <?php
                                echo esc_html__("Select if you want to enable usage of the Google Images Search with the Creative Commons filter enabled, for getting images.", 'aiomatic-automatic-ai-content-writer');
                                ?>
                          </div>
                       </div>
                       <b><?php esc_html_e('Enable Google Images Search Usage: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                    </th>
                    <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="google_images" name="aiomatic_Main_Settings[google_images]"<?php
                     if ($google_images == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                    </td>
                 </tr><tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Unsplash API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                 <tr>
                    <th>
                       <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                          <div class="bws_hidden_help_text cr_min_260px">
                             <?php
                                echo esc_html__("Select if you want to enable usage of the Unsplash API for getting images.", 'aiomatic-automatic-ai-content-writer');
                                ?>
                          </div>
                       </div>
                       <b><?php esc_html_e('Enable Unsplash API Usage: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                    </th>
                    <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="unsplash_api" name="aiomatic_Main_Settings[unsplash_api]"<?php
                     if ($unsplash_api == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                    </td>
                 </tr><tr class="aiomatic-title-holder">
                     <td colspan="2">
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Pixabay Direct Scraping Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
                        </td></tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you want to enable direct scraping of Pixabay website. This will generate different results from the API.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Enable Pixabay Direct Website Scraping: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="pixabay_scrape" name="aiomatic_Main_Settings[pixabay_scrape]"<?php
                     if ($pixabay_scrape == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image type.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Types To Search: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[scrapeimgtype]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimgtype == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="photo"<?php
                              if ($scrapeimgtype == "photo") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Photo", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="illustration"<?php
                              if ($scrapeimgtype == "illustration") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Illustration", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="vector"<?php
                              if ($scrapeimgtype == "vector") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vector", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image orientation.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Orientation: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[scrapeimg_orientation]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimg_orientation == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="horizontal"<?php
                              if ($scrapeimg_orientation == "horizontal") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Horizontal", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="vertical"<?php
                              if ($scrapeimg_orientation == "vertical") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vertical", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Order results by a predefined rule.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Results Order: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[scrapeimg_order]" class="cr_width_full">
                           <option value="any"<?php
                              if ($scrapeimg_order == "any") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Any", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="popular"<?php
                              if ($scrapeimg_order == "popular") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Popular", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="latest"<?php
                              if ($scrapeimg_order == "latest") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Latest", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image category.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Category: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <select name="aiomatic_Main_Settings[scrapeimg_cat]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimg_cat == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="fashion"<?php
                              if ($scrapeimg_cat == "fashion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Fashion", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="nature"<?php
                              if ($scrapeimg_cat == "nature") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Nature", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="backgrounds"<?php
                              if ($scrapeimg_cat == "backgrounds") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Backgrounds", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="science"<?php
                              if ($scrapeimg_cat == "science") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Science", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="education"<?php
                              if ($scrapeimg_cat == "education") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Education", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="people"<?php
                              if ($scrapeimg_cat == "people") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("People", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="feelings"<?php
                              if ($scrapeimg_cat == "feelings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Feelings", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="religion"<?php
                              if ($scrapeimg_cat == "religion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Religion", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="health"<?php
                              if ($scrapeimg_cat == "health") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Health", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="places"<?php
                              if ($scrapeimg_cat == "places") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Places", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="animals"<?php
                              if ($scrapeimg_cat == "animals") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Animals", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="industry"<?php
                              if ($scrapeimg_cat == "industry") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Industry", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="food"<?php
                              if ($scrapeimg_cat == "food") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Food", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="computer"<?php
                              if ($scrapeimg_cat == "computer") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Computer", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="sports"<?php
                              if ($scrapeimg_cat == "sports") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Sports", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="transportation"<?php
                              if ($scrapeimg_cat == "transportation") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Transportation", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="travel"<?php
                              if ($scrapeimg_cat == "travel") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Travel", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="buildings"<?php
                              if ($scrapeimg_cat == "buildings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Buildings", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="business"<?php
                              if ($scrapeimg_cat == "business") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Business", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="music"<?php
                              if ($scrapeimg_cat == "music") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Music", 'aiomatic-automatic-ai-content-writer');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Minimum image width.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Width: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <input type="number" min="1" step="1" name="aiomatic_Main_Settings[scrapeimg_width]" value="<?php echo esc_html($scrapeimg_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Maximum image height.", 'aiomatic-automatic-ai-content-writer');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Height: ', 'aiomatic-automatic-ai-content-writer'); ?></b>
                     </th>
                     <td>
                        <input type="number" min="1" step="1" name="aiomatic_Main_Settings[scrapeimg_height]" value="<?php echo esc_html($scrapeimg_height);?>" placeholder="<?php echo esc_html__("Please insert image min height", 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  </td></tr></table>     
        </div>
        <div id="tab-9<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Random Sentences', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Random Sentences' tab provides tools to generate and customize random sentences, offering creative content solutions and inspiration for your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
                  <tr class="aiomatic-title-holder">
                     <td>
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Random Sentence Generator Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("First List of Possible Sentences (%%random_sentence%%):", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <textarea rows="8" class="cr_width_full" cols="70" name="aiomatic_Main_Settings[sentence_list]" placeholder="<?php echo esc_html__("Please insert the first list of sentences", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($sentence_list);
                        ?></textarea>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Second List of Possible Sentences (%%random_sentence2%%):", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <textarea rows="8" cols="70" class="cr_width_full" name="aiomatic_Main_Settings[sentence_list2]" placeholder="<?php echo esc_html__("Please insert the second list of sentences", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($sentence_list2);
                        ?></textarea>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some variables you wish to be exchanged for different instances of one sentence. Please format this list as follows:<br/>
                                    Variablename => Variables (seperated by semicolon)<br/>Example:<br/>adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome<br/>", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("List of Possible Variables:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <textarea rows="8" cols="70" class="cr_width_full" name="aiomatic_Main_Settings[variable_list]" placeholder="<?php echo esc_html__("Please insert the list of variables", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($variable_list);
                        ?></textarea>
                     </td>
                  </tr></table>     
        </div>
        <div id="tab-10<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Custom HTML', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Custom HTML' tab allows you to directly edit and manage HTML code, giving you the flexibility to create custom designs and functionalities for your WordPress site.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
                  <tr class="aiomatic-title-holder">
                     <td>
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Custom HTML Code/ Ad Code Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert a custom HTML code that will replace the %%custom_html%% variable. This can be anything, even an Ad code.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom HTML Code #1:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <textarea rows="3" cols="70" class="cr_width_full" name="aiomatic_Main_Settings[custom_html]" placeholder="<?php echo esc_html__("Custom HTML #1", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($custom_html);
                        ?></textarea>
                     </td>
                  </tr>
                  <tr>
                     <th>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert a custom HTML code that will replace the %%custom_html2%% variable. This can be anything, even an Ad code.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom HTML Code #2:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </th>
                     <td>
                     <textarea rows="3" cols="70" class="cr_width_full" name="aiomatic_Main_Settings[custom_html2]" placeholder="<?php echo esc_html__("Custom HTML #2", 'aiomatic-automatic-ai-content-writer');?>"><?php
                        echo esc_textarea($custom_html2);
                        ?></textarea>
                     </td>
                  </tr>
               </table>    
        </div>
        <div id="tab-11<?php if($is_activated !== true && $is_activated !== 2){echo 'x';}?>" class="tab-content">
<h3><?php echo esc_html__('Keyword Replacer', 'aiomatic-automatic-ai-content-writer');?></h3>
    <p class="aiomatic-settings-desc"><?php
                            echo esc_html__("The 'Keyword Replacer' tab offers tools to automatically identify and replace specified keywords throughout your WordPress site's content, enhancing SEO and content consistency.", 'aiomatic-automatic-ai-content-writer');
?></p>
        <table class="widefat">
                  <tr class="aiomatic-title-holder">
                     <td>
                        <h2 class="aiomatic-inner-title"><?php echo esc_html__("Keyword Replacer Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
                     </td>
                  </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want the Keyword Replacer Tool to match also partial words, or only full words.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Match Also Partial Words:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="partial_kws" name="aiomatic_Main_Settings[partial_kws]"<?php
                     if ($partial_kws == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want the Keyword Replacer Tool to match in a case sensitive words mode (upper case differentiated from lower case words).", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Make Search Case Sensitive:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="kws_case" name="aiomatic_Main_Settings[kws_case]"<?php
                     if ($kws_case == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select if you want to open added links in a new tab.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Don't Open Links In A New Tab:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
                  <label class="aiomatic-switch"><input type="checkbox" id="no_new_tab_kw" name="aiomatic_Main_Settings[no_new_tab_kw]"<?php
                     if ($no_new_tab_kw == 'on')
                         echo ' checked ';
                     ?>><span class="aiomatic-slider round"></span></label>
            </td>
         </tr>
         <tr>
            <th>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Add a comma separated list of post IDs on which the Keyword Replacer will not function.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Processing Of These Post IDs:", 'aiomatic-automatic-ai-content-writer');?></b>
            </th>
            <td>
               <textarea rows="2" cols="70" class="cr_width_full" name="aiomatic_Main_Settings[kw_skip_ids]" placeholder="<?php echo esc_html__("ex: 23,24,25", 'aiomatic-automatic-ai-content-writer');?>"><?php
                  echo esc_textarea($kw_skip_ids);
                  ?></textarea>
            </td>
         </tr>
         </table>
         <table class="widefat">
         <tr class="aiomatic-title-holder">
            <td>
               <h2 class="aiomatic-inner-title"><?php echo esc_html__("Affiliate Keyword Replacer Rules:", 'aiomatic-automatic-ai-content-writer');?></h2>
               <hr/>
               <div class="table-responsive">
                  <div id="grid-keywords-aiomatic">
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the rule.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to delete this rule?", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("Search Keyword", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This keyword will be replaced with a link you define.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("Replacement Keyword", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This keyword will replace the search keyword you define. Leave this field blank if you only want to add an URL to the specified keyword.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("Link to Add", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Define the link you want to appear the defined keyword. Leave this field blank if you only want to replace the specified keyword without linking from it.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle"><?php echo esc_html__("Target Content", 'aiomatic-automatic-ai-content-writer');?><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select if you want to make this rule target post title, content or both.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                           </div>
                           </div></div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle"><?php echo esc_html__("Maximum Replacement Count", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Set the maximum number of instances which will be replaced in the matched content.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div></div>
                        <?php
                           echo aiomatic_expand_keyword_rules();
                           ?>

                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>
                           <div>
                              <hr/>
                           </div>

                           <div class="cr_center">-</div>
                           <div class="cr_center"><span class="cr_gray20">X</span></div>
                           <div class="cr_center"><input type="text" name="aiomatic_keyword_list[keyword][]" placeholder="<?php echo esc_html__("Please insert the keyword to be replaced", 'aiomatic-automatic-ai-content-writer');?>" value=""/></div>
                           <div class="cr_center"><input type="text" name="aiomatic_keyword_list[replace][]" placeholder="<?php echo esc_html__("Please insert the keyword to replace the search keyword", 'aiomatic-automatic-ai-content-writer');?>" value="" /></div>
                           <div class="cr_center"><input type="url" validator="url" name="aiomatic_keyword_list[link][]" placeholder="<?php echo esc_html__("Please insert the link to be added to the keyword", 'aiomatic-automatic-ai-content-writer');?>" value="" />
                           </div>
                           <div class="cr_center"><select id="aiomatic_keyword_target" name="aiomatic_keyword_list[target][]">
<option value="content" selected><?php echo esc_html__("Content", 'aiomatic-automatic-ai-content-writer');?></option>
<option value="title"><?php echo esc_html__("Title", 'aiomatic-automatic-ai-content-writer');?></option>
<option value="both"><?php echo esc_html__("Content and Title", 'aiomatic-automatic-ai-content-writer');?></option></select></div>
                           <div class="cr_center"><input type="number" min="1" step="1" name="aiomatic_keyword_list[max][]" placeholder="<?php echo esc_html__("Max #", 'aiomatic-automatic-ai-content-writer');?>" value="" />
                           </div>
                        </div>
                  </div>
                  <hr/>
                        <p class="crsubmit"><input type="submit" name="btnSubmitkw" id="btnSubmitkw" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Keyword Replacer Rules", 'aiomatic-automatic-ai-content-writer');?>"/></p>
            </td></tr></table>
            </div>
   <hr/>
   <table><tr class="aiomatic-float-option">
      <th class="aiomatic-save-section dashboard">
      <p class="crsubmit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'aiomatic-automatic-ai-content-writer');?>"/></p>
      </th>
      </tr></table>
   <input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('openai-secret-nonce');?>">
   </form>
   </div>
</div>
</div>
<?php
   }
   if (isset($_POST['aiomatic_keyword_list'])) {
       add_action('admin_init', 'aiomatic_save_keyword_rules');
   }
   function aiomatic_card_save_settings() 
   {
      if (isset($_POST['btnSubmit']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce')) 
      {
         $change_done = false;
         $old_order = get_option('aiomatic_image_cards_order', array());
         if (isset($_POST['aiomatic_Main_Settings']['pexels_api']) && $_POST['aiomatic_Main_Settings']['pexels_api'] != '')
         {
            if(!in_array('pexels', $old_order))
            {
               $old_order[] = 'pexels';
               $change_done = true;
            }
         }
         else
         {
            if(isset($_POST['aiomatic_Main_Settings']))
            {
               if (($xkey = array_search('pexels', $old_order)) !== false) 
               {
                  unset($old_order[$xkey]);
                  $change_done = true;
               }
            }
         }
         if (isset($_POST['aiomatic_Main_Settings']['flickr_api']) && $_POST['aiomatic_Main_Settings']['flickr_api'] != '')
         {
            if(!in_array('flickr', $old_order))
            {
               $old_order[] = 'flickr';
               $change_done = true;
            }
         }
         else
         {
            if(isset($_POST['aiomatic_Main_Settings']))
            {
               if (($xkey = array_search('flickr', $old_order)) !== false) 
               {
                  unset($old_order[$xkey]);
                  $change_done = true;
               }
            }
         }
         if (isset($_POST['aiomatic_Main_Settings']['pixabay_api']) && $_POST['aiomatic_Main_Settings']['pixabay_api'] != '')
         {
            if(!in_array('pixabay', $old_order))
            {
               $old_order[] = 'pixabay';
               $change_done = true;
            }
         }
         else
         {
            if(isset($_POST['aiomatic_Main_Settings']))
            {
               if (($xkey = array_search('pixabay', $old_order)) !== false) 
               {
                  unset($old_order[$xkey]);
                  $change_done = true;
               }
            }
         }
         if (isset($_POST['aiomatic_Main_Settings']['google_images']) && $_POST['aiomatic_Main_Settings']['google_images'] == 'on')
         {
            if(!in_array('google', $old_order))
            {
               $old_order[] = 'google';
               $change_done = true;
            }
         }
         else
         {
            if(isset($_POST['aiomatic_Main_Settings']))
            {
               if (($xkey = array_search('google', $old_order)) !== false) 
               {
                  unset($old_order[$xkey]);
                  $change_done = true;
               }
            }
         }
         if (isset($_POST['aiomatic_Main_Settings']['unsplash_api']) && $_POST['aiomatic_Main_Settings']['unsplash_api'] == 'on')
         {
            if(!in_array('unsplash', $old_order))
            {
               $old_order[] = 'unsplash';
               $change_done = true;
            }
         }
         else
         {
            if(isset($_POST['aiomatic_Main_Settings']))
            {
               if (($xkey = array_search('unsplash', $old_order)) !== false) 
               {
                  unset($old_order[$xkey]);
                  $change_done = true;
               }
            }
         }
         if (isset($_POST['aiomatic_Main_Settings']['pixabay_scrape']) && $_POST['aiomatic_Main_Settings']['pixabay_scrape'] == 'on')
         {
            if(!in_array('pixabayscrape', $old_order))
            {
               $old_order[] = 'pixabayscrape';
               $change_done = true;
            }
         }
         else
         {
            if(isset($_POST['aiomatic_Main_Settings']))
            {
               if (($xkey = array_search('pixabayscrape', $old_order)) !== false) 
               {
                  unset($old_order[$xkey]);
                  $change_done = true;
               }
            }
         }
         if($change_done == false)
         {
            if(isset($_POST['aiomatic_sortable_cards']))
            {
               $new_order = isset($_POST['aiomatic_sortable_cards']) ? $_POST['aiomatic_sortable_cards'] : '';
               $new_order = explode(',', $new_order);
               update_option('aiomatic_image_cards_order', $new_order);
            }
         }
         else
         {
            update_option('aiomatic_image_cards_order', $old_order);
         }
      }
   }
   add_action('admin_init', 'aiomatic_card_save_settings');
   
   function aiomatic_save_keyword_rules($data2)
   {
      if (isset($_POST['aiomatic_keyword_list']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce')) 
      {
         $data2 = $_POST['aiomatic_keyword_list'];
         $rules = array();
         if (isset($data2['keyword'][0])) {
            for ($i = 0; $i < sizeof($data2['keyword']); ++$i) {
               if (isset($data2['keyword'][$i]) && $data2['keyword'][$i] != '') {
                     $index         = trim(sanitize_text_field($data2['keyword'][$i]));
                     $rules[$index] = array(
                        trim(sanitize_text_field($data2['link'][$i])),
                        trim(sanitize_text_field($data2['replace'][$i])),
                        trim(sanitize_text_field($data2['target'][$i])),
                        trim(sanitize_text_field($data2['max'][$i]))
                     );
               }
            }
         }
         update_option('aiomatic_keyword_list', $rules);
      }
   }
   if (isset($_POST['aiomatic_assistant_list'])) {
       add_action('admin_init', 'aiomatic_save_assistant_rules');
   }
   function aiomatic_save_assistant_rules($data2)
   {
      if (isset($_POST['aiomatic_assistant_list']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce')) 
      {
         $data2 = $_POST['aiomatic_assistant_list'];
         $rules = array();
         if (isset($data2['menu_name'][0])) {
            for ($i = 0; $i < sizeof($data2['menu_name']); ++$i) {
                  if (isset($data2['menu_name'][$i]) && $data2['menu_name'][$i] != '' && isset($data2['prompt'][$i]) && $data2['prompt'][$i] != '') 
                  {
                     $index         = trim(sanitize_text_field($data2['menu_name'][$i]));
                     $rules[$index] = array(
                        trim($data2['prompt'][$i]),
                        trim(sanitize_text_field($data2['type'][$i])),
                     );
                  }
            }
         }
         update_option('aiomatic_assistant_list', $rules);
      }
   }
   if (isset($_POST['aiomatic_huggingface_models'])) {
       add_action('admin_init', 'aiomatic_save_huggingface_models');
   }
   function aiomatic_save_huggingface_models($data2)
   {
      if (isset($_POST['aiomatic_huggingface_models']) && isset($_POST['aiomatic_nonce']) && wp_verify_nonce( $_POST['aiomatic_nonce'], 'openai-secret-nonce')) 
      {
         $data2 = $_POST['aiomatic_huggingface_models'];
         $rules = array();
         if (isset($data2['model'][0])) {
            for ($i = 0; $i < sizeof($data2['model']); ++$i) {
                  if (isset($data2['model'][$i]) && $data2['model'][$i] != '') 
                  {
                     $model         = str_replace(' ', '', sanitize_text_field($data2['model'][$i]));
                     $endpoint_url  = $data2['endpoint_url'][$i];
                     $rules[$model] = array($model, $endpoint_url);
                  }
            }
         }
         update_option('aiomatic_huggingface_models', $rules);
      }
   }
   function aiomatic_expand_keyword_rules()
   {
       $rules  = get_option('aiomatic_keyword_list');
       if(!is_array($rules))
       {
          $rules = array();
       }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $request => $value) 
           {
               $uniq = uniqid();
               $output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '">' . esc_html($cont) . '</div>
                           <div class="cr_center aiuniq-' . esc_html($uniq) . '"><span data-id="' . esc_html($uniq) . '" class="wpaiomatic-delete">X</span></div>
                           <div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="text" placeholder="' . esc_html__('Input the keyword to be replaced. This field is required', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_keyword_list[keyword][]" value="' . esc_html(stripslashes($request)) . '" required></div>
                           <div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="text" placeholder="' . esc_html__('Input the replacement word', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_keyword_list[replace][]" value="' . esc_html(stripslashes($value[1])) . '" ></div>
                           <div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="url" validator="url" placeholder="' . esc_html__('Input the URL to be added', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_keyword_list[link][]" value="' . esc_html(stripslashes($value[0])) . '"></div>';
                           if(isset($value[2]))
                           {
                               $target = $value[2];
                           }
                           else
                           {
                               $target = 'content';
                           }
                           $output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '"><select id="aiomatic_keyword_target' . rand() . '" name="aiomatic_keyword_list[target][]">
                                     <option value="content"';
                           if ($target == "content") {
                               $output .= " selected";
                           }
                           $output .= '>' . esc_html__('Content', 'aiomatic-automatic-ai-content-writer') . '</option>
                           <option value="title"';
                           if ($target == "title") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Title', 'aiomatic-automatic-ai-content-writer') . '</option>
                           <option value="both"';
                           if ($target == "both") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Content and Title', 'aiomatic-automatic-ai-content-writer') . '</option>
                       </select></div>
                       <div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="number" min="1" step="1" placeholder="' . esc_html__('Max #', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_keyword_list[max][]" value="' . esc_html($value[3]) . '" class="cr_width_100"></div>';
               $cont++;
           }
       }
       return $output;
   }
   
   function aiomatic_expand_huggingface_models()
   {
       $rules  = get_option('aiomatic_huggingface_models', array());
       if(!is_array($rules))
       {
          $rules = array();
       }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $request => $value) 
           {
               $uniq = uniqid();
               $output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '">' . esc_html($cont) . '</div>
                           <div class="cr_center aiuniq-' . esc_html($uniq) . '"><span data-id="' . esc_html($uniq) . '" class="wpaiomatic-delete">X</span></div>
                           <div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="text" placeholder="' . esc_html__('Input the model name. This field is required', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_huggingface_models[model][]" value="' . esc_html(stripslashes($request)) . '" required></div>';
               if(is_array($value) && isset($value[1]))
               {
                  $endpoint_url = $value[1];
               }
               else
               {
                  $endpoint_url = '';
               }
               $output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="url" placeholder="' . esc_html__('Inference Endpoint URL (Optional)', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_huggingface_models[endpoint_url][]" value="' . esc_attr($endpoint_url) . '"></div>';
               $cont++;
           }
       }
       return $output;
   }
   
   function aiomatic_expand_assistant_rules()
   {
       $rules  = aiomatic_get_assistant();
       if(!is_array($rules))
       {
          $rules = array();
       }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $menu_name => $value) 
           {
               $uniq = uniqid();
               $output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="text" placeholder="' . esc_html__('Add a menu name', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_assistant_list[menu_name][]" value="' . esc_attr(stripslashes($menu_name)) . '" required></div>
<div class="cr_center aiuniq-' . esc_html($uniq) . '"><textarea rows="1" type="text" placeholder="' . esc_html__('Add a prompt', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_assistant_list[prompt][]">' . esc_textarea(stripslashes($value[0])) . '</textarea></div>';
$output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '"><select id="aiomatic_keyword_target' . rand() . '" name="aiomatic_assistant_list[type][]">
<option value="text"';
   if (esc_html($value[1]) == "text") {
         $output .= " selected";
   }
   $output .= '>' . esc_html__('Text', 'aiomatic-automatic-ai-content-writer') . '</option>
   <option value="image"';
   if (esc_html($value[1]) == "image") {
         $output .=  " selected";
   }
   $output .= '>' . esc_html__('Image', 'aiomatic-automatic-ai-content-writer') . '</option>
</select></div>';
$output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '"><span data-id="' . esc_html($uniq) . '" class="wpaiomatic-delete">X</span></div>';
               $cont++;
           }
       }
       return $output;
   }
   ?>