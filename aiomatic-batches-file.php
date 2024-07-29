<?php
defined('ABSPATH') or die();
function aiomatic_save_batch_only_local($token, $my_batch)
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong batch request saving');
    $args = array(
        'post_type'  => 'aiomatic_batches',
        'meta_query' => array(
            array(
                'key'     => '_batch_id',
                'value'   => $my_batch['id'],
                'compare' => 'EXISTS'
            ),
        ),
    );
    $updated = false;
    $query = new WP_Query( $args );
    require_once (dirname(__FILE__) . "/res/aiomatic-batch-api.php"); 
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) 
        {
            $query->the_post();
            $post_id = get_the_ID();
            $batch_id = get_post_meta($post_id, '_batch_id', true);
            if(!empty($batch_id))
            {
                $batch_status = get_post_meta($post_id, '_batch_status', true);
                if($batch_status == $my_batch['status'] && ($batch_status == 'failed' || $batch_status == 'cancelled' || $batch_status == 'completed' || $batch_status == 'expired'))
                {
                    $updated = true;
                    $aiomatic_result['status'] = 'success';
                    $aiomatic_result['id'] = $post_id;
                    continue;
                }
                $failed = false;
                try
                {
                    $batch = aiomatic_openai_retrieve_batch($token, $batch_id);
                    if(!isset($batch['id']))
                    {
                        throw new Exception('Incorrect response from batch grabbing: ' . print_r($batch, true));
                    }
                }
                catch(Exception $e)
                {
                    aiomatic_log_to_file('Exception in batch grabbing: ' . $e->getMessage());
                    $failed = true;
                }
                if($failed == false)
                {
                    $batch_data = array(
                        'post_type' => 'aiomatic_batches',
                        'post_title' => $batch['id'],
                        'post_status' => 'publish',
                        'ID' => $post_id
                    );
                    remove_filter('content_save_pre', 'wp_filter_post_kses');
                    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                    $local_batch_id = wp_update_post($batch_data);
                    add_filter('content_save_pre', 'wp_filter_post_kses');
                    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                    if(is_wp_error($local_batch_id))
                    {
                        aiomatic_log_to_file('Failed to update batch request ' . $local_batch_id->get_error_message());
                    }
                    elseif($local_batch_id === 0)
                    {
                        aiomatic_log_to_file('Failed to update batch request to database: ' . $batch['id']);
                    }
                    else 
                    {
                        $updated = true;
                        update_post_meta($local_batch_id, '_batch_id', $batch['id']);
                        update_post_meta($local_batch_id, '_batch_endpoint', $batch['endpoint']);
                        update_post_meta($local_batch_id, '_batch_completion_window', $batch['completion_window']);
                        update_post_meta($local_batch_id, '_batch_errors', $batch['errors']);
                        update_post_meta($local_batch_id, '_batch_input_file_id', $batch['input_file_id']);
                        update_post_meta($local_batch_id, '_batch_status', $batch['status']);
                        update_post_meta($local_batch_id, '_batch_output_file_id', $batch['output_file_id']);
                        update_post_meta($local_batch_id, '_batch_created_at', $batch['created_at']);
                        update_post_meta($local_batch_id, '_batch_in_progress_at', $batch['in_progress_at']);
                        update_post_meta($local_batch_id, '_batch_expires_at', $batch['expires_at']);
                        update_post_meta($local_batch_id, '_batch_finalizing_at', $batch['finalizing_at']);
                        update_post_meta($local_batch_id, '_batch_completed_at', $batch['completed_at']);
                        update_post_meta($local_batch_id, '_batch_failed_at', $batch['failed_at']);
                        update_post_meta($local_batch_id, '_batch_expired_at', $batch['expired_at']);
                        update_post_meta($local_batch_id, '_batch_cancelling_at', $batch['cancelling_at']);
                        update_post_meta($local_batch_id, '_batch_cancelled_at', $batch['cancelled_at']);
                        update_post_meta($local_batch_id, '_batch_request_count', $batch['request_counts']['total']);
                        update_post_meta($local_batch_id, '_batch_request_completed', $batch['request_counts']['completed']);
                        update_post_meta($local_batch_id, '_batch_request_failed', $batch['request_counts']['failed']);
                        update_post_meta($local_batch_id, '_batch_error_file_id', $batch['error_file_id']);
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['id'] = $local_batch_id;
                    }
                }
            }
        }
    }
    if(!$updated)
    {
        $postdate = date("Y-m-d H:i:s", $my_batch['created_at']);
        $batch_data = array(
            'post_type' => 'aiomatic_batches',
            'post_title' => $my_batch['id'],
            'post_date' => $postdate,
            'post_status' => 'publish'
        );
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $local_batch_id = wp_insert_post($batch_data);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($local_batch_id))
        {
            $aiomatic_result['msg'] = $local_batch_id->get_error_message();
        }
        elseif($local_batch_id === 0)
        {
            $aiomatic_result['msg'] = 'Failed to insert batch request to database: ' . $title;
        }
        else 
        {
            update_post_meta($local_batch_id, '_batch_id', $my_batch['id']);
            update_post_meta($local_batch_id, '_batch_endpoint', $my_batch['endpoint']);
            update_post_meta($local_batch_id, '_batch_completion_window', $my_batch['completion_window']);
            update_post_meta($local_batch_id, '_batch_errors', $my_batch['errors']);
            update_post_meta($local_batch_id, '_batch_input_file_id', $my_batch['input_file_id']);
            update_post_meta($local_batch_id, '_batch_status', $my_batch['status']);
            update_post_meta($local_batch_id, '_batch_output_file_id', $my_batch['output_file_id']);
            update_post_meta($local_batch_id, '_batch_created_at', $my_batch['created_at']);
            update_post_meta($local_batch_id, '_batch_in_progress_at', $my_batch['in_progress_at']);
            update_post_meta($local_batch_id, '_batch_expires_at', $my_batch['expires_at']);
            update_post_meta($local_batch_id, '_batch_finalizing_at', $my_batch['finalizing_at']);
            update_post_meta($local_batch_id, '_batch_completed_at', $my_batch['completed_at']);
            update_post_meta($local_batch_id, '_batch_failed_at', $my_batch['failed_at']);
            update_post_meta($local_batch_id, '_batch_expired_at', $my_batch['expired_at']);
            update_post_meta($local_batch_id, '_batch_cancelling_at', $my_batch['cancelling_at']);
            update_post_meta($local_batch_id, '_batch_cancelled_at', $my_batch['cancelled_at']);
            update_post_meta($local_batch_id, '_batch_request_count', $my_batch['request_counts']['total']);
            update_post_meta($local_batch_id, '_batch_request_completed', $my_batch['request_counts']['completed']);
            update_post_meta($local_batch_id, '_batch_request_failed', $my_batch['request_counts']['failed']);
            update_post_meta($local_batch_id, '_batch_error_file_id', $my_batch['error_file_id']);
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['id'] = $local_batch_id;
        }
    }
    return $aiomatic_result;
}
function aiomatic_save_batch($token, $aiomatic_batch_file, $aiomatic_completion_window, $aiomatic_endpoint)
{
    require_once (dirname(__FILE__) . "/res/aiomatic-batch-api.php"); 
    try
    {
        $metadata = '';
        $batchData = aiomatic_openai_save_batch(
            $token,
            $aiomatic_batch_file,
            $aiomatic_completion_window,
            $aiomatic_endpoint,
            $metadata
        );
        if($batchData === false)
        {
            $aiomatic_result['msg'] = 'Failed to save AI Batch Request using the API';
            return $aiomatic_result;
        }
        if(!isset($batchData['id']))
        {
            $aiomatic_result['msg'] = 'Failed to decode AI Batch Request saving request: ' . print_r($batchData, true);
            return $aiomatic_result;
        }
        $batch_id = $batchData['id'];
    }
    catch(Exception $e)
    {
        $aiomatic_result['msg'] = 'Exception occured during AI Batch Request saving: ' . $e->getMessage();
        return $aiomatic_result;
    }
    if(empty($batch_id))
    {
        $aiomatic_result['msg'] = 'Failed to insert AI Batch Request to AI service: ' . $title;
        return $aiomatic_result;
    }

    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong in batch request saving');
    $batch_data = array(
        'post_type' => 'aiomatic_batches',
        'post_title' => $batch_id,
        'post_status' => 'publish'
    );
    remove_filter('content_save_pre', 'wp_filter_post_kses');
    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
    $local_batch_id = wp_insert_post($batch_data);
    add_filter('content_save_pre', 'wp_filter_post_kses');
    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
    if(is_wp_error($local_batch_id))
    {
        $aiomatic_result['msg'] = $local_batch_id->get_error_message();
    }
    elseif($local_batch_id === 0)
    {
        $aiomatic_result['msg'] = 'Failed to insert batch request to database: ' . $title;
    }
    else 
    {
        update_post_meta($local_batch_id, '_batch_id', $batchData['id']);
        update_post_meta($local_batch_id, '_batch_endpoint', $batchData['endpoint']);
        update_post_meta($local_batch_id, '_batch_completion_window', $batchData['completion_window']);
        update_post_meta($local_batch_id, '_batch_errors', $batchData['errors']);
        update_post_meta($local_batch_id, '_batch_input_file_id', $batchData['input_file_id']);
        update_post_meta($local_batch_id, '_batch_status', $batchData['status']);
        update_post_meta($local_batch_id, '_batch_output_file_id', $batchData['output_file_id']);
        update_post_meta($local_batch_id, '_batch_created_at', $batchData['created_at']);
        update_post_meta($local_batch_id, '_batch_in_progress_at', $batchData['in_progress_at']);
        update_post_meta($local_batch_id, '_batch_expires_at', $batchData['expires_at']);
        update_post_meta($local_batch_id, '_batch_finalizing_at', $batchData['finalizing_at']);
        update_post_meta($local_batch_id, '_batch_completed_at', $batchData['completed_at']);
        update_post_meta($local_batch_id, '_batch_failed_at', $batchData['failed_at']);
        update_post_meta($local_batch_id, '_batch_expired_at', $batchData['expired_at']);
        update_post_meta($local_batch_id, '_batch_cancelling_at', $batchData['cancelling_at']);
        update_post_meta($local_batch_id, '_batch_cancelled_at', $batchData['cancelled_at']);
        update_post_meta($local_batch_id, '_batch_request_count', $batchData['request_counts']['total']);
        update_post_meta($local_batch_id, '_batch_request_completed', $batchData['request_counts']['completed']);
        update_post_meta($local_batch_id, '_batch_request_failed', $batchData['request_counts']['failed']);
        update_post_meta($local_batch_id, '_batch_error_file_id', $batchData['error_file_id']);
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $local_batch_id;
    }
    return $aiomatic_result;
}
?>