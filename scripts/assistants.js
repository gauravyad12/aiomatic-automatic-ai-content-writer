"use strict";
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
    jQuery('input#aiomatic_media_clear_new').on('click', function(e) 
    {
        e.preventDefault();
        jQuery('input#aiomatic_image_id_new').val('0');
        jQuery('#aiomatic-preview-image-new').removeAttr('src');
        jQuery('#aiomatic-preview-image-new').removeAttr('srcset');
        jQuery('#aiomatic-preview-image-new').removeAttr('width');
        jQuery('#aiomatic-preview-image-new').removeAttr('height');
        jQuery('#aiomatic-preview-image-new').removeAttr('sizes');
        jQuery('#aiomatic-preview-image-new').removeAttr('loading');
        jQuery('#aiomatic-preview-image-new').removeAttr('decoding');
        jQuery('#aiomatic-preview-image-new').removeAttr('alt');
        jQuery('#aiomatic-preview-image-new').removeAttr('class');
    });
    jQuery('body').on('click', '#aiomatic_media_clear_new-edit', function(e) 
    {
        e.preventDefault();
        jQuery('input#aiomatic_image_id_new-edit').val('0');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('src');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('srcset');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('width');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('height');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('sizes');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('loading');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('decoding');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('alt');
        jQuery('#aiomatic-preview-image-new-edit').removeAttr('class');
    });
    jQuery('input#aiomatic_media_manager_new').on('click', function(e) {
        e.preventDefault();
        var image_frame;
        if(image_frame){
            image_frame.open();
        }
        image_frame = wp.media({
                title: 'Select Media',
                multiple : false,
                library : {
                    type : 'image',
                }
            });
        image_frame.on('close',function() {
        var selection =  image_frame.state().get('selection');
        var gallery_ids = new Array();
        var my_index = 0;
        selection.each(function(attachment) {
            gallery_ids[my_index] = attachment['id'];
            my_index++;
        });
        var ids = gallery_ids.join(",");
        if(ids.length === 0) return true;
        jQuery('input#aiomatic_image_id_new').val(ids);
        Refresh_Image_New(ids);
        });
        image_frame.on('open',function() {
            var selection =  image_frame.state().get('selection');
            var ids = jQuery('input#aiomatic_image_id_new').val().split(',');
            ids.forEach(function(id) {
                var attachment = wp.media.attachment(id);
                attachment.fetch();
                selection.add( attachment ? [ attachment ] : [] );
            });
        });
        image_frame.open();
    });
    jQuery('input#aiomatic_god_mode_new-edit').on('click', function(e) {
        e.preventDefault();
        var god_mode = '0';
        var dalle = '0';
        var stable = '0';
        var midjourney = '0';
        var amazon = '0';
        var amazon_details = '0';
        var scraper = '0';
        var rss = '0';
        var google = '0';
        var captions = '0';
        var royalty = '0';
        var youtube = '0';
        var email = '0';
        var facebook = '0';
        var facebook_image = '0';
        var twitter = '0';
        var instagram = '0';
        var pinterest = '0';
        var business = '0';
        var youtube_community = '0';
        var reddit = '0';
        var linkedin = '0';
        var webhook = '0';
        var stable_video = '0';
        if(jQuery('#function_god_mode-edit').is(":checked"))
        {
            god_mode = '1';
        }
        if(jQuery('#function_dalle-edit').is(":checked"))
        {
            dalle = '1';
        }
        if(jQuery('#function_stable-edit').is(":checked"))
        {
            stable = '1';
        }
        if(jQuery('#function_midjourney-edit').is(":checked"))
        {
            midjourney = '1';
        }
        if(jQuery('#function_amazon-edit').is(":checked"))
        {
            amazon = '1';
        }
        if(jQuery('#function_amazon_details-edit').is(":checked"))
        {
            amazon_details = '1';
        }
        if(jQuery('#function_scraper-edit').is(":checked"))
        {
            scraper = '1';
        }
        if(jQuery('#function_rss-edit').is(":checked"))
        {
            rss = '1';
        }
        if(jQuery('#function_google-edit').is(":checked"))
        {
            google = '1';
        }
        if(jQuery('#function_captions-edit').is(":checked"))
        {
            captions = '1';
        }
        if(jQuery('#function_royalty-edit').is(":checked"))
        {
            royalty = '1';
        }
        if(jQuery('#function_youtube-edit').is(":checked"))
        {
            youtube = '1';
        }
        if(jQuery('#function_email-edit').is(":checked"))
        {
            email = '1';
        }
        if(jQuery('#function_facebook-edit').is(":checked"))
        {
            facebook = '1';
        }
        if(jQuery('#function_facebook_image-edit').is(":checked"))
        {
            facebook_image = '1';
        }
        if(jQuery('#function_twitter-edit').is(":checked"))
        {
            twitter = '1';
        }
        if(jQuery('#function_instagram-edit').is(":checked"))
        {
            instagram = '1';
        }
        if(jQuery('#function_pinterest-edit').is(":checked"))
        {
            pinterest = '1';
        }
        if(jQuery('#function_business-edit').is(":checked"))
        {
            business = '1';
        }
        if(jQuery('#function_youtube_community-edit').is(":checked"))
        {
            youtube_community = '1';
        }
        if(jQuery('#function_reddit-edit').is(":checked"))
        {
            reddit = '1';
        }
        if(jQuery('#function_linkedin-edit').is(":checked"))
        {
            linkedin = '1';
        }
        if(jQuery('#function_webhook-edit').is(":checked"))
        {
            webhook = '1';
        }
        if(jQuery('#function_stable_video-edit').is(":checked"))
        {
            stable_video = '1';
        }
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: {action: 'aiomatic_get_god_mode_function', god_mode: god_mode, stable_video: stable_video, webhook: webhook, linkedin: linkedin, reddit: reddit, youtube_community: youtube_community, business: business, pinterest: pinterest, instagram: instagram, twitter: twitter, facebook_image: facebook_image, facebook: facebook, dalle: dalle, stable: stable, midjourney: midjourney, amazon: amazon, amazon_details: amazon_details, scraper: scraper, rss: rss, google: google, captions: captions, royalty: royalty, youtube: youtube, email: email, nonce: aiomatic_object.nonce},
            type: 'POST',
            success: function (res) 
            {
                if (res.status !== 'success') 
                {
                    alert('Error in processing: ' + JSON.stringify(res));
                }
                else
                {
                    var god_json = res.json;
                    jQuery('#aiomatic-assistant-functions-edit').val(god_json);
                }
            },
            error: function (r, s, error) {
                alert('Error in processing file sync: ' + error);
            }
        });
    });
    jQuery('input#aiomatic_god_mode_new_disable-edit').on('click', function(e) {
        e.preventDefault();
        var god_json = `[]`;
        jQuery('#aiomatic-assistant-functions-edit').val(god_json);
    });
    jQuery('input#aiomatic_god_mode_new').on('click', function(e) {
        e.preventDefault();
        var god_mode = '0';
        var dalle = '0';
        var stable = '0';
        var midjourney = '0';
        var amazon = '0';
        var amazon_details = '0';
        var scraper = '0';
        var rss = '0';
        var google = '0';
        var captions = '0';
        var royalty = '0';
        var youtube = '0';
        var email = '0';
        var facebook = '0';
        var facebook_image = '0';
        var twitter = '0';
        var instagram = '0';
        var pinterest = '0';
        var business = '0';
        var youtube_community = '0';
        var reddit = '0';
        var linkedin = '0';
        var webhook = '0';
        var stable_video = '0';
        if(jQuery('#function_god_mode').is(":checked"))
        {
            god_mode = '1';
        }
        if(jQuery('#function_dalle').is(":checked"))
        {
            dalle = '1';
        }
        if(jQuery('#function_stable').is(":checked"))
        {
            stable = '1';
        }
        if(jQuery('#function_midjourney').is(":checked"))
        {
            midjourney = '1';
        }
        if(jQuery('#function_amazon').is(":checked"))
        {
            amazon = '1';
        }
        if(jQuery('#function_amazon_details').is(":checked"))
        {
            amazon_details = '1';
        }
        if(jQuery('#function_scraper').is(":checked"))
        {
            scraper = '1';
        }
        if(jQuery('#function_rss').is(":checked"))
        {
            rss = '1';
        }
        if(jQuery('#function_google').is(":checked"))
        {
            google = '1';
        }
        if(jQuery('#function_captions').is(":checked"))
        {
            captions = '1';
        }
        if(jQuery('#function_royalty').is(":checked"))
        {
            royalty = '1';
        }
        if(jQuery('#function_youtube').is(":checked"))
        {
            youtube = '1';
        }
        if(jQuery('#function_email').is(":checked"))
        {
            email = '1';
        }
        if(jQuery('#function_facebook').is(":checked"))
        {
            facebook = '1';
        }
        if(jQuery('#function_facebook_image').is(":checked"))
        {
            facebook_image = '1';
        }
        if(jQuery('#function_twitter').is(":checked"))
        {
            twitter = '1';
        }
        if(jQuery('#function_instagram').is(":checked"))
        {
            instagram = '1';
        }
        if(jQuery('#function_pinterest').is(":checked"))
        {
            pinterest = '1';
        }
        if(jQuery('#function_business').is(":checked"))
        {
            business = '1';
        }
        if(jQuery('#function_youtube_community').is(":checked"))
        {
            youtube_community = '1';
        }
        if(jQuery('#function_reddit').is(":checked"))
        {
            reddit = '1';
        }
        if(jQuery('#function_linkedin').is(":checked"))
        {
            linkedin = '1';
        }
        if(jQuery('#function_webhook').is(":checked"))
        {
            webhook = '1';
        }
        if(jQuery('#function_stable_video').is(":checked"))
        {
            stable_video = '1';
        }
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: {action: 'aiomatic_get_god_mode_function', god_mode: god_mode, stable_video: stable_video, midjourney: midjourney, webhook: webhook, linkedin: linkedin, reddit: reddit, youtube_community: youtube_community, business: business, pinterest: pinterest, instagram: instagram, twitter: twitter, facebook_image: facebook_image, facebook: facebook, dalle: dalle, stable: stable, amazon: amazon, amazon_details: amazon_details, scraper: scraper, rss: rss, google: google, captions: captions, royalty: royalty, youtube: youtube, email: email, nonce: aiomatic_object.nonce},
            type: 'POST',
            success: function (res) 
            {
                if (res.status !== 'success') 
                {
                    alert('Error in processing: ' + JSON.stringify(res));
                }
                else
                {
                    var god_json = res.json;
                    jQuery('#aiomatic-assistant-functions').val(god_json);
                }
            },
            error: function (r, s, error) {
                alert('Error in processing file sync: ' + error);
            }
        });
    });
    jQuery('input#aiomatic_god_mode_new_disable').on('click', function(e) {
        e.preventDefault();
        var god_json = `[]`;
        jQuery('#aiomatic-assistant-functions').val(god_json);
    });
    jQuery('input#aiomatic_media_manager_new-edit').on('click', function(e) {
        e.preventDefault();
        var image_frame;
        if(image_frame){
            image_frame.open();
        }
        image_frame = wp.media({
                title: 'Select Media',
                multiple : false,
                library : {
                    type : 'image',
                }
            });
        image_frame.on('close',function() {
            var selection =  image_frame.state().get('selection');
            var gallery_ids = new Array();
            var my_index = 0;
            selection.each(function(attachment) {
                gallery_ids[my_index] = attachment['id'];
                my_index++;
            });
            var ids = gallery_ids.join(",");
            if(ids.length === 0) return true;
            jQuery('input#aiomatic_image_id_new-edit').val(ids);
            Refresh_Image_Edit(ids);
        });
        image_frame.on('open',function() {
            var selection =  image_frame.state().get('selection');
            var ids = jQuery('input#aiomatic_image_id_new-edit').val().split(',');
            ids.forEach(function(id) {
                var attachment = wp.media.attachment(id);
                attachment.fetch();
                selection.add( attachment ? [ attachment ] : [] );
            });
        });
        image_frame.open();
    });
    function Refresh_Image_New(the_id){
       var data = {
           action: 'aiomatic_get_image',
           id: the_id,
           nonce: aiomatic_object.singlenonce
       };
       jQuery.get(ajaxurl, data, function(response) {
           if(response.success === true) {
               response.data.image = response.data.image.replace('aiomatic-preview-image', 'aiomatic-preview-image-new');
               jQuery('#aiomatic-preview-image-new').replaceWith( response.data.image );
           }
       });
    }
    function Refresh_Image_Edit(the_id){
       var data = {
           action: 'aiomatic_get_image',
           id: the_id,
           nonce: aiomatic_object.singlenonce
       };
       jQuery.get(ajaxurl, data, function(response) {
           if(response.success === true) {
               response.data.image = response.data.image.replace('aiomatic-preview-image', 'aiomatic-preview-image-new-edit');
               jQuery('#aiomatic-preview-image-new-edit').replaceWith( response.data.image );
           }
       });
    }
    function timeConverter(UNIX_timestamp){
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
                    alert('Error in processing file sync: ' + error);
                }
            });
        }
        else
        {
            alert('Empty data-id provided');
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
                    alert('Error in processing file sync: ' + error);
                }
            });
        }
        else
        {
            alert('Empty data-id provided');
        }
    });
    jQuery('body').on('click', '#aiomatic_file_button', function() {
        var aiomatic_file_upload = jQuery('#aiomatic_assistant_file_upload');
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
                formData.append('action', 'aiomatic_assistant_file_upload');
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
                        alert('Error in processing finetune uploading: ' + error);
                        aiomatic_error_message.show();
                    }
                });
            }
        }
    });
    var assistent_files = [];
    var aiomaticAjaxRunning = false;
    jQuery('#aiomatic_sync_assistant_files').on('click', function (e){
        e.preventDefault();
        jQuery("#aiomatic-assistants-files > tbody").empty();
        var btn = jQuery(this);
        if(!aiomaticAjaxRunning) {
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_list_assistant_files', nonce: aiomatic_object.nonce},
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
                        assistent_files = res.data;
                        res.data.forEach(async (tfile) => {
                            var appendme = '<tr><td>' + tfile.id + '</td><td>' + tfile.bytes + '</td><td>' + tfile.purpose + '</td><td>' + timeConverter(tfile.created_at) + '</td><td>' + tfile.filename + '</td><td>' + tfile.status + '</td><td><button data-id="' + tfile.id + '" class="button button-small aiomatic_download_file"';
                            if(tfile.purpose == 'assistants')
                            {
                                appendme += ' disabled';
                            }
                            appendme += '>Download</button><button data-id="' + tfile.id + '" class="button button-small button-link-delete aiomatic_delete_file">Delete</button></td></tr>';
                            jQuery('#aiomatic-assistants-files > tbody:last-child').append(appendme);
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
    jQuery( "#aiomatic_sync_assistant_files" ).trigger( "click" );
    function aiomatic_refresh_options()
    {
        assistent_files.forEach(async (tfile) => {
            jQuery("#aiomatic-assistant-files").append(jQuery('<option>', {
                value: tfile.id,
                text: tfile.filename + ' (' + tfile.id + ')'
            }));
        });
        assistent_files.forEach(async (tfile) => {
            jQuery("#aiomatic-assistant-files-edit").append(jQuery('<option>', {
                value: tfile.id,
                text: tfile.filename + ' (' + tfile.id + ')'
            }));
        });
    }
    jQuery(document).on('change', '#aiomatic-assistant-model', function (e) {
        var model = jQuery('#aiomatic-assistant-model').val();
        if(aiomatic_object.retrival_models.includes(model))
        {
            jQuery('#aiomatic-assistant-file_search').prop('disabled', false);
        }
        else
        {
            jQuery('#aiomatic-assistant-file_search').prop('disabled', true);
            jQuery("#aiomatic-assistant-file_search").prop("checked", false);
        }
    });
    jQuery(document).on('change', '#aiomatic-assistant-model-edit', function (e) {
        var model = jQuery('#aiomatic-assistant-model-edit').val();
        if(aiomatic_object.retrival_models.includes(model))
        {
            jQuery('#aiomatic-assistant-file_search-edit').prop('disabled', false);
        }
        else
        {
            jQuery('#aiomatic-assistant-file_search-edit').prop('disabled', true);
            jQuery("#aiomatic-assistant-file_search-edit").prop("checked", false);
        }
    });
    jQuery(document).on('change', '#aiomatic-assistant-code-interpreter', function (e) {
        if(jQuery("#aiomatic-assistant-code-interpreter").is(':checked') || jQuery("#aiomatic-assistant-file_search").is(':checked'))
        {
            jQuery('#aiomatic-assistant-files').prop('disabled', false);
        }
        else
        {
            jQuery('#aiomatic-assistant-files').prop('disabled', true);
        }
    });
    jQuery(document).on('change', '#aiomatic-assistant-file_search', function (e) {
        if(jQuery("#aiomatic-assistant-code-interpreter").is(':checked') || jQuery("#aiomatic-assistant-file_search").is(':checked'))
        {
            jQuery('#aiomatic-assistant-files').prop('disabled', false);
        }
        else
        {
            jQuery('#aiomatic-assistant-files').prop('disabled', true);
        }
    });
    jQuery(document).on('change', '#aiomatic-assistant-code-interpreter-edit', function (e) {
        if(jQuery("#aiomatic-assistant-code-interpreter-edit").is(':checked') || jQuery("#aiomatic-assistant-file_search-edit").is(':checked'))
        {
            jQuery('#aiomatic-assistant-files-edit').prop('disabled', false);
        }
        else
        {
            jQuery('#aiomatic-assistant-files-edit').prop('disabled', true);
        }
    });
    jQuery(document).on('change', '#aiomatic-assistant-file_search-edit', function (e) {
        if(jQuery("#aiomatic-assistant-code-interpreter-edit").is(':checked') || jQuery("#aiomatic-assistant-file_search-edit").is(':checked'))
        {
            jQuery('#aiomatic-assistant-files-edit').prop('disabled', false);
        }
        else
        {
            jQuery('#aiomatic-assistant-files-edit').prop('disabled', true);
        }
    });
    jQuery('#aiomatic-assistant-model').trigger("change");
    jQuery('#aiomatic-assistant-model-edit').trigger("change");
    jQuery('#aiomatic_sync_assistants').on('click', function (e)
    {
        e.preventDefault();
        if(confirm('Are you sure you want to sync assistants with OpenAI?'))
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var data = {
                action: 'aiomatic_sync_assistants',
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
                        jQuery('.aiomatic-assistants-success').show();
                        jQuery('.aiomatic-assistants-content').val('');
                        setTimeout(function (){
                            jQuery('.aiomatic-assistants-success').hide();
                        },2000);
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing assistant sync: ' + error);
                }
            });
        }
    });
    jQuery('#aiomatic_delete_selected_assistants').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete selected assistants?'))
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var ids = [];
            jQuery('.aiomatic-select-assistant:checked').each(function (idx, item) {
                ids.push(jQuery(item).val())
            });
            if (ids.length) {
                var data = {
                    action: 'aiomatic_delete_selected_assistants',
                    nonce: aiomatic_object.nonce,
                    ids: ids
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res){
                        aiomaticRmLoading(btn);
                        if(res.status === 'success'){
                            jQuery('.aiomatic-assistants-success').show();
                            jQuery('.aiomatic-assistants-content').val('');
                            setTimeout(function (){
                                jQuery('.aiomatic-assistants-success').hide();
                            },2000);
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing assistant removal selected: ' + error);
                    }
                });
            } else {
                alert('No assistants selected');
                aiomaticRmLoading(btn);
            }
        }
    });
    jQuery(".aiomatic_edit_assistant").on('click', function(e) {
        e.preventDefault();
        var assistantid = jQuery(this).attr("edit-id");
        if(assistantid == '')
        {
            alert('Incorrect edit id submitted');
        }
        else
        {
            document.getElementById('mymodalfzr-edit').style.display = "block";
            jQuery('#assistant_id').val(assistantid);
            var data = {
                action: 'aiomatic_get_assistant',
                assistantid: assistantid,
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
                            if(res.data['vector_store_id'] != '')
                            {
                                jQuery('#aiomatic-assistant-vector-store-edit').text('Vectore Store ID: ' + res.data['vector_store_id']);
                            }
                            jQuery('#aiomatic-assistant-title-edit').val(res.data['post_title']);
                            jQuery('#aiomatic-assistant-prompt-edit').val(res.data['post_content']);
                            jQuery('#aiomatic-assistant-description-edit').val(res.data['post_excerpt']);
                            jQuery('#aiomatic-assistant-temperature-edit').val(res.data['temperature']);
                            jQuery('#aiomatic-assistant-topp-edit').val(res.data['topp']);
                            jQuery("#aiomatic-assistant-model-edit").val(res.data['assistant_model']).change();
                            jQuery('#aiomatic-assistant-first-message-edit').val(res.data['assistant_first_message']);
                            jQuery('#aiomatic-assistant-files-edit').val(res.data['assistant_files']);
                            if(res.data['featured_image'] > 0)
                            {
                                jQuery('input#aiomatic_image_id_new-edit').val(res.data['featured_image']);
                                Refresh_Image_Edit(res.data['featured_image']);
                            }
                            else
                            {
                                jQuery('input#aiomatic_image_id_new-edit').val('');
                                Refresh_Image_Edit('');
                            }
                            var functions_str = JSON.stringify(res.data['functions'],null,2);
                            if(functions_str.includes('aiomatic_wp_god_mode'))
                            {
                                jQuery("#function_god_mode-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_image'))
                            {
                                jQuery("#function_dalle-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_stable_image'))
                            {
                                jQuery("#function_stable-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_stable_image'))
                            {
                                jQuery("#function_midjourney-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_stable_video'))
                            {
                                jQuery("#function_stable_video-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_amazon_listing'))
                            {
                                jQuery("#function_amazon-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_amazon_product_details'))
                            {
                                jQuery("#function_amazon_details-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_website_scraper'))
                            {
                                jQuery("#function_scraper-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_rss_parser'))
                            {
                                jQuery("#function_rss-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_google_parser'))
                            {
                                jQuery("#function_google-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_royalty_free_image'))
                            {
                                jQuery("#function_royalty-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_youtube_captions'))
                            {
                                jQuery("#function_captions-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_youtube_search'))
                            {
                                jQuery("#function_youtube-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_send_email'))
                            {
                                jQuery("#function_email-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_webhook'))
                            {
                                jQuery("#function_webhook-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_facebook'))
                            {
                                jQuery("#function_facebook-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_image_facebook'))
                            {
                                jQuery("#function_facebook_image-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_twitter'))
                            {
                                jQuery("#function_twitter-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_instagram'))
                            {
                                jQuery("#function_instagram-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_pinterest'))
                            {
                                jQuery("#function_pinterest-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_google_my_business'))
                            {
                                jQuery("#function_business-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_youtube_community'))
                            {
                                jQuery("#function_youtube_community-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_reddit'))
                            {
                                jQuery("#function_reddit-edit").prop( "checked", true );
                            }
                            if(functions_str.includes('aiomatic_publish_linkedin'))
                            {
                                jQuery("#function_linkedin-edit").prop( "checked", true );
                            }
                            jQuery('#aiomatic-assistant-functions-edit').val(functions_str);
                            if(res.data['code_interpreter'] == true)
                            {
                                jQuery("#aiomatic-assistant-code-interpreter-edit").prop( "checked", true );
                            }
                            else
                            {
                                jQuery("#aiomatic-assistant-code-interpreter-edit").prop( "checked", false );
                            }
                            if(res.data['file_search'] == true)
                            {
                                jQuery("#aiomatic-assistant-file_search-edit").prop( "checked", true );
                            }
                            else
                            {
                                jQuery("#aiomatic-assistant-file_search-edit").prop( "checked", false );
                            }
                            jQuery('#aiomatic-assistant-code-interpreter-edit').trigger("change");
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
                    alert('Error in processing assistant editing: ' + error);
                }
            });
        }
    });
    jQuery(".aiomatic_sync_assistant").on('click', function(e) {
        e.preventDefault();
        var assistantid = jQuery(this).attr("sync-id");
        if(assistantid == '')
        {
            alert('Incorrect sync id submitted');
        }
        else
        {
            var data = {
                action: 'aiomatic_sync_assistant',
                assistantid: assistantid,
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading2(jQuery('#aiomatic_sync_assistant_' + assistantid));
                },
                success: function (res){
                    if(res.status === 'success'){
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing assistant sync by id: ' + error);
                }
            });
        }
    });
    jQuery(".aiomatic_delete_assistant").on('click', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to delete this assistant?'))
        {
            var assistantid = jQuery(this).attr("delete-id");
            if(assistantid == '')
            {
                alert('Incorrect delete id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_delete_assistant',
                    assistantid: assistantid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticLoading2(jQuery('#aiomatic_delete_assistant_' + assistantid));
                    },
                    success: function (res){
                        if(res.status === 'success'){
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                            location.reload();
                        }
                    },
                    error: function (r, s, error){
                        alert('Error in processing assistant deletion: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    jQuery(".aiomatic_duplicate_assistant").on('click', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to duplicate this assistant?'))
        {
            var assistantid = jQuery(this).attr("dup-id");
            if(assistantid == '')
            {
                alert('Incorrect duplicate id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_duplicate_assistant',
                    assistantid: assistantid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticLoading2(jQuery('#aiomatic_duplicate_assistant_' + assistantid));
                    },
                    success: function (res){
                        if(res.status === 'success'){
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                            location.reload();
                        }
                    },
                    error: function (r, s, error){
                        alert('Error in processing assistant duplication: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    jQuery('#aiomatic_deleteall_assistants').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete ALL assistants?'))
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var data = {
                action: 'aiomatic_deleteall_assistants',
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
                        jQuery('.aiomatic-assistants-success').show();
                        jQuery('.aiomatic-assistants-content').val('');
                        setTimeout(function (){
                            jQuery('.aiomatic-assistants-success').hide();
                        },2000);
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing assistant removal (all): ' + error);
                }
            });
        }
    });
    jQuery('#aiomatic_assistants_form').on('submit', function (e)
    {
        e.preventDefault();
        var form = jQuery('#aiomatic_assistants_form');
        var btn = form.find('#aiomatic-assistants-save-button');
        var title = jQuery('#aiomatic-assistant-title').val();
        if(title === ''){
            alert('Please insert all required values!');
        }
        else{
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
                        jQuery('.aiomatic-assistants-success').html("Assistant saved successfully!");
                        jQuery('.aiomatic-assistants-success').show();
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing assistant saving: ' + error);
                }
            });
        }
        return false;
    });
    
    jQuery('#aiomatic_assistants_form-edit').on('submit', function (e)
    {
        e.preventDefault();
        var form = jQuery('#aiomatic_assistants_form-edit');
        var btn = form.find('#aiomatic-assistants-save-button-edit');
        var title = jQuery('#aiomatic-assistant-title-edit').val();
        if(title === ''){
            alert('Please insert all required values!');
        }
        else{
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
                        jQuery('.aiomatic-assistants-success').html("Assistant updated successfully!");
                        jQuery('.aiomatic-assistants-success').show();
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing assistant saving: ' + error);
                }
            });
        }
        return false;
    });
    var aiomatic_assistant_button = jQuery('#aiomatic_assistant_button');
    aiomatic_assistant_button.on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to load assistants from file?'))
        {
            var aiomatic_assistant_upload = jQuery('#aiomatic_assistant_upload');
            if(jQuery("#aiomatic_overwrite").is(':checked'))
            {
                var overwrite = '1';
            }
            else
            {
                var overwrite = '0';
            }
            if(aiomatic_assistant_upload[0].files.length === 0){
                alert('Please select a file!');
            }
            else{
                var aiomatic_progress = jQuery('.aiomatic_progress');
                var aiomatic_error_message = jQuery('.aiomatic-error-msg');
                var aiomatic_upload_success = jQuery('.aiomatic_upload_success');
                var aiomatic_max_file_size = aiomatic_object.maxfilesize;
                var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
                var aiomatic_assistant_file = aiomatic_assistant_upload[0].files[0];
                var aiomatic_assistant_file_extension = aiomatic_assistant_file.name.substr( (aiomatic_assistant_file.name.lastIndexOf('.') +1) );
                if(aiomatic_assistant_file_extension !== 'json'){
                    aiomatic_assistant_upload.val('');
                    alert('This feature only accepts JSON file type!');
                }
                else if(aiomatic_assistant_file.size > aiomatic_max_file_size){
                    aiomatic_assistant_upload.val('');
                    alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
                }
                else{
                    var formData = new FormData();
                    formData.append('action', 'aiomatic_assistant_upload');
                    formData.append('nonce', aiomatic_object.nonce);
                    formData.append('overwrite', overwrite);
                    formData.append('file', aiomatic_assistant_file);
                    jQuery.ajax({
                        url: aiomatic_object.ajax_url,
                        type: 'POST',
                        dataType: 'JSON',
                        data: formData,
                        beforeSend: function (){
                            aiomatic_progress.find('span').css('width','0');
                            aiomatic_progress.show();
                            aiomaticLoading2(aiomatic_assistant_button);
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
                                aiomaticRmLoading(aiomatic_assistant_button);
                                aiomatic_progress.hide();
                                aiomatic_assistant_upload.val('');
                                aiomatic_upload_success.show();
                                location.reload();
                            }
                            else{
                                aiomaticRmLoading(aiomatic_assistant_button);
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
                            aiomatic_assistant_upload.val('');
                            aiomaticRmLoading(aiomatic_assistant_button);
                            aiomatic_progress.addClass('aiomatic_error');
                            aiomatic_progress.find('small').html('Error');
                            alert('Error in processing assistants uploading: ' + error);
                            aiomatic_error_message.show();
                        }
                    });
                }
            }
        }
    });
    jQuery("#checkedAll").on('change', function() {
        if (this.checked) {
            jQuery(".aiomatic-select-assistant").each(function() {
                this.checked=true;
            });
        } else {
            jQuery(".aiomatic-select-assistant").each(function() {
                this.checked=false;
            });
        }
    });
    var aiomatic_assistant_buttonx = jQuery('#aiomatic_assistant_default_button');
    aiomatic_assistant_buttonx.on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to load the default assistants which come bundled with the plugin?'))
        {
            var data = {
                action: 'aiomatic_default_assistant',
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading2(jQuery('#aiomatic_assistant_default_button'));
                },
                success: function (res){
                    if(res.status === 'success'){
                        alert('Default assistants loaded successfully!');
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                        location.reload();
                    }
                },
                error: function (r, s, error){
                    console.error("AJAX Error: ", r);
                    console.error("Status: ", s);
                    console.error("Error: ", error);
                    console.error('Detailed error: ' + r.responseText);
                    alert('Error in processing assistant loading: ' + error);
                    location.reload();
                }
            });
        }
    });
    var codemodalfzr = document.getElementById('mymodalfzr');
    var btn = document.getElementById("aiomatic_manage_assistants");
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
    
    var codemodalfzr_backup = document.getElementById('mymodalfzr_backup');
    var btn_backup = document.getElementById("aiomatic_backup_assistants");
    var span_backup = document.getElementById("aiomatic_close_backup");
    if(btn_backup != null)
    {
        btn_backup.onclick = function(e) {
            e.preventDefault();
            codemodalfzr_backup.style.display = "block";
        }
    }
    if(span_backup != null)
    {
        span_backup.onclick = function() {
            codemodalfzr_backup.style.display = "none";
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
    window.onclick = function(event) {
        if (event.target == codemodalfzr_edit) {
            codemodalfzr_edit.style.display = "none";
        }
        if (event.target == codemodalfzr) {
            codemodalfzr.style.display = "none";
        }
        if (event.target == codemodalfzr_backup) {
            codemodalfzr_backup.style.display = "none";
        }
    }
});