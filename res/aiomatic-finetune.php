<?php
use AiomaticOpenAI\OpenAi\OpenAi;
if(!class_exists('AiomaticFineTune'))
{
    class AiomaticFineTune
    {
        private static  $instance = null ;
        public $aiomatic_max_file_size = 10485760;

        public static function get_instance()
        {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct()
        {
            require_once (dirname(__FILE__) . "/openai/Url.php"); 
            require_once (dirname(__FILE__) . "/openai/OpenAi.php"); 
            add_action('wp_ajax_aiomatic_finetune_upload', [$this,'aiomatic_finetune_upload']);
            add_action('wp_ajax_aiomatic_get_finetune_file', [$this,'aiomatic_get_finetune_file']);
            add_action('wp_ajax_aiomatic_get_finetune', [$this,'aiomatic_get_finetune']);
            add_action('wp_ajax_aiomatic_create_finetune', [$this,'aiomatic_create_finetune']);
            add_action('wp_ajax_aiomatic_finetune_events', [$this,'aiomatic_finetune_events']);
            add_action('wp_ajax_aiomatic_delete_finetune_file', [$this,'aiomatic_delete_finetune_file']);
            add_action('wp_ajax_aiomatic_delete_finetune', [$this,'aiomatic_delete_finetune']);
            add_action('wp_ajax_aiomatic_cancel_finetune', [$this,'aiomatic_cancel_finetune']);
            add_action('wp_ajax_aiomatic_other_finetune', [$this,'aiomatic_other_finetune']);
            add_action('wp_ajax_aiomatic_fetch_finetunes', [$this,'aiomatic_finetunes']);
            add_action('wp_ajax_aiomatic_fetch_finetune_files', [$this,'aiomatic_files']);
            add_action('wp_ajax_aiomatic_download', [$this,'aiomatic_download']);
            add_action('wp_ajax_aiomatic_create_finetune_modal', [$this,'aiomatic_create_finetune_modal']);
            add_action('wp_ajax_aiomatic_data_converter_count',[$this,'aiomatic_data_converter_count']);
            add_action('wp_ajax_aiomatic_data_converter',[$this,'aiomatic_data_converter']);
            add_action('wp_ajax_aiomatic_upload_convert',[$this,'aiomatic_upload_convert']);
            add_action('wp_ajax_aiomatic_upload_convert_batch',[$this,'aiomatic_upload_convert_batch']);
            add_action('wp_ajax_aiomatic_data_insert',[$this,'aiomatic_data_insert']);
            add_action('wp_ajax_aiomatic_data_insert_batch',[$this,'aiomatic_data_insert_batch']);
            add_action('wp_ajax_aiomatic_new_data_insert',[$this,'aiomatic_new_data_insert']);
            add_action('wp_ajax_aiomatic_new_data_batch_insert',[$this,'aiomatic_new_data_batch_insert']);
            add_action('wp_ajax_aiomatic_file_delete',[$this,'aiomatic_file_delete']);
        }

        public function aiomaticUploadOpenAI($file, $open_ai, $purpose = 'fine-tune')
        {
            $model = isset($_POST['model']) && !empty($_POST['model']) ? sanitize_text_field($_POST['model']) : 'gpt-3.5-turbo-1006';
            $name = isset($_POST['custom']) && !empty($_POST['custom']) ? sanitize_title($_POST['custom']) : '';
            $c_file = curl_file_create($file, mime_content_type($file),basename($file));
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
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
            $result = $open_ai->uploadFile(array(
                'purpose' => $purpose,
                'file' => $c_file,
            ));
            $result = json_decode($result);
            if(isset($result->error->message)){
                return trim($result->error->message);
            }
            else{
                $aiomatic_file_id = wp_insert_post(array(
                    'post_title' => $result->id,
                    'post_date' => date('Y-m-d H:i:s',$result->created_at),
                    'post_status' => 'publish',
                    'post_type' => 'aiomatic_file',
                ));
                if(!is_wp_error($aiomatic_file_id)){
                    if($aiomatic_file_id === 0)
                    {
                        return 'An error occured when inserting finetune into the database!';
                    }
                    add_post_meta($aiomatic_file_id, 'aiomatic_filename',$result->filename);
                    add_post_meta($aiomatic_file_id, 'aiomatic_purpose',$result->purpose);
                    add_post_meta($aiomatic_file_id, 'aiomatic_model',$model);
                    add_post_meta($aiomatic_file_id, 'aiomatic_custom_name',$name);
                    add_post_meta($aiomatic_file_id, 'aiomatic_file_size',$result->bytes);
                }
                else{
                    return $aiomatic_file_id->get_error_message();
                }
                return 'success';
            }
        }

        public function aiomatic_data_insert()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with finetuning data insertion');
            if(
                isset($_POST['prompt'])
                && !empty($_POST['prompt'])
                && isset($_POST['completion'])
                && !empty($_POST['completion'])
            ){
                $data = array(
                    'prompt' => sanitize_text_field($_POST['prompt']),
                    'completion' => ' ' . strip_tags(sanitize_text_field($_POST['completion']))
                );
                $file = isset($_POST['file']) && !empty($_POST['file']) ? sanitize_text_field($_POST['file']).'.jsonl' : md5(time()).'.jsonl';
                $aiomatic_json_file = fopen(wp_upload_dir()['basedir'].'/'.$file, "a");
                fwrite($aiomatic_json_file, json_encode($data) . PHP_EOL);
                fclose($aiomatic_json_file);
                $aiomatic_result['file'] = $file;
                $aiomatic_result['status'] = 'success';
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_data_insert_batch()
        {
            check_ajax_referer('openai-ajax-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with batch data insertion');
            if(
                isset($_POST['js_list'])
                && !empty($_POST['js_list'])
            ){
                $data = trim(stripslashes($_POST['js_list']), '" ');
                $file = isset($_POST['file']) && !empty($_POST['file']) ? sanitize_text_field($_POST['file']).'.jsonl' : md5(time()).'.jsonl';
                $aiomatic_json_file = fopen(wp_upload_dir()['basedir'].'/'.$file, "a");
                fwrite($aiomatic_json_file, trim($data));
                fclose($aiomatic_json_file);
                $aiomatic_result['file'] = $file;
                $aiomatic_result['status'] = 'success';
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_new_data_insert()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with finetuning data insertion');
            if(
                isset($_POST['prompt'])
                && !empty($_POST['prompt'])
                && isset($_POST['completion'])
                && !empty($_POST['completion'])
                && isset($_POST['system'])
                && !empty($_POST['system'])
            ){
                $data = array('messages' => array(
                    array('role' => 'system', 'content' => sanitize_text_field($_POST['system'])),
                    array('role' => 'user', 'content' => sanitize_text_field($_POST['prompt'])),
                    array('role' => 'assistant', 'content' => sanitize_text_field($_POST['completion']))
                ));
                $file = isset($_POST['file']) && !empty($_POST['file']) ? sanitize_text_field($_POST['file']).'.jsonl' : md5(time()).'.jsonl';
                $aiomatic_json_file = fopen(wp_upload_dir()['basedir'].'/'.$file, "a");
                fwrite($aiomatic_json_file, json_encode($data) . PHP_EOL);
                fclose($aiomatic_json_file);
                $aiomatic_result['file'] = $file;
                $aiomatic_result['status'] = 'success';
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_new_data_batch_insert()
        {
            check_ajax_referer('openai-ajax-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with batch data insertion');
            if(
                isset($_POST['js_list'])
                && !empty($_POST['js_list'])
            ){
                $data = trim(stripslashes($_POST['js_list']), '" ');
                $file = isset($_POST['file']) && !empty($_POST['file']) ? sanitize_text_field($_POST['file']).'.jsonl' : md5(time()).'.jsonl';
                $aiomatic_json_file = fopen(wp_upload_dir()['basedir'].'/'.$file, "a");
                fwrite($aiomatic_json_file, trim($data));
                fclose($aiomatic_json_file);
                $aiomatic_result['file'] = $file;
                $aiomatic_result['status'] = 'success';
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_file_delete()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with finetuning file deletion');
            if(isset($_POST['file']) && !empty($_POST['file']))
            {
                $file = sanitize_text_field($_POST['file']);
                global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                $zafile = wp_upload_dir()['basedir']. '/' . $file;
                if ($wp_filesystem->exists($zafile)) {
                    $wp_filesystem->delete($zafile);
                    $xposts = get_posts(
                        array(
                            'post_type'              => 'aiomatic_convert',
                            'title'                  => html_entity_decode($file),
                            'post_status'            => 'all',
                            'numberposts'            => 1,
                            'update_post_term_cache' => false,
                            'update_post_meta_cache' => false,           
                            'orderby'                => 'post_date ID',
                            'order'                  => 'ASC',
                        )
                    );
                    if ( ! empty( $xposts ) ) {
                        $zap = $xposts[0];
                    } else {
                        $zap = null;
                    }
                    if($zap !== null)
                    {
                        wp_delete_post($zap->ID, true);
                    }
                    $aiomatic_result['file'] = $file;
                    $aiomatic_result['status'] = 'success';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_upload_convert()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with finetuning upload conversion');
            if(
                isset($_POST['file'])
                && !empty($_POST['file'])
            ){
                $filename = sanitize_text_field($_POST['file']);
                $line = isset($_POST['line']) && !empty($_POST['line']) ? sanitize_text_field($_POST['line']) : 0;
                $index = isset($_POST['index']) && !empty($_POST['index']) ? sanitize_text_field($_POST['index']) : 1;
                $file = wp_upload_dir()['basedir'].'/'.$filename;
                global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                if($wp_filesystem->exists($file)){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
                    {
                        $aiomatic_result['msg'] = 'Missing API Setting';
                    }
                    else 
                    {
                        if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                        {
                            $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                            wp_send_json($aiomatic_result);
                        }
                        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                        $appids = array_filter($appids);
                        $token = $appids[array_rand($appids)];
                        $open_ai = new OpenAi($token);
                        if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                        {
                            $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
                        }
                        $aiomatic_lines = file($file);
                        $aiomatic_file_size = filesize($file);
                        if ($aiomatic_file_size < $this->aiomatic_max_file_size) {
                            $result = $this->aiomaticUploadOpenAI($file, $open_ai, 'fine-tune');
                            $aiomatic_result['next'] = 'DONE';
                        } else {
                            $filename =  str_replace('.jsonl','',$filename);
                            $filename = $filename.'-'.$index.'.jsonl';
                            try {
                                $split_file = wp_upload_dir()['basedir'].'/'.$filename;
                                $aiomatic_json_file = fopen($split_file, "a");
                                $aiomatic_content = '';
                                for($i = $line; $i <= count($aiomatic_lines);$i++){
                                    if($i == count($aiomatic_lines)){
                                        $aiomatic_content .= $aiomatic_lines[$i];
                                        $aiomatic_result['next'] = 'DONE';
                                    }
                                    else{
                                        if(mb_strlen($aiomatic_content, '8bit') > $this->aiomatic_max_file_size){
                                            $aiomatic_result['next'] = $i+1;
                                            break;
                                        }
                                        else{
                                            $aiomatic_content .= $aiomatic_lines[$i];
                                        }
                                    }
                                }
                                fwrite($aiomatic_json_file,$aiomatic_content);
                                fclose($aiomatic_json_file);
                                $result = $this->aiomaticUploadOpenAI($split_file, $open_ai, 'fine-tune');
                                unlink($split_file);
                            }
                            catch (\Exception $exception){
                                $result = $exception->getMessage();
                            }
                        }
                        if($result == 'success'){
                            $aiomatic_result['status'] = 'success';
                        }
                        else{
                            $aiomatic_result['msg'] = $result;
                        }
                    }
                }
                else $aiomatic_result['msg'] = 'The file has been removed';

            }
            wp_send_json($aiomatic_result);
        }
        public function aiomatic_upload_convert_batch()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with batch upload conversion');
            if(
                isset($_POST['file'])
                && !empty($_POST['file'])
            ){
                $filename = sanitize_text_field($_POST['file']);
                $line = isset($_POST['line']) && !empty($_POST['line']) ? sanitize_text_field($_POST['line']) : 0;
                $index = isset($_POST['index']) && !empty($_POST['index']) ? sanitize_text_field($_POST['index']) : 1;
                $file = wp_upload_dir()['basedir'].'/'.$filename;
                global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                if($wp_filesystem->exists($file)){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
                    {
                        $aiomatic_result['msg'] = 'Missing API Setting';
                    }
                    else 
                    {
                        if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                        {
                            $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for batches.';
                            wp_send_json($aiomatic_result);
                        }
                        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                        $appids = array_filter($appids);
                        $token = $appids[array_rand($appids)];
                        $open_ai = new OpenAi($token);
                        if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                        {
                            $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
                        }
                        $aiomatic_lines = file($file);
                        $aiomatic_file_size = filesize($file);
                        if ($aiomatic_file_size < $this->aiomatic_max_file_size) {
                            $result = $this->aiomaticUploadOpenAI($file, $open_ai, 'batch');
                            $aiomatic_result['next'] = 'DONE';
                        } else {
                            $filename =  str_replace('.jsonl','',$filename);
                            $filename = $filename.'-'.$index.'.jsonl';
                            try {
                                $split_file = wp_upload_dir()['basedir'].'/'.$filename;
                                $aiomatic_json_file = fopen($split_file, "a");
                                $aiomatic_content = '';
                                for($i = $line; $i <= count($aiomatic_lines);$i++){
                                    if($i == count($aiomatic_lines)){
                                        $aiomatic_content .= $aiomatic_lines[$i];
                                        $aiomatic_result['next'] = 'DONE';
                                    }
                                    else{
                                        if(mb_strlen($aiomatic_content, '8bit') > $this->aiomatic_max_file_size){
                                            $aiomatic_result['next'] = $i+1;
                                            break;
                                        }
                                        else{
                                            $aiomatic_content .= $aiomatic_lines[$i];
                                        }
                                    }
                                }
                                fwrite($aiomatic_json_file,$aiomatic_content);
                                fclose($aiomatic_json_file);
                                $result = $this->aiomaticUploadOpenAI($split_file, $open_ai, 'batch');
                                unlink($split_file);
                            }
                            catch (\Exception $exception){
                                $result = $exception->getMessage();
                            }
                        }
                        if($result == 'success'){
                            $aiomatic_result['status'] = 'success';
                        }
                        else{
                            $aiomatic_result['msg'] = $result;
                        }
                    }
                }
                else $aiomatic_result['msg'] = 'The file has been removed';

            }
            wp_send_json($aiomatic_result);
        }
        public function sanitize_text_or_array_field($array_or_string)
        {
            if (is_string($array_or_string)) {
                $array_or_string = sanitize_text_field($array_or_string);
            } elseif (is_array($array_or_string)) {
                foreach ($array_or_string as $key => &$value) {
                    if (is_array($value)) {
                        $value = $this->sanitize_text_or_array_field($value);
                    } else {
                        $value = sanitize_text_field($value);
                    }
                }
            }

            return $array_or_string;
        }
        public function aiomatic_data_converter_count()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            global $wpdb;
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with finetuning data conversion counter');
            if(isset($_POST['data']) && is_array($_POST['data']) && count($_POST['data'])){
                $get_value = 'post_excerpt';
                if(isset($_POST['content_excerpt']))
                {
                    if($_POST['content_excerpt'] == 'post_excerpt' || $_POST['content_excerpt'] == 'post_content')
                    {
                        $get_value = $_POST['content_excerpt'];
                    }
                }
                if(isset($_POST['category']) && trim($_POST['category']) != '')
                {
                    $category = trim($_POST['category']);
                }
                else
                {
                    $category = '';
                }
                $types = $this->sanitize_text_or_array_field($_POST['data']);
                $sql = "SELECT COUNT(*) FROM " . $wpdb->posts;
                if($category != '')
                {
                    $sql .= " LEFT JOIN " . $wpdb->term_relationships . " as t ON ID = t.object_id";
                }
                $sql .= " WHERE post_status='publish' AND post_type IN ('".implode("','",$types)."')";
                if($category != '')
                {
                    $sql .= ' AND t.term_taxonomy_id = ' . $category;
                }
                $aiomatic_result['count'] = $wpdb->get_var($sql);
                $aiomatic_result['status'] = 'success';
                $aiomatic_result['types'] = $types;
                $aiomatic_result['category'] = $category;
                $aiomatic_result['content_excerpt'] = $get_value;
            }
            else 
            {
                $aiomatic_result['msg'] = 'Please select least one data to convert';
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_data_converter()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error','msg' => 'Something went wrong with finetuning data converter');
            global $wpdb;
            if(
                isset($_POST['types'])
                && is_array($_POST['types'])
                && count($_POST['types'])
                && isset($_POST['per_page'])
                && !empty($_POST['per_page'])
                && isset($_POST['total'])
                && !empty($_POST['total'])
            ){
                $get_value = 'post_excerpt';
                if(isset($_POST['content_excerpt']))
                {
                    if($_POST['content_excerpt'] == 'post_excerpt' || $_POST['content_excerpt'] == 'post_content')
                    {
                        $get_value = $_POST['content_excerpt'];
                    }
                }
                $types = $this->sanitize_text_or_array_field($_POST['types']);
                $aiomatic_total = sanitize_text_field($_POST['total']);
                $aiomatic_per_page = sanitize_text_field($_POST['per_page']);
                $aiomatic_page = isset($_POST['page']) && !empty($_POST['page']) ? sanitize_text_field($_POST['page']) : 1;
                if(isset($_POST['file']) && !empty($_POST['file'])){
                    $aiomatic_file = sanitize_text_field($_POST['file']);
                }
                else{
                    $aiomatic_file = md5(time()).'.jsonl';
                }
                if(isset($_POST['id']) && !empty($_POST['id'])){
                    $aiomatic_convert_id = sanitize_text_field($_POST['id']);
                }
                else{
                    $aiomatic_convert_id = wp_insert_post(array(
                        'post_title' => $aiomatic_file,
                        'post_type' => 'aiomatic_convert',
                        'post_status' => 'publish'
                    ));
                    if($aiomatic_convert_id === 0)
                    {
                        $aiomatic_result['msg'] = 'Failed to insert conversion into database.';
                        wp_send_json($aiomatic_result);
                    }
                    elseif(is_wp_error($aiomatic_convert_id))
                    {
                        $aiomatic_result['msg'] = 'WP error occurred when inserting conversion: ' . $aiomatic_convert_id->get_error_message();
                        wp_send_json($aiomatic_result);
                    }
                }
                try {
                    $aiomatic_json_file = fopen(wp_upload_dir()['basedir'].'/'.$aiomatic_file, "a");
                    $aiomatic_offset = ( $aiomatic_page * $aiomatic_per_page ) - $aiomatic_per_page;
                    $sql = "SELECT post_title, " . $get_value . " FROM " . $wpdb->posts;
                    if(isset($_POST['category']) && trim($_POST['category']) != '')
                    {
                        $sql .= " LEFT JOIN " . $wpdb->term_relationships . " as t ON ID = t.object_id";
                    }
                    $sql .= " WHERE post_status='publish' AND post_type IN ('".implode("','",$types)."')";
                    if(isset($_POST['category']) && trim($_POST['category']) != '')
                    {
                        $sql .= ' AND t.term_taxonomy_id = ' . trim($_POST['category']);
                    }
                    $sql .= " ORDER BY post_date ASC LIMIT ".$aiomatic_offset.",".$aiomatic_per_page;
                    $aiomatic_data = $wpdb->get_results($sql);
                    
                    if($aiomatic_data && is_array($aiomatic_data) && count($aiomatic_data)){
                        foreach($aiomatic_data as $item){
                            if($get_value == 'post_content')
                            {
                                $data = array(
                                    "prompt" => $item->post_title,
                                    "completion" => ' ' . strip_shortcodes(strip_tags($item->post_content))
                                );
                            }
                            else
                            {
                                $data = array(
                                    "prompt" => $item->post_title,
                                    "completion" => ' ' . strip_shortcodes(strip_tags($item->post_excerpt))
                                );
                            }
                            fwrite($aiomatic_json_file, json_encode($data) . PHP_EOL);
                        }
                    }
                    fclose($aiomatic_json_file);
                    $aiomatic_max_page = ceil($aiomatic_total / $aiomatic_per_page);
                    if($aiomatic_max_page == $aiomatic_page){
                        $aiomatic_result['next_page'] = 'DONE';
                        wp_update_post(array(
                            'ID' => $aiomatic_convert_id,
                            'post_modified' => date('Y-m-d H:i:s')
                        ));
                    }
                    else{
                        $aiomatic_result['next_page'] = $aiomatic_page+1;
                    }
                    $aiomatic_result['file'] = $aiomatic_file;
                    $aiomatic_result['id'] = $aiomatic_convert_id;
                    $aiomatic_result['status'] = 'success';
                }
                catch (\Exception $exception){
                    $aiomatic_result['msg'] = $exception->getMessage();
                }
            }
            else 
            {
                $aiomatic_result['msg'] = 'Please select least one data to convert';
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_create_finetune_modal()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning modal');
            $models = $this->aiomatic_get_models();
            if(is_array($models)){
                $aiomatic_result['status'] = 'success';
                $aiomatic_result['data'] = $models;
            }
            else{
                $aiomatic_result['status'] = 'error';
                $aiomatic_result['msg'] = $models;
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_get_models()
        {
            $result = false;
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
            {
                return array();
            }
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            $open_ai = new OpenAi($token);
            if ($open_ai) {
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
                $result = $open_ai->listModels();
                $json_parse = json_decode($result);
                if(isset($json_parse->error)){
                    return $json_parse->error->message;
                }
                elseif(isset($json_parse->data) && is_array($json_parse->data) && count($json_parse->data)){
                    $result = array();
                    foreach($json_parse->data  as $item){
                        if($item->owned_by != 'openai' && $item->owned_by != 'system' && $item->owned_by != 'openai-dev' && $item->owned_by != 'openai-internal'){
                            $result[] = $item->id;
                        }
                    }
                    if(count($result)){
                        update_option('aiomatic_custom_models', $result);
                    }
                }
            }
            return $result;
        }

        public function aiomatic_download()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
            {
                echo 'Azure/Claude API is not currently supported for finetunes.';
                die();
            }
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            $open_ai = new OpenAi($token);
            if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
                if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                {
                    $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
                }
                $id = sanitize_text_field($_REQUEST['id']);
                if (!$open_ai) {
                    echo 'Missing API Setting';
                } else {
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
                    $result = $open_ai->retrieveFileContent($id);
                    $json_parse = json_decode($result);
                    if(isset($json_parse->error)){
                        echo esc_html($json_parse->error->message);
                    }
                    else{
                        $filename = $id.'.csv';
                        header('Content-Type: application/csv');
                        header('Content-Disposition: attachment; filename="'.$filename.'";');
                        $f = fopen('php://output', 'w');
                        $lines = explode("\n", $result);
                        foreach($lines as $line) {
                            $line = explode(';',$line);
                            fputcsv($f, $line, ';');
                        }
                    }
                }
            }
            die();
        }

        public function aiomatic_create_finetune()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning creation');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
                    if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                    {
                        $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
                    }
                    $model = get_post_meta($aiomatic_file->ID,'aiomatic_model', true);
                    $suffix = get_post_meta($aiomatic_file->ID,'aiomatic_custom_name', true);
                    $dataSend = [
                        'training_file' => $aiomatic_file->post_title
                    ];
                    $dataSend['hyperparameters'] = [];
                    if(isset($_POST['model']) && !empty($_POST['model'])){
                        $dataSend['model'] = sanitize_text_field($_POST['model']);
                    }
                    else{
                        $dataSend['model'] = $model;
                        $dataSend['suffix'] = $suffix;
                    }
                    if(isset($_POST['hyper_epochs']) && !empty($_POST['hyper_epochs'])){
                        $dataSend['hyperparameters']["n_epochs"] = sanitize_text_field($_POST['hyper_epochs']);
                    }
                    if(isset($_POST['hyper_batch']) && !empty($_POST['hyper_batch'])){
                        $dataSend['hyperparameters']['batch_size'] = sanitize_text_field($_POST['hyper_batch']);
                    }
                    if(isset($_POST['hyper_rate']) && !empty($_POST['hyper_rate'])){
                        $dataSend['learning_rate_multiplier'] = sanitize_text_field($_POST['hyper_rate']);
                    }
                    if(isset($_POST['hyper_loss']) && !empty($_POST['hyper_loss'])){
                        $dataSend['prompt_loss_weight'] = sanitize_text_field($_POST['hyper_loss']);
                    }
                    if(isset($_POST['hyper_suffix']) && !empty($_POST['hyper_suffix'])){
                        $suf = sanitize_text_field($_POST['hyper_suffix']);
                        $suf = (strlen($suf) > 40) ? substr($suf, 0, 40) : $suf;
                        $dataSend['suffix'] = $suf;
                    }
                    if(empty($dataSend['model'])){
                        $dataSend['model'] = 'gpt-3.5-turbo-1006';
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
                    if ( $dataSend['model'] === 'turbo' ) 
                    {
                        $dataSend['model'] = 'gpt-3.5-turbo-1006';
                    }
                    $result = $open_ai->createFineTune($dataSend);
                    $aiomatic_result['model'] = $model;
                    $result = json_decode($result);
                    if(isset($result->error->message)){
                        $aiomatic_result['msg'] = $result->error->message;
                    }
                    else{
                        update_post_meta($aiomatic_file->ID,'aiomatic_fine_tune', $result->id);
                        $aiomatic_file_id = wp_insert_post(array(
                            'post_title' => $result->id,
                            'post_date' => date('Y-m-d H:i:s', $result->created_at),
                            'post_status' => 'publish',
                            'post_type' => 'aiomatic_finetune',
                        ));
                        if($aiomatic_file_id === 0)
                        {
                            $aiomatic_result['msg'] = 'Failed to insert finetune into database.';
                            wp_send_json($aiomatic_result);
                        }
                        elseif(is_wp_error($aiomatic_file_id))
                        {
                            $aiomatic_result['msg'] = 'WP error occurred when inserting finetune: ' . $aiomatic_file_id->get_error_message();
                            wp_send_json($aiomatic_result);
                        }
                        add_post_meta($aiomatic_file_id, 'aiomatic_model', $result->model);
                        add_post_meta($aiomatic_file_id, 'aiomatic_updated_at', date('Y-m-d H:i:s', $result->finished_at));
                        add_post_meta($aiomatic_file_id, 'aiomatic_name', $result->fine_tuned_model);
                        add_post_meta($aiomatic_file_id, 'aiomatic_org', $result->organization_id);
                        add_post_meta($aiomatic_file_id, 'aiomatic_status', $result->status);
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['data'] = $result;
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'File not found';
                }
            }
            wp_send_json($aiomatic_result);
        }
        public function aiomatic_endsWith( $haystack, $needle ) {
            $length = strlen( $needle );
            if( !$length ) {
                return true;
            }
            return substr( $haystack, -$length ) === $needle;
        }
        public function aiomatic_finetune_upload()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning uploading');
            if(isset($_FILES['file']) && empty($_FILES['file']['error'])){
                $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                {
                    $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                    wp_send_json($aiomatic_result);
                }
                $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                $appids = array_filter($appids);
                $token = $appids[array_rand($appids)];
                $open_ai = new OpenAi($token);
                if(!$open_ai){
                    $aiomatic_result['msg'] = 'Missing API Setting';
                    wp_send_json($aiomatic_result);
                }
                if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                {
                    $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
                }
                $file_name = sanitize_file_name(basename($_FILES['file']['name']));
                $filetype = wp_check_filetype($file_name);
                if($filetype['ext'] !== 'jsonl' && !aiomatic_endsWith($file_name, '.jsonl')){
                    $aiomatic_result['msg'] = 'Only files with the jsonl extension are supported, you sent: ' . $file_name;
                    wp_send_json($aiomatic_result);
                }
                $tmp_file = $_FILES['file']['tmp_name'];
                $c_file = curl_file_create($tmp_file, $_FILES['file']['type'], $file_name);
                $purpose = isset($_POST['purpose']) && !empty($_POST['purpose']) ? sanitize_text_field($_POST['purpose']) : 'fine-tune';
                $model = isset($_POST['model']) && !empty($_POST['model']) ? sanitize_text_field($_POST['model']) : 'gpt-3.5-turbo-1006';
                
                $name = isset($_POST['name']) && !empty($_POST['name']) ? sanitize_title($_POST['name']) : '';
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
                $result = $open_ai->uploadFile(array(
                    'purpose' => $purpose,
                    'file' => $c_file,
                ));
                $result = json_decode($result);
                if(isset($result->error->message)){
                    $aiomatic_result['msg'] = $result->error->message;
                }
                else{
                    $aiomatic_file_id = wp_insert_post(array(
                        'post_title' => $result->id,
                        'post_date' => date('Y-m-d H:i:s',get_date_from_gmt(date('Y-m-d H:i:s',$result->created_at),'U')),
                        'post_status' => 'publish',
                        'post_type' => 'aiomatic_file',
                    ));
                    if(!is_wp_error($aiomatic_file_id)){
                        if($aiomatic_file_id === 0)
                        {
                            $aiomatic_result['msg'] = 'Failed to upload finetune into database.';
                            wp_send_json($aiomatic_result);
                        }
                        $aiomatic_result['status'] = 'success';
                        add_post_meta($aiomatic_file_id, 'aiomatic_filename',$result->filename);
                        add_post_meta($aiomatic_file_id, 'aiomatic_purpose',$result->purpose);
                        add_post_meta($aiomatic_file_id, 'aiomatic_model',$model);
                        add_post_meta($aiomatic_file_id, 'aiomatic_custom_name',$name);
                        add_post_meta($aiomatic_file_id, 'aiomatic_file_size',$result->bytes);
                    }
                    else{
                        $aiomatic_result['msg'] = $aiomatic_file_id->get_error_message();
                    }
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_get_finetune_file()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning file');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
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
                    $result = $open_ai->retrieveFileContent($aiomatic_file->post_title);
                    $json_parse = json_decode($result);
                    if(isset($json_parse->error)){
                        $aiomatic_result['msg'] = $json_parse->error->message;
                    }
                    else{
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['data'] = $result;
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'File not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_finetune_events()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning events');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
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
                    $result = $open_ai->retrieveFineTune($aiomatic_file->post_title);
                    $result = json_decode($result);
                    if(isset($result->error->message)){
                        $aiomatic_result['msg'] = $result->error->message;
                    }
                    else{
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['data'] = $result->events;
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'Fine Tune not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_get_finetune()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning getting');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
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
                    $result = $open_ai->retrieveFineTune($aiomatic_file->post_title);
                    $result = json_decode($result);
                    if(isset($result->error->message)){
                        $aiomatic_result['msg'] = $result->error->message;
                    }
                    else{
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['data'] = $result;
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'Fine Tune not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_other_finetune()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning other events');
            if(
                isset($_POST['id'])
                && !empty($_POST['id'])
                && isset($_POST['type'])
                && !empty($_POST['type'])
                && in_array($_POST['type'], array('hyperparameters','result_files','training_file','events'))
            ){
                $aiomatic_type = sanitize_text_field($_POST['type']);
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
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
                    $result = $open_ai->retrieveFineTune($aiomatic_file->post_title);
                    $result = json_decode($result);
                    if(isset($result->error->message)){
                        $aiomatic_result['msg'] = $result->error->message;
                    }
                    elseif($aiomatic_type == 'events'){
                        $aiomatic_data = $result;
                        ob_start();
                        include (dirname(__FILE__) . "/training/" . $aiomatic_type . ".php"); 
                        $aiomatic_result['html'] = ob_get_clean();
                        $aiomatic_result['status'] = 'success';
                    }
                    elseif(isset($result->$aiomatic_type)){
                        $aiomatic_data = $result->$aiomatic_type;
                        ob_start();
                        include (dirname(__FILE__) . "/training/" . $aiomatic_type . ".php"); 
                        $aiomatic_result['html'] = ob_get_clean();
                        $aiomatic_result['status'] = 'success';
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'Fine Tune not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_delete_finetune_file()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning deletion');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
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
                    $result = $open_ai->deleteFile($aiomatic_file->post_title);
                    $result = json_decode($result);
                    if(isset($result->error->message)){
                        $aiomatic_result['msg'] = $result->error->message;
                    }
                    else{
                        wp_delete_post($aiomatic_file->ID, true);
                        $aiomatic_result['status'] = 'success';
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'File not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_delete_finetune()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning single deletion');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
                    if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                    {
                        $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
                    }
                    $ft_model = get_post_meta($aiomatic_file->ID,'aiomatic_name',true);
                    if(!empty($ft_model)) {
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
                        $result = $open_ai->deleteFineTune($ft_model);
                        $result = json_decode($result);
                        if (isset($result->error)) {
                            $aiomatic_result['msg'] = $result->error->message;
                        } else {
                            update_post_meta($aiomatic_file->ID, 'aiomatic_deleted','1');
                            $aiomatic_result['status'] = 'success';
                        }
                    }
                    else{
                        $aiomatic_result['msg'] = 'That model does not exist';
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'File not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_cancel_finetune()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning canceling');
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $aiomatic_file = get_post(sanitize_text_field($_POST['id']));
                if($aiomatic_file){
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
                    {
                        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                        wp_send_json($aiomatic_result);
                    }
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    $open_ai = new OpenAi($token);
                    if(!$open_ai){
                        $aiomatic_result['msg'] = 'Missing API Setting';
                        wp_send_json($aiomatic_result);
                    }
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
                    $result = $open_ai->cancelFineTune($aiomatic_file->post_title);
                    $result = json_decode($result);
                    if(isset($result->error->message)){
                        $aiomatic_result['msg'] = $result->error->message;
                    }
                    else{
                        add_post_meta($aiomatic_file->ID, 'aiomatic_status', 'cancelled');
                        $aiomatic_result['status'] = 'success';
                    }
                }
                else{
                    $aiomatic_result['msg'] = 'File not found';
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_finetunes()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            global $wpdb;
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning in Aiomatic');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
            {
                $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                wp_send_json($aiomatic_result);
            }
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            $open_ai = new OpenAi($token);
            if(!$open_ai)
            {
                $aiomatic_result['msg'] = 'Missing API Setting';
                wp_send_json($aiomatic_result);
            }
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
            $result = $open_ai->listFineTunes();
            $result = json_decode($result);
            if(isset($result->error->message))
            {
                $aiomatic_result['msg'] = $result->error->message;
            }
            else
            {
                if(isset($result->data) && is_array($result->data) && count($result->data))
                {
                    $aiomatic_result['status'] = 'success';
                    $aiomaticExist = array();
                    $finetone_models = array();
                    foreach($result->data as $item){
                        $aiomaticExist[] = $item->id;
                        $aiomatic_check = $wpdb->get_row("SELECT * FROM ".$wpdb->posts." WHERE post_type='aiomatic_finetune' AND post_title='{$item->id}'");
                        if(!$aiomatic_check) {
                            $aiomatic_file_id = wp_insert_post(array(
                                'post_title' => $item->id,
                                'post_date' => date('Y-m-d H:i:s', $item->created_at),
                                'post_status' => 'publish',
                                'post_type' => 'aiomatic_finetune',
                            ));
                            if (!is_wp_error($aiomatic_file_id)) {
                                if($aiomatic_file_id === 0)
                                {
                                    $aiomatic_result['msg'] = 'Failed to create finetune to database.';
                                    wp_send_json($aiomatic_result);
                                }
                                add_post_meta($aiomatic_file_id, 'aiomatic_model', $item->model);
                                add_post_meta($aiomatic_file_id, 'aiomatic_updated_at', date('Y-m-d H:i:s', $item->finished_at));
                                add_post_meta($aiomatic_file_id, 'aiomatic_name', $item->fine_tuned_model);
                                add_post_meta($aiomatic_file_id, 'aiomatic_org', $item->organization_id);
                                add_post_meta($aiomatic_file_id, 'aiomatic_status', $item->status);
                                if(isset($item->result_files[0]))
                                {
                                    add_post_meta($aiomatic_file_id, 'aiomatic_fine_tune', $item->result_files[0]);
                                }
                                else
                                {
                                    add_post_meta($aiomatic_file_id, 'aiomatic_fine_tune', $item->training_file);
                                }
                            } else {
                                $aiomatic_result['status'] = 'error';
                                $aiomatic_result['msg'] = $aiomatic_file_id->get_error_message();
                                break;
                            }
                        }
                        else{
                            $aiomatic_file_id = $aiomatic_check->ID;
                            update_post_meta($aiomatic_check->ID, 'aiomatic_model', $item->model);
                            update_post_meta($aiomatic_check->ID, 'aiomatic_updated_at', date('Y-m-d H:i:s', $item->finished_at));
                            update_post_meta($aiomatic_check->ID, 'aiomatic_name', $item->fine_tuned_model);
                            update_post_meta($aiomatic_check->ID, 'aiomatic_org', $item->organization_id);
                            update_post_meta($aiomatic_check->ID, 'aiomatic_status', $item->status);
                            if(isset($item->result_files[0]))
                            {
                                update_post_meta($aiomatic_check->ID, 'aiomatic_fine_tune', $item->result_files[0]);
                            }
                            else
                            {
                                update_post_meta($aiomatic_check->ID, 'aiomatic_fine_tune', $item->training_file);
                            }
                        }
                        if(!empty($item->fine_tuned_model)) {
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
                            $resultModel = $open_ai->retrieveModel($item->fine_tuned_model);
                            $resultModel = json_decode($resultModel);
                            if(isset($resultModel->error)){
                                wp_delete_post($aiomatic_file_id, true);
                            }
                            elseif($item->status == 'succeeded'){
                                $finetone_models[] = $item->fine_tuned_model;
                            }
                        }
                    }
                    update_option('aiomatic_custom_models', $finetone_models);
                    if(count($aiomaticExist)){
                        $wpdb->query("DELETE FROM ".$wpdb->posts." WHERE post_type='aiomatic_finetune' AND post_title NOT IN ('".implode("','",$aiomaticExist)."')");
                    }
                    else{
                        $wpdb->query("DELETE FROM ".$wpdb->posts." WHERE post_type='aiomatic_finetune'");
                    }
                }
                else{
                    $aiomatic_result['status'] = 'success';
                    $wpdb->query("DELETE FROM ".$wpdb->posts." WHERE post_type='aiomatic_finetune'");
                    update_option('aiomatic_custom_models', array());
                }
            }
            wp_send_json($aiomatic_result);
        }

        public function aiomatic_save_files($items)
        {
            global $wpdb;
            $aiomaticExist = array();
            foreach($items as $item){
                if($item->purpose !== 'fine-tune-results' && $item->status != 'deleted') {
                    $aiomatic_check = $wpdb->get_row("SELECT * FROM " . $wpdb->posts . " WHERE post_type='aiomatic_file' AND post_title='{$item->id}'");
                    $aiomaticExist[] = $item->id;
                    if (!$aiomatic_check) {
                        $aiomatic_file_id = wp_insert_post(array(
                            'post_title' => $item->id,
                            'post_date' => date('Y-m-d H:i:s', $item->created_at),
                            'post_status' => 'publish',
                            'post_type' => 'aiomatic_file',
                        ));
                        if (!is_wp_error($aiomatic_file_id)) {
                            if($aiomatic_file_id === 0)
                            {
                                aiomatic_log_to_file('Error when saving file ID ' . $item->id);
                                break;
                            }
                            add_post_meta($aiomatic_file_id, 'aiomatic_filename', $item->filename);
                            add_post_meta($aiomatic_file_id, 'aiomatic_purpose', $item->purpose);
                            add_post_meta($aiomatic_file_id, 'aiomatic_file_size', $item->bytes);
                        } else {
                            aiomatic_log_to_file('Error when saving file ' . $aiomatic_file_id->get_error_message());
                            break;
                        }
                    } else {
                        update_post_meta($aiomatic_check->ID, 'aiomatic_filename', $item->filename);
                        update_post_meta($aiomatic_check->ID, 'aiomatic_purpose', $item->purpose);
                        update_post_meta($aiomatic_check->ID, 'aiomatic_file_size', $item->bytes);
                    }

                }
            }
            if(count($aiomaticExist)) {
                $wpdb->query("DELETE FROM " . $wpdb->posts . " WHERE post_type='aiomatic_file' AND post_title NOT IN ('" . implode("','", $aiomaticExist) . "')");
            }
            else{
                $wpdb->query("DELETE FROM ".$wpdb->posts." WHERE post_type='aiomatic_file'");
            }
        }

        public function aiomatic_files()
        {
            check_ajax_referer('openai-training-nonce', 'nonce');
            global $wpdb;
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning files');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
            {
                $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
                wp_send_json($aiomatic_result);
            }
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            $open_ai = new OpenAi($token);
            if(!$open_ai){
                $aiomatic_result['msg'] = 'Missing API Setting';
                wp_send_json($aiomatic_result);
            }
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
            $result = $open_ai->listFiles();
            $result = json_decode($result);
            if(isset($result->error->message)){
                $aiomatic_result['msg'] = $result->error->message;
            }
            else{
                if(isset($result->data) && is_array($result->data) && count($result->data)){
                    foreach($result->data as $ind => $rd)
                    {
                        if($rd->purpose != 'fine-tune' && $rd->purpose != 'fine-tune-results')
                        {
                            unset($result->data[$ind]);
                        }
                    }
                    $aiomatic_result['status'] = 'success';
                    $this->aiomatic_save_files($result->data);
                }
                else{
                    $aiomatic_result['status'] = 'success';
                    $wpdb->query("DELETE FROM ".$wpdb->posts." WHERE post_type='aiomatic_file'");
                }
            }
            wp_send_json($aiomatic_result);
        }
    }
    AiomaticFineTune::get_instance();
}
?>