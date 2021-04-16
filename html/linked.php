<?php

include 'user_info.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = '431W_project';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sql = 'SELECT * FROM linked';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>List of All Linked</title>
    </head>
    <body>
        <h2>Insert a new link:</h2>
        <form action="/insert_tabs/insert_linked.php" method="post">
            <table>
                <tr><td>Tank ID:</td><td><input type="number" id="tid" name="tid" value="0"></td></tr>
                <tr><td>Attachment ID:</td><td><input type="number" id="aid" name="aid" value="0"></td></tr>
            </table>
            <input type="submit" value="INSERT">
        </form>
        <br><br><br>
        <div id="container">
            <h2>Current List of Linked</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>Linked ID</th>
                        <th>Linked Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tid']) ?></td>
                            <td><?php echo htmlspecialchars($row['aid']); ?></td>
                            <td><?php echo '<form action="/delete_tabs/delete_linked.php" method="post"><input type="submit" value="DELETE"><input type="hidden" name="tid" value="' . htmlspecialchars($row['tid']) . '"><input type="hidden" name="aid" value="' . htmlspecialchars($row['aid']) . '"></form>'; ?></td>
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
