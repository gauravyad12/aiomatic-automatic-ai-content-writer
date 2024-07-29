"use strict";
jQuery(document).ready( function($) {
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
   jQuery('input#aiomatic_media_manager').on('click', function(e) {
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
    jQuery('input#aiomatic_image_id').val(ids);
    Refresh_Image(ids);
    });
    image_frame.on('open',function() {
        var selection =  image_frame.state().get('selection');
        var ids = jQuery('input#aiomatic_image_id').val().split(',');
        ids.forEach(function(id) {
            var attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
        });
    });
    image_frame.open();
});
jQuery('input#aiomatic_media_manager_advanced').on('click', function(e) {
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
    jQuery('input#aiomatic_image_id_advanced').val(ids);
    Refresh_Image_Advanced(ids);
    });
    image_frame.on('open',function() {
        var selection =  image_frame.state().get('selection');
        var ids = jQuery('input#aiomatic_image_id_advanced').val().split(',');
        ids.forEach(function(id) {
            var attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
        });
    });
    image_frame.open();
});
jQuery('input#aiomatic_media_clear_b').on('click', function(e) 
{
    e.preventDefault();
    jQuery('input#aiomatic_image_id_b').val('0');
    jQuery('#aiomatic-preview-image-b').removeAttr('src');
    jQuery('#aiomatic-preview-image-b').removeAttr('srcset');
    jQuery('#aiomatic-preview-image-b').removeAttr('width');
    jQuery('#aiomatic-preview-image-b').removeAttr('height');
    jQuery('#aiomatic-preview-image-b').removeAttr('sizes');
    jQuery('#aiomatic-preview-image-b').removeAttr('loading');
    jQuery('#aiomatic-preview-image-b').removeAttr('decoding');
    jQuery('#aiomatic-preview-image-b').removeAttr('alt');
    jQuery('#aiomatic-preview-image-b').removeAttr('class');
    anythingChanged();
});
jQuery('input#aiomatic_media_clear').on('click', function(e) 
{
    e.preventDefault();
    jQuery('input#aiomatic_image_id').val('0');
    jQuery('#aiomatic-preview-image').removeAttr('src');
    jQuery('#aiomatic-preview-image').removeAttr('srcset');
    jQuery('#aiomatic-preview-image').removeAttr('width');
    jQuery('#aiomatic-preview-image').removeAttr('height');
    jQuery('#aiomatic-preview-image').removeAttr('sizes');
    jQuery('#aiomatic-preview-image').removeAttr('loading');
    jQuery('#aiomatic-preview-image').removeAttr('decoding');
    jQuery('#aiomatic-preview-image').removeAttr('alt');
    jQuery('#aiomatic-preview-image').removeAttr('class');
});
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
jQuery('input#aiomatic_media_manager_b').on('click', function(e) {
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
        jQuery('input#aiomatic_image_id_b').val(ids);
        Refresh_Image_b(ids);
        anythingChanged();
    });
    image_frame.on('open',function() {
        var selection =  image_frame.state().get('selection');
        var ids = jQuery('input#aiomatic_image_id_b').val().split(',');
        ids.forEach(function(id) {
            var attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
        });
    });
    image_frame.open();
});
});
function Refresh_Image_New(the_id){
    var data = {
        action: 'aiomatic_get_image',
        id: the_id,
        nonce: aiomatic_ajax_object.nonce
    };
    jQuery.get(ajaxurl, data, function(response) {
        if(response.success === true) {
            response.data.image = response.data.image.replace('aiomatic-preview-image', 'aiomatic-preview-image-new');
            jQuery('#aiomatic-preview-image-new').replaceWith( response.data.image );
        }
    });
}
function Refresh_Image(the_id){
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
function Refresh_Image_Advanced(the_id){
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
function Refresh_Image_b(the_id){
    var data = {
        action: 'aiomatic_get_image',
        id: the_id,
        nonce: aiomatic_ajax_object.nonce
    };
    jQuery.get(ajaxurl, data, function(response) {
        if(response.success === true) {
            response.data.image = response.data.image.replace('id="aiomatic-preview-image"', 'id="aiomatic-preview-image-b"')
            jQuery('#aiomatic-preview-image-b').replaceWith( response.data.image );
            const srcPattern = /src="([^"]+?)"/;
            const match = response.data.image.match(srcPattern);
            if (match && match.length > 1) 
            {
                jQuery('.openai-chat-avatar').attr('src', match[1]);
            }
            else 
            {
                console.log("Src attribute not found.");
            }
        }
    });
}