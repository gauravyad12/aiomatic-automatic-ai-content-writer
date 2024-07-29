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
jQuery('#button-start-moderation').on('click', function (e){
    e.preventDefault();
    var error_message = false;
    var inputv = jQuery('#aiomatic_moderation_input');
    if(inputv.val() === ''){
        error_message = 'Please enter a text to moderate!';
    }
    if(error_message){
        alert(error_message)
    }
    else{
        aiomaticModerate(inputv.val());
    }
    return false;
});

function aiomaticModerate(text){
    var btn = jQuery('#button-start-moderation');
    var aiomatic_error_message = jQuery('#aiomatic-error-msg');
    var aiomatic_upload_success = jQuery('#aiomatic_moderation_success');
    var aiomatic_progress = jQuery('#aiomatic_progress');
    var data = {
        action: 'aiomatic_moderate_text',
        text: text,
        nonce: aiomatic_moderation_object.nonce
    };
    jQuery.ajax({
        url: aiomatic_moderation_object.ajax_url,
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
            if (res.status === 'success') {
                aiomaticRmLoading(btn);
                aiomatic_progress.hide();
                aiomatic_upload_success.show();
                aiomatic_upload_success.css('visibility','visible');
                var obj = JSON.parse(res.data);
                var pretty = JSON.stringify(obj, undefined, 4);
                jQuery('#aiomatic_moderation_result').text(pretty);
            } else {
                aiomaticRmLoading(btn);
                aiomatic_progress.find('small').html('Error');
                aiomatic_progress.addClass('aiomatic_error');
                aiomatic_error_message.html(res.msg);
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