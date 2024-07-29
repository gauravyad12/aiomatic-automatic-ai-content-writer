"use strict";
jQuery(document).ready(function(){
    function aiomaticLoading(btn){
        btn.attr('disabled','disabled');
        if(!btn.find('spinner').length){
            btn.append('<span class="spinner"></span>');
        }
        btn.find('.spinner').css('visibility','unset');
    }
    function aiomaticRmLoading(btn){
        btn.removeAttr('disabled');
        btn.find('.spinner').remove();
    }
    jQuery('#aiomatic_delete_logs').on('click', function (){
        var data = {
            action: 'aiomatic_delete_logs',
            nonce: aiomatic_object.nonce
        };
        var aiomatic_file_button = jQuery('#aiomatic_delete_logs');
        var aiomatic_delete_user_logs = jQuery('#aiomatic_delete_user_logs');
        jQuery.ajax({
            url: aiomatic_object.ajax_url,
            data: data,
            dataType: 'JSON',
            type: 'POST',
            beforeSend: function (){
                aiomaticLoading(aiomatic_file_button);
                aiomaticLoading(aiomatic_delete_user_logs);
            },
            success: function (res){
                if(res.status === 'success'){
                    alert('Usage logs cleared successfully.');
                    window.location.reload();
                }
                else{
                    alert(res.msg);
                    aiomaticRmLoading(aiomatic_file_button);
                    aiomaticRmLoading(aiomatic_delete_user_logs);
                }
            },
            error: function (r, s, error){
                alert('Error in deleting data: ' + error);
                aiomaticRmLoading(aiomatic_file_button);
                aiomaticRmLoading(aiomatic_delete_user_logs);
            }
        });
    });
    jQuery('#aiomatic_delete_user_logs').on('click', function (){
        var delfor = jQuery('#user_name_delete').val();
        if(delfor == '')
        {
            alert('You need to enter a user name for which the plugin will delete usage logs.');
        }
        else
        {
            var data = {
                action: 'aiomatic_delete_user_logs',
                delfor: delfor,
                nonce: aiomatic_object.nonce
            };
            var aiomatic_file_button = jQuery('#aiomatic_delete_logs');
            var aiomatic_delete_user_logs = jQuery('#aiomatic_delete_user_logs');
            jQuery.ajax({
                url: aiomatic_object.ajax_url,
                data: data,
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (){
                    aiomaticLoading(aiomatic_file_button);
                    aiomaticLoading(aiomatic_delete_user_logs);
                },
                success: function (res){
                    if(res.status === 'success'){
                        alert('Usage logs cleared successfully.');
                        window.location.reload();
                    }
                    else{
                        alert(res.msg);
                        aiomaticRmLoading(aiomatic_file_button);
                        aiomaticRmLoading(aiomatic_delete_user_logs);
                    }
                },
                error: function (r, s, error){
                    alert('Error in deleting data: ' + error);
                    aiomaticRmLoading(aiomatic_file_button);
                    aiomaticRmLoading(aiomatic_delete_user_logs);
                }
            });
        }
    });
    jQuery(document).ready(function(){
        jQuery('span.wpaiomatic-delete').on('click', function(){
            var confirm_delete = confirm('Delete This Rule?');
            if (confirm_delete) {
                jQuery(this).parent().parent().remove();
                jQuery('#myForm').submit();						
            }
        });
    });
    function revealRec(){document.getElementById("diviIdrec").innerHTML = '<br/>We recommend that you check <b><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=50837_5_1_16" target="_blank">Divi theme</a></b>, by <b><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=50837_1_1_3" target="_blank">ElegantThemes</a></b>! It is easy to configure and it looks gorgeous. Check it out now!<br/><br/><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=50837_5_1_19" target="_blank" rel="nofollow"><img style="border:0px" src="https://3.bp.blogspot.com/-h9TLQozNO6Q/W92Sk80zwjI/AAAAAAAAAjg/JC8sFWAUPzseR4nnjhVNbRQmCnr1ZMu4gCLcBGAs/s1600/divi.jpg" width="468" height="60" alt="Divi WordPress Theme"></a>';}
    var codemodalfzr = document.getElementById('mymodalfzr');
    var btn = document.getElementById("mybtnfzr");
    var span = document.getElementById("aiomatic_close");
    var ok = document.getElementById("aiomatic_ok");
    if(btn != null)
    {
        btn.onclick = function() {
            codemodalfzr.style.display = "block";
        }
    }
    if(span != null)
    {
        span.onclick = function() {
            codemodalfzr.style.display = "none";
        }
    }
    if(ok != null)
    {
        ok.onclick = function() {
            codemodalfzr.style.display = "none";
        }
    }
    window.onclick = function(event) {
        if (event.target == codemodalfzr) {
            codemodalfzr.style.display = "none";
        }
    }
});
function limitsChanged()
{
    limitsTextChanged();
    if(jQuery('#enable_limits').is(":checked"))
    {            
        jQuery(".hideLimits").show();
    }
    else
    {
        jQuery(".hideLimits").hide();
    }
}
function limitsTextChanged()
{
    if(jQuery('#enable_limits_text').is(":checked"))
    {            
        jQuery(".hideTextLimits").show();
    }
    else
    {
        jQuery(".hideTextLimits").hide();
    }
}
function aiomaticCreateAdmin(i) {
    var modals = [];
    var btns = [];
    var spans = [];
    var oks = [];
    var btns = [];
    var myarr = [];
    modals = document.getElementById("mymodalfzr" + i);
    btns = document.getElementById("mybtnfzr" + i);
    spans = document.getElementById("aiomatic_close" + i);
    oks = document.getElementById("aiomatic_ok" + i);
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
}
window.onload = limitsChanged;