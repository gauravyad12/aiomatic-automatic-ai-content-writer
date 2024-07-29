<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function aiomatic_assistants_panel()
{
    if(!function_exists('is_plugin_active'))
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    $fbomatic_active = false;
    if (is_plugin_active('fbomatic-facebook-post-generator/fbomatic-facebook-post-generator.php')) 
    {
        $fbomatic_active = true;
    }
    $twitomatic_active = false;
    if (is_plugin_active('twitomatic-twitter-post-generator/twitomatic-twitter-post-generator.php')) 
    {
        $twitomatic_active = true;
    }
    $instamatic_active = false;
    if (is_plugin_active('instamatic-instagram-post-generator/instamatic-instagram-post-generator.php')) 
    {
        $instamatic_active = true;
    }
    $pinterestomatic_active = false;
    if (is_plugin_active('pinterestomatic-pinterest-post-generator/pinterestomatic-pinterest-post-generator.php')) 
    {
        $pinterestomatic_active = true;
    }
    $businessomatic_active = false;
    if (is_plugin_active('businessomatic-google-my-business-post-generator/businessomatic-google-my-business-post-generator.php')) 
    {
        $businessomatic_active = true;
    }
    $youtubomatic_active = false;
    if (is_plugin_active('youtubomatic-youtube-post-generator/youtubomatic-youtube-post-generator.php')) 
    {
        $youtubomatic_active = true;
    }
    $redditomatic_active = false;
    if (is_plugin_active('redditomatic-reddit-post-generator/redditomatic-reddit-post-generator.php')) 
    {
        $redditomatic_active = true;
    }
    $linkedinomatic_active = false;
    if (is_plugin_active('linkedinomatic-linkedin-post-generator/linkedinomatic-linkedin-post-generator.php')) 
    {
        $linkedinomatic_active = true;
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
?>
<h1><?php echo esc_html__("You must add an OpenAI API Key into the plugin's 'Settings' menu before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
    }
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
?>
<h1><?php echo esc_html__("This feature is currently not supported when using Azure/Claude API!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
    return;
    }
    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    if(count($appids) > 1)
    {
?>
<h1><?php echo esc_html__("This feature is currently supported only if you enter a single OpenAI API key in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
        return;
    }
    if(count($appids) == 0)
    {
?>
<h1><?php echo esc_html__("You need to add an API key in plugin settings for this to work.", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
        return;
    }
    $token = $appids[array_rand($appids)];
    if(aiomatic_is_aiomaticapi_key($token))
    {
?>
<h1><?php echo esc_html__("This feature is currently supported only for OpenAI API keys.", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
        return;
    }
?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<h2 class="cr_center"><?php echo esc_html__("AI Assistants", 'aiomatic-automatic-ai-content-writer');?></h2>
<div class="wrap">
        <nav class="nav-tab-wrapper">
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-6" class="nav-tab"><?php echo esc_html__("Manage Assistants", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("Manage Assistant Files", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-1" class="tab-content">
        <br/>
<h3><?php echo esc_html__("What are AI Assistants?", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__('The Assistants API (or AI GPTs) is a cool feature that lets you create AI helpers in your applications, like your WordPress site. These assistants can do a bunch of stuff like run code, find information, and even call functions to get things done. Right now, it works with a few handy tools, and there\'s more coming soon.', 'aiomatic-automatic-ai-content-writer');?></p>
<h3><?php echo esc_html__("To add an Assistants to your WordPress site, you'll follow steps like these:", 'aiomatic-automatic-ai-content-writer');?></h3>
<h4><?php echo esc_html__("Step 1a: Set Up Your Assistant", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("Go to the 'Manage Assistants' tab and click the 'Add New Assistant' button. Fill out an intuitive name for the assistant, select an AI model, add a description and in the 'Assistant Context Prompt' settings field, be sure to add any information that the Assistant should be aware of. Here you can teach it about its name, role and purpose. You can also enable advanced features like 'Code Interpreter' and 'File Search', add your own functions or even upload files for the assistant to process and to extract content from them. Finally, you can assign also an avatar for the Assistant, which will be used for the chatbot, when this assistant is used.", 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 1b: Set Up Your Assistant", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("If you already have assistants created on OpenAI's platform, you can import these assistants, using the 'Import Assistants From OpenAI' button. All create assistants will appear in the plugin and will be able to be used.", 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 2: Select The Assistants To Be Used In Plugin Settings", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("The bulk of the work is done, now you can go to the part of the plugin where you want to use assistants and select the assistant instead of the AI model (usually, you will find an 'AI Assistant Name' settings field, where you will be able to select the imported assistants.", 'aiomatic-automatic-ai-content-writer');?></p>
<p><?php echo esc_html__("That's it! You've successfully set up an AI-powered Assistant on your WordPress website using the Aiomatic plugin. This Assistant can be a valuable tool for engaging with your website visitors, answering frequently asked questions, and providing personalized assistance, or even create content for your site which is highly focused on your specific needs.", 'aiomatic-automatic-ai-content-writer');?></p>
<h3><?php echo esc_html__("AI Assistants Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/x2mkjdOZI9Y" frameborder="0" allowfullscreen></iframe></div></p>   
</div>
<div id="tab-2" class="tab-content">
<br/>
<?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<hr/>
<h3 class="margin5"><?php echo esc_html__("Upload A New Assistant File", 'aiomatic-automatic-ai-content-writer');?></h3>
<div class="aiomatic_form_upload_file">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php echo esc_html__("Select A File To Upload", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="file" id="aiomatic_assistant_file_upload">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="aiomatic_upload_success aiomatic_none margin5 colorgr"><?php echo esc_html__("File uploaded successfully!", 'aiomatic-automatic-ai-content-writer');?></div>
                <div class="aiomatic_progress aiomatic_none"><span></span><small><?php echo esc_html__("Uploading", 'aiomatic-automatic-ai-content-writer');?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_file_button"><?php echo esc_html__("Upload to OpenAI", 'aiomatic-automatic-ai-content-writer');?></button><br>
                <p class="cr_center"><?php echo esc_html__("Maximum upload file size:", 'aiomatic-automatic-ai-content-writer');?> <?php echo size_format($aiomaticMaxFileSize)?>
                <?php
                if(wp_max_upload_size() < 104857600){
                    ?>
                    <?php echo esc_html__("(Please increase this value if you want to upload larger files)", 'aiomatic-automatic-ai-content-writer');?>
                    <?php
                }
                ?></p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<hr/>
<h3 class="margin5"><?php echo esc_html__("Manage Uploaded Assistant Files", 'aiomatic-automatic-ai-content-writer');?></h3>
<br/><br/>
<button href="javascript:void(0)" id="aiomatic_sync_assistant_files" class="page-title-action aiomatic_sync_assistant_files"><?php echo esc_html__("Sync Files", 'aiomatic-automatic-ai-content-writer');?></button>&nbsp;
<a href="https://platform.openai.com/storage" target="_blank" id="aiomatic_view_storage" class="page-title-action aiomatic_view_storage"><?php echo esc_html__("View Files On OpenAI", 'aiomatic-automatic-ai-content-writer');?></a>
<table class="wp-list-table widefat fixed striped table-view-list comments" id="aiomatic-assistants-files">
    <thead>
    <tr>
        <th><?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?></th>
        <th class="width50p"><?php echo esc_html__("Size", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Purpose", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Created At", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Filename", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Action", 'aiomatic-automatic-ai-content-writer');?></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
        </div>
        <div id="tab-6" class="tab-content">
        <h2><?php echo esc_html__("Manage Assistants:", 'aiomatic-automatic-ai-content-writer');?></h2>
<br/>
        <button href="#" id="aiomatic_sync_assistants" class="page-title-action"><?php
        echo esc_html__("Import Assistants From OpenAI", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button id="aiomatic_manage_assistants" class="page-title-action"><?php
        echo esc_html__("Add New Assistant", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button id="aiomatic_backup_assistants" class="page-title-action"><?php
        echo esc_html__("Backup/Restore Assistants", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <a href="https://platform.openai.com/assistants" target="_blank" class="page-title-action"><?php
        echo esc_html__("Check On OpenAI", 'aiomatic-automatic-ai-content-writer');
        ?></a>
        <button href="#" id="aiomatic_delete_selected_assistants" class="page-title-action"><?php
        echo esc_html__("Delete Selected Assistants", 'aiomatic-automatic-ai-content-writer');
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
$aiomatic_assistant_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_assistants = new WP_Query(array(
    'post_type' => 'aiomatic_assistants',
    'posts_per_page' => 40,
    'paged' => $aiomatic_assistant_page,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'any'
));
if($aiomatic_assistants->have_posts()){
    echo '<br><br>' . esc_html__('All assistants', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_assistants->found_posts . ')<br>';
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
        echo esc_html__("Name", 'aiomatic-automatic-ai-content-writer');
        ?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php
        echo esc_html__("Description", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Avatar", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Assistant Local ID", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Assistant OpenAI ID", 'aiomatic-automatic-ai-content-writer');
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
    if($aiomatic_assistants->have_posts())
    {
        foreach ($aiomatic_assistants->posts as $aiomatic_assistant)
        {
            ?>
            <tr>
                <td><input class="aiomatic-select-assistant" id="aiomatic-select-<?php echo $aiomatic_assistant->ID;?>" type="checkbox" name="ids[]" value="<?php echo $aiomatic_assistant->ID;?>"></td>
                <td><?php echo esc_html($aiomatic_assistant->post_title);?></td>
                <td><?php echo esc_html($aiomatic_assistant->post_excerpt);?></td>
                <td><?php $avatar = get_the_post_thumbnail_url($aiomatic_assistant->ID, 'thumbnail'); if($avatar === false){echo 'N/A';}else{echo '<img class="openai-chat-avatar" src="' . $avatar . '" alt="avatar"/>';}?></td>
                <td><?php echo esc_html($aiomatic_assistant->ID);?></td>
                <td><?php $ass_id = get_post_meta($aiomatic_assistant->ID, '_assistant_id', true); echo esc_html($ass_id);?></td>
                <td><?php echo esc_html($aiomatic_assistant->post_date)?></td>
                <td>
                <div class="cr_center">
                <?php
                if(!empty($ass_id))
                {
                ?>
                <a class="button button-small" href="https://platform.openai.com/playground/assistants?assistant=<?php echo esc_html($ass_id);?>" target="_blank"><?php echo esc_html__("Test", 'aiomatic-automatic-ai-content-writer');?></a>
                <?php
                }
                ?>
                <button class="button button-small aiomatic_sync_assistant" id="aiomatic_sync_assistant_<?php echo $aiomatic_assistant->ID;?>" sync-id="<?php echo $aiomatic_assistant->ID;?>"><?php echo esc_html__("Sync", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_duplicate_assistant" id="aiomatic_duplicate_assistant_<?php echo $aiomatic_assistant->ID;?>" dup-id="<?php echo $aiomatic_assistant->ID;?>"><?php echo esc_html__("Duplicate", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_edit_assistant" id="aiomatic_edit_assistant_<?php echo $aiomatic_assistant->ID;?>" edit-id="<?php echo $aiomatic_assistant->ID;?>"><?php echo esc_html__("Edit", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small button-link-delete aiomatic_delete_assistant" id="aiomatic_delete_assistant_<?php echo $aiomatic_assistant->ID;?>" delete-id="<?php echo $aiomatic_assistant->ID;?>"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
                </div>
            </td>
            </tr>
            <?php
        }
    }
    else
    {
        echo '<tr><td colspan="8">' . esc_html__("No assistants added. You can add more using the 'Add New Assistant' button from above.", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
    }
    ?>
    </tbody>
</table>
<?php
if($aiomatic_assistants->have_posts() && $aiomatic_assistants->max_num_pages > 1)
{
?>
<div class="aiomatic-paginate">
    <?php
    echo esc_html__("Page: ", 'aiomatic-automatic-ai-content-writer') . paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_assistants_panel&wpage=%#%'),
        'total'        => $aiomatic_assistants->max_num_pages,
        'current'      => $aiomatic_assistant_page,
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

    <div id="mymodalfzr_backup" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close_backup" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Backup/Restore Assistants", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <br/>
<?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<hr/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Restore Assistants From File", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px">
        <?php
        echo esc_html__("Hit this button and you can restore assistants from file.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<div class="aiomatic_assistant_upload_form">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php
        echo esc_html__("Backup File (*.json)", 'aiomatic-automatic-ai-content-writer');
        ?></th>
            <td>
                <input type="file" id="aiomatic_assistant_upload" accept=".json">
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
        echo esc_html__("File uploaded successfully you can view it in the assistant listing tab.", 'aiomatic-automatic-ai-content-writer');
        ?></div>
                <div class="aiomatic_progress aiomatic_none"><span></span><small><?php
        echo esc_html__("Uploading", 'aiomatic-automatic-ai-content-writer');
        ?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_assistant_button"><?php echo esc_html__("Import Assistants From File", 'aiomatic-automatic-ai-content-writer');?></button><br>
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
               <?php echo esc_html__('Backup Current Assistants To File:', 'aiomatic-automatic-ai-content-writer');?>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Hit this button and you can backup the current assistants to file.", 'aiomatic-automatic-ai-content-writer');
                        ?>
                  </div>
               </div>
            </h3>
            <form method="post" onsubmit="return confirm('Are you sure you want to download assistants to file?');"><input name="aiomatic_nonce" type="hidden" value="<?php echo wp_create_nonce('aiomatic_assistants');?>"><input name="aiomatic_download_assistants_to_file" type="submit" class="button button-primary coderevolution_block_input" value="Backup Assistants To File"></form>
         </div>
</div>
<br/>
<hr/>
<div class="aiomatic-loader-bubble">
<h3 class="margin5"><?php echo esc_html__("Import Default Assistants (This Can Take For A While)", 'aiomatic-automatic-ai-content-writer');?>:
<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
    <div class="bws_hidden_help_text cr_min_260px">
        <?php
        echo esc_html__("Hit this button and the plugin will create the default assistants which come bundled with the plugin.", 'aiomatic-automatic-ai-content-writer');
        ?>
    </div>
</div></h3>
<table class="form-table">
        <tbody>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_assistant_default_button"><?php echo esc_html__("Import Default Assistants", 'aiomatic-automatic-ai-content-writer');?></button><br>
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


<div id="mymodalfzr" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Add New Assistant", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <form action="#" method="post" id="aiomatic_assistants_form">
            <br/>
            <input type="hidden" name="action" value="aiomatic_assistants">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('aiomatic_assistants');?>">
            <h4><?php echo esc_html__("Assistant Name*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the name of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <textarea rows="1" id="aiomatic-assistant-title" name="aiomatic-assistant-title" class="aiomatic-full-size" placeholder="Assistant name" required></textarea>
            <br/>
            <h4><?php echo esc_html__("Assistant Model*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the AI model of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-assistant-model" name="aiomatic-assistant-model" class="aiomatic-full-size">
<?php
$assist_mods = array_merge(AIOMATIC_ASSISTANT_MODELS, get_option('aiomatic_custom_models', array()));
foreach($assist_mods as $modelx)
{
    echo '<option value="' . $modelx .'"';
    echo '>' . esc_html($modelx);
    if(aiomatic_is_vision_model($modelx, ''))
    {
        echo esc_html__(" (Vision)", 'aiomatic-automatic-ai-content-writer');
    }
    echo '</option>';
}
?>
        </select>
        <br/>
            <h4><?php echo esc_html__("Model Temperature", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <input type="number" min="0" step="0.01" max="2" id="aiomatic-assistant-temperature" name="aiomatic-assistant-temperature" value="" placeholder="Model temperature" class="cr_width_full">
        <br/>
            <h4><?php echo esc_html__("Model Top_p", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <input type="number" min="0" max="1" step="0.01" id="aiomatic-assistant-topp" name="aiomatic-assistant-topp" value="" placeholder="Model top_p" class="cr_width_full">
            <br/>
            <h4><?php echo esc_html__("Assistant Description", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the description of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <textarea rows="1" id="aiomatic-assistant-description" name="aiomatic-assistant-description" class="aiomatic-full-size" placeholder="Assistant description"></textarea>
            <br/>
            <h4><?php echo esc_html__("Assistant Context Prompt", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the prompt which will be sent to the AI. Add a context to the AI chatbot, so it knows how to act and how to respond to customers. You can define here the language, tone of voice and role of the AI assistant. Any other settings will also be able to be defined here. This text will be preppended to each conversation, to teach the AI some additional info about you or its behavior. This text will not be displayed to users, it will be only sent to the chatbot. You can also use shortcodes in this field. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-assistant-prompt" name="aiomatic-assistant-prompt" class="aiomatic-full-size" placeholder="Assistant context prompt"></textarea>
            <br/>
            <h4><?php echo esc_html__("Assistant First Message", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the first message of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-assistant-first-message" name="aiomatic-assistant-first-message" class="aiomatic-full-size" placeholder="Assistant first message"></textarea>
        <br/>
        <h4><?php echo esc_html__("Code Interpreter", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Code Interpreter enables the assistant to write and run code. This tool can process files with diverse data and formatting, and generate files such as graphs.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div>&nbsp;&nbsp;<input id="aiomatic-assistant-code-interpreter" value="on" type="checkbox" name="aiomatic-assistant-code-interpreter"></h4>
        <h4><?php echo esc_html__("File Search", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("File Search enables the assistant with knowledge from files that you or your users upload. Once a file is uploaded, the assistant automatically decides when to retrieve content based on user requests. To enable this functionality, a newer model is needed, version 1106 or newer.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div>&nbsp;&nbsp;<input id="aiomatic-assistant-file_search" value="on" type="checkbox" name="aiomatic-assistant-file_search"></h4>
        <h4><?php echo esc_html__("Assistant Files", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Select the files which will be available for the assistant. You can add more files in the 'Manage Assistant Files' menu. To enable this functionality, code interpreter or file_search needs to be enabled for this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-assistant-files" multiple name="aiomatic-assistant-files[]" class="aiomatic-full-size" disabled>
            
        </select>
        <br/>
            <h4><?php echo esc_html__("Assistant Functions", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the function or an array of functions, which the assistant will be able to call You need to respect the required function format, for this to work.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-assistant-functions" name="aiomatic-assistant-functions" class="aiomatic-full-size" placeholder="{
    &quot;name&quot;: &quot;get_weather&quot;,
    &quot;description&quot;: &quot;Determine weather in my location&quot;,
    &quot;parameters&quot;: {
    &quot;type&quot;: &quot;object&quot;,
    &quot;properties&quot;: {
      &quot;location&quot;: {
        &quot;type&quot;: &quot;string&quot;,
        &quot;description&quot;: &quot;The city and state e.g. San Francisco, CA&quot;
      },
      &quot;unit&quot;: {
        &quot;type&quot;: &quot;string&quot;,
        &quot;enum&quot;: [
          &quot;c&quot;,
          &quot;f&quot;
        ]
      }
    },
    &quot;required&quot;: [
      &quot;location&quot;
    ]
  }
}"></textarea>
        <br/>
        <input type='button' class="button-primary" value="<?php esc_attr_e( 'Use Below Functions', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_god_mode_new"/>&nbsp;
        <input type='button' class="button-primary" value="<?php esc_attr_e( 'Disable Functions', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_god_mode_new_disable"/>
        <br/><input type='checkbox' id="function_god_mode"/><label for="function_god_mode"><?php echo esc_html__( 'God Mode (WordPress Function Calling)', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_dalle"/><label for="function_dalle"><?php echo esc_html__( 'Dall-E AI Images', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_stable"/><label for="function_stable"><?php echo esc_html__( 'Stable Diffusion AI Images', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_midjourney"/><label for="function_midjourney"><?php echo esc_html__( 'Midjourney AI Images', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_stable_video"/><label for="function_stable_video"><?php echo esc_html__( 'Stable Diffusion AI Videos', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_amazon"/><label for="function_amazon"><?php echo esc_html__( 'Amazon Product Listing', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_amazon_details"/><label for="function_amazon_details"><?php echo esc_html__( 'Amazon Product Details', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_scraper"/><label for="function_scraper"><?php echo esc_html__( 'Website Scraper', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_rss"/><label for="function_rss"><?php echo esc_html__( 'RSS Parser', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_google"/><label for="function_google"><?php echo esc_html__( 'Google SERP Parser', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_youtube"/><label for="function_youtube"><?php echo esc_html__( 'YouTube Video Search', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_captions"/><label for="function_captions"><?php echo esc_html__( 'YouTube Video Captions Scraper', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_royalty"/><label for="function_royalty"><?php echo esc_html__( 'Royalty Free Image Search', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_email"/><label for="function_email"><?php echo esc_html__( 'Email Sending', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_webhook"/><label for="function_webhook"><?php echo esc_html__( 'Webhook Calling', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_facebook"<?php if(!$fbomatic_active){echo ' disabled title="Required plugin (F-omatic) not activated"';}?>/><label for="function_facebook"><?php echo esc_html__( 'Facebook Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_facebook_image"<?php if(!$fbomatic_active){echo ' disabled title="Required plugin (F-omatic) not activated"';}?>/><label for="function_facebook_image"><?php echo esc_html__( 'Facebook Image Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_twitter"<?php if(!$twitomatic_active){echo ' disabled title="Required plugin (Twitomatic) not activated"';}?>/><label for="function_twitter"><?php echo esc_html__( 'Twitter Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_instagram"<?php if(!$instamatic_active){echo ' disabled title="Required plugin (iMediamatic) not activated"';}?>/><label for="function_instagram"><?php echo esc_html__( 'Instagram Image Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_pinterest"<?php if(!$pinterestomatic_active){echo ' disabled title="Required plugin (Pinterestomatic) not activated"';}?>/><label for="function_pinterest"><?php echo esc_html__( 'Pinterest Image Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_business"<?php if(!$businessomatic_active){echo ' disabled title="Required plugin (Businessomatic) not activated"';}?>/><label for="function_business"><?php echo esc_html__( 'Google My Business Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_youtube_community"<?php if(!$youtubomatic_active){echo ' disabled title="Required plugin (Youtubomatic) not activated"';}?>/><label for="function_youtube_community"><?php echo esc_html__( 'YouTube Community Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_reddit"<?php if(!$redditomatic_active){echo ' disabled title="Required plugin (Redditomatic) not activated"';}?>/><label for="function_reddit"><?php echo esc_html__( 'Reddit Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_linkedin"<?php if(!$linkedinomatic_active){echo ' disabled title="Required plugin (Linkedinomatic) not activated"';}?>/><label for="function_linkedin"><?php echo esc_html__( 'LinkedIn Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
            <h4><?php echo esc_html__("Assistant Avatar", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the avatar of the chatbot assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image-new"/></div>
            <input type="hidden" name="aiomatic-assistant-avatar" id="aiomatic_image_id_new" value="" />
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager_new"/>&nbsp;
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Clear avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_clear_new"/>
      <br/><br/>
<hr/>
      <button id="aiomatic-assistants-save-button" class="button button-primary"><?php echo esc_html__("Save", 'aiomatic-automatic-ai-content-writer');?></button>
   <div class="aiomatic-assistants-success"></div>
   <br/>
</form>
            </div>
        </div>  
    </div>
</div>

<div id="mymodalfzr-edit" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close-edit" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Edit Assistant", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <form action="#" method="post" id="aiomatic_assistants_form-edit">
            <br/>
            <input type="hidden" name="action" value="aiomatic_assistants_edit">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('aiomatic_assistants');?>">
            <input type="hidden" name="assistant_id" id="assistant_id" value="">
            <h4><?php echo esc_html__("Assistant Name*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the name of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <textarea rows="1" id="aiomatic-assistant-title-edit" name="aiomatic-assistant-title" class="aiomatic-full-size" placeholder="Assistant name" required></textarea>
            <br/>
            <h4><?php echo esc_html__("Assistant Model*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the AI model of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-assistant-model-edit" name="aiomatic-assistant-model" class="aiomatic-full-size">
<?php
$assist_mods = array_merge(AIOMATIC_ASSISTANT_MODELS, get_option('aiomatic_custom_models', array()));
foreach($assist_mods as $modelx)
{
    echo '<option value="' . $modelx .'"';
    echo '>' . esc_html($modelx);
    if(aiomatic_is_vision_model($modelx, ''))
    {
        echo esc_html__(" (Vision)", 'aiomatic-automatic-ai-content-writer');
    }
    echo '</option>';
}
?>
        </select> 
            <br/>
            <h4><?php echo esc_html__("Model Temperature", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <input type="number" min="0" step="0.01" max="2" id="aiomatic-assistant-temperature-edit" name="aiomatic-assistant-temperature" value="" placeholder="Model temperature" class="cr_width_full">
        <br/>
            <h4><?php echo esc_html__("Model Top_p", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <input type="number" min="0" max="1" step="0.01" id="aiomatic-assistant-topp-edit" name="aiomatic-assistant-topp" value="" placeholder="Model top_p" class="cr_width_full">
            <br/>
            <h4><?php echo esc_html__("Assistant Description", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the description of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
            <textarea rows="1" id="aiomatic-assistant-description-edit" name="aiomatic-assistant-description" class="aiomatic-full-size" placeholder="Assistant description"></textarea>
            <br/>
            <h4><?php echo esc_html__("Assistant Context Prompt", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the prompt which will be sent to the AI. Add a context to the AI chatbot, so it knows how to act and how to respond to customers. You can define here the language, tone of voice and role of the AI assistant. Any other settings will also be able to be defined here. This text will be preppended to each conversation, to teach the AI some additional info about you or its behavior. This text will not be displayed to users, it will be only sent to the chatbot. You can also use shortcodes in this field. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%current_date_time%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it's assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins).", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-assistant-prompt-edit" name="aiomatic-assistant-prompt" class="aiomatic-full-size" placeholder="Assistant context prompt"></textarea>
            <br/>
            <h4><?php echo esc_html__("Assistant First Message", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the first message of this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-assistant-first-message-edit" name="aiomatic-assistant-first-message" class="aiomatic-full-size" placeholder="Assistant first message"></textarea>
        <br/>
        <h4><?php echo esc_html__("Code Interpreter", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Code Interpreter enables the assistant to write and run code. This tool can process files with diverse data and formatting, and generate files such as graphs.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div>&nbsp;&nbsp;<input id="aiomatic-assistant-code-interpreter-edit" value="on" type="checkbox" name="aiomatic-assistant-code-interpreter"></h4>
        <h4><?php echo esc_html__("File Search", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("File Search enables the assistant with knowledge from files that you or your users upload. Once a file is uploaded, the assistant automatically decides when to retrieve content based on user requests. To enable this functionality, a newer model is needed, version 1106 or newer.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div>&nbsp;&nbsp;<input id="aiomatic-assistant-file_search-edit" value="on" type="checkbox" name="aiomatic-assistant-file_search">&nbsp;&nbsp;<span id="aiomatic-assistant-vector-store-edit"></span></h4>
        <h4><?php echo esc_html__("Assistant Files", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Select the files which will be available for the assistant. You can add more files in the 'Manage Assistant Files' menu. To enable this functionality, code interpreter or file_search needs to be enabled for this assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-assistant-files-edit" multiple name="aiomatic-assistant-files[]" class="aiomatic-full-size" disabled>
            
        </select>
        <br/>
            <h4><?php echo esc_html__("Assistant Functions", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the function or an array of functions, which the assistant will be able to call You need to respect the required function format, for this to work.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <textarea rows="4"  id="aiomatic-assistant-functions-edit" name="aiomatic-assistant-functions" class="aiomatic-full-size" placeholder="{
    &quot;name&quot;: &quot;get_weather&quot;,
    &quot;description&quot;: &quot;Determine weather in my location&quot;,
    &quot;parameters&quot;: {
    &quot;type&quot;: &quot;object&quot;,
    &quot;properties&quot;: {
      &quot;location&quot;: {
        &quot;type&quot;: &quot;string&quot;,
        &quot;description&quot;: &quot;The city and state e.g. San Francisco, CA&quot;
      },
      &quot;unit&quot;: {
        &quot;type&quot;: &quot;string&quot;,
        &quot;enum&quot;: [
          &quot;c&quot;,
          &quot;f&quot;
        ]
      }
    },
    &quot;required&quot;: [
      &quot;location&quot;
    ]
  }
}"></textarea>
        <br/>
        <input type='button' class="button-primary" value="<?php esc_attr_e( 'Use Below Functions', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_god_mode_new-edit"/>&nbsp;
        <input type='button' class="button-primary" value="<?php esc_attr_e( 'Disable Functions', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_god_mode_new_disable-edit"/>
        <br/><input type='checkbox' id="function_god_mode-edit"/><label for="function_god_mode-edit"><?php echo esc_html__( 'God Mode (WordPress Function Calling)', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_dalle-edit"/><label for="function_dalle-edit"><?php echo esc_html__( 'Dall-E AI Images', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_stable-edit"/><label for="function_stable-edit"><?php echo esc_html__( 'Stable Diffusion AI Images', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_midjourney-edit"/><label for="function_midjourney-edit"><?php echo esc_html__( 'Midjourney AI Images', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_stable_video-edit"/><label for="function_stable_video-edit"><?php echo esc_html__( 'Stable Diffusion AI Videos', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_amazon-edit"/><label for="function_amazon-edit"><?php echo esc_html__( 'Amazon Product Listing', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_amazon_details-edit"/><label for="function_amazon_details-edit"><?php echo esc_html__( 'Amazon Product Details', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_scraper-edit"/><label for="function_scraper-edit"><?php echo esc_html__( 'Website Scraper', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_rss-edit"/><label for="function_rss-edit"><?php echo esc_html__( 'RSS Parser', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_google-edit"/><label for="function_google-edit"><?php echo esc_html__( 'Google SERP Parser', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_youtube-edit"/><label for="function_youtube-edit"><?php echo esc_html__( 'YouTube Video Search', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_captions-edit"/><label for="function_captions-edit"><?php echo esc_html__( 'YouTube Video Captions Scraper', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_royalty-edit"/><label for="function_royalty-edit"><?php echo esc_html__( 'Royalty Free Image Search', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_email-edit"/><label for="function_email-edit"><?php echo esc_html__( 'Email Sending', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_webhook-edit"/><label for="function_webhook-edit"><?php echo esc_html__( 'Webhook Calling', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_facebook-edit"<?php if(!$fbomatic_active){echo ' disabled title="Required plugin (F-omatic) not activated"';}?>/><label for="function_facebook-edit"><?php echo esc_html__( 'Facebook Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_facebook_image-edit"<?php if(!$fbomatic_active){echo ' disabled title="Required plugin (F-omatic) not activated"';}?>/><label for="function_facebook_image-edit"><?php echo esc_html__( 'Facebook Image Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_twitter-edit"<?php if(!$twitomatic_active){echo ' disabled title="Required plugin (Twitomatic) not activated"';}?>/><label for="function_twitter-edit"><?php echo esc_html__( 'Twitter Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_instagram-edit"<?php if(!$instamatic_active){echo ' disabled title="Required plugin (iMediamatic) not activated"';}?>/><label for="function_instagram-edit"><?php echo esc_html__( 'Instagram Image Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_pinterest-edit"<?php if(!$pinterestomatic_active){echo ' disabled title="Required plugin (Pinterestomatic) not activated"';}?>/><label for="function_pinterest-edit"><?php echo esc_html__( 'Pinterest Image Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_business-edit"<?php if(!$businessomatic_active){echo ' disabled title="Required plugin (Businessomatic) not activated"';}?>/><label for="function_business-edit"><?php echo esc_html__( 'Google My Business Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_youtube_community-edit"<?php if(!$youtubomatic_active){echo ' disabled title="Required plugin (Youtubomatic) not activated"';}?>/><label for="function_youtube_community-edit"><?php echo esc_html__( 'YouTube Community Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_reddit-edit"<?php if(!$redditomatic_active){echo ' disabled title="Required plugin (Redditomatic) not activated"';}?>/><label for="function_reddit-edit"><?php echo esc_html__( 'Reddit Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
        <input type='checkbox' id="function_linkedin-edit"<?php if(!$linkedinomatic_active){echo ' disabled title="Required plugin (Linkedinomatic) not activated"';}?>/><label for="function_linkedin-edit"><?php echo esc_html__( 'LinkedIn Posting', 'aiomatic-automatic-ai-content-writer' ); ?></label>&nbsp;
            <h4><?php echo esc_html__("Assistant Avatar", 'aiomatic-automatic-ai-content-writer');?>:
        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Set the avatar of the chatbot assistant.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <div class="coderevolution_gutenberg_input"><img id="aiomatic-preview-image-new-edit"/></div>
            <input type="hidden" name="aiomatic-assistant-avatar" id="aiomatic_image_id_new-edit" value="" />
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select an avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_manager_new-edit"/>&nbsp;
            <input type='button' class="button-primary" value="<?php esc_attr_e( 'Clear avatar', 'aiomatic-automatic-ai-content-writer' ); ?>" id="aiomatic_media_clear_new-edit"/>
      <br/><br/>
<hr/>
      <button id="aiomatic-assistants-save-button-edit" class="button button-primary"><?php echo esc_html__("Save", 'aiomatic-automatic-ai-content-writer');?></button>
   <div class="aiomatic-assistants-success"></div>
   <br/>
</form>
            </div>
        </div>  
    </div>
</div>
</div>
<?php
}
?>