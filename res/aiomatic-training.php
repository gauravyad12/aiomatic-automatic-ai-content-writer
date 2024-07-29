<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function aiomatic_openai_training()
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
<h2 class="cr_center"><?php echo esc_html__("AI Model Training", 'aiomatic-automatic-ai-content-writer');?></h2>
<div class="wrap">
        <nav class="nav-tab-wrapper">
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Step 0: Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("Step 1a: Dataset Uploader", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-3" class="nav-tab"><?php echo esc_html__("Step 1b: Dataset Manual Entry", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-4" class="nav-tab"><?php echo esc_html__("Step 1c: Dataset Converter", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-5" class="nav-tab"><?php echo esc_html__("Step 2: Datasets", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-6" class="nav-tab"><?php echo esc_html__("Step 3: Model Finetunes", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-1" class="tab-content">
         <br/>
         <h3><?php echo esc_html__("What is fine-tuning in GPT-3?", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p><?php echo esc_html__("Fine-tuning in GPT-3 is the process of adjusting a specific AI model and its parameters to better suit a specific task. This can be done by providing GPT-3 with a data set that is tailored to the task you need. For example, if you want to create a chatbot which replies similar to questions similar to Rick, from \"Rick and Morty\", this feature is what you need.", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("When fine-tuning a model, it's important to keep a few things in mind, such as the quality of the data set and the parameters of the model that will be adjusted. Additionally, it's important to monitor the performance of the model during and after fine-tuning.", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("Lets say you would like to train your AI to answer specific questions about your website content, company, product or anything else. You can achieve this by fine-tuning a model using your own data! Please note, this process requires a lot of effort. Preparing a high quality data is the key here. And you need to do a lot of testing to achieve best results!", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("If you are looking for a quick way to customize the AI content writer and to teach it some info about your company, I suggest you check the", 'aiomatic-automatic-ai-content-writer');?> <a href="<?php echo admin_url('admin.php?page=aiomatic_embeddings_panel');?>"><?php echo esc_html__("Embeddings", 'aiomatic-automatic-ai-content-writer');?></a> <?php echo esc_html__("feature of the plugin", 'aiomatic-automatic-ai-content-writer');?>.</p>
         <h3><?php echo esc_html__("More about fine tuning", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p><b><?php echo esc_html__("The main steps of fine-tuning are", 'aiomatic-automatic-ai-content-writer');?>:</b></p>
         <ol><li><b><?php echo esc_html__("Step 0: Read this tutorial carefully and watch the tutorial video", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("be sure to not skip this step! Also, be sure to be clear with", 'aiomatic-automatic-ai-content-writer');?> <a href="https://openai.com/api/pricing/" target="_blank"><?php echo esc_html__("OpenAI's pricing", 'aiomatic-automatic-ai-content-writer');?></a> <?php echo esc_html__("for usage of fine tuned models", 'aiomatic-automatic-ai-content-writer');?>.</li>
         <li><b><?php echo esc_html__("Step 1: Create your data for fine-tuning", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("create as many high quality questions and answers as possible, containing as much useful information you can think of, which can teach the AI about the purpose of your finetune. Keep in mind that you might need to create very large amounts of data (tens of tousands of questions and answers) for this to work as expected.", 'aiomatic-automatic-ai-content-writer');?>
        <br/><br/><?php echo esc_html__("Here are some options you have, to help create the data for fine-tuning (select the one that best fits your needs)", 'aiomatic-automatic-ai-content-writer');?>: 
            <ul>
                <li>
                <i>- <?php echo esc_html__("Step 1a: Dataset Uploader", 'aiomatic-automatic-ai-content-writer');?>:</i> <?php echo esc_html__("if you alread have your data ready in the required format (JSONL file), you will be able to directly upload it to OpenAI. Be sure to select the base model for which you want to create a fine tune, from the 'Model Base' dropdown list, because you decide at this step for which model you want to create a fine tune with the uploaded data. To upload larger datasets, your WordPress maximum file upload size setting should be set to at least the file size you want to upload. You can follow", 'aiomatic-automatic-ai-content-writer');?> <a href="https://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" target="_blank"><?php echo esc_html__("this guide", 'aiomatic-automatic-ai-content-writer');?></a> <?php echo esc_html__("to achieve this. The uploaded file must contain prompt and completion pairs. The \"prompt\" part is the question and the \"completion\" part is the answer. You can find an example file", 'aiomatic-automatic-ai-content-writer');?> <a href="https://coderevolution.ro/ai/data.jsonl" target="_blank"><?php echo esc_html__("here", 'aiomatic-automatic-ai-content-writer');?></a>. <?php echo esc_html__("To convert files to JSONL format, you can use the", 'aiomatic-automatic-ai-content-writer');?> <a href="https://platform.openai.com/docs/guides/fine-tuning/cli-data-preparation-tool" target="_blank"><?php echo esc_html__("CLI Data Preparation Tool", 'aiomatic-automatic-ai-content-writer');?></a> <?php echo esc_html__("from OpenAI.", 'aiomatic-automatic-ai-content-writer');?>
                </li>
                <li>
                <i>- <?php echo esc_html__("Step 1b: Dataset Manual Entry", 'aiomatic-automatic-ai-content-writer');?>:</i> <?php echo esc_html__("if not, you can start entering your data into the plugin. To avoid losing your work, this data is kept in your browser's local storage. This is actually complex, so learn how to write datasets by studying", 'aiomatic-automatic-ai-content-writer');?> <a href="https://platform.openai.com/docs/guides/fine-tuning/conditional-generation" target="_blank"><?php echo esc_html__("case studies from OpenAI", 'aiomatic-automatic-ai-content-writer');?></a>. <?php echo esc_html__("Here you can also download your data or directly upload it to OpenAI for usage. Useful tip: to gather your data, start by collecting info about your website pages, content, and any ideas you have in your mind. Try to create a file, or several files, without any HTML formatting or other unnecessary elements. If you have access to ChatGPT, use it to generate a large number of questions and answers based on your content. Gather the data in a Google Sheet with the two columns, and make sure to review and perfect it. A dataset should have a minimum of 500 rows to offer useful results, and much more if you want to achieve better results. According to the OpenAI documentation, above 3,000 rows are recommended. But it ultimately depends on what you're trying to achieve. Be sure to select the base model for which you want to create a fine tune, from the 'Model Base' dropdown list, because you decide at this step for which model you want to create a fine tune with the uploaded data. Check OpenAI's recommendations for fine tuning,", 'aiomatic-automatic-ai-content-writer');?> <a href="https://platform.openai.com/docs/guides/fine-tuning/preparing-your-dataset" target="_blank"><?php echo esc_html__("here", 'aiomatic-automatic-ai-content-writer');?></a>.
                </li><li>
                <i>- <?php echo esc_html__("Step 1c: Dataset Converter", 'aiomatic-automatic-ai-content-writer');?>:</i> <?php echo esc_html__("this is a tool which is designed to colect information from your pages, posts or products and to create datasets from them. This can be useful if you want to train a new model to be more knowledgeable of your website's content. The tool will set the post/page/product title as the \"question\" and the content as the \"answer\". You can download the resulting files and upload them using the 'Dataset Uploader' tab.", 'aiomatic-automatic-ai-content-writer');?>
                </li>
            </ul></li>
        <li><b><?php echo esc_html__("Step 2: Start training your model", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("after data upload is complete, go to the 'Datasets' tab of this plugin, search for the file you uploaded (be sure to sync files) and click 'Create Fine-Tune' for it. In the popup which appears, select 'New Model' if you want to create a new fine tune, or select any existing finetuned models, to create a new finetune based on that existing finetuned model. This process will take some time, for a dataset of 500 rows, it typically takes around 20 minutes.", 'aiomatic-automatic-ai-content-writer');?></li>
        <li><b><?php echo esc_html__("Step 3: Check progress of the fine tune", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("after finetune creation is complete, go to the 'Model Finetunes' tab and check the finetune you created. Be sure to sync finetunes. Wait until the finetune is listed with status 'succeeded', after which, it will appear also in the plugin and can be directly selected, when selecting the models which you want to use for data creation in the plugin! If you don't see your fine-tuned model in the dropdown list, please make sure that the fine-tune request is complete. You can also click on \"Sync Models\" link to get latest models.", 'aiomatic-automatic-ai-content-writer');?></li>
    </ol>
    <p><?php echo esc_html__("Please note, I can not guarantee that the fine-tuned model will work well for your use case. As I mentioned before, dataset quality is very important. If you have a small dataset, you might not get good results. If you have a very large dataset with really well-defined prompt and completion pairs, you should get good results.", 'aiomatic-automatic-ai-content-writer');?></p>
         <h3><?php echo esc_html__("Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/MV5F2X6z_X4" frameborder="0" allowfullscreen></iframe></div></p>
         </div>
        <div id="tab-2" class="tab-content">
         <br/>
<?php
$fileTypes = array(
'fine-tune' => 'Fine-Tune',
//'answers' => 'Answers',
//'search' => 'Search',
//'classifications' => 'Classifications'
);
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<h1 class="wp-heading-inline"><?php echo esc_html__("Upload A New File", 'aiomatic-automatic-ai-content-writer');?></h1>
<div class="aiomatic_form_upload_file">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php echo esc_html__("Dataset (*.jsonl)", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="file" id="aiomatic_file_upload" accept=".jsonl">
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Purpose", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <select id="aiomatic_file_purpose">
                    <?php
                    foreach ($fileTypes as $key=>$fileType){
                        echo '<option value="'.esc_html($key).'">'.esc_html($fileType).'</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Model Base", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <select id="aiomatic_file_model">
<?php
foreach(AIOMATIC_TRAINING_MODELS as $bm)
{
    echo '<option value="' . $bm . '"';
    if($bm == 'davinci-002')
    {
        echo ' selected';
    }
    echo '>' . $bm . '</option>';
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Custom Model Name", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="text" class="regular-text" id="aiomatic_file_name" placeholder="<?php echo esc_html__("Your model name", 'aiomatic-automatic-ai-content-writer');?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="aiomatic_upload_success aiomatic_none margin5 colorgr"><?php echo esc_html__("File uploaded successfully you can view it in Datasets tab.", 'aiomatic-automatic-ai-content-writer');?></div>
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
                    <?php echo esc_html__("(Please increase this value if you want to upload larger datasets)", 'aiomatic-automatic-ai-content-writer');?>
                    <?php
                }
                ?></p> 
    <p class="cr_center"><?php echo esc_html__("TIP: Check more details on training prompt design recommendations,", 'aiomatic-automatic-ai-content-writer');?> <a href="https://platform.openai.com/docs/guides/fine-tuning/preparing-your-dataset" target="_blank">here</a>.</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
        </div>
        <div id="tab-3" class="tab-content">
        <br/>
<h1 class="wp-heading-inline"><?php echo esc_html__("Enter Your Data", 'aiomatic-automatic-ai-content-writer');?></h1>
<form id="aiomatic_form_data" class="coderevolution_gutenberg_input" action="" method="post">
    <div class="aiomatic_list_data">
        <div id="aiomatic_legacy_data">
            <div class="aiomatic_data_item">
                <div class="cr_center"><strong><?php echo esc_html__("Prompt", 'aiomatic-automatic-ai-content-writer');?></strong></div>
                <div class="cr_center"><strong><?php echo esc_html__("Completion", 'aiomatic-automatic-ai-content-writer');?></strong></div>
            </div>
            <div id="aiomatic_data_list" class="aiomatic_data_list">
                <div class="aiomatic_data_item aiomatic_data">
                    <div>
                        <textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea>
                    </div>
                    <div>
                        <textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion"></textarea>
                        <span class="button button-link-delete">&times;</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="aiomatic_gpt_data" class="cr_display_none">
            <div class="aiomatic_new_data_item">
                <div class="cr_center"><strong><?php echo esc_html__("System", 'aiomatic-automatic-ai-content-writer');?></strong></div>
                <div class="cr_center"><strong><?php echo esc_html__("User", 'aiomatic-automatic-ai-content-writer');?></strong></div>
                <div class="cr_center"><strong><?php echo esc_html__("Assistant", 'aiomatic-automatic-ai-content-writer');?></strong></div>
            </div>
            <div id="aiomatic_new_data_list" class="aiomatic_data_list">
                <div class="aiomatic_new_data_item aiomatic_new_data">
                    <div>
                        <textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System"></textarea>
                    </div>
                    <div>
                        <textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User"></textarea>
                    </div>
                    <div>
                        <textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant"></textarea>
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
                    <option value="fine-tune"><?php echo esc_html__("Fine-Tune", 'aiomatic-automatic-ai-content-writer');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo esc_html__("Model Base", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <select id="model_selector_data_training" name="model" onchange="aiomatic_training_data_changed()">
                <?php
foreach(AIOMATIC_TRAINING_MODELS as $bm)
{
    echo '<option value="' . $bm . '"';
    if($bm == 'davinci-002')
    {
        echo ' selected';
    }
    echo '>' . $bm . '</option>';
}
?>
                </select>
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
    <input type="hidden" name="action" value="aiomatic_upload_convert">
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
        <div id="tab-4" class="tab-content">
        <br/>
        <?php
global $wpdb;
$aiomatic_files_page1 = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_files_per_page = 20;
$aiomatic_files_offset = ( $aiomatic_files_page1 * $aiomatic_files_per_page ) - $aiomatic_files_per_page;
$aiomatic_files_count_sql = "SELECT COUNT(*) FROM ".$wpdb->posts." f WHERE f.post_type='aiomatic_convert' AND f.post_status='publish'";
$aiomatic_files_sql = "SELECT f.* FROM ".$wpdb->posts." f WHERE f.post_type='aiomatic_convert' AND f.post_status='publish' ORDER BY f.post_date DESC LIMIT ".$aiomatic_files_offset.",".$aiomatic_files_per_page;
$aiomatic_files = $wpdb->get_results($aiomatic_files_sql);
$aiomatic_files_total = $wpdb->get_var( $aiomatic_files_count_sql );
?>
<h1 class="wp-heading-inline"><?php echo esc_html__("Data Converter", 'aiomatic-automatic-ai-content-writer');?></h1>
<form id="aiomatic_data_converter" method="post" action="">
    <input type="hidden" name="action" value="aiomatic_data_converter_count">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('openai-training-nonce');?>">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php echo esc_html__("Select Data", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <label><input id="aiomatic_posts" class="aiomatic_converter_data" checked type="checkbox" name="data[]" value="post"> <?php echo esc_html__("Posts", 'aiomatic-automatic-ai-content-writer');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label><input id="aiomatic_pages" class="aiomatic_converter_data" type="checkbox" name="data[]" value="page"> <?php echo esc_html__("Pages", 'aiomatic-automatic-ai-content-writer');?></label>
                <?php
                if(in_array('product',get_post_types()) && class_exists( 'woocommerce' )):
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input class="aiomatic_converter_data" id="aiomatic_products" type="checkbox" name="data[]" value="product"> <?php echo esc_html__("Products", 'aiomatic-automatic-ai-content-writer');?></label>
                <?php
                endif;
                ?>
            </td>
        </tr>
        <tr>
        <th scope="row"><?php echo esc_html__("Post Category to Process", 'aiomatic-automatic-ai-content-writer');?></th>
        <td>
        <select id="category" name="category" class="cr_width_full">
        <option value="" disabled selected><?php echo esc_html__("Select a Category (Optional)", 'aiomatic-automatic-ai-content-writer');?></option>
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
            <th scope="row"><?php echo esc_html__("Import Content or Excerpt", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
            <input type="radio" id="post_excerpt" name="content_excerpt" value="post_excerpt" checked>
            <label for="post_excerpt"><?php echo esc_html__("Excerpt", 'aiomatic-automatic-ai-content-writer');?></label>
            <input type="radio" id="post_content" name="content_excerpt" value="post_content">
            <label for="post_content"><?php echo esc_html__("Content", 'aiomatic-automatic-ai-content-writer');?></label><br>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <div class="aiomatic-convert-progress aiomatic-convert-bar coderevolution_gutenberg_input">
                    <span></span>
                    <small>0%</small>
                </div>
                <button class="button-primary button aiomatic_converter_button"><?php echo esc_html__("Convert", 'aiomatic-automatic-ai-content-writer');?></button>
            </td>
        </tr>
        </tbody>
    </table>
</form>
<h1 class="wp-heading-inline"><?php echo esc_html__("Completed Conversions", 'aiomatic-automatic-ai-content-writer');?></h1>
<table class="wp-list-table widefat fixed striped table-view-list comments">
    <thead>
    <tr>
        <th><?php echo esc_html__("Filename", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Started", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Completed", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Size", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Action", 'aiomatic-automatic-ai-content-writer');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($aiomatic_files && is_array($aiomatic_files) && count($aiomatic_files))
    {
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        foreach($aiomatic_files as $aiomatic_file)
        {
            $file = wp_upload_dir()['basedir'].'/'.$aiomatic_file->post_title;
            if($wp_filesystem->exists($file))
            {

        ?>
        <tr>
            <td><?php echo esc_html($aiomatic_file->post_title);?></td>
            <td><?php echo date('d.m.Y H:i',strtotime($aiomatic_file->post_date));?></td>
            <td><?php echo date('d.m.Y H:i',strtotime($aiomatic_file->post_modified));?></td>
            <td><?php echo size_format(filesize($file));?></td>
            <td>
                <a class="button button-small" href="<?php echo wp_upload_dir()['baseurl'].'/'.esc_html($aiomatic_file->post_title)?>" download>Download</a>
                <button class="button button-small aiomatic_convert_upload" data-lines="<?php echo esc_html(count(file($file)))?>" data-file="<?php echo esc_html($aiomatic_file->post_title)?>">Upload</button>
                <button class="button button-small aiomatic_delete_upload" data-lines="<?php echo esc_html(count(file($file)))?>" data-file="<?php echo esc_html($aiomatic_file->post_title)?>">Delete</button>
            </td>
        </tr>
        <?php
            }
        }
    }
    ?>
    </tbody>
</table>
<div class="aiomatic-paginate mb-5">
    <?php
    echo paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_openai_training&wpage=%#%'),
        'total'        => ceil($aiomatic_files_total / $aiomatic_files_per_page),
        'current'      => $aiomatic_files_page1,
        'format'       => '?wpaged=%#%',
        'show_all'     => false,
        'prev_next'    => false,
        'add_args'     => false,
    ));
    ?>
</div>
        </div>
        <div id="tab-5" class="tab-content">
        <br/>
        <?php
$aiomatic_files_page2 = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_files_per_page = 20;
$aiomatic_files_offset = ( $aiomatic_files_page2 * $aiomatic_files_per_page ) - $aiomatic_files_per_page;
$aiomatic_files_count_sql = "SELECT COUNT(*) FROM ".$wpdb->posts." f WHERE f.post_type='aiomatic_file' AND (f.post_status='publish' OR f.post_status = 'future')";
$aiomatic_files_sql = "SELECT f.*
       ,(SELECT fn.meta_value FROM ".$wpdb->postmeta." fn WHERE fn.post_id=f.ID AND fn.meta_key='aiomatic_filename') as filename 
       ,(SELECT fp.meta_value FROM ".$wpdb->postmeta." fp WHERE fp.post_id=f.ID AND fp.meta_key='aiomatic_purpose') as purpose 
       ,(SELECT fm.meta_value FROM ".$wpdb->postmeta." fm WHERE fm.post_id=f.ID AND fm.meta_key='aiomatic_model') as model 
       ,(SELECT fc.meta_value FROM ".$wpdb->postmeta." fc WHERE fc.post_id=f.ID AND fc.meta_key='aiomatic_custom_name') as custom_name 
       ,(SELECT fs.meta_value FROM ".$wpdb->postmeta." fs WHERE fs.post_id=f.ID AND fs.meta_key='aiomatic_file_size') as file_size 
       ,(SELECT ft.meta_value FROM ".$wpdb->postmeta." ft WHERE ft.post_id=f.ID AND ft.meta_key='aiomatic_fine_tune') as finetune 
       FROM ".$wpdb->posts." f WHERE f.post_type='aiomatic_file' AND (f.post_status='publish' OR f.post_status = 'future') ORDER BY f.post_date DESC LIMIT ".$aiomatic_files_offset.",".$aiomatic_files_per_page;
$aiomatic_files = $wpdb->get_results($aiomatic_files_sql);
$aiomatic_files_total = $wpdb->get_var( $aiomatic_files_count_sql );
?>
<h1 class="wp-heading-inline">Files</h1>
<button href="javascript:void(0)" id="aiomatic_sync_files" class="page-title-action aiomatic_sync_files"><?php echo esc_html__("Sync Files", 'aiomatic-automatic-ai-content-writer');?></button>&nbsp;
<a href="https://platform.openai.com/storage" target="_blank" id="aiomatic_view_storage" class="page-title-action aiomatic_view_storage"><?php echo esc_html__("View Files On OpenAI", 'aiomatic-automatic-ai-content-writer');?></a><br><br>
<?php
if($aiomatic_files_total > 0){
    echo esc_html__('All files', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_files_total . ')<br>';
}
?>
<table class="wp-list-table widefat fixed striped table-view-list comments">
    <thead>
    <tr>
        <th><?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?></th>
        <th class="width50p"><?php echo esc_html__("Size", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Model", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Created At", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Filename", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Purpose", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Action", 'aiomatic-automatic-ai-content-writer');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($aiomatic_files && is_array($aiomatic_files) && count($aiomatic_files)):
        foreach($aiomatic_files as $aiomatic_file):
            if(!isset($fileTypes[$aiomatic_file->purpose]))
            {
                continue;
            }
            ?>
            <tr>
                <td><?php echo esc_html($aiomatic_file->post_title)?></td>
                <td><?php echo esc_html(size_format($aiomatic_file->file_size))?></td>
                <td><?php echo esc_html($aiomatic_file->model)?></td>
                <td><?php echo esc_html($aiomatic_file->post_date)?></td>
                <td><?php echo esc_html($aiomatic_file->filename)?></td>
                <td><?php 
                if(isset($fileTypes[$aiomatic_file->purpose]))
                {
                    echo !empty($aiomatic_file->purpose) ? esc_html($fileTypes[$aiomatic_file->purpose]) : 'Fine-Tune';
                }?></td>
                <td>
                    <?php
                    //if(empty($aiomatic_file->finetune) && $aiomatic_file->purpose == 'fine-tune'):
                    ?>
                    <button data-id="<?php echo esc_html($aiomatic_file->ID);?>" class="button button-small aiomatic_create_fine_tune"><?php echo esc_html__("Create Fine-Tune", 'aiomatic-automatic-ai-content-writer');?></button>
                    <?php
                    //endif;
                    ?>
                    <button data-id="<?php echo esc_html($aiomatic_file->ID);?>" class="button button-small aiomatic_retrieve_content"><?php echo esc_html__("Retrieve Content", 'aiomatic-automatic-ai-content-writer');?></button>
                    <button data-id="<?php echo esc_html($aiomatic_file->ID);?>" class="button button-small button-link-delete aiomatic_delete_file"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
                </td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>
<div class="aiomatic-paginate mb-5">
    <?php
    echo paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_openai_training&wpage=%#%'),
        'total'        => ceil($aiomatic_files_total / $aiomatic_files_per_page),
        'current'      => $aiomatic_files_page2,
        'format'       => '?wpaged=%#%',
        'show_all'     => false,
        'prev_next'    => false,
        'add_args'     => false,
    ));
    ?>
</div>
        </div>
        <div id="tab-6" class="tab-content">
        <br/>
        <?php
$aiomatic_files_page3 = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_files_per_page = 10;
$aiomatic_files_offset = ( $aiomatic_files_page3 * $aiomatic_files_per_page ) - $aiomatic_files_per_page;
$aiomatic_files_count_sql = "SELECT COUNT(*) FROM ".$wpdb->posts." f WHERE f.post_type='aiomatic_finetune' AND (f.post_status='publish' OR f.post_status = 'future')";
$aiomatic_files_sql = "SELECT f.*
       ,(SELECT fn.meta_value FROM ".$wpdb->postmeta." fn WHERE fn.post_id=f.ID AND fn.meta_key='aiomatic_model' LIMIT 1) as model 
       ,(SELECT fp.meta_value FROM ".$wpdb->postmeta." fp WHERE fp.post_id=f.ID AND fp.meta_key='aiomatic_updated_at' LIMIT 1) as updated_at 
       ,(SELECT fm.meta_value FROM ".$wpdb->postmeta." fm WHERE fm.post_id=f.ID AND fm.meta_key='aiomatic_name' LIMIT 1) as ft_model 
       ,(SELECT fc.meta_value FROM ".$wpdb->postmeta." fc WHERE fc.post_id=f.ID AND fc.meta_key='aiomatic_org' LIMIT 1) as org_id 
       ,(SELECT fs.meta_value FROM ".$wpdb->postmeta." fs WHERE fs.post_id=f.ID AND fs.meta_key='aiomatic_status' LIMIT 1) as ft_status 
       ,(SELECT ft.meta_value FROM ".$wpdb->postmeta." ft WHERE ft.post_id=f.ID AND ft.meta_key='aiomatic_fine_tune' LIMIT 1) as finetune 
       ,(SELECT fd.meta_value FROM ".$wpdb->postmeta." fd WHERE fd.post_id=f.ID AND fd.meta_key='aiomatic_deleted' LIMIT 1) as deleted 
       FROM ".$wpdb->posts." f WHERE f.post_type='aiomatic_finetune' AND (f.post_status='publish' OR f.post_status = 'future') ORDER BY f.post_date DESC LIMIT ".$aiomatic_files_offset.",".$aiomatic_files_per_page;
$aiomatic_files = $wpdb->get_results($aiomatic_files_sql);
$aiomatic_files_total = $wpdb->get_var( $aiomatic_files_count_sql );
?>
<h1 class="wp-heading-inline"><?php echo esc_html__("Fine-tunes", 'aiomatic-automatic-ai-content-writer');?></h1>
<button href="javascript:void(0)" id="aiomatic_sync_finetunes" class="page-title-action aiomatic_sync_finetunes"><?php echo esc_html__("Sync Fine-tunes", 'aiomatic-automatic-ai-content-writer');?></button>&nbsp;
<a href="https://platform.openai.com/finetune" target="_blank" id="aiomatic_view_finetunes" class="page-title-action aiomatic_view_finetunes"><?php echo esc_html__("View Fine-tunes On OpenAI", 'aiomatic-automatic-ai-content-writer');?></a><br><br>
<?php
if($aiomatic_files_total > 0){
    echo esc_html__('All fine-tunes', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_files_total . ')<br>';
}
?>
<table class="wp-list-table widefat fixed striped table-view-list comments">
    <thead>
    <tr>
        <th><?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Object", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Model", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Created At", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Fine-tune Model", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Organization ID", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Status", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Updated", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Training", 'aiomatic-automatic-ai-content-writer');?></th>
        <th><?php echo esc_html__("Action", 'aiomatic-automatic-ai-content-writer');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($aiomatic_files && is_array($aiomatic_files) && count($aiomatic_files)):
        foreach($aiomatic_files as $aiomatic_file):
            ?>
        <tr>
            <td><?php echo esc_html($aiomatic_file->post_title);?></td>
            <td>fine-tune</td>
            <td><?php echo esc_html($aiomatic_file->model);?></td>
            <td><?php echo esc_html($aiomatic_file->post_date);?></td>
            <td><?php echo esc_html($aiomatic_file->ft_model);?></td>
            <td><?php echo esc_html($aiomatic_file->org_id);?></td>
            <td class="aiomatic-finetune-<?php echo !$aiomatic_file->deleted ? esc_html($aiomatic_file->ft_status) : 'deleted';?>"><?php echo !$aiomatic_file->deleted ? esc_html($aiomatic_file->ft_status) : 'Deleted';if($aiomatic_file->ft_status == 'succeeded'){echo '<div class="tool" data-tip="This model will be available for use in the plugin, as a custom model!">&nbsp;&#9072;</div>';}?></td>
            <td><?php echo esc_html($aiomatic_file->updated_at);?></td>
            <td>
                <a class="aiomatic_get_other button button-small" data-id="<?php echo esc_html($aiomatic_file->ID);?>" data-type="events" href="javascript:void(0)"><?php echo esc_html__("Events", 'aiomatic-automatic-ai-content-writer');?></a><br>
                <a class="aiomatic_get_other button button-small mb-5" data-id="<?php echo esc_html($aiomatic_file->ID);?>" data-type="hyperparameters" href="javascript:void(0)"><?php echo esc_html__("Hyper-params", 'aiomatic-automatic-ai-content-writer');?></a><br>
                <a class="aiomatic_get_other button button-small mb-5" data-id="<?php echo esc_html($aiomatic_file->ID);?>" data-type="result_files" href="javascript:void(0)"><?php echo esc_html__("Result files", 'aiomatic-automatic-ai-content-writer');?></a><br>
                <a class="aiomatic_get_other button button-small mb-5" data-id="<?php echo esc_html($aiomatic_file->ID);?>" data-type="training_file" href="javascript:void(0)"><?php echo esc_html__("Training-files", 'aiomatic-automatic-ai-content-writer');?></a><br>
            </td>
            <td>
                <?php
                if(!$aiomatic_file->deleted):
                    if($aiomatic_file->ft_status == 'pending'):
                    ?>
                <a class="aiomatic_cancel_finetune button button-small button-link-delete" data-id="<?php echo esc_html($aiomatic_file->ID);?>" href="javascript:void(0)"><?php echo esc_html__("Cancel", 'aiomatic-automatic-ai-content-writer');?></a><br>
                <?php
                    endif;
                    if(!empty($aiomatic_file->ft_model)):
                ?>
                <a class="aiomatic_delete_finetune button button-small button-link-delete" data-id="<?php echo esc_html($aiomatic_file->ID);?>" href="javascript:void(0)"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></a><br>
                <?php
                    endif;
                endif;
                ?>
            </td>
        </tr>
            <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>
<div class="aiomatic-paginate mb-5">
    <?php
    echo paginate_links( array(
        'base'         => admin_url('admin.php?page=aiomatic_openai_training&wpage=%#%'),
        'total'        => ceil($aiomatic_files_total / $aiomatic_files_per_page),
        'current'      => $aiomatic_files_page3,
        'format'       => '?wpaged=%#%',
        'show_all'     => false,
        'prev_next'    => false,
        'add_args'     => false,
    ));
    ?>
</div>
        </div>
    </div>
</div>
<?php
}
?>