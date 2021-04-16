<?php

include '../user_info.php';
include '../globals.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = '431W_project';





?>
<!DOCTYPE html>
<html>
    <head>
        <title>Selling Tank...</title>
    </head>
    <body>	
		<p>
                        <?php
				session_start();
				echo "Selling Tank: " . $_SESSION["sell_tid"] . "...<br>";
                                
                                try {
						$_POST["uid"] = $_SESSION["uid"];
						$_POST["tid"] = $_SESSION["sell_tid"];
						$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 
					 
                                        
                                                // OUTSIDE IN
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                #$conn->exec($sql_start_txn);
						#$conn->exec($commit);

						$conn->exec($start_txn);
						
					        $check_balance = $conn->query('SELECT ubalance FROM users WHERE uid="' . $_POST["uid"] . '"');
						$check_price = $conn->query('SELECT price FROM tanks WHERE tid="' . $_POST["tid"] . '"');
						$check_balance->setFetchMode(PDO::FETCH_ASSOC);
						$check_price->setFetchMode(PDO::FETCH_ASSOC);

						#CHECK VALID IDs
						if ($check_price->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid tank id!');
      						}
      						if ($check_balance->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid user id!');
      					        }
						

						$check_ownership = $conn->query('SELECT * FROM inventory_tanks WHERE uid='. $_POST["uid"] . ' AND tid=' . $_POST["tid"]);

						#Check if user  owns an item
						if ($check_ownership->rowCount() == 0){
						   throw new OwnershipException('ERROR: You do not own this tank!');
						}	

						$bal = $check_balance->fetch()["ubalance"];
						$price = $check_price->fetch()["price"];

						#ADD AND UPDATE
						
						$add_price = 'UPDATE users SET ubalance= '. $bal . '+ (' . $price . '* 0.5) WHERE uid=' . $_POST["uid"];
						
		                                

						
						$update_tanks = 'DELETE FROM inventory_tanks WHERE uid = "' . $_POST["uid"] . '"' . ' AND tid = "' . $_POST["tid"] . '"';	
						$conn->exec($add_price);
						$conn->exec($update_tanks);
						
						#CHECK VALUES 
						$check_new_balance = $conn->query('SELECT ubalance FROM users WHERE uid=' . $_POST["uid"]);
						$check_new_balance->setFetchMode(PDO::FETCH_ASSOC);
						$new_bal = $check_new_balance->fetch()["ubalance"];
						
						if($new_bal != ceil(($bal + ($price * 0.5)))){
							throw new Exception("Exit price does not match");
						}
						
						
						$check_new_attach = $conn->query('SELECT * FROM inventory_tanks WHERE tid=' . $_POST["tid"] . ' AND uid=' . $_POST["uid"]);
						$check_new_attach->setFetchMode(PDO::FETCH_ASSOC);

						if($check_new_attach->rowCount() > 0){
							throw new Exception('Tank was not deleted for unknown reason');
						}
						
						#SUCCESS
						echo "sale successful, committing...";	
						$conn->exec($commit);

                                        ?>
                                      
                                       
                                        
                                         
                                          

                         <?php
                                
				}catch(PDOException $e){
                                        echo "Error logging into SQL: " . $e->getMessage();

                                }catch(InsufficientFundsException $e){
					echo "Insufficient Funds Exception: ". $e->getMessage();
					$conn->exec($rollback);

				}catch(InvalidInputException $e){
					echo "Invalid Input Exception: " . $e->getMessage();
					$conn->exec($rollback);
				
				}catch(OwnershipException $e){
					echo "Ownership Exception: " . $e->getMessage();
					$conn->exec($rollback);
					
				}catch(Exception $e){
                                        echo "Error: " . $e->getMessage();
                                        $conn->exec($rollback);
				
				}
				$conn = null;




			?>

                                        <p>You will be redirected in 10 seconds</p>
                                        <script>
                                                var timer = setTimeout(function() {
                                                        window.location='../inventory_management.php'
                                            }, 10000);
                                        </script>

                </p>
    </body>
</div>


