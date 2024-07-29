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
registerBlockType( 'aiomatic-automatic-ai-content-writer/aiomatic-completion', {
    title: 'AIomatic Text Completion Form',
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
        presence_penalty : {
            default: 'default',
            type:   'string',
        },
        frequency_penalty : {
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
        },
        assistant_id : {
            default: '',
            type:   'string',
        }
    },
    keywords: ['list', 'posts', 'aiomatic'],
    edit: (function( props ) {
        var temperature = props.attributes.temperature;
        var top_p = props.attributes.top_p;
        var presence_penalty = props.attributes.presence_penalty;
        var frequency_penalty = props.attributes.frequency_penalty;
        var model = props.attributes.model;
        var user_token_cap_per_day = props.attributes.user_token_cap_per_day;
        var prompt_templates = props.attributes.prompt_templates;
        var prompt_editable = props.attributes.prompt_editable;
        var assistant_id = props.attributes.assistant_id;
        function updateMessage( event ) {
            props.setAttributes( { temperature: event.target.value} );
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
            props.setAttributes( { model: event.target.value} );
		}
        function updateMessage7( event ) {
            props.setAttributes( { user_token_cap_per_day: event.target.value} );
		}
        function updateMessage8( event ) {
            props.setAttributes( { prompt_templates: event.target.value} );
		}
        function updateMessage9( event ) {
            props.setAttributes( { prompt_editable: event.target.value} );
		}
        function updateMessage10( event ) {
            props.setAttributes( { assistant_id: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'AIomatic Text Completion Form ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to generate AI text completion.'
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
				{ type:'number',min:-2,max:2,step:0.1,placeholder:'AI Frequency Penalty', value: frequency_penalty, onChange: updateMessage5, className: 'coderevolution_gutenberg_input' }
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
				{ type:'text',placeholder:'Assistant ID', value: assistant_id, onChange: updateMessage10, className: 'coderevolution_gutenberg_input' }
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
				{ value: model, onChange: updateMessage6, className: 'coderevolution_gutenberg_select', dangerouslySetInnerHTML: {
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
				{ type:'number',min:0,placeholder:'Daily token count for users', value: user_token_cap_per_day, onChange: updateMessage7, className: 'coderevolution_gutenberg_input' }
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