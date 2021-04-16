<?php

include '../user_info.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$username = 'abc123';   <---- MAKE THESE IN 'user_infor.php'
//$password = 'SOME_PASSWORD';   <---- MAKE THESE IN 'user_info.php'
$host = 'localhost';
$dbname = '431W_project';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sql = 'SELECT * FROM system ';
    if(isset($_GET['sorting_style'])) {
        if ($_GET['sorting_style'] == 'sid') {
            $sql = $sql . "ORDER BY sid";
        } else if ($_GET['sorting_style'] == 'rsid') {
            $sql = $sql . "ORDER BY sid DESC";
        } else if ($_GET['sorting_style'] == 'sname') {
            $sql = $sql . "ORDER BY sname";
        } else if ($_GET['sorting_style'] == 'rsname') {
            $sql = $sql . "ORDER BY sname DESC";
        }
    }
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>All Available Systems</title>
    </head>
    <body>
        <div id="container">
    <a href="../inventory_management.php">Return to Inventory Management</a>
	<h2>Available systems: </h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <?php if(isset($_GET['sorting_style'])) { if($_GET['sorting_style'] == 'sid') { ?>
                            <th><a href="get_systems.php?sorting_style=rsid">System ID</a></th>
                        <?php } else { ?>
                            <th><a href="get_systems.php?sorting_style=sid">System ID</a></th>
                        <?php } if($_GET['sorting_style'] == 'sname') { ?>
                            <th><a href="get_systems.php?sorting_style=rsname">System Name</a></th>
                        <?php } else { ?>
                            <th><a href="get_systems.php?sorting_style=sname">System Name</a></th>
                        <?php } } else { ?>
                            <th><a href="get_systems.php?sorting_style=sid">System ID</a></th>
                            <th><a href="get_systems.php?sorting_style=sname">System Name</a></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['sid']) ?></td>
                            <td><?php echo htmlspecialchars($row['sname']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
