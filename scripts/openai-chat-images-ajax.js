"use strict";
jQuery(document).ready(function($) 
{
    $('.aiomatic-chat-holder').each(function( ) 
    {
        var instance = $(this).attr("instance");
        initChatbotAiomatic(instance);
        if(window["aiomatic_chat_image_ajax_object" + instance].autoload == '1')
        {
            $('#aiomatic-open-button' + instance).click();
        }
    });
});
function aiomaticEscapeHtml(text) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
function initChatbotAiomatic(instance)
{
    var aiomatic_chat_image_ajax_object = window["aiomatic_chat_image_ajax_object" + instance];
    jQuery(document).on('click', '#ai-export-txt' + instance, function (event) 
    {
        event.preventDefault();
        ai_chat_download();
    });
    jQuery(document).on('click', '#ai-clear-chat' + instance, function (event) 
    {
        event.preventDefault();
        jQuery('#aiomatic_chat_history' + instance).html('');
    });
    jQuery(document).on('click', '#aiimagechatsubmitbut' + instance, function (event) 
    {
        event.preventDefault();
        openaiimagechatfunct().catch(console.error);
    });
    String.prototype.aitrim = function() {
        return this.replace(/^\s+|\s+$/g, "");
    };
    var input = document.getElementById("aiomatic_chat_input" + instance);
        input.addEventListener("keydown", function (e) {
        if (e.key === "Enter" && !e.shiftKey) { 
            e.preventDefault(); 
            openaiimagechatfunct().catch(console.error);
            return false;
        }
    });
    function ai_chat_download() 
    {
        if(aiomatic_chat_image_ajax_object.chat_download_format == 'txt')
        {
            var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
            var text = x_input_text.replace(/<div class="ai-bubble ai-other">([\s\S]*?)<\/div>/g, "$1\n");
            text = text.replace(/<div class="ai-bubble ai-mine">([\s\S]*?)<\/div>/g, "$1\n");
            text = text.replace(/<div class="ai-speech">([\s\S]*?)<\/div>/g, '');
            text = text.aitrim();
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', 'chat.txt');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
        else
        {
            var element = document.querySelector('#aiomatic_chat_history' + instance);
            var originalStyle = element.getAttribute('style');
            element.style.height = 'auto';
            element.style.maxHeight = 'none';
            element.style.overflow = 'visible';
            html2canvas(element, {
                scrollY: -window.scrollY,
                useCORS: true,
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight
            }).then(canvas => 
            {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'px',
                    format: [canvas.width, canvas.height]
                });
                var pageHeight = pdf.internal.pageSize.height;
                var imgHeight = canvas.height;
                var heightLeft = imgHeight;
                var position = 0;
                pdf.addImage(imgData, 'PNG', 0, position, canvas.width, canvas.height);
                heightLeft -= pageHeight;
                while (heightLeft >= 0) 
                {
                    position = heightLeft - imgHeight;
                    pdf.addImage(imgData, 'PNG', 0, position, canvas.width, canvas.height);
                    heightLeft -= pageHeight;
                }
                pdf.save('chat.pdf');
                element.setAttribute('style', originalStyle);
            });
        }
    }
    async function openaiimagechatfunct() {
        jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', true);
        var input_textj = jQuery('#aiomatic_chat_input' + instance);
        var input_text = '';
        jQuery('#openai-image-chat-response' + instance).html('<div class="automaticx-dual-ring"></div>');
        input_text = input_textj.val();
        if(aiomatic_chat_image_ajax_object.no_empty == '1' && input_text == '')
        {
            jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', false);
            jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">You need to enter a message to speak to the chatbot.</div>');
            return;
        }
        input_text = aiomaticEscapeHtml(input_text);
        input_textj.val('');
        if(aiomatic_chat_image_ajax_object.enable_moderation == '1')
        {
            var isflagged = false;
            await jQuery.ajax({
                type: 'POST',
                url: aiomatic_chat_image_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_moderate_text',
                    text: input_text,
                    nonce: aiomatic_chat_image_ajax_object.moderation_nonce,
                    model: aiomatic_chat_image_ajax_object.moderation_model
                },
                success: function(response) {
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
                        const resp = JSON.parse(response.data);
                        if(resp.results[0].flagged != undefined)
                        {
                            if(resp.results[0].flagged == true)
                            {
                                jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', false);
                                jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">' + aiomatic_chat_image_ajax_object.flagged_message + '</div>');
                                isflagged = true;
                            }
                        }
                        else
                        {
                            console.log('Invalid response from moderation ' + response);
                        }
                    }
                    else
                    {
                        if(typeof response.msg !== 'undefined')
                        {
                            console.log('Moderation returned an error: ' + response.msg);
                        }
                        else
                        {
                            console.log('Moderation returned an error: ' + response);
                        }
                    }
                },
                error: function(error) {
                    console.log('Moderation failed: ' + error.responseText);
                },
            });
            if(isflagged == true)
            {
                return;
            }
        }
        var user_token_cap_per_day = aiomatic_chat_image_ajax_object.user_token_cap_per_day;
        var user_id = aiomatic_chat_image_ajax_object.user_id;
        var persistent = aiomatic_chat_image_ajax_object.persistent;
        if(input_text == '')
        {
            jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', false);
            jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">Please add a text in the input field.</div>');
            console.log('Instruction cannot be empty.');
            return;
        }
        var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
        if(input_text.aitrim() != '')
        {
            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-mine">' + input_text + '</div>');
        }
        
        jQuery.ajax({
            type: 'POST',
            url: aiomatic_chat_image_ajax_object.ajax_url,
            data: {
                action: 'aiomatic_image_chat_submit',
                input_text: input_text,
                user_token_cap_per_day: user_token_cap_per_day,
                nonce: aiomatic_chat_image_ajax_object.nonce,
                user_id: user_id
            },
            success: function(response) {
                if(typeof response === 'string' || response instanceof String)
                {
                    try {
                        responset = JSON.parse(response);
                        response = responset;
                    } catch (error) {
                        console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                    }
                }
                if(response.status == 'success')
                {
                    if(response.data == '')
                    {
                        jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">No image was generated. Please try using a different text input.</div>');
                    }
                    else
                    {
                        var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                        if((persistent == 'on' || persistent == 'logs' || persistent == '1') && user_id != '0')
                        {
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_image_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_user_meta_save',
                                    nonce: aiomatic_chat_image_ajax_object.persistentnonce,
                                    persistent: persistent,
                                    x_input_text: x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>',
                                    user_id: user_id
                                },
                                success: function() {
                                },
                                error: function(error) {
                                    console.log('Error while saving persistent user log: ' + error.responseText);
                                },
                            });
                        }
                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                        // Clear the response container
                        jQuery('#openai-image-chat-response' + instance).html('&nbsp;');
                        // Enable the submit button
                        jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', false);
                    }
                }
                else
                {
                    if(typeof response.msg !== 'undefined')
                    {
                        jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">' + response.msg + '</div>');
                    }
                    else
                    {
                        console.log('Error: ' + response);
                        jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                    }
                }
                jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', false);
            },
            error: function(error) {
                console.log('Error: ' + error.responseText);
                // Clear the response container
                jQuery('#openai-image-chat-response' + instance).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
                // Enable the submit button
                jQuery('#aiimagechatsubmitbut' + instance).attr('disabled', false);
            },
        });
    }
    var recognition;
    var recognizing = false;
    jQuery(document).ready(function() {
        
        if(aiomatic_chat_image_ajax_object.scroll_bot == 'on')
        {
            jQuery('#aiomatic_chat_history' + instance).on('DOMSubtreeModified', function(){
                var psconsole = jQuery('#aiomatic_chat_history' + instance);
                if(psconsole.length)
                {
                    psconsole.scrollTop(psconsole[0].scrollHeight - psconsole.height());
                }
            });
        }
        if(jQuery('#aiomatic_image_chat_templates' + instance).length)
        {
            jQuery('#aiomatic_image_chat_templates' + instance).on('change', function()
            {
                jQuery('#aiomatic_chat_input' + instance).val(jQuery( "#aiomatic_image_chat_templates" + instance ).val());
            });
        }
        else
        {
            // Check if the browser supports the Web Speech API
            if ('webkitSpeechRecognition' in window) {
                recognition = new webkitSpeechRecognition();
                recognition.continuous = true;
                recognition.interimResults = true;

                // Start the speech recognition when the button is clicked
                jQuery('#openai-image-chat-speech-button' + instance).on('click', function() {
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
                            jQuery('#aiomatic_chat_input' + instance).val(jQuery('#aiomatic_chat_input' + instance).val() + " " + event.results[i][0].transcript);
                        }
                    }
                    
                };
            }
        }
    });
}