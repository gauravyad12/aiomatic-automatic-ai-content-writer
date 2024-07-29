"use strict";
jQuery(document).ready(function(){
function aiomaticLoading(btn){
    btn.attr('disabled','disabled');
    if(!btn.find('spinner').length){
        btn.append('<span class="spinner"></span>');
    }
    btn.find('.spinner').css('visibility','unset');
}
function aiomaticRmLoading(btn){
    btn.removeAttr('disabled');
    btn.find('.spinner').remove();
}
jQuery('#button-start-aidetector').on('click', function (e){
    e.preventDefault();
    var error_message = false;
    var inputv = jQuery('#aiomatic_aidetector_input');
    if(inputv.val() === ''){
        error_message = 'Please enter a text to check!';
    }
    if(error_message){
        alert(error_message)
    }
    else{
        aiomaticCheckPlagiation(inputv.val());
    }
    return false;
});

function aiomaticCheckPlagiation(text){
    var btn = jQuery('#button-start-aidetector');
    var aiomatic_error_message = jQuery('#aiomatic-error-msg-aidetector');
    var aiomatic_upload_success = jQuery('#aiomatic_aidetector_success');
    var aiomatic_progress = jQuery('#aiomatic_progress');
    var data = {
        action: 'aiomatic_aidetector_check_text',
        text: text,
        nonce: aiomatic_aidetector_object.nonce
    };
    jQuery.ajax({
        url: aiomatic_aidetector_object.ajax_url,
        data: data,
        type: 'POST',
        xhr: function () {
            var xhr = jQuery.ajaxSettings.xhr();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    aiomatic_progress.find('span').css('width', (Math.round(percentComplete * 100)) + '%');
                }
            }, false);
            return xhr;
        },
        beforeSend: function () {
            aiomatic_progress.find('span').css('width', '0');
            aiomatic_progress.show();
            aiomatic_progress.css('visibility','visible');
            aiomaticLoading(btn);
            aiomatic_error_message.hide();
            aiomatic_upload_success.hide();
        },
        success: function (res) {
            if (res.success == true) 
            {
                console.log('Success ' + JSON.stringify(res));
                aiomaticRmLoading(btn);
                aiomatic_progress.hide();
                aiomatic_upload_success.show();
                aiomatic_upload_success.css('visibility','visible');
                var percentage = res.data.result.percentage;
                var sourceText = res.data.result.report;
                if(sourceText == '')
                {
                    sourceText = 'No conclusion resulted after the check';
                }
                if(Array.isArray(res.data.result.detected_chunks) && res.data.result.detected_chunks.length > 0)
                {
                    sourceText += '\n\n' + 'Detected AI content chunks:';
                    var chunkid = 1;
                    res.data.result.detected_chunks.forEach(element => {
                        sourceText += '\n\n' + 'Chunk ID: ' + chunkid + '\n' + element;
                        chunkid++;
                    });
                }
                jQuery('#aiomatic_aidetector_result').text(sourceText);
                jQuery('#aiomatic_aidetector_percentage').val('Conclusion confidence percentage: ' + percentage + '%');
                aiomatic_error_message.html('');
                aiomatic_error_message.hide();
            } 
            else 
            {
                aiomaticRmLoading(btn);
                aiomatic_progress.find('small').html('Error');
                aiomatic_progress.addClass('aiomatic_error');
                aiomatic_error_message.html(res.data.message);
                aiomatic_error_message.show();
                aiomatic_error_message.css('visibility','visible');
            }
        },
        error: function () {
            aiomaticRmLoading(btn);
            aiomatic_progress.addClass('aiomatic_error');
            aiomatic_progress.find('small').html('Error');
            aiomatic_error_message.html('Please try again');
            aiomatic_error_message.show();
            aiomatic_error_message.css('visibility','visible');
        }
    });
}
});