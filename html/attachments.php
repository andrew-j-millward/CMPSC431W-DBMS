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
    $sql = 'SELECT * FROM attachments';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP List of Attachments</title>
    </head>
    <body>
        <h2>Insert a new attachment: </h2>
        <form action="/insert_tabs/insert_attachments.php" method="post">
            <table>
                <tr><td>Attachment Name:</td><td><input type="text" id="aname" name="aname" value="?"></td></tr>
                <tr><td>Attachment Tier:</td><td><input type="number" id="atier" name="atier" value="0"></td></tr>
                <tr><td>Price:</td><td><input type="number" id="price" name="price" value="0"></td></tr>
                <tr><td>Weight:</td><td><input type="number" id="weight" name="weight" value="0"></td></tr>
                <tr><td>Country ID:</td><td><input type="number" id="cid" name="cid" value="0"></td></tr>
                <tr><td>System ID:</td><td><input type="number" id="sid" name="sid" value="0"></td></tr>
            </table>
            <input type="submit" value="INSERT">
        </form>
        <br><br><br>
        <div id="container">
	 <h2>Current List of Attachments</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>Attachment ID</th>
                        <th>Attachment Name</th>
                        <th>Attachment Tier</th>
                        <th>Price</th>
                        <th>Weight</th>
                        <th>Country ID</th>
                        <th>System ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['aid']) ?></td>
                            <td><?php echo htmlspecialchars($row['aname']); ?></td>
                            <td><?php echo htmlspecialchars($row['atier']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['weight']); ?></td>
                            <td><?php echo htmlspecialchars($row['cid']); ?></td>
                            <td><?php echo htmlspecialchars($row['sid']); ?></td>                            
                           <td><?php echo '<form action="/delete_tabs/delete_attachment.php" method="post"><input type="submit" value="DELETE"><input type="hidden" name="aid" value="' . htmlspecialchars($row['aid']) . '"></form>'; ?></td>

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
