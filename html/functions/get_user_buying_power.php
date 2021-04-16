<?php

include 'user_info.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$username = 'abc123';   <---- MAKE THESE IN 'user_infor.php'
//$password = 'SOME_PASSWORD';   <---- MAKE THESE IN 'user_info.php'
$host = 'localhost';
$dbname = '431W_project';

try {
    session_start();
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $check_user = $pdo->query('SELECT * FROM users WHERE uid="' . $_SESSION["uid"] . '"');
    $check_user->setFetchMode(PDO::FETCH_ASSOC);
    if ($check_user->rowCount() == 0) {
        throw new Exception('Error: Invalid user id!');
    }
    $sql = 'SELECT T.tid, T.tname, T.hit_points, T.dpm, T.price FROM tanks T, users U ';
    $sql = $sql . 'where U.uid='. $_SESSION["uid"] . ' and T.price <= U.ubalance';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
} catch (Exception $e) {
   echo '<script type="text/javascript">',
     '(function () {',
     'setTimeout(function() {window.history.back();}, 3000)',
     '})();',
     '</script>'
   ;
    die($e->getMessage() . '.. Redirecting in 3 sec.');
}

/*$sql2 = 'SELECT * FROM tanks';
try {
    $query_output = mysqli($pdo, $sql2);
} catch (PDOException $e) {
    die("Execution error on SQL query: " . $e->getMessage());
}*/




?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP MySQL Query Data Demo</title>
    </head>
    <body>
        <div id="container">
	    <h2>Tanks I can buy</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
		    <tr>
			<th> Tank ID </th>
                        <th> Tank name</th>
                        <th> Hit points</th>
                        <th> Damage</th>
                        <th> Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
			<tr>
			    <td><?php echo htmlspecialchars($row['tid']) ?></td>
                            <td><?php echo htmlspecialchars($row['tname']) ?></td>
                            <td><?php echo htmlspecialchars($row['hit_points']) ?></td>
                            <td><?php echo htmlspecialchars($row['dpm']) ?></td>
                            <td><?php echo htmlspecialchars($row['price']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
