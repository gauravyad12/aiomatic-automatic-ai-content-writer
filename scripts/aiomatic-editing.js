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
registerBlockType( 'aiomatic-automatic-ai-content-writer/aiomatic-editing', {
    title: 'AIomatic Text Editing Form',
    icon: 'text',
    category: 'embed',
    attributes: {
        temperature : {
            default: 'default',
            type:   'string',
        },
        top_p : {
            default: 'default',
            type:   'string',
        },
        model : {
            default: 'default',
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
        var temperature = props.attributes.temperature;
        var top_p = props.attributes.top_p;
        var model = props.attributes.model;
        var user_token_cap_per_day = props.attributes.user_token_cap_per_day;
        var prompt_templates = props.attributes.prompt_templates;
        var prompt_editable = props.attributes.prompt_editable;
        function updateMessage( event ) {
            props.setAttributes( { temperature: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { top_p: event.target.value} );
		}
        function updateMessage4( event ) {
            props.setAttributes( { model: event.target.value} );
		}
        function updateMessage6( event ) {
            props.setAttributes( { user_token_cap_per_day: event.target.value} );
		}
        function updateMessage8( event ) {
            props.setAttributes( { prompt_templates: event.target.value} );
		}
        function updateMessage9( event ) {
            props.setAttributes( { prompt_editable: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'AIomatic Text Editing Form ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used for AI text editing.'
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
				{ type:'number', min:0,max:1,step:0.1,placeholder:'AI Top_p', value: top_p, onChange: updateMessage3, className: 'coderevolution_gutenberg_input' }
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
				{ value: model, onChange: updateMessage4, className: 'coderevolution_gutenberg_select', dangerouslySetInnerHTML: {
                    __html: editing_options
                } }                
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
				{ type:'text',placeholder:'Template1;Template2;Template3', value: prompt_templates, onChange: updateMessage8, className: 'coderevolution_gutenberg_input' }
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
				{ value: prompt_editable, onChange: updateMessage9, className: 'coderevolution_gutenberg_select' },
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