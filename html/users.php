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
   $sql = 'SELECT * FROM users';
   $q = $pdo->query($sql);
   $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>List of All Users</title>
    </head>
    <body>
        <h2>Insert a new user:</h2>
        <form action="/insert_tabs/insert_users.php" method="post">
            <table>
                <tr><td>User Name:</td><td><input type="text" id="uname" name="uname" value="?"></td></tr>
                <tr><td>Region:</td><td><select id="uregion" name="uregion" size="1">
                        <option value="Europe">Europe</option>
                        <option value="Africa">Africa</option>
                        <option value="Asia">Asia</option>
                        <option value="North America">North America</option>
                        <option value="Australia">Australia</option>
                        <option value="South America">South America</option>
                </select></td></tr> <!-- <input type="text" id="uregion" name="uregion" value="?"> -->

            </table>
            <input type="submit" value="INSERT">
        </form>
        <br><br><br>
        <div id="container">
            <h2>Current List of Users</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Region</th>
                     <th>Battle Count</th>
                     <th>Win Count</th>
                     <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['uid']) ?></td>
                            <td><?php echo htmlspecialchars($row['uname']); ?></td>
                            <td><?php echo htmlspecialchars($row['uregion']); ?></td>
                            <td><?php echo htmlspecialchars($row['ubc']); ?></td>
                            <td><?php echo htmlspecialchars($row['uwc']); ?></td>
                            <td><?php echo htmlspecialchars($row['ubalance']); ?></td>
                            <td><?php echo '<form action="/delete_tabs/delete_user.php" method="post"><input type="submit" value="DELETE"><input type="hidden" name="uid" value="' . htmlspecialchars($row['uid']) . '"></form>'; ?></td>
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
