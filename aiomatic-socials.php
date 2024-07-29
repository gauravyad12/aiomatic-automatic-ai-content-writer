<?php
defined('ABSPATH') or die();
use Abraham\TwitterOAuth\TwitterOAuth;
function aiomatic_post_to_twitter($card_type_found, $post_template, $featured_image)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $twitomatic_Main_Settings = get_option('twitomatic_Main_Settings', false);
    if (!isset($twitomatic_Main_Settings['app_id']) || trim($twitomatic_Main_Settings['app_id']) == '') {
        return array('error' => 'Twitter App ID not set in Twitomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if (!isset($twitomatic_Main_Settings['app_secret']) || trim($twitomatic_Main_Settings['app_secret']) == '') {
        return array('error' => 'Twitter App Secret not set in Twitomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if(isset($twitomatic_Main_Settings['api_ver']) && trim($twitomatic_Main_Settings['api_ver']) == 'v2')
    {
        if (!isset($twitomatic_Main_Settings['access_token']) || trim($twitomatic_Main_Settings['access_token']) == '') 
        {
            return array('error' => 'Please insert your Access Token in Twitomatic plugin settings before we can automatically publish on Twitter using v2 API.');
        }
        if (!isset($twitomatic_Main_Settings['access_token_secret']) || $twitomatic_Main_Settings['access_token_secret'] == '') 
        {
            return array('error' => 'Please insert your Access Token Secret in plugin settings before we can automatically publish on Twitter using v2 API.');
        }
    }
    else
    {
        $access_token_id = get_option('twitomatic_access_token_str', false);
        $access_token_secret = get_option('twitomatic_access_token_scr', false);
        $access_token_id_auth_id = get_option('twitomatic_access_token_auth_id', false);
        $access_token_id_auth_secret = get_option('twitomatic_access_token_auth_secret', false);
        if ($access_token_secret === false || $access_token_id === false || $access_token_id_auth_secret === false || $access_token_id_auth_id != trim($twitomatic_Main_Settings['app_id']) || $access_token_id_auth_secret != trim($twitomatic_Main_Settings['app_secret'])) {
            return array('error' => 'Twitter Authentication not set correctly');
        }
    }
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $posted = false;
    try
    {
        if(function_exists('normalizer_normalize') && function_exists('normalizer_is_normalized') && class_exists('Normalizer'))
        {
            if(!normalizer_is_normalized($post_template, Normalizer::FORM_C)){
                $post_template2 = normalizer_normalize($post_template, Normalizer::FORM_C);
            }
            else
            {
                $post_template2 = $post_template;
            }
            if(strlen($post_template2) > 280)
            {
                if(function_exists('mb_substr'))
                {
                    $post_template = mb_substr($post_template, 0, 280);
                }
                else
                {
                    $post_template = substr($post_template, 0, 280);
                }
            }
        }
        elseif(function_exists('mb_strlen') && function_exists('mb_substr'))
        {
            if( mb_strlen($post_template, 'utf-8') > 280)
            {
                $post_template = mb_substr($post_template, 0, 280);
            }
        }
        else
        {
            if(strlen($post_template) > 280)
            {
                $post_template = substr($post_template, 0, 280);
            }
        }
        $post_template = html_entity_decode($post_template);
        if(isset($twitomatic_Main_Settings['api_ver']) && trim($twitomatic_Main_Settings['api_ver']) == 'v2')
        {
            require_once($social_plugins_folder . "/res/apiv2/ca-bundle-main/src/CaBundle.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Util/JsonDecoder.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Config.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Util.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/TwitterOAuthException.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Token.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Consumer.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/SignatureMethod.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/HmacSha1.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Request.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/Response.php");
            require_once($social_plugins_folder . "/res/apiv2/twitteroauth-main/src/TwitterOAuth.php");
            $twitter = new TwitterOAuth(trim($twitomatic_Main_Settings['app_id']), trim($twitomatic_Main_Settings['app_secret']), trim($twitomatic_Main_Settings['access_token']), trim($twitomatic_Main_Settings['access_token_secret']));
            $twitter->setApiVersion('2');
            $media_id = array();
            if($featured_image != '')
            {
                if(!class_exists('\Codebird\Codebird'))
                {
                    require_once($social_plugins_folder . "/res/codebird/codebird.php");
                }
                \Codebird\Codebird::setConsumerKey(trim($twitomatic_Main_Settings['app_id']), trim($twitomatic_Main_Settings['app_secret']));
                $cb = \Codebird\Codebird::getInstance();
                $cb->setToken(trim($twitomatic_Main_Settings['access_token']), trim($twitomatic_Main_Settings['access_token_secret']));
                $cb->setRemoteDownloadTimeout(30000);
                $reply = $cb->media_upload(array(
                    'media' => twitomatic_encodeURI($featured_image)
                ));
                if($reply->httpstatus == '200')
                {
                    $media_id[] = $reply->media_id_string;
                }
                else
                {
                    aiomatic_log_to_file('Problems in codebird v2 media upload: ' . print_r($reply, true) );
                }
            }
            $params = array();
            $params['text'] = $post_template;
            $media_ids_arr = array();
            if(count($media_id) > 0)
            {
                $media_ids_arr[] = $media_id[0];
            }
            if(count($media_ids_arr) > 0)
            {
                $params['media'] = array('media_ids' => $media_ids_arr);
            }
            $reply = $twitter->post("tweets", $params, true);
            if ($twitter->getLastHttpCode() != 201) 
            {
                return array('error' => 'Problems in Twitter API v2 statuses_update: ' . print_r($reply, true) . ' - ' . $twitter->getLastHttpCode());
            }
            else
            {
                $posted = true;
            }
        }
        else
        {
            if(!class_exists('\Codebird\Codebird'))
            {
                require_once($social_plugins_folder . "/res/codebird/codebird.php");
            }
            \Codebird\Codebird::setConsumerKey(trim($twitomatic_Main_Settings['app_id']), trim($twitomatic_Main_Settings['app_secret']));
            $cb = \Codebird\Codebird::getInstance();
            $cb->setToken($access_token_id, $access_token_secret);
            $cb->setRemoteDownloadTimeout(30000);
            $media_id = array();
            if($featured_image != '')
            {
                $reply = $cb->media_upload(array(
                    'media' => twitomatic_encodeURI($featured_image)
                ));
                if($reply->httpstatus == '200')
                {
                    $media_id[] = $reply->media_id_string;
                }
                else
                {
                    aiomatic_log_to_file('Problems in codebird media upload: ' . print_r($reply, true) );
                }
            }
            $params = array();
            $params['status'] = $post_template;
            if(count($media_id) > 0)
            {
                $params['media_ids'] = $media_id[0];
            }
            $reply = $cb->statuses_update($params);
            if($reply->httpstatus != '200')
            {
                return array('error' => 'Problems in codebird statuses_update: ' . print_r($reply, true));
            }
            else
            {
                $posted = true;
            }
        }
    }
    catch(Exception $e)
    {
        return array('error' => 'Exception thrown in Twitter posting: ' . $e->getMessage());
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}

function aiomatic_post_to_gmb($card_type_found, $post_template, $featured_image, $page_to_post)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $businessomatic_Business_Settings = get_option('businessomatic_Business_Settings', false);
    $businessomatic_Main_Settings = get_option('businessomatic_Main_Settings', false);
    if (!isset($businessomatic_Main_Settings['oauth_key']) || trim($businessomatic_Main_Settings['oauth_key']) == '') {
        return array('error' => 'Please insert your Google OAuth2 Key in plugin settings before we can automatically publish on Google Business.');
    }
    if (!isset($businessomatic_Main_Settings['oauth_secret']) || trim($businessomatic_Main_Settings['oauth_secret']) == '') {
        return array('error' => 'Please insert your Google OAuth2 Secret in plugin settings before we can automatically publish on Google Business.');
    }
    $selected_pids = array($page_to_post);
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $posted = false;
    
    try
    {
        require_once($social_plugins_folder . "/res/Google/vendor/autoload.php");
        require_once($social_plugins_folder . "/res/GoogleMyBusiness/MyBusiness.php");
        $client = new Google_Client();
        $client->setClientId(get_option('businessomatic_access_token_auth_id', false));
        $client->setClientSecret(get_option('businessomatic_access_token_auth_secret', false));
        $client->setScopes('https://www.googleapis.com/auth/plus.business.manage');
        $client->setAccessType('offline');
        $at = get_option('businessomatic_access_token_str', false);
        if(!is_array($at) && businessomatic_is_json($at))
        {
            $at = json_decode($at, true);
        }
        if(isset($at['created']) && isset($at['expires_in']))
        {
            if($at['created'] + $at['expires_in'] < time())
            {
                $refreshToken = get_option('businessomatic_refresh_token', false);
                if($refreshToken !== false)
                {
                    $client->refreshToken($refreshToken);
                    $newtoken = $client->getAccessToken();
                    if(!is_array($newtoken) && businessomatic_is_json($newtoken))
                    {
                        $newtoken = json_decode($newtoken, true);
                    }
                    $newtoken = json_encode($newtoken);
                    update_option('businessomatic_access_token_str', $newtoken);
                }
                else
                {
                    businessomatic_log_to_file('Failed to get REFRESH TOKEN from auth request. You might need to manually reauthorize the app!');
                    $at = json_encode($at);
                    $client->setAccessToken($at);
                }
            }
            else
            {
                $at = json_encode($at);
                $client->setAccessToken($at);
            }
        }
        else
        {
            throw new Exception('Invalid access token format ' . print_r($at, true));
        }
        if ($client->getAccessToken()) {
            $post_template    = strip_tags($post_template);
            $post_template    = str_replace('<', '', $post_template);
            $post_template    = str_replace('>', '', $post_template);
            $post_template    = html_entity_decode($post_template, ENT_QUOTES | ENT_XML1, 'UTF-8');
            $gmb = new Google_Service_MyBusiness($client);
            if (isset($businessomatic_Business_Settings['post_language']) && $businessomatic_Business_Settings['post_language'] != '')
            {
                $lang_code = $businessomatic_Business_Settings['post_language'];
            }
            else
            {
                $lang_code = 'en-US';
            }
            foreach($selected_pids as $spid)
            {
                $posts = $gmb->accounts_locations_localPosts;
                $newPost = new Google_Service_MyBusiness_LocalPost();
                $newPost->setTopicType('STANDARD');
                if(strlen($post_template) > 1499)
                {
                    $post_template = substr($post_template, 0, 1499);
                }
                $newPost->setSummary($post_template);      
                $newPost->setLanguageCode($lang_code);
                if (isset($businessomatic_Business_Settings['call_type']) && trim($businessomatic_Business_Settings['call_type']) != 'DISABLED') {
                    if (isset($businessomatic_Business_Settings['call_url']) && trim($businessomatic_Business_Settings['call_url']) != '')
                    {
                        $calltoaction = new Google_Service_MyBusiness_CallToAction();
                        $calltoaction->setActionType($businessomatic_Business_Settings['call_type']);
                        $call_url = $businessomatic_Business_Settings['call_url'];
                        $calltoaction->setUrl($call_url);
                        $newPost->setCallToAction($calltoaction);
                    }
                }
                if($featured_image != '')
                {
                    $media = new Google_Service_MyBusiness_MediaItem();
                    $media->setMediaFormat("PHOTO");
                    $media->setSourceUrl($featured_image);
                    $newPost->setMedia($media);
                }
                try
                {
                    $listPostsResponse = $posts->create($spid, $newPost);
                    if($listPostsResponse !== false)
                    {
                        $posted = true;
                    }
                }
                catch(Exception $e)
                {
                    return array('error' => 'Exception while posting to business ID: ' . $spid . ', post content: ' . print_r($newPost, true) . ', error while posting: ' . $e->getMessage() . ' trace: ' . $e->getTraceAsString());
                }
            }
        }
        else
        {
            throw new Exception('Failed to set access token!');
        }
    }
    catch(Exception $e) 
    {
        return array('error' => 'Exception thrown in Google Business posting: ' . $e->getMessage());
    }

    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}
function aiomatic_post_to_youtube_community($card_type_found, $post_template, $send_type, $media)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $youtubomatic_Community_Settings = get_option('youtubomatic_Community_Settings', false);
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (!isset($youtubomatic_Community_Settings['cookie_login_info']) || trim($youtubomatic_Community_Settings['cookie_login_info']) == '') {
        return array('error' => 'YouTube cookie_login_info not set in Youtubomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if (!isset($youtubomatic_Community_Settings['cookie_papisid']) || trim($youtubomatic_Community_Settings['cookie_papisid']) == '') {
        return array('error' => 'YouTube cookie_papisid not set in Youtubomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if (!isset($youtubomatic_Community_Settings['cookie_psid']) || trim($youtubomatic_Community_Settings['cookie_psid']) == '') {
        return array('error' => 'YouTube cookie_psid not set in Youtubomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    $cookie_login_info = trim($youtubomatic_Community_Settings['cookie_login_info']);
    $cookie_papisid = trim($youtubomatic_Community_Settings['cookie_papisid']);
    $cookie_psid = trim($youtubomatic_Community_Settings['cookie_psid']);
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $posted = false;
    try
    {
        if(!function_exists('GuzzleHttp\\Promise\\queue'))
        {
            youtubomatic_require_all($social_plugins_folder . "/res/Guzzle");
        }
        require_once($social_plugins_folder . "/res/YoutubeCommunity.php");
        $guzzle_proxy = '';
        if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
            curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
            if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
                $guzzle_proxy = 'http://' . $youtubomatic_Main_Settings['proxy_auth'] . '@' . $youtubomatic_Main_Settings['proxy_url'];
            }
            else
            {
                $guzzle_proxy = 'http://' . $youtubomatic_Main_Settings['proxy_url'];
            }
        }
        $yt_community = new YoutubeCommunityClass($cookie_login_info, $cookie_papisid, $cookie_psid, $guzzle_proxy);
        $posting_result = $yt_community->post( $post_template, $send_type, $media );
        if($posting_result['status'] == 'ok')
        {
            $posted = true;
        }
        else
        {
            return array('error' => 'Error while posting to YouTube Community Tab: ' . print_r($posting_result, true));
        }
    }
    catch(Exception $e)
    {
        return array('error' => 'Exception thrown in YouTube community posting: ' . $e->getMessage());
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}
function aiomatic_post_to_reddit($card_type_found, $title_template, $post_template, $send_type, $subreddit_to_post)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $redditomatic_Main_Settings = get_option('redditomatic_Main_Settings', false);
    $redditomatic_Reddit_Settings = get_option('redditomatic_Reddit_Settings', false);
    if (!isset($redditomatic_Main_Settings['app_id']) || trim($redditomatic_Main_Settings['app_id']) == '') {
        return array('error' => 'Please insert your Reddit App ID in Youtubomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if (!isset($redditomatic_Main_Settings['app_secret']) || trim($redditomatic_Main_Settings['app_secret']) == '') {
        return array('error' => 'Please insert your Reddit App secret in Youtubomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    $authorized = FALSE;
    if (get_option('redditomatic_auth_id', false) !== FALSE) {
        if (get_option('redditomatic_auth_secret', false) !== FALSE) {
            if (trim($redditomatic_Main_Settings['app_id']) == get_option('redditomatic_auth_id', false) && trim($redditomatic_Main_Settings['app_secret']) == get_option('redditomatic_auth_secret', false)) {
                $authorized = TRUE;
            }
        }
    }
    if ($authorized === FALSE) {
        return array('error' => 'The plugin is not authenticated correctly. Please reauthorize it in Redditomatic plugin settings.');
    }
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $posted = false;
    if(!empty($subreddit_to_post))
    {
        $reddit_list = $subreddit_to_post;
    }
    else
    {
        $reddit_list = $redditomatic_Reddit_Settings['subreddits_list'];
    }
    $reddit_list = explode(',', $reddit_list);
    if(count($reddit_list) == 0)
    {
        return array('error' => 'No subreddits defined in OmniBlock settings: ' . $e->getMessage());
    }
    $post_template = strip_tags($post_template);
    try
    {
        if(!class_exists('reddit'))
        {
            require_once($social_plugins_folder . "/res/reddit-sdk/reddit.php");
        }
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $reddit = new reddit(trim($redditomatic_Main_Settings['app_id']), trim($redditomatic_Main_Settings['app_secret']), $actual_link, false);
        if($reddit == false)
        {
            return array('error' => 'Failed to init reddit sdk.');
        }
        $multi_run = false;
        if($send_type != '')
        {
            $kind = $send_type;
        }
        else
        {
            if (isset($redditomatic_Reddit_Settings['submit_kind']) && $redditomatic_Reddit_Settings['submit_kind'] != '') {
                $kind    = $redditomatic_Reddit_Settings['submit_kind'];
            }
            else
            {
                $kind = '';
            }
        }
        if($kind == 'auto')
        {
            $kind = '';
        }
        foreach ($reddit_list as $subreddit) 
        {
            $reddit_url = null;
            if($multi_run == true)
            {
                if (isset($redditomatic_Reddit_Settings['timeout_post']) && $redditomatic_Reddit_Settings['timeout_post'] != '' && is_numeric($redditomatic_Reddit_Settings['timeout_post'])) {
                    $sleep_me = $redditomatic_Reddit_Settings['timeout_post'] * 1000000;
                    usleep($sleep_me);
                }
            }
            if($multi_run == false)
            {
                $multi_run = true;
            }
            $subreddit = trim($subreddit);
            $subreddit = trim($subreddit, '/');
            $red_match = '';
            preg_match('#https?:\/\/(?:www\.)?reddit\.com\/r\/([^\/]*)\/?#', $subreddit, $red_match);
            if(isset($red_match[1]))
            {
                $subreddit = $red_match[1];
            }
            $subreddit = str_replace('r/', '', $subreddit);
            if (isset($redditomatic_Reddit_Settings['only_text']) && $redditomatic_Reddit_Settings['only_text'] == 'on') {
                $reddit_url = null;
                $kind = 'self';
            }
            else
            {
                if($kind != 'image' && $kind != 'video')
                {
                    if(isset($redditomatic_Main_Settings['link_dirrectly']) && $redditomatic_Main_Settings['link_dirrectly'] == 'on' && !empty($post_template))
                    {
                        $reddit_url = $post_template;
                    }
                    if (isset($redditomatic_Reddit_Settings['first_url']) && $redditomatic_Reddit_Settings['first_url'] == 'on') {
                        $regex = '/https?\:\/\/[^\<" \n]+/i';
                        preg_match($regex, htmlspecialchars_decode($post_template), $matches);
                        if(isset($matches[0]) && filter_var($matches[0], FILTER_VALIDATE_URL))
                        {
                            $reddit_url = $matches[0];
                        }
                    }
                }
                elseif($kind == 'image')
                {
                    if($post_template != '')
                    {
                        $reddit_url = $post_template;
                    }
                    else
                    {
                        return array('error' => 'No image found to be posted to Reddit');
                    }
                }
                elseif($kind == 'video')
                {
                    if($post_template != '')
                    {
                        $reddit_url = $post_template;
                    }
                    else
                    {
                        return array('error' => 'No video found to be posted to Reddit');
                    }
                }
            }
            if (isset($redditomatic_Reddit_Settings['nsfw']) && $redditomatic_Reddit_Settings['nsfw'] == 'on') 
            {
                $nsfw = true;
            }
            else
            {
                $nsfw = false;
            }
            if (isset($redditomatic_Reddit_Settings['spoiler']) && $redditomatic_Reddit_Settings['spoiler'] == 'on') 
            {
                $spoiler = true;
            }
            else
            {
                $spoiler = false;
            }
            if (isset($redditomatic_Reddit_Settings['reply']) && $redditomatic_Reddit_Settings['reply'] == 'on') 
            {
                $reply = true;
            }
            else
            {
                $reply = false;
            }
            $response = $reddit->createStory($title_template, $reddit_url, $subreddit, $post_template, $kind, $nsfw, $spoiler, $reply);
            if($response === null || $response === false)
            {
                if($response === false)
                {
                    return array('error' => 'Failed to submit post to Reddit!');
                }
                else
                {
                    return array('error' => 'Failed to submit post to Reddit - null!');
                }
            }
            else
            {
                $json = json_encode($response);
                if(stristr($json, 'you are doing that too much. try again in') !== false)
                {
                    return array('error' => 'You are submitting posts to often to Reddit (Rate Limited). Please wait 10 minutes and try again.');
                }
                else
                {
                    if(stristr($json, '"success":true') !== false)
                    {
                        $posted = true;
                    }
                    else
                    {
                        return array('error' => "Error occured while submitting post to Reddit: " . $json);
                    }
                }
            }
        }
    }
    catch(Exception $e)
    {
        return array('error' => 'Exception thrown in YouTube community posting: ' . $e->getMessage());
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}

function aiomatic_post_to_linkedin($card_type_found, $post_template, $featured_image, $post_title, $post_link, $post_description, $attach_lnk, $selected_pages)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $linkedinomatic_Main_Settings = get_option('linkedinomatic_Main_Settings', false);
    if (!isset($linkedinomatic_Main_Settings['app_id']) || trim($linkedinomatic_Main_Settings['app_id']) == '') {
        return array('error' => 'LinkedIn App ID not set in Linkedinomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if (!isset($linkedinomatic_Main_Settings['app_secret']) || trim($linkedinomatic_Main_Settings['app_secret']) == '') {
        return array('error' => 'LinkedIn App Secret not set in Linkedinomatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    $authorized = FALSE;
    if (get_option('linkedinomatic_auth_id', false) !== FALSE) {
        if (get_option('linkedinomatic_auth_secret', false) !== FALSE) {
            if ($linkedinomatic_Main_Settings['app_id'] == get_option('linkedinomatic_auth_id', false) && $linkedinomatic_Main_Settings['app_secret'] == get_option('linkedinomatic_auth_secret', false)) {
                $authorized = TRUE;
            }
        }
    }
    if ($authorized === FALSE) {
        return array('error' => 'LinkedIn plugin not authorized to post! Authorize the Linkedinomatic plugin in its settings.');
    }
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $posted = false;
    if(empty($selected_pages))
    {
        $linkedinomatic_LinkedIn_Settings = get_option('linkedinomatic_LinkedIn_Settings', false);
        $selected_pages = $linkedinomatic_LinkedIn_Settings['selected_pages'];
        if(!is_array($selected_pages))
        {
            if($selected_pages == '')
            {
                return array('error' => 'You need to specify the company pages where you wish to post.');
            }
            else
            {
                $selected_pages = explode(',', $selected_pages);
                $selected_pages = array_map('trim', $selected_pages);
            }
        }
    }
    elseif(!is_array($selected_pages))
    {
        $selected_pages = array($selected_pages);
    }
    if(strlen($post_title) > 255)
    {
         $post_title = substr($post_title, 0, 255);
    }
    $access_token = get_option('linkedinomatic_access_token', false);
    if(!isset($access_token['access_token']))
    {
        return array('error' => 'Invalid access token format: ' . print_r($access_token, true));
    }
    try
    {
        if( !class_exists( 'CRLinkedInOAuth2' ) ) {
            require_once( $social_plugins_folder . '/res/LinkedIn/LinkedIn.OAuth2.class.php' );
        }
        $linkedin = new CRLinkedInOAuth2();
        if( !$linkedin ) 
        {
            throw new Exception('Failed to init LinkedIn (stage 2)!');
        }
        if(empty($post_title))
        {
            $post_title = '';
        }
        if(empty($post_link))
        {
            $post_link = '';
        }
        if(empty($post_template))
        {
            $post_template = '';
        }
        if(empty($featured_image))
        {
            $featured_image = '';
        }
        if(empty($post_description))
        {
            $post_description = '';
        }
        $licontent = array( 
            'title' 				=> $post_title,
            'submitted-url'			=> $post_link,
            'comment'				=> $post_template,
            'submitted-image-url'	=> $featured_image,
            'description'			=> $post_description
        );
        if ($attach_lnk == '1') 
        {
            $attach_lnk = true;
        }
        else
        {
            $attach_lnk = false;
        }
        foreach($selected_pages as $sps)
        {
            if(strstr($sps, 'xxxLinkedinomaticxxx') !== false)
            {
                $sps = str_replace('xxxLinkedinomaticxxx', '', $sps);
                $response	= $linkedin->shareStatusPostAPI( $licontent, 'urn:li:organization:' . $sps, $access_token['access_token'], $attach_lnk );
                if( !empty( $response['id'] ) ) {
                    $posted = true;
                }
                else
                {
                    return array('error' => 'Failed to publish post ' . $licontent['title'] . ' to company page ' . $sps . ' error: ' . print_r($response, true));
                }
            }
            else
            {
                $response	= $linkedin->shareStatusPostAPI( $licontent, 'urn:li:person:' . $sps, $access_token['access_token'], $attach_lnk );
                if( !empty( $response['id'] ) ) {
                    $posted = true;
                }
                else
                {
                    return array('error' => 'Failed to publish post ' . $licontent['title'] . ' to profile page ' . $sps . ' error: ' . print_r($response, true));
                }
            }
        }
    }
    catch(Exception $e)
    {
        return array('error' => 'Exception thrown in LinkedIn posting: ' . $e->getMessage());
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}
function aiomatic_post_to_facebook($card_type_found, $post_template, $post_link, $page_to_post)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $fbomatic_Facebook_Settings = get_option('fbomatic_Facebook_Settings', false);
    $fbomatic_Main_Settings = get_option('fbomatic_Main_Settings', false);
    if (!isset($fbomatic_Main_Settings['app_id2']) || trim($fbomatic_Main_Settings['app_id2']) == '') {
        if (!isset($fbomatic_Main_Settings['app_id']) || trim($fbomatic_Main_Settings['app_id']) == '') {
            return array('error' => 'Facebook App ID not set in F-omatic plugin settings! Please set up the social poster plugin for this to work!');
        }
    }
    if (!isset($fbomatic_Main_Settings['app_secret2']) || trim($fbomatic_Main_Settings['app_secret2']) == '') {
        if (!isset($fbomatic_Main_Settings['app_secret']) || trim($fbomatic_Main_Settings['app_secret']) == '') {
            return array('error' => 'Facebook App secret not set in F-omatic plugin settings! Please set up the social poster plugin for this to work!');
        }
    }
    if (isset($fbomatic_Main_Settings['app_secret2']) && trim($fbomatic_Main_Settings['app_secret2']) != '') {
        $app_secret = trim($fbomatic_Main_Settings['app_secret2']);
    }
    else
    {
        if (isset($fbomatic_Main_Settings['app_secret']) && trim($fbomatic_Main_Settings['app_secret']) != '') {
            $app_secret = trim($fbomatic_Main_Settings['app_secret']);
        }
    }
    if (isset($fbomatic_Main_Settings['app_id2']) && trim($fbomatic_Main_Settings['app_id2']) != '') {
        $app_id = trim($fbomatic_Main_Settings['app_id2']);
    }
    else
    {
        if (isset($fbomatic_Main_Settings['app_id']) && trim($fbomatic_Main_Settings['app_id']) != '') {
            $app_id = trim($fbomatic_Main_Settings['app_id']);
        }
    }
    $authorized = FALSE;
    if (get_option('fbomatic_auth_id', false) !== FALSE) {
        if (get_option('fbomatic_auth_secret', false) !== FALSE) {
            if ($app_id == get_option('fbomatic_auth_id', false) && $app_secret == get_option('fbomatic_auth_secret', false)) {
                $authorized = TRUE;
            }
        }
    }
    if ($authorized === FALSE) {
        return array('error' => 'Plugin not authorized to post! For this to work, please authorize the social poster plugin from its settings!');
    }
    if (!isset($fbomatic_Main_Settings['access_token']) || $fbomatic_Main_Settings['access_token'] == '') {
        $access_token = get_option('fbomatic_access_token', false);
    } else {
        $access_token = $fbomatic_Main_Settings['access_token'];
    }
    $store = get_option('fbomatic_page_ids', false);
    $pageIds = array();
    if ($store !== false) {
        $store   = explode(',', $store);
        $count   = count($store);
        for ($i = 0; $i < $count; $i++) {
            $exploding = explode('-', $store[$i]);
            if (!isset($exploding[2])) {
                continue;
            }
            $pageIds[$exploding[0]] = $exploding[1];
        }
    }
    $store = get_option('fbomatic_group_ids', false);
    $groupIds = array();
    if ($store !== false) {          
        $store   = explode(',', $store);
        $count   = count($store);
        for ($i = 0; $i < $count; $i++) {
            $exploding = explode('-', $store[$i]);
            if (!isset($exploding[2])) {
                continue;
            }
            $groupIds[$exploding[0]] = $exploding[1];
        }
    }
    if (count($groupIds) == 0 && count($pageIds) == 0) {
        return array('error' => 'No groupd id or page id selected in social poster plugin settings! Please set up the social poster plugin for this to work!');
    }
    
    $selected_pids = array();
    if($page_to_post != '')
    {
        foreach ($pageIds as $pId => $token) 
        {
            if ($pId == $page_to_post) {
                $selected_pids[$pId] = $token;
            }
        }
    }
    else
    {
        if (isset($fbomatic_Facebook_Settings['facebook_pages']) && is_array($fbomatic_Facebook_Settings['facebook_pages'])) {
            $facebook_pages = $fbomatic_Facebook_Settings['facebook_pages'];
            foreach ($pageIds as $pId => $token) {
                if (in_array($pId, $facebook_pages)) {
                    $selected_pids[$pId] = $token;
                }
            }
        }
    }
    if (isset($fbomatic_Facebook_Settings['facebook_groups']) && is_array($fbomatic_Facebook_Settings['facebook_groups'])) {
        $facebook_groups = $fbomatic_Facebook_Settings['facebook_groups'];
        foreach ($groupIds as $pId => $token) {
            if (in_array($pId, $facebook_groups)) {
                $selected_pids[$pId] = $token;
            }
        }
    }
    if(isset($fbomatic_Facebook_Settings['group_post_id']) && $fbomatic_Facebook_Settings['group_post_id'] != '')
    {
        $pIds = explode(',', $fbomatic_Facebook_Settings['group_post_id']);
        foreach($pIds as $pId)
        if(is_numeric(trim($pId)))
        {
            $selected_pids[trim($pId)] = $access_token;
        }
    }
    if (count($selected_pids) == 0) 
    {
        return array('error' => 'Cannot find group id or page ids where to post! Please set up the social poster plugin for this to work!');
    }
    if(isset($fbomatic_Facebook_Settings['limit_content_word_count']) && $fbomatic_Facebook_Settings['limit_content_word_count'] != '')
    {
        $post_template = wp_trim_words($post_template, intval($fbomatic_Facebook_Settings['limit_content_word_count']), '');
    }
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $fbFile = $social_plugins_folder . "/res/Facebook/autoload.php";
    if ($wp_filesystem->exists($fbFile) && $wp_filesystem->is_readable($fbFile)) 
    {
        try
        {
            require_once($fbFile);
        }
        catch (Exception $e) {
            return array('error' => 'Exception thrown in Facebook/autoload.php: ' . $e->getMessage());
        }
    }
    else
    {
        if(!$wp_filesystem->exists($fbFile))
        {
            return array('error' => 'FbInit file does not exist: ' . $fbFile);
        }
        elseif(!$wp_filesystem->is_readable($fbFile))
        {
            return array('error' => 'FbInit file does not exist: ' . $fbFile);
        }
        else
        {
            return array('error' => 'FbInit file is in unknown state... : ' . $fbFile);
        }
    }
    $posted = false;
    foreach ($selected_pids as $pi => $token) 
    {
        if ($pi == 0) {
            continue;
        }
        $attachment = array(
            'message' => $post_template,
            'access_token' => $token,
            'link' => $post_link
        );
        if((isset($fbomatic_Facebook_Settings['min_age']) && $fbomatic_Facebook_Settings['min_age'] != '' && $fbomatic_Facebook_Settings['min_age'] != 'any') || (isset($fbomatic_Facebook_Settings['target_country']) && $fbomatic_Facebook_Settings['target_country'] != '') || (isset($fbomatic_Facebook_Settings['target_region']) && $fbomatic_Facebook_Settings['target_region'] != '') || (isset($fbomatic_Facebook_Settings['target_city']) && $fbomatic_Facebook_Settings['target_city'] != ''))
        {
            $targeting = array();
            if((isset($fbomatic_Facebook_Settings['target_country']) && $fbomatic_Facebook_Settings['target_country'] != '') || (isset($fbomatic_Facebook_Settings['target_region']) && $fbomatic_Facebook_Settings['target_region'] != '') || (isset($fbomatic_Facebook_Settings['target_city']) && $fbomatic_Facebook_Settings['target_city'] != ''))
            {
                $geo_locations = array();
                if(isset($fbomatic_Facebook_Settings['target_country']) && $fbomatic_Facebook_Settings['target_country'] != '')
                {
                    $cntry = explode(',', $fbomatic_Facebook_Settings['target_country']);
                    $cntry = array_map('trim', $cntry);
                    $geo_locations['countries'] = $cntry;
                }
                if(isset($fbomatic_Facebook_Settings['target_region']) && $fbomatic_Facebook_Settings['target_region'] != '')
                {
                    $target_region = explode(',', $fbomatic_Facebook_Settings['target_region']);
                    $target_region = array_map('trim', $target_region);
                    $my_regs = array();
                    foreach($target_region as $tr)
                    {
                        $small_reg = array();
                        $small_reg['key'] = $tr;
                        $my_regs[] = $small_reg;
                    }
                    $geo_locations['regions'] = $my_regs;
                }
                if(isset($fbomatic_Facebook_Settings['target_city']) && $fbomatic_Facebook_Settings['target_city'] != '')
                {
                    $target_city = explode(',', $fbomatic_Facebook_Settings['target_city']);
                    $target_city = array_map('trim', $target_city);
                    $my_regs_c = array();
                    foreach($target_city as $tc)
                    {
                        $small_reg = array();
                        $small_reg['key'] = $tc;
                        $my_regs_c[] = $small_reg;
                    }
                    $geo_locations['cities'] = $my_regs_c;
                }
                $targeting['geo_locations'] = $geo_locations;
            }
            if(isset($fbomatic_Facebook_Settings['min_age']) && $fbomatic_Facebook_Settings['min_age'] != '' && $fbomatic_Facebook_Settings['min_age'] != 'any')
            {
                    $targeting['age_min'] = $fbomatic_Facebook_Settings['min_age'];
            }
            $attachment['targeting'] = $targeting;	
        }
        try 
        {
            $GLOBALS['wp_object_cache']->delete('fbomatic_last_time', 'options');
            $last_time = get_option('fbomatic_last_time', false);
            if($last_time !== false && intval($last_time) + 1 < time())
            {
                $sleep_time = rand (600000, 800000);
                usleep($sleep_time);
            }
            if (isset($fbomatic_Main_Settings['api_version']) && $fbomatic_Main_Settings['api_version'] != 'default' && $fbomatic_Main_Settings['api_version'] != '') {
                $api_ver = $fbomatic_Main_Settings['api_version'];
            }
            else
            {
                $api_ver = FBOMATIC_API_VER;
            }
            $facebook   = new Facebook\Facebook(array(
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                'default_graph_version' => 'v' . $api_ver,
                'cookie' => true
            ));
            $result     = $facebook->post('/' . $pi . '/feed/', $attachment);
            update_option('fbomatic_last_time', time());
            $posted = true;
        }
        catch (Exception $e) {
            update_option('fbomatic_last_time', time());
            return array('error' => 'Exception thrown in Facebook auto posting: ' . $e->getMessage());
        }
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}

function aiomatic_post_image_to_facebook($card_type_found, $post_template, $image_link, $page_to_post)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $fbomatic_Facebook_Settings = get_option('fbomatic_Facebook_Settings', false);
    $fbomatic_Main_Settings = get_option('fbomatic_Main_Settings', false);
    if (!isset($fbomatic_Main_Settings['app_id2']) || trim($fbomatic_Main_Settings['app_id2']) == '') {
        if (!isset($fbomatic_Main_Settings['app_id']) || trim($fbomatic_Main_Settings['app_id']) == '') {
            return array('error' => 'Facebook App ID not set in F-omatic plugin settings! Please set up the social poster plugin for this to work!');
        }
    }
    if (!isset($fbomatic_Main_Settings['app_secret2']) || trim($fbomatic_Main_Settings['app_secret2']) == '') {
        if (!isset($fbomatic_Main_Settings['app_secret']) || trim($fbomatic_Main_Settings['app_secret']) == '') {
            return array('error' => 'Facebook App secret not set in F-omatic plugin settings! Please set up the social poster plugin for this to work!');
        }
    }
    if (isset($fbomatic_Main_Settings['app_secret2']) && trim($fbomatic_Main_Settings['app_secret2']) != '') {
        $app_secret = trim($fbomatic_Main_Settings['app_secret2']);
    }
    else
    {
        if (isset($fbomatic_Main_Settings['app_secret']) && trim($fbomatic_Main_Settings['app_secret']) != '') {
            $app_secret = trim($fbomatic_Main_Settings['app_secret']);
        }
    }
    if (isset($fbomatic_Main_Settings['app_id2']) && trim($fbomatic_Main_Settings['app_id2']) != '') {
        $app_id = trim($fbomatic_Main_Settings['app_id2']);
    }
    else
    {
        if (isset($fbomatic_Main_Settings['app_id']) && trim($fbomatic_Main_Settings['app_id']) != '') {
            $app_id = trim($fbomatic_Main_Settings['app_id']);
        }
    }
    $authorized = FALSE;
    if (get_option('fbomatic_auth_id', false) !== FALSE) {
        if (get_option('fbomatic_auth_secret', false) !== FALSE) {
            if ($app_id == get_option('fbomatic_auth_id', false) && $app_secret == get_option('fbomatic_auth_secret', false)) {
                $authorized = TRUE;
            }
        }
    }
    if ($authorized === FALSE) {
        return array('error' => 'Plugin not authorized to post! For this to work, please authorize the social poster plugin from its settings!');
    }
    if (!isset($fbomatic_Main_Settings['access_token']) || $fbomatic_Main_Settings['access_token'] == '') {
        $access_token = get_option('fbomatic_access_token', false);
    } else {
        $access_token = $fbomatic_Main_Settings['access_token'];
    }
    $store = get_option('fbomatic_page_ids', false);
    $pageIds = array();
    if ($store !== false) {
        $store   = explode(',', $store);
        $count   = count($store);
        for ($i = 0; $i < $count; $i++) {
            $exploding = explode('-', $store[$i]);
            if (!isset($exploding[2])) {
                continue;
            }
            $pageIds[$exploding[0]] = $exploding[1];
        }
    }
    $store = get_option('fbomatic_group_ids', false);
    $groupIds = array();
    if ($store !== false) {          
        $store   = explode(',', $store);
        $count   = count($store);
        for ($i = 0; $i < $count; $i++) {
            $exploding = explode('-', $store[$i]);
            if (!isset($exploding[2])) {
                continue;
            }
            $groupIds[$exploding[0]] = $exploding[1];
        }
    }
    if (count($groupIds) == 0 && count($pageIds) == 0) {
        return array('error' => 'No groupd id or page id selected in social poster plugin settings! Please set up the social poster plugin for this to work!');
    }
    
    $selected_pids = array();
    if($page_to_post != '')
    {
        foreach ($pageIds as $pId => $token) 
        {
            if ($pId == $page_to_post) {
                $selected_pids[$pId] = $token;
            }
        }
    }
    else
    {
        if (isset($fbomatic_Facebook_Settings['facebook_pages']) && is_array($fbomatic_Facebook_Settings['facebook_pages'])) {
            $facebook_pages = $fbomatic_Facebook_Settings['facebook_pages'];
            foreach ($pageIds as $pId => $token) {
                if (in_array($pId, $facebook_pages)) {
                    $selected_pids[$pId] = $token;
                }
            }
        }
    }
    if (isset($fbomatic_Facebook_Settings['facebook_groups']) && is_array($fbomatic_Facebook_Settings['facebook_groups'])) {
        $facebook_groups = $fbomatic_Facebook_Settings['facebook_groups'];
        foreach ($groupIds as $pId => $token) {
            if (in_array($pId, $facebook_groups)) {
                $selected_pids[$pId] = $token;
            }
        }
    }
    if(isset($fbomatic_Facebook_Settings['group_post_id']) && $fbomatic_Facebook_Settings['group_post_id'] != '')
    {
        $pIds = explode(',', $fbomatic_Facebook_Settings['group_post_id']);
        foreach($pIds as $pId)
        {
            if(is_numeric(trim($pId)))
            {
                $selected_pids[trim($pId)] = $access_token;
            }
        }
    }
    if (count($selected_pids) == 0) 
    {
        return array('error' => 'Cannot find group id or page ids where to post! Please set up the social poster plugin for this to work!');
    }
    if(isset($fbomatic_Facebook_Settings['limit_content_word_count']) && $fbomatic_Facebook_Settings['limit_content_word_count'] != '')
    {
        $post_template = wp_trim_words($post_template, intval($fbomatic_Facebook_Settings['limit_content_word_count']), '');
    }
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    $fbFile = $social_plugins_folder . "/res/Facebook/autoload.php";
    if ($wp_filesystem->exists($fbFile) && $wp_filesystem->is_readable($fbFile)) 
    {
        try
        {
            require_once($fbFile);
        }
        catch (Exception $e) {
            return array('error' => 'Exception thrown in Facebook/autoload.php: ' . $e->getMessage());
        }
    }
    else
    {
        if(!$wp_filesystem->exists($fbFile))
        {
            return array('error' => 'FbInit file does not exist: ' . $fbFile);
        }
        elseif(!$wp_filesystem->is_readable($fbFile))
        {
            return array('error' => 'FbInit file does not exist: ' . $fbFile);
        }
        else
        {
            return array('error' => 'FbInit file is in unknown state... : ' . $fbFile);
        }
    }
    $posted = false;
    foreach ($selected_pids as $pi => $token) 
    {
        if ($pi == 0) {
            continue;
        }
        $attachment = array(
            'caption' => $post_template,
            'access_token' => $token,
            'url' => $image_link
        );
        if((isset($fbomatic_Facebook_Settings['min_age']) && $fbomatic_Facebook_Settings['min_age'] != '' && $fbomatic_Facebook_Settings['min_age'] != 'any') || (isset($fbomatic_Facebook_Settings['target_country']) && $fbomatic_Facebook_Settings['target_country'] != '') || (isset($fbomatic_Facebook_Settings['target_region']) && $fbomatic_Facebook_Settings['target_region'] != '') || (isset($fbomatic_Facebook_Settings['target_city']) && $fbomatic_Facebook_Settings['target_city'] != ''))
        {
            $targeting = array();
            if((isset($fbomatic_Facebook_Settings['target_country']) && $fbomatic_Facebook_Settings['target_country'] != '') || (isset($fbomatic_Facebook_Settings['target_region']) && $fbomatic_Facebook_Settings['target_region'] != '') || (isset($fbomatic_Facebook_Settings['target_city']) && $fbomatic_Facebook_Settings['target_city'] != ''))
            {
                $geo_locations = array();
                if(isset($fbomatic_Facebook_Settings['target_country']) && $fbomatic_Facebook_Settings['target_country'] != '')
                {
                    $cntry = explode(',', $fbomatic_Facebook_Settings['target_country']);
                    $cntry = array_map('trim', $cntry);
                    $geo_locations['countries'] = $cntry;
                }
                if(isset($fbomatic_Facebook_Settings['target_region']) && $fbomatic_Facebook_Settings['target_region'] != '')
                {
                    $target_region = explode(',', $fbomatic_Facebook_Settings['target_region']);
                    $target_region = array_map('trim', $target_region);
                    $my_regs = array();
                    foreach($target_region as $tr)
                    {
                        $small_reg = array();
                        $small_reg['key'] = $tr;
                        $my_regs[] = $small_reg;
                    }
                    $geo_locations['regions'] = $my_regs;
                }
                if(isset($fbomatic_Facebook_Settings['target_city']) && $fbomatic_Facebook_Settings['target_city'] != '')
                {
                    $target_city = explode(',', $fbomatic_Facebook_Settings['target_city']);
                    $target_city = array_map('trim', $target_city);
                    $my_regs_c = array();
                    foreach($target_city as $tc)
                    {
                        $small_reg = array();
                        $small_reg['key'] = $tc;
                        $my_regs_c[] = $small_reg;
                    }
                    $geo_locations['cities'] = $my_regs_c;
                }
                $targeting['geo_locations'] = $geo_locations;
            }
            if(isset($fbomatic_Facebook_Settings['min_age']) && $fbomatic_Facebook_Settings['min_age'] != '' && $fbomatic_Facebook_Settings['min_age'] != 'any')
            {
                 $targeting['age_min'] = $fbomatic_Facebook_Settings['min_age'];
            }
            $attachment['targeting'] = $targeting;	
        }
        try 
        {
            $GLOBALS['wp_object_cache']->delete('fbomatic_last_time', 'options');
            $last_time = get_option('fbomatic_last_time', false);
            if($last_time !== false && intval($last_time) + 1 < time())
            {
                $sleep_time = rand (600000, 800000);
                usleep($sleep_time);
            }
            if (isset($fbomatic_Main_Settings['api_version']) && $fbomatic_Main_Settings['api_version'] != 'default' && $fbomatic_Main_Settings['api_version'] != '') {
                $api_ver = $fbomatic_Main_Settings['api_version'];
            }
            else
            {
                $api_ver = FBOMATIC_API_VER;
            }
            $facebook   = new Facebook\Facebook(array(
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                'default_graph_version' => 'v' . $api_ver,
                'cookie' => true
            ));
            $result     = $facebook->post('/' . $pi . '/photos/', $attachment);
            update_option('fbomatic_last_time', time());
            $posted = true;
        }
        catch (Exception $e) {
            update_option('fbomatic_last_time', time());
            return array('error' => 'Exception thrown in Facebook image auto posting: ' . $e->getMessage());
        }
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}

function aiomatic_post_image_to_pinterest($card_type_found, $post_template, $pinterest_title, $pin_me, $image_link, $page_to_post)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $pinterestomatic_Pinterest_Settings = get_option('pinterestomatic_Pinterest_Settings', false);
    $pinterestomatic_Main_Settings = get_option('pinterestomatic_Main_Settings', false);
    if (!isset($pinterestomatic_Pinterest_Settings['app_id']) || trim($pinterestomatic_Pinterest_Settings['app_id']) == '') {
        return array('error' => 'Please insert your cookie string in plugin settings before we can automatically publish on Pinterest.');
    }
    
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    require_once($social_plugins_folder . "/res/vendor/autoload.php");
    require_once($social_plugins_folder . "/res/Pinterest/Pinterest.php");
    $proxy = '';
    if (isset($pinterestomatic_Main_Settings['proxy_url']) && $pinterestomatic_Main_Settings['proxy_url'] != '')
    {
        $proxy = $pinterestomatic_Main_Settings['proxy_url'];
    }
    $posted = false;
    try 
    {
        if($pinterest_title != '')
        {
            if(function_exists('mb_substr'))
            {
                if(mb_strlen($pinterest_title) >= 100)
                {
                    $postTitle = mb_substr( $pinterest_title, 0, 97 ) . '...';
                }
                else
                {
                    $postTitle = $pinterest_title;
                }
            }
            else
            {
                if(strlen($pinterest_title) >= 100)
                {
                    $postTitle = substr( $pinterest_title, 0, 97 ) . '...';
                }
                else
                {
                    $postTitle = $pinterest_title;
                }
            }
        }
        else
        {
            if(function_exists('mb_substr'))
            {
                if(mb_strlen($post_template) >= 100)
                {
                    $postTitle = mb_substr( $post_template, 0, 97 ) . '...';
                }
                else
                {
                    $postTitle = $post_template;
                }
            }
            else
            {
                if(strlen($post_template) >= 100)
                {
                    $postTitle = substr( $post_template, 0, 97 ) . '...';
                }
                else
                {
                    $postTitle = $post_template;
                }
            }
        }
        $pinterest = false;
        $prev_cookie = false;
        $imagesLocale = [$image_link];
        $sbr = explode('~~~', $page_to_post);
        if(isset($sbr[1]))
        {
            if($prev_cookie !== trim($sbr[1]) || $pinterest === false)
            {
                try 
                {
                    $pinterest = new PinterestCookieApi( trim($sbr[1]), $proxy );
                    if($pinterest === false)
                    {
                        pinterestomatic_log_to_file ('Authorisation failed on Pinterest using cookie: ' . trim($sbr[1]));
                        return;
                    }
                    $prev_cookie = trim($sbr[1]);
                } catch (Exception $e) {
                    pinterestomatic_log_to_file ('Authorisation error on Pinterest ' . $e->getMessage());
                    return;
                }
            }
            try {
                $res = $pinterest->sendPost( trim($sbr[0]), $postTitle, $post_template, $pin_me, $imagesLocale );
                $posted = true;
            } catch (Exception $e) {
                pinterestomatic_log_to_file("Exception while posting media to Pinterest for board ID: " . trim($sbr[0]) . ', error: ' . esc_html($e->getMessage()) . ' -- remaining: ' . $pinterest->getRateLimitRemaining());
            }
            if(isset($pinterestomatic_Pinterest_Settings['timeout_post']) && $pinterestomatic_Pinterest_Settings['timeout_post'] != '' && is_numeric($pinterestomatic_Pinterest_Settings['timeout_post']))
            {
                usleep($pinterestomatic_Pinterest_Settings['timeout_post'] * 1000);
            }
        }
        else
        {
            if($pinterest === false)
            {
                try 
                {
                    $pinterest = new PinterestCookieApi( trim($pinterestomatic_Pinterest_Settings['app_id']), $proxy );
                    if($pinterest === false)
                    {
                        pinterestomatic_log_to_file ('Authorisation failed on Pinterest using cookie: ' . trim($sbr[1]));
                        return;
                    }
                } catch (Exception $e) {
                    pinterestomatic_log_to_file ('Authorisation error on Pinterest ' . $e->getMessage());
                    return;
                }
            }
            try {
                $res = $pinterest->sendPost( $page_to_post, $postTitle, $post_template, $pin_me, $imagesLocale );
                $posted = true;
            } catch (Exception $e) {
                pinterestomatic_log_to_file("Exception while posting media to Pinterest for board ID: " . $page_to_post . ', error: ' . esc_html($e->getMessage()) . ' -- remaining: ' . $pinterest->getRateLimitRemaining());
            }
            if(isset($pinterestomatic_Pinterest_Settings['timeout_post']) && $pinterestomatic_Pinterest_Settings['timeout_post'] != '' && is_numeric($pinterestomatic_Pinterest_Settings['timeout_post']))
            {
                usleep($pinterestomatic_Pinterest_Settings['timeout_post'] * 1000);
            }
        }
    } catch (Exception $e) {
        pinterestomatic_log_to_file("General exception occured while posting to Pinterest: " . $e->getMessage());
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}

function aiomatic_post_image_to_instagram($card_type_found, $post_template, $image_link)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (!isset($instamatic_Main_Settings['app_id']) || trim($instamatic_Main_Settings['app_id']) == '') {
        return array('error' => 'Instagram App ID not set in Instamatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    if (!isset($instamatic_Main_Settings['app_secret']) || trim($instamatic_Main_Settings['app_secret']) == '') {
        return array('error' => 'Instagram App secret not set in Instamatic plugin settings! Please set up the social poster plugin for this to work!');
    }
    $plugin_folder = $card_type_found['required_plugin'];
    $plugin_folder = key($plugin_folder);
    $plugin_folder = explode('/', $plugin_folder);
    $plugin_folder = $plugin_folder[0];
    $social_plugins_folder = dirname(__FILE__);
    $social_plugins_folder = str_replace('aiomatic-automatic-ai-content-writer', $plugin_folder, $social_plugins_folder);
    
    $posted = false;
    if(!class_exists('\GuzzleHttp\Client') || !class_exists('\Phpfastcache\Helper\Psr16Adapter'))
    {
        require_once($social_plugins_folder . '/res/vendor-old/autoload.php');
    }
    require_once($social_plugins_folder . '/res/PHPImage/PHPImage.php');
    require_once($social_plugins_folder . "/res/Instagram-post/instagram-photo-video-upload-api.class.php");

    $my_proxy = '';
    if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
    {
        if (isset($instamatic_Main_Settings['proxy_prot']) && $instamatic_Main_Settings['proxy_prot'] != '') 
        {
            $prot = $instamatic_Main_Settings['proxy_prot'];
        }
        else
        {
            $prot = 'http://';
        }
        $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
        $randomness = array_rand($prx);
        if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
        {
            $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
            if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
            {
                $my_proxy = $prot . $prx_auth[$randomness] . '@' . $prx[$randomness];
            }
            else
            {
                $my_proxy = $prot . $prx[$randomness];
            }
        }
        else
        {
            $my_proxy = $prot . $prx[$randomness];
        }
    }
    $appids = preg_split('/\r\n|\r|\n/', trim($instamatic_Main_Settings['app_id']));
    $appsecrets = preg_split('/\r\n|\r|\n/', instamatic_encrypt_decrypt('decrypt', $instamatic_Main_Settings['app_secret']));
    $rand_index = array_rand($appids);
    if(!isset($appsecrets[$rand_index]))
    {
        return array('error' => 'Please be sure to enter the same number of Instagram user IDs and passwords!');
    }
    $myappid = $appids[$rand_index];
    $myappsecret = $appsecrets[$rand_index];
    $apiInstance = new InstagramLoginPassMethod( trim($myappid), $myappsecret, $my_proxy );
    $rrez = $apiInstance->login();
    if ( isset( $rrez[ 'status' ] ) && $rrez[ 'status' ] === 'fail' )
    {
        return array('error' => 'Failed to log in to Instagram, please check if your username and password are correct!');
    }
    else
    {
        if(!isset($rrez[ 'logged_in_user' ][ 'pk' ]))
        {
            return array('error' => "Invalid response from Instagram: " . print_r($rrez, true));
        }
        $delete_file = false;
        $restore_img = '';
        try 
        {
            $temp_img = $image_link;
            $isAscii = true;
            $len = strlen($image_link);
            for ($i = 0; $i < $len; $i++) 
            {
                if (ord($image_link[$i]) > 127) 
                {
                    $isAscii = false;
                    break;
                }
            }
            if($isAscii == true && !$wp_filesystem->is_file($image_link))
            {
            }
            else
            {
                try
                {
                    if(!class_exists('\Eventviva\ImageResize')){require_once ($social_plugins_folder . "/res/ImageResize/ImageResize.php");}
                    $imageRes = new ImageResize($image_link);
                    $imageRes->quality_jpg = 98;
                    if($imageRes->getSourceWidth() != $imageRes->getSourceHeight())
                    {
                        $min_ar = 0.5240740740740741;
                        $max_ar = 1.25;
                        $img_ar = $imageRes->getSourceHeight() / $imageRes->getSourceWidth();
                        if($imageRes->getSourceWidth() >= 320 && $imageRes->getSourceWidth() <= 1080 && $img_ar >= $min_ar && $img_ar <= $max_ar)
                        {
                            $temp_img = $image_link;
                        }
                        else
                        {
                            if(!($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 566) || ($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 1350))
                            {
                                if($imageRes->getSourceWidth() > $imageRes->getSourceHeight())
                                {
                                    $imageRes->resize(1080, 566, true);
                                }
                                else
                                {
                                    $imageRes->resize(1080, 1350, true);
                                }
                                $temp_img = instamatic_get_temp_dir() . 'instamaticimg' . uniqid() . '.jpg';
                                $imageRes->save($temp_img);
                            }
                        }
                    }
                }
                catch(Exception $e)
                {
                    instamatic_log_to_file('Failed to resize image at posting: ' . $e->getMessage());
                }
            }
            $delete = false;
            if(!$wp_filesystem->exists($temp_img))
            {
                $the_temp_img_local = instamatic_get_temp_dir() . 'instamaticlocal' . uniqid() . '.jpg';
                instamatic_downloadFile($temp_img, $the_temp_img_local);
                if($wp_filesystem->exists($the_temp_img_local))
                {
                    $temp_img = $the_temp_img_local;
                    $delete = true;
                }
                else
                {
                    $ftimeout = 300;
                    $fh = fopen($the_temp_img_local, "w");
                    if ($fh) 
                    {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $temp_img);
                        curl_setopt($ch, CURLOPT_FILE, $fh);
                        curl_setopt($ch, CURLOPT_TIMEOUT, $ftimeout);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                        curl_setopt($ch, CURLOPT_REFERER, $temp_img);
                        curl_exec($ch);
                        if (curl_errno($ch)) 
                        { 
                            instamatic_log_to_file('Error in curl download: ' . curl_error($ch));
                        }
                        curl_close($ch);
                        fclose($fh);
                    }
                    if($wp_filesystem->exists($the_temp_img_local))
                    {
                        instamatic_log_to_file('File downloaded using curl method: ' . $temp_img . ' locally to: ' . $the_temp_img_local);
                        $temp_img = $the_temp_img_local;
                        $delete = true;
                    }
                }
                if(!$wp_filesystem->exists($temp_img))
                {
                    try
                    {
                        if(!class_exists('\Eventviva\ImageResize')){require_once ($social_plugins_folder . "/res/ImageResize/ImageResize.php");}
                        $imageRes = new ImageResize($temp_img);
                        $imageRes->quality_jpg = 98;
                        if($imageRes->getSourceWidth() != $imageRes->getSourceHeight())
                        {
                            if(!($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 566) || ($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 1350))
                            {
                                if($imageRes->getSourceWidth() > $imageRes->getSourceHeight())
                                {
                                    $imageRes->resize(1080, 566, true);
                                }
                                else
                                {
                                    $imageRes->resize(1080, 1350, true);
                                }
                                $temp_img = instamatic_get_temp_dir() . 'instamaticimg' . uniqid() . '.jpg';
                                $imageRes->save($temp_img);
                            }
                        }
                    }
                    catch(Exception $e)
                    {
                        instamatic_log_to_file('Failed to resize image at posting, stage 2: ' . $e->getMessage());
                    }
                }
            }
            if(stristr($temp_img, '.png') !== false)
            {
                $featured_image_tmp = instamatic_png2jpg($temp_img);
                if($featured_image_tmp !== false)
                {
                    $restore_img = $temp_img;
                    $temp_img = $featured_image_tmp;
                    $delete_file = true;
                }
            }
        } catch (Exception $e) {
            instamatic_log_to_file("Exception while processing media for Instagram upload, for " . $image_link . ' : ' . $e->getMessage());
        }
        try 
        {
            $za_img = $apiInstance->imageForFeed($temp_img);
        } catch (Exception $e) {
            instamatic_log_to_file("Exception while creating image resource for " . $temp_img . ' : ' . $e->getMessage());
        }
        try 
        {
            $ppost = $apiInstance->uploadPhoto( $rrez[ 'logged_in_user' ][ 'pk' ], $za_img, $post_template, $image_link, 'timeline' );
            $posted = true;
        } catch (Exception $e) {
            instamatic_log_to_file("Exception while posting media to Instagram for " . $image_link . ' : ' . $e->getMessage());
        }
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Result: ' . print_r($ppost, true));
        }
        if($delete == true)
        {
            if ($wp_filesystem->exists($temp_img)) {
                $wp_filesystem->delete($temp_img);
            }
        }
        if($delete_file == true && $restore_img != '')
        {
            if ($wp_filesystem->exists($image_link)) {
                $wp_filesystem->delete($image_link);
            }
            $image_link = $restore_img;
        }
    }
    if($posted == true)
    {
        return array('success' => 'Published');
    }
    else
    {
        return array('error' => 'Nothing was posted, no results');
    }
}
?>