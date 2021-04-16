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
        <title>Inserting attachment...</title>
    </head>
    <body>
      <p>
<?php 
echo "Inserting new attachment: " . $_POST["aname"] . " " . $_POST["atier"] . " " . $_POST["price"] . " " . $_POST["weight"] . " " . $_POST["cid"] . " " . $_POST["sid"] . "..."; 
$sql = 'INSERT INTO attachments (aname, atier, price, weight, cid, sid) ';
$sql = $sql . 'VALUES ("'.$_POST["aname"] . '","' . $_POST["atier"] . '","' . $_POST["price"] . '","' . $_POST["weight"] . '","' . $_POST["cid"] . '","' . $_POST["sid"] . '")';
try {
   $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $check_sid = $conn->query('SELECT sname FROM system where sid="' . $_POST["sid"] . '"');
   $check_cid = $conn->query('SELECT cname FROM countries where cid="' . $_POST["cid"] . '"');
   try {
      if ($check_sid->rowCount() == 0) {
         throw new Exception('ERROR: Invalid system id!');
      }
      if ($check_cid->rowCount() == 0) {
         throw new Exception('ERROR: Invalid country id!');
      }
      # execute insert after error checking
   $conn->exec($sql);
   echo "New record created successfully";
   } catch(Exception $e) {
      echo $e->getMessage();
   }
?>
            <p>You will be redirected in 3 seconds</p>
   <script>
   var timer = setTimeout(function() {
      window.location='../attachments.php'
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
