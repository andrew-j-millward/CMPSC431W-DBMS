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
        <title>Inserting inventory attachment...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Inserting new user attachment: " . $_POST["uid"] . " " . $_POST["aid"] . "..."; 
				$sql = 'INSERT INTO inventory_attachments (uid, aid) ';
				$sql = $sql . 'VALUES ("'.$_POST["uid"] . '","' . $_POST["aid"] . '")';
				try {
					$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$check_uid = $conn->query('SELECT uname FROM users where uid="' . $_POST["uid"] . '"');
   					$check_aid = $conn->query('SELECT aname FROM attachments where aid="' . $_POST["aid"] . '"');
					try {
						if ($check_uid->rowCount() == 0) {
					       throw new Exception('ERROR: Invalid user id!');
					    }
					    if ($check_aid->rowCount() == 0) {
					       throw new Exception('ERROR: Invalid attachment id!');
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
						window.location='../inventory_attachments.php'
					}, 3000);
				</script>
			<?php
				} catch(PDOException $e) {
					echo $sql . "<br>" . $e->getMessage();
				} catch(Exception $e) {
					echo $sql . "<br>" . $e->getMessage();
				}
				$conn = null;
			?>
		</p>
    </body>
</div>
</html>
