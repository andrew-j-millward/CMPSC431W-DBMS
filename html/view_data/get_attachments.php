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
    $sql = 'SELECT attachments.aid, attachments.aname, attachments.atier, attachments.price, attachments.weight, countries.cname, system.sname FROM attachments, countries, system WHERE attachments.cid=countries.cid AND attachments.sid=system.sid ';
    if(isset($_GET['sorting_style'])) {
        if ($_GET['sorting_style'] == 'aid') {
            $sql = $sql . "ORDER BY attachments.aid";
        } else if ($_GET['sorting_style'] == 'raid') {
            $sql = $sql . "ORDER BY attachments.aid DESC";
        } else if ($_GET['sorting_style'] == 'aname') {
            $sql = $sql . "ORDER BY attachments.aname";
        } else if ($_GET['sorting_style'] == 'raname') {
            $sql = $sql . "ORDER BY attachments.aname DESC";
        } else if ($_GET['sorting_style'] == 'atier') {
            $sql = $sql . "ORDER BY attachments.atier";
        } else if ($_GET['sorting_style'] == 'ratier') {
            $sql = $sql . "ORDER BY attachments.atier DESC";
        } else if($_GET['sorting_style'] == 'price') {
            $sql = $sql . "ORDER BY attachments.price";
        } else if($_GET['sorting_style'] == 'rprice') {
            $sql = $sql . "ORDER BY attachments.price DESC";
        } else if($_GET['sorting_style'] == 'weight') {
            $sql = $sql . "ORDER BY attachments.weight";
        } else if($_GET['sorting_style'] == 'rweight') {
            $sql = $sql . "ORDER BY attachments.weight DESC";
        } else if($_GET['sorting_style'] == 'cname') {
            $sql = $sql . "ORDER BY countries.cname";
        } else if($_GET['sorting_style'] == 'rcname') {
            $sql = $sql . "ORDER BY countries.cname DESC";
        } else if($_GET['sorting_style'] == 'sname') {
            $sql = $sql . "ORDER BY system.sname";
        } else if($_GET['sorting_style'] == 'rsname') {
            $sql = $sql . "ORDER BY system.sname DESC";
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
        <title>All Available Attachments</title>
    </head>
    <body>
        <div id="container">
    <a href="../inventory_management.php">Return to Inventory Management</a>
	<h2>Available attachments: </h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <?php if(isset($_GET['sorting_style'])) { if($_GET['sorting_style'] == 'aid') { ?>
                            <th><a href="get_attachments.php?sorting_style=raid">Attachment ID</a></th>
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=aid">Attachment ID</a></th>
                        <?php } if($_GET['sorting_style'] == 'aname') { ?>
                            <th><a href="get_attachments.php?sorting_style=raname">Attachment Name</a></th>
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=aname">Attachment Name</a></th>
                        <?php } if($_GET['sorting_style'] == 'atier') { ?>
                            <th><a href="get_attachments.php?sorting_style=ratier">Tier</a></th>
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=atier">Tier</a></th>
                        <?php } if($_GET['sorting_style'] == 'price') { ?>
                            <th><a href="get_attachments.php?sorting_style=rprice">Price</a></th>
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=price">Price</a></th>
                        <?php } if($_GET['sorting_style'] == 'weight') { ?>
                            <th><a href="get_attachments.php?sorting_style=rweight">Weight</a></th>
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=weight">Weight</a></th>
                        <?php } if($_GET['sorting_style'] == 'cname') { ?>
                            <th><a href="get_attachments.php?sorting_style=rcname">Country</a></th>
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=cname">Country</a></th>
                        <?php } if($_GET['sorting_style'] == 'sname') { ?>
                            <th><a href="get_attachments.php?sorting_style=rsname">System</a></th>	
                        <?php } else { ?>
                            <th><a href="get_attachments.php?sorting_style=sname">System</a></th>
                        <?php } } else { ?>
                            <th><a href="get_attachments.php?sorting_style=aid">Attachment ID</a></th>
                            <th><a href="get_attachments.php?sorting_style=aname">Attachment Name</a></th>
                            <th><a href="get_attachments.php?sorting_style=atier">Tier</a></th>
                            <th><a href="get_attachments.php?sorting_style=price">Price</a></th>
                            <th><a href="get_attachments.php?sorting_style=weight">Weight</a></th>
                            <th><a href="get_attachments.php?sorting_style=cname">Country</a></th>
                            <th><a href="get_attachments.php?sorting_style=sname">System</a></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['aid']) ?></td>
                            <td><?php echo htmlspecialchars($row['aname']) ?></td>
                            <td><?php echo htmlspecialchars($row['atier']) ?></td>
                            <td><?php echo htmlspecialchars($row['price']) ?></td>
                            <td><?php echo htmlspecialchars($row['weight']) ?></td>
                            <td><?php echo htmlspecialchars($row['cname']) ?></td>
                            <td><?php echo htmlspecialchars($row['sname']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<br><br><br>
    </body>
</div>
</html>
