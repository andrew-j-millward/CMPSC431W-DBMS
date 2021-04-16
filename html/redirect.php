<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'user_info.php';

$host = 'localhost';
$dbname = '431W_project';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Redirecting...</title>
    </head>
    <body>
		<p>
			<?php 
				try {
					if (isset($_POST['check_buying_power_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_user_buying_power.php'</script><?php
					} else if (isset($_POST['check_top_three_button'])) {
					    session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_user_top_10.php'</script><?php
					} else if (isset($_POST['check_attach_subsystem_button'])) {
					    session_start();
						//$_SESSION['uid'] = $_POST['uid'];
						$_SESSION['tid2'] = $_POST['tid2'];
						$_SESSION['sid2'] = $_POST['sid2'];
						?><script>window.location='/functions/get_my_tanks_attachments.php'</script><?php
					} else if (isset($_POST['check_dphp_garage_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/total_hits_and_damage.php'</script><?php
					} else if (isset($_POST['check_user_repair_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_user_repair_tanks.php'</script><?php
					} else if (isset($_POST['check_attach_total_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_user_total_attachments.php'</script><?php
					} else if (isset($_POST['check_country_tanks_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_user_total_tanks_by_country.php'</script><?php
					} else if (isset($_POST['check_tank_origin_button'])) {
						session_start();
						$_SESSION['tid'] = $_POST['tid'];
						?><script>window.location='/functions/get_tank_country.php'</script><?php
					} else if (isset($_POST['check_gross_buying_power_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_gross_buying_power.php'</script><?php
					} else if (isset($_POST['check_tank_attachment_compatibility_button'])) {
						session_start();
						$_SESSION['uid'] = $_POST['uid'];
						?><script>window.location='/functions/get_tank_attachment_compatibility.php'</script><?php
					} else if (isset($_POST['purchase_tank'])) {
                                                session_start();
						$_SESSION["uid"] = $_POST["uid"];
						$_SESSION["purchase_tid"] = $_POST["purchase_tid"];
                                                ?><script>window.location='/transactions/purchase_tank.php'</script><?php
                             		
                                        } else if (isset($_POST['sell_tank'])) {
                                                session_start();
                                                $_SESSION["uid"] = $_POST["uid"];
                                                $_SESSION["sell_tid"] = $_POST["sell_tid"];
                                                ?><script>window.location='/transactions/sell_tank.php'</script><?php


                                        } else if (isset($_POST['purchase_attachment'])) {
                                                session_start();
                                                $_SESSION["uid"] = $_POST["uid"];
                                                $_SESSION["purchase_aid"] = $_POST["purchase_aid"];
                                                ?><script>window.location='/transactions/purchase_attachment.php'</script><?php


                                        } else if (isset($_POST['sell_attachment'])) {
                                                session_start();
                                                $_SESSION["uid"] = $_POST["uid"];
                                                $_SESSION["sell_aid"] = $_POST["sell_aid"];
                                                ?><script>window.location='/transactions/sell_attachment.php'</script><?php

					} else if (isset($_POST['repair_tanks'])){
						session_start();
						$_SESSION["uid"] = $_POST["uid"];
                                                ?><script>window.location='/transactions/repair_all_tanks.php'</script><?php


					}else if (isset($_POST['battle'])) {
                                                session_start();
                                                $_SESSION["uid"] = $_POST["uid"];
                                                $_SESSION["battle_tid"] = $_POST["battle_tid"];
                                                ?><script>window.location='/transactions/battle.php'</script><?php

                                         	
					
					} else if (isset($_POST['get_tanks_button'])) {
						?><script>window.location='/view_data/get_tanks.php'</script><?php
					} else if (isset($_POST['get_system_button'])) {
						?><script>window.location='/view_data/get_systems.php'</script><?php
					} else if (isset($_POST['get_attachments_button'])) {
						?><script>window.location='/view_data/get_attachments.php'</script><?php
					} 
					
					else{
						?><script>window.location='/inventory_management.php'</script><?php
					}
			?>
			<?php
				} catch(Exception $e) {
					echo "Error:" . $e->getMessage();
				}
			?>
		</p>
    </body>
</html>
