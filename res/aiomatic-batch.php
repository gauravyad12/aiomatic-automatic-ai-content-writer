<?php
if ( ! defined( 'ABSPATH' ) ) exit;
use AiomaticOpenAI\OpenAi\OpenAi;
function aiomatic_batch_panel()
{
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
<h2 class="cr_center"><?php echo esc_html__("AI Batch Requests", 'aiomatic-automatic-ai-content-writer');?></h2>
<div class="wrap">
        <nav class="nav-tab-wrapper">
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-3" class="nav-tab"><?php echo esc_html__("Manual Batch File Generator", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-6" class="nav-tab"><?php echo esc_html__("Manage AI Batch Requests", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("Manage AI Batch Request Files", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-1" class="tab-content">
        <br/>
<h3><?php echo esc_html__("What are AI Batch Requests?", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__('The Batch API is a powerful feature of the OpenAI platform that allows you to send asynchronous groups of requests, offering significant cost savings, higher rate limits, and a clear 24-hour turnaround time. This service is ideal for processing jobs that don\'t require immediate responses. You can use the Batch API for tasks such as:', 'aiomatic-automatic-ai-content-writer');?></p>
<ul><li>- <?php echo esc_html__("Running evaluations", 'aiomatic-automatic-ai-content-writer');?></li>
<li>- <?php echo esc_html__("Classifying large datasets", 'aiomatic-automatic-ai-content-writer');?></li>
<li>- <?php echo esc_html__("Embedding content repositories", 'aiomatic-automatic-ai-content-writer');?></li></ul>
<p><?php echo esc_html__("Compared to using standard endpoints directly, the Batch API provides:", 'aiomatic-automatic-ai-content-writer');?></p>
<ul><li>- <?php echo esc_html__("Better cost efficiency: 50% cost discount compared to synchronous APIs", 'aiomatic-automatic-ai-content-writer');?></li>
<li>- <?php echo esc_html__("Higher rate limits: Substantially more headroom compared to the synchronous APIs", 'aiomatic-automatic-ai-content-writer');?></li>
<li>- <?php echo esc_html__("Fast completion times: Each batch completes within 24 hours (and often more quickly)", 'aiomatic-automatic-ai-content-writer');?></li></ul>
<p><?php echo sprintf( wp_kses( __( 'Check details about the Batch API, in <a href="%s" target="_blank">OpenAI\'s official documentation</a> and <a href="%s" target="_blank">FAQ</a>.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://platform.openai.com/docs/guides/batch', 'https://help.openai.com/en/articles/9197833-batch-api-faq' );?></p>
<h3><?php echo esc_html__("How to Use the Batch API", 'aiomatic-automatic-ai-content-writer');?></h3>
<h4><?php echo esc_html__("Step 1: Prepare Your Batch File", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("You can use the 'Manual Batch File Generator' tab to create a .jsonl file which will be able to be uploaded directly to OpenAI and used as a AI Batch Request file.", 'aiomatic-automatic-ai-content-writer');?></p>
<p><?php echo esc_html__("You can also manually create a .jsonl file where each line contains the details of an individual request to the API. Each request must include a unique custom_id value. Here's an example of an input file with 2 requests:", 'aiomatic-automatic-ai-content-writer');?></p>
<code>{"custom_id": "request-1", "method": "POST", "url": "/v1/chat/completions", "body": {"model": "gpt-3.5-turbo-0125", "messages": [{"role": "system", "content": "You are a helpful assistant."},{"role": "user", "content": "Hello world!"}],"max_tokens": 1000}}<br/>
{"custom_id": "request-2", "method": "POST", "url": "/v1/chat/completions", "body": {"model": "gpt-3.5-turbo-0125", "messages": [{"role": "system", "content": "You are an unhelpful assistant."},{"role": "user", "content": "Hello world!"}],"max_tokens": 1000}}</code>
<h4><?php echo esc_html__("Step 2: Upload Your Batch Input File", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("Upload your .jsonl file using the 'Manage AI Batch Request Files' tab of this menu.", 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 3: Create the Batch", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("Use the input File object's ID to create a batch, in the 'Manage AI Batch Requests' tab from this menu.", 'aiomatic-automatic-ai-content-writer');?></p>
<h4><?php echo esc_html__("Step 4: Check the Status of a Batch & Retrieve the Results", 'aiomatic-automatic-ai-content-writer');?></h3>
<p><?php echo esc_html__("You can check the status of a batch at any time. Once the batch is complete, download the output from the 'Manage AI Batch Requests' tab.", 'aiomatic-automatic-ai-content-writer');?></p>
<p><?php echo esc_html__("That's it! You've successfully set up an AI-powered Batch API request, using the Aiomatic plugin.", 'aiomatic-automatic-ai-content-writer');?></p>
<h3><?php echo esc_html__("AI Batch Requests Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
<p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/JqWFhJiyPh8" frameborder="0" allowfullscreen></iframe></div></p>
</div>
<div id="tab-3" class="tab-content">
<br/>
<h2 class="wp-heading-inline"><?php echo esc_html__("Enter Your Data", 'aiomatic-automatic-ai-content-writer');?></h2>
<form id="aiomatic_form_data" class="coderevolution_gutenberg_input" action="" method="post">
    <div class="aiomatic_list_data">
        <div id="aiomatic_legacy_data" class="cr_display_none">
            <div class="aiomatic_data_item_single">
                <div class="cr_center"><strong><?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?></strong></div>
            </div>
            <div id="aiomatic_data_list_batch" class="aiomatic_data_list_batch">
                <div class="aiomatic_data_item_single aiomatic_data">
                    <div>
                        <textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea>
                        <span class="button button-link-delete">&times;</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="aiomatic_gpt_data">
            <div class="aiomatic_data_item">
                <div class="cr_center"><strong><?php echo esc_html__("System", 'aiomatic-automatic-ai-content-writer');?></strong></div>
                <div class="cr_center"><strong><?php echo esc_html__("User", 'aiomatic-automatic-ai-content-writer');?></strong></div>
            </div>
            <div id="aiomatic_new_data_batch_list" class="aiomatic_data_list_batch">
                <div class="aiomatic_data_item aiomatic_new_data_batch">
                    <div>
                        <textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System"></textarea>
                    </div>
                    <div>
                        <textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User"></textarea>
                        <span class="button button-link-delete">&times;</span>
                    </div>
                </div>
            </div>
        </div>
        <button class="button button-primary aiomatic_add_data" type="button"><?php echo esc_html__("Save & Add New", 'aiomatic-automatic-ai-content-writer');?></button><br/><br/>
        <button class="button button-primary aiomatic_clear_data coderevolution_gutenberg_input" type="button"><?php echo esc_html__("Clear Data", 'aiomatic-automatic-ai-content-writer');?></button><br/><br/>
        <button class="button button-primary aiomatic_download_data coderevolution_gutenberg_input" type="button"><?php echo esc_html__("Download Data", 'aiomatic-automatic-ai-content-writer');?></button><br/><br/>
        <button class="button button-primary aiomatic_load_data coderevolution_gutenberg_input"><?php echo esc_html__("Load From File", 'aiomatic-automatic-ai-content-writer');?></button>
        <span class="cr_center coderevolution_block_input"><input type="file" id="aiomatic_file_load" accept=".jsonl,.csv"></span>
    </div>
    <p class="cr_center"><?php echo esc_html__("You can load .csv or .jsonl files.", 'aiomatic-automatic-ai-content-writer');?></p>
    <p class="cr_center"><?php echo esc_html__("TIP: You don't need to add prompt or completition suffixes in the data from above, as the plugin will handle this automatically, it will automatically add to your data the suffixes defined in the plugin's 'Settings' menu.", 'aiomatic-automatic-ai-content-writer');?></p>
    <hr/>
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php echo esc_html__("Purpose", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <select name="purpose">
                    <option value="batch"><?php echo esc_html__("Batch", 'aiomatic-automatic-ai-content-writer');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Model Base", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <select id="model_selector_data_batch" name="model" onchange="aiomatic_batch_data_changed()">
<?php
foreach(AIOMATIC_BATCH_MODELS as $bm)
{
    echo '<option value="' . $bm . '">' . $bm;
    if(in_array($bm, AIOMATIC_EMBEDDINGS_MODELS))
    {
        echo ' (/v1/embeddings)';
    }
    else
    {
        echo ' (/v1/chat/completions)';
    }
    echo '</option>';
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Max Tokens", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="number" min="1" step="1" id="model_max_tokens" name="model_max_tokens" placeholder="<?php echo esc_html__("Maximum token size (optional)", 'aiomatic-automatic-ai-content-writer');?>">
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Custom Name", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="text" name="custom" id="file-name-holder" placeholder="<?php echo esc_html__("File name", 'aiomatic-automatic-ai-content-writer');?>">
            </td>
        </tr>
        </tbody>
    </table>
    <div class="aiomatic-convert-progress aiomatic-convert-bar">
        <span></span>
        <small>0%</small>
    </div>
    <div class="aiomatic-upload-message"></div>
    <button class="button-primary button aiomatic_submit coderevolution_gutenberg_input"><?php echo esc_html__("Upload to OpenAI", 'aiomatic-automatic-ai-content-writer');?></button>
</form>
<form id="aiomatic_upload_convert" class="aiomatic_none" action="" method="post">
    <input type="hidden" name="action" value="aiomatic_upload_convert_batch">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('openai-training-nonce');?>">
    <input type="hidden" id="aiomatic_upload_convert_index" name="index" value="1">
    <input id="aiomatic_upload_convert_line" type="hidden" name="line" value="0">
    <input id="aiomatic_upload_convert_lines" type="hidden" value="0">
    <input type="hidden" name="file" value="">
    <input type="hidden" name="purpose" value="fine-tune">
    <input type="hidden" name="model" value="">
    <input type="hidden" name="custom" value="">
</form>
        </div>
<div id="tab-2" class="tab-content">
<br/>
<?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<hr/>
<h3 class="margin5"><?php echo esc_html__("Upload A New AI Batch Request File (*.jsonl)", 'aiomatic-automatic-ai-content-writer');?></h3>
<div class="aiomatic_form_upload_file">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php echo esc_html__("Select A File To Upload", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="file" id="aiomatic_batch_file_upload" accept=".jsonl">
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
<h3 class="margin5"><?php echo esc_html__("Manage Uploaded AI Batch Request Files", 'aiomatic-automatic-ai-content-writer');?></h3>
<br/><br/>
<button href="javascript:void(0)" id="aiomatic_sync_batch_files" class="page-title-action aiomatic_sync_batch_files"><?php echo esc_html__("Sync Files", 'aiomatic-automatic-ai-content-writer');?></button>&nbsp;
<a href="https://platform.openai.com/storage" target="_blank" id="aiomatic_view_storage" class="page-title-action aiomatic_view_storage"><?php echo esc_html__("View Files On OpenAI", 'aiomatic-automatic-ai-content-writer');?></a>
<table class="wp-list-table widefat fixed striped table-view-list comments" id="aiomatic-batch-files">
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
        <h2><?php echo esc_html__("Manage AI Batch Requests:", 'aiomatic-automatic-ai-content-writer');?></h2>
<br/>
        <button id="aiomatic_manage_batches" class="page-title-action"><?php
        echo esc_html__("Add New AI Batch Request", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_sync_batches" class="page-title-action aiomatic_sync_batches"><?php
        echo esc_html__("Sync All AI Batch Requests With OpenAI", 'aiomatic-automatic-ai-content-writer');
        ?></button>
        <button href="#" id="aiomatic_delete_all_batches" class="page-title-action"><?php
        echo esc_html__("Delete AI Batch Request Local Database", 'aiomatic-automatic-ai-content-writer');
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
$aiomatic_batch_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_batches = new WP_Query(array(
    'post_type' => 'aiomatic_batches',
    'posts_per_page' => 40,
    'paged' => $aiomatic_batch_page,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'any'
));
if($aiomatic_batches->have_posts()){
    echo '<br><br>' . esc_html__('All AI Batch Requests', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_batches->found_posts . ')<br>';
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
        <th scope="col"><a href="<?php echo esc_html($title_url); ?>"><?php
        echo esc_html__("OpenAI ID", 'aiomatic-automatic-ai-content-writer');
        ?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php
        echo esc_html__("Local ID", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');
        ?></th>
        <th scope="col"><?php
        echo esc_html__("Endpoint", 'aiomatic-automatic-ai-content-writer');
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
    if($aiomatic_batches->have_posts())
    {
        foreach ($aiomatic_batches->posts as $aiomatic_batch)
        {
            $status = get_post_meta($aiomatic_batch->ID, '_batch_status', true);
            ?>
            <tr>
                <td><?php echo esc_html($aiomatic_batch->post_title);?></td>
                <td><?php echo esc_html($aiomatic_batch->ID);?></td>
                <td><?php echo '<span '; if($status == 'failed' || $status == 'expired'){ echo 'class="cr_red"';}elseif($status == 'completed'){ echo 'class="cr_green"';}elseif($status == 'cancelled'){ echo 'class="cr_darkyellow"';} echo '>';echo $status;echo '</span>';?></td>
                <td><?php echo get_post_meta($aiomatic_batch->ID, '_batch_endpoint', true);?></td>
                <td><?php echo esc_html($aiomatic_batch->post_date)?></td>
                <td>
                <div class="cr_center">
                <button class="button button-small aiomatic_sync_batch" id="aiomatic_sync_batch_<?php echo $aiomatic_batch->ID;?>" sync-id="<?php echo $aiomatic_batch->ID;?>"><?php echo esc_html__("Sync", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_view_batch" id="aiomatic_view_batch_<?php echo $aiomatic_batch->ID;?>" edit-id="<?php echo $aiomatic_batch->ID;?>"><?php echo esc_html__("Details", 'aiomatic-automatic-ai-content-writer');?></button>
<?php
if($status == 'validating' || $status == 'in_progress')
{
?>
<button class="button button-small button-link-delete aiomatic_cancel_batch" id="aiomatic_cancel_batch_<?php echo $aiomatic_batch->ID;?>" edit-id="<?php echo $aiomatic_batch->ID;?>"><?php echo esc_html__("Cancel", 'aiomatic-automatic-ai-content-writer');?></button>
<?php
}
?>
                </div>
            </td>
            </tr>
            <?php
        }
    }
    else
    {
        echo '<tr><td colspan="6">' . esc_html__("No  AI Batch Requests added. You can add more using the 'Add New Batch Request' button from above.", 'aiomatic-automatic-ai-content-writer') . '</td></tr>';
    }
    ?>
    </tbody>
</table>
<?php
if($aiomatic_batches->have_posts() && $aiomatic_batches->max_num_pages > 1)
{
?>
<div class="aiomatic-paginate">
    <?php
    echo esc_html__("Page: ", 'aiomatic-automatic-ai-content-writer') . paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_batch_panel&wpage=%#%'),
        'total'        => $aiomatic_batches->max_num_pages,
        'current'      => $aiomatic_batch_page,
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

<div id="mymodalfzr" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Add New AI Batch Request", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <form action="#" method="post" id="aiomatic_batches_form">
            <br/>
            <input type="hidden" name="action" value="aiomatic_batches">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('aiomatic_batches');?>">
            <h4><?php echo esc_html__("Input File*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("Add a jsonl file of request inputs for the batch.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-batch-file" name="aiomatic-batch-file" class="aiomatic-full-size">
<?php
if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
{
    echo '<option disabled>' . esc_html__("Azure/Claude API is not currently supported for AI Batch Requests", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    $open_ai = new OpenAi($token);
    if(!$open_ai)
    {
        echo '<option disabled>' . esc_html__("Missing API Setting", 'aiomatic-automatic-ai-content-writer') . '</option>';
    }
    else
    {
        $found = false;
        if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
        {
            $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
        }
        $delay = '';
        if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') 
        {
            if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
            {
                $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
                if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
                {
                    $delay = rand(trim($tempo[0]), trim($tempo[1]));
                }
            }
            else
            {
                if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
                {
                    $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
                }
            }
        }
        if($delay != '' && is_numeric($delay))
        {
            usleep($delay);
        }
        $result = $open_ai->listFiles(array(
            'purpose' => 'batch'
        ));
        $result = json_decode($result);
        if(isset($result->error)){
            $aiomatic_result['msg'] = $result->error->message;
        }
        else
        {
            if(isset($result->data) && is_array($result->data) && count($result->data))
            {
                foreach($result->data as $ind => $rd)
                {
                    if($rd->purpose == 'batch')
                    {
                        echo '<option value="' . esc_attr($rd->id) . '">' . esc_html($rd->filename) . ' (' . esc_html($rd->id) . ')</option>';
                        $found = true;
                    }
                }
            }
        }
        if($found == true)
        {
            echo '<option disabled>' . esc_html__("Please upload files in the 'Manage AI Batch Requests Files' tab to use this option", 'aiomatic-automatic-ai-content-writer') . '</option>';
        }
    }
}
?>
        </select>
            <br/>
            <h4><?php echo esc_html__("Completion Window*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("The time frame within which the batch should be processed.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-completion-window" name="aiomatic-completion-window" class="aiomatic-full-size">
        <option value="24h"><?php echo esc_html__("24 hours", 'aiomatic-automatic-ai-content-writer');?></option>
        </select>
        <br/>
            <h4><?php echo esc_html__("Endpoint*", 'aiomatic-automatic-ai-content-writer');?>:<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
        <div class="bws_hidden_help_text cr_min_260px">
        <?php
            echo esc_html__("The endpoint to be used for all requests in the batch.", 'aiomatic-automatic-ai-content-writer');
            ?>
        </div>
        </div></h4>
        <select autocomplete="off" id="aiomatic-endpoint" name="aiomatic-endpoint" class="aiomatic-full-size">
        <option value="/v1/chat/completions">/v1/chat/completions</option>
        <option value="/v1/embeddings">/v1/embeddings</option>
        </select>
        <br/>
<hr/>
      <button id="aiomatic-batch-save-button" class="button button-primary"><?php echo esc_html__("Add", 'aiomatic-automatic-ai-content-writer');?></button>
   <div class="aiomatic-batch-success"></div>
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
            <h2><span class="cr_color_white"><?php echo esc_html__("View AI Batch Request Details", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <div class="general-batch-holder">

        <div id="batch-detail-page-aiomatic">
            <div class="batch-css-holder">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path d="M13 12a1 1 0 1 0-2 0v4a1 1 0 1 0 2 0v-4Zm-1-2.5A1.25 1.25 0 1 0 12 7a1.25 1.25 0 0 0 0 2.5Z"></path><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2ZM4 12a8 8 0 1 1 16 0 8 8 0 0 1-16 0Z" clip-rule="evenodd"></path></svg>
                    &nbsp;<b class="batch-css-heading"><?php echo esc_html__("Batch Request ID", 'aiomatic-automatic-ai-content-writer');?></b>
                    <br/>
                <span id="batch-id"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                </span>
            </div>
            <div class="batch-css-main">
                <div class="batch-css-flex">
                    <div class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path d="M13 12a1 1 0 1 0-2 0v4a1 1 0 1 0 2 0v-4Zm-1-2.5A1.25 1.25 0 1 0 12 7a1.25 1.25 0 0 0 0 2.5Z"></path><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2ZM4 12a8 8 0 1 1 16 0 8 8 0 0 1-16 0Z" clip-rule="evenodd"></path></svg>
                    &nbsp;<b class="batch-css-heading"><?php echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');?></b></div>
                    <div class="batch-css-status">
                    <div class="batch-css-result"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24" size="14" style="margin-top: 1px;"><path fill-rule="evenodd" d="M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm14.076-4.068a1 1 0 0 1 .242 1.393l-4.75 6.75a1 1 0 0 1-1.558.098l-2.5-2.75a1 1 0 0 1 1.48-1.346l1.66 1.827 4.032-5.73a1 1 0 0 1 1.394-.242Z" clip-rule="evenodd"></path></svg>
                        &nbsp;<span id="batch-status"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?></span></div>
                    </div>
                </div>
                <div class="batch-css-flex">
                <div class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path fill-rule="evenodd" d="M4 12a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm8-10C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2Zm1 5a1 1 0 1 0-2 0v4.586l-2.207 2.207a1 1 0 1 0 1.414 1.414l2.5-2.5A1 1 0 0 0 13 12V7Z" clip-rule="evenodd"></path></svg>
                &nbsp;<b class="batch-css-heading"><?php echo esc_html__("Created at", 'aiomatic-automatic-ai-content-writer');?></b></div>
                    <div class="batch-css-status"><div class="batch-css-result"><span id="batch-created"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?></span></div></div>
                </div>
                <div class="batch-css-flex">
                <div class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path fill-rule="evenodd" d="M12.945 1.17a1 1 0 0 1 .811 1.16l-.368 2.088a1 1 0 1 1-1.97-.347l.369-2.089a1 1 0 0 1 1.158-.811ZM5.85 2.73a1 1 0 0 1 1.393.246L8.39 4.614A1 1 0 1 1 6.751 5.76L5.604 4.123a1 1 0 0 1 .245-1.393Zm3.724 5.328a1 1 0 0 1 1.06-.06l10.244 5.646a1 1 0 0 1 .09 1.695l-1.749 1.225 1.139 1.654a1 1 0 0 1-.25 1.386l-3.282 2.298a1 1 0 0 1-1.393-.246l-1.147-1.638-1.634 1.144a1 1 0 0 1-1.56-.654L9.166 9.04a1 1 0 0 1 .408-.981Zm1.907 2.69 1.322 7.867 1.155-.809a1 1 0 0 1 1.393.246l1.147 1.638 1.65-1.155-1.139-1.655a1 1 0 0 1 .25-1.386l1.248-.873-7.026-3.873ZM1.957 8.865a1 1 0 0 1 1.159-.811l2.089.368a1 1 0 1 1-.348 1.97l-2.089-.369a1 1 0 0 1-.81-1.158Z" clip-rule="evenodd"></path></svg>
                <b class="batch-css-heading">&nbsp;<?php echo esc_html__("Endpoint", 'aiomatic-automatic-ai-content-writer');?></b></div>
                <div class="batch-css-status"><div class="batch-css-result"><span id="batch-endpoint"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                <div class="batch-css-flex">
                    <div class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path fill-rule="evenodd" d="M5 6a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h9.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414-1.414L16.586 14H7a3 3 0 0 1-3-3V7a1 1 0 0 1 1-1Z" clip-rule="evenodd"></path></svg>
                    <b class="batch-css-heading">&nbsp;<?php echo esc_html__("Finishing time", 'aiomatic-automatic-ai-content-writer');?></b></div>
                    <div class="batch-css-status"><div class="batch-css-result">
                    <span id="batch-window"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                <div class="batch-css-flex">
                    <div class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path fill-rule="evenodd" d="M11.33 5a1 1 0 0 0-1 1v13h3.33V6a1 1 0 0 0-1-1h-1.33Zm4.33 14H18a1 1 0 0 0 1-1v-8a1 1 0 0 0-1-1h-2.34v10Zm0-12V6a3 3 0 0 0-3-3h-1.33a3 3 0 0 0-3 3v5H6a3 3 0 0 0-3 3v4a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3h-2.34Zm-7.33 6H6a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h2.33v-6Z" clip-rule="evenodd"></path></svg>
                    <b class="batch-css-heading">&nbsp;<?php echo esc_html__("Request counts", 'aiomatic-automatic-ai-content-writer');?></b></div>
                    <div class="batch-css-status"><div class="batch-css-result"><span id="batch-counts"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                <hr class="css-1wozfos">
                <div class="batch-css-files">
                <div class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path fill-rule="evenodd" d="M7 2a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V8.828a3 3 0 0 0-.879-2.12l-3.828-3.83A3 3 0 0 0 13.172 2H7Zm5 2H7a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-9h-3a3 3 0 0 1-3-3V4Zm5.586 4H15a1 1 0 0 1-1-1V4.414L17.586 8Z" clip-rule="evenodd"></path></svg>
                    <b class="batch-css-heading">&nbsp;<?php echo esc_html__("Files", 'aiomatic-automatic-ai-content-writer');?></b>
                </div>
                <div class="batch-css-flex">
                    <b class="batch-css-heading"><?php echo esc_html__("Input", 'aiomatic-automatic-ai-content-writer');?></b>
                    <div class="batch-css-status"><div class="batch-css-result"><span id="batch-input-file"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                </div>
                <div class="batch-css-files">
                <div class="batch-css-flex">
                    <b class="batch-css-heading"><?php echo esc_html__("Output", 'aiomatic-automatic-ai-content-writer');?></b>
                    <div class="batch-css-status"><div class="batch-css-result"><span id="batch-output-file"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                </div>
                <div class="batch-css-files">
                <div class="batch-css-flex">
                    <b class="batch-css-heading"><?php echo esc_html__("Error", 'aiomatic-automatic-ai-content-writer');?></b>
                    <div class="batch-css-status"><div class="batch-css-result"><span id="batch-error-file"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                </div>
                <hr class="css-1wozfos">
                <div class="batch-css-files">
                    <b class="batch-css-heading"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" size="12"><path fill-rule="evenodd" d="M4 12a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm8-10C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2Zm1 5a1 1 0 1 0-2 0v4.586l-2.207 2.207a1 1 0 1 0 1.414 1.414l2.5-2.5A1 1 0 0 0 13 12V7Z" clip-rule="evenodd"></path></svg>
                &nbsp;<?php echo esc_html__("Batch Timeline", 'aiomatic-automatic-ai-content-writer');?></b>
                    <div class="batch-css-status"><div class="batch-css-result"><span id="batch-timeline-wrapper"><?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
                    </span></div></div>
                </div>
                <div>
                    <span id="batch-failed-report"></span>
                </div>
            </div>
        </div>
        </div>
   <div class="aiomatic-batch-success"></div>
   <br/>
</div>
            </div>
        </div>  
    </div>

    <div id="mymodalfzr-parse" class="codemodalfzr">
    <div class="codemodalfzr-content">
        <div class="codemodalfzr-header">
            <span id="aiomatic_close-parse" class="codeclosefzr">&times;</span>
            <h2><span class="cr_color_white"><?php echo esc_html__("Parse Batch Results", 'aiomatic-automatic-ai-content-writer');?></span></h2>
        </div>
        <div class="codemodalfzr-body">
        <div class="table-responsive">
        <div class="general-parsing-batch-holder">

        <div id="batch-parsing-detail-page-aiomatic">
            <div id="aiomatic-batch-result-parsed" class="aiomatic-batch-result-parsed">
            <?php echo esc_html__("Loading...", 'aiomatic-automatic-ai-content-writer');?>
            </div>
        </div>
        </div>
   <div class="aiomatic-batch-success"></div>
   <br/>
</div>
            </div>
        </div>  
    </div>





</div>
<?php
}
?>