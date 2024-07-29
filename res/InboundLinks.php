<?php
use DonatelloZa\RakePlus\RakePlus;
class AiomaticAutoInboundLinks 
{
    public function __construct() 
    {
        require_once (dirname(__FILE__) . "/rake-php-plus/src/AbstractStopwordProvider.php"); 
        require_once (dirname(__FILE__) . "/rake-php-plus/src/ILangParseOptions.php"); 
        require_once (dirname(__FILE__) . "/rake-php-plus/src/LangParseOptions.php"); 
        require_once (dirname(__FILE__) . "/rake-php-plus/src/StopwordArray.php"); 
        require_once (dirname(__FILE__) . "/rake-php-plus/src/StopwordsPatternFile.php"); 
        require_once (dirname(__FILE__) . "/rake-php-plus/src/StopwordsPHP.php"); 
        require_once (dirname(__FILE__) . "/rake-php-plus/src/RakePlus.php");
    }
    public function add_inbound_links($content, $max, $link_post_types, $lang, $rel_search, $current_post_id, $link_type, $link_list, $link_nofollow) 
    {
        $keywords = array();
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if(isset($aiomatic_Main_Settings['kw_method']) && $aiomatic_Main_Settings['kw_method'] == 'ai' && isset($aiomatic_Main_Settings['kw_prompt']) && $aiomatic_Main_Settings['kw_prompt'] != '')
        {
            if (!isset($aiomatic_Main_Settings['app_id']) || trim($aiomatic_Main_Settings['app_id']) == '') 
            {
                aiomatic_log_to_file('You need to insert a valid OpenAI/AiomaticAPI API Key for the automatic AI keyword extractor to work!');
            }
            else
            {
                $appids = preg_split('/\r\n|\r|\n/', trim($aiomatic_Main_Settings['app_id']));
                $appids = array_filter($appids);
                $token = $appids[array_rand($appids)];
                $plain_text_content = strip_tags($content);
                $plain_text_content = strip_shortcodes($plain_text_content);
                if(empty($plain_text_content))
                {
                    return '';
                }
                $prompt = $aiomatic_Main_Settings['kw_prompt'];
                $prompt = str_replace('%%content%%', $plain_text_content, $prompt);
                if(isset($aiomatic_Main_Settings['kw_model']) && $aiomatic_Main_Settings['kw_model'] != '')
                {
                    $kw_model = $aiomatic_Main_Settings['kw_model'];
                }
                else
                {
                    $kw_model = get_default_model_name($aiomatic_Main_Settings);
                }
                if(isset($aiomatic_Main_Settings['kw_assistant_id']) && $aiomatic_Main_Settings['kw_assistant_id'] != '')
                {
                    $kw_assistant_id = $aiomatic_Main_Settings['kw_assistant_id'];
                }
                else
                {
                    $kw_assistant_id = '';
                }
                $all_models = aiomatic_get_all_models(true);
                if(!in_array($kw_model, $all_models))
                {
                    $kw_model = get_default_model_name($aiomatic_Main_Settings);
                }
                $query_token_count = count(aiomatic_encode($prompt));
                $max_tokens = aiomatic_get_max_tokens($kw_model);
                $available_tokens = aiomatic_compute_available_tokens($kw_model, $max_tokens, $prompt, $query_token_count);
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
                $generated_text = aiomatic_generate_text($token, $kw_model, $prompt, $available_tokens, 1, 1, 0, 0, false, 'linkKeywordWriter', 0, $finish_reason, $aierror, true, false, false, '', '', 'user', $kw_assistant_id, $thread_id, '', 'disabled', '', false);
                if($generated_text === false)
                {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
                    {
                        aiomatic_log_to_file('Failed to extract link keywords from: ' . $prompt . ' - error: ' . $aierror);
                    }
                    $keywords = array();
                }
                else
                {
                    $aikws = aiomatic_sanitize_ai_result($generated_text);
                    $keywords = explode(',', $aikws);
                    $keywords = array_map('trim', $keywords);
                    $keywords = array_flip($keywords);
                }
            }
        }
        else
        {
            $keywords = $this->find_keywords($content, $lang);
        }
        $content = $this->insert_links($content, $keywords, $max, $link_post_types, $rel_search, $current_post_id, $link_type, $link_list, $link_nofollow);
        return $content;
    }

