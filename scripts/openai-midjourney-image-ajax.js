"use strict";
function midjourneyimagefunct() {
    jQuery('#aimidjourneyimagesubmitbut').attr('disabled', true);
    var instructionx = jQuery('#aiomatic_midjourney_image_instruction');
    var instruction = instructionx.val();
    if(instruction == '')
    {
        jQuery('#aimidjourneyimagesubmitbut').attr('disabled', false);
        jQuery('#openai-midjourney-image-response').html('<div class="text-primary highlight-text-fail" role="status">Please add a prompt in the input field.</div>');
        console.log('Instruction cannot be empty.');
        return;
    }
    var image_placeholder = aiomatic_midjourney_image_ajax_object.image_placeholder;
    jQuery("#aiomatic_midjourney_image_response").attr("src", image_placeholder).fadeIn();
    var image_size = aiomatic_midjourney_image_ajax_object.image_size;
    var user_token_cap_per_day = aiomatic_midjourney_image_ajax_object.user_token_cap_per_day;
    var user_id = aiomatic_midjourney_image_ajax_object.user_id;
    // Show the loading animation
    jQuery('#openai-midjourney-image-response').html('<div class="automaticx-dual-ring"></div>');
    if(image_size == 'default' || image_size == '')
    {
        image_size = jQuery( "#model-midjourney-size-selector option:selected" ).text();
    }
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_midjourney_image_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_midjourney_image_ajax_submit',
            instruction: instruction,
            image_size: image_size,
            user_token_cap_per_day: user_token_cap_per_day,
            nonce: aiomatic_midjourney_image_ajax_object.nonce,
            user_id: user_id
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
                    jQuery('#openai-midjourney-image-response').html('<div class="text-primary" role="status">No image was returned. Please try using a different text input.</div>');
                    jQuery("#aiomatic_midjourney_image_response").attr("src", '').fadeIn();
                }
                else
                {
                    jQuery("#aiomatic_midjourney_image_response").attr("src", response.data).fadeIn();
                    jQuery('#openai-midjourney-image-response').html('');
                }
            }
            else
            {
                if(typeof response.msg !== 'undefined')
                {
                    jQuery('#openai-midjourney-image-response').html('<div class="text-primary highlight-text-fail" role="status">' + response.msg + '</div>');
                }
                else
                {
                    console.log('Error: ' + response);
                    jQuery('#openai-midjourney-image-response').html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                }
                jQuery("#aiomatic_midjourney_image_response").attr("src", '').fadeIn();
            }
            jQuery('#aimidjourneyimagesubmitbut').attr('disabled', false);
        },
        error: function(error) {
            console.log('Error: ' + error.responseText);
            jQuery("#aiomatic_midjourney_image_response").attr("src", '').fadeIn();
            // Clear the response container
            jQuery('#openai-midjourney-image-response').html('<div class="text-primary highlight-text-fail" role="status">Failed to image content, try again later.</div>');
            // Enable the submit button
            jQuery('#aimidjourneyimagesubmitbut').attr('disabled', false);
        },
    });
}

var recognition;
var recognizing = false;
jQuery(document).ready(function() {
    
    if(!jQuery('#aiomatic_midjourney_image_templates').length)
    {
        // Check if the browser supports the Web Speech API
        if ('webkitSpeechRecognition' in window) {
            recognition = new webkitSpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;

            // Start the speech recognition when the button is clicked
            jQuery('#openai-midjourney-image-speech-button').on('click', function() {
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
                        jQuery('#aiomatic_midjourney_image_instruction').val(jQuery('#aiomatic_midjourney_image_instruction').val() + " " + event.results[i][0].transcript);
                    }
                }
                
            };
        }
    }
    else
    {
        jQuery('#aiomatic_midjourney_image_templates').on('change', function()
        {
            jQuery('#aiomatic_midjourney_image_instruction').val(jQuery( "#aiomatic_midjourney_image_templates" ).val());
        });
    }
});