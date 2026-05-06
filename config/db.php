<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "latres_d";

$connect = new mysqli($hostname, $username, $password, $database);

if($connect->connect_error){
    die("Koneksi gagal : " . $connect->connect_error);
}

session_start();

?>