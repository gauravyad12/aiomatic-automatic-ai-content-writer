<?php
defined('ABSPATH') or die();
function aiomatic_return_god_function_assistants($god_mode, $dalle, $stable, $midjourney, $amazon, $amazon_details, $scraper, $rss, $google, $captions, $royalty, $youtube, $email, $facebook, $facebook_image, $twitter, $instagram, $pinterest, $business, $youtube_community, $reddit, $linkedin, $webhook, $stable_video)
{
    $return_arr = array();
    if ($god_mode === true)
    {
        $return_arr[] = aiomatic_get_god_mode_object();
    }
    if ($dalle === true)
    {
        $return_arr[] = aiomatic_get_dalle_object();
    }
    if ($stable === true)
    {
        $return_arr[] = aiomatic_get_stable_object();
    }
    if ($midjourney === true)
    {
        $return_arr[] = aiomatic_get_midjourney_object();
    }
    if ($stable_video === true)
    {
        $return_arr[] = aiomatic_get_stable_video_object();
    }
    if ($amazon === true)
    {
        $return_arr[] = aiomatic_get_amazon_object();
    }
    if ($amazon_details === true)
    {
        $return_arr[] = aiomatic_get_amazon_details_object();
    }
    if ($scraper === true)
    {
        $return_arr[] = aiomatic_get_scraper_object();
    }
    if ($rss === true)
    {
        $return_arr[] = aiomatic_get_rss_object();
    }
    if ($google === true)
    {
        $return_arr[] = aiomatic_get_google_object();
    }
    if ($captions === true)
    {
        $return_arr[] = aiomatic_get_youtube_captions_object();
    }
    if ($email === true)
    {
        $return_arr[] = aiomatic_get_email_object();
    }
    if ($webhook === true)
    {
        $return_arr[] = aiomatic_get_webhook_object();
    }
    if ($youtube === true)
    {
        $return_arr[] = aiomatic_get_youtube_object();
    }
    if ($royalty === true)
    {
        $return_arr[] = aiomatic_get_royalty_object();
    }
    if ($facebook === true)
    {
        $return_arr[] = aiomatic_get_facebook_object();
    }
    if ($facebook_image === true)
    {
        $return_arr[] = aiomatic_get_facebook_image_object();
    }
    if ($twitter === true)
    {
        $return_arr[] = aiomatic_get_twitter_object();
    }
    if ($instagram === true)
    {
        $return_arr[] = aiomatic_get_instagram_object();
    }
    if ($pinterest === true)
    {
        $return_arr[] = aiomatic_get_pinterest_object();
    }
    if ($business === true)
    {
        $return_arr[] = aiomatic_get_google_business_object();
    }
    if ($youtube_community === true)
    {
        $return_arr[] = aiomatic_get_youtube_community_object();
    }
    if ($reddit === true)
    {
        $return_arr[] = aiomatic_get_reddit_object();
    }
    if ($linkedin === true)
    {
        $return_arr[] = aiomatic_get_linkedin_object();
    }
    return $return_arr;
}
function aiomatic_get_god_mode_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_wp_god_mode',
        'Call any WordPress function using this wrapper function. Add the WP function name which needs to be called in the first parameter, and the parameters which needs to be sent to the function, in an array, sent as the second parameter for the wrapper function. Parameters will be processed using call_user_func_array, use parameters accordingly.',
        [
            new Aiomatic_Query_Parameter('called_function_name', 'The name of the WP function which needs to be called.', 'string', true),
            new Aiomatic_Query_Parameter('parameter_array', 'An array of parameters which should be sent to the function. Return parameters which can be parsed by call_user_func_array, as this is how the function will be called.', 'string', true)
        ]
        );
}
function aiomatic_get_dalle_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_image',
        'Call Dall-E AI to generate an image.',
        [
            new Aiomatic_Query_Parameter('prompt', 'The prompt which will be used for the AI image generator.', 'string', true)
        ]
        );
}
function aiomatic_get_amazon_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_amazon_listing',
        'Get an Amazon product listing based on a search keyword phrase.',
        [
            new Aiomatic_Query_Parameter('query', 'The keyword phrase for which the Amazon product listing should be returned.', 'string', true)
        ]
        );
}
function aiomatic_get_amazon_details_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_amazon_product_details',
        'Get details for a specific Amazon product, by ASIN or by keyword phrase.',
        [
            new Aiomatic_Query_Parameter('query', 'The ASIN or keyword phrase for which the Amazon product details should be returned.', 'string', true)
        ]
        );
}
function aiomatic_get_stable_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_stable_image',
        'Call Stable Diffusion AI to generate an image.',
        [
            new Aiomatic_Query_Parameter('prompt', 'The prompt which will be used for the AI image generator.', 'string', true)
        ]
        );
}
function aiomatic_get_midjourney_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_midjourney_image',
        'Call Midjourney AI to generate an image.',
        [
            new Aiomatic_Query_Parameter('prompt', 'The prompt which will be used for the AI image generator.', 'string', true)
        ]
        );
}
function aiomatic_get_stable_video_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_stable_video',
        'Call Stable Diffusion AI to generate a video based on an image URL.',
        [
            new Aiomatic_Query_Parameter('image_url', 'The ULR of the image which will be used as a source for the AI video generator.', 'string', true)
        ]
        );
}
function aiomatic_get_scraper_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_website_scraper',
        'Scrape any website URL and get the resulting content.',
        [
            new Aiomatic_Query_Parameter('url', 'The URL of the website which will be scraped.', 'string', true)
        ]
        );
}
function aiomatic_get_rss_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_rss_parser',
        'Parses RSS feeds and gets their content in a structured way.',
        [
            new Aiomatic_Query_Parameter('url', 'The URL of RSS feed which will be parsed.', 'string', true)
        ]
        );
}
function aiomatic_get_google_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_google_parser',
        'Parses Google SERP results and returns top search results.',
        [
            new Aiomatic_Query_Parameter('keywords', 'The search keywords for which the Google Search will be made.', 'string', true)
        ]
        );
}
function aiomatic_get_royalty_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_royalty_free_image',
        'Search multiple royalty free image provider websites for an image, based on a keyword.',
        [
            new Aiomatic_Query_Parameter('keyword', 'The search keyword for which a royalty free image will be searched.', 'string', true)
        ]
        );
}
function aiomatic_get_youtube_captions_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_youtube_captions',
        'Parses and returns the captions of a specific YouTube video, by its URL. This can be used to summarize a video.',
        [
            new Aiomatic_Query_Parameter('url', 'The URL of a YouTube video.', 'string', true)
        ]
        );
}
function aiomatic_get_youtube_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_youtube_search',
        'Searches YouTube for videos, based on a search keyword string. You can add the returned video URL in an iframe to embed it to a page.',
        [
            new Aiomatic_Query_Parameter('keyword', 'The search keywords for which a YouTube video will be searched.', 'string', true)
        ]
        );
}
function aiomatic_get_email_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_send_email',
        'Sends an email to a specific email address, with predefined email subject and content.',
        [
            new Aiomatic_Query_Parameter('subject', 'The subject of the email', 'string', true),
            new Aiomatic_Query_Parameter('content', 'The HTML content of the email', 'string', true),
            new Aiomatic_Query_Parameter('recipient_email', 'Defined the email address to which to send the email', 'string', true)
        ]
        );
}
function aiomatic_get_webhook_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_webhook',
        'Calls an external webhook using a predefined list of parameters.',
        [
            new Aiomatic_Query_Parameter('webhook_url', 'The URL of the webhook to be called', 'string', true),
            new Aiomatic_Query_Parameter('method_selector', 'The method to be used when calling the webhook. Possible values are: GET, POST, PUT, DELETE', 'string', true),
            new Aiomatic_Query_Parameter('content_type', 'Set the content type of the called webhook. Possible values are form_data or json', 'string', false),
            new Aiomatic_Query_Parameter('data', 'Set the data to be sent to the webhook. Set the main webhook content. If json was selected in the content_type parameter, enter a valid JSON structure here. If form_data was selected, enter the form data in this format: key => value (add new key/value combinations on a new line)', 'string', false),
            new Aiomatic_Query_Parameter('headers', 'Set any headers to send with the webhook request. Enter the headers in this structure: key => value (add new key/value combinations on a new line). You can also leave this field blank.', 'string', false)
        ]
        );
}
function aiomatic_get_facebook_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_facebook',
        'Publishes a textual post to Facebook, with an optional URL added to the post.',
        [
            new Aiomatic_Query_Parameter('content', 'The textual content of the Facebook post', 'string', true),
            new Aiomatic_Query_Parameter('url', 'The URL attached to the Facebook post', 'string', false)
        ]
        );
}
function aiomatic_get_facebook_image_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_image_facebook',
        'Publishes an image post to Facebook, with an optional image caption.',
        [
            new Aiomatic_Query_Parameter('image_url', 'The URL of the image to be published to Facebook', 'string', true),
            new Aiomatic_Query_Parameter('caption', 'An optional image caption text', 'string', false)
        ]
        );
}
function aiomatic_get_twitter_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_twitter',
        'Publishes a textual post to Twitter (X), with an optional image URL.',
        [
            new Aiomatic_Query_Parameter('content', 'The textual content of the Twitter (X) post', 'string', true),
            new Aiomatic_Query_Parameter('image_url', 'The optional URL of an image', 'string', false)
        ]
        );
}
function aiomatic_get_instagram_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_instagram',
        'Publishes an image post to Instagram, with an optional image text.',
        [
            new Aiomatic_Query_Parameter('image_url', 'The image URL to be sent to Instagram', 'string', true),
            new Aiomatic_Query_Parameter('content', 'The optional image description for the Instagram post', 'string', false)
        ]
        );
}
function aiomatic_get_pinterest_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_pinterest',
        'Publishes an image post to Pinterest, with a pin title, description and URL.',
        [
            new Aiomatic_Query_Parameter('image_url', 'The image URL to be sent to Pinterest', 'string', true),
            new Aiomatic_Query_Parameter('title', 'The title of the Pinterest pin', 'string', true),
            new Aiomatic_Query_Parameter('description', 'The description of the Pinterest pin', 'string', true),
            new Aiomatic_Query_Parameter('pin_url', 'The website URL attached to the Pinterest pin', 'string', false)
        ]
        );
}
function aiomatic_get_google_business_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_google_my_business',
        'Publishes a post to Google My Business, with a textual content and an image URL.',
        [
            new Aiomatic_Query_Parameter('content', 'The content of the GMB post', 'string', true),
            new Aiomatic_Query_Parameter('image_url', 'The URL of the image for the GMB post', 'string', true)
        ]
        );
}
function aiomatic_get_youtube_community_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_youtube_community',
        'Publishes a post to YouTube Community, with a textual content and an image URL.',
        [
            new Aiomatic_Query_Parameter('content', 'The content of the YouTube Community post', 'string', true),
            new Aiomatic_Query_Parameter('post_type', 'Set the YouTube Community post type. Possible values are: text, image', 'string', true),
            new Aiomatic_Query_Parameter('image_url', 'The URL of the image for the YouTube Community post.', 'string', false)
        ]
        );
}
function aiomatic_get_reddit_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_reddit',
        'Publishes a post to Reddit, with a textual content and a title.',
        [
            new Aiomatic_Query_Parameter('title', 'The title of the Reddit post', 'string', true),
            new Aiomatic_Query_Parameter('content', 'The content of the Reddit post', 'string', true)
        ]
        );
}
function aiomatic_get_linkedin_object()
{
    return new Aiomatic_Query_Function(
        'aiomatic_publish_linkedin',
        'Publishes a post to LinkedIn, with a title, link, description, content and image URL.',
        [
            new Aiomatic_Query_Parameter('title', 'The title of the LinkedIn post', 'string', true),
            new Aiomatic_Query_Parameter('content', 'The content of the LinkedIn post', 'string', true),
            new Aiomatic_Query_Parameter('description', 'The description of the LinkedIn post', 'string', false),
            new Aiomatic_Query_Parameter('link', 'The URL attached to the LinkedIn post', 'string', false),
            new Aiomatic_Query_Parameter('image_url', 'The URL of an image, which will be attached to the LinkedIn post', 'string', false)
        ]
        );
}
function aiomatic_return_god_function()
{
    $return_arr = array();
    $aiomatic_Chatbot_Settings = get_option('aiomatic_Chatbot_Settings', false);
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_wp']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_wp']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_god_mode_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_dalle']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_dalle']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_dalle_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_amazon']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_amazon']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_amazon_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_amazon_details']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_amazon_details']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_amazon_details_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_stable']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_stable']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_stable_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_midjourney']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_midjourney']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_midjourney_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_stable_video']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_stable_video']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_stable_video_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_scraper']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_scraper']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_scraper_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_rss']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_rss']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_rss_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_google']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_google']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_google_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_royalty']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_royalty']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_royalty_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_youtube']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_youtube']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_youtube_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_youtube_captions']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_youtube_captions']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_youtube_captions_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_email']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_email']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_email_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_webhook']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_webhook']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_webhook_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_facebook_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_facebook_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_facebook_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_facebook_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_facebook_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_facebook_image_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_twitter_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_twitter_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_twitter_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_instagram_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_instagram_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_instagram_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_pinterest_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_pinterest_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_pinterest_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_google_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_google_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_google_business_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_youtube_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_youtube_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_youtube_community_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_reddit_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_reddit_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_reddit_object());
    }
    if (isset($aiomatic_Chatbot_Settings['god_mode_enable_linkedin_post']) && trim($aiomatic_Chatbot_Settings['god_mode_enable_linkedin_post']) == 'on')
    {
        $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_linkedin_object());
    }
    return $return_arr;
}
add_filter('aiomatic_ai_functions', 'aiomatic_add_god_mode', 999, 1);
function aiomatic_add_god_mode($query) 
{
    if(is_array($query))
    {
        $functions = $query;
    }
    else
    {
        $functions = array();
    }
    if ( current_user_can( 'access_aiomatic_menu' ) ) 
    {
        $functions['functions'] = aiomatic_return_god_function();
        $functions['message'] = '';
    }
    return $functions;
}
?>