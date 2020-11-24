const fs = require('fs');
const cheerio = require('cheerio');
const got = require('got');

const base_url = 'https://wiki.wargaming.net/en/'
const tanks_url = base_url + 'Medium_Tanks'

const get_name_from = (responce) => {

}
got(tanks_url).then(response => {
   const $ = cheerio.load(response.body);
   let all_tanks = $("div[class |= 'b-description-list_item']").children();
   console.log(all_tanks[0].children[4].data);
}).catch(err => {
   console.log(err);
});
