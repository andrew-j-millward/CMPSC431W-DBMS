<?php

include 'user_info.php';
include '../global.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = '431W_project';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Deleting link...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Deleting link: " . $_POST["rid"] . $_POST["cid"] . "..."; 
				$sql_joins = 'DELETE FROM joins WHERE rid = "' . $_POST["rid"] . '"' . ' AND cid = "' . $_POST["cid"] . '"';
				try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    try {
                       // OUTSIDE IN
                       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                       $conn->exec($sql_joins);
                                               echo "Join deleted successfully";
                                   ?>
                                   <p>You will be redirected in 3 seconds</p>
                                   <script>
                                           var timer = setTimeout(function() {
                                                   window.location='../joins.php'
                                           }, 3000);
                                   </script>
                           <?php
                                   } catch(Exception $e) {
                                           echo $sql_joins . "<br>" . $e->getMessage();
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
