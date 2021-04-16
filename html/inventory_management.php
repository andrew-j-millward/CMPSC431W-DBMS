<!DOCTYPE html>
<html>
    <style>
        body {
            background-color: #D6D6D6;
        }
        .div_class_main {
            background-color: #B39D8D;
            height: 800px;
            width: 90%;
            margin-left: 5%;
        }
        .div_class_left {
            width: 45%;
            height: 800px;
            margin-left: 10px;
            margin-right: 0px;
            margin-top: 0px;
            margin-bottom: 50px;
            display: inline-block;
            vertical-align: top;
        }
        .div_class_right {
            width: 45%;
            height: 800px;
            margin-left: 0px;
            margin-right: 0px;
            margin-top: 50px;
            margin-bottom: 50px;
            display: inline-block;
        }
        .spacer {
            height: 50px;
        }
        h1 {
            color: maroon;
        }
        h2 {
            margin-top: 0px;
            margin-bottom: 0px;
        }


    </style>
    <head>
        <title>User Inventory Management</title>
    </head>
    <body>
        <div class="spacer"></div>
        <div class="div_class_main">
            <form action="/redirect.php" method="post">
                <div class="div_class_left">
                    <table>
                        <tr><td><h3>User ID:</h3></td><td><input type="number" id="uid" name="uid" value="0"></td></tr>
                    </table>
                    <table>
                        <tr><td><h3>Reference Tables:</h3></td><td><input type="submit" name="get_tanks_button" value="Tanks"></td><td><input type="submit" name="get_system_button" value="Systems"></td><td><input type="submit" name="get_attachments_button" value="Attachments"></td></tr>
                    </table>
                    <h1>Functions</h1>
                    <table>
                        <tr><td><h2>What tanks can I buy?<br></h2></td><td><input type="submit" name="check_buying_power_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>What are my top 10 tanks?<br></h2></td><td><input type="submit" name="check_top_three_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>What attachments are available on this tank and subsystem?<br></h2></td></tr>
                    </table>
                    <table>
                        <tr><td>Tank ID:<br></td><td><input type="number" id="tid2" name="tid2" value="0"></td></tr>
                        <tr><td>Subsystem:<br></td><td><select id="sid2" name="sid2" size="1">
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
                                   $sql = 'SELECT sname FROM system';
                                   $q = $pdo->query($sql);
                                   $q->setFetchMode(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                   die("Could not connect to the database $dbname :" . $e->getMessage());
                                }
                                while ($row = $q->fetch()) {
                                    $sname = $rows['sname'];
                                    echo "<option value='" . $row['sname'] . "'>" . $row['sname'] . "</option>";
                                }
                            ?>
                        </select></td></tr>
                        <!--<tr><td>Subsystem ID:<br></td><td><input type="number" id="sid2" name="sid2" value="0"></td></tr>-->
                        <tr><td><input type="submit" name="check_attach_subsystem_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>What is the total Hit point and DPM for my Garage?<br></h2></td><td><input type="submit" name="check_dphp_garage_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>How much to repair my tanks?<br></h2></td><td><input type="submit" name="check_user_repair_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>How many attachments do I have?<br></h2></td><td><input type="submit" name="check_attach_total_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>How many tanks do I have from each country?<br></h2></td><td><input type="submit" name="check_country_tanks_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>Which country does this tank belong to?<br></h2></td></tr>
                    </table>
                    <table>
                        <tr><td>Tank ID:<br></td><td><input type="number" id="tid" name="tid" value="0"></td></tr>
                        <tr><td><input type="submit" name="check_tank_origin_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>What is my gross buying power?<br></h2></td><td><input type="submit" name="check_gross_buying_power_button" value="Submit"></td></tr>
                    </table>
                    <table>
                        <tr><td><h2>What are my tank-attachment compatibilities?<br></h2></td><td><input type="submit" name="check_tank_attachment_compatibility_button" value="Submit"></td></tr>
		    </table>

		</div>
		<div class="div_class_right">
		    <h1>Transactions</h1>
			<table>
				<tr><td><h2>Purchase a Tank<br></h2></td></tr>
			</table>
			<table>	
		                <tr><td>Tank ID:</td><td><input type="number" id="purchase_tid" name="purchase_tid" value="0"></td></tr>
				<tr><td><input type="submit" name="purchase_tank" value="Submit"></td></tr>
			</table>
			<br>
                        <table>
                                <tr><td><h2>Sell a Tank<br></h2></td></tr>
                        </table>
                        <table>
                                <tr><td>Tank ID:</td><td><input type="number" id="sell_tid" name="sell_tid" value="0"></td></tr>
                                <tr><td><input type="submit" name="sell_tank" value="Submit"></td></tr>
                        </table>
			<br>
                        <table>
                                <tr><td><h2>Purchase an Attachment<br></h2></td></tr>
                        </table>
                        <table>
                                <tr><td>Attachment ID:</td><td><input type="number" id="purchase_aid" name="purchase_aid" value="0"></td></tr>
                                <tr><td><input type="submit" name="purchase_attachment" value="Submit"></td></tr>
                        </table>
			<br>
                        <table>
                                <tr><td><h2>Sell an Attachment<br></h2></td></tr>
                        </table>
                        <table>
                                <tr><td>Attachment ID:</td><td><input type="number" id="sell_aid" name="sell_aid" value="0"></td></tr>
                                <tr><td><input type="submit" name="sell_attachment" value="Submit"></td></tr>
                        </table>
			<br>
                        <table>
                                <tr><td><h2>Repair All Tanks</h2></td<td><input type="submit" name="repair_tanks" value="Submit"></td></tr>
                        </table><table>
         <br>
                                <tr><td><h2>Battle with a Tank<br></h2></td></tr>
                        </table>
                        <table>
                                <tr><td>Tank ID:</td><td><input type="number" id="battle_tid" name="battle_tid" value="0"></td></tr>
                                <tr><td><input type="submit" name="battle" value="Submit"></td></tr>
                        </table>
                        <br>



                </div>
            </form>
        </div>
        <br><br><br>
	<h3><a href = "/index.html">Home Page</a></h3>
</html>


