<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>
<?php include 'head.phtml'; ?> 
<?php include 'header.php'; ?>
<?php include 'orders.phtml'; ?>