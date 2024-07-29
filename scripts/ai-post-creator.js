"use strict";
function assistantSelected(checkID, disableClass)
{
    if(jQuery('#' + checkID).val() == '')
    {
        jQuery('.' + disableClass).find('option').removeAttr('disabled');
    }
    else
    {
        jQuery('.' + disableClass).find('option').attr('disabled', 'disabled');
    }
}
jQuery(document).ready(function ($)
{
    if( $('#aiomatic_show_more').length )
    {
        $('#aiomatic_show_more').on('click', function(){
            if(jQuery('.aiomatic_toggle_me').is(":visible"))
            {            
                jQuery(".aiomatic_toggle_me").hide();
            }
            else
            {
                jQuery(".aiomatic_toggle_me").show();
            }
        });
    }
    if( $('#aiomatic_ai_content_generator').length )
    {
        var aiomatic_ai_content_generator_btn = $('#aiomatic_ai_content_generator');
    }
    else
    {
        console.log('aiomatic_ai_content_generator button not found');
        return;
    }
    function aiomatic_ShowError(msg){
        console.log(msg);
    }
    function aiomaticLoading(btn){
        btn.attr('disabled','disabled');
        if(!btn.find('spinner').length)
        {
            btn.append('<span class="spinner"></span>');
        }
        btn.find('.spinner').css('visibility','unset');
    }
    function aiomaticRmLoading(btn)
    {
        btn.removeAttr('disabled');
        btn.find('.spinner').remove();
    }
    function aiomaticGetContent(editorId)
    {
        var editor = tinyMCE.get(editorId);
        if (editor) 
        {
            var edc = editor.getContent();
            if(edc == '')
            {
                var quicktagsInput = jQuery("#" + editorId);
                if (quicktagsInput.length) 
                {
                    edc = quicktagsInput.val();
                }
            }
            return edc;
        } 
        else 
        {
            if( jQuery('#' . editorId).length )
            {
                return jQuery('#' + editorId).val();
            }
            else
            {
                return '';
            }
        }
    }
    function aiomaticSetContent(editorId, content)
    {
        var editor = tinyMCE.get(editorId);
        if (editor) 
        {
            var curcont = editor.getContent();
            if(curcont == '')
            {
                var quicktagsInput = jQuery("#" + editorId);
                if (quicktagsInput.length) 
                {
                    curcont = quicktagsInput.val();
                }
            }
            editor.setContent(curcont + ' ' + content);
        } 
        else 
        {
            var curcont = $('#' + editorId).val();
            jQuery('#' + editorId).val(curcont + ' ' + content);
        }
    }
    function aiomaticProductGenerator(title, step, steps)
    {
        var aiomatic_next_step = step+1;
        var aiomatic_step = steps[step];
        if( $('#aiomatic_ai_model').length )
        {
            var model = $('#aiomatic_ai_model').val();
        }
        else
        {
            var model = 'gpt-3.5-turbo';
        }
        if( $('#aiomatic_ai_assistant_id').length )
        {
            var assistant_id = $('#aiomatic_ai_assistant_id').val();
        }
        else
        {
            var assistant_id = '';
        }
        if( $('#aiomatic_title_prompt').length )
        {
            var titlep = $('#aiomatic_title_prompt').val();
        }
        else
        {
            var titlep = '';
        }
        if( $('#aiomatic_seo_prompt').length )
        {
            var seop = $('#aiomatic_seo_prompt').val();
        }
        else
        {
            var seop = '';
        }
        if( $('#aiomatic_content_prompt').length )
        {
            var contentp = $('#aiomatic_content_prompt').val();
        }
        else
        {
            var contentp = '';
        }
        if( $('#aiomatic_short_prompt').length )
        {
            var shortp = $('#aiomatic_short_prompt').val();
        }
        else
        {
            var shortp = '';
        }
        if( $('#aiomatic_tag_prompt').length )
        {
            var tagp = $('#aiomatic_tag_prompt').val();
        }
        else
        {
            var tagp = '';
        }
        if( $('#post_type').length )
        {
            var post_type = $('#post_type').val();
        }
        else
        {
            var post_type = '';
        }
        if( $('#post_ID').length )
        {
            var post_id = $('#post_ID').val();
        }
        else
        {
            var post_id = '';
        }
        if( $('#title').length )
        {
            var prod_title = $('#title').val();
        }
        else
        {
            var prod_title = '';
        }
        var prod_content = aiomaticGetContent('content');
        var prod_excerpt = aiomaticGetContent('excerpt');
        var data = {'action': 'aiomatic_write_aicontent_info', 'model': model, 'assistant_id': assistant_id, 'titlep': titlep, 'seop': seop, 'contentp': contentp, 'shortp': shortp, 'tagp': tagp, 'step': aiomatic_step, 'title' : title, 'post_id': post_id, 'post_type': post_type, 'prod_title': prod_title, 'prod_content': prod_content, 'prod_excerpt': prod_excerpt, 'nonce': aiomatic_creator_object.nonce}
        if(aiomatic_step === 'title')
        {
            if( $('#ai-generator-status').length )
            {
                $('#ai-generator-status').html(aiomatic_creator_object.generating_title);
            }
        }
        if(aiomatic_step === 'meta')
        {
            if( $('#ai-generator-status').length )
            {
                $('#ai-generator-status').html(aiomatic_creator_object.generating_meta);
            }
        }
        if(aiomatic_step === 'description')
        {
            if( $('#ai-generator-status').length )
            {
                $('#ai-generator-status').html(aiomatic_creator_object.generating_content);
            }
        }
        if(aiomatic_step === 'short')
        {
            if( $('#ai-generator-status').length )
            {
                $('#ai-generator-status').html(aiomatic_creator_object.generating_excerpt);
            }
        }
        if(aiomatic_step === 'tags')
        {
            if( $('#ai-generator-status').length )
            {
                $('#ai-generator-status').html(aiomatic_creator_object.generating_tags);
            }
        }
        $.ajax({
            url: aiomatic_creator_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res){
                if(res.success == true)
                {
                    if(aiomatic_step === 'title')
                    {
                        if( $('#title').length )
                        {
                            $('#title').val(res.data.content);
                            $('#title').removeAttr('placeholder');
                        }
                        if( $('#title-prompt-text').length )
                        {
                            $('#title-prompt-text').hide();
                        }
                    }
                    if(aiomatic_step === 'description')
                    {
                        aiomaticSetContent('content', res.data.content);
                    }
                    if(aiomatic_step === 'short')
                    {
                        aiomaticSetContent('excerpt', res.data.content);
                    }
                    if(aiomatic_step === 'tags')
                    {
                        if( $('#new-tag-' + post_type + '_tag').length )
                        {
                            var curtag = $('#new-tag-' + post_type + '_tag').val();
                            $('#new-tag-' + post_type + '_tag').val(curtag + " " + res.data.content);
                        }
                    }
                    if(aiomatic_next_step === steps.length)
                    {
                        if( $('#ai-generator-status').length )
                        {
                            $('#ai-generator-status').html(aiomatic_creator_object.generating_done);
                        }
                        aiomaticRmLoading(aiomatic_ai_content_generator_btn);
                    }
                    else
                    {
                        aiomaticProductGenerator(title, aiomatic_next_step, steps);
                    }
                }
                else
                {
                    if( $('#ai-generator-status').length )
                    {
                        $('#ai-generator-status').html(aiomatic_creator_object.error_occurred + "!");
                    }
                    aiomatic_ShowError(aiomatic_creator_object.error_occurred + " " + JSON.stringify(res));
                    aiomaticRmLoading(aiomatic_ai_content_generator_btn);
                }
            },
            error: function ()
            {
                if( $('#ai-generator-status').length )
                {
                    $('#ai-generator-status').html(aiomatic_creator_object.error_occurred);
                }
                aiomatic_ShowError(aiomatic_creator_object.error_occurred);
                aiomaticRmLoading(aiomatic_ai_content_generator_btn);
            }
        });
    }
    aiomatic_ai_content_generator_btn.on('click', function ()
    {
        if( $('#aiomatic_original_title').length )
        {
            var aiomatic_title = $('#aiomatic_original_title').val();
        }
        else
        {
            var aiomatic_title = '';
        }
        if( $('#title').length )
        {
            var aicontent_title = $('#title').val();
        }
        else
        {
            var aicontent_title = '';
        }
        if(aiomatic_title == '')
        {
            aiomatic_title = aicontent_title;
        }
        if( $('#aiomatic_generate_title').length )
        {
            var aiomatic_generate_title = $('#aiomatic_generate_title').prop('checked') ? 1 : 0;
        }
        else
        {
            var aiomatic_generate_title = 0;
        }
        if( $('#aiomatic_generate_description').length )
        {
            var aiomatic_generate_description = $('#aiomatic_generate_description').prop('checked') ? 1 : 0;
        }
        else
        {
            var aiomatic_generate_description = 0;
        }
        if( $('#aiomatic_generate_meta').length )
        {
            var aiomatic_generate_meta = $('#aiomatic_generate_meta').prop('checked') ? 1 : 0;
        }
        else
        {
            var aiomatic_generate_meta = 0;
        }
        if( $('#aiomatic_generate_short').length )
        {
            var aiomatic_generate_short = $('#aiomatic_generate_short').prop('checked') ? 1 : 0;
        }
        else
        {
            var aiomatic_generate_short = 0;
        }
        if( $('#aiomatic_generate_tags').length )
        {
            var aiomatic_generate_tags = $('#aiomatic_generate_tags').prop('checked') ? 1 : 0;
        }
        else
        {
            var aiomatic_generate_tags = 0;
        }
        var aiomaticSteps = [];
        if(aiomatic_generate_title)
        {
            aiomaticSteps.push('title');
        }
        if(aiomatic_generate_meta)
        {
            aiomaticSteps.push('meta');
        }
        if(aiomatic_generate_description)
        {
            aiomaticSteps.push('description');
        }
        if(aiomatic_generate_short)
        {
            aiomaticSteps.push('short');
        }
        if(aiomatic_generate_tags)
        {
            aiomaticSteps.push('tags');
        }
        if(aiomatic_title === '')
        {
            alert(aiomatic_creator_object.no_title)
        }
        else if(!aiomaticSteps.length)
        {
            alert(aiomatic_creator_object.no_step)
        }
        else
        {
            aiomaticLoading(aiomatic_ai_content_generator_btn);
            aiomaticProductGenerator(aiomatic_title, 0, aiomaticSteps);
        }
    });
});