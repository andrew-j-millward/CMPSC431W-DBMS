const cheerio = require('cheerio');
const got = require('got');

// not used, just for reference
const countries_id = {
   "U.S.A": 1,
   "U.K": 2,
   "Germany": 3,
   "France": 4,
   "U.S.S.R": 5,
   "China": 6,
   "Japan": 7,
   "Sweden": 8,
   "Poland": 9,
   "Czechoslovakia": 10,
   "Italy": 11
};
const roles = {
   'Self-Propelled_Guns': 5,
   'Light_Tanks': 1,
   'Medium_Tanks': 2,
   'Tank_Destroyers': 4
}
const base_url = 'https://wiki.wargaming.net/en/';
const role_url = 'Tank_Destroyers';
let retrieve_list = new Promise((resolve, reject) => {
   let tanks_url = base_url + role_url;
   let tanks_list = [];
   got(tanks_url).then(response => {
      const $ = cheerio.load(response.body);
      let all_tanks = $("div[class |= 'b-description-list_item']").children();
      for (let i = 0; i < Object.keys(all_tanks).length && 
            all_tanks[i] != undefined; i++) {
         const tank_name = all_tanks[i].children[3].children[1].children[0].data;
         tanks_list.push(tank_name + ',' + roles[role_url]);
         console.log(tank_name + ',' + roles[role_url]);
         resolve(tanks_list);
      }
   }).catch(err => {
      console.log(err);
      reject('couldn\'t access server');
   });
});

// use the console log in the callback above to get data.
retrieve_list.then((data) => {
//   console.log(data);
})
