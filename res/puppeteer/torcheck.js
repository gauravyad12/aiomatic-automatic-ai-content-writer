"use strict";
const puppeteer = require('puppeteer');
(async () => {
  var args = process.argv.slice(2);
  process.on('unhandledRejection', up => { throw up })
  var argarr = ['--no-sandbox', '--disable-setuid-sandbox'];
  if(args[2] != 'default')
  {
      argarr.push("--user-agent=" + args[2]);
  }
  argarr.push("--proxy-server=socks5://127.0.0.1:9050");
  const browser = await puppeteer.launch({ignoreHTTPSErrors:true, args: argarr});
  
  if(args[5] != '1')
  {
      //check if tor ok
      const page2 = (await browser.pages())[0];
      if(args[5] != 'default')
      {
          await page2.setDefaultNavigationTimeout(args[5]);
      }
      await page2.goto('https://check.torproject.org/');
      const isUsingTor = await page2.$eval('body', el =>
          el.innerHTML.includes('Congratulations. This browser is configured to use Tor')
          );
      if (!isUsingTor) {
          console.log('CRAWLOMATIC NOT USING TOR!');
          await browser.close()
          return;
      }
  }
  console.log('TOR OK!');
  await browser.close();
})();