"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;
var editing_options = '';
if (Array.isArray(aiomatic_object.models)) {
    aiomatic_object.models.forEach(element => {
        editing_options += '<option value="' + element + '">' + element + '</option>';
    });
} else if (typeof aiomatic_object.models === 'object' && aiomatic_object.models !== null) 
{
    Object.entries(aiomatic_object.models).forEach(([key, value]) => {
        editing_options += '<option value="' + key + '">' + value + '</option>';
    });
}
registerBlockType( 'aiomatic-automatic-ai-content-writer/aiomatic-article', {
    title: 'AIomatic Article',
    icon: 'text',
    category: 'embed',
    attributes: {
        seed_expre : {
            default: '',
            type:   'string',
        },
        temperature : {
            default: '1',
            type:   'string',
        },
        top_p : {
            default: '1',
            type:   'string',
        },
        presence_penalty : {
            default: '0',
            type:   'string',
        },
        frequency_penalty : {
            default: '0',
            type:   'string',
        },
        min_char : {
            default: '0',
            type:   'string',
        },
        max_tokens : {
            default: '2048',
            type:   'string',
        },
        max_seed_tokens : {
            default: '500',
            type:   'string',
        },
        max_continue_tokens : {
            default: '500',
            type:   'string',
        },
        model : {
            default: 'gpt-3.5-turbo-instruct',
            type:   'string',
        },
        assistant_id : {
            default: '',
            type:   'string',
        },
        headings_model : {
            default: 'gpt-3.5-turbo-instruct',
            type:   'string',
        },
        headings : {
            default: '',
            type:   'string',
        },
        images : {
            default: '',
            type:   'string',
        },
        videos : {
            default: '',
            type:   'string',
        },
        cache_seconds : {
            default: '2592000',
            type:   'string',
        },
        no_internet : {
            default: '0',
            type:   'string',
        },
        headings_ai_command : {
            default: 'Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%',
            type:   'string',
        }
    },
    keywords: ['list', 'posts', 'aiomatic'],
    edit: (function( props ) {
        var seed_expre = props.attributes.seed_expre;
        var temperature = props.attributes.temperature;
        var top_p = props.attributes.top_p;
        var presence_penalty = props.attributes.presence_penalty;
        var frequency_penalty = props.attributes.frequency_penalty;
        var min_char = props.attributes.min_char;
        var max_tokens = props.attributes.max_tokens;
        var max_seed_tokens = props.attributes.max_seed_tokens;
        var max_continue_tokens = props.attributes.max_continue_tokens;
        var model = props.attributes.model;
        var headings_model = props.attributes.headings_model;
        var headings = props.attributes.headings;
        var images = props.attributes.images;
        var videos = props.attributes.videos;
        var cache_seconds = props.attributes.cache_seconds;
        var no_internet = props.attributes.no_internet;
        var headings_ai_command = props.attributes.headings_ai_command;
        var assistant_id = props.attributes.assistant_id;
        function updateMessage( event ) {
            props.setAttributes( { temperature: event.target.value} );
		}
        function updateMessage2( event ) {
            props.setAttributes( { seed_expre: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { top_p: event.target.value} );
		}
        function updateMessage4( event ) {
            props.setAttributes( { presence_penalty: event.target.value} );
		}
        function updateMessage5( event ) {
            props.setAttributes( { frequency_penalty: event.target.value} );
		}
        function updateMessage6( event ) {
            props.setAttributes( { min_char: event.target.value} );
		}
        function updateMessage7( event ) {
            props.setAttributes( { max_tokens: event.target.value} );
		}
        function updateMessage8( event ) {
            props.setAttributes( { max_seed_tokens: event.target.value} );
		}
        function updateMessage9( event ) {
            props.setAttributes( { max_continue_tokens: event.target.value} );
		}
        function updateMessage10( event ) {
            props.setAttributes( { model: event.target.value} );
		}
        function updateMessage11( event ) {
            props.setAttributes( { headings: event.target.value} );
		}
        function updateMessage12( event ) {
            props.setAttributes( { images: event.target.value} );
		}
        function updateMessage13( event ) {
            props.setAttributes( { videos: event.target.value} );
		}
        function updateMessage14( event ) {
            props.setAttributes( { cache_seconds: event.target.value} );
		}
        function updateMessage15( event ) {
            props.setAttributes( { headings_model: event.target.value} );
		}
        function updateMessage16( event ) {
            props.setAttributes( { headings_ai_command: event.target.value} );
		}
        function updateMessage17( event ) {
            props.setAttributes( { no_internet: event.target.value} );
		}
        function updateMessage18( event ) {
            props.setAttributes( { assistant_id: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'AIomatic Article ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to generate AI written articles.'
                    )
                )
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Prompt Expression: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set a prompt expression for the article. You can also use the following shortcodes: %%post_title%%, %%post_content%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it\'s assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the prompt command. If you leave this blank, the plugin will automatically use the content, excerpt or title of the post where this block is added.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Short introduction of the article', value: seed_expre, onChange: updateMessage2, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'AI Temperature: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'What sampling temperature to use. Higher values means the model will take more risks. Try 0.9 for more creative applications, and 0 (argmax sampling) for ones with a well-defined answer. We generally recommend altering this or top_p but not both.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,step:0.1,placeholder:'AI Temperature', value: temperature, onChange: updateMessage, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'AI Top_p: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered. We generally recommend altering this or temperature but not both.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,max:1,step:0.1,placeholder:'AI Top_p', value: top_p, onChange: updateMessage3, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'AI Presence Penalty: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model\'s likelihood to talk about new topics.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:-2,max:2,step:0.1,placeholder:'AI Presence Penalty', value: presence_penalty, onChange: updateMessage4, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'AI Frequency Penalty: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model\'s likelihood to repeat the same line verbatim.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:-2,max:2,spte:0.1,placeholder:'AI Frequency Penalty', value: frequency_penalty, onChange: updateMessage5, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Minimum Character Count To Be Added: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the minimum character count to be added. If the API is not returning this amount of characters in a single call, the plugin will call the API multiple times.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Minimum Character Count', value: min_char, onChange: updateMessage6, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Maximum Tokens To Spend On A Single API Call: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum number of tokens to spend on a single API call.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Max Token Count', value: max_tokens, onChange: updateMessage7, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Maximum Prompt Token Count: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the minimum character count to be added. If the API is not returning this amount of characters in a single call, the plugin will call the API multiple times.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Maximum Prompt Token Count', value: max_seed_tokens, onChange: updateMessage8, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Maximum Continue Call Token Count: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum number of tokens to use for generating content on subsequent API calls (if the character count was not met in the first API request).'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Maximum Continue Call Token Count', value: max_continue_tokens, onChange: updateMessage9, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Assistant ID: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the assistant you want to use for this chatbot. This will disable the model you select and use the model set in the assistant settings. This needs to be the numeric ID of the Assistant Post type you created in the plugin.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Assistant ID', value: assistant_id, onChange: updateMessage18, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Model: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the AI model you want to use to generate the content.'
                )
            ),
            gcel(
				'select',
				{ value: model, onChange: updateMessage10, className: 'coderevolution_gutenberg_select', dangerouslySetInnerHTML: {
                    __html: editing_options
                } }
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Maximum Number Of Related Headings to Add To The Content: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum number of related headings to add to the created post content. This feature will use the \'People Also Ask\' feature from Google and Bing. By default, the Bing engine is scraped, if you want to enable also Google scraping, add a SerpAPI key in the plugin\'s \'Settings\' menu -> \'SerpAPI API Key\' settings field.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Maximum number of related headings', value: headings, onChange: updateMessage11, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Headings Model: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the AI model you want to use to generate the additional headings for the content.'
                )
            ),
            gcel(
				'select',
				{ value: headings_model, onChange: updateMessage15, className: 'coderevolution_gutenberg_select', dangerouslySetInnerHTML: {
                    __html: editing_options
                } }
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Headings Prompt Expression: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set a prompt expression for the AI headings generator. You can also use the following shortcodes: %%post_title%%, %%needed_heading_count%%. The same model will be used, as the one selected for content creation. If you leave this field blank, the default prompt will be used: "Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%"'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Write %%needed_heading_count%% PAA related questions, each on a new line, for the title: %%post_title%%', value: headings_ai_command, onChange: updateMessage16, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Maximum Number Of Related Images to Add To The Content: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the maximum number of related images to add to the created post content. This feature will use the \'Royalty Free Image\' settings from the plugin\'s \'Settings\' menu.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Maximum number of related images', value: images, onChange: updateMessage12, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Add A Related Video To The End Of The Content: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Add a related YouTube video to the end of to the created post content. This feature will require you to add at least one YouTube API key in the plugin\'s \'Settings\' -> \'YouTube API Key List\' settings field.'
                )
            ),
            gcel(
				'select',
				{ value: videos, onChange: updateMessage13, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'off'},
                    'off'
                ), 
                gcel(
                    'option',
                    { value: 'on'},
                    'on'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Caching Period For AI Generated Content (Seconds): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the caching period for AI generated content in seconds.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Caching period in seconds', value: cache_seconds, onChange: updateMessage14, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Disable AI Internet Access: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Do you want to disable AI internet access for this shortcode?'
                )
            ),
            gcel(
				'select',
				{ value: no_internet, onChange: updateMessage17, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: '0'},
                    '0'
                ), 
                gcel(
                    'option',
                    { value: '1'},
                    '1'
                )
            )
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );