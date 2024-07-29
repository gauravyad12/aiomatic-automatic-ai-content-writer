<?php
   function aiomatic_csv_panel()
   {
   $all_rules = get_option('aiomatic_csv_list', array());
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
        <h1><?php echo esc_html__("CSV AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></h1>
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
                              <span id="aiomatic_mode_title"><?php echo esc_html__("CSV File URLs List", 'aiomatic-automatic-ai-content-writer');?>*</span>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Add the URLs of the CSV files from where the plugin will get the details for publishing posts. Add each file URL on a new line.", 'aiomatic-automatic-ai-content-writer');
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
                           echo aiomatic_expand_rules_csv();
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
                           <td class="cr_short_td"><input type="text" name="aiomatic_csv_list[rule_description][]" id="rule_description" class="cr_center" placeholder="Rule ID" value="" class="cr_width_full"/></td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_csv_list[post_title][]" placeholder="CSV file URL" class="cr_width_full"></textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" name="aiomatic_csv_list[schedule][]" max="8765812" class="cr_width_60" placeholder="Select the rule schedule interval" value="24"/></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" name="aiomatic_csv_list[max][]" class="cr_width_60" placeholder="Select the # of generated posts" value="1" /></td>
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
                                                  <h3><?php echo esc_html__("CSV File Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
                                             <tr>
                                             <td>
                                                <div>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Set the separator of the CSV file. It is usually auto detected, however, if you have issues with auto detection, you can set the CSV separator here.", 'aiomatic-automatic-ai-content-writer');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("CSV File Separator (Optional):", 'aiomatic-automatic-ai-content-writer');?></b>
                                             </td>
                                             <td>
                                             <input type="text"class="cr_width_full" name="aiomatic_csv_list[csv_separator][]" value="" placeholder="Optional, leave empty if not sure" class="cr_width_full">
                                             </td>
                                          </tr>
                                             <tr><td colspan="2">
                                                  <h3><?php echo esc_html__("Posting Options", 'aiomatic-automatic-ai-content-writer');?>:</h3>
                                             </td></tr>
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
                                                <input type="checkbox" id="strip_title" name="aiomatic_csv_list[strip_title][]">
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
                                                <input type="checkbox" id="skip_spin" name="aiomatic_csv_list[skip_spin][]">               
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
                                                <input type="checkbox" id="skip_translate" name="aiomatic_csv_list[skip_translate][]">               
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to randomize CSV row processing order or do you want to process the lines in their order of appearence?", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Randomize CSV Row Processing Order:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="random_order" name="aiomatic_csv_list[random_order][]">
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
                                                <input type="checkbox" id="title_once" name="aiomatic_csv_list[title_once][]" checked>
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
                                                <input type="checkbox" id="overwrite_existing" name="aiomatic_csv_list[overwrite_existing][]">
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
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_csv_list[strip_by_regex][]" placeholder="regex expression" class="cr_width_full"></textarea>
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
                                                <textarea rows="1" class="cr_width_full" name="aiomatic_csv_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full"></textarea>
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
                                                <select autocomplete="off" id="post_author" name="aiomatic_csv_list[post_author][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="submit_status" name="aiomatic_csv_list[submit_status][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="default_type" name="aiomatic_csv_list[default_type][]" class="cr_width_full">
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
                                                <select autocomplete="off" id="post_format" name="aiomatic_csv_list[post_format][]" class="cr_width_full">
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
                                             <input type="number" min="1" class="cr_width_full" name="aiomatic_csv_list[parent_id][]" value="" placeholder="Post parent ID" class="cr_width_full">
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
                                                <input type="checkbox" id="remove_default" name="aiomatic_csv_list[remove_default][]" checked>
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
                                                <input type="checkbox" id="enable_comments" name="aiomatic_csv_list[enable_comments][]" checked>
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
                                                <input type="checkbox" id="enable_pingback" name="aiomatic_csv_list[enable_pingback][]" checked>
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
                                                <input type="text" id="min_time" name="aiomatic_csv_list[min_time][]" placeholder="Start time" class="cr_half"> - <input type="text" id="max_time" name="aiomatic_csv_list[max_time][]" placeholder="End time" class="cr_half">
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
                                                <textarea rows="1" cols="70" name="aiomatic_csv_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%post_title%%" class="cr_width_full"></textarea>
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
                                                <textarea rows="1" cols="70" name="aiomatic_csv_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%post_title%%" class="cr_width_full"></textarea>
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
                                             <input type="text" class="cr_width_full" name="aiomatic_csv_list[wpml_lang][]" value="" placeholder="WPML/Polylang language" class="cr_width_full">
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
                                                <select autocomplete="off" class="cr_width_full" id="link_type" onchange="hideLinks('');" name="aiomatic_csv_list[link_type][]">
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
                                                <input type="text" name="aiomatic_csv_list[max_links][]" placeholder="Add the number of links to enable this feature" class="cr_width_full">
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
                                                <textarea rows="1" cols="70" name="aiomatic_csv_list[link_list][]" placeholder="URL list (one per line)" class="cr_width_full"></textarea>
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
                                                <input type="checkbox" id="link_nofollow" name="aiomatic_csv_list[link_nofollow][]">
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
                                                <input type="text" name="aiomatic_csv_list[link_post_types][]" placeholder="post" class="cr_width_full">
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
                                                <input type="text" class="cr_width_full" name="aiomatic_csv_list[days_no_run][]" value="" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">  
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
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_csv_list[active][]" value="1" checked />
                              <input type="hidden" name="aiomatic_csv_list[last_run][]" value="1988-01-27 00:00:00"/>
                           <input type="hidden" name="aiomatic_csv_list[rule_unique_id][]" value="<?php echo uniqid('', true);?>"/>
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
            <br/><?php echo esc_html__("Check some example CSV files you can use:", 'aiomatic-automatic-ai-content-writer') . "<ul><li><a href='https://coderevolution.ro/csv/upload.csv' target='_blank'>" . esc_html__("CSV example file 1 (basic functionality)", 'aiomatic-automatic-ai-content-writer') . "</a></li><li><a href='https://coderevolution.ro/csv/advanced.csv' target='_blank'>" . esc_html__("CSV example file 2 (advanced file with some additional variables)", 'aiomatic-automatic-ai-content-writer') . "</a></li><li><a href='https://coderevolution.ro/csv/nested.csv' target='_blank'>" . esc_html__("CSV example file 3 (advanced file with nested [aicontent] shortcodes", 'aiomatic-automatic-ai-content-writer') . "</a></li></ul><b>" . esc_html__("You can also use Google Drive for CSV file storage:", 'aiomatic-automatic-ai-content-writer') . "</b><ul><li><a href='https://youtu.be/D1ruPVbOTpw' target='_blank'>" . esc_html__("Tutorial video: how to use CSV files upload to Google Drive", 'aiomatic-automatic-ai-content-writer') . "</a></li></ul>";?><br/>
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
        <h3><?php echo esc_html__("CSV AI Post Creator Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
        <div id="ai-video-container"><br/>
            <iframe class="ai-video" width="560" height="315" src="https://www.youtube.com/embed/3ZhuTt81F58" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
<?php
   }
   if (isset($_POST['aiomatic_csv_list'])) {
       add_action('admin_init', 'aiomatic_save_rules_csv');
   }
   
   function aiomatic_save_rules_csv($data2)
   {
       $init_rules_per_page = get_option('aiomatic_posts_per_page', 12);
       $rules_per_page = get_option('aiomatic_posts_per_page', 12);
       if(isset($_POST['posts_per_page']))
       {
           update_option('aiomatic_posts_per_page', $_POST['posts_per_page']);
       }
       check_admin_referer('aiomatic_save_rules', '_aiomaticr_nonce');
       
       $data2 = $_POST['aiomatic_csv_list'];
       $rules = get_option('aiomatic_csv_list', array());
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
                   $bundle[]     = trim(sanitize_text_field($data2['enable_comments'][$i]));
                   $bundle[]     = $data2['post_title'][$i];
                   $bundle[]     = trim(sanitize_text_field($data2['enable_pingback'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_format'][$i]));
                   $bundle[]     = trim($data2['custom_fields'][$i]);
                   $bundle[]     = trim($data2['custom_tax'][$i]);
                   $bundle[]     = trim($data2['wpml_lang'][$i]);
                   $bundle[]     = trim($data2['strip_title'][$i]);
                   $bundle[]     = trim($data2['title_once'][$i]);
                   $bundle[]     = trim($data2['min_time'][$i]);
                   $bundle[]     = trim($data2['max_time'][$i]);
                   $bundle[]     = trim($data2['skip_spin'][$i]);
                   $bundle[]     = trim($data2['skip_translate'][$i]);
                   $bundle[]     = trim($data2['rule_description'][$i]);
                   $bundle[]     = trim($data2['strip_by_regex'][$i]);
                   $bundle[]     = trim($data2['replace_regex'][$i]);
                   $bundle[]     = trim($data2['max_links'][$i]);
                   $bundle[]     = trim($data2['link_post_types'][$i]);
                   $bundle[]     = trim($data2['link_type'][$i]);
                   $bundle[]     = trim($data2['link_list'][$i]);
                   $bundle[]     = trim($data2['days_no_run'][$i]);
                   $bundle[]     = trim($data2['overwrite_existing'][$i]);
                   $bundle[]     = trim($data2['link_nofollow'][$i]);
                   $bundle[]     = trim($data2['parent_id'][$i]);
                   $bundle[]     = trim($data2['rule_unique_id'][$i]);
                   $bundle[]     = trim($data2['remove_default'][$i]);
                   $bundle[]     = trim($data2['random_order'][$i]);
                   $bundle[]     = trim($data2['csv_separator'][$i]);
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
       update_option('aiomatic_csv_list', $rules, false);
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
   function aiomatic_expand_rules_csv()
   {
       if (!get_option('aiomatic_running_list')) {
           $running = array();
       } else {
           $running = get_option('aiomatic_running_list');
       }
       $GLOBALS['wp_object_cache']->delete('aiomatic_csv_list', 'options');
       $rules  = get_option('aiomatic_csv_list');
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
                     if(isset($exp[0]) && isset($exp[1]) && $exp[0] == '4')
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
               $enable_comments        = $array_my_values[7];
               $post_title             = $array_my_values[8];
               $enable_pingback        = $array_my_values[9];
               $post_format            = $array_my_values[10];
               $custom_fields          = $array_my_values[11];
               $custom_tax             = $array_my_values[12];
               $wpml_lang              = $array_my_values[13];
               $strip_title            = $array_my_values[14];
               $title_once             = $array_my_values[15];
               $min_time               = $array_my_values[16];
               $max_time               = $array_my_values[17];
               $skip_spin              = $array_my_values[18];
               $skip_translate         = $array_my_values[19];
               $rule_description       = $array_my_values[20];
               $strip_by_regex         = $array_my_values[21];
               $replace_regex          = $array_my_values[22];
               $max_links              = $array_my_values[23];
               $link_post_types        = $array_my_values[24];
               $link_type              = $array_my_values[25];
               $link_list              = $array_my_values[26];
               $days_no_run            = $array_my_values[27];
               $overwrite_existing     = $array_my_values[28];
               $link_nofollow          = $array_my_values[29];
               $parent_id              = $array_my_values[30];
               $rule_unique_id         = $array_my_values[31];
               $remove_default         = $array_my_values[32];
               $random_order           = $array_my_values[33];
               $csv_separator          = $array_my_values[34];
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
                           <td class="cr_short_td"><input type="text" name="aiomatic_csv_list[rule_description][]" id="rule_description' . esc_html($cont) . '" class="cr_center" placeholder="Rule ID" value="' . esc_html($rule_description) . '" class="cr_width_full"/></td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_csv_list[post_title][]" placeholder="CSV file URL" class="cr_width_full">' . htmlspecialchars($post_title) . '</textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" placeholder="# h" name="aiomatic_csv_list[schedule][]" max="8765812" value="' . esc_attr($schedule) . '" class="cr_width_60" required></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" placeholder="#" name="aiomatic_csv_list[max][]" value="' . esc_attr($max) . '"  class="cr_width_60" required></td>
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
         <tr><td colspan="2"><h3>' . esc_html__('CSV File Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the separator of the CSV file. It is usually auto detected, however, if you have issues with auto detection, you can set the CSV separator here.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("CSV File Separator (Optional)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="text" class="cr_width_full" name="aiomatic_csv_list[csv_separator][]" value="' . esc_attr($csv_separator) . '" placeholder="Optional, leave empty if not sure" class="cr_width_full">
                           
           </div>
           </td></tr>
         <tr><td colspan="2"><h3>' . esc_html__('Posting Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr>
         <tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("The AI writer might add the title of the post to the created post content. Check this checkbox if you want to remove the title from the post content", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Strip Title From Content", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="strip_title" name="aiomatic_csv_list[strip_title][]"';
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
                       <input type="checkbox" id="skip_spin" name="aiomatic_csv_list[skip_spin][]"';
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
                       <input type="checkbox" id="skip_translate" name="aiomatic_csv_list[skip_translate][]"';
           if($skip_translate == '1')
           {
               $output .= ' checked';
           }
           $output .= '>               
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to randomize CSV row processing order or do you want to process the lines in their order of appearence?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Randomize CSV Row Processing Order", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="random_order" name="aiomatic_csv_list[random_order][]"';
           if($random_order == '1')
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
                       <input type="checkbox" id="title_once" name="aiomatic_csv_list[title_once][]"';
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
                       <input type="checkbox" id="overwrite_existing" name="aiomatic_csv_list[overwrite_existing][]"';
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
                       <textarea rows="1" class="cr_width_full" name="aiomatic_csv_list[strip_by_regex][]" placeholder="regex" class="cr_width_full">' . esc_textarea($strip_by_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Replace Matches From Regex (Content)", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" class="cr_width_full" name="aiomatic_csv_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full">' . esc_textarea($replace_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the author that you want to assign for the automatically generated posts.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Author", 'aiomatic-automatic-ai-content-writer') . ':</b>   
                       </td><td class="cr_min_width_200">
                       <select autocomplete="off" id="post_author" name="aiomatic_csv_list[post_author][]" class="cr_width_full">';
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
                       <select autocomplete="off" id="submit_status" name="aiomatic_csv_list[submit_status][]" class="cr_width_full">
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
                       <select autocomplete="off" id="default_type" name="aiomatic_csv_list[default_type][]" class="cr_width_full">';
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
                       <select autocomplete="off" id="post_format" name="aiomatic_csv_list[post_format][]" class="cr_width_full">
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
                       <input type="text" class="cr_width_full" name="aiomatic_csv_list[parent_id][]" value="' . esc_attr($parent_id) . '" placeholder="Post parent ID" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This feature will try to remove the WordPress\'s default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Remove WP Default Post Category", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="remove_default" name="aiomatic_csv_list[remove_default][]"';
           if($remove_default == '1')
           {
               $output .= ' checked';
           }
           $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable comments for the generated posts?", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Comments For Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_comments" name="aiomatic_csv_list[enable_comments][]"';
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
                       <input type="checkbox" id="enable_pingback" name="aiomatic_csv_list[enable_pingback][]"';
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
                       <input type="text" id="min_time" name="aiomatic_csv_list[min_time][]" value="' . esc_attr($min_time) . '" placeholder="Start time" class="cr_half"> - <input type="text" id="max_time" name="aiomatic_csv_list[max_time][]" value="' . esc_attr($max_time) . '" placeholder="End time" class="cr_half">   
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Fields", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       
                       </td><td>
                       <textarea rows="1" cols="70" name="aiomatic_csv_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%post_title%%" class="cr_width_full">' . esc_textarea($custom_fields) . '</textarea>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . You can also set hierarhical taxonomies (parent > child), in this format: custom_taxonomy_name => parent1 > child1 . You will also be able to use the custom shortcodes defined in the 'Custom Shortcode Creator' feature from the rule settings - this will allow you to create partially or fully AI generated prompts which will be used for the content generators. You can also use the following topic based shortcodes: %%post_title%%, %%random_sentence%%, %%post_original_title%%, %%random_sentence2%%, %%blog_title%%", 'aiomatic-automatic-ai-content-writer') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Taxonomies", 'aiomatic-automatic-ai-content-writer') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       </td><td>
                         <textarea rows="1" cols="70" name="aiomatic_csv_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%post_title%%" class="cr_width_full">' . esc_textarea($custom_tax) . '</textarea>  
           </div>
           </td></tr><tr><td>
           <div>
          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                          <div class="bws_hidden_help_text_top cr_min_260px">' . esc_html__("Enter a 2 letter language code that will be assigned as the WPML/Polylang language for posts. Example: for German, input: de", 'aiomatic-automatic-ai-content-writer') . '
                          </div>
                      </div>
                      <b>' . esc_html__("Assign WPML/Polylang Language to Posts", 'aiomatic-automatic-ai-content-writer') . ':</b>
                      
                      </td><td>
                      <input type="text" class="cr_width_full" name="aiomatic_csv_list[wpml_lang][]" value="' . esc_attr($wpml_lang) . '" placeholder="WPML/Polylang language" class="cr_width_full">
                          
          </div>
          </td></tr><tr><td colspan="2"><h3>' . esc_html__('Automatic Linking Options', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr><tr><td>
          <div>
          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                          <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the linking method to use in posts.", 'aiomatic-automatic-ai-content-writer') . '
                          </div>
                      </div>
                      <b>' . esc_html__("Automatic Linking Type", 'aiomatic-automatic-ai-content-writer') . ':</b>
                      
                      </td><td>
                      <select autocomplete="off" class="cr_width_full" id="link_type' . esc_html($cont) . '" onchange="hideLinks(' . esc_html($cont) . ');" name="aiomatic_csv_list[link_type][]">
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
                        <input type="text" name="aiomatic_csv_list[max_links][]" placeholder="Add the number of links to enable this feature" class="cr_width_full" value="' . esc_attr($max_links) . '">
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
                      <textarea rows="1" cols="70" name="aiomatic_csv_list[link_list][]" placeholder="URL list (one per line)" class="cr_width_full">' . esc_textarea($link_list) . '</textarea>
                          
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
                      <input type="checkbox" name="aiomatic_csv_list[link_nofollow][]"';
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
                        <input type="text" name="aiomatic_csv_list[link_post_types][]" placeholder="post" class="cr_width_full" value="' . esc_attr($link_post_types) . '">
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
                     <input type="text" class="cr_width_full" name="aiomatic_csv_list[days_no_run][]" value="' . esc_attr($days_no_run) . '" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">
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
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_csv_list[active][]" class="activateDeactivateClass" value="1"';
               if (isset($active) && $active === '1') {
                   $output .= ' checked';
               }
               $output .= '/>
                           <input type="hidden" name="aiomatic_csv_list[last_run][]" value="' . esc_attr($last_run) . '"/>
                           <input type="hidden" name="aiomatic_csv_list[rule_unique_id][]" value="' . esc_attr($rule_unique_id) . '"/></td>
                           <td class="cr_shrt_td2"><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( 'Shortcode for this rule<br/>(to cross-post from this plugin in other plugins):', 'aiomatic-automatic-ai-content-writer'), array(  'br' => array( ) ) ) ) . '<br/><b>%%aiomatic_4_' . esc_html($cont) . '%% and %%aiomatic_title_4_' . esc_html($cont) . '%%</b><br/>' . esc_html__('Posts Generated:', 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($generated_posts) . '<br/>';
               if ($generated_posts != 0) {
                   $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=Aiomatic_4_' . esc_html($cont) . '&post_type=' . esc_html($def_type) . '" target="_blank">' . esc_html__('View Generated Posts', 'aiomatic-automatic-ai-content-writer') . '</a><br/>';
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
                  if (!in_array(array($cont => 4), $running)) {
                        $f = fopen(get_temp_dir() . 'aiomatic_4_' . $cont, 'w');
                        if($f !== false)
                        {
                           flock($f, LOCK_UN);
                           fclose($f);
                           global $wp_filesystem;
                           if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                 include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                 wp_filesystem($creds);
                           }
                           $wp_filesystem->delete(get_temp_dir() . 'aiomatic_4_' . $cont);
                        }
                        $output .= ' cr_hidden';
                   }
                   else
                   {
                       $f = fopen(get_temp_dir() . 'aiomatic_4_' . $cont, 'w');
                       if($f !== false)
                       {
                           if (!flock($f, LOCK_EX | LOCK_NB)) {
                           }
                           else
                           {
                               $output .= ' cr_hidden';
                               flock($f, LOCK_UN);
                               if (($xxkey = array_search(array($cont => 4), $running)) !== false) {
                                   unset($running[$xxkey]);
                                   update_option('aiomatic_running_list', $running);
                               }
                           }
                       }
                   }
               } 
               else 
               {
                  $f = fopen(get_temp_dir() . 'aiomatic_4_' . $cont, 'w');
                  if($f !== false)
                  {
                     flock($f, LOCK_UN);
                     fclose($f);
                     global $wp_filesystem;
                     if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                        wp_filesystem($creds);
                     }
                     $wp_filesystem->delete(get_temp_dir() . 'aiomatic_4_' . $cont);
                  }
                  $output .= ' cr_hidden';
               }
               $output .= '" title="status">
                           <div class="codemainfzr cr_width_80p">
                           <select autocomplete="off" class="codemainfzr" id="actions" class="actions" name="actions" onchange="actionsChangedManual(' . esc_html($cont) . ', this.value, 4, \'' . esc_html($rule_unique_id) . '\');" onfocus="this.selectedIndex = 0;">
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