    private function find_keywords($content, $lang = 'en_US') 
    {
        $plain_text_content = strip_tags($content);
        $plain_text_content = strip_shortcodes($plain_text_content);
        if(empty($plain_text_content))
        {
            return array();
        }
        $rake = RakePlus::create($plain_text_content, $lang);
        $keywords = $rake->sortByScore('desc')->scores();
        return $keywords;
    }


    private function insert_links($content, $keywords, $max, $link_post_types, $rel_search, $post_id, $link_type, $link_list, $link_nofollow) 
    {
        if(count($keywords) == 0 || $max <= 0)
        {
            return $content;
        }
        $keywords = array_map('trim', $keywords);
        $keywords = array_unique($keywords);
        $filteredStrings = [];
        foreach ($keywords as $string => $prob) 
        {
            $isSubstring = false;
            foreach ($keywords as $otherString) 
            {
                if ($string != $otherString && strpos($otherString, $string) !== false) 
                {
                    $isSubstring = true;
                    break;
                }
            }
            if (!$isSubstring) 
            {
                $filteredStrings[$string] = $prob;
            }
        }
        $keywords = $filteredStrings;
        if(count($keywords) == 0)
        {
            return $content;
        }
        $added = 0;
        $doneids = array();
        if($post_id != null)
        {
            $doneids[] = $post_id;
        }
        $links = preg_split('/\r\n|\r|\n/', trim($link_list));
        $links = array_filter($links);
        $pre_tags_matches = array();
        $pre_tags_matches_s = array();
        $conseqMatchs = array();
        $htmlfounds = array();
        $content = aiomatic_replaceExcludes($content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
        foreach ($keywords as $keyword => $score) 
        {
            if($added >= $max)
            {
                break;
            }
            if($link_type == 'internal' || $link_type == '')
            {
                if(strstr($content, $keyword) !== false && strlen($keyword) > 2)
                {
                    $linked_posts = $this->get_linked_posts($keyword, $link_post_types, $rel_search, $doneids);
                    if (!empty($linked_posts)) 
                    {
                        if($linked_posts[0]->guid === null)
                        {
                            $linked_posts[0]->guid = '';
                        }
                        $replacement = sprintf(
                            '<a href="%s" title="%s">%s</a>',
                            esc_url($linked_posts[0]->guid),
                            esc_attr($linked_posts[0]->post_title),
                            $keyword
                        );
                        $content = preg_replace('/\b' . preg_quote($keyword, '/') . '\b/', $replacement, $content, 1);
                        $doneids[] = $linked_posts[0]->ID;
                        $added++;
                    }
                }
            }
            elseif($link_type == 'manual')
            {
                if(count($links) == 0)
                {
                    break;
                }
                else
                {
                    $the_link_id = array_rand($links);
                }
                $my_link = $links[$the_link_id];
                unset($links[$the_link_id]);
                if(strstr($content, $keyword) !== false && strlen($keyword) > 2)
                {
                    if($link_nofollow == 'on' || $link_nofollow == '1')
                    {
                        $ltemplate = '<a href="%s" rel="nofollow">%s</a>';
                    }
                    else
                    {
                        $ltemplate = '<a href="%s">%s</a>';
                    }
                    $replacement = sprintf(
                        $ltemplate,
                        esc_url($my_link),
                        $keyword
                    );
                    $content = preg_replace('/\b' . preg_quote($keyword, '/') . '\b/', $replacement, $content, 1);
                    $added++;
                }
            }
            elseif($link_type == 'mixed')
            {
                //1 internal, 2 manual
                $go_selector = rand(1,2);
                if(count($links) == 0)
                {
                    $go_selector = 1;
                }
                if($go_selector == 1)
                {
                    if(strstr($content, $keyword) !== false && strlen($keyword) > 2)
                    {
                        $linked_posts = $this->get_linked_posts($keyword, $link_post_types, $rel_search, $doneids);
                        if (!empty($linked_posts)) 
                        {
                            if($linked_posts[0]->guid === null)
                            {
                                $linked_posts[0]->guid = '';
                            }
                            $replacement = sprintf(
                                '<a href="%s" title="%s">%s</a>',
                                esc_url($linked_posts[0]->guid),
                                esc_attr($linked_posts[0]->post_title),
                                $keyword
                            );
                            $content = preg_replace('/\b' . preg_quote($keyword, '/') . '\b/', $replacement, $content, 1);
                            $doneids[] = $linked_posts[0]->ID;
                            $added++;
                        }
                        else
                        {
                            if(count($links) > 0)
                            {
                                $go_selector = 2;
                            }
                        }
                    }
                }
                if($go_selector == 2)
                {
                    $the_link_id = array_rand($links);
                    $my_link = $links[$the_link_id];
                    unset($links[$the_link_id]);
                    if(strstr($content, $keyword) !== false && strlen($keyword) > 2)
                    {
                        if($link_nofollow == 'on' || $link_nofollow == '1')
                        {
                            $ltemplate = '<a href="%s" rel="nofollow">%s</a>';
                        }
                        else
                        {
                            $ltemplate = '<a href="%s">%s</a>';
                        }
                        $replacement = sprintf(
                            $ltemplate,
                            esc_url($my_link),
                            $keyword
                        );
                        $content = preg_replace('/\b' . preg_quote($keyword, '/') . '\b/', $replacement, $content, 1);
                        $added++;
                    }
                }
            }
        }
        $content = aiomatic_restoreExcludes($content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
        return $content;
    }

    private function get_linked_posts($keyword, $link_post_types, $rel_search, $post_id) 
    {
        global $wpdb;
        $idquery = "AND ID != %d";
        if($post_id === null)
        {
            $post_id = 0;
        }
        else if(is_array($post_id) && empty($post_id))
        {
            $post_id = 0;
        }
        else if(is_array($post_id))
        {
            $post_id = implode(',', $post_id);
            $idquery = "AND ID NOT IN (%1s)";
        }
        if(empty($link_post_types))
        {
            $link_post_types = 'post';
        }
        $posttypevar = '';
        if($link_post_types !== 'post')
        {
            $pts = explode(',', $link_post_types);
            $posttypevar = ''; 
            foreach ($pts as $pt) 
            {
                if ($posttypevar != '') {
                    $posttypevar .= " OR "; 
                }
                $posttypevar .= "post_type = '" . trim($pt) . "'";
            }
            $posttypevar = "WHERE (" . $posttypevar . ')'; 
        }
        else
        {
            $posttypevar = "WHERE post_type = 'post'";
        }
        $argsvar = array($post_id);
        if(is_array($rel_search) && !empty($rel_search))
        {
            if(count($rel_search) == 1)
            {
                $refvar = array_reverse($rel_search);
                $what = array_pop($refvar);
                $like_expr = $what . ' LIKE %s';
                $argsvar[] = '%' . $wpdb->esc_like($keyword) . '%';
            }
            else
            {
                $like_expr = '(';
                $indx = 0;
                foreach($rel_search as $rsx)
                {
                    if($indx === 0)
                    {
                        $like_expr .= $rsx . ' LIKE %s';
                    }
                    else
                    {
                        $like_expr .= ' OR ' . $rsx . ' LIKE %s';
                    }
                    $indx++;
                    $argsvar[] = '%' . $wpdb->esc_like($keyword) . '%';
                }
                $like_expr .= ')';
            }
        }
        else
        {
            $like_expr = '(post_title LIKE %s OR post_content LIKE %s)';
            $argsvar[] = '%' . $wpdb->esc_like($keyword) . '%';
            $argsvar[] = '%' . $wpdb->esc_like($keyword) . '%';
        }
        $mysqls = "SELECT * FROM {$wpdb->posts}
        " . $posttypevar . "
        AND post_status = 'publish'
        " . $idquery . "
        AND " . $like_expr . "
        LIMIT 1";
        $sql = $wpdb->prepare(
            $mysqls,
            $argsvar
        );
        $linked_posts = $wpdb->get_results($sql);
        if(is_array($linked_posts))
        {
            foreach($linked_posts as $mindex => $mpost)
            {
                $myperma = get_permalink($mpost->ID);
                if($myperma !== false)
                {
                    $linked_posts[$mindex]->guid = $myperma;
                }
            }
        }
        return $linked_posts;
    }
}