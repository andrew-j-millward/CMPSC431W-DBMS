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
    $sql = 'SELECT * FROM inventory_attachments ORDER BY uid ASC, aid ASC LIMIT 5000';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>List of All Inventory Attachments (first 5000)</title>
    </head>
    <body>
        <h2>Insert a new inventory attachment:</h2>
        <form action="/insert_tabs/insert_inventory_attachments.php" method="post">
            <table>
                <tr><td>User ID:</td><td><input type="number" id="uid" name="uid" value="0"></td></tr>
                <tr><td>Attachment ID:</td><td><input type="number" id="aid" name="aid" value="0"></td></tr>

            </table>
            <input type="submit" value="INSERT">
        </form>
        <br><br><br>
        <div id="container">
            <h2>Current List of Inventory Attachments (first 5000)</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>User ID</th>
			<th>Attachment ID</th>
		    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['uid']) ?></td>
			    <td><?php echo htmlspecialchars($row['aid']) ?></td>
                            <td><?php echo '<form action="/delete_tabs/delete_inventory_attachments.php" method="post"><input type="submit" value="DELETE"><input type="hidden" name="uid" value="' . htmlspecialchars($row['uid']) . '"><input type="hidden" name="aid" value="' . htmlspecialchars($row['aid']) . '"></form>'; ?></td>
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
