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
const hitpoints_delta = {
   '1' : 50,
   '2' : 50,
   '3' : 90,
   '4' : 100,
   '5' : 100,
   '6' : 150,
   '7' : 200,
   '8' : 200,
   '9' : 300,
   '10': 300
}
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
const dpm_delta = {
   '1' : 100,
   '2' : 110,
   '3' : 130,
   '4' : 200,
   '5' : 150,
   '6' : 160,
   '7' : 160,
   '8' : 160,
   '9' : 170,
   '10': 200 
}
const gen_number = (base, delta, multiplier = 100) => {
   let generated_number = base + Math.floor(
         Math.random()*(2*delta)/multiplier)*multiplier;
   return generated_number;
};
// generate randomly a number 1-10
// pick price, hitpoints and damage, all with +/- multiplier
try {
   let tanks = fs.readFileSync('./tank_data/all_tanks.csv', {encoding: 'utf8'});
   let modified_data = [];
   tanks.split('\n').forEach( (prev_entry) => {
      // generate level 1 -- 10
      let gen_level = Math.floor((Math.random() * 10) + 1); // would this ever overflow ?
      // generate price that depends on the level
      const gen_price = price_br[gen_level] + Math.floor(
         Math.random()*(2*price_delta[gen_level]) + price_delta[gen_level] -
            price_delta[gen_level]);
      // generate hitpoints
      const get_hitp = gen_number(hitpoints_br[gen_level], hitpoints_delta[gen_level]);
      const get_dmg = gen_number(damage_per_minute[gen_level], dpm_delta[gen_level], 10);
      console.log(gen_level + ' --- ' + get_dmg);
      modified_data.push(prev_entry + ',' + gen_price +
         ',' + get_hitp + ',' + get_dmg + '\n');
   });
   fs.writeFileSync('./tank_data/tanks_with_cost.csv', modified_data);
   console.log(modified_data);
} catch{
   console.log('aghh');
}
