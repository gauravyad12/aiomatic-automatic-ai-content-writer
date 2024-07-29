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
(() => {
	var t, e = {
			401: () => {
				const t = window.wp.element,
					e = window.wp.richText,
					o = window.wp.blockEditor,
					r = window.wp.components;
				async function c() {
					let t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "below",
						e = l(),
						[o, r] = p(e),
						c = r.clientId,
						a = o.clientId,
						n = wp.data.select("core/block-editor").getBlock(c),
						s = '<span id="' + (Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)) + '" class="aiomatic-editor-loading"></span>';
					if ("above" === t) {
						let t = wp.blocks.createBlock("core/paragraph", {
								content: s
							}),
							e = wp.data.select("core/block-editor").getBlockIndex(a),
							o = wp.data.select("core/block-editor").getBlockRootClientId(a);
						return await wp.data.dispatch("core/block-editor").insertBlock(t, e, o), t
					}
					if (e.length > 1 || "core/paragraph" !== n.name) {
						let t = wp.blocks.createBlock("core/paragraph", {
								content: s
							}),
							e = wp.data.select("core/block-editor").getBlockRootClientId(c),
							o = wp.data.select("core/block-editor").getBlockIndex(c) + 1;
						if (!wp.data.select("core/block-editor").canInsertBlockType("core/paragraph", e))
							for (; e && (o = wp.data.select("core/block-editor").getBlockIndex(e) + 1, e = wp.data.select("core/block-editor").getBlockRootClientId(e), !wp.data.select("core/block-editor").canInsertBlockType("core/paragraph", e)););
						return await wp.data.dispatch("core/block-editor").insertBlock(t, o, e), t
					}
					let d = wp.data.select("core/block-editor").getBlockRootClientId(c);
					if (!wp.data.select("core/block-editor").canInsertBlockType("core/paragraph", d)) {
						for (; d && (d = wp.data.select("core/block-editor").getBlockRootClientId(d), !wp.data.select("core/block-editor").canInsertBlockType("core/paragraph", d)););
						let t = wp.blocks.createBlock("core/paragraph", {
							content: s
						});
						return await wp.data.dispatch("core/block-editor").insertBlock(t, void 0, d), t
					}
					let w = i(n),
						u = wp.richText.create({
							html: w
						}),
						g = w.length;
					"offset" in r && (g = r.offset);
					let b = wp.richText.slice(u, 0, g),
						k = wp.richText.slice(u, g, u.text.length),
						h = wp.richText.toHTMLString({
							value: b
						}),
						f = wp.richText.toHTMLString({
							value: k
						}),
						m = n.attributes;
					const v = r.attributeKey;
					let B = m;
					B[v] = h;
					const I = wp.blocks.createBlock(n.name, B);
					let x = m;
					x[v] = s;
					let _ = wp.blocks.createBlock("core/paragraph", x),
						T = m;
					T[v] = f;
					let y = [I, _, wp.blocks.createBlock(n.name, T)];
					return 0 === k.text.trim().length && (y = [I, _]), await wp.data.dispatch("core/block-editor").replaceBlock(c, y), _
				}

				function n() {
					let t = l(),
						[e, o] = p(t);
					return s(t, e, o).trim()
				}

				function l() {
					let t = wp.data.select("core/block-editor").getMultiSelectedBlockClientIds();
					return 0 === t.length && (t = [wp.data.select("core/block-editor").getSelectedBlockClientId()]), t
				}

				function i(t) {
					let e = "";
					return "content" in t.attributes ? e = t.attributes.content : "citation" in t.attributes ? e = t.attributes.citation : "value" in t.attributes ? e = t.attributes.value : "values" in t.attributes ? e = t.attributes.values : "text" in t.attributes && (e = t.attributes.text), e
				}

				function s(t, e, o) {
					let r = "";
					return t.forEach((t => {
						const c = wp.data.select("core/block-editor").getBlock(t);
						let a = i(c),
							n = wp.richText.create({
								html: a
							}).text,
							l = 0,
							p = n.length;
						e.clientId === t && "offset" in e && (l = e.offset), o.clientId === t && "offset" in o && (p = o.offset), n = n.substring(l, p), r += "\n" + n, c.innerBlocks.length > 0 && (r += s(c.innerBlocks.map((t => t.clientId))))
					})), r
				}

				function p(t) {
					const e = wp.data.select("core/block-editor").getSelectionStart(),
						o = wp.data.select("core/block-editor").getSelectionEnd();
					if (e.clientId === o.clientId) return [e, o];
					let r = e,
						c = o;
					return t.length > 0 && t[0] === o.clientId && (r = o, c = e), [r, c]
				}

				function d() {
					let t = n();
					return t.length > 0 && t
				}(0, e.registerFormatType)("aiomatic/custom-buttons", {
					title: "Aiomatic Content Wizard",
					tagName: "aiomatic",
					className: null,
					edit: e => {
						let {
							isActive: n,
							onChange: l,
							value: i
						} = e, s = [];
						if ("object" == typeof aiomatic && "object" == typeof aiomatic.prompts) 
            {
							for (let operation in aiomatic.prompts) 
              {
                  let prompt = aiomatic.prompts[operation];
                  let icon = 'text';
                  if(prompt[1] == 'image')
                  {
                      icon = 'format-image';
                  }
                  s.push({
                    title: operation,
                    icon: icon,
                    onClick: async function() {
                        var selectedText = d();
                        var send_prompt = prompt[0].replace('%%selected_text%%', selectedText);
                        if(send_prompt.includes('%%'))
                        {
                          if (wp && wp.data) 
                          {
                              const postId = wp.data.select("core/editor").getCurrentPostId();
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
                        var block = await aiomaticCreateBlockForAutocompletion(aiomatic.placement);
                        if(icon == 'text')
                        {
                            await aiomaticAutocomplete(block, send_prompt);
                        }
                        else
                        {
                            if(icon == 'format-image')
                            {
                                await aiomaticImager(block, send_prompt);
                            }
                        }
                    },
                  });
							}
						}
            s = aiomatic_uniq_fast(s);
						return (0, t.createElement)(o.BlockControls, null, (0, t.createElement)(r.ToolbarGroup, null, (0, t.createElement)(r.ToolbarDropdownMenu, {
							className: "aiomatic_editor_icon",
							label: "Aiomatic Content Wizard",
              icon: '',
							controls: s
						})))
					}
				})
			}
		},
		o = {};

	function r(t) {
		var c = o[t];
		if (void 0 !== c) return c.exports;
		var a = o[t] = {
			exports: {}
		};
		return e[t](a, a.exports, r), a.exports
	}
	r.m = e, t = [], r.O = (e, o, c, a) => {
		if (!o) {
			var n = 1 / 0;
			for (p = 0; p < t.length; p++) {
				for (var [o, c, a] = t[p], l = !0, i = 0; i < o.length; i++)(!1 & a || n >= a) && Object.keys(r.O).every((t => r.O[t](o[i]))) ? o.splice(i--, 1) : (l = !1, a < n && (n = a));
				if (l) {
					t.splice(p--, 1);
					var s = c();
					void 0 !== s && (e = s)
				}
			}
			return e
		}
		a = a || 0;
		for (var p = t.length; p > 0 && t[p - 1][2] > a; p--) t[p] = t[p - 1];
		t[p] = [o, c, a]
	}, r.o = (t, e) => Object.prototype.hasOwnProperty.call(t, e), (() => {
		var t = {
			826: 0,
			431: 0
		};
		r.O.j = e => 0 === t[e];
		var e = (e, o) => {
				var c, a, [n, l, i] = o,
					s = 0;
				if (n.some((e => 0 !== t[e]))) {
					for (c in l) r.o(l, c) && (r.m[c] = l[c]);
					if (i) var p = i(r)
				}
				for (e && e(o); s < n.length; s++) a = n[s], r.o(t, a) && t[a] && t[a][0](), t[a] = 0;
				return r.O(p)
			},
			o = globalThis.webpackChunkgutenpride = globalThis.webpackChunkgutenpride || [];
		o.forEach(e.bind(null, 0)), o.push = e.bind(null, o.push.bind(o))
	})();
	var c = r.O(void 0, [431], (() => r(401)));
	c = r.O(c)
})();

async function aiomaticCreateBlockForAutocompletion(placement) {
  let selectedBlockClientIds = aiomaticgetSelectedBlockClientIds();
  let [selectionStart, selectionEnd] = aiomaticGetAdjustedSelections(selectedBlockClientIds);
  let lastBlockClientId = selectionEnd.clientId;
  let firstBlockClientId = selectionStart.clientId;
  let lastBlock = wp.data.select('core/block-editor').getBlock(lastBlockClientId);
  let loadingSpinner = aiomaticCreateLoadingSpinner();
  if (placement === 'above') {
    let autoCompleteBlock = wp.blocks.createBlock('core/paragraph', {
      content: loadingSpinner
    }); 

    let index = wp.data.select('core/block-editor').getBlockIndex(firstBlockClientId);

    let parentClientId = wp.data.select('core/block-editor').getBlockRootClientId(firstBlockClientId); 

    await wp.data.dispatch('core/block-editor').insertBlock(autoCompleteBlock, index, parentClientId);
    return autoCompleteBlock;
  } 
  if (selectedBlockClientIds.length > 1 || lastBlock.name !== 'core/paragraph') {

    let autoCompleteBlock = wp.blocks.createBlock('core/paragraph', {
      content: loadingSpinner
    });
    let parentBlockClientId = wp.data.select('core/block-editor').getBlockRootClientId(lastBlockClientId);
    let indexToInsertAt = wp.data.select('core/block-editor').getBlockIndex(lastBlockClientId) + 1;

    if (!wp.data.select('core/block-editor').canInsertBlockType('core/paragraph', parentBlockClientId)) {
      while (parentBlockClientId) {
        indexToInsertAt = wp.data.select('core/block-editor').getBlockIndex(parentBlockClientId) + 1;
        parentBlockClientId = wp.data.select('core/block-editor').getBlockRootClientId(parentBlockClientId);

        if (wp.data.select('core/block-editor').canInsertBlockType('core/paragraph', parentBlockClientId)) {
          break;
        }
      }
    } 
    await wp.data.dispatch('core/block-editor').insertBlock(autoCompleteBlock, indexToInsertAt, parentBlockClientId);
    return autoCompleteBlock;
  }

  let parentBlockClientId = wp.data.select('core/block-editor').getBlockRootClientId(lastBlockClientId);

  if (!wp.data.select('core/block-editor').canInsertBlockType('core/paragraph', parentBlockClientId)) {

    while (parentBlockClientId) {
      parentBlockClientId = wp.data.select('core/block-editor').getBlockRootClientId(parentBlockClientId);

      if (wp.data.select('core/block-editor').canInsertBlockType('core/paragraph', parentBlockClientId)) {
        break;
      }
    }

    let autoCompleteBlock = wp.blocks.createBlock('core/paragraph', {
      content: loadingSpinner
    }); 

    await wp.data.dispatch('core/block-editor').insertBlock(autoCompleteBlock, undefined, parentBlockClientId);
    return autoCompleteBlock;
  }

  let lastBlockContent = aiomaticExtractBlockContent(lastBlock);
  let richText = wp.richText.create({
    html: lastBlockContent
  });
  let start = 0;
  let end = lastBlockContent.length;

  if ('offset' in selectionEnd) {
    end = selectionEnd.offset;
  }

  let firstPart = wp.richText.slice(richText, start, end);
  let secondPart = wp.richText.slice(richText, end, richText.text.length);
  let firstPartContent = wp.richText.toHTMLString({
    value: firstPart
  });
  let secondPartContent = wp.richText.toHTMLString({
    value: secondPart
  });
  let inheritedAttributes = lastBlock.attributes;

  const key = selectionEnd.attributeKey;
  let firstBlockAttributes = inheritedAttributes;
  firstBlockAttributes[key] = firstPartContent;
  const firstPartBlock = wp.blocks.createBlock(lastBlock.name, firstBlockAttributes); 

  let autoCompleteAttributes = inheritedAttributes;
  autoCompleteAttributes[key] = loadingSpinner;
  let autoCompleteBlock = wp.blocks.createBlock('core/paragraph', autoCompleteAttributes);

  let secondBlockAttributes = inheritedAttributes;
  secondBlockAttributes[key] = secondPartContent;
  const secondPartBlock = wp.blocks.createBlock(lastBlock.name, secondBlockAttributes);
  let replacementBlocks = [firstPartBlock, autoCompleteBlock, secondPartBlock];

  if (secondPart.text.trim().length === 0) {
    replacementBlocks = [firstPartBlock, autoCompleteBlock];
  } 


  await wp.data.dispatch('core/block-editor').replaceBlock(lastBlockClientId, replacementBlocks);
  return autoCompleteBlock;
}

function aiomaticCreateLoadingSpinner() {
  const loadingSpinnerId = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
  let spinnersrc = "data:image/gif;base64,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";
  let spinnerHtml = '<p id="' + loadingSpinnerId + '" class="aiomatic-mce-loading"><img src="' + spinnersrc + '"></p>';
  return spinnerHtml;
}
async function aiomaticAutocomplete(autocompleteBlock, selectedText) {
  let autocompletedText = '';

  try {
    autocompletedText = await aiomatic_doAutocompleteRequest(selectedText);
  } catch (error) {
    await wp.data.dispatch('core/block-editor').removeBlocks(autocompleteBlock.clientId);
    alert('An API error occurred with the following response body: \n\n' + error.message);
    return;
  }
  if(autocompletedText === undefined)
  {
      await wp.data.dispatch('core/block-editor').removeBlocks(autocompleteBlock.clientId);
      alert('Incorrect response by AI API!');
      return;
  }
  const autocompletedTextWithLineBreaks = autocompletedText.replace(/\n/g, '<br>');
  
  await wp.data.dispatch('core/block-editor').updateBlockAttributes(autocompleteBlock.clientId, { isLoading: true });
  setTimeout(async () => {
    await wp.data.dispatch('core/block-editor').updateBlockAttributes(autocompleteBlock.clientId, { content: autocompletedTextWithLineBreaks, isLoading: false });
    
    wp.data.dispatch('core/block-editor').selectBlock(autocompleteBlock.clientId);
    wp.data.dispatch('core/block-editor').clearSelectedBlock();
  }, 100);
}
async function aiomaticImager(autocompleteBlock, selectedText) {
  let autocompletedText = '';

  try {
    autocompletedText = await aiomatic_doImageRequest(selectedText);
  } catch (error) {
    await wp.data.dispatch('core/block-editor').removeBlocks(autocompleteBlock.clientId);
    alert('An API error occurred with the following response body: \n\n' + error.message);
    return;
  }
  if(autocompletedText === undefined)
  {
      await wp.data.dispatch('core/block-editor').removeBlocks(autocompleteBlock.clientId);
      alert('Incorrect response returned by AI API!');
      return;
  }
  
  await wp.data.dispatch('core/block-editor').updateBlockAttributes(autocompleteBlock.clientId, { isLoading: true });
  setTimeout(async () => {
    await wp.data.dispatch('core/block-editor').updateBlockAttributes(autocompleteBlock.clientId, { content: autocompletedText, isLoading: false });
    
    wp.data.dispatch('core/block-editor').selectBlock(autocompleteBlock.clientId);
    wp.data.dispatch('core/block-editor').clearSelectedBlock();
  }, 100);
}

const aiomatic_doAutocompleteRequest = async function (text) {
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
const aiomatic_doImageRequest = async function (text) {
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
function aiomaticgetSelectedBlockClientIds() {
  let selectedBlockClientIds = wp.data.select('core/block-editor').getMultiSelectedBlockClientIds();

  if (selectedBlockClientIds.length === 0) {
    selectedBlockClientIds = [wp.data.select('core/block-editor').getSelectedBlockClientId()];
  }

  return selectedBlockClientIds;
}
function aiomaticGetAdjustedSelections(selectedBlockClientIds) {
  const selectionStart = wp.data.select('core/block-editor').getSelectionStart();
  const selectionEnd = wp.data.select('core/block-editor').getSelectionEnd();

  if (selectionStart.clientId === selectionEnd.clientId) {
    return [selectionStart, selectionEnd];
  }

  let adjustedSelectionStart = selectionStart;
  let adjustedSelectionEnd = selectionEnd;

  if (selectedBlockClientIds.length > 0 && selectedBlockClientIds[0] === selectionEnd.clientId) {
    adjustedSelectionStart = selectionEnd;
    adjustedSelectionEnd = selectionStart;
  }

  return [adjustedSelectionStart, adjustedSelectionEnd];
}
function aiomaticExtractBlockContent(block) {
  let content = '';
  if ('content' in block.attributes) {
    content = block.attributes.content;
  } else if ('citation' in block.attributes) {
    content = block.attributes.citation;
  } else if ('value' in block.attributes) {
    content = block.attributes.value;
  } else if ('values' in block.attributes) {
    content = block.attributes.values;
  } else if ('text' in block.attributes) {
    content = block.attributes.text;
  }
  return content;
}