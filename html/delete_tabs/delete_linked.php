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
				echo "Deleting link: " . $_POST["tid"] . $_POST["aid"] . "..."; 
				$sql_linked = 'DELETE FROM linked WHERE tid = "' . $_POST["tid"] . '"' . ' AND aid = "' . $_POST["aid"] . '"';
				try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    try {
                       // OUTSIDE IN
                       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                       $conn->exec($sql_linked);
                                               echo "Link deleted successfully";
                                   ?>
                                   <p>You will be redirected in 3 seconds</p>
                                   <script>
                                           var timer = setTimeout(function() {
                                                   window.location='../linked.php'
                                           }, 3000);
                                   </script>
                           <?php
                                   } catch(Exception $e) {
                                           echo $sql_linked . "<br>" . $e->getMessage();
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
