"use strict";
function Refresh_Image_Single(the_id){
    var data = {
        action: 'aiomatic_get_image',
        id: the_id,
        nonce: aiomatic_ajax_object.nonce
    };
    jQuery.get(ajaxurl, data, function(response) {
        if(response.success === true) {
            jQuery('#aiomatic-preview-image').replaceWith( response.data.image );
        }
    });
}
function Refresh_Image_Single_Advanced(the_id){
    var data = {
        action: 'aiomatic_get_image',
        id: the_id,
        nonce: aiomatic_ajax_object.nonce
    };
    jQuery.get(ajaxurl, data, function(response) {
        if(response.success === true) {
            jQuery('#aiomatic-preview-image-advanced').replaceWith( response.data.image );
        }
    });
}
function singleAssistantChanged()
{
    if(jQuery('#assistant_id_single').val() == '' || jQuery('#assistant_id_single').val() == null)
    {
        jQuery('.disableAssistantsDynamic').removeAttr('disabled');
    }
    else
    {
        jQuery('.disableAssistantsDynamic').attr('disabled', 'disabled');
    }
}
function hideImage(number)
{
    if(jQuery('#enable_ai_images' + number).val() == '1' || jQuery('#enable_ai_images' + number).val() == '2')
    {
        jQuery('.hideImg' + number).show();
    }
    else
    {
        jQuery('.hideImg' + number).hide();
    }
    if(jQuery('#enable_ai_images' + number).val() == '1')
    {
        jQuery('.hideDalle' + number).show();
    }
    else
    {
        jQuery('.hideDalle' + number).hide();
    }
}
function addAiCustomField()
{
    var metakeyinput = jQuery("#metakeyinput").val();
    var metavalue = jQuery("#metavalue").val();
    if(metakeyinput !== '')
    {
        var id = Math.random().toString(16).slice(2);
        var addvar = `<tr id="meta-` + id + `" class="alternate">
<td class="left"><label class="screen-reader-text" for="metakeyinput` + id + `">Key</label><input id="metakeyinput` + id + `" type="text" size="20" value="` + metakeyinput + `"><br/>
<input type="button" data-id="` + id + `" class="wauto button deletemeta button-small dellmetanow" value="Delete">
</td>
<td><label class="screen-reader-text" for="meta-value-` + id + `"Value></label><textarea id="metavalue` + id + `" rows="1" cols="30">` + metavalue + `</textarea><br/>
<input type="button" id="generate_custom` + id + `" class="generate_custom wauto button cr_right" value="Generate AI Content" onclick="addAiCustomFieldContent('` + id + `');"></td>
</tr>`;
        jQuery('#list-table-added tr:last').after(addvar);
    }
}
function addAiCustomFieldContent(variable)
{
    var metakeyinput = jQuery("#metakeyinput" + variable).val();
    if(metakeyinput == '')
    {
        alert('You must enter a custom field name first.');
    }
    else
    {
        aiomatic_generate_ai_text(jQuery('#generate_custom' + variable), 'prompt_custom', 'generate_custom' + variable, 'metavalue' + variable, false, false, false);
    }
}
function aiomatic_save_template()
{
    let template_name = prompt("Enter a name for the new template: ", "Template 1");
    if (template_name != null && template_name != "") 
    {
        if(template_name == 'Default Template')
        {
            alert('This name is reserved, it cannot be used');
            return;
        }
        var template_options = {};
        template_options['title'] = jQuery("#title").val();
        template_options['topics'] = jQuery("#aiomatic_topics").val();
        template_options['submit_status'] = jQuery( "#submit_status" ).val();
        template_options['submit_type'] = jQuery( "#submit_type" ).val();
        template_options['post_sticky'] = jQuery( "#post_sticky" ).val();
        template_options['post_author'] = jQuery( "#post_author" ).val();
        template_options['post_date'] = jQuery("#post_date").val();
        template_options['post_category'] = jQuery('#post_category').val();
        template_options['post_tags'] = jQuery("#post_tags").val();
        template_options['language'] = jQuery("#language").val();
        template_options['writing_style'] = jQuery("#writing_style").val();
        template_options['writing_tone'] = jQuery("#writing_tone").val();
        template_options['sections_count'] = jQuery( "#section_count" ).val();
        template_options['paragraph_count'] = jQuery( "#paragraph_count" ).val();
        template_options['model'] = jQuery( "#model" ).val();
        template_options['assistant_id'] = jQuery( "#assistant_id_single" ).val();
        template_options['max_tokens'] = jQuery("#max_tokens").val();
        template_options['temperature'] = jQuery("#temperature").val();
        template_options['prompt_title'] = jQuery("#prompt_title").val();
        template_options['prompt_sections'] = jQuery("#prompt_sections").val();
        template_options['prompt_content'] = jQuery("#prompt_content").val();
        template_options['prompt_excerpt'] = jQuery("#prompt_excerpt").val();
        template_options['prompt_custom'] = jQuery("#prompt_custom").val();
        template_options['aiomatic_image_id'] = jQuery("#aiomatic_image_id").val();
        jQuery.ajax({
            type: 'POST',
            url: aiomatic_ajax_object.ajax_url,
            data: {
                action: 'aiomatic_save_template',
                template_name: template_name,
                template_options: template_options,
                nonce: aiomatic_ajax_object.nonce
            },
            success: function(response) {
                if (response.success) {
                    jQuery('#template_manager').append(jQuery('<option>', {
                        value: template_name,
                        text: template_name
                    }));
                    alert("Template saved successfully!");
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(error) {
                alert("An error occurred while saving template: " + JSON.stringify(error));
            }
        });
    }
}
function aiomatic_save_template_advanced()
{
    let template_name = prompt("Enter a name for the new template: ", "Template 1");
    if (template_name != null && template_name != "") 
    {
        if(template_name == 'Default Template')
        {
            alert('This name is reserved, it cannot be used');
            return;
        }
        var template_options = {};
        template_options['title_advanced'] = jQuery("#title_advanced").val();
        template_options['posting_mode_changer'] = jQuery("#posting_mode_changer").val();
        template_options['aiomatic_topics_list'] = jQuery("#aiomatic_topics_list").val();
        template_options['aiomatic_listicle_list'] = jQuery("#aiomatic_listicle_list").val();
        template_options['aiomatic_titles'] = jQuery("#aiomatic_titles").val();
        template_options['aiomatic_youtube'] = jQuery("#aiomatic_youtube").val();
        template_options['aiomatic_roundup'] = jQuery("#aiomatic_roundup").val();
        template_options['aiomatic_review'] = jQuery("#aiomatic_review").val();
        template_options['csv_title'] = jQuery("#csv_title").val();
        template_options['submit_status_advanced'] = jQuery( "#submit_status_advanced" ).val();
        template_options['submit_type_advanced'] = jQuery( "#submit_type_advanced" ).val();
        template_options['post_sticky_advanced'] = jQuery( "#post_sticky_advanced" ).val();
        template_options['post_author_advanced'] = jQuery( "#post_author_advanced" ).val();
        template_options['post_date_advanced'] = jQuery("#post_date_advanced").val();
        template_options['post_category_advanced'] = jQuery('#post_category_advanced').val();
        template_options['post_tags_advanced'] = jQuery("#post_tags_advanced").val();
        template_options['aiomatic_image_id_advanced'] = jQuery("#aiomatic_image_id_advanced").val();

        var newselectedarr = ['1a', '1b', '2', '3', '4', '5', '6'];
        newselectedarr.forEach((element) => 
            jQuery('.valuesai' + element).each(function() 
            {
                var innerctrl = jQuery(this);
                if(innerctrl.is('input:text'))
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                } 
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'number')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('select'))
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('textarea'))
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'checkbox')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        if(innerctrl.is(":checked"))
                        {
                            template_options[innerctrl.attr('id')] = '1';
                        }
                        else
                        {
                            template_options[innerctrl.attr('id')] = '0';
                        }
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'color')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'date')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'datetime-local')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'email')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'hidden')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'password')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
                else if(innerctrl.is('input') && innerctrl.prop('type') == 'url')
                {
                    if(innerctrl.attr('id') !== undefined && innerctrl.attr('id') !== '')
                    {
                        template_options[innerctrl.attr('id')] = innerctrl.val();
                    }
                }
            })
        );
        jQuery.ajax({
            type: 'POST',
            url: aiomatic_ajax_object.ajax_url,
            data: {
                action: 'aiomatic_save_template_advanced',
                template_name: template_name,
                template_options: template_options,
                nonce: aiomatic_ajax_object.nonce
            },
            success: function(response) {
                if (response.success) {
                    jQuery('#template_manager_advanced').append(jQuery('<option>', {
                        value: template_name,
                        text: template_name
                    }));
                    alert("Template saved successfully!");
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(error) {
                alert("An error occurred while saving template: " + JSON.stringify(error));
            }
        });
    }
}
function aiomatic_delete_template()
{
    if (confirm("Are you sure you want to delete this template?")) 
    {
        var template_name = jQuery( "#template_manager option:selected" ).text();
        if (template_name != null && template_name != "") 
        {
            if(template_name == 'Default Template')
            {
                alert('This is the default template, it cannot be deleted');
                return;
            }
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_delete_template',
                    template_name: template_name,
                    nonce: aiomatic_ajax_object.nonce
                },
                success: function(response) {
                    if (response.success) {
                        jQuery("#template_manager option[value='" + template_name.replace("'", "\'") + "']").remove();
                        alert("Template deleted successfully!");
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function(error) {
                    alert("An error occurred while saving template: " + JSON.stringify(error));
                }
            });
        }
        else
        {
            alert('No template selected');
        }
    }
}
function aiomatic_delete_template_advanced()
{
    if (confirm("Are you sure you want to delete this template?")) 
    {
        var template_name = jQuery( "#template_manager_advanced option:selected" ).text();
        if (template_name != null && template_name != "") 
        {
            if(template_name == 'Default Template')
            {
                alert('This is the default template, it cannot be deleted');
                return;
            }
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_delete_template_advanced',
                    template_name: template_name,
                    nonce: aiomatic_ajax_object.nonce
                },
                success: function(response) {
                    if (response.success) {
                        jQuery("#template_manager_advanced option[value='" + template_name.replace("'", "\'") + "']").remove();
                        alert("Template deleted successfully!");
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function(error) {
                    alert("An error occurred while saving template: " + JSON.stringify(error));
                }
            });
        }
        else
        {
            alert('No template selected');
        }
    }
}
function aiomatic_load_template()
{
    if (confirm("Are you sure you want to load this template?")) 
    {
        var template_name = jQuery( "#template_manager option:selected" ).text();
        if (template_name != null && template_name != "") 
        {
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_load_template',
                    template_name: template_name,
                    nonce: aiomatic_ajax_object.nonce
                },
                success: function(response) {
                    if (response.success) {
                        if(response.data.content['title'] !== undefined)
                        {
                            jQuery("#title").val(response.data.content['title']);
                        }
                        if(response.data.content['topics'] !== undefined)
                        {
                            jQuery("#aiomatic_topics").val(response.data.content['topics']);
                        }
                        if(response.data.content['submit_status'] !== undefined)
                        {
                            jQuery("#submit_status option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['submit_status']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['submit_type'] !== undefined)
                        {
                            jQuery("#submit_type option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['submit_type']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['post_sticky'] !== undefined)
                        {
                            jQuery("#post_sticky option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['post_sticky']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['post_author'] !== undefined)
                        {
                            jQuery("#post_author option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['post_author']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['post_date'] !== undefined)
                        {
                            jQuery("#post_date").val(response.data.content['post_date']);
                        }
                        if(response.data.content['post_category'] !== undefined)
                        {
                            jQuery("#post_category option").each(function() 
                            {
                                if(response.data.content['post_category'].includes(jQuery(this).val()))
                                {
                                    jQuery(this).prop('selected', true);     
                                }
                                else
                                {
                                    jQuery(this).prop('selected', false);  
                                }            
                            });
                        }
                        if(response.data.content['post_tags'] !== undefined)
                        {
                            jQuery("#post_tags").val(response.data.content['post_tags']);
                        }
                        if(response.data.content['language'] !== undefined)
                        {
                            jQuery("#language").val(response.data.content['language']);
                        }
                        if(response.data.content['writing_style'] !== undefined)
                        {
                            jQuery("#writing_style").val(response.data.content['writing_style']);
                        }
                        if(response.data.content['writing_tone'] !== undefined)
                        {
                            jQuery("#writing_tone").val(response.data.content['writing_tone']);
                        }
                        if(response.data.content['sections_count'] !== undefined)
                        {
                            jQuery("#sections_count option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['sections_count']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['paragraph_count'] !== undefined)
                        {
                            jQuery("#paragraph_count option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['paragraph_count']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['model'] !== undefined)
                        {
                            jQuery("#model option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['model']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['assistant_id'] !== undefined)
                        {
                            jQuery("#assistant_id_single option").each(function() 
                            {
                                if(jQuery(this).val() == response.data.content['assistant_id']) {
                                    jQuery(this).prop('selected', true);            
                                }                        
                            });
                        }
                        if(response.data.content['max_tokens'] !== undefined)
                        {
                            jQuery("#max_tokens").val(response.data.content['max_tokens']);
                        }
                        if(response.data.content['temperature'] !== undefined)
                        {
                            jQuery("#temperature").val(response.data.content['temperature']);
                        }
                        if(response.data.content['prompt_title'] !== undefined)
                        {
                            jQuery("#prompt_title").val(response.data.content['prompt_title']);
                        }
                        if(response.data.content['prompt_sections'] !== undefined)
                        {
                            jQuery("#prompt_sections").val(response.data.content['prompt_sections']);
                        }
                        if(response.data.content['prompt_content'] !== undefined)
                        {
                            jQuery("#prompt_content").val(response.data.content['prompt_content']);
                        }
                        if(response.data.content['prompt_excerpt'] !== undefined)
                        {
                            jQuery("#prompt_excerpt").val(response.data.content['prompt_excerpt']);
                        }
                        if(response.data.content['prompt_custom'] !== undefined)
                        {
                            jQuery("#prompt_custom").val(response.data.content['prompt_custom']);
                        }
                        if(response.data.content['aiomatic_image_id'] !== undefined)
                        {
                            jQuery("#aiomatic_image_id").val(response.data.content['aiomatic_image_id']);
                            if(response.data.content['aiomatic_image_id'] != '')
                            {
                                Refresh_Image_Single(response.data.content['aiomatic_image_id']);
                            }
                        }
                        singleAssistantChanged();
                        alert("Template loaded successfully!");
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function(error) {
                    alert("An error occurred while loading template: " + JSON.stringify(error));
                }
            });
        }
        else
        {
            alert('No template selected');
        }
    }
}
function aiomatic_import_template()
{
    document.getElementById('import_template_file').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;
                try {
                    window.onbeforeunload = null;
                    const templates = JSON.parse(content);
                    if (aiomaticIsValidTemplate(templates)) 
                    {
                        aiomatic_call_import_templates(templates);
                    }
                    else
                    {
                        alert('Invalid template file uploaded');
                    }
                } catch (error) {
                    alert('Invalid JSON file');
                }
            };
            reader.readAsText(file);
        }
    });
    document.getElementById('import_template_file').click();
}
function aiomatic_call_import_templates(templates) 
{
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_import_templates',
            nonce: aiomatic_ajax_object.nonce,
            templates: templates
        },
        success: function(response) {
            if (response.success) {
                alert('Templates imported successfully.');
                location.reload();
            } else {
                alert('Error: ' + response.data.message);
            }
        },
        error: function(error) {
            alert("An error occurred while importing templates: " + JSON.stringify(error));
        }
    });
}
function aiomatic_import_template_advanced()
{
    document.getElementById('import_template_file_advanced').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;
                try {
                    window.onbeforeunload = null;
                    const templates = JSON.parse(content);
                    aiomatic_call_import_templates_advanced(templates);
                } catch (error) {
                    alert('Invalid JSON file');
                }
            };
            reader.readAsText(file);
        }
    });
    document.getElementById('import_template_file_advanced').click();
}
function aiomaticIsValidTemplate(templates) {
    const requiredFields = [
        "title", "topics", "submit_status", "submit_type", "post_sticky", "post_author", 
        "post_date", "post_category", "post_tags", "language", "writing_style", 
        "writing_tone", "sections_count", "paragraph_count", "model", "assistant_id", 
        "max_tokens", "temperature", "prompt_title", "prompt_sections", "prompt_content", 
        "prompt_excerpt", "aiomatic_image_id"
    ];
    
    for (const template in templates) {
        if (templates.hasOwnProperty(template)) {
            const templateData = templates[template];
            for (const field of requiredFields) {
                if (!templateData.hasOwnProperty(field)) {
                    return false;
                }
            }
        }
    }
    return true;
}
function aiomatic_call_import_templates_advanced(templates) 
{
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_import_templates_advanced',
            nonce: aiomatic_ajax_object.nonce,
            templates: templates
        },
        success: function(response) {
            if (response.success) {
                alert('Templates imported successfully.');
                location.reload();
            } else {
                alert('Error: ' + response.data.message);
            }
        },
        error: function(error) {
            alert("An error occurred while importing templates: " + JSON.stringify(error));
        }
    });
}
function aiomatic_export_template()
{
    if (confirm("Are you sure you want to export templates to file?")) 
    {
        jQuery.ajax({
            type: 'POST',
            url: aiomatic_ajax_object.ajax_url,
            data: {
                action: 'aiomatic_export_templates',
                nonce: aiomatic_ajax_object.nonce
            },
            success: function(response) {
                if (response.success) 
                {
                    let dl = document.createElement('a');
                    dl.download = 'templates.json';
                    dl.href = `data:application/json;charset=utf-8,${JSON.stringify(response.data.content)}`;
                    dl.click();
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(error) {
                alert("An error occurred while loading template: " + JSON.stringify(error));
            }
        });
    }
}
function aiomatic_export_template_advanced()
{
    if (confirm("Are you sure you want to export templates to file?")) 
    {
        jQuery.ajax({
            type: 'POST',
            url: aiomatic_ajax_object.ajax_url,
            data: {
                action: 'aiomatic_export_templates_advanced',
                nonce: aiomatic_ajax_object.nonce
            },
            success: function(response) {
                if (response.success) 
                {
                    let dl = document.createElement('a');
                    dl.download = 'templates_advanced.json';
                    dl.href = `data:application/json;charset=utf-8,${JSON.stringify(response.data.content)}`;
                    dl.click();
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(error) {
                alert("An error occurred while loading template: " + JSON.stringify(error));
            }
        });
    }
}
function aiomatic_load_template_advanced()
{
    if (confirm("Are you sure you want to load this template?")) 
    {
        var template_name = jQuery( "#template_manager_advanced option:selected" ).text();
        if (template_name != null && template_name != "") 
        {
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_load_template_advanced',
                    template_name: template_name,
                    nonce: aiomatic_ajax_object.nonce
                },
                success: function(response) {
                    if (response.success) 
                    {
                        for (const [key, value] of Object.entries(response.data.content)) 
                        {
                            var jelem = jQuery("#" + key);
                            if(jelem !== undefined)
                            {
                                if(jelem.is('input:text'))
                                {
                                    jelem.val(value);
                                } 
                                else if(jelem.is('input') && jelem.prop('type') == 'number')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('select'))
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('textarea'))
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'checkbox')
                                {
                                    if(value == '1')
                                    {
                                        jelem.prop( "checked", true );
                                    }
                                    else
                                    {
                                        jelem.prop( "checked", false );
                                    }
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'color')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'date')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'datetime-local')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'email')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'hidden')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'password')
                                {
                                    jelem.val(value);
                                }
                                else if(jelem.is('input') && jelem.prop('type') == 'url')
                                {
                                    jelem.val(value);
                                }
                                if(key === 'aiomatic_image_id_advanced')
                                {
                                    if(value != '')
                                    {
                                        Refresh_Image_Single_Advanced(value);
                                    }
                                }
                            }
                        }
                        assistantSelected('1a');
                        assistantSelected('1b');
                        assistantSelected('2');
                        assistantSelected('3');
                        assistantSelected('4');
                        assistantSelected('6');
                        alert("Advanced template loaded successfully!");
                    } else {
                        alert('Error in advanced template loading: ' + response.data.message);
                    }
                },
                error: function(error) {
                    alert("An error occurred while loading advanced template: " + JSON.stringify(error));
                }
            });
        }
        else
        {
            alert('No advanced template selected');
        }
    }
}
function aiomatic_call_func()
{
    const model_holder = document.getElementById("model_holder");
    if(model_holder !== null)
    {
        const btn = document.getElementById("aiomatic_toggle_model");
        if(btn !== null)
        {
            if (btn.value === "Show") {
                model_holder.style.display = "block";
                btn.value = "Hide";
            } else {
                model_holder.style.display = "none";
                btn.value = "Show";
            }
        }
        else
        {
            console.log('aiomatic_toggle_model not found');
        }
    }
    else
    {
        console.log('model_holder not found');
    }
}
function aiomatic_prompt_func()
{
    const prompt_holder = document.getElementById("prompt_holder");
    if(model_holder !== null)
    {
        const btn = document.getElementById("aiomatic_toggle_prompt");
        if(btn !== null)
        {
            if (btn.value === "Show") {
                prompt_holder.style.display = "block";
                btn.value = "Hide";
            } else {
                prompt_holder.style.display = "none";
                btn.value = "Show";
            }
        }
        else
        {
            console.log('aiomatic_toggle_prompt not found');
        }
    }
    else
    {
        console.log('prompt_holder not found');
    }
}
function aiomatic_all_empty() {
    var aiomatic_topics = document.getElementById("aiomatic_topics");
    var generate_all = document.getElementById("generate_all");
    var generate_title = document.getElementById("generate_title");
    if(generate_title !== null && generate_all !== null && aiomatic_topics !== null)
    {
        if(aiomatic_topics.value === "") { 
            generate_all.disabled = true; 
            generate_title.disabled = true; 
        } else { 
            generate_all.disabled = false;
            generate_title.disabled = false;
        }
    }
    else
    {
        console.log('generate_all/aiomatic_topics/generate_title not found');
    }
}
function aiomaticIsTinyMCEAvailable(editorId) 
{
    return typeof tinymce !== 'undefined' && tinymce.get(editorId);
}
function aiomatic_title_empty() {
    var title = document.getElementById("title");
    var generate_sections = document.getElementById("generate_sections");
    var generate_paragraphs = document.getElementById("generate_paragraphs");
    var generate_excerpt = document.getElementById("generate_excerpt");
    var post_publish = document.getElementById("post_publish");
    if(title !== null && generate_sections !== null && generate_paragraphs !== null && generate_excerpt !== null && post_publish !== null)
    {
        if(title.value === "") { 
            generate_sections.disabled = true; 
            generate_paragraphs.disabled = true; 
            generate_excerpt.disabled = true; 
            post_publish.disabled = true; 
        } else { 
            generate_sections.disabled = false;
            generate_paragraphs.disabled = false;
            generate_excerpt.disabled = false;
            if(typeof(tinyMCE) != "undefined")
            {
                if(window.parent.tinymce.get('post_content') !== undefined && window.parent.tinymce.get('post_content') !== null)
                {
                    if(window.parent.tinymce.get('post_content').getContent() === "" && jQuery("#post_content").val() === "") 
                    { 
                        post_publish.disabled = true;
                    }
                    else
                    {
                        post_publish.disabled = false;
                    }
                }
                else
                {
                    if( jQuery("#post_content").val() == "")
                    {
                        post_publish.disabled = true;
                    }
                    else
                    {
                        post_publish.disabled = false;
                    }
                }
            }
            else
            {
                if( jQuery("#post_content").val() == "")
                {
                    post_publish.disabled = true;
                }
                else
                {
                    post_publish.disabled = false;
                }
            }
        }
    }
    else
    {
        console.log('title/generate_sections/generate_paragraphs/generate_excerpt/post_publish/post_content_advanced not found');
    }
}
function aiomatic_title_empty_advanced() {
    var title = document.getElementById("title_advanced");
    var post_publish = document.getElementById("post_publish_advanced");
    if(title !== null && post_publish !== null)
    {
        if(title.value === "") { 
            post_publish.disabled = true; 
        } 
        else 
        { 
            if(typeof(tinyMCE) != "undefined")
            {
                if(window.parent.tinymce.get('post_content_advanced') !== undefined && window.parent.tinymce.get('post_content_advanced') !== null)
                {
                    if(window.parent.tinymce.get('post_content_advanced').getContent() === "" && jQuery("#post_content_advanced").val() === "") { 
                        post_publish.disabled = true;
                    }
                    else
                    {
                        post_publish.disabled = false;
                    }
                }
                else
                {
                    if( jQuery("#post_content_advanced").val() == "")
                    {
                        post_publish.disabled = true;
                    }
                    else
                    {
                        post_publish.disabled = false;
                    }
                }
            }
            else
            {
                if( jQuery("#post_content_advanced").val() == "")
                {
                    post_publish.disabled = true;
                }
                else
                {
                    post_publish.disabled = false;
                }
            }
        }
    }
    else
    {
        console.log('title/post_publish not found');
    }
}
function aiomatic_content_empty(idname) {
    if(idname == 'post_content')
    {
        var title = document.getElementById("title");
        var post_publish = document.getElementById("post_publish");
    }
    else
    {
        var title = document.getElementById("title_advanced");
        var post_publish = document.getElementById("post_publish_advanced");
    }
    if(title !== null && post_publish !== null && post_content !== null)
    {
        if(title.value === "") 
        {
            post_publish.disabled = true; 
        } 
        else 
        { 
            if(typeof(tinyMCE) != "undefined")
            {
                if(window.parent.tinymce.get(idname) !== undefined && window.parent.tinymce.get(idname) !== null)
                {
                    if(window.parent.tinymce.get(idname).getContent() === "" && jQuery("#" + idname).val() === "") { 
                        post_publish.disabled = true;
                    }
                    else
                    {
                        post_publish.disabled = false;
                    }
                }
                else
                {
                    if( jQuery("#" + idname).val() == "")
                    {
                        post_publish.disabled = true;
                    }
                    else
                    {
                        post_publish.disabled = false;
                    }
                }
            }
            else
            {
                if( jQuery("#" + idname).val() == "")
                {
                    post_publish.disabled = true;
                }
                else
                {
                    post_publish.disabled = false;
                }
            }
        }
    }
    else
    {
        console.log('title/post_publish/post_content not found');
    }
}
function aiomatic_displayTimer(element){
    var start = 1;
    var minutes = 0;
    var extraSeconds = 0;
    var setTimer = setInterval(function () {
        start++;
        minutes = Math.floor(start / 60);
        extraSeconds = start % 60;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        extraSeconds = extraSeconds< 10 ? "0" + extraSeconds : extraSeconds;
        element.val(minutes + ':' + extraSeconds);
    }, 1000);
    return setTimer;
}
function aiomatic_button_displayTimer(element){
    var start = 1;
    var minutes = 0;
    var extraSeconds = 0;
    var setTimer = setInterval(function () {
        start++;
        minutes = Math.floor(start / 60);
        extraSeconds = start % 60;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        extraSeconds = extraSeconds< 10 ? "0" + extraSeconds : extraSeconds;
        element.html(minutes + ':' + extraSeconds);
    }, 1000);
    return setTimer;
}
function assistantSelected(ruleid)
{
    var selected = jQuery('#assistant_id' + ruleid).val();
    if(selected == '' || selected == null)
    {
        jQuery('.hideAssistant' + ruleid).find('option').removeAttr('disabled');
    }
    else
    {
        var selectElement = jQuery('.hideAssistant' + ruleid);
        var selectedValue = selectElement.val();
        jQuery('.hideAssistant' + ruleid).find('option').attr('disabled', 'disabled');
        selectElement.find('option[value="' + selectedValue + '"]').removeAttr('disabled');
    }
}
function aiomatic_generate_ai_text(isthis, promptid, thisid, thisres, istiny, noenable, ajaxchain)
{
    var origvar = jQuery(isthis).attr('value');
    var myInterval = aiomatic_displayTimer(jQuery(isthis));
    jQuery("#generate_sections").prop( "disabled", true );
    jQuery("#generate_all").prop( "disabled", true );
    jQuery("#generate_title").prop( "disabled", true );
    jQuery("#generate_paragraphs").prop( "disabled", true );
    jQuery("#generate_excerpt").prop( "disabled", true );
    jQuery(".generate_custom").prop( "disabled", true );
    jQuery("#post_publish").prop( "disabled", true );

    var prompt_prompt = jQuery("#" + promptid).val();
    var title = jQuery("#title").val();
    var sections_count = jQuery( "#section_count option:selected" ).val();
    var paragraph_count = jQuery( "#paragraph_count option:selected" ).val();
    var model = jQuery( "#model" ).val();
    var assistant_id = jQuery( "#assistant_id_single" ).val();
    var max_tokens = jQuery("#max_tokens").val();
    var language = jQuery("#language").val();
    var topics = jQuery("#aiomatic_topics").val();
    var sections = jQuery("#post_sections").val();
    var writing_style = jQuery("#writing_style").val();
    var writing_tone = jQuery("#writing_tone").val();
    var temperature = jQuery("#temperature").val();
    var metakeyinput = jQuery("#metakeyinput").val();
    var content_gen_type = jQuery("#content_gen_type").val();
    if(content_gen_type === 'yes')
    {
        if(promptid != 'prompt_content')
        {
            content_gen_type = 'no';
        }
    }
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_write_text',
            prompt: prompt_prompt,
            title: title,
            model: model,
            assistant_id: assistant_id,
            max_tokens: max_tokens,
            language: language,
            temperature: temperature,
            writing_style: writing_style,
            writing_tone: writing_tone,
            sections_count: sections_count,
            paragraph_count: paragraph_count,
            metakeyinput: metakeyinput,
            topics: topics,
            sections: sections,
            content_gen_type: content_gen_type,
            nonce: aiomatic_ajax_object.nonce
        },
        success: function(response) {
            if (response.success) {
                if(istiny === true)
                {
                    if(window.parent.tinymce.get(thisres) === undefined || window.parent.tinymce.get(thisres) === null)
                    {
                        jQuery("#" + thisres).val(response.data.content);
                    }
                    else
                    {
                        window.parent.tinymce.get(thisres).setContent(response.data.content);
                    }
                }
                else
                {
                    jQuery("#" + thisres).val(response.data.content);
                }
                if(ajaxchain == true)
                {
                    if(promptid == 'prompt_title')
                    {
                        aiomatic_generate_ai_text(jQuery('#generate_sections'), 'prompt_sections', 'generate_sections', 'post_sections', false, true, true);
                    }
                    else if(promptid == 'prompt_sections')
                    {
                        aiomatic_generate_ai_text(jQuery('#generate_paragraphs'), 'prompt_content', 'generate_paragraphs', 'post_content', true, true, true);
                    }
                    else if(promptid == 'prompt_content')
                    {
                        aiomatic_generate_ai_text(jQuery('#generate_excerpt'), 'prompt_excerpt', 'generate_excerpt', 'post_excerpt', false, false, false);
                    }
                }
            } else {
                alert('Error: ' + response.data.message);
            }
            clearInterval(myInterval);
            jQuery("#" + thisid).attr('value', origvar);
            if(noenable !== true)
            {
                jQuery("#generate_sections").prop( "disabled", false );
                jQuery("#generate_all").prop( "disabled", false );
                jQuery("#generate_title").prop( "disabled", false );
                jQuery("#generate_paragraphs").prop( "disabled", false );
                jQuery("#generate_excerpt").prop( "disabled", false );
                jQuery(".generate_custom").prop( "disabled", false );
                aiomatic_title_empty();
            }
        },
        error: function(error) {
            clearInterval(myInterval);
            jQuery("#" + thisid).attr('value', origvar);
            jQuery("#generate_sections").prop( "disabled", false );
            jQuery("#generate_all").prop( "disabled", false );
            jQuery("#generate_title").prop( "disabled", false );
            jQuery("#generate_paragraphs").prop( "disabled", false );
            jQuery("#generate_excerpt").prop( "disabled", false );
            jQuery(".generate_custom").prop( "disabled", false );
            aiomatic_title_empty();
            alert('An error occurred while processing, please try again later!');
            console.log('Error while processing: ' + JSON.stringify(error));
        }
    });
}
function aiomaticExtractMetaFields() 
{
    const table = document.getElementById('list-table-added');
    const rows = table.querySelectorAll('tr[id^="meta-"]');
    let metaFields = {};
    if (rows.length === 0) 
    {
        return metaFields;
    }
    rows.forEach(row => {
        const keyInput = row.querySelector('input[type="text"]');
        const valueTextarea = row.querySelector('textarea');
        if (keyInput && valueTextarea) {
            metaFields[keyInput.value] = valueTextarea.value;
        }
    });
    return metaFields;
}
jQuery(document).ready(function($) {
    singleAssistantChanged();
    $(document).on("click",".dellmetanow", function(e){
        if (this.getAttribute("data-id") !== null) {
            var remid = this.getAttribute("data-id");
            $('#meta-' + remid).remove();
        }
    });
    if(window.tinyMCE !== undefined)
    {
        if(!window.tinyMCE.activeEditor)
        {
            window.tinyMCE.execCommand('mceToggleEditor', false, 'post_content');
        }
    }
    (function ($) {
        $('#aiomatic-dialog').dialog({
          title: 'Post Pulished Successfully',
          dialogClass: 'wp-dialog',
          autoOpen: false,
          draggable: false,
          width: 'auto',
          modal: true,
          resizable: false,
          closeOnEscape: true,
          position: {
            my: "center",
            at: "center",
            of: window
          },
          open: function () {
            $(document).on("click",".ui-widget-overlay", function(){
              $('#aiomatic-dialog').dialog('close');
            });
            $(document).on("click","#aiomatic-close-button", function(){
                $('#aiomatic-dialog').dialog('close');
            });
          },
          create: function () {
            $('.ui-dialog-titlebar-close').addClass('ui-button');
          },
        });
      })(jQuery);

      
    $(document.body).on("click","#aiomatic-success-button", function (e) {
        if (this.getAttribute("adminurl") !== null) {
            if (this.getAttribute("postid") !== null && this.getAttribute("postid") !== '') {
                window.location.href = this.getAttribute("adminurl") + this.getAttribute("postid") + '&action=edit';
            }
            else
            {
                console.log('Incorrect post ID provided!');
            }
        }
        else
        {
            console.log('Incorrect admin URL provided!');
        }
    });
    $('#generate_title').on('click', function()
    {
        aiomatic_generate_ai_text(this, 'prompt_title', 'generate_title', 'title', false, false, false);
    });
    $('#generate_sections').on('click', function()
    {
        aiomatic_generate_ai_text(this, 'prompt_sections', 'generate_sections', 'post_sections', false, false, false);
    });
    $('#generate_paragraphs').on('click', function()
    {
        aiomatic_generate_ai_text(this, 'prompt_content', 'generate_paragraphs', 'post_content', true, false, false);
    });
    $('#generate_excerpt').on('click', function()
    {
        aiomatic_generate_ai_text(this, 'prompt_excerpt', 'generate_excerpt', 'post_excerpt', false, false, false);
    });
    $('#generate_all').on('click', function()
    {
        $(this).attr('value', 'Working...');
        aiomatic_generate_ai_text($('#generate_title'), 'prompt_title', 'generate_title', 'title', false, true, true);
        $(this).attr('value', 'Generate All');
    });
    if(window.tinyMCE !== undefined)
    {
        var ed = window.tinyMCE.get();
        if(ed !== null)
        {
            ed.forEach((element) => element.on('keyup', function(e)
            {
                aiomatic_content_empty(ed.id);
            }));
        }
    }
    $('#aiomatic-single-post').submit(function(event) {
      event.preventDefault();
      var post_publish = document.getElementById("post_publish");
      var generate_sections = document.getElementById("generate_sections");
      var generate_paragraphs = document.getElementById("generate_paragraphs");
      var generate_excerpt = document.getElementById("generate_excerpt");
      var form = $(this);
      var title = form.find('#title').val();
      if(typeof(tinyMCE) != "undefined")
      {
          if(window.parent.tinymce.get('post_content') !== undefined && window.parent.tinymce.get('post_content') !== null)
          {
            var content = window.parent.tinymce.get('post_content').getContent();
            if(content == '')
            {
                var quicktagsInput = jQuery("#post_content");
                if (quicktagsInput.length) 
                {
                    content = quicktagsInput.val();
                }
            }
            window.parent.tinymce.get('post_content').setContent("");
          }
          else
          {
            var content = $("#post_content").val();
            $("#post_content").val('');
          }
      }
      else
      {
          var content = $("#post_content").val();
          $("#post_content").val('');
      }
      var metaFieldsArray = aiomaticExtractMetaFields();
      var excerpt = form.find('#post_excerpt').val();
      var submit_status = form.find('#submit_status').val();
      var submit_type = form.find('#submit_type').val();
      var post_sticky = form.find('#post_sticky').val();
      var post_date = form.find('#post_date').val();
      var post_author = form.find('#post_author').val();
      var aiomatic_image_id = form.find('#aiomatic_image_id').val();
      var post_category = document.getElementById('post_category').selectedOptions;
      post_category = Array.from(post_category).map(({ value }) => value);
      post_category = JSON.stringify(post_category);
      var post_tags = form.find('#post_tags').val();
      var nonce = form.find('#create_post_nonce').val();
      $("#title").val("");
      $("#post_excerpt").val("");
      $("#post_sections").val("");
      if(post_publish !== null && generate_sections !== null && generate_excerpt !== null && generate_paragraphs !== null)
      {
        post_publish.disabled = true; 
        generate_sections.disabled = true;
        generate_excerpt.disabled = true;
        generate_paragraphs.disabled = true; 
      }
      $.ajax({
        type: 'POST',
        url: aiomatic_ajax_object.ajax_url,
        data: {
          action: 'create_post',
          title: title,
          content: content,
          excerpt: excerpt,
          submit_status: submit_status,
          submit_type: submit_type,
          post_sticky: post_sticky,
          post_author: post_author,
          post_date: post_date,
          post_category: post_category,
          post_tags: post_tags,
          aiomatic_image_id: aiomatic_image_id,
          metaFieldsArray: metaFieldsArray,
          nonce: nonce
        },
        success: function(response) {
          if (response.success) {
            document.getElementById("aiomatic-success-button").setAttribute("postid", response.data.post_id);
            $('#aiomatic-dialog').dialog('open');
          } else {
            alert('Error: ' + response.data.message);
          }
        },
        error: function(error) 
        {
            alert('Error in post publishing: ' + error.responseText);
        }
      });
    });
    aiomatic_all_empty();
    aiomatic_title_empty();
  });
  
  function content_gen_changed()
  {
    if(jQuery('#content_gen_type').val() === 'yes')
    {            
        jQuery("#prompt_content").val(`Write the content of a post section for the heading "%%current_section%%" in %%language%%. Don't repeat the heading in the created content. Don't add an intro or outro. Write %%paragraphs_per_section%% paragraphs in the section. Use HTML for formatting, include unnumbered lists and bold. Writing Style: %%writing_style%%. Tone: %%writing_tone%%.`);
    }
    else
    {
        jQuery("#prompt_content").val(`Write an article about "%%title%%" in %%language%%. The article is organized by the following headings:

%%sections%%

Write %%paragraphs_per_section%% paragraphs per heading.

Use HTML for formatting, include h2 tags, h3 tags, lists and bold. When applicable, add also HTML tables with WordPress styling (you can use WordPress table classes). Table data must be relevant, creative, short and simple.

Add an introduction and a conclusion.

Style: %%writing_style%%. Tone: %%writing_tone%%.`);
    }
  }

