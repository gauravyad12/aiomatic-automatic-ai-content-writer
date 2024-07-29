"use strict";
function updateCSSAttribute(css_attr_name, css_attr_value, original_css_code) {
  const regex = new RegExp(`((?<!-)${css_attr_name}\\s*:\\s*[^;]+;?)`);
  const match = original_css_code.match(regex);
  var updated_css_code = original_css_code;
  if (match) {
    // If the attribute is found in the CSS code, replace its value
    updated_css_code = original_css_code.replace(regex, `${css_attr_name}: ${css_attr_value}`);
    return updated_css_code;
  } else {
    // If the attribute is not found, append a new CSS attribute to the code
    const new_css_attribute = `${css_attr_name}: ${css_attr_value}`;
    if(original_css_code == '')
    {
        updated_css_code = new_css_attribute;
    }
    else
    {
        if(original_css_code.endsWith(';'))
        {
            updated_css_code = `${original_css_code}${new_css_attribute}`;
        }
        else
        {
            updated_css_code = `${original_css_code};${new_css_attribute}`;
        }
    }
    return updated_css_code;
  }
}
function aiomatic_check_vision()
{
    var found = false;
    var selectedAssist = jQuery('#assistant_id').val();
    if (selectedAssist) 
    {
        found = true;
    }
    else
    {
        var selected = jQuery('#chat_model').val();
        aiomatic_object.modelsvision.forEach((model) => {
            if(model == selected)
            {
                found = true;
            }
        });
    }
    if(found == true)
    {
        jQuery(".hideVision").show();
    }
    else
    {
        jQuery(".hideVision").hide();
    }
}
function assistantChanged()
{
    var found = false;
    var selectedAssist = jQuery('#assistant_id').val();
    if (selectedAssist) 
    {
        found = true;
    }
    if(found == true)
    {
        jQuery(".hideAssist").show();
    }
    else
    {
        jQuery(".hideAssist").hide();
    }
}
function assistantChanged_b()
{
    var found = false;
    var selectedAssist = jQuery('#assistant_id_b').val();
    if (selectedAssist) 
    {
        found = true;
    }
    if(found == true)
    {
        jQuery(".hideAssist_b").show();
    }
    else
    {
        jQuery(".hideAssist_b").hide();
    }
}
function voiceChanged()
{
    if(jQuery("#voice_input").is(':checked'))
    {
        jQuery('.hideVoice').show();
    }
    else
    {
        jQuery('.hideVoice').hide();
    }
}
function aiomatic_check_vision_b()
{
    var selected = jQuery('#model_b').val();
    var found = false;
    var selectedAssist = jQuery('#assistant_id_b').val();
    if (selectedAssist) 
    {
        found = true;
    }
    else
    {
        aiomatic_object.modelsvision.forEach((model) => {
            if(model == selected)
            {
                found = true;
            }
        });
    }
    if(found == true)
    {
        jQuery(".hideVision_b").show();
    }
    else
    {
        jQuery(".hideVision_b").hide();
    }
}
function aiomaticDisable(btn)
{
    btn.prop('disabled', true);
}
function fontSizeChanged()
{
    var selected = jQuery('#font_size').find('option:selected').attr('value');
    var text_input = jQuery('.aiomatic_chat_history');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('font-size', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function fontSizeChanged_b()
{
    var selected = jQuery('#font_size_b').find('option:selected').attr('value');
    var text_input = jQuery('.aiomatic_chat_history');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/font_size="([^"]*?)"/g, 'font_size="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('font-size', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function widthChanged()
{
    var selected = jQuery('#width').val();
    var text_input = jQuery('.openai-ai-form');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('width', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function headerChanged()
{
    var selected = jQuery('#show_header').val();
    var text_input = jQuery('.openai-card-header');
    if(selected != undefined && text_input !== null)
    {
        if(selected == 'show')
        {
            text_input.show();
        }
        else
        {
            text_input.hide();
        }
    }
}
function themeChanged()
{
    var selected = jQuery('#chat_theme').val();
    if(selected == 'light')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#ffffff');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#f7f7f9');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#e1e3e6');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#000000');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#3c434a');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#728096');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#333333');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#0084ff');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#e0e0e0');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#000000');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'dark')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#343541');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#454654');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#454654');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#ffffff');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#ece3ea');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#b2b0b6');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#dddddd');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#343541');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#4d4d56');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#f8f8f8');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'midnight')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#000000');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#191919');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#303030');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#e0e0e0');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#c7c7c7');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#a0a0a0');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#555555');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#222222');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#333333');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#eeeeee');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'sunrise')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#FFDAA5');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#FFB67F');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#FF925B');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#8B572A');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#76351E');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#DA8540');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#A66C2F');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#FFA15C');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#FFC591');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#6F4A29');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'ocean')
    {
        var generalackground = jQuery('#general_background');
        generalackground.val('#004466');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#006699');
        backgroundChanged();
        var inputorder_color = jQuery('#input_border_color');
        inputorder_color.val('#003355');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#FFFFFF');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#E0F0FF');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#99CCFF');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#CCDDFF');
        inputplaceholdercolorChanged();
        var userackground_color = jQuery('#user_background_color');
        userackground_color.val('#0077AA');
        userbackgroundcolorChanged();
        var aiackground_color = jQuery('#ai_background_color');
        aiackground_color.val('#0099CC');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#FFFFFF');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'forest')
    {
        var generalackground = jQuery('#general_background');
        generalackground.val('#225533');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#448866');
        backgroundChanged();
        var inputorder_color = jQuery('#input_border_color');
        inputorder_color.val('#003322');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#E0FFE0');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#CCFFCC');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#99FF99');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#AADDA0');
        inputplaceholdercolorChanged();
        var userackground_color = jQuery('#user_background_color');
        userackground_color.val('#22AA55');
        userbackgroundcolorChanged();
        var aiackground_color = jQuery('#ai_background_color');
        aiackground_color.val('#66CC88');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#002400');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'winter')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#DDEEF9');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#BBD0E7');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#99B4D1');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#223344');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#445566');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#667788');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#8899AA');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#99aec7');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#CCD8E9');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#001122');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'twilight')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#483D8B');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#6A5ACD');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#312A63');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#E0E0FF');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#B0B0E0');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#8A89C7');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#A0A0D0');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#7F7FCC');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#9393D3');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#FAFAFF');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'desert')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#FDEBC6');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#EFC97D');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#D9A75C');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#6B4D35');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#8C7048');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#A48662');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#B5967E');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#E5B769');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#EFD39C');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#6B4D35');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'cosmic')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#2E294E');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#453A6B');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#1B1638');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#CFC7E2');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#A09ABC');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#776888');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#8C80A9');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#5F528A');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#6C5FA5');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#EDE6F4');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'rose')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#FFEBF1');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#FFCCE5');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#FF99CC');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#662244');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#993366');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#CC6699');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#884466');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#FF66AA');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#FFB3D9');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#442233');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'tropical')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#A1FFDE');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#85FFC7');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#5CDCA4');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#26734D');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#2E8B57');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#479077');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#40A080');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#3DB58B');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#8EEAD5');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#004C30');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }    
    else if(selected == 'facebook')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#1877F2');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#E4E6EB');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#B0B3B8');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#000000');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#1877F2');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#B0B3B8');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#8A8D91');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#1877F2');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#E9ECEF');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#000000');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'twitter')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#15202B');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#1B2936');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#38444D');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#E1E8ED');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#1DA1F2');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#657786');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#657786');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#1DA1F2');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#243447');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#DDE4E8');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'instagram')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#F9F9F9');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#FFFFFF');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#DBDBDB');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#262626');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#C13584');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#8A3AB9');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#8E8E8E');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#C13584');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#EFEFEF');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#262626');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected == 'whatsapp')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#ECE5DD');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#FFFFFF');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#D0D0D0');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#4C4C4C');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#075E54');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#8A8A8A');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#979797');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#DCF8C6');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#F1F1F1');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#4C4C4C');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#121212');
        userfontcolorChanged();
    }
    else if(selected == 'linkedin')
    {
        var general_background = jQuery('#general_background');
        general_background.val('#F3F6F8');
        backgroundChanged2();
        var background = jQuery('#background');
        background.val('#FFFFFF');
        backgroundChanged();
        var input_border_color = jQuery('#input_border_color');
        input_border_color.val('#CED0D4');
        bordercolorChanged();
        var input_text_color = jQuery('#input_text_color');
        input_text_color.val('#2A2A2A');
        inputtextcolorChanged();
        var persona_name_color = jQuery('#persona_name_color');
        persona_name_color.val('#0077B5');
        personanamecolorChanged();
        var persona_role_color = jQuery('#persona_role_color');
        persona_role_color.val('#6B6B6B');
        personarolecolorChanged();
        var input_placeholder_color = jQuery('#input_placeholder_color');
        input_placeholder_color.val('#8A8A8A');
        inputplaceholdercolorChanged();
        var user_background_color = jQuery('#user_background_color');
        user_background_color.val('#0077B5');
        userbackgroundcolorChanged();
        var ai_background_color = jQuery('#ai_background_color');
        ai_background_color.val('#E8E8E8');
        aibackgroundcolorChanged();
        var ai_font_color = jQuery('#ai_font_color');
        ai_font_color.val('#2A2A2A');
        aifontcolorChanged();
        var user_font_color = jQuery('#user_font_color');
        user_font_color.val('#ffffff');
        userfontcolorChanged();
    }
    else if(selected != '')
    {
        var data = {
            action: 'aiomatic_get_theme',
            themeid: selected,
            nonce: aiomatic_object.nonce,
        };
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res){
                if(res.status === 'success')
                {
                    var json_data = JSON.parse(res.msg);
                    if(json_data.general_background !== undefined)
                    {
                        var general_background = jQuery('#general_background');
                        general_background.val(json_data.general_background);
                        backgroundChanged2();
                    }
                    if(json_data.background !== undefined)
                    {
                        var background = jQuery('#background');
                        background.val(json_data.background);
                        backgroundChanged();
                    }
                    
                    if(json_data.input_border_color !== undefined)
                    {
                        var input_border_color = jQuery('#input_border_color');
                        input_border_color.val(json_data.input_border_color);
                        bordercolorChanged();
                    }
                    if(json_data.input_text_color !== undefined)
                    {
                        var input_text_color = jQuery('#input_text_color');
                        input_text_color.val(json_data.input_text_color);
                        inputtextcolorChanged();
                    }
                    if(json_data.persona_name_color !== undefined)
                    {
                        var persona_name_color = jQuery('#persona_name_color');
                        persona_name_color.val(json_data.persona_name_color);
                        personanamecolorChanged();
                    }
                    if(json_data.persona_role_color !== undefined)
                    {
                        var persona_role_color = jQuery('#persona_role_color');
                        persona_role_color.val(json_data.persona_role_color);
                        personarolecolorChanged();
                    }
                    if(json_data.input_placeholder_color !== undefined)
                    {
                        var input_placeholder_color = jQuery('#input_placeholder_color');
                        input_placeholder_color.val(json_data.input_placeholder_color);
                        inputplaceholdercolorChanged();
                    }
                    if(json_data.user_background_color !== undefined)
                    {
                        var user_background_color = jQuery('#user_background_color');
                        user_background_color.val(json_data.user_background_color);
                        userbackgroundcolorChanged();
                    }
                    if(json_data.ai_background_color !== undefined)
                    {
                        var ai_background_color = jQuery('#ai_background_color');
                        ai_background_color.val(json_data.ai_background_color);
                        aibackgroundcolorChanged();
                    }
                    if(json_data.ai_font_color !== undefined)
                    {
                        var ai_font_color = jQuery('#ai_font_color');
                        ai_font_color.val(json_data.ai_font_color);
                        aifontcolorChanged();
                    }
                    if(json_data.user_font_color !== undefined)
                    {
                        var user_font_color = jQuery('#user_font_color');
                        user_font_color.val(json_data.user_font_color);
                        userfontcolorChanged();
                    }
                    if(json_data.submit_color !== undefined)
                    {
                        var submit_color = jQuery('#submit_color');
                        submit_color.val(json_data.submit_color);
                        submitcolorChanged();
                    }
                    if(json_data.voice_color !== undefined)
                    {
                        var voice_color = jQuery('#voice_color');
                        voice_color.val(json_data.voice_color);
                        voicecolorChanged();
                    }
                    if(json_data.voice_color_activated !== undefined)
                    {
                        var voice_color_activated = jQuery('#voice_color_activated');
                        voice_color_activated.val(json_data.voice_color_activated);
                    }
                    if(json_data.submit_text_color !== undefined)
                    {
                        var submit_text_color = jQuery('#submit_text_color');
                        submit_text_color.val(json_data.submit_text_color);
                        submittextcolorChanged();
                    }
                }
                else
                {
                    alert(res.msg);
                }
            },
            error: function (r, s, error)
            {
                alert('Error in ElevenLabs sync: ' + error);
            }
        });
    }
}
function themeChanged_b()
{
    var selected = jQuery('#chat_theme_b').val();
    if(selected == 'light')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#ffffff');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#f7f7f9');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#e1e3e6');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#000000');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#3c434a');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#728096');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#333333');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#0084ff');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#e0e0e0');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#000000');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'dark')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#343541');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#454654');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#454654');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#ffffff');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#ece3ea');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#b2b0b6');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#dddddd');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#343541');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#4d4d56');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#f8f8f8');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'midnight')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#000000');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#191919');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#303030');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#e0e0e0');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#c7c7c7');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#a0a0a0');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#555555');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#222222');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#333333');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#eeeeee');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'sunrise')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#FFDAA5');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#FFB67F');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#FF925B');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#8B572A');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#76351E');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#DA8540');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#A66C2F');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#FFA15C');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#FFC591');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#6F4A29');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'ocean')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#004466');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#006699');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#003355');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#FFFFFF');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#E0F0FF');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#99CCFF');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#CCDDFF');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#0077AA');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#0099CC');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#FFFFFF');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'forest')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#225533');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#448866');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#003322');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#E0FFE0');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#CCFFCC');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#99FF99');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#AADDA0');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#22AA55');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#66CC88');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#002400');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'winter')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#DDEEF9');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#BBD0E7');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#99B4D1');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#223344');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#445566');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#667788');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#8899AA');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#99aec7');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#CCD8E9');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#001122');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'twilight')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#483D8B');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#6A5ACD');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#312A63');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#E0E0FF');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#B0B0E0');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#8A89C7');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#A0A0D0');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#7F7FCC');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#9393D3');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#FAFAFF');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'desert')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#FDEBC6');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#EFC97D');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#D9A75C');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#6B4D35');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#8C7048');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#A48662');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#B5967E');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#E5B769');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#EFD39C');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#6B4D35');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'cosmic')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#2E294E');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#453A6B');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#1B1638');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#CFC7E2');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#A09ABC');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#776888');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#8C80A9');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#5F528A');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#6C5FA5');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#EDE6F4');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'rose')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#FFEBF1');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#FFCCE5');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#FF99CC');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#662244');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#993366');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#CC6699');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#884466');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#FF66AA');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#FFB3D9');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#442233');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'tropical')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#A1FFDE');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#85FFC7');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#5CDCA4');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#26734D');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#2E8B57');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#479077');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#40A080');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#3DB58B');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#8EEAD5');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#004C30');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'facebook')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#1877F2');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#E4E6EB');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#B0B3B8');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#000000');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#1877F2');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#B0B3B8');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#8A8D91');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#1877F2');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#E9ECEF');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#000000');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'twitter')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#15202B');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#1B2936');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#38444D');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#E1E8ED');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#1DA1F2');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#657786');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#657786');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#1DA1F2');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#243447');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#DDE4E8');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'instagram')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#F9F9F9');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#FFFFFF');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#DBDBDB');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#262626');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#C13584');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#8A3AB9');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#8E8E8E');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#C13584');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#EFEFEF');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#262626');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected == 'whatsapp')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#ECE5DD');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#FFFFFF');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#D0D0D0');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#4C4C4C');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#075E54');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#8A8A8A');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#979797');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#DCF8C6');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#F1F1F1');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#4C4C4C');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#121212');
        userfontcolorChanged_b();
    }
    else if(selected == 'linkedin')
    {
        var general_background = jQuery('#general_background_b');
        general_background.val('#F3F6F8');
        backgroundChanged2_b();
        var background = jQuery('#background_b');
        background.val('#FFFFFF');
        backgroundChanged_b();
        var input_border_color = jQuery('#input_border_color_b');
        input_border_color.val('#CED0D4');
        bordercolorChanged_b();
        var input_text_color = jQuery('#input_text_color_b');
        input_text_color.val('#2A2A2A');
        inputtextcolorChanged_b();
        var persona_name_color = jQuery('#persona_name_color_b');
        persona_name_color.val('#0077B5');
        personanamecolorChanged_b();
        var persona_role_color = jQuery('#persona_role_color_b');
        persona_role_color.val('#6B6B6B');
        personarolecolorChanged_b();
        var input_placeholder_color = jQuery('#input_placeholder_color_b');
        input_placeholder_color.val('#8A8A8A');
        inputplaceholdercolorChanged_b();
        var user_background_color = jQuery('#user_background_color_b');
        user_background_color.val('#0077B5');
        userbackgroundcolorChanged_b();
        var ai_background_color = jQuery('#ai_background_color_b');
        ai_background_color.val('#E8E8E8');
        aibackgroundcolorChanged_b();
        var ai_font_color = jQuery('#ai_font_color_b');
        ai_font_color.val('#2A2A2A');
        aifontcolorChanged_b();
        var user_font_color = jQuery('#user_font_color_b');
        user_font_color.val('#ffffff');
        userfontcolorChanged_b();
    }
    else if(selected != '')
    {
        var data = {
            action: 'aiomatic_get_theme',
            themeid: selected,
            nonce: aiomatic_object.nonce,
        };
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res){
                if(res.status === 'success')
                {
                    var json_data = JSON.parse(res.msg);
                    if(json_data.general_background !== undefined)
                    {
                        var general_background = jQuery('#general_background_b');
                        general_background.val(json_data.general_background);
                        backgroundChanged2_b();
                    }
                    if(json_data.background !== undefined)
                    {
                        var background = jQuery('#background_b');
                        background.val(json_data.background);
                        backgroundChanged_b();
                    }
                    
                    if(json_data.input_border_color !== undefined)
                    {
                        var input_border_color = jQuery('#input_border_color_b');
                        input_border_color.val(json_data.input_border_color);
                        bordercolorChanged_b();
                    }
                    if(json_data.input_text_color !== undefined)
                    {
                        var input_text_color = jQuery('#input_text_color_b');
                        input_text_color.val(json_data.input_text_color);
                        inputtextcolorChanged_b();
                    }
                    if(json_data.persona_name_color !== undefined)
                    {
                        var persona_name_color = jQuery('#persona_name_color_b');
                        persona_name_color.val(json_data.persona_name_color);
                        personanamecolorChanged_b();
                    }
                    if(json_data.persona_role_color !== undefined)
                    {
                        var persona_role_color = jQuery('#persona_role_color_b');
                        persona_role_color.val(json_data.persona_role_color);
                        personarolecolorChanged_b();
                    }
                    if(json_data.input_placeholder_color !== undefined)
                    {
                        var input_placeholder_color = jQuery('#input_placeholder_color_b');
                        input_placeholder_color.val(json_data.input_placeholder_color);
                        inputplaceholdercolorChanged_b();
                    }
                    if(json_data.user_background_color !== undefined)
                    {
                        var user_background_color = jQuery('#user_background_color_b');
                        user_background_color.val(json_data.user_background_color);
                        userbackgroundcolorChanged_b();
                    }
                    if(json_data.ai_background_color !== undefined)
                    {
                        var ai_background_color = jQuery('#ai_background_color_b');
                        ai_background_color.val(json_data.ai_background_color);
                        aibackgroundcolorChanged_b();
                    }
                    if(json_data.ai_font_color !== undefined)
                    {
                        var ai_font_color = jQuery('#ai_font_color_b');
                        ai_font_color.val(json_data.ai_font_color);
                        aifontcolorChanged_b();
                    }
                    if(json_data.user_font_color !== undefined)
                    {
                        var user_font_color = jQuery('#user_font_color_b');
                        user_font_color.val(json_data.user_font_color);
                        userfontcolorChanged_b();
                    }
                    if(json_data.submit_color !== undefined)
                    {
                        var submit_color = jQuery('#submit_color_b');
                        submit_color.val(json_data.submit_color);
                        submitcolorChanged_b();
                    }
                    if(json_data.voice_color !== undefined)
                    {
                        var voice_color = jQuery('#voice_color_b');
                        voice_color.val(json_data.voice_color);
                        voicecolorChanged_b();
                    }
                    if(json_data.voice_color_activated !== undefined)
                    {
                        var voice_color_activated = jQuery('#voice_color_activated_b');
                        voice_color_activated.val(json_data.voice_color_activated);
                        voicecolorActivatedChanged_b();
                    }
                    if(json_data.submit_text_color !== undefined)
                    {
                        var submit_text_color = jQuery('#submit_text_color_b');
                        submit_text_color.val(json_data.submit_text_color);
                        submittextcolorChanged_b();
                    }
                }
                else
                {
                    alert(res.msg);
                }
            },
            error: function (r, s, error)
            {
                alert('Error in ElevenLabs sync: ' + error);
            }
        });
    }
}
function txtbutChanged()
{
    var selected = jQuery('#show_dltxt').val();
    var text_input = jQuery('.ai-export-txt');
    if(selected != undefined && text_input !== null)
    {
        if(selected == 'show')
        {
            text_input.show();
        }
        else
        {
            text_input.hide();
        }
    }
}
function mutebutChanged()
{
    var selected = jQuery('#show_mute').val();
    var text_input = jQuery('.aiomatic-gg-mute');
    if(selected != undefined && text_input !== null)
    {
        if(selected == 'show')
        {
            text_input.show();
        }
        else
        {
            text_input.hide();
        }
    }
    var text_input = jQuery('.aiomatic-gg-unmute');
    if(selected != undefined && text_input !== null)
    {
        if(selected == 'show')
        {
            text_input.show();
        }
        else
        {
            text_input.hide();
        }
    }
}
function internetChanged()
{
    var selected = jQuery('#show_internet').val();
    var text_input = jQuery('.aiomatic-gg-globalist');
    if(selected != undefined && text_input !== null)
    {
        if(selected == 'show')
        {
            text_input.show();
        }
        else
        {
            text_input.hide();
        }
    }
}
function clearbutChanged()
{
    var selected = jQuery('#show_clear').val();
    var text_input = jQuery('.ai-clear-chat');
    if(selected != undefined && text_input !== null)
    {
        if(selected == 'show')
        {
            text_input.show();
        }
        else
        {
            text_input.hide();
        }
    }
}
function widthChanged_b()
{
    var selected = jQuery('#width_b').val();
    var text_input = jQuery('.openai-ai-form');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/width="([^"]*?)"/g, 'width="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('width', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function heightChanged()
{
    var selected = jQuery('#height').val();
    var text_input = jQuery('.aiomatic_chat_history');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('height', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function heightChanged_b()
{
    var selected = jQuery('#height_b').val();
    var text_input = jQuery('.aiomatic_chat_history');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ height="([^"]*?)"/g, ' height="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('height', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function minheightChanged()
{
    var selected = jQuery('#minheight').val();
    var text_input = jQuery('.aiomatic_chat_history');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('min-height', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function minheightChanged_b()
{
    var selected = jQuery('#minheight_b').val();
    var text_input = jQuery('.aiomatic_chat_history');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/minheight="([^"]*?)"/g, 'minheight="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('min-height', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function backgroundChanged2()
{
    var selected = jQuery('#general_background').val();
    var text_input = jQuery('.openai-ai-form');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function backgroundChanged()
{
    var selected = jQuery('#background').val();
    var text_input = jQuery('.aiomatic_chat_history');
    var text_input2 = jQuery('.chat-form-control');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
        var origCSS2 = text_input2.attr("style");
        if(origCSS2 === undefined)
        {
            origCSS2 = "";
        }
        var updatedCSS2 = updateCSSAttribute('background-color', selected + '!important;', origCSS2);
        text_input2.attr('style', updatedCSS2);
    }
}
function backgroundChanged2_b()
{
    var selected = jQuery('#general_background_b').val();
    var text_input = jQuery('.openai-ai-form');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/general_background="([^"]*?)"/g, 'general_background="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function backgroundChanged_b()
{
    var selected = jQuery('#background_b').val();
    var text_input = jQuery('.aiomatic_chat_history');
    var text_input2 = jQuery('.chat-form-control');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/background="([^"]*?)"/g, 'background="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
        var origCSS2 = text_input2.attr("style");
        if(origCSS2 === undefined)
        {
            origCSS2 = "";
        }
        var updatedCSS2 = updateCSSAttribute('background-color', selected + '!important;', origCSS2);
        text_input2.attr('style', updatedCSS2);
    }
}
function userfontcolorChanged()
{
    var selected = jQuery('#user_font_color').val();
    var text_input = jQuery('.ai-mine');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function userfontcolorChanged_b()
{
    var selected = jQuery('#user_font_color_b').val();
    var text_input = jQuery('.ai-mine');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/user_font_color="([^"]*?)"/g, 'user_font_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function userbackgroundcolorChanged()
{
    var selected = jQuery('#user_background_color').val();
    var text_input = jQuery('.ai-mine');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function userbackgroundcolorChanged_b()
{
    var selected = jQuery('#user_background_color_b').val();
    var text_input = jQuery('.ai-mine');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/user_background_color="([^"]*?)"/g, 'user_background_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function aifontcolorChanged()
{
    var selected = jQuery('#ai_font_color').val();
    var text_input = jQuery('.ai-other');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function aifontcolorChanged_b()
{
    var selected = jQuery('#ai_font_color_b').val();
    var text_input = jQuery('.ai-other');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ai_font_color="([^"]*?)"/g, 'ai_font_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function aibackgroundcolorChanged()
{
    var selected = jQuery('#ai_background_color').val();
    var text_input = jQuery('.ai-other');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function aibackgroundcolorChanged_b()
{
    var selected = jQuery('#ai_background_color_b').val();
    var text_input = jQuery('.ai-other');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ai_background_color="([^"]*?)"/g, 'ai_background_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function bordercolorChanged()
{
    var selected = jQuery('#input_border_color').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('border-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function inputtextcolorChanged()
{
    var selected = jQuery('#input_text_color').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function personanamecolorChanged()
{
    var selected = jQuery('#persona_name_color').val();
    var text_input = jQuery('.openai-persona-name');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function personarolecolorChanged()
{
    var selected = jQuery('#persona_role_color').val();
    var text_input = jQuery('.openai-persona-role');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function inputplaceholdercolorChanged()
{
    var selected = jQuery('#input_placeholder_color').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        jQuery('body').append('<style>.aiomatic_chat_input::placeholder{color:' + selected + '!important;}</style>');
    }
}
function inputtextcolorChanged_b()
{
    var selected = jQuery('#input_text_color_b').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/input_text_color="([^"]*?)"/g, 'input_text_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function personanamecolorChanged_b()
{
    var selected = jQuery('#persona_name_color_b').val();
    var text_input = jQuery('.openai-persona-name');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/persona_name_color="([^"]*?)"/g, 'persona_name_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function personarolecolorChanged_b()
{
    var selected = jQuery('#persona_role_color_b').val();
    var text_input = jQuery('.openai-persona-role');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/persona_role_color="([^"]*?)"/g, 'persona_role_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function inputplaceholdercolorChanged_b()
{
    var selected = jQuery('#input_placeholder_color_b').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/input_placeholder_color="([^"]*?)"/g, 'input_placeholder_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        jQuery('body').append('<style>.aiomatic_chat_input::placeholder{color:' + selected + '!important;}</style>');
    }
}
function bordercolorChanged_b()
{
    var selected = jQuery('#input_border_color_b').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/input_border_color="([^"]*?)"/g, 'input_border_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('border-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function placeholderChanged_b()
{
    var selected = jQuery('#placeholder_b').val();
    var text_input = jQuery('.aiomatic_chat_input');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/placeholder="([^"]*?)"/g, 'placeholder="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        text_input.attr("placeholder", selected);
    }
}
function modelChanged_b()
{
    var selected = jQuery('#model_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/model="([^"]*?)"/g, 'model="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
    aiomatic_check_vision_b();
}
function temperatureChanged_b()
{
    var selected = jQuery('#temperature_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/temperature="([^"]*?)"/g, 'temperature="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function toppChanged_b()
{
    var selected = jQuery('#top_p_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/top_p="([^"]*?)"/g, 'top_p="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function presenceChanged_b()
{
    var selected = jQuery('#presence_penalty_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/presence_penalty="([^"]*?)"/g, 'presence_penalty="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function frequencyChanged_b()
{
    var selected = jQuery('#frequency_penalty_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/frequency_penalty="([^"]*?)"/g, 'frequency_penalty="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function contextChanged_b()
{
    var selected = jQuery('#context_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/chat_preppend_text="([^"]*?)"/g, 'chat_preppend_text="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function userChanged_b()
{
    var selected = jQuery('#user_name_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/user_message_preppend="([^"]*?)"/g, 'user_message_preppend="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function aiChanged_b()
{
    var selected = jQuery('#ai_name_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ai_message_preppend="([^"]*?)"/g, 'ai_message_preppend="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function voiceOverwriteChanged_b()
{
    var selected = jQuery('#chatbot_voice_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/overwrite_voice="([^"]*?)"/g, 'overwrite_voice="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function imageAvatarOverwriteChanged_b()
{
    var selected = jQuery('#chatbot_video_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/overwrite_avatar_image="([^"]*?)"/g, 'overwrite_avatar_image="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function aiRole_b()
{
    var selected = jQuery('#ai_role_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ai_role="([^"]*?)"/g, 'ai_role="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function messageChanged_b()
{
    var selected = jQuery('#ai_message_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ai_first_message="([^"]*?)"/g, 'ai_first_message="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function internetChanged_b()
{
    var selected = jQuery('#no_internet_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/internet_access="([^"]*?)"/g, 'internet_access="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function internetAccessChanged_b()
{
    var selected = jQuery('#show_internet_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_internet="([^"]*?)"/g, 'show_internet="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function embeddingsChanged_b()
{
    var selected = jQuery('#no_embeddings_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/embeddings="([^"]*?)"/g, 'embeddings="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function instantChanged_b()
{
    var selected = jQuery('#instant_response_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/instant_response="([^"]*?)"/g, 'instant_response="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function modeChanged_b()
{
    var selected = jQuery('#chat_mode_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/chat_mode="([^"]*?)"/g, 'chat_mode="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function headerChanged_b()
{
    var selected = jQuery('#show_header_b').val();
    var header_me = jQuery('.openai-card-header');
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_header="([^"]*?)"/g, 'show_header="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        if(selected == 'show')
        {
            header_me.show();
        }
        else
        {
            header_me.hide();
        }
    }
}
function speechChanged_b()
{
    var selected = jQuery('#chatbot_text_speech_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/chatbot_text_speech="([^"]*?)"/g, 'chatbot_text_speech="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function uploadPdfChanged_b()
{
    var selected = jQuery('#upload_pdf_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/upload_pdf="([^"]*?)"/g, 'upload_pdf="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function godModeChanged_b()
{
    var selected = jQuery('#enable_god_mode_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/enable_god_mode="([^"]*?)"/g, 'enable_god_mode="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function txtChanged_b()
{
    var selected = jQuery('#show_dltxt_b').val();
    var export_txt = jQuery('.ai-export-txt');
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_dltxt="([^"]*?)"/g, 'show_dltxt="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        if(selected == 'show')
        {
            export_txt.show();
        }
        else
        {
            export_txt.hide();
        }
    }
}
function muteChanged_b()
{
    var selected = jQuery('#show_mute_b').val();
    var export_txt = jQuery('.aiomatic-gg-mute');
    if(selected != undefined && export_txt != undefined && export_txt != null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_mute="([^"]*?)"/g, 'show_mute="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        if(selected == 'show')
        {
            export_txt.show();
        }
        else
        {
            export_txt.hide();
        }
    }
    var export_txt = jQuery('.aiomatic-gg-unmute');
    if(selected != undefined && export_txt != undefined && export_txt != null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_mute="([^"]*?)"/g, 'show_mute="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        if(selected == 'show')
        {
            export_txt.show();
        }
        else
        {
            export_txt.hide();
        }
    }
}
function clearChanged_b()
{
    var selected = jQuery('#show_clear_b').val();
    var export_txt = jQuery('.ai-clear-chat');
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_clear="([^"]*?)"/g, 'show_clear="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        if(selected == 'show')
        {
            export_txt.show();
        }
        else
        {
            export_txt.hide();
        }
    }
}
function assistantID_b()
{
    var selected = jQuery('#assistant_id_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/assistant_id="([^"]*?)"/g, 'assistant_id="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        if(selected != '' && selected != null)
        {
            jQuery('.hideAssistantID').attr('disabled','disabled');
        }
        else
        {
            jQuery('.hideAssistantID').removeAttr('disabled');
        }
    }
}
function selectPromptChanged_b()
{
    var selected = jQuery('#select_prompt_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/select_prompt="([^"]*?)"/g, 'select_prompt="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function customFooterChanged_b()
{
    var selected = aiomaticGetEditorContent('custom_footer_b');
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/custom_footer="([^"]*?)"/g, 'custom_footer="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function customCSSChanged_b()
{
    var selected = aiomaticGetEditorContent('custom_css_b');
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/custom_css="([^"]*?)"/g, 'custom_css="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function sendSoundChanged_b()
{
    var selected = jQuery('#send_message_sound_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/send_message_sound="([^"]*?)"/g, 'send_message_sound="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function receiveSoundChanged_b()
{
    var selected = jQuery('#receive_message_sound_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/receive_message_sound="([^"]*?)"/g, 'receive_message_sound="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function responseDelayChanged_b()
{
    var selected = jQuery('#response_delay_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/response_delay="([^"]*?)"/g, 'response_delay="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function customHeaderChanged_b()
{
    var selected = aiomaticGetEditorContent('custom_header_b');
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/custom_header="([^"]*?)"/g, 'custom_header="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function persistentChanged_b()
{
    var selected = jQuery('#persistent_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/persistent="([^"]*?)"/g, 'persistent="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function fileUploadChanged_b()
{
    var selected = jQuery('#enable_file_uploads_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/file_uploads="([^"]*?)"/g, 'file_uploads="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function visionChanged_b()
{
    var selected = jQuery('#enable_vision_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/enable_vision="([^"]*?)"/g, 'enable_vision="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function imageChanged_b()
{
    var selected = jQuery('#aiomatic_image_id_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/ai_avatar="([^"]*?)"/g, 'ai_avatar="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function templateChanged_b()
{
    var selected = jQuery('#template_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/prompt_templates="([^"]*?)"/g, 'prompt_templates="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function editableChanged_b()
{
    var selected = jQuery('#prompt_editable_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/prompt_editable="([^"]*?)"/g, 'prompt_editable="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function frontChanged_b()
{
    var selected = jQuery('#enable_front_end_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/show_in_window="([^"]*?)"/g, 'show_in_window="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function locationChanged_b()
{
    var selected = jQuery('#window_location_b').val();
    if(selected != undefined)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/window_location="([^"]*?)"/g, 'window_location="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function submitChanged_b()
{
    var selected = jQuery('#submit_b').val();
    var text_input = jQuery('.aichatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        if(selected == '')
        {
            selected = 'Submit';
        }
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/submit="([^"]*?)"/g, 'submit="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        text_input.prop('value', selected);
        text_input.text(selected);
    }
}
function complianceChanged_b()
{
    var selected = jQuery('#compliance_b').val();
    var text_input = jQuery('.compliance-text-ai');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/compliance="([^"]*?)"/g, 'compliance="' + selected.replace('"', "'") + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        text_input.html(selected);
    }
}
function submitcolorChanged()
{
    var selected = jQuery('#submit_color').val();
    var text_input = jQuery('.aichatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
    var text_input = jQuery('#aiimagechatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function submitcolorChanged_b()
{
    var selected = jQuery('#submit_color_b').val();
    var text_input = jQuery('.aichatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/submit_color="([^"]*?)"/g, 'submit_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
    var text_input = jQuery('#aiimagechatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function voicecolorChanged()
{
    var selected = jQuery('#voice_color').val();
    var text_input = jQuery('.openai-chat-speech-button');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
    var text_input = jQuery('#openai-image-speech-button');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function voicecolorChanged_b()
{
    var selected = jQuery('#voice_color_b').val();
    var text_input = jQuery('.openai-chat-speech-button');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/voice_color="([^"]*?)"/g, 'voice_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
    var text_input = jQuery('#openai-image-speech-button');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('background-color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function voicecolorActivatedChanged_b()
{
    var selected = jQuery('#voice_color_activated_b').val();
    var text_input = jQuery('.openai-chat-speech-button');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/voice_color_activated="([^"]*?)"/g, 'voice_color_activated="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
    }
}
function submittextcolorChanged()
{
    var selected = jQuery('#submit_text_color').val();
    var text_input = jQuery('.aichatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
    var text_input = jQuery('#aiimagechatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function submittextcolorChanged_b()
{
    var selected = jQuery('#submit_text_color_b').val();
    var text_input = jQuery('.aichatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        selected = selected.replace(/"/g, "'");
        var customized_chatbot = jQuery('#customized_chatbot').text();
        if(customized_chatbot !== undefined)
        {
            customized_chatbot = customized_chatbot.replace(/submit_text_color="([^"]*?)"/g, 'submit_text_color="' + selected + '"');
            jQuery('#customized_chatbot').text(customized_chatbot);
        }
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
    var text_input = jQuery('#aiimagechatsubmitbut');
    if(selected != undefined && text_input !== null)
    {
        var origCSS = text_input.attr("style");
        if(origCSS === undefined)
        {
            origCSS = "";
        }
        var updatedCSS = updateCSSAttribute('color', selected + '!important;', origCSS);
        text_input.attr('style', updatedCSS);
    }
}
function aiomaticLoading2(btn){
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
function aiomatic_sync_voices_elevenlabs()
{
    var data = {
        action: 'aiomatic_get_elevenlabs_voices',
        nonce: aiomatic_object.nonce
    };
    var elevenlabs_sync = jQuery('#elevenlabs_sync');
    jQuery.ajax({
        url: aiomatic_object.ajax_url,
        data: data,
        dataType: 'JSON',
        type: 'POST',
        beforeSend: function (){
            aiomaticLoading2(elevenlabs_sync);
        },
        success: function (res){
            if(res.status === 'success'){
                alert('ElevenLabs Voices synced successfully.');
                window.location.reload();
            }
            else{
                alert(res.msg);
                aiomaticRmLoading(elevenlabs_sync);
            }
        },
        error: function (r, s, error){
            alert('Error in ElevenLabs sync: ' + error);
            aiomaticRmLoading(elevenlabs_sync);
        }
    });
}
function aiomatic_sync_voices_google()
{
    var data = {
        action: 'aiomatic_get_google_voices',
        nonce: aiomatic_object.nonce
    };
    var google_sync = jQuery('#google_sync');
    jQuery.ajax({
        url: aiomatic_object.ajax_url,
        data: data,
        dataType: 'JSON',
        type: 'POST',
        beforeSend: function (){
            aiomaticLoading2(google_sync);
        },
        success: function (res){
            if(res.status === 'success'){
                alert('Google Text-to-Speech Voices synced successfully.');
                window.location.reload();
            }
            else{
                alert(res.msg);
                aiomaticRmLoading(google_sync);
            }
        },
        error: function (r, s, error){
            alert('Error in Google Text-to-Speech sync: ' + error);
            aiomaticRmLoading(google_sync);
        }
    });
}
function aiomatic_select_persona(personaid)
{
    var data = {
        action: 'aiomatic_get_persona',
        nonce: aiomatic_object.nonce,
        ids: personaid
    };
    jQuery.ajax({
        url: aiomatic_object.ajax_url,
        data: data,
        dataType: 'JSON',
        type: 'POST',
        success: function (res)
        {
            if(res.status === 'success')
            {
                const jsobj = JSON.parse(res.msg);
                jQuery("textarea#ai_name").val(jsobj.post_title);
                jQuery("textarea#ai_role").val(jsobj.post_excerpt);
                jQuery("textarea#preppend_text").val(jsobj.post_content);
                jQuery("#aiomatic_image_id").val(jsobj.avatarid);
                jQuery("textarea#first_message_ai").val(jsobj.message);
                if(jsobj.avatar != '')
                {
                    jQuery("#aiomatic-preview-image").attr("src", jsobj.avatar);
                }
                else
                {
                    jQuery("#aiomatic-preview-image").removeAttr("src");
                }
                alert('Persona details set in settings, please save settings to apply them!');
                window.scrollTo(0, 0);
            }
            else
            {
                alert('Error ' + res.msg);
            }
        },
        error: function (r, s, error)
        {
            alert('Error in processing persona removal: ' + error);
        }
    });
}
function aiomatic_persistent_changed()
{
    var selected = jQuery('#persistent').val();
    if(selected == 'on' || selected == 'logs' || selected == 'vector')
    {
        jQuery(".hidePersistent").show();
    }
    else
    {
        jQuery(".hidePersistent").hide();
    }
}
function aiomatic_global_changed()
{
    var selected = jQuery('#enable_front_end').val();
    if(selected == 'off')
    {
        jQuery(".hideInject").hide();
    }
    else
    {
        jQuery(".hideInject").show();
    }
}
function instantResponseChanged()
{
    var selected = jQuery('#instant_response').val();
    if(selected == 'stream')
    {
        jQuery(".hideStreamer").show();
    }
    else
    {
        jQuery(".hideStreamer").hide();
    }
}
function aiomatic_text_changed()
{
    var selected = jQuery('#chatbot_text_speech').val();
    if(selected == 'google')
    {
        jQuery(".hideeleven").hide();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidedidstream").hide();
        jQuery(".hidegoogle").show();
        jQuery(".hidefree").hide();
    }
    if(selected == 'elevenlabs')
    {
        jQuery(".hideeleven").show();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidedidstream").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hidefree").hide();
    }
    if(selected == 'did' || selected == 'didstream')
    {
        if(selected == 'didstream')
        {
            jQuery(".hidedidstream").show();
        }
        else
        {
            jQuery(".hidedidstream").hide();
        }
        jQuery(".hidedid").show();
        jQuery(".hideopen").hide();
        jQuery(".hideeleven").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hidefree").hide();
    }
    if(selected == 'openai')
    {
        jQuery(".hidedid").hide();
        jQuery(".hidedidstream").hide();
        jQuery(".hideopen").show();
        jQuery(".hideeleven").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hidefree").hide();
    }
    if(selected == 'free')
    {
        jQuery(".hideeleven").hide();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidedidstream").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hidefree").show();
    }
    if(selected == 'off')
    {
        jQuery(".hideeleven").hide();
        jQuery(".hideopen").hide();
        jQuery(".hidedid").hide();
        jQuery(".hidedidstream").hide();
        jQuery(".hidegoogle").hide();
        jQuery(".hidefree").hide();
    }
}
function aiomatic_chatbot_email()
{
    var selected = jQuery('#extension_email').val();
    if(selected == 'off')
    {
        jQuery(".hideemail").hide();
    }
    else
    {
        jQuery(".hideemail").show();
    }
}
function personaChanged()
{
    var personaid = jQuery('#persona_b').find('option:selected').attr('value');
    var data = {
        action: 'aiomatic_get_persona',
        nonce: aiomatic_object.nonce,
        ids: personaid
    };
    jQuery.ajax({
        url: aiomatic_object.ajax_url,
        data: data,
        dataType: 'JSON',
        type: 'POST',
        success: function (res)
        {
            if(res.status === 'success')
            {
                const jsobj = JSON.parse(res.msg);
                jQuery("textarea#ai_name_b").val(jsobj.post_title);
                jQuery("textarea#ai_role_b").val(jsobj.post_excerpt);
                jQuery("textarea#context_b").val(jsobj.post_content);
                jQuery("#aiomatic_image_id_b").val(jsobj.avatarid);
                jQuery("#ai_message_b").val(jsobj.message);
                if(jsobj.avatar != '')
                {
                    jQuery("#aiomatic-preview-image-b").attr("src", jsobj.avatar);
                }
                else
                {
                    jQuery("#aiomatic-preview-image-b").removeAttr("src");
                }
                anythingChanged();
            }
            else
            {
                alert('Error ' + res.msg);
            }
        },
        error: function (r, s, error)
        {
            alert('Error in processing persona removal: ' + error);
        }
    });
}
function extensionsChanged()
{
    if(jQuery("#god_mode_enable_dalle").is(':checked'))
    {
        jQuery('.hide_dalle').show();
    }
    else
    {
        jQuery('.hide_dalle').hide();
    }
    if(jQuery("#god_mode_enable_stable").is(':checked'))
    {
        jQuery('.hide_stable').show();
    }
    else
    {
        jQuery('.hide_stable').hide();
    }
    if(jQuery("#god_mode_enable_stable_video").is(':checked'))
    {
        jQuery('.hide_stable_video').show();
    }
    else
    {
        jQuery('.hide_stable_video').hide();
    }
    if(jQuery("#god_mode_enable_amazon_details").is(':checked') || jQuery("#god_mode_enable_amazon").is(':checked'))
    {
        jQuery('.hide_amazon').show();
    }
    else
    {
        jQuery('.hide_amazon').hide();
    }
    if(jQuery("#god_mode_enable_scraper").is(':checked'))
    {
        jQuery('.hide_scraper').show();
    }
    else
    {
        jQuery('.hide_scraper').hide();
    }
    if(jQuery("#god_mode_enable_rss").is(':checked'))
    {
        jQuery('.hide_rss').show();
    }
    else
    {
        jQuery('.hide_rss').hide();
    }
    if(jQuery("#god_mode_enable_google").is(':checked'))
    {
        jQuery('.hide_google').show();
    }
    else
    {
        jQuery('.hide_google').hide();
    }
    if(jQuery("#god_mode_enable_youtube_captions").is(':checked'))
    {
        jQuery('.hide_caption').show();
    }
    else
    {
        jQuery('.hide_caption').hide();
    }
    if(jQuery("#god_mode_enable_wp").is(':checked'))
    {
        jQuery('.hide_god').show();
    }
    else
    {
        jQuery('.hide_god').hide();
    }
    if(jQuery("#god_mode_enable_facebook_post").is(':checked'))
    {
        jQuery('.hide_facebook').show();
    }
    else
    {
        jQuery('.hide_facebook').hide();
    }
    if(jQuery("#god_mode_enable_pinterest_post").is(':checked'))
    {
        jQuery('.hide_pinterest').show();
    }
    else
    {
        jQuery('.hide_pinterest').hide();
    }
    if(jQuery("#god_mode_enable_google_post").is(':checked'))
    {
        jQuery('.hide_gmb').show();
    }
    else
    {
        jQuery('.hide_gmb').hide();
    }
    if(jQuery("#god_mode_enable_reddit_post").is(':checked'))
    {
        jQuery('.hide_reddit').show();
    }
    else
    {
        jQuery('.hide_reddit').hide();
    }
    if(jQuery("#god_mode_enable_linkedin_post").is(':checked'))
    {
        jQuery('.hide_linkedin').show();
    }
    else
    {
        jQuery('.hide_linkedin').hide();
    }
}
function aiomaticIsTinyMCEAvailable(editorId) 
{
    return typeof tinymce !== 'undefined' && tinymce.get(editorId);
}
function aiomaticGetEditorContent(editorId) 
{
    var content = '';
    if (aiomaticIsTinyMCEAvailable(editorId)) {
        content = tinymce.get(editorId).getContent();
        if(content == '')
        {
            var quicktagsInput = jQuery("#" + editorId);
            if (quicktagsInput.length) 
            {
                content = quicktagsInput.val();
            }
        }
    } 
    else 
    {
        var quicktagsInput = jQuery('#' + editorId);
        if (quicktagsInput.length) {
            content = quicktagsInput.val();
        }
    }
    return content;
}
function anythingChanged()
{
    sendSoundChanged_b();
    receiveSoundChanged_b();
    responseDelayChanged_b();
    customFooterChanged_b();
    customCSSChanged_b();
    customHeaderChanged_b();
    persistentChanged_b();
    fileUploadChanged_b();
    assistantID_b();
    selectPromptChanged_b();
    headerChanged_b();
    speechChanged_b();
    godModeChanged_b();
    uploadPdfChanged_b();
    txtChanged_b();
    muteChanged_b();
    clearChanged_b();
    imageChanged_b();
    modeChanged_b();
    internetAccessChanged_b();
    instantChanged_b();
    messageChanged_b();
    internetChanged_b();
    embeddingsChanged_b();
    aiChanged_b();
    voiceOverwriteChanged_b();
    imageAvatarOverwriteChanged_b();
    aiRole_b();
    visionChanged_b();
    userChanged_b();
    contextChanged_b();
    frequencyChanged_b();
    presenceChanged_b();
    toppChanged_b();
    temperatureChanged_b();
    modelChanged_b();
    placeholderChanged_b();
    bordercolorChanged_b();
    inputtextcolorChanged_b();
    personanamecolorChanged_b();
    personarolecolorChanged_b();
    inputplaceholdercolorChanged_b();
    aibackgroundcolorChanged_b();
    userbackgroundcolorChanged_b();
    userfontcolorChanged_b();
    backgroundChanged_b();
    backgroundChanged2_b();
    aifontcolorChanged_b();
    minheightChanged_b();
    heightChanged_b();
    widthChanged_b();
    fontSizeChanged_b();
    templateChanged_b();
    editableChanged_b();
    frontChanged_b();
    locationChanged_b();
    submitChanged_b();
    complianceChanged_b();
    submitcolorChanged_b();
    voicecolorChanged_b();
    voicecolorActivatedChanged_b();
    submittextcolorChanged_b();
}
document.addEventListener("DOMContentLoaded", function(event) 
{ 
    document.getElementById('myForm').addEventListener('submit', function(event) 
    {
        var elements = document.querySelectorAll('textarea[name^="aiomatic_Chatbot_Settings[chatbots]"], input[name^="aiomatic_Chatbot_Settings[chatbots]"], select[name^="aiomatic_Chatbot_Settings[chatbots]"]');
        elements.forEach(function(element, index) {
            if (element.tagName.toLowerCase() === 'select' && element.multiple) {
                var selectedOptions = Array.from(element.options).filter(option => option.selected);
                if (selectedOptions.length === 0) {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = element.name;
                    hiddenInput.value = "";
                    element.parentNode.appendChild(hiddenInput);
                }
            } else if (element.value.trim() === "") {
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = element.name;
                hiddenInput.value = "";
                element.parentNode.appendChild(hiddenInput);
            }
        });
    });
    var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos)
    {
        window.scrollTo(0, scrollpos);
        localStorage.removeItem("scrollpos");
    }
});
function anyNewChatChanged()
{
    var savedata = [];
    jQuery('.chatbotShortcodeImportant').each((index, element) => 
    {
        var dataid = jQuery(element).attr('data-id');
        var new_shortcode = jQuery('#' + dataid + 'shortcode').val();
        if(new_shortcode != '')
        {
            var new_rule_description = jQuery('#' + dataid + 'rule_description').val();
            var new_not_show_urls = jQuery('#' + dataid + 'not_show_urls').val();
            var new_only_show_urls = jQuery('#' + dataid + 'only_show_urls').val();
            var new_min_time = jQuery('#' + dataid + 'min_time').val();
            var new_max_time = jQuery('#' + dataid + 'max_time').val();
            var new_always_show = jQuery('#' + dataid + 'always_show').val() || [];
            var new_never_show = jQuery('#' + dataid + 'never_show').val() || [];
            var new_no_show_content_wp = jQuery('#' + dataid + 'no_show_content_wp').val() || [];
            var new_show_content_wp = jQuery('#' + dataid + 'show_content_wp').val() || [];
            var new_no_show_locales = jQuery('#' + dataid + 'no_show_locales').val() || [];
            var new_show_locales = jQuery('#' + dataid + 'show_locales').val() || [];
            var new_no_show_roles = jQuery('#' + dataid + 'no_show_roles').val() || [];
            var new_show_roles = jQuery('#' + dataid + 'show_roles').val() || [];
            var new_no_show_devices = jQuery('#' + dataid + 'no_show_devices').val() || [];
            var new_show_devices = jQuery('#' + dataid + 'show_devices').val() || [];
            var new_no_show_oses = jQuery('#' + dataid + 'no_show_oses').val() || [];
            var new_show_oses = jQuery('#' + dataid + 'show_oses').val() || [];
            var new_no_show_browsers = jQuery('#' + dataid + 'no_show_browsers').val() || [];
            var new_show_browsers = jQuery('#' + dataid + 'show_browsers').val() || [];
            var new_no_show_ips = jQuery('#' + dataid + 'no_show_ips').val();
            var new_show_ips = jQuery('#' + dataid + 'show_ips').val();
            var data = {
                shortcode: new_shortcode,
                rule_description: new_rule_description,
                not_show_urls: new_not_show_urls,
                only_show_urls: new_only_show_urls,
                min_time: new_min_time,
                max_time: new_max_time,
                always_show: new_always_show,
                never_show: new_never_show,
                no_show_content_wp: new_no_show_content_wp,
                show_content_wp: new_show_content_wp,
                no_show_locales: new_no_show_locales,
                show_locales: new_show_locales,
                no_show_roles: new_no_show_roles,
                show_roles: new_show_roles,
                no_show_devices: new_no_show_devices,
                show_devices: new_show_devices,
                no_show_oses: new_no_show_oses,
                show_oses: new_show_oses,
                no_show_browsers: new_no_show_browsers,
                show_browsers: new_show_browsers,
                no_show_ips: new_no_show_ips,
                show_ips: new_show_ips
            };
            savedata.push({ index: dataid, data: data });
        }
    });
    jQuery('#aiomatic_chat_json').val(JSON.stringify(savedata));
}
jQuery(document).ready(function()
{
    jQuery('span.wpaiomatic-delete').on('click', function(){
        var confirm_delete = confirm('Delete This Chatbot Rule?');
        if (confirm_delete) {
            var dataid = jQuery(this).attr('data-id');
            if(dataid !== undefined && dataid !== null)
            {
                jQuery('.aiuniq-' + dataid).remove();
            }
            else
            {
                jQuery(this).parent().parent().remove();
            }
            anyNewChatChanged();
            localStorage.setItem('scrollpos', window.scrollY);
            jQuery('#myForm').submit();						
        }
    });
    jQuery('#aiomatic_upload_send_sound_button').on('click', function(e) {
        e.preventDefault();
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload a Sound Effect',
            library: {
                type: ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/x-wav', 'audio/x-mpegurl', 'audio/mp4', 'audio/x-aiff', 'audio/aiff', 'audio/aac', 'audio/flac']
            },
            button: {
                text: 'Use This "Send Message" Sound Effect'
            },
            multiple: false
        });
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            jQuery('#send_message_sound').val(attachment.url);
        });
        file_frame.open();
    });
    jQuery('#aiomatic_upload_receive_sound_button').on('click', function(e) {
        e.preventDefault();
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload a Sound Effect',
            library: {
                type: ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/x-wav', 'audio/x-mpegurl', 'audio/mp4', 'audio/x-aiff', 'audio/aiff', 'audio/aac', 'audio/flac']
            },
            button: {
                text: 'Use This "Receive Message" Sound Effect'
            },
            multiple: false
        });
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            jQuery('#receive_message_sound').val(attachment.url);
        });
        file_frame.open();
    });
    jQuery('#aiomatic_upload_send_sound_button_b').on('click', function(e) {
        e.preventDefault();
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload a Sound Effect',
            library: {
                type: ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/x-wav', 'audio/x-mpegurl', 'audio/mp4', 'audio/x-aiff', 'audio/aiff', 'audio/aac', 'audio/flac']
            },
            button: {
                text: 'Use This "Send Message" Sound Effect'
            },
            multiple: false
        });
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            jQuery('#send_message_sound_b').val(attachment.url);
        });
        file_frame.open();
    });
    jQuery('#aiomatic_upload_receive_sound_button_b').on('click', function(e) {
        e.preventDefault();
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload a Sound Effect',
            library: {
                type: ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/x-wav', 'audio/x-mpegurl', 'audio/mp4', 'audio/x-aiff', 'audio/aiff', 'audio/aac', 'audio/flac']
            },
            button: {
                text: 'Use This "Receive Message" Sound Effect'
            },
            multiple: false
        });
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            jQuery('#receive_message_sound_b').val(attachment.url);
        });
        file_frame.open();
    });
    if (aiomaticIsTinyMCEAvailable('custom_header_b')) 
    {
        var editor = tinymce.get('custom_header_b');
        editor.on('change', function(e) {
            anythingChanged();
        });
        var quicktagsInput = jQuery('#custom_header_b');
        quicktagsInput.on('input', function() {
            if (quicktagsInput.val() === '') {
                jQuery('#custom_header_b_placeholder').show();
            } else {
                jQuery('#custom_header_b_placeholder').hide();
            }
            anythingChanged();
        });
    }
    if (aiomaticIsTinyMCEAvailable('custom_footer_b')) 
    {
        var editor = tinymce.get('custom_footer_b');
        editor.on('change', function(e) {
            anythingChanged();
        });
        var quicktagsInput = jQuery('#custom_footer_b');
        quicktagsInput.on('input', function() {
            if (quicktagsInput.val() === '') {
                jQuery('#custom_footer_b_placeholder').show();
            } else {
                jQuery('#custom_footer_b_placeholder').hide();
            }
            anythingChanged();
        });
    }
    if (aiomaticIsTinyMCEAvailable('custom_css_b')) 
    {
        var editor = tinymce.get('custom_css_b');
        editor.on('change', function(e) {
            anythingChanged();
        });
        var quicktagsInput = jQuery('#custom_css_b');
        quicktagsInput.on('input', function() {
            if (quicktagsInput.val() === '') {
                jQuery('#custom_css_b_placeholder').show();
            } else {
                jQuery('#custom_css_b_placeholder').hide();
            }
            anythingChanged();
        });
    }
    extensionsChanged();
    var copyButton = jQuery('#aiomaticCopyShortcodeText');
    copyButton.on('click', function (e)
    {
        e.preventDefault();
        var textToCopy = document.getElementById("customized_chatbot").innerHTML;
        if(navigator.clipboard !== undefined)
        {
            navigator.clipboard.writeText(textToCopy)
            .then(() => {
                alert('Text copied to clipboard.');
            })
            .catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
        else
        {
            console.error('Failed to copy text');
        }   
    });
    aiomatic_text_changed();
    aiomatic_chatbot_email();
    aiomatic_persistent_changed();
    aiomatic_global_changed();
    instantResponseChanged();
    aiomatic_check_vision();
    assistantChanged();
    voiceChanged();
    anythingChanged();
    jQuery('#aiomatic_sync_personas').on('click', function ()
    {
        var btn = jQuery(this);
        aiomaticLoading2(btn);
        var currentUrl = window.location.href;
        var updatedUrl = currentUrl.replace(/(\?|&)wpage=[^&]+/, '');
        window.location.href = updatedUrl;
    });
    jQuery('#aiomatic_delete_selected_personas').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete selected personas?'))
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var ids = [];
            jQuery('.aiomatic-select-persona:checked').each(function (idx, item) {
                ids.push(jQuery(item).val())
            });
            if (ids.length) {
                var data = {
                    action: 'aiomatic_delete_selected_personas',
                    nonce: aiomatic_object.nonce,
                    ids: ids
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res){
                        aiomaticRmLoading(btn);
                        if(res.status === 'success'){
                            jQuery('.aiomatic-personas-success').show();
                            jQuery('.aiomatic-personas-content').val('');
                            setTimeout(function (){
                                jQuery('.aiomatic-personas-success').hide();
                            },2000);
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing persona removal: ' + error);
                    }
                });
            } else {
                alert('No personas selected');
                aiomaticRmLoading(btn);
            }
        }
    });
    jQuery(".aiomatic_delete_persona").on('click', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to delete this persona?'))
        {
            var personaid = jQuery(this).attr("delete-id");
            if(personaid == '')
            {
                alert('Incorrect delete id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_delete_persona',
                    personaid: personaid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticDisable(jQuery('#aiomatic_delete_persona_' + personaid));
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
                        alert('Error in processing persona deletion: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    jQuery('#aiomatic_deleteall_personas').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete ALL personas?'))
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var data = {
                action: 'aiomatic_deleteall_personas',
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        jQuery('.aiomatic-personas-success').show();
                        jQuery('.aiomatic-personas-content').val('');
                        setTimeout(function (){
                            jQuery('.aiomatic-personas-success').hide();
                        },2000);
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing persona removal: ' + error);
                }
            });
        }
    });
    jQuery('#aiomatic_save_theme').on('click', function (e){
        e.preventDefault();
        let person = prompt("Please enter a theme name:", "New Theme");
        if (person == null || person == "") {
        }
        else 
        {
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var general_background = jQuery('#general_background').val();
            var background = jQuery('#background').val();
            var input_border_color = jQuery('#input_border_color').val();
            var input_text_color = jQuery('#input_text_color').val();
            var persona_name_color = jQuery('#persona_name_color').val();
            var persona_role_color = jQuery('#persona_role_color').val();
            var input_placeholder_color = jQuery('#input_placeholder_color').val();
            var user_background_color = jQuery('#user_background_color').val();
            var ai_background_color = jQuery('#ai_background_color').val();
            var ai_font_color = jQuery('#ai_font_color').val();
            var user_font_color = jQuery('#user_font_color').val();
            var submit_color = jQuery('#submit_color').val();
            var voice_color = jQuery('#voice_color').val();
            var voice_color_activated = jQuery('#voice_color_activated').val();
            var submit_text_color = jQuery('#submit_text_color').val();
            var data = {
                action: 'aiomatic_save_theme',
                post_title: person,
                general_background: general_background,
                background: background,
                input_border_color: input_border_color,
                input_text_color: input_text_color,
                persona_name_color: persona_name_color,
                persona_role_color: persona_role_color,
                input_placeholder_color: input_placeholder_color,
                user_background_color: user_background_color,
                ai_background_color: ai_background_color,
                ai_font_color: ai_font_color,
                user_font_color: user_font_color,
                nonce: aiomatic_object.nonce,
                submit_text_color: submit_text_color,
                submit_color: submit_color,
                voice_color: voice_color,
                voice_color_activated: voice_color_activated
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success')
                    {
                        alert('Theme saved successfully, refresh the page to see it!');
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing theme saving: ' + error);
                }
            });
        }
    });
    jQuery('#aiomatic_delete_theme').on('click', function (e){
        e.preventDefault();
        var themeid = jQuery('#chat_theme_delete').val();
        if(themeid == '')
        {
            alert('You need to select a theme to delete!');
        }
        else
        {
            if(confirm('Are you sure you want to delete the selected theme?'))
            {
                var btn = jQuery(this);
                aiomaticLoading2(btn);
                var data = {
                    action: 'aiomatic_delete_theme',
                    themeid: themeid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res){
                        aiomaticRmLoading(btn);
                        if(res.status === 'success'){
                            jQuery("#chat_theme_delete option[value=" + themeid + "]").remove();
                            alert('Theme deleted successfully.');
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing persona removal: ' + error);
                    }
                });
            }
        }
    });
    jQuery('#aiomatic_add_remote_chatbot').on('click', function (e){
        e.preventDefault();
        var data = {
            action: 'aiomatic_add_remote_chatbot',
            nonce: aiomatic_object.nonce,
        };
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res)
            {
                if(res.status === 'success')
                {
                    location.reload();
                }
                else{
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                alert('Error in processing remote chatbot saving: ' + error);
            }
        });
    });
    jQuery('.aiomatic_delete_remote_chatbot').on('click', function (e){
        e.preventDefault();
        var dataid = jQuery(this).attr('data-id');
        var data = {
            action: 'aiomatic_delete_remote_chatbot',
            dataid: dataid,
            nonce: aiomatic_object.nonce,
        };
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (res)
            {
                if(res.status === 'success')
                {
                    location.reload();
                }
                else{
                    alert(res.msg);
                }
            },
            error: function (r, s, error){
                alert('Error in processing remote chatbot deletion: ' + error);
            }
        });
    });
    jQuery(".aiomatic_duplicate_persona").on('click', function(e) 
    {
        e.preventDefault();
        if(confirm('Are you sure you want to duplicate this persona?'))
        {
            var personaid = jQuery(this).attr("data-id");
            if(personaid == '')
            {
                alert('Incorrect data id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_duplicate_persona',
                    personaid: personaid,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticDisable(jQuery('#aiomatic_duplicate_persona_' + personaid));
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
                        alert('Error in processing persona duplication: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    jQuery('#aiomatic_personas_form').on('submit', function (e)
    {
        e.preventDefault();
        var form = jQuery('#aiomatic_personas_form');
        var btn = form.find('#aiomatic-personas-save-button');
        var title = jQuery('#aiomatic-persona-title').val();
        var prompt = jQuery('#aiomatic-persona-prompt').val();
        if(title === '' || prompt === ''){
            alert('Please insert all required values!');
        }
        else{
            var data = form.serialize();
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading2(btn);
                },
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        jQuery('.aiomatic-personas-success').html("Persona saved successfully!");
                        jQuery('.aiomatic-personas-success').show();
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing persona saving: ' + error);
                }
            });
        }
        return false;
    });
    var aiomatic_persona_button = jQuery('#aiomatic_persona_button');
    aiomatic_persona_button.on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to load personas from file?'))
        {
            var aiomatic_persona_upload = jQuery('#aiomatic_persona_upload');
            if(jQuery("#aiomatic_overwrite").is(':checked'))
            {
                var overwrite = '1';
            }
            else
            {
                var overwrite = '0';
            }
            if(aiomatic_persona_upload[0].files.length === 0){
                alert('Please select a file!');
            }
            else{
                var aiomatic_progress = jQuery('.aiomatic_progress');
                var aiomatic_error_message = jQuery('.aiomatic-error-msg');
                var aiomatic_upload_success = jQuery('.aiomatic_upload_success');
                var aiomatic_max_file_size = aiomatic_object.maxfilesize;
                var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
                var aiomatic_persona_file = aiomatic_persona_upload[0].files[0];
                var aiomatic_persona_file_extension = aiomatic_persona_file.name.substr( (aiomatic_persona_file.name.lastIndexOf('.') +1) );
                if(aiomatic_persona_file_extension !== 'json'){
                    aiomatic_persona_upload.val('');
                    alert('This feature only accepts JSON file type!');
                }
                else if(aiomatic_persona_file.size > aiomatic_max_file_size){
                    aiomatic_persona_upload.val('');
                    alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
                }
                else{
                    var formData = new FormData();
                    formData.append('action', 'aiomatic_persona_upload');
                    formData.append('nonce', aiomatic_object.nonce);
                    formData.append('overwrite', overwrite);
                    formData.append('file', aiomatic_persona_file);
                    jQuery.ajax({
                        url: aiomatic_object.ajax_url,
                        type: 'POST',
                        dataType: 'JSON',
                        data: formData,
                        beforeSend: function (){
                            aiomatic_progress.find('span').css('width','0');
                            aiomatic_progress.show();
                            aiomaticLoading2(aiomatic_persona_button);
                            aiomatic_error_message.hide();
                            aiomatic_upload_success.hide();
                        },
                        xhr: function() {
                            var xhr = jQuery.ajaxSettings.xhr();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    aiomatic_progress.find('span').css('width',(Math.round(percentComplete * 100))+'%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(res) {
                            if(res.status === 'success'){
                                aiomaticRmLoading(aiomatic_persona_button);
                                aiomatic_progress.hide();
                                aiomatic_persona_upload.val('');
                                aiomatic_upload_success.show();
                                location.reload();
                            }
                            else{
                                aiomaticRmLoading(aiomatic_persona_button);
                                aiomatic_progress.find('small').html('Error');
                                aiomatic_progress.addClass('aiomatic_error');
                                aiomatic_error_message.html(res.msg);
                                aiomatic_error_message.show();
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        error: function (r, s, error){
                            aiomatic_persona_upload.val('');
                            aiomaticRmLoading(aiomatic_persona_button);
                            aiomatic_progress.addClass('aiomatic_error');
                            aiomatic_progress.find('small').html('Error');
                            alert('Error in processing personas uploading: ' + error);
                            aiomatic_error_message.show();
                        }
                    });
                }
            }
        }
    });
    jQuery("#checkedAll").on('change', function() {
        if (this.checked) {
            jQuery(".aiomatic-select-persona").each(function() {
                this.checked=true;
            });
        } else {
            jQuery(".aiomatic-select-persona").each(function() {
                this.checked=false;
            });
        }
    });
    var aiomatic_persona_buttonx = jQuery('#aiomatic_persona_default_button');
    aiomatic_persona_buttonx.on('click', function (e){
        if(confirm('Are you sure you want to load the default personas which come bundled with the plugin?'))
        {
            e.preventDefault();
            var data = {
                action: 'aiomatic_default_persona',
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading2(jQuery('#aiomatic_persona_default_button'));
                },
                success: function (res){
                    if(res.status === 'success'){
                        alert('Default personas loaded successfully!');
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                        location.reload();
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing persona loading: ' + error);
                    location.reload();
                }
            });
        }
    });
    var codemodalfzr = document.getElementById('mymodalfzr');
    var btn = document.getElementById("aiomatic_manage_personas");
    var span = document.getElementById("aiomatic_close");
    if(btn != null)
    {
        btn.onclick = function(e) {
            e.preventDefault();
            codemodalfzr.style.display = "block";
        }
    }
    if(span != null)
    {
        span.onclick = function() {
            codemodalfzr.style.display = "none";
        }
    }
    var codemodalfzr_backup = document.getElementById('mymodalfzr_backup');
    var btn_backup = document.getElementById("aiomatic_backup_personas");
    var span_backup = document.getElementById("aiomatic_close_backup");
    if(btn_backup != null)
    {
        btn_backup.onclick = function(e) {
            e.preventDefault();
            codemodalfzr_backup.style.display = "block";
        }
    }
    if(span_backup != null)
    {
        span_backup.onclick = function() {
            codemodalfzr_backup.style.display = "none";
        }
    }
    window.onclick = function(event) {
        if (event.target == codemodalfzr_backup) {
            codemodalfzr_backup.style.display = "none";
        }
        if (event.target == codemodalfzr) {
            codemodalfzr.style.display = "none";
        }
    }
});