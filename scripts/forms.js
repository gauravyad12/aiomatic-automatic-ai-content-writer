"use strict";
jQuery(document).ready(function ($)
{
    $(document).on('change','.aiomatic-create-template-field-type', function(e){
        var type = $(e.currentTarget).val();
        var parentEl = $(e.currentTarget).closest('.aiomatic-template-form-field');
        parentEl.find('.aiomatic-create-template-field-value-main').show();
        if(type === 'select' || type === 'radio' || type === 'checkbox' || type === 'html'){
            parentEl.find('.aiomatic-create-template-field-options-main').show();
            parentEl.find('.aiomatic-create-template-field-min-main').hide();
            parentEl.find('.aiomatic-create-template-field-placeholder-main').hide();
            parentEl.find('.aiomatic-create-template-field-limit-main').hide();
            parentEl.find('.aiomatic-create-template-field-max-main').hide();
            parentEl.find('.aiomatic-create-template-field-rows-main').hide();
            parentEl.find('.aiomatic-create-template-field-cols-main').hide();
        }
        else if(type === 'textarea'){
            parentEl.find('.aiomatic-create-template-field-rows-main').show();
            parentEl.find('.aiomatic-create-template-field-cols-main').show();
            parentEl.find('.aiomatic-create-template-field-options-main').hide();
            parentEl.find('.aiomatic-create-template-field-placeholder-main').show();
            parentEl.find('.aiomatic-create-template-field-limit-main').show();
            parentEl.find('.aiomatic-create-template-field-min-main').hide();
            parentEl.find('.aiomatic-create-template-field-max-main').hide();
        }
        else if(type === 'number'){
            parentEl.find('.aiomatic-create-template-field-rows-main').hide();
            parentEl.find('.aiomatic-create-template-field-cols-main').hide();
            parentEl.find('.aiomatic-create-template-field-options-main').hide();
            parentEl.find('.aiomatic-create-template-field-placeholder-main').show();
            parentEl.find('.aiomatic-create-template-field-limit-main').show();
            parentEl.find('.aiomatic-create-template-field-min-main').show();
            parentEl.find('.aiomatic-create-template-field-max-main').show();
        }
        else{
            parentEl.find('.aiomatic-create-template-field-rows-main').hide();
            parentEl.find('.aiomatic-create-template-field-cols-main').hide();
            parentEl.find('.aiomatic-create-template-field-options-main').hide();
            parentEl.find('.aiomatic-create-template-field-placeholder-main').show();
            parentEl.find('.aiomatic-create-template-field-limit-main').show();
            parentEl.find('.aiomatic-create-template-field-min-main').hide();
            parentEl.find('.aiomatic-create-template-field-max-main').hide();
        }
    })
    var aiomaticCreateField = $('.aiomatic-template-form-field-default');
    $('#aiomatic-create-form-field').on("click", function(e){
        e.preventDefault();
        if(aiomaticCreateField !== null)
        {
            var temphtml = aiomaticCreateField.html().replace(' aiomatic-hidden-form','');       
            $('.aiomatic-template-fields').append(temphtml);
            aiomaticSortField();
        }
    });
    $('body').on("click", '.aiomatic-create-form-field', function(e){
        e.preventDefault();
        if(aiomaticCreateField !== null)
        {
            var temphtml = aiomaticCreateField.html().replace(' aiomatic-hidden-form','');       
            $('.aiomatic-template-fields').append(temphtml);
            aiomaticSortField();
        }
    });
    $('#aiomatic-show-hide-field').on("click", function(e){
        e.preventDefault();
        if(jQuery('#hideAdv').is(":visible"))
        {            
            jQuery("#hideAdv").hide();
        }
        else
        {
            jQuery("#hideAdv").show();
        }
    });
    $(document).on('click','.aiomatic-show-hide-field', function(e){
        e.preventDefault();
        if(jQuery('#hideAdv_edit').is(":visible"))
        {            
            jQuery("#hideAdv_edit").hide();
        }
        else
        {
            jQuery("#hideAdv_edit").show();
        }
    });
    $(document).on('click','.header-al-right', function(e){
        e.preventDefault();
        if(jQuery('.main-form-holder').is(":visible"))
        {            
            jQuery(".main-form-holder").hide();
            jQuery('.header-al-right').html('Show Input Fields');
        }
        else
        {
            jQuery(".main-form-holder").show();
            jQuery('.header-al-right').html('Hide Input Fields');
        }
    });
    function aioGenerateRandomString(length) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        const charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    $(document).on('click','.aiomatic-field-delete', function(e){
        if(confirm('Are you sure you want to delete this field?'))
        {
            $(e.currentTarget).parent().parent().parent().remove();
            aiomaticSortField();
        }
    });
    $(document).on('click','.aiomatic-field-up', function(e){
        let field = $(e.currentTarget).parent().parent().parent();
        let prevField = field.prev('.aiomatic-template-form-field');
        if (prevField.length !== 0) {
            field.insertBefore(prevField);
            aiomaticSortField();
        }
    });
    $(document).on('click','.aiomatic-field-down', function(e){
        let field = $(e.currentTarget).parent().parent().parent();
        let nextField = field.next('.aiomatic-template-form-field');
        if (nextField.length !== 0) {
            field.insertAfter(nextField);
            aiomaticSortField();
        }
    });
    $(document).on('click', '.aiomatic-field-duplicate', function(e) 
    {
        if(confirm('Are you sure you want to duplicate this field?'))
        {
            let clonedElement = $(e.currentTarget).parent().parent().parent().clone();
            let inputField = clonedElement.find('input[placeholder="my_unique_input_id"]');
            let originalValue = inputField.val();
            inputField.val(originalValue + '-' + aioGenerateRandomString(5));
            $(e.currentTarget).parent().parent().parent().after(clonedElement);
            aiomaticSortField();
        }
    });
    $(document).on('click','.aiomatic-field-delete-add', function(e){
        if(confirm('Are you sure you want to delete this field?'))
        {
            $(e.currentTarget).parent().parent().remove();
            aiomaticSortField();
        }
    });
    $(document).on('click','.aiomatic-field-up-add', function(e){
        let field = $(e.currentTarget).parent().parent();
        let prevField = field.prev('.aiomatic-template-form-field');
        if (prevField.length !== 0) {
            field.insertBefore(prevField);
            aiomaticSortField();
        }
    });
    $(document).on('click','.aiomatic-field-down-add', function(e){
        let field = $(e.currentTarget).parent().parent();
        let nextField = field.next('.aiomatic-template-form-field');
        if (nextField.length !== 0) {
            field.insertAfter(nextField);
            aiomaticSortField();
        }
    });
    $(document).on('click', '.aiomatic-field-duplicate-add', function(e) 
    {
        if(confirm('Are you sure you want to duplicate this field?'))
        {
            let clonedElement = $(e.currentTarget).parent().parent().clone();
            let inputField = clonedElement.find('input[placeholder="my_unique_input_id"]');
            let originalValue = inputField.val();
            inputField.val(originalValue + '-' + aioGenerateRandomString(5));
            $(e.currentTarget).parent().parent().after(clonedElement);
            aiomaticSortField();
        }
    });
    var aiomaticFieldInputs = ['label','id','required','type','min','max','options','rows','cols','placeholder','limit','value'];
    function aiomaticSortField(){
        $('.aiomatic-template-fields .aiomatic-template-form-field').each(function(idx, item){
            $.each(aiomaticFieldInputs, function(idxy, field){
                $(item).find('.aiomatic-create-template-field-'+field).attr('name','aiomaticfields['+idx+']['+field+']');
            });
        })
    }
    $("#checkedAll").on('change', function() {
        if (this.checked) {
            $(".aiomatic-select-form").each(function() {
                this.checked=true;
            });
        } else {
            $(".aiomatic-select-form").each(function() {
                this.checked=false;
            });
        }
    });
    function aiomaticLoading(btn)
    {
        btn.attr('disabled','disabled');
        if(!btn.find('spinner').length){
            btn.append('<span class="spinner"></span>');
        }
        btn.find('.spinner').css('visibility','unset');
    }
    function aiomaticDisable(btn)
    {
        btn.prop('disabled', true);
    }
    function aiomaticEnable(btn)
    {
        btn.removeAttr('disabled');
    }
    function aiomaticRmLoading(btn)
    {
        btn.removeAttr('disabled');
        btn.find('.spinner').remove();
    }
    $('#aiomatic_sync_forms').on('click', function (){
        var btn = $(this);
        aiomaticLoading(btn);
        var currentUrl = window.location.href;
        var updatedUrl = currentUrl.replace(/(\?|&)wpage=[^&]+/, '');
        window.location.href = updatedUrl;
    });
    $('#aiomatic_upload_forms').on('click', function (){
        if(confirm('Are you sure you want to add forms from the CSV file?'))
        {
            var aiomatic_csv_upload = $('#aiomatic_csv_upload');
            var btn = $(this);
            aiomaticLoading(btn);
            var data = {
                action: 'aiomatic_upload_forms',
                nonce: aiomatic_object.nonce,
            };
            if(aiomatic_csv_upload[0].files.length === 0){
                alert('Please select a file!');
            }
            else{
                var aiomatic_max_file_size = aiomatic_object.maxfilesize;
                var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
                var aiomatic_form_file = aiomatic_csv_upload[0].files[0];
                var aiomatic_form_file_extension = aiomatic_form_file.name.substr( (aiomatic_form_file.name.lastIndexOf('.') +1) );
                if(aiomatic_form_file_extension !== 'csv'){
                    aiomatic_csv_upload.val('');
                    alert('This feature only accepts csv file type!');
                }
                else if(aiomatic_form_file.size > aiomatic_max_file_size){
                    aiomatic_csv_upload.val('');
                    alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
                }
                else{
                    var reader = new FileReader();
                    reader.readAsText(aiomatic_form_file, "UTF-8");
                    reader.onload = function (evt) {
                        var formData = new FormData();
                        formData.append('action', 'aiomatic_forms_upload');
                        formData.append('xfile', evt.target.result);
                        formData.append('nonce', aiomatic_object.nonce);
                        $.ajax({
                            url: aiomatic_object.ajax_url,
                            type: 'POST',
                            dataType: 'JSON',
                            data: formData,
                            success: function(res) {
                                if(res.status === 'success'){
                                    aiomaticRmLoading(btn);
                                    alert('File uploaded successfully!');
                                }
                                else{
                                    aiomaticRmLoading(btn);
                                    alert('An error occured: ' + JSON.stringify(res));
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            error: function (r, s, error){
                                aiomaticRmLoading(btn);
                                    alert('Unable to upload file: ' + error);
                            }
                        });
                    }
                    reader.onerror = function (evt) {
                        alert("Error reading file: " + aiomatic_form_file.name + ' - ' + reader.error);
                    }
                }
            }
        }
    });
    $('#aiomatic_deleteall_forms').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete ALL forms?'))
        {
            var btn = $(this);
            aiomaticLoading(btn);
            var data = {
                action: 'aiomatic_deleteall_forms',
                nonce: aiomatic_object.nonce,
            };
            $.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        $('.aiomatic-forms-success').show();
                        $('.aiomatic-forms-content').val('');
                        setTimeout(function (){
                            $('.aiomatic-forms-success').hide();
                        },2000);
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing form removal: ' + error);
                }
            });
        }
    });
    $('#aiomatic_delete_selected_forms').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete selected forms?'))
        {
            var btn = $(this);
            aiomaticLoading(btn);
            var ids = [];
            $('.aiomatic-select-form:checked').each(function (idx, item) {
                ids.push($(item).val())
            });
            if (ids.length) {
                var data = {
                    action: 'aiomatic_delete_selected_form',
                    nonce: aiomatic_object.nonce,
                    ids: ids
                };
                $.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res){
                        aiomaticRmLoading(btn);
                        if(res.status === 'success'){
                            $('.aiomatic-forms-success').show();
                            $('.aiomatic-forms-content').val('');
                            setTimeout(function (){
                                $('.aiomatic-forms-success').hide();
                            },2000);
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing form removal: ' + error);
                    }
                });
            } else {
                alert('No forms selected');
                aiomaticRmLoading(btn);
            }
        }
    });
    $('#aiomatic_forms_form').on('submit', function (e)
    {
        e.preventDefault();
        var form = $('#aiomatic_forms_form');
        var btn = form.find('#aiomatic-form-save-button');
        var title = $('#aiomatic-form-title').val();
        var prompt = $('#aiomatic-form-prompt').val();
        if(title === '' || prompt === ''){
            alert('Please insert all required values!');
        }
        else{
            var data = form.serialize();
            $.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading(btn);
                },
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        $('.aiomatic-forms-success').html("Form saved successfully, you can use the following shortcode to show it:<br/><b>[aiomatic-form id='" + res.id + "']</b>");
                        $('.aiomatic-forms-success').show();
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing form saving: ' + error);
                }
            });
        }
        return false;
    });
    $('body').on("click", '#aiomatic-form-save-button_edit',function(e)
    {
        var form = $('#aiomatic_forms_form_edit');
        var btn = form.find('#aiomatic-form-save-button_edit');
        var title = $('#aiomatic-form-title_edit').val();
        var prompt = $('#aiomatic-form-prompt_edit').val();
        var submit = $('#aiomatic-submit_edit').val();
        if(title === '' || prompt === '' || submit == ''){
            alert('Please insert all required values!');
        }
        else{
            var data = form.serialize();
            $.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading(btn);
                },
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        $('.aiomatic-forms-success').html("Form saved successfully, you can use the following shortcode to show it:<br/><b>[aiomatic-form id='" + res.id + "']</b>");
                        $('.aiomatic-forms-success').show();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing form saving: ' + error);
                }
            });
        }
        location.reload();
        return false;
    });
    $(".aiomatic_delete_form").on('click', function(e) {
        if(confirm('Are you sure you want to delete this form?'))
        {
            var formid = $(this).attr("delete-id");
            if(formid == '')
            {
                alert('Incorrect delete id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_delete_form',
                    formid: formid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticDisable($('#aiomatic_delete_form_' + formid));
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
                        alert('Error in processing form deletion: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    $(".aiomatic_duplicate_form").on('click', function(e) {
        if(confirm('Are you sure you want to duplicate this form?'))
        {
            var formid = $(this).attr("data-id");
            if(formid == '')
            {
                alert('Incorrect data id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_duplicate_form',
                    formid: formid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticDisable($('#aiomatic_duplicate_form_' + formid));
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
                        alert('Error in processing form duplication: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    var aiomatic_form_button = $('#aiomatic_form_default_button');
    aiomatic_form_button.on('click', function (e){
        if(confirm('Are you sure you want to load the default forms which came bundled with the plugin?'))
        {
            e.preventDefault();
            var data = {
                action: 'aiomatic_default_form',
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticDisable($('#aiomatic_form_default_button'));
                },
                success: function (res){
                    if(res.status === 'success'){
                        alert('Default forms loaded successfully!');
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                        location.reload();
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing form loading: ' + error);
                    location.reload();
                }
            });
        }
    });
    var aiomatic_manage_form = $('.aiomatic_manage_form');
    var aiomaticAjaxRunning = false;
    aiomatic_manage_form.on('click', function (){
        if(!aiomaticAjaxRunning) {
            var btn = $(this);
            var id = btn.attr('data-id');
            $.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_get_form', id: id, nonce: aiomatic_object.nonce},
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
                        $('.aiomatic_modal_title').html('Edit this form');
                        $('.aiomatic_modal_content').html(res.data);
                        $('.aiomatic-overlay').show();
                        $('.aiomatic_modal').show();
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing form editing: ' + error);
                }
            });
        }
    });
    
    var aiomatic_preview_form = $('.aiomatic_preview_form');
    aiomatic_preview_form.on('click', function (){
        if(!aiomaticAjaxRunning) {
            var btn = $(this);
            var id = btn.attr('data-id');
            $.ajax({
                url: aiomatic_object.ajax_url,
                data: {action: 'aiomatic_preview_form', id: id, nonce: aiomatic_object.nonce},
                type: 'POST',
                beforeSend: function () {
                    aiomaticAjaxRunning = true;
                    $('.aiomatic_modal_content').html('');
                    aiomaticLoading(btn);
                },
                success: function (res) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    $('.aiomatic_modal_title').html('');
                    $('.aiomatic_modal_content').html(res);
                    $('.aiomatic-overlay').show();
                    $('.aiomatic_modal').show();
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing form previewing: ' + error);
                }
            });
        }
    });
    $('.aiomatic_modal_close').on('click', function (){
        $('.aiomatic_modal_close').closest('.aiomatic_modal').hide();
        $('.aiomatic_modal_close').closest('.aiomatic_modal').removeClass('aiomatic-small-modal');
        $('.aiomatic-overlay').hide();
    });
    var aiomatic_form_button = $('#aiomatic_form_button');
    aiomatic_form_button.on('click', function (){
        if(confirm('Are you sure you want to load forms from file?'))
        {
            var aiomatic_form_upload = $('#aiomatic_form_upload');
            if($("#aiomatic_overwrite").is(':checked'))
            {
                var overwrite = '1';
            }
            else
            {
                var overwrite = '0';
            }
            if(aiomatic_form_upload[0].files.length === 0){
                alert('Please select a file!');
            }
            else{
                var aiomatic_progress = $('.aiomatic_progress');
                var aiomatic_error_message = $('.aiomatic-error-msg');
                var aiomatic_upload_success = $('.aiomatic_upload_success');
                var aiomatic_max_file_size = aiomatic_object.maxfilesize;
                var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
                var aiomatic_form_file = aiomatic_form_upload[0].files[0];
                var aiomatic_form_file_extension = aiomatic_form_file.name.substr( (aiomatic_form_file.name.lastIndexOf('.') +1) );
                if(aiomatic_form_file_extension !== 'json'){
                    aiomatic_form_upload.val('');
                    alert('This feature only accepts JSON file type!');
                }
                else if(aiomatic_form_file.size > aiomatic_max_file_size){
                    aiomatic_form_upload.val('');
                    alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
                }
                else{
                    var formData = new FormData();
                    formData.append('action', 'aiomatic_form_upload');
                    formData.append('nonce', aiomatic_object.nonce);
                    formData.append('overwrite', overwrite);
                    formData.append('file', aiomatic_form_file);
                    $.ajax({
                        url: aiomatic_object.ajax_url,
                        type: 'POST',
                        dataType: 'JSON',
                        data: formData,
                        beforeSend: function (){
                            aiomatic_progress.find('span').css('width','0');
                            aiomatic_progress.show();
                            aiomaticLoading(aiomatic_form_button);
                            aiomatic_error_message.hide();
                            aiomatic_upload_success.hide();
                        },
                        xhr: function() {
                            var xhr = $.ajaxSettings.xhr();
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
                                aiomaticRmLoading(aiomatic_form_button);
                                aiomatic_progress.hide();
                                aiomatic_form_upload.val('');
                                aiomatic_upload_success.show();
                                location.reload();
                            }
                            else{
                                aiomaticRmLoading(aiomatic_form_button);
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
                            aiomatic_form_upload.val('');
                            aiomaticRmLoading(aiomatic_form_button);
                            aiomatic_progress.addClass('aiomatic_error');
                            aiomatic_progress.find('small').html('Error');
                            alert('Error in processing forms uploading: ' + error);
                            aiomatic_error_message.show();
                        }
                    });
                }
            }
        }
    });
    $('body').on("change", '#aiomatic-edit-type', function(e){
        var value = $(this).children(":selected").attr("value");
        if(value != 'text')
        {
            $('.aiomatic-hide-not-text').hide();
        }
        else
        {
            $('.aiomatic-hide-not-text').show();
        }
    });
    $('body').on("change", '#aiomatic-type', function(e){
        var value = $(this).children(":selected").attr("value");
        if(value != 'text')
        {
            $('.hide-when-not-text').hide();
        }
        else
        {
            $('.hide-when-not-text').show();
        }
    });
});