"use strict";
const puppeteer = require('puppeteer');

(async () => {
  var args = process.argv.slice(2);
  process.on('unhandledRejection', up => { throw up })
  var h = parseInt(args[3]);
  var height = 1080;
  var auth_user = '';
  var auth_pass = '';
  if (h > 0) {
    height = h;
  }
  else
  {
    h = 0;
  }
  var argarr = ['--no-sandbox', '--disable-setuid-sandbox', "--font-render-hinting=none"];
  if(args[4] !== undefined && args[4] !== 'null')
  {
    const proxarr = args[4].split("~~~");
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
        argarr.push("--proxy-server=" + args[4]);
      }
  }
  if(args[5] != 'default')
  {
      argarr.push("--user-agent=" + args[5]);
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
  if(args[10] != undefined && args[10] != 'default' && args[10] != '' && args[10] != null)
  {
      var localStorageVar = args[10];
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
  if(args[6] != 'default')
  {
      var kkarr = args[6].split(';');
      kkarr.forEach(async function (value) 
      {
          var cookiesobje = '';
          var splitCookie = value.split('=');
          try {
              cookiesobje += '{"name": "' + splitCookie[0].trim() + '","value": "' + decodeURIComponent(splitCookie[1]) + '", "url": "' + args[0] + '"}';
          } catch (error) {
              cookiesobje += '{"name": "' + splitCookie[0].trim() + '","value": "' + splitCookie[1] + '", "url": "' + args[0] + '"}';
          }
          var cookiesobjex = JSON.parse(cookiesobje);
          await page.setCookie(cookiesobjex);
            
      });
  }
  if(args[7] != 'default')
  {
      var xres = args[7].split(":");
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
  page.setViewport({ width: parseInt(args[2]), height: height });
  if(args[8] != 'default')
  {
      await page.setDefaultNavigationTimeout(args[8]);
  }
  await page.goto(args[0], {waitUntil: 'networkidle2'});
  if (h == 0) {
      await page.evaluate(() => window.scrollTo(0, Number.MAX_SAFE_INTEGER));
  }
  if(args[9] != undefined && args[9] != 'default' && args[9] != '' && args[9] != null)
  {
      var evalVar = args[9];
      evalVar = evalVar.replace(/\\/g, '');
      await page.evaluate((evalVar) => 
      {
          eval(evalVar);   
      }, evalVar);
  }
  await page.waitForTimeout(5000);
  var fP = false;
  if (h == 0) {
	  fP = true;
  }
  await page.screenshot({path: args[1], fullPage: fP});
  console.log('ok');
  await browser.close();
})();

