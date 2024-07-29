<?php
defined('ABSPATH') or die();
use AiomaticOpenAI\OpenAi\OpenAi;
if(!class_exists('Aiomatic_Embeddings')) {
    class Aiomatic_Embeddings
    {
        private static  $instance = null ;
        private  $api_key = '' ;
        public static function get_instance($api_key)
        {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self($api_key);
            }
            return self::$instance;
        }

        public function __construct($api_key)
        {
            if(!aiomatic_is_aiomaticapi_key($api_key))
            {
                require_once (dirname(__FILE__) . "/openai/Url.php"); 
                require_once (dirname(__FILE__) . "/openai/OpenAi.php");
            }
            add_action('wp_ajax_aiomatic_embeddings',[$this,'aiomatic_embeddings']);
            $this->api_key = $api_key;
        }

        public function aiomatic_save_embedding($content, $post_type = '', $title = '', $embaddings_id = false, $model = 'text-embedding-ada-002', $namespace = '')
        {
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings saving');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
            {
                $aiomatic_result['msg'] = 'Missing API Setting';
                return $aiomatic_result;
            }
            else 
            {
                if (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure') 
                {
                    if(!aiomatic_is_aiomaticapi_key($this->api_key))
                    {
                        $openai = new OpenAi($this->api_key);
                        if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                        {
                            $openai->setORG($aiomatic_Main_Settings['openai_organization']);
                        }
                    }
                    else
                    {
                        $openai = true;
                    }
                }
                else
                {
                    $openai = true;
                }
            }
            $max_tokens = aiomatic_get_max_input_tokens($model);
            $in_tokens = count(aiomatic_encode($content));
            if($in_tokens > $max_tokens)
            {
                $content = aiomatic_strip_to_token_count($content, aiomatic_get_max_input_tokens($model), false);
            }
            if ((!isset($aiomatic_Main_Settings['embeddings_api']) || trim($aiomatic_Main_Settings['embeddings_api']) == '') || (isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'pinecone'))
            {
                if (!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                    return $aiomatic_result;
                }
                if (!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                    return $aiomatic_result;
                }
                $token = $this->api_key;
                $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
                if($openai)
                {
                    $aiomatic_pinecone_api = trim($aiomatic_Main_Settings['pinecone_app_id']);
                    $aiomatic_pinecone_environment = preg_replace("(^https?:\/\/)", "", trim($aiomatic_Main_Settings['pinecone_index']));
                    $headers = array(
                        'Content-Type' => 'application/json',
                        'Api-Key' => $aiomatic_pinecone_api
                    );
                    $response = wp_remote_get('https://'.$aiomatic_pinecone_environment,array(
                        'headers' => $headers
                    ));
                    if(is_wp_error($response)){
                        $aiomatic_result['msg'] = $response->get_error_message();
                        return $aiomatic_result;
                    }

                    $response_code = $response['response']['code'];
                    if($response_code !== 200){
                        $aiomatic_result['msg'] = $response['body'];
                        if(empty($aiomatic_result['msg'] ))
                        {
                            $aiomatic_result['msg'] = 'Error code returned for Pinecone Index: ' . $aiomatic_Main_Settings['pinecone_index'] . ': ' . $response_code . ' - index: ' . 'https://' . $aiomatic_pinecone_environment . '/databases';
                        }
                        return $aiomatic_result;
                    }
                    $embedding = '';
                    $session = aiomatic_get_session_id();
                    $maxResults = 1;
                    $query = new Aiomatic_Query($content, 2048, $model, 0, '', 'saveembeddings', 'embeddings', $token, $session, $maxResults, '', '');
                    if(aiomatic_google_extension_is_google_embeddings_model($model))
                    {
                        $error = '';
                        $response = aiomatic_generate_embeddings_google($model, $content, $error);
                        if($response === false)
                        {
                            $result['data'] = 'Failed to call Embeddings API: ' . $error;
                            return $result;
                        }
                        if(isset($response['error']))
                        {
                            $result['data'] = 'Error while processing AI response: ' . $response['error'];
                            return $result;
                        }
                        $embedding = $response;
                    }
                    else
                    {
                        if(aiomatic_is_aiomaticapi_key($this->api_key))
                        {
                            $error = '';
                            $response = aiomatic_embeddings_aiomaticapi($token, $model, $content, 0, $error);
                            if($response === false)
                            {
                                $result['data'] = 'Failed to call Embeddings API: ' . $error;
                                return $result;
                            }
                            if(isset($response->error))
                            {
                                $result['data'] = 'Error while processing AI response: ' . $response->error;
                                return $result;
                            }
                            if(!isset($response[0]->embedding))
                            {
                                $result['data'] = 'Failed to call Embeddings API: ' . print_r($response, true);
                                return $result;
                            }
                            apply_filters( 'aiomatic_ai_reply', $response, $query );
                            $embedding = $response[0]->embedding;
                        }
                        else
                        {
                            if (aiomatic_check_if_azure($aiomatic_Main_Settings)) 
                            {
                                $error = '';
                                $response = aiomatic_embeddings_azure($token, $model, $content, 0, $error);
                                if($response === false)
                                {
                                    $result['data'] = 'Failed to call Embeddings API: ' . $error;
                                    return $result;
                                }
                                else
                                {
                                    $embedding = (array)$response[0]->embedding;
                                    apply_filters( 'aiomatic_ai_reply', $response, $query );
                                }
                            }
                            else
                            {
                                $response = $openai->embeddings(array(
                                    'input' => $content,
                                    'model' => $model
                                ));
                            
                                $response = json_decode($response, true);
                                if(isset($response['error']) && !empty($response['error'])) {
                                    $aiomatic_result['msg'] = $response['error']['message'];
                                }
                                else{
                                    $embedding = $response['data'][0]['embedding'];
                                    apply_filters( 'aiomatic_ai_reply', $response, $query );
                                }
                            }
                        }
                    }
                    if(empty($embedding))
                    {
                        if($aiomatic_result['msg'] == 'Something went wrong with embeddings processing')
                        {
                            $aiomatic_result['msg'] = 'No data returned';
                        }
                    }
                    else
                    {
                        $pinecone_url = 'https://' . $aiomatic_pinecone_environment . '/vectors/upsert';
                        if(!$embaddings_id) {
                            if(function_exists('mb_substr'))
                            {
                                $embedding_title = empty($title) ? mb_substr($content, 0, 50, 'UTF-8') : $title;
                            }
                            else
                            {
                                $embedding_title = empty($title) ? substr($content, 0, 50) : $title;
                            }
                            $embedding_data = array(
                                'post_type' => 'aiomatic_embeddings',
                                'post_title' => $embedding_title,
                                'post_content' => $content,
                                'post_status' => 'publish'
                            );
                            if (!empty($post_type)) {
                                $embedding_data['post_type'] = $post_type;
                            }
                            remove_filter('content_save_pre', 'wp_filter_post_kses');
                            remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                            $embaddings_id = wp_insert_post($embedding_data);
                            add_filter('content_save_pre', 'wp_filter_post_kses');
                            add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                        }
                        if(is_wp_error($embaddings_id))
                        {
                            $aiomatic_result['msg'] = $embaddings_id->get_error_message();
                        }
                        elseif($embaddings_id === 0)
                        {
                            $aiomatic_result['msg'] = 'Failed to insert embedding to database: ' . $embedding_title;
                        }
                        else 
                        {
                            if(empty($namespace))
                            {
                                if (isset($aiomatic_Main_Settings['pinecone_namespace']) && trim($aiomatic_Main_Settings['pinecone_namespace']) != '')
                                {
                                    update_post_meta($embaddings_id, 'aiomatic_namespace', trim($aiomatic_Main_Settings['pinecone_namespace']));
                                }
                            }
                            else
                            {
                                update_post_meta($embaddings_id, 'aiomatic_namespace', trim($namespace));
                            }
                            update_post_meta($embaddings_id, 'aiomatic_start',time());
                            if(aiomatic_is_aiomaticapi_key($this->api_key) || (aiomatic_check_if_azure($aiomatic_Main_Settings)))
                            {
                                $usage_tokens = count(aiomatic_encode($content));
                            }
                            else
                            {
                                $usage_tokens = $response['usage']['total_tokens'];
                            }
                            add_post_meta($embaddings_id, 'aiomatic_embedding_token', $usage_tokens);
                            add_post_meta($embaddings_id, 'aiomatic_embedding_model', $model);
                            $vectors = array(
                                array(
                                    'id' => (string)$embaddings_id,
                                    'values' => $embedding
                                )
                            );
                            $sendjs = array('vectors' => $vectors);
                            if(empty($namespace))
                            {
                                if (isset($aiomatic_Main_Settings['pinecone_namespace']) && trim($aiomatic_Main_Settings['pinecone_namespace']) != '')
                                {
                                    $sendjs['namespace'] = trim($aiomatic_Main_Settings['pinecone_namespace']);
                                }
                            }
                            else
                            {
                                $sendjs['namespace'] = trim($namespace);
                            }
                            $response = wp_remote_post($pinecone_url, array(
                                'headers' => $headers,
                                'body' => json_encode($sendjs)
                            ));
                            if(is_wp_error($response))
                            {
                                $aiomatic_result['msg'] = $response->get_error_message();
                                wp_delete_post($embaddings_id);
                            }
                            else
                            {
                                $body = json_decode($response['body'],true);
                                if($body)
                                {
                                    if(isset($body['code']) && isset($body['message']))
                                    {
                                        $aiomatic_result['msg'] = strip_tags($body['message']);
                                        wp_delete_post($embaddings_id);
                                    }
                                    else
                                    {
                                        $aiomatic_result['status'] = 'success';
                                        $aiomatic_result['id'] = $embaddings_id;
                                        update_post_meta($embaddings_id, 'aiomatic_completed', time());
                                    }
                                }
                                else
                                {
                                    $aiomatic_result['msg'] = 'No data returned';
                                    wp_delete_post($embaddings_id);
                                }
                            }
                        }
                    }
                }
                else
                {
                    $aiomatic_result['msg'] = 'Missing OpenAI API Settings';
                }
            }
            elseif(isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'qdrant')
            {
                if (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                    return $aiomatic_result;
                }
                if (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Quadrant index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                    return $aiomatic_result;
                }
                $token = $this->api_key;
                $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
                if($openai)
                {
                    $aiomatic_qdrant_api = trim($aiomatic_Main_Settings['qdrant_app_id']);
                    $aiomatic_qdrant_environment = rtrim(trim($aiomatic_Main_Settings['qdrant_index'], '/'));
                    $aiomatic_qdrant_environment = preg_replace("(^https?:\/\/)", "", $aiomatic_qdrant_environment);
                    $qdrant_url = 'https://' . $aiomatic_qdrant_environment;
                    $embedding = '';
                    $session = aiomatic_get_session_id();
                    $maxResults = 1;
                    $query = new Aiomatic_Query($content, 2048, $model, 0, '', 'saveembeddings', 'embeddings', $token, $session, $maxResults, '', '');
                    if(aiomatic_google_extension_is_google_embeddings_model($model))
                    {
                        $error = '';
                        $response = aiomatic_generate_embeddings_google($model, $content, $error);
                        if($response === false)
                        {
                            $result['data'] = 'Failed to call Embeddings API: ' . $error;
                            return $result;
                        }
                        if(isset($response['error']))
                        {
                            $result['data'] = 'Error while processing AI response: ' . $response['error'];
                            return $result;
                        }
                        $embedding = $response;
                    }
                    else
                    {
                        if(aiomatic_is_aiomaticapi_key($this->api_key))
                        {
                            $error = '';
                            $response = aiomatic_embeddings_aiomaticapi($token, $model, $content, 0, $error);
                            if($response === false)
                            {
                                $result['data'] = 'Failed to call Embeddings API: ' . $error;
                                return $result;
                            }
                            if(isset($response->error))
                            {
                                $result['data'] = 'Error while processing AI response: ' . $response->error;
                                return $result;
                            }
                            if(!isset($response[0]->embedding))
                            {
                                $result['data'] = 'Failed to call Embeddings API: ' . print_r($response, true);
                                return $result;
                            }
                            apply_filters( 'aiomatic_ai_reply', $response, $query );
                            $embedding = $response[0]->embedding;
                        }
                        else
                        {
                            if (aiomatic_check_if_azure($aiomatic_Main_Settings)) 
                            {
                                $error = '';
                                $response = aiomatic_embeddings_azure($token, $model, $content, 0, $error);
                                if($response === false)
                                {
                                    $result['data'] = 'Failed to call Embeddings API: ' . $error;
                                    return $result;
                                }
                                else
                                {
                                    $embedding = (array)$response[0]->embedding;
                                    apply_filters( 'aiomatic_ai_reply', $response, $query );
                                }
                            }
                            else
                            {
                                $response = $openai->embeddings(array(
                                    'input' => $content,
                                    'model' => $model
                                ));
                            
                                $response = json_decode($response, true);
                                if(isset($response['error']) && !empty($response['error'])) {
                                    $aiomatic_result['msg'] = $response['error']['message'];
                                }
                                else{
                                    $embedding = $response['data'][0]['embedding'];
                                    apply_filters( 'aiomatic_ai_reply', $response, $query );
                                }
                            }
                        }
                    }
                    if(empty($embedding))
                    {
                        if($aiomatic_result['msg'] == 'Something went wrong with embeddings processing')
                        {
                            $aiomatic_result['msg'] = 'No data returned';
                        }
                    }
                    else
                    {
                        if(empty($namespace))
                        {
                            if (isset($aiomatic_Main_Settings['qdrant_name']) && trim($aiomatic_Main_Settings['qdrant_name']) != '')
                            {
                                $index_name = $aiomatic_Main_Settings['qdrant_name'];
                            }
                            else
                            {
                                $index_name = 'qdrant';
                            }
                        }
                        else
                        {
                            $index_name = trim($namespace);
                        }
                        try
                        {
                            require_once (dirname(__FILE__) . "/Qdrant.php");
                            $my_indexes = aiomatic_qdrant_list_indexes($aiomatic_qdrant_api, $qdrant_url);
                            $found = false;
                            foreach($my_indexes as $mid)
                            {
                                if($mid['name'] == $index_name)
                                {
                                    $found = true;
                                }
                            }
                            if($found == false)
                            {
                                aiomatic_qdrant_add_index($aiomatic_qdrant_api, $qdrant_url, $index_name);
                            }
                            if(!$embaddings_id) {
                                if(function_exists('mb_substr'))
                                {
                                    $embedding_title = empty($title) ? mb_substr($content, 0, 50, 'UTF-8') : $title;
                                }
                                else
                                {
                                    $embedding_title = empty($title) ? substr($content, 0, 50) : $title;
                                }
                                $embedding_data = array(
                                    'post_type' => 'aiomatic_embeddings',
                                    'post_title' => $embedding_title,
                                    'post_content' => $content,
                                    'post_status' => 'publish'
                                );
                                if (!empty($post_type)) {
                                    $embedding_data['post_type'] = $post_type;
                                }
                                remove_filter('content_save_pre', 'wp_filter_post_kses');
                                remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                                $embaddings_id = wp_insert_post($embedding_data);
                                add_filter('content_save_pre', 'wp_filter_post_kses');
                                add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                            }
                            if(is_wp_error($embaddings_id))
                            {
                                $aiomatic_result['msg'] = $embaddings_id->get_error_message();
                            }
                            elseif($embaddings_id === 0)
                            {
                                $aiomatic_result['msg'] = 'Failed to insert embedding to database: ' . $embedding_title;
                            }
                            else 
                            {
                                if(empty($namespace))
                                {
                                    if (isset($aiomatic_Main_Settings['qdrant_name']) && trim($aiomatic_Main_Settings['qdrant_name']) != '')
                                    {
                                        update_post_meta($embaddings_id, 'aiomatic_namespace', trim($aiomatic_Main_Settings['qdrant_name']));
                                    }
                                }
                                else
                                {
                                    update_post_meta($embaddings_id, 'aiomatic_namespace', trim($namespace));
                                }
                                update_post_meta($embaddings_id, 'aiomatic_start',time());
                                if(aiomatic_is_aiomaticapi_key($this->api_key) || (aiomatic_check_if_azure($aiomatic_Main_Settings)))
                                {
                                    $usage_tokens = count(aiomatic_encode($content));
                                }
                                else
                                {
                                    $usage_tokens = $response['usage']['total_tokens'];
                                }
                                add_post_meta($embaddings_id, 'aiomatic_embedding_token', $usage_tokens);
                                add_post_meta($embaddings_id, 'aiomatic_embedding_model', $model);
                                $vector = array(
                                    'id' => (string)$embaddings_id,
                                    'values' => $embedding
                                );
                                $quadrant_id = aiomatic_qdrant_add_vector( $aiomatic_qdrant_api, $qdrant_url, $index_name, $vector );
                                $aiomatic_result['status'] = 'success';
                                $aiomatic_result['id'] = $embaddings_id;
                                update_post_meta($embaddings_id, 'aiomatic_completed', time());
                                update_post_meta($embaddings_id, 'quadrant_id', $quadrant_id);
                            }
                        }
                        catch(Exception $e)
                        {
                            $aiomatic_result['msg'] = 'Qdrant exception: ' . $e->getMessage();
                            wp_delete_post($embaddings_id);
                        }
                    }
                }
                else
                {
                    $aiomatic_result['msg'] = 'Missing OpenAI API Settings';
                }
            }
            else
            {
                $aiomatic_result['msg'] = 'Unrecognized embeddings provider selected';
            }
            return $aiomatic_result;
        }
        public function aiomatic_get_embedding_data($content, $model = 'text-embedding-ada-002')
        {
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings saving');
            $embedding = '';
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
            {
                $aiomatic_result['msg'] = 'Missing API Setting';
                return $aiomatic_result;
            }
            else 
            {
                if (!isset($aiomatic_Main_Settings['api_selector']) || trim($aiomatic_Main_Settings['api_selector']) != 'azure') 
                {
                    if(!aiomatic_is_aiomaticapi_key($this->api_key))
                    {
                        $openai = new OpenAi($this->api_key);
                        if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
                        {
                            $openai->setORG($aiomatic_Main_Settings['openai_organization']);
                        }
                    }
                    else
                    {
                        $openai = true;
                    }
                }
                else
                {
                    $openai = true;
                }
            }
            $max_tokens = aiomatic_get_max_input_tokens($model);
            $in_tokens = count(aiomatic_encode($content));
            if($in_tokens > $max_tokens)
            {
                $content = aiomatic_strip_to_token_count($content, aiomatic_get_max_input_tokens($model), false);
            }
            $token = $this->api_key;
            $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
            if($openai)
            {
                $session = aiomatic_get_session_id();
                $maxResults = 1;
                $query = new Aiomatic_Query($content, 2048, $model, 0, '', 'saveembeddings', 'embeddings', $token, $session, $maxResults, '', '');
                if(aiomatic_google_extension_is_google_embeddings_model($model))
                {
                    $error = '';
                    $response = aiomatic_generate_embeddings_google($model, $content, $error);
                    if($response === false)
                    {
                        $result['msg'] = 'Failed to call Embeddings API: ' . $error;
                        return $result;
                    }
                    if(isset($response['error']))
                    {
                        $result['msg'] = 'Error while processing AI response: ' . $response['error'];
                        return $result;
                    }
                    $embedding = $response;
                }
                else
                {
                    if(aiomatic_is_aiomaticapi_key($this->api_key))
                    {
                        $error = '';
                        $response = aiomatic_embeddings_aiomaticapi($token, $model, $content, 0, $error);
                        if($response === false)
                        {
                            $result['msg'] = 'Failed to call Embeddings API: ' . $error;
                            return $result;
                        }
                        if(isset($response->error))
                        {
                            $result['msg'] = 'Error while processing AI response: ' . $response->error;
                            return $result;
                        }
                        if(!isset($response[0]->embedding))
                        {
                            $result['msg'] = 'Failed to call Embeddings API: ' . print_r($response, true);
                            return $result;
                        }
                        apply_filters( 'aiomatic_ai_reply', $response, $query );
                        $embedding = $response[0]->embedding;
                    }
                    else
                    {
                        if (aiomatic_check_if_azure($aiomatic_Main_Settings)) 
                        {
                            $error = '';
                            $response = aiomatic_embeddings_azure($token, $model, $content, 0, $error);
                            if($response === false)
                            {
                                $result['msg'] = 'Failed to call Embeddings API: ' . $error;
                                return $result;
                            }
                            else
                            {
                                $embedding = (array)$response[0]->embedding;
                                apply_filters( 'aiomatic_ai_reply', $response, $query );
                            }
                        }
                        else
                        {
                            $response = $openai->embeddings(array(
                                'input' => $content,
                                'model' => $model
                            ));
                        
                            $response = json_decode($response, true);
                            if(isset($response['error']) && !empty($response['error'])) {
                                $aiomatic_result['msg'] = $response['error']['message'];
                            }
                            else{
                                $embedding = $response['data'][0]['embedding'];
                                apply_filters( 'aiomatic_ai_reply', $response, $query );
                            }
                        }
                    }
                }
                if(empty($embedding))
                {
                    if($aiomatic_result['msg'] == 'Something went wrong with embeddings processing')
                    {
                        $aiomatic_result['msg'] = 'No data returned';
                    }
                }
                else
                {
                    unset($aiomatic_result['msg']);
                    $aiomatic_result['data'] = $embedding;
                    $aiomatic_result['status'] = 'success';
                }
            }
            else
            {
                $aiomatic_result['msg'] = 'Missing OpenAI API Settings';
            }
            return $aiomatic_result;
        }
        public function aiomatic_delete_embedding($embaddings_id)
        {
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings deletion');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if ((!isset($aiomatic_Main_Settings['embeddings_api']) || trim($aiomatic_Main_Settings['embeddings_api']) == '') || (isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'pinecone'))
            {
                if (!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
                elseif (!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                }
                else
                {
                    $aiomatic_pinecone_api = trim($aiomatic_Main_Settings['pinecone_app_id']);
                    $aiomatic_pinecone_environment = preg_replace("(^https?:\/\/)", "", trim($aiomatic_Main_Settings['pinecone_index']));    
                    $pinecone_url = 'https://' . $aiomatic_pinecone_environment . '/vectors/delete';
                    $headers = array(
                        'Content-Type' => 'application/json',
                        'Api-Key' => $aiomatic_pinecone_api
                    );
                    $pinecone_ids = 'ids='. $embaddings_id;
                    try 
                    {
                        wp_remote_request('https://' . $aiomatic_pinecone_environment . '/vectors/delete?'.$pinecone_ids, array(
                            'method' => 'DELETE',
                            'headers' => $headers
                        ));
                        $response = wp_remote_post($pinecone_url, array(
                            'headers' => $headers,
                            'body' => json_encode(array('ids' => array($embaddings_id)))
                        ));
                        if(is_wp_error($response)){
                            $aiomatic_result['msg'] = $response->get_error_message();
                            wp_delete_post($embaddings_id);
                        }
                        elseif(wp_remote_retrieve_response_code( $response ) != 200)
                        {
                            $aiomatic_result['msg'] = 'Invalid response from API: ' . wp_remote_retrieve_response_code( $response );
                            wp_delete_post($embaddings_id);
                        }
                        else
                        {
                            $aiomatic_result['status'] = 'success';
                            $aiomatic_result['id'] = $embaddings_id;
                            wp_delete_post($embaddings_id);
                        }
                    }
                    catch (\Exception $e){
                        $aiomatic_result['msg'] = 'Exception thrown: ' . $e->getMessage();
                        wp_delete_post($embaddings_id);
                    }
                }
            }
            elseif(isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'qdrant')
            {
                if (isset($aiomatic_Main_Settings['qdrant_name']) && trim($aiomatic_Main_Settings['qdrant_name']) != '') 
                {
                    $index_name = $aiomatic_Main_Settings['qdrant_name'];
                }
                else
                {
                    $index_name = 'qdrant';
                }
                if (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
                elseif (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                }
                else
                {
                    $aiomatic_qdrant_api = trim($aiomatic_Main_Settings['qdrant_app_id']);
                    $aiomatic_qdrant_environment = rtrim(trim($aiomatic_Main_Settings['qdrant_index'], '/'));
                    $aiomatic_qdrant_environment = preg_replace("(^https?:\/\/)", "", $aiomatic_qdrant_environment);
                    $qdrant_url = 'https://' . $aiomatic_qdrant_environment;

                    $quadrant_id = get_post_meta($embaddings_id, 'quadrant_id', true);
                    if(empty($quadrant_id))
                    {
                        $aiomatic_result['msg'] = 'Qdrant ID not found: ' . $embaddings_id;
                        wp_delete_post($embaddings_id);
                    }
                    else
                    {
                        try
                        {
                            require_once (dirname(__FILE__) . "/Qdrant.php");
                            aiomatic_qdrant_delete_vectors( $aiomatic_qdrant_api, $qdrant_url, $index_name, array($quadrant_id) );
                            $aiomatic_result['status'] = 'success';
                            $aiomatic_result['id'] = $embaddings_id;
                            wp_delete_post($embaddings_id);
                        }
                        catch(Exception $e)
                        {
                            $aiomatic_result['msg'] = 'Exception thrown: ' . $e->getMessage();
                            wp_delete_post($embaddings_id);
                        }
                    }
                }
            }
            else
            {
                $aiomatic_result['msg'] = 'Unrecognized embeddings provider selected';
            }
            return $aiomatic_result;
        }
        public function aiomatic_delete_embeddings_ids($ids)
        {
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings ids');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if ((!isset($aiomatic_Main_Settings['embeddings_api']) || trim($aiomatic_Main_Settings['embeddings_api']) == '') || (isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'pinecone'))
            {
                if (!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
                elseif (!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                }
                else
                {
                    $aiomatic_pinecone_api = trim($aiomatic_Main_Settings['pinecone_app_id']);
                    $aiomatic_pinecone_environment = preg_replace("(^https?:\/\/)", "", trim($aiomatic_Main_Settings['pinecone_index']));   
                    try {
                        $headers = array(
                            'Content-Type' => 'application/json',
                            'Api-Key' => $aiomatic_pinecone_api
                        );
                        $pinecone_ids = '';
                        foreach ($ids as $id){
                            $pinecone_ids = empty($pinecone_ids) ? 'ids='. $id : '&ids=' . $id;
                        }
                        $response = wp_remote_request('https://' . $aiomatic_pinecone_environment . '/vectors/delete?'.$pinecone_ids, array(
                            'method' => 'DELETE',
                            'headers' => $headers
                        ));
                        if(is_wp_error($response)){
                            $aiomatic_result['msg'] = $response->get_error_message();
                        }
                        elseif(wp_remote_retrieve_response_code( $response ) != 200)
                        {
                            $aiomatic_result['msg'] = 'Invalid response from API: ' . wp_remote_retrieve_response_code( $response );
                        }
                        else
                        {
                            $aiomatic_result['status'] = 'success';
                        }
                    }
                    catch (\Exception $exception){

                    }
                    foreach ($ids as $id){
                        wp_delete_post($id);
                    }
                }
            }
            elseif(isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'qdrant')
            {
                if (isset($aiomatic_Main_Settings['qdrant_name']) && trim($aiomatic_Main_Settings['qdrant_name']) != '') 
                {
                    $index_name = $aiomatic_Main_Settings['qdrant_name'];
                }
                else
                {
                    $index_name = 'qdrant';
                }
                if (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
                elseif (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                }
                else
                {
                    $aiomatic_qdrant_api = trim($aiomatic_Main_Settings['qdrant_app_id']);
                    $aiomatic_qdrant_environment = rtrim(trim($aiomatic_Main_Settings['qdrant_index'], '/'));
                    $aiomatic_qdrant_environment = preg_replace("(^https?:\/\/)", "", $aiomatic_qdrant_environment);
                    $qdrant_url = 'https://' . $aiomatic_qdrant_environment;
                    $quadrant_ids = array();
                    foreach ($ids as $embaddings_id){
                        $quadrant_id = get_post_meta($embaddings_id, 'quadrant_id', true);
                        if(!empty($quadrant_id))
                        {
                            $quadrant_ids[] = $quadrant_id;
                        }
                    }
                    try
                    {
                        if(!empty($quadrant_ids))
                        {
                            require_once (dirname(__FILE__) . "/Qdrant.php");
                            aiomatic_qdrant_delete_vectors( $aiomatic_qdrant_api, $qdrant_url, $index_name, $quadrant_ids );
                        }
                        $aiomatic_result['status'] = 'success';
                    }
                    catch(Exception $e)
                    {
                        $aiomatic_result['msg'] = 'Exception thrown: ' . $e->getMessage();
                    }
                    foreach ($ids as $id)
                    {
                        wp_delete_post($id);
                    }
                }
            }
            else
            {
                $aiomatic_result['msg'] = 'Unrecognized embeddings provider selected';
            }
            return $aiomatic_result;
        }
        public function aiomatic_deleteall_embeddings()
        {
            global $wpdb;
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings general deletion');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if ((!isset($aiomatic_Main_Settings['embeddings_api']) || trim($aiomatic_Main_Settings['embeddings_api']) == '') || (isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'pinecone'))
            {
                if (!isset($aiomatic_Main_Settings['pinecone_app_id']) || trim($aiomatic_Main_Settings['pinecone_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
                elseif (!isset($aiomatic_Main_Settings['pinecone_index']) || trim($aiomatic_Main_Settings['pinecone_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Pinecone index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                }
                else
                {
                    $ids = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE post_type='aiomatic_embeddings'");
                    $ids = wp_list_pluck($ids,'ID');
                    if(count($ids)) {
                        $aiomatic_result = $this->aiomatic_delete_embeddings_ids($ids);
                    }
                    else
                    {
                        $aiomatic_result['msg'] = 'No embeddings found to delete!';
                    }
                }
            }
            elseif(isset($aiomatic_Main_Settings['embeddings_api']) && trim($aiomatic_Main_Settings['embeddings_api']) == 'qdrant')
            {
                if (!isset($aiomatic_Main_Settings['qdrant_app_id']) || trim($aiomatic_Main_Settings['qdrant_app_id']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant API key in the plugin\'s \'Settings\' menu (API Keys tab), before you can use this feature!';
                }
                elseif (!isset($aiomatic_Main_Settings['qdrant_index']) || trim($aiomatic_Main_Settings['qdrant_index']) == '') 
                {
                    $aiomatic_result['msg'] = 'You must add a Qdrant index in the plugin\'s \'Settings\' menu (Embeddings tab), before you can use this feature!';
                }
                else
                {
                    $ids = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE post_type='aiomatic_embeddings'");
                    $ids = wp_list_pluck($ids,'ID');
                    if(count($ids)) {
                        $aiomatic_result = $this->aiomatic_delete_embeddings_ids($ids);
                    }
                    else
                    {
                        $aiomatic_result['msg'] = 'No embeddings found to delete!';
                    }
                }
            }
            else
            {
                $aiomatic_result['msg'] = 'Unrecognized embeddings provider selected';
            }
            return $aiomatic_result;
        }

        public function aiomatic_embeddings()
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['embeddings_model']) && $aiomatic_Main_Settings['embeddings_model'] != '') 
            {
                $model = $aiomatic_Main_Settings['embeddings_model'];
            }
            else
            {
                $model = 'text-embedding-ada-002';
            }
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings processing');
            if(isset($_POST['content']) && !empty($_POST['content']))
            {
                $content = wp_kses_post(strip_tags($_POST['content']));
                if(!empty($content)){
                    $aiomatic_result = $this->aiomatic_save_embedding($content, '', '', false, $model, '');
                }
                else 
                {
                    $aiomatic_result['msg'] = 'Please insert your content first!';
                }
            }
            wp_send_json($aiomatic_result);
        }
        public function aiomatic_create_single_embedding($embeddings_str)
        {
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings creation');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['embeddings_model']) && $aiomatic_Main_Settings['embeddings_model'] != '') 
            {
                $model = $aiomatic_Main_Settings['embeddings_model'];
            }
            else
            {
                $model = 'text-embedding-ada-002';
            }
            $content = wp_kses_post(strip_tags($embeddings_str));
            if(!empty($content)){
                $aiomatic_result = $this->aiomatic_save_embedding($content, '', '', false, $model, '');
            }
            wp_send_json($aiomatic_result);
        }
        public function aiomatic_create_single_embedding_nojson($embeddings_str)
        {
            $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings nojson creation');
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['embeddings_model']) && $aiomatic_Main_Settings['embeddings_model'] != '') 
            {
                $model = $aiomatic_Main_Settings['embeddings_model'];
            }
            else
            {
                $model = 'text-embedding-ada-002';
            }
            $content = wp_kses_post(strip_tags($embeddings_str));
            if(!empty($content)){
                $aiomatic_result = $this->aiomatic_save_embedding($content, '', '', false, $model, '');
            }
            return $aiomatic_result;
        }
        public function aiomatic_create_embeddings($embeddings_str)
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['embeddings_model']) && $aiomatic_Main_Settings['embeddings_model'] != '') 
            {
                $model = $aiomatic_Main_Settings['embeddings_model'];
            }
            else
            {
                $model = 'text-embedding-ada-002';
            }
            $aiomatic_result = array('status' => 'error', 'msg' => 'No embeddings could be saved');
            $embeddings_str_arr = preg_split('/\r\n|\r|\n/', $embeddings_str);
            foreach($embeddings_str_arr as $embedme)
            {
                $content = wp_kses_post(strip_tags($embedme));
                if(!empty($content)){
                    $aiomatic_result = $this->aiomatic_save_embedding($content, '', '', false, $model, '');
                }
            }
            wp_send_json($aiomatic_result);
        }
    }
}
