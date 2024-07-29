"use strict";
function openaifunct() {
    jQuery('#aisubmitbut').attr('disabled', true);
    var input_text = jQuery('#aiomatic_input').html();
    if(input_text == '')
    {
        jQuery('#aisubmitbut').attr('disabled', false);
        jQuery('#openai-response').html('<div class="text-primary highlight-text-fail" role="status">Please add a text in the input field.</div>');
        console.log('Input cannot be empty.');
        return;
    }
    // Show the loading animation
    jQuery('#openai-response').html('<div class="automaticx-dual-ring"></div>');
    var model = aiomatic_completition_ajax_object.model;
    var temp = aiomatic_completition_ajax_object.temp;
    var top_p = aiomatic_completition_ajax_object.top_p;
    var presence = aiomatic_completition_ajax_object.presence;
    var frequency = aiomatic_completition_ajax_object.frequency;
    var user_token_cap_per_day = aiomatic_completition_ajax_object.user_token_cap_per_day;
    var user_id = aiomatic_completition_ajax_object.user_id;
    if(model == 'default' || model == '')
    {
        model = jQuery( "#model-selector option:selected" ).text();
    }
    if(temp == 'default' || temp == '')
    {
        temp = jQuery('#temperature-input').val();
    }
    if(top_p == 'default' || top_p == '')
    {
        top_p = jQuery('#top_p-input').val();
    }
    if(presence == 'default' || presence == '')
    {
        presence = jQuery('#presence-input').val();
    }
    if(frequency == 'default' || frequency == '')
    {
        frequency = jQuery('#frequency-input').val();
    }
    var assistant_id = jQuery('#aix-assistant-id').val();
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_completition_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_form_submit',
            input_text: input_text,
            nonce: aiomatic_completition_ajax_object.nonce,
            model: model,
            assistant_id: assistant_id,
            temp: temp,
            top_p: top_p,
            presence: presence,
            user_token_cap_per_day: user_token_cap_per_day,
            frequency: frequency,
            user_id: user_id
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
                    jQuery('#openai-response').html('<div class="text-primary" role="status">AI considers this as the end of the text. Please try using a different text input.</div>');
                }
                else
                {
                    jQuery('#openai-response').html('<div class="openchat-dots-bars-2"></div>');
                    var i = 0;
                    response.data = response.data.replace(/\n/g, '<br>');
                    function typeWriter() {
                        if (i < response.data.length) {
                            // Append the response to the input field
                            jQuery('#aiomatic_input').html(input_text + '<span class="highlight-green">' + response.data.substring(0, i + 1) + '</span>');
                            i++;
                            setTimeout(typeWriter, 50);
                        } else {
                            // Clear the response container
                            jQuery('#openai-response').html('');
                            // Enable the submit button
                            jQuery('#aisubmitbut').attr('disabled', false);
                        }
                    }
                    typeWriter();
                }
            }
            else
            {
                if(typeof response.msg !== 'undefined')
                {
                    jQuery('#openai-response').html('<div class="text-primary highlight-text-fail" role="status">' + response.msg + '</div>');
                }
                else
                {
                    console.log('Error: ' + response);
                    jQuery('#openai-response').html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                }
            }
            jQuery('#aisubmitbut').attr('disabled', false);
        },
        error: function(error) {
            console.log('Error: ' + error.responseText);
            // Clear the response container
            jQuery('#openai-response').html('<div class="text-primary highlight-text-fail" role="status">Failed to generate content, try again later.</div>');
            // Enable the submit button
            jQuery('#aisubmitbut').attr('disabled', false);
        },
    });
}

