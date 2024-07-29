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
registerBlockType( 'aiomatic-automatic-ai-content-writer/aiomatic-chat', {
    title: 'AIomatic Chat Form',
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
        enable_vision : {
            default: 'default',
            type:   'string',
        },
        instant_response : {
            default: 'false',
            type:   'string',
        },
        chat_preppend_text : {
            default: '',
            type:   'string',
        },
        user_message_preppend : {
            default: '',
            type:   'string',
        },
        ai_message_preppend : {
            default: '',
            type:   'string',
        },
        ai_first_message : {
            default: '',
            type:   'string',
        },
        chat_mode : {
            default: '',
            type:   'string',
        },
        user_token_cap_per_day : {
            default: '',
            type:   'string',
        },
        persistent : {
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
        placeholder : {
            default: '',
            type:   'string',
        },
        submit : {
            default: '',
            type:   'string',
        },
        select_prompt : {
            default: '',
            type:   'string',
        },
        show_in_window : {
            default: '',
            type:   'string',
        },
        window_location : {
            default: '',
            type:   'string',
        },
        font_size : {
            default: '1em',
            type:   'string',
        },
        height : {
            default: '100%',
            type:   'string',
        },
        background : {
            default: 'auto',
            type:   'string',
        },
        minheight : {
            default: '250px',
            type:   'string',
        },
        user_font_color : {
            default: '#ffffff',
            type:   'string',
        },
        user_background_color : {
            default: '#0084ff',
            type:   'string',
        },
        ai_font_color : {
            default: '#000000',
            type:   'string',
        },
        ai_background_color : {
            default: '#f0f0f0',
            type:   'string',
        },
        input_border_color : {
            default: '#e1e3e6',
            type:   'string',
        },
        input_text_color : {
            default: '#000000',
            type:   'string',
        },
        persona_name_color : {
            default: '#3c434a',
            type:   'string',
        },
        persona_role_color : {
            default: '#728096',
            type:   'string',
        },
        input_placeholder_color : {
            default: '#333333',
            type:   'string',
        },
        submit_color : {
            default: '#55a7e2',
            type:   'string',
        },
        voice_color : {
            default: '#55a7e2',
            type:   'string',
        },
        voice_color_activated : {
            default: '#55a7e2',
            type:   'string',
        },
        submit_text_color : {
            default: '#ffffff',
            type:   'string',
        },
        width : {
            default: '100%',
            type:   'string',
        },
        ai_avatar : {
            default: '',
            type:   'string',
        },
        ai_role : {
            default: '100%',
            type:   'string',
        },
        general_background : {
            default: '#ffffff',
            type:   'string',
        },
        show_dltxt : {
            default: 'show',
            type:   'string',
        },
        internet_access : {
            default: 'show',
            type:   'string',
        },
        embeddings : {
            default: 'show',
            type:   'string',
        },
        show_mute : {
            default: 'show',
            type:   'string',
        },
        show_internet : {
            default: 'show',
            type:   'string',
        },
        show_clear : {
            default: 'show',
            type:   'string',
        },
        overwrite_voice : {
            default: '',
            type:   'string',
        },
        overwrite_avatar_image : {
            default: '',
            type:   'string',
        },
        compliance : {
            default: '',
            type:   'string',
        },
        chatbot_text_speech : {
            default: '',
            type:   'string',
        },
        upload_pdf : {
            default: '',
            type:   'string',
        },
        file_uploads : {
            default: '',
            type:   'string',
        },
        custom_header : {
            default: '',
            type:   'string',
        },
        custom_footer : {
            default: '',
            type:   'string',
        },
        custom_css : {
            default: '',
            type:   'string',
        },
        enable_god_mode : {
            default: '',
            type:   'string',
        },
        assistant_id : {
            default: '',
            type:   'string',
        },
        disable_streaming : {
            default: '',
            type:   'string',
        },
        send_message_sound : {
            default: '',
            type:   'string',
        },
        receive_message_sound : {
            default: '',
            type:   'string',
        },
        response_delay : {
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
        var enable_vision = props.attributes.enable_vision;
        var instant_response = props.attributes.instant_response;
        var chat_preppend_text = props.attributes.chat_preppend_text;
        var user_message_preppend = props.attributes.user_message_preppend;
        var ai_message_preppend = props.attributes.ai_message_preppend;
        var ai_first_message = props.attributes.ai_first_message;
        var chat_mode = props.attributes.chat_mode;
        var user_token_cap_per_day = props.attributes.user_token_cap_per_day;
        var persistent = props.attributes.persistent;
        var prompt_templates = props.attributes.prompt_templates;
        var prompt_editable = props.attributes.prompt_editable;
        var placeholder = props.attributes.placeholder;
        var submit = props.attributes.submit;
        var select_prompt = props.attributes.select_prompt;
        var show_in_window = props.attributes.show_in_window;
        var window_location = props.attributes.window_location;
        var font_size = props.attributes.font_size;
        var height = props.attributes.height;
        var background = props.attributes.background;
        var minheight = props.attributes.minheight;
        var user_font_color = props.attributes.user_font_color;
        var user_background_color = props.attributes.user_background_color;
        var ai_font_color = props.attributes.ai_font_color;
        var ai_background_color = props.attributes.ai_background_color;
        var input_border_color = props.attributes.input_border_color;
        var input_text_color = props.attributes.input_text_color;
        var persona_name_color = props.attributes.persona_name_color;
        var persona_role_color = props.attributes.persona_role_color;
        var input_placeholder_color = props.attributes.input_placeholder_color;
        var submit_color = props.attributes.submit_color;
        var voice_color = props.attributes.voice_color;
        var voice_color_activated = props.attributes.voice_color_activated;
        var submit_text_color = props.attributes.submit_text_color;
        var width = props.attributes.width;
        var ai_avatar = props.attributes.ai_avatar;
        var ai_role = props.attributes.ai_role;
        var general_background = props.attributes.general_background;
        var compliance = props.attributes.compliance;
        var chatbot_text_speech = props.attributes.chatbot_text_speech;
        var upload_pdf = props.attributes.upload_pdf;
        var file_uploads = props.attributes.file_uploads;
        var custom_header = props.attributes.custom_header;
        var custom_footer = props.attributes.custom_footer;
        var custom_css = props.attributes.custom_css;
        var enable_god_mode = props.attributes.enable_god_mode;
        var assistant_id = props.attributes.assistant_id;
        var disable_streaming = props.attributes.disable_streaming;
        var show_dltxt = props.attributes.show_dltxt;
        var internet_access = props.attributes.internet_access;
        var embeddings = props.attributes.embeddings;
        var show_mute = props.attributes.show_mute;
        var show_internet = props.attributes.show_internet;
        var show_clear = props.attributes.show_clear;
        var overwrite_voice = props.attributes.overwrite_voice;
        var overwrite_avatar_image = props.attributes.overwrite_avatar_image;
        var send_message_sound = props.attributes.send_message_sound;
        var receive_message_sound = props.attributes.receive_message_sound;
        var response_delay = props.attributes.response_delay;
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
            props.setAttributes( { instant_response: event.target.value} );
		}
        function updateMessage8( event ) {
            props.setAttributes( { chat_preppend_text: event.target.value} );
		}
        function updateMessage9( event ) {
            props.setAttributes( { user_message_preppend: event.target.value} );
		}
        function updateMessage10( event ) {
            props.setAttributes( { ai_message_preppend: event.target.value} );
		}
        function updateMessage11( event ) {
            props.setAttributes( { ai_first_message: event.target.value} );
		}
        function updateMessage12( event ) {
            props.setAttributes( { chat_mode: event.target.value} );
		}
        function updateMessage13( event ) {
            props.setAttributes( { user_token_cap_per_day: event.target.value} );
		}
        function updateMessage14( event ) {
            props.setAttributes( { persistent: event.target.value} );
		}
        function updateMessage15( event ) {
            props.setAttributes( { prompt_templates: event.target.value} );
		}
        function updateMessage16( event ) {
            props.setAttributes( { prompt_editable: event.target.value} );
		}
        function updateMessage17( event ) {
            props.setAttributes( { placeholder: event.target.value} );
		}
        function updateMessage18( event ) {
            props.setAttributes( { submit: event.target.value} );
		}
        function updateMessage19( event ) {
            props.setAttributes( { show_in_window: event.target.value} );
		}
        function updateMessage20( event ) {
            props.setAttributes( { window_location: event.target.value} );
		}
        function updateMessage21( event ) {
            props.setAttributes( { font_size: event.target.value} );
		}
        function updateMessage22( event ) {
            props.setAttributes( { height: event.target.value} );
		}
        function updateMessage23( event ) {
            props.setAttributes( { background: event.target.value} );
		}
        function updateMessage24( event ) {
            props.setAttributes( { minheight: event.target.value} );
		}
        function updateMessage25( event ) {
            props.setAttributes( { user_font_color: event.target.value} );
		}
        function updateMessage26( event ) {
            props.setAttributes( { user_background_color: event.target.value} );
		}
        function updateMessage27( event ) {
            props.setAttributes( { ai_font_color: event.target.value} );
		}
        function updateMessage28( event ) {
            props.setAttributes( { ai_background_color: event.target.value} );
		}
        function updateMessage29( event ) {
            props.setAttributes( { input_border_color: event.target.value} );
		}
        function updateMessage30( event ) {
            props.setAttributes( { submit_color: event.target.value} );
		}
        function updateMessage50( event ) {
            props.setAttributes( { voice_color: event.target.value} );
		}
        function updateMessage52( event ) {
            props.setAttributes( { voice_color_activated: event.target.value} );
		}
        function updateMessage31( event ) {
            props.setAttributes( { submit_text_color: event.target.value} );
		}
        function updateMessage32( event ) {
            props.setAttributes( { width: event.target.value} );
		}
        function updateMessage33( event ) {
            props.setAttributes( { ai_avatar: event.target.value} );
		}
        function updateMessage34( event ) {
            props.setAttributes( { ai_role: event.target.value} );
		}
        function updateMessage35( event ) {
            props.setAttributes( { general_background: event.target.value} );
		}
        function updateMessage36( event ) {
            props.setAttributes( { compliance: event.target.value} );
		}
        function updateMessage37( event ) {
            props.setAttributes( { input_text_color: event.target.value} );
		}
        function updateMessage38( event ) {
            props.setAttributes( { input_placeholder_color: event.target.value} );
		}
        function updateMessage39( event ) {
            props.setAttributes( { persona_name_color: event.target.value} );
		}
        function updateMessage40( event ) {
            props.setAttributes( { persona_role_color: event.target.value} );
		}
        function updateMessage41( event ) {
            props.setAttributes( { show_dltxt: event.target.value} );
		}
        function updateMessage54( event ) {
            props.setAttributes( { show_mute: event.target.value} );
		}
        function updateMessage57( event ) {
            props.setAttributes( { show_internet: event.target.value} );
		}
        function updateMessage42( event ) {
            props.setAttributes( { show_clear: event.target.value} );
		}
        function updateMessage43( event ) {
            props.setAttributes( { enable_vision: event.target.value} );
		}
        function updateMessage44( event ) {
            props.setAttributes( { assistant_id: event.target.value} );
		}
        function updateMessage45( event ) {
            props.setAttributes( { overwrite_voice: event.target.value} );
		}
        function updateMessage47( event ) {
            props.setAttributes( { overwrite_avatar_image: event.target.value} );
		}
        function updateMessage46( event ) {
            props.setAttributes( { select_prompt: event.target.value} );
		}
        function updateMessage48( event ) {
            props.setAttributes( { disable_streaming: event.target.value} );
		}
        function updateMessage49( event ) {
            props.setAttributes( { chatbot_text_speech: event.target.value} );
		}
        function updateMessage51( event ) {
            props.setAttributes( { enable_god_mode: event.target.value} );
		}
        function updateMessage55( event ) {
            props.setAttributes( { internet_access: event.target.value} );
		}
        function updateMessage56( event ) {
            props.setAttributes( { embeddings: event.target.value} );
		}
        function updateMessage53( event ) {
            props.setAttributes( { upload_pdf: event.target.value} );
		}
        function updateMessage58( event ) {
            props.setAttributes( { file_uploads: event.target.value} );
		}
        function updateMessage59( event ) {
            props.setAttributes( { custom_header: event.target.value} );
		}
        function updateMessage60( event ) {
            props.setAttributes( { custom_footer: event.target.value} );
		}
        function updateMessage61( event ) {
            props.setAttributes( { send_message_sound: event.target.value} );
		}
        function updateMessage62( event ) {
            props.setAttributes( { receive_message_sound: event.target.value} );
		}
        function updateMessage63( event ) {
            props.setAttributes( { custom_css: event.target.value} );
		}
        function updateMessage64( event ) {
            props.setAttributes( { response_delay: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'AIomatic Chat Form ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to generate an AI chat.'
                    )
                )
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
				{ type:'text',placeholder:'Assistant ID', value: assistant_id, onChange: updateMessage44, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Overwrite Text-to-Speech Voice ID: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the voice ID you want to use for text-to-speech for this chatbot. This needs to be exactly matching the voice ID of the text-to-speech engine you are using. For example, for OpenAI Text-to-Speech API, the voice IDs can be: alloy, echo, onyx, nova, fable, shimmer'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Overwrite chatbot text-to-speech voice', value: overwrite_voice, onChange: updateMessage45, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Overwrite Text-to-Speech Voice ID: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the D-ID streaming avatar image for the chatbot. Send a valid URL to an image, which will be used as a seed for the interactive image avatar of the chatbot, created using D-ID streaming.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Overwrite chatbot video avatar image (D-ID streaming)', value: overwrite_avatar_image, onChange: updateMessage47, className: 'coderevolution_gutenberg_input' }
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
                'Enable AI Vision: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to enable AI vision. Note that this is supported only by the latest AI models, which provide also Vision support.'
                )
            ),
            gcel(
                'select',
                { value: enable_vision, onChange: updateMessage43, className: 'coderevolution_gutenberg_select' }, 
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
                'Disable D-ID Streaming: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to disable D-ID streaming for this chatbot.'
                )
            ),
            gcel(
                'select',
                { value: disable_streaming, onChange: updateMessage48, className: 'coderevolution_gutenberg_select' }, 
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
                'Text-To-Speech/Video: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to enable/disable the text-to-speech/video feature of the chatbot.'
                )
            ),
            gcel(
                'select',
                { value: chatbot_text_speech, onChange: updateMessage49, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'off'},
                    'off'
                ), 
                gcel(
                    'option',
                    { value: 'openai'},
                    'openai'
                ), 
                gcel(
                    'option',
                    { value: 'elevenlabs'},
                    'elevenlabs'
                ), 
                gcel(
                    'option',
                    { value: 'google'},
                    'google'
                ), 
                gcel(
                    'option',
                    { value: 'did'},
                    'did'
                ), 
                gcel(
                    'option',
                    { value: 'didstream'},
                    'didstream'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Enable Chatbot God Mode: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to enable/disable the chatbot GOD MODE feature. This will allow ultimate control of your WordPress site, allowing it to call functions from WordPress directly. Using this feature, you will be able to create posts directly from the chatbot, assign taxonomies, images and many more! Warning! This is a BETA feature, use it with caution.'
                )
            ),
            gcel(
                'select',
                { value: enable_god_mode, onChange: updateMessage51, className: 'coderevolution_gutenberg_select' }, 
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
                'Enable Users To Upload PDF Files To The Chatbot: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to enable users to upload PDF files to the chatbot. This will require some prerequisites to function, please check the \'PDF Chat\' tab for details.'
                )
            ),
            gcel(
                'select',
                { value: upload_pdf, onChange: updateMessage53, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'disabled'},
                    'disabled'
                ), 
                gcel(
                    'option',
                    { value: 'enabled'},
                    'enabled'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Enable Chatbot User File Uploads Using AI Assistants File Search: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to enable file upload for the chatbot. Note that to use this feature, you will need an AI model which supports file search.'
                )
            ),
            gcel(
                'select',
                { value: file_uploads, onChange: updateMessage58, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'disabled'},
                    'disabled'
                ), 
                gcel(
                    'option',
                    { value: 'enabled'},
                    'enabled'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Custom Header Text: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set your own custom header text for the chatbot.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Add the HTML for a custom header for the chatbot', value: custom_header, onChange: updateMessage59, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Custom Footer Text: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set your own custom footer text for the chatbot.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Add the HTML for a custom footer for the chatbot', value: custom_footer, onChange: updateMessage60, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Custom CSS Code: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set your own custom CSS code for the chatbot.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Add a custom CSS code for the chatbot', value: custom_css, onChange: updateMessage63, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Send Message Sound Effect: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select a sound effect to be played when a message is sent in the chatbot. To disable this feature, leave this settings field blank.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Set your Send Message sound effect URL', value: send_message_sound, onChange: updateMessage61, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Receive Message Sound Effect: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select a sound effect to be played when a message is received in the chatbot. To disable this feature, leave this settings field blank.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Set your Receive Message sound effect URL', value: receive_message_sound, onChange: updateMessage62, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Response Delay (ms): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set a number of milliseconds to set as a delay for the chatbot. You can also set an interval between two values (in ms), case in which, the chatbot will select a random number of milliseconds from that interval, at each response.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Set your Receive Message sound effect URL', value: response_delay, onChange: updateMessage64, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Download Chat Log Icon: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Show download chat log icon.'
                )
            ),
            gcel(
                'select',
                { value: show_dltxt, onChange: updateMessage41, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'hide'},
                    'hide'
                ), 
                gcel(
                    'option',
                    { value: 'show'},
                    'show'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Text-To-Speech Mute Icon: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Show Text-To-Speech Mute Icon.'
                )
            ),
            gcel(
                'select',
                { value: internet_access, onChange: updateMessage55, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'disabled'},
                    'disabled'
                ), 
                gcel(
                    'option',
                    { value: 'enabled'},
                    'enabled'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Enable Embeddings: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select if you want to enable Embeddings'
                )
            ),
            gcel(
                'select',
                { value: embeddings, onChange: updateMessage56, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'disabled'},
                    'disabled'
                ), 
                gcel(
                    'option',
                    { value: 'enabled'},
                    'enabled'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Text-To-Speech Mute Icon: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Show Text-To-Speech Mute Icon.'
                )
            ),
            gcel(
                'select',
                { value: show_mute, onChange: updateMessage54, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'hide'},
                    'hide'
                ), 
                gcel(
                    'option',
                    { value: 'show'},
                    'show'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Internet Access Icon: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Show Internet Access Icon.'
                )
            ),
            gcel(
                'select',
                { value: show_internet, onChange: updateMessage57, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'hide'},
                    'hide'
                ), 
                gcel(
                    'option',
                    { value: 'show'},
                    'show'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Clear Chat Log Icon: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Show clear chat log icon.'
                )
            ),
            gcel(
                'select',
                { value: show_clear, onChange: updateMessage42, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'hide'},
                    'hide'
                ), 
                gcel(
                    'option',
                    { value: 'show'},
                    'show'
                )
            ),
            gcel(
                'br'
            ),
            gcel(
                'label',
                { className: 'coderevolution_gutenberg_label' },
                'Instant Chat Response: '
            ),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the chat should have an instant response.'
                )
            ),
            gcel(
                'select',
                { value: instant_response, onChange: updateMessage7, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'false'},
                    'false'
                ), 
                gcel(
                    'option',
                    { value: 'stream'},
                    'stream'
                ), 
                gcel(
                    'option',
                    { value: 'true'},
                    'true'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Preppend Chat With Text (Not Shown To Users): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Preppend the AI chat with this text, it will not be displayed to users. Using this settings field, you can teach the AI some info about your company, your requirements, give the AI some initial conditions and instructions. You can also use shortcodes in this field. List of supported shortcodes: %%post_title%%, %%post_content%%, %%post_content_plain_text%%, %%post_excerpt%%, %%post_cats%%, %%post_tags%%, %%featured_image%%, %%blog_title%%, %%author_name%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%user_name%%, %%user_email%%, %%user_display_name%%, %%user_role%%, %%user_id%%, %%user_firstname%%, %%user_lastname%%, %%user_url%%, %%user_description%%. You can also use custom fields (post meta) that it\'s assigned to posts using custom shortcodes in this format: %%!custom_field_slug!%%. You can also use custom user meta fields (user meta) which is assigned to users using custom shortcodes in this format: %%~custom_field_slug~%%. Example: if you wish to add data that is imported from the custom field post_data, you should use this shortcode: %%!post_data!%%. The length of this command should not be greater than the max token count set in the settings for the seed command - Update: %%related_questions_KEYWORD%% is also supported, to get a list of PAA questions for the KEYWORD you want to use. Update: nested shortcodes also supported (shortcodes generated by rules from other plugins). Example of prompt to pretain the AI --- Article: "%%post_content%%" \n\n Discussion: \n\n'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Preppend chat with this string (will not be shown to users)', value: chat_preppend_text, onChange: updateMessage8, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Preppend Each User Message With Text (Not Shown To Users): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Preppend each of the user messages with this text, it will not be displayed to users. Using this settings field, you can set a name to users in the conversation, like "Customer: ".'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Preppend user message with this string (will not be shown to users)', value: user_message_preppend, onChange: updateMessage9, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Preppend Each AI Message With Text (Not Shown To Users): '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Preppend each of the AI messages with this text, it will not be displayed to users. Using this settings field, you can set a name to the AI in the conversation, like "Support Assistant: ".'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Preppend AI message with this string (will not be shown to users)', value: ai_message_preppend, onChange: updateMessage10, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Set The First Message Of The AI ChatBot:'
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Sets The First Message Of The AI Chat Bot. This is displayed to users.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'First message of the chatbot', value: ai_first_message, onChange: updateMessage11, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
                'br'
            ),
            gcel(
                'label',
                { className: 'coderevolution_gutenberg_label' },
                'Chat Mode: '
            ),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the mode of the chat (images or text).'
                )
            ),
            gcel(
                'select',
                { value: chat_mode, onChange: updateMessage12, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'text'},
                    'text'
                ), 
                gcel(
                    'option',
                    { value: 'images'},
                    'images'
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
				{ type:'number',min:0,placeholder:'Daily token count for users', value: user_token_cap_per_day, onChange: updateMessage13, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Enable Persistent Chat: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select a unique ID for persistent conversations of users. You can create multiple persistent conversations using different IDs, added to different shortcodes.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Select the persistent conversation ID, which will be saved for each user', value: persistent, onChange: updateMessage14, className: 'coderevolution_gutenberg_input' }
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
				{ type:'text',placeholder:'Template1;Template2;Template3', value: prompt_templates, onChange: updateMessage15, className: 'coderevolution_gutenberg_input' }
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
				{ value: prompt_editable, onChange: updateMessage16, className: 'coderevolution_gutenberg_select' },
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
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Form Input Placeholder: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the placeholder text of the chat input. The default is: Enter your chat message here.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Preppend chat with this string (will not be shown to users)', value: placeholder, onChange: updateMessage17, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Form Input Submit Button Text: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the text of the submit button. The default is: Submit'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'Submit', value: submit, onChange: updateMessage18, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Text For Prompt Templates Selection: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the text of the prompt selection placeholder. The default is: Please select a prompt'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'Please select a prompt', value: select_prompt, onChange: updateMessage46, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chat Compliance Text: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Set the compliance text for the chatbot'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'Compliance text', value: compliance, onChange: updateMessage36, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Show Chat In A Popup Window: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Do you want to show the chat in a popup window instead in the page?'
                )
            ),
            gcel(
                'select',
                { value: show_in_window, onChange: updateMessage19, className: 'coderevolution_gutenberg_select' }, 
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
                'Chatbot Avatar: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the numeric ID of a Media Library item which will be set as the avatar of the chatbot AI.'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'', value: ai_avatar, onChange: updateMessage33, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chatbot Role: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the role of the AI chatbot. This is purely cosmetic, will only be displayed on the front end of the chatbot interface.'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'', value: ai_role, onChange: updateMessage34, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Window Location: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select where you want to display the popup window. This works only if you set the "Show Chat In A Popup Window" settings field to "on".'
                )
            ),
            gcel(
                'select',
                { value: window_location, onChange: updateMessage20, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 'bottom-right'},
                    'bottom-right'
                ), 
                gcel(
                    'option',
                    { value: 'bottom-left'},
                    'bottom-left'
                ),gcel(
                    'option',
                    { value: 'top-right'},
                    'top-right'
                ), 
                gcel(
                    'option',
                    { value: 'top-left'},
                    'top-left'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Font Size: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the font size of the chatbot form. Default is 1em'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'1em', value: font_size, onChange: updateMessage21, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chat Form Width: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the width of the chatbot form. For full width, you can set 100% (default value). You can also set values in pixels, like: 400px'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'100%', value: width, onChange: updateMessage32, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chat Form Height: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the height of the chatbot form. For full height, you can set auto (default value). You can also set values in pixels, like: 400px'
                )
            ),
			gcel(
				'input',
				{ type:'text', placeholder:'auto', value: height, onChange: updateMessage22, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chat Form Min-Height: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the min-height of the chatbot form (when the form is resized, this is the minimum height it will be allowed to get. Default is 250px. You can set values in pixels, like: 400px'
                )
            ),
			gcel(
				'input',
				{ type:'text', value: minheight, onChange: updateMessage24, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Form Background Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the background color of the chatbot form. Default is #ffffff'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: general_background, onChange: updateMessage35, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Input Background Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the background color of the chatbot input. Default is #f7f7f9'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: background, onChange: updateMessage23, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Chat Form Min-Height: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the min-height of the chatbot form (when the form is resized, this is the minimum height it will be allowed to get. Default is 250px. You can set values in pixels, like: 400px'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: user_font_color, onChange: updateMessage25, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'User Baloon Background Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the font color of the user baloon chatbot form. Default is #0084ff'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: user_background_color, onChange: updateMessage26, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'AI Font Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the font color of the AI chatbot form. Default is black'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: ai_font_color, onChange: updateMessage27, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'AI Baloon Background Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the font color of the AI baloon chatbot form. Default is #f0f0f0'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: ai_background_color, onChange: updateMessage28, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Input Border Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the border color for the input field. Default is #e1e3e6'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: input_border_color, onChange: updateMessage29, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Input Text Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the text color for the input field. Default is #000000'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: input_text_color, onChange: updateMessage37, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Input Placeholder Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the placeholder color for the input field. Default is #333333'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: input_placeholder_color, onChange: updateMessage38, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Persona Name Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the persona name color for the input field. Default is #000000'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: persona_name_color, onChange: updateMessage39, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Persona Role Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the persona role color for the input field. Default is #000000'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: persona_role_color, onChange: updateMessage40, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Submit Button Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the color of the submit button. Default is #55a7e2'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: submit_color, onChange: updateMessage30, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Submit Button Text Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the text color of the submit button. Default is #55a7e2'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: submit_text_color, onChange: updateMessage31, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Voice Button Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the color of the voice button. Default is #55a7e2'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: voice_color, onChange: updateMessage50, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Voice Button Activated Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the color of the voice button when activated. Default is #55a7e2'
                )
            ),
			gcel(
				'input',
				{ type:'color', value: voice_color_activated, onChange: updateMessage52, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );