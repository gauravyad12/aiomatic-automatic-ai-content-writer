"use strict";
function aiomatic_uniq_fast(a) 
{
    var seen = {};
    var out = [];
    var len = a.length;
    var j = 0;
    for(var i = 0; i < len; i++) {
        var item = a[i];
        var jsit = JSON.stringify(item);
        if(seen[jsit] !== 1) {
              seen[jsit] = 1;
              out[j++] = item;
        }
    }
    return out;
}
(function() {
    let menu = [];
    tinymce.create("tinymce.plugins.aiomatic_editor", {
        init : function(ed, url) { 
            if ("object" == typeof aiomatic && "object" == typeof aiomatic.prompts)
            {
                for (let operation in aiomatic.prompts) 
                {
                    let prompt = aiomatic.prompts[operation];
                    let icon = 'text';
                    let thumb = 'toc';
                    if(prompt[1] == 'image')
                    {
                        icon = 'format-image';
                        thumb = 'image';
                    }
                    menu.push({
                        text: operation,
                        classes: 'aiomatic-classic-button',
                        icon: thumb,
                        onclick: async function () {
                            ed = tinymce.activeEditor;
                            let selectedText = ed.selection.getContent({format: 'text'});
                            let send_prompt = prompt[0].replace('%%selected_text%%', selectedText);
                            if(send_prompt.includes('%%'))
                            {
                                var pid = document.getElementById('post_ID');
                                if(pid !== undefined && pid !== null && pid != '')
                                {
                                    var postId = pid.value;
                                    const ajaxurl = aiomatic.ajaxurl;
                                    const nonce = aiomatic.nonce;
                                    const xdata = new FormData();
                                    xdata.append( 'postId', postId );
                                    xdata.append( 'nonce', nonce );
                                    xdata.append( 'send_prompt', send_prompt );
                                    xdata.append( 'action', 'aiomatic_shortcode_replacer' );
                                    const response = await fetch(ajaxurl, {
                                        method: 'POST',
                                        body: xdata
                                    }).catch(async error => {
                                        console.log('An exception occurred: ' + error.text());
                                    })

                                    if (!response.ok) 
                                    {
                                        console.log('An error occurred: ' + response.text());
                                    }
                                    else
                                    {
                                        const ret = await response.json();
                                        if (ret.message !== undefined) {
                                            console.log('A general error occurred: ' + response.text());
                                        }
                                        else
                                        {
                                            send_prompt = ret.data.content;
                                        }
                                    }
                                }
                            }
                            let dom = tinymce.activeEditor.dom;
                            let $ = tinymce.dom.DomQuery;
        
                            const loadingSpinnerId = await aiomatic_classic_addAutocompleteContainer(aiomatic.placement, ed);
        
                            ed.selection.collapse();
                            let spinner = dom.select('#' + loadingSpinnerId);
        
                            let autocompletedText = '';
                            try {
                                if(icon == 'text')
                                {
                                    autocompletedText = await aiomatic_classic_doAutocompleteRequest(send_prompt);
                                    if(autocompletedText === undefined)
                                    {
                                        throw new Error('Failed to generate text!');
                                    }
                                    autocompletedText = autocompletedText.replace(/\n/g, '<br/>');
                                }
                                else
                                {
                                    if(icon == 'format-image')
                                    {
                                        autocompletedText = await aiomatic_classic_doImageRequest(send_prompt);
                                        if(autocompletedText === undefined)
                                        {
                                            throw new Error('Failed to generate text!');
                                        }
                                    }
                                }
                            } catch (error) {
                                $(spinner).remove();
                                alert('An API error occurred with the following response body: \n\n' + error.message);
                                return;
                            }
        
                            $(spinner).removeAttr('class');
                            $(spinner).removeAttr('id');
        
                            $(spinner).html(autocompletedText);
        
                            ed.undoManager.add();
                        }
                    });
                }
                var uniqueMenu = aiomatic_uniq_fast(menu);
                uniqueMenu.forEach((item, index) => {
                    item.id = `menuitem-${index}`;
                });
                ed.addButton("aiomatic", {
                    type: 'menubutton',
                    title : "Aiomatic Content Wizard",
                    tooltip: 'Aiomatic Content Wizard',
                    image: aiomatic.xicon,
                    icon: false,
                    menu: uniqueMenu
                });
            }
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Aiomatic Buttons",
                author : "CodeRevolution",
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add("aiomatic_editor", tinymce.plugins.aiomatic_editor);
})();

const createLoadingSpinner = function (selectedNode, loadingSpinnerId) {
    let spinnersrc = "data:image/gif;base64,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";
    let spinnerHtml = '';
    if (['li'].includes(selectedNode.tagName.toLowerCase())) {
        spinnerHtml = '<' + selectedNode.tagName + ' id="' + loadingSpinnerId + '" class="aiomatic-mce-loading"><img src="' + spinnersrc + '"></' + selectedNode.tagName + '>';
    } else {
        spinnerHtml = '<p id="' + loadingSpinnerId + '" class="aiomatic-mce-loading"><img src="' + spinnersrc + '"></p>';
    }

    return spinnerHtml;
}

const aiomatic_classic_doAutocompleteRequest = async function (text) {
    const ajaxurl = aiomatic.ajaxurl;
    const nonce = aiomatic.nonce;
    const xdata = new FormData();
    xdata.append( 'prompt', text );
    xdata.append( 'nonce', nonce );
    xdata.append( 'action', 'aiomatic_editor' );
    const response = await fetch(ajaxurl, {
        method: 'POST',
        body: xdata
    }).catch(async error => {
        throw new Error(await error.text());
    })

    if (!response.ok) {
        throw new Error(await response.text());
    }

    const ret = await response.json();
    if (ret.message !== undefined) {
        throw new Error(await response.text());
    }
    return ret.data.content;
}

const aiomatic_classic_doImageRequest = async function (text) {
    const ajaxurl = aiomatic.ajaxurl;
    const nonce = aiomatic.nonce;
    const xdata = new FormData();
    xdata.append( 'prompt', text );
    xdata.append( 'nonce', nonce );
    xdata.append( 'action', 'aiomatic_imager' );
    const response = await fetch(ajaxurl, {
        method: 'POST',
        body: xdata
    }).catch(async error => {
        throw new Error(await error.text());
    })

    if (!response.ok) {
        throw new Error(await response.text());
    }

    const ret = await response.json();
    if (ret.message !== undefined) {
        throw new Error(await response.text());
    }
    return ret.data.content;
}
const aiomatic_classic_addAutocompleteContainer = async function (placement, ed) {
    let $ = tinymce.dom.DomQuery;
    const loadingSpinnerId = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

    let selectionRange = ed.selection.getRng();
    if (placement === 'below') {
        let selectedNode = ed.selection.getEnd();

        let spinnerHtml = createLoadingSpinner(
            selectedNode,
            loadingSpinnerId,
        )
        let spinnerDom = $(spinnerHtml)[0];

        let parentNode = selectionRange.endContainer.parentNode;
        if (parentNode.tagName.toLowerCase() === 'li') {
            $(selectedNode).after(spinnerDom);
        } else if (selectedNode.textContent) {
            selectionRange.collapse(false);
            selectionRange.insertNode(spinnerDom);
            ed.selection.collapse();
        } else {
            $(selectedNode).after(spinnerDom);
        }

    } else { 
        let selectedNode = ed.selection.getStart();
        let spinnerHtml = createLoadingSpinner(
            selectedNode,
            loadingSpinnerId,
        )
        let spinnerDom = $(spinnerHtml)[0];

        let parentNode = selectionRange.startContainer.parentNode;
        if (parentNode.tagName.toLowerCase() === 'li') {
            $(selectedNode).before(spinnerDom);
        } else if (selectedNode.textContent) {
            selectionRange.collapse(true);
            selectionRange.insertNode(spinnerDom);
            ed.selection.collapse();
        } else {
            $(selectedNode).before(spinnerDom);
        }
    }

    ed.undoManager.add();

    return loadingSpinnerId;
}