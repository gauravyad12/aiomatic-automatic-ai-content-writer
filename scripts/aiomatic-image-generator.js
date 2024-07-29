"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'aiomatic-automatic-ai-content-writer/aiomatic-image-generator', {
    title: 'AIomatic Image Generator Form',
    icon: 'text',
    category: 'embed',
    attributes: {
        image_size : {
            default: '1024x1024',
            type:   'string',
        },
        image_model : {
            default: 'dalle2',
            type:   'string',
        },
        user_token_cap_per_day : {
            default: '',
            type:   'string',
        },
        prompt_templates : {
            default: '',
            type:   'string',
        },
        prompt_editable : {
            default: '',
            type:   'string',
        }
    },
    keywords: ['list', 'posts', 'aiomatic'],
    edit: (function( props ) {
        var image_size = props.attributes.image_size;
        var user_token_cap_per_day = props.attributes.user_token_cap_per_day;
        var prompt_templates = props.attributes.prompt_templates;
        var prompt_editable = props.attributes.prompt_editable;
        var image_model = props.attributes.image_model;
        function updateMessage( event ) {
            props.setAttributes( { image_size: event.target.value} );
		}
        function updateMessage6( event ) {
            props.setAttributes( { user_token_cap_per_day: event.target.value} );
		}
        function updateMessage7( event ) {
            props.setAttributes( { prompt_templates: event.target.value} );
		}
        function updateMessage8( event ) {
            props.setAttributes( { prompt_editable: event.target.value} );
		}
        function updateMessage9( event ) {
            props.setAttributes( { image_model: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'AIomatic GPT-3 Image Generator Form ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to generate AI images.'
                    )
                )
			),
            gcel(
				'br'
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
                    'Select the image size for AI generated images.'
                )
            ),
            gcel(
				'select',
				{ value: image_size, onChange: updateMessage, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'default'},
                    'default'
                ), 
                gcel(
                    'option',
                    { value: '1024x1024'},
                    '1024x1024'
                ), 
                gcel(
                    'option',
                    { value: '512x512'},
                    '512x512 (only for Dall-E 2)'
                ), 
                gcel(
                    'option',
                    { value: '256x256'},
                    '256x256 (only for Dall-E 2)'
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
				{ value: image_model, onChange: updateMessage9, className: 'coderevolution_gutenberg_select' }, 
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
                'Daily Token Count for Logged In Users: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the daily token count for logged in users. Users who are not logged in will not be allowed to submit the form. To disable this feature, leave this field blank.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Daily token count for users', value: user_token_cap_per_day, onChange: updateMessage6, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Prompt Templates (Semicolon Separated): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Add a semicolon (;) separated list of prompt templates from which the users will be able to select and submit one.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Template1;Template2;Template3', value: prompt_templates, onChange: updateMessage7, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Prompt Editable: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select wheather the prompt will be editable by users. This is useful when combined with prompt templates from above, when you don\'t want the users to edit the entered template.'
                )
            ),
            gcel(
				'select',
				{ value: prompt_editable, onChange: updateMessage8, className: 'coderevolution_gutenberg_select' },
                gcel(
                    'option',
                    { value: 'yes'},
                    'yes'
                ), 
                gcel(
                    'option',
                    { value: 'no'},
                    'no'
                )
            ),
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );