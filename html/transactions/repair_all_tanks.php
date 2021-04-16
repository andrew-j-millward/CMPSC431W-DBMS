<?php

include '../user_info.php';
include '../globals.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = '431W_project';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Purchasing Tank...</title>
    </head>
    <body>	
      <p>
<?php
session_start();

try {
   $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);



   // OUTSIDE IN
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   #$conn->exec($sql_start_txn);
   #$conn->exec($commit);

   $conn->exec($start_txn);

   $check_balance = $conn->query('SELECT ubalance FROM users WHERE uid="' . $_SESSION["uid"] . '"');
   $check_price = $conn->query('SELECT sum(T.price) as t_price FROM inventory_tanks IT, tanks T WHERE IT.uid="' . $_SESSION["uid"] . '" AND IT.ready_to_battle=1 AND IT.tid=T.tid');

   $check_balance->setFetchMode(PDO::FETCH_ASSOC);
   $check_price->setFetchMode(PDO::FETCH_ASSOC);

   $price = intval($check_price->fetch()["t_price"]/2);
   #CHECK VALID IDs

   if ($check_balance->rowCount() == 0) {
      throw new InvalidInputException('ERROR: Invalid user id!');
   }

   if ($check_price->rowCount() == 0 or $price == 0) {
      throw new InvalidInputException('Nothing to do.');
   }


   $bal = $check_balance->fetch()["ubalance"];
   if($bal < $price){
      throw new InsufficientFundsException("You do not have enough money to repair all tanks!");
   }

   #SUBTRACT AND UPDATE

   $subtract_price = 'UPDATE users SET ubalance= '. $bal . '-' . $price . ' WHERE uid=' . $_SESSION["uid"];


   $update_ready_to_battle = 'UPDATE inventory_tanks IT SET ready_to_battle=0 WHERE IT.uid="' . $_SESSION["uid"] . '"';

   $conn->exec($subtract_price);
   $conn->exec($update_ready_to_battle);

   #CHECK VALUES 
   $check_new_balance = $conn->query('SELECT ubalance FROM users WHERE uid=' . $_SESSION["uid"]);
   $check_new_balance->setFetchMode(PDO::FETCH_ASSOC);
   $new_bal = $check_new_balance->fetch()["ubalance"];

   if($new_bal != ($bal - $price)){
      throw new Exception("Exit price does not match");
   }

   #SUCCESS
   echo "Repair successful, committing...";	
   $conn->exec($commit);

?>






<?php

}catch(PDOException $e){
   echo "Error logging into SQL: " . $e->getMessage();

}catch(InsufficientFundsException $e){
   echo "Insufficient Funds Exception: ". $e->getMessage();
   $conn->exec($rollback);

}catch(InvalidInputException $e){
   echo "Invalid Input Exception: " . $e->getMessage();
   $conn->exec($rollback);

}catch(Exception $e){
   echo "Error repairing tanks";
   $conn->exec($rollback);
}
$conn = null;




?>

                                        <p>You will be redirected in 1 second</p>
<script>
var timer = setTimeout(function() {
   window.location='../inventory_management.php'
}, 1000);
</script>

                </p>
    </body>
</div>


