const puppeteer = require("puppeteer-extra");
const fs = require("fs");
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())
puppeteer.launch({ headless: false, args:[
        '--start-maximized'
    ],slowMO:500 }).then(async browser => {

    const page = await browser.newPage();
    await page.setViewport({
        width: 1280,
        height: 760,
        deviceScaleFactor: 1,
    });
     const url = process.argv[2];
   //const url = 'https://www.kayak.co.uk/flights/LON-PFO/2024-01-10?sort=bestflight_a&fs=stops=-0';
    await page.goto(url, { waitUntil: 'domcontentloaded' });

   // await page.waitForSelector('.vrY3');
   // await page.click('.vrY3 .iInN .iInN-footer button');
    await page.waitForSelector('.Hv20-content .Hv20-value div span');

    let data = await page.evaluate(() => {
        let results = [];
        let price = document.querySelector('.Hv20-content .Hv20-value div span');
        results.push({
            price:price.innerHTML
        })
        return results;
    });
    const fs = require('fs');
    fs.writeFileSync('scrape/flightPrice.json',JSON.stringify(data));

   // fs.writeFileSync('/var/www/html/stephennurse/public/scrape/flightPrice.json',JSON.stringify(data));
   // console.log(data);

    browser.close();
})
// run();


