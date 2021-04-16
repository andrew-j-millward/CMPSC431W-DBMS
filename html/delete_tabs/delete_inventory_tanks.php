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
        <title>Deleting inventory tank...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Deleting inventory tank: " . $_POST["uid"] . $_POST["tid"] . "..."; 
				$sql_inventory_tanks = 'DELETE FROM inventory_tanks WHERE uid = "' . $_POST["uid"] . '"' . ' AND tid = "' . $_POST["tid"] . '"';
				try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    try {
                       // OUTSIDE IN
                       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                       $conn->exec($sql_inventory_tanks);


                                               echo "Inventory tank deleted successfully";
                                   ?>
                                   <p>You will be redirected in 3 seconds</p>
                                   <script>
                                           var timer = setTimeout(function() {
                                                   window.location='../inventory_tanks.php'
                                           }, 3000);
                                   </script>
                           <?php
                                   } catch(Exception $e) {
                                           echo $sql_inventory_tanks . "<br>" . $e->getMessage();
                       $conn->exec($rollback);
                                           
                   }
                   $conn = null;
               }catch(PDOException $e){
                   echo "Error logging into SQL: " . $e->getMessage();

               }catch(Exception $e){
                   echo "Error: " . $e->getMessage();
               }
			?>
		</p>
    </body>
</div>
</html>
