"use strict";
jQuery(document).ready( function($) 
{
    jQuery('body').on('click', '#aivisionbut' + aiomatic_vision_object.chatid, function(e) 
    {
        $('#aiomatic_vision_input' + aiomatic_vision_object.chatid).click();
    });
    jQuery('body').on('change', '#aiomatic_vision_input' + aiomatic_vision_object.chatid, function(e) 
    {
        var vision_input = jQuery('#aiomatic_vision_input' + aiomatic_vision_object.chatid);
        if (vision_input[0] !== undefined && vision_input[0].files !== undefined && vision_input[0].files[0] !== undefined && vision_input[0].files && vision_input[0].files[0])
        {
            $('#aivisionbut' + aiomatic_vision_object.chatid).css("background-color", aiomatic_vision_object.bg_color);
        }
        else
        {
            $('#aivisionbut' + aiomatic_vision_object.chatid).css("background-color", "");
        }
    });
});