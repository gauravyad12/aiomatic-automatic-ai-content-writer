"use strict";
function openaiimagefunct(uniqid) {
    jQuery('#aiimagesubmitbut' + uniqid).attr('disabled', true);
    var instructionx = jQuery('#aiomatic_image_instruction' + uniqid);
    var instruction = instructionx.val();
    if(instruction == '')
    {
        jQuery('#aiimagesubmitbut' + uniqid).attr('disabled', false);
        jQuery('#openai-image-response' + uniqid).html('<div class="text-primary highlight-text-fail" role="status">Please add a prompt in the input field.</div>');
        console.log('Instruction cannot be empty.');
        return;
    }
    var image_placeholder = aiomatic_image_ajax_object.image_placeholder;
    jQuery("#aiomatic_image_response" + uniqid).attr("src", image_placeholder).fadeIn();
    var image_size = aiomatic_image_ajax_object.image_size;
    
    var input_model = jQuery('#image_model' + uniqid);
    if(input_model !== undefined)
    {
        var image_model = input_model.val();
    }
    else
    {
        var image_model = aiomatic_image_ajax_object.image_model;
    }
    var user_token_cap_per_day = aiomatic_image_ajax_object.user_token_cap_per_day;
    var user_id = aiomatic_image_ajax_object.user_id;
    // Show the loading animation
    jQuery('#openai-image-response' + uniqid).html('<div class="automaticx-dual-ring"></div>');
    if(image_size == 'default' || image_size == '')
    {
        image_size = jQuery( "#ai-image-size-selector"  + uniqid + " option:selected" ).text();
    }
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_image_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_image_ajax_submit',
            instruction: instruction,
            image_size: image_size,
            user_token_cap_per_day: user_token_cap_per_day,
            nonce: aiomatic_image_ajax_object.nonce,
            user_id: user_id,
            image_model: image_model
        },
        success: function(response) 
        {
            if(typeof response === 'string' || response instanceof String)
            {
                try {
                    var responset = JSON.parse(response);
                    response = responset;
                } catch (error) {
                    console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                }
            }
            if(response.status == 'success')
            {
                if(response.data == '')
                {
                    jQuery('#openai-image-response' + uniqid).html('<div class="text-primary" role="status">No image was returned. Please try using a different text input.</div>');
                    jQuery("#aiomatic_image_response" + uniqid).attr("src", '').fadeIn();
                }
                else
                {
                    jQuery("#aiomatic_image_response" + uniqid).attr("src", response.data).fadeIn();
                    jQuery('#openai-image-response' + uniqid).html('');
                }
            }
            else
            {
                if(typeof response.msg !== 'undefined')
                {
                    jQuery('#openai-image-response' + uniqid).html('<div class="text-primary highlight-text-fail" role="status">' + response.msg + '</div>');
                }
                else
                {
                    console.log('Error: ' + response);
                    jQuery('#openai-image-response' + uniqid).html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                }
                jQuery("#aiomatic_image_response" + uniqid).attr("src", '').fadeIn();
            }
            jQuery('#aiimagesubmitbut' + uniqid).attr('disabled', false);
        },
        error: function(error) {
            console.log('Error: ' + error.responseText);
            jQuery("#aiomatic_image_response" + uniqid).attr("src", '').fadeIn();
            // Clear the response container
            jQuery('#openai-image-response' + uniqid).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate image content, try again later.</div>');
            // Enable the submit button
            jQuery('#aiimagesubmitbut' + uniqid).attr('disabled', false);
        },
    });
}

var recognition;
var recognizing = false;
jQuery(document).ready(function() {
    if(!jQuery('#aiomatic_image_templates').length)
    {
        // Check if the browser supports the Web Speech API
        if ('webkitSpeechRecognition' in window) {
            recognition = new webkitSpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;

            // Start the speech recognition when the button is clicked
            jQuery('#openai-image-speech-button').on('click', function() {
                if (recognizing) {
                    recognition.stop();
                    recognizing = false;
                } else {
                    recognition.start();
                    recognizing = true;
                }
            });

            // Handle the speech recognition results
            recognition.onresult = function(event) {
                for (var i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) {
                        jQuery('#aiomatic_image_instruction').val(jQuery('#aiomatic_image_instruction').val() + " " + event.results[i][0].transcript);
                    }
                }
                
            };
        }
    }
    else
    {
        jQuery('#aiomatic_image_templates').on('change', function()
        {
            jQuery('#aiomatic_image_instruction').val(jQuery( "#aiomatic_image_templates" ).val());
        });
    }
});