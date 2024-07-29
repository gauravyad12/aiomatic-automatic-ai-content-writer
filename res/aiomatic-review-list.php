<?php
   function aiomatic_review_panel()
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
   $all_rules = get_option('aiomatic_review_list', array());
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
        <h1><?php echo esc_html__("Amazon Product Reviews", 'aiomatic-automatic-ai-content-writer');?></h1>
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
                              <span id="aiomatic_mode_title"><?php echo esc_html__("Single Product ASIN or Keyword", 'aiomatic-automatic-ai-content-writer');?>*</span>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Please provide a single ASIN of an Amazon product (ex: B07RZ74VLR). To create multiple product review posts, add a different ASIN, each on a new line.", 'aiomatic-automatic-ai-content-writer');
                                       if(!function_exists('is_plugin_active'))
                                       {
                                          include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                                       }
                                       $amaz_ext_active = false;
                                       if (is_plugin_active('aiomatic-extension-amazon-api/aiomatic-extension-amazon-api.php')) 
                                       {
                                          $amaz_ext_active = true;
                                       }
                                       if(isset($aiomatic_Main_Settings['amazon_app_id']) && trim($aiomatic_Main_Settings['amazon_app_id']) != '' && isset($aiomatic_Main_Settings['amazon_app_secret']) && trim($aiomatic_Main_Settings['amazon_app_secret']) != '' && $amaz_ext_active == true)
	                                    {
                                          echo '<br/><br/>' . esc_html__("Because you are using the 'Aiomatic Extension: Amazon API' extension, you can query Amazon API also by product categories. To do so, enter at the end of the keyword you are searching for, the category, in this format:", 'aiomatic-automatic-ai-content-writer') . '<br/><br/>' . 
                                          '<b>category: HomeAndKitchen</b>' . '<br/>' .
                                          '<b>pan category: HomeAndKitchen</b>' . '<br/>' .
                                          '<b>french fries category: HomeAndKitchen</b>' . '<br/><br/>' .
                                          esc_html__("Possible category values are: ", 'aiomatic-automatic-ai-content-writer') . '<br>' .                                 
'<i>' . implode(', ', AIOMATIC_AMAZON_CATEGORIES) . '</i>' . '<br/><br/>' . 
                                          esc_html__("Check valid values for your locale, here: ", 'aiomatic-automatic-ai-content-writer') . '<br/><a href="https://webservices.amazon.de/paapi5/documentation/locale-reference.html" target="_blank">Locale Reference for Product Advertising API</a>';
                                       }
                                       else
                                       {
                                          if($amaz_ext_active == true)
                                          {
                                             echo '&nbsp;' . esc_html__("To filter products by categories, you also need to enter your Amazon API key in the Aiomatic's 'Settings', afterwards, more details will appear here about the category filtering options.", 'aiomatic-automatic-ai-content-writer');
                                          }
                                          else
                                          {
                                             echo '&nbsp;' . esc_html__("If you activate the 'Aiomatic Extension: Amazon API' plugin, which adds support for Amazon API access to Aiomatic, and also add your Amazon API key and secret in the plugin settings, you will be able to query Amazon also by product categories. Activate the Amazon Extension plugin and more details will appear here about usage.", 'aiomatic-automatic-ai-content-writer');
                                          }
                                       }
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
                           echo aiomatic_expand_rules_review();
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
                           <td class="cr_short_td"><input type="text" name="aiomatic_review_list[rule_description][]" id="rule_description" class="cr_center" placeholder="Rule ID" value="" class="cr_width_full"/></td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_review_list[review_keyword][]" placeholder="Example: B07RZ74VLR" class="cr_width_full"></textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" name="aiomatic_review_list[schedule][]" max="8765812" class="cr_width_60" placeholder="Select the rule schedule interval" value="24"/></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" name="aiomatic_review_list[max][]" class="cr_width_60" placeholder="Select the # of generated posts" value="1" /></td>
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
                                                <td><select id="assistant_id" name="aiomatic_review_list[assistant_id][]" class="cr_width_full" onchange="assistantSelected('');">
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
                                             <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Amazon Search Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo sprintf( wp_kses( __( "Insert your Amazon Associate ID (Optional). Learn how to get one <a href='%s' target='_blank'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html', 'https://affiliate-program.amazon.com/assoc_credentials/home' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Amazon Associate ID (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_review_list[affiliate_id][]" value="" placeholder="Please insert your Amazon Affiliate ID" class="cr_width_full">  
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the country where you have registred your affiliate account.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Amazon Target Country:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                             <select id="source" name="aiomatic_review_list[target_country][]" class="cr_width_full">
                                             <?php
                                                $amaz_countries = aiomatic_get_amazon_codes();
                                                foreach ($amaz_countries as $key => $value) {
                                                   echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
                                                }
                                                ?>
                                             </select>  
                                                </td>
                                             </tr>
                                             <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("AI Writer Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Sections List (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[post_sections_list][]" placeholder="Post sections list (one per line)" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <input type="text" id="section_count" name="aiomatic_review_list[section_count][]" placeholder="3-4" class="cr_width_full" value="3-4">  
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select what you want to do with product titles in articles.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Headings To Content As:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="sections_role" name="aiomatic_review_list[sections_role][]">
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
                                             <tr>
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
                                                <input type="text" id="paragraph_count" name="aiomatic_review_list[paragraph_count][]" placeholder="2-3" class="cr_width_full" value="2">  
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add the product image to the article.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Product Images To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="topic_images" name="aiomatic_review_list[topic_images][]" checked>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you don't want to add the product links directly to headings.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Don't Add Product Links to Headings:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="no_headlink" name="aiomatic_review_list[no_headlink][]">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you would like to add a relevant YouTube video to the end of the created article.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add A Relevant YouTube Video To The Article:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="topic_videos" name="aiomatic_review_list[topic_videos][]">
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <input type="text" name="aiomatic_review_list[title_outro][]" value="{Experience the Difference|Unlock Your Potential|Elevate Your Lifestyle|Embrace a New Era|Seize the Opportunity|Discover the Power|Transform Your World|Unleash Your True Potential|Embody Excellence|Achieve New Heights|Experience Innovation|Ignite Your Passion|Reveal the Extraordinary}" placeholder="Optional" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td class="hideTOC-1">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Article 'Table Of Contents':", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td class="hideTOC-1">
                                                <input type="checkbox" id="enable_toc" name="aiomatic_review_list[enable_toc][]">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td class="hideTOC-1">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article 'Table Of Contents' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td class="hideTOC-1">
                                                <input type="text" name="aiomatic_review_list[title_toc][]" value="Table of Contents" placeholder="Table of Contents" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add a Customer Reviews Analysis section to the created post. To enable Customer Reviews Analysis for articles, be sure to add a prompt also in the 'Article Customer Reviews Analysis Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Article 'Customer Reviews Analysis' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_reviews" name="aiomatic_review_list[enable_reviews][]">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the Customer Reviews Analysis section header. Default is: Customer Reviews Analysis", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article 'Customer Reviews Analysis' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_review_list[title_reviews][]" value="Customer Reviews Analysis" placeholder="Customer Reviews Analysis" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add a Pros & Cons section to the created post. To enable Pros & Cons for articles, be sure to add a prompt also in the 'Article Pros & Cons Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Article 'Pros & Cons' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_proscons" name="aiomatic_review_list[enable_proscons][]">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the Pros & Cons section header. Default is: Pros & Cons", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article 'Pros & Cons' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_review_list[title_proscons][]" value="Pros & Cons" placeholder="Pros & Cons" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Add Article 'Q&A' Section:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_qa" name="aiomatic_review_list[enable_qa][]">
                                                </td>
                                             </tr> 
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article 'Q&A' Section Header Text:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="aiomatic_review_list[title_qa][]" value="Q&A" placeholder="Q&A" class="cr_width_full">
                                                </td>
                                             </tr> 
                                             <tr><td colspan="2">
                                                  <h4><?php echo esc_html__("Content Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr>
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
                                                <input id="content_language" name="aiomatic_review_list[content_language][]" type="text" list="languages" placeholder="Created content language" class="coderevolution_gutenberg_input" value="English"/>
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
                                             <tr>
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
                                                <input id="writing_style" name="aiomatic_review_list[writing_style][]" type="text" placeholder="Created content writing style" list="writing_styles" class="coderevolution_gutenberg_input" value="Creative"/>
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
                                             <tr>
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
                                                <input id="writing_tone" name="aiomatic_review_list[writing_tone][]" type="text" list="writing_tones" placeholder="Created content writing tone" class="coderevolution_gutenberg_input" value="Neutral"/>
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
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the point of view of the article.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Point Of View:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select autocomplete="off" class="cr_width_full" id="point_of_view" name="aiomatic_review_list[point_of_view][]">
                                                <option value="First Person Singular (I, me, my, mine)"><?php echo esc_html__("First Person Singular (I, me, my, mine)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="First Person Plural (we, us, our, ours)" selected><?php echo esc_html__("First Person Plural (we, us, our, ours)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="Second Person Singular (you, your, yours)"><?php echo esc_html__("Second Person Singular (you, your, yours)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="Second Person Plural (you [plural], y'all, you guys)"><?php echo esc_html__("Second Person Plural (you [plural], y'all, you guys)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="Third Person Singular (he, she, it)"><?php echo esc_html__("Third Person Singular (he, she, it)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                <option value="Third Person Plural (they, them, theirs, themselves)"><?php echo esc_html__("Third Person Plural (they, them, theirs, themselves)", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>   
                                                </td>
                                             </tr>
                                             <tr><td colspan="2">
                                                  <h4><?php echo esc_html__("Prompts", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Title Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[title_prompt][]" placeholder="Enter your title prompts, one per line" class="cr_width_full">Write a title for a product review blog post of the following product: "%%product_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Point of View: %%point_of_view%%. The title must be between 40 and 60 characters. The description of the product is: "%%product_description%%".</textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_title_model" name="aiomatic_review_list[topic_title_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the intro of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Intro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[intro_prompt][]" placeholder="Enter your intro prompts, one per line" class="cr_width_full">Write an introduction for a product review blog post of the following product: "%%product_title%%". The post is reviewing the product "%%product_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Point of View: %%point_of_view%%. Write as if you had first-hand experience with the product you are describing. The description of the product is: "%%product_description%%".</textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_intro_model" name="aiomatic_review_list[topic_intro_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the main Sections of the article. These will be set also as headings in the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%sections_count%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Sections Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[sections_prompt][]" placeholder="Enter your sections prompts, one per line" class="cr_width_full">Write %%sections_count%% consecutive headings for a product review article of the "%%product_title%%" product, that starts with an overview, highlights specific features and aspects of the product, provides detailed insights and specific recommendations. The headings should be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Point of view: %%point_of_view%%. Don't add numbers to the headings, hyphens or any types of quotes. Write as if you had first-hand experience with the product you are describing. Return only the headings list, nothing else.</textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_sections_model" name="aiomatic_review_list[topic_sections_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %current_section%%, %%article_so_far%%, %%last_section_content%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Content Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="3" cols="70" name="aiomatic_review_list[content_prompt][]" placeholder="Enter your content prompt" class="cr_width_full">Write the content of a product review post, for the following section heading: "%%current_section%%". The post is reviewing the product "%%product_title%%" in %%language%%. Don't repeat the product title in the created content, also don't be repetitive in general. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Act as a Content Writer, not as a Virtual Assistant. Return only the content requested, without any additional comments or text. The content provided will be automatically published on my website. Add a engaging Call to Action link to: %%aff_url%%. Be sure to add the following HTML classes to the call to action button: "button btn btn-primary". Writing Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Extract content from the following product description: "%%product_description%%".</textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_content_model" name="aiomatic_review_list[topic_content_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the Customer Reviews Analysis section of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Customer Reviews Analysis Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[reviews_prompt][]" placeholder="Enter your Customer Reviews Analysis prompts, one per line" class="cr_width_full">Write the content of a "Customer Reviews Analysis" section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Use HTML for formatting. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. List of customer reviews: "%%product_reviews%%". </textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the Customer Reviews Analysis generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Customer Reviews Analysis Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_reviews_model" name="aiomatic_review_list[topic_reviews_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the Pros & Cons section of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Pros & Cons Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[proscons_prompt][]" placeholder="Enter your Pros & Cons prompts, one per line" class="cr_width_full">Write the content of a "Pros & Cons" section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%.Use HTML for formatting. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Product description: "%%product_description%%". </textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the AI Model to be used for the Pros & Cons generator.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("AI Model For Pros & Cons Generator:", 'aiomatic-automatic-ai-content-writer');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select autocomplete="off" id="topic_proscons_model" name="aiomatic_review_list[topic_proscons_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the Q&A of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Q&A Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[qa_prompt][]" placeholder="Enter your Q&A prompts, one per line" class="cr_width_full">Write the content of a Q&A section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Product description: "%%product_description%%".</textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_qa_model" name="aiomatic_review_list[topic_qa_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the outro of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Outro Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[outro_prompt][]" placeholder="Enter your outro prompts, one per line" class="cr_width_full">Write an outro for a product review blog post, for the product: "%%product_title%%". The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Product description: "%%product_description%%". Add also an engaging final call to action link, in a clickable HTML format (don't use markdown language), leading to the link of the product: "%%aff_url%%".</textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_outro_model" name="aiomatic_review_list[topic_outro_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Prompt to be used for the excerpt of the article. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Excerpt Prompt:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[excerpt_prompt][]" placeholder="Enter your excerpt prompts, one per line" class="cr_width_full">Write a short excerpt for a product review blog post, for the product: "%%product_title%%". The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. The excerpt must be between 100 and 150 words. </textarea>
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <select autocomplete="off" id="topic_excerpt_model" name="aiomatic_review_list[topic_excerpt_model][]" class="hideAssistant cr_width_full">
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
                                             <tr><td colspan="2">
                                                  <h4><?php echo esc_html__("Advanced Prompting Options", 'aiomatic-automatic-ai-content-writer');?>:</h4>
                                             </td></tr>
                                             <tr>
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
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[strip_by_regex_prompts][]" placeholder="regex expression" class="cr_width_full"></textarea>
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
                                                      <b><?php echo esc_html__("Replace Matches From Regex (Prompts):", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[replace_regex_prompts][]" placeholder="regex replacement" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, reviews, proscons, qa, outro, excerpt", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Run Above Regex On Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input id="run_regex_on" name="aiomatic_review_list[run_regex_on][]" type="text" list="run_regex_on_list" class="coderevolution_gutenberg_input" value="content"/>
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
                                          <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Global Prompt Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prepend Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[global_prepend][]" placeholder="Global prompt prepend text" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Append Text To All Textual AI Prompts:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[global_append][]" placeholder="Global prompt append text" class="cr_width_full"></textarea>
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
                                                <select autocomplete="off" class="cr_width_full" id="link_type" onchange="hideLinks('');" name="aiomatic_review_list[link_type][]">
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
                                                <input type="text" name="aiomatic_review_list[max_links][]" placeholder="Add the number of links to enable this feature" class="cr_width_full">
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
                                                <textarea rows="1" cols="70" name="aiomatic_review_list[link_list][]" placeholder="URL list (one per line)" class="cr_width_full"></textarea>
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
                                                <input type="checkbox" id="link_nofollow" name="aiomatic_review_list[link_nofollow][]">
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
                                                <input type="text" name="aiomatic_review_list[link_post_types][]" placeholder="post" class="cr_width_full">
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
                                                <select autocomplete="off" class="cr_width_full" id="auto_categories" name="aiomatic_review_list[auto_categories][]">
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
                                                <select autocomplete="off" id="category_model" name="aiomatic_review_list[category_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to AI for generating post categories. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Category Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[category_ai_command][]" placeholder="Write a comma separated list of categories, for the post title: %%post_title%%" class="cr_width_full">Generate a comma-separated list of relevant categories for the post title: "%%post_title%%". These categories must accurately categorize the article within the broader topics or themes of your blog, aiding in the organization and navigation of your content.</textarea>
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
                                             <select multiple id="default_category" name="aiomatic_review_list[default_category][]" class="cr_width_full" onmouseover="this.size=this.length;" onmouseout="this.size=4;">
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
                                                <input type="checkbox" id="remove_default" name="aiomatic_review_list[remove_default][]" checked>
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
                                                <input type="checkbox" id="skip_inexist" name="aiomatic_review_list[skip_inexist][]" checked>
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
                                                <select autocomplete="off" class="cr_width_full" id="auto_tags" name="aiomatic_review_list[auto_tags][]">
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
                                                <select autocomplete="off" id="tag_model" name="aiomatic_review_list[tag_model][]" class="hideAssistant cr_width_full">
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
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to AI for generating post tags. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Post Tag Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[tag_ai_command][]" placeholder="Write a comma separated list of tags, for the post title: %%post_title%%" class="cr_width_full">Generate a comma-separated list of relevant tags for the post title: "%%post_title%%". These tags must accurately reflect the key topics, themes, or keywords associated with the article and help improve its discoverability and organization.</textarea>
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
                                                <input type="text" name="aiomatic_review_list[default_tags][]" value="" placeholder="Please insert your additional post tags here" class="cr_width_full">
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
                                                <input type="number" min="1" max="128000" name="aiomatic_review_list[max_tokens][]" value="" placeholder="2048" class="cr_width_full">
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
                                                <input type="number" min="1" max="128000" name="aiomatic_review_list[max_seed_tokens][]" value="" placeholder="1000" class="cr_width_full">
                                                </td>
                                             </tr>
                                             <tr>
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
                                                <input type="number" min="1" max="128000" name="aiomatic_review_list[max_continue_tokens][]" value="" placeholder="500" class="cr_width_full">
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
                                                <input type="number" min="0" step="0.1" max="2" name="aiomatic_review_list[temperature][]" value="" placeholder="1" class="cr_width_full">
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
                                                <input type="number" min="0" max="1" step="0.1" name="aiomatic_review_list[top_p][]" value="" placeholder="1" class="cr_width_full">
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
                                                <input type="number" min="-2" step="0.1" max="2" name="aiomatic_review_list[presence_penalty][]" value="" placeholder="0" class="cr_width_full">
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
                                                <input type="number" min="0" max="2" step="0.1" name="aiomatic_review_list[frequency_penalty][]" value="" placeholder="0" class="cr_width_full">
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
                                             <select autocomplete="off" id="royalty_free" name="aiomatic_review_list[royalty_free][]" class="cr_width_full">
                                                   <option value="0"><?php echo esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="1"><?php echo esc_html__("AI Image From Below Selector", 'aiomatic-automatic-ai-content-writer');?></option>
                                                   <option value="2" selected><?php echo esc_html__("Amazon Product Thumbnail", 'aiomatic-automatic-ai-content-writer');?></option>
                                                </select>
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
                                                <select autocomplete="off" id="search_query_repetition" name="aiomatic_review_list[search_query_repetition][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="enable_ai_images" onchange="hideImage('');" name="aiomatic_review_list[enable_ai_images][]" class="cr_width_full">
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
                                                               echo esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               echo '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' );
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Prompt For The AI Image Generator:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[ai_command_image][]" placeholder="Please insert a command for the AI image generator" class="cr_width_full">A high detail image with no text of: "%%post_title%%"</textarea>
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
                                                <select autocomplete="off" id="image_model" name="aiomatic_review_list[image_model][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="model" name="aiomatic_review_list[image_size][]" class="cr_width_full">
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
                                                   <textarea class="cr_width_60p" rows="1" name="aiomatic_review_list[image_url][]" placeholder="Please insert the link to a valid image (spintax supported)"></textarea>
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
                                                               echo esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("HTML Text To Prepend To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[post_prepend][]" placeholder="HTML content to prepend to the AI generated content" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Enter a HTML text that should be appended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("HTML Text To Append To AI Created Content:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[post_append][]" placeholder="HTML content to append to the AI generated content" class="cr_width_full"></textarea>
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
                                                <textarea rows="2" cols="70" name="aiomatic_review_list[custom_shortcodes][]" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="cr_width_full"></textarea>
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
                                                <input type="checkbox" id="strip_title" name="aiomatic_review_list[strip_title][]">
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
                                                <input type="checkbox" id="skip_spin" name="aiomatic_review_list[skip_spin][]">               
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
                                                <input type="checkbox" id="skip_translate" name="aiomatic_review_list[skip_translate][]">               
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
                                                      <b><?php echo esc_html__("Process Each Title/Keyword Only Once:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="title_once" name="aiomatic_review_list[title_once][]" checked>
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
                                                <input type="checkbox" id="overwrite_existing" name="aiomatic_review_list[overwrite_existing][]">
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
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[strip_by_regex][]" placeholder="regex expression" class="cr_width_full"></textarea>
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
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full"></textarea>
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
                                                <select autocomplete="off" id="post_author" name="aiomatic_review_list[post_author][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="submit_status" name="aiomatic_review_list[submit_status][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="default_type" name="aiomatic_review_list[default_type][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="post_format" name="aiomatic_review_list[post_format][]" class="cr_width_full">
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
                                             <input type="number" min="1" class="cr_width_full" name="aiomatic_review_list[parent_id][]" value="" placeholder="Post parent ID" class="cr_width_full">
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
                                                <input type="checkbox" id="enable_comments" name="aiomatic_review_list[enable_comments][]" checked>
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
                                                <input type="checkbox" id="enable_pingback" name="aiomatic_review_list[enable_pingback][]" checked>
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
                                                <input type="text" id="min_time" name="aiomatic_review_list[min_time][]" placeholder="Start time" class="cr_half"> - <input type="text" id="max_time" name="aiomatic_review_list[max_time][]" placeholder="End time" class="cr_half">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text_top cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Custom Fields:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="aiomatic_review_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%post_title%%" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text_top cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . You can also set hierarhical taxonomies (parent > child), in this format: custom_taxonomy_name => parent1 > child1 . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Custom Taxonomies:", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="aiomatic_review_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%post_title%%" class="cr_width_full"></textarea>
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
                                             <input type="text" class="cr_width_full" name="aiomatic_review_list[wpml_lang][]" value="" placeholder="WPML/Polylang language" class="cr_width_full">
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
                                                <input type="text" class="cr_width_full" name="aiomatic_review_list[days_no_run][]" value="" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">  
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
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_review_list[active][]" value="1" checked />
                              <input type="hidden" name="aiomatic_review_list[last_run][]" value="1988-01-27 00:00:00"/>
                           <input type="hidden" name="aiomatic_review_list[rule_unique_id][]" value="<?php echo uniqid('', true);?>"/>
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
         <br/>
         <?php echo esc_html__("New! You can use the [aicontent]Your Prompt[/aicontent] shortcode in this or other", 'aiomatic-automatic-ai-content-writer') . " <a href='https://1.envato.market/coderevolutionplugins' target='_blank'>" . esc_html__("'omatic plugins created by CodeRevolution", 'aiomatic-automatic-ai-content-writer') . "</a>" .  esc_html__(", click for details:", 'aiomatic-automatic-ai-content-writer');?>&nbsp;<a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-ai-generated-content-from-any-plugin-built-by-coderevolution/" target="_blank"><img src="https://i.ibb.co/gvTNWr6/artificial-intelligence-badge.png" alt="artificial-intelligence-badge" title="AI content generator support, when used together with the Aiomatic plugin"></a><br/><br/><a href="https://www.youtube.com/watch?v=5rbnu_uis7Y" target="_blank"><?php echo esc_html__("Nested Shortcodes also supported!", 'aiomatic-automatic-ai-content-writer');?></a><br/><br/><?php echo esc_html__("Confused about rule running status icons?", 'aiomatic-automatic-ai-content-writer');?> <a href="http://coderevolution.ro/knowledge-base/faq/how-to-interpret-the-rule-running-visual-indicators-red-x-yellow-diamond-green-tick-from-inside-plugins/" target="_blank"><?php echo esc_html__("More info", 'aiomatic-automatic-ai-content-writer');?></a><br/>
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
        <h3><?php echo esc_html__("Amazon Product Reviews Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
        <div id="ai-video-container"><br/>
            <iframe class="ai-video" width="560" height="315" src="https://www.youtube.com/embed/X_sxxlbdKXU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
<?php
   }
   if (isset($_POST['aiomatic_review_list'])) {
       add_action('admin_init', 'aiomatic_save_rules_review');
   }
   
   function aiomatic_save_rules_review($data2)
   {
       $init_rules_per_page = get_option('aiomatic_posts_per_page', 12);
       $rules_per_page = get_option('aiomatic_posts_per_page', 12);
       if(isset($_POST['posts_per_page']))
       {
           update_option('aiomatic_posts_per_page', $_POST['posts_per_page']);
       }
       check_admin_referer('aiomatic_save_rules', '_aiomaticr_nonce');
       
       $data2 = $_POST['aiomatic_review_list'];
       $rules = get_option('aiomatic_review_list', array());
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
       if (isset($data2['review_keyword'][0])) {
           for ($i = 0; $i < sizeof($data2['review_keyword']); ++$i) 
           {
               $bundle = array();
               if (isset($data2['schedule'][$i]) && $data2['schedule'][$i] != '' && $data2['review_keyword'][$i] != '') {
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
                   $bundle[]     = $data2['review_keyword'][$i];
                   $bundle[]     = trim(sanitize_text_field($data2['enable_pingback'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_format'][$i]));
                   $bundle[]     = trim($data2['custom_fields'][$i]);
                   $bundle[]     = trim($data2['custom_tax'][$i]);
                   $bundle[]     = trim($data2['temperature'][$i]);
                   $bundle[]     = trim($data2['top_p'][$i]);
                   $bundle[]     = trim($data2['presence_penalty'][$i]);
                   $bundle[]     = trim($data2['frequency_penalty'][$i]);
                   $bundle[]     = trim($data2['royalty_free'][$i]);
                   $bundle[]     = trim($data2['max_tokens'][$i]);
                   $bundle[]     = trim($data2['max_seed_tokens'][$i]);
                   $bundle[]     = trim($data2['max_continue_tokens'][$i]);
                   $bundle[]     = trim($data2['post_prepend'][$i]);
                   $bundle[]     = trim($data2['post_append'][$i]);
                   $bundle[]     = trim($data2['enable_ai_images'][$i]);
                   $bundle[]     = trim($data2['ai_command_image'][$i]);
                   $bundle[]     = trim($data2['image_size'][$i]);
                   $bundle[]     = trim($data2['wpml_lang'][$i]);
                   $bundle[]     = trim($data2['remove_default'][$i]);
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
                   $bundle[]     = trim($data2['affiliate_id'][$i]);
                   $bundle[]     = trim($data2['content_language'][$i]);
                   $bundle[]     = trim($data2['writing_style'][$i]);
                   $bundle[]     = trim($data2['writing_tone'][$i]);
                   $bundle[]     = trim($data2['title_prompt'][$i]);
                   $bundle[]     = trim($data2['content_prompt'][$i]);
                   $bundle[]     = trim($data2['excerpt_prompt'][$i]);
                   $bundle[]     = trim($data2['paragraph_count'][$i]);
                   $bundle[]     = trim($data2['topic_title_model'][$i]);
                   $bundle[]     = trim($data2['topic_content_model'][$i]);
                   $bundle[]     = trim($data2['topic_excerpt_model'][$i]);
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
                   $bundle[]     = trim($data2['target_country'][$i]);
                   $bundle[]     = trim($data2['global_prepend'][$i]);
                   $bundle[]     = trim($data2['global_append'][$i]);
                   $bundle[]     = trim($data2['search_query_repetition'][$i]);
                   $bundle[]     = trim($data2['days_no_run'][$i]);
                   $bundle[]     = trim($data2['overwrite_existing'][$i]);
                   $bundle[]     = trim($data2['link_nofollow'][$i]);
                   $bundle[]     = trim($data2['parent_id'][$i]);
                   $bundle[]     = trim($data2['rule_unique_id'][$i]);
                   $bundle[]     = trim($data2['point_of_view'][$i]);
                   $bundle[]     = trim($data2['sections_prompt'][$i]);
                   $bundle[]     = trim($data2['topic_sections_model'][$i]);
                   $bundle[]     = trim($data2['post_sections_list'][$i]);
                   $bundle[]     = trim($data2['section_count'][$i]);
                   $bundle[]     = trim($data2['proscons_prompt'][$i]);
                   $bundle[]     = trim($data2['topic_proscons_model'][$i]);
                   $bundle[]     = trim($data2['title_proscons'][$i]);
                   $bundle[]     = trim($data2['enable_proscons'][$i]);
                   $bundle[]     = trim($data2['title_reviews'][$i]);
                   $bundle[]     = trim($data2['enable_reviews'][$i]);
                   $bundle[]     = trim($data2['reviews_prompt'][$i]);
                   $bundle[]     = trim($data2['topic_reviews_model'][$i]);
                   $bundle[]     = trim($data2['no_headlink'][$i]);
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
       update_option('aiomatic_review_list', $rules, false);
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
   function aiomatic_expand_rules_review()
   {
       $all_models = aiomatic_get_all_models(true);
       $all_assistants = aiomatic_get_all_assistants(true);
       if (!get_option('aiomatic_running_list')) {
           $running = array();
       } else {
           $running = get_option('aiomatic_running_list');
       }
       $GLOBALS['wp_object_cache']->delete('aiomatic_review_list', 'options');
       $rules  = get_option('aiomatic_review_list');
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
                     if(isset($exp[0]) && isset($exp[1]) && $exp[0] == '3')
                     {
                        $posted_items[] = $exp[1];
                     }
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
           $amaz_countries = aiomatic_get_amazon_codes();
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
               $review_keyword         = $array_my_values[13];
               $enable_pingback        = $array_my_values[14];
               $post_format            = $array_my_values[15];
               $custom_fields          = $array_my_values[16];
               $custom_tax             = $array_my_values[17];
               $temperature            = $array_my_values[18];
               $top_p                  = $array_my_values[19];
               $presence_penalty       = $array_my_values[20];
               $frequency_penalty      = $array_my_values[21];
               $royalty_free           = $array_my_values[22];
               $max_tokens             = $array_my_values[23];
               $max_seed_tokens        = $array_my_values[24];
               $max_continue_tokens    = $array_my_values[25];
               $post_prepend           = $array_my_values[26];
               $post_append            = $array_my_values[27];
               $enable_ai_images       = $array_my_values[28];
               $ai_command_image       = $array_my_values[29];
               $image_size             = $array_my_values[30];
               $wpml_lang              = $array_my_values[31];
               $remove_default         = $array_my_values[32];
               $strip_title            = $array_my_values[33];
               $title_once             = $array_my_values[34];
               $category_model         = $array_my_values[35];
               $category_ai_command    = $array_my_values[36];
               $tag_model              = $array_my_values[37];
               $tag_ai_command         = $array_my_values[38];
               $min_time               = $array_my_values[39];
               $max_time               = $array_my_values[40];
               $skip_spin              = $array_my_values[41];
               $skip_translate         = $array_my_values[42];
               $affiliate_id           = $array_my_values[43];
               $content_language       = $array_my_values[44];
               $writing_style          = $array_my_values[45];
               $writing_tone           = $array_my_values[46];
               $title_prompt           = $array_my_values[47];
               $content_prompt         = $array_my_values[48];
               $excerpt_prompt         = $array_my_values[49];
               $paragraph_count        = $array_my_values[50];
               $topic_title_model      = $array_my_values[51];
               $topic_content_model    = $array_my_values[52];
               $topic_excerpt_model    = $array_my_values[53];
               $intro_prompt           = $array_my_values[54];
               $topic_intro_model      = $array_my_values[55];
               $outro_prompt           = $array_my_values[56];
               $topic_outro_model      = $array_my_values[57];
               $topic_images           = $array_my_values[58];
               $sections_role          = $array_my_values[59];
               $topic_videos           = $array_my_values[60];
               $rule_description       = $array_my_values[61];
               $custom_shortcodes      = $array_my_values[62];
               $strip_by_regex         = $array_my_values[63];
               $replace_regex          = $array_my_values[64];
               $strip_by_regex_prompts = $array_my_values[65];
               $replace_regex_prompts  = $array_my_values[66];
               $run_regex_on           = $array_my_values[67];
               $max_links              = $array_my_values[68];
               $link_post_types        = $array_my_values[69];
               $enable_toc             = $array_my_values[70];
               $title_toc              = $array_my_values[71];
               $qa_prompt              = $array_my_values[72];
               $topic_qa_model         = $array_my_values[73];
               $enable_qa              = $array_my_values[74];
               $title_qa               = $array_my_values[75];
               $title_outro            = $array_my_values[76];
               $link_type              = $array_my_values[77];
               $link_list              = $array_my_values[78];
               $skip_inexist           = $array_my_values[79];
               $target_country         = $array_my_values[80];
               $global_prepend         = $array_my_values[81];
               $global_append          = $array_my_values[82];
               $search_query_repetition= $array_my_values[83];
               $days_no_run            = $array_my_values[84];
               $overwrite_existing     = $array_my_values[85];
               $link_nofollow          = $array_my_values[86];
               $parent_id              = $array_my_values[87];
               $rule_unique_id         = $array_my_values[88];
               $point_of_view          = $array_my_values[89];
               $sections_prompt        = $array_my_values[90];
               $topic_sections_model   = $array_my_values[91];
               $post_sections_list     = $array_my_values[92];
               $section_count          = $array_my_values[93];
               $proscons_prompt        = $array_my_values[94];
               $topic_proscons_model   = $array_my_values[95];
               $title_proscons         = $array_my_values[96];
               $enable_proscons        = $array_my_values[97];
               $title_reviews          = $array_my_values[98];
               $enable_reviews         = $array_my_values[99];
               $reviews_prompt         = $array_my_values[100];
               $topic_reviews_model    = $array_my_values[101];
               $no_headlink            = $array_my_values[102];
               $image_model            = $array_my_values[103];
               $assistant_id           = $array_my_values[104];
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
               $name = md5(get_bloginfo());
               wp_add_inline_script($name . '-footer-script', 'createAdmin(' . esc_html($cont) . ');createModeSelect(' . esc_html($cont) . ');hideLinks(' . esc_html($cont) . ');', 'after');
               $output .= '<tr>
                           <td class="cr_short_td"><input type="text" name="aiomatic_review_list[rule_description][]" id="rule_description' . esc_html($cont) . '" class="cr_center" placeholder="Rule ID" value="' . esc_html($rule_description) . '" class="cr_width_full"/></td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_review_list[review_keyword][]" placeholder="Example: dog food" class="cr_width_full">' . htmlspecialchars($review_keyword) . '</textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" placeholder="# h" name="aiomatic_review_list[schedule][]" max="8765812" value="' . esc_attr($schedule) . '" class="cr_width_60" required></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" placeholder="#" name="aiomatic_review_list[max][]" value="' . esc_attr($max) . '"  class="cr_width_60" required></td>
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
         <table class="responsive table cr_main_table_nowr">
         <tr><td colspan="2"><h3>' . esc_html__("AI Assistant Options", 'aiomatic-automatic-ai-content-writer') . ':</h3>
         </td></tr><tr>
         <td class="cr_min_width_200">
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Assistant to use for content creation. This will disable the ability to select AI models, as the models assisgned to the assistant will be used for content creation.", 'aiomatic-automatic-ai-content-writer') . '</div>
               </div>
               <b>' . esc_html__("AI Assistant Name:", 'aiomatic-automatic-ai-content-writer') . '</b>
         </td>
         <td><select id="assistant_id' . esc_html($cont) . '" name="aiomatic_review_list[assistant_id][]" class="cr_width_full" onchange="assistantSelected(\'' . esc_html($cont) . '\');">';
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
         <tr><td colspan="2"><h3>' . esc_html__('Amazon Search Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( "Insert your Amazon Associate ID (Optional). Learn how to get one <a href='%s' target='_blank'>here</a>. Also, you need to sign up for Amazon Affiliate program <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html', 'https://affiliate-program.amazon.com/assoc_credentials/home' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Amazon Associate ID (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="text" name="aiomatic_review_list[affiliate_id][]" value="' . esc_attr($affiliate_id) . '" placeholder="Please insert your Amazon Affiliate ID" class="cr_width_full">
                         
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum length of captions in prompts. This is useful to have, when captions can be very long.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Amazon Target Country", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <select id="source" name="aiomatic_review_list[target_country][]" class="cr_width_full">';
                        foreach ($amaz_countries as $key => $value) {
                           $output .= '<option value="' . esc_html($key) . '"';
                              if ($target_country == $key) {
                              $output .= " selected";
                              }
                              $output .= '>' . esc_html($value) . '</option>';
                        }
                        $output .= '</select>
                         
         </div>
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('AI Writer Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a list of post sections, one per line. These will be headings of the content. These can also be automatically generated by the plugin. To enable auto generating of sections, leave this field blank. You can use here the %%topic%% shortcode, to get the value of the above topic, automtically. This will set the value of the %%sections%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you set a section list here, each created article will have this same list of sections, because of this, use shortcodes or Spintax when defining these static topics or leave this field blank for the plugin to auto generate them!", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Post Sections List (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[post_sections_list][]" placeholder="Post sections list (one per line)" class="cr_width_full">' . esc_textarea($post_sections_list) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter the number of sections to create in the article. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%sections_count%% shortcode.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Number Of Content Sections To Generate", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="text" id="section_count' . esc_html($cont) . '" name="aiomatic_review_list[section_count][]" placeholder="3-4" class="cr_width_full" value="' . esc_attr($section_count) . '">
         </div>
         </td></tr>
         <tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select what you want to do with product titles in articles.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Add Headings To Content As", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <select autocomplete="off" class="cr_width_full" id="sections_role" name="aiomatic_review_list[sections_role][]">
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter the number of paragraphs to create for each section. These will also be set as article headings. You can also set value ranges, example: 5-7. In this case, a random number will be selected in this range. Please use only numeric values in this field. This field will set the value of the %%paragraphs_per_section%% shortcode.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Number Of Paragraphs Per Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="text" id="paragraph_count' . esc_html($cont) . '" name="aiomatic_review_list[paragraph_count][]" placeholder="2-3" class="cr_width_full" value="' . esc_attr($paragraph_count) . '">
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add the product image to the article.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Product Images To The Article", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="checkbox" id="topic_images" name="aiomatic_review_list[topic_images][]"';
         if($topic_images == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you don't want to add the product links directly to headings.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Don't Add Product Links to Headings", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="checkbox" id="no_headlink" name="aiomatic_review_list[no_headlink][]"';
         if($no_headlink == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you would like to add a relevant YouTube video to the end of the created article.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add A Relevant YouTube Video To The Article", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="checkbox" id="topic_videos" name="aiomatic_review_list[topic_videos][]"';
         if($topic_videos == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the header text of the outro section header. This is optional.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Outro Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="title_outro' . esc_html($cont) . '" name="aiomatic_review_list[title_outro][]" type="text" placeholder="Optional" class="coderevolution_gutenberg_input" value="' . esc_attr($title_outro) . '"/>           
         </div>
         </td></tr>
         <tr><td class="hideTOC' . esc_html($cont) . '">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add a Table of Contents section to the created post.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Article 'Table Of Contents' Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td class="hideTOC' . esc_html($cont) . '">
                     <input type="checkbox" id="enable_toc" name="aiomatic_review_list[enable_toc][]"';
         if($enable_toc == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td class="hideTOC' . esc_html($cont) . '">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the text of the Table of Contents section header. Default is: Table of Contents", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article 'Table Of Contents' Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td class="hideTOC' . esc_html($cont) . '">
                     <input id="title_toc' . esc_html($cont) . '" name="aiomatic_review_list[title_toc][]" type="text" placeholder="Table of Contents" class="coderevolution_gutenberg_input" value="' . esc_attr($title_toc) . '"/>           
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add a Customer Reviews Analysis section to the created post. To enable Customer Reviews Analysis for articles, be sure to add a prompt also in the 'Article Customer Reviews Analysis Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Article 'Customer Reviews Analysis' Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="enable_reviews" name="aiomatic_review_list[enable_reviews][]"';
         if($enable_reviews == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the header text of the Customer Reviews Analysis section header. Default is: Customer Reviews Analysis", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article 'Customer Reviews Analysis' Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="title_reviews' . esc_html($cont) . '" name="aiomatic_review_list[title_reviews][]" type="text" placeholder="Customer Reviews Analysis" class="coderevolution_gutenberg_input" value="' . esc_attr($title_reviews) . '"/>           
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add a Pros & Cons section to the created post. To enable Pros & Cons for articles, be sure to add a prompt also in the 'Article Pros & Cons Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Article 'Pros & Cons' Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="enable_proscons" name="aiomatic_review_list[enable_proscons][]"';
         if($enable_proscons == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the header text of the Pros & Cons section header. Default is: Pros & Cons", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article 'Pros & Cons' Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="title_proscons' . esc_html($cont) . '" name="aiomatic_review_list[title_proscons][]" type="text" placeholder="Pros & Cons" class="coderevolution_gutenberg_input" value="' . esc_attr($title_proscons) . '"/>           
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to add a Q&A section to the created post. To enable Q&A for articles, be sure to add a prompt also in the 'Article Q&A Prompt' settings field from below.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Add Article 'Q&A' Section", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input type="checkbox" id="enable_qa" name="aiomatic_review_list[enable_qa][]"';
         if($enable_qa == '1')
         {
             $output .= ' checked';
         }
         $output .= '>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the header text of the Q&A section header. Default is: Q&A", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article 'Q&A' Section Header Text", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="title_qa' . esc_html($cont) . '" name="aiomatic_review_list[title_qa][]" type="text" placeholder="Q&A" class="coderevolution_gutenberg_input" value="' . esc_attr($title_qa) . '"/>           
         </div>
         </td></tr>
         <tr><td colspan="2"><h4>' . esc_html__('Content Parameters', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the language of the created content. This will set the value of the %%language%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Content Language", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="content_language' . esc_html($cont) . '" name="aiomatic_review_list[content_language][]" type="text" list="languages" placeholder="Created content language" class="coderevolution_gutenberg_input" value="' . esc_attr($content_language) . '"/>                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the writing style of the created content. This will set the value of the %%writing_style%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Writing Style", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="writing_style' . esc_html($cont) . '" name="aiomatic_review_list[writing_style][]" type="text" list="writing_styles" placeholder="Created content writing style" class="coderevolution_gutenberg_input" value="' . esc_attr($writing_style) . '"/>                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the writing tone of the created content. This will set the value of the %%writing_tone%% shortcode, which can be used in prompts below. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Writing Tone", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="writing_tone' . esc_html($cont) . '" name="aiomatic_review_list[writing_tone][]" type="text" list="writing_tones" placeholder="Created content writing tone" class="coderevolution_gutenberg_input" value="' . esc_attr($writing_tone) . '"/>                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the point of view of the article.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Point Of View", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <select autocomplete="off" class="cr_width_full" id="point_of_view' . esc_html($cont) . '" name="aiomatic_review_list[point_of_view][]">
                     <option value="First Person Singular (I, me, my, mine)"';
             if ($point_of_view == 'First Person Singular (I, me, my, mine)') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("First Person Singular (I, me, my, mine)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="First Person Plural (we, us, our, ours)"';
             if ($point_of_view == 'First Person Plural (we, us, our, ours)') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("First Person Plural (we, us, our, ours)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="Second Person Singular (you, your, yours)"';
             if ($point_of_view == 'Second Person Singular (you, your, yours)') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Second Person Singular (you, your, yours)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="Second Person Plural (you [plural], y\'all, you guys)"';
             if ($point_of_view == 'Second Person Plural (you [plural], y\'all, you guys)') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Second Person Plural (you [plural], y'all, you guys)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="Third Person Singular (he, she, it)"';
            if ($point_of_view == 'Third Person Singular (he, she, it)') {
                  $output .= ' selected';
            }
            $output .= '>' . esc_html__("Third Person Singular (he, she, it)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     <option value="Third Person Plural (they, them, theirs, themselves)"';
            if ($point_of_view == 'Third Person Plural (they, them, theirs, themselves)') {
                  $output .= ' selected';
            }
            $output .= '>' . esc_html__("Third Person Plural (they, them, theirs, themselves)", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>                
         </div>
         </td></tr>
         <tr><td colspan="2"><h4>' . esc_html__('Prompts', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Title. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Title Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[title_prompt][]" placeholder="Enter your title prompts, one per line" class="cr_width_full">' . esc_textarea($title_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the title generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Title Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_title_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Intro. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - to disable article intro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Intro Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[intro_prompt][]" placeholder="Enter your intro prompts, one per line" class="cr_width_full">' . esc_textarea($intro_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the intro generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Intro Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_intro_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the review post main sections. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%sections_count%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Sections Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[sections_prompt][]" placeholder="Enter your sections prompts, one per line" class="cr_width_full">' . esc_textarea($sections_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the sections generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Sections Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_sections_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Content of the article, which will be applied to each section heading generated by the plugin (or entered manually) or to the entire content (depending how you select using the 'Use the Above Content Prompt To Create The Entire Article' checkbox). You can use the following shortcodes: %%current_section%%, %%article_so_far%%, %%last_section_content%%, %%product_title%%, %%product_description%%, %%language%%, %%all_product_titles%%, %%product_author%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%offer_url%%, %%offer_price%%, %%product_list_price%%, %%offer_img%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%review_link%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%product_imgs_html%%, %%price_with_discount_fixed%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%sections%%, %%paragraphs_per_section%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Content Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="3" cols="70" name="aiomatic_review_list[content_prompt][]" placeholder="Enter your content prompt" class="cr_width_full">' . esc_textarea($content_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the content generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Content Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_content_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Customer Reviews Analysis section. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - to disable article outro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Customer Reviews Analysis Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[reviews_prompt][]" placeholder="Enter your Customer Reviews Analysis prompts, one per line" class="cr_width_full">' . esc_textarea($reviews_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the Customer Reviews Analysis generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Customer Reviews Analysis Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_reviews_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_reviews_model))
{
   $topic_reviews_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_reviews_model == $modelx) 
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
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Pros & Cons section. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - to disable article outro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Pros & Cons Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[proscons_prompt][]" placeholder="Enter your Pros & Cons prompts, one per line" class="cr_width_full">' . esc_textarea($proscons_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the Pros & Cons generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Pros & Cons Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_proscons_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
if(empty($topic_proscons_model))
{
   $topic_proscons_model = AIOMATIC_DEFAULT_MODEL;
}
foreach($all_models as $modelx)
{
   $output .= '<option value="' . $modelx .'"';
   if ($topic_proscons_model == $modelx) 
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
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Q&A. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - to disable article outro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Q&A Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[qa_prompt][]" placeholder="Enter your Q&A prompts, one per line" class="cr_width_full">' . esc_textarea($qa_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the Q&A generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Q&A Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_qa_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post outro. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - to disable article outro, leave this prompt blank - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Article Outro Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[outro_prompt][]" placeholder="Enter your outro prompts, one per line" class="cr_width_full">' . esc_textarea($outro_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the outro generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Outro Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_outro_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Prompt to be used for the Post Excerpt. You can use the following shortcodes: %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Excerpt Prompt", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[excerpt_prompt][]" placeholder="Enter your excerpt prompts, one per line" class="cr_width_full">' . esc_textarea($excerpt_prompt) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI Model to be used for the excerpt generator.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Model For Excerpt Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                     </td><td class="cr_min_width_200">
                     <select autocomplete="off" name="aiomatic_review_list[topic_excerpt_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
         <tr><td colspan="2"><h4>' . esc_html__('Advanced Prompting Options', 'aiomatic-automatic-ai-content-writer') . ':</h4></td></tr>
         <tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Run regex on prompts. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Run Regex On Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[strip_by_regex_prompts][]" placeholder="regex" class="cr_width_full">' . esc_textarea($strip_by_regex_prompts) . '</textarea>
                         
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content from prompts, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Replace Matches From Regex (Prompts)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[replace_regex_prompts][]" placeholder="regex replacement" class="cr_width_full">' . esc_textarea($replace_regex_prompts) . '</textarea>
                         
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select on which prompts do you want to run the above Regex. Possible values are (or any of their combinations): title, intro, sections, content, reviews, proscons, qa, outro, excerpt", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Run Above Regex On Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input id="run_regex_on' . esc_html($cont) . '" name="aiomatic_review_list[run_regex_on][]" type="text" list="run_regex_on_list' . esc_html($cont) . '" class="coderevolution_gutenberg_input" value="' . esc_attr($run_regex_on) . '"/>
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
         <tr><td colspan="2"><h3>' . esc_html__('Global Prompt Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This will be prepended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prepend Text To All Textual AI Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[global_prepend][]" placeholder="Global prompt prepend text" class="cr_width_full">' . esc_textarea($global_prepend) . '</textarea>
                         
         </div>
         </td></tr>
         <tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This will be appended to each prompt sent by the plugin to the AI writer. You can use the following shortcodes: %%topic%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%title%%, %%random_sentence%%, %%random_sentence2%%, %%post_original_title%%, %%blog_title%% - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Append Text To All Textual AI Prompts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[global_append][]" placeholder="Global prompt append text" class="cr_width_full">' . esc_textarea($global_append) . '</textarea>
                         
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
                     <select autocomplete="off" class="cr_width_full" id="link_type' . esc_html($cont) . '" onchange="hideLinks(' . esc_html($cont) . ');" name="aiomatic_review_list[link_type][]">
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
                       <input type="text" name="aiomatic_review_list[max_links][]" placeholder="Add the number of links to enable this feature" class="cr_width_full" value="' . esc_attr($max_links) . '">
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
                     <textarea rows="1" cols="70" name="aiomatic_review_list[link_list][]" placeholder="URL list (one per line)" class="cr_width_full">' . esc_textarea($link_list) . '</textarea>
                         
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
                     <input type="checkbox" name="aiomatic_review_list[link_nofollow][]"';
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
                       <input type="text" name="aiomatic_review_list[link_post_types][]" placeholder="post" class="cr_width_full" value="' . esc_attr($link_post_types) . '">
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
                       <select autocomplete="off" class="cr_width_full" id="auto_categories" name="aiomatic_review_list[auto_categories][]">
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
                     <select autocomplete="off" name="aiomatic_review_list[category_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to AI category generator. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Category Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[category_ai_command][]" placeholder="Write a comma separated list of categories, for the post title: %%post_title%%" class="cr_width_full">' . esc_textarea($category_ai_command) . '</textarea>
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post category that you want for the automatically generated posts to have.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Additional Post Category", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     
                     <select multiple class="cr_width_full" id="default_category" name="aiomatic_review_list[default_category' . esc_html($cont) . '][]" onmouseover="this.size=this.length;" onmouseout="this.size=4;">
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
                     <input type="checkbox" id="remove_default" name="aiomatic_review_list[remove_default][]"';
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
                     <input type="checkbox" id="skip_inexist" name="aiomatic_review_list[skip_inexist][]"';
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
                     <select autocomplete="off" class="cr_width_full" id="auto_tags" name="aiomatic_review_list[auto_tags][]">
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
                     <select autocomplete="off" name="aiomatic_review_list[tag_model][]" class="hideAssistant' . esc_html($cont) . ' cr_width_full">';
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
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to AI tag generator. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. You can also add a link to a TXT file, containing keywords (one per line), or to an RSS feed. If you use RSS feeds, you can also use the following additional shortcodes: %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%author_name%%, %%current_date_time%%, %%post_link%%. The length of this command should not be greater than the max token count set in the settings for the prompt command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Post Tag Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-for-openai-gpt-3-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[tag_ai_command][]" placeholder="Write a comma separated list of tags, for the post title: %%post_title%%" class="cr_width_full">' . esc_textarea($tag_ai_command) . '</textarea>
                         
         </div>
         </td></tr><tr><td>
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post tags that you want for the automatically generated posts to have. Spintax supported.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Additional Post Tags", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     
                     </td><td>
                     <input class="cr_width_full" type="text" name="aiomatic_review_list[default_tags][]" value="' . esc_attr($default_tags) . '" placeholder="Please insert your additional post tags here" >
                         
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
                     <input type="number" min="1" max="128000" name="aiomatic_review_list[max_tokens][]" value="' . esc_attr($max_tokens) . '" placeholder="2048" class="cr_width_full">
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of prompt API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 1000.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Prompt Token Count To Use Per API Request", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="1" max="128000" name="aiomatic_review_list[max_seed_tokens][]" value="' . esc_attr($max_seed_tokens) . '" placeholder="1000" class="cr_width_full">
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the maximum number of continue API tokens to use with each request. This will define the length of the resulting API response. Each token usually consists of approximately 4 characters. This defines how much content does the API receive each time you call it. If the API gets more initial data, better quality results will be expected. The maximum amount which can be set is 500.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("Maximum Continue Token Count To Use Per API Request", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="1" max="128000" name="aiomatic_review_list[max_continue_tokens][]" value="' . esc_attr($max_continue_tokens) . '" placeholder="500" class="cr_width_full">
                         
         </div>
         </td></tr><tr><td class="cr_min_width_200">
         <div>
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.", 'aiomatic-automatic-ai-content-writer') . '
                         </div>
                     </div>
                     <b>' . esc_html__("AI Temperature", 'aiomatic-automatic-ai-content-writer') . ':</b>
                     </td><td>
                     <input type="number" min="0" step="0.1" max="2" name="aiomatic_review_list[temperature][]" value="' . esc_attr($temperature) . '" placeholder="1" class="cr_width_full">
                         
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
                     <input type="number" min="0" step="0.1" max="1" name="aiomatic_review_list[top_p][]" value="' . esc_attr($top_p) . '" placeholder="1" class="cr_width_full">
                         
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
                     <input type="number" min="-2" max="2" step="0.1" name="aiomatic_review_list[presence_penalty][]" value="' . esc_attr($presence_penalty) . '" placeholder="0" class="cr_width_full">
                         
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
                     <input type="number" min="-2" step="0.1" max="2" name="aiomatic_review_list[frequency_penalty][]" value="' . esc_attr($frequency_penalty) . '" placeholder="0" class="cr_width_full">
                         
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
                     <select autocomplete="off" name="aiomatic_review_list[royalty_free][]" class="cr_width_full">
                                   <option value="0"';
             if ($royalty_free == '0') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="1"';
             if ($royalty_free == '1') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("AI Image From Below Selector", 'aiomatic-automatic-ai-content-writer') . '</option>
                                   <option value="2"';
             if ($royalty_free == '2') {
                 $output .= ' selected';
             }
             $output .= '>' . esc_html__("Amazon Product Thumbnail", 'aiomatic-automatic-ai-content-writer') . '</option>
                     </select>
                         
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
                     <select autocomplete="off" name="aiomatic_review_list[search_query_repetition][]" class="cr_width_full">
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
                     <select id="enable_ai_images' . esc_html($cont) . '" autocomplete="off" onchange="hideImage(' . esc_html($cont) . ');" name="aiomatic_review_list[enable_ai_images][]" class="cr_width_full">
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
                                         <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set list of prompt commands (one on each line) you want to send to the AI image generator. This command can be any given task or order, based on which, it will generate images. You can use the following shortcodes here: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%. The length of this command should not be greater than 1000 characters, otherwise the plugin will strip it to 1000 characters length. - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You can also add here a link to a .txt file, where you can add multiple prompts (one per line) and the plugin will select a random one at each run. If you use Royalty Free Images as a source, you can also set their keywords here, if no keywords set, they will be automatically generated. You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . sprintf( wp_kses( __( "Please check some tips and tricks about writing prompt commands, <a href='%s' target='_blank'>here</a>. The [aicontent] shortcode is able to be used also here.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/' ) . '
                         </div>
                     </div>
                     <b>' . esc_html__("Prompt For The AI Image Generator", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/how-to-create-a-good-seed-prompt-command-for-aiomatic-image-generating-for-openai-dall-e-api/" target="_blank">&#9432;</a></b>
                     
                     </td><td>
                     <textarea rows="2" cols="70" name="aiomatic_review_list[ai_command_image][]" placeholder="Please insert a command for the AI image generator" class="cr_width_full">' . esc_textarea($ai_command_image) . '</textarea>
                         
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
                     <select autocomplete="off" name="aiomatic_review_list[image_model][]" class="cr_width_full">
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
                     <select autocomplete="off" name="aiomatic_review_list[image_size][]" class="cr_width_full">
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
                     <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[image_url][]" placeholder="Please insert the link to a valid image (spintax supported)">' . esc_textarea($image_url) . '</textarea>
                     
         </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Posting Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
           <tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a HTML text that should be prepended to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("HTML Text To Prepend To AI Created Content", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                       <textarea rows="2" cols="70" name="aiomatic_review_list[post_prepend][]" placeholder="HTML content to prepend to the AI generated content" class="cr_width_full">' . esc_textarea($post_prepend) . '</textarea>
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Enter a HTML text that should be append to the AI generated content in each created post. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%product_title%%, %%product_description%%, %%aff_url%%, %%product_author%%, %%offer_price%%, %%product_price%%, %%product_list_price%%, %%product_brand%%, %%product_isbn%%, %%product_upc%%, %%product_reviews%%, %%price_numeric%%, %%price_currency%%, %%product_asin%%, %%cart_url%%, %%list_price_numeric%%, %%product_imgs%%, %%search_keywords%%, %%language%%, %%writing_style%%, %%point_of_view%%, %%writing_tone%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%, %%random_image[keyword]%%, %%random_image_url[keyword]%%, %%random_video[keyword]%%, %%royalty_free_image_attribution%% - you can also use an optional parameter in the random_image and random_video shortcodes, which will add a percentage chance for the media to appear or not - example: %%random_video[keyword][60]%% - a video will appear in 60% of cases, in the rest of 40%, nothing will be returned by the shortcode - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("HTML Text To Append To AI Created Content", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                       <textarea rows="2" cols="70" name="aiomatic_review_list[post_append][]" placeholder="HTML content to append to the AI generated content" class="cr_width_full">' . esc_textarea($post_append) . '</textarea>
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Custom AI generated content shortcode creator. If you wish to create content from multiple AI prompts, and use them in post content/post custom fields/taxonomies, you can configure this from here. Also, these shortcodes will be able to be used in custom fields or custom taxonomies which the plugin will create. Syntax for this field: shortcode_name => AI_MODEL_TO_USE @@ TEXTUAL_PROMPT_TO_USE (to specify multiple shortcodes and crawling values, separate them by a new line. Example: my_custom_shortcode => gpt-3.5-turbo-instruct @@ Write a short poem. Afterwards, you can use shortcodes in any settings field that supports shortcodes (ex: 'HTML Text To Append To AI Created Content' settings field), like this: %%my_custom_shortcode%%. Official format is %%name_of_custom_shortcode%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Custom Shortcode Creator (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b><span class="tool" data-tip="Supported models: ' . implode(',', aiomatic_get_all_models()) . '">&nbsp;&#9432;</span>
                       </td><td>
                       <textarea rows="2" cols="70" name="aiomatic_review_list[custom_shortcodes][]" placeholder="shortcode_name => AI_MODEL @@ AI_PROMPT" class="cr_width_full">' . esc_textarea($custom_shortcodes) . '</textarea>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Strip Title From Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="strip_title" name="aiomatic_review_list[strip_title][]"';
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
                       <input type="checkbox" id="skip_spin" name="aiomatic_review_list[skip_spin][]"';
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
                       <input type="checkbox" id="skip_translate" name="aiomatic_review_list[skip_translate][]"';
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
                       <b>' . esc_html__("Process Each Title/Keyword Only Once", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="title_once" name="aiomatic_review_list[title_once][]"';
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
                       <input type="checkbox" id="overwrite_existing" name="aiomatic_review_list[overwrite_existing][]"';
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
                       <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[strip_by_regex][]" placeholder="regex" class="cr_width_full">' . esc_textarea($strip_by_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Replace Matches From Regex (Content)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" class="cr_width_full" name="aiomatic_review_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full">' . esc_textarea($replace_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the author that you want to assign for the automatically generated posts.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Author", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                       </td><td class="cr_min_width_200">
                       <select autocomplete="off" id="post_author" name="aiomatic_review_list[post_author][]" class="cr_width_full">';
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
                       <select autocomplete="off" id="submit_status" name="aiomatic_review_list[submit_status][]" class="cr_width_full">
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
                       <select autocomplete="off" id="default_type" name="aiomatic_review_list[default_type][]" class="cr_width_full">';
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
                       <select autocomplete="off" id="post_format" name="aiomatic_review_list[post_format][]" class="cr_width_full">
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
                       <input type="text" class="cr_width_full" name="aiomatic_review_list[parent_id][]" value="' . esc_attr($parent_id) . '" placeholder="Post parent ID" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable comments for the generated posts?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Comments For Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_comments" name="aiomatic_review_list[enable_comments][]"';
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
                       <input type="checkbox" id="enable_pingback" name="aiomatic_review_list[enable_pingback][]"';
               if ($enable_pingback == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( "Do you want to set a custom post publish date for posts? Set the range in the below field Accepted values for this field are listed: <a href='%s' target='_blank'>here</a>. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url_raw( 'https://www.php.net/manual/en/datetime.formats.php' ) ) . '
                           </div>
                       </div>
                       <b>' . esc_html__("Set a Custom Post Publish Date Range", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="text" id="min_time" name="aiomatic_review_list[min_time][]" value="' . esc_attr($min_time) . '" placeholder="Start time" class="cr_half"> - <input type="text" id="max_time" name="aiomatic_review_list[max_time][]" value="' . esc_attr($max_time) . '" placeholder="End time" class="cr_half">   
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Fields", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       
                       </td><td>
                       <textarea rows="1" cols="70" name="aiomatic_review_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%post_title%%" class="cr_width_full">' . esc_textarea($custom_fields) . '</textarea>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . You can also set hierarhical taxonomies (parent > child), in this format: custom_taxonomy_name => parent1 > child1 . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Taxonomies", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                         <textarea rows="1" cols="70" name="aiomatic_review_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%post_title%%" class="cr_width_full">' . esc_textarea($custom_tax) . '</textarea>  
           </div>
           </td></tr><tr><td>
           <div>
          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                          <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Enter a 2 letter language code that will be assigned as the WPML/Polylang language for posts. Example: for German, input: de", 'aiomatic-automatic-ai-content-writer') . '
                          </div>
                      </div>
                      <b>' . esc_html__("Assign WPML/Polylang Language to Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                      
                      </td><td>
                      <input type="text" class="cr_width_full" name="aiomatic_review_list[wpml_lang][]" value="' . esc_attr($wpml_lang) . '" placeholder="WPML/Polylang language" class="cr_width_full">
                          
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
                      <input type="text" class="cr_width_full" name="aiomatic_review_list[days_no_run][]" value="' . esc_attr($days_no_run) . '" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">
          </div>
          </td></tr></table></div> 
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
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_review_list[active][]" class="activateDeactivateClass" value="1"';
               if (isset($active) && $active === '1') {
                   $output .= ' checked';
               }
               $output .= '/>
                           <input type="hidden" name="aiomatic_review_list[last_run][]" value="' . esc_attr($last_run) . '"/>
                           <input type="hidden" name="aiomatic_review_list[rule_unique_id][]" value="' . esc_attr($rule_unique_id) . '"/></td>
                           <td class="cr_shrt_td2"><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( 'Shortcode for this rule<br/>(to cross-post from this plugin in other plugins):', 'aiomatic-automatic-ai-content-writer'), array(  'br' => array( ) ) ) ) . '<br/><b>%%aiomatic_3_' . esc_html($cont) . '%% and %%aiomatic_title_3_' . esc_html($cont) . '%%</b><br/>' . esc_html__('Posts Generated:', 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($generated_posts) . '<br/>';
               if ($generated_posts != 0) {
                   $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=Aiomatic_3_' . esc_html($cont) . '&post_type=' . esc_html($def_type) . '" target="_blank">' . esc_html__('View Generated Posts', 'aiomatic-automatic-ai-content-writer') . '</a><br/>';
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
                  if (!in_array(array($cont => 3), $running)) {
                        $f = fopen(get_temp_dir() . 'aiomatic_3_' . $cont, 'w');
                        if($f !== false)
                        {
                           flock($f, LOCK_UN);
                           fclose($f);
                           global $wp_filesystem;
                           if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                 include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                 wp_filesystem($creds);
                           }
                           $wp_filesystem->delete(get_temp_dir() . 'aiomatic_3_' . $cont);
                        }
                        $output .= ' cr_hidden';
                   }
                   else
                   {
                       $f = fopen(get_temp_dir() . 'aiomatic_3_' . $cont, 'w');
                       if($f !== false)
                       {
                           if (!flock($f, LOCK_EX | LOCK_NB)) {
                           }
                           else
                           {
                               $output .= ' cr_hidden';
                               flock($f, LOCK_UN);
                               if (($xxkey = array_search(array($cont => 3), $running)) !== false) {
                                   unset($running[$xxkey]);
                                   update_option('aiomatic_running_list', $running);
                               }
                           }
                       }
                   }
               } 
               else 
               {
                  $f = fopen(get_temp_dir() . 'aiomatic_3_' . $cont, 'w');
                  if($f !== false)
                  {
                     flock($f, LOCK_UN);
                     fclose($f);
                     global $wp_filesystem;
                     if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                        wp_filesystem($creds);
                     }
                     $wp_filesystem->delete(get_temp_dir() . 'aiomatic_3_' . $cont);
                  }
                  $output .= ' cr_hidden';
               }
               $output .= '" title="status">
                           <div class="codemainfzr cr_width_80p">
                           <select autocomplete="off" class="codemainfzr" id="actions" class="actions" name="actions" onchange="actionsChangedManual(' . esc_html($cont) . ', this.value, 3, \'' . esc_html($rule_unique_id) . '\');" onfocus="this.selectedIndex = 0;">
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