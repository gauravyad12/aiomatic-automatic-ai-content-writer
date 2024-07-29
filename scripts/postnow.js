"use strict";
function aiomatic_post_now(postId)
{
    if (confirm("Are you sure you want to submit this post now?") == true) {
        document.getElementById('aiomatic_submit_post').setAttribute('disabled','disabled');
        document.getElementById('aiomatic_toggle_post').setAttribute('disabled','disabled');
        document.getElementById("aiomatic_span").innerHTML = 'Submitting... (please do not close or refresh this page) ';
        var data = {
             action: 'aiomatic_post_now',
             nonce: aiomatic_poster_object.nonce,
             id: postId
        };
        jQuery.post(aiomatic_poster_object.ajax_url, data, function(response) {
            document.getElementById('aiomatic_submit_post').removeAttribute('disabled');
            document.getElementById('aiomatic_toggle_post').removeAttribute('disabled');
            document.getElementById("aiomatic_span").innerHTML = 'Done! ';
            location.reload();
        }).fail( function(xhr) 
        {
            document.getElementById("aiomatic_span").innerHTML = 'Error, please check the plugin\'s \'Activity and Logging\' menu for details!';
            console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details.');
            document.getElementById('aiomatic_submit_post').removeAttribute('disabled');
            document.getElementById('aiomatic_toggle_post').removeAttribute('disabled');
        });
    } else {
        return;
    }
}
function aiomatic_toggle_now(postId)
{
    if (confirm("Are you sure you want to toggle the processing status of this post?") == true) {
        document.getElementById('aiomatic_submit_post').setAttribute('disabled','disabled');
        document.getElementById('aiomatic_toggle_post').setAttribute('disabled','disabled');
        document.getElementById("aiomatic_span").innerHTML = 'Submitting... (please do not close or refresh this page) ';
        var data = {
             action: 'aiomatic_toggle_status',
             nonce: aiomatic_poster_object.nonce,
             id: postId
        };
        jQuery.post(aiomatic_poster_object.ajax_url, data, function(response) {
            document.getElementById('aiomatic_submit_post').removeAttribute('disabled');
            document.getElementById('aiomatic_toggle_post').removeAttribute('disabled');
            document.getElementById("aiomatic_span").innerHTML = 'Done! ';
            location.reload();
        }).fail( function(xhr) 
        {
            document.getElementById("aiomatic_span").innerHTML = 'Error, please check the plugin\'s \'Activity and Logging\' menu for details!';
            console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details.');
            document.getElementById('aiomatic_submit_post').removeAttribute('disabled');
            document.getElementById('aiomatic_toggle_post').removeAttribute('disabled');
        });
    } else {
        return;
    }
}