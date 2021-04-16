<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'user_info.php';

$host = 'localhost';
$dbname = '431W_project';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Inserting Into Inventory...</title>
    </head>
    <body>
      <p>
<?php 
echo "Inserting new inventory tank: " . $_POST["uid"] . " " . $_POST["tid"] . " " . $_POST["pid"] . "..."; 
$sql = 'INSERT INTO inventory_tanks (uid, tid, pid, twc, tbc, ready_to_battle) ';
$sql = $sql . 'VALUES ("'.$_POST["uid"] . '","' . $_POST["tid"] . '","' . $_POST["pid"] . '","' . "0" . '","' . "0"  . '","' . "0" . '")';
try {
   $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $check_uid = $conn->query('SELECT uid FROM users where uid="' . $_POST["uid"] . '"');
   $check_tid = $conn->query('SELECT tid FROM tanks where tid="' . $_POST["tid"] . '"');
   $check_pid = $conn->query('SELECT pid FROM projectiles where pid="' . $_POST["pid"] . '"');
   try {
      if ($check_uid->rowCount() == 0) {
         throw new Exception('ERROR: Invalid user id!');
      }
      if ($check_tid->rowcount() == 0) {
         throw new exception('error: invalid tank id!');
      }
      if ($check_pid->rowcount() == 0) {
         throw new exception('error: invalid projectile id!');
      }
   $conn->exec($sql);
   echo "New record created successfully";
   } catch(Exception $e) {
      echo $e->getMessage();
   }
?>
            <p>You will be redirected in 3 seconds</p>
   <script>
   var timer = setTimeout(function() {
      window.location='../inventory_tanks.php'
   }, 3000);
   </script>
<?php
} catch(PDOException $e) {
   echo $sql . "<br>" . $e->getMessage();
} catch(Exception $e) {
   echo $e->getMessage();
}
$conn = null;
?>
      </p>
    </body>
</div>
</html>
