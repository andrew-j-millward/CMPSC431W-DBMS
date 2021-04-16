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
				<title>Deleting user...</title>
		</head>
		<body>
			<p>
				<?php 
					echo "Deleting user: " . $_POST["uid"] . "..."; 
					# catch from empty set
					# start transaction

					# delete user
					$del_user = 'DELETE FROM users WHERE uid = "' . $_POST["uid"] . '"';
					# delete inventory_tanks
					$del_inv_tanks = 'DELETE FROM inventory_tanks WHERE uid = "' . $_POST["uid"] . '"';
					# delete inventory_attachments
					$del_inv_attach = 'DELETE FROM inventory_attachments WHERE uid = "' . $_POST["uid"] . '"';
					try {
						$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
						try {
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$conn->exec($sql_start_txn);
							$conn->exec($del_user);
							$conn->exec($del_inv_tanks);
							$conn->exec($del_inv_attach);
							$conn->exec($commit);
							echo "User deleted successfully";
						} catch(Exception $e) {
							$conn->exec($rollback);
							echo $del_user . "<br>" . $e->getMessage();
						}
				?>
				<p>You will be redirected in 3 seconds</p>
				<script>
					var timer = setTimeout(function() {
						 window.location='../users.php'
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
