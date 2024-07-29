<?php
   function aiomatic_items_panel()
   {
      $aiomatic_language_names = array(
         esc_html__("English", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Spanish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("French", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Italian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Afrikaans", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Albanian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Arabic", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Amharic", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Armenian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Belarusian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Bulgarian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Catalan", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Chinese Simplified", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Croatian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Czech", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Danish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Dutch", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Estonian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Filipino", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Finnish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Galician", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("German", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Greek", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Hebrew", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Hindi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Hungarian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Icelandic", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Indonesian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Irish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Japanese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Korean", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Latvian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Lithuanian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Norwegian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Macedonian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Malay", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Maltese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Persian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Polish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Portuguese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Romanian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Russian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Serbian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Slovak", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Slovenian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Swahili", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Swedish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Thai", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Turkish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Ukrainian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Vietnamese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Welsh", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Yiddish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Tamil", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Azerbaijani", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Kannada", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Basque", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Bengali", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Latin", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Chinese Traditional", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Esperanto", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Georgian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Telugu", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Gujarati", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Haitian Creole", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Urdu", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Burmese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Bosnian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Cebuano", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Chichewa", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Corsican", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Frisian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Scottish Gaelic", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Hausa", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Hawaian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Hmong", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Igbo", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Javanese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Kazakh", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Khmer", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Kurdish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Kyrgyz", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Lao", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Luxembourgish", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Malagasy", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Malayalam", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Maori", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Marathi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Mongolian", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Nepali", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Pashto", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Punjabi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Samoan", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Sesotho", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Shona", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Sindhi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Sinhala", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Somali", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Sundanese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Swahili", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Tajik", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Uzbek", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Xhosa", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Yoruba", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Zulu", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Assammese", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Aymara", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Bambara", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Bhojpuri", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Dhivehi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Dogri", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Ewe", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Guarani", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Ilocano", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Kinyarwanda", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Konkani", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Krio", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Kurdish - Sorani", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Lingala", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Luganda", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Maithili", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Meiteilon", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Mizo", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Odia", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Oromo", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Quechua", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Sanskrit", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Sepedi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Tatar", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Tigrinya", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Tsonga", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Turkmen", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Twi", 'aiomatic-automatic-ai-content-writer'),
         esc_html__("Uyghur", 'aiomatic-automatic-ai-content-writer')
      );
   $all_models = aiomatic_get_all_models(true);
   $all_assistants = aiomatic_get_all_assistants(true);
   $all_rules = get_option('aiomatic_rules_list', array());
   if($all_rules === false)
   {
       $all_rules = array();
   }
   $rules_count = count($all_rules);
   $rules_per_page = get_option('aiomatic_posts_per_page', 12);
   $max_pages = ceil($rules_count/$rules_per_page);
   if($max_pages == 0)
   {
       $max_pages = 1;
   }
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
   {
      ?>
<h1><?php echo esc_html__("You must add an OpenAI/AiomaticAPI API Key into the plugin's 'Settings' menu before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
   ?>
<div class="wp-header-end"></div>
<div class="wrap">
   <h1><?php echo esc_html__("Keywords/Titles To Blog Posts", 'aiomatic-automatic-ai-content-writer');?></h1>
</div>
<?php
$max_execution = ini_get('max_execution_time');
if($max_execution != 0 && $max_execution < 1000)
{
    ?>
    <div class="notice notice-error">
        <p class="cr_red">
            <?php echo sprintf( wp_kses( __( "Warning! Your PHP INI max_execution_time is less than 1000 seconds (%s). This means that the plugin's execution will be forcefully stopped by your server after this amount of seconds. Please increase it to ensure that the plugin functions properly. Please check details on server settings, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_html($max_execution), esc_url_raw( get_admin_url() . 'admin.php?page=aiomatic_logs#tab-2' ) );?>
        </p>
    </div>
    <?php
}
?>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <form id="myForm" method="post" action="<?php echo (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">
         <?php
            wp_nonce_field('aiomatic_save_rules', '_aiomaticr_nonce');
            
            if (isset($_GET['settings-updated'])) {
            ?>
         <div>
            <p class="cr_saved_notif"><strong><?php echo esc_html__("Settings saved.", 'aiomatic-automatic-ai-content-writer');?></strong></p>
         </div>
         <?php
            }
            ?>
         <div>
            <div class="hideMain">
               <hr/>
               <div class="table-responsive">
                  <table id="mainRules" class="responsive table cr_main_table">
                     <thead>
                        <tr>
                           <th class="cr_width_160">
                              <?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the rule.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <span id="aiomatic_mode_sel"><?php echo esc_html__("Post Creation Mode", 'aiomatic-automatic-ai-content-writer');?>*</span>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("The main difference between the Topic Based and Title Based posting mode is that the Topic Based mode will make a separate API request for each chapter of the content (+intro, outro, q&a) and compose the article from the result of each of these separate API requests. While the Title Based posting will make a single API request for the entire post content. For longer articles, it is recommended you use the Topic Based Posting method.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <span id="aiomatic_mode_title"><?php echo esc_html__("Post Title List / TXT File URL / RSS Feed URL", 'aiomatic-automatic-ai-content-writer');?>*</span>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Input your desired post titles (one per line), a TXT file with titles (one per line) or a RSS feed URL. The plugin will select a random post title at each run. Nested spintax supported. You can also enter RSS feed URLs, from where the plugin will extract a random post title, each time it runs. If you set a RSS feed URL, an item will be randomly selected from the title/description/content of the RSS feed contents - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Schedule", 'aiomatic-automatic-ai-content-writer');?>*
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       $unlocker = get_option('aiomatic_minute_running_unlocked', false);
                                       if($unlocker == '1')
                                       {
                                           echo esc_html__("Select the interval in minutes after which you want this rule to run. Defined in minutes.", 'aiomatic-automatic-ai-content-writer');
                                       }
                                       else
                                       {
                                           echo esc_html__("Select the interval in hours after which you want this rule to run. Defined in hours.", 'aiomatic-automatic-ai-content-writer');
                                       }
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("# Of Posts", 'aiomatic-automatic-ai-content-writer');?>*
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the maximum number of posts that this rule can create at once.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("More Options", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Shows advanced settings for this rule.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_width_60">
                              <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to delete this rule?", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_width_60">
                              <?php echo esc_html__("Active", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to enable this rule? You can deactivate any rule (you don't have to delete them to deactivate them).", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                              <br/>
                              <input type="checkbox" onchange="thisonChangeHandler(this)" id="exclusion">
                           </th>
                           <th class="cr_width_160">
                              <?php echo esc_html__("Info", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("The number of items (posts, pages) this rule has generated so far.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_actions">
                              <?php echo esc_html__("Actions", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to run this rule now? Note that only one instance of a rule is allowed at once.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                        </tr>
                        
                     </thead>
                     <tbody>
                        <?php
                           echo aiomatic_expand_rules_manual();
                           if(isset($_GET['aiomatic_page']))
                           {
                              $current_page = $_GET['aiomatic_page'];
                           }
                           else
                           {
                              $current_page = '';
                           }
                           if($current_page == '' || (is_numeric($current_page) && $current_page == $max_pages))
                           {
                           ?>
                        
                        <tr>
                           <td class="cr_short_td"><input type="text" name="aiomatic_rules_list[rule_description][]" id="rule_description" class="cr_center" placeholder="Rule ID" value="" class="cr_width_full"/></td>
                           <td class="cr_width_80 cr_center"><select autocomplete="off" id="posting_mode" name="aiomatic_rules_list[posting_mode][]" class="cr_width_full">
                              <option value="topic" selected><?php echo esc_html__("Topic Based/Multiple API Calls", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="title"><?php echo esc_html__("Title Based/Single API Call", 'aiomatic-automatic-ai-content-writer');?></option>
                           </select> 
                           </td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_rules_list[post_title][]" placeholder="Please insert your post titles/TXT file URL/RSS feed URLs/%%ai_generated_title%% shortcode" class="cr_width_full"></textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" name="aiomatic_rules_list[schedule][]" max="8765812" class="cr_width_60" placeholder="Select the rule schedule interval" value="24"/></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" name="aiomatic_rules_list[max][]" class="cr_width_60" placeholder="Select the # of generated posts" value="1" /></td>
                           <td class="cr_width_70 cr_center">
                              <input type="button" id="mybtnfzr" value="Settings">
                              <div id="mymodalfzr" class="codemodalfzr">
                                 <div class="codemodalfzr-content">
                                    <div class="codemodalfzr-header">
                                       <span id="aiomatic_close" class="codeclosefzr">&times;</span>
                                       <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
                                    </div>
                                    <div class="codemodalfzr-body">
                                       <div class="table-responsive">
                                          <table class="responsive table cr_main_table_nowr">
                                             <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td><select id="assistant_id" name="aiomatic_rules_list[assistant_id][]" class="cr_width_full" onchange="assistantSelected('');">
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
        echo '<option value="" selected';
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
                                                </td>
                                             </tr>
                                             <tr class="hidetopic"><td colspan="2">
                                                  <h3><?php echo esc_html__("Topic Based Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("If you set a post topic here, the titles you entered in the 'Post Title List' settings field will not be considered and titles will be auto generated based on this topic! Be sure to edit the 'Title Prompt' settings from below to change the way titles will be created! Enter a post topic list, one on each line. If you leave this field blank, the titles from entered in the 'Post Title List' settings field will be used. If you enter a value here, new titles will be created, based on this topic and the values from the 'Post Title List' will be overwritten. If you enter multiple topics (one per line), a random topic will be selected at each run. This will set the value of the %%topic%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Generate Post Title Based On Topics (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[post_topic_list][]" placeholder="Post topic list (one per line)" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the method to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Title Generator Method:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="title_generator_method" name="aiomatic_rules_list[title_generator_method][]">
                                                <option value="ai" selected><?php echo esc_html__("AI Writer", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="serp"><?php echo esc_html__("Related SERP Searches", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. You can use here the %%topic%% shortcode, to get the value of the above topic, automtically. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Sections List (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[post_sections_list][]" placeholder="Post sections list (one per line)" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter the number of sections to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Number Of Content Sections To Generate:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <input type="text" id="section_count" name="aiomatic_rules_list[section_count][]" placeholder="3-4" class="cr_width_full" value="3-4">  
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select what you want to do with sections in articles.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Sections To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="sections_role" name="aiomatic_rules_list[sections_role][]">
                                                <option value="h2" selected><?php echo esc_html__("h2", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="h3"><?php echo esc_html__("h3", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="b"><?php echo esc_html__("Bold", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="i"><?php echo esc_html__("Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="bi"><?php echo esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="p"><?php echo esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="x"><?php echo esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="no"><?php echo esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Number Of Paragraphs Per Section:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <input type="text" id="paragraph_count" name="aiomatic_rules_list[paragraph_count][]" placeholder="2-3" class="cr_width_full" value="2">  
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the number of related images to add to the created post content. This feature will use the royalty free image sources configured in the plugin's 'Settings' menu or if you have access to the DallE API. You can change image source in the 'AI Image Source' settings field from below. The maximum number of images you can add to each article: number of sections + 2", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Number of Images To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_rules_list[topic_images][]" value="" placeholder="Number of images" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add an image to each of the creating headings from the article.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add An Image To Each Heading Of The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="img_all_headings" name="aiomatic_rules_list[img_all_headings][]" checked>
                                                </td>
                                             </tr> 
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the location of the heading images/videos.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Heading Image/Video Location:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="heading_img_location" name="aiomatic_rules_list[heading_img_location][]" class="cr_width_full">
                                                   <option value="top" selected><?php echo esc_html__("Top of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="heading"><?php echo esc_html__("Under the heading text", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="bottom"><?php echo esc_html__("Bottom of the section", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="random"><?php echo esc_html__("Random", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the number of related YouTube videos to add to the created post content. The maximum number of videos you can add to each article: number of sections", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Number of YouTube Videos To Add To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" name="aiomatic_rules_list[topic_videos][]" value="" placeholder="Number of videos" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Outro Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_rules_list[title_outro][]" value="{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}" placeholder="Optional" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr class="hidetopic">
                                                <td class="hideTOC-1">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Article Table Of Contents:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td class="hideTOC-1">
                                                <input type="checkbox" id="enable_toc" name="aiomatic_rules_list[enable_toc][]">
                                                </td>
                                             </tr> 
                                             <tr class="hidetopic">
                                                <td class="hideTOC-1">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Table Of Contents Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td class="hideTOC-1">
                                                <input type="text" name="aiomatic_rules_list[title_toc][]" value="Table of Contents" placeholder="Table of Contents" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Article Q&A Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_qa" name="aiomatic_rules_list[enable_qa][]">
                                                </td>
                                             </tr> 
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Q&A Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_rules_list[title_qa][]" value="Q&A" placeholder="Q&A" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr class="hidetopic"><td colspan="2">
                                                  <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Content Language:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input id="content_language" name="aiomatic_rules_list[content_language][]" type="text" list="languages" placeholder="Created content language" class="coderevolution_gutenberg_input" value="English"/>
							<datalist id="languages">
<?php
foreach($aiomatic_language_names as $ln)
{
	echo '<option>' . $ln . '</option>';
}
?>
							</datalist>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Writing Style:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input id="writing_style" name="aiomatic_rules_list[writing_style][]" type="text" placeholder="Created content writing style" list="writing_styles" class="coderevolution_gutenberg_input" value="Creative"/>
                                                <datalist id="writing_styles">
<option>Informative</option>
<option>Academic</option>
<option>Descriptive</option>
<option>Detailed</option>
<option>Dramative</option>
<option>Fiction</option>
<option>Expository</option>
<option>Historical</option>
<option>Dialogue</option>
<option>Creative</option>
<option>Critical</option>
<option>Narrative</option>
<option>Persuasive</option>
<option>Reflective</option>
<option>Argumentative</option>
<option>Analytical</option>
<option>Blog</option>
<option>News</option>
<option>Casual</option>
<option>Pastoral</option>
<option>Personal</option>
<option>Poetic</option>
<option>Satirical</option>
<option>Sensory</option>
<option>Articulate</option>
<option>Monologue</option>
<option>Colloquial</option>
<option>Comparative</option>
<option>Concise</option>
<option>Biographical</option>
<option>Anecdotal</option>
<option>Evaluative</option>
<option>Letter</option>
<option>Lyrical</option>
<option>Simple</option>
<option>Vivid</option>
<option>Journalistic</option>
<option>Technical</option>
<option>Direct</option>
<option>Emotional</option>
<option>Metaphorical</option>
<option>Objective</option>
<option>Rhetorical</option>
<option>Theoretical</option>
<option>Business</option>
<option>Report</option>
<option>Research</option>
</datalist>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Writing Tone:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input id="writing_tone" name="aiomatic_rules_list[writing_tone][]" type="text" list="writing_tones" placeholder="Created content writing tone" class="coderevolution_gutenberg_input" value="Neutral"/>
                                                <datalist id="writing_tones">
<option>Neutral</option>
<option>Formal</option>
<option>Assertive</option>
<option>Cheerful</option>
<option>Humorous</option>
<option>Informal</option>
<option>Inspirational</option>
<option>Professional</option>
<option>Emotional</option>
<option>Persuasive</option>
<option>Supportive</option>
<option>Sarcastic</option>
<option>Condescending</option>
<option>Skeptical</option>
<option>Narrative</option>
<option>Journalistic</option>
<option>Conversational</option>
<option>Factual</option>
<option>Friendly</option>
<option>Polite</option>
<option>Scientific</option>
<option>Sensitive</option>
<option>Sincere</option>
<option>Curious</option>
<option>Dissapointed</option>
<option>Encouraging</option>
<option>Optimistic</option>
<option>Surprised</option>
<option>Worried</option>
<option>Confident</option>
<option>Authoritative</option>
<option>Nostalgic</option>
<option>Sympathetic</option>
<option>Suspenseful</option>
<option>Romantic</option>
<option>Serious</option>
</datalist>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic"><td colspan="2">
                                                  <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[title_prompt][]" placeholder="Enter your title prompts, one per line" class="cr_width_full">Write a title for an article about "%%topic%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Title Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_title_model" name="aiomatic_rules_list[topic_title_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[intro_prompt][]" placeholder="Enter your intro prompts, one per line" class="cr_width_full">Craft an introduction for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Intro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_intro_model" name="aiomatic_rules_list[topic_intro_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the Sections of the article. These will be set also as headings in the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Sections Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[sections_prompt][]" placeholder="Enter your sections prompts, one per line" class="cr_width_full">Write %%sections_count%% consecutive headings for an article about "%%title%%" that highlight specific aspects, provide detailed insights and specific recommendations. The headings must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don't add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the sections generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Sections Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_sections_model" name="aiomatic_rules_list[topic_sections_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%title%%, %%article_so_far%%, %%last_section_content%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%current_section%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="3" cols="70" name="aiomatic_rules_list[content_prompt][]" placeholder="Enter your content prompt" class="cr_width_full">Write the content of a post section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%title%%". Don't add the title at the beginning of the created content. Be creative and unique. Don't repeat the heading in the created content. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Act as a Content Writer, not as a Virtual Assistant. Return only the content requested, without any additional comments or text. The content provided will be automatically published on my website. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Content Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_content_model" name="aiomatic_rules_list[topic_content_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to use the above content prompt to create the entire article from a single API call (checkbox checked) or to run the prompt for each section separately (checkbox unchecked). If you check this, be sure to modify the content prompt accordingly.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Use the Above Content Prompt To Create The Entire Article (Not Each Section):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="single_content_call-1" name="aiomatic_rules_list[single_content_call][]" onclick="hideTOC(-1);">
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[qa_prompt][]" placeholder="Enter your Q&A prompts, one per line" class="cr_width_full">Write a Q&A for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Q&A Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_qa_model" name="aiomatic_rules_list[topic_qa_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[outro_prompt][]" placeholder="Enter your outro prompts, one per line" class="cr_width_full">Write an outro for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Outro Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_outro_model" name="aiomatic_rules_list[topic_outro_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[excerpt_prompt][]" placeholder="Enter your excerpt prompts, one per line" class="cr_width_full">Write a short excerpt for an article about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Excerpt Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_excerpt_model" name="aiomatic_rules_list[topic_excerpt_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetopic"><td colspan="2">
                                                  <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Run Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[strip_by_regex_prompts][]" placeholder="regex expression"></textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[replace_regex_prompts][]" placeholder="regex replacement"></textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetopic">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input id="run_regex_on" name="aiomatic_rules_list[run_regex_on][]" type="text" list="run_regex_on_list" class="coderevolution_gutenberg_input" value="content"/>
							<datalist id="run_regex_on_list">
                     <option value="title">title</option>
                     <option value="intro">intro</option>
                     <option value="sections">sections</option>
                     <option value="content">content</option>
                     <option value="qa">Q&A</option>
                     <option value="outro">outro</option>
                     <option value="excerpt">excerpt</option>
							</datalist> 
                                                </td>
                                             </tr>
                                             <tr class="hidetitle"><td colspan="2">
                                                  <h3><?php echo esc_html__("Title Based Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                          <tr class="hidetitle"><td colspan="2">
                                                  <h4><?php echo esc_html__("Post Content - AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr class="hidetitle">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for text generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="model" name="aiomatic_rules_list[model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to OpenAI/AiomaticAPI. This command can be any given task or order, based on which, it will generate content for posts. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[ai_command][]" placeholder="Please insert a command for the AI" class="cr_width_full">Write a comprehensive and SEO-optimized article on the topic of "%%post_title%%". Incorporate relevant keywords naturally throughout the article to enhance search engine visibility. This article must provide valuable information to readers and be well-structured with proper headings, bullet points, and HTML formatting. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. 

Add an introductory and a conclusion section to the article. You can add also some other sections, when they fit the article's subject, like: benefits and practical tips, case studies, first had experience.

Please ensure that the article is at least 1200 words in length and adheres to best SEO practices, including proper header tags (H1, H2, H3), meta title, and meta description.

Feel free to use a friendly, conversational tone and make the article as informative and engaging as possible while ensuring it remains factually accurate and well-researched.

Act as a Content Writer, not as a Virtual Assistant. Return only the content requested, without any additional comments or text. The content provided will be automatically published on my website.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo sprintf( wp_kses( __( "Select the minimum number of characters that the posts should have. If the API returns content which has fewer characters than this number, another API call will be made, until this character limit is met. Please check about API rate limiting <a href='%s'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://beta.openai.com/docs/api-reference/introduction' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Content Minimum Character Count:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="1" step="1" name="aiomatic_rules_list[min_char][]" value="500" placeholder="Please insert a minimum number of characters for posts" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidetitle"><td colspan="2">
                                                  <h4><?php echo esc_html__("Post Title - AI Text Generator Options (%%ai_generated_title%% shortcode)", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("The %%ai_generated_title%% shortcode can be used in the 'Post Title List / TXT File URL / RSS Feed URL' settings field, to get partial or fully AI generated titles.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div></h4>
                                             </td></tr>
                                             <tr class="hidetitle">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for title text generator. You can add this to the post titles, using the %%ai_generated_title%% shortcode.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Title Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="title_model" name="aiomatic_rules_list[title_model][]" class="hideAssistant cr_width_full">
                                                <?php
                                                      foreach($all_models as $modelx)
                                                      {
                                                         echo '<option value="' . $modelx .'"';
                                                         echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                                                      }
                                                      ?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to AI for generating post titles. This command can be any given task or order, based on which, it will generate content for posts. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Title Text Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[title_ai_command][]" placeholder="Please insert a command for the AI" class="cr_width_full">Craft an attention-grabbing and SEO-optimized article title for a dental health blog. This title must be concise, informative, and designed to pique the interest of readers while clearly conveying the topic of the article.</textarea>
                                                </td>
                                             </tr><tr class="hidetitle">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the source of the post title. If you select AI generated, the plugin will create an AI generated title based on keywords you enter in the 'Post Title List' settings field. Otherwise, it will use the titles listed there, for the created posts.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Title Source:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="title_source" name="aiomatic_rules_list[title_source][]" class="cr_width_full">
                                                   <option value="keyword" selected><?php echo esc_html__("Use The Titles From The 'Post Title List' Settings Field", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="ai"><?php echo esc_html__("Fully AI Generated Titles", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr class="hidetitle"><td colspan="2">
                                                  <h4><?php echo esc_html__("Rich Content Creation Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the maximum number of related headings to add to the created post content. This feature will use the 'People Also Ask' feature from Google and Bing. By default, the Bing engine is scraped, if you want to enable also Google scraping, add a SerpAPI key in the plugin's 'Settings' menu -> 'SerpAPI API Key' settings field.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Number Of Related Headings to Add To The Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" name="aiomatic_rules_list[headings][]" value="" placeholder="Max heading count" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for headings generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For The Headings Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="headings_model" name="aiomatic_rules_list[headings_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>  
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the prompt you will use when searching for related headings. You can use the following shortcodes: %%post_title%%, %%needed_heading_count%%. The same model will be used, as the one selected for content creation. If you leave this field blank, the default prompt will be used: 'Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%' You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Related Headings AI Generator Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[headings_ai_command][]" placeholder="Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%" class="cr_width_full">Generate %%needed_heading_count%% People Also Ask (PAA) related questions, each on a new line, that are relevant to the topic of the post title: "%%post_title%%".</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the maximum number of related images to add to the created post content. This feature will use the 'Royalty Free Image' settings from the plugin's 'Settings' menu or if you have access to the DallE API.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Number Of Related Images to Add To The Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" name="aiomatic_rules_list[images][]" value="" placeholder="Max image count" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Add a related YouTube video to the end of to the created post content. This feature will require you to add at least one YouTube API key in the plugin's 'Settings' -> 'YouTube API Key List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add A Related Video To The End Of The Post:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="videos" name="aiomatic_rules_list[videos][]">
                                                </td>
                                             </tr>
                                          <tr class="hidetitle"><td colspan="2">
                                                  <h4><?php echo esc_html__("Manual Headings and Images List", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Add a list of headings (one on each line) to use in the generated articles. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Manual List Of Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[headings_list][]" placeholder="List of headings" class="cr_width_full"></textarea>
                                                </td>
                                             </tr><tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Add a list of image URLs (one on each line) to use in the generated articles. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Manual List Of Images:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[images_list][]" placeholder="List of images" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[global_prepend][]" placeholder="Global prompt prepend text" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[global_append][]" placeholder="Global prompt append text" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Automatic Linking Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Automatic Linking Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="link_type" onchange="hideLinks('');" name="aiomatic_rules_list[link_type][]">
                                                <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="internal"><?php echo esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="manual"><?php echo esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="mixed"><?php echo esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Number Of Automatic Links To Add To The Post Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_rules_list[max_links][]" placeholder="Add the number of links to enable this feature" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidelinks">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Manual List Of URLs (One Per Line):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="aiomatic_rules_list[link_list][]" placeholder="URL list (one per line)" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr class="hidelinks">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Nofollow Attribute To Manual Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="link_nofollow" name="aiomatic_rules_list[link_nofollow][]">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Types Where To Generate Automatic Links:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_rules_list[link_post_types][]" placeholder="post" class="cr_width_full">
                                                </td>
                                             </tr>
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Post Category Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to automatically add post categories from the generated items?", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Add Categories:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="auto_categories" name="aiomatic_rules_list[auto_categories][]">
                                                <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="ai"><?php echo esc_html__("AI Generated", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="hashtags"><?php echo esc_html__("Title", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="content"><?php echo esc_html__("Content", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="both"><?php echo esc_html__("Title and Content", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for category generator. You can add this to the post categories, if you select 'AI Generated Categories' in the 'Auto Add Categories' settings field.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Category Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="category_model" name="aiomatic_rules_list[category_model][]" class="hideAssistant cr_width_full">
                                                <?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>  
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to AI for generating post categories. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Category Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[category_ai_command][]" placeholder="Write a comma separated list of categories, for the post title: %%post_title%%" class="cr_width_full">Generate a comma-separated list of relevant categories for the post title: "%%post_title%%". These categories must accurately categorize the article within the broader topics or themes of your blog, aiding in the organization and navigation of your content.</textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post category that you want for the automatically generated posts to have.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Post Category:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                             <select multiple id="default_category" name="aiomatic_rules_list[default_category][]" class="cr_width_full" onmouseover="this.size=this.length;" onmouseout="this.size=4;">
                                             <option value="aiomatic_no_category_12345678" selected><?php echo esc_html__("Do Not Add a Category", 'aiomatic-automatic-ai-content-writer');?></option>
                                             <?php
                                                $cat_args   = array(
                                                    'orderby' => 'name',
                                                    'hide_empty' => 0,
                                                    'order' => 'ASC'
                                                );
                                                $categories = get_categories($cat_args);
                                                foreach ($categories as $category) {
                                                ?>
                                             <option value="<?php
                                                echo esc_html($category->term_id);
                                                ?>"><?php
                                                echo sanitize_text_field($category->name) . ' - ID ' . $category->term_id;
                                                ?></option>
                                             <?php
                                                }
                                                ?>
                                             </select>   
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This feature will try to remove the WordPress's default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Remove WP Default Post Category:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="remove_default" name="aiomatic_rules_list[remove_default][]" checked>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This option will make the plugin not create categories which are not already existing on your site. For best results in this case, be sure to add to the prompt the list of categories from where the AI should select.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Do Not Add Inexistent Categories:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="skip_inexist" name="aiomatic_rules_list[skip_inexist][]" checked>
                                                </td>
                                             </tr>
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Post Tag Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to automatically add post tags from the generated items?", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Add Tags:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="auto_tags" name="aiomatic_rules_list[auto_tags][]">
                                                <option value="disabled" selected><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="ai"><?php echo esc_html__("AI Generated", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="hashtags"><?php echo esc_html__("Title", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="content"><?php echo esc_html__("Content", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="both"><?php echo esc_html__("Title and Content", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select> 
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for tag generator. You can add this to the post tags, if you select 'AI Generated Tags' in the 'Auto Add Tags' settings field.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Post Tag Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="tag_model" name="aiomatic_rules_list[tag_model][]" class="hideAssistant cr_width_full">
<?php
foreach($all_models as $modelx)
{
   echo '<option value="' . $modelx .'"';
   echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}
?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to AI for generating post tags. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Post Tag Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[tag_ai_command][]" placeholder="Write a comma separated list of tags, for the post title: %%post_title%%" class="cr_width_full">Generate a comma-separated list of relevant tags for the post title: "%%post_title%%". These tags must accurately reflect the key topics, themes, or keywords associated with the article and help improve its discoverability and organization.</textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post tags that you want for the automatically generated posts to have. Spintax supported.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Post Tags:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_rules_list[default_tags][]" value="" placeholder="Please insert your additional post tags here" class="cr_width_full">
                                                </td>
                                             </tr>
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Advanced AI Text Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Total Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="1" max="128000" name="aiomatic_rules_list[max_tokens][]" value="" placeholder="32768" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Prompt Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="1" max="128000" name="aiomatic_rules_list[max_seed_tokens][]" value="" placeholder="1000" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr class="hidetitle">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Continue Token Count To Use Per API Request:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="1" max="128000" name="aiomatic_rules_list[max_continue_tokens][]" value="" placeholder="500" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Temperature:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" step="0.1" max="2" name="aiomatic_rules_list[temperature][]" value="" placeholder="1" class="cr_width_full">
                                                </td>
                                             </tr><tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Top_p:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" max="1" step="0.1" name="aiomatic_rules_list[top_p][]" value="" placeholder="1" class="cr_width_full">
                                                </td>
                                             </tr><tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Presence Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="-2" step="0.1" max="2" name="aiomatic_rules_list[presence_penalty][]" value="" placeholder="0" class="cr_width_full">
                                                </td>
                                             </tr><tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Frequency Penalty:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" max="2" step="0.1" name="aiomatic_rules_list[frequency_penalty][]" value="" placeholder="0" class="cr_width_full">
                                                </td>
                                             </tr>
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Image Generator Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                          <tr>
                                             <td>
                                                <div>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Do you want to set a featured image for the created post (royalty free or AI generated)? Please note that for this feature to function you must configure the plugin (add API keys) in the plugin's 'Settings' menu -> 'Royalty Free Featured Image Importing Options' section.", 'aiomatic-automatic-ai-content-writer');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Auto Set A Featured Image For Posts (Select Source Below):", 'aiomatic-automatic-ai-content-writer');?></b>
                                             </td>
                                             <td>
                                             <input type="checkbox" id="royalty_free" name="aiomatic_rules_list[royalty_free][]" checked>
                                             </td>
                                          </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Search Query Repetition:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" id="search_query_repetition" name="aiomatic_rules_list[search_query_repetition][]" class="cr_width_full">
                                                   <option value="0" selected><?php echo esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="1"><?php echo esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Image Source:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" id="enable_ai_images" onchange="hideImage('');" name="aiomatic_rules_list[enable_ai_images][]" class="cr_width_full">
                                                   <option value="0" selected><?php echo esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="1"><?php echo esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <?php
                                                   if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '')
                                                   {
                                                   ?>
                                                   <option value="2"><?php echo esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <?php
                                                   }
                                                   if (isset($aiomatic_Main_Settings['midjourney_app_id']) && trim($aiomatic_Main_Settings['midjourney_app_id']) != '')
                                                   {
                                                   ?>
                                                   <option value="4"><?php echo esc_html__("Midjourney", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <?php
                                                   }
                                                   ?>
                                                   <option value="3"><?php echo esc_html__("Manual URL List", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr class="hideImg cr_none">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%topic%%, %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[ai_command_image][]" placeholder="Please insert a command for the AI image generator" class="cr_width_full">Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.</textarea>
                                                </td>
                                             </tr>
                                             <tr class="hideDalle cr_none">
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Image Model:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" id="image_model" name="aiomatic_rules_list[image_model][]" class="cr_width_full">
                                                   <option value="dalle2"selected><?php echo esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="dalle3"><?php echo esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="dalle3hd"><?php echo esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr class="hideImg cr_none">
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Image Size:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="model" name="aiomatic_rules_list[image_size][]" class="cr_width_full">
                                                   <option value="256x256"><?php echo esc_html__("256x256 (only for Dall-E 2)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="512x512"><?php echo esc_html__("512x512 (only for Dall-E 2 & Stable Diffusion)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="1024x1024" selected><?php echo esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="1792x1024"><?php echo esc_html__("1792x1024 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="1024x1792"><?php echo esc_html__("1024x1792 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>  
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Insert a comma separated list of links to valid images that will be set randomly for the featured image for the posts that do not have a valid image attached or if you disabled automatical featured image generator. You can also use image numeric IDs from images found in the Media Gallery. To disable this feature, leave this field blank. Spintax supported. You can also use the %%random_image[keyword]%% shortcode to automatically import a random image from Google Image Search with the Creative Commons filter applied. To get a related image, you can also use: %%random_image[%%post_title%%]%%", 'aiomatic-automatic-ai-content-writer');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Default Featured Image List:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                   <textarea rows="1" class="cr_width_60p" name="aiomatic_rules_list[image_url][]" placeholder="Please insert the link to a valid image (spintax supported)"></textarea>
                                                   <input class="cr_width_33p aiomatic_image_button" type="button" value=">>>"/>
                                                </td>
                                             </tr>
                                             <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[post_prepend][]" placeholder="HTML content to prepend to the AI generated content" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[post_append][]" placeholder="HTML content to append to the AI generated content" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Custom Shortcode Creator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b><span class="tool" data-tip="Supported models: <?php echo implode(',', aiomatic_get_all_models());?>">&nbsp;&#9432;</span>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_rules_list[custom_shortcodes][]" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Strip Title From Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="strip_title" name="aiomatic_rules_list[strip_title][]">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Do Not Spin Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="skip_spin" name="aiomatic_rules_list[skip_spin][]">               
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer');?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Do Not Translate Posts Generated By This Rule:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="skip_translate" name="aiomatic_rules_list[skip_translate][]">               
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to process each title from the added list only once.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Process Each Title/Topic Only Once:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="title_once" name="aiomatic_rules_list[title_once][]" checked>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to overwrite existing posts during the publishing process.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Overwrite Existing Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="overwrite_existing" name="aiomatic_rules_list[overwrite_existing][]">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Run Regex On Content:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[strip_by_regex][]" placeholder="regex expression"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[replace_regex][]" placeholder="regex replacement"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the author that you want to assign for the automatically generated posts.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Author:", 'aiomatic-automatic-ai-content-writer');?></b>  
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="post_author" name="aiomatic_rules_list[post_author][]" class="cr_width_full">
                                                <option value="rand"><?php echo esc_html__("Random user", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <?php
                                                   $blogusers = get_users( [ 'role__in' => [ 'contributor', 'author', 'editor', 'administrator' ] ] );
                                                   foreach ($blogusers as $user) {
                                                       echo '<option value="' . esc_html($user->ID) . '"';
                                                       echo '>' . esc_html($user->display_name) . '</option>';
                                                   }
                                                   ?>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the status that you want for the automatically generated posts to have.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Status:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="submit_status" name="aiomatic_rules_list[submit_status][]" class="cr_width_full">
                                                <option value="pending"><?php echo esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="draft"><?php echo esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="publish" selected><?php echo esc_html__("Published", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="private"><?php echo esc_html__("Private", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="trash"><?php echo esc_html__("Trash", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select> 
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the type (post/page) for your automatically generated item.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Item Type:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="default_type" name="aiomatic_rules_list[default_type][]" class="cr_width_full">
                                                <?php
                                                   $is_first = true;
                                                   foreach ( get_post_types( '', 'names' ) as $post_type ) {
                                                      if(strstr($post_type, 'aiomatic_'))
                                                      {
                                                         continue;
                                                      }
                                                      echo '<option value="' . esc_attr($post_type) . '"';
                                                      if($is_first === true)
                                                      {
                                                          echo ' selected';
                                                          $is_first = false;
                                                      }
                                                      echo '>' . esc_html($post_type) . '</option>';
                                                   }
                                                   ?>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("If your template supports 'Post Formats', than you can select one here. If not, leave this at it's default value.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Format:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="post_format" name="aiomatic_rules_list[post_format][]" class="cr_width_full">
                                                <option value="post-format-standard"  selected><?php echo esc_html__("Standard", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-aside"><?php echo esc_html__("Aside", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-gallery"><?php echo esc_html__("Gallery", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-link"><?php echo esc_html__("Link", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-image"><?php echo esc_html__("Image", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-quote"><?php echo esc_html__("Quote", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-status"><?php echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-video"><?php echo esc_html__("Video", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-audio"><?php echo esc_html__("Audio", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="post-format-chat"><?php echo esc_html__("Chat", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>    
                                                </td>
                                             </tr>
                                          <tr>
                                             <td>
                                                <div>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Set the ID of the parent of created posts. This is useful for BBPress integration, to assign forum IDs for created topics or for other similar functionalities.", 'aiomatic-automatic-ai-content-writer');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Post Parent ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                                             </td>
                                             <td>
                                             <input type="number" min="1" class="cr_width_full" name="aiomatic_rules_list[parent_id][]" value="" placeholder="Post parent ID">
                                             </td>
                                          </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable comments for the generated posts?", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Enable Comments For Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_comments" name="aiomatic_rules_list[enable_comments][]" checked>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable pingbacks/trackbacks for the generated posts?", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Enable Pingback/Trackback:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_pingback" name="aiomatic_rules_list[enable_pingback][]" checked>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo sprintf( wp_kses( __( "Do you want to set a custom post publish date for posts? Set the range in the below field Accepted values for this field are listed: <a href='%s' target='_blank'>here</a>. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( 'https://www.php.net/manual/en/datetime.formats.php' ) );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Set a Custom Post Publish Date Range:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" id="min_time" name="aiomatic_rules_list[min_time][]" placeholder="Start time" class="cr_half"> - <input type="text" id="max_time" name="aiomatic_rules_list[max_time][]" placeholder="End time" class="cr_half">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text_top cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Custom Fields:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="aiomatic_rules_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%post_title%%" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text_top cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . You can also set hierarhical taxonomies (parent > child), in this format: custom_taxonomy_name => parent1 > child1 . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Custom Taxonomies:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="aiomatic_rules_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%post_title%%" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                          <tr>
                                             <td>
                                                <div>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text_top cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Enter a 2 letter language code that will be assigned as the WPML/Polylang language for posts. Example: for German, input: de", 'aiomatic-automatic-ai-content-writer');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Assign WPML/Polylang Language to Posts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                             </td>
                                             <td>
                                             <input type="text" class="cr_width_full" name="aiomatic_rules_list[wpml_lang][]" value="" placeholder="WPML/Polylang language">
                                             </td>
                                          </tr>
                                             <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Scheduling Restrictions", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the days of the week when you don't want to run this rule. You can enter a comma separate list of day names.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Do Not Run This Rule On The Following Days Of The Week:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                      <br/><?php echo esc_html__("Current Server Time:", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . date('l', time()) . ', ' . date("Y-m-d H:i:s");?>
                                                </td>
                                                <td>
                                                <input type="text" class="cr_width_full" name="aiomatic_rules_list[days_no_run][]" value="" placeholder="Mo,Tu,We,Th,Fr,Sa,Su">  
                                                </td>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="codemodalfzr-footer">
                                       <br/>
                                       <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                                       <span id="aiomatic_ok" class="codeokfzr cr_inline">OK&nbsp;</span>
                                       <br/><br/>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_rules_list[active][]" value="1" checked />
                              <input type="hidden" name="aiomatic_rules_list[last_run][]" value="1988-01-27 00:00:00"/>
                           <input type="hidden" name="aiomatic_rules_list[rule_unique_id][]" value="<?php echo uniqid('', true);?>"/>
                           </td>
                           <td class="cr_short_td">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("No info.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_center">
                              <div>
                                 <img src="<?php
                                    echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');
                                    ?>" alt="Running" class="cr_running">
                                 <div class="codemainfzr cr_gray_back cr_width_80p">
                                    <select autocomplete="off" class="codemainfzr" id="actions" class="actions" name="actions" disabled>
                                       <option value="select" disabled selected><?php echo esc_html__("Select an Action", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="run" onclick=""><?php echo esc_html__("Run This Rule Now", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="duplicate" onclick=""><?php echo esc_html__("Duplicate This Rule", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="up" onclick=""><?php echo esc_html__("Move This Rule Up", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="down" onclick=""><?php echo esc_html__("Move This Rule Down", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="trash" onclick=""><?php echo esc_html__("Send All Posts To Trash", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="delete" onclick=""><?php echo esc_html__("Permanently Delete All Posts", 'aiomatic-automatic-ai-content-writer');?></option>
                                    </select>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     <?php
                        }
                        ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <hr/>
         
      <div>
         <?php
            $next_url = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($next_url, 'aiomatic_page=') === false)
            {
                if(stristr($next_url, '?') === false)
                {
                    if($max_pages == 1)
                    {
                        $next_url .= '?aiomatic_page=1';
                    }
                    else
                    {
                        $next_url .= '?aiomatic_page=2';
                    }
                }
                else
                {
                    if($max_pages == 1)
                    {
                        $next_url .= '&aiomatic_page=1';
                    }
                    else
                    {
                        $next_url .= '&aiomatic_page=2';
                    }
                }
            }
            else
            {
                if(isset($_GET['aiomatic_page']))
                {
                    $curent_page = $_GET["aiomatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $next_page = $curent_page + 1;
                    if($next_page > $max_pages)
                    {
                        $next_page = $max_pages;
                    }
                    if($next_page <= 0)
                    {
                        $next_page = 1;
                    }
                    $next_url = str_replace('aiomatic_page=' . $curent_page, 'aiomatic_page=' . $next_page, $next_url);
                }
                else
                {
                    if(stristr($next_url, '?') === false)
                    {
                        if($max_pages == 1)
                        {
                            $next_url .= '?aiomatic_page=1';
                        }
                        else
                        {
                            $next_url .= '?aiomatic_page=2';
                        }
                    }
                    else
                    {
                        if($max_pages == 1)
                        {
                            $next_url .= '&aiomatic_page=1';
                        }
                        else
                        {
                            $next_url .= '&aiomatic_page=2';
                        }
                    }
                }
            }
            $prev_url = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($prev_url, 'aiomatic_page=') === false)
            {
                if(stristr($prev_url, '?') === false)
                {
                    $prev_url .= '?aiomatic_page=1';
                }
                else
                {
                    $prev_url .= '&aiomatic_page=1';
                }
            }
            else
            {
                if(isset($_GET['aiomatic_page']))
                {
                    $curent_page = $_GET["aiomatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $go_to = $curent_page - 1;
                    if($go_to <= 0)
                    {
                        $go_to = 1;
                    }
                    if($go_to > $max_pages)
                    {
                        $go_to = $max_pages;
                    }
                    $prev_url = str_replace('aiomatic_page=' . $curent_page, 'aiomatic_page=' . $go_to, $prev_url);
                }
                else
                {
                    if(stristr($prev_url, '?') === false)
                    {
                        $prev_url .= '?aiomatic_page=1';
                    }
                    else
                    {
                        $prev_url .= '&aiomatic_page=1';
                    }
                }
            }
            $first_url = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($first_url, 'aiomatic_page=') === false)
            {
                if(stristr($first_url, '?') === false)
                {
                    $first_url .= '?aiomatic_page=1';
                }
                else
                {
                    $first_url .= '&aiomatic_page=1';
                }
            }
            else
            {
                if(isset($_GET['aiomatic_page']))
                {
                    $curent_page = $_GET["aiomatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $first_url = str_replace('aiomatic_page=' . $curent_page, 'aiomatic_page=1', $first_url);
                }
                else
                {
                    if(stristr($first_url, '?') === false)
                    {
                        $first_url .= '?aiomatic_page=1';
                    }
                    else
                    {
                        $first_url .= '&aiomatic_page=1';
                    }
                }
            }
            $last_url = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($last_url, 'aiomatic_page=') === false)
            {
                if(stristr($last_url, '?') === false)
                {
                    $last_url .= '?aiomatic_page=' . $max_pages;
                }
                else
                {
                    $last_url .= '&aiomatic_page=' . $max_pages;
                }
            }
            else
            {
                if(isset($_GET['aiomatic_page']))
                {
                    $curent_page = $_GET["aiomatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $last_url = str_replace('aiomatic_page=' . $curent_page, 'aiomatic_page=' . $max_pages, $last_url);
                }
                else
                {
                    if(stristr($last_url, '?') === false)
                    {
                        $last_url .= '?aiomatic_page=' . $max_pages;
                    }
                    else
                    {
                        $last_url .= '&aiomatic_page=' . $max_pages;
                    }
                }
            }
            if(isset($_GET['aiomatic_page']))
            {
                $this_page = $_GET["aiomatic_page"];
            }
            else
            {
                $this_page = '1';
            }
            echo '<center><a href="' . esc_url_raw($first_url) . '">' . esc_html__('First Page', 'aiomatic-automatic-ai-content-writer') . '</a>&nbsp;&nbsp;&nbsp;<a href="' . esc_url_raw($prev_url) . '">' . esc_html__('Previous Page', 'aiomatic-automatic-ai-content-writer') . '</a>&nbsp;&nbsp;' . esc_html__('Page', 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($this_page) . ' ' . esc_html__('of', 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($max_pages) . '&nbsp;-&nbsp;' . esc_html__("Rules Per Page:", 'aiomatic-automatic-ai-content-writer') . '&nbsp;&nbsp;<input class="cr_50" type="number" min="2" step="1" max="999" name="posts_per_page" value="' . esc_attr($rules_per_page). '" required/>&nbsp;&nbsp;&nbsp;<a href="' . esc_url_raw($next_url) . '">' . esc_html__('Next Page', 'aiomatic-automatic-ai-content-writer') . '</a>&nbsp;&nbsp;&nbsp;<a href="' . esc_url_raw($last_url) . '">' . esc_html__('Last Page', 'aiomatic-automatic-ai-content-writer') . '</a></center>
            <center></center>
            <center>Info: You can add new rules only on the last page.</center>';
            ?> 
         <div>
            <p class="crsubmit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'aiomatic-automatic-ai-content-writer');?>"/></p>
         </div>
         <div>
         <div><?php echo esc_html__("* = required", 'aiomatic-automatic-ai-content-writer');?></div><br/><?php echo sprintf( wp_kses( __( "Check more settings which apply to rule running, over at the plugin's 'Settings' menu, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( get_admin_url() . 'admin.php?page=aiomatic_admin_settings#tab-17' ) );?>
         <br/><?php echo esc_html__("New! You can use the [aicontent]Your Prompt[/aicontent] shortcode in this or other", 'aiomatic-automatic-ai-content-writer') . " <a href='https://1.envato.market/coderevolutionplugins' target='_blank'>" . esc_html__("'omatic plugins created by CodeRevolution", 'aiomatic-automatic-ai-content-writer') . "</a>" .  esc_html__(", click for details:", 'aiomatic-automatic-ai-content-writer');?>&nbsp;<a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-ai-generated-content-from-any-plugin-built-by-coderevolution/" target="_blank"><img src="https://i.ibb.co/gvTNWr6/artificial-intelligence-badge.png" alt="artificial-intelligence-badge" title="AI content generator support, when used together with the Aiomatic plugin"></a><br/><br/><a href="https://www.youtube.com/watch?v=5rbnu_uis7Y" target="_blank"><?php echo esc_html__("Nested Shortcodes also supported!", 'aiomatic-automatic-ai-content-writer');?></a><br/><br/><?php echo esc_html__("Confused about rule running status icons?", 'aiomatic-automatic-ai-content-writer');?> <a href="http://coderevolution.ro/knowledge-base/faq/how-to-interpret-the-rule-running-visual-indicators-red-x-yellow-diamond-green-tick-from-inside-plugins/" target="_blank"><?php echo esc_html__("More info", 'aiomatic-automatic-ai-content-writer');?></a><br/>
            <div class="cr_none" id="midas_icons">
               <table>
                  <tr>
                     <td><img id="run_img" src="<?php echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');?>" alt="Running" title="status"></td>
                     <td><?php echo esc_html__("In Progress", 'aiomatic-automatic-ai-content-writer');?> - <b><?php echo esc_html__("Importing is Running", 'aiomatic-automatic-ai-content-writer');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="ok_img" src="<?php echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/ok.gif');?>" alt="OK"  title="status"></td>
                     <td><?php echo esc_html__("Success", 'aiomatic-automatic-ai-content-writer');?> - <b><?php echo esc_html__("New Posts Created", 'aiomatic-automatic-ai-content-writer');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="fail_img" src="<?php echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/failed.gif');?>" alt="Faield" title="status"></td>
                     <td><?php echo esc_html__("Failed", 'aiomatic-automatic-ai-content-writer');?> - <b><?php echo esc_html__("An Error Occurred.", 'aiomatic-automatic-ai-content-writer');?> <b><?php echo esc_html__("Please check 'Activity and Logging' plugin menu for details.", 'aiomatic-automatic-ai-content-writer');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="nochange_img" src="<?php echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/nochange.gif');?>" alt="NoChange" title="status"></td>
                     <td><?php echo esc_html__("No Change - No New Posts Created", 'aiomatic-automatic-ai-content-writer');?> - <b><?php echo esc_html__("Possible reasons:", 'aiomatic-automatic-ai-content-writer');?></b></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td>
                        <ul>
                           <li>&#9658; <?php echo esc_html__("Please change rule settings, as your titles are all posted.", 'aiomatic-automatic-ai-content-writer');?></li>
                        </ul>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </form>
   </div>
    <div id="running_status_ai"></div>
</div>
<div class="wrap">
        <h3><?php echo esc_html__("Keywords/Titles To Blog Posts Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
        <div id="ai-video-container"><br/>
            <iframe class="ai-video" width="560" height="315" src="https://www.youtube.com/embed/dhWhsEIccPU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
<?php
   }
   if (isset($_POST['aiomatic_rules_list'])) {
       add_action('admin_init', 'aiomatic_save_rules_manual');
   }
   
   function aiomatic_save_rules_manual($data2)
   {
       $init_rules_per_page = get_option('aiomatic_posts_per_page', 12);
       $rules_per_page = get_option('aiomatic_posts_per_page', 12);
       if(isset($_POST['posts_per_page']))
       {
           update_option('aiomatic_posts_per_page', $_POST['posts_per_page']);
       }
       check_admin_referer('aiomatic_save_rules', '_aiomaticr_nonce');
       
       $data2 = $_POST['aiomatic_rules_list'];
       $rules = get_option('aiomatic_rules_list', array());
       if(!is_array($rules))
       {
          $rules = array();
       }
       $initial_count = count($rules);
       $add = false;
       $scad = false;
       if(isset($_GET["aiomatic_page"]) && is_numeric($_GET["aiomatic_page"]))
       {
           $curent_page = $_GET["aiomatic_page"];
       }
       else
       {
           $curent_page = 1;
       }
       $offset = ($curent_page - 1) * $rules_per_page;
       $cat_cont = $offset;
       $cont  = 0;
       if (isset($data2['post_title'][0])) {
           for ($i = 0; $i < sizeof($data2['post_title']); ++$i) 
           {
               $bundle = array();
               if (isset($data2['schedule'][$i]) && $data2['schedule'][$i] != '' && $data2['post_title'][$i] != '') {
                   $bundle[] = trim(sanitize_text_field($data2['schedule'][$i]));
                   if (isset($data2['active'][$i])) {
                       $bundle[] = trim(sanitize_text_field($data2['active'][$i]));
                   } else {
                       $bundle[] = '0';
                   }
                   $bundle[]     = trim(sanitize_text_field($data2['last_run'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['max'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['submit_status'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_type'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_author'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_tags'][$i]));
                   if($i == sizeof($data2['schedule']) - 1)
                   {
                       if(isset($data2['default_category']))
                       {
                           $bundle[]     = $data2['default_category'];
                       }
                       else
                       {
                           if(!isset($data2['default_category' . $cat_cont]))
                           {
                               $cat_cont++;
                           }
                           if(!isset($data2['default_category' . $cat_cont]))
                           {
                               $bundle[]     = array('aiomatic_no_category_12345678');
                           }
                           else
                           {
                               $bundle[]     = $data2['default_category' . $cat_cont];
                           }
                       }
                   }
                   else
                   {
                       if(!isset($data2['default_category' . $cat_cont]))
                       {
                           $cat_cont++;
                       }
                       if(!isset($data2['default_category' . $cat_cont]))
                       {
                           $bundle[]     = array('aiomatic_no_category_12345678');
                       }
                       else
                       {
                           $bundle[]     = $data2['default_category' . $cat_cont];
                       }
                   }
                   $bundle[]     = trim(sanitize_text_field($data2['auto_categories'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['auto_tags'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['enable_comments'][$i]));
                   $bundle[]     = trim($data2['image_url'][$i]);
                   $bundle[]     = $data2['post_title'][$i];
                   $bundle[]     = trim(sanitize_text_field($data2['enable_pingback'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_format'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['min_char'][$i]));
                   $bundle[]     = trim($data2['custom_fields'][$i]);
                   $bundle[]     = trim($data2['custom_tax'][$i]);
                   $bundle[]     = trim($data2['temperature'][$i]);
                   $bundle[]     = trim($data2['top_p'][$i]);
                   $bundle[]     = trim($data2['presence_penalty'][$i]);
                   $bundle[]     = trim($data2['frequency_penalty'][$i]);
                   $bundle[]     = trim($data2['royalty_free'][$i]);
                   $bundle[]     = trim($data2['ai_command'][$i]);
                   $bundle[]     = trim($data2['max_tokens'][$i]);
                   $bundle[]     = trim($data2['max_seed_tokens'][$i]);
                   $bundle[]     = trim($data2['max_continue_tokens'][$i]);
                   $bundle[]     = trim($data2['model'][$i]);
                   $bundle[]     = trim($data2['headings'][$i]);
                   $bundle[]     = trim($data2['images'][$i]);
                   $bundle[]     = trim($data2['videos'][$i]);
                   $bundle[]     = trim($data2['post_prepend'][$i]);
                   $bundle[]     = trim($data2['post_append'][$i]);
                   $bundle[]     = trim($data2['enable_ai_images'][$i]);
                   $bundle[]     = trim($data2['ai_command_image'][$i]);
                   $bundle[]     = trim($data2['image_size'][$i]);
                   $bundle[]     = trim($data2['headings_list'][$i]);
                   $bundle[]     = trim($data2['images_list'][$i]);
                   $bundle[]     = trim($data2['wpml_lang'][$i]);
                   $bundle[]     = trim($data2['remove_default'][$i]);
                   $bundle[]     = trim($data2['title_model'][$i]);
                   $bundle[]     = trim($data2['title_ai_command'][$i]);
                   $bundle[]     = trim($data2['strip_title'][$i]);
                   $bundle[]     = trim($data2['title_once'][$i]);
                   $bundle[]     = trim($data2['category_model'][$i]);
                   $bundle[]     = trim($data2['category_ai_command'][$i]);
                   $bundle[]     = trim($data2['tag_model'][$i]);
                   $bundle[]     = trim($data2['tag_ai_command'][$i]);
                   $bundle[]     = trim($data2['min_time'][$i]);
                   $bundle[]     = trim($data2['max_time'][$i]);
                   $bundle[]     = trim($data2['skip_spin'][$i]);
                   $bundle[]     = trim($data2['skip_translate'][$i]);
                   $bundle[]     = trim($data2['title_source'][$i]);
                   $bundle[]     = trim($data2['headings_ai_command'][$i]);
                   $bundle[]     = trim($data2['headings_model'][$i]);
                   $bundle[]     = trim($data2['posting_mode'][$i]);
                   $bundle[]     = trim($data2['post_topic_list'][$i]);
                   $bundle[]     = trim($data2['post_sections_list'][$i]);
                   $bundle[]     = trim($data2['content_language'][$i]);
                   $bundle[]     = trim($data2['writing_style'][$i]);
                   $bundle[]     = trim($data2['writing_tone'][$i]);
                   $bundle[]     = trim($data2['title_prompt'][$i]);
                   $bundle[]     = trim($data2['sections_prompt'][$i]);
                   $bundle[]     = trim($data2['content_prompt'][$i]);
                   $bundle[]     = trim($data2['excerpt_prompt'][$i]);
                   $bundle[]     = trim($data2['section_count'][$i]);
                   $bundle[]     = trim($data2['paragraph_count'][$i]);
                   $bundle[]     = trim($data2['topic_title_model'][$i]);
                   $bundle[]     = trim($data2['topic_sections_model'][$i]);
                   $bundle[]     = trim($data2['topic_content_model'][$i]);
                   $bundle[]     = trim($data2['topic_excerpt_model'][$i]);
                   $bundle[]     = trim($data2['single_content_call'][$i]);
                   $bundle[]     = trim($data2['intro_prompt'][$i]);
                   $bundle[]     = trim($data2['topic_intro_model'][$i]);
                   $bundle[]     = trim($data2['outro_prompt'][$i]);
                   $bundle[]     = trim($data2['topic_outro_model'][$i]);
                   $bundle[]     = trim($data2['topic_images'][$i]);
                   $bundle[]     = trim($data2['sections_role'][$i]);
                   $bundle[]     = trim($data2['topic_videos'][$i]);
                   $bundle[]     = trim($data2['rule_description'][$i]);
                   $bundle[]     = trim($data2['custom_shortcodes'][$i]);
                   $bundle[]     = trim($data2['strip_by_regex'][$i]);
                   $bundle[]     = trim($data2['replace_regex'][$i]);
                   $bundle[]     = trim($data2['strip_by_regex_prompts'][$i]);
                   $bundle[]     = trim($data2['replace_regex_prompts'][$i]);
                   $bundle[]     = trim($data2['run_regex_on'][$i]);
                   $bundle[]     = trim($data2['max_links'][$i]);
                   $bundle[]     = trim($data2['link_post_types'][$i]);
                   $bundle[]     = trim($data2['enable_toc'][$i]);
                   $bundle[]     = trim($data2['title_toc'][$i]);
                   $bundle[]     = trim($data2['qa_prompt'][$i]);
                   $bundle[]     = trim($data2['topic_qa_model'][$i]);
                   $bundle[]     = trim($data2['enable_qa'][$i]);
                   $bundle[]     = trim($data2['title_qa'][$i]);
                   $bundle[]     = trim($data2['title_outro'][$i]);
                   $bundle[]     = trim($data2['link_type'][$i]);
                   $bundle[]     = trim($data2['link_list'][$i]);
                   $bundle[]     = trim($data2['skip_inexist'][$i]);
                   $bundle[]     = trim($data2['global_prepend'][$i]);
                   $bundle[]     = trim($data2['global_append'][$i]);
                   $bundle[]     = trim($data2['search_query_repetition'][$i]);
                   $bundle[]     = trim($data2['img_all_headings'][$i]);
                   $bundle[]     = trim($data2['heading_img_location'][$i]);
                   $bundle[]     = trim($data2['days_no_run'][$i]);
                   $bundle[]     = trim($data2['overwrite_existing'][$i]);
                   $bundle[]     = trim($data2['link_nofollow'][$i]);
                   $bundle[]     = trim($data2['title_generator_method'][$i]);
                   $bundle[]     = trim($data2['parent_id'][$i]);
                   $bundle[]     = trim($data2['rule_unique_id'][$i]);
                   $bundle[]     = trim($data2['image_model'][$i]);
                   $bundle[]     = isset($data2['assistant_id'][$i]) ? trim($data2['assistant_id'][$i]) : '';
                   $rules[$offset + $cont] = $bundle;
                   $cont++;
                   $cat_cont++;
               }
           }
           while($cont < $init_rules_per_page)
           {
               if(isset($rules[$offset + $cont]))
               {
                   $rules[$offset + $cont] = false;
               }
               $cont = $cont + 1;
               $cat_cont++;
           }
           $rules = array_values(array_filter($rules));
       }
       $final_count = count($rules);
       if($final_count > $initial_count)
       {
           $add = true;
       }
       elseif($final_count < $initial_count)
       {
           $scad = true;
       }
       update_option('aiomatic_rules_list', $rules, false);
       if(count($rules) % $rules_per_page === 1 && $add === true)
       {
           $rules_count = count($rules);
           $max_pages = ceil($rules_count/$rules_per_page);
           if($max_pages == 0)
           {
               $max_pages = 1;
           }
           $last_url = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
           if(stristr($last_url, 'aiomatic_page=') === false)
           {
               if(stristr($last_url, '?') === false)
               {
                   $last_url .= '?aiomatic_page=' . $max_pages;
               }
               else
               {
                   $last_url .= '&aiomatic_page=' . $max_pages;
               }
           }
           else
           {
               if(isset($_GET['aiomatic_page']))
               {
                   $curent_page = $_GET["aiomatic_page"];
               }
               else
               {
                   $curent_page = '';
               }
               if(is_numeric($curent_page))
               {
                   $last_url = str_replace('aiomatic_page=' . $curent_page, 'aiomatic_page=' . $max_pages, $last_url);
               }
               else
               {
                   if(stristr($last_url, '?') === false)
                   {
                       $last_url .= '?aiomatic_page=' . $max_pages;
                   }
                   else
                   {
                       $last_url .= '&aiomatic_page=' . $max_pages;
                   }
               }
           }
           aiomatic_redirect($last_url);
       }
       elseif(count($rules) != 0 && count($rules) % $rules_per_page === 0 && $scad === true)
       {
           $rules_count = count($rules);
           $max_pages = ceil($rules_count/$rules_per_page);
           if($max_pages == 0)
           {
               $max_pages = 1;
           }
           $last_url = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
           if(stristr($last_url, 'aiomatic_page=') === false)
           {
               if(stristr($last_url, '?') === false)
               {
                   $last_url .= '?aiomatic_page=' . $max_pages;
               }
               else
               {
                   $last_url .= '&aiomatic_page=' . $max_pages;
               }
           }
           else
           {
               if(isset($_GET['aiomatic_page']))
               {
                   $curent_page = $_GET["aiomatic_page"];
               }
               else
               {
                   $curent_page = '';
               }
               if(is_numeric($curent_page))
               {
                   $last_url = str_replace('aiomatic_page=' . $curent_page, 'aiomatic_page=' . $max_pages, $last_url);
               }
               else
               {
                   if(stristr($last_url, '?') === false)
                   {
                       $last_url .= '?aiomatic_page=' . $max_pages;
                   }
                   else
                   {
                       $last_url .= '&aiomatic_page=' . $max_pages;
                   }
               }
           }
           aiomatic_redirect($last_url);
       }
   }
   function aiomatic_expand_rules_manual()
   {
       $all_models = aiomatic_get_all_models(true);
       $all_assistants = aiomatic_get_all_assistants(true);
       if (!get_option('aiomatic_running_list')) {
           $running = array();
       } else {
           $running = get_option('aiomatic_running_list');
       }
       $GLOBALS['wp_object_cache']->delete('aiomatic_rules_list', 'options');
       $rules  = get_option('aiomatic_rules_list');
       if(!is_array($rules))
       {
         $rules = array();
       }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
            $cat_args   = array(
               "orderby" => "name",
               "hide_empty" => 0,
               "order" => "ASC"
           );
           $categories = get_categories($cat_args);
           $posted_items = array();
           $post_list = array();
           $postsPerPage = 50000;
           $paged = 0;
           do
           {
               $postOffset = $paged * $postsPerPage;
               $query = array(
                   'post_status' => array(
                       'publish',
                       'draft',
                       'pending',
                       'trash',
                       'private',
                       'future'
                   ),
                   'post_type' => array(
                       'any'
                   ),
                   'numberposts' => $postsPerPage,
                   'meta_key' => 'aiomatic_parent_rule',
                   'fields' => 'ids',
                   'offset'  => $postOffset
               );
               $got_me = get_posts($query);
               $post_list = array_merge($post_list, $got_me);
               $paged++;
           }while(!empty($got_me));
           wp_suspend_cache_addition(true);
           foreach ($post_list as $post) {
               $rule_id = get_post_meta($post, 'aiomatic_parent_rule', true);
               if ($rule_id != '') {
                  if(stristr($rule_id, '-'))
                  {
                     $exp = explode('-', $rule_id);
                     if(isset($exp[0]) && isset($exp[1]) && $exp[0] == '0')
                     {
                        $posted_items[] = $exp[1];
                     }
                  }
                  else
                  {
                     $posted_items[] = $rule_id;
                  }
               }
           }
           wp_suspend_cache_addition(false);
           $counted_vals = array_count_values($posted_items);
           if(isset($_GET["aiomatic_page"]) && is_numeric($_GET["aiomatic_page"]))
           {
               $curent_page = $_GET["aiomatic_page"];
           }
           else
           {
               $curent_page = 1;
           }
           $unlocker = get_option('aiomatic_minute_running_unlocked', false);
           $rules_per_page = get_option('aiomatic_posts_per_page', 12);
           foreach ($rules as $request => $bundle[]) {
               if(($cont < ($curent_page - 1) * $rules_per_page) || ($cont >= $curent_page * $rules_per_page))
               {
                  $cont++;
                  continue;
               }
               $bundle_values          = array_values($bundle);
               $myValues               = $bundle_values[$cont];
               $array_my_values        = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
               $schedule               = $array_my_values[0];
               $active                 = $array_my_values[1];
               $last_run               = $array_my_values[2];
               $max                    = $array_my_values[3];
               $status                 = $array_my_values[4];
               $def_type               = $array_my_values[5];
               $post_user_name         = $array_my_values[6];
               $default_tags           = $array_my_values[7];
               $default_category       = $array_my_values[8];
               $auto_categories        = $array_my_values[9];
               $auto_tags              = $array_my_values[10];
               $enable_comments        = $array_my_values[11];
               $image_url              = $array_my_values[12];
               $post_title             = $array_my_values[13];
               $enable_pingback        = $array_my_values[14];
               $post_format            = $array_my_values[15];
               $min_char               = $array_my_values[16];
               $custom_fields          = $array_my_values[17];
               $custom_tax             = $array_my_values[18];
               $temperature            = $array_my_values[19];
               $top_p                  = $array_my_values[20];
               $presence_penalty       = $array_my_values[21];
               $frequency_penalty      = $array_my_values[22];
               $royalty_free           = $array_my_values[23];
               $ai_command             = $array_my_values[24];
               $max_tokens             = $array_my_values[25];
               $max_seed_tokens        = $array_my_values[26];
               $max_continue_tokens    = $array_my_values[27];
               $model                  = $array_my_values[28];
               $headings               = $array_my_values[29];
               $images                 = $array_my_values[30];
               $videos                 = $array_my_values[31];
               $post_prepend           = $array_my_values[32];
               $post_append            = $array_my_values[33];
               $enable_ai_images       = $array_my_values[34];
               $ai_command_image       = $array_my_values[35];
               $image_size             = $array_my_values[36];
               $headings_list          = $array_my_values[37];
               $images_list            = $array_my_values[38];
               $wpml_lang              = $array_my_values[39];
               $remove_default         = $array_my_values[40];
               $title_model            = $array_my_values[41];
               $title_ai_command       = $array_my_values[42];
               $strip_title            = $array_my_values[43];
               $title_once             = $array_my_values[44];
               $category_model         = $array_my_values[45];
               $category_ai_command    = $array_my_values[46];
               $tag_model              = $array_my_values[47];
               $tag_ai_command         = $array_my_values[48];
               $min_time               = $array_my_values[49];
               $max_time               = $array_my_values[50];
               $skip_spin              = $array_my_values[51];
               $skip_translate         = $array_my_values[52];
               $title_source           = $array_my_values[53];
               $headings_ai_command    = $array_my_values[54];
               $headings_model         = $array_my_values[55];
               $posting_mode           = $array_my_values[56];
               $post_topic_list        = $array_my_values[57];
               $post_sections_list     = $array_my_values[58];
               $content_language       = $array_my_values[59];
               $writing_style          = $array_my_values[60];
               $writing_tone           = $array_my_values[61];
               $title_prompt           = $array_my_values[62];
               $sections_prompt        = $array_my_values[63];
               $content_prompt         = $array_my_values[64];
               $excerpt_prompt         = $array_my_values[65];
               $section_count          = $array_my_values[66];
               $paragraph_count        = $array_my_values[67];
               $topic_title_model      = $array_my_values[68];
               $topic_sections_model   = $array_my_values[69];
               $topic_content_model    = $array_my_values[70];
               $topic_excerpt_model    = $array_my_values[71];
               $single_content_call    = $array_my_values[72];
               $intro_prompt           = $array_my_values[73];
               $topic_intro_model      = $array_my_values[74];
               $outro_prompt           = $array_my_values[75];
               $topic_outro_model      = $array_my_values[76];
               $topic_images           = $array_my_values[77];
               $sections_role          = $array_my_values[78];
               $topic_videos           = $array_my_values[79];
               $rule_description       = $array_my_values[80];
               $custom_shortcodes      = $array_my_values[81];
               $strip_by_regex         = $array_my_values[82];
               $replace_regex          = $array_my_values[83];
               $strip_by_regex_prompts = $array_my_values[84];
               $replace_regex_prompts  = $array_my_values[85];
               $run_regex_on           = $array_my_values[86];
               $max_links              = $array_my_values[87];
               $link_post_types        = $array_my_values[88];
               $enable_toc             = $array_my_values[89];
               $title_toc              = $array_my_values[90];
               $qa_prompt              = $array_my_values[91];
               $topic_qa_model         = $array_my_values[92];
               $enable_qa              = $array_my_values[93];
               $title_qa               = $array_my_values[94];
               $title_outro            = $array_my_values[95];
               $link_type              = $array_my_values[96];
               $link_list              = $array_my_values[97];
               $skip_inexist           = $array_my_values[98];
               $global_prepend         = $array_my_values[99];
               $global_append          = $array_my_values[100];
               $search_query_repetition= $array_my_values[101];
               $img_all_headings       = $array_my_values[102];
               $heading_img_location   = $array_my_values[103];
               $days_no_run            = $array_my_values[104];
               $overwrite_existing     = $array_my_values[105];
               $link_nofollow          = $array_my_values[106];
               $title_generator_method = $array_my_values[107];
               $parent_id              = $array_my_values[108];
               $rule_unique_id         = $array_my_values[109];
               $image_model            = $array_my_values[110];
               $assistant_id           = $array_my_values[111];
               if(empty($rule_unique_id))
               {
                  $rule_unique_id = $cont;
               }
               if (isset($counted_vals[$rule_unique_id])) {
                   $generated_posts = $counted_vals[$rule_unique_id];
               } else {
                   $generated_posts = 0;
               }
               if($rule_description == '')
               {
                  $rule_description = $cont;
               }
               if(empty($posting_mode))
               {
                  $posting_mode = 'title';
               }
               $name = md5(get_bloginfo());
               wp_add_inline_script($name . '-footer-script', 'createAdmin(' . esc_html($cont) . ');createModeSelect(' . esc_html($cont) . ');hideLinks(' . esc_html($cont) . ');', 'after');
               $output .= '<tr>
                           <td class="cr_short_td"><input type="text" name="aiomatic_rules_list[rule_description][]" id="rule_description' . esc_html($cont) . '" class="cr_center" placeholder="Rule ID" value="' . esc_html($rule_description) . '" class="cr_width_full"/></td>
                           <td class="cr_width_80 cr_center">
                           <select autocomplete="off" id="posting_mode' . esc_html($cont) . '"  name="aiomatic_rules_list[posting_mode][]" class="cr_width_full">
                              <option value="topic"';
                           if ($posting_mode == 'topic') {
                              $output .= ' selected';
                           }
                           $output .= '>' . esc_html__("Topic Based/Multiple API Calls", 'aiomatic-automatic-ai-content-writer') . '</option>
                              <option value="title"';
                           if ($posting_mode == 'title') {
                              $output .= ' selected';
                           }
                           $output .= '>' . esc_html__("Title Based/Single API Call", 'aiomatic-automatic-ai-content-writer') . '</option>
                           </select>
                           </td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_rules_list[post_title][]" placeholder="Please insert your post titles/TXT file URL/RSS feed URLs/%%ai_generated_title%% shortcode" class="cr_width_full">' . htmlspecialchars($post_title) . '</textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" placeholder="# h" name="aiomatic_rules_list[schedule][]" max="8765812" value="' . esc_attr($schedule) . '" class="cr_width_60" required></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" placeholder="#" name="aiomatic_rules_list[max][]" value="' . esc_attr($max) . '"  class="cr_width_60" required></td>
                       <td class="cr_width_70 cr_center">
                       <input type="button" id="mybtnfzr' . esc_html($cont) . '" value="Settings">
                       <div id="mymodalfzr' . esc_html($cont) . '" class="codemodalfzr">
     <div class="codemodalfzr-content">
       <div class="codemodalfzr-header">
         <span id="aiomatic_close' . esc_html($cont) . '" class="codeclosefzr">&times;</span>
         <h2>' . esc_html__('Rule', 'aiomatic-automatic-ai-content-writer') . ' <span class="cr_color_white">ID ' . esc_html($cont) . '</span> ' . esc_html__('Advanced Settings', 'aiomatic-automatic-ai-content-writer') . '</h2>
       </div>
       <div class="codemodalfzr-body">
       <div class="table-responsive">
         <table class="responsive table cr_main_table_nowr"><tr><td colspan="2"><h3>' . esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer') . ':</h3>
         </td></tr><tr>
         <td class="cr_min_width_200">
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer') . '</div>
               </div>
               <b>' . esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer') . '</b>
         </td>
         <td><select id="assistant_id' . esc_html($cont) . '" name="aiomatic_rules_list[assistant_id][]" class="cr_width_full" onchange="assistantSelected(\'' . esc_html($cont) . '\');">';
if($all_assistants === false)
{
   $output .= '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
if(count($all_assistants) == 0)
{
   $output .= '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
   $output .= '<option value=""';
   if($assistant_id == ''){$output .= ' selected';}
$output .= '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($all_assistants as $myassistant)
{
   $output .= '<option value="' . $myassistant->ID .'"';
   if($assistant_id == $myassistant->ID){$output .= ' selected';}
   $output .= '>' . esc_html($myassistant->post_title);
$output .= '</option>';
}
}
}
$output .= '</select>  
         </td>
      </tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td colspan="2"><h3>' . esc_html__('Topic Based Posting Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("If you set a post topic list here, the titles you entered in the \'Post Title List\' settings field will not be considered and titles will be auto generated based on this topic! Be sure to edit the \'Title Prompt\' settings from below to change the way titles will be created! Enter a post topic list, one on each line. If you leave this field blank, the titles from entered in the 'Post Title List' settings field will be used. If you enter a value here, new titles will be created, based on this topic and the values from the 'Post Title List' will be overwritten. If you enter multiple topics (one per line), a random topic will be selected at each run. This will set the value of the %%topic%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Auto Generate Post Title Based On Topics (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[post_topic_list][]" placeholder="Post topic list (one per line)" class="cr_width_full">' . esc_textarea($post_topic_list) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the method to be used for the title generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Title Generator Method", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <select autocomplete="off" class="cr_width_full" id="title_generator_method" name="aiomatic_rules_list[title_generator_method][]">
                       <option value="ai"';
               if ($title_generator_method == 'ai') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("AI Writer", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="serp"';
               if ($title_generator_method == 'serp') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Related SERP Searches", 'aiomatic-automatic-ai-content-writer') . '</option>
                       </select>          
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. You can use here the %%topic%% shortcode, to get the value of the above topic, automtically. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Post Sections List (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[post_sections_list][]" placeholder="Post sections list (one per line)" class="cr_width_full">' . esc_textarea($post_sections_list) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter the number of sections to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Number Of Content Sections To Generate", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="text" id="section_count' . esc_html($cont) . '" name="aiomatic_rules_list[section_count][]" placeholder="3-4" class="cr_width_full" value="' . esc_attr($section_count) . '">
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select what you want to do with sections in articles.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Add Sections To Content As", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <select autocomplete="off" class="cr_width_full" id="sections_role" name="aiomatic_rules_list[sections_role][]">
                       <option value="h2"';
               if ($sections_role == 'h2') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("h2", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="h3"';
               if ($sections_role == 'h3') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("h3", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="b"';
               if ($sections_role == 'b') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Bold", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="i"';
               if ($sections_role == 'i') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Italic", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="bi"';
               if ($sections_role == 'bi') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Bold and Italic", 'aiomatic-automatic-ai-content-writer') . '</option>
               <option value="p"';
               if ($sections_role == 'p') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Paragraph", 'aiomatic-automatic-ai-content-writer') . '</option>
               <option value="x"';
               if ($sections_role == 'x') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Plain Text", 'aiomatic-automatic-ai-content-writer') . '</option>
               <option value="no"';
               if ($sections_role == 'no') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Don't Add Sections", 'aiomatic-automatic-ai-content-writer') . '</option>
                       </select>                
           </div>
           </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Number Of Paragraphs Per Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="text" id="paragraph_count' . esc_html($cont) . '" name="aiomatic_rules_list[paragraph_count][]" placeholder="2-3" class="cr_width_full" value="' . esc_attr($paragraph_count) . '">
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the number of related images to add to the created post content. This feature will use the royalty free image sources configured in the plugin's 'Settings' menu or if you have access to the DallE API. You can change image source in the 'AI Image Source' settings field from below. The maximum number of images you can add to each article: number of sections + 2", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Number of Images To Add To The Article", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="text" name="aiomatic_rules_list[topic_images][]" value="' . esc_attr($topic_images) . '" placeholder="Number of images" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add an image to each of the creating headings from the article.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add An Image To Each Heading Of The Article", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="img_all_headings" name="aiomatic_rules_list[img_all_headings][]"';
         if($img_all_headings == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr><tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the location of the heading images/videos.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Heading Image/Video Location", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" id="heading_img_location' . esc_html($cont) . '" name="aiomatic_rules_list[heading_img_location][]" class="cr_width_full">
                                    <option value="top"';
             if ($heading_img_location == 'top') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Top of the section", 'aiomatic-automatic-ai-content-writer') . '</option>
             <option value="heading"';
             if ($heading_img_location == 'heading') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Under the heading text", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="bottom"';
             if ($heading_img_location == 'bottom') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Bottom of the section", 'aiomatic-automatic-ai-content-writer') . '</option>
             <option value="random"';
            if ($heading_img_location == 'random') {
            $output .= ' selected';
            }
            $output .= '>' . esc_html__("Random", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the number of related videos to add to the created post content. The maximum number of videos you can add to each article: number of sections", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Number of YouTube Videos To Add To The Article", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="0" name="aiomatic_rules_list[topic_videos][]" value="' . esc_attr($topic_videos) . '" placeholder="Number of videos" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the header text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Outro Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="title_outro' . esc_html($cont) . '" name="aiomatic_rules_list[title_outro][]" type="text" placeholder="Optional" class="coderevolution_gutenberg_input" value="' . esc_attr($title_outro) . '"/>           
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="hideTOC' . esc_html($cont) . '">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Article Table Of Contents Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td class="hideTOC' . esc_html($cont) . '">
                     <input type="checkbox" id="enable_toc" name="aiomatic_rules_list[enable_toc][]"';
         if($enable_toc == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="hideTOC' . esc_html($cont) . '">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Table Of Contents Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td class="hideTOC' . esc_html($cont) . '">
                     <input id="title_toc' . esc_html($cont) . '" name="aiomatic_rules_list[title_toc][]" type="text" placeholder="Table of Contents" class="coderevolution_gutenberg_input" value="' . esc_attr($title_toc) . '"/>           
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Article Q&A Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="enable_qa" name="aiomatic_rules_list[enable_qa][]"';
         if($enable_qa == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the header text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Q&A Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="title_qa' . esc_html($cont) . '" name="aiomatic_rules_list[title_qa][]" type="text" placeholder="Q&A" class="coderevolution_gutenberg_input" value="' . esc_attr($title_qa) . '"/>           
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Content Parameters', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Content Language", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="content_language' . esc_html($cont) . '" name="aiomatic_rules_list[content_language][]" type="text" list="languages" placeholder="Created content language" class="coderevolution_gutenberg_input" value="' . esc_attr($content_language) . '"/>                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Writing Style", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="writing_style' . esc_html($cont) . '" name="aiomatic_rules_list[writing_style][]" type="text" list="writing_styles" placeholder="Created content writing style" class="coderevolution_gutenberg_input" value="' . esc_attr($writing_style) . '"/>                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Writing Tone", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="writing_tone' . esc_html($cont) . '" name="aiomatic_rules_list[writing_tone][]" type="text" list="writing_tones" placeholder="Created content writing tone" class="coderevolution_gutenberg_input" value="' . esc_attr($writing_tone) . '"/>                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Prompts', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Title Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[title_prompt][]" placeholder="Enter your title prompts, one per line" class="cr_width_full">' . esc_textarea($title_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Title Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_title_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_title_model))
{
   $topic_title_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_title_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Intro. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - to disable article intro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Intro Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[intro_prompt][]" placeholder="Enter your intro prompts, one per line" class="cr_width_full">' . esc_textarea($intro_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Intro Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_intro_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_intro_model))
{
   $topic_intro_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_intro_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Sections. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Sections Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[sections_prompt][]" placeholder="Enter your sections prompts, one per line" class="cr_width_full">' . esc_textarea($sections_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the sections generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Sections Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_sections_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_sections_model))
{
   $topic_sections_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_sections_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%title%%, %%article_so_far%%, %%last_section_content%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%current_section%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Content Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="3" cols="70" name="aiomatic_rules_list[content_prompt][]" placeholder="Enter your content prompt" class="cr_width_full">' . esc_textarea($content_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Content Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_content_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_content_model))
{
   $topic_content_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_content_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to use the above content prompt to create the entire article from a single API call (checkbox checked) or to run the prompt for each section separately (checkbox unchecked). If you check this, be sure to modify the content prompt accordingly.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Use the Above Content Prompt To Create The Entire Article (Not Each Section)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="single_content_call' . esc_html($cont) . '" name="aiomatic_rules_list[single_content_call][]"';
         if($single_content_call == '1')
         {
             $output .= ' checked';
         }
         $output .= ' onclick="hideTOC(' . esc_html($cont) . ');">
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Q&A. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - to disable article outro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Q&A Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[qa_prompt][]" placeholder="Enter your Q&A prompts, one per line" class="cr_width_full">' . esc_textarea($qa_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Q&A Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_qa_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_qa_model))
{
   $topic_qa_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_qa_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post outro. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections_count%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - to disable article outro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Outro Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[outro_prompt][]" placeholder="Enter your outro prompts, one per line" class="cr_width_full">' . esc_textarea($outro_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Outro Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_outro_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_outro_model))
{
   $topic_outro_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_outro_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Excerpt. You can use the following shortcodes: %%title%%, %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%sections%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Excerpt Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[excerpt_prompt][]" placeholder="Enter your excerpt prompts, one per line" class="cr_width_full">' . esc_textarea($excerpt_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Excerpt Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[topic_excerpt_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_excerpt_model))
{
   $topic_excerpt_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_excerpt_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Advanced Prompting Options', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Run Regex On Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[strip_by_regex_prompts][]" placeholder="regex" class="cr_width_full">' . esc_textarea($strip_by_regex_prompts) . '</textarea>
                         
         </div>
         </td></tr><tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content from prompts, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Replace Matches From Regex (Prompts)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[replace_regex_prompts][]" placeholder="regex replacement" class="cr_width_full">' . esc_textarea($replace_regex_prompts) . '</textarea>
                         
         </div>
         </td></tr><tr class="hidetopic' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, outro, excerpt", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Run Above Regex On Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="run_regex_on' . esc_html($cont) . '" name="aiomatic_rules_list[run_regex_on][]" type="text" list="run_regex_on_list' . esc_html($cont) . '" class="coderevolution_gutenberg_input" value="' . esc_attr($run_regex_on) . '"/>
							<datalist id="run_regex_on_list' . esc_html($cont) . '">
                     <option value="title">title</option>
                     <option value="intro">intro</option>
                     <option value="sections">sections</option>
                     <option value="content">content</option>
                     <option value="qa">Q&A</option>
                     <option value="outro">outro</option>
                     <option value="excerpt">excerpt</option>
							</datalist>    
                         
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td colspan="2"><h3>' . esc_html__('Title Based Posting Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Post Content - AI Text Generator Options', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr><tr class="hidetitle' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the text generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For The Text Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" id="model" name="aiomatic_rules_list[model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($model))
{
   $model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to AI. This command can be any given task or order, based on which, it will generate content for posts. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Text Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[ai_command][]" placeholder="Please insert a command for the AI" class="cr_width_full">' . esc_textarea($ai_command) . '</textarea>
                         
         </div>
         </td></tr><tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( "Select the minimum number of characters that the posts should have. If the API returns content which has fewer characters than this number, another API call will be made, until this character limit is met. Please check about API rate limiting <a href='%s'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://beta.openai.com/docs/api-reference/introduction' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Content Minimum Character Count", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="1" step="1" name="aiomatic_rules_list[min_char][]" value="' . esc_attr($min_char) . '" placeholder="Please insert a minimum number of characters" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Post Title - AI Text Generator Options (%%ai_generated_title%% shortcode)', 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("The %%ai_generated_title%% shortcode can be used in the 'Post Title List / TXT File URL / RSS Feed URL' settings field, to get partial or fully AI generated titles.", 'aiomatic-automatic-ai-content-writer') . '
</div>
</div></h4></td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the title text generator. You can add this to the post titles, using the %%ai_generated_title%% shortcode.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For The Title Text Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[title_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($title_model))
{
   $title_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($title_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}                                  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to AI title text generator. This command can be any given task or order, based on which, it will generate content for posts. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Title Text Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[title_ai_command][]" placeholder="Please insert a command for the AI" class="cr_width_full">' . esc_textarea($title_ai_command) . '</textarea>
                         
         </div>
         </td></tr><tr class="hidetitle' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the source of the post title. If you select AI generated, the plugin will create an AI generated title based on keywords you enter in the 'Post Title List' settings field. Otherwise, it will use the titles listed there, for the created posts.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Post Title Source", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" id="title_source" name="aiomatic_rules_list[title_source][]" class="cr_width_full">
                                    <option value="keyword"';
             if ($title_source == 'keyword') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Use The Titles From The 'Post Title List' Settings Field", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="ai"';
             if ($title_source == 'ai') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Fully AI Generated Titles", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
         </div>
         </td></tr><tr class="hidetitle' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Rich Content Creation Options', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of related headings to add to the created post content. This feature will use the 'People Also Ask' feature from Google and Bing. By default, the Bing engine is scraped, if you want to enable also Google scraping, add a SerpAPI key in the plugin's 'Settings' menu -> 'SerpAPI API Key' settings field.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Number Of Related Headings to Add To The Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="0" name="aiomatic_rules_list[headings][]" value="' . esc_attr($headings) . '" placeholder="Maximum headings count" class="cr_width_full">
                         
         </div>
         </td></tr><tr class="hidetitle' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the headings generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For The Headings Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[headings_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($headings_model))
{
   $headings_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($headings_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}  
            $output .= '</select>
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the prompt you will use when searching for related headings. You can use the following shortcodes: %%post_title%%, %%needed_heading_count%%. The same model will be used, as the one selected for content creation. If you leave this field blank, the default prompt will be used: 'Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%' You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Related Headings AI Generator Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[headings_ai_command][]" placeholder="Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%" class="cr_width_full">' . esc_textarea($headings_ai_command) . '</textarea>                         
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of related images to add to the created post content. This feature will use the royalty free image sources configured in the plugin's 'Settings' menu or if you have access to the DallE API.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Number Of Related Images to Add To The Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="0" name="aiomatic_rules_list[images][]" value="' . esc_attr($images) . '" placeholder="Maximum image count" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Add a related YouTube video to the end of to the created post content. This feature will require you to add at least one YouTube API key in the plugin's 'Settings' -> 'YouTube API Key List' settings field.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add A Related Video To The End Of The Post", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="checkbox" id="videos" name="aiomatic_rules_list[videos][]"';
               if ($videos == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                         
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td colspan="2"><h4>' . esc_html__('Manual Headings and Images List', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Add a list of headings (one on each line) to use in the generated articles. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Manual List Of Headings", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[headings_list][]" placeholder="Manual list of headings" class="cr_width_full">' . esc_textarea($headings_list) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Add a list of image URLs (one on each line) to use in the generated articles. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Manual List Of Images", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[images_list][]" placeholder="Manual list of images" class="cr_width_full">' . esc_textarea($images_list) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Global Prompt Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prepend Text To All Textual AI Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[global_prepend][]" placeholder="Global prompt prepend text" class="cr_width_full">' . esc_textarea($global_prepend) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidetopic' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Append Text To All Textual AI Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[global_append][]" placeholder="Global prompt append text" class="cr_width_full">' . esc_textarea($global_append) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Automatic Linking Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Automatic Linking Type", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <select autocomplete="off" class="cr_width_full" id="link_type' . esc_html($cont) . '" onchange="hideLinks(' . esc_html($cont) . ');" name="aiomatic_rules_list[link_type][]">
                     <option value="disabled"';
             if ($link_type == 'disabled') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="internal"';
             if ($link_type == 'internal') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Internal Links", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="manual"';
             if ($link_type == 'manual') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Manual Links", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="mixed"';
             if ($link_type == 'mixed') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Mixed Links", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>                
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of automatic links to add to created posts. You can also define custom ranges, like: 3-5. Please note that this feature will work best if you already have a considerable number of posts published on your site, which will be used for internal linking.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Maximum Number Of Automatic Links To Add To The Post Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       </td><td>
                       <input type="text" name="aiomatic_rules_list[max_links][]" placeholder="Add the number of links to enable this feature" class="cr_width_full" value="' . esc_attr($max_links) . '">
           </div>
           </td></tr>
         <tr class="hidelinks' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a manual list of links, where the plugin will create links.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Manual List Of URLs (One Per Line)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <textarea rows="1" cols="70" name="aiomatic_rules_list[link_list][]" placeholder="URL list (one per line)" class="cr_width_full">' . esc_textarea($link_list) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hidelinks' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to add nofollow attribute to manually entered, external links?", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Nofollow Attribute To Manual Links", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="checkbox" name="aiomatic_rules_list[link_nofollow][]"';
         if($link_nofollow == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the post types where to create automatic links in posts. You can also add a comma separated list of multiple post types.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Types Where To Generate Automatic Links", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       </td><td>
                       <input type="text" name="aiomatic_rules_list[link_post_types][]" placeholder="post" class="cr_width_full" value="' . esc_attr($link_post_types) . '">
           </div>
           </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Post Category Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically add post categories from the feed items?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Add Categories", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <select autocomplete="off" class="cr_width_full" id="auto_categories" name="aiomatic_rules_list[auto_categories][]">
                       <option value="disabled"';
               if ($auto_categories == 'disabled') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="ai"';
               if ($auto_categories == 'ai') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("AI Generated", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="title"';
               if ($auto_categories == 'title') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Title", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="content"';
               if ($auto_categories == 'content') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Content", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="both"';
               if ($auto_categories == 'both') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Title and Content", 'aiomatic-automatic-ai-content-writer') . '</option>
                       </select>                
           </div>
           </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the category generator. You can add this to the post categories, if you select 'AI Generated Categories' in the 'Auto Add Categories' settings field.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For The Category Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[category_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($category_model))
{
   $category_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($category_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}  
            $output .= '</select>
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to AI category generator. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Category Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[category_ai_command][]" placeholder="Write a comma separated list of categories, for the post title: %%post_title%%" class="cr_width_full">' . esc_textarea($category_ai_command) . '</textarea>
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post category that you want for the automatically generated posts to have.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Additional Post Category", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     
                     <select multiple class="cr_width_full" id="default_category" name="aiomatic_rules_list[default_category' . esc_html($cont) . '][]" onmouseover="this.size=this.length;" onmouseout="this.size=4;">
                     <option value="aiomatic_no_category_12345678"';
                     if(!is_array($default_category))
                     {
                         $default_category = array($default_category);
                     }
                     if(count($default_category) == 1)
                     {
                      foreach($default_category as $dc)
                      {
                            if ("aiomatic_no_category_12345678" == $dc) {
                               $output .= ' selected';
                               break;
                            }
                      }
                   }
                     $output .= '>' . esc_html__("Do Not Add a Category", 'aiomatic-automatic-ai-content-writer') . '</option>';
             foreach ($categories as $category) {
                 $output .= '<option value="' . esc_attr($category->term_id) . '"';
                 foreach($default_category as $dc)
                 {
                     if ($category->term_id == $dc) {
                         $output .= ' selected';
                         break;
                     }
                 }
                 $output .= '>' . sanitize_text_field($category->name) . ' - ID ' . esc_html($category->term_id) . '</option>';
             }
             $output .= '</select>   
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This feature will try to remove the WordPress\'s default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Remove WP Default Post Category", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="remove_default" name="aiomatic_rules_list[remove_default][]"';
         if($remove_default == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This option will make the plugin not create categories which are not already existing on your site. For best results in this case, be sure to add to the prompt the list of categories from where the AI should select.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Do Not Add Inexistent Categories", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="skip_inexist" name="aiomatic_rules_list[skip_inexist][]"';
         if($skip_inexist == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Post Tag Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically add post tags from the feed items?", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Auto Add Tags", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <select autocomplete="off" class="cr_width_full" id="auto_tags" name="aiomatic_rules_list[auto_tags][]">
                     <option value="disabled"';
             if ($auto_tags == 'disabled') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="ai"';
             if ($auto_tags == 'ai') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("AI Generated", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="title"';
             if ($auto_tags == 'title') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Title", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="content"';
             if ($auto_tags == 'content') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Content", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="both"';
             if ($auto_tags == 'both') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Title and Content", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>     
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the tag generator. You can add this to the post tags, if you select 'AI Generated Tags' in the 'Auto Add Tags' settings field.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For The Post Tag Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[tag_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($tag_model))
{
   $tag_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($tag_model == $modelx) 
   {
      $output .= " selected";
   }
   else
   {
      $output .= (($assistant_id != '') ? ' disabled ' : '');
   }
   $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
}  
            $output .= '</select>
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to AI tag generator. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Post Tag Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[tag_ai_command][]" placeholder="Write a comma separated list of tags, for the post title: %%post_title%%" class="cr_width_full">' . esc_textarea($tag_ai_command) . '</textarea>
                         
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post tags that you want for the automatically generated posts to have. Spintax supported.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Additional Post Tags", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input class="cr_width_full" type="text" name="aiomatic_rules_list[default_tags][]" value="' . esc_attr($default_tags) . '" placeholder="Please insert your additional post tags here" >
                         
         </div>
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Advanced AI Text Generator Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. Note that in this value the number of tokens sent to the API as an article prompt will also be counted. The maximum amount which can be set is 4000. For other models, the maximum is 2048.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Total Token Count To Use Per API Request", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="1" max="128000" name="aiomatic_rules_list[max_tokens][]" value="' . esc_attr($max_tokens) . '" placeholder="32768" class="cr_width_full">
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Prompt Token Count To Use Per API Request", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="1" max="128000" name="aiomatic_rules_list[max_seed_tokens][]" value="' . esc_attr($max_seed_tokens) . '" placeholder="1000" class="cr_width_full">
                         
         </div>
         </td></tr><tr class="hidetitle' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Continue Token Count To Use Per API Request", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="1" max="128000" name="aiomatic_rules_list[max_continue_tokens][]" value="' . esc_attr($max_continue_tokens) . '" placeholder="500" class="cr_width_full">
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Temperature", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="0" step="0.1" max="2" name="aiomatic_rules_list[temperature][]" value="' . esc_attr($temperature) . '" placeholder="1" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Top_p", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="0" step="0.1" max="1" name="aiomatic_rules_list[top_p][]" value="' . esc_attr($top_p) . '" placeholder="1" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Presence Penalty", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="-2" max="2" step="0.1" name="aiomatic_rules_list[presence_penalty][]" value="' . esc_attr($presence_penalty) . '" placeholder="0" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Frequency Penalty", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="-2" step="0.1" max="2" name="aiomatic_rules_list[frequency_penalty][]" value="' . esc_attr($frequency_penalty) . '" placeholder="0" class="cr_width_full">
                         
         </div>
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Image Generator Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to set a featured image for the created post (royalty free or AI generated)? Please note that for this feature to function you must configure the plugin (add API keys) in the plugin\'s \'Settings\' menu -> \'Royalty Free Featured Image Importing Options\' section.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Auto Set A Featured Image For Posts (Select Source Below)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="royalty_free" name="aiomatic_rules_list[royalty_free][]"';
             if ($royalty_free == '1') {
                 $output .= ' checked';
             }
             $output .= '>
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the search query repetition mode, when searching royalty free images.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Search Query Repetition", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <select autocomplete="off" name="aiomatic_rules_list[search_query_repetition][]" class="cr_width_full">
                                   <option value="0"';
             if ($search_query_repetition == '0') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Use Different Search Queries For Images", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="1"';
             if ($search_query_repetition == '1') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Use The Same Search Query For Images", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable the AI Image Generator and to replace Royalty Free Images with AI generated images? If you select 'Default Featured Image List', you can add the image URLs in the 'Default Featured Image List' settings field.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Image Source", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <select id="enable_ai_images' . esc_html($cont) . '" onchange="hideImage(' . esc_html($cont) . ');" autocomplete="off" name="aiomatic_rules_list[enable_ai_images][]" class="cr_width_full">
                                   <option value="0"';
             if ($enable_ai_images == '0') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Royalty Free", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="1"';
             if ($enable_ai_images == '1') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("OpenAI/AiomaticAPI", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="2"';
             if ($enable_ai_images == '2') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Stability.AI", 'aiomatic-automatic-ai-content-writer') . '</option>
             <option value="4"';
            if ($enable_ai_images == '4') {
            $output .= ' selected';
            }
            $output .= '>' . esc_html__("Midjourney", 'aiomatic-automatic-ai-content-writer') . '</option>
             <option value="3"';
             if ($enable_ai_images == '3') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Manual URL List", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
         </div>
         </td></tr>
         <tr class="hideImg' . esc_html($cont) . '"><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%topic%%, %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. If you use Royalty Free Images as a source, you can also set their keywords here, if no keywords set, they will be automatically generated. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Image Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_rules_list[ai_command_image][]" placeholder="Please insert a command for the AI image generator" class="cr_width_full">' . esc_textarea($ai_command_image) . '</textarea>
                         
         </div>
         </td></tr>
         <tr class="hideDalle' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI model you wish to use for image the image generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Image Model", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[image_model][]" class="cr_width_full">
                                   <option value="dalle2"';
             if ($image_model == 'dalle2') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Dall-E 2", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="dalle3"';
             if ($image_model == 'dalle3') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Dall-E 3", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="dalle3hd"';
             if ($image_model == 'dalle3hd') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Dall-E 3 HD", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
         </div>
         </td></tr>
         <tr class="hideImg' . esc_html($cont) . '"><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the size of the generated image.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Generated Image Size", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_rules_list[image_size][]" class="cr_width_full">
                                   <option value="256x256"';
             if ($image_size == '256x256') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("256x256 (only for Dall-E 2)", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="512x512"';
             if ($image_size == '512x512') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("512x512 (only for Dall-E 2 & Stable Diffusion)", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="1024x1024"';
             if ($image_size == '1024x1024') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("1024x1024", 'aiomatic-automatic-ai-content-writer') . '</option>
             <option value="1792x1024"';
            if ($image_size == '1792x1024') {
            $output .= ' selected';
            }
            $output .= '>' . esc_html__("1792x1024 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer') . '</option>
            <option value="1024x1792"';
            if ($image_size == '1024x1792') {
            $output .= ' selected';
            }
            $output .= '>' . esc_html__("1024x1792 (only for Dall-E 3)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
         </div>
         </td></tr><tr><td>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Insert a comma separated list of links to valid images that will be set randomly for the featured image for the posts that do not have a valid image attached or if you disabled automatical featured image generator. You can also use image numeric IDs from images found in the Media Gallery. To disable this feature, leave this field blank. Spintax supported. You can also use the %%random_image[keyword]%% shortcode to automatically import a random image from Google Image Search with the Creative Commons filter applied. To get a related image, you can also use: %%random_image[%%post_title%%]%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Default Featured Image List", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[image_url][]" placeholder="Please insert the link to a valid image (spintax supported)">' . esc_textarea($image_url) . '</textarea>
                     
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Posting Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
           <tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("HTML Text To Prepend To AI Created Content", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                       <textarea rows="2" cols="70" name="aiomatic_rules_list[post_prepend][]" placeholder="HTML content to prepend to the AI generated content" class="cr_width_full">' . esc_textarea($post_prepend) . '</textarea>
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a HTML text that should be append to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("HTML Text To Append To AI Created Content", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                       <textarea rows="2" cols="70" name="aiomatic_rules_list[post_append][]" placeholder="HTML content to append to the AI generated content" class="cr_width_full">' . esc_textarea($post_append) . '</textarea>
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Custom Shortcode Creator (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b><span class="tool" data-tip="Supported models: ' . implode(',', aiomatic_get_all_models()) . '">&nbsp;&#9432;</span>
                       </td><td>
                       <textarea rows="2" cols="70" name="aiomatic_rules_list[custom_shortcodes][]" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="cr_width_full">' . esc_textarea($custom_shortcodes) . '</textarea>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Strip Title From Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="strip_title" name="aiomatic_rules_list[strip_title][]"';
           if($strip_title == '1')
           {
               $output .= ' checked';
           }
           $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to skip spinning of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Do Not Spin Posts Generated By This Rule", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="skip_spin" name="aiomatic_rules_list[skip_spin][]"';
           if($skip_spin == '1')
           {
               $output .= ' checked';
           }
           $output .= '>               
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to skip translating of posts generated by this rule?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Do Not Translate Posts Generated By This Rule", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="skip_translate" name="aiomatic_rules_list[skip_translate][]"';
           if($skip_translate == '1')
           {
               $output .= ' checked';
           }
           $output .= '>               
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to process each title from the added list only once.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Process Each Title/Topic Only Once", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="title_once" name="aiomatic_rules_list[title_once][]"';
           if($title_once == '1')
           {
               $output .= ' checked';
           }
           $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to overwrite existing posts during the publishing process.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Overwrite Existing Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="overwrite_existing" name="aiomatic_rules_list[overwrite_existing][]"';
           if($overwrite_existing == '1')
           {
               $output .= ' checked';
           }
           $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Run Regex On Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[strip_by_regex][]" placeholder="regex" class="cr_width_full">' . esc_textarea($strip_by_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Replace Matches From Regex (Content)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" class="cr_width_full" name="aiomatic_rules_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full">' . esc_textarea($replace_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the author that you want to assign for the automatically generated posts.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Author", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                       </td><td class="cr_min_width_200">
                       <select autocomplete="off" id="post_author" name="aiomatic_rules_list[post_author][]" class="cr_width_full">';
                       $output .= '<option value="rand"';
                       if ($post_user_name == "rand") {
                               $output .= " selected";
                           }
                       $output .= '>' . esc_html__("Random user", 'aiomatic-automatic-ai-content-writer') . '</option>';
               $blogusers = get_users( [ 'role__in' => [ 'contributor', 'author', 'editor', 'administrator' ] ] );
               foreach ($blogusers as $user) {
                   $output .= '<option value="' . esc_html($user->ID) . '"';
                   if ($post_user_name == $user->ID) {
                       $output .= " selected";
                   }
                   $output .= '>' . esc_html($user->display_name) . '</option>';
               }
               $output .= '</select>  
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the status that you want for the automatically generated posts to have.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Status", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                       </td><td class="cr_min_width_200">
                       <select autocomplete="off" id="submit_status" name="aiomatic_rules_list[submit_status][]" class="cr_width_full">
                                     <option value="pending"';
               if ($status == 'pending') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                                     <option value="draft"';
               if ($status == 'draft') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                                     <option value="publish"';
               if ($status == 'publish') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                                     <option value="private"';
               if ($status == 'private') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                                     <option value="trash"';
               if ($status == 'trash') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>
                       </select>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the type (post/page) for your automatically generated item.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Item Type", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                       </td><td class="cr_min_width_200">
                       <select autocomplete="off" id="default_type" name="aiomatic_rules_list[default_type][]" class="cr_width_full">';
               foreach ( get_post_types( '', 'names' ) as $post_type ) {
                  if(strstr($post_type, 'aiomatic_'))
                  {
                     continue;
                  }
                  $output .= '<option value="' . esc_attr($post_type) . '"';
                  if ($def_type == $post_type) {
                       $output .= ' selected';
                   }
                  $output .= '>' . esc_html($post_type) . '</option>';
               }
                       $output .= '</select>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__('If your template supports "Post Formats", than you can select one here. If not, leave this at it\'s default value.', 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Format", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                       </td><td>
                       <select autocomplete="off" id="post_format" name="aiomatic_rules_list[post_format][]" class="cr_width_full">
                       <option value="post-format-standard"';
               if ($post_format == 'post-format-standard') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Standard", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-aside"';
               if ($post_format == 'post-format-aside') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Aside", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-gallery"';
               if ($post_format == 'post-format-gallery') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Gallery", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-link"';
               if ($post_format == 'post-format-link') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Link", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-image"';
               if ($post_format == 'post-format-image') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Image", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-quote"';
               if ($post_format == 'post-format-quote') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Quote", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-status"';
               if ($post_format == 'post-format-status') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Status", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-video"';
               if ($post_format == 'post-format-video') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Video", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-audio"';
               if ($post_format == 'post-format-audio') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Audio", 'aiomatic-automatic-ai-content-writer') . '</option>
                       <option value="post-format-chat"';
               if ($post_format == 'post-format-chat') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Chat", 'aiomatic-automatic-ai-content-writer') . '</option>
                   </select>     
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the ID of the parent of created posts. This is useful for BBPress integration, to assign forum IDs for created topics or for other similar functionalities.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Parent ID", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="text" class="cr_width_full" name="aiomatic_rules_list[parent_id][]" value="' . esc_attr($parent_id) . '" placeholder="Post parent ID" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable comments for the generated posts?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Comments For Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_comments" name="aiomatic_rules_list[enable_comments][]"';
               if ($enable_comments == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable pingbacks and trackbacks for the generated posts?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Pingback/Trackback", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_pingback" name="aiomatic_rules_list[enable_pingback][]"';
               if ($enable_pingback == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . 
                                           sprintf( wp_kses( __( "Do you want to set a custom post publish date for posts? Set the range in the below field Accepted values for this field are listed: <a href='%s' target='_blank'>here</a>. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( 'https://www.php.net/manual/en/datetime.formats.php' ) ) . '
                           </div>
                       </div>
                       <b>' . esc_html__("Set a Custom Post Publish Date Range", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="text" id="min_time" name="aiomatic_rules_list[min_time][]" value="' . esc_attr($min_time) . '" placeholder="Start time" class="cr_half"> - <input type="text" id="max_time" name="aiomatic_rules_list[max_time][]" value="' . esc_attr($max_time) . '" placeholder="End time" class="cr_half">   
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Fields", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       
                       </td><td>
                       <textarea rows="1" cols="70" name="aiomatic_rules_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%post_title%%" class="cr_width_full">' . esc_textarea($custom_fields) . '</textarea>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . You can also set hierarhical taxonomies (parent > child), in this format: custom_taxonomy_name => parent1 > child1 . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Taxonomies", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                         <textarea rows="1" cols="70" name="aiomatic_rules_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%post_title%%" class="cr_width_full">' . esc_textarea($custom_tax) . '</textarea>  
           </div>
           </td></tr><tr><td>
           <div>
          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                          <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Enter a 2 letter language code that will be assigned as the WPML/Polylang language for posts. Example: for German, input: de", 'aiomatic-automatic-ai-content-writer') . '
                          </div>
                      </div>
                      <b>' . esc_html__("Assign WPML/Polylang Language to Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                      
                      </td><td>
                      <input type="text" class="cr_width_full" name="aiomatic_rules_list[wpml_lang][]" value="' . esc_attr($wpml_lang) . '" placeholder="WPML/Polylang language" class="cr_width_full">
                          
          </div>
          </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Scheduling Restrictions', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the days of the week when you don't want to run this rule. You can enter a comma separate list of day names.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Do Not Run This Rule On The Following Days Of The Week", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     <br/>' . esc_html__("Current Server Time:", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . date('l', time()) . ', ' . date("Y-m-d H:i:s") . '
                     </td><td>
                     <input type="text" class="cr_width_full" name="aiomatic_rules_list[days_no_run][]" value="' . esc_attr($days_no_run) . '" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">
         </div>
         </td></tr>
         </table></div> 
       </div>
       <div class="codemodalfzr-footer">
         <br/>
         <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3><span id="aiomatic_ok' . esc_html($cont) . '" class="codeokfzr cr_inline">OK&nbsp;</span>
         <br/><br/>
       </div>
     </div>
   
   </div>       
                       </td>
   						<td class="cr_shrt_td2"><span class="wpaiomatic-delete">X</span></td>
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_rules_list[active][]" class="activateDeactivateClass" value="1"';
               if (isset($active) && $active === '1') {
                   $output .= ' checked';
               }
               $output .= '/>
                           <input type="hidden" name="aiomatic_rules_list[last_run][]" value="' . esc_attr($last_run) . '"/>
                           <input type="hidden" name="aiomatic_rules_list[rule_unique_id][]" value="' . esc_attr($rule_unique_id) . '"/></td>
                           <td class="cr_shrt_td2"><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( 'Shortcode for this rule<br/>(to cross-post from this plugin in other plugins):', 'aiomatic-automatic-ai-content-writer'), array(  'br' => array( ) ) ) ) . '<br/><b>%%aiomatic_0_' . esc_html($cont) . '%% and %%aiomatic_title_0_' . esc_html($cont) . '%%</b><br/>' . esc_html__('Posts Generated:', 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($generated_posts) . '<br/>';
               if ($generated_posts != 0) {
                   $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=Aiomatic_0_' . esc_html($cont) . '&post_type=' . esc_html($def_type) . '" target="_blank">' . esc_html__('View Generated Posts', 'aiomatic-automatic-ai-content-writer') . '</a><br/>';
               }
               $output .= esc_html__('Last Run: ', 'aiomatic-automatic-ai-content-writer');
               if ($last_run == '1988-01-27 00:00:00') {
                   $output .= 'Never';
               } else {
                   $output .= $last_run;
               }
               $output .= '<br/>' . esc_html__('Next Run: ', 'aiomatic-automatic-ai-content-writer');
               if($unlocker == '1')
               {
                   $nextrun = aiomatic_add_minute($last_run, $schedule);
               }
               else
               {
                   $nextrun = aiomatic_add_hour($last_run, $schedule);
               }
               $now     = aiomatic_get_date_now();
               if (isset($active) && $active === '1') {
                  if($unlocker == '1')
                  {
                     $aiomatic_hour_diff = (int)aiomatic_minute_diff($now, $nextrun);
                  }
                  else
                  {
                     $aiomatic_hour_diff = (int)aiomatic_hour_diff($now, $nextrun);
                  }
                   if ($aiomatic_hour_diff >= 0) {
                     if($unlocker == '1')
                     {
                         $append = 'Now.';
                     }
                     else
                     {
                         $append = 'Now.';
                     }
                       $cron   = _get_cron_array();
                       if ($cron != FALSE) {
                           $date_format = _x('Y-m-d H:i:s', 'Date Time Format1', 'aiomatic-automatic-ai-content-writer');
                           foreach ($cron as $timestamp => $cronhooks) {
                               foreach ((array) $cronhooks as $hook => $events) {
                                   if ($hook == 'aiomaticaction') {
                                       foreach ((array) $events as $key => $event) {
                                           $append = date_i18n($date_format, $timestamp);
                                       }
                                   }
                               }
                           }
                       }
                       $output .= $append;
                   } else {
                       $output .= $nextrun;
                   }
               } else {
                   $output .= esc_html__('Rule Disabled', 'aiomatic-automatic-ai-content-writer');
               }
               $output .= '<br/>' . esc_html__('Local Time: ', 'aiomatic-automatic-ai-content-writer') . $now;
               $output .= '</div>
                       </div></td>
                           <td class="cr_center">
                           <div>
                           <img id="run_img' . esc_html($cont) . '" src="' . plugin_dir_url(dirname(__FILE__)) . 'images/running.gif' . '" alt="Running" class="cr_status_icon';
               if (!empty($running)) {
                  if (!in_array(array($cont => 0), $running)) {
                        $f = fopen(get_temp_dir() . 'aiomatic_0_' . $cont, 'w');
                        if($f !== false)
                        {
                           flock($f, LOCK_UN);
                           fclose($f);
                           global $wp_filesystem;
                           if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                 include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                 wp_filesystem($creds);
                           }
                           $wp_filesystem->delete(get_temp_dir() . 'aiomatic_0_' . $cont);
                        }
                        $output .= ' cr_hidden';
                   }
                   else
                   {
                       $f = fopen(get_temp_dir() . 'aiomatic_0_' . $cont, 'w');
                       if($f !== false)
                       {
                           if (!flock($f, LOCK_EX | LOCK_NB)) {
                           }
                           else
                           {
                               $output .= ' cr_hidden';
                               flock($f, LOCK_UN);
                               if (($xxkey = array_search(array($cont => 0), $running)) !== false) {
                                   unset($running[$xxkey]);
                                   update_option('aiomatic_running_list', $running);
                               }
                           }
                       }
                   }
               } 
               else 
               {
                  $f = fopen(get_temp_dir() . 'aiomatic_0_' . $cont, 'w');
                  if($f !== false)
                  {
                     flock($f, LOCK_UN);
                     fclose($f);
                     global $wp_filesystem;
                     if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                        wp_filesystem($creds);
                     }
                     $wp_filesystem->delete(get_temp_dir() . 'aiomatic_0_' . $cont);
                  }
                  $output .= ' cr_hidden';
               }
               $output .= '" title="status">
                           <div class="codemainfzr cr_width_80p">
                           <select autocomplete="off" class="codemainfzr" id="actions" class="actions" name="actions" onchange="actionsChangedManual(' . esc_html($cont) . ', this.value, 0, \'' . esc_html($rule_unique_id) . '\');" onfocus="this.selectedIndex = 0;">
                               <option value="select" disabled selected>' . esc_html__("Select an Action", 'aiomatic-automatic-ai-content-writer') . '</option>
                               <option value="run">' . esc_html__("Run This Rule Now", 'aiomatic-automatic-ai-content-writer') . '</option>
                               <option value="duplicate">' . esc_html__("Duplicate This Rule", 'aiomatic-automatic-ai-content-writer') . '</option>
                               <option value="up">' . esc_html__("Move This Rule Up", 'aiomatic-automatic-ai-content-writer') . '</option>
                               <option value="down">' . esc_html__("Move This Rule Down", 'aiomatic-automatic-ai-content-writer') . '</option>
                               <option value="trash">' . esc_html__("Send All Posts To Trash", 'aiomatic-automatic-ai-content-writer') . '</option>
                               <option value="delete">' . esc_html__("Permanently Delete All Posts", 'aiomatic-automatic-ai-content-writer') . '</option>
                           </select>
                           </div>
                           </div>
                           </td>
   					</tr>	
   					';
               $cont = $cont + 1;
           }
       }
       return $output;
   }
   ?>