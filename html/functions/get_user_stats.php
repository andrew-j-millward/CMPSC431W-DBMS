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
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sql = 'SELECT U.uname, sum(T.hit_points), sum(T.damage_per_minute) FROM tanks T, inventory I, users U ';
    $sql = $sql . 'where U.uid=921 and U.uid=I.uid and I.tid=T.tid';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP MySQL Query Data Demo</title>
    </head>
    <body>
        <div id="container">
            <h2>My total Hit Points and Damage amount</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>User name</th>
                        <th>Total Hit points</th>
                        <th>Total Damage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['uname']) ?></td>
                            <td><?php echo htmlspecialchars($row['sum(T.hit_points)']) ?></td>
                            <td><?php echo htmlspecialchars($row['sum(T.damage_per_minute)']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
