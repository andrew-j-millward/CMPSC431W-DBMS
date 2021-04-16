<?php

include 'user_info.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$username = 'abc123';   <---- MAKE THESE IN 'user_infor.php'
//$password = 'SOME_PASSWORD';   <<---- MAKE THESE IN 'user_info.php'
$host = 'localhost';
$dbname = '431W_project';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sql = 'SELECT * FROM tanks';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>List of All Tanks</title>
    </head>
    <body>
        <h2>Insert a new tank:</h2>
        <form action="/insert_tabs/insert_tanks.php" method="post">
            <table>
                <tr><td>Tank Name:</td><td><input type="text" id="tname" name="tname" value="?"></td></tr>
                <tr><td>Role ID:</td><td><input type="number" id="rid" name="rid" value="0"></td></tr>
                <tr><td>Country ID:</td><td><input type="number" id="cid" name="cid" value="0"></td></tr>
                <tr><td>Price:</td><td><input type="number" id="price" name="price" value="0"></td></tr>
                                <tr><td>Hit Points:</td><td><input type="number" id="hit_points" name="hit_points" value="0"></td></tr>
                                <tr><td>Damage Per Minute:</td><td><input type="number" id="dpm" name="dpm" value="0"></td></tr>


            </table>
            <input type="submit" value="INSERT">
        </form>
        <br><br><br>
        <div id="container">
            <h2>Current List of Tanks</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>Tank ID</th>
                        <th>Tank Name</th>
                        <th>Role ID</th>
			<th>Country ID</th>
			<th>Price</th>
			<th>Hit Points</th>
			<th>Damage Per Minute</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tid']) ?></td>
                            <td><?php echo htmlspecialchars($row['tname']); ?></td>
                            <td><?php echo htmlspecialchars($row['rid']); ?></td>
			    <td><?php echo htmlspecialchars($row['cid']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['hit_points']); ?></td>
			    <td><?php echo htmlspecialchars($row['dpm']); ?></td>
                            <td><?php echo '<form action="/delete_tabs/delete_tank.php" method="post"><input type="submit" value="DELETE"><input type="hidden" name="tid" value="' . htmlspecialchars($row['tid']) . '"></form>'; ?></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br>
		<br>
		<br><br><br>
    </body>
</div>
</html>
