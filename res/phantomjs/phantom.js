"use strict";
var system = require('system');
if (system.args.length === 1) {
    phantom.exit();
}
var page = require("webpage").create(),
    url = system.args[1];
page.settings.resourceTimeout = system.args[2];
if(system.args[3] != 'default')
{
    page.settings.userAgent = system.args[3];
}
if(system.args[4] != 'default')
{
    document.cookie = system.args[4];
}
if(system.args[5] != 'default')
{
    var xres = system.args[5].split(":");
    if(xres[1] != undefined)
    {
        page.settings.userName = xres[0];
        page.settings.password = xres[1];
    }
}
var sleeptime = 0;
if(system.args[6] != '0')
{
    sleeptime = parseInt(system.args[6]);
    if(sleeptime === NaN)
    {
        sleeptime = 0;
    }
}
page.onResourceTimeout = function(e) {
  console.log('timeout');
  phantom.exit(1);
};
function onPageReady() {
    var htmlContent = page.evaluate(function () {
        return document.documentElement.outerHTML;
    });
    console.log(htmlContent);
    phantom.exit();
}

page.onError = function(msg, trace) {
    var msgStack = ['ERROR: ' + msg];
    if (trace && trace.length) {
        msgStack.push('TRACE:');
        trace.forEach(function(t) {
            msgStack.push(' -> ' + t.file + ': ' + t.line + (t.function ? ' (in function "' + t.function + '")' : ''));
        });
    }
    // uncomment to log into the console 
    // console.error(msgStack.join('\n'));
};

if(system.args[8] != undefined && system.args[8] != 'default' && system.args[8] != '' && system.args[8] != null)
{
    page.setContent("", encodeURI(url));
    var localStorageVar = system.args[8];
    localStorageVar = localStorageVar.replace(/\\/g, '');
    page.evaluate(function(localStorageVar) {
        localStorageVar = localStorageVar.split(";");
        var k;
        for (k = 0; k < localStorageVar.length; k++) {
            localx = localStorageVar[k].split("=");
            if(localx[1] != undefined && localx[1] != '' && localx[1] != null)
            {
                localStorage.setItem(localx[0], localx[1]);
            }
            else
            {
                if(localx[0] != '')
                {
                    localStorage.setItem(localx[0], '');
                }
            }
        }
    }, localStorageVar);
}
page.open(encodeURI(url), function (status) {
    function checkReadyState() {
        setTimeout(function () {
            var readyState = page.evaluate(function () {
                return document.readyState;
            });

            if ("complete" === readyState) {
                var system = require('system');
                if(system.args[7] !== undefined && system.args[7] != 'default')
                {
                    var evalVar = system.args[7];
                    evalVar = String(evalVar);
                    evalVar = evalVar.replace(/\\/g, '');
                    page.evaluate(function(evalVar) {
                        eval(evalVar);
                    }, evalVar);
                }
                if(sleeptime != 0)
                {
                    setTimeout(onPageReady, sleeptime);
                }
                else
                {
                    onPageReady();
                }
            } else {
                checkReadyState();
            }
        });
    }
    checkReadyState();
});