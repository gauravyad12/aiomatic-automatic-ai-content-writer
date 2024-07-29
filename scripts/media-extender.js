"use strict";
function aiomaticExtendMediaLightboxTemplate(anchor1, anchor2, anchor3, anchor4) 
{
	var attachmentDetailsTmpl = jQuery('#tmpl-attachment-details').text();
	attachmentDetailsTmpl = attachmentDetailsTmpl.replace(/(<(a|button)[^>]+class="[^"]*edit-attachment[^"]*"[^>]*>[^<]*<\/(a|button)>)/, '\n$1' + anchor1);
	jQuery('#tmpl-attachment-details').text(attachmentDetailsTmpl);
	var attachmentDetailsTmplTwoColumn = jQuery('#tmpl-attachment-details-two-column').text();
	attachmentDetailsTmplTwoColumn = attachmentDetailsTmplTwoColumn.replace(/(<a[^>]+class="[^"]*view-attachment[^"]*"[^>]*>[^<]*<\/a>)/, '\n$1 | ' + anchor2);
	attachmentDetailsTmplTwoColumn = attachmentDetailsTmplTwoColumn.replace(/(<(a|button)[^>]+class="[^"]*edit-attachment[^"]*"[^>]*>[^<]*<\/(a|button)>)/, '\n$1' + anchor3);
	jQuery('#tmpl-attachment-details-two-column').text(attachmentDetailsTmplTwoColumn);
	var imageDetailsTmpl = jQuery('#tmpl-image-details').text();
	imageDetailsTmpl = imageDetailsTmpl.replace(/(<input type="button" class="replace-attachment button")/, anchor4 + '\n$1');
	jQuery('#tmpl-image-details').text(imageDetailsTmpl);
}
function aiomaticGetUrlVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}
jQuery(document).ready(function($) 
{
    jQuery(document).on('click', '#aiomatic_save_template', function(e) {
        var templateName = prompt("Enter a name for the template:");
        if (templateName) {
            var aiPrompt = jQuery('#aiomatic_media_prompt').val();
            jQuery.post(ajaxurl, {
                action: 'aiomatic_save_seo_template',
                template_name: templateName,
                prompt: aiPrompt,
                nonce: aiomatic_media_object.nonce
            }, function(response) {
                if (response.success) {
                    alert('Template saved successfully!');
                    loadTemplates();
                } else {
                    alert('Failed to save template.');
                }
            });
        }
    });
    function loadTemplates() {
        jQuery.post(ajaxurl, {
            action: 'aiomatic_load_seo_templates',
            nonce: aiomatic_media_object.nonce
        }, function(response) {
            if (response.success) {
                var templates = response.data;
                jQuery('#aiomatic_template_selector').empty().append(jQuery('<option>', {
                    value: '',
                    text: 'Choose a template'
                }));
                jQuery.each(Object.keys(templates), function(index, name) {
                    jQuery('#aiomatic_template_selector').append(jQuery('<option>', {
                        value: name,
                        text: name
                    }));
                });
            } else {
                alert('Failed to load templates.');
            }
        });
    }
    $(document).on('click', '#aiomatic_load_template', function(e) {
        var templateName = $('#aiomatic_template_selector').val();
        if (templateName) {
            $.post(ajaxurl, {
                action: 'aiomatic_load_seo_template',
                template_name: templateName,
                nonce: aiomatic_media_object.nonce
            }, function(response) {
                if (response.success) {
                    $('#aiomatic_media_prompt').val(response.data);
                    alert('Template loaded successfully!');
                } else {
                    alert('Failed to load template.');
                }
            });
        } else {
            alert('Please select a template.');
        }
    });
    $(document).on('click', '#aiomatic_get_templates', function(e) {
        loadTemplates();
        alert('Templates imported successfully!');
    });
    $(document).on('click', '#aiomatic_delete_template', function(e) {
        var templateName = $('#aiomatic_template_selector').val();
        if (templateName && confirm("Are you sure you want to delete this template?")) {
            $.post(ajaxurl, {
                action: 'aiomatic_delete_seo_template',
                template_name: templateName,
                nonce: aiomatic_media_object.nonce
            }, function(response) {
                if (response.success) {
                    alert('Template deleted successfully!');
                    loadTemplates();
                } else {
                    alert('Failed to delete template.');
                }
            });
        } else {
            alert('Please select a template.');
        }
    });
    if ($('body.post-type-attachment').length) {
		var currPostId = aiomaticGetUrlVars()['post'];
		var editImageBtn = $('#imgedit-open-btn-' + currPostId);
		if (editImageBtn.length) {
			var data = {
				'action' : 'aiomatic_get_edit_image_anchor',
				'post' : currPostId,
				'classes' : 'button',
                'nonce' : aiomatic_media_object.nonce
			};
			jQuery.post(ajaxurl, data, function(response) {
				editImageBtn.after(response);
			});
		}
	}
    $(document).on('click', 'a.autox-thickbox', function(e) {
        e.preventDefault();
        var currEl = $(this);
        aiomaticLoadCropThickbox(currEl.attr('href'));
        return false;
    });
	$(document).on('click', '#aiomatic-cropper-bckgr', function(e) {
		e.preventDefault();
		aiomaticCancelCropImage();
		return false;
	});
	$(document).on('keydown', function(e) {
		if (e.keyCode === 27) {
			aiomaticCancelCropImage();
			return false;
		}
	});
});
function aiomaticLoadCropThickbox(href) {
	jQuery.get(href, function(data) {
		jQuery('body').append(data);
        aiomaticInitScrollingMediaFrameRouter();
        jQuery(window).resize(aiomaticInitScrollingMediaFrameRouter);
	});
}
function aiomaticInitScrollingMediaFrameRouter() {
    var arrows, arrowL, arrowR, arrowWidth;
    var mediaFrameRouter = jQuery('#aiomatic-cropper-wrapper .media-frame-router');
    var mediaRouter = mediaFrameRouter.find('.media-router');
    var mediaFrameRouterWidth = mediaFrameRouter.width();
    var mediaRouterWidth = 3;
    var currIndex = 0;
    var activeIndex = 0;
    var scrollLeft = 0;
    var mediaRouterAnchors = mediaRouter.find('a');
    mediaRouterAnchors.each(function(index) {
        var currEl = jQuery(this);
        mediaRouterWidth += parseInt(currEl.outerWidth(true), 10);
        if (currEl.hasClass('active')) {
            activeIndex = index;
        }
    });
    mediaRouter.css('width', mediaRouterWidth + 'px');
    var hiddenWidth = mediaRouterWidth - mediaFrameRouterWidth;
    if (hiddenWidth > 0) {
        function aiomatic_mediaFrameVisible(index) {
            var minScrollLeft = arrowWidth + mediaFrameRouterWidth;
            for (var i = 0; i <= index; i++) {
                minScrollLeft -= parseInt(jQuery(mediaRouterAnchors[i]).outerWidth(true), 10);
            }
            return scrollLeft < minScrollLeft;
        }
        function aiomaticaiomatic_scrollMediaFrameTo(index, forced) {
            if ((index != currIndex || forced === true) && index > -1 && index < mediaRouterAnchors.length) {
                scrollLeft = arrowWidth;
                for (var i = 0; i < index; i++) {
                    scrollLeft -= parseInt(jQuery(mediaRouterAnchors[i]).outerWidth(true), 10);
                }
                var doScroll = (scrollLeft * -1) - parseInt(jQuery(mediaRouterAnchors[index]).outerWidth(true), 10) - arrowWidth < hiddenWidth;
                if (doScroll) {
                    if (forced === true) {
                        mediaRouter.css('left', scrollLeft + 'px');
                    } else {
                        mediaRouter.animate({
                            left : scrollLeft + 'px'
                        }, 300);
                    }
                    currIndex = index;
                }
                if (currIndex > 0) {
                    arrowL.addClass('active');
                } else {
                    arrowL.removeClass('active');
                }
                if (currIndex < mediaRouterAnchors.length - 1 && !aiomatic_mediaFrameVisible(mediaRouterAnchors.length - 1)) {
                    arrowR.addClass('active');
                } else {
                    arrowR.removeClass('active');
                }
            }
        }
        function aiomatic_scrollMediaFrame(right, forced) {
            aiomaticaiomatic_scrollMediaFrameTo(currIndex + (right ? 1 : -1), forced);
        }
        function aiomaticScrollMediaFrameRight(forced) {
            aiomatic_scrollMediaFrame(true, forced);
        }
        function aiomaticScrollMediaFrameLeft(forced) {
            aiomatic_scrollMediaFrame(false, forced);
        }
        arrows = mediaFrameRouter.find('.arrows');
        arrowR = arrows.filter('.arrow-r').unbind().click(aiomaticScrollMediaFrameRight);
        arrowL = arrows.filter('.arrow-l').unbind().click(aiomaticScrollMediaFrameLeft);
        arrowWidth = parseInt(arrowL.outerWidth(true), 10);
        arrows.css('background-color', jQuery('.media-modal-content').css('background-color')).show();
        aiomaticaiomatic_scrollMediaFrameTo(currIndex, true);
        while (!aiomatic_mediaFrameVisible(activeIndex)) {
            aiomaticScrollMediaFrameRight(true);
        }
    }
}
function aiomaticCancelCropImage() {
	jQuery('#aiomatic-cropper-wrapper').remove();
}
function aiseoselect()
{
    var selected = jQuery('#seo_assistant_id').val();
    if(selected == '')
    {
        jQuery('#aiomatic_model_selector').removeAttr('disabled');
    }
    else
    {
        jQuery("#aiomatic_model_selector").attr('disabled', 'disabled');
    }
}
function target_updated_ai()
{
    if(jQuery("#aiomatic_target_selector option:selected").val() === 'caption') 
    {      
        jQuery("#aiomatic_media_prompt").val('Write a SEO friendly caption text for an image with the title: %%image_title%%');
    }
    else if(jQuery("#aiomatic_target_selector option:selected").val() === 'alt') 
    {
        jQuery("#aiomatic_media_prompt").val('Write a SEO friendly alt text for an image with the title: %%image_title%%');
    }
    else if(jQuery("#aiomatic_target_selector option:selected").val() === 'description') 
    {
        jQuery("#aiomatic_media_prompt").val('Write a SEO friendly description text for an image with the title: %%image_title%%');
    }
    else if(jQuery("#aiomatic_target_selector option:selected").val() === 'title') 
    {
        jQuery("#aiomatic_media_prompt").val('Write a SEO friendly title text for an image from my WordPress blog');
    }
}
function aiomaticGenerateMediaText()
{
    var ai_text = jQuery("#aiomatic_media_prompt").val();
    var ai_model = jQuery("#aiomatic_model_selector").val();
    var ai_assistant = jQuery("#seo_assistant_id").val();
    var title = jQuery("#aiomatic_attachment_title").val();
    var alt = jQuery("#aiomatic_attachment_alt").val();
    var caption = jQuery("#aiomatic_attachment_caption").val();
    var content = jQuery("#attachment_content").val();
    var target = jQuery("#aiomatic_target_selector").val();
    var button = jQuery("#aiomatic_generate_text_media");
    var id = jQuery("#aiomatic_media_id").val();
    function aiomaticLoading(btn)
    {
        jQuery("#aiomatic_target_selector").attr('disabled','disabled');
        jQuery("#aiomatic_media_prompt").attr('disabled','disabled');
        jQuery("#aiomatic_model_selector").attr('disabled','disabled');
        jQuery("#seo_assistant_id").attr('disabled','disabled');
        btn.attr('disabled','disabled');
        if(!btn.find('spinner').length){
            btn.append('<span class="spinner"></span>');
        }
        btn.find('.spinner').css('visibility','unset');
    }
    function aiomaticRmLoading(btn)
    {
        jQuery("#aiomatic_target_selector").removeAttr('disabled');
        jQuery("#aiomatic_media_prompt").removeAttr('disabled');
        jQuery("#aiomatic_model_selector").removeAttr('disabled');
        jQuery("#seo_assistant_id").removeAttr('disabled');
        btn.removeAttr('disabled');
        btn.find('.spinner').remove();
    }
    aiomaticLoading(button);
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'aiomatic_generate_media_text',
            prompt: ai_text,
            nonce : aiomatic_media_object.nonce,
            model: ai_model,
            assistant_id: ai_assistant,
            title: title,
            alt: alt, 
            caption: caption,
            content: content,
            id: id
        },
        success: function(response) {
            aiomaticRmLoading(button);
            if(response.success == true)
            {
                if(target == 'title')
                {
                    jQuery('#aiomatic_attachment_title').val(response.data.content);
                }
                else if(target == 'caption')
                {
                    jQuery('#aiomatic_attachment_caption').val(response.data.content);
                }
                else if(target == 'alt')
                {
                    jQuery('#aiomatic_attachment_alt').val(response.data.content);
                }
                else if(target == 'description')
                {
                    jQuery('#attachment_content').val(response.data.content);
                }
                else
                {
                    console.log('No valid target specified: ' + target);
                }
            }
            else
            {
                alert('Failed to generate text, please try again later');
                console.log('Text generator returned an error: ' + JSON.stringify(response));
            }
        },
        error: function(error) {
            aiomaticRmLoading(button);
            alert('Failed to generate text, please try again later');
            console.log('Text generator failed: ' + error.responseText);
        },
    });
}
function aiomatic_save_media_data()
{
    var title = jQuery("#aiomatic_attachment_title").val();
    var alt = jQuery("#aiomatic_attachment_alt").val();
    var caption = jQuery("#aiomatic_attachment_caption").val();
    var content = jQuery("#attachment_content").val();
    var id = jQuery("#aiomatic_media_id").val();
    var button = jQuery("#aiomatic_save_media");
    function aiomaticLoading(btn)
    {
        jQuery("#aiomatic_target_selector").attr('disabled','disabled');
        jQuery("#aiomatic_media_prompt").attr('disabled','disabled');
        jQuery("#aiomatic_model_selector").attr('disabled','disabled');
        jQuery("#seo_assistant_id").attr('disabled','disabled');
        jQuery("#aiomatic_generate_text_media").attr('disabled','disabled');
        jQuery("#aiomatic_attachment_title").attr('disabled','disabled');
        jQuery("#aiomatic_attachment_alt").attr('disabled','disabled');
        jQuery("#aiomatic_attachment_caption").attr('disabled','disabled');
        jQuery("#attachment_content").attr('disabled','disabled');
        btn.attr('disabled','disabled');
        if(!btn.find('spinner').length){
            btn.append('<span class="spinner"></span>');
        }
        btn.find('.spinner').css('visibility','unset');
    }
    function aiomaticRmLoading(btn)
    {
        jQuery("#aiomatic_target_selector").removeAttr('disabled');
        jQuery("#aiomatic_media_prompt").removeAttr('disabled');
        jQuery("#aiomatic_model_selector").removeAttr('disabled');
        jQuery("#seo_assistant_id").removeAttr('disabled');
        jQuery("#aiomatic_generate_text_media").removeAttr('disabled');
        jQuery("#aiomatic_attachment_title").removeAttr('disabled');
        jQuery("#aiomatic_attachment_alt").removeAttr('disabled');
        jQuery("#aiomatic_attachment_caption").removeAttr('disabled');
        jQuery("#attachment_content").removeAttr('disabled');
        btn.removeAttr('disabled');
        btn.find('.spinner').remove();
    }
    aiomaticLoading(button);
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'aiomatic_save_media_text',
            nonce : aiomatic_media_object.nonce,
            title: title,
            alt: alt, 
            caption: caption,
            content: content,
            id: id
        },
        success: function(response) {
            aiomaticRmLoading(button);
            if(response.success == true)
            {
                alert('Update successful, you need to refresh the page to see the changes appear!');
            }
            else
            {
                alert('Failed to update media, please try again later');
                console.log('Media update returned an error: ' + JSON.stringify(response));
            }
        },
        error: function(error) {
            aiomaticRmLoading(button);
            alert('Failed to update media, please try again later');
            console.log('Media update failed: ' + error.responseText);
        },
    });
}