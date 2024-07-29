"use strict";
var modeselect = document.getElementById("posting_mode");
if(modeselect != null)
{
    var pvalue = modeselect.value;
    if(pvalue == 'title')
    {
        document.querySelectorAll('.hidetitle').forEach(function(el) {
            el.style.display = 'table-row';
        });
        document.querySelectorAll('.hidetopic').forEach(function(el) {
            el.style.display = 'none';
        });
    }
    else if(pvalue == 'topic')
    {
        document.querySelectorAll('.hidetitle').forEach(function(el) {
            el.style.display = 'none';
        });
        document.querySelectorAll('.hidetopic').forEach(function(el) {
            el.style.display = 'table-row';
        });
    }
    modeselect.onchange = function(evt) {
        var value = evt.target.value;
        if(value == 'title')
        {
            document.querySelectorAll('.hidetitle').forEach(function(el) {
                el.style.display = 'table-row';
            });
            document.querySelectorAll('.hidetopic').forEach(function(el) {
                el.style.display = 'none';
            });
        }
        else if(value == 'topic')
        {
            document.querySelectorAll('.hidetitle').forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.hidetopic').forEach(function(el) {
                el.style.display = 'table-row';
            });
        }
    }
}
jQuery('#ai-toggle-video').on('click', function() {
    jQuery(this).text(function(i, text){
        return text === varsx.showme ? varsx.hideme : varsx.showme;
    })
    jQuery('#ai-video-container').slideToggle();
});
function hideTOC(number)
{
    if(jQuery('#single_content_call' + number).is(":checked"))
    {
        jQuery('.hideTOC' + number).hide();
    }
    else
    {
        jQuery('.hideTOC' + number).show();
    }
}
function hideImage(number)
{
    if(jQuery('#enable_ai_images' + number).val() == '1' || jQuery('#enable_ai_images' + number).val() == '2')
    {
        jQuery('.hideImg' + number).show();
    }
    else
    {
        jQuery('.hideImg' + number).hide();
    }
    if(jQuery('#enable_ai_images' + number).val() == '1')
    {
        jQuery('.hideDalle' + number).show();
    }
    else
    {
        jQuery('.hideDalle' + number).hide();
    }
}
function hideLinks(number)
{
    if(jQuery('#link_type' + number).val() == 'internal' || jQuery('#link_type' + number).val() == 'disabled')
    {
        jQuery('.hidelinks' + number).hide();
    }
    else
    {
        jQuery('.hidelinks' + number).show();
    }
}
jQuery(document).ready(function () {
    hideLinks('');
});
function createModeSelect(i) {
    
    if(jQuery('#single_content_call' + i).is(":checked"))
    {
        jQuery('.hideTOC' + i).hide();
    }
    else
    {
        jQuery('.hideTOC' + i).show();
    }
    if(jQuery('#enable_ai_images' + i).val() == '1' || jQuery('#enable_ai_images' + i).val() == '2')
    {
        jQuery('.hideImg' + i).show();
    }
    else
    {
        jQuery('.hideImg' + i).hide();
    }
    if(jQuery('#enable_ai_images' + i).val() == '1')
    {
        jQuery('.hideDalle' + i).show();
    }
    else
    {
        jQuery('.hideDalle' + i).hide();
    }
    var modeselect = document.getElementById("posting_mode" + i);
    if(modeselect !== null)
    {
        var pvalue = modeselect.value;
        if(pvalue !== undefined && pvalue !== null)
        {
            if(pvalue == 'title')
            {
                document.querySelectorAll('.hidetitle' + i).forEach(function(el) {
                    el.style.display = 'table-row';
                });
                document.querySelectorAll('.hidetopic' + i).forEach(function(el) {
                    el.style.display = 'none';
                });
            }
            else if(pvalue == 'topic')
            {
                document.querySelectorAll('.hidetitle' + i).forEach(function(el) {
                    el.style.display = 'none';
                });
                document.querySelectorAll('.hidetopic' + i).forEach(function(el) {
                    el.style.display = 'table-row';
                });
            }
        }
    }
    if(modeselect != null)
    {
        modeselect.onchange = function(evt) {
            var value = evt.target.value;
            if(value == 'title')
            {
                document.querySelectorAll('.hidetitle' + i).forEach(function(el) {
                    el.style.display = 'table-row';
                });
                document.querySelectorAll('.hidetopic' + i).forEach(function(el) {
                    el.style.display = 'none';
                });
            }
            else if(value == 'topic')
            {
                document.querySelectorAll('.hidetitle' + i).forEach(function(el) {
                    el.style.display = 'none';
                });
                document.querySelectorAll('.hidetopic' + i).forEach(function(el) {
                    el.style.display = 'table-row';
                });
            }
        }
    }
}