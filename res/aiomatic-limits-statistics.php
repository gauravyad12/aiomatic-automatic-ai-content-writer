<?php
function aiomatic_get_editable_roles() {
   global $wp_roles;
   $all_roles = $wp_roles->roles;
   $editable_roles = apply_filters('editable_roles', $all_roles);
   return $editable_roles;
}
function aiomatic_save_restrictions($data) {
   check_admin_referer( 'aiomatic_save_restrictions', '_aiomaticr_nonce_restrictions' );
   $data = $_POST['aiomatic_Limit_Rules'];
   $restrictions = array();
   for($i = 0; $i < sizeof($data['user_credits']); ++$i) {
         $bundle = array();
         $user_credits = trim( sanitize_text_field( $data['user_credits'][$i] ) );
         $bundle[] = $user_credits;
         $bundle[] = trim($data['user_credit_type'][$i]);
         $bundle[] = trim( sanitize_text_field( $data['user_time_frame'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['absolute'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['role'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['active'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['ums_sub'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['message'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['rule_description'][$i] ) );
         $bundle[] = trim( sanitize_text_field( $data['user_list'][$i] ) );
      if ($user_credits == '') { continue; }
      else { $restrictions[$i] = $bundle; }
   }
   update_option('aiomatic_Limit_Rules', $restrictions);
}
if (isset($_POST['aiomatic_Limit_Rules'])) {
	add_action('admin_init', 'aiomatic_save_restrictions');
}
function aiomatic_save_menu_limits($data) {
   check_admin_referer( 'aiomatic_save_menus', '_aiomaticr_nonce' );
   $data = $_POST['aiomatic_Menu_Rules'];
   $restrictions = array();
   $cat_cont = 0;
   for($i = 0; $i < sizeof($data['role']); ++$i) 
   {
      $bundle = array();
      $user_roles = $data['role'][$i];
      $bundle[] = $user_roles;
      if($i == sizeof($data['role']) - 1)
      {
            if(isset($data['menu_limit']))
            {
               $bundle[]     = $data['menu_limit'];
            }
            else
            {
               if(!isset($data['menu_limit' . $cat_cont]))
               {
                  $cat_cont++;
               }
               if(!isset($data['menu_limit' . $cat_cont]))
               {
                  $bundle[]     = array('');
               }
               else
               {
                  $bundle[]     = $data['menu_limit' . $cat_cont];
               }
            }
      }
      else
      {
            if(!isset($data['menu_limit' . $cat_cont]))
            {
               $cat_cont++;
            }
            if(!isset($data['menu_limit' . $cat_cont]))
            {
               $bundle[]     = array('');
            }
            else
            {
               $bundle[]     = $data['menu_limit' . $cat_cont];
            }
      }
      $bundle[] = $data['rule_description'][$i];
      $cat_cont++; 
      if (empty($user_roles)) 
      { 
         continue; 
      }
      else 
      { 
         $restrictions[$i] = $bundle;
      }
   }
   update_option('aiomatic_Menu_Rules', $restrictions);
}
if (isset($_POST['aiomatic_Menu_Rules'])) {
	add_action('admin_init', 'aiomatic_save_menu_limits');
}
function aiomatic_expand_limitations($roles) {
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   if(empty(trim($aiomatic_Main_Settings['app_id'])))
   {
       return 'You need to add an API key in plugin settings for this to work!';
   }
   $limitations = get_option('aiomatic_Limit_Rules');
   $output = '';
   if (!empty($limitations)) {
      $name = md5(get_bloginfo());
      wp_register_script($name . '-stats-extra-script', '');
      wp_enqueue_script($name . '-stats-extra-script');
      foreach ($limitations as $cont => $bundle[]) {
              $bundle_values = array_values($bundle); 
              $myValues = $bundle_values[$cont];
              
              $array_my_values = array_values($myValues);
              for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}} 
              $user_credits = $array_my_values[0];
              $user_credit_type = $array_my_values[1];
              $user_time_frame = $array_my_values[2];
              $absolute = $array_my_values[3];
              $role = $array_my_values[4];
              $active = $array_my_values[5];
              $ums_sub = $array_my_values[6];
              $message = $array_my_values[7];
              $rule_description = $array_my_values[8];
              $user_list = $array_my_values[9];
              if($rule_description == '')
              {
                 $rule_description = $cont;
              }
              wp_add_inline_script($name . '-stats-extra-script', 'aiomaticCreateAdmin(' . esc_html($cont) . ');', 'after');
         $output .= '
         <tr>
            <td class="cr_td_xo"><input type="text" name="aiomatic_Limit_Rules[rule_description][]" id="rule_description' . esc_html($cont) . '" class="cr_center" placeholder="Rule ID" value="' . esc_html($rule_description) . '" class="cr_width_full"/></td>
            <td class="cr_min_100"><input type="number" min="0" required step="0.01" name="aiomatic_Limit_Rules[user_credits][]" value="'.esc_attr($user_credits).'" class="cr_width_full" placeholder="Maximum Credits For Users"/></td>
            <td class="cr_min_100">
            <select name="aiomatic_Limit_Rules[user_credit_type][]" class="cr_width_full">
                <option value="queries" ';
                if($user_credit_type === 'queries')
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Queries', 'aiomatic-automatic-ai-content-writer') . '</option>';
$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
$appids = array_filter($appids);
$token = $appids[array_rand($appids)];
if(!aiomatic_is_aiomaticapi_key($token))
{
   $output .= '<option value="units" ';
                if($user_credit_type === 'units')
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Tokens', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="price" ';
                if($user_credit_type === 'price')
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Price', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="pdf" ';
                if($user_credit_type === 'pdf')
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Maximum Chatbot Uploaded PDF Page Count (Per PDF File)', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="pdfchar" ';
                if($user_credit_type === 'pdfchar')
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Maximum Chatbot Uploaded PDF Character Count (Per PDF File)', 'aiomatic-automatic-ai-content-writer') . '</option>';
}
                $output .= '</select></td>
            <td class="cr_6cust"><select class="cr_max_width_80" name="aiomatic_Limit_Rules[user_time_frame][]">
            <option value="day" ';
            if($user_time_frame === 'day')
            {
                  $output .= 'selected="selected"';
            }
            $output .= '>' . esc_html__('Day', 'aiomatic-automatic-ai-content-writer') . '</option>
            <option value="week" ';
            if($user_time_frame === 'week')
            {
                  $output .= 'selected="selected"';
            }
            $output .= '>' . esc_html__('Week', 'aiomatic-automatic-ai-content-writer') . '</option>
            <option value="month" ';
            if($user_time_frame === 'month')
            {
                  $output .= 'selected="selected"';
            }
            $output .= '>' . esc_html__('Month', 'aiomatic-automatic-ai-content-writer') . '</option>
            <option value="year" ';
            if($user_time_frame === 'year')
            {
                  $output .= 'selected="selected"';
            }
            $output .= '>' . esc_html__('Year', 'aiomatic-automatic-ai-content-writer') . '</option>
            </select></td>
            <td class="cr_td_q">
            <select class="cr_max_width_80" name="aiomatic_Limit_Rules[absolute][]">
            <option value="0" ';
            if($absolute === '0')
            {
                  $output .= 'selected="selected"';
            }
            $output .= '>' . esc_html__('No', 'aiomatic-automatic-ai-content-writer') . '</option>
            <option value="1" ';
            if($absolute === '1')
            {
                  $output .= 'selected="selected"';
            }
            $output .= '>' . esc_html__('Yes', 'aiomatic-automatic-ai-content-writer') . '</option>
            </select></td>
            <td class="cr_width_70">
         <center><input type="button" id="mybtnfzr' . esc_html($cont) . '" value="Settings"></center>
         <div id="mymodalfzr' . esc_html($cont) . '" class="codemodalfzr">
<div class="codemodalfzr-content">
<div class="codemodalfzr-header">
<span id="aiomatic_close' . esc_html($cont) . '" class="codeclosefzr">&times;</span>
<h2>' . esc_html__('Rule', 'aiomatic-automatic-ai-content-writer') . ' <span class="cr_color_white">ID ' . esc_html($cont) . '</span> ' . esc_html__('Advanced Settings', 'aiomatic-automatic-ai-content-writer') . '</h2>
</div>
<div class="codemodalfzr-body">
<div class="table-responsive">
<table class="responsive table cr_main_table_nowr">
<tr><td colspan="2"><h2>' . esc_html__('What to Restrict', 'aiomatic-automatic-ai-content-writer') . ':</h2></td></tr>
<tr>
<td class="cr_min_width_200">
<div>
  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text" >' . esc_html__('Select the user role to be restricted.', 'aiomatic-automatic-ai-content-writer') . '
         </div>
      </div>
      <b>' . esc_html__("User Role:", 'aiomatic-automatic-ai-content-writer') . '</b>
      
      </td><td>
      <select name="aiomatic_Limit_Rules[role][]" class="cr_width_full">
      <option value="none" ';
         if($role === 'none')
         {
               $output .= 'selected="selected"';
         }
         $output .= '>' . esc_html__('Don\'t check', 'aiomatic-automatic-ai-content-writer') . '</option>
      <option value="any" ';
         if($role === 'any')
         {
               $output .= 'selected="selected"';
         }
         $output .= '>' . esc_html__('Apply For Any Role', 'aiomatic-automatic-ai-content-writer') . '</option>';
      foreach($roles as $urole => $caps)
      {
         $output .= '<option value="' . $urole . '"';
         if($urole === $role)
         {
            $output .= ' selected="selected"';
         }
         $output .= '>' . $urole . '</option>';
      }
      $output .= '</select>
  </div>
  </td></tr>
<tr>
<td class="cr_min_width_200">
<div>
  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text" >' . esc_html__('Integration with \'Ultimate Membership Pro\'', 'aiomatic-automatic-ai-content-writer') . '
         </div>
      </div>
      <b><a href="https://1.envato.market/UltimateMember" target="_blank">' . esc_html__("Ultimate Membership Pro", 'aiomatic-automatic-ai-content-writer')  . '</a>&nbsp;' . esc_html__("Subscription Plan:", 'aiomatic-automatic-ai-content-writer') . '</b>
      
      </td><td>
      <select name="aiomatic_Limit_Rules[ums_sub][]" class="cr_width_full">
      <option value="none" ';
         if($ums_sub === 'none')
         {
               $output .= 'selected="selected"';
         }
         $output .= '>' . esc_html__('Don\'t check', 'aiomatic-automatic-ai-content-writer') . '</option>';
$levels = array();
if(class_exists('\Indeed\Ihc\Db\Memberships') && function_exists('ihc_reorder_arr'))
{
   $levels = \Indeed\Ihc\Db\Memberships::getAll();
   $levels = ihc_reorder_arr($levels);
}
if(count($levels) > 0)
{
   $output .= '<option value="any" ';
   if($ums_sub === 'any')
   {
         $output .= 'selected="selected"';
   }
   $output .= '>' . esc_html__('Apply For Any Subscription', 'aiomatic-automatic-ai-content-writer') . '</option>';
   $output .= '<option value="nosub" ';
   if($ums_sub === 'nosub')
   {
         $output .= 'selected="selected"';
   }
   $output .= '>' . esc_html__('Not Subscribed Users', 'aiomatic-automatic-ai-content-writer') . '</option>';
}
      foreach($levels as $levelid => $larr)
      {
         $output .= '<option value="' . $levelid . '"';
         if((string)$levelid === $ums_sub)
         {
            $output .= ' selected="selected"';
         }
         $output .= '>' . $larr['label']. '</option>';
      }
      $output .= '</select>
  </div>
  </td></tr>
<tr>
<td class="cr_min_width_200">
<div>
  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text" >' . esc_html__('Set the user ID list to cover with this restriction. You can enter a comma separated list of user IDs.', 'aiomatic-automatic-ai-content-writer') . '
         </div>
      </div>
      <b>'. esc_html__("User ID List:", 'aiomatic-automatic-ai-content-writer') . '</b>
      
      </td><td>
      <input type="text" name="aiomatic_Limit_Rules[user_list][]" value="'.esc_attr($user_list).'" class="cr_width_full" placeholder="User ID List"/>
  </div>
  </td></tr>
  <tr><td colspan="2"><h2>' . esc_html__('More Settings', 'aiomatic-automatic-ai-content-writer') . ':</h2></td></tr>
  <tr>
<td class="cr_min_width_200">
<div>
  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text">' . esc_html__('Set the message to show to restricted users.', 'aiomatic-automatic-ai-content-writer') . '
         </div>
      </div>
      <b>' . esc_html__("User Restricted Message:", 'aiomatic-automatic-ai-content-writer') . '</b>
      
      </td><td>
      <input type="text" name="aiomatic_Limit_Rules[message][]" value="'.esc_attr($message).'" class="cr_width_full" placeholder="You are restricted"/>
  </div>
  </td></tr>
</table></div> 
</div>
<div class="codemodalfzr-footer">
<br/>
<h3 class="cr_inline">Aiomatic Restrictions</h3><span id="aiomatic_ok' . esc_html($cont) . '" class="codeokfzr cr_inline">OK&nbsp;</span>
<br/><br/>
</div>
</div>

</div>     
              </td>
              <td class="cr_30 cr_center" ><span class="wpaiomatic-delete">X</span></td>
                  <td class="cr_short_td">
                  <select name="aiomatic_Limit_Rules[active][]" class="cr_width_full">
      <option value="1" ';
         if($active === '1')
         {
               $output .= 'selected="selected"';
         }
         $output .= '>' . esc_html__('Yes', 'aiomatic-automatic-ai-content-writer') . '</option>
         <option value="0" ';
         if($active === '0')
         {
               $output .= 'selected="selected"';
         }
         $output .= '>' . esc_html__('No', 'aiomatic-automatic-ai-content-writer') . '</option></select></td>
         </tr>	
         ';
              $cont = $cont + 1;
      }
   }
   return $output;
}

function aiomatic_expand_menu_limits($roles) {
   $limitations = get_option('aiomatic_Menu_Rules');
   $output = '';
   if (!empty($limitations)) {
      foreach ($limitations as $cont => $bundle[]) {
              $bundle_values = array_values($bundle); 
              $myValues = $bundle_values[$cont];
              
              $array_my_values = array_values($myValues);
              for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}} 
              $user_role = $array_my_values[0];
              $user_menus = $array_my_values[1];
              $rule_description = $array_my_values[2];
              if(!is_array($user_menus))
              {
                 $user_menus = array($user_menus);
              }
              if($rule_description == '')
              {
                 $rule_description = $cont;
              }
         $output .= '
         <tr>
            <td class="cr_td_xo"><input type="text" name="aiomatic_Menu_Rules[rule_description][]" id="rule_description' . esc_html($cont) . '" class="cr_center" placeholder="Rule ID" value="' . esc_html($rule_description) . '" class="cr_width_full"/></td>
            <td class="cr_min_100"><select name="aiomatic_Menu_Rules[role][]" class="cr_width_full">';
      foreach($roles as $urole => $caps)
      {
         $output .= '<option value="' . $urole . '"';
         if($urole === $user_role)
         {
            $output .= ' selected="selected"';
         }
         $output .= '>' . $urole . '</option>';
      }
      $output .= '</select></td>
            <td class="cr_min_100">
            <select required multiple name="aiomatic_Menu_Rules[menu_limit' . esc_html($cont) . '][]" class="cr_width_full">
                <option value="aiomatic_admin_settings" ';
                if(in_array('aiomatic_admin_settings', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Settings', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_omniblocks" ';
                if(in_array('aiomatic_omniblocks', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI OmniBlocks', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_single_panel" ';
                if(in_array('aiomatic_single_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Single AI Post Creator', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_bulk_creators" ';
                if(in_array('aiomatic_bulk_creators', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Bulk AI Post Creator', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_spinner_panel" ';
                if(in_array('aiomatic_spinner_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Content Editor', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_chatbot_panel" ';
                if(in_array('aiomatic_chatbot_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Chatbot', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_assistants_panel" ';
                if(in_array('aiomatic_assistants_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Assistants', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_shortcodes_panel" ';
                if(in_array('aiomatic_shortcodes_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Shortcodes and Forms', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_embeddings_panel" ';
                if(in_array('aiomatic_embeddings_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Embeddings', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_batch_panel" ';
                if(in_array('aiomatic_batch_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Batch Requests', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_openai_training" ';
                if(in_array('aiomatic_openai_training', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Model Training', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_playground_panel" ';
                if(in_array('aiomatic_playground_panel', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('AI Playground', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_openai_status" ';
                if(in_array('aiomatic_openai_status', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Limits & Statistics', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_more" ';
                if(in_array('aiomatic_more', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('More Features', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_extensions" ';
                if(in_array('aiomatic_extensions', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Aiomatic Extensions', 'aiomatic-automatic-ai-content-writer') . '</option>
                <option value="aiomatic_logs" ';
                if(in_array('aiomatic_logs', $user_menus))
                {
                    $output .= 'selected="selected"';
                }
                $output .= '>' . esc_html__('Activity & Logging', 'aiomatic-automatic-ai-content-writer') . '</option>';
                $output .= '</select></td>
              <td class="cr_30 cr_center" ><span class="wpaiomatic-delete">X</span></td>
         </tr>	
         ';
              $cont = $cont + 1;
      }
   }
   return $output;
}
function aiomatic_getIncidents() 
{
   $url = 'https://status.openai.com/history.rss';
   $response = wp_remote_get( $url );
   if ( is_wp_error( $response ) ) {
     throw new Exception( $response->get_error_message() );
   }
   $response = wp_remote_retrieve_body( $response );
   $xml = simplexml_load_string( $response );
   $incidents = array();
   $oneWeekAgo = time() - 7 * 24 * 60 * 60;
   foreach ( $xml->channel->item as $item ) {
     $date = strtotime( $item->pubDate );
     if ( $date > $oneWeekAgo ) {
       $incidents[] = array(
         'title' => (string) $item->title,
         'description' => (string) $item->description,
         'date' => $date
       );
     }
   }
   return $incidents;
}
function aiomatic_display_arrows($curpage)
{
   if(isset($_GET['pagesort']) && $_GET['pagesort'] == $curpage)
   {
      if (isset($_GET['pageord']) && $_GET['pageord'] == 'asc')
      {
         echo '&nbsp;>';
      }
      else
      {
         echo '&nbsp;<';
      }
   }
   else
   {
      if(!isset($_GET['pagesort']) && $curpage == 'time')
      {
         echo '&nbsp;>';
      }
   }
}
function aiomatic_openai_status()
{
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
   if (isset($aiomatic_Limit_Settings['user_credits'])) {
      $user_credits = $aiomatic_Limit_Settings['user_credits'];
  } else {
      $user_credits = '';
  }
  if (isset($aiomatic_Limit_Settings['user_credit_type'])) {
      $user_credit_type = $aiomatic_Limit_Settings['user_credit_type'];
  } else {
      $user_credit_type = '';
  }
  if (isset($aiomatic_Limit_Settings['user_time_frame'])) {
      $user_time_frame = $aiomatic_Limit_Settings['user_time_frame'];
  } else {
      $user_time_frame = '';
  }
  if (isset($aiomatic_Limit_Settings['guest_time_frame'])) {
      $guest_time_frame = $aiomatic_Limit_Settings['guest_time_frame'];
  } else {
      $guest_time_frame = '';
  }
  if (isset($aiomatic_Limit_Settings['is_absolute_user'])) {
      $is_absolute_user = $aiomatic_Limit_Settings['is_absolute_user'];
  } else {
      $is_absolute_user = '';
  }
  if (isset($aiomatic_Limit_Settings['is_absolute_guest'])) {
      $is_absolute_guest = $aiomatic_Limit_Settings['is_absolute_guest'];
  } else {
      $is_absolute_guest = '';
  }
  if (isset($aiomatic_Limit_Settings['guest_credit_type'])) {
      $guest_credit_type = $aiomatic_Limit_Settings['guest_credit_type'];
  } else {
      $guest_credit_type = '';
  }
  if (isset($aiomatic_Limit_Settings['guest_credits'])) {
      $guest_credits = $aiomatic_Limit_Settings['guest_credits'];
  } else {
      $guest_credits = '';
  }
  if (isset($aiomatic_Limit_Settings['limit_message_logged'])) {
      $limit_message_logged = $aiomatic_Limit_Settings['limit_message_logged'];
  } else {
      $limit_message_logged = '';
  }
  if (isset($aiomatic_Limit_Settings['limit_message_not_logged'])) {
      $limit_message_not_logged = $aiomatic_Limit_Settings['limit_message_not_logged'];
  } else {
      $limit_message_not_logged = '';
  }
  if (isset($aiomatic_Limit_Settings['limit_message_rule'])) {
      $limit_message_rule = $aiomatic_Limit_Settings['limit_message_rule'];
  } else {
      $limit_message_rule = '';
  }
  if (isset($aiomatic_Limit_Settings['ignored_users'])) {
      $ignored_users = $aiomatic_Limit_Settings['ignored_users'];
  } else {
      $ignored_users = '';
  }
  if (isset($aiomatic_Limit_Settings['block_userids'])) {
      $block_userids = $aiomatic_Limit_Settings['block_userids'];
  } else {
      $block_userids = '';
  }
  if (isset($aiomatic_Limit_Settings['enable_limits'])) {
      $enable_limits = $aiomatic_Limit_Settings['enable_limits'];
  } else {
      $enable_limits = '';
  }
  if (isset($aiomatic_Limit_Settings['enable_limits_text'])) {
      $enable_limits_text = $aiomatic_Limit_Settings['enable_limits_text'];
  } else {
      $enable_limits_text = '';
  }
  if (isset($aiomatic_Limit_Settings['user_credits_text'])) {
      $user_credits_text = $aiomatic_Limit_Settings['user_credits_text'];
  } else {
      $user_credits_text = '';
  }
  if (isset($aiomatic_Limit_Settings['user_credit_type_text'])) {
      $user_credit_type_text = $aiomatic_Limit_Settings['user_credit_type_text'];
  } else {
      $user_credit_type_text = '';
  }
  if (isset($aiomatic_Limit_Settings['user_time_frame_text'])) {
      $user_time_frame_text = $aiomatic_Limit_Settings['user_time_frame_text'];
  } else {
      $user_time_frame_text = '';
  }
  if (isset($aiomatic_Limit_Settings['is_absolute_user_text'])) {
      $is_absolute_user_text = $aiomatic_Limit_Settings['is_absolute_user_text'];
  } else {
      $is_absolute_user_text = '';
  }
  if (isset($aiomatic_Limit_Settings['ignored_users_text'])) {
      $ignored_users_text = $aiomatic_Limit_Settings['ignored_users_text'];
  } else {
      $ignored_users_text = '';
  }
  if (isset($aiomatic_Limit_Settings['guest_credits_text'])) {
      $guest_credits_text = $aiomatic_Limit_Settings['guest_credits_text'];
  } else {
      $guest_credits_text = '';
  }
  if (isset($aiomatic_Limit_Settings['guest_credit_type_text'])) {
      $guest_credit_type_text = $aiomatic_Limit_Settings['guest_credit_type_text'];
  } else {
      $guest_credit_type_text = '';
  }
  if (isset($aiomatic_Limit_Settings['guest_time_frame_text'])) {
      $guest_time_frame_text = $aiomatic_Limit_Settings['guest_time_frame_text'];
  } else {
      $guest_time_frame_text = '';
  }
  if (isset($aiomatic_Limit_Settings['is_absolute_guest_text'])) {
      $is_absolute_guest_text = $aiomatic_Limit_Settings['is_absolute_guest_text'];
  } else {
      $is_absolute_guest_text = '';
  }
  if (isset($aiomatic_Limit_Settings['additional_roles'])) {
      $additional_roles = $aiomatic_Limit_Settings['additional_roles'];
  } else {
      $additional_roles = array();
  }
  $max_per_page = 100;
?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<h2 class="cr_center"><?php echo esc_html__("Limits & Statistics", 'aiomatic-automatic-ai-content-writer');?></h2>
<div class="wrap">
        <nav class="nav-tab-wrapper">
            <a href="#tab-0" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Usage Logs", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-5" class="nav-tab"><?php echo esc_html__("Usage Graphs", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("AI Usage Limits", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-6" class="nav-tab"><?php echo esc_html__("Text-to-Speech Usage Limits", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-4" class="nav-tab"><?php echo esc_html__("Plugin Menu Restrictions", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-3" class="nav-tab"><?php echo esc_html__("OpenAI Status", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-x" datahref="<?php echo admin_url('admin.php?page=aiomatic_admin_settings#tab-5');?>" class="nav-tab"><?php echo esc_html__("Limits & Statistics Settings", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-0" class="tab-content">
         <br/>
<?php echo esc_html__("The Aiomatic plugin provides a robust set of features for managing and monitoring the usage of AI services. This tutorial will guide you through the 'Limits and Statistics' feature of the Aiomatic plugin.", 'aiomatic-automatic-ai-content-writer');?>

<h2><?php echo esc_html__("Usage Logs", 'aiomatic-automatic-ai-content-writer');?></h2>
<ol><li>
<?php echo esc_html__("Navigate to the 'Limits and Statistics' section of the Aiomatic plugin.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Click on the 'Usage Logs' tab. Here, you will see a table with the following columns:", 'aiomatic-automatic-ai-content-writer');?>
<ul>
<li>
<?php echo esc_html__("User: The user who made the request.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("IP: The IP address from which the request was made.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Source: The source of the request.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Model: The AI model used for the request.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Mode: The mode in which the request was made.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Units: The number of units used for the request.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Type: The type of units listed.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Price: The cost of the request.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Time: The time when the request was made.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("Session ID: The ID of the session in which the request was made.", 'aiomatic-automatic-ai-content-writer');?>
</li><li>
<?php echo esc_html__("You can use this table to monitor the usage of the plugin and track any unusual activity.", 'aiomatic-automatic-ai-content-writer');?>
</li>
</ul>
</li>
</ol>
<h2><?php echo esc_html__("Usage Graphs", 'aiomatic-automatic-ai-content-writer');?></h2>
<?php echo esc_html__("Click on the 'Usage Graphs' tab in the 'Limits and Statistics' section. Here, you can view graphs that represent the call count, used token count, usage cost, and generated AI image count. These graphs provide a visual representation of the plugin's usage over time, helping you understand usage trends and patterns.", 'aiomatic-automatic-ai-content-writer');?>
<h2><?php echo esc_html__("Usage Limits", 'aiomatic-automatic-ai-content-writer');?></h2>
<?php echo esc_html__("Click on the 'Usage Limits' tab in the 'Limits and Statistics' section. Here, you can set usage limits for both logged in and not logged in users. You can set limits based on token usage, price usage, or call count usage. You can also create usage limiting rules. For example, you might limit the number of requests a user can make in a given time period. The Aiomatic plugin can be integrated with the 'Ultimate Membership Pro' plugin. This allows you to set different usage amounts for members who have joined different membership plans. You can also limit usage based on user role. For example, you might allow administrators to make more requests than regular users.", 'aiomatic-automatic-ai-content-writer');?>
<h2><?php echo esc_html__("OpenAI Status", 'aiomatic-automatic-ai-content-writer');?></h2>
<?php echo esc_html__("Click on the 'OpenAI Status' tab in the 'Limits and Statistics' section. Here, you can see reported incidents from OpenAI's part and their API service status. This can help you troubleshoot any issues with the AI services provided by the plugin. Remember, the 'Limits and Statistics' feature is a powerful tool for managing and monitoring the usage of the Aiomatic plugin. By understanding how to use this feature, you can ensure that your AI services are being used effectively and responsibly.", 'aiomatic-automatic-ai-content-writer');?>
<h2><?php echo esc_html__("Limits and Statistics Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/skwJz6yeqIg" frameborder="0" allowfullscreen></iframe></div></p>
       </div>
        <div id="tab-x" class="tab-content">
        <br/>
        <p><?php echo esc_html__("Redirecting...", 'aiomatic-automatic-ai-content-writer');?></p>
        </div>
        <div id="tab-1" class="tab-content">
         <br/>
         <?php
         if (isset($aiomatic_Main_Settings['enable_tracking']) && $aiomatic_Main_Settings['enable_tracking'] === 'on') {
            echo '<div id="aiomatic_statistics_holder">';
            if (isset($_GET['pagenum']) && $_GET['pagenum'] != '' && is_numeric($_GET['pagenum'])) 
            {
               $shiftp = intval($_GET['pagenum']);
            }
            else
            {
               $shiftp = 1;
            }
            $shiftn = ($shiftp - 1) * $max_per_page;
            $sor_arr = array();
            if (isset($_GET['pagesort']))
            {
               if ($_GET['pagesort'] == 'id')
               {
                  $sor_arr["accessor"] = "id";
               }
               elseif ($_GET['pagesort'] == 'user')
               {
                  $sor_arr["accessor"] = "userId";
               }
               elseif ($_GET['pagesort'] == 'assistant_id')
               {
                  $sor_arr["accessor"] = "assistant_id";
               }
               elseif ($_GET['pagesort'] == 'ip')
               {
                  $sor_arr["accessor"] = "ip";
               }
               elseif ($_GET['pagesort'] == 'source')
               {
                  $sor_arr["accessor"] = "env";
               }
               elseif ($_GET['pagesort'] == 'model')
               {
                  $sor_arr["accessor"] = "model";
               }
               elseif ($_GET['pagesort'] == 'mode')
               {
                  $sor_arr["accessor"] = "mode";
               }
               elseif ($_GET['pagesort'] == 'units')
               {
                  $sor_arr["accessor"] = "units";
               }
               elseif ($_GET['pagesort'] == 'type')
               {
                  $sor_arr["accessor"] = "type";
               }
               elseif ($_GET['pagesort'] == 'price')
               {
                  $sor_arr["accessor"] = "price";
               }
               elseif ($_GET['pagesort'] == 'time')
               {
                  $sor_arr["accessor"] = "time";
               }
               elseif ($_GET['pagesort'] == 'session')
               {
                  $sor_arr["accessor"] = "session";
               }
               if (isset($_GET['pageord']) && $_GET['pageord'] == 'asc')
               {
                  $sor_arr["by"] = "asc";
               }
               else
               {
                  $sor_arr["by"] = "desc";
               }
            }
            $statistics_res = $GLOBALS['aiomatic_stats']->logs_query( [], $shiftn, $max_per_page, null, $sor_arr );
            if($statistics_res['total'] == 0)
            {
               echo esc_html__("Empty results.", 'aiomatic-automatic-ai-content-writer');
            }
            else
            {
               echo '<div id="aiomatic-main-stat-holder" class="table-responsive">';
               echo '<button href="#" id="aiomatic_delete_logs" class="page-title-action aiomatic_delete_logs">' . esc_html__("Delete All Logs", 'aiomatic-automatic-ai-content-writer') . '</button>&nbsp;';
               echo '<a href="https://platform.openai.com/usage" target="_blank" id="aiomatic_check_openai" class="page-title-action aiomatic_delete_logs">' . esc_html__("Check On OpenAI", 'aiomatic-automatic-ai-content-writer') . '</a><br/>';
               echo '<div class="tablediv"><div class="tablecelldiv"><input type="text" id="user_name_delete" placeholder="' . esc_html__("Username for which to delete logs", 'aiomatic-automatic-ai-content-writer') . '"/></div><button href="#" id="aiomatic_delete_user_logs" class="page-title-action full_w_button">' . esc_html__("Delete", 'aiomatic-automatic-ai-content-writer') . '</button></div>';
               echo '<div class="aiomatic-paging-controller">';
               if($statistics_res['total'] > $max_per_page)
               {
                  $pages = ceil($statistics_res['total'] / $max_per_page);
                  $nextp = $shiftp + 1;
                  $prevp = $shiftp - 1;
                  if($nextp > $pages)
                  {
                     $nextp = $pages;
                  }
                  if($prevp < 1)
                  {
                     $prevp = 1;
                  }
                  $first_url = aiomatic_add_to_url('pagenum', 1);
                  $next_url = aiomatic_add_to_url('pagenum', $nextp);
                  $prev_url = aiomatic_add_to_url('pagenum', $prevp);
                  $last_url = aiomatic_add_to_url('pagenum', $pages);
                  echo '&nbsp;<span class="aiomatic-results-count">' . $statistics_res['total'] . '&nbsp;' . esc_html__("results", 'aiomatic-automatic-ai-content-writer') . '</span>&nbsp;&nbsp;';
                  echo '&nbsp;<a href="' . $first_url . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"></path></svg></a>';
                  echo '&nbsp;<a href="' . $prev_url . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M15.41 16.58L10.83 12l4.58-4.59L14 6l-6 6l6 6l1.41-1.42Z"></path></svg></a>';
                  echo '&nbsp;<span class="aiomatic-paging">' . esc_html__("Page", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . $shiftp . '&nbsp;' . esc_html__("of", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . $pages . '</span>';
                  echo '&nbsp;<a href="' . $next_url . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M8.59 16.58L13.17 12L8.59 7.41L10 6l6 6l-6 6l-1.41-1.42Z"></path></svg></a>';
                  echo '&nbsp;<a href="' . $last_url . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M5.59 7.41L7 6l6 6l-6 6l-1.41-1.41L10.17 12L5.59 7.41m6 0L13 6l6 6l-6 6l-1.41-1.41L16.17 12l-4.58-4.59Z"></path></svg></a>';
               }
               else
               {
                  echo '&nbsp;<span class="aiomatic-results-count">' . $statistics_res['total'] . '&nbsp;' . esc_html__("results", 'aiomatic-automatic-ai-content-writer') . '</span>&nbsp;&nbsp;';
                  echo '&nbsp;<svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"></path></svg>';
                  echo '&nbsp;<svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M15.41 16.58L10.83 12l4.58-4.59L14 6l-6 6l6 6l1.41-1.42Z"></path></svg>';
                  echo '&nbsp;<span class="aiomatic-paging">' . esc_html__("Page", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . '1' . '&nbsp;' . esc_html__("of", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . '1' . '</span>';
                  echo '&nbsp;<svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M8.59 16.58L13.17 12L8.59 7.41L10 6l6 6l-6 6l-1.41-1.42Z"></path></svg>';
                  echo '&nbsp;<svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M5.59 7.41L7 6l6 6l-6 6l-1.41-1.41L10.17 12L5.59 7.41m6 0L13 6l6 6l-6 6l-1.41-1.41L16.17 12l-4.58-4.59Z"></path></svg>';
               }
               echo '</div>';
               echo '<table id="stat_table" class="widefat responsive table cr_main_table">';
               $id_sort = aiomatic_add_to_url('pagesort', 'id');
               $user_sort = aiomatic_add_to_url('pagesort', 'user');
               $ip_sort = aiomatic_add_to_url('pagesort', 'ip');
               $source_sort = aiomatic_add_to_url('pagesort', 'source');
               $model_sort = aiomatic_add_to_url('pagesort', 'model');
               $assistant_id_sort = aiomatic_add_to_url('pagesort', 'assistant_id');
               $mode_sort = aiomatic_add_to_url('pagesort', 'mode');
               $units_sort = aiomatic_add_to_url('pagesort', 'units');
               $type_sort = aiomatic_add_to_url('pagesort', 'type');
               $price_sort = aiomatic_add_to_url('pagesort', 'price');
               $time_sort = aiomatic_add_to_url('pagesort', 'time');
               $session_sort = aiomatic_add_to_url('pagesort', 'session');
               if (isset($_GET['pageord']) && $_GET['pageord'] != '')
               {
                  if($_GET['pageord'] == 'asc')
                  {
                     $id_sort = aiomatic_add_to_url('pageord', 'desc', $id_sort);
                     $user_sort = aiomatic_add_to_url('pageord', 'desc', $user_sort);
                     $ip_sort = aiomatic_add_to_url('pageord', 'desc', $ip_sort);
                     $source_sort = aiomatic_add_to_url('pageord', 'desc', $source_sort);
                     $model_sort = aiomatic_add_to_url('pageord', 'desc', $model_sort);
                     $assistant_id_sort = aiomatic_add_to_url('pageord', 'desc', $assistant_id_sort);
                     $mode_sort = aiomatic_add_to_url('pageord', 'desc', $mode_sort);
                     $units_sort = aiomatic_add_to_url('pageord', 'desc', $units_sort);
                     $type_sort = aiomatic_add_to_url('pageord', 'desc', $type_sort);
                     $price_sort = aiomatic_add_to_url('pageord', 'desc', $price_sort);
                     $time_sort = aiomatic_add_to_url('pageord', 'desc', $time_sort);
                     $session_sort = aiomatic_add_to_url('pageord', 'desc', $session_sort);
                  }
                  elseif($_GET['pageord'] == 'desc')
                  {
                     $id_sort = aiomatic_add_to_url('pageord', 'asc', $id_sort);
                     $user_sort = aiomatic_add_to_url('pageord', 'asc', $user_sort);
                     $ip_sort = aiomatic_add_to_url('pageord', 'asc', $ip_sort);
                     $source_sort = aiomatic_add_to_url('pageord', 'asc', $source_sort);
                     $model_sort = aiomatic_add_to_url('pageord', 'asc', $model_sort);
                     $assistant_id_sort = aiomatic_add_to_url('pageord', 'asc', $assistant_id_sort);
                     $mode_sort = aiomatic_add_to_url('pageord', 'asc', $mode_sort);
                     $units_sort = aiomatic_add_to_url('pageord', 'asc', $units_sort);
                     $type_sort = aiomatic_add_to_url('pageord', 'asc', $type_sort);
                     $price_sort = aiomatic_add_to_url('pageord', 'asc', $price_sort);
                     $time_sort = aiomatic_add_to_url('pageord', 'asc', $time_sort);
                     $session_sort = aiomatic_add_to_url('pageord', 'asc', $session_sort);
                  }
               }
               else
               {
                  $id_sort = aiomatic_add_to_url('pageord', 'asc', $id_sort);
                  $user_sort = aiomatic_add_to_url('pageord', 'asc', $user_sort);
                  $ip_sort = aiomatic_add_to_url('pageord', 'asc', $ip_sort);
                  $source_sort = aiomatic_add_to_url('pageord', 'asc', $source_sort);
                  $model_sort = aiomatic_add_to_url('pageord', 'asc', $model_sort);
                  $assistant_id_sort = aiomatic_add_to_url('pageord', 'asc', $assistant_id_sort);
                  $mode_sort = aiomatic_add_to_url('pageord', 'asc', $mode_sort);
                  $units_sort = aiomatic_add_to_url('pageord', 'asc', $units_sort);
                  $type_sort = aiomatic_add_to_url('pageord', 'asc', $type_sort);
                  $price_sort = aiomatic_add_to_url('pageord', 'asc', $price_sort);
                  $time_sort = aiomatic_add_to_url('pageord', 'asc', $time_sort);
                  $session_sort = aiomatic_add_to_url('pageord', 'asc', $session_sort);
               }
               echo '<tr><th><a class="aiomatic_normal" href="' . $id_sort . '">' . esc_html__("ID", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('id');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $user_sort . '">' . esc_html__("User", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('user');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $ip_sort . '">' . esc_html__("IP", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('ip');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $source_sort . '">' . esc_html__("Source", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('source');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $model_sort . '">' . esc_html__("Model", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('model');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $assistant_id_sort . '">' . esc_html__("Assistant ID", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('assistant_id');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $mode_sort . '">' . esc_html__("Mode", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('mode');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $units_sort . '">' . esc_html__("Units", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('units');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $type_sort . '">' . esc_html__("Type", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('type');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $price_sort . '">' . esc_html__("Price", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('price');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $time_sort . '">' . esc_html__("Time", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('time');
               echo '</a></th><th><a class="aiomatic_normal" href="' . $session_sort . '">' . esc_html__("Session ID", 'aiomatic-automatic-ai-content-writer');
               aiomatic_display_arrows('session');
               echo '</a></th></tr>';
               $myusers = array();
               foreach($statistics_res['rows'] as $stat_row)
               {
                  if(!isset($myusers[$stat_row['userId']]))
                  {
                     $thisuser = get_user_by( 'id', $stat_row['userId'] );
                     if($thisuser !== false)
                     {
                        $myusers[$stat_row['userId']] = $thisuser->user_login;
                     }
                  }
                  echo '<tr>';
                  echo '<td>' . $stat_row['id'] . '</td>';
                  if(isset($myusers[$stat_row['userId']]))
                  {
                     echo '<td>' . $myusers[$stat_row['userId']] . '</td>';
                  }
                  else
                  {
                     echo '<td>ID: ' . $stat_row['userId'] . '</td>';
                  }
                  echo '<td>' . $stat_row['ip'] . '</td>';
                  echo '<td>' . $stat_row['env'] . '</td>';
                  echo '<td>' . $stat_row['model'] . '</td>';
                  if(isset($stat_row['assistant_id']) && !empty($stat_row['assistant_id']))
                  {
                     echo '<td>' . $stat_row['assistant_id'] . '</td>';
                  }
                  else
                  {
                     echo '<td>-</td>';
                  }
                  echo '<td>' . $stat_row['mode'] . '</td>';
                  echo '<td>' . $stat_row['units'] . '</td>';
                  echo '<td>' . $stat_row['type'] . '</td>';
                  if(aiomatic_is_aiomaticapi_key($stat_row['apiRef']))
                  {
                     echo '<td>N/A</td>';
                  }
                  else
                  {
                     echo '<td>' . $stat_row['price'] . '$</td>';
                  }
                  echo '<td>' . $stat_row['time'] . '</td>';
                  echo '<td>' . $stat_row['session'] . '</td>';
                  echo '</tr>';
               }
               echo '</table>';
               echo '</div>';
            }
            echo '</div>';
         }
         else
         {
             echo esc_html__("You need to enable the 'Enable Usage Tracking For Statistics And Usage Limits' checkbox from the plugin's 'Settings' menu to enable this feature.", 'aiomatic-automatic-ai-content-writer');
         }
         ?>
        </div>
        <form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
<?php
settings_fields('aiomatic_option_group3');
do_settings_sections('aiomatic_option_group3');
?>
        <div id="tab-6" class="tab-content">
        <br/>
        <?php
         if (isset($aiomatic_Main_Settings['enable_tracking']) && $aiomatic_Main_Settings['enable_tracking'] === 'on') {
        ?>
   <div class="cr_autocomplete">
      <input type="password" id="PreventChromeAutocomplete" 
         name="PreventChromeAutocomplete" autocomplete="address-level4" />
   </div>
        <table class="widefat">
        <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable text-to-speech usage limits?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Text-to-Speech Usage Limits:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_limits_text" onclick="limitsTextChanged();" name="aiomatic_Limit_Settings[enable_limits_text]" <?php
                        if ($enable_limits_text == 'on')
                            echo ' checked ';
                        ?>>
                     </td>
                  </tr>
        <tr class="hideTextLimits"><td colspan="2"><h3><?php echo esc_html__("Text-to-Speech Restrictions For Logged In Users:", 'aiomatic-automatic-ai-content-writer');?></h3></td></tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the maximum number of credits for logged in users. Also, you can select the type of credits: queries, tokens or price. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Max User Credits:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="number" id="user_credits_text" step="0.01" min="0" placeholder="<?php echo esc_html__("Maximum Credits For Users", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Limit_Settings[user_credits_text]" value="<?php
                     echo esc_html($user_credits_text);
                     ?>"/>
                     <select id="user_credit_type_text" name="aiomatic_Limit_Settings[user_credit_type_text]" >
                     <option value="characters"<?php
                        if ($user_credit_type_text == "characters") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Characters", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="queries"<?php
                           if ($user_credit_type_text == "queries") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Queries", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the time frame for which to apply the above limitation.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Time Frame:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <select id="user_time_frame_text" name="aiomatic_Limit_Settings[user_time_frame_text]" >
                     <option value="day"<?php
                        if ($user_time_frame_text == "day") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Day", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="week"<?php
                        if ($user_time_frame_text == "week") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Week", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="month"<?php
                        if ($user_time_frame_text == "month") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Month", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="year"<?php
                           if ($user_time_frame_text == "year") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Year", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("With absolute, a day represents today. Otherwise, it represent the past 24 hours from now. The same logic applies to the other time frames.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Absolute Timeframe:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="checkbox" id="is_absolute_user_text" name="aiomatic_Limit_Settings[is_absolute_user_text]"<?php
                  if ($is_absolute_user_text == 'on')
                        echo ' checked ';
                  ?>>
               </div>
            </td>
         </tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the users who will have full access when interacting with the features of the plugin.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Full Access Users:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select id="ignored_users_text" name="aiomatic_Limit_Settings[ignored_users_text]" >
                     <option value="admin"<?php
                        if ($ignored_users_text == "admin") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Admins Only", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="editor"<?php
                        if ($ignored_users_text == "editor") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Editors & Admins", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="none"<?php
                        if ($ignored_users_text == "none") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("None", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideTextLimits"><td colspan="2"><h3><?php echo esc_html__("Text-to-Speech Restrictions For Not Logged In Users:", 'aiomatic-automatic-ai-content-writer');?></h3></td></tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the maximum number of credits for guests who are not logged in. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Max Guest Credits:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="number" id="guest_credits_text" step="0.01" min="0" placeholder="<?php echo esc_html__("Maximum Credits For Guests", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Limit_Settings[guest_credits_text]" value="<?php
                     echo esc_html($guest_credits_text);
                     ?>"/>
                     <select id="guest_credit_type_text" name="aiomatic_Limit_Settings[guest_credit_type_text]" >
                     <option value="characters"<?php
                        if ($guest_credit_type_text == "characters") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Characters", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="queries"<?php
                           if ($guest_credit_type_text == "queries") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Queries", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="pdf"<?php
                              if ($guest_credit_type_text == "pdf") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Page Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                              <option value="pdfchar"<?php
                                 if ($guest_credit_type_text == "pdfchar") {
                                       echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Character Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the time frame for which to apply the above limitation.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Time Frame:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <select id="guest_time_frame_text" name="aiomatic_Limit_Settings[guest_time_frame_text]" >
                     <option value="day"<?php
                        if ($guest_time_frame_text == "day") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Day", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="week"<?php
                        if ($guest_time_frame_text == "week") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Week", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="month"<?php
                        if ($guest_time_frame_text == "month") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Month", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="year"<?php
                           if ($guest_time_frame_text == "year") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Year", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideTextLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("With absolute, a day represents today. Otherwise, it represent the past 24 hours from now. The same logic applies to the other time frames.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Absolute Timeframe:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="checkbox" id="is_absolute_guest_text" name="aiomatic_Limit_Settings[is_absolute_guest_text]"<?php
                  if ($is_absolute_guest_text == 'on')
                        echo ' checked ';
                  ?>>
               </div>
            </td>
         </tr>
         </table>
         <div><p class="crsubmit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" value="<?php echo esc_html__("Save Settings", 'aiomatic-automatic-ai-content-writer');?>"/></p></div>
         <?php
         }
         else
         {
             echo esc_html__("You need to enable the 'Enable Usage Tracking For Statistics And Usage Limits' checkbox from the plugin's 'Settings' menu to enable this feature.", 'aiomatic-automatic-ai-content-writer');
         }
            ?>
        </div>
        <div id="tab-2" class="tab-content">
        <br/>
        <?php
         if (isset($aiomatic_Main_Settings['enable_tracking']) && $aiomatic_Main_Settings['enable_tracking'] === 'on') {
         ?>
   <div class="cr_autocomplete">
      <input type="password" id="PreventChromeAutocomplete" 
         name="PreventChromeAutocomplete" autocomplete="address-level4" />
   </div>
        <table class="widefat">
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to set a comma separated list of user IDs which are blocked from using the AI?", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Restrict User IDs List From Using The AI:", 'aiomatic-automatic-ai-content-writer');?></b>
            </td>
            <td>
            <input type="text" name="aiomatic_Limit_Settings[block_userids]" id="block_userids" placeholder="User IDs to block" value="<?php echo esc_attr($block_userids);?>" class="cr_width_full"/>
            </td>
         </tr>
        <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable global usage limits?", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Global Usage Limits:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_limits" onclick="limitsChanged();" name="aiomatic_Limit_Settings[enable_limits]" <?php
                        if ($enable_limits == 'on')
                            echo ' checked ';
                        ?>>
                     </td>
                  </tr>
        <tr class="hideLimits"><td colspan="2"><h3><?php echo esc_html__("AI Restrictions For Logged In Users:", 'aiomatic-automatic-ai-content-writer');?></h3></td></tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the maximum number of credits for logged in users. Also, you can select the type of credits: queries, tokens or price. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Max User Credits:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="number" id="user_credits" step="0.01" min="0" placeholder="<?php echo esc_html__("Maximum Credits For Users", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Limit_Settings[user_credits]" value="<?php
                     echo esc_html($user_credits);
                     ?>"/>
                     <select id="user_credit_type" name="aiomatic_Limit_Settings[user_credit_type]" >
                     <option value="queries"<?php
                        if ($user_credit_type == "queries") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Queries", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
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
?>
                     <option value="units"<?php
                        if ($user_credit_type == "units") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Tokens", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="price"<?php
                        if ($user_credit_type == "price") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Price", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="pdf"<?php
                        if ($user_credit_type == "pdf") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Page Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="pdfchar"<?php
                        if ($user_credit_type == "pdfchar") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Character Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                        <?php
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the time frame for which to apply the above limitation.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Time Frame:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <select id="user_time_frame" name="aiomatic_Limit_Settings[user_time_frame]" >
                     <option value="day"<?php
                        if ($user_time_frame == "day") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Day", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="week"<?php
                        if ($user_time_frame == "week") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Week", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="month"<?php
                        if ($user_time_frame == "month") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Month", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="year"<?php
                           if ($user_time_frame == "year") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Year", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("With absolute, a day represents today. Otherwise, it represent the past 24 hours from now. The same logic applies to the other time frames.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Absolute Timeframe:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="checkbox" id="is_absolute_user" name="aiomatic_Limit_Settings[is_absolute_user]"<?php
                  if ($is_absolute_user == 'on')
                        echo ' checked ';
                  ?>>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the users who will have full access when interacting with the features of the plugin.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Full Access Users:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select id="ignored_users" name="aiomatic_Limit_Settings[ignored_users]" >
                     <option value="admin"<?php
                        if ($ignored_users == "admin") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Admins Only", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="editor"<?php
                        if ($ignored_users == "editor") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Editors & Admins", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="none"<?php
                        if ($ignored_users == "none") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("None", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the message to be displayed to logged in users when usage limit is reached.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Message When Limit Reached (Logged In Users):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="1" cols="70" name="aiomatic_Limit_Settings[limit_message_logged]" placeholder="<?php echo esc_html__("Usage limit message", 'aiomatic-automatic-ai-content-writer');?>"><?php
               echo esc_textarea($limit_message_logged);
               ?></textarea>
               </div>
            </td>
         </tr>
         <tr class="hideLimits"><td colspan="2"><h3><?php echo esc_html__("AI Restrictions For Not Logged In Users:", 'aiomatic-automatic-ai-content-writer');?></h3></td></tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the maximum number of credits for guests who are not logged in. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Max Guest Credits:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="number" id="guest_credits" step="0.01" min="0" placeholder="<?php echo esc_html__("Maximum Credits For Guests", 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_Limit_Settings[guest_credits]" value="<?php
                     echo esc_html($guest_credits);
                     ?>"/>
                     <select id="guest_credit_type" name="aiomatic_Limit_Settings[guest_credit_type]" >
                     <option value="queries"<?php
                        if ($guest_credit_type == "queries") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Queries", 'aiomatic-automatic-ai-content-writer');?></option>
<?php 
                     if(!aiomatic_is_aiomaticapi_key($token))
                     {
?>
                     <option value="units"<?php
                        if ($guest_credit_type == "units") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Tokens", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="price"<?php
                        if ($guest_credit_type == "price") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Price", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="pdf"<?php
                           if ($guest_credit_type == "pdf") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Page Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="pdfchar"<?php
                              if ($guest_credit_type == "pdfchar") {
                                    echo " selected";
                              }
                              ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Character Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
}
?>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the time frame for which to apply the above limitation.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Time Frame:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <select id="guest_time_frame" name="aiomatic_Limit_Settings[guest_time_frame]" >
                     <option value="day"<?php
                        if ($guest_time_frame == "day") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Day", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="week"<?php
                        if ($guest_time_frame == "week") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Week", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="month"<?php
                        if ($guest_time_frame == "month") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Month", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="year"<?php
                           if ($guest_time_frame == "year") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Year", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("With absolute, a day represents today. Otherwise, it represent the past 24 hours from now. The same logic applies to the other time frames.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Absolute Timeframe:", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <input type="checkbox" id="is_absolute_guest" name="aiomatic_Limit_Settings[is_absolute_guest]"<?php
                  if ($is_absolute_guest == 'on')
                        echo ' checked ';
                  ?>>
               </div>
            </td>
         </tr>
         <tr class="hideLimits">
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the message to be displayed to not logged in users when usage limit is reached.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Message When Limit Reached (Not Logged In Users):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="1" cols="70" name="aiomatic_Limit_Settings[limit_message_not_logged]" placeholder="<?php echo esc_html__("Usage limit message", 'aiomatic-automatic-ai-content-writer');?>"><?php
               echo esc_textarea($limit_message_not_logged);
               ?></textarea>
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2"><hr/></td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the message to be displayed to logged in users when usage limit is reached for the 'Rule Based Restrictions'.", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Message When Limit Reached (Rule Based Restrictions - Global):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
                  <textarea rows="1" cols="70" name="aiomatic_Limit_Settings[limit_message_rule]" placeholder="<?php echo esc_html__("Usage limit message", 'aiomatic-automatic-ai-content-writer');?>"><?php
               echo esc_textarea($limit_message_rule);
               ?></textarea>
               </div>
            </td>
         </tr>
         <tr><td colspan="2"><hr/></td></tr>
         </table>
         <h3><?php echo esc_html__("Rule Based Restrictions:", 'aiomatic-automatic-ai-content-writer');?></h3>
         <?php
         wp_nonce_field( 'aiomatic_save_restrictions', '_aiomaticr_nonce_restrictions' );
         ?>
         <table class="responsive table cr_main_table">
            <thead>
               <tr>
                  <th>
                     <?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This is the ID of the rule. ", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Max User Credits", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the maximum number of credits for logged in users. Also, you can select the type of credits: queries, tokens or price. To disable this feature, leave this field blank.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Credit Type", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the type of credits.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Time Frame", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the time frame for which to apply the above limitation.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_30">
                     Absolute
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select if you want to apply an absolute timeframe. With absolute, a day represents today. Otherwise, it represent the past 24 hours from now. The same logic applies to the other time frames.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_80">
                     <?php echo esc_html__("Options", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Shows advanced settings for this rule.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_30">
                     <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to delete this rule?", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_32" >
                     <?php echo esc_html__("Active", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to enable this plugin? You can deactivate any rule (you don't have to delete them to deactivate them).", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
               </tr>
            </thead>
            <tbody>
               <?php 
$roles = aiomatic_get_editable_roles();
echo aiomatic_expand_limitations($roles); ?>
               <tr>
                  <td class="cr_td_xo"><input type="text" name="aiomatic_Limit_Rules[rule_description][]" id="rule_description" class="cr_center" placeholder="Rule ID" value="" class="cr_width_full"/></td>
                  <td class="cr_custx"><input type="number" min="0" step="0.01" placeholder="Max user credits" name="aiomatic_Limit_Rules[user_credits][]" value="" class="cr_width_full" /></td>
                  <td class="cr_custx">
                     <select id="user_credit_type" name="aiomatic_Limit_Rules[user_credit_type][]" >
                     <option value="queries"<?php
                        if ($user_credit_type == "queries") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Queries", 'aiomatic-automatic-ai-content-writer');?></option>
                        <?php 
                     if(!aiomatic_is_aiomaticapi_key($token))
                     {
                     ?>
                     <option value="units"<?php
                        if ($user_credit_type == "units") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Tokens", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="price"<?php
                        if ($user_credit_type == "price") {
                              echo " selected";
                        }
                        ?>><?php echo esc_html__("Price", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="pdf"<?php
                           if ($user_credit_type == "pdf") {
                                 echo " selected";
                           }
                           ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Page Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                           <option value="pdfchar"<?php
                                 if ($user_credit_type == "pdfchar") {
                                       echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Maximum Chatbot Uploaded PDF Character Count (Per PDF File)", 'aiomatic-automatic-ai-content-writer');?></option>
                        <?php
                     }
                     ?>
                  </select></td>
                  <td class="cr_6cust">
                     <select class="cr_max_width_80" name="aiomatic_Limit_Rules[user_time_frame][]">
                        <option value="day" selected><?php echo esc_html__("Day", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="week"><?php echo esc_html__("Week", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="month"><?php echo esc_html__("Month", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="year"><?php echo esc_html__("Year", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select>
                  </td>
                  <td class="cr_td_q">
                     <select class="cr_max_width_80" name="aiomatic_Limit_Rules[absolute][]">
                        <option value="0" selected><?php echo esc_html__("No", 'aiomatic-automatic-ai-content-writer');?></option>
                        <option value="1"><?php echo esc_html__("Yes", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select></td>
                  <td class="cr_width_70">
                     <center><input type="button" id="mybtnfzr" value="Settings"></center>
                     <div id="mymodalfzr" class="codemodalfzr">
                        <div class="codemodalfzr-content">
                           <div class="codemodalfzr-header">
                              <span id="aiomatic_close" class="codeclosefzr">&times;</span>
                              <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?></h2>
                           </div>
                           <div class="codemodalfzr-body">
                              <div class="table-responsive">
                                 <table class="responsive table cr_main_table_nowr">
                                    <tr>
                                    <td colspan="2">
                                    <h2><?php echo esc_html__("What to Restrict:", 'aiomatic-automatic-ai-content-writer');?></h2>
                                    </td>
                                    </tr>
                                    <tr>
                                       <td class="cr_min_width_200">
                                          <div>
                                             <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                <div class="bws_hidden_help_text cr_min_260px">
                                                   <?php
                                                      echo esc_html__("Select the user role to be restricted.", 'aiomatic-automatic-ai-content-writer');
                                                      ?>
                                                </div>
                                             </div>
                                             <b><?php echo esc_html__("User Role:", 'aiomatic-automatic-ai-content-writer');?></b>
                                       </td>
                                       <td>
                                       <select name="aiomatic_Limit_Rules[role][]" class="cr_width_full">
                                       <option value="none" selected><?php echo esc_html__("Don't check", 'aiomatic-automatic-ai-content-writer');?></option>
                                       <option value="any"><?php echo esc_html__("Apply For Any Role", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
foreach($roles as $urole => $caps)
{
?>
   <option value="<?php echo $urole;?>"><?php echo $urole;?></option>
<?php
}
?>
                                       </select>
                                       </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="cr_min_width_200">
                                          <div>
                                             <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                <div class="bws_hidden_help_text cr_min_260px">
                                                   <?php
                                                      echo esc_html__("Integration with 'Ultimate Membership Pro'", 'aiomatic-automatic-ai-content-writer');
                                                      ?>
                                                </div>
                                             </div>
                                             <b><a href="https://1.envato.market/UltimateMember" target="_blank"><?php echo esc_html__("Ultimate Membership Pro", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<?php echo esc_html__("Subscription Plan:", 'aiomatic-automatic-ai-content-writer');?></b>
                                       </td>
                                       <td>
                                       <select name="aiomatic_Limit_Rules[ums_sub][]" class="cr_width_full">
                                       <option value="none" selected><?php echo esc_html__("Don't check", 'aiomatic-automatic-ai-content-writer');?></option>
                                       
<?php
$levels = array();
if(class_exists('\Indeed\Ihc\Db\Memberships') && function_exists('ihc_reorder_arr'))
{
   $levels = \Indeed\Ihc\Db\Memberships::getAll();
   $levels = ihc_reorder_arr($levels);
}
if(count($levels) > 0)
{
?>
<option value="nosub"><?php echo esc_html__("Not Subscribed Users", 'aiomatic-automatic-ai-content-writer');?></option>
<option value="any"><?php echo esc_html__("Apply For Any Subscription", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
}
foreach($levels as $levelid => $larr)
{
?>
   <option value="<?php echo $levelid;?>"><?php echo esc_html($larr['label']);?></option>
<?php
}
?>
                                       </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="cr_min_width_200">
                                          <div>
                                             <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                <div class="bws_hidden_help_text cr_min_260px">
                                                   <?php
                                                      echo esc_html__("Set the user ID list to cover with this restriction. You can enter a comma separated list of user IDs.", 'aiomatic-automatic-ai-content-writer');
                                                      ?>
                                                </div>
                                             </div>
                                             <b><?php echo esc_html__("User ID List:", 'aiomatic-automatic-ai-content-writer');?></b>
                                       </td>
                                       <td>
                                       <input type="text" placeholder="User ID list" name="aiomatic_Limit_Rules[user_list][]" value="" class="cr_width_full" />
                                       </td>
                                    </tr>
                                    <tr><td colspan="2">
                                    <h2><?php echo esc_html__("More Settings:", 'aiomatic-automatic-ai-content-writer');?></h2>
                                    </td></tr>
                                    <tr>
                                       <td class="cr_min_width_200">
                                          <div>
                                             <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                <div class="bws_hidden_help_text cr_min_260px">
                                                   <?php
                                                      echo esc_html__("Set the message to show to restricted users.", 'aiomatic-automatic-ai-content-writer');
                                                      ?>
                                                </div>
                                             </div>
                                             <b><?php echo esc_html__("User Restricted Message:", 'aiomatic-automatic-ai-content-writer');?></b>
                                       </td>
                                       <td><input type="text" placeholder="You are restricted" name="aiomatic_Limit_Rules[message][]" value="" class="cr_width_full" />
                                       </td>
                                    </tr>
                                 </table>
                           <div class="codemodalfzr-footer">
                              <br/>
                              <h3 class="cr_inline">Aiomatic Restriction Rules</h3>
                              <span id="aiomatic_ok" class="codeokfzr cr_inline">OK&nbsp;</span>
                              <br/><br/>
                           </div>
                  </td>
                  <td class="cr_30 cr_center" ><span class="cr_30">X</span></td>
                  <td class="cr_short_td">
                  <select name="aiomatic_Limit_Rules[active][]" class="cr_width_full">
                     <option value="1" selected><?php echo esc_html__("Yes", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="0"><?php echo esc_html__("No", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select></td>
               </tr>
            </tbody>
         </table>
         <div><p class="crsubmit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" value="<?php echo esc_html__("Save Settings", 'aiomatic-automatic-ai-content-writer');?>"/></p></div>
         <?php
            echo esc_html__("API usage for this user account: ", 'aiomatic-automatic-ai-content-writer') . do_shortcode('[aiomatic-user-remaining-credits-bar]');
         }
         else
         {
             echo esc_html__("You need to enable the 'Enable Usage Tracking For Statistics And Usage Limits' checkbox from the plugin's 'Settings' menu to enable this feature.", 'aiomatic-automatic-ai-content-writer');
         }
            ?>
        </div>
        <div id="tab-4" class="tab-content">
        <br/>
        <h3><?php echo esc_html__("Plugin Visibility Settings:", 'aiomatic-automatic-ai-content-writer');?></h3>
        <table class="responsive table cr_main_table">
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select the additional user roles who will have access to the Aiomatic plugin, in the admin menu. Note that the administrator user role will always have access to the plugin (this is why it is not shown).", 'aiomatic-automatic-ai-content-writer');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("User Roles To See The Pluin In Admin Menu (Besides Administrators):", 'aiomatic-automatic-ai-content-writer');?></b>
               </div>
            </td>
            <td>
               <div>
               <select id="additional_roles" multiple name="aiomatic_Limit_Settings[additional_roles][]" >
               <?php
foreach($roles as $urole => $caps)
{
   if($urole === 'administrator')
   {
      continue;
   }
   echo '<option value="'; echo $urole; echo '"'; if(in_array($urole, $additional_roles)){ echo ' selected';} echo '>'; echo $urole; echo '</option>';
}
?>
                  </select>
               </div>
            </td>
         </tr>
         </table>
        <h3><?php echo esc_html__("User Role Based Plugin Menu Restrictions:", 'aiomatic-automatic-ai-content-writer');?></h3>
         <?php
         wp_nonce_field( 'aiomatic_save_menus', '_aiomaticr_nonce' );
         ?>
   <div class="cr_autocomplete">
      <input type="password" id="PreventChromeAutocomplete" 
         name="PreventChromeAutocomplete" autocomplete="address-level4" />
   </div>
         <table class="responsive table cr_main_table">
            <thead>
               <tr>
                  <th>
                     <?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This is the ID of the rule. ", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("User Role", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the user role for which to apply the restriction.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Select Menu Entries To Show", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select the menu entries to show for this specific user.", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_30">
                     <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to delete this rule?", 'aiomatic-automatic-ai-content-writer');
                              ?>
                        </div>
                     </div>
                  </th>
               </tr>
            </thead>
            <tbody>
               <?php echo aiomatic_expand_menu_limits($roles); ?>
               <tr>
                  <td class="cr_td_xo"><input type="text" name="aiomatic_Menu_Rules[rule_description][]" id="rule_description" class="cr_center" placeholder="Rule ID" value="" class="cr_width_full"/></td>
                  <td class="cr_custx">
                     <select name="aiomatic_Menu_Rules[role][]" class="cr_width_full">
                        <option value="" selected><?php echo esc_html__("Select a role...", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
foreach($roles as $urole => $caps)
{
?>
   <option value="<?php echo $urole;?>"><?php echo $urole;?></option>
<?php
}
?>
                                       </select>
                                    </td>
               <td class="cr_custx">
                  <select id="menu_limit" multiple name="aiomatic_Menu_Rules[menu_limit][]" >
                     <option value="aiomatic_admin_settings"><?php echo esc_html__("Settings", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_omniblocks"><?php echo esc_html__("AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_single_panel"><?php echo esc_html__("Single AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_bulk_creators"><?php echo esc_html__("Bulk AI Post Creator", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_spinner_panel"><?php echo esc_html__("AI Content Editor", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_chatbot_panel"><?php echo esc_html__("AI Chatbot", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_assistants_panel"><?php echo esc_html__("AI Assistants", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_shortcodes_panel"><?php echo esc_html__("AI Shortcodes and Forms", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_embeddings_panel"><?php echo esc_html__("AI Embeddings", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_batch_panel"><?php echo esc_html__("AI Batch Requests", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_openai_training"><?php echo esc_html__("AI Model Training", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_playground_panel"><?php echo esc_html__("AI Playground", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_openai_status"><?php echo esc_html__("Limits & Statistics", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_more"><?php echo esc_html__("More Features", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_extensions"><?php echo esc_html__("Aiomatic Extensions", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="aiomatic_logs"><?php echo esc_html__("Activity & Logging", 'aiomatic-automatic-ai-content-writer');?></option>
                  </select></td>
                  <td class="cr_30 cr_center" ><span class="cr_30">X</span></td>
                     </tr>
                     </tbody>
                  </table>
                  <div><p class="crsubmit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" value="<?php echo esc_html__("Save Settings", 'aiomatic-automatic-ai-content-writer');?>"/></p></div>
        </div>
        </form>
        <div id="tab-3" class="tab-content">
        <br/>
        <p class="cr_center"><?php echo esc_html__("Only the incidents which occured less than a week ago are displayed here.", 'aiomatic-automatic-ai-content-writer');?></p><hr/>
<?php 
try {
   $incidents = get_transient( 'aiomatic_openai_incidents' );
   if ( $incidents === false ) {
      $incidents = aiomatic_getIncidents();
      set_transient( 'aiomatic_openai_incidents', $incidents, 60 * 10 );
   }
   $echo_me = '';
   foreach($incidents as $incident)
   {
      $echo_me .= '<div><h3><img draggable="false" role="img" class="emoji" alt="emoji" src="https://s.w.org/images/core/emoji/14.0.0/svg/26a0.svg">';
      $echo_me .= ' ' . $incident['date'] . ': ' . $incident['title'] . '</h3><div class="description">' . $incident['description'] . '</div></div><hr class="cr-dashed"/>';
   }
   echo $echo_me;
   if($echo_me != '')
   {
       echo '<hr/>';
   }
}
catch ( Exception $e ) {
   echo 'Error while processing OpenAI status: ' . $e->getMessage();
}
?>
        </div>
        <div id="tab-5" class="tab-content">
         <br/>
         <?php
         if (isset($aiomatic_Main_Settings['enable_tracking']) && $aiomatic_Main_Settings['enable_tracking'] === 'on') {
?>
         <div id="aiomatic_chart_holder">
<?php
echo '<span class="pagination-links">';
$current_page = (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$older = 0;
if(isset($_GET['older']) && $_GET['older'] != '')
{
   $older = intval($_GET['older']);
   if($older < 0)
   {
      $older = 0;
   }
}
echo '&nbsp;<a href="' . add_query_arg( array( 'older' => $older + 12 ), $current_page ) . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"></path></svg></a>';
echo '&nbsp;<a href="' . add_query_arg( array( 'older' => $older + 1 ), $current_page ) . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M15.41 16.58L10.83 12l4.58-4.59L14 6l-6 6l6 6l1.41-1.42Z"></path></svg></a>';
echo '&nbsp;<span class="aiomatic-paging">' . esc_html__("Page", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . ($older + 1) . '&nbsp;</span>';
if($older > 0)
{
   echo '&nbsp;<a href="' . add_query_arg( array( 'older' => $older - 1 ), $current_page ) . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M8.59 16.58L13.17 12L8.59 7.41L10 6l6 6l-6 6l-1.41-1.42Z"></path></svg></a>';
   echo '&nbsp;<a href="' . add_query_arg( array( 'older' => 0 ), $current_page ) . '"><svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="aiomatic-paging-controller-icon disabled" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="transform: rotate(360deg);"><path fill="currentColor" d="M5.59 7.41L7 6l6 6l-6 6l-1.41-1.41L10.17 12L5.59 7.41m6 0L13 6l6 6l-6 6l-1.41-1.41L16.17 12l-4.58-4.59Z"></path></svg></a>';
}
echo '</span>';
   if(isset($_GET['older']) && $_GET['older'] != '' && $_GET['older'] != '0')
   {
      $older = intval($_GET['older']);
      if($older < 0)
      {
         $older = 0;
      }
      $day0time = strtotime(($older * 30) . ' days ago', time());
   }
   else
   {
      $day0time = time();
   }
   $how_many_more_days = 30;
   $results = array();
   $priceresults = array();
   $tokenresults = array();
   $imageresults = array();
   for($j = 0; $j < $how_many_more_days; $j++)
   {
      $total_usd = 0;
      $total_tokens = 0;
      $total_images = 0;
      $strx = "-" . $j . " day";
      if($j > 1)
      {
         $strx .= 's';
      }
      $my_day = date('M d Y', strtotime($strx, $day0time));
      $my_daystart = date('Y-m-d H:i:s', strtotime($my_day . ' 00:00'));
      $my_dayend = date('Y-m-d H:i:s', strtotime($my_day . ' 23:59'));
      $filters['from'] = $my_daystart;
      $filters['to'] = $my_dayend;
      $myday_res = $GLOBALS['aiomatic_stats']->logs_query( [], 0, 100, $filters, null );
      foreach($myday_res['rows'] as $resz)
      {
         $total_usd += $resz['price'];
         if($resz['type'] == 'token' || $resz['type'] == 'tokens')
         {
            $total_tokens += $resz['units'];
         }
         elseif($resz['type'] == 'image' || $resz['type'] == 'images')
         {
            $total_images += $resz['units'];
         }
      }
      $results[$my_day] = $myday_res['total'];
      $priceresults[$my_day] = $total_usd;
      $tokenresults[$my_day] = $total_tokens;
      $imageresults[$my_day] = $total_images;
   }
   $results = array_reverse($results);
   $priceresults = array_reverse($priceresults);
   $tokenresults = array_reverse($tokenresults);
   $imageresults = array_reverse($imageresults);
   $results_html = implode(',' , $results);
   $price_html = implode(',' , $priceresults);
   $token_html = implode(',' , $tokenresults);
   $image_html = implode(',' , $imageresults);
   $days_html = implode(', ',array_keys($results));
   $days_html = str_replace(', ', ',', $days_html);
   $results_html = str_replace(', ', ',', $results_html);
   $our_short = '[aiomatic_charts title="Chart' . uniqid() . '" datalabels="' . esc_html__('API Call Count', 'aiomatic-automatic-ai-content-writer') . ',' . esc_html__('API Call Cost (USD)', 'aiomatic-automatic-ai-content-writer') . ',' . esc_html__('API Token Count', 'aiomatic-automatic-ai-content-writer') . ',' . esc_html__('AI Image Count', 'aiomatic-automatic-ai-content-writer') . '" labels="' . $days_html . '" type="Line" align="aligncenter" margin="5px 20px" datasets="' . $results_html . 'next' . $price_html . 'next' . $token_html . 'next' . $image_html . '" canvasheight="200" width="100%" height="400" relativewidth="1" classn="" colors="#D040D2,#A0A48C,#69D2E1,#40D240" fillopacity="0.7" animation="true" scalefontsize="12" scalefontcolor="#666" scaleoverride="false" scalesteps="null" scalestepwidth="null" scalestartvalue="null"]';
   $returnhtml = do_shortcode($our_short);
   echo $returnhtml;
?>
         </div>
<?php
}
else
{
    echo esc_html__("You need to enable the 'Enable Usage Tracking For Statistics And Usage Limits' checkbox from the plugin's 'Settings' menu to enable this feature.", 'aiomatic-automatic-ai-content-writer');
}
?>
      </div>
</div>
</div>
<?php
}
?>