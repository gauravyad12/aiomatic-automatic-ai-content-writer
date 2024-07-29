<?php
function aiomatic_embeddings_panel()
{
   $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
   if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
   {
?>
<h1><?php echo esc_html__("You must add an OpenAI/AiomaticAPI API Key into the plugin's 'Settings' menu before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
   if ((!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') && (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == ''))
   {
?>
<h1><?php echo esc_html__("You must add a Pinecone API or a Qdrant API key in the plugin's 'Settings' menu (API Keys tab), before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
   if ((!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') && (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == ''))
   {
?>
<h1><?php echo esc_html__("You must add a Pinecone or a Qdrant index in the plugin's 'Settings' menu (Embeddings tab), before you can use this feature!", 'aiomatic-automatic-ai-content-writer');?></h1>
<?php
return;
   }
?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<h2 class="cr_center"><?php echo esc_html__("Aiomatic Embeddings", 'aiomatic-automatic-ai-content-writer');?></h2>

</div>
<div class="wrap gs_popuptype_holder">
        <h1><?php echo esc_html__("Embeddings", 'aiomatic-automatic-ai-content-writer');?></h1>
        <nav class="nav-tab-wrapper">
            <a href="#tab-0" class="nav-tab"><?php echo esc_html__("Tutorial", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-1" class="nav-tab"><?php echo esc_html__("Add A New Embedding", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-3" class="nav-tab"><?php echo esc_html__("Upload Embeddings from CSV", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-5" class="nav-tab"><?php echo esc_html__("Scrape Data From URL", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-4" class="nav-tab"><?php echo esc_html__("Auto Index Existing Posts", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-2" class="nav-tab"><?php echo esc_html__("List Added Embeddings", 'aiomatic-automatic-ai-content-writer');?></a>
            <a href="#tab-x" datahref="<?php echo admin_url('admin.php?page=aiomatic_admin_settings#tab-13');?>" class="nav-tab"><?php echo esc_html__("Settings", 'aiomatic-automatic-ai-content-writer');?></a>
        </nav>
        <div id="tab-0" class="tab-content">
         <br/>
         <h3><?php echo esc_html__("What are embeddings in GPT-3?", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p><?php echo esc_html__("Embeddings are a way to send to the AI content writer a set o pre-trained data, to give it more context about the question or prompt which was submitted to it, for which a response is awaited. These embeddings can help the model better understand language and the requirements sent in the prompt.", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("When creating embeds, it's important to keep in mind to always create a high quality data set, as this will help the AI writer to get a more correct context.", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("Lets say you would like to give your AI the ability to answer specific questions about your website content, company, product or anything else, but you don't want to go through the process of training your own AI model. In this case, the Embeddings feature is what you will need. Simply specify your statements in the Embeddings section of the plugin and they will be also sent to the AI content writer, when needed.", 'aiomatic-automatic-ai-content-writer');?></p>
         <p><?php echo esc_html__("If you are looking for more complex way to customize the AI content writer and to be able to \"teach\" the AI a large set of information (by creating your own fine-tuned model), I suggest you check the", 'aiomatic-automatic-ai-content-writer');?> <a href="<?php echo admin_url('admin.php?page=aiomatic_openai_training');?>"><?php echo esc_html__("AI Model Training", 'aiomatic-automatic-ai-content-writer');?></a> <?php echo esc_html__("feature of the plugin.", 'aiomatic-automatic-ai-content-writer');?></p>
         <h3><?php echo esc_html__("More about Embeddings", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p><b><?php echo esc_html__("The main steps of creating embeddings are", 'aiomatic-automatic-ai-content-writer');?>:</b></p>
         <ol><li><b><?php echo esc_html__("Step 0: Read this tutorial carefully and watch the tutorial video", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("be sure to not skip this step! Also, be sure to be clear with", 'aiomatic-automatic-ai-content-writer');?> <a href="https://openai.com/api/pricing/" target="_blank"><?php echo esc_html__("OpenAI's pricing", 'aiomatic-automatic-ai-content-writer');?></a> <?php echo esc_html__("for usage of embeddings.", 'aiomatic-automatic-ai-content-writer');?></li>
         <li><b><?php echo esc_html__("Step 1: Create your data for embeddings", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("create as many high quality questions and answers as possible, add them on a single line, give detailed context. In this case (contrary to AI model training) you don't need to create very large amounts of data, it is enough to enter just the information which you would like the AI model to learn about.", 'aiomatic-automatic-ai-content-writer');?>
        </li>
        <li><b><?php echo esc_html__("Step 2: Auto Index Existing Posts", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("Using this feature you will be able to automatically create embeddings data from the posts you already have published on your site. You can set the plugin up to automatically index posts, pages, products or any custom post type. Embeddings will be automatically created using their data. You can change the template which is used for automatic embeddings creation, from the plugin's 'Settings' menu -> 'Embeddings' tab -> 'Auto Created Embeddings Template' settings field.", 'aiomatic-automatic-ai-content-writer');?></li>
        <li><b><?php echo esc_html__("Step 3: List Added Embeddings", 'aiomatic-automatic-ai-content-writer');?>:</b> <?php echo esc_html__("Check and verify added embeddings and manage them to be sure they are correct.", 'aiomatic-automatic-ai-content-writer');?></li>
     </ol>
         <h3><?php echo esc_html__("Tutorial Video", 'aiomatic-automatic-ai-content-writer');?></h3>
         <p class="cr_center"><div class="embedtool"><iframe src="https://www.youtube.com/embed/hkk0d7W0kIs" frameborder="0" allowfullscreen></iframe></div></p>

        </div>
        <div id="tab-1" class="tab-content">
         <br/>
         <form action="" method="post" id="aiomatic_embeddings_form">
    <input type="hidden" name="action" value="aiomatic_embeddings">
    <div class="aiomatic-embeddings-success" style="padding: 10px;background: #fff;border-left: 2px solid #11ad6b;display: none"><?php echo esc_html__("Embedding saved successfully", 'aiomatic-automatic-ai-content-writer');?></div>
    <div class="aiomatic-mb-10">
        <p><strong><?php echo esc_html__("Add a new embedding:", 'aiomatic-automatic-ai-content-writer');?></strong></p>
        <textarea name="content" class="aiomatic-embeddings-content coderevolution_gutenberg_input" id="aiomatic-embeddings-content" rows="15"></textarea>
    </div>
    <button class="button button-primary"><?php echo esc_html__("Save", 'aiomatic-automatic-ai-content-writer');?></button>
</form>
        </div>
        <div id="tab-x" class="tab-content">
        <br/>
        <p><?php echo esc_html__("Redirecting...", 'aiomatic-automatic-ai-content-writer');?></p>
        </div>
        <div id="tab-2" class="tab-content">
        <br/>
        <button href="#" id="aiomatic_sync_embeddings" class="page-title-action aiomatic_sync_files"><?php echo esc_html__("Sync Embeddings", 'aiomatic-automatic-ai-content-writer');?></button>
        <button href="#" id="aiomatic_delete_selected_embeddings" class="page-title-action aiomatic_sync_files"><?php echo esc_html__("Delete Selected Embeddings", 'aiomatic-automatic-ai-content-writer');?></button>
        <button href="#" id="aiomatic_deleteall_embeddings" class="page-title-action aiomatic_sync_files"><?php echo esc_html__("Delete All Embeddings", 'aiomatic-automatic-ai-content-writer');?></button>
        <button href="#" id="aiomatic_save_embeddings" class="page-title-action aiomatic_sync_files"><?php echo esc_html__("Download to CSV", 'aiomatic-automatic-ai-content-writer');?></button>
        <?php
$orderby = 'date';
$order = 'DESC';
if (isset($_GET['order']) && in_array(strtolower($_GET['order']), ['asc', 'desc'])) {
    $order = strtoupper($_GET['order']);
}
if (isset($_GET['orderby']) && in_array(strtolower($_GET['orderby']), ['title', 'date'])) {
    $orderby = strtolower($_GET['orderby']);
}
$aiomatic_embedding_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
$aiomatic_embeddings = new WP_Query(array(
    'post_type' => 'aiomatic_embeddings',
    'posts_per_page' => 40,
    'paged' => $aiomatic_embedding_page,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'any'
));
if($aiomatic_embeddings->have_posts()){
    echo '<br><br>' . esc_html__('All embeddings', 'aiomatic-automatic-ai-content-writer') . ' (' . $aiomatic_embeddings->found_posts . ')<br>';
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
        <th scope="col"><a href="<?php echo esc_html($title_url); ?>"><?php echo esc_html__("Content", 'aiomatic-automatic-ai-content-writer');?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php echo esc_html__("Namespace", 'aiomatic-automatic-ai-content-writer');?></th>
        <th scope="col"><?php echo esc_html__("Model", 'aiomatic-automatic-ai-content-writer');?></th>
        <th scope="col"><?php echo esc_html__("Tokens", 'aiomatic-automatic-ai-content-writer');?></th>
        <th scope="col"><?php echo esc_html__("Estimated", 'aiomatic-automatic-ai-content-writer');?></th>
        <th scope="col"><a href="<?php echo esc_html($date_url); ?>"><?php echo esc_html__("Date", 'aiomatic-automatic-ai-content-writer');?><span class="dashicons <?php if(!isset($_GET['order'])){echo 'cr_none';}else{echo $order === 'ASC' ? 'dashicons-arrow-down' : 'dashicons-arrow-up';} ?>"></span></a></th>
        <th scope="col"><?php echo esc_html__("Manage", 'aiomatic-automatic-ai-content-writer');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $stats = new Aiomatic_Statistics();
    if($aiomatic_embeddings->have_posts()){
        foreach ($aiomatic_embeddings->posts as $aiomatic_embedding){
            $token = get_post_meta($aiomatic_embedding->ID,'aiomatic_embedding_token',true);
            $model = get_post_meta($aiomatic_embedding->ID,'aiomatic_embedding_model',true);
            $aiomatic_namespace = get_post_meta($aiomatic_embedding->ID,'aiomatic_namespace',true);
            ?>
            <tr>
                <td><input class="aiomatic-select-embedding" id="aiomatic-select-<?php echo $aiomatic_embedding->ID;?>" type="checkbox" name="ids[]" value="<?php echo $aiomatic_embedding->ID;?>"></td>
                <td><a href="<?php echo get_edit_post_link($aiomatic_embedding->ID);?>" class="aiomatic-embedding-content"><?php echo esc_html($aiomatic_embedding->post_title);?></a></td>
                <td><?php if(empty($aiomatic_namespace)){echo '-';}else{echo esc_html($aiomatic_namespace);}?></td>
                <td><?php if(!empty($model)){echo esc_html($model);} else { echo '-';}?></td>
                <td><?php echo esc_html($token);?></td>
                <td><?php if(!empty($model)){$embprice = $stats->calculatePrice($model, $token) * 2;}else{$embprice = !empty($token) ? ((int)esc_html($token)*0.0004).'$': '--';}echo $embprice;?></td>
                <td><?php echo esc_html($aiomatic_embedding->post_date);?></td>
                <td>
                <button class="button button-small" id="aiomatic_manage_embedding_<?php echo $aiomatic_embedding->ID;?>" onclick="location.href='<?php echo get_edit_post_link($aiomatic_embedding->ID);?>';" href="<?php echo get_edit_post_link($aiomatic_embedding->ID);?>"><?php echo esc_html__("Manage", 'aiomatic-automatic-ai-content-writer');?></button>
                <button class="button button-small aiomatic_delete_embedding" id="aiomatic_delete_embedding_<?php echo $aiomatic_embedding->ID;?>" delete-id="<?php echo $aiomatic_embedding->ID;?>"><?php echo esc_html__("Delete", 'aiomatic-automatic-ai-content-writer');?></button>
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
        'base'         => admin_url('admin.php?page=aiomatic_embeddings_panel&wpage=%#%'),
        'total'        => $aiomatic_embeddings->max_num_pages,
        'current'      => $aiomatic_embedding_page,
        'format'       => '?wpage=%#%',
        'show_all'     => false,
        'prev_next'    => false,
        'add_args'     => false,
    ));
    ?>
</div>
        </div>
        <div id="tab-3" class="tab-content">
         <br/>
         <?php
$aiomaticMaxFileSize = wp_max_upload_size();
?>
<h3 class="margin5"><?php echo esc_html__("Upload New File", 'aiomatic-automatic-ai-content-writer');?></h3>
<div class="aiomatic_form_upload_file">
    <table class="aiomatic_list_data form-table">
        <tbody>
        <tr>
            <th class="aiomatic_th" scope="row"><?php echo esc_html__("Dataset (*.csv)", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="file" id="aiomatic_csv_upload" accept=".csv">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="aiomatic_upload_success aiomatic_none margin5 colorgr"><?php echo esc_html__("File uploaded successfully.", 'aiomatic-automatic-ai-content-writer');?></div>
                <div class="aiomatic_progress aiomatic_none"><span></span><small><?php echo esc_html__("Uploading", 'aiomatic-automatic-ai-content-writer');?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_upload_embeddings"><?php echo esc_html__("Upload", 'aiomatic-automatic-ai-content-writer');?></button><br>
                <p class="cr_center"><?php echo esc_html__("Maximum upload file size", 'aiomatic-automatic-ai-content-writer');?>: <?php echo size_format($aiomaticMaxFileSize)?>
                <?php
                if(wp_max_upload_size() < 104857600){
                    ?>
                    <?php echo esc_html__("(Please increase this value if you want to upload larger datasets)", 'aiomatic-automatic-ai-content-writer');?>
                    <?php
                }
                ?></p> 
                <p class="cr_center"><?php echo esc_html__("The csv file should contain the embeddings data on the first column, each new data on a different row", 'aiomatic-automatic-ai-content-writer');?></p> 
            </td>
        </tr>
        </tbody>
    </table>
</div>
        </div>
        <div id="tab-5" class="tab-content">
         <br/>
<h3 class="margin5"><?php echo esc_html__("Scrape URL Data", 'aiomatic-automatic-ai-content-writer');?></h3>
<div class="aiomatic_form_scrape_url">
    <table class="aiomatic_list_data form-table">
        <tbody>
        <tr>
            <th class="aiomatic_th" scope="row"><?php echo esc_html__("URL", 'aiomatic-automatic-ai-content-writer');?></th>
            <td>
                <input type="url" id="aiomatic_url_embedding" placeholder="<?php echo esc_html__("Enter the URL to be scraped", 'aiomatic-automatic-ai-content-writer');?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="aiomatic_scrape_success aiomatic_none margin5 colorgr"><?php echo esc_html__("URL scraping successful.", 'aiomatic-automatic-ai-content-writer');?></div>
                <div class="aiomatic_url_progress aiomatic_none"><span></span><small><?php echo esc_html__("Scraping the URL...", 'aiomatic-automatic-ai-content-writer');?></small></div>
                <div class="aiomatic-error-msg"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary coderevolution_block_input" id="aiomatic_scrape_url_embeddings"><?php echo esc_html__("Scrape", 'aiomatic-automatic-ai-content-writer');?></button><br>
            </td>
        </tr>
        </tbody>
    </table>
</div>
        </div>
        <div id="tab-4" class="tab-content">
         <br/>
         <table class="widefat">
                  <tr>
                     <td colspan="3">
                        <h2>
                        <?php echo esc_html__("Auto Index Existing Posts:", 'aiomatic-automatic-ai-content-writer');?></h3>
                        <div class="crf_bord cr_color_red cr_width_full"><?php echo esc_html__('Bulk embedding creation might consume a large number of AI model tokens to complete! Be sure you check', 'aiomatic-automatic-ai-content-writer') . '&nbsp;<a href="https://openai.com/pricing" target="_blank">' .  esc_html__('token pricing', 'aiomatic-automatic-ai-content-writer') . '</a>&nbsp;' .  esc_html__('before you continue. You can filter which posts you need to be indexed.', 'aiomatic-automatic-ai-content-writer');?></div>
                     </td>
                  </tr>
                  <tr><td colspan="2">
<?php
    echo esc_html__("INFO: You can change the way the posts are edited by changing settings in the 'Editing Templates and Options' tab from above! Also, be sure to save settings before running bulk post editing!", 'aiomatic-automatic-ai-content-writer');
?>
</td></tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to run manual post editing, now? Please check configuration from below before clicking 'Run Post Editing'.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Manually Run Post Editing Now:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td class="cr_min_100 cr_center">
                     <img id="run_img" src="<?php echo esc_url_raw(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');?>" alt="Running" class="cr_hidden cr_align_middle" title="status">
                     </td>
                     <td>
                     <div class="codemainfzr">
                     <select id="actions" class="actions" name="aiomatic_bulk_actions" onchange="actionsEmbChangedManual(this.value);" onfocus="this.selectedIndex = 0;">
                     <option value="select" disabled selected><?php echo esc_html__("Select an Action", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="run"><?php echo esc_html__("Run Post Editing", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select>
                     </div>
                     </td>
                  </tr>
            </table>
            <table class="widefat">
                  <tr>
                     <td colspan="2">
                        <h2>
                        <?php echo esc_html__("Bulk AI Embeddings Settings:", 'aiomatic-automatic-ai-content-writer');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum number of posts to be processed at each run.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Number Of Posts To Process:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_nr" step="1" min="1" class="cr_width_full" placeholder="Maximum Post Count" name="max_nr" value="10"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select if you want to reindex all posts (also the ones which are already indexed).", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Reindex Every Post:", 'aiomatic-automatic-ai-content-writer');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                        <input type="checkbox" id="no_twice" name="no_twice">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Posts From Which To Create Embeddings:", 'aiomatic-automatic-ai-content-writer');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int,int,int) - use author id [use minus (-) to exclude authors by ID ex. -1,-2,-3]", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Author IDs:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="author_id" name="author_id" class="cr_width_full" value="" placeholder="Author IDs">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - use 'user_nicename' (NOT name)", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Author Names:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="author_name" name="author_name" class="cr_width_full" value="" placeholder="Author names">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string,string,string) - use category slugs instead of names. ", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Category Names:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="category_name" name="category_name" class="cr_width_full" value="" placeholder="Category names">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string,string,string) - use tag slugs instead of names. ", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Tag Names:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="tag_name" name="tag_name" value="" class="cr_width_full" placeholder="Tag names">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Comma separated list of post IDs to edit.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Post IDs:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="post_id" name="post_id" value="" class="cr_width_full" placeholder="Post ID">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - use post slug.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Post Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="post_name" name="post_name" value="" class="cr_width_full" placeholder="Post name">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - use page id.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page ID:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="page_id" name="page_id" value="" class="cr_width_full" placeholder="Page ID">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - use page slug.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="pagename" name="pagename" value="" class="cr_width_full" placeholder="Page name">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - use page id. Return just the child Pages.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Post Parent:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="post_parent" name="post_parent" value="" class="cr_width_full" placeholder="Post parent ID">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string,string) - The post types to return. Valid values are: post, page, revision, attachment, other-custom-post-types. To match any post type enter the keyword: any. The default is post (if left empty).", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Post Type:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="type_post" name="type_post" value="post" class="cr_width_full" placeholder="Post type">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - The post status to return. Valid values are:  publish, pending, draft, auto-draft, future, private, inherit, trash, other-custom-post-statuses", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Post Status:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="post_status" name="post_status" value="" class="cr_width_full" placeholder="Post status">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - number of post to alter. Use 'posts_per_page'=-1 to alter all posts.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Posts To Change:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="number" min="-1" step="1" id="max_posts" name="max_posts" class="cr_width_full" value="" placeholder="Max posts">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - number of post to displace or pass over.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Search Offset:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="number" min="-1" step="1" id="search_offset" name="search_offset" class="cr_width_full" value="" placeholder="Post offset">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - Custom field key.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Meta Key Name:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="meta_name" name="meta_name" value="" class="cr_width_full" placeholder="Meta Key Name">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - Custom field value.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Meta Key Value:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="meta_value" name="meta_value" value="" class="cr_width_full" placeholder="Meta Key Value">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "(string) - Passes along the query string variable from a search. For example usage see: <a href='%s' target='_blank'>this link</a>.", 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'http://www.wprecipes.com/how-to-display-the-number-of-results-in-wordpress-search' );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Search Query:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="text" id="search_query" name="search_query" value="" class="cr_width_full" placeholder="Search query">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - 4 digit year (e.g. 2011).", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Year Query:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="number" min="0" step="1" id="year" name="year" value="" class="cr_width_full" placeholder="Year">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - Month number (from 1 to 12).", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Month Query:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="number" min="1" max="12" step="1" id="month" name="month" class="cr_width_full" value="" placeholder="Month">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(int) - Day of the month (from 1 to 31).", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Day Query:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <input type="number" min="1" max="31" step="1" id="day" name="day" class="cr_width_full" value="" placeholder="Day">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select which posts should be processed - posts with or without featured images.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Status:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <select id="featured_image" name="featured_image" class="cr_width_full" >
                     <option value="any"><?php echo esc_html__("Any", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="with"><?php echo esc_html__("With Featured Images", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="without"><?php echo esc_html__("Without Featured Images", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select> 
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - Designates the ascending or descending order of the 'orderby' parameter. Defaultto 'DESC'.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Order Results:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <select id="order" name="order" class="cr_width_full" >
                     <option value="default"><?php echo esc_html__("Default", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="DESC"><?php echo esc_html__("Descendent", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="ASC"><?php echo esc_html__("Ascendent", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select> 
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("(string) - Sort retrieved posts by parameter. Defaults to 'date'.", 'aiomatic-automatic-ai-content-writer');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Order Results By:", 'aiomatic-automatic-ai-content-writer');?></b>
                     </td>
                     <td>
                     <select id="orderby" name="orderby" class="cr_width_full" >
                     <option value="default"><?php echo esc_html__("Default", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="date"><?php echo esc_html__("Date", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="none"><?php echo esc_html__("None", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="ID"><?php echo esc_html__("ID", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="author"><?php echo esc_html__("Author", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="title"><?php echo esc_html__("Title", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="date"><?php echo esc_html__("Date", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="modified"><?php echo esc_html__("Modified", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="parent"><?php echo esc_html__("Parent", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="rand"><?php echo esc_html__("Random", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="comment_count"><?php echo esc_html__("Comment Count", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="menu_order"><?php echo esc_html__("Menu Order", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="meta_value"><?php echo esc_html__("Meta Value", 'aiomatic-automatic-ai-content-writer');?></option>
                     <option value="meta_value_num"><?php echo esc_html__("Meta Value Number", 'aiomatic-automatic-ai-content-writer');?></option>
                     </select> 
                     </td>
                  </tr>
               </table>
        </div>
    </div>
<?php
}
?>