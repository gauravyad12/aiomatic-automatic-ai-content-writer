"use strict";
jQuery(document).ready(function($) {
    function aiomaticLoading(btn){
        btn.attr('disabled','disabled');
        if(!btn.find('aiomatic-jumping-dots').length){
            btn.append('<span class="aiomatic-jumping-dots">&nbsp;<span class="aiomatic-dot-1">.</span><span class="aiomatic-dot-2">.</span><span class="aiomatic-dot-3">.</span></span>');
        }
        btn.find('.aiomatic-jumping-dots').css('visibility','unset');
    }
    function aiomaticRmLoading(btn){
        btn.removeAttr('disabled');
        btn.find('.aiomatic-jumping-dots').remove();
    }
    function aiomaticSetEditorContent(editorId, content)
    {
        if (typeof tinyMCE !== 'undefined') 
        {
            var editor = tinyMCE.get(editorId);
            if (editor) 
            {
                editor.setContent(content);
            } 
            else 
            {
                jQuery('#' + editorId).val(content);
            }
        }
        else
        {
            jQuery('#' + editorId).val(content);
        }
    }
    $('#delete-link').append('<span id="aiomatic-button-span">&nbsp;<button id="aiomatic-tax-button" class="button">' + AICustomButtonData.writeMessage + '</button>&nbsp;&nbsp;&nbsp;' + AICustomButtonData.moreSettings + '</span');
    $('#aiomatic-tax-button').on('click', function(e) {
        e.preventDefault();
        var descr = jQuery("#description");
        if(descr.length)
        {
            document.getElementById('aiomatic-tax-button').setAttribute('disabled','disabled');
            aiomaticLoading(jQuery('#aiomatic-tax-button'));
            $.ajax({
                url: AICustomButtonData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'aiomatic_write_tax_description',
                    taxonomy: AICustomButtonData.taxonomy,
                    tag_ID: AICustomButtonData.tagID,
                    nonce: AICustomButtonData.nonce
                },
                success: function(res) {
                    if(res.success == true)
                    {
                        document.getElementById('aiomatic-tax-button').removeAttribute('disabled');
                        aiomaticRmLoading(jQuery('#aiomatic-tax-button'));
                        aiomaticSetEditorContent('description', res.data.content);
                    }
                    else
                    {
                        alert('Failed to generate description, please try again later');
                        console.log('Taxonomy description generator returned an error: ' + JSON.stringify(res));
                        document.getElementById('aiomatic-tax-button').removeAttribute('disabled');
                        aiomaticRmLoading(jQuery('#aiomatic-tax-button'));
                    }
                },
                error: function(xhr, status, error) {
                    document.getElementById('aiomatic-tax-button').removeAttribute('disabled');
                    aiomaticRmLoading(jQuery('#aiomatic-tax-button'));
                    alert('Failed to generate the taxonomy description, please try again later!');
                    console.log('Error: ' + error);
                }
            });
        }
        else
        {
            var descr = jQuery("#rank_math_description_editor");
            if(descr.length)
            {
                document.getElementById('aiomatic-tax-button').setAttribute('disabled','disabled');
                aiomaticLoading(jQuery('#aiomatic-tax-button'));
                $.ajax({
                    url: AICustomButtonData.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'aiomatic_write_tax_description',
                        taxonomy: AICustomButtonData.taxonomy,
                        tag_ID: AICustomButtonData.tagID,
                        nonce: AICustomButtonData.nonce
                    },
                    success: function(res) {
                        if(res.success == true)
                        {
                            document.getElementById('aiomatic-tax-button').removeAttribute('disabled');
                            aiomaticRmLoading(jQuery('#aiomatic-tax-button'));
                            aiomaticSetEditorContent('rank_math_description_editor', res.data.content);
                        }
                        else
                        {
                            alert('Failed to generate SEO description, please try again later');
                            console.log('Taxonomy SEO description generator returned an error: ' + JSON.stringify(res));
                            document.getElementById('aiomatic-tax-button').removeAttribute('disabled');
                            aiomaticRmLoading(jQuery('#aiomatic-tax-button'));
                        }
                    },
                    error: function(xhr, status, error) {
                        document.getElementById('aiomatic-tax-button').removeAttribute('disabled');
                        aiomaticRmLoading(jQuery('#aiomatic-tax-button'));
                        alert('Failed to generate the taxonomy rank_math_description, please try again later!');
                        console.log('Error: ' + error);
                    }
                });
            }
        }
    });
});