"use strict";
var page = require("webpage").create();

var system = require("system");
var args = system.args;
var fs = require("fs");
var timeout = 2000; // you can set default timeout

var path = args[1];
var url = args[2];
var imageName = args[3];
var w = parseInt(args[4]);
var h = parseInt(args[5]);
fs.changeWorkingDirectory("" + path);
var height = 1080;

if (isNaN(w)) {
    w = 1920; // you can set default width
}

if (h > 0) {
    height = h; // you can set default width
}
if(args[6] != 'default')
{
    page.settings.userAgent = args[6];
}
if(args[7] != 'default')
{
    document.cookie = args[7];
}
if(args[8] != 'default')
{
    var xres = args[8].split(":");
    if(xres[1] != undefined)
    {
        page.settings.userName = xres[0];
        page.settings.password = xres[1];
    }
}
page.viewportSize = {
    width: w,
    height: height
};

if(system.args[10] != undefined && system.args[10] != 'default' && system.args[10] != '' && system.args[10] != null)
{
    page.setContent("", encodeURI(url));
    var localStorageVar = system.args[10];
    localStorageVar = localStorageVar.replace(/\\/g, '');
    page.evaluate(function(localStorageVar) {
        localStorageVarx = localStorageVar.split(";");
        var k;
        for (k = 0; k < localStorageVarx.length; k++) 
        {
            localx = localStorageVarx[k].split("=");
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
page.open(encodeURI(url), function() {
	if (h == 0) {
		h = page.evaluate(function(){
			return document.body.scrollHeight;
		});
	}	

    page.viewportSize = {
        width: w,
        height: h
    };

    page.clipRect = {top: 0, left: 0, width: w, height: h};
    var system = require('system');
    if(system.args[9] !== undefined && system.args[9] != 'default')
    {
        var evalVar = system.args[9];
        evalVar = String(evalVar);
        evalVar = evalVar.replace(/\\/g, '');
        page.evaluate(function(evalVar) {
            eval(evalVar);
        }, evalVar);
    }
    window.setTimeout(function () {
        page.render(imageName+".jpg");
        console.log('OK!');
        phantom.exit();
    }, timeout);

});

