<?php session_start();
    if($_SESSION['id']){
        unset($_SESSION['id']);
        header("location: login.php");
    }
?>

