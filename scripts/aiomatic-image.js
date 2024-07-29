"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'aiomatic-automatic-ai-content-writer/aiomatic-image', {
    title: 'AIomatic AI Image',
    icon: 'text',
    category: 'embed',
    attributes: {
        seed_expre : {
            default: '',
            type:   'string',
        },
        image_size : {
            default: '256x256',
            type:   'string',
        },
        copy_locally : {
            default: 'off',
            type:   'string',
        },
        cache_seconds : {
            default: '2592000',
            type:   'string',
        },
        image_model : {
            default: 'dalle2',
            type:   'string',
        }
    },
    keywords: ['list', 'posts', 'aiomatic'],
    edit: (function( props ) {
        var seed_expre = props.attributes.seed_expre;
        var image_size = props.attributes.image_size;
        var cache_seconds = props.attributes.cache_seconds;
        var copy_locally = props.attributes.copy_locally;
        var image_model = props.attributes.image_model;
        function updateMessage2( event ) {
            props.setAttributes( { seed_expre: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { image_size: event.target.value} );
		}
        function updateMessage4( event ) {
            props.setAttributes( { cache_seconds: event.target.value} );
		}
        function updateMessage5( event ) {
            props.setAttributes( { copy_locally: event.target.value} );
		}
        function updateMessage6( event ) {
            props.setAttributes( { image_model: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'AIomatic GPT-3 Image ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to generate images.'
                    )
                )
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Seed Expression: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set a seed expression for the image. You can also use the following shortcodes: %%post_title%%, %%post_content%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%. You can also use custom fields (post meta) that it\'s assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command. If you leave this blank, the plugin will automatically use the content, excerpt or title of the post where this block is added.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Short introduction of the image', value: seed_expre, onChange: updateMessage2, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Image Size: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the generated image size.'
                )
            ),
            gcel(
				'select',
				{ value: image_size, onChange: updateMessage3, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: '256x256'},
                    '256x256 (only for Dall-E 2)'
                ), 
                gcel(
                    'option',
                    { value: '512x512'},
                    '512x512 (only for Dall-E 2)'
                ), 
                gcel(
                    'option',
                    { value: '1024x1024'},
                    '1024x1024'
                ), 
                gcel(
                    'option',
                    { value: '1024x1792'},
                    '1024x1792 (only for Dall-E 3)'
                ), 
                gcel(
                    'option',
                    { value: '1792x1024'},
                    '1792x1024 (only for Dall-E 3)'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Image Model: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the image model to use. Note that for Dall-E 3 models, only the 1024x1024 or larger image sizes are supported, while for the Dall-E 2 model, 1024x1024 or smaller sizes are supported.'
                )
            ),
            gcel(
				'select',
				{ value: image_model, onChange: updateMessage6, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'dalle2'},
                    'Dall-E 2'
                ), 
                gcel(
                    'option',
                    { value: 'dalle3'},
                    'Dall-E 3'
                ), 
                gcel(
                    'option',
                    { value: 'dalle3hd'},
                    'Dall-E 3 HD'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Copy Locally: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Do you want to copy the image locally?'
                )
            ),
            gcel(
				'select',
				{ value: copy_locally, onChange: updateMessage5, className: 'coderevolution_gutenberg_select' }, 
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
				{ type:'number',min:0,placeholder:'Caching period in seconds', value: cache_seconds, onChange: updateMessage4, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );