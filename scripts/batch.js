"use strict";
function aiomaticTimeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours() < 10 ? '0' + a.getHours() : a.getHours();
    var min = a.getMinutes() < 10 ? '0' + a.getMinutes() : a.getMinutes();
    var sec = a.getSeconds() < 10 ? '0' + a.getSeconds() : a.getSeconds();
    var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
    return time;
}
function aiomaticLoading2(btn){
    btn.attr('disabled','disabled');
    if(!btn.find('spinner').length){
        btn.append('<span class="spinner"></span>');
    }
    btn.find('.spinner').css('visibility','unset');
}
function aiomaticRmLoading(btn)
{
    btn.removeAttr('disabled');
    btn.find('.spinner').remove();
}
jQuery(document).ready(function()
{
    function initializeCarousel() {
        var currentIndex = 0;
        var $items = jQuery('.aiomatic-carousel-item');
        var itemCount = $items.length;
    
        function showItem(index) {
            $items.hide();
            $items.eq(index).show();
            jQuery('#aiomatic-paging-holder').html((index + 1) + '/' + itemCount);
        }
    
        jQuery('.aiomatic-carousel-prev').on('click', function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : itemCount - 1;
            showItem(currentIndex);
        });
    
        jQuery('.aiomatic-carousel-next').on('click', function() {
            currentIndex = (currentIndex < itemCount - 1) ? currentIndex + 1 : 0;
            showItem(currentIndex);
        });
        showItem(currentIndex);
    }

    jQuery('body').on('click', '.aiomatic_download_file', function() {
        var dataID = jQuery(this).attr('data-id');
        if(dataID != '')
        {
            var btn = jQuery(this);
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_download_file', id: dataID, nonce: aiomatic_object.nonce},
                type: 'POST',
                beforeSend: function () {
                    aiomaticAjaxRunning = true;
                    aiomaticLoading2(btn);
                },
                success: function (res) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    if (res.status !== 'success') 
                    {
                        alert('Error in processing: ' + JSON.stringify(res));
                    }
                    else
                    {
                        var hiddenElement = document.createElement('a');
                        hiddenElement.href = 'data:attachment/text,' + encodeURI(res.data);
                        hiddenElement.target = '_blank';
                        hiddenElement.download = res.filename;
                        hiddenElement.click();
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing file download: ' + error);
                }
            });
        }
        else
        {
            alert('Empty data-id provided');
        }
    });
    jQuery('body').on('click', '.aiomatic_parse_output', function() {
        var dataID = jQuery(this).attr('data-id');
        var dataInID = jQuery(this).attr('data-in-id');
        var endpoint = jQuery(this).attr('endpoint');
        if(dataID != '' && dataInID != '')
        {
            document.getElementById('mymodalfzr-parse').style.display = "block";
            var btn = jQuery(this);
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_parse_output', id: dataID, idin: dataInID, endpoint: endpoint, nonce: aiomatic_object.nonce},
                type: 'POST',
                beforeSend: function () {
                    jQuery('#aiomatic-batch-result-parsed').html(aiomatic_object.loadingstr);
                    aiomaticAjaxRunning = true;
                    aiomaticLoading2(btn);
                },
                success: function (res) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    if (res.status !== 'success') 
                    {
                        alert('Error in processing: ' + JSON.stringify(res));
                    }
                    else
                    {
                        jQuery('#aiomatic-batch-result-parsed').html(res.data);
                        initializeCarousel();
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing file parsing: ' + error);
                }
            });
        }
        else
        {
            alert('Empty data-id or data-in-id provided');
        }
    });
    jQuery('body').on('click', '.aiomatic_delete_file', function() {
        var dataID = jQuery(this).attr('data-id');
        if(dataID != '')
        {
            var btn = jQuery(this);
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_delete_assistant_file', id: dataID, nonce: aiomatic_object.nonce},
                type: 'POST',
                beforeSend: function () {
                    aiomaticAjaxRunning = true;
                    aiomaticLoading2(btn);
                },
                success: function (res) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    if (res.status !== 'success') 
                    {
                        alert('Error in processing: ' + JSON.stringify(res));
                    }
                    else
                    {
                        location.reload();
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing file delete: ' + error);
                }
            });
        }
        else
        {
            alert('Empty data-id provided');
        }
    });
    jQuery('body').on('click', '#aiomatic_file_button', function() {
        var aiomatic_file_upload = jQuery('#aiomatic_batch_file_upload');
        if(aiomatic_file_upload[0].files.length === 0){
            alert('Please select a file!');
        }
        else{
            var aiomatic_max_file_size = aiomatic_object.maxfilesize;
            var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
            var aiomatic_progress = jQuery('.aiomatic_progress');
            var aiomatic_file_button = jQuery('#aiomatic_file_button');
            var aiomatic_file = aiomatic_file_upload[0].files[0];
            var aiomatic_upload_success = jQuery('.aiomatic_upload_success');
            var aiomatic_error_message = jQuery('.aiomatic-error-msg');
            if(aiomatic_file.size > aiomatic_max_file_size){
                aiomatic_file_upload.val('');
                alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
            }
            else{
                var formData = new FormData();
                formData.append('action', 'aiomatic_batch_file_upload');
                formData.append('file', aiomatic_file);
                formData.append('nonce', aiomatic_object.nonce);
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    beforeSend: function (){
                        aiomatic_progress.find('span').css('width','0');
                        aiomatic_progress.show();
                        aiomaticLoading2(aiomatic_file_button);
                        aiomatic_error_message.hide();
                        aiomatic_upload_success.hide();
                    },
                    xhr: function() {
                        var xhr = jQuery.ajaxSettings.xhr();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                aiomatic_progress.find('span').css('width',(Math.round(percentComplete * 100))+'%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(res) {
                        if(res.status === 'success'){
                            aiomaticRmLoading(aiomatic_file_button);
                            aiomatic_progress.hide();
                            aiomatic_file_upload.val('');
                            aiomatic_upload_success.show();
                            location.reload();
                        }
                        else{
                            aiomaticRmLoading(aiomatic_file_button);
                            aiomatic_progress.find('small').html('Error');
                            aiomatic_progress.addClass('aiomatic_error');
                            aiomatic_error_message.html(res.msg);
                            aiomatic_error_message.show();
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function (r, s, error){
                        aiomatic_file_upload.val('');
                        aiomaticRmLoading(aiomatic_file_button);
                        aiomatic_progress.addClass('aiomatic_error');
                        aiomatic_progress.find('small').html('Error');
                        alert('Error in processing batch file uploading: ' + error);
                        aiomatic_error_message.show();
                    }
                });
            }
        }
    });
    var assistent_files = [];
    var assistent_files_input = [];
    var aiomaticAjaxRunning = false;
    jQuery('#aiomatic_sync_batch_files').on('click', function (e){
        e.preventDefault();
        jQuery("#aiomatic-batch-files > tbody").empty();
        var btn = jQuery(this);
        if(!aiomaticAjaxRunning) {
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_list_batch_files', nonce: aiomatic_object.nonce},
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function () {
                    aiomaticAjaxRunning = true;
                    aiomaticLoading2(btn);
                },
                success: function (res) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    if (res.status === 'success') 
                    {
                        assistent_files = Object.values(res.data);
                        assistent_files.forEach(async (tfile) => 
                        {
                            if(tfile.purpose == 'batch')
                            {
                                assistent_files_input.push(tfile);
                            }
                            var appendme = '<tr><td>' + tfile.id + '</td><td>' + tfile.bytes + '</td><td>' + tfile.purpose + '</td><td>' + aiomaticTimeConverter(tfile.created_at) + '</td><td>' + tfile.filename + '</td><td>' + tfile.status + '</td><td><button data-id="' + tfile.id + '" class="button button-small aiomatic_download_file"';
                            appendme += '>Download</button><button data-id="' + tfile.id + '" class="button button-small button-link-delete aiomatic_delete_file">Delete</button></td></tr>';
                            jQuery('#aiomatic-batch-files > tbody:last-child').append(appendme);
                        });
                        aiomatic_refresh_options();
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing file sync: ' + error);
                }
            });
        }
    });
    jQuery( "#aiomatic_sync_batch_files" ).trigger( "click" );
    function aiomatic_refresh_options()
    {
        jQuery('#aiomatic-batch-file').find('option').remove();
        assistent_files_input.forEach(async (tfile) => {
            jQuery("#aiomatic-batch-file").append(jQuery('<option>', {
                value: tfile.id,
                text: tfile.filename + ' (' + tfile.id + ')'
            }));
        });
        if(assistent_files_input.length == 0)
        {
            jQuery("#aiomatic-batch-file").append(jQuery('<option>', {
                value: '',
                disabled: 'disabled',
                text: "Please upload files in the 'Manage AI Batch Requests Files' tab to use this option"
            }));
        }
    }
    jQuery(".aiomatic_cancel_batch").on('click', function(e) {
        e.preventDefault();
        var batchid = jQuery(this).attr("edit-id");
        if(batchid == '')
        {
            alert('Incorrect edit id submitted');
        }
        else
        {
            var data = {
                action: 'aiomatic_cancel_batch',
                batchid: batchid,
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    if(res.status === 'success'){
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing batch viewing: ' + error);
                }
            });
        }
    });
    jQuery(".aiomatic_view_batch").on('click', function(e) {
        e.preventDefault();
        var batchid = jQuery(this).attr("edit-id");
        if(batchid == '')
        {
            alert('Incorrect edit id submitted');
        }
        else
        {
            jQuery('#batch-window').html(aiomatic_object.loadingstr);
            jQuery('#batch-id').html(aiomatic_object.loadingstr);
            jQuery('#batch-status').html(aiomatic_object.loadingstr);
            jQuery('#batch-endpoint').html(aiomatic_object.loadingstr);
            jQuery('#batch-counts').html(aiomatic_object.loadingstr);
            jQuery('#batch-created').html(aiomatic_object.loadingstr);
            jQuery('#batch-input-file').html(aiomatic_object.loadingstr);
            jQuery('#batch-output-file').html(aiomatic_object.loadingstr);
            jQuery('#batch-error-file').html(aiomatic_object.loadingstr);
            jQuery('#batch-timeline-wrapper').html(aiomatic_object.loadingstr);
            jQuery('#batch-failed-report').html('');

            document.getElementById('mymodalfzr-edit').style.display = "block";
            var data = {
                action: 'aiomatic_get_batch',
                batchid: batchid,
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    if(res.status === 'success'){
                        if(res.data !== undefined)
                        {
                            jQuery('#batch-window').html(res.data['batch_completion_window']);
                            jQuery('#batch-id').html('<a href="https://platform.openai.com/batches/' + res.data['batch_id'] + '" target="_blank">' + res.data['batch_id'] + '</a>');
                            if(res.data['batch_status'] == 'failed')
                            {
                                var failed_report = '<hr/>';
                                if (res.data['batch_errors'])
                                {
                                    res.data['batch_errors'].data.forEach(error => 
                                    {
                                        failed_report += `<span class="cr_red">Line: ${error.line}</span>&nbsp;${error.message}<br/>`;
                                    });
                                }
                                jQuery('#batch-failed-report').html(failed_report);
                                jQuery('#batch-status').html(res.data['batch_status']);
                            }
                            else
                            {
                                jQuery('#batch-status').html(res.data['batch_status']);
                            }
                            jQuery('#batch-endpoint').html(res.data['batch_endpoint']);
                            jQuery('#batch-counts').html('<span>Completed:</span>&nbsp;' + res.data['batch_request_completed'] + '&nbsp;&nbsp;&nbsp;<span>Failed:</span>&nbsp;' + res.data['batch_request_failed'] + '&nbsp;&nbsp;&nbsp;<span>Total:</span>&nbsp;' + res.data['batch_request_count'] + '&nbsp;');
                            jQuery('#batch-created').html(aiomaticTimeConverter(res.data['batch_created_at']));
                            jQuery('#batch-input-file').html('<a href="https://platform.openai.com/storage/files/' + res.data['batch_input_file_id'] + '" target="_blank">' + res.data['batch_input_file_id'] + '</a>&nbsp;<button data-id="' + res.data['batch_input_file_id'] + '" class="button button-small aiomatic_download_file">Download</button>');
                            if (res.data['batch_output_file_id']) 
                            {
                                jQuery('#batch-output-file').html('<a href="https://platform.openai.com/storage/files/' + res.data['batch_output_file_id'] + '" target="_blank">' + res.data['batch_output_file_id'] + '</a>&nbsp;<button data-id="' + res.data['batch_output_file_id'] + '" class="button button-small aiomatic_download_file">Download</button>&nbsp;<button data-id="' + res.data['batch_output_file_id'] + '" data-in-id="' + res.data['batch_input_file_id'] + '" endpoint="' + res.data['batch_endpoint'] + '" class="button button-small aiomatic_parse_output">Parse Output</button>');
                            }
                            else
                            {
                                jQuery('#batch-output-file').html('');
                            }
                            if (res.data['batch_error_file_id']) 
                            {
                                jQuery('#batch-error-file').html('<a href="https://platform.openai.com/storage/files/' + res.data['batch_error_file_id'] + '" target="_blank">' + res.data['batch_error_file_id'] + '</a>&nbsp;<button data-id="' + res.data['batch_error_file_id'] + '" class="button button-small aiomatic_download_file">Download</button>');
                            }
                            else
                            {
                                jQuery('#batch-error-file').html('');
                            }
                            var timestr = aiomatic_object.createdstr + ' ' + aiomaticTimeConverter(res.data['batch_created_at']);
                            if (res.data['batch_in_progress_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.progressstr + ' ' + aiomaticTimeConverter(res.data['batch_in_progress_at']);
                            }
                            if (res.data['batch_cancelling_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.cancellingstr + ' ' + aiomaticTimeConverter(res.data['batch_cancelling_at']);
                            }
                            if (res.data['batch_cancelled_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.cancelledstr + ' ' + aiomaticTimeConverter(res.data['batch_cancelled_at']);
                            }
                            if (res.data['batch_finalizing_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.finalizingstr + ' ' + aiomaticTimeConverter(res.data['batch_finalizing_at']);
                            }
                            if (res.data['batch_completed_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.completedstr + ' ' + aiomaticTimeConverter(res.data['batch_completed_at']);
                                const date = new Date(null);
                                date.setSeconds(res.data['batch_completed_at'] - res.data['batch_created_at']);
                                const resulttime = date.toISOString().slice(11, 19);
                                timestr += '<br/>' + aiomatic_object.completedinstr + ' ' + resulttime;
                            }
                            if (res.data['batch_failed_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.failedstr + ' ' + aiomaticTimeConverter(res.data['batch_failed_at']);
                            }
                            if (res.data['batch_expired_at'])
                            {
                                timestr += '<br/>' + aiomatic_object.expiredstr + ' ' + aiomaticTimeConverter(res.data['batch_expired_at']);
                            }
                            jQuery('#batch-timeline-wrapper').html(timestr);
                        }
                        else
                        {
                            alert('Incorrect response from the back end!');
                        }
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing batch viewing: ' + error);
                }
            });
        }
    });
    jQuery('#aiomatic_sync_batches').on('click', function (e)
    {
        e.preventDefault();
        var btn = jQuery(this);
        aiomaticLoading2(btn);
        var data = {
            action: 'aiomatic_sync_batches',
            nonce: aiomatic_object.nonce,
        };
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res){
                aiomaticRmLoading(btn);
                if(res.status === 'success'){
                    jQuery('.aiomatic-batch-success').show();
                    setTimeout(function (){
                        jQuery('.aiomatic-batch-success').hide();
                    },2000);
                    location.reload();
                }
                else{
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                aiomaticRmLoading(btn);
                alert('Error in processing batch requests sync: ' + error);
            }
        });
    });
    jQuery('#aiomatic_delete_all_batches').on('click', function (e)
    {
        e.preventDefault();
        if(confirm('Are you sure you want to delete all locally stored AI Batch Requests?'))
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var data = {
                action: 'aiomatic_delete_all_batches',
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        jQuery('.aiomatic-batch-success').show();
                        setTimeout(function (){
                            jQuery('.aiomatic-batch-success').hide();
                        },2000);
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing batch requests sync: ' + error);
                }
            });
        }
    });
    jQuery(".aiomatic_sync_batch").on('click', function(e) {
        e.preventDefault();
        var batchid = jQuery(this).attr("sync-id");
        if(batchid == '')
        {
            alert('Incorrect sync id submitted');
        }
        else
        {
            var data = {
                action: 'aiomatic_sync_batch',
                batchid: batchid,
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading2(jQuery('#aiomatic_sync_batch_' + batchid));
                },
                success: function (res){
                    if(res.status === 'success'){
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                        aiomaticRmLoading(jQuery('#aiomatic_sync_batch_' + batchid));
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing batch sync by id: ' + error);
                    aiomaticRmLoading(jQuery('#aiomatic_sync_batch_' + batchid));
                }
            });
        }
    });
    jQuery('#aiomatic_batches_form').on('submit', function (e)
    {
        e.preventDefault();
        var form = jQuery('#aiomatic_batches_form');
        var btn = form.find('#aiomatic-batch-save-button');
        var data = form.serialize();
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            beforeSend: function (){
                aiomaticLoading2(btn);
            },
            success: function (res){
                aiomaticRmLoading(btn);
                if(res.status === 'success'){
                    jQuery('.aiomatic-batch-success').html("AI Batch Request saved successfully!");
                    jQuery('.aiomatic-batch-success').show();
                    location.reload();
                }
                else{
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                aiomaticRmLoading(btn);
                alert('Error in processing AI Batch Request saving: ' + error);
            }
        });
        return false;
    });
    var codemodalfzr = document.getElementById('mymodalfzr');
    var btn = document.getElementById("aiomatic_manage_batches");
    var span = document.getElementById("aiomatic_close");
    if(btn != null)
    {
        btn.onclick = function(e) {
            e.preventDefault();
            codemodalfzr.style.display = "block";
        }
    }
    if(span != null)
    {
        span.onclick = function() {
            codemodalfzr.style.display = "none";
        }
    }
    
    var codemodalfzr_edit = document.getElementById('mymodalfzr-edit');
    var span_edit = document.getElementById("aiomatic_close-edit");
    if(span_edit != null)
    {
        span_edit.onclick = function() {
            codemodalfzr_edit.style.display = "none";
        }
    }
    
    var codemodalfzr_parse = document.getElementById('mymodalfzr-parse');
    var span_parse = document.getElementById("aiomatic_close-parse");
    if(span_parse != null)
    {
        span_parse.onclick = function() {
            codemodalfzr_parse.style.display = "none";
        }
    }

    window.onclick = function(event) 
    {
        if (event.target == codemodalfzr_parse) {
            codemodalfzr_parse.style.display = "none";
        }
        if (event.target == codemodalfzr_edit) {
            codemodalfzr_edit.style.display = "none";
        }
        if (event.target == codemodalfzr) {
            codemodalfzr.style.display = "none";
        }
    }
});

