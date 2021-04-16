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
        <title>Deleting system...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Deleting system: " . $_POST["sid"] . "..."; 
				# catch from empty set
				$sql_system = 'DELETE FROM system WHERE system.sid = ' . $_POST["sid"];
				$sql_attachments = 'DELETE FROM attachments WHERE attachments.sid = ' . $_POST["sid"];  
				$sql_linked = 'DELETE linked FROM linked INNER JOIN attachments ON attachments.aid = linked.aid WHERE attachments.sid = ' . $_POST["sid"];
				$sql_inventory_attachments = 'DELETE inventory_attachments FROM inventory_attachments INNER JOIN attachments ON inventory_attachments.aid = attachments.aid WHERE attachments.sid = ' . $_POST["sid"];
				try {
					 $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 try {
						// OUTSIDE IN
                                        	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        	$conn->exec($sql_start_txn);
						$conn->exec($sql_inventory_attachments);
						$conn->exec($sql_linked);
						$conn->exec($sql_attachments);	
						$conn->exec($sql_system);
                                        	$conn->exec($commit);


                                       	 	echo "System deleted successfully";
                                	?>
                                	<p>You will be redirected in 3 seconds</p>
                                	<script>
                                        	var timer = setTimeout(function() {
                                        	        window.location='../system.php'
                                    	    }, 3000);
                                	</script>
                        	<?php
                                	} catch(Exception $e) {
                                        	echo $sql_system . "<br>" . $e->getMessage();
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
