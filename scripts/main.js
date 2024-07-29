"use strict"; 
var initial = '';
function aiomaticLoading(btn)
{
    btn.attr('disabled','disabled');
    if(!btn.find('spinner').length){
        btn.append('<span class="spinner"></span>');
    }
    btn.find('.spinner').css('visibility','unset');
}
function aiomaticRmLoading(btn)
{
    btn.removeAttr('disabled');
    btn.find('.spinner').remove();
}
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
function aiomaticRefreshOllama()
{
    var confirm_delete = confirm('Are you sure you want to refresh Ollama model list?');
    if (confirm_delete) {
        document.getElementById('ollamaButton').setAttribute('disabled','disabled');
        jQuery.ajax({
            url: mycustommainsettings.ajaxurl,
            type: 'POST',
            data: {
                action: 'aiomatic_refresh_ollama_models',
                nonce: mycustommainsettings.nonce
            },
            success: function(res) {
                if(res.success == true)
                {
                    document.getElementById('ollamaButton').removeAttribute('disabled');
                    alert('Ollama models refreshed successfully!');
                }
                else
                {
                    alert('Failed to refresh model list: ' + res.data.message);
                    console.log('Failed to refresh model list: ' + JSON.stringify(res));
                    document.getElementById('ollamaButton').removeAttribute('disabled');
                }
            },
            error: function(xhr, status, error) {
                document.getElementById('ollamaButton').removeAttribute('disabled');
                alert('Failed to refresh model list, please try again later!');
                console.log('Error: ' + error);
            }
        });
    }
}
function actionsChangedTax()
{
    var confirm_delete = confirm('Are you sure you want to run manual taxonomy description writing?');
    if (confirm_delete) {
        document.getElementById('taxactions').setAttribute('disabled','disabled');
        jQuery.ajax({
            url: mycustommainsettings.ajaxurl,
            type: 'POST',
            data: {
                action: 'aiomatic_write_tax_description_manual',
                nonce: mycustommainsettings.nonce
            },
            success: function(res) {
                if(res.success == true)
                {
                    document.getElementById('taxactions').removeAttribute('disabled');
                    alert('Taxonomy descriptions were written successfully!');
                }
                else
                {
                    alert('Failed to generate manual tax description: ' + res.data.message);
                    console.log('Taxonomy manual description generator returned an error: ' + JSON.stringify(res));
                    document.getElementById('taxactions').removeAttribute('disabled');
                }
            },
            error: function(xhr, status, error) {
                document.getElementById('taxactions').removeAttribute('disabled');
                alert('Failed to generate the taxonomy description, please try again later!');
                console.log('Error: ' + error);
            }
        });
    }
}
jQuery(document).ready(function($) 
{
    if($('#aiomatic_roaylty_free_sortable').length)
    {
        var mainCardOrder = $('#aiomatic_roaylty_free_sortable');
        if(mainCardOrder !== undefined)
        {
            mainCardOrder.sortable({
                update: function(event, ui) {
                    var cardOrder = $('#aiomatic_roaylty_free_sortable');
                    if(cardOrder !== undefined)
                    {
                        var scardOrder = cardOrder.sortable('toArray').toString();
                        $('#sortable_cards').val(scardOrder);
                    }
                    else
                    {
                        console.log('Cannot find the aiomatic_roaylty_free_sortable input!');
                    }
                }
            });
        }
        else
        {
            console.log('Error, aiomatic_roaylty_free_sortable input not found!');
        }
    }
});
    function populate_default_internet()
    {
        jQuery("#internet_prompt").val(`Web search results:
%%web_results%%
Current date: %%current_date%%
Instructions: Using the provided web search results, write a comprehensive reply to the given query. Make sure to cite results using [[number](URL)] notation after the reference. If the provided search results refer to multiple subjects with the same name, write separate answers for each subject.
Query: %%original_query%%`);
    }
    function populate_default_template()
    {
        jQuery("#internet_single_template").val(`[%%result_counter%%]: %%result_title%% %%result_snippet%% 
URL: %%result_link%%`);
    }
    function embeddingsChanged()
    {
        if(jQuery('#embeddings_bulk').is(":checked"))
        {            
            jQuery(".hideEmbeddingsContent").show();
        }
        else
        {
            jQuery(".hideEmbeddingsContent").hide();
        }
    }
    function internetChanged()
    {
        if(jQuery('#internet_bulk').is(":checked"))
        {            
            jQuery(".hideInternetContent").show();
        }
        else
        {
            jQuery(".hideInternetContent").hide();
        }
    }
    function imgChanged()
    {
        if(jQuery('#random_image_sources').is(":checked"))
        {            
            jQuery(".hideImgs").show();
        }
        else
        {
            jQuery(".hideImgs").hide();
        }
    }
    function imgCopyChanged()
    {
        if(jQuery("#copy_locally option:selected").val() === 'amazon')
        {
            jQuery(".hideCompress").show();
        }
        else
        {
            if(jQuery("#copy_locally option:selected").val() === 'digital')
            {
                jQuery(".hideCompress").show();
            }
            else
            {
                if(jQuery("#copy_locally option:selected").val() === 'wasabi')
                {
                    jQuery(".hideCompress").show();
                }
                else
                {
                    if(jQuery("#copy_locally option:selected").val() === 'cloudflare')
                    {
                        jQuery(".hideCompress").show();
                    }
                    else
                    {
                        if(jQuery("#copy_locally option:selected").val() === 'on')
                        {            
                            jQuery(".hideCompress").show();
                        }
                        else
                        {
                            jQuery(".hideCompress").hide();
                        }
                    }
                }
            }
        }
    }
    function kwChanged()
    {
        if(jQuery('#kw_method').val() == 'ai')
        {            
            jQuery(".kwai").show();
            jQuery(".kwbuiltin").hide();
        }
        else
        {
            jQuery(".kwai").hide();
            jQuery(".kwbuiltin").show();
        }
    }
    function taxSeoChanged()
    {
        if(jQuery('#tax_seo_auto').val() == 'write')
        {            
            jQuery(".TaxSEO").show();
        }
        else
        {
            jQuery(".TaxSEO").hide();
        }
    }
    function imageAIChanged()
    {
        if(jQuery('#use_image_ai').is(":checked"))
        {            
            jQuery(".hideimgai").show();
        }
        else
        {
            jQuery(".hideimgai").hide();
        }
    }
    function ytKwChanged()
    {
        if(jQuery('#improve_yt_kw').is(":checked"))
        {            
            jQuery(".hideytkw").show();
        }
        else
        {
            jQuery(".hideytkw").hide();
        }
    }
    function embChanged()
    {
        if(jQuery('#rewrite_embedding').is(":checked"))
        {            
            jQuery(".hideEmb").show();
        }
        else
        {
            jQuery(".hideEmb").hide();
        }
    }
    function keyUpdated()
    {
        var enteredText = jQuery('#app_id').val();
        if(enteredText !== undefined)
        {
            var numberOfLineBreaks = (enteredText.match(/\n/g)||[]).length;
            if(numberOfLineBreaks > 0)
            {
                jQuery(".multiplehide").show();
            }
            else
            {
                jQuery(".multiplehide").hide();
            }
        }
    }
    function mainChanged()
    {
        if(jQuery('#aiomatic-logo').length)
        {
            return;
        }
        imgCopyChanged();
        imgChanged();
        embeddingsChanged();
        internetChanged();
        taxSeoChanged();
        ytKwChanged();
        imageAIChanged();
        keyUpdated();
        embChanged();
        kwChanged();
        if(jQuery('.input-checkbox-ai').is(":checked"))
        {            
            jQuery(".hideMain").show();
        }
        else
        {
            jQuery(".hideMain").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'best' || jQuery("#spin_text option:selected").val() === 'wordai' || jQuery("#spin_text option:selected").val() === 'spinrewriter' || jQuery("#spin_text option:selected").val() === 'spinnerchief' || jQuery("#spin_text option:selected").val() === 'chimprewriter' || jQuery("#spin_text option:selected").val() === 'contentprofessor') 
        {      
            jQuery(".hideBest").show();
        }
        else
        {
            jQuery(".hideBest").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'spinnerchief') 
        {      
            jQuery(".hideChief").show();
        }
        else
        {
            jQuery(".hideChief").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'spinrewriter') 
        {      
            jQuery(".hideSpinRewriterSpecific").show();
        }
        else
        {
            jQuery(".hideSpinRewriterSpecific").hide();
        }
if (mycustommainsettings.best_user == '' || mycustommainsettings.best_password == '')
{
        if(jQuery("#spin_text option:selected").val() === 'best') 
        {      
            jQuery("#bestspin").show();
        }
        else
        {
            jQuery("#bestspin").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'wordai') 
        {      
            jQuery("#wordai").show();
        }
        else
        {
            jQuery("#wordai").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'spinrewriter') 
        {      
            jQuery("#spinrewriter").show();
        }
        else
        {
            jQuery("#spinrewriter").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'spinnerchief') 
        {      
            jQuery("#spinnerchief").show();
        }
        else
        {
            jQuery("#spinnerchief").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'chimprewriter') 
        {      
            jQuery("#chimprewriter").show();
        }
        else
        {
            jQuery("#chimprewriter").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'contentprofessor') 
        {      
            jQuery("#contentprofessor").show();
        }
        else
        {
            jQuery("#contentprofessor").hide();
        }
}
else
{
if(initial == '')
{
    initial = jQuery("#spin_text option:selected").val();
}
if(initial != '' && initial != jQuery("#spin_text option:selected").val())
{
        if(jQuery("#spin_text option:selected").val() === 'best') 
        {      
            jQuery("#bestspin").show();
        }
        else
        {
            jQuery("#bestspin").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'wordai') 
        {      
            jQuery("#wordai").show();
        }
        else
        {
            jQuery("#wordai").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'spinrewriter') 
        {      
            jQuery("#spinrewriter").show();
        }
        else
        {
            jQuery("#spinrewriter").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'spinnerchief') 
        {      
            jQuery("#spinnerchief").show();
        }
        else
        {
            jQuery("#spinnerchief").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'chimprewriter') 
        {      
            jQuery("#chimprewriter").show();
        }
        else
        {
            jQuery("#chimprewriter").hide();
        }
        if(jQuery("#spin_text option:selected").val() === 'contentprofessor') 
        {      
            jQuery("#contentprofessor").show();
        }
        else
        {
            jQuery("#contentprofessor").hide();
        }
}
else
{
    jQuery("#spinrewriter").hide();
    jQuery("#spinnerchief").hide();
    jQuery("#chimprewriter").hide();
    jQuery("#contentprofessor").hide();
    jQuery("#wordai").hide();
    jQuery("#bestspin").hide();
}
}
        if(jQuery('#send_email').is(":checked"))
        {            
            jQuery(".hideMail").show();
        }
        else
        {
            jQuery(".hideMail").hide();
        }
        if(jQuery('#enable_logging').is(":checked"))
        {            
            jQuery(".hideLog").show();
        }
        else
        {
            jQuery(".hideLog").hide();
        }
        if(jQuery('#skip_old').is(":checked"))
        {            
            jQuery(".hideOld").show();
        }
        else
        {
            jQuery(".hideOld").hide();
        }
    }
    window.onload = mainChanged;
    jQuery(document).ready(function(){
        jQuery('span.wpaiomatic-delete').on('click', function(){
            var confirm_delete = confirm('Are you sure you want to delete this rule?');
            if (confirm_delete) 
            {
                var dataid = jQuery(this).attr('data-id');
                if(dataid !== undefined && dataid !== null)
                {
                    jQuery('.aiuniq-' + dataid).remove();
                }
                else
                {
                    jQuery(this).parent().parent().remove();
                }
                jQuery('#myForm').submit();					
            }
        });
        var plugin_slug = mycustomsettings.plugin_slug;
        jQuery('#' + plugin_slug + '_register').on('click', function()
        {
            var ajaxurl = mycustomsettings.ajaxurl;
            var nonce = jQuery('#' + plugin_slug + '_activation_nonce').val();
            var code = jQuery('#' + plugin_slug + '_register_code').val();
            if(code == '')
            {
                alert('You need to enter a purchase code for the activation to work.');
            }
            else
            {
                var thisbut = jQuery(this);
                aiomaticLoading(thisbut);
                var data = {
                    action: 'aiomatic_activation',
                    code: code,
                    nonce: nonce
                };
                jQuery.post(ajaxurl, data, function(response) {
                    aiomaticRmLoading(thisbut);
                    if(response.trim() == 'ok')
                    {
                        location.reload();
                    }
                    else
                    {
                        alert('Error in registration process: ' + response);
                    }
                }).fail( function(xhr) 
                {
                    aiomaticRmLoading(thisbut);
                    alert('Exception in registration process: ' + xhr.statusText);
                });
            }
        });
        jQuery('#' + plugin_slug + '_revoke_license').on('click', function()
        {
            var confirm_delete = confirm('Are you sure you want to revoke your license?');
            if (confirm_delete) 
            {
                var ajaxurl = mycustomsettings.ajaxurl;
                var nonce = jQuery('#' + plugin_slug + '_activation_nonce').val();
                var thisbut = jQuery(this);
                aiomaticLoading(thisbut);
                var data = {
                    action: 'aiomatic_revoke',
                    nonce: nonce
                };
                jQuery.post(ajaxurl, data, function(response) {
                    aiomaticRmLoading(thisbut);
                    if(response.trim() == 'ok')
                    {
                        location.reload();
                    }
                    else
                    {
                        alert('Error in revoking process: ' + response);
                    }
                }).fail( function(xhr) 
                {
                    aiomaticRmLoading(thisbut);
                    alert('Exception in revoking process: ' + xhr.statusText);
            });
            }
        });
    });
    var unsaved = false;
    jQuery(document).ready(function () {
        jQuery("#api_selector").on('change', function(){
            if(jQuery("#api_selector").val() === 'azure') 
            {      
                jQuery(".azurehide").show();
                jQuery(".openhide").hide();
                jQuery("#apilinks").html("<a href='https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' target='_blank'>Azure</a>");
            }
            else
            {
                jQuery(".azurehide").hide();
                jQuery(".openhide").show();
                jQuery("#apilinks").html("<a href='https://platform.openai.com/api-keys' target='_blank'>OpenAI</a>&nbsp;/&nbsp;<a href='https://aiomaticapi.com/api-keys/' target='_blank'>AiomaticAPI</a>");
            }
        });
        if(jQuery("#api_selector").val() === 'azure') 
        {      
            jQuery(".azurehide").show();
            jQuery(".openhide").hide();
            jQuery("#apilinks").html("<a href='https://portal.azure.com/?microsoft_azure_marketplace_ItemHideKey=microsoft_openai_tip#home' target='_blank'>Azure</a>");
        }
        else
        {
            jQuery(".azurehide").hide();
            jQuery(".openhide").show();
            jQuery("#apilinks").html("<a href='https://platform.openai.com/api-keys' target='_blank'>OpenAI</a>&nbsp;/&nbsp;<a href='https://aiomaticapi.com/api-keys/' target='_blank'>AiomaticAPI</a>");
        }
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
function revealRec(){document.getElementById("diviIdrec").innerHTML = '<br/>We recommend that you check <b><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=50837_5_1_16" target="_blank">Divi theme</a></b>, by <b><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=50837_1_1_3" target="_blank">ElegantThemes</a></b>! It is easy to configure and it looks gorgeous. Check it out now!<br/><br/><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=50837_5_1_19" target="_blank" rel="nofollow"><img style="border:0px" src="https://3.bp.blogspot.com/-h9TLQozNO6Q/W92Sk80zwjI/AAAAAAAAAjg/JC8sFWAUPzseR4nnjhVNbRQmCnr1ZMu4gCLcBGAs/s1600/divi.jpg" width="468" height="60" alt="Divi WordPress Theme"></a>';}