//https://help.openai.com/en/articles/9197833-batch-api-faq
function aiomatic_batch_data_changed()
{
    var select = jQuery('#model_selector_data_batch').val();
    if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
    {
        var aiomatic_legacy_data = jQuery('#aiomatic_legacy_data');
        var aiomatic_gpt_data = jQuery('#aiomatic_gpt_data');
        aiomatic_legacy_data.hide();
        aiomatic_gpt_data.show();
    }
    else
    {
        var aiomatic_legacy_data = jQuery('#aiomatic_legacy_data');
        var aiomatic_gpt_data = jQuery('#aiomatic_gpt_data');
        aiomatic_legacy_data.show();
        aiomatic_gpt_data.hide();
    }
}
jQuery(document).ready(function ($){
    function aiomatic_stripslashes (str) 
    {
        return (str + '').replace(/\\(.?)/g, function (s, n1) {
          switch (n1) {
          case '\\':
            return '\\';
          case '0':
            return '\u0000';
          case '':
            return '';
          default:
            return n1;
          }
        });
    }
    $('.aiomatic_modal_close').on('click', function (){
        $('.aiomatic_modal_close').closest('.aiomatic_modal').hide();
        $('.aiomatic_modal_close').closest('.aiomatic_modal').removeClass('aiomatic-small-modal');
        $('.aiomatic-overlay').hide();
    });
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
    var aiomatic_max_file_size = aiomatic_object.maxfilesize;
    var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
    var aiomatic_delete_file = $('.aiomatic_delete_file');
    var aiomatic_ajax_url = aiomatic_object.ajax_url;
    function aiomaticSortData(){
        $('.aiomatic_data').each(function (idx, item){
            $(item).find('.aiomatic_data_prompt').attr('name','data_batch['+idx+'][prompt]');
        });
        $('.aiomatic_new_data_batch').each(function (idx, item){
            $(item).find('.aiomatic_new_data_batch_system').attr('name','new_data_batch['+idx+'][system]');
            $(item).find('.aiomatic_new_data_batch_prompt').attr('name','new_data_batch['+idx+'][prompt]');
        });
    }
    var aiomatic_item = '<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea><span class="button button-link-delete">×</span></div></div>';
    var aiomatic_new_item = '<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System"></textarea> </div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User"></textarea><span class="button button-link-delete">×</span></div></div>';
    var aiomatic_data_restore = window.localStorage.getItem('aiomatic_data_list_batch');
    if(aiomatic_data_restore !== null && aiomatic_data_restore !== "")
    {
        var appendData = '';
        var oldobj = '';
        try{
            oldobj = JSON.parse(aiomatic_data_restore);
            oldobj.forEach(function (element){if(element.prompt !== null && element.prompt !== undefined){appendData += '<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt">' + element.prompt + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
            appendData += aiomatic_item;
            $('#aiomatic_data_list_batch').html(appendData);
        }
        catch(e)
        {
            alert(e);
        }
    }
    var aiomatic_new_data_batch_restore = window.localStorage.getItem('aiomatic_new_data_batch_list');
    if(aiomatic_new_data_batch_restore !== null && aiomatic_new_data_batch_restore !== "")
    {
        var appendData = '';
        var oldobj = '';
        try{
            oldobj = JSON.parse(aiomatic_new_data_batch_restore);
            oldobj.forEach(function (element){if(element.prompt !== null && element.prompt !== undefined){appendData += '<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System">' + element.system + '</textarea> </div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User">' + element.prompt + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
            appendData += aiomatic_new_item;
            $('#aiomatic_new_data_batch_list').html(appendData);
        }
        catch(e)
        {
            alert(e);
        }
    }
    var progressBar = $('.aiomatic-convert-bar');
    var aiomatic_add_data = $('.aiomatic_add_data');
    var aiomatic_clear_data = $('.aiomatic_clear_data');
    var aiomatic_download_data = $('.aiomatic_download_data');
    var aiomatic_load_data = $('.aiomatic_load_data');
    var form = $('#aiomatic_form_data');
    aiomatic_add_data.on('click', function (){
        var select = jQuery('#model_selector_data_batch').val();
        if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
        {
            $('#aiomatic_new_data_batch_list').append(aiomatic_new_item);
        }
        else
        {
            $('#aiomatic_data_list_batch').append(aiomatic_item);
        }
        aiomaticSortData();
        var total = 0;
        var lists = [];
        $('.aiomatic_data').each(function (idx, item){
            var item_prompt = $(item).find('.aiomatic_data_prompt').val();
            if(item_prompt !== ''){
                total += 1;
                lists.push({prompt: item_prompt});
            }
        });
        if(total > 0){
            try
            {
                var jsonstr = JSON.stringify(lists);
                window.localStorage.setItem('aiomatic_data_list_batch', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
        var new_total = 0;
        var new_lists = [];
        $('.aiomatic_new_data_batch').each(function (idx, item){
            var item_system = $(item).find('.aiomatic_new_data_batch_system').val();
            var item_prompt = $(item).find('.aiomatic_new_data_batch_prompt').val();
            if(item_prompt !== ''){
                new_total += 1;
                new_lists.push({system: item_system, prompt: item_prompt});
            }
        });
        if(new_total > 0){
            try
            {
                var jsonstr = JSON.stringify(new_lists);
                window.localStorage.setItem('aiomatic_new_data_batch_list', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
    });
    aiomatic_clear_data.on('click', function ()
    {
        var select = jQuery('#model_selector_data_batch').val();
        if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
        {
            $('#aiomatic_new_data_batch_list').html('<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System"></textarea></div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User"></textarea><span class="button button-link-delete">×</span></div></div>');
            window.localStorage.removeItem('aiomatic_new_data_batch_list');
        }
        else
        {
            $('#aiomatic_data_list_batch').html('<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea><span class="button button-link-delete">×</span></div></div>');
            window.localStorage.removeItem('aiomatic_data_list_batch');
        }
    });
    var Download = 
    {
        click : function(node) {
            var ev = new MouseEvent("click", {
                bubbles: true,
                cancelable: false,
                view: window,
                detail: 0,
                screenX: 0,
                screenY: 0,
                clientX: 0,
                clientY: 0,
                ctrlKey: false,
                altKey: false,
                shiftKey: false,
                metaKey: false,
                button: 0,
                relatedTarget: null
            });
            return node.dispatchEvent(ev);
        },
        encode : function(data) {
                return 'data:application/octet-stream;base64,' + btoa( data );
        },
        link : function(data, name){
            var a = document.createElement('a');
            a.download = name || self.location.pathname.slice(self.location.pathname.lastIndexOf('/')+1);
            a.href = data || self.location.href;
            return a;
        }
    };
    Download.save = function(data, name)
    {
        this.click(
            this.link(
                this.encode( data ),
                name
            )
        );
    };
    aiomatic_download_data.on('click', function ()
    {
        var select = jQuery('#model_selector_data_batch').val();
        var model_max_tokens = jQuery('#model_max_tokens').val();
        if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
        {
            var total = 0;
            var lists = '';
            $('.aiomatic_new_data_batch').each(function (idx, item){
                var item_system = $(item).find('.aiomatic_new_data_batch_system').val();
                var item_prompt = $(item).find('.aiomatic_new_data_batch_prompt').val();
                if(item_prompt !== '')
                {
                    total += 1;
                    var messages = [
                    {
                        role: "system",
                        content: item_system
                    },
                    {
                        role: "user",
                        content: item_prompt
                    }
                    ];
                    var json_arr = 
                    {
                        custom_id: "request-" + total,
                        method: "POST",
                        url: "/v1/chat/completions",
                        body: 
                        {
                            model: select,
                            messages: messages
                        }
                    };
                    if (typeof model_max_tokens !== 'undefined' && model_max_tokens !== null && model_max_tokens != '') 
                    {
                        json_arr.body.max_tokens = model_max_tokens;
                    }
                    try
                    {
                        var myJsonString = JSON.stringify(json_arr);
                        lists += myJsonString + '\n';
                    }
                    catch(e)
                    {
                        alert(e);
                    }
                }
            });
            lists = lists.trim();
            if(total > 0){
                try
                {
                    Download.save(lists, "new_data_batch.jsonl");
                }
                catch(e)
                {
                    alert(e);
                }
            }
            else
            {
                alert('No data to download!');
            }
        }
        else
        {
            var total = 0;
            var lists = '';
            $('.aiomatic_data').each(function (idx, item){
                var item_prompt = $(item).find('.aiomatic_data_prompt').val();
                if(item_prompt !== ''){
                    total += 1;
                    var json_arr = 
                    {
                        custom_id: "request-" + total,
                        method: "POST",
                        url: "/v1/embeddings",
                        body: 
                        {
                            model: select,
                            input: item_prompt
                        }
                    };
                    try
                    {
                        var myJsonString = JSON.stringify(json_arr);
                        lists += myJsonString + '\n';
                    }
                    catch(e)
                    {
                        alert(e);
                    }
                }
            });
            lists = lists.trim();
            if(total > 0){
                try
                {
                    Download.save(lists, "data.jsonl");
                }
                catch(e)
                {
                    alert(e);
                }
            }
            else
            {
                alert('No data to download!');
            }
        }
    });
    aiomatic_load_data.on('click', function (event){
        event.preventDefault();
        var aiomatic_file_load = $('#aiomatic_file_load');
        if(aiomatic_file_load[0].files.length === 0){
            alert('Please select a file first!');
        }
        else
        {
            var aiomatic_file = aiomatic_file_load[0].files[0];
            var aiomatic_file_extension = aiomatic_file.name.substr( (aiomatic_file.name.lastIndexOf('.') +1) );
            if(aiomatic_file_extension !== 'jsonl' && aiomatic_file_extension !== 'csv')
            {
                aiomatic_file_load.val('');
                alert('This feature only accepts JSONL or CSV file types!');
            }
            else if(aiomatic_file.size > aiomatic_max_file_size)
            {
                aiomatic_file_load.val('');
                alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
            }
            else
            {
                var select = jQuery('#model_selector_data_batch').val();
                if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
                {
                    var reader = new FileReader();
                    reader.readAsText(aiomatic_file, "UTF-8");
                    var thehtml = '';
                    reader.onload = function (evt) {
                        if(aiomatic_file_extension == 'jsonl')
                        {
                            var explodefile = evt.target.result.split(/\r?\n/);
                            explodefile.forEach(function (element){if(element.trim() !== ''){var oldobj = '';try{oldobj = JSON.parse(element.trim());}catch(e) {alert(e);}if(oldobj.hasOwnProperty("messages")){if(oldobj.messages[0].role !== null && oldobj.messages[1].role !== null && oldobj.messages[2].role !== null && oldobj.messages[0].role !== undefined && oldobj.messages[1].role !== undefined && oldobj.messages[2].role !== undefined){thehtml += '<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System">' + oldobj.messages[0].content + '</textarea> </div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User">' + oldobj.messages[1].content + '</textarea><span class="button button-link-delete">×</span></div></div>';}}}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System"></textarea> </div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_new_data_batch_list').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_new_data_batch').each(function (idx, item){
                                    var item_system = $(item).find('.aiomatic_new_data_batch_system').val();
                                    var item_prompt = $(item).find('.aiomatic_new_data_batch_prompt').val();
                                    if(item_prompt !== ''){
                                        total += 1;
                                        lists.push({system: item_system, prompt: item_prompt});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_new_data_batch_list', jsonstr);
                                        alert("Data loaded successfully!");
                                    }
                                    catch(e)
                                    {
                                        alert(e);
                                    }
                                }
                            }
                            else
                            {
                                alert("Invalid file submitted: " + aiomatic_file.name);
                            }
                        }
                        else
                        {
                            let data = evt.target.result.split("\r\n");
                            for (let i in data) {
                                data[i] = data[i].split(",");
                            }
                            data.forEach(function (element){if(element[0] !== null && element[0] != '' && element[1] != '' && element[1] !== null){thehtml += '<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System">' + element[0] + '</textarea> </div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User">' + element[1] + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_data_item aiomatic_new_data_batch"><div><textarea rows="1" name="new_data_batch[0][system]" class="regular-text aiomatic_new_data_batch_system aiomatic_height" placeholder="System"></textarea> </div><div><textarea rows="1" name="new_data_batch[0][prompt]" class="regular-text aiomatic_new_data_batch_prompt aiomatic_height" placeholder="User"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_new_data_batch_list').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_new_data_batch').each(function (idx, item){
                                    var item_system = $(item).find('.aiomatic_new_data_batch_system').val();
                                    var item_prompt = $(item).find('.aiomatic_new_data_batch_prompt').val();
                                    if(item_prompt !== ''){
                                        total += 1;
                                        lists.push({system: item_system, prompt: item_prompt});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_new_data_batch_list', jsonstr);
                                        alert("Data loaded successfully!");
                                    }
                                    catch(e)
                                    {
                                        alert(e);
                                    }
                                }
                            }
                            else
                            {
                                alert("Invalid file submitted: " + aiomatic_file.name);
                            }
                        }
                    }
                    reader.onerror = function (evt) {
                        alert("Error reading file: " + aiomatic_file.name + ' - ' + reader.error);
                    }
                }
                else
                {
                    var reader = new FileReader();
                    reader.readAsText(aiomatic_file, "utf-8");
                    var thehtml = '';
                    reader.onload = function (evt) {
                        if(aiomatic_file_extension == 'jsonl')
                        {
                            var explodefile = evt.target.result.split(/\r?\n/);
                            explodefile.forEach(function (element){if(element.trim() !== ''){var oldobj = '';try{oldobj = JSON.parse(element.trim());}catch(e) {alert(e);}if(oldobj.hasOwnProperty("prompt")){if(oldobj.prompt !== null){thehtml += '<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt">' + oldobj.prompt + '</textarea><span class="button button-link-delete">×</span></div></div>';}}}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_data_list_batch').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_data').each(function (idx, item){
                                    var item_prompt = $(item).find('.aiomatic_data_prompt').val();
                                    if(item_prompt !== ''){
                                        total += 1;
                                        lists.push({prompt: item_prompt});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_data_list_batch', jsonstr);
                                        alert("Data loaded successfully!");
                                    }
                                    catch(e)
                                    {
                                        alert(e);
                                    }
                                }
                            }
                            else
                            {
                                alert("Invalid file submitted: " + aiomatic_file.name);
                            }
                        }
                        else
                        {
                            let data = evt.target.result.split("\r\n");
                            for (let i in data) {
                                data[i] = data[i].split(",");
                            }
                            data.forEach(function (element){if(element[0] !== null && element[0] != ''){thehtml += '<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt">' + element[0] + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_data_item_single aiomatic_data"><div><textarea rows="1" name="data_batch[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_data_list_batch').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_data').each(function (idx, item){
                                    var item_prompt = $(item).find('.aiomatic_data_prompt').val();
                                    if(item_prompt !== ''){
                                        total += 1;
                                        lists.push({prompt: item_prompt});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_data_list_batch', jsonstr);
                                        alert("Data loaded successfully!");
                                    }
                                    catch(e)
                                    {
                                        alert(e);
                                    }
                                }
                            }
                            else
                            {
                                alert("Invalid file submitted: " + aiomatic_file.name);
                            }
                        }
                    }
                    reader.onerror = function (evt) {
                        alert("Error reading file: " + aiomatic_file.name + ' - ' + reader.error);
                    }
                }
            }
        }
    });
    $(document).on('click','.aiomatic_data span', function (e){
        $(e.currentTarget).parent().parent().remove();
        var total = 0;
        var lists = [];
        $('.aiomatic_data').each(function (idx, item){
            var item_prompt = $(item).find('.aiomatic_data_prompt').val();
            if(item_prompt !== ''){
                total += 1;
                lists.push({prompt: item_prompt});
            }
        });
        if(total > 0){
            try
            {
                var jsonstr = JSON.stringify(lists);
                window.localStorage.setItem('aiomatic_data_list_batch', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
        else
        {
            window.localStorage.removeItem('aiomatic_data_list_batch');
        }
        aiomaticSortData();
    });
    
    $(document).on('click','.aiomatic_new_data_batch span', function (e){
        $(e.currentTarget).parent().parent().remove();
        var total = 0;
        var lists = [];
        $('.aiomatic_new_data_batch').each(function (idx, item){
            var item_system = $(item).find('.aiomatic_new_data_batch_system').val();
            var item_prompt = $(item).find('.aiomatic_new_data_batch_prompt').val();
            if(item_prompt !== ''){
                total += 1;
                lists.push({system: item_system, prompt: item_prompt});
            }
        });
        if(total > 0){
            try
            {
                var jsonstr = JSON.stringify(lists);
                window.localStorage.setItem('aiomatic_new_data_batch_list', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
        else
        {
            window.localStorage.removeItem('aiomatic_new_data_batch_list');
        }
        aiomaticSortData();
    });

    function aiomaticFileUpload(data, btn){
        var aiomatic_upload_convert_index = parseInt($('#aiomatic_upload_convert_index').val());
        $.ajax({
            url: aiomatic_ajax_url,
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function (res){
                if(res.status === 'success'){
                    if(res.next === 'DONE'){
                        var select = jQuery('#model_selector_data_batch').val();
                        if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
                        {
                            $('#aiomatic_new_data_batch_list').html(aiomatic_new_item);
                        }
                        else
                        {
                            $('#aiomatic_data_list_batch').html(aiomatic_item);
                        }
                        $('.aiomatic-upload-message').html('The upload was successfully completed!');
                        progressBar.find('small').html('100%');
                        progressBar.find('span').css('width','100%');
                        aiomaticRmLoading(btn);
                        setTimeout(function (){
                            $('#aiomatic_upload_convert_line').val('0');
                            $('#aiomatic_upload_convert_index').val('1');
                            progressBar.hide();
                            progressBar.removeClass('aiomatic_error')
                            progressBar.find('span').css('width',0);
                            progressBar.find('small').html('0%');
                        },2000);

                    }
                    else{
                        $('#aiomatic_upload_convert_line').val(res.next);
                        $('#aiomatic_upload_convert_index').val(aiomatic_upload_convert_index+1);
                        var data = $('#aiomatic_upload_convert').serialize();
                        aiomaticFileUpload(data, btn);
                    }
                }
                else{
                    progressBar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                progressBar.addClass('aiomatic_error');
                aiomaticRmLoading(btn);
                alert('Error in processing upload: ' + error);
            }
        })
    }

    function aiomaticProcessData(lists, start, file, btn){
        var purpose = $('select[name=purpose]').val();
        var model = $('select[name=model]').val();
        var name = $('#file-name-holder').val();
        var model_max_tokens = jQuery('#model_max_tokens').val();
        var total = 0;
        var js_list = '';
        if(file == '' && name != '')
        {
            file = name;
        }
        lists.forEach((item) => 
        {
            total += 1;
            var json_arr = 
            {
                custom_id: "request-" + total,
                method: "POST",
                url: "/v1/embeddings",
                body: 
                {
                    model: model,
                    input: item.prompt
                }
            };
            if (typeof model_max_tokens !== 'undefined' && model_max_tokens !== null && model_max_tokens != '') 
            {
                json_arr.body.max_tokens = model_max_tokens;
            }
            try
            {
                var myJsonString = JSON.stringify(json_arr);
                js_list += myJsonString + '\n';
            }
            catch(e)
            {
                alert(e);
            }
        });
        if(js_list == '')
        {
            alert('Processing failed, please try again later');
            return;
        }
        var data = {
            action: 'aiomatic_data_insert_batch',
            js_list: js_list,
            file: file,
            nonce: aiomatic_object.nonce
        };
        $.ajax({
            url: aiomatic_ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res){
                if(res.status === 'success'){
                    var percent = '100';
                    progressBar.find('small').html(percent+'%');
                    progressBar.find('span').css('width',percent+'%');
                    $('#aiomatic_upload_convert input[name=model]').val(model);
                    $('#aiomatic_upload_convert input[name=purpose]').val(purpose);
                    $('#aiomatic_upload_convert input[name=custom]').val(name);
                    $('#aiomatic_upload_convert input[name=file]').val(res.file);
                    var data = $('#aiomatic_upload_convert').serialize();
                    aiomaticFileUpload(data, btn);
                }
                else{
                    progressBar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                progressBar.addClass('aiomatic_error');
                aiomaticRmLoading(btn);
                alert('Error in processing data: ' + error);
            }
        });
    }
    function aiomaticNewProcessData(lists, start, file, btn){
        var purpose = $('select[name=purpose]').val();
        var model = $('select[name=model]').val();
        var name = $('#file-name-holder').val();
        var model_max_tokens = jQuery('#model_max_tokens').val();
        if(file == '' && name != '')
        {
            file = name;
        }
        var js_list = '';
        var total = 0;
        lists.forEach((item) => 
        {
            total += 1;
            var messages = [
                {
                    role: "system",
                    content: item.system
                },
                {
                    role: "user",
                    content: item.prompt
                }
            ];
            var json_arr = 
            {
                custom_id: "request-" + total,
                method: "POST",
                url: "/v1/chat/completions",
                body: 
                {
                    model: model,
                    messages: messages
                }
            };
            if (typeof model_max_tokens !== 'undefined' && model_max_tokens !== null && model_max_tokens != '') 
            {
                json_arr.body.max_tokens = model_max_tokens;
            }
            try
            {
                var myJsonString = JSON.stringify(json_arr);
                js_list += myJsonString + '\n';
            }
            catch(e)
            {
                alert(e);
            }
        });
        if(js_list == '')
        {
            alert('Processing failed, please try again later');
            return;
        }
        var data = {
            action: 'aiomatic_new_data_batch_insert',
            js_list: js_list,
            file: file,
            nonce: aiomatic_object.nonce
        };
        $.ajax({
            url: aiomatic_ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res){
                if(res.status === 'success'){
                    var percent = 100;
                    progressBar.find('small').html(percent+'%');
                    progressBar.find('span').css('width',percent+'%');
                    $('#aiomatic_upload_convert input[name=model]').val(model);
                    $('#aiomatic_upload_convert input[name=purpose]').val(purpose);
                    $('#aiomatic_upload_convert input[name=custom]').val(name);
                    $('#aiomatic_upload_convert input[name=file]').val(res.file);
                    var data = $('#aiomatic_upload_convert').serialize();
                    aiomaticFileUpload(data, btn);
                }
                else{
                    progressBar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                progressBar.addClass('aiomatic_error');
                aiomaticRmLoading(btn);
                alert('Error in processing data: ' + error);
            }
        });
    }
    form.on('submit', function (e){
        e.preventDefault();
        var select = jQuery('#model_selector_data_batch').val();
        if(aiomatic_object.moder_gpt_models_aiomatic.includes(select))
        {
            var total = 0;
            var lists = [];
            var btn = form.find('.aiomatic_submit');
            $('.aiomatic_new_data_batch').each(function (idx, item){
                var item_system = $(item).find('.aiomatic_new_data_batch_system').val();
                var item_prompt = $(item).find('.aiomatic_new_data_batch_prompt').val();
                if(item_prompt !== ''){
                    total += 1;
                    lists.push({system: item_system, prompt: item_prompt })
                }
            });
            if(total > 0){
                $('#aiomatic_upload_convert_line').val('0');
                $('#aiomatic_upload_convert_index').val('1');
                $('.aiomatic-upload-message').empty();
                progressBar.show();
                progressBar.removeClass('aiomatic_error')
                progressBar.find('span').css('width',0);
                progressBar.find('small').html('0%');
                aiomaticLoading(btn);
                aiomaticNewProcessData(lists, 0, '', btn);
            }
            else{
                alert('Please insert at least one row');
            }
        }
        else
        {
            var total = 0;
            var lists = [];
            var btn = form.find('.aiomatic_submit');
            $('.aiomatic_data').each(function (idx, item){
                var item_prompt = $(item).find('.aiomatic_data_prompt').val();
                if(item_prompt !== ''){
                    total += 1;
                    lists.push({prompt: item_prompt})
                }
            });
            if(total > 0){
                $('#aiomatic_upload_convert_line').val('0');
                $('#aiomatic_upload_convert_index').val('1');
                $('.aiomatic-upload-message').empty();
                progressBar.show();
                progressBar.removeClass('aiomatic_error')
                progressBar.find('span').css('width',0);
                progressBar.find('small').html('0%');
                aiomaticLoading(btn);
                aiomaticProcessData(lists, 0, '', btn);
            }
            else{
                alert('Please insert at least one row');
            }
        }
        return false;
    });
    $('.aiomatic_modal_close').on('click', function (){
        $('.aiomatic_modal_close').closest('.aiomatic_modal').hide();
        $('.aiomatic_modal_close').closest('.aiomatic_modal').removeClass('aiomatic-small-modal');
        $('.aiomatic-overlay').hide();
    });
    function aiomaticFileUpload(data, btn){
        var aiomatic_upload_convert_index = parseInt($('#aiomatic_upload_convert_index').val());
        var total_lines = parseInt($('#aiomatic_upload_convert_lines').val());
        if(total_lines === 0)
        {
            total_lines = 1;
        }
        var  aiomatic_upload_bar = $('.aiomatic-convert-bar');
        $.ajax({
            url: aiomatic_ajax_url,
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function (res){
                if(res.status === 'success'){
                    if(res.next === 'DONE'){
                        $('.aiomatic-upload-message').html('Upload was successful!');
                        res.next = total_lines;
                        var percent = Math.ceil(res.next*100/total_lines);
                        aiomatic_upload_bar.find('small').html(percent+'%');
                        aiomatic_upload_bar.find('span').css('width',percent+'%');
                        aiomaticRmLoading(btn);
                    }
                    else{
                        var percent = Math.ceil(res.next*100/total_lines);
                        aiomatic_upload_bar.find('small').html(percent+'%');
                        aiomatic_upload_bar.find('span').css('width',percent+'%');
                        $('#aiomatic_upload_convert_line').val(res.next);
                        $('#aiomatic_upload_convert_index').val(aiomatic_upload_convert_index+1);
                        var data = $('#aiomatic_upload_convert').serialize();
                        aiomaticFileUpload(data,btn);
                    }
                }
                else{
                    aiomatic_upload_bar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                aiomatic_upload_bar.addClass('aiomatic_error');
                aiomaticRmLoading(btn);
                alert('Error in processing file upload: ' + error);
            }
        });
    }
    $(document).on('submit','#aiomatic_upload_convert', function (e){
        $('#aiomatic_upload_convert_index').val(1);
        $('#aiomatic_upload_convert_line').val(0);
        $('.aiomatic-upload-message').empty();
        var form = $(e.currentTarget);
        var data = form.serialize();
        var btn = form.find('button');
        aiomaticLoading(btn);
        var  aiomatic_upload_bar = $('.aiomatic-upload-bar');
        aiomatic_upload_bar.show();
        aiomatic_upload_bar.removeClass('aiomatic_error')
        aiomatic_upload_bar.find('span').css('width',0);
        aiomatic_upload_bar.find('small').html('0%');
        aiomaticFileUpload(data,btn);
        return false;
    });
    $('.aiomatic_modal_close').on('click', function (){
        $('.aiomatic_modal_close').closest('.aiomatic_modal').hide();
        $('.aiomatic_modal_close').closest('.aiomatic_modal').removeClass('aiomatic-small-modal');
        $('.aiomatic-overlay').hide();
    })
    var aiomaticAjaxRunning = false;
    aiomatic_delete_file.on('click', function (){
        if(!aiomaticAjaxRunning) {
            var conf = confirm('Are you sure that you want to delete this file?');
            if (conf) {
                var btn = $(this);
                var id = btn.attr('data-id');
                $.ajax({
                    url: aiomatic_ajax_url,
                    data: {action: 'aiomatic_delete_finetune_file', id: id, nonce: aiomatic_object.nonce},
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function () {
                        aiomaticAjaxRunning = true;
                        aiomaticLoading(btn);
                    },
                    success: function (res) {
                        aiomaticAjaxRunning = false;
                        aiomaticRmLoading(btn);
                        if (res.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error) {
                        aiomaticAjaxRunning = false;
                        aiomaticRmLoading(btn);
                        alert('Error in processing finetune removal: ' + error);
                    }
                });
            }
            else{
                aiomaticAjaxRunning = false;
            }
        }
    });
    var aiomaticAjaxRunning = false;
    $('.aiomatic_modal_close').on('click', function (){
        $('.aiomatic_modal_close').closest('.aiomatic_modal').hide();
        $('.aiomatic-overlay').hide();
    })
    function aiomaticLoading(btn){
        btn.attr('disabled','disabled');
        if(btn.find('.spinner').length === 0){
            btn.append('<span class="aiomatic-spinner spinner"></span>');
        }
        btn.find('.spinner').css('visibility','unset');
    }
    function aiomaticRmLoading(btn){
        btn.removeAttr('disabled');
        btn.find('.spinner').remove();
    }
});