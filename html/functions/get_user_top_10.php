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
    $sql = 'SELECT I.tid, T.tname, I.twc, I.tbc, (I.twc/I.tbc) AS winrate FROM inventory_tanks I, tanks T, users U ';
    $sql = $sql . 'WHERE U.uid='. $_SESSION["uid"] . ' AND U.uid = I.uid AND I.tid= T.tid ORDER BY winrate DESC LIMIT 10';
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
        <title>Top 10 Tanks</title>
    </head>
    <body>
        <div id="container">
	    <h2>Top 10 Tanks</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Tank ID</th>
                        <th> Tank Name</th>
                        <th> Win Count</th>
			<th> Battle Count</th>
			<th> Win Rate </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tid']) ?></td>
                            <td><?php echo htmlspecialchars($row['tname']) ?></td>
                            <td><?php echo htmlspecialchars($row['twc']) ?></td>
                            <td><?php echo htmlspecialchars($row['tbc']) ?></td>
                            <td><?php echo htmlspecialchars($row['winrate']) ?></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
