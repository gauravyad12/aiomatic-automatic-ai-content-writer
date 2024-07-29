"use strict";
function aiomatic_parse_html_to_gptobj(html)
{
    if(html == '')
    {
        return [];
    }
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    let messages = [];
    const allMessages = doc.querySelectorAll('.ai-bubble');
    allMessages.forEach(message => 
    {
        const role = message.classList.contains('ai-other') ? 'assistant' : 'user';
        messages.push({ role: role, content: message.innerHTML.trim() });
    });
    return messages;
}
function aiomaticSleep(ms) 
{
    return new Promise(resolve => setTimeout(resolve, ms));
}
const myStreamObject = {
    async startAndDisplayStream(avatarImageUrl, chatId, apiKey) 
    {
        let streamingdebugging = false;
        function myCleverDecodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }
        let idleVideoUrl = null;
        var aiomatic_chat_ajax_object = window["aiomatic_chat_ajax_object" + chatId];
        const RTCPeerConnection = (
            window.RTCPeerConnection ||
            window.webkitRTCPeerConnection ||
            window.mozRTCPeerConnection
        ).bind(window);
        
        let peerConnection;
        let streamId;
        let sessionId;
        let sessionClientAnswer;
        
        let statsIntervalId;
        let videoIsPlaying;
        let lastBytesReceived;
        const talkVideo = document.getElementById('talk-video' + chatId);
        if(talkVideo === undefined || talkVideo === null)
        {
            return;
        }
        const loadingIndicator = document.getElementById('aiomatic-loading-indicator' + chatId);
        talkVideo.setAttribute('playsinline', '');
        function whenFinishedPlaying(videoElement) {
            return new Promise((resolve) => {
                videoElement.onended = () => {
                resolve();
              };
            });
        }
        if (peerConnection && peerConnection.connectionState === 'connected') {
            return;
        }

        stopAllStreams();
        closePC();

        const sessionResponse = await fetchWithRetries(`https://api.d-id.com/talks/streams`, {
            method: 'POST',
            headers: {
                Authorization: `Basic ` + apiKey,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                source_url: avatarImageUrl,
            }),
        });

        const { id: newStreamId, offer, ice_servers: iceServers, session_id: newSessionId } = await sessionResponse.json();
        streamId = newStreamId;
        sessionId = newSessionId;

        try {
            sessionClientAnswer = await createPeerConnection(offer, iceServers);
        } catch (e) {
            console.log('Error during streaming setup', e);
            stopAllStreams();
            closePC();
            throw e;
        }

        const sdpResponse = await fetch(`https://api.d-id.com/talks/streams/${streamId}/sdp`, {
        method: 'POST',
        headers: {
            Authorization: `Basic ` + apiKey,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            answer: sessionClientAnswer,
            session_id: sessionId,
        }),
        });
        if(sdpResponse.ok !== true)
        {
            console.log('Error during stream starting', JSON.stringify(sdpResponse));
            stopAllStreams();
            closePC();
            throw Exception('Error: ' + JSON.stringify(sdpResponse));
        }
        this.talkToDidStream = async function(myText)
        {
            if (peerConnection?.signalingState === 'stable' || peerConnection?.iceConnectionState === 'connected') 
            {
                myText = myText.replace(/^<p>|<\/p>$/g, '');
                var myvoice = aiomatic_chat_ajax_object.did_voice;
                if(aiomatic_chat_ajax_object.overwrite_voice != '')
                {
                    myvoice = aiomatic_chat_ajax_object.overwrite_voice;
                }
                let xscript = {
                    script: {
                        type: 'text',
                        input: myCleverDecodeHtml(myText),
                    },
                    driver_url: 'bank://lively/',
                    config: {
                        stitch: true,
                    },
                    session_id: sessionId,
                };
                if(myvoice != '')
                {
                    let didVoiceExp = myvoice.split(':');
                    if(didVoiceExp[1] !== undefined) {
                        if(didVoiceExp[0].trim() !== '') {
                            xscript.script.provider = {
                                type: didVoiceExp[0].trim().toLowerCase(),
                                voice_id: didVoiceExp[1].trim()
                            };
                    
                            if(didVoiceExp[2] !== undefined) {
                                xscript.script.provider.voice_config = {
                                    style: didVoiceExp[2].trim()
                                };
                            }
                        }
                    }
                }
                const talkResponse = await fetchWithRetries(`https://api.d-id.com/talks/streams/${streamId}`, {
                    method: 'POST',
                    headers: {
                        Authorization: `Basic ` + apiKey,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(xscript),
                });
            }
        };
        
        this.destroyConnectionStreaming = async function()
        {
            await fetch(`https://api.d-id.com/talks/streams/${streamId}`, {
            method: 'DELETE',
            headers: {
                Authorization: `Basic ` + apiKey,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ session_id: sessionId }),
            });
        
            stopAllStreams();
            closePC();
        };
        
        function aiomaticStreamRmLoading(btn){
            btn.removeAttr('disabled');
            btn.find('.aiomatic-jumping-dots').remove();
        }
        function onIceGatheringStateChange() {
            if(streamingdebugging)
            {
                console.log('ICE gathering status: ' + peerConnection.iceGatheringState);
            }
        }
        function onIceCandidate(event) {
            if(streamingdebugging)
            {
                console.log('onIceCandidate', event);
            }
            if (event.candidate) {
            const { candidate, sdpMid, sdpMLineIndex } = event.candidate;
        
            fetch(`https://api.d-id.com/talks/streams/${streamId}/ice`, {
                method: 'POST',
                headers: {
                Authorization: `Basic ` + apiKey,
                'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                candidate,
                sdpMid,
                sdpMLineIndex,
                session_id: sessionId,
                }),
            });
            }
        }
        function onIceConnectionStateChange() {
            if(streamingdebugging)
            {
                console.log('ICE status: ' + peerConnection.iceConnectionState);
            }
            if (peerConnection.iceConnectionState === 'failed' || peerConnection.iceConnectionState === 'closed') {
                stopAllStreams();
                closePC();
            }
        }
        function onConnectionStateChange() {
            if(streamingdebugging)
            {
                console.log('Peer connection state: ' + peerConnection.connectionState);
            }
        }
        function onSignalingStateChange() {
            if(streamingdebugging)
            {
                console.log('Signal status change: ' + peerConnection.signalingState);
            }
        }
        
        function onVideoStatusChange(videoIsPlaying, stream) 
        {
            let status;
            if (videoIsPlaying) 
            {
                status = 'streaming';
                const remoteStream = stream;
                setVideoElement(remoteStream);
            } else {
                status = 'empty';
                whenFinishedPlaying(talkVideo);
                playIdleVideo();
            }
            if(streamingdebugging)
            {
                console.log('Streaming status change: ' + status);
            }
        }
        
        function onTrack(event) 
        {
            if (!event.track) return;
        
            statsIntervalId = setInterval(async () => {
            const stats = await peerConnection.getStats(event.track);
            stats.forEach((report) => {
                if (report.type === 'inbound-rtp' && report.mediaType === 'video') {
                const videoStatusChanged = videoIsPlaying !== report.bytesReceived > lastBytesReceived;
        
                if (videoStatusChanged) {
                    videoIsPlaying = report.bytesReceived > lastBytesReceived;
                    onVideoStatusChange(videoIsPlaying, event.streams[0]);
                }
                lastBytesReceived = report.bytesReceived;
                }
            });
            }, 500);
        }
        
        async function createPeerConnection(offer, iceServers) {
            if (!peerConnection) {
                peerConnection = new RTCPeerConnection({ iceServers });
                peerConnection.addEventListener('icegatheringstatechange', onIceGatheringStateChange, true);
                peerConnection.addEventListener('icecandidate', onIceCandidate, true);
                peerConnection.addEventListener('iceconnectionstatechange', onIceConnectionStateChange, true);
                peerConnection.addEventListener('connectionstatechange', onConnectionStateChange, true);
                peerConnection.addEventListener('signalingstatechange', onSignalingStateChange, true);
                peerConnection.addEventListener('track', onTrack, true);
            }
        
            await peerConnection.setRemoteDescription(offer);
            if(streamingdebugging)
            {
                console.log('set remote sdp OK');
            }
        
            const sessionClientAnswer = await peerConnection.createAnswer();
            if(streamingdebugging)
            {
                console.log('create local sdp OK');
            }
        
            await peerConnection.setLocalDescription(sessionClientAnswer);
            if(streamingdebugging)
            {
                console.log('set local sdp OK');
            }
        
            return sessionClientAnswer;
        }
        
        function setVideoElement(stream) {
            if (!stream) return;
            talkVideo.muted = false;
            talkVideo.srcObject = stream;
            talkVideo.loop = false;
            if (talkVideo.paused) {
                talkVideo
                    .play()
                    .then((_) => {})
                    .catch((e) => {});
            }
        }
        async function playIdleVideo() 
        {
            if (!idleVideoUrl) 
            {
                // If not, call the generateIdleVideo function to get it
                let speechData = new FormData();
                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                speechData.append('did_image', aiomatic_chat_ajax_object.did_image);
                speechData.append('action', 'aiomatic_get_d_id_default_video_chat');
                var speechRequest = new XMLHttpRequest();
                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                speechRequest.ontimeout = () => {
                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                    return; // Exit the function if unable to retrieve the video
                };                     
                speechRequest.onerror = function () 
                {
                    console.error("Network Error");
                    return; // Exit the function if unable to retrieve the video
                };
                speechRequest.onabort = function () 
                {
                    console.error("The request was aborted.");
                    return; // Exit the function if unable to retrieve the video
                };
                speechRequest.onload = function () {
                    var result = speechRequest.responseText;
                    try 
                    {
                        var jsonresult = JSON.parse(result);
                        if(jsonresult.status === 'success')
                        {
                            idleVideoUrl = jsonresult.video;
                            talkVideo.muted = false;
                            talkVideo.src = idleVideoUrl;
                            talkVideo.loop = true;
                            talkVideo.play().catch(e => console.error('Error playing idle video:', e));
                        }
                        else
                        {
                            var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                            console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                            return; // Exit the function if unable to retrieve the video
                        }
                    }
                    catch (errorSpeech){
                        console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                        return; // Exit the function if unable to retrieve the video
                    }
                }
                speechRequest.send(speechData);
            }
            else
            {
                talkVideo.srcObject = null;
                talkVideo.src = idleVideoUrl;
                talkVideo.loop = true;
                talkVideo.play().catch(e => console.error('Error playing idle video:', e));
            }
            loadingIndicator.style.display = 'none';
            var chatbut = jQuery('#aichatsubmitbut' + chatId);
            aiomaticStreamRmLoading(chatbut);
        }
        
        function stopAllStreams() {
            if (talkVideo.srcObject) {
                if(streamingdebugging)
                {
                    console.log('stopping video streams');
                }
                talkVideo.srcObject.getTracks().forEach((track) => track.stop());
                talkVideo.srcObject = null;
            }
        }
        
        function closePC(pc = peerConnection) {
            if (!pc) return;
            if(streamingdebugging)
            {
                console.log('stopping peer connection');
            }
            pc.close();
            pc.removeEventListener('icegatheringstatechange', onIceGatheringStateChange, true);
            pc.removeEventListener('icecandidate', onIceCandidate, true);
            pc.removeEventListener('iceconnectionstatechange', onIceConnectionStateChange, true);
            pc.removeEventListener('connectionstatechange', onConnectionStateChange, true);
            pc.removeEventListener('signalingstatechange', onSignalingStateChange, true);
            pc.removeEventListener('track', onTrack, true);
            clearInterval(statsIntervalId);
            if(streamingdebugging)
            {
                console.log('stopped peer connection');
            }
            if (pc === peerConnection) {
                peerConnection = null;
            }
        }
        const maxRetryCount = 3;
        const maxDelaySec = 4;
        
        async function fetchWithRetries(url, options, retries = 1) {
            if(streamingdebugging)
            {
                console.log('Fetching (' + retries + '): ' + url);
            }
            try {
                return await fetch(url, options);
            } catch (err) {
                if (retries <= maxRetryCount) {
                    const delay = Math.min(Math.pow(2, retries) / 4 + Math.random(), maxDelaySec) * 1000;
            
                    await new Promise((resolve) => setTimeout(resolve, delay));
            
                    console.log(`Request failed, retrying ${retries}/${maxRetryCount}. Error ${err}`);
                    return fetchWithRetries(url, options, retries + 1);
                } else {
                    throw new Error(`Max retries exceeded. error: ${err}`);
                }
            }
        }
    }
}
jQuery(document).ready(function($) 
{
    $('.aiomatic-chat-holder').each(function( ) 
    {
        var instance = $(this).attr("instance");
        initChatbotAiomatic(instance);
        if(window["aiomatic_chat_ajax_object" + instance].autoload == '1')
        {
            $('#aiomatic-open-button' + instance).click();
        }
    });
});
function aiomatic_nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
function aiomatic_mergeDeep(target, source) 
{
    Object.keys(source).forEach(key => 
    {
        if (source[key] && typeof source[key] === 'object' && key !== 'arguments') 
        {
            if (!target[key]) 
            {
                target[key] = {};
            }
            aiomatic_mergeDeep(target[key], source[key]);
        } 
        else 
        {
            if (key === 'arguments') 
            {
                if (!target[key]) 
                {
                    target[key] = '';
                } 
                target[key] += source[key];
            } 
            else 
            {
                target[key] = source[key];
            }
        }
    });
}
function aiomaticEscapeHtml(text) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
function aiChatUploadDataomatic(aiomatic_chat_ajax_object, uniqid, input_text, remember_string, user_question, function_result) 
{
    var formData = new FormData();
    formData.append('uniqid', uniqid);
    formData.append('input_text', input_text);
    formData.append('remember_string', remember_string);
    formData.append('user_question', user_question);
    if(function_result !== null)
    {
        formData.append('function_result', function_result);
    }
    formData.append('action', 'aiomatic_save_chat_data');
    formData.append('nonce', aiomatic_chat_ajax_object.persistentnonce);
    return jQuery.ajax({
        url: aiomatic_chat_ajax_object.ajax_url,
        async: false, 
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false
    });
};
function initChatbotAiomatic(instance)
{
    String.prototype.aitrim = function() 
    {
        return this.replace(/^\s+|\s+$/g, "");
    };
    function aiomaticHideAndRepair(chatbut, e)
    {
        aiomaticRmLoading(chatbut)
        var chatbut = jQuery('#aiomatic-video-wrapper' + instance);
        chatbut.hide();
        streamingEpicFail = true;
        console.error('Failed to init D-ID stream: ', e);
        alert('Chatbot avatar failed to load, please try again later.');
    }
    function aiomaticLoading(btn){
        btn.attr('disabled','disabled');
        if(!btn.find('aiomatic-jumping-dots').length){
            btn.append('<span class="aiomatic-jumping-dots">&nbsp;<span class="aiomatic-dot-1">.</span><span class="aiomatic-dot-2">.</span><span class="aiomatic-dot-3">.</span></span>');
        }
        btn.find('.aiomatic-jumping-dots').css('visibility','unset');
    }
    var streamingEpicFail = false;
    var aiomatic_chat_ajax_object = window["aiomatic_chat_ajax_object" + instance];
    var avatarImageUrl = '';
    var did_app_id = '';
    if(aiomatic_chat_ajax_object.text_speech == 'didstream' && !jQuery('.aiomatic-gg-unmute').length)
    {
        avatarImageUrl = aiomatic_chat_ajax_object.did_image;
        did_app_id = aiomatic_chat_ajax_object.did_app_id;
        if(avatarImageUrl != '' && did_app_id != '')
        {
            var chatbut = jQuery('#aichatsubmitbut' + instance);
            aiomaticLoading(chatbut);
            myStreamObject.startAndDisplayStream(avatarImageUrl, instance, did_app_id).catch((e) => aiomaticHideAndRepair(chatbut, e)); 
        }
    }
    jQuery(document).on('click', '#ai-export-txt' + instance, function (event) 
    {
        event.preventDefault();
        ai_chat_download();
    });
    jQuery(document).on('click', '#ai-clear-chat' + instance, function (event) 
    {
        event.preventDefault();
        jQuery('#aiomatic_chat_history' + instance).html('');
    });
    jQuery(document).on('click', '.aiomatic-gg-mute', function() {
        jQuery(this).removeClass('aiomatic-gg-mute').addClass('aiomatic-gg-unmute');
    });
    jQuery(document).on('click', '.aiomatic-gg-unmute', function() {
        jQuery(this).removeClass('aiomatic-gg-unmute').addClass('aiomatic-gg-mute');
    });
    jQuery(document).on('click', '.aiomatic-gg-globalist', function() 
    {
        var chatid = jQuery('.aiomatic-gg-globalist').attr('chatid');
        var jq = jQuery('#aiomatic-globe-overlay' + chatid);
        jq.toggleClass('aiomatic-globe-bar');
        var title = 'Disable Chatbot Internet Access' ;
        if(jq.hasClass('aiomatic-globe-bar'))
        {
            title = 'Enable Chatbot Internet Access';
        }
        jQuery('#aiomatic-globe-overlay-mother' + chatid).attr('title', title);
    });
    jQuery(document).on('click', '#aichatsubmitbut' + instance, function (event) 
    {
        event.preventDefault();
        openaichatfunct().catch(console.error);
    });
    jQuery('body').on('click', '#aipdfbut' + instance, function(e) 
    {
        jQuery('#aiomatic_pdf_input' + instance).click();
    });
    jQuery('body').on('click', '#aifilebut' + instance, function(e) 
    {
        jQuery('#aiomatic_file_input' + instance).click();
    });
    var aiomatic_generator_working = false;
    var eventGenerator = false;
    jQuery('body').on('click', '#aistopbut' + instance, function(e) 
    {
        var chatbut = jQuery('#aichatsubmitbut' + instance);
        aiomaticRmLoading(chatbut);
        aiomatic_generator_working = false;
        eventGenerator.close();
        jQuery('#aistopbut' + instance).hide();
    });
    jQuery('body').on('change', '#aiomatic_pdf_input' + instance, async function(e) 
    {
        jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">&nbsp;</div>');
        var pdf_input = jQuery('#aiomatic_pdf_input' + instance);
        if(pdf_input !== null && pdf_input !== undefined)
        {
            if (pdf_input[0] !== undefined && pdf_input[0].files !== undefined && pdf_input[0].files[0] !== undefined && pdf_input[0].files && pdf_input[0].files[0]) 
            {
                var pdfIcon = document.getElementById('aipdfbut' + instance);
                var originalIcon = pdfIcon.innerHTML;
                pdfIcon.innerHTML = '<div class="aiomatic-pdf-loading"></div>';
                jQuery('body').off('click', '#aipdfbut' + instance);
                var emb_namespace = 'pdf_' + Math.ceil(Math.random() * 100000);
                var formData = new FormData();
                formData.append('image', pdf_input[0].files[0]);
                formData.append('pdf_namespace', emb_namespace);
                formData.append('action', 'aiomatic_handle_chat_pdf_upload');
                formData.append('nonce', aiomatic_chat_ajax_object.persistentnonce);
                await jQuery.ajax({
                    url: aiomatic_chat_ajax_object.ajax_url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) 
                    {
                        if(response.status == 'success') 
                        {
                            pdf_input.val(''); 
                            const chatx = document.getElementById('aichatsubmitbut' + instance);
                            chatx.setAttribute('data-pdf', emb_namespace);
                            pdfIcon.innerHTML = '<div class="aiomatic-pdf-remove">&times;</div>';
                            pdfIcon.title = "End PDF session";
                            jQuery('body').on('click', '#aipdfbut' + instance, function(e) 
                            {
                                const chatx = document.getElementById('aichatsubmitbut' + instance);
                                chatx.setAttribute('data-pdf', '');
                                jQuery('body').off('click', '#aipdfbut' + instance);
                                pdfIcon.innerHTML = originalIcon;
                                pdfIcon.title = "Upload a PDF file to the chatbot";
                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + aiomatic_chat_ajax_object.pdf_end + '</div>');
                                jQuery('body').on('click', '#aipdfbut' + instance, function(e) 
                                {
                                    jQuery('#aiomatic_pdf_input' + instance).click();
                                });
                            });
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + aiomatic_chat_ajax_object.pdf_ok + '</div>');
                        }
                        else 
                        {
                            pdf_input.val(''); 
                            console.log(JSON.stringify(response));
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + aiomatic_chat_ajax_object.pdf_fail + '</div>');
                            pdfIcon.innerHTML = originalIcon;
                            return;
                        }
                    },
                    error: function(error) {
                        pdf_input.val(''); 
                        console.log('Error while calling pdf upload functions: ' + error.responseText);
                        jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + aiomatic_chat_ajax_object.pdf_fail + '</div>');
                        pdfIcon.innerHTML = originalIcon;
                        return;
                    }
                });
            }
        }
    });
    
    jQuery('body').on('change', '#aiomatic_file_input' + instance, async function(e) 
    {
        jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">&nbsp;</div>');
        var file_input = jQuery('#aiomatic_file_input' + instance);
        if(file_input !== null && file_input !== undefined)
        {
            if (file_input[0] !== undefined && file_input[0].files !== undefined && file_input[0].files[0] !== undefined && file_input[0].files && file_input[0].files[0]) 
            {
                var fileIcon = document.getElementById('aifilebut' + instance);
                var ai_thread_id = jQuery('#aiomatic_thread_id' + instance).val();
                var originalIcon = fileIcon.innerHTML;
                fileIcon.innerHTML = '<div class="aiomatic-file-loading"></div>';
                jQuery('body').off('click', '#aifilebut' + instance);
                var formData = new FormData();
                formData.append('image', file_input[0].files[0]);
                formData.append('thread_id', ai_thread_id);
                formData.append('action', 'aiomatic_handle_chat_file_upload');
                formData.append('nonce', aiomatic_chat_ajax_object.persistentnonce);
                await jQuery.ajax({
                    url: aiomatic_chat_ajax_object.ajax_url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) 
                    {
                        if(response.status == 'success') 
                        {
                            file_input.val(''); 
                            const chatx = document.getElementById('aichatsubmitbut' + instance);
                            chatx.setAttribute('data-store', response.msg);
                            chatx.setAttribute('data-file', response.fid);
                            fileIcon.innerHTML = '<div class="aiomatic-file-remove">&times;</div>';
                            fileIcon.title = "End file session";
                            jQuery('body').on('click', '#aifilebut' + instance, async function(e) 
                            {
                                const chatx = document.getElementById('aichatsubmitbut' + instance);
                                fileIcon.innerHTML = '<div class="aiomatic-file-loading"></div>';
                                var delstore = chatx.getAttribute('data-store');
                                var delfile = chatx.getAttribute('data-file');
                                if(delfile != '')
                                {
                                    var formDelData = new FormData();
                                    formDelData.append('id', delfile);
                                    formDelData.append('storeid', delstore);
                                    formDelData.append('action', 'aiomatic_delete_assistant_vector_store');
                                    formDelData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                    await jQuery.ajax({
                                        url: aiomatic_chat_ajax_object.ajax_url,
                                        type: 'POST',
                                        data: formDelData,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) 
                                        {
                                            console.log('File deleted');
                                        },
                                        error: function(error) {
                                            console.log('Failed to delete file ID: ' + delfile + ', error: ' + error.responseText);
                                        }
                                    });
                                }
                                chatx.setAttribute('data-file', '');
                                chatx.setAttribute('data-store', '');
                                jQuery('body').off('click', '#aifilebut' + instance);
                                fileIcon.innerHTML = originalIcon;
                                fileIcon.title = "Upload a file to the chatbot";
                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">File session ended</div>');
                                jQuery('body').on('click', '#aifilebut' + instance, function(e) 
                                {
                                    jQuery('#aiomatic_file_input' + instance).click();
                                });
                            });
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">File upload successful</div>');
                        }
                        else 
                        {
                            file_input.val(''); 
                            console.log(JSON.stringify(response));
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">File upload failed</div>');
                            fileIcon.innerHTML = originalIcon;
                            return;
                        }
                    },
                    error: function(error) {
                        file_input.val(''); 
                        console.log('Error while calling file upload functions: ' + error.responseText);
                        jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">File upload failed</div>');
                        fileIcon.innerHTML = originalIcon;
                        return;
                    }
                });
            }
        }
    });
    function aiisAlphaNumeric(str) {
        var code, i, len;
        for (i = 0, len = str.length; i < len; i++) {
        code = str.charCodeAt(i);
        if (!(code > 47 && code < 58) && // numeric (0-9)
            !(code > 64 && code < 91) && // upper alpha (A-Z)
            !(code > 96 && code < 123)) { // lower alpha (a-z)
            return false;
        }
        }
        return true;
    }
    var input = document.getElementById("aiomatic_chat_input" + instance);
    if(input !== undefined && input !== null)
    {
        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter" && !e.shiftKey) { 
                e.preventDefault(); 
                openaichatfunct().catch(console.error);
                return false;
            }
        });
    }
    function airemovePrefix(mainString, substring) 
    {
        if (mainString.startsWith(substring)) 
        {
        return mainString.slice(substring.length);
        } else 
        {
        return mainString;
        }
    }
    function airemoveAfter(mainString, substring) {
        var index = mainString.indexOf(substring);
        if (index !== -1) {
        return mainString.slice(0, index);
        } else {
        return mainString;
        }
    }
    function aiomaticRmLoading(btn){
        btn.removeAttr('disabled');
        btn.find('.aiomatic-jumping-dots').remove();
    }
    function AiHtmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }
    function ai_trimHtmlToMaxLength(htmlString, maxLength) 
    {
        const parser = new DOMParser();
        const doc = parser.parseFromString(htmlString, 'text/html');
        const divs = doc.querySelectorAll('div');
        for (let i = divs.length - 1; i >= 0; i--) 
        {
            if (doc.body.innerHTML.length <= maxLength) 
            {
                break;
            }
            divs[i].parentNode.removeChild(divs[i]);
        }
        return doc.body.innerHTML;
    }
    function ai_chat_download() 
    {
        if(aiomatic_chat_ajax_object.chat_download_format == 'txt')
        {
            var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
            var text = x_input_text.replace(/<div class="ai-bubble ai-other">([\s\S]*?)<\/div>/g, aiomatic_chat_ajax_object.ai_message_preppend + "$1\n");
            text = text.replace(/<div class="ai-bubble ai-mine">([\s\S]*?)<\/div>/g, aiomatic_chat_ajax_object.user_message_preppend + "$1\n");
            text = text.replace(/<div class="ai-speech">([\s\S]*?)<\/div>/g, '');
            text = text.aitrim();
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', 'chat.txt');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
        else
        {
            var element = document.querySelector('#aiomatic_chat_history' + instance);
            var originalStyle = element.getAttribute('style');
            element.style.height = 'auto';
            element.style.maxHeight = 'none';
            element.style.overflow = 'visible';
            html2canvas(element, {
                scrollY: -window.scrollY,
                useCORS: true,
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight
            }).then(canvas => 
            {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'px',
                    format: [canvas.width, canvas.height]
                });
                var pageHeight = pdf.internal.pageSize.height;
                var imgHeight = canvas.height;
                var heightLeft = imgHeight;
                var position = 0;
                pdf.addImage(imgData, 'PNG', 0, position, canvas.width, canvas.height);
                heightLeft -= pageHeight;
                while (heightLeft >= 0) 
                {
                    position = heightLeft - imgHeight;
                    pdf.addImage(imgData, 'PNG', 0, position, canvas.width, canvas.height);
                    heightLeft -= pageHeight;
                }
                pdf.save('chat.pdf');
                element.setAttribute('style', originalStyle);
            });
        }
    }
    function aiomatic_strstr(haystack, needle, bool) 
    {
        var pos = 0;
        haystack += "";
        pos = haystack.indexOf(needle); if (pos == -1) {
            return false;
        } else {
            if (bool) {
                return haystack.substr(0, pos);
            } else {
                return haystack.slice(pos);
            }
        }
    }
    function xdelay(time) 
    {
        return new Promise(resolve => setTimeout(resolve, time));
    }
    async function openaichatfunct() 
    {
        var chatbut = jQuery('#aichatsubmitbut' + instance);
        aiomaticLoading(chatbut);
        var input_textj = jQuery('#aiomatic_chat_input' + instance);
        var ai_thread_id = jQuery('#aiomatic_thread_id' + instance).val();
        var ai_assistant_id = jQuery('#aiomatic_assistant_id' + instance).val();
        if(ai_assistant_id === null)
        {
            ai_assistant_id = '';
        }
        var pdf_data = chatbut.attr('data-pdf');
        if(pdf_data === undefined || pdf_data === null)
        {
            pdf_data = '';
        }
        var file_data = chatbut.attr('data-store');
        if(file_data === undefined || file_data === null)
        {
            file_data = '';
        }
        var input_text = '';
        if(aiomatic_chat_ajax_object.text_speech == 'did' && !jQuery('.aiomatic-gg-unmute').length)
        {
            const boxes = document.querySelectorAll('.ai_video');
            boxes.forEach(box => {
                box.remove();
            });
        }
        input_text = input_textj.val();
        if(aiomatic_chat_ajax_object.no_empty == '1' && input_text == '')
        {
            aiomaticRmLoading(chatbut);
            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">You need to enter a message to speak to the chatbot.</div>');
            return;
        }
        input_text = aiomaticEscapeHtml(input_text);
        var user_question = input_text;
        input_textj.val('');
        if(aiomatic_chat_ajax_object.enable_moderation == '1')
        {
            var isflagged = false;
            await jQuery.ajax({
                type: 'POST',
                url: aiomatic_chat_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_moderate_text',
                    text: input_text,
                    nonce: aiomatic_chat_ajax_object.moderation_nonce,
                    model: aiomatic_chat_ajax_object.moderation_model
                },
                success: function(response) {
                    if(typeof response === 'string' || response instanceof String)
                    {
                        try 
                        {
                            var responset = JSON.parse(response);
                            response = responset;
                        } 
                        catch (error) 
                        {
                            console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                        }
                    }
                    if(response.status == 'success')
                    {
                        var resp = null;
                        try 
                        {
                            resp = JSON.parse(response.data);
                        } 
                        catch (error) 
                        {
                            console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + resp);
                        }
                        if(resp.results[0].flagged != undefined)
                        {
                            if(resp.results[0].flagged == true)
                            {
                                aiomaticRmLoading(chatbut);
                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + aiomatic_chat_ajax_object.flagged_message + '</div>');
                                isflagged = true;
                            }
                        }
                        else
                        {
                            console.log('Invalid response from moderation ' + response);
                        }
                    }
                    else
                    {
                        if(typeof response.msg !== 'undefined')
                        {
                            console.log('Moderation returned an error: ' + response.msg);
                        }
                        else
                        {
                            console.log('Moderation returned an error: ' + response);
                        }
                    }
                },
                error: function(error) {
                    console.log('Moderation failed: ' + error.responseText);
                },
            });
            if(isflagged == true)
            {
                return;
            }
        }
        var chat_preppend_text = aiomatic_chat_ajax_object.chat_preppend_text;
        var extension_email_prompt = '';
        if(input_text.toLowerCase().includes('email') || input_text.toLowerCase().includes('e-mail'))
        {
            extension_email_prompt = aiomatic_chat_ajax_object.extension_email_prompt;
            chat_preppend_text = chat_preppend_text + extension_email_prompt;
        }
        var user_message_preppend = aiomatic_chat_ajax_object.user_message_preppend;
        var ai_message_preppend = aiomatic_chat_ajax_object.ai_message_preppend;
        var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
        var remember_string = x_input_text;
        var is_modern_gpt = aiomatic_chat_ajax_object.is_modern_gpt;
        if(aiomatic_chat_ajax_object.max_messages != '')
        {
            const regex = /(<div class="ai-bubble ai-other">[\s\S]*?<\/div>)|(<div class="ai-bubble ai-mine">[\s\S]*?<\/div>)|(<div class="ai-speech">[\s\S]*?<\/div>)/g;
            let matches = [];
            let match;
            while ((match = regex.exec(remember_string)) !== null) {
                matches.push(match[0]);
            }
            remember_string = matches.slice(0 - parseInt(aiomatic_chat_ajax_object.max_messages)).join('');
        }
        if(aiomatic_chat_ajax_object.max_message_context != '')
        {
            if(remember_string.length > parseInt(aiomatic_chat_ajax_object.max_message_context))
            {
                remember_string = ai_trimHtmlToMaxLength(remember_string, parseInt(aiomatic_chat_ajax_object.max_message_context));
            }
        }
        if(is_modern_gpt == '1')
        {
            remember_string = aiomatic_parse_html_to_gptobj(remember_string);
            if(chat_preppend_text != '')
            {
                remember_string.unshift({ role: 'system', content: chat_preppend_text });
            }
            remember_string = JSON.stringify(remember_string);
        }
        else
        {
            remember_string = remember_string.replace(/<div class="ai-bubble ai-other"(?:\sstyle="[^"]*?")?>([\s\S]*?)<\/div>/g, ai_message_preppend + "$1\n");
            remember_string = remember_string.replace(/<div class="ai-bubble ai-mine"(?:\sstyle="[^"]*?")?>([\s\S]*?)<\/div>/g, user_message_preppend + "$1\n");
            remember_string = remember_string.replace(/<div class="ai-speech"(?:\sstyle="[^"]*?")?>([\s\S]*?)<\/div>/g, '');
            remember_string = remember_string.aitrim();
            remember_string = remember_string.slice(-12000);
            var nlregex = /<br\s*[\/]?>/gi;
            remember_string = remember_string.replace(nlregex, "\n");
            if(chat_preppend_text != '')
            {
                remember_string = chat_preppend_text + '\n' + remember_string;
            }
        }
        var model = aiomatic_chat_ajax_object.model;
        var temp = aiomatic_chat_ajax_object.temp;
        var top_p = aiomatic_chat_ajax_object.top_p;
        var presence = aiomatic_chat_ajax_object.presence;
        var frequency = aiomatic_chat_ajax_object.frequency;
        var instant_response = aiomatic_chat_ajax_object.instant_response;
        var user_token_cap_per_day = aiomatic_chat_ajax_object.user_token_cap_per_day;
        var user_id = aiomatic_chat_ajax_object.user_id;
        var enable_god_mode = aiomatic_chat_ajax_object.enable_god_mode;
        var persistent = aiomatic_chat_ajax_object.persistent;
        if(ai_assistant_id != '')
        {
            if(persistent != 'off' && persistent != '0' && persistent != '')
            {
                persistent = 'assistant';
            }
        }
        if(model == 'default' || model == '')
        {
            model = jQuery( "#model-chat-selector" + instance + " option:selected" ).text();
        }
        if(temp == 'default' || temp == '')
        {
            temp = jQuery('#temperature-chat-input' + instance).val();
        }
        if(top_p == 'default' || top_p == '')
        {
            top_p = jQuery('#top_p-chat-input' + instance).val();
        }
        if(presence == 'default' || presence == '')
        {
            presence = jQuery('#presence-chat-input' + instance).val();
        }
        if(frequency == 'default' || frequency == '')
        {
            frequency = jQuery('#frequency-chat-input' + instance).val();
        }
        var vision_file = '';
        var vision_input = jQuery('#aiomatic_vision_input' + instance);
        if(vision_input !== null && vision_input !== undefined)
        {
            if (vision_input[0] !== undefined && vision_input[0].files !== undefined && vision_input[0].files[0] !== undefined && vision_input[0].files && vision_input[0].files[0]) 
            {
                var formData = new FormData();
                formData.append('image', vision_input[0].files[0]);
                formData.append('action', 'aiomatic_handle_vision_image_upload');
                formData.append('nonce', aiomatic_chat_ajax_object.persistentnonce);
                await jQuery.ajax({
                    url: aiomatic_chat_ajax_object.ajax_url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) 
                    {
                        if(response.status == 'success') 
                        {
                            if(response.image_url !== '')
                            {
                                vision_input.val(''); 
                                jQuery('#aivisionbut' + instance).css("background-color", "");
                                vision_file = response.image_url;
                            }
                            else
                            {
                                vision_input.val(''); 
                                jQuery('#aivisionbut' + instance).css("background-color", "");
                                aiomaticRmLoading(chatbut);
                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">File upload failed, please try again later.</div>');
                                return;
                            }
                        }
                        else 
                        {
                            vision_input.val(''); 
                            jQuery('#aivisionbut' + instance).css("background-color", "");
                            aiomaticRmLoading(chatbut);
                            console.log(JSON.stringify(response));
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + response.msg + '</div>');
                            return;
                        }
                    },
                    error: function(error) {
                        vision_input.val(''); 
                        jQuery('#aivisionbut' + instance).css("background-color", "");
                        console.log('Error while calling AI functions: ' + error.responseText);
                        aiomaticRmLoading(chatbut);
                        jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the file upload, please try again later.</div>');
                        return;
                    }
                });
            }
        }
        if(input_text.aitrim() != '')
        {
            if(aiomatic_chat_ajax_object.send_message_sound != '')
            {
                var snd = new Audio(aiomatic_chat_ajax_object.send_message_sound);
                snd.play();
            }
            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">&nbsp;</div>');
            input_text = input_text.replace(/(?:\r\n|\r|\n)/g, '<br>');
            var appendhtml = '<div class="ai-bubble ai-mine">' + input_text;
            if(vision_file != '')
            {
                appendhtml += '<img src="' + vision_file + '" class="aiomatic-vision-image">';
            }
            appendhtml += '</div>';
            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + appendhtml);
        }
        if(aiomatic_chat_ajax_object.response_delay.trim() != '')
        {
            let xms;
            var sleepval = aiomatic_chat_ajax_object.response_delay.trim();
            if (typeof sleepval === 'string' && sleepval.includes('-')) 
            {
                const [min, max] = sleepval.split('-').map(Number);
                xms = Math.floor(Math.random() * (max - min + 1)) + min;
            } 
            else 
            {
                xms = Number(sleepval);
            }
            await aiomaticSleep(xms);
        }
        var lastch = input_text.charAt(input_text.length - 1);
        if(aiisAlphaNumeric(lastch))
        {
            input_text += '.';
        }
        if(user_message_preppend != '')
        {
            var endSpace = /\s$/;
            if (endSpace.test(user_message_preppend)) 
            {
                input_text = user_message_preppend + input_text;
            }
            else
            {
                input_text = user_message_preppend + ' ' + input_text;
            }
        }
        if(is_modern_gpt != '1')
        {
            if(ai_message_preppend != '')
            {
                input_text = input_text + ' \n' + ai_message_preppend;
            }
        }
        if( jQuery('#aiomatic_message_input'+ instance).length )
        {
            var hardcoded_chat = jQuery('#aiomatic_message_input' + instance).val();
            if(hardcoded_chat !== '')
            {
                const fm = hardcoded_chat.trim().split(/\\r\\n|\\r|\\n/).filter(xline => xline.length > 0);
                if(fm[0] !== undefined && fm[0] !== null)
                {
                    var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                    var hardresponse = fm[0];
                    fm.shift();
                    if(fm.length == 0 && aiomatic_strstr(x_input_text, hardresponse, false) !== false)
                    {
                        hardresponse = false;
                    }
                    while(aiomatic_strstr(x_input_text, hardresponse, false) !== false && fm.length > 0)
                    {
                        fm.shift();
                        if(fm.length > 0) 
                        {
                            hardresponse = fm[0];
                        }
                        else
                        {
                            hardresponse = false;
                            break;
                        }
                    }
                    if(fm.length > 0) 
                    {
                        jQuery('#aiomatic_message_input' + instance).val(fm.join('\\r\\n'));
                    }
                    else
                    {
                        jQuery('#aiomatic_message_input' + instance).val('');
                    }
                    if(hardresponse !== false)
                    {
                        if(instant_response == 'true' || instant_response == 'on')
                        {
                            xdelay(1000).then(() => 
                            {
                                var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + hardresponse + '</div>');
                                var has_speech = false;
                                var response_data = hardresponse;
                                if(aiomatic_chat_ajax_object.receive_message_sound != '')
                                {
                                    var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                                    snd.play();
                                }
                                if(!jQuery('.aiomatic-gg-unmute').length)
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                                    {
                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                        if(response_data != '')
                                        {
                                            has_speech = true;
                                            let speechData = new FormData();
                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                            speechData.append('x_input_text', response_data);
                                            speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                            var speechRequest = new XMLHttpRequest();
                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                            speechRequest.responseType = "arraybuffer";
                                            speechRequest.ontimeout = () => {
                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };                     
                                            speechRequest.onerror = function () 
                                            {
                                                console.error("Network Error");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onabort = function () 
                                            {
                                                console.error("The request was aborted.");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onload = function () {
                                                var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                                var fr = new FileReader();
                                                fr.onload = function () {
                                                    var fileText = this.result;
                                                    try {
                                                        var errorMessage = JSON.parse(fileText);
                                                        console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    } catch (errorBlob) {
                                                        var blobUrl = URL.createObjectURL(blob);
                                                        var audioElement = document.createElement('audio');
                                                        audioElement.src = blobUrl;
                                                        audioElement.controls = true;
                                                        audioElement.style.marginTop = "2px";
                                                        audioElement.style.width = "100%";
                                                        audioElement.addEventListener("error", function(event) {
                                                            console.error("Error loading or playing the audio: ", event);
                                                        });
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                        jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                        audioElement.play();
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                fr.readAsText(blob);
                                            }
                                            speechRequest.send(speechData);
                                        }
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                        {
                                            response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                            if(response_data != '')
                                            {
                                                has_speech = true;
                                                let speechData = new FormData();
                                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                speechData.append('x_input_text', response_data);
                                                speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                                var speechRequest = new XMLHttpRequest();
                                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                speechRequest.responseType = "arraybuffer";
                                                speechRequest.ontimeout = () => {
                                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };                     
                                                speechRequest.onerror = function () 
                                                {
                                                    console.error("Network Error");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onabort = function () 
                                                {
                                                    console.error("The request was aborted.");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onload = function () {
                                                    var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                                    var fr = new FileReader();
                                                    fr.onload = function () {
                                                        var fileText = this.result;
                                                        try {
                                                            var errorMessage = JSON.parse(fileText);
                                                            console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        } catch (errorBlob) {
                                                            var blobUrl = URL.createObjectURL(blob);
                                                            var audioElement = document.createElement('audio');
                                                            audioElement.src = blobUrl;
                                                            audioElement.controls = true;
                                                            audioElement.style.marginTop = "2px";
                                                            audioElement.style.width = "100%";
                                                            audioElement.addEventListener("error", function(event) {
                                                                console.error("Error loading or playing the audio: ", event);
                                                            });
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                            jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                            audioElement.play();
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                    fr.readAsText(blob);
                                                }
                                                speechRequest.send(speechData);
                                            }
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'google')
                                            {
                                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                if(response_data != '')
                                                {
                                                    has_speech = true;
                                                    let speechData = new FormData();
                                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                    speechData.append('x_input_text', response_data);
                                                    speechData.append('action', 'aiomatic_get_google_voice_chat');
                                                    var speechRequest = new XMLHttpRequest();
                                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                    speechRequest.ontimeout = () => {
                                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };                     
                                                    speechRequest.onerror = function () 
                                                    {
                                                        console.error("Network Error");
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };
                                                    speechRequest.onabort = function () 
                                                    {
                                                        console.error("The request was aborted.");
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };
                                                    speechRequest.onload = function () {
                                                        var result = speechRequest.responseText;
                                                        try {
                                                            var jsonresult = JSON.parse(result);
                                                            if(jsonresult.status === 'success'){
                                                                var byteCharacters = atob(jsonresult.audio);
                                                                const byteNumbers = new Array(byteCharacters.length);
                                                                for (let i = 0; i < byteCharacters.length; i++) {
                                                                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                                }
                                                                const byteArray = new Uint8Array(byteNumbers);
                                                                const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                                const blobUrl = URL.createObjectURL(blob);
                                                                var audioElement = document.createElement('audio');
                                                                audioElement.src = blobUrl;
                                                                audioElement.controls = true;
                                                                audioElement.style.marginTop = "2px";
                                                                audioElement.style.width = "100%";
                                                                audioElement.addEventListener("error", function(event) {
                                                                    console.error("Error loading or playing the audio: ", event);
                                                                });
                                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                                jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                                audioElement.play();
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            }
                                                            else{
                                                                var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                                console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            }
                                                        }
                                                        catch (errorSpeech){
                                                            console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                    speechRequest.send(speechData);
                                                }
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'did')
                                                {
                                                    response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                    if(response_data != '')
                                                    {
                                                        has_speech = true;
                                                        let speechData = new FormData();
                                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                        speechData.append('x_input_text', response_data);
                                                        speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                                        var speechRequest = new XMLHttpRequest();
                                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                        speechRequest.ontimeout = () => {
                                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        };                     
                                                        speechRequest.onerror = function () 
                                                        {
                                                            console.error("Network Error");
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        };
                                                        speechRequest.onabort = function () 
                                                        {
                                                            console.error("The request was aborted.");
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        };
                                                        speechRequest.onload = function () {
                                                            var result = speechRequest.responseText;
                                                            try 
                                                            {
                                                                var jsonresult = JSON.parse(result);
                                                                if(jsonresult.status === 'success')
                                                                {
                                                                    var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-video">' + videoURL + '</div>');
                                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                    aiomaticRmLoading(chatbut);
                                                                    aiomatic_generator_working = false;
                                                                }
                                                                else
                                                                {
                                                                    var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                                    console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                    aiomaticRmLoading(chatbut);
                                                                    aiomatic_generator_working = false;
                                                                }
                                                            }
                                                            catch (errorSpeech){
                                                                console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            }
                                                        }
                                                        speechRequest.send(speechData);
                                                    }
                                                }
                                                else
                                                {
                                                    if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                                    {
                                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                        if(response_data != '')
                                                        {
                                                            if(avatarImageUrl != '' && did_app_id != '')
                                                            {
                                                                if(streamingEpicFail === false)
                                                                {
                                                                    has_speech = true;
                                                                    myStreamObject.talkToDidStream(response_data);
                                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                    aiomatic_generator_working = false;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                        {
                                                            var T2S;
                                                            if("speechSynthesis" in window || speechSynthesis)
                                                            {
                                                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                                if(response_data != '')
                                                                {
                                                                    T2S = window.speechSynthesis || speechSynthesis;
                                                                    var utter = new SpeechSynthesisUtterance(response_data);
                                                                    var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                                    var desiredVoiceName = voiceSetting[0].trim();
                                                                    var desiredLang = voiceSetting[1].trim();
                                                                    var voices = T2S.getVoices();
                                                                    var selectedVoice = voices.find(function(voice) {
                                                                        return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                                    });
                                                                    if (selectedVoice) {
                                                                        utter.voice = selectedVoice;
                                                                        utter.lang = selectedVoice.lang;
                                                                    } 
                                                                    else 
                                                                    {
                                                                        utter.lang = desiredLang;
                                                                    }
                                                                    T2S.speak(utter);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                var error_generated = '';
                                aiomaticRmLoading(chatbut);
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                                if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0' && error_generated == '')
                                {
                                    var save_persistent = x_input_text;
                                    if(persistent == 'vector')
                                    {
                                        save_persistent = user_question;
                                    }
                                    jQuery.ajax({
                                        type: 'POST',
                                        url: aiomatic_chat_ajax_object.ajax_url,
                                        data: {
                                            action: 'aiomatic_user_meta_save',
                                            nonce: aiomatic_chat_ajax_object.persistentnonce,
                                            persistent: persistent,
                                            thread_id: aiomatic_chat_ajax_object.thread_id,
                                            x_input_text: save_persistent,
                                            user_id: user_id
                                        },
                                        success: function() {
                                        },
                                        error: function(error) {
                                            console.log('Error while saving persistent user log: ' + error.responseText);
                                        },
                                    });
                                }
                            });  
                        }
                        else
                        {
                            var i = 0;
                            var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                            function typeWriterBotWrapper(x_input_text) 
                            {
                                return new Promise((resolve, reject) => 
                                {
                                    typeWriterBot(x_input_text, resolve);
                                });
                            }
                            function typeWriterBot(x_input_text, resolve) 
                            {
                                if (i < hardresponse.length) 
                                {
                                    // Append the response to the input field
                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + hardresponse.substring(0, i + 1) + '</div>');
                                    i++;
                                    setTimeout(function() {
                                        typeWriterBot(x_input_text, resolve);
                                    }, 50);
                                } 
                                else 
                                {
                                    x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                                    var has_speech = false;
                                    var response_data = hardresponse;
                                    if(aiomatic_chat_ajax_object.receive_message_sound != '')
                                    {
                                        var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                                        snd.play();
                                    }
                                    if(!jQuery('.aiomatic-gg-unmute').length)
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                                        {
                                            response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                            if(response_data != '')
                                            {
                                                has_speech = true;
                                                let speechData = new FormData();
                                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                speechData.append('x_input_text', response_data);
                                                speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                                var speechRequest = new XMLHttpRequest();
                                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                speechRequest.responseType = "arraybuffer";
                                                speechRequest.ontimeout = () => {
                                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };                     
                                                speechRequest.onerror = function () 
                                                {
                                                    console.error("Network Error");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onabort = function () 
                                                {
                                                    console.error("The request was aborted.");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onload = function () {
                                                    var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                                    var fr = new FileReader();
                                                    fr.onload = function () {
                                                        var fileText = this.result;
                                                        try {
                                                            var errorMessage = JSON.parse(fileText);
                                                            console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        } catch (errorBlob) {
                                                            var blobUrl = URL.createObjectURL(blob);
                                                            var audioElement = document.createElement('audio');
                                                            audioElement.src = blobUrl;
                                                            audioElement.controls = true;
                                                            audioElement.style.marginTop = "2px";
                                                            audioElement.style.width = "100%";
                                                            audioElement.addEventListener("error", function(event) {
                                                                console.error("Error loading or playing the audio: ", event);
                                                            });
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                            jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                            audioElement.play();
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                    fr.readAsText(blob);
                                                }
                                                speechRequest.send(speechData);
                                            }
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                            {
                                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                if(response_data != '')
                                                {
                                                    has_speech = true;
                                                    let speechData = new FormData();
                                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                    speechData.append('x_input_text', response_data);
                                                    speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                                    var speechRequest = new XMLHttpRequest();
                                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                    speechRequest.responseType = "arraybuffer";
                                                    speechRequest.ontimeout = () => {
                                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };                     
                                                    speechRequest.onerror = function () 
                                                    {
                                                        console.error("Network Error");
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };
                                                    speechRequest.onabort = function () 
                                                    {
                                                        console.error("The request was aborted.");
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };
                                                    speechRequest.onload = function () {
                                                        var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                                        var fr = new FileReader();
                                                        fr.onload = function () {
                                                            var fileText = this.result;
                                                            try {
                                                                var errorMessage = JSON.parse(fileText);
                                                                console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            } catch (errorBlob) {
                                                                var blobUrl = URL.createObjectURL(blob);
                                                                var audioElement = document.createElement('audio');
                                                                audioElement.src = blobUrl;
                                                                audioElement.controls = true;
                                                                audioElement.style.marginTop = "2px";
                                                                audioElement.style.width = "100%";
                                                                audioElement.addEventListener("error", function(event) {
                                                                    console.error("Error loading or playing the audio: ", event);
                                                                });
                                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                                jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                                audioElement.play();
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            }
                                                        }
                                                        fr.readAsText(blob);
                                                    }
                                                    speechRequest.send(speechData);
                                                }
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'google')
                                                {
                                                    response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                    if(response_data != '')
                                                    {
                                                        has_speech = true;
                                                        let speechData = new FormData();
                                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                        speechData.append('x_input_text', response_data);
                                                        speechData.append('action', 'aiomatic_get_google_voice_chat');
                                                        var speechRequest = new XMLHttpRequest();
                                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                        speechRequest.ontimeout = () => {
                                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        };                     
                                                        speechRequest.onerror = function () 
                                                        {
                                                            console.error("Network Error");
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        };
                                                        speechRequest.onabort = function () 
                                                        {
                                                            console.error("The request was aborted.");
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        };
                                                        speechRequest.onload = function () {
                                                            var result = speechRequest.responseText;
                                                            try {
                                                                var jsonresult = JSON.parse(result);
                                                                if(jsonresult.status === 'success'){
                                                                    var byteCharacters = atob(jsonresult.audio);
                                                                    const byteNumbers = new Array(byteCharacters.length);
                                                                    for (let i = 0; i < byteCharacters.length; i++) {
                                                                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                                    }
                                                                    const byteArray = new Uint8Array(byteNumbers);
                                                                    const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                                    const blobUrl = URL.createObjectURL(blob);
                                                                    var audioElement = document.createElement('audio');
                                                                    audioElement.src = blobUrl;
                                                                    audioElement.controls = true;
                                                                    audioElement.style.marginTop = "2px";
                                                                    audioElement.style.width = "100%";
                                                                    audioElement.addEventListener("error", function(event) {
                                                                        console.error("Error loading or playing the audio: ", event);
                                                                    });
                                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                                    jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                                    audioElement.play();
                                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                    aiomaticRmLoading(chatbut);
                                                                    aiomatic_generator_working = false;
                                                                }
                                                                else{
                                                                    var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                                    console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                    aiomaticRmLoading(chatbut);
                                                                    aiomatic_generator_working = false;
                                                                }
                                                            }
                                                            catch (errorSpeech){
                                                                console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            }
                                                        }
                                                        speechRequest.send(speechData);
                                                    }
                                                }
                                                else
                                                {
                                                    if(aiomatic_chat_ajax_object.text_speech == 'did')
                                                    {
                                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                        if(response_data != '')
                                                        {
                                                            has_speech = true;
                                                            let speechData = new FormData();
                                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                            speechData.append('x_input_text', response_data);
                                                            speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                                            var speechRequest = new XMLHttpRequest();
                                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                            speechRequest.ontimeout = () => {
                                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            };                     
                                                            speechRequest.onerror = function () 
                                                            {
                                                                console.error("Network Error");
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            };
                                                            speechRequest.onabort = function () 
                                                            {
                                                                console.error("The request was aborted.");
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                aiomaticRmLoading(chatbut);
                                                                aiomatic_generator_working = false;
                                                            };
                                                            speechRequest.onload = function () {
                                                                var result = speechRequest.responseText;
                                                                try 
                                                                {
                                                                    var jsonresult = JSON.parse(result);
                                                                    if(jsonresult.status === 'success')
                                                                    {
                                                                        var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-video">' + videoURL + '</div>');
                                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                        aiomaticRmLoading(chatbut);
                                                                        aiomatic_generator_working = false;
                                                                    }
                                                                    else
                                                                    {
                                                                        var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                                        console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                        aiomaticRmLoading(chatbut);
                                                                        aiomatic_generator_working = false;
                                                                    }
                                                                }
                                                                catch (errorSpeech){
                                                                    console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                    aiomaticRmLoading(chatbut);
                                                                    aiomatic_generator_working = false;
                                                                }
                                                            }
                                                            speechRequest.send(speechData);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                                        {
                                                            response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                            if(response_data != '')
                                                            {
                                                                if(avatarImageUrl != '' && did_app_id != '')
                                                                {
                                                                    if(streamingEpicFail === false)
                                                                    {
                                                                        has_speech = true;
                                                                        myStreamObject.talkToDidStream(response_data);
                                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                        aiomatic_generator_working = false;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                            {
                                                                var T2S;
                                                                if("speechSynthesis" in window || speechSynthesis)
                                                                {
                                                                    response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                                    if(response_data != '')
                                                                    {
                                                                        T2S = window.speechSynthesis || speechSynthesis;
                                                                        var utter = new SpeechSynthesisUtterance(response_data);
                                                                        var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                                        var desiredVoiceName = voiceSetting[0].trim();
                                                                        var desiredLang = voiceSetting[1].trim();
                                                                        var voices = T2S.getVoices();
                                                                        var selectedVoice = voices.find(function(voice) 
                                                                        {
                                                                            return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                                        });
                                                                        if (selectedVoice) {
                                                                            utter.voice = selectedVoice;
                                                                            utter.lang = selectedVoice.lang;
                                                                        } 
                                                                        else 
                                                                        {
                                                                            utter.lang = desiredLang;
                                                                        }
                                                                        T2S.speak(utter);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    // Clear the response container
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    // Enable the submit button
                                    aiomaticRmLoading(chatbut);
                                    i = 0;
                                    resolve();
                                }
                            }
                            xdelay(1000).then(async () => {
                                var error_generated = '';
                                var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                                await typeWriterBotWrapper(x_input_text);
                                var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                                if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0' && error_generated == '')
                                {
                                    var save_persistent = x_input_text;
                                    if(persistent == 'vector')
                                    {
                                        save_persistent = user_question;
                                    }
                                    jQuery.ajax({
                                        type: 'POST',
                                        url: aiomatic_chat_ajax_object.ajax_url,
                                        data: {
                                            action: 'aiomatic_user_meta_save',
                                            nonce: aiomatic_chat_ajax_object.persistentnonce,
                                            persistent: persistent,
                                            thread_id: aiomatic_chat_ajax_object.thread_id,
                                            x_input_text: save_persistent,
                                            user_id: user_id
                                        },
                                        success: function() {
                                        },
                                        error: function(error) {
                                            console.log('Error while saving persistent user log: ' + error.responseText);
                                        },
                                    });
                                }
                            });
                        }
                        return;
                    }
                }
            }
        }
        if(instant_response == 'stream')
        {
            if(aiomatic_generator_working === true)
            {
                console.log('AI Chatbot already working!');
                aiomaticRmLoading(chatbut);
                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">There was an issue with processing, please try again!</div>');
                return;
            }
            if(ai_assistant_id != '' && ai_thread_id == '')
            {
                await jQuery.ajax({
                    type: 'POST',
                    url: aiomatic_chat_ajax_object.ajax_url,
                    data: {
                        action: 'aiomatic_create_thread',
                        nonce: aiomatic_chat_ajax_object.nonce,
                        assistantid: ai_assistant_id,
                        file_data: file_data
                    },
                    success: function(result) 
                    {
                        if(result.status == 'success' && result.data != undefined)
                        {
                            jQuery('#aiomatic_thread_id' + instance).val(result.data);
                            ai_thread_id = result.data;
                        }
                        else
                        {
                            console.log('Thread creation failed: ' + JSON.stringify(result));
                        }
                    },
                    error: function(error) {
                        console.log('Failed to create thread: ' + error.responseText);
                    },
                });
            }
            if(enable_god_mode == '')
            {
                enable_god_mode = 'off';
            }
            aiomatic_generator_working = true;
            var count_line = 0;
            var response_data = '';
            var internet_permission = aiomatic_chat_ajax_object.internet_access;
            if(jQuery('#aiomatic-globe-overlay' + instance).hasClass('aiomatic-globe-bar'))
            {
                internet_permission = 'disabled';
            }
            var eventURL = aiomatic_chat_ajax_object.stream_url;
            eventURL += '&input_text=' + encodeURIComponent(input_text);
            if(pdf_data != '')
            {
                eventURL += '&pdf_data=' + encodeURIComponent(pdf_data);
            }
            if(file_data != '')
            {
                eventURL += '&file_data=' + encodeURIComponent(file_data);
            }
            if(aiomatic_chat_ajax_object.user_token_cap_per_day != '')
            {
                eventURL += '&user_token_cap_per_day=' + encodeURIComponent(aiomatic_chat_ajax_object.user_token_cap_per_day);
            }
            if(aiomatic_chat_ajax_object.user_id != '')
            {
                eventURL += '&user_id=' + encodeURIComponent(aiomatic_chat_ajax_object.user_id);
            }
            if(aiomatic_chat_ajax_object.frequency != '')
            {
                eventURL += '&frequency=' + encodeURIComponent(aiomatic_chat_ajax_object.frequency);
            }
            if(aiomatic_chat_ajax_object.presence != '')
            {
                eventURL += '&presence=' + encodeURIComponent(aiomatic_chat_ajax_object.presence);
            }
            if(aiomatic_chat_ajax_object.top_p != '')
            {
                eventURL += '&top_p=' + encodeURIComponent(aiomatic_chat_ajax_object.top_p);
            }
            if(aiomatic_chat_ajax_object.temp != '')
            {
                eventURL += '&temp=' + encodeURIComponent(aiomatic_chat_ajax_object.temp);
            }
            if(aiomatic_chat_ajax_object.model != '')
            {
                eventURL += '&model=' + encodeURIComponent(aiomatic_chat_ajax_object.model);
            }
            if(ai_assistant_id != '')
            {
                eventURL += '&assistant_id=' + encodeURIComponent(ai_assistant_id);
            }
            if(ai_thread_id != '')
            {
                eventURL += '&thread_id=' + encodeURIComponent(ai_thread_id);
            }
            if(remember_string != '')
            {
                eventURL += '&remember_string=' + encodeURIComponent(remember_string);
            }
            if(is_modern_gpt != '')
            {
                eventURL += '&is_modern_gpt=' + encodeURIComponent(is_modern_gpt);
            }
            if(internet_permission != '')
            {
                eventURL += '&internet_access=' + encodeURIComponent(internet_permission);
            }
            if(aiomatic_chat_ajax_object.embeddings != '')
            {
                eventURL += '&embeddings=' + encodeURIComponent(aiomatic_chat_ajax_object.embeddings);
            }
            if(user_question != '')
            {
                eventURL += '&user_question=' + encodeURIComponent(user_question);
            }
            if(enable_god_mode != '')
            {
                eventURL += '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
            }
            if(vision_file != '')
            {
                eventURL += '&vision_file=' + encodeURIComponent(vision_file);
            }
            if(eventURL.length > 2080)
            {
                console.log('URL too long, using alternative event method');
                var unid = "id" + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);;
                aiChatUploadDataomatic(aiomatic_chat_ajax_object, unid, input_text, remember_string, user_question, null);
                eventURL = aiomatic_chat_ajax_object.stream_url + '&input_text=0&remember_string=0&user_question=0';
                if(pdf_data != '')
                {
                    eventURL += '&pdf_data=' + encodeURIComponent(pdf_data);
                }
                if(file_data != '')
                {
                    eventURL += '&file_data=' + encodeURIComponent(file_data);
                }
                if(aiomatic_chat_ajax_object.user_token_cap_per_day != '')
                {
                    eventURL += '&user_token_cap_per_day=' + encodeURIComponent(aiomatic_chat_ajax_object.user_token_cap_per_day);
                }
                if(aiomatic_chat_ajax_object.user_id != '')
                {
                    eventURL += '&user_id=' + encodeURIComponent(aiomatic_chat_ajax_object.user_id);
                }
                if(aiomatic_chat_ajax_object.frequency != '')
                {
                    eventURL += '&frequency=' + encodeURIComponent(aiomatic_chat_ajax_object.frequency);
                }
                if(aiomatic_chat_ajax_object.presence != '')
                {
                    eventURL += '&presence=' + encodeURIComponent(aiomatic_chat_ajax_object.presence);
                }
                if(aiomatic_chat_ajax_object.top_p != '')
                {
                    eventURL += '&top_p=' + encodeURIComponent(aiomatic_chat_ajax_object.top_p);
                }
                if(aiomatic_chat_ajax_object.temp != '')
                {
                    eventURL += '&temp=' + encodeURIComponent(aiomatic_chat_ajax_object.temp);
                }
                if(aiomatic_chat_ajax_object.model != '')
                {
                    eventURL += '&model=' + encodeURIComponent(aiomatic_chat_ajax_object.model);
                }
                if(ai_assistant_id != '')
                {
                    eventURL += '&assistant_id=' + encodeURIComponent(ai_assistant_id);
                } 
                if(ai_thread_id != '')
                {
                    eventURL += '&thread_id=' + encodeURIComponent(ai_thread_id);
                }
                if(is_modern_gpt != '')
                {
                    eventURL += '&is_modern_gpt=' + encodeURIComponent(is_modern_gpt);
                }
                if(internet_permission != '')
                {
                    eventURL += '&internet_access=' + encodeURIComponent(internet_permission);
                }
                if(aiomatic_chat_ajax_object.embeddings != '')
                {
                    eventURL += '&embeddings=' + encodeURIComponent(aiomatic_chat_ajax_object.embeddings);
                }
                if(enable_god_mode != '')
                {
                    eventURL += '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
                }
                eventURL += '&bufferid=' + encodeURIComponent(unid);
                if(vision_file != '')
                {
                    eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                }
            }
            try
            {
                eventGenerator = new EventSource(eventURL);
            }
            catch(e)
            {
                console.log('Error in Event creation: ' + e);
            }
            eventGenerator.onopen = function() {
                jQuery('#aistopbut' + instance).show();
            };
            var initialContent = jQuery('#aiomatic_chat_history' + instance).html();
            var error_generated = '';
            var func_call = {
                init_data: {
                    pdf_data: pdf_data, 
                    file_data: file_data, 
                    user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day, 
                    user_id: aiomatic_chat_ajax_object.user_id, 
                    frequency: aiomatic_chat_ajax_object.frequency, 
                    presence: aiomatic_chat_ajax_object.presence, 
                    top_p: aiomatic_chat_ajax_object.top_p, 
                    temp: aiomatic_chat_ajax_object.temp, 
                    model: aiomatic_chat_ajax_object.model, 
                    input_text: input_text, 
                    remember_string: remember_string,
                    is_modern_gpt: is_modern_gpt,
                    user_question: user_question
                },
            };
            function handleContentBlockDelta(e) 
            {
                if(aiomatic_chat_ajax_object.model_type == 'claude')
                {
                    var aiomatic_newline_before = false;
                    var aiomatic_response_events = 0;
                    var aiomatic_limitLines = 1;
                    var currentContent = jQuery('#aiomatic_chat_history' + instance).html();
                    var resultData = null;
                    if(e.data == '[DONE]')
                    {
                        var hasFinishReason = true;
                    }
                    else
                    {
                        try 
                        {
                            resultData = JSON.parse(e.data);
                        } 
                        catch (e) 
                        {
                            console.warn(e);
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                            eventGenerator.close();
                            jQuery('#aistopbut' + instance).hide();
                            return;
                        }
                        var hasFinishReason = resultData &&
                        (resultData.finish_reason === "stop" ||
                        resultData.finish_reason === "length");
                        if(resultData.stop_reason == 'stop_sequence' || resultData.stop_reason == 'max_tokens')
                        {
                            hasFinishReason = true;
                        }
                    }
                    var content_generated = '';
                    if(hasFinishReason){
                        count_line += 1;
                        aiomatic_response_events = 0;
                    }
                    else
                    {
                        if(resultData !== null)
                        {
                            var result = resultData;
                        }
                        else
                        {
                            var result = null;
                            try {
                                result = JSON.parse(e.data);
                            } 
                            catch (e) 
                            {
                                console.warn(e);
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                                jQuery('#aistopbut' + instance).hide();
                                eventGenerator.close();
                                return;
                            };
                        }
                        if(result.error !== undefined){
                            if(result.error !== undefined){
                                error_generated = result.error[0].message;
                            }
                            else
                            {
                                error_generated = JSON.stringify(result.error);
                            }
                            if(error_generated === undefined)
                            {
                                error_generated = result.error.message;
                            }
                            if(error_generated === undefined)
                            {
                                error_generated = result.error;
                            }
                            console.log('Error while processing request(1): ' + error_generated);
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                        }
                        else
                        {
                            if(result.completion !== undefined)
                            {
                                content_generated = result.completion;
                            }
                            else if(result.delta.text !== undefined)
                            {
                                content_generated = result.delta.text;
                            }
                            else
                            {
                                console.log('Unrecognized format: ' + result);
                                content_generated = '';
                            }
                        }
                        response_data += aiomatic_nl2br(content_generated);
                        if((content_generated === '\n' || content_generated === ' \n' || content_generated === '.\n' || content_generated === '\n\n' || content_generated === '.\n\n' || content_generated === '"\n') && aiomatic_response_events > 0 && currentContent !== ''){
                            if(!aiomatic_newline_before) {
                                aiomatic_newline_before = true;
                                jQuery('#aiomatic_chat_history' + instance).html(currentContent + '<br /><br />');
                            }
                        }
                        else if(content_generated === '\n' && aiomatic_response_events === 0  && currentContent === ''){

                        }
                        else{
                            aiomatic_newline_before = false;
                            aiomatic_response_events += 1;
                            jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + response_data + '</div>');
                        }
                    }
                    if(count_line >= aiomatic_limitLines)
                    {
                        eventGenerator.close();
                        jQuery('#aistopbut' + instance).hide();
                        if(extension_email_prompt != '' && error_generated == '')
                        {
                            var matches = AiHtmlDecode(response_data).match(/\[[\s\n]*email[\s\n]*to="([^"]*?)"[\s\n]*subject="([^"]*?)"[\s\n]*content="([^"]*?)"\]/);
                            if(matches !== null && matches !== undefined && matches[1] !== undefined && matches[2] !== undefined && matches[3] !== undefined)
                            {
                                console.log('Sending email to: ' + matches[1] + ' subject: "' + matches[2] + '" content: "' + matches[3] + '"');
                                jQuery.ajax({
                                    type: 'POST',
                                    url: aiomatic_chat_ajax_object.ajax_url,
                                    data: {
                                        action: 'aiomatic_send_email',
                                        nonce: aiomatic_chat_ajax_object.nonce,
                                        to: matches[1],
                                        subject: matches[2],
                                        content: matches[3]
                                    },
                                    success: function(emailresp) 
                                    {
                                        console.log('Email response: ' + emailresp);
                                    },
                                    error: function(error) {
                                        console.log('Error while sending email: ' + error.responseText);
                                    },
                                });
                            }
                        }
                        var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                        if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0' && error_generated == '')
                        {
                            var save_persistent = x_input_text;
                            if(persistent == 'vector')
                            {
                                save_persistent = user_question;
                            }
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_user_meta_save',
                                    nonce: aiomatic_chat_ajax_object.persistentnonce,
                                    persistent: persistent,
                                    thread_id: aiomatic_chat_ajax_object.thread_id,
                                    x_input_text: save_persistent,
                                    user_id: user_id
                                },
                                success: function() {
                                },
                                error: function(error) {
                                    console.log('Error while saving persistent user log: ' + error.responseText);
                                },
                            });
                        }
                        if(error_generated == '')
                        {
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_record_user_usage',
                                    nonce: aiomatic_chat_ajax_object.persistentnonce,
                                    user_id: user_id,
                                    input_text: input_text,
                                    response_text: response_data,
                                    model: model,
                                    temp: temp,
                                    vision_file: vision_file,
                                    user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day
                                },
                                success: function() 
                                {
                                },
                                error: function(error) {
                                    console.log('Error while saving user data: ' + error.responseText);
                                },
                            });
                        }
                        if(error_generated == '')
                        {
                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                        }
                        var has_speech = false;
                        if(aiomatic_chat_ajax_object.receive_message_sound != '')
                        {
                            var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                            snd.play();
                        }
                        if(error_generated == '' && !jQuery('.aiomatic-gg-unmute').length)
                        {
                            if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                            {
                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                if(response_data != '')
                                {
                                    has_speech = true;
                                    let speechData = new FormData();
                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                    speechData.append('x_input_text', response_data);
                                    speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                    var speechRequest = new XMLHttpRequest();
                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                    speechRequest.responseType = "arraybuffer";
                                    speechRequest.ontimeout = () => {
                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };                     
                                    speechRequest.onerror = function () 
                                    {
                                        console.error("Network Error");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onabort = function () 
                                    {
                                        console.error("The request was aborted.");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onload = function () {
                                        var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                        var fr = new FileReader();
                                        fr.onload = function () {
                                            var fileText = this.result;
                                            try {
                                                var errorMessage = JSON.parse(fileText);
                                                console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            } catch (errorBlob) {
                                                var blobUrl = URL.createObjectURL(blob);
                                                var audioElement = document.createElement('audio');
                                                audioElement.src = blobUrl;
                                                audioElement.controls = true;
                                                audioElement.style.marginTop = "2px";
                                                audioElement.style.width = "100%";
                                                audioElement.addEventListener("error", function(event) {
                                                    console.error("Error loading or playing the audio: ", event);
                                                });
                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                audioElement.play();
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            }
                                        }
                                        fr.readAsText(blob);
                                    }
                                    speechRequest.send(speechData);
                                }
                            }
                            else
                            {
                                if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                {
                                    response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                    if(response_data != '')
                                    {
                                        has_speech = true;
                                        let speechData = new FormData();
                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                        speechData.append('x_input_text', response_data);
                                        speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                        var speechRequest = new XMLHttpRequest();
                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                        speechRequest.responseType = "arraybuffer";
                                        speechRequest.ontimeout = () => {
                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };                     
                                        speechRequest.onerror = function () 
                                        {
                                            console.error("Network Error");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onabort = function () 
                                        {
                                            console.error("The request was aborted.");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onload = function () {
                                            var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                            var fr = new FileReader();
                                            fr.onload = function () {
                                                var fileText = this.result;
                                                try {
                                                    var errorMessage = JSON.parse(fileText);
                                                    console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                } catch (errorBlob) {
                                                    var blobUrl = URL.createObjectURL(blob);
                                                    var audioElement = document.createElement('audio');
                                                    audioElement.src = blobUrl;
                                                    audioElement.controls = true;
                                                    audioElement.style.marginTop = "2px";
                                                    audioElement.style.width = "100%";
                                                    audioElement.addEventListener("error", function(event) {
                                                        console.error("Error loading or playing the audio: ", event);
                                                    });
                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                    jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                    audioElement.play();
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            fr.readAsText(blob);
                                        }
                                        speechRequest.send(speechData);
                                    }
                                }
                                else
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'google')
                                    {
                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                        if(response_data != '')
                                        {
                                            has_speech = true;
                                            let speechData = new FormData();
                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                            speechData.append('x_input_text', response_data);
                                            speechData.append('action', 'aiomatic_get_google_voice_chat');
                                            var speechRequest = new XMLHttpRequest();
                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                            speechRequest.ontimeout = () => {
                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };                     
                                            speechRequest.onerror = function () 
                                            {
                                                console.error("Network Error");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onabort = function () 
                                            {
                                                console.error("The request was aborted.");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onload = function () {
                                                var result = speechRequest.responseText;
                                                try {
                                                    var jsonresult = JSON.parse(result);
                                                    if(jsonresult.status === 'success'){
                                                        var byteCharacters = atob(jsonresult.audio);
                                                        const byteNumbers = new Array(byteCharacters.length);
                                                        for (let i = 0; i < byteCharacters.length; i++) {
                                                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                        }
                                                        const byteArray = new Uint8Array(byteNumbers);
                                                        const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                        var blobUrl = URL.createObjectURL(blob);
                                                        var audioElement = document.createElement('audio');
                                                        audioElement.src = blobUrl;
                                                        audioElement.controls = true;
                                                        audioElement.style.marginTop = "2px";
                                                        audioElement.style.width = "100%";
                                                        audioElement.addEventListener("error", function(event) {
                                                            console.error("Error loading or playing the audio: ", event);
                                                        });
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                        jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                        audioElement.play();
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                    else{
                                                        var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                        console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                catch (errorSpeech){
                                                    console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            speechRequest.send(speechData);
                                        }
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'did')
                                        {
                                            response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                            if(response_data != '')
                                            {
                                                has_speech = true;
                                                let speechData = new FormData();
                                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                speechData.append('x_input_text', response_data);
                                                speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                                var speechRequest = new XMLHttpRequest();
                                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                speechRequest.ontimeout = () => {
                                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };                     
                                                speechRequest.onerror = function () 
                                                {
                                                    console.error("Network Error");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onabort = function () 
                                                {
                                                    console.error("The request was aborted.");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onload = function () {
                                                    var result = speechRequest.responseText;
                                                    try 
                                                    {
                                                        var jsonresult = JSON.parse(result);
                                                        if(jsonresult.status === 'success')
                                                        {
                                                            var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-video">' + videoURL + '</div>');
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                        else
                                                        {
                                                            var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                            console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                    catch (errorSpeech){
                                                        console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                speechRequest.send(speechData);
                                            }
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                            {
                                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                if(response_data != '')
                                                {
                                                    if(avatarImageUrl != '' && did_app_id != '')
                                                    {
                                                        if(streamingEpicFail === false)
                                                        {
                                                            has_speech = true;
                                                            myStreamObject.talkToDidStream(response_data);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                {
                                                    var T2S;
                                                    if("speechSynthesis" in window || speechSynthesis)
                                                    {
                                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                        if(response_data != '')
                                                        {
                                                            T2S = window.speechSynthesis || speechSynthesis;
                                                            var utter = new SpeechSynthesisUtterance(response_data);
                                                            var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                            var desiredVoiceName = voiceSetting[0].trim();
                                                            var desiredLang = voiceSetting[1].trim();
                                                            var voices = T2S.getVoices();
                                                            var selectedVoice = voices.find(function(voice) {
                                                                return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                            });
                                                            if (selectedVoice) {
                                                                utter.voice = selectedVoice;
                                                                utter.lang = selectedVoice.lang;
                                                            } 
                                                            else 
                                                            {
                                                                utter.lang = desiredLang;
                                                            }
                                                            T2S.speak(utter);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if(has_speech === false)
                        {
                            if(error_generated == '')
                            {
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                            }
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                        }
                    }
                }
            }
            if(ai_assistant_id != '')
            {
                var run_id = '';
                var func_calls = 0;
                var response_data = '';
                var hasFinishReason = false;
                var content_generated = '';
                var th_id = '';
                eventGenerator.addEventListener('thread.created', threadCreatedEventHandler);
                eventGenerator.addEventListener('thread.run.created', threadRunCreatedEventHandler);
                eventGenerator.addEventListener('thread.run.queued', threadRunQueuedEventHandler);
                eventGenerator.addEventListener('thread.run.in_progress', threadRunInProgressEventHandler);
                eventGenerator.addEventListener('thread.run.requires_action', threadRunRequiresActionEventHandler);
                eventGenerator.addEventListener('thread.run.completed', threadRunCompletedEventHandler);
                eventGenerator.addEventListener('thread.run.failed', threadRunFailedEventHandler);
                eventGenerator.addEventListener('thread.run.cancelling', threadRunCancellingEventHandler);
                eventGenerator.addEventListener('thread.run.cancelled', threadRunCancelledEventHandler);
                eventGenerator.addEventListener('thread.run.expired', threadRunExpiredEventHandler);
                eventGenerator.addEventListener('thread.run.step.created', threadRunStepCreatedEventHandler);
                eventGenerator.addEventListener('thread.run.step.in_progress', threadRunStepInProgressEventHandler);
                eventGenerator.addEventListener('thread.run.step.delta', threadRunStepDeltaEventHandler);
                eventGenerator.addEventListener('thread.run.step.completed', threadRunStepCompletedEventHandler);
                eventGenerator.addEventListener('thread.run.step.failed', threadRunStepFailedEventHandler);
                eventGenerator.addEventListener('thread.run.step.cancelled', threadRunStepCancelledEventHandler);
                eventGenerator.addEventListener('thread.run.step.expired', threadRunStepExpiredEventHandler);
                eventGenerator.addEventListener('thread.message.created', threadMessageCreatedEventHandler);
                eventGenerator.addEventListener('thread.message.in_progress', threadMessageInProgressEventHandler);
                eventGenerator.addEventListener('thread.message.delta', threadMessageDeltaEventHandler);
                eventGenerator.addEventListener('thread.message.incomplete', threadMessageIncompleteEventHandler);
                eventGenerator.addEventListener('thread.message.completed', threadMessageCompletedEventHandler);
                eventGenerator.addEventListener('error', function(e) {
                    var data = JSON.parse(e.data);
                    console.error('Stream Error:', data);
                    hasFinishReason = true;
                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                    aiomaticRmLoading(chatbut);
                    aiomatic_generator_working = false;if (typeof eventGenerator !== 'undefined') 
                    {
                        eventGenerator.close();
                        jQuery('#aistopbut' + instance).hide();
                    }
                });
                
                eventGenerator.addEventListener('done', function(e) {
                    console.log('Stream ended');
                    hasFinishReason = true;
                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                    aiomaticRmLoading(chatbut);
                    aiomatic_generator_working = false;if (typeof eventGenerator !== 'undefined') 
                    {
                        eventGenerator.close();
                        jQuery('#aistopbut' + instance).hide();
                    }
                });
            }
            else
            {
                eventGenerator.onmessage = handleMessageEvent;
                eventGenerator.addEventListener('content_block_delta', handleContentBlockDelta);
                eventGenerator.addEventListener('message_stop', handleMessageStopEvent);
                eventGenerator.addEventListener('completion', handleCompletionEvent);
            }
            function handleMessageStopEvent(e) 
            {
                aiomaticRmLoading(chatbut);
                aiomatic_generator_working = false;
                eventGenerator.close();
                jQuery('#aistopbut' + instance).hide();
                return;
            }
            function threadCreatedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Thread created:', data);
            }
            function threadRunCreatedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run created:', data);
                run_id = data.id;
                th_id = data.thread_id;
            }
            function threadRunQueuedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run queued:', data);
            }
            function threadRunInProgressEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run in_progress:', data);
            }
            function threadRunRequiresActionEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run requires_action:', data);
                if (func_calls > 0) 
                {
                    jQuery.ajax({
                        type: 'POST',
                        async: false,
                        url: aiomatic_chat_ajax_object.ajax_url,
                        data: {
                            action: 'aiomatic_call_ai_function',
                            nonce: aiomatic_chat_ajax_object.persistentnonce,
                            func_call: func_call
                        },
                        success: function(result) 
                        {
                            result = JSON.parse(result);
                            if(result.scope == 'fail')
                            {
                                console.log('Error while calling parsing functions: ' + result);
                                hasFinishReason = true;
                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the request, please try again later.</div>');
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                                if (typeof eventGenerator !== 'undefined') 
                                {
                                    eventGenerator.close();
                                    jQuery('#aistopbut' + instance).hide();
                                }
                                return;
                            }
                            else
                            {
                                if(result.scope == 'response')
                                {
                                    console.log('Recalling AI stream chat');
                                    if (typeof eventGenerator !== 'undefined') 
                                    {
                                        eventGenerator.close();
                                        jQuery('#aistopbut' + instance).hide();
                                    }
                                    if(aiomatic_chat_ajax_object.enable_god_mode == '')
                                    {
                                        aiomatic_chat_ajax_object.enable_god_mode = 'off';
                                    }
                                    var internet_permission = aiomatic_chat_ajax_object.internet_access;
                                    if(jQuery('#aiomatic-globe-overlay' + instance).hasClass('aiomatic-globe-bar'))
                                    {
                                        internet_permission = 'disabled';
                                    }
                                    eventURL = aiomatic_chat_ajax_object.stream_url;
                                    if(pdf_data != '')
                                    {
                                        eventURL += '&pdf_data=' + encodeURIComponent(pdf_data);
                                    }
                                    if(file_data != '')
                                    {
                                        eventURL += '&file_data=' + encodeURIComponent(file_data);
                                    }
                                    if(aiomatic_chat_ajax_object.user_token_cap_per_day != '')
                                    {
                                        eventURL += '&user_token_cap_per_day=' + encodeURIComponent(aiomatic_chat_ajax_object.user_token_cap_per_day);
                                    }
                                    if(aiomatic_chat_ajax_object.user_id != '')
                                    {
                                        eventURL += '&user_id=' + encodeURIComponent(aiomatic_chat_ajax_object.user_id);
                                    }
                                    if(aiomatic_chat_ajax_object.frequency != '')
                                    {
                                        eventURL += '&frequency=' + encodeURIComponent(aiomatic_chat_ajax_object.frequency);
                                    }
                                    if(aiomatic_chat_ajax_object.presence != '')
                                    {
                                        eventURL += '&presence=' + encodeURIComponent(aiomatic_chat_ajax_object.presence);
                                    }
                                    if(aiomatic_chat_ajax_object.top_p != '')
                                    {
                                        eventURL += '&top_p=' + encodeURIComponent(aiomatic_chat_ajax_object.top_p);
                                    }
                                    if(aiomatic_chat_ajax_object.temp != '')
                                    {
                                        eventURL += '&temp=' + encodeURIComponent(aiomatic_chat_ajax_object.temp);
                                    }
                                    if(aiomatic_chat_ajax_object.model != '')
                                    {
                                        eventURL += '&model=' + encodeURIComponent(aiomatic_chat_ajax_object.model);
                                    }
                                    if(ai_assistant_id != '')
                                    {
                                        eventURL += '&assistant_id=' + encodeURIComponent(ai_assistant_id);
                                    }
                                    if(th_id != '')
                                    {
                                        eventURL += '&thread_id=' + encodeURIComponent(th_id);
                                    }
                                    if(remember_string != '')
                                    {
                                        eventURL += '&remember_string=' + encodeURIComponent(remember_string);
                                    }
                                    if(is_modern_gpt != '')
                                    {
                                        eventURL += '&is_modern_gpt=' + encodeURIComponent(is_modern_gpt);
                                    }
                                    if(internet_permission != '')
                                    {
                                        eventURL += '&internet_access=' + encodeURIComponent(internet_permission);
                                    }
                                    if(aiomatic_chat_ajax_object.embeddings != '')
                                    {
                                        eventURL += '&embeddings=' + encodeURIComponent(aiomatic_chat_ajax_object.embeddings);
                                    }
                                    if(user_question != '')
                                    {
                                        eventURL += '&user_question=' + encodeURIComponent(user_question);
                                    }
                                    if(enable_god_mode != '')
                                    {
                                        eventURL += '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
                                    }
                                    eventURL += '&input_text=' + encodeURIComponent(input_text);
                                    if(vision_file != '')
                                    {
                                        eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                                    }
                                    var fnrez = JSON.stringify(result.data);
                                    eventURL += '&functions_result=' + encodeURIComponent(fnrez);
                                    if(run_id != '')
                                    {
                                        eventURL += '&run_id=' + encodeURIComponent(run_id);
                                    }
                                    if(eventURL.length > 2080)
                                    {
                                        console.log('URL too long, using alternative processing method');
                                        var unid = "id" + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);;
                                        aiChatUploadDataomatic(aiomatic_chat_ajax_object, unid, input_text, remember_string, user_question, fnrez);
                                        eventURL = aiomatic_chat_ajax_object.stream_url;
                                        eventURL += '&input_text=0&remember_string=0&user_question=0&functions_result=0';
                                        if(pdf_data != '')
                                        {
                                            eventURL += '&pdf_data=' + encodeURIComponent(pdf_data);
                                        }
                                        if(file_data != '')
                                        {
                                            eventURL += '&file_data=' + encodeURIComponent(file_data);
                                        }
                                        if(aiomatic_chat_ajax_object.user_token_cap_per_day != '')
                                        {
                                            eventURL += '&user_token_cap_per_day=' + encodeURIComponent(aiomatic_chat_ajax_object.user_token_cap_per_day);
                                        }
                                        if(aiomatic_chat_ajax_object.user_id != '')
                                        {
                                            eventURL += '&user_id=' + encodeURIComponent(aiomatic_chat_ajax_object.user_id);
                                        }
                                        if(aiomatic_chat_ajax_object.frequency != '')
                                        {
                                            eventURL += '&frequency=' + encodeURIComponent(aiomatic_chat_ajax_object.frequency);
                                        }
                                        if(aiomatic_chat_ajax_object.presence != '')
                                        {
                                            eventURL += '&presence=' + encodeURIComponent(aiomatic_chat_ajax_object.presence);
                                        }
                                        if(aiomatic_chat_ajax_object.top_p != '')
                                        {
                                            eventURL += '&top_p=' + encodeURIComponent(aiomatic_chat_ajax_object.top_p);
                                        }
                                        if(aiomatic_chat_ajax_object.temp != '')
                                        {
                                            eventURL += '&temp=' + encodeURIComponent(aiomatic_chat_ajax_object.temp);
                                        }
                                        if(aiomatic_chat_ajax_object.model != '')
                                        {
                                            eventURL += '&model=' + encodeURIComponent(aiomatic_chat_ajax_object.model);
                                        }
                                        if(ai_assistant_id != '')
                                        {
                                            eventURL += '&assistant_id=' + encodeURIComponent(ai_assistant_id);
                                        }
                                        if(th_id != '')
                                        {
                                            eventURL += '&thread_id=' + encodeURIComponent(th_id);
                                        }
                                        if(is_modern_gpt != '')
                                        {
                                            eventURL += '&is_modern_gpt=' + encodeURIComponent(is_modern_gpt);
                                        }
                                        if(internet_permission != '')
                                        {
                                            eventURL += '&internet_access=' + encodeURIComponent(internet_permission);
                                        }
                                        if(aiomatic_chat_ajax_object.embeddings != '')
                                        {
                                            eventURL += '&embeddings=' + encodeURIComponent(aiomatic_chat_ajax_object.embeddings);
                                        }
                                        if(enable_god_mode != '')
                                        {
                                            eventURL += '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
                                        }
                                        if(vision_file != '')
                                        {
                                            eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                                        }
                                        if(run_id != '')
                                        {
                                            eventURL += '&run_id=' + encodeURIComponent(run_id);
                                        }
                                        eventURL += '&bufferid=' + encodeURIComponent(unid);
                                    }
                                    func_call = {
                                        init_data: {
                                            pdf_data: pdf_data, 
                                            file_data: file_data,
                                            user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day, 
                                            user_id: aiomatic_chat_ajax_object.user_id, 
                                            frequency: aiomatic_chat_ajax_object.frequency, 
                                            presence: aiomatic_chat_ajax_object.presence, 
                                            top_p: aiomatic_chat_ajax_object.top_p, 
                                            temp: aiomatic_chat_ajax_object.temp, 
                                            model: aiomatic_chat_ajax_object.model, 
                                            input_text: input_text, 
                                            remember_string: remember_string,
                                            is_modern_gpt: is_modern_gpt,
                                            user_question: user_question
                                        },
                                    };
                                    try
                                    {
                                        eventGenerator = new EventSource(eventURL);
                                    }
                                    catch(e)
                                    {
                                        console.log('Error in Event startup: ' + e);
                                    }
                                    eventGenerator.onerror = handleErrorEvent;
                                    hasFinishReason = false;
                                    eventGenerator.addEventListener('thread.created', threadCreatedEventHandler);
                                    eventGenerator.addEventListener('thread.run.created', threadRunCreatedEventHandler);
                                    eventGenerator.addEventListener('thread.run.queued', threadRunQueuedEventHandler);
                                    eventGenerator.addEventListener('thread.run.in_progress', threadRunInProgressEventHandler);
                                    eventGenerator.addEventListener('thread.run.requires_action', threadRunRequiresActionEventHandler);
                                    eventGenerator.addEventListener('thread.run.completed', threadRunCompletedEventHandler);
                                    eventGenerator.addEventListener('thread.run.failed', threadRunFailedEventHandler);
                                    eventGenerator.addEventListener('thread.run.cancelling', threadRunCancellingEventHandler);
                                    eventGenerator.addEventListener('thread.run.cancelled', threadRunCancelledEventHandler);
                                    eventGenerator.addEventListener('thread.run.expired', threadRunExpiredEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.created', threadRunStepCreatedEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.in_progress', threadRunStepInProgressEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.delta', threadRunStepDeltaEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.completed', threadRunStepCompletedEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.failed', threadRunStepFailedEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.cancelled', threadRunStepCancelledEventHandler);
                                    eventGenerator.addEventListener('thread.run.step.expired', threadRunStepExpiredEventHandler);
                                    eventGenerator.addEventListener('thread.message.created', threadMessageCreatedEventHandler);
                                    eventGenerator.addEventListener('thread.message.in_progress', threadMessageInProgressEventHandler);
                                    eventGenerator.addEventListener('thread.message.delta', threadMessageDeltaEventHandler);
                                    eventGenerator.addEventListener('thread.message.incomplete', threadMessageIncompleteEventHandler);
                                    eventGenerator.addEventListener('thread.message.completed', threadMessageCompletedEventHandler);
                                    eventGenerator.addEventListener('error', function(e) {
                                        var data = JSON.parse(e.data);
                                        console.error('Stream Error:', data);
                                        hasFinishReason = true;
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;if (typeof eventGenerator !== 'undefined') 
                                        {
                                            eventGenerator.close();
                                            jQuery('#aistopbut' + instance).hide();
                                        }
                                    });
                                    
                                    eventGenerator.addEventListener('done', function(e) {
                                        console.log('Stream ended');
                                        hasFinishReason = true;
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;if (typeof eventGenerator !== 'undefined') 
                                        {
                                            eventGenerator.close();
                                            jQuery('#aistopbut' + instance).hide();
                                        }
                                    });
                                }
                                else
                                {
                                    if(result.scope == 'user_message')
                                    {
                                        hasFinishReason = true;
                                        jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + result.data + '</div>');
                                        if (typeof eventGenerator !== 'undefined') 
                                        {
                                            eventGenerator.close();
                                            jQuery('#aistopbut' + instance).hide();
                                        }
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    }
                                    else
                                    {
                                        console.log('Unknown scope returned: ' + result);
                                        hasFinishReason = true;
                                        jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the request, please try again later.</div>');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                        if (typeof eventGenerator !== 'undefined') 
                                        {
                                            eventGenerator.close();
                                            jQuery('#aistopbut' + instance).hide();
                                        }
                                        return;
                                    }
                                }
                            }
                        },
                        error: function(error) {
                            console.log('Error while calling AI functions: ' + error.responseText);
                            hasFinishReason = true;
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the request, please try again later.</div>');
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                            if (typeof eventGenerator !== 'undefined') 
                            {
                                eventGenerator.close();
                                jQuery('#aistopbut' + instance).hide();
                            }
                            return;
                        },
                    });
                }
            }
            function threadRunCompletedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run completed:', data);
                eventGenerator.close();
                jQuery('#aistopbut' + instance).hide();
                if(extension_email_prompt != '' && error_generated == '')
                {
                    var matches = AiHtmlDecode(response_data).match(/\[[\s\n]*email[\s\n]*to="([^"]*?)"[\s\n]*subject="([^"]*?)"[\s\n]*content="([^"]*?)"\]/);
                    if(matches !== null && matches !== undefined && matches[1] !== undefined && matches[2] !== undefined && matches[3] !== undefined)
                    {
                        console.log('Sending email to: ' + matches[1] + ' subject: "' + matches[2] + '" content: "' + matches[3] + '"');
                        jQuery.ajax({
                            type: 'POST',
                            url: aiomatic_chat_ajax_object.ajax_url,
                            data: {
                                action: 'aiomatic_send_email',
                                nonce: aiomatic_chat_ajax_object.nonce,
                                to: matches[1],
                                subject: matches[2],
                                content: matches[3]
                            },
                            success: function(emailresp) 
                            {
                                console.log('Email response: ' + emailresp);
                            },
                            error: function(error) {
                                console.log('Error while sending email: ' + error.responseText);
                            },
                        });
                    }
                }
                var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0' && error_generated == '')
                {
                    var save_persistent = x_input_text;
                    if(persistent == 'vector')
                    {
                        save_persistent = user_question;
                    }
                    jQuery.ajax({
                        type: 'POST',
                        url: aiomatic_chat_ajax_object.ajax_url,
                        data: {
                            action: 'aiomatic_user_meta_save',
                            nonce: aiomatic_chat_ajax_object.persistentnonce,
                            persistent: persistent,
                            thread_id: aiomatic_chat_ajax_object.thread_id,
                            x_input_text: save_persistent,
                            user_id: user_id
                        },
                        success: function() {
                        },
                        error: function(error) {
                            console.log('Error while saving persistent user log: ' + error.responseText);
                        },
                    });
                }
                if(error_generated == '')
                {
                    jQuery.ajax({
                        type: 'POST',
                        url: aiomatic_chat_ajax_object.ajax_url,
                        data: {
                            action: 'aiomatic_record_user_usage',
                            nonce: aiomatic_chat_ajax_object.persistentnonce,
                            user_id: user_id,
                            input_text: input_text,
                            response_text: response_data,
                            model: model,
                            temp: temp,
                            vision_file: vision_file,
                            user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day
                        },
                        success: function() 
                        {
                        },
                        error: function(error) {
                            console.log('Error while saving user data: ' + error.responseText);
                        },
                    });
                }
                if(error_generated == '')
                {
                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                }
                var has_speech = false;
                if(aiomatic_chat_ajax_object.receive_message_sound != '')
                {
                    var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                    snd.play();
                }
                if(error_generated == '' && !jQuery('.aiomatic-gg-unmute').length)
                {
                    if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                    {
                        has_speech = true;
                        let speechData = new FormData();
                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                        speechData.append('x_input_text', response_data);
                        speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                        var speechRequest = new XMLHttpRequest();
                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                        speechRequest.responseType = "arraybuffer";
                        speechRequest.ontimeout = () => {
                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                        };                     
                        speechRequest.onerror = function () 
                        {
                            console.error("Network Error");
                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                        };
                        speechRequest.onabort = function () 
                        {
                            console.error("The request was aborted.");
                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                        };
                        speechRequest.onload = function () {
                            var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                            var fr = new FileReader();
                            fr.onload = function () {
                                var fileText = this.result;
                                try {
                                    var errorMessage = JSON.parse(fileText);
                                    console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                } catch (errorBlob) {
                                    var blobUrl = URL.createObjectURL(blob);
                                    var audioElement = document.createElement('audio');
                                    audioElement.src = blobUrl;
                                    audioElement.controls = true;
                                    audioElement.style.marginTop = "2px";
                                    audioElement.style.width = "100%";
                                    audioElement.addEventListener("error", function(event) {
                                        console.error("Error loading or playing the audio: ", event);
                                    });
                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                    jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                    audioElement.play();
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                }
                            }
                            fr.readAsText(blob);
                        }
                        speechRequest.send(speechData);
                    }
                    else
                    {
                        if(aiomatic_chat_ajax_object.text_speech == 'openai')
                        {
                            has_speech = true;
                            let speechData = new FormData();
                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                            speechData.append('x_input_text', response_data);
                            speechData.append('action', 'aiomatic_get_openai_voice_chat');
                            var speechRequest = new XMLHttpRequest();
                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                            speechRequest.responseType = "arraybuffer";
                            speechRequest.ontimeout = () => {
                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                            };                     
                            speechRequest.onerror = function () 
                            {
                                console.error("Network Error");
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                            };
                            speechRequest.onabort = function () 
                            {
                                console.error("The request was aborted.");
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                            };
                            speechRequest.onload = function () {
                                var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                var fr = new FileReader();
                                fr.onload = function () {
                                    var fileText = this.result;
                                    try {
                                        var errorMessage = JSON.parse(fileText);
                                        console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    } catch (errorBlob) {
                                        var blobUrl = URL.createObjectURL(blob);
                                        var audioElement = document.createElement('audio');
                                        audioElement.src = blobUrl;
                                        audioElement.controls = true;
                                        audioElement.style.marginTop = "2px";
                                        audioElement.style.width = "100%";
                                        audioElement.addEventListener("error", function(event) {
                                            console.error("Error loading or playing the audio: ", event);
                                        });
                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                        jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                        audioElement.play();
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    }
                                }
                                fr.readAsText(blob);
                            }
                            speechRequest.send(speechData);
                        }
                        else
                        {
                            if(aiomatic_chat_ajax_object.text_speech == 'google')
                            {
                                has_speech = true;
                                let speechData = new FormData();
                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                speechData.append('x_input_text', response_data);
                                speechData.append('action', 'aiomatic_get_google_voice_chat');
                                var speechRequest = new XMLHttpRequest();
                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                speechRequest.ontimeout = () => {
                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                };                     
                                speechRequest.onerror = function () 
                                {
                                    console.error("Network Error");
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                };
                                speechRequest.onabort = function () 
                                {
                                    console.error("The request was aborted.");
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                };
                                speechRequest.onload = function () {
                                    var result = speechRequest.responseText;
                                    try {
                                        var jsonresult = JSON.parse(result);
                                        if(jsonresult.status === 'success'){
                                            var byteCharacters = atob(jsonresult.audio);
                                            const byteNumbers = new Array(byteCharacters.length);
                                            for (let i = 0; i < byteCharacters.length; i++) {
                                                byteNumbers[i] = byteCharacters.charCodeAt(i);
                                            }
                                            const byteArray = new Uint8Array(byteNumbers);
                                            const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                            var blobUrl = URL.createObjectURL(blob);
                                            var audioElement = document.createElement('audio');
                                            audioElement.src = blobUrl;
                                            audioElement.controls = true;
                                            audioElement.style.marginTop = "2px";
                                            audioElement.style.width = "100%";
                                            audioElement.addEventListener("error", function(event) {
                                                console.error("Error loading or playing the audio: ", event);
                                            });
                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                            jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                            audioElement.play();
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        }
                                        else{
                                            var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                            console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        }
                                    }
                                    catch (errorSpeech){
                                        console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    }
                                }
                                speechRequest.send(speechData);
                            }
                            else
                            {
                                if(aiomatic_chat_ajax_object.text_speech == 'did')
                                {
                                    has_speech = true;
                                    let speechData = new FormData();
                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                    speechData.append('x_input_text', response_data);
                                    speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                    var speechRequest = new XMLHttpRequest();
                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                    speechRequest.ontimeout = () => {
                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };                     
                                    speechRequest.onerror = function () 
                                    {
                                        console.error("Network Error");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onabort = function () 
                                    {
                                        console.error("The request was aborted.");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onload = function () {
                                        var result = speechRequest.responseText;
                                        try 
                                        {
                                            var jsonresult = JSON.parse(result);
                                            if(jsonresult.status === 'success')
                                            {
                                                var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-video">' + videoURL + '</div>');
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            }
                                            else
                                            {
                                                var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            }
                                        }
                                        catch (errorSpeech){
                                            console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        }
                                    }
                                    speechRequest.send(speechData);
                                }
                                else
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                    {
                                        if(avatarImageUrl != '' && did_app_id != '')
                                        {
                                            if(streamingEpicFail === false)
                                            {
                                                has_speech = true;
                                                myStreamObject.talkToDidStream(response_data);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomatic_generator_working = false;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'free')
                                        {
                                            var T2S;
                                            if("speechSynthesis" in window || speechSynthesis)
                                            {
                                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                if(response_data != '')
                                                {
                                                    T2S = window.speechSynthesis || speechSynthesis;
                                                    var utter = new SpeechSynthesisUtterance(response_data);
                                                    var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                    var desiredVoiceName = voiceSetting[0].trim();
                                                    var desiredLang = voiceSetting[1].trim();
                                                    var voices = T2S.getVoices();
                                                    var selectedVoice = voices.find(function(voice) {
                                                        return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                    });
                                                    if (selectedVoice) {
                                                        utter.voice = selectedVoice;
                                                        utter.lang = selectedVoice.lang;
                                                    } 
                                                    else 
                                                    {
                                                        utter.lang = desiredLang;
                                                    }
                                                    T2S.speak(utter);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if(has_speech === false)
                {
                    if(error_generated == '')
                    {
                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                    }
                    aiomaticRmLoading(chatbut);
                    aiomatic_generator_working = false;
                }
            }
            function threadRunCancellingEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run cancelling:', data);
            }
            function threadRunCancelledEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run cancelled:', data);
            }
            function threadRunExpiredEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run expired:', data);
            }
            function threadRunStepCreatedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step created:', data);
            }
            function threadRunStepInProgressEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step in progress:', data);
            }
            function threadRunStepDeltaEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step delta:', data);
                var xarr = {'tool_calls': []};
                xarr.tool_calls.push(data.delta.step_details.tool_calls[0]);
                aiomatic_mergeDeep(func_call, xarr);
                func_calls++;
            }
            function threadRunStepCompletedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step completed:', data);
            }
            function threadRunStepCancelledEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step cancelled:', data);
            }
            function threadRunStepExpiredEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step expired:', data);
            }
            function threadMessageCreatedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run message created:', data);
            }
            function threadMessageInProgressEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run message in progress:', data);
            }
            function threadMessageDeltaEventHandler(e) {
                var data = JSON.parse(e.data);
                if(typeof data.delta.content[0].text.value !== 'undefined')
                {
                    content_generated = data.delta.content[0].text.value;
                    response_data += aiomatic_nl2br(content_generated);
                    jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + response_data + '</div>');
                }
                else
                {
                    console.log('Generated content not found: ' + data);
                }
            }
            function threadMessageIncompleteEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run message incomplete:', data);
                eventGenerator.close();
                jQuery('#aistopbut' + instance).hide();
            }
            function threadRunFailedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run failed:', data);
                console.warn(e);
                aiomaticRmLoading(chatbut);
                aiomatic_generator_working = false;
                eventGenerator.close();
                jQuery('#aistopbut' + instance).hide();
                return;
            }
            function threadRunStepFailedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run step failed:', data);
                console.warn(e);
                aiomaticRmLoading(chatbut);
                aiomatic_generator_working = false;
                eventGenerator.close();
                jQuery('#aistopbut' + instance).hide();
                return;
            }
            function threadMessageCompletedEventHandler(e) {
                var data = JSON.parse(e.data);
                //console.log('Run message completed:', data);
            }
            function handleCompletionEvent(e) 
            {
                if(aiomatic_chat_ajax_object.model_type == 'claude')
                {
                    var aiomatic_newline_before = false;
                    var aiomatic_response_events = 0;
                    var aiomatic_limitLines = 1;
                    var currentContent = jQuery('#aiomatic_chat_history' + instance).html();
                    var resultData = null;
                    if(e.data == '[DONE]')
                    {
                        var hasFinishReason = true;
                    }
                    else
                    {
                        try 
                        {
                            resultData = JSON.parse(e.data);
                        } 
                        catch (e) 
                        {
                            console.warn(e);
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                            eventGenerator.close();
                            jQuery('#aistopbut' + instance).hide();
                            return;
                        }
                        var hasFinishReason = resultData &&
                        (resultData.finish_reason === "stop" ||
                        resultData.finish_reason === "length");
                        if(resultData.stop_reason == 'stop_sequence' || resultData.stop_reason == 'max_tokens')
                        {
                            hasFinishReason = true;
                        }
                    }
                    var content_generated = '';
                    if(hasFinishReason){
                        count_line += 1;
                        aiomatic_response_events = 0;
                    }
                    else
                    {
                        if(resultData !== null)
                        {
                            var result = resultData;
                        }
                        else
                        {
                            var result = null;
                            try {
                                result = JSON.parse(e.data);
                            } 
                            catch (e) 
                            {
                                console.warn(e);
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                                eventGenerator.close();
                                jQuery('#aistopbut' + instance).hide();
                                return;
                            };
                        }
                        if(result.error !== undefined){
                            if(result.error !== undefined){
                                error_generated = result.error[0].message;
                            }
                            else
                            {
                                error_generated = JSON.stringify(result.error);
                            }
                            if(error_generated === undefined)
                            {
                                error_generated = result.error.message;
                            }
                            if(error_generated === undefined)
                            {
                                error_generated = result.error;
                            }
                            console.log('Error while processing request(1): ' + error_generated);
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                        }
                        else
                        {
                            if(result.completion !== undefined)
                            {
                                content_generated = result.completion;
                            }
                            else if(result.content[0].text !== undefined)
                            {
                                content_generated = result.content[0].text;
                            }
                            else
                            {
                                content_generated = '';
                            }
                        }
                        response_data += aiomatic_nl2br(content_generated);
                        if((content_generated === '\n' || content_generated === ' \n' || content_generated === '.\n' || content_generated === '\n\n' || content_generated === '.\n\n' || content_generated === '"\n') && aiomatic_response_events > 0 && currentContent !== ''){
                            if(!aiomatic_newline_before) {
                                aiomatic_newline_before = true;
                                jQuery('#aiomatic_chat_history' + instance).html(currentContent + '<br /><br />');
                            }
                        }
                        else if(content_generated === '\n' && aiomatic_response_events === 0  && currentContent === ''){

                        }
                        else{
                            aiomatic_newline_before = false;
                            aiomatic_response_events += 1;
                            jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + response_data + '</div>');
                        }
                    }
                    if(count_line >= aiomatic_limitLines)
                    {
                        eventGenerator.close();
                        jQuery('#aistopbut' + instance).hide();
                        if(extension_email_prompt != '' && error_generated == '')
                        {
                            var matches = AiHtmlDecode(response_data).match(/\[[\s\n]*email[\s\n]*to="([^"]*?)"[\s\n]*subject="([^"]*?)"[\s\n]*content="([^"]*?)"\]/);
                            if(matches !== null && matches !== undefined && matches[1] !== undefined && matches[2] !== undefined && matches[3] !== undefined)
                            {
                                console.log('Sending email to: ' + matches[1] + ' subject: "' + matches[2] + '" content: "' + matches[3] + '"');
                                jQuery.ajax({
                                    type: 'POST',
                                    url: aiomatic_chat_ajax_object.ajax_url,
                                    data: {
                                        action: 'aiomatic_send_email',
                                        nonce: aiomatic_chat_ajax_object.nonce,
                                        to: matches[1],
                                        subject: matches[2],
                                        content: matches[3]
                                    },
                                    success: function(emailresp) 
                                    {
                                        console.log('Email response: ' + emailresp);
                                    },
                                    error: function(error) {
                                        console.log('Error while sending email: ' + error.responseText);
                                    },
                                });
                            }
                        }
                        var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                        if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0' && error_generated == '')
                        {
                            var save_persistent = x_input_text;
                            if(persistent == 'vector')
                            {
                                save_persistent = user_question;
                            }
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_user_meta_save',
                                    nonce: aiomatic_chat_ajax_object.persistentnonce,
                                    persistent: persistent,
                                    thread_id: aiomatic_chat_ajax_object.thread_id,
                                    x_input_text: save_persistent,
                                    user_id: user_id
                                },
                                success: function() {
                                },
                                error: function(error) {
                                    console.log('Error while saving persistent user log: ' + error.responseText);
                                },
                            });
                        }
                        if(error_generated == '')
                        {
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_record_user_usage',
                                    nonce: aiomatic_chat_ajax_object.persistentnonce,
                                    user_id: user_id,
                                    input_text: input_text,
                                    response_text: response_data,
                                    model: model,
                                    temp: temp,
                                    vision_file: vision_file,
                                    user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day
                                },
                                success: function() 
                                {
                                },
                                error: function(error) {
                                    console.log('Error while saving user data: ' + error.responseText);
                                },
                            });
                        }
                        if(error_generated == '')
                        {
                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                        }
                        var has_speech = false;
                        if(aiomatic_chat_ajax_object.receive_message_sound != '')
                        {
                            var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                            snd.play();
                        }
                        if(error_generated == '' && !jQuery('.aiomatic-gg-unmute').length)
                        {
                            if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                            {
                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                if(response_data != '')
                                {
                                    has_speech = true;
                                    let speechData = new FormData();
                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                    speechData.append('x_input_text', response_data);
                                    speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                    var speechRequest = new XMLHttpRequest();
                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                    speechRequest.responseType = "arraybuffer";
                                    speechRequest.ontimeout = () => {
                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };                     
                                    speechRequest.onerror = function () 
                                    {
                                        console.error("Network Error");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onabort = function () 
                                    {
                                        console.error("The request was aborted.");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onload = function () {
                                        var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                        var fr = new FileReader();
                                        fr.onload = function () {
                                            var fileText = this.result;
                                            try {
                                                var errorMessage = JSON.parse(fileText);
                                                console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            } catch (errorBlob) {
                                                var blobUrl = URL.createObjectURL(blob);
                                                var audioElement = document.createElement('audio');
                                                audioElement.src = blobUrl;
                                                audioElement.controls = true;
                                                audioElement.style.marginTop = "2px";
                                                audioElement.style.width = "100%";
                                                audioElement.addEventListener("error", function(event) {
                                                    console.error("Error loading or playing the audio: ", event);
                                                });
                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                audioElement.play();
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            }
                                        }
                                        fr.readAsText(blob);
                                    }
                                    speechRequest.send(speechData);
                                }
                            }
                            else
                            {
                                if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                {
                                    response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                    if(response_data != '')
                                    {
                                        has_speech = true;
                                        let speechData = new FormData();
                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                        speechData.append('x_input_text', response_data);
                                        speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                        var speechRequest = new XMLHttpRequest();
                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                        speechRequest.responseType = "arraybuffer";
                                        speechRequest.ontimeout = () => {
                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };                     
                                        speechRequest.onerror = function () 
                                        {
                                            console.error("Network Error");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onabort = function () 
                                        {
                                            console.error("The request was aborted.");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onload = function () {
                                            var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                            var fr = new FileReader();
                                            fr.onload = function () {
                                                var fileText = this.result;
                                                try {
                                                    var errorMessage = JSON.parse(fileText);
                                                    console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                } catch (errorBlob) {
                                                    var blobUrl = URL.createObjectURL(blob);
                                                    var audioElement = document.createElement('audio');
                                                    audioElement.src = blobUrl;
                                                    audioElement.controls = true;
                                                    audioElement.style.marginTop = "2px";
                                                    audioElement.style.width = "100%";
                                                    audioElement.addEventListener("error", function(event) {
                                                        console.error("Error loading or playing the audio: ", event);
                                                    });
                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                    jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                    audioElement.play();
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            fr.readAsText(blob);
                                        }
                                        speechRequest.send(speechData);
                                    }
                                }
                                else
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'google')
                                    {
                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                        if(response_data != '')
                                        {
                                            has_speech = true;
                                            let speechData = new FormData();
                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                            speechData.append('x_input_text', response_data);
                                            speechData.append('action', 'aiomatic_get_google_voice_chat');
                                            var speechRequest = new XMLHttpRequest();
                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                            speechRequest.ontimeout = () => {
                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };                     
                                            speechRequest.onerror = function () 
                                            {
                                                console.error("Network Error");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onabort = function () 
                                            {
                                                console.error("The request was aborted.");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onload = function () {
                                                var result = speechRequest.responseText;
                                                try {
                                                    var jsonresult = JSON.parse(result);
                                                    if(jsonresult.status === 'success'){
                                                        var byteCharacters = atob(jsonresult.audio);
                                                        const byteNumbers = new Array(byteCharacters.length);
                                                        for (let i = 0; i < byteCharacters.length; i++) {
                                                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                        }
                                                        const byteArray = new Uint8Array(byteNumbers);
                                                        const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                        var blobUrl = URL.createObjectURL(blob);
                                                        var audioElement = document.createElement('audio');
                                                        audioElement.src = blobUrl;
                                                        audioElement.controls = true;
                                                        audioElement.style.marginTop = "2px";
                                                        audioElement.style.width = "100%";
                                                        audioElement.addEventListener("error", function(event) {
                                                            console.error("Error loading or playing the audio: ", event);
                                                        });
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                        jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                        audioElement.play();
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                    else{
                                                        var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                        console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                catch (errorSpeech){
                                                    console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            speechRequest.send(speechData);
                                        }
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'did')
                                        {
                                            response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                            if(response_data != '')
                                            {
                                                has_speech = true;
                                                let speechData = new FormData();
                                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                speechData.append('x_input_text', response_data);
                                                speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                                var speechRequest = new XMLHttpRequest();
                                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                speechRequest.ontimeout = () => {
                                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };                     
                                                speechRequest.onerror = function () 
                                                {
                                                    console.error("Network Error");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onabort = function () 
                                                {
                                                    console.error("The request was aborted.");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onload = function () {
                                                    var result = speechRequest.responseText;
                                                    try 
                                                    {
                                                        var jsonresult = JSON.parse(result);
                                                        if(jsonresult.status === 'success')
                                                        {
                                                            var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-video">' + videoURL + '</div>');
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                        else
                                                        {
                                                            var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                            console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                    catch (errorSpeech){
                                                        console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                speechRequest.send(speechData);
                                            }
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                            {
                                                response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                if(response_data != '')
                                                {
                                                    if(avatarImageUrl != '' && did_app_id != '')
                                                    {
                                                        if(streamingEpicFail === false)
                                                        {
                                                            has_speech = true;
                                                            myStreamObject.talkToDidStream(response_data);
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomatic_generator_working = false;
                                                        }
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                {
                                                    var T2S;
                                                    if("speechSynthesis" in window || speechSynthesis)
                                                    {
                                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                        if(response_data != '')
                                                        {
                                                            T2S = window.speechSynthesis || speechSynthesis;
                                                            var utter = new SpeechSynthesisUtterance(response_data);
                                                            var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                            var desiredVoiceName = voiceSetting[0].trim();
                                                            var desiredLang = voiceSetting[1].trim();
                                                            var voices = T2S.getVoices();
                                                            var selectedVoice = voices.find(function(voice) {
                                                                return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                            });
                                                            if (selectedVoice) {
                                                                utter.voice = selectedVoice;
                                                                utter.lang = selectedVoice.lang;
                                                            } 
                                                            else 
                                                            {
                                                                utter.lang = desiredLang;
                                                            }
                                                            T2S.speak(utter);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if(has_speech === false)
                        {
                            if(error_generated == '')
                            {
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                            }
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                        }
                    }
                }
            }
            function handleMessageEvent(e)
            {
                if(aiomatic_chat_ajax_object.model_type != 'claude')
                {
                    var aiomatic_newline_before = false;
                    var aiomatic_response_events = 0;
                    var aiomatic_limitLines = 1;
                    var currentContent = jQuery('#aiomatic_chat_history' + instance).html();
                    var resultData = null;
                    if(e.data == '[DONE]')
                    {
                        var hasFinishReason = true;
                    }
                    else
                    {
                        if(aiomatic_chat_ajax_object.model_type != 'google')
                        {
                            try 
                            {
                                resultData = JSON.parse(e.data);
                            } 
                            catch (e) 
                            {
                                console.warn(e);
                                aiomaticRmLoading(chatbut);
                                aiomatic_generator_working = false;
                                eventGenerator.close();
                                jQuery('#aistopbut' + instance).hide();
                                return;
                            }
                            var hasFinishReason = resultData.choices &&
                            resultData.choices[0] &&
                            (resultData.choices[0].finish_reason === "stop" ||
                            resultData.choices[0].finish_reason === "length");
                        }
                    }
                    if(aiomatic_chat_ajax_object.model_type != 'google')
                    {
                        if(aiomatic_chat_ajax_object.model_type != 'ollama')
                        {
                            var content_generated = '';
                            if(hasFinishReason){
                                count_line += 1;
                                aiomatic_response_events = 0;
                            }
                            else
                            {
                                var result = null;
                                try 
                                {
                                    result = JSON.parse(e.data);
                                } 
                                catch (e) 
                                {
                                    console.warn(e);
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    jQuery('#aistopbut' + instance).hide();
                                    return;
                                };
                                if(result.error !== undefined){
                                    if(result.error !== undefined){
                                        error_generated = result.error[0].message;
                                    }
                                    else
                                    {
                                        error_generated = JSON.stringify(result.error);
                                    }
                                    if(error_generated === undefined)
                                    {
                                        error_generated = result.error.message;
                                    }
                                    if(error_generated === undefined)
                                    {
                                        error_generated = result.error;
                                    }
                                    console.log('Error while processing request(2): ' + error_generated);
                                    jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                    eventGenerator.close();
                                    jQuery('#aistopbut' + instance).hide();
                                    return;
                                }
                                else
                                {
                                    if(aiomatic_chat_ajax_object.model_type == 'huggingface')
                                    {
                                        if (result.generated_text)
                                        {
                                            var hasFinishReason = true;
                                            count_line += 1;
                                            aiomatic_response_events = 0;
                                        }
                                        else
                                        {
                                            content_generated = result.token.text;
                                        }
                                    }
                                    else
                                    {
                                        content_generated = result.choices[0].delta !== undefined ? (result.choices[0].delta.content !== undefined ? result.choices[0].delta.content : '') : result.choices[0].text;
                                    }
                                }
                                response_data += aiomatic_nl2br(content_generated);
                                if((content_generated === '\n' || content_generated === ' \n' || content_generated === '.\n' || content_generated === '\n\n' || content_generated === '.\n\n' || content_generated === '"\n') && aiomatic_response_events > 0 && currentContent !== ''){
                                    if(!aiomatic_newline_before) {
                                        aiomatic_newline_before = true;
                                        jQuery('#aiomatic_chat_history' + instance).html(currentContent + '<br /><br />');
                                    }
                                }
                                else if(content_generated === '\n' && aiomatic_response_events === 0  && currentContent === ''){
                                    
                                }
                                else if(response_data == '')
                                {
                                    aiomatic_newline_before = false;
                                    aiomatic_response_events += 1;
                                }
                                else{
                                    aiomatic_newline_before = false;
                                    aiomatic_response_events += 1;
                                    jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + response_data + '</div>');
                                }
                                if(result.choices !== undefined && result.choices[0] !== undefined && result.choices[0].delta !== undefined)
                                {
                                    aiomatic_mergeDeep(func_call, result.choices[0].delta);
                                    if (result.choices[0].finish_reason === "tool_calls" || result.choices[0].finish_reason === "tool_call") 
                                    {
                                        jQuery.ajax({
                                            type: 'POST',
                                            async: false,
                                            url: aiomatic_chat_ajax_object.ajax_url,
                                            data: {
                                                action: 'aiomatic_call_ai_function',
                                                nonce: aiomatic_chat_ajax_object.persistentnonce,
                                                func_call: func_call
                                            },
                                            success: function(result) 
                                            {
                                                result = JSON.parse(result);
                                                if(result.scope == 'fail')
                                                {
                                                    console.log('Error while calling parsing functions: ' + result);
                                                    jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the request, please try again later.</div>');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                    if (typeof eventGenerator !== 'undefined') 
                                                    {
                                                        eventGenerator.close();
                                                        jQuery('#aistopbut' + instance).hide();
                                                    }
                                                    return;
                                                }
                                                else
                                                {
                                                    if(result.scope == 'response')
                                                    {
                                                        console.log('Recalling AI chat');
                                                        if (typeof eventGenerator !== 'undefined') 
                                                        {
                                                            eventGenerator.close();
                                                            jQuery('#aistopbut' + instance).hide();
                                                        }
                                                        if(aiomatic_chat_ajax_object.enable_god_mode == '')
                                                        {
                                                            aiomatic_chat_ajax_object.enable_god_mode = 'off';
                                                        }
                                                        var internet_permission = aiomatic_chat_ajax_object.internet_access;
                                                        if(jQuery('#aiomatic-globe-overlay' + instance).hasClass('aiomatic-globe-bar'))
                                                        {
                                                            internet_permission = 'disabled';
                                                        }
                                                        var eventURL = aiomatic_chat_ajax_object.stream_url;
                                                        eventURL += '&input_text=' + encodeURIComponent(input_text);
                                                        if(pdf_data != '')
                                                        {
                                                            eventURL += '&pdf_data=' + encodeURIComponent(pdf_data);
                                                        }
                                                        if(file_data != '')
                                                        {
                                                            eventURL += '&file_data=' + encodeURIComponent(file_data);
                                                        }
                                                        if(aiomatic_chat_ajax_object.user_token_cap_per_day != '')
                                                        {
                                                            eventURL += '&user_token_cap_per_day=' + encodeURIComponent(aiomatic_chat_ajax_object.user_token_cap_per_day);
                                                        }
                                                        if(aiomatic_chat_ajax_object.user_id != '')
                                                        {
                                                            eventURL += '&user_id=' + encodeURIComponent(aiomatic_chat_ajax_object.user_id);
                                                        }
                                                        if(aiomatic_chat_ajax_object.frequency != '')
                                                        {
                                                            eventURL += '&frequency=' + encodeURIComponent(aiomatic_chat_ajax_object.frequency);
                                                        }
                                                        if(aiomatic_chat_ajax_object.presence != '')
                                                        {
                                                            eventURL += '&presence=' + encodeURIComponent(aiomatic_chat_ajax_object.presence);
                                                        }
                                                        if(aiomatic_chat_ajax_object.top_p != '')
                                                        {
                                                            eventURL += '&top_p=' + encodeURIComponent(aiomatic_chat_ajax_object.top_p);
                                                        }
                                                        if(aiomatic_chat_ajax_object.temp != '')
                                                        {
                                                            eventURL += '&temp=' + encodeURIComponent(aiomatic_chat_ajax_object.temp);
                                                        }
                                                        if(aiomatic_chat_ajax_object.model != '')
                                                        {
                                                            eventURL += '&model=' + encodeURIComponent(aiomatic_chat_ajax_object.model);
                                                        }
                                                        if(ai_assistant_id != '')
                                                        {
                                                            eventURL += '&assistant_id=' + encodeURIComponent(ai_assistant_id);
                                                        }
                                                        if(th_id != '')
                                                        {
                                                            eventURL += '&thread_id=' + encodeURIComponent(th_id);
                                                        }
                                                        if(remember_string != '')
                                                        {
                                                            eventURL += '&remember_string=' + encodeURIComponent(remember_string);
                                                        }
                                                        if(is_modern_gpt != '')
                                                        {
                                                            eventURL += '&is_modern_gpt=' + encodeURIComponent(is_modern_gpt);
                                                        }
                                                        if(internet_permission != '')
                                                        {
                                                            eventURL += '&internet_access=' + encodeURIComponent(internet_permission);
                                                        }
                                                        if(aiomatic_chat_ajax_object.embeddings != '')
                                                        {
                                                            eventURL += '&embeddings=' + encodeURIComponent(aiomatic_chat_ajax_object.embeddings);
                                                        }
                                                        if(user_question != '')
                                                        {
                                                            eventURL += '&user_question=' + encodeURIComponent(user_question);
                                                        }
                                                        if(enable_god_mode != '')
                                                        {
                                                            eventURL += '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
                                                        }
                                                        if(vision_file != '')
                                                        {
                                                            eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                                                        }
                                                        var fnrez = JSON.stringify(result.data);
                                                        eventURL += '&functions_result=' + encodeURIComponent(fnrez);
                                                        if(eventURL.length > 2080)
                                                        {
                                                            console.log('URL too long, using alternative method');
                                                            var unid = "id" + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);;
                                                            aiChatUploadDataomatic(aiomatic_chat_ajax_object, unid, input_text, remember_string, user_question, fnrez);
                                                            var eventURL = aiomatic_chat_ajax_object.stream_url;
                                                            eventURL += '&input_text=0&remember_string=0&user_question=0&functions_result=0';
                                                            if(pdf_data != '')
                                                            {
                                                                eventURL += '&pdf_data=' + encodeURIComponent(pdf_data);
                                                            }
                                                            if(file_data != '')
                                                            {
                                                                eventURL += '&file_data=' + encodeURIComponent(file_data);
                                                            }
                                                            if(aiomatic_chat_ajax_object.user_token_cap_per_day != '')
                                                            {
                                                                eventURL += '&user_token_cap_per_day=' + encodeURIComponent(aiomatic_chat_ajax_object.user_token_cap_per_day);
                                                            }
                                                            if(aiomatic_chat_ajax_object.user_id != '')
                                                            {
                                                                eventURL += '&user_id=' + encodeURIComponent(aiomatic_chat_ajax_object.user_id);
                                                            }
                                                            if(aiomatic_chat_ajax_object.frequency != '')
                                                            {
                                                                eventURL += '&frequency=' + encodeURIComponent(aiomatic_chat_ajax_object.frequency);
                                                            }
                                                            if(aiomatic_chat_ajax_object.presence != '')
                                                            {
                                                                eventURL += '&presence=' + encodeURIComponent(aiomatic_chat_ajax_object.presence);
                                                            }
                                                            if(aiomatic_chat_ajax_object.top_p != '')
                                                            {
                                                                eventURL += '&top_p=' + encodeURIComponent(aiomatic_chat_ajax_object.top_p);
                                                            }
                                                            if(aiomatic_chat_ajax_object.temp != '')
                                                            {
                                                                eventURL += '&temp=' + encodeURIComponent(aiomatic_chat_ajax_object.temp);
                                                            }
                                                            if(aiomatic_chat_ajax_object.model != '')
                                                            {
                                                                eventURL += '&model=' + encodeURIComponent(aiomatic_chat_ajax_object.model);
                                                            }
                                                            if(is_modern_gpt != '')
                                                            {
                                                                eventURL += '&is_modern_gpt=' + encodeURIComponent(is_modern_gpt);
                                                            }
                                                            if(internet_permission != '')
                                                            {
                                                                eventURL += '&internet_access=' + encodeURIComponent(internet_permission);
                                                            }
                                                            if(aiomatic_chat_ajax_object.embeddings != '')
                                                            {
                                                                eventURL += '&embeddings=' + encodeURIComponent(aiomatic_chat_ajax_object.embeddings);
                                                            }
                                                            if(enable_god_mode != '')
                                                            {
                                                                eventURL += '&enable_god_mode=' + encodeURIComponent(enable_god_mode);
                                                            }
                                                            if(vision_file != '')
                                                            {
                                                                eventURL += '&vision_file=' + encodeURIComponent(vision_file);
                                                            }
                                                            eventURL += '&bufferid=' + encodeURIComponent(unid);
                                                        }
                                                        func_call = {
                                                            init_data: {
                                                                pdf_data: pdf_data, 
                                                                file_data: file_data,
                                                                user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day, 
                                                                user_id: aiomatic_chat_ajax_object.user_id, 
                                                                frequency: aiomatic_chat_ajax_object.frequency, 
                                                                presence: aiomatic_chat_ajax_object.presence, 
                                                                top_p: aiomatic_chat_ajax_object.top_p, 
                                                                temp: aiomatic_chat_ajax_object.temp, 
                                                                model: aiomatic_chat_ajax_object.model, 
                                                                input_text: input_text, 
                                                                remember_string: remember_string,
                                                                is_modern_gpt: is_modern_gpt,
                                                                user_question: user_question
                                                            },
                                                        };
                                                        try
                                                        {
                                                            eventGenerator = new EventSource(eventURL);
                                                        }
                                                        catch(e)
                                                        {
                                                            console.log('Error in Event: ' + e);
                                                        }
                                                        eventGenerator.onerror = handleErrorEvent;
                                                        eventGenerator.addEventListener('message_stop', handleMessageStopEvent);
                                                        eventGenerator.addEventListener('completion', handleCompletionEvent);
                                                        eventGenerator.onmessage = handleMessageEvent;
                                                        eventGenerator.addEventListener('content_block_delta', handleContentBlockDelta);
                                                    }
                                                    else
                                                    {
                                                        if(result.scope == 'user_message')
                                                        {
                                                            jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + result.data + '</div>');
                                                            if (typeof eventGenerator !== 'undefined') 
                                                            {
                                                                eventGenerator.close();
                                                                jQuery('#aistopbut' + instance).hide();
                                                            }
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                        else
                                                        {
                                                            console.log('Unknown scope returned: ' + result);
                                                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the request, please try again later.</div>');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                            if (typeof eventGenerator !== 'undefined') 
                                                            {
                                                                eventGenerator.close();
                                                                jQuery('#aistopbut' + instance).hide();
                                                            }
                                                            return;
                                                        }
                                                    }
                                                }
                                            },
                                            error: function(error) {
                                                console.log('Error while calling AI functions: ' + error.responseText);
                                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process the request, please try again later.</div>');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                                if (typeof eventGenerator !== 'undefined') 
                                                {
                                                    eventGenerator.close();
                                                    jQuery('#aistopbut' + instance).hide();
                                                }
                                                return;
                                            },
                                        });
                                    }
                                }
                            }
                        }
                        else
                        {
                            if(Object.hasOwn(resultData, 'done_reason'))
                            {
                                hasFinishReason = true;
                            }
                            if(hasFinishReason){
                                count_line += 1;
                                aiomatic_response_events = 0;
                            }
                            if(e.data == '[ERROR]')
                            {
                                error_generated = 'Failed to get chat response!';
                                console.log('Error while processing request: ' + error_generated);
                                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                                count_line += 1;
                            }
                            else
                            {
                                if(e.data !== '[DONE]')
                                {
                                    if (resultData && resultData.message && typeof resultData.message.content !== 'undefined')
                                    {
                                        response_data += aiomatic_nl2br(resultData.message.content);
                                        aiomatic_response_events += 1;
                                        jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + response_data + '</div>');
                                    }
                                    else
                                    {
                                        error_generated = 'Failed to get chat response!';
                                        console.log('Streaming error: ' + JSON.stringify(resultData));
                                        if(resultData && resultData.error && resultData.error[0] && typeof resultData.error[0].message !== 'undefined')
                                        {
                                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + resultData.error[0].message + '</div>');
                                        }
                                        else
                                        {
                                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + JSON.stringify(resultData) + '</div>');
                                        }
                                        count_line += 1;
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        if(hasFinishReason){
                            count_line += 1;
                            aiomatic_response_events = 0;
                        }
                        if(e.data == '[ERROR]')
                        {
                            error_generated = 'Failed to get chat response!';
                            console.log('Error while processing request: ' + error_generated);
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + error_generated + '</div>');
                            count_line += 1;
                        }
                        else
                        {
                            if(e.data !== '[DONE]')
                            {
                                response_data += aiomatic_nl2br(e.data);
                                aiomatic_response_events += 1;
                                jQuery('#aiomatic_chat_history' + instance).html(initialContent + '<div class="ai-bubble ai-other">' + response_data + '</div>');
                            }
                        }
                    }
                    if(count_line >= aiomatic_limitLines)
                    {
                        eventGenerator.close();
                        jQuery('#aistopbut' + instance).hide();
                        if(extension_email_prompt != '' && error_generated == '')
                        {
                            var matches = AiHtmlDecode(response_data).match(/\[[\s\n]*email[\s\n]*to="([^"]*?)"[\s\n]*subject="([^"]*?)"[\s\n]*content="([^"]*?)"\]/);
                            if(matches !== null && matches !== undefined && matches[1] !== undefined && matches[2] !== undefined && matches[3] !== undefined)
                            {
                                console.log('Sending email to: ' + matches[1] + ' subject: "' + matches[2] + '" content: "' + matches[3] + '"');
                                jQuery.ajax({
                                    type: 'POST',
                                    url: aiomatic_chat_ajax_object.ajax_url,
                                    data: {
                                        action: 'aiomatic_send_email',
                                        nonce: aiomatic_chat_ajax_object.nonce,
                                        to: matches[1],
                                        subject: matches[2],
                                        content: matches[3]
                                    },
                                    success: function(emailresp) 
                                    {
                                        console.log('Email response: ' + emailresp);
                                    },
                                    error: function(error) {
                                        console.log('Error while sending email: ' + error.responseText);
                                    },
                                });
                            }
                        }
                        var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                        if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0' && error_generated == '')
                        {
                            var save_persistent = x_input_text;
                            if(persistent == 'vector')
                            {
                                save_persistent = user_question;
                            }
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_user_meta_save',
                                    nonce: aiomatic_chat_ajax_object.persistentnonce,
                                    persistent: persistent,
                                    thread_id: aiomatic_chat_ajax_object.thread_id,
                                    x_input_text: save_persistent,
                                    user_id: user_id
                                },
                                success: function() {
                                },
                                error: function(error) {
                                    console.log('Error while saving persistent user log: ' + error.responseText);
                                },
                            });
                        }
                        if(error_generated == '')
                        {
                            jQuery.ajax({
                                type: 'POST',
                                url: aiomatic_chat_ajax_object.ajax_url,
                                data: {
                                    action: 'aiomatic_record_user_usage',
                                    nonce: aiomatic_chat_ajax_object.persistentnonce,
                                    user_id: user_id,
                                    input_text: input_text,
                                    response_text: response_data,
                                    model: model,
                                    temp: temp,
                                    vision_file: vision_file,
                                    user_token_cap_per_day: aiomatic_chat_ajax_object.user_token_cap_per_day
                                },
                                success: function() 
                                {
                                },
                                error: function(error) {
                                    console.log('Error while saving user data: ' + error.responseText);
                                },
                            });
                        }
                        if(error_generated == '')
                        {
                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                        }
                        var has_speech = false;
                        if(aiomatic_chat_ajax_object.receive_message_sound != '')
                        {
                            var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                            snd.play();
                        }
                        if(error_generated == '' && !jQuery('.aiomatic-gg-unmute').length)
                        {
                            if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                            {
                                has_speech = true;
                                let speechData = new FormData();
                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                speechData.append('x_input_text', response_data);
                                speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                var speechRequest = new XMLHttpRequest();
                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                speechRequest.responseType = "arraybuffer";
                                speechRequest.ontimeout = () => {
                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                };                     
                                speechRequest.onerror = function () 
                                {
                                    console.error("Network Error");
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                };
                                speechRequest.onabort = function () 
                                {
                                    console.error("The request was aborted.");
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    aiomaticRmLoading(chatbut);
                                    aiomatic_generator_working = false;
                                };
                                speechRequest.onload = function () {
                                    var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                    var fr = new FileReader();
                                    fr.onload = function () {
                                        var fileText = this.result;
                                        try {
                                            var errorMessage = JSON.parse(fileText);
                                            console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        } catch (errorBlob) {
                                            var blobUrl = URL.createObjectURL(blob);
                                            var audioElement = document.createElement('audio');
                                            audioElement.src = blobUrl;
                                            audioElement.controls = true;
                                            audioElement.style.marginTop = "2px";
                                            audioElement.style.width = "100%";
                                            audioElement.addEventListener("error", function(event) {
                                                console.error("Error loading or playing the audio: ", event);
                                            });
                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                            jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                            audioElement.play();
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        }
                                    }
                                    fr.readAsText(blob);
                                }
                                speechRequest.send(speechData);
                            }
                            else
                            {
                                if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                {
                                    has_speech = true;
                                    let speechData = new FormData();
                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                    speechData.append('x_input_text', response_data);
                                    speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                    var speechRequest = new XMLHttpRequest();
                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                    speechRequest.responseType = "arraybuffer";
                                    speechRequest.ontimeout = () => {
                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };                     
                                    speechRequest.onerror = function () 
                                    {
                                        console.error("Network Error");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onabort = function () 
                                    {
                                        console.error("The request was aborted.");
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        aiomaticRmLoading(chatbut);
                                        aiomatic_generator_working = false;
                                    };
                                    speechRequest.onload = function () {
                                        var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                        var fr = new FileReader();
                                        fr.onload = function () {
                                            var fileText = this.result;
                                            try {
                                                var errorMessage = JSON.parse(fileText);
                                                console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            } catch (errorBlob) {
                                                var blobUrl = URL.createObjectURL(blob);
                                                var audioElement = document.createElement('audio');
                                                audioElement.src = blobUrl;
                                                audioElement.controls = true;
                                                audioElement.style.marginTop = "2px";
                                                audioElement.style.width = "100%";
                                                audioElement.addEventListener("error", function(event) {
                                                    console.error("Error loading or playing the audio: ", event);
                                                });
                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                audioElement.play();
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            }
                                        }
                                        fr.readAsText(blob);
                                    }
                                    speechRequest.send(speechData);
                                }
                                else
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'google')
                                    {
                                        has_speech = true;
                                        let speechData = new FormData();
                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                        speechData.append('x_input_text', response_data);
                                        speechData.append('action', 'aiomatic_get_google_voice_chat');
                                        var speechRequest = new XMLHttpRequest();
                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                        speechRequest.ontimeout = () => {
                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };                     
                                        speechRequest.onerror = function () 
                                        {
                                            console.error("Network Error");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onabort = function () 
                                        {
                                            console.error("The request was aborted.");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onload = function () {
                                            var result = speechRequest.responseText;
                                            try {
                                                var jsonresult = JSON.parse(result);
                                                if(jsonresult.status === 'success'){
                                                    var byteCharacters = atob(jsonresult.audio);
                                                    const byteNumbers = new Array(byteCharacters.length);
                                                    for (let i = 0; i < byteCharacters.length; i++) {
                                                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                    }
                                                    const byteArray = new Uint8Array(byteNumbers);
                                                    const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                    var blobUrl = URL.createObjectURL(blob);
                                                    var audioElement = document.createElement('audio');
                                                    audioElement.src = blobUrl;
                                                    audioElement.controls = true;
                                                    audioElement.style.marginTop = "2px";
                                                    audioElement.style.width = "100%";
                                                    audioElement.addEventListener("error", function(event) {
                                                        console.error("Error loading or playing the audio: ", event);
                                                    });
                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                    jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                    audioElement.play();
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                                else{
                                                    var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                    console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            catch (errorSpeech){
                                                console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            }
                                        }
                                        speechRequest.send(speechData);
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'did')
                                        {
                                            has_speech = true;
                                            let speechData = new FormData();
                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                            speechData.append('x_input_text', response_data);
                                            speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                            var speechRequest = new XMLHttpRequest();
                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                            speechRequest.ontimeout = () => {
                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };                     
                                            speechRequest.onerror = function () 
                                            {
                                                console.error("Network Error");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onabort = function () 
                                            {
                                                console.error("The request was aborted.");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onload = function () {
                                                var result = speechRequest.responseText;
                                                try 
                                                {
                                                    var jsonresult = JSON.parse(result);
                                                    if(jsonresult.status === 'success')
                                                    {
                                                        var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-video">' + videoURL + '</div>');
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                    else
                                                    {
                                                        var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                        console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                catch (errorSpeech){
                                                    console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            speechRequest.send(speechData);
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                            {
                                                if(avatarImageUrl != '' && did_app_id != '')
                                                {
                                                    if(streamingEpicFail === false)
                                                    {
                                                        has_speech = true;
                                                        myStreamObject.talkToDidStream(response_data);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                {
                                                    var T2S;
                                                    if("speechSynthesis" in window || speechSynthesis)
                                                    {
                                                        response_data = response_data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                        if(response_data != '')
                                                        {
                                                            T2S = window.speechSynthesis || speechSynthesis;
                                                            var utter = new SpeechSynthesisUtterance(response_data);
                                                            var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                            var desiredVoiceName = voiceSetting[0].trim();
                                                            var desiredLang = voiceSetting[1].trim();
                                                            var voices = T2S.getVoices();
                                                            var selectedVoice = voices.find(function(voice) {
                                                                return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                            });
                                                            if (selectedVoice) {
                                                                utter.voice = selectedVoice;
                                                                utter.lang = selectedVoice.lang;
                                                            } 
                                                            else 
                                                            {
                                                                utter.lang = desiredLang;
                                                            }
                                                            T2S.speak(utter);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if(has_speech === false)
                        {
                            if(error_generated == '')
                            {
                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                            }
                            aiomaticRmLoading(chatbut);
                            aiomatic_generator_working = false;
                        }
                    }
                }
            };
            eventGenerator.onerror = handleErrorEvent;
            function handleErrorEvent(e) 
            {
                console.log('Halting execution, EventGenerator error: ' + JSON.stringify(e));
                jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to process response, please try again later.</div>');
                aiomaticRmLoading(chatbut);
                aiomatic_generator_working = false;
                eventGenerator.close();
                jQuery('#aistopbut' + instance).hide();
            };
        }
        else
        {
            var internet_permission = aiomatic_chat_ajax_object.internet_access;
            if(jQuery('#aiomatic-globe-overlay' + instance).hasClass('aiomatic-globe-bar'))
            {
                internet_permission = 'disabled';
            }
            jQuery.ajax({
                type: 'POST',
                url: aiomatic_chat_ajax_object.ajax_url,
                data: {
                    action: 'aiomatic_chat_submit',
                    input_text: input_text,
                    nonce: aiomatic_chat_ajax_object.nonce,
                    model: model,
                    temp: temp,
                    top_p: top_p,
                    presence: presence,
                    frequency: frequency,
                    user_token_cap_per_day: user_token_cap_per_day,
                    remember_string: remember_string,
                    is_modern_gpt: is_modern_gpt,
                    user_id: user_id,
                    vision_file: vision_file,
                    user_question: user_question,
                    ai_assistant_id: ai_assistant_id,
                    ai_thread_id: ai_thread_id,
                    pdf_data: pdf_data,
                    file_data: file_data,
                    internet_access: internet_permission,
                    embeddings: aiomatic_chat_ajax_object.embeddings,
                    enable_god_mode: enable_god_mode
                },
                success: function(response) {
                    if(typeof response === 'string' || response instanceof String)
                    {
                        try {
                            var responset = JSON.parse(response);
                            response = responset;
                        } catch (error) {
                            console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                        }
                    }
                    if(response.status == 'success')
                    {
                        if(response.thread_id !== undefined)
                        {
                            jQuery('#aiomatic_thread_id' + instance).val(response.thread_id);
                        }
                        if(response.data == '')
                        {
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">AI considers this as the end of the text. Please try using a different text input.</div>');
                        }
                        else
                        {
                            if(ai_message_preppend != '')
                            {
                                response.data = airemovePrefix(response.data.aitrim(), ai_message_preppend);
                                response.data = response.data.aitrim();
                            }
                            if(user_message_preppend != '')
                            {
                                response.data = airemoveAfter(response.data.aitrim(), user_message_preppend);
                                response.data = response.data.aitrim();
                            }
                            response.data = response.data.replace(/\n/g, '<br>');
                            if(extension_email_prompt != '')
                            {
                                var matches = AiHtmlDecode(response.data).match(/\[[\s\n]*email[\s\n]*to="([^"]*?)"[\s\n]*subject="([^"]*?)"[\s\n]*content="([^"]*?)"\]/);
                                if(matches !== null && matches !== undefined && matches[1] !== undefined && matches[2] !== undefined && matches[3] !== undefined)
                                {
                                    console.log('Sending email to: ' + matches[1] + ' subject: "' + matches[2] + '" content: "' + matches[3] + '"');
                                    jQuery.ajax({
                                        type: 'POST',
                                        url: aiomatic_chat_ajax_object.ajax_url,
                                        data: {
                                            action: 'aiomatic_send_email',
                                            nonce: aiomatic_chat_ajax_object.nonce,
                                            to: matches[1],
                                            subject: matches[2],
                                            content: matches[3]
                                        },
                                        success: function(emailresp) 
                                        {
                                            console.log('Email response: ' + emailresp);
                                        },
                                        error: function(error) {
                                            console.log('Error while sending email: ' + error.responseText);
                                        },
                                    });
                                    response.data = response.data.replace(/\[[\s\n]*email[\s\n]*to=&quot;([\s\S]*?)&quot;[\s\n]*subject=&quot;([\s\S]*?)&quot;[\s\n]*content=&quot;([\s\S]*?)&quot;\]/g, "");
                                    if(response.data == '')
                                    {
                                        response.data = 'Ok';
                                    }
                                }
                            }
                            var x_input_text = jQuery('#aiomatic_chat_history' + instance).html();
                            if((persistent != 'off' && persistent != '0' && persistent != '') && user_id != '0')
                            {
                                if(response.thread_id !== undefined)
                                {
                                    var threadid = response.thread_id;
                                }
                                else
                                {
                                    var threadid = aiomatic_chat_ajax_object.thread_id;
                                }
                                var save_persistent = x_input_text;
                                if(persistent == 'vector')
                                {
                                    save_persistent = user_question;
                                }
                                jQuery.ajax({
                                    type: 'POST',
                                    url: aiomatic_chat_ajax_object.ajax_url,
                                    data: {
                                        action: 'aiomatic_user_meta_save',
                                        nonce: aiomatic_chat_ajax_object.persistentnonce,
                                        persistent: persistent,
                                        thread_id: threadid,
                                        x_input_text: save_persistent + '<div class="ai-bubble ai-other">' + response.data + '</div>',
                                        user_id: user_id
                                    },
                                    success: function() {
                                    },
                                    error: function(error) {
                                        console.log('Error while saving persistent user log: ' + error.responseText);
                                    },
                                });
                            }
                            if(instant_response == 'true' || instant_response == 'on')
                            {
                                var has_speech = false;
                                if(aiomatic_chat_ajax_object.receive_message_sound != '')
                                {
                                    var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                                    snd.play();
                                }
                                if(!jQuery('.aiomatic-gg-unmute').length)
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                                    {
                                        has_speech = true;
                                        let speechData = new FormData();
                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                        speechData.append('x_input_text', response.data);
                                        speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                        var speechRequest = new XMLHttpRequest();
                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                        speechRequest.responseType = "arraybuffer";
                                        speechRequest.ontimeout = () => {
                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };                     
                                        speechRequest.onerror = function () 
                                        {
                                            console.error("Network Error");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onabort = function () 
                                        {
                                            console.error("The request was aborted.");
                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                            aiomaticRmLoading(chatbut);
                                            aiomatic_generator_working = false;
                                        };
                                        speechRequest.onload = function () {
                                            var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                            var fr = new FileReader();
                                            fr.onload = function () {
                                                var fileText = this.result;
                                                try {
                                                    var errorMessage = JSON.parse(fileText);
                                                    console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                    // Clear the response container
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    // Enable the submit button
                                                    aiomaticRmLoading(chatbut);
                                                } catch (errorBlob) {
                                                    var blobUrl = URL.createObjectURL(blob);
                                                    var audioElement = document.createElement('audio');
                                                    audioElement.src = blobUrl;
                                                    audioElement.controls = true;
                                                    audioElement.style.marginTop = "2px";
                                                    audioElement.style.width = "100%";
                                                    audioElement.addEventListener("error", function(event) {
                                                        console.error("Error loading or playing the audio: ", event);
                                                    });
                                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                    jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                    audioElement.play();
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                }
                                            }
                                            fr.readAsText(blob);
                                        }
                                        speechRequest.send(speechData);
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                        {
                                            has_speech = true;
                                            let speechData = new FormData();
                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                            speechData.append('x_input_text', response.data);
                                            speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                            var speechRequest = new XMLHttpRequest();
                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                            speechRequest.responseType = "arraybuffer";
                                            speechRequest.ontimeout = () => {
                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };                     
                                            speechRequest.onerror = function () 
                                            {
                                                console.error("Network Error");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onabort = function () 
                                            {
                                                console.error("The request was aborted.");
                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                aiomaticRmLoading(chatbut);
                                                aiomatic_generator_working = false;
                                            };
                                            speechRequest.onload = function () {
                                                var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                                var fr = new FileReader();
                                                fr.onload = function () {
                                                    var fileText = this.result;
                                                    try {
                                                        var errorMessage = JSON.parse(fileText);
                                                        console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                        // Clear the response container
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        // Enable the submit button
                                                        aiomaticRmLoading(chatbut);
                                                    } catch (errorBlob) {
                                                        var blobUrl = URL.createObjectURL(blob);
                                                        var audioElement = document.createElement('audio');
                                                        audioElement.src = blobUrl;
                                                        audioElement.controls = true;
                                                        audioElement.style.marginTop = "2px";
                                                        audioElement.style.width = "100%";
                                                        audioElement.addEventListener("error", function(event) {
                                                            console.error("Error loading or playing the audio: ", event);
                                                        });
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                        jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                        audioElement.play();
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    }
                                                }
                                                fr.readAsText(blob);
                                            }
                                            speechRequest.send(speechData);
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'google')
                                            {
                                                has_speech = true;
                                                let speechData = new FormData();
                                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                speechData.append('x_input_text', response.data);
                                                speechData.append('action', 'aiomatic_get_google_voice_chat');
                                                var speechRequest = new XMLHttpRequest();
                                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                speechRequest.ontimeout = () => {
                                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };                     
                                                speechRequest.onerror = function () 
                                                {
                                                    console.error("Network Error");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onabort = function () 
                                                {
                                                    console.error("The request was aborted.");
                                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                    aiomaticRmLoading(chatbut);
                                                    aiomatic_generator_working = false;
                                                };
                                                speechRequest.onload = function () {
                                                    var result = speechRequest.responseText;
                                                    try {
                                                        var jsonresult = JSON.parse(result);
                                                        if(jsonresult.status === 'success'){
                                                            var byteCharacters = atob(jsonresult.audio);
                                                            const byteNumbers = new Array(byteCharacters.length);
                                                            for (let i = 0; i < byteCharacters.length; i++) {
                                                                byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                            }
                                                            const byteArray = new Uint8Array(byteNumbers);
                                                            const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                            var blobUrl = URL.createObjectURL(blob);
                                                            var audioElement = document.createElement('audio');
                                                            audioElement.src = blobUrl;
                                                            audioElement.controls = true;
                                                            audioElement.style.marginTop = "2px";
                                                            audioElement.style.width = "100%";
                                                            audioElement.addEventListener("error", function(event) {
                                                                console.error("Error loading or playing the audio: ", event);
                                                            });
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-speech"></div>');
                                                            jQuery('#aiomatic_chat_history' + instance + ' .ai-speech').append(audioElement);
                                                            audioElement.play();
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            aiomaticRmLoading(chatbut);
                                                            aiomatic_generator_working = false;
                                                        }
                                                        else{
                                                            var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                            console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                            // Clear the response container
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            // Enable the submit button
                                                            aiomaticRmLoading(chatbut);
                                                        }
                                                    }
                                                    catch (errorSpeech){
                                                        console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                        // Clear the response container
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        // Enable the submit button
                                                        aiomaticRmLoading(chatbut);
                                                    }
                                                }
                                                speechRequest.send(speechData);
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'did')
                                                {
                                                    has_speech = true;
                                                    let speechData = new FormData();
                                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                    speechData.append('x_input_text', response.data);
                                                    speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                                    var speechRequest = new XMLHttpRequest();
                                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                    speechRequest.ontimeout = () => {
                                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };                     
                                                    speechRequest.onerror = function () 
                                                    {
                                                        console.error("Network Error");
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };
                                                    speechRequest.onabort = function () 
                                                    {
                                                        console.error("The request was aborted.");
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        aiomaticRmLoading(chatbut);
                                                        aiomatic_generator_working = false;
                                                    };
                                                    speechRequest.onload = function () {
                                                        var result = speechRequest.responseText;
                                                        try 
                                                        {
                                                            var jsonresult = JSON.parse(result);
                                                            if(jsonresult.status === 'success')
                                                            {
                                                                var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>' + '<div class="ai-video">' + videoURL + '</div>');
                                                                // Clear the response container
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                // Enable the submit button
                                                                aiomaticRmLoading(chatbut);
                                                            }
                                                            else
                                                            {
                                                                var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                                console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                                // Clear the response container
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                                // Enable the submit button
                                                                aiomaticRmLoading(chatbut);
                                                            }
                                                        }
                                                        catch (errorSpeech){
                                                            console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                            // Clear the response container
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            // Enable the submit button
                                                            aiomaticRmLoading(chatbut);
                                                        }
                                                    }
                                                    speechRequest.send(speechData);
                                                }
                                                else
                                                {
                                                    if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                                    {
                                                        if(avatarImageUrl != '' && did_app_id != '')
                                                        {
                                                            if(streamingEpicFail === false)
                                                            {
                                                                has_speech = true;
                                                                myStreamObject.talkToDidStream(response.data);
                                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                                // Clear the response container
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            }
                                                            else
                                                            {
                                                                jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                                // Clear the response container
                                                                jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                            }
                                                        }
                                                        else
                                                        {
                                                            jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                            // Clear the response container
                                                            jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                        {
                                                            var T2S;
                                                            if("speechSynthesis" in window || speechSynthesis)
                                                            {
                                                                var response_data = response.data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                                if(response_data != '')
                                                                {
                                                                    T2S = window.speechSynthesis || speechSynthesis;
                                                                    var utter = new SpeechSynthesisUtterance(response_data);
                                                                    var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                                    var desiredVoiceName = voiceSetting[0].trim();
                                                                    var desiredLang = voiceSetting[1].trim();
                                                                    var voices = T2S.getVoices();
                                                                    var selectedVoice = voices.find(function(voice) {
                                                                        return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                                    });
                                                                    if (selectedVoice) {
                                                                        utter.voice = selectedVoice;
                                                                        utter.lang = selectedVoice.lang;
                                                                    } 
                                                                    else 
                                                                    {
                                                                        utter.lang = desiredLang;
                                                                    }
                                                                    T2S.speak(utter);
                                                                }
                                                            }
                                                        }
                                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                                        // Clear the response container
                                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                                        // Enable the submit button
                                                        aiomaticRmLoading(chatbut);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data + '</div>');
                                    // Clear the response container
                                    jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                    // Enable the submit button
                                    aiomaticRmLoading(chatbut);
                                }
                            }
                            else
                            {
                                var speak_now = false;
                                var has_speech = false;
                                if(aiomatic_chat_ajax_object.receive_message_sound != '')
                                {
                                    var snd = new Audio(aiomatic_chat_ajax_object.receive_message_sound);
                                    snd.play();
                                }
                                if(!jQuery('.aiomatic-gg-unmute').length)
                                {
                                    if(aiomatic_chat_ajax_object.text_speech == 'elevenlabs')
                                    {
                                        has_speech = true;
                                        speak_now = true;
                                        let speechData = new FormData();
                                        speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                        speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                        speechData.append('x_input_text', response.data);
                                        speechData.append('action', 'aiomatic_get_elevenlabs_voice_chat');
                                        var speechRequest = new XMLHttpRequest();
                                        speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                        speechRequest.responseType = "arraybuffer";
                                        speechRequest.ontimeout = () => {
                                            console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                            aiomatic_generator_working = false;
                                            typeWriter();
                                        };                     
                                        speechRequest.onerror = function () 
                                        {
                                            console.error("Network Error");
                                            aiomatic_generator_working = false;
                                            typeWriter();
                                        };
                                        speechRequest.onabort = function () 
                                        {
                                            console.error("The request was aborted.");
                                            aiomatic_generator_working = false;
                                            typeWriter();
                                        };
                                        speechRequest.onload = function () {
                                            var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                            var fr = new FileReader();
                                            fr.onload = function () {
                                                var fileText = this.result;
                                                try {
                                                    var errorMessage = JSON.parse(fileText);
                                                    console.log('ElevenLabs API failed: ' + errorMessage.msg);
                                                    typeWriter();
                                                } catch (errorBlob) {
                                                    var blobUrl = URL.createObjectURL(blob);
                                                    var audioElement = document.createElement('audio');
                                                    audioElement.src = blobUrl;
                                                    audioElement.controls = true;
                                                    audioElement.style.marginTop = "2px";
                                                    audioElement.style.width = "100%";
                                                    audioElement.addEventListener("error", function(event) 
                                                    {
                                                        console.error("Error loading or playing the audio: ", event);
                                                    });
                                                    var aiomatic_speech = audioElement.outerHTML;
                                                    response.data += '</div>' + '<div class="ai-speech">' + aiomatic_speech;
                                                    typeWriter();
                                                    audioElement.play();
                                                }
                                            }
                                            fr.readAsText(blob);
                                        }
                                        speechRequest.send(speechData);
                                    }
                                    else
                                    {
                                        if(aiomatic_chat_ajax_object.text_speech == 'openai')
                                        {
                                            speak_now = true;
                                            has_speech = true;
                                            let speechData = new FormData();
                                            speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                            speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                            speechData.append('x_input_text', response.data);
                                            speechData.append('action', 'aiomatic_get_openai_voice_chat');
                                            var speechRequest = new XMLHttpRequest();
                                            speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                            speechRequest.responseType = "arraybuffer";
                                            speechRequest.ontimeout = () => {
                                                console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                aiomatic_generator_working = false;
                                                typeWriter();
                                            };                     
                                            speechRequest.onerror = function () 
                                            {
                                                console.error("Network Error");
                                                aiomatic_generator_working = false;
                                                typeWriter();
                                            };
                                            speechRequest.onabort = function () 
                                            {
                                                console.error("The request was aborted.");
                                                aiomatic_generator_working = false;
                                                typeWriter();
                                            };
                                            speechRequest.onload = function () {
                                                var blob = new Blob([speechRequest.response], {type: "audio/mpeg"});
                                                var fr = new FileReader();
                                                fr.onload = function () {
                                                    var fileText = this.result;
                                                    try {
                                                        var errorMessage = JSON.parse(fileText);
                                                        console.log('OpenAI TTS API failed: ' + errorMessage.msg);
                                                        typeWriter();
                                                    } catch (errorBlob) {
                                                        var blobUrl = URL.createObjectURL(blob);
                                                        var audioElement = document.createElement('audio');
                                                        audioElement.src = blobUrl;
                                                        audioElement.controls = true;
                                                        audioElement.style.marginTop = "2px";
                                                        audioElement.style.width = "100%";
                                                        audioElement.addEventListener("error", function(event) 
                                                        {
                                                            console.error("Error loading or playing the audio: ", event);
                                                        });
                                                        var aiomatic_speech = audioElement.outerHTML;
                                                        response.data += '</div>' + '<div class="ai-speech">' + aiomatic_speech;
                                                        typeWriter();
                                                        audioElement.play();
                                                    }
                                                }
                                                fr.readAsText(blob);
                                            }
                                            speechRequest.send(speechData);
                                        }
                                        else
                                        {
                                            if(aiomatic_chat_ajax_object.text_speech == 'google')
                                            {
                                                speak_now = true;
                                                has_speech = true;
                                                let speechData = new FormData();
                                                speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                speechData.append('x_input_text', response.data);
                                                speechData.append('action', 'aiomatic_get_google_voice_chat');
                                                var speechRequest = new XMLHttpRequest();
                                                speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                speechRequest.ontimeout = () => {
                                                    console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                    aiomatic_generator_working = false;
                                                    typeWriter();
                                                };                     
                                                speechRequest.onerror = function () 
                                                {
                                                    console.error("Network Error");
                                                    aiomatic_generator_working = false;
                                                    typeWriter();
                                                };
                                                speechRequest.onabort = function () 
                                                {
                                                    console.error("The request was aborted.");
                                                    aiomatic_generator_working = false;
                                                    typeWriter();
                                                };
                                                speechRequest.onload = function () {
                                                    var result = speechRequest.responseText;
                                                    try {
                                                        var jsonresult = JSON.parse(result);
                                                        if(jsonresult.status === 'success'){
                                                            var byteCharacters = atob(jsonresult.audio);
                                                            const byteNumbers = new Array(byteCharacters.length);
                                                            for (let i = 0; i < byteCharacters.length; i++) {
                                                                byteNumbers[i] = byteCharacters.charCodeAt(i);
                                                            }
                                                            const byteArray = new Uint8Array(byteNumbers);
                                                            const blob = new Blob([byteArray], {type: 'audio/mp3'});
                                                            var blobUrl = URL.createObjectURL(blob);
                                                            var audioElement = document.createElement('audio');
                                                            audioElement.src = blobUrl;
                                                            audioElement.controls = true;
                                                            audioElement.style.marginTop = "2px";
                                                            audioElement.style.width = "100%";
                                                            audioElement.addEventListener("error", function(event) 
                                                            {
                                                                console.error("Error loading or playing the audio: ", event);
                                                            });
                                                            var aiomatic_speech = audioElement.outerHTML;
                                                            response.data += '</div>' + '<div class="ai-speech">' + aiomatic_speech;
                                                            typeWriter();
                                                            audioElement.play();
                                                        }
                                                        else{
                                                            var errorMessageDetail = 'Google: ' + jsonresult.msg;
                                                            console.log('Google Text-to-Speech error: ' + errorMessageDetail);
                                                            typeWriter();
                                                        }
                                                    }
                                                    catch (errorSpeech){
                                                        console.log('Exception in Google Text-to-Speech API: ' + errorSpeech);
                                                        typeWriter();
                                                    }
                                                }
                                                speechRequest.send(speechData);
                                            }
                                            else
                                            {
                                                if(aiomatic_chat_ajax_object.text_speech == 'did')
                                                {
                                                    speak_now = true;
                                                    has_speech = true;
                                                    let speechData = new FormData();
                                                    speechData.append('nonce', aiomatic_chat_ajax_object.nonce);
                                                    speechData.append('overwrite_voice', aiomatic_chat_ajax_object.overwrite_voice);
                                                    speechData.append('x_input_text', response.data);
                                                    speechData.append('action', 'aiomatic_get_d_id_video_chat');
                                                    var speechRequest = new XMLHttpRequest();
                                                    speechRequest.open("POST", aiomatic_chat_ajax_object.ajax_url);
                                                    speechRequest.ontimeout = () => {
                                                        console.error(`The request for ` + aiomatic_chat_ajax_object.ajax_url + ` timed out.`);
                                                        aiomatic_generator_working = false;
                                                        typeWriter();
                                                    };                     
                                                    speechRequest.onerror = function () 
                                                    {
                                                        console.error("Network Error");
                                                        aiomatic_generator_working = false;
                                                        typeWriter();
                                                    };
                                                    speechRequest.onabort = function () 
                                                    {
                                                        console.error("The request was aborted.");
                                                        aiomatic_generator_working = false;
                                                        typeWriter();
                                                    };
                                                    speechRequest.onload = function () {
                                                        var result = speechRequest.responseText;
                                                        try 
                                                        {
                                                            var jsonresult = JSON.parse(result);
                                                            if(jsonresult.status === 'success')
                                                            {
                                                                var videoURL = '<video class="ai_video" autoplay="autoplay" controls="controls"><source src="' + jsonresult.video + '" type="video/mp4"></video>';
                                                                response.data += '</div>' + '<div class="ai-video">' + videoURL;
                                                                console.log(response.data);
                                                                typeWriter();
                                                            }
                                                            else
                                                            {
                                                                var errorMessageDetail = 'D-ID: ' + jsonresult.msg;
                                                                console.log('D-ID Text-to-video error: ' + errorMessageDetail);
                                                                typeWriter();
                                                            }
                                                        }
                                                        catch (errorSpeech){
                                                            console.log('Exception in D-ID Text-to-video API: ' + errorSpeech);
                                                            typeWriter();
                                                        }
                                                    }
                                                    speechRequest.send(speechData);
                                                }
                                                else
                                                {
                                                    if(aiomatic_chat_ajax_object.text_speech == 'didstream')
                                                    {
                                                        if(avatarImageUrl != '' && did_app_id != '')
                                                        {
                                                            if(streamingEpicFail === false)
                                                            {
                                                                has_speech = true;
                                                                myStreamObject.talkToDidStream(response.data);
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(aiomatic_chat_ajax_object.text_speech == 'free')
                                                        {
                                                            var T2S;
                                                            if("speechSynthesis" in window || speechSynthesis)
                                                            {
                                                                var response_data = response.data.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                                                                if(response_data != '')
                                                                {
                                                                    T2S = window.speechSynthesis || speechSynthesis;
                                                                    var utter = new SpeechSynthesisUtterance(response_data);
                                                                    var voiceSetting = aiomatic_chat_ajax_object.free_voice.split(";");
                                                                    var desiredVoiceName = voiceSetting[0].trim();
                                                                    var desiredLang = voiceSetting[1].trim();
                                                                    var voices = T2S.getVoices();
                                                                    var selectedVoice = voices.find(function(voice) {
                                                                        return voice.name === desiredVoiceName && voice.lang === desiredLang;
                                                                    });
                                                                    if (selectedVoice) {
                                                                        utter.voice = selectedVoice;
                                                                        utter.lang = selectedVoice.lang;
                                                                    } 
                                                                    else 
                                                                    {
                                                                        utter.lang = desiredLang;
                                                                    }
                                                                    T2S.speak(utter);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                var i = 0;
                                function typeWriter() {
                                    if (i < response.data.length) {
                                        // Append the response to the input field
                                        jQuery('#aiomatic_chat_history' + instance).html(x_input_text + '<div class="ai-bubble ai-other">' + response.data.substring(0, i + 1) + '</div>');
                                        i++;
                                        setTimeout(typeWriter, 50);
                                    } else {
                                        // Clear the response container
                                        jQuery('#openai-chat-response' + instance).html('&nbsp;');
                                        // Enable the submit button
                                        aiomaticRmLoading(chatbut);
                                        i = 0;
                                    }
                                }
                                jQuery('#openai-chat-response' + instance).html('');
                                if(speak_now === false)
                                {
                                    typeWriter();
                                }
                            }
                        }
                    }
                    else
                    {
                        if(typeof response.msg !== 'undefined')
                        {
                            console.log('Error: ' + JSON.stringify(response));
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">' + response.msg + '</div>');
                            aiomaticRmLoading(chatbut);
                        }
                        else
                        {
                            console.log('Error: ' + response);
                            jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Processing failed, please try again</div>');
                            aiomaticRmLoading(chatbut);
                        }
                    }
                    if(has_speech === false)
                    {
                        aiomaticRmLoading(chatbut);
                    }
                },
                error: function(error) 
                {
                    console.log('Error: ' + error.responseText);
                    // Clear the response container
                    jQuery('#openai-chat-response' + instance).html('<div class="text-primary highlight-text" role="status">Failed to generate content, try again later.</div>');
                    // Enable the submit button
                    aiomaticRmLoading(chatbut);
                },
            });
        }
    }
    var recognition;
    var recognizing = false;
    if(aiomatic_chat_ajax_object.enable_copy == 'on')
    {
        jQuery(document).on('click', '.ai-bubble', function (event) {
            var finder = jQuery(event.target);
            if(finder !== null)
            {
                var jsf = finder.html();
                var nlregex = /<br\s*[\/]?>/gi;
                jsf = jsf.replace(nlregex, "\n");
                if(navigator.clipboard !== undefined)
                {
                    navigator.clipboard.writeText(jsf);
                }
            }
            var popup = jQuery("<div class='popup'>Text copied!</div>");
            popup.appendTo("body");
            popup.css({
                "position": "absolute",
                "top": event.pageY + 10,
                "left": event.pageX + 10
            });
            jQuery(document).mousemove(function(event) {
                popup.css({
                    "position": "absolute",
                    "top": event.pageY + 10,
                    "left": event.pageX + 10
                });
            });
            setTimeout(function() {
                popup.remove();
            }, 3000);
        });
    }
    if(aiomatic_chat_ajax_object.scroll_bot == 'on')
    {
        jQuery('#aiomatic_chat_history' + instance).on('DOMSubtreeModified', function(){
            var psconsole = jQuery('#aiomatic_chat_history' + instance);
            if(psconsole.length)
            {
                psconsole.scrollTop(psconsole[0].scrollHeight - psconsole.height());
            }
        });
    }
    if(jQuery('#aiomatic_chat_templates' + instance).length)
    {
        jQuery('#aiomatic_chat_templates' + instance).on('change', function()
        {
            jQuery('#aiomatic_chat_input' + instance).val(jQuery( "#aiomatic_chat_templates" + instance ).val());
        });
    }
    // Check if the browser supports the Web Speech API
    if ('webkitSpeechRecognition' in window) {
        recognition = new webkitSpeechRecognition();
        recognition.onerror = function(event) 
        { 
            console.log('Failed to start speech recognition: ' + JSON.stringify(event));
            recognizing = false;
            if(aiomatic_chat_ajax_object.voice_color !== undefined && aiomatic_chat_ajax_object.voice_color != '' && aiomatic_chat_ajax_object.voice_color != null && aiomatic_chat_ajax_object.voice_color_activated !== undefined && aiomatic_chat_ajax_object.voice_color_activated != '' && aiomatic_chat_ajax_object.voice_color_activated != null)
            {
                document.querySelector( '#openai-chat-speech-button' + instance ).style.setProperty( 'background-color', aiomatic_chat_ajax_object.voice_color, 'important' );
            }
         }

        recognition.onend = function() 
        {
            recognizing = false;
            if(aiomatic_chat_ajax_object.voice_color !== undefined && aiomatic_chat_ajax_object.voice_color != '' && aiomatic_chat_ajax_object.voice_color != null && aiomatic_chat_ajax_object.voice_color_activated !== undefined && aiomatic_chat_ajax_object.voice_color_activated != '' && aiomatic_chat_ajax_object.voice_color_activated != null)
            {
                document.querySelector( '#openai-chat-speech-button' + instance ).style.setProperty( 'background-color', aiomatic_chat_ajax_object.voice_color, 'important' );
            }
        }
        recognition.continuous = true;
        recognition.interimResults = true;

        // Start the speech recognition when the button is clicked
        jQuery('#openai-chat-speech-button' + instance).on('click', function() 
        {
            if (recognizing) 
            {
                try{
                    recognition.stop();
                }
                catch(e)
                {
                    console.log('Speech recognition stop error: ' + e);
                }
                recognizing = false;
                if(aiomatic_chat_ajax_object.voice_color !== undefined && aiomatic_chat_ajax_object.voice_color != '' && aiomatic_chat_ajax_object.voice_color != null && aiomatic_chat_ajax_object.voice_color_activated !== undefined && aiomatic_chat_ajax_object.voice_color_activated != '' && aiomatic_chat_ajax_object.voice_color_activated != null)
                {
                    this.style.setProperty( 'background-color', aiomatic_chat_ajax_object.voice_color, 'important' );
                }
            } 
            else 
            {
                try{
                    recognition.start();
                }
                catch(e)
                {
                    console.log('Speech recognition start error: ' + e);
                }
                recognizing = true;
                if(aiomatic_chat_ajax_object.voice_color !== undefined && aiomatic_chat_ajax_object.voice_color != '' && aiomatic_chat_ajax_object.voice_color != null && aiomatic_chat_ajax_object.voice_color_activated !== undefined && aiomatic_chat_ajax_object.voice_color_activated != '' && aiomatic_chat_ajax_object.voice_color_activated != null)
                {
                    this.style.setProperty( 'background-color', aiomatic_chat_ajax_object.voice_color_activated, 'important' );
                }
            }
        });

        // Handle the speech recognition results
        recognition.onresult = function(event) {
            for (var i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    jQuery('#aiomatic_chat_input' + instance).val(jQuery('#aiomatic_chat_input' + instance).val() + " " + event.results[i][0].transcript);
                    if(aiomatic_chat_ajax_object.auto_submit_voice == 'on')
                    {
                        jQuery('#aichatsubmitbut' + instance).click();
                    }
                }
            }
            
        };
    }
}