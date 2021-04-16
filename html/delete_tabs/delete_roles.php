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
        <title>Deleting role...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Deleting role: " . $_POST["rid"] . "..."; 

                $sql_joins = 'DELETE FROM joins WHERE joins.rid = ' . $_POST["rid"];
                $sql_linked = 'DELETE tanks, linked, inventory_tanks FROM tanks INNER JOIN linked ON tanks.tid=linked.tid INNER JOIN inventory_tanks ON tanks.tid=inventory_tanks.tid WHERE tanks.rid= ' . $_POST["rid"];
				$sql_roles = 'DELETE FROM roles WHERE roles.rid = ' . $_POST["rid"];
				
				try {
					$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					try {
                                        	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        	$conn->exec($sql_start_txn);
                                        	$conn->exec($sql_joins);
                                        	$conn->exec($sql_linked);
                                        	$conn->exec($sql_roles);
                                        	$conn->exec($commit);


                                       	 	echo "Role deleted successfully";
                                	?>
                                	<p>You will be redirected in 3 seconds</p>
                                	<script>
                                        	var timer = setTimeout(function() {
                                        	        window.location='../roles.php'
                                    	    }, 3000);
                                	</script>
                        	<?php
                                	} catch(Exception $e) {
                                        	echo $sql_roles . "<br>" . $e->getMessage();
                                            $conn->exec($rollback);
                					}
					$conn = null;
				} catch(PDOException $e){
					echo "Error logging into SQL: " . $e->getMessage();
				} catch(Exception $e){
                    echo "Error encountered in deletion: " . $e->getMessage();
                }
	
					
				?>
		</p>
    </body>
</div>
</html>
