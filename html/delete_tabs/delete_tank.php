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
        <title>Deleting tank...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Deleting tank: " . $_POST["tid"] . "..."; 
				# catch from empty set
				$sql_tanks = 'DELETE FROM tanks WHERE tanks.tid = ' . $_POST["tid"];
				$sql_linked = 'DELETE FROM linked WHERE linked.tid = ' . $_POST["tid"];
			       	$sql_inventory_tanks = 'DELETE FROM inventory_tanks WHERE inventory_tanks.tid = ' . $_POST["tid"];	
				
				try {
					 $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					try {
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conn->exec($sql_start_txn);
                        $conn->exec($sql_tanks);
                        $conn->exec($sql_linked);
                        $conn->exec($sql_inventory_tanks);
                        $conn->exec($commit);

                        echo "Tank deleted successfully";
                    } catch(Exception $e) {
                    echo $sql_tanks . "<br>" . $e->getMessage();
                        $conn->exec($rollback);                    
                    }
            ?>
            <p>You will be redirected in 3 seconds</p>
        	<script>
                var timer = setTimeout(function() {
                    window.location='../tanks.php'
            	}, 3000);
        	</script>
            <?php
                } catch(PDOException $e) {
                    echo "Error logging into SQL: " . $e->getMessage();
                } catch(Exception $e) {
                    $conn->exec($rollback);
                    echo "Error encountered in deletion: " . $e->getMessage();
                }
                $conn = null;	
			?>
		</p>
    </body>
</div>
</html>