function getCaretCharacterOffsetWithin(element) {
    var caretOffset = 0;
    var doc = element.ownerDocument || element.document;
    var win = doc.defaultView || doc.parentWindow;
    var sel;
    if (typeof win.getSelection != "undefined") {
        sel = win.getSelection();
        if (sel.rangeCount > 0) {
            var range = win.getSelection().getRangeAt(0);
            var preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(element);
            preCaretRange.setEnd(range.endContainer, range.endOffset);
            caretOffset = preCaretRange.toString().length;
        }
    } else if ((sel = doc.selection) && sel.type != "Control") {
        var textRange = sel.createRange();
        var preCaretTextRange = doc.body.createTextRange();
        preCaretTextRange.moveToElementText(element);
        preCaretTextRange.setEndPoint("EndToEnd", textRange);
        caretOffset = preCaretTextRange.text.length;
    }
    return caretOffset;
}

// Function to get the current cursor position in an element
function aigetCursorPos(el) {
    var range = window.getSelection().getRangeAt(0);
    var preCaretRange = range.cloneRange();
    preCaretRange.selectNodeContents(el);
    preCaretRange.setEnd(range.endContainer, range.endOffset);
    return preCaretRange.toString().length;
}

// Function to set the cursor position in an element
function aisetCursorPos(el, pos) {
    var range = document.createRange();
    var sel = window.getSelection();
    var inputText = el.innerText;
    // Check if the cursor position is over the length of the input text
    if (pos > inputText.length) {
        pos = inputText.length;
    }
    var currentPos = 0;
    // Iterate through the child nodes to find the node where the cursor position is
    for (var i = 0; i < el.childNodes.length; i++) {
        var childNode = el.childNodes[i];
        if (currentPos + childNode.length >= pos) {
            // Set the cursor position in the current child node
            range.setStart(childNode, pos - currentPos);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
            break;
        } else {
            currentPos += childNode.length;
        }
    }
}

var recognition;
var recognizing = false;
var aidecodeHtmlEntity = function(str) {
    return str.replace(/&#(\d+);/g, function(match, dec) {
        return String.fromCharCode(dec);
    });
};

jQuery(document).ready(function() {
    jQuery('#copy-button').on('click', function() {
        var jsf = jQuery("#aiomatic_input").clone() 
        .find("br").replaceWith("\n")   
        .end() 
        .text();
        if(navigator.clipboard !== undefined)
        {
            navigator.clipboard.writeText(jsf);
        }
    });
    jQuery('#aiomatic_input').on('keydown', function() {
        var inputText = this.innerHTML;
        if (inputText.includes('class="highlight-green"')) {
            var restore = saveCaretPosition(this);
            var strippedInputText = inputText.replace(/class="highlight-green"/g, 'class="highlight-none"');
            this.innerHTML = strippedInputText;
            restore();
        }
    });

    function saveCaretPosition(context) {
        var selection = window.getSelection();
        var range = selection.getRangeAt(0);
        range.setStart(context, 0);
        var len = range.toString().length;

        return function restore() {
            var pos = getTextNodeAtPosition(context, len);
            selection.removeAllRanges();
            var range = new Range();
            range.setStart(pos.node, pos.position);
            selection.addRange(range);

        }
    }

    function getTextNodeAtPosition(root, index) {
        const NODE_TYPE = NodeFilter.SHOW_TEXT;
        var treeWalker = document.createTreeWalker(root, NODE_TYPE, function next(elem) {
            if (index > elem.textContent.length) {
                index -= elem.textContent.length;
                return NodeFilter.FILTER_REJECT
            }
            return NodeFilter.FILTER_ACCEPT;
        });
        var c = treeWalker.nextNode();
        return {
            node: c ? c : root,
            position: index
        };
    }
    if(!jQuery('#aiomatic_completion_templates').length)
    {
        // Check if the browser supports the Web Speech API
        if ('webkitSpeechRecognition' in window) {
            recognition = new webkitSpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;

            // Start the speech recognition when the button is clicked
            jQuery('#openai-speech-button').on('click', function() {
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
                        jQuery('#aiomatic_input').append(event.results[i][0].transcript);
                    }
                }
            };
        }
    }
    else
    {
        jQuery('#aiomatic_completion_templates').on('change', function()
        {
            jQuery('#aiomatic_input').html(jQuery( "#aiomatic_completion_templates" ).val());
        });
    }
});