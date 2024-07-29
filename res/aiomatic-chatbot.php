<?php
function aiomatic_chat_settings_updated($old_value, $value, $option) 
{
    if (array_key_exists('remote_chat', $value) && (!isset($old_value['remote_chat']) || $value['remote_chat'] !== $old_value['remote_chat'])) 
    {
        $myop = get_option('aiomatic_chat_page_id', false);
        if($myop !== false)
        {
            if(is_numeric($myop))
            {
                $myop = array($myop);
            }
            $changedone = false;
            foreach($myop as $mind => $marr)
            {
                $tp = get_post($marr);
                if($tp === null)
                {
                    unset($myop[$mind]);
                    $changedone = true;
                }
            }
            if($changedone == true)
            {
                update_option('aiomatic_chat_page_id', $myop);
            }
            if (!isset($value['remote_chat']) || trim($value['remote_chat']) != 'on')
            {
                foreach($myop as $mind => $marr)
                {
                    wp_delete_post($marr, true);
                    delete_option('aiomatic_chat_page_id');
                }
            }
        }
    }
    else
    {
        if(!isset($value['remote_chat']))
        {
            $myop = get_option('aiomatic_chat_page_id', false);
            if($myop !== false)
            {
                if(is_numeric($myop))
                {
                    $myop = array($myop);
                }
                foreach($myop as $mind => $marr)
                {
                    wp_delete_post($marr, true);
                    delete_option('aiomatic_chat_page_id');
                }
            }
        }
    }
}
add_action('update_option_aiomatic_Chatbot_Settings', 'aiomatic_chat_settings_updated', 10, 3);
function aiomatic_chatbot_panel()
{
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
   {
      ?>
<h1><?php echo esc_html__("You must add an OpenAI/AiomaticAPI API Key into the plugin's 'Settings' menu before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
   $all_models = aiomatic_get_all_models(true);
   $all_assistants = aiomatic_get_all_assistants(true);
   $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if (isset($aiomatic_Chatbot_Settings['font_size'])) {
        $font_size = $aiomatic_Chatbot_Settings['font_size'];
    } else {
        $font_size = '';
    }
    if (isset($aiomatic_Chatbot_Settings['show_header'])) {
        $show_header = $aiomatic_Chatbot_Settings['show_header'];
    } else {
        $show_header = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chat_theme'])) {
        $chat_theme = $aiomatic_Chatbot_Settings['chat_theme'];
    } else {
        $chat_theme = '';
    }
    if (isset($aiomatic_Chatbot_Settings['show_dltxt'])) {
        $show_dltxt = $aiomatic_Chatbot_Settings['show_dltxt'];
    } else {
        $show_dltxt = '';
    }
    if (isset($aiomatic_Chatbot_Settings['show_mute'])) {
        $show_mute = $aiomatic_Chatbot_Settings['show_mute'];
    } else {
        $show_mute = '';
    }
    if (isset($aiomatic_Chatbot_Settings['show_internet'])) {
        $show_internet = $aiomatic_Chatbot_Settings['show_internet'];
    } else {
        $show_internet = '';
    }
    if (isset($aiomatic_Chatbot_Settings['show_clear'])) {
        $show_clear = $aiomatic_Chatbot_Settings['show_clear'];
    } else {
        $show_clear = '';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_language'])) {
        $voice_language = $aiomatic_Chatbot_Settings['voice_language'];
    } else {
        $voice_language = 'en-US';
    }
    if (isset($aiomatic_Chatbot_Settings['did_image'])) {
        $did_image = $aiomatic_Chatbot_Settings['did_image'];
    } else {
        $did_image = 'https://create-images-results.d-id.com/api_docs/assets/noelle.jpeg';
    }
    if (isset($aiomatic_Chatbot_Settings['did_height'])) {
        $did_height = $aiomatic_Chatbot_Settings['did_height'];
    } else {
        $did_height = '300';
    }
    if (isset($aiomatic_Chatbot_Settings['did_width'])) {
        $did_width = $aiomatic_Chatbot_Settings['did_width'];
    } else {
        $did_width = '300';
    }
    if (isset($aiomatic_Chatbot_Settings['did_voice'])) {
        $did_voice = $aiomatic_Chatbot_Settings['did_voice'];
    } else {
        $did_voice = 'microsoft:en-US-JennyNeural:Cheerful';
    }
    if (isset($aiomatic_Chatbot_Settings['google_voice'])) {
        $google_voice = $aiomatic_Chatbot_Settings['google_voice'];
    } else {
        $google_voice = 'en-US';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_pitch'])) {
        $voice_pitch = $aiomatic_Chatbot_Settings['voice_pitch'];
    } else {
        $voice_pitch = '0';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_speed'])) {
        $voice_speed = $aiomatic_Chatbot_Settings['voice_speed'];
    } else {
        $voice_speed = '1';
    }
    if (isset($aiomatic_Chatbot_Settings['audio_profile'])) {
        $audio_profile = $aiomatic_Chatbot_Settings['audio_profile'];
    } else {
        $audio_profile = 'en-US';
    }
    if (isset($aiomatic_Chatbot_Settings['chatbot_text_speech'])) {
        $chatbot_text_speech = $aiomatic_Chatbot_Settings['chatbot_text_speech'];
    } else {
        $chatbot_text_speech = '';
    }
    if (isset($aiomatic_Chatbot_Settings['free_voice'])) {
        $free_voice = $aiomatic_Chatbot_Settings['free_voice'];
    } else {
        $free_voice = '';
    }
    if (isset($aiomatic_Chatbot_Settings['extension_email'])) {
        $extension_email = $aiomatic_Chatbot_Settings['extension_email'];
    } else {
        $extension_email = '';
    }
    if (isset($aiomatic_Chatbot_Settings['extension_email_prompt'])) {
        $extension_email_prompt = $aiomatic_Chatbot_Settings['extension_email_prompt'];
    } else {
        $extension_email_prompt = 'When I ask you to send an email, don\'t tell me that you cannot send emails, but instead, respond in the following format, be sure to always keep parameter order: [email to="recipient_email" subject="email_subject" content="email_content"]';
    }
    if (isset($aiomatic_Chatbot_Settings['eleven_voice'])) {
        $eleven_voice = $aiomatic_Chatbot_Settings['eleven_voice'];
    } else {
        $eleven_voice = '';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_similarity_boost'])) {
        $voice_similarity_boost = $aiomatic_Chatbot_Settings['voice_similarity_boost'];
    } else {
        $voice_similarity_boost = '';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_style'])) {
        $voice_style = $aiomatic_Chatbot_Settings['voice_style'];
    } else {
        $voice_style = '';
    }
    if (isset($aiomatic_Chatbot_Settings['speaker_boost'])) {
        $speaker_boost = $aiomatic_Chatbot_Settings['speaker_boost'];
    } else {
        $speaker_boost = '';
    }
    if (isset($aiomatic_Chatbot_Settings['open_model_id'])) {
        $open_model_id = $aiomatic_Chatbot_Settings['open_model_id'];
    } else {
        $open_model_id = '';
    }
    if (isset($aiomatic_Chatbot_Settings['open_voice'])) {
        $open_voice = $aiomatic_Chatbot_Settings['open_voice'];
    } else {
        $open_voice = '';
    }
    if (isset($aiomatic_Chatbot_Settings['open_format'])) {
        $open_format = $aiomatic_Chatbot_Settings['open_format'];
    } else {
        $open_format = '';
    }
    if (isset($aiomatic_Chatbot_Settings['open_speed'])) {
        $open_speed = $aiomatic_Chatbot_Settings['open_speed'];
    } else {
        $open_speed = '';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_stability'])) {
        $voice_stability = $aiomatic_Chatbot_Settings['voice_stability'];
    } else {
        $voice_stability = '';
    }
    if (isset($aiomatic_Chatbot_Settings['eleven_model_id'])) {
        $eleven_model_id = $aiomatic_Chatbot_Settings['eleven_model_id'];
    } else {
        $eleven_model_id = '';
    }
    if (isset($aiomatic_Chatbot_Settings['eleven_voice_custom'])) {
        $eleven_voice_custom = $aiomatic_Chatbot_Settings['eleven_voice_custom'];
    } else {
        $eleven_voice_custom = '';
    }
    if (isset($aiomatic_Chatbot_Settings['width'])) {
        $width = $aiomatic_Chatbot_Settings['width'];
    } else {
        $width = '';
    }
    if (isset($aiomatic_Chatbot_Settings['height'])) {
        $height = $aiomatic_Chatbot_Settings['height'];
    } else {
        $height = '';
    }
    if (isset($aiomatic_Chatbot_Settings['minheight'])) {
        $minheight = $aiomatic_Chatbot_Settings['minheight'];
    } else {
        $minheight = '';
    }
    if (isset($aiomatic_Chatbot_Settings['custom_header'])) {
        $custom_header = $aiomatic_Chatbot_Settings['custom_header'];
    } else {
        $custom_header = '';
    }
    if (isset($aiomatic_Chatbot_Settings['custom_footer'])) {
        $custom_footer = $aiomatic_Chatbot_Settings['custom_footer'];
    } else {
        $custom_footer = '';
    }
    if (isset($aiomatic_Chatbot_Settings['custom_css'])) {
        $custom_css = $aiomatic_Chatbot_Settings['custom_css'];
    } else {
        $custom_css = '';
    }
    if (isset($aiomatic_Chatbot_Settings['placeholder'])) {
        $placeholder = $aiomatic_Chatbot_Settings['placeholder'];
    } else {
        $placeholder = '';
    }
    if (isset($aiomatic_Chatbot_Settings['submit'])) {
        $submit = $aiomatic_Chatbot_Settings['submit'];
    } else {
        $submit = '';
    }
    if (isset($aiomatic_Chatbot_Settings['compliance'])) {
        $compliance = $aiomatic_Chatbot_Settings['compliance'];
    } else {
        $compliance = '';
    }
    if (isset($aiomatic_Chatbot_Settings['select_prompt'])) {
        $select_prompt = $aiomatic_Chatbot_Settings['select_prompt'];
    } else {
        $select_prompt = '';
    }
    if (isset($aiomatic_Chatbot_Settings['upload_pdf'])) {
        $upload_pdf = $aiomatic_Chatbot_Settings['upload_pdf'];
    } else {
        $upload_pdf = '';
    }
    if (isset($aiomatic_Chatbot_Settings['pdf_page'])) {
        $pdf_page = $aiomatic_Chatbot_Settings['pdf_page'];
    } else {
        $pdf_page = '';
    }
    if (isset($aiomatic_Chatbot_Settings['pdf_character'])) {
        $pdf_character = $aiomatic_Chatbot_Settings['pdf_character'];
    } else {
        $pdf_character = '';
    }
    if (isset($aiomatic_Chatbot_Settings['pdf_ok'])) {
        $pdf_ok = $aiomatic_Chatbot_Settings['pdf_ok'];
    } else {
        $pdf_ok = '';
    }
    if (isset($aiomatic_Chatbot_Settings['pdf_end'])) {
        $pdf_end = $aiomatic_Chatbot_Settings['pdf_end'];
    } else {
        $pdf_end = '';
    }
    if (isset($aiomatic_Chatbot_Settings['pdf_fail'])) {
        $pdf_fail = $aiomatic_Chatbot_Settings['pdf_fail'];
    } else {
        $pdf_fail = '';
    }
    if (isset($aiomatic_Chatbot_Settings['background'])) {
        $background = $aiomatic_Chatbot_Settings['background'];
    } else {
        $background = '#f7f7f9';
    }
    if (isset($aiomatic_Chatbot_Settings['general_background'])) {
        $general_background = $aiomatic_Chatbot_Settings['general_background'];
    } else {
        $general_background = '#ffffff';
    }
    if (isset($aiomatic_Chatbot_Settings['user_font_color'])) {
        $user_font_color = $aiomatic_Chatbot_Settings['user_font_color'];
    } else {
        $user_font_color = 'white';
    }
    if (isset($aiomatic_Chatbot_Settings['user_background_color'])) {
        $user_background_color = $aiomatic_Chatbot_Settings['user_background_color'];
    } else {
        $user_background_color = '#0084ff';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_font_color'])) {
        $ai_font_color = $aiomatic_Chatbot_Settings['ai_font_color'];
    } else {
        $ai_font_color = 'black';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_background_color'])) {
        $ai_background_color = $aiomatic_Chatbot_Settings['ai_background_color'];
    } else {
        $ai_background_color = '#f0f0f0';
    }
    if (isset($aiomatic_Chatbot_Settings['input_border_color'])) {
        $input_border_color = $aiomatic_Chatbot_Settings['input_border_color'];
    } else {
        $input_border_color = '#e1e3e6';
    }
    if (isset($aiomatic_Chatbot_Settings['input_text_color'])) {
        $input_text_color = $aiomatic_Chatbot_Settings['input_text_color'];
    } else {
        $input_text_color = '#000000';
    }
    if (isset($aiomatic_Chatbot_Settings['persona_name_color'])) {
        $persona_name_color = $aiomatic_Chatbot_Settings['persona_name_color'];
    } else {
        $persona_name_color = '#3c434a';
    }
    if (isset($aiomatic_Chatbot_Settings['persona_role_color'])) {
        $persona_role_color = $aiomatic_Chatbot_Settings['persona_role_color'];
    } else {
        $persona_role_color = '#728096';
    }
    if (isset($aiomatic_Chatbot_Settings['input_placeholder_color'])) {
        $input_placeholder_color = $aiomatic_Chatbot_Settings['input_placeholder_color'];
    } else {
        $input_placeholder_color = '#333333';
    }
    if (isset($aiomatic_Chatbot_Settings['submit_color'])) {
        $submit_color = $aiomatic_Chatbot_Settings['submit_color'];
    } else {
        $submit_color = '#55a7e2';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_color'])) {
        $voice_color = $aiomatic_Chatbot_Settings['voice_color'];
    } else {
        $voice_color = '#55a7e2';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_color_activated'])) {
        $voice_color_activated = $aiomatic_Chatbot_Settings['voice_color_activated'];
    } else {
        $voice_color_activated = '#55a7e2';
    }
    if (isset($aiomatic_Chatbot_Settings['submit_text_color'])) {
        $submit_text_color = $aiomatic_Chatbot_Settings['submit_text_color'];
    } else {
        $submit_text_color = '#ffffff';
    }
    if (isset($aiomatic_Chatbot_Settings['enable_moderation'])) {
        $enable_moderation = $aiomatic_Chatbot_Settings['enable_moderation'];
    } else {
        $enable_moderation = '';
    }
    if (isset($aiomatic_Chatbot_Settings['moderation_model'])) {
        $moderation_model = $aiomatic_Chatbot_Settings['moderation_model'];
    } else {
        $moderation_model = '';
    }
    if (isset($aiomatic_Chatbot_Settings['flagged_message'])) {
        $flagged_message = $aiomatic_Chatbot_Settings['flagged_message'];
    } else {
        $flagged_message = '';
    }
    if (isset($aiomatic_Chatbot_Settings['enable_copy'])) {
        $enable_copy = $aiomatic_Chatbot_Settings['enable_copy'];
    } else {
        $enable_copy = '';
    }
    if (isset($aiomatic_Chatbot_Settings['enable_html'])) {
        $enable_html = $aiomatic_Chatbot_Settings['enable_html'];
    } else {
        $enable_html = '';
    }
    if (isset($aiomatic_Chatbot_Settings['disable_modern_chat'])) {
        $disable_modern_chat = $aiomatic_Chatbot_Settings['disable_modern_chat'];
    } else {
        $disable_modern_chat = '';
    }
    if (isset($aiomatic_Chatbot_Settings['allow_stream_stop'])) {
        $allow_stream_stop = $aiomatic_Chatbot_Settings['allow_stream_stop'];
    } else {
        $allow_stream_stop = '';
    }
    if (isset($aiomatic_Chatbot_Settings['strip_js'])) {
        $strip_js = $aiomatic_Chatbot_Settings['strip_js'];
    } else {
        $strip_js = '';
    }
    if (isset($aiomatic_Chatbot_Settings['scroll_bot'])) {
        $scroll_bot = $aiomatic_Chatbot_Settings['scroll_bot'];
    } else {
        $scroll_bot = '';
    }
    if (isset($aiomatic_Chatbot_Settings['send_message_sound'])) {
        $send_message_sound = $aiomatic_Chatbot_Settings['send_message_sound'];
    } else {
        $send_message_sound = '';
    }
    if (isset($aiomatic_Chatbot_Settings['receive_message_sound'])) {
        $receive_message_sound = $aiomatic_Chatbot_Settings['receive_message_sound'];
    } else {
        $receive_message_sound = '';
    }
    if (isset($aiomatic_Chatbot_Settings['response_delay'])) {
        $response_delay = $aiomatic_Chatbot_Settings['response_delay'];
    } else {
        $response_delay = '';
    }
    if (isset($aiomatic_Chatbot_Settings['instant_response'])) {
        $instant_response = $aiomatic_Chatbot_Settings['instant_response'];
    } else {
        $instant_response = '';
    }
    if (isset($aiomatic_Chatbot_Settings['voice_input'])) {
        $voice_input = $aiomatic_Chatbot_Settings['voice_input'];
    } else {
        $voice_input = '';
    }
    if (isset($aiomatic_Chatbot_Settings['auto_submit_voice'])) {
        $auto_submit_voice = $aiomatic_Chatbot_Settings['auto_submit_voice'];
    } else {
        $auto_submit_voice = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chat_download_format'])) {
        $chat_download_format = $aiomatic_Chatbot_Settings['chat_download_format'];
    } else {
        $chat_download_format = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chat_preppend_text'])) {
        $chat_preppend_text = $aiomatic_Chatbot_Settings['chat_preppend_text'];
    } else {
        $chat_preppend_text = '';
    }
    if (isset($aiomatic_Chatbot_Settings['user_message_preppend'])) {
        $user_message_preppend = $aiomatic_Chatbot_Settings['user_message_preppend'];
    } else {
        $user_message_preppend = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_message_preppend'])) {
        $ai_message_preppend = $aiomatic_Chatbot_Settings['ai_message_preppend'];
    } else {
        $ai_message_preppend = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_role'])) {
        $ai_role = $aiomatic_Chatbot_Settings['ai_role'];
    } else {
        $ai_role = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_first_message'])) {
        $ai_first_message = $aiomatic_Chatbot_Settings['ai_first_message'];
    } else {
        $ai_first_message = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_avatar'])) {
        $ai_avatar = $aiomatic_Chatbot_Settings['ai_avatar'];
    } else {
        $ai_avatar = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chat_mode'])) {
        $chat_mode = $aiomatic_Chatbot_Settings['chat_mode'];
    } else {
        $chat_mode = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chat_model'])) {
        $chat_model = $aiomatic_Chatbot_Settings['chat_model'];
    } else {
        $chat_model = get_default_model_name($aiomatic_Main_Settings);
    }
    if (isset($aiomatic_Chatbot_Settings['assistant_id'])) {
        $assistant_id = $aiomatic_Chatbot_Settings['assistant_id'];
    } else {
        $assistant_id = '';
    }
    if (isset($aiomatic_Chatbot_Settings['enable_vision'])) {
        $enable_vision = $aiomatic_Chatbot_Settings['enable_vision'];
    } else {
        $enable_vision = 'off';
    }
    if (isset($aiomatic_Chatbot_Settings['enable_file_uploads'])) {
        $enable_file_uploads = $aiomatic_Chatbot_Settings['enable_file_uploads'];
    } else {
        $enable_file_uploads = 'off';
    }
    if (isset($aiomatic_Chatbot_Settings['persistent'])) {
        $persistent = $aiomatic_Chatbot_Settings['persistent'];
    } else {
        $persistent = '';
    }
    if (isset($aiomatic_Chatbot_Settings['persistent_guests'])) {
        $persistent_guests = $aiomatic_Chatbot_Settings['persistent_guests'];
    } else {
        $persistent_guests = '';
    }
    if (isset($aiomatic_Chatbot_Settings['prompt_templates'])) {
        $prompt_templates = $aiomatic_Chatbot_Settings['prompt_templates'];
    } else {
        $prompt_templates = '';
    }
    if (isset($aiomatic_Chatbot_Settings['prompt_editable'])) {
        $prompt_editable = $aiomatic_Chatbot_Settings['prompt_editable'];
    } else {
        $prompt_editable = '';
    }
    if (isset($aiomatic_Chatbot_Settings['image_chat_size'])) {
        $image_chat_size = $aiomatic_Chatbot_Settings['image_chat_size'];
    } else {
        $image_chat_size = '512x512';
    }
    if (isset($aiomatic_Chatbot_Settings['image_chat_model'])) {
        $image_chat_model = $aiomatic_Chatbot_Settings['image_chat_model'];
    } else {
        $image_chat_model = 'dalle2';
    }
    if (isset($aiomatic_Chatbot_Settings['remote_chat'])) {
        $remote_chat = $aiomatic_Chatbot_Settings['remote_chat'];
    } else {
        $remote_chat = '';
    }
    if (isset($aiomatic_Chatbot_Settings['allow_chatbot_site'])) {
        $allow_chatbot_site = $aiomatic_Chatbot_Settings['allow_chatbot_site'];
    } else {
        $allow_chatbot_site = '';
    }
    if (isset($aiomatic_Chatbot_Settings['user_token_cap_per_day'])) {
        $user_token_cap_per_day = $aiomatic_Chatbot_Settings['user_token_cap_per_day'];
    } else {
        $user_token_cap_per_day = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_whitelisted_functions'])) {
        $god_whitelisted_functions = $aiomatic_Chatbot_Settings['god_whitelisted_functions'];
    } else {
        $god_whitelisted_functions = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_blacklisted_functions'])) {
        $god_blacklisted_functions = $aiomatic_Chatbot_Settings['god_blacklisted_functions'];
    } else {
        $god_blacklisted_functions = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_wp'])) {
        $god_mode_enable_wp = $aiomatic_Chatbot_Settings['god_mode_enable_wp'];
    } else {
        $god_mode_enable_wp = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_dalle'])) {
        $god_mode_enable_dalle = $aiomatic_Chatbot_Settings['god_mode_enable_dalle'];
    } else {
        $god_mode_enable_dalle = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_stable'])) {
        $god_mode_enable_stable = $aiomatic_Chatbot_Settings['god_mode_enable_stable'];
    } else {
        $god_mode_enable_stable = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_midjourney'])) {
        $god_mode_enable_midjourney = $aiomatic_Chatbot_Settings['god_mode_enable_midjourney'];
    } else {
        $god_mode_enable_midjourney = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_image_size_stable'])) {
        $ai_image_size_stable = $aiomatic_Chatbot_Settings['ai_image_size_stable'];
    } else {
        $ai_image_size_stable = '';
    }
    if (isset($aiomatic_Chatbot_Settings['stable_model'])) {
        $stable_model = $aiomatic_Chatbot_Settings['stable_model'];
    } else {
        $stable_model = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_image_model'])) {
        $ai_image_model = $aiomatic_Chatbot_Settings['ai_image_model'];
    } else {
        $ai_image_model = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_image_size'])) {
        $ai_image_size = $aiomatic_Chatbot_Settings['ai_image_size'];
    } else {
        $ai_image_size = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_dalle_failed'])) {
        $god_mode_dalle_failed = $aiomatic_Chatbot_Settings['god_mode_dalle_failed'];
    } else {
        $god_mode_dalle_failed = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_stable_failed'])) {
        $god_mode_stable_failed = $aiomatic_Chatbot_Settings['god_mode_stable_failed'];
    } else {
        $god_mode_stable_failed = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_stable_video'])) {
        $god_mode_enable_stable_video = $aiomatic_Chatbot_Settings['god_mode_enable_stable_video'];
    } else {
        $god_mode_enable_stable_video = '';
    }
    if (isset($aiomatic_Chatbot_Settings['ai_video_size_stable'])) {
        $ai_video_size_stable = $aiomatic_Chatbot_Settings['ai_video_size_stable'];
    } else {
        $ai_video_size_stable = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_amazon'])) {
        $god_mode_enable_amazon = $aiomatic_Chatbot_Settings['god_mode_enable_amazon'];
    } else {
        $god_mode_enable_amazon = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_amazon_details'])) {
        $god_mode_enable_amazon_details = $aiomatic_Chatbot_Settings['god_mode_enable_amazon_details'];
    } else {
        $god_mode_enable_amazon_details = '';
    }
    if (isset($aiomatic_Chatbot_Settings['affiliate_id'])) {
        $affiliate_id = $aiomatic_Chatbot_Settings['affiliate_id'];
    } else {
        $affiliate_id = '';
    }
    if (isset($aiomatic_Chatbot_Settings['target_country'])) {
        $target_country = $aiomatic_Chatbot_Settings['target_country'];
    } else {
        $target_country = '';
    }
    if (isset($aiomatic_Chatbot_Settings['listing_template'])) {
        $listing_template = $aiomatic_Chatbot_Settings['listing_template'];
    } else {
        $listing_template = '%%product_counter%%. %%product_title%% - Desciption: %%product_description%% - Link: %%product_url%% - Price: %%product_price%%';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_scraper'])) {
        $god_mode_enable_scraper = $aiomatic_Chatbot_Settings['god_mode_enable_scraper'];
    } else {
        $god_mode_enable_scraper = '';
    }
    if (isset($aiomatic_Chatbot_Settings['scrape_method'])) {
        $scrape_method = $aiomatic_Chatbot_Settings['scrape_method'];
    } else {
        $scrape_method = '0';
    }
    if (isset($aiomatic_Chatbot_Settings['strip_tags'])) {
        $strip_tags = $aiomatic_Chatbot_Settings['strip_tags'];
    } else {
        $strip_tags = '0';
    }
    if (isset($aiomatic_Chatbot_Settings['max_chars'])) {
        $max_chars = $aiomatic_Chatbot_Settings['max_chars'];
    } else {
        $max_chars = '0';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_rss'])) {
        $god_mode_enable_rss = $aiomatic_Chatbot_Settings['god_mode_enable_rss'];
    } else {
        $god_mode_enable_rss = '';
    }
    if (isset($aiomatic_Chatbot_Settings['max_rss_items'])) {
        $max_rss_items = $aiomatic_Chatbot_Settings['max_rss_items'];
    } else {
        $max_rss_items = '5';
    }
    if (isset($aiomatic_Chatbot_Settings['rss_template'])) {
        $rss_template = $aiomatic_Chatbot_Settings['rss_template'];
    } else {
        $rss_template = '[%%item_counter%%]: %%item_title%% - %%item_description%%';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_google'])) {
        $god_mode_enable_google = $aiomatic_Chatbot_Settings['god_mode_enable_google'];
    } else {
        $god_mode_enable_google = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_youtube_captions'])) {
        $god_mode_enable_youtube_captions = $aiomatic_Chatbot_Settings['god_mode_enable_youtube_captions'];
    } else {
        $god_mode_enable_youtube_captions = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_email'])) {
        $god_mode_enable_email = $aiomatic_Chatbot_Settings['god_mode_enable_email'];
    } else {
        $god_mode_enable_email = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_webhook'])) {
        $god_mode_enable_webhook = $aiomatic_Chatbot_Settings['god_mode_enable_webhook'];
    } else {
        $god_mode_enable_webhook = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_facebook_post'])) {
        $god_mode_enable_facebook_post = $aiomatic_Chatbot_Settings['god_mode_enable_facebook_post'];
    } else {
        $god_mode_enable_facebook_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['facebook_post_select'])) {
        $facebook_post_select = $aiomatic_Chatbot_Settings['facebook_post_select'];
    } else {
        $facebook_post_select = '';
    }
    if (isset($aiomatic_Chatbot_Settings['max_caption_length'])) {
        $max_caption_length = $aiomatic_Chatbot_Settings['max_caption_length'];
    } else {
        $max_caption_length = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_royalty'])) {
        $god_mode_enable_royalty = $aiomatic_Chatbot_Settings['god_mode_enable_royalty'];
    } else {
        $god_mode_enable_royalty = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_youtube'])) {
        $god_mode_enable_youtube = $aiomatic_Chatbot_Settings['god_mode_enable_youtube'];
    } else {
        $god_mode_enable_youtube = '';
    }
    if (isset($aiomatic_Chatbot_Settings['max_google_items'])) {
        $max_google_items = $aiomatic_Chatbot_Settings['max_google_items'];
    } else {
        $max_google_items = '5';
    }
    if (isset($aiomatic_Chatbot_Settings['google_template'])) {
        $google_template = $aiomatic_Chatbot_Settings['google_template'];
    } else {
        $google_template = '[%%item_counter%%]: %%item_title%% - %%item_snippet%%';
    }
    if (isset($aiomatic_Chatbot_Settings['sort_results'])) {
        $sort_results = $aiomatic_Chatbot_Settings['sort_results'];
    } else {
        $sort_results = 'none';
    }
    if (isset($aiomatic_Chatbot_Settings['max_products'])) {
        $max_products = $aiomatic_Chatbot_Settings['max_products'];
    } else {
        $max_products = '3-4';
    }  
    if (isset($aiomatic_Chatbot_Settings['god_preview'])) {
        $god_preview = $aiomatic_Chatbot_Settings['god_preview'];
    } else {
        $god_preview = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_twitter_post'])) {
        $god_mode_enable_twitter_post = $aiomatic_Chatbot_Settings['god_mode_enable_twitter_post'];
    } else {
        $god_mode_enable_twitter_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_instagram_post'])) {
        $god_mode_enable_instagram_post = $aiomatic_Chatbot_Settings['god_mode_enable_instagram_post'];
    } else {
        $god_mode_enable_instagram_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_pinterest_post'])) {
        $god_mode_enable_pinterest_post = $aiomatic_Chatbot_Settings['god_mode_enable_pinterest_post'];
    } else {
        $god_mode_enable_pinterest_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['pinterest_post_select'])) {
        $pinterest_post_select = $aiomatic_Chatbot_Settings['pinterest_post_select'];
    } else {
        $pinterest_post_select = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_google_post'])) {
        $god_mode_enable_google_post = $aiomatic_Chatbot_Settings['god_mode_enable_google_post'];
    } else {
        $god_mode_enable_google_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_youtube_post'])) {
        $god_mode_enable_youtube_post = $aiomatic_Chatbot_Settings['god_mode_enable_youtube_post'];
    } else {
        $god_mode_enable_youtube_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_reddit_post'])) {
        $god_mode_enable_reddit_post = $aiomatic_Chatbot_Settings['god_mode_enable_reddit_post'];
    } else {
        $god_mode_enable_reddit_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['subreddits_list'])) {
        $subreddits_list = $aiomatic_Chatbot_Settings['subreddits_list'];
    } else {
        $subreddits_list = '';
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_linkedin_post'])) {
        $god_mode_enable_linkedin_post = $aiomatic_Chatbot_Settings['god_mode_enable_linkedin_post'];
    } else {
        $god_mode_enable_linkedin_post = '';
    }
    if (isset($aiomatic_Chatbot_Settings['linkedin_selected_pages'])) {
        $linkedin_selected_pages = $aiomatic_Chatbot_Settings['linkedin_selected_pages'];
    } else {
        $linkedin_selected_pages = '';
    }
    if (isset($aiomatic_Chatbot_Settings['business_post_select'])) {
        $business_post_select = $aiomatic_Chatbot_Settings['business_post_select'];
    } else {
        $business_post_select = array();
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_front_end'])) {
        $god_mode_front_end = $aiomatic_Chatbot_Settings['god_mode_front_end'];
    } else {
        $god_mode_front_end = '';
    }
    if (isset($aiomatic_Chatbot_Settings['max_input_length'])) {
        $max_input_length = $aiomatic_Chatbot_Settings['max_input_length'];
    } else {
        $max_input_length = '';
    }
    if (isset($aiomatic_Chatbot_Settings['max_message_count'])) {
        $max_message_count = $aiomatic_Chatbot_Settings['max_message_count'];
    } else {
        $max_message_count = '';
    }
    if (isset($aiomatic_Chatbot_Settings['max_message_context'])) {
        $max_message_context = $aiomatic_Chatbot_Settings['max_message_context'];
    } else {
        $max_message_context = '';
    }
    if (isset($aiomatic_Chatbot_Settings['restriction_time'])) {
        $restriction_time = $aiomatic_Chatbot_Settings['restriction_time'];
    } else {
        $restriction_time = '';
    }
    if (isset($aiomatic_Chatbot_Settings['restriction_count'])) {
        $restriction_count = $aiomatic_Chatbot_Settings['restriction_count'];
    } else {
        $restriction_count = '';
    }
    if (isset($aiomatic_Chatbot_Settings['restriction_message'])) {
        $restriction_message = $aiomatic_Chatbot_Settings['restriction_message'];
    } else {
        $restriction_message = '';
    }
    if (isset($aiomatic_Chatbot_Settings['no_empty'])) {
        $no_empty = $aiomatic_Chatbot_Settings['no_empty'];
    } else {
        $no_empty = '';
    }
    if (isset($aiomatic_Chatbot_Settings['temperature'])) {
        $temperature = $aiomatic_Chatbot_Settings['temperature'];
    } else {
        $temperature = '1';
    }
    if (isset($aiomatic_Chatbot_Settings['top_p'])) {
        $top_p = $aiomatic_Chatbot_Settings['top_p'];
    } else {
        $top_p = '1';
    }
    if (isset($aiomatic_Chatbot_Settings['presence_penalty'])) {
        $presence_penalty = $aiomatic_Chatbot_Settings['presence_penalty'];
    } else {
        $presence_penalty = '0';
    }
    if (isset($aiomatic_Chatbot_Settings['frequency_penalty'])) {
        $frequency_penalty = $aiomatic_Chatbot_Settings['frequency_penalty'];
    } else {
        $frequency_penalty = '0';
    }
    if (isset($aiomatic_Chatbot_Settings['enable_front_end'])) {
        $enable_front_end = $aiomatic_Chatbot_Settings['enable_front_end'];
    } else {
        $enable_front_end = '';
    }
    if (isset($aiomatic_Chatbot_Settings['custom_global_shortcode'])) {
        $custom_global_shortcode = $aiomatic_Chatbot_Settings['custom_global_shortcode'];
    } else {
        $custom_global_shortcode = '';
    }
    if (isset($aiomatic_Chatbot_Settings['window_location'])) {
        $window_location = $aiomatic_Chatbot_Settings['window_location'];
    } else {
        $window_location = '';
    }
    if (isset($aiomatic_Chatbot_Settings['page_load_chat'])) {
        $page_load_chat = $aiomatic_Chatbot_Settings['page_load_chat'];
    } else {
        $page_load_chat = '';
    }
    if (isset($aiomatic_Chatbot_Settings['window_width'])) {
        $window_width = $aiomatic_Chatbot_Settings['window_width'];
    } else {
        $window_width = '';
    }
    if (isset($aiomatic_Chatbot_Settings['not_show_urls'])) {
        $not_show_urls = $aiomatic_Chatbot_Settings['not_show_urls'];
    } else {
        $not_show_urls = '';
    }
    if (isset($aiomatic_Chatbot_Settings['only_show_urls'])) {
        $only_show_urls = $aiomatic_Chatbot_Settings['only_show_urls'];
    } else {
        $only_show_urls = '';
    }
    if (isset($aiomatic_Chatbot_Settings['min_time'])) {
        $min_time = $aiomatic_Chatbot_Settings['min_time'];
    } else {
        $min_time = '';
    }
    if (isset($aiomatic_Chatbot_Settings['never_show'])) {
        $never_show = $aiomatic_Chatbot_Settings['never_show'];
    } else {
        $never_show = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_content_wp'])) {
        $show_content_wp = $aiomatic_Chatbot_Settings['show_content_wp'];
    } else {
        $show_content_wp = array();
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_content_wp'])) {
        $no_show_content_wp = $aiomatic_Chatbot_Settings['no_show_content_wp'];
    } else {
        $no_show_content_wp = array();
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_locales'])) {
        $no_show_locales = $aiomatic_Chatbot_Settings['no_show_locales'];
    } else {
        $no_show_locales = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_locales'])) {
        $show_locales = $aiomatic_Chatbot_Settings['show_locales'];
    } else {
        $show_locales = array();
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_roles'])) {
        $no_show_roles = $aiomatic_Chatbot_Settings['no_show_roles'];
    } else {
        $no_show_roles = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_roles'])) {
        $show_roles = $aiomatic_Chatbot_Settings['show_roles'];
    } else {
        $show_roles = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_devices'])) {
        $show_devices = $aiomatic_Chatbot_Settings['show_devices'];
    } else {
        $show_devices = array();
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_devices'])) {
        $no_show_devices = $aiomatic_Chatbot_Settings['no_show_devices'];
    } else {
        $no_show_devices = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_oses'])) {
        $show_oses = $aiomatic_Chatbot_Settings['show_oses'];
    } else {
        $show_oses = array();
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_oses'])) {
        $no_show_oses = $aiomatic_Chatbot_Settings['no_show_oses'];
    } else {
        $no_show_oses = array();
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_browsers'])) {
        $no_show_browsers = $aiomatic_Chatbot_Settings['no_show_browsers'];
    } else {
        $no_show_browsers = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_browsers'])) {
        $show_browsers = $aiomatic_Chatbot_Settings['show_browsers'];
    } else {
        $show_browsers = array();
    }
    if (isset($aiomatic_Chatbot_Settings['show_ips'])) {
        $show_ips = $aiomatic_Chatbot_Settings['show_ips'];
    } else {
        $show_ips = '';
    }
    if (isset($aiomatic_Chatbot_Settings['no_show_ips'])) {
        $no_show_ips = $aiomatic_Chatbot_Settings['no_show_ips'];
    } else {
        $no_show_ips = '';
    }
    if (isset($aiomatic_Chatbot_Settings['always_show'])) {
        $always_show = $aiomatic_Chatbot_Settings['always_show'];
    } else {
        $always_show = array();
    }
    if (isset($aiomatic_Chatbot_Settings['max_time'])) {
        $max_time = $aiomatic_Chatbot_Settings['max_time'];
    } else {
        $max_time = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chatbot_icon_html'])) {
        $chatbot_icon_html = $aiomatic_Chatbot_Settings['chatbot_icon_html'];
    } else {
        $chatbot_icon_html = '';
    }
    if (isset($aiomatic_Chatbot_Settings['chatbot_icon'])) {
        $chatbot_icon = $aiomatic_Chatbot_Settings['chatbot_icon'];
    } else {
        $chatbot_icon = '';
    }
    if (isset($aiomatic_Chatbot_Settings['aiomatic_chat_json'])) {
        $aiomatic_chat_json = $aiomatic_Chatbot_Settings['aiomatic_chat_json'];
    } else {
        $aiomatic_chat_json = '';
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
?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
    <h2 class="cr_center"><?php echo esc_html__("AI Chatbot", 'aiomatic-automatic-ai-content-writer');?></h2>
    <nav class="nav-tab-wrapper">
        <a href="#tab-t" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-0"<?php if ($assistant_id != ''){echo ' class="nav-tab aiomatic-tab-disabled" title="Disabled when using Assistants"';}else{echo ' class="nav-tab"';}?>><?php echo esc_html__("Persona Selector", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-10"<?php if ($assistant_id != ''){echo ' class="nav-tab aiomatic-tab-disabled" title="Disabled when using Assistants"';}else{echo ' class="nav-tab"';}?>><?php echo esc_html__("Persona Manager", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-4" class="nav-tab"><?php echo esc_html__("API Parameters", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-12" class="nav-tab"><?php echo esc_html__("Chatbot Context Details", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Styling", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-2" class="nav-tab"><?php echo esc_html__("Moderation", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-5" class="nav-tab"><?php echo esc_html__("Global Chatbots", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-11" class="nav-tab"><?php echo esc_html__("Limitations", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-8" class="nav-tab"><?php echo esc_html__("Text-to-Speech/Video", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-13" class="nav-tab"><?php echo esc_html__("PDF Chat", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-15" class="nav-tab"><?php echo esc_html__("Remote Chatbot", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-7" class="nav-tab"><?php echo esc_html__("Custom Chatbot Builder", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-6" class="nav-tab"><?php echo esc_html__("Persistent Chat Logs", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-14" class="nav-tab"><?php echo esc_html__("Extensions", 'aiomatic-automatic-ai-content-writer');?></a>
        <a href="#tab-3" class="nav-tab"><?php echo esc_html__("Settings", 'aiomatic-automatic-ai-content-writer');?></a>
    </nav>
        <form autocomplete="off" id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
        <div class="cr_autocomplete">
 <input type="password" id="PreventChromeAutocomplete" 
  name="PreventChromeAutocomplete" autocomplete="address-level4" />
</div>
<?php
    settings_fields('aiomatic_option_group4');
    do_settings_sections('aiomatic_option_group4');
    if (isset($_GET['settings-updated'])) {
?>
<div id="message" class="updated">
<p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'aiomatic-automatic-ai-content-writer');?></strong></p>
</div>
<?php
}
?>
<div class="aiomatic_class">
<div id="tab-t" class="tab-content">
<br/>
<h3><?php echo esc_html__("AI Chatbot Configuration Details", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__('In this tutorial, I\'ll walk through the process of setting up an AI-powered chatbot on your WordPress website using the Aiomatic WordPress plugin. This plugin allows you to integrate AI language models to create a highly customizable chatbot that can interact with your website visitors.', 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 1: Customize the Chatbot Behavior", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("In the Aiomatic settings page, navigate to the \"AI Chatbot\" menu of the plugin. You will be able to customize the chatbot in the 'Chatbot Customization', 'Chatbot Default Styling', 'Chatbot Settings' and 'Default API Parameters' tabs. Here, you can define how the chatbot will respond to specific user inputs. You can also change the visual style and appearance of the chatbot. Don't forget to always save your changes.", 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 2: Add the Chatbot to Your Website", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("You can add the chatbot globally to your site or locally to posts or pages. To add the chatbot locally, you can use the [aiomatic-chat-form] shortcode. If you want to add it globally, you need to go to the settings page of the plugin, go to the \"AI Chatbot\" menu of the plugin and navigate to the 'Global Chatbots' tab. Choose where you want the chatbot to appear on your website (e.g., on all front end, back end, except pages where you don't want the chatbot to appear).", 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 3: Test the Chatbot", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("Visit your website and look for the chatbot. Interact with the chatbot by typing questions or phrases into the chat window. Verify that the chatbot responds appropriately based on the rules you defined.", 'aiomatic-automatic-ai-content-writer');?></p>
<p><?php echo esc_html__("That's it! You've successfully set up an AI-powered chatbot on your WordPress website using the Aiomatic plugin. This chatbot can be a valuable tool for engaging with your website visitors, answering frequently asked questions, and providing personalized assistance.", 'aiomatic-automatic-ai-content-writer');?></p>
<h3><?php echo esc_html__("AI Chatbot Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/QCkNkCrFi-o" frameborder="0" allowfullscreen></iframe></div></p>
</div>
<div id="tab-0" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Persona Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the name of the AI Assistant. This will be prepended to each AI message. This is useful to teach the AI chatbot about its role and name. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea id="ai_name" rows="2" name="aiomatic_Chatbot_Settings[ai_message_preppend]" placeholder="AI"><?php
    echo esc_textarea($ai_message_preppend);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the role of the AI Assistant. This info is only informative, will appear only in the chatbot interface, is not sent to the AI writer. Be sure to add the role in the 'Chatbot Context' settings field, for it to take effect in the AI writer.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Assistant Role:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea id="ai_role" rows="2" name="aiomatic_Chatbot_Settings[ai_role]" placeholder="AI Assistant role"><?php
    echo esc_textarea($ai_role);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Add a context to the AI chatbot, so it knows how to act and how to respond to customers. You can define here the language, tone of voice and role of the AI assistant. Any other settings will also be able to be defined here. This text will be preppended to each conversation, to teach the AI some additional info about you or its behavior. This text will not be displayed to users, it will be only sent to the chatbot. You can also use shortcodes in this field. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). Example of prompt to pretain the AI --- Article: \"%%post_content%%\" \n\n Discussion: \n\n", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Context:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea id="preppend_text" rows="6" name="aiomatic_Chatbot_Settings[chat_preppend_text]" placeholder="Example: Converse as if you were a Marketing Agency Assistant. Be friendly, creative. Respond only in English."><?php
    echo esc_textarea($chat_preppend_text);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the name of the AI. This will be prepended to each AI message. This is useful to teach the AI chatbot about its role and name. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Initial Messages (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="2" id="first_message_ai" name="aiomatic_Chatbot_Settings[ai_first_message]" placeholder="Hi! How can I help you?"><?php
    echo esc_textarea($ai_first_message);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the avatar image of the AI. This will be shown in the chatbot interface.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Avatar Image:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
$add_src = '';
if(is_numeric($ai_avatar))
{
    $att_src = wp_get_attachment_image_src( $ai_avatar, 'thumbnail', false );
    if ( $att_src && $att_src[0] != false )
    {
        $add_src = ' src="' . $att_src[0] . '"';
    }
}
        $image = '<div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image"' . $add_src . '/></div>';
        echo $image; ?>
            <input type="hidden" name="aiomatic_Chatbot_Settings[ai_avatar]" id="aiomatic_image_id" value="<?php echo $ai_avatar;?>" class="regular-text" />
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager"/>
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Clear avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_clear"/>
                        
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the name of the user. This will be prepended to each user message. This is useful to teach the AI chatbot about its role and name. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("User Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="2" name="aiomatic_Chatbot_Settings[user_message_preppend]" placeholder="User"><?php
    echo esc_textarea($user_message_preppend);
?></textarea>
        </div>
        </td></tr>
        <tr><td colspan="2">
            <hr/>
        <h2><?php echo esc_html__("Select A Chatbot Persona: ", 'aiomatic-automatic-ai-content-writer');?>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Click the persona you want to use in your chatbot and it will be selected and its values will be automatically filled in the settings fields from above. All you have to do afterwards, is to save settings and the chatbot persona will be applied to the chatbot!", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div></h2>
        <br/>
</td></tr>
<tr><td colspan="2">
<div class="row" id="aiomatic-templates-panel">
<?php
$aiomatic_persona_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_personas = new WP_Query(array(
    'post_type' => 'aiomatic_personas',
    'posts_per_page' => 40,
    'paged' => $aiomatic_persona_page,
    'order' => 'DESC',
    'orderby' => 'date',
    'post_status' => 'any'
));
if(!$aiomatic_personas->have_posts())
{
    echo '&nbsp;&nbsp;&nbsp;' . esc_html__("No chatbot personas added. Add them in the 'Manage Chatbot Personas' tab.", 'aiomatic-automatic-ai-content-writer');
}
else
{
    foreach ($aiomatic_personas->posts as $aiomatic_persona)
    {
        echo '<div class="aiomatic-col-lg-3"><div class="aiomatic-chat-boxes aiomatic-text-center"><div class="aiomatic-card" onclick="aiomatic_select_persona(' . $aiomatic_persona->ID . ');"><div class="aiomatic-card-body">';
        $att_src = get_the_post_thumbnail_url( $aiomatic_persona->ID, 'thumbnail' );
        if ( $att_src )
        {
            echo '<div class="aiomatic-widget-user-image"><img alt="User Avatar" class="ai-user-avatar aiomatic-rounded-circle" src="' . $att_src . '"></div>';
        }
        else
        {
            echo '<div class="aiomatic-widget-user-image">' . esc_html__("No avatar added", 'aiomatic-automatic-ai-content-writer') . '</div>';
        }
        echo '<div class="aiomatic-template-title"><h6 class="aiomatic-number-font">' . esc_html($aiomatic_persona->post_title) . '</h6></div><div class="aiomatic-template-info"><p class="aiomatic-text-muted">' . esc_html($aiomatic_persona->post_excerpt) . '</p></div>';
        echo '</div></div></div></div>';
    }
}
?>
</div>
<?php
if($aiomatic_personas->have_posts() && $aiomatic_personas->max_num_pages > 1)
{
?>
<div class="aiomatic-paginate">
    <?php
    echo esc_html__("Page: ", 'aiomatic-automatic-ai-content-writer') . paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_chatbot_panel&wpage=%#%'),
        'total'        => $aiomatic_personas->max_num_pages,
        'current'      => $aiomatic_persona_page,
        'format'       => '?wpage=%#%',
        'show_all'     => false,
        'prev_next'    => true,
        'add_args'     => false,
    ));
    ?>
</div>
<?php
}
?>
</td>
</tr>
</table>
</div>
<div id="tab-7" class="tab-content">
    <table class="widefat">
    <tr><td><h2><?php echo esc_html__("Use the following shortcode to add the customized chatbot to your site:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
    <tr><td colspan="2" class="cr_width_full"><div class="cr_center"><span class="cr_red cr_center cr_width_full cr_margin_block crf_bord" id="customized_chatbot">[aiomatic-chat-form temperature="1" top_p="1" assistant_id="" model="gpt-3.5-turbo" enable_vision="off" presence_penalty="0" frequency_penalty="0" instant_response="false" ai_role="" ai_avatar="" chat_preppend_text="Act as a customer assistant, respond to every question in a helpful way." chatbot_text_speech="off" upload_pdf="" enable_god_mode="disabled" user_message_preppend="User" show_header="" show_clear="" show_dltxt="" show_mute="" show_internet="" overwrite_voice="" overwrite_avatar_image="" internet_access="enabled" embeddings="enabled" ai_message_preppend="AI" ai_first_message="Hello, how can I help you today?" chat_mode="text" persistent="off" prompt_templates="" prompt_editable="on" placeholder="Enter your chat message here" select_prompt="Please select a prompt" file_uploads="off" custom_header="" custom_footer="" custom_css="" send_message_sound="" receive_message_sound="" response_delay="" submit="Submit" compliance="" show_in_window="off" window_location="top-right" font_size="1em" height="100%" background="auto" general_background="#ffffff" minheight="250px" user_font_color="#ffffff" user_background_color="#0084ff" ai_font_color="#000000" ai_background_color="#f0f0f0" input_placeholder_color="#333333" persona_name_color="#3c434a" persona_role_color="#728096" input_text_color="#000000" input_border_color="#e1e3e6" submit_color="#55a7e2" submit_text_color="#ffffff" voice_color="#55a7e2" voice_color_activated="#55a7e2" width="100%"]</span><button class="page-title-action aimt-10" id="aiomaticCopyShortcodeText"><?php echo esc_html__("Copy Text", 'aiomatic-automatic-ai-content-writer');?></button></div><br/></td></tr>
    
    <tr><td colspan="2">
<hr/></td></tr><tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot API Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
</td></tr>
<tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the assistant to be used for chatbot. The model used when creating the AI Assistant will be used to create the content.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Chatbot Assistant Name (Using This Disables Chatbot Personas):", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="assistant_id_b" onchange="anythingChanged();assistantChanged_b();" class="cr_width_full">
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
        if ($assistant_id == '') 
        {
        echo " selected";
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if ($assistant_id == $myassistant->ID) 
            {
            echo " selected";
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
    <tr class="hideAssist_b">
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable file upload for the chatbot. Note that to use this feature, you will need an AI model which supports file search. Supported file types: .c, .cs, .cpp, .doc, .docx, .html, .java, .json, .md, .pdf, .php, .pptx, .py, .rb, .tex, .txt, .css, .js, .sh, .ts", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable File Uploads In The Chatbot (Using AI Assistants File Search):", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select autocomplete="off" id="enable_file_uploads_b" onchange="anythingChanged();" class="cr_width_full">
        <option value="on" <?php if($enable_file_uploads == 'on'){echo ' selected';}?> ><?php echo esc_html__("On", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="off" <?php if($enable_file_uploads == 'off'){echo ' selected';}?> ><?php echo esc_html__("Off", 'aiomatic-automatic-ai-content-writer');?></option>
    </select>
    </td>
    </tr>
    <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the model of the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="model_b" onchange="anythingChanged();" class="hideAssistantID cr_width_full" >
<?php
echo '<option selected value="default">default</option>';
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($chat_model == $modelx) 
{
echo " selected";
}
echo '>' . esc_html($modelx);
if(aiomatic_is_vision_model($modelx, ''))
{
    echo esc_html__(" (Vision)", 'aiomatic-automatic-ai-content-writer');
}
echo esc_html(aiomatic_get_model_provider($modelx));
echo '</option>';
}
?>
?>
                    </select>
        </div>
        </td></tr>
    <tr class="hideVision_b">
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable vision for the chatbot. Note that to use this feature, you will need an AI model which supports vision.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable Chatbot Vision:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select autocomplete="off" id="enable_vision_b" name="aiomatic_Chatbot_Settings[enable_vision]" class="hideAssistantIDVision cr_width_full" onchange="anythingChanged();">
        <option value="on" <?php if($enable_vision == 'on'){echo ' selected';}?> ><?php echo esc_html__("On", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="off" <?php if($enable_vision == 'off'){echo ' selected';}?> ><?php echo esc_html__("Off", 'aiomatic-automatic-ai-content-writer');?></option>
    </select>
    </td>
    </tr>
        <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="0" step="0.1" id="temperature_b" max="2" class="hideAssistantID cr_width_full" onchange="anythingChanged();" value="<?php echo esc_html($temperature);?>" placeholder="1">
        </td></tr><tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="0" step="0.1" max="1" id="top_p_b" class="hideAssistantID cr_width_full" onchange="anythingChanged();" value="<?php echo esc_html($top_p);?>" placeholder="1">
        </td></tr><tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="-2" step="0.1" max="2" id="presence_penalty_b" class="hideAssistantID cr_width_full" onchange="anythingChanged();" value="<?php echo esc_html($presence_penalty);?>" placeholder="0">
        </td></tr><tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="-2" step="0.1" max="2" id="frequency_penalty_b" class="hideAssistantID cr_width_full" onchange="anythingChanged();" value="<?php echo esc_html($frequency_penalty);?>" placeholder="0">
        </td></tr>
        <tr><td>
        <h2><?php echo esc_html__("Chatbot Persona Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the chatbot persona you want to use for your current chatbot setup.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Persona:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </td>
            <td>
            <select id="persona_b" onchange="personaChanged();" class="hideAssistantID cr_width_full">
        <?php
$post_list = array();
$postsPerPage = 50000;
$paged = 0;
do
{
    $postOffset = $paged * $postsPerPage;
    $query = array(
        'post_status' => array(
            'publish'
        ),
        'post_type' => array(
            'aiomatic_personas'
        ),
        'numberposts' => $postsPerPage,
        'offset'  => $postOffset
    );
    $got_me = get_posts($query);
    $post_list = array_merge($post_list, $got_me);
    $paged++;
}while(!empty($got_me));
if(count($post_list) == 0)
{
    echo '<option value="" disabled>' . esc_html__("No chatbot personas added. Add them in the 'Manage Chatbot Personas' tab.", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
    echo '<option value="" disabled selected>' . esc_html__("Select a persona", 'aiomatic-automatic-ai-content-writer') . '</option>';
    foreach ($post_list as $aiomatic_persona) 
    {
        echo '<option value="' . esc_html($aiomatic_persona->ID) . '">' . esc_html($aiomatic_persona->post_title) . ' (' . esc_html($aiomatic_persona->post_excerpt) . ')' . '</option>';
    }
}
?>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the name of the AI. This will be prepended to each AI message. This is useful to teach the AI chatbot about its role and name.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea id="ai_name_b" rows="2" onchange="anythingChanged();" placeholder="AI" class="hideAssistantID"><?php
    echo esc_textarea($ai_message_preppend);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the role of the AI Assistant. This info is only informative, will appear only in the chatbot interface, is not sent to the AI writer. Be sure to add the role in the 'Chatbot Context' settings field, for it to take effect in the AI writer.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Assistant Role:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="2" id="ai_role_b" onchange="anythingChanged();" placeholder="AI Assistant role" class="hideAssistantID"><?php
    echo esc_textarea($ai_role);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Add a context to the AI chatbot, so it knows how to act and how to respond to customers. You can define here the language, tone of voice and role of the AI assistant. Any other settings will also be able to be defined here. This text will be preppended to each conversation, to teach the AI some additional info about you or its behavior. This text will not be displayed to users, it will be only sent to the chatbot. You can also use shortcodes in this field. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). Example of prompt to pretain the AI --- Article: \"%%post_content%%\" \n\n Discussion: \n\n", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Context:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="4" id="context_b" onchange="anythingChanged();" rows="2" class="hideAssistantID" placeholder="Example: Converse as if you were a Marketing Agency Assistant. Be friendly, creative. Respond only in English."><?php
    echo esc_textarea($chat_preppend_text);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the name of the AI. This will be prepended to each AI message. This is useful to teach the AI chatbot about its role and name.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Initial Messages (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea id="ai_message_b" onchange="anythingChanged();" rows="2" class="hideAssistantID" placeholder="Hi! How can I help you?"><?php
    echo esc_textarea($ai_first_message);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the avatar image of the AI. This will be shown in the chatbot interface.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Avatar Image:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
$add_src = '';
if(is_numeric($ai_avatar))
{
    $att_src = wp_get_attachment_image_src( $ai_avatar, 'thumbnail', false );
    if ( $att_src && $att_src[0] != false )
    {
        $add_src = ' src="' . $att_src[0] . '"';
    }
}
        $image = '<div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image-b"' . $add_src . '/></div>';
        echo $image; ?>
            <input type="hidden" id="aiomatic_image_id_b" value="<?php echo $ai_avatar;?>" class="regular-text" />
            <input type='button' class="hideAssistantID button-primary" value="<?php esc_attr_e( 'Select an avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager_b"/>
            <input type='button' class="hideAssistantID button-primary" value="<?php esc_attr_e( 'Clear avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_clear_b"/>
                        
        </div>
        </td></tr>
        <tr><td>
        <h2><?php echo esc_html__("Chatbot Context Details:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the name of the user. This will be prepended to each user message. This is useful to teach the AI chatbot about its role and name.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("User Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea id="user_name_b" rows="2" onchange="anythingChanged();" class="hideAssistantID" placeholder="User"><?php
    echo esc_textarea($user_message_preppend);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the placeholder text of the chat input. The default is: Enter your chat message here.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Input Placeholder:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" id="placeholder_b" placeholder="Enter your chat message here" onchange="anythingChanged()"><?php
    echo esc_textarea($placeholder);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the text of the submit button. The default is: Submit", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Input Submit Button Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" id="submit_b" placeholder="Submit" onchange="anythingChanged()"><?php
    echo esc_textarea($submit);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the compliance text which will be shown at the bottom of the chatbot (default is empty).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Compliance Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" id="compliance_b" placeholder="Compliance text" onchange="anythingChanged()"><?php
    echo esc_textarea($compliance);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the text of the prompt selection placeholder. The default is: Please select a prompt", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Text For Prompt Templates Selection:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" id="select_prompt_b" placeholder="Please select a prompt" onchange="anythingChanged()"><?php
    echo esc_textarea($select_prompt);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
    <h2><?php echo esc_html__("Chatbot General Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to make the chatbot respond with full text or do you want to enable a typing effect, so text will appear gradually. You can also use streaming, which is the recommended method to be used, as in this case, the plugin will show the response in real time, as it is generated by the AI (similar to ChatGPT).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Instant Responses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="instant_response_b" onchange="anythingChanged();" class="cr_width_full">
    <?php
echo '<option' . ($instant_response == 'on' ? ' selected': '') . ' value="on">on</option>';
echo '<option' . ($instant_response == 'stream' ? ' selected': '') . ' value="stream">stream</option>';
echo '<option' . ($instant_response == 'off' ? ' selected': '') . ' value="off">off</option>';
?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a sound effect to be played when a message is sent in the chatbot. To disable this feature, leave this settings field blank. You can get free sound effects from here: https://pixabay.com/sound-effects/search/notification/?order=ec", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot 'Send Message' Sound Effect:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" placeholder="<?php echo esc_html__("Upload your 'Send Message' sound effect file using the button from below", 'aiomatic-automatic-ai-content-writer');?>" onchange="anythingChanged();" id="send_message_sound_b" value="<?php echo esc_attr($send_message_sound); ?>" />
                    <button class="button" id="aiomatic_upload_send_sound_button_b"><?php echo esc_html__("Upload a 'Send Message' sound effect", 'aiomatic-automatic-ai-content-writer');?></button>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a sound effect to be played when a message is received in the chatbot. To disable this feature, leave this settings field blank. You can get free sound effects from here: https://pixabay.com/sound-effects/search/notification/?order=ec", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot 'Receive Message' Sound Effect:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" placeholder="<?php echo esc_html__("Upload your 'Receive Message' sound effect file using the button from below", 'aiomatic-automatic-ai-content-writer');?>" onchange="anythingChanged();" id="receive_message_sound_b" value="<?php echo esc_attr($receive_message_sound); ?>" />
                    <button class="button" id="aiomatic_upload_receive_sound_button_b"><?php echo esc_html__("Upload a 'Receive Message' sound effect", 'aiomatic-automatic-ai-content-writer');?></button>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a number of milliseconds to set as a delay for the chatbot. You can also set an interval between two values (in ms), case in which, the chatbot will select a random number of milliseconds from that interval, at each response.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Response Delay (ms):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" placeholder="<?php echo esc_html__("Example: 100-500", 'aiomatic-automatic-ai-content-writer');?>" id="response_delay_b" onchange="anythingChanged();" value="<?php echo esc_attr($response_delay); ?>" />
        </div>
        </td></tr>
        <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the default chat mode (image or text).", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Default Chat Mode:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="chat_mode_b" onchange="anythingChanged();" class="cr_width_full">
    <?php
echo '<option' . ($chat_mode == 'text' ? ' selected': '') . ' value="text">Text</option>';
echo '<option' . ($chat_mode == 'images' ? ' selected': '') . ' value="images">Image</option>';
?>
    </select>  
    </td>
    </tr>
        <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable the persistent chat mode. Chats will be saved in the database and can be viewed from the 'Limits and Statistics' menu of the plugin. If you want to enable the Vector Database persistent chat functionality, you need to add your API key for a Vector Database Service in the plugin's 'Settings' menu. Also, you need to enable embeddings for the chatbot, from the 'Settings' menu -> 'Embeddings' tab -> 'Enable Embeddings For' -> check the 'Chatbot Shortcodes' checkbox -> save settings.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Persistent Chat:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="persistent_b" onchange="anythingChanged();" class="cr_width_full">
    <?php
echo '<option' . ($persistent == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($persistent == 'on' ? ' selected': '') . ' value="on">On (Local Storage)</option>';
echo '<option' . ($persistent == 'logs' ? ' selected': '') . ' value="logs">On (Local Storage), Only Save Chat Logs</option>';
echo '<option' . ($persistent == 'vector' ? ' selected': '') . ' value="vector"';
if($pinecone_app_id == '' && $qdrant_app_id == '')
{
    echo ' disabled title="You need to set up a Pinecone or a Qdrant API keys in plugin settings for this to work"';
}
echo '>' . esc_html__("On (Vector Database Storage), Auto Create Embeddings From User Messages", 'aiomatic-automatic-ai-content-writer') . '</option>';
?>
    </select>  
    </td>
    </tr><tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable Chatbot internet access for this specific chatbot? To enable internet access, you have to go to the 'Settings' menu -> 'AI Internet Access' tab -> 'Enable AI Internet Access For' -> check the 'Chatbot Shortcodes' checkbox -> save settings.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable Chatbot Internet Access:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="no_internet_b" <?php if(!isset($aiomatic_Main_Settings['internet_chat_short']) || $aiomatic_Main_Settings['internet_chat_short'] != 'on'){ echo ' disabled title="' . esc_html__("For this to work, you need to enable internet access for the chatbot in the 'Settings' menu -> 'AI Internet Access' tab -> 'Chatbot Shortcodes' checkbox", 'aiomatic-automatic-ai-content-writer') . '"';}?> onchange="anythingChanged();" class="cr_width_full">
    <?php
echo '<option selected value="enabled">Enabled</option>';
echo '<option value="disabled">Disabled</option>';
?>
    </select>  
    </td>
    </tr><tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable Chatbot embeddings for this specific chatbot? To enable embeddings, you have to go to the 'Settings' menu -> 'Embeddings' tab -> 'Enable Embeddings For' -> check the 'Chatbot Shortcodes' checkbox -> save settings.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable Chatbot Embeddings:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="no_embeddings_b" <?php if($pinecone_app_id == '' && $qdrant_app_id == ''){echo ' disabled title="You need to set up a Pinecone or a Qdrant API keys in plugin settings for this to work"';}else{if(!isset($aiomatic_Main_Settings['embeddings_chat_short']) || $aiomatic_Main_Settings['embeddings_chat_short'] != 'on'){ echo ' disabled title="' . esc_html__("For this to work, you need to enable embeddings for the chatbot in the 'Settings' menu -> 'Embeddings' tab -> 'Chatbot Shortcodes' checkbox", 'aiomatic-automatic-ai-content-writer') . '"';}}?> onchange="anythingChanged();" class="cr_width_full">
    <?php
echo '<option selected value="enabled">Enabled</option>';
echo '<option value="disabled">Disabled</option>';
?>
    </select>  
    </td>
    </tr>
    <tr><td>
    <div>
    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
<?php
echo esc_html__("Select if you want to enable the prompts to be user editable. You should use this feature only together with the prompt templates feature.", 'aiomatic-automatic-ai-content-writer');
?>
                    </div>
                </div>
                <b><?php echo esc_html__("Prompt Templates:", 'aiomatic-automatic-ai-content-writer');?></b>
                </div>
                </td><td>
                <div>
                <textarea rows="2" onchange="anythingChanged();" id="template_b" placeholder="Add a semicolon (;) separated list of prompt templates from which the users will be able to select and submit one."><?php
echo esc_textarea($prompt_templates);
?></textarea>
    </div>
    </td></tr>
    <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable the prompts to be user editable. You should use this feature only together with the prompt templates feature.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Prompts Editable By Users:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="prompt_editable_b" onchange="anythingChanged();" class="cr_width_full">
    <?php
echo '<option' . ($prompt_editable == 'on' ? ' selected': '') . ' value="on">On</option>';
echo '<option' . ($prompt_editable == 'off' ? ' selected': '') . ' value="off">Off</option>';
?>
    </select>  
    </td>
    </tr>
    <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to inject the chatbot globally, to the entire front end and/or back end of your site.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Inject Chatbot Globally To Your Site:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="enable_front_end_b" onchange="anythingChanged();" class="cr_width_full">
<?php
echo '<option' . ($enable_front_end == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($enable_front_end == 'front' ? ' selected': '') . ' value="front">Front End</option>';
echo '<option' . ($enable_front_end == 'back' ? ' selected': '') . ' value="back">Back End</option>';
echo '<option' . ($enable_front_end == 'both' ? ' selected': '') . ' value="both">Front End & Back End</option>';
?>
</select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select where you want to show the embedded chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Location:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="window_location_b" onchange="anythingChanged();" class="cr_width_full">
<?php
echo '<option' . ($window_location == 'bottom-right' ? ' selected': '') . ' value="bottom-right">Bottom Right</option>';
echo '<option' . ($window_location == 'bottom-left' ? ' selected': '') . ' value="bottom-left">Bottom Left</option>';
echo '<option' . ($window_location == 'top-right' ? ' selected': '') . ' value="top-right">Top Right</option>';
echo '<option' . ($window_location == 'top-left' ? ' selected': '') . ' value="top-left">Top Left</option>';
?>
</select>
        </div>
        </td></tr>
<?php
if(!function_exists('is_plugin_active'))
{
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
$all_ok = true;
$issue_counter = 1;
if (!is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
{
    $all_ok = false;
}
if($pinecone_app_id == '' && $qdrant_app_id == '')
{
    $all_ok = false;
}
if (!isset($aiomatic_Main_Settings['embeddings_chat_short']) || trim($aiomatic_Main_Settings['embeddings_chat_short']) != 'on')
{
    $all_ok = false;
}
?>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable users to upload PDF files to the chatbot. This will require some prerequisites to function, please check the 'PDF Chat' tab for details.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Users To Upload PDF Files To The Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="upload_pdf_b" <?php if($all_ok === false){echo ' disabled title="Feature not available, check the \'PDF Chat\' tab for details"';}?> onchange="anythingChanged();" >
<?php
echo '<option value="disabled"';
if ($upload_pdf !== 'on' || $all_ok == false)
{
    echo ' selected';
}
echo '>Disabled</option>';
echo '<option value="enabled"';
if ($upload_pdf == 'on' && $all_ok == true)
{
    echo ' selected';
}
echo '>Enabled</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable/disable the chatbot Extensions feature. This can be used to enable a series of extensions, like social posting, email sending, Amazon product details scraping, website or RSS feed scraping, God Mode, which will allow ultimate control of your WordPress site, allowing it to call functions from WordPress directly. Using this feature, you will be able to create posts directly from the chatbot, assign taxonomies, images and many more! Warning! This is a BETA feature, use it with caution. This will apply only if regular AI models are used (not AI Assistants - for these, the God Mode needs to be enabled from Assistant editing menu). Also, God Mode will work only for logged in administrator privileged users.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Extensions (God Mode):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="enable_god_mode_b" onchange="anythingChanged();" >
<?php
echo '<option selected value="disabled">Disabled</option>';
echo '<option value="enabled">Enabled</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable chatbot text to speech/video.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Text-to-Speech/Video:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <select id="chatbot_text_speech_b" onchange="anythingChanged()" >
<?php
echo '<option' . ($chatbot_text_speech == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($chatbot_text_speech == 'free' ? ' selected': '') . ' value="free">Browser Text-to-Speech (Free)</option>';
if (!isset($aiomatic_Main_Settings['app_id'])) 
{
    $aiomatic_Main_Settings['app_id'] = '';
}
$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
$appids = array_filter($appids);
if(empty($appids))
{
$token = '';
}
else
{
$token = $appids[array_rand($appids)];
} 
if(!aiomatic_is_aiomaticapi_key($token) && (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure'))
{
    echo '<option' . ($chatbot_text_speech == 'openai' ? ' selected': '') . ' value="openai">OpenAI Text-to-Speech</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'openai' ? ' selected': '') . ' disabled value="openai">OpenAI Text-to-Speech (' . esc_html__("Currently Only OpenAI API is supported for TTS", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
if (isset($aiomatic_Main_Settings['elevenlabs_app_id']) && trim($aiomatic_Main_Settings['elevenlabs_app_id']) != '')
{
    echo '<option' . ($chatbot_text_speech == 'elevenlabs' ? ' selected': '') . ' value="elevenlabs">ElevenLabs.io Text-to-Speech</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'elevenlabs' ? ' selected': '') . ' disabled value="elevenlabs">ElevenLabs.io Text-to-Speech (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
if (isset($aiomatic_Main_Settings['google_app_id']) && trim($aiomatic_Main_Settings['google_app_id']) != '')
{
    echo '<option' . ($chatbot_text_speech == 'google' ? ' selected': '') . ' value="google">Google Text-to-Speech</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'google' ? ' selected': '') . ' disabled value="google">Google Text-to-Speech (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
if (isset($aiomatic_Main_Settings['did_app_id']) && trim($aiomatic_Main_Settings['did_app_id']) != '')
{
    echo '<option' . ($chatbot_text_speech == 'did' ? ' selected': '') . ' value="did">D-ID Text-to-Video</option>';
    echo '<option' . ($chatbot_text_speech == 'didstream' ? ' selected': '') . ' value="didstream">D-ID Text-to-Video Streaming</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'did' ? ' selected': '') . ' disabled value="did">D-ID Text-to-Video (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
    echo '<option' . ($chatbot_text_speech == 'didstream' ? ' selected': '') . ' disabled value="didstream">D-ID Text-to-Video Streaming (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
?>
</select>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to overwrite the chatbot text-to-speech voice ID. This needs to be exactly matching the voice ID of the text-to-speech engine you are using. For example, for OpenAI Text-to-Speech API, the voice IDs can be: alloy, echo, onyx, nova, fable, shimmer", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Overwrite Chatbot Text-to-Speech Voice ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
if($chatbot_text_speech == 'openai')
{
?>
<select id="chatbot_voice_b" onchange="anythingChanged()" class="cr_width_full">
<?php
echo '<option value="">Select a voice</option>';
echo '<option value="alloy">alloy</option>';
echo '<option value="echo">echo</option>';
echo '<option value="fable">fable</option>';
echo '<option value="nova">nova</option>';
echo '<option value="onyx">onyx</option>';
echo '<option value="shimmer">shimmer</option>';
?>
</select>
<?php
}
elseif($chatbot_text_speech == 'did' || $chatbot_text_speech == 'didstream')
{
?>
    <input id="chatbot_voice_b" value="" list="did_voice_list" autocomplete="off" placeholder="Custom chatbot voice" onchange="anythingChanged()" class="cr_width_full"/>
<?php
}
elseif($chatbot_text_speech == 'elevenlabs')
{
?>
<select id="chatbot_voice_b" onchange="anythingChanged()" class="cr_width_full">
<?php
$eleven_voices = aiomatic_get_eleven_voices();
if($eleven_voices === false)
{
    echo '<option value="" disabled>'.esc_html__("Failed to list voices!", 'aiomatic-automatic-ai-content-writer').'</option>';
}
else
{
    echo '<option value="">Select a voice</option>';
    foreach($eleven_voices as $key => $voice)
    {
        echo '<option value="'.esc_attr($key).'">'.esc_html($voice).'</option>';
    }
}
?>
</select>
<?php
}
elseif($chatbot_text_speech == 'google')
{
?>
<select id="chatbot_voice_b" onchange="anythingChanged()" class="cr_width_full">
<?php
$google_voices = aiomatic_get_google_voices($voice_language);
if($google_voices === false)
{
    echo '<option value="" disabled>'.esc_html__("Failed to list voices!", 'aiomatic-automatic-ai-content-writer').'</option>';
}
else
{
    echo '<option value="">Select a voice</option>';
    foreach($google_voices as $key => $voice)
    {
        echo '<option value="'.esc_attr($voice['name']).'">'.esc_html($voice['name']).'</option>';
    }
}
?>
</select>
<?php 
}
else
{
?>
<input type="text" id="chatbot_voice_b" value="" autocomplete="off" placeholder="Custom chatbot voice" onchange="anythingChanged()" class="cr_width_full">
<?php
}
?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to overwrite the chatbot video avatar URL.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Overwrite Chatbot Video Avatar URL:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <input type="text" id="chatbot_video_b" value="" autocomplete="off" placeholder="Custom chatbot video avatar" onchange="anythingChanged()" class="cr_width_full">
        </td></tr>
        <tr><td>
    <h2><?php echo esc_html__("Chatbot Styling Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the chatbot header.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Chatbot Header:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_header_b" onchange="anythingChanged();" >
<?php
echo '<option'.($show_header == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_header == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Chat Log TXT or PDF File Download Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Chat Log File Download Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_dltxt_b" onchange="anythingChanged();" >
<?php
echo '<option'.($show_dltxt == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_dltxt == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Text-To-Speech Mute Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Text-To-Speech Mute Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_mute_b" onchange="anythingChanged();" >
<?php
echo '<option'.($show_mute == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_mute == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Internet Access Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Internet Access Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_internet_b" onchange="anythingChanged();" >
<?php
echo '<option'.($show_internet == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_internet == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the clearing button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Chat Clearing Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_clear_b" onchange="anythingChanged();" >
<?php
echo '<option'.($show_clear == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_clear == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the chat font size of the chatbot form. Default is 1em", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Font Size:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="font_size_b" onchange="anythingChanged();" >
<?php
echo '<option'.($font_size == '1em' ? ' selected': '').' value="1em">1em</option>';
for($i = 10; $i <= 30; $i++){
    echo '<option'.($font_size == $i . 'px' ? ' selected': '').' value="'.esc_html($i).'px">'.esc_html($i).'px</option>';
}
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the width of the chatbot form. For full width, you can set 100% (default value). You can also set values in pixels, like: 400px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Form Width:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="width_b" value="<?php echo esc_html($width);?>" placeholder="100%" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the height of the chatbot form. Default is auto. You can set values in pixels, like: 400px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Form Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="height_b" value="<?php echo esc_html($height);?>" placeholder="auto" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the min-height of the chatbot form (when the form is resized, this is the minimum height it will be allowed to get. Default is 250px. You can set values in pixels, like: 400px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Form Min-Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="minheight_b" value="<?php echo esc_html($minheight);?>" placeholder="250px" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set your own custom header text for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Custom Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
          $settings = array(
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4',
            'editor_height' => 80,
            'teeny' => false
          );
          wp_editor( $custom_header, 'custom_header_b', $settings );
?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set your own custom footer text for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Custom Footer Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
          $settings = array(
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4',
            'editor_height' => 80,
            'teeny' => false
          );
          wp_editor( $custom_footer, 'custom_footer_b', $settings );
?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set your own custom CSS code for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Custom CSS Code:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
          $settings = array(
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4',
            'editor_height' => 80,
            'teeny' => false
          );
          wp_editor( $custom_css, 'custom_css_b', $settings );
?>
        </div>
        </td></tr>
        <tr><td colspan="2"><h2><?php echo esc_html__("AI Chatbot Coloring Options:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the background color of the chatbot form. Default is #ffffff", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Form Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="general_background_b" value="<?php echo esc_attr($general_background);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the background color of the chatbot form. Default is #f7f7f9", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="background_b" value="<?php echo esc_html($background);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the user chatbot form. Default is white", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("User Font Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="user_font_color_b" value="<?php echo esc_html($user_font_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the user baloon chatbot form. Default is #0084ff", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("User Baloon Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="user_background_color_b" value="<?php echo esc_html($user_background_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the AI chatbot form. Default is black", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Font Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="ai_font_color_b" value="<?php echo esc_html($ai_font_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the AI baloon chatbot form. Default is #f0f0f0", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Baloon Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="ai_background_color_b" value="<?php echo esc_html($ai_background_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the border color for the input field. Default is #e1e3e6", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Border Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="input_border_color_b" value="<?php echo esc_html($input_border_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the text color for the input field. Default is #e1e3e6", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Text Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="input_text_color_b" value="<?php echo esc_html($input_text_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the placeholder color for the input field. Default is #e1e3e6", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Placeholder Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="input_placeholder_color_b" value="<?php echo esc_html($input_placeholder_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the persona name.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Persona Name Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="persona_name_color_b" value="<?php echo esc_html($persona_name_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the persona role.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Persona Role Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="persona_role_color_b" value="<?php echo esc_html($persona_role_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the submit button. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Submit Button Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="submit_color_b" value="<?php echo esc_html($submit_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the text color of the submit button. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Submit Button Text Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="submit_text_color_b" value="<?php echo esc_html($submit_text_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the voice button. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Button Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="voice_color_b" value="<?php echo esc_html($voice_color);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the voice button when it is activated. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Button Activated Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="voice_color_activated_b" value="<?php echo esc_html($voice_color_activated);?>" onchange="anythingChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the chatbot header.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Theme:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="chat_theme_b" onchange="themeChanged_b();" >
<?php
echo '<option'.($chat_theme == '' ? ' selected': '').' value="">No Change</option>';
echo '<option'.($chat_theme == 'light' ? ' selected': '').' value="light">Light</option>';
echo '<option'.($chat_theme == 'dark' ? ' selected': '').' value="dark">Dark</option>';
echo '<option'.($chat_theme == 'midnight' ? ' selected': '').' value="midnight">Midnight</option>';
echo '<option'.($chat_theme == 'sunrise' ? ' selected': '').' value="sunrise">Sunrise</option>';
echo '<option'.($chat_theme == 'ocean' ? ' selected': '').' value="ocean">Ocean</option>';
echo '<option'.($chat_theme == 'forest' ? ' selected': '').' value="forest">Forest</option>';
echo '<option'.($chat_theme == 'winter' ? ' selected': '').' value="winter">Winter</option>';
echo '<option'.($chat_theme == 'twilight' ? ' selected': '').' value="twilight">Twilight</option>';
echo '<option'.($chat_theme == 'desert' ? ' selected': '').' value="desert">Desert</option>';
echo '<option'.($chat_theme == 'cosmic' ? ' selected': '').' value="cosmic">Cosmic</option>';
echo '<option'.($chat_theme == 'rose' ? ' selected': '').' value="rose">Rose</option>';
echo '<option'.($chat_theme == 'tropical' ? ' selected': '').' value="tropical">Tropical</option>';
echo '<option'.($chat_theme == 'facebook' ? ' selected': '').' value="facebook">Facebook</option>';
echo '<option'.($chat_theme == 'twitter' ? ' selected': '').' value="twitter">Twitter</option>';
echo '<option'.($chat_theme == 'instagram' ? ' selected': '').' value="instagram">Instagram</option>';
echo '<option'.($chat_theme == 'whatsapp' ? ' selected': '').' value="whatsapp">WhatsApp</option>';
echo '<option'.($chat_theme == 'linkedin' ? ' selected': '').' value="linkedin">LinkedIn</option>';
$aiomatic_themes = new WP_Query(array(
    'post_type' => 'aiomatic_themes',
    'posts_per_page' => -1,
    'order' => 'DESC',
    'orderby' => 'date',
    'post_status' => 'any'
));
if($aiomatic_themes->have_posts())
{
    foreach ($aiomatic_themes->posts as $aiomatic_theme)
    {
        echo '<option'.($chat_theme == $aiomatic_theme->ID ? ' selected': '').' value="' . $aiomatic_theme->ID . '">'. esc_html($aiomatic_theme->post_title) . '</option>';
    }
}
?>
                    </select>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/XFomdusLtHc" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
    </table>
</div><div id="tab-13" class="tab-content">
<table class="widefat">
<tr><td colspan="2">
    <h2><?php echo esc_html__("PDF Chat Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
<?php
$all_ok = true;
$issue_counter = 1;
if (!is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
{
    $all_ok = false;
    echo '<tr><td colspan="2"><span class="cr_red">' . $issue_counter++ . '. ' . esc_html__("This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://coderevolution.ro/product/aiomatic-extension-pdf-file-storage-and-parsing/" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
if($pinecone_app_id == '' && $qdrant_app_id == '')
{
    $all_ok = false;
    echo '<tr><td colspan="2"><span class="cr_red">' . $issue_counter++ . '. ' . esc_html__("You need to enter a Pinecone.io API or a Qdrant API key in the 'API Keys' tab to use this feature, go to the plugin's 'Settings' menu -> in the 'API Keys' tab, set up an API key for a vector database ('Embeddings API Options' section)", 'aiomatic-automatic-ai-content-writer') . '</span></td></tr>';
}
if (!isset($aiomatic_Main_Settings['embeddings_chat_short']) || trim($aiomatic_Main_Settings['embeddings_chat_short']) != 'on')
{
    $all_ok = false;
    echo '<tr><td colspan="2"><span class="cr_red">' . $issue_counter++ . '. ' . esc_html__("You need to enable Embeddings for the Chatbot -> go to the 'Embeddings' tab in the same menu and check the 'Enable Embeddings For' -> 'Chatbot Shortcodes' checkbox -> save settings.", 'aiomatic-automatic-ai-content-writer') . '</span></td></tr>';
}
?>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable users to upload PDF files to the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Users To Upload PDF Files To The Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="upload_pdf" name="aiomatic_Chatbot_Settings[upload_pdf]"<?php
    if ($upload_pdf == 'on')
    {
        echo ' checked ';
    }
    if($all_ok === false)
    {
        echo " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
    }
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to limit the maximum number of pages extracted from the pdf files.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Limit PDF Page Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="number" min="0" step="1" id="pdf_page" name="aiomatic_Chatbot_Settings[pdf_page]" class="cr_width_full" value="<?php echo esc_html($pdf_page);?>" placeholder="PDF page count limit">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to limit the maximum number of characters extracted from the pdf files.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Limit PDF Character Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="number" min="0" step="1" id="pdf_character" name="aiomatic_Chatbot_Settings[pdf_character]" class="cr_width_full" value="<?php echo esc_html($pdf_character);?>" placeholder="PDF character count limit">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the user message which appears when the pdf file was uploaded successfully.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("PDF File Uploaded Successfully User Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="text" id="pdf_ok" name="aiomatic_Chatbot_Settings[pdf_ok]" class="cr_width_full" value="<?php echo esc_html($pdf_ok);?>" placeholder="PDF file uploaded successfully! You can ask questions about it.">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the user message which appears when the pdf session was ended by the user.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("PDF Session Ended User Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="text" id="pdf_end" name="aiomatic_Chatbot_Settings[pdf_end]" class="cr_width_full" value="<?php echo esc_html($pdf_end);?>" placeholder="PDF file session ended.">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the user message which appears when the pdf file upload failed.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("PDF File Uploaded Failed User Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="text" id="pdf_fail" name="aiomatic_Chatbot_Settings[pdf_fail]" class="cr_width_full" value="<?php echo esc_html($pdf_fail);?>" placeholder="Failed to upload the PDF file, please try again later.">
        </div>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/SkFdO5-zxFY" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
        </table>
</div>
<div id="tab-12" class="tab-content">
<table class="widefat">
<tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Context Details:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the placeholder text of the chat input. The default is: empty.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Input Placeholder:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" name="aiomatic_Chatbot_Settings[placeholder]" placeholder="Enter your chat message here"><?php
    echo esc_textarea($placeholder);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the text of the submit button. The default is: Submit", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Input Submit Button Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" name="aiomatic_Chatbot_Settings[submit]" placeholder="Submit"><?php
    echo esc_textarea($submit);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the text of the prompt selection placeholder. The default is: Please select a prompt", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Text For Prompt Templates Selection:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" name="aiomatic_Chatbot_Settings[select_prompt]" placeholder="Please select a prompt"><?php
    echo esc_textarea($select_prompt);
?></textarea>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the compliance text which will be shown at the bottom of the chatbot (default is empty)", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Compliance Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" name="aiomatic_Chatbot_Settings[compliance]" placeholder="Compliance text"><?php
    echo esc_textarea($compliance);
?></textarea>
        </div>
        </td></tr>
        </table>
</div>
<div id="tab-10" class="tab-content">
<h2><?php echo esc_html__("Manage Chatbot Personas:", 'aiomatic-automatic-ai-content-writer');?></h2>
<br/>
        <button href="#" id="aiomatic_sync_personas" class="page-title-action"><?php
        echo esc_html__("Sync Personas", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button id="aiomatic_manage_personas" class="page-title-action"><?php
        echo esc_html__("Add New Persona", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button id="aiomatic_backup_personas" class="page-title-action"><?php
        echo esc_html__("Backup/Restore Personas", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_delete_selected_personas" class="page-title-action"><?php
        echo esc_html__("Delete Selected Personas", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_deleteall_personas" class="page-title-action"><?php
        echo esc_html__("Delete All Personas", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <?php
if($aiomatic_personas->have_posts()){
    echo '<br><br>' . esc_html__('All personas', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_personas->found_posts . ')<br>';
}
?>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th class="manage-column column-cb check-column aiomatic-tdcol" scope="col"><input class="aiomatic-chk" type="checkbox" id="checkedAll"></th>
        <th scope="col"><?php
        echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Role", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Avatar", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Date", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Manage", 'aiomatic-automatic-ai-content-writer');
        ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($aiomatic_personas->have_posts())
    {
        foreach ($aiomatic_personas->posts as $aiomatic_persona)
        {
            ?>
            <tr>
                <td><input class="aiomatic-select-persona" id="aiomatic-select-<?php echo $aiomatic_persona->ID;?>" type="checkbox" name="ids[]" value="<?php echo $aiomatic_persona->ID;?>"></td>
                <td><a href="<?php echo get_edit_post_link($aiomatic_persona->ID);?>" class="aiomatic-persona-content"><?php echo esc_html($aiomatic_persona->post_title);?></a></td>
                <td><?php echo esc_html($aiomatic_persona->post_excerpt);?></td>
                <td><?php $avatar = get_the_post_thumbnail_url($aiomatic_persona->ID, 'thumbnail'); if($avatar === false){echo 'N/A';}else{echo '<img class="openai-chat-avatar" src="' . $avatar . '" alt="avatar"/>';}?></td>
                <td><?php echo esc_html($aiomatic_persona->ID);?></td>
                <td><?php echo esc_html($aiomatic_persona->post_date)?></td>
                <td>
                <div class="cr_center">
                <a class="button button-small" href="<?php echo get_edit_post_link($aiomatic_persona->ID);?>"><?php echo esc_html__("Edit", 'aiomatic-automatic-ai-content-writer');?></a>
                <button class="button button-small aiomatic_duplicate_persona" id="aiomatic_duplicate_persona_<?php echo $aiomatic_persona->ID;?>" data-id="<?php echo $aiomatic_persona->ID;?>"><?php echo esc_html__("Duplicate", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_delete_persona" id="aiomatic_delete_persona_<?php echo $aiomatic_persona->ID;?>" delete-id="<?php echo $aiomatic_persona->ID;?>"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
                </div>
            </td>
            </tr>
            <?php
        }
    }
    else
    {
        echo '<tr><td colspan="7">' . esc_html__("No chatbot personas added. You can add more using the 'Add New Persona' button from above.", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
    }
    ?>
    </tbody>
</table>
<?php
if($aiomatic_personas->have_posts() && $aiomatic_personas->max_num_pages > 1)
{
?>
<div class="aiomatic-paginate">
    <?php
    echo esc_html__("Page: ", 'aiomatic-automatic-ai-content-writer') . paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_chatbot_panel&wpage=%#%'),
        'total'        => $aiomatic_personas->max_num_pages,
        'current'      => $aiomatic_persona_page,
        'format'       => '?wpage=%#%',
        'show_all'     => false,
        'prev_next'    => true,
        'add_args'     => false,
    ));
    ?>
</div>
<?php
}
?>
<br/></hr/><br/>
<table class="widefat">
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/V0aiz-b1mdQ" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr></table>
</div>
<div id="tab-15" class="tab-content">
<h2><?php echo esc_html__("AI Chatbot Embedding On Remote Sites Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
<table class="wp-list-table widefat fixed striped table-view-list posts">
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable embedding of the chatbot on remote websites, using iframes. If you deactivate remote chatbots, all created remote chatbot instances will be also deleted.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Embedding On Remote Sites:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="remote_chat" name="aiomatic_Chatbot_Settings[remote_chat]"<?php
    if ($remote_chat == 'on')
    {
        echo ' checked ';
    }
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a list of domains (separated by commas), which will be allowed to display the chatbot on their site. To allow all sites to add this chatbot, leave this field blank. Example usage: https://www.example.org", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Domain List Allowed To Embed Chatbots:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" id="allow_chatbot_site" placeholder="https://www.example.org" name="aiomatic_Chatbot_Settings[allow_chatbot_site]"><?php
    echo esc_textarea($allow_chatbot_site);
?></textarea>
        </div>
        </td></tr>
<?php
if ($remote_chat == 'on')
{
    $myop = get_option('aiomatic_chat_page_id', false);
    if($myop !== false)
    {
        if(is_numeric($myop))
        {
            $myop = array($myop);
        }
    ?>
    <tr>
        <td colspan="2">
        <b><?php echo esc_html__("You can use these HTML codes to embed the chatbot on other websites:", 'aiomatic-automatic-ai-content-writer');?></b>
        </td>
    </tr>
    <?php
        $changedone = false;
        if(count($myop) == 0)
        {
?>
    <tr>
        <td colspan="2">
        <b><?php echo esc_html__("No remote chatbot instances created. Click the button from below to create a new instance!", 'aiomatic-automatic-ai-content-writer');?></b>
        </td>
    </tr>
<?php
        }
        foreach($myop as $zind => $myopthis)
        {
            if(get_permalink($myopthis) === false)
            {
                unset($myop[$zind]);
                $changedone = true;
                continue;
            }
    ?>
    <tr>
        <td colspan="2">
            <hr/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <b><?php echo esc_html__("Embed HTML Code:", 'aiomatic-automatic-ai-content-writer');?></b><br/>
            <span class="cr_red">
    <?php
        echo esc_html('<iframe src="' . get_permalink($myopthis) . '" width="600" height="800" frameborder="0" scrolling="no">' . esc_html__("Your browser does not support iframes.", 'aiomatic-automatic-ai-content-writer') . '</iframe>');
    ?>
            </span>
            <p><?php
        echo sprintf( wp_kses( __( "<a href='%s' class='button' target='_blank'>Edit</a>", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'data-id' => array(), 'class' => array(), 'href' => array(), 'target' => array() ) ) ), get_edit_post_link($myopthis));
?>&nbsp;<?php
        echo sprintf( wp_kses( __( "<a href='#' data-id='" . esc_attr($myopthis) . "' class='aiomatic_delete_remote_chatbot button'>Delete</a>", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'data-id' => array(), 'class' => array(), 'href' => array(), 'target' => array() ) ) ), get_edit_post_link($myopthis));
    ?></p>
        </td>
    </tr>
    <?php
        }
        if($changedone == true)
        {
            update_option('aiomatic_chat_page_id', $myop);
        }
    }
    else
    {     
?>
<tr>
    <td colspan="2">
    <b><?php echo esc_html__("No remote chatbot instances created. Click the button from below to create a new instance.", 'aiomatic-automatic-ai-content-writer');?></b>
    </td>
</tr>
<?php
    }
?>
<tr>
    <td colspan="2">
        <hr/>
    </td>
</tr>
<tr>
    <td colspan="2">
    <button id="aiomatic_add_remote_chatbot" class="button"><?php echo esc_html__("Add A New Remote Chatbot", 'aiomatic-automatic-ai-content-writer');?></button>
    </td>
</tr>
<?php
}
?>
</table>
</div>
<div id="tab-14" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Extension Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td colspan="2"><span class="cr_red"><?php echo esc_html__("Warning! This feature is currently supported only for OpenAI models (excepting gpt-3.5-instruct). Each extension will use some additional input tokens, which will be sent to the AI in each request. So, using extensions will increase also costs of API usage. Be sure to activate only the extensions which you need!", 'aiomatic-automatic-ai-content-writer');?></span></td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Dall-E Image' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Dall-E Image' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_dalle" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_dalle]"<?php
    if ($god_mode_enable_dalle == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr><tr class="hide_dalle">
        <td class="cr_min_width_200">
            <div>
                <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                    <div class="bws_hidden_help_text cr_min_260px">
                    <?php
                        echo esc_html__("Select the image size for AI generated images.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                    </div>
                </div>
                <b><?php echo esc_html__("AI Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>
        </td>
        <td>
        <select autocomplete="off" id="ai_image_size" name="aiomatic_Chatbot_Settings[ai_image_size]" class="cr_width_full">
            <option value="256x256" <?php if($ai_image_size == '256x256'){echo ' selected';}?> ><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="512x512" <?php if($ai_image_size == '512x512'){echo ' selected';}?> ><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="1024x1024" <?php if($ai_image_size == '1024x1024'){echo ' selected';}?> ><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="1024x1792" <?php if($ai_image_size == '1024x1792'){echo ' selected';}?> ><?php echo esc_html__("1024x1792 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="1792x1024" <?php if($ai_image_size == '1792x1024'){echo ' selected';}?> ><?php echo esc_html__("1792x1024 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer');?></option>
        </select>
        </td>
        </tr>
        <tr class="hide_dalle">
        <td class="cr_min_width_200">
            <div>
                <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                    <div class="bws_hidden_help_text cr_min_260px">
                    <?php
                        echo esc_html__("Select the image model for AI generated images.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                    </div>
                </div>
                <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
        </td>
        <td>
        <select autocomplete="off" id="ai_image_model" name="aiomatic_Chatbot_Settings[ai_image_model]" class="cr_width_full">
            <option value="dalle2" <?php if($ai_image_model == 'dalle2'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="dalle3" <?php if($ai_image_model == 'dalle3'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="dalle3hd" <?php if($ai_image_model == 'dalle3hd'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
        </select>
        </td>
        </tr>
        <tr class="hide_dalle"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the message which is displayed to the user in case the image creations fails.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Image Generator Failed User Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="text" id="god_mode_dalle_failed" name="aiomatic_Chatbot_Settings[god_mode_dalle_failed]" value="<?php echo esc_html($god_mode_dalle_failed);?>" placeholder="Image creation failed, please try again later.">
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Midjourney Image' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Midjourney Image' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_midjourney" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_midjourney]"<?php
    if ($god_mode_enable_midjourney == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Stable Diffusion Image' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Stable Diffusion Image' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_stable" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_stable]"<?php
    if ($god_mode_enable_stable == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_stable">
                     <td>
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
                     </td>
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
                  <tr class="hide_stable">
        <td class="cr_min_width_200">
            <div>
                <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                    <div class="bws_hidden_help_text cr_min_260px">
                    <?php
                        echo esc_html__("Select the image size for AI generated images.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                    </div>
                </div>
                <b><?php echo esc_html__("AI Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>
        </td>
        <td>
        <select autocomplete="off" id="ai_image_size_stable" name="aiomatic_Chatbot_Settings[ai_image_size_stable]" class="cr_width_full">
            <option value="512x512" <?php if($ai_image_size_stable == '512x512'){echo ' selected';}?> ><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="1024x1024" <?php if($ai_image_size_stable == '1024x1024'){echo ' selected';}?> ><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
        </select>
        </td>
        </tr>
        <tr class="hide_stable"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the message which is displayed to the user in case the image creations fails.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Image Generator Failed User Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="text" id="god_mode_stable_failed" name="aiomatic_Chatbot_Settings[god_mode_stable_failed]" value="<?php echo esc_html($god_mode_stable_failed);?>" placeholder="Image creation failed, please try again later.">
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Stable Diffusion Video' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Stable Diffusion Video' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_stable_video" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_stable_video]"<?php
    if ($god_mode_enable_stable_video == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_stable_video">
        <td class="cr_min_width_200">
            <div>
                <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                    <div class="bws_hidden_help_text cr_min_260px">
                    <?php
                        echo esc_html__("Select the size for AI generated videos.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                    </div>
                </div>
                <b><?php echo esc_html__("AI Generated Video Size:", 'aiomatic-automatic-ai-content-writer');?></b>
        </td>
        <td>
        <select autocomplete="off" id="ai_video_size_stable" name="aiomatic_Chatbot_Settings[ai_video_size_stable]" class="cr_width_full">
            <option value="768x768" <?php if($ai_video_size_stable == '768x768'){echo ' selected';}?> ><?php echo esc_html__("768x768", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="1024x576" <?php if($ai_video_size_stable == '1024x576'){echo ' selected';}?> ><?php echo esc_html__("1024x576", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="576x1024" <?php if($ai_video_size_stable == '576x1024'){echo ' selected';}?> ><?php echo esc_html__("576x1024", 'aiomatic-automatic-ai-content-writer');?></option>
        </select>
        </td>
        </tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Amazon Product Listing' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Amazon Product Listing' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_amazon" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_amazon]"<?php
    if ($god_mode_enable_amazon == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Amazon Product Details' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Amazon Product Details' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_amazon_details" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_amazon_details]"<?php
    if ($god_mode_enable_amazon_details == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_amazon"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo sprintf( wp_kses( __( "Insert your Amazon Associate ID (Optional). Learn how to get one <a href='%s' target='_blank'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html', 'https://affiliate-program.amazon.com/assoc_credentials/home' );
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Amazon Associate ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="text" id="affiliate_id" name="aiomatic_Chatbot_Settings[affiliate_id]" value="<?php echo esc_html($affiliate_id);?>" placeholder="Please insert your Amazon Affiliate ID">
        </div>
        </td></tr>
        <tr class="hide_amazon"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the country where you have registred your affiliate account.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Amazon Target Country:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="source" name="aiomatic_Chatbot_Settings[target_country]" class="cr_width_full">
                    <?php
                    $amaz_countries = aiomatic_get_amazon_codes();
                    foreach ($amaz_countries as $key => $value) {
                        echo '<option value="' . esc_html($key) . '"';
                        if($target_country == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($value) . '</option>';
                    }
                    ?>
                    </select>  
        </div>
        </td></tr>
            <tr class="hide_amazon">
            <td>
                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                            echo esc_html__("Set the maximum number of products to add in the product listing. You can also set a variable number of products, case in which a random number will be selected from the range you specify. Example 5-7", 'aiomatic-automatic-ai-content-writer');
                            ?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Max Number Of Products To Include:", 'aiomatic-automatic-ai-content-writer');?></b>   
            </td>
            <td class="cr_min_width_200">
            <input type="text" id="max_products" name="aiomatic_Chatbot_Settings[max_products]" placeholder="3-4" class="cr_width_full" value="<?php echo esc_attr($max_products);?>">  
            </td>
            </tr>
            <tr class="hide_amazon">
            <td class="cr_min_width_200">
                <div>
                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                            echo esc_html__("Select the type of sorting of the returned results.", 'aiomatic-automatic-ai-content-writer');
                            ?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Sort Results By:", 'aiomatic-automatic-ai-content-writer');?></b>   
            </td>
            <td class="cr_min_width_200">
            <select id="sort_results" name="aiomatic_Chatbot_Settings[sort_results]" class="cr_width_full">
            <option value="none" <?php if($sort_results == 'none'){echo ' selected';}?>><?php echo esc_html__("None", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="Relevance" <?php if($sort_results == 'Relevance'){echo ' selected';}?>><?php echo esc_html__("Relevance", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="Price:LowToHigh" <?php if($sort_results == 'Price:LowToHigh'){echo ' selected';}?>><?php echo esc_html__("Price:LowToHigh", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="Price:HighToLow" <?php if($sort_results == 'Price:HighToLow'){echo ' selected';}?>><?php echo esc_html__("Price:HighToLow", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="NewestArrivals" <?php if($sort_results == 'NewestArrivals'){echo ' selected';}?>><?php echo esc_html__("NewestArrivals", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="Featured" <?php if($sort_results == 'Featured'){echo ' selected';}?>><?php echo esc_html__("Featured", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="AvgCustomerReviews" <?php if($sort_results == 'AvgCustomerReviews'){echo ' selected';}?>><?php echo esc_html__("AvgCustomerReviews", 'aiomatic-automatic-ai-content-writer');?></option>
            </select>    
            </td>
            </tr>
        <tr class="hide_amazon"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set what information do you want to add into each product listing entry. You can use the following shortcodes to get data for specific products: %%product_counter%%, %%product_title%%, %%product_description%%, %%product_url%%, %%product_price%%, %%product_list_price%%, %%product_image%%, %%product_cart_url%%, %%product_images_urls%%, %%product_images%%, %%product_reviews%%. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Product Listing Template:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<textarea rows="1" name="aiomatic_Chatbot_Settings[listing_template]" placeholder='Set what information do you want to add into each product listing entry'><?php
    echo esc_textarea($listing_template);
?></textarea>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Websites Scraper' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Website Scraper' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_scraper" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_scraper]"<?php
    if ($god_mode_enable_scraper == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
            <tr class="hide_scraper">
            <td class="cr_min_width_200">
                <div>
                    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                            echo esc_html__("Select the method to be used for scraping.", 'aiomatic-automatic-ai-content-writer');
                            ?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Scraping Method:", 'aiomatic-automatic-ai-content-writer');?></b>   
            </td>
            <td class="cr_min_width_200">
            <select id="scrape_method" name="aiomatic_Chatbot_Settings[scrape_method]" class="cr_width_full">
            <option value="0" <?php if($scrape_method == '0'){echo ' selected';}?>><?php echo esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="1" <?php if($scrape_method == '1'){echo ' selected';}?>><?php echo esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="2" <?php if($scrape_method == '2'){echo ' selected';}?>><?php echo esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="3" <?php if($scrape_method == '3'){echo ' selected';}?>><?php echo esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="4" <?php if($scrape_method == '4'){echo ' selected';}?>><?php echo esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="5" <?php if($scrape_method == '5'){echo ' selected';}?>><?php echo esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="6" <?php if($scrape_method == '6'){echo ' selected';}?>><?php echo esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');?></option>
            </select>    
            </td>
            </tr>
        <tr class="hide_scraper"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to remove all HTML tags from the scraped content and leave only the plain textual content in it.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Strip All HTML Tags:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="strip_tags" name="aiomatic_Chatbot_Settings[strip_tags]"<?php
    if ($strip_tags == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_scraper"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum number of characters to keep from the scraped data.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Maximum # Of Characters To Keep:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="number" min="0" step="1" id="max_chars" name="aiomatic_Chatbot_Settings[max_chars]" class="cr_width_full" value="<?php echo esc_html($max_chars);?>" placeholder="# Of Characters To Keep">
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'RSS Feed Parser' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'RSS Feed Parser' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_rss" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_rss]"<?php
    if ($god_mode_enable_rss == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_rss"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum number of items from the RSS feed to process.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Maximum # Of Items To Process:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="number" min="0" step="1" id="max_rss_items" name="aiomatic_Chatbot_Settings[max_rss_items]" class="cr_width_full" value="<?php echo esc_html($max_rss_items);?>" placeholder="# Of RSS items to process">
        </div>
        </td></tr>
        <tr class="hide_rss"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the template of the resulting string, which will be built after parsing the RSS feed. You can use the following shortcodes, which will map to the values of each RSS feed item: %%item_counter%%, %%item_title%%, %%item_content%%, %%item_description%%, %%item_url%%, %%item_author%%, %%item_categories%%", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Results Template:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<textarea rows="1" name="aiomatic_Chatbot_Settings[rss_template]" placeholder='Set the RSS item template sent to the AI'><?php
    echo esc_textarea($rss_template);
?></textarea>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'RSS Feed Parser' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Google SERP Parser' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_google" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_google]"<?php
    if ($god_mode_enable_google == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_google"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum number of items from the Google SERP to process.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Maximum # Of Items To Process:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="number" min="0" step="1" id="max_google_items" name="aiomatic_Chatbot_Settings[max_google_items]" class="cr_width_full" value="<?php echo esc_html($max_google_items);?>" placeholder="# Of RSS items to process">
        </div>
        </td></tr>
        <tr class="hide_google"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the template of the resulting string, which will be built after parsing the search results. You can use the following shortcodes, which will map to the values of each search results item: %%item_counter%%, %%item_title%%, %%item_snippet%%, %%item_url%%", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Results Template:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<textarea rows="1" name="aiomatic_Chatbot_Settings[google_template]" placeholder='Set the Google SERP item template sent to the AI'><?php
    echo esc_textarea($google_template);
?></textarea>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'YouTube Video Captions' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'YouTube Video Captions' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_youtube_captions" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_youtube_captions]"<?php
    if ($god_mode_enable_youtube_captions == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hide_caption"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum length in characters of the resulting string. If the captions are longer than this value, they will shortened.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Maximum Caption Length (Characters):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="number" min="0" step="1" id="max_caption_length" name="aiomatic_Chatbot_Settings[max_caption_length]" class="cr_width_full" value="<?php echo esc_html($max_caption_length);?>" placeholder="Maximum number of caption characters">
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Royalty Free Image Search' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Royalty Free Image Search' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_royalty" name="aiomatic_Chatbot_Settings[god_mode_enable_royalty]"<?php
    if ($god_mode_enable_royalty == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'YouTube Video Search' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'YouTube Video Search' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_youtube" name="aiomatic_Chatbot_Settings[god_mode_enable_youtube]"<?php
    if ($god_mode_enable_youtube == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Email Sending' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Email Sending' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_email" name="aiomatic_Chatbot_Settings[god_mode_enable_email]"<?php
    if ($god_mode_enable_email == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Webhook Calling' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Webhook Calling' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_webhook" name="aiomatic_Chatbot_Settings[god_mode_enable_webhook]"<?php
    if ($god_mode_enable_webhook == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable WordPress function calling extension (God Mode) for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'God Mode' Extension (WordPress Function Calling) - BETA:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_mode_enable_wp" onchange="extensionsChanged();" name="aiomatic_Chatbot_Settings[god_mode_enable_wp]"<?php
    if ($god_mode_enable_wp == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
    <tr class="hide_god"><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Add a list of functions which will not be allowed to be executed by the chatbot (a function on each line).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Blacklisted WordPress Functions:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </td><td>
<textarea rows="2" name="aiomatic_Chatbot_Settings[god_blacklisted_functions]" placeholder='List of blacklisted functions for chatbot god mode'><?php
    echo esc_textarea($god_blacklisted_functions);
?></textarea>
        </td></tr>
    <tr class="hide_god"><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Add a list of functions which will be allowed to be executed by the chatbot (a function on each line). If you set a list of functions here, any other function which does not appear on the list will not be allowed to be executed by the god mode chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Whitelisted WordPress Functions:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </td><td>
<textarea rows="2" name="aiomatic_Chatbot_Settings[god_whitelisted_functions]" placeholder='List of whitelisted functions for chatbot god mode'><?php
    echo esc_textarea($god_whitelisted_functions);
?></textarea>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Facebook Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Facebook Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" onchange="extensionsChanged();" id="god_mode_enable_facebook_post" 
<?php 
$no_fb = false;
if (!is_plugin_active('fbomatic-facebook-post-generator/fbomatic-facebook-post-generator.php')) 
{
    $no_fb = true;
}
if($no_fb == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_facebook_post]"<?php
    if ($god_mode_enable_facebook_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_fb == true)
{
    echo esc_html__("This option requires the F-omatic Automatic Post Generator and Social Network Auto Poster plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/fbomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr class="hide_facebook"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the page associated with your App ID, where you want to publish your posts.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Page Where To Publish Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
$output = '<select id="facebook_post_select" name="aiomatic_Chatbot_Settings[facebook_post_select]" >';
$store = get_option('fbomatic_page_ids', false);
if($store !== FALSE)
{
    $store = explode(',', $store);
    $fcount = count($store);
    for($i = 0; $i < $fcount; $i++)
    {
        $exploding = explode('-', $store[$i]);
        if(!isset($exploding[2]))
        {
            continue;
        }
        $output .= '<option value="' . esc_html($exploding[0]) . '"';
        if($exploding[0] == $facebook_post_select)
        {
            $output .= " selected";
        }
        $output .= '>' . esc_html($exploding[2]) . '</option>';
    }
}
else
{
    $output .= '<option disabled value="">' . esc_html__('You need to set up the F-omatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
}
$output .= '</select>';
echo $output;
?>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Twitter (X) Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Twitter (X) Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" id="god_mode_enable_twitter_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('twitomatic-twitter-post-generator/twitomatic-twitter-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_twitter_post]"<?php
    if ($god_mode_enable_twitter_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the Twitomatic Automatic Post Generator and Twitter Auto Poster Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/twitomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Instagram Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Instagram Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" id="god_mode_enable_instagram_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('instamatic-instagram-post-generator/instamatic-instagram-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_instagram_post]"<?php
    if ($god_mode_enable_instagram_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the iMediamatic Automatic Post Generator and Instagram Auto Poster Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/instamatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Pinterest Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Pinterest Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" onchange="extensionsChanged();" id="god_mode_enable_pinterest_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('pinterestomatic-pinterest-post-generator/pinterestomatic-pinterest-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_pinterest_post]"<?php
    if ($god_mode_enable_pinterest_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the Pinterestomatic Automatic Post Generator and Pinterest Auto Poster Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/pinterestomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr class="hide_pinterest"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the board associated with your account, where you want to publish your pins.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Boards Where To Publish Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
$output = '<select id="pinterest_post_select" name="aiomatic_Chatbot_Settings[pinterest_post_select]" >';
$boards = get_option('pinterestomatic_public_boards', false);
if($boards !== FALSE)
{
    if($boards != '' && is_array($boards))
    {
        foreach($boards as $id => $name)
        {
            $output .= '<option value="' . esc_attr($id) . '"';
            if ($pinterest_post_select == $id) {
                $output .= " selected";
            }
            $output .= '>' . esc_html($name) . '</option>';
        }
    }
}
else
{
    $output .= '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
}
$output .= '</select>';
echo $output;
?>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Google My Business Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Google My Business Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" onchange="extensionsChanged();" id="god_mode_enable_google_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('businessomatic-google-my-business-post-generator/businessomatic-google-my-business-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_google_post]"<?php
    if ($god_mode_enable_google_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the Businessomatic Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/businessomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr class="hide_gmb"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the page associated with your account, where you want to publish your posts.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Pages Where To Publish Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="business_post_select" name="aiomatic_Chatbot_Settings[business_post_select]" >
<?php
$store = get_option('businessomatic_my_business_list', false);
if($store !== FALSE)
{
    foreach ($store as $index => $val)
    {
?>
<option value="<?php echo esc_html($index);?>"
<?php
        if($index == $business_post_select) echo " selected" ?>>
<?php echo esc_html($val); ?>
</option>
<?php
    }
}
?>
</select>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'YouTube Community Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'YouTube Community Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" id="god_mode_enable_youtube_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('youtubomatic-youtube-post-generator/youtubomatic-youtube-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_youtube_post]"<?php
    if ($god_mode_enable_youtube_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the Youtubomatic Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/youtubomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'Reddit Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'Reddit Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" onchange="extensionsChanged();" id="god_mode_enable_reddit_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('redditomatic-reddit-post-generator/redditomatic-reddit-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_reddit_post]"<?php
    if ($god_mode_enable_reddit_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the Redditomatic Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/redditomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr class="hide_reddit">
            <td>
            <div>
                <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                    <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                        echo esc_html__("Input a list of comma separated subreddit names where you want to automatically post your new post content.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                    </div>
                </div>
                <b><?php echo esc_html__("Subreddits Where To Post:", 'aiomatic-automatic-ai-content-writer');?></b>
            </div>
            </td>
            <td>
            <div>
                <textarea name="aiomatic_Chatbot_Settings[subreddits_list]" placeholder="Please insert a subreddit"><?php
                    echo esc_textarea($subreddits_list);
                    ?></textarea>
            </div>
            </td>
        </tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the 'LinkedIn Posting' for the Chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("'LinkedIn Posting' Extension:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="checkbox" onchange="extensionsChanged();" id="god_mode_enable_linkedin_post" 
<?php 
$no_tw = false;
if (!is_plugin_active('linkedinomatic-linkedin-post-generator/linkedinomatic-linkedin-post-generator.php')) 
{
    $no_tw = true;
}
if($no_tw == true)
{
    echo ' disabled';
} ?> name="aiomatic_Chatbot_Settings[god_mode_enable_linkedin_post]"<?php
    if ($god_mode_enable_linkedin_post == 'on')
        echo ' checked ';
?>>
<?php
if($no_tw == true)
{
    echo esc_html__("This option requires the Linkedinomatic Plugin for WordPress plugin to be active. Check it", 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://1.envato.market/linkedinomatic" target="_blank">' . esc_html__("here", 'aiomatic-automatic-ai-content-writer') . '</a>.</span></td></tr>';
}
?>
        </div>
        </td></tr>
        <tr class="hide_linkedin">
            <td>
                <div>
                <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                    <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                            echo esc_html__("Select the pages associated with your App ID, where you want to publish your posts. To select multiple entries, please hold down the 'Control' key.", 'aiomatic-automatic-ai-content-writer');
                            ?>
                    </div>
                </div>
                <b><?php echo esc_html__("LinkedIn Page Where to Publish Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                </div>
            </td>
            <td>
                <div>
                <select name="aiomatic_Chatbot_Settings[linkedin_selected_pages]" id="PagesSelect" class="cr_auto">
                <?php
                $companies = get_option('linkedinomatic_my_companies', array());
                if(is_array($companies) && count($companies) > 0)
                {
                    if(count($companies) > 0)
                    {
                        foreach($companies as $cmp_id => $cmp_name)
                        {
                            if($cmp_name == 'Profile Page')
                            {
                                echo '<option value="' . esc_attr($cmp_id) . '"';
                                if($cmp_id == $linkedin_selected_pages)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($cmp_name) . '</option>';
                            }
                            else
                            {
                                echo '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                if('xxxLinkedinomaticxxx' . $cmp_id == $linkedin_selected_pages)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($cmp_name) . '</option>';
                            }
                        }
                    }
                }
                ?>
                </select>
            </td>
        </tr>
        <tr><td colspan="2">
    <hr/>
        </td></tr>
    <tr><td colspan="2">
    <h3><?php echo esc_html__("Chatbot Extensions Activation Settings:", 'aiomatic-automatic-ai-content-writer');?></h3>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable Chatbot Extensions in the chatbot preview from below. This will apply only if regular AI models are used (not AI Assistants - for these, the Chatbot Extensions needs to be enabled from Assistant editing menu). Also, Chatbot Extensions will work only for logged in administrator privileged users.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Extensions In The Chabot Preview From Below:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="god_preview" name="aiomatic_Chatbot_Settings[god_preview]"<?php
    if ($god_preview == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable Chatbot Extensions in the globally injected chatbot, on the entire front end and/or back end of your site. This will apply only if regular AI models are used (not AI Assistants - for these, the Chatbot Extensions needs to be enabled from Assistant editing menu). Also, Chatbot Extensions will work only for logged in administrator privileged users.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Extensions In The Globally Injected Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="god_mode_front_end" name="aiomatic_Chatbot_Settings[god_mode_front_end]" >
<?php
echo '<option' . ($god_mode_front_end == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($god_mode_front_end == 'front' ? ' selected': '') . ' value="front">Front End</option>';
echo '<option' . ($god_mode_front_end == 'back' ? ' selected': '') . ' value="back">Back End</option>';
echo '<option' . ($god_mode_front_end == 'both' ? ' selected': '') . ' value="both">Front End & Back End</option>';
?>
</select>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Legacy Extensions:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Enable the ChatBot To Send Emails. Users will be able to ask the chatbot to send emails by providing the recipient, email subject and email content. The plugin will instruct the chatbot to return the content of the email in a specific format, which it will parse and send the email in the chatbot's name.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Legacy Email Sending Method (Not Recommended):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="extension_email" onchange="aiomatic_chatbot_email()" name="aiomatic_Chatbot_Settings[extension_email]" >
<?php
echo '<option' . ($extension_email == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($extension_email == 'on' ? ' selected': '') . ' value="on">On</option>';
?>
</select>
        </div>
        </td></tr>
        <tr class="hideemail"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the prompt completion to be sent to the AI writer, so it will become aware that it can send emails. This prompt will be added to the conversation only when the user enteres in the message sent to the AI, any of the following keywords: email, e-mail", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Writer Prompt For Email Sending Awareness:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<textarea rows="1" name="aiomatic_Chatbot_Settings[extension_email_prompt]" placeholder='Prompt to make the AI aware that it can send emails'><?php
    echo esc_textarea($extension_email_prompt);
?></textarea>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/6RQn-v9tlek" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
</table>
</div>
<div id="tab-11" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("AI Chatbot Limitations:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
    <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the daily token count for logged in users. Users who are not logged in will not be allowed to submit the form. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Total Token Cap Per Day For Users:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="0" step="1" id="user_token_cap_per_day" name="aiomatic_Chatbot_Settings[user_token_cap_per_day]" class="cr_width_full" value="<?php echo esc_html($user_token_cap_per_day);?>" placeholder="User token cap / day">
        </td></tr>
    <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum input length for user messages.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Single Message Max Input Length (Characters):", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="1" step="1" id="max_input_length" name="aiomatic_Chatbot_Settings[max_input_length]" class="cr_width_full" value="<?php echo esc_html($max_input_length);?>" placeholder="Max input length">
        </td></tr>
    <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum chat messages to send as API context. Default is to send as much as possible, to the AI, depending on model accepted token size.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Max Chat Messages To Send As API Context:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="1" step="1" id="max_message_count" name="aiomatic_Chatbot_Settings[max_message_count]" class="cr_width_full" value="<?php echo esc_html($max_message_count);?>" placeholder="Max context chat message count">
        </td></tr>
    <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the maximum chat message context size, in characters, which will be sent to the AI chatbot..", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Max Chat Context Size (Characters):", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="1" step="1" id="max_message_context" name="aiomatic_Chatbot_Settings[max_message_context]" class="cr_width_full" value="<?php echo esc_html($max_message_context);?>" placeholder="Max context chat size">
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to allow empty chat messages or not", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Disable Sending Of Empty Chat Messages:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="no_empty" name="aiomatic_Chatbot_Settings[no_empty]"<?php
    if ($no_empty == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Limits user requests by user IP. Set restriction time and set max requests per restriction time. Set also the restriction time window (in seconds) for the max requests.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Limit User Messages - Max Requests / Time Window:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="1" step="1" id="restriction_count" name="aiomatic_Chatbot_Settings[restriction_count]" class="cr_width_25p" value="<?php echo esc_html($restriction_count);?>" placeholder="<?php echo esc_html__("Set max requests", 'aiomatic-automatic-ai-content-writer');?>">&nbsp;<?php echo esc_html__("requests", 'aiomatic-automatic-ai-content-writer');?>&nbsp;/&nbsp; 
                    <input type="number" min="1" id="restriction_time" name="aiomatic_Chatbot_Settings[restriction_time]" class="cr_width_25p" value="<?php echo esc_html($restriction_time);?>" placeholder="<?php echo esc_html__("Set restriction time", 'aiomatic-automatic-ai-content-writer');?>">&nbsp;<?php echo esc_html__("seconds", 'aiomatic-automatic-ai-content-writer');?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a message to be displayed to restricted users.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Error Message When User Exceeded The Limit:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input id="restriction_message" name="aiomatic_Chatbot_Settings[restriction_message]" list="restriction_message" type="text" class="coderevolution_gutenberg_input" value="<?php echo esc_attr($restriction_message);?>" placeholder="You exceeded your requests limit."/>
        </div>
        </td></tr>
</table>
</div>
<div id="tab-8" class="tab-content">
    <table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Text-to-Speech/Video Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
<?php
if ((!isset($aiomatic_Main_Settings['elevenlabs_app_id']) || trim($aiomatic_Main_Settings['elevenlabs_app_id']) == '') && (!isset($aiomatic_Main_Settings['google_app_id']) || trim($aiomatic_Main_Settings['google_app_id']) == '') && (!isset($aiomatic_Main_Settings['did_app_id']) || trim($aiomatic_Main_Settings['did_app_id']) == '') && (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == ''))
{
    echo '<tr><td colspan="2"><h2>' . esc_html__("You need to enter an ElevenLabs.io API key, OpenAI API key, D-ID API key or a Google Text-to-Speech API key in the 'API Keys' tab and save settings, to use this feature.", 'aiomatic-automatic-ai-content-writer') . '</h2></td></tr>';
}
else
{
    if (isset($aiomatic_Main_Settings['elevenlabs_app_id']) && trim($aiomatic_Main_Settings['elevenlabs_app_id']) != '')
    {
        echo '<tr><td><b>' . esc_html__("Sync ElevenLabs.io Voices:", 'aiomatic-automatic-ai-content-writer') . '</b></td><td><input type="button" onclick="aiomatic_sync_voices_elevenlabs()" id="elevenlabs_sync" value="Sync"></td></tr>';
    }
    if (isset($aiomatic_Main_Settings['google_app_id']) && trim($aiomatic_Main_Settings['google_app_id']) != '')
    {
        echo '<tr><td><b>' . esc_html__("Sync Google Text-to-Speech Voices:", 'aiomatic-automatic-ai-content-writer') . '</b></td><td><input type="button" onclick="aiomatic_sync_voices_google()" id="google_sync" value="Sync"></td></tr>';
    }
?>
<tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable chatbot text to speech/video.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Text-to-Speech/Video:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="chatbot_text_speech" onchange="aiomatic_text_changed()" name="aiomatic_Chatbot_Settings[chatbot_text_speech]" >
<?php
echo '<option' . ($chatbot_text_speech == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($chatbot_text_speech == 'free' ? ' selected': '') . ' value="free">Browser Text-to-Speech (Free)</option>';
if (!isset($aiomatic_Main_Settings['app_id'])) 
{
    $aiomatic_Main_Settings['app_id'] = '';
}
$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
$appids = array_filter($appids);
if(empty($appids))
{
$token = '';
}
else
{
$token = $appids[array_rand($appids)];
} 
if(!aiomatic_is_aiomaticapi_key($token) && (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure'))
{
    echo '<option' . ($chatbot_text_speech == 'openai' ? ' selected': '') . ' value="openai">OpenAI Text-to-Speech</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'openai' ? ' selected': '') . ' disabled value="openai">OpenAI Text-to-Speech (' . esc_html__("Currently Only OpenAI API is supported for TTS", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
if (isset($aiomatic_Main_Settings['elevenlabs_app_id']) && trim($aiomatic_Main_Settings['elevenlabs_app_id']) != '')
{
    echo '<option' . ($chatbot_text_speech == 'elevenlabs' ? ' selected': '') . ' value="elevenlabs">ElevenLabs.io Text-to-Speech</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'elevenlabs' ? ' selected': '') . ' disabled value="elevenlabs">ElevenLabs.io Text-to-Speech (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
if (isset($aiomatic_Main_Settings['google_app_id']) && trim($aiomatic_Main_Settings['google_app_id']) != '')
{
    echo '<option' . ($chatbot_text_speech == 'google' ? ' selected': '') . ' value="google">Google Text-to-Speech</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'google' ? ' selected': '') . ' disabled value="google">Google Text-to-Speech (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
if (isset($aiomatic_Main_Settings['did_app_id']) && trim($aiomatic_Main_Settings['did_app_id']) != '')
{
    echo '<option' . ($chatbot_text_speech == 'did' ? ' selected': '') . ' value="did">D-ID Text-to-Video</option>';
    echo '<option' . ($chatbot_text_speech == 'didstream' ? ' selected': '') . ' value="didstream">D-ID Text-to-Video Streaming</option>';
}
else
{
    echo '<option' . ($chatbot_text_speech == 'did' ? ' selected': '') . ' disabled value="did">D-ID Text-to-Video (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
    echo '<option' . ($chatbot_text_speech == 'didstream' ? ' selected': '') . ' disabled value="didstream">D-ID Text-to-Video Streaming (' . esc_html__("Enter API key in Settings to enable", 'aiomatic-automatic-ai-content-writer') . ')</option>';
}
?>
</select>
        </div>
        </td></tr>
        <tr class="hidefree"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the voice which will be used by the chatbot. Please note that the list of voices may differ depending on the browser. For example, voices in the name of which contains Google will be available only in the Chrome browser. For Egde will be available Microsoft voices.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Voice:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="free_voice" name="aiomatic_Chatbot_Settings[free_voice]">
        <option value="Google US English;en-US" <?php if($free_voice == 'Google US English;en-US'){echo ' selected';}?> >
            Google US English, en-US
        </option><option value="Trinoids;en-US" <?php if($free_voice == 'Trinoids;en-US'){echo ' selected';}?> >
            Trinoids, en-US
        </option><option value="Microsoft David - English (United States);en-US" <?php if($free_voice == 'Microsoft David - English (United States);en-US'){echo ' selected';}?> >
            Microsoft David - English (United States), en-US
        </option><option value="Microsoft Mark - English (United States);en-US" <?php if($free_voice == 'Microsoft Mark - English (United States);en-US'){echo ' selected';}?> >
            Microsoft Mark - English (United States), en-US
        </option><option value="Microsoft Zira - English (United States);en-US" <?php if($free_voice == 'Microsoft Zira - English (United States);en-US'){echo ' selected';}?> >
            Microsoft Zira - English (United States), en-US
        </option><option value="Google Deutsch;de-DE" <?php if($free_voice == 'Google Deutsch;de-DE'){echo ' selected';}?> >
            Google Deutsch, de-DE
        </option><option value="Google UK English Female;en-GB" <?php if($free_voice == 'Google UK English Female;en-GB'){echo ' selected';}?> >
            Google UK English Female, en-GB
        </option><option value="Google UK English Male;en-GB" <?php if($free_voice == 'Google UK English Male;en-GB'){echo ' selected';}?> >
            Google UK English Male, en-GB
        </option><option value="Google español;es-ES" <?php if($free_voice == 'Google español;es-ES'){echo ' selected';}?> >
            Google español, es-ES
        </option><option value="Google español de Estados Unidos;es-US" <?php if($free_voice == 'Google español de Estados Unidos;es-US'){echo ' selected';}?> >
            Google español de Estados Unidos, es-US
        </option><option value="Google français;fr-FR" <?php if($free_voice == 'Google français;fr-FR'){echo ' selected';}?> >
            Google français, fr-FR
        </option><option value="Google हिन्दी;hi-IN" <?php if($free_voice == 'Google हिन्दी;hi-IN'){echo ' selected';}?> >
            Google हिन्दी, hi-IN
        </option><option value="Google Bahasa Indonesia;id-ID" <?php if($free_voice == 'Google Bahasa Indonesia;id-ID'){echo ' selected';}?> >
            Google Bahasa Indonesia, id-ID
        </option><option value="Google italiano;it-IT" <?php if($free_voice == 'Google italiano;it-IT'){echo ' selected';}?> >
            Google italiano, it-IT
        </option><option value="Google 日本語;ja-JP" <?php if($free_voice == 'Google 日本語;ja-JP'){echo ' selected';}?> >
            Google 日本語, ja-JP
        </option><option value="Google 한국의;ko-KR" <?php if($free_voice == 'Google 한국의;ko-KR'){echo ' selected';}?> >
            Google 한국의, ko-KR
        </option><option value="Google Nederlands;nl-NL" <?php if($free_voice == 'Google Nederlands;nl-NL'){echo ' selected';}?> >
            Google Nederlands, nl-NL
        </option><option value="Google polski;pl-PL" <?php if($free_voice == 'Google polski;pl-PL'){echo ' selected';}?> >
            Google polski, pl-PL
        </option><option value="Google português do Brasil;pt-BR" <?php if($free_voice == 'Google português do Brasil;pt-BR'){echo ' selected';}?> >
            Google português do Brasil, pt-BR
        </option><option value="Google русский;ru-RU" <?php if($free_voice == 'Google русский;ru-RU'){echo ' selected';}?> >
            Google русский, ru-RU
        </option><option value="Google 普通话（中国大陆）;zh-CN" <?php if($free_voice == 'Google 普通话（中国大陆）;zh-CN'){echo ' selected';}?> >
            Google&nbsp;普通话（中国大陆）, zh-CN
        </option><option value="Google 粤語（香港）;zh-HK" <?php if($free_voice == 'Google 粤語（香港）;zh-HK'){echo ' selected';}?> >
            Google&nbsp;粤語（香港）, zh-HK
        </option><option value="Google 國語（臺灣）;zh-TW" <?php if($free_voice == 'Google 國語（臺灣）;zh-TW'){echo ' selected';}?> >
            Google 國語（臺灣）, zh-TW
        </option></select>
        </div>
        </td></tr>
<tr class="hidedidstream"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the default width of the talking avatar. The default value for this is 300px.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Talking Avatar Width:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="1" id="did_width" name="aiomatic_Chatbot_Settings[did_width]" class="cr_width_full" value="<?php echo esc_html($did_width);?>" placeholder="300">
        </div>
        </td></tr>
        <tr class="hidedidstream"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the default height of the talking avatar. The default value for this is 300px.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Talking Avatar Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="1" id="did_height" name="aiomatic_Chatbot_Settings[did_height]" class="cr_width_full" value="<?php echo esc_html($did_height);?>" placeholder="300">
        </div>
        </td></tr>
<tr class="hidedid"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("The URL of the source image to be animated by the driver video, or a selection from the list of provided studio actors.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Actor Source Image URL:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input id="did_image" name="aiomatic_Chatbot_Settings[did_image]" list="did_image_list" type="text" list="did_image" class="coderevolution_gutenberg_input" value="<?php echo esc_attr($did_image);?>" placeholder="Actor URL"/>
                    <datalist id="did_image_list">
                    <option>https://create-images-results.d-id.com/api_docs/assets/noelle.jpeg</option>
                    <option>https://create-images-results.d-id.com/api_docs/assets/amy.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Zivva_f/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/William_m/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Sara_f/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Magen_f/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Luna_f/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Joaquin_m/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Jenna_f/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Ibrahim_m/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Hassan_m/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Gordon_m/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Fatha_f/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Fanna_f/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Eric_m/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Emma_f/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Emily_f/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Bull_m/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Brandon_m/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Billy_m/image.jpeg</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Aria_f/image.png</option>
                    <option>https://create-images-results.d-id.com/DefaultPresenters/Amber_f/image.jpeg</option>
                    </datalist>
        </div>
        </td></tr>
<tr class="hidedid"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a voice you want to use for your video chatbot. You can add voices in the following format: voice_provider:voice_name:voice_config - available voices lists:", 'aiomatic-automatic-ai-content-writer');
    echo '&nbsp;<a href="https://speech.microsoft.com/portal/voicegallery" target="_blank">https://speech.microsoft.com/portal/voicegallery</a> - <a href="https://docs.aws.amazon.com/polly/latest/dg/voicelist.html" target="_blank">https://docs.aws.amazon.com/polly/latest/dg/voicelist.html</a>';
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Select a Voice:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input id="did_voice" name="aiomatic_Chatbot_Settings[did_voice]" type="text" list="did_voice_list" class="coderevolution_gutenberg_input" value="<?php echo esc_attr($did_voice);?>" placeholder="Voice config"/>
                    <datalist id="did_voice_list">
                    <option>microsoft:en-US-JennyNeural:Neutral</option>
                    <option>microsoft:en-US-JennyNeural:Cheerful</option>
                    <option>microsoft:en-US-JennyNeural:Sad</option>
                    <option>microsoft:en-US-JennyNeural:Assistant</option>
                    <option>microsoft:en-US-JennyNeural:Chat</option>
                    <option>microsoft:en-US-JennyNeural:Newscast</option>
                    <option>microsoft:en-US-JennyNeural:Angry</option>
                    <option>microsoft:en-US-JennyNeural:Excited</option>
                    <option>microsoft:en-US-JennyNeural:Friendly</option>
                    <option>microsoft:en-US-JennyNeural:Terrified</option>
                    <option>microsoft:en-US-JennyNeural:Shouting</option>
                    <option>microsoft:en-US-JennyNeural:Unfriendly</option>
                    <option>microsoft:en-US-JennyNeural:Whispering</option>
                    <option>microsoft:en-US-JennyNeural:Hopeful</option>
                    <option>microsoft:en-US-JennyNeural:Default</option>
                    <option>microsoft:en-US-GuyNeural:Default</option>
                    <option>microsoft:en-US-GuyNeural:Newscast</option>
                    <option>microsoft:en-US-GuyNeural:Angry</option>
                    <option>microsoft:en-US-GuyNeural:Cheerful</option>
                    <option>microsoft:en-US-GuyNeural:Sad</option>
                    <option>microsoft:en-US-GuyNeural:Excited</option>
                    <option>microsoft:en-US-GuyNeural:Friendly</option>
                    <option>microsoft:en-US-GuyNeural:Terrified</option>
                    <option>microsoft:en-US-GuyNeural:Shouting</option>
                    <option>microsoft:en-US-GuyNeural:Unfriendly</option>
                    <option>microsoft:en-US-GuyNeural:Whispering</option>
                    <option>microsoft:en-US-GuyNeural:Hopeful</option>
                    <option>microsoft:en-US-AmberNeural</option>
                    <option>microsoft:en-US-AnaNeural</option>
                    <option>microsoft:en-US-AriaNeural:Default</option>
                    <option>microsoft:en-US-AriaNeural:Chat</option>
                    <option>microsoft:en-US-AriaNeural:Cheerful</option>
                    <option>microsoft:en-US-AriaNeural:Empathetic</option>
                    <option>microsoft:en-US-AriaNeural:Angry</option>
                    <option>microsoft:en-US-AriaNeural:Sad</option>
                    <option>microsoft:en-US-AriaNeural:Excited</option>
                    <option>microsoft:en-US-AriaNeural:Friendly</option>
                    <option>microsoft:en-US-AriaNeural:Terrified</option>
                    <option>microsoft:en-US-AriaNeural:Shouting</option>
                    <option>microsoft:en-US-AriaNeural:Unfriendly</option>
                    <option>microsoft:en-US-AriaNeural:Whispering</option>
                    <option>microsoft:en-US-AriaNeural:Hopeful</option>
                    <option>microsoft:en-US-AshleyNeural</option>
                    <option>microsoft:en-US-BrandonNeural</option>
                    <option>microsoft:en-US-ChristopherNeural</option>
                    <option>microsoft:en-US-CoraNeural</option>
                    <option>microsoft:en-US-DavisNeural:Default</option>
                    <option>microsoft:en-US-DavisNeural:Chat</option>
                    <option>microsoft:en-US-DavisNeural:Angry</option>
                    <option>microsoft:en-US-DavisNeural:Cheerful</option>
                    <option>microsoft:en-US-DavisNeural:Excited</option>
                    <option>microsoft:en-US-DavisNeural:Friendly</option>
                    <option>microsoft:en-US-DavisNeural:Hopeful</option>
                    <option>microsoft:en-US-DavisNeural:Sad</option>
                    <option>microsoft:en-US-DavisNeural:Shouting</option>
                    <option>microsoft:en-US-DavisNeural:Terrified</option>
                    <option>microsoft:en-US-DavisNeural:Unfriendly</option>
                    <option>microsoft:en-US-DavisNeural:Whispering</option>
                    <option>microsoft:en-US-ElizabethNeural</option>
                    <option>microsoft:en-US-EricNeural</option>
                    <option>microsoft:en-US-JacobNeural</option>
                    <option>microsoft:en-US-JaneNeural:Default</option>
                    <option>microsoft:en-US-JaneNeural:Cheerful</option>
                    <option>microsoft:en-US-JaneNeural:Angry</option>
                    <option>microsoft:en-US-JaneNeural:Excited</option>
                    <option>microsoft:en-US-JaneNeural:Friendly</option>
                    <option>microsoft:en-US-JaneNeural:Hopeful</option>
                    <option>microsoft:en-US-JaneNeural:Sad</option>
                    <option>microsoft:en-US-JaneNeural:Shouting</option>
                    <option>microsoft:en-US-JaneNeural:Terrified</option>
                    <option>microsoft:en-US-JaneNeural:Unfriendly</option>
                    <option>microsoft:en-US-JaneNeural:Whispering</option>
                    <option>microsoft:en-US-JaneNeural:Default</option>
                    <option>microsoft:en-US-JasonNeural:Default</option>
                    <option>microsoft:en-US-JasonNeural:Angry</option>
                    <option>microsoft:en-US-JasonNeural:Cheerful</option>
                    <option>microsoft:en-US-JasonNeural:Excited</option>
                    <option>microsoft:en-US-JasonNeural:Friendly</option>
                    <option>microsoft:en-US-JasonNeural:Hopeful</option>
                    <option>microsoft:en-US-JasonNeural:Sad</option>
                    <option>microsoft:en-US-JasonNeural:Shouting</option>
                    <option>microsoft:en-US-JasonNeural:Terrified</option>
                    <option>microsoft:en-US-JasonNeural:Unfriendly</option>
                    <option>microsoft:en-US-JasonNeural:Whispering</option>
                    <option>microsoft:en-US-MichelleNeural</option>
                    <option>microsoft:en-US-MonicaNeural</option>
                    <option>microsoft:en-US-NancyNeural:Default</option>
                    <option>microsoft:en-US-NancyNeural:Angry</option>
                    <option>microsoft:en-US-NancyNeural:Cheerful</option>
                    <option>microsoft:en-US-NancyNeural:Excited</option>
                    <option>microsoft:en-US-NancyNeural:Friendly</option>
                    <option>microsoft:en-US-NancyNeural:Hopeful</option>
                    <option>microsoft:en-US-NancyNeural:Sad</option>
                    <option>microsoft:en-US-NancyNeural:Shouting</option>
                    <option>microsoft:en-US-NancyNeural:Terrified</option>
                    <option>microsoft:en-US-NancyNeural:Unfriendly</option>
                    <option>microsoft:en-US-NancyNeural:Whispering</option>
                    <option>microsoft:en-US-RogerNeural</option>
                    <option>microsoft:en-US-SaraNeural:Default</option>
                    <option>microsoft:en-US-SaraNeural:Angry</option>
                    <option>microsoft:en-US-SaraNeural:Cheerful</option>
                    <option>microsoft:en-US-SaraNeural:Excited</option>
                    <option>microsoft:en-US-SaraNeural:Friendly</option>
                    <option>microsoft:en-US-SaraNeural:Hopeful</option>
                    <option>microsoft:en-US-SaraNeural:Sad</option>
                    <option>microsoft:en-US-SaraNeural:Shouting</option>
                    <option>microsoft:en-US-SaraNeural:Terrified</option>
                    <option>microsoft:en-US-SaraNeural:Unfriendly</option>
                    <option>microsoft:en-US-SaraNeural:Whispering</option>
                    <option>microsoft:en-US-SteffanNeural</option>
                    <option>microsoft:en-US-TonyNeural:Default</option>
                    <option>microsoft:en-US-TonyNeural:Angry</option>
                    <option>microsoft:en-US-TonyNeural:Cheerful</option>
                    <option>microsoft:en-US-TonyNeural:Excited</option>
                    <option>microsoft:en-US-TonyNeural:Friendly</option>
                    <option>microsoft:en-US-TonyNeural:Hopeful</option>
                    <option>microsoft:en-US-TonyNeural:Sad</option>
                    <option>microsoft:en-US-TonyNeural:Shouting</option>
                    <option>microsoft:en-US-TonyNeural:Terrified</option>
                    <option>microsoft:en-US-TonyNeural:Unfriendly</option>
                    <option>microsoft:en-US-TonyNeural:Whispering</option>
                    <option>microsoft:en-US-AIGenerate1Neural</option>
                    <option>microsoft:en-US-AIGenerate2Neural</option>
                    <option>amazon:Amy</option>
                    <option>amazon:Emma</option>
                    <option>amazon:Brian</option>
                    <option>amazon:Arthur</option>
                    <option>amazon:Nicole</option>
                    <option>amazon:Olivia</option>
                    <option>amazon:Russell</option>
                    <option>amazon:Ivy</option>
                    <option>amazon:Joanna</option>
                    <option>amazon:Kendra</option>
                    <option>amazon:Kimberly</option>
                    <option>amazon:Salli</option>
                    <option>amazon:Joey</option>
                    <option>amazon:Justin</option>
                    <option>amazon:Kevin</option>
                    <option>amazon:Matthew</option>
                    <option>amazon:Ruth</option>
                    <option>amazon:Stephen</option>
                    <option>amazon:Geraint</option>
                    <option>amazon:Ayanda</option>
                    <option>amazon:Aria</option>
                    <option>amazon:Aditi</option>
                    <option>amazon:Raveena</option>
                    <option>amazon:Kajal</option>
                    <option>amazon:Zeina</option>
                    <option>amazon:Hala</option>
                    <option>amazon:Arlet</option>
                    <option>amazon:Hiujin</option>
                    <option>amazon:Zhiyu</option>
                    <option>amazon:Naja</option>
                    <option>amazon:Mads</option>
                    <option>amazon:Laura</option>
                    <option>amazon:Lotte</option>
                    <option>amazon:Ruben</option>
                    <option>amazon:Suvi</option>
                    <option>amazon:Celine</option>
                    <option>amazon:L??a</option>
                    <option>amazon:Mathieu</option>
                    <option>amazon:R??mi</option>
                    <option>amazon:Chantal</option>
                    <option>amazon:Gabrielle</option>
                    <option>amazon:Liam</option>
                    <option>amazon:Marlene</option>
                    <option>amazon:Vicki</option>
                    <option>amazon:Hans</option>
                    <option>amazon:Daniel</option>
                    <option>amazon:Hannah</option>
                    <option>amazon:Dora</option>
                    <option>amazon:Karl</option>
                    <option>amazon:Carla</option>
                    <option>amazon:Bianca</option>
                    <option>amazon:Giorgio</option>
                    <option>amazon:Adriano</option>
                    <option>amazon:Mizuki</option>
                    <option>amazon:Takumi</option>
                    <option>amazon:Kazuha</option>
                    <option>amazon:Tomoko</option>
                    <option>amazon:Seoyeon</option>
                    <option>amazon:Liv</option>
                    <option>amazon:Ida</option>
                    <option>amazon:Ewa</option>
                    <option>amazon:Maja</option>
                    <option>amazon:Jacek</option>
                    <option>amazon:Jan</option>
                    <option>amazon:Ola</option>
                    <option>amazon:Camila</option>
                    <option>amazon:Vitoria</option>
                    <option>amazon:Ricardo</option>
                    <option>amazon:Thiago</option>
                    <option>amazon:Ines</option>
                    <option>amazon:Cristiano</option>
                    <option>amazon:Carmen</option>
                    <option>amazon:Tatyana</option>
                    <option>amazon:Maxim</option>
                    <option>amazon:Conchita</option>
                    <option>amazon:Lucia</option>
                    <option>amazon:Enrique</option>
                    <option>amazon:Sergio</option>
                    <option>amazon:Mia</option>
                    <option>amazon:Andr??s</option>
                    <option>amazon:Lupe</option>
                    <option>amazon:Penelope</option>
                    <option>amazon:Miguel</option>
                    <option>amazon:Pedro</option>
                    <option>amazon:Astrid</option>
                    <option>amazon:Elin</option>
                    <option>amazon:Filiz</option>
                    <option>amazon:Gwyneth</option>
                    <option>afflorithmics:en-US-JennyNeural</option>
                    <option>elevenlabs:en-US-JennyNeural</option>
                    </datalist>
        </div>
        </td></tr>
<tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a voice you want to use for your chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Select a Voice:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="eleven_voice" name="aiomatic_Chatbot_Settings[eleven_voice]" >
<?php
$eleven_voices = aiomatic_get_eleven_voices();
if($eleven_voices === false)
{
    echo '<option value="" disabled>'.esc_html__("Failed to list voices!", 'aiomatic-automatic-ai-content-writer').'</option>';
}
else
{
    foreach($eleven_voices as $key => $voice)
    {
        echo '<option' . ($eleven_voice == esc_attr($key) ? ' selected': '') . ' value="'.esc_attr($key).'">'.esc_html($voice).'</option>';
    }
}
?>
</select>
        </div>
        </td></tr>
        <tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a custom voice ID, if you want to use a custom voice ID from ElevenLabs. This will overwrite the voice ID added from above.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Custom Voice ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="width" name="aiomatic_Chatbot_Settings[eleven_voice_custom]" value="<?php echo esc_html($eleven_voice_custom);?>" placeholder="Custom voice ID">
        </div>
        </td></tr>
        <tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the model to be used when generating the voices.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice AI Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="eleven_model_id" name="aiomatic_Chatbot_Settings[eleven_model_id]" >
<?php
echo '<option' . ($eleven_model_id == 'eleven_monolingual_v1' ? ' selected': '') . ' value="eleven_monolingual_v1">eleven_monolingual_v1</option>';
echo '<option' . ($eleven_model_id == 'eleven_multilingual_v1' ? ' selected': '') . ' value="eleven_multilingual_v1">eleven_multilingual_v1</option>';
echo '<option' . ($eleven_model_id == 'eleven_multilingual_v2' ? ' selected': '') . ' value="eleven_multilingual_v2">eleven_multilingual_v2</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the Voice stability of the chosen voice. Higher stability ensures consistency but may result in monotony, therefore for longer text, it is recommended to decrease stability. The default value is 0.75", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Stability:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="0" step="0.01" id="voice_stability" name="aiomatic_Chatbot_Settings[voice_stability]" class="cr_width_full" value="<?php echo esc_html($voice_stability);?>" placeholder="0.75">
        </div>
        </td></tr>
        <tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Boosting voice clarity and target speaker similarity is achieved by high enhancement; however, very high values can produce artifacts, so it's essential to find the optimal setting. The default value is 0.75", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Similarity Boost:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="0" step="0.01" id="voice_similarity_boost" name="aiomatic_Chatbot_Settings[voice_similarity_boost]" class="cr_width_full" value="<?php echo esc_html($voice_similarity_boost);?>" placeholder="0.75">
        </div>
        </td></tr>
        <tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Boost the characteristics of the voice. Default is disabled.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Style Exaggeration:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="0" step="0.01" id="voice_style" name="aiomatic_Chatbot_Settings[voice_style]" class="cr_width_full" value="<?php echo esc_html($voice_style);?>" placeholder="Style exaggeration">
        </div>
        </td></tr>
        <tr class="hideeleven"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Boost the similarity of the synthesized speech and the voice at the cost of some generation speed.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Speaker Boost:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="speaker_boost" name="aiomatic_Chatbot_Settings[speaker_boost]"<?php
    if ($speaker_boost == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hideopen"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the model to be used when generating the voices.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice AI Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="open_model_id" name="aiomatic_Chatbot_Settings[open_model_id]" >
<?php
echo '<option' . ($open_model_id == 'tts-1' ? ' selected': '') . ' value="tts-1">tts-1</option>';
echo '<option' . ($open_model_id == 'tts-1-hd' ? ' selected': '') . ' value="tts-1-hd">tts-1-hd</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr class="hideopen"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the voice to be used when generating the text to speech.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Voice Selector:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="open_voice" name="aiomatic_Chatbot_Settings[open_voice]" >
<?php
echo '<option' . ($open_voice == 'alloy' ? ' selected': '') . ' value="alloy">alloy</option>';
echo '<option' . ($open_voice == 'echo' ? ' selected': '') . ' value="echo">echo</option>';
echo '<option' . ($open_voice == 'fable' ? ' selected': '') . ' value="fable">fable</option>';
echo '<option' . ($open_voice == 'nova' ? ' selected': '') . ' value="nova">nova</option>';
echo '<option' . ($open_voice == 'onyx' ? ' selected': '') . ' value="onyx">onyx</option>';
echo '<option' . ($open_voice == 'shimmer' ? ' selected': '') . ' value="shimmer">shimmer</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr class="hideopen"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the output format to be used when generating the text to speech.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Voice Output Format:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="open_format" name="aiomatic_Chatbot_Settings[open_format]" >
<?php
echo '<option' . ($open_format == 'mp3' ? ' selected': '') . ' value="mp3">mp3</option>';
echo '<option' . ($open_format == 'opus' ? ' selected': '') . ' value="opus">opus</option>';
echo '<option' . ($open_format == 'aac' ? ' selected': '') . ' value="aac">aac</option>';
echo '<option' . ($open_format == 'flac' ? ' selected': '') . ' value="flac">flac</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr class="hideopen"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the Voice speed of the chosen voice. The default value is 1. Min: 0.25, max: 4.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Stability:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="0.25" step="0.01" max="4" id="open_speed" name="aiomatic_Chatbot_Settings[open_speed]" class="cr_width_full" value="<?php echo esc_html($open_speed);?>" placeholder="1">
        </div>
        </td></tr>
<tr class="hidegoogle"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the language of the chosen voice.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="voice_language" name="aiomatic_Chatbot_Settings[voice_language]" >
<?php
$gvlanguages = array(
    'af-ZA' => 'Afrikaans (South Africa)',
    'ar-XA' => 'Arabic, multi-region',
    'id-ID' => 'Indonesian (Indonesia)',
    'ms-MY' => 'Malay (Malaysia)',
    'ca-ES' => 'Catalan (Spain)',
    'da-DK' => 'Danish (Denmark)',
    'de-DE' => 'German (Germany)',
    'en-AU' => 'English (Australia)',
    'en-GB' => 'English (Great Britain)',
    'en-IN' => 'English (India)',
    'en-US' => 'English (United States)',
    'es-ES' => 'Spanish (Spain)',
    'es-US' => 'Spanish (United States)',
    'eu-ES' => 'Basque (Spain)',
    'fil-PH' => 'Filipino (Philippines)',
    'fr-CA' => 'French (Canada)',
    'fr-FR' => 'French (France)',
    'gl-ES' => 'Galician (Spain)',
    'it-IT' => 'Italian (Italy)',
    'lv-LV' => 'Latvian (Latvia)',
    'lt-LT' => 'Lithuanian (Lithuania)',
    'hu-HU' => 'Hungarian (Hungary)',
    'nl-NL' => 'Dutch (Netherlands)',
    'nb-NO' => 'Norwegian Bokmål (Norway)',
    'pl-PL' => 'Polish (Poland)',
    'pt-BR' => 'Portuguese (Brazil)',
    'pt-PT' => 'Portuguese (Portugal)',
    'ro-RO' => 'Romanian (Romania)',
    'sk-SK' => 'Slovak (Slovakia)',
    'fi-FI' => 'Finnish (Finland)',
    'sv-SE' => 'Swedish (Sweden)',
    'vi-VN' => 'Vietnamese (Vietnam)',
    'tr-TR' => 'Turkish (Turkey)',
    'is-IS' => 'Icelandic (Iceland)',
    'cs-CZ' => 'Czech (Czech Republic)',
    'el-GR' => 'Greek (Greece)',
    'bg-BG' => 'Bulgarian (Bulgaria)',
    'ru-RU' => 'Russian (Russia)',
    'sr-RS' => 'Serbian (Serbia)',
    'uk-UA' => 'Ukrainian (Ukraine)',
    'he-IL' => 'Hebrew (Israel)',
    'mr-IN' => 'Marathi (India)',
    'hi-IN' => 'Hindi (India)',
    'bn-IN' => 'Bengali (India)',
    'gu-IN' => 'Gujarati (India)',
    'ta-IN' => 'Tamil (India)',
    'te-IN' => 'Telugu (India)',
    'kn-IN' => 'Kannada (India)',
    'ml-IN' => 'Malayalam (India)',
    'th-TH' => 'Thai (Thailand)',
    'cmn-TW' => 'Mandarin (Taiwan)',
    'yue-HK' => 'Cantonese (Hong Kong)',
    'ja-JP' => 'Japanese (Japan)',
    'cmn-CN' => 'Mandarin (Mainland China)',
    'ko-KR' => 'Korean (South Korea)'
);
foreach($gvlanguages as $key => $lang)
{
    echo '<option' . ($voice_language == esc_attr($key) ? ' selected': '') . ' value="'.esc_attr($key).'">'.esc_html($lang).'</option>';
}
?>
</select>
        </div>
        </td></tr>
        <tr class="hidegoogle"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the name of the chosen voice.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="google_voice" name="aiomatic_Chatbot_Settings[google_voice]" >
<?php
if (!isset($aiomatic_Main_Settings['google_app_id']) || trim($aiomatic_Main_Settings['google_app_id']) == '')
{
    $google_voices = false;
}
else
{
    $google_voices = aiomatic_get_google_voices($voice_language);
}
if($google_voices === false)
{
    echo '<option value="" disabled>'.esc_html__("Failed to list voices!", 'aiomatic-automatic-ai-content-writer').'</option>';
}
else
{
    foreach($google_voices as $key => $voice)
    {
        echo '<option' . ($google_voice == esc_attr($voice['name']) ? ' selected': '') . ' value="'.esc_attr($voice['name']).'">'.esc_html($voice['name']).'</option>';
    }
}
?>
</select>
        </div>
        </td></tr>
        <tr class="hidegoogle"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the Audio Device Profile of the chosen voice.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Audio Device Profile:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="audio_profile" name="aiomatic_Chatbot_Settings[audio_profile]" >
<?php
$gvprofiles = array(
    '' => esc_html__('Default','aiomatic-automatic-ai-content-writer'),
    'wearable-class-device' => esc_html__('Smart watch or wearable','aiomatic-automatic-ai-content-writer'),
    'handset-class-device' => esc_html__('Smartphone','aiomatic-automatic-ai-content-writer'),
    'headphone-class-device' => esc_html__('Headphones or earbuds','aiomatic-automatic-ai-content-writer'),
    'small-bluetooth-speaker-class-device' => esc_html__('Small home speaker','aiomatic-automatic-ai-content-writer'),
    'medium-bluetooth-speaker-class-device' => esc_html__('Smart home speaker','aiomatic-automatic-ai-content-writer'),
    'large-home-entertainment-class-device' => esc_html__('Home entertainment system or smart TV','aiomatic-automatic-ai-content-writer'),
    'large-automotive-class-device' => esc_html__('Car speaker','aiomatic-automatic-ai-content-writer'),
    'telephony-class-application' => esc_html__('Interactive Voice Response (IVR) system','aiomatic-automatic-ai-content-writer')
);
foreach($gvprofiles as $key => $val)
{
    echo '<option' . ($audio_profile == esc_attr($key) ? ' selected': '') . ' value="'.esc_attr($key).'">'.esc_html($val).'</option>';
}
?>
</select>
        </div>
        </td></tr>
        <tr class="hidegoogle"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the Voice Speed of the chosen voice. Speaking rate/speed, in the range [0.25, 4.0]. 1.0 is the normal native speed supported by the specific voice. 2.0 is twice as fast, and 0.5 is half as fast. If unset(0.0), defaults to the native 1.0 speed. Any other values < 0.25 or > 4.0 will return an error.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Speed:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="0.25" max="4" step="0.01" id="voice_speed" name="aiomatic_Chatbot_Settings[voice_speed]" class="cr_width_full" value="<?php echo esc_html($voice_speed);?>" placeholder="Voice speed">
        </div>
        </td></tr>
        <tr class="hidegoogle"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a the Voice Pitch of the chosen voice. Speaking pitch, in the range [-20.0, 20.0]. 20 means increase 20 semitones from the original pitch. -20 means decrease 20 semitones from the original pitch.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Pitch:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="number" min="-20" step="0.1" max="20" id="voice_pitch" name="aiomatic_Chatbot_Settings[voice_pitch]" class="cr_width_full" value="<?php echo esc_html($voice_pitch);?>" placeholder="Voice pitch">
        </div>
        </td></tr><tr><td colspan="2">
    <h2><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/OwCsRmsfS-0" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("D-ID Streaming Video Update:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/oaquPhw3GrQ" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
<?php
}
?>
    </table>
</div>
<div id="tab-1" class="tab-content">
    <table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("AI Chatbot Default Styling Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the chatbot header.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Chatbot Header:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_header" name="aiomatic_Chatbot_Settings[show_header]" onchange="headerChanged();" >
<?php
echo '<option'.($show_header == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_header == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Chat Log TXT or PDF File Download Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Chat Log File Download Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_dltxt" name="aiomatic_Chatbot_Settings[show_dltxt]" onchange="txtbutChanged();" >
<?php
echo '<option'.($show_dltxt == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_dltxt == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Text-To-Speech Mute Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Text-To-Speech Mute Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select
<?php 
if (!isset($aiomatic_Chatbot_Settings['chatbot_text_speech']) || $aiomatic_Chatbot_Settings['chatbot_text_speech'] == 'off' || $aiomatic_Chatbot_Settings['chatbot_text_speech'] == '' ) 
{
    echo ' disabled title="' . esc_html__("Text-To-Speech feature needs to be active for this feature to work", 'aiomatic-automatic-ai-content-writer') . '"';
}
?> id="show_mute" name="aiomatic_Chatbot_Settings[show_mute]" onchange="mutebutChanged();" >
<?php
echo '<option'.($show_mute == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_mute == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Disable Internet Access Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Disable Internet Access Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select
<?php 
if(!isset($aiomatic_Main_Settings['internet_chat_short']) || $aiomatic_Main_Settings['internet_chat_short'] != 'on')
{
    echo ' disabled title="' . esc_html__("You need to enable Internet Access For Chatbots for this to work", 'aiomatic-automatic-ai-content-writer') . '"';
}
?> id="show_internet" name="aiomatic_Chatbot_Settings[show_internet]" onchange="internetChanged();" >
<?php
echo '<option'.($show_internet == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_internet == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the Chat Clearing Button.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show Chat Clearing Button:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_clear" name="aiomatic_Chatbot_Settings[show_clear]" onchange="clearbutChanged();" >
<?php
echo '<option'.($show_clear == 'show' ? ' selected': '').' value="show">Show</option>';
echo '<option'.($show_clear == 'hide' ? ' selected': '').' value="hide">Hide</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the chat font size of the chatbot form. Default is 1em", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Font Size:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="font_size" name="aiomatic_Chatbot_Settings[font_size]" onchange="fontSizeChanged();" >
<?php
echo '<option'.($font_size == '1em' ? ' selected': '').' value="1em">1em</option>';
for($i = 10; $i <= 30; $i++){
    echo '<option'.($font_size == $i . 'px' ? ' selected': '').' value="'.esc_html($i).'px">'.esc_html($i).'px</option>';
}
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the width of the chatbot form. For full width, you can set 100% (default value). You can also set values in pixels, like: 400px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Form Width:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="width" name="aiomatic_Chatbot_Settings[width]" value="<?php echo esc_html($width);?>" placeholder="100%" onchange="widthChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the height of the chatbot form. Default is auto. You can set values in pixels, like: 400px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Form Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="height" name="aiomatic_Chatbot_Settings[height]" value="<?php echo esc_html($height);?>" placeholder="auto" onchange="heightChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the min-height of the chatbot form (when the form is resized, this is the minimum height it will be allowed to get. Default is 250px. You can set values in pixels, like: 400px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chat Form Min-Height:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" id="minheight" name="aiomatic_Chatbot_Settings[minheight]" value="<?php echo esc_html($minheight);?>" placeholder="250px" onchange="minheightChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set your own custom header text for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Custom Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
          $settings = array(
            'textarea_name' => 'aiomatic_Chatbot_Settings[custom_header]',
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4',
            'editor_height' => 80,
            'teeny' => false
          );
          wp_editor( $custom_header, 'custom_header', $settings );
?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set your own custom footer text for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Custom Footer Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
          $settings = array(
            'textarea_name' => 'aiomatic_Chatbot_Settings[custom_footer]',
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4',
            'editor_height' => 80,
            'teeny' => false
          );
          wp_editor( $custom_footer, 'custom_footer', $settings );
?>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set your own custom CSS code for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Custom CSS Code:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<?php
          $settings = array(
            'textarea_name' => 'aiomatic_Chatbot_Settings[custom_css]',
            'media_buttons' => true,
            'quicktags' => true,
            'tabindex' => '4',
            'editor_height' => 80,
            'teeny' => false
          );
          wp_editor( $custom_css, 'custom_css', $settings );
?>
        </div>
        </td></tr>
        <tr><td colspan="2"><h2><?php echo esc_html__("AI Chatbot Coloring Options:", 'aiomatic-automatic-ai-content-writer');?></h2></td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the background color of the chatbot form. Default is #f7f7f9", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Form Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="general_background" name="aiomatic_Chatbot_Settings[general_background]" value="<?php echo esc_html($general_background);?>" onchange="backgroundChanged2()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the background color of the chatbot form. Default is #f7f7f9", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="background" name="aiomatic_Chatbot_Settings[background]" value="<?php echo esc_html($background);?>" onchange="backgroundChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the user chatbot form. Default is white", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("User Font Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="user_font_color" name="aiomatic_Chatbot_Settings[user_font_color]" value="<?php echo esc_html($user_font_color);?>" onchange="userfontcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the user baloon chatbot form. Default is #0084ff", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("User Baloon Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="user_background_color" name="aiomatic_Chatbot_Settings[user_background_color]" value="<?php echo esc_html($user_background_color);?>" onchange="userbackgroundcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the AI chatbot form. Default is black", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Font Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="ai_font_color" name="aiomatic_Chatbot_Settings[ai_font_color]" value="<?php echo esc_html($ai_font_color);?>" onchange="aifontcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the font color of the AI baloon chatbot form. Default is #f0f0f0", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Baloon Background Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="ai_background_color" name="aiomatic_Chatbot_Settings[ai_background_color]" value="<?php echo esc_html($ai_background_color);?>" onchange="aibackgroundcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the border color for the input field. Default is #e1e3e6", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Border Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="input_border_color" name="aiomatic_Chatbot_Settings[input_border_color]" value="<?php echo esc_html($input_border_color);?>" onchange="bordercolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the text color for the input field. Default is #e1e3e6", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Text Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="input_text_color" name="aiomatic_Chatbot_Settings[input_text_color]" value="<?php echo esc_html($input_text_color);?>" onchange="inputtextcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the placeholder color for the input field. Default is #e1e3e6", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Input Placeholder Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="input_placeholder_color" name="aiomatic_Chatbot_Settings[input_placeholder_color]" value="<?php echo esc_html($input_placeholder_color);?>" onchange="inputplaceholdercolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the persona name color for the input field. Default is #3c434a", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Persona Name Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="persona_name_color" name="aiomatic_Chatbot_Settings[persona_name_color]" value="<?php echo esc_html($persona_name_color);?>" onchange="personanamecolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the persona role color for the input field. Default is #3c434a", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Persona Role Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="persona_role_color" name="aiomatic_Chatbot_Settings[persona_role_color]" value="<?php echo esc_html($persona_role_color);?>" onchange="personarolecolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the submit button. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Submit Button Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="submit_color" name="aiomatic_Chatbot_Settings[submit_color]" value="<?php echo esc_html($submit_color);?>" onchange="submitcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the text color of the submit button. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Submit Button Text Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="submit_text_color" name="aiomatic_Chatbot_Settings[submit_text_color]" value="<?php echo esc_html($submit_text_color);?>" onchange="submittextcolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the voice button. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Button Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="voice_color" name="aiomatic_Chatbot_Settings[voice_color]" value="<?php echo esc_html($voice_color);?>" onchange="voicecolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the color of the voice button when activated. Default is #55a7e2", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Voice Button Activated Color:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="color" id="voice_color_activated" name="aiomatic_Chatbot_Settings[voice_color_activated]" value="<?php echo esc_html($voice_color_activated);?>" onchange="voicecolorChanged()">
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the chatbot header.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Theme:", 'aiomatic-automatic-ai-content-writer');?></b><br/>
                    </div>
                    </td><td>
                    <div>
                    <select id="chat_theme" name="aiomatic_Chatbot_Settings[chat_theme]" onchange="themeChanged();" class="cr_width_full">
<?php
echo '<option'.($chat_theme == '' ? ' selected': '').' value="">No Change</option>';
echo '<option'.($chat_theme == 'light' ? ' selected': '').' value="light">Light</option>';
echo '<option'.($chat_theme == 'dark' ? ' selected': '').' value="dark">Dark</option>';
echo '<option'.($chat_theme == 'midnight' ? ' selected': '').' value="midnight">Midnight</option>';
echo '<option'.($chat_theme == 'sunrise' ? ' selected': '').' value="sunrise">Sunrise</option>';
echo '<option'.($chat_theme == 'ocean' ? ' selected': '').' value="ocean">Ocean</option>';
echo '<option'.($chat_theme == 'forest' ? ' selected': '').' value="forest">Forest</option>';
echo '<option'.($chat_theme == 'winter' ? ' selected': '').' value="winter">Winter</option>';
echo '<option'.($chat_theme == 'twilight' ? ' selected': '').' value="twilight">Twilight</option>';
echo '<option'.($chat_theme == 'desert' ? ' selected': '').' value="desert">Desert</option>';
echo '<option'.($chat_theme == 'cosmic' ? ' selected': '').' value="cosmic">Cosmic</option>';
echo '<option'.($chat_theme == 'rose' ? ' selected': '').' value="rose">Rose</option>';
echo '<option'.($chat_theme == 'tropical' ? ' selected': '').' value="tropical">Tropical</option>';
echo '<option'.($chat_theme == 'facebook' ? ' selected': '').' value="facebook">Facebook</option>';
echo '<option'.($chat_theme == 'twitter' ? ' selected': '').' value="twitter">Twitter</option>';
echo '<option'.($chat_theme == 'instagram' ? ' selected': '').' value="instagram">Instagram</option>';
echo '<option'.($chat_theme == 'whatsapp' ? ' selected': '').' value="whatsapp">WhatsApp</option>';
echo '<option'.($chat_theme == 'linkedin' ? ' selected': '').' value="linkedin">LinkedIn</option>';
if($aiomatic_themes->have_posts())
{
    foreach ($aiomatic_themes->posts as $aiomatic_theme)
    {
        echo '<option'.($chat_theme == $aiomatic_theme->ID ? ' selected': '').' value="' . $aiomatic_theme->ID . '">'. esc_html($aiomatic_theme->post_title) . '</option>';
    }
}
?>
                    </select>
        </div>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Theme Management:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Save new color themes from current color settings.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Save New Theme From Current Colors:", 'aiomatic-automatic-ai-content-writer');?></b></td>
        <td>
                    <button href="#" id="aiomatic_save_theme" class="page-title-action"><?php
        echo esc_html__("Save New Theme", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        </td></tr>
        <tr><td>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Delete an existing theme from the listed themes.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Delete Existing Theme:", 'aiomatic-automatic-ai-content-writer');?></b></td>
        <td>
<?php     
if($aiomatic_themes->have_posts())
{
    echo '<select id="chat_theme_delete" class="cr_width_60p">';
    echo '<option value="" selected disabled>'. esc_html__("Select a theme to delete", 'aiomatic-automatic-ai-content-writer') . '</option>';
    foreach ($aiomatic_themes->posts as $aiomatic_theme)
    {
        echo '<option value="' . $aiomatic_theme->ID . '">'. esc_html($aiomatic_theme->post_title) . '</option>';
    }
    echo '</select>';
}
else
{
    echo '<select id="chat_theme_delete" class="cr_width_60p">';
    echo '<option value="" selected disabled>'. esc_html__("No saved themes available", 'aiomatic-automatic-ai-content-writer') . '</option>';
    echo '</select>';
}
?>
    <button href="#"<?php if(!$aiomatic_themes->have_posts()){ echo ' disabled';}?> id="aiomatic_delete_theme" class="cr_float_right page-title-action"><?php
        echo esc_html__("Delete Selected Theme", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Chatbot Themes Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/M1uwngrumrg" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
    </table>
</div>
<div id="tab-2" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("AI Chatbot Moderation Options:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable chatbot moderation", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable User Message Moderation:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="enable_moderation" name="aiomatic_Chatbot_Settings[enable_moderation]"<?php
    if ($enable_moderation == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the AI model you want to use for moderation.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("AI Moderation Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="moderation_model" name="aiomatic_Chatbot_Settings[moderation_model]" class="cr_width_full">
<?php
echo '<option' . ($moderation_model == 'text-moderation-stable' ? ' selected': '') . ' value="text-moderation-stable">text-moderation-stable</option>';
echo '<option' . ($moderation_model == 'text-moderation-latest' ? ' selected': '') . ' value="text-moderation-latest">text-moderation-latest</option>';
?>
                    </select>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the message which will appear to users when their input is flagged.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Flagged Text Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <textarea rows="1" name="aiomatic_Chatbot_Settings[flagged_message]" placeholder="Your message has been flagged as potentially harmful or inappropriate. Please review your language and content to ensure it aligns with our values of respect and sensitivity towards others. Thank you for your cooperation."><?php
    echo esc_textarea($flagged_message);
?></textarea>
        </div>
        </td></tr>
</table>
</div>
<div id="tab-3" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("AI Chatbot Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to make the chatbot respond with full text or do you want to enable response streaming, which is the recommended method to be used. In this case, the response will appear in real time, as it is generated by the AI (similar to ChatGPT). You can also use a typing effect, so text will appear gradually, but in this case, the response will start to appear only after the AI sent the full response to the plugin. This is also required for the text-to-speech feature of the plugin.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Instant Responses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
        <select id="instant_response" name="aiomatic_Chatbot_Settings[instant_response]" class="cr_width_full" onchange="instantResponseChanged();">
    <?php
echo '<option' . ($instant_response == 'on' ? ' selected': '') . ' value="on">'. esc_html__("Instant Response", 'aiomatic-automatic-ai-content-writer') . '</option>';
if (!isset($aiomatic_Main_Settings['app_id'])) 
{
    $aiomatic_Main_Settings['app_id'] = '';
}
$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
$appids = array_filter($appids);
if(empty($appids))
{
$token = '';
}
else
{
$token = $appids[array_rand($appids)];
} 
if(!aiomatic_is_aiomaticapi_key($token))
{
    echo '<option' . ($instant_response == 'stream' ? ' selected': '') . ' value="stream">'. esc_html__("Response Streaming (Recommended)", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
echo '<option' . ($instant_response == 'off' ? ' selected': '') . ' value="off">'. esc_html__("Typewriter Effect", 'aiomatic-automatic-ai-content-writer') . '</option>';
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideStreamer"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to allow users to stop response creation when AI message streaming in progress.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Allow Users To Stop Response Creation When Streaming:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="allow_stream_stop" name="aiomatic_Chatbot_Settings[allow_stream_stop]"<?php
    if ($allow_stream_stop == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to disable modern response processing in the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Disable Chatbot Modern Response Processing:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="disable_modern_chat" name="aiomatic_Chatbot_Settings[disable_modern_chat]"<?php
    if ($disable_modern_chat == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to allow the chatbot to send HTML responses and the plugin to execute and parse these HTML responses.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot HTML Responses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="enable_html" name="aiomatic_Chatbot_Settings[enable_html]"<?php
    if ($enable_html == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to remove JavaScript code from the chatbot's HTML responses.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Strip JavaScript From Chatbot HTML Responses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="strip_js" name="aiomatic_Chatbot_Settings[strip_js]"<?php
    if ($strip_js == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the copying of messages, if users click the message bubbles.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Message Copying By Clicking It:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="enable_copy" name="aiomatic_Chatbot_Settings[enable_copy]"<?php
    if ($enable_copy == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to automatically scroll the window to bottom on new messages.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Scroll To Bottom Of The Form On New Messages:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="scroll_bot" name="aiomatic_Chatbot_Settings[scroll_bot]"<?php
    if ($scroll_bot == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a sound effect to be played when a message is sent in the chatbot. To disable this feature, leave this settings field blank. You can get free sound effects from here: https://pixabay.com/sound-effects/search/notification/?order=ec", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot 'Send Message' Sound Effect:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" placeholder="<?php echo esc_html__("Upload your 'Send Message' sound effect file using the button from below", 'aiomatic-automatic-ai-content-writer');?>" id="send_message_sound" name="aiomatic_Chatbot_Settings[send_message_sound]" value="<?php echo esc_attr($send_message_sound); ?>" />
                    <button class="button" id="aiomatic_upload_send_sound_button"><?php echo esc_html__("Upload a 'Send Message' sound effect", 'aiomatic-automatic-ai-content-writer');?></button>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select a sound effect to be played when a message is received in the chatbot. To disable this feature, leave this settings field blank. You can get free sound effects from here: https://pixabay.com/sound-effects/search/notification/?order=ec", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot 'Receive Message' Sound Effect:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" placeholder="<?php echo esc_html__("Upload your 'Receive Message' sound effect file using the button from below", 'aiomatic-automatic-ai-content-writer');?>" id="receive_message_sound" name="aiomatic_Chatbot_Settings[receive_message_sound]" value="<?php echo esc_attr($receive_message_sound); ?>" />
                    <button class="button" id="aiomatic_upload_receive_sound_button"><?php echo esc_html__("Upload a 'Receive Message' sound effect", 'aiomatic-automatic-ai-content-writer');?></button>
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a number of milliseconds to set as a delay for the chatbot. You can also set an interval between two values (in ms), case in which, the chatbot will select a random number of milliseconds from that interval, at each response.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Response Delay (ms):", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="text" placeholder="<?php echo esc_html__("Example: 100-500", 'aiomatic-automatic-ai-content-writer');?>" id="response_delay" name="aiomatic_Chatbot_Settings[response_delay]" value="<?php echo esc_attr($response_delay); ?>" />
        </div>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable the voice input feature for the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chatbot Voice Input:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="voice_input" onchange="voiceChanged();" name="aiomatic_Chatbot_Settings[voice_input]"<?php
    if ($voice_input == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hideVoice"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to automatically submit form after speech recognition is complete.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Enable Chat Auto-Submit On Voice Input Completion:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="auto_submit_voice" name="aiomatic_Chatbot_Settings[auto_submit_voice]"<?php
    if ($auto_submit_voice == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the file format how you want to allow users to download chatbot conversations to file.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Download Chat Conversation To File As:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="chat_download_format" name="aiomatic_Chatbot_Settings[chat_download_format]" class="cr_width_full">
    <?php
echo '<option' . ($chat_download_format == 'txt' ? ' selected': '') . ' value="txt">Txt</option>';
if (!is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
{
    echo '<option disabled title="Feature not available, check the \'PDF Chat\' tab for details" value="pdf">Pdf</option>';
}
else
{
    echo '<option' . ($chat_download_format == 'pdf' ? ' selected': '') . ' value="pdf">Pdf</option>';
}
?>
    </select>  
    </td>
    </tr>
        <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the default chat mode (image or text).", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Default Chat Mode:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="chat_mode" name="aiomatic_Chatbot_Settings[chat_mode]" class="cr_width_full">
    <?php
echo '<option' . ($chat_mode == 'text' ? ' selected': '') . ' value="text">Text</option>';
echo '<option' . ($chat_mode == 'images' ? ' selected': '') . ' value="images">Image</option>';
?>
    </select>  
    </td>
    </tr>
    <tr><td>
    <div>
    <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                    <div class="bws_hidden_help_text cr_min_260px">
<?php
echo esc_html__("Select if you want to enable the prompts to be user editable. You should use this feature only together with the prompt templates feature.", 'aiomatic-automatic-ai-content-writer');
?>
                    </div>
                </div>
                <b><?php echo esc_html__("Prompt Templates:", 'aiomatic-automatic-ai-content-writer');?></b>
                </div>
                </td><td>
                <div>
                <textarea rows="2" name="aiomatic_Chatbot_Settings[prompt_templates]" placeholder="Add a semicolon (;) separated list of prompt templates from which the users will be able to select and submit one."><?php
echo esc_textarea($prompt_templates);
?></textarea>
    </div>
    </td></tr>
    <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable the prompts to be user editable. You should use this feature only together with the prompt templates feature.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Prompts Editable By Users:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="prompt_editable" name="aiomatic_Chatbot_Settings[prompt_editable]" class="cr_width_full">
    <?php
echo '<option' . ($prompt_editable == 'on' ? ' selected': '') . ' value="on">On</option>';
echo '<option' . ($prompt_editable == 'off' ? ' selected': '') . ' value="off">Off</option>';
?>
    </select>  
    </td>
    </tr>
    <tr><td colspan="2">
    <h2><?php echo esc_html__("AI Image Chatbot Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
    <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the image size for the AI image chatbot.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Image Chatbot Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select autocomplete="off" id="sizeid" name="aiomatic_Chatbot_Settings[image_chat_size]" class="cr_width_full">
        <option value="256x256" <?php if($image_chat_size == '256x256'){echo ' selected';}?> ><?php echo esc_html__("256x256", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="512x512" <?php if($image_chat_size == '512x512'){echo ' selected';}?> ><?php echo esc_html__("512x512", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="1024x1024" <?php if($image_chat_size == '1024x1024'){echo ' selected';}?> ><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
    </select>
    </td>
    </tr>
    <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the image model for the AI image chatbot.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select autocomplete="off" id="model" name="aiomatic_Chatbot_Settings[image_chat_model]" class="cr_width_full">
        <option value="dalle2" <?php if($image_chat_model == 'dalle2'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="dalle3" <?php if($image_chat_model == 'dalle3'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="dalle3hd" <?php if($image_chat_model == 'dalle3hd'){echo ' selected';}?> ><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
    </select>
    </td>
    </tr>
</table>
</div>
<div id="tab-4" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("Default API Parameters:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the assistant to be used for chatbot. The model used when creating the AI Assistant will be used to create the content.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Chatbot Assistant Name (Using This Disables Chatbot Personas):", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="assistant_id" name="aiomatic_Chatbot_Settings[assistant_id]" class="cr_width_full" onchange="assistantChanged();">
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
        if ($assistant_id == '') 
        {
        echo " selected";
        }
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            if ($assistant_id == $myassistant->ID) 
            {
            echo " selected";
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
    <tr class="hideAssist">
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable file upload for the chatbot. Note that to use this feature, you will need an AI model which supports file search. Supported file types: .c, .cs, .cpp, .doc, .docx, .html, .java, .json, .md, .pdf, .php, .pptx, .py, .rb, .tex, .txt, .css, .js, .sh, .ts", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable File Uploads In The Chatbot (Using AI Assistants File Search):", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select autocomplete="off" id="enable_file_uploads" name="aiomatic_Chatbot_Settings[enable_file_uploads]" <?php 
    if ($assistant_id != '')
    {
        $assistant_model = get_post_meta($assistant_id, '_assistant_model', true);
        if(!empty($assistant_model))
        {
            if(!aiomatic_is_retrieval_model($assistant_model, ''))
            {
                echo 'disabled title="Disabled when using AI Assistants which use models which don\'t support AI Retrieval"';
            }
        }
        else
        {
            echo 'disabled title="No AI model added to this assistant"';
        }
    }
?>class="cr_width_full">
        <option value="on" <?php if($enable_file_uploads == 'on'){echo ' selected';}?> ><?php echo esc_html__("On", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="off" <?php if($enable_file_uploads == 'off'){echo ' selected';}?> ><?php echo esc_html__("Off", 'aiomatic-automatic-ai-content-writer');?></option>
    </select>
    </td>
    </tr>
<tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select the model to be used for chatbot.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Chatbot Model:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="chat_model" name="aiomatic_Chatbot_Settings[chat_model]" class="cr_width_full" <?php if ($assistant_id != ''){echo 'disabled title="Disabled when using AI Assistants"';}?> onchange="aiomatic_check_vision();">
    <?php
foreach($all_models as $modelx)
{
echo '<option value="' . $modelx .'"';
if ($chat_model == $modelx) 
{
echo " selected";
}
echo '>' . esc_html($modelx);
if(aiomatic_is_vision_model($modelx, ''))
{
    echo esc_html__(" (Vision)", 'aiomatic-automatic-ai-content-writer');
}
echo esc_html(aiomatic_get_model_provider($modelx));
echo '</option>';
}
?>
    </select>  
    </td>
    </tr>
    <tr class="hideVision">
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable vision for the chatbot. Note that to use this feature, you will need an AI model which supports vision.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable Chatbot Vision:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select autocomplete="off" id="enable_vision" name="aiomatic_Chatbot_Settings[enable_vision]" <?php 
    if ($assistant_id != '')
    {
        $assistant_model = get_post_meta($assistant_id, '_assistant_model', true);
        if(!empty($assistant_model))
        {
            if(!aiomatic_is_vision_model($assistant_model, ''))
            {
                echo 'disabled title="Disabled when using AI Assistants which use models which don\'t support AI Vision"';
            }
        }
        else
        {
            echo 'disabled title="No AI model added to this assistant"';
        }
    }
?>class="cr_width_full">
        <option value="on" <?php if($enable_vision == 'on'){echo ' selected';}?> ><?php echo esc_html__("On", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="off" <?php if($enable_vision == 'off'){echo ' selected';}?> ><?php echo esc_html__("Off", 'aiomatic-automatic-ai-content-writer');?></option>
    </select>
    </td>
    </tr>
    <tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="0" step="0.1" id="temperature" max="2" name="aiomatic_Chatbot_Settings[temperature]" <?php if ($assistant_id != ''){echo 'disabled title="Disabled when using AI Assistants"';}?>class="cr_width_full" value="<?php echo esc_html($temperature);?>" placeholder="1">
        </td></tr><tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="0" step="0.1" max="1" id="top_p" name="aiomatic_Chatbot_Settings[top_p]" <?php if ($assistant_id != ''){echo 'disabled title="Disabled when using AI Assistants"';}?>class="cr_width_full" value="<?php echo esc_html($top_p);?>" placeholder="1">
        </td></tr><tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="-2" step="0.1" max="2" id="presence_penalty" <?php if ($assistant_id != ''){echo 'disabled title="Disabled when using AI Assistants"';}?>name="aiomatic_Chatbot_Settings[presence_penalty]" class="cr_width_full" value="<?php echo esc_html($presence_penalty);?>" placeholder="0">
        </td></tr><tr><td>
                    <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                    
                    </td><td>
                    <input type="number" min="-2" step="0.1" max="2" id="frequency_penalty" <?php if ($assistant_id != ''){echo 'disabled title="Disabled when using AI Assistants"';}?>name="aiomatic_Chatbot_Settings[frequency_penalty]" class="cr_width_full" value="<?php echo esc_html($frequency_penalty);?>" placeholder="0">
        </td></tr>
</table>
</div>
<div id="tab-5" class="tab-content">
<table class="widefat">
    <tr><td colspan="2">
    <h2><?php echo esc_html__("Global Chatbots Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to inject the chatbot globally, to the entire front end and/or back end of your site.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Inject Chatbot Globally To Your Site:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="enable_front_end" onchange="aiomatic_global_changed();" name="aiomatic_Chatbot_Settings[enable_front_end]" >
<?php
echo '<option' . ($enable_front_end == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($enable_front_end == 'front' ? ' selected': '') . ' value="front">Front End</option>';
echo '<option' . ($enable_front_end == 'back' ? ' selected': '') . ' value="back">Back End</option>';
echo '<option' . ($enable_front_end == 'both' ? ' selected': '') . ' value="both">Front End & Back End</option>';
?>
</select>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select where you want to show the embedded chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Location:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<select id="window_location" name="aiomatic_Chatbot_Settings[window_location]" >
<?php
echo '<option' . ($window_location == 'bottom-right' ? ' selected': '') . ' value="bottom-right">Bottom Right</option>';
echo '<option' . ($window_location == 'bottom-left' ? ' selected': '') . ' value="bottom-left">Bottom Left</option>';
echo '<option' . ($window_location == 'top-right' ? ' selected': '') . ' value="top-right">Top Right</option>';
echo '<option' . ($window_location == 'top-left' ? ' selected': '') . ' value="top-left">Top Left</option>';
?>
</select>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to automatically open the globally injected chatbot at page load.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Auto Open Chatbot On Page Load:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                <input type="checkbox" id="page_load_chat" name="aiomatic_Chatbot_Settings[page_load_chat]"<?php
    if ($page_load_chat == 'on')
        echo ' checked ';
?>>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the width of the chatbot form embedded. Default is 460px", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Width:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<input type="text" id="window_width" name="aiomatic_Chatbot_Settings[window_width]" class="cr_width_full" value="<?php echo esc_html($window_width);?>" placeholder="400px">
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a icon which will open the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Chatbot Open Icon:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="0"<?php
    if ($chatbot_icon == '0')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/0.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="1"<?php
    if ($chatbot_icon == '1')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/1.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="2"<?php
    if ($chatbot_icon == '2')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/2.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="3"<?php
    if ($chatbot_icon == '3')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/3.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="4"<?php
    if ($chatbot_icon == '4')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/4.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="5"<?php
    if ($chatbot_icon == '5')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/5.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="6"<?php
    if ($chatbot_icon == '6')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/6.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="7"<?php
    if ($chatbot_icon == '7')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/7.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="8"<?php
    if ($chatbot_icon == '8')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/8.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="9"<?php
    if ($chatbot_icon == '9')
        echo ' checked ';
?>><img src="<?php echo plugins_url('icons/9.png', __FILE__);?>" width="32" height="32"><br>
    <input type="radio" name="aiomatic_Chatbot_Settings[chatbot_icon]" value="x"<?php
    if ($chatbot_icon == 'x')
        echo ' checked ';
?>><?php echo esc_html__("Your Own HTML Or Image URL:", 'aiomatic-automatic-ai-content-writer');?><input type="text" value="<?php echo esc_html($chatbot_icon_html);?>" placeholder="Your HTML content" name="aiomatic_Chatbot_Settings[chatbot_icon_html]" />
        </div>
        </td></tr>
        <tr class="hideInject"><td colspan="2">
    <h2><?php echo esc_html__("Default Global Chatbot Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a custom chatbot shortcode to be used when displaying the globally injected shortcode. To inject the default chatbot, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Custom Chatbot Shortcode To Be Injected Globally:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
<textarea rows="2" name="aiomatic_Chatbot_Settings[custom_global_shortcode]" placeholder="<?php echo esc_html__("Add a custom chatbot shortcode to be injected globally to your site (optional)", 'aiomatic-automatic-ai-content-writer');?>"><?php
    echo esc_textarea($custom_global_shortcode);
?></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td colspan="2">
    <h2><?php echo esc_html__("Default Global Chatbot Restrictions:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a list of URL where to not show the chatbot. You can enter multiple URLs, each on a new line.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot On These URLs:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                        <textarea rows="2" name="aiomatic_Chatbot_Settings[not_show_urls]" placeholder="URL list, each on a new line"><?php
    echo esc_textarea($not_show_urls);
?></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a list of URL only where to show the chatbot. You can enter multiple URLs, each on a new line. If you enter a list of URLs, the chatbot will be shown only on these URls and not on any other URLs from your site.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only On These URLs:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                        <textarea rows="2" name="aiomatic_Chatbot_Settings[only_show_urls]" placeholder="URL list, each on a new line"><?php
    echo esc_textarea($only_show_urls);
?></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the hour period of each day, when you want to show the chatbot embedded on your site. Your current server time is: ", 'aiomatic-automatic-ai-content-writer') . date("h:i A");
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Between Specific Hours Each Day:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="time" id="min_time" name="aiomatic_Chatbot_Settings[min_time]" value="<?php
    echo esc_attr($min_time);
?>" placeholder="Show the Chatbot Only After This Hour"> - <input type="time" id="max_time" name="aiomatic_Chatbot_Settings[max_time]" value="<?php
echo esc_attr($max_time);
?>" placeholder="Show the Chatbot Only Before This Hour">
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the days of the week, when you want to always show the chatbot (regardless of the above hour limitations).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Days When To Always Show The Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="always_show" multiple name="aiomatic_Chatbot_Settings[always_show][]" class="cr_width_full">
<?php
echo '<option' . (in_array('Monday', $always_show) ? ' selected': '') . ' value="Monday">Monday</option>';
echo '<option' . (in_array('Tuesday', $always_show) ? ' selected': '') . ' value="Tuesday">Tuesday</option>';
echo '<option' . (in_array('Wednesday', $always_show) ? ' selected': '') . ' value="Wednesday">Wednesday</option>';
echo '<option' . (in_array('Thursday', $always_show) ? ' selected': '') . ' value="Thursday">Thursday</option>';
echo '<option' . (in_array('Friday', $always_show) ? ' selected': '') . ' value="Friday">Friday</option>';
echo '<option' . (in_array('Saturday', $always_show) ? ' selected': '') . ' value="Saturday">Saturday</option>';
echo '<option' . (in_array('Sunday', $always_show) ? ' selected': '') . ' value="Sunday">Sunday</option>';
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the days of the week, when you want to never show the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Days When To Never Show The Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="never_show" multiple name="aiomatic_Chatbot_Settings[never_show][]" class="cr_width_full">
<?php
echo '<option' . (in_array('Monday', $never_show) ? ' selected': '') . ' value="Monday">Monday</option>';
echo '<option' . (in_array('Tuesday', $never_show) ? ' selected': '') . ' value="Tuesday">Tuesday</option>';
echo '<option' . (in_array('Wednesday', $never_show) ? ' selected': '') . ' value="Wednesday">Wednesday</option>';
echo '<option' . (in_array('Thursday', $never_show) ? ' selected': '') . ' value="Thursday">Thursday</option>';
echo '<option' . (in_array('Friday', $never_show) ? ' selected': '') . ' value="Friday">Friday</option>';
echo '<option' . (in_array('Saturday', $never_show) ? ' selected': '') . ' value="Saturday">Saturday</option>';
echo '<option' . (in_array('Sunday', $never_show) ? ' selected': '') . ' value="Sunday">Sunday</option>';
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the WordPress content where to not show the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot On This WordPress Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="no_show_content_wp" multiple name="aiomatic_Chatbot_Settings[no_show_content_wp][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $no_show_content_wp ) ? $no_show_content_wp : [ '*' ];
echo aiomatic_get_wordpress_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the WordPress content only where to show the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only On This WordPress Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_content_wp" multiple name="aiomatic_Chatbot_Settings[show_content_wp][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $show_content_wp ) ? $show_content_wp : [ '*' ];
echo aiomatic_get_wordpress_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the languages for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Languages:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="no_show_locales" multiple name="aiomatic_Chatbot_Settings[no_show_locales][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $no_show_locales ) ? $no_show_locales : [ '' ];
echo aiomatic_get_locales_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the languages for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Languages:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_locales" multiple name="aiomatic_Chatbot_Settings[show_locales][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $show_locales ) ? $show_locales : [ '' ];
echo aiomatic_get_locales_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the user roles for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These User Roles:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="no_show_roles" multiple name="aiomatic_Chatbot_Settings[no_show_roles][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $no_show_roles ) ? $no_show_roles : [ '' ];
echo aiomatic_get_user_roles_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the user roles for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These User Roles:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_roles" multiple name="aiomatic_Chatbot_Settings[show_roles][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $show_roles ) ? $show_roles : [ '' ];
echo aiomatic_get_user_roles_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the devices for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Devices:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="no_show_devices" multiple name="aiomatic_Chatbot_Settings[no_show_devices][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $no_show_devices ) ? $no_show_devices : [ '' ];
echo aiomatic_get_devices_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the devices for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Devices:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_devices" multiple name="aiomatic_Chatbot_Settings[show_devices][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $show_devices ) ? $show_devices : [ '' ];
echo aiomatic_get_devices_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Operating Systems for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Operating Systems:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="no_show_oses" multiple name="aiomatic_Chatbot_Settings[no_show_oses][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $no_show_oses ) ? $no_show_oses : [ '' ];
echo aiomatic_get_oses_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Operating Systems for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Operating Systems:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_oses" multiple name="aiomatic_Chatbot_Settings[show_oses][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $show_oses ) ? $show_oses : [ '' ];
echo aiomatic_get_oses_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Browsers for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Browsers:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="no_show_browsers" multiple name="aiomatic_Chatbot_Settings[no_show_browsers][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $no_show_browsers ) ? $no_show_browsers : [ '' ];
echo aiomatic_get_browsers_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Browsers for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Browsers:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select id="show_browsers" multiple name="aiomatic_Chatbot_Settings[show_browsers][]" class="resize_vertical cr_width_full">
<?php
$selected = is_array( $show_browsers ) ? $show_browsers : [ '' ];
echo aiomatic_get_browsers_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the IP Addresses for which the chatbot will not be shown. List of IP addresses or IP ranges. Examples: 46.33.233.31, 46.0-46.1", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These IP Addresses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div><textarea rows="2" name="aiomatic_Chatbot_Settings[no_show_ips]" placeholder="<?php echo esc_html__("IP Addresses / Ranges", 'aiomatic-automatic-ai-content-writer');?>"><?php
    echo esc_textarea($no_show_ips);
?></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the IP Addresses for only which the chatbot will be shown. List of IP addresses or IP ranges. Examples: 46.33.233.31, 46.0-46.1", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These IP Addresses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div><textarea rows="2" name="aiomatic_Chatbot_Settings[show_ips]" placeholder="<?php echo esc_html__("IP Addresses / Ranges", 'aiomatic-automatic-ai-content-writer');?>"><?php
    echo esc_textarea($show_ips);
?></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td colspan="2">
        <h2><?php echo esc_html__("Additional Global Chatbot Rules:", 'aiomatic-automatic-ai-content-writer');?></h2>
        </td></tr>
        <tr class="hideInject"><td colspan="2">
        <table class="widefat">
         <tr class="aiomatic-title-holder">
            <td>
            <input name="aiomatic_chat_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_chat_nonce');?>">
            <input type="hidden" id="aiomatic_chat_json" name="aiomatic_Chatbot_Settings[aiomatic_chat_json]" value="<?php echo esc_attr($aiomatic_chat_json);?>">
               <hr/>
               <div class="table-responsive">
                  <div id="grid-keywords-chatbot-aiomatic">
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
                              <?php echo '[aiomatic-chat-form] ' . esc_html__("Shortcode", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Set the chatbot shortcode which will be used for the global website injection.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <div class="grid-keywords-heading-aiomatic aiomatic-middle">
                              <?php echo esc_html__("Settings", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Set more configurations and restrictions for this chatbot.", 'aiomatic-automatic-ai-content-writer');
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
                        <?php
                           echo aiomatic_expand_chatbot_rules($aiomatic_chat_json);
                           $chuniqid = uniqid();
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
                           <div class="cr_center"><input type="text" id="<?php echo $chuniqid;?>rule_description" onchange="anyNewChatChanged();" placeholder="Rule ID" value="" class="cr_width_full"/></div>
                           <div class="cr_center"><textarea rows="1" data-id="<?php echo $chuniqid;?>" id="<?php echo $chuniqid;?>shortcode" onchange="anyNewChatChanged();" class="chatbotShortcodeImportant cr_width_full" placeholder="<?php echo esc_html__("Please insert the chatbot shortcode to be injected globally", 'aiomatic-automatic-ai-content-writer');?>"></textarea></div>
                           <div class="cr_center">
                              <input type="button" id="mybtnchatfzr" value="Settings" onclick="document.getElementById('mymodalchatfzr').style.display = 'block';">
                              <div id="mymodalchatfzr" class="codemodalfzr">
                                 <div class="codemodalfzr-content">
                                    <div class="codemodalfzr-header">
                                       <span id="aiomatic_chat_close" class="codeclosefzr" onclick="document.getElementById('mymodalchatfzr').style.display = 'none';">&times;</span>
                                       <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'aiomatic-automatic-ai-content-writer');?></span>&nbsp;<?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
                                    </div>
                                    <div class="codemodalfzr-body">
                                       <div class="table-responsive">
                                          <table class="responsive table cr_main_table_nowr">
                                          <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a list of URL where to not show the chatbot. You can enter multiple URLs, each on a new line.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot On These URLs:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                        <textarea rows="2" id="<?php echo $chuniqid;?>not_show_urls" onchange="anyNewChatChanged();" placeholder="URL list, each on a new line"></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set a list of URL only where to show the chatbot. You can enter multiple URLs, each on a new line. If you enter a list of URLs, the chatbot will be shown only on these URls and not on any other URLs from your site.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only On These URLs:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                        <textarea rows="2" id="<?php echo $chuniqid;?>only_show_urls" onchange="anyNewChatChanged();" placeholder="URL list, each on a new line"></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the hour period of each day, when you want to show the chatbot embedded on your site. Your current server time is: ", 'aiomatic-automatic-ai-content-writer') . date("h:i A");
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Between Specific Hours Each Day:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <input type="time" id="<?php echo $chuniqid;?>min_time" onchange="anyNewChatChanged();" value="" placeholder="Show the Chatbot Only After This Hour"> - 
                    <input type="time" id="<?php echo $chuniqid;?>max_time" onchange="anyNewChatChanged();" value="" placeholder="Show the Chatbot Only Before This Hour">
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the days of the week, when you want to always show the chatbot (regardless of the above hour limitations).", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Days When To Always Show The Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="<?php echo $chuniqid;?>always_show" onchange="anyNewChatChanged();" class="cr_width_full">
<?php
echo '<option value="Monday">Monday</option>';
echo '<option value="Tuesday">Tuesday</option>';
echo '<option value="Wednesday">Wednesday</option>';
echo '<option value="Thursday">Thursday</option>';
echo '<option value="Friday">Friday</option>';
echo '<option value="Saturday">Saturday</option>';
echo '<option value="Sunday">Sunday</option>';
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the days of the week, when you want to never show the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Days When To Never Show The Chatbot:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>never_show" class="cr_width_full">
<?php
echo '<option value="Monday">Monday</option>';
echo '<option value="Tuesday">Tuesday</option>';
echo '<option value="Wednesday">Wednesday</option>';
echo '<option value="Thursday">Thursday</option>';
echo '<option value="Friday">Friday</option>';
echo '<option value="Saturday">Saturday</option>';
echo '<option value="Sunday">Sunday</option>';
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the WordPress content where to not show the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot On This WordPress Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>no_show_content_wp" class="resize_vertical cr_width_full">
<?php
$selected = [];
echo aiomatic_get_wordpress_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the WordPress content only where to show the chatbot.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only On This WordPress Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>show_content_wp" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_wordpress_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the languages for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Languages:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>no_show_locales" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_locales_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the languages for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Languages:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>show_locales" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_locales_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the user roles for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These User Roles:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>no_show_roles" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_user_roles_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the user roles for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These User Roles:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>show_roles" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_user_roles_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the devices for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Devices:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>no_show_devices" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_devices_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the devices for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Devices:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>show_devices" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_devices_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Operating Systems for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Operating Systems:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>no_show_oses" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_oses_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Operating Systems for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Operating Systems:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>show_oses" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_oses_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Browsers for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These Browsers:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>no_show_browsers" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_browsers_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the Browsers for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These Browsers:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple onchange="anyNewChatChanged();" id="<?php echo $chuniqid;?>show_browsers" class="resize_vertical cr_width_full">
<?php
echo aiomatic_get_browsers_content($selected);
?>
    </select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the IP Addresses for which the chatbot will not be shown. List of IP addresses or IP ranges. Examples: 46.33.233.31, 46.0-46.1", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Do Not Show The Chatbot For These IP Addresses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div><textarea rows="2" id="<?php echo $chuniqid;?>no_show_ips" onchange="anyNewChatChanged();" placeholder="<?php echo esc_html__("IP Addresses / Ranges", 'aiomatic-automatic-ai-content-writer');?>"></textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the IP Addresses for only which the chatbot will be shown. List of IP addresses or IP ranges. Examples: 46.33.233.31, 46.0-46.1", 'aiomatic-automatic-ai-content-writer');
?>
                        </div>
                    </div>
                    <b><?php echo esc_html__("Show The Chatbot Only For These IP Addresses:", 'aiomatic-automatic-ai-content-writer');?></b>
                    </div>
                    </td><td>
                    <div><textarea rows="2" id="<?php echo $chuniqid;?>show_ips" onchange="anyNewChatChanged();" placeholder="<?php echo esc_html__("IP Addresses / Ranges", 'aiomatic-automatic-ai-content-writer');?>"></textarea>
        </div>
        </td></tr>
                                            </table>
                                        </div>
                                    </div>
                                <div class="codemodalfzr-footer">
                                       <br/>
                                       <h3 class="cr_inline"><?php echo esc_html__("Aiomatic Global Chatbots", 'aiomatic-automatic-ai-content-writer');?></h3>
                                       <span id="aiomatic_chat_ok" class="codeokfzr cr_inline" onclick="document.getElementById('mymodalchatfzr').style.display = 'none';">OK&nbsp;</span>
                                       <br/><br/>
                                    </div>
                                 </div>
                                </div>
                            </div>
                            <div class="cr_center"><span class="cr_gray20">X</span></div>
                        </div>
                  </div>
                  <hr/>
                        <p class="crsubmit"><input type="submit" name="btnSubmitkw" id="btnSubmitkw" class="button button-primary" onclick="unsaved = false;localStorage.setItem('scrollpos', window.scrollY);" value="<?php echo esc_html__("Save Additional Chatbot Injection Rules", 'aiomatic-automatic-ai-content-writer');?>"/></p>
            </td></tr></table>
        </td></tr>
        <tr><td colspan="2">
    <h2><?php echo esc_html__("Tutorial Videos:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/iE9LUaHDFNE" frameborder="0" allowfullscreen></iframe></div></p>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/qoRX4SIGXjA" frameborder="0" allowfullscreen></iframe></div></p>
        </td></tr>
</table>
</div>

<div id="tab-6" class="tab-content">
<br/>
<table class="widefat">
<tr>
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable the persistent chat mode. Chats will be saved in the database and can be viewed from the 'Limits and Statistics' menu of the plugin. If you want to enable the Vector Database persistent chat functionality, you need to add your API key for a Vector Database Service in the plugin's 'Settings' menu. Also, you need to enable embeddings for the chatbot, from the 'Settings' menu -> 'Embeddings' tab -> 'Enable Embeddings For' -> check the 'Chatbot Shortcodes' checkbox -> save settings.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Persistent Chat:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="persistent" name="aiomatic_Chatbot_Settings[persistent]" class="cr_width_full" onchange="aiomatic_persistent_changed();">
    <?php
echo '<option' . ($persistent == 'off' ? ' selected': '') . ' value="off">' . esc_html__("Off", 'aiomatic-automatic-ai-content-writer') . '</option>';
echo '<option' . ($persistent == 'on' ? ' selected': '') . ' value="on">' . esc_html__("On (Local Storage)", 'aiomatic-automatic-ai-content-writer') . '</option>';
echo '<option' . ($persistent == 'logs' ? ' selected': '') . ' value="logs">' . esc_html__("On (Local Storage), Only Save Chat Logs", 'aiomatic-automatic-ai-content-writer') . '</option>';
echo '<option' . ($persistent == 'vector' ? ' selected': '') . ' value="vector"';
if($pinecone_app_id == '' && $qdrant_app_id == '')
{
    echo ' disabled title="You need to set up a Pinecone or a Qdrant API keys in plugin settings for this to work"';
}
echo '>' . esc_html__("On (Vector Database Storage), Auto Create Embeddings From User Messages", 'aiomatic-automatic-ai-content-writer') . '</option>';
?>
    </select>  
    </td>
    </tr>
<tr class="hidePersistent">
    <td>
        <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                <div class="bws_hidden_help_text cr_min_260px">
                <?php
                    echo esc_html__("Select if you want to enable the persistent chat mode also for not logged in users.", 'aiomatic-automatic-ai-content-writer');
                    ?>
                </div>
            </div>
            <b><?php echo esc_html__("Enable Persistent Chat Also For Not Logged In Users:", 'aiomatic-automatic-ai-content-writer');?></b>   
    </td>
    <td class="cr_min_width_200">
    <select id="persistent_guests" name="aiomatic_Chatbot_Settings[persistent_guests]" class="cr_width_full">
    <?php
echo '<option' . ($persistent_guests == 'off' ? ' selected': '') . ' value="off">Off</option>';
echo '<option' . ($persistent_guests == 'on' ? ' selected': '') . ' value="on">On</option>';
?>
    </select>  
    </td>
    </tr>
</table>
    <br/>
<?php
$current_page = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if ( isset( $_GET['action'] ) && isset( $_GET['user_id'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'user_meta_manager_' . $_GET['action'] . '_' . $_GET['user_id'] ) ) 
{
    $user_id = urldecode($_GET['user_id']);
    $action = urldecode( $_GET['action'] );
    if(isset($_GET['conv_id']))
    {
        $conv_id = urldecode($_GET['conv_id']);
    }
    else
    {
        $conv_id = '';
    }
    if ( $action == 'delete_meta' ) 
    {
        if(is_numeric($user_id) && $user_id > 0)
        {
            if($assistant_id != '')
            {
                delete_user_meta( $user_id, 'aiomatic_assistant_history_thread' );
            }
            else
            {
                delete_user_meta( $user_id, 'aiomatic_chat_history' . $conv_id );
            }
        }
        else
        {
            if($assistant_id != '')
            {
                delete_transient('aiomatic_assistant_history_thread_' . $user_id);
            }
            else
            {
                delete_transient('aiomatic_chat_history_' . $conv_id . '_' . $user_id);
            }
        }
        $xcurrent_page = preg_replace('#&user_id=([^&]*)#', '', $current_page);
        echo "<script>location.href='" . $xcurrent_page . "';</script>";
    }
    elseif ( $action == 'delete_all_meta' ) 
    {
        $paged = 1;
        $users_per_page = 20;
        $users = array();
        do
        {
            $users_query = new WP_User_Query(
                array(
                    'meta_query' => array(
                    array(
                        'key'     => 'aiomatic_chat_history',
                        'compare_key' => 'LIKE'
                    )
                    ),
                    'number' => $users_per_page,
                    'paged' => $paged,
                )
            );
            $paged++;
            $rezuser = $users_query->get_results();
            $users = array_merge($rezuser, $users);
        }
        while(!empty($rezuser));
        $transi_count = 0;
        if($assistant_id != '')
        {
            $all_transients = aiomatic_get_transients_by_regex('aiomatic_assistant_history_thread_.+', PHP_INT_MAX, $transi_count);
        }
        else
        {
            $all_transients = aiomatic_get_transients_by_regex('aiomatic_chat_history_.+', PHP_INT_MAX, $transi_count);
        }
        foreach ( $users as $user ) 
        {
            $user_id = $user->ID;
            $all_meta = get_user_meta($user_id, '', true);
            $my_meta = array_filter($all_meta, function($key){
                return strpos($key, 'aiomatic_chat_history') === 0;
            }, ARRAY_FILTER_USE_KEY);
            foreach($my_meta as $key => $zmeta)
            {
                $pref = explode('aiomatic_chat_history', $key);
                if(isset($pref[1]))
                {
                    delete_user_meta($user_id, $key);
                }
            }
        }
        foreach ( $all_transients as $transient_name => $transient_value ) 
        {
            if($assistant_id != '')
            {
                preg_match_all('#aiomatic_assistant_history_thread_([\s\S]+)#i', $transient_name, $trmatches);
                if(isset($trmatches[2][0]))
                {
                    $user_id = $trmatches[2][0];
                    $conv_id = $trmatches[1][0];
                    delete_transient('aiomatic_assistant_history_thread_' . $user_id);
                }
            }
            else
            {
                preg_match_all('#aiomatic_chat_history_([^_]+)_([\s\S]+)#i', $transient_name, $trmatches);
                if(isset($trmatches[2][0]))
                {
                    $user_id = $trmatches[2][0];
                    $conv_id = $trmatches[1][0];
                    delete_transient('aiomatic_chat_history_' . $conv_id . '_' . $user_id);
                }
            }
        }
        $zcurrent_page = preg_replace('#&action=delete_all_meta#', '', $current_page);
        $zcurrent_page = preg_replace('#&conv_id=([^&]*?)&#', '&', $zcurrent_page);
        echo '<a href="' . $zcurrent_page . '" class="button">' . esc_html__('Back to List', 'aiomatic-automatic-ai-content-writer') . '</a>';
    }
}

$paged = 1;
if ( isset( $_GET['paged'] ) ) {
    $paged = intval( $_GET['paged'] );
}
$users_per_page = 20;
if ( isset( $_GET['users_per_page'] ) ) {
    $users_per_page = intval( $_GET['users_per_page'] );
    if($users_per_page <= 0)
    {
        $users_per_page = 20;
    }
}
if($assistant_id != '')
{
    $users_query = new WP_User_Query(
    array(
        'meta_query' => array(
        array(
            'key'     => 'aiomatic_assistant_history_thread',
            'compare_key' => 'LIKE'
        )
        ),
        'number' => $users_per_page,
        'paged' => $paged,
    )
    );
}
else
{
    $users_query = new WP_User_Query(
        array(
            'meta_query' => array(
            array(
                'key'     => 'aiomatic_chat_history',
                'compare_key' => 'LIKE'
            )
            ),
            'number' => $users_per_page,
            'paged' => $paged,
        )
        );
}
$transi_count = 0;
if($assistant_id != '')
{
    $all_transients = aiomatic_get_transients_by_regex('aiomatic_assistant_history_thread_.+', PHP_INT_MAX, $transi_count);
}
else
{
    $all_transients = aiomatic_get_transients_by_regex('aiomatic_chat_history_.+', PHP_INT_MAX, $transi_count);
}
$total_users = $users_query->get_total();
$total_items = $total_users + $transi_count;
$total_pages = ceil( ($total_users + $transi_count) / $users_per_page );
$users = $users_query->get_results();
echo '<div class="wrap">';
echo '<h1>' . esc_html__('User Conversation Manager', 'aiomatic-automatic-ai-content-writer') . '</h1>';
echo '<table class="wp-list-table widefat fixed striped users">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col" id="username" class="manage-column column-username column-primary">Username/IP</th>';
echo '<th scope="col" id="username" class="manage-column column-username column-primary">Chat ID</th>';
echo '<th scope="col" id="email" class="manage-column column-email">Email</th>';
echo '<th scope="col" id="actions" class="manage-column column-actions">Actions</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody id="the-list">';
if(count($users) == 0 && count($all_transients) == 0)
{
    echo '</tbody></table><br/><br/>' . esc_html__('No persistent chat messages found. You can enable this feature if you use the following shortcode to add a persistent AI chat to your page: [aiomatic-chat-form persistent="on"]', 'aiomatic-automatic-ai-content-writer') . '</div>';
}
else
{
    $displayed = 0;
    $users = aiomatic_array_unique($users);
    foreach ( $users as $user ) {
        $displayed++;
        $user_id = $user->ID;
        $username = $user->user_login;
        $email = $user->user_email;
        if($assistant_id != '')
        {
            $zmeta = get_user_meta($user_id, 'aiomatic_assistant_history_thread', true);
            if(!empty($zmeta))
            {
                echo '<tr>';
                echo '<td class="username column-username has-row-actions column-primary" data-colname="Username">' . esc_html( $username ) . '</td>';
                echo '<td class="chatid column-chatid" data-colname="ChatID">' . $zmeta . '</td>';
                echo '<td class="email column-email" data-colname="Email">' . esc_html( $email ) . '</td>';
                echo '<td class="actions column-actions" data-colname="Actions">';
                echo '<a href="' . add_query_arg( array( 'action' => 'view_meta', 'user_id' => $user_id, 'conv_id' => $zmeta, '_wpnonce' => wp_create_nonce( 'user_meta_manager_view_meta_' . $user_id ) ), $current_page ) . '">View</a> | ';
                echo '<a href="' . add_query_arg( array( 'action' => 'download_meta', 'user_id' => $user_id, 'conv_id' => $zmeta, '_wpnonce' => wp_create_nonce( 'user_meta_manager_download_meta_' . $user_id ) ), $current_page ) . '">Download</a> | ';
                echo '<a href="' . add_query_arg( array( 'action' => 'delete_meta', 'user_id' => $user_id, 'conv_id' => $zmeta, '_wpnonce' => wp_create_nonce( 'user_meta_manager_delete_meta_' . $user_id ) ), $current_page ) . '">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
        }
        else
        {
            $all_meta = get_user_meta($user_id, '', true);
            $my_meta = array_filter($all_meta, function($key){
                return strpos($key, 'aiomatic_chat_history') === 0;
            }, ARRAY_FILTER_USE_KEY);
            foreach($my_meta as $key => $zmeta)
            {
                $pref = explode('aiomatic_chat_history', $key);
                if(isset($pref[1]))
                {
                    echo '<tr>';
                    echo '<td class="username column-username has-row-actions column-primary" data-colname="Username">' . esc_html( $username ) . '</td>';
                    echo '<td class="chatid column-chatid" data-colname="ChatID">' . $pref[1] . '</td>';
                    echo '<td class="email column-email" data-colname="Email">' . esc_html( $email ) . '</td>';
                    echo '<td class="actions column-actions" data-colname="Actions">';
                    echo '<a href="' . add_query_arg( array( 'action' => 'view_meta', 'user_id' => $user_id, 'conv_id' => $pref[1], '_wpnonce' => wp_create_nonce( 'user_meta_manager_view_meta_' . $user_id ) ), $current_page ) . '">View</a> | ';
                    echo '<a href="' . add_query_arg( array( 'action' => 'download_meta', 'user_id' => $user_id, 'conv_id' => $pref[1], '_wpnonce' => wp_create_nonce( 'user_meta_manager_download_meta_' . $user_id ) ), $current_page ) . '">Download</a> | ';
                    echo '<a href="' . add_query_arg( array( 'action' => 'delete_meta', 'user_id' => $user_id, 'conv_id' => $pref[1], '_wpnonce' => wp_create_nonce( 'user_meta_manager_delete_meta_' . $user_id ) ), $current_page ) . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
    if($displayed < $users_per_page)
    {
        $skip_cnt = 0;
        if(count($users) == 0)
        {
            $skip_cnt = $users_per_page * ($paged - 1);
            $skip_cnt = $skip_cnt - $total_users;
        }
        $skipped = 0;
        foreach ( $all_transients as $transient_name => $transient_value ) 
        {
            if($skip_cnt > 0)
            {
                if($skipped < $skip_cnt)
                {
                    $skipped++;
                    continue;
                }
            }
            if($assistant_id != '')
            {
                preg_match_all('#aiomatic_assistant_history_thread_([\s\S]+)#i', $transient_name, $trmatches);
                if(isset($trmatches[1][0]))
                {
                    $displayed++;
                    $user_id = $trmatches[1][0];
                    $username = $trmatches[1][0];
                    $email = '-';
                    echo '<tr>';
                    echo '<td class="username column-username has-row-actions column-primary" data-colname="Username">' . $username . '</td>';
                    echo '<td class="chatid column-chatid" data-colname="ChatID">' . $transient_value . '</td>';
                    echo '<td class="email column-email" data-colname="Email">' . esc_html( $email ) . '</td>';
                    echo '<td class="actions column-actions" data-colname="Actions">';
                    echo '<a href="' . add_query_arg( array( 'action' => 'view_meta', 'user_id' => urlencode($user_id), 'conv_id' => urlencode($transient_value), '_wpnonce' => wp_create_nonce( 'user_meta_manager_view_meta_' . $user_id ) ), $current_page ) . '">View</a> | ';
                    echo '<a href="' . add_query_arg( array( 'action' => 'download_meta', 'user_id' => urlencode($user_id), 'conv_id' => urlencode($transient_value), '_wpnonce' => wp_create_nonce( 'user_meta_manager_download_meta_' . $user_id ) ), $current_page ) . '">Download</a> | ';
                    echo '<a href="' . add_query_arg( array( 'action' => 'delete_meta', 'user_id' => urlencode($user_id), 'conv_id' => urlencode($transient_value), '_wpnonce' => wp_create_nonce( 'user_meta_manager_delete_meta_' . $user_id ) ), $current_page ) . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                    if($displayed >= $users_per_page)
                    {
                        break;
                    }
                }
            }
            else
            {
                preg_match_all('#aiomatic_chat_history_([^_]+)_([\s\S]+)#i', $transient_name, $trmatches);
                if(isset($trmatches[2][0]))
                {
                    $displayed++;
                    $user_id = $trmatches[2][0];
                    $username = $trmatches[2][0];
                    $chatid = $trmatches[1][0];
                    $email = '-';
                    echo '<tr>';
                    echo '<td class="username column-username has-row-actions column-primary" data-colname="Username">' . $username . '</td>';
                    echo '<td class="chatid column-chatid" data-colname="ChatID">' . esc_html($chatid) . '</td>';
                    echo '<td class="email column-email" data-colname="Email">' . esc_html( $email ) . '</td>';
                    echo '<td class="actions column-actions" data-colname="Actions">';
                    echo '<a href="' . add_query_arg( array( 'action' => 'view_meta', 'user_id' => urlencode($user_id), 'conv_id' => urlencode($chatid), '_wpnonce' => wp_create_nonce( 'user_meta_manager_view_meta_' . $user_id ) ), $current_page ) . '">View</a> | ';
                    echo '<a href="' . add_query_arg( array( 'action' => 'download_meta', 'user_id' => urlencode($user_id), 'conv_id' => urlencode($chatid), '_wpnonce' => wp_create_nonce( 'user_meta_manager_download_meta_' . $user_id ) ), $current_page ) . '">Download</a> | ';
                    echo '<a href="' . add_query_arg( array( 'action' => 'delete_meta', 'user_id' => urlencode($user_id), 'conv_id' => urlencode($chatid), '_wpnonce' => wp_create_nonce( 'user_meta_manager_delete_meta_' . $user_id ) ), $current_page ) . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                    if($displayed >= $users_per_page)
                    {
                        break;
                    }
                }
            }
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '<div class="tablenav bottom">';
    echo '<div class="tablenav-pages">';
    echo '<span class="displaying-num">' . $total_items . ' items (' . $total_users . '/' . $transi_count . ')</span>';
    echo '<span class="pagination-links">';
    if($paged > 1)
    {
        echo '<a href="' . add_query_arg( array( 'paged' => $paged - 1 ), $current_page ) . '">' . esc_html__('Prev', 'aiomatic-automatic-ai-content-writer') . '</a>&nbsp;';
    }
    for ( $i = 1; $i <= $total_pages; $i++ ) 
    {
        $class = ( $i == $paged ) ? ' current' : '';
        echo '<a class="' . $class . '" href="' . add_query_arg( array( 'paged' => $i ), $current_page ) . '">' . $i . '</a>&nbsp;';
    }
    if($paged < $total_pages)
    {
        echo '<a href="' . add_query_arg( array( 'paged' => $paged + 1 ), $current_page ) . '">' . esc_html__('Next', 'aiomatic-automatic-ai-content-writer') . '</a>&nbsp;';
    }
    echo '</span>';
    echo '</div>';
    echo '</div>';
    if($displayed > 0)
    {
        echo '<a href="' . add_query_arg( array( 'action' => 'download_all_meta', 'user_id' => urlencode($user_id), 'conv_id' => 'all', '_wpnonce' => wp_create_nonce( 'user_meta_manager_download_all_meta_' . $user_id ) ), $current_page ) . '" class="button">' . esc_html__('Download All Conversations', 'aiomatic-automatic-ai-content-writer') . '</a>';
        echo '&nbsp;&nbsp;&nbsp;';
        echo '<a href="' . add_query_arg( array( 'action' => 'delete_all_meta', 'user_id' => urlencode($user_id), 'conv_id' => 'all', '_wpnonce' => wp_create_nonce( 'user_meta_manager_delete_all_meta_' . $user_id ) ), $current_page ) . '" class="button">' . esc_html__('Delete All Conversations', 'aiomatic-automatic-ai-content-writer') . '</a>';
    }
    echo '</div>';
    if ( isset( $_GET['action'] ) && isset( $_GET['user_id'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'user_meta_manager_' . $_GET['action'] . '_' . $_GET['user_id'] ) ) 
    {
        $user_id = urldecode( $_GET['user_id'] );
        $action = urldecode( $_GET['action'] );
        $conv_id = urldecode( $_GET['conv_id'] );
        if ( $action == 'delete_meta' ) 
        {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>' . esc_html__('User conversation data has been deleted.', 'aiomatic-automatic-ai-content-writer') . '</p>';
            echo '</div>';
        } 
        elseif ( $action == 'view_meta' ) 
        {
            if(is_numeric($user_id))
            {
                if($assistant_id != '')
                {
                    $thread_id = get_user_meta($user_id, 'aiomatic_assistant_history_thread', true);
                    if(!empty($thread_id))
                    {
                        try
                        {
                            if(!aiomatic_is_aiomaticapi_key($token) && (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure'))
                            {
                                $conv_meta = '';
                                require_once (dirname(__FILE__) . "/aiomatic-assistants-api.php");
                                $old_messages = aiomatic_openai_list_messages($token, $thread_id, 100, 'asc');
                                if(isset($old_messages['data']) && is_array($old_messages['data']))
                                {
                                    foreach($old_messages['data'] as $om)
                                    {
                                        if(isset($om['content'][0]['text']['value']))
                                        {
                                            if($om['role'] == 'user')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-mine">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                            elseif($om['role'] == 'assistant')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-other">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        catch(Exception $e)
                        {
                            $conv_meta = '';
                        }
                    }
                    else
                    {
                        $conv_meta = '';
                    }
                }
                else
                {
                    $conv_meta = get_user_meta($user_id, 'aiomatic_chat_history' . $conv_id, true);
                }
            }
            else
            {
                if($assistant_id != '')
                {
                    $thread_id = get_transient('aiomatic_assistant_history_thread_' . $user_id);
                    if(!empty($thread_id))
                    {
                        try
                        {
                            if(!aiomatic_is_aiomaticapi_key($token) && (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure'))
                            {
                                $conv_meta = '';
                                require_once (dirname(__FILE__) . "/aiomatic-assistants-api.php");
                                $old_messages = aiomatic_openai_list_messages($token, $thread_id, 100, 'asc');
                                if(isset($old_messages['data']) && is_array($old_messages['data']))
                                {
                                    foreach($old_messages['data'] as $om)
                                    {
                                        if(isset($om['content'][0]['text']['value']))
                                        {
                                            if($om['role'] == 'user')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-mine">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                            elseif($om['role'] == 'assistant')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-other">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        catch(Exception $e)
                        {
                            $conv_meta = '';
                        }
                    }
                    else
                    {
                        $conv_meta = '';
                    }
                }
                else
                {
                    $conv_meta = get_transient('aiomatic_chat_history_' . $conv_id . '_' . $user_id);
                }
            }
            if($conv_meta === false)
            {
                $conv_meta = '';
            }
            echo '<div class="wrap">';
            echo '<h1>' . esc_html__('View User Conversation', 'aiomatic-automatic-ai-content-writer') . '</h1>';
            echo '<div id="aiomatic_chat_history_log" class="aiomatic_chat_history_log ai-chat form-control" title="Click on a bubble to copy its content!">
            <table class="form-table">';
            echo '<tbody>';
            echo '<tr>';
            echo '<td>' . $conv_meta . '</td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table></div>';
            $zcurrent_page = preg_replace('#&action=view_meta#', '', $current_page);
            $zcurrent_page = preg_replace('#&conv_id=([^&]*?)&#', '&', $zcurrent_page);
            echo '<a href="' . $zcurrent_page . '" class="button">' . esc_html__('Back to List', 'aiomatic-automatic-ai-content-writer') . '</a>';
            echo '</div>';
        }
        elseif ( $action == 'download_meta' ) 
        {
            if(is_numeric($user_id))
            {
                if($assistant_id != '')
                {
                    $thread_id = get_user_meta($user_id, 'aiomatic_assistant_history_thread', true);
                    if(!empty($thread_id))
                    {
                        try
                        {
                            if(!aiomatic_is_aiomaticapi_key($token) && (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure'))
                            {
                                $conv_meta = '';
                                require_once (dirname(__FILE__) . "/aiomatic-assistants-api.php");
                                $old_messages = aiomatic_openai_list_messages($token, $thread_id, 100, 'asc');
                                if(isset($old_messages['data']) && is_array($old_messages['data']))
                                {
                                    foreach($old_messages['data'] as $om)
                                    {
                                        if(isset($om['content'][0]['text']['value']))
                                        {
                                            if($om['role'] == 'user')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-mine">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                            elseif($om['role'] == 'assistant')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-other">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        catch(Exception $e)
                        {
                            $conv_meta = '';
                        }
                    }
                    else
                    {
                        $conv_meta = '';
                    }
                }
                else
                {
                    $conv_meta = get_user_meta($user_id, 'aiomatic_chat_history' . $conv_id, true);
                }
            }
            else
            {
                if($assistant_id != '')
                {
                    $thread_id = get_transient('aiomatic_assistant_history_thread_' . $user_id);
                    if(!empty($thread_id))
                    {
                        try
                        {
                            if(!aiomatic_is_aiomaticapi_key($token) && (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure'))
                            {
                                $conv_meta = '';
                                require_once (dirname(__FILE__) . "/aiomatic-assistants-api.php");
                                $old_messages = aiomatic_openai_list_messages($token, $thread_id, 100, 'asc');
                                if(isset($old_messages['data']) && is_array($old_messages['data']))
                                {
                                    foreach($old_messages['data'] as $om)
                                    {
                                        if(isset($om['content'][0]['text']['value']))
                                        {
                                            if($om['role'] == 'user')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-mine">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                            elseif($om['role'] == 'assistant')
                                            {
                                                $conv_meta .= '<div class="ai-bubble ai-other">' . $om['content'][0]['text']['value'] . '</div>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        catch(Exception $e)
                        {
                            $conv_meta = '';
                        }
                    }
                    else
                    {
                        $conv_meta = '';
                    }
                }
                else
                {
                    $conv_meta = get_transient('aiomatic_chat_history_' . $conv_id . '_' . $user_id);
                }
            }
            if($conv_meta === false)
            {
                $conv_meta = '';
            }
            $conv_meta = str_replace('<div class="ai-bubble ai-mine">', 'User: ', $conv_meta);
            $conv_meta = str_replace('<div class="ai-bubble ai-other">', 'AI: ', $conv_meta);
            $conv_meta = str_replace('</div>', '\r\n', $conv_meta);
            $conv_meta = str_replace('<br>', '\r\n', $conv_meta);
            echo '<script type="text/javascript">function aiomatic_toBinary(string) {
                const codeUnits = Uint16Array.from(
                { length: string.length },
                (element, index) => string.charCodeAt(index)
                );
                const charCodes = new Uint8Array(codeUnits.buffer);
            
                let result = "";
                charCodes.forEach((char) => {
                result += String.fromCharCode(char);
                });
                return result;
            }try{var blists = aiomatic_toBinary("' . str_replace('"', '\"', $conv_meta) . '");var encodedString = btoa(blists);var hiddenElement = document.createElement(\'a\');hiddenElement.href = \'data:text/attachment;base64,\' + encodedString;hiddenElement.target = \'_blank\';hiddenElement.download = \'chat-log-' . $user_id . '.txt\';hiddenElement.click();}catch(e){alert(e);}</script>';
            $zcurrent_page = preg_replace('#&action=download_meta#', '', $current_page);
            $zcurrent_page = preg_replace('#&conv_id=([^&]*?)&#', '&', $zcurrent_page);
            echo '<a href="' . $zcurrent_page . '" class="button">' . esc_html__('Back to List', 'aiomatic-automatic-ai-content-writer') . '</a>';
        }
        elseif ( $action == 'download_all_meta' ) 
        {
            $paged = 1;
            $users_per_page = 20;
            $users = array();
            do
            {
                $users_query = new WP_User_Query(
                    array(
                        'meta_query' => array(
                        array(
                            'key'     => 'aiomatic_chat_history',
                            'compare_key' => 'LIKE'
                        )
                        ),
                        'number' => $users_per_page,
                        'paged' => $paged,
                    )
                );
                $paged++;
                $rezuser = $users_query->get_results();
                $users = array_merge($rezuser, $users);
            }
            while(!empty($rezuser));
            $transi_count = 0;
            if($assistant_id != '')
            {
                $all_transients = aiomatic_get_transients_by_regex('aiomatic_assistant_history_thread_.+', PHP_INT_MAX, $transi_count);
            }
            else
            {
                $all_transients = aiomatic_get_transients_by_regex('aiomatic_chat_history_.+', PHP_INT_MAX, $transi_count);
            }
            $full_chat_log = '';
            foreach ( $users as $user ) 
            {
                $user_id = $user->ID;
                $all_meta = get_user_meta($user_id, '', true);
                $my_meta = array_filter($all_meta, function($key){
                    return strpos($key, 'aiomatic_chat_history') === 0;
                }, ARRAY_FILTER_USE_KEY);
                foreach($my_meta as $key => $zmeta)
                {
                    $pref = explode('aiomatic_chat_history', $key);
                    if(isset($pref[1]))
                    {
                        $conv_id = $pref[1];
                        $conv_meta = get_user_meta($user_id, 'aiomatic_chat_history' . $conv_id, true);
                        if($conv_meta === false)
                        {
                            $conv_meta = '';
                        }
                        $conv_meta = str_replace('<div class="ai-bubble ai-mine">', 'User: ', $conv_meta);
                        $conv_meta = str_replace('<div class="ai-bubble ai-other">', 'AI: ', $conv_meta);
                        $conv_meta = str_replace('</div>', '\r\n', $conv_meta);
                        $conv_meta = str_replace('<br>', '\r\n', $conv_meta);
                        $full_chat_log .= 'Logged-in User ID: ' . $user_id . '\r\n';
                        $full_chat_log .= 'Conversation ID: ' . $conv_id . '\r\n';
                        $full_chat_log .= '---------------------' . '\r\n';
                        $full_chat_log .= $conv_meta . '\r\n';
                        $full_chat_log .= '---------------------' . '\r\n' . '\r\n';
                    }
                }
            }
            foreach ( $all_transients as $transient_name => $transient_value ) 
            {
                if($assistant_id != '')
                {
                    preg_match_all('#aiomatic_assistant_history_thread_([\s\S]+)#i', $transient_name, $trmatches);
                    if(isset($trmatches[2][0]))
                    {
                        $user_id = $trmatches[2][0];
                        $conv_id = $trmatches[1][0];
                        $conv_meta = get_transient('aiomatic_assistant_history_thread_' . $user_id);
                        if($conv_meta === false)
                        {
                            $conv_meta = '';
                        }
                        $conv_meta = str_replace('<div class="ai-bubble ai-mine">', 'User: ', $conv_meta);
                        $conv_meta = str_replace('<div class="ai-bubble ai-other">', 'AI: ', $conv_meta);
                        $conv_meta = str_replace('</div>', '\r\n', $conv_meta);
                        $conv_meta = str_replace('<br>', '\r\n', $conv_meta);
                        $full_chat_log .= 'Guest ID: ' . $user_id . '\r\n';
                        $full_chat_log .= 'Conversation ID: ' . $conv_id . '\r\n';
                        $full_chat_log .= '---------------------' . '\r\n';
                        $full_chat_log .= $conv_meta . '\r\n';
                        $full_chat_log .= '---------------------' . '\r\n' . '\r\n';
                    }
                }
                else
                {
                    preg_match_all('#aiomatic_chat_history_([^_]+)_([\s\S]+)#i', $transient_name, $trmatches);
                    if(isset($trmatches[2][0]))
                    {
                        $user_id = $trmatches[2][0];
                        $conv_id = $trmatches[1][0];
                        $conv_meta = get_transient('aiomatic_chat_history_' . $conv_id . '_' . $user_id);
                        if($conv_meta === false)
                        {
                            $conv_meta = '';
                        }
                        $conv_meta = str_replace('<div class="ai-bubble ai-mine">', 'User: ', $conv_meta);
                        $conv_meta = str_replace('<div class="ai-bubble ai-other">', 'AI: ', $conv_meta);
                        $conv_meta = str_replace('</div>', '\r\n', $conv_meta);
                        $conv_meta = str_replace('<br>', '\r\n', $conv_meta);
                        $full_chat_log .= 'Guest ID: ' . $user_id . '\r\n';
                        $full_chat_log .= 'Conversation ID: ' . $conv_id . '\r\n';
                        $full_chat_log .= '---------------------' . '\r\n';
                        $full_chat_log .= $conv_meta . '\r\n';
                        $full_chat_log .= '---------------------' . '\r\n' . '\r\n';
                    }
                }
            }
            echo '<script type="text/javascript">function aiomatic_toBinary(string) {
                const codeUnits = Uint16Array.from(
                { length: string.length },
                (element, index) => string.charCodeAt(index)
                );
                const charCodes = new Uint8Array(codeUnits.buffer);
            
                let result = "";
                charCodes.forEach((char) => {
                result += String.fromCharCode(char);
                });
                return result;
            }try{var blists = aiomatic_toBinary("' . str_replace('"', '\"', $full_chat_log) . '");var encodedString = btoa(blists);var hiddenElement = document.createElement(\'a\');hiddenElement.href = \'data:text/attachment;base64,\' + encodedString;hiddenElement.target = \'_blank\';hiddenElement.download = \'full-chat-log.txt\';hiddenElement.click();}catch(e){alert(e);}</script>';
            $zcurrent_page = preg_replace('#&action=download_all_meta#', '', $current_page);
            $zcurrent_page = preg_replace('#&conv_id=([^&]*?)&#', '&', $zcurrent_page);
            echo '<a href="' . $zcurrent_page . '" class="button">' . esc_html__('Back to List', 'aiomatic-automatic-ai-content-writer') . '</a>';
        }
    }
}
?>
<h2><?php echo esc_html__("Tutorial Video:", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/mD_7oaCt2eM" frameborder="0" allowfullscreen></iframe></div></p>
</div>
</div>
    <div><p class="crsubmit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'aiomatic-automatic-ai-content-writer');?>"/></p></div>
    </form>
</div>
<div id="mymodalfzr" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Add New Persona", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <form action="#" method="post" autocomplete="off" id="aiomatic_personas_form">
            <br/>
            <input type="hidden" name="action" value="aiomatic_personas">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('aiomatic_personas');?>">
            <h1><strong><?php echo esc_html__("Add New Persona:", 'aiomatic-automatic-ai-content-writer');?></strong></h1>
            <h4><?php echo esc_html__("Persona Name*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the name of this persona.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <textarea rows="1" id="aiomatic-persona-title" name="aiomatic-persona-title" class="aiomatic-full-size" placeholder="Persona name" required></textarea>
            <br/>
            <h4><?php echo esc_html__("Persona Role", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the role of this persona.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <textarea rows="1" id="aiomatic-persona-description" name="aiomatic-persona-description" class="aiomatic-full-size" placeholder="Persona role"></textarea>
            <br/>
            <h4><?php echo esc_html__("Persona Context Prompt*", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the prompt which will be sent to the AI. Add a context to the AI chatbot, so it knows how to act and how to respond to customers. You can define here the language, tone of voice and role of the AI assistant. Any other settings will also be able to be defined here. This text will be preppended to each conversation, to teach the AI some additional info about you or its behavior. This text will not be displayed to users, it will be only sent to the chatbot. You can also use shortcodes in this field. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-persona-prompt" name="aiomatic-persona-prompt" class="aiomatic-full-size" placeholder="Persona context prompt" required></textarea>
            <br/>
            <h4><?php echo esc_html__("Persona First Message", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the first message of this persona.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-persona-first-message" name="aiomatic-persona-first-message" class="aiomatic-full-size" placeholder="Persona first message"></textarea>
            <br/>
            <h4><?php echo esc_html__("Persona Avatar", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the avatar of the chatbot persona.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image-new"/></div>
            <input type="hidden" name="aiomatic-persona-avatar" id="aiomatic_image_id_new" value="" />
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager_new"/>
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Clear avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_clear_new"/>
      <br/><br/>
<hr/>
      <button id="aiomatic-personas-save-button" class="button button-primary"><?php echo esc_html__("Save", 'aiomatic-automatic-ai-content-writer');?></button>
   <div class="aiomatic-personas-success"></div>
   <br/>
</form>
            </div>
        </div>  
    </div>
</div>

<div id="mymodalfzr_backup" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close_backup" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Backup/Restore Personas", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <br/>
<?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<hr/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Restore Personas From File", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px">
        <?php
        echo esc_html__("Hit this button and you can restore personas from file.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<div class="aiomatic_persona_upload_form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php
        echo esc_html__("Backup File (*.json)", 'aiomatic-automatic-ai-content-writer');
        ?></th>
            <td>
                <input type="file" id="aiomatic_persona_upload" accept=".json">
            </td>
        </tr>
        <tr>
            <th scope="row"><?php
        echo esc_html__("Overwrite Existing", 'aiomatic-automatic-ai-content-writer');
        ?></th>
            <td>
                <input type="checkbox" id="aiomatic_overwrite" value="on">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="aiomatic_upload_success aiomatic_none margin5 colorgr"><?php
        echo esc_html__("File uploaded successfully you can view it in the persona listing tab.", 'aiomatic-automatic-ai-content-writer');
        ?></div>
                <div class="aiomatic_progress aiomatic_none"><span></span><small><?php
        echo esc_html__("Uploading", 'aiomatic-automatic-ai-content-writer');
        ?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_persona_button"><?php echo esc_html__("Import Personas From File", 'aiomatic-automatic-ai-content-writer');?></button><br>
                <p class="cr_center"><?php
        echo esc_html__("Maximum upload file size", 'aiomatic-automatic-ai-content-writer');
        ?>: <?php echo size_format($aiomaticMaxFileSize)?>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</div>
<br/>
<hr/>
<div class="aiomatic-loader-bubble">
    <div>
            <h3>
               <?php echo esc_html__('Backup Current Personas To File:', 'aiomatic-automatic-ai-content-writer');?>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Hit this button and you can backup the current personas to file.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <form method="post" onsubmit="return confirm('Are you sure you want to download personas to file?');"><input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_personas');?>"><input name="aiomatic_download_personas_to_file" type="submit" class="button button-primary coderevolution_block_input" value="Backup Personas To File"></form>
         </div>
</div>
<br/>
<hr/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Import Default Personas (This Can Take For A While)", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px">
        <?php
        echo esc_html__("Hit this button and the plugin will create the default personas which come bundled with the plugin.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<table class="form-table">
        <tbody>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_persona_default_button"><?php echo esc_html__("Import Default Personas", 'aiomatic-automatic-ai-content-writer');?></button><br>
            </td>
        </tr>
        </tbody>
</table>
</div>
    <hr/>
            </div>
        </div>  
    </div>
</div>
<hr/>
    <div>
    <h2 class="cr_image_center"><?php echo esc_html__("Chatbot Preview", 'aiomatic-automatic-ai-content-writer');?></h2>
<?php
$preview_settings = array( 'live_preview' => 'yes', 'temperature' => '', 'top_p' => '', 'presence_penalty' => '', 'frequency_penalty' => '', 'model' => '', 'instant_response' => '', 'show_in_window' => 'off' );
if($god_preview == 'on')
{
    $preview_settings['enable_god_mode'] = 'yes';
}
echo aiomatic_chat_shortcode($preview_settings);
?>
    </div>
    <br/><br/>
    <hr/>
    <div class="cr_image_center"><?php echo esc_html__("To add the chat bot to your website, please include the shortcode [aiomatic-chat-form] in the desired location on your site.", 'aiomatic-automatic-ai-content-writer');?></div>
<?php
}
function aiomatic_expand_chatbot_rules($aiomatic_chat_json)
{
    $rules  = json_decode($aiomatic_chat_json);
    if($rules == false)
    {
        return '';
    }
    $output = '';
    $cont   = 0;
    if (!empty($rules)) {
        foreach ($rules as $dataid => $value) 
        {
            $uniqum = $value->index;
            $data = $value->data;
            $uniq = uniqid();
            if(empty($data->rule_description))
            {
                $data->rule_description = $uniqum;
            }
            $output .= '<div class="cr_center aiuniq-' . esc_html($uniq) . '"><input type="text" id="' . $uniqum . 'rule_description" onchange="anyNewChatChanged();" placeholder="Rule ID" value="' . esc_html($data->rule_description) . '" class="cr_width_full"/></div>
                        <div class="cr_center aiuniq-' . esc_html($uniq) . '"><textarea rows="1" data-id="' . $value->index . '" id="' . $uniqum . 'shortcode" onchange="anyNewChatChanged();" placeholder="' . esc_html__('Input the chatbot shortcode which will be embedded globally to your site', 'aiomatic-automatic-ai-content-writer') . '" class="chatbotShortcodeImportant cr_width_full" required>' . esc_textarea(stripslashes($data->shortcode)) . '</textarea></div>
                        <div class="cr_center aiuniq-' . esc_html($uniq) . '">
                              <input type="button" id="mybtnchatfzr' . esc_html($cont) . '" value="Settings" onclick="document.getElementById(\'mymodalchatfzr' . esc_html($cont) . '\').style.display = \'block\';">
                              <div id="mymodalchatfzr' . esc_html($cont) . '" class="codemodalfzr">
                                 <div class="codemodalfzr-content">
                                    <div class="codemodalfzr-header">
                                       <span id="aiomatic_chat_close' . esc_html($cont) . '" class="codeclosefzr" onclick="document.getElementById(\'mymodalchatfzr' . esc_html($cont) . '\').style.display = \'none\';">&times;</span>
                                       <h2><span class="cr_color_white">' . esc_html__("Rule ID ", 'aiomatic-automatic-ai-content-writer') . esc_html(stripslashes($dataid)) . '</span>&nbsp;' . esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer') . '</h2>
                                    </div>
                                    <div class="codemodalfzr-body">
                                       <div class="table-responsive">
                                          <table class="responsive table cr_main_table_nowr">
                                             
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set a list of URL where to not show the chatbot. You can enter multiple URLs, each on a new line.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot On These URLs:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                        <textarea rows="2" id="' . $uniqum . 'not_show_urls" onchange="anyNewChatChanged();" placeholder="URL list, each on a new line">' . esc_textarea($data->not_show_urls) . '</textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set a list of URL only where to show the chatbot. You can enter multiple URLs, each on a new line. If you enter a list of URLs, the chatbot will be shown only on these URls and not on any other URLs from your site.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only On These URLs:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                        <textarea rows="2" id="' . $uniqum . 'only_show_urls" onchange="anyNewChatChanged();" placeholder="URL list, each on a new line">' . esc_textarea($data->only_show_urls) . '</textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the hour period of each day, when you want to show the chatbot embedded on your site. Your current server time is: ", 'aiomatic-automatic-ai-content-writer') . date("h:i A") . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Between Specific Hours Each Day:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <input type="time" id="' . $uniqum . 'min_time" onchange="anyNewChatChanged();" value="' . esc_attr($data->min_time) . '" placeholder="Show the Chatbot Only After This Hour"> - <input type="time" id="' . $uniqum . 'max_time" value="' . esc_attr($data->max_time) . '" placeholder="Show the Chatbot Only Before This Hour">
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the days of the week, when you want to always show the chatbot (regardless of the above hour limitations).", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Days When To Always Show The Chatbot:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'always_show" onchange="anyNewChatChanged();" class="cr_width_full">' . 
'<option' . (in_array('Monday', $data->always_show) ? ' selected': '') . ' value="Monday">Monday</option>' . 
'<option' . (in_array('Tuesday', $data->always_show) ? ' selected': '') . ' value="Tuesday">Tuesday</option>' .
'<option' . (in_array('Wednesday', $data->always_show) ? ' selected': '') . ' value="Wednesday">Wednesday</option>' . 
'<option' . (in_array('Thursday', $data->always_show) ? ' selected': '') . ' value="Thursday">Thursday</option>' .
'<option' . (in_array('Friday', $data->always_show) ? ' selected': '') . ' value="Friday">Friday</option>' .
'<option' . (in_array('Saturday', $data->always_show) ? ' selected': '') . ' value="Saturday">Saturday</option>' .
'<option' . (in_array('Sunday', $data->always_show) ? ' selected': '') . ' value="Sunday">Sunday</option>' .
'</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the days of the week, when you want to never show the chatbot.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Days When To Never Show The Chatbot:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'never_show" onchange="anyNewChatChanged();" class="cr_width_full">' . 
'<option' . (in_array('Monday', $data->never_show) ? ' selected': '') . ' value="Monday">Monday</option>' .
'<option' . (in_array('Tuesday', $data->never_show) ? ' selected': '') . ' value="Tuesday">Tuesday</option>' .
'<option' . (in_array('Wednesday', $data->never_show) ? ' selected': '') . ' value="Wednesday">Wednesday</option>' .
'<option' . (in_array('Thursday', $data->never_show) ? ' selected': '') . ' value="Thursday">Thursday</option>' .
'<option' . (in_array('Friday', $data->never_show) ? ' selected': '') . ' value="Friday">Friday</option>' .
'<option' . (in_array('Saturday', $data->never_show) ? ' selected': '') . ' value="Saturday">Saturday</option>' .
'<option' . (in_array('Sunday', $data->never_show) ? ' selected': '') . ' value="Sunday">Sunday</option>' .
'</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the WordPress content where to not show the chatbot.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot On This WordPress Content:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple  id="' . $uniqum . 'no_show_content_wp" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->no_show_content_wp ) ? $data->no_show_content_wp : [ '*' ];
$output .= aiomatic_get_wordpress_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the WordPress content only where to show the chatbot.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only On This WordPress Content:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'show_content_wp" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->show_content_wp ) ? $data->show_content_wp : [ '*' ];
$output .= aiomatic_get_wordpress_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the languages for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot For These Languages:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'no_show_locales" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->no_show_locales ) ? $data->no_show_locales : [ '' ];
$output .= aiomatic_get_locales_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the languages for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only For These Languages:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'show_locales" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->show_locales ) ? $data->show_locales : [ '' ];
$output .= aiomatic_get_locales_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the user roles for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot For These User Roles:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'no_show_roles" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->no_show_roles ) ? $data->no_show_roles : [ '' ];
$output .= aiomatic_get_user_roles_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the user roles for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only For These User Roles:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'show_roles" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->show_roles ) ? $data->show_roles : [ '' ];
$output .= aiomatic_get_user_roles_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the devices for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot For These Devices:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'no_show_devices" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->no_show_devices ) ? $data->no_show_devices : [ '' ];
$output .= aiomatic_get_devices_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the devices for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only For These Devices:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'show_devices" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->show_devices ) ? $data->show_devices : [ '' ];
$output .= aiomatic_get_devices_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the Operating Systems for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot For These Operating Systems:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'no_show_oses" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->no_show_oses ) ? $data->no_show_oses : [ '' ];
$output .= aiomatic_get_oses_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the Operating Systems for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only For These Operating Systems:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'show_oses" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->show_oses ) ? $data->show_oses : [ '' ];
$output .= aiomatic_get_oses_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the Browsers for which the chatbot will not be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot For These Browsers:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'no_show_browsers" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->no_show_browsers ) ? $data->no_show_browsers : [ '' ];
$output .= aiomatic_get_browsers_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the Browsers for only which the chatbot will be shown.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only For These Browsers:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div>
                    <select multiple id="' . $uniqum . 'show_browsers" onchange="anyNewChatChanged();" class="resize_vertical cr_width_full">';
$selected = is_array( $data->show_browsers ) ? $data->show_browsers : [ '' ];
$output .= aiomatic_get_browsers_content($selected);
$output .= '</select>  
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the IP Addresses for which the chatbot will not be shown. List of IP addresses or IP ranges. Examples: 46.33.233.31, 46.0-46.1", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Show The Chatbot For These IP Addresses:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div><textarea rows="2" id="' . $uniqum . 'no_show_ips" onchange="anyNewChatChanged();" placeholder="' . esc_html__("IP Addresses / Ranges", 'aiomatic-automatic-ai-content-writer') . '">' . esc_textarea($data->no_show_ips) . '</textarea>
        </div>
        </td></tr>
        <tr class="hideInject"><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the IP Addresses for only which the chatbot will be shown. List of IP addresses or IP ranges. Examples: 46.33.233.31, 46.0-46.1", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Show The Chatbot Only For These IP Addresses:", 'aiomatic-automatic-ai-content-writer') . '</b>
                    </div>
                    </td><td>
                    <div><textarea rows="2" id="' . $uniqum . 'show_ips" onchange="anyNewChatChanged();" placeholder="' . esc_html__("IP Addresses / Ranges", 'aiomatic-automatic-ai-content-writer') . '">' . esc_textarea($data->show_ips) . '</textarea>
        </div>
        </td></tr>
                                            </table>
                                        </div>
                                    </div>
                            <div class="codemodalfzr-footer">
                                <br/>
                                <h3 class="cr_inline">Aiomatic Chatbot Injection</h3><span id="aiomatic_chat_ok' . esc_html($cont) . '" class="codeokfzr cr_inline" onclick="document.getElementById(\'mymodalchatfzr' . esc_html($cont) . '\').style.display = \'none\';">OK&nbsp;</span>
                                <br/><br/>
                            </div>
                                 </div>
                                </div>
                            </div>
                        <div class="cr_center aiuniq-' . esc_html($uniq) . '"><span data-id="' . esc_html($uniq) . '" class="wpaiomatic-delete">X</span></div>';
            $cont++;
        }
    }
    return $output;
}
?>