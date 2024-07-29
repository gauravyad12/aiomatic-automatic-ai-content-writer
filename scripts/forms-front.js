"use strict";
function aiomaticCountChars(textbox, counter) 
{
    var counterElement = document.getElementById(counter);
    if (!counterElement) 
    {
        return;
    }
    if (typeof tinymce !== 'undefined' && tinymce.get(textbox)) 
    {
        textboxElement = tinymce.get(textbox).getContent({format: 'text'});
        counterElement.innerHTML = textboxElement.length;
        return;
    }
    var textboxElement = document.getElementById(textbox);    
    if (!textboxElement) 
    {
        return;
    }
    var count = textboxElement.value.length;
    counterElement.innerHTML = count;
}
jQuery(document).ready(function ($)
{
    var model_type = 'gpt';
    function aiomatic_nl2br (str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
    function aiChatUploadDataomaticForm(aiomatic_completition_ajax_object, uniqid, input_text, remember_string, user_question, function_result) 
    {
        var formData = new FormData();
        formData.append('uniqid', uniqid);
        formData.append('input_text', input_text);
        formData.append('remember_string', remember_string);
        formData.append('user_question', user_question);
        if(function_result !== null)
        {
            formData.append('function_result', function_result);
        }
        formData.append('action', 'aiomatic_save_chat_data');
        formData.append('nonce', aiomatic_completition_ajax_object.persistentnonce);
        return jQuery.ajax({
            url: aiomatic_completition_ajax_object.ajax_url,
            async: false, 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false
        });
    };
    function aiomatic_mergeDeep(target, source) 
    {
        Object.keys(source).forEach(key => 
        {
            if (source[key] && typeof source[key] === 'object' && key !== 'arguments') 
            {
                if (!target[key]) 
                {
                    target[key] = {};
                }
                aiomatic_mergeDeep(target[key], source[key]);
            } 
            else 
            {
                if (key === 'arguments') 
                {
                    if (!target[key]) 
                    {
                        target[key] = '';
                    } 
                    target[key] += source[key];
                } 
                else 
                {
                    target[key] = source[key];
                }
            }
        });
    }
    function AiomaticValidateEmail(input) 
    {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (input.match(validRegex)) {
          return true;
        } else {
          return false;
        }
    }
    function AiomaticisValidUrl(string) {
        try {
          new URL(string);
          return true;
        } catch (err) {
          return false;
        }
      }
    function aiomatichtmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }
    function aiomaticBasicEditor(dataId){
        var basicEditor = true;
        if (typeof tinyMCE === 'undefined' || tinyMCE === null)
        {
            return basicEditor;
        }
        var editor = tinyMCE.get('aiomatic-prompt-result' + dataId);
        var inputp = document.getElementById('wp-aiomatic-prompt-result' + dataId + '-wrap');
        if ( inputp !== null && inputp.classList.contains('tmce-active') && editor ) {
            basicEditor = false;
        }
        return basicEditor;
    }
    function aiomaticSetContent(dataId, value){
        if (aiomaticBasicEditor(dataId)) {
            document.getElementById('aiomatic-prompt-result' + dataId).value = aiomatichtmlDecode(value);
        } else {
            var editor = tinyMCE.get('aiomatic-prompt-result' + dataId);
            editor.setContent(aiomatichtmlDecode(value));
        }
        aiomaticCountChars('aiomatic-prompt-result' + dataId,'charCount_span' + dataId);
    }
    function aiomaticLoadingBtn(btn){
        btn.attr('disabled', '');
        btn.addClass('button--loading');
    }
    function aiomaticRmLoading(btn){
        btn.removeAttr('disabled');
        btn.removeClass('button--loading');
    }
    function aiSimpleDecryptWithKey(encryptedText, key) 
    {
        var decodedData = atob(encryptedText);
        var result = '';
        for (var i = 0, len = decodedData.length; i < len; i++) 
        {
            var shift = key.charCodeAt(i % key.length);
            var charCode = (decodedData.charCodeAt(i) - shift + 256) % 256;
            var char = String.fromCharCode(charCode);
            result += char;
        }
        return result;
    }
    var eventGenerator = false;
    var aiomatic_generator_working = false;
    $(document).on('click','.aiomatic_copy_btn', function(e) 
    {
        e.preventDefault();
        var editorId = $(this).attr('data-id');
        if(editorId !== undefined && editorId !== null)
        {
            var content;
            if (tinyMCE.get('aiomatic-prompt-result' + editorId)) {
                content = tinyMCE.get('aiomatic-prompt-result' + editorId).getContent();
            } else {
                content = $('#aiomatic-prompt-result' + editorId).val();
            }
            if(navigator.clipboard !== undefined)
            {
                navigator.clipboard.writeText(content).then(function() {
                    alert('Content copied to clipboard');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                });
            }
            else
            {
                console.error('Failed to copy text');
            }
        }
    });
    function aiomaticScrapeData(value) {
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_completition_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_scrape_form_submit',
                    scrapeurl: value,
                    nonce: aiomatic_completition_ajax_object.nonce
                },
                success: function(response) {
                    if (typeof response === 'string' || response instanceof String) {
                        try {
                            var responset = JSON.parse(response);
                            response = responset;
                        } catch (error) {
                            reject("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                            return;
                        }
                    }
                    resolve(response);
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }
    $(document).on('click','.aiomatic-generate-button', async function(e)
    {
        e.preventDefault();
        var targetButton = e.target.closest('.aiomatic-generate-button');
        if (targetButton) 
        {
            var dataId = targetButton.getAttribute('data-id');
        }
        else
        {
            jQuery('#openai-response').html('<div class="text-primary highlight-text-fail" role="status">Failed to process form response, please try again later.</div>');
            console.log('aiomatic-generate-button not found!');
            return;
        }
        var downloadButton = jQuery("#download_button" + dataId);
        downloadButton.hide();
        jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status"></div>');
        var aiomaticGenerateBtn = $('#aiomatic-generate-button' + dataId);
        if (aiomaticGenerateBtn.length == 0) 
        {
            jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">There was an error during processing, please try again later.</div>');
            return;
        }
        var aiomaticMaxToken = document.getElementById('aiomatic-engine' + dataId);
        var max_tokens = aiomaticMaxToken.value;
        var aiomaticTemperature = document.getElementById('aiomatic-temperature' + dataId);
        var aiomaticTypeInput = document.getElementById('aiomatic-form-type' + dataId);
        var aiomaticType = aiomaticTypeInput.value;
        var temperature = aiomaticTemperature.value;
        var aiomaticTopP = document.getElementById('aiomatic-top_p' + dataId);
        var top_p = aiomaticTopP.value;
        var aiomaticFP = document.getElementById('aiomatic-frequency_penalty' + dataId);
        var frequency_penalty = aiomaticFP.value;
        var aiomaticPP = document.getElementById('aiomatic-presence_penalty' + dataId);
        var presence_penalty = aiomaticPP.value;
        var error_message = false;
        var aiomaticPromptTitle = document.getElementById('aiomatic-prompt' + dataId);
        var prompt = aiomaticPromptTitle.value;
        prompt = aiSimpleDecryptWithKey(prompt, aiomatic_completition_ajax_object.secretkey);
        var model = jQuery("#aiomatic-engine" + dataId).val();
        if(aiomatic_completition_ajax_object.claude_models.includes(model))
        {
            model_type = 'claude';
        }
        else
        {
            if(aiomatic_completition_ajax_object.google_models.includes(model))
            {
                model_type = 'google';
            }
            else
            {
                if(aiomatic_completition_ajax_object.huggingface_models.includes(model))
                {
                    model_type = 'huggingface';
                }
            }
        }
        var instant_response = jQuery("#aiomatic-streaming" + dataId).val();
        var assistant_id = jQuery("#aiomatic-assistant-id" + dataId).val();
        if(assistant_id === null)
        {
            assistant_id = '';
        }
        if(prompt === ''){
            error_message = 'Please insert prompt';
        }
        else if(max_tokens === ''){
            error_message = 'Please enter max tokens';
        }
        else if(parseFloat(max_tokens) < 1 || parseFloat(max_tokens) > 8000){
            error_message = 'Please enter a valid max tokens value between 1 and 8000';
        }
        else if(temperature === ''){
            error_message = 'Please enter temperature';
        }
        else if(parseFloat(temperature) < 0 || parseFloat(temperature) > 2){
            error_message = 'Please enter a valid temperature value between 0 and 2';
        }
        else if(top_p === ''){
            error_message = 'Please enter Top P';
        }
        else if(parseFloat(top_p) < 0 || parseFloat(top_p) > 1){
            error_message = 'Please enter a valid Top P value between 0 and 1';
        }
        else if(frequency_penalty === ''){
            error_message = 'Please enter frequency penalty';
        }
        else if(parseFloat(frequency_penalty) < -2 || parseFloat(frequency_penalty) > 2){
            error_message = 'Please enter a valid frequency penalty value between -2 and 2';
        }
        else if(presence_penalty === ''){
            error_message = 'Please enter presence penalty';
        }
        else if(parseFloat(presence_penalty) < -2 || parseFloat(presence_penalty) > 2){
            error_message = 'Please enter a valid presence penalty value between -2 and 2';
        }
        const scrapePromises = [];
        let formin = $('.aiomatic-form-input' + dataId);
        formin.each(function(){
            let name = $(this).attr('aiomatic-name');
            let value = $(this).val();
            let type = $(this).attr('data-type');
            let min = $(this).attr('data-min');
            let max = $(this).attr('data-max');
            let required = $(this).attr('data-required');
            let limit = $(this).attr('data-limit');
            if(aiomatic_completition_ajax_object.min_len != '')
            {
                if(value.length < parseInt(aiomatic_completition_ajax_object.min_len, 10))
                {
                    error_message = name + ': You need to enter a longer input value, minimum is: ' + aiomatic_completition_ajax_object.min_len;
                }
            }
            if(aiomatic_completition_ajax_object.max_len != '')
            {
                if(value.length > parseInt(aiomatic_completition_ajax_object.max_len, 10))
                {
                    error_message = name + ': You need to enter a shorter input value, maximum is: ' + aiomatic_completition_ajax_object.max_len;
                }
            }
            if(min != '')
            {
                if(min > parseInt(value, 10))
                {
                    error_message = name + ': You need to enter a value larger than ' + min;
                }
            }
            if(max != '')
            {
                if(max < parseInt(value, 10))
                {
                    error_message = name + ': You need to enter a value smaller than ' + max;
                }
            }
            if(type == 'email')
            {
                if(!AiomaticValidateEmail(value))
                {
                    error_message = name + ': Invalid email address submitted: ' + value;
                }
            }
            if(type == 'url' || type == 'scrape')
            {
                if(!AiomaticisValidUrl(value))
                {
                    error_message = name + ': Invalid URL submitted: ' + value;
                }
            }
            if(required == 'yes' && value == '')
            {
                error_message = name + ': This field is required';
            }
            if(type == 'scrape')
            {
                aiomaticLoadingBtn(aiomaticGenerateBtn);
                scrapePromises.push(
                    aiomaticScrapeData(value).then(response => {
                        if (response.status == 'success') 
                        {
                            if (response.data == '') 
                            {
                                error_message = name + ': Cannot scrape URL, no content found.';
                            } 
                            else 
                            {
                                if (typeof limit !== 'undefined' && limit !== false && limit !== null && limit !== '') 
                                {
                                    limit = parseInt(limit, 10);
                                    if (!isNaN(limit) && limit > 0) 
                                    {
                                        if (response.data.length > limit) 
                                        {
                                            response.data = response.data.substring(0, limit);
                                        }
                                    }
                                }
                                prompt = prompt.replace('%%' + name + '%%', response.data);
                            }
                        } 
                        else 
                        {
                            if (typeof response.msg !== 'undefined') 
                            {
                                error_message = name + ': Error in scraping: ' + response.msg;
                            } 
                            else 
                            {
                                error_message = name + ': Scraping failed, please try again later.';
                            }
                        }
                    }).catch(error => {
                        error_message = name + ': Error in request: ' + error.responseText;
                    }).finally(() => {
                        aiomaticRmLoading(aiomaticGenerateBtn);
                    })
                );
            }
            else
            {
                if (typeof limit !== 'undefined' && limit !== false && limit !== null && limit !== '') 
                {
                    limit = parseInt(limit, 10);
                    if (!isNaN(limit) && limit > 0) 
                    {
                        if (value.length > limit) 
                        {
                            value = value.substring(0, limit);
                        }
                    }
                }
                prompt = prompt.replace('%%' + name + '%%', value);
            }
        });
        await Promise.all(scrapePromises);
        if(prompt === '')
        {
            error_message = 'Empty prompt was returned';
        }
        if(error_message)
        {
            jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">' + error_message + '</div>');
            console.log('AI Form processing failed: ' + error_message);
            jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
            aiomaticRmLoading(aiomaticGenerateBtn);
            return;
        }
        else
        {
            aiomaticLoadingBtn(aiomaticGenerateBtn);
            var image_placeholder = aiomatic_completition_ajax_object.image_placeholder;
            jQuery("#aiomatic_form_response" + dataId).attr("src", image_placeholder).fadeIn();
            if(aiomaticType == 'text')
            {
                aiomaticSetContent(dataId, '');
            }
            document.getElementById('openai-response' + dataId).innerHTML = '';

            if(instant_response == 'stream' && aiomaticType == 'text')
            {
                if(aiomatic_generator_working === true)
                {
                    console.log('AI already processing a request!');
                    jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                    jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
                    aiomaticRmLoading(aiomaticGenerateBtn);
                    return;
                }
                var enable_god_mode = 'off';
                aiomatic_generator_working = true;
                var count_line = 0;
                var response_data = '';
                var pdf_data = '';
                var ai_thread_id = '';
                var user_token_cap_per_day = '';
                var remember_string = '';
                var user_question = prompt;
                var input_text = prompt;
                var vision_file = '';
                var mystream = aiomatic_completition_ajax_object.stream_url;
                if(aiomatic_completition_ajax_object.claude_models.includes(model))
                {
                    mystream = aiomatic_completition_ajax_object.stream_url_claude;
                }
                var eventURL = mystream + '&pdf_data=' + encodeURIComponent(pdf_data) + 
                '&user_token_cap_per_day=' + encodeURIComponent(user_token_cap_per_day) + 
                '&user_id=' + encodeURIComponent(aiomatic_completition_ajax_object.user_id) + 
                '&frequency=' + encodeURIComponent(frequency_penalty) + 
                '&presence=' + encodeURIComponent(presence_penalty) + 
                '&top_p=' + encodeURIComponent(top_p) + 
                '&temp=' + encodeURIComponent(temperature) + 
                '&model=' + encodeURIComponent(model) + 
                '&assistant_id=' + encodeURIComponent(assistant_id) + 
                '&thread_id=' + encodeURIComponent(ai_thread_id) + 
                '&input_text=' + encodeURIComponent(input_text) + 
                '&remember_string=' + encodeURIComponent(remember_string) + 
                '&user_question=' + encodeURIComponent(user_question) + 
                '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
                if(vision_file != '')
                {
                    eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                }
                if(eventURL.length > 2080)
                {
                    console.log('URL too long, using alternative event method');
                    var unid = "id" + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);;
                    aiChatUploadDataomaticForm(aiomatic_completition_ajax_object, unid, input_text, remember_string, user_question, null);
                    eventURL = mystream + '&pdf_data=' + encodeURIComponent(pdf_data) + 
                    '&user_token_cap_per_day=' + encodeURIComponent(user_token_cap_per_day) + 
                    '&user_id=' + encodeURIComponent(aiomatic_completition_ajax_object.user_id) + 
                    '&frequency=' + encodeURIComponent(frequency_penalty) + 
                    '&presence=' + encodeURIComponent(presence_penalty) + 
                    '&top_p=' + encodeURIComponent(top_p) + 
                    '&temp=' + encodeURIComponent(temperature) + 
                    '&model=' + encodeURIComponent(model) + 
                    '&assistant_id=' + encodeURIComponent(assistant_id) + 
                    '&thread_id=' + encodeURIComponent(ai_thread_id) + 
                    '&input_text=0' + 
                    '&remember_string=0' +  
                    '&user_question=0' + 
                    '&enable_god_mode=' + encodeURIComponent(enable_god_mode) +
                    '&bufferid=' + encodeURIComponent(unid);
                    if(vision_file != '')
                    {
                        eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                    }
                }
                eventGenerator = new EventSource(eventURL);
                var error_generated = '';
                var func_call = {
                    init_data: {
                        pdf_data: pdf_data, 
                        user_token_cap_per_day: user_token_cap_per_day, 
                        user_id: aiomatic_completition_ajax_object.user_id, 
                        frequency: frequency_penalty, 
                        presence: presence_penalty, 
                        top_p: top_p, 
                        temp: temperature, 
                        model: model, 
                        input_text: input_text, 
                        remember_string: remember_string, 
                        user_question: user_question
                    },
                };
                function handleContentBlockDelta(e) 
                {
                    var hasFinishReason = false;
                    if(model_type == 'claude')
                    {
                        var aiomatic_newline_before = false;
                        var aiomatic_response_events = 0;
                        var aiomatic_limitLines = 1;
                        var resultData = null;
                        if(e.data == '[DONE]')
                        {
                            hasFinishReason = true;
                        }
                        else
                        {
                            try 
                            {
                                resultData = JSON.parse(e.data);
                            } 
                            catch (e) 
                            {
                                console.warn(e);
                                jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                                jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
                                aiomaticRmLoading(aiomaticGenerateBtn);
                                aiomatic_generator_working = false;
                                eventGenerator.close();
                                return;
                            }
                            var hasFinishReason = resultData &&
                            (resultData.finish_reason === "stop" ||
                            resultData.finish_reason === "length");
                            if(resultData.stop_reason == 'stop_sequence' || resultData.stop_reason == 'max_tokens')
                            {
                                hasFinishReason = true;
                            }
                        }
                        var content_generated = '';
                        if(hasFinishReason){
                            count_line += 1;
                            aiomatic_response_events = 0;
                        }
                        else
                        {
                            if(resultData !== null)
                            {
                                var result = resultData;
                            }
                            else
                            {
                                var result = null;
                                try {
                                    result = JSON.parse(e.data);
                                } 
                                catch (e) 
                                {
                                    console.warn(e);
                                    jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                                    jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
                                    aiomaticRmLoading(aiomaticGenerateBtn);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    return;
                                };
                            }
                            if(result.error !== undefined){
                                error_generated = result.error[0].message;
                                if(error_generated === undefined)
                                {
                                    error_generated = result.error.message;
                                }
                                if(error_generated === undefined)
                                {
                                    error_generated = result.error;
                                }
                                jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                                jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                                console.log('Error while processing request(1): ' + error_generated);
                            }
                            else
                            {
                                if(result.completion !== undefined)
                                {
                                    content_generated = result.completion;
                                }
                                else if(result.delta.text !== undefined)
                                {
                                    content_generated = result.delta.text;
                                }
                                else
                                {
                                    console.log('Unrecognized format: ' + result);
                                    content_generated = '';
                                }
                            }
                            response_data += aiomatic_nl2br(content_generated);
                            if((content_generated === '\n' || content_generated === ' \n' || content_generated === '.\n' || content_generated === '\n\n' || content_generated === '.\n\n' || content_generated === '"\n') && aiomatic_response_events > 0){
                                if(!aiomatic_newline_before) {
                                    aiomatic_newline_before = true;
                                }
                            }
                            else if(content_generated === '\n' && aiomatic_response_events === 0){

                            }
                            else{
                                aiomatic_newline_before = false;
                                aiomatic_response_events += 1;
                                aiomaticSetContent(dataId, response_data);
                            }
                        }
                        if(count_line >= aiomatic_limitLines)
                        {
                            eventGenerator.close();
                            aiomatic_generator_working = false;
                            jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                            aiomaticRmLoading(aiomaticGenerateBtn);
                        }
                    }
                }
                if(assistant_id != '')
                {
                    var run_id = '';
                    var func_calls = 0;
                    var response_data = '';
                    var content_generated = '';
                    var th_id = '';
                    eventGenerator.addEventListener('thread.created', threadCreatedEventHandler);
                    eventGenerator.addEventListener('thread.run.created', threadRunCreatedEventHandler);
                    eventGenerator.addEventListener('thread.run.queued', threadRunQueuedEventHandler);
                    eventGenerator.addEventListener('thread.run.in_progress', threadRunInProgressEventHandler);
                    eventGenerator.addEventListener('thread.run.requires_action', threadRunRequiresActionEventHandler);
                    eventGenerator.addEventListener('thread.run.completed', threadRunCompletedEventHandler);
                    eventGenerator.addEventListener('thread.run.failed', threadRunFailedEventHandler);
                    eventGenerator.addEventListener('thread.run.cancelling', threadRunCancellingEventHandler);
                    eventGenerator.addEventListener('thread.run.cancelled', threadRunCancelledEventHandler);
                    eventGenerator.addEventListener('thread.run.expired', threadRunExpiredEventHandler);
                    eventGenerator.addEventListener('thread.run.step.created', threadRunStepCreatedEventHandler);
                    eventGenerator.addEventListener('thread.run.step.in_progress', threadRunStepInProgressEventHandler);
                    eventGenerator.addEventListener('thread.run.step.delta', threadRunStepDeltaEventHandler);
                    eventGenerator.addEventListener('thread.run.step.completed', threadRunStepCompletedEventHandler);
                    eventGenerator.addEventListener('thread.run.step.failed', threadRunStepFailedEventHandler);
                    eventGenerator.addEventListener('thread.run.step.cancelled', threadRunStepCancelledEventHandler);
                    eventGenerator.addEventListener('thread.run.step.expired', threadRunStepExpiredEventHandler);
                    eventGenerator.addEventListener('thread.message.created', threadMessageCreatedEventHandler);
                    eventGenerator.addEventListener('thread.message.in_progress', threadMessageInProgressEventHandler);
                    eventGenerator.addEventListener('thread.message.delta', threadMessageDeltaEventHandler);
                    eventGenerator.addEventListener('thread.message.incomplete', threadMessageIncompleteEventHandler);
                    eventGenerator.addEventListener('thread.message.completed', threadMessageCompletedEventHandler);
                    eventGenerator.addEventListener('error', function(e) {
                        var data = JSON.parse(e.data);
                        console.error('Stream Error:', data);
                        jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                        jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
                        aiomaticRmLoading(aiomaticGenerateBtn);
                        aiomatic_generator_working = false;
                        eventGenerator.close();
                        return;
                    });
                    
                    eventGenerator.addEventListener('done', function(e) {
                        console.log('Stream ended');
                        aiomaticRmLoading(aiomaticGenerateBtn);
                        aiomatic_generator_working = false;
                        eventGenerator.close();
                        return;
                    });
                }
                else
                {
                    eventGenerator.onmessage = handleMessageEvent;
                    eventGenerator.addEventListener('content_block_delta', handleContentBlockDelta);
                    eventGenerator.addEventListener('message_stop', handleMessageStopEvent);
                    eventGenerator.addEventListener('completion', handleCompletionEvent);
                }
                function handleMessageStopEvent(e) 
                {
                    aiomaticRmLoading(aiomaticGenerateBtn);
                    aiomatic_generator_working = false;
                    eventGenerator.close();
                    return;
                }
                function threadCreatedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Thread created:', data);
                }
                function threadRunCreatedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run created:', data);
                    run_id = data.id;
                    th_id = data.thread_id;
                }
                function threadRunQueuedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run queued:', data);
                }
                function threadRunInProgressEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run in_progress:', data);
                }
                function threadRunRequiresActionEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run requires_action:', data);
                }
                function threadRunCompletedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run completed:', data);
                    eventGenerator.close();
                    aiomatic_generator_working = false;
                    jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                    aiomaticRmLoading(aiomaticGenerateBtn);
                }
                function threadRunCancellingEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run cancelling:', data);
                }
                function threadRunCancelledEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run cancelled:', data);
                }
                function threadRunExpiredEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run expired:', data);
                }
                function threadRunStepCreatedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step created:', data);
                }
                function threadRunStepInProgressEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step in progress:', data);
                }
                function threadRunStepDeltaEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step delta:', data);
                    var xarr = {'tool_calls': []};
                    xarr.tool_calls.push(data.delta.step_details.tool_calls[0]);
                    aiomatic_mergeDeep(func_call, xarr);
                    func_calls++;
                }
                function threadRunStepCompletedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step completed:', data);
                }
                function threadRunStepCancelledEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step cancelled:', data);
                }
                function threadRunStepExpiredEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step expired:', data);
                }
                function threadMessageCreatedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run message created:', data);
                }
                function threadMessageInProgressEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run message in progress:', data);
                }
                function threadMessageDeltaEventHandler(e) {
                    var data = JSON.parse(e.data);
                    if(typeof data.delta.content[0].text.value !== 'undefined')
                    {
                        content_generated = data.delta.content[0].text.value;
                        response_data += aiomatic_nl2br(content_generated);
                        aiomaticSetContent(dataId, response_data);
                    }
                    else
                    {
                        console.log('Generated content not found: ' + data);
                    }
                }
                function threadMessageIncompleteEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run message incomplete:', data);
                    eventGenerator.close();
                }
                function threadRunFailedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run failed:', data);
                    console.warn(e);
                    aiomaticRmLoading(aiomaticGenerateBtn);
                    aiomatic_generator_working = false;
                    eventGenerator.close();
                    return;
                }
                function threadRunStepFailedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run step failed:', data);
                    console.warn(e);
                    aiomaticRmLoading(aiomaticGenerateBtn);
                    aiomatic_generator_working = false;
                    eventGenerator.close();
                    return;
                }
                function threadMessageCompletedEventHandler(e) {
                    var data = JSON.parse(e.data);
                    //console.log('Run message completed:', data);
                }
                function handleCompletionEvent(e) 
                {
                    if(model_type == 'claude')
                    {
                        var aiomatic_newline_before = false;
                        var aiomatic_response_events = 0;
                        var aiomatic_limitLines = 1;
                        var resultData = null;
                        var hasFinishReason = false;
                        if(e.data == '[DONE]')
                        {
                            hasFinishReason = true;
                        }
                        else
                        {
                            try 
                            {
                                resultData = JSON.parse(e.data);
                            } 
                            catch (e) 
                            {
                                console.warn(e);
                                aiomaticRmLoading(aiomaticGenerateBtn);
                                aiomatic_generator_working = false;
                                eventGenerator.close();
                                return;
                            }
                            hasFinishReason = resultData &&
                            (resultData.finish_reason === "stop" ||
                            resultData.finish_reason === "length");
                            if(resultData.stop_reason == 'stop_sequence' || resultData.stop_reason == 'max_tokens')
                            {
                                hasFinishReason = true;
                            }
                        }
                        var content_generated = '';
                        if(hasFinishReason){
                            count_line += 1;
                            aiomatic_response_events = 0;
                        }
                        else
                        {
                            if(resultData !== null)
                            {
                                var result = resultData;
                            }
                            else
                            {
                                var result = null;
                                try {
                                    result = JSON.parse(e.data);
                                } 
                                catch (e) 
                                {
                                    console.warn(e);
                                    aiomaticRmLoading(aiomaticGenerateBtn);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    return;
                                };
                            }
                            if(result.error !== undefined){
                                error_generated = result.error[0].message;
                                if(error_generated === undefined)
                                {
                                    error_generated = result.error.message;
                                }
                                if(error_generated === undefined)
                                {
                                    error_generated = result.error;
                                }
                                console.log('Error while processing request(1): ' + error_generated);
                                jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                                jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                                aiomaticRmLoading(aiomaticGenerateBtn);
                                aiomatic_generator_working = false;
                                eventGenerator.close();
                                return;
                            }
                            else
                            {
                                if(result.completion !== undefined)
                                {
                                    content_generated = result.completion;
                                }
                                else if(result.content[0].text !== undefined)
                                {
                                    content_generated = result.content[0].text;
                                }
                                else
                                {
                                    content_generated = '';
                                }
                            }
                            response_data += aiomatic_nl2br(content_generated);
                            if((content_generated === '\n' || content_generated === ' \n' || content_generated === '.\n' || content_generated === '\n\n' || content_generated === '.\n\n' || content_generated === '"\n') && aiomatic_response_events > 0){
                                if(!aiomatic_newline_before) {
                                    aiomatic_newline_before = true;
                                }
                            }
                            else if(content_generated === '\n' && aiomatic_response_events === 0){

                            }
                            else{
                                aiomatic_newline_before = false;
                                aiomatic_response_events += 1;
                                aiomaticSetContent(dataId, response_data);
                            }
                        }
                        if(count_line >= aiomatic_limitLines)
                        {
                            eventGenerator.close();
                            aiomatic_generator_working = false;
                            jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                            aiomaticRmLoading(aiomaticGenerateBtn);
                        }
                    }
                }
                function handleMessageEvent(e)
                {
                    var hasFinishReason = false;
                    if(model_type != 'claude')
                    {
                        var aiomatic_newline_before = false;
                        var aiomatic_response_events = 0;
                        var aiomatic_limitLines = 1;
                        var resultData = null;
                        if(e.data == '[DONE]')
                        {
                            hasFinishReason = true;
                        }
                        else
                        {
                            if(model_type != 'google')
                            {
                                try 
                                {
                                    resultData = JSON.parse(e.data);
                                } 
                                catch (e) 
                                {
                                    console.warn(e);
                                    aiomaticRmLoading(aiomaticGenerateBtn);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    return;
                                }
                                hasFinishReason = resultData.choices &&
                                resultData.choices[0] &&
                                (resultData.choices[0].finish_reason === "stop" ||
                                resultData.choices[0].finish_reason === "length");
                            }
                        }
                        if(model_type != 'google')
                        {
                            var content_generated = '';
                            if(hasFinishReason){
                                count_line += 1;
                                aiomatic_response_events = 0;
                            }
                            else
                            {
                                var result = null;
                                try {
                                    result = JSON.parse(e.data);
                                } 
                                catch (e) 
                                {
                                    console.warn(e);
                                    aiomaticRmLoading(aiomaticGenerateBtn);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    return;
                                };
                                if(result.error !== undefined){
                                    error_generated = result.error[0].message;
                                    if(error_generated === undefined)
                                    {
                                        error_generated = result.error.message;
                                    }
                                    if(error_generated === undefined)
                                    {
                                        error_generated = result.error;
                                    }
                                    console.log('Error while processing request(2): ' + error_generated);
                                    jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                                    jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                                    aiomaticRmLoading(aiomaticGenerateBtn);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    return;
                                }
                                else
                                {
                                    if(model_type == 'huggingface')
                                    {
                                        if (result.generated_text)
                                        {
                                            var hasFinishReason = true;
                                            count_line += 1;
                                            aiomatic_response_events = 0;
                                        }
                                        else
                                        {
                                            content_generated = result.token.text;
                                        }
                                    }
                                    else
                                    {
                                        content_generated = result.choices[0].delta !== undefined ? (result.choices[0].delta.content !== undefined ? result.choices[0].delta.content : '') : result.choices[0].text;
                                    }
                                }
                                response_data += aiomatic_nl2br(content_generated);
                                if((content_generated === '\n' || content_generated === ' \n' || content_generated === '.\n' || content_generated === '\n\n' || content_generated === '.\n\n' || content_generated === '"\n') && aiomatic_response_events > 0){
                                    if(!aiomatic_newline_before) {
                                        aiomatic_newline_before = true;
                                    }
                                }
                                else if(content_generated === '\n' && aiomatic_response_events === 0){
                                    
                                }
                                else if(response_data == '')
                                {
                                    aiomatic_newline_before = false;
                                    aiomatic_response_events += 1;
                                }
                                else{
                                    aiomatic_newline_before = false;
                                    aiomatic_response_events += 1;
                                    aiomaticSetContent(dataId, response_data);
                                }
                            }
                        }
                        else
                        {
                            if(hasFinishReason){
                                count_line += 1;
                                aiomatic_response_events = 0;
                            }
                            if(e.data == '[ERROR]')
                            {
                                error_generated = 'Failed to get form response!';
                                console.log('Error while processing request: ' + error_generated);
                                jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                                jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                                count_line += 1;
                            }
                            else
                            {
                                if(e.data !== '[DONE]')
                                {
                                    response_data += aiomatic_nl2br(e.data);
                                    aiomatic_response_events += 1;
                                    aiomaticSetContent(dataId, response_data);
                                }
                            }
                        }
                        if(count_line >= aiomatic_limitLines)
                        {
                            eventGenerator.close();
                            aiomatic_generator_working = false;
                            jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                            aiomaticRmLoading(aiomaticGenerateBtn);
                        }
                    }
                };
                eventGenerator.onerror = handleErrorEvent;
                function handleErrorEvent(e) 
                {
                    console.log('Halting execution, EventGenerator error: ' + JSON.stringify(e));
                    jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                    jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text" role="status">Failed to process response, please try again later.</div>');
                    aiomaticRmLoading(aiomaticGenerateBtn);
                    aiomatic_generator_working = false;
                    eventGenerator.close();
                    return;
                };
            }
            else
            {
                jQuery.ajax({
                    type: 'POST',
                    url: aiomatic_completition_ajax_object.ajax_url,
                    data: {
                        action: 'aiomatic_form_submit',
                        input_text: prompt,
                        nonce: aiomatic_completition_ajax_object.nonce,
                        model: model,
                        assistant_id: assistant_id,
                        temp: temperature,
                        top_p: top_p,
                        presence: presence_penalty,
                        aiomaticType: aiomaticType,
                        frequency: frequency_penalty,
                        user_token_cap_per_day: '',
                        user_id: aiomatic_completition_ajax_object.user_id
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
                            if(response.data == '')
                            {
                                jQuery('#openai-response' + dataId).html('<div class="text-primary" role="status">AI considers this as the end of the text. Please try using a different text input.</div>');
                            }
                            else
                            {
                                jQuery('#openai-response' + dataId).html('');
                                if(aiomaticType == 'text')
                                {
                                    aiomaticSetContent(dataId, response.data);
                                }
                                else
                                {
                                    if(aiomaticType == 'image' || aiomaticType == 'image-new' || aiomaticType == 'image-mid')
                                    {
                                        downloadButton.attr("href", aiomatichtmlDecode(response.data));
                                        downloadButton.show();
                                        jQuery("#aiomatic_form_response" + dataId).attr("src", aiomatichtmlDecode(response.data)).fadeIn();
                                    }
                                    else
                                    {
                                        downloadButton.attr("href", "data:image/gif;base64," + aiomatichtmlDecode(response.data));
                                        downloadButton.show();
                                        jQuery("#aiomatic_form_response" + dataId).attr("src", "data:image/gif;base64," + aiomatichtmlDecode(response.data)).fadeIn();
                                    }
                                }
                            }
                        }
                        else
                        {
                            if(typeof response.msg !== 'undefined')
                            {
                                jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                                console.log('Error in processing: ' + response.msg);
                                jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                            }
                            else
                            {
                                console.log('Error: ' + response);
                                jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                                jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                            }
                        }
                        aiomaticRmLoading(aiomaticGenerateBtn);
                    },
                    error: function(error) {
                        console.log('Error: ' + error.responseText);
                        jQuery("#aiomatic_form_response" + dataId).attr("src", '').fadeIn();
                        // Clear the response container
                        jQuery('#openai-response' + dataId).html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
                        aiomaticRmLoading(aiomaticGenerateBtn);
                    },
                });
            }
        }
    });
});