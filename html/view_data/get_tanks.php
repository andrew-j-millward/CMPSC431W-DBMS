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
    $sql = 'SELECT tanks.tid, tanks.tname, roles.rname, countries.cname, tanks.price, tanks.hit_points, tanks.dpm FROM tanks, roles, countries WHERE tanks.rid=roles.rid AND tanks.cid=countries.cid ';
    if(isset($_GET['sorting_style'])) {
        if ($_GET['sorting_style'] == 'tid') {
            $sql = $sql . "ORDER BY tanks.tid";
        } else if ($_GET['sorting_style'] == 'rtid') {
            $sql = $sql . "ORDER BY tanks.tid DESC";
        } else if ($_GET['sorting_style'] == 'tname') {
            $sql = $sql . "ORDER BY tanks.tname";
        } else if ($_GET['sorting_style'] == 'rtname') {
            $sql = $sql . "ORDER BY tanks.tname DESC";
        } else if ($_GET['sorting_style'] == 'rname') {
            $sql = $sql . "ORDER BY roles.rname";
        } else if ($_GET['sorting_style'] == 'rrname') {
            $sql = $sql . "ORDER BY roles.rname DESC";
        } else if($_GET['sorting_style'] == 'cname') {
            $sql = $sql . "ORDER BY countries.cname";
        } else if($_GET['sorting_style'] == 'rcname') {
            $sql = $sql . "ORDER BY countries.cname DESC";
        } else if($_GET['sorting_style'] == 'price') {
            $sql = $sql . "ORDER BY tanks.price";
        } else if($_GET['sorting_style'] == 'rprice') {
            $sql = $sql . "ORDER BY tanks.price DESC";
        } else if($_GET['sorting_style'] == 'hit_points') {
            $sql = $sql . "ORDER BY tanks.hit_points";
        } else if($_GET['sorting_style'] == 'rhit_points') {
            $sql = $sql . "ORDER BY tanks.hit_points DESC";
        } else if($_GET['sorting_style'] == 'dpm') {
            $sql = $sql . "ORDER BY tanks.dpm";
        } else if($_GET['sorting_style'] == 'rdpm') {
            $sql = $sql . "ORDER BY tanks.dpm DESC";
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
        <title>All Available Tanks</title>
    </head>
    <body>
        <div id="container">
    <a href="../inventory_management.php">Return to Inventory Management</a>
	<h2>Available tanks: </h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <?php if(isset($_GET['sorting_style'])) { if($_GET['sorting_style'] == 'tid') { ?>
                            <th><a href="get_tanks.php?sorting_style=rtid">Tank ID</a></th>
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=tid">Tank ID</a></th>
                        <?php } if($_GET['sorting_style'] == 'tname') { ?>
                            <th><a href="get_tanks.php?sorting_style=rtname">Tank Name</a></th>
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=tname">Tank Name</a></th>
                        <?php } if($_GET['sorting_style'] == 'rname') { ?>
                            <th><a href="get_tanks.php?sorting_style=rrname">Role</a></th>
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=rname">Role</a></th>
                        <?php } if($_GET['sorting_style'] == 'cname') { ?>
                            <th><a href="get_tanks.php?sorting_style=rcname">Country</a></th>
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=cname">Country</a></th>
                        <?php } if($_GET['sorting_style'] == 'price') { ?>
                            <th><a href="get_tanks.php?sorting_style=rprice">Price</a></th>
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=price">Price</a></th>
                        <?php } if($_GET['sorting_style'] == 'hit_points') { ?>
                            <th><a href="get_tanks.php?sorting_style=rhit_points">Hit Points</a></th>
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=hit_points">Hit Points</a></th>
                        <?php } if($_GET['sorting_style'] == 'dpm') { ?>
                            <th><a href="get_tanks.php?sorting_style=rdpm">Damage Per Minute</a></th>	
                        <?php } else { ?>
                            <th><a href="get_tanks.php?sorting_style=dpm">Damage Per Minute</a></th>
                        <?php } } else { ?>
                            <th><a href="get_tanks.php?sorting_style=tid">Tank ID</a></th>
                            <th><a href="get_tanks.php?sorting_style=tname">Tank Name</a></th>
                            <th><a href="get_tanks.php?sorting_style=rname">Role</a></th>
                            <th><a href="get_tanks.php?sorting_style=cname">Country</a></th>
                            <th><a href="get_tanks.php?sorting_style=price">Price</a></th>
                            <th><a href="get_tanks.php?sorting_style=hit_points">Hit Points</a></th>
                            <th><a href="get_tanks.php?sorting_style=dpm">Damage Per Minute</a></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tid']) ?></td>
                            <td><?php echo htmlspecialchars($row['tname']) ?></td>
                            <td><?php echo htmlspecialchars($row['rname']) ?></td>
                            <td><?php echo htmlspecialchars($row['cname']) ?></td>
                            <td><?php echo htmlspecialchars($row['price']) ?></td>
                            <td><?php echo htmlspecialchars($row['hit_points']) ?></td>
                            <td><?php echo htmlspecialchars($row['dpm']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
