<?php
function aiomatic_omniblocks()
{
    require_once (dirname(__FILE__) . "/aiomatic-languages.php");
    $cont  = 0;
    $temp_list = array();
    $args = array(
        'post_type' => 'aiomatic_omni_temp',
        'posts_per_page' => -1,
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) 
    {
        while ( $the_query->have_posts() ) 
        {
            $the_query->the_post();
            $temp_list[get_the_ID()] = get_the_title();
        }
    }
    wp_reset_postdata();
    $terms = get_terms([
        'taxonomy' => 'ai_template_categories',
        'hide_empty' => false,
    ]);
    $aiomatic_tax_names = array();
    foreach ($terms as $term)
    {
        $aiomatic_tax_names[] = $term->slug;
    }
    $default_cards = aiomatic_omniblocks_default_cards(); 
    $default_block_types = aiomatic_omniblocks_default_block_types(); 
    $all_models = aiomatic_get_all_models(true);
    $all_models_function = aiomatic_get_all_models_function();
    $all_assistants = aiomatic_get_all_assistants(true);
    $all_dalle_models = aiomatic_get_dalle_image_models();
    $all_stable_models = aiomatic_get_stable_image_models();
    $all_formats = ['post-format-standard' => 'Standard', 'post-format-aside' => 'Aside', 'post-format-gallery' => 'Gallery', 'post-format-link' => 'Link', 'post-format-image' => 'Image', 'post-format-quote' => 'Quote', 'post-format-status' => 'Status', 'post-format-video' => 'Video', 'post-format-audio' => 'Audio', 'post-format-chat' => 'Chat'];
    $all_dalle_sizes = ['256x256' => '256x256', '512x512' => '512x512', '1024x1024' => '1024x1024', '1024x1792' => '1024x1792 (only for Dall-E 3)', '1792x1024' => '1792x1024 (only for Dall-E 3)'];
    $all_stable_sizes = ['512x512' => '512x512', '1024x1024' => '1024x1024'];
    $all_midjourney_sizes = ['512x512' => '512x512', '1024x1024' => '1024x1024', '1792x1024' => '1792x1024', '1024x1792' => '1024x1792'];
    $all_stable_video_sizes = ['768x768' => '768x768', '1024x576' => '1024x576', '576x1024' => '576x1024'];
    $all_scraper_types = ['auto' => 'Auto Detect', 'visual' => 'Visual Selector', 'id' => 'ID', 'class' => 'Class', 'xpath' => 'XPath/CSS Selector', 'regex' => 'Regex - First Match', 'regexall' => 'Regex - All Matches', 'raw' => 'Full HTML'];
    $all_rules = get_option('aiomatic_omni_list', array());
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
    if (isset($aiomatic_Main_Settings['deepl_auth'])) {
        $deepl_auth = $aiomatic_Main_Settings['deepl_auth'];
    } else {
        $deepl_auth = '';
    }
    if (isset($aiomatic_Main_Settings['bing_auth'])) {
        $bing_auth = $aiomatic_Main_Settings['bing_auth'];
    } else {
        $bing_auth = '';
    }
   ?>
<div class="wp-header-end"></div>
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
<h2 class="cr_center"><?php echo esc_html__("AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></h2>
</div>
<nav class="nav-tab-wrapper">
    <a href="#tab-0" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
    <a href="#tab-1" class="nav-tab"><?php echo esc_html__("OmniBlock Rule Manager", 'aiomatic-automatic-ai-content-writer');?></a>
    <a href="#tab-3" class="nav-tab"><?php echo esc_html__("OmniBlock Template Manager", 'aiomatic-automatic-ai-content-writer');?></a>
    <a href="#tab-2" class="nav-tab"><?php echo esc_html__("OmniBlock Types", 'aiomatic-automatic-ai-content-writer');?></a>
    <a href="#tab-4" class="nav-tab"><?php echo esc_html__("OmniBlock Files", 'aiomatic-automatic-ai-content-writer');?></a>
</nav>
<div id="mymodalfzr_edit" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close_edit" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Edit OmniBlock Template", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <table id="ai-editor-div" class="aiomatic-automation responsive table cr_main_table_nowr cr_center">
        <tr><td>
        <br/>
        <div id="my-loading-indicator">
    <?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
</div>
</td></tr>
</table>
</div>
</div>
</div>
</div>
<div id="mymodalfzr_run" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close_run" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Run OmniBlock", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <table id="ai-runner-div" class="aiomatic-automation responsive table cr_main_table_nowr cr_center">
        <tr><td>
        <br/>
        <div id="my-loading-indicator-run">
    <?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
</div>
</td></tr>
</table>
</div>
</div>
</div>
</div>
<div id="mymodalfzr_new" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close_new" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Add A New OmniBlock Template", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <br/>
<div class="aiomatic-loader-bubble">

<div class="codemodalauto-body">
                                       <div class="table-responsive">
                                          <table class="aiomatic-automation responsive table cr_main_table_nowr cr_center">
                                            <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Set the name of the OmniBlock template to save.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("OmniBlock Template Title:", 'aiomatic-automatic-ai-content-writer');?></b></div>
                                                </td>
                                                <td>
                                                <input type="text" id="omni_template_new" class="cr_width_full" name="omni_template_new" value="" placeholder="New OmniBlock Template Title">
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Set the category of the OmniBlock template to save. You can add multiple categories, separated by ;", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("OmniBlock Template Category:", 'aiomatic-automatic-ai-content-writer');?></b></div>
                                                </td>
                                                <td>
                                                <input type="text" id="omni_template_cat_new" class="cr_width_full" list="new_cats" name="omni_template_cat_new" value="" placeholder="New OmniBlock Template Category">
                                                <datalist id="new_cats">
<?php
foreach($aiomatic_tax_names as $ln)
{
	echo '<option>' . $ln . '</option>';
}
?>
							</datalist>
                                                </td>
                                             </tr>
                                             <tr><td colspan="2">
                                            <div><button id="ai-save-omni-template" class="button"><?php echo esc_html__("Save OmniBlock Template", 'aiomatic-automatic-ai-content-writer');?></button></div>
                                             </td></tr>
                                            <tr>
                                             <tr><td colspan="2">
                                            <div class="aiseparator aistart"><b><?php echo esc_html__("OmniBlock Queue Starts Here", 'aiomatic-automatic-ai-content-writer');?></b></div>
                                             </td></tr>
                                            <tr>
                                            <td colspan="2">
                                            <input type="hidden" id="sortable_cards_new" class="cr_width_full" name="aiomatic_omni_list_new" value="<?php echo htmlspecialchars(json_encode($default_cards));?>">
                                            <ul id="aiomatic_sortable_cards_new" name="aiomatic_sortable_cards_new">
<?php
    $global_index = '1';
    if(empty($default_block_types))
    {
        echo esc_html__('No AI OmniBlock Types Added To This Rule', 'aiomatic-automatic-ai-content-writer');
    }
    else
    {
        $exec = 1;
        $shortcodes_arr = array('%%keyword%%');
        foreach ($default_cards as $card_id) 
        {
            if(!empty($card_id['type']))
            {
                $assistant_helper = uniqid();
                $urlrandval = uniqid();
                $global_index = $card_id['identifier'];
                $card_type_found = array();
                foreach($default_block_types as $def_card)
                {
                    if($card_id['type'] == $def_card['id'])
                    {
                        $card_type_found = $def_card;
                        break;
                    }
                }
                if(empty($card_type_found))
                {
                    aiomatic_log_to_file('Warning! OmniBlock type not found for: ' . print_r($card_id, true));
                }
                else
                {
                    $local_shortcodes = array();
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        $local_shortcodes[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                    }
                    $plugin_required = array();
                    if(!empty($card_type_found['required_plugin']))
                    {
                        foreach($card_type_found['required_plugin'] as $pslug => $pname)
                        {
                            if(!function_exists('is_plugin_active'))
                            {
                                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            }
                            if (!is_plugin_active($pslug)) 
                            {
                                $plugin_required[] = 'You need enable the "' . $pname[0] . '" plugin for this OmniBlock type to work: ' . $pname[1];
                            }
                        }
                    }
                    echo '<li data-id-str="" class="omniblock-card"><input data-clone-index="xc' . uniqid() . '" class="cr_center aiomatic-bold aiomatic-indigo omniblock-title" card-type="' . esc_html($card_type_found['id']) . '" type="text" placeholder="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '"  title="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '" value="' . esc_attr($card_id['name']) . '">
                    <input type="hidden" class="omniblock-id" card-type="' . esc_html($card_type_found['id']) . '" value="' . esc_attr($card_id['identifier']) . '">
                    <input type="hidden" class="omniblock-shortcodes" card-type="' . esc_html($card_type_found['id']) . '" value="' . esc_attr(implode(',', $local_shortcodes)) . '">';
                    if($card_type_found['id'] == 'text_spinner')
                    {
                        if (!isset($aiomatic_Main_Settings['spin_text']) || $aiomatic_Main_Settings['spin_text'] === 'disabled')
                        {
                            $plugin_required[] = 'Spinning disabled from \'Settings\' -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field, this OmniBlock will not function';
                        }
                        if (isset($aiomatic_Main_Settings['spin_what']) && $aiomatic_Main_Settings['spin_what'] === 'bulk') 
                        {
                            $plugin_required[] = 'Spinning disabled for OmniBlocks, from plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Enable Spinner For\' settings field, this OmniBlock will not function';
                        }
                    }
                    elseif($card_type_found['id'] == 'embeddings')
                    {
                        if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
                        {
                            $plugin_required[] = 'You must add an OpenAI/AiomaticAPI API Key into the plugin\'s \'Settings\' menu before you can use this feature!';
                        }
                        if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
                        {
                            $plugin_required[] = 'You must add a Pinecone API or a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                        }
                    }
                    foreach($card_id['parameters'] as $name => $orig_text)
                    {
                        if(isset($card_type_found['parameters'][$name]) && isset($card_type_found['parameters'][$name]['type']) && ($card_type_found['parameters'][$name]['type'] == 'text' || $card_type_found['parameters'][$name]['type'] == 'textarea' || $card_type_found['parameters'][$name]['type'] == 'url' || $card_type_found['parameters'][$name]['type'] == 'scraper_string'))
                        {
                            foreach($shortcodes_arr as $sha)
                            {
                                $orig_text = str_replace($sha, '', $orig_text);
                            }
                            $incorrect_sh = array();
                            foreach($default_block_types as $cardt)
                            {
                                foreach($cardt['shortcodes'] as $shc)
                                {
                                    preg_match_all('~(%%' . $shc . '[a-zA-Z0-9]*?%%)~', $orig_text, $submatches);
                                    if(isset($submatches[1][0]))
                                    {
                                        foreach($submatches[1] as $incsh)
                                        {
                                            $incorrect_sh[] = $incsh;
                                        }
                                    }
                                }
                            }
                            if(!empty($incorrect_sh))
                            {
                                $plugin_required[] = 'This block has some incorrect shortcodes: ' . implode(',', $incorrect_sh);
                            }
                        }
                    }
                    if(!empty($plugin_required))
                    {
                        echo '<p class="requirement cr_red"><ul class="requirement cr_red">';
                        foreach($plugin_required as $pr)
                        {
                            echo '<li>' . $pr . '</li>';
                        }
                        echo '</ul></p>';
                    }
                    echo '<div class="card-name';
                    if($card_type_found['type'] == 'save')
                    {
                        echo ' aisave-content';
                    }
                    else
                    {
                        echo ' aicreate-content';
                    }
                    echo '">' . esc_html__('OmniBlock Type:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Created shortcodes by this OmniBlock (usable in OmniBlocks from below this one): ', 'aiomatic-automatic-ai-content-writer');
                    echo '<ul>';
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        echo '<li>%%' . $shtc . $card_id['identifier'] . '%%</li>';
                    }
                    echo '</ul>';
                    if (isset($aiomatic_Main_Settings['omni_webhook']) && trim($aiomatic_Main_Settings['omni_webhook']) == 'on')
                    {
                        $rest_url = rest_url('omniblock/v1/webhook');
                        if(isset($card_id['parameters']['api_key']) && !empty(trim($card_id['parameters']['api_key'])))
                        {
                            $rest_url = add_query_arg('apikey', trim($card_id['parameters']['api_key']), $rest_url);
                        }
                        $rest_url = add_query_arg('omniblockid', trim($cont) . '_' . trim($card_id['identifier']), $rest_url);
                        $rest_url = add_query_arg('input', urlencode('Webhooks in WordPress'), $rest_url);
                        $card_type_found['description'] = str_replace('%%webhook_url%%', '<br/><span class="cr_red disable_drag">' . $rest_url . '</span>', $card_type_found['description']);
                    }
                    else
                    {
                        $card_type_found['description'] = str_replace('%%webhook_url%%', '<span class="cr_red">' . esc_html__('OmniBlock Webhook functionality not enabled in \'Settings\' menu of the plugin!' , 'aiomatic-automatic-ai-content-writer') . '</span>', $card_type_found['description']);
                    }
                    echo '</div></div>&nbsp;' . esc_attr($card_type_found['name']) . '</div><p class="card-desc">' . $card_type_found['description'] . '</p><div class="ai-collapsible-holder"><button class="aicollapsible" title="' . esc_html__('Show/Hide Parameters', 'aiomatic-automatic-ai-content-writer') . '"><img class="controls-icon" src="' . plugin_dir_url( __FILE__ ) . '../images/controls.png' . '"></button></div><div class="aicollapsible-parameters">';
                    echo '<h3>' . esc_html__('OmniBlock Parameters', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Set the parameters which will be used in this OmniBlock.', 'aiomatic-automatic-ai-content-writer') . '</div></div></h3><hr/>';
                    foreach($card_type_found['parameters'] as $name => $card_type)
                    {
                        echo '<h4>' . esc_html($card_type['title']) . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html($card_type['description']) . '</div></div></h4>';
                        if($card_type['type'] == 'text')
                        {
                            $randval = uniqid();
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                            echo '<input type="text" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                            }
                            foreach($shortcodes_arr as $myshort)
                            {
                                $my_id = explode('_', $myshort);
                                $my_id = end($my_id);
                                $my_id = substr($my_id, 0, -2);
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  $myshort;
                                echo  '</p>';
                            }
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        elseif($card_type['type'] == 'textarea')
                        {
                            $randval = uniqid();
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                            echo '<textarea class="' . esc_attr($name) . ' cr_width_full" id="xai' . $randval . '" data-clone-index="xc' . uniqid() . '" placeholder="' . esc_html($card_type['placeholder']) . '">' . esc_textarea($value) . '</textarea>';
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                            }
                            foreach($shortcodes_arr as $myshort)
                            {
                                $my_id = explode('_', $myshort);
                                $my_id = end($my_id);
                                $my_id = substr($my_id, 0, -2);
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  $myshort;
                                echo  '</p>';
                            }
                            if($def_card['id'] == 'ai_text_foreach' && $name == 'prompt')
                            {
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  '%%current_input_line%%';
                                echo  '</p>';
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  '%%current_input_line_counter%%';
                                echo  '</p>';
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  '%%all_input_lines%%';
                                echo  '</p>';
                            }
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        elseif($card_type['type'] == 'model_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" id="xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_models as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'model_select_function')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" id="xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_models_function as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'assistant_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" id="sel_xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" onchange="assistantChanged(\'xa' . $assistant_helper . '\');" class="' . esc_attr($name) . ' cr_width_full">';
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
                                    if($value == '')
                                    {
                                        echo ' selected';
                                    }
                                    echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                    foreach($all_assistants as $myassistant)
                                    {
                                        echo '<option value="' . esc_attr($myassistant->ID) .'"';
                                        if($value == $myassistant->ID)
                                        {
                                            echo ' selected';
                                        }
                                        echo '>' . esc_html($myassistant->post_title);
                                        echo '</option>';
                                    }
                                }
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'dalle_image_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_dalle_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'stable_image_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_stable_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'midjourney_image_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_midjourney_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'stable_video_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_stable_video_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'scraper_type')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="scraper_selector ' . esc_attr($name) . ' cr_width_full" data-id-str="" data-source-field-id="ur' . $urlrandval . '" data-target-field-id="' . $assistant_helper . '">';
                            foreach($all_scraper_types as $index => $modelx)
                            {
                                echo '<option value="' . esc_attr($index) .'"';
                                if($value == $index)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'scraper_string')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<input type="text" data-clone-index="xc' . uniqid() . '" id="st' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                        }
                        elseif($card_type['type'] == 'number')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<input type="number" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                        }
                        elseif($card_type['type'] == 'checkbox')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            echo '<option value="0"';
                            if($value == '0')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("No", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="1"';
                            if($value == '1')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Yes", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'dalle_image_model_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_dalle_models as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'stable_image_model_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_stable_models as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'status_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            echo '<option value="publish"';
                            if($value == "publish")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="pending"';
                            if($value == "pending")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="draft"';
                            if($value == "draft")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="private"';
                            if($value == "private")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="trash"';
                            if($value == "trash")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'type_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach(get_post_types( '', 'names' ) as $modelx)
                            {
                                if(strstr($modelx, 'aiomatic_'))
                                {
                                   continue;
                                }
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'amazon_country_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach(aiomatic_get_amazon_codes() as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'amazon_sort_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach(aiomatic_get_amazon_sorts() as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'yt_community_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('text' => 'Text', 'image' => 'Image');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'reddit_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('auto' => 'Auto', 'link' => 'Link', 'self' => 'Text', 'image' => 'Image', 'video' => 'Video');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'method_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('POST' => 'POST', 'GET' => 'GET', 'PUT' => 'PUT', 'DELETE' => 'DELETE');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'content_type_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('JSON' => 'JSON', 'form' => 'Form Data');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'facebook_page_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
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
                                    echo '<option value="' . esc_html($exploding[0]) . '"';
                                    if($exploding[0] == $value)
                                    {
                                        echo " selected";
                                    }
                                    echo '>' . esc_html($exploding[2]) . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the F-omatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'location_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $locations = array('local' => 'local');
                            if(!function_exists('is_plugin_active'))
                            {
                                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            }
                            if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                            {
                                $locations['amazon'] = 'Amazon S3';
                                $locations['wasabi'] = 'Wasabi';
                                $locations['cloudflare'] = 'CloudFlare';
                                $locations['digital'] = 'Digital Ocean';
                            }
                            foreach($locations as $id => $name)
                            {
                                echo '<option value="' . esc_html($id) . '"';
                                if($id == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . ucfirst(esc_html($name)) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $values = $card_type['values'];
                            foreach($values as $id => $name)
                            {
                                echo '<option value="' . esc_html($id) . '"';
                                if($id == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html($name) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'file_type_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $locations = array('txt' => 'txt', 'html' => 'html', 'doc' => 'doc', 'pdf' => 'pdf');
                            if(!function_exists('is_plugin_active'))
                            {
                                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            }
                            foreach($locations as $id => $name)
                            {
                                echo '<option value="' . esc_html($id) . '"';
                                if($id == $value)
                                {
                                    echo " selected";
                                }
                                if ($id == 'pdf' && !is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
                                {
                                    echo " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
                                }
                                echo '>' . esc_html($name) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'file_selector')
                        {
                            if(empty($_GLOBALS['omni_files']))
                            {
                                $_GLOBALS['omni_files'] = get_posts([
                                    'post_type' => 'aiomatic_omni_file',
                                    'post_status' => 'publish',
                                    'numberposts' => -1
                                ]);
                            }
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            if(empty($_GLOBALS['omni_files']))
                            {
                                echo '<option disabled selected>' . esc_html__('No files added, add new files in the \'OmniBlock Files\' tab', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            else
                            {
                                echo '<option value="random"';
                                if('random' == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html__('Random', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                echo '<option value="latest"';
                                if('latest' == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html__('Latest', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            foreach($_GLOBALS['omni_files'] as $id => $name)
                            {
                                echo '<option value="' . esc_html($name->ID) . '"';
                                if($name->ID == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html($name->post_title) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'pinterest_board_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $boards = get_option('pinterestomatic_public_boards', false);
                            if($boards !== FALSE)
                            {
                                foreach($boards as $id => $name)
                                {
                                    echo '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        echo " selected";
                                    }
                                    echo '>' . esc_html($name) . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'gpb_page_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $boards = get_option('businessomatic_my_business_list', false);
                            if($boards !== FALSE)
                            {
                                foreach($boards as $id => $name)
                                {
                                    echo '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        echo " selected";
                                    }
                                    echo '>' . esc_html($name) . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the Businessomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'linkedin_page_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $companies = get_option('linkedinomatic_my_companies', array());
                            if(is_array($companies) && count($companies) > 0)
                            {
                                foreach($companies as $cmp_id => $cmp_name)
                                {
                                    if($cmp_name == 'Profile Page')
                                    {
                                        echo '<option value="' . esc_attr($cmp_id) . '"';
                                        if($cmp_id == $value)
                                        {
                                            echo ' selected';
                                        }
                                        echo '>' . esc_html($cmp_name) . '</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                        if('xxxLinkedinomaticxxx' . $cmp_id == $value)
                                        {
                                            echo ' selected';
                                        }
                                        echo '>' . esc_html($cmp_name) . '</option>';
                                    }
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the Linkedinomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'language_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $i = 0;
                            foreach ($language_names as $lang) {
                                echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                if ($value == $language_codes[$i]) {
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
                                    if ($value == $language_codes_deepl[$i]) {
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
                                    if ($value == $language_codes_bing[$i]) {
                                        echo ' selected';
                                    }
                                    echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                                    $i++;
                                }
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'format_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_formats as $modelx => $namex)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($namex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'url')
                        {
                            $randval = uniqid();
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                            echo '<input type="url" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' ur' . esc_attr($urlrandval) . ' cr_width_full" id="xai' . $randval . '" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                            }
                            foreach($shortcodes_arr as $myshort)
                            {
                                $my_id = explode('_', $myshort);
                                $my_id = end($my_id);
                                $my_id = substr($my_id, 0, -2);
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  $myshort;
                                echo  '</p>';
                            }
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        elseif($card_type['type'] == 'scraper_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . '" id="sc' . $assistant_helper . '" class="cr_width_full">';
                            echo '<option value="0"';
                            if($value == '0')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="1"';
                            if($value == '1')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';         
                            echo '<option value="2"';
                            if($value == '2')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="3"';
                            if($value == '3')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="4"';
                            if($value == '4')
                            {
                                echo ' selected';
                            }
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                            }
                            echo '>' . esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                            }
                            echo '</option>';
                            echo '<option value="5"';
                            if($value == '5')
                            {
                                echo ' selected';
                            }
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                            }
                            echo '>' . esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                            }
                            echo '</option>';
                            echo '<option value="6"';
                            if($value == '6')
                            {
                                echo ' selected';
                            }
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                            }
                            echo '>';
                            echo esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                            }
                            echo '</option>';
                            echo '</select>';
                        }
                    }
                    $critical = false;
                    if(isset($card_id['parameters']['critical']) && $card_id['parameters']['critical'] == '1')
                    {
                        $critical = true;
                    }
                    echo '<h4>' . esc_html__("Critical", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is critical or not. When a Critical OmniBlock fails to generate its content correctly and it fails, it will cause the entire OmniBlock running sequence to stop. Non-critical OmniBlocks when they fail, the execution of blocks will continue, the result of the failed OmniBlock will be blank.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                    echo '&nbsp;<input type="checkbox" class="critical-blocks" data-clone-index="xc' . uniqid() . '" id="critical-' . esc_attr($card_id['identifier']) . '"';
                    if($critical == true)
                    {
                        echo ' checked';
                    }
                    echo '>';
                    echo '</h4>';
                    $disabled = false;
                    if(isset($card_id['parameters']['disabled']) && $card_id['parameters']['disabled'] == '1')
                    {
                        $disabled = true;
                    }
                    echo '<h4>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is disabled or not. The disabled OmniBlocks will be skipped from processing.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                    echo '&nbsp;<input type="checkbox" class="disabled-blocks" data-clone-index="xc' . uniqid() . '" id="disabled-' . esc_attr($card_id['identifier']) . '"';
                    if($disabled == true)
                    {
                        echo ' checked';
                    }
                    echo '>';
                    echo '</h4>';
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        $shortcodes_arr[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                    }
                    echo '</div>
                    <button class="move-up-btn_new" title="Move Up">
    <!-- SVG for move up -->
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0L12 8.292a.5.5 0 0 1-.708.708L8 5.707V12.5a.5.5 0 0 1-1 0V5.707L4.707 9a.5.5 0 1 1-.708-.708l3.647-3.646z"/>
</svg>
</button>
<button class="move-down-btn_new" title="Move Down">
    <!-- SVG for move down -->
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1-.708 0L3.293 7.707a.5.5 0 1 1 .708-.708L7 10.293V3.5a.5.5 0 0 1 1 0v6.793l2.999-3.294a.5.5 0 0 1 .708.708l-4 4.147z"/>
</svg>
</button>
                    <button class="delete-btn" title="' . esc_html__('Delete', 'aiomatic-automatic-ai-content-writer') . '">X</button><div class="ai_common_holder"><div class="step-number">' . esc_html__("Step", 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($exec) . '</div><div class="aiomatic-run-now"></div><div class="id-shower">' . esc_html__("ID:", 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($card_id['identifier']) . '</div></div></div></li>';
                    $exec++;
                }
            }
            else
            {
                aiomatic_log_to_file('Incorrect block format provided: ' . print_r($card_id, true));
            }
        }
    }
?>
        </ul>
</td>
</tr>
<tr>
<td colspan="2">
<?php
echo '<div class="aiseparator aistop"><b>' . esc_html__("OmniBlock Queue Stops Here", 'aiomatic-automatic-ai-content-writer') . '</b></div><h2>' . esc_html__('Add A New OmniBlock To The Above Queue (Drag And Drop):', 'aiomatic-automatic-ai-content-writer') . '</h2>';
?>
<ul id="aiomatic_new_card_types_new" name="aiomatic_new_card_types_new">
<?php
if(empty($default_block_types))
{
    echo esc_html__('No AI OmniBlock Types Defined!', 'aiomatic-automatic-ai-content-writer');
}
else
{
    $first = true;
    $ublockid = $global_index;
    foreach ($default_block_types as $card_id) 
    {
        if(!empty($card_id['type']))
        {
            aiomatic_increment($ublockid);
            $assistant_helper = uniqid();
            echo '<li data-id-str="" class="omniblock-card new-card';
            if($first != true)
            {
                echo ' cr_none';
            }
            $local_shortcodes = array();
            foreach($card_id['shortcodes'] as $shtc)
            {
                $local_shortcodes[] = '%%' . $shtc . $ublockid . '%%';
            }
            $plugin_required = array();
            if(!empty($card_id['required_plugin']))
            {
                foreach($card_id['required_plugin'] as $pslug => $pname)
                {
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (!is_plugin_active($pslug)) 
                    {
                        $plugin_required[] = 'You need enable the "' . $pname[0] . '" plugin for this OmniBlock type to work: ' . $pname[1];
                    }
                }
            }
            echo '" id="' . sanitize_title($card_id['name']) . '_new"><input data-clone-index="xc' . uniqid() . '" class="cr_center aiomatic-bold aiomatic-indigo omniblock-title" card-type="' . esc_html($card_id['id']) . '" type="text" placeholder="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '"  title="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '" value="' . esc_attr($card_id['name']) . '">
            <input type="hidden" class="omniblock-id" card-type="' . esc_html($card_id['id']) . '" value="' . esc_attr($ublockid) . '">
            <input type="hidden" class="omniblock-shortcodes" card-type="' . esc_html($card_id['id']) . '" value="' . esc_attr(implode(',', $local_shortcodes)) . '">';
            if($card_id['id'] == 'text_spinner')
            {
                if (!isset($aiomatic_Main_Settings['spin_text']) || $aiomatic_Main_Settings['spin_text'] === 'disabled')
                {
                    $plugin_required[] = 'Spinning disabled from \'Settings\' -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field, this OmniBlock will not function';
                }
                if (isset($aiomatic_Main_Settings['spin_what']) && $aiomatic_Main_Settings['spin_what'] === 'bulk') 
                {
                    $plugin_required[] = 'Spinning disabled for OmniBlocks, from plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Enable Spinner For\' settings field, this OmniBlock will not function';
                }
            }
            elseif($card_id['id'] == 'embeddings')
            {
                if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
                {
                    $plugin_required[] = 'You must add an OpenAI/AiomaticAPI API Key into the plugin\'s \'Settings\' menu before you can use this feature!';
                }
                if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
                {
                    $plugin_required[] = 'You must add a Pinecone API or a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
            }
            if(!empty($plugin_required))
            {
                echo '<p class="requirement cr_red"><ul class="requirement cr_red">';
                foreach($plugin_required as $pr)
                {
                    echo '<li>' . $pr . '</li>';
                }
                echo '</ul></p>';
            }
            echo '<div class="card-name';
            if($card_id['type'] == 'save')
            {
                echo ' aisave-content';
            }
            else
            {
                echo ' aicreate-content';
            }
            if (isset($aiomatic_Main_Settings['omni_webhook']) && trim($aiomatic_Main_Settings['omni_webhook']) == 'on')
            {
                $card_id['description'] = str_replace('%%webhook_url%%', esc_html__('add this OmniBlock and save settings to get the URL' , 'aiomatic-automatic-ai-content-writer'), $card_id['description']);
            }
            else
            {
                $card_id['description'] = str_replace('%%webhook_url%%', '<span class="cr_red">' . esc_html__('OmniBlock Webhook functionality not enabled in \'Settings\' menu of the plugin!' , 'aiomatic-automatic-ai-content-writer') . '</span>', $card_id['description']);
            }
            echo '">' . esc_html__('OmniBlock Type:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . esc_attr($card_id['name']) . '</div><p class="card-desc">' . $card_id['description'] . '</p><div class="ai-collapsible-holder"><button class="aicollapsible" title="' . esc_html__('Show/Hide Parameters', 'aiomatic-automatic-ai-content-writer') . '"><img class="controls-icon" src="' . plugin_dir_url( __FILE__ ) . '../images/controls.png' . '"></button></div><div class="aicollapsible-parameters">';
            echo '<h3>' . esc_html__('OmniBlock Parameters', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Set the parameters which will be used in this OmniBlock.', 'aiomatic-automatic-ai-content-writer') . '</div></div></h3><hr/>';
            $first = false;
            foreach($card_id['parameters'] as $name => $card_type)
            {
                echo '<h4>' . esc_html($card_type['title']) . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html($card_type['description']) . '</div></div></h4>';   
                if($card_type['type'] == 'text')
                {
                    $randval = uniqid();
                    echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                    echo '<input type="text" class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                    echo '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p></div>';
                    echo '</div>';
                }
                elseif($card_type['type'] == 'textarea')
                {
                    $randval = uniqid();
                    $additional = '';
                    if($name == 'prompt' && $card_id['id'] == 'ai_text_foreach')
                    {
                        $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%current_input_line_counter%%</p>';
                        $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%current_input_line%%</p>';
                        $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%all_input_lines%%</p>';
                    }
                    echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                    echo '<textarea class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">' . esc_textarea($card_type['default_value']) . '</textarea>';
                    echo '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p>' . $additional  . '</div>';
                    echo '</div>';
                }
                elseif($card_type['type'] == 'model_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="xa' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_models as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'model_select_function')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="xa' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_models_function as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'assistant_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="sel_xa' . $assistant_helper . '" onchange="assistantChanged(\'xa' . $assistant_helper . '\');" class="' . esc_attr($name) . ' cr_width_full">';
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
                            if('' == $card_type['default_value'])
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            foreach($all_assistants as $myassistant)
                            {
                                echo '<option value="' . $myassistant->ID .'"';
                                if($myassistant->ID == $card_type['default_value'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($myassistant->post_title);
                                echo '</option>';
                            }
                        }
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'dalle_image_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_dalle_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'stable_image_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_stable_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'midjourney_image_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_midjourney_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'stable_video_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_stable_video_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'scraper_type')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="scraper_selector ' . esc_attr($name) . ' cr_width_full" data-id-str="" data-source-field-id="ur' . $urlrandval . '" data-target-field-id="' . $assistant_helper . '">';
                    foreach($all_scraper_types as $index => $modelx)
                    {
                        echo '<option value="' . esc_attr($index) .'"';
                        if($index == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'scraper_string')
                {
                    echo '<input type="text" class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="st' . $assistant_helper . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                }
                elseif($card_type['type'] == 'number')
                {
                    echo '<input type="number" class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                }
                elseif($card_type['type'] == 'checkbox')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    echo '<option value="0"';
                    if('0' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("No", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="1"';
                    if('1' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Yes", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '</select>';
                }
                elseif($card_type['type'] == 'dalle_image_model_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_dalle_models as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'stable_image_model_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_stable_models as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'status_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    echo '<option value="publish"';
                    if("publish" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="pending"';
                    if("pending" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="draft"';
                    if("draft" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="private"';
                    if("private" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="trash"';
                    if("trash" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '</select>';
                }
                elseif($card_type['type'] == 'type_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach(get_post_types( '', 'names' ) as $modelx)
                    {
                        if(strstr($modelx, 'aiomatic_'))
                        {
                           continue;
                        }
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'amazon_country_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach(aiomatic_get_amazon_codes() as $key => $modelx)
                    {
                        echo '<option value="' . $key .'"';
                        if($key == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'amazon_sort_select')
                {
                    $value = '';
                    if(isset($card_id['parameters'][$name]))
                    {
                        $value = $card_id['parameters'][$name];
                    }
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach(aiomatic_get_amazon_sorts() as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($value == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'yt_community_selector')
                {
                    $community_types = array('text' => 'Text', 'image' => 'Image');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'reddit_selector')
                {
                    $community_types = array('auto' => 'Auto', 'link' => 'Link', 'self' => 'Text', 'image' => 'Image', 'video' => 'Video');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'method_selector')
                {
                    $community_types = array('POST' => 'POST', 'GET' => 'GET', 'PUT' => 'PUT', 'DELETE' => 'DELETE');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'content_type_selector')
                {
                    $community_types = array('JSON' => 'JSON', 'form' => 'Form Data');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'facebook_page_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
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
                            echo '<option value="' . esc_html($exploding[0]) . '"';
                            if($exploding[0] == $card_type['default_value'])
                            {
                                echo " selected";
                            }
                            echo '>' . esc_html($exploding[2]) . '</option>';
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the F-omatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'location_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $locations = array('local' => 'local');
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                    {
                        $locations['amazon'] = 'Amazon S3';
                        $locations['wasabi'] = 'Wasabi';
                        $locations['cloudflare'] = 'CloudFlare';
                        $locations['digital'] = 'Digital Ocean';
                    }
                    foreach($locations as $id => $name)
                    {
                        echo '<option value="' . esc_html($id) . '"';
                        if($id == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . ucfirst(esc_html($name)) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $values = $card_type['values'];
                    foreach($values as $id => $name)
                    {
                        echo '<option value="' . esc_html($id) . '"';
                        if($id == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html($name) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'file_type_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $locations = array('txt' => 'txt', 'html' => 'html', 'doc' => 'doc', 'pdf' => 'pdf');
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    foreach($locations as $id => $name)
                    {
                        echo '<option value="' . esc_html($id) . '"';
                        if($id == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        if ($id == 'pdf' && !is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
                        {
                            echo " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
                        }
                        echo '>' . esc_html($name) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'file_selector')
                {
                    if(empty($_GLOBALS['omni_files']))
                    {
                        $_GLOBALS['omni_files'] = get_posts([
                            'post_type' => 'aiomatic_omni_file',
                            'post_status' => 'publish',
                            'numberposts' => -1
                        ]);
                    }
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    if(empty($_GLOBALS['omni_files']))
                    {
                        echo '<option disabled selected>' . esc_html__('No files added, add new files in the \'OmniBlock Files\' tab', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    else
                    {
                        echo '<option value="random"';
                        if('random' == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html__('Random', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        echo '<option value="latest"';
                        if('latest' == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html__('Latest', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    foreach($_GLOBALS['omni_files'] as $id => $name)
                    {
                        echo '<option value="' . esc_html($name->ID) . '"';
                        if($name->ID == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html($name->post_title) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'pinterest_board_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $boards = get_option('pinterestomatic_public_boards', false);
                    if($boards !== FALSE)
                    {
                        foreach($boards as $id => $name)
                        {
                            echo '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                echo " selected";
                            }
                            echo '>' . esc_html($name) . '</option>';
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'gpb_page_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $boards = get_option('businessomatic_my_business_list', false);
                    if($boards !== FALSE)
                    {
                        foreach($boards as $id => $name)
                        {
                            echo '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                echo " selected";
                            }
                            echo '>' . esc_html($name) . '</option>';
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the Businessomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'linkedin_page_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $companies = get_option('linkedinomatic_my_companies', array());
                    if(is_array($companies) && count($companies) > 0)
                    {
                        foreach($companies as $cmp_id => $cmp_name)
                        {
                            if($cmp_name == 'Profile Page')
                            {
                                echo '<option value="' . esc_attr($cmp_id) . '"';
                                if($cmp_id == $card_type['default_value'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($cmp_name) . '</option>';
                            }
                            else
                            {
                                echo '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                if('xxxLinkedinomaticxxx' . $cmp_id == $card_type['default_value'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($cmp_name) . '</option>';
                            }
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the Linkedinomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'language_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $i = 0;
                    foreach ($language_names as $lang) {
                        echo '<option value="' . esc_html($language_codes[$i]) . '"';
                        if ($card_type['default_value'] == $language_codes[$i]) {
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
                            if ($card_type['default_value'] == $language_codes_deepl[$i]) {
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
                            if ($card_type['default_value'] == $language_codes_bing[$i]) {
                                echo ' selected';
                            }
                            echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                            $i++;
                        }
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'format_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_formats as $modelx => $namex)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($namex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'url')
                {
                    $randval = uniqid();
                    echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                    echo '<input type="url" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' ur' . esc_attr($urlrandval) . ' cr_width_full" id="xai' . $randval . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                    echo '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p></div>';
                    echo '</div>';
                }
                elseif($card_type['type'] == 'scraper_select')
                {
                    echo '<select data-clone-index="xc' . uniqid() . '" autocomplete="off" id="sc' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                    echo '<option value="0"';
                    if('0' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="1"';
                    if('1' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';         
                    echo '<option value="2"';
                    if('2' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="3"';
                    if('3' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="4"';
                    if('4' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                    }
                    echo '>' . esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                    }
                    echo '</option>';
                    echo '<option value="5"';
                    if('5' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                    }
                    echo '>' . esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                    }
                    echo '</option>';
                    echo '<option value="6"';
                    if('6' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                    }
                    echo '>';
                    echo esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                    }
                    echo '</option>';
                    echo '</select>';
                }
            }
            $critical = false;
            if(isset($card_id['parameters']['critical']) && $card_id['parameters']['critical'] == '1')
            {
                $critical = true;
            }
            echo '<h4>' . esc_html__("Critical", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is critical or not. When a Critical OmniBlock fails to generate its content correctly and it fails, it will cause the entire OmniBlock running sequence to stop. Non-critical OmniBlocks when they fail, the execution of blocks will continue, the result of the failed OmniBlock will be blank.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
            echo '&nbsp;<input type="checkbox" class="critical-blocks" data-clone-index="xc' . uniqid() . '" id="critical-' . esc_attr($ublockid) . '"';
            if($critical == true)
            {
                echo ' checked';
            }
            echo '>';
            echo '</h4>';
            $disabled = false;
            if(isset($card_id['parameters']['disabled']) && $card_id['parameters']['disabled'] == '1')
            {
                $disabled = true;
            }
            echo '<h4>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is disabled or not. The disabled OmniBlocks will be skipped from processing.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
            echo '&nbsp;<input type="checkbox" class="disabled-blocks" data-clone-index="xc' . uniqid() . '" id="disabled-' . esc_attr($ublockid) . '"';
            if($disabled == true)
            {
                echo ' checked';
            }
            echo '>';
            echo '</h4>';
            echo '</div>
            <button disabled class="move-up-btn_new" title="Move Up">
            <!-- SVG for move up -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0L12 8.292a.5.5 0 0 1-.708.708L8 5.707V12.5a.5.5 0 0 1-1 0V5.707L4.707 9a.5.5 0 1 1-.708-.708l3.647-3.646z"/>
        </svg>
        </button>
        <button disabled class="move-down-btn_new" title="Move Down">
            <!-- SVG for move down -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1-.708 0L3.293 7.707a.5.5 0 1 1 .708-.708L7 10.293V3.5a.5.5 0 0 1 1 0v6.793l2.999-3.294a.5.5 0 0 1 .708.708l-4 4.147z"/>
        </svg>
        </button>
            <button disabled class="delete-btn" title="' . esc_html__('Delete', 'aiomatic-automatic-ai-content-writer') . '">X</button><div class="ai_common_holder"><div class="step-number"></div><div class="aiomatic-run-now"></div><div class="id-shower"></div></div></li></li>';
        }
    }
}
?>
                                            </td>
                                            </tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Select what type of block you want to add.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("OmniBlock Type To Add (Drag And Drop):", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<div class="ai-right-flex"><button id="add-new-btn_new" class="button page-title-action" title="<?php echo esc_html__('Add the above OmniBlock to the Queue', 'aiomatic-automatic-ai-content-writer');?>"><?php echo esc_html__('Add OmniBlock', 'aiomatic-automatic-ai-content-writer');?></button></div>
                                                </td>
                                                <td>
                                                <select title="<?php echo esc_html__('Change the OmniBlock Type which is displayed, which will be able to be added to the OmniBlock Queue.', 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full" id="omni_select_block_type_new" onchange="aiBlockTypeChangeHandler_new('');">
                                                    <option value="" disabled selected><?php echo esc_html__("Select a block type to add", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
$last_btype = '';
foreach ($default_block_types as $card_id) 
{
    if($card_id['category'] !== $last_btype)
    {
        echo '<option disabled value="">' . esc_html($card_id['category']) . '</option>';
        $last_btype = $card_id['category'];
    }
    echo '<option value="' . sanitize_title($card_id['name']) . '">' . esc_html($card_id['name']) . '</option>';
}
?>
                                                </select>
                                                </td>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>

</div>
    <hr/>
            </div>
        </div>  
    </div>
</div>

<div id="mymodalfzr_backup" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close_backup" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Backup/Restore OmniBlock Templates", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <br/>
<?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<hr/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Restore OmniBlock Templates From File", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px disable_drag">
        <?php
        echo esc_html__("Hit this button and you can restore OmniBlock Templates from file.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<div class="aiomatic_omni_upload_form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php
        echo esc_html__("Backup File (*.json)", 'aiomatic-automatic-ai-content-writer');
        ?></th>
            <td>
                <input type="file" id="aiomatic_omni_upload" accept=".json">
            </td>
        </tr>
        <tr>
            <th scope="row"><?php
        echo esc_html__("Overwrite Existing", 'aiomatic-automatic-ai-content-writer');
        ?></th>
            <td>
                <input type="checkbox" id="aiomatic_overwrite" value="1">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="aiomatic_upload_success aiomatic_none margin5 colorgr"><?php
        echo esc_html__("File uploaded successfully you can view it in the OmniBlock Templates listing tab.", 'aiomatic-automatic-ai-content-writer');
        ?></div>
                <div class="aiomatic_progress aiomatic_none"><span></span><small><?php
        echo esc_html__("Uploading", 'aiomatic-automatic-ai-content-writer');
        ?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_omni_button"><?php echo esc_html__("Import OmniBlock Templates From File", 'aiomatic-automatic-ai-content-writer');?></button><br>
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
               <?php echo esc_html__('Backup Current OmniBlock Templates To File:', 'aiomatic-automatic-ai-content-writer');?>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px disable_drag">
                     <?php
                        echo esc_html__("Hit this button and you can backup the current OmniBlock Templates to file.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <form method="post" onsubmit="return confirm('Are you sure you want to download OmniBlock Templates to file?');"><input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_omni');?>"><input name="aiomatic_download_omni_to_file" type="submit" class="button button-primary coderevolution_block_input" value="Backup OmniBlock Templates To File"></form>
         </div>
</div>
<br/>
<hr/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Import Default OmniBlock Templates (This Can Take For A While)", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px disable_drag">
        <?php
        echo esc_html__("Hit this button and the plugin will create the default OmniBlock Templates which come bundled with the plugin.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<table class="form-table">
        <tbody>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_omni_default_button"><?php echo esc_html__("Import Default OmniBlock Templates", 'aiomatic-automatic-ai-content-writer');?></button><br>
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
<div id="tab-4" class="tab-content">
<div class="wrap gs_popuptype_holder seo_pops">
<h2><?php echo esc_html__("Manage OmniBlock Files:", 'aiomatic-automatic-ai-content-writer');?></h2>
<br/>
<form method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to upload this file?');">
<label class="locationRemoteHide" for="aiomatic-file-upload-rules"><?php echo esc_html__("Select File To Upload:", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&nbsp;</label><input type="file" class="locationRemoteHide" id="aiomatic-file-upload-rules" name="aiomatic-file-upload-rules" value=""/>
<label class="locationRemoteShow cr_none" for="aiomatic-file-remote-rules"><?php echo esc_html__("Link To Remote File:", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&nbsp;</label><input type="url" class="locationRemoteShow cr_none" placeholder="<?php echo esc_html__("Remote file URL", 'aiomatic-automatic-ai-content-writer');?>" id="aiomatic-file-remote-rules" name="aiomatic-file-remote-rules" value=""/>
&nbsp;
<label for="aiomatic-file-upload-location"><?php echo esc_html__("Upload Location:", 'aiomatic-automatic-ai-content-writer');?>&nbsp;&nbsp;</label>
<select id="aiomatic-file-upload-location" name="aiomatic-file-upload-location" autocomplete="off" class="cr_width_auto" onchange="aiomatic_upload_selector_changing();">
<?php
$locations = array('local' => 'local');
if(!function_exists('is_plugin_active'))
{
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
{
    $locations['amazon'] = 'Amazon S3';
    $locations['wasabi'] = 'Wasabi';
    $locations['cloudflare'] = 'CloudFlare';
    $locations['digital'] = 'Digital Ocean';
}
$locations['remote'] = 'Remote Link';
foreach($locations as $id => $name)
{
?>
    <option value="<?php echo esc_attr($id);?>"
<?php
    if(esc_attr($id) == $value)
    {
        echo " selected";
    }
    echo '>' . ucfirst(esc_html($name)) . '</option>';
}
?>
</select>
<br/><br/>
<input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_omni');?>">
        <button onclick="location.reload(); return false;" id="aiomatic_sync_omni_files" name="aiomatic_sync_omni_files" class="page-title-action"><?php
        echo esc_html__("Sync OmniBlock Files", 'aiomatic-automatic-ai-content-writer');
        ?></button>&nbsp;
        <button onclick="return aiomatic_upload_field_empty();" id="aiomatic_upload_omni_files" name="aiomatic_upload_omni_files" class="page-title-action"><?php
        echo esc_html__("Upload OmniBlock File", 'aiomatic-automatic-ai-content-writer');
        ?></button>&nbsp;
        <button href="#" id="aiomatic_delete_selected_files" class="page-title-action"><?php
        echo esc_html__("Delete Selected OmniBlock Files", 'aiomatic-automatic-ai-content-writer');
        ?></button>
         </form>
<?php
$orderby = 'date';
$order = 'DESC';
if (isset($_GET['order']) && in_array(strtolower($_GET['order']), ['asc', 'desc'])) {
    $order = strtoupper($_GET['order']);
}
if (isset($_GET['orderby']) && in_array(strtolower($_GET['orderby']), ['title', 'date'])) {
    $orderby = strtolower($_GET['orderby']);
}
$aiomatic_omni_file_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_omni_file = new WP_Query(array(
    'post_type' => 'aiomatic_omni_file',
    'posts_per_page' => 40,
    'paged' => $aiomatic_omni_file_page,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'any'
));
if($aiomatic_omni_file->have_posts()){
    echo '<br><br>' . esc_html__('All OmniBlock Files', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_omni_file->found_posts . ')<br>';
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
        <th class="manage-column column-cb check-column aiomatic-tdcol" scope="col"><input class="aiomatic-chk" type="checkbox" id="checkedAllFiles"></th>
        <th scope="col"><a href="<?php echo esc_html($title_url); ?>"><?php
        echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');
        ?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php
        echo esc_html__("Location", 'aiomatic-automatic-ai-content-writer');
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
    if($aiomatic_omni_file->have_posts())
    {
        foreach ($aiomatic_omni_file->posts as $aiomatic_omni_f)
        {
            ?>
            <tr>
                <td><input class="aiomatic-select-omni-file" id="aiomatic-select-<?php echo $aiomatic_omni_f->ID;?>" type="checkbox" name="ids[]" value="<?php echo $aiomatic_omni_f->ID;?>"></td>
                <td><?php echo esc_html($aiomatic_omni_f->post_title);?></td>
                <td><?php $category_detail = get_the_terms($aiomatic_omni_f->ID, 'ai_file_type');
$categories_list = array();
if(is_array($category_detail))
{
    foreach($category_detail as $cd){
        $categories_list[] = $cd->slug;
    }
}
if(empty($categories_list))
{
    echo '-';
}
else
{
    echo esc_html(implode(', ', $categories_list));
}
?></td>
                <td><?php echo esc_html($aiomatic_omni_f->post_date)?></td>
                <td>
                <div class="cr_center">
                <form method="post"><input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_omni');?>"><input name="aiomatic_fid" type="hidden" value="<?php echo $aiomatic_omni_f->ID;?>"><a class="button button-small" target="_blank" href="<?php echo $aiomatic_omni_f->post_content;?>"><?php echo esc_html__("View", 'aiomatic-automatic-ai-content-writer');?></a>&nbsp;<input name="aiomatic_download_omni_file" type="submit" class="button button-small" value="Download">&nbsp;<button class="button button-small button-link-delete aiomatic_delete_omni_file" id="aiomatic_delete_omni_file_<?php echo $aiomatic_omni_f->ID;?>" delete-id="<?php echo $aiomatic_omni_f->ID;?>"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
                </form>
                </div>
            </td>
            </tr>
            <?php
        }
    }
    else
    {
        echo '<tr><td colspan="5">' . esc_html__("No OmniBlock Files found. You can add more using the 'Upload OmniBlock File' button from above. You can also generate new files using OmniBlocks.", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
    }
    ?>
    </tbody>
</table>
<div id="ai-video-containerx"><br/>
    <iframe class="ai-video" width="560" height="315" src="https://www.youtube.com/embed/gCbUO6Pf6ag" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<?php
if($aiomatic_omni_file->have_posts() && $aiomatic_omni_file->max_num_pages > 1)
{
?>
<div class="aiomatic-paginate">
    <?php
    echo esc_html__("Page: ", 'aiomatic-automatic-ai-content-writer') . paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_omniblocks&wpage=%#%'),
        'total'        => $aiomatic_omni_file->max_num_pages,
        'current'      => $aiomatic_omni_file_page,
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
</div>
</div>
<div id="tab-3" class="tab-content">
<div class="wrap gs_popuptype_holder seo_pops">
<h2><?php echo esc_html__("Manage OmniBlock Templates:", 'aiomatic-automatic-ai-content-writer');?></h2>
<br/>
        <button id="aiomatic_manage_omni_templates" class="page-title-action"><?php
        echo esc_html__("Add New OmniBlock Template", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button id="aiomatic_backup_templates" class="page-title-action"><?php
        echo esc_html__("Backup/Restore OmniBlock Templates", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_delete_selected_templates" class="page-title-action"><?php
        echo esc_html__("Delete Selected OmniBlock Templates", 'aiomatic-automatic-ai-content-writer');
        ?></button>
<?php
$aiomatic_omni_template_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_omni_temp = new WP_Query(array(
    'post_type' => 'aiomatic_omni_temp',
    'posts_per_page' => 40,
    'paged' => $aiomatic_omni_template_page,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'any'
));
if($aiomatic_omni_temp->have_posts()){
    echo '<br><br>' . esc_html__('All OmniBlock Templates', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_omni_temp->found_posts . ')<br>';
}
?>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th class="manage-column column-cb check-column aiomatic-tdcol" scope="col"><input class="aiomatic-chk" type="checkbox" id="checkedAll"></th>
        <th scope="col"><a href="<?php echo esc_html($title_url); ?>"><?php
        echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');
        ?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php
        echo esc_html__("Category", 'aiomatic-automatic-ai-content-writer');
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
    if($aiomatic_omni_temp->have_posts())
    {
        foreach ($aiomatic_omni_temp->posts as $aiomatic_omni_template)
        {
            ?>
            <tr>
                <td><input class="aiomatic-select-omni-template" id="aiomatic-select-<?php echo $aiomatic_omni_template->ID;?>" type="checkbox" name="ids[]" value="<?php echo $aiomatic_omni_template->ID;?>"></td>
                <td><?php echo esc_html($aiomatic_omni_template->post_title);?></td>
                <td><?php $category_detail = get_the_terms($aiomatic_omni_template->ID, 'ai_template_categories');
$categories_list = array();
if(is_array($category_detail))
{
    foreach($category_detail as $cd){
        $categories_list[] = $cd->slug;
    }
}
if(empty($categories_list))
{
    echo '-';
}
else
{
    echo esc_html(implode(', ', $categories_list));
}
?></td>
                <td><?php echo esc_html($aiomatic_omni_template->post_date)?></td>
                <td>
                <div class="cr_center">
                <button class="button button-small aiomatic_duplicate_omni_template" id="aiomatic_duplicate_omni_template_<?php echo $aiomatic_omni_template->ID;?>" dup-id="<?php echo $aiomatic_omni_template->ID;?>"><?php echo esc_html__("Duplicate", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_edit_omni_template" id="aiomatic_edit_omni_template_<?php echo $aiomatic_omni_template->ID;?>" edit-id="<?php echo $aiomatic_omni_template->ID;?>"><?php echo esc_html__("Edit", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small button-link-delete aiomatic_delete_omni_template" id="aiomatic_delete_omni_template_<?php echo $aiomatic_omni_template->ID;?>" delete-id="<?php echo $aiomatic_omni_template->ID;?>"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
                </div>
            </td>
            </tr>
            <?php
        }
    }
    else
    {
        echo '<tr><td colspan="5">' . esc_html__("No OmniBlock Templates added. You can add more using the 'Add New OmniBlock Templates' button from above. You can also import the default templates which come with the plugin, by clicking on the 'Backup/Restore OmniBlock Templates' button from above and afterwards, the 'Import Default OmniBlock Templates' button.", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
    }
    ?>
    </tbody>
</table>
<?php
if($aiomatic_omni_temp->have_posts() && $aiomatic_omni_temp->max_num_pages > 1)
{
?>
<div class="aiomatic-paginate">
    <?php
    echo esc_html__("Page: ", 'aiomatic-automatic-ai-content-writer') . paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_omniblocks&wpage=%#%'),
        'total'        => $aiomatic_omni_temp->max_num_pages,
        'current'      => $aiomatic_omni_template_page,
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
</div>
</div>
<div id="tab-2" class="tab-content">
<div class="wrap gs_popuptype_holder gs_display_table seo_pops">
<h2><?php echo esc_html__("Available OmniBlock Types:", 'aiomatic-automatic-ai-content-writer');?></h2>
<?php
$default_cards_showcase = $default_block_types;
foreach ($default_cards_showcase as $k => $v):
    $v['enabled'] = true;
    $v['link'] = array();
    if(isset($v['required_plugin']) && is_array($v['required_plugin']))
    {
        foreach($v['required_plugin'] as $rslug => $rp)
        {
            if(!function_exists('is_plugin_active'))
            {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }
            if (!is_plugin_active($rslug)) 
            {
                $v['enabled'] = false;
                $v['link'][$rp[1]] = $rp[0];
            }
        }
    }
    ?>
	<div class="aiomatic-magic-box-wrap<?php echo ($v['enabled']) ? '' : ' aiomatic-disabled-box';?>">
<?php
if(!empty($v['link']))
{
?>
		<a href="<?php echo key($v['link']);?>" target="_blank">
<?php
}
?>
			<div class="aiomatic-magic-feature <?php echo $k;?>">
				<div class="aiomatic-magic-box-title"><?php echo $v['name'];?></div>
				<div class="aiomatic-magic-box-desc"><?php echo $v['description'];?></div><br/>
				<div class="aiomatic-magic-box-desc"><?php echo esc_html__('Category:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . trim($v['category'], ' -');?></div>
                <?php
                if(!$v['enabled'])
                {
                ?>
                <br/><div class="aiomatic-magic-box-desc">>> <?php echo esc_html_e('Required plugin not active. Get It Now!', 'aiomatic-automatic-ai-content-writer');?> <<</div>
                <?php
                }
                ?>
			</div>
            <?php
if(!empty($v['link']))
{
?>
		</a>
<?php
}
?>
	</div>
<?php endforeach;?>

</div>
</div>
<div id="tab-0" class="tab-content">
<div class="wrap gs_popuptype_holder gs_display_table seo_pops">
<h2><?php echo esc_html__("Welcome to the AI OmniBlocks Tutorial", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("In this tutorial, we will explore the AI OmniBlocks feature of the Aiomatic plugin, which will be a guaranteed gamechanger for the AI game!", 'aiomatic-automatic-ai-content-writer');?></p>

<h2><?php echo esc_html__("Getting Started with AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("First, ensure you have installed the latest version of Aiomatic. Be sure to update the plugin to the latest version available for download on CodeCanyon.", 'aiomatic-automatic-ai-content-writer');?></p>

<h2><?php echo esc_html__("Understanding OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("OmniBlocks are modular AI-driven elements that can be combined and executed sequentially to automate content creation tasks. They will bring limitless potential to AI driven work, allowing you to create your own AI driven task sequence, in a queue.", 'aiomatic-automatic-ai-content-writer');?></p>
<p><?php echo esc_html__("For example, the first OmniBlock in a sequence might generate an SEO-optimized blog post title based on input keywords, while subsequent blocks might generate an article outline, and then the full article text. Upcoming blocks can publish the article, while the final blocks can share the article on a specific social network of your choice.", 'aiomatic-automatic-ai-content-writer');?></p>

<h2><?php echo esc_html__("Meeting OmniBlocks For The First Time", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("Once installed, navigate to the AI OmniBlocks menu in your dashboard where you'll find the following tabs in the menu:", 'aiomatic-automatic-ai-content-writer');?></p>
<ul>
    <li><?php echo esc_html__("OmniBlock Rule Manager", 'aiomatic-automatic-ai-content-writer');?></li>
    <li><?php echo esc_html__("OmniBlock Template Manager", 'aiomatic-automatic-ai-content-writer');?></li>
    <li><?php echo esc_html__("OmniBlock Types", 'aiomatic-automatic-ai-content-writer');?></li>
    <li><?php echo esc_html__("OmniBlock Files", 'aiomatic-automatic-ai-content-writer');?></li>
</ul>

<h2><?php echo esc_html__("Importing Default Templates", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("Begin by importing the default templates that come bundled with the plugin:", 'aiomatic-automatic-ai-content-writer');?></p>
<ol>
    <li><?php echo esc_html__("Go to the OmniBlock Template Manager tab.", 'aiomatic-automatic-ai-content-writer');?></li>
    <li><?php echo esc_html__("Click on 'Backup/Restore OmniBlock Templates'.", 'aiomatic-automatic-ai-content-writer');?></li>
    <li><?php echo esc_html__("In the popup, click 'Import Default OmniBlock Templates'.", 'aiomatic-automatic-ai-content-writer');?></li>
</ol>
<p><?php echo esc_html__("This action refreshes the page and new templates such as 'Amazon Best Sellers', 'Engaging Blog Post Title', and others will appear.", 'aiomatic-automatic-ai-content-writer');?></p>

<h2><?php echo esc_html__("Configuring OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></h2>
<div>
    <p><strong><?php echo esc_html__("Example:", 'aiomatic-automatic-ai-content-writer');?></strong> <?php echo esc_html__("To configure an OmniBlock for creating a simple blog post:", 'aiomatic-automatic-ai-content-writer');?></p>
    <p><?php echo esc_html__("1. Enter a keyword in the input field.", 'aiomatic-automatic-ai-content-writer');?></p>
    <p><?php echo esc_html__("2. Select the relevant template from the Template Manager.", 'aiomatic-automatic-ai-content-writer');?></p>
    <p><?php echo esc_html__("3. Click 'Save Settings' to ensure all configurations are stored.", 'aiomatic-automatic-ai-content-writer');?></p>
    <p><?php echo esc_html__("4. Run the OmniBlock rule, using the 'Select an action' button from the created OmniBlock rule.", 'aiomatic-automatic-ai-content-writer');?></p>
</div>

<h2><?php echo esc_html__("Creating Custom Templates", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("You can also create your own OmniBlock templates by combining different types of blocks as per your specific needs. This is particularly useful for more complex tasks that require customized workflows.", 'aiomatic-automatic-ai-content-writer');?></p>

<h2><?php echo esc_html__("Testing and Feedback", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("Since AI OmniBlocks are still in beta, testing them thoroughly and providing feedback is crucial. If you encounter any issues or have suggestions for improvements, you can contact via the email listed on the YouTube channel or leave a comment under the video.", 'aiomatic-automatic-ai-content-writer');?></p>

<h2><?php echo esc_html__("Conclusion", 'aiomatic-automatic-ai-content-writer');?></h2>
<p><?php echo esc_html__("This feature, although still under development, represents a significant advancement in automating content creation within the Aiomatic environment. With further refinement and user feedback, it will become even more powerful.", 'aiomatic-automatic-ai-content-writer');?></p>

<p><?php echo esc_html__("Thank you for following this tutorial. Look forward to more updates on this feature!", 'aiomatic-automatic-ai-content-writer');?></p>
<h2><?php echo esc_html__("OmniBlocks Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h2>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/vuyssxmxP_Y" frameborder="0" allowfullscreen></iframe></div></p>
</div>
</div>
<div id="tab-1" class="tab-content">
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <form novalidate id="myForm" method="post" action="<?php echo (aiomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">
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
                  <table id="mainRules" class="aiomatic-automation responsive table cr_main_table">
                     <thead>
                        <tr>
                           <th class="cr_width_160">
                              <?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("This is the ID of the rule.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Keywords", 'aiomatic-automatic-ai-content-writer');?>*
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("Set the main keywords which will be processed by this automation task. Enter a keyword on each line. You will be able to access the values of these keywords, from the AI process, using the following shortcode: %%keyword%%", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Schedule", 'aiomatic-automatic-ai-content-writer');?>*
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
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
                              <?php echo esc_html__("# Actions", 'aiomatic-automatic-ai-content-writer');?>*
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("Select the maximum number of keywords to process in a single run.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("OmniBlock Manager", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("Configures OmniBlocks for this rule.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("More Settings", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("Configure advanced settings for this rule.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_width_60">
                              <?php echo esc_html__("Del", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("Do you want to delete this rule?", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_width_60">
                              <?php echo esc_html__("Active", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
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
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                    <?php
                                       echo esc_html__("The number of items (posts, pages) this rule has generated so far.", 'aiomatic-automatic-ai-content-writer');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_actions">
                              <?php echo esc_html__("Actions", 'aiomatic-automatic-ai-content-writer');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
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
                           echo aiomatic_expand_rules_omni($default_block_types, $all_models, $all_models_function, $all_dalle_models, $all_stable_models, $all_assistants, $all_stable_sizes, $all_midjourney_sizes, $all_stable_video_sizes, $all_dalle_sizes, $all_scraper_types, $aiomatic_Main_Settings, $all_formats, $language_names, $language_codes, $deepl_auth, $language_names_deepl, $language_codes_deepl, $bing_auth, $language_names_bing, $language_codes_bing, $temp_list, $aiomatic_tax_names);
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
                           <td class="cr_short_td"><input type="text" name="aiomatic_omni_list[rule_description][]" id="rule_description" class="cr_center" placeholder="Rule ID" value="" class="cr_width_full"/></td>
                           <td class="cr_loi"><textarea rows="1" name="aiomatic_omni_list[main_keywords][]" placeholder="Main keywords" class="cr_width_full"></textarea></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" name="aiomatic_omni_list[schedule][]" max="8765812" class="cr_width_60" placeholder="Select the rule schedule interval" value="24"/></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" name="aiomatic_omni_list[max][]" class="cr_width_60" placeholder="Select the # of generated posts" value="1" /></td>
                           <td class="cr_width_70 cr_center">
                              <input type="button" id="mybtnauto" value="Configure">
                              <div id="mymodalauto" class="codemodalauto">
                                 <div class="codemodalauto-content">
                                    <div class="codemodalauto-header">
                                       <span id="aiomatic_auto_close" class="codecloseauto">&times;</span>
                                       <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'aiomatic-automatic-ai-content-writer');?></span> - <?php echo esc_html__("AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></h2>
                                    </div>
                                    <div class="codemodalauto-body">
                                       <div class="table-responsive">
                                          <table class="aiomatic-automation responsive table cr_main_table_nowr">
                                            <tbody class="aiomatic-tbody-automation">
                                             <tr><td class="aiomatic_block_me" colspan="2">
                                                  <h2><?php echo esc_html__("Manage AI OmniBlocks", 'aiomatic-automatic-ai-content-writer');?>:</h2>
                                            <div class="aiseparator aistart"><b><?php echo esc_html__("OmniBlock Queue Starts Here", 'aiomatic-automatic-ai-content-writer');?></b></div>
                                             </td></tr>
                                            <tr>
                                            <td colspan="2">
                                            <input type="hidden" id="sortable_cards" name="aiomatic_omni_list[aiomatic_sortable_cards][]" value="<?php echo htmlspecialchars(json_encode($default_cards));?>">
                                            <ul id="aiomatic_sortable_cards" name="aiomatic_sortable_cards">
<?php
    $global_index = '1';
    if(empty($default_block_types))
    {
        echo esc_html__('No AI OmniBlock Types Added To This Rule', 'aiomatic-automatic-ai-content-writer');
    }
    else
    {
        $exec = 1;
        $shortcodes_arr = array('%%keyword%%');
        foreach ($default_cards as $card_id) 
        {
            if(!empty($card_id['type']))
            {
                $assistant_helper = uniqid();
                $urlrandval = uniqid();
                $global_index = $card_id['identifier'];
                $card_type_found = array();
                foreach($default_block_types as $def_card)
                {
                    if($card_id['type'] == $def_card['id'])
                    {
                        $card_type_found = $def_card;
                        break;
                    }
                }
                if(empty($card_type_found))
                {
                    aiomatic_log_to_file('Warning! OmniBlock type not found for: ' . print_r($card_id, true));
                }
                else
                {
                    $local_shortcodes = array();
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        $local_shortcodes[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                    }
                    $plugin_required = array();
                    if(!empty($card_type_found['required_plugin']))
                    {
                        foreach($card_type_found['required_plugin'] as $pslug => $pname)
                        {
                            if(!function_exists('is_plugin_active'))
                            {
                                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            }
                            if (!is_plugin_active($pslug)) 
                            {
                                $plugin_required[] = 'You need enable the "' . $pname[0] . '" plugin for this OmniBlock type to work: ' . $pname[1];
                            }
                        }
                    }
                    echo '<li data-id-str="" class="omniblock-card"><input data-clone-index="xc' . uniqid() . '" class="cr_center aiomatic-bold aiomatic-indigo omniblock-title" card-type="' . esc_html($card_type_found['id']) . '" type="text" placeholder="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '"  title="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '" value="' . esc_attr($card_id['name']) . '">
                    <input type="hidden" class="omniblock-id" card-type="' . esc_html($card_type_found['id']) . '" value="' . esc_attr($card_id['identifier']) . '">
                    <input type="hidden" class="omniblock-shortcodes" card-type="' . esc_html($card_type_found['id']) . '" value="' . esc_attr(implode(',', $local_shortcodes)) . '">';
                    if($card_type_found['id'] == 'text_spinner')
                    {
                        if (!isset($aiomatic_Main_Settings['spin_text']) || $aiomatic_Main_Settings['spin_text'] === 'disabled')
                        {
                            $plugin_required[] = 'Spinning disabled from \'Settings\' -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field, this OmniBlock will not function';
                        }
                        if (isset($aiomatic_Main_Settings['spin_what']) && $aiomatic_Main_Settings['spin_what'] === 'bulk') 
                        {
                            $plugin_required[] = 'Spinning disabled for OmniBlocks, from plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Enable Spinner For\' settings field, this OmniBlock will not function';
                        }
                    }
                    elseif($card_type_found['id'] == 'embeddings')
                    {
                        if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
                        {
                            $plugin_required[] = 'You must add an OpenAI/AiomaticAPI API Key into the plugin\'s \'Settings\' menu before you can use this feature!';
                        }
                        if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
                        {
                            $plugin_required[] = 'You must add a Pinecone API or a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                        }
                    }
                    foreach($card_id['parameters'] as $name => $orig_text)
                    {
                        if(isset($card_type_found['parameters'][$name]) && isset($card_type_found['parameters'][$name]['type']) && ($card_type_found['parameters'][$name]['type'] == 'text' || $card_type_found['parameters'][$name]['type'] == 'textarea' || $card_type_found['parameters'][$name]['type'] == 'url' || $card_type_found['parameters'][$name]['type'] == 'scraper_string'))
                        {
                            foreach($shortcodes_arr as $sha)
                            {
                                $orig_text = str_replace($sha, '', $orig_text);
                            }
                            $incorrect_sh = array();
                            foreach($default_block_types as $cardt)
                            {
                                foreach($cardt['shortcodes'] as $shc)
                                {
                                    preg_match_all('~(%%' . $shc . '[a-zA-Z0-9]*?%%)~', $orig_text, $submatches);
                                    if(isset($submatches[1][0]))
                                    {
                                        foreach($submatches[1] as $incsh)
                                        {
                                            $incorrect_sh[] = $incsh;
                                        }
                                    }
                                }
                            }
                            if(!empty($incorrect_sh))
                            {
                                $plugin_required[] = 'This block has some incorrect shortcodes: ' . implode(',', $incorrect_sh);
                            }
                        }
                    }
                    if(!empty($plugin_required))
                    {
                        echo '<p class="requirement cr_red"><ul class="requirement cr_red">';
                        foreach($plugin_required as $pr)
                        {
                            echo '<li>' . $pr . '</li>';
                        }
                        echo '</ul></p>';
                    }
                    echo '<div class="card-name';
                    if($card_type_found['type'] == 'save')
                    {
                        echo ' aisave-content';
                    }
                    else
                    {
                        echo ' aicreate-content';
                    }
                    echo '">' . esc_html__('OmniBlock Type:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Created shortcodes by this OmniBlock (usable in OmniBlocks from below this one): ', 'aiomatic-automatic-ai-content-writer');
                    echo '<ul>';
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        echo '<li>%%' . $shtc . $card_id['identifier'] . '%%</li>';
                    }
                    echo '</ul>';
                    if (isset($aiomatic_Main_Settings['omni_webhook']) && trim($aiomatic_Main_Settings['omni_webhook']) == 'on')
                    {
                        $rest_url = rest_url('omniblock/v1/webhook');
                        if(isset($card_id['parameters']['api_key']) && !empty(trim($card_id['parameters']['api_key'])))
                        {
                            $rest_url = add_query_arg('apikey', trim($card_id['parameters']['api_key']), $rest_url);
                        }
                        $rest_url = add_query_arg('omniblockid', trim($cont) . '_' . trim($card_id['identifier']), $rest_url);
                        $rest_url = add_query_arg('input', urlencode('Webhooks in WordPress'), $rest_url);
                        $card_type_found['description'] = str_replace('%%webhook_url%%', '<br/><span class="cr_red disable_drag">' . $rest_url . '</span>', $card_type_found['description']);
                    }
                    else
                    {
                        $card_type_found['description'] = str_replace('%%webhook_url%%', '<span class="cr_red">' . esc_html__('OmniBlock Webhook functionality not enabled in \'Settings\' menu of the plugin!' , 'aiomatic-automatic-ai-content-writer') . '</span>', $card_type_found['description']);
                    }
                    echo '</div></div>&nbsp;' . esc_attr($card_type_found['name']) . '</div><p class="card-desc">' . $card_type_found['description'] . '</p><div class="ai-collapsible-holder"><button class="aicollapsible" title="' . esc_html__('Show/Hide Parameters', 'aiomatic-automatic-ai-content-writer') . '"><img class="controls-icon" src="' . plugin_dir_url( __FILE__ ) . '../images/controls.png' . '"></button></div><div class="aicollapsible-parameters">';
                    echo '<h3>' . esc_html__('OmniBlock Parameters', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Set the parameters which will be used in this OmniBlock.', 'aiomatic-automatic-ai-content-writer') . '</div></div></h3><hr/>';
                    foreach($card_type_found['parameters'] as $name => $card_type)
                    {
                        echo '<h4>' . esc_html($card_type['title']) . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html($card_type['description']) . '</div></div></h4>';
                        if($card_type['type'] == 'text')
                        {
                            $randval = uniqid();
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                            echo '<input type="text" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                            }
                            foreach($shortcodes_arr as $myshort)
                            {
                                $my_id = explode('_', $myshort);
                                $my_id = end($my_id);
                                $my_id = substr($my_id, 0, -2);
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  $myshort;
                                echo  '</p>';
                            }
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        elseif($card_type['type'] == 'textarea')
                        {
                            $randval = uniqid();
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                            echo '<textarea class="' . esc_attr($name) . ' cr_width_full" id="xai' . $randval . '" data-clone-index="xc' . uniqid() . '" placeholder="' . esc_html($card_type['placeholder']) . '">' . esc_textarea($value) . '</textarea>';
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                            }
                            foreach($shortcodes_arr as $myshort)
                            {
                                $my_id = explode('_', $myshort);
                                $my_id = end($my_id);
                                $my_id = substr($my_id, 0, -2);
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  $myshort;
                                echo  '</p>';
                            }
                            if($def_card['id'] == 'ai_text_foreach' && $name == 'prompt')
                            {
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  '%%current_input_line%%';
                                echo  '</p>';
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  '%%current_input_line_counter%%';
                                echo  '</p>';
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  '%%all_input_lines%%';
                                echo  '</p>';
                            }
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        elseif($card_type['type'] == 'model_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" id="xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_models as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'model_select_function')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" id="xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_models_function as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'assistant_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" id="sel_xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" onchange="assistantChanged(\'xa' . $assistant_helper . '\');" class="' . esc_attr($name) . ' cr_width_full">';
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
                                    if($value == '')
                                    {
                                        echo ' selected';
                                    }
                                    echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                    foreach($all_assistants as $myassistant)
                                    {
                                        echo '<option value="' . esc_attr($myassistant->ID) .'"';
                                        if($value == $myassistant->ID)
                                        {
                                            echo ' selected';
                                        }
                                        echo '>' . esc_html($myassistant->post_title);
                                        echo '</option>';
                                    }
                                }
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'dalle_image_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_dalle_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'stable_image_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_stable_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'midjourney_image_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_midjourney_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'stable_video_size_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_stable_video_sizes as $sizeid => $sizex)
                            {
                                echo '<option value="' . esc_attr($sizeid) .'"';
                                if($value == $sizeid)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($sizex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'scraper_type')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="scraper_selector ' . esc_attr($name) . ' cr_width_full" data-id-str="" data-source-field-id="ur' . $urlrandval . '" data-target-field-id="' . $assistant_helper . '">';
                            foreach($all_scraper_types as $index => $modelx)
                            {
                                echo '<option value="' . esc_attr($index) .'"';
                                if($value == $index)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'scraper_string')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<input type="text" data-clone-index="xc' . uniqid() . '" id="st' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                        }
                        elseif($card_type['type'] == 'number')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<input type="number" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                        }
                        elseif($card_type['type'] == 'checkbox')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            echo '<option value="0"';
                            if($value == '0')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("No", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="1"';
                            if($value == '1')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Yes", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'dalle_image_model_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_dalle_models as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'stable_image_model_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_stable_models as $modelx)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'status_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            echo '<option value="publish"';
                            if($value == "publish")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="pending"';
                            if($value == "pending")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="draft"';
                            if($value == "draft")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="private"';
                            if($value == "private")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="trash"';
                            if($value == "trash")
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'type_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach(get_post_types( '', 'names' ) as $modelx)
                            {
                                if(strstr($modelx, 'aiomatic_'))
                                {
                                   continue;
                                }
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'amazon_country_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach(aiomatic_get_amazon_codes() as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'amazon_sort_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach(aiomatic_get_amazon_sorts() as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'yt_community_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('text' => 'Text', 'image' => 'Image');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'reddit_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('auto' => 'Auto', 'link' => 'Link', 'self' => 'Text', 'image' => 'Image', 'video' => 'Video');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'method_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('POST' => 'POST', 'GET' => 'GET', 'PUT' => 'PUT', 'DELETE' => 'DELETE');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'content_type_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            $community_types = array('JSON' => 'JSON', 'form' => 'Form Data');
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($community_types as $key => $modelx)
                            {
                                echo '<option value="' . esc_attr($key) .'"';
                                if($value == $key)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($modelx) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'facebook_page_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
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
                                    echo '<option value="' . esc_html($exploding[0]) . '"';
                                    if($exploding[0] == $value)
                                    {
                                        echo " selected";
                                    }
                                    echo '>' . esc_html($exploding[2]) . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the F-omatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'location_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $locations = array('local' => 'local');
                            if(!function_exists('is_plugin_active'))
                            {
                                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            }
                            if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                            {
                                $locations['amazon'] = 'Amazon S3';
                                $locations['wasabi'] = 'Wasabi';
                                $locations['cloudflare'] = 'CloudFlare';
                                $locations['digital'] = 'Digital Ocean';
                            }
                            foreach($locations as $id => $name)
                            {
                                echo '<option value="' . esc_html($id) . '"';
                                if($id == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . ucfirst(esc_html($name)) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $values = $card_type['values'];
                            foreach($values as $id => $name)
                            {
                                echo '<option value="' . esc_html($id) . '"';
                                if($id == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html($name) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'file_type_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $locations = array('txt' => 'txt', 'html' => 'html', 'doc' => 'doc', 'pdf' => 'pdf');
                            if(!function_exists('is_plugin_active'))
                            {
                                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            }
                            foreach($locations as $id => $name)
                            {
                                echo '<option value="' . esc_html($id) . '"';
                                if($id == $value)
                                {
                                    echo " selected";
                                }
                                if ($id == 'pdf' && !is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
                                {
                                    echo " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
                                }
                                echo '>' . esc_html($name) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'file_selector')
                        {
                            if(empty($_GLOBALS['omni_files']))
                            {
                                $_GLOBALS['omni_files'] = get_posts([
                                    'post_type' => 'aiomatic_omni_file',
                                    'post_status' => 'publish',
                                    'numberposts' => -1
                                ]);
                            }
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            if(empty($_GLOBALS['omni_files']))
                            {
                                echo '<option disabled selected>' . esc_html__('No files added, add new files in the \'OmniBlock Files\' tab', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            else
                            {
                                echo '<option value="random"';
                                if('random' == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html__('Random', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                echo '<option value="latest"';
                                if('latest' == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html__('Latest', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            foreach($_GLOBALS['omni_files'] as $id => $name)
                            {
                                echo '<option value="' . esc_html($name->ID) . '"';
                                if($name->ID == $value)
                                {
                                    echo " selected";
                                }
                                echo '>' . esc_html($name->post_title) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'pinterest_board_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $boards = get_option('pinterestomatic_public_boards', false);
                            if($boards !== FALSE)
                            {
                                foreach($boards as $id => $name)
                                {
                                    echo '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        echo " selected";
                                    }
                                    echo '>' . esc_html($name) . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'gpb_page_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $boards = get_option('businessomatic_my_business_list', false);
                            if($boards !== FALSE)
                            {
                                foreach($boards as $id => $name)
                                {
                                    echo '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        echo " selected";
                                    }
                                    echo '>' . esc_html($name) . '</option>';
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the Businessomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'linkedin_page_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $companies = get_option('linkedinomatic_my_companies', array());
                            if(is_array($companies) && count($companies) > 0)
                            {
                                foreach($companies as $cmp_id => $cmp_name)
                                {
                                    if($cmp_name == 'Profile Page')
                                    {
                                        echo '<option value="' . esc_attr($cmp_id) . '"';
                                        if($cmp_id == $value)
                                        {
                                            echo ' selected';
                                        }
                                        echo '>' . esc_html($cmp_name) . '</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                        if('xxxLinkedinomaticxxx' . $cmp_id == $value)
                                        {
                                            echo ' selected';
                                        }
                                        echo '>' . esc_html($cmp_name) . '</option>';
                                    }
                                }
                            }
                            else
                            {
                                echo '<option disabled value="">' . esc_html__('You need to set up the Linkedinomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'language_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            $i = 0;
                            foreach ($language_names as $lang) {
                                echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                if ($value == $language_codes[$i]) {
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
                                    if ($value == $language_codes_deepl[$i]) {
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
                                    if ($value == $language_codes_bing[$i]) {
                                        echo ' selected';
                                    }
                                    echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                                    $i++;
                                }
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'format_selector')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                            foreach($all_formats as $modelx => $namex)
                            {
                                echo '<option value="' . esc_attr($modelx) .'"';
                                if($value == $modelx)
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($namex) . '</option>';
                            }
                            echo '</select>';
                        }
                        elseif($card_type['type'] == 'url')
                        {
                            $randval = uniqid();
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                            echo '<input type="url" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' ur' . esc_attr($urlrandval) . ' cr_width_full" id="xai' . $randval . '" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                            }
                            foreach($shortcodes_arr as $myshort)
                            {
                                $my_id = explode('_', $myshort);
                                $my_id = end($my_id);
                                $my_id = substr($my_id, 0, -2);
                                echo  '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                echo  $myshort;
                                echo  '</p>';
                            }
                            if(count($shortcodes_arr) > 0)
                            {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        elseif($card_type['type'] == 'scraper_select')
                        {
                            $value = '';
                            if(isset($card_id['parameters'][$name]))
                            {
                                $value = $card_id['parameters'][$name];
                            }
                            echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . '" id="sc' . $assistant_helper . '" class="cr_width_full">';
                            echo '<option value="0"';
                            if($value == '0')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="1"';
                            if($value == '1')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';         
                            echo '<option value="2"';
                            if($value == '2')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="3"';
                            if($value == '3')
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            echo '<option value="4"';
                            if($value == '4')
                            {
                                echo ' selected';
                            }
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                            }
                            echo '>' . esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                            }
                            echo '</option>';
                            echo '<option value="5"';
                            if($value == '5')
                            {
                                echo ' selected';
                            }
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                            }
                            echo '>' . esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                            }
                            echo '</option>';
                            echo '<option value="6"';
                            if($value == '6')
                            {
                                echo ' selected';
                            }
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                            }
                            echo '>';
                            echo esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                            if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                            {
                                echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                            }
                            echo '</option>';
                            echo '</select>';
                        }
                    }
                    $critical = false;
                    if(isset($card_id['parameters']['critical']) && $card_id['parameters']['critical'] == '1')
                    {
                        $critical = true;
                    }
                    echo '<h4>' . esc_html__("Critical", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is critical or not. When a Critical OmniBlock fails to generate its content correctly and it fails, it will cause the entire OmniBlock running sequence to stop. Non-critical OmniBlocks when they fail, the execution of blocks will continue, the result of the failed OmniBlock will be blank.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                    echo '&nbsp;<input type="checkbox" class="critical-blocks" data-clone-index="xc' . uniqid() . '" id="critical-' . esc_attr($card_id['identifier']) . '"';
                    if($critical == true)
                    {
                        echo ' checked';
                    }
                    echo '>';
                    echo '</h4>';
                    $disabled = false;
                    if(isset($card_id['parameters']['disabled']) && $card_id['parameters']['disabled'] == '1')
                    {
                        $disabled = true;
                    }
                    echo '<h4>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is disabled or not. The disabled OmniBlocks will be skipped from processing.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                    echo '&nbsp;<input type="checkbox" class="disabled-blocks" data-clone-index="xc' . uniqid() . '" id="disabled-' . esc_attr($card_id['identifier']) . '"';
                    if($disabled == true)
                    {
                        echo ' checked';
                    }
                    echo '>';
                    echo '</h4>';
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        $shortcodes_arr[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                    }
                    echo '</div>
                    <button class="move-up-btn" title="Move Up">
    <!-- SVG for move up -->
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0L12 8.292a.5.5 0 0 1-.708.708L8 5.707V12.5a.5.5 0 0 1-1 0V5.707L4.707 9a.5.5 0 1 1-.708-.708l3.647-3.646z"/>
</svg>
</button>
<button class="move-down-btn" title="Move Down">
    <!-- SVG for move down -->
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1-.708 0L3.293 7.707a.5.5 0 1 1 .708-.708L7 10.293V3.5a.5.5 0 0 1 1 0v6.793l2.999-3.294a.5.5 0 0 1 .708.708l-4 4.147z"/>
</svg>
</button>
                    <button class="delete-btn" title="' . esc_html__('Delete', 'aiomatic-automatic-ai-content-writer') . '">X</button><div class="ai_common_holder"><div class="step-number">' . esc_html__("Step", 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($exec) . '</div><div class="aiomatic-run-now"></div><div class="id-shower">' . esc_html__("ID:", 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($card_id['identifier']) . '</div></div></div></li>';
                    $exec++;
                }
            }
            else
            {
                aiomatic_log_to_file('Incorrect block format provided: ' . print_r($card_id, true));
            }
        }
    }
?>
        </ul>
</td>
</tr>
<tr>
<td colspan="2">
<?php
echo '<div class="aiseparator aistop"><b>' . esc_html__("OmniBlock Queue Stops Here", 'aiomatic-automatic-ai-content-writer') . '</b></div><h2>' . esc_html__('Add A New OmniBlock To The Above Queue (Drag And Drop):', 'aiomatic-automatic-ai-content-writer') . '</h2>';
?>
<ul id="aiomatic_new_card_types" name="aiomatic_new_card_types">
<?php
if(empty($default_block_types))
{
    echo esc_html__('No AI OmniBlock Types Defined!', 'aiomatic-automatic-ai-content-writer');
}
else
{
    $first = true;
    $ublockid = $global_index;
    foreach ($default_block_types as $card_id) 
    {
        if(!empty($card_id['type']))
        {
            aiomatic_increment($ublockid);
            $assistant_helper = uniqid();
            echo '<li data-id-str="" class="omniblock-card new-card';
            if($first != true)
            {
                echo ' cr_none';
            }
            $local_shortcodes = array();
            foreach($card_id['shortcodes'] as $shtc)
            {
                $local_shortcodes[] = '%%' . $shtc . $ublockid . '%%';
            }
            $plugin_required = array();
            if(!empty($card_id['required_plugin']))
            {
                foreach($card_id['required_plugin'] as $pslug => $pname)
                {
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (!is_plugin_active($pslug)) 
                    {
                        $plugin_required[] = 'You need enable the "' . $pname[0] . '" plugin for this OmniBlock type to work: ' . $pname[1];
                    }
                }
            }
            echo '" id="' . sanitize_title($card_id['name']) . '"><input data-clone-index="xc' . uniqid() . '" class="cr_center aiomatic-bold aiomatic-indigo omniblock-title" card-type="' . esc_html($card_id['id']) . '" type="text" placeholder="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '"  title="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '" value="' . esc_attr($card_id['name']) . '">
            <input type="hidden" class="omniblock-id" card-type="' . esc_html($card_id['id']) . '" value="' . esc_attr($ublockid) . '">
            <input type="hidden" class="omniblock-shortcodes" card-type="' . esc_html($card_id['id']) . '" value="' . esc_attr(implode(',', $local_shortcodes)) . '">';
            if($card_id['id'] == 'text_spinner')
            {
                if (!isset($aiomatic_Main_Settings['spin_text']) || $aiomatic_Main_Settings['spin_text'] === 'disabled')
                {
                    $plugin_required[] = 'Spinning disabled from \'Settings\' -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field, this OmniBlock will not function';
                }
                if (isset($aiomatic_Main_Settings['spin_what']) && $aiomatic_Main_Settings['spin_what'] === 'bulk') 
                {
                    $plugin_required[] = 'Spinning disabled for OmniBlocks, from plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Enable Spinner For\' settings field, this OmniBlock will not function';
                }
            }
            elseif($card_id['id'] == 'embeddings')
            {
                if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
                {
                    $plugin_required[] = 'You must add an OpenAI/AiomaticAPI API Key into the plugin\'s \'Settings\' menu before you can use this feature!';
                }
                if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
                {
                    $plugin_required[] = 'You must add a Pinecone API or a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
            }
            if(!empty($plugin_required))
            {
                echo '<p class="requirement cr_red"><ul class="requirement cr_red">';
                foreach($plugin_required as $pr)
                {
                    echo '<li>' . $pr . '</li>';
                }
                echo '</ul></p>';
            }
            echo '<div class="card-name';
            if($card_id['type'] == 'save')
            {
                echo ' aisave-content';
            }
            else
            {
                echo ' aicreate-content';
            }
            if (isset($aiomatic_Main_Settings['omni_webhook']) && trim($aiomatic_Main_Settings['omni_webhook']) == 'on')
            {
                $card_id['description'] = str_replace('%%webhook_url%%', esc_html__('add this OmniBlock and save settings to get the URL' , 'aiomatic-automatic-ai-content-writer'), $card_id['description']);
            }
            else
            {
                $card_id['description'] = str_replace('%%webhook_url%%', '<span class="cr_red">' . esc_html__('OmniBlock Webhook functionality not enabled in \'Settings\' menu of the plugin!' , 'aiomatic-automatic-ai-content-writer') . '</span>', $card_id['description']);
            }
            echo '">' . esc_html__('OmniBlock Type:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . esc_attr($card_id['name']) . '</div><p class="card-desc">' . $card_id['description'] . '</p><div class="ai-collapsible-holder"><button class="aicollapsible" title="' . esc_html__('Show/Hide Parameters', 'aiomatic-automatic-ai-content-writer') . '"><img class="controls-icon" src="' . plugin_dir_url( __FILE__ ) . '../images/controls.png' . '"></button></div><div class="aicollapsible-parameters">';
            echo '<h3>' . esc_html__('OmniBlock Parameters', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Set the parameters which will be used in this OmniBlock.', 'aiomatic-automatic-ai-content-writer') . '</div></div></h3><hr/>';
            $first = false;
            foreach($card_id['parameters'] as $name => $card_type)
            {
                echo '<h4>' . esc_html($card_type['title']) . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html($card_type['description']) . '</div></div></h4>';   
                if($card_type['type'] == 'text')
                {
                    $randval = uniqid();
                    echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                    echo '<input type="text" class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                    echo '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p></div>';
                    echo '</div>';
                }
                elseif($card_type['type'] == 'textarea')
                {
                    $randval = uniqid();
                    $additional = '';
                    if($name == 'prompt' && $card_id['id'] == 'ai_text_foreach')
                    {
                        $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%current_input_line_counter%%</p>';
                        $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%current_input_line%%</p>';
                        $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%all_input_lines%%</p>';
                    }
                    echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                    echo '<textarea class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">' . esc_textarea($card_type['default_value']) . '</textarea>';
                    echo '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p>' . $additional  . '</div>';
                    echo '</div>';
                }
                elseif($card_type['type'] == 'model_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="xa' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_models as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'model_select_function')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="xa' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_models_function as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'assistant_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="sel_xa' . $assistant_helper . '" onchange="assistantChanged(\'xa' . $assistant_helper . '\');" class="' . esc_attr($name) . ' cr_width_full">';
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
                            if('' == $card_type['default_value'])
                            {
                                echo ' selected';
                            }
                            echo '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
                            foreach($all_assistants as $myassistant)
                            {
                                echo '<option value="' . $myassistant->ID .'"';
                                if($myassistant->ID == $card_type['default_value'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($myassistant->post_title);
                                echo '</option>';
                            }
                        }
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'dalle_image_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_dalle_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'stable_image_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_stable_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'midjourney_image_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_midjourney_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'stable_video_size_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_stable_video_sizes as $sizeid => $sizex)
                    {
                        echo '<option value="' . esc_attr($sizeid) .'"';
                        if($sizeid == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($sizex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'scraper_type')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="scraper_selector ' . esc_attr($name) . ' cr_width_full" data-id-str="" data-source-field-id="ur' . $urlrandval . '" data-target-field-id="' . $assistant_helper . '">';
                    foreach($all_scraper_types as $index => $modelx)
                    {
                        echo '<option value="' . esc_attr($index) .'"';
                        if($index == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'scraper_string')
                {
                    echo '<input type="text" class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="st' . $assistant_helper . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                }
                elseif($card_type['type'] == 'number')
                {
                    echo '<input type="number" class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                }
                elseif($card_type['type'] == 'checkbox')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    echo '<option value="0"';
                    if('0' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("No", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="1"';
                    if('1' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Yes", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '</select>';
                }
                elseif($card_type['type'] == 'dalle_image_model_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_dalle_models as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'stable_image_model_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_stable_models as $modelx)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'status_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    echo '<option value="publish"';
                    if("publish" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="pending"';
                    if("pending" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="draft"';
                    if("draft" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="private"';
                    if("private" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                    <option value="trash"';
                    if("trash" == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '</select>';
                }
                elseif($card_type['type'] == 'type_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach(get_post_types( '', 'names' ) as $modelx)
                    {
                        if(strstr($modelx, 'aiomatic_'))
                        {
                           continue;
                        }
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'amazon_country_select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach(aiomatic_get_amazon_codes() as $key => $modelx)
                    {
                        echo '<option value="' . $key .'"';
                        if($key == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'amazon_sort_select')
                {
                    $value = '';
                    if(isset($card_id['parameters'][$name]))
                    {
                        $value = $card_id['parameters'][$name];
                    }
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach(aiomatic_get_amazon_sorts() as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($value == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'yt_community_selector')
                {
                    $community_types = array('text' => 'Text', 'image' => 'Image');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'reddit_selector')
                {
                    $community_types = array('auto' => 'Auto', 'link' => 'Link', 'self' => 'Text', 'image' => 'Image', 'video' => 'Video');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'method_selector')
                {
                    $community_types = array('POST' => 'POST', 'GET' => 'GET', 'PUT' => 'PUT', 'DELETE' => 'DELETE');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'content_type_selector')
                {
                    $community_types = array('JSON' => 'JSON', 'form' => 'Form Data');
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($community_types as $key => $modelx)
                    {
                        echo '<option value="' . esc_attr($key) .'"';
                        if($card_type['default_value'] == $key)
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($modelx) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'facebook_page_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
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
                            echo '<option value="' . esc_html($exploding[0]) . '"';
                            if($exploding[0] == $card_type['default_value'])
                            {
                                echo " selected";
                            }
                            echo '>' . esc_html($exploding[2]) . '</option>';
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the F-omatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'location_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $locations = array('local' => 'local');
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                    {
                        $locations['amazon'] = 'Amazon S3';
                        $locations['wasabi'] = 'Wasabi';
                        $locations['cloudflare'] = 'CloudFlare';
                        $locations['digital'] = 'Digital Ocean';
                    }
                    foreach($locations as $id => $name)
                    {
                        echo '<option value="' . esc_html($id) . '"';
                        if($id == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . ucfirst(esc_html($name)) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'select')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $values = $card_type['values'];
                    foreach($values as $id => $name)
                    {
                        echo '<option value="' . esc_html($id) . '"';
                        if($id == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html($name) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'file_type_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $locations = array('txt' => 'txt', 'html' => 'html', 'doc' => 'doc', 'pdf' => 'pdf');
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    foreach($locations as $id => $name)
                    {
                        echo '<option value="' . esc_html($id) . '"';
                        if($id == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        if ($id == 'pdf' && !is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
                        {
                            echo " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
                        }
                        echo '>' . esc_html($name) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'file_selector')
                {
                    if(empty($_GLOBALS['omni_files']))
                    {
                        $_GLOBALS['omni_files'] = get_posts([
                            'post_type' => 'aiomatic_omni_file',
                            'post_status' => 'publish',
                            'numberposts' => -1
                        ]);
                    }
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    if(empty($_GLOBALS['omni_files']))
                    {
                        echo '<option selected disabled>' . esc_html__('No files added, add new files in the \'OmniBlock Files\' tab', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    else
                    {
                        echo '<option value="random"';
                        if('random' == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html__('Random', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        echo '<option value="latest"';
                        if('latest' == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html__('Latest', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    foreach($_GLOBALS['omni_files'] as $id => $name)
                    {
                        echo '<option value="' . esc_html($name->ID) . '"';
                        if($name->ID == $card_type['default_value'])
                        {
                            echo " selected";
                        }
                        echo '>' . esc_html($name->post_title) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'pinterest_board_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $boards = get_option('pinterestomatic_public_boards', false);
                    if($boards !== FALSE)
                    {
                        foreach($boards as $id => $name)
                        {
                            echo '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                echo " selected";
                            }
                            echo '>' . esc_html($name) . '</option>';
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'gpb_page_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $boards = get_option('businessomatic_my_business_list', false);
                    if($boards !== FALSE)
                    {
                        foreach($boards as $id => $name)
                        {
                            echo '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                echo " selected";
                            }
                            echo '>' . esc_html($name) . '</option>';
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the Businessomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'linkedin_page_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $companies = get_option('linkedinomatic_my_companies', array());
                    if(is_array($companies) && count($companies) > 0)
                    {
                        foreach($companies as $cmp_id => $cmp_name)
                        {
                            if($cmp_name == 'Profile Page')
                            {
                                echo '<option value="' . esc_attr($cmp_id) . '"';
                                if($cmp_id == $card_type['default_value'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($cmp_name) . '</option>';
                            }
                            else
                            {
                                echo '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                if('xxxLinkedinomaticxxx' . $cmp_id == $card_type['default_value'])
                                {
                                    echo ' selected';
                                }
                                echo '>' . esc_html($cmp_name) . '</option>';
                            }
                        }
                    }
                    else
                    {
                        echo '<option disabled value="">' . esc_html__('You need to set up the Linkedinomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'language_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    $i = 0;
                    foreach ($language_names as $lang) {
                        echo '<option value="' . esc_html($language_codes[$i]) . '"';
                        if ($card_type['default_value'] == $language_codes[$i]) {
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
                            if ($card_type['default_value'] == $language_codes_deepl[$i]) {
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
                            if ($card_type['default_value'] == $language_codes_bing[$i]) {
                                echo ' selected';
                            }
                            echo '>' . esc_html($language_names_bing[$i]) . '</option>';
                            $i++;
                        }
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'format_selector')
                {
                    echo '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                    foreach($all_formats as $modelx => $namex)
                    {
                        echo '<option value="' . $modelx .'"';
                        if($modelx == $card_type['default_value'])
                        {
                            echo ' selected';
                        }
                        echo '>' . esc_html($namex) . '</option>';
                    }
                    echo '</select>';
                }
                elseif($card_type['type'] == 'url')
                {
                    $randval = uniqid();
                    echo '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                    echo '<input type="url" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' ur' . esc_attr($urlrandval) . ' cr_width_full" id="xai' . $randval . '" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                    echo '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p></div>';
                    echo '</div>';
                }
                elseif($card_type['type'] == 'scraper_select')
                {
                    echo '<select data-clone-index="xc' . uniqid() . '" autocomplete="off" id="sc' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                    echo '<option value="0"';
                    if('0' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="1"';
                    if('1' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';         
                    echo '<option value="2"';
                    if('2' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="3"';
                    if('3' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    echo '>' . esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                    echo '<option value="4"';
                    if('4' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                    }
                    echo '>' . esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                    }
                    echo '</option>';
                    echo '<option value="5"';
                    if('5' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                    }
                    echo '>' . esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                    }
                    echo '</option>';
                    echo '<option value="6"';
                    if('6' == $card_type['default_value'])
                    {
                        echo ' selected';
                    }
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                    }
                    echo '>';
                    echo esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                    {
                        echo esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                    }
                    echo '</option>';
                    echo '</select>';
                }
            }
            $critical = false;
            if(isset($card_id['parameters']['critical']) && $card_id['parameters']['critical'] == '1')
            {
                $critical = true;
            }
            echo '<h4>' . esc_html__("Critical", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is critical or not. When a Critical OmniBlock fails to generate its content correctly and it fails, it will cause the entire OmniBlock running sequence to stop. Non-critical OmniBlocks when they fail, the execution of blocks will continue, the result of the failed OmniBlock will be blank.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
            echo '&nbsp;<input type="checkbox" class="critical-blocks" data-clone-index="xc' . uniqid() . '" id="critical-' . esc_attr($ublockid) . '"';
            if($critical == true)
            {
                echo ' checked';
            }
            echo '>';
            echo '</h4>';
            $disabled = false;
            if(isset($card_id['parameters']['disabled']) && $card_id['parameters']['disabled'] == '1')
            {
                $disabled = true;
            }
            echo '<h4>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is disabled or not. The disabled OmniBlocks will be skipped from processing.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
            echo '&nbsp;<input type="checkbox" class="disabled-blocks" data-clone-index="xc' . uniqid() . '" id="disabled-' . esc_attr($ublockid) . '"';
            if($disabled == true)
            {
                echo ' checked';
            }
            echo '>';
            echo '</h4>';
            echo '</div>
            <button disabled class="move-up-btn" title="Move Up">
            <!-- SVG for move up -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0L12 8.292a.5.5 0 0 1-.708.708L8 5.707V12.5a.5.5 0 0 1-1 0V5.707L4.707 9a.5.5 0 1 1-.708-.708l3.647-3.646z"/>
        </svg>
        </button>
        <button disabled class="move-down-btn" title="Move Down">
            <!-- SVG for move down -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1-.708 0L3.293 7.707a.5.5 0 1 1 .708-.708L7 10.293V3.5a.5.5 0 0 1 1 0v6.793l2.999-3.294a.5.5 0 0 1 .708.708l-4 4.147z"/>
        </svg>
        </button>
            <button disabled class="delete-btn" title="' . esc_html__('Delete', 'aiomatic-automatic-ai-content-writer') . '">X</button><div class="ai_common_holder"><div class="step-number"></div><div class="aiomatic-run-now"></div><div class="id-shower"></div></div></li></li>';
        }
    }
}
?>
                                            </td>
                                            </tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Select what type of block you want to add.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("OmniBlock Type To Add (Drag And Drop):", 'aiomatic-automatic-ai-content-writer');?></b>&nbsp;<div class="ai-right-flex"><button id="add-new-btn" class="button page-title-action" title="<?php echo esc_html__('Add the above OmniBlock to the Queue', 'aiomatic-automatic-ai-content-writer');?>"><?php echo esc_html__('Add OmniBlock', 'aiomatic-automatic-ai-content-writer');?></button></div>
                                                </td>
                                                <td>
                                                <select title="<?php echo esc_html__('Change the OmniBlock Type which is displayed, which will be able to be added to the OmniBlock Queue.', 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full" id="omni_select_block_type" onchange="aiBlockTypeChangeHandler('');">
                                                    <option value="" disabled selected><?php echo esc_html__("Select a block type to add", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
$last_btype = '';
foreach ($default_block_types as $card_id) 
{
    if($card_id['category'] !== $last_btype)
    {
        echo '<option disabled value="">' . esc_html($card_id['category']) . '</option>';
        $last_btype = $card_id['category'];
    }
    echo '<option value="' . sanitize_title($card_id['name']) . '">' . esc_html($card_id['name']) . '</option>';
}
?>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr><td colspan="2"><hr/></td></tr>
                                             <tr><td colspan="2">
                                                  <h2><?php echo esc_html__("Additional Parameters", 'aiomatic-automatic-ai-content-writer');?>:</h2>
                                             </td></tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Add additional shortcodes which will be available in the OmniBlocks. Add multiple shortcodes on a new line. In the above OmniBlocks, you can use the shortcodes in this format: %%shortcode_name%%. The format is: shortcode_name => shortcode_value1, shortcode_value2", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Shortcodes:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" title="<?php echo esc_html__('Set up additional shortcodes which will be available in OmniBlocks.', 'aiomatic-automatic-ai-content-writer');?>" name="aiomatic_omni_list[more_keywords][]" onchange="updateSortableInputAI('');" id="more_keywords" placeholder="shortcode_name => shortcode_value1, shortcode_value2" class="cr_width_full"></textarea>
                                                </td>
                                             </tr>
                                             <tr><td colspan="2"><hr/></td></tr>
                                             <tr><td colspan="2">
                                                  <h2><?php echo esc_html__("AI OmniBlock Templates Manager", 'aiomatic-automatic-ai-content-writer');?>:</h2>
                                             </td></tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Select a OmniBlock template to be used in this rule. You can import the default templates which come bundled with the plugin, from the above 'OmniBlock Template Manager' tab -> 'Backup/Restore OmniBlock Templates' button -> 'Import Default OmniBlock Templates' button.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Load An OmniBlock Template:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select title="<?php echo esc_html__('Select an OmniBlock Template to be loaded into the OmniBlock Queue. Note that this will overwrite your current OmniBlock setup.', 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full omni_select_template" id="omni_select_template" data-id="">
<?php
if(!empty($temp_list))
{
?>
                                                    <option value="" disabled selected><?php echo esc_html__("Select a template", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
foreach($temp_list as $templid => $templ)
{
    echo '<option value="' . esc_attr($templid) . '">' . esc_html($templ) . '</option>';
}
}
else
{
echo '<option value="" disabled selected>' . esc_html__("No templates found. Add some in the 'OmniBlock Template Manager' tab", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
?>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Select a OmniBlock template category to list.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Filter OmniBlock Templates By Category:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <select title="<?php echo esc_html__('Filter displayed OmniBlock Templates by Category.', 'aiomatic-automatic-ai-content-writer');?>" class="cr_width_full omni_select_template_cat" data-id="">
<?php
if(!empty($aiomatic_tax_names))
{
?>
                                                    <option value="" selected><?php echo esc_html__("Show all templates", 'aiomatic-automatic-ai-content-writer');?></option>
<?php
foreach($aiomatic_tax_names as $templ)
{
    echo '<option value="' . esc_attr($templ) . '">' . esc_html($templ) . '</option>';
}
}
else
{
echo '<option value="" disabled selected>' . esc_html__("No template categories found. Add some in the 'OmniBlock Template Manager' tab", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
?>
                                                </select>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="ai-flex">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Save the above OmniBlock queue as a new OmniBlock template. Afterwards, the template will be manageable in the 'OmniBlock Template Manager' tab from above.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Save Above OmniBlocks As A New Template:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="button" class="aisavetemplate button page-title-action" title="<?php echo esc_html__('Saves the OmniBlock Queue configured above, as a new Template', 'aiomatic-automatic-ai-content-writer');?>" data-id="" value="<?php echo esc_html__("Save New Template", 'aiomatic-automatic-ai-content-writer');?>">
                                                </td>
                                             </tr>
</tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="codemodalauto-footer">
                                       <br/>
                                       <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3>
                                       <span id="aiomatic_auto_ok" class="codeokauto cr_inline">OK&nbsp;</span>
                                       <br/><br/>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_width_70 cr_center">
                              <input type="button" id="mybtnfzr" value="Settings">
                              <div id="mymodalfzr" class="codemodalfzr">
                                 <div class="codemodalfzr-content">
                                    <div class="codemodalfzr-header">
                                       <span id="aiomatic_close" class="codeclosefzr">&times;</span>
                                       <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'aiomatic-automatic-ai-content-writer');?></span> <?php echo esc_html__("OmniBlocks", 'aiomatic-automatic-ai-content-writer');?></h2>
                                    </div>
                                    <div class="codemodalfzr-body">
                                       <div class="table-responsive">
                                          <table class="aiomatic-automation responsive table cr_main_table_nowr">
                                             <tr><td colspan="2">
                                                  <h2><?php echo esc_html__("Advanced Settings", 'aiomatic-automatic-ai-content-writer');?>:</h2>
                                             </td></tr>
                                             <tr>
                                                <td>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Select if you want to process each keyword from the added list only once.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Process Each Keyword Only Once:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="title_once" name="aiomatic_omni_list[title_once][]" checked>
                                                </td>
                                             </tr>
                                             <tr><td colspan="2"><h3><?php echo esc_html__('Scheduling Restrictions', 'aiomatic-automatic-ai-content-writer');?>:</h3></td></tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px disable_drag">
                                                            <?php
                                                               echo esc_html__("Select the days of the week when you don't want to run this rule. You can enter a comma separate list of day names.", 'aiomatic-automatic-ai-content-writer');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Do Not Run This Rule On The Following Days Of The Week:", 'aiomatic-automatic-ai-content-writer');?></b>
                                                      <br/><?php echo esc_html__("Current Server Time:", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . date('l', time()) . ', ' . date("Y-m-d H:i:s");?>
                                                </td>
                                                <td>
                                                <input type="text" class="cr_width_full" name="aiomatic_omni_list[days_no_run][]" value="" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">  
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
                           <td class="cr_short_td"><input type="checkbox" name="aiomatic_omni_list[active][]" value="1" checked />
                              <input type="hidden" name="aiomatic_omni_list[last_run][]" value="1988-01-27 00:00:00"/>
                           <input type="hidden" name="aiomatic_omni_list[rule_unique_id][]" value="<?php echo uniqid('', true);?>"/>
                           </td>
                           <td class="cr_short_td">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px disable_drag">
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
                                       <option value="erase" onclick=""><?php echo esc_html__("Erase Processed Keyword History", 'aiomatic-automatic-ai-content-writer');?></option>
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
         <div><?php echo esc_html__("* = required", 'aiomatic-automatic-ai-content-writer');?></div>
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
</div>
    <div id="running_status_ai"></div>
</div>
<?php
}
if (isset($_POST['aiomatic_omni_list'])) {
    add_action('admin_init', 'aiomatic_save_rules_omni');
}

function aiomatic_save_rules_omni($data2)
{
    $init_rules_per_page = get_option('aiomatic_posts_per_page', 12);
    $rules_per_page = get_option('aiomatic_posts_per_page', 12);
    if(isset($_POST['posts_per_page']))
    {
        update_option('aiomatic_posts_per_page', $_POST['posts_per_page']);
    }
    check_admin_referer('aiomatic_save_rules', '_aiomaticr_nonce');
    
    $data2 = $_POST['aiomatic_omni_list'];
    $rules = get_option('aiomatic_omni_list', array());
    if(!is_array($rules))
    {
        $rules = array();
    }
    $initial_rules = $rules;
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
    if (isset($data2['main_keywords'][0])) {
        for ($i = 0; $i < sizeof($data2['main_keywords']); ++$i) 
        {
            $bundle = array();
            if (isset($data2['schedule'][$i]) && $data2['schedule'][$i] != '' && $data2['main_keywords'][$i] != '') {
                $bundle[] = trim(sanitize_text_field($data2['schedule'][$i]));
                if (isset($data2['active'][$i])) {
                    $bundle[] = trim(sanitize_text_field($data2['active'][$i]));
                } else {
                    $bundle[] = '0';
                }
                $bundle[]     = trim(sanitize_text_field($data2['last_run'][$i]));
                $bundle[]     = trim(sanitize_text_field($data2['max'][$i]));
                $bundle[]     = $data2['main_keywords'][$i];
                $bundle[]     = trim($data2['title_once'][$i]);
                $bundle[]     = trim($data2['rule_description'][$i]);
                $bundle[]     = trim($data2['rule_unique_id'][$i]);
                $bundle[]     = trim($data2['aiomatic_sortable_cards'][$i]);
                $bundle[]     = $data2['more_keywords'][$i];
                $bundle[]     = $data2['days_no_run'][$i];
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
    //check for removals
    $arr_rem = array();
    foreach($initial_rules as $initr)
    {
        if(!aiomatic_array_search_recursive($initr, $rules))
        {
            $arr_rem[] = $initr;
        }
    }
    if(!empty($arr_rem))
    {
        foreach($arr_rem as $removeme)
        {
            if(isset($removeme[5]) && $removeme[5] == '1' && isset($removeme[4]) && trim($removeme[4]) !== '')
            {
                $keyword_arr = preg_split('/\r\n|\r|\n/', trim($removeme[4]));
                aiomatic_remove_processed_keywords($keyword_arr);
            }
        }
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
    update_option('aiomatic_omni_list', $rules, false);
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
function aiomatic_expand_rules_omni($default_block_types, $all_models, $all_models_function, $all_dalle_models, $all_stable_models, $all_assistants, $all_stable_sizes, $all_midjourney_sizes, $all_stable_video_sizes, $all_dalle_sizes, $all_scraper_types, $aiomatic_Main_Settings, $all_formats, $language_names, $language_codes, $deepl_auth, $language_names_deepl, $language_codes_deepl, $bing_auth, $language_names_bing, $language_codes_bing, $temp_list, $aiomatic_tax_names)
{
    if (!get_option('aiomatic_running_list')) {
        $running = array();
    } else {
        $running = get_option('aiomatic_running_list');
    }
    $GLOBALS['wp_object_cache']->delete('aiomatic_omni_list', 'options');
    $rules  = get_option('aiomatic_omni_list');
    if(!is_array($rules))
    {
        $rules = array();
    }
    $output = '';
    $cont   = 0;
    if (!empty($rules)) {
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
                    if(isset($exp[0]) && isset($exp[1]) && $exp[0] == '5')
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
        foreach ($rules as $request => $bundle[]) 
        {
            $reg_css_code = '#aiomatic_sortable_cards' . esc_html($cont) . ' {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }';
            $name = md5(get_bloginfo());
            wp_add_inline_style( $name . '-automation', $reg_css_code );
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
            $main_keywords          = $array_my_values[4];
            $title_once             = $array_my_values[5];
            $rule_description       = $array_my_values[6];
            $rule_unique_id         = $array_my_values[7];
            $sortable_cards         = $array_my_values[8];
            $more_keywords          = $array_my_values[9];
            $days_no_run            = $array_my_values[10];
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
            wp_add_inline_script($name . '-footer-script', 'autoCreateAdmin(' . esc_html($cont) . ');createAdmin(' . esc_html($cont) . ');createModeSelect(' . esc_html($cont) . ');hideLinks(' . esc_html($cont) . ');', 'after');
            $output .= '<tr>
                        <td class="cr_short_td"><input type="text" name="aiomatic_omni_list[rule_description][]" id="rule_description' . esc_html($cont) . '" class="cr_center" placeholder="Rule ID" value="' . esc_html($rule_description) . '" class="cr_width_full"/></td>
                        <td class="cr_loi"><textarea rows="1" name="aiomatic_omni_list[main_keywords][]" placeholder="Main keywords" class="cr_width_full">' . esc_textarea($main_keywords) . '</textarea></td>
                        <td class="cr_comm_td"><input type="number" step="1" min="1" placeholder="# h" name="aiomatic_omni_list[schedule][]" max="8765812" value="' . esc_attr($schedule) . '" class="cr_width_60" required></td>
                        <td class="cr_comm_td"><input type="number" step="1" min="0" placeholder="#" name="aiomatic_omni_list[max][]" value="' . esc_attr($max) . '"  class="cr_width_60" required></td>
                    <td class="cr_width_70 cr_center">
                    <input type="button" id="mybtnauto' . esc_html($cont) . '" value="Configure">
                    <div id="mymodalauto' . esc_html($cont) . '" class="codemodalauto">
    <div class="codemodalauto-content">
    <div class="codemodalauto-header">
        <span id="aiomatic_auto_close' . esc_html($cont) . '" class="codecloseauto">&times;</span>
        <h2>' . esc_html__('Rule', 'aiomatic-automatic-ai-content-writer') . ' <span class="cr_color_white">ID ' . esc_html($cont) . '</span> - ' . esc_html__('AI OmniBlocks', 'aiomatic-automatic-ai-content-writer') . '</h2>
    </div>
    <div class="codemodalauto-body">
    <div class="table-responsive">
        <table class="aiomatic-automation responsive table cr_main_table_nowr">
        <tbody class="aiomatic-tbody-automation">';
    $warning = '';
    $saved_cards = htmlspecialchars_decode($sortable_cards);
    $saved_cards = json_decode($saved_cards, true);
    if(is_array($saved_cards) && !empty($saved_cards))
    {
        $save_type_found = false;
        $zindex = 1;
        $num_cards = count($saved_cards);
        foreach ($saved_cards as $card_id) 
        {
            $card_type_found = array();
            foreach($default_block_types as $def_card)
            {
                if($card_id['type'] == $def_card['id'])
                {
                    $card_type_found = $def_card;
                    break;
                }
            }
            if(empty($card_type_found))
            {
                $warning .= '<p>' . esc_html__('OmniBlock type not found: ', 'aiomatic-automatic-ai-content-writer') . $card_id['type'] . '</p>';
            }
            if(isset($card_type_found['type']) && $card_type_found['type'] == 'save')
            {
                $save_type_found = true;
            }
            if($zindex == $num_cards)
            {
                if(isset($card_type_found['type']) && $card_type_found['type'] != 'save')
                {
                    if (isset($active) && $active === '1') 
                    {
                        $warning .= '<p>' . esc_html__('Last OmniBlock is not a "Action" type block! In automatic runs, all data created after the last "Action" type block will be lost.', 'aiomatic-automatic-ai-content-writer') . '</p>';
                    }
                }
            }
            $zindex++;
            if(isset($card_type_found['type']) && $card_type_found['type'] == 'create' )
            {
                if(isset($card_type_found['shortcodes']) && !empty($card_type_found['shortcodes']))
                {
                    $local_shortcodes = array();
                    foreach($card_type_found['shortcodes'] as $shtc)
                    {
                        $local_shortcodes[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                    }
                    if($shtc == 'file_')
                    {
                        $local_shortcodes[] = '%%xlsx_' . $card_id['identifier'] . '_';
                    }
                    if($shtc == 'webhook_data_')
                    {
                        $local_shortcodes[] = '%%webhook_data_' . $card_id['identifier'] . '_';
                    }
                    $not_found_blocks = array();
                    $block_found = false;
                    foreach ($saved_cards as $saved_card_id) 
                    {
                        foreach($saved_card_id['parameters'] as $name => $orig_text)
                        {
                            if(!empty($orig_text))
                            {
                                foreach($local_shortcodes as $lsc)
                                {
                                    if(strstr($orig_text, $lsc) !== false)
                                    {
                                        $block_found = true;
                                        break;
                                    }
                                }
                                if($block_found == true)
                                {
                                    break;
                                }
                            }
                        }
                        if($block_found == true)
                        {
                            break;
                        }
                    }
                    if($block_found === false)
                    {
                        $not_found_blocks[] = $card_id['identifier'];
                    }
                    if(!empty($not_found_blocks))
                    {
                        if (isset($active) && $active === '1') 
                        {
                            $warning .= '<p>' . esc_html__('The following OmniBlock IDs are not used in the queue (you can remove them): ', 'aiomatic-automatic-ai-content-writer') . implode(',', $not_found_blocks) . '</p>';
                        }
                    }
                }
            }
        }
        if($save_type_found === false)
        {
            if (isset($active) && $active === '1') 
            {
                $warning .= '<p>' . esc_html__('No "Action" type OmniBlock added in the queue! Add a "Action" type OmniBlock, like: "Save Posts" to store the data which was created by the AI. Otherwise, it will be lost.', 'aiomatic-automatic-ai-content-writer') . '</p>';
            }
        }
    }
    else
    {
        $warning .= '<p>' . esc_html__('Failed to decode OmniBlocks data!', 'aiomatic-automatic-ai-content-writer') . '</p>';
    }
    if($warning != '')
    {
        $output .= '<tr><td colspan="2"><h2>' . esc_html__('Block Validation Errors', 'aiomatic-automatic-ai-content-writer') . ':</h2></td></tr>
        <tr><td colspan="2" class="cr_red">' . $warning . '</td></tr>';
    }
    $output .= '<tr><td class="aiomatic_block_me" colspan="2"><h2>' . esc_html__('Manage AI OmniBlocks', 'aiomatic-automatic-ai-content-writer') . ':</h2><div class="aiseparator aistart"><b>' . esc_html__("OmniBlock Queue Starts Here", 'aiomatic-automatic-ai-content-writer') . '</b></div></td></tr>
    <tr>
    <td colspan="2">
    <input type="hidden" id="sortable_cards' . esc_html($cont) . '" name="aiomatic_omni_list[aiomatic_sortable_cards][]" value="' . esc_attr($sortable_cards) . '">
    <ul id="aiomatic_sortable_cards' . esc_html($cont) . '" name="aiomatic_sortable_cards' . esc_html($cont) . '">';
    $last_id = '1';
    if(empty($default_block_types))
    {
        $output .= esc_html__('No AI OmniBlock Types Added To This Rule', 'aiomatic-automatic-ai-content-writer');
    }
    else
    {
        
        if(empty($saved_cards) && !is_array($saved_cards))
        {
            $output .= esc_html__('Failed to decode saved blocks data!', 'aiomatic-automatic-ai-content-writer');
        }
        else
        {
            $exec = 1;
            $new_shortcodes_arr = array('%%keyword%%');
            foreach ($saved_cards as $card_id) 
            {
                $curr_arr = array();
                if(!empty($card_id['type']))
                {
                    $assistant_helper = uniqid();
                    $urlrandval = uniqid();
                    $last_id = $card_id['identifier'];
                    $card_type_found = array();
                    foreach($default_block_types as $def_card)
                    {
                        if($card_id['type'] == $def_card['id'])
                        {
                            $card_type_found = $def_card;
                            break;
                        }
                    }
                    if(empty($card_type_found))
                    {
                        aiomatic_log_to_file('Warning! OmniBlock type not found for: ' . print_r($card_id, true));
                    }
                    else
                    {
                        $local_shortcodes = array();
                        foreach($card_type_found['shortcodes'] as $shtc)
                        {
                            $local_shortcodes[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                        }
                        $plugin_required = array();
                        if(!empty($card_type_found['required_plugin']))
                        {
                            foreach($card_type_found['required_plugin'] as $pslug => $pname)
                            {
                                if(!function_exists('is_plugin_active'))
                                {
                                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                                }
                                if (!is_plugin_active($pslug)) 
                                {
                                    $plugin_required[] = 'You need enable the "' . $pname[0] . '" plugin for this OmniBlock type to work: ' . $pname[1];
                                }
                            }
                        }
                        $output .= '<li data-id-str="' . esc_html($cont) . '" class="omniblock-card"><input data-clone-index="xc' . uniqid() . '" class="cr_center aiomatic-bold aiomatic-indigo omniblock-title" card-type="' . esc_html($card_type_found['id']) . '" type="text" placeholder="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '"  title="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '" value="' . esc_attr($card_id['name']) . '">
                        <input type="hidden" class="omniblock-id" card-type="' . esc_html($card_type_found['id']) . '" value="' . esc_attr($last_id) . '">
                        <input type="hidden" class="omniblock-shortcodes" card-type="' . esc_html($card_type_found['id']) . '" value="' . esc_attr(implode(',', $local_shortcodes)) . '">';
                        if($card_type_found['id'] == 'text_spinner')
                        {
                            if (!isset($aiomatic_Main_Settings['spin_text']) || $aiomatic_Main_Settings['spin_text'] === 'disabled')
                            {
                                $plugin_required[] = 'Spinning disabled from \'Settings\' -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field, this OmniBlock will not function';
                            }
                            if (isset($aiomatic_Main_Settings['spin_what']) && $aiomatic_Main_Settings['spin_what'] === 'bulk') 
                            {
                                $plugin_required[] = 'Spinning disabled for OmniBlocks, from plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Enable Spinner For\' settings field, this OmniBlock will not function';
                            }
                        }
                        elseif($card_type_found['id'] == 'embeddings')
                        {
                            if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
                            {
                                $plugin_required[] = 'You must add an OpenAI/AiomaticAPI API Key into the plugin\'s \'Settings\' menu before you can use this feature!';
                            }
                            if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
                            {
                                $plugin_required[] = 'You must add a Pinecone API or a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                            }
                        }
                        foreach($card_id['parameters'] as $name => $orig_text)
                        {
                            if(isset($card_type_found['parameters'][$name]) && isset($card_type_found['parameters'][$name]['type']) && ($card_type_found['parameters'][$name]['type'] == 'text' || $card_type_found['parameters'][$name]['type'] == 'textarea' || $card_type_found['parameters'][$name]['type'] == 'url' || $card_type_found['parameters'][$name]['type'] == 'scraper_string'))
                            {
                                foreach($new_shortcodes_arr as $sha)
                                {
                                    $orig_text = str_replace($sha, '', $orig_text);
                                }
                                $incorrect_sh = array();
                                foreach($default_block_types as $cardt)
                                {
                                    foreach($cardt['shortcodes'] as $shc)
                                    {
                                        preg_match_all('~(%%' . $shc . '[a-zA-Z0-9]*?%%)~', $orig_text, $submatches);
                                        if(isset($submatches[1][0]))
                                        {
                                            foreach($submatches[1] as $incsh)
                                            {
                                                $incorrect_sh[] = $incsh;
                                            }
                                        }
                                    }
                                }
                                if(!empty($incorrect_sh))
                                {
                                    $plugin_required[] = 'This block has some incorrect shortcodes: ' . implode(',', $incorrect_sh);
                                }
                            }
                        }
                        if(!empty($plugin_required))
                        {
                            $output .= '<p class="requirement cr_red"><ul class="requirement cr_red">';
                            foreach($plugin_required as $pr)
                            {
                                $output .= '<li>' . $pr . '</li>';
                            }
                            $output .= '</ul></p>';
                        }
                        $output .= '<div class="card-name';
                        if($card_type_found['type'] == 'save')
                        {
                            $output .= ' aisave-content';
                        }
                        else
                        {
                            $output .= ' aicreate-content';
                        }
                        $output .= '">' . esc_html__('OmniBlock Type:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Created shortcodes by this OmniBlock (usable in OmniBlocks from below this one): ', 'aiomatic-automatic-ai-content-writer');
                        $output .= '<ul>';
                        foreach($card_type_found['shortcodes'] as $shtc)
                        {
                            $output .= '<li>%%' . $shtc . $card_id['identifier'] . '%%</li>';
                        }
                        $output .= '</ul>';
                        if (isset($aiomatic_Main_Settings['omni_webhook']) && trim($aiomatic_Main_Settings['omni_webhook']) == 'on')
                        {
                            $rest_url = rest_url('omniblock/v1/webhook');
                            if(isset($card_id['parameters']['api_key']) && !empty(trim($card_id['parameters']['api_key'])))
                            {
                                $rest_url = add_query_arg('apikey', trim($card_id['parameters']['api_key']), $rest_url);
                            }
                            $rest_url = add_query_arg('omniblockid', trim($cont) . '_' . trim($card_id['identifier']), $rest_url);
                            $rest_url = add_query_arg('input', urlencode('Webhooks in WordPress'), $rest_url);
                            $card_type_found['description'] = str_replace('%%webhook_url%%', '<br/><span class="cr_red disable_drag">' . $rest_url . '</span>', $card_type_found['description']);
                        }
                        else
                        {
                            $card_type_found['description'] = str_replace('%%webhook_url%%', '<span class="cr_red">' . esc_html__('OmniBlock Webhook functionality not enabled in \'Settings\' menu of the plugin!' , 'aiomatic-automatic-ai-content-writer') . '</span>', $card_type_found['description']);
                        }
                        $output .= '</div></div>&nbsp;' . esc_attr($card_type_found['name']) . '</div><p class="card-desc">' . $card_type_found['description'] . '</p><div class="ai-collapsible-holder"><button class="aicollapsible" title="' . esc_html__('Show/Hide Parameters', 'aiomatic-automatic-ai-content-writer') . '"><img class="controls-icon" src="' . plugin_dir_url( __FILE__ ) . '../images/controls.png' . '"></button></div><div class="aicollapsible-parameters">';
                        $output .= '<h3>' . esc_html__('OmniBlock Parameters', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Set the parameters which will be used in this OmniBlock.', 'aiomatic-automatic-ai-content-writer') . '</div></div></h3><hr/>';
                    
                        foreach($card_type_found['parameters'] as $name => $card_type)
                        {
                            $output .= '<h4>' . esc_html($card_type['title']) . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html($card_type['description']) . '</div></div></h4>';
                            if($card_type['type'] == 'text')
                            {
                                $randval = uniqid();
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                                $output .= '<input type="text" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                                if(count($new_shortcodes_arr) > 0)
                                {
                                    $output .= '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                                }
                                foreach($new_shortcodes_arr as $myshort)
                                {
                                    $my_id = explode('_', $myshort);
                                    $my_id = end($my_id);
                                    $my_id = substr($my_id, 0, -2);
                                    $output .=  '<p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                    $output .=  $myshort;
                                    $output .=  '</p>';
                                }
                                if(count($new_shortcodes_arr) > 0)
                                {
                                    $output .= '</div>';
                                }
                                $output .= '</div>';
                            }
                            elseif($card_type['type'] == 'textarea')
                            {
                                $randval = uniqid();
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                                $output .= '<textarea class="' . esc_attr($name) . ' cr_width_full" data-clone-index="xc' . uniqid() . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">' . esc_textarea($value) . '</textarea>';
                                if(count($new_shortcodes_arr) > 0)
                                {
                                    $output .= '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                                }
                                foreach($new_shortcodes_arr as $myshort)
                                {
                                    $my_id = explode('_', $myshort);
                                    $my_id = end($my_id);
                                    $my_id = substr($my_id, 0, -2);
                                    $output .=  '<p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                    $output .=  $myshort;
                                    $output .=  '</p>';
                                }
                                if($card_type_found['id'] == 'ai_text_foreach' && $name == 'prompt')
                                {
                                    $output .=  '<p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                    $output .=  '%%current_input_line%%';
                                    $output .=  '</p>';
                                    $output .=  '<p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                    $output .=  '%%current_input_line_counter%%';
                                    $output .=  '</p>';
                                    $output .=  '<p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                    $output .=  '%%all_input_lines%%';
                                    $output .=  '</p>';
                                }
                                if(count($new_shortcodes_arr) > 0)
                                {
                                    $output .= '</div>';
                                }
                                $output .= '</div>';
                            }
                            elseif($card_type['type'] == 'model_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" id="xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_models as $modelx)
                                {
                                    $output .= '<option value="' . $modelx .'"';
                                    if($value == $modelx)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'model_select_function')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" id="xa' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_models_function as $modelx)
                                {
                                    $output .= '<option value="' . $modelx .'"';
                                    if($value == $modelx)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'assistant_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="sel_xa' . $assistant_helper . '" onchange="assistantChanged(\'xa' . $assistant_helper . '\');" class="' . esc_attr($name) . ' cr_width_full">';
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
                                        if($value == '')
                                        {
                                            $output .= ' selected';
                                        }
                                        $output .= '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                        foreach($all_assistants as $myassistant)
                                        {
                                            $output .= '<option value="' . $myassistant->ID .'"';
                                            if($value == $myassistant->ID)
                                            {
                                                $output .= ' selected';
                                            }
                                            $output .= '>' . esc_html($myassistant->post_title);
                                            $output .= '</option>';
                                        }
                                    }
                                }
                                $output .= '</select>';
                                wp_add_inline_script(md5(get_bloginfo()) . '-footer-script', 'assistantChanged(\'xa' . $assistant_helper . '\');', 'after');
                            }
                            elseif($card_type['type'] == 'dalle_image_size_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_dalle_sizes as $sizeid => $sizex)
                                {
                                    $output .= '<option value="' . esc_attr($sizeid) .'"';
                                    if($value == $sizeid)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($sizex) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'stable_image_size_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_stable_sizes as $sizeid => $sizex)
                                {
                                    $output .= '<option value="' . esc_attr($sizeid) .'"';
                                    if($value == $sizeid)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($sizex) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'midjourney_image_size_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_midjourney_sizes as $sizeid => $sizex)
                                {
                                    $output .= '<option value="' . esc_attr($sizeid) .'"';
                                    if($value == $sizeid)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($sizex) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'stable_video_size_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_stable_video_sizes as $sizeid => $sizex)
                                {
                                    $output .= '<option value="' . esc_attr($sizeid) .'"';
                                    if($value == $sizeid)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($sizex) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'scraper_type')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="scraper_selector ' . esc_attr($name) . ' cr_width_full" data-id-str="' . esc_html($cont) . '" data-source-field-id="ur' . $urlrandval . '" data-target-field-id="' . $assistant_helper . '">';
                                foreach($all_scraper_types as $index => $modelx)
                                {
                                    $output .= '<option value="' . esc_attr($index) .'"';
                                    if($value == $index)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'scraper_string')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<input type="text" id="st' . $assistant_helper . '" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                            }
                            elseif($card_type['type'] == 'number')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<input type="number" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_html($value) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                            }
                            elseif($card_type['type'] == 'checkbox')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $output .= '<option value="0"';
                                if($value == '0')
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("No", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                $output .= '<option value="1"';
                                if($value == '1')
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Yes", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'dalle_image_model_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_dalle_models as $modelx)
                                {
                                    $output .= '<option value="' . $modelx .'"';
                                    if($value == $modelx)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'stable_image_model_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_stable_models as $modelx)
                                {
                                    $output .= '<option value="' . $modelx .'"';
                                    if($value == $modelx)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'status_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $output .= '<option value="publish"';
                                if($value == "publish")
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                                <option value="pending"';
                                if($value == "pending")
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                                <option value="draft"';
                                if($value == "draft")
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                                <option value="private"';
                                if($value == "private")
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                                <option value="trash"';
                                if($value == "trash")
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'type_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach(get_post_types( '', 'names' ) as $modelx)
                                {
                                    if(strstr($modelx, 'aiomatic_'))
                                    {
                                       continue;
                                    }
                                    $output .= '<option value="' . $modelx .'"';
                                    if($value == $modelx)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'amazon_country_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach(aiomatic_get_amazon_codes() as $key => $modelx)
                                {
                                    $output .= '<option value="' . $key .'"';
                                    if($value == $key)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'amazon_sort_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach(aiomatic_get_amazon_sorts() as $key => $modelx)
                                {
                                    $output .= '<option value="' . esc_attr($key) .'"';
                                    if($value == $key)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'yt_community_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $community_types = array('text' => 'Text', 'image' => 'Image');
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($community_types as $key => $modelx)
                                {
                                    $output .= '<option value="' . esc_attr($key) .'"';
                                    if($value == $key)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'reddit_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $reddit_types = array('auto' => 'Auto', 'link' => 'Link', 'self' => 'Text', 'image' => 'Image', 'video' => 'Video');
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($reddit_types as $key => $modelx)
                                {
                                    $output .= '<option value="' . esc_attr($key) .'"';
                                    if($value == $key)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'method_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $reddit_types = array('POST' => 'POST', 'GET' => 'GET', 'PUT' => 'PUT', 'DELETE' => 'DELETE');
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($reddit_types as $key => $modelx)
                                {
                                    $output .= '<option value="' . esc_attr($key) .'"';
                                    if($value == $key)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'content_type_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $reddit_types = array('JSON' => 'JSON', 'form' => 'Form Data');
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($reddit_types as $key => $modelx)
                                {
                                    $output .= '<option value="' . esc_attr($key) .'"';
                                    if($value == $key)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($modelx) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'facebook_page_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
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
                                        if($exploding[0] == $value)
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
                            }
                            elseif($card_type['type'] == 'location_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $locations = array('local' => 'local');
                                if(!function_exists('is_plugin_active'))
                                {
                                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                                }
                                if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                                {
                                    $locations['amazon'] = 'Amazon S3';
                                    $locations['wasabi'] = 'Wasabi';
                                    $locations['cloudflare'] = 'CloudFlare';
                                    $locations['digital'] = 'Digital Ocean';
                                }
                                foreach($locations as $id => $name)
                                {
                                    $output .= '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        $output .= " selected";
                                    }
                                    $output .= '>' . ucfirst(esc_html($name)) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $values = $card_type['values'];
                                foreach($values as $id => $name)
                                {
                                    $output .= '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        $output .= " selected";
                                    }
                                    $output .= '>' . esc_html($name) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'file_type_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $locations = array('txt' => 'txt', 'html' => 'html', 'doc' => 'doc', 'pdf' => 'pdf');
                                if(!function_exists('is_plugin_active'))
                                {
                                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                                }
                                foreach($locations as $id => $name)
                                {
                                    $output .= '<option value="' . esc_html($id) . '"';
                                    if($id == $value)
                                    {
                                        $output .= " selected";
                                    }
                                    if ($id == 'pdf' && !is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
                                    {
                                        $output .= " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
                                    }
                                    $output .= '>' . esc_html($name) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'file_selector')
                            {
                                if(empty($_GLOBALS['omni_files']))
                                {
                                    $_GLOBALS['omni_files'] = get_posts([
                                        'post_type' => 'aiomatic_omni_file',
                                        'post_status' => 'publish',
                                        'numberposts' => -1
                                    ]);
                                }
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                if(empty($_GLOBALS['omni_files']))
                                {
                                    $output .= '<option disabled selected>' . esc_html__('No files added, add new files in the \'OmniBlock Files\' tab', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                }
                                else
                                {
                                    $output .= '<option value="random"';
                                    if('random' == $value)
                                    {
                                        $output .= " selected";
                                    }
                                    $output .= '>' . esc_html__('Random', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                    $output .= '<option value="latest"';
                                    if('latest' == $value)
                                    {
                                        $output .= " selected";
                                    }
                                    $output .= '>' . esc_html__('Latest', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                }
                                foreach($_GLOBALS['omni_files'] as $id => $name)
                                {
                                    $output .= '<option value="' . esc_html($name->ID) . '"';
                                    if($name->ID == $value)
                                    {
                                        $output .= " selected";
                                    }
                                    $output .= '>' . esc_html($name->post_title) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'pinterest_board_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $boards = get_option('pinterestomatic_public_boards', false);
                                if($boards !== FALSE)
                                {
                                    foreach($boards as $id => $name)
                                    {
                                        $output .= '<option value="' . esc_html($id) . '"';
                                        if($id == $value)
                                        {
                                            $output .= " selected";
                                        }
                                        $output .= '>' . esc_html($name) . '</option>';
                                    }
                                }
                                else
                                {
                                    $output .= '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'gpb_page_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $boards = get_option('businessomatic_my_business_list', false);
                                if($boards !== FALSE)
                                {
                                    foreach($boards as $id => $name)
                                    {
                                        $output .= '<option value="' . esc_html($id) . '"';
                                        if($id == $value)
                                        {
                                            $output .= " selected";
                                        }
                                        $output .= '>' . esc_html($name) . '</option>';
                                    }
                                }
                                else
                                {
                                    $output .= '<option disabled value="">' . esc_html__('You need to set up the Businessomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'linkedin_page_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $companies = get_option('linkedinomatic_my_companies', array());
                                if(is_array($companies) && count($companies) > 0)
                                {
                                    foreach($companies as $cmp_id => $cmp_name)
                                    {
                                        if($cmp_name == 'Profile Page')
                                        {
                                            $output .= '<option value="' . esc_attr($cmp_id) . '"';
                                            if($cmp_id == $value)
                                            {
                                                $output .= ' selected';
                                            }
                                            $output .= '>' . esc_html($cmp_name) . '</option>';
                                        }
                                        else
                                        {
                                            $output .= '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                            if('xxxLinkedinomaticxxx' . $cmp_id == $value)
                                            {
                                                $output .= ' selected';
                                            }
                                            $output .= '>' . esc_html($cmp_name) . '</option>';
                                        }
                                    }
                                }
                                else
                                {
                                    $output .= '<option disabled value="">' . esc_html__('You need to set up the Linkedinomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'language_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                $i = 0;
                                foreach ($language_names as $lang) {
                                    $output .= '<option value="' . esc_html($language_codes[$i]) . '"';
                                    if ($value == $language_codes[$i]) {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($language_names[$i]) . '</option>';
                                    $i++;
                                }
                                if($deepl_auth != '')
                                {
                                    $i = 0;
                                    foreach ($language_names_deepl as $lang) {
                                        $output .= '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                                        if ($value == $language_codes_deepl[$i]) {
                                            $output .= ' selected';
                                        }
                                        $output .= '>' . esc_html($language_names_deepl[$i]) . '</option>';
                                        $i++;
                                    }
                                }
                                if($bing_auth != '')
                                {
                                    $i = 0;
                                    foreach ($language_names_bing as $lang) {
                                        $output .= '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                                        if ($value == $language_codes_bing[$i]) {
                                            $output .= ' selected';
                                        }
                                        $output .= '>' . esc_html($language_names_bing[$i]) . '</option>';
                                        $i++;
                                    }
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'format_selector')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                                foreach($all_formats as $modelx => $namex)
                                {
                                    $output .= '<option value="' . $modelx .'"';
                                    if($value == $modelx)
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($namex) . '</option>';
                                }
                                $output .= '</select>';
                            }
                            elseif($card_type['type'] == 'url')
                            {
                                $randval = uniqid();
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                                $output .= '<input type="url" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' ur' . esc_attr($urlrandval) . ' cr_width_full" value="' . esc_html($value) . '" id="xai' . $randval . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                                if(count($new_shortcodes_arr) > 0)
                                {
                                    $output .= '<div class="shortcode-list" data-id-str="xai' . $randval . '">';
                                }
                                foreach($new_shortcodes_arr as $myshort)
                                {
                                    $my_id = explode('_', $myshort);
                                    $my_id = end($my_id);
                                    $my_id = substr($my_id, 0, -2);
                                    $output .=  '<p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Shortcode created by OmniBlock ID: ', 'aiomatic-automatic-ai-content-writer') . $my_id . '">';
                                    $output .=  $myshort;
                                    $output .=  '</p>';
                                }
                                if(count($new_shortcodes_arr) > 0)
                                {
                                    $output .= '</div>';
                                }
                                $output .= '</div>';
                            }
                            elseif($card_type['type'] == 'scraper_select')
                            {
                                $value = '';
                                if(isset($card_id['parameters'][$name]))
                                {
                                    $value = $card_id['parameters'][$name];
                                }
                                $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="sc' . $assistant_helper . '" class="' . esc_attr($name) . '" class="cr_width_full">';
                                $output .= '<option value="0"';
                                if($value == '0')
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                $output .= '<option value="1"';
                                if($value == '1')
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';         
                                $output .= '<option value="2"';
                                if($value == '2')
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                $output .= '<option value="3"';
                                if($value == '3')
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                $output .= '<option value="4"';
                                if($value == '4')
                                {
                                    $output .= ' selected';
                                }
                                if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                                {
                                    $output .= ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                                }
                                $output .= '>' . esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                                if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                                {
                                    $output .= esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                                }
                                $output .= '</option>';
                                $output .= '<option value="5"';
                                if($value == '5')
                                {
                                    $output .= ' selected';
                                }
                                if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                                {
                                    $output .= ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                                }
                                $output .= '>' . esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                                if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                                {
                                    $output .= esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                                }
                                $output .= '</option>';
                                $output .= '<option value="6"';
                                if($value == '6')
                                {
                                    $output .= ' selected';
                                }
                                if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                                {
                                    $output .= ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                                }
                                $output .= '>';
                                $output .= esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                                if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                                {
                                    $output .= esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                                }
                                $output .= '</option>';
                                $output .= '</select>';
                            }
                        }
                        $critical = false;
                        if(isset($card_id['parameters']['critical']) && $card_id['parameters']['critical'] == '1')
                        {
                            $critical = true;
                        }
                        $output .= '<h4>' . esc_html__("Critical", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is critical or not. When a Critical OmniBlock fails to generate its content correctly and it fails, it will cause the entire OmniBlock running sequence to stop. Non-critical OmniBlocks when they fail, the execution of blocks will continue, the result of the failed OmniBlock will be blank.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                        $output .= '&nbsp;<input type="checkbox" class="critical-blocks" data-clone-index="xc' . uniqid() . '" id="critical-' . esc_attr($last_id) . '"';
                        if($critical == true)
                        {
                            $output .= ' checked';
                        }
                        $output .= '>';
                        $output .= '</h4>';
                        $disabled = false;
                        if(isset($card_id['parameters']['disabled']) && $card_id['parameters']['disabled'] == '1')
                        {
                            $disabled = true;
                        }
                        $output .= '<h4>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is disabled or not. The disabled OmniBlocks will be skipped from processing.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                        $output .= '&nbsp;<input type="checkbox" class="disabled-blocks" data-clone-index="xc' . uniqid() . '" id="disabled-' . esc_attr($last_id) . '"';
                        if($disabled == true)
                        {
                            $output .= ' checked';
                        }
                        $output .= '>';
                        $output .= '</h4>';
                        foreach($card_type_found['shortcodes'] as $shtc)
                        {
                            $new_shortcodes_arr[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                            $curr_arr[] = '%%' . $shtc . $card_id['identifier'] . '%%';
                        }
                        $output .= '</div>
                        <button class="move-up-btn" title="Move Up">
        <!-- SVG for move up -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0L12 8.292a.5.5 0 0 1-.708.708L8 5.707V12.5a.5.5 0 0 1-1 0V5.707L4.707 9a.5.5 0 1 1-.708-.708l3.647-3.646z"/>
    </svg>
    </button>
    <button class="move-down-btn" title="Move Down">
        <!-- SVG for move down -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1-.708 0L3.293 7.707a.5.5 0 1 1 .708-.708L7 10.293V3.5a.5.5 0 0 1 1 0v6.793l2.999-3.294a.5.5 0 0 1 .708.708l-4 4.147z"/>
    </svg>
    </button>
                        <button class="delete-btn" title="' . esc_html__('Delete', 'aiomatic-automatic-ai-content-writer') . '">X</button><div class="ai_common_holder"><div class="step-number">' . esc_html__("Step", 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($exec) . '</div><div class="aiomatic-run-now';
                        if($card_type_found['type'] == 'save')
                        {
                            $output .= ' aisave-content';
                        }
                        else
                        {
                            $output .= ' aicreate-content';
                        }
                        $output .= '" data-cont="' . esc_html($cont) . '" data-shtc="' . implode(',', $curr_arr) . '" data-lastid="' . esc_html($last_id) . '">' . esc_html__("Run Now", 'aiomatic-automatic-ai-content-writer') . '</div><div class="id-shower">' . esc_html__("ID:", 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($card_id['identifier']) . '</div></div></li>';
                        $exec++;
                    }
                }
            }
        }
    }
    $output .= '</ul>
</td>
</tr>
<tr>
<td colspan="2"><div class="aiseparator aistop"><b>' . esc_html__("OmniBlock Queue Stops Here", 'aiomatic-automatic-ai-content-writer') . '</b></div><h2>' . esc_html__('Add A New OmniBlock To The Above Queue (Drag And Drop):', 'aiomatic-automatic-ai-content-writer') . '</h2>';
    $output .= '<ul id="aiomatic_new_card_types' . esc_html($cont) . '" name="aiomatic_new_card_types">';
    if(empty($default_block_types))
    {
        $output .= esc_html__('No AI OmniBlock Types Defined!', 'aiomatic-automatic-ai-content-writer');
    }
    else
    {
        $first = true;
        $save_id = $last_id;
        foreach ($default_block_types as $card_id) 
        {
            if(!empty($card_id['type']))
            {
                $assistant_helper = uniqid();
                $urlrandval = uniqid();
                aiomatic_increment($save_id);
                $local_shortcodes = array();
                foreach($card_id['shortcodes'] as $shtc)
                {
                    $local_shortcodes[] = '%%' . $shtc . $save_id . '%%';
                }
                $output .= '<li data-id-str="' . esc_html($cont) . '" class="omniblock-card new-card';
                if($first != true)
                {
                    $output .= ' cr_none';
                }
                $plugin_required = array();
                if(!empty($card_id['required_plugin']))
                {
                    foreach($card_id['required_plugin'] as $pslug => $pname)
                    {
                        if(!function_exists('is_plugin_active'))
                        {
                            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                        }
                        if (!is_plugin_active($pslug)) 
                        {
                            $plugin_required[] = 'You need enable the "' . $pname[0] . '" plugin for this OmniBlock type to work: ' . $pname[1];
                        }
                    }
                }
                $output .= '" id="' . sanitize_title($card_id['name']) . esc_html($cont) . '"><input data-clone-index="xc' . uniqid() . '" class="cr_center aiomatic-bold aiomatic-indigo omniblock-title" card-type="' . esc_html($card_id['id']) . '" type="text" placeholder="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '"  title="' . esc_html__('OmniBlock Title', 'aiomatic-automatic-ai-content-writer') . '" value="' . esc_attr($card_id['name']) . '">
                <input type="hidden" class="omniblock-id" card-type="' . esc_html($card_id['id']) . '" value="' . esc_attr($save_id) . '">
                <input type="hidden" class="omniblock-shortcodes" card-type="' . esc_html($card_id['id']) . '" value="' . esc_attr(implode(',', $local_shortcodes)) . '">';
                if($card_id['id'] == 'text_spinner')
                {
                    if (!isset($aiomatic_Main_Settings['spin_text']) || $aiomatic_Main_Settings['spin_text'] === 'disabled')
                    {
                        $plugin_required[] = 'Spinning disabled from \'Settings\' -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field, this OmniBlock will not function';
                    }
                    if (isset($aiomatic_Main_Settings['spin_what']) && $aiomatic_Main_Settings['spin_what'] === 'bulk') 
                    {
                        $plugin_required[] = 'Spinning disabled for OmniBlocks, from plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Enable Spinner For\' settings field, this OmniBlock will not function';
                    }
                }
                elseif($card_id['id'] == 'embeddings')
                {
                    if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
                    {
                        $plugin_required[] = 'You must add an OpenAI/AiomaticAPI API Key into the plugin\'s \'Settings\' menu before you can use this feature!';
                    }
                    if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
                    {
                        $plugin_required[] = 'You must add a Pinecone API or a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                    }
                }
                if(!empty($plugin_required))
                {
                    $output .= '<p class="requirement cr_red"><ul class="requirement cr_red">';
                    foreach($plugin_required as $pr)
                    {
                        $output .= '<li>' . $pr . '</li>';
                    }
                    $output .= '</ul></p>';
                }
                $output .= '<div class="card-name';
                if($card_id['type'] == 'save')
                {
                    $output .= ' aisave-content';
                }
                else
                {
                    $output .= ' aicreate-content';
                }
                if (isset($aiomatic_Main_Settings['omni_webhook']) && trim($aiomatic_Main_Settings['omni_webhook']) == 'on')
                {
                    $card_id['description'] = str_replace('%%webhook_url%%', esc_html__('add this OmniBlock and save settings to get the URL' , 'aiomatic-automatic-ai-content-writer'), $card_id['description']);
                }
                else
                {
                    $card_id['description'] = str_replace('%%webhook_url%%', '<span class="cr_red">' . esc_html__('OmniBlock Webhook functionality not enabled in \'Settings\' menu of the plugin!' , 'aiomatic-automatic-ai-content-writer') . '</span>', $card_id['description']);
                }
                $output .= '">' . esc_html__('OmniBlock Type:', 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . esc_attr($card_id['name']) . '</div><p class="card-desc">' . $card_id['description'] . '</p><div class="ai-collapsible-holder"><button class="aicollapsible" title="' . esc_html__('Show/Hide Parameters', 'aiomatic-automatic-ai-content-writer') . '"><img class="controls-icon" src="' . plugin_dir_url( __FILE__ ) . '../images/controls.png' . '"></button></div><div class="aicollapsible-parameters">';
                $output .= '<h3>' . esc_html__('OmniBlock Parameters', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__('Set the parameters which will be used in this OmniBlock.', 'aiomatic-automatic-ai-content-writer') . '</div></div></h3><hr/>';
                $first = false;
                foreach($card_id['parameters'] as $name => $card_type)
                {
                    $output .= '<h4>' . esc_html($card_type['title']) . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html($card_type['description']) . '</div></div></h4>';   
                    if($card_type['type'] == 'text')
                    {
                        $randval = uniqid();
                        $output .= '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                        $output .= '<input type="text" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '" id="xai' . $randval . '">';
                        $output .= '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p></div>';
                        $output .= '</div>';
                        
                    }
                    elseif($card_type['type'] == 'textarea')
                    {
                        $randval = uniqid();
                        $additional = '';
                        if($name == 'prompt' && $card_id['id'] == 'ai_text_foreach')
                        {
                            $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%current_input_line_counter%%</p>';
                            $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%current_input_line%%</p>';
                            $additional .= '<p class="aishortcodes" data-index="" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%all_input_lines%%</p>';
                        }
                        $output .= '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                        $output .= '<textarea data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" placeholder="' . esc_html($card_type['placeholder']) . '" id="xai' . $randval . '">' . esc_textarea($card_type['default_value']) . '</textarea>';
                        $output .= '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p>' . $additional . '</div>';
                        $output .= '</div>';
                    }
                    elseif($card_type['type'] == 'model_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="xa' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_models as $modelx)
                        {
                            $output .= '<option value="' . $modelx .'"';
                            if($modelx == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'model_select_function')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="xa' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_models_function as $modelx)
                        {
                            $output .= '<option value="' . $modelx .'"';
                            if($modelx == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . esc_html(aiomatic_get_model_provider($modelx)) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'assistant_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="sel_xa' . $assistant_helper . '" onchange="assistantChanged(\'xa' . $assistant_helper . '\');" class="' . esc_attr($name) . ' cr_width_full">';
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
                                if('' == $card_type['default_value'])
                                {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
                                foreach($all_assistants as $myassistant)
                                {
                                    $output .= '<option value="' . $myassistant->ID .'"';
                                    if($myassistant->ID == $card_type['default_value'])
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($myassistant->post_title);
                                    $output .= '</option>';
                                }
                            }
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'dalle_image_size_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_dalle_sizes as $sizeid => $sizex)
                        {
                            $output .= '<option value="' . esc_attr($sizeid) .'"';
                            if($sizeid == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($sizex) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'stable_image_size_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_stable_sizes as $sizeid => $sizex)
                        {
                            $output .= '<option value="' . esc_attr($sizeid) .'"';
                            if($sizeid == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($sizex) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'midjourney_image_size_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_midjourney_sizes as $sizeid => $sizex)
                        {
                            $output .= '<option value="' . esc_attr($sizeid) .'"';
                            if($sizeid == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($sizex) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'stable_video_size_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_stable_video_sizes as $sizeid => $sizex)
                        {
                            $output .= '<option value="' . esc_attr($sizeid) .'"';
                            if($sizeid == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($sizex) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'scraper_type')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="scraper_selector ' . esc_attr($name) . ' cr_width_full" data-id-str="' . esc_html($cont) . '" data-source-field-id="ur' . $urlrandval . '" data-target-field-id="' . $assistant_helper . '">';
                        foreach($all_scraper_types as $index => $modelx)
                        {
                            $output .= '<option value="' . esc_attr($index) .'"';
                            if($index == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'scraper_string')
                    {
                        $output .= '<input type="text" data-clone-index="xc' . uniqid() . '" id="st' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                    }
                    elseif($card_type['type'] == 'number')
                    {
                        $output .= '<input type="number" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '">';
                    }
                    elseif($card_type['type'] == 'checkbox')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $output .= '<option value="0"';
                        if('0' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("No", 'aiomatic-automatic-ai-content-writer') . '</option>';
                        $output .= '<option value="1"';
                        if('1' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Yes", 'aiomatic-automatic-ai-content-writer') . '</option>';
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'dalle_image_model_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_dalle_models as $modelx)
                        {
                            $output .= '<option value="' . $modelx .'"';
                            if($modelx == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'stable_image_model_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_stable_models as $modelx)
                        {
                            $output .= '<option value="' . $modelx .'"';
                            if($modelx == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'status_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $output .= '<option value="publish"';
                        if("publish" == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Published", 'aiomatic-automatic-ai-content-writer') . '</option>
                        <option value="pending"';
                        if("pending" == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Pending -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                        <option value="draft"';
                        if("draft" == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Draft -> Moderate", 'aiomatic-automatic-ai-content-writer') . '</option>
                        <option value="private"';
                        if("private" == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Private", 'aiomatic-automatic-ai-content-writer') . '</option>
                        <option value="trash"';
                        if("trash" == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Trash", 'aiomatic-automatic-ai-content-writer') . '</option>';
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'type_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach(get_post_types( '', 'names' ) as $modelx)
                        {
                            if(strstr($modelx, 'aiomatic_'))
                            {
                               continue;
                            }
                            $output .= '<option value="' . $modelx .'"';
                            if($modelx == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'format_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($all_formats as $modelx => $namex)
                        {
                            if(strstr($modelx, 'aiomatic_'))
                            {
                               continue;
                            }
                            $output .= '<option value="' . $modelx .'"';
                            if($modelx == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($namex) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'amazon_country_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach(aiomatic_get_amazon_codes() as $key => $modelx)
                        {
                            $output .= '<option value="' . $key .'"';
                            if($key == $card_type['default_value'])
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'amazon_sort_select')
                    {
                        $value = '';
                        if(isset($card_id['parameters'][$name]))
                        {
                            $value = $card_id['parameters'][$name];
                        }
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach(aiomatic_get_amazon_sorts() as $key => $modelx)
                        {
                            $output .= '<option value="' . esc_attr($key) .'"';
                            if($value == $key)
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'yt_community_selector')
                    {
                        $community_types = array('text' => 'Text', 'image' => 'Image');
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($community_types as $key => $modelx)
                        {
                            $output .= '<option value="' . esc_attr($key) .'"';
                            if($card_type['default_value'] == $key)
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'reddit_selector')
                    {
                        $reddit_types = array('auto' => 'Auto', 'link' => 'Link', 'self' => 'Text', 'image' => 'Image', 'video' => 'Video');
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($reddit_types as $key => $modelx)
                        {
                            $output .= '<option value="' . esc_attr($key) .'"';
                            if($card_type['default_value'] == $key)
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'method_selector')
                    {
                        $reddit_types = array('POST' => 'POST', 'GET' => 'GET', 'PUT' => 'PUT', 'DELETE' => 'DELETE');
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($reddit_types as $key => $modelx)
                        {
                            $output .= '<option value="' . esc_attr($key) .'"';
                            if($card_type['default_value'] == $key)
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'content_type_selector')
                    {
                        $reddit_types = array('JSON' => 'JSON', 'form' => 'Form Data');
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        foreach($reddit_types as $key => $modelx)
                        {
                            $output .= '<option value="' . esc_attr($key) .'"';
                            if($card_type['default_value'] == $key)
                            {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($modelx) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'facebook_page_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
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
                                if($exploding[0] == $card_type['default_value'])
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
                    }
                    elseif($card_type['type'] == 'location_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $locations = array('local' => 'local');
                        if(!function_exists('is_plugin_active'))
                        {
                            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                        }
                        if (is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                        {
                            $locations['amazon'] = 'Amazon S3';
                            $locations['wasabi'] = 'Wasabi';
                            $locations['cloudflare'] = 'CloudFlare';
                            $locations['digital'] = 'Digital Ocean';
                        }
                        foreach($locations as $id => $name)
                        {
                            $output .= '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                $output .= " selected";
                            }
                            $output .= '>' . ucfirst(esc_html($name)) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $values = $card_type['values'];
                        foreach($values as $id => $name)
                        {
                            $output .= '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                $output .= " selected";
                            }
                            $output .= '>' . esc_html($name) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'file_type_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $locations = array('txt' => 'txt', 'html' => 'html', 'doc' => 'doc', 'pdf' => 'pdf');
                        if(!function_exists('is_plugin_active'))
                        {
                            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                        }
                        foreach($locations as $id => $name)
                        {
                            $output .= '<option value="' . esc_html($id) . '"';
                            if($id == $card_type['default_value'])
                            {
                                $output .= " selected";
                            }
                            if ($id == 'pdf' && !is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
                            {
                                $output .= " disabled title='This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active'";
                            }
                            $output .= '>' . esc_html($name) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'file_selector')
                    {
                        if(empty($_GLOBALS['omni_files']))
                        {
                            $_GLOBALS['omni_files'] = get_posts([
                                'post_type' => 'aiomatic_omni_file',
                                'post_status' => 'publish',
                                'numberposts' => -1
                            ]);
                        }
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        if(empty($_GLOBALS['omni_files']))
                        {
                            $output .= '<option disabled selected>' . esc_html__('No files added, add new files in the \'OmniBlock Files\' tab', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        }
                        else
                        {
                            $output .= '<option value="random"';
                            if('random' == $card_type['default_value'])
                            {
                                $output .= " selected";
                            }
                            $output .= '>' . esc_html__('Random', 'aiomatic-automatic-ai-content-writer') . '</option>';
                            $output .= '<option value="latest"';
                            if('latest' == $card_type['default_value'])
                            {
                                $output .= " selected";
                            }
                            $output .= '>' . esc_html__('Latest', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        }
                        foreach($_GLOBALS['omni_files'] as $id => $name)
                        {
                            $output .= '<option value="' . esc_html($name->ID) . '"';
                            if($name->ID == $card_type['default_value'])
                            {
                                $output .= " selected";
                            }
                            $output .= '>' . esc_html($name->post_title) . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'pinterest_board_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $boards = get_option('pinterestomatic_public_boards', false);
                        if($boards !== FALSE)
                        {
                            foreach($boards as $id => $name)
                            {
                                $output .= '<option value="' . esc_html($id) . '"';
                                if($id == $card_type['default_value'])
                                {
                                    $output .= " selected";
                                }
                                $output .= '>' . esc_html($name) . '</option>';
                            }
                        }
                        else
                        {
                            $output .= '<option disabled value="">' . esc_html__('You need to set up the Pinterestomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'gpb_page_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $boards = get_option('businessomatic_my_business_list', false);
                        if($boards !== FALSE)
                        {
                            foreach($boards as $id => $name)
                            {
                                $output .= '<option value="' . esc_html($id) . '"';
                                if($id == $card_type['default_value'])
                                {
                                    $output .= " selected";
                                }
                                $output .= '>' . esc_html($name) . '</option>';
                            }
                        }
                        else
                        {
                            $output .= '<option disabled value="">' . esc_html__('You need to set up the Businessomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'linkedin_page_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $companies = get_option('linkedinomatic_my_companies', array());
                        if(is_array($companies) && count($companies) > 0)
                        {
                            foreach($companies as $cmp_id => $cmp_name)
                            {
                                if($cmp_name == 'Profile Page')
                                {
                                    $output .= '<option value="' . esc_attr($cmp_id) . '"';
                                    if($cmp_id == $card_type['default_value'])
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($cmp_name) . '</option>';
                                }
                                else
                                {
                                    $output .= '<option value="xxxLinkedinomaticxxx' . esc_attr($cmp_id) . '"';
                                    if('xxxLinkedinomaticxxx' . $cmp_id == $card_type['default_value'])
                                    {
                                        $output .= ' selected';
                                    }
                                    $output .= '>' . esc_html($cmp_name) . '</option>';
                                }
                            }
                        }
                        else
                        {
                            $output .= '<option disabled value="">' . esc_html__('You need to set up the Linkedinomatic plugin before using this feature!', 'aiomatic-automatic-ai-content-writer') . '</option>';
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'language_selector')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $i = 0;
                        foreach ($language_names as $lang) {
                            $output .= '<option value="' . esc_html($language_codes[$i]) . '"';
                            if ($card_type['default_value'] == $language_codes[$i]) {
                                $output .= ' selected';
                            }
                            $output .= '>' . esc_html($language_names[$i]) . '</option>';
                            $i++;
                        }
                        if($deepl_auth != '')
                        {
                            $i = 0;
                            foreach ($language_names_deepl as $lang) {
                                $output .= '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                                if ($card_type['default_value'] == $language_codes_deepl[$i]) {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html($language_names_deepl[$i]) . '</option>';
                                $i++;
                            }
                        }
                        if($bing_auth != '')
                        {
                            $i = 0;
                            foreach ($language_names_bing as $lang) {
                                $output .= '<option value="' . esc_html($language_codes_bing[$i]) . '"';
                                if ($card_type['default_value'] == $language_codes_bing[$i]) {
                                    $output .= ' selected';
                                }
                                $output .= '>' . esc_html($language_names_bing[$i]) . '</option>';
                                $i++;
                            }
                        }
                        $output .= '</select>';
                    }
                    elseif($card_type['type'] == 'url')
                    {
                        $randval = uniqid();
                        $output .= '<div class="main-holder-short" data-id-str="xai' . $randval . '">';
                        $output .= '<input type="url" data-clone-index="xc' . uniqid() . '" class="' . esc_attr($name) . ' ur' . esc_attr($urlrandval) . ' cr_width_full" value="' . esc_attr($card_type['default_value']) . '" placeholder="' . esc_html($card_type['placeholder']) . '" id="xai' . $randval . '">';
                        $output .= '<div class="shortcode-list" data-id-str="xai' . $randval . '"><p class="aishortcodes" data-index="' . esc_html($cont) . '" data-id-str="xai' . $randval . '" title="' . esc_html__('Main keyword shortcode', 'aiomatic-automatic-ai-content-writer') . '">%%keyword%%</p></div>';
                        $output .= '</div>';
                    }
                    elseif($card_type['type'] == 'scraper_select')
                    {
                        $output .= '<select autocomplete="off" data-clone-index="xc' . uniqid() . '" id="sc' . $assistant_helper . '" class="' . esc_attr($name) . ' cr_width_full">';
                        $output .= '<option value="0"';
                        if('0' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("WordPress (Default)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                        $output .= '<option value="1"';
                        if('1' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("PhantomJS (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';         
                        $output .= '<option value="2"';
                        if('2' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Puppeteer (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                        $output .= '<option value="3"';
                        if('3' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        $output .= '>' . esc_html__("Tor (needs to be installed on server)", 'aiomatic-automatic-ai-content-writer') . '</option>';
                        $output .= '<option value="4"';
                        if('4' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                        {
                            $output .= ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                        }
                        $output .= '>' . esc_html__("Puppeteer (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                        if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                        {
                            $output .= esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                        }
                        $output .= '</option>';
                        $output .= '<option value="5"';
                        if('5' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                        {
                            $output .= ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                        }
                        $output .= '>' . esc_html__("Tor (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                        if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                        {
                            $output .= esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                        }
                        $output .= '</option>';
                        $output .= '<option value="6"';
                        if('6' == $card_type['default_value'])
                        {
                            $output .= ' selected';
                        }
                        if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                        {
                            $output .= ' title="' . esc_html__("This option is disabled. To enable it, add a HeadlessBrowserAPI Key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer') . '" disabled';
                        }
                        $output .= '>';
                        $output .= esc_html__("PhantomJS (HeadlessBrowserAPI)", 'aiomatic-automatic-ai-content-writer');
                        if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
                        {
                            $output .= esc_html__(' - to enable, add a HeadlessBrowserAPI key in the plugin\'s \'Settings\'', 'aiomatic-automatic-ai-content-writer');
                        }
                        $output .= '</option>';
                        $output .= '</select>';
                    }
                }
                $critical = false;
                if(isset($card_id['parameters']['critical']) && $card_id['parameters']['critical'] == '1')
                {
                    $critical = true;
                }
                $output .= '<h4>' . esc_html__("Critical", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is critical or not. When a Critical OmniBlock fails to generate its content correctly and it fails, it will cause the entire OmniBlock running sequence to stop. Non-critical OmniBlocks when they fail, the execution of blocks will continue, the result of the failed OmniBlock will be blank.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                $output .= '&nbsp;<input type="checkbox" class="critical-blocks" data-clone-index="xc' . uniqid() . '" id="critical-' . esc_attr($save_id) . '"';
                if($critical == true)
                {
                    $output .= ' checked';
                }
                $output .= '>';
                $output .= '</h4>';
                $disabled = false;
                if(isset($card_id['parameters']['disabled']) && $card_id['parameters']['disabled'] == '1')
                {
                    $disabled = true;
                }
                $output .= '<h4>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . ':&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Set if this OmniBlock is disabled or not. The disabled OmniBlocks will be skipped from processing.", 'aiomatic-automatic-ai-content-writer') . '</div></div>';
                $output .= '&nbsp;<input type="checkbox" class="disabled-blocks" data-clone-index="xc' . uniqid() . '" id="disabled-' . esc_attr($save_id) . '"';
                if($disabled == true)
                {
                    $output .= ' checked';
                }
                $output .= '>';
                $output .= '</h4>';
                $output .= '</div>
                <button disabled class="move-up-btn" title="Move Up">
                <!-- SVG for move up -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0L12 8.292a.5.5 0 0 1-.708.708L8 5.707V12.5a.5.5 0 0 1-1 0V5.707L4.707 9a.5.5 0 1 1-.708-.708l3.647-3.646z"/>
            </svg>
            </button>
            <button disabled class="move-down-btn" title="Move Down">
                <!-- SVG for move down -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1-.708 0L3.293 7.707a.5.5 0 1 1 .708-.708L7 10.293V3.5a.5.5 0 0 1 1 0v6.793l2.999-3.294a.5.5 0 0 1 .708.708l-4 4.147z"/>
            </svg>
            </button>
                <button disabled class="delete-btn" title="' . esc_html__('Delete', 'aiomatic-automatic-ai-content-writer') . '">X</button><div class="ai_common_holder"><div class="step-number"></div><div class="aiomatic-run-now"></div><div class="id-shower"></div></div></li></li>';
            }
        }
    }
    $output .= '</ul>
    </td>
    </tr>
    <tr>
    <td class="ai-flex">
          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
             <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Select what type of block you want to add.", 'aiomatic-automatic-ai-content-writer') . '</div>
          </div>
          <b>' . esc_html__("OmniBlock Type To Add (Drag And Drop):", 'aiomatic-automatic-ai-content-writer') . '</b>&nbsp;<div class="ai-right-flex"><button id="add-new-btn' . esc_html($cont) . '" class="button page-title-action" title="' . esc_html__('Add the above OmniBlock to the Queue', 'aiomatic-automatic-ai-content-writer') . '">' . esc_html__('Add OmniBlock', 'aiomatic-automatic-ai-content-writer') . '</button></div>
    </td>
    <td>
    <select title="' . esc_html__('Change the OmniBlock Type which is displayed, which will be able to be added to the OmniBlock Queue.', 'aiomatic-automatic-ai-content-writer') . '" class="cr_width_full" id="omni_select_block_type' . esc_html($cont) . '" onchange="aiBlockTypeChangeHandler(\'' . esc_html($cont) . '\');">
        <option value="" disabled selected>' . esc_html__("Select a block type to add", 'aiomatic-automatic-ai-content-writer') . '</option>';
    $last_btype = '';
    foreach ($default_block_types as $card_id) 
    {
        if($card_id['category'] !== $last_btype)
        {
            $output .= '<option disabled value="">' . esc_html($card_id['category']) . '</option>';
            $last_btype = $card_id['category'];
        }
        $output .= '<option value="' . sanitize_title($card_id['name']) . '">' . esc_html($card_id['name']) . '</option>';
    }
    $output .= '</select>
    </td>
 </tr>
 <tr><td colspan="2"><hr/></td></tr>
 <tr><td colspan="2"><h2>' . esc_html__('Additional Parameters', 'aiomatic-automatic-ai-content-writer') . ':</h2></td></tr>
 <tr>
 <td class="ai-flex">
     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
         <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Add additional shortcodes which will be available in the OmniBlocks. Add multiple shortcodes on a new line. In the above OmniBlocks, you can use the shortcodes in this format: %%shortcode_name%%. The format is: shortcode_name => shortcode_value1, shortcode_value2", 'aiomatic-automatic-ai-content-writer') . '</div>
     </div>
     <b>' . esc_html__("Additional Shortcodes:", 'aiomatic-automatic-ai-content-writer') . '</b>
 </td>
 <td>
 <textarea rows="1" title="' . esc_html__('Set up additional shortcodes which will be available in OmniBlocks.', 'aiomatic-automatic-ai-content-writer') . '" name="aiomatic_omni_list[more_keywords][]" onchange="updateSortableInputAI(' . esc_html($cont) . ');" id="more_keywords' . esc_html($cont) . '" placeholder="shortcode_name => shortcode_value1, shortcode_value2" class="cr_width_full">' . esc_textarea($more_keywords) . '</textarea>
 </td>
</tr>
<tr><td colspan="2"><hr/></td></tr>
 <tr><td colspan="2"><h2>' . esc_html__('AI OmniBlock Templates Manager', 'aiomatic-automatic-ai-content-writer') . ':</h2></td></tr>
 <tr>
 <td class="ai-flex">
     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
         <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Select a OmniBlock template to be used in this rule. You can import the default templates which come bundled with the plugin, from the above 'OmniBlock Template Manager' tab -> 'Backup/Restore OmniBlock Templates' button -> 'Import Default OmniBlock Templates' button.", 'aiomatic-automatic-ai-content-writer') . '</div>
     </div>
     <b>' . esc_html__("Load An OmniBlock Template:", 'aiomatic-automatic-ai-content-writer') . '</b>
 </td>
 <td>
 <select title="' . esc_html__('Select an OmniBlock Template to be loaded into the OmniBlock Queue. Note that this will overwrite your current OmniBlock setup.', 'aiomatic-automatic-ai-content-writer') . '" class="cr_width_full omni_select_template" id="omni_select_template' . esc_html($cont) . '" data-id="' . esc_html($cont) . '">';
if(!empty($temp_list))
{
$output .= '<option value="" selected>' . esc_html__("Select a template", 'aiomatic-automatic-ai-content-writer') . '</option>';
foreach($temp_list as $templid => $templ)
{
    $output .= '<option value="' . esc_attr($templid) . '">' . esc_html($templ) . '</option>';
}
}
else
{
    $output .= '<option value="" disabled selected>' . esc_html__("No templates found. Add some in the 'OmniBlock Template Manager' tab", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
$output .= '</select>
 </td>
</tr>
<tr>
   <td class="ai-flex">
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Select a OmniBlock template category to list.", 'aiomatic-automatic-ai-content-writer') . '</div>
         </div>
         <b>' . esc_html__("Filter OmniBlock Templates By Category:", 'aiomatic-automatic-ai-content-writer') . '</b>
   </td>
   <td>
   <select title="' . esc_html__('Filter displayed OmniBlock Templates by Category.', 'aiomatic-automatic-ai-content-writer') . '" class="cr_width_full omni_select_template_cat" data-id="' . esc_html($cont) . '">';
if(!empty($aiomatic_tax_names))
{
    $output .= '<option value="" selected>' . esc_html__("Show all templates", 'aiomatic-automatic-ai-content-writer') . '</option>';
    foreach($aiomatic_tax_names as $templ)
    {
        $output .= '<option value="' . esc_attr($templ) . '">' . esc_html($templ) . '</option>';
    }
}
else
{
    $output .= '<option value="" disabled selected>' . esc_html__("No template categories found. Add some in the 'OmniBlock Template Manager' tab", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
$output .= '</select>
   </td>
</tr>
<tr>
   <td class="ai-flex">
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Save the above OmniBlock queue as a new OmniBlock template. Afterwards, the template will be manageable in the 'OmniBlock Template Manager' tab from above.", 'aiomatic-automatic-ai-content-writer') . '</div>
         </div>
         <b>' . esc_html__("Save Above OmniBlocks As A New Template:", 'aiomatic-automatic-ai-content-writer') . '</b>
   </td>
   <td>
   <input type="button" class="aisavetemplate button page-title-action" title="' . esc_html__('Saves the OmniBlock Queue configured above, as a new Template', 'aiomatic-automatic-ai-content-writer') . '" data-id="' . esc_html($cont) . '" value="' . esc_html__("Save New Template", 'aiomatic-automatic-ai-content-writer') . '">
   </td>
</tr>      
</tbody></table></div> 
    </div>
    <div class="codemodalauto-footer">
        <br/>
        <h3 class="cr_inline">Aiomatic Automatic Post Generator</h3><span id="aiomatic_auto_ok' . esc_html($cont) . '" class="codeokauto cr_inline">OK&nbsp;</span>
        <br/><br/>
    </div>
    </div>
</div>       
                    </td>
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
        <table class="aiomatic-automation responsive table cr_main_table_nowr">
        <tr><td colspan="2"><h2>' . esc_html__('Advanced Settings', 'aiomatic-automatic-ai-content-writer') . ':</h2></td></tr>
        <tr><td>
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Select if you want to process each keyword from the added list only once.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Process Each Keyword Only Once", 'aiomatic-automatic-ai-content-writer') . ':</b>
                    
                    </td><td>
                    <input type="checkbox" id="title_once" name="aiomatic_omni_list[title_once][]"';
        if($title_once == '1')
        {
            $output .= ' checked';
        }
        $output .= '>
                        
        </div>
        </td></tr>
        <tr><td colspan="2"><h3>' . esc_html__('Scheduling Restrictions', 'aiomatic-automatic-ai-content-writer') . ':</h3></td></tr><tr><td class="cr_min_width_200">
        <div>
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                        <div class="bws_hidden_help_text cr_min_260px disable_drag">' . esc_html__("Select the days of the week when you don't want to run this rule. You can enter a comma separate list of day names.", 'aiomatic-automatic-ai-content-writer') . '
                        </div>
                    </div>
                    <b>' . esc_html__("Do Not Run This Rule On The Following Days Of The Week", 'aiomatic-automatic-ai-content-writer') . ':</b>
                    <br/>' . esc_html__("Current Server Time:", 'aiomatic-automatic-ai-content-writer') . '&nbsp;' . date('l', time()) . ', ' . date("Y-m-d H:i:s") . '
                    </td><td>
                    <input type="text" class="cr_width_full" name="aiomatic_omni_list[days_no_run][]" value="' . esc_attr($days_no_run) . '" placeholder="Mo,Tu,We,Th,Fr,Sa,Su" class="cr_width_full">
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
                        <td class="cr_short_td"><input type="checkbox" name="aiomatic_omni_list[active][]" class="activateDeactivateClass" value="1"';
            if (isset($active) && $active === '1') {
                $output .= ' checked';
            }
            $output .= '/>
                        <input type="hidden" name="aiomatic_omni_list[last_run][]" value="' . esc_attr($last_run) . '"/>
                        <input type="hidden" name="aiomatic_omni_list[rule_unique_id][]" value="' . esc_attr($rule_unique_id) . '"/></td>
                        <td class="cr_shrt_td2"><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px disable_drag">' . sprintf( wp_kses( __( 'Shortcode for this rule<br/>(to cross-post from this plugin in other plugins):', 'aiomatic-automatic-ai-content-writer'), array(  'br' => array( ) ) ) ) . '<br/><b>%%aiomatic_5_' . esc_html($cont) . '%% and %%aiomatic_title_5_' . esc_html($cont) . '%%</b><br/>' . esc_html__('Posts Generated:', 'aiomatic-automatic-ai-content-writer') . ' ' . esc_html($generated_posts) . '<br/>';
            if ($generated_posts != 0) {
                $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=Aiomatic_5_' . esc_html($cont) . '" target="_blank">' . esc_html__('View Generated Posts', 'aiomatic-automatic-ai-content-writer') . '</a><br/>';
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
                if (!in_array(array($cont => 5), $running)) {
                    $f = fopen(get_temp_dir() . 'aiomatic_5_' . $cont, 'w');
                    if($f !== false)
                    {
                        flock($f, LOCK_UN);
                        fclose($f);
                        global $wp_filesystem;
                        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                wp_filesystem($creds);
                        }
                        $wp_filesystem->delete(get_temp_dir() . 'aiomatic_5_' . $cont);
                    }
                    $output .= ' cr_hidden';
                }
                else
                {
                    $f = fopen(get_temp_dir() . 'aiomatic_5_' . $cont, 'w');
                    if($f !== false)
                    {
                        if (!flock($f, LOCK_EX | LOCK_NB)) {
                        }
                        else
                        {
                            $output .= ' cr_hidden';
                            flock($f, LOCK_UN);
                            if (($xxkey = array_search(array($cont => 5), $running)) !== false) {
                                unset($running[$xxkey]);
                                update_option('aiomatic_running_list', $running);
                            }
                        }
                    }
                }
            } 
            else 
            {
                $f = fopen(get_temp_dir() . 'aiomatic_5_' . $cont, 'w');
                if($f !== false)
                {
                    flock($f, LOCK_UN);
                    fclose($f);
                    global $wp_filesystem;
                    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                    }
                    $wp_filesystem->delete(get_temp_dir() . 'aiomatic_5_' . $cont);
                }
                $output .= ' cr_hidden';
            }
            $output .= '" title="status">
                        <div class="codemainfzr cr_width_80p">
                        <select autocomplete="off" class="codemainfzr" id="actions" class="actions" name="actions" onchange="actionsChangedManual(' . esc_html($cont) . ', this.value, 5, \'' . esc_html($rule_unique_id) . '\');" onfocus="this.selectedIndex = 0;">
                            <option value="select" disabled selected>' . esc_html__("Select an Action", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="run">' . esc_html__("Run This Rule Now", 'aiomatic-automatic-ai-content-writer') . '</option>
                            <option value="erase">' . esc_html__("Erase Processed Keyword History", 'aiomatic-automatic-ai-content-writer') . '</option>
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