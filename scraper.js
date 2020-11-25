const fs = require('fs');
const cheerio = require('cheerio');
const got = require('got');

const base_url = 'https://wiki.wargaming.net/en/'
const tanks_url = base_url + 'Medium_Tanks'
got(tanks_url).then(response => {
   const $ = cheerio.load(response.body);
   let all_tanks = $("div[class |= 'b-description-list_item']").children();
   for (let i = 0; i < Object.keys(all_tanks).length; i++) {
      console.log(all_tanks[i].children[3].children[1].children[0].data);
   }
}).catch(err => {
   console.log(err);
});
