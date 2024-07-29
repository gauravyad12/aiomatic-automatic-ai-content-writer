"use strict";
function actionsEmbChangedManual(selectedValue)
{
    if (selectedValue==='run')
    {
        runNowEmbManual();
    }
}
function runNowEmbManual()
{
    if (confirm("Are you sure you want to run bulk embeddings indexing?") == true) 
    {
        document.getElementById("run_img").style.visibility = "visible";
        document.getElementById("run_img").src = aiomatic_emb_object.plugin_dir_url + "images/running.gif";
        if(jQuery('#author_id') !== undefined)
        {
            var author_id = jQuery('#author_id').val();
            if(author_id === undefined || author_id === null)
            {
                author_id = '';
            }
        }
        else
        {
            var author_id = '';
        }
        if(jQuery('#author_name') !== undefined)
        {
            var author_name = jQuery('#author_name').val();
            if(author_name === undefined || author_name === null)
            {
                author_name = '';
            }
        }
        else
        {
            var author_name = '';
        }
        if(jQuery('#category_name') !== undefined)
        {
            var category_name = jQuery('#category_name').val();
            if(category_name === undefined || category_name === null)
            {
                category_name = '';
            }
        }
        else
        {
            var category_name = '';
        }
        if(jQuery('#tag_name') !== undefined)
        {
            var tag_name = jQuery('#tag_name').val();
            if(tag_name === undefined || tag_name === null)
            {
                tag_name = '';
            }
        }
        else
        {
            var tag_name = '';
        }
        if(jQuery('#post_id') !== undefined)
        {
            var post_id = jQuery('#post_id').val();
            if(post_id === undefined || post_id === null)
            {
                post_id = '';
            }
        }
        else
        {
            var post_id = '';
        }
        if(jQuery('#post_name') !== undefined)
        {
            var post_id = jQuery('#post_name').val();
            if(post_id === undefined || post_id === null)
            {
                post_id = '';
            }
        }
        else
        {
            var post_name = '';
        }
        if(jQuery('#pagename') !== undefined)
        {
            var pagename = jQuery('#pagename').val();
            if(pagename === undefined || pagename === null)
            {
                pagename = '';
            }
        }
        else
        {
            var pagename = '';
        }
        if(jQuery('#year') !== undefined)
        {
            var year = jQuery('#year').val();
            if(year === undefined || year === null)
            {
                year = '';
            }
        }
        else
        {
            var year = '';
        }
        if(jQuery('#month') !== undefined)
        {
            var month = jQuery('#month').val();
            if(month === undefined || month === null)
            {
                month = '';
            }
        }
        else
        {
            var month = '';
        }
        if(jQuery('#day') !== undefined)
        {
            var day = jQuery('#day').val();
            if(day === undefined || day === null)
            {
                day = '';
            }
        }
        else
        {
            var day = '';
        }
        if(jQuery('#page_id') !== undefined)
        {
            var page_id = jQuery('#page_id').val();
            if(page_id === undefined || page_id === null)
            {
                page_id = '';
            }
        }
        else
        {
            var page_id = '';
        }
        if(jQuery('#post_parent') !== undefined)
        {
            var post_parent = jQuery('#post_parent').val();
            if(post_parent === undefined || post_parent === null)
            {
                post_parent = '';
            }
        }
        else
        {
            var post_parent = '';
        }
        if(jQuery('#max_nr') !== undefined)
        {
            var max_nr = jQuery('#max_nr').val();
            if(max_nr === undefined || max_nr === null)
            {
                max_nr = '';
            }
        }
        else
        {
            var max_nr = '';
        }
        if(jQuery('#max_posts') !== undefined)
        {
            var max_posts = jQuery('#max_posts').val();
            if(max_posts === undefined || max_posts === null)
            {
                max_posts = '';
            }
        }
        else
        {
            var max_posts = '';
        }
        if(jQuery('#search_offset') !== undefined)
        {
            var search_offset = jQuery('#search_offset').val();
            if(search_offset === undefined || search_offset === null)
            {
                search_offset = '';
            }
        }
        else
        {
            var search_offset = '';
        }
        if(jQuery('#search_query') !== undefined)
        {
            var search_query = jQuery('#search_query').val();
            if(search_query === undefined || search_query === null)
            {
                search_query = '';
            }
        }
        else
        {
            var search_query = '';
        }
        if(jQuery('#meta_name') !== undefined)
        {
            var meta_name = jQuery('#meta_name').val();
            if(meta_name === undefined || meta_name === null)
            {
                meta_name = '';
            }
        }
        else
        {
            var meta_name = '';
        }
        if(jQuery('#meta_value') !== undefined)
        {
            var meta_value = jQuery('#meta_value').val();
            if(meta_value === undefined || meta_value === null)
            {
                meta_value = '';
            }
        }
        else
        {
            var meta_value = '';
        }
        if(jQuery('#order') !== undefined)
        {
            var order = jQuery('#order').val();
            if(order === undefined || order === null)
            {
                order = '';
            }
        }
        else
        {
            var order = '';
        }
        if(jQuery('#orderby') !== undefined)
        {
            var orderby = jQuery('#orderby').val();
            if(orderby === undefined || orderby === null)
            {
                orderby = '';
            }
        }
        else
        {
            var orderby = '';
        }
        if(jQuery('#featured_image') !== undefined)
        {
            var featured_image = jQuery('#featured_image').val();
            if(featured_image === undefined || featured_image === null)
            {
                featured_image = '';
            }
        }
        else
        {
            var featured_image = '';
        }
        if(jQuery('#post_status') !== undefined)
        {
            var post_status = jQuery('#post_status').val();
            if(post_status === undefined || post_status === null)
            {
                post_status = '';
            }
        }
        else
        {
            var post_status = '';
        }
        if(jQuery('#type_post') !== undefined)
            {
            var type_post = jQuery('#type_post').val();
            if(type_post === undefined || type_post === null)
            {
                type_post = '';
            }
        }
        else
        {
            var type_post = '';
        }
        if(jQuery('#no_twice') !== undefined)
        {
            if(jQuery("#no_twice").is(':checked'))
            {
                var no_twice = 'on';
            }
            else
            {
                var no_twice = 'off';
            }
        }
        else
        {
            var no_twice = 'off';
        }
        var data = {
            action: 'aiomatic_run_my_bulk_embeddings_action',
            nonce: aiomatic_emb_object.nonce,
            author_id: author_id,
            author_name: author_name,
            category_name: category_name,
            tag_name: tag_name,
            post_id: post_id,
            post_name: post_name,
            pagename: pagename,
            year: year,
            month: month,
            day: day,
            post_parent: post_parent,
            page_id: page_id,
            max_nr: max_nr,
            max_posts: max_posts,
            search_offset: search_offset,
            search_query: search_query,
            meta_name: meta_name,
            meta_value: meta_value,
            order: order,
            orderby: orderby,
            featured_image: featured_image,
            no_twice: no_twice,
            post_status: post_status,
            type_post: type_post
        };
        jQuery.post(aiomatic_emb_object.ajax_url, data, function(response) 
        {
            if(response.trim() == 'ok')
            {
                document.getElementById("run_img").src = aiomatic_emb_object.plugin_dir_url + "images/ok.gif";
            }
            else
            {
                if(response.trim() == 'nochange')
                {
                    document.getElementById("run_img").src = aiomatic_emb_object.plugin_dir_url + "images/nochange.gif";
                }
                else
                {
                    document.getElementById("run_img").src = aiomatic_emb_object.plugin_dir_url + "images/failed.gif";
                }
            }
        }).fail( function(xhr) 
        {
            console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details. Ajax URL: ' + aiomatic_emb_object.ajax_url);
            document.getElementById("run_img").src = aiomatic_emb_object.plugin_dir_url + "images/failed.gif";
            alert('Server returned error while processing: "' + xhr.statusText +  '", please check plugin\'s \'Activity and Logging\' menu for details.');
        });
    } else {
        return;
    }
}
jQuery(document).ready(function ($)
{
    $("#checkedAll").on('change', function() {
        if (this.checked) {
            $(".aiomatic-select-embedding").each(function() {
                this.checked=true;
            });
        } else {
            $(".aiomatic-select-embedding").each(function() {
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
    $('#aiomatic_sync_embeddings').on('click', function (){
        var btn = $(this);
        aiomaticLoading(btn);
        location.reload();
    });
    $('#aiomatic_save_embeddings').on('click', function (){
        if(confirm('Are you sure you want to download ALL embeddings in a CSV file?'))
        {
            var btn = $(this);
            aiomaticLoading(btn);
            var data = {
                action: 'aiomatic_download_embeddings',
                nonce: aiomatic_emb_object.nonce,
            };
            $.ajax({
                url: aiomatic_emb_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        try
                        {
                            let csvContent = "data:text/csv;charset=utf-8," 
                                + res.rows.map(e => e.join(",")).join("\n");
                            var encodedUri = encodeURI(csvContent);
                            var link = document.createElement("a");
                            link.setAttribute("href", encodedUri);
                            link.setAttribute("download", "embeddings.csv");
                            document.body.appendChild(link);
                            link.click();
                        }
                        catch(e)
                        {
                            alert(e);
                        }
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing embedding saving: ' + error);
                }
            });
        }
    });
    $('#aiomatic_upload_embeddings').on('click', function (){
        if(confirm('Are you sure you want to add embeddings from the CSV file?'))
        {
            var aiomatic_csv_upload = $('#aiomatic_csv_upload');
            var btn = $(this);
            aiomaticLoading(btn);
            if(aiomatic_csv_upload[0].files.length === 0){
                alert('Please select a file!');
            }
            else{
                var aiomatic_max_file_size = aiomatic_emb_object.maxfilesize;
                var aiomatic_file = aiomatic_csv_upload[0].files[0];
                var aiomatic_file_extension = aiomatic_file.name.substr( (aiomatic_file.name.lastIndexOf('.') +1) );
                if(aiomatic_file_extension !== 'csv'){
                    aiomatic_csv_upload.val('');
                    alert('This feature only accepts csv file type!');
                }
                else if(aiomatic_file.size > aiomatic_max_file_size){
                    aiomatic_csv_upload.val('');
                    alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
                }
                else{
                    var reader = new FileReader();
                    reader.readAsText(aiomatic_file, "UTF-8");
                    reader.onload = function (evt) {
                        var formData = new FormData();
                        formData.append('action', 'aiomatic_embeddings_upload');
                        formData.append('xfile', evt.target.result);
                        formData.append('nonce', aiomatic_emb_object.nonce);
                        $.ajax({
                            url: aiomatic_emb_object.ajax_url,
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
                        alert("Error reading file: " + aiomatic_file.name + ' - ' + reader.error);
                    }
                }
            }
        }
    });
    $('#aiomatic_scrape_url_embeddings').on('click', function (){
        if(confirm('Are you sure you want to scrape embeddings from this URL?'))
        {
            var aiomatic_url_embedding = $('#aiomatic_url_embedding').val();
            var btn = $(this);
            aiomaticLoading(btn);
            if(aiomatic_url_embedding == ''){
                alert('Please input a website URL!');
            }
            else
            {
                var formData = new FormData();
                formData.append('action', 'aiomatic_scrape_url_embeddings');
                formData.append('xurl', aiomatic_url_embedding);
                formData.append('nonce', aiomatic_emb_object.nonce);
                $.ajax({
                    url: aiomatic_emb_object.ajax_url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    success: function(res) {
                        if(res.status === 'success'){
                            aiomaticRmLoading(btn);
                            alert('Embeddings created successfully!');
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
                            alert('Unable to scrape URL: ' + error);
                    }
                });
            }
        }
    });
    $('#aiomatic_deleteall_embeddings').on('click', function (){
        if(confirm('Are you sure you want to delete ALL embeddings?'))
        {
            var btn = $(this);
            aiomaticLoading(btn);
            var data = {
                action: 'aiomatic_deleteall_embedding',
                nonce: aiomatic_emb_object.nonce,
            };
            $.ajax({
                url: aiomatic_emb_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        $('.aiomatic-embeddings-success').show();
                        $('.aiomatic-embeddings-content').val('');
                        setTimeout(function (){
                            $('.aiomatic-embeddings-success').hide();
                        },2000);
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing embedding removal: ' + error);
                }
            });
        }
    });
    $('#aiomatic_delete_selected_embeddings').on('click', function (){
        if(confirm('Are you sure you want to delete selected embeddings?'))
        {
            var btn = $(this);
            aiomaticLoading(btn);
            var ids = [];
            $('.aiomatic-select-embedding:checked').each(function (idx, item) {
                ids.push($(item).val())
            });
            if (ids.length) {
                var data = {
                    action: 'aiomatic_delete_selected_embedding',
                    nonce: aiomatic_emb_object.nonce,
                    ids: ids
                };
                $.ajax({
                    url: aiomatic_emb_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res){
                        aiomaticRmLoading(btn);
                        if(res.status === 'success'){
                            $('.aiomatic-embeddings-success').show();
                            $('.aiomatic-embeddings-content').val('');
                            setTimeout(function (){
                                $('.aiomatic-embeddings-success').hide();
                            },2000);
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing embedding removal: ' + error);
                    }
                });
            } else {
                alert('No embeddings selected');
                aiomaticRmLoading(btn);
            }
        }
    });
    $('#aiomatic_embeddings_form').on('submit', function (e)
    {
        var form = $('#aiomatic_embeddings_form');
        var btn = form.find('button');
        var content = $('.aiomatic-embeddings-content').val();
        if(content === ''){
            alert('Please insert an embedding value!');
        }
        else{
            var data = form.serialize();
            $.ajax({
                url: aiomatic_emb_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading(btn);
                },
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        $('.aiomatic-embeddings-success').show();
                        $('.aiomatic-embeddings-content').val('');
                        setTimeout(function (){
                            $('.aiomatic-embeddings-success').hide();
                        },2000)
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing embedding form: ' + error);
                }
            });
        }
        return false;
    });
    $(".aiomatic_delete_embedding").on('click', function(e) {
        if(confirm('Are you sure you want to delete this embedding?'))
        {
            var embeddingid = $(this).attr("delete-id");
            if(embeddingid == '')
            {
                alert('Incorrect delete id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_delete_embedding',
                    embeddingid: embeddingid,
                    nonce: aiomatic_emb_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_emb_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticDisable($('#aiomatic_delete_embedding_' + embeddingid));
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
                        alert('Error in processing embedding deletion: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
});