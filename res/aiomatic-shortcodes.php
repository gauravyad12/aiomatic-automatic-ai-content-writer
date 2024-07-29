<?php
function aiomatic_shortcodes_panel()
{
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
   {
      ?>
<h1><?php echo esc_html__("You must add an OpenAI/AiomaticAPI API Key into the plugin's 'Settings' menu before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
?>
<div class="aiomatic-template-form-field-default aiomatic-hidden-form">
<div class="aiomatic-template-form-field aiomatic-hidden-form">
<div>
   <div>
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Label*", 'aiomatic-automatic-ai-content-writer');?><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the input field Label (textual hint).", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></strong>
         <input type="text" name="aiomaticfields[0][label]" required placeholder="The label which will be shown next to the input field" class="aiomatic-create-template-field-label aiomatic-full-size">
   </div>
   <div>
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("ID*", 'aiomatic-automatic-ai-content-writer');?><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the input field ID. This is important, as you will be able to get the value entered by users on the front end for this input field, using this ID. You will be able to use this in the 'Prompt' settings field from below, in the following format: %%ID_YOU_ENTER_HERE%%.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></strong>
         <input placeholder="my_unique_input_id" type="text" name="aiomaticfields[0][id]" required class="aiomatic-create-template-field-id aiomatic-full-size">
         <small class="aiomatic-full-center"><?php echo esc_html__("You can add the value of this field to the form prompt from below, using this shortcode", 'aiomatic-automatic-ai-content-writer');?>: <b>%%my_unique_input_id%%</b></small>
   </div>
   <div>
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Required*", 'aiomatic-automatic-ai-content-writer');?><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set this input field as required (form cannot be submitted unless this is filled up).", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></strong>
         <select name="aiomaticfields[0][required]" class="aiomatic-create-template-field-required aiomatic-full-size">
            <option value="no" selected><?php echo esc_html__("No", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="yes"><?php echo esc_html__("Yes", 'aiomatic-automatic-ai-content-writer');?></option>
         </select>
   </div>
   <div>
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Field Type*", 'aiomatic-automatic-ai-content-writer');?><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the field type for this input field.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></strong>
         <select name="aiomaticfields[0][type]" class="aiomatic-create-template-field-type aiomatic-full-size">
            <option value="text" selected><?php echo esc_html__("Text", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="select"><?php echo esc_html__("Select", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="number"><?php echo esc_html__("Number", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="email"><?php echo esc_html__("Email", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="url"><?php echo esc_html__("URL", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="scrape"><?php echo esc_html__("URL Scraper", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="textarea"><?php echo esc_html__("Textarea", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="checkbox"><?php echo esc_html__("Checkbox", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="radio"><?php echo esc_html__("Radio", 'aiomatic-automatic-ai-content-writer');?></option>
            <option value="html"><?php echo esc_html__("HTML", 'aiomatic-automatic-ai-content-writer');?></option>
         </select>
   </div>
   <div class="aiomatic-create-template-field-placeholder-main aiomatic-placeholder-form">
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Placeholder Text", 'aiomatic-automatic-ai-content-writer');?></strong>
         <input placeholder="Placeholder text" type="text" name="aiomaticfields[0][placeholder]" class="aiomatic-create-template-field-placeholder aiomatic-full-size">
   </div>
   <div class="aiomatic-create-template-field-limit-main aiomatic-limit-form">
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Max Character Input Limit", 'aiomatic-automatic-ai-content-writer');?></strong>
         <input placeholder="Max input character count" type="text" name="aiomaticfields[0][limit]" class="aiomatic-create-template-field-limit aiomatic-full-size">
   </div>
   <div class="aiomatic-create-template-field-min-main aiomatic-hidden-form">
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Min", 'aiomatic-automatic-ai-content-writer');?></strong>
         <input placeholder="Minimum value (optional)" type="number" name="aiomaticfields[0][min]" class="aiomatic-create-template-field-min aiomatic-full-size">
   </div>
   <div class="aiomatic-create-template-field-max-main aiomatic-hidden-form">
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Max", 'aiomatic-automatic-ai-content-writer');?></strong>
         <input placeholder="Maximum value (optional)" type="number" name="aiomaticfields[0][max]" class="aiomatic-create-template-field-max aiomatic-full-size">
   </div>
   <div class="aiomatic-create-template-field-rows-main aiomatic-hidden-form">
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Rows", 'aiomatic-automatic-ai-content-writer');?></strong>
         <input placeholder="Textarea rows count (optional)" type="number" name="aiomaticfields[0][rows]" class="aiomatic-create-template-field-rows aiomatic-full-size">
   </div>
   <div class="aiomatic-create-template-field-cols-main aiomatic-hidden-form">
         <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Cols", 'aiomatic-automatic-ai-content-writer');?></strong>
         <input placeholder="Textarea columns count (optional)" type="number" name="aiomaticfields[0][cols]" class="aiomatic-create-template-field-cols aiomatic-full-size">
   </div>
</div>
<div class="aiomatic-create-template-field-options-main aiomatic-hidden-form">
   <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Options", 'aiomatic-automatic-ai-content-writer');?></strong>
   <textarea name="aiomaticfields[0][options]" class="aiomatic-create-template-field-options aiomatic-full-size" placeholder="Possible values, separated by a new line"></textarea>
</div>
<div class="aiomatic-create-template-field-value-main">
   <strong class="aiomatic-label-top marginbottom-5"><?php echo esc_html__("Predefined Value", 'aiomatic-automatic-ai-content-writer');?></strong>
   <textarea name="aiomaticfields[0][value]" class="aiomatic-create-template-field-value aiomatic-full-size" placeholder="Predefined value"></textarea>
</div>
<div class="aiomatic-form-controls">
<span class="aiomatic-field-up-add"><?php echo esc_html__("Move Up", 'aiomatic-automatic-ai-content-writer');?></span>&nbsp;
<span class="aiomatic-field-down-add"><?php echo esc_html__("Move Down", 'aiomatic-automatic-ai-content-writer');?></span>&nbsp;
<span class="aiomatic-field-delete-add"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></span>&nbsp;
<span class="aiomatic-field-duplicate-add"><?php echo esc_html__("Duplicate", 'aiomatic-automatic-ai-content-writer');?></span>
</div>
</div>
</div>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<h2 class="cr_center"><?php echo esc_html__("Aiomatic Shortcodes & Forms", 'aiomatic-automatic-ai-content-writer');?></h2>
</div>
<div class="wrap gs_popuptype_holder">
        <nav class="nav-tab-wrapper">
            <a href="#tab-0" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Built-in Shortcodes", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("Add A New AI Form", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-4" class="nav-tab"><?php echo esc_html__("AI Forms Importer/Exporter", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-3" class="nav-tab"><?php echo esc_html__("List AI Forms", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-x" datahref="<?php echo admin_url('admin.php?page=aiomatic_admin_settings#tab-18');?>" class="nav-tab"><?php echo esc_html__("AI Forms Settings", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-0" class="tab-content">
        <br/>
         <h3><?php echo esc_html__("What are AI Forms?", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p><?php echo esc_html__("With AI Forms you can create fully customizable forms which will be able to be used using the [aiomatic-form id=\"FORM_ID\"] shortcode. You can create textual forms, Dalle-2 image forms or Stable Diffusion image forms. You can create custom input fields of multiple types for the created forms, where users will be able to define their desired input values. These input fields will be able to be replaced in the prompts you define for each form, using shortcodes in this format: %%input_field_ID%%.", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("The forms feature will allow you to extend the functionality of your site, provide customized responses to user questions or even create AI membership websites. These forms will be able to be used next to the conventional 'built-in' shortcodes which are provided by the plugin. These 'built-in' shortcodes are listed in the 'Buil-in Shortcodes' tab from above.", 'aiomatic-automatic-ai-content-writer');?></p>
         <h3><?php echo esc_html__("How to get started with AI Forms?", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p><b><?php echo esc_html__("The main steps of creating forms are", 'aiomatic-automatic-ai-content-writer');?>:</b></p>
         <ol><li><b><?php echo esc_html__("Step 0: Read this tutorial carefully and watch the tutorial video", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("be sure to not skip this step!", 'aiomatic-automatic-ai-content-writer');?></li>
         <li><b><?php echo esc_html__("Step 1a: Import the default AI Forms", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("In case you want to get some inspiration on how to create your own forms or you want to get started really quick with using the AI Forms functionality of the plugin, you can go ahead and import the default forms which come bundled with this plugin. To do this, go to the 'AI Forms Importer/Exporter' tab and click the 'Import Default Forms' button.", 'aiomatic-automatic-ai-content-writer');?>
        </li>
        <li><b><?php echo esc_html__("Step 1b: Create your own AI Forms", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("You can also get started creating your own AI Forms. To do this, go to the 'Add A New AI Form' tab and start setting up your own forms. You can select between multiple form types (text, Dall-E image or Stable Diffusion image), set a form name and description (which can be displayed on the top of the form, as a form headers). You can create also multiple input fields (of multiple types), using the 'Add A New Form Input Field' button, which will be used by users to enter their data. For each input field, you can set an 'ID', which will be used as a shortcode (and replaced with the value entered by the user) in the AI prompt you define in the form you build, using this format: %%input_ID%%. You will be also able to set some AI model advanced settings and configure the form's submit button text. For more detailed AI Forms customization, you can check the plugin's 'Settings' menu -> 'AI Forms' tab.", 'aiomatic-automatic-ai-content-writer');?></li>
        <li><b><?php echo esc_html__("Step 2: Use the AI Forms", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("You can set up the AI Forms in the front end of your site, by using the [aiomatic-form id=\"FORM_ID\"] shortcode. You can get the shortcode for each form, from the 'List AI Forms' tab from above. Here you will be able to manage (edit, delete, preview) created AI Forms.", 'aiomatic-automatic-ai-content-writer');?>
        </li>
    </ol>
         <h3><?php echo esc_html__("Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/NhbEeIXxu-0" frameborder="0" allowfullscreen></iframe></div></p>

        </div>
        <div id="tab-x" class="tab-content">
        <br/>
        <p><?php echo esc_html__("Redirecting...", 'aiomatic-automatic-ai-content-writer');?></p>
        </div>
        <div id="tab-1" class="tab-content">
         <br/>
         <p>
   <h2><?php echo esc_html__("Available shortcodes:", 'aiomatic-automatic-ai-content-writer');?></h2> <ul><li><strong>[aiomatic-text-completion-form]</strong> <?php echo esc_html__("to add a form similar to OpenAI's Text Completion Playground, to generate AI written text based on prompts.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-text-editing-form]</strong> <?php echo esc_html__("to add a form similar to OpenAI's Playground, to generate AI written text based on prompts.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-image-generator-form]</strong> <?php echo esc_html__("to add a form to generate AI images (GPT-3) based on prompts.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-stable-image-generator-form]</strong> <?php echo esc_html__("to add a form to generate AI images (Stable Diffusion) based on prompts.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-midjourney-image-generator-form]</strong> <?php echo esc_html__("to add a form to generate AI images (Midjourney) based on prompts.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-chat-form]</strong> <?php echo esc_html__("to add a form to generate a chat similar to ChatGPT. However, please note that this is not ChatGPT, but instead it is a custom chatbot built on top of OpenAI API.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-persona-selector]</strong> <?php echo esc_html__("to add a Chatbot persona selector screen on the front end, visitors can click on the chatbot persona with which they want to chat. Other [aiomatic-chat-form] parameters will be also able to be used here.", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-article]</strong> <?php echo esc_html__("to automatically write an article based on the 'seed_expre' argument of the post content/excerpt/title where the shortcode is placed,", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aicontent]Your Prompt[/aicontent]</strong> <?php echo esc_html__("to execute the prompt which is added inside the shortcode and to automatically save the result to the post,", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-image]</strong> <?php echo esc_html__("to automatically create an AI generated image (GPT-3) based on the 'seed_expre' argument of the post content/excerpt/title where the shortcode is placed,", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-stable-image]</strong> <?php echo esc_html__("to automatically create an AI generated image (Stable Diffusion) based on the 'seed_expre' argument of the post content/excerpt/title where the shortcode is placed,", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-midjourney-image]</strong> <?php echo esc_html__("to automatically create an AI generated image (Midjourney) based on the 'seed_expre' argument of the post content/excerpt/title where the shortcode is placed,", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-audio-converter]</strong> <?php echo esc_html__("to convert an audio file to text", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-text-moderation]</strong> <?php echo esc_html__("to check a text for profanities and to moderate it", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-plagiarism-check]</strong> <?php echo esc_html__("to check a text for plagiarism", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-ai-detector]</strong> <?php echo esc_html__("to check a text for AI generated content", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-internet-search]</strong> <?php echo esc_html__("check internet search results for a specific keyword - this shortcode is only for testing purposes", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-user-remaining-credits-text]</strong> <?php echo esc_html__("to include a textual representation of the remaining credits for the current account (in case AI usage is limited from plugin settings)", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-user-remaining-credits-bar]</strong> <?php echo esc_html__("to include a visual representation of the remaining credits for the current account (in case AI usage is limited from plugin settings)", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic_charts]</strong> <?php echo esc_html__("to embed dynamic and customizable charts and graphs in WordPress posts and pages. Usage: [aiomatic_charts type=\"Line/Bar/Radar/Pie/Doughnut/PolarArea\" title=\"ChartTitle\" labels=\"Label1,Label2,Label3\" data=\"Value1,Value2,Value3\" datasets=\"DataSet1,DataSet2\" colors=\"#RGB1,#RGB2,#RGB3\" canvaswidth=625 canvasheight=625 width='100%' height='auto' fillopacity=0.7 animation='true/false' scalefontsize=12 scalefontcolor='#666' scaleoverride='true/false' scalesteps='number' scalestepwidth='value' scalestartvalue='value']  and", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-list-posts]</strong> <?php echo esc_html__("to include a list that contains only posts imported by this plugin, and", 'aiomatic-automatic-ai-content-writer');?></li>
   <li><strong>[aiomatic-display-posts]</strong> <?php echo esc_html__("to include a WordPress like post listing. Usage:", 'aiomatic-automatic-ai-content-writer');?> [aiomatic-display-posts type='any/post/page/...' title_color='#ffffff' excerpt_color='#ffffff' read_more_text="Read More" link_to_source='yes' order='ASC/DESC' orderby='title/ID/author/name/date/rand/comment_count' title_font_size='19px', excerpt_font_size='19px' posts_per_page=number_of_posts_to_show category='posts_category' ruleid='ID_of_aiomatic_rule']</li></ul> 
   <br/><?php echo esc_html__("Example:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-list-posts type='any' order='ASC' orderby='date' posts_per_page=50 category= '' ruleid='0']</b>
   <br/><?php echo esc_html__("Example 2:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-display-posts include_excerpt='true' image_size='thumbnail' wrapper='div']</b>
   <br/><?php echo esc_html__("Example 3:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-article seed_expre='Write an informal article about Climate Change' temperature='1' top_p='1' assistant_id='' model='gpt-3.5-turbo-instruct' presence_penalty='0' frequency_penalty='0' min_char='500' max_tokens='2048' max_tokens='2048' max_seed_tokens='500' max_continue_tokens='500' images="2" headings="3" videos="on" static_content="off" cache_seconds="2592000" headings_model='gpt-3.5-turbo-instruct' headings_seed_expre='Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%' no_internet='0']</b>
   <br/><?php echo esc_html__("Example 4:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-image seed_expre='A high detail photograph of a sports car driving on the highway' image_size='1024x1024' image_model='dalle2' static_content='on' copy_locally='on' cache_seconds='2592000']</b>
   <br/><?php echo esc_html__("Example 5:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-stable-image seed_expre='A high detail photograph of a sports car driving on the highway' image_size='1024x1024' static_content='on' copy_locally='on' cache_seconds='2592000']</b>
   <br/><?php echo esc_html__("Example 6:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-midjourney-image seed_expre='A high detail photograph of a sports car driving on the highway' image_size='1024x1024' static_content='on' copy_locally='on' cache_seconds='2592000']</b>
   <br/><?php echo esc_html__("Example 7:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-text-completion-form temperature='default' top_p='default' assistant_id='' model='default' presence_penalty='default' frequency_penalty='default' prompt_templates='' prompt_editable="on"]</b>
   <br/><?php echo esc_html__("Example 8:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-text-editing-form temperature='default' top_p='default' model='default' prompt_templates='' prompt_editable="on"]</b>
   <br/><?php echo esc_html__("Example 9:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-image-generator-form image_size='default' image_model='dalle2' prompt_templates='' prompt_editable="on"]</b>
   <br/><?php echo esc_html__("Example 10:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-stable-image-generator-form image_size='default' prompt_templates='' prompt_editable="on"]</b>
   <br/><?php echo esc_html__("Example 11:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-midjourney-image-generator-form image_size='default' prompt_templates='' prompt_editable="on"]</b>
   <br/><?php echo esc_html__("Example 12:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-chat-form temperature="default" top_p="default" assistant_id="" model="default" enable_vision="off" presence_penalty="default" frequency_penalty="default" instant_response="false" enable_god_mode="disabled" chatbot_text_speech="" upload_pdf="" file_uploads="" custom_header="" custom_footer="" custom_css="" send_message_sound="" receive_message_sound="" response_delay="" ai_avatar="" show_header="show" show_clear="" show_dltxt="show" show_mute="show" show_internet="show" ai_role="" chat_preppend_text="Act as a customer assistant, respond to every question in a helpful way." user_message_preppend="User" ai_message_preppend="AI" ai_first_message="Hello, how can I help you today?" chat_mode="text" persistent="off" prompt_templates="" prompt_editable="on" placeholder="Enter your chat message here" submit="Submit" show_in_window="off" window_location="top-right" font_size="1em" height="100%" background="auto" general_background="#ffffff" minheight="250px" user_font_color="#ffffff" user_background_color="#0084ff" ai_font_color="#000000" ai_background_color="#f0f0f0" input_border_color="#e1e3e6" submit_color="#55a7e2" submit_text_color="#ffffff" voice_color="#55a7e2" voice_color_activated="#55a7e2" width="100%"]</b>
   <br/><?php echo esc_html__("Example 13:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-persona-selector ai_personas="47389,47387,47385"] - you need to change the chatbot persona IDs to the IDs of personas which you want to use, from your site!</b>
   <br/><?php echo esc_html__("Example 14:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-text-moderation] - yes, as simple as this!</b>
   <br/><?php echo esc_html__("Example 15:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-plagiarism-check] - very simple use!</b>
   <br/><?php echo esc_html__("Example 16:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-ai-detector] - simple as this!</b>
   <br/><?php echo esc_html__("Example 17:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-audio-converter] - also simple!</b>
   <br/><?php echo esc_html__("Example 18:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-user-remaining-credits-text] - display usage of AI credits for the current user, in a textual form</b>
   <br/><?php echo esc_html__("Example 19:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-user-remaining-credits-bar] - display usage of AI credits for the current user, in a visual form</b>
   <br/><?php echo esc_html__("Example 20:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic-internet-search keyword="dog food"]</b>
   <br/><?php echo esc_html__("Example 21:", 'aiomatic-automatic-ai-content-writer');?> <b>[aicontent model="gpt-3.5-turbo"]Say hello![/aicontent]</b>
   <br/><?php echo esc_html__("Example 22:", 'aiomatic-automatic-ai-content-writer');?> <b>[aiomatic_charts type="Pie" title="ExpenseDistribution" labels="Rent,Utilities,Groceries" data="40,30,30" colors="#FF6384,#36A2EB,#FFCE56"]</b>
   </p>
   <h2><?php echo esc_html__("Currently supported models to be used in shortcodes:", 'aiomatic-automatic-ai-content-writer');?></h2>
<ul>
<?php
$all_assistants = aiomatic_get_all_assistants(true);
$all_models = aiomatic_get_all_models();
foreach($all_models as $modl)
{
   echo '<li>-&nbsp;' . $modl . esc_html(aiomatic_get_model_provider($modl)) . '</li>';
}
?>
</ul></p>
   </div>
   <div id="tab-2" class="tab-content">
         <br/>
   <form action="#" method="post" id="aiomatic_forms_form">
    <input type="hidden" name="action" value="aiomatic_forms">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('aiomatic_forms');?>">
      <h1><strong><?php echo esc_html__("Add a new form:", 'aiomatic-automatic-ai-content-writer');?></strong></h1>
      <div class="main-form-header-holder"><h2><?php echo esc_html__("Input Fields", 'aiomatic-automatic-ai-content-writer');?>:</h2><span class="header-al-right"><?php echo esc_html__("Hide Input Fields", 'aiomatic-automatic-ai-content-writer');?></span></div>
      <div class="main-form-holder">
      <button id="aiomatic-create-form-field" class="button"><?php echo esc_html__("Add A New Form Input Field", 'aiomatic-automatic-ai-content-writer');?></button>
   <br/><br/>
      <div class="aiomatic-template-fields"></div>
      </div>
      <hr/>
      <h2><?php echo esc_html__("Form Options", 'aiomatic-automatic-ai-content-writer');?>:</h2>
      <h4><?php echo esc_html__("Type*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the type of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select id="aiomatic-type" name="aiomatic-type" required class="aiomatic-create-template-field-type aiomatic-full-size" onchange="aiomatic_type_changed();">
      <option value="text"><?php echo esc_html__("Text", 'aiomatic-automatic-ai-content-writer');?></option>
      <option value="image"><?php echo esc_html__("Dall-E 2 Image", 'aiomatic-automatic-ai-content-writer');?></option>
      <option value="image-new"><?php echo esc_html__("Dall-E 3 Image", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '') 
{
    echo '<option value="image2">' . esc_html__("Stable Diffusion Image", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
if (isset($aiomatic_Main_Settings['midjourney_app_id']) && trim($aiomatic_Main_Settings['midjourney_app_id']) != '') 
{
    echo '<option value="image-mid">' . esc_html__("Midjourney Image", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
?>
      </select>
      <br/>
      <h4><?php echo esc_html__("Title*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the title of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input id="aiomatic-form-title" name="aiomatic-form-title" class="aiomatic-full-size" placeholder="Your form name" required>
      <br/>
      <h4><?php echo esc_html__("Description", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the description of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <textarea id="aiomatic-form-description" name="aiomatic-form-description" class="aiomatic-full-size" placeholder="Your form description"></textarea>
      <br/>
      <h4><?php echo esc_html__("Prompt*", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the prompt which will be sent to the AI content writer. You can use shortcodes to get the input values entered by users in the form. The shortcodes need to be in the following format: %%ID_of_the_input_field%%", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <textarea id="aiomatic-form-prompt" name="aiomatic-form-prompt" class="aiomatic-full-size" placeholder="The prompt which will be sent to the AI content writer" required></textarea>
      <br/>
      <h4><?php echo esc_html__("Sample Response", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set an example response for this form, this can be shown to users.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <textarea name="aiomatic-form-response" id="aiomatic-form-response" class="aiomatic-full-size" placeholder="A sample response to show for this form"></textarea>
      <hr/>
      <div class="hide-when-not-text">
      <h2><?php echo esc_html__("AI API Options", 'aiomatic-automatic-ai-content-writer');?>:</h2>
      <h4><?php echo esc_html__("AI Assistant ID*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the AI assistant ID to be used for this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select name="aiomatic-form-assistant-id" class="aiomatic-create-template-field-type aiomatic-full-size">
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
        echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            echo '<option value="' . $myassistant->ID .'"';
            echo '>' . esc_html($myassistant->post_title);
            echo '</option>';
        }
    }
}
?>
      </select>
      <br/><h4><?php echo esc_html__("AI Model*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select the AI model to be used for this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select name="aiomatic-form-model" class="aiomatic-create-template-field-type aiomatic-full-size">
<?php
foreach($all_models as $modl)
{
   echo '<option value="' . $modl . '">' . $modl . esc_html(aiomatic_get_model_provider($modl)) . '</option>';
}
?>
      </select>
      <br/><h4><?php echo esc_html__("Response Streaming*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to enable response streaming for your AI form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select name="aiomatic-form-stream" class="aiomatic-create-template-field-type aiomatic-full-size">
        <option value="stream"><?php echo esc_html__("Enabled", 'aiomatic-automatic-ai-content-writer');?></option>
        <option value="0"><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
      </select>
      <br/>
      <br/>
      <button id="aiomatic-show-hide-field" class="button"><?php echo esc_html__("Show/Hide Advanced Model Settings", 'aiomatic-automatic-ai-content-writer');?></button>
      <br/>
      <div class="aiomatic-hidden-form" id="hideAdv">
      <h4><?php echo esc_html__("Max Token Count", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the AI maximum token count of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input type="number" min="1" max="128000" step="1" name="aiomatic-max" value="" placeholder="Maximum token count to be used" class="cr_width_full">
      <br/>
      <h4><?php echo esc_html__("Temperature", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the AI temperature of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input type="number" min="0" max="2" step="0.1" name="aiomatic-temperature" value="" placeholder="AI Temperature" class="cr_width_full">
      <br/>
      <h4><?php echo esc_html__("Top_p", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the AI top_p parameter of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input type="number" min="0" max="1" step="0.1" name="aiomatic-topp" value="" placeholder="AI Top_p" class="cr_width_full">
      <br/>
      <h4><?php echo esc_html__("Presence Penalty", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the AI presence penalty parameter of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input type="number" min="-2" step="0.1" max="2" name="aiomatic-presence" value="" placeholder="AI Presence Penalty" class="cr_width_full">
      <br/>
      <h4><?php echo esc_html__("Frequency Penalty", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the AI frequency penalty parameter of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input type="number" min="0" max="2" step="0.1" name="aiomatic-frequency" value="" placeholder="AI Frequency penalty" class="cr_width_full">
      </div>
      <hr/>
      </div>
      <h2><?php echo esc_html__("Front End Options", 'aiomatic-automatic-ai-content-writer');?>:</h2>
      <h4><?php echo esc_html__("Show Header On Front End*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the form header to users.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select name="aiomatic-header" class="aiomatic-create-template-field-type aiomatic-full-size">
         <option value="show" selected><?php echo esc_html__("Show", 'aiomatic-automatic-ai-content-writer');?></option>
         <option value="hide"><?php echo esc_html__("Hide", 'aiomatic-automatic-ai-content-writer');?></option>
      </select>
      <br/>
      <h4 class="hide-when-not-text"><?php echo esc_html__("Display AI Form Results In", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the form results in a modern WP Editor instead of a plain textarea.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select name="aiomatic-editor" class="hide-when-not-text aiomatic-create-template-field-type aiomatic-full-size">
         <option value="textarea" selected><?php echo esc_html__("Textarea", 'aiomatic-automatic-ai-content-writer');?></option>
         <option value="wpeditor"><?php echo esc_html__("WP Editor", 'aiomatic-automatic-ai-content-writer');?></option>
      </select>
      <br class="hide-when-not-text"/>
      <h4 class="hide-when-not-text"><?php echo esc_html__("Show Advanced Form Options", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Select if you want to show the advanced form options to users.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <select name="aiomatic-advanced" class="hide-when-not-text aiomatic-create-template-field-type aiomatic-full-size">
         <option value="hide" selected><?php echo esc_html__("Hide", 'aiomatic-automatic-ai-content-writer');?></option>
         <option value="show"><?php echo esc_html__("Show", 'aiomatic-automatic-ai-content-writer');?></option>
      </select>
      <br class="hide-when-not-text"/>
      <h4><?php echo esc_html__("Submit Button Text*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
<div class="bws_hidden_help_text cr_min_260px">
<?php
    echo esc_html__("Set the submit button text of this form.", 'aiomatic-automatic-ai-content-writer');
    ?>
</div>
</div></h4>
      <input id="aiomatic-submit" name="aiomatic-submit" value="Submit" class="aiomatic-full-size" placeholder="Submit" required>
    <br/><br/>
    <button id="aiomatic-form-save-button" class="button button-primary"><?php echo esc_html__("Save", 'aiomatic-automatic-ai-content-writer');?></button>
   <div class="aiomatic-forms-success"></div>
</form>
        </div>
        <div id="tab-4" class="tab-content">
         <br/>
<?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Import Forms From File", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px">
        <?php
        echo esc_html__("Hit this button and you can restore forms from file.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<div class="aiomatic_form_upload_form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php
        echo esc_html__("Backup File (*.json)", 'aiomatic-automatic-ai-content-writer');
        ?></th>
            <td>
                <input type="file" id="aiomatic_form_upload" accept=".json">
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
        echo esc_html__("File uploaded successfully you can view it in the form listing tab.", 'aiomatic-automatic-ai-content-writer');
        ?></div>
                <div class="aiomatic_progress aiomatic_none"><span></span><small><?php
        echo esc_html__("Uploading", 'aiomatic-automatic-ai-content-writer');
        ?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_form_button"><?php echo esc_html__("Import Forms From File", 'aiomatic-automatic-ai-content-writer');?></button><br>
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
<div class="aiomatic-loader-bubble">
    <div>
            <h3>
               <?php echo esc_html__('Download Current Forms To File:', 'aiomatic-automatic-ai-content-writer');?>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Hit this button and you can backup the current forms to file.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <form method="post" onsubmit="return confirm('Are you sure you want to download forms to file?');"><input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_forms');?>"><input name="aiomatic_download_forms_to_file" type="submit" class="button button-primary coderevolution_block_input" value="Download Forms To File"></form>
         </div>
</div>
<br/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Import Default Forms", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px">
        <?php
        echo esc_html__("Hit this button and the plugin will create the default forms which come bundled with the plugin.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<table class="form-table">
        <tbody>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_form_default_button"><?php echo esc_html__("Import Default Forms", 'aiomatic-automatic-ai-content-writer');?></button><br>
            </td>
        </tr>
        </tbody>
</table>
</div>
        </div>
        <div id="tab-3" class="tab-content">
        <br/>
        <button href="#" id="aiomatic_sync_forms" class="page-title-action"><?php
        echo esc_html__("Sync Forms", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_delete_selected_forms" class="page-title-action"><?php
        echo esc_html__("Delete Selected Forms", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_deleteall_forms" class="page-title-action"><?php
        echo esc_html__("Delete All Forms", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <?php
        
$orderby = 'date';
$order = 'DESC';
if (isset($_GET['order']) && in_array(strtolower($_GET['order']), ['asc', 'desc'])) {
    $order = strtoupper($_GET['order']);
}
if (isset($_GET['orderby']) && in_array(strtolower($_GET['orderby']), ['title', 'date'])) {
    $orderby = strtolower($_GET['orderby']);
}
$aiomatic_form_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_forms = new WP_Query(array(
    'post_type' => 'aiomatic_forms',
    'posts_per_page' => 40,
    'paged' => $aiomatic_form_page,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'any'
));
if($aiomatic_forms->have_posts()){
    echo '<br><br>' . esc_html__('All forms', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_forms->found_posts . ')<br>';
}
$current_order = filter_input(INPUT_GET, 'order', FILTER_DEFAULT) === 'asc' ? 'desc' : 'asc';
$title_url = add_query_arg([
    'orderby' => 'title',
    'order' => $current_order
], $_SERVER['REQUEST_URI']);
$date_url = add_query_arg([
    'orderby' => 'date',
    'order' => $current_order
], $_SERVER['REQUEST_URI']);
?>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th class="manage-column column-cb check-column aiomatic-tdcol" scope="col"><input class="aiomatic-chk" type="checkbox" id="checkedAll"></th>
        <th scope="col"><a href="<?php echo esc_html($title_url); ?>"><?php
        echo esc_html__("Title", 'aiomatic-automatic-ai-content-writer');
        ?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php
        echo esc_html__("Type", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Shortcode", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Input Field Count", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><a href="<?php echo esc_html($date_url); ?>"><?php
        echo esc_html__("Date", 'aiomatic-automatic-ai-content-writer');
        ?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php
        echo esc_html__("Manage", 'aiomatic-automatic-ai-content-writer');
        ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($aiomatic_forms->have_posts()){
        foreach ($aiomatic_forms->posts as $aiomatic_form){
            $aiomaticfields = get_post_meta($aiomatic_form->ID, '_aiomaticfields', true);
            $type = get_post_meta($aiomatic_form->ID, 'type', true);
            if(!is_array($aiomaticfields))
            {
               $aiomaticfields = array();
            }
            ?>
            <tr>
                <td><input class="aiomatic-select-form" id="aiomatic-select-<?php echo $aiomatic_form->ID;?>" type="checkbox" name="ids[]" value="<?php echo $aiomatic_form->ID;?>"></td>
                <td><a href="<?php echo get_edit_post_link($aiomatic_form->ID);?>" class="aiomatic-form-content"><?php echo esc_html($aiomatic_form->post_title);?></a></td>
                <td><?php echo esc_html($type);?></td>
                <td><?php echo '[aiomatic-form id="' . $aiomatic_form->ID . '"]';?></td>
                <td><?php echo count($aiomaticfields);?></td>
                <td><?php echo esc_html($aiomatic_form->post_date)?></td>
                <td>
                <div class="cr_center">
                <button class="button button-small aiomatic_preview_form" id="aiomatic_preview_form_<?php echo $aiomatic_form->ID;?>" data-id="<?php echo $aiomatic_form->ID;?>"><?php echo esc_html__("Preview", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_manage_form" id="aiomatic_manage_form_<?php echo $aiomatic_form->ID;?>" data-id="<?php echo $aiomatic_form->ID;?>"><?php echo esc_html__("Edit", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_duplicate_form" id="aiomatic_duplicate_form_<?php echo $aiomatic_form->ID;?>" data-id="<?php echo $aiomatic_form->ID;?>"><?php echo esc_html__("Duplicate", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_delete_form" id="aiomatic_delete_form_<?php echo $aiomatic_form->ID;?>" delete-id="<?php echo $aiomatic_form->ID;?>"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
                </div>
            </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
<div class="aiomatic-paginate">
    <?php
    echo paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_shortcodes_panel&wpage=%#%'),
        'total'        => $aiomatic_forms->max_num_pages,
        'current'      => $aiomatic_form_page,
        'format'       => '?wpage=%#%',
        'show_all'     => false,
        'prev_next'    => false,
        'add_args'     => false,
    ));
    ?>
</div>
        </div>
    </div>
<?php
}
?>