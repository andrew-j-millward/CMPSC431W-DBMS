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
        <title>Deleting attachment...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Deleting attachment: " . $_POST["aid"] . "..."; 
				# catch from empty set	
				$sql_attachments = 'DELETE FROM attachments WHERE attachments.aid = ' . $_POST["aid"];  
				$sql_linked = 'DELETE FROM linked WHERE linked.aid = ' . $_POST["aid"];
				$sql_inventory_attachments = 'DELETE FROM inventory_attachments WHERE inventory_attachments.aid = ' . $_POST["aid"];
				try {
					 $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 try {
						// OUTSIDE IN
                                        	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        	$conn->exec($sql_start_txn);
						$conn->exec($sql_inventory_attachments);
						$conn->exec($sql_linked);
						$conn->exec($sql_attachments);	
                                        	$conn->exec($commit);


                                       	 	echo "Attachment deleted successfully";
                                	?>
                                	<p>You will be redirected in 3 seconds</p>
                                	<script>
                                        	var timer = setTimeout(function() {
                                        	        window.location='../attachments.php'
                                    	    }, 3000);
                                	</script>
                        	<?php
                                	} catch(Exception $e) {
                                        	echo $sql_attachments . "<br>" . $e->getMessage();
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
