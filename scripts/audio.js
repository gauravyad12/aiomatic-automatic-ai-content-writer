"use strict";
jQuery(document).ready(function(){
(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.Recorder = f()}})(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
    "use strict";

    module.exports = require("./recorder").Recorder;

},{"./recorder":2}],2:[function(require,module,exports){
    'use strict';

    var _createClass = (function () {
        function defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
                var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ("value" in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);
            }
        }return function (Constructor, protoProps, staticProps) {
            if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;
        };
    })();

    Object.defineProperty(exports, "__esModule", {
        value: true
    });
    exports.Recorder = undefined;

    var _inlineWorker = require('inline-worker');

    var _inlineWorker2 = _interopRequireDefault(_inlineWorker);

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : { default: obj };
    }

    function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
            throw new TypeError("Cannot call a class as a function");
        }
    }

    var Recorder = exports.Recorder = (function () {
        function Recorder(source, cfg) {
            var _this = this;

            _classCallCheck(this, Recorder);

            this.config = {
                bufferLen: 4096,
                numChannels: 2,
                mimeType: 'audio/wav'
            };
            this.recording = false;
            this.callbacks = {
                getBuffer: [],
                exportWAV: []
            };

            Object.assign(this.config, cfg);
            this.context = source.context;
            this.node = (this.context.createScriptProcessor || this.context.createJavaScriptNode).call(this.context, this.config.bufferLen, this.config.numChannels, this.config.numChannels);

            this.node.onaudioprocess = function (e) {
                if (!_this.recording) return;

                var buffer = [];
                for (var channel = 0; channel < _this.config.numChannels; channel++) {
                    buffer.push(e.inputBuffer.getChannelData(channel));
                }
                _this.worker.postMessage({
                    command: 'record',
                    buffer: buffer
                });
            };

            source.connect(this.node);
            this.node.connect(this.context.destination); //this should not be necessary

            var self = {};
            this.worker = new _inlineWorker2.default(function () {
                var recLength = 0,
                    recBuffers = [],
                    sampleRate = undefined,
                    numChannels = undefined;

                self.onmessage = function (e) {
                    switch (e.data.command) {
                        case 'init':
                            init(e.data.config);
                            break;
                        case 'record':
                            record(e.data.buffer);
                            break;
                        case 'exportWAV':
                            exportWAV(e.data.type);
                            break;
                        case 'getBuffer':
                            getBuffer();
                            break;
                        case 'clear':
                            clear();
                            break;
                    }
                };

                function init(config) {
                    sampleRate = config.sampleRate;
                    numChannels = config.numChannels;
                    initBuffers();
                }

                function record(inputBuffer) {
                    for (var channel = 0; channel < numChannels; channel++) {
                        recBuffers[channel].push(inputBuffer[channel]);
                    }
                    recLength += inputBuffer[0].length;
                }

                function exportWAV(type) {
                    var buffers = [];
                    for (var channel = 0; channel < numChannels; channel++) {
                        buffers.push(mergeBuffers(recBuffers[channel], recLength));
                    }
                    var interleaved = undefined;
                    if (numChannels === 2) {
                        interleaved = interleave(buffers[0], buffers[1]);
                    } else {
                        interleaved = buffers[0];
                    }
                    var dataview = encodeWAV(interleaved);
                    var audioBlob = new Blob([dataview], { type: type });

                    self.postMessage({ command: 'exportWAV', data: audioBlob });
                }

                function getBuffer() {
                    var buffers = [];
                    for (var channel = 0; channel < numChannels; channel++) {
                        buffers.push(mergeBuffers(recBuffers[channel], recLength));
                    }
                    self.postMessage({ command: 'getBuffer', data: buffers });
                }

                function clear() {
                    recLength = 0;
                    recBuffers = [];
                    initBuffers();
                }

                function initBuffers() {
                    for (var channel = 0; channel < numChannels; channel++) {
                        recBuffers[channel] = [];
                    }
                }

                function mergeBuffers(recBuffers, recLength) {
                    var result = new Float32Array(recLength);
                    var offset = 0;
                    for (var i = 0; i < recBuffers.length; i++) {
                        result.set(recBuffers[i], offset);
                        offset += recBuffers[i].length;
                    }
                    return result;
                }

                function interleave(inputL, inputR) {
                    var length = inputL.length + inputR.length;
                    var result = new Float32Array(length);

                    var index = 0,
                        inputIndex = 0;

                    while (index < length) {
                        result[index++] = inputL[inputIndex];
                        result[index++] = inputR[inputIndex];
                        inputIndex++;
                    }
                    return result;
                }

                function floatTo16BitPCM(output, offset, input) {
                    for (var i = 0; i < input.length; i++, offset += 2) {
                        var s = Math.max(-1, Math.min(1, input[i]));
                        output.setInt16(offset, s < 0 ? s * 0x8000 : s * 0x7FFF, true);
                    }
                }

                function writeString(view, offset, string) {
                    for (var i = 0; i < string.length; i++) {
                        view.setUint8(offset + i, string.charCodeAt(i));
                    }
                }

                function encodeWAV(samples) {
                    var buffer = new ArrayBuffer(44 + samples.length * 2);
                    var view = new DataView(buffer);

                    /* RIFF identifier */
                    writeString(view, 0, 'RIFF');
                    /* RIFF chunk length */
                    view.setUint32(4, 36 + samples.length * 2, true);
                    /* RIFF type */
                    writeString(view, 8, 'WAVE');
                    /* format chunk identifier */
                    writeString(view, 12, 'fmt ');
                    /* format chunk length */
                    view.setUint32(16, 16, true);
                    /* sample format (raw) */
                    view.setUint16(20, 1, true);
                    /* channel count */
                    view.setUint16(22, numChannels, true);
                    /* sample rate */
                    view.setUint32(24, sampleRate, true);
                    /* byte rate (sample rate * block align) */
                    view.setUint32(28, sampleRate * 4, true);
                    /* block align (channel count * bytes per sample) */
                    view.setUint16(32, numChannels * 2, true);
                    /* bits per sample */
                    view.setUint16(34, 16, true);
                    /* data chunk identifier */
                    writeString(view, 36, 'data');
                    /* data chunk length */
                    view.setUint32(40, samples.length * 2, true);

                    floatTo16BitPCM(view, 44, samples);

                    return view;
                }
            }, self);

            this.worker.postMessage({
                command: 'init',
                config: {
                    sampleRate: this.context.sampleRate,
                    numChannels: this.config.numChannels
                }
            });

            this.worker.onmessage = function (e) {
                var cb = _this.callbacks[e.data.command].pop();
                if (typeof cb == 'function') {
                    cb(e.data.data);
                }
            };
        }

        _createClass(Recorder, [{
            key: 'record',
            value: function record() {
                this.recording = true;
            }
        }, {
            key: 'stop',
            value: function stop() {
                this.recording = false;
            }
        }, {
            key: 'clear',
            value: function clear() {
                this.worker.postMessage({ command: 'clear' });
            }
        }, {
            key: 'getBuffer',
            value: function getBuffer(cb) {
                cb = cb || this.config.callback;
                if (!cb) throw new Error('Callback not set');

                this.callbacks.getBuffer.push(cb);

                this.worker.postMessage({ command: 'getBuffer' });
            }
        }, {
            key: 'exportWAV',
            value: function exportWAV(cb, mimeType) {
                mimeType = mimeType || this.config.mimeType;
                cb = cb || this.config.callback;
                if (!cb) throw new Error('Callback not set');

                this.callbacks.exportWAV.push(cb);

                this.worker.postMessage({
                    command: 'exportWAV',
                    type: mimeType
                });
            }
        }], [{
            key: 'forceDownload',
            value: function forceDownload(blob, filename) {
                var url = (window.URL || window.webkitURL).createObjectURL(blob);
                var link = window.document.createElement('a');
                link.href = url;
                link.download = filename || 'output.wav';
                var click = document.createEvent("Event");
                click.initEvent("click", true, true);
                link.dispatchEvent(click);
            }
        }]);

        return Recorder;
    })();

    exports.default = Recorder;

},{"inline-worker":3}],3:[function(require,module,exports){
    "use strict";

    module.exports = require("./inline-worker");
},{"./inline-worker":4}],4:[function(require,module,exports){
    (function (global){
        "use strict";

        var _createClass = (function () { function defineProperties(target, props) { for (var key in props) { var prop = props[key]; prop.configurable = true; if (prop.value) prop.writable = true; } Object.defineProperties(target, props); } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

        var _classCallCheck = function (instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } };

        var WORKER_ENABLED = !!(global === global.window && global.URL && global.Blob && global.Worker);

        var InlineWorker = (function () {
            function InlineWorker(func, self) {
                var _this = this;

                _classCallCheck(this, InlineWorker);

                if (WORKER_ENABLED) {
                    var functionBody = func.toString().trim().match(/^function\s*\w*\s*\([\w\s,]*\)\s*{([\w\W]*?)}$/)[1];
                    var url = global.URL.createObjectURL(new global.Blob([functionBody], { type: "text/javascript" }));

                    return new global.Worker(url);
                }

                this.self = self;
                this.self.postMessage = function (data) {
                    setTimeout(function () {
                        _this.onmessage({ data: data });
                    }, 0);
                };

                setTimeout(function () {
                    func.call(self);
                }, 0);
            }

            _createClass(InlineWorker, {
                postMessage: {
                    value: function postMessage(data) {
                        var _this = this;

                        setTimeout(function () {
                            _this.self.onmessage({ data: data });
                        }, 0);
                    }
                }
            });

            return InlineWorker;
        })();

        module.exports = InlineWorker;
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}]},{},[1])(1)
});
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
jQuery('.aiomatic-audio-select').on('click', function (){
    var type = jQuery(this).val();
    jQuery('.aiomatic-audio-type').hide();
    jQuery('.aiomatic-audio-'+type).show();
    jQuery('.aiomatic-audio-'+type).css('visibility','visible'); 
});
jQuery('#button-start-converter').on('click', function (e){
    e.preventDefault();
    var type = jQuery('.aiomatic-audio-select:checked').val();
    var error_message = false;
    var response = 'text';
    if(type === 'upload'){
        if(jQuery('.aiomatic-audio-upload input')[0].files.length === 0){
            error_message = 'An audio file is mandatory.';
        }
        else{
            var file = jQuery('.aiomatic-audio-upload input')[0].files[0];
            if(jQuery.inArray(file.type, aiomatic_audio_mime_types) < 0){
                error_message = 'Accepted file types are mp3, mp4, mpeg, mpga, m4a, wav, or webm'
            }
            else if(file.size > 26214400){
                error_message = 'Audio file maximum 25MB';
            }
        }
    }
    if(!error_message && type === 'url' && jQuery('.aiomatic-audio-url input').val() === ''){
        error_message = 'Please insert audio URL';
    }
    if(!error_message && (response === 'post' || response === 'page') && jQuery('.aiomatic-audio-title').val() === ''){
        error_message = 'The title field is required'
    }
    if(type === 'record' && aiomaticAudioBlob.size > (10 * Math.pow(1024, 25))){
        error_message = 'Audio file maximum 25MB';
    }
    if(error_message){
        alert(error_message)
    }
    else{
        var data = new FormData(jQuery('.aiomatic-audio-form')[0]);
        data.append('action', 'aiomatic_audio_converter');
        data.append('nonce', aiomatic_audio_object.nonce);
        if(type === 'record'){
            data.append('recorded_audio', aiomaticAudioBlob, 'aiomatic_recording.wav');
            aiomaticUploadConverter(data);
        }
        else {
            aiomaticUploadConverter(data);
        }
    }
    return false;
});

