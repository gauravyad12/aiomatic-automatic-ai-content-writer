<?php
defined('ABSPATH') or die();
function aiomatic_save_assistant($token, $title, $model, $prompt, $description, $temperature, $topp, $assistant_first_message, $avatar, $code_interpreter, $file_search, $assistant_files, $functions_str = '')
{
    require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
    $vector_store_id = '';
    $assistant_id = '';
    if(empty($title))
    {
        $aiomatic_result['msg'] = 'You need to add a name for the assistant!';
        return $aiomatic_result;
    }
    if(empty($model))
    {
        $aiomatic_result['msg'] = 'You need to add a model for the assistant!';
        return $aiomatic_result;
    }
    $files_ok = false;
    $tools = [];
    if($code_interpreter == 'on')
    {
        $tools[] = ['type' => 'code_interpreter'];
        $files_ok = true;
    }
    if($file_search == 'on')
    {
        $tools[] = ['type' => 'file_search'];
        $files_ok = true;
    }
    $functions_json = json_decode($functions_str, true);
    if($functions_json === null)
    {
        $functions = array();
    }
    else
    {
        if(is_array($functions_json) && !isset($functions_json['name']))
        {
            $functions = $functions_json;
        }
        elseif(isset($functions_json['name']))
        {
            $functions = array($functions_json);
        }
        else
        {
            $functions = array();
        }
    }
    foreach($functions as $func)
    {
        $tools[] = ['type' => 'function', 'function' => $func];
    }
    if($files_ok === false)
    {
        $assistant_files = [];
    }
    try
    {
        $metadata = '';
        $assistantData = aiomatic_openai_save_assistant(
            $token,
            $model,
            $title,
            $description,
            $temperature,
            $topp,
            $prompt,
            $tools,
            $assistant_files,
            $metadata,
            $vector_store_id
        );
        if($assistantData === false)
        {
            $aiomatic_result['msg'] = 'Failed to save assistant using the API';
            return $aiomatic_result;
        }
        if(!isset($assistantData['id']))
        {
            $aiomatic_result['msg'] = 'Failed to decode assistant saving request: ' . print_r($assistantData, true);
            return $aiomatic_result;
        }
        $assistant_id = $assistantData['id'];
    }
    catch(Exception $e)
    {
        $aiomatic_result['msg'] = 'Exception occured during Assistant saving: ' . $e->getMessage();
        return $aiomatic_result;
    }
    if(empty($assistant_id))
    {
        $aiomatic_result['msg'] = 'Failed to insert assistant to AI service: ' . $title;
        return $aiomatic_result;
    }
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong assistant saving');
    $assistant_data = array(
        'post_type' => 'aiomatic_assistants',
        'post_title' => $title,
        'post_content' => $prompt,
        'post_excerpt' => $description,
        'post_status' => 'publish'
    );
    remove_filter('content_save_pre', 'wp_filter_post_kses');
    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
    $local_assistant_id = wp_insert_post($assistant_data);
    add_filter('content_save_pre', 'wp_filter_post_kses');
    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
    if(is_wp_error($local_assistant_id))
    {
        $aiomatic_result['msg'] = $local_assistant_id->get_error_message();
    }
    elseif($local_assistant_id === 0)
    {
        $aiomatic_result['msg'] = 'Failed to insert assistant to database: ' . $title;
    }
    else 
    {
        update_post_meta($local_assistant_id, '_assistant_id', $assistant_id);
        if(!empty($assistant_first_message))
        {
            update_post_meta($local_assistant_id, '_assistant_first_message', $assistant_first_message);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_first_message', '');
        }
        if(!empty($model))
        {
            update_post_meta($local_assistant_id, '_assistant_model', $model);
        }
        if(!empty($vector_store_id))
        {
            update_post_meta($local_assistant_id, '_assistant_vector_store_id', $vector_store_id);
        }
        if(!empty($tools))
        {
            update_post_meta($local_assistant_id, '_assistant_tools', $tools);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_tools', array());
        }
        if(!empty($temperature))
        {
            update_post_meta($local_assistant_id, '_assistant_temperature', $temperature);
        }
        if(!empty($topp))
        {
            update_post_meta($local_assistant_id, '_assistant_topp', $topp);
        }
        if(!empty($assistant_files))
        {
            update_post_meta($local_assistant_id, '_assistant_files', $assistant_files);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_files', array());
        }
        if(!empty($avatar))
        {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $res2 = set_post_thumbnail($local_assistant_id, $avatar);
            if ($res2 === FALSE) 
            {
                $aiomatic_result['msg'] = 'Failed to insert assistant avatar to database: ' . $avatar;
            }
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $local_assistant_id;
    }
    return $aiomatic_result;
}
function aiomatic_update_assistant($token, $assistant_id, $assistant_id_local, $title, $model, $prompt, $description, $temperature, $topp, $assistant_first_message, $avatar, $code_interpreter, $file_search, $assistant_files, $functions_str = '')
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong assistant updating');
    require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
    if(empty($title))
    {
        $aiomatic_result['msg'] = 'You need to add a name for the assistant!';
        return $aiomatic_result;
    }
    if(empty($model))
    {
        $aiomatic_result['msg'] = 'You need to add a model for the assistant!';
        return $aiomatic_result;
    }
    $vector_store_id = null;
    $files_ok = false;
    $tools = [];
    if($code_interpreter == 'on')
    {
        $tools[] = ['type' => 'code_interpreter'];
        $files_ok = true;
    }
    if($file_search == 'on')
    {
        $tools[] = ['type' => 'file_search'];
        $files_ok = true;
    }
    $functions_json = json_decode($functions_str, true);
    if($functions_json === null)
    {
        $functions = array();
    }
    else
    {
        if(is_array($functions_json) && !isset($functions_json['name']))
        {
            $functions = $functions_json;
        }
        elseif(isset($functions_json['name']))
        {
            $functions = array($functions_json);
        }
        else
        {
            $functions = array();
        }
    }
    foreach($functions as $func)
    {
        $tools[] = ['type' => 'function', 'function' => $func];
    }
    if($files_ok === false)
    {
        $assistant_files = [];
    }
    try
    {
        $address_post_id = '';
        $metadata = '';
        $assistantData = aiomatic_openai_modify_assistant(
            $token,
            $assistant_id,
            $model,
            $title,
            $description,
            $prompt,
            $temperature,
            $topp,
            $tools,
            $assistant_files,
            $metadata,
            $vector_store_id,
            $address_post_id
        );
        if($assistantData === false)
        {
            $aiomatic_result['msg'] = 'Failed to update assistant using the API';
            return $aiomatic_result;
        }
        if(!isset($assistantData['id']))
        {
            $aiomatic_result['msg'] = 'Failed to decode assistant updating request: ' . print_r($assistantData, true);
            return $aiomatic_result;
        }
        $assistant_id = $assistantData['id'];
    }
    catch(Exception $e)
    {
        $aiomatic_result['msg'] = 'Exception occured during Assistant updating: ' . $e->getMessage();
        return $aiomatic_result;
    }
    if(empty($assistant_id))
    {
        $aiomatic_result['msg'] = 'Failed to update assistant to AI service: ' . $title;
        return $aiomatic_result;
    }
    $assistant_data = array(
        'post_type' => 'aiomatic_assistants',
        'post_title' => $title,
        'post_content' => $prompt,
        'post_excerpt' => $description,
        'post_status' => 'publish',
        'ID' => $assistant_id_local
    );
    remove_filter('content_save_pre', 'wp_filter_post_kses');
    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
    $local_assistant_id = wp_update_post($assistant_data);
    add_filter('content_save_pre', 'wp_filter_post_kses');
    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
    if(is_wp_error($local_assistant_id))
    {
        $aiomatic_result['msg'] = $local_assistant_id->get_error_message();
    }
    elseif($local_assistant_id === 0)
    {
        $aiomatic_result['msg'] = 'Failed to update assistant to database: ' . $title;
    }
    else 
    {
        $vector_store_id = get_post_meta($local_assistant_id, '_assistant_vector_store_id', true);
        if(!empty($vector_store_id))
        {
            $solved = false;
            $ls_fid = [];
            try
            {
                $list_stores = aiomatic_openai_list_vector_store_files($token, $vector_store_id);
            }
            catch(Exception $e)
            {
                if(strstr($e->getMessage(), 'No vector store found with id') !== false)
                {
                    $vs = aiomatic_openai_create_vector_store($token, 'Assistant Vector Store', $assistant_files);
                    if(isset($vs['id']))
                    {
                        update_post_meta($local_assistant_id, '_assistant_vector_store_id', $vs['id']);
                        $solved = true;
                        $vector_store_id = $vs['id'];
                        $assistantData = aiomatic_openai_modify_assistant(
                            $token,
                            $assistant_id,
                            $model,
                            $title,
                            $description,
                            $prompt,
                            $temperature,
                            $topp,
                            $tools,
                            $assistant_files,
                            $metadata,
                            $vector_store_id,
                            $address_post_id
                        );
                        if($assistantData === false)
                        {
                            $aiomatic_result['msg'] = 'Failed to update assistant vector store using the API';
                            return $aiomatic_result;
                        }
                        if(!isset($assistantData['id']))
                        {
                            $aiomatic_result['msg'] = 'Failed to decode assistant vector store updating request: ' . print_r($assistantData, true);
                            return $aiomatic_result;
                        }
                    }
                }
                else
                {
                    throw $e;
                }
            }
            if(!$solved)
            {
                foreach($list_stores as $ls)
                {
                    $ls_fid[] = $ls['id'];
                }
                foreach($assistant_files as $fid)
                {
                    if(!in_array($fid, $ls_fid))
                    {
                        aiomatic_openai_create_vector_store_file($token, $vector_store_id, $fid);
                    }
                }
                foreach($ls_fid as $fid)
                {
                    if(!in_array($fid, $assistant_files))
                    {
                        aiomatic_openai_delete_vector_store_file($token, $vector_store_id, $fid);
                    }
                }
                $assistantData = aiomatic_openai_modify_assistant(
                    $token,
                    $assistant_id,
                    $model,
                    $title,
                    $description,
                    $prompt,
                    $temperature,
                    $topp,
                    $tools,
                    $assistant_files,
                    $metadata,
                    $vector_store_id,
                    $address_post_id
                );
                if($assistantData === false)
                {
                    $aiomatic_result['msg'] = 'Failed to update assistant vector store db using the API';
                    return $aiomatic_result;
                }
                if(!isset($assistantData['id']))
                {
                    $aiomatic_result['msg'] = 'Failed to decode assistant vector store db updating request: ' . print_r($assistantData, true);
                    return $aiomatic_result;
                }
            }
        }
        else
        {
            $vs = aiomatic_openai_create_vector_store($token, 'New Assistant Vector Store', $assistant_files);
            if(isset($vs['id']))
            {
                update_post_meta($local_assistant_id, '_assistant_vector_store_id', $vs['id']);
                $vector_store_id = $vs['id'];
                $assistantData = aiomatic_openai_modify_assistant(
                    $token,
                    $assistant_id,
                    $model,
                    $title,
                    $description,
                    $prompt,
                    $temperature,
                    $topp,
                    $tools,
                    $assistant_files,
                    $metadata,
                    $vector_store_id,
                    $address_post_id
                );
                if($assistantData === false)
                {
                    $aiomatic_result['msg'] = 'Failed to update assistant vector store using the API';
                    return $aiomatic_result;
                }
                if(!isset($assistantData['id']))
                {
                    $aiomatic_result['msg'] = 'Failed to decode assistant vector store updating request: ' . print_r($assistantData, true);
                    return $aiomatic_result;
                }
            }
        }

        update_post_meta($local_assistant_id, '_assistant_id', $assistant_id);
        if(!empty($assistant_first_message))
        {
            update_post_meta($local_assistant_id, '_assistant_first_message', $assistant_first_message);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_first_message', '');
        }
        if(!empty($model))
        {
            update_post_meta($local_assistant_id, '_assistant_model', $model);
        }
        if(!empty($temperature))
        {
            update_post_meta($local_assistant_id, '_assistant_temperature', $temperature);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_temperature', '');
        }
        if(!empty($topp))
        {
            update_post_meta($local_assistant_id, '_assistant_topp', $topp);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_topp', '');
        }
        if(!empty($tools))
        {
            update_post_meta($local_assistant_id, '_assistant_tools', $tools);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_tools', array());
        }
        if(!empty($assistant_files))
        {
            update_post_meta($local_assistant_id, '_assistant_files', $assistant_files);
        }
        else
        {
            update_post_meta($local_assistant_id, '_assistant_files', array());
        }
        if(!empty($avatar))
        {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $res2 = set_post_thumbnail($local_assistant_id, $avatar);
            if ($res2 === FALSE) 
            {
                $aiomatic_result['msg'] = 'Failed to insert assistant avatar to database: ' . $avatar;
            }
        }
        else
        {
            if($avatar === '0' || $avatar === 0)
            {
                delete_post_thumbnail($local_assistant_id);
            }
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $local_assistant_id;
    }
    return $aiomatic_result;
}
function aiomatic_save_assistant_only_local($token, $title, $model, $prompt, $description, $temperature, $topp, $assistant_first_message, $avatar, $assistant_files, $assistant_id, $created_at, $tools, $vector_store_id)
{
    if(empty($title))
    {
        $title = 'Untitled Assistant';
    }
    $args = array(
        'post_type'  => 'aiomatic_assistants',
        'meta_query' => array(
            array(
                'key'     => '_assistant_id',
                'value'   => $assistant_id,
                'compare' => 'EXISTS'
            ),
        ),
    );
    $updated = false;
    $query = new WP_Query( $args );
    require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) 
        {
            $query->the_post();
            $post_id = get_the_ID();
            $ass_id = get_post_meta($post_id, '_assistant_id', true);
            if(!empty($ass_id))
            {
                $failed = false;
                try
                {
                    $assistant = aiomatic_openai_retrieve_assistant($token, $ass_id);
                    if(!isset($assistant['id']))
                    {
                        throw new Exception('Incorrect response from assistant grabbing: ' . print_r($assistant, true));
                    }
                }
                catch(Exception $e)
                {
                    aiomatic_log_to_file('Exception in assistant grabbing: ' . $e->getMessage());
                    $failed = true;
                }
                if($failed == false)
                {
                    if(empty($assistant['description']))
                    {
                        $assistant['description'] = '';
                    }
                    if(empty($assistant['instructions']))
                    {
                        $assistant['instructions'] = '';
                    }
                    $assistant_data = array(
                        'post_type' => 'aiomatic_assistants',
                        'post_title' => $assistant['name'],
                        'post_content' => $assistant['instructions'],
                        'post_excerpt' => $assistant['description'],
                        'post_status' => 'publish',
                        'ID' => $post_id
                    );
                    remove_filter('content_save_pre', 'wp_filter_post_kses');
                    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                    $local_assistant_id = wp_update_post($assistant_data);
                    add_filter('content_save_pre', 'wp_filter_post_kses');
                    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                    if(is_wp_error($local_assistant_id))
                    {
                        aiomatic_log_to_file('Failed to update assistant ' . $local_assistant_id->get_error_message());
                    }
                    elseif($local_assistant_id === 0)
                    {
                        aiomatic_log_to_file('Failed to update assistant to database: ' . $assistant['name']);
                    }
                    else 
                    {
                        $updated = true;
                        $file_ids = array();
                        if(isset($assistant['tool_resources']['code_interpreter']['file_ids'][0]))
                        {
                            $file_ids = $assistant['tool_resources']['code_interpreter']['file_ids'];
                        }
                        update_post_meta($local_assistant_id, '_assistant_model', $assistant['model']);
                        update_post_meta($local_assistant_id, '_assistant_tools', (array) $assistant['tools']);
                        update_post_meta($local_assistant_id, '_assistant_files', $file_ids);
                        if(!empty($vector_store_id))
                        {
                            update_post_meta($local_assistant_id, '_assistant_vector_store_id', $vector_store_id);
                        }
                        if(!empty($temperature))
                        {
                            update_post_meta($local_assistant_id, '_assistant_temperature', $temperature);
                        }
                        if(!empty($topp))
                        {
                            update_post_meta($local_assistant_id, '_assistant_topp', $topp);
                        }
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['id'] = $local_assistant_id;
                    }
                }
            }
        }
    }
    if(!$updated)
    {
        if(empty($title))
        {
            $aiomatic_result['msg'] = 'You need to add a name for the assistant!';
            return $aiomatic_result;
        }
        if(empty($model))
        {
            $aiomatic_result['msg'] = 'You need to add a model for the assistant!';
            return $aiomatic_result;
        }
        if(empty($prompt))
        {
            $prompt = '';
        }
        if(empty($description))
        {
            $description = '';
        }
        $postdate = date("Y-m-d H:i:s", $created_at);
        $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong assistant saving');
        $assistant_data = array(
            'post_type' => 'aiomatic_assistants',
            'post_title' => $title,
            'post_content' => $prompt,
            'post_excerpt' => $description,
            'post_date' => $postdate,
            'post_status' => 'publish'
        );
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $local_assistant_id = wp_insert_post($assistant_data);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($local_assistant_id))
        {
            $aiomatic_result['msg'] = $local_assistant_id->get_error_message();
        }
        elseif($local_assistant_id === 0)
        {
            $aiomatic_result['msg'] = 'Failed to insert assistant to database: ' . $title;
        }
        else 
        {
            update_post_meta($local_assistant_id, '_assistant_id', $assistant_id);
            if(!empty($assistant_first_message))
            {
                update_post_meta($local_assistant_id, '_assistant_first_message', $assistant_first_message);
            }
            else
            {
                update_post_meta($local_assistant_id, '_assistant_first_message', '');
            }
            if(!empty($model))
            {
                update_post_meta($local_assistant_id, '_assistant_model', $model);
            }
            if(!empty($tools))
            {
                update_post_meta($local_assistant_id, '_assistant_tools', (array)$tools);
            }
            else
            {
                update_post_meta($local_assistant_id, '_assistant_tools', array());
            }
            if(!empty($vector_store_id))
            {
                update_post_meta($local_assistant_id, '_assistant_vector_store_id', $vector_store_id);
            }
            if(!empty($temperature))
            {
                update_post_meta($local_assistant_id, '_assistant_temperature', $temperature);
            }
            if(!empty($topp))
            {
                update_post_meta($local_assistant_id, '_assistant_topp', $topp);
            }
            if(!empty($assistant_files))
            {
                update_post_meta($local_assistant_id, '_assistant_files', $assistant_files);
            }
            else
            {
                update_post_meta($local_assistant_id, '_assistant_files', array());
            }
            if(!empty($avatar))
            {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $res2 = set_post_thumbnail($local_assistant_id, $avatar);
                if ($res2 === FALSE) 
                {
                    $aiomatic_result['msg'] = 'Failed to insert assistant avatar to database: ' . $avatar;
                }
            }
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['id'] = $local_assistant_id;
        }
    }
    return $aiomatic_result;
}
?>