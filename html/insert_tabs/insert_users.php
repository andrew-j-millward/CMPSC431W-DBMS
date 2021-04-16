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
        <title>Inserting user...</title>
    </head>
    <body>
		<p>
			<?php 
				echo "Inserting new user: " . $_POST["uname"] . " " . $_POST["uregion"] . " " . "0" . " " . "0" . " " . "0" . "..."; 
				$sql = 'INSERT INTO users (uname, uregion, ubc, uwc, ubalance) ';
				$sql = $sql . 'VALUES ("'.$_POST["uname"] . '","' . $_POST["uregion"] . '","' . 0 . '","' . 0 . '","' . 5000 . '")';
				try {
					$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$conn->exec($sql);
					echo "New record created successfully";
			?>
				<p>You will be redirected in 3 seconds</p>
				<script>
					var timer = setTimeout(function() {
						window.location='../users.php'
					}, 3000);
				</script>
			<?php
				} catch(PDOException $e) {
					echo $sql . "<br>" . $e->getMessage();
				}
				$conn = null;
			?>
		</p>
    </body>
</div>
</html>
