<?php

include 'user_info.php';
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
        <title>Deleting projectile...</title>
    </head>
    <body>
      <p>
<?php 
echo "Deleting projectile: " . $_POST["pid"] . "..."; 
# catch from empty set
# start transaction

# delete user
$del_proj = 'DELETE FROM projectiles WHERE pid = "' . $_POST["pid"] . '"';
# delete inventory_tanks
$update_inv_tanks = 'UPDATE inventory_tanks SET pid=1 WHERE pid = "' . $_POST["pid"] . '"';
   try {
      if ($_POST["pid"] == 1) {
         throw new Exception('Cannot remove Armor-Piercing Shell Type as it is the default.');
      }
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      try {
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $conn->exec($sql_start_txn);
         $conn->exec($del_proj);
         $conn->exec($update_inv_tanks);
         $conn->exec($commit);
         echo "Projectile deleted successfully";
      } catch(PDOException $e) {
         $conn->exec($rollback);
         echo $del_proj . "<br>" . $e->getMessage();
         # rollback ...
      }
?>
            <p>You will be redirected in 3 seconds</p>
      <script>
      var timer = setTimeout(function() {
         window.location='../projectiles.php'
      }, 3000);
      </script>
<?php
   } catch(PDOException $e){
        echo "Error logging into SQL: " . $e->getMessage();
    } catch(Exception $e){
        echo "Error encountered in deletion: " . $e->getMessage();
    }
$conn = null;
?>
      </p>
    </body>
</div>
</html>
