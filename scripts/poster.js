"use strict";
var initial = '';
function mainChanged()
{
    if(jQuery("#ai_rewriter").val() == 'enabled')
    {            
        jQuery(".hideMain").show();
        visionSelectedAI();
    }
    else
    {
        jQuery(".hideMain").hide();
    }
}
function mainChanged2()
{
    if(jQuery("#ai_featured_image").val() == 'enabled')
    {            
        jQuery(".hideMain2").show();
        mainChangedImg();
    }
    else
    {
        jQuery(".hideMain2").hide();
        jQuery(".hideImg").hide();
    }
}
function mainChanged2e()
{
    if(jQuery("#ai_featured_image_edit").val() == 'enabled')
    {            
        jQuery(".hideMain2e").show();
    }
    else
    {
        jQuery(".hideMain2e").hide();
    }
}
function mainChanged2c()
{
    if(jQuery("#ai_featured_image_edit_content").val() == 'enabled')
    {            
        jQuery(".hideMain2c").show();
    }
    else
    {
        jQuery(".hideMain2c").hide();
    }
}
function mainChangedImg()
{
    if(jQuery("#ai_featured_image_source").val() == '1')
    {            
        jQuery(".hideImg").show();
    }
    else
    {
        jQuery(".hideImg").hide();
    }
}

function aiomatic_audio_changed()
{
    var selected = jQuery('#content_text_speech').val();
    if(selected == 'google')
    {
        jQuery(".hideeleven").hide();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidegoogle").show();
        jQuery(".hideWideAudio").show();
    }
    if(selected == 'elevenlabs')
    {
        jQuery(".hideeleven").show();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hideWideAudio").show();
    }
    if(selected == 'did')
    {
        jQuery(".hidedid").show();
        jQuery(".hideopen").hide();
        jQuery(".hideeleven").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hideWideAudio").show();
    }
    if(selected == 'openai')
    {
        jQuery(".hidedid").hide();
        jQuery(".hideopen").show();
        jQuery(".hideeleven").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hideWideAudio").show();
    }
    if(selected == 'off')
    {
        jQuery(".hideeleven").hide();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hideWideAudio").hide();
    }
}
function mainChanged3()
{
    if(jQuery("#append_spintax").val() == 'append' || jQuery("#append_spintax").val() == 'preppend' || jQuery("#append_spintax").val() == 'inside')
    {            
        jQuery(".hideMain3").show();
        visionSelectedAI3();
    }
    else
    {
        jQuery(".hideMain3").hide();
    }
}
function mainChanged4()
{
    if(jQuery("#add_links").val() == 'enabled')
    {  
        jQuery(".hideMain4").show();
        if(jQuery("#link_method").val() == 'aiomatic')
        {        
            jQuery(".hideMain4a").show();
            jQuery(".hideMain4l").hide();
        }
        else
        {
            jQuery(".hideMain4a").hide();
            jQuery(".hideMain4l").show();
            
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
        hideLinks();
    }
    else
    {
        jQuery(".hideMain4").hide();
        jQuery(".hideMain4a").hide();
        jQuery(".hideMain4l").hide();
    }
}
function hideLinks()
{
    if(jQuery("#add_links").val() == 'disabled')
    {
        jQuery(".hidelinks").hide();
    }
    else
    {
        if(jQuery("#link_type").val() == 'internal')
        {            
            jQuery(".hidelinks").hide();
        }
        else
        {
            jQuery(".hidelinks").show();
        }
    }
}
function mainChanged5()
{
    if(jQuery("#add_comments").val() == 'enabled')
    {            
        jQuery(".hideMain5").show();
        visionSelectedAI5();
    }
    else
    {
        jQuery(".hideMain5").hide();
    }
}
function mainChanged7()
{
    if(jQuery("#add_cats").val() == 'enabled')
    {            
        jQuery(".hideMain7").show();
        visionSelectedAI7();
    }
    else
    {
        jQuery(".hideMain7").hide();
    }
}
function mainChanged8()
{
    if(jQuery("#add_tags").val() == 'enabled')
    {            
        jQuery(".hideMain8").show();
        visionSelectedAI8();
    }
    else
    {
        jQuery(".hideMain8").hide();
    }
}
function mainChanged10()
{
    if(jQuery("#add_custom").val() == 'enabled')
    {            
        jQuery(".hideMain10").show();
        visionSelectedAI10();
    }
    else
    {
        jQuery(".hideMain10").hide();
    }
}
function mainChanged9()
{
    if(jQuery("#append_toc").val() == 'append' || jQuery("#append_toc").val() == 'preppend' || jQuery("#append_toc").val() == 'heading' || jQuery("#append_toc").val() == 'heading2')
    {            
        jQuery(".hideMain9").show();
    }
    else
    {
        jQuery(".hideMain9").hide();
    }
}
function mainChanged6()
{
    if(jQuery("#add_seo").val() == 'enabled')
    {            
        jQuery(".hideMain6").show();
        visionSelectedAI6();
    }
    else
    {
        jQuery(".hideMain6").hide();
    }
}
function loadMe()
{
    toggleMain();
    mainChanged();
    toggleCats();
    toggleCustom();
    mainChangedImg();
    mainChanged2();
    mainChanged2e();
    mainChanged2c();
    mainChanged3();
    mainChanged4();
    mainChanged5();
    mainChanged6();
    mainChanged7();
    mainChanged8();
    mainChanged9();
    mainChanged10();
    aiomatic_audio_changed();
    hideLinks();
}
window.onload = loadMe;
var unsaved = false;
jQuery(document).ready(function () {
    jQuery(":input").on('change', function(){
        var classes = this.className;
        var classes = this.className.split(' ');
        var found = jQuery.inArray('actions', classes) > -1;
        if (this.id != 'select-shortcode' && this.id != 'PreventChromeAutocomplete' && this.className != 'sc_chat_form_field_prompt_text' && this.id != 'actions' && !found)
        {
            unsaved = true;
        }
    });
    function unloadPage(){ 
        if(unsaved){
            return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
        }
    }
    window.onbeforeunload = unloadPage;
});
function toggleCats()
{
    if(jQuery('#hideCats').is(":visible"))
    {            
        jQuery(".hideCats").hide();
    }
    else
    {
        jQuery(".hideCats").show();
    }
}
function toggleCustom()
{
    if(!jQuery('#post_custom').is(":checked"))
    {            
        jQuery(".hideCustom").hide();
    }
    else
    {
        jQuery(".hideCustom").show();
    }
}
function toggleMain()
{
    if(!jQuery('#aiomatic_spinning').is(":checked"))
    {            
        jQuery(".hideAuto").hide();
    }
    else
    {
        jQuery(".hideAuto").show();
    }
}