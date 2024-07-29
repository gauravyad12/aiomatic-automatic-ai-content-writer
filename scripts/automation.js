"use strict";
document.addEventListener('DOMContentLoaded', function () 
{
    const checkboxes = document.querySelectorAll('.disabled-blocks');
    checkboxes.forEach(checkbox => 
    {
        checkbox.addEventListener('change', function () {
            const omniblockCard = this.closest('.omniblock-card');
            if (this.checked) {
                omniblockCard.classList.add('disabled');
            } else {
                omniblockCard.classList.remove('disabled');
            }
        });
        const omniblockCard = checkbox.closest('.omniblock-card');
        if (checkbox.checked) {
            omniblockCard.classList.add('disabled');
        } else {
            omniblockCard.classList.remove('disabled');
        }
    });
});
function aiomatic_upload_selector_changing() 
{
    var x;
    x = document.getElementById("aiomatic-file-upload-location").value;
    if (x == "remote") 
    {
        jQuery('.locationRemoteHide').hide();
        jQuery('.locationRemoteShow').show();
    }
    else
    {
        jQuery('.locationRemoteHide').show();
        jQuery('.locationRemoteShow').hide();
    }
}
function aiomatic_upload_field_empty() 
{
    var x;
    var y;
    y = document.getElementById("aiomatic-file-upload-location").value;
    if (y == "remote") 
    {
        x = document.getElementById("aiomatic-file-remote-rules").value;
        if (x == "") {
            alert("You must enter a valid remote file URL before you can submit this.");
            return false;
        }
        else
        {
            unsaved = false;
        }
    }
    else
    {
        x = document.getElementById("aiomatic-file-upload-rules").value;
        if (x == "") {
            alert("You must select a valid file before you can submit this.");
            return false;
        }
        else
        {
            unsaved = false;
        }
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
function autoCreateAdmin(i) {
    var modals = [];
    var btns = [];
    var spans = [];
    var oks = [];
    var btns = [];
    modals = document.getElementById("mymodalauto" + i);
    btns = document.getElementById("mybtnauto" + i);
    spans = document.getElementById("aiomatic_auto_close" + i);
    oks = document.getElementById("aiomatic_auto_ok" + i);
    btns.onclick = function(e) {
        modals.style.display = "block";
    }
    spans.onclick = function(e) {
        modals.style.display = "none";
    }
    oks.onclick = function(e) {
        modals.style.display = "none";
    }
    modals.addEventListener("click", function(e) {
        if (e.target !== this)
            return;
        modals.style.display = "none";
    }, false);
    var mainCardOrder = jQuery('#aiomatic_sortable_cards' + i);
    if(mainCardOrder !== undefined)
    {
        if (typeof jQuery.fn.sortable !== 'undefined') 
        {
            mainCardOrder.sortable({
                update: function(event, ui) {
                    unsaved = true;
                    var cardOrder = jQuery('#aiomatic_sortable_cards' + i);
                    if(cardOrder !== undefined)
                    {
                        updateSortableInputAI(i, '');
                        updateCardSteps(i);
                    }
                    else
                    {
                        console.log('Cannot find the aiomatic_sortable_cards' + i + ' input!');
                    }
                },
                stop: function(event, ui) {
                    var cardOrder = jQuery('#aiomatic_sortable_cards' + i);
                    if(cardOrder !== undefined)
                    {
                        updateSortableInputAI(i, '');
                        updateCardSteps(i);
                    }
                    else
                    {
                        console.log('Cannot find the aiomatic_sortable_cards' + i + ' input!');
                    }
                },
                receive: function(event, ui) {
                    unsaved = true;
                    jQuery('#aiomatic_sortable_cards' + i + ' .delete-btn').prop('disabled', false);
                    jQuery('#aiomatic_sortable_cards' + i + ' .move-up-btn').prop('disabled', false);
                    jQuery('#aiomatic_sortable_cards' + i + ' .move-down-btn').prop('disabled', false);
                },
                scroll: true,
                scrollSensitivity: 100, 
                scrollSpeed: 10,
                cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
            });
        }
        jQuery(document).on('change input', '#aiomatic_sortable_cards' + i + ' input, #aiomatic_sortable_cards' + i + ' textarea, #aiomatic_sortable_cards' + i + ' select', function() {
            updateSortableInputAI(i, '');
        });
        jQuery(document).on('click','#aiomatic_sortable_cards' + i + ' button', function (e)
        {
            setTimeout(function() {
                updateSortableInputAI(i, '');
                updateCardSteps(i);
            }, 100);
        });
        if (typeof jQuery.fn.draggable !== 'undefined') 
        {
            jQuery('#aiomatic_new_card_types' + i + ' .new-card').draggable({
                helper: function() {
                    unsaved = true;
                    var cloned = jQuery(this).clone(true);
                    jQuery('.omniblock-card').removeClass('selected');
                    cloned.removeAttr('id');
                    var clonedHtml = cloned.prop('outerHTML');
                    var idMap = {};
                    var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
                        return replaceId(match, idMap);
                    });
                    var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
                        return replaceDataId(match, idMap);
                    });
                    cloned = jQuery(newHtml);
                    jQuery(this).find('input, textarea, select').each(function(index) {
                        var index = jQuery(this).attr('data-clone-index');
                        if(index != null && index != '' && index != undefined)
                        {
                            var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                            if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                                clonedElement.prop('checked', jQuery(this).is(':checked'));
                            } else {
                                clonedElement.val(jQuery(this).val());
                            }
                        }
                    });
                    return cloned.appendTo('#aiomatic_sortable_cards' + i).show();
                }, 
                connectToSortable: '#aiomatic_sortable_cards' + i, 
                revert: 'invalid',
                appendTo: '#aiomatic_sortable_cards' + i,
                scroll: true,
                cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
            });
        }
        jQuery(document).on('click','#add-new-btn' + i, function (e)
        {
            e.preventDefault();
            unsaved = true;
            var cloned = jQuery('#aiomatic_new_card_types' + i + ' li:visible').clone(true);
            cloned.removeAttr('id');
            var clonedHtml = cloned.prop('outerHTML');
            var idMap = {};
            var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
                return replaceId(match, idMap);
            });
            var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
                return replaceDataId(match, idMap);
            });
            cloned = jQuery(newHtml);
            if (cloned.hasClass('selected')) {
                cloned.removeClass('selected');
            }
            jQuery('#aiomatic_new_card_types' + i + ' li:visible').find('input, textarea, select').each(function(index) {
                var index = jQuery(this).attr('data-clone-index');
                if(index != null && index != '' && index != undefined)
                {
                    var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                    if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                        clonedElement.prop('checked', jQuery(this).is(':checked'));
                    } else {
                        clonedElement.val(jQuery(this).val());
                    }
                }
            });
            var retme = cloned.appendTo('#aiomatic_sortable_cards' + i).show();
            updateSortableInputAI(i, '');
            updateCardSteps(i);
            jQuery('#aiomatic_sortable_cards' + i + ' .delete-btn').prop('disabled', false);
            jQuery('#aiomatic_sortable_cards' + i + ' .move-up-btn').prop('disabled', false);
            jQuery('#aiomatic_sortable_cards' + i + ' .move-down-btn').prop('disabled', false);
            return retme;
        });
    }
    else
    {
        console.log('Error, aiomatic_sortable_cards' + i + ' input not found!');
    }
}
function aiomaticParseShortcode(shortcodeString) 
{
    let parsedShortcodes = {};
    if(shortcodeString == '')
    {
        return parsedShortcodes;
    }
    let lines = shortcodeString.split('\n');
    lines.forEach(line => {
        let parts = line.split('=>');
        if (parts.length === 2) 
        {
            let name = parts[0].trim();
            let values = parts[1].split(',').map(value => value.trim());
            parsedShortcodes[name] = values;
        }
    });
    return parsedShortcodes;
}
function aiomaticEscapeHtml(unsafe)
{
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}
function updateSortableInputAI(i, suff)
{
    var data = [];
    var all_shortcodes = [];
    jQuery('#aiomatic_sortable_cards' + suff + i + ' > li').each(function(index) 
    {
        var li = jQuery(this);
        var cardType = li.find('[card-type]').attr('card-type');
        var title = li.find('input[class*="omniblock-title"]').val();
        var indentificator = li.find('input[class*="omniblock-id"]').val();
        
        var shortcodes_holder = li.find('div[class*="shortcode-list"]');
        if(shortcodes_holder !== undefined)
        {
            if(shortcodes_holder.length > 0)
            {
                var count = 1;
                shortcodes_holder.each(function(index, one_holder_dom) {
                    var one_holder = jQuery(one_holder_dom);
                    var cardID = one_holder.attr('data-id-str');
                    var more_short_string = '';
                    var more_shortcodes = jQuery('#more_keywords' + i).val();
                    more_shortcodes = aiomaticParseShortcode(more_shortcodes);
                    var more_shorts = '';
                    if (cardType === 'ai_text_foreach' && count == 2) 
                    {
                        more_shorts += '<p class="aishortcodes" data-suff="' + suff + '" data-id-str="' + cardID + '" data-index="' + i + '" title="The additional shortcodes added by you from the settings.">%%current_input_line_counter%%</p>';
                        more_shorts += '<p class="aishortcodes" data-suff="' + suff + '" data-id-str="' + cardID + '" data-index="' + i + '" title="The additional shortcodes added by you from the settings.">%%current_input_line%%</p>';
                        more_shorts += '<p class="aishortcodes" data-suff="' + suff + '" data-id-str="' + cardID + '" data-index="' + i + '" title="The additional shortcodes added by you from the settings.">%%all_input_lines%%</p>';
                    }
                    for (let element in more_shortcodes) {
                        if(element != '')
                        {
                            more_short_string += '<p class="aishortcodes" data-suff="' + suff + '" data-id-str="' + cardID + '" data-index="' + i + '" title="The additional shortcodes added by you from the settings.">%%' + aiomaticEscapeHtml(element) + '%%</p>';
                        }
                    }
                    var shortcodes_str = '<p class="aishortcodes" data-suff="' + suff + '" data-id-str="' + cardID + '" data-index="' + i + '" title="The main keyword shortcode.">%%keyword%%</p>' + more_shorts + more_short_string;
                    if(cardID !== null)
                    {
                        all_shortcodes.forEach((element) => {if(element !== ''){var myIdArray = element.split('_');var myId = myIdArray[myIdArray.length - 1];myId = myId.substring(0, myId.length - 2);shortcodes_str += '<p class="aishortcodes" data-suff="' + suff + '" data-index="' + i + '" data-id-str="' + cardID + '" title="Shortcode created by OmniBlocks ID: ' + myId + '">' + element + '</p>'}});
                        one_holder.html(shortcodes_str);
                    }
                    count++;
                });
            }
        }
        var shortcodes = li.find('input[class*="omniblock-shortcodes"]').val();
        if(shortcodes !== undefined)
        {
            shortcodes = shortcodes.split(',');
            shortcodes = jQuery.grep(shortcodes, n => n == 0 || n);
            all_shortcodes = all_shortcodes.concat(shortcodes);
            all_shortcodes = [...new Set(all_shortcodes)];
        }
        var criticalBlock = '0';
        if(li.find('input[class="critical-blocks"]').is(':checked'))
        {
            criticalBlock = '1';
        }
        var disabledBlock = '0';
        if(li.find('input[class="disabled-blocks"]').is(':checked'))
        {
            disabledBlock = '1';
        }
        var parameters = {};
        if (cardType === 'ai_text') 
        {
            var prompt = li.find('.prompt').val();
            var model = li.find('.model').val();
            var assistant_id = li.find('.assistant_id').val();
            parameters = {
                'prompt': prompt,
                'model': model,
                'assistant_id': assistant_id,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'ai_text_foreach') 
        {
            var multiline_input = li.find('.multiline_input').val();
            var prepend = li.find('.prepend').val();
            var append = li.find('.append').val();
            var prompt = li.find('.prompt').val();
            var model = li.find('.model').val();
            var assistant_id = li.find('.assistant_id').val();
            var max_runs = li.find('.max_runs').val();
            parameters = {
                'multiline_input': multiline_input,
                'prompt': prompt,
                'model': model,
                'prepend': prepend,
                'append': append,
                'max_runs': max_runs,
                'assistant_id': assistant_id,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'dalle_ai_image' || cardType === 'stable_ai_image') 
        {
            var prompt = li.find('.prompt').val();
            var model = li.find('.model').val();
            var image_size = li.find('.image_size').val();
            parameters = {
                'prompt': prompt,
                'model': model,
                'image_size': image_size,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'midjourney_ai_image') 
        {
            var prompt = li.find('.prompt').val();
            var image_size = li.find('.image_size').val();
            parameters = {
                'prompt': prompt,
                'image_size': image_size,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'stable_ai_video') 
        {
            var image_url = li.find('.image_url').val();
            var image_size = li.find('.image_size').val();
            parameters = {
                'image_url': image_url,
                'image_size': image_size,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'nlp_entities') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'tts_openai') 
        {
            var input_text = li.find('.input_text').val();
            var model = li.find('.model').val();
            var voice = li.find('.voice').val();
            var output = li.find('.output').val();
            var stability = li.find('.stability').val();
            parameters = {
                'input_text': input_text,
                'model': model,
                'voice': voice,
                'output': output,
                'stability': stability,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'nlp_entities_neuron') 
        {
            var input_text = li.find('.input_text').val();
            var engine = li.find('.engine').val();
            var language = li.find('.language').val();
            parameters = {
                'input_text': input_text,
                'engine': engine,
                'language': language,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'webhook_fire') 
        {
            var api_key = li.find('.api_key').val();
            parameters = {
                'api_key': api_key,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'crawl_sites') 
        {
            var url = li.find('.url').val();
            var scrape_method = li.find('.scrape_method').val();
            var scrape_selector = li.find('.scrape_selector').val();
            var scrape_string = li.find('.scrape_string').val();
            var strip_tags = li.find('.strip_tags').val();
            var max_chars = li.find('.max_chars').val();
            parameters = {
                'url': url,
                'scrape_method': scrape_method,
                'scrape_selector': scrape_selector,
                'scrape_string': scrape_string,
                'strip_tags': strip_tags,
                'max_chars': max_chars,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'crawl_rss') 
        {
            var url = li.find('.url').val();
            var template = li.find('.template').val();
            var max_items = li.find('.max_items').val();
            var scrape = li.find('.scrape').val();
            var scrape_method = li.find('.scrape_method').val();
            var max_chars = li.find('.max_chars').val();
            var prompt = li.find('.prompt').val();
            var model = li.find('.model').val();
            var assistant_id = li.find('.assistant_id').val();
            parameters = {
                'url': url,
                'template': template,
                'max_items': max_items,
                'scrape': scrape,
                'scrape_method': scrape_method,
                'max_chars': max_chars,
                'prompt': prompt,
                'model': model,
                'assistant_id': assistant_id,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'google_search') 
        {
            var keyword = li.find('.keyword').val();
            var locale = li.find('.locale').val();
            var template = li.find('.template').val();
            var max_items = li.find('.max_items').val();
            var scrape = li.find('.scrape').val();
            var scrape_method = li.find('.scrape_method').val();
            var max_chars = li.find('.max_chars').val();
            var prompt = li.find('.prompt').val();
            var model = li.find('.model').val();
            var assistant_id = li.find('.assistant_id').val();
            parameters = {
                'keyword': keyword,
                'template': template,
                'locale': locale,
                'max_items': max_items,
                'scrape': scrape,
                'scrape_method': scrape_method,
                'max_chars': max_chars,
                'prompt': prompt,
                'model': model,
                'assistant_id': assistant_id,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'post_import') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'random_line') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'youtube_video') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'royalty_image') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'youtube_caption') 
        {
            var url = li.find('.url').val();
            var max_caption = li.find('.max_caption').val();
            parameters = {
                'url': url,
                'max_caption': max_caption,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'amazon_product') 
        {
            var asin = li.find('.asin').val();
            var aff_id = li.find('.aff_id').val();
            var target_country = li.find('.target_country').val();
            parameters = {
                'asin': asin,
                'aff_id': aff_id,
                'target_country': target_country,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'amazon_listing') 
        {
            var asin = li.find('.asin').val();
            var aff_id = li.find('.aff_id').val();
            var target_country = li.find('.target_country').val();
            var sort_results = li.find('.sort_results').val();
            var max_product_count = li.find('.max_product_count').val();
            var listing_template = li.find('.listing_template').val();
            parameters = {
                'asin': asin,
                'aff_id': aff_id,
                'target_country': target_country,
                'sort_results': sort_results,
                'max_product_count': max_product_count,
                'listing_template': listing_template,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'text_translate') 
        {
            var input_text = li.find('.input_text').val();
            var translate = li.find('.translate').val();
            var translate_source = li.find('.translate_source').val();
            var second_translate = li.find('.second_translate').val();
            parameters = {
                'input_text': input_text,
                'translate': translate,
                'translate_source': translate_source,
                'second_translate': second_translate,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'text_spinner') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'embeddings') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'load_file') 
        {
            var input_text = li.find('.input_text').val();
            parameters = {
                'input_text': input_text,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_email') 
        {
            var email_title = li.find('.email_title').val();
            var email_content = li.find('.email_content').val();
            var email_recipient = li.find('.email_recipient').val();
            parameters = {
                'email_title': email_title,
                'email_content': email_content,
                'email_recipient': email_recipient,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'save_file') 
        {
            var post_template = li.find('.post_template').val();
            var send_type = li.find('.send_type').val();
            var file_type = li.find('.file_type').val();
            parameters = {
                'post_template': post_template,
                'send_type': send_type,
                'file_type': file_type,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_facebook') 
        {
            var post_template = li.find('.post_template').val();
            var post_link = li.find('.post_link').val();
            var page_to_post = li.find('.page_to_post').val();
            parameters = {
                'post_template': post_template,
                'post_link': post_link,
                'page_to_post': page_to_post,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_image_facebook') 
        {
            var post_template = li.find('.post_template').val();
            var image_link = li.find('.image_link').val();
            var page_to_post = li.find('.page_to_post').val();
            parameters = {
                'post_template': post_template,
                'image_link': image_link,
                'page_to_post': page_to_post,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_image_instagram') 
        {
            var post_template = li.find('.post_template').val();
            var image_link = li.find('.image_link').val();
            parameters = {
                'post_template': post_template,
                'image_link': image_link,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_image_pinterest') 
        {
            var post_template = li.find('.post_template').val();
            var post_title = li.find('.post_title').val();
            var pin_me = li.find('.pin_me').val();
            var image_link = li.find('.image_link').val();
            var page_to_post = li.find('.page_to_post').val();
            parameters = {
                'post_template': post_template,
                'post_title': post_title,
                'pin_me': pin_me,
                'image_link': image_link,
                'page_to_post': page_to_post,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_twitter') 
        {
            var post_template = li.find('.post_template').val();
            var featured_image = li.find('.featured_image').val();
            parameters = {
                'post_template': post_template,
                'featured_image': featured_image,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_gmb') 
        {
            var post_template = li.find('.post_template').val();
            var featured_image = li.find('.featured_image').val();
            var page_to_post = li.find('.page_to_post').val();
            parameters = {
                'post_template': post_template,
                'featured_image': featured_image,
                'page_to_post': page_to_post,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_community_youtube') 
        {
            var post_template = li.find('.post_template').val();
            var featured_image = li.find('.featured_image').val();
            var send_type = li.find('.send_type').val();
            parameters = {
                'post_template': post_template,
                'featured_image': featured_image,
                'send_type': send_type,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_reddit') 
        {
            var subreddit_to_post = li.find('.subreddit_to_post').val();
            var title_template = li.find('.title_template').val();
            var post_template = li.find('.post_template').val();
            var send_type = li.find('.send_type').val();
            parameters = {
                'post_template': post_template,
                'title_template': title_template,
                'subreddit_to_post': subreddit_to_post,
                'send_type': send_type,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_webhook') 
        {
            var webhook_url = li.find('.webhook_url').val();
            var webhook_method = li.find('.webhook_method').val();
            var content_type = li.find('.content_type').val();
            var post_template = li.find('.post_template').val();
            var headers_template = li.find('.headers_template').val();
            parameters = {
                'content_type': content_type,
                'webhook_method': webhook_method,
                'webhook_url': webhook_url,
                'post_template': post_template,
                'headers_template': headers_template,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'god_mode') 
        {
            var prompt = li.find('.prompt').val();
            var assistant_id = li.find('.assistant_id').val();
            var model = li.find('.model').val();
            parameters = {
                'prompt': prompt,
                'assistant_id': assistant_id,
                'model': model,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'send_linkedin') 
        {
            var post_template = li.find('.post_template').val();
            var featured_image = li.find('.featured_image').val();
            var page_to_post = li.find('.page_to_post').val();
            var post_title = li.find('.post_title').val();
            var post_link = li.find('.post_link').val();
            var attach_lnk = li.find('.attach_lnk').val();
            var post_description = li.find('.post_description').val();
            parameters = {
                'post_template': post_template,
                'featured_image': featured_image,
                'page_to_post': page_to_post,
                'post_title': post_title,
                'post_link': post_link,
                'attach_lnk': attach_lnk,
                'post_description': post_description,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'save_post') 
        {
            var postTitle = li.find('.post_title').val();
            var postContent = li.find('.post_content').val();
            var post_excerpt = li.find('.post_excerpt').val();
            var post_author = li.find('.post_author').val();
            var post_status = li.find('.post_status').val();
            var post_type = li.find('.post_type').val();
            var post_format = li.find('.post_format').val();
            var post_parent = li.find('.post_parent').val();
            var post_comments = li.find('.post_comments').val();
            var post_pingbacks = li.find('.post_pingbacks').val();
            var post_date = li.find('.post_date').val();
            var post_custom_fields = li.find('.post_custom_fields').val();
            var post_slug = li.find('.post_slug').val();
            var post_custom_taxonomies = li.find('.post_custom_taxonomies').val();
            var post_lang = li.find('.post_lang').val();
            var post_categories = li.find('.post_categories').val();
            var post_tags = li.find('.post_tags').val();
            var post_id = li.find('.post_id').val();
            var content_regex = li.find('.content_regex').val();
            var replace_regex = li.find('.replace_regex').val();
            var overwrite_existing = li.find('.overwrite_existing').val();
            var featuredImage = li.find('.featured_image').val();
            parameters = {
                'post_title': postTitle,
                'post_content': postContent,
                'post_excerpt': post_excerpt,
                'post_author': post_author,
                'post_status': post_status,
                'post_type': post_type,
                'post_format': post_format,
                'post_parent': post_parent,
                'post_comments': post_comments,
                'post_pingbacks': post_pingbacks,
                'post_date': post_date,
                'post_custom_fields': post_custom_fields,
                'post_slug': post_slug,
                'post_custom_taxonomies': post_custom_taxonomies,
                'post_lang': post_lang,
                'post_categories': post_categories,
                'post_tags': post_tags,
                'content_regex': content_regex,
                'replace_regex': replace_regex,
                'overwrite_existing': overwrite_existing,
                'featured_image': featuredImage,
                'post_id': post_id,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'if_block') 
        {
            var condition = li.find('.condition').val();
            var evaluation_method = li.find('.evaluation_method').val();
            var expected_value = li.find('.expected_value').val();
            var true_blocks = li.find('.true_blocks').val();
            var false_blocks = li.find('.false_blocks').val();
            parameters = {
                'condition': condition,
                'evaluation_method': evaluation_method,
                'expected_value': expected_value,
                'true_blocks': true_blocks,
                'false_blocks': false_blocks,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'exit_block') 
        {
            parameters = {
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else if (cardType === 'jump_block') 
        {
            var jumpto = li.find('.jumpto').val();
            parameters = {
                'jumpto': jumpto,
                'critical': criticalBlock,
                'disabled': disabledBlock
            };
        }
        else
        {
            if(cardType !== undefined)
            {
                console.log('Unknown card type found: ' + cardType);
            }
            return;
        }
        var item = {
            'identifier': indentificator,
            'name': title,               
            'type': cardType,           
            'parameters': parameters  
        };
        var existingIndex = data.findIndex(d => d.identifier === indentificator);
        if (existingIndex === -1) 
        {
            data.push(item);
        }
        else
        {
            while(data.findIndex(d => d.identifier === indentificator) !== -1)
            {
                indentificator = aiomatic_increment(indentificator);
            }
            item = {
                'identifier': indentificator, 
                'name': title,               
                'type': cardType,           
                'parameters': parameters      
            };
            data.push(item);
        }
        var id_show = li.find('.id-shower');
        if(id_show !== undefined)
        {
            if(id_show.text() == '')
            {
                id_show.text('ID: ' + indentificator);
                var bl_id = li.find('.omniblock-id');
                if(bl_id !== undefined)
                {
                    bl_id.val(indentificator);
                    var bl_code = li.find('.omniblock-shortcodes');
                    if(bl_code !== undefined)
                    {
                        var bltype = bl_code.attr("card-type");
                        if(bltype !== null)
                        {
                            if(bltype == 'ai_text')
                            {
                                bl_code.val('%%ai_text_' + indentificator + '%%');
                            }
                            else if(bltype == 'ai_text_foreach')
                            {
                                bl_code.val('%%ai_text_foreach_' + indentificator + '%%');
                            }
                            else if(bltype == 'dalle_ai_image')
                            {
                                bl_code.val('%%dalle_image_' + indentificator + '%%');
                            }
                            else if(bltype == 'royalty_image')
                            {
                                bl_code.val('%%free_image_' + indentificator + '%%');
                            }
                            else if(bltype == 'stable_ai_image')
                            {
                                bl_code.val('%%stability_image_' + indentificator + '%%');
                            }
                            else if(bltype == 'midjourney_ai_image')
                            {
                                bl_code.val('%%midjourney_image_' + indentificator + '%%');
                            }
                            else if(bltype == 'stable_ai_video')
                            {
                                bl_code.val('%%stability_video_' + indentificator + '%%');
                            }
                            else if(bltype == 'nlp_entities')
                            {
                                bl_code.val('%%entities_' + indentificator + '%%,%%entities_details_json_' + indentificator + '%%');
                            }
                            else if(bltype == 'tts_openai')
                            {
                                bl_code.val('%%audio_url_' + indentificator + '%%');
                            }
                            else if(bltype == 'nlp_entities_neuron')
                            {
                                bl_code.val('%%entities_title_' + indentificator + '%%,%%entities_description_' + indentificator + '%%,%%entities_h1_' + indentificator + '%%,%%entities_h2_' + indentificator + '%%,%%entities_content_basic_' + indentificator + '%%,%%entities_content_basic_with_ranges_' + indentificator + '%%,%%entities_content_extended_' + indentificator + '%%,%%entities_content_extended_with_ranges_' + indentificator + '%%,%%entities_list_' + indentificator + '%%');
                            }
                            else if(bltype == 'webhook_fire')
                            {
                                bl_code.val('%%webhook_data_' + indentificator + '%%');
                            }
                            else if(bltype == 'crawl_sites')
                            {
                                bl_code.val('%%scraped_content_' + indentificator + '%%,%%scraped_content_plain_' + indentificator + '%%');
                            }
                            else if(bltype == 'crawl_rss')
                            {
                                bl_code.val('%%rss_content_' + indentificator + '%%');
                            }
                            else if(bltype == 'google_search')
                            {
                                bl_code.val('%%search_result_' + indentificator + '%%');
                            }
                            else if(bltype == 'youtube_video')
                            {
                                bl_code.val('%%video_url_' + indentificator + '%%,%%video_embed_' + indentificator + '%%');
                            }
                            else if(bltype == 'post_import')
                            {
                                bl_code.val('%%post_id_' + indentificator + '%%,%%post_url_' + indentificator + '%%,%%post_title_' + indentificator + '%%,%%post_content_' + indentificator + '%%,%%post_excerpt_' + indentificator + '%%,%%post_categories_' + indentificator + '%%,%%post_tags_' + indentificator + '%%,%%post_author_' + indentificator + '%%,%%post_date_' + indentificator + '%%,%%post_status_' + indentificator + '%%,%%post_type_' + indentificator + '%%,%%post_image_' + indentificator + '%%');
                            }
                            else if(bltype == 'random_line')
                            {
                                bl_code.val('%%random_line_' + indentificator + '%%');
                            }
                            else if(bltype == 'youtube_caption')
                            {
                                bl_code.val('%%video_caption_' + indentificator + '%%,%%video_title_' + indentificator + '%%,%%video_description_' + indentificator + '%%,%%video_thumb_' + indentificator + '%%');
                            }
                            else if(bltype == 'amazon_product')
                            {
                                bl_code.val('%%product_title_' + indentificator + '%%,%%product_description_' + indentificator + '%%,%%product_url_' + indentificator + '%%,%%product_price_' + indentificator + '%%,%%product_list_price_' + indentificator + '%%,%%product_image_' + indentificator + '%%,%%product_cart_url_' + indentificator + '%%,%%product_images_urls_' + indentificator + '%%,%%product_images_' + indentificator + '%%,%%product_reviews_' + indentificator + '%%,%%product_score_' + indentificator + '%%,%%product_language_' + indentificator + '%%,%%product_edition_' + indentificator + '%%,%%product_pages_count_' + indentificator + '%%,%%product_publication_date_' + indentificator + '%%,%%product_contributors_' + indentificator + '%%,%%product_manufacturer_' + indentificator + '%%,%%product_binding_' + indentificator + '%%,%%product_product_group_' + indentificator + '%%,%%product_rating_' + indentificator + '%%,%%product_eans_' + indentificator + '%%,%%product_part_no_' + indentificator + '%%,%%product_model_' + indentificator + '%%,%%product_warranty_' + indentificator + '%%,%%product_color_' + indentificator + '%%,%%product_is_adult_' + indentificator + '%%,%%product_dimensions_' + indentificator + '%%,%%product_date_' + indentificator + '%%,%%product_size_' + indentificator + '%%,%%product_unit_count_' + indentificator + '%%');
                            }
                            else if(bltype == 'amazon_listing')
                            {
                                bl_code.val('%%product_listing_' + indentificator + '%%');
                            }
                            else if(bltype == 'text_translate')
                            {
                                bl_code.val('%%translated_' + indentificator + '%%');
                            }
                            else if(bltype == 'embeddings')
                            {
                                bl_code.val('%%embeddings_' + indentificator + '%%');
                            }
                            else if(bltype == 'text_spinner')
                            {
                                bl_code.val('%%spun_' + indentificator + '%%');
                            }
                            else if(bltype == 'save_post')
                            {
                                bl_code.val('%%created_post_id_' + indentificator + '%%,%%created_post_url_' + indentificator + '%%');
                            }
                            else if(bltype == 'load_file')
                            {
                                bl_code.val('%%file_' + indentificator + '%%');
                            }
                            else if(bltype == 'send_email')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'save_file')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_facebook')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_image_facebook')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_image_instagram')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_image_pinterest')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_twitter')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_gmb')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_community_youtube')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_linkedin')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_reddit')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'send_webhook')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'god_mode')
                            {
                                bl_code.val('%%god_mode_' + indentificator + '%%');
                            }
                            else if(bltype == 'if_block')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'exit_block')
                            {
                                bl_code.val('');
                            }
                            else if(bltype == 'jump_block')
                            {
                                bl_code.val('');
                            }
                            else
                            {
                                bl_code.val('');
                            }
                        }
                    }
                }
            }
        }
    });
    jQuery('#sortable_cards' + suff + i).val(JSON.stringify(data));
}
function assistantChanged(assistantID)
{
    if(jQuery('#sel_' + assistantID).val() == '' || jQuery('#sel_' + assistantID).val() == null)
    {
        jQuery('#' + assistantID).removeAttr('disabled');
    }
    else
    {
        jQuery('#' + assistantID).attr('disabled', 'disabled');
    }
}
function actionsChangedOmni(ruleId, typeId, uniquid, shtc, runTable)
{
    if(unsaved){
        alert("You have unsaved changes on this page. Please save your changes before manually running rules!");
        return;
    }
    runNowOmni(ruleId, typeId, uniquid, shtc, runTable);
}
function aiomatic_string_to_slug(str)
{
	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();

	var from = "àáäâèéëêìíïîòóöôùúüûñçěščřžýúůďťň·/_,:;";
	var to   = "aaaaeeeeiiiioooouuuuncescrzyuudtn------";

	for (var i=0, l=from.length ; i<l ; i++)
	{
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	str = str.replace('.', '-') // replace a dot by a dash 
		.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, '-') // collapse whitespace and replace by a dash
		.replace(/-+/g, '-') // collapse dashes
		.replace( /\//g, '' ); // collapse all forward-slashes

	return str;
}
function runNowOmni(number, typeId, uniquid, shtc, runTable)
{
    document.getElementById("run_img_omni" + number).style.visibility = "visible";
    document.getElementById("run_img_omni" + number).src = mycustomsettings.plugin_dir_url + "images/running.gif";
    var data = {
        action: 'aiomatic_run_omniblock',
        id: number,
        type: typeId,
        uniquid: uniquid,
        nonce: aiomatic_ajax_object.nonce
    };
    var pollingInterval;
    function startPolling() {
        pollingInterval = setInterval(function() 
        {
            jQuery.get(mycustomsettings.ajaxurl, { action: 'aiomatic_check_process_status', nonce: aiomatic_ajax_object.bulk_nonce }, function(response) 
            {
                if (response.status === 'success') 
                {
                    var datetime = myAIGetDateTime();
                    jQuery('#running_status_ai').html('<hr/><b>Activity Log:</b><br/><br/>' + datetime + ':<br/> ' + response.msg);
                }
                else
                {
                    console.log('Failed to poll results: ' + response);
                    clearInterval(pollingInterval);
                }
            }).fail(function(xhr) 
            {
                clearInterval(pollingInterval);
                console.log('Exception in results polling: ' + JSON.stringify(xhr));
            });
        }, 3000);
    }
    jQuery.post(mycustomsettings.ajaxurl, data, function(response) 
    {
        if(response.trim() == 'nochange')
        {
            document.getElementById("run_img_omni" + number).src= mycustomsettings.plugin_dir_url + "images/nochange.gif";
            runTable.html('No results returned');
        }
        else
        {
            if(response.trim() == 'fail')
            {
                document.getElementById("run_img_omni" + number).src= mycustomsettings.plugin_dir_url + "images/failed.gif";
                runTable.html('Running failed, please check details in the \'Activity and Logging\' menu of the plugin.');
            }
            else
            {
                document.getElementById("run_img_omni" + number).src= mycustomsettings.plugin_dir_url + "images/ok.gif";
                if(response.trim() == 'ok')
                {
                    runTable.html('Success!');
                }
                else
                {
                    var rez = '';
                    try 
                    {
                        rez = JSON.parse(response);
                    } 
                    catch (e) 
                    {
                        document.getElementById("run_img_omni" + number).src= mycustomsettings.plugin_dir_url + "images/failed.gif";
                        runTable.html('Failed to deconde server response ' + response);
                        console.log('Failed to decode server response: ' + console.error(e));
                        return;
                    }
                    if(Array.isArray(rez))
                    {
                        var isEmpty = true;
                        rez.forEach((element) => {if(element != '') {isEmpty = false;}});
                        if(isEmpty === true)
                        {
                            alert('Failed to run OmniBlock, please check the \'Actity and Logging\' menu for details!');
                        }
                        var add_me = '<h2>Shortcodes and their respective values:</h2><br/><br/>';
                        shtc = shtc.replace('%%keyword%%,','');
                        const shtc_arr = shtc.split(",");
                        if(shtc_arr.length != rez.length)
                        {
                            console.log('Array lenght mistmatch: ' + shtc_arr + ' AND ' + rez);
                        }
                        for (var i = 0; i < shtc_arr.length; i++)
                        {
                            add_me += '<h3>' + shtc_arr[i] + '</h3><br/>';
                            add_me += '<textarea class="cr_width_full" rows="4" id="' + aiomatic_string_to_slug(shtc_arr[i]) + '">' + rez[i] + '</textarea><br/><span data-id="' + aiomatic_string_to_slug(shtc_arr[i]) + '" title="Copy text" class="aiomatic-copy-textarea"><svg fill="#000000" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Text-files"> <path d="M53.9791489,9.1429005H50.010849c-0.0826988,0-0.1562004,0.0283995-0.2331009,0.0469999V5.0228 C49.7777481,2.253,47.4731483,0,44.6398468,0h-34.422596C7.3839517,0,5.0793519,2.253,5.0793519,5.0228v46.8432999 c0,2.7697983,2.3045998,5.0228004,5.1378999,5.0228004h6.0367002v2.2678986C16.253952,61.8274002,18.4702511,64,21.1954517,64 h32.783699c2.7252007,0,4.9414978-2.1725998,4.9414978-4.8432007V13.9861002 C58.9206467,11.3155003,56.7043495,9.1429005,53.9791489,9.1429005z M7.1110516,51.8661003V5.0228 c0-1.6487999,1.3938999-2.9909999,3.1062002-2.9909999h34.422596c1.7123032,0,3.1062012,1.3422,3.1062012,2.9909999v46.8432999 c0,1.6487999-1.393898,2.9911003-3.1062012,2.9911003h-34.422596C8.5049515,54.8572006,7.1110516,53.5149002,7.1110516,51.8661003z M56.8888474,59.1567993c0,1.550602-1.3055,2.8115005-2.9096985,2.8115005h-32.783699 c-1.6042004,0-2.9097996-1.2608986-2.9097996-2.8115005v-2.2678986h26.3541946 c2.8333015,0,5.1379013-2.2530022,5.1379013-5.0228004V11.1275997c0.0769005,0.0186005,0.1504021,0.0469999,0.2331009,0.0469999 h3.9682999c1.6041985,0,2.9096985,1.2609005,2.9096985,2.8115005V59.1567993z"></path> <path d="M38.6031494,13.2063999H16.253952c-0.5615005,0-1.0159006,0.4542999-1.0159006,1.0158005 c0,0.5615997,0.4544001,1.0158997,1.0159006,1.0158997h22.3491974c0.5615005,0,1.0158997-0.4542999,1.0158997-1.0158997 C39.6190491,13.6606998,39.16465,13.2063999,38.6031494,13.2063999z"></path> <path d="M38.6031494,21.3334007H16.253952c-0.5615005,0-1.0159006,0.4542999-1.0159006,1.0157986 c0,0.5615005,0.4544001,1.0159016,1.0159006,1.0159016h22.3491974c0.5615005,0,1.0158997-0.454401,1.0158997-1.0159016 C39.6190491,21.7877007,39.16465,21.3334007,38.6031494,21.3334007z"></path> <path d="M38.6031494,29.4603004H16.253952c-0.5615005,0-1.0159006,0.4543991-1.0159006,1.0158997 s0.4544001,1.0158997,1.0159006,1.0158997h22.3491974c0.5615005,0,1.0158997-0.4543991,1.0158997-1.0158997 S39.16465,29.4603004,38.6031494,29.4603004z"></path> <path d="M28.4444485,37.5872993H16.253952c-0.5615005,0-1.0159006,0.4543991-1.0159006,1.0158997 s0.4544001,1.0158997,1.0159006,1.0158997h12.1904964c0.5615025,0,1.0158005-0.4543991,1.0158005-1.0158997 S29.0059509,37.5872993,28.4444485,37.5872993z"></path> </g> </g></svg></span><br/><br/>';
                        }
                        runTable.html(add_me);
                    }
                    else
                    {
                        console.log('The results cannot be parsed! ' + rez)
                        runTable.html('The results cannot be parsed!');
                    }
                }
            }
        }
        if(mycustomsettings.more_logs == '1')
        {
            clearInterval(pollingInterval);
        }
    }).fail( function(xhr) 
    {
        console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details.');
        document.getElementById("run_img_omni" + number).src= mycustomsettings.plugin_dir_url + "images/failed.gif";
        if(mycustomsettings.more_logs == '1')
        {
            clearInterval(pollingInterval);
        }
    });
    if(mycustomsettings.more_logs == '1')
    {
        startPolling();
    }
}
jQuery(document).ready(function($) 
{
    function updateOmniBlockState(checkbox) 
    {
        const omniblockCard = checkbox.closest('.omniblock-card');
        if (checkbox.is(':checked')) {
            omniblockCard.addClass('disabled');
        } else {
            omniblockCard.removeClass('disabled');
        }
    }
    function initializeCheckboxes() {
        $('.disabled-blocks').each(function () {
            const checkbox = $(this);
            updateOmniBlockState(checkbox);
        });
    }
    initializeCheckboxes();
    $(document).on('change', '.disabled-blocks', function () 
    {
        updateOmniBlockState($(this));
    });
    $(document).ajaxComplete(function () 
    {
        initializeCheckboxes();
    });

    var codemodalfzr_backup = document.getElementById('mymodalfzr_backup');
    var btn_backup = document.getElementById("aiomatic_backup_templates");
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
    
    var codemodalfzr_new = document.getElementById('mymodalfzr_new');
    var btn = document.getElementById("aiomatic_manage_omni_templates");
    var span = document.getElementById("aiomatic_close_new");
    if(btn != null)
    {
        btn.onclick = function(e) {
            e.preventDefault();
            codemodalfzr_new.style.display = "block";
        }
    }
    if(span != null)
    {
        span.onclick = function() {
            codemodalfzr_new.style.display = "none";
        }
    }

    var codemodalfzr_run = document.getElementById('mymodalfzr_run');
    var buttons = document.getElementsByClassName("aiomatic-run-now");
    var span = document.getElementById("aiomatic_close_run");
    if(btn != null)
    {
        for(var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = function(e) {
                e.preventDefault();
                if (confirm("Are you sure you want to run this OmniBlock now? Note that all previous OmniBlocks from the rule will also be executed.") == true) {
                    var ruleId = this.getAttribute('data-cont');
                    var uniquid = this.getAttribute('data-lastid');
                    var shtc = this.getAttribute('data-shtc');
                    if(ruleId === null || ruleId === '' || uniquid === null || uniquid === '')
                    {
                        var runTable = jQuery('#ai-runner-div tbody');
                        codemodalfzr_run.style.display = "block";
                        var loadingHTML = '<tr><td><br/><div id="my-loading-indicator">Failed to parse required input data...</div></td></tr>';
                        runTable.html(loadingHTML);
                    }
                    unsaved = false;
                    var runTable = jQuery('#ai-runner-div tbody');
                    codemodalfzr_run.style.display = "block";
                    var loadingHTML = '<tr><td><br/><br/><br/><div id="my-loading-indicator">Running, please wait...<br/><br/><img id="run_img_omni' + ruleId + '"></div></td></tr>';
                    runTable.html(loadingHTML);
                    actionsChangedOmni(ruleId, 5, uniquid, shtc, runTable);
                }
            }
        }
    }
    if(span != null)
    {
        span.onclick = function() {
            codemodalfzr_run.style.display = "none";
        }
    }

    var codemodalfzr_edit = document.getElementById('mymodalfzr_edit');
    var buttons = document.getElementsByClassName("aiomatic_edit_omni_template");
    var span = document.getElementById("aiomatic_close_edit");
    if(btn != null)
    {
        for(var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = function(e) {
                e.preventDefault();
                unsaved = false;
                var editTable = jQuery('#ai-editor-div tbody');
                codemodalfzr_edit.style.display = "block";
                var theID = jQuery(this).attr('edit-id');
                if(theID !== null && editTable !== null)
                {
                    var loadingHTML = '<tr><td><br/><div id="my-loading-indicator">Loading...</div></td></tr>';
                    editTable.html(loadingHTML);
                    var data = {
                        action: 'aiomatic_get_omni_data',
                        nonce: aiomatic_object.nonce,
                        theID: theID
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
                                editTable.html(res.msg);
                                
                                var mainCardOrder_edit = $('#aiomatic_sortable_cards_edit');
                                if(mainCardOrder_edit !== undefined)
                                {
                                    if (typeof jQuery.fn.sortable !== 'undefined') 
                                    {
                                        mainCardOrder_edit.sortable({
                                            update: function(event, ui) {
                                                unsaved = true;
                                                updateSortableInputAI('', '_edit');
                                                updateCardSteps('');
                                            },
                                            stop: function(event, ui) {
                                                updateSortableInputAI('', '_edit');
                                                updateCardSteps('');
                                            },
                                            receive: function(event, ui) {
                                                unsaved = true;
                                                $('#aiomatic_sortable_cards_edit .delete-btn').prop('disabled', false);
                                                $('#aiomatic_sortable_cards_edit .move-up-btn_edit').prop('disabled', false);
                                                $('#aiomatic_sortable_cards_edit .move-down-btn_edit').prop('disabled', false);
                                                updateCardSteps('');
                                            },
                                            scroll: true,
                                            scrollSensitivity: 100, 
                                            scrollSpeed: 10,
                                            cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
                                        });
                                    }
                                    jQuery('#aiomatic_sortable_cards_edit').on('change input', 'input, textarea, select', function() {
                                        updateSortableInputAI('', '_edit');
                                    });
                                    jQuery(document).on('click','#aiomatic_sortable_cards_edit button', function (e)
                                    {
                                        setTimeout(function() {
                                            updateSortableInputAI('', '_edit');
                                            updateCardSteps('');
                                        }, 100);
                                    });
                                }
                                else
                                {
                                    console.log('Error, aiomatic_sortable_cards_edit input not found!');
                                }
                                if (typeof jQuery.fn.draggable !== 'undefined') 
                                {
                                    $('#aiomatic_new_card_types_edit .new-card').draggable({
                                        helper: function() {
                                            unsaved = true;
                                            var cloned = $(this).clone(true);
                                            jQuery('.omniblock-card').removeClass('selected');
                                            cloned.removeAttr('id');
                                            var clonedHtml = cloned.prop('outerHTML');
                                            var idMap = {};
                                            var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
                                                return replaceId(match, idMap);
                                            });
                                            var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
                                                return replaceDataId(match, idMap);
                                            });
                                            cloned = jQuery(newHtml);
                                            $(this).find('input, textarea, select').each(function(index) {
                                                var index = jQuery(this).attr('data-clone-index');
                                                if(index != null && index != '' && index != undefined)
                                                {
                                                    var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                                                    if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                                                        clonedElement.prop('checked', jQuery(this).is(':checked'));
                                                    } else {
                                                        clonedElement.val(jQuery(this).val());
                                                    }
                                                }
                                            });
                                            return cloned.appendTo('#aiomatic_sortable_cards_edit').show();
                                        }, 
                                        connectToSortable: '#aiomatic_sortable_cards_edit', 
                                        revert: 'invalid',
                                        appendTo: '#aiomatic_sortable_cards_edit',
                                        scroll: true,
                                        cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
                                    });
                                }
                            }
                            else
                            {
                                alert(res.msg);
                            }
                        },
                        error: function (r, s, error)
                        {
                            alert('Error in processing OmniBlock templates editing: ' + error);
                        }
                    });
                }
            }
        }
    }
    if(span != null)
    {
        span.onclick = function() {
            codemodalfzr_edit.style.display = "none";
        }
    }

    /*window.onclick = function(event) {
        if (event.target == codemodalfzr_backup) {
            codemodalfzr_backup.style.display = "none";
        }
        if (event.target == codemodalfzr_new) {
            codemodalfzr_new.style.display = "none";
        }
        if (event.target == codemodalfzr_edit) {
            codemodalfzr_edit.style.display = "none";
        }
    }*/
    jQuery(document).on('click','.aiomatic-copy-textarea', function (e)
    {
        e.preventDefault();
        var dataid = jQuery(this).attr('data-id');
        var txt = jQuery("#" + dataid).val();
        if(navigator.clipboard !== undefined)
        {
            navigator.clipboard.writeText(txt);
            alert('Text copied');
        }
        else
        {
            alert('Failed to copy text');
        }
    });
    jQuery(document).on('click','#ai-save-omni-template_edit', function (e)
    {
        e.preventDefault();
        if(confirm('Are you sure you want to save the configured OmniBlock template?'))
        {
            unsaved = false;
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var omni_template_edit = jQuery('#omni_template_edit').val();
            var omni_template_cat_edit = jQuery('#omni_template_cat_edit').val();
            var sortable_cards_edit = jQuery('#sortable_cards_edit').val();
            var omni_template_id = jQuery('#omni_template_id').val();
            var data = {
                action: 'aiomatic_save_omni_template_edit',
                nonce: aiomatic_object.nonce,
                omni_template_edit: omni_template_edit,
                omni_template_cat_edit: omni_template_cat_edit,
                sortable_cards_edit: sortable_cards_edit,
                omni_template_id: omni_template_id
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing OmniBlock templates editing: ' + error);
                }
            });
        }
    });
    jQuery('#ai-save-omni-template').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to save the configured OmniBlock template?'))
        {
            unsaved = false;
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var omni_template_new = jQuery('#omni_template_new').val();
            var omni_template_cat_new = jQuery('#omni_template_cat_new').val();
            var sortable_cards_new = jQuery('#sortable_cards_new').val();
            var data = {
                action: 'aiomatic_save_omni_template',
                nonce: aiomatic_object.nonce,
                omni_template_new: omni_template_new,
                omni_template_cat_new: omni_template_cat_new,
                sortable_cards_new: sortable_cards_new
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                success: function (res){
                    aiomaticRmLoading(btn);
                    if(res.status === 'success'){
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                    }
                },
                error: function (r, s, error){
                    aiomaticRmLoading(btn);
                    alert('Error in processing OmniBlock templates saving: ' + error);
                }
            });
        }
    });
    
    jQuery('#aiomatic_delete_selected_templates').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete selected OmniBlock templates?'))
        {
            unsaved = false;
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var ids = [];
            jQuery('.aiomatic-select-omni-template:checked').each(function (idx, item) {
                ids.push(jQuery(item).val())
            });
            if (ids.length) {
                var data = {
                    action: 'aiomatic_delete_selected_templates',
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
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing OmniBlock templates removal: ' + error);
                    }
                });
            } else {
                alert('No OmniBlock templates selected');
                aiomaticRmLoading(btn);
            }
        }
    });
    jQuery('#aiomatic_delete_selected_files').on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to delete selected OmniBlock files?'))
        {
            unsaved = false;
            var btn = jQuery(this);
            aiomaticLoading2(btn);
            var ids = [];
            jQuery('.aiomatic-select-omni-file:checked').each(function (idx, item) {
                ids.push(jQuery(item).val())
            });
            if (ids.length) {
                var data = {
                    action: 'aiomatic_delete_selected_files',
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
                            location.reload();
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (r, s, error){
                        aiomaticRmLoading(btn);
                        alert('Error in processing OmniBlock files removal: ' + error);
                    }
                });
            } else {
                alert('No OmniBlock files selected');
                aiomaticRmLoading(btn);
            }
        }
    });
    var aiomatic_omni_button = jQuery('#aiomatic_omni_button');
    aiomatic_omni_button.on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to load OmniBlock Templates from file?'))
        {
            unsaved = false;
            var aiomatic_omni_upload = jQuery('#aiomatic_omni_upload');
            if(jQuery("#aiomatic_overwrite").is(':checked'))
            {
                var overwrite = '1';
            }
            else
            {
                var overwrite = '0';
            }
            if(aiomatic_omni_upload[0].files.length === 0){
                alert('Please select a file!');
            }
            else{
                var aiomatic_progress = jQuery('.aiomatic_progress');
                var aiomatic_error_message = jQuery('.aiomatic-error-msg');
                var aiomatic_upload_success = jQuery('.aiomatic_upload_success');
                var aiomatic_max_file_size = aiomatic_object.maxfilesize;
                var aiomatic_max_size_in_mb = aiomatic_object.maxfilesize / (1024 ** 2);
                var aiomatic_omni_file = aiomatic_omni_upload[0].files[0];
                var aiomatic_omni_file_extension = aiomatic_omni_file.name.substr( (aiomatic_omni_file.name.lastIndexOf('.') +1) );
                if(aiomatic_omni_file_extension !== 'json'){
                    aiomatic_omni_upload.val('');
                    alert('This feature only accepts JSON file type!');
                }
                else if(aiomatic_omni_file.size > aiomatic_max_file_size){
                    aiomatic_omni_upload.val('');
                    alert('Dataset allowed maximum size (MB): '+ aiomatic_max_size_in_mb)
                }
                else{
                    var formData = new FormData();
                    formData.append('action', 'aiomatic_omni_upload');
                    formData.append('nonce', aiomatic_object.nonce);
                    formData.append('overwrite', overwrite);
                    formData.append('file', aiomatic_omni_file);
                    jQuery.ajax({
                        url: aiomatic_object.ajax_url,
                        type: 'POST',
                        dataType: 'JSON',
                        data: formData,
                        beforeSend: function (){
                            aiomatic_progress.find('span').css('width','0');
                            aiomatic_progress.show();
                            aiomaticLoading2(aiomatic_omni_button);
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
                                aiomaticRmLoading(aiomatic_omni_button);
                                aiomatic_progress.hide();
                                aiomatic_omni_upload.val('');
                                aiomatic_upload_success.show();
                                location.reload();
                            }
                            else{
                                aiomaticRmLoading(aiomatic_omni_button);
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
                            aiomatic_omni_upload.val('');
                            aiomaticRmLoading(aiomatic_omni_button);
                            aiomatic_progress.addClass('aiomatic_error');
                            aiomatic_progress.find('small').html('Error');
                            alert('Error in processing templates uploading: ' + error);
                            aiomatic_error_message.show();
                        }
                    });
                }
            }
        }
    });
    jQuery("#checkedAll").on('change', function() {
        if (this.checked) {
            jQuery(".aiomatic-select-omni-template").each(function() {
                this.checked=true;
            });
        } else {
            jQuery(".aiomatic-select-omni-template").each(function() {
                this.checked=false;
            });
        }
    });
    jQuery("#checkedAllFiles").on('change', function() {
        if (this.checked) {
            jQuery(".aiomatic-select-omni-file").each(function() {
                this.checked=true;
            });
        } else {
            jQuery(".aiomatic-select-omni-file").each(function() {
                this.checked=false;
            });
        }
    });

    jQuery(document).on('change','.omni_select_template', function (e)
    {
        var confirm_delete = confirm('Are you sure you want to load this template and overwrite the current OmniBlocks for this rule?');
        if (confirm_delete) {
            var selval = jQuery(this).val();
            var formid = jQuery(this).attr('data-id');
            if(selval != '')
            {
                jQuery.ajax({
                    url: aiomatic_ajax_object.ajax_url,
                    data: {action: 'aiomatic_get_template_data', id: selval, formid: formid, nonce: aiomatic_ajax_object.nonce},
                    type: 'POST',
                    success: function (res) {
                        if (res.status !== 'success') 
                        {
                            alert('Error in processing: ' + JSON.stringify(res));
                        }
                        else
                        {
                            if(res.status === 'success')
                            {
                                jQuery('#sortable_cards' + formid).val(res.msg);
                                jQuery('#btnSubmit').click();
                            }
                        }
                    },
                    error: function (r, s, error) {
                        alert('Error in processing template sync: ' + error);
                    }
                });
            }
        }
    });
    jQuery(document).on('change','.omni_select_template_cat', function (e)
    {
        var selval = jQuery(this).val();
        var formid = jQuery(this).attr('data-id');
        if(selval !== null)
        {
            jQuery.ajax({
                url: aiomatic_ajax_object.ajax_url,
                data: {action: 'aiomatic_get_template_cat_data', id: selval, nonce: aiomatic_ajax_object.nonce},
                type: 'POST',
                success: function (res) {
                    if (res.status !== 'success') 
                    {
                        alert('Error in processing: ' + JSON.stringify(res));
                    }
                    else
                    {
                        if(res.status === 'success')
                        {
                            var selectme = jQuery('#omni_select_template' + formid);
                            selectme.empty();
                            if (Array.isArray(res.msg) && res.msg.length === 0) 
                            {
                                selectme.append($('<option/>', {
                                    value: "",
                                    text: "No templates to list",
                                    disabled: true,
                                    selected: true
                                }));
                            }
                            else
                            {
                                selectme.append($('<option/>', {
                                    value: "",
                                    text: "Select a template",
                                    disabled: true,
                                    selected: true
                                }));
                            }
                            $.each(res.msg, function(index, value) 
                            {
                                var newOption = $('<option/>', {
                                    value: index,
                                    text : value
                                });
                                selectme.append(newOption);
                            });
                        }
                    }
                },
                error: function (r, s, error) {
                    alert('Error in processing template category sync: ' + error);
                }
            });
        }
    });
    jQuery(".aiomatic_duplicate_omni_template").on('click', function(e) {
        e.preventDefault();
        unsaved = false;
        if(confirm('Are you sure you want to duplicate this OmniBlock template?'))
        {
            var id = jQuery(this).attr("dup-id");
            if(id == '')
            {
                alert('Incorrect duplicate id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_duplicate_omni_template',
                    id: id,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticLoading2(jQuery('#aiomatic_duplicate_omni_template_' + id));
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
                        alert('Error in processing OmniBlock template duplication: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    jQuery(".aiomatic_delete_omni_template").on('click', function(e) {
        e.preventDefault();
        unsaved = false;
        if(confirm('Are you sure you want to delete this OmniBlock Template?'))
        {
            var id = jQuery(this).attr("delete-id");
            if(id == '')
            {
                alert('Incorrect delete id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_delete_omni_template',
                    id: id,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticLoading2(jQuery('#aiomatic_delete_omni_template_' + id));
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
                        alert('Error in processing OmniBlock Template deletion: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    jQuery(".aiomatic_delete_omni_file").on('click', function(e) {
        e.preventDefault();
        unsaved = false;
        if(confirm('Are you sure you want to delete this OmniBlock File?'))
        {
            var id = jQuery(this).attr("delete-id");
            if(id == '')
            {
                alert('Incorrect delete id submitted');
            }
            else
            {
                e.preventDefault();
                var data = {
                    action: 'aiomatic_delete_omni_file',
                    id: id,
                    nonce: aiomatic_object.nonce,
                };
                jQuery.ajax({
                    url: aiomatic_object.ajax_url,
                    data: data,
                    dataType: 'JSON',
                    type: 'POST',
                    beforeSend: function (){
                        aiomaticLoading2(jQuery('#aiomatic_delete_omni_file_' + id));
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
                        alert('Error in processing OmniBlock Template deletion: ' + error);
                        location.reload();
                    }
                });
            }
        }
    });
    var aiomatic_omni_buttonx = jQuery('#aiomatic_omni_default_button');
    aiomatic_omni_buttonx.on('click', function (e){
        e.preventDefault();
        if(confirm('Are you sure you want to load the default OmniBlock Templates which come bundled with the plugin?'))
        {
            unsaved = false;
            var data = {
                action: 'aiomatic_default_omni',
                nonce: aiomatic_object.nonce,
            };
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading2(jQuery('#aiomatic_omni_default_button'));
                },
                success: function (res){
                    if(res.status === 'success'){
                        alert('Default OmniBlock Templates loaded successfully!');
                        location.reload();
                    }
                    else{
                        alert(res.msg);
                        location.reload();
                    }
                },
                error: function (r, s, error){
                    alert('Error in processing OmniBlock Template loading: ' + error);
                    location.reload();
                }
            });
        }
    });
    var mainCardOrder = $('#aiomatic_sortable_cards');
    if(mainCardOrder !== undefined)
    {
        if (typeof jQuery.fn.sortable !== 'undefined') 
        {
            mainCardOrder.sortable({
                update: function(event, ui) {
                    unsaved = true;
                    updateSortableInputAI('', '');
                    updateCardSteps('');
                },
                stop: function(event, ui) {
                    updateSortableInputAI('', '');
                    updateCardSteps('');
                },
                receive: function(event, ui) {
                    unsaved = true;
                    $('#aiomatic_sortable_cards .delete-btn').prop('disabled', false);
                    $('#aiomatic_sortable_cards .move-up-btn').prop('disabled', false);
                    $('#aiomatic_sortable_cards .move-down-btn').prop('disabled', false);
                    updateCardSteps('');
                },
                scroll: true,
                scrollSensitivity: 100, 
                scrollSpeed: 10,
                cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
            });
        }
        jQuery('#aiomatic_sortable_cards').on('change input', 'input, textarea, select', function() {
            updateSortableInputAI('', '');
        });
        jQuery(document).on('click','#aiomatic_sortable_cards button', function (e)
        {
            setTimeout(function() {
                updateSortableInputAI('', '');
                updateCardSteps('');
            }, 100);
        });
    }
    else
    {
        console.log('Error, aiomatic_sortable_cards input not found!');
    }
    var mainCardOrder_new = $('#aiomatic_sortable_cards_new');
    if(mainCardOrder_new !== undefined)
    {
        if (typeof jQuery.fn.sortable !== 'undefined') 
        {
            mainCardOrder_new.sortable({
                update: function(event, ui) {
                    unsaved = true;
                    updateSortableInputAI('', '_new');
                    updateCardSteps('');
                },
                stop: function(event, ui) {
                    updateSortableInputAI('', '_new');
                    updateCardSteps('');
                },
                receive: function(event, ui) {
                    unsaved = true;
                    $('#aiomatic_sortable_cards_new .delete-btn').prop('disabled', false);
                    $('#aiomatic_sortable_cards_new .move-up-btn_new').prop('disabled', false);
                    $('#aiomatic_sortable_cards_new .move-down-btn_new').prop('disabled', false);
                    updateCardSteps('');
                },
                scroll: true,
                scrollSensitivity: 100, 
                scrollSpeed: 10,
                cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
            });
        }
        jQuery('#aiomatic_sortable_cards_new').on('change input', 'input, textarea, select', function() {
            updateSortableInputAI('', '_new');
        });
        jQuery(document).on('click','#aiomatic_sortable_cards_new button', function (e)
        {
            setTimeout(function() {
                updateSortableInputAI('', '_new');
                updateCardSteps('');
            }, 100);
        });
    }
    else
    {
        console.log('Error, aiomatic_sortable_cards_new input not found!');
    }
    if (typeof jQuery.fn.draggable !== 'undefined') 
    {
        jQuery('#aiomatic_new_card_types .new-card').draggable({
            helper: function() {
                unsaved = true;
                var cloned = jQuery(this).clone(true);
                jQuery('.omniblock-card').removeClass('selected');
                cloned.removeAttr('id');
                var clonedHtml = cloned.prop('outerHTML');
                var idMap = {};
                var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
                    return replaceId(match, idMap);
                });
                var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
                    return replaceDataId(match, idMap);
                });
                cloned = jQuery(newHtml);
                jQuery(this).find('input, textarea, select').each(function(index) {
                    var index = jQuery(this).attr('data-clone-index');
                    if(index != null && index != '' && index != undefined)
                    {
                        var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                        if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                            clonedElement.prop('checked', jQuery(this).is(':checked'));
                        } else {
                            clonedElement.val(jQuery(this).val());
                        }
                    }
                });
                return cloned.appendTo('#aiomatic_sortable_cards').show();
            }, 
            connectToSortable: '#aiomatic_sortable_cards', 
            revert: 'invalid',
            appendTo: '#aiomatic_sortable_cards',
            scroll: true,
            cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
        });
        jQuery('#aiomatic_new_card_types_new .new-card').draggable({
            helper: function() {
                unsaved = true;
                var cloned = jQuery(this).clone(true);
                jQuery('.omniblock-card').removeClass('selected');
                cloned.removeAttr('id');
                var clonedHtml = cloned.prop('outerHTML');
                var idMap = {};
                var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
                    return replaceId(match, idMap);
                });
                var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
                    return replaceDataId(match, idMap);
                });
                cloned = jQuery(newHtml);
                jQuery(this).find('input, textarea, select').each(function(index) {
                    var index = jQuery(this).attr('data-clone-index');
                    if(index != null && index != '' && index != undefined)
                    {
                        var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                        if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                            clonedElement.prop('checked', jQuery(this).is(':checked'));
                        } else {
                            clonedElement.val(jQuery(this).val());
                        }
                    }
                });
                return cloned.appendTo('#aiomatic_sortable_cards_new').show();
            }, 
            connectToSortable: '#aiomatic_sortable_cards_new', 
            revert: 'invalid',
            appendTo: '#aiomatic_sortable_cards_new',
            scroll: true,
            cancel: ':input,option,.disable_drag,.aishortcodes,.aiomatic-run-now'
        });
    }
    jQuery.aiomatic_iframe = function() {
        jQuery('body').prepend('<div class="aiomatic_iframe__overlay"><div class="aiomatic_iframe__centerWrap"><div class="aiomatic_iframe__centerer"><div class="aiomatic_iframe__contentWrap" style="background: url(https://1.bp.blogspot.com/-vIHeaMvTAts/XOsDjqTD0jI/AAAAAAAAAx4/SRvufVxlRwYufBlZVmWUYng_dhW0rs2OwCLcBGAs/s1600/loading.gif) no-repeat center"><div class="aiomatic_iframe__scaleWrap" style="visibility: hidden;"><div class="aiomatic_iframe__closeBtn"><p>x</p></div>');
    };
    jQuery(document).on('click','.aisavetemplate', function (e)
    {
        e.preventDefault();
        if(confirm('Are you sure you want to save the configured OmniBlock template?'))
        {
            var index = jQuery(this).attr('data-id');
            if(index != null && index != undefined)
            {
                var sc = jQuery('#sortable_cards' + index);
                if(sc !== null)
                {
                    sc = sc.val();
                    let tmpname = window.prompt("Please enter the name of the new template:", "Template 1");
                    if (tmpname != null && tmpname != "") 
                    {
                        let tmpcat = window.prompt("Please enter a category for the new template:", "new");
                        if (tmpcat === null) 
                        {
                            tmpcat = '';
                        }
                        var data = {
                            action: 'aiomatic_save_omni_template',
                            nonce: aiomatic_object.nonce,
                            omni_template_new: tmpname,
                            omni_template_cat_new: tmpcat,
                            sortable_cards_new: sc
                        };
                        jQuery.ajax({
                            url: aiomatic_object.ajax_url,
                            data: data,
                            dataType: 'JSON',
                            type: 'POST',
                            success: function (res){
                                if(res.status === 'success'){
                                    alert('Template saved successfully')
                                }
                                else{
                                    alert(res.msg);
                                }
                            },
                            error: function (r, s, error){
                                alert('Error in processing OmniBlock templates saving: ' + error);
                            }
                        });
                    }
                }
                else
                {
                    console.log('sortable_cards not found!');
                }
            }
            else
            {
                console.log('data-id not found!');
            }
        }
    });
    function getPathTo(element) {
        if (element.id !== '') {
            if (element.id != 'aiomatic_container') {
                var res = element.id;
                res = res.replace('/\\/g', "");
                res = res.replace('/"/g', "");
                res = res.replace('/\'/g', "");
                return "//*[@id='" + res + "']";
            } else {
                return '//body/*';
            }
        }
        var res = element.className;
        if (res !== '' && res != 'highlight') {
            res = res.replace('highlight ', "");
            res = res.replace(' highlight ', " ");
            res = res.replace(' highlight', "");
            res = res.replace('/\\/g', "");
            res = res.replace('/"/g', "");
            res = res.replace('/\'/g', "");
            if (res !== '' && res != ' ') {
                res = jQuery.trim(res);
                if (res == '') {
                    return aiomatic_get_tree_xpath(element);
                }
                return "//*[@class='" + res + "']";
            }
        }
        var itempropz = element.getAttribute("itemprop");
        if (itempropz !== '' && itempropz !== null) {
            return "//*[@itemprop='" + itempropz + "']";
        }
        if (element === document.body) {
            return '//body/*';
        }
        return getPathTo(element.parentNode);
    }
    function aiomatic_get_tree_xpath(element) {
        var paths = [];
        for (; element && element.nodeType == Node.ELEMENT_NODE; element = element.parentNode) {
            var index = 0;
            var moreSiblings = false;
            for (var sibling = element.previousSibling; sibling; sibling = sibling.previousSibling) {
                if (sibling.nodeType == Node.DOCUMENT_TYPE_NODE)
                    continue;
    
                if (sibling.nodeName == element.nodeName)
                    ++index;
            }
    
            for (var sibling = element.nextSibling; sibling && !moreSiblings; sibling = sibling.nextSibling) {
                if (sibling.nodeName == element.nodeName)
                    moreSiblings = true;
            }
    
            var tagName = (element.prefix ? element.prefix + ":" : "") + element.localName;
            var pathIndex = (index || moreSiblings ? "[" + (index + 1) + "]" : "");
            if (element.id && !(element.id.match(/[0-9]+/))) {
                tagName = "/*";
                pathIndex = '[@id="' + element.id + '"]';
            };
    
            paths.splice(0, 0, tagName + pathIndex);
    
            if (element.id && !(element.id.match(/[0-9]+/))) {
                break;
            }
    
        }
    
        return paths.length ? "/" + paths.join("/") : null;
    };
    jQuery(document).on('change','.scraper_selector', function (e)
    {
        e.preventDefault();
        var selvalue = jQuery(this).val();
        if (selvalue != 'visual') {
            return;
        }
        var mySrc = '';
        if (jQuery(this).attr('data-source-field-id') != '') {
            mySrc = jQuery('*[class*="' + jQuery(this).attr('data-source-field-id') + '"]').val();
			mySrc = mySrc.split("\n");
            mySrc = mySrc[Math.floor(Math.random() * mySrc.length)];
        }
        var myID = '';
        if (jQuery(this).attr('data-id-str') != '') {
            myID = jQuery(this).attr('data-id-str');
        }
        var myDest = '';
        if (jQuery(this).attr('data-target-field-id') != '') {
            myDest = jQuery(this).attr('data-target-field-id');
        }
        if (myDest == '') {
            return;
        }
        if (mySrc === undefined || mySrc.indexOf('http') == -1) 
        {
            alert('You did not enter a valid crawling start URL (in the "Scraper Start (Seed) URL" settings field)');
            return;
        }
        var crawlCookie = '';
        var htuser = '';
        var phantom_wait = '';
        var clickelement = '';
        var customUA = '';
        var scripter = '';
        var request_delay = '';
        var local_storage = '';
        var enable_adblock = '0';
        var auto_captcha = '0';
        var usephantom = jQuery('#sc' + myDest).val();
        var iframeUrl = aiomatic_ajax_object.ajax_url + '?action=aiomatic_iframe&nonce=' + aiomatic_ajax_object.nonce + '&address=' + encodeURIComponent(mySrc);
        if (crawlCookie != '') {
            iframeUrl += '&crawlCookie=' + encodeURIComponent(crawlCookie);
        }
        if (clickelement != '') {
            iframeUrl += '&clickelement=' + encodeURIComponent(clickelement);
        }
        if (usephantom != '') {
            iframeUrl += '&usephantom=' + encodeURIComponent(usephantom);
        }
        if (customUA != '') {
            iframeUrl += '&customUA=' + encodeURIComponent(customUA);
        }
        if (htuser != '') {
            iframeUrl += '&htuser=' + encodeURIComponent(htuser);
        }
        if (phantom_wait != '') {
            iframeUrl += '&phantom_wait=' + encodeURIComponent(phantom_wait);
        }
        if (request_delay != '') {
            iframeUrl += '&request_delay=' + encodeURIComponent(request_delay);
        }
        if (scripter != '') {
            iframeUrl += '&scripter=' + encodeURIComponent(scripter);
        }
        if (local_storage != '') {
            iframeUrl += '&local_storage=' + encodeURIComponent(local_storage);
        }
        if (enable_adblock == '1') {
            iframeUrl += '&enable_adblock=1';
        }
        if (auto_captcha == '1') {
            iframeUrl += '&auto_captcha=1';
        }
        $('.aiomatic_iframe__overlay .aiomatic_iframe__scaleWrap').append('<iframe id="cr_page_frame" src="' + iframeUrl + '">');

        $('.aiomatic_iframe__overlay').fadeIn(750);
        $("#cr_page_frame").on("load", function() {

            $('.aiomatic_iframe__scaleWrap').css('visibility', 'visible');
            var prev;
            var doc = document.getElementById("cr_page_frame").contentDocument;
            doc.body.onmouseover = handler;

            function handler(event) {

                if (event.target === doc.body ||
                    (prev && prev === event.target)) {
                    return;
                }
                if (prev instanceof SVGElement) {
                    prev.classList.remove('highlight'); 
                    prev = undefined;
                } else if (prev && prev.className) {
                    prev.className = prev.className.replace(/\bhighlight\b/, '');
                    prev = undefined;
                }
                if (event.target) {
                    prev = event.target;
                    if (prev instanceof SVGElement) {
                        prev.classList.add('highlight'); 
                    } else {
                        prev.className += " highlight";
                    }
                }
            }
            $("#cr_page_frame").contents().find("body *").on('click', function() {
                if (jQuery(this).hasClass('highlight')) {
                    var xpathval = '';
                    var element = $(this)[0];
                    if (element && element.id && !(element.id.match(/[0-9]+/)))
                        xpathval = "//*[@id='" + element.id + "']";
                    else
                        xpathval = getPathTo(element);
                    jQuery('#st' + myDest).val(xpathval);
                    updateSortableInputAI(myID, '');
                    $('.aiomatic_iframe__overlay').fadeOut(750, function() {
                        $(this).find('iframe').remove();
                        jQuery('.aiomatic_iframe__scaleWrap').css('visibility', 'hidden');
                    });

                    return false;

                }


            });
        });

        $('.aiomatic_iframe__overlay iframe').on('click', function(e) {
            e.stopPropagation();
        });

        $('.aiomatic_iframe__overlay').on('click', function(e) {
            e.preventDefault();
            $('.aiomatic_iframe__overlay').fadeOut(750, function() {
                $(this).find('iframe').remove();
                jQuery('.aiomatic_iframe__scaleWrap').css('visibility', 'hidden');
            });
        });
    }); 
    jQuery.aiomatic_iframe();
    jQuery(document).on('click','.delete-btn', function (e)
    {
        e.preventDefault();
        unsaved = true;
        var list = jQuery(this).closest('ul');
        if (list.children('li').length > 1) {
            var li = e.target.closest('li');
            li.parentNode.removeChild(li);
        }
        else
        {
            alert("You cannot delete the last element.");
        }
    });
    jQuery(document).on('click','#add-new-btn', function (e)
    {
        e.preventDefault();
        unsaved = true;
        var cloned = jQuery('#aiomatic_new_card_types li:visible').clone(true);
        cloned.removeAttr('id');
        var clonedHtml = cloned.prop('outerHTML');
        var idMap = {};
        var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
            return replaceId(match, idMap);
        });
        var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
            return replaceDataId(match, idMap);
        });
        cloned = jQuery(newHtml);
        if (cloned.hasClass('selected')) {
            cloned.removeClass('selected');
        }
        jQuery('#aiomatic_new_card_types li:visible').find('input, textarea, select').each(function(index) {
            var index = jQuery(this).attr('data-clone-index');
            if(index != null && index != '' && index != undefined)
            {
                var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                    clonedElement.prop('checked', jQuery(this).is(':checked'));
                } else {
                    clonedElement.val(jQuery(this).val());
                }
            }
        });
        var retme = cloned.appendTo('#aiomatic_sortable_cards').show();
        updateSortableInputAI('', '');
        $('#aiomatic_sortable_cards .delete-btn').prop('disabled', false);
        $('#aiomatic_sortable_cards .move-up-btn').prop('disabled', false);
        $('#aiomatic_sortable_cards .move-down-btn').prop('disabled', false);
        updateCardSteps('');
        return retme;
    });
    jQuery(document).on('click','#add-new-btn_new', function (e)
    {
        e.preventDefault();
        unsaved = true;
        var cloned = jQuery('#aiomatic_new_card_types_new li:visible').clone(true);
        cloned.removeAttr('id');
        var clonedHtml = cloned.prop('outerHTML');
        var idMap = {};
        var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
            return replaceId(match, idMap);
        });
        var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
            return replaceDataId(match, idMap);
        });
        cloned = jQuery(newHtml);
        if (cloned.hasClass('selected')) {
            cloned.removeClass('selected');
        }
        jQuery('#aiomatic_new_card_types_new li:visible').find('input, textarea, select').each(function(index) {
            var index = jQuery(this).attr('data-clone-index');
            if(index != null && index != '' && index != undefined)
            {
                var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                    clonedElement.prop('checked', jQuery(this).is(':checked'));
                } else {
                    clonedElement.val(jQuery(this).val());
                }
            }
        });
        var retme = cloned.appendTo('#aiomatic_sortable_cards_new').show();
        updateSortableInputAI('', '_new');
        $('#aiomatic_sortable_cards_new .delete-btn').prop('disabled', false);
        $('#aiomatic_sortable_cards_new .move-up-btn_new').prop('disabled', false);
        $('#aiomatic_sortable_cards_new .move-down-btn_new').prop('disabled', false);
        updateCardSteps('');
        return retme;
    });
    jQuery(document).on('click','#add-new-btn_edit', function (e)
    {
        e.preventDefault();
        unsaved = true;
        var cloned = jQuery('#aiomatic_new_card_types_edit li:visible').clone(true);
        cloned.removeAttr('id');
        var clonedHtml = cloned.prop('outerHTML');
        var idMap = {};
        var midHtml = clonedHtml.replace(/id="xai[0-9a-f]+"/g, function(match) {
            return replaceId(match, idMap);
        });
        var newHtml = midHtml.replace(/data-id-str="xai[0-9a-f]+"/g, function(match) {
            return replaceDataId(match, idMap);
        });
        cloned = jQuery(newHtml);
        if (cloned.hasClass('selected')) {
            cloned.removeClass('selected');
        }
        jQuery('#aiomatic_new_card_types_edit li:visible').find('input, textarea, select').each(function(index) {
            var index = jQuery(this).attr('data-clone-index');
            if(index != null && index != '' && index != undefined)
            {
                var clonedElement = cloned.find('[data-clone-index="' + index + '"]');
                if (jQuery(this).is(':checkbox') || jQuery(this).is(':radio')) {
                    clonedElement.prop('checked', jQuery(this).is(':checked'));
                } else {
                    clonedElement.val(jQuery(this).val());
                }
            }
        });
        var retme = cloned.appendTo('#aiomatic_sortable_cards_edit').show();
        updateSortableInputAI('', '_edit');
        $('#aiomatic_sortable_cards_edit .delete-btn').prop('disabled', false);
        $('#aiomatic_sortable_cards_edit .move-up-btn_edit').prop('disabled', false);
        $('#aiomatic_sortable_cards_edit .move-down-btn_edit').prop('disabled', false);
        updateCardSteps('');
        return retme;
    });
    jQuery(document).on('click','.move-up-btn', function (e)
    {
        e.preventDefault();
        unsaved = true;
        var currentLi = e.target.closest('li');
        var customID = currentLi.getAttribute("data-id-str");
        var prevLi = currentLi.previousElementSibling;
        if (prevLi) {
            var sortableList = document.getElementById('aiomatic_sortable_cards' + customID);
            sortableList.insertBefore(currentLi, prevLi);
        }
    });
    jQuery(document).on('click','.move-up-btn_new', function (e)
    {
        e.preventDefault();
        var currentLi = e.target.closest('li');
        var customID = currentLi.getAttribute("data-id-str");
        var prevLi = currentLi.previousElementSibling;
        if (prevLi) {
            var sortableList = document.getElementById('aiomatic_sortable_cards_new' + customID);
            sortableList.insertBefore(currentLi, prevLi);
        }
    });
    jQuery(document).on('click','.move-up-btn_edit', function (e)
    {
        e.preventDefault();
        var currentLi = e.target.closest('li');
        var customID = currentLi.getAttribute("data-id-str");
        var prevLi = currentLi.previousElementSibling;
        if (prevLi) {
            var sortableList = document.getElementById('aiomatic_sortable_cards_edit' + customID);
            sortableList.insertBefore(currentLi, prevLi);
        }
    });
    jQuery(document).on('click','.move-down-btn', function (e)
    {
        e.preventDefault();
        unsaved = true;
        var currentLi = e.target.closest('li');
        var customID = currentLi.getAttribute("data-id-str");
        var nextLi = currentLi.nextElementSibling;
        if (nextLi) {
            var sortableList = document.getElementById('aiomatic_sortable_cards' + customID);
            sortableList.insertBefore(nextLi, currentLi);
        }
    });
    jQuery(document).on('click','.move-down-btn_new', function (e)
    {
        e.preventDefault();
        var currentLi = e.target.closest('li');
        var customID = currentLi.getAttribute("data-id-str");
        var nextLi = currentLi.nextElementSibling;
        if (nextLi) {
            var sortableList = document.getElementById('aiomatic_sortable_cards_new' + customID);
            sortableList.insertBefore(nextLi, currentLi);
        }
    });
    jQuery(document).on('click','.move-down-btn_edit', function (e)
    {
        e.preventDefault();
        var currentLi = e.target.closest('li');
        var customID = currentLi.getAttribute("data-id-str");
        var nextLi = currentLi.nextElementSibling;
        if (nextLi) {
            var sortableList = document.getElementById('aiomatic_sortable_cards_edit' + customID);
            sortableList.insertBefore(nextLi, currentLi);
        }
    });
    jQuery(document).on('mousedown','.omniblock-card', function (e) {
        if (jQuery(e.target).closest('button').length) {
            return;
        }
        if (jQuery(this).hasClass('selected')) {
            jQuery('.omniblock-card').removeClass('selected');
        } else {
            jQuery('.omniblock-card').removeClass('selected');
            jQuery(this).addClass('selected');
        }
    });
    jQuery(document).on('click','textarea, input[type="text"], input[type="number"], input[type="url"]', function() 
    {
        jQuery(document).data('aiLastFocused', jQuery(this).attr('id'));
    });
    jQuery(document).on('click','.aicollapsible', function (e)
    {
        e.preventDefault();
        if (jQuery(this).hasClass('selected')) {
            jQuery(this).removeClass('selected');
        } else {
            jQuery(this).addClass('selected');
        }
        $(this).closest('.omniblock-card').find('.aicollapsible-parameters').toggle();
    });
    jQuery(document).on('click','.aishortcodes', function (e)
    {
        e.preventDefault();
        var textToAppend = jQuery(this).text();
        var idToUse = jQuery(this).attr("data-id-str");
        var i = jQuery(this).attr("data-index");
        var datasuf = jQuery(this).attr("data-suff");
        if(datasuf == '' || datasuf == undefined || datasuf == null)
        {
            datasuf = '';
        }
        if(idToUse !== undefined)
        {
            var parentCard = jQuery('#' + idToUse);
            if(parentCard !== undefined)
            {
                var lastFocusedId = jQuery(document).data('aiLastFocused');
                if (lastFocusedId == idToUse) 
                {
                    var currentVal = parentCard.val();
                    var startPos = parentCard[0].selectionStart;
                    var endPos = parentCard[0].selectionEnd;
                    var textBefore = currentVal.substring(0, startPos);
                    var textAfter = currentVal.substring(endPos);
                    parentCard.val(textBefore + textToAppend + textAfter);
                    var newCursorPos = startPos + textToAppend.length;
                    parentCard[0].setSelectionRange(newCursorPos, newCursorPos);
                }
                else
                {
                    parentCard.val(parentCard.val() + textToAppend);
                }
                if(i !== undefined)
                {
                    updateSortableInputAI(i, datasuf);
                }
            }
        }
    });
});
function replaceId(match, idMap) 
{
    var originalId = match.slice(4, -1);
    if (!idMap[originalId]) {
        idMap[originalId] = 'xai' + jsuniqid();
    }
    return 'id="' + idMap[originalId] + '"';
}
function replaceDataId(match, idMap) 
{
    var originalDataId = match.slice(13, -1);
    if (!idMap[originalDataId]) {
        idMap[originalDataId] = 'xai' + jsuniqid();
    }
    return 'data-id-str="' + idMap[originalDataId] + '"';
}
function aiBlockTypeChangeHandler(i)
{
    const listItems = document.querySelectorAll('#aiomatic_new_card_types' + i + ' > li');
    listItems.forEach(listItem => {
        listItem.style.display = 'none';
    });
    jQuery('.omniblock-card new-card').hide();
    var omni_select_block_type = jQuery('#omni_select_block_type' + i).val();
    jQuery('#' + omni_select_block_type + i).show();
}
function aiBlockTypeChangeHandler_new(i)
{
    const listItems = document.querySelectorAll('#aiomatic_new_card_types_new' + i + ' > li');
    listItems.forEach(listItem => {
        listItem.style.display = 'none';
    });
    jQuery('.omniblock-card new-card').hide();
    var omni_select_block_type = jQuery('#omni_select_block_type_new' + i).val();
    jQuery('#' + omni_select_block_type + i + '_new').show();
}
function aiBlockTypeChangeHandler_edit(i)
{
    const listItems = document.querySelectorAll('#aiomatic_new_card_types_edit' + i + ' > li');
    listItems.forEach(listItem => {
        listItem.style.display = 'none';
    });
    jQuery('.omniblock-card new-card').hide();
    var omni_select_block_type = jQuery('#omni_select_block_type_edit' + i).val();
    jQuery('#' + omni_select_block_type + i + '_edit').show();
}
function updateCardSteps(i) {
    jQuery('#aiomatic_sortable_cards' + i + ' > li').each(function(index) 
    {
        jQuery(this).find('.step-number').text('Step ' + (index + 1));
    });
}
function jsuniqid(prefix = '', moreEntropy = false) 
{
    const time = new Date().getTime();
    const randomPortion = Math.floor(Math.random() * 1000000);
    let uniqid = prefix + time.toString(16) + randomPortion.toString(16);
    if (moreEntropy) {
      const extraRandomPortion = Math.floor(Math.random() * 1000000);
      uniqid += extraRandomPortion.toString(16);
    }
    return uniqid;
}
function aiomatic_increment(string) {
    let lastChar = string.charAt(string.length - 1);
    let rest = string.substring(0, string.length - 1);
    let next;
    switch (lastChar) 
    {
        case '':
            next = 'a';
            break;
        case 'z':
            next = 'A';
            break;
        case 'Z':
            next = '0';
            break;
        case '9':
            rest = aiomatic_increment(rest);
            next = 'a';
            break;
        default:
            next = String.fromCharCode(lastChar.charCodeAt(0) + 1);
    }
    return rest + next;
}