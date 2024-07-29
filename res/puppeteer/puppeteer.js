"use strict";
function puppeteerDelay(time) {
   return new Promise(function(resolve) { 
       setTimeout(resolve, time)
   });
}
const puppeteer = require('puppeteer');
(async () => {
  var args = process.argv.slice(2);
  process.on('unhandledRejection', up => { throw up })
  var argarr = ['--no-sandbox', '--disable-setuid-sandbox'];
  var auth_user = '';
  var auth_pass = '';
  if(args[1] !== undefined && args[1] !== 'null')
  {
      const proxarr = args[1].split("~~~");
      if(proxarr[1] !== undefined)
      {
        const userpass = proxarr[1].split(":");
        if(userpass[1] !== undefined)
        {
            auth_user = userpass[0];
            auth_pass = userpass[1];
        }
        argarr.push("--proxy-server=" + proxarr[0]);
      }
      else
      {
        argarr.push("--proxy-server=" + args[1]);
      }
  }
  if(args[2] != 'default')
  {
      argarr.push("--user-agent=" + args[2]);
  }
  const browser = await puppeteer.launch({ignoreHTTPSErrors:true, args: argarr});
  const page = (await browser.pages())[0];
  if(auth_pass != '')
  {
    await page.authenticate({        
        username: auth_user,
        password: auth_pass
    });
  }
  if(args[8] != undefined && args[8] != 'default' && args[8] != '' && args[8] != null)
  {
      var localStorageVar = args[8];
      localStorageVar = localStorageVar.replace(/\\/g, '');
      await page.evaluateOnNewDocument((localStorageVar) => 
      {
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
  if(args[3] != 'default')
  {
      var kkarr = args[3].split(';');
      kkarr.forEach(async function (value) 
      {
          var cookiesobje = '';
          var splitCookie = value.split('=');
          if(splitCookie[1] !== undefined)
          {
            try {
                cookiesobje += '{"name": "' + splitCookie[0].trim() + '","value": "' + decodeURIComponent(splitCookie[1]) + '", "url": "' + args[0] + '"}';
            } catch (error) {
                cookiesobje += '{"name": "' + splitCookie[0].trim() + '","value": "' + splitCookie[1] + '", "url": "' + args[0] + '"}';
            }
            if(cookiesobje != '')
            {
                try 
                {
                    var cookiesobjex = JSON.parse(cookiesobje);
                    await page.setCookie(cookiesobjex);
                }
                catch(error) 
                {
                }
            }
          }
      });
  }
  if(args[4] != 'default')
  {
      var xres = args[4].split(":");
      if(xres[1] != undefined)
      {
          var user = xres[0];
          var pass = xres[1];
          const auth = new Buffer(`${user}:${pass}`).toString('base64');
          await page.setExtraHTTPHeaders({
              'Authorization': `Basic ${auth}`                    
          });
      }
  }
  if(args[5] != 'default')
  {
      await page.setDefaultNavigationTimeout(args[5]);
  }
  await page.goto(args[0], {waitUntil: 'networkidle2'});
  const bodyWidth = await page.evaluate(() => document.body.scrollWidth);
  const bodyHeight = await page.evaluate(() => document.body.scrollHeight);
  await page.setViewport({ width: bodyWidth, height: bodyHeight });
  await page.evaluate(() => window.scrollTo(0, Number.MAX_SAFE_INTEGER));
  if(args[6] != 'default' && args[6] != '' && args[6] != '0')
  {
      await puppeteerDelay(args[6]);
  }
  if(args[7] != undefined && args[7] != 'default' && args[7] != '' && args[7] != null)
  {
      var evalVar = args[7];
      evalVar = evalVar.replace(/\\/g, '');
      await page.evaluate((evalVar) => 
      {
          eval(evalVar);   
      }, evalVar);
  }
  let bodyHTML = await page.content();
  console.log(bodyHTML);
  await browser.close();
})();