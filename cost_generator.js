const fs = require('fs');

// randomly give 1 for each tank at +/- 10*x
const price_br = {
   '1' : 1000,
   '2' : 3500,
   '3' : 37000, 
   '4' : 137000,
   '5' : 356700, 
   '6' : 925000,
   '7' : 1450000,
   '8' : 2500000, 
   '9' : 3565000,
   '10': 6100000
};
const price_delta = {
   '1' : 1000,
   '2' : 1000,
   '3' : 5000, 
   '4' : 10000,
   '5' : 20000, 
   '6' : 30000,
   '7' : 50000,
   '8' : 70000, 
   '9' : 100000,
   '10': 0
}
const hitpoints_br = {
   '1' : 200,
   '2' : 320,
   '3' : 390,
   '4' : 500,
   '5' : 570,
   '6' : 820,
   '7' : 1100,
   '8' : 1400,
   '9' : 1800,
   '10': 2400
};
const damage_per_minute = {
   '1' : 300,
   '2' : 520,
   '3' : 700,
   '4' : 800,
   '5' : 1170,
   '6' : 1300,
   '7' : 1500,
   '8' : 1700,
   '9' : 1900,
   '10': 2100
}
// generate randomly a number 1-10
// pick price, hitpoints and damage, all with +/- multiplier
try {
   let tanks = fs.readFileSync('./tank_data/all_tanks.csv', {encoding: 'utf8'});
   let modified_data = [];
   tanks.split('\n').forEach( () => {
      let gen_level = Math.floor((Math.random() * 9) + 1);
      const gen_price = price_br[gen_level] + Math.floor(
         Math.random()*(2*price_delta[gen_level]) + price_delta[gen_level] -
            price_delta[gen_level]);
      console.log(gen_level + ' --- ' + Math.floor(gen_price/100)*100);
   })
//   fs.writeFileSync(path, data)
   console.log(tanks.split('\n')[0]);
} catch{
   console.log('aghh');
}