//starting Advanced mode functions
function postingModeChanged()
{
    var selected = jQuery("#posting_mode_changer").val();
    if(selected == '1a')
    {
        jQuery("#topicdiv").show();
        jQuery("#inputtitlediv").hide();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '1a-')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").show();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '1b')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").show();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '2')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").hide();
        jQuery("#youtubediv").show();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '3')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").hide();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").show();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '4')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").hide();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").show();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '5')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").hide();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").show();
        jQuery("#listiclediv").hide();
    }
    else if(selected == '6')
    {
        jQuery("#topicdiv").hide();
        jQuery("#inputtitlediv").hide();
        jQuery("#youtubediv").hide();
        jQuery("#roundupdiv").hide();
        jQuery("#reviewdiv").hide();
        jQuery("#csvdiv").hide();
        jQuery("#listiclediv").show();
    }
}
jQuery(document).ready(function($) 
{ 
    var codemodalfzr1a = document.getElementById('mymodalfzr1a');
    var codemodalfzr1b = document.getElementById('mymodalfzr1b');
    var codemodalfzr2 = document.getElementById('mymodalfzr2');
    var codemodalfzr3 = document.getElementById('mymodalfzr3');
    var codemodalfzr4 = document.getElementById('mymodalfzr4');
    var codemodalfzr5 = document.getElementById('mymodalfzr5');
    var codemodalfzr6 = document.getElementById('mymodalfzr6');
    var span1a = document.getElementById("aiomatic_close1a");
    var span1b = document.getElementById("aiomatic_close1b");
    var span2 = document.getElementById("aiomatic_close2");
    var span3 = document.getElementById("aiomatic_close3");
    var span4 = document.getElementById("aiomatic_close4");
    var span5 = document.getElementById("aiomatic_close5");
    var span6 = document.getElementById("aiomatic_close6");
    var ok1a = document.getElementById("aiomatic_ok1a");
    var ok1b = document.getElementById("aiomatic_ok1b");
    var ok2 = document.getElementById("aiomatic_ok2");
    var ok3 = document.getElementById("aiomatic_ok3");
    var ok4 = document.getElementById("aiomatic_ok4");
    var ok5 = document.getElementById("aiomatic_ok5");
    var ok6 = document.getElementById("aiomatic_ok6");

    if(span1a != null)
    {
        span1a.onclick = function() {
            codemodalfzr1a.style.display = "none";
        }
    }
    if(span1b != null)
    {
        span1b.onclick = function() {
            codemodalfzr1b.style.display = "none";
        }
    }
    if(span2 != null)
    {
        span2.onclick = function() {
            codemodalfzr2.style.display = "none";
        }
    }
    if(span3 != null)
    {
        span3.onclick = function() {
            codemodalfzr3.style.display = "none";
        }
    }
    if(span4 != null)
    {
        span4.onclick = function() {
            codemodalfzr4.style.display = "none";
        }
    }
    if(span5 != null)
    {
        span5.onclick = function() {
            codemodalfzr5.style.display = "none";
        }
    }
    if(span6 != null)
    {
        span6.onclick = function() {
            codemodalfzr6.style.display = "none";
        }
    }
    if(ok1a != null)
    {
        ok1a.onclick = function() {
            codemodalfzr1a.style.display = "none";
        }
    }
    if(ok1b != null)
    {
        ok1b.onclick = function() {
            codemodalfzr1b.style.display = "none";
        }
    }
    if(ok2 != null)
    {
        ok2.onclick = function() {
            codemodalfzr2.style.display = "none";
        }
    }
    if(ok3 != null)
    {
        ok3.onclick = function() {
            codemodalfzr3.style.display = "none";
        }
    }
    if(ok4 != null)
    {
        ok4.onclick = function() {
            codemodalfzr4.style.display = "none";
        }
    }
    if(ok5 != null)
    {
        ok5.onclick = function() {
            codemodalfzr5.style.display = "none";
        }
    }
    if(ok6 != null)
    {
        ok6.onclick = function() {
            codemodalfzr6.style.display = "none";
        }
    }
    window.onclick = function(event) {
        if (event.target == codemodalfzr1a || event.target == codemodalfzr1b || event.target == codemodalfzr2 || event.target == codemodalfzr3 || event.target == codemodalfzr4 || event.target == codemodalfzr5 || event.target == codemodalfzr6) 
        {
            codemodalfzr1a.style.display = "none";
            codemodalfzr1b.style.display = "none";
            codemodalfzr2.style.display = "none";
            codemodalfzr3.style.display = "none";
            codemodalfzr4.style.display = "none";
            codemodalfzr5.style.display = "none";
            codemodalfzr6.style.display = "none";
        }
    }
    if (aiomaticIsTinyMCEAvailable('post_content_advanced')) 
    {
        var editor = tinymce.get('post_content_advanced');
        editor.on('change', function(e) {
            aiomatic_content_empty('post_content_advanced');
        });
        jQuery(document).on('input', '#post_content_advanced', function (event) 
        {
            aiomatic_content_empty('post_content_advanced');
        });
    }
    if (aiomaticIsTinyMCEAvailable('post_content')) 
    {
        var editor = tinymce.get('post_content');
        editor.on('change', function(e) {
            aiomatic_content_empty('post_content');
        });
        jQuery(document).on('input', '#post_content', function (event) 
        {
            aiomatic_content_empty('post_content');
        });
    }
    $('#aiomatic-advanced-button').on('click', function(e) 
    {
        e.preventDefault();
        var selected = jQuery("#posting_mode_changer").val();
        if(selected == '1a' || selected == '1a-')
        {
            codemodalfzr1a.style.display = "block";
        }
        else if(selected == '1b')
        {
            codemodalfzr1b.style.display = "block";
        }
        else if(selected == '2')
        {
            codemodalfzr2.style.display = "block";
        }
        else if(selected == '3')
        {
            codemodalfzr3.style.display = "block";
        }
        else if(selected == '4')
        {
            codemodalfzr4.style.display = "block";
        }
        else if(selected == '5')
        {
            codemodalfzr5.style.display = "block";
        }
        else if(selected == '6')
        {
            codemodalfzr6.style.display = "block";
        }
    });
    
    $('#aiomatic-single-post-advanced').submit(function(event) 
    {
        event.preventDefault();
        var post_publish_advanced = document.getElementById("post_publish_advanced");
        var title_advanced = jQuery("#title_advanced");
        var title_advanced_val = title_advanced.val();
        var form_advanced = jQuery(this);
        if(typeof(tinyMCE) != "undefined")
        {
            if(window.parent.tinymce.get('post_content_advanced') !== undefined && window.parent.tinymce.get('post_content_advanced') !== null)
            {
                var content_advanced = window.parent.tinymce.get('post_content_advanced').getContent();
                if(content_advanced == '')
                {
                    var quicktagsInput = jQuery("#post_content_advanced");
                    if (quicktagsInput.length) 
                    {
                        content_advanced = quicktagsInput.val();
                    }
                }
                window.parent.tinymce.get('post_content_advanced').setContent("");
            }
            else
            {
                var content_advanced = $("#post_content_advanced").val();
                $("#post_content_advanced").val('');
            }
        }
        else
        {
            var content_advanced = $("#post_content_advanced").val();
            $("#post_content_advanced").val('');
        }
        var submit_status_advanced = form_advanced.find('#submit_status_advanced').val();
        var submit_type_advanced = form_advanced.find('#submit_type_advanced').val();
        var post_sticky_advanced = form_advanced.find('#post_sticky_advanced').val();
        var post_date_advanced = form_advanced.find('#post_date_advanced').val();
        var post_author_advanced = form_advanced.find('#post_author_advanced').val();
        var aiomatic_image_id_advanced = form_advanced.find('#aiomatic_image_id_advanced').val();
        var post_category_advanced = document.getElementById('post_category_advanced').selectedOptions;
        post_category_advanced = Array.from(post_category_advanced).map(({ value }) => value);
        post_category_advanced = JSON.stringify(post_category_advanced);
        var post_tags_advanced = form_advanced.find('#post_tags_advanced').val();
        var nonce_advanced = form_advanced.find('#create_post_nonce').val();
        title_advanced.val("");
        if(post_publish_advanced !== null)
        {
            post_publish_advanced.disabled = true;
        }
        $.ajax({
          type: 'POST',
          url: aiomatic_ajax_object.ajax_url,
          data: {
            action: 'create_post',
            title: title_advanced_val,
            content: content_advanced,
            excerpt: '',
            submit_status: submit_status_advanced,
            submit_type: submit_type_advanced,
            post_sticky: post_sticky_advanced,
            post_author: post_author_advanced,
            post_date: post_date_advanced,
            post_category: post_category_advanced,
            post_tags: post_tags_advanced,
            aiomatic_image_id: aiomatic_image_id_advanced,
            nonce: nonce_advanced
          },
          success: function(response) {
            if (response.success) {
              document.getElementById("aiomatic-success-button").setAttribute("postid", response.data.post_id);
              $('#aiomatic-dialog').dialog('open');
            } else {
              alert('Error: ' + response.data.message);
            }
          },
          error: function(error) 
          {
              alert('Error in post publishing: ' + error.responseText);
          }
        });
        aiomatic_title_empty_advanced();
    });
    $('#aiomatic-generate-button').on('click', function(e) 
    {
        e.preventDefault();
        var title_advanced = jQuery('#title_advanced').val();
        if(typeof(tinyMCE) != "undefined")
        {
            if(window.parent.tinymce.get('post_content_advanced') === undefined || window.parent.tinymce.get('post_content_advanced') === null)
            {
                var content_advanced = $("#post_content_advanced").val();
            }
            else
            {
                var content_advanced = window.parent.tinymce.get('post_content_advanced').getContent();
                if(content_advanced == '')
                {
                    var quicktagsInput = jQuery("#post_content_advanced");
                    if (quicktagsInput.length) 
                    {
                        content_advanced = quicktagsInput.val();
                    }
                }
            }
        }
        else
        {
            var content_advanced = $("#post_content_advanced").val();
        }
        if(content_advanced != '' || title_advanced != '')
        {
            if (!confirm("You have unsaved data in post title or content. Are you sure you want to proceed?"))
            {
                return;
            }
        }
        var ctrl = jQuery(this);
        var totalvar = {};
        var selected = jQuery("#posting_mode_changer").val();
        if(selected != '1a' && selected != '1a-' && selected != '1b' && selected != '2' && selected != '3' && selected != '4' && selected != '5' && selected != '6')
        {
            alert('Incorrect posting_mode_changer set!');
            return;
        }
        var newselected = selected.endsWith('-') ? Array.from(selected).splice(0,selected.length - 1).join('') : selected;
        jQuery('.valuesai' + newselected).each(function() 
        {
            var innerctrl = jQuery(this);
            if(innerctrl.is('input:text'))
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            } 
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'number')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('select'))
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('textarea'))
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'checkbox')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    if(innerctrl.is(":checked"))
                    {
                        totalvar[innerctrl.attr('name')] = '1';
                    }
                    else
                    {
                        totalvar[innerctrl.attr('name')] = '0';
                    }
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'color')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'date')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'datetime-local')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'email')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'hidden')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'password')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
            else if(innerctrl.is('input') && innerctrl.prop('type') == 'url')
            {
                if(innerctrl.attr('name') !== undefined && innerctrl.attr('name') !== '')
                {
                    totalvar[innerctrl.attr('name')] = innerctrl.val();
                }
            }
        });
        if(selected == '1a')
        {
            var aiomatic_topics = jQuery("#aiomatic_topics_list").val();
            if(aiomatic_topics == '')
            {
                alert('Error, "Post Topic List" required!');
                return;
            }
            totalvar['post_topic_list'] = aiomatic_topics;
        }
        else if(selected == '1a-')
        {
            var aiomatic_titles = jQuery("#aiomatic_titles").val();
            if(aiomatic_titles == '')
            {
                alert('Error, "Post Title List" required!');
                return;
            }
            totalvar['post_title'] = aiomatic_titles;
        }
        else if(selected == '1b')
        {
            var aiomatic_titles = jQuery("#aiomatic_titles").val();
            if(aiomatic_titles == '')
            {
                alert('Error, "Post Title List"  required!');
                return;
            }
            totalvar['post_title'] = aiomatic_titles;
        }
        else if(selected == '2')
        {
            var aiomatic_youtube = jQuery("#aiomatic_youtube").val();
            if(aiomatic_youtube == '')
            {
                alert('Error, "YouTube Video URLs"  required!');
                return;
            }
            totalvar['url_list'] = aiomatic_youtube;
        }
        else if(selected == '3')
        {
            var aiomatic_roundup = jQuery("#aiomatic_roundup").val();
            if(aiomatic_roundup == '')
            {
                alert('Error, "Product Search Keywords / Product ASIN List" required!');
                return;
            }
            totalvar['amazon_keyword'] = aiomatic_roundup;
        }
        else if(selected == '4')
        {
            var aiomatic_review = jQuery("#aiomatic_review").val();
            if(aiomatic_review == '')
            {
                alert('Error, "Single Product ASIN or Keyword" required!');
                return;
            }
            totalvar['review_keyword'] = aiomatic_review;
        }
        else if(selected == '5')
        {
            var csv_title = jQuery("#csv_title").val();aiomaticloader
            if(csv_title == '')
            {
                alert('Error, "CSV File URLs List" required!');
                return;
            }
            totalvar['post_title'] = csv_title;
        }
        else if(selected == '6')
        {
            var aiomatic_topics = jQuery("#aiomatic_listicle_list").val();
            if(aiomatic_topics == '')
            {
                alert('Error, "Listicle Topic List" required!');
                return;
            }
            totalvar['post_topic_list'] = aiomatic_topics;
        }
        ctrl.prop( "disabled", true );
        var origvar = ctrl.html();
        var myInterval = aiomatic_button_displayTimer(ctrl);
        var aiomaticloader = jQuery("#aiomaticloader");
        aiomaticloader.css('visibility', 'visible');
        if(aiomatic_ajax_object.no_jobs == '1')
        {
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_execute_single_advanced',
                    post_data: totalvar,
                    selected: selected,
                    nonce: aiomatic_ajax_object.nonce
                },
                success: function(response) 
                {
                    clearInterval(myInterval);
                    aiomaticloader.css('visibility', 'hidden');
                    ctrl.html(origvar);
                    ctrl.prop( "disabled", false );
                    if (response.success) 
                    {
                        jQuery("#title_advanced").val(response.data.title);
                        if(typeof(tinyMCE) != "undefined")
                        {
                            if(window.parent.tinymce.get('post_content_advanced') === undefined || window.parent.tinymce.get('post_content_advanced') === null)
                            {
                                $("#post_content_advanced").val(response.data.content);
                            }
                            else
                            {
                                window.parent.tinymce.get('post_content_advanced').setContent(response.data.content);
                            }
                        }
                        else
                        {
                            $("#post_content_advanced").val(response.data.content);
                        }
                    } 
                    else 
                    {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function(error) 
                {
                    clearInterval(myInterval);
                    aiomaticloader.css('visibility', 'hidden');
                    ctrl.html(origvar);
                    ctrl.prop( "disabled", false );
                    alert("An error occurred while generating content: " + JSON.stringify(error));
                }
            });
        }
        else
        {
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_execute_single_advanced_job',
                    post_data: totalvar,
                    selected: selected,
                    nonce: aiomatic_ajax_object.nonce
                },
                success: function(response) 
                {
                    if (response.success) 
                    {
                        if(response.data.job_id !== undefined)
                        {
                            aiomaticPollJob(response.data.job_id, myInterval, aiomaticloader, ctrl, origvar);
                        }
                        else
                        {
                            alert('Failed to queue job: ' + JSON.stringify(response.data));
                            clearInterval(myInterval);
                            aiomaticloader.css('visibility', 'hidden');
                            ctrl.html(origvar);
                            ctrl.prop( "disabled", false );
                        }
                    } 
                    else 
                    {
                        alert('Error: ' + response.data.message);
                        clearInterval(myInterval);
                        aiomaticloader.css('visibility', 'hidden');
                        ctrl.html(origvar);
                        ctrl.prop( "disabled", false );
                    }
                },
                error: function(error) 
                {
                    clearInterval(myInterval);
                    aiomaticloader.css('visibility', 'hidden');
                    ctrl.html(origvar);
                    ctrl.prop( "disabled", false );
                    alert("An error occurred while generating content using jobs: " + JSON.stringify(error));
                }
            });
        }
    });
    var previousPollStatus = '';
    var sameStatusPoll = 0;
    function aiomaticPollJob(job_id, myInterval, aiomaticloader, ctrl, origvar) 
    {
        jQuery.ajax({
            type: 'POST',
            url: aiomatic_ajax_object.ajax_url,
            data: {
                action: 'aiomatic_poll_single_advanced_job',
                job_id: job_id,
                nonce: aiomatic_ajax_object.nonce
            },
            success: function(response) 
            {
                var json_resp = JSON.parse(response);
                if (json_resp.status === 'completed') 
                {
                    if(json_resp.data.title !== undefined)
                    {
                        jQuery("#title_advanced").val(json_resp.data.title);
                    }
                    else
                    {
                        console.log('No title returned ' + JSON.stringify(json_resp));
                    }
                    if(json_resp.data.title !== undefined)
                    {
                        if(typeof(tinyMCE) != "undefined")
                        {
                            if(window.parent.tinymce.get('post_content_advanced') === undefined || window.parent.tinymce.get('post_content_advanced') === null)
                            {
                                $("#post_content_advanced").val(json_resp.data.content);
                            }
                            else
                            {
                                window.parent.tinymce.get('post_content_advanced').setContent(json_resp.data.content);
                            }
                        }
                        else
                        {
                            $("#post_content_advanced").val(json_resp.data.content);
                        }
                    }
                    else
                    {
                        console.log('No content returned ' + JSON.stringify(json_resp));
                    }
                    clearInterval(myInterval);
                    aiomaticloader.css('visibility', 'hidden');
                    ctrl.html(origvar);
                    ctrl.prop( "disabled", false );
                    jQuery("#aiomatic-status-loader").html('');
                    var post_publish = document.getElementById("post_publish_advanced");
                    post_publish.disabled = false;
                }
                else
                {
                    if (json_resp.status === 'pending') 
                    {
                        if(json_resp.data.step !== undefined)
                        {
                            if(previousPollStatus == json_resp.data.step)
                            {
                                sameStatusPoll++;
                            }
                            else
                            {
                                sameStatusPoll = 0;
                                previousPollStatus = json_resp.data.step;
                            }
                            var textAppend = '';
                            if(sameStatusPoll >= 15)
                            {
                                textAppend = ', this is taking longer than usual...';
                            }
                            else
                            {
                                if(sameStatusPoll >= 30)
                                {
                                    textAppend = ', probably your server is not responding. Check max_execution_time and other server timeouts...';
                                }
                            }
                            jQuery("#aiomatic-status-loader").html(json_resp.data.step + textAppend);
                        }
                        // If job is not yet complete, poll again after a delay
                        setTimeout(function() {
                            aiomaticPollJob(job_id, myInterval, aiomaticloader, ctrl, origvar);
                        }, 4000); // Poll every 4 seconds
                    }
                    else
                    {
                        if(json_resp.status === 'failed')
                        {
                            alert('Failed to run job: ' + json_resp.data);
                            clearInterval(myInterval);
                            aiomaticloader.css('visibility', 'hidden');
                            ctrl.html(origvar);
                            ctrl.prop( "disabled", false );
                            jQuery("#aiomatic-status-loader").html('');
                        }
                        else
                        {
                            alert('Unknown job state: ' + response);
                            clearInterval(myInterval);
                            aiomaticloader.css('visibility', 'hidden');
                            ctrl.html(origvar);
                            ctrl.prop( "disabled", false );
                            jQuery("#aiomatic-status-loader").html('');
                        }
                    }
                }
            },
            error: function(error) 
            {
                alert("An error occurred while polling job: " + JSON.stringify(error));
                clearInterval(myInterval);
                aiomaticloader.css('visibility', 'hidden');
                ctrl.html(origvar);
                ctrl.prop( "disabled", false );
                jQuery("#aiomatic-status-loader").html('');
            }
        });
    }
});