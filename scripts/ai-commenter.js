"use strict"; 
jQuery(document).ready(function ()
{
    if(jQuery('#reviews-filter').length)
    {
        jQuery('table.product-reviews tr.comment').each(function (idx, item)
        {
            let id = jQuery(item).find('.check-column input[type=checkbox]').val();
            if(id !== undefined)
            {
                jQuery(item).find('.has-row-actions .row-actions').append('<span class="aiomatic_commenter"><a id="aiomatic_comment_replier" class="aiomatic_comment_replier" href="javascript:void(0)" data-id="' + id + '">' + mycommentssettings.aireplytext + '</a></span>');
            }
        });
    }
    var nowprocessing = false;
    jQuery(document).on('click','.aiomatic_commenter', function (e)
    {

        var btn = jQuery(this).find('a');
        if(nowprocessing === true)
        {
            alert(mycommentssettings.processingtext);
        }
        else
        {
            var id = btn.attr('data-id');
            if (id === '' || id === undefined) 
            {
                alert(mycommentssettings.cannotfind);
            } 
            else 
            {
                nowprocessing = jQuery.ajax({
                    url: mycommentssettings.ajaxurl,
                    data: {
                        action: 'aiomatic_comment_replier', 
                        zid: id, 
                        nonce: mycommentssettings.nonce
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function ()
                    {
                        btn.html(mycommentssettings.working)
                    },
                    success: function (res)
                    {
                        btn.html(mycommentssettings.aireplytext);
                        nowprocessing = false;
                        if(res.success == true)
                        {
                            var myA = jQuery('button[data-comment-id="' + id + '"][data-action="replyto"]');
                            if(myA !== null && myA !== undefined)
                            {
                                myA.click();
                                jQuery('#replycontent').val(res.data.content);
                            }
                            else
                            {
                                console.log('Cannot find reply button for comment ID: ' + id);
                            }
                        }
                        else
                        {
                            alert('Error in comment generator: ' + JSON.stringify(res));
                        }
                    },
                    error: function ()
                    {
                        nowprocessing = false;
                    }
                });
            }
        }
    });
});