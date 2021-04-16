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
    $check_tank = $pdo->query('SELECT * FROM tanks WHERE tid="' . $_SESSION["tid"] . '"');
    $check_tank->setFetchMode(PDO::FETCH_ASSOC);
    if ($check_tank->rowCount() == 0) {
        throw new Exception('Error: Invalid tank id!');
    }
    $sql = 'SELECT C.cname FROM countries C, tanks T ';
    $sql = $sql . 'WHERE T.tid='. $_SESSION["tid"] . ' AND T.cid = C.cid';
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


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tank Country of Origin</title>
    </head>
    <body>
        <div id="container">
	<h2>Country of Tank ID: <?php echo $_SESSION["tid"] ?></h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Country Name</th>	
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cname']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
