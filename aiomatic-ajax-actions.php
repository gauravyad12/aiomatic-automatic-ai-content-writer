<?php
defined('ABSPATH') or die();
use \Eventviva\ImageResize;
use AiomaticOpenAI\OpenAi\OpenAi;
use Aws\S3\S3Client;

add_action( 'wp_ajax_aiomatic_write_tax_description', 'aiomatic_write_tax_description' );
function aiomatic_write_tax_description() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['tag_ID']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (tag_ID)' . print_r($_POST, true) ) );
        exit;
	}
    $tag_ID = $_POST['tag_ID'];
    if(!isset($_POST['taxonomy']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (taxonomy)' . print_r($_POST, true) ) );
        exit;
	}
    $taxonomy = $_POST['taxonomy'];
    $my_term = get_term_by('id', $tag_ID, $taxonomy);
    if($my_term == false)
	{
		wp_send_json_error( array( 'message' => 'Taxonomy ID not found: ' . print_r($tag_ID, true) ) );
        exit;
	}
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
    
    if (isset($aiomatic_Main_Settings['tax_description_prompt']) && trim($aiomatic_Main_Settings['tax_description_prompt']) != '') 
    {
        $prompt = trim($aiomatic_Main_Settings['tax_description_prompt']);
    }
    else
    {
        $prompt = 'Write a description for a WordPress %%term_taxonomy_name%% with the following title: "%%term_name%%"';
    }
    if (isset($aiomatic_Main_Settings['tax_description_model']) && trim($aiomatic_Main_Settings['tax_description_model']) != '') 
    {
        $model = trim($aiomatic_Main_Settings['tax_description_model']);
    }
    else
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
    if (isset($aiomatic_Main_Settings['tax_assistant_id']) && trim($aiomatic_Main_Settings['tax_assistant_id']) != '') 
    {
        $tax_assistant_id = trim($aiomatic_Main_Settings['tax_assistant_id']);
    }
    else
    {
        $tax_assistant_id = '';
    }
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
	$new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    $prompt = str_replace('%%term_id%%', $my_term->term_id, $prompt);
    $prompt = str_replace('%%term_name%%', $my_term->name, $prompt);
    $prompt = str_replace('%%term_slug%%', $my_term->slug, $prompt);
    $prompt = str_replace('%%term_description%%', $my_term->description, $prompt);
    $prompt = str_replace('%%term_taxonomy_name%%', $my_term->taxonomy, $prompt);
    $prompt = str_replace('%%term_taxonomy_id%%', $my_term->term_taxonomy_id, $prompt);
	$query_token_count = count(aiomatic_encode($prompt));
    $max_tokens = aiomatic_get_max_tokens($model);
	$available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
	if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
	{
		$string_len = strlen($prompt);
		$string_len = $string_len / 2;
		$string_len = intval(0 - $string_len);
        $aicontent = aiomatic_substr($prompt, 0, $string_len);
		$aicontent = trim($aicontent);
		if(empty($aicontent))
		{
			wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
            exit;
		}
		$query_token_count = count(aiomatic_encode($aicontent));
		$available_tokens = $max_tokens - $query_token_count;
	}
    $thread_id = '';
	$aierror = '';
	$finish_reason = '';
	$generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, 1, 1, 0, 0, false, 'taxonomyDescriptionWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $tax_assistant_id, $thread_id, '', 'disabled', '', false);
	if($generated_text === false)
	{
		wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
        exit;
	}
	else
	{
		$new_post_content = aiomatic_sanitize_ai_result($generated_text);
	}
    do_action('aiomatic_tax_description_reply', $new_post_content);
    wp_send_json_success( array('content' => $new_post_content) );
    die();
}

add_action('wp_ajax_aiomatic_activation', 'aiomatic_activation');
function aiomatic_activation()
{
    $code                 = $_POST['code'];
    $nonce                   = $_POST['nonce'];
    if(!wp_verify_nonce( $nonce, 'activation-secret-nonce'))
    {
        echo 'You are not allowed to do this action!';
        die();
    }
    $plugin = plugin_basename(__FILE__);
    $plugin_slug = explode('/', $plugin);
    $plugin_slug = $plugin_slug[0];
    if(strlen(trim($code)) != 36 || strstr($code, '-') == false)
    {
        aiomatic_log_to_file('Invalid registration code submitted: ' . $code);
        echo 'Invalid registration code submitted!';
        die();
    }
    else
    {
        $ch = curl_init('https://wpinitiate.com/verify-purchase/purchase.php');
        if($ch !== false)
        {
            $data           = array();
            $data['code']   = trim($code);
            $data['siteURL']   = get_bloginfo('url');
            $data['siteName']   = get_bloginfo('name');
            $data['siteEmail']   = get_bloginfo('admin_email');
            $fdata = "";
            foreach ($data as $key => $val) {
                $fdata .= "$key=" . urlencode(trim($val)) . "&";
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $result = curl_exec($ch);
            if($result === false)
            {
                curl_close($ch);
                aiomatic_log_to_file('Failed to get verification response: ' . curl_error($ch));
                echo 'Failed to get verification response: ' . curl_error($ch);
                die();
            }
            else
            {
                $rj = json_decode($result, true);
                if(isset($rj['error']))
                {
                    echo $rj['error'];
                    die();
                }
                elseif(isset($rj['item_name']))
                {
                    $rj['code'] = $code;
                    if($rj['item_id'] == '38877369' || $rj['item_id'] == '13371337' || $rj['item_id'] == '19200046')
                    {
                        update_option($plugin_slug . '_registration', $rj);
                    }
                    else
                    {
                        aiomatic_log_to_file('Invalid response from purchase code verification (are you sure you inputted the right purchase code?): ' . print_r($rj, true));
                        echo 'Invalid response from purchase code verification (are you sure you inputted the right purchase code?): ' . print_r($rj, true);
                        die();
                    }
                }
                else
                {
                    aiomatic_log_to_file('Invalid json from purchase code verification: ' . print_r($result, true));
                    echo 'Invalid json from purchase code verification: ' . print_r($result, true);
                    die();
                }
            }
            curl_close($ch);
        }
        else
        {
            aiomatic_log_to_file('Failed to init curl when trying to make purchase verification.');
            echo 'Failed to init curl!';
            die();
        }
    }
    echo 'ok';
    die();
}
add_action('wp_ajax_aiomatic_revoke', 'aiomatic_revoke');
function aiomatic_revoke()
{
    $nonce                   = $_POST['nonce'];
    if(!wp_verify_nonce($nonce, 'activation-secret-nonce'))
    {
        echo 'You are not allowed to do this action!';
        die();
    }
    $plugin = plugin_basename(__FILE__);
    $plugin_slug = explode('/', $plugin);
    $plugin_slug = $plugin_slug[0];
    $ch = curl_init('https://wpinitiate.com/verify-purchase/revoke.php');
    if($ch !== false)
    {
        $data           = array();
        $data['siteURL']   = get_bloginfo('url');
        $fdata = "";
        foreach ($data as $key => $val) {
            $fdata .= "$key=" . urlencode(trim($val)) . "&";
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        if($result === false)
        {
            update_option($plugin_slug . '_registration', false);
        }
        else
        {
            update_option($plugin_slug . '_registration', false);
        }
    }
    else
    {
        aiomatic_log_to_file('Failed to init curl to revoke verification response.');
        echo 'Failed to init curl!';
        die();
    }
    echo 'ok';
    die();
}
add_action( 'wp_ajax_aiomatic_write_tax_description_manual', 'aiomatic_write_tax_description_manual' );
function aiomatic_write_tax_description_manual() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['tax_description_manual']) && trim($aiomatic_Main_Settings['tax_description_manual']) != '') 
    {
        $taxonomy = trim($aiomatic_Main_Settings['tax_description_manual']);
    }
    else
    {
        $taxonomy = 'category';
    }
    if (isset($aiomatic_Main_Settings['max_tax_nr']) && trim($aiomatic_Main_Settings['max_tax_nr']) != '') 
    {
        $max_tax_nr = intval(trim($aiomatic_Main_Settings['max_tax_nr']));
    }
    else
    {
        $max_tax_nr = 5;
    }
    if (isset($aiomatic_Main_Settings['overwite_tax']) && trim($aiomatic_Main_Settings['overwite_tax']) == 'on')
    {
        $overwite_tax = true;
    }
    else
    {
        $overwite_tax = false;
    }
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
    
    if (isset($aiomatic_Main_Settings['tax_description_prompt']) && trim($aiomatic_Main_Settings['tax_description_prompt']) != '') 
    {
        $prompt = trim($aiomatic_Main_Settings['tax_description_prompt']);
    }
    else
    {
        $prompt = 'Write a description for a WordPress %%term_taxonomy_name%% with the following title: "%%term_name%%"';
    }
    if (isset($aiomatic_Main_Settings['tax_description_model']) && trim($aiomatic_Main_Settings['tax_description_model']) != '') 
    {
        $model = trim($aiomatic_Main_Settings['tax_description_model']);
    }
    else
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
    if (isset($aiomatic_Main_Settings['tax_assistant_id']) && trim($aiomatic_Main_Settings['tax_assistant_id']) != '') 
    {
        $tax_assistant_id = trim($aiomatic_Main_Settings['tax_assistant_id']);
    }
    else
    {
        $tax_assistant_id = '';
    }
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
	$new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    $args = array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'number'     => 0,
    );
    $filtered_terms = [];
    $terms = get_terms($args);
    if (!empty($terms) && !is_wp_error($terms)) 
    {
        foreach ($terms as $term) 
        {
            if($overwite_tax === true)
            {
                $filtered_terms[] = $term; 
                if (count($filtered_terms) >= $max_tax_nr) break;
            }
            else
            {
                if (empty($term->description)) 
                {
                    $filtered_terms[] = $term; 
                    if (count($filtered_terms) >= $max_tax_nr) break;
                }
            }
        }
    } 
    else 
    {
        if(is_wp_error($terms))
        {
            wp_send_json_error( array( 'message' => 'An error occurred: ' . $terms->get_error_message()) );
            exit;
        }
        wp_send_json_error( array( 'message' => 'No ' . $taxonomy . ' terms found without a description.' ) );
        exit;
    }
    if(count($filtered_terms) == 0)
    {
        wp_send_json_error( array( 'message' => 'No ' . $taxonomy . ' tax terms found without a description.' ) );
        exit;
    }
    foreach ($filtered_terms as $my_term) 
    {
        $thisprompt = str_replace('%%term_id%%', $my_term->term_id, $prompt);
        $thisprompt = str_replace('%%term_name%%', $my_term->name, $thisprompt);
        $thisprompt = str_replace('%%term_slug%%', $my_term->slug, $thisprompt);
        $thisprompt = str_replace('%%term_description%%', $my_term->description, $thisprompt);
        $thisprompt = str_replace('%%term_taxonomy_name%%', $my_term->taxonomy, $thisprompt);
        $thisprompt = str_replace('%%term_taxonomy_id%%', $my_term->term_taxonomy_id, $thisprompt);
        $query_token_count = count(aiomatic_encode($thisprompt));
        $max_tokens = aiomatic_get_max_tokens($model);
        $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $thisprompt, $query_token_count);
        if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
        {
            $string_len = strlen($thisprompt);
            $string_len = $string_len / 2;
            $string_len = intval(0 - $string_len);
            $aicontent = aiomatic_substr($thisprompt, 0, $string_len);
            $aicontent = trim($aicontent);
            if(empty($aicontent))
            {
                wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
                exit;
            }
            $query_token_count = count(aiomatic_encode($aicontent));
            $available_tokens = $max_tokens - $query_token_count;
        }
        $thread_id = '';
        $aierror = '';
        $finish_reason = '';
        $generated_text = aiomatic_generate_text($token, $model, $thisprompt, $available_tokens, 1, 1, 0, 0, false, 'taxonomyDescriptionWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $tax_assistant_id, $thread_id, '', 'disabled', '', false);
        if($generated_text === false)
        {
            wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
            exit;
        }
        else
        {
            $new_post_content = aiomatic_sanitize_ai_result($generated_text);
        }
        do_action('aiomatic_tax_description_reply', $new_post_content);
        $args = array(
            'description' => $new_post_content,
        );
        $updated_term = wp_update_term($my_term->term_id, $taxonomy, $args);
        if (is_wp_error($updated_term)) {
            wp_send_json_error( array( 'message' => 'An error occurred when updating taxonomy description: ' . $updated_term->get_error_message() ) );
            exit;
        }
        if (isset($aiomatic_Main_Settings['tax_seo_auto']))
        {
            if($aiomatic_Main_Settings['tax_seo_auto'] == 'copy')
            {
                aiomatic_save_term_seo_description($my_term->term_id, $new_post_content, $taxonomy);
            }
            elseif($aiomatic_Main_Settings['tax_seo_auto'] == 'write')
            {
                $xdescription = aiomatic_auto_write_tax_SEO_description($my_term->term_id, $taxonomy);
                if(!empty($xdescription))
                {
                    aiomatic_save_term_seo_description($my_term->term_id, $xdescription, $taxonomy);
                }
            }
        }
    }
    wp_send_json_success( array('content' => 'ok') );
    die();
}

add_action( 'wp_ajax_aiomatic_refresh_ollama_models', 'aiomatic_refresh_ollama_models' );
function aiomatic_refresh_ollama_models() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['ollama_url']) || trim($aiomatic_Main_Settings['ollama_url']) == '') 
    {
        wp_send_json_error(array( 'message' => 'You need to enter an Ollama API URl for this to work!'));
        exit;
    }
    $llama_models = aiomatic_get_ollama_models(true);
    if($llama_models !== false)
    {
        wp_send_json_success( array('data' => $llama_models) );
        die();
    }
    else
    {
        wp_send_json_error(array( 'message' => 'Failed to get Ollama models list.'));
        die();
    }
}
function aiomatic_write_aicontent_info() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['step']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (step)' . print_r($_POST, true) ) );
        exit;
	}
    $step = $_POST['step'];
    if(!isset($_POST['title']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (title)' . print_r($_POST, true) ) );
        exit;
	}
    $title = $_POST['title'];
    if(!isset($_POST['model']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (model)' . print_r($_POST, true) ) );
        exit;
	}
    $model = $_POST['model'];
    if(!isset($_POST['assistant_id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (assistant_id)' . print_r($_POST, true) ) );
        exit;
	}
    $assistant_id = $_POST['assistant_id'];
    if(!isset($_POST['titlep']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (titlep)' . print_r($_POST, true) ) );
        exit;
	}
    $titlep = $_POST['titlep'];
    if(!isset($_POST['seop']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (seop)' . print_r($_POST, true) ) );
        exit;
	}
    $seop = $_POST['seop'];
    if(!isset($_POST['contentp']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (contentp)' . print_r($_POST, true) ) );
        exit;
	}
    $contentp = $_POST['contentp'];
    if(!isset($_POST['shortp']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (shortp)' . print_r($_POST, true) ) );
        exit;
	}
    $shortp = $_POST['shortp'];
    if(!isset($_POST['tagp']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (tagp)' . print_r($_POST, true) ) );
        exit;
	}
    $tagp = $_POST['tagp'];
    if(!isset($_POST['prod_title']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prod_title)' . print_r($_POST, true) ) );
        exit;
	}
    $prod_title = $_POST['prod_title'];
    if(!isset($_POST['prod_content']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prod_content)' . print_r($_POST, true) ) );
        exit;
	}
    $prod_content = $_POST['prod_content'];
    if(!isset($_POST['prod_excerpt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prod_excerpt)' . print_r($_POST, true) ) );
        exit;
	}
    $prod_excerpt = $_POST['prod_excerpt'];
    if(!isset($_POST['post_type']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (post_type)' . print_r($_POST, true) ) );
        exit;
	}
    $post_type = $_POST['post_type'];
    if(!isset($_POST['post_id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (post_id)' . print_r($_POST, true) ) );
        exit;
	}
    $post_id = $_POST['post_id'];
    if(!empty($step))
    {
        if($step == 'title')
        {
            $prompt = $titlep;
        }
        elseif($step == 'meta')
        {
            $prompt = $seop;
        }
        elseif($step == 'description')
        {
            $prompt = $contentp;
        }
        elseif($step == 'short')
        {
            $prompt = $shortp;
        }
        elseif($step == 'tags')
        {
            $prompt = $tagp;
        }
        else
        {
            wp_send_json_error( array( 'message' => 'Incorrect step sent' . print_r($step, true) ) );
            exit;
        }
    }
    else
    {
        wp_send_json_error( array( 'message' => 'Empty content sent' . print_r($_POST, true) ) );
        exit;
    }
    if(empty($prompt))
    {
        wp_send_json_error( array( 'message' => 'Empty prompt sent' . print_r($_POST, true) ) );
        exit;
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
    $new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    $prompt = str_replace('%%post_title_idea%%', $title, $prompt);
    $prompt = str_replace('%%post_title%%', $prod_title, $prompt);
    $prompt = str_replace('%%post_excerpt%%', $prod_excerpt, $prompt);
    $prompt = str_replace('%%post_content%%', $prod_content, $prompt);
    $prompt = str_replace('%%post_type%%', $post_type, $prompt);
    $prompt = str_replace('%%random_sentence%%', aiomatic_random_sentence_generator(), $prompt);
    $prompt = str_replace('%%random_sentence2%%', aiomatic_random_sentence_generator(false), $prompt);
    $prompt = aiomatic_replaceSynergyShortcodes($prompt);
    if (isset($aiomatic_Main_Settings['custom_html'])) {
        $prompt = str_replace('%%custom_html%%', $aiomatic_Main_Settings['custom_html'], $prompt);
    }
    if (isset($aiomatic_Main_Settings['custom_html2'])) {
        $prompt = str_replace('%%custom_html2%%', $aiomatic_Main_Settings['custom_html2'], $prompt);
    }
    if($post_id != '')
    {
        preg_match_all('#%%!([^!]*?)!%%#', $prompt, $matched_content);
        if(isset($matched_content[1][0]))
        {
            foreach($matched_content[1] as $mc)
            {
                $post_custom_data = get_post_meta($post_id, $mc, true);
                if($post_custom_data != '')
                {
                    $prompt = str_replace('%%!' . $mc . '!%%', $post_custom_data, $prompt);
                }
                else
                {
                    $prompt = str_replace('%%!' . $mc . '!%%', '', $prompt);
                }
            }
        }
        preg_match_all('#%%!!([^!]*?)!!%%#', $prompt, $matched_content);
        if(isset($matched_content[1][0]))
        {
            foreach($matched_content[1] as $mc)
            {
                $ctaxs = '';
                $terms = get_the_terms( $post_id, $mc );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
                {
                    $ctaxs_arr = array();
                    foreach ( $terms as $term ) {
                        $ctaxs_arr[] = $term->slug;
                    }
                    $ctaxs = implode(',', $ctaxs_arr);
                }
                if($post_custom_data != '')
                {
                    $prompt = str_replace('%%!!' . $mc . '!!%%', $ctaxs, $prompt);
                }
                else
                {
                    $prompt = str_replace('%%!!' . $mc . '!!%%', '', $prompt);
                }
            }
        }
    }
    else
    {
        preg_match_all('#%%!([^!]*?)!%%#', $prompt, $matched_content);
        if(isset($matched_content[1][0]))
        {
            foreach($matched_content[1] as $mc)
            {
                $prompt = str_replace('%%!' . $mc . '!%%', '', $prompt);
            }
        }
        preg_match_all('#%%!!([^!]*?)!!%%#', $prompt, $matched_content);
        if(isset($matched_content[1][0]))
        {
            foreach($matched_content[1] as $mc)
            {
                $prompt = str_replace('%%!!' . $mc . '!!%%', '', $prompt);
            }
        }
    }
    if ( is_user_logged_in() ) 
    {
        $user_id = get_current_user_id();
        if($user_id !== 0)
        {
            preg_match_all('#%%~([^!]*?)~%%#', $prompt, $matched_content);
            if(isset($matched_content[1][0]))
            {
                foreach($matched_content[1] as $mc)
                {
                    $post_custom_data = get_user_meta($user_id, $mc, true);
                    if($post_custom_data != '')
                    {
                        $prompt = str_replace('%%~' . $mc . '~%%', $post_custom_data, $prompt);
                    }
                    else
                    {
                        $prompt = str_replace('%%~' . $mc . '~%%', '', $prompt);
                    }
                }
            }
        }
        else
        {
            preg_match_all('#%%~([^!]*?)~%%#', $prompt, $matched_content);
            if(isset($matched_content[1][0]))
            {
                foreach($matched_content[1] as $mc)
                {
                    $prompt = str_replace('%%~' . $mc . '~%%', '', $prompt);
                }
            }
        }
    } 
    else 
    {
        preg_match_all('#%%~([^!]*?)~%%#', $prompt, $matched_content);
        if(isset($matched_content[1][0]))
        {
            foreach($matched_content[1] as $mc)
            {
                $prompt = str_replace('%%~' . $mc . '~%%', '', $prompt);
            }
        }
    }
    $prompt = preg_replace_callback('#%%random_image_url\[([^\]]*?)\]%%#', function ($matches) {
        $arv = array();
        $my_img = aiomatic_get_random_image_google($matches[1], 0, 0, '', $arv);
        return $my_img;
    }, $prompt);
    $prompt = preg_replace_callback('#%%random_image\[([^\]]*?)\](\[\d+\])?%%#', function ($matches) {
        if(isset($matches[2]))
        {
            $chance = trim($matches[2], '[]');
        }
        else
        {
            $chance = '';
        }
        $arv = array();
        $my_img = aiomatic_get_random_image_google($matches[1], 0, 0, $chance, $arv);
        return '<img src="' . $my_img . '">';
    }, $prompt);
    $prompt = preg_replace_callback('#%%random_video\[([^\]]*?)\](\[\d+\])?%%#', function ($matches) {
        if(isset($matches[2]))
        {
            $chance = trim($matches[2], '[]');
        }
        else
        {
            $chance = '';
        }
        $my_vid = aiomoatic_get_video($matches[1], $chance);
        return $my_vid;
    }, $prompt);
    $prompt = apply_filters('aiomatic_replace_aicontent_shortcode', $prompt);
	$query_token_count = count(aiomatic_encode($prompt));
    $max_tokens = aiomatic_get_max_tokens($model);
	$available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
	if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
	{
		$string_len = strlen($prompt);
		$string_len = $string_len / 2;
		$string_len = intval(0 - $string_len);
        $aicontent = aiomatic_substr($prompt, 0, $string_len);
		$aicontent = trim($aicontent);
		if(empty($aicontent))
		{
			wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
            exit;
		}
		$query_token_count = count(aiomatic_encode($aicontent));
		$available_tokens = $max_tokens - $query_token_count;
	}
    $thread_id = '';
	$aierror = '';
	$finish_reason = '';
	$generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, 1, 1, 0, 0, false, 'aiContentInfoWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $assistant_id, $thread_id, '', 'disabled', '', false);
	if($generated_text === false)
	{
		wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
        exit;
	}
	else
	{
		$new_post_content = aiomatic_sanitize_ai_result($generated_text);
        if($step == 'meta')
        {
            if(!empty($post_id))
            {
                aiomatic_save_seo_description($post_id, $new_post_content);
            }
        }
	}
    do_action('aiomatic_aicontent_reply', $new_post_content);
    wp_send_json_success( array('content' => $new_post_content) );
    die();
}
add_action( 'wp_ajax_aiomatic_write_aicontent_info', 'aiomatic_write_aicontent_info' );

function aiomatic_save_post_ai() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['post_id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (post_id)' . print_r($_POST, true) ) );
        exit;
	}
    $post_id = $_POST['post_id'];
    if(!isset($_POST['aiomatic_title']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (aiomatic_title)' . print_r($_POST, true) ) );
        exit;
	}
    $this_post = get_post($post_id);
    if($this_post === null)
    {
        wp_send_json_error( array( 'message' => 'Incorrect post_id sent ' . print_r($_POST, true) ) );
        exit;
    }
    $aiomatic_title = $_POST['aiomatic_title'];
    if(!isset($_POST['aiomatic_ai_seo']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (aiomatic_ai_seo)' . print_r($_POST, true) ) );
        exit;
	}
    $aiomatic_ai_seo = $_POST['aiomatic_ai_seo'];
    if(!isset($_POST['aiomatic_ai_content']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (aiomatic_ai_content)' . print_r($_POST, true) ) );
        exit;
	}
    $aiomatic_ai_content = $_POST['aiomatic_ai_content'];
    if(!isset($_POST['aiomatic_ai_excerpt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (aiomatic_ai_excerpt)' . print_r($_POST, true) ) );
        exit;
	}
    $aiomatic_ai_excerpt = $_POST['aiomatic_ai_excerpt'];
    if(!isset($_POST['aiomatic_ai_tags']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (aiomatic_ai_tags)' . print_r($_POST, true) ) );
        exit;
	}
    $aiomatic_ai_tags = $_POST['aiomatic_ai_tags'];
    if(empty($aiomatic_title) && empty($aiomatic_ai_seo) && empty($aiomatic_ai_content) && empty($aiomatic_ai_excerpt) && empty($aiomatic_ai_tags))
    {
        wp_send_json_error( array( 'message' => 'Incorrect query sent (nothing to save)' . print_r($_POST, true) ) );
        exit;
    }
    if(!empty($post_id))
    {
        $need_change = false;
        $my_post = array();
        if($this_post->post_status == 'auto-draft')
        {
            $my_post['post_status'] = 'draft';
        }
        $my_post['ID'] = $post_id;
        if(!empty($aiomatic_title))
        {
            $my_post['post_title'] = $aiomatic_title;
            $need_change = true;
        }
        if(!empty($aiomatic_ai_content))
        {
            $my_post['post_content'] = $aiomatic_ai_content;
            $need_change = true;
        }
        if(!empty($aiomatic_ai_excerpt))
        {
            $my_post['post_excerpt'] = $aiomatic_ai_excerpt;
            $need_change = true;
        }
        if(!empty($aiomatic_ai_tags))
        {
            $my_post['tags_input'] = $aiomatic_ai_tags;
            $need_change = true;
        }
        if(!empty($aiomatic_ai_seo))
        {
            aiomatic_save_seo_description($post_id, $aiomatic_ai_seo);
        }
        if($need_change)
        {
            remove_filter('content_save_pre', 'wp_filter_post_kses');
            remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
            try
            {
                $post_id = wp_update_post($my_post, true);
            }
            catch(Exception $e)
            {
                aiomatic_log_to_file('Exception in saving post: ' . $e->getMessage());
            }
            add_filter('content_save_pre', 'wp_filter_post_kses');
            add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        }
    }
    else
    {
        wp_send_json_error( array( 'message' => 'Empty post_id sent' . print_r($_POST, true) ) );
        exit;
    }
    $post_link = get_edit_post_link($post_id);
    $post_link = str_replace('&amp;', '&', $post_link);
    wp_send_json_success( array('content' => $post_link) );
    die();
}
add_action( 'wp_ajax_aiomatic_save_post_ai', 'aiomatic_save_post_ai' );

add_action('wp_ajax_aiomatic_get_elevenlabs_voice_chat', 'aiomatic_get_elevenlabs_voice_chat');
add_action('wp_ajax_nopriv_aiomatic_get_elevenlabs_voice_chat', 'aiomatic_get_elevenlabs_voice_chat');
function aiomatic_get_elevenlabs_voice_chat()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with elevenlabs');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(!isset($_REQUEST['x_input_text']) || empty($_REQUEST['x_input_text']))
    {
        $aiomatic_result['msg'] = 'No text to send to text-to-speech!';
        wp_send_json($aiomatic_result);
    }
    if ((!isset($aiomatic_Main_Settings['elevenlabs_app_id']) || trim($aiomatic_Main_Settings['elevenlabs_app_id']) == ''))
    {
        $aiomatic_result['msg'] = 'You need to enter an ElevenLabs API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if(isset($aiomatic_Chatbot_Settings['eleven_voice_custom']) && $aiomatic_Chatbot_Settings['eleven_voice_custom'] != '')
    {
        $voice = $aiomatic_Chatbot_Settings['eleven_voice_custom'];
    }
    else
    {
        if(isset($aiomatic_Chatbot_Settings['eleven_voice']) && $aiomatic_Chatbot_Settings['eleven_voice'] != '')
        {
            $voice = $aiomatic_Chatbot_Settings['eleven_voice'];
        }
        else
        {
            $voice = '21m00Tcm4TlvDq8ikWAM';
        }
    }
    if(isset($_REQUEST['overwrite_voice']) && !empty($_REQUEST['overwrite_voice']))
    {
        $voice = trim(stripslashes($_REQUEST['overwrite_voice']));
    }
    $message = sanitize_text_field($_REQUEST['x_input_text']);
    $session = aiomatic_get_session_id();
    $query = new Aiomatic_Query($message, 0, 'elevenlabs', '0', '', 'text-to-speech', 'text-to-speech', trim($aiomatic_Main_Settings['elevenlabs_app_id']), $session, 1, '', '');
    $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
    $ok = apply_filters( 'aiomatic_tts_allowed', true, $aiomatic_Limit_Settings );
    if ( $ok !== true ) 
    {
        $aiomatic_result['msg'] = 'Rate limited: ' . $ok;
        wp_send_json($aiomatic_result);
    }
    $result = aiomatic_elevenlabs_stream($voice, $message, 'aiomatic_Chatbot_Settings');
    if(is_array($result)){
        wp_send_json($result);
    }
    else
    {
        apply_filters( 'aiomatic_ai_reply_text', $query, $message );
        echo $result;
        die();
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_get_god_mode_function', 'aiomatic_get_god_mode_function');
function aiomatic_get_god_mode_function()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    require_once (dirname(__FILE__) . "/aiomatic-god-mode.php"); 
    $god_mode = false;
    $dalle = false;
    $stable = false;
    $midjourney = false;
    $scraper = false;
    $amazon = false;
    $amazon_details = false;
    $rss = false;
    $google = false;
    $captions = false;
    $royalty = false;
    $youtube = false;
    $email = false;
    $facebook = false;
    $facebook_image = false;
    $twitter = false;
    $instagram = false;
    $pinterest = false;
    $business = false;
    $youtube_community = false;
    $reddit = false;
    $linkedin = false;
    $webhook = false;
    $stable_video = false;
    if(isset($_REQUEST['god_mode']) && $_REQUEST['god_mode'] == '1')
    {
        $god_mode = true;
    }
    if(isset($_REQUEST['dalle']) && $_REQUEST['dalle'] == '1')
    {
        $dalle = true;
    }
    if(isset($_REQUEST['stable']) && $_REQUEST['stable'] == '1')
    {
        $stable = true;
    }
    if(isset($_REQUEST['midjourney']) && $_REQUEST['midjourney'] == '1')
    {
        $midjourney = true;
    }
    if(isset($_REQUEST['scraper']) && $_REQUEST['scraper'] == '1')
    {
        $scraper = true;
    }
    if(isset($_REQUEST['amazon']) && $_REQUEST['amazon'] == '1')
    {
        $amazon = true;
    }
    if(isset($_REQUEST['amazon_details']) && $_REQUEST['amazon_details'] == '1')
    {
        $amazon_details = true;
    }
    if(isset($_REQUEST['rss']) && $_REQUEST['rss'] == '1')
    {
        $rss = true;
    }
    if(isset($_REQUEST['google']) && $_REQUEST['google'] == '1')
    {
        $google = true;
    }
    if(isset($_REQUEST['captions']) && $_REQUEST['captions'] == '1')
    {
        $captions = true;
    }
    if(isset($_REQUEST['royalty']) && $_REQUEST['royalty'] == '1')
    {
        $royalty = true;
    }
    if(isset($_REQUEST['youtube']) && $_REQUEST['youtube'] == '1')
    {
        $youtube = true;
    }
    if(isset($_REQUEST['email']) && $_REQUEST['email'] == '1')
    {
        $email = true;
    }
    if(isset($_REQUEST['facebook']) && $_REQUEST['facebook'] == '1')
    {
        $facebook = true;
    }
    if(isset($_REQUEST['facebook_image']) && $_REQUEST['facebook_image'] == '1')
    {
        $facebook_image = true;
    }
    if(isset($_REQUEST['twitter']) && $_REQUEST['twitter'] == '1')
    {
        $twitter = true;
    }
    if(isset($_REQUEST['instagram']) && $_REQUEST['instagram'] == '1')
    {
        $instagram = true;
    }
    if(isset($_REQUEST['pinterest']) && $_REQUEST['pinterest'] == '1')
    {
        $pinterest = true;
    }
    if(isset($_REQUEST['business']) && $_REQUEST['business'] == '1')
    {
        $business = true;
    }
    if(isset($_REQUEST['youtube_community']) && $_REQUEST['youtube_community'] == '1')
    {
        $youtube_community = true;
    }
    if(isset($_REQUEST['reddit']) && $_REQUEST['reddit'] == '1')
    {
        $reddit = true;
    }
    if(isset($_REQUEST['linkedin']) && $_REQUEST['linkedin'] == '1')
    {
        $linkedin = true;
    }
    if(isset($_REQUEST['webhook']) && $_REQUEST['webhook'] == '1')
    {
        $webhook = true;
    }
    if(isset($_REQUEST['stable_video']) && $_REQUEST['stable_video'] == '1')
    {
        $stable_video = true;
    }
    $wp_god_mode = aiomatic_return_god_function_assistants($god_mode, $dalle, $stable, $midjourney, $amazon, $amazon_details, $scraper, $rss, $google, $captions, $royalty, $youtube, $email, $facebook, $facebook_image, $twitter, $instagram, $pinterest, $business, $youtube_community, $reddit, $linkedin, $webhook, $stable_video);
    $aiomatic_result = array('status' => 'success', 'json' => json_encode($wp_god_mode));
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_check_process_status', 'aiomatic_check_process_status');
function aiomatic_check_process_status()
{
    check_ajax_referer('openai-bulk-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with status polling');
    $poll = get_transient('aiomatic_log_history');
    if($poll !== false)
    {
        $aiomatic_result['msg'] = esc_html($poll);
        $aiomatic_result['status'] = 'success';
    }
    else
    {
        $aiomatic_result['msg'] = 'Running status not found';
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_get_openai_voice_chat', 'aiomatic_get_openai_voice_chat');
add_action('wp_ajax_nopriv_aiomatic_get_openai_voice_chat', 'aiomatic_get_openai_voice_chat');
function aiomatic_get_openai_voice_chat()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with OpenAI TTS');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(!isset($_REQUEST['x_input_text']) || empty($_REQUEST['x_input_text']))
    {
        $aiomatic_result['msg'] = 'No text to send to text-to-speech!';
        wp_send_json($aiomatic_result);
    }
    if (!isset($aiomatic_Main_Settings['app_id'])) 
    {
        $aiomatic_Main_Settings['app_id'] = '';
    }
    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    if (empty($token))
    {
        $aiomatic_result['msg'] = 'You need to enter an OpenAI API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    if(aiomatic_is_aiomaticapi_key($token) || (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)))
    {
        $aiomatic_result['msg'] = 'Only OpenAI API keys are supported at the moment.';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if(isset($aiomatic_Chatbot_Settings['open_model_id']) && $aiomatic_Chatbot_Settings['open_model_id'] != '')
    {
        $open_model_id = $aiomatic_Chatbot_Settings['open_model_id'];
    }
    else
    {
        $open_model_id = 'tts-1';
    }
    if(isset($aiomatic_Chatbot_Settings['open_voice']) && $aiomatic_Chatbot_Settings['open_voice'] != '')
    {
        $open_voice = $aiomatic_Chatbot_Settings['open_voice'];
    }
    else
    {
        $open_voice = 'alloy';
    }
    if(isset($_REQUEST['overwrite_voice']) && !empty($_REQUEST['overwrite_voice']))
    {
        $open_voice = trim(stripslashes($_REQUEST['overwrite_voice']));
    }
    if(isset($aiomatic_Chatbot_Settings['open_format']) && $aiomatic_Chatbot_Settings['open_format'] != '')
    {
        $open_format = $aiomatic_Chatbot_Settings['open_format'];
    }
    else
    {
        $open_format = 'mp3';
    }
    if(isset($aiomatic_Chatbot_Settings['open_speed']) && $aiomatic_Chatbot_Settings['open_speed'] != '')
    {
        $open_speed = $aiomatic_Chatbot_Settings['open_speed'];
    }
    else
    {
        $open_speed = '1';
    }
    $message = sanitize_text_field($_REQUEST['x_input_text']);
    $session = aiomatic_get_session_id();
    $query = new Aiomatic_Query($message, 0, 'openai-' . $open_model_id, '0', '', 'text-to-speech', 'text-to-speech', $token, $session, 1, '', '');
    $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
    $ok = apply_filters( 'aiomatic_tts_allowed', true, $aiomatic_Limit_Settings );
    if ( $ok !== true ) 
    {
        $aiomatic_result['msg'] = 'Rate limited: ' . $ok;
        wp_send_json($aiomatic_result);
    }
    $result = aiomatic_openai_voice_stream($token, $open_model_id, $open_voice, $open_format, $open_speed, $message);
    if(is_array($result))
    {
        wp_send_json($result);
    }
    else
    {
        apply_filters( 'aiomatic_ai_reply_text', $query, $message );
        switch ($open_format) 
        {
            case 'opus':
                header('Content-Type: audio/opus');
                break;
            case 'aac':
                header('Content-Type: audio/aac');
                break;
            case 'flac':
                header('Content-Type: audio/flac');
                break;
            default:
                header('Content-Type: audio/mpeg');
        }
        echo $result;
        die();
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_get_google_voice_chat', 'aiomatic_get_google_voice_chat');
add_action('wp_ajax_nopriv_aiomatic_get_google_voice_chat', 'aiomatic_get_google_voice_chat');
function aiomatic_get_google_voice_chat()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with Google Voice');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(!isset($_REQUEST['x_input_text']) || empty($_REQUEST['x_input_text']))
    {
        $aiomatic_result['msg'] = 'No text to send to text-to-speech!';
        wp_send_json($aiomatic_result);
    }
    if ((!isset($aiomatic_Main_Settings['google_app_id']) || trim($aiomatic_Main_Settings['google_app_id']) == ''))
    {
        $aiomatic_result['msg'] = 'You need to enter an Google Text-to-Speech API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if(isset($aiomatic_Chatbot_Settings['google_voice']) && $aiomatic_Chatbot_Settings['google_voice'] != '')
    {
        $voice = $aiomatic_Chatbot_Settings['google_voice'];
    }
    else
    {
        $aiomatic_result['msg'] = 'You need to select a Google Text-to-Speech Voice Name for this feature to work.';
        wp_send_json($aiomatic_result);
    }
    if(isset($_REQUEST['overwrite_voice']) && !empty($_REQUEST['overwrite_voice']))
    {
        $voice = trim(stripslashes($_REQUEST['overwrite_voice']));
    }
    if(isset($aiomatic_Chatbot_Settings['audio_profile']) && $aiomatic_Chatbot_Settings['audio_profile'] != '')
    {
        $audio_profile = $aiomatic_Chatbot_Settings['audio_profile'];
    }
    else
    {
        $audio_profile = '';
    }
    if(isset($aiomatic_Chatbot_Settings['voice_language']) && $aiomatic_Chatbot_Settings['voice_language'] != '')
    {
        $voice_language = $aiomatic_Chatbot_Settings['voice_language'];
    }
    else
    {
        $aiomatic_result['msg'] = 'You need to select a Google Text-to-Speech Voice Language for this feature to work.';
        wp_send_json($aiomatic_result);
    }
    if(isset($aiomatic_Chatbot_Settings['voice_speed']) && $aiomatic_Chatbot_Settings['voice_speed'] != '')
    {
        $voice_speed = $aiomatic_Chatbot_Settings['voice_speed'];
    }
    else
    {
        $voice_speed = '';
    }
    if(isset($aiomatic_Chatbot_Settings['voice_pitch']) && $aiomatic_Chatbot_Settings['voice_pitch'] != '')
    {
        $voice_pitch = $aiomatic_Chatbot_Settings['voice_pitch'];
    }
    else
    {
        $voice_pitch = '';
    }
    $message = sanitize_text_field($_REQUEST['x_input_text']);
    $session = aiomatic_get_session_id();
    $query = new Aiomatic_Query($message, 0, 'google', '0', '', 'text-to-speech', 'text-to-speech', trim($aiomatic_Main_Settings['google_app_id']), $session, 1, '', '');
    $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
    $ok = apply_filters( 'aiomatic_tts_allowed', true, $aiomatic_Limit_Settings );
    if ( $ok !== true ) 
    {
        $aiomatic_result['msg'] = 'Rate limited: ' . $ok;
        wp_send_json($aiomatic_result);
    }
    $result = aiomatic_google_stream($voice, $voice_language, $audio_profile, $voice_speed, $voice_pitch, $message);
    if(is_array($result)){
        if(isset($result['status']) && $result['status'] == 'success')
        {
            apply_filters( 'aiomatic_ai_reply_text', $query, $message );
        }
        wp_send_json($result);
    }
    else
    {
        echo $result;
        die();
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_get_d_id_video_chat', 'aiomatic_get_d_id_video_chat');
add_action('wp_ajax_nopriv_aiomatic_get_d_id_video_chat', 'aiomatic_get_d_id_video_chat');
function aiomatic_get_d_id_video_chat()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with D-ID');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(!isset($_REQUEST['x_input_text']) || empty($_REQUEST['x_input_text']))
    {
        $aiomatic_result['msg'] = 'No text to send to text-to-video!';
        wp_send_json($aiomatic_result);
    }
    if ((!isset($aiomatic_Main_Settings['did_app_id']) || trim($aiomatic_Main_Settings['did_app_id']) == ''))
    {
        $aiomatic_result['msg'] = 'You need to enter an Google Text-to-video API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if(isset($aiomatic_Chatbot_Settings['did_image']) && $aiomatic_Chatbot_Settings['did_image'] != '')
    {
        $did_image = $aiomatic_Chatbot_Settings['did_image'];
    }
    else
    {
        $did_image = 'https://create-images-results.d-id.com/api_docs/assets/noelle.jpeg';
    }
    if(isset($aiomatic_Chatbot_Settings['did_voice']) && $aiomatic_Chatbot_Settings['did_voice'] != '')
    {
        $did_voice = $aiomatic_Chatbot_Settings['did_voice'];
    }
    else
    {
        $did_voice = 'microsoft:en-US-JennyNeural:Cheerful';
    }
    if(isset($_REQUEST['overwrite_voice']) && !empty($_REQUEST['overwrite_voice']))
    {
        $did_voice = trim(stripslashes($_REQUEST['overwrite_voice']));
    }
    $message = sanitize_text_field($_REQUEST['x_input_text']);
    $session = aiomatic_get_session_id();
    $query = new Aiomatic_Query($message, 0, 'd-id', '0', '', 'text-to-speech', 'text-to-speech', trim($aiomatic_Main_Settings['did_app_id']), $session, 1, '', '');
    $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
    $ok = apply_filters( 'aiomatic_tts_allowed', true, $aiomatic_Limit_Settings );
    if ( $ok !== true ) 
    {
        $aiomatic_result['msg'] = 'Rate limited: ' . $ok;
        wp_send_json($aiomatic_result);
    }
    $result = aiomatic_d_id_video($did_image, $message, $did_voice);
    if(is_array($result)){
        if(isset($result['status']) && $result['status'] == 'success')
        {
            apply_filters( 'aiomatic_ai_reply_text', $query, $message );
        }
        else
        {
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                aiomatic_log_to_file('D-ID Video Failed: ' . print_r($result, true));
            }
        }
        wp_send_json($result);
    }
    else
    {
        echo $result;
        die();
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_get_d_id_default_video_chat', 'aiomatic_get_d_id_default_video_chat');
add_action('wp_ajax_nopriv_aiomatic_get_d_id_default_video_chat', 'aiomatic_get_d_id_default_video_chat');
function aiomatic_get_d_id_default_video_chat()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with D-ID');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if ((!isset($aiomatic_Main_Settings['did_app_id']) || trim($aiomatic_Main_Settings['did_app_id']) == ''))
    {
        $aiomatic_result['msg'] = 'You need to enter an Google Text-to-video API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    if(isset($_POST['did_image']) && trim($_POST['did_image']) != '')
    {
        $did_image = $_POST['did_image'];
    }
    else
    {
        $aiomatic_result['msg'] = 'Insuficient parameters for call!';
        wp_send_json($aiomatic_result);
    }
    $filename = basename($did_image);
    $filename = explode("?", $filename);
    $filename = $filename[0];
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    $local_exist = aiomatic_check_video_locally($filename);
    if($local_exist !== false)
    {
        $result['video'] = $local_exist;
        $result['status'] = 'success';
        wp_send_json($result);
    }
    $message = '<break time="5000ms"/>';
    $session = aiomatic_get_session_id();
    $query = new Aiomatic_Query($message, 0, 'd-id', '0', '', 'text-to-speech', 'text-to-speech', trim($aiomatic_Main_Settings['did_app_id']), $session, 1, '', '');
    $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
    $ok = apply_filters( 'aiomatic_tts_allowed', true, $aiomatic_Limit_Settings );
    if ( $ok !== true ) 
    {
        $aiomatic_result['msg'] = 'Rate limited: ' . $ok;
        wp_send_json($aiomatic_result);
    }
    $result = aiomatic_d_id_idle_video($did_image, $message);
    if(is_array($result)){
        if(isset($result['status']) && $result['status'] == 'success' && isset($result['video']))
        {
            $local_url = aiomatic_copy_video_locally($result['video'], $filename, 'local');
            if(isset($local_url[0]) && $local_url !== false)
            {
                $result['video'] = $local_url[0];
            }
            else
            {
                aiomatic_log_to_file('Failed to copy default video locally to your server! Please check on available storage space.');
            }
            apply_filters( 'aiomatic_ai_reply_text', $query, $message );
        }
        else
        {
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                aiomatic_log_to_file('D-ID Video Failed: ' . print_r($result, true));
            }
        }
        wp_send_json($result);
    }
    else
    {
        echo $result;
        die();
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_comment_replier', 'aiomatic_comment_replier');
function aiomatic_comment_replier()
{
    check_ajax_referer('openai-comment-nonce', 'nonce');
    if(!isset($_POST['zid']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (id)' . print_r($_POST, true) ) );
        exit;
	}
    $comment_id = sanitize_text_field($_POST['zid']);
    $comment = get_comment($comment_id);
    if(!$comment || is_wp_error($comment))
    {
        wp_send_json_error( array( 'message' => 'Failed to find comment with ID: ' . $comment_id) );
        exit;
    }
    $post = get_post($comment->comment_post_ID);
    if(!$post) 
    {
        wp_send_json_error( array( 'message' => 'Failed to find post for comment, with ID: ' . $comment->comment_post_ID) );
        exit;
    }
	$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
	if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
    if (isset($aiomatic_Main_Settings['comment_prompt']) && trim($aiomatic_Main_Settings['comment_prompt']) != '') 
    {
        $prompt = trim($aiomatic_Main_Settings['comment_prompt']);
    }
    else
    {
        $prompt = 'Write a reply for %%username%%\'s comment on the post titled "%%post_title%%". The user\'s comment is: %%comment%%';
    }
    if (isset($aiomatic_Main_Settings['comment_model']) && trim($aiomatic_Main_Settings['comment_model']) != '') 
    {
        $model = trim($aiomatic_Main_Settings['comment_model']);
    }
    else
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
    if (isset($aiomatic_Main_Settings['comment_assistant_id']) && trim($aiomatic_Main_Settings['comment_assistant_id']) != '') 
    {
        $comment_assistant_id = trim($aiomatic_Main_Settings['comment_assistant_id']);
    }
    else
    {
        $comment_assistant_id = '';
    }
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
	$new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    $prompt = str_replace('%%post_title%%', $post->post_title, $prompt);
    $prompt = str_replace('%%post_excerpt%%', $post->post_excerpt, $prompt);
    $prompt = str_replace('%%username%%', $comment->comment_author, $prompt);
    $prompt = str_replace('%%comment%%', $comment->comment_content, $prompt);
	$query_token_count = count(aiomatic_encode($prompt));
    $max_tokens = aiomatic_get_max_tokens($model);
	$available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
	if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
	{
		$string_len = strlen($prompt);
		$string_len = $string_len / 2;
		$string_len = intval(0 - $string_len);
        $aicontent = aiomatic_substr($prompt, 0, $string_len);
		$aicontent = trim($aicontent);
		if(empty($aicontent))
		{
			wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
            exit;
		}
		$query_token_count = count(aiomatic_encode($aicontent));
		$available_tokens = $max_tokens - $query_token_count;
	}
    $thread_id = '';
	$aierror = '';
	$finish_reason = '';
	$generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, 1, 1, 0, 0, false, 'singleCommentWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $comment_assistant_id, $thread_id, '', 'disabled', '', false);
	if($generated_text === false)
	{
		wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
        exit;
	}
	else
	{
		$new_post_content = aiomatic_sanitize_ai_result($generated_text);
	}
    do_action('aiomatic_comment_reply', $new_post_content);
	wp_send_json_success( array( 'content' => $new_post_content ) );
    exit;
}

add_action('wp_ajax_aiomatic_generate_media_text', 'aiomatic_generate_media_text');
function aiomatic_generate_media_text()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['prompt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prompt)' . print_r($_POST, true) ) );
        exit;
	}
    $prompt = sanitize_text_field($_POST['prompt']);
    if(!isset($_POST['title']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (title)' . print_r($_POST, true) ) );
        exit;
	}
    $title = sanitize_text_field($_POST['title']);
    if(!isset($_POST['caption']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (caption)' . print_r($_POST, true) ) );
        exit;
	}
    $caption = sanitize_text_field($_POST['caption']);
    if(!isset($_POST['alt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (alt)' . print_r($_POST, true) ) );
        exit;
	}
    $alt = sanitize_text_field($_POST['alt']);
    if(!isset($_POST['content']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (content)' . print_r($_POST, true) ) );
        exit;
	}
    $content = sanitize_text_field($_POST['content']);
    if(!isset($_POST['model']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (model)' . print_r($_POST, true) ) );
        exit;
	}
    $model = sanitize_text_field($_POST['model']);
    if(!isset($_POST['assistant_id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (assistant_id)' . print_r($_POST, true) ) );
        exit;
	}
    $assistant_id = sanitize_text_field($_POST['assistant_id']);
    if(!isset($_POST['id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (id)' . print_r($_POST, true) ) );
        exit;
	}
    $attachment_id = sanitize_text_field($_POST['id']);
	$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
	if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
	$new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    $prompt = str_replace('%%image_title%%', $title, $prompt);
    $prompt = str_replace('%%image_caption%%', $caption, $prompt);
    $prompt = str_replace('%%image_alt%%', $alt, $prompt);
    $prompt = str_replace('%%image_description%%', $content, $prompt);
    $blog_title = html_entity_decode(get_bloginfo('title'));
    $prompt = str_replace('%%blog_title%%', $blog_title, $prompt);
    $prompt = str_replace('%%random_sentence%%', aiomatic_random_sentence_generator(), $prompt);
    $prompt = str_replace('%%random_sentence2%%', aiomatic_random_sentence_generator(false), $prompt);
    $parent_post_id = wp_get_post_parent_id($attachment_id);
    if ($parent_post_id) 
    {
        $parent_post_title = get_the_title($parent_post_id);
        $prompt = str_replace('%%parent_title%%', $parent_post_title, $prompt);
        $parent_post_excerpt = get_the_excerpt($parent_post_id);
        $prompt = str_replace('%%parent_excerpt%%', $parent_post_excerpt, $prompt);
        $parent_post_content = get_the_content($parent_post_id);
        $prompt = str_replace('%%parent_content%%', $parent_post_content, $prompt);
    } 
    else 
    {
        $prompt = str_replace('%%parent_title%%', '', $prompt);
        $prompt = str_replace('%%parent_excerpt%%', '', $prompt);
        $prompt = str_replace('%%parent_content%%', '', $prompt);
    }
    $prompt = aiomatic_replaceSynergyShortcodes($prompt);
	$query_token_count = count(aiomatic_encode($prompt));
    $max_tokens = aiomatic_get_max_tokens($model);
	$available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
	if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
	{
		$string_len = strlen($prompt);
		$string_len = $string_len / 2;
		$string_len = intval(0 - $string_len);
        $aicontent = aiomatic_substr($prompt, 0, $string_len);
		$aicontent = trim($aicontent);
		if(empty($aicontent))
		{
			wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
            exit;
		}
		$query_token_count = count(aiomatic_encode($aicontent));
		$available_tokens = $max_tokens - $query_token_count;
	}
    $thread_id = '';
	$aierror = '';
	$finish_reason = '';
	$generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, 1, 1, 0, 0, false, 'singleMediaWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $assistant_id, $thread_id, '', 'disabled', '', false);
	if($generated_text === false)
	{
		wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
        exit;
	}
	else
	{
		$new_post_content = aiomatic_sanitize_ai_result($generated_text);
	}
	wp_send_json_success( array( 'content' => $new_post_content ) );
    exit;
}

add_action('wp_ajax_aiomatic_save_media_text', 'aiomatic_save_media_text');
function aiomatic_save_media_text()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['title']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (title)' . print_r($_POST, true) ) );
        exit;
	}
    $title = sanitize_text_field($_POST['title']);
    if(!isset($_POST['caption']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (caption)' . print_r($_POST, true) ) );
        exit;
	}
    $caption = sanitize_text_field($_POST['caption']);
    if(!isset($_POST['alt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (alt)' . print_r($_POST, true) ) );
        exit;
	}
    $alt = sanitize_text_field($_POST['alt']);
    if(!isset($_POST['content']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (content)' . print_r($_POST, true) ) );
        exit;
	}
    $content = sanitize_text_field($_POST['content']);
    if(!isset($_POST['id']) || !is_numeric($_POST['id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (id)' . print_r($_POST, true) ) );
        exit;
	}
    $id = sanitize_text_field($_POST['id']);
    $attachment_data = array(
        'ID'           => $id,
        'post_title'   => $title,
        'post_excerpt' => $caption,
        'post_content' => $content
    );
    $result = wp_update_post($attachment_data);
	if (is_wp_error($result))
	{
		wp_send_json_error( array( 'message' => 'Failed to save media: ' . $result->get_error_message()) );
        exit;
	}
	else
	{
        update_post_meta($id, '_wp_attachment_image_alt', $alt);
		$new_post_content = 'ok';
	}
	wp_send_json_success( array( 'content' => $new_post_content ) );
    exit;
}

add_action('wp_ajax_aiomatic_get_elevenlabs_voices', 'aiomatic_update_elevenlabs_voices_func');
add_action('wp_ajax_nopriv_aiomatic_get_elevenlabs_voices', 'aiomatic_update_elevenlabs_voices_func');
function aiomatic_update_elevenlabs_voices_func()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong EleventLabs');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['elevenlabs_app_id']) || trim($aiomatic_Main_Settings['elevenlabs_app_id']) == '')
    {
        $aiomatic_result['msg'] = 'You need to enter an ElevenLabs API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $my_voices = aiomatic_update_elevenlabs_voices();
    if(is_array($my_voices))
    {
        update_option('aiomatic_elevenlabs', $my_voices);
        $aiomatic_result['status'] = 'success';
    }
    else
    {
        $aiomatic_result['msg'] = 'Failed to list ElevenLabs Voices!';
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_get_google_voices', 'aiomatic_update_google_voices_func');
add_action('wp_ajax_nopriv_aiomatic_get_google_voices', 'aiomatic_update_google_voices_func');
function aiomatic_update_google_voices_func()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong Google Voice Function');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if (!isset($aiomatic_Main_Settings['google_app_id']) || trim($aiomatic_Main_Settings['google_app_id']) == '')
    {
        $aiomatic_result['msg'] = 'You need to enter an Google Text-to-Speech API key for this to work!';
        wp_send_json($aiomatic_result);
    }
    if (isset($aiomatic_Chatbot_Settings['voice_language']) && trim($aiomatic_Chatbot_Settings['voice_language']) != '')
    {
        $voice_language = trim($aiomatic_Chatbot_Settings['voice_language']);
    }
    else
    {
        $voice_language = 'en-US';
    }
    $my_voices = aiomatic_update_google_voices($voice_language);
    if(is_array($my_voices))
    {
        update_option('aiomatic_google_voices' . sanitize_title($voice_language), $my_voices);
        $aiomatic_result['status'] = 'success';
    }
    else
    {
        $aiomatic_result['msg'] = 'Failed to list Google Text-to-Speech Voices!';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_form_upload', 'aiomatic_form_upload');
function aiomatic_form_upload()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with form upload');
    if(isset($_FILES['file']) && empty($_FILES['file']['error']))
    {
        $file_name = sanitize_file_name(basename($_FILES['file']['name']));
        $filetype = wp_check_filetype($file_name);
        if($filetype['ext'] !== 'json' && !aiomatic_endsWith($file_name, '.json')){
            $aiomatic_result['msg'] = 'Only files with the json extension are supported, you sent: ' . $file_name;
            wp_send_json($aiomatic_result);
        }
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $fc = $wp_filesystem->get_contents($_FILES['file']['tmp_name']);
        if(empty($fc))
        {
            $aiomatic_result['msg'] = 'Failed to read file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        $fc_dec = json_decode($fc, true);
        if($fc_dec === null)
        {
            $aiomatic_result['msg'] = 'Failed to decode json file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        if(isset($_POST['overwrite']))
        {
            $overwrite = $_POST['overwrite'];
        }
        else
        {
            $overwrite = '0';
        }
        foreach($fc_dec as $jsonf)
        {
            $address_post_id = 0;
            $query = new WP_Query(
                array(
                    'post_type'              => 'aiomatic_forms',
                    'title'                  => $jsonf['title'],
                    'post_status'            => 'all',
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false,
                    'orderby'                => 'post_date ID',
                    'order'                  => 'ASC',
                )
            );
            
            if ( ! empty( $query->post ) ) {
                if($overwrite != '1')
                {
                    //form already exists, skipping it
                    continue;
                }
                else
                {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $address_post_id = get_the_ID();
                        break;
                    }
                }
            }
            $forms_data = array(
                'post_type' => 'aiomatic_forms',
                'post_title' => $jsonf['title'],
                'post_content' => $jsonf['description'],
                'post_status' => 'publish'
            );
            $forms_data['ID'] = $address_post_id;
            remove_filter('content_save_pre', 'wp_filter_post_kses');
            remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
            if($overwrite != '1')
            {
                $forms_id = wp_insert_post($forms_data);
            }
            else
            {
                if(isset($forms_data['ID']) && $forms_data['ID'] != '0')
                {
                    $forms_id = wp_update_post($forms_data);
                }
                else
                {
                    $forms_id = wp_insert_post($forms_data);
                }
            }
            add_filter('content_save_pre', 'wp_filter_post_kses');
            add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
            if(is_wp_error($forms_id))
            {
                aiomatic_log_to_file('Failed to import form: ' . $forms_id->get_error_message());
            }
            elseif($forms_id === 0)
            {
                aiomatic_log_to_file('Failed to insert form to database: ' . print_r($forms_data, true));
            }
            else 
            {
                update_post_meta($forms_id, 'prompt', $jsonf['prompt']);
                if(isset($jsonf['assistant_id']))
                {
                    update_post_meta($forms_id, 'assistant_id', $jsonf['assistant_id']);
                }
                update_post_meta($forms_id, 'model', $jsonf['model']);
                update_post_meta($forms_id, 'header', $jsonf['header']);
                if(!isset($jsonf['editor']))
                {
                    $jsonf['editor'] = 'textarea';
                }
                update_post_meta($forms_id, 'editor', $jsonf['editor']);
                if(!isset($jsonf['advanced']))
                {
                    $jsonf['advanced'] = 'hide';
                }
                update_post_meta($forms_id, 'advanced', $jsonf['advanced']);
                update_post_meta($forms_id, 'submit', $jsonf['submit']);
                update_post_meta($forms_id, 'max', $jsonf['max']);
                update_post_meta($forms_id, 'temperature', $jsonf['temperature']);
                update_post_meta($forms_id, 'topp', $jsonf['topp']);
                update_post_meta($forms_id, 'presence', $jsonf['presence']);
                update_post_meta($forms_id, 'frequency', $jsonf['frequency']);
                update_post_meta($forms_id, 'response', $jsonf['response']);
                if(isset($jsonf['streaming_enabled']))
                {
                    update_post_meta($forms_id, 'streaming_enabled', $jsonf['streaming_enabled']);
                }
                else
                {
                    update_post_meta($forms_id, 'streaming_enabled', '0');
                }
                update_post_meta($forms_id, 'type', $jsonf['type']);
                update_post_meta($forms_id, '_aiomaticfields', $jsonf['aiomaticfields']);
            }
        }
        $aiomatic_result['status'] = 'success';
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_persona_upload', 'aiomatic_persona_upload');
function aiomatic_persona_upload()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with persona upload');
    if(isset($_FILES['file']) && empty($_FILES['file']['error']))
    {
        $file_name = sanitize_file_name(basename($_FILES['file']['name']));
        $filetype = wp_check_filetype($file_name);
        if($filetype['ext'] !== 'json' && !aiomatic_endsWith($file_name, '.json')){
            $aiomatic_result['msg'] = 'Only files with the json extension are supported, you sent: ' . $file_name;
            wp_send_json($aiomatic_result);
        }
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $fc = $wp_filesystem->get_contents($_FILES['file']['tmp_name']);
        if(empty($fc))
        {
            $aiomatic_result['msg'] = 'Failed to read file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        $fc_dec = json_decode($fc, true);
        if($fc_dec === null)
        {
            $aiomatic_result['msg'] = 'Failed to decode json file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        if(isset($_POST['overwrite']))
        {
            $overwrite = $_POST['overwrite'];
        }
        else
        {
            $overwrite = '0';
        }
        foreach($fc_dec as $jsonf)
        {
            $address_post_id = 0;
            $query = new WP_Query(
                array(
                    'post_type'              => 'aiomatic_personas',
                    'title'                  => $jsonf['name'],
                    'post_status'            => 'all',
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false,
                    'orderby'                => 'post_date ID',
                    'order'                  => 'ASC',
                )
            );
            
            if ( ! empty( $query->post ) ) {
                if($overwrite != '1')
                {
                    //persona already exists, skipping it
                    continue;
                }
                else
                {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $address_post_id = get_the_ID();
                        break;
                    }
                }
            }
            $personas_data = array(
                'post_type' => 'aiomatic_personas',
                'post_title' => $jsonf['name'],
                'post_excerpt' => $jsonf['role'],
                'post_content' => $jsonf['prompt'],
                'post_status' => 'publish'
            );
            $personas_data['ID'] = $address_post_id;
            remove_filter('content_save_pre', 'wp_filter_post_kses');
            remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
            if($overwrite != '1')
            {
                $personas_id = wp_insert_post($personas_data);
            }
            else
            {
                if(isset($personas_data['ID']) && $personas_data['ID'] != '0')
                {
                    $personas_id = wp_update_post($personas_data);
                }
                else
                {
                    $personas_id = wp_insert_post($personas_data);
                }
            }
            add_filter('content_save_pre', 'wp_filter_post_kses');
            add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
            if(is_wp_error($personas_id))
            {
                aiomatic_log_to_file('Failed to import persona: ' . $personas_id->get_error_message());
            }
            elseif($personas_id === 0)
            {
                aiomatic_log_to_file('Failed to insert persona to database: ' . print_r($personas_data, true));
            }
            else 
            {
                if(is_numeric($jsonf['avatar']))
                {
                    if($jsonf['avatar'] > 0)
                    {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        require_once(ABSPATH . 'wp-admin/includes/media.php');
                        set_post_thumbnail( $personas_id, $jsonf['avatar'] );
                    }
                }
                elseif(filter_var($jsonf['avatar'], FILTER_VALIDATE_URL))
                {
                    if (!aiomatic_generate_featured_image($jsonf['avatar'], $personas_id)) 
                    {
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
                        {
                            aiomatic_log_to_file('aiomatic_generate_featured_image failed for ' . $jsonf['avatar']);
                        }
                    }
                }
                if(isset($jsonf['message']) && !empty($jsonf['message']))
                {
                    update_post_meta($personas_id, '_persona_first_message', $jsonf['message']);
                }
            }
        }
        $aiomatic_result['status'] = 'success';
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_assistant_upload', 'aiomatic_assistant_upload');
function aiomatic_assistant_upload()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with assistant upload');
    if(isset($_FILES['file']) && empty($_FILES['file']['error']))
    {
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
            $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            if(empty($token))
            {
                $aiomatic_result['msg'] = 'Invalid API key submitted';
                wp_send_json($aiomatic_result);
            }
            if(aiomatic_is_aiomaticapi_key($token))
            {
                $aiomatic_result['msg'] = 'Currently only OpenAI API is supported for text moderation.';
                wp_send_json($aiomatic_result);
            }
        }
        $file_name = sanitize_file_name(basename($_FILES['file']['name']));
        $filetype = wp_check_filetype($file_name);
        if($filetype['ext'] !== 'json' && !aiomatic_endsWith($file_name, '.json')){
            $aiomatic_result['msg'] = 'Only files with the json extension are supported, you sent: ' . $file_name;
            wp_send_json($aiomatic_result);
        }
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $fc = $wp_filesystem->get_contents($_FILES['file']['tmp_name']);
        if(empty($fc))
        {
            $aiomatic_result['msg'] = 'Failed to read file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        $fc_dec = json_decode($fc, true);
        if($fc_dec === null)
        {
            $aiomatic_result['msg'] = 'Failed to decode json file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        if(isset($_POST['overwrite']))
        {
            $overwrite = $_POST['overwrite'];
        }
        else
        {
            $overwrite = '0';
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
        foreach($fc_dec as $jsonf)
        {
            $vector_store_id = '';
            if(empty($jsonf['role']))
            {
                $jsonf['role'] = '';
            }
            if(empty($jsonf['prompt']))
            {
                $jsonf['prompt'] = '';
            }
            if(empty($jsonf['message']))
            {
                $jsonf['message'] = '';
            }
            $existing_openai = false;
            $address_post_id = 0;
            $assistant_id = '';
            $temperature = '';
            $topp = '';
            if(isset($jsonf['temperature']))
            {
                $temperature = $jsonf['temperature'];
            }
            if(isset($jsonf['topp']))
            {
                $topp = $jsonf['topp'];
            }
            if(isset($jsonf['id']) && !empty($jsonf['id']))
            {
                $query = new WP_Query(
                    array(
                        'post_type'              => 'aiomatic_assistants',
                        'meta_query' => array(
                            array(
                                'key'     => '_assistant_id',
                                'value'   => $jsonf['id'],
                                'compare' => 'EXISTS'
                            ),
                        ),
                        'post_status'            => 'all',
                        'posts_per_page'         => 1,
                        'no_found_rows'          => true,
                        'ignore_sticky_posts'    => true,
                        'update_post_term_cache' => false,
                        'update_post_meta_cache' => false,
                        'orderby'                => 'post_date ID',
                        'order'                  => 'ASC',
                    )
                );
                if ( ! empty( $query->post ) ) 
                {
                    if($overwrite != '1')
                    {
                        //assistant already exists, skipping it
                        continue;
                    }
                    else
                    {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            $address_post_id = get_the_ID();
                            $assistant_id = get_post_meta($address_post_id, '_assistant_id', true);
                            break;
                        }
                    }
                }
                if(!empty($assistant_id))
                {
                    try
                    {
                        $ex_assistant = aiomatic_openai_retrieve_assistant($token, $assistant_id);
                        if(isset($ex_assistant['id']) && $ex_assistant['id'] == $assistant_id)
                        {
                            $existing_openai = true;
                        }
                    }
                    catch(Exception $e)
                    {
                        $aiomatic_result['msg'] = 'Failed to retrieve assistant using the API '  . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    }
                }
            }
            if($existing_openai == true)
            {
                $tools = [];
                if($jsonf['code_interpreter'] == 'on')
                {
                    $tools[] = ['type' => 'code_interpreter'];
                }
                if($jsonf['file_search'] == 'on')
                {
                    $tools[] = ['type' => 'file_search'];
                }
                $functions_json = $jsonf['functions'];
                if($functions_json === false)
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
                try
                {
                    if($address_post_id != '' && $address_post_id != 0)
                    {
                        $vector_store_id = get_post_meta($address_post_id, '_assistant_vector_store_id', true);
                    }
                    $metadata = '';
                    $assistantData = aiomatic_openai_modify_assistant($token, $assistant_id, $jsonf['model'], $jsonf['name'], $jsonf['role'], $jsonf['prompt'], $temperature, $topp, $tools, $jsonf['files'], $metadata, $vector_store_id, $address_post_id);
                    if($assistantData === false)
                    {
                        $aiomatic_result['msg'] = 'Failed to update assistant using the API';
                        wp_send_json($aiomatic_result);
                    }
                }
                catch(Exception $e)
                {
                    $aiomatic_result['msg'] = 'Failed to retrieve assistant using the API '  . $e->getMessage();
                    wp_send_json($aiomatic_result);
                }
            }
            else
            {
                $tools = [];
                if($jsonf['code_interpreter'] == 'on')
                {
                    $tools[] = ['type' => 'code_interpreter'];
                }
                if($jsonf['file_search'] == 'on')
                {
                    $tools[] = ['type' => 'file_search'];
                }
                $functions_json = $jsonf['functions'];
                if($functions_json === false)
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
                try
                {
                    $metadata = '';
                    $assistantData = aiomatic_openai_save_assistant(
                        $token,
                        $jsonf['model'],
                        $jsonf['name'],
                        $jsonf['role'],
                        $temperature,
                        $topp,
                        $jsonf['prompt'],
                        $tools,
                        $jsonf['files'],
                        $metadata,
                        $vector_store_id
                    );
                    if($assistantData === false)
                    {
                        $aiomatic_result['msg'] = 'Failed to save assistant using the API';
                        wp_send_json($aiomatic_result);
                    }
                    else
                    {
                        $assistant_id = $assistantData['id'];
                    }
                }
                catch(Exception $e)
                {
                    $aiomatic_result['msg'] = 'Failed to retrieve assistant using the API '  . $e->getMessage();
                    wp_send_json($aiomatic_result);
                }
            }
            $assistants_data = array(
                'post_type' => 'aiomatic_assistants',
                'post_title' => $jsonf['name'],
                'post_excerpt' => $jsonf['role'],
                'post_content' => $jsonf['prompt'],
                'post_status' => 'publish'
            );
            $assistants_data['ID'] = $address_post_id;
            remove_filter('content_save_pre', 'wp_filter_post_kses');
            remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
            if($overwrite != '1')
            {
                $assistants_id_local = wp_insert_post($assistants_data);
            }
            else
            {
                if(isset($assistants_data['ID']) && $assistants_data['ID'] != '0')
                {
                    $assistants_id_local = wp_update_post($assistants_data);
                }
                else
                {
                    $assistants_id_local = wp_insert_post($assistants_data);
                }
            }
            add_filter('content_save_pre', 'wp_filter_post_kses');
            add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
            if(is_wp_error($assistants_id_local))
            {
                aiomatic_log_to_file('Failed to import assistant: ' . $assistants_id_local->get_error_message());
            }
            elseif($assistants_id_local === 0)
            {
                aiomatic_log_to_file('Failed to insert assistant to database: ' . print_r($assistants_data, true));
            }
            else 
            {
                if(is_numeric($jsonf['avatar']))
                {
                    if($jsonf['avatar'] > 0)
                    {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        require_once(ABSPATH . 'wp-admin/includes/media.php');
                        set_post_thumbnail( $assistants_id_local, $jsonf['avatar'] );
                    }
                }
                elseif(filter_var($jsonf['avatar'], FILTER_VALIDATE_URL))
                {
                    if (!aiomatic_generate_featured_image($jsonf['avatar'], $assistants_id_local)) 
                    {
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
                        {
                            aiomatic_log_to_file('aiomatic_generate_featured_image failed for ' . $jsonf['avatar']);
                        }
                    }
                }
                if(isset($jsonf['message']) && !empty($jsonf['message']))
                {
                    update_post_meta($assistants_id_local, '_assistant_first_message', $jsonf['message']);
                }
                else
                {
                    update_post_meta($assistants_id_local, '_assistant_first_message', '');
                }
                update_post_meta($assistants_id_local, '_assistant_id', $assistant_id);
                if(!empty($jsonf['model']))
                {
                    update_post_meta($assistants_id_local, '_assistant_model', $jsonf['model']);
                }
                $tools = [];
                if($jsonf['code_interpreter'] == 'on')
                {
                    $tools[] = ['type' => 'code_interpreter'];
                }
                if($jsonf['file_search'] == 'on')
                {
                    $tools[] = ['type' => 'file_search'];
                }
                $functions_json = $jsonf['functions'];
                if($functions_json === false)
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
                if(!empty($tools))
                {
                    update_post_meta($assistants_id_local, '_assistant_tools', $tools);
                }
                else
                {
                    update_post_meta($assistants_id_local, '_assistant_tools', array());
                }
                if(!empty($temperature))
                {
                    update_post_meta($assistants_id_local, '_assistant_temperature', $temperature);
                }
                if(!empty($topp))
                {
                    update_post_meta($assistants_id_local, '_assistant_topp', $topp);
                }
                if(!empty($vector_store_id))
                {
                    update_post_meta($assistants_id_local, '_assistant_vector_store_id', $vector_store_id);
                }
                if(!empty($jsonf['files']))
                {
                    update_post_meta($assistants_id_local, '_assistant_files', $jsonf['files']);
                }
                else
                {
                    update_post_meta($assistants_id_local, '_assistant_files', array());
                }
            }
        }
        $aiomatic_result['status'] = 'success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_omni_upload', 'aiomatic_omni_upload');
function aiomatic_omni_upload()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with OmniBlock Template upload');
    if(isset($_FILES['file']) && empty($_FILES['file']['error']))
    {
        $file_name = sanitize_file_name(basename($_FILES['file']['name']));
        $filetype = wp_check_filetype($file_name);
        if($filetype['ext'] !== 'json' && !aiomatic_endsWith($file_name, '.json')){
            $aiomatic_result['msg'] = 'Only files with the json extension are supported, you sent: ' . $file_name;
            wp_send_json($aiomatic_result);
        }
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $fc = $wp_filesystem->get_contents($_FILES['file']['tmp_name']);
        if(empty($fc))
        {
            $aiomatic_result['msg'] = 'Failed to read file: ' . $_FILES['file']['tmp_name'];
            wp_send_json($aiomatic_result);
        }
        $fc = aiomatic_removeBOM($fc);
        $fc_dec = json_decode($fc, true);
        if($fc_dec === null)
        {
            $aiomatic_result['msg'] = 'Failed to decode template json file: ' . $_FILES['file']['tmp_name'] . ' - ' . json_last_error_msg();
            wp_send_json($aiomatic_result);
        }
        if(isset($_POST['overwrite']))
        {
            $overwrite = $_POST['overwrite'];
        }
        else
        {
            $overwrite = '0';
        }
        foreach($fc_dec as $jsonf)
        {
            $address_post_id = 0;
            if(isset($jsonf['id']) && !empty($jsonf['id']))
            {
                $query = new WP_Query(
                    array(
                        'post_type'              => 'aiomatic_omni_temp',
                        'title'                  => $jsonf['name'],
                        'post_status'            => 'all',
                        'posts_per_page'         => 1,
                        'no_found_rows'          => true,
                        'ignore_sticky_posts'    => true,
                        'update_post_term_cache' => false,
                        'update_post_meta_cache' => false,
                        'orderby'                => 'post_date ID',
                        'order'                  => 'ASC',
                    )
                );
                if ( ! empty( $query->post ) ) 
                {
                    if($overwrite != '1')
                    {
                        aiomatic_log_to_file('Template existing, skipping: ' . $jsonf['name']);
                        //template already exists, skipping it
                        continue;
                    }
                    else
                    {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            $address_post_id = get_the_ID();
                            break;
                        }
                    }
                }
            }
            if(is_array($jsonf['json']))
            {
                $jsonf['json'] = json_encode($jsonf['json']);
            }
            $json_me = addslashes($jsonf['json']);
            if($json_me === false)
            {
                $json_me = $jsonf['json'];
            }
            $omni_data = array(
                'post_type' => 'aiomatic_omni_temp',
                'post_title' => $jsonf['name'],
                'post_content' => $json_me,
                'post_status' => 'publish'
            );
            $omni_data['ID'] = $address_post_id;
            remove_filter('content_save_pre', 'wp_filter_post_kses');
            remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
            if($overwrite != '1')
            {
                $omni_id_local = wp_insert_post($omni_data);
            }
            else
            {
                if(isset($omni_data['ID']) && $omni_data['ID'] != '0')
                {
                    $omni_id_local = wp_update_post($omni_data);
                }
                else
                {
                    $omni_id_local = wp_insert_post($omni_data);
                }
            }
            add_filter('content_save_pre', 'wp_filter_post_kses');
            add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
            if(is_wp_error($omni_id_local))
            {
                aiomatic_log_to_file('Failed to import OmniBlock Template: ' . $omni_id_local->get_error_message());
            }
            elseif($omni_id_local === 0)
            {
                aiomatic_log_to_file('Failed to insert OmniBlock Template to database: ' . print_r($omni_data, true));
            }
            else 
            {
                update_post_meta($omni_id_local, 'aiomatic_json', $json_me);
                if(isset($jsonf['category']) && !empty($jsonf['category']))
                {
                    if(!is_array($jsonf['category']))
                    {
                        $terms_array = explode(';', $jsonf['category']);
                    }
                    else
                    {
                        $terms_array = $jsonf['category'];
                    }
                    wp_set_object_terms($omni_id_local, $terms_array, 'ai_template_categories');
                }
            }
        }
        $aiomatic_result['status'] = 'success';
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_default_form', 'aiomatic_default_form');
function aiomatic_default_form()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with default forms');
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $default_file = dirname(__FILE__) . "/defaults/form-defaults.json";
    if(!$wp_filesystem->exists($default_file))
    {
        $aiomatic_result['msg'] = 'Default form json file not found: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc = $wp_filesystem->get_contents($default_file);
    if(empty($fc))
    {
        $aiomatic_result['msg'] = 'Failed to read file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc_dec = json_decode($fc, true);
    if($fc_dec === null)
    {
        $aiomatic_result['msg'] = 'Failed to decode json file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $overwrite = '0';
    foreach($fc_dec as $jsonf)
    {
        $address_post_id = 0;
        $query = new WP_Query(
            array(
                'post_type'              => 'aiomatic_forms',
                'title'                  => $jsonf['title'],
                'post_status'            => 'all',
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'orderby'                => 'post_date ID',
                'order'                  => 'ASC',
            )
        );
        
        if ( ! empty( $query->post ) ) {
            if($overwrite != '1')
            {
                //form already exists, skipping it
                continue;
            }
            else
            {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $address_post_id = get_the_ID();
                    break;
                }
            }
        }
        $forms_data = array(
            'post_type' => 'aiomatic_forms',
            'post_title' => $jsonf['title'],
            'post_content' => $jsonf['description'],
            'post_status' => 'publish'
        );
        $forms_data['ID'] = $address_post_id;
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        if($overwrite != '1')
        {
            $forms_id = wp_insert_post($forms_data);
        }
        else
        {
            if(isset($forms_data['ID']) && $forms_data['ID'] != '0')
            {
                $forms_id = wp_update_post($forms_data);
            }
            else
            {
                $forms_id = wp_insert_post($forms_data);
            }
        }
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($forms_id))
        {
            aiomatic_log_to_file('Failed to import form: ' . $forms_id->get_error_message());
        }
        elseif($forms_id === 0)
        {
            aiomatic_log_to_file('Failed to insert form to database: ' . print_r($forms_data, true));
        }
        else 
        {
            update_post_meta($forms_id, 'prompt', $jsonf['prompt']);
            update_post_meta($forms_id, 'model', $jsonf['model']);
            if(isset($jsonf['assistant_id']))
            {
                update_post_meta($forms_id, 'assistant_id', $jsonf['assistant_id']);
            }
            update_post_meta($forms_id, 'header', $jsonf['header']);
            if(!isset($jsonf['editor']))
            {
                $jsonf['editor'] = 'textarea';
            }
            update_post_meta($forms_id, 'editor', $jsonf['editor']);
            if(!isset($jsonf['advanced']))
            {
                $jsonf['advanced'] = 'hide';
            }
            update_post_meta($forms_id, 'advanced', $jsonf['advanced']);
            update_post_meta($forms_id, 'submit', $jsonf['submit']);
            update_post_meta($forms_id, 'max', $jsonf['max']);
            update_post_meta($forms_id, 'temperature', $jsonf['temperature']);
            update_post_meta($forms_id, 'topp', $jsonf['topp']);
            update_post_meta($forms_id, 'presence', $jsonf['presence']);
            update_post_meta($forms_id, 'frequency', $jsonf['frequency']);
            update_post_meta($forms_id, 'response', $jsonf['response']);
            if(isset($jsonf['streaming_enabled']))
            {
                update_post_meta($forms_id, 'streaming_enabled', $jsonf['streaming_enabled']);
            }
            else
            {
                update_post_meta($forms_id, 'streaming_enabled', '0');
            }
            update_post_meta($forms_id, 'type', $jsonf['type']);
            update_post_meta($forms_id, '_aiomaticfields', $jsonf['aiomaticfields']);
        }
    }
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_default_assistant', 'aiomatic_default_assistant');
function aiomatic_default_assistant()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with default assistants');
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
        $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
        wp_send_json($aiomatic_result);
    }
    else
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        if(empty($token))
        {
            $aiomatic_result['msg'] = 'Invalid API key submitted';
            wp_send_json($aiomatic_result);
        }
        if(aiomatic_is_aiomaticapi_key($token))
        {
            $aiomatic_result['msg'] = 'Currently only OpenAI API is supported for text moderation.';
            wp_send_json($aiomatic_result);
        }
    }
    $default_file = dirname(__FILE__) . "/defaults/assistant-defaults.json";
    if(!$wp_filesystem->exists($default_file))
    {
        $aiomatic_result['msg'] = 'Default assistant json file not found: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc = $wp_filesystem->get_contents($default_file);
    if(empty($fc))
    {
        $aiomatic_result['msg'] = 'Failed to read file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc_dec = json_decode($fc, true);
    if($fc_dec === false || $fc_dec === null)
    {
        $aiomatic_result['msg'] = 'Failed to decode json file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $overwrite = '0';
    require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
    foreach($fc_dec as $jsonf)
    {
        $vector_store_id = '';
        if(empty($jsonf['role']))
        {
            $jsonf['role'] = '';
        }
        if(empty($jsonf['prompt']))
        {
            $jsonf['prompt'] = '';
        }
        if(empty($jsonf['message']))
        {
            $jsonf['message'] = '';
        }
        $existing_openai = false;
        $address_post_id = 0;
        $assistant_id = '';
        $temperature = '';
        $topp = '';
        if(isset($jsonf['temperature']))
        {
            $temperature = $jsonf['temperature'];
        }
        if(isset($jsonf['topp']))
        {
            $topp = $jsonf['topp'];
        }
        if(isset($jsonf['id']) && !empty($jsonf['id']))
        {
            $query = new WP_Query(
                array(
                    'post_type'              => 'aiomatic_assistants',
                    'meta_query' => array(
                        array(
                            'key'     => '_assistant_id',
                            'value'   => $jsonf['id'],
                            'compare' => 'EXISTS'
                        ),
                    ),
                    'post_status'            => 'all',
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false,
                    'orderby'                => 'post_date ID',
                    'order'                  => 'ASC',
                )
            );
            if ( ! empty( $query->post ) ) 
            {
                if($overwrite != '1')
                {
                    //assistant already exists, skipping it
                    continue;
                }
                else
                {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $address_post_id = get_the_ID();
                        $assistant_id = get_post_meta($address_post_id, '_assistant_id', true);
                        break;
                    }
                }
            }
            if(!empty($assistant_id))
            {
                try
                {
                    $ex_assistant = aiomatic_openai_retrieve_assistant($token, $assistant_id);
                    if(isset($ex_assistant['id']) && $ex_assistant['id'] == $assistant_id)
                    {
                        $existing_openai = true;
                    }
                }
                catch(Exception $e)
                {
                    $aiomatic_result['msg'] = 'Failed to retrieve assistant using the API '  . $e->getMessage();
                    wp_send_json($aiomatic_result);
                }
            }
        }
        if($existing_openai == true)
        {
            $tools = [];
            if($jsonf['code_interpreter'] == 'on')
            {
                $tools[] = ['type' => 'code_interpreter'];
            }
            if($jsonf['file_search'] == 'on')
            {
                $tools[] = ['type' => 'file_search'];
            }
            $functions_json = $jsonf['functions'];
            if($functions_json === false)
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
            try
            {
                if($address_post_id != '' && $address_post_id != 0)
                {
                    $vector_store_id = get_post_meta($address_post_id, '_assistant_vector_store_id', true);
                }
                $metadata = '';
                $assistantData = aiomatic_openai_modify_assistant($token, $assistant_id, $jsonf['model'], $jsonf['name'], $jsonf['role'], $jsonf['prompt'], $temperature, $topp, $tools, $jsonf['files'], $metadata, $vector_store_id, $address_post_id);
                if($assistantData === false)
                {
                    $aiomatic_result['msg'] = 'Failed to update assistant using the API';
                    wp_send_json($aiomatic_result);
                }
            }
            catch(Exception $e)
            {
                $aiomatic_result['msg'] = 'Failed to retrieve assistant using the API '  . $e->getMessage();
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $tools = [];
            if($jsonf['code_interpreter'] == 'on')
            {
                $tools[] = ['type' => 'code_interpreter'];
            }
            if($jsonf['file_search'] == 'on')
            {
                $tools[] = ['type' => 'file_search'];
            }
            $functions_json = $jsonf['functions'];
            if($functions_json === false)
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
            try
            {
                $metadata = '';
                $assistantData = aiomatic_openai_save_assistant(
                    $token,
                    $jsonf['model'],
                    $jsonf['name'],
                    $jsonf['role'],
                    $temperature,
                    $topp,
                    $jsonf['prompt'],
                    $tools,
                    $jsonf['files'],
                    $metadata,
                    $vector_store_id
                );
                if($assistantData === false)
                {
                    $aiomatic_result['msg'] = 'Failed to save assistant using the API';
                    wp_send_json($aiomatic_result);
                }
                else
                {
                    $assistant_id = $assistantData['id'];
                }
            }
            catch(Exception $e)
            {
                $aiomatic_result['msg'] = 'Failed to retrieve assistant using the API '  . $e->getMessage();
                wp_send_json($aiomatic_result);
            }
        }
        $assistants_data = array(
            'post_type' => 'aiomatic_assistants',
            'post_title' => $jsonf['name'],
            'post_excerpt' => $jsonf['role'],
            'post_content' => $jsonf['prompt'],
            'post_status' => 'publish'
        );
        $assistants_data['ID'] = $address_post_id;
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        if($overwrite != '1')
        {
            $assistants_id_local = wp_insert_post($assistants_data);
        }
        else
        {
            if(isset($assistants_data['ID']) && $assistants_data['ID'] != '0')
            {
                $assistants_id_local = wp_update_post($assistants_data);
            }
            else
            {
                $assistants_id_local = wp_insert_post($assistants_data);
            }
        }
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($assistants_id_local))
        {
            aiomatic_log_to_file('Failed to import assistant: ' . $assistants_id_local->get_error_message());
        }
        elseif($assistants_id_local === 0)
        {
            aiomatic_log_to_file('Failed to insert assistant to database: ' . print_r($assistants_data, true));
        }
        else 
        {
            if(is_numeric($jsonf['avatar']))
            {
                if($jsonf['avatar'] > 0)
                {
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    set_post_thumbnail( $assistants_id_local, $jsonf['avatar'] );
                }
            }
            elseif(filter_var($jsonf['avatar'], FILTER_VALIDATE_URL))
            {
                if (!aiomatic_generate_featured_image($jsonf['avatar'], $assistants_id_local)) 
                {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
                    {
                        aiomatic_log_to_file('aiomatic_generate_featured_image failed for ' . $jsonf['avatar']);
                    }
                }
            }
            if(isset($jsonf['message']) && !empty($jsonf['message']))
            {
                update_post_meta($assistants_id_local, '_assistant_first_message', $jsonf['message']);
            }
            else
            {
                update_post_meta($assistants_id_local, '_assistant_first_message', '');
            }
            update_post_meta($assistants_id_local, '_assistant_id', $assistant_id);
            if(!empty($jsonf['model']))
            {
                update_post_meta($assistants_id_local, '_assistant_model', $jsonf['model']);
            }
            $tools = [];
            if($jsonf['code_interpreter'] == 'on')
            {
                $tools[] = ['type' => 'code_interpreter'];
            }
            if($jsonf['file_search'] == 'on')
            {
                $tools[] = ['type' => 'file_search'];
            }
            $functions_json = $jsonf['functions'];
            if($functions_json === false)
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
            if(!empty($tools))
            {
                update_post_meta($assistants_id_local, '_assistant_tools', $tools);
            }
            else
            {
                update_post_meta($assistants_id_local, '_assistant_tools', array());
            }
            if(!empty($vector_store_id))
            {
                update_post_meta($assistants_id_local, '_assistant_vector_store_id', $vector_store_id);
            }
            if(!empty($temperature))
            {
                update_post_meta($assistants_id_local, '_assistant_temperature', $temperature);
            }
            if(!empty($topp))
            {
                update_post_meta($assistants_id_local, '_assistant_topp', $topp);
            }
            if(!empty($jsonf['files']))
            {
                update_post_meta($assistants_id_local, '_assistant_files', $jsonf['files']);
            }
            else
            {
                update_post_meta($assistants_id_local, '_assistant_files', array());
            }
        }
    }
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_default_omni', 'aiomatic_default_omni');
function aiomatic_default_omni()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with default OmniBlock templates');
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $default_file = dirname(__FILE__) . "/defaults/omni-templates-defaults.json";
    if(!$wp_filesystem->exists($default_file))
    {
        $aiomatic_result['msg'] = 'Default OmniBlock templates json file not found: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc = $wp_filesystem->get_contents($default_file);
    if(empty($fc))
    {
        $aiomatic_result['msg'] = 'Failed to read file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc_dec = json_decode($fc, true);
    if($fc_dec === false || $fc_dec === null)
    {
        $aiomatic_result['msg'] = 'Failed to decode json file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $overwrite = '0';
    foreach($fc_dec as $jsonf)
    {
        $address_post_id = 0;
        if(isset($jsonf['id']) && !empty($jsonf['id']))
        {
            $query = new WP_Query(
                array(
                    'post_type'              => 'aiomatic_omni_temp',
                    'post_status'            => 'all',
                    'title'                  => $jsonf['name'],
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false,
                    'orderby'                => 'post_date ID',
                    'order'                  => 'ASC',
                )
            );
            if ( ! empty( $query->post ) ) 
            {
                if($overwrite != '1')
                {
                    //template already exists, skipping it
                    continue;
                }
                else
                {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $address_post_id = get_the_ID();
                        break;
                    }
                }
            }
        }
        if(is_array($jsonf['json']))
        {
            $jsonf['json'] = json_encode($jsonf['json']);
        }
        $json_me = addslashes($jsonf['json']);
        if($json_me === false)
        {
            $json_me = $jsonf['json'];
        }
        $omni_data = array(
            'post_type' => 'aiomatic_omni_temp',
            'post_title' => $jsonf['name'],
            'post_content' => $json_me,
            'post_status' => 'publish'
        );
        $omni_data['ID'] = $address_post_id;
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        if($overwrite != '1')
        {
            $omni_id_local = wp_insert_post($omni_data);
        }
        else
        {
            if(isset($omni_data['ID']) && $omni_data['ID'] != '0')
            {
                $omni_id_local = wp_update_post($omni_data);
            }
            else
            {
                $omni_id_local = wp_insert_post($omni_data);
            }
        }
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($omni_id_local))
        {
            aiomatic_log_to_file('Failed to import OmniBlock Template: ' . $omni_id_local->get_error_message());
        }
        elseif($omni_id_local === 0)
        {
            aiomatic_log_to_file('Failed to insert OmniBlock Template to database: ' . print_r($omni_data, true));
        }
        else 
        {
            update_post_meta($omni_id_local, 'aiomatic_json', $json_me);
            if(isset($jsonf['category']) && !empty($jsonf['category']))
            {
                if(!is_array($jsonf['category']))
                {
                    $terms_array = explode(';', $jsonf['category']);
                }
                else
                {
                    $terms_array = $jsonf['category'];
                }
                wp_set_object_terms($omni_id_local, $terms_array, 'ai_template_categories');
            }
        }
    }
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_default_persona', 'aiomatic_default_persona');
function aiomatic_default_persona()
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with default personas');
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $default_file = dirname(__FILE__) . "/defaults/persona-defaults.json";
    if(!$wp_filesystem->exists($default_file))
    {
        $aiomatic_result['msg'] = 'Default persona json file not found: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc = $wp_filesystem->get_contents($default_file);
    if(empty($fc))
    {
        $aiomatic_result['msg'] = 'Failed to read file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $fc_dec = json_decode($fc, true);
    if($fc_dec === false || $fc_dec === null)
    {
        $aiomatic_result['msg'] = 'Failed to decode json file: ' . $default_file;
        wp_send_json($aiomatic_result);
    }
    $overwrite = '0';
    foreach($fc_dec as $jsonf)
    {
        $address_post_id = 0;
        $query = new WP_Query(
            array(
                'post_type'              => 'aiomatic_personas',
                'title'                  => $jsonf['name'],
                'post_status'            => 'all',
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'orderby'                => 'post_date ID',
                'order'                  => 'ASC',
            )
        );
        
        if ( ! empty( $query->post ) ) {
            if($overwrite != '1')
            {
                //persona already exists, skipping it
                continue;
            }
            else
            {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $address_post_id = get_the_ID();
                    break;
                }
            }
        }
        $personas_data = array(
            'post_type' => 'aiomatic_personas',
            'post_title' => $jsonf['name'],
            'post_excerpt' => $jsonf['role'],
            'post_content' => $jsonf['prompt'],
            'post_status' => 'publish'
        );
        $personas_data['ID'] = $address_post_id;
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        if($overwrite != '1')
        {
            $personas_id = wp_insert_post($personas_data);
        }
        else
        {
            if(isset($personas_data['ID']) && $personas_data['ID'] != '0')
            {
                $personas_id = wp_update_post($personas_data);
            }
            else
            {
                $personas_id = wp_insert_post($personas_data);
            }
        }
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($personas_id))
        {
            aiomatic_log_to_file('Failed to import persona: ' . $personas_id->get_error_message());
        }
        elseif($personas_id === 0)
        {
            aiomatic_log_to_file('Failed to insert persona to database: ' . print_r($personas_data, true));
        }
        else 
        {
            if(isset($jsonf['avatar']))
            {
                if(is_numeric($jsonf['avatar']))
                {
                    if($jsonf['avatar'] > 0)
                    {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        require_once(ABSPATH . 'wp-admin/includes/media.php');
                        set_post_thumbnail( $personas_id, $jsonf['avatar'] );
                    }
                }
                elseif(filter_var($jsonf['avatar'], FILTER_VALIDATE_URL))
                {
                    if (!aiomatic_generate_featured_image($jsonf['avatar'], $personas_id)) 
                    {
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
                        {
                            aiomatic_log_to_file('aiomatic_generate_featured_image failed for ' . $jsonf['avatar']);
                        }
                    }
                }
            }
            if(isset($jsonf['message']) && !empty($jsonf['message']))
            {
                update_post_meta($personas_id, '_persona_first_message', $jsonf['message']);
            }
        }
    }
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_save_image', 'aiomatic_save_image');
function aiomatic_save_image() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
	$imagesrc = $_POST['imagesrc'];
    if(empty($imagesrc))
    {
        wp_send_json_error(array('error' => 'No image argument data found'));
    }
	$post_id = $_POST['post_id'];
    if(isset($_POST['orig_prompt']))
    {
	    $orig_prompt = $_POST['orig_prompt'];
    }
    else
    {
        $orig_prompt = 'image';
    }
    if(empty($post_id))
    {
        $post_id = null;
    }
    $size = 'full';
    $localpath = false;
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(substr( $imagesrc, 0, 21 ) === "data:image/png;base64")
    {
        $attachment_id = aiomatic_upload_base64_image($imagesrc, $orig_prompt, $post_id);
        if ( is_wp_error( $attachment_id ) ) {
            wp_send_json_error( $attachment_id );
        }
        if (  $attachment_id === false ) {
            wp_send_json_error(array('error' => 'Failed to upload image'));
        }
        $alt = wp_strip_all_tags( $orig_prompt, true );
        update_post_meta( $attachment_id, '_wp_attachment_image_alt', wp_slash( $alt ) );
        list( $url, $width, $height ) = wp_get_attachment_image_src( $attachment_id, $size );
        wp_send_json_success( compact( 'attachment_id', 'url', 'width', 'height', 'size' ) );
    }
    else
    {
        if ((isset($aiomatic_Main_Settings['ai_resize_height']) && $aiomatic_Main_Settings['ai_resize_height'] !== '') || (isset($aiomatic_Main_Settings['ai_resize_width']) && $aiomatic_Main_Settings['ai_resize_width'] !== ''))
        {
            try
            {
                if (isset($aiomatic_Main_Settings['copy_locally']) && ($aiomatic_Main_Settings['copy_locally'] == 'on' || $aiomatic_Main_Settings['copy_locally'] == 'amazon' || $aiomatic_Main_Settings['copy_locally'] == 'wasabi' || $aiomatic_Main_Settings['copy_locally'] == 'digital'))
                {
                    $localpath = aiomatic_copy_image_locally($imagesrc);
                    if(isset($localpath[1]) && $localpath !== false)
                    {
                        if(!class_exists('\Eventviva\ImageResize')){require_once (dirname(__FILE__) . "/res/ImageResize/ImageResize.php");}
                        $imageRes = new ImageResize($localpath[1]);
                        if (isset($aiomatic_Main_Settings['ai_resize_quality']) && $aiomatic_Main_Settings['ai_resize_quality'] !== '')
                        {
                            $imageRes->quality_jpg = intval($aiomatic_Main_Settings['ai_resize_quality']);
                        }
                        else
                        {
                            $imageRes->quality_jpg = 100;
                        }
                        if ((isset($aiomatic_Main_Settings['ai_resize_height']) && $aiomatic_Main_Settings['ai_resize_height'] !== '') && (isset($aiomatic_Main_Settings['ai_resize_width']) && $aiomatic_Main_Settings['ai_resize_width'] !== ''))
                        {
                            $imageRes->resizeToBestFit($aiomatic_Main_Settings['ai_resize_width'], $aiomatic_Main_Settings['ai_resize_height'], true);
                        }
                        elseif (isset($aiomatic_Main_Settings['ai_resize_width']) && $aiomatic_Main_Settings['ai_resize_width'] !== '')
                        {
                            $imageRes->resizeToWidth($aiomatic_Main_Settings['ai_resize_width'], true);
                        }
                        elseif (isset($aiomatic_Main_Settings['ai_resize_height']) && $aiomatic_Main_Settings['ai_resize_height'] !== '')
                        {
                            $imageRes->resizeToHeight($aiomatic_Main_Settings['ai_resize_height'], true);
                        }
                        $imageRes->save($localpath[1]);
                    }
                }
            }
            catch(Exception $e)
            {
                aiomatic_log_to_file('Failed to resize AI generated image: ' . $localpath[0] . ' to sizes ' . $aiomatic_Main_Settings['ai_resize_width'] . ' - ' . $aiomatic_Main_Settings['ai_resize_height'] . '. Exception thrown ' . esc_html($e->getMessage()) . '!');
            }
        }
        if(isset($localpath[0]))
        {
            $imagesrc = $localpath[0];
        }
        $file_name_is = aiomatic_extract_keywords_from_prompt($orig_prompt);
        $attachment_id = aiomatic_media_sideload_image( $imagesrc, $post_id, $orig_prompt, 'id', $file_name_is );
        if ( is_wp_error( $attachment_id ) ) {
            wp_send_json_error( $attachment_id );
        }
        $alt = wp_strip_all_tags( $orig_prompt, true );
        update_post_meta( $attachment_id, '_wp_attachment_image_alt', wp_slash( $alt ) );
        list( $url, $width, $height ) = wp_get_attachment_image_src( $attachment_id, $size );
        wp_send_json_success( compact( 'attachment_id', 'url', 'width', 'height', 'size' ) );
    }
    die();
}

add_action('wp_ajax_aiomatic_generate_image_ajax', 'aiomatic_generate_image_ajax');
function aiomatic_generate_image_ajax() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with image generator');
    if(!isset($_POST['image_size']) || !isset($_POST['instruction']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for AI generated images';
        wp_send_json($aiomatic_result);
    }
    $ai_model = $_POST['ai_model'];
    if($ai_model == 'stable')
    {
        if(!isset($_POST['image_size']) || !isset($_POST['instruction']))
        {
            $aiomatic_result['msg'] = 'Incomplete POST request for stable images';
            wp_send_json($aiomatic_result);
        }
        $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
        if(!empty($user_token_cap_per_day))
        {
            $user_token_cap_per_day = intval($user_token_cap_per_day);
        }
        $user_id = sanitize_text_field($_POST['user_id']);
        $image_size = $_POST['image_size'];
        $image_size = str_replace('??', 'x', $image_size);
        $instruction = stripslashes($_POST['instruction']);
        $sizes = array('1024x1024', '512x512');
        if(!in_array($image_size, $sizes))
        {
            $aiomatic_result['msg'] = 'Incorrect Stable Diffusion image size provided: ' . $image_size;
            wp_send_json($aiomatic_result);
        }
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['stability_app_id']) || trim($aiomatic_Main_Settings['stability_app_id']) == '') 
        {
            $aiomatic_result['msg'] = 'You need to insert a valid Stability.AI API Key for this to work!';
            wp_send_json($aiomatic_result);
        }
        $used_token_count = 0;
        if(is_numeric($user_token_cap_per_day))
        {
            if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
            {
                $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
                wp_send_json($aiomatic_result);
            }
            $used_token_count = get_user_meta($user_id, 'aiomatic_used_stable_image_tokens', true);
            if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
            {
                $used_token_count = intval($used_token_count);
                if($used_token_count > $user_token_cap_per_day)
                {
                    $aiomatic_result['msg'] = 'Daily token count usage for your user account was exceeded! Please try again tomorrow.';
                    wp_send_json($aiomatic_result);
                }
            }
            else
            {
                $used_token_count = 0;
            }
        }
        if($image_size == '512x512')
        {
            $width = '512';
            $height = '512';
        }
        elseif($image_size == '1024x1024')
        {
            $width = '1024';
            $height = '1024';
        }
        else
        {
            $width = '512';
            $height = '512';
        }
        $ierror = '';
        $temp_get_imgs = aiomatic_generate_stability_image($instruction, $height, $width, 'mediaLibraryStableImage', 0, true, $ierror, false, false);
        if($temp_get_imgs !== false)
        {
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_stable_image_tokens', $used_token_count);
            }
            $aiomatic_result['data'] = $temp_get_imgs;
            $aiomatic_result['status'] = 'success';
            wp_send_json($aiomatic_result);
        }
        $aiomatic_result['msg'] = 'Error occurred when calling image API: ' . $ierror;
        wp_send_json($aiomatic_result);
    }
    elseif($ai_model == 'midjourney')
    {
        if(!isset($_POST['image_size']) || !isset($_POST['instruction']))
        {
            $aiomatic_result['msg'] = 'Incomplete POST request for midjourney images';
            wp_send_json($aiomatic_result);
        }
        $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
        if(!empty($user_token_cap_per_day))
        {
            $user_token_cap_per_day = intval($user_token_cap_per_day);
        }
        $user_id = sanitize_text_field($_POST['user_id']);
        $image_size = $_POST['image_size'];
        $image_size = str_replace('??', 'x', $image_size);
        $instruction = stripslashes($_POST['instruction']);
        $sizes = array('1024x1024', '512x512', '1024x1792', '1792x1024');
        if(!in_array($image_size, $sizes))
        {
            $aiomatic_result['msg'] = 'Incorrect Midjourney image size provided: ' . $image_size;
            wp_send_json($aiomatic_result);
        }
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['midjourney_app_id']) || trim($aiomatic_Main_Settings['midjourney_app_id']) == '') 
        {
            $aiomatic_result['msg'] = 'You need to insert a valid GoAPI (midjourney) API Key for this to work!';
            wp_send_json($aiomatic_result);
        }
        $used_token_count = 0;
        if(is_numeric($user_token_cap_per_day))
        {
            if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
            {
                $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
                wp_send_json($aiomatic_result);
            }
            $used_token_count = get_user_meta($user_id, 'aiomatic_used_midjourney_image_tokens', true);
            if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
            {
                $used_token_count = intval($used_token_count);
                if($used_token_count > $user_token_cap_per_day)
                {
                    $aiomatic_result['msg'] = 'Daily token count usage for your user account was exceeded! Please try again tomorrow.';
                    wp_send_json($aiomatic_result);
                }
            }
            else
            {
                $used_token_count = 0;
            }
        }
        if($image_size == '512x512')
        {
            $width = '512';
            $height = '512';
        }
        elseif($image_size == '1024x1024')
        {
            $width = '1024';
            $height = '1024';
        }
        else
        {
            $width = '512';
            $height = '512';
        }
        $ierror = '';
        $temp_get_imgs = aiomatic_generate_ai_image_midjourney($instruction, $width, $height, 'mediaLibraryMidjourneyImage', true, $ierror);
        if($temp_get_imgs !== false)
        {
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_midjourney_image_tokens', $used_token_count);
            }
            $aiomatic_result['data'] = $temp_get_imgs;
            $aiomatic_result['status'] = 'success';
            wp_send_json($aiomatic_result);
        }
        $aiomatic_result['msg'] = 'Error occurred when calling image API: ' . $ierror;
        wp_send_json($aiomatic_result);
    }
    else
    {
        $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
        if(!empty($user_token_cap_per_day))
        {
            $user_token_cap_per_day = intval($user_token_cap_per_day);
        }
        $user_id = sanitize_text_field($_POST['user_id']);
        $image_size = $_POST['image_size'];
        $image_size = str_replace('??', 'x', $image_size);
        $instruction = stripslashes($_POST['instruction']);
        if($ai_model == 'dalle2')
        {
            $sizes = array('1024x1024', '512x512', '256x256');
        }
        else
        {
            $sizes = array('1024x1024', '1792x1024', '1024x1792');
        }
        if(!in_array($image_size, $sizes))
        {
            $aiomatic_result['msg'] = 'Invalid image size provided: ' . $image_size;
            wp_send_json($aiomatic_result);
        }
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
        {
            $aiomatic_result['msg'] = 'You need to insert a valid OpenAI/AiomaticAPI API Key for this to work!';
            wp_send_json($aiomatic_result);
        }
        $used_token_count = 0;
        if(is_numeric($user_token_cap_per_day))
        {
            if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
            {
                $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
                wp_send_json($aiomatic_result);
            }
            $used_token_count = get_user_meta($user_id, 'aiomatic_used_image_tokens', true);
            if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
            {
                $used_token_count = intval($used_token_count);
                if($used_token_count > $user_token_cap_per_day)
                {
                    $aiomatic_result['msg'] = 'The daily token count usage for your user account was exceeded! Please try again tomorrow.';
                    wp_send_json($aiomatic_result);
                }
            }
            else
            {
                $used_token_count = 0;
            }
        }
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        $aierror = '';
        $response_text = aiomatic_generate_ai_image($token, 1, $instruction, $image_size, 'mediaLibraryDallEImage', true, 0, $aierror, $ai_model);
        if($response_text !== false && is_array($response_text))
        {
            foreach($response_text as $tmpimg)
            {
                $aiomatic_result['data'] = $tmpimg;
                $aiomatic_result['status'] = 'success';
                do_action('aiomatic_ai_image_reply', $tmpimg);
                wp_send_json($aiomatic_result);
            }
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_image_tokens', $used_token_count);
            }
        }
        $aiomatic_result['msg'] = 'Error occurred when calling image API: ' . $aierror . ' -- ' . print_r($response_text, true);
        wp_send_json($aiomatic_result);
    }
    die();
}

add_action('wp_ajax_aiomatic_generate_royalty_free_image_ajax', 'aiomatic_generate_royalty_free_image_ajax');
function aiomatic_generate_royalty_free_image_ajax() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with image generator');
    if(!isset($_POST['instruction']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for royalty free images';
        wp_send_json($aiomatic_result);
    }
    $instruction = stripslashes(trim($_POST['instruction']));
    $image_source = $_POST['image_source'];
    $img_attr = '';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $raw_img_list = array();
    $full_result_list = array();
    $z_img = aiomatic_get_free_image($aiomatic_Main_Settings, $instruction, $img_attr, 10, true, $raw_img_list, array($image_source), $full_result_list);
    if(!empty($z_img))
    {
        $aiomatic_result['data'] = $full_result_list;
        $aiomatic_result['status'] = 'success';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['msg'] = 'No images returned for: ' . esc_html($instruction) . ', from: ' . esc_html($image_source);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_image_ajax_submit', 'aiomatic_image_submit');
add_action('wp_ajax_nopriv_aiomatic_image_ajax_submit', 'aiomatic_image_submit');
function aiomatic_image_submit() 
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with image submission');
    if(!isset($_POST['image_size']) || !isset($_POST['instruction']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for DALLE images';
        wp_send_json($aiomatic_result);
    }
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
	$user_id = sanitize_text_field($_POST['user_id']);
	$image_size = $_POST['image_size'];
    $image_size = str_replace('??', 'x', $image_size);
	$instruction = stripslashes($_POST['instruction']);
    if(isset($_POST['image_model']))
    {
	    $image_model = stripslashes($_POST['image_model']);
        if(!in_array($image_model, AIOMATIC_DALLE_IMAGE_MODELS))
        {
            $image_model = 'dalle2';
        }
    }
    else
    {
        $image_model = 'dalle2';
    }
    if($image_model == 'dalle2')
    {
        $sizes = array('1024x1024', '512x512', '256x256');
        if(!in_array($image_size, $sizes))
        {
            $aiomatic_result['msg'] = 'Invalid Dall-E 2 image size provided: ' . $image_size;
            wp_send_json($aiomatic_result);
        }
    }
    else
    {
        $sizes = array('1024x1024', '1792x1024', '1024x1792');
        if(!in_array($image_size, $sizes))
        {
            $aiomatic_result['msg'] = 'Invalid Dall-E 3 image size provided: ' . $image_size;
            wp_send_json($aiomatic_result);
        }
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = 'You need to insert a valid OpenAI/AiomaticAPI API Key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_image_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = 'The daily token count for your user account has been exceeded! Please try again tomorrow.';
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
	$aierror = '';
    $response_text = aiomatic_generate_ai_image($token, 1, $instruction, $image_size, 'shortcodeImageForm', false, 0, $aierror, $image_model);
    if($response_text !== false && is_array($response_text))
    {
        foreach($response_text as $tmpimg)
        {
            $aiomatic_result['data'] = $tmpimg;
            $aiomatic_result['status'] = 'success';
            do_action('aiomatic_ai_form_image_reply', $tmpimg);
            wp_send_json($aiomatic_result);
        }
        if(is_numeric($user_token_cap_per_day))
        {
            $used_token_count = intval($used_token_count) + 1000;
            update_user_meta($user_id, 'aiomatic_used_image_tokens', $used_token_count);
        }
    }
    $aiomatic_result['msg'] = 'Error occurred when calling image API: ' . $aierror . ' -- ' . print_r($response_text, true);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_run_my_bulk_embeddings_action', 'aiomatic_run_my_bulk_embeddings_action');
function aiomatic_run_my_bulk_embeddings_action()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['rule_timeout']) && $aiomatic_Main_Settings['rule_timeout'] != '') {
        $timeout = intval($aiomatic_Main_Settings['rule_timeout']);
    } else {
        $timeout = 36000;
    }
    ini_set('memory_limit', '-1');
    ini_set('default_socket_timeout', $timeout);
    ini_set('safe_mode', 'Off');
    ini_set('max_execution_time', $timeout);
    ini_set('ignore_user_abort', 1);
    ini_set('user_agent', aiomatic_get_random_user_agent());
    if(function_exists('ignore_user_abort'))
    {
        ignore_user_abort(true);
    }
    if(function_exists('set_time_limit'))
    {
        set_time_limit($timeout);
    }
    if (isset($aiomatic_Main_Settings['enable_detailed_logging']) && $aiomatic_Main_Settings['enable_detailed_logging'] == 'on') 
    {
        aiomatic_log_exec_time('Bulk Embeddings');
    }
    if (isset($aiomatic_Main_Settings['aiomatic_enabled']) && $aiomatic_Main_Settings['aiomatic_enabled'] == 'on') {
        $query     = array(
        );
        if (isset($_POST['author_id']) && $_POST['author_id'] != '') {
            $query['author'] = $_POST['author_id'];
        }
        if (isset($_POST['author_name']) && $_POST['author_name'] != '') {
            $query['author_name'] = $_POST['author_name'];
        }
        if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
            $query['category_name'] = $_POST['category_name'];
        }
        if (isset($_POST['tag_name']) && $_POST['tag_name'] != '') {
            $query['tag'] = $_POST['tag_name'];
        }
        if (isset($_POST['post_id']) && $_POST['post_id'] != '') {
            $postids = $_POST['post_id'];
            $postids = explode(',', $postids);
            $postids = array_map('trim', $postids);
            $query['post__in'] = $postids;
        }
        if (isset($_POST['post_name']) && $_POST['post_name'] != '') {
            $query['name'] = $_POST['post_name'];
        }
        if (isset($_POST['pagename']) && $_POST['pagename'] != '') {
            $query['pagename'] = $_POST['pagename'];
        }
        if (isset($_POST['year']) && $_POST['year'] != '') {
            $query['year'] = $_POST['year'];
        }
        if (isset($_POST['month']) && $_POST['month'] != '') {
            $query['monthnum'] = $_POST['month'];
        }
        if (isset($_POST['day']) && $_POST['day'] != '') {
            $query['day'] = $_POST['day'];
        }
        if (isset($_POST['post_parent']) && $_POST['post_parent'] != '') {
            $query['post_parent'] = $_POST['post_parent'];
        }
        if (isset($_POST['page_id']) && $_POST['page_id'] != '') {
            $query['page_id'] = $_POST['page_id'];
        }
        if (isset($_POST['max_nr']) && $_POST['max_nr'] != '') {
            $max_nr = intval($_POST['max_nr']);
        }
        else
        {
            $max_nr = 0;
        }
        if (isset($_POST['max_posts']) && $_POST['max_posts'] != '') 
        {
            if(intval($_POST['max_posts']) != -1 && $max_nr > intval($_POST['max_posts']))
            {
                $query['posts_per_page'] = $max_nr;
            }
            else
            {
                $query['posts_per_page'] = $_POST['max_posts'];
            }
        }
        else
        {
            if($max_nr > 5)
            {
                $query['posts_per_page'] = $max_nr;
            }
        }
        if (isset($_POST['search_offset']) && $_POST['search_offset'] != '') {
            $query['offset'] = $_POST['search_offset'];
        }
        if (isset($_POST['search_query']) && $_POST['search_query'] != '') {
            $query['s'] = $_POST['search_query'];
        }
        if (isset($_POST['meta_name']) && $_POST['meta_name'] != '') {
            $query['meta_key'] = $_POST['meta_name'];
        }
        if (isset($_POST['meta_value']) && $_POST['meta_value'] != '') {
            $query['meta_value'] = $_POST['meta_value'];
        }
        if (isset($_POST['order']) && $_POST['order'] != 'default') {
            $query['order'] = $_POST['order'];
        }
        if (isset($_POST['orderby']) && $_POST['orderby'] != 'default') {
            $query['orderby'] = $_POST['orderby'];
        }
        if (isset($_POST['featured_image']) && $_POST['featured_image'] != 'any') {
            if($_POST['featured_image'] == 'with')
            {
                $query['meta_query'] = array(
                    array(
                      'key' => '_thumbnail_id',
                      'compare' => 'EXISTS'
                    )
                );
            }
            elseif($_POST['featured_image'] == 'without')
            {
                $query['meta_query'] = array(
                    array(
                      'key' => '_thumbnail_id',
                      'value' => '?',
                      'compare' => 'NOT EXISTS'
                    )
                );
            }
        }
        $custom_name = 'aiomatic_indexed';
        if (isset($_POST['no_twice']) && $_POST['no_twice'] == 'on') 
        {
        }
        else
        {
            if(isset($query['meta_query']))
            {
                $query['meta_query'][] = array(
                    'key' => $custom_name,
                    'value' => '?',
                    'compare' => 'NOT EXISTS'
                );
            }
            else
            {
                $query['meta_query'] = array(
                    array(
                      'key' => $custom_name,
                      'value' => '?',
                      'compare' => 'NOT EXISTS'
                    )
                );
            }
        }
        if (isset($_POST['post_status']) && $_POST['post_status'] != '') {
            $query['post_status'] = array_map('trim', explode(',', $_POST['post_status']));
        }
        else
        {
            $query['post_status'] = 'any';
        }
        if (isset($_POST['type_post']) && $_POST['type_post'] != '') {
            $query['post_type'] = array_map('trim', explode(',', $_POST['type_post']));
        }
        else
        {
            $query['post_type'] = 'post';
        }
        $processed = 0;
        $post_list = get_posts($query);
        if(count($post_list) > 0)
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['embedding_template']) && trim($aiomatic_Main_Settings['embedding_template']) != '')
            {
                if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
                {
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    require_once(dirname(__FILE__) . "/res/Embeddings.php");
                    $embdedding = new Aiomatic_Embeddings($token);
                    foreach ($post_list as $tpost) 
                    {
                        if($max_nr > 0 && $processed == $max_nr)
                        {
                            break;
                        }
                        $processed++;
                        $post_url = get_permalink($tpost->ID);
                        $post_title = $tpost->post_title;
                        $post_excerpt = $tpost->post_excerpt;
                        $post_id = $tpost->ID;
                        $post_content = $tpost->post_content;
                        if (strstr($aiomatic_Main_Settings['embedding_template'], '%%post_content%%') !== false && isset($aiomatic_Main_Settings['rewrite_embedding']) && trim($aiomatic_Main_Settings['rewrite_embedding']) == 'on' && isset($aiomatic_Main_Settings['embedding_rw_prompt']) && trim($aiomatic_Main_Settings['embedding_rw_prompt']) != '')
                        {
                            $embedding_rw_prompt = trim($aiomatic_Main_Settings['embedding_rw_prompt']);
                            $embedding_rw_prompt = str_replace('%%post_url%%', $post_url, $embedding_rw_prompt);
                            $embedding_rw_prompt = str_replace('%%post_title%%', $post_title, $embedding_rw_prompt);
                            $embedding_rw_prompt = str_replace('%%post_excerpt%%', $post_excerpt, $embedding_rw_prompt);
                            $embedding_rw_prompt = str_replace('%%post_content%%', strip_shortcodes($post_content), $embedding_rw_prompt);
                            $embedding_rw_prompt = str_replace('%%post_id%%', $post_id, $embedding_rw_prompt);
                            if($embedding_rw_prompt != '')
                            {
                                if(isset($aiomatic_Main_Settings['embedding_rw_model']) && trim($aiomatic_Main_Settings['embedding_rw_model']) != '')
                                {
                                    $rw_model = trim($aiomatic_Main_Settings['embedding_rw_model']);
                                }
                                else
                                {
                                    $rw_model = get_default_model_name($aiomatic_Main_Settings);
                                }
                                $all_models = aiomatic_get_all_models(true);
                                if(!in_array($rw_model, $all_models))
                                {
                                    $rw_model = get_default_model_name($aiomatic_Main_Settings);
                                }
                                $query_token_count = count(aiomatic_encode($embedding_rw_prompt));
                                $max_tokens = aiomatic_get_max_tokens($rw_model);
                                $available_tokens = aiomatic_compute_available_tokens($rw_model, $max_tokens, $embedding_rw_prompt, $query_token_count);
                                if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
                                {
                                    $string_len = strlen($embedding_rw_prompt);
                                    $string_len = $string_len / 2;
                                    $string_len = intval(0 - $string_len);
                                    $embedding_rw_prompt = aiomatic_substr($embedding_rw_prompt, 0, $string_len);
                                    $embedding_rw_prompt = trim($embedding_rw_prompt);
                                    $query_token_count = count(aiomatic_encode($embedding_rw_prompt));
                                    $available_tokens = $max_tokens - $query_token_count;
                                }
                                if(!empty($embedding_rw_prompt))
                                {
                                    $thread_id = '';
                                    $aierror = '';
                                    $finish_reason = '';
                                    $generated_text = aiomatic_generate_text($token, $rw_model, $embedding_rw_prompt, $available_tokens, 1, 1, 0, 0, false, 'embeddingsOptimizer', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', '', $thread_id, '', 'disabled', '', false);
                                    if($generated_text === false)
                                    {
                                        aiomatic_log_to_file('Failed to optimize post content for embeddings: ' . print_r($embedding_rw_prompt, true));
                                    }
                                    else
                                    {
                                        $post_content = aiomatic_sanitize_ai_result($generated_text);
                                    }
                                }
                            }
                        }
                        $emb_template = trim($aiomatic_Main_Settings['embedding_template']);
                        $emb_template = str_replace('%%post_url%%', $post_url, $emb_template);
                        $emb_template = str_replace('%%post_title%%', $post_title, $emb_template);
                        $emb_template = str_replace('%%post_excerpt%%', $post_excerpt, $emb_template);
                        $emb_template = str_replace('%%post_content%%', strip_shortcodes($post_content), $emb_template);
                        $emb_template = str_replace('%%post_id%%', $post_id, $emb_template);
                        if($emb_template != '')
                        {
                            $embid = get_post_meta($post_id, $custom_name, true);
                            if(!empty($embid))
                            {
                                $my_emb = get_post($embid);
                            }
                            else
                            {
                                $my_emb = null;
                            }
                            if(!empty($embid) && $my_emb != null)
                            {
                                $my_emb->post_content = $emb_template;
                                wp_update_post($my_emb);
                            }
                            else
                            {
                                $rez = $embdedding->aiomatic_create_single_embedding_nojson($emb_template);
                                if($rez['status'] == 'error')
                                {
                                    aiomatic_log_to_file('Failed to save embedding for post id: ' . $post_id . ' error: ' . print_r($rez, true));
                                }
                                else
                                {
                                    update_post_meta($tpost->ID, $custom_name, $rez['id']);
                                }
                            }
                        }
                    }
                }
                else
                {
                    aiomatic_log_to_file('You need to set up an OpenAI API key in the Aiomatic plugin\' settings, for this to work!');
                    echo 'fail';
                }
            }
            else
            {
                aiomatic_log_to_file('No embedding template set in plugin settings!');
                echo 'fail';
            }
        }
    }
    if($processed == 0)
    {
        echo 'nochange';
    }
    else
    {
        echo 'ok';
    }
    die();
}
add_action('wp_ajax_aiomatic_run_my_bulk_action', 'aiomatic_run_my_bulk_action');
function aiomatic_run_my_bulk_action()
{
    check_ajax_referer('openai-bulk-nonce', 'nonce');
    echo aiomatic_do_bulk_post();
    die();
}
add_action('wp_ajax_aiomatic_run_my_bulk_action_test', 'aiomatic_run_my_bulk_action_test');
function aiomatic_run_my_bulk_action_test()
{
    check_ajax_referer('openai-bulk-nonce', 'nonce');
    echo aiomatic_do_bulk_post_test();
    die();
}
add_action('wp_ajax_aiomatic_preview_form', 'aiomatic_preview_form');
function aiomatic_preview_form()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['id']) || !isset($_POST['id']))
    {
        die();
    }
    echo do_shortcode('[aiomatic-form id="' . esc_html(trim($_POST['id'])) . '"]');
    die();
}
add_action('wp_ajax_aiomatic_stable_image_ajax_submit', 'aiomatic_stable_image_submit');
add_action('wp_ajax_nopriv_aiomatic_stable_image_ajax_submit', 'aiomatic_stable_image_submit');
function aiomatic_stable_image_submit() 
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with Stable Difussion');
    if(!isset($_POST['image_size']) || !isset($_POST['instruction']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for stable images';
        wp_send_json($aiomatic_result);
    }
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
	$user_id = sanitize_text_field($_POST['user_id']);
	$image_size = $_POST['image_size'];
    $image_size = str_replace('??', 'x', $image_size);
	$instruction = stripslashes($_POST['instruction']);
    $sizes = array('1024x1024', '512x512');
    if(!in_array($image_size, $sizes))
    {
        $aiomatic_result['msg'] = 'Invalid Stable Diffusion image size provided: ' . $image_size;
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['stability_app_id']) || trim($aiomatic_Main_Settings['stability_app_id']) == '') 
    {
        $aiomatic_result['msg'] = 'You need to insert a valid Stability.AI API Key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_stable_image_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = 'The daily token count for your user account has been exceeded! Please try again tomorrow.';
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
    if($image_size == '512x512')
    {
        $width = '512';
        $height = '512';
    }
    elseif($image_size == '1024x1024')
    {
        $width = '1024';
        $height = '1024';
    }
    else
    {
        $width = '512';
        $height = '512';
    }
    $ierror = '';
    $temp_get_imgs = aiomatic_generate_stability_image($instruction, $height, $width, 'shortcodeChatStableImage', 0, true, $ierror, false, false);
    if($temp_get_imgs !== false)
    {
        if(is_numeric($user_token_cap_per_day))
        {
            $used_token_count = intval($used_token_count) + 1000;
            update_user_meta($user_id, 'aiomatic_used_stable_image_tokens', $used_token_count);
        }
        $aiomatic_result['data'] = $temp_get_imgs;
        $aiomatic_result['status'] = 'success';
        do_action('aiomatic_stable_image_reply', $temp_get_imgs);
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['msg'] = 'Error occurred when calling image API: ' . $ierror;
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_midjourney_image_ajax_submit', 'aiomatic_midjourney_image_submit');
add_action('wp_ajax_nopriv_aiomatic_midjourney_image_ajax_submit', 'aiomatic_midjourney_image_submit');
function aiomatic_midjourney_image_submit() 
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with Midjourney');
    if(!isset($_POST['image_size']) || !isset($_POST['instruction']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for midjourney images';
        wp_send_json($aiomatic_result);
    }
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
	$user_id = sanitize_text_field($_POST['user_id']);
	$image_size = $_POST['image_size'];
    $image_size = str_replace('??', 'x', $image_size);
	$instruction = stripslashes($_POST['instruction']);
    $sizes = array('1024x1024', '512x512', '1024x1792', '1792x1024');
    if(!in_array($image_size, $sizes))
    {
        $aiomatic_result['msg'] = 'Invalid Midjourney image size provided: ' . $image_size;
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['midjourney_app_id']) || trim($aiomatic_Main_Settings['midjourney_app_id']) == '') 
    {
        $aiomatic_result['msg'] = 'You need to insert a valid GoAPI (Midjourney) API Key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_midjourney_image_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = 'The daily token count for your user account has been exceeded! Please try again tomorrow.';
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
    if($image_size == '512x512')
    {
        $width = '512';
        $height = '512';
    }
    elseif($image_size == '1024x1024')
    {
        $width = '1024';
        $height = '1024';
    }
    else
    {
        $width = '512';
        $height = '512';
    }
    $ierror = '';
    $temp_get_imgs = aiomatic_generate_ai_image_midjourney($instruction, $width, $height, 'shortcodeChatMidjourneyImage', true, $ierror);
    if($temp_get_imgs !== false)
    {
        if(is_numeric($user_token_cap_per_day))
        {
            $used_token_count = intval($used_token_count) + 1000;
            update_user_meta($user_id, 'aiomatic_used_midjourney_image_tokens', $used_token_count);
        }
        $aiomatic_result['data'] = $temp_get_imgs;
        $aiomatic_result['status'] = 'success';
        do_action('aiomatic_midjourney_image_reply', $temp_get_imgs);
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['msg'] = 'Error occurred when calling image API: ' . $ierror;
    wp_send_json($aiomatic_result);
    die();
}

add_action( 'wp_ajax_aiomatic_get_image', 'aiomatic_get_image' );
add_action( 'wp_ajax_nopriv_aiomatic_get_image', 'aiomatic_get_image' );
function aiomatic_get_image() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
    if(isset($_GET['id']) ){
        if(empty($_GET['id']))
        {
            $data = array(
                'image'    => '<img id="aiomatic-preview-image">',
            );
            wp_send_json_success( $data );
        }
        $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'thumbnail', false, array( 'id' => 'aiomatic-preview-image' ) );
        $data = array(
            'image'    => $image,
        );
        wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
    die();
}
add_action( 'wp_ajax_create_post', 'aiomatic_create_post' );
function aiomatic_create_post() {
	check_ajax_referer( 'create_post', 'nonce' );
    if(isset($_POST['metaFieldsArray']))
    {
        $metaFieldsArray = $_POST['metaFieldsArray'];
    }
    else
    {
        $metaFieldsArray = array();
    }
	$post_title = stripslashes($_POST['title']);
	$post_content = stripslashes($_POST['content']);
	$post_excerpt = stripslashes($_POST['excerpt']);
	$submit_status = sanitize_text_field( stripslashes($_POST['submit_status']) );
	$submit_type = isset($_POST['submit_type']) ? sanitize_text_field( stripslashes($_POST['submit_type']) ) : 'post';
	$post_sticky = sanitize_text_field( $_POST['post_sticky'] );
	$post_author = stripslashes($_POST['post_author']);
	$aiomatic_image_id = stripslashes( $_POST['aiomatic_image_id'] );
	$post_date = stripslashes($_POST['post_date']);
	$post_tags = stripslashes( $_POST['post_tags'] );
	$post_category = stripslashes(sanitize_text_field( stripslashes($_POST['post_category']) ));
	$post_category = json_decode($post_category, true);
	if ( empty( $post_title ) || empty( $post_content ) ) {
	  wp_send_json_error( array( 'message' => 'Title and Content are required fields' ) );
	}
    if(empty($submit_type))
    {
        $submit_type = 'post';
    }
    if(!in_array($submit_type, get_post_types( '', 'names' )))
    {
        $submit_type = 'post';
    }
	$statuses = get_post_statuses();
	$statuses['trash'] = 'Trash';
	if(!array_key_exists($submit_status, $statuses))
	{
		wp_send_json_error( array( 'message' => 'Invalid post status submitted: ' . $submit_status . ' - ' .print_r($statuses, true) ) );
	}
	$author_obj = get_user_by('id', $post_author);
	if($author_obj === false)
	{
		wp_send_json_error( array( 'message' => 'Invalid post author submitted' ) );
	}
	$post_args = array(
		'post_title' => $post_title,
		'post_content' => $post_content,
		'post_excerpt' => $post_excerpt,
		'post_status' => $submit_status,
		'post_type' => $submit_type,
		'post_author' => $post_author,
		'post_date' => $post_date
	);
    if(!empty($post_tags))
	{
		$post_args['tags_input'] = $post_tags;
	}
    if(!empty($metaFieldsArray))
	{
		$post_args['meta_input'] = $metaFieldsArray;
	}
    remove_filter('content_save_pre', 'wp_filter_post_kses');
    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
	$post_id = wp_insert_post( $post_args );
    add_filter('content_save_pre', 'wp_filter_post_kses');
    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
	if ( is_wp_error( $post_id ) ) {
	  wp_send_json_error( array( 'message' => $post_id->get_error_message() ) );
	}
    elseif ( $post_id === 0 ) {
        wp_send_json_error( array( 'message' => 'Failed to insert post: ' . $post_title ) );
    }
	if ($post_sticky == 'on') 
	{
		stick_post($post_id);
	}
	if(is_array($post_category))
	{
		$default_category = get_option('default_category');
		wp_set_post_categories($post_id, $post_category, true);
		if(is_numeric($default_category))
		{
			if(!in_array($default_category, $post_category))
			{
				$deftrerm = get_term_by('id', $default_category, 'category');
				if($deftrerm !== false)
				{
					wp_remove_object_terms( $post_id, $deftrerm->slug, 'category' );
				}
			}
		}
	}
	if($aiomatic_image_id != '' && is_numeric($aiomatic_image_id))
	{
		$aiomatic_image_id = intval($aiomatic_image_id);
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		set_post_thumbnail($post_id, $aiomatic_image_id);
	}
	wp_send_json_success( array( 'post_id' => $post_id ) );
    die();
}
add_action( 'wp_ajax_aiomatic_write_text', 'aiomatic_write_text' );
add_action( 'wp_ajax_nopriv_aiomatic_write_text', 'aiomatic_write_text' );
function aiomatic_write_text() 
{
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
    require_once(dirname(__FILE__) . "/res/aiomatic-chars.php");
	if(!isset($_POST['prompt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prompt)' ) );
	}
	$prompt = stripslashes( $_POST['prompt'] );
	if(!isset($_POST['model']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (model)' ) );
	}
	$model = stripslashes( $_POST['model'] );
	if(!isset($_POST['assistant_id']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (assistant_id)' ) );
	}
	$assistant_id = stripslashes( $_POST['assistant_id'] );
	if(!isset($_POST['max_tokens']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (max_tokens)' ) );
	}
	$max_tokens = stripslashes( $_POST['max_tokens'] );
	if(!isset($_POST['temperature']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (temperature)' ) );
	}
	$temperature = stripslashes( $_POST['temperature'] );
	if(!isset($_POST['title']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (title)' ) );
	}
	$title = stripslashes( $_POST['title'] );
	if(!isset($_POST['language']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (language)' ) );
	}
	$language = stripslashes( $_POST['language'] );
	if(!isset($_POST['writing_style']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (writing_style)' ) );
	}
	$writing_style = stripslashes( $_POST['writing_style'] );
	if(!isset($_POST['writing_tone']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (writing_tone)' ) );
	}
	$writing_tone = stripslashes( $_POST['writing_tone'] );
	if(!isset($_POST['topics']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (topics)' ) );
	}
	$topics = stripslashes( $_POST['topics'] );
	if(!isset($_POST['sections']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (sections)' ) );
	}
	$sections = stripslashes( $_POST['sections'] );
	if(!isset($_POST['sections_count']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (sections_count)' ) );
	}
	$sections_count = stripslashes( $_POST['sections_count'] );
	if(!isset($_POST['paragraph_count']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (paragraph_count)' ) );
	}
	$paragraph_count = stripslashes( $_POST['paragraph_count'] );
	if(!isset($_POST['content_gen_type']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (content_gen_type)' ) );
	}
    if(isset($_POST['metakeyinput']))
	{
	    $metakeyinput = stripslashes( $_POST['metakeyinput'] );
	}
    else
    {
        $metakeyinput = '';
    }
	$content_gen_type = stripslashes( $_POST['content_gen_type'] );
	$temperature = floatval($temperature);
	$max_tokens = intval($max_tokens);
	if($max_tokens > 2048)
	{
		$big_model = false;
		if(!aiomatic_is_trained_model($model))
		{
			$big_model = true;
		}
		elseif(strstr($model, 'turbo') !== false && !aiomatic_is_trained_model($model))
		{
			$big_model = true;
		}
		elseif(strstr($model, 'gpt-4') !== false && !aiomatic_is_trained_model($model))
		{
			$big_model = true;
		}
		if($big_model == false)
		{
			$max_tokens = 2048;
		}
	}
	$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
	if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
	$new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    if($content_gen_type == 'yes')
    {
        $main_prompt = $prompt;
        if($sections != '')
        {
            $post_sections_arr = preg_split('/\r\n|\r|\n/', $sections);
        }
        else
        {
            $post_sections_arr = array();
        }
        foreach($post_sections_arr as $current_section)
        {
            $prompt = str_replace('%%title%%', $title, $main_prompt);
            $prompt = str_replace('%%current_section%%', $current_section, $main_prompt);
            $prompt = str_replace('%%language%%', $language, $prompt);
            $prompt = str_replace('%%writing_style%%', $writing_style, $prompt);
            $prompt = str_replace('%%writing_tone%%', $writing_tone, $prompt);
            $prompt = str_replace('%%topic%%', $topics, $prompt);
            $prompt = str_replace('%%sections%%', $sections, $prompt);
            $prompt = str_replace('%%sections_count%%', $sections_count, $prompt);
            $prompt = str_replace('%%paragraphs_per_section%%', $paragraph_count, $prompt);
            $prompt = str_replace('%%meta_title%%', $metakeyinput, $prompt);
            
            $query_token_count = count(aiomatic_encode($prompt));
            $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
            if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
            {
                $string_len = strlen($prompt);
                $string_len = $string_len / 2;
                $string_len = intval(0 - $string_len);
                $aicontent = aiomatic_substr($prompt, 0, $string_len);
                $aicontent = trim($aicontent);
                if(empty($aicontent))
                {
                    wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
                }
                $query_token_count = count(aiomatic_encode($aicontent));
                $available_tokens = $max_tokens - $query_token_count;
            }
            $thread_id = '';
            $aierror = '';
            $finish_reason = '';
            $generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, $temperature, 1, 0, 0, false, 'singlePostWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $assistant_id, $thread_id, '', 'disabled', '', false);
            if($generated_text === false)
            {
                wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
            }
            else
            {
                $new_post_content .= '<h2>' . $current_section . '</h2>';
                $new_post_content .= aiomatic_sanitize_ai_result($generated_text) . ' ';
            }
        }
    }
    else
    {
        $prompt = str_replace('%%title%%', $title, $prompt);
        $prompt = str_replace('%%language%%', $language, $prompt);
        $prompt = str_replace('%%writing_style%%', $writing_style, $prompt);
        $prompt = str_replace('%%writing_tone%%', $writing_tone, $prompt);
        $prompt = str_replace('%%topic%%', $topics, $prompt);
        $prompt = str_replace('%%sections%%', $sections, $prompt);
        $prompt = str_replace('%%sections_count%%', $sections_count, $prompt);
        $prompt = str_replace('%%paragraphs_per_section%%', $paragraph_count, $prompt);
        $prompt = str_replace('%%meta_title%%', $metakeyinput, $prompt);
        
        $query_token_count = count(aiomatic_encode($prompt));
        $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
        if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
        {
            $string_len = strlen($prompt);
            $string_len = $string_len / 2;
            $string_len = intval(0 - $string_len);
            $aicontent = aiomatic_substr($prompt, 0, $string_len);
            $aicontent = trim($aicontent);
            if(empty($aicontent))
            {
                wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
            }
            $query_token_count = count(aiomatic_encode($aicontent));
            $available_tokens = $max_tokens - $query_token_count;
        }
        $thread_id = '';
        $aierror = '';
        $finish_reason = '';
        $generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, $temperature, 1, 0, 0, false, 'singlePostWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $assistant_id, $thread_id, '', 'disabled', '', false);
        if($generated_text === false)
        {
            wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
        }
        else
        {
            $new_post_content = aiomatic_sanitize_ai_result($generated_text);
        }
    }
    if (!isset($aiomatic_Main_Settings['no_undetectibility']) || $aiomatic_Main_Settings['no_undetectibility'] != 'on') 
    {
        $new_post_content = aiomatic_remove_parasite_phrases($new_post_content);
        if(!isset($xchars))
        {
            $xchars = array();
        }
        $rand_percentage = rand(10, 20);
        $new_post_content = aiomatic_make_unique($new_post_content, $xchars, $rand_percentage);
    }
    do_action('aiomatic_text_writer_reply', $new_post_content);
	wp_send_json_success( array( 'content' => $new_post_content ) );
    die();
}

add_action( 'wp_ajax_aiomatic_delete_template', 'aiomatic_delete_template' );
function aiomatic_delete_template() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['template_name']))
	{
		wp_send_json_error( array( 'message' => 'Template name is required!' ) );
	}
	$template_name = sanitize_text_field( stripslashes($_POST['template_name']) );
    if(empty($template_name))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid template name!' ) );
    }
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates'; 
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
        if(!isset($aiomatic_templates[$template_name]))
        {
            wp_send_json_error( array( 'message' => 'Template name not found in database, please refresh this page to update template listing' ) );
        }
        else
        {
            unset($aiomatic_templates[$template_name]);
            update_user_meta( $user_id, $key, $aiomatic_templates );
        }
    }
    wp_send_json_success( array( 'content' => 'saved' ) );
    die();
}
add_action( 'wp_ajax_aiomatic_delete_template_advanced', 'aiomatic_delete_template_advanced' );
function aiomatic_delete_template_advanced() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['template_name']))
	{
		wp_send_json_error( array( 'message' => 'Template name is required!' ) );
	}
	$template_name = sanitize_text_field( stripslashes($_POST['template_name']) );
    if(empty($template_name))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid template name!' ) );
    }
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates_advanced'; 
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
        if(!isset($aiomatic_templates[$template_name]))
        {
            wp_send_json_error( array( 'message' => 'Template name not found in database, please refresh this page to update template listing' ) );
        }
        else
        {
            unset($aiomatic_templates[$template_name]);
            update_user_meta( $user_id, $key, $aiomatic_templates );
        }
    }
    wp_send_json_success( array( 'content' => 'saved' ) );
    die();
}

add_action( 'wp_ajax_aiomatic_save_template', 'aiomatic_save_template' );
function aiomatic_save_template() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['template_name']))
	{
		wp_send_json_error( array( 'message' => 'Template name is required!' ) );
	}
	$template_name = sanitize_text_field( stripslashes($_POST['template_name']) );
    if(empty($template_name))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid template name!' ) );
    }
	if(!isset($_POST['template_options']))
	{
		wp_send_json_error( array( 'message' => 'Template settings are required!' ) );
	}
	$template_options = $_POST['template_options'];
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates'; 
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
        $aiomatic_templates[$template_name] = $template_options;
        update_user_meta( $user_id, $key, $aiomatic_templates );
    }
    wp_send_json_success( array( 'content' => 'saved' ) );
    die();
}
add_action( 'wp_ajax_aiomatic_save_template_advanced', 'aiomatic_save_template_advanced' );
function aiomatic_save_template_advanced() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['template_name']))
	{
		wp_send_json_error( array( 'message' => 'Template name is required!' ) );
	}
	$template_name = sanitize_text_field( stripslashes($_POST['template_name']) );
    if(empty($template_name))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid template name!' ) );
    }
	if(!isset($_POST['template_options']))
	{
		wp_send_json_error( array( 'message' => 'Template settings are required!' ) );
	}
	$template_options = $_POST['template_options'];
	
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates_advanced'; 
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
        $aiomatic_templates[$template_name] = $template_options;
        update_user_meta( $user_id, $key, $aiomatic_templates );
    }
    wp_send_json_success( array( 'content' => 'saved' ) );
    die();
}

add_action( 'wp_ajax_aiomatic_load_template', 'aiomatic_load_template' );
function aiomatic_load_template() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['template_name']))
	{
		wp_send_json_error( array( 'message' => 'Template name is required!' ) );
	}
	$template_name = sanitize_text_field( stripslashes($_POST['template_name']) );
    if(empty($template_name))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid template name!' ) );
    }
    $aiomatic_templates = array();
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        if($template_name == 'Default Template')
        {
            $author_obj = get_user_by('id', $user_id);
            if($author_obj !== false)
            {
                $user_login = $author_obj->ID;
            }
            else
            {
                aiomatic_log_to_file('Failed to detect current user name: ' . $user_id);
                $user_login = 1;
            }
            $dt = new DateTime();
            $datef = $dt->format('Y-m-d H:i:s');
            $default_category = get_option('default_category');
            $aiomatic_templates = array
            (
                'title' => '',
                'topics' => '',
                'submit_status' => 'draft',
                'submit_type' => 'post',
                'post_sticky' => 'no',
                'post_author' => $user_login,
                'post_date' => $datef,
                'post_category' => array($default_category),
                'post_tags' => '',
                'language' => 'English',
                'writing_style' => 'Creative',
                'writing_tone' => 'Neutral',
                'sections_count' => 2,
                'paragraph_count' => 3,
                'model' => 'gpt-3.5-turbo-instruct',
                'max_tokens' => 4000,
                'temperature' => 1,
                'prompt_title' => 'Write a title for an article about "%%topic%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.',
                'prompt_sections' => 'Write %%sections_count%% consecutive headings for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.',
                'prompt_content' => 'Write an article about "%%title%%" in %%language%%. The article is organized by the following headings:

%%sections%%

Write %%paragraphs_per_section%% paragraphs per heading.

Use HTML for formatting, include h2 tags, h3 tags, lists and bold.

Add an introduction and a conclusion.

Style: %%writing_style%%. Tone: %%writing_tone%%.',
                'prompt_excerpt' => 'Write an excerpt for an article about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.'
                    );
        }
        else
        {
            $key = 'aiomatic_templates'; 
            $single = true; 
            $aiomatic_templates = get_user_meta( $user_id, $key, $single );
            if(!is_array($aiomatic_templates))
            {
                $aiomatic_templates = array();
            }
            if(!isset($aiomatic_templates[$template_name]))
            {
                wp_send_json_error( array( 'message' => 'Template name not found in the database' ) );
            }
            $aiomatic_templates = $aiomatic_templates[$template_name];
        }
    }
    wp_send_json_success( array( 'content' => $aiomatic_templates ) );
    die();
}

add_action( 'wp_ajax_aiomatic_import_templates_advanced', 'aiomatic_import_templates_advanced' );
function aiomatic_import_templates_advanced() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
    if(!isset($_POST['templates']))
	{
		wp_send_json_error( array( 'message' => 'Template json is required!' ) );
	}
    $templates = $_POST['templates'];
    if(!is_array($_POST['templates'])) {
        wp_send_json_error(['message' => 'Invalid JSON data']);
    }
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates_advanced';
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
        $templates = array_merge($templates, $aiomatic_templates);
        update_user_meta( $user_id, $key, $templates );
    }
    wp_send_json_success( array( 'status' => 'ok' ) );
    die();
}
add_action( 'wp_ajax_aiomatic_import_templates', 'aiomatic_import_templates' );
function aiomatic_import_templates() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
    if(!isset($_POST['templates']))
	{
		wp_send_json_error( array( 'message' => 'Template json is required!' ) );
	}
    $templates = $_POST['templates'];
    if(!is_array($_POST['templates'])) {
        wp_send_json_error(['message' => 'Invalid JSON data']);
    }
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates';
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
        $templates = array_merge($templates, $aiomatic_templates);
        update_user_meta( $user_id, $key, $templates );
    }
    wp_send_json_success( array( 'status' => 'ok' ) );
    die();
}
add_action( 'wp_ajax_aiomatic_export_templates', 'aiomatic_export_templates' );
function aiomatic_export_templates() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
    $aiomatic_templates = array();
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates'; 
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
    }
    wp_send_json_success( array( 'content' => $aiomatic_templates ) );
    die();
}
add_action( 'wp_ajax_aiomatic_export_templates_advanced', 'aiomatic_export_templates_advanced' );
function aiomatic_export_templates_advanced() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
    $aiomatic_templates = array();
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        $key = 'aiomatic_templates_advanced'; 
        $single = true; 
        $aiomatic_templates = get_user_meta( $user_id, $key, $single );
        if(!is_array($aiomatic_templates))
        {
            $aiomatic_templates = array();
        }
    }
    wp_send_json_success( array( 'content' => $aiomatic_templates ) );
    die();
}

add_action( 'wp_ajax_aiomatic_load_template_advanced', 'aiomatic_load_template_advanced' );
function aiomatic_load_template_advanced() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['template_name']))
	{
		wp_send_json_error( array( 'message' => 'Template name is required!' ) );
	}
	$template_name = sanitize_text_field( stripslashes($_POST['template_name']) );
    if(empty($template_name))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid template name!' ) );
    }
    $aiomatic_templates = array();
	$user_id = get_current_user_id(); 
    if($user_id == 0)
    {
        wp_send_json_error( array( 'message' => 'No user logged in, cannot find templates!' ) );
    }
    else
    {
        if($template_name == 'Default Template')
        {
            $author_obj = get_user_by('id', $user_id);
            if($author_obj !== false)
            {
                $user_login = $author_obj->ID;
            }
            else
            {
                aiomatic_log_to_file('Failed to detect current user name: ' . $user_id);
                $user_login = 1;
            }
            $dt = new DateTime();
            $datef = $dt->format('Y-m-d H:i:s');
            $default_category = get_option('default_category');
            $aiomatic_templates = array(
'title_advanced' => '',
'posting_mode_changer' => '1a',
'aiomatic_topics_list' => '',
'aiomatic_listicle_list' => '',
'aiomatic_titles' => '',
'aiomatic_youtube' => '',
'aiomatic_roundup' => '',
'aiomatic_review' => '',
'csv_title' => '',
'submit_status_advanced' => 'draft',
'submit_type_advanced' => 'post',
'post_sticky_advanced' => 'no',
'post_author_advanced' => $user_login,
'post_date_advanced' => $datef,
'post_category_advanced' => array($default_category),
'post_tags_advanced' => '',
'title_generator_method1a' => 'ai',
'assistant_id1a' => '',
'title_generator_method6' => 'ai',
'assistant_id6' => '',
'assistant_id1b' => '',
'assistant_id2' => '',
'assistant_id3' => '',
'assistant_id4' => '',
'post_sections_list1a' => '',
'section_count1a' => '3-4',
'sections_role1a' => 'h2',
'paragraph_count1a' => 2,
'topic_images1a' => '',
'img_all_headings1a' => 1,
'heading_img_location1a' => 'top',
'topic_videos1a' => '',
'title_outro1a' => '{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}',
'enable_toc1a' => 0,
'title_toc1a' => 'Table of Contents',
'enable_qa1a' => 0,
'title_qa1a' => 'Q&A',
'content_language1a' => 'English',
'writing_style1a' => 'Creative',
'writing_tone1a' => 'Neutral',
'title_prompt1a' => 'Write a title for an article about "%%topic%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.',
'topic_title_model1a' => 'gpt-3.5-turbo',
'intro_prompt1a' => 'Craft an introduction for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_intro_model1a' => 'gpt-3.5-turbo',
'sections_prompt1a' => 'Write %%sections_count%% consecutive headings for an article about "%%title%%" that highlight specific aspects, provide detailed insights and specific recommendations. The headings must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don\'t add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else.',
'topic_sections_model1a' => 'gpt-3.5-turbo',
'content_prompt1a' => 'Write the content of a post section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%title%%". Don\'t add the title at the beginning of the created content. Be creative and unique. Don\'t repeat the heading in the created content. Don\'t add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_content_model1a' => 'gpt-3.5-turbo',
'single_content_call-11a' => 0,
'qa_prompt1a' => 'Write a Q&A for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_qa_model1a' => 'gpt-3.5-turbo',
'outro_prompt1a' => 'Write an outro for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_outro_model1a' => 'gpt-3.5-turbo',
'excerpt_prompt1a' => 'Write a short excerpt for an article about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.',
'topic_excerpt_model1a' => 'gpt-3.5-turbo',
'strip_by_regex_prompts1a' => '',
'replace_regex_prompts1a' => '',
'run_regex_on1a' => 'content',
'global_prepend1a' => '',
'global_append1a' => '',
'link_type1a' => 'disabled',
'max_links1a' => '',
'link_list1a' => '',
'link_nofollow1a' => 0,
'link_post_types1a' => '',
'max_tokens1a' => '',
'max_seed_tokens1a' => '',
'temperature1a' => '',
'top_p1a' => '',
'presence_penalty1a' => '',
'frequency_penalty1a' => '',
'search_query_repetition1a' => 0,
'enable_ai_images1a' => 0,
'ai_command_image1a' => 'Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.',
'model1a' => '1024x1024',
'post_prepend1a' => '',
'post_append1a' => '',
'custom_shortcodes1a' => '',
'strip_title1a' => 0,
'skip_spin1a' => 0,
'skip_translate1a' => 0,
'strip_by_regex1a' => '',
'replace_regex1a' => '',
'post_sections_list6' => '',
'section_count6' => '3-4',
'sections_role6' => 'h2',
'paragraph_count6' => 2,
'topic_images6' => '',
'img_all_headings6' => 1,
'heading_img_location6' => 'top',
'topic_videos6' => '',
'title_outro6' => '{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}',
'enable_toc6' => 0,
'title_toc6' => 'Table of Contents',
'enable_qa6' => 0,
'title_qa6' => 'Q&A',
'content_language6' => 'English',
'writing_style6' => 'Creative',
'writing_tone6' => 'Neutral',
'title_prompt6' => 'Write a title for a listicle about "%%topic%%" in %%language%%. The listicle will include %%sections_count%% items. Style: %%writing_style%%. Tone: %%writing_tone%%. Include a specific number in the title to indicate a list. Must be between 40 and 60 characters.',
'topic_title_model6' => 'gpt-3.5-turbo',
'intro_prompt6' => 'Craft an introduction for a listicle about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Highlight the number of items in the list and what the reader can expect to learn or gain from the listicle.',
'topic_intro_model6' => 'gpt-3.5-turbo',
'sections_prompt6' => 'Write %%sections_count%% consecutive entries for a listicle about "%%title%%". The entries must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don\'t use HTML in your response, write only plain text entries, one on each line, as I will use these entries to further create content for each of them. Return only the entries, nothing else.',
'topic_sections_model6' => 'gpt-3.5-turbo',
'content_prompt6' => 'Write the content of a listicle section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%title%%". Don\'t add the title at the beginning of the created content. Be creative and unique. Don\'t repeat the heading in the created content. Don\'t add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Act as a Content Writer, not as a Virtual Assistant. Return only the content requested, without any additional comments or text. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_content_model6' => 'gpt-3.5-turbo',
'single_content_call-16' => 0,
'qa_prompt6' => 'Write a Q&A listicle for an article about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Each question should be clear and engaging, followed by a detailed and informative answer. Use HTML for formatting, include unnumbered lists and bold where applicable. Return only the Q&A content, nothing else.',
'topic_qa_model6' => 'gpt-3.5-turbo',
'outro_prompt6' => 'Write an outro for a listicle about "%%title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_outro_model6' => 'gpt-3.5-turbo',
'excerpt_prompt6' => 'Write a short excerpt for a listicle about "%%title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters. Highlight the listicle nature of the article and what readers can expect to find.',
'topic_excerpt_model6' => 'gpt-3.5-turbo',
'strip_by_regex_prompts6' => '',
'replace_regex_prompts6' => '',
'run_regex_on6' => 'content',
'global_prepend6' => '',
'global_append6' => '',
'link_type6' => 'disabled',
'max_links6' => '',
'link_list6' => '',
'link_nofollow6' => 0,
'link_post_types6' => '',
'max_tokens6' => '',
'max_seed_tokens6' => '',
'temperature6' => '',
'top_p6' => '',
'presence_penalty6' => '',
'frequency_penalty6' => '',
'search_query_repetition6' => 0,
'enable_ai_images6' => 0,
'ai_command_image6' => 'Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.',
'model6' => '1024x1024',
'post_prepend6' => '',
'post_append6' => '',
'custom_shortcodes6' => '',
'strip_title6' => 0,
'skip_spin6' => 0,
'skip_translate6' => 0,
'strip_by_regex6' => '',
'replace_regex6' => '',
'model1b' => '1024x1024',
'ai_command1b' => 'Write a comprehensive and SEO-optimized article on the topic of "%%post_title%%". Incorporate relevant keywords naturally throughout the article to enhance search engine visibility. This article must provide valuable information to readers and be well-structured with proper headings, bullet points, and HTML formatting. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple.  Add an introductory and a conclusion section to the article. You can add also some other sections, when they fit the article\'s subject, like: benefits and practical tips, case studies, first had experience. Please ensure that the article is at least 1200 words in length and adheres to best SEO practices, including proper header tags (H1, H2, H3), meta title, and meta description. Feel free to use a friendly, conversational tone and make the article as informative and engaging as possible while ensuring it remains factually accurate and well-researched.',
'min_char1b' => 500,
'title_model1b' => 'gpt-3.5-turbo',
'title_ai_command1b' => 'Craft an attention-grabbing and SEO-optimized article title for a dental health blog. This title must be concise, informative, and designed to pique the interest of readers while clearly conveying the topic of the article.',
'title_source1b' => 'keyword',
'headings1b' => '',
'headings_model1b' => 'gpt-3.5-turbo',
'headings_ai_command1b' => 'Generate %%needed_heading_count%% People Also Ask (PAA) related questions, each on a new line, that are relevant to the topic of the post title: "%%post_title%%".',
'images1b' => '',
'videos1b' => 0,
'headings_list1b' => '',
'images_list1b' => '',
'global_prepend1b' => '',
'global_append1b' => '',
'link_type1b' => 'disabled',
'max_links1b' => '',
'link_list1b' => '',
'link_nofollow1b' => 0,
'link_post_types1b' => '',
'max_tokens1b' => '',
'max_seed_tokens1b' => '',
'max_continue_tokens1b' => '',
'temperature1b' => '',
'top_p1b' => '',
'presence_penalty1b' => '',
'frequency_penalty1b' => '',
'search_query_repetition1b' => 0,
'enable_ai_images1b' => 0,
'ai_command_image1b' => 'Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.',
'post_prepend1b' => '',
'post_append1b' => '',
'custom_shortcodes1b' => '',
'strip_title1b' => 0,
'skip_spin1b' => 0,
'skip_translate1b' => 0,
'strip_by_regex1b' => '',
'replace_regex1b' => '',
'default_lang2' => '',
'max_caption2' => 3000,
'ai_titles2' => 0,
'post_sections_list2' => '',
'section_count2' => '3-4',
'sections_role2' => 'h2',
'paragraph_count2' => 2,
'topic_images2' => '',
'img_all_headings2' => 1,
'heading_img_location2' => 'heading',
'topic_videos2' => 0,
'title_outro2' => '{In Conclusion|To Conclude|In Summary|To Wrap It Up|Key Takeaways|Future Outlook|Closing Remarks|The Conclusion|Final Thoughts|In Retrospect|The Way Forward|Wrapping Up|Concluding Remarks|Insights and Conclusions}',
'enable_toc2' => 0,
'title_toc2' => 'Table of Contents',
'enable_qa2' => 0,
'title_qa2' => 'Q&A',
'content_language2' => 'English',
'writing_style2' => 'Creative',
'writing_tone2' => 'Neutral',
'title_prompt2' => 'Generate a title for a blog post discussing the topics covered in the YouTube video titled: "%%video_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.',
'topic_title_model2' => 'gpt-3.5-turbo',
'intro_prompt2' => 'Write an introduction for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The YouTube video has the following transcript: "%%video_captions%%"',
'topic_intro_model2' => 'gpt-3.5-turbo',
'sections_prompt2' => 'Write %%sections_count%% consecutive headings that highlight specific aspects, provide detailed insights and specific recommendations for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Don\'t add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else. Extract ideas from the following video transcript: "%%video_captions%%"',
'topic_sections_model2' => 'gpt-3.5-turbo',
'content_prompt2' => 'Write the content of a post section for the heading "%%current_section%%" in %%language%%. The title of the post is: "%%video_title%%". Don\'t repeat the heading in the created content. Don\'t add an intro or outro. Be creative and unique. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%. Extract content from the following video transcript: "%%video_captions%%"',
'topic_content_model2' => 'gpt-3.5-turbo',
'single_content_call-12' => 0,
'qa_prompt2' => 'Write a Q&A for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The YouTube video has the following transcript: "%%video_captions%%"',
'topic_qa_model2' => 'gpt-3.5-turbo',
'outro_prompt2' => 'Write an outro for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The YouTube video has the following transcript: "%%video_captions%%"',
'topic_outro_model2' => 'gpt-3.5-turbo',
'excerpt_prompt2' => 'Write a short excerpt for a blog post which talks about the topics discussed in the YouTube video with the following title: "%%video_title%%" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters. The YouTube video has the following transcript: "%%video_captions%%"',
'topic_excerpt_model2' => 'gpt-3.5-turbo',
'strip_by_regex_prompts2' => '',
'replace_regex_prompts2' => '',
'run_regex_on2' => 'content',
'global_prepend2' => '',
'global_append2' => '',
'link_type2' => 'disabled',
'max_links2' => '',
'link_list2' => '',
'link_nofollow2' => 0,
'link_post_types2' => '',
'max_tokens2' => '',
'max_seed_tokens2' => '',
'max_continue_tokens2' => '',
'temperature2' => '',
'top_p2' => '',
'presence_penalty2' => '',
'frequency_penalty2' => '',
'search_query_repetition2' => 0,
'enable_ai_images2' => 0,
'ai_command_image2' => 'Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this post title: "%%post_title%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.',
'model2' => '1024x1024',
'post_prepend2' => '',
'post_append2' => '',
'custom_shortcodes2' => '',
'strip_title2' => 0,
'skip_spin2' => 0,
'skip_translate2' => 0,
'no_random2' => 0,
'strip_by_regex2' => '',
'replace_regex2' => '',
'affiliate_id3' => '',
'source3' => 'com',
'min_price3' => '',
'max_price3' => '',
'max_products3' => '3-4',
'sort_results3' => 'none',
'shuffle_products3' => 1,
'first_hand3' => 0,
'sections_role3' => 'h2',
'paragraph_count3' => 2,
'topic_images3' => 1,
'no_headlink3' => 0,
'topic_videos3' => 0,
'title_outro3' => '{Experience the Difference|Unlock Your Potential|Elevate Your Lifestyle|Embrace a New Era|Seize the Opportunity|Discover the Power|Transform Your World|Unleash Your True Potential|Embody Excellence|Achieve New Heights|Experience Innovation|Ignite Your Passion|Reveal the Extraordinary}',
'enable_toc3' => 0,
'title_toc3' => 'Table of Contents',
'enable_qa3' => 0,
'title_qa3' => 'Q&A',
'enable_table3' => 0,
'content_language3' => 'English',
'writing_style3' => 'Creative',
'writing_tone3' => 'Neutral',
'title_prompt3' => 'Write a title for a product roundup blog post which talks about the following products: %%all_product_titles%%,  %%all_product_info%%, in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.',
'topic_title_model3' => 'gpt-3.5-turbo',
'intro_prompt3' => 'Write an intro for a blog post which talks about the following products: %%all_product_titles%%,  %%all_product_info%%, in %%language%%. The title of the post is "%%post_title%%". Style: %%writing_style%%. Tone: %%writing_tone%%.',
'topic_intro_model3' => 'gpt-3.5-turbo',
'content_prompt3' => 'Write the content of a post section describing the product "%%product_title%%" in %%language%%. Include pros and cons of the product. Don\'t repeat the product title in the created content. Don\'t add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%. %%first_hand_experience_prompt%% Extract content from the following product description: "%%product_description%%"',
'topic_content_model3' => 'gpt-3.5-turbo',
'qa_prompt3' => 'Write a Q&A for a blog post with the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The blog post describes and compares multiple products: %%all_product_titles%%',
'topic_qa_model3' => 'gpt-3.5-turbo',
'outro_prompt3' => 'Write an outro for a blog post with the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The blog post describes and compares multiple products: %%all_product_titles%%',
'topic_outro_model3' => 'gpt-3.5-turbo',
'excerpt_prompt3' => 'Write a short excerpt for a blog post with the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. The blog post describes and compares multiple products: %%all_product_titles%%',
'topic_excerpt_model3' => 'gpt-3.5-turbo',
'table_prompt3' => 'Generate a HTML product comparison table, for a product review blog post. The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Don\'t add the entire description as a table entry, but instead, extract data from it, make matches between multiple products, be creative and also short and simple. The table must be in a WordPress friendly format and have modern styling (you can use WordPress table classes). Detail product information: %%all_product_info%%',
'topic_table_model3' => 'gpt-3.5-turbo',
'strip_by_regex_prompts3' => '',
'replace_regex_prompts3' => '',
'run_regex_on3' => 'content',
'global_prepend3' => '',
'global_append3' => '',
'link_type3' => 'disabled',
'max_links3' => '',
'link_list3' => '',
'link_nofollow3' => 0,
'link_post_types3' => '',
'max_tokens3' => '',
'max_seed_tokens3' => '',
'max_continue_tokens3' => '',
'temperature3' => '',
'top_p3' => '',
'presence_penalty3' => '',
'frequency_penalty3' => '',
'search_query_repetition3' => 0,
'enable_ai_images3' => 0,
'ai_command_image3' => 'A high detail image with no text of: "%%post_title%%"',
'model3' => '1024x1024',
'post_prepend3' => '',
'post_append3' => '',
'custom_shortcodes3' => '',
'strip_title3' => 0,
'skip_spin3' => 0,
'skip_translate3' => 0,
'strip_by_regex3' => '',
'replace_regex3' => '',
'affiliate_id4' => '',
'source4' => 'com',
'post_sections_list4' => '',
'section_count4' => '3-4',
'sections_role4' => 'h2',
'paragraph_count4' => 2,
'topic_images4' => 1,
'no_headlink4' => 0,
'topic_videos4' => 0,
'title_outro4' => '{Experience the Difference|Unlock Your Potential|Elevate Your Lifestyle|Embrace a New Era|Seize the Opportunity|Discover the Power|Transform Your World|Unleash Your True Potential|Embody Excellence|Achieve New Heights|Experience Innovation|Ignite Your Passion|Reveal the Extraordinary}',
'enable_toc4' => 0,
'title_toc4' => 'Table of Contents',
'enable_reviews4' => 0,
'title_reviews4' => 'Customer Reviews Analysis',
'enable_proscons4' => 0,
'title_proscons4' => 'Pros & Cons',
'enable_qa4' => 0,
'title_qa4' => 'Q&A',
'content_language4' => 'English',
'writing_style4' => 'Creative',
'writing_tone4' => 'Neutral',
'title_prompt4' => 'Write a title for a product review blog post of the following product: "%%product_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Point of View: %%point_of_view%%. The title must be between 40 and 60 characters. The description of the product is: "%%product_description%%".',
'topic_title_model4' => 'gpt-3.5-turbo',
'intro_prompt4' => 'Write an introduction for a product review blog post of the following product: "%%product_title%%". The post is reviewing the product "%%product_title%%", in %%language%% language. Style: %%writing_style%%. Tone: %%writing_tone%%. Point of View: %%point_of_view%%. Write as if you had first-hand experience with the product you are describing. The description of the product is: "%%product_description%%".',
'topic_intro_model4' => 'gpt-3.5-turbo',
'sections_prompt4' => 'Write %%sections_count%% consecutive headings for a product review article of the "%%product_title%%" product, that starts with an overview, highlights specific features and aspects of the product, provides detailed insights and specific recommendations. The headings should be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Point of view: %%point_of_view%%. Don\'t add numbers to the headings, hyphens or any types of quotes. Write as if you had first-hand experience with the product you are describing. Return only the headings list, nothing else.',
'topic_sections_model4' => 'gpt-3.5-turbo',
'content_prompt4' => 'Write the content of a product review post, for the following section heading: "%%current_section%%". The post is reviewing the product "%%product_title%%" in %%language%%. Don\'t repeat the product title in the created content, also don\'t be repetitive in general. Don\'t add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Extract content from the following product description: "%%product_description%%".',
'topic_content_model4' => 'gpt-3.5-turbo',
'reviews_prompt4' => 'Write the content of a "Customer Reviews Analysis" section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Use HTML for formatting. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. List of customer reviews: "%%product_reviews%%".',
'topic_reviews_model4' => 'gpt-3.5-turbo',
'proscons_prompt4' => 'Write the content of a "Pros & Cons" section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%.Use HTML for formatting. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Product description: "%%product_description%%".',
'topic_proscons_model4' => 'gpt-3.5-turbo',
'qa_prompt4' => 'Write the content of a Q&A section for a product review blog post for the following product: "%%product_title%%". The title of the blog post is: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Product description: "%%product_description%%".',
'topic_qa_model4' => 'gpt-3.5-turbo',
'outro_prompt4' => 'Write an outro for a product review blog post, for the product: "%%product_title%%". The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. Product description: "%%product_description%%". Add also an engaging final call to action link, in a clickable HTML format (don\'t use markdown language), leading to the link of the product: "%%aff_url%%".',
'topic_outro_model4' => 'gpt-3.5-turbo',
'excerpt_prompt4' => 'Write a short excerpt for a product review blog post, for the product: "%%product_title%%". The post has the following title: "%%post_title%%", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Point Of View: %%point_of_view%%. The excerpt must be between 100 and 150 words.',
'topic_excerpt_model4' => 'gpt-3.5-turbo',
'strip_by_regex_prompts4' => '',
'replace_regex_prompts4' => '',
'run_regex_on4' => 'content',
'global_prepend4' => '',
'global_append4' => '',
'link_type4' => 'disabled',
'max_links4' => '',
'link_list4' => '',
'link_nofollow4' => 0,
'link_post_types4' => '',
'max_tokens4' => '',
'max_seed_tokens4' => '',
'max_continue_tokens4' => '',
'temperature4' => '',
'top_p4' => '',
'presence_penalty4' => '',
'frequency_penalty4' => '',
'search_query_repetition4' => 0,
'enable_ai_images4' => 0,
'ai_command_image4' => 'A high detail image with no text of: "%%post_title%%"',
'model4' => '1024x1024',
'post_prepend4' => '',
'post_append4' => '',
'custom_shortcodes4' => '',
'skip_spin4' => 0,
'skip_translate4' => 0,
'strip_by_regex4' => '',
'replace_regex4' => '',
'csv_separator5' => '',
'strip_title5' => 0,
'skip_spin5' => 0,
'skip_translate5' => 0,
'random_order5' => 0,
'strip_by_regex5' => '',
'replace_regex5' => '',
'link_type5' => 'disabled',
'max_links5' => '',
'link_list5' => '',
'link_nofollow5' => 0,
'link_post_types5' => '',
'image_model1a' => 'dalle2',
'image_model1b' => 'dalle2',
'image_model2' => 'dalle2',
'image_model3' => 'dalle2',
'image_model4' => 'dalle2',
'image_model6' => 'dalle2',
            );
        }
        else
        {
            $key = 'aiomatic_templates_advanced'; 
            $single = true; 
            $aiomatic_templates = get_user_meta( $user_id, $key, $single );
            if(!is_array($aiomatic_templates))
            {
                $aiomatic_templates = array();
            }
            if(!isset($aiomatic_templates[$template_name]))
            {
                wp_send_json_error( array( 'message' => 'Advanced template name not found in the database' ) );
            }
            $aiomatic_templates = $aiomatic_templates[$template_name];
        }
    }
    wp_send_json_success( array( 'content' => $aiomatic_templates ) );
    die();
}

add_action('wp_ajax_aiomatic_handle_vision_image_upload', 'aiomatic_handle_vision_image_upload');
add_action('wp_ajax_nopriv_aiomatic_handle_vision_image_upload', 'aiomatic_handle_vision_image_upload');
function aiomatic_handle_vision_image_upload() 
{
    if ( !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'openai-persistent-nonce'))
    {
        $aiomatic_result['msg'] = esc_html__('You are not allowed to do this.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $aiomatic_result = array('status' => 'error', 'msg' => 'Image uploaded successfully');
    $allowed_file_types = ['image/jpeg', 'image/png', 'image/gif'];
    if(!isset($_FILES['image']))
    {
        $aiomatic_result['msg'] = esc_html__('No file sent for upload.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $file = $_FILES['image'];
    if ($file['size'] > 10000000) 
    {
        $aiomatic_result['msg'] = esc_html__('File size exceeds maximum limit.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if (!in_array($file['type'], $allowed_file_types)) 
    {
        $aiomatic_result['msg'] = esc_html__('Invalid file type submitted.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    add_filter('upload_dir', 'aiomatic_custom_vision_upload_dir');
    $upload = wp_handle_upload($file, ['test_form' => false]);
    remove_filter('upload_dir', 'aiomatic_custom_vision_upload_dir');
    if (!empty($upload['error'])) 
    {
        $aiomatic_result['msg'] = esc_html__('Upload error: ', 'aiomatic-automatic-ai-content-writer') . esc_html($upload['error']);
        wp_send_json($aiomatic_result);
        die();
    } 
    else 
    {
        $attachment_data = [
            'post_mime_type' => $upload['type'],
            'post_title' => sanitize_file_name($upload['file']),
            'post_content' => '',
            'post_status' => 'inherit'
        ];
        $attachment_id = wp_insert_attachment($attachment_data, $upload['file']);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);
        $image_url = wp_get_attachment_url($attachment_id);
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['image_url'] = $image_url;
        wp_send_json($aiomatic_result);
    }
    wp_die();
}

add_action('wp_ajax_aiomatic_handle_chat_pdf_upload', 'aiomatic_handle_chat_pdf_upload');
add_action('wp_ajax_nopriv_aiomatic_handle_chat_pdf_upload', 'aiomatic_handle_chat_pdf_upload');
function aiomatic_handle_chat_pdf_upload() 
{
    if ( !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'openai-persistent-nonce'))
    {
        $aiomatic_result['msg'] = esc_html__('You are not allowed to do this.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if ( !isset($_POST['pdf_namespace']) || empty($_POST['pdf_namespace']))
    {
        $aiomatic_result['msg'] = esc_html__('Please specify also a namespace for embeddings.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $aiomatic_result = array('status' => 'error', 'msg' => 'PDF file uploaded successfully');
    if(!function_exists('is_plugin_active'))
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    if (!is_plugin_active('aiomatic-extension-pdf-files/aiomatic-extension-pdf-files.php')) 
    {
        $aiomatic_result['msg'] = esc_html__("This option requires the Aiomatic Extension - PDF File Storage And Parsing to be active.", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = esc_html__("You need to enter an OpenAI API key for this feature to work.", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if (isset($aiomatic_Main_Settings['pinecone_app_id'])) {
        $pinecone_app_id = $aiomatic_Main_Settings['pinecone_app_id'];
    } else {
        $pinecone_app_id = '';
    }
    if (isset($aiomatic_Main_Settings['qdrant_app_id'])) {
        $qdrant_app_id = $aiomatic_Main_Settings['qdrant_app_id'];
    } else {
        $qdrant_app_id = '';
    }
    if($pinecone_app_id == '' && $qdrant_app_id == '')
    {
        $aiomatic_result['msg'] = esc_html__("You need to enter a Pinecone.io API or a Qdrant API key for this to work", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if (!isset($aiomatic_Main_Settings['embeddings_chat_short']) || trim($aiomatic_Main_Settings['embeddings_chat_short']) != 'on')
    {
        $aiomatic_result['msg'] = esc_html__("You need to enable Embeddings for the Chatbot for this to work", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if (!isset($aiomatic_Chatbot_Settings['upload_pdf']) || $aiomatic_Chatbot_Settings['upload_pdf'] != 'on') 
    {
        $aiomatic_result['msg'] = esc_html__("You need to enable PDF chat in plugin settings.", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $allowed_file_types = ['application/pdf'];
    if(!isset($_FILES['image']))
    {
        $aiomatic_result['msg'] = esc_html__('No file sent for upload.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $file = $_FILES['image'];
    if ($file['size'] > 50000000) 
    {
        $aiomatic_result['msg'] = esc_html__('File size exceeds maximum limit.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if (!in_array($file['type'], $allowed_file_types)) 
    {
        $aiomatic_result['msg'] = esc_html__('Invalid file type submitted.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    add_filter('upload_dir', 'aiomatic_custom_vision_upload_dir');
    $upload = wp_handle_upload($file, ['test_form' => false]);
    remove_filter('upload_dir', 'aiomatic_custom_vision_upload_dir');
    if (!empty($upload['error'])) 
    {
        $aiomatic_result['msg'] = esc_html__('Upload error: ', 'aiomatic-automatic-ai-content-writer') . esc_html($upload['error']);
        wp_send_json($aiomatic_result);
        die();
    } 
    else 
    {
        $attachment_data = [
            'post_mime_type' => $upload['type'],
            'post_title' => sanitize_file_name($upload['file']),
            'post_content' => '',
            'post_status' => 'inherit'
        ];
        $attachment_id = wp_insert_attachment($attachment_data, $upload['file']);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);
        $post_urlx = wp_get_attachment_url($attachment_id);
        $htmlc = aiomatic_extension_pdfext_getRemoteFile($post_urlx);
        if($htmlc === false)
        {
            $aiomatic_result['msg'] = esc_html__('Failed to upload and process file');
            wp_send_json($aiomatic_result);
            die();
        }
        $file_data = '';
        $pdf =  new PdfToText();
        $pdf->LoadFromString($htmlc);
        $aiomatic_stats = new Aiomatic_Statistics();
        $pdflim = $aiomatic_stats->get_pdf_limits();
        $maxp = -1;
        if(is_array($pdflim))
        {
            if(isset($pdflim[0]) && is_array($pdflim[0]))
            {
                foreach($pdflim[0] as $pdfp)
                {
                    if(intval($pdfp) > $maxp)
                    {
                        $maxp = intval($pdfp);
                    }
                }
            }
        }
        if($maxp > 0)
        {
            $page_range = '1-' . $maxp;
        }
        else
        {
            if (isset($aiomatic_Main_Settings['pdf_page']) && trim($aiomatic_Main_Settings['pdf_page']) != '')
            {
                $page_range = '1-' . trim($aiomatic_Main_Settings['pdf_page']);
            }
            else
            {
                $page_range = '';
            }
        }
        if($page_range == '')
        {
            $file_data = $pdf->Text;
        }
        else
        {
            $page_range_arr = array_map('trim', aiomatic_extension_pdfext_extract_range($page_range));
            foreach( $pdf->Pages as $page_number => $page_contents)
            {
                if(count($page_range_arr) == 0)
                {
                    break;
                }
                if(in_array($page_number, $page_range_arr))
                {
                    $page_range_arr = array_diff($page_range_arr, array($page_number));
                    $file_data .= $page_contents;
                }
            }
        }
        if($file_data === false || empty(trim($file_data)))
        {
            $pparser = new \Smalot\PdfParser\Parser();
            $document = $pparser->parseContent($htmlc);
            if($page_range == '')
            {
                $file_data  = $document->getText();
            }
            else
            {
                $page_range_arr = array_map('trim', aiomatic_extension_pdfext_extract_range($page_range));
                $nr = 1;
                $pages  = $document->getPages();
                foreach ($pages as $page) {
                    if(count($page_range_arr) == 0)
                    {
                        break;
                    }
                    if(in_array($nr, $page_range_arr))
                    {
                        $page_range_arr = array_diff($page_range_arr, array($nr));
                        $file_data .= $page->getText();
                    }
                    $nr++;
                }
                $pages = count($pages);
            }
        }
        if($file_data === false || empty(trim($file_data)))
        {
            $aiomatic_result['msg'] = esc_html__('No textual data found in the PDF file');
            wp_send_json($aiomatic_result);
            die();
        }
        $file_data = nl2br($file_data);
        $maxc = -1;
        if(is_array($pdflim))
        {
            if(isset($pdflim[1]) && is_array($pdflim[1]))
            {
                foreach($pdflim[1] as $pdfc)
                {
                    if(intval($pdfc) > $maxc)
                    {
                        $maxc = intval($pdfc);
                    }
                }
            }
        }
        if($maxc > 0)
        {
            $file_data = (strlen($file_data) > $maxc) ? substr($file_data, 0, $maxc) : $file_data;
        }
        else
        {
            if (isset($aiomatic_Main_Settings['pdf_character']) && trim($aiomatic_Main_Settings['pdf_character']) != '')
            {
                $max_l = intval($aiomatic_Main_Settings['pdf_character']);
                $file_data = (strlen($file_data) > $max_l) ? substr($file_data, 0, $max_l) : $file_data;
            }
        }
        if (isset($aiomatic_Main_Settings['embeddings_model']) && $aiomatic_Main_Settings['embeddings_model'] != '') 
        {
            $model = $aiomatic_Main_Settings['embeddings_model'];
        }
        else
        {
            $model = 'text-embedding-ada-002';
        }
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        require_once(dirname(__FILE__) . "/res/Embeddings.php");
        $embdedding = new Aiomatic_Embeddings($token);
        $aiomatic_result = $embdedding->aiomatic_save_embedding($file_data, '', '', false, $model, $_POST['pdf_namespace']);
        wp_send_json($aiomatic_result);
    }
    wp_die();
}

add_action('wp_ajax_aiomatic_handle_chat_file_upload', 'aiomatic_handle_chat_file_upload');
add_action('wp_ajax_nopriv_aiomatic_handle_chat_file_upload', 'aiomatic_handle_chat_file_upload');
function aiomatic_handle_chat_file_upload() 
{
    if ( !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'openai-persistent-nonce'))
    {
        $aiomatic_result['msg'] = esc_html__('You are not allowed to do this.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $thread_id = '';
    if ( isset($_POST['thread_id']) && $_POST['thread_id'] != '')
    {
        $thread_id = $_POST['thread_id'];
    }
    $aiomatic_result = array('status' => 'error', 'msg' => 'File uploaded successfully');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for uploads.';
        wp_send_json($aiomatic_result);
        die();
    }
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = esc_html__("You need to enter an OpenAI API key for this feature to work.", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if (!isset($aiomatic_Chatbot_Settings['enable_file_uploads']) || $aiomatic_Chatbot_Settings['enable_file_uploads'] != 'on') 
    {
        $aiomatic_result['msg'] = esc_html__("You need to enable file uploads for chat in plugin settings.", 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if(!isset($_FILES['image']))
    {
        $aiomatic_result['msg'] = esc_html__('No file sent for upload.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $file = $_FILES['image'];
    if ($file['size'] > 50000000) 
    {
        $aiomatic_result['msg'] = esc_html__('File size exceeds maximum limit.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    $open_ai = new OpenAi($token);
    if(!$open_ai){
        $aiomatic_result['msg'] = 'Missing API Setting';
        wp_send_json($aiomatic_result);
        die();
    }
    if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
    {
        $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
    }
    $file['name'] = 'chatbot-' . $file['name'];
    $file_name = sanitize_file_name(basename($file['name']));
    $tmp_file = $file['tmp_name'];
    $c_file = curl_file_create($tmp_file, $file['type'], $file_name);
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
    $purpose = 'assistants';
    $result = $open_ai->uploadFile(array(
        'purpose' => $purpose,
        'file' => $c_file,
    ));
    $result = json_decode($result);
    if(isset($result->error)){
        $aiomatic_result['msg'] = $result->error->message;
    }
    else
    {
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
        try
        {
            $vs = aiomatic_openai_create_vector_store($token, 'New Vector Store', array($result->id));
            if(isset($vs['id']))
            {
                if(!empty($thread_id))
                {
                    $thread = aiomatic_openai_modify_thread($token, $thread_id, $vs['id']);
                    if(!isset($thread['id']))
                    {
                        $aiomatic_result['msg'] = 'Invalid thread format when modifying thread: ' . print_r($thread, true);
                        wp_send_json($aiomatic_result);
                        wp_die();
                    }
                }
                $aiomatic_result['msg'] = $vs['id'];
                $aiomatic_result['fid'] = $result->id;
                $aiomatic_result['status'] = 'success';
            }
        }
        catch(Exception $e)
        {
            $aiomatic_result['msg'] = 'Exception in vector store creation: ' . $e->getMessage();
        }
    }
    wp_send_json($aiomatic_result);
    wp_die();
}

add_action('wp_ajax_aiomatic_save_chat_data', 'aiomatic_save_chat_data');
add_action('wp_ajax_nopriv_aiomatic_save_chat_data', 'aiomatic_save_chat_data');
function aiomatic_save_chat_data() 
{
    if ( !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'openai-persistent-nonce'))
    {
        $aiomatic_result['msg'] = esc_html__('You are not allowed to do this.', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if ( !isset($_POST['uniqid']) || empty($_POST['uniqid']))
    {
        $aiomatic_result['msg'] = esc_html__('Missing parameter (uniqid)', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if ( !isset($_POST['input_text']))
    {
        $aiomatic_result['msg'] = esc_html__('Missing parameter (input_text)', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if ( !isset($_POST['remember_string']))
    {
        $aiomatic_result['msg'] = esc_html__('Missing parameter (remember_string)', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    if ( !isset($_POST['user_question']))
    {
        $aiomatic_result['msg'] = esc_html__('Missing parameter (user_question)', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
        die();
    }
    $setarr = array($_POST['input_text'], $_POST['remember_string'], $_POST['user_question']);
    if (isset($_POST['function_result']) && !empty($_POST['function_result']))
    {
        $setarr[] = $_POST['function_result'];
    }
    set_transient('aiomatic_ai_data_' . $_POST['uniqid'], $setarr, 300);
    $aiomatic_result = array('status' => 'success', 'msg' => 'OK');
    wp_send_json($aiomatic_result);
    wp_die();
}
add_action('wp_ajax_aiomatic_chat_submit', 'aiomatic_chat_submit');
add_action('wp_ajax_nopriv_aiomatic_chat_submit', 'aiomatic_chat_submit');
function aiomatic_chat_submit() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with chat');
    if(!isset($_POST['input_text']) || !isset($_POST['model']) || !isset($_POST['temp']) || !isset($_POST['presence']) || !isset($_POST['frequency']) || !isset($_POST['remember_string']))
    {
        $aiomatic_result['msg'] = esc_html__('Incomplete POST request for chat', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
    }
    $is_modern_gpt = '0';
    if(isset($_POST['is_modern_gpt']))
    {
        $is_modern_gpt = $_POST['is_modern_gpt'];
    }
    $no_internet = false;
    if(isset($_POST['internet_access']) && ($_POST['internet_access'] === 'no' || $_POST['internet_access'] === '0' || $_POST['internet_access'] == 'off' || $_POST['internet_access'] == 'disabled' || $_POST['internet_access'] == 'Disabled' || $_POST['internet_access'] == 'disable' || $_POST['internet_access'] == "false"))
    {
        $no_internet = true;
    }
    $no_embeddings = false;
    if(isset($_POST['embeddings']) && ($_POST['embeddings'] === 'no' || $_POST['embeddings'] === '0' || $_POST['embeddings'] == 'off' || $_POST['embeddings'] == 'disabled' || $_POST['embeddings'] == 'disable' || $_POST['embeddings'] == 'Disabled' || $_POST['embeddings'] == "false"))
    {
        $no_embeddings = true;
    }
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if(isset($_POST['pdf_data']))
    {
        $embedding_namespace = stripslashes($_POST['pdf_data']);
    }
    else
    {
        $embedding_namespace = '';
    }
    if(isset($_POST['file_data']))
    {
        $file_data = stripslashes($_POST['file_data']);
    }
    else
    {
        $file_data = '';
    }
    if(isset($_POST['ai_thread_id']))
    {
        $thread_id = stripslashes($_POST['ai_thread_id']);
    }
    else
    {
        $thread_id = '';
    }
    if(isset($_POST['user_id']))
    {
        $user_id = stripslashes($_POST['user_id']);
    }
    else
    {
        $user_id = '';
    }
    if(empty($embedding_namespace))
    {
        if (isset($aiomatic_Chatbot_Settings['persistent']) && $aiomatic_Chatbot_Settings['persistent'] == 'vector')
        {
            $embedding_namespace = 'persistentchat_' . $user_id . '_' . $thread_id;
        }
    }
	$input_text = stripslashes($_POST['input_text']);
    if (isset($aiomatic_Chatbot_Settings['max_input_length']) && $aiomatic_Chatbot_Settings['max_input_length'] != '' && is_numeric($aiomatic_Chatbot_Settings['max_input_length'])) 
    {
        if(strlen($input_text) > intval($aiomatic_Chatbot_Settings['max_input_length']))
        {
            $input_text = substr($input_text, 0, intval($aiomatic_Chatbot_Settings['max_input_length']));
        }
    }
    if(isset($_POST['remember_string']))
    {
        $remember_string = stripslashes($_POST['remember_string']);
    }
    else
    {
        $remember_string = '';
    }
    if($is_modern_gpt == '1')
    {
        if(!empty($remember_string))
        {
            $remember_string = json_decode($remember_string, true);
            if($remember_string === null)
            {
                $aiomatic_result['msg'] = esc_html__('Failed to decode conversation data in request!', 'aiomatic-automatic-ai-content-writer');
                wp_send_json($aiomatic_result);
            }
            if(!is_array($remember_string))
            {
                $remember_string = [];
            }
        }
        else
        {
            $remember_string = [];
        }
        $remember_string[] = array ('role' => 'user', 'content' => $input_text);
        $input_text = $remember_string;
    }
    else
    {
        if(!empty(trim($remember_string)))
        {
            $input_text = trim($remember_string) . PHP_EOL . $input_text;
        }
    }
    if(isset($_POST['user_question']))
    {
        $user_question = stripslashes($_POST['user_question']);
    }
    else
    {
        $user_question = '';
    }
    if(isset($_POST['ai_assistant_id']))
    {
        $assistant_id = stripslashes($_POST['ai_assistant_id']);
    }
    else
    {
        $assistant_id = '';
    }
    if(isset($_POST['model']))
    {
        $model = stripslashes($_POST['model']);
    }
    else
    {
        $model = 'default';
    }
    if($model == 'default')
    {
        $model = AIOMATIC_DEFAULT_MODEL;
    }
    if(isset($_POST['temp']))
    {
        $temperature = stripslashes($_POST['temp']);
    }
    else
    {
        $temperature = '1';
    }
    if(isset($_POST['top_p']))
    {
        $top_p = stripslashes($_POST['top_p']);
    }
    else
    {
        $top_p = '1';
    }
    if(isset($_POST['presence']))
    {
        $presence_penalty = stripslashes($_POST['presence']);
    }
    else
    {
        $presence_penalty = '0';
    }
    if(isset($_POST['frequency']))
    {
        $frequency_penalty = stripslashes($_POST['frequency']);
    }
    else
    {
        $frequency_penalty = '0';
    }
    $all_models = aiomatic_get_all_models();
    $models = $all_models;
    if(!in_array($model, $models))
    {
        $aiomatic_result['msg'] = esc_html__('Invalid model provided: ', 'aiomatic-automatic-ai-content-writer') . $model;
        wp_send_json($aiomatic_result);
    }
    $vision_file = '';
    if(isset($_REQUEST['vision_file']))
    {
        if(aiomatic_is_vision_model($model, $assistant_id))
        {
            $vision_file = stripslashes($_REQUEST['vision_file']);
        }
    }
    $temperature = floatval($temperature);
    $top_p = floatval($top_p);
    $presence_penalty = floatval($presence_penalty);
    $frequency_penalty = floatval($frequency_penalty);
    if (isset($aiomatic_Chatbot_Settings['restriction_time']) && $aiomatic_Chatbot_Settings['restriction_time'] != '' && is_numeric($aiomatic_Chatbot_Settings['restriction_time']) 
    && isset($aiomatic_Chatbot_Settings['restriction_count']) && $aiomatic_Chatbot_Settings['restriction_count'] != '' && is_numeric($aiomatic_Chatbot_Settings['restriction_count'])) 
    {
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $restriction_time = esc_attr( $aiomatic_Chatbot_Settings['restriction_time'] );
        $user_hash = 'ai' . md5( $user_ip );
        $user_requests = get_transient( $user_hash );
        if($user_requests === false)
        {
            $user_requests = 0;
        }
        $user_max_requests = esc_attr( $aiomatic_Chatbot_Settings['restriction_count'] );
        if ( (int)$user_requests >= (int)$user_max_requests ) 
        {
            $restriction_message = '';
            if (isset($aiomatic_Chatbot_Settings['restriction_message']) && $aiomatic_Chatbot_Settings['restriction_message'] != '')
            {
                $restriction_message = $aiomatic_Chatbot_Settings['restriction_message'];
            }
            $aiomatic_result['msg'] = $restriction_message;
            wp_send_json($aiomatic_result);
        }
        set_transient( $user_hash, (int)$user_requests + 1, (int)$restriction_time );
    }
    if($temperature < 0 || $temperature > 2)
    {
        $aiomatic_result['msg'] = esc_html__('Invalid temperature provided: ', 'aiomatic-automatic-ai-content-writer') . $temperature;
        wp_send_json($aiomatic_result);
    }
    if($top_p < 0 || $top_p > 1)
    {
        $aiomatic_result['msg'] = esc_html__('Invalid top_p provided: ', 'aiomatic-automatic-ai-content-writer') . $top_p;
        wp_send_json($aiomatic_result);
    }
    if($presence_penalty < -2 || $presence_penalty > 2)
    {
        $aiomatic_result['msg'] = esc_html__('Invalid presence_penalty provided: ', 'aiomatic-automatic-ai-content-writer') . $presence_penalty;
        wp_send_json($aiomatic_result);
    }
    if($frequency_penalty < -2 || $frequency_penalty > 2)
    {
        $aiomatic_result['msg'] = esc_html__('Invalid frequency_penalty provided: ', 'aiomatic-automatic-ai-content-writer') . $frequency_penalty;
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = esc_html__('You need to insert a valid OpenAI/AiomaticAPI API Key for this to work!', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
    }
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_chat_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = esc_html__('Daily token count of your user account was exceeded! Please try again tomorrow.', 'aiomatic-automatic-ai-content-writer');
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    $max_tokens = aiomatic_get_max_tokens($model);
    if($is_modern_gpt == '1')
    {
        $aitext = '';
        foreach($input_text as $aimess)
        {
            if(isset($aimess['content']))
            {
                if(!is_array($aimess['content']))
                {
                    $aitext .= $aimess['content'] . '\n';
                }
                else
                {
                    foreach($aimess['content'] as $internalmess)
                    {
                        if($internalmess['type'] == 'text')
                        {
                            $aitext .= $internalmess['text'] . '\n';
                        }
                    }
                }
            }
        }
        $query_token_count = count(aiomatic_encode($aitext));
        $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $aitext, $query_token_count);
        if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
        {
            $startIndex = intdiv(count($input_text), 2);
            $input_text = array_slice($input_text, $startIndex);
            $lastindex = end(array_keys($input_text));
            $string_len = strlen($input_text[$lastindex]['content']);
            $string_len = $string_len / 2;
            $string_len = intval(0 - $string_len);
            $input_text[$lastindex]['content'] = aiomatic_substr($input_text[$lastindex]['content'], 0, $string_len);
            $input_text[$lastindex]['content'] = trim($input_text[$lastindex]['content']);
            $aitext = '';
            foreach($input_text as $aimess)
            {
                if(isset($aimess['content']))
                {
                    if(!is_array($aimess['content']))
                    {
                        $aitext .= $aimess['content'] . '\n';
                    }
                    else
                    {
                        foreach($aimess['content'] as $internalmess)
                        {
                            if($internalmess['type'] == 'text')
                            {
                                $aitext .= $internalmess['text'] . '\n';
                            }
                        }
                    }
                }
            }
            $query_token_count = count(aiomatic_encode($aitext));
            $available_tokens = $max_tokens - $query_token_count;
        }
    }
    else
    {
        $query_token_count = count(aiomatic_encode($input_text));
        $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $input_text, $query_token_count);
        if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
        {
            $string_len = strlen($input_text);
            $string_len = $string_len / 2;
            $string_len = intval(0 - $string_len);
            $input_text = aiomatic_substr($input_text, 0, $string_len);
            $input_text = trim($input_text);
            if(empty($input_text))
            {
                aiomatic_log_to_file('Empty API seed expression provided (after processing)');
                $aiomatic_result['msg'] = esc_html__('An internal error occurred, please try again later!', 'aiomatic-automatic-ai-content-writer');
                wp_send_json($aiomatic_result);
            }
            $query_token_count = count(aiomatic_encode($input_text));
            $available_tokens = $max_tokens - $query_token_count;
        }
    }
    $function_result = 'disabled';
    if(isset($_POST['enable_god_mode']))
    {
        if($_POST['enable_god_mode'] === 'on' || $_POST['enable_god_mode'] === 'yes' || $_POST['enable_god_mode'] === 'true' || $_POST['enable_god_mode'] === '1' ||  $_POST['enable_god_mode'] === 'enable' ||  $_POST['enable_god_mode'] === 'enabled')
        {
            $function_result = '';
        }
    }
	$error = '';
    $finish_reason = '';
    do_action('aiomatic_calling_chatbot', $input_text, $model);
    $response_text = aiomatic_generate_text($token, $model, $input_text, $available_tokens, $temperature, $top_p, $presence_penalty, $frequency_penalty, true, 'shortcodeChat', 0, $finish_reason, $error, $no_internet, $no_embeddings, false, $vision_file, $user_question, 'user', $assistant_id, $thread_id, $embedding_namespace, $function_result, $file_data, true);    
    if($response_text === false)
    {
        $aiomatic_result['msg'] = $error;
        wp_send_json($aiomatic_result);
    }
    else
    {
        if($is_modern_gpt == '1')
        {
            $aitext = '';
            foreach($input_text as $aimess)
            {
                if(isset($aimess['content']))
                {
                    if(!is_array($aimess['content']))
                    {
                        $aitext .= $aimess['content'] . '\n';
                    }
                    else
                    {
                        foreach($aimess['content'] as $internalmess)
                        {
                            if($internalmess['type'] == 'text')
                            {
                                $aitext .= $internalmess['text'] . '\n';
                            }
                        }
                    }
                }
            }
            $inp_count = count(aiomatic_encode($aitext));
        }
        else
        {
            $inp_count = count(aiomatic_encode($input_text));
        }
        $resp_count = count(aiomatic_encode($response_text));
        if(is_numeric($user_token_cap_per_day))
        {
            $used_token_count = intval($used_token_count) + $inp_count + $resp_count;
            update_user_meta($user_id, 'aiomatic_used_chat_tokens', $used_token_count);
        }
    }
    $aiomatic_result['status'] = 'success';
    $response_text = stripslashes($response_text);
	if (isset($aiomatic_Chatbot_Settings['enable_html']) && trim($aiomatic_Chatbot_Settings['enable_html']) == 'on') 
    {
        if (isset($aiomatic_Chatbot_Settings['strip_js']) && trim($aiomatic_Chatbot_Settings['strip_js']) == 'on') 
        {
            $response_text = preg_replace('/<script([\s\S]*?)\/\s*script>/is', "", $response_text);
            $response_text = preg_replace('/on[a-zA-Z]*="([^"]*?)"/is', "", $response_text);
        }
        $aiomatic_result['data'] = trim($response_text);
    }
    else
    {
        $aiomatic_result['data'] = trim(esc_html($response_text));
    }
    $aiomatic_result['thread_id'] = $thread_id;
    do_action('aiomatic_chat_reply', $aiomatic_result);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_post_now', 'aiomatic_aiomatic_submit_post_callback');
function aiomatic_aiomatic_submit_post_callback()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $run_id = $_POST['id'];
    $wp_post = get_post($run_id);
    if($wp_post != null)
    {
        aiomatic_do_post($wp_post, true);
    }
    die();
}
add_action('wp_ajax_aiomatic_toggle_status', 'aiomatic_toggle_status');
function aiomatic_toggle_status()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $run_id = $_POST['id'];
    $wp_post = get_post($run_id);
    if($wp_post != null)
    {
        $aiomatic_Spinner_Settings = get_option('aiomatic_Spinner_Settings', false);
        if (isset($aiomatic_Spinner_Settings['custom_name']) && trim($aiomatic_Spinner_Settings['custom_name']) != '') {
            $custom_name = trim($aiomatic_Spinner_Settings['custom_name']);
        } else {
            $custom_name = 'aiomatic_published';
        }
        $metavalue = get_post_meta($run_id, $custom_name, true);
        if($metavalue == 'pub')
        {
            delete_post_meta($run_id, $custom_name);
        }
        else
        {
            update_post_meta($run_id, $custom_name, 'pub');
        }
    }
    die();
}
add_action('wp_ajax_aiomatic_delete_embedding', 'aiomatic_aiomatic_delete_embedding');
function aiomatic_aiomatic_delete_embedding()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong embedding deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['embeddingid']))
    {
        $aiomatic_result['msg'] = 'Field missing: embeddingid';
    }
    else
    {
        $embeddingid = $_POST['embeddingid'];
        if($embeddingid != '' && is_numeric($embeddingid))
        {
            $wp_post = get_post($embeddingid);
            if($wp_post != null)
            {
                $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
                {
                    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                    $appids = array_filter($appids);
                    $token = $appids[array_rand($appids)];
                    require_once(dirname(__FILE__) . "/res/Embeddings.php");
                    $embdedding = new Aiomatic_Embeddings($token);
                    $status = $embdedding->aiomatic_delete_embedding($embeddingid);
                    $aiomatic_result = $status;
                }
                else
                {
                    $aiomatic_result['msg'] = 'No app ID in plugin settings.';
                }
            }
            else
            {
                $aiomatic_result['msg'] = 'No post found with this ID: ' . $embeddingid;
            }
        }
        else
        {
            $aiomatic_result['msg'] = 'Blank embedding ID added';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_logs', 'aiomatic_delete_logs');
function aiomatic_delete_logs()
{
    $aiomatic_result = array('status' => 'success', 'msg' => 'Data deleted successfully');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $GLOBALS['aiomatic_stats']->clear_db();
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_user_logs', 'aiomatic_delete_user_logs');
function aiomatic_delete_user_logs()
{
    $aiomatic_result = array('status' => 'success', 'msg' => 'Data deleted successfully');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['delfor']) || empty($_POST['delfor']))
    {
        $aiomatic_result['status'] = 'fail';
        $aiomatic_result['msg'] = 'Empty username added in the request!';
        wp_send_json($aiomatic_result);
    }
    $userId = null;
    $user = get_user_by('login', $_POST['delfor']);
    if($user)
    {
        $userId = $user->ID;
    }
    else
    {
        $aiomatic_result['status'] = 'fail';
        $aiomatic_result['msg'] = 'Failed to get user ID for username: ' . $_POST['delfor'];
        wp_send_json($aiomatic_result);
    }
    $aiomatic_stats = new Aiomatic_Statistics();
    $aiomatic_stats->deleteUsageEntries('all', null, $userId, null, null);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_personas', 'aiomatic_personas');
function aiomatic_personas()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with AI Personas');
    check_ajax_referer('aiomatic_personas', 'nonce');
    if(!isset($_POST['aiomatic-persona-title']) || empty($_POST['aiomatic-persona-title']))
    {
        $aiomatic_result['msg'] = 'Empty persona title added!';
        wp_send_json($aiomatic_result);
    }
    $title = $_POST['aiomatic-persona-title'];
    if(!isset($_POST['aiomatic-persona-prompt']) || empty($_POST['aiomatic-persona-prompt']))
    {
        $aiomatic_result['msg'] = 'Empty persona prompt added!';
        wp_send_json($aiomatic_result);
    }
    $prompt = $_POST['aiomatic-persona-prompt'];
    $description = '';
    if(isset($_POST['aiomatic-persona-description']) && !empty($_POST['aiomatic-persona-description']))
    {
        $description = $_POST['aiomatic-persona-description'];
    }
    $first_message = '';
    if(isset($_POST['aiomatic-persona-first-message']) && !empty($_POST['aiomatic-persona-first-message']))
    {
        $first_message = $_POST['aiomatic-persona-first-message'];
    }
    $avatar = '';
    if(isset($_POST['aiomatic-persona-avatar']) && !empty($_POST['aiomatic-persona-avatar']))
    {
        $avatar = $_POST['aiomatic-persona-avatar'];
    }
    $aiomatic_result = aiomatic_save_persona($title, $prompt, $description, $first_message, $avatar);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_list_assistant_files', 'aiomatic_list_assistant_files');
function aiomatic_list_assistant_files()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning files');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for assistants.';
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
    $result = $open_ai->listFiles(array(
        'purpose' => 'assistants'
    ));
    $result = json_decode($result);
    if(isset($result->error)){
        $aiomatic_result['msg'] = $result->error->message;
    }
    else{
        if(isset($result->data) && is_array($result->data) && count($result->data))
        {
            foreach($result->data as $ind => $rd)
            {
                if($rd->purpose != 'assistants')
                {
                    unset($result->data[$ind]);
                }
            }
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['data'] = $result->data;
        }
        else{
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['data'] = array();
        }
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_list_batch_files', 'aiomatic_list_batch_files');
function aiomatic_list_batch_files()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with batch files');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for AI Batch Requests.';
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
    if(isset($result->error)){
        $aiomatic_result['msg'] = $result->error->message;
    }
    else{
        if(isset($result->data) && is_array($result->data) && count($result->data))
        {
            foreach($result->data as $ind => $rd)
            {
                if($rd->purpose != 'batch' && $rd->purpose != 'batch_output')
                {
                    unset($result->data[$ind]);
                }
            }
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['data'] = $result->data;
        }
        else{
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['data'] = array();
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_download_file', 'aiomatic_download_file');
function aiomatic_download_file()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with file downloading');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for this feature.';
        wp_send_json($aiomatic_result);
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
            $aiomatic_result['msg'] = 'Missing API Setting';
            wp_send_json($aiomatic_result);
            die();
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
                $aiomatic_result['msg'] = 'Error: ' . $json_parse->error->message;
                wp_send_json($aiomatic_result);
                die();
            }
            else
            {
                $file_info = $open_ai->retrieveFile($id); 
                $json_info_parse = json_decode($file_info);
                if(!isset($json_info_parse->filename))
                {
                    $aiomatic_result['msg'] = 'Error in file downloading: ' . print_r($json_info_parse, true);
                    wp_send_json($aiomatic_result);
                    die();
                }
                else
                {
                    $filename = $json_info_parse->filename;
                    $aiomatic_result['status'] = 'success';
                    $aiomatic_result['data'] = $result;
                    $aiomatic_result['filename'] = $filename;
                    wp_send_json($aiomatic_result);
                    die();
                }
            }
        }
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_parse_output', 'aiomatic_parse_output');
function aiomatic_parse_output()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with result parsing');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for finetunes.';
        wp_send_json($aiomatic_result);
        die();
    }
    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    $open_ai = new OpenAi($token);
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id']) && isset($_REQUEST['idin']) && !empty($_REQUEST['idin']) && isset($_REQUEST['endpoint']) && !empty($_REQUEST['endpoint'])) 
    {
        if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
        {
            $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
        }
        $id = sanitize_text_field($_REQUEST['id']);
        $idin = sanitize_text_field($_REQUEST['idin']);
        $endpoint = sanitize_text_field($_REQUEST['endpoint']);
        if (!$open_ai) {
            $aiomatic_result['msg'] = 'Missing API Setting';
            wp_send_json($aiomatic_result);
            die();
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
                $aiomatic_result['msg'] = 'Error: ' . $json_parse->error->message;
                wp_send_json($aiomatic_result);
                die();
            }
            else
            {
                if($delay != '' && is_numeric($delay))
                {
                    usleep($delay);
                }
                $result_in = $open_ai->retrieveFileContent($idin);
                $json_parse_in = json_decode($result_in);
                if(isset($json_parse_in->error)){
                    $aiomatic_result['msg'] = 'Error in input file reading: ' . $json_parse_in->error->message;
                    wp_send_json($aiomatic_result);
                    die();
                }
                else
                {
                    if($endpoint === '/v1/chat/completions')
                    {
                        $parsed_data = array(
                            'input' => $result_in,
                            'output' => $result
                        );
                        $formatted_result = aiomatic_format_parsed_data($parsed_data);
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['data'] = $formatted_result;
                        wp_send_json($aiomatic_result);
                        die();
                    }
                    else
                    {
                        $parsed_data = array(
                            'input' => $result_in,
                            'output' => $result
                        );
                        $formatted_result = aiomatic_format_parsed_embeddings_data($parsed_data);
                        $aiomatic_result['status'] = 'success';
                        $aiomatic_result['data'] = $formatted_result;
                        wp_send_json($aiomatic_result);
                        die();
                    }
                }
            }
        }
    }
    else
    {
        $aiomatic_result['msg'] = 'Incorrect request sent.';
        wp_send_json($aiomatic_result);
        die();
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_get_template_data', 'aiomatic_get_template_data');
function aiomatic_get_template_data()
{
    check_ajax_referer('openai-omni-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with template data');
    if(!isset($_POST['id']) || empty($_POST['id']))
    {
        $aiomatic_result['msg'] = 'Empty template id added!';
        wp_send_json($aiomatic_result);
    }
    $themeid = $_POST['id'];
    $formid = $_POST['formid'];
    $aiomatic_theme = get_post(sanitize_text_field($themeid));
    if($aiomatic_theme === null || $aiomatic_theme === 0)
    {
        $aiomatic_result['msg'] = 'Failed to get template ID: ' . print_r($themeid, true);
        wp_send_json($aiomatic_result);
    }
    else 
    {
        $json_back = get_post_meta($aiomatic_theme->ID, 'aiomatic_json', true);
        if(!empty($json_back))
        {
            $aiomatic_theme->post_content = $json_back;
        }
        if(empty($formid))
        {
            update_option('aiomatic_dafault_omni_template', $aiomatic_theme->ID, false);
            $aiomatic_result['msg'] = $aiomatic_theme->post_content;
            $aiomatic_result['status'] = 'success';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $aiomatic_result['msg'] = $aiomatic_theme->post_content;
            $aiomatic_result['status'] = 'success';
            wp_send_json($aiomatic_result);
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_save_seo_template', 'aiomatic_save_seo_template');
function aiomatic_save_seo_template() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $templates = get_option('aiomatic_templates', array());
    $template_name = sanitize_text_field($_POST['template_name']);
    $prompt = sanitize_textarea_field($_POST['prompt']);
    $templates[$template_name] = $prompt;
    update_option('aiomatic_templates', $templates);
    wp_send_json_success();
}
add_action('wp_ajax_aiomatic_load_seo_templates', 'aiomatic_load_seo_templates');
function aiomatic_load_seo_templates() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $templates = get_option('aiomatic_templates', array());
    wp_send_json_success($templates);
}
add_action('wp_ajax_aiomatic_load_seo_template', 'aiomatic_load_seo_template');
function aiomatic_load_seo_template() 
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $templates = get_option('aiomatic_templates', array());
    $template_name = sanitize_text_field($_POST['template_name']);
    if (isset($templates[$template_name])) {
        wp_send_json_success($templates[$template_name]);
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_aiomatic_delete_seo_template', 'aiomatic_delete_seo_template');
function aiomatic_delete_seo_template() {
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    
    $templates = get_option('aiomatic_templates', array());
    $template_name = sanitize_text_field($_POST['template_name']);
    
    if (isset($templates[$template_name])) {
        unset($templates[$template_name]);
        update_option('aiomatic_templates', $templates);
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_aiomatic_get_template_cat_data', 'aiomatic_get_template_cat_data');
function aiomatic_get_template_cat_data()
{
    check_ajax_referer('openai-omni-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with template category selection');
    if(!isset($_POST['id']))
    {
        $aiomatic_result['msg'] = 'Empty template category id added!';
        wp_send_json($aiomatic_result);
    }
    if(empty($_POST['id']))
    {
        $args = array(
            'post_type' => 'aiomatic_omni_temp',
            'posts_per_page' => -1
        );
        $return_arr = array();
        $the_query = new WP_Query($args);
        if ($the_query->have_posts())
        {
            while ($the_query->have_posts())
            {
                $the_query->the_post();
                $return_arr[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }
        $aiomatic_result['msg'] = $return_arr;
        $aiomatic_result['status'] = 'success';
        wp_send_json($aiomatic_result);
        die();
    }
    $themeid = $_POST['id'];
    $args = array(
        'post_type' => 'aiomatic_omni_temp',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'ai_template_categories',
                'field' => 'slug',
                'terms' => $themeid
            )
        )
    );
    $return_arr = array();
    $the_query = new WP_Query($args);
    if ($the_query->have_posts())
    {
        while ($the_query->have_posts())
        {
            $the_query->the_post();
            $return_arr[get_the_ID()] = get_the_title();
        }
        wp_reset_postdata();
    }
    $aiomatic_result['msg'] = $return_arr;
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_assistant_vector_store', 'aiomatic_delete_assistant_vector_store');
add_action('wp_ajax_nopriv_aiomatic_delete_assistant_vector_store', 'aiomatic_delete_assistant_vector_store');
function aiomatic_delete_assistant_vector_store()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning deletion');
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
        {
            $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for assistants.';
            wp_send_json($aiomatic_result);
        }
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
        $storeid = $_POST['storeid'];
        $store_del = aiomatic_openai_delete_vector_store($token, $storeid);
        if(isset($store_del->error))
        {
            $aiomatic_result['msg'] = $result->error->message;
            wp_send_json($aiomatic_result);
        }
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
        $result = $open_ai->deleteFile($_POST['id']);
        $result = json_decode($result);
        if(isset($result->error))
        {
            $aiomatic_result['msg'] = $result->error->message;
        }
        else
        {
            $aiomatic_result['status'] = 'success';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_delete_assistant_file', 'aiomatic_delete_assistant_file');
function aiomatic_delete_assistant_file()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with finetuning deletion');
    if(isset($_POST['id']) && !empty($_POST['id'])){
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
        $result = $open_ai->deleteFile($_POST['id']);
        $result = json_decode($result);
        if(isset($result->error))
        {
            $aiomatic_result['msg'] = $result->error->message;
        }
        else
        {
            $aiomatic_result['status'] = 'success';
        }
    }
    wp_send_json($aiomatic_result);
}
add_action('wp_ajax_aiomatic_assistant_file_upload', 'aiomatic_assistant_file_upload');
function aiomatic_assistant_file_upload()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with file uploading');
    if(isset($_FILES['file']) && empty($_FILES['file']['error'])){
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
        {
            $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for assistants.';
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
        $tmp_file = $_FILES['file']['tmp_name'];
        $c_file = curl_file_create($tmp_file, $_FILES['file']['type'], $file_name);
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
        $purpose = 'assistants';
        $result = $open_ai->uploadFile(array(
            'purpose' => $purpose,
            'file' => $c_file,
        ));
        $result = json_decode($result);
        if(isset($result->error)){
            $aiomatic_result['msg'] = $result->error->message;
        }
        else
        {
            $aiomatic_result['msg'] = $result->id;
            $aiomatic_result['status'] = 'success';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_batch_file_upload', 'aiomatic_batch_file_upload');
function aiomatic_batch_file_upload()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with file uploading');
    if(isset($_FILES['file']) && empty($_FILES['file']['error'])){
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
        {
            $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for batch API.';
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
        $tmp_file = $_FILES['file']['tmp_name'];
        $c_file = curl_file_create($tmp_file, $_FILES['file']['type'], $file_name);
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
        $purpose = 'batch';
        $result = $open_ai->uploadFile(array(
            'purpose' => $purpose,
            'file' => $c_file,
        ));
        $result = json_decode($result);
        if(isset($result->error)){
            $aiomatic_result['msg'] = $result->error->message;
        }
        else
        {
            $aiomatic_result['msg'] = $result->id;
            $aiomatic_result['status'] = 'success';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_assistants', 'aiomatic_assistants');
function aiomatic_assistants()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with AI Assistants');
    check_ajax_referer('aiomatic_assistants', 'nonce');
    $token = '';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
    }
    else
    {
        $aiomatic_result['msg'] = 'Please set up your API key in the plugin\' settings.';
        wp_send_json($aiomatic_result);
    }
    if(!isset($_POST['aiomatic-assistant-title']) || empty($_POST['aiomatic-assistant-title']))
    {
        $aiomatic_result['msg'] = 'Empty assistant title added!';
        wp_send_json($aiomatic_result);
    }
    $title = stripslashes($_POST['aiomatic-assistant-title']);
    if(!isset($_POST['aiomatic-assistant-prompt']) || empty($_POST['aiomatic-assistant-prompt']))
    {
        $prompt = '';
    }
    else
    {
        $prompt = stripslashes($_POST['aiomatic-assistant-prompt']);
    }
    if(!isset($_POST['aiomatic-assistant-model']) || empty($_POST['aiomatic-assistant-model']))
    {
        $aiomatic_result['msg'] = 'Empty assistant model added!';
        wp_send_json($aiomatic_result);
    }
    $code_interpreter = false;
    if(isset($_POST['aiomatic-assistant-code-interpreter']) && $_POST['aiomatic-assistant-code-interpreter'] == 'on')
    {
        $code_interpreter = true;
    }
    $file_search = false;
    if(isset($_POST['aiomatic-assistant-file_search']) && $_POST['aiomatic-assistant-file_search'] == 'on')
    {
        $file_search = true;
    }
    $model = stripslashes($_POST['aiomatic-assistant-model']);
    $description = '';
    if(isset($_POST['aiomatic-assistant-description']) && !empty($_POST['aiomatic-assistant-description']))
    {
        $description = stripslashes($_POST['aiomatic-assistant-description']);
    }
    $topp = '';
    if(isset($_POST['aiomatic-assistant-topp']) && !empty($_POST['aiomatic-assistant-topp']))
    {
        $topp = stripslashes($_POST['aiomatic-assistant-topp']);
    }
    $temperature = '';
    if(isset($_POST['aiomatic-assistant-temperature']) && !empty($_POST['aiomatic-assistant-temperature']))
    {
        $temperature = stripslashes($_POST['aiomatic-assistant-temperature']);
    }
    $assistant_first_message = '';
    if(isset($_POST['aiomatic-assistant-first-message']) && !empty($_POST['aiomatic-assistant-first-message']))
    {
        $assistant_first_message = stripslashes($_POST['aiomatic-assistant-first-message']);
    }
    $avatar = '';
    if(isset($_POST['aiomatic-assistant-avatar']))
    {
        $avatar = stripslashes($_POST['aiomatic-assistant-avatar']);
    }
    $functions = '';
    if(isset($_POST['aiomatic-assistant-functions']) && !empty($_POST['aiomatic-assistant-functions']))
    {
        $functions = stripslashes($_POST['aiomatic-assistant-functions']);
    }
    $assistant_files = [];
    if(isset($_POST['aiomatic-assistant-files']) && !empty($_POST['aiomatic-assistant-files']))
    {
        $assistant_files = $_POST['aiomatic-assistant-files'];
        if(is_array($assistant_files) && count($assistant_files) > 20)
        {
            $assistant_files = array_slice($assistant_files, 0, 20);
        }
    }
    $aiomatic_result = aiomatic_save_assistant($token, $title, $model, $prompt, $description, $temperature, $topp, $assistant_first_message, $avatar, $code_interpreter, $file_search, $assistant_files, $functions);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_batches', 'aiomatic_batches');
function aiomatic_batches()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with AI Batch Requests');
    check_ajax_referer('aiomatic_batches', 'nonce');
    $token = '';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
    }
    else
    {
        $aiomatic_result['msg'] = 'Please set up your API key in the plugin\' settings.';
        wp_send_json($aiomatic_result);
    }
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Only OpenAI API is supported for the Batches API';
        wp_send_json($aiomatic_result);
    }
    if(!isset($_POST['aiomatic-batch-file']) || empty($_POST['aiomatic-batch-file']))
    {
        $aiomatic_result['msg'] = 'Empty AI Batch Request File added!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_batch_file = $_POST['aiomatic-batch-file'];
    if(!isset($_POST['aiomatic-completion-window']) || empty($_POST['aiomatic-completion-window']))
    {
        $aiomatic_result['msg'] = 'Empty AI Completion Window added!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_completion_window = $_POST['aiomatic-completion-window'];
    if(!isset($_POST['aiomatic-endpoint']) || empty($_POST['aiomatic-endpoint']))
    {
        $aiomatic_result['msg'] = 'Empty AI Endpoint added!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_endpoint = $_POST['aiomatic-endpoint'];
    $aiomatic_result = aiomatic_save_batch($token, $aiomatic_batch_file, $aiomatic_completion_window, $aiomatic_endpoint);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_assistants_edit', 'aiomatic_assistants_edit');
function aiomatic_assistants_edit()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with AI Assistants editing');
    check_ajax_referer('aiomatic_assistants', 'nonce');
    $token = '';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
    }
    else
    {
        $aiomatic_result['msg'] = 'Please set up your API key in the plugin\' settings.';
        wp_send_json($aiomatic_result);
    }
    if(!isset($_POST['aiomatic-assistant-title']) || empty($_POST['aiomatic-assistant-title']))
    {
        $aiomatic_result['msg'] = 'Empty assistant title added!';
        wp_send_json($aiomatic_result);
    }
    $title = stripslashes($_POST['aiomatic-assistant-title']);
    if(!isset($_POST['assistant_id']) || empty($_POST['assistant_id']))
    {
        $aiomatic_result['msg'] = 'Incorrect request provided!';
        wp_send_json($aiomatic_result);
    }
    $assistant_id_local = stripslashes($_POST['assistant_id']);
    $assistant_id = get_post_meta($assistant_id_local, '_assistant_id', true);
    if(empty($assistant_id))
    {
        $aiomatic_result['msg'] = 'Assistant ID was not found in the database!';
        wp_send_json($aiomatic_result);
    }
    if(!isset($_POST['aiomatic-assistant-prompt']) || empty($_POST['aiomatic-assistant-prompt']))
    {
        $prompt = '';
    }
    else
    {
        $prompt = stripslashes($_POST['aiomatic-assistant-prompt']);
    }
    if(!isset($_POST['aiomatic-assistant-model']) || empty($_POST['aiomatic-assistant-model']))
    {
        $aiomatic_result['msg'] = 'Empty assistant model added!';
        wp_send_json($aiomatic_result);
    }
    $code_interpreter = false;
    if(isset($_POST['aiomatic-assistant-code-interpreter']) && $_POST['aiomatic-assistant-code-interpreter'] == 'on')
    {
        $code_interpreter = true;
    }
    $file_search = false;
    if(isset($_POST['aiomatic-assistant-file_search']) && $_POST['aiomatic-assistant-file_search'] == 'on')
    {
        $file_search = true;
    }
    $model = stripslashes($_POST['aiomatic-assistant-model']);
    $description = '';
    if(isset($_POST['aiomatic-assistant-description']) && !empty($_POST['aiomatic-assistant-description']))
    {
        $description = stripslashes($_POST['aiomatic-assistant-description']);
    }
    $topp = '';
    if(isset($_POST['aiomatic-assistant-topp']) && !empty($_POST['aiomatic-assistant-topp']))
    {
        $topp = stripslashes($_POST['aiomatic-assistant-topp']);
    }
    $temperature = '';
    if(isset($_POST['aiomatic-assistant-temperature']) && !empty($_POST['aiomatic-assistant-temperature']))
    {
        $temperature = stripslashes($_POST['aiomatic-assistant-temperature']);
    }
    $assistant_first_message = '';
    if(isset($_POST['aiomatic-assistant-first-message']) && !empty($_POST['aiomatic-assistant-first-message']))
    {
        $assistant_first_message = stripslashes($_POST['aiomatic-assistant-first-message']);
    }
    $avatar = '';
    if(isset($_POST['aiomatic-assistant-avatar']))
    {
        $avatar = stripslashes($_POST['aiomatic-assistant-avatar']);
    }
    $functions = '';
    if(isset($_POST['aiomatic-assistant-functions']) && !empty($_POST['aiomatic-assistant-functions']))
    {
        $functions = stripslashes($_POST['aiomatic-assistant-functions']);
    }
    $assistant_files = [];
    if(isset($_POST['aiomatic-assistant-files']) && !empty($_POST['aiomatic-assistant-files']))
    {
        $assistant_files = $_POST['aiomatic-assistant-files'];
        if(is_array($assistant_files) && count($assistant_files) > 20)
        {
            $assistant_files = array_slice($assistant_files, 0, 20);
        }
    }
    $aiomatic_result = aiomatic_update_assistant($token, $assistant_id, $assistant_id_local, $title, $model, $prompt, $description, $temperature, $topp, $assistant_first_message, $avatar, $code_interpreter, $file_search, $assistant_files, $functions);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_forms', 'aiomatic_forms');
function aiomatic_forms()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with AI forms');
    check_ajax_referer('aiomatic_forms', 'nonce');
    $formid = '';
    if(isset($_POST['formid']) && !empty($_POST['formid']))
    {
        $formid = $_POST['formid'];
    }
    if(!isset($_POST['aiomatic-form-title']) || empty($_POST['aiomatic-form-title']))
    {
        $aiomatic_result['msg'] = 'Empty form title added!';
        wp_send_json($aiomatic_result);
    }
    $title = $_POST['aiomatic-form-title'];
    if(!isset($_POST['aiomatic-form-prompt']) || empty($_POST['aiomatic-form-prompt']))
    {
        $aiomatic_result['msg'] = 'Empty form prompt added!';
        wp_send_json($aiomatic_result);
    }
    $prompt = $_POST['aiomatic-form-prompt'];
    if(!isset($_POST['aiomatic-form-model']) || empty($_POST['aiomatic-form-model']))
    {
        $aiomatic_result['msg'] = 'Empty form model added!';
        wp_send_json($aiomatic_result);
    }
    $model = $_POST['aiomatic-form-model'];
    if(!isset($_POST['aiomatic-form-stream']) || (empty($_POST['aiomatic-form-stream']) && $_POST['aiomatic-form-stream'] !== '0'))
    {
        $aiomatic_result['msg'] = 'Empty form stream added!';
        wp_send_json($aiomatic_result);
    }
    $streaming_enabled = $_POST['aiomatic-form-stream'];
    if(isset($_POST['aiomatic-form-assistant-id']))
    {
        $assistant_id = $_POST['aiomatic-form-assistant-id'];
    }
    else
    {
        $assistant_id = '';
    }
    if(!isset($_POST['aiomatic-header']) || empty($_POST['aiomatic-header']))
    {
        $aiomatic_result['msg'] = 'Empty form header state added!';
        wp_send_json($aiomatic_result);
    }
    $header = $_POST['aiomatic-header'];
    if(!isset($_POST['aiomatic-editor']) || empty($_POST['aiomatic-editor']))
    {
        $_POST['aiomatic-editor'] = 'textarea';
    }
    $editor = $_POST['aiomatic-editor'];
    if(!isset($_POST['aiomatic-advanced']) || empty($_POST['aiomatic-advanced']))
    {
        $_POST['aiomatic-advanced'] = 'hide';
    }
    $advanced = $_POST['aiomatic-advanced'];
    if(!isset($_POST['aiomatic-submit']) || empty($_POST['aiomatic-submit']))
    {
        $aiomatic_result['msg'] = 'Empty form submit text added!';
        wp_send_json($aiomatic_result);
    }
    $submit = $_POST['aiomatic-submit'];
    $description = '';
    if(isset($_POST['aiomatic-form-description']) && !empty($_POST['aiomatic-form-description']))
    {
        $description = $_POST['aiomatic-form-description'];
    }
    $response = '';
    if(isset($_POST['aiomatic-form-response']) && !empty($_POST['aiomatic-form-response']))
    {
        $response = $_POST['aiomatic-form-response'];
    }
    $max = '';
    if(isset($_POST['aiomatic-max']) && !empty($_POST['aiomatic-max']))
    {
        $max = $_POST['aiomatic-max'];
    }
    $temperature = '';
    if(isset($_POST['aiomatic-temperature']) && !empty($_POST['aiomatic-temperature']))
    {
        $temperature = $_POST['aiomatic-temperature'];
    }
    $topp = '';
    if(isset($_POST['aiomatic-topp']) && !empty($_POST['aiomatic-topp']))
    {
        $topp = $_POST['aiomatic-topp'];
    }
    $presence = '';
    if(isset($_POST['aiomatic-presence']) && !empty($_POST['aiomatic-presence']))
    {
        $presence = $_POST['aiomatic-presence'];
    }
    $frequency = '';
    if(isset($_POST['aiomatic-frequency']) && !empty($_POST['aiomatic-frequency']))
    {
        $frequency = $_POST['aiomatic-frequency'];
    }
    $type = '';
    if(isset($_POST['aiomatic-type']) && !empty($_POST['aiomatic-type']))
    {
        $type = $_POST['aiomatic-type'];
    }
    $aiomaticfields = array();
    if(isset($_POST['aiomaticfields']) && !empty($_POST['aiomaticfields']))
    {
        $aiomaticfields = $_POST['aiomaticfields'];
    }
    $aiomatic_result = aiomatic_save_forms($formid, $title, $prompt, $model, $header, $submit, $description, $response, $max, $temperature, $topp, $presence, $frequency, $type, $aiomaticfields, $assistant_id, $streaming_enabled, $editor, $advanced);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_deleteall_forms', 'aiomatic_deleteall_forms');
function aiomatic_deleteall_forms()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with general form deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $allposts = get_posts( array('post_type'=>'aiomatic_forms','numberposts'=>-1) );
    foreach ($allposts as $eachpost) {
        wp_delete_post( $eachpost->ID, true );
    }
    $aiomatic_result['msg'] = 'Successfully deleted all forms!';
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_deleteall_personas', 'aiomatic_deleteall_personas');
function aiomatic_deleteall_personas()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with general persona deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $allposts = get_posts( array('post_type'=>'aiomatic_personas','numberposts'=>-1) );
    foreach ($allposts as $eachpost) {
        wp_delete_post( $eachpost->ID, true );
    }
    $aiomatic_result['msg'] = 'Successfully deleted all personas!';
    $aiomatic_result['status'] = 'success';
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_save_theme', 'aiomatic_save_theme');
function aiomatic_save_theme()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with theme saving');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['post_title']) || empty($_POST['post_title']))
    {
        $aiomatic_result['msg'] = 'Empty form post_title added!';
        wp_send_json($aiomatic_result);
    }
    $post_title = $_POST['post_title'];
    if(!isset($_POST['general_background']) || empty($_POST['general_background']))
    {
        $aiomatic_result['msg'] = 'Empty form general_background added!';
        wp_send_json($aiomatic_result);
    }
    $general_background = $_POST['general_background'];
    if(!isset($_POST['background']) || empty($_POST['background']))
    {
        $aiomatic_result['msg'] = 'Empty form background added!';
        wp_send_json($aiomatic_result);
    }
    $background = $_POST['background'];
    if(!isset($_POST['input_border_color']) || empty($_POST['input_border_color']))
    {
        $aiomatic_result['msg'] = 'Empty form input_border_color added!';
        wp_send_json($aiomatic_result);
    }
    $input_border_color = $_POST['input_border_color'];
    if(!isset($_POST['input_text_color']) || empty($_POST['input_text_color']))
    {
        $aiomatic_result['msg'] = 'Empty form input_text_color added!';
        wp_send_json($aiomatic_result);
    }
    $input_text_color = $_POST['input_text_color'];
    if(!isset($_POST['persona_name_color']) || empty($_POST['persona_name_color']))
    {
        $aiomatic_result['msg'] = 'Empty form persona_name_color added!';
        wp_send_json($aiomatic_result);
    }
    $persona_name_color = $_POST['persona_name_color'];
    if(!isset($_POST['persona_role_color']) || empty($_POST['persona_role_color']))
    {
        $aiomatic_result['msg'] = 'Empty form persona_role_color added!';
        wp_send_json($aiomatic_result);
    }
    $persona_role_color = $_POST['persona_role_color'];
    if(!isset($_POST['input_placeholder_color']) || empty($_POST['input_placeholder_color']))
    {
        $aiomatic_result['msg'] = 'Empty form input_placeholder_color added!';
        wp_send_json($aiomatic_result);
    }
    $input_placeholder_color = $_POST['input_placeholder_color'];
    if(!isset($_POST['user_background_color']) || empty($_POST['user_background_color']))
    {
        $aiomatic_result['msg'] = 'Empty form user_background_color added!';
        wp_send_json($aiomatic_result);
    }
    $user_background_color = $_POST['user_background_color'];
    if(!isset($_POST['ai_background_color']) || empty($_POST['ai_background_color']))
    {
        $aiomatic_result['msg'] = 'Empty form ai_background_color added!';
        wp_send_json($aiomatic_result);
    }
    $ai_background_color = $_POST['ai_background_color'];
    if(!isset($_POST['ai_font_color']) || empty($_POST['ai_font_color']))
    {
        $aiomatic_result['msg'] = 'Empty form ai_font_color added!';
        wp_send_json($aiomatic_result);
    }
    $ai_font_color = $_POST['ai_font_color'];
    if(!isset($_POST['user_font_color']) || empty($_POST['user_font_color']))
    {
        $aiomatic_result['msg'] = 'Empty form user_font_color added!';
        wp_send_json($aiomatic_result);
    }
    $user_font_color = $_POST['user_font_color'];
    if(!isset($_POST['submit_color']) || empty($_POST['submit_color']))
    {
        $aiomatic_result['msg'] = 'Empty form submit_color added!';
        wp_send_json($aiomatic_result);
    }
    $submit_color = $_POST['submit_color'];
    if(!isset($_POST['voice_color']) || empty($_POST['voice_color']))
    {
        $aiomatic_result['msg'] = 'Empty form voice_color added!';
        wp_send_json($aiomatic_result);
    }
    $voice_color = $_POST['voice_color'];
    if(!isset($_POST['voice_color_activated']) || empty($_POST['voice_color_activated']))
    {
        $aiomatic_result['msg'] = 'Empty form voice_color_activated added!';
        wp_send_json($aiomatic_result);
    }
    $voice_color_activated = $_POST['voice_color_activated'];
    if(!isset($_POST['submit_text_color']) || empty($_POST['submit_text_color']))
    {
        $aiomatic_result['msg'] = 'Empty form submit_text_color added!';
        wp_send_json($aiomatic_result);
    }
    $submit_text_color = $_POST['submit_text_color'];
    $encode_arr = array(
        'general_background' => $general_background,
        'background' => $background,
        'input_border_color' => $input_border_color,
        'input_text_color' => $input_text_color,
        'persona_name_color' => $persona_name_color,
        'persona_role_color' => $persona_role_color,
        'input_placeholder_color' => $input_placeholder_color,
        'user_background_color' => $user_background_color,
        'ai_background_color' => $ai_background_color,
        'ai_font_color' => $ai_font_color,
        'user_font_color' => $user_font_color,
        'submit_color' => $submit_color,
        'voice_color' => $voice_color,
        'voice_color_activated' => $voice_color_activated,
        'submit_text_color' => $submit_text_color,
    );
    $json_save = json_encode($encode_arr);
    $themes_data = array(
        'post_type' => 'aiomatic_themes',
        'post_title' => $post_title,
        'post_content' => $json_save,
        'post_status' => 'publish'
    );
    remove_filter('content_save_pre', 'wp_filter_post_kses');
    remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
    $themes_id = wp_insert_post($themes_data);
    add_filter('content_save_pre', 'wp_filter_post_kses');
    add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
    if(is_wp_error($themes_id))
    {
        $aiomatic_result['msg'] = 'Failed to import form: ' . $themes_id->get_error_message();
        wp_send_json($aiomatic_result);
    }
    elseif($themes_id === 0)
    {
        $aiomatic_result['msg'] = 'Failed to insert form to database: ' . print_r($themes_data, true);
        wp_send_json($aiomatic_result);
    }
    else 
    {
        $aiomatic_result['msg'] = 'Successfully deleted all personas!';
        $aiomatic_result['status'] = 'success';
        wp_send_json($aiomatic_result);
    }
    die();
}
add_action('wp_ajax_aiomatic_get_theme', 'aiomatic_get_theme');
function aiomatic_get_theme()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with theme getting');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['themeid']) || empty($_POST['themeid']))
    {
        $aiomatic_result['msg'] = 'Empty form themeid added!';
        wp_send_json($aiomatic_result);
    }
    $themeid = $_POST['themeid'];
    $aiomatic_theme = get_post(sanitize_text_field($themeid));
    if($aiomatic_theme === null || $aiomatic_theme === 0)
    {
        $aiomatic_result['msg'] = 'Failed to get theme ID: ' . print_r($themeid, true);
        wp_send_json($aiomatic_result);
    }
    else 
    {
        $aiomatic_result['msg'] = $aiomatic_theme->post_content;
        $aiomatic_result['status'] = 'success';
        wp_send_json($aiomatic_result);
    }
    die();
}
add_action('wp_ajax_aiomatic_delete_theme', 'aiomatic_delete_theme');
function aiomatic_delete_theme()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with theme deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['themeid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        wp_delete_post($_POST['themeid']);
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['msg'] = 'Theme deleted successfully';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_selected_form', 'aiomatic_delete_selected_form');
function aiomatic_delete_selected_form()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with form deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $deleted = false;
        if(count($_POST['ids'])) 
        {
            foreach ($_POST['ids'] as $id)
            {
                wp_delete_post($id);
                $deleted = true;
            }
        }
        if($deleted === true)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'Forms deleted successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_selected_personas', 'aiomatic_delete_selected_personas');
function aiomatic_delete_selected_personas()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with persona deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $deleted = false;
        if(count($_POST['ids'])) 
        {
            foreach ($_POST['ids'] as $id)
            {
                wp_delete_post($id);
                $deleted = true;
            }
        }
        if($deleted === true)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'Personas deleted successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_selected_assistants', 'aiomatic_delete_selected_assistants');
function aiomatic_delete_selected_assistants()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with assistant deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $token = '';
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
        }
        else
        {
            $aiomatic_result['msg'] = 'Please set up your API key in the plugin\' settings.';
            wp_send_json($aiomatic_result);
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
        $deleted = false;
        $errors = '';
        if(count($_POST['ids'])) 
        {
            foreach ($_POST['ids'] as $id)
            {
                $assistant_id = get_post_meta($id, '_assistant_id', true);
                if(!empty($assistant_id))
                {
                    try
                    {
                        aiomatic_openai_delete_assistant($token, $assistant_id);
                    }
                    catch(Exception $e)
                    {
                        $errors .= 'Failed to delete assistant ID: ' . $assistant_id . ', exception: ' . $e->getMessage() . '\n';
                    }
                }
                $vector_store_id = get_post_meta($id, '_assistant_vector_store_id', true);
                if(!empty($vector_store_id))
                {
                    aiomatic_openai_delete_vector_store($token, $vector_store_id);
                }
                wp_delete_post($id);
                $deleted = true;
            }
        }
        if(!empty($errors))
        {
            $aiomatic_result['msg'] = 'Assistant failed to be deleted: ' . $errors;
            wp_send_json($aiomatic_result);
        }
        if($deleted === true)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'Assistant deleted successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_selected_templates', 'aiomatic_delete_selected_templates');
function aiomatic_delete_selected_templates()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with OmniBlock template deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $deleted = false;
        if(count($_POST['ids'])) 
        {
            foreach ($_POST['ids'] as $id)
            {
                wp_delete_post($id);
                $deleted = true;
            }
        }
        if($deleted === true)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'OmniBlock templates deleted successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_selected_files', 'aiomatic_delete_selected_files');
function aiomatic_delete_selected_files()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with OmniBlock file deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $deleted = false;
        if(count($_POST['ids'])) 
        {
            foreach ($_POST['ids'] as $id)
            {
                $this_post = get_post($id);
                if($this_post === null)
                {
                    $aiomatic_result['msg'] = 'Incorrect post_id sent';
                    wp_send_json($aiomatic_result);
                }
                $local_id = get_post_meta($id, 'local_id', true);
                if(empty($local_id))
                {
                    $aiomatic_result['msg'] = 'Local file path not found';
                    wp_send_json($aiomatic_result);
                }
                $file_type = '';
                $terms = wp_get_object_terms( $id, 'ai_file_type' );
                if(!is_wp_error($terms))
                {
                    foreach($terms as  $tm)
                    {
                        $file_type = $tm->slug;
                        break;
                    }
                }
                if($file_type == 'local')
                {
                    global $wp_filesystem;
                    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                        wp_filesystem($creds);
                    }
                    $wp_filesystem->delete($local_id);
                }
                elseif($file_type == 'amazon')
                {
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                    {
                        $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['bucket_name']) || trim($aiomatic_Main_Settings['bucket_name']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Amazon S3 bucket_name for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['s3_user']) || trim($aiomatic_Main_Settings['s3_user']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Amazon S3 s3_user for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['s3_pass']) || trim($aiomatic_Main_Settings['s3_pass']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Amazon S3 s3_pass for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['bucket_region']) || trim($aiomatic_Main_Settings['bucket_region']) == '')
                    {
                        $aiomatic_Main_Settings['bucket_region'] = 'eu-central-1';
                    }
                    try
                    {
                        $credentials = array('key' => trim($aiomatic_Main_Settings['s3_user']), 'secret' => trim($aiomatic_Main_Settings['s3_pass']));
                        $s3 = new S3Client([
                            'version' => 'latest',
                            'region'  => trim($aiomatic_Main_Settings['bucket_region']),
                            'credentials' => $credentials
                        ]);
                    }
                    catch(Exception $e)
                    {
                        $aiomatic_result['msg'] = 'Failed to initialize Amazon S3 API: ' . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    }
                    try 
                    {
                        $obj_arr = [
                            'Bucket' => trim($aiomatic_Main_Settings['bucket_name']),
                            'Key'    => $local_id,
                        ];
                        $awsret = $s3->deleteObject($obj_arr);
                        if(!isset($awsret['DeleteMarker']))
                        {
                            $aiomatic_result['msg'] = "Failed to decode Amazon S3 API response: " . print_r($awsret, true);
                            wp_send_json($aiomatic_result);
                        }
                    } 
                    catch (Exception $e) 
                    {
                        $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to Amazon S3: " . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    } 
                }
                elseif($file_type == 'wasabi')
                {
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                    {
                        $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['wasabi_bucket']) || trim($aiomatic_Main_Settings['wasabi_bucket']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_bucket for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['wasabi_user']) || trim($aiomatic_Main_Settings['wasabi_user']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_user for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['wasabi_pass']) || trim($aiomatic_Main_Settings['wasabi_pass']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_pass for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['wasabi_region']) || trim($aiomatic_Main_Settings['wasabi_region']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_region for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    try
                    {
                        $credentials = array('key' => trim($aiomatic_Main_Settings['wasabi_user']), 'secret' => trim($aiomatic_Main_Settings['wasabi_pass']));
                        $s3 = new S3Client([
                            'endpoint' => "https://" . trim($aiomatic_Main_Settings['wasabi_bucket']) . ".s3." . trim($aiomatic_Main_Settings['wasabi_region']) . ".wasabisys.com/",
                            'bucket_endpoint' => true,
                            'version' => 'latest',
                            'region'  => trim($aiomatic_Main_Settings['wasabi_region']),
                            'credentials' => $credentials
                        ]);
                    }
                    catch(Exception $e)
                    {
                        $aiomatic_result['msg'] = 'Failed to initialize Wasabi API: ' . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    }
                    try 
                    {
                        $obj_arr = [
                            'Bucket' => trim($aiomatic_Main_Settings['wasabi_bucket']),
                            'Key'    => $local_id,
                        ];
                        $awsret = $s3->deleteObject($obj_arr);
                        if(!isset($awsret['DeleteMarker']))
                        {
                            $aiomatic_result['msg'] = "Failed to decode Wasabi API response: " . print_r($awsret, true);
                            wp_send_json($aiomatic_result);
                        }
                    } 
                    catch (Exception $e) 
                    {
                        $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to Wasabi: " . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    } 
                }
                elseif($file_type == 'cloudflare')
                {
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                    {
                        $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['cloud_bucket']) || trim($aiomatic_Main_Settings['cloud_bucket']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_bucket for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['cloud_user']) || trim($aiomatic_Main_Settings['cloud_user']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_user for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['cloud_pass']) || trim($aiomatic_Main_Settings['cloud_pass']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_pass for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['cloud_account']) || trim($aiomatic_Main_Settings['cloud_account']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_account for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    try
                    {
                        $credentials = array('key' => trim($aiomatic_Main_Settings['cloud_user']), 'secret' => trim($aiomatic_Main_Settings['cloud_pass']));
                        $s3 = new S3Client([
                            'endpoint' => "https://" . trim($aiomatic_Main_Settings['cloud_account']) . ".r2.cloudflarestorage.com",
                            'bucket_endpoint' => true,
                            'version' => 'latest',
                            'region' => 'us-east-1',
                            'credentials' => $credentials
                        ]);
                    }
                    catch(Exception $e)
                    {
                        $aiomatic_result['msg'] = 'Failed to initialize CloudFlare API: ' . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    }
                    try 
                    {
                        $obj_arr = [
                            'Bucket' => trim($aiomatic_Main_Settings['cloud_bucket']),
                            'Key'    => $local_id,
                        ];
                        $awsret = $s3->deleteObject($obj_arr);
                        if(!isset($awsret['DeleteMarker']))
                        {
                            $aiomatic_result['msg'] = "Failed to decode CloudFlare API response: " . print_r($awsret, true);
                            wp_send_json($aiomatic_result);
                        }
                    } 
                    catch (Exception $e) 
                    {
                        $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to CloudFlare: " . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    } 
                }
                elseif($file_type == 'digital')
                {
                    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
                    if(!function_exists('is_plugin_active'))
                    {
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    }
                    if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
                    {
                        $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['digital_endpoint']) || trim($aiomatic_Main_Settings['digital_endpoint']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Digital Ocean digital_endpoint for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['digital_user']) || trim($aiomatic_Main_Settings['digital_user']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Digital Ocean digital_user for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    if (!isset($aiomatic_Main_Settings['digital_pass']) || trim($aiomatic_Main_Settings['digital_pass']) == '')
                    {
                        $aiomatic_result['msg'] = 'You need to enter a Digital Ocean digital_pass for this to work!';
                        wp_send_json($aiomatic_result);
                    }
                    $bucket_name = '';
                    preg_match_all('#https:\/\/([^.]*?)\.(?:[^.]*?)\.digitaloceanspaces\.com#i', trim($aiomatic_Main_Settings['digital_endpoint']), $zmatches);
                    if(isset($zmatches[1][0]))
                    {
                        $bucket_name = $zmatches[1][0];
                    }
                    else
                    {
                        $aiomatic_result['msg'] = 'Failed to parse Digital Ocean Spaces URL: ' . trim($aiomatic_Main_Settings['digital_endpoint']);
                        wp_send_json($aiomatic_result);
                    }
                    $endpoint_plain_url = preg_replace('#https?:\/\/([^.]*?\.)([^.]*?)\.digitaloceanspaces\.com#i', 'https://$2.digitaloceanspaces.com', trim($aiomatic_Main_Settings['digital_endpoint']));
                    try
                    {
                        $credentials = array('key' => trim($aiomatic_Main_Settings['digital_user']), 'secret' => trim($aiomatic_Main_Settings['digital_pass']));
                        $s3 = new S3Client([
                            'version' => 'latest',
                            'region'  => 'us-east-1',
                            'endpoint' => $endpoint_plain_url,
                            'use_path_style_endpoint' => false,
                            'credentials' => $credentials
                        ]);
                    }
                    catch(Exception $e)
                    {
                        $aiomatic_result['msg'] = 'Failed to initialize Digital Ocean API: ' . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    }
                    try 
                    {
                        $obj_arr = [
                            'Bucket' => trim($bucket_name),
                            'Key'    => $local_id,
                        ];
                        $awsret = $s3->deleteObject($obj_arr);
                        if(!isset($awsret['DeleteMarker']))
                        {
                            $aiomatic_result['msg'] = "Failed to decode Digital Ocean API response: " . print_r($awsret, true);
                            wp_send_json($aiomatic_result);
                        }
                    } 
                    catch (Exception $e) 
                    {
                        $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to Digital Ocean: " . $e->getMessage();
                        wp_send_json($aiomatic_result);
                    } 
                }
                wp_delete_post($id);
                $deleted = true;
            }
        }
        if($deleted === true)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'OmniBlock files deleted successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_save_omni_template', 'aiomatic_save_omni_template');
function aiomatic_save_omni_template()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with OmniBlock template creation');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['omni_template_new'])  || empty($_POST['omni_template_new']) || !isset($_POST['omni_template_cat_new']) || !isset($_POST['sortable_cards_new']) || empty($_POST['sortable_cards_new']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $ai_data = array(
            'post_type' => 'aiomatic_omni_temp',
            'post_title' => $_POST['omni_template_new'],
            'post_content' => $_POST['sortable_cards_new'],
            'post_status' => 'publish'
        );
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $omni_id = wp_insert_post($ai_data);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($omni_id))
        {
            aiomatic_log_to_file('Failed to insert OmniBlock template: ' . $omni_id->get_error_message());
        }
        elseif($omni_id === 0)
        {
            aiomatic_log_to_file('Failed to insert OmniBlock template: ' . print_r($ai_data, true));
        }
        else 
        {
            update_post_meta($omni_id, 'aiomatic_json', $_POST['sortable_cards_new']);
            if(trim($_POST['omni_template_cat_new']) != '')
            {
                $cats = $_POST['omni_template_cat_new'];
                $cat_arr = explode(';', $cats);
                $cat_arr = array_map('trim', $cat_arr);
                wp_set_object_terms($omni_id, $cat_arr, 'ai_template_categories');
            }
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'OmniBlock template inserted successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_save_omni_template_edit', 'aiomatic_save_omni_template_edit');
function aiomatic_save_omni_template_edit()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with OmniBlock template creation');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['omni_template_edit'])  || empty($_POST['omni_template_edit']) || !isset($_POST['omni_template_cat_edit']) || !isset($_POST['sortable_cards_edit']) || empty($_POST['sortable_cards_edit']) || !isset($_POST['omni_template_id']) || empty($_POST['omni_template_id']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $ai_data = array(
            'post_type'    => 'aiomatic_omni_temp',
            'post_title'   => $_POST['omni_template_edit'],
            'post_content' => $_POST['sortable_cards_edit'],
            'ID'           => $_POST['omni_template_id'],
            'post_status'  => 'publish'
        );
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $omni_id = wp_update_post($ai_data);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($omni_id))
        {
            aiomatic_log_to_file('Failed to update OmniBlock template: ' . $omni_id->get_error_message());
        }
        elseif($omni_id === 0)
        {
            aiomatic_log_to_file('Failed to update OmniBlock template: ' . print_r($ai_data, true));
        }
        else 
        {
            update_post_meta($omni_id, 'aiomatic_json', $_POST['sortable_cards_edit']);
            if(trim($_POST['omni_template_cat_edit']) != '')
            {
                $cats = $_POST['omni_template_cat_edit'];
                $cat_arr = explode(';', $cats);
                $cat_arr = array_map('trim', $cat_arr);
                wp_set_object_terms($omni_id, $cat_arr, 'ai_template_categories');
            }
            else
            {
                wp_set_object_terms($omni_id, array(), 'ai_template_categories');
            }
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = 'OmniBlock template updated successfully';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_sync_assistants', 'aiomatic_sync_assistants');
function aiomatic_sync_assistants()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with assistant importing');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $token = '';
    $imported = false;
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
    }
    else
    {
        $aiomatic_result['msg'] = 'Please set up your API key in the plugin\' settings.';
        wp_send_json($aiomatic_result);
    }
    require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
    try
    {
        $all_assistants = aiomatic_openai_list_assistants($token);
        if(empty($all_assistants))
        {
            $aiomatic_result['msg'] = 'No assistants to import.';
            wp_send_json($aiomatic_result);
        }
        foreach($all_assistants as $my_assistant)
        {
            $vector_store_id = '';
            if(isset($my_assistant['tool_resources']['file_search']['vector_store_ids'][0]))
            {
                $vector_store_id = $my_assistant['tool_resources']['file_search']['vector_store_ids'][0];
            }
            $file_ids = array();
            if(isset($my_assistant['tool_resources']['code_interpreter']['file_ids'][0]))
            {
                $file_ids = $my_assistant['tool_resources']['code_interpreter']['file_ids'];
            }
            $result = aiomatic_save_assistant_only_local($token, $my_assistant['name'], $my_assistant['model'], $my_assistant['instructions'], $my_assistant['description'], $my_assistant['temperature'], $my_assistant['top_p'], '', '', $file_ids, $my_assistant['id'], $my_assistant['created_at'], $my_assistant['tools'], $vector_store_id);
            if(!isset($result['id']))
            {
                $aiomatic_result['msg'] = 'Failed to import assistant: ' . print_r($result, true);
            }
            else
            {
                $imported = true;
            }
        }
    }
    catch(Exception $e)
    {
        $aiomatic_result['msg'] = 'Exception while importing assistants: ' . $e->getMessage();
    }
    if($imported === true)
    {
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['msg'] = 'Assistant imported successfully';
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_sync_batches', 'aiomatic_sync_batches');
function aiomatic_sync_batches()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with batch request importing');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $token = '';
    $imported = false;
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
    }
    else
    {
        $aiomatic_result['msg'] = 'Please set up your API key in the plugin\' settings.';
        wp_send_json($aiomatic_result);
    }
    require_once (dirname(__FILE__) . "/res/aiomatic-batch-api.php"); 
    try
    {
        $all_batches = aiomatic_openai_list_batches($token);
        if(empty($all_batches))
        {
            $aiomatic_result['msg'] = 'No batch requests to import.';
            wp_send_json($aiomatic_result);
        }
        foreach($all_batches as $my_batch)
        {
            $result = aiomatic_save_batch_only_local($token, $my_batch);
            if(!isset($result['id']))
            {
                $aiomatic_result['msg'] = 'Failed to import AI Batch Request: ' . print_r($result, true);
            }
            else
            {
                $imported = true;
            }
        }
    }
    catch(Exception $e)
    {
        $aiomatic_result['msg'] = 'Exception while importing batch requests: ' . $e->getMessage();
    }
    if($imported === true)
    {
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['msg'] = 'AI Batch Requests imported successfully';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_all_batches', 'aiomatic_delete_all_batches');
function aiomatic_delete_all_batches()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with batch request importing');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $post_type = 'aiomatic_batches';
    $posts = get_posts(array(
        'post_type' => $post_type,
        'numberposts' => -1,
        'post_status' => 'any'
    ));
    $deleted = false;
    foreach ($posts as $post) {
        wp_delete_post($post->ID, true);
        $deleted = true;
    }
    if($deleted === true)
    {
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['msg'] = 'AI Batch Requests deleted successfully';
    }
    if($deleted === false)
    {
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['msg'] = 'No AI Batch Requests to delete';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_get_persona', 'aiomatic_get_persona');
function aiomatic_get_persona()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with persona query');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $persona = false;
        $aiomatic_persona = get_post($_POST['ids'], ARRAY_A);
        if ($aiomatic_persona) 
        {
            $avatar = get_the_post_thumbnail_url($aiomatic_persona['ID'], 'thumbnail');
            $avatarid = get_post_thumbnail_id($aiomatic_persona['ID']);
            $message = get_post_meta($aiomatic_persona['ID'], '_persona_first_message', true);
            $onlyKeys = ['ID', 'post_content','post_title', 'post_excerpt'];
            $aiomatic_persona = array_filter($aiomatic_persona, function($v) use ($onlyKeys) 
            {
                return in_array($v, $onlyKeys);
            }, ARRAY_FILTER_USE_KEY);
            $aiomatic_persona['avatar'] = $avatar;
            $aiomatic_persona['avatarid'] = $avatarid;
            $aiomatic_persona['message'] = $message;
            $persona = json_encode($aiomatic_persona);
        }
        if($persona !== false)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['msg'] = $persona;
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_duplicate_form', 'aiomatic_duplicate_form');
function aiomatic_duplicate_form()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with form duplication');
    if(!isset($_POST['formid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $formid = $_POST['formid'];
        $original_form = get_post($formid);
        if($original_form == null)
        {
            $aiomatic_result['msg'] = 'Form id was not found!';
            wp_send_json($aiomatic_result);
        }
        $prompt = get_post_meta($formid, 'prompt', true);
        $model = get_post_meta($formid, 'model', true);
        $assistant_id = get_post_meta($formid, 'assistant_id', true);
        if(empty($assistant_id))
        {
            $assistant_id = '';
        }
        $header = get_post_meta($formid, 'header', true);
        $advanced = get_post_meta($formid, 'advanced', true);
        $editor = get_post_meta($formid, 'editor', true);
        $submit = get_post_meta($formid, 'submit', true);
        $max = get_post_meta($formid, 'max', true);
        $temperature = get_post_meta($formid, 'temperature', true);
        $topp = get_post_meta($formid, 'topp', true);
        $presence = get_post_meta($formid, 'presence', true);
        $frequency = get_post_meta($formid, 'frequency', true);
        $response = get_post_meta($formid, 'response', true);
        $type = get_post_meta($formid, 'type', true);
        $aiomaticfields = get_post_meta($formid, '_aiomaticfields', true);
        if(!is_array($aiomaticfields))
        {
            $aiomaticfields = array();
        }
        $original_form->post_date = wp_date('Y-m-d H:i:s');
        unset($original_form->ID);
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $forms_id = wp_insert_post($original_form);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($forms_id))
        {
            $aiomatic_result['msg'] = 'Failed to save duplicated form!';
            wp_send_json($aiomatic_result);
        }
        update_post_meta($forms_id, 'prompt', $prompt);
        update_post_meta($forms_id, 'model', $model);
        update_post_meta($forms_id, 'assistant_id', $assistant_id);
        update_post_meta($forms_id, 'header', $header);
        update_post_meta($forms_id, 'advanced', $advanced);
        update_post_meta($forms_id, 'editor', $editor);
        update_post_meta($forms_id, 'submit', $submit);
        update_post_meta($forms_id, 'max', $max);
        update_post_meta($forms_id, 'temperature', $temperature);
        update_post_meta($forms_id, 'topp', $topp);
        update_post_meta($forms_id, 'presence', $presence);
        update_post_meta($forms_id, 'frequency', $frequency);
        update_post_meta($forms_id, 'response', $response);
        update_post_meta($forms_id, 'type', $type);
        update_post_meta($forms_id, '_aiomaticfields', $aiomaticfields);
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $forms_id;
        $aiomatic_result['msg'] = 'Success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_duplicate_persona', 'aiomatic_duplicate_persona');
function aiomatic_duplicate_persona()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with persona duplication');
    if(!isset($_POST['personaid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $personaid = $_POST['personaid'];
        $original_persona = get_post($personaid);
        if($original_persona == null)
        {
            $aiomatic_result['msg'] = 'Persona id was not found!';
            wp_send_json($aiomatic_result);
        }
        $first_message = get_post_meta($personaid, '_persona_first_message', true);
        $original_persona->post_date = wp_date('Y-m-d H:i:s');
        $avatar = get_post_thumbnail_id($original_persona->ID);
        unset($original_persona->ID);
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $persona_id = wp_insert_post($original_persona);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($persona_id))
        {
            $aiomatic_result['msg'] = 'Failed to save duplicated persona!';
            wp_send_json($aiomatic_result);
        }
        if($avatar > 0)
        {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            set_post_thumbnail( $persona_id, $avatar );
        }
        if(!empty($first_message))
        {
            update_post_meta($persona_id, '_persona_first_message', $first_message);
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $persona_id;
        $aiomatic_result['msg'] = 'Success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_add_remote_chatbot', 'aiomatic_add_remote_chatbot');
function aiomatic_add_remote_chatbot()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with remote chatbot creation');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $page_title = 'Chatbot ' . uniqid(); 
    $page_id = wp_insert_post(array(
        'post_title'     => $page_title,
        'post_status'    => 'publish',
        'post_type'      => 'aiomatic_remote_chat',
        'post_content'   => '[aiomatic-chat-form]'
    ));
    if ($page_id && !is_wp_error($page_id)) 
    {
        $myop = get_option('aiomatic_chat_page_id', false);
        if($myop === false)
        {
            $myop = array();
        }
        if(is_numeric($myop))
        {
            $myop = array($myop);
        }
        $myop[] = $page_id;
        update_option('aiomatic_chat_page_id', $myop);
    }
    else
    {
        $aiomatic_result['msg'] = 'Failed to save remote chatbot instance!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['status'] = 'success';
    $aiomatic_result['id'] = $page_id;
    $aiomatic_result['msg'] = 'Success';
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_remote_chatbot', 'aiomatic_delete_remote_chatbot');
function aiomatic_delete_remote_chatbot()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with remote chatbot deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['dataid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
        wp_send_json($aiomatic_result);
    }
    $dataid = $_POST['dataid'];
    wp_delete_post($dataid, true);
    $aiomatic_result['status'] = 'success';
    $aiomatic_result['msg'] = 'Success';
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_form', 'aiomatic_delete_form');
function aiomatic_delete_form()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular form deletion');
    if(!isset($_POST['formid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $_POST['formid'];
        $aiomatic_result['msg'] = 'Success';
        wp_delete_post($_POST['formid']);
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_assistant', 'aiomatic_delete_assistant');
function aiomatic_delete_assistant()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular assistant deletion');
    if(!isset($_POST['assistantid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
            $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            if(empty($token))
            {
                $aiomatic_result['msg'] = 'Invalid API key submitted';
                wp_send_json($aiomatic_result);
            }
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
        $errors = '';
        $assistant_id = get_post_meta($_POST['assistantid'], '_assistant_id', true);
        if(!empty($assistant_id))
        {
            try
            {
                aiomatic_openai_delete_assistant($token, $assistant_id);
            }
            catch(Exception $e)
            {
                $errors .= 'Failed to delete assistant ID: ' . $assistant_id . ', exception: ' . $e->getMessage() . '\n';
            }
        }
        $vector_store_id = get_post_meta($_POST['assistantid'], '_assistant_vector_store_id', true);
        if(!empty($vector_store_id))
        {
            aiomatic_openai_delete_vector_store($token, $vector_store_id);
        }
        wp_delete_post($_POST['assistantid']);
        if(!empty($errors))
        {
            $aiomatic_result['msg'] = 'Assistant failed to be deleted: ' . $errors;
            wp_send_json($aiomatic_result);
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $_POST['assistantid'];
        $aiomatic_result['msg'] = 'Success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_omni_template', 'aiomatic_delete_omni_template');
function aiomatic_delete_omni_template()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular OmniBlock Template deletion');
    if(!isset($_POST['id']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        wp_delete_post($_POST['id']);
        if(!empty($errors))
        {
            $aiomatic_result['msg'] = 'OmniBlock Template failed to be deleted: ' . $errors;
            wp_send_json($aiomatic_result);
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $_POST['id'];
        $aiomatic_result['msg'] = 'Success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_omni_file', 'aiomatic_delete_omni_file');
function aiomatic_delete_omni_file()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular OmniBlock File deletion');
    if(!isset($_POST['id']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $this_post = get_post($_POST['id']);
        if($this_post === null)
        {
            $aiomatic_result['msg'] = 'Incorrect post_id sent';
            wp_send_json($aiomatic_result);
        }

        $local_id = get_post_meta($_POST['id'], 'local_id', true);
        if(empty($local_id))
        {
            $aiomatic_result['msg'] = 'Local file path not found';
            wp_send_json($aiomatic_result);
        }
        $file_type = '';
        $terms = wp_get_object_terms( $_POST['id'], 'ai_file_type' );
        if(!is_wp_error($terms))
        {
            foreach($terms as  $tm)
            {
                $file_type = $tm->slug;
                break;
            }
        }
        if($file_type == 'local')
        {
            global $wp_filesystem;
            if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                wp_filesystem($creds);
            }
            $wp_filesystem->delete($local_id);
        }
        elseif($file_type == 'amazon')
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if(!function_exists('is_plugin_active'))
            {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }
            if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
            {
                $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['bucket_name']) || trim($aiomatic_Main_Settings['bucket_name']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Amazon S3 bucket_name for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['s3_user']) || trim($aiomatic_Main_Settings['s3_user']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Amazon S3 s3_user for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['s3_pass']) || trim($aiomatic_Main_Settings['s3_pass']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Amazon S3 s3_pass for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['bucket_region']) || trim($aiomatic_Main_Settings['bucket_region']) == '')
            {
                $aiomatic_Main_Settings['bucket_region'] = 'eu-central-1';
            }
            try
            {
                $credentials = array('key' => trim($aiomatic_Main_Settings['s3_user']), 'secret' => trim($aiomatic_Main_Settings['s3_pass']));
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region'  => trim($aiomatic_Main_Settings['bucket_region']),
                    'credentials' => $credentials
                ]);
            }
            catch(Exception $e)
            {
                $aiomatic_result['msg'] = 'Failed to initialize Amazon S3 API: ' . $e->getMessage();
                wp_send_json($aiomatic_result);
            }
            try 
            {
                $obj_arr = [
                    'Bucket' => trim($aiomatic_Main_Settings['bucket_name']),
                    'Key'    => $local_id,
                ];
                $awsret = $s3->deleteObject($obj_arr);
                if(!isset($awsret['DeleteMarker']))
                {
                    $aiomatic_result['msg'] = "Failed to decode Amazon S3 API response: " . print_r($awsret, true);
                    wp_send_json($aiomatic_result);
                }
            } 
            catch (Exception $e) 
            {
                $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to Amazon S3: " . $e->getMessage();
                wp_send_json($aiomatic_result);
            } 
        }
        elseif($file_type == 'wasabi')
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if(!function_exists('is_plugin_active'))
            {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }
            if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
            {
                $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['wasabi_bucket']) || trim($aiomatic_Main_Settings['wasabi_bucket']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_bucket for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['wasabi_user']) || trim($aiomatic_Main_Settings['wasabi_user']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_user for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['wasabi_pass']) || trim($aiomatic_Main_Settings['wasabi_pass']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_pass for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['wasabi_region']) || trim($aiomatic_Main_Settings['wasabi_region']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Wasabi wasabi_region for this to work!';
                wp_send_json($aiomatic_result);
            }
            try
            {
                $credentials = array('key' => trim($aiomatic_Main_Settings['wasabi_user']), 'secret' => trim($aiomatic_Main_Settings['wasabi_pass']));
                $s3 = new S3Client([
                    'endpoint' => "https://" . trim($aiomatic_Main_Settings['wasabi_bucket']) . ".s3." . trim($aiomatic_Main_Settings['wasabi_region']) . ".wasabisys.com/",
                    'bucket_endpoint' => true,
                    'version' => 'latest',
                    'region'  => trim($aiomatic_Main_Settings['wasabi_region']),
                    'credentials' => $credentials
                ]);
            }
            catch(Exception $e)
            {
                $aiomatic_result['msg'] = 'Failed to initialize Wasabi API: ' . $e->getMessage();
                wp_send_json($aiomatic_result);
            }
            try 
            {
                $obj_arr = [
                    'Bucket' => trim($aiomatic_Main_Settings['wasabi_bucket']),
                    'Key'    => $local_id,
                ];
                $awsret = $s3->deleteObject($obj_arr);
                if(!isset($awsret['DeleteMarker']))
                {
                    $aiomatic_result['msg'] = "Failed to decode Wasabi API response: " . print_r($awsret, true);
                    wp_send_json($aiomatic_result);
                }
            } 
            catch (Exception $e) 
            {
                $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to Wasabi: " . $e->getMessage();
                wp_send_json($aiomatic_result);
            } 
        }
        elseif($file_type == 'cloudflare')
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if(!function_exists('is_plugin_active'))
            {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }
            if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
            {
                $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['cloud_bucket']) || trim($aiomatic_Main_Settings['cloud_bucket']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_bucket for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['cloud_user']) || trim($aiomatic_Main_Settings['cloud_user']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_user for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['cloud_pass']) || trim($aiomatic_Main_Settings['cloud_pass']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_pass for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['cloud_account']) || trim($aiomatic_Main_Settings['cloud_account']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a CloudFlare cloud_account for this to work!';
                wp_send_json($aiomatic_result);
            }
            try
            {
                $credentials = array('key' => trim($aiomatic_Main_Settings['cloud_user']), 'secret' => trim($aiomatic_Main_Settings['cloud_pass']));
                $s3 = new S3Client([
                    'endpoint' => "https://" . trim($aiomatic_Main_Settings['cloud_account']) . ".r2.cloudflarestorage.com",
                    'bucket_endpoint' => true,
                    'version' => 'latest',
                    'region' => 'us-east-1',
                    'credentials' => $credentials
                ]);
            }
            catch(Exception $e)
            {
                $aiomatic_result['msg'] = 'Failed to initialize CloudFlare API: ' . $e->getMessage();
                wp_send_json($aiomatic_result);
            }
            try 
            {
                $obj_arr = [
                    'Bucket' => trim($aiomatic_Main_Settings['cloud_bucket']),
                    'Key'    => $local_id,
                ];
                $awsret = $s3->deleteObject($obj_arr);
                if(!isset($awsret['DeleteMarker']))
                {
                    $aiomatic_result['msg'] = "Failed to decode CloudFlare API response: " . print_r($awsret, true);
                    wp_send_json($aiomatic_result);
                }
            } 
            catch (Exception $e) 
            {
                $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to CloudFlare: " . $e->getMessage();
                wp_send_json($aiomatic_result);
            } 
        }
        elseif($file_type == 'digital')
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if(!function_exists('is_plugin_active'))
            {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }
            if (!is_plugin_active('aiomatic-extension-amazon-s3-images/aiomatic-extension-amazon-s3-images.php')) 
            {
                $aiomatic_result['msg'] = 'You need enable the "Aiomatic Extension: Amazon S3 Storage" plugin for this feature to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['digital_endpoint']) || trim($aiomatic_Main_Settings['digital_endpoint']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Digital Ocean digital_endpoint for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['digital_user']) || trim($aiomatic_Main_Settings['digital_user']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Digital Ocean digital_user for this to work!';
                wp_send_json($aiomatic_result);
            }
            if (!isset($aiomatic_Main_Settings['digital_pass']) || trim($aiomatic_Main_Settings['digital_pass']) == '')
            {
                $aiomatic_result['msg'] = 'You need to enter a Digital Ocean digital_pass for this to work!';
                wp_send_json($aiomatic_result);
            }
            $bucket_name = '';
            preg_match_all('#https:\/\/([^.]*?)\.(?:[^.]*?)\.digitaloceanspaces\.com#i', trim($aiomatic_Main_Settings['digital_endpoint']), $zmatches);
            if(isset($zmatches[1][0]))
            {
                $bucket_name = $zmatches[1][0];
            }
            else
            {
                $aiomatic_result['msg'] = 'Failed to parse Digital Ocean Spaces URL: ' . trim($aiomatic_Main_Settings['digital_endpoint']);
                wp_send_json($aiomatic_result);
            }
            $endpoint_plain_url = preg_replace('#https?:\/\/([^.]*?\.)([^.]*?)\.digitaloceanspaces\.com#i', 'https://$2.digitaloceanspaces.com', trim($aiomatic_Main_Settings['digital_endpoint']));
            try
            {
                $credentials = array('key' => trim($aiomatic_Main_Settings['digital_user']), 'secret' => trim($aiomatic_Main_Settings['digital_pass']));
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region'  => 'us-east-1',
                    'endpoint' => $endpoint_plain_url,
                    'use_path_style_endpoint' => false,
                    'credentials' => $credentials
                ]);
            }
            catch(Exception $e)
            {
                $aiomatic_result['msg'] = 'Failed to initialize Digital Ocean API: ' . $e->getMessage();
                wp_send_json($aiomatic_result);
            }
            try 
            {
                $obj_arr = [
                    'Bucket' => trim($bucket_name),
                    'Key'    => $local_id,
                ];
                $awsret = $s3->deleteObject($obj_arr);
                if(!isset($awsret['DeleteMarker']))
                {
                    $aiomatic_result['msg'] = "Failed to decode Digital Ocean API response: " . print_r($awsret, true);
                    wp_send_json($aiomatic_result);
                }
            } 
            catch (Exception $e) 
            {
                $aiomatic_result['msg'] = "There was an error uploading the file " . $image_url . " to Digital Ocean: " . $e->getMessage();
                wp_send_json($aiomatic_result);
            } 
        }
        wp_delete_post($_POST['id']);
        if(!empty($errors))
        {
            $aiomatic_result['msg'] = 'OmniBlock File failed to be deleted: ' . $errors;
            wp_send_json($aiomatic_result);
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $_POST['id'];
        $aiomatic_result['msg'] = 'Success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_duplicate_assistant', 'aiomatic_duplicate_assistant');
function aiomatic_duplicate_assistant()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular assistant duplication');
    if(!isset($_POST['assistantid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $vector_store_id = '';
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
            $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            if(empty($token))
            {
                $aiomatic_result['msg'] = 'Invalid API key submitted';
                wp_send_json($aiomatic_result);
            }
        }
        $original_assistant = get_post($_POST['assistantid'], ARRAY_A);
        if($original_assistant == null)
        {
            $aiomatic_result['msg'] = 'Assistant id was not found!';
            wp_send_json($aiomatic_result);
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
        $errors = '';
        $assistant_id = get_post_meta($_POST['assistantid'], '_assistant_id', true);
        $assistant_first_message = get_post_meta($_POST['assistantid'], '_assistant_first_message', true);
        $featured_image = get_post_thumbnail_id($_POST['assistantid']);
        $new_id = false;
        if(!empty($assistant_id))
        {
            try
            {
                $new_id = aiomatic_openai_duplicate_assistant($token, $assistant_id, $vector_store_id);
            }
            catch(Exception $e)
            {
                $errors .= 'Failed to duplicate assistant ID: ' . $assistant_id . ', exception: ' . $e->getMessage() . '\n';
            }
        }
        if($new_id !== false)
        {
            try
            {
                $file_ids = array();
                if(isset($new_id['tool_resources']['code_interpreter']['file_ids'][0]))
                {
                    $file_ids = $new_id['tool_resources']['code_interpreter']['file_ids'];
                }
                $result = aiomatic_save_assistant_only_local($token, $new_id['name'], $new_id['model'], $new_id['instructions'], $new_id['description'], $new_id['temperature'], $new_id['top_p'], $assistant_first_message, $featured_image, $file_ids, $new_id['id'], $new_id['created_at'], $new_id['tools'], $vector_store_id);
                if(!isset($result['id']))
                {
                    $aiomatic_result['msg'] = 'Failed to import assistant: ' . print_r($result, true);
                }
            }
            catch(Exception $e)
            {
                $errors .= 'Failed to duplicate assistant ID locally: ' . $assistant_id . ', exception: ' . $e->getMessage() . '\n';
            }
            if(!empty($errors))
            {
                $aiomatic_result['msg'] = 'Assistant failed to be duplicated: ' . $errors;
                wp_send_json($aiomatic_result);
            }
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['id'] = $_POST['assistantid'];
            $aiomatic_result['msg'] = 'Success';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_duplicate_omni_template', 'aiomatic_duplicate_omni_template');
function aiomatic_duplicate_omni_template()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular OmniBlock template duplication');
    if(!isset($_POST['id']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $id = $_POST['id'];
        $original_temp = get_post($id);
        if($original_temp == null)
        {
            $aiomatic_result['msg'] = 'OmniBlock template id was not found!';
            wp_send_json($aiomatic_result);
        }
        $original_temp->post_date = wp_date('Y-m-d H:i:s');
        $original_temp->post_title .= ' - Copy';
        $original_temp->post_content = addslashes($original_temp->post_content);
        unset($original_temp->ID);
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $zaid = wp_insert_post($original_temp);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($zaid))
        {
            $aiomatic_result['msg'] = 'Failed to save duplicated OmniBlock template!';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $category_detail = get_the_terms($id, 'ai_template_categories');
            $categories_list = array();
            if(is_array($category_detail))
            {
                foreach($category_detail as $cd){
                    $categories_list[] = $cd->slug;
                }
            }
            if(!empty($categories_list))
            {
                wp_set_object_terms($zaid, $categories_list, 'ai_template_categories');
            }
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $zaid;
        $aiomatic_result['msg'] = 'Success';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_get_omni_data', 'aiomatic_get_omni_data');
function aiomatic_get_omni_data()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular OmniBlock template query');
    if(!isset($_POST['theID']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $id = $_POST['theID'];
        $original_temp = get_post($id);
        if($original_temp == null)
        {
            $aiomatic_result['msg'] = 'OmniBlock edit template id was not found!';
            wp_send_json($aiomatic_result);
        }
        $json_back = get_post_meta($id, 'aiomatic_json', true);
        if(!empty($json_back))
        {
            $original_temp->post_content = $json_back;
        }
        $saved_cards = json_decode($original_temp->post_content, true);
        if($saved_cards === null)
        {
            aiomatic_log_to_file('Decode fail: ' . json_last_error_msg());
            $aiomatic_result['msg'] = 'OmniBlock edit template failed to be decoded!';
            wp_send_json($aiomatic_result);
        }
        $data = get_omniblock_data($saved_cards, $original_temp);
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['msg'] = $data;
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_get_assistant', 'aiomatic_get_assistant_ajax');
function aiomatic_get_assistant_ajax()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular assistant getting');
    if(!isset($_POST['assistantid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $original_assistant = get_post($_POST['assistantid'], ARRAY_A);
        if($original_assistant == null)
        {
            $aiomatic_result['msg'] = 'Assistant id was not found!';
            wp_send_json($aiomatic_result);
        }
        $code_interpreter = false;
        $file_search = false;
        $functions = [];
        $tools = get_post_meta($original_assistant['ID'], '_assistant_tools', true);
        if(!empty($tools))
        {
            foreach($tools as $tool)
            {
                if($tool['type'] == 'code_interpreter')
                {
                    $code_interpreter = true;
                }
                elseif($tool['type'] == 'file_search')
                {
                    $file_search = true;
                }
                elseif($tool['type'] == 'function')
                {
                    $functions[] = $tool['function'];
                }
            }
        }
        $assistant_first_message = get_post_meta($original_assistant['ID'], '_assistant_first_message', true);
        $assistant_model = get_post_meta($original_assistant['ID'], '_assistant_model', true);
        $assistant_files = get_post_meta($original_assistant['ID'], '_assistant_files', true);
        $assistant_id = get_post_meta($original_assistant['ID'], '_assistant_id', true);
        $temperature = get_post_meta($original_assistant['ID'], '_assistant_temperature', true);
        $topp = get_post_meta($original_assistant['ID'], '_assistant_topp', true);
        $vector_store_id = get_post_meta($original_assistant['ID'], '_assistant_vector_store_id', true);
        $original_assistant['code_interpreter'] = $code_interpreter;
        $original_assistant['file_search'] = $file_search;
        $original_assistant['functions'] = $functions;
        $original_assistant['assistant_first_message'] = $assistant_first_message;
        $original_assistant['assistant_model'] = $assistant_model;
        $original_assistant['assistant_files'] = $assistant_files;
        $original_assistant['assistant_id'] = $assistant_id;
        $original_assistant['temperature'] = $temperature;
        $original_assistant['topp'] = $topp;
        $original_assistant['vector_store_id'] = $vector_store_id;
        $original_assistant['featured_image'] = get_post_thumbnail_id($original_assistant['ID']);
        if($original_assistant['featured_image'] === false)
        {
            $original_assistant['featured_image'] = 0;
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['data'] = $original_assistant;
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_get_batch', 'aiomatic_get_batch_ajax');
function aiomatic_get_batch_ajax()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular batch getting');
    if(!isset($_POST['batchid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $original_batch = get_post($_POST['batchid'], ARRAY_A);
        if($original_batch == null)
        {
            $aiomatic_result['msg'] = 'Batch id was not found!';
            wp_send_json($aiomatic_result);
        }
        $batch_id = get_post_meta($_POST['batchid'], '_batch_id', true);
        $batch_endpoint = get_post_meta($_POST['batchid'], '_batch_endpoint', true);
        $batch_completion_window = get_post_meta($_POST['batchid'], '_batch_completion_window', true);
        $batch_errors = get_post_meta($_POST['batchid'], '_batch_errors', true);
        $batch_input_file_id = get_post_meta($_POST['batchid'], '_batch_input_file_id', true);
        $batch_status = get_post_meta($_POST['batchid'], '_batch_status', true);
        $batch_output_file_id = get_post_meta($_POST['batchid'], '_batch_output_file_id', true);
        $batch_created_at = get_post_meta($_POST['batchid'], '_batch_created_at', true);
        $batch_in_progress_at = get_post_meta($_POST['batchid'], '_batch_in_progress_at', true);
        $batch_expires_at = get_post_meta($_POST['batchid'], '_batch_expires_at', true);
        $batch_finalizing_at = get_post_meta($_POST['batchid'], '_batch_finalizing_at', true);
        $batch_completed_at = get_post_meta($_POST['batchid'], '_batch_completed_at', true);
        $batch_failed_at = get_post_meta($_POST['batchid'], '_batch_failed_at', true);
        $batch_expired_at = get_post_meta($_POST['batchid'], '_batch_expired_at', true);
        $batch_cancelling_at = get_post_meta($_POST['batchid'], '_batch_cancelling_at', true);
        $batch_cancelled_at = get_post_meta($_POST['batchid'], '_batch_cancelled_at', true);
        $batch_request_count = get_post_meta($_POST['batchid'], '_batch_request_count', true);
        $batch_request_completed = get_post_meta($_POST['batchid'], '_batch_request_completed', true);
        $batch_request_failed = get_post_meta($_POST['batchid'], '_batch_request_failed', true);
        $batch_error_file_id = get_post_meta($_POST['batchid'], '_batch_error_file_id', true);
        $original_batch['batch_endpoint'] = $batch_endpoint;
        $original_batch['batch_id'] = $batch_id;
        $original_batch['batch_completion_window'] = $batch_completion_window;
        $original_batch['batch_errors'] = $batch_errors;
        $original_batch['batch_input_file_id'] = $batch_input_file_id;
        $original_batch['batch_status'] = $batch_status;
        $original_batch['batch_output_file_id'] = $batch_output_file_id;
        $original_batch['batch_expires_at'] = $batch_expires_at;
        $original_batch['batch_created_at'] = $batch_created_at;
        $original_batch['batch_in_progress_at'] = $batch_in_progress_at;
        $original_batch['batch_cancelling_at'] = $batch_cancelling_at;
        $original_batch['batch_cancelled_at'] = $batch_cancelled_at;
        $original_batch['batch_finalizing_at'] = $batch_finalizing_at;
        $original_batch['batch_completed_at'] = $batch_completed_at;
        $original_batch['batch_failed_at'] = $batch_failed_at;
        $original_batch['batch_expired_at'] = $batch_expired_at;
        $original_batch['batch_request_count'] = $batch_request_count;
        $original_batch['batch_request_failed'] = $batch_request_failed;
        $original_batch['batch_request_completed'] = $batch_request_completed;
        $original_batch['batch_error_file_id'] = $batch_error_file_id;
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['data'] = $original_batch;
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_cancel_batch', 'aiomatic_cancel_batch_ajax');
function aiomatic_cancel_batch_ajax()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular batch cancel');
    if(!isset($_POST['batchid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $batch_id = $_POST['batchid'];
        $open_batch_id = get_post_meta($batch_id, '_batch_id', true);
        if(empty($open_batch_id))
        {
            $aiomatic_result['msg'] = 'Batch ID not found in the database!';
            wp_send_json($aiomatic_result);
        }
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
            $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            if(empty($token))
            {
                $aiomatic_result['msg'] = 'Invalid API key submitted';
                wp_send_json($aiomatic_result);
            }
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-batch-api.php"); 
        try
        {
            $batch = aiomatic_openai_cancel_batch($token, $open_batch_id);
            if(!isset($batch['id']))
            {
                throw new Exception('Incorrect response from batch cancelling: ' . print_r($batch, true));
            }
            else
            {
                $original_batch = get_post($batch_id, ARRAY_A);
                if($original_batch == null)
                {
                    $aiomatic_result['msg'] = 'Batch Request id was not found!';
                    wp_send_json($aiomatic_result);
                }
                $batch_data = array(
                    'post_type' => 'aiomatic_batches',
                    'post_title' => $batch['id'],
                    'post_status' => 'publish',
                    'ID' => $original_batch['ID']
                );
                remove_filter('content_save_pre', 'wp_filter_post_kses');
                remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                $local_batch_id = wp_update_post($batch_data);
                add_filter('content_save_pre', 'wp_filter_post_kses');
                add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                if(is_wp_error($local_batch_id))
                {
                    $aiomatic_result['msg'] = $local_batch_id->get_error_message();
                }
                elseif($local_batch_id === 0)
                {
                    $aiomatic_result['msg'] = 'Failed to update assistant to database: ' . $assistant['name'];
                }
                else 
                {
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
        catch(Exception $e)
        {
            $aiomatic_result['msg'] = 'Exception in batch cancelling: ' . $e->getMessage();
            wp_send_json($aiomatic_result);
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['data'] = $batch;
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_sync_assistant', 'aiomatic_sync_assistant_ajax');
function aiomatic_sync_assistant_ajax()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular assistant sync');
    if(!isset($_POST['assistantid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $original_assistant = get_post($_POST['assistantid'], ARRAY_A);
        if($original_assistant == null)
        {
            $aiomatic_result['msg'] = 'Assistant id was not found!';
            wp_send_json($aiomatic_result);
        }
        $ass_id = get_post_meta($original_assistant['ID'], '_assistant_id', true);
        if(empty($ass_id))
        {
            $aiomatic_result['msg'] = 'OpenAI assistant id was not found!';
            wp_send_json($aiomatic_result);
        }
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
            $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            if(empty($token))
            {
                $aiomatic_result['msg'] = 'Invalid API key submitted';
                wp_send_json($aiomatic_result);
            }
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
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
            $aiomatic_result['msg'] = 'Exception in assistant grabbing: ' . $e->getMessage();
            wp_send_json($aiomatic_result);
        }
        if(empty($assistant['name']))
        {
            $assistant['name'] = 'Untitled Assistant';
        }
        if(empty($assistant['instructions']))
        {
            $assistant['instructions'] = '';
        }
        if(empty($assistant['description']))
        {
            $assistant['description'] = '';
        }
        $assistant_data = array(
            'post_type' => 'aiomatic_assistants',
            'post_title' => $assistant['name'],
            'post_content' => $assistant['instructions'],
            'post_excerpt' => $assistant['description'],
            'post_status' => 'publish',
            'ID' => $original_assistant['ID']
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
            $aiomatic_result['msg'] = 'Failed to update assistant to database: ' . $assistant['name'];
        }
        else 
        {
            update_post_meta($local_assistant_id, '_assistant_model', $assistant['model']);
            update_post_meta($local_assistant_id, '_assistant_tools', (array) $assistant['tools']);
            $file_ids = array();
            if(isset($assistant['tool_resources']['code_interpreter']['file_ids'][0]))
            {
                $file_ids = $assistant['tool_resources']['code_interpreter']['file_ids'];
            }
            update_post_meta($local_assistant_id, '_assistant_files', $file_ids);
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['id'] = $local_assistant_id;
        }
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_sync_batch', 'aiomatic_sync_batch_ajax');
function aiomatic_sync_batch_ajax()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular batch request sync');
    if(!isset($_POST['batchid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $original_batch = get_post($_POST['batchid'], ARRAY_A);
        if($original_batch == null)
        {
            $aiomatic_result['msg'] = 'Batch Request id was not found!';
            wp_send_json($aiomatic_result);
        }
        $batch_id = get_post_meta($original_batch['ID'], '_batch_id', true);
        if(empty($batch_id))
        {
            $aiomatic_result['msg'] = 'OpenAI Batch Request id was not found!';
            wp_send_json($aiomatic_result);
        }
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
            $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
            wp_send_json($aiomatic_result);
        }
        else
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            if(empty($token))
            {
                $aiomatic_result['msg'] = 'Invalid API key submitted';
                wp_send_json($aiomatic_result);
            }
        }
        require_once (dirname(__FILE__) . "/res/aiomatic-batch-api.php"); 
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
            $aiomatic_result['msg'] = 'Exception in batch grabbing: ' . $e->getMessage();
            wp_send_json($aiomatic_result);
        }
        $batch_data = array(
            'post_type' => 'aiomatic_batches',
            'post_title' => $batch['id'],
            'post_status' => 'publish',
            'ID' => $original_batch['ID']
        );
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
        $local_batch_id = wp_update_post($batch_data);
        add_filter('content_save_pre', 'wp_filter_post_kses');
        add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
        if(is_wp_error($local_batch_id))
        {
            $aiomatic_result['msg'] = $local_batch_id->get_error_message();
        }
        elseif($local_batch_id === 0)
        {
            $aiomatic_result['msg'] = 'Failed to update assistant to database: ' . $assistant['name'];
        }
        else 
        {
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
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_persona', 'aiomatic_delete_persona');
function aiomatic_delete_persona()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with singular persona deletion');
    if(!isset($_POST['personaid']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        check_ajax_referer('openai-ajax-nonce', 'nonce');
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['id'] = $_POST['personaid'];
        $aiomatic_result['msg'] = 'Success';
        wp_delete_post($_POST['personaid']);
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_download_embeddings', 'aiomatic_download_embeddings');
function aiomatic_download_embeddings()
{
    global $wpdb;
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embedding downloading');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $ids = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE post_type='aiomatic_embeddings'");
    $ids = wp_list_pluck($ids,'ID');
    $ret_arr = array();
    if(count($ids)) 
    {
        foreach($ids as $my_postid)
        {
            $content_post = get_post($my_postid);
            if(isset($content_post->post_content))
            {
                $ret_arr[] = array($content_post->post_content);
            }
        }
        if(count($ret_arr) > 0)
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['rows'] = $ret_arr;
        }
        else
        {
            $aiomatic_result['msg'] = 'No embeddings can be downloaded.';
        }
    }
    else
    {
        $aiomatic_result['msg'] = 'No embeddings found to download.';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_get_form', 'aiomatic_get_form');
function aiomatic_get_form()
{
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with form getting');
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $aiomatic_form = get_post(sanitize_text_field($_POST['id']));
        if($aiomatic_form)
        {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            $prompt = get_post_meta($aiomatic_form->ID, 'prompt', true);
            $assistant_id = get_post_meta($aiomatic_form->ID, 'assistant_id', true);
            if(empty($assistant_id))
            {
                $assistant_id = '';
            }
            $model = get_post_meta($aiomatic_form->ID, 'model', true);
            $header = get_post_meta($aiomatic_form->ID, 'header', true);
            $editor = get_post_meta($aiomatic_form->ID, 'editor', true);
            $advanced = get_post_meta($aiomatic_form->ID, 'advanced', true);
            $submit = get_post_meta($aiomatic_form->ID, 'submit', true);
            $max = get_post_meta($aiomatic_form->ID, 'max', true);
            $temperature = get_post_meta($aiomatic_form->ID, 'temperature', true);
            $topp = get_post_meta($aiomatic_form->ID, 'topp', true);
            $presence = get_post_meta($aiomatic_form->ID, 'presence', true);
            $frequency = get_post_meta($aiomatic_form->ID, 'frequency', true);
            $response = get_post_meta($aiomatic_form->ID, 'response', true);
            $type = get_post_meta($aiomatic_form->ID, 'type', true);
            $streaming_enabled = get_post_meta($aiomatic_form->ID, 'streaming_enabled', true);
            $aiomaticfields = get_post_meta($aiomatic_form->ID, '_aiomaticfields', true);
            if(!is_array($aiomaticfields))
            {
                $aiomaticfields = array();
            }
            $aiomaticfields = array_values($aiomaticfields);
            $result = '<form action="#" method="post" id="aiomatic_forms_form_edit">
            <input type="hidden" name="action" value="aiomatic_forms">
            <input type="hidden" name="formid" value="' . esc_attr($aiomatic_form->ID) . '">
            <input type="hidden" name="nonce" value="' . wp_create_nonce('aiomatic_forms') . '">
            <div class="main-form-header-holder"><h2>' . esc_html__("Input Fields", 'aiomatic-automatic-ai-content-writer') . ':</h2><span class="header-al-right">' . esc_html__("Hide Input Fields", 'aiomatic-automatic-ai-content-writer') . '</span></div>
              <div class="main-form-holder">
              <button class="aiomatic-create-form-field button">' . esc_html__("Add A New Form Input Field", 'aiomatic-automatic-ai-content-writer') . '</button>
              <br/><br/>
              <div class="aiomatic-template-fields">';
              foreach($aiomaticfields as $inx => $aifield)
              {
                    $result .= '<div class="aiomatic-template-form-field">
                    <div class="aiomatic-template-form-field">
                    <div>
                       <div>
                             <strong class="aiomatic-label-top marginbottom-5">Label*<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the input field Label (textual hint).", 'aiomatic-automatic-ai-content-writer') . '</div>
                             </div></strong>
                             <input type="text" name="aiomaticfields[' . $inx . '][label]" required placeholder="The label which will be shown next to the input field" value="' . (isset($aifield['label']) ? esc_attr($aifield['label']) : '') . '" class="aiomatic-create-template-field-label aiomatic-full-size">
                       </div>
                       <div>
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("ID*", 'aiomatic-automatic-ai-content-writer') . '<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the input field ID. This is important, as you will be able to get the value entered by users on the front end for this input field, using this ID. You will be able to use this in the 'Prompt' settings field from below, in the following format: %%ID_YOU_ENTER_HERE%%.", 'aiomatic-automatic-ai-content-writer') . '</div>
                             </div></strong>
                             <input placeholder="my_unique_input_id" type="text" name="aiomaticfields[' . $inx . '][id]" required value="' . (isset($aifield['id']) ? esc_attr($aifield['id']) : '') . '" class="aiomatic-create-template-field-id aiomatic-full-size">
                             <small class="aiomatic-full-center">' . esc_html__("You can add the value of this field to the form prompt from below, using this shortcode", 'aiomatic-automatic-ai-content-writer') . ': <b>%%my_unique_input_id%%</b></small>
                       </div>
                       <div>
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Required*", 'aiomatic-automatic-ai-content-writer') . '<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set this input field as required (form cannot be submitted unless this is filled up).", 'aiomatic-automatic-ai-content-writer') . '</div>
                             </div></strong>
                             <select name="aiomaticfields[' . $inx . '][required]" class="aiomatic-create-template-field-required aiomatic-full-size">
                                <option value="no"';
                                if(isset($aifield['required']) && $aifield['required'] == 'no')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>No</option>
                                <option value="yes"';
                                if(isset($aifield['required']) && $aifield['required'] == 'yes')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Yes</option>
                             </select>
                       </div>
                       <div>
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Field Type*", 'aiomatic-automatic-ai-content-writer') . '<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the field type for this input field.", 'aiomatic-automatic-ai-content-writer') . '</div>
                             </div></strong>
                             <select name="aiomaticfields[' . $inx . '][type]" class="aiomatic-create-template-field-type aiomatic-full-size">
                                <option value="text"';
                                if(isset($aifield['type']) && $aifield['type'] == 'text')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Text</option>
                                <option value="select"';
                                if(isset($aifield['type']) && $aifield['type'] == 'select')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Drop-Down</option>
                                <option value="number"';
                                if(isset($aifield['type']) && $aifield['type'] == 'number')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Number</option>
                                <option value="email"';
                                if(isset($aifield['type']) && $aifield['type'] == 'email')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Email</option>
                                <option value="url"';
                                if(isset($aifield['type']) && $aifield['type'] == 'url')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>URL</option>
                                <option value="scrape"';
                                if(isset($aifield['type']) && $aifield['type'] == 'scrape')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>URL Scraper</option>
                                <option value="textarea"';
                                if(isset($aifield['type']) && $aifield['type'] == 'textarea')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Textarea</option>
                                <option value="checkbox"';
                                if(isset($aifield['type']) && $aifield['type'] == 'checkbox')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Checkbox</option>
                                <option value="radio"';
                                if(isset($aifield['type']) && $aifield['type'] == 'radio')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>Radio</option>
                                <option value="html"';
                                if(isset($aifield['type']) && $aifield['type'] == 'html')
                                {
                                    $result .= ' selected';
                                }
                                $result .= '>HTML</option>
                             </select>
                       </div>
                       <div class="aiomatic-create-template-field-placeholder-main';
                       if(isset($aifield['type']) && ($aifield['type'] == 'html' || $aifield['type'] == 'radio' || $aifield['type'] == 'checkbox' || $aifield['type'] == 'select'))
                       {
                           $result .= ' aiomatic-hidden-form';
                       }
                       $result .= '">
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Placeholder Text", 'aiomatic-automatic-ai-content-writer') . '</strong>
                             <input placeholder="Placeholder text" type="text" name="aiomaticfields[' . $inx . '][placeholder]" value="' . (isset($aifield['placeholder']) ? esc_attr($aifield['placeholder']) : '') . '" class="aiomatic-create-template-field-placeholder aiomatic-full-size">
                       </div>
                       <div class="aiomatic-create-template-field-limit-main';
                       if(isset($aifield['type']) && ($aifield['type'] == 'html' || $aifield['type'] == 'radio' || $aifield['type'] == 'checkbox' || $aifield['type'] == 'select'))
                       {
                           $result .= ' aiomatic-hidden-form';
                       }
                       $result .= '">
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Max Character Input Limit", 'aiomatic-automatic-ai-content-writer') . '</strong>
                             <input placeholder="Max input character count" type="text" name="aiomaticfields[' . $inx . '][limit]" value="' . (isset($aifield['limit']) ? esc_attr($aifield['limit']) : '') . '" class="aiomatic-create-template-field-limit aiomatic-full-size">
                       </div>
                       <div class="aiomatic-create-template-field-min-main';
                       if(isset($aifield['type']) && $aifield['type'] != 'number')
                       {
                           $result .= ' aiomatic-hidden-form';
                       }
                       $result .= '">
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Min", 'aiomatic-automatic-ai-content-writer') . '</strong>
                             <input placeholder="Minimum value (optional)" type="number" name="aiomaticfields[' . $inx . '][min]" value="' . (isset($aifield['min']) ? esc_attr($aifield['min']) : '') . '" class="aiomatic-create-template-field-min aiomatic-full-size">
                       </div>
                       <div class="aiomatic-create-template-field-max-main';
                       if(isset($aifield['type']) && $aifield['type'] != 'number')
                       {
                           $result .= ' aiomatic-hidden-form';
                       }
                       $result .= '">
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Max", 'aiomatic-automatic-ai-content-writer') . '</strong>
                             <input placeholder="Maximum value (optional)" type="number" name="aiomaticfields[' . $inx . '][max]" value="' . (isset($aifield['max']) ? esc_attr($aifield['max']) : '') . '" class="aiomatic-create-template-field-max aiomatic-full-size">
                       </div>
                       <div class="aiomatic-create-template-field-rows-main';
                       if(isset($aifield['type']) && $aifield['type'] != 'textarea')
                       {
                           $result .= ' aiomatic-hidden-form';
                       }
                       $result .= '">
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Rows", 'aiomatic-automatic-ai-content-writer') . '</strong>
                             <input placeholder="Textarea rows count (optional)" type="number" name="aiomaticfields[' . $inx . '][rows]" value="' . (isset($aifield['rows']) ? esc_attr($aifield['rows']) : '') . '" class="aiomatic-create-template-field-rows aiomatic-full-size">
                       </div>
                       <div class="aiomatic-create-template-field-cols-main';
                       if(isset($aifield['type']) && $aifield['type'] != 'textarea')
                       {
                           $result .= ' aiomatic-hidden-form';
                       }
                       $result .= '">
                             <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Cols", 'aiomatic-automatic-ai-content-writer') . '</strong>
                             <input placeholder="Textarea columns count (optional)" type="number" name="aiomaticfields[' . $inx . '][cols]" value="' . (isset($aifield['cols']) ? esc_attr($aifield['cols']) : '') . '" class="aiomatic-create-template-field-cols aiomatic-full-size">
                       </div>
                    </div>
                    <div class="aiomatic-create-template-field-options-main';
                    if(isset($aifield['type']) && $aifield['type'] != 'radio' && $aifield['type'] != 'checkbox' && $aifield['type'] != 'select' && $aifield['type'] != 'html')
                    {
                        $result .= ' aiomatic-hidden-form';
                    }
                    $result .= '">
                       <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Options", 'aiomatic-automatic-ai-content-writer') . '</strong>
                       <textarea name="aiomaticfields[' . $inx . '][options]" class="aiomatic-create-template-field-options aiomatic-full-size" placeholder="Possible values, separated by a new line">' . (isset($aifield['options']) ? esc_textarea($aifield['options']) : '') . '</textarea>
                    </div>
                    <div class="aiomatic-create-template-field-value-main">
                       <strong class="aiomatic-label-top marginbottom-5">' . esc_html__("Predefined Value", 'aiomatic-automatic-ai-content-writer') . '</strong>
                       <textarea name="aiomaticfields[' . $inx . '][value]" class="aiomatic-create-template-field-value aiomatic-full-size" placeholder="Predefined Value">' . (isset($aifield['value']) ? esc_textarea($aifield['value']) : '') . '</textarea>
                    </div>
                    <div class="aiomatic-form-controls">
                    <span class="aiomatic-field-up">' . esc_html__("Move Up", 'aiomatic-automatic-ai-content-writer') . '</span>&nbsp;
                    <span class="aiomatic-field-down">' . esc_html__("Move Down", 'aiomatic-automatic-ai-content-writer') . '</span>&nbsp;
                    <span class="aiomatic-field-delete">' . esc_html__("Delete", 'aiomatic-automatic-ai-content-writer') . '</span>&nbsp;
                    <span class="aiomatic-field-duplicate">' . esc_html__("Duplicate", 'aiomatic-automatic-ai-content-writer') . '</span>
                    </div>
                    </div>
                    </div>';
              }
              $result .= '</div></div>
              <hr/>
              <h2>' . esc_html__("Form Options", 'aiomatic-automatic-ai-content-writer') . ':</h2>
              <h4>' . esc_html__("Type*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the type of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <select name="aiomatic-type" id="aiomatic-edit-type" class="aiomatic-create-template-field-type aiomatic-full-size">
                 <option value="text"';
                 if($type == 'text')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>' . esc_html__("Text", 'aiomatic-automatic-ai-content-writer') . '</option>
                 <option value="image"';
                 if($type == 'image')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>' . esc_html__("Dall-E 2 Image", 'aiomatic-automatic-ai-content-writer') . '</option>
                 <option value="image-new"';
                 if($type == 'image-new')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>' . esc_html__("Dall-E 3 Image", 'aiomatic-automatic-ai-content-writer') . '</option>';
                 if (isset($aiomatic_Main_Settings['stability_app_id']) && trim($aiomatic_Main_Settings['stability_app_id']) != '') 
                 {
                    $result .= '<option value="image2"';
                    if($type == 'image2')
                    {
                       $result .= ' selected';
                    }
                    $result .= '>' . esc_html__("Stable Diffusion Image", 'aiomatic-automatic-ai-content-writer') . '</option>';
                 }
                 if (isset($aiomatic_Main_Settings['midjourney_app_id']) && trim($aiomatic_Main_Settings['midjourney_app_id']) != '') 
                 {
                    $result .= '<option value="image-mid"';
                    if($type == 'image-mid')
                    {
                       $result .= ' selected';
                    }
                    $result .= '>' . esc_html__("Midjourney", 'aiomatic-automatic-ai-content-writer') . '</option>';
                 }
                 $result .= '</select>
              <br/>
              <h4>' . esc_html__("Title*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the title of this form.", 'aiomatic-automatic-ai-content-writer'). '</div>
              </div></h4>
              <input id="aiomatic-form-title_edit" name="aiomatic-form-title" class="aiomatic-full-size" placeholder="Your form name" value="' . esc_attr($aiomatic_form->post_title) . '" required>
              <br/>
              <h4>' . esc_html__("Description", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the description of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <textarea id="aiomatic-form-description" name="aiomatic-form-description" class="aiomatic-full-size" placeholder="Your form description">' . esc_textarea($aiomatic_form->post_content) . '</textarea>
              <br/>
              <h4>' . esc_html__("Prompt*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the prompt which will be sent to the AI content writer. You can use shortcodes to get the input values entered by users in the form. The shortcodes need to be in the following format: %%ID_of_the_input_field%%", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <textarea id="aiomatic-form-prompt_edit" name="aiomatic-form-prompt" class="aiomatic-full-size" placeholder="The prompt which will be sent to the AI content writer" required>' . esc_textarea($prompt) . '</textarea>
              <br/>
              <h4>' . esc_html__("Sample Response", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set an example response for this form, this can be shown to users.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <textarea name="aiomatic-form-response" id="aiomatic-form-response" class="aiomatic-full-size" placeholder="A sample response to show for this form">' . esc_textarea($response) . '</textarea>
              <hr/>
              <div class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= '">
              <h2>' . esc_html__("AI Model Options", 'aiomatic-automatic-ai-content-writer') . ':</h2>
              <h4>' . esc_html__("AI Assistant ID*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI assistant to be used for this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <select name="aiomatic-form-assistant-id" class="aiomatic-create-template-field-type aiomatic-full-size">';
$all_assistants = aiomatic_get_all_assistants();
if($all_assistants === false)
{
    $result .= '<option val="" selected disabled>' . esc_html__("Only OpenAI API is supported for Assistants API", 'aiomatic-automatic-ai-content-writer') . '</option>';
}
else
{
    if(count($all_assistants) == 0)
    {
        $result .= '<option val="" selected disabled>' . esc_html__("No Assistans added, go to the plugin's 'AI Assistans' menu to add new assistants!", 'aiomatic-automatic-ai-content-writer') . '</option>';
    }
    else
    {
        $result .= '<option value=""';
        if($assistant_id == '')
        {
            $result .= ' selected';
        }
        $result .= '>' . esc_html__("Don't use assistants, use AI models instead", 'aiomatic-automatic-ai-content-writer') . '</option>';
        foreach($all_assistants as $myassistant)
        {
            $result .= '<option value="' . $myassistant->ID .'"';
            if($assistant_id == $myassistant->ID)
            {
                $result .= ' selected';
            }
            $result .= '>' . esc_html($myassistant->post_title);
            $result .= '</option>';
        }
    }
}
$result .= '</select>
              <br/>
              <h4>' . esc_html__("AI Model*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the AI model to be used for this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <select name="aiomatic-form-model" class="aiomatic-create-template-field-type aiomatic-full-size">';
$all_models = aiomatic_get_all_models();
foreach($all_models as $modl)
{
    $result .= '<option value="' . $modl . '"';
    if($modl == $model)
    {
        $result .= ' selected';
    }
    $result .= '>' . $modl . esc_html(aiomatic_get_model_provider($modl)) . '</option>';
}
$result .= '</select>
            <br/>
            <h4>' . esc_html__("Response Streaming*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to enable response streaming for your AI form.", 'aiomatic-automatic-ai-content-writer') . '</div>
            </div></h4>
            <select name="aiomatic-form-stream" class="aiomatic-create-template-field-type aiomatic-full-size"><option value="stream"';
            if('stream' === $streaming_enabled)
            {
            $result .= ' selected';
            }
            $result .= '>' . esc_html__("Enabled", 'aiomatic-automatic-ai-content-writer') . '</option>
            <option value="0"';
            if('stream' !== $streaming_enabled)
            {
            $result .= ' selected';
            }
            $result .= '>' . esc_html__("Disabled", 'aiomatic-automatic-ai-content-writer') . '</option></select>
              <br/>
              <br/>
              <button class="aiomatic-show-hide-field button">' . esc_html__("Show/Hide Advanced Model Settings", 'aiomatic-automatic-ai-content-writer') . '</button>
              <br/>
              <div class="aiomatic-hidden-form" id="hideAdv_edit">
              <h4>' . esc_html__("Max Token Count", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the AI maximum token count of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <input type="number" min="1" max="128000" step="1" name="aiomatic-max" value="' . esc_attr($max) . '" placeholder="Maximum token count to be used" class="cr_width_full">
              <br/>
              <h4>' . esc_html__("Temperature", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the AI temperature of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <input type="number" min="0" step="0.1" max="2" name="aiomatic-temperature" value="' . esc_attr($temperature) . '" placeholder="AI Temperature" class="cr_width_full">
              <br/>
              <h4>' . esc_html__("Top_p", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the AI top_p parameter of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <input type="number" min="0" max="1" step="0.1" name="aiomatic-topp" value="' . esc_attr($topp) . '" placeholder="AI Top_p" class="cr_width_full">
              <br/>
              <h4>' . esc_html__("Presence Penalty", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the AI presence penalty parameter of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <input type="number" min="-2" step="0.1" max="2" name="aiomatic-presence" value="' . esc_attr($presence) . '" placeholder="AI Presence Penalty" class="cr_width_full">
              <br/>
              <h4>' . esc_html__("Frequency Penalty", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the AI frequency penalty parameter of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <input type="number" min="0" max="2" step="0.1" name="aiomatic-frequency" value="' . esc_attr($frequency) . '" placeholder="AI Frequency penalty" class="cr_width_full">
              </div>
              <hr/>
              </div>
              <h2>' . esc_html__("Front End Options", 'aiomatic-automatic-ai-content-writer') . ':</h2>
              <h4>' . esc_html__("Show Header On Front End*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to show the form header to users.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <select name="aiomatic-header" class="aiomatic-create-template-field-type aiomatic-full-size">
                 <option value="show"';
                 if($header == 'show')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>Show</option>
                 <option value="hide"';
                 if($header == 'hide')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>Hide</option>
              </select>
              <br/>
              <h4 class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= '">' . esc_html__("Display AI Form Results In", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to show the form results in a modern WP Editor instead of a plain textarea.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <select name="aiomatic-editor" class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= ' aiomatic-create-template-field-type aiomatic-full-size">
                 <option value="textarea"';
                 if($editor == 'textarea')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>Textarea</option>
                 <option value="wpeditor"';
                 if($editor == 'wpeditor')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>WP Editor</option>
              </select>
              <br class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= '"/>
              <h4 class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= '">' . esc_html__("Show Advanced Form Options", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you want to show the advanced form options to users.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <select name="aiomatic-advanced" class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= ' aiomatic-create-template-field-type aiomatic-full-size">
                 <option value="hide"';
                 if($advanced == 'hide')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>Hide</option>
                 <option value="show"';
                 if($advanced == 'show')
                 {
                    $result .= ' selected';
                 }
                 $result .= '>Show</option>
              </select>
              <br class="aiomatic-hide-not-text';
              if($type != 'text')
              {
                $result .= ' aiomatic-hidden-form';
              }
              $result .= '"/>
              <h4>' . esc_html__("Submit Button Text*", 'aiomatic-automatic-ai-content-writer') . ':<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
              <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the submit button text of this form.", 'aiomatic-automatic-ai-content-writer') . '</div>
              </div></h4>
              <input id="aiomatic-submit_edit" name="aiomatic-submit" value="' . esc_attr($submit) . '" class="aiomatic-full-size" placeholder="Submit" required>
            <br/><br/>
            <button type="submit" id="aiomatic-form-save-button_edit" class="button button-primary">' . esc_html__("Save", 'aiomatic-automatic-ai-content-writer') . '</button>
           <div class="aiomatic-forms-success"></div>
        </form>';
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['data'] = $result;
        }
        else{
            $aiomatic_result['msg'] = 'Form not found';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_scrape_url_embeddings', 'aiomatic_scrape_url_embeddings');
function aiomatic_scrape_url_embeddings()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings scraping');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['xurl']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
        {
            $file_data = aiomatic_scrape_page(trim($_POST['xurl']), '0', 'auto', '');
            if($file_data === false)
            {
                $aiomatic_result['msg'] = 'Incorrect AJAX call';
            }
            else
            {
                $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                $appids = array_filter($appids);
                $token = $appids[array_rand($appids)];
                require_once(dirname(__FILE__) . "/res/Embeddings.php");
                $embdedding = new Aiomatic_Embeddings($token);
                $aiomatic_result = $embdedding->aiomatic_create_single_embedding_nojson(stripslashes($file_data));
            }
        }
        else
        {
            $aiomatic_result['msg'] = 'Please set up API key';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_embeddings_upload', 'aiomatic_embeddings_upload');
function aiomatic_embeddings_upload()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings uploading');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['xfile']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
        {
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            require_once(dirname(__FILE__) . "/res/Embeddings.php");
            $embdedding = new Aiomatic_Embeddings($token);
            $aiomatic_result = $embdedding->aiomatic_create_embeddings(stripslashes($_POST['xfile']));
        }
        else
        {
            $aiomatic_result['msg'] = 'Please set up API key';
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_deleteall_embedding', 'aiomatic_deleteall_embedding');
function aiomatic_deleteall_embedding()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with general embeddings deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        require_once(dirname(__FILE__) . "/res/Embeddings.php");
        $embdedding = new Aiomatic_Embeddings($token);
        $aiomatic_result = $embdedding->aiomatic_deleteall_embeddings();
    }
    else
    {
        $aiomatic_result['msg'] = 'Please set up API key for embeddings';
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_delete_selected_embedding', 'aiomatic_delete_selected_embedding');
function aiomatic_delete_selected_embedding()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with embeddings deletion');
    check_ajax_referer('openai-ajax-nonce', 'nonce');
    if(!isset($_POST['ids']))
    {
        $aiomatic_result['msg'] = 'Incorrect AJAX call';
    }
    else
    {
        if(count($_POST['ids'])) {
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (isset($aiomatic_Main_Settings['app_id']) && trim($aiomatic_Main_Settings['app_id']) != '') 
            {
                $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                $appids = array_filter($appids);
                $token = $appids[array_rand($appids)];
                require_once(dirname(__FILE__) . "/res/Embeddings.php");
                $embdedding = new Aiomatic_Embeddings($token);
                $aiomatic_result = $embdedding->aiomatic_delete_embeddings_ids($_POST['ids']);
            }
            else
            {
                $aiomatic_result['msg'] = 'Please set up API key for embeddings deletion';
            }
        }
    }
    wp_send_json($aiomatic_result);
    die();
}
add_action('wp_ajax_aiomatic_erase_action', 'aiomatic_erase_action');
function aiomatic_erase_action()
{
    check_ajax_referer('openai-run-nonce', 'nonce');
    $param = '';
    if(isset($_POST['id']))
    {
        $param = $_POST['id'];
    }
    else
    {
        aiomatic_log_to_file('Incorrect POST request sent');
        echo 'fail';
        die();
    }
    $rules = get_option('aiomatic_omni_list', array());
    if (!empty($rules)) 
    {
        $found = 0;
        $cont = 0;
        $main_keywords = '';
        foreach ($rules as $request => $bundle[]) 
        {
            if ($cont == $param) 
            {
                $bundle_values    = array_values($bundle);
                $myValues         = $bundle_values[$cont];
                $array_my_values  = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
                $main_keywords    = isset($array_my_values[4]) ? $array_my_values[4] : '';
                $found            = 1;
                break;
            }
            $cont = $cont + 1;
        }
        if($found === 0)
        {
            aiomatic_log_to_file('Rule ID not found in rules list: ' . $param);
            echo 'fail';
            die();
        }
        $keyword_arr = preg_split('/\r\n|\r|\n/', trim($main_keywords));
        aiomatic_remove_processed_keywords($keyword_arr);
        echo 'ok';
        die();
    } 
    else 
    {
        aiomatic_log_to_file('No rules found for aiomatic_omni_list!');
        echo 'fail';
        die();
    }
}
add_action('wp_ajax_aiomatic_my_action', 'aiomatic_my_action_callback');
function aiomatic_my_action_callback()
{
    check_ajax_referer('openai-run-nonce', 'nonce');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $failed                 = false;
    $del_id                 = $_POST['id'];
    if(isset($_POST['type']))
    {
        $type                   = $_POST['type'];
    }
    else
    {
        $type                   = '0';
    }
    $how                    = $_POST['how'];
    if($how == 'duplicate')
    {
        if($type == 0)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_rules_list', 'options');
            if (!get_option('aiomatic_rules_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_rules_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[109] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_rules_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_rules_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_rules_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 1)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_youtube_list', 'options');
            if (!get_option('aiomatic_youtube_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_youtube_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[97] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_youtube_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_youtube_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_youtube_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 2)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_amazon_list', 'options');
            if (!get_option('aiomatic_amazon_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_amazon_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[94] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_amazon_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_amazon_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_amazon_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 3)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_review_list', 'options');
            if (!get_option('aiomatic_review_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_review_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[88] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_review_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_review_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_review_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 4)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_csv_list', 'options');
            if (!get_option('aiomatic_csv_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_csv_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[31] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_csv_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_csv_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_csv_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 5)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_omni_list', 'options');
            if (!get_option('aiomatic_omni_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_omni_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[7] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_omni_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_omni_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_omni_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 6)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_listicle_list', 'options');
            if (!get_option('aiomatic_listicle_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_listicle_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $copy_bundle[2] = '1988-01-27 00:00:00';
                        $copy_bundle[95] = uniqid('', true);
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    aiomatic_log_to_file('aiomatic_listicle_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('aiomatic_listicle_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_listicle_list empty!');
                echo 'nochange';
                die();
            }
        }
        else
        {
            aiomatic_log_to_file('Unknown type submitted: ' . $type);
            echo 'nochange';
            die();
        }
    }
    $force_delete           = true;
    $number                 = 0;
    if ($how == 'trash') 
    {
        $force_delete = false;
    }
    else
    {
        if($type == 5)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_omni_list', 'options');
            if (!get_option('aiomatic_omni_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_omni_list');
            }
            $cont = 0;
            foreach ($rules as $request => $bundle) 
            {
                if (isset($bundle[7]) && $bundle[7] == $del_id && isset($bundle[4])) 
                {
                    $keyword_arr = preg_split('/\r\n|\r|\n/', trim($bundle[4]));
                    aiomatic_remove_processed_keywords($keyword_arr);
                    break;
                }
                $cont = $cont + 1;
            }
        }
    }
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
        $index = get_post_meta($post, 'aiomatic_parent_rule', true);
        if ($index == $type . '-' . $del_id || $index == $del_id) 
        {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, $force_delete);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('[PostDelete] Failed to delete all posts for rule id: ' . esc_html($del_id) . '!');
        }
        echo 'failed';
    } else {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts for rule id: ' . esc_html($del_id) . '!');
        }
        if ($number == 0) {
            echo 'nochange';
        } else {
            echo 'ok';
        }
    }
    die();
}

add_action('wp_ajax_aiomatic_my_action_move', 'aiomatic_my_action_move_callback');
function aiomatic_my_action_move_callback()
{
    check_ajax_referer('openai-run-nonce', 'nonce');
    $del_id                 = $_POST['id'];
    if(isset($_POST['type']))
    {
        $type                   = $_POST['type'];
    }
    else
    {
        $type                   = '0';
    }
    $how                    = $_POST['how'];
    if($how == 'up')
    {
        if($type == 0)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_rules_list', 'options');
            if (!get_option('aiomatic_rules_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_rules_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_rules_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_rules_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_rules_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 1)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_youtube_list', 'options');
            if (!get_option('aiomatic_youtube_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_youtube_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_youtube_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_youtube_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_youtube_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 2)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_amazon_list', 'options');
            if (!get_option('aiomatic_amazon_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_amazon_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_amazon_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_amazon_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_amazon_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 3)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_review_list', 'options');
            if (!get_option('aiomatic_review_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_review_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_review_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_review_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_review_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 4)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_csv_list', 'options');
            if (!get_option('aiomatic_csv_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_csv_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_csv_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_csv_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_csv_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 5)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_omni_list', 'options');
            if (!get_option('aiomatic_omni_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_omni_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_omni_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_omni_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_omni_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 6)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_listicle_list', 'options');
            if (!get_option('aiomatic_listicle_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_listicle_list');
            }
            if (!empty($rules)) {
                if ($del_id > 0 && $del_id < count($rules)) {
                    $temp = $rules[$del_id - 1];
                    $rules[$del_id - 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    update_option('aiomatic_listicle_list', $rules, false);
                    echo 'ok';
                    die();
                }
                else {
                    aiomatic_log_to_file('aiomatic_listicle_list index out of bounds for move up: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_listicle_list empty!');
                echo 'nochange';
                die();
            }
        }
        else
        {
            aiomatic_log_to_file('Unknown type submitted: ' . $type);
            echo 'nochange';
            die();
        }
    }
    elseif($how == 'down')
    {
        if($type == 0)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_rules_list', 'options');
            if (!get_option('aiomatic_rules_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_rules_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_rules_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_rules_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_rules_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 1)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_youtube_list', 'options');
            if (!get_option('aiomatic_youtube_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_youtube_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_youtube_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_youtube_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_youtube_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 2)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_amazon_list', 'options');
            if (!get_option('aiomatic_amazon_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_amazon_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_amazon_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_amazon_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_amazon_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 3)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_review_list', 'options');
            if (!get_option('aiomatic_review_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_review_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_review_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_review_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_review_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 4)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_csv_list', 'options');
            if (!get_option('aiomatic_csv_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_csv_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_csv_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_csv_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_csv_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 5)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_omni_list', 'options');
            if (!get_option('aiomatic_omni_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_omni_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_omni_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_omni_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_omni_list empty!');
                echo 'nochange';
                die();
            }
        }
        elseif($type == 6)
        {
            $GLOBALS['wp_object_cache']->delete('aiomatic_listicle_list', 'options');
            if (!get_option('aiomatic_listicle_list')) {
                $rules = array();
            } else {
                $rules = get_option('aiomatic_listicle_list');
            }
            if (!empty($rules)) {
                if ($del_id >= 0 && $del_id < count($rules) - 1) {
                    $temp = $rules[$del_id + 1];
                    $rules[$del_id + 1] = $rules[$del_id];
                    $rules[$del_id] = $temp;
                    
                    update_option('aiomatic_listicle_list', $rules, false);
                    echo 'ok';
                    die();
                } else {
                    aiomatic_log_to_file('aiomatic_listicle_list index out of bounds for move down: ' . $del_id);
                    echo 'nochange';
                    die();
                }
            } else {
                aiomatic_log_to_file('aiomatic_listicle_list empty!');
                echo 'nochange';
                die();
            }
        }
        else
        {
            aiomatic_log_to_file('Unknown type submitted: ' . $type);
            echo 'nochange';
            die();
        }
    }
    else
    {
        aiomatic_log_to_file('Unknown action submitted: ' . $how);
        echo 'nochange';
        die();
    }
    die();
}
add_action('wp_ajax_aiomatic_run_my_action', 'aiomatic_run_my_action_callback');
function aiomatic_run_my_action_callback()
{
    check_ajax_referer('openai-run-nonce', 'nonce');
    if(!isset($_POST['id']))
    {
        die();
    }
    $run_id = $_POST['id'];
    if(isset($_POST['type']))
    {
        $type                   = $_POST['type'];
    }
    else
    {
        $type                   = 0;
    }
    echo aiomatic_run_rule($run_id, $type, 0, 0, null, '', '');
    die();
}
add_action('wp_ajax_aiomatic_run_omniblock', 'aiomatic_run_omniblock_callback');
function aiomatic_run_omniblock_callback()
{
    check_ajax_referer('openai-omni-nonce', 'nonce');
    if(!isset($_POST['id']) || !isset($_POST['uniquid']))
    {
        die();
    }
    $run_id = $_POST['id'];
    if(isset($_POST['type']))
    {
        $type                   = $_POST['type'];
    }
    else
    {
        $type                   = 0;
    }
    $uniquid = $_POST['uniquid'];
    $rezult = aiomatic_run_rule($run_id, $type, 0, 0, null, $uniquid, '');
    if(is_array($rezult))
    {
        echo json_encode($rezult);
    }
    else
    {
        echo $rezult;
    }
    die();
}
add_action('wp_ajax_nopriv_aiomatic_editor', 'aiomatic_editor');
add_action('wp_ajax_aiomatic_editor', 'aiomatic_editor');
function aiomatic_editor() {
	check_ajax_referer('wp_rest', 'nonce');
	$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['assistant_not_logged']) || $aiomatic_Main_Settings['assistant_not_logged'] == 'disable')
    {
        if(!is_user_logged_in())
        {
            wp_send_json_error( array( 'message' => esc_html__("You need to log in to perform this action!", 'aiomatic-automatic-ai-content-writer') ) );
        }
    }
    if(!isset($_POST['prompt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prompt)' ) );
	}
	$prompt = stripslashes(sanitize_text_field( $_POST['prompt'] ));
    if (isset($aiomatic_Main_Settings['assistant_disable']) && $aiomatic_Main_Settings['assistant_disable'] == 'on')
    {
        wp_send_json_error( array( 'message' => 'Assistant disabled in plugin settings' ) );
    }
    if (!isset($aiomatic_Main_Settings['aiomatic_enabled']) || $aiomatic_Main_Settings['aiomatic_enabled'] != 'on')
    {
        wp_send_json_error( array( 'message' => 'Aiomatic plugin disabled' ) );
    }
    if(isset($aiomatic_Main_Settings['assistant_model']) && $aiomatic_Main_Settings['assistant_model'] != '')
    {
        $model = $aiomatic_Main_Settings['assistant_model'];
    }
    else
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
    if(isset($aiomatic_Main_Settings['wizard_assistant_id']) && $aiomatic_Main_Settings['wizard_assistant_id'] != '')
    {
        $wizard_assistant_id = $aiomatic_Main_Settings['wizard_assistant_id'];
    }
    else
    {
        $wizard_assistant_id = '';
    }
	$temperature = 1;
    if(isset($aiomatic_Main_Settings['assistant_temperature']) && $aiomatic_Main_Settings['assistant_temperature'] != '')
    {
        $temperature = intval($aiomatic_Main_Settings['assistant_temperature']);
    }
	$top_p = 1;
    if(isset($aiomatic_Main_Settings['assistant_top_p']) && $aiomatic_Main_Settings['assistant_top_p'] != '')
    {
        $top_p = intval($aiomatic_Main_Settings['assistant_top_p']);
    }
	$fpenalty = 0;
    if(isset($aiomatic_Main_Settings['assistant_fpenalty']) && $aiomatic_Main_Settings['assistant_fpenalty'] != '')
    {
        $fpenalty = intval($aiomatic_Main_Settings['assistant_fpenalty']);
    }
	$ppenalty = 0;
    if(isset($aiomatic_Main_Settings['assistant_ppenalty']) && $aiomatic_Main_Settings['assistant_ppenalty'] != '')
    {
        $ppenalty = intval($aiomatic_Main_Settings['assistant_ppenalty']);
    }
	$max_tokens = aiomatic_get_max_tokens($model);
	$all_models = aiomatic_get_all_models(true);
	if(!in_array($model, $all_models))
    {
        $model = get_default_model_name($aiomatic_Main_Settings);
    }
	if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
	$new_post_content = '';
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
	$query_token_count = count(aiomatic_encode($prompt));
	$available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
	if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
	{
		$string_len = strlen($prompt);
		$string_len = $string_len / 2;
		$string_len = intval(0 - $string_len);
        $aicontent = aiomatic_substr($prompt, 0, $string_len);
		$aicontent = trim($aicontent);
		if(empty($aicontent))
		{
			wp_send_json_error( array( 'message' => 'Incorrect prompt provided!' ) );
		}
		$query_token_count = count(aiomatic_encode($aicontent));
		$available_tokens = $max_tokens - $query_token_count;
	}
    $thread_id = '';
	$aierror = '';
	$finish_reason = '';
	$generated_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, $temperature, $top_p, $ppenalty, $fpenalty, false, 'aiAssistantWriter', 0, $finish_reason, $aierror, false, false, false, '', '', 'user', $wizard_assistant_id, $thread_id, '', 'disabled', '', false);
	if($generated_text === false)
	{
		wp_send_json_error( array( 'message' => 'Failed to generate AI content: ' . $aierror) );
	}
	else
	{
		$new_post_content = aiomatic_sanitize_ai_result($generated_text);
	}
    do_action('aiomatic_assistant_text_reply', $new_post_content);
	wp_send_json_success( array( 'content' => $new_post_content ) );
    die();
}
add_action('wp_ajax_nopriv_aiomatic_shortcode_replacer', 'aiomatic_shortcode_replacer');
add_action('wp_ajax_aiomatic_shortcode_replacer', 'aiomatic_shortcode_replacer');
function aiomatic_shortcode_replacer() 
{
	check_ajax_referer('wp_rest', 'nonce');
    if(!isset($_POST['postId']) || !isset($_POST['send_prompt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (postId or send_prompt)' ) );
	}
	$postId = stripslashes(sanitize_text_field( $_POST['postId'] ));
	$send_prompt = stripslashes( $_POST['send_prompt'] );
    $post = get_post($postId);
    if($post === null)
    {
        wp_send_json_error( array( 'message' => 'Incorrect postId sent ' . print_r($_POST, true) ) );
        exit;
    }
    $blog_title = html_entity_decode(get_bloginfo('title'));
    $post_link = get_permalink($postId);
    $post_title = $post->post_title;
    $post_excerpt = $post->post_excerpt;
    $post_content = $post->post_content;
    $author_obj       = get_user_by('id', $post->post_author);
    if($author_obj !== false && isset($author_obj->user_nicename))
    {
        $user_name        = $author_obj->user_nicename;
    }
    else
    {
        $user_name        = '';
    }
    $featured_image   = '';
    wp_suspend_cache_addition(true);
    $metas = get_post_custom($post->ID);
    wp_suspend_cache_addition(false);
    if(is_array($metas))
    {
        $rez_meta = aiomatic_preg_grep_keys('#.+?_featured_ima?ge?#i', $metas);
    }
    else
    {
        $rez_meta = array();
    }
    if(count($rez_meta) > 0)
    {
        foreach($rez_meta as $rm)
        {
            if(isset($rm[0]) && filter_var($rm[0], FILTER_VALIDATE_URL))
            {
                $featured_image = $rm[0];
                break;
            }
        }
    }
    if($featured_image == '')
    {
        $featured_image = aiomatic_generate_thumbmail($post->ID);
    }
    if($featured_image == '' && $post_content != '')
    {
        $dom     = new DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($post_content);
        libxml_use_internal_errors($internalErrors);
        $tags      = $dom->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $temp_get_img = $tag->getAttribute('src');
            if ($temp_get_img != '') {
                $temp_get_img = strtok($temp_get_img, '?');
                $featured_image = rtrim($temp_get_img, '/');
            }
        }
    }
    $post_cats = '';
    $post_categories = wp_get_post_categories( $post->ID );
    foreach($post_categories as $c){
        $cat = get_category( $c );
        $post_cats .= $cat->name . ',';
    }
    $post_cats = trim($post_cats, ',');
    if($post_cats != '')
    {
        $post_categories = explode(',', $post_cats);
    }
    else
    {
        $post_categories = array();
    }
    if(count($post_categories) == 0)
    {
        $terms = get_the_terms( $post->ID, 'product_cat' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $post_categories[] = $term->slug;
            }
            $post_cats = implode(',', $post_categories);
        }
        
    }
    $post_tagz = '';
    $post_tags = wp_get_post_tags( $post->ID );
    foreach($post_tags as $t){
        $post_tagz .= $t->name . ',';
    }
    $post_tagz = trim($post_tagz, ',');
    if($post_tagz != '')
    {
        $post_tags = explode(',', $post_tagz);
    }
    else
    {
        $post_tags = array();
    }
    if(count($post_tags) == 0)
    {
        $terms = get_the_terms( $post->ID, 'product_tag' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $post_tags[] = $term->slug;
            }
            $post_tagz = implode(',', $post_tags);
        }
        
    }
    $send_prompt = replaceAIPostShortcodes($send_prompt, $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz, $postId, '', '', '', '', '', '');
	wp_send_json_success( array( 'content' => $send_prompt ) );
    die();
}
add_action('wp_ajax_aiomatic_imager', 'aiomatic_imager');
function aiomatic_imager() {
	check_ajax_referer('wp_rest', 'nonce');

    if(!isset($_POST['prompt']))
	{
		wp_send_json_error( array( 'message' => 'Incorrect query sent (prompt)' ) );
	}
	$prompt = stripslashes(sanitize_text_field( $_POST['prompt'] ));

	$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['assistant_disable']) && $aiomatic_Main_Settings['assistant_disable'] == 'on')
    {
        wp_send_json_error( array( 'message' => 'Assistant disabled in plugin settings' ) );
    }
    if (!isset($aiomatic_Main_Settings['aiomatic_enabled']) || $aiomatic_Main_Settings['aiomatic_enabled'] != 'on')
    {
        wp_send_json_error( array( 'message' => 'Aiomatic plugin disabled' ) );
    }
	if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
		wp_send_json_error( array( 'message' => 'You need to enter an OpenAI API key in plugin settings!' ) );
	}
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
	$appids = array_filter($appids);
	$token = $appids[array_rand($appids)];
    $image_size = '512x512';
	if (isset($aiomatic_Main_Settings['assistant_image_size']) && trim($aiomatic_Main_Settings['assistant_image_size']) != '') 
    {
        $image_size = $aiomatic_Main_Settings['assistant_image_size'];
    }
    $image_model = 'dalle2';
	if (isset($aiomatic_Main_Settings['assistant_image_model']) && trim($aiomatic_Main_Settings['assistant_image_model']) != '') 
    {
        $image_model = $aiomatic_Main_Settings['assistant_image_model'];
    }
    if($image_model == 'stability')
    {
        $echo_ok = false;
        $height = '512';
        $width = '512';
        if ($image_size == '1024x1024') 
        {
            $height = '1024';
            $width = '1024';
        }
        $ierror = '';
        $arr_response_text = aiomatic_generate_stability_image($prompt, $height, $width, 'aiAssistantStableImage', 0, false, $ierror, false, false);
        if($arr_response_text === false)
        {
            wp_send_json_error( array( 'message' => 'Error occurred when calling Stability.ai API in image assistant: ' . $ierror) );
        }
        else
        {
            if(!isset($arr_response_text[1]))
            {
                wp_send_json_error( array( 'message' => 'Error occurred when calling Stability.ai API in image assistant, incorrect reply!') );
            }
            $image = '<img src="' . $arr_response_text[1] . '">';
            $echo_ok = true;
        }
        if($echo_ok === false)
        {
            wp_send_json_error( array( 'message' => 'No image returned from Stability.ai API call: ' . $prompt) );
        }
    }
    elseif($image_model == 'midjourney')
    {
        $echo_ok = false;
        $height = '512';
        $width = '512';
        if ($image_size == '1024x1024') 
        {
            $height = '1024';
            $width = '1024';
        }
        elseif ($image_size == '1024x1792') 
        {
            $height = '1792';
            $width = '1024';
        }
        elseif ($image_size == '1792x1024') 
        {
            $height = '1024';
            $width = '1792';
        }
        $ierror = '';
        $arr_response_text = aiomatic_generate_ai_image_midjourney($prompt, $width, $height, 'aiAssistantMidjourneyImage', false, $ierror);
        if($arr_response_text === false)
        {
            wp_send_json_error( array( 'message' => 'Error occurred when calling GoAPI (midjourney) API in image assistant: ' . $ierror) );
        }
        else
        {
            if(!isset($arr_response_text))
            {
                wp_send_json_error( array( 'message' => 'Error occurred when calling GoAPI (midjourney) in image assistant, incorrect reply!') );
            }
            $image = '<img src="' . $arr_response_text . '">';
            $echo_ok = true;
        }
        if($echo_ok === false)
        {
            wp_send_json_error( array( 'message' => 'No image returned from GoAPI (midjourney) API call: ' . $prompt) );
        }
    }
    else
    {
        $error = '';
        $image = '';
        $echo_ok = false;
        $response_text = aiomatic_generate_ai_image($token, 1, $prompt, $image_size, 'aiAssistantImage', true, 0, $error, $image_model);
        if($response_text === false)
        {
            wp_send_json_error( array( 'message' => 'Error occurred when calling API in image assistant: ' . $error) );
        }
        else
        {
            foreach($response_text as $tmpimg)
            {
                $localpath = aiomatic_copy_image_locally($tmpimg);
                if($localpath !== false)
                {
                    $image = '<img src="' . $localpath[0] . '">';
                    $echo_ok = true;
                    break;
                }
                else
                {
                    wp_send_json_error( array( 'message' => 'Failed to copy image file locally: ' . $tmpimg) );
                }
            }
        }
        if($echo_ok === false)
        {
            wp_send_json_error( array( 'message' => 'No image returned from API call: ' . $prompt) );
        }
    }
	if($image === false)
	{
		wp_send_json_error( array( 'message' => 'Failed to generate AI image: ' . $error) );
	}
    do_action('aiomatic_assistant_image_reply', $image);
	wp_send_json_success( array( 'content' => $image ) );
    die();
}

add_action('wp_ajax_aiomatic_form_submit', 'aiomatic_form_submit');
add_action('wp_ajax_nopriv_aiomatic_form_submit', 'aiomatic_form_submit');
function aiomatic_form_submit() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with form submission');
    $response_text = '';
    if(!isset($_POST['presence']) || !isset($_POST['input_text']) || !isset($_POST['model']) || !isset($_POST['temp']) || !isset($_POST['top_p']) || !isset($_POST['frequency']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for form submission';
        wp_send_json($aiomatic_result);
    }
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
	$user_id = sanitize_text_field($_POST['user_id']);
    if(isset($_POST['aiomaticType']))
    {
	    $aiomaticType = sanitize_text_field($_POST['aiomaticType']);
    }
    else
    {
        $aiomaticType = 'none';
    }
	$input_text = stripslashes($_POST['input_text']);
	$model = sanitize_text_field(stripslashes($_POST['model']));
    if($model == 'default')
    {
        $model = AIOMATIC_DEFAULT_MODEL;
    }
	$assistant_id = sanitize_text_field(stripslashes($_POST['assistant_id']));
	$temperature = sanitize_text_field($_POST['temp']);
	$top_p = sanitize_text_field($_POST['top_p']);
	$presence_penalty = sanitize_text_field($_POST['presence']);
	$frequency_penalty = sanitize_text_field($_POST['frequency']);
    $all_models = aiomatic_get_all_models(true);
    $models = $all_models;
    if(!in_array($model, $models))
    {
        $aiomatic_result['msg'] = 'Invalid model provided: ' . $model;
        wp_send_json($aiomatic_result);
    }
    $temperature = floatval($temperature);
    $top_p = floatval($top_p);
    $presence_penalty = floatval($presence_penalty);
    $frequency_penalty = floatval($frequency_penalty);
    if($temperature < 0 || $temperature > 2)
    {
        $aiomatic_result['msg'] = 'Invalid temperature provided: ' . $temperature;
        wp_send_json($aiomatic_result);
    }
    if($top_p < 0 || $top_p > 1)
    {
        $aiomatic_result['msg'] = 'Invalid top_p provided: ' . $top_p;
        wp_send_json($aiomatic_result);
    }
    if($presence_penalty < -2 || $presence_penalty > 2)
    {
        $aiomatic_result['msg'] = 'Invalid presence_penalty provided: ' . $presence_penalty;
        wp_send_json($aiomatic_result);
    }
    if($frequency_penalty < -2 || $frequency_penalty > 2)
    {
        $aiomatic_result['msg'] = 'Invalid frequency_penalty provided: ' . $frequency_penalty;
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = 'You need to insert a valid OpenAI/AiomaticAPI API Key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = 'Daily token count of your user account has been exceeded! Please try again tomorrow.';
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    do_action('aiomatic_calling_forms', $input_text, $model);
    if($aiomaticType == 'text' || $aiomaticType == 'none')
    {
        $max_tokens = aiomatic_get_max_tokens($model);
        $input_text = preg_replace('#<br\s*/?>#i', "\n", $input_text);
        $input_text = htmlspecialchars_decode($input_text, ENT_QUOTES);
        $input_text = stripslashes($input_text);
        $input_text = preg_replace('#<div><span class="highlight-none">([\s\S]*?)<\/span><\/div>#i', PHP_EOL . '$1', $input_text);
        $input_text = preg_replace('#<span class="highlight-none">([\s\S]*?)<\/span>#i', '$1', $input_text);
        $query_token_count = count(aiomatic_encode($input_text));
        $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $input_text, $query_token_count);
        if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
        {
            $string_len = strlen($input_text);
            $string_len = $string_len / 2;
            $string_len = intval(0 - $string_len);
            $input_text = aiomatic_substr($input_text, 0, $string_len);
            $input_text = trim($input_text);
            if(empty($input_text))
            {
                aiomatic_log_to_file('Empty API seed expression provided (after processing)');
                wp_die();
            }
            $query_token_count = count(aiomatic_encode($input_text));
            $available_tokens = $max_tokens - $query_token_count;
        }
        $thread_id = '';
        $error = '';
        $finish_reason = '';
        if($aiomaticType == 'text')
        {
            $response_text = aiomatic_generate_text($token, $model, $input_text, $available_tokens, $temperature, $top_p, $presence_penalty, $frequency_penalty, false, 'formsText', 0, $finish_reason, $error, false, false, false, '', '', 'user', $assistant_id, $thread_id, '', 'disabled', '', false);
        }
        else
        {
            $response_text = aiomatic_generate_text($token, $model, $input_text, $available_tokens, $temperature, $top_p, $presence_penalty, $frequency_penalty, false, 'shortcodeCompletion', 0, $finish_reason, $error, false, false, false, '', '', 'user', $assistant_id, $thread_id, '', 'disabled', '', false);
        }
        if($response_text === false)
        {
            $aiomatic_result['msg'] = $error;
            wp_send_json($aiomatic_result);
        }
        else
        {
            $inp_count = count(aiomatic_encode($input_text));
            $resp_count = count(aiomatic_encode($response_text));
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + $inp_count + $resp_count;
                update_user_meta($user_id, 'aiomatic_used_tokens', $used_token_count);
            }
        }
    }
    elseif($aiomaticType == 'image')
    {
        $echo_ok = false;
        $error = '';
        $image_size = '512x512';
        if (isset($aiomatic_Main_Settings['ai_image_size']) && trim($aiomatic_Main_Settings['ai_image_size']) != '') 
        {
            $image_size = trim($aiomatic_Main_Settings['ai_image_size']);
        }
        $image_model = 'dalle2';
        $arr_response_text = aiomatic_generate_ai_image($token, 1, $input_text, $image_size, 'formsImage', false, 0, $error, $image_model);
        if($arr_response_text === false)
        {
            $aiomatic_result['msg'] = $error;
            wp_send_json($aiomatic_result);
        }
        else
        {
            foreach($arr_response_text as $tmpimg)
            {
                $response_text = $tmpimg;
                $echo_ok = true;
            }
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_image_chat_tokens', $used_token_count);
            }
        }
        if($echo_ok === false)
        {
            $aiomatic_result['msg'] = 'No image returned from API call: ' . $input_text;
            wp_send_json($aiomatic_result);
        }
    }
    elseif($aiomaticType == 'image-new')
    {
        $echo_ok = false;
        $error = '';
        $image_size = '1024x1024';
        if (isset($aiomatic_Main_Settings['ai_image_size']) && trim($aiomatic_Main_Settings['ai_image_size']) != '') 
        {
            $image_size = trim($aiomatic_Main_Settings['ai_image_size']);
        }
        $image_model = 'dalle3';
        $arr_response_text = aiomatic_generate_ai_image($token, 1, $input_text, $image_size, 'formsImage', false, 0, $error, $image_model);
        if($arr_response_text === false)
        {
            $aiomatic_result['msg'] = $error;
            wp_send_json($aiomatic_result);
        }
        else
        {
            foreach($arr_response_text as $tmpimg)
            {
                $response_text = $tmpimg;
                $echo_ok = true;
            }
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_image_chat_tokens', $used_token_count);
            }
        }
        if($echo_ok === false)
        {
            $aiomatic_result['msg'] = 'No image returned from API call: ' . $input_text;
            wp_send_json($aiomatic_result);
        }
    }
    elseif($aiomaticType == 'image2')
    {
        $echo_ok = false;
        $height = '512';
        $width = '512';
        if (isset($aiomatic_Main_Settings['ai_image_size']) && trim($aiomatic_Main_Settings['ai_image_size']) != '') 
        {
            if(trim($aiomatic_Main_Settings['ai_image_size']) == '1024x1024')
            {
                $height = '1024';
                $width = '1024';
            }
        }
        $ierror = '';
        $arr_response_text = aiomatic_generate_stability_image($input_text, $height, $width, 'formsStableImage', 0, true, $ierror, false, false);
        if($arr_response_text === false)
        {
            $aiomatic_result['msg'] = $ierror;
            wp_send_json($aiomatic_result);
        }
        else
        {
            $response_text = $arr_response_text;
            $echo_ok = true;
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_image_chat_tokens', $used_token_count);
            }
        }
        if($echo_ok === false)
        {
            $aiomatic_result['msg'] = 'No image returned from API call: ' . $input_text;
            wp_send_json($aiomatic_result);
        }
    }
    elseif($aiomaticType == 'image-mid')
    {
        $echo_ok = false;
        $height = '512';
        $width = '512';
        if (isset($aiomatic_Main_Settings['ai_image_size']) && trim($aiomatic_Main_Settings['ai_image_size']) != '') 
        {
            if(trim($aiomatic_Main_Settings['ai_image_size']) == '1024x1024')
            {
                $height = '1024';
                $width = '1024';
            }
            elseif(trim($aiomatic_Main_Settings['ai_image_size']) == '1024x1792')
            {
                $height = '1792';
                $width = '1024';
            }
            elseif(trim($aiomatic_Main_Settings['ai_image_size']) == '1792x1024')
            {
                $height = '1024';
                $width = '1792';
            }
        }
        $ierror = '';
        $arr_response_text = aiomatic_generate_ai_image_midjourney($input_text, $width, $height, 'formsMidjourneyImage', true, $ierror);
        if($arr_response_text === false)
        {
            $aiomatic_result['msg'] = $ierror;
            wp_send_json($aiomatic_result);
        }
        else
        {
            $response_text = $arr_response_text;
            $echo_ok = true;
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + 1000;
                update_user_meta($user_id, 'aiomatic_used_image_chat_tokens', $used_token_count);
            }
        }
        if($echo_ok === false)
        {
            $aiomatic_result['msg'] = 'No image returned from API call: ' . $input_text;
            wp_send_json($aiomatic_result);
        }
    }
    else
    {
        $aiomatic_result['msg'] = 'Unknown request type submitted: ' . esc_html($aiomaticType);
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['status'] = 'success';
    $aiomatic_result['data'] = esc_html($response_text);
    do_action('aiomatic_form_reply', $response_text);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_scrape_form_submit', 'aiomatic_scrape_form_submit');
add_action('wp_ajax_nopriv_aiomatic_scrape_form_submit', 'aiomatic_scrape_form_submit');
function aiomatic_scrape_form_submit() 
{
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with form submission');
    if(!isset($_POST['scrapeurl']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for text scraping';
        wp_send_json($aiomatic_result);
    }
    $scraped_data = '';
    $scrapeurl = trim($_POST['scrapeurl']);
    if(filter_var($scrapeurl, FILTER_VALIDATE_URL))
    {
        $scraped_data = aiomatic_scrape_page($scrapeurl, '0', 'auto', '');
        if($scraped_data === false)
        {
            $aiomatic_result['msg'] = 'Incorrect AJAX call';
        }
        else
        {
            $aiomatic_result['status'] = 'success';
            $aiomatic_result['data'] = $scraped_data;
        }
    }
    else
    {
        $aiomatic_result['msg'] = 'Unknown URL format submitted: ' . esc_url($scrapeurl);
    }
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_edit_submit', 'aiomatic_edit_submit');
add_action('wp_ajax_nopriv_aiomatic_edit_submit', 'aiomatic_edit_submit');

function aiomatic_edit_submit() {
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with edit submission');
    if(!isset($_POST['instruction']) || !isset($_POST['input_text']) || !isset($_POST['model']) || !isset($_POST['temp']) || !isset($_POST['top_p']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for text editing';
        wp_send_json($aiomatic_result);
    }
	$instruction = stripslashes($_POST['instruction']);
	$input_text = stripslashes($_POST['input_text']);
	$model = sanitize_text_field($_POST['model']);
	$temperature = sanitize_text_field($_POST['temp']);
	$top_p = sanitize_text_field($_POST['top_p']);
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
	$user_id = sanitize_text_field($_POST['user_id']);
    $temperature = floatval($temperature);
    $top_p = floatval($top_p);
    $models = aiomatic_get_all_models(true);
    if(!in_array($model, $models))
    {
        $aiomatic_result['msg'] = 'Invalid editing model provided: ' . $model;
        wp_send_json($aiomatic_result);
    }
    if($temperature < 0 || $temperature > 2)
    {
        $aiomatic_result['msg'] = 'Invalid temperature provided: ' . $temperature;
        wp_send_json($aiomatic_result);
    }
    if($top_p < 0 || $top_p > 1)
    {
        $aiomatic_result['msg'] = 'Invalid top_p provided: ' . $top_p;
        wp_send_json($aiomatic_result);
    }
    if(empty($instruction))
    {
        $aiomatic_result['msg'] = 'You need to add an instruction for the text editing!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = 'You need to insert a valid OpenAI/AiomaticAPI API Key for this to work!';
        wp_send_json($aiomatic_result);
    }
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_edit_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = 'Daily token count of your user account is exceeded! Please try again tomorrow.';
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    $completionmodels = $models;
    if(in_array($model, $completionmodels))
    {
        if(!aiomatic_endsWith(trim($instruction), ':'))
        {
            $prompt = $instruction . ': ' . $input_text;
        }
        else
        {
            $prompt = $instruction . $input_text;
        }
        $thread_id = '';
        $error = '';
        $finish_reason = '';
        $max_tokens = aiomatic_get_max_tokens($model);
        $prompt = stripslashes($prompt);
        $query_token_count = count(aiomatic_encode($prompt));
        $available_tokens = aiomatic_compute_available_tokens($model, $max_tokens, $prompt, $query_token_count);
        if($available_tokens <= AIOMATIC_MINIMUM_TOKENS_FOR_COMPLETIONS)
        {
            $string_len = strlen($prompt);
            $string_len = $string_len / 2;
            $string_len = intval(0 - $string_len);
            $prompt = aiomatic_substr($prompt, 0, $string_len);
            $prompt = trim($prompt);
            if(empty($prompt))
            {
                $aiomatic_result['msg'] = 'Empty API seed expression provided (after processing)';
                wp_send_json($aiomatic_result);
            }
            else
            {
                $query_token_count = count(aiomatic_encode($prompt));
                $available_tokens = $max_tokens - $query_token_count;
            }
        }
        $response_text = aiomatic_generate_text($token, $model, $prompt, $available_tokens, $temperature, $top_p, 0, 0, false, 'shortcodeCEditor', 0, $finish_reason, $error, false, false, false, '', '', 'user', '', $thread_id, '', 'disabled', '', false);
        if($response_text === false)
        {
            $aiomatic_result['msg'] = $error;
            wp_send_json($aiomatic_result);
        }
        else
        {
            $inp_count = count(aiomatic_encode($prompt));
            $resp_count = count(aiomatic_encode($response_text));
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + $inp_count + $resp_count;
                update_user_meta($user_id, 'aiomatic_used_tokens', $used_token_count);
            }
        }
        $response_text = trim($response_text);
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['data'] = $response_text;
        do_action('aiomatic_editor_reply', $response_text);
        wp_send_json($aiomatic_result);
    }
    else
    {
        $aierror = '';
        $input_text = stripslashes($input_text);
        $instruction = stripslashes($instruction);
        $response_text = aiomatic_edit_text($token, $model, $instruction, $input_text, $temperature, $top_p, 'shortcodeEditor', 0, $aierror);
        if($response_text === false)
        {
            $aiomatic_result['msg'] = $aierror;
            wp_send_json($aiomatic_result);
        }
        else
        {
            $instr_count = count(aiomatic_encode($instruction));
            $inp_count = count(aiomatic_encode($input_text));
            $resp_count = count(aiomatic_encode($response_text));
            if(is_numeric($user_token_cap_per_day))
            {
                $used_token_count = intval($used_token_count) + $instr_count + $inp_count + $resp_count;
                update_user_meta($user_id, 'aiomatic_used_edit_tokens', $used_token_count);
            }
        }
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['data'] = $response_text;
        do_action('aiomatic_editor_reply', $response_text);
        wp_send_json($aiomatic_result);
    }
    die();
}

add_action('wp_ajax_aiomatic_image_chat_submit', 'aiomatic_image_chat_submit');
add_action('wp_ajax_nopriv_aiomatic_image_chat_submit', 'aiomatic_image_chat_submit');

function aiomatic_image_chat_submit() 
{
    $echo_ok = false;
	check_ajax_referer('openai-ajax-images-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with chat submission');
    if(!isset($_POST['input_text']))
    {
        $aiomatic_result['msg'] = 'Incomplete POST request for image chat';
        wp_send_json($aiomatic_result);
    }
    $user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!empty($user_token_cap_per_day))
    {
        $user_token_cap_per_day = intval($user_token_cap_per_day);
    }
	$user_id = sanitize_text_field($_POST['user_id']);
	$input_text = stripslashes($_POST['input_text']);
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
    {
        $aiomatic_result['msg'] = esc_html__('You need to insert a valid OpenAI/AiomaticAPI API Key for this to work!', 'aiomatic-automatic-ai-content-writer');
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    $used_token_count = 0;
    if(is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0 || !is_numeric($user_id))
        {
            $aiomatic_result['msg'] = sprintf( wp_kses( __( 'You are not allowed to access this form if you are not logged in. Please <a href="%s" target="_blank">log in</a> to continue.', 'aiomatic-automatic-ai-content-writer'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), wp_login_url(get_permalink()) );
            wp_send_json($aiomatic_result);
        }
        $used_token_count = get_user_meta($user_id, 'aiomatic_used_image_chat_tokens', true);
        if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
        {
            $used_token_count = intval($used_token_count);
            if($used_token_count > $user_token_cap_per_day)
            {
                $aiomatic_result['msg'] = esc_html__('Daily token limit for your user account was exceeded! Please try again tomorrow.', 'aiomatic-automatic-ai-content-writer');
                wp_send_json($aiomatic_result);
            }
        }
        else
        {
            $used_token_count = 0;
        }
    }
	$appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
	$error = '';
    $image_size = '512x512';
	if (isset($aiomatic_Chatbot_Settings['image_chat_size']) && trim($aiomatic_Chatbot_Settings['image_chat_size']) != '') 
    {
        $image_size = $aiomatic_Chatbot_Settings['image_chat_size'];
    }
    $image_chat_model = 'dalle2';
	if (isset($aiomatic_Chatbot_Settings['image_chat_model']) && trim($aiomatic_Chatbot_Settings['image_chat_model']) != '') 
    {
        $image_chat_model = $aiomatic_Chatbot_Settings['image_chat_model'];
    }
    $response_text = aiomatic_generate_ai_image($token, 1, $input_text, $image_size, 'shortcodeImageChat', false, 0, $error, $image_chat_model);
    if($response_text === false)
    {
        $aiomatic_result['msg'] = $error;
        wp_send_json($aiomatic_result);
    }
    else
    {
        foreach($response_text as $tmpimg)
        {
            $aiomatic_result['status'] = 'success';
            if(isset($aiomatic_result['data']))
            {
                $aiomatic_result['data'] .= '<a href="' . $tmpimg . '" target="_blank"><img class="image_max_w_ai" src="' . $tmpimg . '"></a>';
            }
            else
            {
                $aiomatic_result['data'] = '<a href="' . $tmpimg . '" target="_blank"><img class="image_max_w_ai" src="' . $tmpimg . '"></a>';
            }
            $echo_ok = true;
        }
        if(is_numeric($user_token_cap_per_day))
        {
            $used_token_count = intval($used_token_count) + 1000;
            update_user_meta($user_id, 'aiomatic_used_image_chat_tokens', $used_token_count);
        }
    }
    if($echo_ok === false)
    {
        $aiomatic_result['msg'] = esc_html__('No image returned from API call: ', 'aiomatic-automatic-ai-content-writer') . $input_text;
        wp_send_json($aiomatic_result);
    }
    do_action('aiomatic_image_chat_reply', $aiomatic_result);
    wp_send_json($aiomatic_result);
    die();
}

add_action('wp_ajax_aiomatic_user_meta_save', 'aiomatic_user_meta_save');
add_action('wp_ajax_nopriv_aiomatic_user_meta_save', 'aiomatic_user_meta_save');

function aiomatic_user_meta_save() 
{
	check_ajax_referer('openai-persistent-nonce', 'nonce');
    if(!isset($_POST['x_input_text']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no x_input_text: ' . print_r($_POST, true));
	    wp_die();
    }
    if(!isset($_POST['user_id']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no user_id: ' . print_r($_POST, true));
	    wp_die();
    }
	$user_id = sanitize_text_field($_POST['user_id']);
    if(!isset($_POST['persistent']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no persistentid: ' . print_r($_POST, true));
	    wp_die();
    }
	$persistent = sanitize_text_field($_POST['persistent']);
    if(empty($user_id) || $user_id == 0)
    {
        aiomatic_log_to_file('Failed to save persistent conversation, user_id is not valid: ' . print_r($_POST, true));
	    wp_die();
    }
    if(isset($_POST['thread_id']))
    {
	    $thread_id = stripslashes($_POST['thread_id']);
    }
    else
    {
        $thread_id = '';
    }
    if($persistent == 'vector')
    {
        $x_input_text = stripslashes($_POST['x_input_text']);
        if(!empty($x_input_text))
        {
            $namespace = 'persistentchat_' . $user_id . '_' . $thread_id;
            $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
            if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
            {
                aiomatic_log_to_file('You need to enter an OpenAI API key for this feature to work.');
                wp_die();
            }
            if (isset($aiomatic_Main_Settings['pinecone_app_id'])) {
                $pinecone_app_id = $aiomatic_Main_Settings['pinecone_app_id'];
            } else {
                $pinecone_app_id = '';
            }
            if (isset($aiomatic_Main_Settings['qdrant_app_id'])) {
                $qdrant_app_id = $aiomatic_Main_Settings['qdrant_app_id'];
            } else {
                $qdrant_app_id = '';
            }
            if($pinecone_app_id == '' && $qdrant_app_id == '')
            {
                aiomatic_log_to_file('You need to enter a Pinecone.io API or a Qdrant API key for this to work');
                wp_die();
            }
            if (!isset($aiomatic_Main_Settings['embeddings_chat_short']) || trim($aiomatic_Main_Settings['embeddings_chat_short']) != 'on')
            {
                aiomatic_log_to_file('You need to enable Embeddings for the Chatbot for this to work');
                wp_die();
            }
            if (isset($aiomatic_Main_Settings['embeddings_model']) && $aiomatic_Main_Settings['embeddings_model'] != '') 
            {
                $model = $aiomatic_Main_Settings['embeddings_model'];
            }
            else
            {
                $model = 'text-embedding-ada-002';
            }
            $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
            $appids = array_filter($appids);
            $token = $appids[array_rand($appids)];
            require_once(dirname(__FILE__) . "/res/Embeddings.php");
            $embdedding = new Aiomatic_Embeddings($token);
            $aiomatic_result = $embdedding->aiomatic_save_embedding($x_input_text, '', '', false, $model, $namespace);
            if($aiomatic_result['status'] == 'error')
            {
                aiomatic_log_to_file('Failed to save user chat log embeddings: ' . print_r($aiomatic_result, true));
                wp_die();
            }
        }
    }
    else
    {
        if(empty($thread_id))
        {
            $x_input_text = stripslashes($_POST['x_input_text']);
            if(!empty($x_input_text))
            {
                if(is_numeric($user_id))
                {
                    update_user_meta($user_id, 'aiomatic_chat_history_' . $persistent, $x_input_text);
                }
                else
                {
                    set_transient('aiomatic_chat_history_' . $persistent . '_' . $user_id, $x_input_text, 0);
                }
            }
        }
        else
        {
            if(is_numeric($user_id))
            {
                update_user_meta($user_id, 'aiomatic_assistant_history_thread', $thread_id);
            }
            else
            {
                set_transient('aiomatic_assistant_history_thread_' . $user_id, $thread_id, 0);
            }
        }
    }
	wp_die();
}

add_action('wp_ajax_aiomatic_record_user_usage', 'aiomatic_record_user_usage');
add_action('wp_ajax_nopriv_aiomatic_record_user_usage', 'aiomatic_record_user_usage');
function aiomatic_record_user_usage() 
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
	check_ajax_referer('openai-persistent-nonce', 'nonce');
    if(!isset($_POST['input_text']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no input_text: ' . print_r($_POST, true));
	    wp_die();
    }
	$input_text = stripslashes($_POST['input_text']);
    if(!isset($_POST['user_id']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no user_id: ' . print_r($_POST, true));
	    wp_die();
    }
	$user_id = sanitize_text_field($_POST['user_id']);
    if(!isset($_POST['user_token_cap_per_day']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no user_token_cap_per_day: ' . print_r($_POST, true));
	    wp_die();
    }
	$user_token_cap_per_day = sanitize_text_field($_POST['user_token_cap_per_day']);
    if(!isset($_POST['response_text']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no response_text: ' . print_r($_POST, true));
	    wp_die();
    }
	$response_text = sanitize_text_field($_POST['response_text']);
    if(!isset($_POST['model']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no model: ' . print_r($_POST, true));
	    wp_die();
    }
	$model = sanitize_text_field($_POST['model']);
    if(!isset($_POST['temp']))
    {
        aiomatic_log_to_file('Failed to save persistent conversation, no temp: ' . print_r($_POST, true));
	    wp_die();
    }
    $vision_file = '';
    if(isset($_POST['vision_file']))
    {
        $vision_file = $_POST['vision_file'];
    }
	$temperature = sanitize_text_field($_POST['temp']);
    $inp_count = count(aiomatic_encode($input_text));
    $resp_count = count(aiomatic_encode($response_text));
    if($user_token_cap_per_day != '' && is_numeric($user_token_cap_per_day))
    {
        if(empty($user_id) || $user_id == 0)
        {
            aiomatic_log_to_file('Failed to save persistent conversation, invalid user ID sent: ' . print_r($_POST, true));
        }
        else
        {
            $used_token_count = 0;
            $used_token_count = get_user_meta($user_id, 'aiomatic_used_chat_tokens', true);
            if($used_token_count !== '' && $used_token_count !== false && is_numeric($used_token_count))
            {
                $used_token_count = intval($used_token_count);
            }
            else
            {
                $used_token_count = 0;
            }
            $used_token_count = intval($used_token_count) + $inp_count + $resp_count;
            update_user_meta($user_id, 'aiomatic_used_chat_tokens', $used_token_count);
        }
    }
    $session = aiomatic_get_session_id();
    $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
    $appids = array_filter($appids);
    $token = $appids[array_rand($appids)];
    $query = new Aiomatic_Query($input_text, 0, $model, $temperature, null, 'shortcodeChat', 'text', $token, $session, 1, '', '');
    apply_filters( 'aiomatic_ai_reply', $response_text, $query );
    if($vision_file != '')
    {
        $stats = [
            "env" => $query->env,
            "session" => $query->session,
            "mode" => 'image',
            "model" => $query->model,
            "apiRef" => $query->apiKey,
            "units" => 1,
            "type" => 'images',
        ];
        if (empty($stats["price"])) {
            if (aiomatic_is_aiomaticapi_key($query->apiKey)) {
                $stats["price"] = 0;
            } else {
                $stats["price"] = $GLOBALS['aiomatic_stats']->getVisionPrice($query->model);
            }
        }
        $GLOBALS['aiomatic_stats']->add($stats);
    }
	wp_die();
}

add_action('wp_ajax_aiomatic_call_ai_function', 'aiomatic_call_ai_function');
add_action('wp_ajax_nopriv_aiomatic_call_ai_function', 'aiomatic_call_ai_function');
function aiomatic_call_ai_function() 
{
	check_ajax_referer('openai-persistent-nonce', 'nonce');
    if(!isset($_POST['func_call']))
    {
        aiomatic_log_to_file('Failed to call function, no func_call: ' . print_r($_POST, true));
	    wp_die();
    }
    require_once(dirname(__FILE__) . "/aiomatic-god-mode-parser.php");
    $func_call = $_POST['func_call'];
    $func_call = json_decode(json_encode($func_call), FALSE);
    $func_call = apply_filters( 'aiomatic_ai_reply_raw', $func_call, '');
    if(isset($func_call->init_data) && isset($func_call->aiomatic_tool_results))
    {
        $func_call_copy = clone $func_call;
        if(isset($func_call_copy->init_data))
        {
            unset($func_call_copy->init_data);
        }
        if(isset($func_call_copy->aiomatic_tool_results))
        {
            unset($func_call_copy->aiomatic_tool_results);
        }
        for($i = 0; $i < count($func_call->aiomatic_tool_results);$i++)
        {
            $func_call->aiomatic_tool_results[$i]['assistant_message'] = $func_call_copy;
        }
        $json_me = json_encode(array('scope' => 'response', 'data' => $func_call->aiomatic_tool_results));
        echo $json_me;
        wp_die();
    }
    elseif(isset($func_call->init_data) && isset($func_call->aiomatic_tool_direct_message))
    {
        $my_message = '';
        foreach($func_call->aiomatic_tool_direct_message as $dm)
        {
            $my_message .= $dm['content'] . ' ';
        }
        $my_message = trim($my_message);
        echo json_encode(array('scope' => 'user_message', 'data' => $my_message));
        wp_die();
    }
    else
    {
        aiomatic_log_to_file('Failed to parse result: ' . print_r($func_call, true));
    }
    echo array('scope' => 'fail', 'data' => 'fail');
	wp_die();
}

add_action('wp_ajax_aiomatic_send_email', 'aiomatic_send_email');
add_action('wp_ajax_nopriv_aiomatic_send_email', 'aiomatic_send_email');
function aiomatic_send_email() 
{
}

add_action('wp_ajax_aiomatic_create_thread', 'aiomatic_create_thread');
add_action('wp_ajax_nopriv_aiomatic_create_thread', 'aiomatic_create_thread');
function aiomatic_create_thread() 
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with assistant thread creation');
	check_ajax_referer('openai-ajax-nonce', 'nonce');
    $assistant_id = isset($_POST['assistantid']) ? sanitize_text_field($_POST['assistantid']) : '';
    $file_data = isset($_POST['file_data']) ? sanitize_text_field($_POST['file_data']) : '';
    if(empty($assistant_id))
    {
        $aiomatic_result['msg'] = 'No assistant ID passed';
        wp_send_json($aiomatic_result);
        wp_die();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
        $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
        wp_send_json($aiomatic_result);
        wp_die();
    }
    else
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        if(empty($token))
        {
            $aiomatic_result['msg'] = 'Invalid API key submitted';
            wp_send_json($aiomatic_result);
            wp_die();
        }
        if(aiomatic_is_aiomaticapi_key($token))
        {
            $aiomatic_result['msg'] = 'Currently only OpenAI API is supported for audio processing.';
            wp_send_json($aiomatic_result);
            wp_die();
        }
    }
    $assistant_first_message = '';
    require_once (dirname(__FILE__) . "/res/aiomatic-assistants-api.php"); 
    try
    {
        $local_assistant_id = aiomatic_find_local_assistant_id($assistant_id);
        if($local_assistant_id === false)
        {
            $aiomatic_result['msg'] = 'Failed to find local assistant ID for: ' . $assistant_id;
            wp_send_json($aiomatic_result);
            wp_die();
        }
        $assistant_first_message = get_post_meta($local_assistant_id, '_assistant_first_message', true);
        if(!empty($assistant_first_message))
        {
            $simulate_conv = array();
            $simulate_conv[] = array("role" => 'assistant', "content" => $assistant_first_message);
        }
        else
        {
            $simulate_conv = [];
        }
        $thread = aiomatic_openai_create_thread($token, $simulate_conv, $file_data);
        if(!isset($thread['id']))
        {
            $aiomatic_result['msg'] = 'Invalid thread format: ' . print_r($thread, true);
            wp_send_json($aiomatic_result);
            wp_die();
        }
        $thread_id = $thread['id'];
        $aiomatic_result['status'] = 'success';
        $aiomatic_result['data'] = $thread_id;
    }
    catch(Exception $e)
    {
        $aiomatic_result['msg'] = 'Exception in thread creation: ' . $e->getMessage();
    }
    wp_send_json($aiomatic_result);
	wp_die();
}
add_action( 'wp_ajax_aiomatic_audio_converter', 'aiomatic_audio_converter' );
add_action( 'wp_ajax_nopriv_aiomatic_audio_converter', 'aiomatic_audio_converter' );
function aiomatic_audio_converter()
{
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with audio converter');
    if ( !wp_verify_nonce( $_POST['nonce'], 'openai-audio-nonce' ) ) {
        $aiomatic_result['msg'] = 'You are not allowed to execute this action!';
        wp_send_json($aiomatic_result);
    }
    $purpose = isset($_REQUEST['audio_purpose']) && !empty($_REQUEST['audio_purpose']) ? sanitize_text_field($_REQUEST['audio_purpose']) : 'transcriptions';
    $prompt = isset($_REQUEST['prompt']) && !empty($_REQUEST['prompt']) ? sanitize_text_field($_REQUEST['prompt']) : '';
    $type = isset($_REQUEST['type']) && !empty($_REQUEST['type']) ? sanitize_text_field($_REQUEST['type']) : 'upload';
    $url = isset($_REQUEST['url']) && !empty($_REQUEST['url']) ? sanitize_text_field($_REQUEST['url']) : '';
    $model = isset($_REQUEST['model']) && !empty($_REQUEST['model']) ? sanitize_text_field($_REQUEST['model']) : 'whisper-1';
    $temperature = isset($_REQUEST['temperature']) && !empty($_REQUEST['temperature']) ? sanitize_text_field($_REQUEST['temperature']) : 0;
    $language = isset($_REQUEST['language']) && !empty($_REQUEST['language']) ? sanitize_text_field($_REQUEST['language']) : 'en';
    $mime_types = ['mp3' => 'audio/mpeg','mp4' => 'video/mp4','mpeg' => 'video/mpeg','m4a' => 'audio/m4a','wav' => 'audio/wav','webm' => 'video/webm'];
    if($purpose != 'transcriptions' && $purpose != 'translations')
    {
        $aiomatic_result['msg'] = 'Unknown purpose submitted.';
        wp_send_json($aiomatic_result);
    }
    if($type == 'upload' && !isset($_FILES['file'])){
        $aiomatic_result['msg'] = 'An audio file is mandatory.';
        wp_send_json($aiomatic_result);
    }
    if($type == 'record' && !isset($_FILES['recorded_audio'])){
        $aiomatic_result['msg'] = 'An audio recording is mandatory.';
        wp_send_json($aiomatic_result);
    }
    if($type == 'upload'){
        $file = $_FILES['file'];
        $file_name = sanitize_file_name(basename($file['name']));
        $filetype = wp_check_filetype($file_name);
        if(!in_array($filetype['type'], $mime_types)){
            $aiomatic_result['msg'] = 'We only accept mp3, mp4, mpeg, mpga, m4a, wav, or webm.';
            wp_send_json($aiomatic_result);
        }
        if($file['size'] > 26214400){
            $aiomatic_result['msg'] = 'Audio file maximum 25MB';
            wp_send_json($aiomatic_result);
        }
    }
    if($type == 'record'){
        $file = $_FILES['recorded_audio'];
        $file_name = sanitize_file_name(basename($file['name']));
        $filetype = wp_check_filetype($file_name);
        if(!in_array($filetype['type'], $mime_types)){
            $aiomatic_result['msg'] = 'We only accept mp3, mp4, mpeg, mpga, m4a, wav, or webm.';
            wp_send_json($aiomatic_result);
        }
        if($file['size'] > 26214400){
            $aiomatic_result['msg'] = 'Audio file maximum 25MB';
            wp_send_json($aiomatic_result);
        }
        $tmp_file = $file['tmp_name'];
    }
    if($type == 'url'){
        if(empty($url)){
            $aiomatic_result['msg'] = 'The audio URL is required';
            wp_send_json($aiomatic_result);
        }
        $remoteFile = get_headers($url, 1);
        $file_name = basename($url);
        $is_in_mime_types = false;
        $file_ext = '';
        foreach($mime_types as $key=>$mime_type){
            if((is_array($remoteFile['Content-Type']) && in_array($mime_type,$remoteFile['Content-Type'])) || strpos($remoteFile['Content-Type'], $mime_type) !== false){
                $is_in_mime_types = true;
                $file_ext = '.'.$key;
                break;
            }
        }
        if(!$is_in_mime_types){
            $aiomatic_result['msg'] = 'We only accept mp3, mp4, mpeg, mpga, m4a, wav, or webm.';
            wp_send_json($aiomatic_result);
        }

        if(strpos($file_name, $file_ext) === false){
            $file_name = md5(uniqid() . time()) . $file_ext;
        }
        if($remoteFile['Content-Length'] > 26214400){
            $aiomatic_result['msg'] = 'Audio file maximum 25MB';
            wp_send_json($aiomatic_result);
        }
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
        $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
        wp_send_json($aiomatic_result);
    }
    else
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        if(empty($token))
        {
            $aiomatic_result['msg'] = 'Invalid API key submitted';
            wp_send_json($aiomatic_result);
        }
        if(aiomatic_is_aiomaticapi_key($token))
        {
            $aiomatic_result['msg'] = 'Currently only OpenAI API is supported for audio processing.';
            wp_send_json($aiomatic_result);
        }
    }
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for audio conversion.';
        wp_send_json($aiomatic_result);
    }
    require_once (dirname(__FILE__) . "/res/openai/Url.php"); 
    require_once (dirname(__FILE__) . "/res/openai/OpenAi.php"); 
    $open_ai = new OpenAi($token);
    if(!$open_ai){
        $aiomatic_result['msg'] = 'Missing API Setting';
        wp_send_json($aiomatic_result);
    }
    if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
    {
        $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
    }
    if($type == 'url'){
        if(!function_exists('download_url')){
            include_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $tmp_file = download_url($url);
        if ( is_wp_error( $tmp_file ) ){
            $aiomatic_result['msg'] = $tmp_file->get_error_message();
            wp_send_json($aiomatic_result);
        }
    }
    if($type == 'upload'){
        $tmp_file = $file['tmp_name'];
    }
    $response_format = 'text';
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $data_request = array(
        'audio' => array(
            'filename' => $file_name,
            'data' => $wp_filesystem->get_contents($tmp_file)
        ),
        'model' => $model,
        'temperature' => $temperature,
        'response_format' => $response_format,
        'prompt' => $prompt
    );
    if($purpose == 'transcriptions' && !empty($language)){
        $data_request['language'] = $language;
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
    if($purpose == 'transcriptions')
    {
        $completion = $open_ai->transcribe($data_request);
    }
    elseif($purpose == 'translations')
    {
        $completion = $open_ai->translate($data_request);
    }
    $result = json_decode($completion);
    if($result && isset($result->error)){
        $aiomatic_result['msg'] = $result->error->message;
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['status'] = 'success';
    $text_generated = $completion;
    $aiomatic_result['data'] = $text_generated;
    if(empty($text_generated)){
        $aiomatic_result['msg'] = 'OpenAI returned empty content';
        wp_send_json($aiomatic_result);
    }
    do_action('aiomatic_audio_converter_reply', $aiomatic_result);
    wp_send_json($aiomatic_result);
    die();
}
add_action( 'wp_ajax_aiomatic_moderate_text', 'aiomatic_moderate_text' );
add_action( 'wp_ajax_nopriv_aiomatic_moderate_text', 'aiomatic_moderate_text' );
function aiomatic_moderate_text()
{
    check_ajax_referer('openai-moderation-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'msg' => 'Something went wrong with text moderation');
    $text = isset($_REQUEST['text']) && !empty($_REQUEST['text']) ? sanitize_text_field($_REQUEST['text']) : '';
    if(empty($text))
    {
        $aiomatic_result['msg'] = 'You need to enter a text to moderate!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') {
        $aiomatic_result['msg'] = 'You need to add an API key in plugin settings for this shortcode to work.';
        wp_send_json($aiomatic_result);
    }
    else
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        if(empty($token))
        {
            $aiomatic_result['msg'] = 'Invalid API key submitted';
            wp_send_json($aiomatic_result);
        }
        if(aiomatic_is_aiomaticapi_key($token))
        {
            $aiomatic_result['msg'] = 'Currently only OpenAI API is supported for text moderation.';
            wp_send_json($aiomatic_result);
        }
    }
    if (aiomatic_check_if_azure_or_others($aiomatic_Main_Settings)) 
    {
        $aiomatic_result['msg'] = 'Azure/Claude API is not currently supported for moderation.';
        wp_send_json($aiomatic_result);
    }
    require_once (dirname(__FILE__) . "/res/openai/Url.php"); 
    require_once (dirname(__FILE__) . "/res/openai/OpenAi.php"); 
    $open_ai = new OpenAi($token);
    if(!$open_ai){
        $aiomatic_result['msg'] = 'Missing API Setting';
        wp_send_json($aiomatic_result);
    }
    if (isset($aiomatic_Main_Settings['openai_organization']) && $aiomatic_Main_Settings['openai_organization'] != '')
    {
        $open_ai->setORG($aiomatic_Main_Settings['openai_organization']);
    }
    $data_request = array(
        'input' => $text
    );
    if(isset($_REQUEST['model']) && !empty(trim($_REQUEST['model'])))
    {
        $data_request['model'] = trim($_REQUEST['model']);
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
    $moderation = $open_ai->moderation($data_request);
    $result = json_decode($moderation);
    if($result && isset($result->error)){
        $aiomatic_result['msg'] = $result->error->message;
        wp_send_json($aiomatic_result);
    }
    $aiomatic_result['status'] = 'success';
    $aiomatic_result['data'] = $moderation;
    do_action('aiomatic_text_moderation_reply', $aiomatic_result);
    wp_send_json($aiomatic_result);
    die();
}

add_action( 'wp_ajax_aiomatic_aidetector_check_text', 'aiomatic_aidetector_check_text' );
add_action( 'wp_ajax_nopriv_aiomatic_aidetector_check_text', 'aiomatic_aidetector_check_text' );
function aiomatic_aidetector_check_text()
{
    check_ajax_referer('openai-aidetector-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'message' => 'Something went wrong with text AI content check');
    $text = isset($_REQUEST['text']) && !empty($_REQUEST['text']) ? sanitize_text_field($_REQUEST['text']) : '';
    if(empty($text))
    {
        $aiomatic_result['message'] = 'You need to enter a text to check!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['plagiarism_api']) || trim($aiomatic_Main_Settings['plagiarism_api']) == '') {
        $aiomatic_result['message'] = 'You need to add a PlagiarismCheck API key in plugin settings for this shortcode to work.';
        wp_send_json($aiomatic_result);
    }
    else
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['plagiarism_api']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        if(empty($token))
        {
            $aiomatic_result['msg'] = 'Invalid API key submitted';
            wp_send_json($aiomatic_result);
        }
    }
    $status_check = false;
    $language = 'en';
    if(isset($_POST['language']))
	{
		$language = trim($_POST['language']);
	}
    $postData = [
        'language' => $language,
        'text' => $text,
    ];
    $requestData = [];
    foreach ($postData as $name => $value) {
        $requestData[] = $name.'='.urlencode($value);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['plagiarism_api']) || trim($aiomatic_Main_Settings['plagiarism_api']) == '') 
    {
		wp_send_json_error( array( 'status' => 'error', 'message' => 'You need to enter a PlagiarismCheck API key in plugin settings!' ) );
        exit;
	}
    $ch = curl_init();
    if ($ch === false) 
    {
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in aidetector check request' ) );
        exit;
	}  
    curl_setopt($ch, CURLOPT_URL, 'https://plagiarismcheck.org/api/v1/chat-gpt/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $requestData)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-API-TOKEN:'. trim($aiomatic_Main_Settings['plagiarism_api'])
    ));
    
    $result = curl_exec($ch);
    if ($result === false) 
    {
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in ai detector check request result' ) );
        exit;
	}  
    curl_close($ch);

    $response = json_decode($result);
    if ($response === null) 
    {
        aiomatic_log_to_file('Failed to decode initial ai detector checker API result: ' . $result);
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to decode initial ai detector checker API result' ) );
        exit;
	} 
    if ($response->success) 
    {
        $timeout = 0;
        $max_time = 120;
        if(isset($response->data->id))
        {
            $id = $response->data->id;
        }
        else
        {
            aiomatic_log_to_file('Failed to decode ai detector checker API result: ' . print_r($response, true));
            wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to decode ai detector checker API result' ) );
            exit;
        }
        $ok_done = false;
        while($timeout < $max_time && !$ok_done)
        {
            sleep(5);
            $ch = curl_init();
            if ($ch === false) 
            {
                wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in ai detector check request result success' ) );
                exit;
            }  
            curl_setopt($ch, CURLOPT_URL, 'https://plagiarismcheck.org/api/v1/chat-gpt/' . $id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-API-TOKEN:'. trim($aiomatic_Main_Settings['plagiarism_api'])
            ));
            $status_check = curl_exec($ch);
            if ($status_check === false) 
            {
                wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to execute curl in ai detector check request result success' ) );
                exit;
            }  
            curl_close($ch);
            $status = json_decode($status_check);
            if ($status === null) 
            {
                wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to decode response in ai detector check request result success' ) );
                exit;
            }
            if (isset($status->data->conclusion_type) && !empty($status->data->conclusion_type)) 
            {
                $ok_done = true;
                $data = array();
                $data['status'] = 200;
                if(isset($status->data->likely_percent) && !empty($status->data->likely_percent))
                {
                    $data['percentage'] = $status->data->likely_percent;
                }
                else
                {
                    $data['percentage'] = $status->data->percent;
                }
                $data['report'] = $status->data->conclusion;
                $detected_chunks = array();
                if ($status && !empty($status->data->chunks)) 
                {
                    $content = $status->data->content;
                    $chunks = $status->data->chunks;
                    foreach ($chunks as $chunk) 
                    {
                        $start = $chunk->position[0];
                        $end = $chunk->position[1];
                        $extracted_text = substr($content, $start, $end - $start);
                        $detected_chunks[] =$extracted_text;
                    }
                }
                $data['detected_chunks'] = $detected_chunks;
                wp_send_json_success( array('status' => 'success', 'result' => $data) );
            }
            else
            {
                $timeout += 5;
            }
        }
        if(!$ok_done)
        {
            aiomatic_log_to_file('Failed to get status from ai detector checker API result: ' . $status_check);
            wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to get status from ai detector checker API result' ) );
            exit;
        }
    }
    else
    {
        if ($response->message) 
        {
            aiomatic_log_to_file('Error in AI detector API call: ' . $response->message);
            wp_send_json_error( array( 'status' => 'error', 'message' => 'Error in AI detector API call: ' . esc_html($response->message) ) );
            exit;
        }
        aiomatic_log_to_file('Failed to interpret ai detector checker API result: ' . $result);
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to interpret ai detector checker API result' ) );
        exit;
    }
    aiomatic_log_to_file('Failed to get status from ai detector checker API result (timeout)');
    wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to get status from ai detector checker API result' ) );
    exit;
}
add_action( 'wp_ajax_aiomatic_plagiarism_check_text', 'aiomatic_plagiarism_check_text' );
add_action( 'wp_ajax_nopriv_aiomatic_plagiarism_check_text', 'aiomatic_plagiarism_check_text' );
function aiomatic_plagiarism_check_text()
{
    check_ajax_referer('openai-plagiarism-nonce', 'nonce');
    $aiomatic_result = array('status' => 'error', 'message' => 'Something went wrong with text plagiarism check');
    $text = isset($_REQUEST['text']) && !empty($_REQUEST['text']) ? sanitize_text_field($_REQUEST['text']) : '';
    if(empty($text))
    {
        $aiomatic_result['message'] = 'You need to enter a text to check!';
        wp_send_json($aiomatic_result);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['plagiarism_api']) || trim($aiomatic_Main_Settings['plagiarism_api']) == '') {
        $aiomatic_result['message'] = 'You need to add a PlagiarismCheck API key in plugin settings for this shortcode to work.';
        wp_send_json($aiomatic_result);
    }
    else
    {
        $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['plagiarism_api']));
        $appids = array_filter($appids);
        $token = $appids[array_rand($appids)];
        if(empty($token))
        {
            $aiomatic_result['msg'] = 'Invalid API key submitted';
            wp_send_json($aiomatic_result);
        }
    }
    $status_check = false;
    $language = 'en';
    if(isset($_POST['language']))
	{
		$language = trim($_POST['language']);
	}
    $postData = [
        'language' => $language,
        'text' => $text,
    ];
    $requestData = [];
    foreach ($postData as $name => $value) {
        $requestData[] = $name.'='.urlencode($value);
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['plagiarism_api']) || trim($aiomatic_Main_Settings['plagiarism_api']) == '') 
    {
		wp_send_json_error( array( 'status' => 'error', 'message' => 'You need to enter a PlagiarismCheck API key in plugin settings!' ) );
        exit;
	}
    $ch = curl_init();
    if ($ch === false) 
    {
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in plagiarism check request' ) );
        exit;
	}  
    curl_setopt($ch, CURLOPT_URL, 'https://plagiarismcheck.org/api/v1/text');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $requestData)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-API-TOKEN:'. trim($aiomatic_Main_Settings['plagiarism_api'])
    ));
    
    $result = curl_exec($ch);
    if ($result === false) 
    {
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in plagiarism check request result' ) );
        exit;
	}  
    curl_close($ch);

    $response = json_decode($result);
    if ($response === null) 
    {
        aiomatic_log_to_file('Failed to decode plagiarism checker API result: ' . $result);
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to decode plagiarism checker API result' ) );
        exit;
	} 
    if ($response->success) 
    {
        $timeout = 0;
        $max_time = 120;
        $id = $response->data->text->id;
        $ok_done = false;
        while($timeout < $max_time && !$ok_done)
        {
            sleep(5);
            $ch = curl_init();
            if ($ch === false) 
            {
                wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in plagiarism check request result success' ) );
                exit;
            }  
            curl_setopt($ch, CURLOPT_URL, 'https://plagiarismcheck.org/api/v1/text/' . $id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-API-TOKEN:'. trim($aiomatic_Main_Settings['plagiarism_api'])
            ));
            $status_check = curl_exec($ch);
            if ($status_check === false) 
            {
                wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to execute curl in plagiarism check request result success' ) );
                exit;
            }  
            curl_close($ch);
            $status = json_decode($status_check);
            if ($status === null) 
            {
                wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to decode response in plagiarism check request result success' ) );
                exit;
            }  
            if (isset($status->data->state) && $status->data->state === 5) 
            {
                $ch = curl_init();
                if ($ch === false) 
                {
                    wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to init curl in plagiarism check request result state' ) );
                    exit;
                }  
                curl_setopt($ch, CURLOPT_URL, 'https://plagiarismcheck.org/api/v1/text/report/' . $id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-API-TOKEN:'. trim($aiomatic_Main_Settings['plagiarism_api'])
                ));
                $report_check = curl_exec($ch);
                if ($ch === false) 
                {
                    wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to exec curl in plagiarism check request result state' ) );
                    exit;
                }  
                curl_close($ch);
                $report = json_decode($report_check);
                if ($ch === null) 
                {
                    wp_send_json_error( array('status' => 'error',  'message' => 'Failed to decode request in plagiarism check request result state' ) );
                    exit;
                }
                $ok_done = true;
                $data = array();
                $data['status'] = 200;
                $data['percentage'] = $report->data->report->percent;
                $data['report'] = json_encode($report->data->report_data->sources);
                wp_send_json_success( array('status' => 'success', 'result' => $data) );
            }
            else
            {
                $timeout += 5;
            }
        }
        if(!$ok_done)
        {
            aiomatic_log_to_file('Failed to get status from plagiarism checker API result: ' . $status_check);
            wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to get status from plagiarism checker API result' ) );
            exit;
        }
    }
    else
    {
        if ($response->message) 
        {
            aiomatic_log_to_file('Error in plagiarism checker API call: ' . $response->message);
            wp_send_json_error( array( 'status' => 'error', 'message' => 'Error in plagiarism checker API call: ' . esc_html($response->message) ) );
            exit;
        }
        aiomatic_log_to_file('Failed to interpret plagiarism checker API result: ' . $result);
		wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to decode plagiarism checker API result' ) );
        exit;
    }
    aiomatic_log_to_file('Failed to get status from plagiarism checker API result (timeout)');
    wp_send_json_error( array( 'status' => 'error', 'message' => 'Failed to get status from plagiarism checker API result' ) );
    exit;
}

add_action( 'wp_ajax_aiomatic_execute_single_advanced_job', 'aiomatic_execute_single_advanced_job' );
function aiomatic_execute_single_advanced_job() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['post_data']))
	{
		wp_send_json_error( array( 'message' => 'post_data is required!' ) );
	}
	$post_data = $_POST['post_data'];
    if(empty($post_data))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid post_data!' ) );
    }
	if(!isset($_POST['selected']))
	{
		wp_send_json_error( array( 'message' => 'Selected options are required!' ) );
	}
	$selected = $_POST['selected'];
	if($selected != '1a' && $selected != '1a-' && $selected != '1b' && $selected != '2' && $selected != '3' && $selected != '4' && $selected != '5' && $selected != '6')
    {
        wp_send_json_error( array( 'message' => 'Selected job options are invalid: ' . $selected) );
    }
    $job_id = uniqid('job_', true);
    if($selected == '1a')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = 'test';//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '500';//min_char
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = '';//ai_command
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = '';//max_continue_tokens
        $inner_arr[] = '';//model
        $inner_arr[] = '';//headings
        $inner_arr[] = '';//images
        $inner_arr[] = '';//videos
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//headings_list
        $inner_arr[] = '';//images_list
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = 'gpt-3.5-turbo';//title_model
        $inner_arr[] = '';//title_ai_command
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = 'keyword';//title_source
        $inner_arr[] = '';//headings_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//headings_model
        $inner_arr[] = 'topic';//posting_mode
        $inner_arr[] = $post_data['post_topic_list'];//post_topic_list
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = $post_data['title_generator_method'];//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 0;
    }
    elseif($selected == '1a-')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['post_title'];//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '500';//min_char
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = '';//ai_command
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = '';//max_continue_tokens
        $inner_arr[] = '';//model
        $inner_arr[] = '';//headings
        $inner_arr[] = '';//images
        $inner_arr[] = '';//videos
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//headings_list
        $inner_arr[] = '';//images_list
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = 'gpt-3.5-turbo';//title_model
        $inner_arr[] = '';//title_ai_command
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = 'keyword';//title_source
        $inner_arr[] = '';//headings_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//headings_model
        $inner_arr[] = 'topic';//posting_mode
        $inner_arr[] = '';//post_topic_list
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = $post_data['title_generator_method'];//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 0;
    }
    elseif($selected == '1b')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['post_title'];//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = $post_data['min_char'];//min_char
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['ai_command'];//ai_command
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['model'];//model
        $inner_arr[] = $post_data['headings'];//headings
        $inner_arr[] = $post_data['images'];//images
        $inner_arr[] = $post_data['videos'];//videos
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = $post_data['headings_list'];//headings_list
        $inner_arr[] = $post_data['images_list'];//images_list
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['title_model'];//title_model
        $inner_arr[] = $post_data['title_ai_command'];//title_ai_command
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['title_source'];//title_source
        $inner_arr[] = $post_data['headings_ai_command'];//headings_ai_command
        $inner_arr[] = $post_data['headings_model'];//headings_model
        $inner_arr[] = 'title';//posting_mode
        $inner_arr[] = '';//post_topic_list
        $inner_arr[] = '';//post_sections_list
        $inner_arr[] = 'English';//content_language
        $inner_arr[] = 'Creative';//writing_style
        $inner_arr[] = 'Neutral';//writing_tone
        $inner_arr[] = 'Write a title for an article about \"%%topic%%\" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.';//title_prompt
        $inner_arr[] = 'Write %%sections_count%% consecutive headings for an article about \"%%title%%\" that highlight specific aspects, provide detailed insights and specific recommendations. The headings must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don\'t add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else.';//sections_prompt
        $inner_arr[] = 'Write the content of a post section for the heading \"%%current_section%%\" in %%language%%. The title of the post is: \"%%title%%\". Don\'t add the title at the beginning of the created content. Be creative and unique. Don\'t repeat the heading in the created content. Don\'t add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.';//content_prompt
        $inner_arr[] = 'Write a short excerpt for an article about \"%%title%%\" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.';//excerpt_prompt
        $inner_arr[] = '3-4';//section_count
        $inner_arr[] = '2';//paragraph_count
        $inner_arr[] = 'gpt-3.5-turbo';//topic_title_model
        $inner_arr[] = 'gpt-3.5-turbo';//topic_sections_model
        $inner_arr[] = 'gpt-3.5-turbo';//topic_content_model
        $inner_arr[] = 'gpt-3.5-turbo';//topic_excerpt_model
        $inner_arr[] = '0';//single_content_call
        $inner_arr[] = 'Craft an introduction for an article about \"%%title%%\", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.';//intro_prompt
        $inner_arr[] = 'gpt-3.5-turbo';//topic_intro_model
        $inner_arr[] = 'Write an outro for an article about \"%%title%%\", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.';//outro_prompt
        $inner_arr[] = 'gpt-3.5-turbo';//topic_outro_model
        $inner_arr[] = '';//topic_images
        $inner_arr[] = 'h2';//sections_role
        $inner_arr[] = '';//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = '';//strip_by_regex_prompts
        $inner_arr[] = '';//replace_regex_prompts
        $inner_arr[] = 'content';//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = '0';//enable_toc
        $inner_arr[] = 'Table of Contents';//title_toc
        $inner_arr[] = 'Write a Q&A for an article about \"%%title%%\", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.';//qa_prompt
        $inner_arr[] = 'gpt-3.5-turbo';//topic_qa_model
        $inner_arr[] = '0';//enable_qa
        $inner_arr[] = 'Q&A';//title_qa
        $inner_arr[] = 'In Conclusion';//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = '1';//img_all_headings
        $inner_arr[] = 'top';//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = 'ai';//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 0;
    }
    elseif($selected == '2')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['url_list'];//url_list
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['default_lang'];//default_lang
        $inner_arr[] = $post_data['ai_titles'];//ai_titles
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['max_caption'];//max_caption
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = $post_data['no_random'];//no_random
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 1;
    }
    elseif($selected == '3')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['amazon_keyword'];//url_list
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['affiliate_id'];//affiliate_id
        $inner_arr[] = $post_data['first_hand'];//first_hand
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['max_products'];//max_products
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['target_country'];//target_country
        $inner_arr[] = $post_data['min_price'];//min_price
        $inner_arr[] = $post_data['max_price'];//max_price
        $inner_arr[] = $post_data['sort_results'];//sort_results
        $inner_arr[] = $post_data['shuffle_products'];//shuffle_products
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['no_headlink'];//no_headlink
        $inner_arr[] = $post_data['enable_table'];//enable_table
        $inner_arr[] = $post_data['table_prompt'];//table_prompt
        $inner_arr[] = $post_data['topic_table_model'];//topic_table_model
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 2;
    }
    elseif($selected == '4')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['review_keyword'];//review_keyword
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['affiliate_id'];//affiliate_id
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['target_country'];//target_country
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['point_of_view'];//point_of_view
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['proscons_prompt'];//proscons_prompt
        $inner_arr[] = $post_data['topic_proscons_model'];//topic_proscons_model
        $inner_arr[] = $post_data['title_proscons'];//title_proscons
        $inner_arr[] = $post_data['enable_proscons'];//enable_proscons
        $inner_arr[] = $post_data['title_reviews'];//title_reviews
        $inner_arr[] = $post_data['enable_reviews'];//enable_reviews
        $inner_arr[] = $post_data['reviews_prompt'];//reviews_prompt
        $inner_arr[] = $post_data['topic_reviews_model'];//topic_reviews_model
        $inner_arr[] = $post_data['no_headlink'];//no_headlink
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 3;
    }
    elseif($selected == '5')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = $post_data['post_title'];//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['random_order'];//random_order
        $inner_arr[] = $post_data['csv_separator'];//csv_separator
        $type = 4;
    }
    elseif($selected == '6')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = 'test';//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['post_topic_list'];//post_topic_list
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = $post_data['title_generator_method'];//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = $job_id;//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 6;
    }
    $rules = array($inner_arr);
    aiomatic_job_set_status_pending($job_id, array('step' => 'Job started'));

    $response = json_encode(array('success' => true, 'data' => array('job_id' => $job_id)));

    // Send the response headers
    if (!headers_sent()) {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . strlen($response));
        header('Connection: close');
        header('Cache-Control: no-cache, must-revalidate');
        header('X-Accel-Buffering: no');
    }
    if (session_id()) {
        session_write_close();
    }

    // Clear all other buffers
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    
    // Turn off compression on the server
    if (function_exists('apache_setenv')) {
        apache_setenv('no-gzip', 1);
    }
    
    ini_set('zlib.output_compression', 0);

    // Flush all output to the client. The script will continue to run but the client connection will close
    echo $response;
    if (ob_get_level() > 0) 
    {
        ob_flush();
    }
    flush();

    // If you're running PHP-FPM, this will finish the request and allow the script to run in the background
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
    register_shutdown_function('aiomatic_fatal_clear_job', $job_id);
    //start actual work
    $return_me = aiomatic_run_rule(0, $type, 0, 1, $rules, '', '');
    if(!is_array($return_me) || !isset($return_me[0]) || !isset($return_me[1]))
    {
        aiomatic_job_set_status_failed($job_id, 'Rule running failed: ' . print_r($return_me, true));
        wp_die();
    }
    else
    {
        aiomatic_job_set_status_completed($job_id, array('content' => $return_me[0], 'title' => $return_me[1] ));
        wp_die();
    }
}

add_action( 'wp_ajax_aiomatic_execute_single_advanced', 'aiomatic_execute_single_advanced' );
function aiomatic_execute_single_advanced() {
	check_ajax_referer( 'openai-single-nonce', 'nonce' );
	if(!isset($_POST['post_data']))
	{
		wp_send_json_error( array( 'message' => 'post_data is required!' ) );
	}
	$post_data = $_POST['post_data'];
    if(empty($post_data))
    {
        wp_send_json_error( array( 'message' => 'You need to enter a valid post_data!' ) );
    }
	if(!isset($_POST['selected']))
	{
		wp_send_json_error( array( 'message' => 'Selected options are required!' ) );
	}
	$selected = $_POST['selected'];
	if($selected != '1a' && $selected != '1a-' && $selected != '1b' && $selected != '2' && $selected != '3' && $selected != '4' && $selected != '5' && $selected != '6')
    {
        wp_send_json_error( array( 'message' => 'Selected options are invalid: ' . $selected ) );
    }
    if($selected == '1a')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = 'test';//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '500';//min_char
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = '';//ai_command
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = '';//max_continue_tokens
        $inner_arr[] = '';//model
        $inner_arr[] = '';//headings
        $inner_arr[] = '';//images
        $inner_arr[] = '';//videos
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//headings_list
        $inner_arr[] = '';//images_list
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = 'gpt-3.5-turbo';//title_model
        $inner_arr[] = '';//title_ai_command
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = 'keyword';//title_source
        $inner_arr[] = '';//headings_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//headings_model
        $inner_arr[] = 'topic';//posting_mode
        $inner_arr[] = $post_data['post_topic_list'];//post_topic_list
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = $post_data['title_generator_method'];//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 0;
    }
    elseif($selected == '1a-')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['post_title'];//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '500';//min_char
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = '';//ai_command
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = '';//max_continue_tokens
        $inner_arr[] = '';//model
        $inner_arr[] = '';//headings
        $inner_arr[] = '';//images
        $inner_arr[] = '';//videos
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//headings_list
        $inner_arr[] = '';//images_list
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = 'gpt-3.5-turbo';//title_model
        $inner_arr[] = '';//title_ai_command
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = 'keyword';//title_source
        $inner_arr[] = '';//headings_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//headings_model
        $inner_arr[] = 'topic';//posting_mode
        $inner_arr[] = '';//post_topic_list
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = $post_data['title_generator_method'];//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 0;
    }
    elseif($selected == '1b')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['post_title'];//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = $post_data['min_char'];//min_char
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['ai_command'];//ai_command
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['model'];//model
        $inner_arr[] = $post_data['headings'];//headings
        $inner_arr[] = $post_data['images'];//images
        $inner_arr[] = $post_data['videos'];//videos
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = $post_data['headings_list'];//headings_list
        $inner_arr[] = $post_data['images_list'];//images_list
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['title_model'];//title_model
        $inner_arr[] = $post_data['title_ai_command'];//title_ai_command
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['title_source'];//title_source
        $inner_arr[] = $post_data['headings_ai_command'];//headings_ai_command
        $inner_arr[] = $post_data['headings_model'];//headings_model
        $inner_arr[] = 'title';//posting_mode
        $inner_arr[] = '';//post_topic_list
        $inner_arr[] = '';//post_sections_list
        $inner_arr[] = 'English';//content_language
        $inner_arr[] = 'Creative';//writing_style
        $inner_arr[] = 'Neutral';//writing_tone
        $inner_arr[] = 'Write a title for an article about \"%%topic%%\" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 40 and 60 characters.';//title_prompt
        $inner_arr[] = 'Write %%sections_count%% consecutive headings for an article about \"%%title%%\" that highlight specific aspects, provide detailed insights and specific recommendations. The headings must be written in %%language%%, following a %%writing_style%% style and a %%writing_tone%% tone. Don\'t add numbers to the headings, hyphens or any types of quotes. Return only the headings list, nothing else.';//sections_prompt
        $inner_arr[] = 'Write the content of a post section for the heading \"%%current_section%%\" in %%language%%. The title of the post is: \"%%title%%\". Don\'t add the title at the beginning of the created content. Be creative and unique. Don\'t repeat the heading in the created content. Don\'t add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.';//content_prompt
        $inner_arr[] = 'Write a short excerpt for an article about \"%%title%%\" in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%. Must be between 150 and 250 characters.';//excerpt_prompt
        $inner_arr[] = '3-4';//section_count
        $inner_arr[] = '2';//paragraph_count
        $inner_arr[] = 'gpt-3.5-turbo';//topic_title_model
        $inner_arr[] = 'gpt-3.5-turbo';//topic_sections_model
        $inner_arr[] = 'gpt-3.5-turbo';//topic_content_model
        $inner_arr[] = 'gpt-3.5-turbo';//topic_excerpt_model
        $inner_arr[] = '0';//single_content_call
        $inner_arr[] = 'Craft an introduction for an article about \"%%title%%\", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.';//intro_prompt
        $inner_arr[] = 'gpt-3.5-turbo';//topic_intro_model
        $inner_arr[] = 'Write an outro for an article about \"%%title%%\", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.';//outro_prompt
        $inner_arr[] = 'gpt-3.5-turbo';//topic_outro_model
        $inner_arr[] = '';//topic_images
        $inner_arr[] = 'h2';//sections_role
        $inner_arr[] = '';//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = '';//strip_by_regex_prompts
        $inner_arr[] = '';//replace_regex_prompts
        $inner_arr[] = 'content';//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = '0';//enable_toc
        $inner_arr[] = 'Table of Contents';//title_toc
        $inner_arr[] = 'Write a Q&A for an article about \"%%title%%\", in %%language%%. Style: %%writing_style%%. Tone: %%writing_tone%%.';//qa_prompt
        $inner_arr[] = 'gpt-3.5-turbo';//topic_qa_model
        $inner_arr[] = '0';//enable_qa
        $inner_arr[] = 'Q&A';//title_qa
        $inner_arr[] = 'In Conclusion';//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = '1';//img_all_headings
        $inner_arr[] = 'top';//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = 'ai';//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 0;
    }
    elseif($selected == '2')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['url_list'];//url_list
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['default_lang'];//default_lang
        $inner_arr[] = $post_data['ai_titles'];//ai_titles
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['max_caption'];//max_caption
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = $post_data['no_random'];//no_random
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 1;
    }
    elseif($selected == '3')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['amazon_keyword'];//url_list
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['affiliate_id'];//affiliate_id
        $inner_arr[] = $post_data['first_hand'];//first_hand
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['max_products'];//max_products
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['target_country'];//target_country
        $inner_arr[] = $post_data['min_price'];//min_price
        $inner_arr[] = $post_data['max_price'];//max_price
        $inner_arr[] = $post_data['sort_results'];//sort_results
        $inner_arr[] = $post_data['shuffle_products'];//shuffle_products
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = $post_data['no_headlink'];//no_headlink
        $inner_arr[] = $post_data['enable_table'];//enable_table
        $inner_arr[] = $post_data['table_prompt'];//table_prompt
        $inner_arr[] = $post_data['topic_table_model'];//topic_table_model
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 2;
    }
    elseif($selected == '4')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = $post_data['review_keyword'];//review_keyword
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['max_continue_tokens'];//max_continue_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['affiliate_id'];//affiliate_id
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['target_country'];//target_country
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = $post_data['point_of_view'];//point_of_view
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['proscons_prompt'];//proscons_prompt
        $inner_arr[] = $post_data['topic_proscons_model'];//topic_proscons_model
        $inner_arr[] = $post_data['title_proscons'];//title_proscons
        $inner_arr[] = $post_data['enable_proscons'];//enable_proscons
        $inner_arr[] = $post_data['title_reviews'];//title_reviews
        $inner_arr[] = $post_data['enable_reviews'];//enable_reviews
        $inner_arr[] = $post_data['reviews_prompt'];//reviews_prompt
        $inner_arr[] = $post_data['topic_reviews_model'];//topic_reviews_model
        $inner_arr[] = $post_data['no_headlink'];//no_headlink
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 3;
    }
    elseif($selected == '5')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = $post_data['post_title'];//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '0';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = '';//parent_id
        $inner_arr[] = uniqid();//rule_unique_id
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['random_order'];//random_order
        $inner_arr[] = $post_data['csv_separator'];//csv_separator
        $type = 4;
    }
    elseif($selected == '6')
    {
        $inner_arr = array();
        $inner_arr[] = '24';//schedule
        $inner_arr[] = '1';//active
        $inner_arr[] = '1988-01-27 00:00:00';//last_run
        $inner_arr[] = '1';//max
        $inner_arr[] = 'publish';//post_status
        $inner_arr[] = 'post';//post_type
        $inner_arr[] = 'rand';//post_user_name
        $inner_arr[] = '';//item_create_tag
        $inner_arr[] = array('aiomatic_no_category_12345678');//default_category
        $inner_arr[] = 'disabled';//auto_categories
        $inner_arr[] = 'disabled';//can_create_tag
        $inner_arr[] = '0';//enable_comments
        $inner_arr[] = '';//image_url
        $inner_arr[] = 'test';//post_title
        $inner_arr[] = '0';//enable_pingback
        $inner_arr[] = 'post-format-standard';//post_format
        $inner_arr[] = '';//custom_fields
        $inner_arr[] = '';//custom_tax
        $inner_arr[] = $post_data['temperature'];//temperature
        $inner_arr[] = $post_data['top_p'];//top_p
        $inner_arr[] = $post_data['presence_penalty'];//presence_penalty
        $inner_arr[] = $post_data['frequency_penalty'];//frequency_penalty
        $inner_arr[] = '0';//royalty_free
        $inner_arr[] = $post_data['max_tokens'];//max_tokens
        $inner_arr[] = $post_data['max_seed_tokens'];//max_seed_tokens
        $inner_arr[] = $post_data['post_prepend'];//post_prepend
        $inner_arr[] = $post_data['post_append'];//post_append
        $inner_arr[] = $post_data['enable_ai_images'];//enable_ai_images
        $inner_arr[] = $post_data['ai_command_image'];//ai_command_image
        $inner_arr[] = $post_data['image_size'];//image_size
        $inner_arr[] = '';//wpml_lang
        $inner_arr[] = '1';//remove_default
        $inner_arr[] = $post_data['strip_title'];//strip_title
        $inner_arr[] = '0';//title_once
        $inner_arr[] = 'gpt-3.5-turbo';//category_model
        $inner_arr[] = '';//category_ai_command
        $inner_arr[] = 'gpt-3.5-turbo';//tag_model
        $inner_arr[] = '';//tag_ai_command
        $inner_arr[] = '';//min_time
        $inner_arr[] = '';//max_time
        $inner_arr[] = $post_data['skip_spin'];//skip_spin
        $inner_arr[] = $post_data['skip_translate'];//skip_translate
        $inner_arr[] = $post_data['post_topic_list'];//post_topic_list
        $inner_arr[] = $post_data['post_sections_list'];//post_sections_list
        $inner_arr[] = $post_data['content_language'];//content_language
        $inner_arr[] = $post_data['writing_style'];//writing_style
        $inner_arr[] = $post_data['writing_tone'];//writing_tone
        $inner_arr[] = $post_data['title_prompt'];//title_prompt
        $inner_arr[] = $post_data['sections_prompt'];//sections_prompt
        $inner_arr[] = $post_data['content_prompt'];//content_prompt
        $inner_arr[] = $post_data['excerpt_prompt'];//excerpt_prompt
        $inner_arr[] = $post_data['section_count'];//section_count
        $inner_arr[] = $post_data['paragraph_count'];//paragraph_count
        $inner_arr[] = $post_data['topic_title_model'];//topic_title_model
        $inner_arr[] = $post_data['topic_sections_model'];//topic_sections_model
        $inner_arr[] = $post_data['topic_content_model'];//topic_content_model
        $inner_arr[] = $post_data['topic_excerpt_model'];//topic_excerpt_model
        $inner_arr[] = $post_data['single_content_call'];//single_content_call
        $inner_arr[] = $post_data['intro_prompt'];//intro_prompt
        $inner_arr[] = $post_data['topic_intro_model'];//topic_intro_model
        $inner_arr[] = $post_data['outro_prompt'];//outro_prompt
        $inner_arr[] = $post_data['topic_outro_model'];//topic_outro_model
        $inner_arr[] = $post_data['topic_images'];//topic_images
        $inner_arr[] = $post_data['sections_role'];//sections_role
        $inner_arr[] = $post_data['topic_videos'];//topic_videos
        $inner_arr[] = '';//rule_description
        $inner_arr[] = $post_data['custom_shortcodes'];//custom_shortcodes
        $inner_arr[] = $post_data['strip_by_regex'];//strip_by_regex
        $inner_arr[] = $post_data['replace_regex'];//replace_regex
        $inner_arr[] = $post_data['strip_by_regex_prompts'];//strip_by_regex_prompts
        $inner_arr[] = $post_data['replace_regex_prompts'];//replace_regex_prompts
        $inner_arr[] = $post_data['run_regex_on'];//run_regex_on
        $inner_arr[] = $post_data['max_links'];//max_links
        $inner_arr[] = $post_data['link_post_types'];//link_post_types
        $inner_arr[] = $post_data['enable_toc'];//enable_toc
        $inner_arr[] = $post_data['title_toc'];//title_toc
        $inner_arr[] = $post_data['qa_prompt'];//qa_prompt
        $inner_arr[] = $post_data['topic_qa_model'];//topic_qa_model
        $inner_arr[] = $post_data['enable_qa'];//enable_qa
        $inner_arr[] = $post_data['title_qa'];//title_qa
        $inner_arr[] = $post_data['title_outro'];//title_outro
        $inner_arr[] = $post_data['link_type'];//link_type
        $inner_arr[] = $post_data['link_list'];//link_list
        $inner_arr[] = '';//skip_inexist
        $inner_arr[] = $post_data['global_prepend'];//global_prepend
        $inner_arr[] = $post_data['global_append'];//global_append
        $inner_arr[] = $post_data['search_query_repetition'];//search_query_repetition
        $inner_arr[] = $post_data['img_all_headings'];//img_all_headings
        $inner_arr[] = $post_data['heading_img_location'];//heading_img_location
        $inner_arr[] = '';//days_no_run
        $inner_arr[] = '';//overwrite_existing
        $inner_arr[] = $post_data['link_nofollow'];//link_nofollow
        $inner_arr[] = $post_data['title_generator_method'];//title_generator_method
        $inner_arr[] = '';//parent_id
        $inner_arr[] = '';//rule_unique_id
        $inner_arr[] = $post_data['image_model'];//image_model
        $inner_arr[] = $post_data['assistant_id'];//assistant_id
        $type = 6;
    }
    $rules = array($inner_arr);
    $return_me = aiomatic_run_rule(0, $type, 0, 1, $rules, '', '');
    if(!is_array($return_me) || !isset($return_me[0]) || !isset($return_me[1]))
    {
        wp_send_json_error( array( 'message' => 'Rule running failed: ' . print_r($return_me, true)) );
    }
    else
    {
        wp_send_json_success( array( 'content' => $return_me[0], 'title' => $return_me[1] ) );
    }
    wp_send_json_error( array( 'message' => 'Incorrect query!' ) );
    die();
}

add_action( 'wp_ajax_aiomatic_poll_single_advanced_job', 'aiomatic_poll_single_advanced_job' );
function aiomatic_poll_single_advanced_job() 
{
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    $nonce_verified = wp_verify_nonce($nonce, 'openai-single-nonce');
    if (!$nonce_verified) 
    {
        $status = array('status' => 'failed', 'data' => 'Security check failed!');
        echo json_encode($status);
        wp_die();
    }
    if(!isset($_POST['job_id']))
	{
        $status = array('status' => 'failed', 'data' => 'job_id is required!');
        echo json_encode($status);
        wp_die();
	}
	$job_id = $_POST['job_id'];
    $status = aiomatic_job_get_status(trim($job_id));
    if($status === false)
    {
        $status = array('status' => 'failed', 'data' => 'Job not found in database');
    }
    echo json_encode($status);
	wp_die();
}

add_action( 'wp_ajax_aiomatic_iframe', 'aiomatic_iframe_callback' );
function aiomatic_iframe_callback() 
{
    check_ajax_referer('openai-omni-nonce', 'nonce');
    require_once (dirname(__FILE__) . "/aiomatic-scraper.php"); 
    if(!current_user_can('access_aiomatic_menu')) die();
    $started = '%3Cs';
    $url = null;
    $cookie = isset($_GET['crawlCookie']) ? $_GET['crawlCookie'] : '' ;
    $clickelement = isset($_GET['clickelement']) ? $_GET['clickelement'] : '' ;
    $use_phantom = isset($_GET['usephantom']) ? $_GET['usephantom'] : '' ;
    $customUA = isset($_GET['customUA']) ? $_GET['customUA'] : '' ;
    $htuser = isset($_GET['htuser']) ? $_GET['htuser'] : '' ;
    $phantom_wait = isset($_GET['phantom_wait']) ? $_GET['phantom_wait'] : '' ;
    $request_delay = isset($_GET['request_delay']) ? $_GET['request_delay'] : '' ;
    $scripter = isset($_GET['scripter']) ? $_GET['scripter'] : '' ;
    $local_storage = isset($_GET['local_storage']) ? $_GET['local_storage'] : '' ;
    $auto_captcha = isset($_GET['auto_captcha']) ? $_GET['auto_captcha'] : '' ;
    $enable_adblock = isset($_GET['enable_adblock']) ? $_GET['enable_adblock'] : '' ;
    $url = $_GET['address'];
    if($customUA == 'random')
    {
        $customUA = aiomatic_get_random_user_agent();
    }
    if ( !$url ) {
        aiomatic_log_to_file('URL field empty when using Visual Selector.');
        exit();
    }
    $content = false;
    $got_phantom = false;
    if($use_phantom == '1')
    {
        $content = aiomatic_get_page_PhantomJS($url, $cookie, $customUA, '1', $htuser, $phantom_wait, $request_delay, $scripter, $local_storage);
        if($content !== false)
        {
            $got_phantom = true;
        }
    }
    elseif($use_phantom == '2')
    {
        $content = aiomatic_get_page_Puppeteer($url, $cookie, $customUA, '1', $htuser, $phantom_wait, $request_delay, $scripter, $local_storage);
        if($content !== false)
        {
            $got_phantom = true;
        }
    }
    elseif($use_phantom == '3')
    {
        $content = aiomatic_get_page_Tor($url, $cookie, $customUA, '1', $htuser, $phantom_wait, $request_delay, $scripter, $local_storage);
        if($content !== false)
        {
            $got_phantom = true;
        }
    }
    elseif($use_phantom == '4')
    {
        $content = aiomatic_get_page_PuppeteerAPI($url, $cookie, $customUA, '1', $htuser, $phantom_wait, $request_delay, $scripter, $local_storage, $auto_captcha, $enable_adblock, $clickelement);
        if($content !== false)
        {
            $got_phantom = true;
        }
    }
    elseif($use_phantom == '5')
    {
        $content = aiomatic_get_page_TorAPI($url, $cookie, $customUA, '1', $htuser, $phantom_wait, $request_delay, $scripter, $local_storage, $auto_captcha, $enable_adblock, $clickelement);
        if($content !== false)
        {
            $got_phantom = true;
        }
    }
    elseif($use_phantom == '6')
    {
        $content = aiomatic_get_page_PhantomJSAPI($url, $cookie, $customUA, '1', $htuser, $phantom_wait, $request_delay, $scripter, $local_storage);
        if($content !== false)
        {
            $got_phantom = true;
        }
    }
    if($got_phantom === false)
    {
        if (!aiomatic_check_if_phantom($use_phantom))
        { 
            $content = aiomatic_get_web_page($url, $cookie);
        }
    }
    if (  empty($content) ) 
    {
        if(empty($url))
        {
            $url = '';
        }
        aiomatic_log_to_file('Failed to get page when using Visual Selector: ' . esc_url_raw($url));
        echo 'Failed to get page when using Visual Selector: ' . esc_url_raw($url);
        header('404 Not Found');
        exit();
    }
    if ( !preg_match('/<base\s/i', $content) ) {
        $base = '<base href="' . $url . '">';
        $content = str_replace('</head>', $base . '</head>', $content);
    }
    $content = preg_replace('/src="\/\/(.*?)"/', 'src="https://$1"', $content);
    $content = preg_replace('/href="\/\/(.*?)"/', 'href="https://$1"', $content);
    if ( preg_match('!^https?://[^/]+!', $url, $matches) ) {
        $stem = $matches[0];
        $content1 = preg_replace('!(\s)(src|href)(=")\/!i', "\\1\\2\\3$stem/", $content);
        if($content1 !== null)
        {
            $content = $content1;
        }
        $content1 = preg_replace('!(\s)(url)(\s*\(\s*["\']?)\/!i', "\\1\\2\\3$stem/", $content);
        if($content1 !== null)
        {
            $content = $content1;
        }
    }
    $content = aiomatic_fix_links($content, $url);
    $content1 = preg_replace('{<script[\s\S]*?\/\s?script>}s', '', $content);
    if($content1 !== null)
    {
        $content = $content1;
    }
    echo $content . urldecode($started . "tyle%3E%5Bclass~%3Dhighlight%5D%7Bbox-shadow%3Ainset%200%200%200%201000px%20rgba%28255%2C0%2C0%2C.5%29%20%21important%3B%7D%5Bclass~%3Dhighlight%5D%7Boutline%3A.010416667in%20solid%20red%20%21important%3B%7D") . urldecode("%3C%2Fstyle%3E");
    die();
}
?>