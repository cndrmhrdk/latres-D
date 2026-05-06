<?php
session_start();

if(!isset($_GET['confirmed'])){
    header("Location: index.php");
    exit;
} else {
    session_unset();
    session_destroy();
    
    header("Location: login.php");
    exit;
}


?>