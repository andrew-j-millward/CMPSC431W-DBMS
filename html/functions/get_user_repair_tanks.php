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
   $check_uid = 'SELECT uid from users where users.uid="'. $_SESSION["uid"] . '"';
    $uid_query = $pdo->query($check_uid);
    $uid_query->setFetchMode(PDO::FETCH_ASSOC);
    if ($uid_query->rowCount() == 0) {
       throw New Exception("No such User ID");
    }
    $sql = 'SELECT T.tname, (T.price*0.5) AS repair_cost FROM tanks T, inventory_tanks I, users U ';
    $sql = $sql . 'where U.uid='. $_SESSION["uid"] . ' AND I.tid = T.tid AND I.uid = U.uid AND I.ready_to_battle=1';
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
	    <h2>Price to repair each tank</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Tank name</th>
                        <th> Price</th>                      
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tname']) ?></td>
                            <td><?php echo htmlspecialchars($row['repair_cost']) ?></td> 
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
