"use strict";
var moder_gpt_models_aiomatic = ['gpt-3.5-turbo-0125', 'gpt-3.5-turbo-0613', 'gpt-3.5-turbo-1106', 'gpt-4-0613', 'gpt-4']
function aiomatic_training_data_changed()
{
    var select = jQuery('#model_selector_data_training').val();
    if(moder_gpt_models_aiomatic.includes(select))
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
    var aiomatic_file_button = $('#aiomatic_file_button');
    var aiomatic_file_upload = $('#aiomatic_file_upload');
    var aiomatic_file_purpose = $('#aiomatic_file_purpose');
    var aiomatic_file_name = $('#aiomatic_file_name');
    var aiomatic_file_model = $('#aiomatic_file_model');
    var aiomatic_progress = $('.aiomatic_progress');
    var aiomatic_error_message = $('.aiomatic-error-msg');
    var aiomatic_create_fine_tune = $('.aiomatic_create_fine_tune');
    var aiomatic_retrieve_content = $('.aiomatic_retrieve_content');
    var aiomatic_delete_file = $('.aiomatic_delete_file');
    var aiomatic_ajax_url = aiomatic_object.ajax_url;
    var aiomatic_upload_success = $('.aiomatic_upload_success');
    aiomatic_file_button.on('click', function (){
        if(aiomatic_file_upload[0].files.length === 0){
            alert('Please select a file!');
        }
        else{
            var aiomatic_file = aiomatic_file_upload[0].files[0];
            var aiomatic_file_extension = aiomatic_file.name.substr( (aiomatic_file.name.lastIndexOf('.') +1) );
            if(aiomatic_file_extension !== 'jsonl'){
                aiomatic_file_upload.val('');
                alert('This feature only accepts JSONL file type!');
            }
            else if(aiomatic_file.size > aiomatic_max_file_size){
                aiomatic_file_upload.val('');
                alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
            }
            else{
                var formData = new FormData();
                formData.append('action', 'aiomatic_finetune_upload');
                formData.append('file', aiomatic_file);
                formData.append('purpose', aiomatic_file_purpose.val());
                formData.append('model', aiomatic_file_model.val());
                formData.append('name', aiomatic_file_name.val());
                formData.append('nonce', aiomatic_object.nonce);
                $.ajax({
                    url: aiomatic_ajax_url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    beforeSend: function (){
                        aiomatic_progress.find('span').css('width','0');
                        aiomatic_progress.show();
                        aiomaticLoading(aiomatic_file_button);
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
                            aiomaticRmLoading(aiomatic_file_button);
                            aiomatic_progress.hide();
                            aiomatic_file_upload.val('');
                            aiomatic_upload_success.show();
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
    function aiomaticSortData(){
        $('.aiomatic_data').each(function (idx, item){
            $(item).find('.aiomatic_data_prompt').attr('name','data['+idx+'][prompt]');
            $(item).find('.aiomatic_data_completion').attr('name','data['+idx+'][completion]');
        });
        $('.aiomatic_new_data').each(function (idx, item){
            $(item).find('.aiomatic_new_data_system').attr('name','new_data['+idx+'][system]');
            $(item).find('.aiomatic_new_data_prompt').attr('name','new_data['+idx+'][prompt]');
            $(item).find('.aiomatic_new_data_completion').attr('name','new_data['+idx+'][completion]');
        });
    }
    var aiomatic_item = '<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea> </div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion"></textarea><span class="button button-link-delete">×</span></div></div>';
    var aiomatic_new_item = '<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System"></textarea> </div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User"></textarea> </div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant"></textarea><span class="button button-link-delete">×</span></div></div>';
    var aiomatic_data_restore = window.localStorage.getItem('aiomatic_data_list');
    if(aiomatic_data_restore !== null && aiomatic_data_restore !== "")
    {
        var appendData = '';
        var oldobj = '';
        try{
            oldobj = JSON.parse(aiomatic_data_restore);
            oldobj.forEach(function (element){if(element.prompt !== null && element.completion !== null && element.prompt !== undefined && element.completion !== undefined){appendData += '<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt">' + element.prompt + '</textarea> </div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion">' + element.completion + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
            appendData += aiomatic_item;
            $('#aiomatic_data_list').html(appendData);
        }
        catch(e)
        {
            alert(e);
        }
    }
    var aiomatic_new_data_restore = window.localStorage.getItem('aiomatic_new_data_list');
    if(aiomatic_new_data_restore !== null && aiomatic_new_data_restore !== "")
    {
        var appendData = '';
        var oldobj = '';
        try{
            oldobj = JSON.parse(aiomatic_new_data_restore);
            oldobj.forEach(function (element){if(element.prompt !== null && element.completion !== null && element.prompt !== undefined && element.completion !== undefined){appendData += '<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System">' + element.system + '</textarea> </div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User">' + element.prompt + '</textarea> </div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant">' + element.completion + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
            appendData += aiomatic_new_item;
            $('#aiomatic_new_data_list').html(appendData);
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
        var select = jQuery('#model_selector_data_training').val();
        if(moder_gpt_models_aiomatic.includes(select))
        {
            $('#aiomatic_new_data_list').append(aiomatic_new_item);
        }
        else
        {
            $('#aiomatic_data_list').append(aiomatic_item);
        }
        aiomaticSortData();
        var total = 0;
        var lists = [];
        $('.aiomatic_data').each(function (idx, item){
            var item_prompt = $(item).find('.aiomatic_data_prompt').val();
            var item_completion = $(item).find('.aiomatic_data_completion').val();
            if(item_prompt !== '' && item_completion !== ''){
                total += 1;
                lists.push({prompt: item_prompt, completion: item_completion});
            }
        });
        if(total > 0){
            try
            {
                var jsonstr = JSON.stringify(lists);
                window.localStorage.setItem('aiomatic_data_list', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
        var new_total = 0;
        var new_lists = [];
        $('.aiomatic_new_data').each(function (idx, item){
            var item_system = $(item).find('.aiomatic_new_data_system').val();
            var item_prompt = $(item).find('.aiomatic_new_data_prompt').val();
            var item_completion = $(item).find('.aiomatic_new_data_completion').val();
            if(item_prompt !== '' && item_completion !== ''){
                new_total += 1;
                new_lists.push({system: item_system, prompt: item_prompt, completion: item_completion});
            }
        });
        if(new_total > 0){
            try
            {
                var jsonstr = JSON.stringify(new_lists);
                window.localStorage.setItem('aiomatic_new_data_list', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
    });
    aiomatic_clear_data.on('click', function ()
    {
        var select = jQuery('#model_selector_data_training').val();
        if(moder_gpt_models_aiomatic.includes(select))
        {
            $('#aiomatic_new_data_list').html('<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System"></textarea></div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User"></textarea></div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant"></textarea><span class="button button-link-delete">×</span></div></div>');
            window.localStorage.removeItem('aiomatic_new_data_list');
        }
        else
        {
            $('#aiomatic_data_list').html('<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea></div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion"></textarea><span class="button button-link-delete">×</span></div></div>');
            window.localStorage.removeItem('aiomatic_data_list');
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
    aiomatic_download_data.on('click', function (){
        var select = jQuery('#model_selector_data_training').val();
        if(moder_gpt_models_aiomatic.includes(select))
        {
            var total = 0;
            var lists = '';
            $('.aiomatic_new_data').each(function (idx, item){
                var item_system = $(item).find('.aiomatic_new_data_system').val();
                var item_prompt = $(item).find('.aiomatic_new_data_prompt').val();
                var item_completion = $(item).find('.aiomatic_new_data_completion').val();
                if(item_prompt !== '' && item_completion !== ''){
                    total += 1;
                    var messages = [
                    {
                        role: "system",
                        content: item_system
                    },
                    {
                        role: "user",
                        content: item_prompt
                    },
                    {
                        role: "assistant",
                        content: item_completion
                    }
                    ];
                    var json_arr = {
                        messages: messages
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
                    Download.save(lists, "new_data.jsonl");
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
                var item_completion = $(item).find('.aiomatic_data_completion').val();
                if(item_prompt !== '' && item_completion !== ''){
                    total += 1;
                    var json_arr = {};
                    json_arr['prompt'] = item_prompt;
                    json_arr['completion'] = item_completion;
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
                alert('This feature only accepts JSONL or CSV file type!');
            }
            else if(aiomatic_file.size > aiomatic_max_file_size)
            {
                aiomatic_file_load.val('');
                alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
            }
            else
            {
                var select = jQuery('#model_selector_data_training').val();
                if(moder_gpt_models_aiomatic.includes(select))
                {
                    var reader = new FileReader();
                    reader.readAsText(aiomatic_file, "UTF-8");
                    var thehtml = '';
                    reader.onload = function (evt) {
                        if(aiomatic_file_extension == 'jsonl')
                        {
                            var explodefile = evt.target.result.split(/\r?\n/);
                            explodefile.forEach(function (element){if(element.trim() !== ''){var oldobj = '';try{oldobj = JSON.parse(element.trim());}catch(e) {alert(e);}if(oldobj.hasOwnProperty("messages")){if(oldobj.messages[0].role !== null && oldobj.messages[1].role !== null && oldobj.messages[2].role !== null && oldobj.messages[0].role !== undefined && oldobj.messages[1].role !== undefined && oldobj.messages[2].role !== undefined){thehtml += '<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System">' + oldobj.messages[0].content + '</textarea> </div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User">' + oldobj.messages[1].content + '</textarea> </div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant">' + oldobj.messages[2].content + '</textarea><span class="button button-link-delete">×</span></div></div>';}}}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System"></textarea> </div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User"></textarea> </div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_new_data_list').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_new_data').each(function (idx, item){
                                    var item_system = $(item).find('.aiomatic_new_data_system').val();
                                    var item_prompt = $(item).find('.aiomatic_new_data_prompt').val();
                                    var item_completion = $(item).find('.aiomatic_new_data_completion').val();
                                    if(item_prompt !== '' && item_completion !== ''){
                                        total += 1;
                                        lists.push({system: item_system, prompt: item_prompt, completion: item_completion});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_new_data_list', jsonstr);
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
                            data.forEach(function (element){if(element[0] !== null && element[0] != '' && element[1] != '' && element[1] !== null && element[2] != '' && element[2] !== null){thehtml += '<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System">' + element[0] + '</textarea> </div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User">' + element[1] + '</textarea> </div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant">' + element[2] + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_new_data_item aiomatic_new_data"><div><textarea rows="1" name="new_data[0][system]" class="regular-text aiomatic_new_data_system aiomatic_height" placeholder="System"></textarea> </div><div><textarea rows="1" name="new_data[0][prompt]" class="regular-text aiomatic_new_data_prompt aiomatic_height" placeholder="User"></textarea> </div><div><textarea rows="1" name="new_data[0][completion]" class="regular-text aiomatic_new_data_completion aiomatic_height" placeholder="Assistant"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_new_data_list').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_new_data').each(function (idx, item){
                                    var item_system = $(item).find('.aiomatic_new_data_system').val();
                                    var item_prompt = $(item).find('.aiomatic_new_data_prompt').val();
                                    var item_completion = $(item).find('.aiomatic_new_data_completion').val();
                                    if(item_prompt !== '' && item_completion !== ''){
                                        total += 1;
                                        lists.push({system: item_system, prompt: item_prompt, completion: item_completion});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_new_data_list', jsonstr);
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
                            explodefile.forEach(function (element){if(element.trim() !== ''){var oldobj = '';try{oldobj = JSON.parse(element.trim());}catch(e) {alert(e);}if(oldobj.hasOwnProperty("prompt")){if(oldobj.prompt !== null && oldobj.completion !== null){thehtml += '<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt">' + oldobj.prompt + '</textarea> </div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion">' + oldobj.completion + '</textarea><span class="button button-link-delete">×</span></div></div>';}}}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea> </div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_data_list').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_data').each(function (idx, item){
                                    var item_prompt = $(item).find('.aiomatic_data_prompt').val();
                                    var item_completion = $(item).find('.aiomatic_data_completion').val();
                                    if(item_prompt !== '' && item_completion !== ''){
                                        total += 1;
                                        lists.push({prompt: item_prompt, completion: item_completion});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_data_list', jsonstr);
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
                            data.forEach(function (element){if(element[0] !== null && element[0] != '' && element[1] != '' && element[1] !== null){thehtml += '<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt">' + element[0] + '</textarea> </div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion">' + element[1] + '</textarea><span class="button button-link-delete">×</span></div></div>';}});
                            if(thehtml !== '')
                            {
                                thehtml += '<div class="aiomatic_data_item aiomatic_data"><div><textarea rows="1" name="data[0][prompt]" class="regular-text aiomatic_data_prompt aiomatic_height" placeholder="Prompt"></textarea> </div><div><textarea rows="1" name="data[0][completion]" class="regular-text aiomatic_data_completion aiomatic_height" placeholder="Completion"></textarea><span class="button button-link-delete">×</span></div></div>';
                                $('#aiomatic_data_list').html(thehtml);
                                var total = 0;
                                var lists = [];
                                $('.aiomatic_data').each(function (idx, item){
                                    var item_prompt = $(item).find('.aiomatic_data_prompt').val();
                                    var item_completion = $(item).find('.aiomatic_data_completion').val();
                                    if(item_prompt !== '' && item_completion !== ''){
                                        total += 1;
                                        lists.push({prompt: item_prompt, completion: item_completion});
                                    }
                                });
                                if(total > 0){
                                    try
                                    {
                                        var jsonstr = JSON.stringify(lists);
                                        window.localStorage.setItem('aiomatic_data_list', jsonstr);
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
            var item_completion = $(item).find('.aiomatic_data_completion').val();
            if(item_prompt !== '' && item_completion !== ''){
                total += 1;
                lists.push({prompt: item_prompt, completion: item_completion});
            }
        });
        if(total > 0){
            try
            {
                var jsonstr = JSON.stringify(lists);
                window.localStorage.setItem('aiomatic_data_list', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
        else
        {
            window.localStorage.removeItem('aiomatic_data_list');
        }
        aiomaticSortData();
    });
    
    $(document).on('click','.aiomatic_new_data span', function (e){
        $(e.currentTarget).parent().parent().remove();
        var total = 0;
        var lists = [];
        $('.aiomatic_new_data').each(function (idx, item){
            var item_system = $(item).find('.aiomatic_new_data_system').val();
            var item_prompt = $(item).find('.aiomatic_new_data_prompt').val();
            var item_completion = $(item).find('.aiomatic_new_data_completion').val();
            if(item_prompt !== '' && item_completion !== ''){
                total += 1;
                lists.push({system: item_system, prompt: item_prompt, completion: item_completion});
            }
        });
        if(total > 0){
            try
            {
                var jsonstr = JSON.stringify(lists);
                window.localStorage.setItem('aiomatic_new_data_list', jsonstr);
            }
            catch(e)
            {
                alert(e);
            }
        }
        else
        {
            window.localStorage.removeItem('aiomatic_new_data_list');
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
                        var select = jQuery('#model_selector_data_training').val();
                        if(moder_gpt_models_aiomatic.includes(select))
                        {
                            $('#aiomatic_new_data_list').html(aiomatic_new_item);
                        }
                        else
                        {
                            $('#aiomatic_data_list').html(aiomatic_item);
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
        if(file == '' && name != '')
        {
            file = name;
        }
        var data = {
            action: 'aiomatic_data_insert',
            prompt: aiomatic_stripslashes(lists[start].prompt),
            completion: aiomatic_stripslashes(lists[start].completion),
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
                    var percent = Math.ceil((start+1)*90/lists.length);
                    progressBar.find('small').html(percent+'%');
                    progressBar.find('span').css('width',percent+'%');
                    if((start + 1) === lists.length){
                        $('#aiomatic_upload_convert input[name=model]').val(model);
                        $('#aiomatic_upload_convert input[name=purpose]').val(purpose);
                        $('#aiomatic_upload_convert input[name=custom]').val(name);
                        $('#aiomatic_upload_convert input[name=file]').val(res.file);
                        var data = $('#aiomatic_upload_convert').serialize();
                        aiomaticFileUpload(data, btn);
                    }
                    else{
                        aiomaticProcessData(lists, (start+1), file, btn);
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
                alert('Error in processing data: ' + error);
            }
        });
    }
    function aiomaticNewProcessData(lists, start, file, btn){
        var purpose = $('select[name=purpose]').val();
        var model = $('select[name=model]').val();
        var name = $('#file-name-holder').val();
        if(file == '' && name != '')
        {
            file = name;
        }
        var data = {
            action: 'aiomatic_new_data_insert',
            system: aiomatic_stripslashes(lists[start].system),
            prompt: aiomatic_stripslashes(lists[start].prompt),
            completion: aiomatic_stripslashes(lists[start].completion),
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
                    var percent = Math.ceil((start+1)*90/lists.length);
                    progressBar.find('small').html(percent+'%');
                    progressBar.find('span').css('width',percent+'%');
                    if((start + 1) === lists.length){
                        $('#aiomatic_upload_convert input[name=model]').val(model);
                        $('#aiomatic_upload_convert input[name=purpose]').val(purpose);
                        $('#aiomatic_upload_convert input[name=custom]').val(name);
                        $('#aiomatic_upload_convert input[name=file]').val(res.file);
                        var data = $('#aiomatic_upload_convert').serialize();
                        aiomaticFileUpload(data, btn);
                    }
                    else{
                        aiomaticNewProcessData(lists, (start+1), file, btn);
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
                alert('Error in processing data: ' + error);
            }
        });
    }
    form.on('submit', function (){
        var select = jQuery('#model_selector_data_training').val();
        if(moder_gpt_models_aiomatic.includes(select))
        {
            var total = 0;
            var lists = [];
            var btn = form.find('.aiomatic_submit');
            $('.aiomatic_new_data').each(function (idx, item){
                var item_system = $(item).find('.aiomatic_new_data_system').val();
                var item_prompt = $(item).find('.aiomatic_new_data_prompt').val();
                var item_completion = $(item).find('.aiomatic_new_data_completion').val();
                if(item_prompt !== '' && item_completion !== ''){
                    total += 1;
                    lists.push({system: item_system, prompt: item_prompt, completion: item_completion })
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
                var item_completion = $(item).find('.aiomatic_data_completion').val();
                if(item_prompt !== '' && item_completion !== ''){
                    total += 1;
                    lists.push({prompt: item_prompt, completion: item_completion })
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
    var form = $('#aiomatic_data_converter');
    var btn = $('.aiomatic_converter_button');
    var progressBar = $('.aiomatic-convert-bar');
    var aiomatic_convert_upload = $('.aiomatic_convert_upload');
    var aiomatic_delete_upload = $('.aiomatic_delete_upload');
    function aiomaticConverter(data){
        $.ajax({
            url: aiomatic_ajax_url,
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function (res){
                if(res.status === 'success'){
                    if(res.next_page === 'DONE'){
                        aiomaticRmLoading(btn);
                        progressBar.find('small').html('100%');
                        progressBar.find('span').css('width','100%');
                        setTimeout(function (){
                            window.location.reload();
                        },1000);
                    }
                    else{
                        var percent = Math.ceil(data.page*100/data.total);
                        progressBar.find('small').html(percent+'%');
                        progressBar.find('span').css('width',percent+'%');
                        data.page = res.next_page;
                        data.file = res.file;
                        data.id = res.id;
                        aiomaticConverter(data);
                    }
                }
                else{
                    progressBar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert(res.msg);
                }
            },
            error: function (request, status, error){
                progressBar.addClass('aiomatic_error');
                aiomaticRmLoading(btn);
                alert('Error in processing: ' + error);
            }
        });
    }
    form.on('submit', function (){
        if(!$('.aiomatic_converter_data:checked').length){
            alert('Please select least one data to convert');
        }
        else{
            var data = form.serialize();
            $.ajax({
                url: aiomatic_ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    progressBar.show();
                    progressBar.removeClass('aiomatic_error')
                    progressBar.find('span').css('width',0);
                    progressBar.find('small').html('0%');
                    aiomaticLoading(btn);
                },
                success: function (res){
                    if(res.status === 'success'){
                        if(res.count > 0){
                            aiomaticConverter({action: 'aiomatic_data_converter', types: res.types, category: res.category, total: res.count, page: 1, per_page: 100, content_excerpt: res.content_excerpt, nonce: aiomatic_object.nonce});
                        }
                        else{
                            progressBar.addClass('aiomatic_error');
                            aiomaticRmLoading(btn);
                            alert('Nothing to convert');
                        }
                    }
                    else{
                        progressBar.addClass('aiomatic_error');
                        aiomaticRmLoading(btn);
                        alert(res.msg);
                    }
                },
                error: function (request, status, error) {
                    progressBar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert('Error in processing: ' + error);
                }
            });
        }
        return false;
    });
    aiomatic_convert_upload.on('click', function (){
        var btn = $(this);
        var file = btn.attr('data-file');
        var lines = btn.attr('data-lines');
        $('.aiomatic-overlay').show();
        $('.aiomatic_modal').show();
        $('.aiomatic_modal_title').html('File Setting');
        $('.aiomatic_modal').addClass('aiomatic-small-modal');
        $('.aiomatic_modal_content').empty();
        var html = '<form id="aiomatic_upload_convert" action="" method="post"><input type="hidden" name="action" value="aiomatic_upload_convert"><input type="hidden" id="aiomatic_upload_convert_index" name="index" value="1"><input id="aiomatic_upload_convert_line" type="hidden" name="line" value="0"><input id="aiomatic_upload_convert_lines" type="hidden" value="'+lines+'"><input type="hidden" name="file" value="'+file+'"><p><label>Purpose</label>&nbsp;<select class="coderevolution_gutenberg_select" name="purpose"><option value="fine-tune">Fine-Tune</option></select></p>';
        html += '<p><label>Model Base</label>&nbsp;<select class="coderevolution_gutenberg_select" name="model"><option value="gpt-3.5-turbo-0125">gpt-3.5-turbo-0125</option><option value="gpt-4-0613">gpt-4-0613</option><option value="gpt-4">gpt-4</option><option value="gpt-3.5-turbo-0613">gpt-3.5-turbo-0613</option><option value="gpt-3.5-turbo-1106" selected>gpt-3.5-turbo-1106</option><option value="babbage-002">babbage-002</option><option value="davinci-002">davinci-002</option></select></p>';
        html += '<p><label>Custom Name</label>&nbsp;<input class="coderevolution_gutenberg_select" type="text" name="custom"></p>';
        html += '<div class="aiomatic-convert-progress aiomatic-upload-bar"><span></span><small>0%</small></div>';
        html += '<div class="aiomatic-upload-message"></div><p><button class="button button-primary coderevolution_gutenberg_select">Upload</button></p>'
        $('.aiomatic_modal_content').append(html);
    });
    aiomatic_delete_upload.on('click', function (){
        var btn = $(this);
        var file = btn.attr('data-file');
        $.ajax({
            url: aiomatic_ajax_url,
            data: {
                action: 'aiomatic_file_delete',
                file: file,
                nonce: aiomatic_object.nonce
            },
            type: 'POST',
            beforeSend: function (){
                progressBar.show();
                progressBar.removeClass('aiomatic_error')
                progressBar.find('span').css('width',0);
                progressBar.find('small').html('0%');
                aiomaticLoading(btn);
            },
            success: function (res){
                if(res.status === 'success'){
                    window.location.reload();
                }
                else{
                    progressBar.addClass('aiomatic_error');
                    aiomaticRmLoading(btn);
                    alert(res.msg);
                }
            },
            error: function (request, status, error) {
                progressBar.addClass('aiomatic_error');
                aiomaticRmLoading(btn);
                alert('Error in deleting: ' + error);
            }
        });
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
    $('.aiomatic_sync_files').on('click', function (){
        var btn = $(this);
        if(!aiomaticAjaxRunning) {
            $.ajax({
                url: aiomatic_ajax_url,
                data: {action: 'aiomatic_fetch_finetune_files', nonce: aiomatic_object.nonce},
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
                    alert('Error in processing sync: ' + error);
                }
            });
        }
    });
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
    $(document).on('click','#aiomatic_create_finetune_btn', function (e){
        if(!aiomaticAjaxRunning) {
            var btn = $(e.currentTarget);
            var id = $('#aiomatic_create_finetune_id').val();
            var model = $('#aiomatic_create_finetune_model').val();
            var hyper_epochs = $('#hyper_epochs').val();
            var hyper_batch = $('#hyper_batch').val();
            var hyper_rate = $('#hyper_rate').val();
            var hyper_loss = $('#hyper_loss').val();
            var hyper_suffix = $('#hyper_suffix').val();
            $.ajax({
                url: aiomatic_ajax_url,
                data: {action: 'aiomatic_create_finetune', id: id, model: model, hyper_epochs: hyper_epochs, hyper_batch: hyper_batch, hyper_rate: hyper_rate, hyper_loss: hyper_loss, hyper_suffix: hyper_suffix, nonce: aiomatic_object.nonce},
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function () {
                    aiomaticAjaxRunning = true;
                    aiomaticLoading(btn);
                },
                success: function (res) {
                    aiomaticRmLoading(btn);
                    aiomaticAjaxRunning = false;
                    if (res.status === 'success') {
                        window.location.reload();
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing new finetune: ' + error);
                }
            });
        }
    });
    aiomatic_create_fine_tune.on('click', function (){
        if(!aiomaticAjaxRunning) {
            var btn = $(this);
            var id = btn.attr('data-id');
            $.ajax({
                url: aiomatic_ajax_url,
                data: {action: 'aiomatic_create_finetune_modal', nonce: aiomatic_object.nonce},
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
                        $('.aiomatic_modal_content').empty();
                        $('.aiomatic-overlay').show();
                        $('.aiomatic_modal').show();
                        $('.aiomatic_modal_title').html('Choose Model');
                        $('.aiomatic_modal').addClass('aiomatic-small-modal');
                        var html = '<input type="hidden" id="aiomatic_create_finetune_id" value="' + id + '"><p><label>Select Model</label>';
                        html += '<select class="coderevolution_gutenberg_select" id="aiomatic_create_finetune_model">';
                        html += '<option value="">New Model</option>';
                        $.each(res.data, function (idx, item) {
                            html += '<option value="' + item + '">' + item + '</option>';
                        })
                        html += '</select>';
                        html += '</p>';
                        html += '<p>Enable Hyperparameters:&nbsp;<input type="checkbox" id="hyper_switcher" onchange="aiomatic_switcher_change()"></p>';
                        html += '<div id="hyper_div" style="display:none;">'
                        html += '<p>Number of Epochs:&nbsp;<input type="number" min="1" max="999" step="1" id="hyper_epochs" class="coderevolution_gutenberg_input" placeholder="The number of epochs to train the model for"></p>';
                        html += '<p>Batch Size:&nbsp;<input type="number" min="1" max="999" step="1" id="hyper_batch" class="coderevolution_gutenberg_input" placeholder="The batch size to use for training"></p>';
                        html += '<p>Learning Rate Multiplier:&nbsp;<input type="number" min="0" max="1" step="0.01" id="hyper_rate" class="coderevolution_gutenberg_input" placeholder="The learning rate multiplier to use for training"></p>';
                        html += '<p>Prompt Loss Weight:&nbsp;<input type="number" min="0" max="1" step="0.01" id="hyper_loss" class="coderevolution_gutenberg_input" placeholder="The weight to use for loss on the prompt tokens"></p>';
                        html += '<p>Model Suffix:&nbsp;<input type="text" id="hyper_suffix" class="coderevolution_gutenberg_input" placeholder="A string of up to 40 characters that will be added to your fine-tuned model name"></p>';
                        html += '</div>';
                        html += '<p><button class="button button-primary coderevolution_gutenberg_select" id="aiomatic_create_finetune_btn">Create</button></p>';
                        html += '<script>function aiomatic_switcher_change() {if(jQuery(\'#hyper_switcher\').is(":checked")) {jQuery("#hyper_div").show();} else {jQuery("#hyper_div").hide();}};</script>';
                        $('.aiomatic_modal_content').append(html);
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing new finetune modal: ' + error);
                }
            });
        }
    });
    aiomatic_retrieve_content.on('click', function (){
        if(!aiomaticAjaxRunning) {
            var btn = $(this);
            var id = btn.attr('data-id');
            $.ajax({
                url: aiomatic_ajax_url,
                data: {action: 'aiomatic_get_finetune_file', id: id, nonce: aiomatic_object.nonce},
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
                        $('.aiomatic_modal_title').html('File Content');
                        $('.aiomatic_modal_content').html('<pre>' + res.data + '</pre>');
                        $('.aiomatic-overlay').show();
                        $('.aiomatic_modal').show();
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (r, s, error) {
                    aiomaticAjaxRunning = false;
                    aiomaticRmLoading(btn);
                    alert('Error in processing finetune file: ' + error);
                }
            });
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
    var aiomatic_get_other = $('.aiomatic_get_other');
    var aiomatic_get_finetune = $('.aiomatic_get_finetune');
    var aiomatic_cancel_finetune = $('.aiomatic_cancel_finetune');
    var aiomatic_delete_finetune = $('.aiomatic_delete_finetune');
    aiomatic_cancel_finetune.on('click', function (){
        var conf = confirm('Are you sure?');
        if(conf) {
            var btn = $(this);
            var id = btn.attr('data-id');
            if (!aiomaticAjaxRunning) {
                aiomaticAjaxRunning = true;
                $.ajax({
                    url: aiomatic_ajax_url,
                    data: {action: 'aiomatic_cancel_finetune', id: id, nonce: aiomatic_object.nonce},
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function () {
                        aiomaticLoading(btn);
                    },
                    success: function (res) {
                        aiomaticRmLoading(btn);
                        aiomaticAjaxRunning = false;
                        if (res.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error) {
                        aiomaticRmLoading(btn);
                        aiomaticAjaxRunning = false;
                        alert('Error in processing finetune cancelling: ' + error);
                    }
                });
            }
        }
    });
    aiomatic_delete_finetune.on('click', function (){
        var conf = confirm('Are you sure?');
        if(conf) {
            var btn = $(this);
            var id = btn.attr('data-id');
            if (!aiomaticAjaxRunning) {
                aiomaticAjaxRunning = true;
                $.ajax({
                    url: aiomatic_ajax_url,
                    data: {action: 'aiomatic_delete_finetune', id: id, nonce: aiomatic_object.nonce},
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function () {
                        aiomaticLoading(btn);
                    },
                    success: function (res) {
                        aiomaticRmLoading(btn);
                        aiomaticAjaxRunning = false;
                        if (res.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error) {
                        aiomaticRmLoading(btn);
                        aiomaticAjaxRunning = false;
                        alert('Error in processing finetune deletion: ' + error);
                    }
                });
            }
        }
    });
    aiomatic_get_other.on('click', function (){
        var btn = $(this);
        var id = btn.attr('data-id');
        var type = btn.attr('data-type');
        var aiomaticTitle = btn.text().trim();
        if(!aiomaticAjaxRunning){
            aiomaticAjaxRunning = true;
            $.ajax({
                url: aiomatic_ajax_url,
                data: {action: 'aiomatic_other_finetune', id: id, type: type, nonce: aiomatic_object.nonce},
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading(btn);
                },
                success: function (res){
                    aiomaticRmLoading(btn);
                    aiomaticAjaxRunning = false;
                    if(res.status === 'success'){
                        $('.aiomatic_modal_title').html(aiomaticTitle);
                        $('.aiomatic_modal_content').html(res.html);
                        $('.aiomatic-overlay').show();
                        $('.aiomatic_modal').show();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    aiomaticAjaxRunning = false;
                    alert('Error in processing finetune switching: ' + error);
                }
            });
        }
    });
    $('.aiomatic_sync_finetunes').on('click', function (){
        var btn = $(this);
        $.ajax({
            url: aiomatic_ajax_url,
            data: {action: 'aiomatic_fetch_finetunes', nonce: aiomatic_object.nonce},
            dataType: 'JSON',
            type: 'POST',
            beforeSend: function (){
                aiomaticLoading(btn);
            },
            success: function (res){
                aiomaticRmLoading(btn);
                if(res.status === 'success'){
                    window.location.reload();
                }
                else{
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                aiomaticRmLoading(btn);
                alert('Error in processing finetune fetching: ' + error);
            }
        });
    })
});