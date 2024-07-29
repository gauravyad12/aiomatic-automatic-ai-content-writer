<?php
defined('ABSPATH') or die();
function aiomatic_omniblocks_default_block_types() 
{
    $amazon_extended_shortcodes = array('product_score_', 'product_edition_', 'product_language_', 'product_pages_count_', 'product_publication_date_', 'product_contributors_', 'product_manufacturer_', 'product_binding_', 'product_product_group_', 'product_rating_', 'product_ean_', 'product_part_no_', 'product_model_', 'product_warranty_', 'product_color_', 'product_is_adult_', 'product_dimensions_', 'product_date_', 'product_size_', 'product_unit_count_');
    $amazon_shortcodes = array('product_title_', 'product_description_', 'product_url_', 'product_price_', 'product_list_price_', 'product_image_', 'product_cart_url_', 'product_images_urls_', 'product_images_', 'product_reviews_');
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
	if(!function_exists('is_plugin_active'))
	{
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	$amaz_ext_active = false;
	if (is_plugin_active('aiomatic-extension-amazon-api/aiomatic-extension-amazon-api.php')) 
	{
		$amaz_ext_active = true;
	}
	if(isset($aiomatic_Main_Settings['amazon_app_id']) && trim($aiomatic_Main_Settings['amazon_app_id']) != '' && isset($aiomatic_Main_Settings['amazon_app_secret']) && trim($aiomatic_Main_Settings['amazon_app_secret']) != '' && $amaz_ext_active !== false)
	{
        $amazon_shortcodes = array_merge($amazon_shortcodes, $amazon_extended_shortcodes);
    }
    $all_blocks = apply_filters('aiomniblocks_block_types', [
        'ai_text' => [
            'id' => 'ai_text',
            'name' => esc_html__('AI Text', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - AI Content Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Generates AI textual content using different models', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('ai_text_'),
            'parameters' => array(
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the content writer', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the content writer. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'assistant_id' => array(
                    'type' => 'assistant_select',
                    'title' => esc_html__('AI Assistant', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the AI Assistant to be used with the AI writer. If you select an assistant, a model cannot be selected any more, but instead, the model assigned to the assistant will be used.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'model_select',
                    'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the model to be used with the AI writer.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'ai_text_foreach' => [
            'id' => 'ai_text_foreach',
            'name' => esc_html__('AI Text For Each Line Of Input', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - AI Content Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Generates AI textual content using different models, calling the AI writer for each line of the input text (with respective prompt changes)', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('ai_text_foreach_'),
            'parameters' => array(
                'multiline_input' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Multiline Input', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the multiline input, which will be used to call the AI', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the multiline input which will be cut to lines and will be used to call the below prompt, for each of its lines. This input will be cut up to multiple lines and will create the %%current_input_line%% shortcode, usable below. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the content writer', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the content writer. Additional shortcodes you can use: %%current_input_line%%, %%current_input_line_counter%%, %%all_input_lines%%, %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'assistant_id' => array(
                    'type' => 'assistant_select',
                    'title' => esc_html__('AI Assistant', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the AI Assistant to be used with the AI writer. If you select an assistant, a model cannot be selected any more, but instead, the model assigned to the assistant will be used.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'model_select',
                    'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the model to be used with the AI writer.', 'aiomatic-automatic-ai-content-writer')
                ),
                'prepend' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Text To Prepend To Each Content Block', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Text to prepend', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the text to be prepend to each content block which was created by this OmniBlock.', 'aiomatic-automatic-ai-content-writer')
                ),
                'append' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Text To Append To Each Content Block', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Text to append', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the text to be appended to each content block which was created by this OmniBlock.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_runs' => array(
                    'type' => 'number',
                    'title' => esc_html__('Set The Maximum Number Of Lines To Process', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Max lines to process', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of lines to process. This field is optional.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'dalle_ai_image' => [
            'id' => 'dalle_ai_image',
            'name' => esc_html__('AI Image Dall-E', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - AI Content Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Generates AI images using different Dall-E models', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('dalle_image_'),
            'parameters' => array(
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the image generator', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the image generator. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'dalle_image_model_select',
                    'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Set the AI model to be used for the image generator.', 'aiomatic-automatic-ai-content-writer')
                ),
                'image_size' => array(
                    'type' => 'dalle_image_size_select',
                    'title' => esc_html__('Image Size', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Set the image size to be used for the image generator.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'stable_ai_image' => [
            'id' => 'stable_ai_image',
            'name' => esc_html__('AI Image Stable Diffusion', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - AI Content Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Generates AI images using different Stable Diffusion models', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('stability_image_'),
            'parameters' => array(
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the image generator', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the image generator. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'stable_image_model_select',
                    'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Set the AI model to be used for the image generator.', 'aiomatic-automatic-ai-content-writer')
                ),
                'image_size' => array(
                    'type' => 'stable_image_size_select',
                    'title' => esc_html__('Image Size', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Set the image size to be used for the image generator.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'midjourney_ai_image' => [
            'id' => 'midjourney_ai_image',
            'name' => esc_html__('AI Image Midjourney', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - AI Content Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Generates AI images using different Midjourney models', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('midjourney_image_'),
            'parameters' => array(
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the image generator', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the image generator. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'image_size' => array(
                    'type' => 'midjourney_image_size_select',
                    'title' => esc_html__('Image Size', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Set the image size to be used for the image generator.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'stable_ai_video' => [
            'id' => 'stable_ai_video',
            'name' => esc_html__('AI Video Stable Diffusion', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - AI Content Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Generates AI videos using different source images', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('stability_video_'),
            'parameters' => array(
                'image_url' => array(
                    'type' => 'url',
                    'title' => esc_html__('Source Image URL', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the source image URL which will be sent to the video generator', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the source image URL which will be sent to the video generator.', 'aiomatic-automatic-ai-content-writer')
                ),
                'image_size' => array(
                    'type' => 'stable_video_size_select',
                    'title' => esc_html__('Image Size', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Set the size of the image which will be sent to the AI video generator. Original images will be resized to the selected image size before sending.', 'aiomatic-automatic-ai-content-writer')
                ),
            )
        ],
        'crawl_sites' => [
            'id' => 'crawl_sites',
            'name' => esc_html__('Scrape Sites', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Scrapes data from websites and uses it for content creation', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('scraped_content_', 'scraped_content_plain_'),
            'parameters' => array(
                'url' => array(
                    'type' => 'url',
                    'title' => esc_html__('Scraped URL', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the URL to be scraped for data', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the URL to be scraped for data. You can also add multiple URLs (one on each line), from which a random one will be selected. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape_method' => array(
                    'type' => 'scraper_select',
                    'title' => esc_html__('Scraping Method', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the method to be used for scraping. This will affect the %%item_scraped_data%% shortcode.', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape_selector' => array(
                    'type' => 'scraper_type',
                    'title' => esc_html__('Scraping Query Selector', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the query type you want to search for the article full content.', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape_string' => array(
                    'type' => 'scraper_string',
                    'title' => esc_html__('Scraping Query String', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Input the search query for full content searching', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Input the search query for full content searching. This can be the ID or class name you want to search for, the regex expression you want to apply or the XPath/CSS Selector Expression you want to query for. You can also enter a comma separated list of selectors, in this case, the plugin will get the results for all. If you leave this field blank, content will be automatically detected for you. Multiple expressions supported, each on a different line.', 'aiomatic-automatic-ai-content-writer')
                ),
                'strip_tags' => array(
                    'type' => 'checkbox',
                    'title' => esc_html__('Strip All HTML Tags', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select if you want to remove all HTML tags from the scraped content and leave only the plain textual content in it.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_chars' => array(
                    'type' => 'number',
                    'title' => esc_html__('Maximum # Of Characters To Keep', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the maximum number of characters to keep from the scraped data', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of characters to keep from the scraped data.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'crawl_rss' => [
            'id' => 'crawl_rss',
            'name' => esc_html__('Scrape RSS', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Scrapes content from RSS feeds', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('rss_content_'),
            'parameters' => array(
                'url' => array(
                    'type' => 'url',
                    'title' => esc_html__('RSS Feed URL', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the URL of the RSS feed to be scraped for data', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the URL of the RSS feed to be scraped for data. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'template' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Results Template', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '[%%item_counter%%]: %%item_title%% - %%item_description%%',
                    'placeholder' => esc_html__('Set the template of the resulting string, which will be built after parsing the RSS feed', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the template of the resulting string, which will be built after parsing the RSS feed. You can use the following shortcodes, which will map to the values of each RSS feed item: %%item_counter%%, %%item_title%%, %%item_content%%, %%item_description%%, %%item_url%%, %%item_author%%, %%item_categories%%, %%item_scraped_data%% - the %%item_scraped_data%% shortcode will be usable only if you enable the \'Scrape Links\' feature from below.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_items' => array(
                    'type' => 'number',
                    'title' => esc_html__('Maximum # Of Items To Process', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '10',
                    'placeholder' => esc_html__('Set the maximum number of items to process', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of items to process. This will make the plugin process up to the maximum number of feed items and include them in the final result.', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape' => array(
                    'type' => 'checkbox',
                    'title' => esc_html__('Scrape Links', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Do you want to scrape each link and extract readable content from them? Note that this feature will add the scraped data into the %%item_scraped_data%% variable, be sure to use it in the template above!', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape_method' => array(
                    'type' => 'scraper_select',
                    'title' => esc_html__('Scraping Method', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the method to be used for scraping. This will affect the %%item_scraped_data%% shortcode.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_chars' => array(
                    'type' => 'number',
                    'title' => esc_html__('Maximum # Of Characters To Keep', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the maximum number of characters to keep from the scraped data', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of characters to keep from the scraped data.', 'aiomatic-automatic-ai-content-writer')
                ),
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Process Each Result With AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the content writer', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the content writer, to process each result. Additional shortcodes you can use: %%current_item%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported. If you don\'t add the %%current_item%% to the prompt, it will be automatically appended to the end of it.', 'aiomatic-automatic-ai-content-writer')
                ),
                'assistant_id' => array(
                    'type' => 'assistant_select',
                    'title' => esc_html__('AI Assistant', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the AI Assistant to be used with the AI writer. If you select an assistant, a model cannot be selected any more, but instead, the model assigned to the assistant will be used.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'model_select',
                    'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the model to be used with the AI writer.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'google_search' => [
            'id' => 'google_search',
            'name' => esc_html__('Google Search', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Search Google and get search results data', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('search_result_'),
            'parameters' => array(
                'keyword' => array(
                    'type' => 'text',
                    'title' => esc_html__('Keyword', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the keyword for which SERP data is queried', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the keyword for which SERP data is queried. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'locale' => array(
                    'type' => 'text',
                    'title' => esc_html__('Search Results Location', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('2 letter country code', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Specifying this parameter should lead to more relevant results for a specific country. This is particularly true for international customers and, even more specifically, for customers in English- speaking countries other than the United States. To restrict search results only to websites located in a specific country, specify this parameter as: countryDE - replace DE with your own 2 letter country code', 'aiomatic-automatic-ai-content-writer')
                ),
                'template' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Results Template', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '[%%item_counter%%]: %%item_title%% - %%item_snippet%%',
                    'placeholder' => esc_html__('Set the template of the resulting string, which will be built after parsing the search results', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the template of the resulting string, which will be built after parsing the search results. You can use the following shortcodes, which will map to the values of each search results item: %%item_counter%%, %%item_title%%, %%item_snippet%%, %%item_url%%, %%item_scraped_data%% - the %%item_scraped_data%% shortcode will be usable only if you enable the \'Scrape Links\' feature from below.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_items' => array(
                    'type' => 'number',
                    'title' => esc_html__('Maximum # Of Items To Process', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '10',
                    'placeholder' => esc_html__('Set the maximum number of items to process', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of items to process. This will make the plugin process up to the maximum number of search results items and include them in the final result.', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape' => array(
                    'type' => 'checkbox',
                    'title' => esc_html__('Scrape Links', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Do you want to scrape each link and extract readable content from them? Note that this feature will add the scraped data into the %%item_scraped_data%% variable, be sure to use it in the template above!', 'aiomatic-automatic-ai-content-writer')
                ),
                'scrape_method' => array(
                    'type' => 'scraper_select',
                    'title' => esc_html__('Scraping Method', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the method to be used for scraping. This will affect the %%item_scraped_data%% shortcode.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_chars' => array(
                    'type' => 'number',
                    'title' => esc_html__('Maximum # Of Characters To Keep', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the maximum number of characters to keep from the scraped data', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of characters to keep from the scraped data.', 'aiomatic-automatic-ai-content-writer')
                ),
                'prompt' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Process Each Result With AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the AI prompt which will be sent to the content writer', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the AI prompt which will be sent to the content writer, to process each result. Additional shortcodes you can use: %%current_item%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported. If you don\'t add the %%current_item%% to the prompt, it will be automatically appended to the end of it.', 'aiomatic-automatic-ai-content-writer')
                ),
                'assistant_id' => array(
                    'type' => 'assistant_select',
                    'title' => esc_html__('AI Assistant', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the AI Assistant to be used with the AI writer. If you select an assistant, a model cannot be selected any more, but instead, the model assigned to the assistant will be used.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'model_select',
                    'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the model to be used with the AI writer.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'youtube_caption' => [
            'id' => 'youtube_caption',
            'name' => esc_html__('YouTube Video Caption', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Scrapes the YouTube video captions and uses them for AI content creation', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('video_caption_', 'video_title_', 'video_description_', 'video_thumb_'),
            'parameters' => array(
                'url' => array(
                    'type' => 'url',
                    'title' => esc_html__('YouTube Video URL', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the URL of the YouTube video from which captions will be imported', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the URL of the YouTube video from which captions will be imported.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_caption' => array(
                    'type' => 'number',
                    'title' => esc_html__('Maximum Result Length', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the maximum length in characters of the resulting string', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum length in characters of the resulting string. If the captions are longer than this value, they will shortened.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'amazon_product' => [
            'id' => 'amazon_product',
            'name' => esc_html__('Amazon Product Details', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Amazon Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Scrapes product details from Amazon, by ASIN', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => $amazon_shortcodes,
            'parameters' => array(
                'asin' => array(
                    'type' => 'text',
                    'title' => esc_html__('Single Product ASIN or Keyword', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Example: B07RZ74VLR', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Please provide a single ASIN of an Amazon product (ex: B07RZ74VLR).', 'aiomatic-automatic-ai-content-writer')
                ),
                'aff_id' => array(
                    'type' => 'text',
                    'title' => esc_html__('Amazon Associate ID', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Insert your Amazon Associate ID', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Insert your Amazon Associate ID (Optional).', 'aiomatic-automatic-ai-content-writer')
                ),
                'target_country' => array(
                    'type' => 'amazon_country_select',
                    'title' => esc_html__('Amazon Target Country', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the country where you have registred your affiliate account.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'amazon_listing' => [
            'id' => 'amazon_listing',
            'name' => esc_html__('Amazon Product Listing', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Amazon Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Scrapes product listing details from Amazon, by ASIN or keyword', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('product_listing_'),
            'parameters' => array(
                'asin' => array(
                    'type' => 'text',
                    'title' => esc_html__('Product Search Keywords / Product ASIN List', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Example: dog food', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Please provide the a search keyword for Amazon products to be included in the created content. Alternatively, you can provide a comma separated list of product ASINs (ex: B07RZ74VLR,B07RX6FBFR).', 'aiomatic-automatic-ai-content-writer')
                ),
                'aff_id' => array(
                    'type' => 'text',
                    'title' => esc_html__('Amazon Associate ID', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Insert your Amazon Associate ID', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Insert your Amazon Associate ID (Optional).', 'aiomatic-automatic-ai-content-writer')
                ),
                'target_country' => array(
                    'type' => 'amazon_country_select',
                    'title' => esc_html__('Amazon Target Country', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the country where you have registred your affiliate account.', 'aiomatic-automatic-ai-content-writer')
                ),
                'sort_results' => array(
                    'type' => 'amazon_sort_select',
                    'title' => esc_html__('Sort Amazon Results By', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the type of sorting of the returned results.', 'aiomatic-automatic-ai-content-writer')
                ),
                'max_product_count' => array(
                    'type' => 'text',
                    'title' => esc_html__('Maximum Number Of Products To Query', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the maximum number of products to add in the product listing', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the maximum number of products to add in the product listing. You can also set a variable number of products, case in which a random number will be selected from the range you specify. Example 5-7', 'aiomatic-automatic-ai-content-writer')
                ),
                'listing_template' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Product Listing Template', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '%%product_counter%%. %%product_title%% - Desciption: %%product_description%% - Link: %%product_url%% - Price: %%product_price%%',
                    'placeholder' => esc_html__('Set what information do you want to add into each product listing entry', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set what information do you want to add into each product listing entry. You can use the following shortcodes to get data for specific products: %%product_counter%%, %%product_title%%, %%product_description%%, %%product_url%%, %%product_price%%, %%product_list_price%%, %%product_image%%, %%product_cart_url%%, %%product_images_urls%%, %%product_images%%, %%product_reviews%%. If you have access to the Amazon API, you can set it up in the plugin and get access to the following advanced shortcodes also: %%product_score%%, %%product_edition%%, %%product_language%%, %%product_pages_count%%, %%product_publication_date%%, %%product_contributors%%, %%product_manufacturer%%, %%product_binding%%, %%product_product_group%%, %%product_rating%%, %%product_ean%%, %%product_part_no%%, %%product_model%%, %%product_warranty%%, %%product_color%%, %%product_is_adult%%, %%product_dimensions%%, %%product_date%%, %%product_size%%, %%product_unit_count%%', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'text_translate' => [
            'id' => 'text_translate',
            'name' => esc_html__('Text Translator', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Processing Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Translates text using Google Translate/Microsoft Translator/DeepL. To use Microsoft Translator or DeepL, add your API key for these services in the plugin\'s \'Settings\' menu.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('translated_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Text To Be Translated', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Input your text', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Provide the text which needs to be translated.', 'aiomatic-automatic-ai-content-writer')
                ),
                'translate' =>  array(
                    'type' => 'language_selector',
                    'title' => esc_html__('Translate Content To', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Do you want to automatically translate generated content using Google Translate/Microsoft Translator/DeepL to any language?', 'aiomatic-automatic-ai-content-writer')
                ),
                'translate_source' =>  array(
                    'type' => 'language_selector',
                    'title' => esc_html__('Translation Source Language', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the source language of the translation.', 'aiomatic-automatic-ai-content-writer')
                ),
                'second_translate' =>  array(
                    'type' => 'language_selector',
                    'title' => esc_html__('Do Also A Second Translation To', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Do you want to automatically translate generated content a second time, to this final language? In some cases, this can replace word spinning of scraped content. Please note that this can increase the amount of requests made to the translation APIs. This field has no effect if you don\'t set also a first translation language, in the settings field from above.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'text_spinner' => [
            'id' => 'text_spinner',
            'name' => esc_html__('Text Spinner', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Processing Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Spins the text and rewrites it, making it unique. For this feature to work, you need to select a text spinner service from the plugin\'s \'Settings\' menu -> \'Bulk Posts\' tab -> \'Spin Text Using Word Synonyms\' settings field.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('spun_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Text To Be Spun', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Input your text', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Provide the text which needs to be spun.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'royalty_image' => [
            'id' => 'royalty_image',
            'name' => esc_html__('Royalty Free Image Search', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Media Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Adds a related royalty free images to the content. For this feature to work, you need to select one or multipel royalty free images services from the plugin\'s \'Settings\' menu -> \'Royalty Free Images\' tab.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('free_image_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Image Keyword Search', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the keyword based on which royalty free images will be searched', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the keyword based on which royalty free images will be searched. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'youtube_video' => [
            'id' => 'youtube_video',
            'name' => esc_html__('YouTube Video Search', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Media Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Adds a related YouTube video to the content.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('video_url_', 'video_embed_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Video Keyword Search', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the keyword based on which YouTube videos will be searched', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the keyword based on which YouTube videos will be searched. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'embeddings' => [
            'id' => 'embeddings',
            'name' => esc_html__('Embeddings Result', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Outputs an embeddings result from the embeddings you have created in the plugin, based on the text input sent to this OmniBlock. Note that for this feature to work, you need to enable embeddings in the plugin and create embeddings texts, which matches the result you are expecting.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('embeddings_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Embeddings Input', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Input your text', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Provide the text which will be used to generate the embeddings result.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'load_file' => [
            'id' => 'load_file',
            'name' => esc_html__('Load File Content', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Gathers the content of a single file.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('file_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'file_selector',
                    'title' => esc_html__('File To Load', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'description' => esc_html__('Select the file to load into a shortcode. You can load plain text files or xlsx files. If you load an xlsx file, you can also use the following shortcodes to access xlsx data: %%xlsx_BLOCKID_XLSXROW_XLSXCOLUMN%%, %%xlsx_BLOCKID_column_XLSXCOLUMN%%, %%xlsx_BLOCKID_row_XLSXROW%%, %%xlsx_BLOCKID_row_random%%, %%xlsx_BLOCKID_row_random_check%%', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'nlp_entities' => [
            'id' => 'nlp_entities',
            'name' => esc_html__('Related NLP Entities - TextRazor', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Using TextRazor API, gets related entities to keywords.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('entities_', 'entities_details_json_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'text',
                    'title' => esc_html__('Entities Search Keywords', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Example: dog food', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Please provide the a search keyword for the related entities search.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'nlp_entities_neuron' => [
            'id' => 'nlp_entities_neuron',
            'name' => esc_html__('Related NLP Entities - NeuronWriter', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Using NeuronWriter API, gets related entities to keywords.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('entities_title_', 'entities_description_', 'entities_h1_', 'entities_h2_', 'entities_content_basic_', 'entities_content_basic_with_ranges_', 'entities_content_extended_', 'entities_content_extended_with_ranges_', 'entities_list_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'text',
                    'title' => esc_html__('Entities Search Keywords', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Example: dog food', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Please provide the a search keyword for the related entities search.', 'aiomatic-automatic-ai-content-writer')
                ),
                'engine' => array(
                    'type' => 'select',
                    'values' => array("google.al" => "ALBANIA | google.AL", "google.ad" => "ANDORRA | google.AD", "google.at" => "AUSTRIA | google.AT", "google.by" => "BELARUS | google.BY", "google.be" => "BELGIUM | google.BE", "google.ba" => "BOSNIA AND HERZEGOVINA | google.BA", "google.bg" => "BULGARIA | google.BG", "google.hr" => "CROATIA | google.HR", "google.cz" => "CZECH REPUBLIC | google.CZ", "google.dk" => "DENMARK | google.DK", "google.ee" => "ESTONIA | google.EE", "google.fi" => "FINLAND | google.FI", "google.fr" => "FRANCE | google.FR", "google.de" => "GERMANY | google.DE", "google.com.gi" => "GIBRALTAR | google.com.GI", "google.gr" => "GREECE | google.GR", "google.gg" => "GUERNSEY | google.GG", "google.hu" => "HUNGARY | google.HU", "google.is" => "ICELAND | google.IS", "google.ie" => "IRELAND | google.IE", "google.im" => "ISLE OF MAN | google.IM", "google.it" => "ITALY | google.IT", "google.je" => "JERSEY | google.JE", "google.lv" => "LATVIA | google.LV", "google.li" => "LIECHTENSTEIN | google.LI", "google.lt" => "LITHUANIA | google.LT", "google.lu" => "LUXEMBOURG | google.LU", "google.mk" => "MACEDONIA | google.MK", "google.com.mt" => "MALTA | google.com.MT", "google.md" => "MOLDOVA | google.MD", "google.me" => "MONTENEGRO | google.ME", "google.nl" => "NETHERLANDS | google.NL", "google.no" => "NORWAY | google.NO", "google.pl" => "POLAND | google.PL", "google.pt" => "PORTUGAL | google.PT", "google.ro" => "ROMANIA | google.RO", "google.ru" => "RUSSIA | google.RU", "google.sm" => "SAN MARINO | google.SM", "google.rs" => "SERBIA | google.RS", "google.sk" => "SLOVAKIA | google.SK", "google.si" => "SLOVENIA | google.SI", "google.es" => "SPAIN | google.ES", "google.se" => "SWEDEN | google.SE", "google.ch" => "SWITZERLAND | google.CH", "google.com.tr" => "TURKEY | google.com.TR", "google.com.ua" => "UKRAINE | google.com.UA", "google.co.uk" => "UNITED KINGDOM | google.co.UK", "google.com.ag" => "ANTIGUA AND BARBUDA | google.com.AG", "google.bs" => "BAHAMAS | google.BS", "google.com.bz" => "BELIZE | google.com.BZ", "google.vg" => "BRITISH VIRGIN ISLANDS | google.VG", "google.ca" => "CANADA | google.CA", "google.co.cr" => "COSTA RICA | google.co.CR", "google.com.cu" => "CUBA | google.com.CU", "google.dm" => "DOMINICA | google.DM", "google.com.do" => "DOMINICAN REPUBLIC | google.com.DO", "google.com.sv" => "EL SALVADOR | google.com.SV", "google.gl" => "GREENLAND | google.GL", "google.com.gt" => "GUATEMALA | google.com.GT", "google.ht" => "HAITI | google.HT", "google.hn" => "HONDURAS | google.HN", "google.com.jm" => "JAMAICA | google.com.JM", "google.com.mx" => "MEXICO | google.com.MX", "google.com.ni" => "NICARAGUA | google.com.NI", "google.com.pa" => "PANAMA | google.com.PA", "google.com.pr" => "PUERTO RICO | google.com.PR", "google.com.vc" => "SAINT VINCENT AND THE GRENADINES | google.com.VC", "google.tt" => "TRINIDAD AND TOBAGO | google.TT", "google.com" => "UNITED STATES (USA) | google.COM", "google.co.vi" => "VIRGIN ISLANDS | google.co.VI", "google.com.ar" => "ARGENTINA | google.com.AR", "google.com.bo" => "BOLIVIA | google.com.BO", "google.com.br" => "BRAZIL | google.com.BR", "google.cl" => "CHILE | google.CL", "google.com.co" => "COLOMBIA | google.com.CO", "google.com.ec" => "ECUADOR | google.com.EC", "google.gy" => "GUYANA | google.GY", "google.com.py" => "PARAGUAY | google.com.PY", "google.com.pe" => "PERU | google.com.PE", "google.sr" => "SURINAME | google.SR", "google.com.uy" => "URUGUAY | google.com.UY", "google.co.ve" => "VENEZUELA | google.co.VE", "google.com.af" => "AFGHANISTAN | google.com.AF", "google.am" => "ARMENIA | google.AM", "google.az" => "AZERBAIJAN | google.AZ", "google.com.bh" => "BAHRAIN | google.com.BH", "google.com.bd" => "BANGLADESH | google.com.BD", "google.bt" => "BHUTAN | google.BT", "google.com.bn" => "BRUNEI | google.com.BN", "google.com.kh" => "CAMBODIA | google.com.KH", "google.cn" => "CHINA | google.CN", "google.com.cy" => "CYPRUS | google.com.CY", "google.ge" => "GEORGIA | google.GE", "google.com.hk" => "HONG KONG | google.com.HK", "google.co.in" => "INDIA | google.co.IN", "google.co.id" => "INDONESIA | google.co.ID", "google.iq" => "IRAQ | google.IQ", "google.co.il" => "ISRAEL | google.co.IL", "google.co.jp" => "JAPAN | google.co.JP", "google.jo" => "JORDAN | google.JO", "google.kz" => "KAZAKHSTAN | google.KZ", "google.com.kw" => "KUWAIT | google.com.KW", "google.kg" => "KYRGYZSTAN | google.KG", "google.la" => "LAOS | google.LA", "google.com.lb" => "LEBANON | google.com.LB", "google.com.my" => "MALAYSIA | google.com.MY", "google.mv" => "MALDIVES | google.MV", "google.mn" => "MONGOLIA | google.MN", "google.com.mm" => "MYANMAR | google.com.MM", "google.com.np" => "NEPAL | google.com.NP", "google.com.om" => "OMAN | google.com.OM", "google.com.pk" => "PAKISTAN | google.com.PK", "google.ps" => "PALESTINE | google.PS", "google.com.ph" => "PHILIPPINES | google.com.PH", "google.com.qa" => "QATAR | google.com.QA", "google.com.sa" => "SAUDI ARABIA | google.com.SA", "google.com.sg" => "SINGAPORE | google.com.SG", "google.co.kr" => "SOUTH KOREA | google.co.KR", "google.lk" => "SRI LANKA | google.LK", "google.com.tw" => "TAIWAN | google.com.TW", "google.com.tj" => "TAJIKISTAN | google.com.TJ", "google.co.th" => "THAILAND | google.co.TH", "google.tl" => "TIMOR-LESTE | google.TL", "google.tm" => "TURKMENISTAN | google.TM", "google.ae" => "UNITED ARAB EMIRATES | google.AE", "google.co.uz" => "UZBEKISTAN | google.co.UZ", "google.com.vn" => "VIETNAM | google.com.VN", "google.dz" => "ALGERIA | google.DZ", "google.co.ao" => "ANGOLA | google.co.AO", "google.bj" => "BENIN | google.BJ", "google.co.bw" => "BOTSWANA | google.co.BW", "google.bf" => "BURKINA FASO | google.BF", "google.bi" => "BURUNDI | google.BI", "google.cm" => "CAMEROON | google.CM", "google.cv" => "CAPE VERDE | google.CV", "google.cf" => "CENTRAL AFRICAN REPUBLIC | google.CF", "google.td" => "CHAD | google.TD", "google.cd" => "DEMOCRATIC REPUBLIC OF THE CONGO | google.CD", "google.dj" => "DJIBOUTI | google.DJ", "google.com.eg" => "EGYPT | google.com.EG", "google.com.et" => "ETHIOPIA | google.com.ET", "google.ga" => "GABON | google.GA", "google.gm" => "GAMBIA | google.GM", "google.com.gh" => "GHANA | google.com.GH", "google.ci" => "IVORY COAST | google.CI", "google.co.ke" => "KENYA | google.co.KE", "google.co.ls" => "LESOTHO | google.co.LS", "google.com.ly" => "LIBYA | google.com.LY", "google.mg" => "MADAGASCAR | google.MG", "google.mw" => "MALAWI | google.MW", "google.ml" => "MALI | google.ML", "google.mu" => "MAURITIUS | google.MU", "google.co.ma" => "MOROCCO | google.co.MA", "google.co.mz" => "MOZAMBIQUE | google.co.MZ", "google.com.na" => "NAMIBIA | google.com.NA", "google.ne" => "NIGER | google.NE", "google.com.ng" => "NIGERIA | google.com.NG", "google.cg" => "REPUBLIC OF THE CONGO | google.CG", "google.rw" => "RWANDA | google.RW", "google.sh" => "SAINT HELENA | google.SH", "google.st" => "SAO TOMÉ AND PRÍNCIPE | google.ST", "google.sn" => "SENEGAL | google.SN", "google.sc" => "SEYCHELLES | google.SC", "google.com.sl" => "SIERRA LEONE | google.com.SL", "google.so" => "SOMALIA | google.SO", "google.co.za" => "SOUTH AFRICA | google.co.ZA", "google.co.tz" => "TANZANIA | google.co.TZ", "google.tg" => "TOGO | google.TG", "google.tn" => "TUNISIA | google.TN", "google.co.ug" => "UGANDA | google.co.UG", "google.co.zm" => "ZAMBIA | google.co.ZM", "google.co.zw" => "ZIMBABWE | google.co.ZW", "google.as" => "AMERICAN SAMOA | google.AS", "google.com.ai" => "ANGUILLA | google.com.AI", "google.com.au" => "AUSTRALIA | google.com.AU", "google.co.ck" => "COOK ISLANDS | google.co.CK", "google.com.fj" => "FIJI | google.com.FJ", "google.ki" => "KIRIBATI | google.KI", "google.fm" => "MICRONESIA | google.FM", "google.ms" => "MONTSERRAT | google.MS", "google.nr" => "NAURU | google.NR", "google.co.nz" => "NEW ZEALAND | google.co.NZ", "google.nu" => "NIUE | google.NU", "google.com.pg" => "PAPUA NEW GUINEA | google.com.PG", "google.pn" => "PITCAIRN | google.PN", "google.com.sb" => "SOLOMON ISLANDS | google.com.SB", "google.to" => "TONGA | google.TO", "google.vu" => "VANUATU | google.VU", "google.ws" => "WESTERN SAMOA | google.WS"),
                    'title' => esc_html__('Search Engine', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => 'google.co.uk',
                    'description' => esc_html__('Set the search engine you want to use for results querying', 'aiomatic-automatic-ai-content-writer')
                ),
                'language' => array(
                    'type' => 'select',
                    'values' => array("Abkhazian" => "Abkhazian", "Afar" => "Afar", "Afrikaans" => "Afrikaans", "Akan" => "Akan", "Albanian" => "Albanian", "Amharic" => "Amharic", "Arabic" => "Arabic", "Aragonese" => "Aragonese", "Armenian" => "Armenian", "Assamese" => "Assamese", "Avaric" => "Avaric", "Aymara" => "Aymara", "Azerbaijani" => "Azerbaijani", "Bambara" => "Bambara", "Bashkir" => "Bashkir", "Basque" => "Basque", "Belarusian" => "Belarusian", "Bengali" => "Bengali", "Bihari" => "Bihari", "Bislama" => "Bislama", "Bosnian" => "Bosnian", "Breton" => "Breton", "Bulgarian" => "Bulgarian", "Burmese" => "Burmese", "Catalan" => "Catalan", "Chamorro" => "Chamorro", "Chechen" => "Chechen", "Chinese" => "Chinese", "Chuvash" => "Chuvash", "Corsican" => "Corsican", "Cree" => "Cree", "Croatian" => "Croatian", "Czech" => "Czech", "Danish" => "Danish", "Dhivehi" => "Dhivehi", "Dutch" => "Dutch", "Dzongkha" => "Dzongkha", "English" => "English", "Esperanto" => "Esperanto", "Estonian" => "Estonian", "Ewe" => "Ewe", "Faroese" => "Faroese", "Fijian" => "Fijian", "Finnish" => "Finnish", "French" => "French", "Fulah" => "Fulah", "Galician" => "Galician", "Ganda" => "Ganda", "Georgian" => "Georgian", "German" => "German", "Greek" => "Greek", "Guarani" => "Guarani", "Gujarati" => "Gujarati", "Haitian" => "Haitian", "Hausa" => "Hausa", "Hebrew" => "Hebrew", "Herero" => "Herero", "Hindi" => "Hindi", "Hiri Motu" => "Hiri Motu", "Hungarian" => "Hungarian", "Icelandic" => "Icelandic", "Igbo" => "Igbo", "Indonesian" => "Indonesian", "Inuktitut" => "Inuktitut", "Inupiaq" => "Inupiaq", "Irish" => "Irish", "Italian" => "Italian", "Japanese" => "Japanese", "Javanese" => "Javanese", "Kalaallisut" => "Kalaallisut", "Kannada" => "Kannada", "Kanuri" => "Kanuri", "Kashmiri" => "Kashmiri", "Kazakh" => "Kazakh", "Khmer" => "Khmer", "Kikuyu" => "Kikuyu", "Kinyarwanda" => "Kinyarwanda", "Kirghiz" => "Kirghiz", "Komi" => "Komi", "Kongo" => "Kongo", "Korean" => "Korean", "Kuanyama" => "Kuanyama", "Kurdish" => "Kurdish", "Lao" => "Lao", "Latvian" => "Latvian", "Limburgan" => "Limburgan", "Lingala" => "Lingala", "Lithuanian" => "Lithuanian", "Luba-Katanga" => "Luba-Katanga", "Luxembourgish" => "Luxembourgish", "Macedonian" => "Macedonian", "Malagasy" => "Malagasy", "Malay" => "Malay", "Malayalam" => "Malayalam", "Maltese" => "Maltese", "Maori" => "Maori", "Marathi" => "Marathi", "Marshallese" => "Marshallese", "Moldavian" => "Moldavian", "Mongolian" => "Mongolian", "Nauru" => "Nauru", "Navajo" => "Navajo", "Ndonga" => "Ndonga", "Nepali" => "Nepali", "North Ndebele" => "North Ndebele", "Northern Sami" => "Northern Sami", "Norwegian" => "Norwegian", "Nyanja" => "Nyanja", "Occitan" => "Occitan", "Ojibwa" => "Ojibwa", "Oriya" => "Oriya", "Oromo" => "Oromo", "Ossetian" => "Ossetian", "Panjabi" => "Panjabi", "Persian" => "Persian", "Polish" => "Polish", "Portuguese (Brazil)" => "Portuguese (Brazil)", "Portuguese" => "Portuguese", "Pushto" => "Pushto", "Quechua" => "Quechua", "Romanian" => "Romanian", "Romansh" => "Romansh", "Rundi" => "Rundi", "Russian" => "Russian", "Samoan" => "Samoan", "Sango" => "Sango", "Sanskrit" => "Sanskrit", "Sardinian" => "Sardinian", "Gaelic" => "Gaelic", "Serbian" => "Serbian", "Shona" => "Shona", "Sichuan Yi" => "Sichuan Yi", "Sindhi" => "Sindhi", "Sinhala" => "Sinhala", "Slovak" => "Slovak", "Slovenian" => "Slovenian", "Somali" => "Somali", "South Ndebele" => "South Ndebele", "Southern Sotho" => "Southern Sotho", "Spanish" => "Spanish", "Sundanese" => "Sundanese", "Swahili" => "Swahili", "Swati" => "Swati", "Swedish" => "Swedish", "Tagalog" => "Tagalog", "Tahitian" => "Tahitian", "Tajik" => "Tajik", "Tamil" => "Tamil", "Tatar" => "Tatar", "Telugu" => "Telugu", "Thai" => "Thai", "Tibetan" => "Tibetan", "Tigrinya" => "Tigrinya", "Tonga" => "Tonga", "Tsonga" => "Tsonga", "Tswana" => "Tswana", "Turkish" => "Turkish", "Turkmen" => "Turkmen", "Twi" => "Twi", "Uighur" => "Uighur", "Ukrainian" => "Ukrainian", "Urdu" => "Urdu", "Uzbek" => "Uzbek", "Venda" => "Venda", "Vietnamese" => "Vietnamese", "Walloon" => "Walloon", "Welsh" => "Welsh", "Western Frisian" => "Western Frisian", "Wolof" => "Wolof", "Xhosa" => "Xhosa", "Yiddish" => "Yiddish", "Yoruba" => "Yoruba", "Zhuang" => "Zhuang", "Zulu" => "Zulu"),
                    'title' => esc_html__('Search Language', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => 'English',
                    'description' => esc_html__('Set the search language you want to use for results querying', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'tts_openai' => [
            'id' => 'tts_openai',
            'name' => esc_html__('Text-To-Speech - OpenAI', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Using OpenAI API, transforms text to speech (audio).', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('audio_url'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'text',
                    'title' => esc_html__('Text', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Text to be transformed into speech', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Please provide the text which will be transformed into speech.', 'aiomatic-automatic-ai-content-writer')
                ),
                'model' => array(
                    'type' => 'select',
                    'values' => array("tts-1" => "tts-1", "tts-1-hd" => "tts-1-hd"),
                    'title' => esc_html__('AI TTS Model', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => 'tts-1',
                    'description' => esc_html__('Set the AI TTS model to be used.', 'aiomatic-automatic-ai-content-writer')
                ),
                'voice' => array(
                    'type' => 'select',
                    'values' => array("alloy" => "alloy", "echo" => "echo", "fable" => "fable", "nova" => "nova", "onyx" => "onyx", "shimmer" => "shimmer"),
                    'title' => esc_html__('AI Voice Selector', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => 'alloy',
                    'description' => esc_html__('Select the voice to be used when generating the text to speech.', 'aiomatic-automatic-ai-content-writer')
                ),
                'output' => array(
                    'type' => 'select',
                    'values' => array("mp3" => "mp3", "opus" => "opus", "aac" => "aac", "flac" => "flac"),
                    'title' => esc_html__('AI Voice Output Format', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => 'mp3',
                    'description' => esc_html__('Select the output format to be used when generating the text to speech.', 'aiomatic-automatic-ai-content-writer')
                ),
                'stability' => array(
                    'type' => 'number',
                    'title' => esc_html__('Voice Stability', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '1',
                    'placeholder' => esc_html__('1', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Select a the Voice speed of the chosen voice. The default value is 1. Min: 0.25, max: 4.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'webhook_fire' => [
            'id' => 'webhook_fire',
            'name' => esc_html__('Webhook Listener', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Using data from a webhook URL, run OmniBlock rules automatically, even when not scheduled. Webhook URL is: %%webhook_url%%', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('webhook_data_'),
            'parameters' => array(
                'api_key' => array(
                    'type' => 'text',
                    'title' => esc_html__('Webhook API Key', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set your API own API key which will allow access to your webhook', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set your API own API key which will allow access to your webhook. This will prevent unauthorized requests from accessing the webhook.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'post_import' => [
            'id' => 'post_import',
            'name' => esc_html__('Post Data Importing', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Returns content from a specific post ID or search query. You can get many specific data from a post, based on its ID or by a search query', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('post_id_', 'post_url_', 'post_title_', 'post_content_', 'post_excerpt_', 'post_categories_', 'post_tags_', 'post_author_', 'post_date_', 'post_status_', 'post_type_', 'post_image_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'text',
                    'title' => esc_html__('Post ID / Advanced Query', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Input a post ID or an advanced query', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Provide the post ID for which you want to query the content. You can also set the advanced query parameters for what posts to process. Learn more about these parameters here: https://developer.wordpress.org/reference/classes/wp_query/ - Example: to process posts from a specific category, insert: &category_name=category_slug - If you want to process a single post returned by the search query only once, you can do it by defining the following search parameter here: aiomatic_unique_tag=your_unique_tag', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'random_line' => [
            'id' => 'random_line',
            'name' => esc_html__('Random Line Of Text', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Content Gathering Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Returns a random line of text, from the lines entered in the OmniBlock input.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array('random_line_'),
            'parameters' => array(
                'input_text' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Text Input (Multiline)', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Input a multiline text', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Input a multiline text, this OmniBlock will select at each run, a random line from it', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'if_block' => [
            'id' => 'if_block',
            'name' => esc_html__('Conditional (IF) OmniBlock', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Logic Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Executes a set of OmniBlocks if a condition is met, otherwise executes another set of OmniBlocks.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array(),
            'parameters' => array(
                'condition' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Condition', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the condition to be evaluated', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the condition which will be evaluated. This will get the result of the condition.', 'aiomatic-automatic-ai-content-writer')
                ),
                'evaluation_method' => array(
                    'type' => 'select',
                    'values' => array("equals" => "Equals", 'not_equals' => 'Not Equals', 'contains' => 'Contains', 'not_contains' => 'Not Contains', 'greater_than' => 'Greater Than', 'less_than' => 'Less Than', 'starts_with' => 'Starts With', 'not_starts_with' => 'Not Starts With', 'ends_with' => 'Ends With', 'not_ends_with' => 'Not Ends With'),
                    'title' => esc_html__('Evaluation Method', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => 'equals',
                    'description' => esc_html__('Select the method to evaluate the condition with the expected value.', 'aiomatic-automatic-ai-content-writer')
                ),
                'expected_value' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Expected Value', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the expected value of the condition', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the expected value which will be compared with the result of the condition.', 'aiomatic-automatic-ai-content-writer')
                ),
                'true_blocks' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Condition True Blocks', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('List of block IDs to execute if the condition is true', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the list of block IDs to execute if the condition is true, separated by commas.', 'aiomatic-automatic-ai-content-writer')
                ),
                'false_blocks' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Condition False Blocks', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('List of block IDs to execute if the condition is false', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the list of block IDs to execute if the condition is false, separated by commas.', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'jump_block' => [
            'id' => 'jump_block',
            'name' => esc_html__('Jump To OmniBlock ID', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Logic Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Jumps to a specific OmniBlock ID and continues execution of the OmniBlock queue from that specific location. You can also add a comma separated list of OmniBlock IDs, in this case, the plugin will select a random ID each time it executes the Jump OmniBlock.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array(),
            'parameters' => array(
                'jumpto' => array(
                    'type' => 'textarea',
                    'title' => esc_html__('Jump To OmniBlock ID', 'aiomatic-automatic-ai-content-writer'),
                    'default_value' => '',
                    'placeholder' => esc_html__('Set the ID of the OmniBlock where to jump', 'aiomatic-automatic-ai-content-writer'),
                    'description' => esc_html__('Set the ID of the OmniBlock where to jump', 'aiomatic-automatic-ai-content-writer')
                )
            )
        ],
        'exit_block' => [
            'id' => 'exit_block',
            'name' => esc_html__('Exit OmniBlock', 'aiomatic-automatic-ai-content-writer'),
            'category' => esc_html__(' - Logic Blocks', 'aiomatic-automatic-ai-content-writer'),
            'required_plugin' => array(),
            'description' => esc_html__('Finishes the execution queue of OmniBlocks. This block is useful when combined with an IF or a Jump OmniBlock type.', 'aiomatic-automatic-ai-content-writer'),
            'type' => 'create',
            'shortcodes' => array(),
            'parameters' => array(
            )
        ]
    ]);
    aiomatic_sort_by_category($all_blocks);
    return $all_blocks;
}
function aiomatic_sort_by_category(&$array) 
{
    uasort($array, function($a, $b) {
        return strcmp($a['category'], $b['category']);
    });
}
function aiomatic_add_block_types($block_types) 
{
    $block_types['send_email'] = [
        'id' => 'send_email',
        'name' => 'Send Email',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array(),
        'description' => esc_html__('Sends an email to your desired email address', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'email_title' => array(
                'type' => 'text',
                'title' => esc_html__('Email Subject', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the subject of the email to be sent', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the subject of the email to be sent. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'email_content' => array(
                'type' => 'textarea',
                'title' => esc_html__('Email Content', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the content of the email to be sent', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the content of the email to be sent. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'email_recipient' => array(
                'type' => 'text',
                'title' => esc_html__('Email Recipient Address', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the email address to which to send the email', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the email address to which to send the email. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['save_file'] = [
        'id' => 'save_file',
        'name' => 'Save To File',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array(),
        'description' => esc_html__('Save content to file', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('File Content Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main file content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main file content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'file_type' => array(
                'type' => 'file_type_selector',
                'title' => esc_html__('File Type', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Set the file type of the saved file.', 'aiomatic-automatic-ai-content-writer')
            ),
            'send_type' => array(
                'type' => 'location_selector',
                'title' => esc_html__('File Location', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Set the location of the saved file.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_facebook'] = [
        'id' => 'send_facebook',
        'name' => 'Send Text/Link To Facebook',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('fbomatic-facebook-post-generator/fbomatic-facebook-post-generator.php' => array('F-omatic Automatic Post Generator', 'https://1.envato.market/fbomatic')),
        'description' => esc_html__('Sends text/link posts to Facebook pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'page_to_post' => array(
                'type' => 'facebook_page_selector',
                'title' => esc_html__('Page Where to Publish Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the page associated with your App ID, where you want to publish your posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Facebook Post Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main Facebook post content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main Facebook post content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_link' => array(
                'type' => 'url',
                'title' => esc_html__('Facebook Post Link', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the link of the Facebook post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the link of the Facebook post. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_image_facebook'] = [
        'id' => 'send_image_facebook',
        'name' => 'Send Image To Facebook',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('fbomatic-facebook-post-generator/fbomatic-facebook-post-generator.php' => array('F-omatic Automatic Post Generator', 'https://1.envato.market/fbomatic')),
        'description' => esc_html__('Sends posts to Facebook pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'page_to_post' => array(
                'type' => 'facebook_page_selector',
                'title' => esc_html__('Page Where to Publish Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the page associated with your App ID, where you want to publish your posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'image_link' => array(
                'type' => 'url',
                'title' => esc_html__('Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the URL of the Facebook image post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the URL of the Facebook image post. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Image Caption', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the caption of the Facebook image', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the caption of the Facebook image. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_image_instagram'] = [
        'id' => 'send_image_instagram',
        'name' => 'Send Image To Instagram',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('instamatic-instagram-post-generator/instamatic-instagram-post-generator.php' => array('iMediamatic - Social Media Poster', 'https://1.envato.market/instamatic')),
        'description' => esc_html__('Sends posts to Instagram pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'image_link' => array(
                'type' => 'url',
                'title' => esc_html__('Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the URL of the Instagram image post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the URL of the Instagram image post. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Image Text', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the text of the Instagram image', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the text of the Instagram image. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_image_pinterest'] = [
        'id' => 'send_image_pinterest',
        'name' => 'Send Image To Pinterest',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('pinterestomatic-pinterest-post-generator/pinterestomatic-pinterest-post-generator.php' => array('Pinterestomatic - Social Media Poster', 'https://1.envato.market/pinterestomatic')),
        'description' => esc_html__('Sends pins to Pinterest boards', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'page_to_post' => array(
                'type' => 'pinterest_board_selector',
                'title' => esc_html__('Board Where to Publish Pins', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the board associated with your account, where you want to publish your pins.', 'aiomatic-automatic-ai-content-writer')
            ),
            'image_link' => array(
                'type' => 'url',
                'title' => esc_html__('Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the URL of the Pinterest image post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the URL of the Pinterest image post. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_title' => array(
                'type' => 'textarea',
                'title' => esc_html__('Pin Title', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the title of the Pinterest pin', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the title of the Pinterest pin. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Pin Description', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the description of the Pinterest pin', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the description of the Pinterest pin. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'pin_me' => array(
                'type' => 'url',
                'title' => esc_html__('Pin URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the URL of the Pinterest pin', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the URL of the Pinterest pin. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_twitter'] = [
        'id' => 'send_twitter',
        'name' => 'Send To X (Twitter)',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('twitomatic-twitter-post-generator/twitomatic-twitter-post-generator.php' => array('Twitomatic Automatic Post Generator', 'https://1.envato.market/twitomatic')),
        'description' => esc_html__('Sends posts to X (Twitter) pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('X (Twitter) Post Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main X (Twitter) post content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main X (Twitter) post content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'featured_image' => array(
                'type' => 'url',
                'title' => esc_html__('X (Twitter) Post Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the link of the X (Twitter) post image', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the link of the X (Twitter) post image. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_gmb'] = [
        'id' => 'send_gmb',
        'name' => 'Send To Google My Business',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('businessomatic-google-my-business-post-generator/businessomatic-google-my-business-post-generator.php' => array('Businessomatic Automatic Post Generator', 'https://1.envato.market/businessomatic')),
        'description' => esc_html__('Sends posts to Google My Business pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'page_to_post' => array(
                'type' => 'gpb_page_selector',
                'title' => esc_html__('Business Where to Publish Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the business associated with your account, where you want to publish your posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Google My Business Post Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main Google My Business post content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main Google My Business post content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'featured_image' => array(
                'type' => 'url',
                'title' => esc_html__('Google My Business Post Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the link of the Google My Business post image', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the link of the Google My Business post image. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_community_youtube'] = [
        'id' => 'send_community_youtube',
        'name' => 'Send To YouTube Community',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('youtubomatic-youtube-post-generator/youtubomatic-youtube-post-generator.php' => array('Youtubomatic Automatic Post Generator', 'https://1.envato.market/youtubomatic')),
        'description' => esc_html__('Sends posts to YouTube Community pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('YouTube Community Post Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main YouTube Community post content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main YouTube Community post content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'featured_image' => array(
                'type' => 'url',
                'title' => esc_html__('YouTube Community Post Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the link of the  post image', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the link of the YouTube Community post image. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'send_type' => array(
                'type' => 'yt_community_selector',
                'title' => esc_html__('YouTube Community Post Type', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Set the YouTube Community post type.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_reddit'] = [
        'id' => 'send_reddit',
        'name' => 'Send To Reddit',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('redditomatic-reddit-post-generator/redditomatic-reddit-post-generator.php' => array('Redditomatic Automatic Post Generator', 'https://1.envato.market/redditomatic')),
        'description' => esc_html__('Sends posts to Reddit subreddits', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'subreddit_to_post' => array(
                'type' => 'textarea',
                'title' => esc_html__('Subreddits Where To Publish Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the subreddits where to publish the content (comma separated list)', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the subreddits where to publish the content (comma separated list).', 'aiomatic-automatic-ai-content-writer')
            ),
            'title_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Reddit Post Title Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main Reddit post title', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main Reddit post title. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Reddit Post Content Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main Reddit post content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main Reddit post content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'send_type' => array(
                'type' => 'reddit_selector',
                'title' => esc_html__('Reddit Post Type', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Set the Reddit post type.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_linkedin'] = [
        'id' => 'send_linkedin',
        'name' => 'Send To LinkedIn',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array('linkedinomatic-linkedin-post-generator/linkedinomatic-linkedin-post-generator.php' => array('Linkedinomatic Auto Poster', 'https://1.envato.market/linkedinomatic')),
        'description' => esc_html__('Sends posts to LinkedIn pages', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'page_to_post' => array(
                'type' => 'linkedin_page_selector',
                'title' => esc_html__('Page Where to Publish Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the page associated with your App ID, where you want to publish your posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_title' => array(
                'type' => 'textarea',
                'title' => esc_html__('LinkedIn Post Title', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main LinkedIn post title', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main LinkedIn post title. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_link' => array(
                'type' => 'url',
                'title' => esc_html__('LinkedIn Post Link', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main LinkedIn post link', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main LinkedIn post link. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_description' => array(
                'type' => 'textarea',
                'title' => esc_html__('LinkedIn Post Description', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main LinkedIn post description', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main LinkedIn post description. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'attach_lnk' => array(
                'type' => 'checkbox',
                'title' => esc_html__('Attach Links To Created Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Set if you want to attach links to created LinkedIn posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('LinkedIn Post Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main LinkedIn post content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main LinkedIn post content. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'featured_image' => array(
                'type' => 'url',
                'title' => esc_html__('LinkedIn Post Image URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the link of the LinkedIn post image', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the link of the LinkedIn post image. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['send_webhook'] = [
        'id' => 'send_webhook',
        'name' => 'Send To A Webhook',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array(),
        'description' => esc_html__('Sends content to a webhook', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array(),
        'parameters' => array(
            'webhook_url' => array(
                'type' => 'url',
                'title' => esc_html__('Webhook URL', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the webhook URL where to submit the content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the webhook URL where to submit the content.', 'aiomatic-automatic-ai-content-writer')
            ),
            'webhook_method' => array(
                'type' => 'method_selector',
                'title' => esc_html__('Method Selector', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the request method you want to use, when sending the data to the webhook.', 'aiomatic-automatic-ai-content-writer')
            ),
            'content_type' => array(
                'type' => 'content_type_selector',
                'title' => esc_html__('Content Type', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the content type you want to send to the webhook. Possible values are JSON or Form Data.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Content Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the main webhook content', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the main webhook content. If you selected JSON type content, enter a valid JSON structure here. If you selected Form Data, enter the form data in this structure: key => value (add new key/value combinations on a new line). Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'headers_template' => array(
                'type' => 'textarea',
                'title' => esc_html__('Headers Template', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set content headers (optional)', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set any headers to send with the webhook request. Enter the headers in this structure: key => value (add new key/value combinations on a new line). Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['god_mode'] = [
        'id' => 'god_mode',
        'name' => 'Send To A God Mode Function',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array(),
        'description' => esc_html__('Sends content to a God Mode function, the AI can call any function from your WordPress site. Warning, this feature can be dangerous, use it only if you know what you are doing!', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array('god_mode_'),
        'parameters' => array(
            'prompt' => array(
                'type' => 'textarea',
                'title' => esc_html__('AI Prompt', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the AI prompt which will be sent to the God Mode parser', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the AI prompt which will be sent to the God Mode parser. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported. You should add here specific instructions on what feature of the God Mode (WordPress functions) should be called by the AI.', 'aiomatic-automatic-ai-content-writer')
            ),
            'assistant_id' => array(
                'type' => 'assistant_select',
                'title' => esc_html__('AI Assistant', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the AI Assistant to be used with the AI God Mode parser. If you select an assistant, a model cannot be selected any more, but instead, the model assigned to the assistant will be used. Also, the AI Assistant needs to have the God Mode function enabled in its settings.', 'aiomatic-automatic-ai-content-writer')
            ),
            'model' => array(
                'type' => 'model_select_function',
                'title' => esc_html__('AI Model', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select the model to be used with the AI God Mode parser. Only models which support function calling are listed here.', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    $block_types['save_post'] = [
        'id' => 'save_post',
        'name' => 'Save Post To WordPress',
        'category' => esc_html__(' - Content Saving Blocks', 'aiomatic-automatic-ai-content-writer'),
        'required_plugin' => array(),
        'description' => esc_html__('Saves the AI created data as a WordPress post', 'aiomatic-automatic-ai-content-writer'),
        'type' => 'save',
        'shortcodes' => array('created_post_id_', 'created_post_url_'),
        'parameters' => array(
            'post_title' => array(
                'type' => 'text',
                'title' => esc_html__('Post Title', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the title of the post to be created', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the title of the post to be created. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_content' => array(
                'type' => 'textarea',
                'title' => esc_html__('Post Content', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the content of the post to be created', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the content of the post to be created. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_excerpt' => array(
                'type' => 'textarea',
                'title' => esc_html__('Post Excerpt', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the excerpt of the post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the excerpt of the post to be created. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_slug' => array(
                'type' => 'text',
                'title' => esc_html__('Post Slug', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the slug of the post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the slug of the post (the post URL/name). If you leave this field blank, WordPress will automatically generate the slug of the post from the post tile. Any text that you enter here will be URL encoded, to be compatible with slug creation. The length of the slug should not exceed 200 characters.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_author' => array(
                'type' => 'number',
                'title' => esc_html__('Post Author ID', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '1',
                'placeholder' => esc_html__('Set the numeric ID of the author of the post', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Select the numeric ID of the author that you want to assign for the automatically generated posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_status' => array(
                'type' => 'status_selector',
                'title' => esc_html__('Post Status', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => 'publish',
                'description' => esc_html__('Select the status that you want for the automatically generated posts to have.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_type' => array(
                'type' => 'type_selector',
                'title' => esc_html__('Post Type', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => 'post',
                'description' => esc_html__('Select the type (post/page) for your automatically generated item.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_format' => array(
                'type' => 'format_selector',
                'title' => esc_html__('Post Format', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => 'post-format-standard',
                'description' => esc_html__('If your template supports \'Post Formats\', than you can select one here. If not, leave this at it\'s default value.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_parent' => array(
                'type' => 'number',
                'title' => esc_html__('Post Parent', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the ID of the parent of created posts', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the ID of the parent of created posts. This is useful for BBPress integration, to assign forum IDs for created topics or for other similar functionalities.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_comments' => array(
                'type' => 'checkbox',
                'title' => esc_html__('Enable Comments', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '1',
                'description' => esc_html__('Do you want to enable comments for the generated posts?', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_pingbacks' => array(
                'type' => 'checkbox',
                'title' => esc_html__('Enable Pingbacks/Trackbacks', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '1',
                'description' => esc_html__('Do you want to enable pingbacks/trackbacks for the generated posts?', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_date' => array(
                'type' => 'text',
                'title' => esc_html__('Post Date Range', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Do you want to set a custom post publish date for posts?', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Do you want to set a custom post publish date for posts? Set the range in the below field. You can set dates in the following format (a random date will be selected from the range): date1 ~ date2. If you don\'t use the ~ character, the date will be considered as a single date string.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_custom_fields' => array(
                'type' => 'textarea',
                'title' => esc_html__('Custom Fields', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_custom_taxonomies' => array(
                'type' => 'textarea',
                'title' => esc_html__('Custom Taxonomies', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B . You can also set hierarhical taxonomies (parent > child), in this format: custom_taxonomy_name => parent1 > child1 . ', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_lang' => array(
                'type' => 'text',
                'title' => esc_html__('WPML/Polylang Language', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('en', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Enter a 2 letter language code that will be assigned as the WPML/Polylang language for posts. Example: for German, input: de', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_categories' => array(
                'type' => 'text',
                'title' => esc_html__('Post Categories', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Category1, Category2, Category3', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Add a comma separated list of categories to set for posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_tags' => array(
                'type' => 'text',
                'title' => esc_html__('Post Tags', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Tag1, Tag2, Tag3', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Add a comma separated list of tags to set for posts.', 'aiomatic-automatic-ai-content-writer')
            ),
            'featured_image' => array(
                'type' => 'text',
                'title' => esc_html__('Featured Image', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Set the featured image of the post to be created', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Set the featured image of the post to be created. Additional shortcodes you can use: %%current_date_time%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%% + Spintax, Synergy shortcodes, [aicontent] shortcodes and WordPress shortcodes supported. You can also use the numeric IDs of Media Library attachments.', 'aiomatic-automatic-ai-content-writer')
            ),
            'content_regex' => array(
                'type' => 'textarea',
                'title' => esc_html__('Run Regex On Content', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Regex expression', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Run regex on post content. To disable this feature, leave this field blank. No Regex separators are required here. You can add multiple Regex expressions, each on a different line.', 'aiomatic-automatic-ai-content-writer')
            ),
            'replace_regex' => array(
                'type' => 'textarea',
                'title' => esc_html__('Replace Matches From Regex', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Regex replacement', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank. No Regex separators are required here. You can add multiple replacement expressions, each on a different line.', 'aiomatic-automatic-ai-content-writer')
            ),
            'overwrite_existing' => array(
                'type' => 'checkbox',
                'title' => esc_html__('Overwrite Existing Posts', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'description' => esc_html__('Select if you want to overwrite existing posts during the publishing process.', 'aiomatic-automatic-ai-content-writer')
            ),
            'post_id' => array(
                'type' => 'text',
                'title' => esc_html__('Post ID (Optional)', 'aiomatic-automatic-ai-content-writer'),
                'default_value' => '',
                'placeholder' => esc_html__('Update an existing post ID (optional)', 'aiomatic-automatic-ai-content-writer'),
                'description' => esc_html__('Update an existing post ID (optional)', 'aiomatic-automatic-ai-content-writer')
            )
        )
    ];
    return $block_types;
}
add_filter('aiomniblocks_block_types', 'aiomatic_add_block_types');
function aiomatic_omniblocks_default_cards() 
{
    $def = get_option('aiomatic_dafault_omni_template', false);
    if(!empty($def))
    {
        $aiomatic_theme = get_post(sanitize_text_field($def));
        if($aiomatic_theme !== null && $aiomatic_theme !== 0)
        {
            $default_json = json_decode($aiomatic_theme->post_content, true);
            if(!empty($default_json))
            {
                return apply_filters('aiomniblocks_block_defaults', $default_json);
            }
        }
    }
    return apply_filters('aiomniblocks_block_defaults', [
        [
            'identifier' => '1',
            'name' => 'Create a post title for a keyword',
            'type' => 'ai_text',
            'parameters' => array(
                'prompt' => 'Craft an attention-grabbing and SEO-optimized article title on the topic of "%%keyword%%". This title must be concise, informative, and designed to pique the interest of readers while clearly conveying the topic of the article.',
                'model' => 'gpt-3.5-turbo',
                'assistant_id' => '',
                'critical' => '0'
            )
        ],
        [
            'identifier' => '2',
            'name' => 'Create an article about a keyword',
            'type' => 'ai_text',
            'parameters' => array(
                'prompt' => 'Write a comprehensive and SEO-optimized article on the topic of "%%keyword%%". Incorporate relevant keywords naturally throughout the article to enhance search engine visibility. This article must provide valuable information to readers and be well-structured with proper headings, bullet points, and HTML formatting. If needed, you can use WordPress related CSS styling for the article. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). If added, table data must be relevant, creative, short and simple. Add an introductory and a conclusion section to the article. You can add also some other sections, when they fit the article\'s subject, like: benefits and practical tips, case studies, first had experience.Please ensure that the article is at least 1200 words in length and adheres to best SEO practices, including proper header tags (H1, H2, H3), meta title, and meta description.Feel free to use a friendly, conversational tone and make the article as informative and engaging as possible while ensuring it remains factually accurate and well-researched.',
                'model' => 'gpt-3.5-turbo',
                'assistant_id' => '',
                'critical' => '0'
            )
        ],
        [
            'identifier' => '3',
            'name' => 'Generate featured image',
            'type' => 'dalle_ai_image',
            'parameters' => array(
                'prompt' => 'Generate a high-resolution, visually compelling image that creatively interprets the theme encapsulated by this keyword: "%%keyword%%". The image should be versatile enough to fit various niches, from technology and lifestyle to nature and science. It should feature a central, eye-catching element that abstractly represents the topic, surrounded by relevant, subtler motifs that provide context and depth. The composition should be balanced and aesthetically pleasing, with a harmonious color palette that complements the mood of the title. The artwork should be suitable for use as a captivating header image for a blog post.',
                'model' => 'dalle3',
                'image_size' => '1024x1024',
                'critical' => '0'
            )
        ],
        [
            'identifier' => '4',
            'name' => 'Publish post',
            'type' => 'save_post',
            'parameters' => array(
                'post_title' => '%%ai_text_1%%',
                'post_content' => '%%ai_text_2%%',
                'featured_image' => '%%dalle_image_3%%',
                'critical' => '0'
            )
        ]
    ]);
}
?>