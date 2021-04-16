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
    $sql = 'SELECT * FROM countries';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP List of Countries</title>
    </head>
    <body>
        <h2>Insert a new country:</h2>
        <form action="/insert_tabs/insert_countries.php" method="post">
            <table>
                <tr><td>Country Name:</td><td><input type="text" id="cname" name="cname" value="?"></td></tr>

            </table>
            <input type="submit" value="INSERT">
        </form>
        <br><br><br>
        <div id="container">
            <h2>Current List of Countries</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>Country ID</th>
                        <th>Country Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cid']) ?></td>
                            <td><?php echo htmlspecialchars($row['cname']); ?></td>
                            <td><?php echo '<form action="/delete_tabs/delete_country.php" method="post"><input type="submit" value="DELETE"><input type="hidden" name="cid" value="' . htmlspecialchars($row['cid']) . '"></form>'; ?></td>
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
