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
        <title>Inserting joins...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Inserting new join: " . $_POST["rid"] . " " . $_POST["cid"] . "..."; 
				$sql = 'INSERT INTO joins (rid, cid) ';
				$sql = $sql . 'VALUES ("'.$_POST["rid"] . '","' . $_POST["cid"] . '")';
				try {
					$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$check_rid = $conn->query('SELECT rname FROM roles where rid="' . $_POST["rid"] . '"');
   					$check_cid = $conn->query('SELECT cname FROM countries where cid="' . $_POST["cid"] . '"');
					try {
						if ($check_rid->rowCount() == 0) {
					       throw new Exception('ERROR: Invalid role id!');
					    }
					    if ($check_cid->rowCount() == 0) {
					       throw new Exception('ERROR: Invalid country id!');
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
						window.location='../joins.php'
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
