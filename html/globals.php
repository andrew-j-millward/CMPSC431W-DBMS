<?php
$start_txn = 'START TRANSACTION';
$sql_start_txn = 'START TRANSACTION';

$commit = 'COMMIT';
$rollback = 'ROLLBACK';

class InsufficientFundsException extends Exception{}

class InvalidInputException extends Exception{}

class OwnershipException extends Exception{}
?>
