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
    $sql = 'SELECT tanks.tname, attachments.aname FROM users, inventory_tanks, inventory_attachments, tanks, linked, attachments WHERE users.uid=inventory_tanks.uid AND users.uid=inventory_attachments.uid AND inventory_tanks.tid=tanks.tid AND inventory_attachments.aid=attachments.aid AND tanks.tid=linked.tid AND attachments.aid=linked.aid AND users.uid=' . $_SESSION["uid"];
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
        <title>Tank Attachment User Compatibility</title>
    </head>
    <body>
        <div id="container">
	<h2>Tank/Attachment Compatibility Pairs Within User Inventory: </h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Tank Name</th>	
                        <th> Attachment Name</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tname']) ?></td>
                            <td><?php echo htmlspecialchars($row['aname']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