function aiomaticUploadConverter(data){
    var btn = jQuery('#button-start-converter');
    jQuery.ajax({
        url: aiomatic_audio_object.ajax_url,
        data: data,
        type: 'POST',
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        xhr: function () {
            var xhr = jQuery.ajaxSettings.xhr();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    aiomatic_progress.find('span').css('width', (Math.round(percentComplete * 100)) + '%');
                }
            }, false);
            return xhr;
        },
        beforeSend: function () {
            jQuery('.button-link-delete').show();
            jQuery('.button-link-delete').css('visibility','visible');
            aiomatic_progress.find('span').css('width', '0');
            aiomatic_progress.show();
            aiomatic_progress.css('visibility','visible');
            aiomaticLoading(btn);
            aiomatic_error_message.hide();
            aiomatic_upload_success.hide();
        },
        success: function (res) {
            if (res.status === 'success') {
                aiomaticRmLoading(btn);
                jQuery('.button-link-delete').hide();
                jQuery('.aiomatic-audio-upload input').val('');
                aiomatic_progress.hide();
                aiomatic_upload_success.show();
                aiomatic_upload_success.css('visibility','visible');
                jQuery('#aiomatic_audio_result').text(res.data);
            } else {
                aiomaticRmLoading(btn);
                jQuery('.button-link-delete').hide();
                aiomatic_progress.find('small').html('Error');
                aiomatic_progress.addClass('aiomatic_error');
                aiomatic_error_message.html(res.msg);
                aiomatic_error_message.show();
                aiomatic_error_message.css('visibility','visible');
            }
        },
        error: function () {
            aiomaticRmLoading(btn);
            jQuery('.button-link-delete').hide();
            aiomatic_progress.addClass('aiomatic_error');
            aiomatic_progress.find('small').html('Error');
            aiomatic_error_message.html('Please try again');
            aiomatic_error_message.show();
            aiomatic_error_message.css('visibility','visible');
        }
    });
}
var aiomatic_audio_mime_types = ['audio/mpeg','video/mp4','video/mpeg','audio/m4a','audio/wav','video/webm'];
var aiomatic_progress = jQuery('.aiomatic_progress');
var aiomatic_error_message = jQuery('.aiomatic-error-msg');
var aiomatic_upload_success = jQuery('.aiomatic_upload_success');
/*Start Record*/
var aiomatic_btn_record = jQuery('#btn-audio-record');
var aiomatic_btn_record_pause = jQuery('#btn-audio-record-pause');
var aiomatic_btn_record_stop = jQuery('#btn-audio-record-stop');
var aiomatic_audio_record_result = jQuery('#aiomatic-audio-record-result');
var aiomaticStream;
var aiomaticRec;
var input;
var aiomaticAudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext;
var aiomaticAudioBlob;
function aiomaticstartRecording() {
    var constraints = { audio: true, video:false }
    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
        audioContext = new aiomaticAudioContext();
        aiomaticStream = stream;
        input = audioContext.createMediaStreamSource(stream);
        aiomaticRec = new Recorder(input,{numChannels:1});
        aiomaticRec.record();
    })
}
function aiomaticpauseRecording(){
    if (aiomaticRec.recording){
        aiomaticRec.stop();
    }
    else{
        aiomaticRec.record()
    }
}
function aiomaticstopRecording() {
    aiomaticRec.stop();
    aiomaticStream.getAudioTracks()[0].stop();
    aiomaticRec.exportWAV(aiomaticcreateDownloadLink);
}
function aiomaticcreateDownloadLink(blob) {
    aiomaticAudioBlob = blob;
    var url = URL.createObjectURL(blob);
    aiomatic_audio_record_result.html('<audio controls="true" src="'+url+'"></audio>');
}
aiomatic_btn_record_pause.on('click', function (){
    if(aiomatic_btn_record_pause.hasClass('aiomatic-paused')){
        aiomatic_btn_record_pause.html('Pause');
        aiomatic_btn_record_pause.removeClass('aiomatic-paused');
    }
    else{
        aiomatic_btn_record_pause.html('Continue');
        aiomatic_btn_record_pause.addClass('aiomatic-paused');
    }
    aiomaticpauseRecording();
})
aiomatic_btn_record.on('click', function (){
    aiomaticstartRecording();
    aiomatic_btn_record.hide();
    aiomatic_audio_record_result.empty();
    aiomatic_audio_record_result.hide();
    aiomatic_btn_record_pause.show();
    aiomatic_btn_record_pause.css('visibility','visible');
    aiomatic_btn_record_stop.show();
    aiomatic_btn_record_stop.css('visibility','visible');
});
aiomatic_btn_record_stop.on('click', function () {
    aiomaticstopRecording();
    aiomatic_btn_record_pause.hide();
    aiomatic_btn_record_stop.hide();
    aiomatic_btn_record.html('Re-Record');
    aiomatic_btn_record.show();
    aiomatic_btn_record.css('visibility','visible');
    aiomatic_audio_record_result.show();
    aiomatic_audio_record_result.css('visibility','visible');
})
jQuery('.aiomatic-audio-purpose').on('change', function (){
    if(jQuery(this).val() === 'translations'){
        jQuery('.aiomatic_languages').hide();
    }
    else{
        jQuery('.aiomatic_languages').show();
        jQuery('.aiomatic_languages').css('visibility','visible');
    }
});
var aiomaticAudioWorking = false;
jQuery('.aiomatic-btn-cancel').on('click', function (){
    var btn = jQuery('#button-start-converter');
    jQuery(this).hide();
    aiomaticRmLoading(btn);
    aiomatic_progress.hide();
    if(aiomaticAudioWorking){
        aiomaticAudioWorking.abort();
    }
});
});