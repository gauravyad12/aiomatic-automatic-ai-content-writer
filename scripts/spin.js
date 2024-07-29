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
function visionSelectedAI()
{
    var selected = jQuery('#edit_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision").show();
    }
    else
    {
        jQuery(".hideVision").hide();
    }
}
function visionSelectedAI3()
{
    var selected = jQuery('#model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision3").show();
    }
    else
    {
        jQuery(".hideVision3").hide();
    }
}
function visionSelectedAI7()
{
    var selected = jQuery('#cats_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision7").show();
    }
    else
    {
        jQuery(".hideVision7").hide();
    }
}
function visionSelectedAI9()
{
    var selected = jQuery('#link_juicer_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision9").show();
    }
    else
    {
        jQuery(".hideVision9").hide();
    }
}
function visionSelectedAI8()
{
    var selected = jQuery('#tags_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision8").show();
    }
    else
    {
        jQuery(".hideVision8").hide();
    }
}
function visionSelectedAI10()
{
    var selected = jQuery('#custom_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision10").show();
    }
    else
    {
        jQuery(".hideVision10").hide();
    }
}
function visionSelectedAI5()
{
    var selected = jQuery('#comments_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision5").show();
    }
    else
    {
        jQuery(".hideVision5").hide();
    }
}
function visionSelectedAI6()
{
    var selected = jQuery('#seo_model').val();
    var found = false;
    aiomatic_object.modelsvision.forEach((model) => {
        if(model == selected)
        {
            found = true;
        }
    });
    if(found == true)
    {
        jQuery(".hideVision6").show();
    }
    else
    {
        jQuery(".hideVision6").hide();
    }
}
jQuery(document).ready(function()
{
    visionSelectedAI();
    visionSelectedAI3();
    visionSelectedAI7();
    visionSelectedAI8();
    visionSelectedAI10();
    visionSelectedAI9();
    visionSelectedAI5();
    visionSelectedAI6();
});