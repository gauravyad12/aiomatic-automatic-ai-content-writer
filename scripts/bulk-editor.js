"use strict";
function actionsChangedManual(selectedValue)
{
    if(unsaved){
        alert("You have unsaved changes on this page. Please save your changes before manually running rules!");
        return;
    }
    if (selectedValue==='run')
    {
        runNowManual();
    }
    else
    {
        testNowManual();
    }
}
var unsaved = false;
jQuery(document).ready(function () {
    aiomatic_edit_changed();
    sameChanged();
    jQuery(":input").on('change', function(){
        var classes = this.className;
        var classes = this.className.split(' ');
        var found = jQuery.inArray('actions', classes) > -1;
        if (this.id != 'select-shortcode' && this.id != 'PreventChromeAutocomplete' && this.className != 'sc_chat_form_field_prompt_text' && this.id != 'actions' && !found)
        {
            unsaved = true;
        }
    });
    jQuery("#process_event").on('change', function(){
        var pe = jQuery( "#process_event" ).val();
        if(pe == 'publish')
        {
            jQuery( ".hidethis" ).show();
        }
        else
        {
            jQuery( ".hidethis" ).hide();
        }
    });
    function unloadPage(){ 
        if(unsaved){
            return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
        }
    }
    window.onbeforeunload = unloadPage;
    var pe = jQuery( "#process_event" ).val();
    if(pe == 'publish')
    {
        jQuery( ".hidethis" ).show();
    }
    else
    {
        jQuery( ".hidethis" ).hide();
    }
});
function aiomatic_edit_changed()
{
    var auto_edit = jQuery( "#auto_edit" ).val();
    if(auto_edit == 'wp')
    {
        jQuery( ".hideexternal" ).hide();
        jQuery( ".hidewp" ).show();
    }
    else
    {
        if(auto_edit == 'external')
        {
            jQuery( ".hideexternal" ).show();
            jQuery( ".hidewp" ).hide();
        }
        else
        {
            jQuery( ".hideexternal" ).hide();
            jQuery( ".hidewp" ).hide();
        }
    }
}
function sameChanged()
{
    if(jQuery("#no_twice").is(':checked'))
    {
        jQuery( ".hideField" ).show();
    }
    else
    {
        jQuery( ".hideField" ).hide();
    }
}
function myAIGetDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
         month = '0'+month;
    }
    if(day.toString().length == 1) {
         day = '0'+day;
    }   
    if(hour.toString().length == 1) {
         hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
         minute = '0'+minute;
    }
    if(second.toString().length == 1) {
         second = '0'+second;
    }   
    var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
     return dateTime;
}
function runNowManual()
{
    if (confirm("Are you sure you want to run bulk AI post editing?") == true) 
    {
        document.getElementById("run_img").style.visibility = "visible";
        document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/running.gif";
        var data = {
            action: 'aiomatic_run_my_bulk_action',
            nonce: mybulksettings.nonce
        };
        var pollingInterval;
        function startPolling() {
            pollingInterval = setInterval(function() 
            {
                jQuery.get(mybulksettings.ajaxurl, { action: 'aiomatic_check_process_status', nonce: mybulksettings.nonce }, function(response) 
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
        jQuery.post(mybulksettings.ajaxurl, data, function(response) 
        {
            if(response.trim() == 'ok')
            {
                document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/ok.gif";
            }
            else
            {
                if(response.trim() == 'nochange')
                {
                    document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/nochange.gif";
                }
                else
                {
                    document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/failed.gif";
                }
            }
            if(mybulksettings.more_logs == '1')
            {
                clearInterval(pollingInterval);
            }
        }).fail( function(xhr) 
        {
            console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details. Ajax URL: ' + mybulksettings.ajaxurl);
            document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/failed.gif";
            alert('Server returned error while processing: "' + xhr.statusText +  '", please check plugin\'s \'Activity and Logging\' menu for details.');
            if(mybulksettings.more_logs == '1')
            {
                clearInterval(pollingInterval);
            }
        });
        if(mybulksettings.more_logs == '1')
        {
            startPolling();
        }
    } else {
        return;
    }
}
function testNowManual()
{
    document.getElementById("run_img").style.visibility = "visible";
    document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/running.gif";
    var data = {
        action: 'aiomatic_run_my_bulk_action_test',
        nonce: mybulksettings.nonce
    };
    jQuery.post(mybulksettings.ajaxurl, data, function(response) 
    {
        var results_shower = document.getElementById("results_shower");
        if(response.trim() == 'nochange')
        {
            results_shower.innerHTML = 'No posts matched your query';
            document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/nochange.gif";
        }
        else if(response.trim() == 'fail')
        {
            results_shower.innerHTML = 'Testing failed';
            document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/failed.gif";
        }
        else
        {
            results_shower.innerHTML = 'Affected post ID list: ' + response;
            document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/ok.gif";
        }
    }).fail( function(xhr) 
    {
        results_shower.innerHTML = 'Exception occurred in running';
        console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details. Ajax URL: ' + mybulksettings.ajaxurl);
        document.getElementById("run_img").src = mybulksettings.plugin_dir_url + "images/failed.gif";
        alert('Server returned error while processing: "' + xhr.statusText +  '", please check plugin\'s \'Activity and Logging\' menu for details.');
    });
}