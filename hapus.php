<?php
    require "config/db.php";

    $id_asset = $_GET['id_aset'];

    $sql = "DELETE FROM assets where id_asset = ?";
    $statement = $connect->prepare($sql);
    $statement->bind_param("i", $id_asset);
    $statement->execute();
    $result = $statement->get_result();

    header("Location: index.php");
?>